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
  
  
  function showData(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="cariupdatestatus";
    url=url+"?nip="+str1;
    url=url+"&jns="+str2;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("ditemukan").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("ditemukan").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
</script>

<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:540px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-info"   style="padding:3px;overflow:auto;width:98%;height:510px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>UPDATE STATUS USUL CUTI</b>
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
    <form method='POST' name='formupdatestatus'>    
      <table>      
      <tr>
        <td>
          <div class="input-group navbar-form">
          <span class="input-group-addon" id="basic-addon1">NIP </span>    
          <input type="text" name="nip" id="nip" class="form-control" placeholder="Ketik NIP dan tekan Enter" aria-describedby="basic-addon1" onkeyup="validAngka(this)" size='25' maxlength='18' >
          </div>
        </td>
        <td>
          <select name="jnscuti" id="jnscuti" required onChange="showData(formupdatestatus.nip.value, this.value)" />
          <option value='' selected>-- Pilih Jenis Cuti --</option>
          <option value='CUTI LAINNYA'>CUTI LAINNYA</option>
          <option value='CUTI TUNDA'>CUTI TUNDA</option>
          </select>    
        </td>
      </tr>
      </table>
      </form>
      

  <!-- untuk ajax -->
  

  </center>
  <div id='ditemukan'></div>
  </div>
</div>
</div>
</center>
