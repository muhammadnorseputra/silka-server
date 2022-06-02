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
          <form method="POST" action="../kinerja_pppk/tampilunkernom_pppk">
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
  <div class="panel panel-default" style="width: 90%;background-color: AliceBlue">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <td align='right' width='50'>
        <form method="POST" action="../kinerja_pppk/cariusul_pppk">
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
  echo "(JUMLAH PPPK : ".$jmlpeg.")";
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
          $nip = $v['nipppk'];
          echo "<tr>";
          echo "<td align='center'>".$no."</td>";

          //$pangkat = $this->mpegawai->getnamapangkat($v['fid_golru']);
          $golru = $this->mpppk->getnamagolru($v['fid_golru']);
          $tingpen = $this->mpegawai->gettingpen($v['fid_tingpen']);
          $nama = $this->mpppk->getnama($nip);
          echo "<td>NIPPPK. ".$nip."<br/>".$nama."<br/> Golru : ".$golru;
          //echo "<td>NIPPPK. ".$nip."<br/>".$nama;
          
          $kelasjabatan = $this->mkinerja_pppk->get_kelasjabft($nip);
          $hargajabatan = $this->mkinerja_pppk->get_hargajabft($nip);
          $jnsjab = "<span class='label label-warning'>JFT</span>";
          $tingpen = "<span class='label label-primary'>".$tingpen."</span>";
          
          echo "<br/>".$v['jabatan'];       

          echo "<br/>".$jnsjab." ".$tingpen; 

          echo "</td>";

          $pengali = $v['pengali']; 
          echo "<td>";          
          echo "<div><small>Kelas</small><span class='pull-right text-muted'>".$v['kelas_jab']."<span></div>";
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

	$keltugasjft = $this->mpppk->getkeltugas_jft_nipppk($nip);
        $jenisjab = "FUNGSIONAL TERTENTU";

        if ($v['cutitk_1bulan'] == "TIDAK") {
          if (($jenisjab == "STRUKTURAL") OR ($jenisjab == "FUNGSIONAL UMUM") OR (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "TEKNIS"))
             OR (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "PENYULUH"))) { 
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
	  } else if ((($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) OR (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "PENDIDIKAN"))) {
                echo "<td class='success' align='center'><br/>TIDAK WAJIB EKINERJA</td>";
          } else {
                echo "<td class='danger' align='center'></td>";
          }
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
          $gajibruto =  $this->mkinerja_pppk->get_gajibruto($nip, $thn, $bln);
          $tppbruto =  $this->mkinerja_pppk->get_tppbruto($nip, $thn, $bln);
          $jmlpot =  $this->mkinerja_pppk->get_jmlpotongan($nip, $thn, $bln);
          $jnsptkp =  $this->mkinerja_pppk->get_jnsptkp($nip);
          $ptkp =  $this->mkinerja_pppk->get_ptkp($jnsptkp);
          $npwp =  $this->mkinerja_pppk->get_npwp($nip);
          $pphbulan =  $this->mkinerja_pppk->get_pphbulan($nip, $thn, $bln);
          if ($npwp == '') {
            $ketnpwp = "<s>NPWP</s>";
          } else {
            $ketnpwp = "NPWP";
          }

          echo "<div><small>Gaji Bruto</small><span class='pull-right text-muted'>".number_format($gajibruto,0,",",".")."<span></div>";
          echo "<div><small>TPP Bruto</small><span class='pull-right text-muted'>".number_format($tppbruto,0,",",".")."<span></div>";
          echo "<div><small>Pot. Gaji</small><span class='pull-right text-muted'>(".number_format($jmlpot,0,",",".").")<span></div>";
          $pphgaji = $this->mkinerja_pppk->get_pphgaji($nip, $thn, $bln);
          echo "<div><small>PPh Gaji</small><span class='pull-right text-muted'>(".number_format($pphgaji,0,",",".").")<span></div>";
          echo "<div><small>PPh 21</small><span class='pull-right text-muted'>".number_format($pphbulan,0,",",".")."<span></div>";
          echo "<div><small><code>".$ketnpwp."</code> <code>".$jnsptkp."</code></small></div>";

          $iwpgaji =  $this->mkinerja_pppk->get_iwpgaji($nip, $thn, $bln);
          $iwpterhutang =  $this->mkinerja_pppk->get_iwpterhutang($nip, $thn, $bln);
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

          //echo "<div><small>Pajak ".$pajak."</small><span class='pull-right text-muted'>".number_format($v['jml_pajak'],0,",",".")."<span></div>";
          
          echo "<div class='text-success'><small><b>TAKE HOME PAY</b></small></div>
                <span class='pull-right text-muted'>
                  <p class='text-success'><b>Rp. ".number_format($v['tpp_diterima'],0,",",".")."</b></p>
                </span>
                ";
          echo "</td>";
          
            if (($this->session->userdata('level') == "ADMIN")) {
              if ($this->mkinerja_pppk->getstatuspengantar_pppk($idunker, $thn, $bln) == "ENTRI") {
		 echo "<td align='center'>";
                echo "<form method='POST' action='".base_url()."kinerja/editusulpns'>";
                echo "<input type='hidden' name='idunker' id='idunker' value='$idunker'>";          
                echo "<input type='hidden' name='nip' id='nip' value='$v[nipppk]'>";
                echo "<input type='hidden' name='thn' id='thn' value='$v[tahun]'>";
                echo "<input type='hidden' name='bln' id='bln' value='$v[bulan]'>"; 
                echo "<button type='submit' class='btn btn-warning btn-xs'>";
                echo "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span><br/>&nbspEdit&nbsp";
                echo "</button>";
                echo "</form>";
                echo "<br/>";

                echo "<form method='POST' action='".base_url()."kinerja/hapus_usul'>";
                echo "<input type='hidden' name='idunker' id='idunker' value='$idunker'>";          
                echo "<input type='hidden' name='nip' id='nip' value='$v[nipppk]'>";
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
      $ratakinerja = $this->mkinerja_pppk->getratakinerja($idunker, $thn, $bln);
      $rataabsensi = $this->mkinerja_pppk->getrataabsensi($idunker, $thn, $bln);
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
      $tottppkotor = $this->mkinerja_pppk->tottppkotor_perpengantarperiode($idpengantar, $thn, $bln);
      $tottambahan = $this->mkinerja_pppk->tottambahan_perpengantarperiode($idpengantar, $thn, $bln);
      $tottppmurni = $this->mkinerja_pppk->tottppmurni_perpengantarperiode($idpengantar, $thn, $bln);
      $totpajak = $this->mkinerja_pppk->totpajak_perpengantarperiode($idpengantar, $thn, $bln);;
      $totiwp = $this->mkinerja_pppk->totiwp_perpengantarperiode($idpengantar, $thn, $bln);
      $tottppditerima = $this->mkinerja_pppk->tottppditerima_perpengantarperiode($idpengantar, $thn, $bln);
	
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
    <tr>           
        <td align='right' colspan='4'>
          <?php
          if (($this->session->userdata('level') == "ADMIN") AND ($this->mkinerja_pppk->getstatuspengantar_pppk($idunker, $thn, $bln) == "ENTRI")) {
            echo "<form method='POST' action='../kinerja_pppk/lanjutverifikasi'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-primary'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Lanjutkan Verifikasi SKPD";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND ($this->mkinerja_pppk->getstatuspengantar_pppk($idunker, $thn, $bln) == "VERIFIKASI")) { 
            echo "<form method='POST' action='../kinerja_pppk/simpankalkulasi'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";  
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-danger'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Setuju dan Simpan Kalkulasi";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND (($this->mkinerja_pppk->getstatuspengantar_pppk($idunker, $thn, $bln) == "REKAP") OR ($this->mkinerja_pppk->getstatuspengantar_pppk($idunker, $thn, $bln) == "CETAK"))) { 
            echo "<form method='POST' action='../kinerja_pppk/cetakrekapunor_perperiode' target='_blank'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$idunker'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-success btn-sm'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span> Cetak Rekapitulasi";
            echo "</button>";
            echo "</form>";
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

