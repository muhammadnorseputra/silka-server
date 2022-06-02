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
			<table class="table table-bordered">
				<tbody>
					<tr>	
						<td width="200"><h4>SKOR KINERJA</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-center"><h4><?= $detail->skor_kinerja ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>SKOR DISIPLIN</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-center"><h4><?= $detail->skor_disiplin ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>INOVASI</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-center"><h4><?= $detail->inovasi ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>SKOR INOVASI</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-center"><h4><?= $detail->skor_inovasi ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>SKOR PERILAKU</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-center"><h4><?= $detail->skor_prilaku ?><h4></td>
					</tr>
					<tr>	
						<td width="200"><h4>SKOR TEAM WORK</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-center"><h4><?= $detail->skor_timwork ?><h4></td>
					</tr>
					<tr>	
						<td class="bg-danger"><h4>TOTAL SKOR</h4></td>
						<td class="bg-danger" width="10"><h4>:</h4></td>
						<td class="bg-danger text-center">
							<h4>
								<?php 
									$total_skor = $detail->skor_kinerja + $detail->skor_disiplin + $detail->skor_inovasi + $detail->skor_prilaku
								+ $detail->skor_timwork;
								?>
								<?= $total_skor ?>
								<?php 
									//Simpan ke database total skor
									$this->mpetruk->simpan_total_score($detail->nip, $total_skor); 
								?>
							<h4>
						</td>
					</tr>
					<tr>	
						<td width="200"><h4>DATA DUKUNG</h4></td>
						<td width="10"><h4>:</h4></td>
						<td class="text-left"><h4>Apabila ada dokumentasi berkaitan dengan pelaksanaan penilaian pegawai yang bersangkutan dapat mengirimkan bukti berupa file gambar atau document ke email <a href="mailto:sukiman2580@gmail.com"><i>sukiman2580@gmail.com<i></a><h4></td>
					</tr>
					
					<tr>	
						<td colspan="3"><a target="_blank" href="<?= base_url('petruk/cetak_hasil_penilaian/'.$detail->fid_unit_kerja.'/'.$detail->nip) ?>" class="btn btn-lg btn-block btn-primary"><i class="glyphicon glyphicon-print"></i> Cetak Hasil Penilaian</a></td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</div>
