<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>

<script>
$('input[name="tahun"]').datepicker({
    minViewMode: 2,
    maxViewMode: 2,
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy'
});
</script>

<script>

var dataTable = $("#tbl_rekap").DataTable({
  processing: true,
  serverSide: true,
  searching: true,
  order: [], 
  deferRender: true,
  responsive: true,
  lengthChange: true,
  "pagingType": "full_numbers",
  ajax: {
      url: '<?= base_url("santunan_korpri/data_rekapitulasi_santunan") ?>',
      type: 'POST',
      data: function(s){
          s.tahun = $("input[name='tahun']").val(),
          s.bulan = $("select[name='bulan']").val(),
          s.jns_santunan = $("select[name='jenis_santunan']").val()
      }
  },
  columnDefs: [{
                "targets": [0,1,2,3,4,6],
                "className": "dt-head-center",
                "orderable": false
            }, 
            {
            	"targets" : [5,7,8,9],
            	"className": "dt-center",
            	"orderable": false		
            }],
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

$("form[name='filter']").on('submit', function(e) {
	e.preventDefault();
	dataTable.draw();
});

function clearFilter() {
	$("form[name='filter']")[0].reset();
	dataTable.ajax.reload();
}

function cetak_kwt(x){
	  if((x != "")){
      $.ajax({
        url: '<?= base_url()."santunan_korpri/cetak_kwitansi/" ?>' + x,
        type: 'POST',
        dataType: 'html',
        beforeSend: function() {
        	$.post('<?= base_url()."santunan_korpri/update_tgl_cetak/" ?>' + x, function(res){
        		console.log(res);
        	}, 'json');
        },
        success: function(data){
          if(data){
            var URL = "cetak_kwitansi/"+ x;
            //var iframe = "<iframe src="+URL+" width='100%' height='500' frameborder='0'></iframe>";
            //$("section.preview-pdf").html(iframe);
            window.open(URL, '_blank', 'channelmode=1,fullscreen=1,left=0,top=0,height=500,width=600,menubar=0,status=0');
            $("span#icon-check-"+x).html(`<i class="glyphicon glyphicon-print"></i>`);
          } else {
            alert('DATA TIDAK DITEMUKAN');
          }
        },
        error: function(error) {
        	//alert(error.responseText);
        	alert('TGL CETAK TELAH DI PROSES');
        }
      });	
    } else {
    	alert('PNS tidak ditemukan!');
    }
}

function cetak(){
	  var x = $("input[name='tahun']").val();
	  var y = $("select[name='bulan']").val();
	  var z = $("select[name='jenis_santunan']").val();
	  if((x != "") || (y != "0") || (z != "0")){
	  	let tahun = (x == "") ? "0" : x;
      $.ajax({
        url: '<?php echo base_url()."santunan_korpri/cetak/" ?>'+ tahun +'/'+ y +'/'+ z,
        type: 'POST',
        dataType: 'html',
        success: function(data){
          if(data){
            var URL = "cetak/"+ tahun +'/'+ y +'/'+ z;
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
    	alert('Silahkan filter terlebih dahulu, minimal tahun!');
    }
}
</script>