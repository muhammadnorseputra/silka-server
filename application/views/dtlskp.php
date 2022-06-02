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
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pegawai/rwyskp'>";          
        echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-grain" aria-hidden="true"></span>
        <?php
          echo '<b>DETAIL SKP TAHUN '.$thn.'</b><br />';
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
                <li class="active"><a href="#skp" data-toggle="tab">SKP</a></li>
		<?php
                if ($thn != '2021') {
                ?>
                <li><a href="#pp" data-toggle="tab">Pejabat Penilai</a></li>
                <li><a href="#app" data-toggle="tab">Atasan Pejabat Penilai</a></li>
		<?php
		}
		?>
		<li><a href="#upload" data-toggle="tab">Upload file</a></li>	
                <?php
                if ($thn != '2021') {
                ?>
		<li><a href="#cetak" data-toggle="tab">Cetak Form Prestasi Kerja</a></li>
                <?php
                }
                ?>
	      </ul>

              <!-- Tab panes, ini content dari tab di atas -->
              <div class="tab-content">
                <div class="tab-pane face in active" id="skp">
                <br />
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                  <div class="panel panel-default">
                    <div class="panel-heading"><b>STANDAR KINERJA PEGAWAI</b></div>
                    <?php
                      foreach($pegdtlskp as $v):                    
                    ?>
		    <br/>
		    <div class='well' style="width: 90%">
                    <table class='table table-condensed' style="width: 100%">
                        <tr>
                          <td align='right'>Tahun :</td>
                          <td colspan='2'>
				<?php
					echo $v['tahun'];
					if (($v['tahun'] == '2021') AND ($v['inisiatifkerja'] == 0)) {
						echo " <span class='text-primary'><b>PP 46/2011</b></span>";
					} else {
						echo " <span class='text-danger'><b>PP 30/2019</b></span>";
					}
				?>
			  </td>                          
                          <td colspan='2' align='right'>Jenis :</td>
                          <td width=''><?php echo $v['jns_skp']; ?></td>
                        </tr>
                        <tr>                                                
                          <td colspan='6'></td>                        
                        </tr>
                        <tr>
                          <td colspan='2' align='right'>Orientasi Pelayanan :</td>
                          <td colspan='2' width='100'>
                            <?php
                              echo $v['orientasi_pelayanan']; 
                              echo ' [ '.$this->mpegawai->getnilaiskp($v['orientasi_pelayanan']).' ]';
                            ?>                          
                          </td>
                          <td></td>
                          <td></td>                        
                        </tr>
			<tr>
                          <td colspan='2' align='right'>Inisiatif Kerja :</td>
                          <td colspan='2'>
                            <?php
			      if ($v['inisiatifkerja'] != 0) { 
                               	echo $v['inisiatifkerja'];
                              	echo ' [ '.$this->mpegawai->getnilaiskp($v['inisiatifkerja']).' ]';
			      } else {
				echo "-";
			      }
                            ?>
                          </td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td colspan='2' align='right'>Integritas :</td>
                          <td colspan='2'>
                          <?php
                            echo $v['integritas'];
                            echo ' [ '.$this->mpegawai->getnilaiskp($v['integritas']).' ]';
                          ?>                             
                          </td>
                          <td align='right'>Nilai SKP :</td>
                          <td>
                          <?php 
                            echo $v['nilai_skp'];
                            echo ' [ '.$this->mpegawai->getnilaiskp($v['nilai_skp']).' ]';
                            echo ' --- 60% = '.round((0.6*$v['nilai_skp']), 2);
                          ?>                              
                          </td>
                        </tr>
                        <tr>
                          <td colspan='2' align='right'>Komitmen :</td>
                          <td colspan='2'>
                          <?php 
                              echo $v['komitmen'];
                              echo ' [ '.$this->mpegawai->getnilaiskp($v['komitmen']).' ]';
                          ?>                            
                          </td>
                          <td></td>
                          <td>
                          </td>
                        </tr>
                        <tr>
                          <td colspan='2' align='right'>Disiplin :</td>
                          <td colspan='2'>
                          <?php
                            echo $v['disiplin'];
                            echo ' [ '.$this->mpegawai->getnilaiskp($v['disiplin']).' ]';
                          ?>                            
                          </td>
			  <td align='right'>Nilai Prilaku Kerja :</td>
                          <td>
                          <?php
                            echo round($v['nilai_prilaku_kerja'], 2);
                            echo ' [ '.$this->mpegawai->getnilaiskp(round($v['nilai_prilaku_kerja']), 2).' ]';
                            echo ' --- 40% = '.round((0.4*$v['nilai_prilaku_kerja']), 2);
                          ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan='2' align='right'>Kerjasama :</td>
                          <td colspan='2'>
                          <?php
                            echo $v['kerjasama'];
                            echo ' [ '.$this->mpegawai->getnilaiskp($v['kerjasama']).' ]';
                          ?>                            
                          </td>
                          <td align='right'><b>Nilai Prestasi Kerja :</b></td>
                          <td><b>
                          <?php
                            echo round($v['nilai_prestasi_kerja'], 2);
                            echo ' [ '.$this->mpegawai->getnilaiskp(round($v['nilai_prestasi_kerja']), 2).' ]';
                          ?>                            
                          </b></td>
                        </tr>
                        <tr>
                          <td colspan='2' align='right'>Kepemimpinan :</td>
                          <td colspan='2'>
                          <?php
                            if ($v['jns_skp'] == 'STRUKTURAL') {
                              echo $v['kepemimpinan'];
                              echo ' [ '.$this->mpegawai->getnilaiskp($v['kepemimpinan']).' ]';
                            } else {
                              echo "-";
                            }
                          ?>                            
                          </td>
                          <td colspan='2' align='center'>
			  <?php
                            if (($v['tahun'] == '2021') AND ($v['inisiatifkerja'] == 0)) { // PP 46/2011
                                $nkin46 = $this->mskp->konversiskp_pp46($v['nilai_prestasi_kerja']);
				echo "<b><span class='text-primary'>
                                KONVERSI NILAI KINERJA PP 46/2011 : ",$nkin46,"</span></b>";
                            }
                          ?>
			  </td>
                        </tr>
			<tr>
				<td colspan='6' align='right'>
				<?php
					if (($v['tahun'] == '2021') AND ($v['inisiatifkerja'] != 0)) { // PP 30/2019
                                	$nkin2021 = ($nkin46/2) + (round($v['nilai_prestasi_kerja'], 2)/2);
                                	echo "<H5><b><span class='text-danger'>
                                	NILAI KINERJA 2021 : ",round($nkin2021,3),"</span></b></H5>";
                            	}
                          	?>
				</td>
			</tr>
                      </table>
		      </div>
                    <?php
                      endforeach;
                    ?>                    
                  </div>            
                </div> <!-- akhir konten tab SKP -->
                
		<div class="tab-pane fade" id="pp">
                  <br />
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>PEJABAT PENILAI</b></div>
                        <?php
                        foreach($pegdtlskp as $v):                    
                        ?>
                          <table class='table table-condensed'>
                          <?php
                            if ($v['nip_pp'] != '') {
                              echo "<tr>";
                              echo "<td align='right'>NIP :</td><td>".$v['nip_pp']."</td>";
                              echo "</tr>";
                            } 
                          ?>
                          <tr>
                            <td align='right' width='300'>Nama :</td><td><?php echo $v['nama_pp']; ?></td>
                          </tr>
                          <?php
                            if ($v['nip_pp'] != '') {
                              echo "<tr>";
                              echo "<td align='right'>Pangkat :</td><td>".$this->mpegawai->getnamapangkat($v['fid_golru_pp'])." (".$this->mpegawai->getnamagolru($v['fid_golru_pp']).") </td>";
                              echo "</tr>";
                            }
                          ?>
                          <tr>
                            <td align='right'>Jabatan :</td><td><?php echo $v['jab_pp']; ?></td>
                          </tr>
                          <tr>
                            <td align='right'>Unit Kerja :</td><td><?php echo $v['unor_pp']; ?></td>
                          </tr>
                          </table>
                        <?php
                          endforeach;
                        ?>                        
                    </div>
                </div> <!-- akhir konten tab pp -->

                <div class="tab-pane fade" id="app">
                <br />
                  <div class="panel panel-default">
                    <div class="panel-heading"><b>ATASAN PEJABAT PENILAI</b></div>
                    <?php
                        foreach($pegdtlskp as $v):                    
                        ?>
                        <table class='table table-condensed'>
                        <?php
                            if ($v['nip_app'] != '') {
                              echo "<tr>";
                              echo "<td align='right'>NIP :</td><td>".$v['nip_app']."</td>";
                              echo "</tr>";
                            } 
                          ?>
                        <tr>
                          <td align='right' width='300'>Nama :</td><td><?php echo $v['nama_app']; ?></td>
                        </tr>
                        <?php
                            if ($v['nip_app'] != '') {
                              echo "<tr>";
                              echo "<td align='right'>Pangkat :</td><td>".$this->mpegawai->getnamapangkat($v['fid_golru_app'])." (".$this->mpegawai->getnamagolru($v['fid_golru_app']).") </td>";
                              echo "</tr>";
                            }
                          ?>
                        <tr>
                          <td align='right'>Jabatan :</td><td><?php echo $v['jab_app']; ?></td>
                        </tr>
                        <tr>
                          <td align='right'>Unit Kerja :</td><td><?php echo $v['unor_app']; ?></td>
                        </tr>
                        </table>
                        <?php
                          endforeach;
                        ?>                        
                      
                    </div>  
                </div> <!-- akhir konten tab app -->

                <div class="tab-pane fade" id="upload">
                <br />
                  <div class="panel panel-default">
                    <div class="panel-heading"><b>UPLOAD FILE</b></div>                    
                    <br />
                    <!-- memeriksa file skp -->
                    <?php
                      $lokasifile='./fileskp/';

                      if (file_exists('./fileskp/'.$nip.'-'.$v['tahun'].'.pdf')) {
                        $namafile=$nip.'-'.$v['tahun'].'.pdf';
                      } else {
                        $namafile=$nip.'-'.$v['tahun'].'.PDF';
                      } 
                      
                      if (file_exists ($lokasifile.$namafile))
                        echo "<a class='btn btn-info btn-xs' href='../fileskp/$namafile' target='_blank' role='button'>
                              <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                              Download file</a><br /><br />Silahkan upload untuk memperbarui file, 
                              harus format .pdf ukuran maksimal 3 MB !!!";
                      else
                        echo "<h4><span class='label label-danger'>File Tidak Ada, Silahkan Upload</span></h4>";
                    ?>
                    <?php
                      $this->session->flashdata('pesan')
                    ?>
                    <br />
                    <?php 
                      //echo form_open_multipart('upload/insert');
                      
                    ?>
                    <!-- Jalankan function insert pada controller upload -->
                    <form action="<?=base_url()?>upload/insertskp" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileskp" size="40" class="btn btn-info" />
                    <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                    <input type='hidden' name='thn' id='thn' maxlength='4' value='<?php echo $thn; ?>'>
                    <br />
                    <button type="submit" value="upload" class="btn btn-warning">
                    <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                    </form>
                    <br />
                  </div>  
                </div> <!-- akhir konten tab upload -->

		<!-- awal konten tab cetak -->
                <div class="tab-pane fade" id="cetak">
                <br/>
                  <div class="panel panel-default">                    
                    <br />
                    <form method='POST' action='../crudskp/cetakfpk' target='_blank'>
                    <input type='hidden' name='nip' id='nip' value='<?php echo $nip; ?>'>
                    <input type='hidden' name='thn' id='thn' value='<?php echo $thn; ?>'>
                      <table class='table table-condensed' style="width: 80%"> 
                      <tr>
                        <td align='right'>Periode Penilaian</td>
                        <td colspan='5'><input type="text" name="periodeawal" size='10' maxlength='10' class="tanggal" value='01-01-2020' required />
                        sampai dengan <input type="text" name="periodeakhir" size='10' maxlength='10' class="tanggal" value='31-12-2020' required /></td>
                      </tr>
                      <tr>
                        <td align='right'>Unit Kerja</td>
                        <?php
                          $nmunker = $this->munker->getnamaunker($this->mpegawai->getfidunker($v['nip']));
                        ?>
                        <td colspan='5'><input type="text" name="nmunker" size='100' value='<?php echo $nmunker;?>' required /></td>
                      </tr>
                      <tr>
                        <?php
                          $nmjab = $this->mkinerja->getnamajabatan($v['nip']);
                        ?>
                        <td align='right'>Jabatan</td>
                        <td colspan='5'><input type="text" name="nmjab" size='100' value='<?php echo $nmjab;?>' required /></td>
                      </tr>
                      <tr>
                        <td align='right'>Tanggal Dibuat oleh Penilai</td>
                        <td><input type="text" name="dibuatpenilai" size='10' maxlength='10' class="tanggal" value='<?php echo date('d-m-Y'); ?>' required /></td>
                        <td align='right'>Tanggal Diterima oleh PNS</td><td>
                        <input type="text" name="diterimapns"  size='10' maxlength='10' class="tanggal" value='<?php echo date('d-m-Y'); ?>' required /></td>
                        <td align='right'>Tanggal Diterima oleh Atasan Penilai</td>
                        <td><input type="text" name="diterimaatasanpenilai" size='10' maxlength='10' name="dibuat" class="tanggal" value='<?php echo date('d-m-Y'); ?>' required /></td>
                      </tr>
                      <tr>
                      <td colspan='6' align='center'><br/>
                        <button type="submit" value="upload" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-print" aria-hidden="false"></span>&nbspCetak Form Prestasi Kerja</button>    
                      </td>
                      </tr>
                      </table>
                    </form>              
                  </div>
                </div>
                <!-- akhir konten tab cetak -->

              </div> <!-- akhir konten tab-content -->

                

            </td>
          </tr>
        </table>
      </div>    
    </div>
  </div>  
</center>
