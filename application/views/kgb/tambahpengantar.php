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
  <div class='panel panel-default' style="width: 65%; background-color:Beige;">
    <div class='panel-body'>
      <form method='POST' action='../kgb/tampilpengantar'>
        <!--<input type='text' name='nip' id='nip' maxlength='18' value='$nip'>-->
        <p align='right'>
          <button type='submit' class='btn btn-warning btn-sm'>&nbsp
          <span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      </form>

      <form method='POST' action='../kgb/tambahpengantar_aksi'>

        <div class='panel panel-success'>
          <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
          <b>TAMBAH PENGANTAR KENAIKAN GAJI BERKALA</b>
          </div>

          <table class='table'>
            <tr>
              <td align='center'>
                <table class='table table-condensed'>
                  <tr>
                    <td align='right' width='250'>No. Pengantar :</td><td><input type="text" name="nopengantar" size='30' maxlength='100' required /></td>
                  </tr>
                  <tr>
                    <td align='right'>Tanggal Pengantar :</td>
                    <td><input type='text' name='tglpengantar' class='tanggal' value='<?php echo date('d-m-Y'); ?>' required /></td>
                  </tr>
                  <tr>
                    <td align='right'>Unit Kerja :</td>
                    <td>
                      <select name='id_unker' id='id_unker' required >
                        <?php
                        echo "<option value=''>- Pilih Unit Kerja -</option>";
                        foreach($unker as $uk)
                        {
                          echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
                        }
                        ?>
                      </select>
                    </td>
                  </tr> 
                </table>
              </td>
            </tr>
          </table>
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
