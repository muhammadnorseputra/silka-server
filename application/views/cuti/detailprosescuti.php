<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../cuti/tampilproses">
          <button type="submit" class="btn btn-primary btn-sm">
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

  <div class="panel panel-warning">  
  <div class="panel-heading" align="left">
  <b>Pengantar Nomor : <?php echo $nopengantar; ?></b><br />
  <?php echo "Jumlah Data : ", $jmldata, " Usul"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:300px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='warning'>
        <td align='center' width='10'><b>No</b></td>
        <td align='center' width='250'><b>NIP | Nama</b></td>
        <td align='center' width='500'><b>Jabatan</b></td>
        <td align='center' width='120'><b>Jenis Cuti</b></td>
        <td align='center' width='150'><b>Lama</b></td>
        <td align='center'><b>Entry Usul | User Usul</b><br/><b><u>Kirim Usul</u></b></td>
        <td align='center' width='120' colspan='2'><b>Status</b></td>
        <td align='center' width='50'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($cuti as $v):          
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
        <td align='center'><?php echo $v['nama_jenis_cuti'], '<br />Tahun ',$v['thn_cuti']; ?></td>

	<td align='center'>
        <?php
        if ($v['tambah_hari_tunda'] != 0) {
          $jmltotal = $v['jml'] + $v['tambah_hari_tunda'];
          echo $jmltotal." (".$v['jml']." + ".$v['tambah_hari_tunda']." Cuti Tunda)";
        } else {
          $jmltotal = $v['jml'];
          echo $jmltotal.' '.$v['satuan_jml'];
        }
        ?>
        <?php echo '<br />',tgl_indo($v['tgl_mulai']),'<br />s/d ',tgl_indo($v['tgl_selesai']); ?></td>

        <td align='center'><?php echo $v['tgl_usul'].'<br/>'.$this->mlogin->getnamauser($v['user_usul']); ?><br/><u><?php echo $v['tgl_kirim_usul']; ?></u></td>

        <td align='center'>
        <?php
        $status = $this->mcuti->getstatuscuti($v['fid_status']);
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
              ?>
              <img style="width: 50px;" src="<?php echo base_url().'assets/qrcodecuti/'.$v['qrcode'] .'.png';?>">
              <?php
            }
          ?>
        </td>

        <td align='center'>
          <?php
          if ($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXBKPPD') {
            echo "<form method='POST' action='../cuti/prosesusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-info btn-xs'>";
            echo "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span><br />Proses";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<form method='POST' action='../cuti/prosesusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
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
      <!--
            <form method='POST' action='../cuti/hapus_pengantar'>
            <input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>
            <input type='hidden' name='no_pengantar' id='no_pengantar' value='$nopengantar'>
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Turun Status
            </button>
            </form>
      -->
        <?php
          if ($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'BKPPD') {
            if ($this->mcuti->cek_selainsetujubtltms($idpengantar) == TRUE) {
              echo "<form method='POST' action='../cuti/selesaikancuti_aksi'>";          
              echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
              echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
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
