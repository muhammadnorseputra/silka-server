<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
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
  <div class='panel panel-default' style="width: 55%; background-color:Beige;">
    <div class='panel-body'>
      <form method='POST' action='../kgb/tampilpengantar'>
        <!--<input type='text' name='nip' id='nip' maxlength='18' value='$nip'>-->
        <p align='right'>
          <button type='submit' class='btn btn-warning btn-sm'>&nbsp
          <span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      </form>

      <form method='POST' action='../kgb/editpengantar_aksi'>
        <div class='panel panel-success'>
          <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          <b>EDIT PENGANTAR KENAIKAN GAJI BERKALA</b>
          </div>
          <?php
            foreach($kgb as $v):
          ?>
          <table class='table'>
            <tr>
              <td align='center'>
                <table class='table table-condensed'>
                  <tr>                    
                    <input type='hidden' name='idpengantar' value='<?php echo $v['id_pengantar']; ?>' required />
                    <input type='hidden' name='nopengantar_lama' value='<?php echo $v['no_pengantar']; ?>' required />
                    <td align='right' width='250'>No. Pengantar :</td>
                    <td><input type="text" name="nopengantar" size='30' maxlength='100' value="<?php echo $v['no_pengantar']; ?>" required /></td>
                  </tr>
                  <tr>
                    <td align='right'>Tanggal Pengantar :</td>
                    <td><input type='text' name='tglpengantar' class='tanggal' value='<?php echo tgl_sql($v['tgl_pengantar']); ?>' required /></td>
                  </tr>
                  <tr>
                    <td align='right'>Unit Kerja :</td>
                    <td>
                    <?php
                      echo '<b>'.$this->munker->getnamaunker($v['fid_unit_kerja']).'</b>';
                    ?>
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
        <p align='right'>
          <button type='submit' class='btn btn-success btn-sm'>
          <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
          </button>
        </p>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>

<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class='alert alert-dismissible alert-danger'>
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>