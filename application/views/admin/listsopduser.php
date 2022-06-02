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
  <div class="panel panel-default"  style="width: 99%;">
  <div class="panel-body">
  
  <table class='table table-condensed'>
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

  <div class="panel panel-danger">  
  <div class="panel-heading" align="left">
  <b>SOPD User Management</b><br />
  <?php echo "Jumlah Data : ", $jmldata, " Instansi"; ?>
  </div>
  </div>
  <table class="table table-condensed">
      <tr class='danger'>
        <td align='center' width='30'><b>No.</b></td>
        <td align='center' width='80'><b>ID Instansi</b></td>
        <td align='center' width='450'><b>Nama Instansi</b></b></td>
        <td align='center' width='650'><b>User</b></td>
        <td align='center'><b>Aksi</b></td>
      </tr>
</table>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:280px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <!--
      <tr class='danger'>
        <td align='center' width='30'>No.</td>
        <td align='center' width='80'>ID Instansi</td>
        <td align='center' width='450'>Nama Instansi</td>
        <td align='center'>User</td>
        <td align='center'>Aksi</td>
      </tr>
      -->

      <?php
        $no = 1;
        foreach($sopd as $v):          
      ?>

      <tr>    
        <td align='center' width='30'><?php echo $no; ?></td>
        <td align='center' width='80'><?php echo $v['id_instansi']; ?></td>
        <td width='450'><?php echo $v['nama_instansi']; ?></td>
        <td>
        <?php 
        $userlist = explode(",", $v['nip_user']);
        foreach ($userlist as $ul):
          $lokasifile = './photo/';
          $filename = $ul.".jpg";

          if (file_exists ($lokasifile.$filename)) {
            $photo = "../photo/".$ul.".jpg";
          } else {
            $photo = "../photo/nophoto.jpg";
          }

          //$nama = $this->mpegawai->getnama($ul);
          echo "<img src='$photo' width='45' height='60' title=".$ul.">&nbsp";
        endforeach;
        ?>          
        </td>
        <td align='center' width='50'>
          <?php          
              echo "<form method='POST' action='../admin/editsopduser'>";          
              echo "<input type='hidden' name='id_instansi' id='nip' value='$v[id_instansi]'>";
              echo "<input type='hidden' name='nama_instansi' id='username' value='$v[nama_instansi]'>";
              ?>
              <button type="submit" class="btn btn-primary btn-xs">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><br />&nbspEdit&nbsp
              </button>
              </form>
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