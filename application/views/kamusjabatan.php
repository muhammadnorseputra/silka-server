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
    var url="showkamusjabatan";
    url=url+"?nmjab="+str1;
    url=url+"&jns="+str2;
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
      document.getElementById("tampilkan").innerHTML= "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
</script>

<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:650px;border:0px solid white">
  <div class="panel-body">

    <div class="panel panel-warning"   style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>KAMUS KELAS JABATAN SESUAI PERATURAN BKN NO. 5 TAHUN 2021</b>
      </div>
	

        <table class='table table-condensed'>
          <tr>            
            <td align='right' width='50'>
              <form method="POST" action="tampilimportepresensi">
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
    <form method='POST' name='formkamus'>
	<div class="row" style="padding:3px;width:70%;height:auto;">
		<div class="col-md-8 text-center">
			<input class='form-control' placeholder='Ketik Nama Jabatan' type='text' name='nmjab' id='nmjab' maxlength='50' value=''>
		</div>
		<div class="col-md-3 text-center">    
			<select class='form-control' name="jnsjab" id="jnsjab" required>
        		<?php
            		echo "<option value='0' selected>- Pilih Jenis Jabatan -</option>";
            		echo "<option value='jft'>FUNGSIONAL TERTENTU</option>";
            		echo "<option value='jfu'>FUNGSIONAL UMUM</option>";
        		?>
       	 		</select>
		</div>
		<div class="col-md-1 text-left">
			<button type="button" class="btn btn-info" onClick="showData(formkamus.nmjab.value, formkamus.jnsjab.value)">
            		<span class="fa fa-search" aria-hidden="true"></span> Tampil Data
          </button>
		</div>
	</div>
      </form>

  <!-- untuk ajax -->
  
  </center>
  <div id='tampilkan'></div>
  </div>
</div>
</div>
</center>

