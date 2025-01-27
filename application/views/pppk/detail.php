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

  function showUpdateJabPeta(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilupdatejabpeta";
    url=url+"?idpeta="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataJabPeta1;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataJabPeta1(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilpeta").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljabpeta1").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

</script>

<center>
  <div class="panel panel-default" style="width: 80%;">
    <div class="panel-body">          
      <table class='table table-condensed'>
        <tr>  
        <td align='right' width='50'>
                <button type="button" class="btn btn-info btn-outline btn-sm" data-toggle="modal" data-target="#personal">
                <b><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> INFO PERSONAL</b><sup class="text-danger">Baru</sup>
                </button>
        </td>
	<td align='right'>
          <?php
          if ($this->session->userdata('level') == "ADMIN") { 
            echo "<form method='POST' action='../pppk/edit'>";          
            ?>
            <button type="submit" class="btn btn-warning btn-outline btn-sm">
            <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span>&nbspEdit&nbsp
            </button>
            <input type='hidden' name='nipppk' id='nipppk' maxlength='20' value='<?php echo $nipppk; ?>'>
          <?php
            echo "</form>";
          }
          ?>
          </td> 
          
          <td align='right' width='50'>
          <?php
          echo "<form method='POST' action='../pppk/tampilunker'>";          
          ?>
          <button type="submit" class="btn btn-danger btn-outline btn-sm">
          <span class="glyphicon glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
          <?php
            echo "</form>";
          ?>
          </td> 
        </tr>
      </table>         

      <?php
      if ($pesan != '') {
        ?>
        <div class="<?php echo $jnspesan; ?>" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
        <?php
      }
      ?>

      <div class="panel panel-info">        
        <div class='panel-heading' align='left'>
        <b>DETAIL DATA PPPK</b>
        </div>        
        <?php
          foreach($detail as $v):
        ?>        

        <table class="table table-condensed">
            <tr bgcolor='#F2DEDE'>
              <td align='right' width='160'><b>NIP PPPK</b></td>
              <td colspan='3'><b><?php echo $v['nipppk']; ?></b></td>
              <td align='center' rowspan='17' width='200' bgcolor='#D9EDF7'>

              <div class="well well-sm" >
              <?php        
                $lokasifile='./photononpns/';
                $namafile=$v['photo'];

                if ($v['photo'] == '') {
                  echo "<img class='thumbnail' src='../photononpns/nophoto.jpg' width='120' >";
                  echo "<div align='right'>";
                  echo "<h4>File Photo tidak tersedia, silahkan upload !!!</h4>";
                  if ($this->session->userdata('level') != "TAMU") { 
                    echo "Untuk meng-upload file photo, klik tombol \"Pilih File\", pilih file image yang akan di-upload (harus format .jpg dengan ukuran maksimal 100 KB), dan klik tombol <br/>\"Upload File Photo\".";
                    echo "<br /><br/>";
                  }
                  echo "</div>";
                } else {
                  if (file_exists($lokasifile.$namafile)) {
                    echo "<img class='thumbnail' src='../photononpns/$namafile' width='120' height='160' >";
                    if ($this->session->userdata('level') != "TAMU") { 
                      echo "<div align='right'>";
                      echo "Untuk mengganti file photo, klik tombol \"Pilih File\", pilih file image yang akan di-upload (harus format .jpg dengan ukuran maksimal 100 KB), dan klik tombol <br/>\"Ganti File Photo\".";
                      echo "<br /><br/>";
                      echo "</div>";
                    }
                  } else {
                    echo "<img class='thumbnail' src='../photononpns/nophoto.jpg' width='120' >";
                    echo "<div align='right'>";
                    echo "<h4>File Photo tidak tersedia, silahkan upload !!!</h4>";
                    if ($this->session->userdata('level') != "TAMU") { 
                      echo "Untuk meng-upload file photo, klik tombol \"Pilih File\", pilih file image yang akan di-upload (harus format .jpg dengan ukuran maksimal 100 KB), dan klik tombol <br/>\"Upload File Photo\".";
                      echo "<br /><br/>";
                    }
                    echo "</div>";
                  }
                }
              ?>
              <?php
              if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') != "TAMU")) { 
              ?>
              <div align='right'>
              <form name='fuploadphoto' action="<?=base_url()?>uploadpppk/uploadphoto" method="post" enctype="multipart/form-data">
                <input type="file" name="photo" class="btn btn-xs btn-info" />
                <input type='hidden' name='nipppk' id='nipppk' maxlength='20' value='<?php echo $v['nipppk']; ?>'><br/>
                <input type='hidden' name='filelama' id='filelama' maxlength='20' value='<?php echo $v['photo']; ?>'>

                <?php
                if ($v['nipppk'] == '') {
                  ?>
                  <button type="submit" value="upload" class="btn btn-xs btn-danger">
                  <span class="glyphicon glyphicon-triangle-top" aria-hidden="false"></span>&nbspUpload File Photo</button>
                  <?php
                } else {
                  if (file_exists($lokasifile.$namafile)) {
                    ?>
                    <button type="submit" value="upload" class="btn btn-xs btn-success">
                    <span class="glyphicon glyphicon-triangle-right" aria-hidden="false"></span>&nbspGanti File Photo</button>
                    <?php                  
                  } else {
                    ?>
                    <button type="submit" value="upload" class="btn btn-xs btn-danger">
                    <span class="glyphicon glyphicon-triangle-top" aria-hidden="false"></span>&nbspUpload File Photo</button>
                    <?php
                  }
                }
                ?>
                
              </form>           
              </div>    
              <?php
              }
              ?>
              </div>
		
	      <?php 
	      //if ($this->session->userdata('nip') == "198104072009041002") {
	      ?>  		
	      <div class="well well-sm" align="center">

		<div class='row' style='margin-top:5px;'>
		 <div class="col-lg-12" align='center'> 
                  <form method="POST" action="../pppk/rwygaji">
                    <input type="hidden" name="nipppk" id="nipppk" maxlength="18" value="<?php echo $v['nipppk']; ?>">
                    <button type="submit" class="btn btn-success btn-outline btn-sm" style='padding:10px; width:100%;'>
                      <span class="glyphicon glyphicon-apple" aria-hidden="true"></span>&nbspPENGHASILAN
		    </button>
                  </form>
		 </div>
		</div>
                <div class='row' style='margin-top:10px;'>
                 <div class="col-lg-12" align='center'>
                  <form method="POST" action="../pppk/rwycuti">
                    <input type="hidden" name="nipppk" id="nipppk" maxlength="18" value="<?php echo $v['nipppk']; ?>">
                    <button type="submit" class="btn btn-success btn-outline btn-sm" style='padding:10px; width:100%;'>
                      <span class="glyphicon glyphicon-plane" aria-hidden="true"></span>&nbspCUTI
                    </button>
                  </form>
		 </div>
                </div>
                <div class='row' style='margin-top:10px;'>
                 <div class="col-lg-12" align='center'>
                  <form method="POST" action="../pppk/rwykgb">
                    <input type="hidden" name="nipppk" id="nipppk" maxlength="18" value="<?php echo $v['nipppk']; ?>">
                    <button type="submit" class="btn btn-success btn-outline btn-sm" style='padding:10px; width:100%;'>
                      <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbspKGB
                    </button>
                  </form>
                 </div>
                </div>
		<div class='row' style='margin-top:10px;'>
                 <div class="col-lg-12" align='center'>
                  <form method="POST" action="../pppk/rwykel">
                    <input type="hidden" name="nipppk" id="nipppk" maxlength="18" value="<?php echo $v['nipppk']; ?>">
                    <button type="submit" class="btn btn-success btn-outline btn-sm" style='padding:10px; width:100%;'>
                      <span class="fa fa-group" aria-hidden="true"></span>&nbspKELUARGA
                    </button>
                  </form>
                 </div>
                </div>
                <div class='row' style='margin-top:10px;'>
                 <div class="col-lg-12" align='center'>
                  <form method="POST" action="../pppk/rwydik">
                    <input type="hidden" name="nipppk" id="nipppk" maxlength="18" value="<?php echo $v['nipppk']; ?>">
                    <button type="submit" class="btn btn-success btn-outline btn-sm" style='padding:10px; width:100%;'>
                      <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbspDIKLAT
                    </button>
                  </form>
                 </div>
                </div>
			
              </div> <!-- End Well -->
	      <?php
	      //}	
	      ?>
              </td>
            </tr>
            <tr>
              <td align='right' width='160' bgcolor='#D9EDF7'><b>Nama Lengkap</b></td>
              <td colspan='3'><?php echo $v['nama']; ?></td>              
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Gelar Depan</b></td>
              <td><?php echo $v['gelar_depan']; ?></td>
              <td  align='right' bgcolor='#D9EDF7' width='160'><b>Gelar Belakang</b></td>
              <td><?php echo $v['gelar_blk']; ?></tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Tempat Lahir</b>
              </td>
              <td><?php echo $v['tmp_lahir']; ?></td>
              <td align='right' bgcolor='#D9EDF7'><b>Tanggal Lahir</b></td>
              <td><?php echo tgl_indo($v['tgl_lahir']); ?></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Alamat Lengkap</b>
              </td>
              <td colspan='3'>
                <?php echo $v['alamat']; ?>
                <?php echo $this->mpegawai->getkelurahan($v['fid_keldesa']); ?>
              </td>
            </tr>
            <tr>
              <td width='150' bgcolor='#D9EDF7' align='right'><b>No. Handphone</b></td>
              <td><?php echo $v['no_handphone']; ?></td>
              <td bgcolor='#D9EDF7' align='right'><b>Email</b></td>
              <td><?php echo $v['email']; ?></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jenis Kelamin</b></td>
              <td><?php echo $v['jns_kelamin']; ?></td>              
              <td align='right' bgcolor='#D9EDF7'><b>Agama</b></td>
              <td width='220'><?php echo $this->mpegawai->getagama($v['fid_agama']); ?></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Pendidikan Terakhir</b></td>
              <td colspan='3'>
                <?php
                  echo $this->mpegawai->gettingpen($v['fid_tingkat_pendidikan']).'-';
                  echo $this->mpegawai->getjurpen($v['fid_jurusan_pendidikan']);
                  echo '<br /><b>'.$v['nama_sekolah'].'</b>';
                  echo '<br />Lulus Tahun : '.$v['tahun_lulus'];

                ?>
              </td>
            </tr>            
            <tr>
              <td align='right' coolspan='3' bgcolor='#D9EDF7'><b>Status Kawin</b></td>
              <td>
                <?php echo $this->mpegawai->getstatkawin($v['fid_status_kawin']); ?>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>Status PTKP</b></td>
              <td width='220'>(<?= $this->mpppk->getstatus_ptkp($v['fid_status_ptkp']) ?>) <?= $this->mpppk->getketerangan_ptkp($v['fid_status_ptkp']) ?></td>
            </tr>
            <tr>
            	<td align='right' bgcolor='#D9EDF7'><b>NIK</b></td>
            	<td>
                <?= !empty($v['no_npwp']) ? $v['nik'] : "-"; ?>
                </td>
		<td align='right' bgcolor='#D9EDF7'><b>No. NPWP</b></td>
                <td>
                <?= !empty($v['no_npwp']) ? $v['no_npwp'] : "-"; ?>
                </td>
            </tr>
            <tr>
              <td align='center' colspan='4' class='warning'><b>KONTRAK PERJANJIAN KERJA</b></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Peta Jabatan</b>
              <?php
                if ($this->session->userdata('level') == "ADMIN") {
              ?>
              <button type="button" class="form-control btn btn-default btn-sm" data-toggle="modal" data-target="#updatejab" >
                 <span class="fa fa-refresh" aria-hidden="true"></span> Mapping Peta Jabatan
                </button>
              <?php
                }
              ?>
	      </td>
              <td colspan='3'>
		<?php 
                $detail_pejab = $this->mpetajab->detailKomponenJabatan($v['fid_peta_jabatan'])->result_array();
                foreach($detail_pejab as $dp) {
                        $nmunker_pj = $this->munker->getnamaunker($dp['fid_unit_kerja']);
                        $nmjab_pj = $this->mpetajab->get_namajab($dp['id']);
                        $jnsjab_pj = $this->mpetajab->get_namajnsjab($dp['fid_jnsjab']);
                        $unor = $this->mpetajab->get_namaunor($dp['fid_atasan']);
                        echo $nmunker_pj;
                        echo "<br/>".$unor;
                        echo "<br/><span class='label label-info'>".$jnsjab_pj."</span> ".$nmjab_pj;
                        echo "<span class='text text-info'> (Kelas : ".$dp['kelas'].")</span>";
		}
		?>
	    </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Unit Kerja</b></td>
              <td colspan='3'><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jabatan</b></td>
              <td>
              <?php echo $v['nama_jabft']; ?>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>TMT Jabatan</b></td>
              <td>
              <?php echo tgl_indo($v['tmt_jabatan']); ?>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Golru</b></td>
              <td>
              <?php echo $v['nama_golru']; ?>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>TMT Golru</b></td>
              <td>
              <?php echo tgl_indo($v['tmt_golru_pppk']); ?>
              </td>
            </tr>
            
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Gaji Pokok</b></td>
              <td>
              <b>Rp. <?php echo indorupiah($v['gaji_pokok']); ?></b>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>TMT PPPK</b></td>
              <td>
              <?php echo tgl_indo($v['tmt_pppk_awal'])." s/d ".tgl_indo($v['tmt_pppk_akhir']); ?>
              </td>
            </tr>
            
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>(TPP)</b><br><small>Tambahan Penghasilan Pegawai</small></td>
              <td>
              	<b><?php echo $v['tpp'] === 'YA' ? '<span class="text-success">BERHAK TPP</span>' : '<span class="text-danger">TIDAK BERHAK</span>'; ?></b>
              </td>
	      <td align='right' bgcolor='#D9EDF7'><b>MASA KONTRAK KERJA</b></td>
              <td>
              <?php echo $v['masakontrak_thn']." TAHUN, ".$v['masakontrak_bln']." BULAN"; ?>
              </td>
            </tr>
            
            <tr>
              <td align='right' bgcolor='#DFF0D8'><b>SK PENGANGKATAN</b>
              </td>
              <td colspan='3' bgcolor='#DFF0D8'>
                
                <table class="table table-condensed">
                  <tr bgcolor='#DFF0D8'>
                    <td width='0' align='right'><b>No. SK :</b></td>
                    <td><?php echo $v['nomor_sk']; ?></td>
                    <td width='80' align='right'><b>Tgl. SK :</b></td>
                    <td width='0'><?php echo tgl_indo($v['tgl_sk']); ?></td>
                  </tr>
                  <tr bgcolor='#DFF0D8'>
                    <td width='120' align='right'><b>Pejabat :</b></td>
                    <td colspan='3'><?php echo $v['pejabat_sk']; ?></td>
                  </tr>
                  <tr bgcolor='#DFF0D8'>
                    <td align='right'><b>TMT :</b></td>
                    <td colspan='3'><?php echo tgl_indo($v['tmt_pppk_awal'])." s/d ".tgl_indo($v['tmt_pppk_akhir']); ?></td>
                  </tr>  
		  <tr bgcolor='#DFF0D8'>
                    <td align='right'><b>SPMT :</b></td>
                    <td colspan='3'><?php echo tgl_indo($v['tmt_spmt']); ?></td>
                  </tr>
                </table>
                
              </td>
            </tr>
            
            <tr>
              <td align='left' colspan='5'>Dientri oleh <?php echo $this->mpegawai->getnama($v['created_by']).' (NIP. '.$v['created_by'].') pada tanggal '.tglwaktu_indo($v['created_at']); ?>
              </td>
            </tr>
            <?php
            if ($v['updated_by'] != '') {
            ?>
              <tr>
                <td align='left' colspan='5'>Diupdate oleh <?php echo $this->mpegawai->getnama($v['updated_by']).' (NIP. '.$v['created_by'].') pada tanggal '.tglwaktu_indo($v['updated_at']); ?>
                </td>
              </tr>                        
            <?php
            }
            ?>
        </table>

        <?php
        endforeach;
        ?>
      </div> <!--panel panel-info-->      
    </div> <!--panel-body-->
  </div> <!--panel panel-default-->
</center>


<!-- Modal Info Personal-->
<div id="personal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="dialog">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <form method="POST" action="../pppk/updateinfopersonal">
        <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>

      <div class="modal-header">
        <h5 class="modal-title">Informasi Personal ::: <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk']); ?></h5>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:100%;border:1px solid white">
        <?php
          foreach($detail as $v):
        ?>
        <div class="panel panel-info">
          <div class="panel-body">
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>NIK</b><br/>
                  <sub><div class='text-danger'>Sesuai NIK pada KTP/KK</div></sub>
                </div>
                <div class="col-md-9 col-xs-10">
                  <input type='text' name='nik' id='nik' maxlength='16' value='<?php echo $v['nik']; ?>' required />
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>NPWP</b>
                </div>
                <div class="col-md-9 col-xs-10">
                  <input type='text' name='npwp' id='npwp' maxlength='20' value='<?php echo $v['no_npwp']; ?>'>
                  <br/><small class='text-info'>Tulis selengkapnya termasuk Titik dan Strip, Contoh : 67.123.456.0-731.000</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>No. Handphone</b>
                </div>
                <div class="col-md-9 col-xs-5">
                  <input type='text' name='handphone' id='handphone' maxlength='20' value='<?php echo $v['no_handphone']; ?>' required />
                  <small class='text-info'>Hanya satu No Handphone Aktif, ditulis lengkap tanpa spasi</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Email</b>
                </div>
                <div class="col-md-9 col-xs-10">
                  <input type='text' name='email' id='email' maxlength='50' value='<?php echo $v['email']; ?>' required />
                  <br/><small class='text-info'>Disarankan sesuai dengan email aktif pada Handphone</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Alamat</b><br/>
                  <sub><div class='text-danger'>Domisili / Tempat Tinggal</div></sub>
                </div>
                <div class="col-md-9 col-xs-6">
                  <input type='text' name='alamat' id='alamat' maxlength='100' size='50' value='<?php echo $v['alamat']; ?>' required />
                  <select name="id_keldesa" id="id_keldesa" required>
                    <?php
                      $kel = $this->mpegawai->kelurahan()->result_array();
                      echo "<option value='' selected>- Pilih Desa / Kelurahan -</option>";
                      foreach($kel as $k):
                        if ($v['fid_keldesa'] == $k['id_kelurahan']) {
                          echo "<option value=".$k['id_kelurahan']." selected>".$k['nama_kelurahan']."</option>";
                        } else {
                          echo "<option value=".$k['id_kelurahan'].">".$k['nama_kelurahan']."</option>";
                        }
                      endforeach;
                    ?>
                  </select>
                  <br/><small class='text-info'>Jika diluar Balangan, tulis alamat lengkap dan Desa/Kelurahan LUAR BALANGAN</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Agama</b><br/>
                  <sub><div class='text-info'>Pilih Agama</div></sub>
                </div>
                <div class="col-md-9 col-xs-6">
                  <select name="id_agama" id="id_agama" required>
                    <?php
		      $agama = $this->mpegawai->ref_agama()->result_array();		
                      echo "<option value='' selected>- Pilih Agama -</option>";
                      foreach($agama as $a):
                        if ($v['fid_agama'] == $a['id_agama']) {
                          echo "<option value=".$a['id_agama']." selected>".$a['nama_agama']."</option>";
                        } else {
                          echo "<option value=".$a['id_agama'].">".$a['nama_agama']."</option>";
                        }
                      endforeach;
                    ?>
                  </select>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Status Kawin</b><br/>
                  <sub><div class='text-info'>Pilih Status Kawin</div></sub>
                </div>
                <div class="col-md-9 col-xs-6">
                  <select name="id_statkaw" id="id_statkaw" required>
                    <?php
                      $statkaw = $this->mpegawai->ref_kawin()->result_array();
                      echo "<option value='' selected>- Pilih Status Kawin -</option>";
                      foreach($statkaw as $sk):
                        if ($v['fid_status_kawin'] == $sk['id_status_kawin']) {
                          echo "<option value=".$sk['id_status_kawin']." selected>".$sk['nama_status_kawin']."</option>";
                        } else {
                          echo "<option value=".$sk['id_status_kawin'].">".$sk['nama_status_kawin']."</option>";
                        }
                      endforeach;
                    ?>
                  </select>
                </div>
              </div>
          </div> <!-- End Panel Body -->
        </div> <!-- End Panel -->
        <?php
          endforeach;
        ?>
      </div> <!-- End Body Modal -->
      <!-- footer modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
          <span class="fa fa-ban" aria-hidden="true"></span> Close</button>
        <button type="submit" class="btn btn-success btn-outline">
          <span class="fa fa-save" aria-hidden="true"></span> Update</button>
      </div> <!-- End footer modal -->
      </form>
    </div> <!-- End Content Modal -->
  </div> <!-- End Dialog Modal -->
</div> <!-- End Modal Info Personal -->

<!-- Modal Update Jabatan -->
        <div id="updatejab" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">UPDATE JABATAN</h4>
              </div>
              <!-- body modal -->
              <div class="modal-body" align="left" style="padding:10px;width:100%;height:100%;">
                <form method='POST' name='formupdatejab' style='padding-top:8px' action='../pppk/update_rwyjabpeta_aksi' enctype='multipart/form-data'>
                    <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $v['nipppk']; ?>'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class="form-group input-group">
                            <?php
				if ($v['fid_jnsjab'] == '2') {
					$jnsjab = "FUNGSIONAL UMUM";
					$jab = $this->mpetajab->jabfu_peta($v['fid_unit_kerja'])->result_array();
                                } else if ($v['fid_jnsjab'] == '3') {
					$jnsjab = "FUNGSIONAL TERTENTU";
					$jab = $this->mpetajab->jabft_peta($v['fid_unit_kerja'])->result_array();
                                }
                            ?>
			    <span class="input-group-addon" style="width:140px;text-align: left;">Pilih Jabatan</span>	
                            <select class="form-control" name="id_peta" id="id_peta" required
                                onChange="showUpdateJabPeta(this.value)" style="font-size: 11px;">
                              <?php
                              echo "<option value='' selected>-- ".$jnsjab."--</option>";
                              foreach($jab as $j)
                              {
				$atasan = $this->mpetajab->get_namaunoratasan($j['id']);
                                if (($v['fid_jnsjab'] == '2') AND ($j['fid_jabfu'] == $v['fid_jabfu'])) {
                                  echo "<option value='".$j['id']."'>".$j['nama_jabfu']." [".$atasan."]</option>";
                                } else if (($v['fid_jnsjab'] == '3') AND ($j['fid_jabft'] == $v['fid_jabft'])) {
                                  echo "<option value='".$j['id']."'>".$j['nama_jabft']." [".$atasan."]</option>";
                                }
                              }
                              ?>
                            </select>
                            </div>
			</div>
		    </div>
		    <div class='row'>
                        <div class='col-md-12'>
				<div id='tampilpeta'></div>  
			</div>
		    </div>
		</form>
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div>
<!-- End Modal Tambah Jabatan -->
