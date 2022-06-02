<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
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

  function showPri2021(str1, str2)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getprilaku2021";
    url=url+"?jnsjab="+str1;
    url=url+"&aturan="+str2;      
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedPri2021;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedPri2021(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("prilaku2021").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("prilaku2021").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

  
  function showHitung(jns, ori, integ, kom, dis, ker, kep, skp)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatahitung";
    url=url+"?jns="+jns;
    url=url+"&ori="+ori;
    url=url+"&integ="+integ;
    url=url+"&kom="+kom;
    url=url+"&dis="+dis;
    url=url+"&ker="+ker;
    url=url+"&kep="+kep;
    url=url+"&skp="+skp;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedHitung;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedHitung(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("hitung").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("hitung").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
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

</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/rwyskp'>";          
        echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formtambahskp2021' action='../crudskp/tambah2021_aksi'>
      <input type='hidden' name='nip' namemaxlength='18' value='<?php echo $nip;?>'>

      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-grain" aria-hidden="true"></span>
        <?php
          echo '<b>TAMBAH DATA SKP 2021</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

        <table class="table table-condensed">
          <tr>
            <td align='center'>
              <ul class="nav nav-tabs">
              <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
              <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
                <li class="active"><a href="#skp" data-toggle="tab">SKP Dan Prilaku Kerja</a></li>
                <li><a href="#pp" data-toggle="tab">Pejabat Penilai</a></li>
                <li><a href="#app" data-toggle="tab">Atasan Pejabat Penilai</a></li>
              </ul>

              <!-- Tab panes, ini content dari tab di atas -->
              <div class="tab-content">
                <div class="tab-pane face in active" id="skp">
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                  <div class="panel panel-danger" style="height: 250px;">
                    <table class='table table-condensed'>
                        <tr>                          
                          <td width='250'>
                            <select class="form-control" name="jenis" id="jenis" onChange="showPri2021(this.value, formtambahskp2021.aturan.value)" required>
                              <option value=''>- Pilih Jenis Jabatan -</option>
                              <option value='STRUKTURAL'>STRUKTURAL</option>
                              <option value='FUNGSIONAL UMUM'>FUNGSIONAL UMUM</option>
                              <option value='FUNGSIONAL TERTENTU'>FUNGSIONAL TERTENTU</option>
                            </select>
			  </td>
			  <td width='250'>
			    <select class="form-control" name="aturan" id="aturan" onChange="showPri2021(formtambahskp2021.jenis.value, this.value)" required>
			      <?php
			      if ($this->mskp->cekskp($nip, '2021') == 0) {
			      ?>	
                              	<option value='PP46' selected>PP 46 / 2011</option>
                              	<option value='PP30' disabled>PP 30 / 2019</option>
			      <?php
			      } else if ($this->mskp->cekskp2021_pp46($nip)) {
			      ?>
				<option value='PP46' disabled>PP 46 / 2011</option>
                              	<option value='PP30' selected>PP 30 / 2019</option>
                              <?php
			      }
			      ?>
                            </select>
			    </div>
			  </td>
                          <td width='100'><input class="form-control" type="text" name="tahun" id="tahun" size="4" value="2021" Readonly></td>
			  <td></td>
                        </tr>
			<tr>
                                <td colspan='4' align='center'><div id='prilaku2021'></div>
                                </td>
                        </tr>
                      </table>      
                  </div>            
                </div> <!-- akhir konten tab SKP -->

                <div class="tab-pane fade" id="pp">
                  <br />
                    <div class="panel panel-default" style="height: 250px;">
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
                  <div class="panel panel-default" style="height: 250px;">
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
      
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
