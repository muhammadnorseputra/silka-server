
<div class="container">
 <div class="row">
    <div class="col-md-4" style="padding: 10px 10px 10px 0;">
      <b>Pilih Unit Kerja: </b><select name="unker" id="unker"></select>
    </div>
    <div class="col-md-2" style="padding: 10px; display: none;" id="seljabdata">
      <b>Jenis Jabatan: </b> <br><select id="jenis_jabatan"> </select>
    </div>
  </div>
  
  <div class="row">
    <div class="panel panel-primary">

  <div class="panel-heading" style="position: relative;">
    <h6><b>LAPORAN DIKLAT</b></h6> 
   <!--  <div class="pull-right" id="selunkerdata">
      <b><small>Pilih Unit Kerja:</small> </b><br><select name="unker" id="unker"></select>
    </div>
      <span id="seljabdata"><b><small>Jenis Jabatan:</small> </b> <br><select id="jenis_jabatan"> </select></span> -->
  </div>
  <div class="panel-body">
    <span id="loader"></span>
    <div class="table-wrapper-scroll-y">  
    <table class="table table-condensed table-hover table-striped table-bordered display" id="myDataTable">
      <thead class="bg-info">
        <tr>
          <!-- <th width="25">NO <br><small>#</small></th> -->
          <th width="240">NAMA LENGKAP<br> <small>NIP</small></th>
          <th width="270">JABATAN <br><small> ESELON</small></th>
          <th width="130">TMT JABATAN <br> <small>Mulai Tanggal</small></th>
          <th><u class="text-danger">KEBUTUHAN</u> DIKLAT <br> <small>STRUKTURAL/TEKNIS</small></th>
          <th>DIKLAT <u class="text-danger">YANG PERNAH DIIKUTI</u> <br> <small>STRUKTURAL/TEKNIS</small></th>
        </tr>
      </thead>
      <tbody id="laporan_diklat_data">
 
      </tbody>

<!--       <tfoot class="bg-warning">
        <tr>
          <th width="240">NAMA LENGKAP<br> <small>NIP</small></th>
          <th width="250">JABATAN / ESELON</th>
          <th>TMT JABATAN</th>
          <th><u class="text-danger">KEBUTUHAN</u> (DIKLAT/BIMTEK/KURSUS) <br> <small>STRUKTURAL/TEKNIS</small></th>
          <th>DIKLAT/BIMTEK/KURSUS <u class="text-danger">YANG PERNAH DIIKUTI</u> <br> <small>STRUKTURAL/TEKNIS</small></th>
        </tr>
      </tfoot> -->
    </table>
    </div>
  </div>
   <div class="panel-footer">::: Table Laporan Diklat 
      <b class="text-danger">&bull;</b> <b><span id="jmlbaris"></span></b>
      <b class="text-danger">&bull;</b> Unker: <b><span id="unkeridsel"></span></b>
      <b class="text-danger">&bull;</b> Tanggal: <b><span id="tgl_c"></span></b>
      <!-- <b class="text-danger">&bull;</b> Jumlah PNS: <b><span id="jmlpns"></span></b> -->
      <p class="pull-right">
        <button class="btn btn-xs btn-primary" onClick="cetaklap()" id="cetak" disabled><i class="glyphicon glyphicon-print"></i> Cetak</button>
        <button class="btn btn-xs btn-success" onclick="location.reload()"><i class="glyphicon glyphicon-repeat"></i> Reload Table</button>
      </p>
   </div>
</div>
  </div>
</div>


<!-- CETAK LAPORAN MODAL SHOW -->
<div class="modal fade " id="myModalPrint" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-lg" style="width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">CETAK LAPORAN DIKLAT</h4>
      </div>
      <div class="modal-body"></div>     
    </div>
  </div>
</div>
<!-- END MODAL -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

<script>
$("#unker").select2({
   width: '370px' 
}); 
$("#jenis_jabatan").select2({
   width: '180px' 
});   

//tanggal cetak
var tgl = new Date();
var hari = tgl.getDate();
var bln = tgl.getMonth();
var thn = tgl.getFullYear();

$("span#tgl_c").html(hari+"/"+bln+"/"+thn);
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

    // VIEW DATA
    $("#unker,#jenis_jabatan").on("change", function(){
      var unkerid = $("#unker").val();
      var jabid = $("#jenis_jabatan").val();
        $.ajax({
          url: '<?php echo base_url()."diklat/get_laporandata" ?>',
          type: 'POST',  
          data: 'idunker='+unkerid+'&idjnsjab='+jabid,
          dataType: 'json',
          beforeSend: function(){
            $("span#loader").html('<img src="<?php echo base_url('assets/loading5.gif') ?>"><br>Mohon Tunggu...').css("display","block");
            $("#laporan_diklat_data").css("opacity","0.5");
          },
          success: function(oke){
            if(unkerid == 0){
             $("#laporan_diklat_data").html("<tr class='text-center'><td colspan='5'><b class='text-danger'>BARIS KOSONG!</b></td></tr>");
             $("#seljabdata").css("display","none"); 
            }else{
            var baris = '';
            var rwt = '';
            var no = 1;
            for(var x = 0;x<oke.length;x++){
              var q = oke[x];

              if(q.nama_jabatan != null && q.fid_jabatan != ''){
                var jabatan = q.nama_jabatan;
                var idjab = q.fid_jabatan;
              }else{
                var jabatan = '';
                var idjab = '';
              }

              if(q.nama_jabfu != null && q.fid_jabfu != ''){
                var jabatan_fu = q.nama_jabfu;
                var idjab_fu = q.fid_jabfu;
              }else{
                var jabatan_fu = '';
                var idjab_fu = '';
              }
              
              if(q.nama_jabft != null && q.fid_jabft != ''){
                var jabatan_ft = q.nama_jabft;
                var idjab_ft = q.fid_jabft;
              }else{
                var jabatan_ft = '';
                var idjab_ft = '';
              }

              var esl = q.nama_eselon;
              if(esl == 'II/A' || esl == 'II/B'){
                var rek_s = [{"nama_diklat":"PIM II"},{"nama_diklat":"PIM III"},{"nama_diklat":"PIM IV"}] 
              }else if(esl == 'III/A' || esl == 'III/B'){
                var rek_s = [{"nama_diklat":"PIM III"},{"nama_diklat":"PIM IV"},{"nama_diklat":"PRAJABATAN"}]
              }else if(esl == 'IV/A' || esl == 'IV/B'){
                var rek_s = [{"nama_diklat":"PIM IV"},{"nama_diklat":"PRAJABATAN"}]
              }else if(esl == 'JFU' || esl == 'JFT'){
                var rek_s = [{"nama_diklat":"JFU/JFT"}]
              }

              var rek = '';
              for(var i = 0; i<rek_s.length;i++){
                rek += '<li>'+rek_s[i].nama_diklat+'</li>';
              }

              baris += '<tr>'+
                      // '<td width="25" align="center">'+no+'</td>'+
                      '<td width="240"><b>'+q.nama_pegawai+'</b><br><b class="text-muted">NIP.</b> '+q.nip+'</td>'+
                      '<td width="270"><b>'+jabatan+' '+jabatan_fu+' '+jabatan_ft+'</b><br><b class="text-muted">&bull;</b> Eselon (<b class="text-danger">'+esl+'</b>)</td>'+
                      '<td align="center" width="130">'+q.tmt_jabatan+'</td>'+
                      //diklat rekomendasi
                      '<td>'+
                      '<div class="collapse" id="collapseExampleOke'+idjab+'">'+
                      '<p class="text-danger text-center bg-danger">Diklat Struktural</p>'
                      +rek+
                      '<p class="text-info text-center bg-info">Diklat Teknis Fungsional</p>'+
                        '<span id="bariske_rekomendasi'+idjab+'"></span>'+
                      '</div>'+
                      '<button class="btn btn-block btn-xs btn-success" data-toggle="collapse" data-target="#collapseExampleOke'+idjab+'" aria-expanded="false" aria-controls="collapseExampleOke'+idjab+'"><i class="glyphicon glyphicon-book"></i> Lihat Teknis Fungsional / Struktural'+
                      '</button>'+  
                      '</td>'+
                      //diklat riwayat
                      '<td width="246">'+
                      '<div class="collapse" id="collapseExample'+q.nip+'">'+
                        '<p class="text-danger text-center bg-danger">Diklat Struktural</p>'+ 
                          '<div id="bariske'+q.nip+'"></div>'+ 
                        '<p class="text-info text-center bg-info">Diklat Teknis Fungsional</p>'+  
                            '<div id="fungsional'+q.nip+'"></div> <div id="teknis'+q.nip+'"></div>'+
                        '</div>'+
                           '<button class="btn btn-block btn-xs btn-info" data-toggle="collapse" data-target="#collapseExample'+q.nip+'" aria-expanded="false" aria-controls="collapseExample'+q.nip+'"><i class="glyphicon glyphicon-book"></i> Lihat Teknis Fungsional / Struktural'+
                           '</button>'+
                      '</td>'+
                      '</tr>';
            no++;
            get_data_rekomendasi(idjab);
            get_data_riwayat(q.nip);
            get_data_riwayat_teknis(q.nip);
            get_data_riwayat_fungsional(q.nip);
            }

            $("#laporan_diklat_data").html(baris);
            $("#seljabdata").css("display","block"); 
          }

            var ukr = oke[0].unker;
            var selukr = $("#unker").val();
            if(selukr != 0){
              var unkr = ukr;
            }else{
              var unkr = "-";
            }
            $("span#unkeridsel").html(unkr);

            var btnCetak = $("#cetak");

            var jml = oke.length;
            var selukr2 = $("#unker").val();
            if(selukr2 != 0 || oke == ''){
              var sum = jml;
              btnCetak.prop("disabled",false);
            }else{
              var sum = "0";
              btnCetak.prop("disabled",true);
            }
            $("span#jmlbaris").html(sum+" Baris");


        },
          complete: function(){
            $("span#loader").css("display","none");
            $("#laporan_diklat_data").css("opacity","1");
            
           
          }
        });
    });       

    // VIEW DATA REKOMENDASI DIKLAT LIST
    function get_data_rekomendasi(jb){    
      $.ajax({
        type:'POST',
        data:'jab='+jb,
        url : '<?php echo base_url()."diklat/get_data_rekomendasi_l" ?>',
        dataType: 'json',
        success: function(hasilx){
           
                var barisx = '';
            for(var y = 0;y<hasilx.length;y++){
                var x = hasilx[y];
                if(x.nama_syarat_diklat != ""){
                  barisx += '<li>'+x.nama_syarat_diklat+'</li>';
                }else{
                  barisx += '-';
                }
                $("#bariske_rekomendasi"+x.fid_jabatan+"").html(barisx); 
          }

        }
      });
    } 

    // VIEW DATA REKOMENDASI DIKLAT LIST
    function get_data_riwayat(nip){
      $.ajax({
        type:'POST',
        data:'nippns='+nip,
        url : '<?php echo base_url()."diklat/get_data_riwayat_l" ?>',
        dataType: 'json',
        success: function(hasilya){
            var barisy = '';
            for(var y = 0;y<hasilya.length;y++){
              var z = hasilya[y];
              barisy += '<li>'+z.nama_diklat_struktural+'</li>';
            $("#bariske"+z.nip+"").html(barisy);   
            }

        }
      });
    } 

    function get_data_riwayat_teknis(nip){
      $.ajax({
        type:'POST',
        data:'nip='+nip,
        url : '<?php echo base_url()."diklat/get_data_riwayat_l_teknis" ?>',
        dataType: 'json',
        success: function(hasilya){
            var barisy = '';
            for(var y = 0;y<hasilya.length;y++){
              var z = hasilya[y];
              barisy += '<li>'+z.nama_diklat_teknis+'</li>';
            $("#teknis"+z.nip+"").html(barisy);   
            }

        }
      });
    }      

    function get_data_riwayat_fungsional(nip){
      $.ajax({
        type:'POST',
        data:'nip='+nip,
        url : '<?php echo base_url()."diklat/get_data_riwayat_l_fungsional" ?>',
        dataType: 'json',
        success: function(hasilya){
            var barisy = '';
            for(var y = 0;y<hasilya.length;y++){
              var z = hasilya[y];
              barisy += '<li>'+z.nama_diklat_fungsional+'</li>';
            $("#fungsional"+z.nip+"").html(barisy);   
            }

        }
      });
    } 
    function cetaklap(){
          var ukr = $("#unker").val();
          var jbt_s = $("#jenis_jabatan").val();

          $.ajax({
            url: '<?php echo base_url()."diklat/cetaklaporan" ?>',
            type: 'POST',
            data: 'unkerid='+ukr+'&jabid='+jbt_s,
            dataType: 'html',
            beforeSend: function(){
              $("span#loader").html('<img src="<?php echo base_url('assets/loading5.gif') ?>"><br>Mohon Tunggu...').css("display","block");
            },
            success: function(res_query){

            if(ukr != 0){
                var red = "cetaklaporan/"+ukr+"/"+jbt_s;

              var fra = "<iframe src="+red+" width='100%' height='500' frameborder='0'></iframe>";
                var dataHendler = $(".modal-body");
                dataHendler.html(fra);
              }
                $("#myModalPrint").modal('show');
                $("span#loader").css("display","none");
              },
              error: function(){
                alert('error');
              }
          }); 
    }       
</script>
<style>
table {
  margin:0;
}
table li {
  margin-left: 10px;
  padding-right: 3px;
}
table li:last-child {
  margin-bottom: 10px;
}
#loader {
  position: absolute;
  top:0;
  left: 0;
  width:100%;
  padding: 10px;
  background: #fff;
  text-align: center;
  display: none;
  border-bottom: 3px solid #0066ff;
}

.panel-body {
  margin:0;
  padding:0;
  position: relative;
}
.panel-body::-moz-scrollbar,
.panel-body::-webkit-scrollbar,
.panel-body::-o-scrollbar,
.panel-body::scrollbar{
    width: 0.8em;
}
 
.panel-body::-moz-scrollbar-track,
.panel-body::-webkit-scrollbar-track,
.panel-body::-o-scrollbar-track,
.panel-body::scrollbar-track {
    -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -o-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
.panel-body::-moz-scrollbar-thumb,
.panel-body::-webkit-scrollbar-thumb,
.panel-body::-o-scrollbar-thumb,
.panel-body::scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
  border-radius: 50px;
}  
#selunkerdata, span#seljabdata{
  position: absolute;
  right: 5px;
  top: 5px;
}
span#seljabdata {
  right: 33%;
  display: none;
}

/*.table-wrapper-scroll-y {
  display: block;
  max-height: 450px;
  overflow-y: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}*/

tbody {
    display:block;
    height:auto;
    max-height: 400px;
    overflow:auto;
    overflow-x:hidden;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
thead {
    width: calc( 100% - 0 );
    color: #666;
    font: sans-serif;
}

p.info {
  position: absolute;
  bottom: 0;
}
</style>