<style>
  table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 1px !important;
  }
</style>
<div class="container-fluid">
    <div class="row">
      <section class="title">
        <p class="text-danger" style="padding-bottom: 10px; border-bottom: 1px solid orange; text-transform: uppercase; font-size: 20px;"> RENCANA PENGEMBANGAN KARIR
        </p>
      </section>
      <section style="margin-bottom: 10px; gap: 5px; display: flex; justify-content: start; align-items: center">
          <select name="unkerid" id="unker" class="unit_kerja"></select>
          <button class="btn btn-primary" onclick="reload()"><i class="glyphicon glyphicon-repeat"></i> Reload Table</button>
      </section>
      <div class="row">
          <div class="col-md-4">
              <div class="alert alert-info" role="alert">
                  1. Pilih unit kerja untuk memfilter data. <br> 2. Lakukan Perencanaan Karir <br> 3. Reload Table untuk refresh data
              </div>
          </div>
      </div>
    <div class="clearfix"></div>
    <section class="panel-table">
        <div class="panel panel-warning">
			<div class="panel-heading">
              <b>TABEL RENCANA PENGEMBANGAN KARIR</b> 
            </div>
            <div class="panel-body">
              <table style="width:100%" class="table table-hover table-striped table-bordered order-column display" id="tbl_instansi">
                <thead>
                    <th rowspan="3">NO</th>
                    <th rowspan="3">NAMA / NIP</th>
                    <th rowspan="3">JABATAN SAAT INI</th>
                    <th rowspan="3">REKOMENDASI JABATAN</th>
                    <th rowspan="3">REKOMENDASI PENEMPATAN</th>
                    <th rowspan="3">LOWONGAN KEBUTUHAN JABATAN</th>
                    <tr>
                        <th colspan="4">PENEMPATAN SESUAI RENCANA KARIR</th>
                        <th rowspan="2">BENTUK PENGEMBANGAN KARIR</th>
                        <th rowspan="2">WAKTU PELAKSANAAN (Tahun ke)</th>
                        <th colspan="2">PROSEDUR PENGISIAN DAN MEKANISME</th>
                        <th rowspan="2">AKSI</th>
                    </tr>
                    <th>JPT</th>
                    <th>JA</th>
                    <th>JF_TERAMPIL</th>
                    <th>JF_AHLI</th>
                    <th>MEKANISME</th>
                    <th>PROSEDUR</th>

                  </thead>
              </table>
            </div>
        </div>
    </section>
    </div>
</div>
<?php $this->load->view($script_instansi) ?>
