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
        echo "<form method='POST' action='../pppk/rwydik'>";          
        echo "<input type='hidden' name='nipppk' id='nipppk' value='$nipppk'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>
	
      <form method='POST' name='formeditdiktek' action='../pppk/editws_aksi'>
      <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
      <input type='hidden' name='no' id='no' value='<?php echo $no; ?>'>
      <input type='hidden' name='tahun_lama' id='tahun_lama' value='<?php echo $tahun; ?>'>

      <div class="panel panel-info">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <b>EDIT PENGEMBANGAN KOMPETENSI LAINNYA</b><br />
        <?php echo $this->mpppk->getnama_lengkap($nipppk).' ::: '.$nipppk; ?>
        </div>
        <?php
          foreach($diktek as $v):
        ?>
      <table class="table table-condensed">
        <tr>
          <td align='right'>Jenis :</td>
          <td>
		<select name="fid_jenis" id="fid_jenis" required >
		<?php
		if ($v['fid_jenis_workshop'] == 0) {
                       echo "<option value='' selected>-- Pilih Jenis --</option>";
                }     
                $jnsw = $this->mpegawai->jenis_workshop()->result_array();
                foreach($jnsw as $jw) {
		     if ($jw['id_jenis_workshop'] == $v['fid_jenis_workshop']) {		
                       echo "<option value='".$jw['id_jenis_workshop']."' selected>".$jw['nama_jenis_workshop']."</option>";
		     } else {
		       echo "<option value='".$jw['id_jenis_workshop']."'>".$jw['nama_jenis_workshop']."</option>";
		     } 	
                }
		?>
		</select>
	  </td>
        </tr>
        <tr>
          <td align='right'>Rumpun :</td>
          <td>
                <select name="fid_rumpun" id="fid_rumpun" required >
                <?php
                if ($v['fid_rumpun_diklat'] == 0) {
                       echo "<option value='' selected>-- Pilih Rumpun --</option>";
                }
                $jnsrd = $this->mpegawai->rumpun_diklat()->result_array();
                foreach($jnsrd as $rd) {
                     if ($rd['id_rumpun_diklat'] == $v['fid_rumpun_diklat']) {
                       echo "<option value='".$rd['id_rumpun_diklat']."' selected>".$rd['nama_rumpun_diklat']."</option>";
                     } else {
                       echo "<option value='".$rd['id_rumpun_diklat']."'>".$rd['nama_rumpun_diklat']."</option>";
                     }
                }
                ?>
                </select>
          </td>
        </tr>
        <tr>
          <td align='right'>Nama Seminar / Workshop :</td>
          <td><input type="text" name="namaws" size='80' maxlength='200' value='<?php echo $v['nama_workshop']; ?>' required /></td>
        </tr>
        <tr>
          <td align='right'>Tahun :</td>
          <td><input type="text" name="tahun" size="10" onkeyup="validAngka(this)" maxlength="4" value='<?php echo $v['tahun']; ?>' required /></td>
        </tr>
        <tr>
          <td align='right'>Instansi Penyelenggara :</td>
          <td><input type="text" name="penyelenggara" size='50' maxlength='200' value='<?php echo $v['instansi_penyelenggara']; ?>'required /></td>
        </tr>
        <tr>
          <td align='right'>Tempat :</td>
          <td><input type="text" name="tempat" size='40' maxlength='200' value='<?php echo $v['tempat']; ?>' required /></td>
        </tr>
        <tr>
          <td align='right'>Tgl. Pelaksanaan :</td>
	  <?php
	      if ($v['tanggal'] != null) {
                $tgl = tgl_sql($v['tanggal']);
              } else if ($v['lama_hari'] == 0) {
                $tgl = '';
              }
	  ?>
          <td><input type="text" name="tgl" class="tanggal" size='15' maxlength='10' value='<?php echo $tgl; ?>' required /></td>
        </tr> 
        <tr>
          <td align='right'>Lama :</td>
          <td>
            <?php
              if ($v['lama_bulan'] != 0) {
                $lama = $v['lama_bulan'];
              } else if ($v['lama_hari'] != 0) {
                $lama = $v['lama_hari'];
              } else if ($v['lama_jam'] != 0) {
                $lama = $v['lama_jam'];
              } else {
		$lama = 0;
	      }
		
            ?>
            <input type="text" name="lama" size='5' onkeyup="validAngka(this)" value='<?php echo $lama; ?>' maxlength='3' />

            <select name="satuan_lama" id="satuan_lama" required >
            <?php
              if ($v['lama_bulan'] != 0) {
                $lama = $v['lama_bulan'];
                echo "<option value='BULAN' selected>BULAN</option>";
                echo "<option value='HARI'>HARI</option>";
                echo "<option value='JAM'>JAM</option>";
              } else if ($v['lama_hari'] != 0) {
                $lama = $v['lama_hari'];
                echo "<option value='BULAN'>BULAN</option>";
                echo "<option value='HARI' selected>HARI</option>";
                echo "<option value='JAM'>JAM</option>";
              } else if ($v['lama_jam'] != 0) {
                $lama = $v['lama_jam'];
                echo "<option value='BULAN'>BULAN</option>";
                echo "<option value='HARI'>HARI</option>";
                echo "<option value='JAM' selected>JAM</option>";
              } else {
		echo "<option value=''>-- Pilih Satuan --</option>";
		echo "<option value='BULAN'>BULAN</option>";
                echo "<option value='HARI'>HARI</option>";
                echo "<option value='JAM'>JAM</option>";
	      }	
            ?>
          </select>
          </td>
        </tr>
        <tr>
          <td rowspan='3' align='right'>Surat Keputusan :</td>
          <td>Pejabat&nbsp <input type="text" name="pejabatsk" size='50' maxlength='200' value='<?php echo $v['pejabat_sk']; ?>' required /></td>
        </tr>
        <tr>
          <td>No. SK&nbsp&nbsp   <input type="text" name="nosk" size='30' maxlength='100' value='<?php echo $v['no_sk']; ?>' required /></td>
        </tr>
        <tr>
	<?php
	  if ($v['tgl_sk'] != null) {
            $tglsk = tgl_sql($v['tgl_sk']);
          } else {
            $tglsk = '';
          }
	?>

          <td>Tgl. SK&nbsp&nbsp  <input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' value='<?php echo $tglsk; ?>' required /></td>
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
