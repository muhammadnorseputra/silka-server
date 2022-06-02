
<div class="col-sm-4" style="border-right: 1px solid #eee;">
	<h3 class="page-header"><i class="glyphicon glyphicon-check "></i> SENSUS JABATAN <!-- SISTEM APLIKASI MUTASI <span style="padding-left:30px;">(SAMUT)</span> --></h3>
	<div class="clearfix"></div>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
         1. Apa itu sensus analisis jabatan?
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <p>
        	Analisis jabatan adalah suatu kegiatan pengumpulan, penilaian dan penyusunan berbagai informasi secara sistematis yang berkaitan dengan jabatan. Atau definisi analisis jabatan yaitu merupakan kegiatan untuk mempelajari dan menyimpulkan keterangan-keterangan ataupun fakta-fakta yang berkaitan dengan jabatan secara sistematis dan teratur. 
        </p>
        <p>
			Teknis Analisis Jabatan merupakan suatu proses dimana sejumlah pekerjaan dibagi-bagi untuk menentukan tugas dan tanggung jawab yang ada hubungannya dengan pekerjaan, persyaratan apa saja yang harus dipenuhi dimana pekerjaan tersebut dilakukan dan kapabilitas personal yang disyaratkan untuk mencapai kinerja yang maksimal.
        </p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          2. Apa tujuan dari analisis jabatan tersebut?
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
      	<p>
		    Adapun beberapa tujuan analisis jabatan yaitu untuk menciptakan Sumber Daya Manusia (SDM) berkualitas dalam menghadapi perkembangan ekonomi, untuk menciptakan kenyamanan saat bekerja dan supaya terkendali dalam pekerjaan pada suatu perusahaan atau organisasi, yang didalamnya termasuk untuk menentukan:

		    <ul>
		    <li>Apa saja yang dilakukan oleh pekerja pada jabatan yang di dudukinya.</li>
		    <li>Apa saja wewenang dan tanggung jawab pekerja pada jabatan yang di dudukinya.</li>
		    <li>Mengapa pekerjaan tersebut perlu dilakukan dan bagaimana cara melakukan pekerjaan tersebut.</li>
		    <li>Peralatan apa saja yang diperlukan dalam menjalankan pekerjaan tersebut.</li>
		    <li>Berapa besar gaji dan seberapa lama jam kerjanya.</li>
		    <li>Pendidikan, pelatihan dan pengalaman apa saja yang diperlukan untuk menjalankan pekerjaan tersebut.</li>
		    <li>Dan kemampuan, sikap apa saja yang diperlukan dalam menjalankan pekerjaan tersebut.</li>
			</ul>
      	</p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          3. Apa saja manfaat dari analisis jabatan?
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
      	<p>
		    Analisis jabatan memiliki banyak manfaat untuk pimpinan suatu perusahaan atau organisasi, salah satunya untuk memecahkan masalah mengenai kepegawaian khususnya yang berkaitan dengan tugas yang harus dilakukan oleh pekerja pada perusahaan tersebut. Adapun beberapa manfaat analisis jabatan, yang diantaranya yaitu:

		    <ul>
			   <li>Untuk penarikan dan seleksi tenaga kerja.</li>
				<li>Untuk penempatan posisi dari tenaga kerja.</li>
				<li>Untuk menentukan pendidikan maupun pelatihan dari tenaga kerja.</li>
				<li>Untuk keperluan penilaian kerja.</li>
				<li>Untuk perbaikan syarat-syarat dalam pekerjaan.</li>
				<li>Untuk promosi jabatan pada tenaga kerja.</li>
				<li>Untuk perencanaan organisasi.</li>
			</ul>
      	</p>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
          4. Bagaimana saya menganalisis jabatan?
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">
        <p>
          blaa blaa blaa blaa 
        </p>
      </div>
    </div>
  </div>  
</div>
<hr>
<a class="btn btn-sm btn-primary pull-right" style="margin-left: 5px;" role="button" data-toggle="modal" href="#myModal"><i class="glyphicon glyphicon-plus "></i> Form Sensus</a>
<span class="text-danger pull-right" style="margin-top:5px; font-size:14px;">Apakah anda sudah mendaftarkan diri?</span> 
<div class="clearfix"></div>
<p></p>

<div class="modal fade" id="myModalEdit" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" action="" method="post">
      <input type="hidden" name="aj_syaratjab_sensus">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">EDIT</h4>
      </div>
      <div class="modal-body">
        <div id="pesan_edit"></div>
        <div class="form-group">
          <label for="jabstruk" class="col-sm-2 control-label">Jabatan</label>

          <div class="col-sm-6">
          <select class="form-control" name="n_jabatan_edit" id="n_jabatan_edit">
              <option value="">-- Nama Jabatan --</option>
              <?php foreach ($n_jab as $nj) { ?>
                <option value="<?php echo $nj->id_aj_syaratjab ?>"><?php echo $nj->n_jabatan ?></option>
              <?php } ?>

            </select>
          </div>
        </div>  

        <div class="form-group" id="eselon2">
          <label for="jnsjb" class="col-sm-2 control-label">Eselon</label>
          <div class="col-sm-3">
            <select class="form-control" name="esl2_edit" id="esl2select">
              <option value=""> II </option>
              <?php foreach ($eselon_2 as $e2) { ?>
                <option value="<?php echo $e2->id_jabatan ?>"><?php echo $e2->nama_jabatan ?></option>
              <?php } ?>               
            </select>
          </div>
          <div class="col-sm-3">
            <select class="form-control" name="esl3_edit" id="esl3select">
              <option value=""> III  </option>
              <?php foreach ($eselon_3 as $e3) { ?>
                <option value="<?php echo $e3->id_jabatan ?>"><?php echo $e3->nama_jabatan ?></option>
              <?php } ?>               
            </select>
          </div>
          <div class="col-sm-3">
          <select class="form-control"  name="esl4_edit" id="esl4select">
            <option value=""> IV  </option>
              <?php foreach ($eselon_4 as $e4) { ?>
                <option value="<?php echo $e4->id_jabatan ?>"><?php echo $e4->nama_jabatan ?></option>
              <?php } ?>             
          </select>
          </div>          
        </div>              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CLOSE</button>
        <button type="button" class="btn btn-primary" onclick="updatedatapemangku()">UPDATE</button>
      </div>      
    </div>
    </form>
  </div>
</div>


<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-lg">
    <form class="form-horizontal" action="" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Sensus Jabatan</h4>
      </div>
      <div class="modal-body">

        <div id="pesan"></div>  
        <div class="form-group">
          <label for="search" class="col-sm-2 control-label">Cari PNS</label>
          <div class="col-sm-5">
            <!-- <input type="text" class="form-control" id="search" name="search">
            <ul id="finalResult"></ul> -->
            <select multiple class="form-control nipsel" onchange="cek_data()" id="nipsel" name="nipsel">
                <option value="">-- Pilih PNS --</option>
              <?php foreach ($peg as $p) { ?>
                <option value="<?php echo $p->nip ?>" title="<?php echo $p->nama_unit_kerja ?>"><b><?php echo $p->nip ?></b> <?php echo $p->nama ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="nip" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" name="nama_pns" readonly="">
          </div>
          <label for="nip" class="col-sm-1 control-label">NIP</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="nip_pns" name="nip" readonly="">
          </div>
        </div>

        <div class="form-group">
          <label for="pangkat" class="col-sm-2 control-label">Pangkat</label>
         
          <!--  <div style="margin-top:7px;"><b><span id="pangkat"></span></b> <span id="nama_golru"></span></div> -->
          <div class="col-sm-3">
            <input type="text" class="form-control" name="pangkat" readonly="">
          </div>
          <label for="nama_golru" class="col-sm-1 control-label">Dalam Golru</label>
          <div class="col-sm-1" style="min-width: 90px;">
            <input type="text" class="form-control" name="nama_golru" readonly="">
            <input type="hidden" id="idgolru" name="fid_golru" class="form-control">
          </div> 
        </div>

       <div class="form-group">
          <label for="unker" class="col-sm-2 control-label">Unit Kerja</label>
          <div class="col-sm-7">
            <select class="form-control" name="unker" id="unkersel" disabled>
              <option value="">-- Pilih Unit Kerja --</option>
              <?php foreach ($uk as $u) { ?>
                <option value="<?php echo $u->id_unit_kerja ?>"><?php echo $u->nama_unit_kerja ?></option>
              <?php } ?>
            </select>
          </div>
        </div>        

        <div class="form-group">
        <label for="jnsjb" class="col-sm-2 control-label">Jenis jabatan</label>
          <div class="col-sm-9">
            <label class="radio-inline">
              <input type="radio" name="fid_jenis_jabatan" value="1" id="optionsRadios2" disabled> <!-- 0 -->
              Struktural
            </label>

            <label class="radio-inline">
              <input type="radio" name="fid_jenis_jabatan" value="2" id="optionsRadios3" disabled> <!-- 1 -->
              Jabatan Pelaksana
            </label>

            <label class="radio-inline" >
              <input type="radio" name="fid_jenis_jabatan" value="3" id="optionsRadios4" disabled> <!-- 2 -->
              Jabatan Fungsional Tertentu
            </label>
          </div>
        </div>

        <div class="form-group">
          <label for="jabstruk" class="col-sm-2 control-label">Jabatan</label>

          <div class="col-sm-3">
          <select class="form-control" name="n_jabatan" disabled>
              <option value="">-- Nama Jabatan --</option>
              <?php foreach ($n_jab as $nj) { ?>
                <option value="<?php echo $nj->id_aj_syaratjab ?>"><?php echo $nj->n_jabatan ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="col-sm-3">
            <select class="form-control" name="fid_jabatan" id="jabstruk" style="display: none; width: 440px;" disabled>
              <option value="">-- Pilih Jabatan Struktural--</option>
              <?php foreach ($jab_struk as $s) { ?>
                <option value="<?php echo $s->id_jabatan ?>"><?php echo $s->nama_jabatan ?></option>
              <?php } ?> 
            </select>

            <select class="form-control" name="fid_jabft" id="jabftsel" style="display: none; width: 440px;" disabled>
              <option value="">-- Pilih Jabatan Fungsional Tertentu--</option>
              <?php foreach ($jab_ft as $ft) { ?>
                <option value="<?php echo $ft->id_jabft ?>"><?php echo $ft->nama_jabft ?></option>
              <?php } ?>              
            </select>

            <select class="form-control" name="fid_jabfu" id="jabfusel" style="display: none; width: 440px;" disabled>
              <option value="">-- Pilih Jabatan Pelaksana--</option>
              <?php foreach ($jab_fu as $fu) { ?>
                <option value="<?php echo $fu->id_jabfu ?>"><?php echo $fu->nama_jabfu ?></option>
              <?php } ?>
            </select>       
          </div>

        </div>

        <div class="form-group" id="eselon2">
          <label for="jnsjb" class="col-sm-2 control-label">Eselon</label>
          <div class="col-sm-3">
            <select class="form-control" name="esl2_sensus" id="esl2select" disabled>
              <option value="">-- Eselon II--</option>
              <?php foreach ($eselon_2 as $e2) { ?>
                <option value="<?php echo $e2->id_jabatan ?>"><?php echo $e2->nama_jabatan ?></option>
              <?php } ?>               
            </select>
          </div>
          <div class="col-sm-3">
            <select class="form-control" name="esl3_sensus" id="esl3select" disabled>
              <option value="">-- Eselon III --</option>
              <?php foreach ($eselon_3 as $e3) { ?>
                <option value="<?php echo $e3->id_jabatan ?>"><?php echo $e3->nama_jabatan ?></option>
              <?php } ?>               
            </select>
          </div>
          <div class="col-sm-3">
          <select class="form-control"  name="esl4_sensus" id="esl4select" disabled>
            <option value="">-- Eselon IV --</option>
              <?php foreach ($eselon_4 as $e4) { ?>
                <option value="<?php echo $e4->id_jabatan ?>"><?php echo $e4->nama_jabatan ?></option>
              <?php } ?>             
          </select>
          </div>          
        </div>

        <div class="form-group">
          <label for="nip" class="col-sm-2 control-label">TINGPEN</label>
          <div class="col-sm-1" style="min-width: 100px;">
            <input type="text" class="form-control" id="nip" name="tingpeng" readonly="">
            <input type="hidden" name="fid_tingkat_pendidikan" class="form-control">
          </div>
          <label for="nip" class="col-sm-1 control-label">Jurusan</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="jurusan" readonly="">
            <input type="hidden" name="fid_jurusan_pendidikan" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="nip" class="col-sm-2 control-label">Kelas Jabatan</label>
          <div class="col-sm-1">
            <input type="text" class="form-control" name="kelas_jabatan" id="kelas_jabatan" disabled>
          </div>
          <label for="nip" class="col-sm-3 control-label">JP Diklat</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="jp_diklat" disabled>
          </div>
        </div>
 
        <div class="form-group">
          <label for="nip" class="col-sm-2 control-label">Nilai SKP</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="skp" readonly="">
          </div>
          <label for="nip" class="col-sm-2 control-label">JML Cuti Sakit</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="csakit" disabled>
          </div>
        </div> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="simpandata()">Simpan Record</button>
      </div>
    </div><!-- /.modal-content -->
  </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div class="col-sm-8">
<div id="bg-loading" style="z-index: 1;"></div>

<div id="loading" style="z-index: 2;"><center><img src="<?php echo base_url('assets/loading5.gif') ?>"></center> Mohon Tunggu Sebentar...</div>

<!-- <h3 class="page-header">&nbsp;</h3>	 -->
<div class="panel panel-info">
  <div class="panel-heading"><b>Tabel Sensus</b><!-- <br>Jumlah - Anjab: 8 Asn --> 

      <button class="btn btn-xs btn-danger pull-right" onclick="location.reload()"><i class="glyphicon glyphicon-repeat"></i> Reload Table</button>
  </div>
  <div class="panel-body" style="height: 600px; overflow: scroll; overflow-x: hidden;">
    <div class="table-responsive">
        <table class="table table-responsive table-condensed table-striped display" id="myTable">
          <thead>
            <tr>
              <th width="20">NO</th>
              <th width="300"><u>NIP</u> <small>Nama</small></th>
              <th>Info Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel_data_sensus"></tbody>
        </table>
    </div>
    </div>
</div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css') ?>">
<script src="<?php echo base_url('assets/datatables/datatables.min.js') ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('assets/sweetalert/sweetalert.css') ?>">
<script src="<?php echo base_url('assets/sweetalert/sweetalert.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>


<script type="text/javascript">
  $("#loading").hide();
  $("#bg-loading").hide();

$(".nipsel").select2({
  width: '350px',
  placeholder: 'NIP / NAMA',
  minimumResultsForSearch: 1,
  maximumSelectionLength: 1,
  minimumInputLength: 3,
  // maximumInputLength: 20,
  language: {
  inputTooShort: function () {
    return "Silahkan Masukan Karakter Sesuai NIP/NAMA...";
  }
}
});
$("[name='n_jabatan'], #esl2select, #esl3select, #esl4select").select2({
   width: '200px' 
});

tablesensus();
function tablesensus(){
    $.ajax({
      type : "POST",
      url  : '<?php echo base_url()."anjab/getdatasensus" ?>',
      dataType : 'json',
      success: function (data) {
        var no=1;
        var baris = '';
        for(var i=0;i<data.length;i++){      
          
          if(data[i].fid_jabstruk != ''){
            var jabatan = "<em>"+data[i].nama_jab+"</em>";
          }else{
            var jabatan = '';
          }
          if(data[i].fid_jabfu != ''){
            var jfu = "<em>"+data[i].nama_jabfu+"</em>";
          }else{
            var jfu = '';
          }
          if(data[i].fid_jabft != ''){
            var jft = "<em>"+data[i].nama_jabft+"</em>";
          }else{
            var jft = '';
          }

          if(data[i].n_jab != null){
            var nama_jabatan = data[i].n_jab;
          }else{
            var nama_jabatan = "TANPA JABATAN";
          }

          baris += '<tr>'+
                      '<td align="center">'+no+'</td>' 
                      +
                      '<td><img src="<?php echo base_url('photo') ?>/'+data[i].nip+'.jpg" width="90" class="img-rounded pull-left" style="margin-right:5px;" alt="'+data[i].nama+'"> <b><br>'+data[i].nama+'</b><br> | '+data[i].nip+'<br><span style="color:#999; font-weight:normal;">'+data[i].unker+'</span></td>'
                      +
                      '<td><b><u>'+data[i].nama_jenis_jabatan+'</u></b> [ '+nama_jabatan+' ]<br>'+jabatan+' '+jfu+' '+jft+'<hr>Kelas Jabatan <b>('+data[i].kelas_jabatan+') </b>| <span style="color:#965683; font-weight:bold;">'+data[i].tingpen+' - '+data[i].jurusan+'</span><br>NILAI SKP: <span class="badge">'+data[i].skp+'</span><br>CUTI SAKIT: '+data[i].jml_cuti_sakit+' HARI <br> JP DIKLAT: ['+data[i].jp_diklat+'] JAM</td>'
                      +
                      '<td align="center" width="80"><a class="btn btn-xs btn-danger" onclick="hapus('+data[i].aj_syaratjab_sensus+')"><i class="glyphicon glyphicon-trash"></i></a> <a class="btn btn-xs btn-primary" onclick="edit('+data[i].aj_syaratjab_sensus+')" data-toggle="modal" class="modal" data-target="#myModalEdit"><i class="glyphicon glyphicon-edit"></i></a></td>'
                  +'</tr>';
        no++;
        }
              // var resultHendrel = $('#tabel_data_sensus').html(baris);
              $('#tabel_data_sensus').html(baris);
      },
      complete: function(){
              var dataTable = $("#myTable").DataTable();  
      }

        
    });
  }

function edit(z){
    $.ajax({
      type: 'POST',
      data: 'id='+z,
      url : '<?php echo base_url()."anjab/editdatapemangku" ?>',
      dataType: 'json',
      success: function(result){
        var nj = result[0].n_jabatan;
        var id = result[0].aj_syaratjab_sensus;

        var esel2 = result[0].fid_jabesl2;
        var esel3 = result[0].fid_jabesl3;
        var esel4 = result[0].fid_jabesl4;

        if(nj != null){
          $("[name ='n_jabatan_edit']").val(nj);
        }else{
          $("[name ='n_jabatan_edit']").val("");
        }
        $("[name ='aj_syaratjab_sensus']").val(id);
        

        $("[name='esl2_edit']").val(esel2);
        $("[name='esl3_edit']").val(esel3);
        $("[name='esl4_edit']").val(esel4);
      }
    });
}

function updatedatapemangku(){
    var id = $("[name ='aj_syaratjab_sensus']").val();
    var nj = $("[name ='n_jabatan_edit']").val();

    var esel2 = $("[name='esl2_edit']").val();
    var esel3 = $("[name='esl3_edit']").val();
    var esel4 = $("[name='esl4_edit']").val();

      $.ajax({
        type: 'POST',
        url : '<?php echo base_url()."anjab/updatedatapemangku" ?>',
        dataType: 'json',
        data: 'id='+id+'&njab='+nj+'&esel2='+esel2+'&esel3='+esel3+'&esel4='+esel4,
        success: function(rest){
         
           if(rest.status == '1'){
            $('#pesan_edit').html(rest.hasil1);
           }else{
            $('#pesan_edit').html(rest.hasil);
            tablesensus();
            swal({
              title: "Success!",
              text: "Data Telah Diupdate",
              type: "success",
              timer: "1500",
              showConfirmButton: false
            });
            var counter = 1;
            var counterId = setInterval(function(){

             counter = 1;
             $("#myModalEdit").modal('hide');
             if(counter == 1){
              clearInterval(counterId);
             }
            },1700);
           }
        }
      });    
}

function cek_data(){
  var nip = $("#nipsel").val();
  var id  = $("#selectId").attr("class"); 
  if(nip != ''){
  $.ajax({
    url: '<?php echo base_url()."anjab/showdata" ?>',
    data: 'nip='+nip+'&idunker='+id,
    type: 'POST',
  }).success(function(hasil){
      var json = hasil,
          obj = JSON.parse(json);

      $("[name='nama_pns']").val(obj[0].nama);

      $("[name ='n_jabatan']").prop('disabled', false);

      $("[name='unker']").val(obj[0].fid_unit_kerja);
      $("[name='nip']").val(obj[0].nip_pns);

      $("[name ='pangkat']").val(obj[0].nama_pangkat);
      $("[name ='nama_golru']").val(obj[0].nama_golru);
      $("[name ='fid_golru']").val(obj[0].id_golru);


      $("[name ='jurusan']").val(obj[0].nama_jurusan_pendidikan);
      $("[name ='fid_tingkat_pendidikan']").val(obj[0].id_tingkat_pendidikan);

      $("[name ='tingpeng']").val(obj[0].nama_tingkat_pendidikan);
      $("[name ='fid_jurusan_pendidikan']").val(obj[0].id_jurusan_pendidikan);

      if(obj[0].nilai_skp != null){
        $("[name='skp']").val(obj[0].nilai_skp);
      }else{
        $("[name='skp']").val('0');
      }

      if(obj[0].jml != null){
        $("[name='csakit']").val(obj[0].jml+" "+obj[0].satuan_jml);
      }else{
        $("[name='csakit']").val('Usul Kosong');
      }

      if(obj[0].lama_jam != null){
        $("[name ='jp_diklat'").val(obj[0].lama_jam+" JAM");
      }else{
        $("[name ='jp_diklat'").val('Belum Diklat');
      }

      var tingpen = obj[0].id_tingkat_pendidikan;
      if(tingpen == '01'){
        $("#kelas_jabatan").val("3");
      }
      if(tingpen == '02'){
        $("#kelas_jabatan").val("4");
      }
      if(tingpen == '03'){
        $("#kelas_jabatan").val("5");
      }
      if(tingpen == '04'){
        $("#kelas_jabatan").val("6");
      }
      if(tingpen == '05'){
        $("#kelas_jabatan").val("6");
      }
      if(tingpen == '06'){
        $("#kelas_jabatan").val("6");
      }
      if(tingpen == '08' || tingpen == '07'){
        $("#kelas_jabatan").val("7");
      }
      if(tingpen == '09'){
        $("#kelas_jabatan").val("9");
      }
      if(tingpen == '10'){
        $("#kelas_jabatan").val("10");
      }
      if(tingpen == '98'){
        $("#kelas_jabatan").val("Tidak Tamat SD");
      }
      if(tingpen == '99'){
        $("#kelas_jabatan").val("Belum Sekolah");
      }


      var type = $("[name ='fid_jenis_jabatan']");
      // if(nip == ''){
      //   $("[name ='esl2_sensus']").prop("disabled",true);
      //   $("[name ='esl3_sensus']").prop("disabled",true);
      //   $("[name ='esl4_sensus']").prop("disabled",true);      
      // }else{
        if(obj[0].fid_jnsjab == '1' && obj[0].fid_jabatan != '' || type[0].checked){
          var val = type[0].value = "1";
          $("[name ='fid_jenis_jabatan']").val(val);
          $("#optionsRadios2").prop("checked", true).prop("disabled", false);
          $("#optionsRadios3").prop("disabled", true);
          $("#optionsRadios4").prop("disabled", true);

          $("#jabstruk").prop("disabled", true).val(obj[0].fid_jabatan).css("display","block");
          $("#jabfusel").prop("disabled", true).val('').css("display","none");
          $("#jabftsel").prop("disabled", true).val('').css("display","none");

          $("[name ='esl2_sensus']").prop("disabled",false);
          $("[name ='esl3_sensus']").prop("disabled",false);
          $("[name ='esl4_sensus']").prop("disabled",false);

        }
        if(obj[0].fid_jnsjab == '2' && obj[0].fid_jabfu != '' || type[1].checked){
          var val = type[1].value = "2";
          $("[name ='fid_jenis_jabatan']").val(val);

          $("#optionsRadios2").prop("disabled", true);
          $("#optionsRadios3").prop("checked", true).prop("disabled", false);
          $("#optionsRadios4").prop("disabled", true);

          $("#jabstruk").prop("disabled", true).val('').css("display","none");
          $("#jabfusel").prop("disabled", true).val(obj[0].fid_jabfu).css("display","block");
          $("#jabftsel").prop("disabled", true).val('').css("display","none");

          $("[name ='esl2_sensus']").prop("disabled",false);
          $("[name ='esl3_sensus']").prop("disabled",false);
          $("[name ='esl4_sensus']").prop("disabled",false);

        }
        if(obj[0].fid_jnsjab == '3' && obj[0].fid_jabft != '' || type[2].checked){
          var val = type[2].value = "3";
          $("[name ='fid_jenis_jabatan']").val(val);
          $("#optionsRadios2").prop("disabled", true);
          $("#optionsRadios3").prop("disabled", true);
          $("#optionsRadios4").prop("checked", true).prop("disabled", false);

          $("#jabstruk").prop("disabled", true).val('').css("display","none");
          $("#jabfusel").prop("disabled", true).val('').css("display","none");
          $("#jabftsel").prop("disabled", true).val(obj[0].fid_jabft).css("display","block");

          $("[name ='esl2_sensus']").prop("disabled",true);
          $("[name ='esl3_sensus']").prop("disabled",true);
          $("[name ='esl4_sensus']").prop("disabled",true);
        }
      // }

  });
  }else{
      $("[name='nama_pns']").val('');
      $("[name='fid_jenis_jabatan']").val('');

      $("[name ='n_jabatan']").prop('disabled', true);

      $("[name='unker']").val('');
      $("[name='nip']").val('');
  }
}

//FUNGSI SIMPAN DATA
 function simpandata(){
  var nipsel = $("[name ='nipsel']").val();

  var nip_pns = $("[name='nip']").val();
  var unker_pns = $("[name='unker']").val();
  var j_jabatan_pns = $("[name ='fid_jenis_jabatan']").val();

  var jabstruk_pns = $("[name='fid_jabatan']").val();
  var jabft_pns = $("[name='fid_jabft']").val();
  var jabfu_pns = $("[name='fid_jabfu']").val();

  var esl2_pns = $("[name='esl2_sensus']").val();
  var esl3_pns = $("[name='esl3_sensus']").val();
  var esl4_pns = $("[name='esl4_sensus']").val();

  var klsjab_pns = $("[name='kelas_jabatan']").val();
  var njab_pns = $("[name='n_jabatan']").val();
  var golru_pns = $("[name='fid_golru']").val();
  var tingpen = $("[name='fid_tingkat_pendidikan']").val();
  var jurusan = $("[name='fid_jurusan_pendidikan']").val();
  var jp_diklat_pns = $("[name='jp_diklat']").val();
  var skp_pns = $("[name='skp']").val();
  var csakit_pns = $("[name='csakit']").val();


  // var add = $("[name ='created_by']").val();
  // var at  = $("[name ='created_at']").val();

  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."anjab/p_simpandatasensus" ?>',
    data: 'nipsel='+nipsel+'&nip='+nip_pns+'&unker='+unker_pns+'&j_jab='+j_jabatan_pns+'&jbs='+jabstruk_pns+'&jft='+jabft_pns+'&jfu='+jabfu_pns+'&esl2='+esl2_pns+'&esl3='+esl3_pns+'&esl4='+esl4_pns+'&klsjab='+klsjab_pns+'&njab='+njab_pns+'&golru='+golru_pns+'&tingpen='+tingpen+'&jurusan='+jurusan+'&jp='+jp_diklat_pns+'&skp='+skp_pns+'&csakit='+csakit_pns,
    dataType: 'json',
    success: function(result){
      if(result.status == ''){
          $("#nipsel").value = "";

          $("[name ='nip']").val('');
          $("[name ='nama_pns']").val('');
          $("[name ='nama_golru']").val('');

          $("[name ='fid_jenis_jabatan']").val('');

          $("[name ='unker']").val('');
          
          $("[name ='fid_jabatan']").val('');
          $("[name ='fid_jabft']").val('');
          $("[name ='fid_jabfu']").val('');

          $("[name ='esl2']").val('');
          $("[name ='esl3']").val('');
          $("[name ='esl4']").val('');

          $("[name ='kelas_jabatan']").val('');
          $("[name ='n_jabatan']").val('');
          $("[name ='fid_golru']").val('');
          $("[name ='tingpeng']").val('');
          $("[name ='jurusan']").val('');
          $("[name ='jp_diklat']").val('');
          $("[name ='skp']").val('');
          $("[name ='csakit']").val('');
          $("[name ='created_by']").val('');
          $("[name ='created_at']").val('');     
          $("[name ='pangkat']").val('');

 
          $("#myModal").modal('hide');  
          //$("#pesan").html(result.msg); 
          //swal("Success!", "1 Baris Data Telah Ditambahkan!", "success");
            swal({
              title: "Success!",
              text: "1 Baris Data Telah Ditambahkan",
              type: "success",
              showConfirmButton: false,
              timer: 1500
            });
          setTimeout(function() {
            tablesensus();
          }, 1000);            

      }else if(result.status == '1'){
          //$("#pesan").html(result.msg1);
      }else if(result.status == '2'){
          // $("#pesan").html(result.msg2);  
          swal("error", result.msg2, "error");
      }else{
          $("#optionsRadios2").val(1);
          $("#optionsRadios3").val(2);
          $("#optionsRadios4").val(3);
      }
      // else if(result.status == '3'){
      //     $("#pesan").html(result.msg3);  
      // }


    },
    error: function(){
      swal("error", "Sistem tidak merespon :)", "error");
    }
  });

 }

function hapus(id){
  swal({
    title: "Apakah anda yakin?",
    text: "Anda akan menghapus 1 baris data!",
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
            data: 'id='+ id,
            url : '<?php echo base_url()."anjab/hapusdatasensus" ?>',
            success: function(){
              setTimeout(function(){
               swal("Deleted!", "1 baris data telah terhapus.", "success");
              }, 1000);
            },
            beforeSend : function(){
              $("#loading").show().css('display', 'block');
              $("#bg-loading").show().css('display', 'block');
              // location.reload('fast');
            },
            complete : function(){
              $("#loading").hide();
              $("#bg-loading").fadeOut('slow');
              tablesensus();
            },
            error: function(){
              swal("Error", "Terjadi kesalahan dalam penghapusan Record :)", "error");
            }
        });    
  });  
}

    //  function hapus(id){
    //   var tanya = confirm('Apakah anda takin akan menghapus data?');

    //   if(tanya){
    //     $.ajax({
    //         type: 'POST',
    //         data: 'id='+ id,
    //         url : '<?php echo base_url()."anjab/hapusdatasensus" ?>',
    //         success: function(){
    //            tablesensus();
    //         },
    //         beforeSend : function(){
    //           $("#loading").show();
    //           $("#bg-loading").show();
    //           // location.reload('fast');
    //         },
    //         complete : function(){
    //           $("#loading").hide();
    //           $("#bg-loading").fadeOut('slow');
    //         }
    //     });
    //   }
    // }
</script>

<style type="text/css">
  #bg-loading {
    background-color: #fff;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0.8;
    display: none;
  }
  #loading {
    position: absolute;
    top:20px;
    left: 40%;
    display: none;
  }

</style>