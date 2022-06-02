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
    if(!/^[0-9]+$/.test(a.value))
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

  function showKecamatan(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showkecamatan";
    url=url+"?idkel="+str1;   
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedKecamatan;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedKecamatan(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkecamatan").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkecamatan").innerHTML=
      "<center><br/><img src=<?php echo '../photo/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }
 
  
  function showJurPen(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showjurpen";
    url=url+"?idtp="+str1;   
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedJurpen;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedJurpen(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampiljurpen").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljurpen").innerHTML=
      "<center><br/><img src=<?php echo '../photo/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }   
  
</script>

<center>
  <div class="panel panel-default" style="width: 65%;">
    <div class="panel-body">          
      <table class='table table-condensed'>
        <tr>         
          <td align='right' width='50'>
          <?php
          echo "<form method='POST' action='../nonpns/tampilunker'>";          
          //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-danger btn-sm">
          <span class="glyphicon glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
          <?php
            echo "</form>";
          ?>
          </td>  
        </tr>
      </table>    
      <form method='POST' name='formedit' action='../nonpns/edit_aksi'>
      <!--<input type='hidden' name='nip' id='nip' maxlength='18' value='<?php //echo $v['nip']; ?>'>-->

      <div class="panel panel-info">        
        <div class='panel-heading' align='left'>
        <b>EDIT DATA NON PNS</b>
        </div>        
        <?php
          foreach($nonpns as $v):
        ?>
        <table class="table table-condensed">
            <tr bgcolor='#F2DEDE'>
              <td align='right' width='160'><b>No. KTP</b></td>
              <td colspan='3'><b><?php echo $v['nik']; ?></b>
              <input type='hidden' name='nik' id='nik' maxlength='20' value='<?php echo $v['nik']; ?>'><br/>
              </td>
              <!--
              <td align='center' rowspan='13' width='200' bgcolor='#D9EDF7'>              
              <div class="well well-sm" >
                <img src='../photo/<?php //echo $v['nip']; ?>.jpg' width='120' height='160' alt='<?php //echo $v['nip']; ?>.jpg'>
                
              </div>
              </td>
              -->
            </tr>
            <tr>
              <td align='right' width='160' bgcolor='#D9EDF7'><b>Nama Lengkap</b></td>
              <td colspan='3'><input type="text" name="nama" size='50' maxlength='30' value='<?php echo $v['nama']; ?>' placeholder="Ketik nama lengkap sesuai KTP" required />
              <small class="text-muted">** WAJIB DIISI</small>
              </td>              
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Gelar Depan</b></td>
              <td><input type="text" name="gelar_depan" size='10' value='<?php echo $v['gelar_depan']; ?>' maxlength='10' />
              </td>
              <td  align='right' bgcolor='#D9EDF7' width='120'><b>Gelar Belakang</b></td>
              <td><input type="text" name="gelar_blk" size='12' value='<?php echo $v['gelar_blk']; ?>' maxlength='10' /></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Tempat Lahir</b>
              </td>
              <td>
                <input type="text" name="tmp_lahir" size='20' maxlength='30' value='<?php echo $v['tmp_lahir']; ?>' required />
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>Tanggal Lahir</b></td>
              <td>
                <input type="text" class="tanggal" name="tgl_lahir" size='12' value='<?php echo tgl_sql($v['tgl_lahir']); ?>' maxlength='10' required />
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Alamat Lengkap</b><br/>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td colspan='3'>
                <textarea name='alamat' rows='2' cols='100' required><?php echo $v['alamat']; ?></textarea>
                <table class="table table-condensed">
                  <tr>
                    <td colspan='4'>
                      <select name="idkel" id="idkel" onChange="showKecamatan(this.value)" required >
                        <?php
                        //echo "<option value='-'>-- Pilih Desa / Kelurahan --</option>";
                        if ($kel['nama_kelurahan'] == 'LUAR BALANGAN') {
                          echo "<option value='6300010001' selected>LUAR BALANGAN</option>";
                        } else {
                          echo "<option value='6300010001' selected>LUAR BALANGAN</option>";
                        }
                        foreach($keldes as $kel)
                        { 
                          if ($kel['nama_kelurahan'] != 'LUAR BALANGAN') {
                              //echo "<option value='".$kel['id_kelurahan']."'>".$kel['nama_kelurahan']."</option>";  
                                  
                            if ($v['fid_keldesa']==$kel['id_kelurahan']) {
                              echo "<option value='".$kel['id_kelurahan']."' selected>".$kel['nama_kelurahan']."</option>";
                            } else {
                              echo "<option value='".$kel['id_kelurahan']."'>".$kel['nama_kelurahan']."</option>";
                            }
                          }                                                    
                        }
                        ?>
                      </select>
                      <small class="text-muted">** WAJIB DIISI<br/>Pilih "LUAR BALANGAN", jika alamat pada KTP berada diluar Kabupaten Balangan</small>
                    </td>
                  </tr>
                  <tr>
                    <td colspan='4'>
                      <div id='tampilkecamatan'></div>  
                    </td>
                  </tr>
                  <tr><td colspan='4'></td></tr>
                </table>                            
              </td>
            </tr>
            <tr>
              <td width='150' bgcolor='#D9EDF7' align='right'><b>No. Telepon Rumah</b></td>
              <td><input type="text" name="no_telp_rumah" size='15' value='<?php echo $v['no_telp_rumah']; ?>' maxlength='15' /></td>
              <td bgcolor='#D9EDF7' align='right'><b>No. Hand Phone</b></td>
              <td><input type="text" name="no_hape" size='12' maxlength='12' value='<?php echo $v['no_hp']; ?>' required />
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jenis Kelamin</b></td>
              <td>
                <select name="jns_kelamin" id="jns_kelamin" required>
                <?php
                  if ($v['jns_kelamin']=='PRIA') {
                    echo "<option value='PRIA' selected>PRIA</option>";
                    echo "<option value='WANITA'>WANITA</option>";
                  } else {
                    echo "<option value='PRIA'>PRIA</option>";
                    echo "<option value='WANITA' selected>WANITA</option>";
                  }
                ?>
              </select>              
              <small class="text-muted">** WAJIB DIISI</small>
              </td>              
              <td align='right' bgcolor='#D9EDF7'><b>Agama</b></td>
              <td width='220'>
                <select name="fid_agama" id="fid_agama" required>
                <?php
                //echo "<option value='-'>-- Pilih Agama --</option>";
                foreach($agama as $a)
                {          
                  if ($v['fid_agama']==$a['id_agama']) {
                    echo "<option value='".$a['id_agama']."' selected>".$a['nama_agama']."</option>";
                  } else {
                    echo "<option value='".$a['id_agama']."'>".$a['nama_agama']."</option>";
                  }    
                }
                ?>
                </select>                
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Pendidikan Terakhir</b><br />
              <small class="text-muted">** WAJIB DIISI</small></td>
              <td colspan='3'>
                <select name="fid_tingkat_pendidikan" id="fid_tingkat_pendidikan" onChange="showJurPen(this.value)" required>
                <?php
                //echo "<option value='-'>-- Pilih Pendidikan --</option>";
                foreach($tingpen as $tp)
                {              
                  if ($v['fid_tingkat_pendidikan']==$tp['id_tingkat_pendidikan']) {
                    echo "<option value='".$tp['id_tingkat_pendidikan']."' selected>".$tp['nama_tingkat_pendidikan']."</option>";
                  } else {
                    echo "<option value='".$tp['id_tingkat_pendidikan']."'>".$tp['nama_tingkat_pendidikan']."</option>";
                  } 
                }
                ?>
                </select>
                <small class="text-muted">Diisi sesuai ijazah terakhir yang "telah" dimiliki, bukan pendidikan yang sedang dilaksanakan saat ini.</small>
                <br/><br/>
                <div id='tampiljurpen'>
                  <?php                  
                  $jurpen = $this->mnonpns->jurpen($v['fid_tingkat_pendidikan'])->result_array();
                  ?>
                  <table class="table table-condensed">
                    <tr>
                      <td width='100' bgcolor='#D9EDF7' align='right'><b>Jurusan</b></td>
                      <td>
                        <select name='fid_jurusan_pendidikan' id='fid_jurusan_pendidikan' required>
                        <option value=''>-- Pilih Jurusan --</option>
                        <?php
                        foreach($jurpen as $jp) {              
                          if ($v['fid_jurusan_pendidikan']==$jp['id_jurusan_pendidikan']) {
                            echo "<option value='".$jp['id_jurusan_pendidikan']."' selected>".$jp['nama_jurusan_pendidikan']."</option>";
                          } else {
                            echo "<option value='".$jp['id_jurusan_pendidikan']."'>".$jp['nama_jurusan_pendidikan']."</option>";
                          } 
                          //echo "<option value='".$jp['id_jurusan_pendidikan']."'>".$jp['nama_jurusan_pendidikan']."</option>";
                        }
                        ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td width='100' bgcolor='#D9EDF7' align='right'><b>Nama Sekolah</b></td>
                      <td><input type="text" name="nama_sekolah" size='75' maxlength='100' value='<?php echo $v['nama_sekolah']; ?>'required /></td>
                    </tr>
                    <tr>
                      <td bgcolor='#D9EDF7' align='right'><b>Tahun Lulus</b></td>
                      <td><input type="text" name="tahun_lulus" size='6' maxlength='4' value='<?php echo $v['tahun_lulus']; ?>' required /></td>
                    </tr>
                    <tr><td colspan='2'></td></tr>
                  </table>
                </div>
              </td>
            </tr>            
            <tr>
              <td align='right' coolspan='3' bgcolor='#D9EDF7'><b>Status Kawin</b></td>
              <td>
                <select name="fid_status_kawin" id="fid_status_kawin" required>
                <?php
                //echo "<option value='-'>-- Pilih Status Kawin --</option>";
                foreach($statkaw as $sk)
                {       
                  if ($v['fid_status_kawin']==$sk['id_status_kawin']) {
                    echo "<option value='".$sk['id_status_kawin']."' selected>".$sk['nama_status_kawin']."</option>";
                  } else {
                    echo "<option value='".$sk['id_status_kawin']."'>".$sk['nama_status_kawin']."</option>";
                  }
                }
                ?>
                </select>
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>No. NPWP</b></td>
              <td>
              <input type="text" name="no_npwp" size='25' maxlength='20' value='<?php echo $v['no_npwp']; ?>' />
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>No. BPJS</b></td>
              <td>
              <input type="text" name="no_bpjs" size='25' maxlength='20' value='<?php echo $v['no_bpjs']; ?>' />
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Unit Kerja</b></td>
              <td colspan='3'>
              <select name="fid_unit_kerja" id="fid_unit_kerja" required>
                <?php
                //echo "<option value='-'>-- Pilih Unit Kerja --</option>";
                foreach($unker as $u)
                {              
                  if ($v['fid_unit_kerja']==$u['id_unit_kerja']) {
                    echo "<option value='".$u['id_unit_kerja']."' selected>".$u['nama_unit_kerja']."</option>";
                  } else {
                    echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
                  }
                  //echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
                }
                ?>
              </select>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Tugas Pekerjaan</b></td>
              <td colspan='2'>
              <select name="fid_jabatan" id="fid_jabatan" required>
                <?php
                //echo "<option value='-'>-- Pilih Tugas --</option>";
                foreach($jab as $j)
                {                   
                    if ($v['fid_jabnonpns']==$j['id_jabnonpns']) {
                      echo "<option value='".$j['id_jabnonpns']."' selected>".$j['nama_jabnonpns']."</option>";
                    } else {
                      echo "<option value='".$j['id_jabnonpns']."'>".$j['nama_jabnonpns']."</option>";
                    }                   
                }
                //echo "<option value='".$idjab."'>".$nmjab."</option>";
                ?>
              </select>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td colspan='2'>
              <div id='tampilketjab'></div>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jenis Non PNS</b></td>
              <td>
                <select name="fid_jenis_nonpns" id="fid_jenis_nonpns" required>
                <?php
                //echo "<option value='-'>-- Pilih Jenis --</option>";
                foreach($jnsnonpns as $jn)
                {
                  if ($v['fid_jenis_nonpns']==$jn['id_jenis_nonpns']) {
                    echo "<option value='".$jn['id_jenis_nonpns']."' selected>".$jn['nama_jenis_nonpns']."</option>";
                  } else {
                    echo "<option value='".$jn['id_jenis_nonpns']."'>".$jn['nama_jenis_nonpns']."</option>";
                  }              
                  //echo "<option value='".$u['id_jenis_nonpns']."'>".$u['nama_jenis_nonpns']."</option>";
                }
                ?>
              </select>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>Sumber Gaji</b></td>
              <td>
                <select name="fid_sumbergaji" id="fid_sumbergaji" required>
                <?php
                //echo "<option value='-'>-- Pilih Jenis --</option>";
                foreach($sumbergaji as $g)
                {
                  if ($v['fid_sumbergaji']==$g['id_sumbergaji']) {
                    echo "<option value='".$g['id_sumbergaji']."' selected>".$g['nama_sumbergaji']."</option>";
                  } else {
                    echo "<option value='".$g['id_sumbergaji']."'>".$g['nama_sumbergaji']."</option>";
                  }              
                  //echo "<option value='".$u['id_jenis_nonpns']."'>".$u['nama_jenis_nonpns']."</option>";
                }
                ?>
              </select>              
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>                 
        </table>
        <?php
        endforeach;
        ?>
      </div> <!--panel panel-info-->
      <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
      </p>
    </div> <!--panel-body-->
  </div> <!--panel panel-default-->
</center>