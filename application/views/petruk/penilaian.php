<?php
	// nilai kinerja
	$kinerja = isset($kinerja->nilai_skp) ? $kinerja->nilai_skp : 0;
	// presentase kehadiran
	$hitung_persentase = isset($absen->realisasi) ? $absen->realisasi : 0;

?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3><b><i class="text-success glyphicon glyphicon-thumbs-up"></i> Penilaian Instrumen Kinerja</b></h3> <b><?= namagelar($peg->gelar_depan, $peg->nama, $peg->gelar_belakang) ?></b> (NIP. <?= polanip($peg->nip) ?>) - <b><?= $this->mpegawai->namajabnip($peg->nip) ?></b> <hr>
			<?php
				if($this->session->flashdata('msg') <> ''):
					echo '
						<div class="alert alert-danger">
						
						<h3>Danger!</h3>
							'.$this->session->flashdata('msg').'
						</div>
					';
				endif;
			?>
			<?= form_open(base_url('petruk/simpan_penilaian')) ?>
			<input type="hidden" value="<?= base64_encode($peg->nip) ?>" name="nip">
			<input type="hidden" value="<?= base64_encode($peg->fid_unit_kerja) ?>" name="unit_kerja">
			<table class="table table-bordered" style="background:#fff;line-height:1.6em;">
			<thead>
				<tr bgcolor="#34ee55">
						<th width="100"><b>INDIKATOR</b></th>
						<th width="150"><b>KRITERIA / SUB INDIKATOR</b></th>
						<th width="100" class="text-center" ><b>NILAI / SKOR</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><h4><b>Kinerja</b></h4></td>
					<td>
						<h4>Nilai e-Kinerja bulan <b>Maret</b> 2021 dengan kriteria <i style="border-bottom:1px solid #000;">></i> 85</h4>
						<span class="text-danger"> Nilai e-Kinerja Maret 2021: <b>(<?= $kinerja ?>)</b></span>
					</td>
					<td class="text-center"><?= $kinerja !== 0 ? "<h4>10</h4>" : "<h4>0</h4>"; ?> </td>
					<input type="hidden" value="<?= $kinerja !== 0 ? base64_encode(10) : base64_encode(0); ?>" name="skor_kinerja">
					
				</tr>
				<tr>
					<td><h4><b>Disiplin</b></h4></td>
					<td>
						<h4>Persentase tingkat kehadiran pegawai yang bersangkutan, apabila memenuhi kriteria <i style="border-bottom:1px solid #000;">></i> 95%</h4>
						<span class="text-danger"> Presentase Kehadiran Maret 2021: <b>(<?= $hitung_persentase."%" ?>)</b></span>		
					</td>
					<td class="text-center"><?= $hitung_persentase >= 95 ? "<h4>10</h4>" : "<h4>0</h4>"; ?></td>
					<input type="hidden" value="<?= $hitung_persentase >= 95 ? base64_encode(10) : base64_encode(0); ?>" name="skor_absensi">
				</tr>
				<tr>
					<td><h4><b>Inovasi/Lainnya</b></h4> </td>
					<td>
							
							<textarea rows="4" class="form-control" placeholder="Masukan nama inovasi beserta keterangan dari inovasi tersebut..." id="nama_inovasi" name="nama_inovasi"></textarea>
							<small id="nama_inovasi" class="form-text text-muted">Contoh: <b>Si Midun Chatting Ke Faskes</b> (Strategi Kemitraan Dukun Kampung dan Bidan Cegah Stunting yang merujuk ke Fasilitas Kesehatan, tahun 2018.) </small>
							<hr>
							<p class="text-danger ">Selain berkaitan dengan inovasi bentuk lainnya yang bisa dimasukan dalam penilaian melalui sistem ini adalah khususnya bagi Jabatan Fungsional Tertentu yang memiliki prestasi tingkat regional ataupun nasional sesuai dengan jabatannya.</p>
							<?php echo form_error('nama_inovasi'); ?>
						
						<h5>Keterangan:</h5>
						<ol type="A" style="font-size:16px;">
							<li><b>Nilai 10</b> diberikan apabila inovasi ada pada SKPD yang bersangkutan, namun tidak dilakukan tindaklanjut sehingga belum bisa dimanfaatkan ke pihak lain 
							yang memerlukan.</li>
							<li><b>Nilai 20</b> diberikan apabila inovasi ada pada SKPD yang bersangkutan, hanya dapat dimanfaatkan oleh individu yang bersangkutan karena alasan tersentu.</li>
							<li><b>Nilai 30</b> diberikan apabila inovasi ada pada SKPD yang bersangkutan, bisa memberikan manfaat bagi seluruh pegawai lingkup SKPD tersebut.</li>
							<li><b>Nilai 40</b> diberikan apabila inovasi yang ada mampu memberikan manfaat bagi seluruh SKPD ataupun masyarakat secara umum, sehingga mampu mendorong kinerja pegawai, kesejahteraan masyarakat.</li>
						</ol>
					</td>
					<td class="text-center bg-danger">
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios1">
						    <h4>10</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_inovasi" id="exampleRadios1" value="<?= base64_encode(10) ?>">
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios2">
						    <h4>20</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_inovasi" id="exampleRadios2" value="<?= base64_encode(20) ?>">
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios3">
						    <h4>30</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_inovasi" id="exampleRadios3" value="<?= base64_encode(30) ?>">
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios4">
						    <h4>40</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_inovasi" id="exampleRadios4" value="<?= base64_encode(40) ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td><h4><b>Perilaku</b></h4></td>
					<td>
						<h4>Nilai e-Perilaku Tahun 2020 pegawai yang bersangkutan apabila memenuhi nilai <i style="border-bottom:1px solid #000;">></i> 76</h4>
						<span class="text-danger"> Nilai Perilaku Tahun 2020: <b>(<?= isset($perilaku->nilai_prilaku_kerja) ? $perilaku->nilai_prilaku_kerja : "Riwayat SKP tidak ditemukan" ?>)</b></span>
					</td>
					<td class="text-center"><?= isset($perilaku->nilai_prilaku_kerja) >= 76 ? "<h4>10</h4>" : "<h4>0</h4>"; ?></td>
					<input type="hidden" value="<?= isset($perilaku->nilai_prilaku_kerja) >= 76 ? base64_encode(10) : base64_encode(0); ?>" name="skor_perilaku">
				</tr>
				<tr>
					<td><h4><b>Team Work</b></h4></td>
					<td><h4>Nilai berada pada range 10-30, secara objektif dilakukan oleh Kepala SKPD yang bersangkutan sesuai dengan kriteria yang telah ditentukan.</h4></td>
					<td class="text-center bg-danger">
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios5">
						    <h4>10</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_teamwork" id="exampleRadios5" value="<?= base64_encode(10) ?>">
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios6">
						    <h4>15</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_teamwork" id="exampleRadios6" value="<?= base64_encode(15) ?>">
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="exampleRadios7">
						    <h4>20</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_teamwork" id="exampleRadios7" value="<?= base64_encode(20) ?>">
						</div>
						<div class="form-check">
							<label class="form-check-label" for="exampleRadios8">
						    <h4>25</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_teamwork" id="exampleRadios8" value="<?= base64_encode(25) ?>">
						</div>
						<div class="form-check">
							<label class="form-check-label" for="exampleRadios9">
						    <h4>30</h4>
						  </label>
						  <input class="form-check-input" type="radio" name="skor_teamwork" id="exampleRadios9" value="<?= base64_encode(30) ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td  rowspan="2"><h4><b>Data Dukung</b></h4></td>
					<td colspan="2"><h4>Apabila ada dokumentasi berkaitan dengan pelaksanaan penilaian pegawai yang bersangkutan misal rapat, wawancara, atau yang lainnya dapat juga disertakan dan menjadi tambahan data dukung yang dikirim melalui email <a href="mailto:sukiman2580@gmail.com"><i>sukiman2580@gmail.com<i></a></h4></td>
				</tr>
				<tr>
					<td colspan="2"><h4>Apabila penilaian telah selesai dilaksanakan melalui sistem, simpan hasil penilaian dan cetak hasilnya, ditandatangani Kepala SKPD yang bersangkutan kemudian diserahkan <i>by email</i> Ke Badan Kepegawaian Pendidikan dan Pelatihan Daerah Kabupaten Balangan atas nama <a href="mailto:sukiman2580@gmail.com"><i>sukiman2580@gmail.com<i></a></h4></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" onclick="return confirm('Apakah anda yakin penilaian sudah benar & telah selesai?')" class="btn btn-lg btn-block btn-success">Simpan Penilaian</button></td>
					<td><button type="button" onclick="window.history.back(-1)" class="btn btn-lg btn-block btn-danger">Batalkan</button></td>
				</tr>
			</tbody>
			</table>
			<?= form_close() ?>
		</div>
	</div>
</div>