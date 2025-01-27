<div class="container" style="margin-top: 3rem;">
	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
			<form method='POST' action='../pegawai/rwyph'>
	          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
	          <button type="submit" class="btn btn-danger btn-sm">
	          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Batal
	          </button>
	      </form>
	      <br>
	      <?= form_open(base_url('pegawai/edit_tanhor_aksi'), ['id' => 'f_edittanhor', 'class' => 'form-horizontal'], ['nip' => $nip, 'id' => $row->id]); ?>
              <div class="row">
                <div class="container">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-right: 10px;">
                            <label for="jenis">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="">Pilih Jenis Penghargaan</option>
                                <?php 
                                    foreach($ref as $rj):
                                    $sel = $rj->id_jenis_tanhor === $row->fid_jenis_tanhor ? 'selected' : ''; 
                                ?>	
                                    <option value="<?= $rj->id_jenis_tanhor ?>" <?= $sel ?>><?= $rj->nama_jenis_tanhor ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> <!-- close -->
                </div> <!-- container -->
              </div>  <!-- row -->
              <div class="row">
            <div class="container">
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="nama_tanhor">Nama Penghargaan</label>
                  <input type="text" name="nama_tanhor" id="nama_tanhor" class="form-control" value="<?= $row->nama_tanhor ?>" placeholder="Nama Penghargaan" />
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
          <div class="row">
            <div class="container">
              <div class="col-md-1 col-lg-1">
                <div class="form-group" style="margin-right: 5px;">
                  <label for="tahun">Tahun</label>
                  <input type="year" name="tahun" id="tahun" class="form-control" placeholder="Tahun"  value="<?= $row->tahun ?>" maxlength="4" size="4"/>
                </div>
              </div>
              <div class="col-md-5 col-lg-5">
                <div class="form-group">
                  <label for="pejabat">Pejabat</label>
                  <input type="text" name="pejabat" id="pejabat" class="form-control" placeholder="Pejabat"  value="<?= $row->pejabat ?>"/>
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
          <div class="row">
            <div class="container">
              <div class="col-md-4 col-lg-4">
                <div class="form-group" style="margin-right: 5px;">
                  <label for="nomor">Nomor</label>
                  <input type="text" name="nomor" id="nomor" class="form-control" placeholder="Nomor Keppres" value="<?= $row->no_keppres ?>"/>
                </div>
              </div>
              <div class="col-md-2 col-lg-2">
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal"  value="<?= $row->tgl_keppres ?>"/>
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
			  <div class="clearfix"></div>
			  <button type="submit" role="button" class="btn btn-md btn-success">Update</button>
      	<?= form_close(); ?>
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
		$("#jenis").select2({
			width: "100%",
			dropdownParent: $('body')
		});
	});
</script>
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>