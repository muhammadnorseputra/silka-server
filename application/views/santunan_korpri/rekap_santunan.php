<div class="container">
  <div class="row">
    <div class="clearfix"></div>
    <section class="panel-table">
        <div class="panel panel-success">
						<div class="panel-heading">
              <b>REKAPITULASI SANTUNAN KORPRI</b> 
            </div>
            <div class="panel-body">
            	<div class="row">
					      <div class="col-lg-12 col-md-12">
						  <button type="button" class="btn btn-md btn-secondary" id="addSantunan"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
						  <hr>
					        <form method="post" name="filter" action="#" class="row">
								<div class="form-group col-md-2">
									<label for="tahun">Tahun</label>
									<input type="text" class="form-control" name="tahun" value="" id="tahun" placeholder="Year">
								</div>
								<div class="form-group col-md-3">
								<label for="bulan">Bulan</label>
								<select class="form-control" id="bulan" name="bulan">
												<option value="0">-- Pilih bulan --</option>
												<option value="Januari">Januari</option>
												<option value="Februari">Februari</option>
												<option value="Maret">Maret</option>
												<option value="April">April</option>
												<option value="Mei">Mei</option>
												<option value="Juni">Juni</option>
												<option value="Juli">Juli</option>
												<option value="Agustus">Agustus</option>
												<option value="September">September</option>
												<option value="Oktober">Oktober</option>
												<option value="November">November</option>
												<option value="Desember">Desember</option>
											</select>
								</div>
								<div class="form-group col-md-3">
								<label for="jenis_santunan">Jenis Santunan</label>
								<select class="form-control" id="jenis_santunan" name="jenis_santunan">
										<option value="0">-- Pilih Jenis Santunan --</option>
										<?php 
										foreach($jenis as $j):
										?>
										<option value="<?php echo $j->id_jenis_tali_asih ?>"><?php echo $j->nama_jenis_tali_asih ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4">
									<label for="filter">Pencarian (masukan nip/nama)</label>
									<input type="text" class="column_filter form-control" id="filter" size="40" placeholder="Search NIP / NAMA">
								</div>
								<div class="form-group col-md-12">
								<button type="submit" class="btn btn-md btn-info"><i class="glyphicon glyphicon-glass"></i> Filter</button>
								<button type="button" class="btn btn-md btn-success" onclick="cetak()"><i class="glyphicon glyphicon-print"></i> Cetak Rekap</button>
								<button type="button" class="btn btn-md btn-danger" onclick="clearFilter()"><i class="glyphicon glyphicon-remove"></i> Clear</button>				
								</div>
							</form>
					      </div>
            	</div>
            	<hr>
            	<div class="alert alert-warning" role="alert">
							  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Untuk mencetak rekapitulasi wajib melakukan filter minimal dalam tahun, 
							  menghindari terjadinya redundant data.
							</div>
              <table class="table table-hover table-bordered table-striped  display responsive no-wrap" id="tbl_rekap">
                <thead>
                  <th width="15">NO</th>
                  <th>NIP</th>
                  <th>NAMA</th>
                  <th>JENIS SANTUNAN</th>
                  <th>BULAN</th>
                  <th>TAHUN</th>
                  <th>BESAR SANTUNAN</th>
                  <th class="none">UNIT KERJA</th>
                  <th class="none">NOTE</th>
                  <th></th>
                </thead>
              </table>
            </div>
        </div>
    </section>
    <section class="preview-pdf">
    	
    </section>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<?= form_open(base_url("santunan_korpri/save"), array('name' => 'fmusulsantunan', 'id' => 'fmusulsantunan', 'autocomplete' => 'off')); ?>
	<input type="hidden" name="unit_kerja" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ENTRI SANTUNAN</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nip">NIP</label>
					<div style="display:flex; justify-content: space-between; align-item: center; gap: 5px">
						<input type="nip" name="nip" class="form-control" id="nip" placeholder="MASUKAN NIP" data-validetta="required,cekpengguna">
						<button type="button" id="ceknip" class="btn btn-sm btn-warning">CEK</button>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="jenis">JENIS SANTUNAN</label>
					<select id="jenis" name="jenis_santunan_korpri" class="form-control" disabled data-validetta="required">
						<option value="0">-- Pilih Jenis Santunan --</option>
						<?php 
						foreach($jenis as $j):
						?>
						<option value="<?php echo $j->id_jenis_tali_asih ?>"><?php echo $j->nama_jenis_tali_asih ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="display-profile"></div>
			</div>
		</div>
		<div class="row" id="step-2" style="display: none; margin-top: 10px;">
			<div class="col-md-4">
				<div class="form-group">
					<label for="besar_santunan">BESAR SANTUNAN</label>
					<input type="text" name="besar_santunan" class="form-control" id="besar_santunan" placeholder="Besar Santunan" data-validetta="required" data-vd-message-required="besar santunan wajid diisi">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="tahun">TAHUN</label>
					<input type="text" name="tahun" id="tahun" value="<?= date('Y') ?>" class="form-control" placeholder="TAHUN" data-validetta="required" data-vd-message-required="tahun wajib diisi">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="bulan">BULAN</label>
					<select class="form-control" id="bulan" name="bulan" data-validetta="required" data-vd-message-required="bulan wajib diisi">
						<option value="">-- Pilih bulan --</option>
						<?php 
							foreach(list_bulan() as $r):
							$selected = $r == date('m') ? 'selected' : ''; 
						?>
							<option value="<?= bulan($r) ?>" <?= $selected ?>><?= bulan($r) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row" id="step-3" style="display: none;">
			<div class="col-md-4">
				<div class="form-group">
					<label for="bulan">TGL. BUP</label>
					<input type="text" disabled name="tgl_bup" class="form-control" id="tgl_bup" placeholder="yyyy-mm-dd" data-validetta="required,date" data-vd-message-required="tgl bup wajib diisi">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="bulan">TGL. MENINGGAL</label>
					<input type="text" disabled name="tgl_meninggal" class="form-control" id="tgl_meninggal" placeholder="hari-bulan-tahun" data-validetta="required" data-vd-message-required="tgl meninggal wajib diisi">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="bulan">TGL. KEBAKARAN</label>
					<input type="text" disabled name="tgl_kebakaran" class="form-control" id="tgl_kebakaran" placeholder="hari-bulan-tahun" data-validetta="required" data-vd-message-required="tgl kebakaran wajib diisi">
				</div>
			</div>
		</div>
		<div class="row" id="step-4" style="display: none;">
			<div class="col-md-12">
			<textarea name="note" class="form-control" cols="4" rows="3" placeholder="Masukan keterangan untuk pembayaran pada kwitansi." data-validetta="required" data-vd-message-required="Keterangan wajib disi."></textarea>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
	<?= form_close() ?><!--form-->
    </div>
  </div>
</div>

<?php $this->load->view($js); ?>