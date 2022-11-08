  <!-- Default panel contents -->
  <script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
    
  <script>
    $(document).ready(function(){
      // Sembunyikan alert validasi kosong
      $("#kosong").hide();
    });
  </script>
  <center>
    <div class="panel panel-default" style="width:99%;height:650px;border:0px solid white">
    <div class="panel-body">
      <div class="panel panel-primary" style="padding:3px;overflow:auto;width:98%;height:620px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
          <b>IMPORT FILE EXCEL DATA HASIL PERHITUNGAN TPP MANUAL</b>
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
    $hari_ini = date('d');
    if ((($hari_ini > 5) AND ($status == 1)) OR ($this->session->userdata('nip') == "198104072009041002")) {
    ?>
    <div class="row" style="padding:10px;">
          <div class="col-sm-5 col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
		<div class="caption" align='left'>
                  <b><span class='text text-primary'>1. DOWNLOAD TEMPLATE</span></b>
                </div>
                <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                <form method="post" action="<?php echo base_url("index.php/Kinerja/export_tppmanual"); ?>" enctype="multipart/form-data">
                  <div class="form-group input-group">
                    <select name="id_unker" class="form-control" id="id_unker" required>
                    <?php
                        echo "<option value='0'>- Pilih Unit Kerja -</option>";
                        foreach($unker as $uk)
                        {
                          echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
                        }
			var_dump($unker);
                        foreach($unsekolah as $us):
                            echo "<option value=".$us['id_kecamatan'].">SEKOLAH KEC. ".$us['nama_kecamatan']."</option>";
                        endforeach;
                    ?>
                    </select>
                    <span class="input-group-addon"></span>
                    <select class="form-control" name="jns" id="jns" required>
                      <option value='0'>Jenis</option>
                      <option value='pns' selected>PNS</option>
                      <option value='pppk'>PPPK</option>
                    </select>
                    <span class="input-group-addon"></span>
                    <button type="submit" value="Preview" name="preview" class="form-control btn btn-sm btn-info">
                      <span class="fa fa-arrow-down" aria-hidden="false"></span>&nbspGet Data
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="caption" align='left'>
                  <b><span class='text text-primary'>2. IMPORT FILE PERHITUNGAN TPP MANUAL</span></b>
                </div>
                  <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                  <!-- <form method="post" action="<?php //echo base_url("index.php/absensi/form"); ?>" enctype="multipart/form-data">-->
                  <form method="post" action="<?php echo base_url("index.php/Kinerja/formupload"); ?>" enctype="multipart/form-data">
                      <!-- Buat sebuah input type file -->
                    <div class="form-group input-group">
                      <span class="input-group-addon">Pilih File</span>
                      <input class="form-control" type="file" name="file" class="btn btn-sm btn-info" />
                      <span class="input-group-addon"></span>
                        <select class="form-control" name="jns" id="jns" required>
                          <option value='0'>Jenis</option>
                          <option value='pns' selected>PNS</option>
                          <option value='pppk'>PPPK</option>
                        </select>
                        <span class="input-group-addon"></span>
                      <!-- Buat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import -->
                      <button type="submit" value="Preview" name="preview" class="form-control btn btn-sm btn-success">
                        <span class="fa fa-check" aria-hidden="false"></span>&nbspCek Data
                      </button>
                    </div>
                  </form>
              </div>
            </div>
          </div>
    </div>
    <?php
    } else {
	?>
    	<br/>
    	<div class="alert alert-success" role="alert">
      	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<b>INFORMASI ::: </b>Perhitungan TPP  hanya dapat dilakukan setelah tanggal 5 setiap bulan
    	</div> 
    	<?php
    }
    ?>
   
    <?php
    if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
      if(isset($upload_error)){ // Jika proses upload gagal
        echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
        die; // stop skrip
      }
      $jns = $_POST['jns'];
      // Buat sebuah tag form untuk proses import data ke database
      if ($jns == 'pns') {
        echo "<form method='post' action='".base_url("index.php/Kinerja/import_hitungmanual")."'>";
      } else if($jns == 'pppk') {
        echo "<form method='post' action='".base_url("index.php/Kinerja_pppk/import_hitungmanual")."'>";
      }
      // Buat sebuah div untuk alert validasi kosong
      echo "<br/><div style='color: red;' id='kosong'>DATA TIDAK LENGKAP ATAU TIDAK SESUAI KETENTUAN.<br/>";
      echo "<span class='text text-info'>Periksa kembali file template, atau kemungkinan sudah terdapat perhitungan TPP yang sudah Approve sebelumnya.</span></div></br>";
    
      echo "
          <table class='table table-bordered table-hover' style='width: 99%'>
          <tr class='info'>
            <td align='center'>No</td>";
      if ($jns == 'pns') {
        $lbnip = "NIP";
      } else if ($jns == 'pppk') {
        $lbnip = "NIPPPK";
      }
      echo "<td align='left'>".$lbnip." | Nama<br/>Jabatan</td>
        <td align='left' width='90'>Periode</td>
        <td align='right' width='110'>TPP Basic<br/>(Sesuai Perbup)</td>
        <td align='right' width='120'>Kinerja</td>
        <td align='right' width='100'>Absensi</td>
        <td align='right' width='100'>TPP Bruto</td>
        <td align='right' width='120'>PPh 21</td>
        <td align='right' width='100'>TPP Netto<br/>IWP 1%</td>
        <td align='center'>Info</td>
      </tr>";
      $numrow = 1;
      $kosong = 0;
      
      $no = 1;
      // Lakukan perulangan dari data yang ada di excel
      // $sheet adalah variabel yang dikirim dari controller
      $tglini = date('d');
      $bulanini = date('m');
      $tahunini = date('Y');
      //echo $tahunini;
      $jmlvalid = 0;
      $jmlinvalid = 0;
      
      foreach($sheet as $row) {
        // Ambil data pada excel sesuai Kolom
        $idunker = $row['A']; // Ambil data NIP
        $nip = $row['B']; // Ambil data NIP
        $jabatan = $row['E'];
        $tahun = $row['F']; // Ambil data tahun
        $bulan = $row['G']; // Ambil data jml hari
        $kelas = $row['H'];
        $basic = $row['I'];
	$indikator = $row['J'];
        $plt = strtoupper($row['K']);
        $tam_plt = $row['L'];
        $mk7h = strtoupper($row['M']);
        $ctk1b = strtoupper($row['N']);
        $ket = $row['O'];

	if ($jns == 'pns') {
        	$status = $this->mkinerja->getstatuspengantar($idunker, $tahun, $bulan);
      	} else  if ($jns == 'pppk') {
        	$status = $this->mkinerja_pppk->getstatuspengantar_pppk($idunker, $tahun, $bulan);
      	}	

        // Cek jika semua data tidak diisi
        //if($nip == "" && $bulan == "" && $tahun == "" && $kelas == "" && $basic == "" && $nilai_skp == "" && $tpp_kin == "" && $nilai_abs == "" && $tpp_abs == "")
        //continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
        
        // Cek $numrow apakah lebih dari 1
        // Artinya karena baris pertama adalah nama-nama kolom
        // Jadi dilewat saja, tidak usah diimport
        if($numrow > 1){
          // Validasi apakah semua data telah diisi
          $nip_td = ( ! empty($nip))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
          $periode_td = ( ! empty($bulan) OR ! empty($tahun))? "" : " style='backgroud: #E07171;'";
          $kelas_td = ( ! empty($kelas))? "" : " style='background: #E07171;'";
          $basic_td = ( ! empty($basic))? "" : " style='background: #E07171;'";
          $plt_td = ( ! empty($plt))? "" : " style='background: #E07171;'";
          $mk7h_td = ( ! empty($mk7h))? "" : " style='background: #E07171;'";
          $ctk1b_td = ( ! empty($ctk1b))? "" : " style='background: #E07171;'";
         
          if($jns == 'pns') {
            // cek apakah pns dalam kewenangan user yang login
            $berhaktpp = $this->mkinerja->get_haktpp($nip);
            $cekpns = $this->mpegawai->getnipnama($nip)->result_array();
	    $telahusul = $this->mkinerja->cektelahusul($nip, $tahun, $bulan);
            $nama = $this->mpegawai->getnama($nip);
            $unker = $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
	    $gaji = $this->mkinerja->cekadagaji($nip, $tahun, $bulan);
            $jenis = "PNS";
          } else if($jns == 'pppk') {
            // cek apakah pns dalam kewenangan user yang login
            $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
            $cekpns = $this->mpppk->getnipnama($nip)->result_array();
            $telahusul = $this->mkinerja_pppk->cektelahusul($nip, $tahun, $bulan);
            $nama = $this->mpppk->getnama($nip);
            $unker = $this->munker->getnamaunker($this->mpppk->getfidunker($nip));
	    $gaji = $this->mkinerja_pppk->cekadagaji($nip, $tahun, $bulan);
            $jenis = "PPPK";
          }       

          // Jika salah satu data ada yang kosong
	  // Telah usul == 1, berarti sudah ada usulan yang masuk 
          //if ($idunker == "" or $idunker == "0" or $nip == "" or $bulan == "" or $tahun == "" or $kelas == "" or $basic == "" or $berhaktpp == "TIDAK" 
	  //	or (($status == 'REKAP' or $status == 'CETAK') and $telahusul == "1")) {
	  if ($telahusul == "1") {
            $kosong++; // Tambah 1 variabel $kosong
            $status = "TELAH USUL";
            $jmlinvalid++;
          } else if ($idunker == "" or $idunker == "0" or $nip == "" or $bulan == "" or $tahun == "" or $kelas == "" or $basic == "" or $berhaktpp == "TIDAK"
                or ($telahusul == "1")) {
            $kosong++; // Tambah 1 variabel $kosong
            $status = "DATA TIDAK LENGKAP";
            $jmlinvalid++;
          // mengizinkan VALID, data absensi desember diupload pada bulan januari
          } else if ((($bulan == '12') AND ($bulanini == '1') AND ($tahun == $tahunini-1)) AND ($cekpns)) {
            $status = "VALID";
            $jmlvalid++;
          // mengizinkan VALID, data absensi desember diupload pada bulan desember
          } else if ((($bulan == '12') AND ($bulanini == '12') AND ($tahun == $tahunini)) AND ($cekpns)) {
            $status = "VALID";
            $jmlvalid++;
          // hanya mengizinkan data absensi bulan lalu yg diupload, paling lambat tanggal 4
          } else if (($bulan != $bulanini-1) or ($tahun != $tahunini) or ($tglini >= '30') or (! $cekpns)) {
	  //} else if (($bulan <= $bulanini-1) or ($tahun != $tahunini) or (! $cekpns)) {
            $status = "INVALID";
            $jmlinvalid++;
          } else if ($gaji == 0) {
	    $status = "DATA GAJI TIDAK ADA";
            $jmlinvalid++;	
	  } else {
            $status = "VALID";
            $jmlvalid++;
          }

          // tampilkan hanya data bulan kemaren
          if ($status == "VALID") {
            echo "<tr align='center'>";
            $warnastatus = "blue";
          } else {
            echo "<tr align='center' class='danger' style='color: black;'>";
            $warnastatus = "red";
          }
          echo "<td align='center'>".$no."</td>";
          echo "<td align='left'".$nip_td."><small>".$nama." | NIP. ".$nip."</small><br/>";
          echo "<small>".$jabatan."<br/>".$unker."</small></td>";
          echo "<td".$periode_td." align='left'><small>".bulan($bulan)." ".$tahun."<br/>";
          if ($plt == 'YA') {
            if ($tam_plt == 0) {
              echo " <span class='label label-info'>PLT</span>";
            } else {
              echo " <span class='label label-info'>PLT. 20%</span>";
            }
          }
          $statuspeg = $this->mpegawai->getstatpeg($nip);
          if ($statuspeg == "CPNS") {
            echo " <span class='label label-warning'>CPNS</span>";
	    $basic = $basic * 0.8;
	    $ketcpns = "<code>80 %</code>";
          } else {
	    $ketcpns = "";
	  }

          echo "</small></td>";
          echo "<td".$kelas_td." ".$basic_td." align='left'>";
          echo "<div><small>Kelas</small><span class='pull-right text-muted'>".$kelas."<span></div>";
          echo "<small>".$ketcpns."</small><span class='pull-right text-muted'><small>Rp. ".number_format($basic,0,",",".")."</small><span>";
          echo "</td>";
          
        // Indikator Kinerja
          if ($jns == 'pns') {
            $jnsjab = $this->mkinerja->get_jnsjab($nip);
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            $nilai_skp = $this->mkinerja->get_realisasikinerja($nip, $tahun, $bulan);
          } else if ($jns == 'pppk') {
            $jnsjab = "FUNGSIONAL TERTENTU";
	    $keltugasjft = $this->mpppk->getkeltugas_jft_nipppk($nip);
            $nilai_skp = $this->mkinerja_pppk->get_realisasikinerja($nip, $tahun, $bulan);
          }

	  if ($ctk1b == 'YA') {
             echo "<td align='center' class='info'><small class='text text-muted'>CUTI / TK 1 BULAN</small></td>";
             $nilaiskp60p = 0;
             $tpp_kin = 0; 
	  } else if ($ctk1b == 'TIDAK') {
	    //if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH")) {
            //if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH") OR (($keltugasjft == "KESEHATAN") AND ($plt == "YA"))) {
	    if ($indikator == "AK") {
	    if ($nilai_skp >= 90) {
              $nilai_skp_pengali = 100;
              $kat_skp = "<span class='label label-primary'>SANGAT BAIK</span>";
            } else if (($nilai_skp >= 76) AND ($nilai_skp < 90)) {
              $nilai_skp_pengali = 90;
              $kat_skp = "<span class='label label-success'>BAIK</span>";
            } else if (($nilai_skp >= 61) AND ($nilai_skp < 76)) {
              $nilai_skp_pengali = 80;
              $kat_skp = "<span class='label label-warning'>CUKUP</span>";
            } else if (($nilai_skp >= 51) AND ($nilai_skp < 61)) {
              $nilai_skp_pengali = 70;
              $kat_skp = "<span class='label label-danger'>KURANG</span>";
            } else if (($nilai_skp >= 10) AND ($nilai_skp < 51)) {
              $nilai_skp_pengali = 40;
              $kat_skp = "<span class='label label-danger'>BURUK</span>";
            } else {
              $nilai_skp_pengali = 0;
              $kat_skp = "<span class='label label-danger'>DATA KINERJA TIDAK ADA</span>";
            }
            
    	    $nilaiskp60p = 0.6*$nilai_skp_pengali;
            //$tpp_kin = ($basic*round($nilaiskp60p,2))/100;
	    $tpp_kin = ($basic*$nilaiskp60p)/100;
	    $tpp_kin = pembulatan_satuan((int)$tpp_kin);
    	
	    if ($mk7h == "YA") {
           	$tpp_kin = $tpp_kin * 0.4; // Jika masuk kerja kurang dari 7 hari maka TPP Kinerja 40%
            }	
	
            //if ($ctk1b == "YA") {
            //	$tpp_kin = 0; // Jika masuk kerja kurang dari 7 hari maka TPP Kinerja 40%
            //}

            echo "<td align='left'>";
            echo "<div><small>Nilai SKP</small><span class='pull-right text-muted'><small>".round($nilai_skp,2)."</small><span></div>";
            echo "<small>".$kat_skp."</small>";
            if ($mk7h == "YA") {
              echo "<small><span class='label label-danger'>40 %</span></small>";
            }
            if ($ctk1b == "YA") {
              echo "<small><span class='label label-danger'>CUTI 1 BULAN ".$tpp_kin."</span></small>";
            }
            echo "<span class='pull-right text-muted'><small>Rp. ".number_format($tpp_kin,0,",",".")."</small><span></div>";
            echo "</td>";
          //} else if (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN")) {
          //} else if ((($keltugasjft == "KESEHATAN") AND ($plt == "TIDAK")) OR ($keltugasjft == "PENDIDIKAN")) {
	  } else if ($indikator == "A") {
	    $tpp_kin = 0;
            echo "<td align='center' class='warning'><small class='text text-muted'>Tidak Wajib eKinerja</small></td>";
          } 
	 }
         // End Indikator Kinerja

          // Indikator Absensi
          if ($jns == 'pns') {
            $jnsjab = $this->mkinerja->get_jnsjab($nip);
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            $nilai_abs = $this->mkinerja->get_realisasiabsensi($nip, $tahun, $bulan);
          } else if ($jns == 'pppk') {
            $jnsjab = "FUNGSIONAL TERTENTU";
            $keltugasjft = $this->mpppk->getkeltugas_jft_nipppk($nip);
            $nilai_abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $tahun, $bulan);
          }

	  if ($indikator == "AK") {
          //if (($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH") OR (($keltugasjft == "KESEHATAN") AND ($plt == "YA"))) {
            $nilaiabsensi40p = 0.4*$nilai_abs;
            $tpp_abs = ($basic*round($nilaiabsensi40p,2))/100;
	    $tpp_abs = pembulatan_satuan((int)$tpp_abs);
            //$tpp_abs = pembulatan(round($tpp_abs,0));
            echo "<td align='left'>";
            echo "<div><small>Nilai</small><span class='pull-right text-muted'><small>".round($nilai_abs,2)."</small><span></div>";
            echo "<span class='pull-right text-muted'><small>Rp. ".number_format($tpp_abs,0,",",".")."</small><span>";
            echo "</td>";
	  } else if ($indikator == "A") {
          //} else if ((($keltugasjft == "KESEHATAN") AND ($plt == "TIDAK")) OR ($keltugasjft == "PENDIDIKAN")) {
            $tpp_abs = ($basic*round($nilai_abs,2))/100;
	    $tpp_abs = pembulatan_satuan((int)$tpp_abs);
            //$tpp_abs = pembulatan(round($tpp_abs,0));
            echo "<td align='left'>";
            echo "<div><small>Nilai</small><span class='pull-right text-muted'><small>".round($nilai_abs,2)."</small><span></div>";
            echo "<span class='pull-right text-muted'><small>Rp. ".number_format($tpp_abs,0,",",".")."</small><span>";
            echo "</td>";
          }
          // End Indikator Absensi

	  //var_dump($jns);
          //$tpp_bruto = $tpp_kin + $tpp_abs;
	  $tpp_bruto = pembulatan_satuan($tpp_kin) + pembulatan_satuan($tpp_abs);
          echo "<td align='right'><small>".number_format($tpp_bruto,0,",",".")."<br/>";
          if ($plt == 'YA')  {
            if ($tam_plt != 0) {
              echo "+ ".number_format($tam_plt,0,",",".");
              $tpp_bruto = $tpp_bruto + $tam_plt;
              echo "<br/>= ".number_format($tpp_bruto,0,",",".");
            }
          }
          echo "</small></td>";
          // PPh 21
          if ($jns == 'pns') {
	    $spesialis = $this->mkinerja->cekspesialis($nip);
	    if ($spesialis == true) {
		$idgolru = $this->mpegawai->getidgolruterakhir($nip);
		if (($idgolru == "45") OR ($idgolru == "44") OR ($idgolru == "43") OR ($idgolru == "42") OR ($idgolru == "41")) {
              		$pph = $tpp_bruto * 0.15;
            	} else if (($idgolru == "34") OR ($idgolru == "33") OR ($idgolru == "32") OR ($idgolru == "31")) {
              		$pph = $tpp_bruto * 0.05;
            	} 
	    } else {
            	$pph = hitungpph($nip, $jns, $tahun, $bulan, $tpp_bruto);
	    }
            $jnsptkp = $this->mkinerja->get_jnsptkp($nip);
            $npwp = $this->mkinerja->get_npwp($nip);
            $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $tahun, $bulan);
          } else if ($jns == 'pppk') {
            $pph = hitungpph($nip, $jns, $tahun, $bulan, $tpp_bruto);
            $jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
            $npwp = $this->mkinerja_pppk->get_npwp($nip);
            $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $tahun, $bulan);
          }

	  $pph = pembulatan_satuan($pph);
          
          if ($npwp == '') {
            $ketnpwp = "<s>NPWP</s>";
          } else {
            $ketnpwp = "NPWP";
          }       
          // End PPh 21

          echo "<td align='left'>";
          echo "<div><small>PPh 21</small><span class='pull-right text-muted'><small>(".number_format($pph,0,",",".").")</small>
          		 <span></div><code><small>".$ketnpwp."</code> <code>".$jnsptkp."</small></code>";
          echo "</td>";
	  
          //if ($statuspeg == "CPNS") {
	  //  $tpp_bruto = $tpp_bruto * 0.8; // TPP bruto 80%
          //  $tpp_netto = $tpp_bruto - $pph - $iwp_terhutang;
          //} else {
          $tpp_netto = $tpp_bruto - $pph;
          //}

 	  // IWP
          $iwp_tpp = $tpp_netto*0.01; // IWP TPP 1% dari TPP bruto
          $iwp_total = $iwp_gaji + $iwp_tpp;
          if ($iwp_total > 120000) {
            $iwp_terhutang = round(120000-$iwp_gaji);
          } else {
            $iwp_terhutang = round($iwp_tpp);
          }

 	  $iwp_terhutang = pembulatan_satuan($iwp_terhutang);
          // END IWP
          
	  $thp = $tpp_netto - $iwp_terhutang;
	  
          echo "<td align='left'>
		<div><small>Netto</small><span class='pull-right text-muted'><small>".number_format($tpp_netto,0,",",".")."</small></span></div>";
          echo "<div><small>IWP 1%</small><span class='pull-right text-muted'><small>(".number_format($iwp_terhutang,0,",",".").")</small></span></div>";
	  echo "<div><b><small>THP</small><span class='pull-right text-primary'><small>".number_format($thp,0,",",".")."</small></span></b></div>";
	  echo "</td>";

	  if ($ket != '') {
            echo "<td align='center' width='50'>
                  <button type='button' class='btn btn-warning btn-xs' data-toggle='modal' data-target='#keterangan".$nip."'>
                  <span class='fa fa-2x fa-info-circle' aria-hidden='true'></span>
                  </button><br/><span class='label label-info'><small>$status</small></span>
            </td>";
          } else {
            echo "<td><span class='label label-default'><small>$status</small></span></td>";
          }
          
          ?>
          <div id="keterangan<?php echo $nip;?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-body" align="left">
                <?php
                  echo "<h5 class='text text-muted'>".$nama."</h5>";
                  echo $ket;
                ?>
                </div>
              </div>
            </div>
          </div>
          <?php
          
          $no++;
        } // end IF Cek jika semua data tidak diisi
        $numrow++; // Tambah 1 setiap kali looping
        
      } // end foreach
      echo "</table>";
      
      echo "<div class='row'>";
      echo "<div class='col-md-6'></div>";
      echo "<div class='col-md-2' align='right'>";
        echo "<h4><span class='label label-info'>Jumlah data Valid : ".$jmlvalid."</span></h4>";
      echo "</div><div class='col-md-2' align='center'>";
        echo "<h4><span class='label label-warning'>Jumlah data Invalid : ".$jmlinvalid."</span></h4>";
      echo "</div>
            <div class='col-md-2' align='left'>";
      // Cek apakah variabel kosong lebih dari 0
      // Jika lebih dari 0, berarti ada data yang masih kosong
      if(($kosong > 0) OR ($jmlinvalid > 0)) {
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
        echo "<button type='submit' name='import' class='btn btn-sm btn-success'>
              <span class='glyphicon glyphicon-save' aria-hidden='false'></span>&nbspSimpan Data
              </button>";
        //echo "<button type='submit' name='import'>Import</button>";
      }
      
      echo "</div>";
      echo "</div>";
      echo "</form>";
    }
    ?>
  <?php
  function hitungpph($nip, $jns, $thn, $bln, $tppbruto) {
    // PPh 21
    $mpeg = new mpegawai();
    $mpeg_pppk = new mpppk();
    $mkin = new mkinerja();
    $mkin_pppk = new mkinerja_pppk();
    
    if ($jns == 'pns') {
      $gajibruto = $mkin->mkinerja->get_gajibruto($nip, $thn, $bln);
      $jnsptkp = $mkin->mkinerja->get_jnsptkp($nip);
      $npwp = $mkin->mkinerja->get_npwp($nip);
      $jmlpot = $mkin->mkinerja->get_jmlpotongan($nip, $thn, $bln);
      //$jnskel =  $mpeg->mpegawai->getjnskel($nip);
      if (($jnsptkp == '') OR ($jnsptkp == null)) {
        // jika data ptkp kosong, maka dihitung TK/0
        $jnsptkp = 'TK/0';
        $ptkp = $mkin->mkinerja->get_ptkp($jnsptkp);
      } else {
        $ptkp = $mkin->mkinerja->get_ptkp($jnsptkp);
      }
    } else if ($jns == 'pppk') {
      $gajibruto = $mkin_pppk->mkinerja_pppk->get_gajibruto($nip, $thn, $bln);
      $jnsptkp = $mkin_pppk->mkinerja_pppk->get_jnsptkp($nip);
      $npwp = $mkin_pppk->mkinerja_pppk->get_npwp($nip);
      $jmlpot = $mkin_pppk->mkinerja_pppk->get_jmlpotongan($nip, $thn, $bln);
      //$jnskel =  $mpeg_pppk->mpppk->getjnskel($nip);
      if (($jnsptkp == '') OR ($jnsptkp == null)) {
        // jika data ptkp kosong, maka dihitung TK/0
        $jnsptkp = 'TK/0';
        $ptkp = $mkin_pppk->mkinerja_pppk->get_ptkp($jnsptkp);
      } else {
        $ptkp = $mkin_pppk->mkinerja_pppk->get_ptkp($jnsptkp);
      }
    }

    //var_dump($gajibruto);    
    $hasilbruto = $gajibruto + $tppbruto;
    // Biaya jabatan 5% maksimal 500ribu
    $biayajab = $hasilbruto * 0.05;
    if ($biayajab > 500000) {
      $biayajab = 500000;
    }
    $hasilnetto = $hasilbruto-($jmlpot + round($biayajab));
    $hasilnetto_tahun = $hasilnetto*12;
    $pkp = $hasilnetto_tahun - $ptkp;
    $pkp_b = pembulatan_ribuan(round($pkp));
    $pph = 0;
    if (($pkp_b >= 1) AND ($pkp_b <= 60000000)) {
      $pph = $pkp_b*0.05;
    } else if (($pkp_b > 60000000) AND ($pkp_b <= 250000000)) {
      $pph = $pph + 2500000 + (($pkp_b - 50000000) * 0.15);
    } else if (($pkp_b > 250000000) AND ($pkp_b <= 500000000)) {
      $pph = $pph + 32500000 + (($pkp_b-250000000) * 0.25);
    } else if ($pkp_b > 500000000) {
      $pph = $pph + 95000000 + (($pkp_b-500000000) * 0.30);
    }
    $pph_perbulan = $pph / 12;
    if ($npwp == '') {
      // jika NPWP tidak ada, maka PPh jadi 120%
      $pph_perbulan = $pph_perbulan * 1.2;
    }
    $pphgaji = $mkin->mkinerja->get_pphgaji($nip, $thn, $bln);
    $pph_disetor = $pph_perbulan - $pphgaji;    
    return round($pph_disetor);
  }
  ?>
    </div>
    </div>
  </center>
