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
  
  
  function showData(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="cariprogress_ipasn_siasn";
    url=url+"?idunker="+str1;
    url=url+"&tahun="+str2;
    url=url+"&tl="+str3;
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
  <div class="panel panel-success" style="padding:3px;overflow:auto;width:100%;height:740px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>PROGRESS PENGUKURAN IPASN VERSI SIASN BKN</b>
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

  <div class="well well-sm">
    <?php
    $tglterakhir = $this->mpip->tgl_updateterakhir_siasn();
    ?>
    <h5>NILAI INDEKS PROFESIONALITAS PNS PEMKAB. BALANGAN TAHUN 2023 per  tanggal <?php echo date('d-m-Y', strtotime($tglterakhir)); ?> (Sumber data SIASN)</h5>
    
    <?php	
        $sqlrata = $this->mpip->nilairata_pertanggal_siasn($tglterakhir)->result_array();
	echo "<div class='row'>";
	echo "<h5>";
        foreach($sqlrata as $z):
		echo "<div class='col-md-2'><div class='alert alert-success'><b>Jumlah Data : ".round($z['jmldata'],2)."</b></div></div>";
		echo "<div class='col-md-2'><div class='alert alert-info'><b>Kualifikasi : ".round($z['ratakua'],2)."</b></div></div>";
                echo "<div class='col-md-2'><div class='alert alert-info'><b>Kompetensi : ".round($z['ratakomp'],2)."</b></div></div>";
                echo "<div class='col-md-2'><div class='alert alert-info'><b>Kinerja : ".round($z['ratakin'],2)."</b></div></div>";
                echo "<div class='col-md-2'><div class='alert alert-info'><b>Disiplin : ".round($z['ratadis'],2)."</b></div></div>";
                echo "<div class='col-md-2'><div class='alert alert-danger'><b>Nilai IPASN : ".round($z['ratatotal'],2)."</b></div></div>";
        endforeach;
	echo "</h5>";
	echo "</div>";
        ?>
  </div>

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
    
    <form method='POST' name='formupdatestatus'>    
      <table>      
      <tr>        
        <td>
          <select name="id_unker" id="id_unker" required onChange="showData(this.value, formupdatestatus.tahun.value, formupdatestatus.tgllap.value)"/>
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
	  <select name="tahun" id="tahun" required onChange="showData(formupdatestatus.id_unker.value, this.value, formupdatestatus.tgllap.value)"/>
          <option value=''>- Pilih Tahun -</option>
          <option value='2022' selected>2022</option>
	  <option value='2023' selected>2023</option>
	  </select>
	</td>
        <td>
          <select name="tgllap" id="tgllap" required onChange="showData(formupdatestatus.id_unker.value, formupdatestatus.tahun.value, this.value)" />
          <?php
          echo "<option value=''>- Pilih Tanggal Update -</option>";
          foreach($tgllap as $tl)
          {
	    if ($tl['tgl_update'] == $tglterakhir) {	
              echo "<option value='".$tl['tgl_update']."' selected>".date('d-m-Y', strtotime($tl['tgl_update']))."</option>";
	    } else {
	      echo "<option value='".$tl['tgl_update']."'>".date('d-m-Y', strtotime($tl['tgl_update']))."</option>";
	    }
          }
          ?>
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
