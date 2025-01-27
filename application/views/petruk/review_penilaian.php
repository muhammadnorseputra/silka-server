<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<?php
					if($this->session->flashdata('msg') <> ''):
						echo '
							<div class="alert alert-success">
							
							<b>Success!</b><br>
								'.$this->session->flashdata('msg').'
							</div>
						';
					endif;
					
			?>
			<h3><i class="text-success glyphicon glyphicon-check"></i> Review Hasil Penilaian </h3>
			<b><?= namagelar($profile->gelar_depan, $profile->nama, $profile->gelar_belakang) ?></b> (NIP. <?= polanip($detail->nip) ?>) - <b><?= $this->mpegawai->namajabnip($detail->nip) ?></b>
			<hr>
			<?php if(date('Y') != '2024'): ?>
			<table class="table table-bordered">
				<tbody>
					<tr>	
						<td width="200"><h4>KINERJA</h4></td>
						<td width="10"><h4>:</h4></td>
						<td><h4><?= strtoupper($detail->predikat_kinerja) ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>DISIPLIN</h4></td>
						<td width="10"><h4>:</h4></td>
						<td><h4><?= strtoupper($detail->persentase_disiplin) ?>% (3 BULAN TERAKHIR)<h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>INOVASI</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-left"><h4><?= $detail->inovasi ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>TEAM WORK</h4></td>
						<td width="10"><h4>:</h4></td>
						<td><h4><?= strtoupper($detail->predikat_timwork) ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>DATA DUKUNG</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-left"><h4>Apabila penilaian telah selesai dilaksanakan melalui sistem, simpan hasil penilaian dan cetak hasilnya, ditandatangani Kepala SKPD yang bersangkutan kemudian dikirimkan ke Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten Balangan dengan link drive <a href="https://bit.ly/DATACALONASNBERPRESTASI" target="_blank"><i>https://bit.ly/DATACALONASNBERPRESTASI<i></a></h4></td>
					</tr>
					
					<tr>	
						<td colspan="3"><a target="_blank" href="<?= base_url('petruk/cetak_hasil_penilaian/'.$detail->fid_unit_kerja.'/'.$detail->nip) ?>" class="btn btn-lg btn-block btn-primary"><i class="glyphicon glyphicon-print"></i> Cetak Hasil Penilaian</a></td>
					</tr>
				</tbody>
			</table>
			<?php endif; ?>
			<table class="table table-bordered table-hover">
				<tbody>
					<tr>	
						<td width="70%"><h4><b>SURAT USULAN</b></h4></td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->surat_usulan) ?><h4></td>
					</tr>
					<tr>	
						<td width="70%"><h4><b>DAFTAR RIWAYAT HIDUP</b></h4></td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->daftar_riwayat_hidup) ?><h4></td>
					</tr>
					<tr>	
						<td width="70%"><h4><b>SK PANGKAT TERAKHIR</b></h4></td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->sk_pangkat_terakhir) ?><h4></td>
					</tr>
					<tr>	
						<td width="70%"><h4><b>SK JABATAN TERAKHIR</b></h4>(Opsional)</td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->sk_jabatan_terakhir) ?><h4></td>
					</tr>	
					<tr>	
						<td width="70%"><h4><b>PENILAIAN KINERJA</b></h4>Penilaian Kinerja Tahun 2022 & 2023 Minimal BAIK</td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->penilaian_kinerja) ?><h4></td>
					</tr>		
					<tr>	
						<td width="70%"><h4><b>SERTIFIKAT / PIAGAM PENGHARGAAN</b></h4>(Opsional)</td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->is_sertifikat) ?><h4></td>
					</tr>									
					<tr>	
						<td width="70%"><h4><b>REKAP DAFTAR HADIR</b></h4> Rekapitulasi daftar hadir 3 bulan terakhir.</td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->persentase_disiplin) ?>%<h4></td>
					</tr>
						
					<tr>	
						<td width="70%"><h4><b>SUPER HUKDIS</b></h4> Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin</td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->is_sertifikat) ?><h4></td>
					</tr>

					<tr>	
						<td width="70%"><h4><b>PROPOSAL INOVASI</b></h4></td>
						<td width="10"><h4>:</h4></td>
						<td align="middle"><h4><?= strtoupper($detail->proposal_inovasi) ?><h4></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
