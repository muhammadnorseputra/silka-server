<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>

<link href="<?php echo base_url('assets/diklat/validetta/validetta.css') ?>" rel="stylesheet" type="text/css" media="screen" >
<script type="text/javascript" src="<?php echo base_url('assets/diklat/validetta/validetta.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/jquery.mask.min.js') ?>"></script>
<style>
.dataTables_filter {
    display: none !important;
}
</style>
<script>
$('#besar_santunan').mask("#.###.##0", {reverse: true, placeholder: "Rp. "});

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

$("input.column_filter").on('change', function(e) {
  e.preventDefault();
  dataTable.search($(this).val()).draw();
})

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

$("button#addSantunan").on("click", function(e) {
  e.preventDefault();
  var $modal = $("#myModal");
  $modal.modal('show')
});

$("button#ceknip").on('click', function(e) {
  var v = $("input#nip").val();
  $.getJSON('<?= base_url("santunan_korpri/ceknip") ?>', {nip: v}, function(result) {
    if(result.status == true && result.data != null) {
		  $(".display-profile").html(result.data)
      $("#step-2").css("display", "block");
      $("select[name='jenis_santunan_korpri']").prop("disabled", false);
      $("input[name='unit_kerja']").val(result.unor);
    } else {
      $("select[name='jenis_santunan_korpri']").prop("disabled", true);
      $(".display-profile").html(`
        <div class="alert alert-danger" role="alert">${result.data}</div>
      `)
      $("#step-2").css("display", "none");
    }
	});	
})

$('input[name="tahun"]').datepicker({
    minViewMode: 2,
    maxViewMode: 2,
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy'
});

$('input[name="tgl_meninggal"],input[name="tgl_kebakaran"],input[name="tgl_bup"]').datepicker({
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true,
    //format: 'dd-mm-yyyy'
    format: 'yyyy-mm-dd'
});
 
$("form[name='fmusulsantunan']").validetta({
  showErrorMessages : true,
  realTime : true,
  display : 'bubble', //bubble or inline
  errorTemplateClass : 'validetta-bubble',
  onValid : function( event ) {
    event.preventDefault(); // Will prevent the submission of the form
    var fm = $(this.form);
    $.post(fm.attr("action"), fm.serialize(), function(result) {
        alert(result.msg);
        if(result.stsCode == 200) {
        	fm[0].reset();
        	dataTable.ajax.reload();
          $('#myModal').modal('hide');
        }
    }, 'json');
  },
  onError : function(event){
    alert( 'Silahkan isi semua bidang yang tersedia');
  },
  validators: {
	  remote : {
	    cekpengguna : {
	      // Here, you must use ajax setting determined by jQuery
	      // More info : http://api.jquery.com/jquery.ajax/#jQuery-ajax-settings
	      type : 'POST',
	      url : '<?= base_url("santunan_korpri/cekpenggunasantunan") ?>',
	      datatype : 'json'
	    }
	  }
  }
});

$('#myModal').on('hidden.bs.modal', function (e) {
  $("form[name='fmusulsantunan']")[0].reset();
  $("#step-2").css("display", "none");
  $("#step-3").css("display", "none");
  $("#step-4").css("display", "none");
  $(".display-profile").html('');
  $("select[name='jenis_santunan_korpri']").prop("disabled", true);
})

$("select[name='jenis_santunan_korpri']").on('change', function(e) {
  e.preventDefault();
  let _ = $(this);
  if(_.val() != 0) {
    $("#step-3").css("display", "block");
    $("#step-4").css("display", "block");
  } else {
    $("#step-3").css("display", "none");
    $("#step-4").css("display", "none");
  }
  if(_.val() == 1) {
    $("[name='tgl_bup']").prop("disabled", false);
    $("[name='tgl_meninggal']").prop("disabled", true);
    $("[name='tgl_kebakaran']").prop("disabled", true);
    $("[name='tgl_kebakaran']").val('');
    $("[name='tgl_meninggal']").val('');
  } else if(_.val() == 2 || _.val() == 4 || _.val() == 5) {
    $("[name='tgl_bup']").prop("disabled", true);
    $("[name='tgl_meninggal']").prop("disabled", false);
    $("[name='tgl_kebakaran']").prop("disabled", true);
    $("[name='tgl_kebakaran']").val('');
    $("[name='tgl_bup']").val('');
  } else if(_.val() == 3) {
    $("[name='tgl_bup']").prop("disabled", true);
    $("[name='tgl_kebakaran']").prop("disabled", false);
    $("[name='tgl_meninggal']").prop("disabled", true);
    $("[name='tgl_meninggal']").val('');
    $("[name='tgl_bup']").val('');
  } 
})
</script>