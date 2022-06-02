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
  
  
  function showData(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilrekap";
    url=url+"?thn="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataRekap;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataRekap(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkan").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkan").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  function showDataPerorangan(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilperorangan";
    url=url+"?data="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataPerorangan;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataPerorangan(){
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
  <div class="panel panel-success" style="padding:3px;width:98%;height:600px;">
    <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
      <b>REKAPUTILASI PENSIUN</b>
    </div>
    <br/>
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
  
  <div class="row">
    <div class="col-lg-1" align='center'></div>
    <div class="col-lg-6" align='center'>
      <form class="navbar-form navbar-center" name='formcari' role="search">
        <div class="form-group">      
          <input type="text" name="data" id="data" class="form-control" placeholder="Ketik NIP atau Nama" size='25' maxlength='18'>
          <button type="button" class="btn btn-success" onClick="showDataPerorangan(formcari.data.value)">
            <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Cari Pensiun</button>
        </div>
      </form>  
    </div>
    <div class="col-lg-3" align='center'>
      <form method='POST' name='formrekap'>       
        <div class="form-group input-group">    
          <span class="input-group-addon"><small>Pilih Tahun TMT Pensiun </small></span>
          <select class="form-control" name="thn" id="thn" required onChange="showData(this.value)">
          <?php
          echo "<option value='' selected>- Pilih Tahun -</option>";
          foreach($tahun as $thn)
          {
            echo "<option value='".$thn['tahun']."'>".$thn['tahun']."</option>";
          }
          ?>
          </select>
        </div>
      </form>
    </div> 
    <div class="col-lg-2" align='center'></div>        
  </div>

  <!-- untuk ajax -->
  <div id='tampilkan'></div>
  </div>
</center>
