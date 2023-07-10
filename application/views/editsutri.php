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

      <form method='POST' name='formeditsutri' action='../pegawai/editsutri_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <input type='hidden' name='sutri_ke' id='sutri_ke' value='<?php echo $sutri_ke; ?>'>
      <input type='hidden' name='tgl_nikah_lama' id='tgl_nikah_lama' value='<?php echo $tgl_nikah; ?>'>

      <?php      
          $jnskel = $this->mpegawai->getjnskel($nip);
          if ($jnskel == 'LAKI-LAKI') {
            $ketsutri = "Istri";
          } else if ($jnskel == 'PEREMPUAN') {
            $ketsutri = "Suami";
          }
      ?>
      <div class="panel panel-info">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <b>Edit Data <?php echo $ketsutri; ?></b><br />
        <?php echo $this->mpegawai->getnama($nip).' ::: '.$nip; ?>
        </div>

        <?php
          foreach($sutri as $v):
        ?>
        <table class="table table-condensed table-hover">        
          <tr>
            <td align='right' width='150'>Nama <?php echo $ketsutri; ?> :</td>
            <td colspan='3'><input type="text" name="namasutri" size='40' maxlength='50' value='<?php echo $v['nama_sutri']; ?>' required /></td>
          </tr>
          <tr>
            <td align='right'>Tempat Lahir :</td>
            <td><input type="text" name="tmplahir" size='30' maxlength='30' value='<?php echo $v['tmp_lahir']; ?>' required /></td>        
            <td align='right' width='150'>Tanggal Lahir :</td>
            <td colspan='3'><input type="text" name="tgllahir" class="tanggal" size='15' maxlength='10' value='<?php echo tgl_sql($v['tgl_lahir']); ?>' required /></td>
          </tr>
          <tr>
            <td align='right'>Akta Nikah :</td>
            <td><input type="text" name="aktanikah" size='30' maxlength='100' value='<?php echo $v['no_akta_nikah']; ?>' required /></td>
            <td align='right'>Tanggal Nikah :</td>
            <td colspan='3'><input type="text" name="tglnikah" class="tanggal" size='15' maxlength='10' value='<?php echo tgl_sql($v['tgl_nikah']); ?>' required /></td>
          </tr>
          <tr>
            <td align='right'>Pekerjaan :</td>
            <td colspan='3'>
              <select name="pekerjaan" id="pekerjaan" required >
                <?php
                  if ($v['pekerjaan'] == 'PEGAWAI NEGERI') {
                    echo "<option value='PEGAWAI NEGERI' selected>PEGAWAI NEGERI</option>";
                    echo "<option value='PEGAWAI SWASTA'>PEGAWAI SWASTA</option>";
                    echo "<option value='WIRASWASTA'>WIRASWASTA</option>";
                    echo "<option value='HONORER'>HONORER</option>";
                    echo "<option value='RUMAH TANGGA'>RUMAH TANGGA</option>";
                  } else if ($v['pekerjaan'] == 'PEGAWAI SWASTA') {
                    echo "<option value='PEGAWAI NEGERI'>PEGAWAI NEGERI</option>";
                    echo "<option value='PEGAWAI SWASTA' selected>PEGAWAI SWASTA</option>";
                    echo "<option value='WIRASWASTA'>WIRASWASTA</option>";
                    echo "<option value='HONORER'>HONORER</option>";
                    echo "<option value='RUMAH TANGGA'>RUMAH TANGGA</option>";
                  }  else if ($v['pekerjaan'] == 'WIRASWASTA') {
                    echo "<option value='PEGAWAI NEGERI'>PEGAWAI NEGERI</option>";
                    echo "<option value='PEGAWAI SWASTA'>PEGAWAI SWASTA</option>";
                    echo "<option value='WIRASWASTA' selected>WIRASWASTA</option>";
                    echo "<option value='HONORER'>HONORER</option>";
                    echo "<option value='RUMAH TANGGA'>RUMAH TANGGA</option>";
                  }  else if ($v['pekerjaan'] == 'HONORER') {
                    echo "<option value='PEGAWAI NEGERI'>PEGAWAI NEGERI</option>";
                    echo "<option value='PEGAWAI SWASTA'>PEGAWAI SWASTA</option>";
                    echo "<option value='WIRASWASTA'>WIRASWASTA</option>";
                    echo "<option value='HONORER' selected>HONORER</option>";
                    echo "<option value='RUMAH TANGGA'>RUMAH TANGGA</option>";
                  }  else if ($v['pekerjaan'] == 'RUMAH TANGGA') {
                    echo "<option value='PEGAWAI NEGERI'>PEGAWAI NEGERI</option>";
                    echo "<option value='PEGAWAI SWASTA'>PEGAWAI SWASTA</option>";
                    echo "<option value='WIRASWASTA'>WIRASWASTA</option>";
                    echo "<option value='HONORER'>HONORER</option>";
                    echo "<option value='RUMAH TANGGA' selected>RUMAH TANGGA</option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td align='right'>Status :</td>
            <td>
              <select name="statuskawin" id="statuskawin" required >
                <?php
                  if (($v['status_kawin'] == 'MENIKAH') OR ($v['status_kawin'] == '')) {
                    echo "<option value='MENIKAH' selected>MENIKAH</option>";
                    echo "<option value='JANDA/DUDA'>JANDA / DUDA</option>";
                  } else if ($v['status_kawin'] == 'JANDA/DUDA') {
                    echo "<option value='MENIKAH'>MENIKAH</option>";
                    echo "<option value='JANDA/DUDA' selected>JANDA / DUDA</option>";
                  } 
                ?>
              </select>
            </td>
            <td align='right'>Status Hidup :</td>
            <?php
            if ($v['status_hidup'] == 'YA') {
              echo "
            <td><input id='statushidup' name='statushidup' type='checkbox' value='YA' checked='checked'></td>";
            } else {
              echo "
            <td><input id='statushidup' name='statushidup' type='checkbox' value='YA'></td>";
            }
            ?>	
	    <td align='right'>Tanggungan :</td>
            <?php
            if ($v['tanggungan'] == 'YA') {
              echo "
            <td><input id='tanggungan' name='tanggungan' type='checkbox' value='YA' checked='checked'></td>";
            } else {
              echo "
            <td><input id='tanggungan' name='tanggungan' type='checkbox' value='YA'></td>";
            }
            ?>

          </tr>
          <tr>
            <td align='right'>NIP <?php echo $ketsutri; ?> (Jika PNS):</td>
            <td><input type="text" name="nipsutri"  size='25' maxlength='18' value='<?php echo $v['nip_sutri']; ?>' /></td>
            <td align='right' colspan='2'>No. Kartu <?php echo $ketsutri; ?> :</td>
            <td colspan='2'><input type="text" name="nokarisu" size='20' maxlength='15' value='<?php echo $v['no_karisu']; ?>' /></td>
          </tr>
          <tr>
            <td align='right'>Tanggal Cerai :</td>
	    <?php
		if ($v['tgl_cerai'] == '') {
	    		$tgl_cerai = '';
	 	} else {
			$tgl_cerai = tgl_sql($v['tgl_cerai']);
		}

		if ($v['tgl_meninggal'] == '') {
                        $tgl_meninggal = '';
                } else {
                        $tgl_meninggal = tgl_sql($v['tgl_meninggal']);
                }
	    ?>
            <td><input type="text" name="tglcerai" class="tanggal" size='15' maxlength='10' value='<?php echo $tgl_cerai; ?>'/></td>
            <td align='right' colspan='2'>No. Akta Cerai :</td>
            <td colspan='2'><input type="text" name="aktacerai" size='40' maxlength='50' value='<?php echo $v['no_akta_cerai']; ?>' /></td>
          </tr>        
          <tr>
            <td align='right'>Tanggal Meninggal :</td>
            <td><input type="text" name="tglmeninggal" class="tanggal" size='15' maxlength='10' value='<?php echo $tgl_meninggal; ?>' /></td>
            <td align='right' colspan='2'>No. Akta Meninggal :</td>
            <td colspan='2'><input type="text" name="aktameninggal" size='40' maxlength='50' value='<?php echo $v['no_akta_meninggal']; ?>' /></td>
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
