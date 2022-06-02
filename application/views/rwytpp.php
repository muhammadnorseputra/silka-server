<center>  
  <div class="panel panel-info" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/detail'>";          
        echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </p>
      <?php
        echo "</form>";          
      if ($pesan != '') {
        ?>
        <div class="<?php echo $jnspesan; ?>" alert-info role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
        <?php
      }
      ?> 

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT TAMBAHAN PENGHASILAN PEGAWAI</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

      <table class="table">
        <tr>
          <td align='center'>
            <ul class="nav nav-tabs">
              <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
              <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
              <li class='active'><a href='#tpp' data-toggle='tab'>TPP</a></li>
              <li><a href='#gaji' data-toggle='tab'>GAJI</a></li>
              <li><a href="#kinerja" data-toggle="tab">KINERJA</a></li>              
              <li><a href="#absensi" data-toggle="tab">ABSENSI</a></li>
            </ul>

            <!-- Tab panes, ini content dari tab di atas -->
            <div class="tab-content">
              <div class="tab-pane" id="gaji">
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                <div class="panel panel-info">
                  <div class='panel-heading'><b>GAJI</b></div>
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20' rowspan='2'><center>#</center></th>
                      <th width='150' rowspan='2'><center>PERIODE</center></th>
                      <th width='150' rowspan='2'><center>GAJI POKOK</center></th>
                      <th width='150' rowspan='2'><center>GAJI BRUTO<br/>(Gaji Pokok + Tunjangan Lainnya)</center></th>
                      <th width='150' colspan='4'><center>JUMLAH POTONGAN</center></th>
                      <th width='150' rowspan='2'><center>GAJI NETTO</center></th>
                    </tr>
		    <tr class='info'>
                      <th width='150'><center>PPh 21</center></th>
                      <th width='150'><center>IWP 1%</center></th>
                      <th width='150'><center>Lainnya</center></th>
                      <th width='150'><center>Jumlah</center></th>
		    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwygaji as $g):                    
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td align='left'>
                        <?php
                          echo bulan($g['bulan']).' '.$g['tahun'];
                        ?>
                      </td>
                      <td align='right'><?php echo "Rp. ".number_format($g['gapok'],0,",","."); ?></td>                      
                      <td align='right'><?php echo "Rp. ".number_format($g['gaji_bruto'],0,",","."); ?></td>
                      <td align='right'><?php echo "Rp. ".number_format($g['pajak'],0,",","."); ?></td>
                      <td align='right'><?php echo "Rp. ".number_format($g['iwp_peg'],0,",","."); ?></td>
                      <td align='right'><?php echo "Rp. ".number_format(($g['jml_potongan']-$g['pajak']-$g['iwp_peg']),0,",","."); ?></td>
                      <td align='right'><?php echo "Rp. ".number_format($g['jml_potongan'],0,",","."); ?></td>
                      <td align='right'><?php echo "Rp. ".number_format($g['gaji_netto'],0,",","."); ?></td>                      
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>
                </div>            
              </div> <!-- akhir konten tab Gaji -->
              
              <div class="tab-pane face in active" id="tpp">
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                <div class="panel panel-info">
                  <div class='panel-heading'><b>TAMBAHAN PENGHASILAN PEGAWAI</b></div>
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='150'><center>Periode</center></th>
                      <th width='550'><center>Jabatan</center></th>
                      <th width='150'><center>TPP Basic</center></th>
                      <th width='150'><center>TPP Kinerja</center></th>
                      <th width='150'><center>TPP Absensi</center></th>
                      <th width='150'><center>+ Tambahan<br>- Pengurangan</center></th>
                      <th width='150'><center>Pajak</center></th>
                      <th width='150' class='warning'><center><p class='text-success'><b>TAKE HOME PAY</b></p></center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwytpp as $v):                    
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td>
                        <?php
                          echo bulan($v['bulan']).' '.$v['tahun'];
                          echo "<br/>";
                          if ($v['cuti_sakit'] == "YA") {
                            echo "<code>Cuti Sakit</code>";  
                          }

                          if ($v['cuti_besar'] == "YA") {
                            echo "<code>Cuti Besar</code>";  
                          }

                          if ($v['cpns'] == "YA") {
                            echo "<code>CPNS</code>";  
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          echo "<small>".$v['jabatan']."</small>";
                          echo "<br/><small>".$this->munker->getnamaunker($v['fid_unker'])."</small>";
                          echo "<small><code>Kelas : ".$v['kelas_jab']."</code></small>";
                        ?>
                      </td>
                      <td align='right'><?php echo "Rp. ".number_format($v['tpp_basic'],0,",","."); ?></td>
                      <td align='right'>
                        <?php
                          echo "<small><span class='pull-right text-muted'>Nilai SKP : ".$v['nilai_kinerja']."</span></small>";
                          echo "<br/>Rp. ".number_format($v['tpp_kinerja'],0,",",".");
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                          echo "<small><span class='pull-right text-muted'>Nilai Absensi : ".$v['nilai_absensi']."</span></small>";
                          echo "<br/>Rp. ".number_format($v['tpp_absensi'],0,",",".");
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                          if ($v['bendahara'] == "YA") {
                            echo "<small><code>Bendahara</code></small><br/>"; 
                          }

                          if ($v['terpencil'] == "YA") {
                            echo "<small><code>Terpencil</code></small><br/>"; 
                          }

                          if ($v['pokja'] == "YA") {
                            echo "<small><code>UKPBJ</code></small><br/>"; 
                          }

                          if ($v['tanpajfu'] == "YA") {
                            echo "<small><code>Tanpa JFU</code></small><br/>"; 
                          }

                          if ($v['radiografer'] == "YA") {
                            echo "<small><code>Rediografer</code></small><br/>"; 
                          }

                          if ($v['dokter'] == "YA") {
                            echo "<small><code>Dokter</code></small><br/>"; 
                          }

                          if ($v['inspektorat'] == "YA") {
                            echo "<small><code>Inspektorat</code></small><br/>"; 
                          }

                          if ($v['plt'] == "YA") {
                            echo "<small><code>PLT. Kelas ".$v['plt_kelasjab']."</code></small><br/>"; 
                          }

                          if ($v['sekda'] == "YA") {
                            echo "<small><code>Sekda</code></small><br/>"; 
                          }

                          if ($v['kelas1dan3'] == "YA") {
                            echo "<small><code>Kelas 1/3</code></small>"; 
                          }


                          if ($v['jml_penambahan'] != 0) {
                            echo "<p class='text-primary'><b>+</b> Rp. ".number_format( $v['jml_penambahan'],0,",",".")."</p>";
                          }

                          if ($v['jml_pengurangan'] != 0) {
                            echo "<p class='text-danger'><b>-</b> Rp. ".number_format( $v['jml_pengurangan'],0,",",".")."</p>";
                          }
                          echo "<br/>";
                        ?>
                      </td>
                      <td align='right'><?php echo "Rp. ".number_format( $v['jml_pajak'],0,",","."); ?></td>
                      <td align='right'><p class='text-success'><b><?php echo "Rp. ".number_format( $v['tpp_diterima'],0,",","."); ?></b></p></td>                      
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>
                </div>            
              </div> <!-- akhir konten tab tpp -->

              <div class="tab-pane" id="kinerja">
                <br />
                
                <div class="panel panel-info">
                  <div class="panel-heading"><b>NILAI SKP</b></div>
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='150'><center>Periode</center></th>             
                      <th align='550'><center>Jabatan</center></th>
                      <th width='80'><center>Nilai SKP</center></th>
                      <th width='250'><center>Atasan Langsung</center></th>
                      <th width='250'><center>Diupload Oleh</center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwykin as $v):                    
                      ?>
                      <td align='center'><?php echo $no;?></td>
                      <td>
                        <?php
                          echo bulan($v['bulan']).' '.$v['tahun'];
                        ?>
                      </td>
                      <td>
                        <?php
                          echo "<small>".$v['jabatan']."</small>";
                          echo "<br/><small>".$v['unit_kerja']."</small>";
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                          echo "<code>".$v['nilai_skp']."</code>";
                        ?>
                      </td>
                      <td>
                        <?php
                          echo $v['atasan_langsung'];
                        ?>
                      </td>
                      <td>
                        <?php
                          echo "<small>".$this->mpegawai->getnama($v['import_by']).'<br />'.tglwaktu_indo($v['import_at'])."</small>";
                        ?>
                      </td>
                    <tr>
                      
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>                  
                </div>            
              </div> <!-- akhir konten tab kinerja -->

              <div class="tab-pane" id="absensi">
                <br />
                
                <div class="panel panel-info">
                  <div class="panel-heading"><b>ABSENSI</b></div>
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='150'><center>Periode</center></th>
                      <th width='80'><center>Jumlah HK</center></th>                      
                      <th width='80'><center>Hadir</center></th>
                      <th width='80'><center>Izin</center></th>
                      <th width='80'><center>Sakit</center></th>
                      <th width='80'><center>Terlambat</center></th>
                      <th width='80'><center>Pulang Cepat</center></th>
                      <th width='80'><center>TK</center></th>
                      <th width='80'><center>Cuti</center></th>
                      <th width='80'><center>Tugas Dinas</center></th>
                      <th width='80'><center>Total Pengurang</center></th>
                      <th width='80'><center>Realisasi</center></th>
                      <th width='250'><center>Diupload Oleh</center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwyabs as $v):                    
                      ?>
                      <td align='center'><?php echo $no;?></td>
                      <td>
                        <?php
                          echo bulan($v['bulan']).' '.$v['tahun'];
                        ?>
                      </td>
                      <?php 
                        echo "<td align='right'>".$v['jml_hari']."</td>";
                        echo "<td align='right'>".$v['hadir']."</td>";
                        echo "<td align='right'>".$v['izin']."</td>";
                        echo "<td align='right'>".$v['sakit']."</td>";
                        echo "<td align='right'>".$v['terlambat']."</td>";
                        echo "<td align='right'>".$v['pulang_cepat']."</td>";
                        echo "<td align='right'>".$v['tk']."</td>";
                        echo "<td align='right'>".$v['cuti']."</td>";
                        echo "<td align='right'>".$v['tudin']."</td>";
                        echo "<td align='right'>".$v['total_pengurang']."</td>";
                      ?>
                      <td align='right'>
                        <?php
                          echo "<code>".$v['realisasi']."</code>";
                        ?>
                      </td>
                      <td>
                        <?php
                          echo "<small>".$this->mpegawai->getnama($v['entry_by']).'<br />'.tglwaktu_indo($v['entry_at'])."</small>";
                        ?>
                      </td>
                    <tr>
                      
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>                  
                </div>            
              </div> <!-- akhir konten tab absensi -->

            </div> <!-- akhir konten tab-content -->
          </td>
        </tr>
      </table>
  </div> <!-- akhir panel body-->
</div> <!-- akhir panel -->
</div>
</center>
