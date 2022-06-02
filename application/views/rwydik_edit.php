<div class="container">
	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
			<form method='POST' action='../pegawai/rwydik'>
	          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
	          <button type="submit" class="btn btn-danger btn-sm">
	          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Batal
	          </button>
	      </form>
	      <br>
	      <?= form_open(base_url('pegawai/edit_dik_aksi'), ['id' => 'f_editdik', 'class' => 'form-horizontal'], ['nip' => $nip, 'id' => $row->id]); ?>
      		<div class="col-md-2">
		        <div class="form-group">
				    <label for="jns_dik">Pilih Jenis Diklat</label>
				    <select class="form-control" name="jenis_diklat">
				    	<option value="">-- Jenis Diklat --</option>
				    	<?php foreach($jenis_dik_jst as $j): ?>
				    	<?php $selected = $j->id_diklat_struktural == $row->fid_diklat_struktural ? 'selected' : ''; ?>
				    	<option value="<?= $j->id_diklat_struktural ?>" <?= $selected ?>><?= $j->nama_diklat_struktural ?></option>	
				    	<?php endforeach; ?>
				    </select>
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="tahun_pelaksanaan">Tahun Pelaksanaan</label>
				    <input value="<?= $row->tahun ?>" class="form-control" type="number" id="tahun_pelaksanaan" name="tahun_pelaksanaan" placeholder="Tahun Pelaksanaan">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="col-md-8">
		        <div class="form-group">
				    <label for="instansi_dik">Instansi Penyelenggara</label>
				    <input value="<?= $row->instansi_penyelenggara ?>" class="form-control" type="text" id="instansi_dik" name="intansi_penyelenggara" placeholder="Instansi Penyelenggara">
				  </div>
			  </div>
			  <div class="col-md-3" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="tempat_pelaksanaan">Tempat Pelaksanaan</label>
				    <input value="<?= $row->tempat ?>"  class="form-control" type="text" id="tempat_pelaksanaan" name="tempat_pelaksanaan" placeholder="Tempat Pelaksanaan">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="col-md-2">
		        <div class="form-group">
				    <label for="bulan">Bulan</label>
				    <input value="<?= $row->lama_bulan ?>"  class="form-control" type="number" id="bulan" name="bulan" placeholder="Bulan">
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="hari">Hari</label>
				    <input value="<?= $row->lama_hari ?>"  class="form-control" type="number" id="hari" name="hari" placeholder="Hari">
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="jam">Jam</label>
				    <input value="<?= $row->lama_jam ?>"  class="form-control" type="number" id="jam" name="jam" placeholder="Jam">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <hr>
			  <div class="col-md-3">
		        <div class="form-group">
				    <label for="pejabat">Pejabat</label>
				    <input value="<?= $row->pejabat_sk ?>"  class="form-control" type="text" id="pejabat" name="pejabat" placeholder="Pejabat">
				  </div>
			  </div>
			  <div class="col-md-6" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="nomor">Nomor</label>
				    <input value="<?= $row->no_sk ?>"  class="form-control" type="text" id="nomor" name="nomor" placeholder="Nomor">
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="tgl">Tanggal</label>
				    <input value="<?= $row->tgl_sk ?>"  class="form-control" type="date" id="tgl" name="tgl" placeholder="Tanggal">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <button type="submit" role="button" class="btn btn-lg btn-success">Update</button>
      	<?= form_close(); ?>
      </div>
	</div>
</div>