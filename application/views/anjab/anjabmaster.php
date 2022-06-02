
<div class="col-sm-4" style="border-right: 1px solid #eee;height:650px;min-height:305px; max-height: 100%; overflow: scroll; overflow-x: hidden;">
	<h3 class="page-header"><i class="glyphicon glyphicon-briefcase"></i>  Syarat Jabatan</h3>
	<div class="clearfix"></div>
<div id="msg"></div>
	<form class="form-horizontal" action="#" method="post" id="postdatamaster">
  <input type="hidden" name="id_syarat" value="">
  
        <div class="form-group">
          <label for="unker" class="col-sm-3 control-label">Unit Kerja</label>
          <div class="col-sm-9">
            <select class="form-control" name="unker" id="unkersel">
              <!-- <option value="">-- Pilih Unit Kerja --</option> -->
            </select>
          </div>
        </div>

        <script type="text/javascript">
              //query select jabatan
              function show(x)
              {

                var type = $("[name ='jnsjb']");
                if(x==0 && type[0].checked){
                  var val = type[0].value;
                  $("[name ='jnsjb']").val(val);
                  $('#jbs').css("display","block");
                  $('#eselon2').css("display","block");
                  $('#eselon3').css("display","block");
                  $('#eselon4').css("display","block");
                }else{
                  $('#jbs').css("display","none");
                }

                if(x==1 && type[1].checked){
                  var val = type[1].value;
                  $("[name ='jnsjb']").val(val);
                  $('#jfu').css("display","block");
                  // $('#eselon2').css("display","none");
                  // $('#eselon3').css("display","none");
                  // $('#eselon4').css("display","none");
                }else{
                  $('#jfu').css("display","none");
                }

                if(x==2 && type[2].checked){
                  var val = type[2].value;
                  $("[name ='jnsjb']").val(val);
                  $('#jft').css("display","block");
                  $('#eselon2').css("display","none");
                  $('#eselon3').css("display","none");
                  $('#eselon4').css("display","none");
                       
                }else{
                  $('#jft').css("display","none");
                }
                return false;
              }
        </script>

		<div class="form-group">
        <label for="jnsjb" class="col-sm-3 control-label">Jenis jabatan</label>
          <div class="col-sm-9">
			  <label class="radio-inline">
			    <input type="radio" name="jnsjb" id="optionsRadios2" onclick="show(0)" value="1">
			    Struktural
			  </label>

			  <label class="radio-inline">
			    <input type="radio" name="jnsjb" id="optionsRadios3" onclick="show(1)" value="2">
			    Jabatan Pelaksana
			  </label>

        <label class="radio-inline" >
          <input type="radio" name="jnsjb" id="optionsRadios4" onclick="show(2)" value="3">
          JFT
        </label>

          </div>
        </div>


        <div class="form-group" style="display: none;" id="jbs">
          <label for="jabstruk" class="col-sm-3 control-label">Jabstruk</label>
          <div class="col-sm-9">
            <select class="form-control" name="fid_jabstruk" id="jabstruk" disabled="">
              <option value="">-- Pilih Jabatan Struktural--</option> 
		        </select> 
          </div>
          <div class="clearfix"></div><br>
<!--           <label for="" class="col-sm-3 control-label">Nama Jabatan</label>
          <div class="col-sm-9">
            <input type="text" name="n_jabatan" class="form-control">
          </div> -->

        </div>


        <div class="form-group pilih-jabatan" style="display: none;" id="jfu">
          <label for="jfu" class="col-sm-3 control-label">Jabatan Pelaksana</label>
          <div class="col-sm-9">
            <select class="form-control" name="fid_jabfu" id="jabfusel">
              <option value="">-- Pilih Jabatan Pelaksana--</option>
            </select>
          </div>
          <div class="clearfix"></div><br>
          <label for="jfu" class="col-sm-3 control-label">Nama Jabatan</label>
          <div class="col-sm-9">
            <input type="text" name="n_jabatan" class="form-control">
          </div>          
        </div>

        <div class="form-group pilih-jabatan" style="display: none;" id="jft">
          <label for="jft" class="col-sm-3 control-label">JFT</label>
          <div class="col-sm-9">
            <select class="form-control" name="fid_jabft" id="jabftsel">
              <option value="">-- Pilih Jabatan Fungsional Tertentu--</option>
            </select>
          </div>
        </div>  

        <div class="form-group" id="eselon4">
          <label for="jnsjb" class="col-sm-3 control-label">Eselon IV</label>
          <div class="col-sm-9">

          <select class="form-control"  name="esl4" id="esl4select" disabled="disabled">
            <option value="">-- Eselon IV --</option>
          </select>

          </div>
        </div>

        <div class="form-group" id="eselon3">
          <label for="jnsjb" class="col-sm-3 control-label">Eselon III</label>
          <div class="col-sm-9">

          <select class="form-control" name="esl3" id="esl3select" disabled="disabled">
            <option value="">-- Eselon III --</option>
          </select>

          </div>
        </div>

		    <div class="form-group" id="eselon2">
          <label for="jnsjb" class="col-sm-3 control-label">Eselon II</label>
          <div class="col-sm-9">

          <select class="form-control" name="esl2" id="esl2select" disabled="disabled">
            <option value="">-- Eselon II--</option>
          </select>

          </div>
        </div>

        <div class="form-group">
          <label for="golru" class="col-sm-3 control-label">Golongan Ruang</label>
          <div class="col-sm-6">
            <select class="form-control" name="golru">
              <option value="">-- Pilih Golru --</option>
              <?php foreach ($golru as $g) { ?>
              <option value="<?php echo $g->id_golru ?>"> (<?php echo $g->nama_golru ?>) <?php echo $g->nama_pangkat ?></option>
              <?php } ?>
            </select>
          </div>
        </div>  

<!--<div class="form-group">
	    <label for="namjab" class="col-sm-3 control-label">Nama Jabatan</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="namjab" placeholder="">
	    </div>
	  </div> -->

	  <div class="form-group">
	  	<label for="Pendidikan" class="col-sm-3 control-label">Pendidikan</label>
      <div class="col-sm-3">
        <select class="form-control" name="ting_pen">
          <option value="">- # -</option>
          <?php foreach ($tingpen as $tg) { ?>
          <option value="<?php echo $tg->id_tingkat_pendidikan ?>"> <?php echo $tg->nama_tingkat_pendidikan ?></option>
          <?php } ?>
        </select>
      </div> 
      <div class="col-sm-6">
	  		<select multiple class="form-control select_pendidikan" name="pendidikan[]" style="height: 300px;">
			  <option value="">-- Pilih Pendidikan --</option>
        <?php foreach ($getpdd as $p) {?>
          <option value="<?php echo $p->nama_jurusan_pendidikan ?>"><?php echo $p->nama_jurusan_pendidikan ?></option>
        <?php } ?>
			</select>

	  	</div>
	  </div>

	  <div class="form-group">
	    <label for="klsjab" class="col-sm-3 control-label">Kelas Jabatan</label>
	    <div class="col-sm-3">
          <select class="form-control"  name="klsjab" id="klsjab">
            <option value="">-- Kelas --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
          </select>        
	    </div>

	    <label for="SKP" class="col-sm-3 control-label">Nilai SKP</label>
	    <div class="col-sm-3">
	      <input type="number" class="form-control" min="0" max="76" name="skp" id="SKP" placeholder="">
	    </div>
	  </div>


	  <div class="form-group">
	    <label for="JP" class="col-sm-3 control-label">JML JP Diklat</label>
	    <div class="col-sm-3">
	      <input type="number" class="form-control" min="0" max="20" name="jp" id="JP" placeholder="">
	    </div>

	    <label for="Cuti" class="col-sm-3 control-label"> JML Cuti Sakit</label>
	    <div class="col-sm-3">
	      <input type="number" class="form-control" min="0" max="1" name="cutisakit" id="Cuti" placeholder="">
	    </div>
	  </div>

        <hr>
        <a href="#" class="btn btn-sm btn-success pull-left" style="display: none;" id="updatedata" onclick="updatedatamaster()">Update</a>
         <button class="btn btn-sm btn-danger pull-right" style="display: none;"  type="button" id="batal"><i class="glyphicon glyphicon-off"></i> Batal </button>
        <a href="#" class="btn btn-sm btn-primary pull-right" id="tambahdata" onclick="tambahdatamaster()">Tambah</a>

	</form>
	<div class="clearfix"></div>
	<hr>
</div>


<div class="col-sm-8">
<!-- <h3 class="page-header">&nbsp;</h3>	 -->
<div id="loading"><img src="<?php echo base_url('assets/loading5.gif') ?>"></div>
<div id="bg-loading"></div>
<div class="panel panel-info">
  <div class="panel-heading"><b>Table Master</b>
<button class="btn btn-xs btn-danger pull-right" onclick="location.reload()"><i class="glyphicon glyphicon-repeat"></i> Reload Table</button>
  </div>
  <div class="panel-body" style="height: 600px; overflow: scroll; overflow-x: hidden;">
      <div class="table-responsive">
        <table class="table table-condensed table-striped" id="myTable">
        
          <thead>
            <tr>
              <th width="35">No</th>
              <th width="180">Nama Jabatan</th>
              <th width="250">Eselon</th>
              <th><u>Golru</u></th>
              <th>Info Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th width="35">No</th>
              <th width="180">Nama Jabatan</th>
              <th width="250">Eselon</th>
              <th><u>Golru</u></th>
              <th>Info Jabatan</th>
              <th>Aksi</th>
            </tr>
          </tfoot>          
          <tbody id="getdataanjab"></tbody>
        </table>
      </div>
    </div>
</div>	
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css') ?>">
<script src="<?php echo base_url('assets/datatables/datatables.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/sweetalert/sweetalert.js') ?>"></script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

<script type="text/javascript">
  $(".select_pendidikan").select2({
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
<script type="text/javascript">
  $("#loading").hide();
  $("#bg-loading").hide();
  
  getdatamaster();
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

  function getdatamaster(){
    $.ajax({
      type : "POST",
      url  : '<?php echo base_url()."anjab/getdatamaster" ?>',
      dataType : 'json',
      success: function (data) {
        var no=1;
        var baris = '';
        for(var i=0;i<data.length;i++){
          if(data[i].fid_jabfu != ''){
            var jabfuTampil = data[i].nama_jabfu+"<br><u>"+data[i].n_jabatan+"</u>";
            var eselon = '<b>Eselon IV </b> <br>'+ data[i].eselon4+'<br> <b>Eselon III</b><br>  '+ data[i].eselon3 +'<br><b> Eselon II </b><br> '+ data[i].eselon2
          }else {
            var jabfuTampil = '';
            var eselon='<center><span class="label label-danger label-lg">KOSONG!</span> <br> <b>STATUS: <u>JFT</u></b></center>';
          }
          if(data[i].fid_jabft != ''){
            var jabftTampil = data[i].nama_jabft;
          }else{
            var jabftTampil = '';
          }
          if(data[i].fid_jabstruk != ''){
            var jabstTampil = data[i].nama_jabatan+"<br><u>"+data[i].n_jabatan+"</u>";
            var eselon = '<b>Eselon IV </b><br> '+ data[i].eselon4+'<br> <b>Eselon III</b> <br> '+ data[i].eselon3 +'<br><b> Eselon II </b><br> '+ data[i].eselon2
          }else{
            var jabstTampil = '';
          }

              var s_kp = data[i].skp;
              if(s_kp >= 90){
                var dinilai = "(MEMUASKAN)";
              }
              if(s_kp >= 76){
                var dinilai = "(BAIK)";
              }
              if(s_kp < 76){
                var dinilai = "(CUKUP)";
              }
              if(s_kp <= 56){
                var dinilai = "(KURANG)";
              }
              

          baris += '<tr>'+
                        '<td width="20" align="center">'+no+'</td>' +
                        '<td width="130"><b>'+jabstTampil+' '+jabfuTampil+' '+jabftTampil+'</b><br>'+data[i].nama_unit_kerja+'</td>' +
                        '<td width="90">'+eselon+'</td>' +
                        '<td><b>'+data[i].nama_jenis_jabatan+'</b><br>'+data[i].nama_pangkat+' ('+data[i].nama_golru+')</td>' +
                        '<td width="150"> (<b>'+data[i].nama_tingkat_pendidikan+'</b>) '+data[i].pendidikan+'<hr> <b>TOTAL JP</b> <span class="label label-primary pull-right">'+data[i].total_jp_diklat+' jam</span>  <br> <b>KELAS JABATAN</b> <span class="label label-success pull-right">'+data[i].kelas_jabatan+'</span><br> <b>CUTI SAKIT</b> <span class="label label-info pull-right">'+data[i].jml_cuti_sakit+' HARI</span> <br><b>NILAI SKP</b> <span class="label label-warning pull-right">'+data[i].skp+' '+dinilai+'</span></td>' +
                        '<td width="70" align="center"><a class="btn btn-xs btn-success" onclick="submit('+data[i].id_aj_syaratjab+')"><i class="glyphicon glyphicon-edit"></i></a> <a class="btn btn-xs btn-danger" onclick="hapus('+data[i].id_aj_syaratjab+')"><i class="glyphicon glyphicon-trash"></i></a></td>' 
                   +'</tr>';
        no++;}
        $('#getdataanjab').html(baris);
        var dataTable = $('#myTable').DataTable();    
            
        // var resultHendrel = $('#getdataanjab').html(baris);
        //       $('#myTable').DataTable({
        //         pageLength: 3
        //       }).html(resultHendrel);
      }
    });
  }

    //ESELON II
    $("#unkersel").on("change", function(){
      var idselunker = $(this).val();
      if(idselunker == ''){
        $("#esl2select").prop('disabled', true);
      }else{
        $("#esl2select").prop('disabled', false);
        $.ajax({
          url: '<?php echo base_url()."anjab/getesl2" ?>',
          type:'POST',  
          data: {'idselunker': idselunker},
          dataType: 'json',
          success: function(data){
            $("#esl2select").html(data);
          },
          error: function(){
            alert('error');
          }
        });
      }
    });

    //ESELON III
    $("#unkersel").on("change", function(){
      var idselunker = $(this).val();
      if(idselunker == ''){
        $("#esl3select").prop('disabled', true);
      }else{
        $("#esl3select").prop('disabled', false);
        $.ajax({
          url: '<?php echo base_url()."anjab/getesl3" ?>',
          type:'POST',  
          data: {'idselunker': idselunker},
          dataType: 'json',
          success: function(data){
            $("#esl3select").html(data);
          },
          error: function(){
            alert('error');
          }
        });
      }
    });

    //ESELON IV
    $("#unkersel").on("change", function(){
      var idselunker = $(this).val();
      if(idselunker == ''){
        $("#esl4select").prop('disabled', true);
      }else{
        $("#esl4select").prop('disabled', false);
        $.ajax({
          url: '<?php echo base_url()."anjab/getesl4" ?>',
          type:'POST',  
          data: {'idselunker': idselunker},
          dataType: 'json',
          success: function(data){

            $("#esl4select").html(data);
          },
          error: function(){
            alert('error');
          }
        });
      }
    });

    // SELECT JABATAN STRUKTURAL
    getJabS();
    function getJabS(){
    $("#unkersel").on("change", function(){
      var idselunker = $(this).val();
      if(idselunker == ''){
        $("#jabstruk").prop('disabled', true);
      }else{
        $("#jabstruk").prop('disabled', false);
        $.ajax({
          url: '<?php echo base_url()."anjab/getjabstruk" ?>',
          type:'POST',  
          data: {'idselunker': idselunker},
          dataType: 'json',
          success: function(data){
            $("#jabstruk").html(data);
          },
          error: function(){
            alert('error');
          }
        });
      }
    });
     }

    //SELECT JABATAN FUNGSIONAL
    getJabFu();
    function getJabFu(){
    $("#optionsRadios3").on("change", function(){
      $.ajax({
        url: '<?php echo base_url()."anjab/getjabfu" ?>',
        type: 'POST',
        dataType: 'json',
        success: function(data2){
          $('#jabfusel').html(data2);
          getdatamaster();
        },
        error: function(){
          alert('error');
        }
      });
    });
    }


    //SELECT JABATAN FUNGSIONAL TERTENTU
    getJabFt();
    function getJabFt(){
    $("#optionsRadios4").on("change", function(){
      $.ajax({
        url: '<?php echo base_url()."anjab/getjabft" ?>',
        type: 'POST',
        dataType: 'json',
        success: function(data2){
          $('#jabftsel').html(data2);
          getdatamaster();
        },
        error: function(){
          alert('error');
        }
      });
    });
    }


    //TAMBAH DATA MASTER
    function tambahdatamaster(){
      var unker = $("[name= 'unker']").val();
      var jnsjb = $("[name= 'jnsjb']").val();  

      var jabstruk = $("[name= 'fid_jabstruk']").val();
      var jabfu = $("[name= 'fid_jabfu']").val();
      var n_jab = $("[name= 'n_jabatan']").val();
      var jabft = $("[name= 'fid_jabft']").val();
      var esl2  = $("[name= 'esl2']").val();
      var esl3  = $("[name= 'esl3']").val();
      var esl4  = $("[name= 'esl4']").val();
      var golru  = $("[name= 'golru']").val();
      var pdd  = $("[name= 'pendidikan[]']").val();
      var klsjab  = $("[name= 'klsjab']").val();
      var skp  = $("[name= 'skp']").val();
      var jp  = $("[name= 'jp']").val();
      var csakit  = $("[name= 'cutisakit']").val();
      var tingpen  = $("[name= 'ting_pen']").val();


      $.ajax({
        type: 'POST',
        data:'unker='+unker+'&jnsjb='+jnsjb+'&jabstruk='+jabstruk+'&jabfu='+jabfu+'&n_jab='+n_jab+'&jabft='+jabft+'&esl2='+esl2+'&esl3='+esl3+'&esl4='+esl4+'&golru='+golru+'&pendidikan='+pdd+'&klsjab='+klsjab+'&skp='+skp+'&jp='+jp+'&csakit='+csakit+'&tingpen='+tingpen,
        url: '<?php echo base_url()."anjab/p_tambahdatamaster" ?>',
        dataType: 'json',
        success: function(hasil){
          $('#msg').html(hasil.pesan);
               getdatamaster();
               dataTable;  

        },
        beforeSend : function(){
          $("#loading").css('display','block').show().append("Mohon Tunggu...");
          $("#bg-loading").css('display','block').show();
          location.reload();
         $("[name= 'unker']").val('');
         // $("[name= 'jnsjb']").val('');
         $("[name= 'fid_jabstruk']").val('').prop('disabled',true);
         $("[name= 'fid_jabfu']").val('');
         $("[name= 'n_jabatan']").val('');
         $("[name= 'fid_jabft']").val('');
         $("[name= 'esl2']").val('').prop('disabled',true);
         $("[name= 'esl3']").val('').prop('disabled',true);
         $("[name= 'esl4']").val('').prop('disabled',true);
         $("[name= 'golru']").val('');
         $("[name= 'pendidikan[]']").val('');
         $("[name= 'klsjab']").val('');
         $("[name= 'skp']").val('');
         $("[name= 'jp']").val('');
         $("[name= 'cutisakit']").val('');
         $("[name= 'teng_pen']").val(''); 
         $("[name= 'ting_pen']").val('');            
        },
        complete : function(){
          $("#loading").fadeOut('slow');
          $("#bg-loading").fadeOut('slow');              
        }
      });
    }


  function submit(x){
    $.ajax({
      type: 'POST',
      data: 'id='+x,
      url : '<?php echo base_url()."anjab/editId" ?>',
      dataType: 'json',
      success: function(result){

              $("#updatedata").css("display","block");
              $("#batal").css("display","block");
              
              $("#tambahdata").css("display","none");
               $("[name= 'unker']").val(result[0].fid_unit_kerja);
               if(result[0].fid_jenis_jabatan == '1'){
                  getJabS();
                  $("#optionsRadios2").prop('checked', true);
                  $('#jbs').css("display","block");
                  $('#jfu').css("display","none");
                  $('#jft').css("display","none");

                  $('#eselon2').css("display","block");
                  $('#eselon3').css("display","block");
                  $('#eselon4').css("display","block");
                  $("[name= 'fid_jabstruk']").val(result[0].fid_jabstruk);
               }
               if(result[0].fid_jenis_jabatan == '2'){
                  getJabFu();
                  $("#optionsRadios3").prop('checked', true);
                  $('#jbs').css("display","none");
                  $('#jfu').css("display","block");
                  $('#jft').css("display","none");

                  // $('#eselon2').css("display","none");
                  // $('#eselon3').css("display","none");
                  // $('#eselon4').css("display","none");
                  $("[name= 'fid_jabfu']").val(result[0].fid_jabfu);

               }
               if(result[0].fid_jenis_jabatan == '3'){
                  getJabFt();
                  $("#optionsRadios4").prop('checked', true);
                  $('#jbs').css("display","none");
                  $('#jfu').css("display","none");
                  $('#jft').css("display","block");

                  $('#eselon2').css("display","none");
                  $('#eselon3').css("display","none");
                  $('#eselon4').css("display","none");
                  $("[name= 'fid_jabft']").val(result[0].fid_jabft);
               }  
               

               $("[name= 'golru']").val(result[0].fid_golru);
               $("[name= 'n_jabatan']").val(result[0].n_jabatan);

               $(".select_pendidikan").val(result[0].pendidikan);
               
               $("[name= 'klsjab']").val(result[0].kelas_jabatan);
               $("[name= 'skp']").val(result[0].skp);
               $("[name= 'jp']").val(result[0].total_jp_diklat);
               $("[name= 'cutisakit']").val(result[0].jml_cuti_sakit);
               $("[name= 'id_syarat']").val(result[0].id_aj_syaratjab);
      }

    });

  }
  
    $("#batal").on('click', function(){
      $("#tambahdata").css("display","block");
      
      $("#updatedata").css("display","none");
      $("#batal").css("display","none");

     $("[name= 'unker']").val('');
     $("[name= 'fid_jabstruk']").val('').prop('disabled',true);
     $("[name= 'fid_jabfu']").val('');
     $("[name= 'fid_jabft']").val('');
     $("[name= 'esl2']").val('').prop('disabled',true);
     $("[name= 'esl3']").val('').prop('disabled',true);
     $("[name= 'esl4']").val('').prop('disabled',true);
     $("[name= 'golru']").val('');
     $("[name= 'pendidikan[]']").val('');
     $("[name= 'klsjab']").val('');
     $("[name= 'n_jabatan']").val('');
     $("[name= 'skp']").val('');
     $("[name= 'jp']").val('');
     $("[name= 'cutisakit']").val('');
    });


    function updatedatamaster(){
      var unker = $("[name= 'unker']").val();
      var jabfu = $("[name= 'fid_jabfu']").val();
      var jabft = $("[name= 'fid_jabft']").val();
      var golru  = $("[name= 'golru']").val();
      var klsjab  = $("[name= 'klsjab']").val();
      var skp  = $("[name= 'skp']").val();
      var jp  = $("[name= 'jp']").val();
      var csakit  = $("[name= 'cutisakit']").val();
      var id  = $("[name= 'id_syarat']").val();
      var njab = $("[name= 'n_jabatan']").val();
      // var pdd = $("[name= 'pendidikan[]']").val();

      $.ajax({
        type: 'POST',
        url : '<?php echo base_url()."anjab/updatedata" ?>',
        dataType: 'json',
        data: 'id='+id+'&jabfu='+jabfu+'&jabft='+jabft+'&unker='+unker+'&golru='+golru+'&klsjab='+klsjab+'&skp='+skp+'&jp='+jp+'=&csakit='+csakit+'&nama_jabatan='+njab,
        success: function(hasil){
         $('#msg').html(hasil.msg);
         getdatamaster();
           var dataTable = $('#myTable').DataTable();  
           swal({
              title: "Success!",
              text: "Data Telah Diupdate",
              type: "success",
              timer: "2000",
              showConfirmButton: false
            });
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
    closeOnCancel: false,
    showLoaderOnConfirm: true
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
          type: 'POST',
          data: 'id='+ id,
          url : '<?php echo base_url()."anjab/hapusdata" ?>',
          success: function(){
              getdatamaster();
              unker();
                 $("[name= 'jnsjb']").prop('checked',false);
                 $("[name= 'fid_jabstruk']").val('').prop('disabled',true);
                 $("[name= 'fid_jabfu']").val('');
                 $("[name= 'fid_jabft']").val('');
                 $("[name= 'esl2']").val('').prop('disabled',true);
                 $("[name= 'esl3']").val('').prop('disabled',true);
                 $("[name= 'esl4']").val('').prop('disabled',true);
                 $("[name= 'golru']").val('');
                 $("[name= 'pendidikan[]']").val('');
                 $("[name= 'klsjab']").val('');
                 $("[name= 'n_jabatan']").val('');
                 $("[name= 'skp']").val('');
                 $("[name= 'jp']").val('');
                 $("[name= 'cutisakit']").val('');
                 $("#tambahdata").css("display","block");
                  
                 $("#updatedata").css("display","none");
                 $("#batal").css("display","none");
          },
          beforeSend : function(){
            $("#loading").show().css('display','block');
            $("#bg-loading").show().css('display','block');
            // location.reload('fast');
          },
          complete : function(){
            $("#loading").fadeOut('slow');
            $("#bg-loading").fadeOut('slow');
            swal("Deleted!", "1 baris data telah terhapus.", "success");
            dataTable; 
          }
      });      
    } else {
      swal("Cancelled", "Data Batal Dihapus", "error");
    }    
  });
}

// function hapus(id){
//   var tanya = confirm('Apakah anda takin akan menghapus data?');

//   if(tanya){
//     $.ajax({
//         type: 'POST',
//         data: 'id='+ id,
//         url : '<?php echo base_url()."anjab/hapusdata" ?>',
//         success: function(){
//             getdatamaster();
//             unker();
//            $("[name= 'jnsjb']").prop('checked',false);
//            $("[name= 'fid_jabstruk']").val('').prop('disabled',true);
//            $("[name= 'fid_jabfu']").val('');
//            $("[name= 'fid_jabft']").val('');
//            $("[name= 'esl2']").val('').prop('disabled',true);
//            $("[name= 'esl3']").val('').prop('disabled',true);
//            $("[name= 'esl4']").val('').prop('disabled',true);
//            $("[name= 'golru']").val('');
//            $("[name= 'pendidikan[]']").val('');
//            $("[name= 'klsjab']").val('');
//            $("[name= 'n_jabatan']").val('');
//            $("[name= 'skp']").val('');
//            $("[name= 'jp']").val('');
//            $("[name= 'cutisakit']").val('');
//             $("#tambahdata").css("display","block");
            
//             $("#updatedata").css("display","none");
//             $("#batal").css("display","none");
//         },
//         beforeSend : function(){
//           $("#loading").show();
//           $("#bg-loading").show();
//           // location.reload('fast');
//         },
//         complete : function(){
//           $("#loading").fadeOut('slow');
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
    opacity: 0.9;
    filter: blur(5px);
    z-index: 1;
    display: none;
  }
  #loading {
    z-index: 2;
    position: absolute;
    top: 10%;
    left: 50%;
    display: none;
  }
</style>