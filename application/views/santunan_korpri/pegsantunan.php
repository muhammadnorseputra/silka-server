<?php 
	$panelColor = $type['jenis'] == 'bup' ? 'danger' : 'info';
?>

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
    	<section class="panel-table">
        <div class="panel panel-<?= $panelColor ?>">
						<div class="panel-heading">
              <b>ENTRI SANTUNAN KORPRI</b> 
            </div>
            <div class="panel-body">
            	<?= form_open(base_url("santunan_korpri/save"), array('name' => 'fmusulsantunan', 'id' => 'fmusulsantunan', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
            	
            	<div class="row">
            		
            		<div class="col-md-3 text-center" id="ansview"></div>
            		<div class="col-md-9">
							  <div class="form-group">
							    <label for="nip" class="col-sm-2 control-label">NIP</label>
							    <div class="col-sm-4">
							    <?php if($type['jenis'] == 'bup'): ?>
							      <input type="text" name="nip" class="form-control" id="nip" value="<?= $type['nip'] ?>">
							      <input type="hidden" name="bln" id="bln" value="<?= $type['bulan_bup'] ?>">
							    <?php else: ?>
							    	<input type="text" name="nip" class="form-control" id="nip" value="<?= $type['nip'] ?>">
									<?php endif; ?>
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="unker" class="col-sm-2 control-label">Unit Kerja</label>
							    <div class="col-sm-8">
							    	<select class="form-control" id="unker" name="unit_kerja" data-validetta="required" data-vd-message-required="unit kerja belum dipilih">
										<option value="">-- Pilih unit kerja --</option>
							    		<?php foreach($type['unker'] as $u): ?>
										  <option value="<?= $u->nama_unit_kerja ?>"><?= $u->nama_unit_kerja ?></option>
										  <?php endforeach; ?>
										</select>
							    </div>
							  </div>
							  <div class="form-group">
							  	<label for="jenis_tali_asih" class="col-sm-2 control-label">Jenis Santunan</label>
							    <div class="col-sm-10">
							    		<?php if($type['jenis'] == 'bup'): ?>
									  	<label class="radio-inline">
											  <input type="radio" name="jenis_tali_asih" id="inlineRadio1" value="1" checked> <h4><b style="position:relative; bottom:10px;">PENSIUN BUP</b></h4>
											</label>
											<label class="radio-inline">
											  <input type="radio" name="jenis_tali_asih" id="inlineRadio2" value="2" disabled> <h4><b style="position:relative; bottom:10px; color:gray;"><s>PNS Aktif Meninggal</s></b></h4>
											</label>
											<label class="radio-inline">
											  <input type="radio" name="jenis_tali_asih" id="inlineRadio3" value="3" disabled> <h4><b style="position:relative; bottom:10px; color:gray;"><s>Kebakaran</s></b></h4>
											</label>
										<?php else: ?>
											<label class="radio-inline">
											  <input type="radio" name="jenis_tali_asih" id="inlineRadio1" value="1" disabled> <h4><b style="position:relative; bottom:10px; color:gray;"><s>PENSIUN BUP</s></b></h4>
											</label>
											<label class="radio-inline">
											  <input type="radio" name="jenis_tali_asih" id="inlineRadio2" value="2" data-validetta="required" data-vd-message-required="pilih salah satu"> <h4><b style="position:relative; bottom:10px;">PNS Aktif Meninggal</b></h4>
											</label>
											<label class="radio-inline">
											  <input type="radio" name="jenis_tali_asih" id="inlineRadio3" value="3" data-validetta="required" data-vd-message-required="pilih salah satu"> <h4><b style="position:relative; bottom:10px;">Kebakaran</b></h4>
											</label>
										<?php endif; ?>
									</div>
							  </div>
							  <div class="clearfix"></div>
							  
							  <div class="form-group">
							    <label for="besar_santunan" class="col-sm-2 control-label">Besar Santunan</label>
							    <div class="col-sm-3">
							    	<input type="text" name="besar_santunan" class="form-control" id="besar_santunan" placeholder="Besar Santunan" data-validetta="required" data-vd-message-required="besar santunan wajid diisi">
							    </div>
							  </div>
							  
											<div class="form-group">
										    <label for="tahun" class="col-sm-2 control-label">Tahun</label>
										    <div class="col-sm-2">
										    	<?php if($type['jenis'] == 'bup'): ?>
										    	<input type="text" name="tahun" id="tahun" class="form-control" data-validetta="required" value="<?= $type['tahun_bup'] ?>" data-vd-message-required="tahun wajib diisi">
										    	<?php else: ?>
										    	<input type="text" name="tahun" id="tahun" class="form-control" data-validetta="required" data-vd-message-required="tahun wajib diisi">
										   		<?php endif; ?>
										     </div>
										  </div>
								  
										  <div class="form-group">
										    <label for="bulan" class="col-sm-2 control-label">Bulan</label>
										    <div class="col-sm-3">
										    	<select class="form-control" id="bulan" name="bulan" data-validetta="required" data-vd-message-required="bulan wajib diisi">
													  <option value="">-- Pilih bulan --</option>
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
										  </div>
										  <?php if($type['jenis'] == 'bup'): ?>
											<div class="form-group">
										    <label for="tgl_bup" class="col-sm-2 control-label">Tgl.BUP</label>
										    <div class="col-sm-3">
										    	<input type="text" name="tgl_bup" class="form-control" id="tgl_bup" placeholder="yyyy-mm-dd" data-validetta="required,date" data-vd-message-required="tgl bup wajib diisi">
										    </div>
											</div>
											<?php else: ?>
											<div class="form-group">
										    <label for="tgl_meninggal" class="col-sm-2 control-label">Tgl.Meninggal</label>
										    <div class="col-sm-3">
										    	<input type="text" disabled name="tgl_meninggal" class="form-control" id="tgl_meninggal" placeholder="hari-bulan-tahun" data-validetta="required" data-vd-message-required="tgl meninggal wajib diisi">
										    </div>
											</div>
											
											<div class="form-group">
										    <label for="tgl_kebakaran" class="col-sm-2 control-label">Tgl.Kebakaran</label>
										    <div class="col-sm-3">
										    	<input type="text" disabled name="tgl_kebakaran" class="form-control" id="tgl_kebakaran" placeholder="hari-bulan-tahun" data-validetta="required" data-vd-message-required="tgl kebakaran wajib diisi">
										    </div>
											</div>
											<?php endif; ?>
											
											<div class="form-group">
										    <label for="tgl_kebakaran" class="col-sm-2 control-label">&nbsp;</label>
										    <div class="col-sm-8">
										    	<textarea name="note" class="form-control" cols="4" rows="3" placeholder="Masukan keterangan untuk pembayaran pada kwitansi." data-validetta="required" data-vd-message-required="Keterangan wajib disi."></textarea>
										    </div>
											</div>
											
											<div class="form-group">
										    <label for="tgl_kebakaran" class="col-sm-2 control-label">&nbsp;</label>
										    <div class="col-sm-3">
										    	<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
										    	<!--<button type="reset" class="btn btn-danger btn-sm">Reset</button>-->
										    </div>
										    <div class="col-sm-1">
										    </div>
											</div>
            		</div>
            	</div>
              <?= form_close() ?><!--form-->
						</div>
        </div>
    	</section> 
    </div>
  </div><!--row-->
</div> <!--container-->
<?php $this->load->view($type['pegsantunan_js']) ?>