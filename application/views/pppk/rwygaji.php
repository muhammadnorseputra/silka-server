<?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>

<center>  
  <div class="panel panel-default" style="width: 80%;">
    <div class="panel-body">
      <table class='table table-condensed'>
        <tr> 
          <td align='right' width='50'>
            <?php
              echo "<form method='POST' action='../pppk/detail'>";          
              echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$nipppk'>";
            ?>
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            <?php
              echo "</form>";          
            ?>
          </td>            
        </tr>
      </table> 

      <div id='rwypkj'></div>
    
      <div class="panel panel-default">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-education" aria-hidden="true"></span>
        <?php
          echo '<b>DATA RIWAYAT</b><br />';
          echo $this->mpppk->getnama($nipppk);
          echo " ::: NIPPPK. ".$nipppk
        ?>
        </div>
        <table class="table table-condensed">
          <tr>
            <td align='center'>
		<ul class="nav nav-tabs">
              		<!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
              		<!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
              		<li><a href='#tppng' data-toggle='tab'>TPP 2023</a></li>
              		<li><a href='#gaji' data-toggle='tab'>GAJI</a></li>
              		<li><a href="#kinerja2023" data-toggle="tab">KINERJA 2023</a></li>
                        <li class='active'><a href="#kinerjabkn" data-toggle="tab">KINERJA BKN</a></li>
              		<li><a href="#absensi" data-toggle="tab">ABSENSI</a></li>
            	</ul>

	     <!-- Tab panes, ini content dari tab di atas -->
             <div class="tab-content">
              <div class="tab-pane" id="gaji">
		<div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
		<div class="panel panel-success">
                  <div class='panel-heading'><b>GAJI</b></div>
		  <table class='table table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20' rowspan='2'><center>#</center></th>
                      <th width='120' rowspan='2'><center>PERIODE</center></th>
                      <th width='100' rowspan='2'><center>GAJI POKOK</center></th>
                      <th width='120' rowspan='2'><center>GAJI BRUTO<br/>(Gaji Pokok + Tunjangan Lainnya)</center></th>
                      <th width='50' rowspan='2'><center>JENIS<br/>PTKP</center></th>
                      <th colspan='5'><center>JUMLAH POTONGAN</center></th>
                      <th width='100' rowspan='2'><center>TUNJANGAN<br/>BPJS 4%</center></th>
                      <th width='100' rowspan='2'><center>GAJI NETTO</center></th>
                    </tr>
                    <tr class='info'>
                      <th><center>PPh 21</center></th>
                      <th><center>IWP 1%</center></th>
                      <th><center>BPJS 4%</center></th>
                      <th><center>Lainnya</center></th>
                      <th><center>Jumlah</center></th>
                    </tr>
		    <?php
                    $no=1;
                    foreach($rwygaji as $g):
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
                     <td align='right'><?php echo $g['ptkp']; ?></td>
                     <td align='right'><?php echo "Rp. ".number_format($g['pajak'],0,",","."); ?></td>
                     <td align='right'><?php echo "Rp. ".number_format($g['iwp_peg'],0,",","."); ?></td>
                     <td align='right'><?php echo "Rp. ".number_format($g['bpjs'],0,",","."); ?></td>
                     <td align='right'><?php echo "Rp. ".number_format(($g['jml_potongan']-$g['pajak']-$g['iwp_peg']-$g['bpjs']),0,",","."); ?></td>
                     <td align='right'><?php echo "Rp. ".number_format($g['jml_potongan'],0,",","."); ?></td>
                     <td align='right'><?php echo "Rp. ".number_format($g['bpjs'],0,",","."); ?></td>
                     <td align='right'><?php echo "Rp. ".number_format($g['gaji_netto'],0,",","."); ?></td>
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>	
		</div> <!-- end panel gaji -->
		</div> <!-- End Scroll -->
	      </div> <!-- end tab-pane gaji -->

	      <div class="tab-pane" id="tppng">
		<div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                <div class="panel panel-success">
                  <div class='panel-heading'><b>TPP TAHUN 2023</b></div>
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20' rowspan='2'><center>#</center></th>
                      <th width='150' rowspan='2'><center>Periode</center></th>
                      <th width='550' rowspan='2'><center>Jabatan</center></th>
                      <th width='80' rowspan='2'><center>Produk tifitas</center></th>
                      <th width='80' rowspan='2'><center>Disiplin</center></th>
                      <th align='center' colspan='4'><b>TOTAL KRITERIA</b></td>
                      <th align='center' width='120' rowspan='2'><b>Total Realisasi</b></td>
                      <th align='center' width='120' rowspan='2'><b>PPh21<br/>IWP 1%<br/>BPJS 4%</b></td>
                      <th align='center' width='120' rowspan='2'><b>Take Home Pay</b></td>
                      <th align='center' width='120' rowspan='2'><b>Status</b></td>
                    </tr>
                    <tr class='info'>
                        <td align='center' width='90'><b>Beban Kerja</b></td>
                        <td align='center' width='90'><b>Prestasi Kerja</b></td>
                        <td align='center' width='90'><b>Kondisi Kerja</b></td>
                        <td align='center' width='90'><b>Kelangkaan Profesi</b></td>
                    </tr>

		    <?php
                    $no=1;
                    foreach($pegrwytppng as $v):
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td>
                        <?php
                          echo bulan($v['bulan']).' '.$v['tahun'];
                          if ($v['statuspeg'] == "CPNS") {
                                echo "<br/><span class='label label-success'>CPNS 80%</span>";
                          }

                          if ($v['ket_pengurang'] != "") {
                                echo "<br/><span class='label label-warning'>PENGURANG ".$v['ket_pengurang']."</span>";
                          }
                        ?>
                      </td>
		       <td>
                        <?php
                          echo "<small>".$v['jabatan']."</small>";
                          if ($v['persen_plt'] == '100') {
                                echo "<br/><small>PLT. ".$v['jabatan_plt']."</small>";
                                echo " <span class='label label-info'>PLT 100%</span>";
                          } else if ($v['persen_plt'] == '20') {
                                echo "<br/><small>PLT. ".$v['jabatan_plt']."</small>";
                                echo " <span class='label label-info'>PLT 20%</span>";
                          }

                          $koord = $this->mpetajab->get_koorsubkoord($v['fid_jabpeta']);
                          if ($koord) {
                                echo "<br/><small><u>".$koord."</u></small>";
                          }

                          echo "<br/><small>".$this->munker->getnamaunker($v['fid_unker'])."</small>";
                          echo "<small><code>Kelas : ".$v['kelasjab']."</code></small>";
                        ?>
                      </td>
                      <td align='right'><?php echo $v['nilai_produktifitas']."<br/>".$v['persen_produktifitas']." %"; ?></td>
                      <td align='right'><?php echo $v['nilai_disiplin']."<br/>".$v['persen_disiplin']." %"; ?></td>
                      <td align='right'>
                        <?php
                        echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_bk'],0,",",".");
                        echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_bk'],0,",",".");
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                                echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_pk'],0,",",".");
                                echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_pk'],0,",",".");
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                                echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_kk'],0,",",".");
                                echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_kk'],0,",",".");
                        ?>
                      </td>
		      <td align='right'>
                        <?php
                                echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_kp'],0,",",".");
                        echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_kp'],0,",",".");
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                                $tot_basic = $v['basic_bk'] + $v['basic_pk'] + $v['basic_kk'] + $v['basic_kp'];
                                $tot_real = $v['real_bk'] + $v['real_pk'] + $v['real_kk'] + $v['real_kp'];
                                echo "<span class='label label-success pull-left'>B</span> ".number_format($tot_basic,0,",",".");
                                echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_total'],0,",",".");
                        ?>
                      </td>
		      <td align='right'>
                        <?php
                        if ($v['jns_ptkp']) {
                        echo "<span class='label label-info' align='left'>".$v['jns_ptkp']."</span>";
                        }
                        if ($v['npwp']) {
                                echo " <span class='label label-success' align='left'>NPWP</span>";
                        } else {
                                echo " <span class='label label-danger' align='left'><del>NPWP<del></span>";
                        }
                        echo "<br/>";
                        echo number_format($v['jml_pph'],0,",",".")."<br/>".number_format($v['jml_iwp'],0,",",".")."<br/>".number_format($v['jml_bpjs'],0,",",".");
                        ?>
                      </td>
                      <td align='right'><?php echo number_format($v['tpp_diterima'],0,",","."); ?></td>
                        <?php $status = $this->mtppng->get_statustppng($v['fid_status']); ?>
                      <td align='center'><span class='label label-default'><?php echo $status;?></span></td>
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>
                </div>
		</div><!-- End Scroll -->
              </div> <!-- akhir konten tab tppng --> 	  
			
	      <div class="tab-pane" id="kinerja2023">
		<div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
                <div class="panel panel-success">
                  <div class="panel-heading"><b>NILAI SKP</b></div>
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='120'><center>Periode</center></th>
                      <th align='350'><center>Jabatan</center></th>
                      <!--<th align='120'><center>Nilai Aktifitas<br/><b>(Khusus Nakes)</b></center></th>-->
                      <th width='120'><center>Nilai Kinerja<br/>Jumlah Aktifitas (Nakes)</center></th>
                      <th><center>Atasan Langsung</center></th>
                      <th width='200'><center>Import Oleh</center></th>
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
                          if ($v['jml_aktifitas_nakes'] != 0) {
                              echo "<code>".$v['jml_aktifitas_nakes']."</code> Aktifitas";
                          } else {
                              echo "<code>".$v['nilai_skp']."</code> Point";
                          }
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
		</div> <!-- End Scroll -->
              </div> <!-- akhir konten tab kinerja -->

	      <div class="tab-pane" id="absensi">
		<div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
                <div class="panel panel-success">
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
		</div> <!-- End Scroll -->
              </div> <!-- akhir konten tab absensi -->	
	
              <div class="tab-pane face in active" id="kinerjabkn">
                <div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
                <div class="panel panel-danger">
                  <div class="panel-heading"><b>PENILAIAN KINERJA (Aplikasi Kinerja BKN)</b></div>
                  <table class='table table-condensed table-hover'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='120'><center>PERIODE</center></th>
                      <th width='300'><center>JABATAN SKP</center></th>
                      <th width='200'><center>HASIL PENILAIAN</center></th>
                      <th><center>ATASAN</center></th>
                      <th colspan='2'><center>DOKUMEN</center></th>
                    </tr>
                    <?php
                    $no=1;	
			 // Start Modal Tambah SKP Tahunan
                          if (($this->session->userdata('nip') == '198104072009041002') OR ($this->session->userdata('nip') == "198001252010011011")) { ?>
			    <div class="row" style='margin: 10px;'>
                             <div class="col-md-3" align='left'>
                              <button type='button' class='btn btn-default btn-outline btn-sm' data-toggle='modal' data-target='#insertbulananskp2024<?php echo $nipppk; ?>'>
                              <span style="padding-top:5px;" class='fa fa-plus' aria-hidden='true'></span> TAMBAH DATA BULANAN 2024
                              </button>
                             </div>
			    </div> 	

                          <!-- Modal Tambah Data Bulanan -->
                          <div id="insertbulananskp2024<?php echo $nipppk; ?>" class="modal fade" role="dialog">
                           <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-info'>TAMBAH DATA HASIL KINERJA BULANAN TAHUN 2024</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpppk->getnama($nipppk)."</h5>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                  <form method='POST' name='formaddskp2024' action='../pppk/tambahskpbulanan_aksi'>
                                  <input type='hidden' name='nipppk' id='nipppk' value='<?php echo $nipppk; ?>' >
                                  <div class="row">
                                    <div class="col-md-3">PERIODE BULAN</div>
                                    <div class="col-md-9">
                                        <select name="bln" id="bln" required>
                                        <?php
                                        echo "<option value='0' selected>- Bulan -</option>";
                                        echo "<option value='1'>Januari</option>";
                                        echo "<option value='2'>Februari</option>";
                                        echo "<option value='3'>Maret</option>";
                                        echo "<option value='4'>April</option>";
                                        echo "<option value='5'>Mei</option>";
                                        echo "<option value='6'>Juni</option>";
                                        echo "<option value='7'>Juli</option>";
                                        echo "<option value='8'>Agustus</option>";
                                        echo "<option value='9'>September</option>";
                                        echo "<option value='10'>Oktober</option>";
                                        echo "<option value='11'>November</option>";
                                        echo "<option value='12'>Desember</option>";
                                        ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-3">JABATAN</div>
                                    <div class="col-md-9" align='left'><input type='text' name='jab' size='60' maxlength='150' id='jab' value='' required /></div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-3">UNIT KERJA</div>
                                    <div class="col-md-9" align='left'><input type='text' name='unker' size='60' id='unker' value='' required /></div>
                                  </div>
                                  <br/>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-4">NIP ATASAN PENILAI</div>
                                    <div class="col-md-8" align='left'><input type='text' name='nip_atasan' size='50' id='nip_atasan'' value='' required /></div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-4">NAMA ATASAN PENILAI</div>
                                    <div class="col-md-8" align='left'><input type='text' name='nama_atasan' size='50' id='nama_atasan' value='' required /></div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-4">JABATAN ATASAN PENILAI</div>
                                    <div class="col-md-8" align='left'><input type='text' name='jab_atasan' size='50' id='jab_atasan' value='' required /></div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-4">UNIT KERJA ATASAN PENILAI</div>
                                    <div class="col-md-8" align='left'><input type='text' name='unker_atasan' size='50' id='unker_atasan' value='' required /></div>
                                  </div>
                                  <br/>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-3">HASIL KERJA</div>
                                    <div class="col-md-9">
                                        <select name="hasilkerja" id="hasilkerja" required>
                                        <?php
                                        echo "<option value='' selected>- PILIH -</option>";
                                        echo "<option value='diatas'>DIATAS EKSPEKTASI</option>";
                                        echo "<option value='sesuai'>SESUAI EKSPEKTASI</option>";
                                        echo "<option value='dibawah'>DIBAWAH EKSPEKTASI</option>";
                                        ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-3">PERILAKU KERJA</div>
                                    <div class="col-md-9">
                                        <select name="perilakukerja" id="perilakukerja" required>
                                        <?php
                                        echo "<option value='' selected>- PILIH -</option>";
                                        echo "<option value='diatas'>DIATAS EKSPEKTASI</option>";
                                        echo "<option value='sesuai'>SESUAI EKSPEKTASI</option>";
                                        echo "<option value='dibawah'>DIBAWAH EKSPEKTASI</option>";
                                        ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-3">PREDIKAT KINERJA</div>
                                    <div class="col-md-9">
                                        <select name="predikatkinerja" id="predikatkinerja" required>
                                        <?php
                                        echo "<option value='' selected>- PILIH -</option>";
                                        echo "<option value='sangat baik'>SANGAT BAIK</option>";
                                        echo "<option value='baik'>BAIK</option>";
                                        echo "<option value='butuh perbaikan'>BUTUH PERBAIKAN</option>";
                                        echo "<option value='kurang'>KURANG</option>";
                                        echo "<option value='sangat kurang'>SANGAT KURANG</option>";
                                        ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="row" style='margin-top: 10px;'>
                                    <div class="col-md-12" align='right'>
                                      <button type="submit" value="upload" class="btn btn-sm btn-info btn-outline">
                                        <span class="fa fa-save fa-2x" aria-hidden="false"></span><br/>SIMPAN
                                      </button>
                                    </div>
                                  </div>
                                  </form>
                                </div> <!-- End Modal Body -->
                            </div>
                           </div>
                          </div>
                          <!-- End Modal Tambah Data Bulanan -->
                          <?php }

                        // End Modal Tambah SKP Tahunan
	
                    foreach($pegrwykinbkn as $v):
		     if ($v['bulan'] == 3) {
                        // Cek Dokumen SKP Tahunan di folder /fileskpbulanan
                        if (file_exists('./fileskpbulanan_pppk/'.$v['nip'].'-SKP2024.pdf')) {
                                $ketskp = "UPLOAD ULANG";
                                $jnsfileskp = ".pdf";
                                $btncolorskp = "btn-danger";
                        } else if (file_exists('./fileskpbulanan_pppk/'.$v['nip'].'-SKP2024.PDF')) {
                                $ketskp = "UPLOAD ULANG";
                                $jnsfileskp = ".PDF";
                                $btncolorskp = "btn-danger";
                        } else {
                                $ketskp = " UPLOAD FILE";
                                $btncolorskp = "btn-info";
                        }
                        ?>
                        <div class='row' style="margin:10px;">
                          <div class="col-md-3" align='left'>
                              <button type='button' class='btn <?php echo $btncolorskp; ?> btn-outline btn-sm' data-toggle='modal' data-target='#uploadskp2024<?php echo $v['id']; ?>'>

                              <span style="padding-top:5px;" class='fa fa-upload' aria-hidden='true'></span><?php echo $ketskp; ?> SKP TAHUN 2024
                              </button>
                          </div>
                          <div class="col-md-3" align='right'>
                            <?php
                            if ((file_exists('./fileskpbulanan_pppk/'.$v['nip'].'-SKP2024.pdf')) OR (file_exists('./fileskpbulanan_pppk/'.$v['nip'].'-SKP2024.PDF'))) {
                            ?>
                                <a style="padding-left:40px; padding-right:40px; padding-top:5px;" class='btn btn-success btn-outline btn-sm'
					href='../fileskpbulanan_pppk/<?php echo $v['nip']."-SKP2024".$jnsfileskp; ?>' target='_blank' role='button'>
                                <span class='fa fa-file-pdf-o' aria-hidden='true'></span>LIHAT SKP TAHUN 2024</a>
                            <?php
                            }
                            ?>
                          </div>
                        </div> <!-- End Row -->

                        <?php
                     }
                     ?>
		     <tr>	
                      <td align='center'><?php echo $no;?></td>
                      <td>
                        <?php
			  if ($v['bulan'] != '13') {
                            echo bulan($v['bulan']).' '.$v['tahun'];
			  } else if ($v['bulan'] == '13') {
                            echo 'FINAL '.$v['tahun'];
                          } 
                        ?>
                      </td>
                      <td>
                        <?php
			  $jnsjabbkn = $this->mpegawai->getnama_jnsjabbkn($v['jenis']);
                          echo "<small><b>".$jnsjabbkn."</b></small>";
                          echo "<br/><small><i>".$v['skp_jabatan']."</i></small>";
                          echo "<br/><small><u>".$v['skp_unor']."</u></small>";
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                          echo "<span class='text text-primary pull-left'>Hasil Kerja</span>
                                <span class='label label-primary'>".strtoupper($v['hasil_kerja'])."</span><br />";
                          echo "<span class='text text-warning pull-left'>Perilaku  Kerja</span>
                                <span class='label label-warning'>".strtoupper($v['perilaku_kerja'])."</span><br />";
                          echo "<span class='text text-success pull-left'>HASIL AKHIR</span>
                                <span class='label label-success'>".strtoupper($v['hasil_akhir'])."</span><br/>";
                          echo "<small><span class='text text-danger pull-left'>Dinilai pada :</span>
                                <span class='text text-danger pull-left'>".tglwaktu_indo($v['waktu_dinilai'])."</span></small>";
                        ?>
                      </td>
                      <td>
                        <?php
                          echo "<small><b>".$v['pegawai_atasan_nama']."</b></small>";
                          echo "<br/><small><i>".$v['pegawai_atasan_jabatan']."</i></small>";
                          echo "<br/><small><u>".$v['pegawai_atasan_unor']."</u></small>";
                        ?>
                      </td>
                      <td align='right'>
                        <?php
                        if (file_exists('./fileskpbulanan_pppk/'.$v['berkas'].'.pdf')) {
                                $ket = "Upload Ulang";
                                $jnsfile = ".pdf";
                                $btncolor = "btn-warning";
                        } else if (file_exists('./fileskpbulanan_pppk/'.$v['berkas'].'.PDF')) {
                                $ket = "Upload Ulang";
                                $jnsfile = ".PDF";
                                $btncolor = "btn-warning";
                        } else {
                                $ket = "Upload File";
                                $btncolor = "btn-info";
                        }

                        ?>
			<button type='button' class='btn <?php echo $btncolor; ?> btn-outline btn-xs' data-toggle='modal' data-target='#upload<?php echo $v['id']; ?>'>
                          <span class='fa fa-upload' aria-hidden='true'></span>&nbsp<?php echo $ket; ?>
                        </button>

			<?php
                        if ((file_exists('./fileskpbulanan_pppk/'.$v['berkas'].'.pdf')) OR (file_exists('./fileskpbulanan_pppk/'.$v['berkas'].'.PDF'))) {
                        ?>
			<a class='btn btn-success btn-outline btn-xs' href='../fileskpbulanan_pppk/<?php echo $v['berkas'].$jnsfile; ?>' target='_blank' role='button' style='margin-top: 5px; margin-bottom:5px;'>
                          <span class='fa fa-eye' aria-hidden='true'></span>&nbspView File</a>
			<?php
                        }
                        ?>

                        <?php
                        if ($this->session->userdata('nip') == '198104072009041002') {
                        ?>
                        <form method="POST" name="'formdelete" action="<?=base_url()?>pppk/deleteskp2024">
                           <input type='hidden' name='id' id='id' value='<?php echo $v['id']; ?>' >
                           <input type='hidden' name='nip' id='nip' value='<?php echo $v['nip']; ?>' >
                           <input type='hidden' name='nmberkas' id='nmberkas' value='<?php echo $v['berkas']; ?>' >
                               <button type="submit" value="upload" class="btn btn-xs btn-danger btn-outline" style='margin-top: 5px; margin-bottom: 5px;'>
                                 <span class="fa fa-trash" aria-hidden="false"></span>&nbspDelete
                               </button>
                        </form>
                        <?php
                        }
                        ?>

                      </td>
                    </tr>
                        <!-- Modal Upload SKP Bulanan -->
                        <div id="upload<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-primary'>UPLOAD DOKUMEN PENILAIAN KINERJA BULANAN</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
                                        echo "<span class='text text-primary'>Periode : ".bulan($v['bulan'])." ".$v['tahun']."</span>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                  <form method="POST" name="'formupload" action="<?=base_url()?>uploadpppk/insertskpbulanan" enctype="multipart/form-data">
                                  <input type='hidden' name='id' id='id' value='<?php echo $v['id']; ?>' >
                                  <input type='hidden' name='nipppk' id='nipppk' value='<?php echo $v['nip']; ?>' >
                                  <input type='hidden' name='thn' id='thn' value='<?php echo $v['tahun']; ?>' >
                                  <input type='hidden' name='bln' id='bln' value='<?php echo $v['bulan']; ?>' >
                                  <input type='hidden' name='berkaslama' id='berkaslama' value='<?php echo $v['berkas']; ?>' >
                                  <div class="row"'>
                                    <div class="col-md-4"><span class='text text-primary'>Pilih file dokumen dengan format .pdf maks 200 Kilo Byte.</span>
                                    </div>
                                    <div class="col-md-5">
                                      <input type="file" name="fileskpbulanan_pppk" class="btn btn-xs btn-info">
                                    </div>
                                    <div class="col-md-3" align='center'>
                                      <button type="submit" value="upload" class="btn btn-sm btn-primary btn-outline">
                                        <span class="fa fa-upload" aria-hidden="false"></span>&nbspUpload File
                                      </button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal Upload SKP Bulanan -->

                        <!-- Modal Upload SKP 2024 -->
                        <div id="uploadskp2024<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-danger'>UPLOAD DOKUMEN SASARAN KINERJA PEGAWAI TAHUN 2024</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                  <form method="POST" name="'formupload" action="<?=base_url()?>uploadpppk/insertskp2024" enctype="multipart/form-data">
                                  <input type='hidden' name='nipppk' id='nipppk' value='<?php echo $v['nip']; ?>' >
                                  <div class="row"'>
                                    <div class="col-md-4"><span class='text text-danger'>Pilih file dokumen dengan format .pdf maks 200 Kilo Byte.</span>
                                    </div>
                                    <div class="col-md-5">
                                      <input type="file" name="fileskpbulanan_pppk" class="btn btn-xs btn-danger">
                                    </div>
                                    <div class="col-md-3" align='center'>
                                      <button type="submit" value="upload" class="btn btn-sm btn-danger btn-outline">
                                        <span class="fa fa-upload" aria-hidden="false"></span>&nbspUpload File
                                      </button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal Upload SKP 2024 -->

                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>
                </div>
                </div> <!-- End Scroll -->
              </div> <!-- akhir konten tab kinerja BKN -->


	     </div> <!-- en tab content -->	
            </td>
          </tr>
        </table>        
      </div>
    </div>
  </div>  
</center>
