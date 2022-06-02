<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/vfs_fonts.js') ?>"></script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-bootstrap.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
<script>
/*
$(document).ready(function(){
	$("#myModal").modal('show');
	setTimeout(() => {
		$("#myModal").modal('hide');
	}, 19000)
});
*/

var dataTable = $("#tbl_rekap").DataTable({
  processing: true,
  serverSide: true,
  searching: false,
  order: [[1, 'desc']], 
  deferRender: true,
  keys: false,
  autoWidth: false,
  select: false,
  searching: false,
  lengthChange:  true,
  "scrollY": "300px",
  "scrollCollapse": true,
  ajax: {
      url: '<?= base_url("diklat/get_rekap_v2") ?>',
      type: 'POST',
      data: function(s){
          s.unkerid = $("[name='unkerid']").val(),
          s.checkstatus = $("[name='checkstatus']").val(),
          s.checkjabatan = $("[name='checkjabatan']").val(),
          s.tahun = $("[name='tahun']").val()
      }
  },
  columnDefs: [
            {
                "targets": [2,3,4,5,7],
                "className": "dt-head-center",
                "orderable": false
            },
            {
                "targets": [0],
                "className": "dt-center",
                "orderable": false
            },
            {
                "targets": [1],
                "width" : "20%",
                "orderable": true
            },
            {
                "targets": [6],
                "width" : "10%",
                "orderable": true
            }
  ],
  language: {
    search: "Pencarian: ",
    processing: "Mohon Tunggu, Processing...",
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya"
    },
    emptyTable: "No matching records found, please filter this data by unit kerja"
  }
});

$("#caridata").on('click', function() {
  dataTable.draw();
});


var select = $("#unker").select2({
  width: '25%',
  placeholder: {
    id: '-1',
    text: '-- Cari Unit Kerja --'
  },
  selectOnClose: false,
  allowClear: true,
  theme: "bootstrap",
  //minimumInputLength: 5,
  ajax: {
    url: '<?= base_url("diklat/get_unit_kerja") ?>',
    type: 'POST',
    dataType: 'json',
    quietMillis: 250,
    data: function(params) {
      return {
        searchParm: params.term
      };
    },
    processResults: function(response) {
      return {
        results: response.items
      };
    },
    cahce: true
  }
});


function cetaklap(){
	  var z = $("[name ='checkjabatan']").val();
	  var y = $("[name ='checkstatus']").val();
	  var x = $("[name ='unkerid']").val();
	  var t = $("[name ='tahun']").val();
      $.ajax({
        url: '<?php echo base_url()."diklat/cetaklaporan_v2/" ?>'+ x +'/'+y+'/'+z+'/'+t,
        type: 'POST',
        dataType: 'html',
        beforeSend: function(){
        	$(".modal-body").html("Mohon Tunggu, Prossesing ...");
        },
        success: function(data){
          var container = $(".modal-body");
          if(x != null){
            var url = "cetaklaporan_v2/"+x +'/'+y+'/'+z+'/'+t;
            var iframe = "<iframe src="+url+" width='100%' height='500' frameborder='0'></iframe>";
            container.css("padding","0").html(iframe);
          } else {
            container.html('<span class="text-danger">Unker ID null.</span>')
          }
          $("#ModalPrint").modal('show');
        },
        error: function(error) {
        	alert('Info!!! Unit Kerja Belum Dipilih.');
        }
      });	
}
</script>