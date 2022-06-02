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
  <div class="panel panel-danger" style="width: 90%;background-color: Snow">
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

  <div class="panel panel-info" style="background-color: Snow">  
    <div class="panel-heading" align="left">
    <?php
      $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
    ?>
  <b>NOMINATIF TPP ASN ::: TK, SD, SMP SEDERAJAT KEC. <?php echo $kecamatan; ?></b>
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
          $nip = $v['nipppk'];
          echo "<tr>";
          echo "<td align='center'>".$no."</td>";

          $golru = $this->mpppk->getnamagolru($v['fid_golru']);
          $tingpen = $this->mpegawai->gettingpen($v['fid_tingpen']);
          $nama = $this->mpppk->getnama($nip);
          echo "<td>NIPPPK. ".$nip."<br/>".$nama."<br/>Golru. ".$golru;
                    
          $kelasjabatan = $this->mkinerja_pppk->get_kelasjabft($nip);
          $hargajabatan = $this->mkinerja_pppk->get_hargajabft($nip);
          $jnsjab = "<span class='label label-warning'>JFT</span>";
          $tingpen = "<span class='label label-primary'>".$tingpen."</span>";
          
          $nmsekolah = $this->munker->getnamaunker($v['fid_unker']);   
          echo "<br/>".$v['jabatan']." pada ".$nmsekolah."<br/>".$jnsjab." ".$tingpen; 

          echo "</td>";

          $pengali = $v['pengali']; 
          echo "<td>";          
          echo "<br/><div><small>TPP Basic</small><span class='pull-right text-muted'>Rp. ".number_format($v['tpp_basic'],0,",",".")."<span></div>";
          

          echo "</td>";
          
          // Perhitungan Tukin yang diterima, diambil 60%
          $nilaiskp60p = (60/100)*$nilaiskp;
          echo "<td class='info' align='center'>";
          echo "<span class='text-muted'>TIDAK WAJIB eKinerja</span>";
          
          echo "</td>";

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
          
          // Hitung tambahan          
           
          echo "<td>";          
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

	  if (($golru == "XIII") OR ($golru == "XIV") OR ($golru == "XV") OR ($golru == "XVI") OR ($golru == "XVII")) {
                $pajak = "15 %";
          } else if (($golru == "IX") OR ($golru == "X") OR ($golru == "XI") OR ($golru == "XII")) {
                $pajak = "5 %";
          } else {
                $pajak = "0 %";
          }

          echo "<div><small>Pajak ".$pajak."</small><span class='pull-right text-muted'>".number_format($v['jml_pajak'],0,",",".")."<span></div>";
          
          echo "<div class='text-success'><small><b>TAKE HOME PAY</b></small></div>
                <span class='pull-right text-muted'>
                  <p class='text-success'><b>Rp. ".number_format($v['tpp_diterima'],0,",",".")."</b></p>
                </span>
                ";
          echo "</td>";
          
            if (($this->session->userdata('level') == "ADMIN")) {
              echo "<td align='center'>";
              if ($this->mkinerja_pppk->getstatuspengantar_perid($idpengantar, $thn, $bln) == "ENTRI") {
                echo "<form method='POST' action='".base_url()."kinerja/editusulpns'>";
                echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";                
                echo "<input type='hidden' name='idunker' id='idunker' value='$id_kec'>";               
                echo "<input type='hidden' name='nip' id='nip' value='$v[nipppk]'>";
                echo "<input type='hidden' name='thn' id='thn' value='$v[tahun]'>";
                echo "<input type='hidden' name='bln' id='bln' value='$v[bulan]'>"; 
                echo "<button type='submit' class='btn btn-warning btn-xs'>";
                echo "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span><br/>&nbspEdit&nbsp";
                echo "</button>";
                echo "</form>";
                echo "<br/>";

                echo "<form method='POST' action='".base_url()."kinerja/hapus_usul'>";
                echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";                
                echo "<input type='hidden' name='idunker' id='idunker' value='$id_kec'>";              
                echo "<input type='hidden' name='nip' id='nip' value='$v[nipppk]'>";
                echo "<input type='hidden' name='thn' id='thn' value='$v[tahun]'>";
                echo "<input type='hidden' name='bln' id='bln' value='$v[bulan]'>"; 
                echo "<button type='submit' class='btn btn-danger btn-xs'>";
                echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br/>Hapus";
                echo "</button>";
                echo "</form>";
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
      $ratakinerja = $this->mkinerja_pppk->getratakinerja_perpengantar($idpengantar, $thn, $bln);
      $rataabsensi = $this->mkinerja_pppk->getrataabsensi_perpengantar($idpengantar, $thn, $bln);
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
      $totpajak = $this->mkinerja_pppk->totpajak_perpengantarperiode($idpengantar, $thn, $bln);
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

      Total TPP yang Dibayarkan 
      <span class='pull-right text-muted'><b>
      <?php echo "Rp. ".number_format($tottppditerima,0,",","."); ?></b></span><br/>
    </td>    
    <tr>           
        <td align='right' colspan='4'>
          <?php
          if (($this->session->userdata('level') == "ADMIN") AND ($this->mkinerja_pppk->getstatuspengantar_perid($idpengantar, $thn, $bln) == "ENTRI")) {
            echo "<form method='POST' action='../kinerja_pppk/lanjutverifikasi_sekolahan'>";          
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='id_kec' id='id_kec' value='$id_kec'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-primary'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Lanjutkan Verifikasi Dinas Pendidikan";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND ($this->mkinerja_pppk->getstatuspengantar_perid($idpengantar, $thn, $bln) == "VERIFIKASI")) { 
            echo "<form method='POST' action='../kinerja_pppk/simpankalkulasi_sekolahan'>";          
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='id_kec' id='id_kec' value='$id_kec'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-danger'>";
            echo "<span class='glyphicon glyphicon-saved' aria-hidden='true'></span> Setuju dan Simpan Kalkulasi";
            echo "</button>";
            echo "</form>";
          } else if (($this->session->userdata('tpp_priv') == "Y") AND (($this->mkinerja_pppk->getstatuspengantar_perid($idpengantar, $thn, $bln) == "REKAP") OR ($this->mkinerja_pppk->getstatuspengantar_perid($idpengantar, $thn, $bln) == "CETAK"))) { 
            echo "<form method='POST' action='../kinerja_pppk/cetakrekapsekolahan_perperiode' target='_blank'>";          
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$idpengantar'>";  
            echo "<input type='hidden' name='id_kec' id='id_kec' value='$id_kec'>";
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

