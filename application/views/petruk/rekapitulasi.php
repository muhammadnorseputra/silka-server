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
							  	<?php foreach($f_tahun->result() as $ft): ?>
							  		<option value="<?= $ft->tahun ?>"><?= $ft->tahun ?></option>
							  	<?php endforeach ?>
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
              <th class="none">SURAT USULAN</th>
              <th class="none">DAFTAR RIWAYAT HIDUP</th>
              <th class="none">SK PANGKAT TERAKHIR</th>
              <th class="none">SK JABATAN TERAKHIR</th>
              <th class="none">PENILAIAN KINERJA</th>
              <th class="none">SERTIFIKAT / PIAGAM</th>
              <th class="none">SUPER HUKDIS</th>
              <th class="none">PROPOSAL INNOVASI</th>
              <th class="none">PERSENTASE KEHADIRAN 3 BULAN TERAKHIR</th>
              <th>TOTAL PENILAIAN MANDIRI</th>
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


<!-- Modal Tambahan Nilai -->
<div class="modal fade" id="TAMBAHANNILAI" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="TAMBAHANNILAILabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <?= form_open(base_url('petruk/simpan_tambahan_nilai'), ['id' => 'form_horizontal', 'class' => 'f_tambahan_nilai'], ['id' => '']) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="TAMBAHANNILAILabel">DAFTAR PENILAIAN MANDIRI</h3>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover" width="100%">
          <tbody>
            <tr class="bg-warning">
              <td width="5%">1</td>
              <td colspan="2"><b>Inovatif</b></td>
            </tr>
            <tr>
              <td colspan="2"><b>Orisinalitas</b> <br>Range Nilai :<span class="label label-info">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_orisinalitas" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Efesiensi/Efektivitasfesiansi</b> <br>Range Nilai :<span class="label label-info">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_efesiansi" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Keberlanjutan</b> <br>Range Nilai :<span class="label label-info">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_keberlanjutan" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Manfaat/Dampak</b> <br>Range Nilai :<span class="label label-info">0-40</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_manfaat" min="0" max="40" minlength="0" maxlength="40" required></td>
            </tr>
            <tr class="bg-warning">
              <td width="5%">2</td>
              <td colspan="2"><b>Kinerja & Disiplin 2024 (Kinerja sampai bulan Juni/semester 1)</b></td>
            </tr>
            <tr>
              <td colspan="2"><b>Berdampak pada Organisasi</b> <br>Range Nilai :<span class="label label-success">0-40</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_dampak_organisasi" min="0" max="40" minlength="0" maxlength="40" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Keterlibatan dalam Tim Kerja</b> <br>Range Nilai :<span class="label label-success">0-40</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_keterlibatan" min="0" max="40" minlength="0" maxlength="40" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Disiplin 3 Bulan Terakhir</b> <br>Range Nilai :<span class="label label-success">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_disiplin" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr class="bg-warning">
              <td width="5%">3</td>
              <td colspan="2"><b>Rekam Jejak </b></td>
            </tr>
            <tr>
              <td colspan="2"><b>Pengalaman Jabatan</b> <br>Range Nilai :<span class="label label-warning">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_pengalaman_jabatan" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Pengembangan Kompetensi</b> <br>Range Nilai :<span class="label label-warning">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_pengembangan_kopetensi" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Penghargaan yang diterima</b> <br>Range Nilai :<span class="label label-warning">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_penghargaan_diterima" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Moralitas / Kedisiplinan</b> <br>Range Nilai :<span class="label label-warning">0-20</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_moralitas" min="0" max="20" minlength="0" maxlength="20" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Tingkat Pendidikan</b> <br>Range Nilai :<span class="label label-warning">0-10</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_tingkat_pendidikan" min="0" max="10" minlength="0" maxlength="10" required></td>
            </tr>
            <tr>
              <td colspan="2"><b>Penugasan Lain</b> <br>Range Nilai :<span class="label label-warning">0-10</span></td>
              <td width="15%"><input type="number" class="form-control" name="skor_integritas" min="0" max="10" minlength="0" maxlength="10" required></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN PENILAIAN</button>
      </div>
    </div>
   <?= form_close();?>
  </div>
</div>

<!-- Modal Piagam -->
<div class="modal fade" id="exampleModal" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <?= form_open(base_url('petruk/simpan_nomor_piagam'), ['id' => 'form_horizontal', 'class' => 'f_nomor_piagam'], ['id' => '']) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Piagam</h3>
      </div>
      <div class="modal-body">
        	<div class="form-group">
		    <label for="exampleFormControlInput1">Nomor Sertificate</label>
		    <input type="text" name="nomor_piagam" class="form-control" id="exampleFormControlInput1" placeholder="Contoh: 800/.../BKPPD-BLG/2021">
		   </div>
		   <div class="form-group">
		    <label for="exampleFormControlInput2">Tanggal Sertificate</label>
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
  $(".f_tambahan_nilai")[0].reset();
});

$(document).on('click', 'a#TAMBAH_NILAI', function(event) {
	event.preventDefault();
	var $URL = $(this).attr('href');
	var $ID  = $(this).attr('id_petruk');
  var $NILAI = $(this).data('nilai');
	if($ID != '') {
    	$('input[name="skor_orisinalitas"]').val($NILAI.data.skor_orisinalitas);
    	$('input[name="skor_efesiansi"]').val($NILAI.data.skor_efesiansi);
    	$('input[name="skor_keberlanjutan"]').val($NILAI.data.skor_keberlanjutan);
    	$('input[name="skor_manfaat"]').val($NILAI.data.skor_manfaat);
    	$('input[name="skor_dampak_organisasi"]').val($NILAI.data.skor_dampak_organisasi);
    	$('input[name="skor_keterlibatan"]').val($NILAI.data.skor_keterlibatan);
    	$('input[name="skor_disiplin"]').val($NILAI.data.skor_disiplin);
    	$('input[name="skor_pengalaman_jabatan"]').val($NILAI.data.skor_pengalaman_jabatan);
    	$('input[name="skor_pengembangan_kopetensi"]').val($NILAI.data.skor_pengembangan_kopetensi);
    	$('input[name="skor_penghargaan_diterima"]').val($NILAI.data.skor_penghargaan_diterima);
    	$('input[name="skor_moralitas"]').val($NILAI.data.skor_moralitas);
    	$('input[name="skor_tingkat_pendidikan"]').val($NILAI.data.skor_tingkat_pendidikan);
    	$('input[name="skor_integritas"]').val($NILAI.data.skor_integritas);  
    }
    $('input[name="id"]').val($ID);
    $('#TAMBAHANNILAI').modal('show');
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

$(".f_tambahan_nilai").unbind().bind('submit', function(e) {
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
			$('#TAMBAHANNILAI').modal('hide');
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