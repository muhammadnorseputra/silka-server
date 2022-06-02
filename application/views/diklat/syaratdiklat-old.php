<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div>
				<p class="bg-primary text-danger" style="padding: 10px; border-left: 5px solid orange; text-transform: uppercase; font-size: 20px;">Syarat Diklat
					<button class="btn btn-default pull-right" type="button" id="add"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
				</p>
				<!-- <i>Untuk Refrensi / Perekaman Baris Data Persyaratan Diklat</i>  -->
			</div>
			
			<div class="clearfix"><br></div>
			<div id="collapseAdd" style="display: none;">
				<button type="button" style="position: relative; right: 10px; top:5px;" class="close" id="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<div class="alert alert-success" style="border-bottom:3px solid #0f4334;">
					<div class="form-inline">
						<div id="msg"></div>
						<div class="col-md-4">
							<div class="form-group" action="#">
								<label for="unker"><b>1.</b> Unit Kerja: </label><br>
							<select class="form-control" id="unker"></select>
							<p class="text-danger"><br>
							<i><b>Info!!</b><br>Pastikan UNIT KERJA sudah sesuai, apabila terjadi perbedaan tidak dapat di ubah lagi...</i></p>
							<div class="clearfix"><br></div>
							<label><b>2.</b> Jabatan: </label><br>
							<select class="form-control" id="jabstruk" name="jabstruk" disabled="disabled">
								<option value="0">-- Select Jabatan Struktural -- </option>
							</select>
						</div>
					</div>
					<div class="col-md-8" style="border-left:1px dotted #ccc;">
						
						<div class="col-md-12">
							<div class="form-group">
								<label><b>3.</b> Jenis Diklat: </label><br>
								<div class="radio" style="margin-bottom: 5px;">
									<label>
										<input type="radio" name="jnsjb" id="inlineRadio1" value="STRUKTURAL" disabled="disabled"> <span style="top:-2px; left:2px; color:darkorange; position: relative;">STRUKTURAL</span>
									</label>
								</div>
								<br>
								<div class="radio">
									<label>
										<input type="radio" name="jnsjb" id="inlineRadio2" value="TEKNIS FUNGSIONAL" disabled="disabled"> <span style="top:-2px;  color:darkorange; left:2px; position: relative;"> TEKNIS FUNGSIONAL</span>
									</label>
								</div>
							</div>
							<br><br>
							<div class="form-group teknis_fungsional" style="display: none;">
								<label for="nama_diklat teknis_fungsional"><b>4.</b> Nama Diklat Teknis Fungsional:  <b class="text-warning"><!-- *) Max 6 Nama Diklat... --></b></label><br>
								
								<input type="text" class="form-control" name="nama_diklat" id="nm" placeholder="Nama Diklat..." disabled="disabled" size="85%">
								<p class="text-danger" style="margin-top:2px;">
								<!-- Tekan <b>ENTER</b> untuk memisahkan kata!</i --></p>
								<!-- <button class="btn btn-xs btn-info"><i class="glyphicon glyphicon-plus"></i></button> -->
							</div>
							<div class="form-group struktural" style="display: none;">
								<label for="nama_diklat"><b>4.</b> Nama Diklat Struktural: </label><br>
								<label class="radio-inline">
									<input type="radio" name="nama_dik" id="inlineCheckbox1" value="PIM I">
									<span style="top:2px; left:0px; color:darkorange; position: relative;">PIM I</span>
								</label>
								<label class="radio-inline">
									<input type="radio" name="nama_dik" id="inlineCheckbox2" value="PIM II"> <span style="top:2px; left:0px; color:darkorange; position: relative;">PIM II</span>
								</label>
								<label class="radio-inline">
									<input type="radio" name="nama_dik" id="inlineCheckbox3" value="PIM III"> <span style="top:2px; left:0px; color:darkorange; position: relative;">PIM III</span>
								</label>
								<label class="radio-inline">
									<input type="radio" name="nama_dik" id="inlineCheckbox4" value="PIM IV"> <span style="top:2px; left:0px; color:darkorange; position: relative;">PIM IV</span>
								</label>
								<!-- <label class="radio-inline">
									<input type="radio" name="nama_dik" id="inlineCheckbox5" value="PRAJABATAN"> <span style="top:2px; left:0px; color:darkorange; position: relative;">PRAJABATAN</span>
								</label> -->																
							</div>
							<hr>
							<button class="btn btn-success pull-right" disabled="disabled" id="save" onclick="toSave()"><i class="glyphicon glyphicon-save"></i> Save</button>
							<button class="btn btn-danger pull-right" id="reload" onclick="location.reload()" style="margin-right: 20px;"><i class="glyphicon glyphicon-repeat"></i> Reload</button>
							<!-- <button class="btn btn-danger pull-right" style="margin-right: 10px;" >Close</button> -->
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="clearfix"><br></div>
		<div class="col-md-4" style="padding-top: 10px; margin-bottom: 10px;">
			<b>Filter Data:</b>
			<div class="form-horizontal">
				<div class="form-group">
					<!-- <label for="unker" class="col-sm-3 control-label">Unit Kerja</label> -->
					<div class="col-sm-9">
					<select class="form-control" id="unkerfilter2"></select>
				</div>
			</div>
			<div class="form-group">
				<!-- <label for="inputPassword3" class="col-sm-3 control-label">Jabatan</label>  -->
				<div class="col-sm-9">
					<select class="form-control" id="jabatan_filter_data" disabled>
						<option value="0">-- Select Jabatan Struktural -- </option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10">
					<button id="filtercari" class="btn btn-info btn-xs pull-right" disabled>GO CARI</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="clearfix"><br></div>
	<div class="panel panel-warning">
		<div class="panel-heading"><b>TABLE SYARAT DIKLAT</b> <button class="btn btn-xs btn-info pull-right" onclick="reload()" data-toggle="tooltip" data-placement="top" title="Double Click!"><i class="glyphicon glyphicon-refresh"></i> Reload Table</button></div>
		<div class="panel-body" style="overflow-y: scroll; overflow-x: hidden; max-height: 350px; height: auto;">
			<table class="table table-hover table-striped table-condensed display" id="tableSyarat">
				<thead class="bg-info">
					<tr>
						<th width="25">No</th>
						<th width="250">Nama Jabatan</th>
						<th>Persyaratan Diklat</th>
						<!-- <th width="150">Jenis Diklat</th> -->
						<th width="150" align="center">Aksi</th>
					</tr>
				</thead>
			<tbody id="myData"></tbody>
			<tfoot>
			<tr>
				<th width="25">No</th>
				<th>Nama Jabatan</th>
				<th>Riwayat Diklat</th>
				<!-- <th width="150">Jenis Diklat</th> -->
				<th align="center">Aksi</th>
			</tr>
			</tfoot>
		</table>
	</div>
</div>
</div>
<div class="modal fade" id="myModalEdit" data-backdrop="static">
<div class="modal-dialog modal-md">
	<form class="form-horizontal">
		
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> EDIT <span style="font-size: 10px;" id="title-edit"></span></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="myform">
					<input type="hidden" id="id_syarat_diklat">
					<input type="hidden" id="unkerid">
					<input type="hidden" id="jabatanid">
					<div class="form-group">
						<label for="nama_jabatan" class="col-sm-3 control-label">UNIT KERJA</label>
						<div class="col-sm-8">
							<!-- <select class="form-control" id="unkerfilter" name="unkerfilter"></select> -->
							<span id="unkerfilter" style="font-weight: bold; color:red; font-size: 14px; position: relative; top: 5px;"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="label_jnsjab" class="col-sm-3 control-label">JENIS DIKLAT</label>
						<div class="col-sm-9">
							<div class="radio">
								<label style="padding-right: 20px;">
									<input type="radio" name="jnsjbFilter" id="inlineRadioFilter1" value="STRUKTURAL">
									<span style="top:4px; position: relative;">STRUKTURAL</span>
								</label>
								
								<label style="padding-left: 20px;">
									<input type="radio" name="jnsjbFilter" id="inlineRadioFilter2" value="TEKNIS FUNGSIONAL">
									<span style="top:4px; position: relative;">TEKNIS FUNGSIONAL</span>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="nama_jabatan" class="col-sm-3 control-label">JABATAN STRUKTURAL</label>
						<div class="col-sm-8">
							<a style="display:none; position: absolute;top:8px; cursor: pointer; right: -10px; float: right; z-index: 999;" onclick="close_jabatanfilter()" id="r_edit"><i class="glyphicon glyphicon-remove"></i></a>
						<select class="form-control" name="jabatan_sekarang" id="jabatanfilter" style="display:none;"></select>
						
						<a style="position: relative;top:5px; float: right; cursor: pointer; margin-right: 5px; z-index: 999;" onclick="show_jabatanfilter()" id="l_edit"><i class="glyphicon glyphicon-edit"></i></a>
						<span style="font-size: 12px; font-weight: bold; color:red; position: relative;top:5px;" id="nama_jabatan">
							
						</div>
					</div>
					
					<div class="form-group teknis_fungsional_fil" style="display: none;">
						<label for="nama_jabatan" class="col-sm-3 control-label">RIWAYAT DIKLAT</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="nama_diklat_filter" id="nm_diklat_filter" placeholder="Nama Diklat, enter pisah kata.." style="margin-bottom: 5px;">
							<!-- <span class="text-danger"> *) Gunakan <b>KOMA (,)</b> untuk memisahkan Nama Diklat...</span> -->
						</div>
					</div>
					<div class="form-group struktural_fil" style="display: none;">
						<label for="nama_diklat" class="col-sm-3 control-label">Nama Diklat Struktural: </label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="radio" name="nama_dik_fil" id="inlineCheckbox1" value="PIM I">
								<span style="top:2px; left:0px; color:darkgreen; position: relative;">PIM I</span>
							</label>
							<label class="radio-inline">
								<input type="radio" name="nama_dik_fil" id="inlineCheckbox2" value="PIM II"> <span style="top:2px; left:0px; color:darkgreen; position: relative;">PIM II</span>
							</label>
							<label class="radio-inline">
								<input type="radio" name="nama_dik_fil" id="inlineCheckbox3" value="PIM III"> <span style="top:2px; left:0px; color:darkgreen; position: relative;">PIM III</span>
							</label>
							<label class="radio-inline">
								<input type="radio" name="nama_dik_fil" id="inlineCheckbox4" value="PIM IV"> <span style="top:2px; left:0px; color:darkgreen; position: relative;">PIM IV</span>
							</label>
							<!-- <label class="radio-inline">
								<input type="radio" name="nama_dik_fil" id="inlineCheckbox5" value="PRAJABATAN"> <span style="top:2px; left:0px; color:darkgreen; position: relative;">PRAJABATAN</span>
							</label> -->							
						</div>
					</div>
				</form>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="update()">UPDATE</button>
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
<?php $this->load->view($syarat_diklat) ?>
<script>
// $('#nm').tagsinput({
//     maxTags: 6
// });

function show_jabatanfilter() {
    $("#jabatanfilter").css("display", "block");
    $("span#nama_jabatan").css("display", "none");
    $("a#l_edit").css("display", "none");
    $("a#r_edit").css("display", "block");
    $("span.info").css("display", "block");
}

function close_jabatanfilter() {
    $("#jabatanfilter").css("display", "none");
    $("span#nama_jabatan").css("display", "block");
    $("a#l_edit").css("display", "block");
    $("a#r_edit").css("display", "none");
    $("span.info").css("display", "none");
    jabstruk_filter();
}
$("button#add").click(function(e) {
    if (e) {
        $("#collapseAdd").fadeIn();
    } else {
        $("#collapseAdd").fadeOut();
    }
});
$("button#close").click(function(e) {
    if (e) {
        $("#collapseAdd").fadeOut();
    } else {
        $("#collapseAdd").fadeIn();
    }
});
</script>