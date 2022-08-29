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
    var url="show_reflokasibkn";
    url=url+"?nmlok="+str1;
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
    <div class="panel panel-info" style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>DATA REFERENSI JENIS JABATAN PENANDATANGAN SK</b>
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
    <?php
	$datattd = $this->mpegawai->cari_refjenisttdbkn()->result_array();
        $no = 1;
        echo "<div style='width:80%;margin:30px;'>";

        ?>
        <table width="100%" class="table table-striped table-bordered table-hover" style="width: 60%;">
                <thead>
                        <tr role="row">
                                <th style="width: 5%;;" class='info'><center>NO</center></th>
                                <th style="width: 10%;" class='info'><center>KODE</center></th>
                                <th style="width: 50%;" class='info'><center>NAMA JABATAN</center></th>
                        </tr>
                </thead>
                <tbody>
        <?php

        if ($datattd){
                foreach($datattd as $v){
                ?>
                        <tr role="row">
                                <td align='center'><?php echo $no; ?></td>
                                <td align='center'><?php echo $v['id']; ?></td>
                                <td><?php echo $v['nama']; ?></td>
                        </tr>
                <?php
		$no++;
                } // End Foreach
        }
    ?>
</center>

