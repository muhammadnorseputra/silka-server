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
  <div class="panel panel-warning" style="width: 30%;border:0px solid white">
    <div class="panel-heading">    
      <?php
        echo "<form method='POST' action='../akunpns/listakun'>";          
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='rstpwd' action='../akunpns/prosesresetpassword'>

      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-reload" aria-hidden="true"></span>
        <b>Reset Password Akun</b>
        </div>
        <?php
          foreach($user as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>             
              <table class='table table-condensed'>
                <tr>
                  <td align='right' width='150'>NIP :</td>
                  <td><input type="text" size='20' value='<?php echo $v['nip']; ?>' disabled />
                  <input type="hidden" name="nip" size='30' value='<?php echo $v['nip']; ?>'/></td>
                </tr>
                <tr>
                  <td align='right'>Nama :</td>
                  <td><input type="text" size="30" name="nama" value='<?php echo $nama;?>' disabled /></td>
                </tr>
		<tr>
                <td colspan="2">
                  <small class="text-muted" style="color: red;">Password tidak boleh sama dengan NIP</small>
                </td>
                </tr>
                <tr>
                  <td align='right'>Password Baru :</td>
                  <td><input type="password" name="pwdbaru" size='20' maxlength='20' onChange="cekvalid(this.value, rstpwd.pwdbarulagi.value)" required />
                  <small id="gajiHelpInline" class="text-muted">Min. 8 Karakter</small></td>
                </tr>
                <tr>
                  <td align='right'>Password Baru (Ulangi):</td>
                  <td><input type="password" name="pwdbarulagi" size='20' maxlength='20' onChange="cekvalid(rstpwd.pwdbaru.value, this.value)" required />
                  <small id="gajiHelpInline" class="text-muted">Min. 8 Karakter</small></td>
                </tr>
                <tr>
                  <td align='right' colspan='2'>
                  <small id="passwdHelpInline" class="text-muted">Tombol "Reset Password" akan tampil otomatis ketika data "Password Baru" sama dengan "Password Baru (ulangi), dan minimal 8 karakter"</small>
                  </td>
                </tr>
                <tr>
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
