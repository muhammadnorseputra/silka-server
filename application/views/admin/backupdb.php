<!-- Default panel contents -->
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-info">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
  <center>
  <div class="panel panel-default"  style="width: 30%;">
  <div class="panel-body">

  <div class="panel panel-danger">
  <div class="panel-heading" align="left">
  <b>Backup Databases</b><br /> 
  </div>
  </div>
  <table class="table table-responsive table-bordered">
   <thead>
    <tr>
     <th>Nama Database</th>
     <th></th>
    </tr>
   </thead> 
   <tbody>
    <?php 
      foreach ($listdb as $db => $val)
	{
	$btn = '<a href="'.base_url("admin/run_backupdb/$val").'" class="btn btn-sm btn-primary">Run Backup</a>';
        if($val == "sapkv2") {
	 $btn_rundb = $btn;
        } else {
         $btn_rundb = "<span class='text-danger'>Disabled</span>";
	}
          echo '<tr>
		   <td>'.$val.'</td>
		   <td>'.$btn_rundb.'</td>
		</tr>';
	}
    ?>
   </tbody>
  </table>
  <!-- untuk scrollbar -->
  </div>
  </div>
  </center>
