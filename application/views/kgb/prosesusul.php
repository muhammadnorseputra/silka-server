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
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }

  //validasi textbox khusus angka dan tanda strip (-)
  function validAngkaStrip(a)
  {
    if(!/^[0-9.-]+$/.test(a.value))
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

  //function showProsesUsul(str1, str2, str3, str4)
  function showProsesUsul(fidgolru, mk_thn, mk_bln, tmt)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showHasilProses";
    url=url+"?fidgolru="+fidgolru;
    url=url+"&mkthn="+mk_thn;
    url=url+"&mkbln="+mk_bln;
    url=url+"&tmt="+tmt;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedProsesUsul;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedProsesUsul(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("hasilproses").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("hasilproses").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/detailproses'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-warning btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formprosesusul' action='../kgb/prosesusulsetuju'>
      <div class="panel panel-success">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>PROSES USUL KGB</b>
        </div>
        <?php
          foreach($kgb as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>                           
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='120'><b>No. Pengantar</b> :</td>
                  <td width='250'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='120'><b>Tgl. Pengantar</b> :</td>
                  <td  colspan='2'><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='8' colspan='2'>
                    <?php
                    $lokasifile = './photo/';
                    $filename = $v['nip'].".jpg";

                    if (file_exists ($lokasifile.$filename)) {
                      $photo = "../photo/".$v['nip'].".jpg";
                    } else {
                      $photo = "../photo/nophoto.jpg";
                    }
                    ?>
                    <center><img class='img-thumbnail' src='<?php echo $photo; ?>' width='120' height='160' alt='$nip.jpg'>
			<br />
			<?php
			// Tampilkan QR Code
			$qrcode = "../assets/qrcodekgb/".$v['qrcode'].".png";
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
                <tr class='success'>
                  <td align='right'><b>Gapok Lama</b> :</td>
                  <td><?php echo 'Rp. '.indorupiah($v['gapok_lama']).',-'; ?></td>
                  <td align='center' colspan='2'>
                  <?php
                    $status = $this->mkgb->getstatuskgb($v['fid_status']);
                    if ($status == 'INBOXBKPPD') {
                      echo "<button type='button' class='btn btn-success btn-sm' onClick='showProsesUsul(formprosesusul.fidgolru.value, formprosesusul.mkthn.value,formprosesusul.mkbln.value,formprosesusul.tmt.value)'>";
                      echo "Hitung KGB&nbsp<span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>";
                      echo "</button>";
                    }
                  ?>
                  </td>
                </tr>                
                <tr class='success'>
                  <td align='right'><b>Masa Kerja</b> :</td>
                  <td>
                    <?php echo $v['mk_thn_lama'].' Tahun, '.$v['mk_bln_lama'].' Bulan'; ?>                    
                    <input type="hidden" size="3" name="mkthn" id="mkthn" value="<?php echo $v['mk_thn_lama']; ?>" />
                    <input type="hidden" size="3" name="mkbln" id="mkbln" value="<?php echo $v['mk_bln_lama']; ?>" />
                  </td>
                  <td rowspan='4' colspan='2'><div id='hasilproses'></div></td>
                </tr>
                <tr class='success'>
                  <td align='right'><b>Berdasarkan<br/>Surat Keputusan</b> :</td>
                  <td><?php echo $v['sk_lama_pejabat'].'<br/>Nomor : '.$v['sk_lama_no'].'<br/>Tanggal :'.tgl_indo($v['sk_lama_tgl']); ?></td>
                </tr>
                <tr class='success'>
                  <td align='right'><b>TMT</b> :</td>
                  <td>
                    <?php echo tgl_indo($v['tmt_gaji_lama']); ?>
                    <input type="hidden" size='10' name="tmt" value="<?php echo $v['tmt_gaji_lama']; ?>" />
                  </td>         
                </tr>
                <tr class='success'>
                  <td align='right'><b>Dalam Golru</b> :</td>
                  <td>
                    <?php echo $this->mpegawai->getnamapangkat($v['fid_golru_lama']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_lama']).')';?>
                    <input type="hidden" size='3' name="fidgolru" value="<?php echo $v['fid_golru_lama']; ?>" />
                  </td>      
                </tr>
                <tr>                
                <td align='center' colspan='5'>
                  <?php
                  if ($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXBKPPD') {
                  ?>
                  <table class="table table-condensed">
                    <tr>
                      <td align='right' class='success'>No. SK :</td> 
                      <td align='left' class='success'>
                        <!--<form method='POST' action='../kgb/prosesusulsetuju'>-->
                        <input type='text' name='no_sk' id='no_sk' size='23' required>
                      </td>
                      <td align='right' class='success'>Tgl. SK :</td> 
                      <td align='left' class='success'><input type='text' name='tgl_sk' id='tgl_sk' class="tanggal" size='12' value='<?php echo date('d-m-Y'); ?>' required></td>  
                      <td align='center' rowspan='3' class='success'>
                      <?php
                        echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                        echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                        echo "<button type='submit' class='btn btn-success btn-xs'>";
                        echo "<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span><br />Setuju<br/>(Cetak SK)";
                        echo "</button>";
                        //echo "</form>";
                      ?>
                      </td>
                   
                    </tr>
                    <tr>
                      <td align='right' class='success'>Pejabat SK :</td> 
                      <td align='left' class='success' colspan='3'>
                        <input type='text' name='pejabat_sk' id='pejabat_sk' value='KEPALA BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA' size='80' required>
                      </td> 
                      </form> <!-- end form formprosesusul -->
                    </tr>
                  </table>
                  <?php
                  }
                  ?>
                </td>
                </tr>
                <tr class='info'>
                  <td align='right'><b>Diusulkan oleh : </b></td>
                  <td colspan='6' align='left'><?php echo $this->mpegawai->getnama($v['user_usul']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_usul']).'<b> diterima pada tanggal </b>'.tglwaktu_indo($v['tgl_kirim_usul']); ?></td>
                </tr>
                <tr><td></td></tr>

                <?php
                $status = $this->mkgb->getstatuskgb($v['fid_status']);
                if (($status == 'BTL') OR ($status == 'TMS')) {
                ?>
                <tr class='danger'>
                  <td align='right'><b>Status : </b></td>
                  <td colspan='6'><?php echo '<b>'.$status.'</b><br/>'.$v['alasan']; ?></td>
                </tr>
                <tr class='danger'>
                  <td align='right'><b>Diproses oleh : </b></td>
                  <td colspan='6'><?php echo $this->mpegawai->getnama($v['user_proses']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_proses']); ?></td>
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
                  <td colspan='6'><?php echo $this->mpegawai->getnama($v['user_proses']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_proses']); ?></td>
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
                      <li class="active"><a href="#kgb" data-toggle="tab">Riwayat KGB</a></li>                      
                      <li><a href="#kp" data-toggle="tab">Riwayat KP</a></li>
                      <li><a href="#skp" data-toggle="tab">SKP <?php echo date('Y')-1; ?></a></li>
                      <li><a href="#cp" data-toggle="tab">CPNS / PNS</a></li>
                      
                    </ul>

                    
                    <div class="tab-content">
                      <!--begin tab content KGB-->
                      <div class="tab-pane face in active" id="kgb">
                        <br/>
                        <div class="panel panel-info">
                          <table class="table table-bordered">
                            <tr>
                              <td colspan='2' align='center'>                            
                                  <table class='table table-condensed table-hover'>
                                    <tr class='warning'>
                                      <th width='20'><center>#</center></th>
                                      <th align='150'><center>Gaji Pokok</center></th>
                                      <th width='150'><center>Dalam Pangkat /<br />Golongan Ruang</center></th>
                                      <th align='50'><center>TMT</center></th>
                                      <th width='200'><center>Masa Kerja</center></th>
                                      <th width='300'><center>Surat Keputusan</center></th>
                                      <th width='80'></th>
                                    </tr>
                                    <?php
                                      $no=1;
                                      foreach($rwykgb as $kgb):                    
                                    ?>
                                    <tr>
                                      <td align='center'><?php echo $no;?></td>
                                      <td align='left'><?php echo 'Rp. ',indorupiah($kgb['gapok']);?></td>
                                      <td><?php echo $this->mpegawai->getnamapangkat($kgb['fid_golru']).'<br />'.$this->mpegawai->getnamagolru($kgb['fid_golru']); ?></td>
                                      <td align='center'><?php echo tgl_indo($kgb['tmt']); ?></td>                    
                                      <?php                    
                                      echo '<td align=center>'.$kgb['mk_thn'].' Tahun '.$kgb['mk_bln'].' Bulan</td>';
                                      ?>
                                      <td width='300'><?php echo $kgb['pejabat_sk'].'<br />Nomor : '.$kgb['no_sk'].'<br />Tanggal : '.tgl_indo($kgb['tgl_sk']); ?></td>
                                      <td align='center'>
                                        <?php
                                          if ($this->mpegawai->gettmtkgbterakhir($v['nip']) == $kgb['tmt']) {
                                            ?>
                                            <tr>
                                            <td></td>
                                            <td colspan='6' align='right'>
                                            <?php
                                            $lokasifile = './filekgb/';
                                            $namafile = $kgb['berkas'];

                                            if (file_exists($lokasifile.$namafile.'.pdf')) {
                                              $namafile=$namafile.'.pdf';
                                            } else if (file_exists($lokasifile.$namafile.'.PDF')) {
                                              $namafile=$namafile.'.PDF';
                                            } else if ($namafile == '') {
                                              $namafile='';
                                            }

                                            if ((file_exists ($lokasifile.$namafile)) AND ($namafile != '')) {
                                              echo "<a class='btn btn-info btn-sm' href='../filekgb/$namafile' target='_blank' role='button'>
                                            <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                                            Download File Berkas SK KGB Terakhir</a>";
                                            } else { 
                                              echo "<h4><span class='label label-warning'>File berkas SK KGB Terakhir tidak tersedia, silahkan upload !!!</span></h4>";
                                            }
                                            ?>
                                            </td>                                            
                                          <?php
                                          }
                                          ?>
                                      </td>
                                    </tr>
                                    <?php
                                      $no++;
                                      endforeach;
                                    ?>
                                  </table>
                              </td>
                            </tr>
                          </table>        
                        </div>
                        <center>
                          <?php
                          if ($namafile != '') {
                          ?>
                          <!--<a class="media" href="assets/ManualCuti.pdf"></a>-->
                          <a class='media' href=<?php echo base_url()."filekgb/$namafile"; ?>></a>
                              <script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
                                  <script type="text/javascript">
                                      $(function () {
                                          $('.media').media({width: 1000; height: 100});
                                      });
                                  </script>
                          <?php
                          }
                          ?>
                        </center>
                      </div>
                      <!-- end tab content KGB -->

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
                                  $namafile=$skp['nip'].'-'.$skp['tahun'];

                                  if (file_exists($lokasifile.$namafile.'.pdf')) {
                                    $namafile=$namafile.'.pdf';
                                  } else {
                                    $namafile=$namafile.'.PDF';
                                  }

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

                        <!-- Tampilkan file SKP -->
                        <center>
                          <a class='media' href=<?php echo base_url()."fileskp/$namafile"; ?>></a>
                              <script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
                                  <script type="text/javascript">
                                      $(function () {
                                          $('.media').media({width: 1000});
                                      });
                                  </script>
                        </center>

                      </div>

                      <!--begin tab content CPNS/PNS-->
                      <div class="tab-pane" id="cp">
                        <br/>
                        <center>
                          <?php
                          foreach($rwycp as $cp):
                            ?>                          
                          <div class="panel panel-info">
                            <table class="table table-condensed">
                              <tr>
                                <td>
                                  <div class="panel panel-warning">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading" align='center'><b>CPNS</b></div>
                                    <table class="table table-condensed table-hover">
                                      <tr>
                                        <td width='120' align='right'>Gol. Ruang :</td>
                                        <td><?php echo $this->mpegawai->getnamagolru($cp['fid_golru_cpns']),'   TMT : ',tgl_indo($cp['tmt_cpns']); ?></td>
                                      </tr>
                                      <tr>
                                        <td align='right'>Gaji Pokok :</td>
                                        <td><?php echo 'Rp. ',indorupiah($cp['gapok_cpns']);
                                        echo ' <u>(80 % = Rp. ', indorupiah((80*$cp['gapok_cpns'])/100),')</u>';
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align='right'>Jabatan :</td>
                                      <td><?php echo $cp['jabatan_cpns']; ?></td>
                                    </tr>
                                    <tr>
                                      <td align='right'>Unit Kerja :</td>
                                      <td><?php echo $cp['unker_cpns']; ?></td>
                                    </tr>
                                    <tr>
                                      <td align='right'>Masa Kerja :</td>
                                      <td><?php echo $cp['mkthn_cpns'],' Tahun, ', $cp['mkbln_cpns'],' Bulan'; ?></td>
                                    </tr>
                                    <tr>
                                      <td rowspan='3' align='right'>Surat Keputusan :</td>
                                      <td>Pejabat : <?php echo $cp['pejabat_sk_cpns']; ?></td>
                                    </tr>
                                    <tr>
                                      <td>No. SK : <?php echo $cp['no_sk_cpns']; ?></td>
                                    </tr>
                                    <tr>
                                      <td>Tgl. SK : <?php echo tgl_indo($cp['tgl_sk_cpns']); ?></td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                              <?php
                                      // tampilkan <td> unt PNS jika status pegawai PNS
                              if ($this->mpegawai->getstatpeg($cp['nip']) == 'PNS')
                              {
                                ?>
                                <td>
                                  <div class="panel panel-success">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading" align='center'><b>PNS</b></div>
                                    <table class="table table-condensed table-hover">
                                      <tr>
                                        <td width='120' align='right'>Gol. Ruang :</td>
                                        <td><?php echo $this->mpegawai->getnamagolru($cp['fid_golru_pns']),'   TMT : ',tgl_indo($cp['tmt_pns']); ?></td>
                                      </tr>                  
                                      <tr>
                                        <td align='right'>Gaji Pokok :</td>
                                        <td><?php echo 'Rp. ',indorupiah($cp['gapok_pns']); ?></td>
                                      </tr>
                                      <tr>
                                        <td align='right'>Jabatan :</td>
                                        <td><?php echo $cp['jabatan_pns']; ?></td>
                                      </tr>
                                      <tr>
                                        <td align='right'>Unit Kerja :</td>
                                        <td><?php echo $cp['unker_pns']; ?></td>
                                      </tr>
                                      <tr>
                                        <td align='right'>Masa Kerja :</td>
                                        <td><?php echo $cp['mkthn_pns'],' Tahun, ', $cp['mkbln_pns'],' Bulan'; ?></td>
                                      </tr>
                                      <tr>
                                        <td rowspan='3' align='right'>Surat Keputusan :</td>
                                        <td>Pejabat : <?php echo $cp['pejabat_sk_pns']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>No. SK : <?php echo $cp['no_sk_pns']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Tgl. SK : <?php echo tgl_indo($cp['tgl_sk_pns']); ?></td>
                                      </tr>
                                    </table>
                                  </div>
                                </td>
                                <?php
                              }
                              ?>
                            </tr>                                  
                            <tr>
                              <td colspan='2' align='right'>            
                                <?php
                                $lokasifile='./filecp/';
                                $namafile=$cp['berkas'];

                                if (file_exists($lokasifile.$namafile.'.pdf')) {
                                  $namafile=$namafile.'.pdf';
                                } else {
                                  $namafile=$namafile.'.PDF';
                                }


                                if (file_exists ($lokasifile.$namafile))
                                  echo "<a class='btn btn-info btn-sm' href='../filecp/$namafile' target='_blank' role='button'>
                                <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                                Download File Berkas SK CPNS/PNS</a>";
                                else
                                  echo "<h4><span class='label label-warning'>File berkas SK CPNS/PNS tidak tersedia dalam sistem</span></h4>";
                                ?>
                              </td>
                            </tr>
                          </table>        
                        </div>
                        <?php
                        endforeach;
                        ?>
                      </center>

                      <!-- Tampilkan file CPNS/PNS -->
                        <center>
                          <a class='media' href=<?php echo base_url()."filecp/$namafile"; ?>></a>
                              <script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
                                  <script type="text/javascript">
                                      $(function () {
                                          $('.media').media({width: 1000});
                                      });
                                  </script>
                        </center>                        
                      </div>
                      <!-- end tab content CPNS/PNS -->

                      <!--begin tab content KP-->
                      <div class="tab-pane" id="kp">
                        <br/>                        
                        <div class="panel panel-info">
                          <table class="table table-bordered">
                            <tr>
                              <td colspan='2' align='center'>
                                <table class='table table-condensed table-hover'>
                                  <tr class='warning'>
                                    <th width='20'><center>#</center></th>
                                    <th width='200'><center>Pangkat / Golru<br />TMT</center></th>
                                    <th width='200'><center>Gaji Pokok</center></th>
                                    <th width='300'><center><u>Dalam Jabatan</u><br /><i>Masa Kerja</i></center></th>
                                    <th width='200'><center>Surat Keputusan</center></th>
                                  </tr>
                                  <?php
                                  $no=1;
                                  foreach($rwykp as $kp):
                                    ?>
                                  <tr>
                                    <td align='center'><?php echo $no;?></td>
                                    <td><?php echo $this->mpegawai->getnamapangkat($kp['fid_golru']).' ('.$this->mpegawai->getnamagolru($kp['fid_golru']).')'; ?>
                                      <?php echo '<br />TMT : '.tgl_indo($kp['tmt']); ?></td>

                                      <td width='150' align ='center'><?php echo "Rp. ".indorupiah($kp['gapok']).",-"; ?></td>
                                      <?php echo '<td><u>'.$kp['dlm_jabatan'].'</u><br />';?><?php
                                      if (($kp['mkgol_thn'] == 0) AND ($kp['mkgol_bln'] == 0) ) {
                                        echo '</td>';
                                      } else {
                                        echo '<i>'.$kp['mkgol_thn'].' Tahun, '.$kp['mkgol_bln'].' Bulan</i></td>';
                                      }
                                      ?>                                      
                                      <td width='300'><?php echo $kp['pejabat_sk'].'<br />Nomor : '.$kp['no_sk'].'<br />Tanggal : '.tgl_indo($kp['tgl_sk']); ?></td>
                                      <?php
                                      if ($this->mpegawai->gettmtkpterakhir($v['nip']) == $kp['tmt']) {
                                        ?>
                                        <tr>
                                          <td></td>
                                          <td colspan='4' align='right'>
                                            <?php
                                            $lokasifile = './filekp/';
                                            $namafile = $kp['berkas'];

                                            if (file_exists($lokasifile.$namafile.'.pdf')) {
                                              $namafile=$namafile.'.pdf';
                                            } else {
                                              $namafile=$namafile.'.PDF';
                                            }

                                            if (file_exists ($lokasifile.$namafile))
                                              echo "<a class='btn btn-info btn-sm' href='../filekp/$namafile' target='_blank' role='button'>
                                            <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                                            Download File Berkas SK KP Terakhir</a>";
                                            else
                                              echo "<h4><span class='label label-warning'>File berkas SK Pangkat Terakhir tidak tersedia</span></h4>";
                                            ?>
                                          </td>                                            
                                          <?php
                                        }
                                        ?>
                                      </tr>
                                      <?php
                                      $no++;
                                      endforeach;
                                      ?>
                                    </table>
                                  </td>
                                </tr>
                              </table>                      
                          </div>                          
                      <!-- end tab content KP -->

                        <!-- Tampilkan file CPNS/PNS -->
                        <center>
                          <a class='media' href=<?php echo base_url()."filekp/$namafile"; ?>></a>
                              <script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
                                  <script type="text/javascript">
                                      $(function () {
                                          $('.media').media({width: 1000});
                                      });
                                  </script>
                        </center>                        

                      </div>
                    </div>
                    <!-- akhir data riwayat -->
                  </td>
                </tr>
              </table>

            <?php
            if ($this->mkgb->getstatuskgb($v['fid_status']) == 'INBOXBKPPD') {
            ?>
              <table class="table table-condensed">
                <tr>                    
                  <form method='POST' name='formbtlusul' action='../kgb/prosesusulbtl'>
                  <td align='right' width='400' rowspan='3' class='warning'>
                    <textarea id="alasanbtl" name="alasanbtl" rows="3" cols="60" required=""></textarea>
                  </td>                  
                  <td align='left' rowspan='3' class='warning'>
                  <?php
                    //echo "<form method='POST' action='../cuti/detailusul'>";
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-warning btn-xs'>";
                    echo "<span class='glyphicon glyphicon-hand-down' aria-hidden='true'></span><br />B T L<br/>(Ke SKPD)";
                    echo "</button>";
                  ?>
                  </td>
                  </form>
                  <form method='POST' name='formtmsusul' action='../kgb/prosesusultms'>
                  <td align='right' width='400' rowspan='3' class='danger'>                    
                    <textarea id="alasantms" name="alasantms" rows="3" cols="60" required></textarea>
                  </td>                  
                  <td align='left' rowspan='3' class='danger'>
                  <?php
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-danger btn-xs'>";
                    echo "<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span><br />T M S<br/>(Selesai)";
                    echo "</button>";
                  ?>
                  </td>
                  </form>
                </tr>
              </table>
            <?php
            }
            ?>
            </td>            
          </tr>
        </table>

      <!-- tuutup form jangan dihapus, untuk menghindari  ketika tombol Cetak SK diklik yang dieksekusi bukan '../kgb/prosesusulsetuju'  pada 'formprosesusul' -->
      </form>

        
      <?php
        endforeach;
      ?>  
      </div>      
      <?php
        if (($status == 'SETUJU') OR ($status == 'CETAKSK')) {
          ?>
          <form method='POST' name='formcetaksk' action='../kgb/cetaksk' target='_blank'>
          <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $v['fid_pengantar']; ?>'>
          <input type='hidden' name='nip' id='nip' size='18' value='<?php echo $v['nip']; ?>'>
          
          <p align="right">
            <button type="submit" class="btn btn-primary btn-sm">&nbsp
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbspCetak SK&nbsp&nbsp&nbsp
            </button>
          </p>
          </form>
      <?php
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
