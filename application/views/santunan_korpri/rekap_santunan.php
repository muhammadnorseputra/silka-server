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
					        <form class="form-inline" method="post" name="filter" action="#">
									  <div class="form-group">
									    <label for="tahun">Tahun</label>
									    <input type="text" class="form-control" name="tahun" value="" id="tahun" placeholder="Masukan tahun">
									  </div>
									  <div class="form-group">
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
									  <div class="form-group">
									    <label for="jenis_santunan">Jenis Santunan</label>
									    <select class="form-control" id="jenis_santunan" name="jenis_santunan">
											  <option value="0">-- Pilih Jenis Santunan --</option>
											  <option value="1">BUP</option>
											  <option value="2">PNS aktif meninggal</option>
											  <option value="3">Kebakaran</option>
											</select>
									  </div>
									  <div class="form-group">
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

<?php $this->load->view($js); ?>