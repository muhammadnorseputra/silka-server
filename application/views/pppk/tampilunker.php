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

<center>
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

<?php
  if ($this->session->userdata('nonpns_priv') == "Y") {
?>
  <div class='row' atyle='width:80%;'>
     <div class="col-lg-8" align='center'>	
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
     </div>
     <div class="col-lg-4" align='center'>
            <form class="navbar-form navbar-center" role="search" method="POST" action="../pppk/tampildatacari">
              <div class="form-group">
                <input type="text" name="data" id="data" class="form-control" placeholder="Ketik NIP PPPK / Nama" size='25' maxlength='25'>
                <button type="submit" class="btn btn-warning btn-sm">
                  <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Cari PPPK</button>
              </div>
            </form>
     </div>
  </div>	
<?php
}
?>

  <div id='tampil' style="height: 450px;"></div>
  </div>
</center>
