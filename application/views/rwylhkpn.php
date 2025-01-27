<center>  
  <div class="panel panel-default" style="width: 70%">
    <div class="panel-body">
	<table class='table table-condensed'>
        <tr>
          <td align='right' width='50'>
            <?php
              echo "<form method='POST' action='../pegawai/detail'>";          
              echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
            ?>
              <p align="right">
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
              </p>
            <?php
              echo "</form>";          
            ?>
          </td>
        </tr>
      </table>
 		
      <?php
      if (isset($pesan) != '') {
      ?>
        <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
      <?php
      	}
      ?> 
      <div class="panel panel-info" style="padding:3px;overflow:auto;width:100%;height:420px;border:1px solid white">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-education" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT PELAPORAN LHKPN</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <table class="table">
       	  <?php if (($this->session->userdata('level') == 'ADMIN') AND ($this->mpegawai->cekstatuslhkpn($nip) == 'YA')): ?>
          <tr>
            <td class="text-right">
        	<button class="btn btn-primary btn-outline" data-toggle="modal" data-target="#entripdk">+ Tambah</button>
            </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td align='center'>
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th align='80'><center>Tahun Wajib Lapor</center></th>
                    <th width='400'><center>Jabatan Wajib Lapor</center></th>
                    <th width='400'><center>Pada Unit Kerja</center></th>
                    <th width='200'><center>File Tambahan Berita Negara (TBN)</center></th>
		    <th colspan='2'><center></center></th>	
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwylhkpn as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='center'><?php echo $v['tahun_wajib']."<br/><small><span class='text text-muted'>disampaikan tanggal ".tgl_indo($v['tgl_penyampaian'])."</span></small>"; ?></td>
                    <td><?php echo $v['jabatan']; ?></td>
                    <td><?php echo $v['unit_kerja']; ?></td>                    
		    <td align='center'>
                          <?php
			  if (file_exists('./filelhkpn/'.$v['file_tbn'].'.pdf')) {
                                $ket = "Upload Ulang";
                                $jnsfile = ".pdf";
                                $btncolor = "btn-warning";
                          } else if (file_exists('./filelhkpn/'.$v['file_tbn'].'.PDF')) {
                                $ket = "Upload Ulang";
                                $jnsfile = ".PDF";
                                $btncolor = "btn-warning";
                          } else {
                                $ket = "Upload TBN";
                                $btncolor = "btn-info";
                          }
			  ?>	
			
			  <?php
			  if ($v['tahun_wajib'] == '2023') {	
			  ?>
                          <button type='button' class='btn <?php echo $btncolor; ?> btn-outline btn-xs' data-toggle='modal' data-target='#uploadtbn<?php echo $v['id']; ?>'>
                            <span class='fa fa-upload fa-1x' aria-hidden='true'></span><br /><?php echo $ket; ?>
                          </button>	
			  <?php
			  }
			  ?>

                          <?php
                          if ((file_exists('./filelhkpn/'.$v['file_tbn'].'.pdf')) OR (file_exists('./filelhkpn/'.$v['file_tbn'].'.PDF'))) {
                          ?>
                            <a class='btn btn-success btn-outline btn-xs' href='../filelhkpn/<?php echo $v['file_tbn'].$jnsfile; ?>' target='_blank' role='button' style='margin-left: 10px;'>
                            <span class='fa fa-eye fa-1x' aria-hidden='true'></span><br />View File</a>
                          <?php
                          }
                          ?>
                        <!-- Modal Upload TBN -->
                        <div id="uploadtbn<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-primary'>UPLOAD DOKUMEN TAMBAHAN BERITA NEGARA LHKPN</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
                                        //echo "<span class='text text-primary'>Jenis Form : ".$v['jenis_form']."<br /> Tanggal Penyampaian ".tgl_indo($v['tgl_penyampaian'])."</span>";
                                        echo "<span class='text text-primary'>Tahun Wajib Lapor ".$v['tahun_wajib']."</span>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                  <form method="POST" name="formuploadtbn" action="<?=base_url()?>upload/insert_tbnlhkpn" enctype="multipart/form-data">
                                  <input type='hidden' name='id' id='id' value='<?php echo $v['id']; ?>' >
                                  <input type='hidden' name='nip' id='nip' value='<?php echo $v['nip']; ?>' >
                                  <input type='hidden' name='thn' id='thn' value='<?php echo $v['tahun_wajib']; ?>' >
                                  <input type='hidden' name='berkaslama' id='berkaslama' value='<?php echo $v['file_tbn']; ?>' >
                                  <div class="row"'>
                                    <div class="col-md-4"><span class='text text-primary'>Pilih file dokumen dengan format .pdf maks 1 Mega Byte.</span>
                                    </div>
                                    <div class="col-md-5">
                                      <input type="file" name="filetbn" class="btn btn-xs btn-info">
                                    </div>
                                    <div class="col-md-3" align='center'>
                                      <button type="submit" value="upload" class="btn btn-sm btn-primary btn-outline">
                                        <span class="fa fa-upload" aria-hidden="false"></span>&nbspUpload File
                                      </button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal Upload TBN -->

                        </td>
                        <?php if($this->session->userdata('level') === 'ADMIN'): ?>
                        <td width='20'>
                        	<form method='POST' action='../pegawai/hapusrwylhkpn_aksi'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-danger btn-xs btn-outline">
	                    			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
	                    		</button>
	                    		</form>
                        </td>
                        <td width='20'>
                        	<form method='POST' action='../pegawai/editrwylhkpn'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-primary btn-xs btn-outline">
	                    			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><br/>&nbspEdit&nbsp
	                    		</button>
	                    		</form>
                        </td>
                        
        			<?php endif; ?>
		  </tr>
                  <?php
                    $no++;
                    endforeach;
                  ?>
                </table>
            </td>
          </tr>
        </table>        
      </div>
    </div>
  </div>  
</center>

<!-- Modal Entri Riwayat Pendidikan -->
<div id="entripdk" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<?= form_open(base_url('pegawai/entri_pdk_aksi'), ['id' => 'f_entripdk', 'class' => 'form-horizontal'], ['nip' => $nip]); ?>
			<div class="modal-header">
	        <h4 class="modal-title">Tambah Riwayat Pendidikan</h4>
	        <?= $this->mpegawai->getnama($nip); ?> - <?= $nip ?>
	      </div>
	      <div class="modal-body">
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-1 col-lg-2">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="gd">Gelar Depan</label>
			        			<input name="gd" type="text" class="form-control" placeholder="Ex: Drs.">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-1 col-lg-2">
			        		<div class="form-group">
			        			<label for="gb">Gelar Belakang</label>
			        			<input name="gb" type="text" class="form-control" placeholder="Ex: S.Kom">
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-3">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="tp">Tingkat Pendidikan</label>
			        			<select name="tp" id="tp" class="form-control">
			        				<option value="">Pilih Tingkat Pendidikan</option>
			        				<?php foreach($ref_tingkat_pendidikan as $tp): ?>	
			        					<option value="<?= $tp->id_tingkat_pendidikan ?>"><?= $tp->nama_tingkat_pendidikan ?></option>
			        				<?php endforeach; ?>
			        			</select>
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-6">
			        		<div class="form-group">
			        			<label for="jp">Jurusan Pendidikan</label>
			        			<select name="jp"  id="jp" class="form-control">
			        				<option value="">Pilih Jurusan Pendidikan</option>
			        			</select>
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
		        
		        <hr>
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-7">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="nama_sekolah">Nama Sekolah</label>
			        			<input name="nama_sekolah" type="text" class="form-control" placeholder="Ex: STIMIK INDONESIA JAKARTA">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-2">
			        		<div class="form-group">
			        			<label for="tahun_lulus">Tahun Lulus</label>
			        			<input name="tahun_lulus" type="number" size="4" maxlength="4" class="form-control" placeholder="Ex: 2021">
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-4">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="nama_kepsek">Nama Kepsek</label>
			        			<input name="nama_kepsek" type="text" class="form-control" placeholder="Ex: Putra">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-3">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="no_sttb">No. STTB</label>
			        			<input name="no_sttb" type="text" class="form-control" placeholder="Ex: 0001/01/stimik/indonesia/2021">
			        		</div>
			        	</div> <!-- close -->
			        	<div class="col-md-2">
			        		<div class="form-group">
			        			<label for="tgl_sttb">Tanggal. STTB</label>
			        			<input name="tgl_sttb" type="date" class="form-control" placeholder="Ex: 27/05/1999">
			        		</div>
			        	</div> <!-- close -->
		        	</div> <!-- container -->
		        </div> <!-- row -->
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	      	<button type="submit" class="btn btn-primary">Simpan & Update Pendidikan</button>
	      </div>
	      <?= form_close() ?>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
<style>
.select2-container .select2-selection--single {
	height: 40px !important;
	font-weight: bold;
	font-size: 16px;
}
</style>
<script>
	$(function() {
		var $modal = $('#entripdk');
		var $form = $("#f_entripdk");
		$modal.on('shown.bs.modal', function () {
		  $('input[name="gd"]').focus();
		  $(this).find("#tp,#jp").select2({
				width: "100%",
				dropdownParent: $('#entripdk')
			}); 
		});
		
		$modal.on('hide.bs.modal', function () {
		  $form.get(0).reset();
		  $("select[name='jp']").html(`<option value="">Pilih Jurusan Pendidikan</option>`);
		})
		  
		var $select_tp = $("select[name='tp']");
		$select_tp.on("change", function(e) {
			e.preventDefault();
			var $this = $(this);
			var $id_tp = $this.val();
			$.getJSON(`<?= base_url("pegawai/list_jurusan_pendidikan") ?>`, {id: $id_tp}, function(res) {
				$("select[name='jp']").html(res);
			});
		})
	});
</script>
