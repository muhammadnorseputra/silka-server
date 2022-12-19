<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
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
       <?php
        if (isset($pesan) != '') {
        ?>
          <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
            <?php
            echo $pesan;
            ?>          
          </div> 
        <?php
          }
        ?>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-queen" aria-hidden="true"></span>        
        <?php
          echo '<b>RIWAYAT PENGHARGAAN</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        
        <table class="table table-bordered">
          <?php if($this->session->userdata('level') == 'ADMIN'): ?>
        	 <tr>
        	 	<td class="text-right">
        	 		<button class="btn btn-primary" data-toggle="modal" data-target="#entri_tanhor">+ Tambah</button>
        	 	</td>
        	 </tr>
        	<?php endif; ?>
          <tr>
            <td colspan='2' align='center'>                            
                <table class='table table-condensed table-hover table-bordered'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='550'><center>Nama</center></th>
                    <th align='50'><center>Tahun</center></th>
                    <th width='400'><center>Surat Keputusan</center></th>
                    <?php if($this->session->userdata('level') === 'ADMIN'): ?>
                      <th width='100'><center>Aksi</center></th>
                    <?php endif; ?>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwyph as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td>
                    	<?php 
                    		if($v['fid_jenis_tanhor'] !== '99'):
                    			echo $this->mpegawai->getnamaph($v['fid_jenis_tanhor']);
                    		else:
                    		 	echo $v['nama_tanhor'];
                    		endif;
                    	?>
                    </td>
                    <td><?php echo $v['tahun']; ?></td>
                    <td width='300'><?php echo $v['pejabat'].'<br />Nomor : '.$v['no_keppres'].'<br />Tanggal : '.tgl_indo($v['tgl_keppres']); ?></td>
                    <?php if($this->session->userdata('level') === 'ADMIN'): ?>
                      <td>
                        <form method='POST' action='../pegawai/hapusrwyph'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-danger btn-xs">
	                    			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
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
<!-- Modal Entri Riwayat Penghargaan -->
<div id="entri_tanhor" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<?= form_open(base_url('pegawai/entri_penghargaan'), ['id' => 'f_entri_tanhor', 'class' => 'form-horizontal'], ['nip' => $nip]); ?>
			<div class="modal-header">
	        <h4 class="modal-title">Tambah Riwayat Penghargaan</h4>
	        <?= $this->mpegawai->getnama($nip); ?> - <?= $nip ?>
	      </div>
	      <div class="modal-body">
          <div class="row">
            <div class="container">
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="jenis_tanhor">Jenis</label>
                  <select name="jenis_tanhor" id="jenis_tanhor"></select>
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
          <div class="row">
            <div class="container">
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="nama_tanhor">Nama Penghargaan</label>
                  <input type="text" name="nama_tanhor" id="nama_tanhor" class="form-control" placeholder="Nama Penghargaan" />
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
          <div class="row">
            <div class="container">
              <div class="col-md-1 col-lg-1">
                <div class="form-group" style="margin-right: 5px;">
                  <label for="tahun">Tahun</label>
                  <input type="year" name="tahun" id="tahun" class="form-control" placeholder="Tahun" maxlength="4" size="4"/>
                </div>
              </div>
              <div class="col-md-5 col-lg-5">
                <div class="form-group">
                  <label for="pejabat">Pejabat</label>
                  <input type="text" name="pejabat" id="pejabat" class="form-control" placeholder="Pejabat"/>
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
          <div class="row">
            <div class="container">
              <div class="col-md-4 col-lg-4">
                <div class="form-group" style="margin-right: 5px;">
                  <label for="nomor">Nomor</label>
                  <input type="text" name="nomor" id="nomor" class="form-control" placeholder="Nomor Keppres"/>
                </div>
              </div>
              <div class="col-md-2 col-lg-2">
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal" />
                </div>
              </div>
            </div> <!-- container -->
          </div> <!-- row -->
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	      	<button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
	      <?= form_close() ?>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
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
  $(function() {
		var $modal = $('#entri_tanhor');
		var $form = $("#f_entri_tanhor");
		$modal.on('shown.bs.modal', function () {
		  $('input[name="gd"]').focus();
      $(this).find('#jenis_tanhor').select2({
        width: "100%",
        theme: "classic",
        selectOnClose: false,
        placeholder: 'Pilih Jenis Tanhor',
        dropdownParent: $('#entri_tanhor'),
        ajax: {
          url: '<?= base_url("pegawai/ref_jenis_tanhor") ?>',
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
	
	});
</script>
