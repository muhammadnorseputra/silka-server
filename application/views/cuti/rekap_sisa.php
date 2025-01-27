<script type="text/javascript">
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
  
  
  function showData(str1, str2, str3, str4, str5)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="carirekap_sisa";
    url=url+"?idunker="+str1;
    url=url+"&bln="+str2;
    url=url+"&thn="+str3;
    url=url+"&jnsasn="+str4;
    url=url+"&jmlhkpw="+str5;
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
  <div class="panel panel-warning" style="padding:3px;overflow:auto;width:98%;height:510px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>REKAPUTILASI SISA CUTI</b>
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
    <div class="<?php echo $jnspesan; ?>" alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>
  
  <center>
    <form method='POST' name='formrekapsisa'>    
      <table>      
      <tr>        
        <td>
          <select name="id_unker" id="id_unker" required style='width:600px;' >
          <?php
          echo "<option value=''>- Pilih Unit Kerja -</option>";
          foreach($unker as $uk)
          {
            echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
          }
          ?>
          </select>
        </td>
	<td style='padding-left: 5px;'>
        <select name="bln" id="bln" required>
        <?php
            echo "<option value='0'>- Bulan -</option>";
            echo "<option value='1' selected>Januari</option>";
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
        <td style='padding-left: 5px;'>
          <select name="thn" id="thn" required />
          <?php
          echo "<option value=''>- Tahun Cuti -</option>";
          echo "<option value='2025' selected>2025</option>";
	  echo "<option value='2024'>2024</option>";
          /*foreach($tahun as $thn)
          {
            echo "<option value='".$thn['thn_cuti']."'>".$thn['thn_cuti']."</option>";
          }*/
          ?>
          </select>    
        </td>
	<td style='padding-left: 5px;'>
          <select name="jnsasn" id="jnsasn" required />
          <option value=''>- Jenis ASN -</option>
	  <option value='PNS' selected>PNS</option>
	  <option value='PPPK'>PPPK</option>
        </td>
        <td style='padding-left: 5px;'>
          <select name="jmlhkpw" id="jmlhkpw" required />
          <option value=''>- Jumlah Hari Kerja -</option>
          <option value='5' selected>5 HK</option>
          <option value='6'>6 HK</option>
        </td>
	<td style='padding-left: 5px;'>
	   <button type="button" class="btn btn-info btn-sm" onClick="showData(formrekapsisa.id_unker.value, formrekapsisa.bln.value, formrekapsisa.thn.value, formrekapsisa.jnsasn.value, formrekapsisa.jmlhkpw.value)">
            <span class="fa fa-cloud-download" aria-hidden="true"></span> Kalkulasi Sisa
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
