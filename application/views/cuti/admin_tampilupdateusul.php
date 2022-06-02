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
    var url="cariupdateusul";
    url=url+"?nip="+str1;
    url=url+"&thn="+str2;
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
  <div class="panel panel-danger" style="width:70%; background-color:Beige;">
  <div class="panel-body">

  <div class="panel panel-info" style="padding:30px;overflow:auto;width:100%;height:550px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>UPDATE DATA USUL CUTI</b>
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
    <form method='POST' name='formupdateusul'>    
      <table>      
      <tr>
        <td>
          <div class="input-group navbar-form">
          <span class="input-group-addon" id="basic-addon1">NIP </span>    
          <input type="text" name="nip" id="nip" class="form-control" placeholder="Ketik NIP dan tekan Enter" aria-describedby="basic-addon1" onkeyup="validAngka(this)" size='25' maxlength='18' onChange="showData(this.value, formupdateusul.thncuti.value)">
          </div>
        </td>
        <td>
          <?php
            $thn = date('Y');
          ?>
          <select name="jnscuti" id="thncuti" required onChange="showData(formupdateusul.nip.value, this.value)" />
          <option value='' selected>-- Tahun Cuti --</option>
          <option value='<?php echo $thn; ?>'><?php echo $thn; ?></option>
          <option value='<?php echo $thn-1; ?>'><?php echo $thn-1; ?></option>
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
