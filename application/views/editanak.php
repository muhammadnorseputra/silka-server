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

  //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
 
</script>

<center>  
  <div class="panel panel-default" style="width: 60%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/rwykel'>";          
        echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formeditsutri' action='../pegawai/editanak_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <input type='hidden' name='nama_anak_lama' id='nama_anak_lama' value='<?php echo $nama_anak; ?>'>
      <input type='hidden' name='tgl_lahir_lama' id='tgl_lahir_lama' value='<?php echo $tgl_lahir; ?>'>

      <?php
      $jnskel = $this->mpegawai->getjnskel($nip);
        if ($jnskel == 'LAKI-LAKI') {
          $ketibubapak = "Ibu";
        } else if ($jnskel == 'PEREMPUAN') {
          $ketibubapak = "Bapak";
        }
      ?>

      <div class="panel panel-info">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <b>Edit Data Anak</b><br />
        <?php echo $this->mpegawai->getnama($nip).' ::: '.$nip; ?>
        </div>

        <?php
          foreach($anak as $v):
        ?>
          <table class="table table-condensed table-hover">        
          <tr>
            <td align='right' width='150'>Nama Anak :</td>
            <td colspan='3'><input type="text" name="namaanak" size='40' maxlength='50' value='<?php echo $v['nama_anak']; ?>' required /></td>
          </tr>
          <tr>
            <td align='right'>Tempat Lahir :</td>
            <td><input type="text" name="tmplahir" size='30' maxlength='30' value='<?php echo $v['tmp_lahir']; ?>' required /></td>        
            <td align='right' width='150'>Tanggal Lahir :</td>
            <td><input type="text" name="tgllahir" class="tanggal" size='15' maxlength='10' value='<?php echo tgl_sql($v['tgl_lahir']); ?>' required /></td>
          </tr>
          <tr>
            <td align='right'>Nama <?php echo $ketibubapak; ?> :</td>
            <td>          
            <select name="sutri_ke" id="sutri_ke" required >
              <?php
                $ibubapak = $this->mpegawai->getibubapak($nip)->result_array();
                foreach($ibubapak as $ib)
                {
                  if ($v['fid_sutri_ke']==$ib['sutri_ke']) {
                    echo "<option value='".$ib['sutri_ke']."' selected>".$ib['nama_sutri']."</option>";
                  } else {
                    echo "<option value='".$ib['sutri_ke']."'>".$ib['nama_sutri']."</option>";
                  }
                }
              ?>
            </select>
            </td>
            <td align='right'>Jenis Kelamin :</td>
            <td>
               <select name="jnskel" id="jnskel" required >
                <?php
                  if (($v['jns_kelamin'] == 'PRIA') OR ($v['jns_kelamin'] == '')) {
                    echo "<option value='PRIA' selected>PRIA</option>";
                    echo "<option value='WANITA'>WANITA</option>";
                  } else if ($v['jns_kelamin'] == 'WANITA') {
                    echo "<option value='PRIA'>PRIA</option>";
                    echo "<option value='WANITA' selected>WANITA</option>";
                  } 
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td align='right'>Status Anak :</td>
            <td colspan='3'>
              <select name="status" id="status" required >
              <?php
                  if (($v['status'] == 'KANDUNG') OR ($v['status'] == '')) {
                    echo "<option value='KANDUNG' selected>KANDUNG</option>";
                    echo "<option value='TIRI'>TIRI</option>";
                    echo "<option value='ANGKAT'>ANGKAT</option>";
                  } else if ($v['status'] == 'TIRI') {
                    echo "<option value='KANDUNG'>KANDUNG</option>";
                    echo "<option value='TIRI' selected>TIRI</option>";
                    echo "<option value='ANGKAT'>ANGKAT</option>";
                  } else if ($v['status'] == 'ANGKAT') {
                    echo "<option value='KANDUNG'>KANDUNG</option>";
                    echo "<option value='TIRI'>TIRI</option>";
                    echo "<option value='ANGKAT' selected>ANGKAT</option>";
                  } 
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td align='right'>Status Hidup :</td>
            <?php
              if ($v['status_hidup'] == 'YA') {
                echo "<td colspan='3'><input id='statushidup' name='statushidup' type='checkbox' value='YA' checked='checked'></td>";
              } else {
                echo "<td colspan='3'><input id='statushidup' name='statushidup' type='checkbox' value='YA'></td>";
              }
              ?>
          </tr>        
        </table>
      </div> <!-- end class="panel-info" -->
      <p align="right">          
          <button type='submit' class='btn btn-success btn-sm'>
          <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
          </button>
        </p>
      </form>
      <?php
        endforeach;
      ?>
    </div> <!-- end class="panel-body" -->
  </div>  <!-- end class="panel" -->
</center>