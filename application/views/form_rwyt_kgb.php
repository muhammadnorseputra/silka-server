<center>  
  <div class="panel panel-default" style="width: 60%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../rwykgb'>";          
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
	        <b>TAMBAH RIWAYAT KGB</b><br />
	        <?php echo $this->mpegawai->getnama($nip).' ::: '.$nip; ?>
        </div>
        
        <form method='POST' action='../tambah_rwy_kgb_aksi'>
		    <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
		    	<table class="table table-condensed table-hover">

	        <tr>
	          <td width='160' align='right'>Nip</td>
	          <td><input type="text" name="nip" disabled value="<?= $nip ?>"></td>
	        </tr>
	        
	        
	        <tr>
	          <td width='160' align='right'>Golru</td>
	          <td>
	          	<select name="golru">
	          	<option value="">-- Pilih Golru --</option>
	          		<?php 
	          			$db = $this->mpegawai->golru();
	          			if($db->num_rows() > 0) {
	          				foreach($db->result() as $g):
	          					echo '<option value="'.$g->id_golru.'">'.$g->nama_golru.'</option>';
	          				endforeach;
	          			}
	          		?>
	          	</select>
	          </td>
	        </tr>
	        
	        <tr>
	          <td width='160' align='right'>Gapok</td>
	          <td><input type="number" name="gapok" size="20"></td>
	        </tr>
	        
	        <tr>
	          <td align='right'>MK Tahun</td>
	          <td><input type="number" name="mk_tahun" size="8"></td>
	        </tr>
	      	
	      	<tr>
	          <td align='right'>MK Bulan</td>
	          <td><input type="number" name="mk_bulan" size="8"></td>
	        </tr>
	        
	      	<tr>
	          <td align='right'>TMT</td>
	          <td><input type="text" name="tmt" size="10"> / tahun - bln - tgl</td>
	        </tr>
	        
	        <tr bgcolor="pink">
	          <td width='160' align='right'><b>Pejabat SK</b></td>
	          <td><input type="text" name="pejabat_sk" size="50"></td>
	        </tr>
	        
	         <tr bgcolor="pink">
	          <td width='160' align='right'><b>Nomor SK</b></td>
	          <td><input type="text" name="no_sk" size="50"></td>
	        </tr>
	        
	        <tr bgcolor="pink">
	          <td align='right'><b>Tanggal SK</b></td>
	          <td><input type="text" name="tgl_sk" size="10"> / tahun - bln - tgl </td>
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