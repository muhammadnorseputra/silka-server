<style>
  table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 1px !important;
  }
</style>
<div class="container">
    <div class="row">
      <section class="title">
        <p class="text-danger" style="padding-bottom: 10px; border-bottom: 1px solid orange; text-transform: uppercase; font-size: 20px;"> REKAPITULASI
        </p>
      </section>
      <section style="margin-bottom: 10px; gap: 5px; display: flex; justify-content: start; align-items: center">
          <select name="unkerid" id="unker" class="unit_kerja"></select>
      </section>
      <div class="row">
          <div class="col-md-6">
              <div class="alert alert-info" role="alert">
                  1. Pilih unit kerja untuk memfilter data. <br> 2. Klik tombol Unduh Data Untuk Merekap format excel
              </div>
          </div>
      </div>
      <div id="result"></div>
      <br>
      <table class="table table-bordered table-condensed table-striped table-hover" style="background-color:#fff">
        <thead>
          <th>NO</th>
          <th>NAMA UNIT KERJA</th>
          <th>TOTAL PEGAWAI</th>
          <th>TOTAL BELUM INPUT</th>
          <th>TOTAL VALIDASI</th>
        </thead>
        <tbody>
          <?php $no=1; foreach($data->result() as $u): 
          $peg_perunker = $this->mrpk->ceknip('pegawai', ['fid_unit_kerja' => $u->id_unit_kerja])->num_rows();
          $total_input_nilai = $this->db->where('status', 'DONE')->where('unker_id', $u->id_unit_kerja)->get('rpk_penilaian')->num_rows();
          $total_validasi = $this->mrpk->ceknip('rpk_penilaian', ['unker_id' => $u->id_unit_kerja, 'status' => 'DONE'])->num_rows();
          ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= $u->nama_unit_kerja ?></td>
              <td class="text-center"><?= $peg_perunker ?></td>
              <td class="text-center"><?= ($peg_perunker - $total_input_nilai) ?></td>
              <td class="text-center"><?= $total_validasi != 0 ? $total_validasi : '-'; ?></td>
            </tr>
          <?php $no++; endforeach ?>
        </tbody>
      </table>
    </div>
</div>
<?php $this->load->view($script_rekap) ?>