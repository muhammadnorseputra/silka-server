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
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Loading...</center>";
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
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Loading...</center>";
    }
  }     
</script>
<?php

	$d = $detail[0];

?>
<center>
  <div class="panel panel-default" style="width: 85%;">
    <div class="panel-body">          
      <table class='table table-condensed'>
        <tr>         
          <td align='right' width='50'>
          <?php
          echo "<form method='POST' action='../pppk/tampilunker'>";          
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
      <form method='POST' action='../pppk/edit_aksi'>
      <div class="panel panel-info">        
        <div class='panel-heading' align='left'>
        <b>EDIT DATA PPPK</b>
        </div>        
        
        <table class="table table-condensed">
            <tr bgcolor='#D2DEDE'>
              <td align='right' width='100%'><b>NIP PPPK</b></td>
              <td colspan='3'><input type="text" name="nipppk" value="<?= $d['nipppk'] ?>" size='20' onkeyup='validAngka(this)' maxlength='18' placeholder="Ketik NIP P3K" required />
              <small class="text-muted">** WAJIB DIISI, hanya angka tanpa spasi</small>
              </td>
            </tr>
            <tr>
              <td align='right' width='160' bgcolor='#D9EDF7'><b>Nama Lengkap</b></td>
              <td colspan='3'><input type="text" name="nama" value="<?= $d['nama'] ?>" size='50' maxlength='30' placeholder="Ketik nama lengkap sesuai KTP" required />
              <small class="text-muted">** WAJIB DIISI</small>
              </td>              
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Gelar Depan</b></td>
              <td><input type="text" name="gelar_depan" value="<?= $d['gelar_depan'] ?>" size='10' maxlength='10' />
              </td>
              <td  align='right' bgcolor='#D9EDF7'><b>Gelar Belakang</b></td>
              <td><input type="text" name="gelar_blk" value="<?= $d['gelar_blk'] ?>" size='12' maxlength='10' /></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Tempat Lahir</b>
              </td>
              <td>
                <input type="text" name="tmp_lahir" size='20' value="<?= $d['tmp_lahir'] ?>" maxlength='30' required />
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>Tanggal Lahir</b></td>
              <td>
                <input type="text" class="tanggal" name="tgl_lahir" value="<?= tgl_sql($d['tgl_lahir']) ?>" size='12' required />
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Alamat Lengkap</b><br/>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td colspan='3'>
                <textarea name='alamat' rows='2' cols='100' required><?= $d['alamat'] ?></textarea>
                <table class="table table-condensed">
                  <tr>
                    <td colspan='4'>
                      <select name="fid_keldesa" id="fid_keldesa" onChange="showKecamatan(this.value)" required >
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
                            if ($d['fid_keldesa']==$kel['id_kelurahan']) {
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
            <!--<tr>
              <td width='150' bgcolor='#D9EDF7' align='right'><b>No. Telepon Rumah</b></td>
              <td><input type="text" name="no_telp_rumah" size='15' maxlength='15' /></td>
              <td bgcolor='#D9EDF7' align='right'><b>No. Hand Phone</b></td>
              <td><input type="text" name="no_hape" size='12' maxlength='12' required />
                <small class="text-muted">** WAJIB DIISI</small>
              </td>-->
            </tr>
	    <tr>
              <td align='right' bgcolor='#D9EDF7'><b>No. Handphone</b></td>
              <td colspan='4'>
                <input type="text" name="no_handphone" id="no_handphone" size='20' value="<?= $d['no_handphone'] ?>" maxlength='20' required />
                <small class="text-muted">** WAJIB DIISI, Hanya Angka</small>
              </td>
	    </tr>	
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jenis Kelamin</b></td>
              <td>
                <select name="jns_kelamin" id="jns_kelamin" required>
                <?php
                  if ($d['jns_kelamin']=='PRIA') {
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
              <td>
                <select name="fid_agama" id="fid_agama" required>
                <?php
                echo "<option value='-'>-- Pilih Agama --</option>";
                foreach($agama as $a)
                {          
                  if ($d['fid_agama']==$a['id_agama']) {
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
                echo "<option value='-'>-- Pilih Pendidikan --</option>";
                foreach($tingpen as $tp)
                {              
                  if ($d['fid_tingkat_pendidikan']==$tp['id_tingkat_pendidikan']) {
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
                  $jurpen = $this->mnonpns->jurpen($d['fid_tingkat_pendidikan'])->result_array();
                  ?>
                  <table class="table table-condensed">
                    <tr>
                      <td width='100' bgcolor='#D9EDF7' align='right'><b>Jurusan</b></td>
                      <td>
                        <select name='fid_jurusan_pendidikan' id='fid_jurusan_pendidikan' required>
                        <option value=''>-- Pilih Jurusan --</option>
                        <?php
                        foreach($jurpen as $jp) {              
                          if ($d['fid_jurusan_pendidikan']==$jp['id_jurusan_pendidikan']) {
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
                      <td><input type="text" name="nama_sekolah" size='75' maxlength='100' value='<?php echo $d['nama_sekolah']; ?>' required /></td>
                    </tr>
                    <tr>
                      <td bgcolor='#D9EDF7' align='right'><b>Tahun Lulus</b></td>
                      <td><input type="text" name="tahun_lulus" size='6' maxlength='4' value='<?php echo $d['tahun_lulus']; ?>' required /></td>
                    </tr>
                    <tr><td colspan='2'></td></tr>
                  </table>
                </div>
              </td>
            </tr>   
            <tr>
              <td align='right' width='160' bgcolor='#D9EDF7'><b>No. NPWP</b></td>
              <td colspan='3'><input type="text" name="no_npwp" size="40" value="<?= $d['no_npwp'] ?>" required />
              <small class="text-muted">** WAJIB DIISI</small>
              </td>              
            </tr>         
            <tr>
              <td align='right' coolspan='3' bgcolor='#D9EDF7'><b>Status Kawin</b></td>
              <td>
                <select name="fid_status_kawin" id="fid_status_kawin" required>
                <?php
                echo "<option value='-'>-- Pilih Status Kawin --</option>";
                foreach($statkaw as $sk)
                {              
                  if ($d['fid_status_kawin']==$sk['id_status_kawin']) {
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
              <td align='right' coolspan='3' bgcolor='#D9EDF7'><b>Status PTKP</b></td>
              <td>
                <select name="fid_status_ptkp" id="fid_status_ptkp" required>
                <?php
                echo "<option value='-'>-- Pilih Status PTKP --</option>";
                foreach($ptkp as $p)
                {              
                  if ($d['fid_status_ptkp']==$p['id_status_ptkp']) {
                    echo "<option value='".$p['id_status_ptkp']."' selected>(".$p['status'].") ". $p['keterangan'] ."</option>";
                  } else {
                    echo "<option value='".$p['id_status_ptkp']."'>(".$p['status'].") ". $p['keterangan'] ."</option>";
                  }
                }
                ?>
                </select>
                <small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <!--<tr>
              <td align='right' bgcolor='#D9EDF7'><b>No. NPWP</b></td>
              <td>
              <input type="text" name="no_npwp" size='25' maxlength='20' />
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>No. BPJS</b></td>
              <td>
              <input type="text" name="no_bpjs" size='25' maxlength='20' />
              </td>
            </tr>-->
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Unit Kerja</b></td>
              <td colspan='3'>
              <select name="fid_unit_kerja" id="fid_unit_kerja" required>
                <?php
                echo "<option value='-'>-- Pilih Unit Kerja --</option>";
                foreach($unker as $u)
                {              
                  if ($d['fid_unit_kerja']==$u['id_unit_kerja']) {
                    echo "<option value='".$u['id_unit_kerja']."' selected>".$u['nama_unit_kerja']."</option>";
                  } else {
                    echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
                  }
                }
                ?>
              </select>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jabatan</b></td>
              <td>
              <select name="fid_jabft" id="fid_jabft" required>
                <?php
                echo "<option value='-'>-- Pilih Tugas --</option>";
                foreach($jab as $j)
                {
                	if($d['fid_jabft'] == $j['id_jabft']){
                		echo "<option value='".$j['id_jabft']."' selected>".$j['nama_jabft']."</option>";
                	} else {
                  	echo "<option value='".$j['id_jabft']."'>".$j['nama_jabft']."</option>";
                	}
                }
                ?>
              </select>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>TMT Jabatan</b></td>
              <td>
              	<input type="text" class="tanggal" name="tmt_jabatan" value="<?= tgl_sql($d['tmt_jabatan']) ?>" size='12' maxlength='10' required />
              	<small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Golru</b></td>
              <td>
                <select name="fid_golru_pppk" id="fid_golru_pppk" required >
                <?php
                echo "<option value='-'>-- Pilih Golru --</option>";
                foreach($golrupppk as $u)
                {
                	if($d[fid_golru_pppk] == $u['id_golru']){
                		echo "<option value='".$u['id_golru']."' selected>".$u['nama_golru']."</option>";              
                  } else {
                  	echo "<option value='".$u['id_golru']."'>".$u['nama_golru']."</option>";
                	}
                }
                ?>
              </select>
              <small class="text-muted">** WAJIB DIISI</small>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>TMT Golru</b></td>
              <td>
              	<input type="text" class="tanggal" name="tmt_golru_pppk" value="<?= tgl_sql($d['tmt_golru_pppk']) ?>" size='12' maxlength='10' required />
              	<small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr>
            <tr>
            	<td align='right' bgcolor='#D9EDF7'><b>Masa Kerja</b></td>
            	<td>Tahun: <input type="text" name="maker_tahun" size='5' maxlength='2' value="<?= $d['maker_tahun'] ?>" placeholder="tahun"/> / Bulan: <input type="text" placeholder="bulan" name="maker_bulan" value="<?= $d['maker_bulan'] ?>" size='5' maxlength='2' /> / <b>Gaji Pokok</b> <input type="text" value="<?= $d['gaji_pokok'] ?>" name="gaji_pokok" size='12' maxlength='10' required /></td>
            	<td align='right' bgcolor='#D9EDF7'><b>TMT Kontrak</b></td>
            	<td>
              	<input type="text" class="tanggal" name="tmt_pppk_awal" value="<?= tgl_sql($d['tmt_pppk_awal']) ?>" size='12' required />
		 s/d <input type="text" class="tanggal" name="tmt_pppk_akhir" value="<?= tgl_sql($d['tmt_pppk_akhir']) ?>" size='12' required />
              	<small class="text-muted">** WAJIB DIISI</small>
              </td>
            </tr> 
            
            <tr>
            	<td align='right' bgcolor='#D9EDF7'><b>TPP</b></td>
            	<td>
	            	<select name="tpp" required>
	            		<option value=""> -- Status TPP -- </option>
	            		<?php
	            			if($d['tpp'] == 'YA'){
	            		?>
		            		<option value="YA" selected> BERHAK </option>	
		            		<option value="TIDAK"> TIDAK BERHAK </option>
	            		<?php } else { ?>
	            			<option value="YA"> BERHAK </option>	
		            		<option value="TIDAK" selected> TIDAK BERHAK </option>
		            	<?php } ?>
	            	</select>
            	</td>
            </tr> 
            
            <tr bgcolor='#D9EDF7'>
              <td align='right' width='160'><b>Nomor SK</b></td>
              <td colspan='3'><input type="text" name="nomor_sk" size='50' value="<?= $d['nomor_sk'] ?>" maxlength='30' placeholder="Nomor Sk" required />
              <small class="text-muted">** WAJIB DIISI</small>
              </td>              
            </tr>    
            <tr bgcolor='#D9EDF7'>
              <td align='right' width='160'><b>Pejabat SK</b></td>
              <td colspan='3'><input type="text" name="pejabat_sk" size='50' maxlength='30' value="<?= $d['pejabat_sk'] ?>" placeholder="Pejabat Sk" required />
              <small class="text-muted">** WAJIB DIISI</small>
              </td>              
            </tr>   
            <tr bgcolor='#D9EDF7'>
              <td align='right'><b>Tanggal SK</b></td>
              <td colspan='3'>
              	<input type="text" class="tanggal" name="tgl_sk" size='12'  value="<?= tgl_sql($d['tgl_sk']) ?>" placeholder="Tgl Sk" maxlength='10' required />
              	<small class="text-muted">** WAJIB DIISI</small>
              </td>            
            </tr>         
        </table>
      </div> <!--panel panel-info-->
      <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan Perubahan          </button>
      </p>
    </div> <!--panel-body-->
  </div> <!--panel panel-default-->
</center>
