<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      // lihat tabel char code pada javaascript (1 sampai 9 = 48 sampai 57)
       if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
      return true;
  }

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

  function showKep(str1, str2, str3)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatakepedit";
    url=url+"?jnsjab="+str1;
    url=url+"&nip="+str2;
    url=url+"&thn="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedKep;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedKep(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("kepemimpinan").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("kepemimpinan").innerHTML=
      "<center><br/><img src=<?php echo '../photo/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }   

  function showPP(str1, str2, str3)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatappedit";
    url=url+"?jnspp="+str1; 
    url=url+"&nip="+str2;
    url=url+"&thn="+str3;     
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
      "<center><br/><img src=<?php echo '../photo/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  function showAPP(str1, str2, str3)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataappedit";
    url=url+"?jnsapp="+str1;    
    url=url+"&nip="+str2;
    url=url+"&thn="+str3;       
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
      "<center><br/><img src=<?php echo '../photo/loading5.gif'; ?> /><br/>Waiting...</center>";
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

      <form method='POST' name='formtambahskp' action='../crudskp/edit_aksi'>
      <input type='hidden' name='nip' maxlength='18' value='<?php echo $nip;?>'>
      <input type='hidden' name='thn' maxlength='4' value='<?php echo $thn;?>'>

      <div class="panel panel-warning">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-grain" aria-hidden="true"></span>
        <?php
          echo '<b>EDIT DATA PPK</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

        <?php
          foreach($skp as $v):
        ?>

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
                  <div class="panel panel-default">
                    <table class='table table-condensed'>
                        <tr>                          
                          <td align='right' width='200'>Jenis :</td>
                          <td>
                            <select name="jenis" id="jenis" onChange="showKep(this.value, formtambahskp.nip.value, formtambahskp.thn.value)" required />
                            <?php
                                if ($v['jns_skp'] == 'STRUKTURAL') {
                                  echo "<option value='STRUKTURAL' selected>STRUKTURAL</option>";
                                  echo "<option value='FUNGSIONAL UMUM'>FUNGSIONAL UMUM</option>";
                                  echo "<option value='FUNGSIONAL TERTENTU'>FUNGSIONAL TERTENTU</option>";
                                } else if ($v['jns_skp'] == 'FUNGSIONAL UMUM') {
                                  echo "<option value='STRUKTURAL'>STRUKTURAL</option>";
                                  echo "<option value='FUNGSIONAL UMUM' selected>FUNGSIONAL UMUM</option>";
                                  echo "<option value='FUNGSIONAL TERTENTU'>FUNGSIONAL TERTENTU</option>";
                                } else if ($v['jns_skp'] == 'FUNGSIONAL TERTENTU') {
                                  echo "<option value='STRUKTURAL'>STRUKTURAL</option>";
                                  echo "<option value='FUNGSIONAL UMUM'>FUNGSIONAL UMUM</option>";
                                  echo "<option value='FUNGSIONAL TERTENTU' selected>FUNGSIONAL TERTENTU</option>";
                                } 
                              ?>
                            </select>
                          </td>    
                          <td align='right' width='120'>Tahun :</td>
                          <td colspan='3'><input type="text" name="tahun" value='<?php echo $v['tahun']; ?>' size='8' maxlength='4' onkeypress="return hanyaAngka(event)" disabled></td>
                        </tr>
                        <tr>                                                
                          <td align='right' width='200'><b>Nilai SKP :</b></td>
                          <td colspan='5'><input type="text" name="nilaiskp" value='<?php echo $v['nilai_skp']; ?>' size='8' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" Readonly />
                          </td>                          
                        </tr>
                        <tr>
                          <td colspan='4' align='center'><b>Prilaku Kerja</b></td>
                          <td rowspan='4' width='420'></td>
                        </tr>
                        <tr>
                          <td align='right'>Orientasi Pelayanan :</td>
                          <td><input type="text" name="orientasipelayanan" value='<?php echo $v['orientasi_pelayanan']; ?>' size='8' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" Readonly /></td>
                          <td align='right'>Integritas :</td>
                          <td><input type="text" name="integritas" value='<?php echo $v['integritas']; ?>' size='8' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" Readonly />
                          </td>                                             
                        </tr>
                        <tr>
                          <td align='right'>Komitmen :</td>
                          <td><input type="text" name="komitmen" value='<?php echo $v['komitmen']; ?>' size='8' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" Readonly /></td>
                          <td align='right'>Disiplin :</td>
                          <td><input type="text" name="disiplin" value='<?php echo $v['disiplin']; ?>' size='8' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" Readonly /></td>
                        </tr>
                        <tr>
                          <td align='right'>Kerjasama :</td>
                          <td><input type="text" name="kerjasama" value='<?php echo $v['kerjasama']; ?>' size='8' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" Readonly /></td>
                          <td align='right'>Kepemimpinan :</td>
                          <!--<td><input type="text" name="kepemimpinan" size='8' maxlength='5' onkeypress="return hanyaAngka(event)"></td>-->
                          <td>
                          <div id='kepemimpinan'>
                          <?php
                          if ($v['jns_skp'] == 'STRUKTURAL') {
                            echo "<input type='text' name='kepemimpinan' value='$v[kepemimpinan]' size='8' maxlength='5' onkeypress='return hanyaAngkaDesimal(event)' Readonly />";
                          } else {
                            echo "<input type='text' name='kepemimpinan' size='8' maxlength='5' value='0' disabled>";
                            //echo "<td><div id='kepemimpinan'></div></td>";
                          }
                          ?>
                          </div>
                          </td>
                        </tr>
                      </table>      
                  </div>            
                </div> <!-- akhir konten tab SKP -->

                <div class="tab-pane" id="pp">
                  <br />
                    <div class="panel panel-default">
                        <table class='table table-condensed'>
                        <tr>Pilih Jenis Pejabat :&nbsp&nbsp
                        <?php
                          $jnspp = $this->mskp->cek_pp($nip,$thn);
                          if ($jnspp == 'PNS') {
                            echo "<input id='jnspp' name='jnspp' type='radio' value='PNS' onClick='showPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)' checked> PNS&nbsp&nbsp&nbsp";
                            echo "<input id='jnspp' name='jnspp' type='radio' value='NONPNS' onClick='showPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)'> Non PNS</td>
                              ";
                          } else if ($jnspp == 'NONPNS') {
                            echo "<input id='jnspp' name='jnspp' type='radio' value='PNS' onClick='showPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)'> PNS&nbsp&nbsp&nbsp";
                            echo "<input id='jnspp' name='jnspp' type='radio' value='NONPNS' onClick='showPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)' checked> Non PNS</td>
                              ";
                          }
                        ?>

                        <td align='center' colspan='2'>
                        <div id='tampilpp'>
                        <?php
                          $jnspp = $this->mskp->cek_pp($nip, $thn);
                          if ($jnspp == 'PNS') {
                            echo "<table class='table table-condensed'>";
                            echo "<tr>";
                            echo "<td align='right' width='250'>NIP :</td>";
                            echo "<td><input type='text' name='nippp' size='20' maxlength='18' value='$v[nip_pp]' onkeypress='return hanyaAngka(event)'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Nama :</td>";
                            echo "<td><input type='text' name='namapp' size='40' maxlength='40' value='$v[nama_pp]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Pangkat :</td>";
                            echo "<td>";
                            $golru = $this->mpegawai->golru()->result_array();
                            echo "<select name='id_golrupp' id='id_golrupp'>";  
                            foreach($golru as $gl)
                            {
                              if ($v[fid_golru_pp] == $gl[id_golru]) {
                                echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                              } else {
                                echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                              }
                            }
                            
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Jabatan :</td>";
                            echo "<td><input type='text' name='jabatanpp' size='80' maxlength='100' value='$v[jab_pp]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Unit Kerja :</td>";
                            echo "<td><input type='text' name='unorpp' size='80' maxlength='100' value='$v[unor_pp]'></td>";
                            echo "</tr>";
                            echo "</table>";
                          } else if ($jnspp == 'NONPNS') {                            
                            echo "<table class='table table-condensed'>";
                            echo "<tr>";
                            echo "<td align='right' width='250'>Nama :</td>";
                            echo "<td><input type='text' name='namapp' size='40' maxlength='40' value='$v[nama_pp]'></td>";
                            echo "</tr>";            
                            echo "<tr>";
                            echo "<td align='right'>Jabatan :</td>";
                            echo "<td><input type='text' name='jabatanpp' size='70' maxlength='100' value='$v[jab_pp]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Unit Kerja :</td>";
                            echo "<td><input type='text' name='unorpp' size='100' maxlength='100' value='$v[unor_pp]'></td>";
                            echo "</tr>";
                            echo "</table>";
                          }
                        ?>
                        </div>
                        </td>
                        </tr>
                        </table>
                    </div>
                </div> <!-- akhir konten tab pp -->

                <div class="tab-pane" id="app">
                <br />
                    <div class="panel panel-default">
                        <table class='table table-condensed'>
                        <tr>Pilih Atasan Jenis Pejabat :&nbsp&nbsp
                        <?php
                          $jnspp = $this->mskp->cek_app($nip,$thn);
                          if ($jnspp == 'PNS') {
                            echo "<input id='jnsapp' name='jnsapp' type='radio' value='PNS' onClick='showAPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)' checked> PNS&nbsp&nbsp&nbsp";
                            echo "<input id='jnsapp' name='jnsapp' type='radio' value='NONPNS' onClick='showAPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)'> Non PNS</td>
                              ";
                          } else if ($jnspp == 'NONPNS') {
                            echo "<input id='jnsapp' name='jnsapp' type='radio' value='PNS' onClick='showAPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)'> PNS&nbsp&nbsp&nbsp";
                            echo "<input id='jnsapp' name='jnsapp' type='radio' value='NONPNS' onClick='showAPP(this.value, formtambahskp.nip.value, formtambahskp.thn.value)' checked> Non PNS</td>
                              ";
                          }
                        ?>

                        <td align='center' colspan='2'>
                        <div id='tampilapp'>
                        <?php
                          $jnspp = $this->mskp->cek_app($nip, $thn);
                          if ($jnspp == 'PNS') {
                            echo "<table class='table table-condensed'>";
                            echo "<tr>";
                            echo "<td align='right' width='250'>NIP :</td>";
                            echo "<td><input type='text' name='nipapp' size='20' maxlength='18' value='$v[nip_app]' onkeypress='return hanyaAngka(event)'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Nama :</td>";
                            echo "<td><input type='text' name='namaapp' size='40' maxlength='40' value='$v[nama_app]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Pangkat :</td>";
                            echo "<td>";
                            $golru = $this->mpegawai->golru()->result_array();
                            echo "<select name='id_golruapp' id='id_golruapp'>";  
                            foreach($golru as $gl)
                            {
                              if ($v[fid_golru_app] == $gl[id_golru]) {
                                echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                              } else {
                                echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                              }
                            }
                            
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Jabatan :</td>";
                            echo "<td><input type='text' name='jabatanapp' size='80' maxlength='100' value='$v[jab_app]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Unit Kerja :</td>";
                            echo "<td><input type='text' name='unorapp' size='80' maxlength='100' value='$v[unor_app]'></td>";
                            echo "</tr>";
                            echo "</table>";
                          } else if ($jnspp == 'NONPNS') {                            
                            echo "<table class='table table-condensed'>";
                            echo "<tr>";
                            echo "<td align='right' width='250'>Nama :</td>";
                            echo "<td><input type='text' name='namaapp' size='40' maxlength='40' value='$v[nama_app]'></td>";
                            echo "</tr>";            
                            echo "<tr>";
                            echo "<td align='right'>Jabatan :</td>";
                            echo "<td><input type='text' name='jabatanapp' size='70' maxlength='100' value='$v[jab_app]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td align='right'>Unit Kerja :</td>";
                            echo "<td><input type='text' name='unorapp' size='100' maxlength='100' value='$v[unor_app]'></td>";
                            echo "</tr>";
                            echo "</table>";
                          }
                        ?>
                        </div>
                        </td>
                        </tr>
                        </table>
                    </div>
                </div> <!-- akhir konten tab app -->
               
              </div> <!-- akhir konten tab-content -->                

            </td>
          </tr>
        </table>

        <?php
        endforeach;
        ?>

      </div>         
        <p align="right">
          <button type="submit" class="btn btn-warning btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
