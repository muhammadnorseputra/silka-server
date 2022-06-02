<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  // hanya angka bilangan bulat, tidak berkoma	
  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      // lihat tabel char code pada javaascript (1 sampai 9 = 48 sampai 57)
       if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	document.getElementById("tahun").value = "";
        return false;
      }
      return true;
  }

  //function hanyaAngka(evt) {
  //    var charCode = (evt.which) ? evt.which : event.keyCode
  //    var angka = document.forms["formtambahskp"]["tahun"].value;
  //      // lihat tabel char code pada javaascript (1 sampai 9 = 48 sampai 57)
  //      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  //		document.getElementById("tahun").value = "";
  //              return false;
  //      } else if (angka >= 2020) {
  //              document.getElementById("tahun").value = "";
  //              alert("Tahun SKP harus 2020 keatas");
  //              return false;
  //      }
  //    return true;
  //}

  // diperbolehkan angka desimal/berkoma
  function hanyaAngkaDesimal(evt) {      
      var charCode = (evt.which) ? evt.which : event.keyCode
      // lihat tabel char code pada javaascript (titik=44, 1 sampai 9 = 48 sampai 57)
       if (charCode == 44 && charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
      return true;
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

  function showPP(str1)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatapp";
    url=url+"?jnspp="+str1;      
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedPP;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedPP(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilpp").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilpp").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  function showAPP(str1)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataapp";
    url=url+"?jnsapp="+str1;      
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedAPP;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedAPP(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilapp").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilapp").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  // Showunker untuk menampilkan unit kerja pada textbox sehingga bisa diedit manual
  function showunkerpp(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataunkerpp";
    url=url+"?idunker="+str1;      
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedUnkerPP;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedUnkerPP(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilunkerpp").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilunkerpp").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  // Showunker untuk menampilkan unit kerja pada textbox sehingga bisa diedit manual
  function showunkerapp(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataunkerapp";
    url=url+"?idunker="+str1;      
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedUnkerAPP;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedUnkerAPP(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilunkerapp").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilunkerapp").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  function showNilaiSkp(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatanilaiskp";
    url=url+"?nip="+str1;   
    url=url+"&thn="+str2;  
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedNilaiSkp;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedNilaiSkp(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilnilaiskp").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilnilaiskp").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  function showNilaiPrilaku(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatanilaiprilaku";
    url=url+"?nip="+str1;   
    url=url+"&thn="+str2;  
    url=url+"&jns="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedNilaiPrilaku;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedNilaiPrilaku(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilnilaiprilaku").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilnilaiprilaku").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/rwyskp'>";          
        echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <div class="row" style="padding:10px;"> <!-- Baris Awal -->
          <div class="col-md-12" align='right'>
            <button type="submit" class="btn btn-danger btn-sm">&nbsp
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
            </button>
          </div>

        </div>
      <?php
        echo "</form>";          
      ?>


      <form method='POST' name='formtambahskp' action='../crudskp/tambah_aksi_integrasi'>
      <input type='hidden' name='nip' namemaxlength='18' value='<?php echo $nip;?>'>

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-grain" aria-hidden="true"></span>
        <?php
          echo '<b>TAMBAH DATA SKP INTEGRASI</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

        <table class="table table-condensed">
          <tr>
            <td align='center'>
	      <p class='text-danger' align='left'>Catatan : Untuk menghindari kesalahan entri data dan mendapatkan hasil yang akurat, lakukan entri data secara berurutan sesuai <span class='label label-info'>NOMOR</span></p>
              <ul class="nav nav-tabs">
              <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
              <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
                <li class="active"><a href="#skp" data-toggle="tab"><h4><span class='label label-danger'>1.</span></h4><b>SKP Dan Prilaku Kerja</b></a></li>
                <li><a href="#pp" data-toggle="tab"><h4><span class='label label-danger'>2.</span></h4><b>Pejabat Penilai</b></a></li>
                <li><a href="#app" data-toggle="tab"><h4><span class='label label-danger'>3.</span></h4><b>Atasan Pejabat Penilai</b></a></li>
              </ul>

              <!-- Tab panes, ini content dari tab di atas -->
              <div class="tab-content">
                <div class="tab-pane face in active" id="skp">
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                  <div class="panel panel-default">
                    <table class='table table-condensed'>
                        <tr>              
                          <td align='right' width='200'><span class='label label-info'>1.</span> Jenis :</td>
                          <td>
                            <div class='row'>
                              <div class="col-md-3">
                              <select name="jenis" id="jenis" required>
                                <option value=''>- Pilih Jenis Jabatan -</option>
                                <option value='STRUKTURAL'>STRUKTURAL</option>
                                <option value='FUNGSIONAL UMUM'>FUNGSIONAL UMUM</option>
                                <option value='FUNGSIONAL TERTENTU'>FUNGSIONAL TERTENTU</option>
                              </select>   
                              </div>
                              <div class="col-md-2" align='right'><span class='label label-info'>2.</span> Tahun :</div>
                              <div class="col-md-2" align='left'>
				<input type="text" name="tahun" id="tahun" size='8' maxlength='4' onkeyup="return hanyaAngka(event)" required >
                              </div>
                            </div>

                          </td>    
                        </tr>
                        <tr>                                                
                          <td align='right' width='200'><b><span class='label label-info'>3.</span> Nilai SKP :</b></td>
                          <td>
                          <button type="button" class="btn btn-success btn-xs" OnClick="showNilaiSkp(formtambahskp.nip.value, formtambahskp.tahun.value)"><small>
                            <span class="fa fa-chevron-down" aria-hidden="true" ></span>&nbspGet Nilai SKP Tahunan pada eKinerja
                          </small></button>                          
                          <br/><br/> 
                          <div id='tampilnilaiskp'></div>
                          </td>                          
                        </tr>
                        <tr>                          
                          <td align='right'><b><span class='label label-info'>4.</span> Prilaku Kerja :</b></td>
                          <td colspan='3'>
                            <button type="button" class="btn btn-warning btn-xs" OnClick="showNilaiPrilaku(formtambahskp.nip.value, formtambahskp.tahun.value, formtambahskp.jenis.value)"><small>
                              <span class="fa fa-chevron-down" aria-hidden="true" ></span>&nbspGet Nilai Prilaku Kerja pada ePrilaku360
                            </small></button>
                            <br/><br/> 
                            <div id='tampilnilaiprilaku'></div>
                          </td>
                        </tr>
                      </table>      
                  </div>            
                </div> <!-- akhir konten tab SKP -->

                <div class="tab-pane fade" id="pp">
                  <br />
                    <div class="panel panel-default">
                        <table class='table table-bordered'>
                        <tr>
                          <td align='center' colspan='2'>Pilih Jenis Pejabat :&nbsp&nbsp
                          <input id='jnspp' name="jnspp" type="radio" value="PNS" onClick="showPP(this.value)"> PNS&nbsp&nbsp&nbsp
                          <input id='jnspp' name="jnspp" type="radio" value="NONPNS" onClick="showPP(this.value)"> Non PNS</td>
                        </tr>
                        <tr>
                        <td colspan='2' align='center'><div id='tampilpp'></div></td>
                        </tr>
                        </table>
                    </div>
                </div> <!-- akhir konten tab pp -->

                <div class="tab-pane fade" id="app">
                <br />
                  <div class="panel panel-default">
                    <table class='table table-bordered'>
                        <tr>
                          <td align='center' colspan='2'>Pilih Jenis Atasan Pejabat :&nbsp&nbsp
                          <input id='jnspp' name="jnsapp" type="radio" value="PNS" onClick="showAPP(this.value)"> PNS&nbsp&nbsp&nbsp
                          <input id='jnspp' name="jnsapp" type="radio" value="NONPNS" onClick="showAPP(this.value)"> Non PNS</td>
                        </tr>
                        <tr>
                        <td colspan='2' align='center'><div id='tampilapp'></div></td>
                        </tr>
                        </table>
                    </div>  
                </div> <!-- akhir konten tab app -->
               
              </div> <!-- akhir konten tab-content -->                

            </td>
          </tr>
        </table>
      </div>
      <div align="right">
	<h4><span class='label label-danger'>4.</span>
          <button type="submit" class="btn btn-success">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
	</h4>
      </div>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
