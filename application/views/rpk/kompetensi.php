<style>
  table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 1px !important;
  }
</style>
<div class="container-fluid">
    <div class="row">
      <section class="title">
        <p class="text-danger" style="padding-bottom: 10px; border-bottom: 1px solid orange; text-transform: uppercase; font-size: 20px;"> PENYELARASAN KOMPETENSI
        </p>
      </section>
      <section style="margin-bottom: 10px; gap: 5px; display: flex; justify-content: start; align-items: center">
          <select name="unkerid" id="unker" class="unit_kerja"></select>
          <button class="btn btn-primary" onclick="reload()"><i class="glyphicon glyphicon-repeat"></i> Reload Table</button>
      </section>
      <div class="row">
          <div class="col-md-4">
              <div class="alert alert-info" role="alert">
                  1. Pilih unit kerja untuk memfilter data. <br> 2. Lengkapi Persyaratan Nilai Jabatan <br> 3. Reload Table untuk refresh data
              </div>
          </div>
      </div>
      <section class="panel-table">
        <div class="panel panel-warning">
			<div class="panel-heading">
              <b>TABEL PENYELARASAN KOMPETENSI</b> 
            </div>
            <div class="panel-body">
              <table style="width:100%" class="table table-hover table-striped table-bordered order-column display" id="tbl_kompetensi">
                <thead>
                    <th rowspan="3">NO</th>
                    <th rowspan="3">NAMA / NIP</th>
                    <tr>
                        <th colspan="3" class="text-center" style="vertical-align: middle;">Hasil Penilaian/Uji Kompetensi</th>
                        <th rowspan="2">Waktu Pelaksanaan <br> (Tahun Ke)</th>
                        <th colspan="3" class="text-center" style="vertical-align: middle;">Persyaratan Nilai Jabatan Yang Akan Diduduki</th>
                        <th rowspan="2">Penyelarasan Kompetensi Jabatan</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <th>Nilai Kompetensi <br> Manajerial</th>
                    <th>Nilai Kompetensi <br> Sosiokultural</th>
                    <th>Nilai Kompetensi <br> Teknis</th>
                    <th>Nilai Kompetensi <br> Manajerial</th>
                    <th>Nilai Kompetensi <br> Sosiokultural</th>
                    <th>Nilai Kompetensi <br> Teknis</th>
                  </thead>
              </table>
            </div>
        </div>
    </section>
    </div>
</div>
<?php $this->load->view($script_kompetensi) ?>