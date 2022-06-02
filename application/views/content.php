<!--
<div class="col-md-4 col-md-offset-4" style="margin-top:5%">	
	<center>
		<div class="btn-info btn-lg">
			<h2>::: SILKa Online :::</h2>
			<h4>Sistem Informasi dan Layanan Kepegawaian</h4><h5>Badan Kepegawaian, Pendidikan dan Pelatihan Daerah<br />Kabupaten Balangan</h5>
		</div>
	</center>
</div>
-->

<!--
<div class="col-md-6 col-md-offset-3" style="margin-top:0%">
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" 
  <?php
      echo "<img src=".base_url()."assets/idulfitri1438-600.jpg>";
      ?>        
  ></iframe>
</div>
</div>

<div class="col-md-8 col-md-offset-2" style="margin-top:2%">
	<center>
		<div class="btn-danger btn-lg">
			<h5>UJI COBA Fitur Terbaru SILKa Online: <ins>Update atau Edit Data Riwayat SKP.</ins><br/>Sekarang anda dapat melakukan perubahan atau edit data riwayat SKP, caranya klik tombol Edit pada form Riwayat SKP.</h5>
		</div>
	</center>
</div>
-->

<div class="row">
	<div class="col-md-4 col-md-offset-4" style="margin-top:10%">
		<center>
			<?php
                             $nip = $this->session->userdata('nip');
                             $jnskel = $this->mpegawai->getjnskel($nip);
                             if ($jnskel == 'LAKI-LAKI') {
                             	$warna = 'btn-info btn-lg';
			     } else if ($jnskel == 'PEREMPUAN') {
                        	$warna = 'btn-warning btn-lg';
			     }
			?>

			<div class="<?php echo $warna ?>">
				<?php 
		            		$nip = $this->session->userdata('nip');
		            		$nama = $this->mpegawai->getnama($nip);
				/*	$jnskel = $this->mpegawai->getjnskel($nip);
					$statkawin = $this->mpegawai->getstatkawinpns($nip);
					if ($jnskel == 'LAKI-LAKI') {
						if ($statkawin == 'BELUM KAWIN') {
							$pg = 'Mas';
						} else {
							$pg = 'Bapak';
						}
						$sebutan = 'ganteng';
					} else if ($jnskel == 'PEREMPUAN') {
						if ($statkawin == 'BELUM KAWIN') {
                                                        $pg = 'Mba';
                                                } else {
                                                        $pg = 'Ibu';
                                                }
						$sebutan = 'cantik';
					}
				*/
		            		echo "<h5>Anda Login sebagai ".$nama."</h5>";
				//	echo "<h4>Hai, ".$pg." ".$nama."</h4>";
	            		//	echo "<h5>Anda terlihat <b>".$sebutan."</b> hari ini. Semoga hari-hari anda penuh berkah dan menyenangkan bersama kami.</h5>";
				?>
			        
				<h2>::: SILKa :::</h2>
				<h5>Sistem Informasi dan Layanan Kepegawaian</h5><h4>BKPSDM Kabupaten Balangan</h4>
			</div>
		</center>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--<div class="modal-header">-->
      <!--  <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>-->
      <!--</div>-->
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="glyphicon glyphicon-remove"></i></button>
        <h3>Pengumuman Terbaru</h3>
	<div align='left'>
		<blockquote>
                Import Data Absensi dan Nilai SKP Bulanan hanya dapat dilakukan pada tanggal 1 s/d 5 setiap bulan.
		<br/>
		<small>
		Selain tanggal 1 s/d 5, maka form Import Absensi dan Import Kinerja tidak dapat ditampilkan.
		</small>
		</blockquote>
	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
	
<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
 data-keyboard="false">
	<div class="modal-dialog modal-lg" style="width:90%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Team Survey SILKa</h4>
			</div>
			<?= form_open('home/simpanSurvey', array('id' => 'formSurvey')) ?>
			<input type="hidden" name="nip_survey" value="<?= $this->session->userdata('nip'); ?>">
			<div class="modal-body" id="ModalSurvey">
				
				<!-- SAMBUTAN -->
				<div class="text-center" id="wel">
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
								<h1>Hai, "<?= $this->session->userdata('nama') ?>"</h1><hr>
								<p class="text-center">
									<img src="<?= base_url('assets/icon-survey.png') ?>" width="240" alt="">
									<br>
									Saat ini kami sedang melakukan survei terhadap penggunaan aplikasi SILKa Online. <br/>Survey ini sangat diperlukan dalam rangka pengumpulan informasi sebagai bahan untuk pengembangan SILKa Online kedepan. Survei terdiri atas <?= $this->Mapi->jmlPertanyaan() ?> pertanyaan dalam 3 bagian :<br> <b>HARAPAN (<?= $this->Mapi->jmlJenis('HARAPAN') ?>), KENYATAAN (<?= $this->Mapi->jmlJenis('KENYATAAN') ?>), KEPUASAN (<?= $this->Mapi->jmlJenis('KEPUASAN') ?>)</b>
									<br/><br/>Survei dilakukan hanya 1 kali untuk setiap user sesaat setelah berhasil Login.<br/>Hasil survei yang telah disimpan tidak dapat dirobah atau diulang kembali.
									<br/><br/>Pendapat anda  menentukan masa depan SILKa Online.
									<br/>HAVE A NICE DAY, DON'T FORGET TOBE HAPPY.
								</p>
								<br>
								<button type="button" onclick="openSurvey()" class="btn btn-lg btn-primary text-center">Mulai Sekarang <em class="glyphicon glyphicon-edit"></em></button>
							
						</div>
					</div>
				</div>

				<!-- PENUTUP -->
				<div class="text-center" id="finish" style="display:none;">
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
								<h1>Terimakasih "<?= $this->session->userdata('nama') ?>"</h1><hr>
								<p class="text-center">
									<!-- <img src="<?= base_url('assets/icon-survey.png') ?>" width="120" alt=""> -->
									<br>
									Anda telah menyelesaikan survey secara keseluruhan, 
									partisipasi anda sangat berguna bagi kami
								</p>
								<br>
								<button type="button" onclick="closeSurvey()" class="btn btn-lg btn-primary text-center">Selesai <em class="glyphicon glyphicon-share-alt"></em></button>
							
						</div>
					</div>
				</div>

				<!-- SURVEY -->
				<div class="tab-content" style="display:none;">
				<blockquote class="info">
					<b>
						<em class="glyphicon glyphicon-exclamation-sign"></em>
						Pengisikan survey hanya dapat dilakukan 1 kali & tidak bisa diubah, jadi periksa kembali secara keseluruhan sebelum disimpan.
					</b>
				</blockquote>

					<div role="tabpanel" class="tab-pane fade in active" id="harapan">
						<blockquote>
							<b>
								<em class="glyphicon glyphicon-th"></em>
								Survey Harapan
							</b>
						</blockquote>

						<table id="mySurvey" class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th style="background:teal;text-align:center; color:#fff;">Quisioner</th>
									<th style="background:grey; text-align:center; color:#fff;">Responses</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$harapan = $this->Mapi->get_pertanyaan('HARAPAN');
									$no=1;
									foreach($harapan as $p){
								?>
								<tr>
									<td width="650">
										<span class="number">
											<?= $no ?>
										</span>
										<b class="pertanyaan">
											<?= $p->pertanyaan ?>
										</b>
									</td>
									<td>
										<input type="hidden" name="idpertanyaan[]" value="<?= $p->id ?>">
										<!-- Pilihan sangat tidak penting -->
										<label class="radio-inline" for="optionsRadios1<?= $p->id ?>">
											<input type="radio" name="mySurvey<?= $p->id ?>" id="optionsRadios1<?= $p->id ?>" value="Sangat Tidak Penting">
											<span style="position:relative; top:3px;">Sangat Tidak Penting</span>
										</label>
										<!-- Pilihan Tidak Penting -->
										<label class="radio-inline" for="optionsRadios2<?= $p->id ?>">
											<input type="radio" name="mySurvey<?= $p->id ?>" id="optionsRadios2<?= $p->id ?>" value="Tidak Penting">
											<span style="position:relative; top:3px;">Tidak Penting</span>
										</label>
										<!-- Pilihan Biasa -->
										<label class="radio-inline" for="optionsRadios3<?= $p->id ?>">
											<input type="radio" name="mySurvey<?= $p->id ?>" id="optionsRadios3<?= $p->id ?>" value="Biasa">
											<span style="position:relative; top:3px;">Biasa</span>
										</label>
										<!-- Pilihan Penting -->
										<label class="radio-inline" for="optionsRadios4<?= $p->id ?>">
											<input type="radio" name="mySurvey<?= $p->id ?>" id="optionsRadios4<?= $p->id ?>" value="Penting">
											<span style="position:relative; top:3px;">Penting</span>
										</label>
										<!-- Pilihan Sangat Penting -->
										<label class="radio-inline" for="optionsRadios5<?= $p->id ?>">
											<input type="radio" name="mySurvey<?= $p->id ?>" id="optionsRadios5<?= $p->id ?>" value="Sangat Penting">
											<span style="position:relative; top:3px;">Sangat Penting</span>
										</label>
									</td>
								</tr>
								<?php $no++;} ?>
							</tbody>
						</table>
						<hr>
						<a href="#real" class="btn btn-primary btn-sm text-center pull-right" role="tab" data-toggle="tab">&nbsp; &nbsp; SELANJUTNYA <em class="glyphicon glyphicon-chevron-right"></em> &nbsp; &nbsp;</a>
						
						<div class="clearfix"></div>
					
					</div>

					<div role="tabpanel" class="tab-pane fade" id="real">

						<blockquote>
							<b>
							<em class="glyphicon glyphicon-th"></em>
								Survey Kenyataan
							</b>
						</blockquote>
						<table id="mySurvey" class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th style="background:teal;text-align:center; color:#fff;">Quisioner</th>
									<th style="background:grey; text-align:center; color:#fff;">Responses</th>
								</tr>
							</thead>
							<tbody>
								<?php 
										$real = $this->Mapi->get_pertanyaan('KENYATAAN');
										$no=18;
										foreach($real as $r){
								?>
								<tr>
									<td width="650">
										<span class="number">
											<?= $no ?>
										</span>
										<b class="pertanyaan">
											<?= $r->pertanyaan ?>
										</b>
									</td>
									<td>
										<input type="hidden" name="idpertanyaan[]" value="<?= $r->id ?>">
										<!-- Pilihan sangat tidak Setuju -->
										<label class="radio-inline" for="optionsRadios6<?= $r->id ?>">
											<input type="radio" name="mySurvey<?= $r->id ?>" id="optionsRadios6<?= $r->id ?>" value="Sangat Tidak Setuju">
											<span style="position:relative; top:3px;">Sangat Tidak Setuju</span>
										</label>
										<!-- Pilihan Tidak Setuju -->
										<label class="radio-inline" for="optionsRadios7<?= $r->id ?>">
											<input type="radio" name="mySurvey<?= $r->id ?>" id="optionsRadios7<?= $r->id ?>" value="Tidak Setuju">
											<span style="position:relative; top:3px;">Tidak Setuju</span>
										</label>
										<!-- Pilihan Biasa -->
										<label class="radio-inline" for="optionsRadios8<?= $r->id ?>">
											<input type="radio" name="mySurvey<?= $r->id ?>" id="optionsRadios8<?= $r->id ?>" value="Biasa">
											<span style="position:relative; top:3px;">Biasa</span>
										</label>
										<!-- Pilihan Setuju -->
										<label class="radio-inline" for="optionsRadios9<?= $r->id ?>">
											<input type="radio" name="mySurvey<?= $r->id ?>" id="optionsRadios9<?= $r->id ?>" value="Setuju">
											<span style="position:relative; top:3px;">Setuju</span>
										</label>
										<!-- Pilihan Sangat Setuju -->
										<label class="radio-inline" for="optionsRadios10<?= $r->id ?>">
											<input type="radio" name="mySurvey<?= $r->id ?>" id="optionsRadios10<?= $r->id ?>" value="Sangat Setuju">
											<span style="position:relative; top:3px;">Sangat Setuju</span>
										</label>

									</td>
								</tr>
								<?php $no++;} ?>
							</tbody>
						</table>
						<hr>
						<a href="#harapan" class="btn btn-danger btn-sm" role="tab" data-toggle="tab">&nbsp; &nbsp;<em class="glyphicon glyphicon-chevron-left"></em>
							SEBELUMNYA &nbsp; &nbsp;</a>
						<a href="#kepuasan" class="btn btn-primary btn-sm pull-right" role="tab" data-toggle="tab">&nbsp; &nbsp;SELANJUTNYA <em class="glyphicon glyphicon-chevron-right"></em>&nbsp; &nbsp;</a>
					
						<div class="clearfix"></div>
						
					</div>

					<div role="tabpanel" class="tab-pane fade" id="kepuasan">
						<blockquote>
							<b>
							
							<em class="glyphicon glyphicon-th"></em>
								Survey Kepuasan
							</b>
						</blockquote>
						<table id="mySurvey" class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th style="background:teal;text-align:center; color:#fff;">Quisioner</th>
									<th style="background:grey; text-align:center; color:#fff;">Responses</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$real = $this->Mapi->get_pertanyaan('KEPUASAN');
								$no=29;
								foreach($real as $v){
						?>
								<tr>
									<td width="650">
										<span class="number">
											<?= $no ?></span>
										<b class="pertanyaan">
											<?= $v->pertanyaan ?></b>
									</td>
									<td>
										<input type="hidden" name="idpertanyaan[]" value="<?= $v->id ?>">
										<?php if($v->id == 36){ ?>
										<div class="input-group col-md-10 pull-left">
											<input type="text" name="mySurvey<?= $v->id ?>" class="form-control">
										</div>
										<?php } elseif($v->id == 37) { ?>
										<div class="input-group col-md-2 pull-left">
											<select class="form-control" name="mySurvey<?= $v->id ?>">
											<option value="null">#</option>
											<option value="1">1 (Kurang)</option>
											<option value="2">2 (Kurang)</option>
											<option value="3">3 (Kurang)</option>
											<option value="4">4 (Kurang)</option>
											<option value="5">5 (Sedang)</option>
											<option value="6">6 (Sedang)</option>
											<option value="7">7 (Sedang)</option>
											<option value="8">8 (Sedang)</option>
											<option value="9">9 (Tinggi)</option>
											<option value="10">10 (Tinggi)</option>
										</select>											
										</div>
										<?php } elseif($v->id == 38){ ?>
										<div class="input-group col-md-12 pull-left">
											<input type="text" name="mySurvey<?= $v->id ?>" class="form-control">
										</div>
										<?php } elseif($v->id == 35){ ?>
										<select class="form-control" name="mySurvey<?= $v->id ?>" id="mySurvey35" onchange="proses()">
											<option value="null">#</option>
											<option value="Info dan peremajaan data Non PNS">Info dan peremajaan data Non PNS</option>
											<option value="Laporan Kepegawaian">Laporan Kepegawaian</option>
											<option value="Cuti">Cuti</option>
											<option value="Kenaikan Gaji Berkala">Kenaikan Gaji Berkala</option>
											<option value="Upload dokumen">Upload dokumen</option>
											<option value="Analisis Jabatan">Analisis Jabatan</option>
											<option value="Analisis Diklat">Analisis Diklat</option>
											
										</select>
										
										<?php } elseif($v->id == 34) {?>
										<!-- Pilihan 1 tahun -->
										<label class="radio-inline" for="optionsRadios11<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios11<?= $v->id ?>" value="1 Tahun">
											<span style="position:relative; top:3px;">1 Tahun</span>
										</label>
										<!-- Pilihan 6 Bulan -->
										<label class="radio-inline" for="optionsRadios12<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios12<?= $v->id ?>" value="6 Bulan">
											<span style="position:relative; top:3px;">6 Bulan</span>
										</label>
										<!-- Pilihan 3 Bulan -->
										<label class="radio-inline" for="optionsRadios13<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios13<?= $v->id ?>" value="3 Bulan">
											<span style="position:relative; top:3px;">3 Bulan</span>
										</label>
										<!-- Pilihan Kurang 3 Bulan -->
										<label class="radio-inline" for="optionsRadios14<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios14<?= $v->id ?>" value="Kurang 3 Bulan">
											<span style="position:relative; top:3px;">Kurang 3 Bulan</span>
										</label>
										<?php } elseif($v->id == 33) {?>
										<!-- Pilihan Sangat Responsif -->
										<label class="radio-inline" for="optionsRadios15<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios15<?= $v->id ?>" value="Sangat Responsif">
											<span style="position:relative; top:3px;">Sangat Responsif</span>
										</label>
										<!-- Pilihan Responsif -->
										<label class="radio-inline" for="optionsRadios16<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios16<?= $v->id ?>" value="Responsif">
											<span style="position:relative; top:3px;">Responsif</span>
										</label>
										<!-- Pilihan Kurang Responsif -->
										<label class="radio-inline" for="optionsRadios17<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios17<?= $v->id ?>" value="Kurang Responsif">
											<span style="position:relative; top:3px;">Kurang Responsif</span>
										</label>
										<!-- Pilihan Sama Sekali Tidak Responsif -->
										<label class="radio-inline" for="optionsRadios18<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios18<?= $v->id ?>" value="Sama Sekali Tidak Responsif">
											<span style="position:relative; top:3px;">Sama Sekali Tidak Responsif</span>
										</label>
										<?php } elseif($v->id == 32) {?>
										<select class="form-control" name="mySurvey<?= $v->id ?>">
											<option value="null">#</option>
											<option value="Berkualitas">Berkualitas</option>
											<option value="Bermanfaat">Bermanfaat</option>
											<option value="Praktis">Praktis</option>
											<option value="Bisa Diandalkan">Bisa Diandalkan</option>
											<option value="Efektif">Efektif</option>
											<option value="Efisien">Efisien</option>
											<option value="Unik / Tidak ada duanya">Unik / Tidak ada duanya</option>
											<option value="Biasa saja">Biasa saja</option>
										</select>
										<?php } elseif($v->id == 31) {?>
										<select class="form-control" name="mySurvey<?= $v->id ?>">
											<option value="null">#</option>
											<option value="Sangat Berkualitas">Sangat Berkualitas</option>
											<option value="Berkualitas">Berkualitas</option>
											<option value="Cukup Berkualitas">Cukup Berkualitas</option>
											<option value="Tidak Berkualitas">Tidak Berkualitas</option>
											<option value="Sangat Tidak Berkualitas">Sangat Tidak Berkualitas</option>
										</select>
										<?php } elseif($v->id == 30) {?>
										<!-- Pilihan Sangat Baik -->
										<label class="radio-inline" for="optionsRadios18<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios18<?= $v->id ?>" value="Sangat Baik">
											<span style="position:relative; top:3px;">Sangat Baik</span>
										</label>
										<!-- Pilihan Baik -->
										<label class="radio-inline" for="optionsRadios20<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios20<?= $v->id ?>" value="Baik">
											<span style="position:relative; top:3px;">Baik</span>
										</label>
										<!-- Pilihan Cukup Baik -->
										<label class="radio-inline" for="optionsRadios21<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios21<?= $v->id ?>" value="Cukup Baik">
											<span style="position:relative; top:3px;">Cukup Baik</span>
										</label>
										<!-- Pilihan Buruk -->
										<label class="radio-inline" for="optionsRadios22<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios22<?= $v->id ?>" value="Buruk">
											<span style="position:relative; top:3px;">Buruk</span>
										</label>
										<!-- Pilihan Sangat Buruk -->
										<label class="radio-inline" for="optionsRadios23<?= $v->id ?>">
											<input type="radio" name="mySurvey<?= $v->id ?>" id="optionsRadios23<?= $v->id ?>" value="Sangat Buruk">
											<span style="position:relative; top:3px;">Sangat Buruk</span>
										</label>
										<?php } elseif($v->id == 29) {?>
										<select class="form-control" name="mySurvey<?= $v->id ?>">
											<option value="null">#</option>
											<option value="Sangat Puas">Sangat Puas</option>
											<option value="Puas">Puas</option>
											<option value="Tidak puas dan tidak kecewa">Tidak puas dan tidak kecewa</option>
											<option value="Kecewa">Kecewa</option>
											<option value="Sangat Kecewa">Sangat Kecewa</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php $no++;} ?>
							</tbody>
						</table>
						<hr>
						<a href="#real" class="btn btn-danger btn-sm" role="tab" data-toggle="tab">&nbsp; &nbsp;<em class="glyphicon glyphicon-arrow-left"></em>
							SEBELUMNYA &nbsp; &nbsp;</a>
						<button type="submit" class="btn btn-success btn-sm pull-right">&nbsp; &nbsp;<em class="glyphicon glyphicon-floppy-disk"></em>
							SIMPAN SURVEY &nbsp; &nbsp;</button>
						<div class="clearfix"></div>

					</div>
				</div>

			</div>
			<?= form_close() ?>
			<!-- 
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div> -->
		</div>
	</div>
</div>
<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600" rel="stylesheet">
<style>
	blockquote,
	blockquote.info {
		margin: 0;
		margin-top: 10px;
		padding: .5em 1em;
		border-left: 5px solid #f6ebc1;
		background-color: #f6ebc1;
		font-family: 'Raleway', sans-serif;
	}
	
	blockquote.info {
		background: pink;
		border:1px solid red;
		font-size:14px;
		font-weight:normal;
		font-family: 'Raleway', sans-serif;
	}

	blockquote.info em {
		margin-right: 5px;
	}

	blockquote p {
		margin: 0;
		text-align: center;
		font-weight: normal;
		font-family: 'Raleway', sans-serif;
	}

	#wel, #finish {
		font-family: 'Raleway', sans-serif;
		font-size:14px;
	}

	#mySurvey thead tr th {
		padding: 15px 5px !important;
		font-family: 'Raleway', sans-serif;
	}

	#mySurvey tbody tr td {
		padding: 15px 5px !important;
	}

	#mySurvey tbody tr {
		/* border-left: 5px solid transparent; */
		/* transition: all .3s ease; */
		font-family: 'Raleway', sans-serif;
		color:#666;
	}

	#mySurvey tbody tr b.pertanyaan {
		font-size: 14px;
		position: relative;
		top: 5px;
	}

	#mySurvey tbody tr td span.number {
		width: 30px;
		height: 30px;
		padding-top: 6px;
		margin-right: 15px;
		border-radius: 50%;
		background: teal;
		color: #fff;
		text-align: center;
		display: inline-block;
		position: relative;
		transition: all .3s ease;
		transform: rotate(360deg);
		float: left;
	}

	#mySurvey tbody tr:hover td span.number {
		background: #222;
		color: rgba(253, 215, 3, 1);
		transform: rotate(-360deg);
	}

	#mySurvey tbody tr:hover {
		background: rgba(253, 215, 3, 0.5);
		/* border-left: 5px solid #222; */
		box-shadow: 0 0 2em #ccc;
		color:#000;
	}	

</style>

<script>
//	$(document).ready(function() {
//        $("#myModal").modal('show');
//    });
</script>

<script>

//function openSurvey() {
//	$("#ModalSurvey #wel").slideUp();
//	$(".tab-content").fadeIn();
//}

//function closeSurvey() {
//	$("#myModal").modal('hide');
//}

//function proses(){
//  var harga=document.getElementById("mySurvey35").value;
//	if(harga == 0){
//  	document.getElementById("inputLain").style.display = 'block';
//	} else {
//		document.getElementById("inputLain").style.display = 'none';
//	}
//	}

// function showHide(){
// var lainnya = $("#chcek");
// 	if(lainnya[0].checked){
// 		$("#inputLain").css('display', 'block');
// 		$("#mySurvey35").css('display', 'none');
// 	}
// 	if(!lainnya[0].checked){
// 		$("#inputLain").css('display', 'none');
// 		$("#mySurvey35").css('display', 'block').val('0');
// 	}
// }

//$(document).ready(function () {
//	cek_survey();
//	function cek_survey() {
//		var nip = $("[name='nip_survey']").val();
//		$.post('<?= base_url("home/cekSurvey") ?>', {
//			nipuser: nip
//		}, function (result) {			
//			if (result.length == 0) {
//				$("#myModal").modal('show');
//			} else if (result.length > 0) {
//				$("#myModal").modal('hide');
//			}
//		}, 'json');
//	}

//	$("#formSurvey").on('submit', function (e) {
//		e.preventDefault();
//		var form = $(this);		
//		if(form[0].mySurvey1.value == '') {
//			swal('error!', 'Harap isi semua survey', 'warning'); //pesan validasi kosong 	
//		} else {
//			$.ajax({
//				url: form.attr('action'),
//				method: 'POST',
//				data: form.serialize(),
//				dataType: 'json',
//				success: function (result) {
//					if (result.type == 'success') {
//						$("#finish").fadeIn('slow');
//						$(".tab-content").slideUp();
//					} else if (result.type == 'error') {
//						swal(result.type, result.content, result.type);
//					} else if (result.type == 'warning') {
//						swal(result.type, result.content, result.type);
//					}
//				},
//				error: function () {
//					swal('error!', 'error responses server', 'warning');
//				}
//			});
//		}
//	})
//});
</script>

<!--
<div class="row">
	<div class="col-md-8  col-md-offset-2" style="margin-top:5%;" align="center">
		<div class="btn-danger btn-lg">			
		<h5>UJI COBA Modul Terbaru SILKa Online LAYANAN KENAIKAN GAJI BERKALA.<br/>Sekarang usulan kenaikan gaji berkala dapat disampaikan dan diproses secara online pada SILKa Online melalui menu Gaji Berkala<br/>-- SELAMAT MENCOBA --</h5>
		</div>
	</div>	
</div>
-->
