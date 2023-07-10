<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
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
    var url="tampilperunker";
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
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Loading...</center>";
    }
  } 
</script>
<?php
	$get_bulan_open = "06";
	$get_bulan = date("m");
	if($get_bulan === $get_bulan_open):
?>
<center>
    
  <table class='table table-condensed'>
    <tr>
      <?php
      if ($this->session->userdata('nonpns_priv') == "Y") { 
      ?>
      <td align='center'>
        <form class="navbar-form navbar-center">
          <div class="form-group">
              <select name="id_unker" id="id_unker" onChange="showData(this.value)">
              <?php
                  echo "<option value=''>- Pilih Unit Kerja -</option>";
                  foreach($unker as $uk)
                  {
                      echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
                  }
              ?>
              </select>

          </div>
        </form>
      </td>
      <?php
      }
      ?>
    </tr>
  </table>
  
  <div>  
	  <div id='tampil' style="height: 450px;">
	 		<h3>Penilaian Instrumen Kinerja</h3>
	 		<p>Silahkan pilih unit kerja anda, kemudian pilih salah satu pegawai yang akan dinilai.</p> <hr>
	 		
	  </div>
  </div>
</center>
<?php else: ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="jumbotron">
				  <h2><i class="glyphicon glyphicon-info-sign"></i><br><br>Penilaian Instrumen Kinerja Ditutup Sementara.</h2>
				  <p>Akan dibuka kembali setelah pemberitahuan dari kami, terimakasih.</p>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>