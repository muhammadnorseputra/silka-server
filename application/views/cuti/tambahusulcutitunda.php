<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.tanggal').datepicker({
      format: "dd-mm-yyyy",
      todayHighlight: true,
      clearBtn: true,
      autoclose:true
    });
  });

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

  function showNama(str1, str2, str3)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatacuti";
    url=url+"?thn="+str1; 
    url=url+"&nip="+str2;    
    url=url+"&kel="+str3;
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
        echo "<form method='POST' action='../cuti/detailpengantar'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formtambahusulcuti' action='../cuti/tambahusulcutitunda_aksi'>
      <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $idpengantar; ?>'>

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>TAMBAH USUL CUTI TUNDA</b>
        </div>

        <table class="table">
          <tr>
            <td align='center'>              
             
              <table class="table table-bordered">
                <tr>
                  <td align='right' width='110'>No. Pengantar :</td>
                  <td width='300'><input type="text" name="nopengantar" value="<?php echo $nopengantar; ?>" disabled/></td>
                  <td align='right' width='110'>Tgl. Pengantar :</td>
                  <td><input type="text" name="tglpengantar" class="tanggal" value="<?php echo tgl_indo($tglpengantar); ?>" disabled /></td>
                  <td rowspan='6' width='250'><div id='nama'></div></td>
                </tr>
                <tr>
                  <td align='right'>NIP :</td>
                  <!-- NIP ini hanay untuk pencarian, NIP yang disimpan ke database pada pada Controller cuti.php getdatacuti(), dengan metode ajax -->
                  <td><input type="text" name="nip" id="nip" size='25' maxlength='18' onkeyup="validAngka(this)" onChange="showNama(formtambahusulcuti.tahun.value, this.value, 'CUTI LAINNYA')" value='' required /></td>                  
                  <td colspan='2' align='left'>Keputusan Pejabat Yang Berwenang</td>
                </tr>                
                <tr>
                  <td align='right'>Tahun :</td>
                  <td>
                    <input type="text" name="tahun" size='8' maxlength='4' onkeyup="validAngka(this)" value="<?php echo date('Y'); ?>" onChange="showNama(this.value, formtambahusulcuti.nip.value, 'CUTI LAINNYA')" required />
                  </td>
                  <td colspan='2' rowspan='3'><textarea id="keputusan_pej" name="keputusan_pej" rows="4" cols="60"></textarea></td>
                </tr>
                <tr>
                  <td align='right'>Jumlah Hari : </td>
                  <td colspan='1'><input type="text" name="jmlhari" size='8' onkeyup="validAngka(this)" maxlength='2' value=''   />
                  </td>
                  
                </tr>
                <tr>
                <td align='right'></td>
                <td align='center'></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
       <!-- Tombol submit ada pada file cuti.php function getdatacuti() dengan metode ajax -->
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
