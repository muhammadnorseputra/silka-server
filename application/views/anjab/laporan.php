<div class="container-fluid">
	<center>
		<form method="POST" action="#" class="form-horizontal">
			<div class="form-group">
	          <label for="golru" class="col-sm-3 control-label">UNIT KERJA</label>
	          <div class="col-sm-6">
	            <select class="form-control" name="unker" id="unkersel" onchange="selectunker()">
	              <!-- <option value="">-- Pilih Golru --</option> -->
	            </select>
	          </div>
	        </div> 
		</form>
		<div id="loading" style="z-index: 2; display: none;"><center><img src="<?php echo base_url('assets/loading5.gif') ?>"></center> Mohon Tunggu Sebentar...</div>
	</center>

	<div class="panel panel-primary" id="panel" style=" display: none;">
	  <!-- Default panel contents -->
	  <div class="panel-heading"><b> Tabel Laporan </b> <span id="unkerterpilih"></span>
	  	<a  id="cetak" class="btn btn-default btn-sm pull-right" onClick="cetaklap()">
	  		<i class="glyphicon glyphicon-print"></i> CETAK LAPORAN
	  	</a>
	  	<a href="#" id="hapus-data"></a>
	  	<div class="clearfix"></div>
	  </div>
	  <!-- Table -->
	  <div class="table-responsive" style="height: 450px; overflow-y: scroll;">
	  <table class="table table-bordered text-center table-hover ">
	  	<thead>
		  <tr>
		  	<?php if($this->session->userdata('level') == "ADMIN" || $this->session->userdata('nama') == "salasiah" || $this->session->userdata('nama') == "kholik"): ?>
		  		<th rowspan="2" width="5"></th>
		  	<?php endif ?>
		  	<th rowspan="2" width="5" style="vertical-align: middle; background:#ccc;" class="text-center">NO</th>
		  	<th rowspan="2" width="15%" style="vertical-align: middle;; background:#ccc;" class="text-center">NAMA JABATAN</th>
		  	<th rowspan="2" width="25%" style="vertical-align: middle;; background:#ccc;" class="text-center">UNIT KERJA</th>
		  	<th rowspan="2" width="10" style="vertical-align: middle;; background:#ccc;" class="text-center">KELAS JABATAN</th>
		    <th colspan="3" width="30%" class="text-center" style="background-color: #9cccf9;">PEMANGKU JABATAN  </th>
			<th rowspan="2" style="vertical-align: middle; background:#ccc;" class="text-center">KETERANGAN</th>
			<tr>
				<!-- <th colspan="3"></th> -->
			    <th style="background-color: #9cccf9;" width="10%">NAMA</th>
			    <th style="background-color: #9cccf9;">NIP</th>
			    <th style="background-color: #9cccf9;">PANGKAT/GOLRU</th>
			</tr>

			<tr style="color:#ccc; text-align: center; background-color: #eee;">
			<?php if($this->session->userdata('level') == "ADMIN" || $this->session->userdata('nama') == "salasiah" || $this->session->userdata('nama') == "kholik"): ?>
				<td></td>
			<?php endif ?>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
			</tr>
		  </tr>		  	
		  
		</thead>
		<tbody id="isi-laporan">
		</tbody>
	  </table>
	  </div>
	  <div class="panel-footer">
	  	<i class="glyphicon glyphicon-chevron-left"></i> Laporan Hasil Analisa. <i class="glyphicon glyphicon-chevron-right"></i> TGL : <?php echo date("Y-m-d") ?>
	  </div>
	</div>	
</div>
<div class="modal fade " id="myModalPrint" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-lg" style="width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">PREVIEW PDF</h4>
      </div>
      <div class="modal-body"></div>     
    </div>
  </div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/sweetalert/sweetalert.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>


<script>
$("#loading").hide();	


unker();    
function unker(){
  $.ajax({
    type:'POST',
    url : '<?php echo base_url()."anjab/get_unker" ?>',
    dataType: 'json',
    success: function(hasil){
      $("#unkersel").html(hasil);    
    }
  });
}	

function selectunker(){
	var unkerid = $("[name ='unker']").val();
	if(unkerid != ''){
	  $.ajax({
	    type:'POST',
	    data: 'unkerid='+unkerid,
	    url : '<?php echo base_url()."anjab/get_laporan" ?>',
	    dataType: 'json',
	    success: function(hasil){

			var no = 1;
			var rest = '';
			var i;
			if(no == 1){
				<?php if($this->session->userdata('level') == "ADMIN" || $this->session->userdata('nama') == "salasiah" || $this->session->userdata('nama') == "kholik"): ?>	
					$(".panel-heading a#hapus-data").html('<a class="btn btn-sm btn-danger pull-right" style="margin-right:10px;" onclick="hapus()"><i class="glyphicon glyphicon-trash"></i> Hapus Record</a> ');
				<?php endif ?>
			}
			for(i=0;i<hasil.length;i++){
			

				
				var njab = hasil[i].nama_jabatan;
				if(njab != null){
					var nama_jabatan = njab
				}else{
					var nama_jabatan = "-";
				}

				var ukj  = hasil[i].unker;
				if(ukj != null){
					var unit_kerja = ukj;
				}else{
					var unit_kerja = "-";
				}
				var kls  = hasil[i].kelas_jabatan;
				if(kls != '0'){
					var kelas_jabatan = kls;
				}else{
					var kelas_jabatan = "-";
				}

				var nama = hasil[i].nama;
				if(nama != null){
					var nama_pns = nama;
				}else{
					var nama_pns = "-";
				}

				var nip = hasil[i].nip;
				if(nip != null){
					var nip_pns = nip;
				}else{
					var nip_pns ="-";
				}

				var pangkat = hasil[i].nama_pangkat;
				var golru  = hasil[i].nama_golru;
				if(pangkat != null || golru != null){
					var pangkat_pns = pangkat;
					var golru_pns = " ("+golru+")";
				}else{
					var pangkat_pns = "-";
					var golru_pns = "-";					
				}

	  var jml_mms_min = hasil[i].jml_mms;
      var ms =  '<span class="text-primary text-bold text-status">MEMENUHI SYARAT</span> (<b>MS</b>) <b>SCORE (1)</b>		';
      var mms = '<span class="text-success text-bold text-status">MASIH MEMENUHI SYARAT</span> (<b>MMS</b>) <br><b>SCORE ('+jml_mms_min+' )</b>';
      var kms = '<span class="text-danger text-bold text-status">KURANG MEMENUHI SYARAT</span> (<b>KMS</b>)<br><b>SCORE ('+jml_mms_min+' )</b>';

      var a = hasil[i].skor_kelas_jabatan;
      var b = hasil[i].skor_golru;
      var c = hasil[i].skor_jurusan;
      var d = hasil[i].skor_jp;
      var e = hasil[i].skor_skp;
      var f = hasil[i].skor_csakit;

      if(a != '0' && b != '0' && c != '0' && d != '0' && e != '0' && f != '0'){
         var head = ms;
        var bg   = "panel-primary";
      }else if(a != '0' && b != '0' && c != '0' || jml_mms_min >= '0.7'){
         var head = mms;
         var bg = "info";
      }else if(a == '0' && b == '0' && c == '0' || jml_mms_min <= '0.7'){
        var head = kms;
        var bg   = "";
      }            				

		if(ukj ==  null && kls == '0' && nama ==  null && nip == null && pangkat == null && golru == null){
			var ket = "<b style='color:green;'> FORMASI TERSEDIA/KOSONG</b>";
		}else{
			var ket = head;
		}



			if(hasil[i].jml_baris != 0){

			 rest += '<tr class="bg-'+bg+'">'+
			 					<?php if($this->session->userdata('level') == "ADMIN" || $this->session->userdata('nama') == "salasiah" || $this->session->userdata('nama') == "kholik"): ?>
								// '<td class="bg-danger"> </td>'+
								'<td><input type="checkbox" name="checkboxlist" value="'+hasil[i].id_aj_syaratjab_analisis+'"></td>'+
								<?php endif ?>
								'<td>'+no+'</td>'+
								'<td>'+nama_jabatan+'</td>'+
								'<td>'+unit_kerja+'</td>'+
								'<td>'+kelas_jabatan+'</td>'+
								'<td>'+nama_pns+'</td>'+
								'<td>'+nip_pns+'</td>'+
								'<td>'+pangkat_pns+'<b>'+golru_pns+'</b></td>'+
								'<td>'+ket+'</td>'+
							'<tr>';
			}else{
				$("#isi-laporan").html("<tr><td>#</td><td colspan='7'><b>DATA KOSONG</b></td></tr>");
			}
			no++;
		}
		// if(hasil[0].id_unit_kerja != null){
			$("#isi-laporan").html(rest);
		// }else{
		// 	$("#isi-laporan").html("<tr><td>#</td><td colspan='7'><b>DATA KOSONG</b></td></tr>");
		// }	

	    },
        beforeSend : function(){
          $("#loading").show().css("display","block");
          $("#panel").show();
        },
        complete : function(){
          $("#loading").hide();
        }
	  });	
	}else{
		$("#panel").hide();
	}
}

function cetaklap(){
	var x = $("[name ='unker']").val();
      $.ajax({
        url: '<?php echo base_url()."anjab/cetaklaporan" ?>',
        type: 'POST',
        data: 'idunker='+x,
        dataType: 'html',
        beforeSend: function(){
        	$(".modal-body").append("<div id='preview-pdf-load'>Mohon Tunggu...</div>");
        },
        success: function(data2){
			if(x != null){
	       	var red = "cetaklaporan/"+x;

	   		var fra = "<iframe src="+red+" width='100%' height='500' frameborder='0'></iframe>";
	        var dataHendler = $(".modal-body");
	        dataHendler.html(fra);
	    	}
        	$("#myModalPrint").modal('show');
        },
        error: function(){
          alert('error');
        }
      });	
}

function hapus(){
	
	var ids = $('[name=checkboxlist]:checked').map(function(){
	     return $(this).val();
	    }).get();	
	var sumids = ids.length;
  swal({
    title: "Apakah anda yakin?",
    text: "Anda akan menghapus "+sumids+" baris data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Ya, Hapus !",
    closeOnConfirm: false,
    showLoaderOnConfirm: true
  },
  function(){
        $.ajax({
            type: 'POST',
            data: { id: ids },
            url : '<?php echo base_url()."anjab/hapusdatalaporan" ?>',
            success: function(){
              setTimeout(function(){
               swal("Deleted!", ""+sumids+" baris data telah terhapus.", "success");
              }, 1000);
              selectunker();
            },
            error: function(){
              swal("Error", "Terjadi kesalahan dalam penghapusan Record :)", "error");
            }
        });    
  });  
}
</script>

<script type="text/javascript">
  $("#unkersel").select2({
  width: 'resolve',
  minimumResultsForSearch: -1
  // minimumInputLength: 3,
  // maximumInputLength: 20
  });

  $("#unkersel").select2({
  width: 'resolve',
  minimumResultsForSearch: 1
  });
</script>

<style type="text/css">
#preview-pdf-load {
	position: relative;
	top: 10%;
	left: 10%;
}
#isi-laporan {
	height: 80%;
	overflow: scroll;
}
</style>