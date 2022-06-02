<div class="container">
	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
		<form method='POST' action='../pegawai/rwypdk'>
          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
          <button type="submit" class="btn btn-danger btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Batal
          </button>
      </form>
      <br>
			<?= form_open(base_url('pegawai/edit_pdk_aksi'), ['id' => 'f_editpdk', 'class' => 'form-horizontal'], ['nip' => $nip, 'id' => $row->id]); ?>
			 <div class="panel panel-info">
				<div class="panel-heading">
					<h4>Edit Riwayat Pendidikan</h4>
					<?= $this->mpegawai->getnama($nip); ?> - <?= $nip ?>
				</div>
				<div class="panel-body">
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-1 col-lg-2">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="gd">Gelar Depan</label>
			        			<input name="gd" value="<?= $row->gelar_dpn ?>" type="text" class="form-control" placeholder="Ex: Drs.">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-1 col-lg-2">
			        		<div class="form-group">
			        			<label for="gb">Gelar Belakang</label>
			        			<input name="gb" value="<?= $row->gelar_blk ?>" type="text" class="form-control" placeholder="Ex: S.Kom">
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-3">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="tp">Tingkat Pendidikan</label>
			        			<select name="tp" id="tp" class="form-control">
			        				<option value="">Pilih Tingkat Pendidikan</option>
			        				<?php 
			        					foreach($tingpen as $tp):
			        					$sel = $tp->id_tingkat_pendidikan === $row->fid_tingkat ? 'selected' : ''; 
			        				?>	
			        					<option value="<?= $tp->id_tingkat_pendidikan ?>" <?= $sel ?>><?= $tp->nama_tingkat_pendidikan ?></option>
			        				<?php endforeach; ?>
			        			</select>
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-6">
			        		<div class="form-group">
			        			<label for="jp">Jurusan Pendidikan</label>
			        			<select name="jp"  id="jp" class="form-control">
			        				<option value="">Pilih Jurusan Pendidikan</option>
			        			</select>
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
		        
		        <hr>
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-7">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="nama_sekolah">Nama Sekolah</label>
			        			<input name="nama_sekolah" value="<?= $row->nama_sekolah ?>" type="text" class="form-control" placeholder="Ex: STIMIK INDONESIA JAKARTA">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-2">
			        		<div class="form-group">
			        			<label for="tahun_lulus">Tahun Lulus</label>
			        			<input name="tahun_lulus" value="<?= $row->thn_lulus ?>" type="number" size="4" maxlength="4" class="form-control" placeholder="Ex: 2021">
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-4">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="nama_kepsek">Nama Kepsek</label>
			        			<input name="nama_kepsek" value="<?= $row->nama_kepsek ?>" type="text" class="form-control" placeholder="Ex: Putra">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-3">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="no_sttb">No. STTB</label>
			        			<input name="no_sttb" value="<?= $row->no_sttb ?>" type="text" class="form-control" placeholder="Ex: 0001/01/stimik/indonesia/2021">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-2">
			        		<div class="form-group">
			        			<label for="tgl_sttb">Tanggal. STTB</label>
			        			<input name="tgl_sttb" value="<?= $row->tgl_sttb ?>" type="date" class="form-control" placeholder="Ex: 27/05/1999">
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
				</div>
				<div class="panel-footer">
	      		<button type="submit" class="btn btn-primary">Update & Simpan Perubahan</button>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<style>
.select2-container .select2-selection--single {
	height: 40px !important;
	font-weight: bold;
	font-size: 18px;
}
</style>
<script>
	$(function() { 
		$("#tp,#jp").select2({
			width: "100%",
			dropdownParent: $('body')
		});
			
		var $id_tp = "<?= $row->fid_tingkat ?>";
		var $id_jp = "<?= $row->fid_jurusan ?>";
		
		list_jp($id_tp);
		
		
		$("select[name='jp']").html(`<option value="">Pilih Jurusan Pendidikan</option>`);
		
		var $select_tp = $("select[name='tp']");
		$select_tp.on("change", function(e) {
			e.preventDefault();
			var $this = $(this);
			$id_tp = $this.val();
			list_jp($id_tp);
		});
		
		function list_jp($id) {
			$.getJSON(`<?= base_url("pegawai/list_jurusan_pendidikan") ?>`, {id: $id, id_jurpen: $id_jp}, function(res) {
				$("select[name='jp']").html(res);
			});
		}
	});
</script>
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
