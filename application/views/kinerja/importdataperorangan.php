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
  
  
  function showData(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showkinbulananperorangan";
    url=url+"?nip="+str1;
    url=url+"&thn="+str2;
    url=url+"&bln="+str3;
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
  <div class="panel panel-default" style="width:99%;height:650px;border:0px solid white">
  <div class="panel-body">

    <div class="panel panel-warning"   style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>IMPORT DATA KINERJA PERORANGAN</b>
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
    <form method='POST' name='formkin'>    
      <table style='width:50%;'>      
      <tr>
        <td>
          <input class='form-control' placeholder='Ketik NIP' type='text' name='nip' id='nip' maxlength='18' value=''>
        </td>
        <td>
        <select class='form-control' name="thn" id="thn" required>
        <?php
            echo "<option value='0'>- Pilih Tahun -</option>";
	    //echo "<option value='2021'>2021</option>";
	    //echo "<option value='2022'>2022</option>";
	    echo "<option value='2023' selected>2023</option>";
	    echo "<option value='2024'>2024</option>";	
        ?>
        </select>
        </td>          
        <td>
        <select class='form-control'  name="bln" id="bln" required>
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
          <button type="button" class="btn btn-info" onClick="showData(formkin.nip.value, formkin.thn.value, formkin.bln.value)">
            <span class="fa fa-cloud-download" aria-hidden="true"></span> Download Kinerja Bulanan
          </button>          
        </td>
      </tr>
      </table>
      </form>
      

  <!-- untuk ajax -->
  
  </center>
  <div id='tampilkan'></div>
  </div>
</div>
</div>
</center>
