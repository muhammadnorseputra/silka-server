<p>
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active">
    <a class="nav-link active" id="jst-tab" data-toggle="tab" href="#jst" role="tab" data-toggle="tab" aria-controls="home" aria-selected="true">STRUKTURAL</a>
  </li>
  <li role="presentation">
    <a class="nav-link" id="jfu-tab" data-toggle="tab" href="#jfu" role="tab" data-toggle="tab" aria-controls="profile" aria-selected="false">FUNGSIONAL UMUM / PELAKSANAN</a>
  </li>
  <li role="presentation">
    <a class="nav-link" id="jft-tab" data-toggle="tab" href="#jft" role="tab" data-toggle="tab" aria-controls="contact" aria-selected="false">FUNGSIONAL TERTENTU</a>
  </li>
</ul>
</p>
<p>
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="jst">
  	<div class="table-responsive">
		  <table class="table table-hover table-bordered" cellpadding="8" cellspacing="5">
		  	<thead class="bg-danger">
			    <th>NO</th>
			    <th>NAMA JABATAN</th>
			    <th>JABATAN INDUK</th>
			    <th>ESELON</th>
			    <th>KELAS</th>
			    <th>HARGA</th>
			    <?php if($this->session->userdata('level') == 'ADMIN'): ?>
			    <th>EDIT</th>
			    <?php endif; ?>
		    </thead>
		    <tbody>
		    	<?php 
		    		$no = 1;
		    		foreach($data_jst as $jst):
		    	?>
		    	<tr>
		    		<td class="text-center"><?= $no ?></td>
		    		<td><?= $jst->nama_jabatan ?></td>
		    		<td><?= $this->mharjab->get_jabatan_induk($jst->fid_jabatan_induk) ?></td>
		    		<td class="text-center"><?= $jst->nama_eselon ?></td>
		    		<td class="text-center bg-primary" style="font-size:20px; color: #fff;"><?= $jst->kelas ?></td>
		    		<td class="text-center" class="text-center" style="font-size:18px; color: #000;"><?= $jst->harga ?></td>
		    		<?php if($this->session->userdata('level') == 'ADMIN'): ?>
				    	<td><button type="button" onclick="showDetail(<?= $jst->id_jabatan ?>)" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-pencil"></i> Edit</button></td>
				    <?php endif; ?>
		    	</tr>
		    	<?php
		    		$no++;
		    		endforeach;
		    	?>
		    </tbody>
		  </table>
		</div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="jfu">
  <div class="table-responsive">
		  <table class="table table-hover table-bordered" cellpadding="8" cellspacing="5">
		  	<thead class="bg-success">
			    <th>NO</th>
			    <th>JABATAN</th>
			    <th>KELOMPOK TUGAS</th>
			    <th>KELAS</th>
			    <th>HARGA</th>
			    <?php if($this->session->userdata('level') == 'ADMIN'): ?>
			    <th>EDIT</th>
			    <?php endif; ?>
		    </thead>
		    <tbody>
		    	<?php 
		    		$no = 1;
		    		foreach($data_jfu as $jfu):
		    	?>
		    	<tr>
		    		<td class="text-center"><?= $no ?></td>
		    		<td><?= $jfu->nama_jabfu ?></td>
		    		<td class="text-center"><?= $jfu->kelompok_tugas ?></td>
		    		<td class="text-center bg-primary" style="font-size:20px; color: #fff;"><?= $jfu->kelas ?></td>
		    		<td class="text-center" class="text-center" style="font-size:18px; color: #000;"><?= $jfu->harga ?></td>
		    		<?php if($this->session->userdata('level') == 'ADMIN'): ?>
				    	<td><button type="button" onclick="showDetailJFU(<?= $jfu->id_jabfu ?>)" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-pencil"></i> Edit</button></td>
				    <?php endif; ?>
		    	</tr>
		    	<?php
		    		$no++;
		    		endforeach;
		    	?>
		    </tbody>
		  </table>
		</div>
  </div>
  <div role="tabpanel" class="tab-pane fade"  id="jft">
  <div class="table-responsive">
		  <table class="table table-hover table-bordered" cellpadding="8" cellspacing="5">
		  	<thead class="bg-primary">
			    <th>NO</th>
			    <th>JABATAN</th>
			    <th>KELOMPOK TUGAS</th>
			    <th>KELAS</th>
			    <th>HARGA</th>
		    </thead>
		    <tbody>
		    	<?php 
		    		$no = 1;
		    		foreach($data_jft as $jft):
		    	?>
		    	<tr>
		    		<td class="text-center"><?= $no ?></td>
		    		<td><?= $jft->nama_jabft ?></td>
		    		<td class="text-center"><?= $jft->kelompok_tugas ?></td>
		    		<td class="text-center bg-primary" style="font-size:20px; color: #fff;"><?= $jft->kelas ?></td>
		    		<td class="text-center" style="font-size:18px; color: #000;"><?= $jft->harga ?></td>
		    	</tr>
		    	<?php
		    		$no++;
		    		endforeach;
		    	?>
		    </tbody>
		  </table>
		</div>
  </div>
</div>
</p>

<!-- Modal JST-->
<div class="modal fade" id="ModalJST" tabindex="-1"  role="dialog" aria-labelledby="ModalJST">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('harjab/updateharjab') ?>" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="id_jabatan">
        <table class="table">
				  <tr>
				  	<td width="20%">Jabatan</td>
				  	<td class="id_namajabatan">...</td>
				  </tr>
				  <tr>
				  	<td width="20%">Kelas</td>
				  	<td>
				  		<select name="kelasjabatan">
				  			<option value="1">1</option>
				  			<option value="2">2</option>
				  			<option value="3">3</option>
				  			<option value="4">4</option>
				  			<option value="5">5</option>
				  			<option value="6">6</option>
				  			<option value="7">7</option>
				  			<option value="8">8</option>
				  			<option value="9">9</option>
				  			<option value="10">10</option>
				  			<option value="11">11</option>
				  			<option value="12">12</option>
				  			<option value="13">13</option>
				  			<option value="14">14</option>
				  		</select>
				  	</td>
				  </tr>
				  <tr>
				  	<td width="20%">Harga</td>
				  	<td>
				  		<input type="number" name="hargajabatan" class="form-control">
				  	</td>
				  </tr>
				</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </div>
		</form>
  </div>
</div>

<!-- Modal JFU-->
<div class="modal fade" id="ModalJFU" tabindex="-1"  role="dialog" aria-labelledby="ModalJFU">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('harjab/updateharjab_jfu') ?>" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit JFU</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="id_jabfu">
        <table class="table">
				  <tr>
				  	<td width="20%">Jabatan</td>
				  	<td class="id_namajabatan">...</td>
				  </tr>
				  <tr>
				  	<td width="20%">Kelas</td>
				  	<td>
				  		<select name="kelasjabatan">
				  			<option value="1">1</option>
				  			<option value="2">2</option>
				  			<option value="3">3</option>
				  			<option value="4">4</option>
				  			<option value="5">5</option>
				  			<option value="6">6</option>
				  			<option value="7">7</option>
				  			<option value="8">8</option>
				  			<option value="9">9</option>
				  			<option value="10">10</option>
				  			<option value="11">11</option>
				  			<option value="12">12</option>
				  			<option value="13">13</option>
				  			<option value="14">14</option>
				  		</select>
				  	</td>
				  </tr>
				  <tr>
				  	<td width="20%">Harga</td>
				  	<td>
				  		<input type="number" name="hargajabatan" class="form-control">
				  	</td>
				  </tr>
				</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </div>
		</form>
  </div>
</div>