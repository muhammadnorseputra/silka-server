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
    var url="showhasilimportbulanan";
    url=url+"?thn="+str1;
    url=url+"&bln="+str2;
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
    <div class="panel panel-info"   style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>CROSCEK DATA HASIL IMPORT</b>
      </div>

      <div align='right' style='padding:10px;'>
       <form method="POST" action="../home">
        <button type="submit" class="btn btn-primary btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
        </button>
      </form>
    </div>


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
    <form method='POST' name='formkin'>    
      <table style='width:25%;'>      
      <tr>        
        <td>
        <select name="thn" id="thn" required>
        <?php
            echo "<option value='0'>- Pilih Tahun -</option>";
            echo "<option value='2020'>2020</option>";          
	    echo "<option value='2021' selected>2021</option>";
	    echo "<option value='2022' selected>2022</option>";
        ?>
        </select>
        </td>          
        <td>
        <select name="bln" id="bln" required>
        <?php
            echo "<option value='0' selected>- Pilih Bulan -</option>";
            echo "<option value='1'>Januari</option>";
            echo "<option value='2'>Februari</option>";
            echo "<option value='3'>Maret</option>";
            echo "<option value='4'>April</option>";
            echo "<option value='5'>Mei</option>";
            echo "<option value='6'>Juni</option>";
            echo "<option value='7'>Juli</option>";
            echo "<option value='8'>Agustus</option>";
            echo "<option value='9'>September</option>";
            echo "<option value='10'>Oktober</option>";
            echo "<option value='11'>November</option>";
            echo "<option value='12'>Desember</option>";
        ?>
        </select>
        </td>
        <td>
          <button type="button" class="btn btn-success btn-sm" onClick="showData(formkin.thn.value, formkin.bln.value)">
            <span class="fa fa-cloud-download" aria-hidden="true"></span> Cek Hasil Import
          </button>          
        </td>
      </tr>
      </table>
      </form>
      

  <!-- untuk ajax -->
  
  </center>
  <div id='tampilkan'></div>
  </div>
</center>
