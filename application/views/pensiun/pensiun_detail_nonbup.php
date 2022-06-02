<?php
 $d = $data[0];
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
				<?= form_open(base_url('pensiun/pensiun_aksi/non_bup')); ?>
				<table class="table table-responsive table-bordered table-condensed table-hover bg-info" align="center" style="margin-top:10px;">
				  <tbody>
				  	<tr>
				  		<td colspan="7" bgcolor="#33FF66" align="center"><b>DETAIL DATA PEGAWAI</b></td>
				    </tr>
				    <tr>
				        <td align="right"><b>NIP</b></td>
				        <td colspan="4"><b><?= $d->nip ?></b></td>
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
					      <td align="right"><b> Note </b></td>
					      <td colspan="6">
					      </td>
				      </tr>
				  </tbody>
				</table>
				
				<table class="table table-responsive table-bordered table-condensed table-hover bg-info" align="center">
					  <tbody>
					    <tr>
					      <td colspan="4" bgcolor="#33FF66" align="center"><b>DETAIL SURAT KEPUTUSAN PENSIUN</b></td>
					    </tr>
					    <tr>
					      <input class="form-control" type="hidden" name="nip" size="20" maxlength="18" value="<?= $d->nip ?>">
					      <td colspan="1" width="150" align="right"><b>Jenis Pensiun</b></td>
					      <td colspan="3">
					        <select name="id_jns_pens" required>
					          <option value="0" selected="">-- Jenis Pensiun --</option>
					          <option value="7">ATAS PERMINTAAN SENDIRI</option>
					          <option value="3">CACAT KARENA DINAS</option>
					          <option value="4">CACAT TIDAK KARENA DINAS</option>
					          <option value="6">MENINGGAL DUNIA</option>
					          <option value="2">TEWAS DALAM DINAS</option>
					          <option value="5">UZUR</option>
					        </select></td>
					    </tr>
					    <tr>
					      <td colspan="1" align="right"><b>NO. SK</b></td>
					      <td colspan="1"><input class="form-control" name="no_sk" size="50" maxlength="40"></td>
					      <td align="right"><b>Tanggal SK</b></td>
					      <td colspan="1"><input class="form-control" name="tgl_sk" id="tgl_sk" size="12" maxlength="10"></td>
					    </tr>
					    <tr>
					      <td colspan="1" align="right"><b>NIP</b></td>
					      <td colspan="3"><?= $d->nip ?></td>
					    </tr>
					    <tr>
					      <td colspan="1" align="right"><b>Nama</b></td>
					      <td colspan="3"><?= $d->nama ?></td>
					    </tr>
					    <tr>
					      <td colspan="1" align="right"><b>Tanggal Lahir</b></td>
					      <td colspan="3"><?= $d->tgl_lahir ?></td>
					    </tr>
					    <tr>
					      <td colspan="1" align="right"><b>Unit Kerja</b></td>
					      <td colspan="3"><?= $this->mpensiun->getunitkerja($d->fid_unit_kerja) ?></td>
					    </tr>
					    <tr>
					      <td colspan="1" align="right"><b>Tanggal Meninggal</b></td>
					      <td colspan="3"><div class="row"><div class="col-md-3"><input class="form-control" name="tgl_meninggal" id="tgl_meninggal" size="12" maxlength="10" value=""></div></div></td>
					    </tr>
					   
					    <tr>
					      <td align="right"><b>TMT Pensiun</b></td>
					      <td colspan="3"><div class="row"><div class="col-md-3"><input class="form-control" name="tmt_pens" id="tmt_pens" size="12" maxlength="10"></div></div></td>
					    </tr>
					    
					    <tr>
					      <td align="right"><b>Nama Keluarga</b></td>
					      <td colspan="1"><input class="form-control" name="nm_pnrima" size="30" maxlength="25"></td>
					      <td align="right"><b>Tanggal Lahir Penerima</b></td>
					      <td colspan="1"><input class="form-control" name="tl_pnrima" id="tl_pnrima" size="12" maxlength="10"></td>
					    </tr>
					    <tr>
					      <td align="right"><b>Hubungan Keluarga</b></td>
					      <td colspan="3"><select name="hub_kel"> &nbsp; &nbsp;
					          <option value="0" selected="">-- Hubungan Keluarga --</option>
					          <option value="sutri">SUAMI / ISTRI</option>
					          <option value="anak">ANAK</option>
					          <option value="ortu">ORANG TUA</option>
					        </select></td>
					    </tr>
					    <tr>
					      <td align="right"><b>Alamat Pensiun</b></td>
					      <td colspan="3"><input class="form-control" name="alamat_pens" size="90"></td>
					    </tr>
					    <tr>
					      <td align="right"><b>Catatan</b></td>
					      <td colspan="3"><textarea class="form-control" name="note" rows="3" cols="90"></textarea></td>
					    </tr>
					    <tr>
					      <td></td>
					      <td align="center"><button type="submit" class="btn btn-primary btn-block">S I M P A N</button></td>
					      <td colspan="2" align="center">
					        <button type="button" class="btn btn-danger btn-block" onclick="window.location.href='<?= base_url("pensiun/cari_pegawai") ?>'">K E L U A R</button>
					      </td>
					    </tr>
					  </tbody>
					</table>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>