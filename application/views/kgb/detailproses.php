<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../kgb/tampilproses">
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
  <?php echo "Jumlah Data : ", $jmldata, " Usulan"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:300px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='success'>
        <td align='center' rowspan='2'><b>No</b></td>
        <td align='center' rowspan='2' width='180'><b>NIP | Nama</b></td>
        <td align='center' rowspan='2' width='500'><b>Jabatan</b></td>
        <td align='center' colspan='4'><b>Gaji Pokok Terakhir</b></td>
        <td align='center' rowspan='2' width='120'><b>Entri Usul</b></td>
        <td align='center' rowspan='2' colspan='2'><b>Status</b></td>
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
        $status = $this->mkgb->getstatuskgb($v['fid_status']);
        if ($status == 'INBOXBKPPD') {          
          echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
        } else if ($status == 'BTL') {
          echo "<h5><span class='label label-warning'>B T L</span></h5>";
        } else if ($status == 'TMS') {
          echo "<h5><span class='label label-danger'>T M S</span></h5>";
        } else if ($status == 'SETUJU') {
          echo "<h5><span class='label label-success'>SETUJU</span></h5>";
        } else if ($status == 'CETAKSK') {
          echo "<h5><span class='label label-default'>CETAK SK</span></h5>";
        } else if ($status == 'SELESAI') {
          echo "<h5><span class='label label-default'>SELESAI</span></h5>";
        }
        ?>          
        </td>
	<td>
          <?php
            if (($status == 'SETUJU') OR ($status == 'CETAKSK')) {
              //echo "<img style='width: 100px;' src=base_url().'assets/images/'.$v[qrcode]>";
              ?>
              <img style="width: 50px;" src="<?php echo base_url().'assets/qrcodekgb/'.$v['qrcode'].'.png';?>">
              <?php
            }
          ?>
        </td>
        <td align='center'>
          <?php
          if ($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXBKPPD') {
            echo "<form method='POST' action='../kgb/prosesusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-primary btn-xs'>";
            echo "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span><br />Proses";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<form method='POST' action='../kgb/prosesusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-default btn-xs'>";
            echo "<span class='glyphicon glyphicon-list' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
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
          if ($this->mkgb->getstatuspengantar_byidpengantar($idpengantar) == 'BKPPD') {
            if ($this->mkgb->cek_selainsetujubtltms($idpengantar) == TRUE) {
              echo "<form method='POST' action='../kgb/selesaikankgb_aksi'>";          
              echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
              ?>
              <p align="right">
              <button type="submit" class="btn btn-success btn-sm">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Selesaikan
              </button>
              </p>
              </form>
          <?php
            }
          }
          ?>            
</div>
</div>
</center>
