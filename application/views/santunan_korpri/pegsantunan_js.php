<link href="<?php echo base_url('assets/diklat/validetta/validetta.css') ?>" rel="stylesheet" type="text/css" media="screen" >
<script type="text/javascript" src="<?php echo base_url('assets/diklat/validetta/validetta.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/jquery.mask.min.js') ?>"></script>
<script>
    $('#besar_santunan').mask("#.###.##0", {reverse: true, placeholder: "Rp. "});
    $('#tahun').mask("0000", {placeholder: "____"});
    $("#inlineRadio2").click(function(){

        $("[name='tgl_meninggal']").prop("disabled", false);
        $("[name='tgl_kebakaran']").prop("disabled", true);
        $("[name='tgl_kebakaran']").val('');

    });

    $("#inlineRadio3").click(function(){

        $("[name='tgl_meninggal']").val('');
        $("[name='tgl_meninggal']").prop("disabled", true);
        $("[name='tgl_kebakaran']").prop("disabled", false);

    });

</script>
<script>
$("select#bulan").val($("#bln").val());
let elnip = $('input[name="nip"]');

let kondisiawal = elnip.val();
ceknip(kondisiawal);
function ceknip(v) {
	$.getJSON('<?= base_url("santunan_korpri/ceknip") ?>', {nip: v}, function(result) {
		$("#ansview").html(result.data);
		$("select[name='unit_kerja']").val(result.unker);
	});	
}

elnip.on('blur', function() {
let values = $(this).val();
ceknip(values);
})

elnip.on('change', function() {
let values = $(this).val();
ceknip(values);
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
  display : 'bubble',
  errorTemplateClass : 'validetta-bubble',
  onValid : function( event ) {
    event.preventDefault(); // Will prevent the submission of the form
    var fm = $(this.form);
    $.post(fm.attr("action"), fm.serialize(), function(result) {
        alert(result.msg);
        if(result.stsCode == 200) {
        	fm[0].reset();
        	window.location = '<?= base_url("santunan_korpri/rekapitulasi_santunan") ?>';
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

</script>