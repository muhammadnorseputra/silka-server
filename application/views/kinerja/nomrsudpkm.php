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
  <b>NOMINATIF KINERJA ASN ::: <?php echo $nmunker; ?></b>
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
        <td align='center' width='30'><b>No1</b></td>
        <td align='center' width='350'><b>IDENTITAS</b></td>
        <td align='center' width='150'><b>KETERANGAN</td>
        <td align='center' width='150'><b>KINERJA</b></td>
        <td align='center' width='150'><b>ABSENSI</b></td>
        <td align='center' width='140'><b>TAMBAHAN</b></td>
        <td align='center' width='140'><b>KALKULASI</b></td>
	<?php
        if (($this->session->userdata('level') == "ADMIN")) {
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
            echo "<td>NIP. ".$nip."<br/>".$nama."<br/>".$pangkat." (".$golru.")";
          } else {
            echo "<td>NIP. ".$nip."<br/>".$this->mkinerja->get_namapensiun($nip)." <span class='label label-success'>PENSIUN / MUTASI</span><br/>".$pangkat." (".$golru.")";
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
          $cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
          if (($cekplt == true) AND ($v['cuti_sakit'] == "TIDAK") AND ($v['cuti_besar'] == "TIDAK")) {
            $dataplt = $this->mkinerja->get_dataplt($nip); 
            echo "<br/><i class='fa fa-check'></i><small class=text-primary><abbr title='".$dataplt."'> PLT. ".$dataplt."</abbr></small>";
          }
                    
          $cekbendahara = $this->mkinerja->cek_sdgbendahara($nip, $bln, $thn);
          if ($cekbendahara == true) {
            $databendahara = $this->mkinerja->get_databendahara($nip);
            echo "<br/><i class='fa fa-check'></i><small class=text-primary>".$databendahara."</abbr></small>";
          }

          echo "<br/>".$jnsjab." ".$tingpen; 

          echo "</td>";

          $pengali = $v['pengali'];               
          //$totaltukin = $v['harga_jab']*$hargasatuan; 

          echo "<td>";
          // PLT. hanya diperbolehkan jika ybs dalam keadaan tidak sedang cuti sakit atau cuti besar
          if (($cekplt == true) AND ($v['cuti_sakit'] == "TIDAK") AND ($v['cuti_besar'] == "TIDAK")) {
            echo "<span class='label label-success'>PLT. </span>";
            echo "<div><small>Kelas</small><span class='pull-right text-muted'>".$v['plt_kelasjab']."<span></div>";
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

          // TPP basic sebenarnya adalah ini
          // pada database, TPP basic adalah sudah dikurangi dengan jml_pengurangan (selisih jaspel)
          $tppbasic = $v['tpp_basic'] + $v['jml_pengurangan'];
          echo "<br/><div><small>TPP Basic</small><span class='pull-right text-muted'>".number_format($tppbasic,0,",",".")."<span></div>";
          echo "<div><small>Pengurang</small><span class='pull-right text-muted'>".number_format($v['jml_pengurangan'],0,",",".")."<span></div>";
          echo "<b><div><small>Perhitungan</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_basic'],0,",",".")."<span></div></b>";
          

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
          if (($jenisjab == "STRUKTURAL") OR ($jenisjab == "FUNGSIONAL UMUM")) {
            echo "<td class='$warna'>";
            if ($nilaiskp > 100) {
              $nilaiskp100k++; 
              echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-danger'><b>".number_format($nilaiskp,2)."</b></p><span></div>";            
            } else if ($nilaiskp <= 50) {
              $skpkurang50++;
              echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-warning'><b>".number_format($nilaiskp,2)."</b></p><span></div>";
              //echo "<div><small>60 %</small><span class='pull-right text-muted'>".number_format($nilaiskp60p,2)."<span></div>";
            } else {
              echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-primary'>".number_format($nilaiskp,2)."</p><span></div>";
              //echo "<div><small>60 %</small><span class='pull-right text-muted'>".number_format($nilaiskp60p,2)."<span></div>";
            }

            echo "<br/>";
            echo "<div><small>60 %</small><span class='pull-right text-muted'>".number_format($nilaiskp60p,2)."<span></div>";
            echo "<div><small>TPP Kinerja</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_kinerja'],0,",",".")."<span></div>";
            
            echo "</td>";
          } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
		echo "<td class='info' align='center'><br/>TIDAK WAJIB EKINERJA</td>";
          } else {
	 	echo "<td class='warning' align='center'></td>";
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

          $cekspesialis = $this->mkinerja->cekspesialis($nip);
          if ($cekspesialis == true) {
                echo "<td class='info' align='center'><br/>TIDAK WAJIB EKINERJA</td>";
          } else {
            echo "<td class='$warna'>";          
            echo "<div><small>Realisasi</small><span class='pull-right text-muted'><p class='text-primary'>".number_format($nilaiabsensi,2)."</p><span></div>";
            echo "<br/>";
            
            if (($jenisjab == "STRUKTURAL") OR ($jenisjab == "FUNGSIONAL UMUM")) {
              echo "<div><small>40 %</small><span class='pull-right text-muted'>".number_format($nilaiabsensi40p,2)."<span></div>"; 
            }

            echo "<div><small>TPP Absensi</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_absensi'],0,",",".")."<span></div>";
          }
           
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


          echo "<td>";
          echo "<div><small>TPP Gross</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_kotor'],0,",",".")."<span></div>";
          echo "<div><small>Tambahan</small><span class='pull-right text-muted'>".number_format($v['jml_penambahan'],0,",",".")."<span></div>";
          
          //$jmlbersih = $v['jml_tpp_murni'] + $totaltambahan;
          echo "<div><small>Jumlah</small><span class='pull-right text-muted'>".number_format($v['jml_tpp_murni'],0,",",".")."<span></div>";


          if (($golru == "IV/E") OR ($golru == "IV/D") OR ($golru == "IV/C") OR ($golru == "IV/B") OR ($golru == "IV/A")) {
              $pajak = "15 %";
            } else if (($golru == "III/D") OR ($golru == "III/C") OR ($golru == "III/B") OR ($golru == "III/A")) {
              $pajak = "5 %";
            } else {
              $pajak = "0 %";
            }

          echo "<div><small>Pajak ".$pajak."</small><span class='pull-right text-muted'>".number_format($v['jml_pajak'],0,",",".")."<span></div>";
          //$kurangipajak = $v['jml_tpp_murni'] - $v['jml_pajak']; // data nilai setelah pajak, tidak ada dalam tabel
          //echo "<div><small>Total</small><span class='pull-right text-muted'>".number_format($kurangipajak,0,",",".")."<span></div>";
          
	  //echo "<div><small>BPJS</small><span class='pull-right text-muted'>".number_format($v['jml_iuran_bpjs'],0,",",".")."<span></div>";
          echo "<div class='text-success'><small><b>TAKE HOME PAY</b></small></div>
                <span class='pull-right text-muted'>
                  <p class='text-success'><b>Rp. ".number_format($v['tpp_diterima'],0,",",".")."</b></p>
                </span>
                ";
          echo "</td>";

	  if (($this->session->userdata('level') == "ADMIN")) {
	    echo "<td align='center'>";
            if ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "ENTRI") {           
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
            } else {
              echo "<span class='label label-success'>SELESAI</span>";              
            }      
            echo "</td>";
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
      $ratakinerja = $this->mkinerja->getratakinerja($idunker, $thn, $bln);
      $rataabsensi = $this->mkinerja->getrataabsensi($idunker, $thn, $bln);
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
      $tottppkotor = $this->mkinerja->tottppkotor_perunkerperiode($idunker, $thn, $bln);
      $tottambahan = $this->mkinerja->tottambahan_perunkerperiode($idunker, $thn, $bln);
      $tottppmurni = $this->mkinerja->tottppmurni_perunkerperiode($idunker, $thn, $bln);
      $totpajak = $this->mkinerja->totpajak_perunkerperiode($idunker, $thn, $bln);
      $tottppditerima = $this->mkinerja->tottppditerima_perunkerperiode($idunker, $thn, $bln);
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

      Total TPP yang Dibayarkan 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima,0,",","."); ?></b></span><br/>
    </td>
    <td width='25%' class='warning' style='padding: 10px;'>
      <b>TOTAL TPP YANG DIBAYARKAN : </b><br/>
      <?php
        $tottppditerimagol4 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"IV/");
        $tottppditerimagol3 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"III/");
        $tottppditerimagol2 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"II/");
        $tottppditerimagol1 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"I/");
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
        $tottppditerima_jpt = $this->mkinerja->tottppditerima_perunkerperiode_jpt($idunker, $thn, $bln);
        $tottppditerima_administrator = $this->mkinerja->tottppditerima_perunkerperiode_administrator($idunker, $thn, $bln);
        $tottppditerima_pengawas = $this->mkinerja->tottppditerima_perunkerperiode_pengawas($idunker, $thn, $bln);
        $tottppditerima_jfujft = $this->mkinerja->tottppditerima_perunkerperiode_jfujft($idunker, $thn, $bln);
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
	//if ($this->session->userdata('level') == "ADMIN") {
        if (($bulanini-1 == $bln) AND ($tahunini == $thn)) {
	  if (($this->session->userdata('level') == "ADMIN") AND ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "ENTRI")) {
            echo "<form method='POST' action='../kinerja/lanjutverifikasi'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-primary'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Lanjutkan Verifikasi SKPD";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "VERIFIKASI")) { 
            echo "<form method='POST' action='../kinerja/simpankalkulasi'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-danger'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Setuju dan Simpan";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND (($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "REKAP") OR ($this->mkinerja->getstatuspengantar($idunker, $thn, $bln) == "CETAK"))) { 
            echo "<form method='POST' action='../kinerja/cetakrekapunor_perperiode' target='_blank'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-success'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span> Cetak Rekapitulasi";
            echo "</button>";
            echo "</form>";
          }
	//}
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
