<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
	<table class='table table-condensed'>
        <tr>
          <td align='left'>
            <?php
	    $intbkn_session = $this->session->userdata('intbkn_priv');
            if ($intbkn_session == "YA") {
              ?>
              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#tampilpdksapk"><span class="fa fa-exchange" aria-hidden="true"></span> Komparasi Data Pendidikan SAPK</button>
              <?php
            }     
            ?>
          </td>

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
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-education" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT PENDIDIKAN</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <table class="table">
        	<?php if($this->session->userdata('level') == 'ADMIN'): ?>
        	 <tr>
        	 	<td class="text-right">
        	 		<button class="btn btn-primary" data-toggle="modal" data-target="#entripdk">+ Tambah</button>
        	 	</td>
        	 </tr>
        	<?php endif; ?>
          <tr>
            <td align='center'>
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='250'><center>Tingkat<br />Jurusan</center></th>
                    <th align='50'><center>Tahun Lulus</center></th>
                    <th width='350'><center>Nama Sekolah</center></th>
                    <th width='350'><center>Ijazah / STTB</center></th>
		    <th><center>Aksi</center></th>	
		  <?php if($this->session->userdata('level') === 'ADMIN'): ?>
			  <th><center>Hapus</center></th>
			  <th><center>Edit</center></th>
		  <?php endif; ?>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwypdk as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <?php
                      $tingpen = $this->mpegawai->gettingpen($v['fid_tingkat']);
                      if (($tingpen == 'SD') OR ($tingpen == 'SMP')) {
                        echo '<td>'.$this->mpegawai->getjurpen($v['fid_jurusan']).'</td>';                      
                      } else {
                        echo '<td>'.$tingpen.'<br />'.$this->mpegawai->getjurpen($v['fid_jurusan']).'</td>';
                        
                      }
                    ?>
                    <td><?php echo $v['thn_lulus']; ?></td>
                    <td><?php echo $v['nama_sekolah']; ?></td>                    
                    <td width='300'><?php echo $v['nama_kepsek'].'<br />Nomor : '.$v['no_sttb'].'<br />Tanggal : '.tgl_indo($v['tgl_sttb']); ?></td>
                  
		    <td align='left'>
                          <?php
                          $lokasifile = './filepdk/';
                          $namafile = $v['berkas'];

                          if (file_exists($lokasifile.$namafile.'.pdf')) {
                            $namafile=$namafile.'.pdf';
                          } else {
                            $namafile=$namafile.'.PDF';
                          }

                          // Jika file berkas ditemukan
                          if (file_exists ($lokasifile.$namafile)) {
                            if ($this->mpegawai-> getthnluluspdkterakhir($nip) == $v['thn_lulus']) {
                              echo "<a class='btn btn-warning btn-xs' href='../filepdk/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>&nbspDownload</a>";
                            ?>
                            <br/>
                            Silahkan upload untuk update file
                            <form action="<?=base_url()?>upload/insertpdk" method="post" enctype="multipart/form-data">
                              <input type="file" name="filepdk" class="btn btn-xs btn-info">
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='thn_lulus' id='thn_lulus' value='<?php echo $v['thn_lulus']; ?>'>
                              <button type="submit" value="upload" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                              </form>
                              <?php
                            } else {
                              echo "<br/><a class='btn btn-warning btn-xs' href='../filepdk/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span><br/>Download</a>";
                            }
                          }
			
			  // Jika file berkas tidak ditemukan
                          if (!file_exists ($lokasifile.$namafile)) {
                            if ($this->mpegawai->getthnluluspdkterakhir($nip) == $v['thn_lulus']) {
                              echo "<div style='color: red'>File tidak tersedia, silahkan upload !!!</div>";
                            ?>
                            <form action="<?=base_url()?>upload/insertpdk" method="post" enctype="multipart/form-data">
                              <input type="file" name="filepdk" class="btn btn-xs btn-info" />
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='thn_lulus' id='thn_lulus' value='<?php echo $v['thn_lulus']; ?>'>
                              <button type="submit" value="upload" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                              </form>
                              <?php
                            }
                          }

                         ?>
                        </td>
                        <?php if($this->session->userdata('level') === 'ADMIN'): ?>
                        <td>
                        	<form method='POST' action='../pegawai/hapusrwypdk_aksi'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-danger btn-xs">
	                    			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
	                    		</button>
	                    		</form>
                        </td>
                        <td>
                        	<form method='POST' action='../pegawai/editrwypdk'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-primary btn-xs">
	                    			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><br/>Edit
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

<?php
if ($intbkn_session == "YA") {
?>
<!-- Modal Tampil data BKN-->
<div id="tampilpdksapk" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Komparasi Riwayat Pendidikan pada SAPK</h4>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:550px;border:1px solid white">        
        <small>
        <div class="row" style="padding:10px;"> <!-- Baris Awal -->
          
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">DATA SILKa Online</div>
              <!-- .panel-heading -->
              <div class="panel-body">
                <div class="panel-group" id="accordionsilka">
                  <?php                  
                  foreach ($pegrwypdk as $v)
                  {
                    echo "<div class='panel panel-default'>";                    
                    $tingpen = $this->mpegawai->gettingpen($v['fid_tingkat']);
		    $jurpen = $this->mpegawai->getjurpen($v['fid_jurusan']);
                    echo "<div class='panel-heading'>
                            <span class='panel-title'>
                              <a data-toggle='collapse' data-parent='#accordionsilka' href='#silka".$v['fid_tingkat']."-".$v['thn_lulus']."' aria-expanded='false' class='collapsed'>".$tingpen."-".$jurpen."</a>
                            </span>
                          </div>";                    
                    echo "<div id='silka".$v['fid_tingkat']."-".$v['thn_lulus']."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";

                    ?>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Jurusan"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$jurpen; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Tahun Lulus"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$v['thn_lulus']; ?></div>
                          </div>
                          <br/>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Nama Sekolah"; ?></div>
                            <div class="col-md-8"><?php echo ": ".$v['nama_sekolah']; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Ijazah"; ?></div>    
                          </div> 
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "Kepsek. ".$v['nama_kepsek']; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "Nomor. ".$v['no_sttb']; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "Tangal. ".tgl_indo($v['tgl_sttb']); ?></div>
                          </div>
                    <?php
                    echo "</div>
                          </div>
                        </div>";                    
                  }
                  ?>

                </div>
              </div>
              <!-- .panel-body -->
            </div>
          </div> <!-- End Column Panel Data SAPK-->

          <!-- Column SAPK -->
          <div class="col-md-6">
            <div class="panel panel-success">
              <div class="panel-heading"><b>DATA SAPK</b></div>
              <!-- .panel-heading -->
              <div class="panel-body">
                <div class="panel-group" id="accordionsapk">
                  <?php
                  // Jika menggunakan Json API
                  $resultApi = apiResult('https://wsrv.bkn.go.id/api/pns/rw-pendidikan/'.$nip);
                  //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/198104072009041002');
                  $obj = json_decode($resultApi);
                  //print_r($obj);
                  //var_dump($obj);

                  // Jika menggunakan file Json                  
                  //$url = 'http://localhost/silka/assets/rwpendidikan.json';
                  //$konten = file_get_contents($url);
                  //$obj = json_decode($konten, true);
                  //var_dump($obj);
                  
		if ($obj->code == '1') {
                  foreach ($obj->data as $data)
                  {
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <span class='panel-title'>
                              <a data-toggle='collapse' data-parent='#accordionsilka' href='#sapk".$data->tkPendidikanId."-".$data->tahunLulus."' aria-expanded='false' class='collapsed'>".$data->tkPendidikanNama."-".$data->pendidikanNama."</a>
                            </span>
                          </div>";
                    echo "<div id='sapk".$data->tkPendidikanId."-".$data->tahunLulus."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
                          
                          <div class="row">
                            <div class="col-md-12">
                            <?php
                              if ($data->isPendidikanPertama == 1) {
                                echo "<H5><code>Pendidikan saat CPNS</code></H5>";  
                              }
                              ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Jurusan"; ?></div>
                            <div class="col-md-8"><?php echo ": ".$data->pendidikanNama; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Tahun Lulus"; ?></div>
                            <div class="col-md-8"><?php echo ": ".$data->tahunLulus; ?></div>
                          </div>
                          <br/>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Nama Sekolah"; ?></div>
                            <div class="col-md-8"><?php echo ": ".$data->namaSekolah; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Gelar Pendidikan"; ?></div>
                            <div class="col-md-8">
                            <?php
                              if (($data->gelarDepan == "") AND ($data->gelarBelakang == "")) {
                                echo ": -";                              
                              } else {
                                echo ": <code>".$data->gelarDepan."</code> NAMA PNS <code>".$data->gelarBelakang."</code>";  
                              }
                              ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Ijazah"; ?></div>    
                          </div> 
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "Nomor. ".$data->nomorIjasah; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "Tanggal. ".$data->tglLulus; ?></div>
                          </div>
                    <?php
                    
                    echo "</div>
                          </div>
                        </div>";                    
                  } // End Foreach
		} else {
			echo "<center><h5><span class='text-info'>SAPK BKN : </span><span class='text-danger'>".$obj->data."</span></h5>";
              		echo "Silahkan hubungi Administrator SAPK BKN pada BKPPD Kab. Balangan</center>";
		}
                  ?>
                  </div>
                </div>
              </div>
              <!-- .panel-body -->
            </div> <!-- End Column Data SAPK-->
          </div><!-- End Row -->
          </small>
        </div> <!-- End Modal Body -->
      </div> <!-- End Modal Content -->
    </div> <!-- End Modal Dialog -->
  </div><!-- End Modal Tampil data BKN-->
<?php
}
?>
