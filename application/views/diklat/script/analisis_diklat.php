<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

<link href="<?php echo base_url('assets/diklat/validetta/validetta.css') ?>" rel="stylesheet" type="text/css" media="screen" >
<script type="text/javascript" src="<?php echo base_url('assets/diklat/validetta/validetta.js') ?>"></script>

<script>
$("#unker").select2({
   width: '100%',
   theme: "classic"
}); 
$("#pilih_jabatan").select2({
   width: '100%', 
});   
$("#jenis_jabatan").select2({
   width: '100%',
  theme: "classic" 
});   

</script>

<script>
  	unker();    

  	// SELECT UNIT KERJA
    function unker(){
      $.ajax({
        type:'POST',
        url : '<?php echo base_url()."diklat/get_unker" ?>',
        dataType: 'json',
        success: function(hasil){
          $("#unker").html(hasil);   
        },
        complete: function(){
          get_jns_jabatan();  
        }
      });
    }	

    // SELECT JENIS JABATAN
    function get_jns_jabatan(){
      $.ajax({
        type:'POST',
        url : '<?php echo base_url()."diklat/get_jns_jabatan" ?>',
        dataType: 'json',
        success: function(hasilya){
          $("#jenis_jabatan").html(hasilya);   
        }
      });
    }  

    // SELECT JABATAN STRUKTURAL
    $("#unker").on("change", function(){
      var unker = $(this).val();
      if(unker == 0){
        $("#pilih_jabatan").prop('disabled', true);
        $("#jenis_jabatan").prop('disabled', true);
      }else{
        $("#pilih_jabatan").prop('disabled', false);
        $("#jenis_jabatan").prop('disabled', false);
        $.ajax({
          url: '<?php echo base_url()."diklat/get_jabstruk" ?>',
          type:'POST',  
          data: 'idunker='+unker,
          dataType: 'json',
          success: function(data){
            $("#pilih_jabatan").html(data);
          }
        });
      }
    });       


    //list pegawai 

    var sel_jabid = $("#jenis_jabatan").val();
    var sel_unker = $("#unker").val();
    var sel_jab = $("#pilih_jabatan").val();

    if(sel_jabid == 0 && sel_unker != 0){
      var sel = $("#unker");
      var evenqu = "change";   
    }else if(sel_jabid != 0 && sel_unker != 0){  
      var sel = $("#unker,#jenis_jabatan,#pilih_jabatan");
      var evenqu = "change";
    }else if(sel_jab != 0 || sel_unker != 0 || sel_jabid != 0){
      var sel = $("#pilih_jabatan");
      var evenqu = "change";
    }

    sel.on(evenqu, function(){
      get_analisa();
    });


      
    function get_analisa(){
        var unkerid = $("#unker").val();
        var jabid = $("#jenis_jabatan").val();
        var nippns = $("#nipcari").val();
        var jab   = $("#pilih_jabatan").val();

      $.ajax({
        type:'POST',
        data: 'idunker='+unkerid+'&idjab='+jabid+'&carinip='+nippns+'&jab='+jab,
        url : '<?php echo base_url()."diklat/get_pegawai" ?>',
        dataType: 'json',
        beforeSend: function(){
        	// $("span#loader").html('<img src="<?php echo base_url('assets/loading5.gif') ?>"><br> Mohon Tunggu...<br>').css("display","block");
          // $(".thumbnail").css("opacity","0.5");
          $("#list-pegawai").html('<center><h4>Mohon Tunggu, Prosessing...</h4></center>'); 

        },
        success: function(hasil){

          $(".thumbnail").css("opacity","1");
          if(hasil != '' || jabid != 0 && unkerid != 0){
          var baris = '';
          var col = 6;
          var cnt = 0;
          var row = 1;
          for (var i=0;i<hasil.length;i++) {
          	$("span#nama_unker").html(hasil[i].nama_unit_kerja).css("display","block");   
          	$("#unker").css("display","none");

          	var nama = hasil[i].nama_pegawai;

            //color
          	var esl  = hasil[i].nama_golru;
          	if(esl == 'IV/E' || esl == 'IV/D' || esl == 'IV/C' || esl == 'IV/B' || esl == 'IV/A'){
          		var color = "danger";
          	}else if(esl == 'III/D' || esl == 'III/C' || esl == 'III/B' || esl == 'III/A'){
          		var color = "success";
          	}else if(esl == 'II/D' || esl == 'II/C' || esl == 'II/B' || esl == 'II/A'){
          		var color = "info";
          	}else if(esl == 'I/D'){
          		var color = "warning";
          	}else{
          		var color = "default";
          	}

            //jabatan
            if(hasil[i].nama_jabatan != null){
              var jabatan = hasil[i].nama_jabatan;
            }
            else if(hasil[i].nama_jabfu != null){
              var jabatan = hasil[i].nama_jabfu;
            }
            else if(hasil[i].nama_jabft != null){
              var jabatan = hasil[i].nama_jabft;
            }else{
              var jabatan = '';
            }

            //baris
          	if(cnt >= col){
          		row = "<div class='row'></div>";
          		cnt = 0;
          	}
            cnt++;

            //pola nip -1
            var nipmy1 = hasil[i].nip;
            var idnip = nipmy1;
     		    
            //limit nama 
            var namaqu = nama.slice(0, 10);

          	baris += '<div class="col-md-4 col-sm-4">'+
          				'<div class="thumbnail" data-toggle="popover" data-content="'+jabatan+'">'+
          					'<img src="<?php echo base_url('photo') ?>/'+nipmy1+'.jpg" style="box-shadow: 0 0 5px #666;height: 110px;" alt="..."  data-toggle="tooltip" data-placement="top" title="'+jabatan+'">'+
          					'<div class="caption bg-'+color+'">'+
          						'<div id="caption"><b>'+nama+'</b><br> <b>NIP :</b>'+hasil[i].nip+'</div>'+
          						'<br><br><br><br><button class="btn btn-block btn-xs btn-'+color+'" data-toggle="modal" data-target=".detail-peg" max="18" min="0" onclick="more(\''+idnip+'\')"><i class="glyphicon glyphicon-user"></i> DETAIL</button>'+
          					'</div>'+
          				'</div>'+
          			 '</div>';


          }
          $("#list-pegawai").html(baris); 
          if(unkerid == '0'){
            $("span#loader").css("display","none");
          }else if(jabid == '0'){
            $("span#loader").css("display","none");
          }else{
            $("span#loader").css("display","none");
          }

          if(unkerid != '0'){
              $("#jenis_jabatan").prop("disabled",false);
          }else{
            $("#jenis_jabatan").prop("disabled",true);
              get_jns_jabatan();   
          }
        }else{
          $("#list-pegawai").html("<h4 class='text-muted text-center'><i  class='glyphicon glyphicon-user'></i> <b>PNS</b> Tidak Ditemukan!</h4>"); 
            $("span#loader").css("display","none");
          
        }
        }
      });	
    }

    $('.detail-peg').on('shown.bs.modal', function (e) {
      e.target = $('.nav-tabs a:first').tab('show');
    });

    function more(x){

    $.ajax({
      type: 'POST',
      data: 'nip='+x,
      url : '<?php echo base_url()."diklat/get_more_pegawai" ?>',
      dataType: 'json',
      beforeSend: function(){
        $("span#loader2").html('<img src="<?php echo base_url('assets/loading5.gif') ?>">').css("display","block");
        // data_rekomendasi_diklat();
      },
      success: function(result){

        var i = result[0];

          //color
          var esl  = i.nama_golru;
          if(esl == 'IV/E' || esl == 'IV/D' || esl == 'IV/C' || esl == 'IV/B' || esl == 'IV/A'){
            var color = "danger";
          }else if(esl == 'III/D' || esl == 'III/C' || esl == 'III/B' || esl == 'III/A'){
            var color = "success";
          }else if(esl == 'II/D' || esl == 'II/C' || esl == 'II/B' || esl == 'II/A'){
            var color = "info";
          }else if(esl == 'I/D'){
            var color = "warning";
          }else{
            var color = "default";
          }

          //jabatan
          if(i.nama_jabatan != null){
            var jabatan = i.nama_jabatan;
            var jabatan_id = i.fid_jabatan;
          }
          else if(i.nama_jabfu != null){
            var jabatan = i.nama_jabfu;
            var jabatan_id = i.fid_jabfu;
          }
          else if(i.nama_jabft != null){
            var jabatan = i.nama_jabft;
            var jabatan_id = i.fid_jabft;
          }else{
            var jabatan = '';
            var jabatan_id = '';
          }

          //form usul hanya untuk jft dan jfu
          if(i.nama_jabatan != null) {
            $("#usulTab, #okTab").hide();
            $("#okContent").show();
            $("#usulTabStruktural").show();
          } else {
            $("#usulTab, #okTab").show();
            $("#okContent").hide();
            $("#usulTabStruktural").hide();
          }

          if(i.jenis_kelamin == "L"){
            var jk = "Pria";
          }else{
            var jk = "Wanita";
          }

          if(i.nama_eselon != null){
            var eselon = i.nama_eselon
          }else{
            var eselon = '-';
          }

          //hitung umur
          var tgl_l = i.tgl_lahir;
          var umr   = tgl_l.slice(0,4);
          var umur  = 2018 - parseInt(tgl_l) ;

          //pola nip -1
          var mynip = i.nip;
          var nipsave = mynip.slice(0,16);

          //insert value pada form usul
          $("[name='bynip']").val(mynip);
          $("[name='fid_jabatan']").val(i.fid_jabatan);

        var baris = '<table class="table table-condensed">'+
                      '<tr>'+
                        '<td><i class="glyphicon glyphicon-bookmark" </td>'+
                        '<td class="bg-info"><b>Info Kepegawian</b></td>'+
                      '</tr>'+

                      '<tr>'+
                        '<td width="100" class="bg-info"><b>Nama</b> </td>'+
                        '<td><b class="text-danger">'+i.nama_pegawai+'</b><br><b>NIP: </b>'+mynip+'</td>'+
                        '<td width="5"><img src="<?php echo base_url('photo') ?>/'+mynip+'.jpg" alt="..." style="position:absolute; right:2px; top:0px; box-shadow: 0 8px 1em #eee;" data-toggle="tooltip" width="80" height="80" class="img-thumbnail" data-placement="top" title="'+jabatan+'"></td>'+

                        '<input type="hidden" id="analisa-diklat-nip" value="'+nipsave+'">'+
                      '</tr>'+

                      '<tr>'+
                        '<td width="100" class="bg-info"><b>Unit Kerja</b> </td>'+
                        '<td><b>'+i.nama_unit_kerja+'</b></td>'+
                      '</tr>'+

                      '<tr>'+
                        '<td width="100" class="bg-info"><b>Jabatan</b> </td>'+
                        '<td><b class="text-'+color+'">'+jabatan+'</b> &bull; <b>Eselon</b> ('+eselon+')</td>'+
                        '<input type="hidden" id="analisa-diklat-pop" value="'+jabatan_id+'">'+
                        '<input type="hidden" id="eselon-diklat-pop" value="'+i.nama_eselon+'">'+
                      '</tr>'+

                      '<tr>'+
                        '<td width="100" class="bg-info"><b>Pangkat</b> </td>'+
                        '<td>'+i.nama_pangkat+' <b class="text-'+color+'">('+i.nama_golru+')</b> <b class="text-danger">|</b> TMT : <b>'+i.tmt_golru_skr+'</b></td>'+
                      '</tr>'+

                      '<tr>'+
                        '<td width="100" class="bg-info"><b>Pendidikan Terakhir</b> </td>'+
                        '<td><b>'+i.nama_tingkat_pendidikan+' </b>'+i.nama_jurusan_pendidikan+'<br>'+
                          '<b>Tahun Lulus: '+i.tahun_lulus+'</b>'+
                        '</td>'+
                      '</tr>'+

                      //'<tr>'+
                      //  '<td><i class="glyphicon glyphicon-lock" </td>'+
                      //  '<td class="bg-info"><b>Info Pribadi</b></td>'+
                      //'</tr>'+
                      
                      //'<tr>'+
                      //  '<td width="100" class="bg-info"><b>TTL</b> </td>'+
                      //  '<td>'+i.tmp_lahir+' <b class="text-danger">/</b> '+tgl_l+' <b class="text-danger">|</b> <b>Umur:</b> '+umur+' Tahun </td>'+
                      //'</tr>'+

                      //'<tr>'+
                      //  '<td width="100" class="bg-info"><b>JK</b> </td>'+
                      //  '<td><span class="badge">'+jk+'</span> - <b>Status Perkawinan:</b> '+i.nama_status_kawin+'</td>'+
                        
                      //'</tr>'+

                      //'<tr>'+
                      //  '<td width="100" class="bg-info"><b>Alamat</b> </td>'+
                      //  '<td>'+i.alamat+' <br><b>Telp:</b> '+i.telepon+'</td>'+
                      //'</tr>'+
                      
                      //'<tr>'+
                      // '<td width="100" class="bg-info"><b>Agama</b> </td>'+
                      //  '<td><b>'+i.nama_agama+'</b></td>'+
                      //'</tr>'+

                      //'<tr>'+
                      //  '<td width="100" class="bg-info"><b>LHKPN</b> </td>'+
                      //  '<td><b>'+i.wajib_lhkpn+'</b></td>'+
                      //'</tr>'+


                      //'<tr class="bg-danger">'+
                      //  '<td width="30"><b>NOTE!</b> </td>'+
                      //  '<td><marquee direction="left"><b class="text-danger">'+i.note+'</b></marquee></td>'+
                      //'</tr>'+

                      // '<tr>'+
                      //   '<td width="30"></td>'+
                      //   '<td><button class="btn btn-primary btn-sm btn-block d-block">::: SELENGKAPNYA :::</button></td>'+
                      // '</tr>'+

                    '</table>';
      	$("#peg_load_here").html(baris);
        $("span#loader2").css("display","none");
      },
      complete: function(){
        data_riwayat_diklat();
        data_rekomendasi_diklat();
        getUsulan();
        getRekDikTek();
        rwyt_diklat_fungsional();
        rwyt_diklat_teknis();
        getUsulanJST();
      }

    });
    }

    function getUsulan() {
      var nipq = $("[name='bynip']").val();
      $.ajax({
        type:'POST',
        data:'nip='+nipq,
        url : '<?php echo base_url()."diklat/get_usulan_diklat_teknis" ?>',
        dataType: 'json',
        beforeSend: function(){
          $("tbody#getDataUsulan").html("<tr><td colspan='3' class='text-center'>Mohon Tunggu, Processing...</td></tr>");
        },
        success: function(hasil){
          $("tbody#getDataUsulan").html(hasil);
        }
      });
    }
    
    function getUsulanJST() {
      var nipq = $("[name='bynip']").val();
      $.ajax({
        type:'POST',
        data:'nip='+nipq,
        url : '<?php echo base_url()."diklat/get_usulan_diklat_teknis_fungsional_jst" ?>',
        dataType: 'html',
        beforeSend: function(){
          $("#usulan_diklat_struktural").html("Mohon Tunggu, Processing...");
        },
        success: function(hasil){
          $("#usulan_diklat_struktural").html(hasil);
        }
      });	
    }

    $(document).on('show.bs.modal', '.detail-peg', function () {
      var zIndex = 1040 + (10 * $('.detail-peg:visible').length);
      $(this).css('z-index', zIndex);
      setTimeout(function() {
          $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
      }, 0);
    });

    function edit_usulan(id, jenis, status) {
      var modal = $("#myModalEditUsul");
      if(jenis == 'detail') {
        modal.on('show.bs.modal', function() {
          $("input.edit, textarea.edit").prop("disabled", true);
          $("p.help-block .edit").css("display","none");
          $("button[type='submit'].edit").hide();
          $("#error_edit").show();
          $("h4#myModalLabel").html("DETAIL DIKLAT ON DATABASE");
        });
      } else if(jenis == 'edit') {
        modal.on('show.bs.modal', function() {
          $("p.help-block .edit").css("display","block");
          $("input.edit, textarea.edit").prop("disabled", false);
          $("#error_edit").hide();
          $("button[type='submit'].edit").show();
          $("h4#myModalLabel").html("EDIT USUL DIKLAT");
        });
      }

      if(status == 0) {
        $("#not_prv").show();
      } else {
        $("#not_prv").hide();
      }
      
      $.getJSON('<?= base_url("diklat/get_usul_by_id") ?>/'+ id, function(result) {
        modal.modal('show');
        $("[name='id_syarat_diklat_usulan_edit']").val(result[0].id_syarat_diklat);
        $("#usul_edit").val(result[0].nama_syarat_diklat);
        $("#tupoksi_edit").val(result[0].tupoksi);
        $("#penyelenggara_edit").val(result[0].penyelenggara);
        $("#jp_edit").val(result[0].jp);
        $("#biaya_edit").val(result[0].biaya);
        $("#capaian_edit").val(result[0].capaian);
        $("[name='error_edit']").val(result[0].ctt);
      });
    }


    function updateUsulDiklat() {
      var id = $("[name='id_syarat_diklat_usulan_edit']").val();
      var name = $("[name='usul_edit']").val();
      var tusi = $("[name='tupoksi_edit']").val();
      var penyelenggara = $("[name='penyelenggara_edit']").val();
      var jp = $("[name='jp_edit']").val();
      var biaya = $("[name='biaya_edit']").val();
      var hasil = $("[name='capaian_edit']").val();
      $.post('<?= base_url("diklat/get_update_usul_by_id") ?>/' + id, 
      {
        usul_edit: name, tupoksi: tusi, penyelenggara: penyelenggara, jp: jp, biaya: biaya, capaian: hasil 
      }, function(e){
        alert(e);
        getUsulan();
      });
    }

    function getRekDikTek() {
      var nipq = $("[name='bynip']").val();
      $.ajax({
        type:'POST',
        data:'nip='+nipq,
        url : '<?php echo base_url()."diklat/get_rekomendasi_diklat_teknis" ?>',
        dataType: 'json',
        beforeSend: function(){
          $("tbody#getRekomendasiDiklatTeknis").html("<tr><td colspan='4' class='text-center'>Mohon Tunggu, Processing...</td></tr>");
        },
        success: function(hasil){
          $("tbody#getRekomendasiDiklatTeknis").html(hasil);
        }
      });
    }    

    function hapus_usulan(id) {
      var r = confirm("Apakah anda yakin akan menghapus diklat tersebut?");
      if(r) {
        $.post('<?= base_url('diklat/hapus_usulan') ?>/'+ id, function(res) {
          alert(res);
          getUsulan();
        }, 'json');
      }
    }

    $("form[name='fmusul']").validetta({
        showErrorMessages : true,
        realTime : true,
        display : 'inline',
        errorTemplateClass : 'validetta-inline',
        onValid : function( event ) {
          event.preventDefault(); // Will prevent the submission of the form
          var fm = $(this.form);
          $.post(fm.attr("action"), fm.serialize(), function(result) {
              alert(result.content);
              fm[0].reset();
              getUsulan();
              $('.nav-tabs a:last').tab('show');
          }, 'json');
        },
        onError : function(event){
          alert( 'Silahkan isi semua bidang yang tersedia');
        }
      });

	$("form[name='fusuldiklatjst']").validetta({
	    showErrorMessages : true,
	    realTime : true,
	    display : 'bubble',
	    errorTemplateClass : 'validetta-bubble',
	    onValid : function( event ) {
	      event.preventDefault(); // Will prevent the submission of the form
	      var fm = $(this.form);
	      $.post(fm.attr("action"), fm.serialize(), function(result) {
	          alert(result.content);
	          fm[0].reset();
	          $("#usulDiklatJST").modal('hide');
	          getUsulanJST();
	          //getUsulan();
	          //$('.nav-tabs a:last').tab('show');
	      }, 'json');
	    },
	    onError : function(event){
	      alert( 'Silahkan isi semua bidang yang tersedia');
	    }
	  });

    function data_riwayat_diklat(){
        // var id = $("#analisa-diklat-pop").val();
        var nip = $("#analisa-diklat-nip").val();
        $.ajax({
        type:'POST',
        data:'nip='+nip,
        url : '<?php echo base_url()."diklat/get_datariwayatdiklat" ?>',
        dataType: 'json',
        success: function(queryok){
          if(queryok == ''){
            $("#riwayat_diklat_struktural").html("<br><center><span class='text-danger'><b>RIWAYAT DIKLAT <u>STRUKTURAL</u> KOSONG</b></span></center>");
          }else{
            var nama_rwyt_diklat = '';
            var no = 1;
            for(var r = 0;r<queryok.length;r++){
              var q = queryok[r];
              nama_rwyt_diklat += "<tr><td align='center'><b class='text-danger'>"+no+".</b></td><td> "+q.nama_diklat_struktural.toUpperCase()+
              " </td><td>"+q.tempat+"</td><td align='center'>"+q.tahun+"</td><td>"+q.no_sk+"</td><td>"+q.lama_jam+"</td><td>"+q.lama_hari+"</td><td>"+q.lama_bulan+"</td>"+ 
                "<input type='checkbox' style='display:none;' value='"+q.nama_diklat_struktural+"' name='nama_riwayat_diklat_analisa' checked></tr>";
              no++;
            }
            var rwyt_diklat = '<table class="table table-condensed table-striped table-bordered table-hover" style="margin-top:10px;">'+
                                '<tr>'+
                                  '<td width="10" valign="top" class="bg-danger">NO</td>'+
                                  '<td width="150"  valign="top" class="bg-danger">NAMA DIKLAT</td>'+
                                  '<td width="150" valign="top" class="bg-danger">TEMPAT</td>'+
                                  '<td width="20" valign="top" class="bg-danger">TAHUN</td>'+
                                  '<td width="150" valign="top" class="bg-danger">NO SK</td>'+
                                  '<td width="20" class="bg-danger">JAM</td>'+
                                  '<td width="20" class="bg-danger">HARI</td>'+
                                  '<td width="20" class="bg-danger">BULAN</td>'+
                                  nama_rwyt_diklat+
                                '</tr>'+
                             '</table>';


            $("#riwayat_diklat_struktural").html(rwyt_diklat);
          }
        }
      });
    }

    function rwyt_diklat_fungsional(){
      var nip_fu = $("#analisa-diklat-nip").val();
      $.ajax({
        url : '<?php echo base_url()."diklat/get_rwyt_diklat_fungsional" ?>',
        type: 'GET',
        data: 'nip_fu='+nip_fu,
        dataType: 'json',
        cahce: false,
        success: function(hasilque){
          if(hasilque == ''){
            // $("#riwayat_diklat_fungsional").html("<br><span class='text-muted'><b>RIWAYAT DIKLAT <u class='text-info'>FUNGSIONAL</u> KOSONG</b></span>");
          }else{
            var nama_rwyt_diklat = '';
            var no = 1;
            for(var r = 0;r<hasilque.length;r++){
              var q = hasilque[r];
              nama_rwyt_diklat += "<tr>"+
                                      "<td align='center'>"+
                                        "<b class='text-danger'>"+no+".</b>"+
                                      "</td>"+
                                      "<td> "+q.nama_diklat_fungsional.toUpperCase()+
                                          "<div class='collapse' id='collapseExample-"+no+"' style='border-top:1px solid #ccc;margin: 5px 0px 5px 0; padding-top:5px;'><b>NO.SK: <b class='text-danger'>"+q.no_sk+"</b> </b> | <b>TGL.SK:</b> "+q.tgl_sk+" <br> <b> TEMPAT: </b> "+q.tempat+"<br><b>Instansi Penyelenggara:</b> "+q.instansi_penyelenggara+" <br> <b>Lama:</b> Jam/"+q.lama_jam+" &bull; Hari/"+q.lama_hari+" &bull; Bulan/"+q.lama_bulan+"<br> <b>Tahun:</b> "+q.tahun+"</div>"+
                                      "</td>"+
                                      "<td>"+
                                      "<button class='btn btn-xs btn-primary' data-toggle='collapse' data-target='#collapseExample-"+no+"' aria-expanded='false' aria-controls='collapseExample'> <i class='glyphicon glyphicon-plus'></i></button>"+
                                      "</td>"+
                                  "</tr>"; 
              no++;
            }
            var rwyt_diklat_fu = '<table class="table table-condensed table-striped table-bordered table-hover" style="margin-top:10px;">'+
                                    '<tr>'+
                                      '<td width="10" valign="top" class="bg-warning">NO</td>'+
                                      '<td valign="top" class="bg-warning">NAMA DIKLAT <u> FUNGSIONAL</u></td>'+
                                      '<td width="25" valign="top"></td>'+
                                      nama_rwyt_diklat
                                    '</tr>'+
                                 '</table>';

            $("#riwayat_diklat_fungsional").html(rwyt_diklat_fu); 
          }
        }
      });
    } 

    function rwyt_diklat_teknis(){
      var nip_tk = $("#analisa-diklat-nip").val();
      $.ajax({
        type:'GET',
        data:'nip_tk='+nip_tk,
        url : '<?php echo base_url()."diklat/get_rwyt_diklat_teknis" ?>',
        dataType: 'json',
        cahce: false,
        success: function(hasilque1){
          if(hasilque1 == ''){
            // $("#riwayat_diklat_teknis").html("<br><span class='text-muted'><b>RIWAYAT DIKLAT <u class='text-info'>TEKNIS</u> KOSONG</b></span>");
          }else{
            var nama_rwyt_diklat = '';
            var no = 1;
            for(var r = 0;r<hasilque1.length;r++){
              var q = hasilque1[r];
              nama_rwyt_diklat += "<tr>"+
                                      "<td align='center'>"+
                                        "<b class='text-danger'>"+no+".</b>"+
                                      "</td>"+
                                      "<td> "+q.nama_diklat_teknis.toUpperCase()+
                                          "<div class='collapse' id='collapseExample"+no+"' style='border-top:1px solid #ccc;margin: 5px 0px 5px 0; padding-top:5px;'><b>NO.SK:</b> <b class='text-danger'>"+q.no_sk+"</b>  | <b>TGL.SK:</b> "+q.tgl_sk+" <br> <b> TEMPAT: </b> "+q.tempat+"<br><b>Instansi Penyelenggara:</b> "+q.instansi_penyelenggara+" <br> <b>Lama:</b> Jam/"+q.lama_jam+" &bull; Hari/"+q.lama_hari+" &bull; Bulan/"+q.lama_bulan+"<br> <b>Tahun:</b> "+q.tahun+"</div>"+
                                      "</td>"+
                                      "<td>"+
                                      "<button class='btn btn-xs btn-primary' data-toggle='collapse' data-target='#collapseExample"+no+"' aria-expanded='false' aria-controls='collapseExample'> <i class='glyphicon glyphicon-plus'></i></button>"+
                                      "</td>"+
                                  "</tr>";                   
              no++;
            }
            var rwyt_diklat_tk = '<table class="table table-condensed table-striped table-bordered table-hover" style="margin-top:10px;">'+
                                    '<tr>'+
                                      '<td width="10" valign="top" class="bg-info">NO</td>'+
                                      '<td valign="top" class="bg-info">NAMA DIKLAT <u> TEKNIS</u></td>'+
                                      '<td width="25" valign="top"></td>'+
                                      nama_rwyt_diklat
                                    '</tr>'+
                                 '</table>';

            $("#riwayat_diklat_teknis").html(rwyt_diklat_tk); 
          }
        }
      });
    } 

    function update_status(id) {
      
      if($(".cekStatus"+id).is(':checked')){
        var val = 3;
      }else if($('.cekStatus'+id).not(':checked')) {
        var val = 1;
      }

      $.post('<?= base_url("diklat/update_status"); ?>', {setdata: val, getid: id}, function(result){
          data_rekomendasi_diklat();
          getRekDikTek();
        });
    }

    function data_rekomendasi_diklat(){

        var id = $("#analisa-diklat-pop").val();

             
        $.ajax({
        type:'POST',
        data:'id='+id,
        url : '<?php echo base_url()."diklat/get_datasyaratdiklat" ?>',
        dataType: 'json',
        beforeSend: function(){
          data_riwayat_diklat();
        },
        success: function(res){
        
          if(res == ''){
            $("#rekomendasi_diklat").html("<span class='text-danger'><b>BELUM ADA DATA PERSYARATAN DIKLAT</b></span>");
            $("span#loader3").css("display","none");

          }else{

          var esl = $("#eselon-diklat-pop").val();

           if(esl == 'I/A' || esl == 'I/B' ){
             var nm_dik = [
                            {"nama_diklat" : "PIM I"},
                            {"nama_diklat" : "PRAJABATAN"}
                          ]
           }else if(esl == 'II/A' || esl == 'II/B' ){
             var nm_dik = [
                            {"nama_diklat" : "PIM I"},
                            {"nama_diklat" : "PIM II"},
                            {"nama_diklat" : "PRAJABATAN"}
                          ]
           }else if(esl == 'III/A' || esl == 'III/B' || esl == 'III/C' || esl == 'III/D'){
             var nm_dik = [
                            {"nama_diklat" : "PIM III"},
                            {"nama_diklat" : "PIM IV"},
                            {"nama_diklat" : "PRAJABATAN"}
                           ]
           }else if(esl == 'IV/A' || esl == 'IV/B' || esl == 'IV/C' || esl == 'IV/D'){
             var nm_dik = [
                           {"nama_diklat" : "PIM IV"},
                           {"nama_diklat" : "PRAJABATAN"}
                          ]
           }

          //STRUKTURAL
          var no = 1;
          var dataSd = '';
          var jdl_i = "STRUKTURAL";  
          var rek = '';
          for(var i = 0;i<nm_dik.length;i++){        
                var nama_diklat_analisis = $("[name='nama_riwayat_diklat_analisa']:checked").map(function() {
                                                                                  return $(this).val();
                                                                              }).get();                
                 

                 var cari = nama_diklat_analisis.filter( function(e){ return e == nm_dik[i].nama_diklat});
                 if(cari != ''){
                  var ceklis = '<span class="label label-success pull-right">Terpenuhi</span>';
                 }else{
                  var ceklis = '<span class="label label-danger pull-right">Belum Terpenuhi</span>';
                      rek += "<tr><td><b> <i class='glyphicon glyphicon-share-alt'></i></b></td><td> "+nm_dik[i].nama_diklat+"</td></tr>";
                 }         

                dataSd += "<b> <i class='glyphicon glyphicon-share-alt'></i></b> "+nm_dik[i].nama_diklat+" "+ceklis+"<br>";
            no++;
          }

            var nox = 1;
            var dataSdx = '';
            var jdl_x = "TEKNIS FUNGSIONAL";
            for(var x = 0;x<res.length;x++){
              var jdlx = res[x].jenis_syarat_diklat;
              if(jdlx == 'TEKNIS FUNGSIONAL'){
                if(res[x].sts_apprv == 3) {
                  var status_terpenuhi = '<span class="label label-success pull-right">Terpenuhi</span>';
                  var status_cek = 'checked';
                } else {
                  var status_terpenuhi = '<span class="label label-danger pull-right">Belum Terpenuhi</span>';
                  var status_cek = '';                
                }
                if(res[x].nama_syarat_diklat != ''){
                  dataSdx += `
                  <b>
                    <?php if($this->session->userdata('nama') == 'salasiah'){ ?> 
                    <input type='checkbox' class='cekStatus${res[x].id_syarat_diklat}' onchange='update_status(${res[x].id_syarat_diklat})' ${status_cek}> 
                    <?php } else { ?>
                      <i class='glyphicon glyphicon-share-alt'></i>
                    <?php } ?>
                  </b> 
                  ${res[x].nama_syarat_diklat.toUpperCase()} ${status_terpenuhi} <br>`;
                }else{
                  var dataSdx = "<b class='text-warning'>DATA PERSYARATAN BELUM ADA</b>";
                }
              }
              nox++;
            }
            
            var data = '<table class="table table-bordered table-condensed">'+
                          '<tr>'+
                            '<td width="15"><i class="glyphicon glyphicon-chevron-right"></i></td>'+
                            '<td><b class="text-danger"><u>'+jdl_i+'</u></b></td>'+
                          '</tr>'+

                          '<tr>'+
                            '<td width="15" valign="top"></td>'+
                            '<td><b class="text-success">'+dataSd+'</b></td>'+
                          '</tr>'+

                       '</table><hr>'+
                       '<table class="table table-bordered table-condensed">'+
                          '<tr>'+
                            '<td width="15"><i class="glyphicon glyphicon-chevron-right"></i></td>'+
                            '<td><b class="text-danger"><u>'+jdl_x+'</u></b></td>'+
                          '</tr>'+

                          '<tr>'+
                            '<td width="15" valign="top"></td>'+
                            '<td><b class="text-success">'+dataSdx+'</b></td>'+
                          '</tr>'+
                       '</table>';
            $("#rekomendasi_diklat").html(data);

            // if(dataSd == ''){
            //   var rekomendasi = '';
            // }else{
            // var rekomendasi = '<br><table class="table table-condensed table-striped table-bordered table-hover">'+
            //                         '<tr>'+
            //                           '<td width="10" valign="top" class="bg-danger"></td>'+
            //                           '<td valign="top" class="bg-info">DIKLAT <u> STRUKTURAL</u></td>'+
            //                           rek
            //                         '</tr>'+
            //                      '</table>';
            // }
            // $("#rekomendasi_diklat_analisa").html(rekomendasi);

            $("span#loader3").css("display","none");
          }
        }
      });
    }


</script>
<script>
  // $('[data-toggle="popover"]').popover({
  //   trigger: 'hover',
  //   placement: 'top',
  //   delay: { "show": 500, "hide": 100 },
  //   container: 'body'
  // });
</script>
<style>
  .thumbnail { transition: all .5s ease; background: url("<?php echo base_url('assets/bg-batik.jpg') ?>");background-repeat: no-repeat;
    background-position: left top;background-size: 100% 150px; background-color: #fff; }
  .thumbnail:hover {
    transition: all .5s ease;
    box-shadow: 0 0 1em #999;
    -webkit-box-shadow: 0 0 1em #999;
    -moz-box-shadow: 0 0 1em #999;
    -o-box-shadow: 0 0 1em #999;
    border: 1px solid orange;
/*    position: relative;
    transform: scale(1.05);
    z-index: 9999;*/
  }
  .thumbnail #caption {
    position: absolute;
    font-size: 11px;
    padding: 10px 10px 10px 15px;
    color: #333;
    background-color: #eee;
    left: 15px;
    width: auto;
    max-width: 150%;
    border-bottom: 2px solid #666;
    /*border-left: 2px solid #666;*/
  }
/*  .thumbnail:hover #caption:before {
    border:0;
  }*/
  /* .thumbnail #caption:before {
    content: "";
    position: absolute;
    left: 0;
    bottom: -20px;
    width: 0; 
    height: 0; 
    border-top: 18px solid #666; 
    border-left: 18px solid transparent;
    z-index: -1;    
  } */
  textarea#catatan {
     transition: all .5s ease;
  }
  textarea#catatan:focus {
    -webkit-box-shadow: 0 0 1em #aaa;
    -moz-box-shadow: 0 0 1em #aaa;
    -o-box-shadow: 0 0 1em #aaa;
     transition: all .5s ease;
  }

.panel-body::-webkit-scrollbar,
.tab-content #fu::-webkit-scrollbar,
.panel-body::-moz-scrollbar,
.tab-content #fu::-moz-scrollbar{
    width: 0.8em;
}
 
.panel-body::-webkit-scrollbar-track,
.tab-content #fu::-webkit-scrollbar-track,
.panel-body::-moz-scrollbar-track,
.tab-content #fu::-moz-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
.panel-body::-webkit-scrollbar-thumb,
.tab-content #fu::-webkit-scrollbar-thumb,
.panel-body::-moz-scrollbar-thumb,
.tab-content #fu::-moz-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
  border-radius: 50px;
}
#loader {
  position: absolute;
  left: 0;
  top: 0;
  background: #fff;
  width: 100%;
}
</style>