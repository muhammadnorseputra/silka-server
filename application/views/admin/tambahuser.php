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
    var url="getdatauser";
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
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../admin/listuser'>";          
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' action='../admin/tambahuser_aksi'>
      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>TAMBAH USER</b>
        </div>

        <table class="table">
          <tr>
            <td align='center'>              
             
              <table class='table table-condensed'>
                <tr>
                  <td align='right' colspan='2'>NIP :</td>
                  <td colspan='3'><input type="text" name="nip" size='30' maxlength='18' onkeyup="validAngka(this)" onChange="showNama(this.value)" required />
                  </td>
                  <td rowspan='4' colspan='5'><div id='nama'></div></td>
                </tr>
                <tr>
                  <td align='right' colspan='2'>Username :</td>
                  <td colspan='3'><input type="text" name="username" size='30' maxlength='18' required />
                  </td>
                </tr>
                <tr>
                  <td align='right' colspan='2'>Password :</td>
                  <td colspan='3'><input type="text" name="password" size='20' maxlength='18' required />
                  </td>
                </tr>                
                <tr>
                  <td align='right' colspan='2'>Level :</td>
                  <td colspan='3'>
                    <select name="level" id="level" required />
                      <?php
                      echo "<option value=''>- Pilih Level -</option>";
                      echo "<option value='ADMIN'>ADMIN</option>";
                      echo "<option value='USER'>USER</option>";
                      echo "<option value='TAMU'>TAMU</option>";
                      ?>
                    </select>                            
                  </td>
                </tr>
                <tr class='danger'>
                  <td colspan='10' align='center'>PRIVILEDGE</td>
                </tr>
                <tr class='danger'>
                  <td width='70' align='right'>Profil</td>
                  <td width='100'>
                    <input name='profil' type='radio' value='Y'>Y &nbsp
                    <input name='profil' type='radio' value='N' checked='checked'>N
                  </td>
		  <td width='70' align='right'>Edit Profil</td>
                  <td width='100'>
                    <input name='edit_profil' type='radio' value='Y'>Y &nbsp
                    <input name='edit_profil' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Cetak Profil</td>
                  <td width='100'>
                    <input name='cetakprofil' type='radio' value='Y'>Y &nbsp
                    <input name='cetakprofil' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Nominatif</td>
                  <td width='100'>
                    <input name='nominatif' type='radio' value='Y'>Y &nbsp
                    <input name='nominatif' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='90' align='right'>Cetak Nominatif</td>
                  <td width='100'>
                    <input name='cetaknominatif' type='radio' value='Y'>Y &nbsp
                    <input name='cetaknominatif' type='radio' value='N' checked='checked'>N
                  </td>
                </tr>
                <tr class='danger'>
                  <td width='70' align='right'>Statistik</td>
                  <td width='100'>
                    <input name='statistik' type='radio' value='Y'>Y &nbsp
                    <input name='statistik' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='90' align='right'>Cetak Statistik</td>
                  <td width='100'>
                    <input name='cetakstatistik' type='radio' value='Y'>Y &nbsp
                    <input name='cetakstatistik' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>SOTK</td>
                  <td width='100'>
                    <input name='sotk' type='radio' value='Y'>Y &nbsp
                    <input name='sotk' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Cetak SOTK</td>
                  <td width='100'>
                    <input name='cetaksotk' type='radio' value='Y'>Y &nbsp
                    <input name='cetaksotk' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Usul Cuti</td>
                  <td width='100'>
                    <input name='usulcuti' type='radio' value='Y'>Y &nbsp
                    <input name='usulcuti' type='radio' value='N' checked='checked'>N
                  </td>
                </tr>
                <tr class='danger'>
                  <td width='70' align='right'>Proses Cuti</td>
                  <td width='100'>
                    <input name='prosescuti' type='radio' value='Y'>Y &nbsp
                    <input name='prosescuti' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Usul KGB</td>
                  <td width='100'>
                    <input name='usulkgb' type='radio' value='Y'>Y &nbsp
                    <input name='usulkgb' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Proses KGB</td>
                  <td width='100'>
                    <input name='proseskgb' type='radio' value='Y'>Y &nbsp
                    <input name='proseskgb' type='radio' value='N' checked='checked'>N
                  </td>
                  <td width='70' align='right'>Non PNS</td>
                  <td width='100'>
                    <input name='nonpns' type='radio' value='Y'>Y &nbsp
                    <input name='nonpns' type='radio' value='N' checked='checked'>N
                  </td>
		  <td width='70' align='right'>Akun PNS</td>
                  <td width='100'>
                    <input name='akunpns' type='radio' value='Y'>Y &nbsp
                    <input name='akunpns' type='radio' value='N' checked='checked'>N
                  </td>
                </tr>
		</tr>
                <tr class='danger'>
                  <td width='70' align='right'>TPP</td>
                  <td width='100'>
                    <input name='tpp' type='radio' value='Y'>Y &nbsp
                    <input name='tpp' type='radio' value='N' checked='checked'>N
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
