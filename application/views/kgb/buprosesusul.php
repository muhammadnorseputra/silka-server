<?php
// untuk menghitung KGB berikutnya pada form prosesusul.php
function showHasilProses() {
    $fidgolru = $this->input->get('fidgolru'); 
    $mk_thn = $this->input->get('mkthn'); 
    $mk_bln = $this->input->get('mkbln'); 
    $tmt = $this->input->get('tmt');

    $tmt_thn = substr($tmt,0,4);
    $tmt_bln = substr($tmt,5,2);


    
    // cari selisih bulan mk untuk menambahkan 1 tahun
    $mk_blnbaru = 12-$mk_bln;
    $mk_bln = 0;
    //$mk_thn++;
    $tmt_bln = $tmt_bln+$mk_blnbaru;

    if ($tmt_bln > 12) {
      $tmt_thn=$tmt_thn+1;
      $tmt_bln = $tmt_bln-12;
    }

    /*$sisabln = $tmt_bln%12;
    if ($sisabln) {
      $tmt_bln = $sisabln;
      //$tmt_bln = $tmt_bln-12;
      //$tmt_thn++;
    }
    */

    // cek golongan, untuk golongan II menggunakan kenaikan gaji ganjil    
    if (($fidgolru == '21') OR ($fidgolru == '22') OR ($fidgolru == '23') OR ($fidgolru == '24')) {      
      if (!($mk_thn%2)) {
        // cek gaji disini    
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        //$mk_thn++;
        $mk_thn=$mk_thn+1;
        //echo '<br/>2 genap';
      } else {
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        $mk_thn=$mk_thn+2;
        //echo '<br/>2 ganjil';
      }
      //echo '<br/>golru 2 : '.$fidgolru;
    } else {
      if (!($mk_thn%2)) {
        // cek gaji disini    
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        $mk_thn=$mk_thn+2;
        //echo '<br/>134 genap';
      } else {
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        //$mk_thn++;
        $mk_thn=$mk_thn+1;
        //echo '<br/>134 ganjil';
      }
      //echo '<br/>golru 134 : '.$fidgolru;
    }       
    
    // diperlukan nama pangkat untuk query pada tabel ref_gaji
    $namgolru = $this->mpegawai->getnamagolru($fidgolru);
    $gaji = $this->mkgb->getgaji($namgolru, $mk_thn);

    /*
    echo '<br/>MK Tahun : '.$mk_thn;
    echo '<br/>MK Bulan : '.$mk_bln;
    echo '<br/>Golru : '.$namgolru;
    echo '<br/>TMT : '.$tmt_bln.'-'.$tmt_thn;
    echo '<br/>Gaji : Rp. '.indorupiah($gaji);
    */

    ?>
    <table class="table table-condensed">
      <tr class='success'>
        <td align='right'><b>Gaji Pokok Baru</b> :</td>
        <td>
        <input type="text" size='15' name="gapok" value="<?php echo $gaji; ?>" />
        <?php //echo 'Rp. '.indorupiah($gaji).',-'; ?>
        </td>
      </tr>                
      <tr class='success'>
        <td align='right'><b>Berdasarkan Masa Kerja</b> :</td>
        <td>
          <input type="text" size='3' maxlength='2' name="mkthn" value="<?php echo $mk_thn; ?>" /> Tahun
          <input type="text" size='3' maxlength='2' name="mkbln" value="<?php echo $mk_bln; ?>" /> Bulan
          <?php //echo $mk_thn.' Tahun, '.$mk_bln.' Bulan'; ?>
        </td>
      </tr>
      <tr class='success'>
        <td align='right'><b>Dalam Golru</b> :</td>
        <td>
          <?php echo $this->mpegawai->getnamapangkat($fidgolru).' ('.$this->mpegawai->getnamagolru($fidgolru).')';?>
          <input type="hidden" size='3' name="fid_golru_baru" value="<?php echo $fidgolru; ?>" />
        </td>                  
      </tr>
      <tr class='success'>
        <td align='right'><b>TMT KGB</b> :</td>
        <td>
          <input type="text" size='10' name="tmtkgb" class='tanggal' value="<?php echo '01-'.$tmt_bln.'-'.$tmt_thn; ?>" />
          <?php //echo '1 '.bulan($tmt_bln).' '.$tmt_thn; ?>
        </td>                  
      </tr>
      <tr class='success'>
        <td align='right'><b>TMT KGB Berikutnya</b> :</td>
        <td>
          <input type="text" size='10' name="tmtberikutnya" class='tanggal' value="<?php echo '01-'.$tmt_bln.'-'.($tmt_thn+2); ?>" />
          <?php //echo '1 '.bulan($tmt_bln).' '.($tmt_thn+2)  ; ?>
        </td>                  
      </tr>
      
    </table>
    <?php
  }

  ?>