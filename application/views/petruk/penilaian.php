<?php
	// nilai kinerja
	$kinerja = isset($kinerja->nilai_skp) ? $kinerja->nilai_skp : 0;

?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
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
						<th width="10%"><b>INDIKATOR</b></th>
						<th width="150%"><b>KRITERIA / SUB INDIKATOR</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><h4><b>Kinerja</b></h4></td>
					<td>
					<h4>Pilih Predikat SKP Tahun 2022</h4>
						<select name="kinerja" id="kinerja" class="form-control">
							<option value="">-- Pilih Predikat Kinerja --</option>
							<option value="SANGAT KURANG">SANGAT KURANG</option>
							<option value="KURANG">KURANG</option>
							<option value="BUTUH PERBAIKAN">BUTUH PERBAIKAN</option>
							<option value="BAIK">BAIK</option>
							<option value="SANGAT BAIK">SANGAT BAIK</option>
						</select>
						<hr>
						<h4>Merupakan nilai SKP Tahunan bedasarkan predikat kinerja yang diberikan oleh pejabat penilai kinerja. Predikat Kinerja yang dipersyaratkan minimal <b> BAIK</b>.</h4>
						
					</td>
				</tr>
				<tr>
					<td><h4><b>Disiplin</b></h4></td>
					<td>
						<h4>Persentase tingkat kehadiran pegawai yang bersangkutan, dalam 3 bulan terkahir :
							<span class="text-success font-bold"><b>(<?= $absen."%" ?>)</b></span>	</h4>	
						<div class="text-info"><?= $absen_info ?></div>
						<input type="hidden" value="<?= base64_encode($absen) ?>" name="absensi">
					</td>
				</tr>
				<tr>
					<td><h4><b>Inovasi/Lainnya</b></h4> </td>
					<td>	
						<h4>Berikan <b>Nama Inovasi</b> serta <b>Deskripsi secara ringkas dan jelas</b>  dari inovasi tersebut</h4>
							<textarea rows="4" maxlength="500" class="form-control" placeholder="Masukan nama inovasi beserta deskripsi dari inovasi tersebut..." id="nama_inovasi" name="nama_inovasi"></textarea>
							<p id="nama_inovasi" class="form-text text-danger">Max: 500 Karakter </p>
							<p id="nama_inovasi" class="form-text text-info">Contoh: <b>Si Midun Chatting Ke Faskes</b> (Strategi Kemitraan Dukun Kampung dan Bidan Cegah Stunting yang merujuk ke Fasilitas Kesehatan, tahun 2018.) </p>
					</td>
				</tr>
				<tr>
					<td><h4><b>Team Work</b></h4></td>
					<td>
						<h4>Untuk Penilaian Team Work, silahkan pilih.</h4>
						<select name="timwork" id="timwork" class="form-control">
							<option value="">-- Pilih Penilaian Team Work --</option>
							<option value="Tidak bisa bekerja sama">Tidak bisa bekerja sama</option>
							<option value="Cukup mudah bekerja sama">Cukup mudah bekerja sama</option>
							<option value="Mudah bekerja sama">Mudah bekerja sama</option>
							<option value="Sangat mudah bekerja sama">Sangat mudah bekerja sama</option>
						</select>
					</td>
				</tr>
				<tr>
					<td  rowspan="2"><h4><b>Data Dukung</b></h4></td>
					<td>
						<h4>Kelengkapan Data Dukung Calon ASN Berprestasi</h4>
						<ol type="A" style="font-size:16px;">
							<li><b>SK Pangkat Terakhir</b></li>
							<li><b>SK Jabatan Terakhir bagi yang Menjabat</b> </li>
							<li><b>Sasaran Kinerja Pegawai Tahun Terakhir</b> </li>
							<li><b>Hasil Cetak Usulan ASN yang ditandatangani oleh Kepala Perangkat Daerah</b> </li>
							<li><b>Sertificate atau Piagam Penghargaan</b> </li>
							<li><b>Surat Kepala Perangkat Darah yang menerangkan bahwa pegawai ASN yang diusulkan tidak dalam proses atau sedang menjalani hukuman disiplin tingkat berat, sedang dan ringan.</b> </li>
							<li><b>Proposal.</b> </li>
						</ol>
					</td>
				</tr>
				<tr>
					<td><h4>Apabila penilaian telah selesai dilaksanakan melalui sistem, simpan hasil penilaian dan cetak hasilnya, ditandatangani Kepala SKPD yang bersangkutan kemudian dikirimkan ke Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten Balangan dengan link drive <a href="https://bit.ly/DATACALONASNBERPRESTASI" target="_blank"><i>https://bit.ly/DATACALONASNBERPRESTASI<i></a></h4></td>
				</tr>
				<tr>
					<td><button type="button" onclick="window.history.back(-1)" class="btn btn-lg btn-block btn-danger">Batalkan</button></td>
					<td><button type="submit" onclick="return confirm('Apakah anda yakin penilaian sudah benar & telah selesai?')" class="btn btn-lg btn-block btn-success">Simpan Penilaian</button></td>
				</tr>
			</tbody>
			</table>
			<?= form_close() ?>
		</div>
	</div>
</div>