<div class="container">
  <div class="row">
    <div class="clearfix"></div>
    <section class="panel-table">
        <div class="panel panel-danger">
						<div class="panel-heading">
              <b>REKAP MUTASI PEGAWAI</b> 
            </div>
            <div class="panel-body">
            	<div class="row">
            		<div class="col-lg-3 col-md-2">
					        <pre><div class="text-primary"><b>TOTAL : <?= $this->mpensiun->get_all_data_rekap() ?> PNS</b></div></pre>
					      </div>
					      <div class="col-lg-9 col-md-10">
					        <button onclick="window.location.href='../pensiun/cari_pegawai'" class="btn btn-md btn-danger"><i class="glyphicon glyphicon-send"></i> &nbsp; Entri Non BUP & Mutasi</button>
					      </div>
					      
            	</div>
              <table class="table table-hover table-striped table-bordered display responsive no-wrap" id="tbl_rekap">
                <thead>
                  <th width="15">NO</th>
                  <th>NIP</th>
                  <th>NAMA</th>
                  <th>JABATAN</th>
                  <th class="none">NOTE</th>
                </thead>
              </table>
            </div>
        </div>
    </section>
  </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/vfs_fonts.js') ?>"></script>

<script>
var dataTable = $("#tbl_rekap").DataTable({
  processing: true,
  serverSide: true,
  searching: true,
  order: [[2, 'desc']], 
  deferRender: true,
  keys: true,
  autoWidth: true,
  select: false,
  responsive: true,
  lengthChange: true,
  "pageLength": 8,
  "pagingType": "full_numbers",
  "scrollY": "300px",
  "scrollCollapse": true,
  ajax: {
      url: '<?= base_url("pensiun/data_rekap_mutasi") ?>',
      type: 'POST',
  },
  columnDefs: [
            {
                "targets": [3],
                "className": "dt-head-center",
                "orderable": false
            },
            {
                "targets": [0],
                "className": "dt-center",
                "orderable": false
            },
            {
                "targets": [4],
                "className": "bg-danger",
                "orderable": false
            }
  ],
  language: {
    search: "Pencarian (masukan nip/nama): ",
    processing: "Mohon tunggu, loading data...",
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya"
    },
    emptyTable: "No matching records found"
  }
});

</script>