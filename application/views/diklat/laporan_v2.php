<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Mohon Perhatian!</h4>
      </div>
      <div class="modal-body">
        Mohon perhatian, proses cetak rekaputlasi Analisis Kebutuhan Diklat (AKD) akan di tutup dalam beberapa hari lagi.
        Terimakasih.
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <section class="title">
    <p class="text-danger" style="padding-bottom: 10px; border-bottom: 1px solid orange; text-transform: uppercase; font-size: 20px;"> ANALISIS KEBUTUHAN DIKLAT TEKNIS FUNGSIONAL
    </p>
    </section>
    <section class="search">
      <div class="row">
        <div class="col-md-12">
        
          <h4>Tampilkan Data Berdasarkan:</h4>
          
          <div class="form-inline">
           <select class="form-control" name="tahun">
          		<?php foreach($this->md->get_tahun_usul() as $t): ?>
          			<option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
          		<?php endforeach; ?>
           </select>
           |
          	
           <select class="form-control" name="checkjabatan">
          		<option value="0">All Jabatan</option>
          		<option value="1">Struktural</option>
          	</select>
          	|
          	<select class="form-control" name="checkstatus">
          		<option value="0">All Status</option>
          		<option value="1">Disetujui</option>
          		<option value="3">Terlaksana</option>
          	</select>
          	|
            <select name="unkerid" id="unker" class="unit_kerja"></select>

            <button type="button" class="btn btn-sm btn-primary" id="caridata"><i
                class="glyphicon glyphicon-th-list"></i> Tampilkan Data</button>
            <button class="btn btn-sm btn-warning" id="cetakrekap" onclick="cetaklap()"><i class="glyphicon glyphicon-print"></i> Cetak Rekap</button>
          	<button class="btn btn-sm btn-success pull-right" id="input" onclick="window.location.href='<?= base_url("diklat/analisis_diklat") ?>'"><i class="glyphicon glyphicon-plus"></i> Input Usulan Diklat Baru</button>
          </div>
        </div>
      </div>
    </section>
    <div class="alert alert-info" role="alert">
    Pilih unit kerja untuk mencetak data. <br> <b>User wajib melalukan <u> verifikasi  </u>(<i>pada analisis data</i>) apabila diklat telah terlaksana.</b>
    </div>
    <div class="clearfix"></div>
    <section class="panel-table">
        <div class="panel panel-warning">
						<div class="panel-heading">
              <b>ANALISIS KEBUTUHAN DIKLAT</b> 
            </div>
            <div class="panel-body">
              <table class="table table-hover table-striped table-bordered" id="tbl_rekap">
                <thead>
                  <th>NO</th>
                  <th>NAMA / NIP</th>
                  <th>NAMA DIKLAT</th>
                  <th>TUPOKSI</th>
                  <th>WAKTU (JP)</th>
                  <th>PENYELENGGARA</th>
                  <th>BIAYA</th>
                  <th>HASIL YANG DIHARAPKAN</th>
                  <th>STATUS</th>
                </thead>
              </table>
            </div>
        </div>
    </section>
  </div>
</div>


<div class="modal fade" id="ModalPrint" data-keyboard="false"> 
  <div class="modal-dialog" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">PREVIEW PDF</h4>
      </div>
      <div class="modal-body"></div>     
    </div>
  </div>
</div>

<?php $this->load->view($laporan_v2) ?>