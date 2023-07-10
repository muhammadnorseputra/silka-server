<center>
  <div class="panel panel-default" style="width: 75%;">
    <div class="panel-body">          
      <table class='table table-condensed'>
        <tr>  
					<td align='right'>
          <?php
          if ($this->session->userdata('level') == "ADMIN") { 
            echo "<form method='POST' action='../pppk/edit'>";          
            ?>
            <button type="submit" class="btn btn-warning btn-sm">
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

	      <div class="well well-sm" align='center'>
                <?php
                  echo "<form method='POST' action='../pppk/rwygaji'>";
                  echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$v[nipppk]'>";
                ?>
                <button type="submit" class="btn btn-success" style='padding:10px; width:230px;'>
                  <span class="glyphicon glyphicon-apple" aria-hidden="true"></span>&nbspRIWAYAT GAJI</button>
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
              <td width='150' bgcolor='#D9EDF7' align='right'><b>No. Telepon Rumah</b></td>
              <td><?php //echo $v['no_telp_rumah']; ?></td>
              <td bgcolor='#D9EDF7' align='right'><b>No. Hand Phone</b></td>
              <td><?php echo $v['no_handphone']; ?></td>
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
              <?php echo tgl_indo($v['tmt_jabft']); ?>
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
