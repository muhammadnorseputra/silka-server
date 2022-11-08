<style>
  table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 1px !important;
  }
</style>
<div class="container-fluid">
    <div class="row">
      <section class="title">
        <p class="text-danger" style="padding-bottom: 10px; border-bottom: 1px solid orange; text-transform: uppercase; font-size: 20px;"> PEMETAAN JABATAN
        </p>
      </section>
      <section style="margin-bottom: 10px; gap: 5px; display: flex; justify-content: start; align-items: center">
          <select name="unkerid" id="unker" class="unit_kerja"></select>
          <button class="btn btn-primary" onclick="reload()"><i class="glyphicon glyphicon-repeat"></i> Reload Table</button>
      </section>
      <div class="alert alert-info" role="alert">
          1. Pilih unit kerja untuk memfilter data. <br> 2. Lakukan Review Jabatan <br> *) <b>Untuk melakukan penilaian ulang / meremajakan riwayat, <u> HAPUS</u> data</b>
      </div>
    <div class="clearfix"></div>
    <section class="panel-table">
        <div class="panel panel-warning">
						<div class="panel-heading">
              <b>TABEL PEMETAAN JABATAN</b> 
            </div>
            <div class="panel-body">
              <table class="table table-hover table-striped table-bordered" id="tbl_petajabtan">
                <thead>

                    <th rowspan="4" width="10" style="vertical-align: middle;">NO</th>
                    <th rowspan="4" style="vertical-align: middle;">NAMA / NIP</th>
                    <th rowspan="4" style="vertical-align: middle;">NAMA JABATAN</th>
                    <tr>
                      <th colspan="5" style="vertical-align: middle;" class="text-center">POSISI JABATAN SAAT INI</th>
                      <th rowspan="3" style="vertical-align: middle;" class="text-center">KELAS JABATAN</th>
                      <th rowspan="3" style="vertical-align: middle;" class="text-center">REKOMENDASI PENGEMBANGAN</th>
                      <th rowspan="3" style="vertical-align: middle;" class="text-center">KEBUTUHAN JABATAN</th>
                      <th rowspan="3" style="vertical-align: middle;" class="text-center">AKSI</th>
                    </tr>
                    <th rowspan="2" style="vertical-align: middle;" class="text-center">JABATAN PIMPINAN TINGGI (JPT)</th>
                    <th rowspan="2" style="vertical-align: middle;" class="text-center">JABATAN ADMINISTRASI (JA)</th>
                    <th colspan="3" style="vertical-align: middle;" class="text-center">JABATAN FUNGSIONAL (JF)</th>
                    <tr>
                      <th style="vertical-align: middle;" class="text-center">KETERAMPILAN</th>
                      <th style="vertical-align: middle;" class="text-center">KEAHLIAN</th>
                      <th style="vertical-align: middle;" class="text-center">RUMPUN JABATAN <br> FUNGSIONAL</th>
                    </tr>
                </thead>
              </table>
            </div>
        </div>
    </section>
    </div>
</div>
<?php $this->load->view($script_petajabatan) ?>
