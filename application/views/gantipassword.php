<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

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

  function cekvalid(str1, str2, str3, str4)
  { xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="cekgantipassword";
    url=url+"?nip="+str1;
    url=url+"&plama="+str2;
    url=url+"&pbaru="+str3;
    url=url+"&pbarulagi="+str4;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedHasil;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedHasil(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("hasil").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("hasil").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center>";
    }
  } 
  
</script>

<center>  
  <div class="panel panel-default" style="width: 30%;border:0px solid white">
    <div class="panel-body">    
      <form method='POST' name='gntpwd' action='../login/prosesgantipassword'>

      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>Ganti Password</b>
        </div>
        <?php
        $nip = $this->session->userdata('nip');
        ?>

        <table class="table table-condensed">
          <tr>
            <td align='center'>             
              <table class='table table-condensed'>
                <tr class='danger'>
                  <td align='right' width='150'>NIP :</td>
                  <td><input type="text" name="nip" size='30' value='<?php echo $nip; ?>' disabled /></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Username :</td>
                  <td><input type="text" name="nama" value='<?php echo $this->session->userdata('nama');?>' disabled /></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Password Lama :</td>
                  <td><input type="password" name="pwdlama" width='30' maxlength='16' onChange="cekvalid(gntpwd.nip.value, this.value, gntpwd.pwdbaru.value, gntpwd.pwdbarulagi.value)" required /></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Password Baru :</td>
                  <td><input type="password" name="pwdbaru" width='30' maxlength='16' onChange="cekvalid(gntpwd.nip.value, gntpwd.pwdlama.value, this.value, gntpwd.pwdbarulagi.value)" required /></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Password Baru (Ulangi):</td>
                  <td><input type="password" name="pwdbarulagi" width='30' maxlength='16' onChange="cekvalid(gntpwd.nip.value, gntpwd.pwdlama.value, gntpwd.pwdbaru.value, this.value)" required /></td>
                </tr>
                <tr class='danger'>
                  <td align='right' colspan='2'>
                  <div id='hasil'></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div> 
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-danger">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
