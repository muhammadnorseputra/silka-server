<?php
	// nilai kinerja
	$kinerja = isset($kinerja->nilai_skp) ? $kinerja->nilai_skp : 0;

?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h3><b><i class="text-success glyphicon glyphicon-thumbs-up"></i> Penilaian Instrumen Kinerja 2024</b></h3> <b><?= namagelar($peg->gelar_depan, $peg->nama, $peg->gelar_belakang) ?></b> (NIP. <?= polanip($peg->nip) ?>) - <b><?= $this->mpegawai->namajabnip($peg->nip) ?></b> <hr>
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
			<?= form_open(base_url('petruk/simpan_penilaian_2024')) ?>
			<input type="hidden" value="<?= base64_encode($peg->nip) ?>" name="nip">
			<input type="hidden" value="<?= base64_encode($peg->fid_unit_kerja) ?>" name="unit_kerja">
			<table class="table table-bordered table-hover" style="background:#fff;line-height:1.6em;">
			<thead>
				<tr bgcolor="#34ee55">
						<th width="40%"><b>INDIKATOR</b></th>
						<th width="20%"><b>KETERANGAN SUB INDIKATOR</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><h4><b>Surat Usulan</b></h4></td>
					<td>
						<select name="surat_usulan" id="surat_usulan" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><h4><b>Dafta Riwayat Hidup</b></h4></td>
					<td>
						<select name="daftar_riwayat_hidup" id="daftar_riwayat_hidup" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><h4><b>SK Pangkat Terakhir</b></h4></td>
					<td>
						<select name="sk_pangkat_terakhir" id="sk_pangkat_terakhir" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><h4><b>SK Jabatan Terakhir</b></h4>(Optional)</td>
					<td>
						<select name="sk_jabatan_terakhir" id="sk_jabatan_terakhir" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>			
				<tr>
					<td><h4><b>Penilaian Kinerja</b></h4>Penilaian Kinerja Tahun 2022 & 2023 Minimal BAIK</td>
					<td>
						<select name="penilaian_kinerja" id="penilaian_kinerja" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><h4><b>Sertifikat / Piagam Penghargaan</b></h4>(Optional)</td>
					<td>
						<select name="is_sertifikat" id="is_sertifikat" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>	
				<tr>
					<td><h4><b>Rekapitulasi Daftar Hadir</b></h4></td>
					<td>
					<h4><?= $absen."%" ?></h4>
					<?= $absen_info ?>
					<input type="hidden" value="<?= base64_encode($absen) ?>" name="absensi">
					</td>
				</tr>	
				<tr>
					<td><h4><b>Hukdis</b></h4>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin</td>
					<td>
					<select name="super_hukdis" id="super_hukdis" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>		
				<tr>
					<td><h4><b>Proposal Inovasi</b></h4></td>
					<td>
					<select name="proposal_inovasi" id="proposal_inovasi" class="form-control">
							<option value="" selected>-- Pilih Keterangan --</option>
							<option value="ADA">ADA</option>
							<option value="TIDAK ADA">TIDAK ADA</option>
						</select>
					</td>
				</tr>		
				<tr>
					<td colspan="2"><h4><b>Unggah Dokumen</b></h4>
					<a href="//bit.ly/dokumenASNberprestasiblg2024" target="_blank"> bit.ly/dokumenASNberprestasiblg2024</a>
					<!-- <textarea row="10" name="link_eviden" id="link_eviden" class="form-control" placeholder="Pastekan Link Doumen Disini ..."></textarea> -->
					</td>
				</tr>							
				<!-- <tr>
					<td><h4><b>Kinerja</b></h4></td>
					<td>
					<h4>Pilih Predikat SKP Tahun 2023</h4>
						<select name="kinerja" id="kinerja" class="form-control">
							<option value="">-- Pilih Predikat Kinerja --</option>
							<option value="SANGAT BAIK">SANGAT BAIK</option>
							<option value="BAIK">BAIK</option>
							<option value="BUTUH PERBAIKAN">BUTUH PERBAIKAN</option>
							<option value="KURANG">KURANG</option>
							<option value="SANGAT KURANG">SANGAT KURANG</option>
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
					<td><h4><b>Sertifikasi/Lainnya</b></h4> </td>
					<td>	
						<select name="sertifikasi" id="sertifikasi" class="form-control">
							<option value="">-- Pilih Tingkat Sertifikasi --</option>
							<option value="TINGKAT NASIONAL">TINGKAT NASIONAL</option>
							<option value="TINGKAT PROVINSI">TINGKAT PROVINSI</option>
							<option value="TINGKAT KABUPATEN">TINGKAT KABUPATEN</option>
						</select>
						<h4>Silahkan pilih sertifikasi/piagam/bentuk lainnya sesuai tingkat.</h4>
					</td>
				</tr> -->
				<tr>
					<td><button type="button" onclick="window.history.back(-1)" class="btn btn-lg btn-danger">Batalkan</button></td>
					<td><button type="submit" onclick="return confirm('Apakah anda yakin penilaian sudah benar & telah selesai?')" class="btn btn-lg btn-block btn-success">Simpan Penilaian</button></td>
				</tr>
			</tbody>
			</table>
			<?= form_close() ?>
		</div>
	</div>
</div>