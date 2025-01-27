<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <td align='right'>
      <?php
      // cek privilegde user session -- usulkgb_priv
      if ($this->session->userdata('usulkgb_priv') == "Y") { 
      ?>
      <td align='right'>
        <?php
        // jika status sudah cetak maka tidak bisa tambah usul lagi
        if ($this->mkgb->getstatuspengantar_byidpengantar($idpengantar) == 'SKPD') {
        ?>
          <form method="POST" action="../kgb/tambahusul">
            <?php
            echo "<input type='hidden' name='id_pengantar' id='fid_pengantar' value='$idpengantar'>";
            ?>
            <button type="submit" class="btn btn-success btn-sm">
              <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Tambah Usul
            </button>
          </form>
        <?php
        }
        ?>
      </td>
      <?php
      }
      ?>
      </td>
      <td align='right' width='50'>
        <form method="POST" action="../kgb/tampilpengantar">
          <button type="submit" class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table>

  <?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?> 

  <div class="panel panel-success">  
  <div class="panel-heading" align="left">
  <b>Pengantar KGB Nomor : <?php echo $nopengantar; ?></b><br />
  <?php echo $this->mkgb->getunker_pengantar($idpengantar); ?>
  <?php echo "<br/>Jumlah Data : ", $jmldata, " Usul"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:100%;height:300px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='success'>
        <td align='center' rowspan='2'><b>No</b></td>
        <td align='center' rowspan='2' width='180'><b>NIP | Nama</b></td>
        <td align='center' rowspan='2'><b>Jabatan</b></td>
        <td align='center' colspan='4'><b>Gaji Pokok Terakhir</b></td>
        <td align='center' rowspan='2' width='120'><b>Entri Usul</b></td>
        <td align='center' rowspan='2' colspan='4'><b>Aksi</b></td>
      </tr>
      <tr class='success'>
        <td align='center' width='100'><b>Gaji Pokok</b></td>
        <td align='center' width='80'><b>Dlm Golru</b></td>
        <td align='center' width='70'><b>Maker</b></td>
        <td align='center' width='120'><b>TMT</b></td>

      </tr>

      <?php
        $no = 1;
        foreach($kgb as $v):          
      ?>

      <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }
      ?>

      <tr>
        <td align='center'><?php echo $no; ?></td>
        <td><?php echo $v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></td>
        <td><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja']; ; ?></td>
        <td align='center'><?php echo 'Rp. ',indorupiah($v['gapok_lama']); ?></td>
        <td align='center'><?php echo $this->mpegawai->getnamagolru($v['fid_golru_lama']); ?></td>
        <td align='center'><?php echo $v['mk_thn_lama'].' Tahun<br/>'.$v['mk_bln_lama'].' Bulan'; ?></td>
        <td align='center'><?php echo tgl_indo($v['tmt_gaji_lama']); ?></td>

        <td align='center'><?php echo tglwaktu_indo($v['tgl_usul']); ?></td>
        <td align='center'>
          <?php
          if (($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXSKPD') OR ($this->mkgb->getstatuskgb($v['fid_status']) == 'CETAKUSUL')) {
            echo "<form method='POST' action='../kgb/detailusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-success btn-xs'>";
            echo "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-success btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span><br />Detail";
            echo "</button>";
          }
          ?>
        </td>
        <!--
        <td align='center'>
          <?php
          /*
          if (($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXSKPD') OR ($this->mkgb->getstatuskgb($v['fid_status']) == 'CETAKUSUL')) {
            echo "<form method='POST' action='../kgb/cetakusul' target='_blank'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";          
            echo "<button type='submit' class='btn btn-primary btn-xs'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span><br />Cetak";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-primary btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span><br />Cetak";
            echo "</button>";
          }
          */
          ?>
        </td>
        -->
        <td align='center'>
          <?php
          if (($this->mkgb->getstatuspengantar_byidpengantar($idpengantar) == 'SKPD') AND (($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXSKPD') OR ($this->mkgb->getstatuskgb($v['fid_status']) == 'CETAKUSUL'))) {
            echo "<form method='POST' action='../kgb/editusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-warning btn-xs'>";
            echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span><br />&nbspEdit&nbsp";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-warning btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span><br />&nbspEdit&nbsp";
            echo "</button>";            
          }
          ?>
        </td>
        <td align='center'>
          <?php
          if (($this->mkgb->getstatuspengantar_byidpengantar($idpengantar) == 'SKPD') AND (($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXSKPD') OR ($this->mkgb->getstatuskgb($v['fid_status']) == 'CETAKUSUL'))) {
            echo "<form method='POST' action='../kgb/hapus_usul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-danger btn-xs'>";
            echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br />Hapus";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-danger btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br />Hapus";
            echo "</button>";
          }
          ?>
        </td>
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>  
</div>
</div>
          <?php
          if ($this->mkgb->getjmldetailpengantar($idpengantar) == 0) {
            echo "<form method='POST' action='../kgb/hapus_pengantar'>";          
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='no_pengantar' id='no_pengantar' value='$nopengantar'>";
            ?>
            <p align="right">
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus Pengantar
            </button>
            </p>
            </form>
          <?php
          } else if ($this->mkgb->getstatuspengantar_byidpengantar($idpengantar) == 'CETAK') {
            echo "<form method='POST' action='../kgb/kirim_kebkppd'>";          
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='no_pengantar' id='no_pengantar' value='$nopengantar'>";
            ?>
            <p align="right">
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Kirim Pengantar
            </button>
            </p>
            </form>
          <?php
          }
          ?>            
</div>
</div>
</center>
