<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
    <table class='table table-condensed'>
        <tr>
	<?php
	$intbkn_session = $this->session->userdata('intbkn_priv');
        if ($intbkn_session == "YA") {
	//if ($this->session->userdata('level') != "TAMU") {
        ?>
	<td align='left' width='50' >
              <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#tampilskpsapk"><span class="fa fa-desktop" aria-hidden="true"></span> Komparasi Data SKP SAPK</button>
          </td>
	<?php
        }
	//if ($this->session->userdata('level') == "USER") {
	if (!($this->mskp->cekskp2021_pp46($nip)) OR !($this->mskp->cekskp2021_pp30($nip))) {
        ?>
	 <td align='right'>
            <form method="POST" action="../crudskp/tambah2021">
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-warning btn-outline btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah SKP KHUSUS 2021 (Integrasi BKN)
                </button>
            </form>
        </td>
	<?php
	}
	//}
	?>
	<td align='right' width='50'>
            <form method="POST" action="../crudskp/tambahintegrasi">
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-success btn-outline btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah SKP SEBELUM 2021 (Integrasi BKN)
                </button>
            </form>
        </td>
	<?php
	//if ($this->session->userdata('level') != "TAMU") {
	?>
	<!--
          <td align='right' width='50'> 
            <form method="POST" action="../crudskp/tambah">
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah SKP 2019 kebawah
                </button>
            </form>
          </td>
	-->
	<?php
	//}
	?>
          <td align='right' width='50'>
            <form method='POST' action='../pegawai/detail'>
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            </form>
          </td>
        </tr>
      </table>    

      <?php
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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-grain" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT SKP</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

        <table class="table">
          <tr>
            <td align='center'>
              <table class='table table-hover table-bordered'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='50'><center>Tahun</center></th>
                    <th width='50'><center>Nilai<br />SKP</center></th>
                    <th width='50'><center>Nilai<br />Prilaku Kerja</center></th>
                    <th width='50'><center>Nilai<br />Prestasi Kerja</center></th>
                    <th width='300'><center>Pejabat Penilai</center></th>
                    <th width='300'><center>Atasan Pejabat Penilai</center></th>
                    <th width='100' colspan='2'><center>Aksi</center></th>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwyskp as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='left'>
		    <small>
			<?php
				echo $v['tahun']."<br/>".$v['jns_skp'];
				if ($v['id_bkn']) {
					echo "<br/><code>Integrated</code>";
				}

				if (($v['tahun'] == '2021') AND ($v['inisiatifkerja'] != '0')) {
					echo "<br/><code><span class='text-primary'><b>PP 30/2019</b></span></code>";
				} else if (($v['tahun'] == '2021') AND ($v['integritas'] != '0') AND ($v['disiplin'] != '0')) {
					echo "<br/><code><span class='text-primary'><b>PP 46/2011</b></span></code>";
				}
			?>
		    </small>
		    </td>
                    <td align='center'><?php echo $v['nilai_skp']; ?></td>
                    <td align='center'><?php echo round($v['nilai_prilaku_kerja'], 2); ?></td>
                    <td align='center'>
			<?php
				echo round($v['nilai_prestasi_kerja'], 2);
				if (($v['tahun'] == '2021') AND ($v['integritas'] != '0') AND ($v['disiplin'] != '0')) {
					$konversi = $this->mskp->konversiskp_pp46(round($v['nilai_prestasi_kerja'], 2));
					echo "<br/><b><span class='text-success'><small>KONVERSI</small><br>".round($konversi,2)."</span></b>";
				} else if (($v['tahun'] == '2021') AND ($v['inisiatifkerja'] != '0')) {
					$getnpk = $this->mskp->get_nilaiprestasikerja($nip,2021)->result_array();
					$nintegrasi = 0;
					foreach($getnpk as $np):
						$nintegrasi = $nintegrasi + ($np['nilai_prestasi_kerja'] * 0.5);
					endforeach;				
					$predikat = $this->mskp->get_predikat2021($nintegrasi);
					echo "<br/><b><span class='text-danger'><small>INTEGRASI<br>".round($nintegrasi,3)."<br/>(".$predikat.")</small></span></b>";
				}	
			?>
		    </td>
                    <!--<td><small><?php echo $v['nama_pp'].'<br />'.$v['nip_pp'].'<br />'.$this->mpegawai->getnamapangkat($v['fid_golru_pp']).'   '.$this->mpegawai->getnamagolru($v['fid_golru_pp']).'<br />'.$v['jab_pp'].'<br />'.$v['unor_pp']; ?></small></td>-->
                    <td><small><?php echo $v['nama_pp'].'<br />'.$v['jab_pp'].'<br />'.$v['unor_pp']; ?></small></td>
                    <!--<td><small><?php echo $v['nama_app'].'<br />'.$v['nip_app'].'<br />'.$this->mpegawai->getnamapangkat($v['fid_golru_app']).'   '.$this->mpegawai->getnamagolru($v['fid_golru_app']).'<br />'.$v['jab_app'].'<br />'.$v['unor_app']; ?></small></td>-->
                    <td><small><?php echo $v['nama_app'].'<br />'.$v['jab_app'].'<br />'.$v['unor_app']; ?></small></td>
                    
		    <td align='center'>
                    <?php
                    echo "<form method='POST' action='../pegawai/dtlskp'>";          
                    echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
                    echo "<input type='hidden' name='thn' id='thn' maxlength='4' value='$v[tahun]'>";
                    ?>
                    <button type="submit" class="btn btn-info btn-xs ">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail
                    </button>
                    <?php
                      echo "</form>";
                    ?>		    

  		    <br />	
			
		    <?php
		    if ($v['tahun'] < 2020) {
                    echo "<form method='POST' action='../crudskp/editskp'>";          
                    echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
                    echo "<input type='hidden' name='thn' id='thn' maxlength='4' value='$v[tahun]'>";
                    ?>
                    <button type="submit" class="btn btn-success btn-xs ">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Edit
                    </button>
                    <?php
                      echo "</form>";
		    }
                    ?>
			
  		    </td>
		    <td align='center'>

                    <?php
                    echo "<form method='POST' action='../crudskp/hapus'>";          
                    echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
                    echo "<input type='hidden' name='thn' id='thn' maxlength='4' value='$v[tahun]'>";
                    ?>
                    <button type="submit" class="btn btn-warning btn-xs ">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus
                    </button>
                    <?php
                      echo "</form>";
                    ?>
                    <!-- memeriksa file skp -->
                    <?php
                      $lokasifile='./fileskp/';
                      //$namafile=$nip.'-'.$v['tahun'].'.pdf';
                      if (file_exists('./fileskp/'.$nip.'-'.$v['tahun'].'.pdf')) {
                        $namafile=$nip.'-'.$v['tahun'].'.pdf';
                      } else {
                        $namafile=$nip.'-'.$v['tahun'].'.PDF';
                      } 

                      if (file_exists ($lokasifile.$namafile))
                        echo "<h5><a class='btn btn-info btn-xs' href='../fileskp/$namafile' target='_blank' role='button'>
                              <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                              Download</a></h5>";
                      else
                        echo "<br/><span class='text text-danger'><b><span class='fa fa-file-pdf-o'></span>&nbspFile tidak ada</b></span>";
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
    </div>
  </div>  
</center>

<?php
if ($intbkn_session == "YA") {
?>
<!-- Modal Tampil data BKN-->
<div id="tampilskpsapk" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Komparasi Riwayat SKP pada SAPK</h4>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:550px;border:1px solid white">        
        <small>
        <div class="row" style="padding:10px;"> <!-- Baris Awal -->
          
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">DATA SILKa Online</div>
              <!-- .panel-heading -->
              <div class="panel-body">
                <div class="panel-group" id="accordionsilka">
                  <?php
                  // Jika menggunakan Json API
                  //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/rw-skp/'.$nip);
                  //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/198104072009041002');
                  //$obj = json_decode($resultApi);
                  //print_r($obj);
                  //var_dump($obj);

                  // Jika menggunakan file Json
                  //$url = 'http://localhost/silka/assets/datautama_wsbkn.json';
                  //$konten = file_get_contents($url);
                  //$obj = json_decode($konten, true);
                  //var_dump($obj);
                  $data = $this->mpegawai->rwyskp($nip)->result_array(); 
                  foreach ($data as $d)
                  {
		    if (($d['tahun'] == '2021') AND ($d['inisiatifkerja'])) {
                    	$aturan = "PP 30/2019";
                    } else {
                    	$aturan = "PP 46/2011";
                    }
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <h5 class='panel-title'>
                              <a data-toggle='collapse' data-parent='#accordionsilka' href='#silka".$d['id']."' aria-expanded='false' class='collapsed'>
				Tahun ".$d['tahun']."</a> <small><span class=text-primary>".$aturan."</span>
				<code>(Nilai PK : ".number_format($d['nilai_prestasi_kerja'],2).")</code></small>
                            </h5>
                          </div>";
                    echo "<div id='silka".$d['id']."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
		      <div class="row">
                        <div class="col-md-4"><?php echo "ID BKN"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['id_bkn']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Jenis Jabatan"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['jns_skp']; ?></div>
                      </div>
		      <div class="row">
			<?php
			if (($d['tahun'] == '2021') AND ($d['inisiatifkerja'])) {
				$aturan = "PP 30/2019";
			} else {
				$aturan = "PP 46/2011";
			}
			?>
                        <div class="col-md-4"><?php echo "Peraturan Kinerja"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$aturan; ?></div>
                      </div>
                      <div class="row">
                        <?php
                          $skp60 = $d['nilai_skp'] * 0.6;
                        ?>
                        <div class="col-md-4"><b><?php echo "Nilai SKP"; ?></b></div>
                        <div class="col-md-2"><b><?php echo ": ".number_format($d['nilai_skp'],2); ?></b></div>                        
                        <div class="col-md-6">60 % : <b><?php echo number_format($skp60,2); ?></b></div>
                      </div>
                      <br/>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Orientasi Pelayanan"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['orientasi_pelayanan']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Integritas"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['integritas']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Komitmen"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['komitmen']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Disiplin"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['disiplin']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Kerjasama"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['kerjasama']; ?></div>
                      </div>                    
		      <div class="row">
                        <div class="col-md-4"><?php echo "Inisiatif Kerja"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['inisiatifkerja']; ?></div>
                      </div>  
                      <div class="row">
                        <div class="col-md-4"><?php echo "Kepemimpinan"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$d['kepemimpinan']; ?></div>
                      </div>
                      <div class="row">
                        <?php
			  if (($d['kepemimpinan'] == '') || ($d['kepemimpinan'] == 0)) {
                        if (($d['inisiatifkerja'] == '') OR ($d['inisiatifkerja'] == 0)) { // PP 46/2011
                                $jml = $d['orientasi_pelayanan']+$d['integritas']+$d['komitmen']+$d['disiplin']+$d['kerjasama'];
				$rata = $jml/5;
                        } else { // PP 30/2019
                                $jml = $d['orientasi_pelayanan']+$d['komitmen']+$d['inisiatifkerja']+$d['kerjasama'];
                        	$rata = $jml/4;
			}
                } else {
                        if (($d['inisiatifkerja'] == '') OR ($d['inisiatifkerja'] == 0)) { // PP 30/2011
                                $jml = $d['orientasi_pelayanan']+$d['integritas']+$d['komitmen']+$d['disiplin']+$d['kerjasama']+$d['kepemimpinan'];
                        	$rata = $jml / 6;
			} else { // PP 30/2019
                                $jml = $d['orientasi_pelayanan']+$d['komitmen']+$d['inisiatifkerja']+$d['kerjasama']+$d['kepemimpinan'];
                        	$rata = $jml / 5;
			}
                }

                          //$jml = $d['orientasi_pelayanan']+$d['integritas']+$d['komitmen']+$d['disiplin']+$d['kerjasama']+$d['kepemimpinan'];
                          //if ($d['jns_skp'] == "STRUKTURAL") {
                          //  $rata = $jml/6;  
                          //} else {
                          //  $rata = $jml/5;
                          //}
                          
                        ?>
                        <div class="col-md-4"><u><?php echo "Jumlah"; ?></u></div>
                        <div class="col-md-8"><?php echo ": <u>".$jml."</u>"; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><b><?php echo "Rata-rata"; ?></b></div>
                        <div class="col-md-8"><?php echo ": <b>".number_format($rata,2)."</b>"; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-6"><b><?php echo "Nilai Prilaku Kerja"; ?></b></div>
                        <div class="col-md-6">40 % : <b><?php echo number_format($d['nilai_prilaku_kerja'],2); ?></b></div>
                      </div>
                      <div class="row">
                        <h5>
                        <div class="col-md-7 text-primary"><b><?php echo "NILAI PRESTASI KERJA"; ?></b></div>
                        <div class="col-md-5 text-primary"><b><?php echo number_format($d['nilai_prestasi_kerja'],2); ?></b></div>
                        </h5>
                      </div>
		      <?php
			if (($d['tahun'] == '2021') AND ($d['integritas'] != '0') AND ($d['disiplin'] != '0')) {
                                $konversi = $this->mskp->konversiskp_pp46(round($d['nilai_prestasi_kerja'], 2));
                                $nintegrasi = 0;
				?>
                      		<div class="row">
                        		<div class="col-md-7 text-warning"><b><?php echo "NILAI KONVERSI"; ?></b></div>
                        		<div class="col-md-5 text-warning"><b><?php echo round($konversi,2); ?></b></div>
                      		</div>
                      		<?php
                        } else if (($d['tahun'] == '2021') AND ($d['inisiatifkerja'] != '0')) {
                                $konversi = 0;
                                $getnpk = $this->mskp->get_nilaiprestasikerja($nip,2021)->result_array();
                                $nintegrasi = 0;
                                foreach($getnpk as $np):
					$nintegrasi = $nintegrasi + ($np['nilai_prestasi_kerja'] * 0.5);
                                endforeach;
				?>
                      		<div class="row">
                        		<div class="col-md-7 text-success"><b><?php echo "NILAI INTEGRASI"; ?></b></div>
                        		<div class="col-md-5 text-success"><b><?php echo round($nintegrasi,2); ?></b></div>
                      		</div>
                      		<?php
                        }
		      ?>

                      <br/><b>PEJABAT PENILAI</b>
                      <div class="row">
                        <div class="col-md-2"><?php echo "NIP"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$d['nip_pp']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Nama"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$d['nama_pp']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Unit"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$d['unor_pp']; ?></div>
                      </div>

                      <br/><b>ATASAN PEJABAT PENILAI</b>
                      <div class="row">
                        <div class="col-md-2"><?php echo "NIP"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$d['nip_app']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Nama"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$d['nama_app']; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Unit"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$d['unor_app']; ?></div>
                      </div>
                    <?php
                    echo "</div>
                          </div>
                        </div>";                    
                  }
                  ?>

                </div>
              </div>
              <!-- .panel-body -->
            </div>
          </div> <!-- End Column Panel Data SAPK-->

          <!-- Column SAPK -->
          <div class="col-md-6">
            <div class="panel panel-success">
              <div class="panel-heading"><b>DATA SAPK</b></div>
              <!-- .panel-heading -->
              <div class="panel-body">
                <div class="panel-group" id="accordionsapk">
                  <?php
                  // Jika menggunakan Json API
                  $resultApi = apiResult('https://wsrv-duplex.bkn.go.id/api/skp/pns/'.$nip);
                  //$resultApi = apiResult('https://wsrv.bkn.go.id/api/pns/rw-skp/'.$nip);
		  //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/198104072009041002');
                  $obj = json_decode($resultApi);
                  //print_r($obj);
                  //var_dump($obj);

                  // Jika menggunakan file Json
                  //$url = 'http://localhost/silka/assets/datautama_wsbkn.json';
                  //$konten = file_get_contents($url);
                  //$obj = json_decode($konten, true);
                  //var_dump($obj);

                  //foreach ($obj->data as $data) // jika menggunakan wsrv.bkn.go.id
		  foreach ($obj->mapData->data as $data) // jika menggunakan wsrv-duplex.bkn.go.id
                  {
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <h5 class='panel-title'>
                              <a data-toggle='collapse' data-parent='#accordionsapk' href='#sapk".$data->id."' aria-expanded='false' class='collapsed'>
				Tahun ".$data->tahun."</a>";
		    if ($data->jenisPeraturanKinerjaKd == "PP30") {
		    //if (($data->tahun == "2021") AND ($data->integritas == "0.0") AND ($data->disiplin == "0.0")) {
			$aturan = "PP 30/2019";
			echo " <small><span class=text-primary>".$aturan."</span></small>";
		    } else if ($data->jenisPeraturanKinerjaKd == "PP46") {
			$aturan = "PP 46/2011";
			echo " <small><span class=text-primary>".$aturan."</span></small>";
		    }
		    echo "<small><code>(Nilai PK : ".$data->nilaiPrestasiKerja.")</code></small>
                            </h5>
                          </div>";
                    echo "<div id='sapk".$data->id."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
		      <div class="row">
                        <div class="col-md-4"><?php echo "ID"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->id; ?></div>
                      </div>
                      <div class="row">
                        <?php $jnsjab = $this->mwsbkn->getnamajnsjab($data->jenisJabatan); ?>
                        <div class="col-md-4"><?php echo "Jenis Jabatan"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$jnsjab; ?></div>
                      </div>
		      <div class="row">
                        <div class="col-md-4"><?php echo "Peraturan Kinerja"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->jenisPeraturanKinerjaKd; ?></div>
                      </div>
                      <div class="row">
                        <?php
                          $skp60 = $data->nilaiSkp * 0.6;
                        ?>
                        <div class="col-md-4"><b><?php echo "Nilai SKP"; ?></b></div>
                        <div class="col-md-2"><b><?php echo ": ".$data->nilaiSkp; ?></b></div>                        
                        <div class="col-md-6">60 % : <b><?php echo $skp60; ?></b></div>
                      </div>
                      <br/>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Orientasi Pelayanan"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->orientasiPelayanan; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Integritas"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->integritas; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Komitmen"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->komitmen; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Disiplin"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->disiplin; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Kerjasama"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->kerjasama; ?></div>
                      </div>                      
		      <div class="row">
                        <div class="col-md-4"><?php echo "Inisiatif Kerja"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->inisiatifKerja; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><?php echo "Kepemimpinan"; ?></div>
                        <div class="col-md-8"><?php echo ": ".$data->kepemimpinan; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><u><?php echo "Jumlah"; ?></u></div>
                        <div class="col-md-8"><?php echo ": <u>".$data->jumlah."</u>"; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4"><b><?php echo "Rata-rata"; ?></b></div>
                        <div class="col-md-8"><?php echo ": <b>".$data->nilairatarata."</b>"; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-6"><b><?php echo "Nilai Prilaku Kerja"; ?></b></div>
                        <div class="col-md-6">40 % : <b><?php echo $data->nilaiPerilakuKerja; ?></b></div>
                      </div>
                      <div class="row">
                        <h5>
                        <div class="col-md-7 text-primary"><b><?php echo "NILAI PRESTASI KERJA"; ?></b></div>
                        <div class="col-md-5 text-primary"><b><?php echo $data->nilaiPrestasiKerja; ?></b></div>
                        </h5>
                      </div>
		      <?php 
		      if ($data->jenisPeraturanKinerjaKd == "PP46") {
		      ?>
		      <div class="row">
                        <div class="col-md-7 text-warning"><b><?php echo "NILAI KONVERSI"; ?></b></div>
                        <div class="col-md-5 text-warning"><b><?php echo $data->konversiNilai; ?></b></div>
                      </div>
		      <?php
		      } else if ($data->jenisPeraturanKinerjaKd == "PP30") {
		      ?>
  	 	      <div class="row">
                        <div class="col-md-7 text-success"><b><?php echo "NILAI INTEGRASI"; ?></b></div>
                        <div class="col-md-5 text-success"><b><?php echo $data->nilaiIntegrasi; ?></b></div>
                      </div>
		      <?php
		      }
		      ?>

                      <br/><b>PEJABAT PENILAI</b>
                      <div class="row">
                        <div class="col-md-2"><?php echo "NIP"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$data->penilaiNipNrp; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Nama"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$data->penilaiNama; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Unit"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$data->penilaiUnorNama; ?></div>
                      </div>

                      <br/><b>ATASAN PEJABAT PENILAI</b>
                      <div class="row">
                        <div class="col-md-2"><?php echo "NIP"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$data->atasanPenilaiNipNrp; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Nama"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$data->atasanPenilaiNama; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><?php echo "Unit"; ?></div>
                        <div class="col-md-10"><?php echo ": ".$data->atasanPenilaiUnorNama; ?></div>
                      </div>
                    <?php
                    echo "</div>
                          </div>
                        </div>";

                    
                  }
                  ?>
                  </div>
                </div>
              </div>
              <!-- .panel-body -->
            </div> <!-- End Column Data SAPK-->
          </div><!-- End Row -->
          </small>
        </div> <!-- End Modal Body -->
      </div> <!-- End Modal Content -->
    </div> <!-- End Modal Dialog -->
  </div><!-- End Modal Tampil data BKN-->
<?php
}
?>
