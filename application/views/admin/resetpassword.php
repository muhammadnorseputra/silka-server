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

  function cekvalid(str1, str2)
  { xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="ceksamapassword";
    url=url+"?pbaru="+str1;
    url=url+"&pbarulagi="+str2;
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
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
  
</script>

<center>  
  <div class="panel panel-default" style="width: 30%;border:0px solid white">
    <div class="panel-body">    
      <form method='POST' name='rstpwd' action='../admin/prosesresetpassword'>

      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-reload" aria-hidden="true"></span>
        <b>Reset Password</b>
        </div>
        <?php
          foreach($user as $v):
        ?>
        <table class="table table-condensed">
          <tr>
            <td align='center'>             
              <table class='table table-condensed'>
                <tr class='danger'>
                  <td align='right' width='150'>NIP :</td>
                  <td><input type="text" size='30' value='<?php echo $v['nip']; ?>' disabled />
                  <input type="hidden" name="nip" size='30' value='<?php echo $v['nip']; ?>'/></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Nama :</td>
                  <td><input type="text" name="nama" value='<?php echo $nama;?>' disabled /></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Username :</td>
                  <td><input type="text" value='<?php echo $v['username']?>' disabled />
                  <input type="hidden" name="username" value='<?php echo $v['username']?>'/></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Reset Password Baru :</td>
                  <td><input type="password" name="pwdbaru" width='30' maxlength='16' onChange="cekvalid(this.value, rstpwd.pwdbarulagi.value)" required /></td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Password Baru (Ulangi):</td>
                  <td><input type="password" name="pwdbarulagi" width='30' maxlength='16' onChange="cekvalid(rstpwd.pwdbaru.value, this.value)" required /></td>
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
        <?php
        endforeach;
        ?>
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
