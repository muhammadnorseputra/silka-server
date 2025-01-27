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
  
  
  function showData(str1, str2, str3, str4)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showskpbulanan";
    url=url+"?uk="+str1;
    url=url+"&thn="+str2;
    url=url+"&bln="+str3;
    url=url+"&jns="+str4;
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
    <div class="panel panel-info" style="padding:3px;overflow:auto;width:100%;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>TAMPIL SKP BULANAN HASIL EKINERJA BARU</b>
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
      <table style='width:60%;'>      
      <tr>
        <td>
        <select name="id_unker" id="id_unker" required>
          <?php
              echo "<option value='0'>- Pilih Unit Kerja -</option>";
              foreach($unker as $uk)
              {
                echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
              }
          ?>
          </select>
        </td>
        <td style='padding-left: 3px;'>
        <select name="thn" id="thn" required>
        <?php
            echo "<option value='0'>- Tahun -</option>";
	    echo "<option value='2025' selected>2025</option>";
       ?>
        </select>
        </td>          
        <td style='padding-left: 3px;'>
        <select name="bln" id="bln" required>
        <?php
            echo "<option value='0' selected>- Bulan -</option>";
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
	<td style='padding-left: 3px;'>
        <select name="jns" id="jns" required>
            <option value='0'>- Jenis -</option>
            <option value='pns' selected>PNS</option>
            <option value='pppk'>PPPK</option>
          </select>
        </td>
        <td style='padding-left: 3px;'>
          <button type="button" class="btn btn-success btn-sm" onClick="showData(formkin.id_unker.value, formkin.thn.value, formkin.bln.value, formkin.jns.value)">
            <span class="fa fa-cloud-download" aria-hidden="true"></span> Tampil SKP Bulanan
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
