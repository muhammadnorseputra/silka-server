<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-heading"><b>REKAPTULASI HASIL PENILAIAN YANG MASUK KE BKPPD</b></div>
			  <div class="panel-body">
			 			<div class="form-inline">
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon3">Filter Bulan</span>
							  <select name="bulan" class="form-control">
							  	<option value="0">-- Pilih Bulan --</option>
							  	<option value="01">Januari</option>
							  	<option value="02">Februari</option>
							  	<option value="03">Maret</option>
							  	<option value="04">April</option>
							  	<option value="05">Mei</option>
							  	<option value="06">Juni</option>
							  	<option value="07">Juli</option>
							  	<option value="08">Agustus</option>
							  	<option value="09">September</option>
							  	<option value="10">Oktober</option>
							  	<option value="11">November</option>
							  	<option value="12">Desember</option>
							  </select>
							</div>
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon3">Filter Tahun</span>
							  <select name="tahun" class="form-control">
							  	<option value="0">-- Pilih Tahun --</option>
							  	<option value="2020">2020</option>
							  	<option value="2021">2021</option>
							  </select>
							</div>
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon3">Filter Score</span>
							  <select name="skor" class="form-control">
							  	<option value="0">-- Pilih Score --</option>
							  	<option value="asc">Tertinggi</option>
							  	<option value="desc">Terendah</option>
							  </select>
							</div>
							<button class="btn btn-primary pull-right" onclick="cetak_rekapitulasi()"><i class="glyphicon glyphicon-filter"></i> Cetak Rekapitulasi</button>
					</div>
					<hr>
			    <table class="table table-hover table-striped table-bordered display responsive no-wrap" id="tbl_rekap">
            <thead>
              <th width="15">NO</th>
              <th>NIP</th>
              <th>NAMA</th>
              <th>UNIT KERJA</th>
              <th class="none">SKOR KINERJA</th>
              <th class="none">SKOR DISIPLIN</th>
              <th class="none">INOVASI</th>
              <th class="none">SKOR INOVASI</th>
              <th class="none">SKOR PERILAKU</th>
              <th class="none">SKOR TIM WORK</th>
              <th>TOTAL SCORE</th>
              <th>AKSI</th>
            </thead>
          </table>
					<button class="btn btn-info" onclick="return dataTable.ajax.reload()"><i class="glyphicon glyphicon-refresh"></i>
					 Fast Reload Table</button>
			  </div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Piagam -->
<div class="modal fade" id="exampleModal" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <?= form_open(base_url('petruk/simpan_nomor_piagam'), ['id' => 'form_horizontal', 'class' => 'f_nomor_piagam'], ['id' => '']) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Piagam</h3>
      </div>
      <div class="modal-body">
        	<div class="form-group">
		    <label for="exampleFormControlInput1">Nomor</label>
		    <input type="text" name="nomor_piagam" class="form-control" id="exampleFormControlInput1" placeholder="Contoh: 800/.../BKPPD-BLG/2021">
		   </div>
		   <div class="form-group">
		    <label for="exampleFormControlInput2">Tanggal</label>
		    <input type="text" name="tgl_piagam" class="form-control tanggal" id="exampleFormControlInput2" placeholder="dd-mm-yyyy">
		   </div>
		   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
   <?= form_close();?>
  </div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/vfs_fonts.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>

<script>
$(document).ready(function () {
 $('.tanggal').datepicker({
   format: "yyyy-mm-dd",
   todayHighlight: true,
   clearBtn: true,
   autoclose:true
 });
});
 
var dataTable = $("#tbl_rekap").DataTable({
  processing: true,
  serverSide: true,
  searching: true,
  order: [[1, 'desc']], 
  deferRender: true,
  keys: false,
  autoWidth: true,
  select: false,
  responsive: true,
  lengthChange: true,
  "pagingType": "full_numbers",
  "scrollY": "300px",
  "scrollCollapse": true,
  ajax: {
      url: '<?= base_url("petruk/list_hasil_penilaian") ?>',
      type: 'POST',
      data: function(s){
          s.bulan = $("select[name='bulan']").val(),
          s.tahun = $("select[name='tahun']").val(),
          s.skor = $("select[name='skor']").val()
      }
  },
  columnDefs: [
            {
                "targets": [0,4,5,6,7,8,9],
                "className": "dt-head-center",
                "orderable": false
            },
            {
                "targets": [1,2,3],
                "className": "dt-left",
                "orderable": true
            },
            {
                "targets": [10,11],
                "className": "dt-center",
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

$("select[name='bulan'],select[name='tahun'],select[name='skor']").on('change', function() {
  dataTable.draw();
});

$('#exampleModal').on('hidden.bs.modal', function (e) {
  e.preventDefault();
  $(".f_nomor_piagam")[0].reset();
});

$(document).on('click', 'a#nomor_piagam', function(event) {
	event.preventDefault();
	var $URL = $(this).attr('href');
	var $ID  = $(this).attr('id_petruk');
	var $NOMOR  = $(this).attr('set_nomor');
	var $TGL  = $(this).attr('set_tgl');
	if($NOMOR != '') {
		$('input[name="nomor_piagam"]').val($NOMOR);
		$('input[name="tgl_piagam"]').val($TGL);
	}
	$('input[name="id"]').val($ID);
	$('#exampleModal').modal('show');
});

$(".f_nomor_piagam").unbind().bind('submit', function(e) {
	e.preventDefault();
	var _this = $(this);
	var $action = _this.attr('action');
	var $method = _this.attr('method');
	var $data   = _this.serialize();
	$.ajax({
		url: $action,
		method: $method,
		dataType: 'json',
		data: $data,
		success: function(res) {
			alert(res);
			$('#exampleModal').modal('hide');
			dataTable.ajax.reload();
		}
	});
});

function cetak_rekapitulasi(){
	  var x = $("select[name='bulan']").val();
	  var y = $("select[name='tahun']").val();
	  var z = $("select[name='skor']").val();
	  if((x != "0") || (y != "0") || (z != "0")){
      $.ajax({
        url: '<?php echo base_url()."petruk/cetak_rekapitulasi/" ?>'+ x +'/'+ y +'/'+ z,
        type: 'POST',
        dataType: 'html',
        success: function(data){
          if(data){
            var URL = "cetak_rekapitulasi/"+ x +'/'+ y +'/'+ z;
            //var iframe = "<iframe src="+URL+" width='100%' height='500' frameborder='0'></iframe>";
            //$("section.preview-pdf").html(iframe);
            window.open(URL, '_blank');
          } else {
            alert('DATA TIDAK DITEMUKAN');
          }
        },
        error: function(error) {
        	alert('Error, terjadi kesalahan pada saat memproses cetak.');
        }
      });	
    } else {
    	alert('Silahkan filter terlebih dahulu');
    }
}
</script>