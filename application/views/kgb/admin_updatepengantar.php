<!-- untuk inputan hanya angka dengan javascript -->
<!--
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
-->
<script type="text/javascript">
            $(document).ready(function () {
                $('.tanggal').datepicker({
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                    clearBtn: true,
                    autoclose:true
                });
            });
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/admin_tampilupdatepengantar'>";          
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";     
        /*
        $created = $this->session->userdata('nip');
        echo $created;
        */
      ?>

      <form method='POST' action='../kgb/admin_updatepengantar_aksi'>
      <input type='hidden' name='id_pengantar' id='id_pengantar' maxlength='18' value='<?php echo $id_pengantar;?>'>

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>UPDATE PENGANTAR KGB</b>
        </div>
        <?php
          foreach($pengantar as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>                           
              <table class='table table-condensed'>
                <tr>
                  <td align='right' width='250'>No. Pengantar :</td>
                  <td><input type="text" name="nopengantar" value="<?php echo $v['no_pengantar']; ?>" size='30' maxlength='100' required /></td>
                </tr>
                <tr>
                  <td align='right'>Tanggal Pengantar :</td><td><input type="text" size='10' maxlength='10' name="tglpengantar" class="tanggal" value='<?php echo tgl_sql($v['tgl_pengantar']); ?>' required /></td>
                </tr>
                <tr>
                  <td align='right'>Unit Kerja :</td><td><input type="text" size='80' name="unker" value='<?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?>' Disabled /></td>
                </tr>   
                <tr>
                  <td align='right'>Status Pengantar :</td>
                  <td>
                    <select name="id_status" id="id_status" required />
                      <?php
                      foreach($statuspengantar as $sp)
                      {
                        if ($v['fid_status']==$sp['id_statuspengantarkgb']) {
                          echo "<option value='".$sp['id_statuspengantarkgb']."' selected>".$sp['nama_statuspengantarkgb']."</option>";
                        } else {
                          echo "<option value='".$sp['id_statuspengantarkgb']."'>".$sp['nama_statuspengantarkgb']."</option>";
                        }                        
                      }
                      ?>
                    </select>                         
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
