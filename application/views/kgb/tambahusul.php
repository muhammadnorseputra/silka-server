<!-- untuk inputan hanya angka dengan javascript -->
<!--
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
-->

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

  //validasi textbox khusus angka dan tanda strip (-)
  function validAngkaStrip(a)
  {
    if(!/^[0-9.-]+$/.test(a.value))
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
  
  function showDataKGB(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showDataTambah";
    url=url+"?idberkas="+str1;
    url=url+"&nip="+str2;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataKGB;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedDataKGB(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("KetKGB").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("KetKGB").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  function showSKAkhir(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showSKAkhir";
    url=url+"?nip="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedSKAkhir;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedSKAkhir(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("skterakhir").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("skterakhir").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/detailpengantar'>";          
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

      <form method='POST' name='formtambahusul' action='../kgb/tambahusul_aksi'>
      <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $idpengantar; ?>'>

      <div class="panel panel-success">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>TAMBAH USUL KGB</b>
        </div>

        <table class="table">
          <tr>
            <td align='center'>
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='120'>No. Pengantar :</td>
                  <td width='200' align='left'>
                    <input type="text" name="nopengantar" value="<?php echo $nopengantar; ?>" size='25' disabled/>
                  </td>
                  <td align='right' width='120'>Tgl. Pengantar :</td>
                  <td align='left'>
                    <input type="text" name="tglpengantar" class="tanggal" value="<?php echo tgl_indo($tglpengantar); ?>" disabled />                  
                  </td>
                </tr>                               
                <tr>
                  <td align='right'>NIP :</td>
                  <!-- NIP ini hanay untuk pencarian, NIP yang disimpan ke database pada pada Controller cuti.php getdatacuti(), dengan metode ajax -->
                  <td align='left'>
                    <input type="text" name="nip" placeholder='Ketikkan NIP' id="nip" size='25' maxlength='18' onkeyup="validAngka(this)" onChange="" value='' required />
                  </td>

                  <td align='left'>
                    <button type='button' class='btn btn-info btn-sm' onClick='showSKAkhir(formtambahusul.nip.value)'><span class='glyphicon glyphicon-search' aria-hidden='true'></span> Cari Data </button>
                  </td>
                  <td>
                    <div id='skterakhir'></div>
                  </td>

                  <!--
                  <td align='right'>Dokumen Terakhir :</td>
                  <td>
                    <select name="id_berkas" id="id_berkas" onChange="" required />
                      <?php
                      //echo "<option value=''>- Pilih Dokumen Gaji Terakhir -</option>";
                      //echo "<option value='SKCPNS'>SK CPNS (Untuk KGB Pertama)</option>";
                      //echo "<option value='SKKP'>SK Pangkat Terakhir</option>";
                      //echo "<option value='SKKGB'>SK KGB Terakhir</option>";
                      ?>
                    </select>&nbsp&nbsp
                    <button type='button' class='btn btn-info btn-sm' onClick="showDataKGB(formtambahusul.id_berkas.value, formtambahusul.nip.value)">
                      <span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>&nbsp&nbspTampilkan Data Gaji Terakhir
                    </button>
                  </td>
                -->
                </tr>        
                <tr>
                  <td align='left' colspan='5' rowspan='2'><div id='KetKGB'></div></td>
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
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-danger">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>