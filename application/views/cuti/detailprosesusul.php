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
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../cuti/detailproses'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>Batal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>PROSES USUL CUTI</b>
        </div>
        <?php
          foreach($cuti as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>                           
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='120'><b>No. Pengantar</b> :</td>
                  <td width='300'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='120'><b>Tgl. Pengantar</b> :</td>
                  <td  colspan='2'><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='6' colspan='2'>
                    <?php
                    $lokasifile = './photo/';
                    $filename = $v['nip'].".jpg";

                    if (file_exists ($lokasifile.$filename)) {
                      $photo = "../photo/".$v['nip'].".jpg";
                    } else {
                      $photo = "../photo/nophoto.jpg";
                    }
                    ?>
                    <center><img class='img-thumbnail' src='<?php echo $photo; ?>' width='120' height='160' alt=''>
			
		    <?php
                    // Tampilkan QR Code
                    $qrcode = "../assets/qrcodecuti/".$v['qrcode'].".png";
                    ?>
                    <img class='img-qrcode' src='<?php echo $qrcode; ?>' width='120' height='120' alt=''>

                  </td>
                </tr>
                <tr>
                  <td align='right'><b>NIP</b> :</td>
                  <td><?php echo $v['nip']; ?></td>
                  <td align='right'><b>Nama</b> :</td>
                  <td colspan='2'><?php echo $this->mpegawai->getnama($v['nip']); ?></td>
                </tr>
                <?php 
                    if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
                    }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
                    }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
                    }
                ?>
                <tr>
                  <td align='right'><b>Jabatan</b> :</td>
                  <td colspan='4'><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br /><u>', $v['nama_unit_kerja'],'</u>'; ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Jenis Cuti</b> :</td>
                  <td><?php echo $v['nama_jenis_cuti']; ?></td>
                  <td align='center' colspan='3'><b>Keterangan</b> : <?php echo $v['ket_jns_cuti']; ?></td>
                </tr>                
                <tr>
                  <td align='right'><b>Tahun</b> :</td>
                  <td><?php echo $v['thn_cuti']; ?>
                  <?php
                  if ($v['tambah_hari_tunda'] != 0) {
                    $jmltotal = $v['jml'] + $v['tambah_hari_tunda'];
                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp<b>Jumlah</b> : ". $jmltotal." (".$v['jml']." ".$v['satuan_jml']." + ".$v['tambah_hari_tunda']." Cuti Tunda)";
                  } else {
                    $jmltotal = $v['jml'];
                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp<b>Jumlah</b> : ". $jmltotal." ".$v['satuan_jml'];
                  }
                  ?>
                  </td>
                  <td align='right'><b>Tanggal Cuti</b> :</td>
                  <td colspan='2'><?php echo tgl_indo($v['tgl_mulai']).' s/d '.tgl_indo($v['tgl_selesai']); ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Alamat</b> :</td>
                  <td colspan='4'><?php echo $v['alamat']; ?></td>                  
                </tr>
                <tr>
                <td align='center' colspan='2'><u><b>Catatan Pejabat Kepegawaian</b></u></td>
                <td align='center' colspan='3'><u><b>Catatan / Pertimbangan Atasan Langsung</b></u></td>
                <td align='center' colspan='4'><u><b>Keputusan Pejabat Yang Berwenang</b></u></td>
                </tr>
                <tr>                  
                  <td colspan='2' align='center'><?php echo $v['catatan_pej_kepeg']; ?></td>
                  <td colspan='3' align='center'><?php echo $v['catatan_atasan']; ?></td>
                  <td colspan='4' align='center'><?php echo $v['keputusan_pej']; ?></td>
                </tr>
                <tr class='info'>
                  <!--<td colspan='3' align='center'><b>Entri Usul : </b><?php //echo $v['tgl_usul'].' | '.$this->mlogin->getnamauser($v['user_usul']); ?></td>
                  <td colspan='4' align='center'><b>Kirim Usul : </b><?php //echo $v['tgl_kirim_usul']; ?></td>-->
                </tr>
                <?php
                $status = $this->mcuti->getstatuscuti($v['fid_status']);
                if (($status == 'BTL') OR ($status == 'TMS')) {
                ?>
                <tr class='danger'>
                  <td align='right'><b>Status : </b></td>
                  <td colspan='6'><?php echo '<b>'.$status.'</b><br/>'.$v['alasan']; ?></td>
                </tr>
                <tr class='danger'>
                  <td align='right'><b>Diproses oleh : </b></td>
                  <td colspan='6'><?php echo $this->mlogin->getnamauser($v['user_proses']).' pada '.$v['tgl_proses']; ?></td>
                </tr>
                <?php
                } else if (($status == 'SETUJU') OR ($status == 'CETAKSK')){
                ?>
                <tr class='success'>
                  <td align='right'><b>Status : </b></td>
                  <td colspan='6'><?php echo '<b>'.$status.'</b><br/>No. SK : '.$v['no_sk'].' -- Tgl. SK : '.tgl_indo($v['tgl_sk']).' -- Pejabat SK : '.$v['pejabat_sk'] ; ?></td>
                </tr>
                <tr class='success'>
                  <td align='right'><b>Diproses oleh : </b></td>
                  <td colspan='6'><?php echo $this->mlogin->getnamauser($v['user_proses']).' pada '.$v['tgl_proses']; ?></td>
                </tr>
                <?php  
                }
                ?>

                <tr>
                  <td colspan='6'>
                    <!-- awal data riwayat -->
                    <ul class="nav nav-tabs">
                      <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
                      <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->


                      <li class="active"><a href="#cuti" data-toggle="tab">Riwayat Cuti</a></li>
                      <li><a href="#skp" data-toggle="tab">Penilaian Prestasi Kerja Tahun <?php echo $v['thn_cuti']-1; ?></a></li>                      
                    </ul>

                    <div class="tab-content">
                      <div class="tab-pane face in active" id="cuti">
                        <br />                  
                        <table class="table table-condensed">
                          <tr>
                            <td align='center'>
                              <div class="panel panel-info" style="height: 215px; width: 100%">
                                <table class='table table-condensed table-hover'>
                                  <tr class='info'>
                                    <th><center>Tahun</center></th>
                                    <th><center>Jenis Cuti</center></th>
                                    <th><center>Lama (+ Tunda)</center></th>
                                    <th>Tgl. Mulai s/d Tgl. Selesai</th>
                                  </tr>
                                  <?php
                                    foreach($rwycuti as $rc):                                                          
                                  ?>
                                  <tr>
                                    <td align='center'><?php echo $rc['thn_cuti']; ?></td>
                                    <td><?php echo $this->mcuti->getnamajeniscuti($rc['fid_jns_cuti']); ?></td>
                                    <td align='center'>
                                    <?php
                                      if ($rc['tambah_hari_tunda'] != 0) {
                                        $jmltotal = $rc['jml'] + $rc['tambah_hari_tunda'];
                                        echo $jmltotal." Hari [".$rc['jml']." + ".$rc['tambah_hari_tunda']." Cuti Tunda]";
                                      } else {
                                        $jmltotal = $rc['jml'];
                                        echo $jmltotal." Hari"." (".$rc['tambah_hari_tunda']." Hari Tunda)";
                                      }
                                    ?>
                                      
                                    </td>
                                    <td align='left'><?php echo tgl_indo($rc['tgl_mulai']).' s/d '.tgl_indo($rc['tgl_selesai']); ?></td>
                                  </tr>
                                  <?php
                                    endforeach;
                                  ?>
                                </table>
                              </div>
                            </td>
                            <td align='center'>
                              <div class="panel panel-info" style="height: 215px; width: 90%">
                                <table class='table table-condensed table-hover'>
                                  <tr class='info'>
                                    <th colspan='2'><center>Cuti Tunda</center></th>
                                  </tr>
                                  <?php
                                    foreach($rwycutitunda as $rc):                    
                                  ?>
                                  <tr>
                                    <td align='center'><?php echo 'Cuti Tahunan '.$rc['thn_cuti'].' tunda ke '.($rc['thn_cuti']+1); ?></td>
                                    <td><?php echo $rc['jml'].' HARI'; ?></td></td>
                                  </tr>
                                  <?php
                                    endforeach;
                                  ?>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="tab-pane" id="skp">
                        <br />
                        <?php
                        foreach($rwyskp as $skp):
                        ?>
                          <div class="panel panel-info">
                          <table class='table table-condensed'>
                            <tr>
                              <td colspan='2' align='right'>Tahun :</td>
                              <td colspan='2'><?php echo $skp['tahun']; ?></td>                          
                              <td align='right'>Jenis :</td>
                              <td><?php echo $skp['jns_skp']; ?></td>
                            </tr>
                            <tr>                                                
                              <td colspan='6'></td>                        
                            </tr>
                            <tr>
                              <td colspan='2' align='right'>Orientasi Pelayanan :</td>
                              <td colspan='2'>
                                <?php
                                  echo $skp['orientasi_pelayanan']; 
                                  echo ' [ '.$this->mpegawai->getnilaiskp($skp['orientasi_pelayanan']).' ]';
                                ?>                          
                              </td>
                              <td></td>
                              <td></td>                        
                            </tr>
                            <tr>
                              <td colspan='2' align='right'>Integritas :</td>
                              <td colspan='2'>
                              <?php
                                echo $skp['integritas'];
                                echo ' [ '.$this->mpegawai->getnilaiskp($skp['integritas']).' ]';
                              ?>                             
                              </td>
                              <td align='right'>Nilai SKP :</td>
                              <td>
                              <?php 
                                echo $skp['nilai_skp'];
                                echo ' [ '.$this->mpegawai->getnilaiskp($skp['nilai_skp']).' ]';
                                echo ' --- 60% = '.round((0.6*$skp['nilai_skp']), 2);
                              ?>                              
                              </td>
                            </tr>
                            <tr>
                              <td colspan='2' align='right'>Komitmen :</td>
                              <td colspan='2'>
                              <?php 
                                  echo $skp['komitmen'];
                                  echo ' [ '.$this->mpegawai->getnilaiskp($skp['komitmen']).' ]';
                              ?>                            
                              </td>
                              <td align='right'>Nilai Prilaku Kerja :</td>
                              <td>
                              <?php
                                echo round($skp['nilai_prilaku_kerja'], 2);
                                echo ' [ '.$this->mpegawai->getnilaiskp(round($skp['nilai_prilaku_kerja']), 2).' ]';
                                echo ' --- 40% = '.round((0.4*$skp['nilai_prilaku_kerja']), 2);
                              ?>                            
                              </td>
                            </tr>
                            <tr>
                              <td colspan='2' align='right'>Disiplin :</td>
                              <td colspan='2'>
                              <?php
                                echo $skp['disiplin'];
                                echo ' [ '.$this->mpegawai->getnilaiskp($skp['disiplin']).' ]';
                              ?>                            
                              </td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan='2' align='right'>Kerjasama :</td>
                              <td colspan='2'>
                              <?php
                                echo $skp['kerjasama'];
                                echo ' [ '.$this->mpegawai->getnilaiskp($skp['kerjasama']).' ]';
                              ?>                            
                              </td>
                              <td align='right'><b>Nilai Prestasi Kerja :</b></td>
                              <td><b>
                              <?php
                                echo round($skp['nilai_prestasi_kerja'], 2);
                                echo ' [ '.$this->mpegawai->getnilaiskp(round($skp['nilai_prestasi_kerja']), 2).' ]';
                              ?>                            
                              </b></td>
                            </tr>
                            <tr>
                              <td colspan='2' align='right'>Kepemimpinan :</td>
                              <td colspan='2'>
                              <?php
                                if ($skp['jns_skp'] == 'STRUKTURAL') {
                                  echo $skp['kepemimpinan'];
                                  echo ' [ '.$this->mpegawai->getnilaiskp($skp['kepemimpinan']).' ]';
                                } else {
                                  echo "-";
                                }
                              ?>                            
                              </td>
                              <td></td>
                              <td align='right'>
                                <!-- memeriksa file skp -->
                                <?php
                                  $lokasifile='./fileskp/';
                                  $namafile=$skp['nip'].'-'.$skp['tahun'].'.pdf';
                                  if (file_exists ($lokasifile.$namafile))
                                    echo "<a class='btn btn-info btn-sm' href='../fileskp/$namafile' target='_blank' role='button'>
                                          <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                                          Download File</a>";
                                  else
                                    echo "<h4><span class='label label-danger'><span class='glyphicon glyphicon-remove'></span>&nbspFile tidak ada</span></h4>";
                                ?>
                              </td>
                            </tr>
                          </table>
                          </div> <!-- end panel -->

                        <?php
                        endforeach;
                        ?>
                      </div>
                    </div>
                    <!-- akhir data riwayat -->
                  </td>
                </tr>
              </table>

            <?php
            if ($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXBKPPD') {
            ?>
              <table class="table table-condensed">
                <tr class='danger'>
                  <td colspan='7' align='center'><b>APPROVAL</b></td>
                </tr>
                <tr class='danger'>
                  <td align='right' rowspan='3'>
                    <form method='POST' action='../cuti/prosesusulbtl'>
                    <textarea id="alasanbtl" name="alasanbtl" rows="3" cols="35" required></textarea>
                  </td>                  
                  <td align='center' rowspan='3'>
                  <?php
                    //echo "<form method='POST' action='../cuti/detailusul'>";
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-warning btn-xs'>";
                    echo "<span class='glyphicon glyphicon-hand-down' aria-hidden='true'></span><br />B T L<br/>(Ke SKPD)";
                    echo "</button>";
                    echo "</form>";
                  ?>
                  </td>
                  <td align='right' rowspan='3'>
                    <form method='POST' action='../cuti/prosesusultms'>
                    <textarea id="alasantms" name="alasantms" rows="3" cols="35" required></textarea>
                  </td>                  
                  <td align='left' rowspan='3'>
                  <?php
                    //echo "<form method='POST' action='../cuti/detailusul'>";          
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-danger btn-xs'>";
                    echo "<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span><br />T M S<br/>(Selesai)";
                    echo "</button>";
                    echo "</form>";
                  ?>
                  </td>
                  <td align='right'>No. SK</td> 
                  <td align='left'>
                    <form method='POST' action='../cuti/prosesusulsetuju'>
                    <input type='text' name='no_sk' id='no_sk' size='23' required></td> 
                  <td align='center' rowspan='2'>
                  <?php
                    //echo "<form method='POST' action='../cuti/detailusul'>";          
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-success btn-xs'>";
                    echo "<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span><br />Setuju<br/>(Cetak SK)";
                    echo "</button>";
                    //echo "</form>";
                  ?>
                  </td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Tgl. SK</td> 
                  <td align='left'><input type='text' name='tgl_sk' id='tgl_sk' class="tanggal" size='12' value='<?php echo date('d-m-Y'); ?>' required></td> 
                </tr>
                <tr class='danger'>
                  <td align='right'>Pejabat SK</td> 
                  <td colspan='2' align='left'><input type='text' name='pejabat_sk' id='pejabat_sk' value='KEPALA BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA' size='35' required></td> 
                  </form>
                </tr>
              </table>
            <?php
            }
            ?>

            </td>            
          </tr>
        </table>
      <?php
        $status = $this->mcuti->getstatuscuti($v['fid_status']);
        endforeach;
      ?>  
      </div>      
      <?php
        if (($status == "SETUJU") OR ($status == "CETAKSK")) {
          echo "<form method='POST' action='../cuti/cetaksk' target='_blank'>";          
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[fid_pengantar]'>";
          echo "<input type='hidden' name='nip' id='nip' size='18' value='$v[nip]'>";
          echo "<input type='hidden' name='thn_cuti' id='thn_cuti' size='5' value='$v[thn_cuti]'>";
          echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' size='10' value='$v[fid_jns_cuti]'>";
      ?>
          <p align="right">
            <button type="submit" class="btn btn-primary btn-sm">&nbsp
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbspCetak SK&nbsp&nbsp&nbsp
            </button>
          </p>
      <?php
        echo "</form>";
        }
      ?>
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
