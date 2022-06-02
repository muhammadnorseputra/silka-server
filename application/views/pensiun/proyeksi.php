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
    var url="tampilproyeksi";
    url=url+"?thn="+str1;
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
  <div class="panel panel-info" style="padding:3px;width:98%;height:600px;">
    <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
      <b>PROYEKSI BUP 5 TAHUN</b>
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
    <div class="col-lg-4" align='center'></div>
    <div class="col-lg-3" align='center'>
      <form method='POST' name='formrekap' style='padding-top:8px'>       
        <div class="form-group input-group">    
          <span class="input-group-addon"><small>Pilih Tahun Proyeksi </small></span>
          <select class="form-control" name="thn" id="thn" required onChange="showData(this.value)">
          <?php
          $y = date('Y');
          echo "<option value='' selected>- Pilih Tahun -</option>";
          $i = 1;
          while($i<=6) {
            echo "<option value='".$y."'>".$y."</option>";
            $i++;
            $y++;
          }
          ?>
          </select>
        </div>
      </form>
    </div> 
    <div class="col-lg-5" align='center'></div>        
  </div>

  <!-- untuk ajax -->
  <div id='tampilkan'></div>
  </div>
</center>
