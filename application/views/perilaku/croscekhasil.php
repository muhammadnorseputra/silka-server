<script type="text/javascript">
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
  
  
  function showData(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilkroscekhasil";
    url=url+"?uk="+str1;
    url=url+"&thn="+str2;
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
</script>

<!-- Default panel contents -->
  <center>
  <div class="panel panel-primary" style="padding:3px;width:98%;height:auto;">
    <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
      <b>KROSCEK HASIL PENILAIAN PERILAKU</b>
    </div>
    <br/>
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-2" align='center'></div>
        <div class="col-lg-7" align='center'>
          <form method='' name='formkroscek' style='padding-top:8px'>       
            <div class="form-group input-group">    
              <span class="input-group-addon"><small>Unit Kerja</small></span>
              <select class="form-control" name="unker" id="unker" required>
              <?php
              echo "<option value='' selected>-- Unit Kerja --</option>";
              foreach($unker as $data)
              {
                echo "<option value='".$data['id_unit_kerja']."'>".$data['nama_unit_kerja']."</option>";
              }
              ?>
              </select>

              <span class="input-group-addon"><small>Tahun Penilaian</small></span>
              <select class="form-control" name="tahun" id="tahun" required>
              <?php
              echo "<option value='0'>-- Tahun --</option>";
              echo "<option value='2020' selected>2020</option>";
              ?>
              </select>

              <span class="input-group-addon"></span>
              <button type="button" class="form-control btn btn-success btn-sm" onClick="showData(formkroscek.unker.value, formkroscek.tahun.value)">
                <span class="fa fa-cloud-download" aria-hidden="true"></span> Cek Hasil ePerilaku
              </button>

            </div>
          </form>
        </div> 
        <div class="col-lg-3" align='center'></div>        
      </div>

      <!-- untuk ajax -->
      <div id='tampilkan'></div>
    </div>
  </div>
</center>
