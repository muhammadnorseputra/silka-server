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
  
  
  function showData(str1, str2, str3, str4)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilpnsusul";
    url=url+"?nip="+str1;
    url=url+"&uk="+str2;
    url=url+"&thn="+str3;
    url=url+"&bln="+str4;
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
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }

  function showKalkulasi(str1, str2, str3, str4, str5, str6)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilkalkulasi";
    url=url+"?nip="+str1;
    url=url+"&thn="+str2;
    url=url+"&bln="+str3;
    url=url+"&kls="+str4;
    url=url+"&kin="+str5;
    url=url+"&abs="+str6;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedKalkulasi;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedKalkulasi(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("kalkulasi").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("kalkulasi").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
</script>

<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:640px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-success"   style="padding:3px;overflow:auto;width:70%;height:610px;">
    <div class='panel-heading' align='left'>
      <b>TAMBAH USUL TPP PERIODE <?php echo strtoupper(bulan($bln))." ".$thn; ?></b><br/>
      <?php
        $nmunker = $this->munker->getnamaunker($idunker);
        echo $nmunker;
      ?>
    </div>
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method='POST' action='../kinerja/detail_pengantar'>   
            <input type='hidden' name='fid_unker' id='fid_unker' value='<?php echo $idunker; ?>'>
            <input type='hidden' name='thn' id='thn' value='<?php echo $thn; ?>'>
            <input type='hidden' name='bln' id='bln' value='<?php echo $bln; ?>'>         
            <button type='submit' class='btn btn-success btn-sm'>
              <span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>Kembali
            </button>
          </form>
      </td>
    </tr>
  </table> 

  <?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?>" alert-info role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>
  
  <center>
    <form method='POST' name='formtambahusul'>    
      <table>      
      <tr>
        <td>
          <div class="input-group navbar-form">
          <span class="input-group-addon" id="basic-addon1">NIP </span>    
          <input type="text" name="nip" id="nip" class="form-control" placeholder="Ketik NIP dan tekan Enter" aria-describedby="basic-addon1" onkeyup="validAngka(this)" size='25' maxlength='18'>
          <input type="hidden" name="idunker" id="idunker" value='<?php echo $idunker; ?>'>          
          <input type="hidden" name="thn" id="thn" value='<?php echo $thn; ?>'>
          <input type="hidden" name="bln" id="bln" value='<?php echo $bln; ?>'>
          </div>
        </td>       
        <td align='right' width='50'>
          <button type="button" class="btn btn-primary btn-sm" onClick="showData(formtambahusul.nip.value, formtambahusul.idunker.value, formtambahusul.thn.value, formtambahusul.bln.value)">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Tampil Data PNS
          </button>
      </td>
      </tr>
      </table>
      </form>
      

  <!-- untuk ajax -->
  

  </center>
  <div align='left' id='tampil'></div>
  </div>
</div>
</div>
</center>
