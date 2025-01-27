<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>


<script type="text/javascript">
  
  function listJabatan(id, unkerId) {
    $.getJSON(`listJabatan`, {id: id, unker: unkerId}, function(res) {
      $("#listJabatan").html(res);
    })
  }
  
  function updatePosisi(id) {
    $modal = $("#modelEditPosisiJabatan");
    $modal.find("input[name='idpetajab']").val(id);
    $modal.modal('show');
  }

  function updateKomponen(id) {
    $modal = $("#modelEditKomponen");
    $modal.find("input[name='idpetajab']").val(id);
    $.getJSON(`<?= base_url('petajab/detailkomponen') ?>/${id}`, function(res) {
      
      $modal.find("input[name='kelas']").val(res.data.kelas);
      $modal.find("input[name='keterangan']").val(res.data.koord_subkoord);

      $modal.find("input[name='tpp_pk']").val(tandaPemisahTitik(res.data.pk));
      $modal.find("input[name='tpp_bk']").val(tandaPemisahTitik(res.data.bk));
      $modal.find("input[name='tpp_kk']").val(tandaPemisahTitik(res.data.kk));
      $modal.find("input[name='tpp_tb']").val(tandaPemisahTitik(res.data.tb));
      $modal.find("input[name='tpp_kp']").val(tandaPemisahTitik(res.data.kp));

      $modal.modal('show');
    })
  }

  $(document).on("submit", "form#formsetposisi", function(e) {
    e.preventDefault();
    let _ = $(this),
        action = _.attr('action'),
        data   = _.serialize(); 
    $.post(action, data, function(res) {
      if(res.data.id_peta === 0) {
         alert('Rumah jabatan tidak ditemukan pada PETA_JABATAN');
         return false;
      }
      window.location.reload();
    }, 'json');
    console.log(data);
  })

  function inputAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
      return true;
  }

  // Fungsi menambahkan titik pada input angka (lanjutan dari fungsi numberonly)
  function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");
	b=b.replace("-","");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)){
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	if (_minus) c = "-" + c ;
	return c;
  }

  // Fungsi input data hanya angka
  function numbersonly(ini, e){
	if (e.keyCode>=49){
		if(e.keyCode<=57){
			a = ini.value.toString().replace(".","");
			b = a.replace(/[^\d]/g,"");
			b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
			ini.value = tandaPemisahTitik(b);
			return false;
		}
		else if(e.keyCode<=105){
			if(e.keyCode>=96){
				//e.keycode = e.keycode - 47;
				a = ini.value.toString().replace(".","");	
				b = a.replace(/[^\d]/g,"");
				b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
				ini.value = tandaPemisahTitik(b);
				//alert(e.keycode);
				return false;
			}
			else {return false;}
		}
		else {
			return false;
		}
	}else if (e.keyCode==48){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==95){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==8 || e.keycode==46){
		a = ini.value.replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = b.substr(0,b.length -1);
		if (tandaPemisahTitik(b)!=""){
			ini.value = tandaPemisahTitik(b);
		} else {
			ini.value = "";
		}
		return false;
	} else if (e.keyCode==9){
		return true;
	} else if (e.keyCode==17){
		return true;
	} else {
		alert (e.keyCode);
	return false;
	}
  }

  //validasi textbox khusus angka
  function validAngka(a)
  {
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }

  function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
      {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
      }
    if (window.ActiveXObject)
      { 
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }
  
  
  function showData(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="caripeta";
    url=url+"?idunker="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkan").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkan").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  function showDataTambahJab(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampiljab";
    url=url+"?idjnsjab="+str1;
    url=url+"&idunker="+str2;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataJab;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataJab(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampiljab").innerHTML=xmlhttp.responseText;
      document.getElementById("tampildtljab").innerHTML="";
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljab").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  function showDataDetailTambahJab(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampildetailjab";
    url=url+"?idjnsjab="+str1;
    url=url+"&idunker="+str2;
    url=url+"&idjab="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataDetailJab;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataDetailJab(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampildtljab").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampildtljab").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 


  function showDataSetjf(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampiljabSetjf";
    url=url+"?idjnsjab="+str1;
    url=url+"&idunker="+str2;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataSetjf;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataSetjf(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampiljabSetjf").innerHTML=xmlhttp.responseText;
      document.getElementById("tampildtlSetjf").innerHTML="";
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljabSetjf").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  function showDataDetailSetjf(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampildetailSetjf";
    url=url+"?idjnsjab="+str1;
    url=url+"&idunker="+str2;
    url=url+"&idjab="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataDetailSetjf;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataDetailSetjf(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampildtlSetjf").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampildtlSetjf").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }
</script>

<!-- Default panel contents -->
<center>
  <div class="panel panel-success" style="padding:1px;overflow:auto;width:100%;height:640px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>PETA JABATAN</b>
        </div>
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 

  <?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>
  
  <center>
    <div class="row" align='center'>
          <form method='' name='formupdatestatus' style='padding-top:8px'>   
            <div class="col-md-6">    
              <div class="form-group input-group">    
                <span class="input-group-addon">Unit Kerja</span>
                <select class="form-control" name="id_unker" id="id_unker" required onChange="showData(formupdatestatus.id_unker.value)">
                <?php
                echo "<option value='' selected>-- Unit Kerja --</option>";
                foreach($unker as $uk)
                {
                  echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
                }
                ?>
                </select>     
              </div>
            </div>
            <div class="col-md-2">
              <button type="button" class="form-control btn btn-success btn-sm" onClick="showData(formupdatestatus.id_unker.value)" >
                <span class="fa fa-refresh" aria-hidden="true"></span> Refresh Data
              </button>
            </div>            
          </form>
          <div class="col-md-1"></div>
      </div>
  </center>
  
  <div id='tampilkan'></div>
  </div>
</center>

<!-- Modal Tambah PNS -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="tampiltambahpns" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Tambah PNS</h4>
                    </div>
                    <form class="form-horizontal" action="<?php echo base_url('petajab/tambahpns')?>" method="post" enctype="multipart/form-data" role="form">
                     <div class="modal-body">
                             <div class="form-group">
                                 <label class="col-lg-2 col-sm-2 control-label">Nama</label>
                                 <div class="col-lg-10">
                                  <input type="text" id="id" name="id">
                                     <input type="text" class="form-control" id="nama" name="nama" placeholder="Tuliskan Nama">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-lg-2 col-sm-2 control-label">Alamat</label>
                                 <div class="col-lg-10">
                                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Tuliskan Alamat"></textarea>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-lg-2 col-sm-2 control-label">Pekerjaan</label>
                                 <div class="col-lg-10">
                                     <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Tuliskan Pekerjaan">
                                 </div>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button class="btn btn-info" type="submit"> Simpan&nbsp;</button>
                             <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
                         </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- END Modal Tambah PNS -->

