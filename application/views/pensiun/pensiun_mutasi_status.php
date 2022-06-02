<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php 
						if($this->session->flashdata('valid') <> '') {
					?>
						<div class="alert alert-<?= $this->session->flashdata('mode') ?>" role="alert">
						  <?= $this->session->flashdata('pesan') ?>
						</div>
					<?php } ?>
					<button type="button" class="btn btn-danger btn-block" onclick="window.location.href='<?= base_url("pensiun/cari_pegawai") ?>'">K E M B A L I</button>	
				</div>
			</div>
		</div>
	</div>
</div>