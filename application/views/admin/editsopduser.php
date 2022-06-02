<center>  
  <div class="panel panel-default" style="width: 60%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../admin/listsopduser'>";          
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' action='../admin/editsopduser_aksi'>
      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>EDIT SOPD USER</b>
        </div>
        <?php
          foreach($user as $v):
        ?>

        <table class='table table-condensed'>
          <tr>
            <td align='center'>              
             
              <table class='table table-condensed'>
                <tr>
                  <td align='right'>ID Instansi :</td>
                  <td>
                  <input type="text" size='10' value='<?php echo $v['id_instansi']; ?>' disabled/>
                  <input type="hidden" name="id_instansi" size='10' value='<?php echo $v['id_instansi']; ?>' />
                  </td>
                </tr>
                <tr>
                  <td align='right'>Nama Instansi :</td>
                  <td>
                  <input type="text" size='100' value='<?php echo $v['nama_instansi']; ?>' disabled/>
                  <input type="hidden" name="nama_instansi" size='100' value='<?php echo $v['nama_instansi']; ?>'/>
                  </td>
                </tr>
                <tr>
                  <td rowspan='2' align='right'>User Admin :</td>
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
                    echo "<img src='$photo' width='60' height='80' title=".$ul.">&nbsp";
                  endforeach;
                  ?>          
                  </td>
                </tr>
                <tr>
                  <td># Setiap NIP harus dipisahkan dengan koma (,) tanpa spasi<br />
                  <textarea name="nip_user" rows="3" cols="100"><?php echo $v['nip_user']; ?></textarea>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <?php
        endforeach;
        ?>
      </div>          
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-danger">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>