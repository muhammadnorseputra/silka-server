<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <!--<table class='table table-condensed'>
    <tr>
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table>
  -->

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

  <div class="panel panel-success">  
  <div class="panel-heading" align="left">
  <b>Inbox Status Cuti</b><br />
  <?php echo "Jumlah Data : ", $jmldata, " Usul"; ?>
  </div>

  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:305px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='success'>
        <td align='center'><b>No</b></td>
        <td align='center' width='220'><b>NIP | Nama</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center' width='120'><b>Jenis Cuti</b></td>
        <td align='center' width='150'><b>Lama</b></td>
        <!--<td align='center' width='120'><b>Pengantar</b></td>-->
        <td align='center' width='120' colspan='2'><b>Status</b></td>
      </tr>

      <?php
        //$no = 1;
        // untuk penomoran sesuai paging
        $no = $this->uri->segment('3') + 1;
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
        <td><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja']; ?></td>
        <td align='center'><?php echo $v['nama_jenis_cuti'], '<br />Tahun ',$v['thn_cuti']; ?></td>
        <?php
        $jnscuti = $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
        if (($jnscuti == 'CUTI TAHUNAN') AND ($v['tambah_hari_tunda'] != 0)) {
          echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].' + '.$v['tambah_hari_tunda'].' HARI<br />'.tgl_indo($v['tgl_mulai']).'<br />s/d '.tgl_indo($v['tgl_selesai'])."</td>";
        }  else {
          echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].'<br />'.tgl_indo($v['tgl_mulai']).'<br />s/d '.tgl_indo($v['tgl_selesai'])."</td>";
        }
        ?>        
        <!--<td align='center'><?php //echo $this->mcuti->getnopengantar($v['fid_pengantar']).'<br/>'.tgl_indo($v['tgl_pengantar']); ?></td>-->
        <td align='center'><?php echo $this->mcuti->getstatuscuti($v['fid_status']); ?></td>
        <td align='center'>
          <?php
          if ($this->mcuti->getstatuscuti($v['fid_status']) == 'BTL') {
            echo "<form method='POST' action='".base_url()."cuti/updatebtl'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-success btn-xs'>";
            echo "<span class='glyphicon glyphicon-new-window' aria-hidden='true'></span><br />Update";
            echo "</button>";
            echo "</form>";
          } else if ($this->mcuti->getstatuscuti($v['fid_status']) == 'TMS') {
            echo "<form method='POST' action='".base_url()."cuti/detailtms'>";
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-success btn-xs'>";
            echo "<span class='glyphicon glyphicon-list' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else {
            echo "";
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
  echo $paging;
?>        
</div>
</div>
</center>