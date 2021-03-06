<?php 
	$d = $data[0];
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
				<?= form_open(base_url('pensiun/mutasi_aksi')); ?>
				<table class="table table-responsive table-bordered table-condensed table-hover" align="center" style="margin-top:10px;">
				  <tbody>
				  	<tr>
				  		<td colspan="7" bgcolor="#33FF66" align="center"><b>DETAIL DATA PEGAWAI</b></td>
				    </tr>
				    <tr>
				        <td align="right"><b>NIP</b></td>
				        <td colspan="4"><input type="hidden" name="nip" value="<?= $d->nip ?>"><b><?= $d->nip ?></b></td>
					    <td rowspan="14" colspan="2" align="center">
					    	<br>
					    	<img src="<?= base_url('photo/'.$d->nip.'.jpg') ?>" width="210" height="255">
					    </td>
				    </tr>
				    <tr>
				    	<td align="right"><b>Nama</b></td>
				    	<td colspan="4"><?= $d->nama ?></td>
				    </tr>
					  <tr>
					    <td align="right"><b>Glr. Depan</b></td>
					    <td>
					    	<?= $d->gelar_depan ?>
					    </td>
					    <td align="right"><b>Glr. Blk.</b></td>
					    <td colspan="2">
					    	<?= $d->gelar_belakang ?>
					    </td>
					  </tr>
					  <tr>
					    <td align="right"><b>Tmp Lahir</b></td>
					    <td><?= $d->tmp_lahir ?></td>
					    <td align="right"><b>Tgl Lahir</b></td>
					    <td colspan="2">
					    <?= $d->tgl_lahir ?></td>
					  </tr>
					  <tr>
					    <td align="right"><b>Alamat</b></td>
					    <td colspan="4">
					    <?= $d->alamat ?></td>
					  </tr>
					  <tr>
					    <td align="right"><b>Kelurahan</b></td>
					    <td colspan="1"><?= $this->mpensiun->getkelurahan($d->fid_alamat_kelurahan) ?></td>
					    <td align="right"><b>Kecamatan</b></td>
					    <td colspan="2">
					    <b><?= $this->mpensiun->getkecamatan($d->fid_alamat_kelurahan) ?></b> </td>
					    </tr>
					    <tr>
					    <td align="right"><b>Telepon</b></td>
					    <td colspan="4"><?= $d->telepon ?></td>
					    </tr>
					    <tr>
					    <td align="right"><b>Agama</b></td>
					    <td colspan="4"><?= $this->mpensiun->getagama($d->fid_agama) ?></td></tr>
					  <tr>
					    <td align="right"><b>Jen. Kel.</b></td>
					    <td><?= $d->jenis_kelamin == "L" ? "Laki - Laki" : "Perempuan" ?></td>
					    <td align="right"><b>Stat. Kawin</b></td>
					    <td colspan="2"><?= $this->mpensiun->getstatkawin($d->fid_status_kawin) ?></td></tr>
					    <tr>
					    <td align="right"><b>Pendidikan</b></td>
					    <td colspan="2"><?= $this->mpensiun->gettingpen($d->fid_tingkat_pendidikan) ?></td><td align="right"><b>Th. Lulus</b></td>
					    <td colspan="1"><?= $d->tahun_lulus ?></td>
					  </tr>
				      <tr>
				      	<td align="right"><b>Jurusan</b></td>
				      	<td colspan="4"><?= $this->mpensiun->getjurpen($d->fid_jurusan_pendidikan) ?></td>
				      </tr>
				      <tr>
				        <td align="right"><b>Stat. Peg.</b></td>
				        	<td colspan="4"><?= $this->mpensiun->getstatpegid($d->nip) ?></td>
				        </tr>
				        <tr>
				        <td align="right"><b>No. Karpeg</b></td>
				        <td><?= $d->no_karpeg ?></td>
				        <td align="right"><b>No. Karis/Karsu</b></td>
				        <td colspan="2"><?= $d->no_karis_karsu ?></td>  
				      </tr>
				      <tr>
				        <td align="right"><b>Golru Awal</b></td>
				        <td><?= $this->mpensiun->getnamagolru($d->fid_golru_awal) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TMT :</b> <?= $d->tmt_golru_awal ?></td>
				        <td align="right"><b>Golru Skr</b></td>
				        <td colspan="2"><?= $this->mpensiun->getnamagolru($d->fid_golru_skr) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TMT :</b> <?= $d->tmt_golru_skr ?></td>
				      </tr>
				      <tr>
				        <td align="right"><b>No. SK CPNS</b></td>
				        <td><?= $d->no_sk_cpns ?></td>
				        <td align="right"><b>Tgl. SK CPNS</b></td>
				        <td colspan="2"><?= $d->tgl_sk_cpns ?></td>
				        <td align="right"><b>TMT CPNS</b></td>
				        <td><?= $d->tmt_cpns ?></td>
				      </tr>
				      <tr>
				        <td width="100" align="right"><b>No. SK PNS</b></td>
				        <td><?= $d->no_sk_pns ?></td>
				        <td align="right"><b>Tgl. SK PNS</b></td>
				        <td colspan="2"><?= $d->tgl_sk_pns ?></td>
				        <td align="right"><b>TMT PNS</b></td>
				        <td><?= $d->tmt_pns ?></td>
				      </tr>
				      <tr>
				        <td align="right"><b>Jen. Peg.</b></td>
				        <td colspan="3"><?= $this->mpensiun->getjnspeg($d->nip) ?></td>
					      <td align="right"><b>MaKer Total</b></td>
					      <td colspan="2"><?= $d->makertotal_tahun ?> Tahun &nbsp;/&nbsp; <?= $d->makertotal_bulan ?> Bulan
					    </td>
				      </tr>
				      <tr>
					      <td align="right">
					          <b>Unit Kerja <br> Instansi <br> Jabatan</b>
					      </td>
					      <td colspan="4">
					      	<?= $this->mpensiun->getunitkerja($d->fid_unit_kerja) ?>  <input type="hidden" name="nm_unker" value="<?= $this->mpensiun->getunitkerja($d->fid_unit_kerja) ?>"><br><b> 
					      	<input type="hidden" name="nm_instansi" value="<?= $this->mpensiun->getinstansi($d->fid_unit_kerja) ?>"><br>
					        <?= $this->mpensiun->namajabnip($d->nip) ?> 
					        <input type="hidden" name="nm_jabatan" value="<?= $this->mpensiun->namajabnip($d->nip) ?>"></b>
					      </td>
					      <td colspan="1" align="right">
					              <b>PLT <br>Eselon <br>TMT Jab</b>
					      </td>
				          <td colspan="1"><?= $d->plt ?><br><?= $this->mpensiun->getnamaeselon($d->fid_eselon) ?><br><?= $d->tmt_jabatan ?></td>
				      </tr>
				      <tr>
					      <td align="right"><b> Keterangan </b></td>
					      <td colspan="6">
					      	<textarea name="keterangan_mutasi" class="form-control" rows="3" placeholder="Masukan keterangan mutasi disini ..."></textarea>
					      	<br>
					      	<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-send"></i>  SUBMIT</button>
					      	<!--<button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-file"></i> CEK FILES PADA SISTEM</button>-->
							<button type="button" onclick="window.location.href='<?= base_url("pensiun/proyeksi") ?>'" class="btn pull-right btn-primary">
							  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
							</button>
					      </td>
				      </tr>
				  </tbody>
				</table>		
				<?= form_close(); ?>	
				</div>
			</div>
		</div>
	</div>
</div>