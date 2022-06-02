<!-- Default panel contents -->
<?php
if (($nmunker == '') OR ($thn == 0) OR ($bln == 0)) { 
//echo $nmunker." / ".$thn." ".$bln;    
?>
    <center>
    <div class="panel panel-default" style="width: 50%">
        <div class="panel-body">
           <div class="alert alert-danger alert-dismissible" role="alert">              
              <b>ERROR...</b><br />Silahkan pilih unit kerja, tahun dan bulan terlebih dahulu
            </div>  
          <form method="POST" action="../kinerja/tampilunkernom">
          <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
        </div>
        </div>
    </center>
  <?php
} else {
?>
  <center>
  <div class="panel panel-default" style="width: 90%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <?php
      //cek priviledge session user -- cetak_nominatif_priv
      if (($this->session->userdata('level') == "ADMIN") AND ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "ENTRI")) { 
      ?>      
        <td align='right'>
          <form method="POST" action="../kinerja/tambahusulpns">                
            <input type='hidden' name='idunker' id='idunker' maxlength='18' value='<?php echo $idunker; ?>'>
            <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
            <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
            <button type="submit" class="btn btn-info btn-sm">
              <span class="fa fa-plus" aria-hidden="true"></span> Tambah Manual
            </button>
          </form>
        </td>
      <?php
      }
      ?>
      <td align='right' width='50'>
        <form method="POST" action="../kinerja/cariusul">
          <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 

<?php
  if ($pesan != '') {
        ?>
        <div class="<?php echo $jnspesan; ?>" alert-info role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
        <?php
      }
  ?>

  <div class="panel panel-info">  
    <div class="panel-heading" align="left">
  <b>NOMINATIF TPP ASN ::: <?php echo $nmunker; ?></b>
  <br />
  PERIODE : <?php echo strtoupper(bulan($bln))." ".$thn;?>
  <?php 
  echo "(JUMLAH PNS : ".$jmlpeg.")";
  ?>
  </div>
  <div style="padding:3px;overflow:auto;width:98%;height:400px;border:1px solid white" >
 
  <table class="table table-bordered table-hover"  style="font-size: 11px;">
      <thead>
      <tr class='success'>
        <td align='center' width='30'><b>No</b></td>
        <td align='center' width='350'><b>IDENTITAS</b></td>
        <td align='center' width='150'><b>KETERANGAN</td>
        <td align='center' width='150'><b>KINERJA<br/>(60%)</b></td>
        <td align='center' width='150'><b>ABSENSI<br/>(40%)</b></td>
        <td align='center' width='140'><b>TAMBAHAN</b></td>
        <td align='center' width='140'><b>KALKULASI<br/>PPh 21 & IWP</b></td>
        <td align='center' width='140'><b>KALKULASI<br/>TAKE HOME PAY</b></td>
	<?php
        if (($this->session->userdata('level') == "ADMIN") AND ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "ENTRI")) {
          echo "<td align='center' width='80'><b>AKSI</b></td>";
        }
        ?>	
      </tr>     
      </thead>      
      <tbody>
      <?php 

      $skplebih100 = 0;
      $skpkurang50 = 0;
      $salahjab = 0;
      $nilaiskp100k = 0;   
      $jmldata = 0;
      $no = 1; 
      
      foreach($usul_tpp as $v):
        $nilaiskp = $v['nilai_kinerja']; // hasil adalah array response dari api pada server sebelah

        if (($nilaiskp != 0) || ($nilaiskp != null)) {
          $nip = $v['nip'];
          echo "<tr>";
          echo "<td align='center'>".$no."</td>";

          $pangkat = $this->mpegawai->getnamapangkat($v['fid_golru']);
          $golru = $this->mpegawai->getnamagolru($v['fid_golru']);
          $tingpen = $this->mpegawai->gettingpen($v['fid_tingpen']);

          //echo "<td>NIP. ".$nip."<br/>".$this->mpegawai->getnama($nip)."<br/>".$pangkat." (".$golru.")";
	  $nama = $this->mpegawai->getnama($nip);
          if ($nama) {
            echo "<td><b>NIP. ".$nip."<br/>".$nama."</b><br/><small>".$pangkat." (".$golru.")</small>";
          } else {
            echo "<td>NIP. ".$nip."<br/>".$this->mkinerja->get_namapensiun($nip)." <span class='label label-success'>PENSIUNAN</span>";
          }

          //$jabkinerja = strtoupper($v['jabatan']);

          $jnsjab = $this->mkinerja->get_jnsjab($nip);
          if ($jnsjab == "STRUKTURAL") {
            $kelasjabatan = $this->mkinerja->get_kelasjabstruk($nip);
            $hargajabatan = $this->mkinerja->get_hargajabstruk($nip);
            $jnsjab = "<span class='label label-danger'>Struk</span>";
            $tingpen = "<span class='label label-primary'>".$tingpen."</span>";
          } else if ($jnsjab == "FUNGSIONAL UMUM") {
            $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
            $hargajabatan = $this->mkinerja->get_hargajabfu($nip);
            $jnsjab = "<span class='label label-success'>JFU</span>";
            $tingpen = "<span class='label label-primary'>".$tingpen."</span>";
            //$atasan = $this->mpegawai->getnamajab($id);
          } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
            $kelasjabatan = $this->mkinerja->get_kelasjabft($nip);
            $hargajabatan = $this->mkinerja->get_hargajabft($nip);
            $jnsjab = "<span class='label label-warning'>JFT</span>";
            $tingpen = "<span class='label label-primary'>".$tingpen."</span>";
          }
          //$jabsilka = $this->mpegawai->namajabnip($nip);

          
          // Jika ada error di idjab, jnsjab, namajab ada model Mpegawai, periksa nip pada ekinerja (mungkin ada spasi)

          //if (strpos($jabkinerja, $jabsilka) === false) { // jika nama jabatan tidak sama (tanda sama dengan harus tiga kali ===)
          //if (strcmp($jabkinerja, $jabsilka) == 1) { // membandingkan ASCII nama jabatan pada ekinerja dgn silka
          //  echo "<td align='center'><span style='font-size: 2em; color: Tomato;'><i class='fa fa-times'></i></span></td>";  
          //  $salahjab++;
          //} else {
          //  echo "<td align='center'><span style='font-size: 2em; color: Limegreen;'><i class='fa fa-check'></i></span></td>";
          //}

          //echo "<td>".$jabkinerja."<br/><u>".$jabsilka."</u><br/>";
          //echo "<br/>".$jabsilka;       
	  echo "<br/>".$v['jabatan']; 

          //echo " (".$kelasjabatan." : ".$hargajabatan.")<br/>";
          
          // KETENTUAN BARU
          // untuk PLT, kinerja dihitung berdasarkan kelas dan harga jabatan PLT nya
          // sehingga tidak ada penambahan untuk PLT        
          // dan ybs tidak dalam kondisi sedang cuti besar atau cuti sakit
          //$cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
          
	  //cek PLT dari tabel usul_tpp
	  $cekplt = $this->mkinerja->cek_plt($nip, $bln, $thn);
	  //if (($cekplt == true) AND ($v['cuti_sakit'] == "TIDAK") AND ($v['cuti_besar'] == "TIDAK")) {
          if (($cekplt == "YA") AND ($v['cuti_sakit'] == "TIDAK") AND ($v['cuti_besar'] == "TIDAK")) {
	    $dataplt = $this->mkinerja->get_dataplt($nip); 
            echo "<br/><i class='fa fa-check'></i><small class=text-primary><abbr title='".$dataplt."'> PLT. ".$dataplt."</abbr></small>";
          }
                    
          $cekbendahara = $this->mkinerja->cek_sdgbendahara($nip, $bln, $thn);
          if ($cekbendahara == true) {
            $databendahara = $this->mkinerja->get_databendahara($nip);
            echo "<br/><i class='fa fa-check'></i><small class=text-primary>".$databendahara."</abbr></small>";
          }

	  $nmunker = $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
	  //$nmunker = $this->munker->getnamaunker($this->mpegawai->getfidunker($v['fid_unker']));
          echo "<br/>".$nmunker;
          echo "<br/>".$jnsjab." ".$tingpen; 

          echo "</td>";

          $pengali = $v['pengali'];               
          //$totaltukin = $v['harga_jab']*$hargasatuan; 

          echo "<td>";
          // PLT. hanya diperbolehkan jika ybs dalam keadaan tidak sedang cuti sakit atau cuti besar
          //if (($cekplt == true) AND ($v['cuti_sakit'] == "TIDAK") AND ($v['cuti_besar'] == "TIDAK")) {
          // Cek PLT dari tabel usul_tpp
	  if (($cekplt == "YA") AND ($v['cuti_sakit'] == "TIDAK") AND ($v['cuti_besar'] == "TIDAK")) {
	    echo "<span class='label label-success'>PLT. </span>";
            echo "<div><small>Kelas</small><span class='pull-right text-muted'>".$v['kelas_jab']."<span></div>";
          } else {
            echo "<span class='label label-info'>Definitif</span>";
            echo "<div><small>Kelas</small><span class='pull-right text-muted'>".$v['kelas_jab']."<span></div>";
          }

          if ($v['cpns'] == "YA") {
            echo "<code class='pull-left'>Status : CPNS [80%]</code>";
            echo "<br/>";  
          }

          if ($v['cuti_sakit'] == "YA") {
            echo "<span class='label label-danger'>CUTI SAKIT (40 %)</span>";
            echo "<br/>";  
          }

          if ($v['cuti_besar'] == "YA") {
            echo "<span class='label label-warning'>CUTI BESAR (40 %)</span>";
            echo "<br/>";  
          }

          echo "<br/><div><small>TPP Basic</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_basic'],0,",",".")."<span></div>";
	  
	  if ($v['ket'] != '') {
	  echo "<br/><button type='button' class='btn btn-info btn-xs btn-outline' data-toggle='modal' data-target='#keterangan".$nip."'>
                  <span class='text text-danger'><span class='fa fa-info-circle' aria-hidden='true'></span> Informasi</span>
                  </button>";          
	  }

	  ?>
          <div id="keterangan<?php echo $nip;?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-body" align="left">
                <?php
                  echo "<h5 class='text text-info'>".$nama."</h5>";
                  echo $v['ket'];
                ?>
                </div>
              </div>
            </div>
          </div>
          <?php

          echo "</td>";
          
          // Perhitungan Tukin yang diterima, diambil 60%
          $nilaiskp60p = (60/100)*$nilaiskp;
          if ($nilaiskp == 0) {
            $warna = "danger";
          } else if ($nilaiskp <= 50) {
            $warna = "warning";
          } else {
            $warna = "default";
          }

	  $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
          $jenisjab = $this->mkinerja->get_jnsjab($nip);
	  $plt = $v['plt'];

	if ($v['cutitk_1bulan'] == "TIDAK") {
          //if (($jenisjab == "STRUKTURAL") OR ($jenisjab == "FUNGSIONAL UMUM") OR (($keltugasjft == "KESEHATAN") AND ($plt == "YA")) OR (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "TEKNIS"))  OR (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "PENYULUH"))) {
          	echo "<td class='$warna'>";
          	if ($nilaiskp > 100) {
            		$nilaiskp100k++; 
            		echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-danger'><b>".number_format($nilaiskp,2)."</b></p><span></div>";            
          	} else if ($nilaiskp <= 50) {
            		$skpkurang50++;
            		echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-warning'><b>".number_format($nilaiskp,2)."</b></p><span></div>";
	       	} else {
            		echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-primary'>".number_format($nilaiskp,2)."</p><span></div>";
         	} 
	        echo "<br/>";
          	//echo "<div><small>60 %</small><span class='pull-right text-muted'>".number_format($nilaiskp60p,2)."<span></div>";
		if ($nilaiskp >= 90) {
              		$nilai_skp_pengali = 100;
              		$kat_skp = "<span class='label label-primary'>SANGAT BAIK</span>";
            	} else if (($nilaiskp >= 76) AND ($nilaiskp < 90)) {
              		$nilai_skp_pengali = 90;
              		$kat_skp = "<span class='label label-success'>BAIK</span>";
            	} else if (($nilaiskp >= 61) AND ($nilaiskp < 76)) {
              		$nilai_skp_pengali = 80;
              		$kat_skp = "<span class='label label-warning'>CUKUP</span>";
            	} else if (($nilaiskp >= 51) AND ($nilaiskp < 61)) {
              		$nilai_skp_pengali = 70;
              		$kat_skp = "<span class='label label-danger'>KURANG</span>";
            	} else if (($nilaiskp >= 10) AND ($nilaiskp < 51)) {
              		$nilai_skp_pengali = 40;
              		$kat_skp = "<span class='label label-danger'>BURUK</span>";
            	} else {
              		$nilai_skp_pengali = 0;
              		//$kat_skp = "<span class='label label-danger'>DATA KINERJA TIDAK ADA</span>";
          		$kat_skp = "";  	
		}
		echo "<div><small>".$kat_skp."</small></div>";
          	echo "<div><small>TPP Kinerja</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_kinerja'],0,",",".")."<span></div>";
	        echo "</td>";
	  //} else if ((($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) OR (($keltugasjft == "KESEHATAN") AND ($plt == "TIDAK")) OR (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "PENDIDIKAN"))
	  //	    ) {
          //      echo "<td class='success' align='center'><br/>TIDAK WAJIB EKINERJA</td>";
          //} else {
          //      echo "<td class='danger' align='center'></td>";
          //}
	} else if ($v['cutitk_1bulan'] == "YA") {
	  echo "<td class='info' align='center'><br/>CUTI/TK 1 BULAN</td>";
	}

          // get nilai absensi
          $nilaiabsensi = $v['nilai_absensi'];
          $nilaiabsensi40p = (40/100)*$nilaiabsensi;
          
          if ($nilaiabsensi == 0) {
            $warna = "danger";
          } else if ($nilaiabsensi <= 50) {
            $warna = "warning";
          } else {
            $warna = "default";
          }

          echo "<td class='$warna'>";          
          echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-primary'>".number_format($nilaiabsensi,2)."</p><span></div>";
          echo "<br/>";
            
          echo "<div><small>40 %</small><span class='pull-right text-muted'>".number_format($nilaiabsensi40p,2)."<span></div>";
          echo "<div><small>TPP Absensi</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_absensi'],0,",",".")."<span></div>";
          //echo "<td align='center'>0 (0)</br>Rp. ".number_format($v['tpp_absensi'],0,",",".")."</td>";
         
          // Hitung tambahan          
           
          echo "<td>";

          // KETENTUAN BARU
          // untuk PLT, kinerja dihitung berdasarkan kelas dan harga jabatan PLT nya
          // sehingga tidak ada penambahan untuk PLT
          /*
          if ($cekplt == true) {
            echo "<div><small>PLT.</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_plt'],0,",",".")."<span></div>";
            $tambahplt = $v['jml_tpp_plt'];
          }
          */
          if ($v['plt'] == "YA") {
            $eselonplt = $this->mkinerja->get_eselonplt($nip);
            $eselonsaatini = $this->mpegawai->getfideselon($nip);
            if ($eselonplt == $eselonsaatini) {                   
              echo "<div><small>PLT. 20%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_plt'],0,",",".")."<span></div>";
            }          
          }

          if ($v['sekda'] == "YA") {
            echo "<div><small>Sekda 100%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_sekda'],0,",",".")."<span></div>";
          }

          if ($v['tanpajfu'] == "YA") {
            echo "<div><small>Tanpa JFU. 10%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_tanpajfu'],0,",",".")."<span></div>";
          }
          
          if ($v['bendahara'] == "YA") {
            echo "<div><small>Bendahara. 10%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_bendahara'],0,",",".")."<span></div>";
          }

          if ($v['pokja'] == "YA") {
            echo "<div><small>UKPBJ. 10%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_pokja'],0,",",".")."<span></div>";
          }
          
          if ($v['dokter'] == "YA") {
            echo "<div><small>Dokter</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_dokter'],0,",",".")."<span></div>";
          }

          if ($v['radiografer'] == "YA") {
            echo "<div><small>Radiografer. 10%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_radiografer'],0,",",".")."<span></div>";
          }

          if ($v['inspektorat'] == "YA") {
            echo "<div><small>Inspektorat. 10%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_inspektorat'],0,",",".")."<span></div>";
          }          

          if ($v['kelas1dan3'] == "YA") {
            if ($kelasjabatan == 1) {
              echo "<div><small>Kelas 1. 60%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_kelas1dan3'],0,",",".")."<span></div>";
            } else if ($kelasjabatan == 3) {
              echo "<div><small>Kelas 3. 20%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_kelas1dan3'],0,",",".")."<span></div>";
            }
          }          

          if ($v['terpencil'] == "YA") {
            echo "<div><small>Terpencil 10%</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_terpencil'],0,",",".")."<span></div>";
          }

          echo "<br/><div><small>JUMLAH.</small><span class='pull-right text-muted'>".number_format($v['jml_penambahan'],0,",",".")."<span></div>";
          echo "</td>";
	
	  // PPH dan IWP
          echo "<td>";
          $gajibruto =  $this->mkinerja->get_gajibruto($nip, $thn, $bln);
          $tppbruto =  $this->mkinerja->get_tppbruto($nip, $thn, $bln);
          $jmlpot =  $this->mkinerja->get_jmlpotongan($nip, $thn, $bln);
          $jnsptkp =  $this->mkinerja->get_jnsptkp($nip);
          $ptkp =  $this->mkinerja->get_ptkp($jnsptkp);
          $npwp =  $this->mkinerja->get_npwp($nip);
          $pphbulan =  $this->mkinerja->get_pphbulan($nip, $thn, $bln);
          if ($npwp == '') {
            $ketnpwp = "<s>NPWP</s>";
          } else {
            $ketnpwp = "NPWP";
          }

          echo "<div><small>Gaji Bruto</small><span class='pull-right text-muted'>".number_format($gajibruto,0,",",".")."<span></div>";
          echo "<div><small>TPP Bruto</small><span class='pull-right text-muted'>".number_format($tppbruto,0,",",".")."<span></div>";
          echo "<div><small>Pot. Gaji</small><span class='pull-right text-muted'>(".number_format($jmlpot,0,",",".").")<span></div>";
	  $pphgaji = $this->mkinerja->get_pphgaji($nip, $thn, $bln);
          echo "<div><small>PPh Gaji</small><span class='pull-right text-muted'>(".number_format($pphgaji,0,",",".").")<span></div>";
	  echo "<div><small>PPh 21</small><span class='pull-right text-muted'>".number_format($pphbulan,0,",",".")."<span></div>";
	  echo "<div><small><code>".$ketnpwp."</code> <code>".$jnsptkp."</code></small></div>";

          $iwpgaji =  $this->mkinerja->get_iwpgaji($nip, $thn, $bln);
          $iwpterhutang =  $this->mkinerja->get_iwpterhutang($nip, $thn, $bln);
          echo "<div><small>IWP Gaji</small><span class='pull-right text-muted'>".number_format($iwpgaji,0,",",".")."<span></div>";
          echo "<div><small>IWP Terhutang</small><span class='pull-right text-muted'>".number_format($iwpterhutang,0,",",".")."<span></div>";          

          echo "</td>";
          // End PPH dan IWP


          echo "<td>";
          echo "<div><small>TPP Real</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_kotor'],0,",",".")."<span></div>";
          echo "<div><small>Tambahan</small><span class='pull-right text-muted'>".number_format($v['jml_penambahan'],0,",",".")."<span></div>";
          
          //$jmlbersih = $v['jml_tpp_murni'] + $totaltambahan;
          echo "<div><small>TPP Bruto</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_murni'],0,",",".")."<span></div>";

          echo "<div><small>PPh 21</small><span class='pull-right text-muted'>(".number_format($v['jml_pajak'],0,",",".").")<span></div>";
	  echo "<div><small>IWP 1%</small><span class='pull-right text-muted'>(".number_format($v['jml_iuran_bpjs'],0,",",".").")<span></div>";
          
          echo "<div class='text-success'><small><b>TAKE HOME PAY</b></small></div>";
          if ($v['cpns'] == "YA") {
            echo "<code class='pull-left'>[80%]</code>";
          }
	  echo "<span class='pull-right text-muted'>
                  <p class='text-success'><b>Rp. ".number_format($v['tpp_diterima'],0,",",".")."</b></p>
                </span>
                ";
          echo "</td>";
          
	  if (($this->session->userdata('level') == "ADMIN")) {  
	   if ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "ENTRI") {           
	      echo "<td align='center'>";      
  	      echo "<form method='POST' action='".base_url()."kinerja/editusulpns'>";
              echo "<input type='hidden' name='idunker' id='idunker' value='$idunker'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              echo "<input type='hidden' name='thn' id='thn' value='$v[tahun]'>";
              echo "<input type='hidden' name='bln' id='bln' value='$v[bulan]'>"; 
              echo "<button type='submit' class='btn btn-warning btn-xs'>";
              echo "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span><br/>&nbspEdit&nbsp";
              echo "</button>";
              echo "</form>";
              echo "<br/>";

              echo "<form method='POST' action='".base_url()."kinerja/hapus_usul'>";
              echo "<input type='hidden' name='idunker' id='idunker' value='$idunker'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              echo "<input type='hidden' name='thn' id='thn' value='$v[tahun]'>";
              echo "<input type='hidden' name='bln' id='bln' value='$v[bulan]'>"; 
              echo "<button type='submit' class='btn btn-danger btn-xs'>";
              echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br/>Hapus";
              echo "</button>";
              echo "</form>";
	      echo "</td>";
            } 
	    //else {
            //  echo "<span class='label label-success'>SELESAI</span>";              
            //}      
          }
          $jmldata++;
        }
        $no++;
        echo "</tr>";

      endforeach;

      ?>
      </tbody>     
  </table>
</div>
</div>

<small>
<table class='table table-condensed'>
    <tr>
    <td width='25%' class='info' style='padding: 10px;'>    
      Jumlah respon data Aplikasi DES / eKinerja
      <span class='pull-right text-muted'><b>
      <?php echo $jmldata; ?> Data</b></span><br/>

      Jumlah data dengan Nilai SKP diatas 100
      <span class='pull-right text-muted'><b>
      <?php echo $skplebih100; ?> Data</b></span><br/>

      Jumlah data dengan Nilai SKP dibawah 50 
      <span class='pull-right text-muted'><b>
      <?php echo $skpkurang50; ?> Data</b></span><br/>

    <?php
      $ratakinerja = $this->mkinerja->getratakinerja_perpengantar($idpengantar, $thn, $bln);
      $rataabsensi = $this->mkinerja->getrataabsensi_perpengantar($idpengantar, $thn, $bln);
    ?> 
      RATA-RATA KINERJA
      <span class='pull-right text-muted'><b>
      <?php echo number_format($ratakinerja,2); ?></b></span><br/>

      RATA-RATA ABSENSI  
      <span class='pull-right text-muted'><b>
      <?php echo number_format($rataabsensi,2); ?></b></span> 
    </td>
    <td width='25%' class='success' style='padding: 10px;'>
    <?php
      $tottppkotor = $this->mkinerja->tottppkotor_perpengantarperiode($idpengantar, $thn, $bln);
      $tottambahan = $this->mkinerja->tottambahan_perpengantarperiode($idpengantar, $thn, $bln);
      $tottppmurni = $this->mkinerja->tottppmurni_perpengantarperiode($idpengantar, $thn, $bln);
      $totpajak = $this->mkinerja->totpajak_perpengantarperiode($idpengantar, $thn, $bln);;
      $totiwp = $this->mkinerja->totiwp_perpengantarperiode($idpengantar, $thn, $bln);
      $tottppditerima = $this->mkinerja->tottppditerima_perpengantarperiode($idpengantar, $thn, $bln);
    ?>
      Total TPP sesuai Realisasi 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppkotor,0,",","."); ?></b></span><br/>

      Total Tambahan 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottambahan,0,",","."); ?></b></span><br/>

      Total TPP + Tambahan (Sebelum Pajak) 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppmurni,0,",","."); ?></b></span><br/>

      Total Pajak 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($totpajak,0,",","."); ?></b></span><br/>

      Total IWP 1%
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($totiwp,0,",","."); ?></b></span><br/>

      Total TPP yang Dibayarkan 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima,0,",","."); ?></b></span><br/>
    </td>
    <td width='25%' class='warning' style='padding: 10px;'>
      <b>TOTAL TPP YANG DIBAYARKAN : </b><br/>
      <?php
	$tottppditerimagol4 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"IV/");
        $tottppditerimagol3 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"III/");
        $tottppditerimagol2 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"II/");
        $tottppditerimagol1 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"I/");
      ?>
      Golongan IV 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerimagol4,0,",","."); ?></b></span><br/>

      Golongan III 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerimagol3,0,",","."); ?></b></span><br/>

      Golongan II
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerimagol2,0,",","."); ?></b></span><br/>

      Golongan I 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerimagol1,0,",","."); ?></b></span><br/>
    </td>
    <td width='25%' class='danger' style='padding: 10px;'>
      <b>TOTAL TPP YANG DIBAYARKAN : </b><br/>
      <?php
	$tottppditerima_jpt = $this->mkinerja->tottppditerima_perpengantarperiode_jpt($idpengantar, $thn, $bln);
        $tottppditerima_administrator = $this->mkinerja->tottppditerima_perpengantarperiode_administrator($idpengantar, $thn, $bln);
        $tottppditerima_pengawas = $this->mkinerja->tottppditerima_perpengantarperiode_pengawas($idpengantar, $thn, $bln);
        $tottppditerima_jfujft = $this->mkinerja->tottppditerima_perpengantarperiode_jfujft($idpengantar, $thn, $bln);
      ?>
      JPT
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima_jpt,0,",","."); ?></b></span><br/>

      ADMINISTRATOR 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima_administrator,0,",","."); ?></b></span><br/>

      PENGAWAS
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima_pengawas,0,",","."); ?></b></span><br/>

      JFU/JFT 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima_jfujft,0,",","."); ?></b></span><br/>
    </td>      
    <tr>           
      <td align='right' colspan='4'>
        <?php
	$bulanini = date('n');
	$tahunini = date('Y');

	// tombol simpan hanya ditampilkan jika usulan hnya bulan lalu, dan tahun hnya tahun ini
   //if ($tahunini == $thn) {
	if (($bulanini-1 == $bln) AND ($tahunini == $thn)) {
	//if (($bln == '12') AND ($bulanini == '1') AND ($tahunini-1 == $thn)) {// Khusus Hitung TPP Desember pada Januari tahun berikutnya
	//var_dump($bln);
	//if ((($bulanini-1 == $bln) OR ($bulanini == $bln)) AND ($tahunini == $thn)) {
	  if (($this->session->userdata('level') == "ADMIN") AND ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "ENTRI")) {
            echo "<form method='POST' action='../kinerja/lanjutverifikasi'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-primary'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Lanjutkan Verifikasi SKPD";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "VERIFIKASI")) { 
            echo "<form method='POST' action='../kinerja/simpankalkulasi'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-danger'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Setuju & Simpan";
            echo "</button>";
            echo "</form>";
          } //else if ($this->session->userdata('level') == "ADMIN") {
	    else if (($this->session->userdata('tpp_priv') == "Y") AND (($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "REKAP") OR ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "CETAK"))) { 
            echo "<form method='POST' action='../kinerja/cetakrekapunor_perperiode' target='_blank'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-success'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span> Cetak Rekapitulasi";
            echo "</button>";
            echo "</form>";
          }
      	}  
      ?>
      </td>
    </tr>
    </tr>
  </table> 
  </small>

</div>
</div>
</center>
<?php
}
?>
