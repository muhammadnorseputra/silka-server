<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%;">
  <div class="panel-body">

  <?php
  if ($this->session->flashdata('pesan') <> ''){
    ?>
    <div class="alert alert-dismissible alert-danger">
      <?php echo $this->session->flashdata('pesan');?>
    </div>
    <?php
  }
  ?>
  
  <table class='table table-condensed'>
    <tr>
      <?php
      // cek privilegde user session -- usulcuti_priv
      if ($this->session->userdata('usulkgb_priv') == "Y") { 
      ?>
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>           
      <?php
      }
      ?>
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

  <div class="panel panel-danger">  
  <div class="panel-heading" align="left">
  <b>UPDATE PENGANTAR KGB</b><br />
  <?php echo "Jumlah Data : ", $this->mkgb->getjml_tampilupdatepengantar(), " Pengantar"; ?>
  </div>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:450px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='warning'>
        <td align='center' width='40'><b>No.</b></td>
        <td align='center' width='200'><b>No. Pengantar</b></td>
        <td align='center' width='200'><b>Tgl. Pengantar</b></td>
        <td align='center' width='450'><b>Unit Kerja</b></td>
        <td align='center' width='50'><b>Jumlah Usul</b></td>
        <td align='center' width='50'><b>Status</b></td>
        <td align='center' colspan='2'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($kgb as $v):          
      ?>
     
        <td align='center'><?php echo $no; ?></td>
        <td><?php echo $v['no_pengantar']; ?></td>        
        <td><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
        <td><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
        
        <td align='center'><?php echo $this->mkgb->getjmldetailpengantar($v['id_pengantar']); ?></td>
        <td align='center'><?php echo $this->mkgb->getstatuspengantar($v['fid_status']); ?></td>        
        <!--<td><?php //echo tglwaktu_indo($v['created_at']); ?></td>-->
        <td align='center' width='100'>
          <?php
          echo "<form method='POST' action='../kgb/admin_updatepengantar'>";          
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
          echo "<input type='hidden' name='tgl_pengantar' id='tgl_pengantar' value='$v[tgl_pengantar]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-sm">
          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbspUpdate Usul
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
