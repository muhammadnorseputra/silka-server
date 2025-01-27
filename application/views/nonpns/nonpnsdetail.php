<center>
  <div class="panel panel-default" style="width: 75%;">
    <div class="panel-body">          
      <table class='table table-condensed'>
        <tr> 
          <td align='right'>
          <?php
          if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') != "TAMU")) { 
            echo "<form method='POST' action='../nonpns/editnonpns'>";          
            ?>
            <button type="submit" class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span>&nbspEdit&nbsp
            </button>
            <input type='hidden' name='nik' id='nik' maxlength='20' value='<?php echo $nik; ?>'>
          <?php
            echo "</form>";
          }
          ?>
          </td>  

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
        <b>DETAIL DATA NON PNS</b>
        </div>        
        <?php
          foreach($detail as $v):
        ?>        

        <table class="table table-condensed">
            <tr bgcolor='#F2DEDE'>
              <td align='right' width='160'><b>No. KTP</b></td>
              <td colspan='3'><b><?php echo $v['nik']; ?></b></td>
              <td align='center' rowspan='16' width='200' bgcolor='#D9EDF7'>

              <div class="well well-sm" >
              <?php        
                $lokasifile='./photononpns/';
                $namafile=$v['photo'];

                if ($v['photo'] == '') {
                  echo "<img class='thumbnail' src='../photononpns/nophoto.jpg' width='120' >";
                  echo "<div align='right'>";
                  echo "<h4>File Photo tidak tersedia, silahkan upload !!!</h4>";
                  if ($this->session->userdata('level') != "TAMU") { 
                    echo "Untuk meng-upload file photo, klik tombol \"Pilih File\", pilih file image yang akan di-upload (harus format .jpg dengan ukuran maksimal 100 KB), 
			dan klik tombol <br/>\"Upload File Photo\".";
                    echo "<br /><br/>";
                  }
                  echo "</div>";
                } else {
                  if (file_exists($lokasifile.$namafile)) {
                    echo "<img class='thumbnail' src='../photononpns/$namafile' width='120' height='160' >";
                    if ($this->session->userdata('level') != "TAMU") { 
                      echo "<div align='right'>";
                      echo "1Untuk mengganti file photo, klik tombol \"Pilih File\", pilih file image yang akan di-upload (harus format .jpg dengan ukuran maksimal 100 KB), dan klik tombol <br/>\"Ganti File Photo\".";
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
              <form name='fuploadphoto' action="<?=base_url()?>uploadnonpns/uploadphoto" method="post" enctype="multipart/form-data">
                <input type="file" name="photo" class="btn btn-xs btn-info" />
                <input type='hidden' name='nik' id='nik' maxlength='20' value='<?php echo $v['nik']; ?>'><br/>
                <input type='hidden' name='filelama' id='filelama' maxlength='20' value='<?php echo $v['photo']; ?>'>

                <?php
                if ($v['photo'] == '') {
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

              <div class="well well-sm" >              
                <div align='right'>
                <?php
                  $lokasiberkas='./filenonpns/';
                  $fileberkas=$v['berkas'];

                  if ($v['berkas'] == '') {
                      echo "<h4>File berkas tidak tersedia, silahkan upload !!!</h4>";
                      if ($this->session->userdata('level') != "TAMU") { 
                        echo "<br />Untuk meng-upload file berkas, klik tombol \"Pilih File\", pilih file yang akan di-upload (harus format .pdf dengan ukuran maksimal 2 MB), dan klik tombol \"Upload File Berkas\".";
                        echo "<br /><br/>";
                      }
                  } else {
                    if (file_exists($lokasiberkas.$fileberkas)) {
                      if ($this->session->userdata('level') != "TAMU") { 
                        echo "<a class='btn btn-success btn' href='../filenonpns/$fileberkas' target='_blank' role='button'>
                        <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                        Download file berkas disini</a><br /><br />
                        Untuk mengganti file berkas, klik tombol \"Pilih File\", pilih file yang akan di-upload (harus format .pdf dengan ukuran maksimal 2 MB), dan klik tombol \"Ganti File Berkas\".";
                        echo "<br /><br/>";
                      } else {
                        echo "<a class='btn btn-success btn' role='button' disabled>
                        <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                        File berkas tersedia</a><br /><br />";
                      }
                    } else {
                      if ($this->session->userdata('level') != "TAMU") { 
                        echo "<h4>File berkas tidak tersedia, silahkan upload !!!</h4>";
                        echo "<br />Untuk meng-upload file berkas, klik tombol \"Pilih File\", pilih file yang akan di-upload (harus format .pdf dengan ukuran maksimal 2 MB), dan klik tombol \"Upload File Berkas\".";
                        echo "<br /><br/>";
                      }
                    }
                  }                  
                ?>

                <?php
                if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') != "TAMU")) { 
                ?>
                  <form action="<?=base_url()?>uploadnonpns/uploadberkas" method="post" enctype="multipart/form-data">
                    <input type="file" name="berkas" class="btn btn-xs btn-info" />
                    <input type='hidden' name='nik' id='nik' maxlength='20' value='<?php echo $v['nik']; ?>'><br/>
                    <input type='hidden' name='filelama' id='filelama' maxlength='20' value='<?php echo $v['berkas']; ?>'>
                    <?php
                    if ($v['berkas'] == '') {
                      ?>
                      <button type="submit" value="upload" class="btn btn-xs btn-danger">
                      <span class="glyphicon glyphicon-triangle-top" aria-hidden="false"></span>&nbspUpload File Berkas</button>
                      <?php
                    } else {
                      if (file_exists($lokasiberkas.$fileberkas)) {
                        ?>
                        <button type="submit" value="upload" class="btn btn-xs btn-success">
                        <span class="glyphicon glyphicon-triangle-right" aria-hidden="false"></span>&nbspGanti File Berkas</button>
                        <?php                  
                      } else {
                        ?>
                        <button type="submit" value="upload" class="btn btn-xs btn-danger">
                        <span class="glyphicon glyphicon-triangle-top" aria-hidden="false"></span>&nbspUpload File Berkas</button>
                        <?php
                      }
                    }
                    ?>
                  </form>
                <?php
                }
                ?>
                </div>    
              </div>

              <div class="well well-sm" align='center'>
                <?php
                  echo "<form method='POST' action='../nonpns/rwypendidikan'>";          
                  echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
                ?>
                <button type="submit" class="btn btn-success" style='padding:10px; width:230px;'>
                  <span class="glyphicon glyphicon-education" aria-hidden="true"></span>&nbspRIWAYAT PENDIDIKAN</button>
                <?php
                    echo "</form>";
                ?>
                <br />
                <?php
                  echo "<form method='POST' action='../nonpns/rwypekerjaan'>";          
                  echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
                ?>
                <button type="submit" class="btn btn-info" style='padding:10px; width:230px;'>
                  <span class="glyphicon glyphicon-sort" aria-hidden="true"></span>&nbspRIWAYAT PEKERJAAN</button>
                <?php
                    echo "</form>";
                ?>
              </div>

              </td>
            </tr>
            <tr>
              <td align='right' width='160' bgcolor='#D9EDF7'><b>Nama Lengkap</b></td>
              <td colspan='3'><?php echo $v['nama']; ?></td>              
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Gelar Depan</b></td>
              <td><?php echo $v['gelar_depan']; ?></td>
              <td  align='right' bgcolor='#D9EDF7' width='120'><b>Gelar Belakang</b></td>
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
                <table class="table table-condensed">
                  <tr>
                    <td colspan='4'>
                      <?php echo $this->mpegawai->getkelurahan($v['fid_keldesa']); ?>
                    </td>
                  </tr>
                </table>                            
              </td>
            </tr>
            <tr>
              <td width='150' bgcolor='#D9EDF7' align='right'><b>No. Telepon Rumah</b></td>
              <td><?php echo $v['no_telp_rumah']; ?></td>
              <td bgcolor='#D9EDF7' align='right'><b>No. Hand Phone</b></td>
              <td><?php echo $v['no_hp']; ?></td>
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
                  echo '<br />'.$v['nama_sekolah'];
                  echo '<br />Lulus Tahun : '.$v['tahun_lulus'];

                ?>
              </td>
            </tr>            
            <tr>
              <td align='right' coolspan='3' bgcolor='#D9EDF7'><b>Status Kawin</b></td>
              <td>
                <?php echo $this->mpegawai->getstatkawin($v['fid_status_kawin']); ?>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>No. NPWP</b></td>
              <td>
              <?php echo $v['no_npwp']; ?>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>No. BPJS</b></td>
              <td>
              <?php echo $v['no_bpjs']; ?>
              </td>
            </tr>
            <tr>
              <td align='center' colspan='4' class='warning'><b>TUGAS PEKERJAAN SAAT INI</b></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Unit Kerja</b></td>
              <td colspan='3'><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jabatan</b></td>
              <td>
              <?php echo $this->mnonpns->getjabatan($v['fid_jabnonpns'])."<br />".$v['ket_jabnonpns']; ?>
              </td>
              <td colspan='2'>
              <div id='tampilketjab'></div>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Jenis Tenaga</b></td>
              <td>
              <?php echo $this->mnonpns->getjnsnonpns($v['fid_jenis_nonpns']); ?>
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>Sumber Gaji</b></td>
              <td>
              <?php echo $this->mnonpns->getsumbergaji($v['fid_sumbergaji']); ?>
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#DFF0D8'><b>SK PENGANGKATAN PERTAMA</b>
              </td>
              <td colspan='3' bgcolor='#DFF0D8'>
                <?php        
                    foreach($skawal as $awal):
                ?>
                <table class="table table-condensed">
                  <tr bgcolor='#DFF0D8'>
                    <td width='170' align='right'><b>No. SK :</b></td>
                    <td><?php echo $awal['no_sk']; ?></td>
                    <td width='80' align='right'><b>Tgl. SK :</b></td>
                    <td width='130'><?php echo tgl_indo($awal['tgl_sk']); ?></td>
                  </tr>
                  <tr bgcolor='#DFF0D8'>
                    <td width='120' align='right'><b>Pejabat :</b></td>
                    <td colspan='3'><?php echo $awal['pejabat_sk']; ?></td>
                  </tr>
                  <tr bgcolor='#DFF0D8'>
                    <td align='right'><b>TMT :</b></td>
                    <td colspan='3'><?php echo tgl_indo($awal['tmt_awal']); ?> <b>sampai </b>
                    <?php echo tgl_indo($awal['tmt_akhir']); ?></td>
                  </tr>      
                  <tr bgcolor='#DFF0D8'>
                    <td bgcolor='#DFF0D8' align='right'><b>Gaji pada SK Pertama :</b></td>
                    <td colspan='3'><?php echo 'Rp. '.indorupiah($awal['gaji']).',-'; ?></td>
                  </tr>
                </table>
                <?php
                  endforeach;
                ?>
              </td>
            </tr>
            <tr>              
              <td align='right' bgcolor='#F2DEDE'><b>SK PENGANGKATAN TERAKHIR</b>
              </td>
              <td colspan='3' bgcolor='#F2DEDE'>
                <?php        
                    foreach($skakhir as $akhir):
                ?>
                <table class="table table-condensed">
                  <tr bgcolor='#F2DEDE'>
                    <td width='170' align='right'><b>No. SK :</b></td>
                    <td><?php echo $akhir['no_sk']; ?></td>
                    <td width='80' align='right'><b>Tgl. SK :</b></td>
                    <td width='130'><?php echo tgl_indo($akhir['tgl_sk']); ?></td>
                  </tr>
                  <tr bgcolor='#F2DEDE'>
                    <td width='120' align='right'><b>Pejabat :</b></td>
                    <td colspan='3'><?php echo $akhir['pejabat_sk']; ?></td>
                  </tr>
                  <tr bgcolor='#F2DEDE'>
                    <td align='right'><b>Terhitung Mulai Tanggal :</b></td>
                    <td colspan='3'><?php echo tgl_indo($akhir['tmt_awal']); ?><b> sampai </b>
                    <?php echo tgl_indo($akhir['tmt_akhir']); ?></td>
                  </tr>      
                  <tr bgcolor='#F2DEDE'>
                    <td bgcolor='#F2DEDE' align='right'><b>Gaji pada SK Terakhir :</b></td>
                    <td colspan='3'><?php echo 'Rp. '.indorupiah($akhir['gaji']).',-'; ?></td>
                  </tr>
                </table>
                 <?php
                  endforeach;
                ?>
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
