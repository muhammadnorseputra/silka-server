  <?php
    if ($this->session->flashdata('pesan') <> ''){
      ?>
      <div class="alert alert-dismissible alert-danger">
        <?php echo $this->session->flashdata('pesan');?>
      </div>
      <?php
    }
  ?>

<center>
  <?php
    foreach($peg as $v):
  ?>
  <div class="panel panel-default" style="width: 80%">   

    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/detail'>";          
        echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-road" aria-hidden="true"></span>
        <?php
          echo '<b>CPNS PNS</b><br />';
          echo $this->mpegawai->getnama($v['nip']);
          echo " ::: ".$v['nip']
        ?>
        </div>
        <table class="table table-condensed">
          <tr>
            <td>
              <div class="panel panel-danger">
                <!-- Default panel contents -->
                <div class="panel-heading" align='center'><b>CPNS</b></div>
                <table class="table table-condensed table-hover">
                  <tr>
                    <td width='120' align='right'>Gol. Ruang :</td>
                    <td><?php echo $this->mpegawai->getnamagolru($v['fid_golru_cpns']),'   TMT : ',tgl_indo($v['tmt_cpns']); ?></td>
                  </tr>
                  <tr>
                    <td align='right'>SPMT :</td>
                    <td><?php //echo tgl_indo($v['tgl_spmt']),' No. SK. SPMT : ',$v['no_sk_spmt']; ?></td>
                  </tr>
                  <tr>
                    <td align='right'>Gaji Pokok :</td>
                    <td><?php echo 'Rp. ',indorupiah($v['gapok_cpns']);
                              echo ' <u>(80 % = Rp. ', indorupiah((80*$v['gapok_cpns'])/100),')</u>';
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td align='right'>Jabatan :</td>
                    <td><?php echo $v['jabatan_cpns']; ?></td>
                  </tr>
                  <tr>
                    <td align='right'>Unit Kerja :</td>
                    <td><?php echo $v['unker_cpns']; ?></td>
                  </tr>
                  <tr>
                    <td align='right'>Masa Kerja :</td>
                    <td><?php echo $v['mkthn_cpns'],' Tahun, ', $v['mkbln_cpns'],' Bulan'; ?></td>
                  </tr>
                  <tr>
                    <td rowspan='3' align='right'>Surat Keputusan :</td>
                    <td>Pejabat : <?php echo $v['pejabat_sk_cpns']; ?></td>
                  </tr>
                  <tr>
                    <td>No. SK : <?php echo $v['no_sk_cpns']; ?></td>
                  </tr>
                  <tr>
                    <td>Tgl. SK : <?php echo tgl_indo($v['tgl_sk_cpns']); ?></td>
                  </tr>
                </table>
              </div>
            </td>
            <?php
              // tampilkan <td> unt PNS jika status pegawai PNS
              if ($this->mpegawai->getstatpeg($v['nip']) == 'PNS')
              {
            ?>
            <td>
              <div class="panel panel-success">
                <!-- Default panel contents -->
                <div class="panel-heading" align='center'><b>PNS</b></div>
                <table class="table table-condensed table-hover">
                  <tr>
                    <td width='120' align='right'>Gol. Ruang :</td>
                    <td><?php echo $this->mpegawai->getnamagolru($v['fid_golru_pns']),'   TMT : ',tgl_indo($v['tmt_pns']); ?></td>
                  </tr>                  
                  <tr>
                    <td align='right'>Gaji Pokok :</td>
                    <td><?php echo 'Rp. ',indorupiah($v['gapok_pns']); ?></td>
                  </tr>
                  <tr>
                    <td align='right'>Jabatan :</td>
                    <td><?php echo $v['jabatan_pns']; ?></td>
                  </tr>
                  <tr>
                    <td align='right'>Unit Kerja :</td>
                    <td><?php echo $v['unker_pns']; ?></td>
                  </tr>
                  <tr>
                    <td align='right'>Masa Kerja :</td>
                    <td><?php echo $v['mkthn_pns'],' Tahun, ', $v['mkbln_pns'],' Bulan'; ?></td>
                  </tr>
                  <tr>
                    <td rowspan='3' align='right'>Surat Keputusan :</td>
                    <td>Pejabat : <?php echo $v['pejabat_sk_pns']; ?></td>
                  </tr>
                  <tr>
                    <td>No. SK : <?php echo $v['no_sk_pns']; ?></td>
                  </tr>
                  <tr>
                    <td>Tgl. SK : <?php echo tgl_indo($v['tgl_sk_pns']); ?></td>
                  </tr>
                </table>
              </div>
            </td>
            <?php
              }
            ?>
          </tr>
          <?php
            //cek priviledge session user -- edit_profil_priv
            if ($this->session->userdata('edit_profil_priv') == "Y")
            {
          ?>
              <tr>
              <td colspan='2'>            
                <div class="panel panel-warning">
                    <!-- Default panel contents -->
                    <div class="panel-heading" align='center'><b>Upload File Berkas SK CPNS dan PNS</b></div>
                    <table class='table table-condensed   table-hover'>
                      <tr>                        
                        <td align='center'>
                        <?php
                          $lokasifile='./filecp/';
                          $namafile=$v['berkas'];
                          
                          // awal dengan FTP
                          /*
                          $this->load->library('ftp');

                          $config['hostname'] = '192.168.1.4';
                          $config['username'] = 'silka_ftp';
                          $config['password'] = 'FtpSanggam';
                          $config['debug'] = TRUE;

                          $this->ftp->connect($config);

                          $list = $this->ftp->list_files('/filecp/');
                          $nmfile = '/filecp/'.$namafile.'.pdf';

                          if (in_array($nmfile, $list))
                          {
                            ?>
                            <form action="<?=base_url()?>download/cpnspns" method="post" enctype="multipart/form-data">
                              <input type='hidden' name='file' id='file' value='<?php echo $nmfile; ?>'>
                              <button type="submit" value="upload" class="btn btn-success">
                            <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspDownload</button>
                            </form>
                            <?php
                            echo "<br />Silahkan upload untuk memperbarui file, 
                                  harus dengan format .pdf ukuran maksimal 2 MB !!!";
                          }

                          $this->ftp->close(); 
                          
                          */
                          // akhir FTP



                          if (file_exists($lokasifile.$namafile.'.pdf')) {
                            $namafile=$namafile.'.pdf';
                          } else {
                            $namafile=$namafile.'.PDF';
                          }


                          if (file_exists ($lokasifile.$namafile))
                            echo "<a class='btn btn-info btn-xs' href='../filecp/$namafile' target='_blank' role='button'>
                                  <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                                  Download File Berkas SK CPNS/PNS</a><br />Silahkan upload untuk memperbarui file, 
                                  harus dengan format .pdf ukuran maksimal 2 MB !!!";
                          else
                            echo "<h4><span class='label label-warning'>File berkas SK CPNS/PNS tidak tersedia dalam sistem, silahkan upload !!!</span></h4>";

                        //echo form_open_multipart('upload/insert');                        
                        ?>
                        <!-- Jalankan function insert pada controller upload -->
                        </td>
                        <form action="<?= base_url() ?>upload/insertcpnspns" method="post" enctype="multipart/form-data">
                        <td align='right'>                        
                        <input type="file" name="filecp" size="40" class="btn btn-info" />
                        <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $v['nip']; ?>'>
                        <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                        </td>
                        <td align='left'>
                        <button type="submit" value="upload" class="btn btn-success">
                        <span class="glyphicon glyphicon-upload"></span>&nbspUpload</button>
                        </td>
                        </form>
                      </tr>
                    </table>
                </div>            
              </td>
              </tr>
          <?php
            }
          ?>
          <?php
            // tampilkan tabel prajabatan jika status pegawai PNS
            if ($this->mpegawai->getstatpeg($v['nip']) == 'PNS')
            {
          ?>
              <tr>
              <td colspan='2'>            
                <div class="panel panel-info">
                    <!-- Default panel contents -->
                    <div class="panel-heading" align='center'><b>PRAJABATAN</b></div>
                    <table class='table table-condensed table-hover'>
                      <tr>
                        <td align='right' width='120'>Penyelenggara : </td>
                        <td><?php echo $v['instansi_penyelenggara']; ?></td>
                        <td align='right' width='150'>Tempat Pelaksanaan : </td>
                        <td><?php echo $v['tempat']; ?></td>
                        <td align='right' width='120'>Lama : </td>
                        <td width='130'>
                          <?php
                            if ($v['lama_bulan'] != '0') {
                              echo $v['lama_bulan'], ' Bulan';
                            } else if ($v['lama_hari'] != '0') {
                              echo $v['lama_hari'], ' Hari';
                            } else if ($v['lama_jam'] != '0') {
                              echo $v['lama_jam'], ' Jam';
                            }
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td align='right'>Nomor STTPL : </td>
                        <td><?php echo $v['no_sk']; ?></td>
                        <td align='right'>Pejabat STTPL : </td>
                        <td><?php echo $v['pejabat_sk']; ?></td>
                        <td align='right'>Tanggal STTPL : </td>
                        <td><?php echo tgl_indo($v['tgl_sk']); ?></td>
                      </tr>
                    </table>
                </div>            
              </td>
              </tr>
          <?php
            }
          ?>
          <tr>
            <td colspan='2' align='center'>              
              <div class="panel panel-info">
                <!-- Default panel contents -->
                <div class="panel-heading" align='center'><b>INFORMASI</b></div>
                <table class='table table-condensed table-hover'>
                  <tr>
                    <td align='right' width='150'>Status Kepegawaian :</td>
                    <td width='80'><?php echo $this->mpegawai->getstatpeg($v['nip']); ?></td>
                    <td align='right'>Jenis Pengadaan :</td>
                    <td><?php echo $this->mpegawai->getjnspengadaan($v['fid_jns_pengadaan']); ?></td>
                    <td align='right'>No. Karpeg :</td>
                    <td><?php echo $v['no_karpeg']; ?></td>
                  </tr>
                  <tr>
                    <td colspan='3' align='right'>No. SK Pertek CPNS 2 TH :</td>
                    <td colspan='1' width='170'><?php echo $v['no_sk_pertek_c2th']; ?></td>
                    <td colspan='1' align='right' width='100'>Tgl .SK :</td>
                    <td colspan='3' width='170'><?php //echo $v['tgl_pertek_c2th']; ?></td>
                  </tr>
                  <tr>
                    <td colspan='3' align='right'>No. Surat Ket Dokter :</td>
                    <td colspan='1' ><?php echo $v['no_surat_dokter']; ?></td>
                    <td colspan='1' align='right'>Tgl. Surat :</td>
                    <td colspan='3' ><?php //echo tgl_indo($v['tgl_dokter']); ?></td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>        
      </div>
    </div>
  </div>
  <?php
    endforeach;
  ?>
</center>
