<!-- Default panel contents -->
<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
  
  <script>
  $(document).ready(function(){
    // Sembunyikan alert validasi kosong
    $("#kosong").hide();
  });
</script>

  <center>
    <div class="panel panel-primary" style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>IMPORT FILE EXCEL DATA ABSENSI</b>
      </div>

  <?php
  if ($pesan != '') {
    ?>
    <br/>
    <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>

  <?php
  if ($status == 1) {
  ?>  
  <div class="row" style="padding:10px;">    
        <div class="col-sm-1 col-md-1"></div>
        <div class="col-sm-5 col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div align='left'>
                <a href="<?php echo base_url("excel/format.xlsx"); ?>" style='color: red;'>DOWNLOAD TEMPLATE FILE ABSENSI</a>
                <br/><small>            
                - Dilarang banar maubah urutan / susunan kolom<br/>
                - Yang dapat di-import hanya data absensi bulan lalu (M-1), kecuali bulan Desember<br/>
                - Yang dapat di-import hanya data absensi PNS pada SKPD sesuai kewenangan anda<br/>
                - NIP kada boleh ada spasi, harus sasuai lawan NIP nang ada pada SILKa Online<br/>
                - Gasan Bulan ditulis dalam angka haja (cuntuh : Januari = 1, Nopember = 11)
              </small>
            </div>
          </div>
        </div>
        </div>

        <div class="col-sm-6 col-md-5">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="caption" align='left'>
                IMPORT FILE ABSENSI              
              <br/><small class='text-danger'>
                CEK BANAR BUJUR-BUJUR DULU SABALUM DI-IMPORT,<br/>
                DATA ABSENSI NANG UDAH DI-IMPORT KADA KAWA DIHAPUS LAGI.
              </small>
              </div>
              <div class="row">
                <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                <!-- <form method="post" action="<?php //echo base_url("index.php/absensi/form"); ?>" enctype="multipart/form-data">-->
                <form method="post" action="<?php echo base_url("index.php/absensi/form"); ?>" enctype="multipart/form-data">
		  <div class="form-group input-group">                
                    <span class="input-group-addon">Pilih File</span>
                    <input class="form-control" type="file" name="file" class="btn btn-sm btn-info" /> 
                    <span class="input-group-addon"></span>
                      <select class="form-control" name="jns" id="jns" required>
                        <option value='0'>- Pilih Jenis-</option>                        
                        <option value='pns' selected>PNS</option>
                        <option value='pppk'>PPPK</option>
                      </select>
                      <span class="input-group-addon"></span>
                    <!-- Buat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import -->
                    <button type="submit" value="Preview" name="preview" class="form-control btn btn-sm btn-success">
                      <span class="glyphicon glyphicon-check" aria-hidden="false"></span>&nbspCek Data
                    </button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
    <div class="col-sm-1 col-md-2"></div>
  </div>
  <?php
  // end if status
  }
  ?> 


  <?php
  if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
    if(isset($upload_error)){ // Jika proses upload gagal
      echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
      die; // stop skrip
    }
    
    // Buat sebuah tag form untuk proses import data ke database
    echo "<form method='post' action='".base_url("index.php/absensi/import")."'>";
    
    // Buat sebuah div untuk alert validasi kosong
    //echo "<div style='color: red;' id='kosong'>
    //      Data tidak lengkap, terdapat <span id='jumlah_kosong'></span> data yang belum diisi.
    //      </div><br/>";
    echo "<div style='color: red;' id='kosong'>Data tidak lengkap atau tidak sesuai ketentuan.</div><br/>";    

    echo "<table class='table table-condensed table-hover' style='width: 70%'> 
    <tr class='info'>
      <td align='center'>No</td>      
      <td align='center'>NIP Nama<br/>Jabatan</td>
      <td align='center' width='90'>Periode</td>
      <td align='center' width='80'>Jumlah<br>Hari Kerja</td>
      <td align='center' width='80'>Hadir</td>
      <td align='center' width='80' class='danger'><b>Total Pengurang</b></td>
      <td align='center' width='80' class='danger'><b>REALISASI</b></td>
      <td align='center' width='80'>Status</td>
    </tr>";
    
    $numrow = 1;
    $kosong = 0;
    
    $no = 1;
    // Lakukan perulangan dari data yang ada di excel
    // $sheet adalah variabel yang dikirim dari controller

    $tglini = date('d');
    $bulanini = date('m');
    $tahunini = date('Y');
	
    //echo $bulanini;

    $jmlvalid = 0;
    $jmlinvalid = 0;

    $jns = $_POST['jns'];

    foreach($sheet as $row){ 
      // Ambil data pada excel sesuai Kolom
      $nip = $row['A']; // Ambil data NIS
      $bulan = $row['B']; // Ambil data nama
      $tahun = $row['C']; // Ambil data jenis kelamin
      $jml_hari = $row['D']; // Ambil data alamat
      $hadir = $row['E'];
      $totpengurang = $row['F'];


      // Cek jika semua data tidak diisi
      if($nip == "" && $bulan == "" && $tahun == "" && $jml_hari == "" && $hadir == "")
      //if($nip == "" && $bulan == "" && $tahun == "" && $jml_hari == "")
        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
      
      
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){
        // Validasi apakah semua data telah diisi
        $nip_td = ( ! empty($nip))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
        //$bulan_td = ($bulan != $bulanini-1)? " style='background: #E07171;'" : ""; // Jika Nama kosong, beri warna merah
        $periode_td = ( ! empty($bulan) OR ! empty($tahun))? "" : " style='background: #E07171;'";
        //$bulan_td = ( ! empty($bulan))? "" : " style='background: #E07171;'";
        //$tahun_td = ( ! empty($tahun))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
        $jml_hari_td = ( ! empty($jml_hari))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
        $hadir_td = ( ! empty($hadir))? "" : " style='background: #E07171;'";

        // cek apakah pns dalam kewenangan user yang login
        if($jns == 'pns') {
          // cek apakah pns dalam kewenangan user yang login
          $cekpns = $this->mpegawai->getnipnama($nip)->result_array();
          $nama = $this->mpegawai->getnama($nip);
          $unker = $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
          $jenis = "PNS";
        } else if($jns == 'pppk') {
          // cek apakah pns dalam kewenangan user yang login
          $cekpns = $this->mpppk->getnipnama($nip)->result_array();
          $nama = $this->mpppk->getnama_lengkap($nip);
          $unker = $this->munker->getnamaunker($this->mpppk->getfidunker($nip));
          $jenis = "PPPK";
        }     
	
	// Jika salah satu data ada yang kosong
	/*
        if (($nip == "" or $bulan == "" or $tahun == "" or $jml_hari == "" or $hadir == "") OR (!$cekpns)) {
          $kosong++; // Tambah 1 variabel $kosong
          $status = "INVALID";
          $jmlinvalid++;
        // mengizinkan VALID, data absensi desember diupload pada bulan januari
        } else {
          $status = "VALID";
          $jmlvalid++;
        }
	*/
	
	
        // Jika salah satu data ada yang kosong
        //if ($nip == "" or $bulan == "" or $tahun == "" or $jml_hari == "" or $hadir == "") {
	if ($nip == "" or $bulan == "" or $tahun == "" or $jml_hari == "") {
          $kosong++; // Tambah 1 variabel $kosong
          $status = "INVALID";
        // mengizinkan VALID, data absensi desember diupload pada bulan januari
        } else if ((($bulan == '12') AND ($bulanini == '1') AND ($tahun == $tahunini-1)) AND ($cekpns)) {
          $status = "VALID";
        // mengizinkan VALID, data absensi desember diupload pada bulan desember
        } else if ((($bulan == '12') AND ($bulanini == '12') AND ($tahun == $tahunini)) AND ($cekpns)) {
          $status = "VALID";
        // hanya mengizinkan data absensi bulan lalu yg diupload
        } else if (($bulan != $bulanini-1) or ($tahun != $tahunini) or (! $cekpns)) {
          $status = "INVALID";
        } else {
          $status = "VALID";
        }        
        
        // tampilkan hanya data bulan kemaren
        if ($status == "VALID") {
          echo "<tr align='center'>";
          $warnastatus = "blue";
        } else {
          echo "<tr align='center' class='danger' style='color: white;'>";
          $warnastatus = "red";
        }

        echo "<td align='center'>".$no."</td>";
        echo "<td align='left'".$nip_td."><small>".$nama." | NIP. ".$nip."</small><br/>";        
        echo $unker."</small></td>";
        echo "<td".$periode_td.">".bulan($bulan)." ".$tahun."</td>";
        echo "<td".$jml_hari_td."><b>".$jml_hari."</b></td>";        
        echo "<td".$hadir_td."><b>".$hadir."</b></td>";

        if ($totpengurang > 100) {
          $realisasi = 0; 
        } else {
          $realisasi = 100-$totpengurang;
        }
        
	if ($totpengurang != 0) {
          echo "<td class='danger' style='color: red'><b>".$totpengurang."</b></td>";
          echo "<td class='danger' style='color: red'><b>".$realisasi."</b></td>";
        } else {
          echo "<td class='danger'><b>".$totpengurang."</b></td>";
          echo "<td class='danger'><b>".$realisasi."</b></td>";
        }  
        echo "<td style='color: ".$warnastatus.";'><b>".$status."</b></td>";
        echo "</tr>";        
        
        $no++;
      }
      $numrow++; // Tambah 1 setiap kali looping
    }
    
    echo "</table>";
    
    // Cek apakah variabel kosong lebih dari 0
    // Jika lebih dari 0, berarti ada data yang masih kosong
    if(($kosong > 0) OR ($status == "INVALID")) {
    ?>  
      <script>
      $(document).ready(function(){
        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
        $("#jumlah_kosong").html('<?php echo $kosong; ?>');
        
        $("#kosong").show(); // Munculkan alert validasi kosong
      });
      </script>
    <?php
    } else { // Jika semua data sudah diisi
      // Buat sebuah tombol untuk mengimport data ke database
      echo "<input type='hidden' name='jns' size='3' value='".$jns."'>";      
      echo "<button type='submit' name='import' class='btn btn btn-success'>
            <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspImport
            </button>";
      //echo "<button type='submit' name='import'>Import</button>";
    }
    
    echo "</form>";
  }
  ?>

</center>
