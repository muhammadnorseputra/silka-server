<!-- Default panel contents -->
<center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../home">
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
  <b>PROSES KENAIKAN GAJI BERKALA</b><br />
  <?php echo "Jumlah Data : ", $this->mkgb->getjmlpengantarbystatus(3), " Pengantar"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:380px;border:1px solid white" >
  <table class="table table table-condensed table-hover">
      <tr class='success'>
        <td align='center'><b>No.</b></td>
            <td align='center' width='200'><b>No. Pengantar</b></td>
            <td align='center' width='120'><b>Tgl. Pengantar</b></td>
            <td align='center' width='450'><b>Unit Kerja</b></td>
            <td align='center' width='100'><b>Jumlah Usul</b></td>
            <td align='center' width='60'><b><b>Status</b></td>
            <td align='center' width='200'><b>Created</b></td>
            <td align='center' colspan='3'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($kgb as $v):          
      ?>
        <tr>
        <td align='center'><?php echo $no; ?></td>
        <td><?php echo $v['no_pengantar']; ?></td>
        <td><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
        <td><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
        <td align='center'><?php echo $this->mkgb->getjmldetailpengantar($v['id_pengantar']); ?></td>
        <td align='center'><?php echo $this->mkgb->getstatuspengantar($v['fid_status']); ?></td>
        <td><?php echo tglwaktu_indo($v['created_at']).'<br />'.$this->mpegawai->getnama($v['created_by']); ?></td>
        <td align='center'>
          <?php
          echo "<form method='POST' action='../kgb/detailproses'>";
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
          ?>
          <button type="submit" class="btn btn-success btn-xs ">
          <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Detail Usul
          </button>
          <?php
            echo "</form>";
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
</div>
</div>
</center>