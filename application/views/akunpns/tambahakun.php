<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

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

  function showNama(str1)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataakun";
    url=url+"?nip="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedNama;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedNama(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("nama").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("nama").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
  </script>


<center>  
  <div class="panel panel-warning" style="width: 70%">
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

      <form method='POST' action='../akunpns/tambahakun_aksi'>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>TAMBAH AKUN PNS</b>
        </div>

        <table class="table table-condensed">
          <tr>
            <td align='center'>
              <table class='table table-condensed' style="width: 100%">
                <tr>
                  <td align='right' width='100'>NIP :</td>
                  <td><input type="text" name="nip" size='30' maxlength='18' onkeyup="validAngka(this)" onChange="showNama(this.value)" required />
                  </td>
                  <td rowspan='3' width='550' class='info'>
                    <div id='nama'></div>
                  </td>
                </tr>
                <tr>
                  <td align='right'>Password :</td>
                  <td><input type="password" name="password" size='20' maxlength='18' required />
                   <small class="text-muted" style="color: red;">Password tidak boleh sama dengan NIP</small>
		  </td>
                </tr>                
                <tr>
                  <td align='right'>Status :</td>
                  <td>
                    <select name="status" id="status" required />
                      <?php
                      echo "<option value='AKTIF' selected>AKTIF</option>";
                      echo "<option value='NONAKTIF'>NONAKTIF</option>";
                      ?>
                    </select>                            
                  </td>
                </tr>                
              </table>
            </td>
          </tr>
        </table>
      </div>          
        <!--
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
        -->
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
