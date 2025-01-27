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


  function showData(str1,str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="cari_wllhkpn";
    url=url+"?idunker="+str1;
    url=url+"&tahun="+str2;
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
  <div class="panel panel-info" style="padding:3px;overflow:auto;width:90%;height:510px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>NOMINATIF ASN WAJIB LAPOR LHKPN</b>
        </div>
  
  <table class='table table-condensed'>
    <tr>            
      <td align='right' width='30'>
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
    <form method='POST' name='formwllhkpn'>
     <table>      
      <tr>        
        <td>
          <select name="id_unker" id="id_unker" onChange="showData(this.value,formwllhkpn.tahun.value)" />
          <?php
          echo "<option value=''>- Pilih Unit Kerja -</option>";
          foreach($unker as $uk)
          {
            echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
          }
          ?>
          </select>
        </td>
	<td> 
          <select name="tahun" id="tahun" required onChange="showData(formwllhkpn.id_unker.value, this.value)" />
	  <option value=''>-- Tahun Wajib Lapor --</option>
	  <option value='2023' selected>2023</option>
          </select>
        </td>
      </tr>
      </table>
      </form>
      

  <!-- untuk ajax -->
  

  </center>
  <div id='tampilkan'></div>
  </div>
</center>
