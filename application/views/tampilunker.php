<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

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
    var url="tampilpegunker";
    url=url+"?idunker="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampil").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampil").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
</script>

<center>
<form class="navbar-form navbar-center">
  <div class="form-group">
      <select name="id_unker" class="form-control" id="id_unker" onChange="showData(this.value)">
      <?php
          echo "<option value=''>- Pilih Unit Kerja -</option>";
          foreach($unker as $uk)
          {
              echo "<option value='".$uk['id_unit_kerja']."'>".$uk['id_unit_kerja']." | ".$uk['nama_unit_kerja']."</option>";
          }
      ?>
      </select>
  </div>  
</form>
<br />
  <div>  
  <div id='tampil'></div>
  </div>
</center>
<script type="text/javascript">
$("#id_unker").select2({
   width: '600px',
   theme: "classic",
   delay: 250 
});   
</script>
