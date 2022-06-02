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
	        <b>EDIT RIWAYAT POKJA</b><br />
	        <?php echo $this->mpegawai->getnama($nip).' ::: '.$nip; ?>
        </div>
        
        <form method='POST' action='../pegawai/editrwypokja_aksi'>
		    <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
		    <input type='hidden' name='id' id='id' maxlength='18' value='<?php echo $id; ?>'> 
		    	<table class="table table-condensed table-hover">

	        <tr>
	          <td width='160' align='right'>Nama :</td>
	          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Pokja :</td>
	          <td>
	          	
	          	<select name="nm_pokja">
	          	<option value="0">Pilih Pokja</option>
	          		<?php
	          			$getpokja = $this->mpegawai->getrefpokja();
	          			foreach($getpokja as $p) {
		          			if($p['id_pokja'] == $detailrwypokja[0]['fid_pokja']) {
		          				echo "<option value='".$p['id_pokja']."' selected>".$p['nama_pokja']."</option>";
		          			} else {
		          				echo "<option value='".$p['id_pokja']."'>".$p['nama_pokja']."</option>";
		          			}
	          			}
	          		?>
	          	</select>
	    
	          </td>
	        </tr>
	        
	        <tr>
          		<td align='right'>TMT Awal :</td>
          		<td><input type="date" value="<?= $detailrwypokja[0]['tmt_awal'] ?>" name="tmt_awal" size='15' maxlength='10' required /></td>
        	</tr>
        	<tr>
        		<td align='right'>TMT Akhir:</td>
          		<td><input type="date" value="<?= $detailrwypokja[0]['tmt_akhir'] ?>" name="tmt_akhir" size='15' maxlength='10' required /></td>
        	</tr>
	        <tr bgcolor="orange">
	          <td align='right'>Nomor SK :</td>
	          <td><input type="text" value="<?= $detailrwypokja[0]['no_sk'] ?>" name="no_sk" size='50' maxlength='200' required /></td>
	        </tr>
	        
	        <tr bgcolor="orange">
	          <td align='right'>Pejabat SK :</td>
	          <td><input type="text" value="<?= $detailrwypokja[0]['pejabat_sk'] ?>" name="pejabat_sk" size='50' maxlength='200' required /></td>
	        </tr>
	        
	        <tr bgcolor="orange">
          		<td align='right'>Tgl. SK :</td>
          		<td>  <input type="date" value="<?= $detailrwypokja[0]['tgl_sk'] ?>" name="tgl_sk"  size='15' maxlength='10' required /></td>
        	</tr>
	        
	        <tr>
	          <td align='right' colspan='2'>
	                <button type="submit" class="btn btn-success btn-sm">
	                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
	                </button>
	          </td>
	        </tr>
	      </table>
		    </form>
     
    </div>
    
    </div> <!-- end class="panel-body" -->
  </div>  <!-- end class="panel" -->
</center>