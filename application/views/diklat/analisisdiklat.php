<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="row">
      <h4>Filter Data Berdasarkan:</h4>
        <b>UNIT KERJA </b><select name="unker" id="unker" style="display:none;"></select>
      </div>
      <br>
      <div class="row">
        <b>JENIS JABATAN: </b> <select id="jenis_jabatan" disabled> </select>
      </div>
      <br>
      <div class="row">
        <b>JABATAN STRUKTURAL</b> <select class="form-control" style="width:100%;" id="pilih_jabatan" disabled></select>
      </div>
      <br>
      <div class="row">
      <b>BY IDENTIAS</b>
        <div class="form-inline">
          <div class="form-group">
            <label class="sr-only" for="nipcari">Mencari Berdasarkan Indentitas</label>
            <div class="input-group col-md-12">
              <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
              <input type="text" class="form-control" name="nipcari" max="18" min="0" id="nipcari" placeholder="Masukan Nip / Nama">
            </div>
          </div>
          <button type="button" id="carinippns" onclick="get_analisa()" class="btn btn-primary"> <i class="glyphicon glyphicon-search"></i> Cari</button>
          </div>
      </div>
    </div>

    <div class="col-md-8">
       <!--  -->
       <div class="panel panel-warning">
					<div class="panel-heading"><b><span id="nama_unker" style="display:none;"></span></b> </div>
          <div class="panel-body" style="overflow-y: scroll; overflow-x: hidden; height:540px;">
            <div class="row" id="list-pegawai" ></div>
          </div>
      </div>
    </div>

    <div class="clearfix"></div>
    <!-- <center><span id="loader"></span></center> -->
    

  </div>
</div>


<div class="modal fade detail-peg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" style="width:90%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Informasi Kediklatan</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-5">
            <div class="text-success"><b><i class="glyphicon glyphicon-user"></i> Profil Singkat Pegawai</b></div>
            <div id="peg_load_here">
              <center><span id="loader2"></span></center>
            </div>
            <div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="panel panel-success" style="border-bottom: 3px solid #333;">
              <div class="panel-heading"><span class="text-default"><i class="glyphicon glyphicon-list-alt"></i><b>
                    Riwayat Diklat</b></span> <br> <small class="text-muted">::: Data diambil dari tabel riwayat
                  diklat</small></div>
              <div class="panel-body">
                <div>
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#struktural" aria-controls="struktural" role="tab"
                        data-toggle="tab">STRUKTURAL</a></li>
                        
                    <li role="presentation"><a href="#fu" aria-controls="fu" role="tab" data-toggle="tab"> TEKNIS
                        FUNGSIONAL</a></li>
                    
                    <li role="presentation" class="pull-right" id="usulTab"><a href="#usul" aria-controls="usul"
                    role="tab" data-toggle="tab"><b class="text-warning"><span class="text-danger"><i
                          class="glyphicon glyphicon-plus"></i></span> USUL</b></a></li>
                          
                    <li role="presentation" class="pull-right" id="usulTabStruktural"><a href="#usulJST" aria-controls="usulJST"
                    role="tab" data-toggle="tab"><b class="text-warning"><span class="text-danger"><i
                          class="glyphicon glyphicon-check"></i></span> DAFTAR USULAN DIKLAT</b></a></li>
                          
                    <li role="presentation" class="pull-right" id="okTab"><a href="#ok" aria-controls="ok" role="tab"
                        data-toggle="tab"><b class="text-success"><span class="text-danger"><i
                              class="glyphicon glyphicon-check"></i></span> ANALISIS DIKLAT TF</b></a>
                    </li>
                    
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="struktural">
                      <div id="riwayat_diklat_struktural"></div>
                      
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="usulJST">
                    <br>
                      <button id="usulDiklatStruktural" data-toggle="modal" data-target="#usulDiklatJST" class="btn btn-sm btn-primary"><i
                          class="glyphicon glyphicon-plus"></i> TAMBAH USULAN DIKLAT TF STRUKTURAL</button>
                          
                       <div id="usulan_diklat_struktural"></div>    
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="fu"
                      style="height: auto; max-height: 350px; overflow-y: scroll; overflow-x: hidden;">
                      <br>
                      
                      <div id="riwayat_diklat_fungsional"></div>
                      <div class="clearfix"></div>
                      <div id="riwayat_diklat_teknis"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="ok">
                      <!-- <div id="rekomendasi_diklat_analisa"></div> -->
                      <div class="clearfix"><br></div>
                      <b>A. USULAN DIKLAT TEKNIS</b>
                      <table class="table table-bordered table-hover table-striped" style="margin-top:10px;">
                        <thead>
                          <th width="10">No</th>
                          <th>Nama Diklat</th>
                          <th width="100">Status usulan</th>
                          <th width="30">Detail</th>
                          <th width="30">Edit</th>
                          <th width="30">Hapus</th>
                        </thead>
                        <tbody id="getDataUsulan"></tbody>
                      </table>

                      <b>B. PELAKSANAAN DIKLAT</b>
                      <table class="table table-striped table-hover table-bordered" style="margin-top:10px;">
                        <thead>
                          <tr>
                            <th width="10">No</th>
                            <th>Nama Diklat</th>
                            <th width="100">Status Diklat</th>
                            <th width="120">Verifikator User</th>
                          </tr>
                        </thead>
                        <tbody id="getRekomendasiDiklatTeknis"></tbody>
                      </table>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="usul" style="max-height:350px; overflow-y:scroll; overflow-x:hidden;">
                      <form action="<?= base_url("diklat/usul_diklat") ?>" method="POST" name="fmusul">
                        <input type="hidden" name="bynip">
                        <input type="hidden" name="user_usul" value="<?= $this->session->userdata('nama'); ?>">

                        <div class="clearfix"><br></div>
                        <label for="nama_syarat_diklat">NAMA DIKLAT</label>
                        <div class="form-group" style="margin-top:10px;">
                          <input type="text" class="form-control" name="nama_diklat_usul" id="nama_syarat_diklat" data-validetta="required,minLength[1],maxLength[225]">
                          <p class="help-block text-danger">*diwajibkan menggunakan huruf kapital</p>
                        </div>

                        <label for="tupoksi">TUPOKSI JABATAN</label><br>
                        <small>Salah satu tupoksi yang berkaitan dengan diklat yang diusulkan</small>
                        <div class="form-group" style="margin-top:10px;">
                          <textarea class="form-control" name="tupoksi" id="tupoksi" rows="8" data-validetta="required"></textarea>
                        </div>
                        
                        <label for="penyelenggara">NAMA PENYELENGGARA DIKLAT </label>
                        <div class="form-group" style="margin-top:10px;">
                          <input type="text" class="form-control" name="penyelenggara" id="penyelenggara" data-validetta="required,minLength[1],maxLength[225]">
                        </div>

                        <label for="jp">JUMLAH JP (Jam Pelajaran)</label>
                        <div class="form-group has-error" style="margin-top:10px;">
                        <input type="number" class="form-control col-md-4" max="50000000" min="1" name="jp" id="jp" data-validetta="required,number">
                        <p class="help-block text-danger">(*) only number</p>
                        </div>

                        <label for="biaya">BIAYA PELAKSANAAN</label>
                        <div class="form-group has-error" style="margin-top:10px;">
                          <input type="number" class="form-control col-md-4" max="50000000" min="1" name="biaya" id="biaya" data-validetta="required,number">
                          <p class="help-block text-danger">(*) not use dot, coma, space & only number format</p>
                        </div>

                        <label for="capaian">HASIL YANG DIHARAPKAN</label>
                        <div class="form-group" style="margin-top:10px;">
                          <textarea class="form-control" name="capaian" id="capaian" row="5" data-validetta="required"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-md"><i class="glyphicon glyphicon-send"></i>  Kirim</button>
                      </form>
                      <hr>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Tab panes -->

            <div class="panel panel-default" id="okContent" style="border-bottom: 3px solid #333;">
              <div class="panel-heading"><span class="text-default"><i
                    class="glyphicon glyphicon-lg glyphicon-book"></i><b> Rekomendasi Diklat</b></span> <br> <small
                  class="text-muted">::: Data diambil dari Persyaratan Diklat</small></div>
              <div class="panel-body" id="rekomendasi_diklat"
                style="height: auto; max-height: 350px; overflow-y: scroll; overflow-x: hidden;"></div>
              <center><span id="loader3"></span></center>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal usul diklat jst-->
<div class="modal fade" id="usulDiklatJST" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Usul Diklat Struktural</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open(base_url("diklat/usul_diklat_struktural"), array('name' => 'fusuldiklatjst')); ?>
        	<input type="hidden" name="bynip">
        	<input type="hidden" name="user_usul" value="<?= $this->session->userdata('nama'); ?>">
        	<input type="hidden" name="fid_jabatan">
        	
        	<label for="nama_syarat_diklat">NAMA DIKLAT</label>
	        <div class="form-group" style="margin-top:10px;">
	          <input type="text" class="form-control" name="nama_diklat_usul" id="nama_syarat_diklat" data-validetta="required,minLength[1],maxLength[225]">
	          <p class="help-block text-danger">*Diwajibkan menggunakan huruf kapital</p>
	        </div>
	        
	        <div class="row">
		        <div class="col-md-4">
			        <label for="tahun">TAHUN PELAKSANAAN</label>
			        <div class="form-group" style="margin-top:10px;">
			          
			           <input type="number" class="form-control" name="tahun" id="tahun" data-validetta="required,minLength[1],maxLength[10]">
			          <p class="help-block text-danger">Format tahun, contoh: <u><?= date('Y') ?></u></p>
			        </div>
		        </div>
				<div class="col-md-6">
				<label for="jns_syarat_diklat">JENIS DIKLAT</label><br>
		        <div class="form-group" style="margin-top:10px;">
		          	<label class="radio-inline">
					  <input type="radio" name="jns_syarat_diklat" id="inlineRadio1" data-validetta="required" value="FUNGSIONAL"> FUNGSIONAL
					</label>
					<label class="radio-inline">
					  <input type="radio" name="jns_syarat_diklat" id="inlineRadio2" data-validetta="required" value="TEKNIS"> TEKNIS
					</label>
		        </div>
		        </div>
	        </div>
	        
	        <label for="tupoksi">TUPOKSI JABATAN</label><br>
	        <small>Salah satu tupoksi yang berkaitan dengan diklat yang diusulkan</small>
	        <div class="form-group" style="margin-top:10px;">
	          <textarea class="form-control" name="tupoksi" id="tupoksi" rows="5" data-validetta="required"></textarea>
	        </div>
	        
	        <label for="penyelenggara">NAMA PENYELENGGARA DIKLAT </label>
	        <div class="form-group" style="margin-top:10px;">
	          <input type="text" class="form-control" name="penyelenggara" id="penyelenggara" data-validetta="required,minLength[1],maxLength[225]">
	        </div>
	        
	        <label for="tempat">TEMPAT PENYELENGGARA DIKLAT </label>
	        <div class="form-group" style="margin-top:10px;">
	          <input type="text" class="form-control" name="tempat" id="tempat" data-validetta="required,minLength[1],maxLength[180]">
	        </div>
			
			<div class="row">
				<div class="col-md-6">
			        <label for="jp">JUMLAH JP (Jam Pelajaran)</label>
			        <div class="form-group has-warning" style="margin-top:10px;">
			        <input type="number" class="form-control col-md-4" max="50000000" min="1" name="jp" id="jp" data-validetta="required,number">
			        <p class="help-block text-warning">(*) only number</p>
			        </div>
		        </div>
				<div class="col-md-6">
			        <label for="biaya">BIAYA PELAKSANAAN</label>
			        <div class="form-group has-warning" style="margin-top:10px;">
			          <input type="number" class="form-control col-md-4" max="50000000" min="1" name="biaya" id="biaya" data-validetta="required,number">
			          <p class="help-block text-warning">(*) not use dot, coma, space & only number format</p>
			        </div>
		        </div>
	        </div>
	
	        <label for="capaian">HASIL YANG DIHARAPKAN</label>
	        <div class="form-group" style="margin-top:10px;">
	          <textarea class="form-control" name="capaian" id="capaian" row="5" data-validetta="required"></textarea>
	        </div>
	        
	        <button type="submit" class="btn btn-primary">Simpan</button>
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal edit usulan nama diklat -->
<div class="modal fade" id="myModalEditUsul" tabindex="-1" role="dialog" aria-labelledby="myModalEditUsul">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_syarat_diklat_usulan_edit">
        
        <div class="form-group has-error" id="not_prv">
        <label for="capaian_edit text-bold">CATATAN TIDAK DI SETUJUI !</label>
          <textarea class="form-control edit" name="error_edit" rows="8"></textarea>
        </div>

        <div class="form-group">
          <label for="usul-diklat">NAMA DIKLAT</label>
          <input type="text" class="form-control edit" id="usul_edit" name="usul_edit">
        </div>

        <div class="form-group">
        <label for="tupoksi_edit">TUPOKSI JABATAN</label>
          <textarea class="form-control edit" name="tupoksi_edit" id="tupoksi_edit" rows="8"></textarea>
        </div>

        <div class="form-group">
          <label for="penyelenggara_edit">PENYELENGGARA </label>
          <input type="text" class="form-control edit" name="penyelenggara_edit" id="penyelenggara_edit">
        </div>

        <div class="form-group has-error">
        <label for="jp_edit">JUMLAH JP (Jam Pelajaran)</label>
        <input type="number" class="form-control edit" max="50000000" min="1" name="jp_edit" id="jp_edit"">
        <p class="help-block edit">(*) only number</p>
        </div>

        <div class="form-group has-error">
        <label for="biaya_edit">BIAYA PELAKSANAAN</label>
          <input type="number" class="form-control  edit" max="50000000" min="1" name="biaya_edit" id="biaya_edit">
          <p class="help-block edit">(*) not use dot, coma, space & only number format</p>
        </div>

        <div class="form-group has-success">
        <label for="capaian_edit">HASIL YANG DIHARAPKAN</label>
          <textarea class="form-control edit" name="capaian_edit" id="capaian_edit" row="5"></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="edit btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="edit btn btn-primary" onclick="updateUsulDiklat()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view($analisis_diklat) ?>
