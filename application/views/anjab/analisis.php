<div class="col-sm-6">
<div id="bg-loading1" style="z-index: 1;"></div>
<div id="loading1" style="z-index: 2;"><center><img src="<?php echo base_url('assets/loading5.gif') ?>"></center> Mohon Tunggu Sebentar...</div>

<form class="form-horizontal" method="POST">
  <input type="hidden" name="id_aj_syaratjab_analisis">
  <input type="hidden" name="idunitkerja">
   <div class="form-group">
      <div class="col-sm-6 col-md-offset-5">
        <select class="form-control" name="p_jabatan" id="p_jabatan" onchange="j_jabatan()">
          <option value="">-- JABATAN --</option>
          <?php foreach ($p_jabatan as $pj) { ?>
            <option value="<?php echo $pj->id_aj_syaratjab ?>"><?php echo $pj->n_jabatan ?></option>
          <?php } ?>
        </select>
      </div>
   </div>  
</form>  

<div class="panel panel-danger">
  <div class="panel-heading">PROFIL JABATAN</div>
  <div class="panel-body profil-jabatan">
  <form action="#" method="POST">
    <input type="hidden" name="id_aj_syaratjab">
    <table id="tabel-jabatan">
      <tr>
        <td>UNIT KERJA</td>
        <td>:</td>
        <td><input type="text" name="j_unker" readonly size="70%"></td>
      </tr>
      <tr>
        <td>JABATAN</td>
        <td>:</td>
        <td>
            <input type="text" name="j_jab" readonly size="65%"><br>
            <input type="text" name="j_jabatan" readonly size="65%">
        </td>
      </tr>  

      <tr>
        <td>ESELON (II)</td>
        <td>:</td>
        <td><input type="text" name="j_esel2" id="j_e2" readonly size="65%"></td>
      </tr>
      <tr>
        <td>ESELON (III)</td>
        <td>:</td>
        <td><input type="text" name="j_esel3" id="j_e3" readonly size="65%"></td>
      </tr>                
      <tr>
        <td>ESELON (IV)</td>
        <td>:</td>
        <td><input type="text" name="j_esel4" id="j_e4" readonly size="65%"></td>
      </tr> 
          
      <tr>
        <td>KELAS JABATAN</td>
        <td>:</td>
        <td><input type="text" name="j_kls_jab" readonly size="1%"></td>
      </tr>
      <tr>
        <td>GOLRU</td>
        <td>:</td>
        <td>
            <input type="text" name="j_pangkat" readonly size="20%">
            ( <input type="text" name="j_golru" readonly size="2%"> )
        </td>
      </tr> 
      <tr>
        <td>PENDIDIKAN</td>
        <td>:</td>
        <td><input type="text" name="j_pendidikan" readonly size="60%"></td>
      </tr> 
      <tr>
        <td></td>
        <td></td>
        <td>
            NILAI SKP:  <input type="text" name="j_skp" readonly size="3%"> <span class="j_dinilai"></span> |
            JP DIKLAT:  <input type="text" name="j_jp" readonly size="3%"> JAM |
            CUTI SAKIT: <input type="text" name="j_csakit" readonly size="3%"> HARI
        </td>
      </tr>   
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>                    
    </table>
    </form>
  </div>
</div>	
</div>
<div class="col-sm-6">
<div id="status"></div>
<div id="bg-loading" style="z-index: 1;"></div>
<div id="loading" style="z-index: 2;"><center><img src="<?php echo base_url('assets/loading5.gif') ?>"></center> Mohon Tunggu Sebentar...</div>

<form class="form-horizontal" method="POST">
  <input type="hidden" name="skor_kelas_jabatan" value="0.2">
  <input type="hidden" name="skor_kelas_jabatan_kosong" value="0">

  <input type="hidden" name="skor_golru" value="0.2">
  <input type="hidden" name="skor_golru_kosong" value="0">

  <input type="hidden" name="skor_jurusan" value="0.3">
  <input type="hidden" name="skor_jurusan_kosong" value="0">

  <input type="hidden" name="skor_jp" value="0.1">
  <input type="hidden" name="skor_jp_kosong" value="0">

  <input type="hidden" name="skor_skp" value="0.1">
  <input type="hidden" name="skor_skp_kosong" value="0">

  <input type="hidden" name="skor_cs" value="0.1">
  <input type="hidden" name="skor_cs_kosong" value="0">

   <div class="form-group">
      <!-- <label for="unker" class="col-sm-1 control-label"></label>
       --><div class="col-sm-12">
        <select class="form-control" name="p_pns" onchange="caripns()" disabled id="prop">
          <option value="">-- PILIH PNS --</option>
              <option value="0">### PEMANGKU JABATAN TIDAK ADA/KOSONG ###</option>
          <?php foreach ($p_pns as $pp) { ?>

            <option value="<?php echo $pp->nip ?>" title="<?php echo $pp->unker ?>"><?php echo $pp->nip ?> | <?php echo $pp->nama_pns ?></option>
         
          <?php }  ?>
        </select>
      </div>
    </div>  
</form>

<div class="clearfix"></div>
<div class="panel panel-success">
  <div class="panel-heading">PROFIL PNS</div>
  <div class="panel-body profil-pns">
    <form action="#" method="POST">
    <input type="hidden" name="aj_syaratjab_sensus">
    <table id="tabel-pns">
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td><input type="text" name="nip" readonly size="25%"></td>
      </tr>
      <tr>
        <td>NAMA LENGKAP</td>
        <td>:</td>
        <td>
            <input type="text" name="nama" readonly size="40%"> <br>
            <input type="text" name="pangkat" readonly size="16%">( <input type="text" name="golru" readonly size="2%">) <input type="hidden" name="id_golru" readonly size="2%">
        </td>
      </tr>
      <tr>
        <td>ESELON (II)</td>
        <td>:</td>
        <td><input type="text" name="esel2" id="e2" readonly size="60%"></td>
      </tr> 
      <tr>
        <td>ESELON (III)</td>
        <td>:</td>
        <td><input type="text" name="esel3" id="e3" readonly size="60%"></td>
      </tr>            
      <tr>
        <td>ESELON (IV)</td>
        <td>:</td>
        <td><input type="text" name="esel4" id="e4" readonly size="60%"></td>
      </tr>              
      <tr>
        <td>UNIT KERJA</td>
        <td>:</td>
        <td><input type="text" name="unker" readonly size="70%"></td>
      </tr>  
      <tr>
        <td>JABATAN</td>
        <td>:</td>
        <td>
            <input type="text" name="jabatan" readonly size="40%"><br>
            <input type="text" name="jabatan_skr" readonly size="70%">
        </td>
      </tr> 
      <tr>
        <td >KELAS JABATAN</td>
        <td>:</td>
        <td><input type="text" name="kelas_jabatan" readonly size="1%"></td>
          
            
          
      </tr>  
      <tr>
        <td>PENDIDIKAN</td>
        <td>:</td>
        <td>
            <input type="text" name="tingpen" readonly size="1px">
            <input type="hidden" name="id_tingpen" readonly size="1px">

            <input type="text" name="jurusan" readonly size="30%">
            <input type="hidden" name="id_jurusan" readonly size="30%">            
        </td>
      </tr>  
      <tr>
        <td></td>
        <td></td>
        <td>
            NILAI SKP  <input type="text" name="skp" readonly size="5%"> <span class="dinilai"></span> |
            JP DIKLAT  <input type="text" name="jp" readonly size="5%"> JAM |
            CUTI SAKIT <input type="text" name="csakit" readonly size="7%"> HARI 
        </td>
      </tr>           
    </table>
    </form>
  </div>
</div>	
</div>
<div id="bg-loading3" style="z-index: 1;"></div>    
<div id="loading3" style="z-index: 2;"><center><img src="<?php echo base_url('assets/loading5.gif') ?>"></center></div>
<div class="clearfix"></div>
<div class="col-sm-12">
<center>
    <a class="btn btn-lg btn-success" href="#hasilanalisis" role="button" onClick="submit()" id="proses" style="display: none;">::: BANDINGKAN :::</a> 


</center>
  <div class="clearfix"></div><br>
  <div class="panel panel-default" id="hasil-analisi" style="display: none;">
  <div class="panel-heading">HASIL ANALISIS</div>
  <div class="panel-body hasil-analisi">
    <div class="col-md-3">

      <table width="100%">

        <tr>
          <td colspan="4" width="100%"><div style="display: inline-block; padding:5px; background-color:#073642; color:#fff; width: 100%;">PROFIL PNS</div></td>
        </tr>
        <tr>
          <td align="right">KELAS JABATAN</td>
          <td align="right"><input type="checkbox" name="s_klsjab" disabled></td>
        </tr>
        <tr>
          <td align="right">PANGKAT / GOLRU</td>
          <td align="right"><input type="checkbox" name="s_golru" disabled></td>
        </tr>        
        <tr>
          <td align="right">PENDIDIKAN</td>
          <td align="right"><input type="checkbox" name="s_pdd" disabled></td>
        </tr>        
        <tr>
          <td align="right">PELATIHAN</td>
          <td align="right"><input type="checkbox" name="s_jp" disabled></td>
        </tr>        
        <tr>
          <td align="right">INTEGRITAS & MORALITAS</td>
          <td align="right"><input type="checkbox" name="s_skp" disabled></td>
        </tr>        
        <tr>
          <td align="right">SEHAT JASMANI & ROHANI</td>
          <td align="right"><input type="checkbox" name="s_cs" disabled></td>
        </tr>        
      </table>      
    </div>
    <div class="col-md-3" style="border-right: 3px solid #ccc;">
      <table style="float: right;" width="100%">
        <tr>
          <td colspan="4" width="100%"><div style="display: inline-block; padding:5px;  color:#fff; background-color:#873642; width: 100%;">PROFIL JABATAN</div></td>
        </tr>        
        <tr>
          <td align="right"><input type="checkbox" name="r_klsjab" disabled></td>
          <td>KELAS JABATAN</td>
        </tr>
        <tr>
          <td align="right"><input type="checkbox" name="r_golru" disabled></td>
          <td>PANGKAT / GOLRU</td>
        </tr>
        <tr>
          <td align="right"><input type="checkbox" name="r_pdd" disabled></td>
          <td>PENDIDIKAN</td>
        </tr>
        <tr>
          <td align="right"><input type="checkbox" name="r_jp" disabled></td>
          <td>PELATIHAN</td>
        </tr>
        <tr>
          <td align="right"><input type="checkbox" name="r_skp" disabled></td>
          <td>INTEGRITAS & MORALITAS</td>
        </tr>
        <tr>
          <td align="right"><input type="checkbox" name="r_cs" disabled></td>
          <td>SEHAT JASMANI & ROHANI</td>
        </tr>                                        
      </table>      
    </div>
    <div class="col-md-6">

          <center id="tombol-hasil">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>

            <button class="btn btn-lg btn-danger" role="button" onClick="hasil()" id="hasil" style="display:none;">
              ::: HASIL ANALISIS DATA :::
            </button>
          
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
            
          </center>
          <table id="hasil_result" width="100%" border="0"></table>
          <center>
              <a class="btn btn-sm btn-danger pull-right" role="button" onClick="close_data()" id="complete" style="display: none;"><i class="glyphicon glyphicon-remove"></i> CLOSE</a>
            <a class="btn btn-sm btn-success pull-right" role="button" onClick="save_data()" id="save" style="display: none; margin-right: 10px;"><i class="glyphicon glyphicon-floppy-save"></i> SAVE</a>            
          </center>
    </div>
  </div>
</div>  

<div id="hasilanalisis"></div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/sweetalert/sweetalert.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>



<script>
function close_data(){
  var id = $("[name ='id_aj_syaratjab_analisis']").val();
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."anjab/hapus_analisis_null" ?>',
    data: 'id='+id,
    success: function(){
      hasil();
      location.reload();
    }
  });
 }

function save_data(){
  var id = $("[name ='id_aj_syaratjab_analisis']").val();  
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."anjab/update_analisis_null" ?>',
    data: 'id='+id,
    dataType: 'json',
    success: function(rest){
      hasil();
      swal({
        title: "Success!",
        text: "Data Telah Tersimpan Pada Database "+rest.res,
        type: "success",
        timer: "1800",
        showConfirmButton: false
      });
      setInterval(function(){
        location.reload();
      },1700);
      
    }
  });
 }

function hasil(){
  var id = $("[name ='id_aj_syaratjab_analisis']").val();
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."anjab/gethasil" ?>',
    data: 'id='+id,
    dataType: 'json',
    beforeSend: function(){
      $("#tombol-hasil").hide();
    },
    success: function(result){
    

    var a = result[0].klsjab;
    if(a == '0'){
       var kls = "<span class='notlike'>KELAS JABATAN ANDA TIDAK SESUAI DENGAN JABATAN ANDA</span>";
    }else{
      var kls = a;
    }

    var b = result[0].golru;
    if(b == '0'){
      var gol = "<span class='notlike'>GOLONGAN RUANG TIDAK SESUAI DENGAN JABATAN ANDA</span>";
    }else{
      var gol = b;
    }

    var c = result[0].jurusan;
    if(c == '0'){
      var jur = "<span class='notlike'>PENDIDIKAN TIDAK SESUAI DENGAN JABATAN SAAT INI</span>";
    }else{
      var jur = c;
    }


    var d  = result[0].jp;
    if(d == '0'){
      var jp = "<span class='notlike'>PELATIHAN MASIH KURANG, MINIMAL 20 JAM PELAJARAN</span>";
    }else{
      var jp = d;
    }

    var e = result[0].skp;
    if(e == '0'){
      var skp = "<span class='notlike'>NILAI SKP KURANG DARI 76</span>";
    }else{
      var skp = e;
    }

    var f  = result[0].csakit;
    if(f == '0'){
      var cs = "<span class='notlike'>PERLU PENGURANGAN IJIN SAKIT";
    }else{
      var cs = f;
    }

    var jml_mms_min = result[0].jml_mms;

    
      var ms =  '<tr>' +
                    '<td width="200"><span class="text-primary text-bold text-status">MEMENUHI SYARAT</span> (<b>MS</b>)</td>' +
                    '<td width="60%"><b>SCORE (1)</b></td>'+
                '</tr>';
      var mms = '<tr>' +
                  '<td width="200">'+
                    '<span class="text-success text-bold text-status">MASIH MEMENUHI SYARAT</span> (<b>MMS</b>) <br>'+
                    '<small>*Dengan catatan/keterangan poin yang tidak terpenuhi</small>'+
                  '</td>'+
                  '<td width="60%">: <b>SCORE ('+jml_mms_min+' )</b></td>'+
                '</tr>';
      var kms = '<tr>'+
                  '<td width="200">'+
                    '<span class="text-danger text-bold text-status">KURANG MEMENUHI SYARAT</span> (<b>KMS</b>)<br>'+
                    '<small>*Dengan catatan/keterangan PNS harus menyesuaikan dengan syarat jabatan</small>'+
                  '</td>'+
                  '<td width="60%">: <b>SCORE ('+jml_mms_min+' )</b> / MINIMAL <b>(0.7)</b></td>'+
                 '</tr>';


      if(a != '0' && b != '0' && c != '0' && d != '0' && e != '0' && f != '0'){
         var head = ms;
      }else if(a != '0' && b != '0' && c != '0' || jml_mms_min >= '0.7'){
         var head = mms;
      }else if(a == '0' && b == '0' && c == '0' || jml_mms_min <= '0.7'){
        var head = kms;
      }


      if(kls != '0'){
      var row =
                      '<tr>'+
                          '<td>PANGKAT / GOLRU</td>'+
                          '<td>'+gol+'</td>'+
                      '</tr>' + 
                      '<tr>'+
                          '<td>PENDIDIKAN</td>'+
                          '<td>'+jur+'</td>'+
                      '</tr>' +
                      '<tr>'+
                          '<td>PELATIHAN</td>'+
                          '<td>'+jp+'</td>'+
                      '</tr>' +
                      '<tr>'+
                        '<td>INTEGRITAS & MORALITAS</td>'+
                        '<td>'+skp+'</td>'+
                     '</tr>' +
                     '<tr>'+
                          '<td>SEHAT JASMANI & ROHANI</td>'+
                          '<td>'+cs+'</td>'+
                      '</tr>';                  
      }else{
      var row =  '<tr>'+
                        '<td>KELAS JABATAN</td>' +
                        '<td>KELAS JABATAN ANDA TIDAK SESUAI DENGAN JABATAN ANDA</td>'+
                      '</tr>';
      }

      if(gol != '0'){
      var row =  '<tr>'+
                        '<td>KELAS JABATAN</td>' +
                        '<td>'+kls+'</td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td>PENDIDIKAN</td>'+
                          '<td>'+jur+'</td>'+
                      '</tr>' +
                      '<tr>'+
                          '<td>PELATIHAN</td>'+
                          '<td>'+jp+'</td>'+
                      '</tr>' +
                      '<tr>'+
                        '<td>INTEGRITAS & MORALITAS</td>'+
                        '<td>'+skp+'</td>'+
                     '</tr>' +
                     '<tr>'+
                          '<td>SEHAT JASMANI & ROHANI</td>'+
                          '<td>'+cs+'</td>'+
                      '</tr>'; 
      }else{
      var row = '<tr>'+
                    '<td>PANGKAT / GOLRU</td>'+
                    '<td>GOLONGAN RUANG TIDAK SESUAI DENGAN JABATAN ANDA</td>'+
                '</tr>';        
      }
      if(jur != '0'){
      var row =  '<tr>'+
                        '<td>KELAS JABATAN</td>' +
                        '<td>'+kls+'</td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td>PANGKAT / GOLRU</td>'+
                          '<td>'+gol+'</td>'+
                      '</tr>' +
                      '<tr>'+
                          '<td>PELATIHAN</td>'+
                          '<td>'+jp+'</td>'+
                      '</tr>' +
                      '<tr>'+
                        '<td>INTEGRITAS & MORALITAS</td>'+
                        '<td>'+skp+'</td>'+
                     '</tr>' +
                     '<tr>'+
                          '<td>SEHAT JASMANI & ROHANI</td>'+
                          '<td>'+cs+'</td>'+
                      '</tr>'; 
      }else{
      var row = '<tr>'+
                    '<td>PENDIDIKAN</td>'+
                    '<td>PENDIDIKAN TIDAK SESUAI DENGAN JABATAN SAAT INI</td>'+
                '</tr>';

      }
      if(jp != '0'){
      var row =  '<tr>'+
                        '<td>KELAS JABATAN</td>' +
                        '<td>'+kls+'</td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td>PANGKAT / GOLRU</td>'+
                          '<td>'+gol+'</td>'+
                      '</tr>' + 
                      '<tr>'+
                          '<td>PENDIDIKAN</td>'+
                          '<td>'+jur+'</td>'+
                      '</tr>' +
                      '<tr>'+
                      '<tr>'+
                        '<td>INTEGRITAS & MORALITAS</td>'+
                        '<td>'+skp+'</td>'+
                     '</tr>' +
                     '<tr>'+
                          '<td>SEHAT JASMANI & ROHANI</td>'+
                          '<td>'+cs+'</td>'+
                      '</tr>'; 
      }else{
      var row = '<tr>'+
                    '<td>PELATIHAN</td>'+
                    '<td>PELATIHAN MASIH KURANG, MINIMAL 20 JAM PELAJARAN</td>'+
                '</tr>';
      
      }
      if(skp != '0'){
      var row =  '<tr>'+
                        '<td>KELAS JABATAN</td>' +
                        '<td>'+kls+'</td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td>PANGKAT / GOLRU</td>'+
                          '<td>'+gol+'</td>'+
                      '</tr>' + 
                      '<tr>'+
                          '<td>PENDIDIKAN</td>'+
                          '<td>'+jur+'</td>'+
                      '</tr>' +
                      '<tr>'+
                          '<td>PELATIHAN</td>'+
                          '<td>'+jp+'</td>'+
                      '</tr>' +
                      '<tr>'+
                     '<tr>'+
                          '<td>SEHAT JASMANI & ROHANI</td>'+
                          '<td>'+cs+'</td>'+
                      '</tr>'; 
      }else{
      var row =  '<tr>'+
                    '<td>INTEGRITAS & MORALITAS</td>'+
                    '<td>NILAI SKP KURANG DARI 76</td>'+
                 '</tr>';  
      }

      if(cs != '0'){
      var row =  '<tr>'+
                        '<td>KELAS JABATAN</td>' +
                        '<td>'+kls+'</td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td>PANGKAT / GOLRU</td>'+
                          '<td>'+gol+'</td>'+
                      '</tr>' + 
                      '<tr>'+
                          '<td>PENDIDIKAN</td>'+
                          '<td>'+jur+'</td>'+
                      '</tr>' +
                      '<tr>'+
                          '<td>PELATIHAN</td>'+
                          '<td>'+jp+'</td>'+
                      '</tr>' +
                      '<tr>'+
                        '<td>INTEGRITAS & MORALITAS</td>'+
                        '<td>'+skp+'</td>'+
                     '</tr>' +
                     '<tr>'+
                          '<td>SEHAT JASMANI & ROHANI</td>'+
                          '<td>'+cs+'</td>'+
                      '</tr>';                      
      }else{
       var row = '<tr>'+
                    '<td>SEHAT JASMANI & ROHANI</td>'+
                    '<td>PERLU PENGURANGAN IJIN SAKIT</td>'+
                '</tr>';       
      }


    $("#hasil_result").html(head+""+row);                 
    },
    complete: function(){
      $("#complete").css("display","block");
      $("#save").css("display","block");
      $("#proses").css("display","none");
    }

    });
}

$("#loading,#loading1,#loading3").hide();
$("#bg-loading,#bg-loading1,#bg-loading3").hide();

$("[name='p_pns'],[name='p_jabatan']").select2({
  width: '350px',  
  minimumResultsForSearch: 1
});

  function caripns(){
    var val = $("[name ='p_pns']").val();

    if(val != ""){

    
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url()."anjab/analisis_profil" ?>',
        data: 'katakunci='+val,
        cache: true,
        dataType: 'json',
        success: function (result) {

            $("[name ='aj_syaratjab_sensus']").val(result[0].aj_syaratjab_sensus);
            var gd = result[0].g_depan;
            var gb =  result[0].g_belakang;
            if(gd != '' || gb != ''){
              var g_depan = gd+" ";
              var g_belakang = ", "+gb;
            }else{
              var g_depan = '';
              var g_belakang = '';  
            }

            if(result[0].fid_jabstruk != ''){
              var jabatan = result[0].nama_jabatan;
            }
            if(result[0].fid_jabft != ''){
              var jabatan = result[0].nama_jabft;
            }
            if(result[0].fid_jabfu != ''){
              var jabatan = result[0].nama_jabfu;
            }
            

            $("[name ='nip'").val(result[0].nip_pns);
            $("[name ='nama']").val(g_depan+""+result[0].nama+""+g_belakang);
            $("[name ='unker'").val(result[0].unker);
            $("[name ='jabatan'").val(result[0].n_jabatan);
            $("[name ='jabatan_skr'").val(jabatan); 
            $("[name ='kelas_jabatan'").val(result[0].kelas_jabatan);     

            $("[name ='pangkat']").val(result[0].nama_pangkat);

            $("[name ='golru']").val(result[0].nama_golru); 
            $("[name ='id_golru']").val(result[0].id_golru); 

            $("[name ='tingpen']").val(result[0].tingpen);
            $("[name ='id_tingpen']").val(result[0].id_tingkat_pendidikan);
            $("[name ='jurusan']").val(result[0].jurusan); 
            $("[name ='id_jurusan']").val(result[0].id_jurusan_pendidikan); 

            $("[name ='esel4']").val(result[0].eselon4);
            $("[name ='esel3']").val(result[0].eselon3); 
            $("[name ='esel2']").val(result[0].eselon2); 

            var s_kp = result[0].nilai_skp;
            var row  = result[0].ada;
            if(s_kp != '' || row != '' || s_kp != 0){
              
              if(s_kp >= 90){
                var dinilai = "(MEMUASKAN)";
              }
              if(s_kp >= 76 && row != ''){
                var dinilai = "(BAIK)";
              }
              if(s_kp < 76 && row != 0){
                var dinilai = "(CUKUP)";
              }
              if(s_kp <= 56 && row != 0){
                var dinilai = "(KURANG)";
              }
              if(row == 0){
                var dinilai = "(BELUM USUL)";
              }
              if(s_kp == 0){
                var dinilai = "";
              }
              $(".dinilai").html(dinilai);

              var skp = s_kp;  
            }else{
              var skp = "KOSONG";
            }

            $("[name ='skp']").val(skp);

            var jp_jam = result[0].lama_jam;
            if(jp_jam != null){
              var jp = jp_jam;
            }
            else{
              var jp = "0"; 
            }
            $("[name ='jp']").val(jp); 

            var jml_s = result[0].jml;
            var stn_j = result[0].satuan_jml
            if(jml_s != null && stn_j != null){
               var jml = jml_s;
               var stn = stn_j;
            }else{
               var jml = '0';
               var stn = '';
            }

            $("[name ='csakit']").val(jml+" "+stn); 
        },
        complete: function (){
          // $("#tabel-pns").slideDown('slow');
          
          $("#loading").hide();
          $("#bg-loading").fadeOut('slow');
          if($("[name ='p_pns']").val() != '0'){
            $("#proses").css("display","block");
          }else{
            insert_pns();
            // swal("Success", "1 Jabatan Tanpa PEMANGKU Telah di Proses..", "success");
            swal({
              title: "Success!",
              text: "1 Jabatan Tanpa PEMANGKU Telah di Proses..",
              type: "success",
              showConfirmButton: false
            });
            setTimeout(function(){
              location.reload();
            }, 1500);
          }
        },
        beforeSend : function(){
          $("#loading").show();
          $("#bg-loading").show();
          // location.reload('fast');
        }
         
        
      }); 
    }else{
      $("[name ='nip'").val('');
      $("[name ='nama']").val('');
      $("[name ='unker'").val('');
      $("[name ='jabatan'").val('');
      $("[name ='jabatan_skr'").val(''); 
      $("[name ='kelas_jabatan'").val('');     

      $("[name ='pangkat']").val('');
      $("[name ='golru']").val(''); 
      $("[name ='tingpen']").val('');
      $("[name ='jurusan']").val(''); 

      $("[name ='skp']").val('');
      $("[name ='jp']").val(''); 
      $("[name ='csakit']").val(''); 
      $("#proses").css("display","none");

      $("[name ='esel4']").val('');
      $("[name ='esel3']").val(''); 
      $("[name ='esel2']").val('');       
      // $("#tabel-pns").slideUp('slow');
      $("[name ='r_klsjab']").prop("checked",false);
      $("[name ='s_klsjab']").prop("checked",false);
      
      $("[name ='r_golru']").prop("checked",false);
      $("[name ='s_golru']").prop("checked",false);

      $("[name ='r_skp']").prop("checked",false);
      $("[name ='s_skp']").prop("checked",false);

      $("[name ='r_jp']").prop("checked",false);
      $("[name ='s_jp']").prop("checked",false);
    }
  }
 
  function j_jabatan(){
    var val_j = $("[name ='p_jabatan']").val();
    if(val_j != ""){
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url()."anjab/analisis_jabatan" ?>',
        data: 'carijabatan='+val_j,
        dataType: 'json',
        success: function(i){
          $("[name ='idunitkerja']").val(i[0].id_unit_kerja);
          $("[name ='id_aj_syaratjab']").val(i[0].id_aj_syaratjab);
          $("[name ='j_unker']").val(i[0].nama_unit_kerja);

            if(i[0].fid_jabstruk != ''){
              var jabatan = i[0].nama_jabatan;
            }
            if(i[0].fid_jabft != ''){
              var jabatan = i[0].nama_jabft;
            }
            if(i[0].fid_jabfu != ''){
              var jabatan = i[0].nama_jabfu;
            }

          $("[name ='j_jab']").val(i[0].n_jabatan);
          $("[name ='j_jabatan']").val(i[0].nama_jabatan);
          $("[name ='j_kls_jab']").val(i[0].kelas_jabatan);

          
          $("[name ='j_golru']").val(i[0].nama_golru);
          $("[name ='j_pangkat']").val(i[0].nama_pangkat);

          var s_kp =i[0].skp;
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
          $(".j_dinilai").html(dinilai);
          $("[name ='j_skp']").val(i[0].skp);


          $("[name ='j_jp']").val(i[0].total_jp_diklat);
          $("[name ='j_csakit']").val(i[0].jml_cuti_sakit);
          // var pddkn = i[0].pendidikan;
          // var pdd = explode(','+pddkn);
          $("[name ='j_pendidikan']").val(i[0].pendidikan);

          $("[name ='j_esel4']").val(i[0].eselon4);
          $("[name ='j_esel3']").val(i[0].eselon3); 
          $("[name ='j_esel2']").val(i[0].eselon2);           


        },
        complete: function (){
          // $("#tabel-pns").slideDown('slow');

          $("#loading1").hide();
          $("#bg-loading1").fadeOut('slow');
          $("#prop").prop("disabled", false);
        },
        beforeSend : function(){
          $("#loading1").show();
          $("#bg-loading1").show();
          // location.reload('fast');
        }
      });
    }
    else {
      $("[name ='j_unker']").val('');
      $("[name ='j_jab']").val('');
      $("[name ='j_jabatan']").val('');
      $("[name ='j_kls_jab']").val('');

      
      $("[name ='j_golru']").val('');
      $("[name ='j_pangkat']").val('');

      $("[name ='j_skp']").val('');
      $("[name ='j_jp']").val('');
      $("[name ='j_csakit']").val('');

      $("[name ='j_pendidikan']").val('');  
      $("#prop").prop("disabled", true);   

      $("[name ='j_esel4']").val('');
      $("[name ='j_esel3']").val(''); 
      $("[name ='j_esel2']").val('');       

    }
  }


  
  function insert_pns(){

    var j_klsjajb = $("[name ='j_kls_jab']").val(); //profil jabatan
    var s_klsjab  = $("[name ='kelas_jabatan']").val(); //profil pns

    var j_golru = $("[name ='j_golru']").val(); //profil jabatan
    var s_golru  = $("[name ='golru']").val(); //profil pns

    var j_jp = $("[name ='j_jp']").val(); //profil jabatan
    var s_jp  = $("[name ='jp']").val(); //profil pns

    var j_skp = $("[name ='j_skp']").val();
    var s_skp = $("[name ='skp']").val();

    var j_pdd = $("[name ='j_pendidikan']").val(); 
    var s_pdd = $("[name ='jurusan']").val(); 

    var j_rs = $("[name ='j_csakit']").val(); 
    var s_rs = $("[name ='csakit']").val(); 


    var id_jab = $("[name ='id_aj_syaratjab']").val();
    var id  = $("[name ='aj_syaratjab_sensus']").val();
    var kls_jab  = $("[name ='kelas_jabatan']").val();
    var golru  = $("[name ='id_golru']").val();
    var tingpen  = $("[name ='id_tingpen']").val();
    var jurusan  = $("[name ='id_jurusan']").val();
    var jp  = $("[name ='jp']").val();
    var skp  = $("[name ='skp']").val();
    var csakit  = $("[name ='csakit']").val();
    var idunitkerja  = $("[name ='idunitkerja']").val();



      if(s_klsjab){
        if(j_klsjajb != s_klsjab){
            $("[name ='r_klsjab']").prop("checked",false);
            $("[name ='s_klsjab']").prop("checked",true);
            var skor_kelas_jabatan = $("[name ='skor_kelas_jabatan_kosong']").val();
        }else{
            $("[name ='r_klsjab']").prop("checked",true);
            $("[name ='s_klsjab']").prop("checked",true);
            var skor_kelas_jabatan = $("[name ='skor_kelas_jabatan']").val();
        }
      }else{
            $("[name ='r_klsjab']").prop("checked",false);
            $("[name ='s_klsjab']").prop("checked",false);
            var skor_kelas_jabatan = $("[name ='skor_kelas_jabatan_kosong']").val();
      }

      if(s_golru){
        if(j_golru != s_golru && s_golru < j_golru){
            $("[name ='r_golru']").prop("checked",false);
            $("[name ='s_golru']").prop("checked",true);
            var skor_golru = $("[name ='skor_golru_kosong']").val(); 
        }else{
            $("[name ='r_golru']").prop("checked",true);
            $("[name ='s_golru']").prop("checked",true);
            var skor_golru = $("[name ='skor_golru']").val(); 
        }
      }else{
            $("[name ='r_golru']").prop("checked",false);
            $("[name ='s_golru']").prop("checked",false);
            var skor_golru = $("[name ='skor_golru_kosong']").val(); 
      }


      var pddkan = $("[name ='jurusan']").val();
      var j_pddkan = $("[name ='j_pendidikan']").val();

      var find = j_pddkan.indexOf(pddkan);

      if(find != -1){
        $("[name ='r_pdd']").prop("checked",true); 
        $("[name ='s_pdd']").prop("checked",true); 
        var skor_jurusan = $("[name ='skor_jurusan']").val();
      }else{
        $("[name ='r_pdd']").prop("checked",true);
        $("[name ='s_pdd']").prop("checked",false); 
        var skor_jurusan = $("[name ='skor_jurusan_kosong']").val(); 
      }

      if(s_jp != 0){
            $("[name ='s_jp']").prop("checked",true);
            $("[name ='r_jp']").prop("checked",true);

            var skor_jp = $("[name ='skor_jp']").val(); 
      }else if(s_jp >= j_jp){
            $("[name ='r_jp']").prop("checked",true);
            $("[name ='s_jp']").prop("checked",true);
            var skor_jp = $("[name ='skor_jp']").val(); 
      }else if(s_jp <= j_jp){
            $("[name ='r_jp']").prop("checked",true); 
            $("[name ='s_jp']").prop("checked",false);
            var skor_jp = $("[name ='skor_jp_kosong']").val(); 
      }
      else{
            $("[name ='r_jp']").prop("checked",true);
            var skor_jp = $("[name ='skor_jp_kosong']").val(); 
      }
     

      if(s_skp < '76'){
            $("[name ='r_skp']").prop("checked",true);
            $("[name ='s_skp']").prop("checked",false);
            var skor_skp = $("[name ='skor_skp_kosong']").val(); 
      }else if(j_skp != '' && s_skp >= '76'){
            $("[name ='r_skp']").prop("checked",true);  
            $("[name ='s_skp']").prop("checked",true);
            var skor_skp = $("[name ='skor_skp']").val(); 
      }
      else if(s_skp == ''){
            $("[name ='s_skp']").prop("checked",false);
            var skor_skp = $("[name ='skor_skp_kosong']").val();   
      }else{
            $("[name ='r_skp']").prop("checked",true); 
            $("[name ='s_skp']").prop("checked",true);  
            var skor_skp = $("[name ='skor_skp']").val();   
      }

      if(s_rs != 0){
            $("[name ='s_cs']").prop("checked",false);
            $("[name ='r_cs']").prop("checked",true);
            var skor_cs = $("[name ='skor_cs_kosong']").val(); 
      }else if(s_rs >= 1){
            $("[name ='r_cs']").prop("checked",true);
            $("[name ='s_cs']").prop("checked",false);
            var skor_cs = $("[name ='skor_cs_kosong']").val(); 
      }else if(s_rs < 1){
            $("[name ='r_cs']").prop("checked",true); 
            $("[name ='s_cs']").prop("checked",true);
            var skor_cs = $("[name ='skor_cs']").val(); 
      }
      else{
            $("[name ='r_cs']").prop("checked",true);
            $("[name ='s_cs']").prop("checked",false);
            var skor_cs = $("[name ='skor_cs_kosong']").val(); 
      }
      
      if(id == 0){
        var sts = 1;
      }else{
        var sts = 0;
      }
      //var sts = 0;

    $.ajax({
      type: 'POST',
      url : '<?php echo base_url()."anjab/insert_profil_pns" ?>',
      data: 'id_aj_syaratjab='+id_jab+'&aj_syaratjab_sensus='+id+'&klsjab='+kls_jab+'&golru='+golru+'&tingpen='+tingpen+'&jurusan='+jurusan+'&jp='+jp+'&skp='+skp+'&csakit='+csakit+'&skor_kelas_jabatan='+skor_kelas_jabatan+'&skor_golru='+skor_golru+'&skor_jurusan='+skor_jurusan+'&skor_jp='+skor_jp+'&skor_skp='+skor_skp+'&skor_cs='+skor_cs+'&id_unker='+idunitkerja+'&sts='+sts,
      dataType: 'json'
    });  
  }

 function submit(){
    var val = $("[name ='aj_syaratjab_sensus']").val();
    var val2 = $("[name ='id_aj_syaratjab']").val();

  $.ajax({
    type: 'POST',
    url: '<?php echo base_url()."anjab/perbandingan" ?>',
    data: 'val='+val+'&syarat_jab='+val2,
    dataType: 'json',
    success: function(result){
      $("[name ='id_aj_syaratjab_analisis']").val(result[0].id_aj_syaratjab_analisis);

    },
    beforeSend: function(){
      insert_pns();
      // $("#bg-loading3").fadeIn('slow');
      // $("#loading3").show();
      $("#hasil-analisi").slideDown('slow');      

    },
    complete: function (){
      // $("#loading3").hide();
      // $("#bg-loading3").fadeOut('slow');
      $("#proses").prop("disabled", true);
      $("#hasil").css("display","block");
      $("[name='p_pns'").prop("disabled",true);
      $("[name='p_jabatan'").prop("disabled",true);
    }
  });
 }

 
</script>
<style type="text/css">
  #table-pns tr, td {
    padding: 8px;
  }
  #e4,
  #e3,
  #e2,
  #j_e4,
  #j_e3,
  #j_e2 {
    color:blue;
    font-weight: bold;
  }
  input[type="text"] {
    background: #fff;
    border-top:0;
    border-left:0;
    border-right:0;
    border-bottom: dashed;
    border-bottom-width: 0px;
    border-color: #ccc;
    color:#000;
    font-weight: normal;
    padding-left: 0;
  }
  input[name="kelas_jabatan"], 
  input[name="tingpen"], 
  input[name ='jp'], 
  input[name ='skp'],
  input[name ='j_kls_jab'],
  input[name ='j_golru'],
  input[name="golru"],
  input[name="j_skp"],
  input[name="j_jp"],
  input[name="j_csakit"],
  input[name="csakit"]{
    text-align: center;
    color:red;
  }
  input[name="jabatan"],
  input[name="j_jab"],
  .dinilai {
    color:red;
  }  
  input[name="golru"], 
  input[name="pangkat"], 
  input[name="jurusan"],
  input[name="j_jab"], 
  input[name="j_jabatan"],
  input[name="j_pendidikan"] {
    font-weight: bold;
    border:0;
  }
  input[name="golru"],
  input[name ='j_golru'] {
    color:green;
  }
  input[name="tingpen"] {
    color:green;
  }
  input[name="j_unker"],
  input[name="j_jab"] {
    text-decoration: underline;
  }

  #bg-loading,#bg-loading1 {
    background-color: #fff;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0.9;
    filter: blur(5px);
  }
  #loading,#loading1 {
    position: absolute;
    top:40%;
    left: 40%;
  }
  #bg-loading3{
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color:#fff;
    filter: blur(5px);
  }
  #loading3 {
    margin: 0 auto;
    margin-top:15%;
    left: 45%;
    position: absolute;
  }
  span.notlike {
    font-weight: bold;
    color:red;
  }
  span.text-status {
    font-weight:bold;
    font-size: 14px;
  }
</style>
