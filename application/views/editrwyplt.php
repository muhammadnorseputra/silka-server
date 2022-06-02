
<center>  
  <div class="panel panel-default" style="width: 60%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/rwyjab'>";          
        echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

	<div class="panel panel-info">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <b>EDIT RIWAYAT PLT / PLH</b><br />
        <?php echo $this->mpegawai->getnama($nip).' ::: '.$nip; ?>
        </div>
        
        <form method='POST' action='../pegawai/editrwyplt_aksi'>
	    <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
	    <input type='hidden' name='id' id='id' maxlength='18' value='<?php echo $id; ?>'> 
	           <table class="table table-condensed table-hover">

	        <tr>
	          <td width='160' align='right'>Nama :</td>
	          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Jenis Jabatan :</td>
	          <td>
	          	<?php 
	          		if($detailrwyplt[0]['jns_jabatan'] == 'Plt') {
	          			echo '<input type="radio" name="jns_jab" value="Plt" checked="checked"> Plt
	          				  <input type="radio" name="jns_jab" value="Plh"> Plh';
	          		} else {
	          			echo '<input type="radio" name="jns_jab" value="Plt"> Plt
	          				  <input type="radio" name="jns_jab" value="Plh" checked="checked"> Plh';
	          		}
	          	?>
	          	
	          </td>
	        </tr>
	        
	        <tr>
	          <td align='right'>UnitKerja :</td>
	          <td>
	          	<select name="unitkerja" onchange="pilihunker()">
	          	<option value="0">Pilih Unit Kerja</option>
	          		<?php
	          			$getunker = $this->mpegawai->getunitkerja();
	          			foreach($getunker as $u) {
		          			if($u['nama_unit_kerja'] == $detailrwyplt[0]['unit_kerja']) {
		          				echo "<option value='".$u['nama_unit_kerja']."' selected>".$u['nama_unit_kerja']."</option>";
		          			} else {
		          				echo "<option value='".$u['nama_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
		          			}
	          			}
	          		?>
	          	</select>
	          </td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Jabatan :</td>
	          <td>
	          
	          	<!--<input type="text" name="jabatan" size='70' value="<?= $detailrwyplt[0]['jabatan'] ?>" maxlength='200' required />-->
	          <select name="jabstruk" onchange="pilihjabatan(this.value)">
	          <option value="0">Pilih Jabatan Struktural</option>
	          <?php
	          	$getjabstruk = $this->mpegawai->getjabstruk($detailrwyplt[0]['unit_kerja']);
	          	foreach($getjabstruk as $s) {
	          		if($s['id_jabatan'] == $detailrwyplt[0]['fid_jabstruk']){
						echo "<option value='".$s['id_jabatan']."-".$s['nama_jabatan']."' selected>".$s['nama_jabatan']."</option>";
					} else {
						echo "<option value='".$s['id_jabatan']."-".$s['nama_jabatan']."'>".$s['nama_jabatan']."</option>";
					}
				}	
	          ?>		
	          </select>
	          	
	          </td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Eselon :</td>
	          <td>
	          	<select name="eselon">
	          		<option value="0">Pilih Eselon</option>
	          		<?php
	          			$geteselon = $this->mpegawai->geteselon();
	          			foreach($geteselon as $e) {
	          				if($e['id_eselon'] == $detailrwyplt[0]['fid_eselon']) {
	          					echo "<option value='".$e['id_eselon']."' selected>".$e['nama_eselon']."</option>";
	          				} else {
	          					echo "<option value='".$e['id_eselon']."'>".$e['nama_eselon']."</option>";
	          				}
	          			}
	          		?>
	          	</select>
			<p class="help-block">(eselon automatis dipilih, berdasarkan jabatan yang di pilih)</p>
	          </td>
	        </tr>
	       
	        <tr>
          		<td align='right'>TMT Awal :</td>
          		<td><input type="text" name="tmt_awal" class="tmt_awal" value="<?= $detailrwyplt[0]['tmt_awal'] ?>" size='15' maxlength='10' required /></td>
        	</tr>
        	<tr>
        		<td align='right'>TMT Akhir:</td>
          		<td><input type="text" name="tmt_akhir" class="tmt_akhir" value="<?= $detailrwyplt[0]['tmt_akhir'] ?>" size='15' maxlength='10' required /></td>
        	</tr>
	        <tr bgcolor="pink">
	          <td align='right'>Nomor SK :</td>
	          <td><input type="text" name="nosk" size='50'  value="<?= $detailrwyplt[0]['no_sk'] ?>" maxlength='200' required /></td>
	        </tr>
	        <tr bgcolor="pink">
          		<td align='right'>Tgl. SK :</td>
          		<td>  <input type="text" name="tglsk" class="tgl_sk"  value="<?= $detailrwyplt[0]['tgl_sk'] ?>" size='15' maxlength='10' required /></td>
        	</tr>
	        
	        <tr bgcolor="pink">
	          <td align='right'>Pejabat SK :</td>
	          <td><input type="text" name="pejabatsk" size='50'  value="<?= $detailrwyplt[0]['pejabat_sk'] ?>" maxlength='200' required /></td>
	        </tr>
	        <tr>
	          <td align='right' colspan='2'>
	                <button type="submit" class="btn btn-success btn-sm">
	                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspUpdate
	                </button>
	          </td>
	        </tr>
	      </table>
        </form>
        
    </div>
    
    </div> <!-- end class="panel-body" -->
  </div>  <!-- end class="panel" -->
</center>

<script>
	        
function pilihunker() {
	var id = $("[name = 'unitkerja']").val();
	$.get('<?= base_url("pegawai/getjab/") ?>',{unker: id}, function(result){
		$("[name = 'jabstruk']").html(result);
	});
	pilihjabatan("0");
}


function pilihjabatan(id) {
        var pecah_str = id.split("-");
        var ids       = pecah_str[0];
        $.getJSON('<?= base_url("pegawai/geteselon_byjabatan/") ?>', {id: ids}, function(result) {
                $("select[name='eselon']").val(result);
        });
}

</script>
