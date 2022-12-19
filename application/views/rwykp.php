<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
	<table class='table table-condensed'>
        <tr>
          <td align='left'>
            <?php
	    $intbkn_session = $this->session->userdata('intbkn_priv');
	    if ($intbkn_session == "YA") {
            //if ($this->session->userdata('level') == "ADMIN") {
              ?>
              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#tampilkpsapk"><span class="fa fa-exchange" aria-hidden="true"></span> Komparasi Data Golru SAPK</button>
              <?php
            }     
            ?>
          </td>

          <td align='right' width='50'>
            <form method='POST' action='../pegawai/detail'>
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            </form>
          </td>
        </tr>
      </table> 

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-star" aria-hidden="true"></span>        
          <?php
          echo '<b>RIWAYAT PANGKAT</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
          ?>
        </div>
        <div style="padding:3px;overflow:auto;width:99%;height:390px;border:1px solid white" >
          <table class="table table-condensed">
          <?php if($this->session->userdata('level') == 'ADMIN'): ?>
        	 <tr>
        	 	<td class="text-right">
        	 		<button class="btn btn-primary" data-toggle="modal" data-target="#entrikp">+ Tambah</button>
        	 	</td>
        	 </tr>
        	<?php endif; ?>
            <tr>
              <td colspan='2' align='center'>                            
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='200'><center>Pangkat / Golru<br />TMT<br/>Gaji Pokok</center></th>
                    <th width='300'><center><u>Dalam Jabatan</u><br />Angka Kredit<br /><i>Masa Kerja</i></center></th>
                    <th><center>Surat Keputusan</center></th>
                    <th><center>Aksi</center></th>
                  </tr>
                  <?php
                  $no=1;
                  foreach($pegrwykp as $v):                    
                    ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td><?php echo $this->mpegawai->getnamapangkat($v['fid_golru']).'<br />'.$this->mpegawai->getnamagolru($v['fid_golru']); ?>
                        <?php echo '<br />TMT : '.tgl_indo($v['tmt'])."<br/>Rp. ".indorupiah($v['gapok']).",-"; ?></td>
                        <?php
                        if ($v['angka_kredit'] == 0) {
                          echo '<td><u>'.$v['dlm_jabatan'].'</u><br />';  
                        } else {
                          echo '<td><u>'.$v['dlm_jabatan'].'</u><br />'.$v['angka_kredit'].'<br />';  
                        }
                        ?>
                        <?php
                        if (($v['mkgol_thn'] == 0) AND ($v['mkgol_bln'] == 0) ) {
                          echo '</td>';
                        } else {
                          echo '<i>'.$v['mkgol_thn'].' Tahun, '.$v['mkgol_bln'].' Bulan</i></td>';
                        }
                        ?>
                        <td width='300'><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>

                        <td align='left'>
                          <?php
                          $lokasifile = './filekp/';
                          $namafile = $v['berkas'];

                          if (file_exists($lokasifile.$namafile.'.pdf')) {
                            $namafile=$namafile.'.pdf';
                          } else {
                            $namafile=$namafile.'.PDF';
                          }

                          // Jika file berkas ditemukan
                          if (file_exists ($lokasifile.$namafile)) {
                            if ($this->mpegawai->gettmtkpterakhir($nip) == $v['tmt']) {
                              echo "<a class='btn btn-warning btn-xs' href='../filekp/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>&nbspDownload</a>";
                            ?>
                            <br/>
                            Silahkan upload untuk update file
                            <form action="<?=base_url()?>upload/insertkp" method="post" enctype="multipart/form-data">
                              <input type="file" name="filekp" class="btn btn-xs btn-info"> 
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='id_golru' id='id_golru' value='<?php echo $v['fid_golru']; ?>'>
                              <button type="submit" value="upload" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                              </form>
                              <?php
                            } else {
                              echo "<br/><a class='btn btn-warning btn-xs' href='../filekp/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span><br/>Download</a>";
                            }
                          }

                          // Jika file berkas tidak ditemukan
                          if (!file_exists ($lokasifile.$namafile)) {
                            if ($this->mpegawai->gettmtkpterakhir($nip) == $v['tmt']) {                            
                              echo "<div style='color: red'>File tidak tersedia, silahkan upload !!!</div>";
                            ?>
                            <form action="<?=base_url()?>upload/insertkp" method="post" enctype="multipart/form-data">
                              <input type="file" name="filekp" class="btn btn-xs btn-info" />
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='id_golru' id='id_golru' value='<?php echo $v['fid_golru']; ?>'>
                              <button type="submit" value="upload" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                              </form>
                              <?php
                            }
                          }

                            ?>
                          </td>
                        </tr>
                        <?php
                        $no++;
                      endforeach;
                      ?>
                    </table>
                  </td>
                </tr>
              </table>        
            </td>
          </div>
        </div>
      </div> 
</center>

<?php
if ($intbkn_session == "YA") {
?>
<!-- Modal Tampil data BKN-->
<div id="tampilkpsapk" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Komparasi Riwayat Pangkat pada SAPK</h4>
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
                  foreach ($pegrwykp as $v)
                  {
                    $nmgolru = $this->mpegawai->getnamagolru($v['fid_golru']);
                    $nmpangkat = $this->mpegawai->getnamapangkat($v['fid_golru']);
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <h5 class='panel-title'>
                              <a data-toggle='collapse' data-parent='#accordionsilka' href='#silka".$v['fid_golru']."' aria-expanded='false' class='collapsed'>".$nmgolru." (".$nmpangkat.")</a>
                            </h5>
                          </div>";
                    echo "<div id='silka".$v['fid_golru']."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Golru"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$nmgolru." (".$nmpangkat.")"; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "TMT"; ?></div>
                            <div class="col-md-9"><?php echo ": ".tgl_indo($v['tmt']); ?></div>
                          </div>
                          <br/>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Gaji Pokok"; ?></div>
                            <div class="col-md-9"><?php echo ": Rp. ".indorupiah($v['gapok']); ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Masa Kerja"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$v['mkgol_thn']." Tahun, ".$v['mkgol_bln']." Bulan"; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Dalam Jabatan"; ?></div>    
                          </div>                      
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11" align='left'>
                              <?php
                                if ($v['angka_kredit'] == 0) {
                                  echo '<u>'.$v['dlm_jabatan'].'</u>';  
                                } else {
                                  echo '<u>'.$v['dlm_jabatan'].'</u><br />Angka Kredit : '.$v['angka_kredit'];  
                                }
                              ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Surat Keputusan"; ?></div>    
                          </div> 
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "".$v['pejabat_sk']; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "No. SK. ".$v['no_sk']." Tgl. ".tgl_indo($v['tgl_sk']); ?></div>
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
          </div> <!-- End Column Panel Data Silka-->

          <!-- Column SAPK -->
          <div class="col-md-6">
            <div class="panel panel-success">
              <div class="panel-heading"><b>DATA SAPK</b></div>
              <!-- .panel-heading -->
              <div class="panel-body">
                <div class="panel-group" id="accordionsapk">
                  <?php
                  // Jika menggunakan Json API
                  $resultApi = apiResult('https://wsrv.bkn.go.id/api/pns/rw-golongan/'.$nip);
                  //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/198104072009041002');
                  $obj = json_decode($resultApi);
                  //var_dump($obj);
		  //print_r($obj);

                  // Jika menggunakan file Json                 
                  //$url = 'http://localhost/silka/assets/rwgolru.json';
                  //$konten = file_get_contents($url);
                  //$obj = json_decode($konten, true);
                  //var_dump($obj);

		if($obj->code == '1') {                  
                  foreach ($obj->data as $data)
                  {
                    $nmgolru = $this->mpegawai->getnamagolru($data->golonganId);
                    $nmpangkat = $this->mpegawai->getnamapangkat($data->golonganId);
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <h5 class='panel-title'>
                              <a data-toggle='collapse' data-parent='#accordionsilka' href='#sapk".$data->golonganId."' aria-expanded='false' class='collapsed'>".$nmgolru." (".$nmpangkat.")</a>
                            </h5>
                          </div>";
                    echo "<div id='sapk".$data->golonganId."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Golru"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$data->golongan." (".$nmpangkat.")"; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "TMT"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$data->tmtGolongan; ?></div>
                          </div>
			  <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Jenis KP"; ?></div>
                            <div class="col-md-9"><?php echo ": ".$data->jenisKPNama; ?></div>
                          </div>

                          <br/>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Persetujuan Teknis"; ?></div>
                            <div class="col-md-8"><?php echo ": No. ".$data->noPertekBkn." Tgl. ".$data->tglPertekBkn; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Masa Kerja"; ?></div>
                            <div class="col-md-8"><?php echo ": ".$data->masaKerjaGolonganTahun." Tahun, ".$data->masaKerjaGolonganBulan." Bulan"; ?></div>
                          </div>
			  	<?php
                          	//if (($data->jumlahKreditUtama != null) OR ($data->jumlahKreditUtama != "0.0")) {
			  	?>
	                          <div class="row">
	                            <div class="col-md-4 text-primary"><?php echo "Angka Kredit"; ?></div>    
        	                    <div class="col-md-8" align='left'>
	                              <?php
        	                          echo ': A.K. Utama : '.$data->jumlahKreditUtama.' | A.K. Tambahan : '.$data->jumlahKreditTambahan;  
                	              ?>
                        	    </div>
                          	  </div>
			  	<?php
				//}
			  	?>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Surat Keputusan"; ?></div>    
                          </div> 
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo "No. SK. ".$data->skNomor." Tgl. ".$data->skTanggal; ?></div>
                          </div>
                    <?php
                    
                    echo "</div>
                          </div>
                        </div>";

                  } // tutup foreach
		
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

<!-- Modal Entri Riwayat KP -->
<div id="entrikp" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<?= form_open(base_url('pegawai/entri_kp_aksi'), ['id' => 'f_entrikp', 'class' => 'form-horizontal'], ['nip' => $nip]); ?>
			<div class="modal-header">
	        <h4 class="modal-title">Tambah Riwayat KP</h4>
	        <?= $this->mpegawai->getnama($nip); ?> - <?= $nip ?>
	      </div>
	      <div class="modal-body">
		        <div class="row">
		        	<div class="container">
			        	<div class="col-md-2 col-lg-2">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="uraian">Uraian</label>
			        			<select name="uraian" id="uraian">
                      <option value="">Pilih Uraian</option>
                      <option value="CPNS">CPNS</option>
                      <option value="PNS">PNS</option>
                      <option value="KENAIKAN PANGKAT">KENAIKAN PANGKAT</option>
                    </select>
			        		</div>
			        	</div>
                <div class="col-md-2 col-lg-2">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="jenis">Jenis</label>
			        			<select name="jenis" id="jenis">
                      <option value="">Pilih Jenis</option>
                      <option value="REGULER">REGULER</option>
                      <option value="PILIHAN (STRUKTURAL)">PILIHAN (STRUKTURAL)</option>
                      <option value="PILIHAN (JFT)">PILIHAN (JFT)</option>
                      <option value="PILIHAN (PI)">PILIHAN (PI)</option>
                      <option value="PILIHAN (TUBEL)">PILIHAN (TUBEL)</option>
                    </select>
			        		</div>
			        	</div>
                <div class="col-md-2 col-lg-2">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="golru">Golongan Ruang</label> <br>
			        			<select name="golru" id="golru">
                    </select>
			        		</div>
			        	</div>
                <div class="col-md-2 col-lg-2">
			        		<div class="form-group" style="margin-right: 10px;">
			        			<label for="tmt">TMT Pangkat</label>
                    <input type="date" name="tmt" id="tmt" class="form-control">
			        		</div>
			        	</div>
		        	</div> <!-- container -->
		        </div> <!-- row -->
            <div class="row">
              <div class="container">
                  <div class="col-md-5 col-lg-5">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="dlm_jabatan">Dalam Jabatan</label>
                      <input type="text" name="dlm_jabatan" id="dlm_jabatan" class="form-control" placeholder="Pada ">
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="gaji">Gaji Pokok | <span id="toRupiah"></span></label>
                      <input type="text" name="gaji" class="form-control" placeholder="Rupiah" size='20' maxlength='100' onkeyup="isRupiah(this)" onchange="isRupiah(this)"/>
                    </div>
                  </div>
                  <div class="col-md-1 col-lg-1">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="ak">AK</label>
                      <input type="text" name="ak" id="ak" size='5' maxlength='10' class="form-control" placeholder="0.00">
                    </div>
                  </div>
              </div> <!-- container -->
            </div> <!-- row -->
            <div class="row">
              <div class="container">
                  <div class="col-md-1 col-lg-1">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="mk_tahun">MK Tahun</label>
                      <input type="number" name="mk_tahun" id="mk_tahun" size='5' maxlength='5' class="form-control">
                    </div>
                  </div>
                  <div class="col-md-1 col-lg-1">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="mk_bulan">MK Bulan</label>
                      <input type="number" name="mk_bulan" id="mk_bulan" size='5' maxlength='5' class="form-control">
                    </div>
                  </div>
              </div> <!-- container -->
            </div> <!-- row -->
            <hr>
            <div class="row">
              <div class="container">
                  <div class="col-md-3 col-lg-3">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="pejabat_sk">Pejabat (SK)</label>
                      <input type="text" name="pejabat_sk" id="pejabat_sk" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="nomor_sk">Nomor (SK)</label>
                      <input type="text" name="nomor_sk" id="nomor_sk" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-2 col-lg-2">
                    <div class="form-group" style="margin-right: 10px;">
                      <label for="tgl_sk">Tanggal (SK)</label>
                      <input type="date" name="tgl_sk" id="tgl_sk" class="form-control">
                    </div>
                  </div>
              </div> <!-- container -->
            </div> <!-- row -->
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	      	<button type="submit" class="btn btn-primary">Simpan & Update</button>
	      </div>
	      <?= form_close() ?>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
<style>
.select2-container .select2-selection--single {
	height: 35px !important;
	font-weight: bold;
	font-size: 16px;
}
label {
  font-weight: bold;
  font-size: 14px;
  color: #323232;
}
/* Hide Calendar Icon In Chrome */
input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-calendar-picker-indicator {
    display: none;
    -webkit-appearance: none;
}
</style>
<script>
  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }

  function isRupiah(e) {
    let num = e.value;
    $('span#toRupiah').html(`Rp. ${formatNumber(num)}`);
  }
	$(function() {
		var $modal = $('#entrikp');
		var $form = $("#f_entrikp");
		$modal.on('shown.bs.modal', function () {
		  $('input[name="gd"]').focus();
		  $(this).find("#uraian,#jenis").select2({
				width: "100%",
        theme: "classic",
        minimumResultsForSearch: Infinity,
				dropdownParent: $('#entrikp')
			}); 
      $(this).find('#golru').select2({
        width: "100%",
        theme: "classic",
        selectOnClose: false,
        placeholder: 'Golongan Ruang',
        dropdownParent: $('#entrikp'),
        ajax: {
          url: '<?= base_url("pegawai/list_golru") ?>',
          dataType: 'json',
          delay: 250,
          minimumInputLength: 1,
          data: function (params) {
            return {
              q: params.term, // search term
            };
          },
          processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
              results: data
            };
          },
          templateResult: function(res) {
            return `${res.id} - ${res.text}`
          }
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
      });
		});
		
		$modal.on('hide.bs.modal', function () {
		  $form.get(0).reset();
		})
		  
		// var $select_tp = $("select[name='tp']");
		// $select_tp.on("change", function(e) {
		// 	e.preventDefault();
		// 	var $this = $(this);
		// 	var $id_tp = $this.val();
		// 	$.getJSON(`<?= base_url("pegawai/list_jurusan_pendidikan") ?>`, {id: $id_tp}, function(res) {
		// 		$("select[name='jp']").html(res);
		// 	});
		// })
	});
</script>