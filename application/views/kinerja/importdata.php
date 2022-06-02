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
    var url="showkinbulanan";
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
    <div class="panel panel-primary"   style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>IMPORT DATA KINERJA</b>
      </div>

      <?php
      if ($pesan != '') {
        ?>
        <br/>
        <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
        <?php
      }
      ?>

      <?php
      if ($status == 1) {
      ?>

      <table class='table table-condensed'>
          <tr>
	      <?php
            //cek priviledge session user -- cetak_nominatif_priv
            if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('level') == "USER")) { 
            ?>      
              <td align='right'>
                <form method="POST" action="../kinerja/tampilimportperorangan">      
                  <button type="submit" class="btn btn-warning btn-sm">
                    <span class="fa fa-plus" aria-hidden="true"></span> Import Perorangan
                  </button>
                </form>
              </td>
            <?php
            }
            ?>
            <td align='right' width='50'>
              <form method="POST" action="../home">
                <button type="submit" class="btn btn-primary btn-sm">
                  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
              </form>
            </td>
          </tr>
        </table>

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
        <td>
        <select name="thn" id="thn" required>
        <?php
            echo "<option value='0'>- Pilih Tahun -</option>";
	    echo "<option value='2021'>2021</option>";          
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
          <select name="jns" id="jns" required>
            <option value='0'>- Pilih Jenis -</option>
            <option value='pns' selected>PNS</option>
            <option value='pppk'>PPPK</option>
          </select>
        </td>
        <td>
          <button type="button" class="btn btn-info btn-sm" onClick="showData(formkin.id_unker.value, formkin.thn.value, formkin.bln.value, formkin.jns.value)">
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
  
  <?php
  // end if status
  }
  ?>

</center>
