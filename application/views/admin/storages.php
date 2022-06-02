<div class="container">
  <div class="row">
    <div class="clearfix"></div>
    <section class="panel-table">
        <div class="panel panel-danger">
						<div class="panel-heading">
              <b>Manajemen Files Personal</b> 
            </div>
            <div class="panel-body">
            	<div class="row">
            		<div class="col-lg-3 col-md-2" style="border-right:1px solid #999;">
                  <div class="form-group  has-success has-feedback">
                  <label for="inputSuccess2">Hanya untuk PNS Pensiun / Mutasi Keluar</label>
            			<input name="nip" class="form-control form-control-lg"  type="text" placeholder="Masukan NIP" id="inputSuccess2">
                  
                  <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                  </div>
				        </div>
				        <div class="col-lg-9 col-md-10" style="margin-top:21px;">
                  <div class="btn-group" role="group">
				        	  <button type="button" id="btncari" class="btn btn-success"><i class="glyphicon glyphicon-send"></i> &nbsp; List</button>
                    <button type="button" id="repeat" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i></button>
                  </div>
                  <button type="button" id="btnmultidel" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> &nbsp; Hapus Semua</button>
				        </div>
            	</div>
              <hr>
              <div class="row">
              	<div class="col-md-6">
              		<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Photo 
                    <span class="count_photo badge">0</span> 
                    <span class="badge" style="float:right;background-color:blue;"><?= dir_size('photo/') ?></span>
                  </h3>
              		<hr>
              		<ul class="list-group" id="file_photo"></ul>
                 
              		<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Personal 
                    <span class="count_file_perso badge">0</span> 
                    <span class="badge" style="float:right;background-color:blue;"><?= dir_size('fileperso/') ?></span>
                  </h3>
              		<hr>
              		<ul class="list-group" id="file_perso"></ul>
              	
                	<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Kenaikan Pangkat 
                    <span class="count_file_kp badge">0</span> 
                    <span class="badge" style="float:right;background-color:blue;"><?= dir_size('filekp/') ?></span>
                  </h3>
              		<hr>
              		<ul class="list-group" id="file_kp"></ul>
              	
                	<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Kenaikan Gaji Berkala 
                    <span class="count_file_kgb badge">0</span> <span class="badge" style="float:right;background-color:blue;">
                    <?= dir_size('filekgb/') ?></span>
                  </h3>
              		<hr>
              		<ul class="list-group" id="file_kgb"></ul>
              	</div>
              	<div class="col-md-6">
              		<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> SKP 
                    <span class="count_file_skp badge">0</span> <span class="badge" style="float:right;background-color:blue;">
                    <?= dir_size('fileskp/') ?></span></h3>
              		<hr>
              		<ul class="list-group" id="file_skp"></ul>
              	
                	<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Pendidikan 
                    <span class="count_file_pdk badge">0</span> <span class="badge" style="float:right;background-color:blue;">
                    <?= dir_size('filepdk/') ?></span></h3>
              		<hr>
              		<ul class="list-group" id="file_pdk"></ul>
              	
                	<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Jabatan 
                    <span class="count_file_jab badge">0</span> <span class="badge" style="float:right;background-color:blue;">
                    <?= dir_size('filejab/') ?></span></h3>
              		<hr>
              		<ul class="list-group" id="file_jab"></ul>
              	
                	<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> Hukuman Disiplin 
                    <span class="count_file_hd badge">0</span> <span class="badge" style="float:right;background-color:blue;">
                    <?= dir_size('filehd/') ?></span></h3>
              		<hr>
              		<ul class="list-group" id="file_hd"></ul>
              	
                	<h3>
                    <i class="glyphicon glyphicon-folder-open" style="margin-right:10px; color:#999;"></i> CPNS/PNS 
                    <span class="count_file_cp badge">0</span> <span class="badge" style="float:right;background-color:blue;">
                    <?= dir_size('filecp/') ?></span></h3>
              		<hr>
              		<ul class="list-group" id="file_cp"></ul>
              	</div>
              </div>
            </div>
        </div>
    </section>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script>
  
  
  function delone(e) {
    var urlFile = e.getAttribute('xurl');
    var data = e.getAttribute('xdata');
    if(confirm(`Apakah anda akan menghapus ${data} ?`)) {
      $.post(urlFile, {file: data}, function(res) {
        if(res.status == true) {
          refresh();
        }
      }, 'json');
    }
  };
  
	//$(document).ready(function() {
		var fnip = $("input[name='nip']");
		var fbtn = $("#btncari");
    var fmultidel = $("#btnmultidel");
    var frepeat = $("#repeat");
   
    function refresh() {
     fbtn.click();
    } 
   
    frepeat.on("click", function(e) {
      e.preventDefault();
      fnip.val('').focus();
    });
    
    fmultidel.on("click", function(e) {
      e.preventDefault();
      if(fnip.val().length < 16) {
				alert('Masukan Full NIP');
				return false;
			}
      $.ajax({
        url: "<?= base_url('files/cek_nip_multidel') ?>",
        type: 'POST',
				data: {
					nip: fnip.val().replace(/\s+/g, '')
				},
				dataType: 'json',
				success: function(res) {
          if(res.total_files > 0) {
            if(confirm(`Apakah anda akan menghapus ${res.total_files} files (${res.total_sizes}) ?`)) {             
              $.ajax({
                url: res.uri_next,
                type: 'POST',
                data: {
                  nip: res.nip.replace(/\s+/g, '')
                },
                beforeSend: function() {
                  fmultidel.prop("disabled",true);
                },
                dataType: 'json',
                success: function(result) {
                  alert(result.file);
                  if(result.status == true) {
                    refresh();
                  }
                },
                complete: function() {
                  fmultidel.prop("disabled",false);
                }
              });
            }
          } else {
            alert('File Sudah Bersih !');
          }
        }
      });
    });
    
		fbtn.on("click", function (e) {
			$(".list-group").html('');
			e.preventDefault();
			if(fnip.val().length < 16) {
				alert('Masukan Full NIP');
				return false;
			}
			$.ajax({
				url: "<?= base_url('files/cek_nip') ?>",
        type: 'POST',
				data: {
					nip: fnip.val().replace(/\s+/g, '')
				},
				dataType: 'json',
				success: function(res) {
					// FILE PHOTO
					var total_photo = res.photo.length;
					if(total_photo > 0) {
						$("span.count_photo").html(total_photo);
						res.photo.forEach(function(item, index) {
						
							$("ul#file_photo").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_photo").html('0');
						$("ul#file_photo").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
							
					// FILE PERSO
					var total_perso = res.file_perso.length;
					if(total_perso > 0) {
						$("span.count_file_perso").html(total_perso);
						res.file_perso.forEach(function(item, index) {
						
							$("ul#file_perso").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
								<button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_perso").html('0');
						$("ul#file_perso").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					
					// FILE SKP ALL
					var total_skp = res.file_skp.length;
					if(total_skp > 0) {
						$("span.count_file_skp").html(total_skp);
						res.file_skp.forEach(function(item, index) {
						
							$("ul#file_skp").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_skp").html('0');
						$("ul#file_skp").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					
					// FILE PDK
					var total_pdk = res.file_pdk.length;
					if(total_pdk > 0) {
						$("span.count_file_pdk").html(total_pdk);
						res.file_pdk.forEach(function(item, index) {
						
							$("ul#file_pdk").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_pdk").html('0');
						$("ul#file_pdk").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					
					// FILE KP
					var total_kp = res.file_kp.length;
					if(total_kp > 0) {
						$("span.count_file_kp").html(total_kp);
						res.file_kp.forEach(function(item, index) {
						
							$("ul#file_kp").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_kp").html('0');
						$("ul#file_kp").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					// FILE KGB
					var total_kgb = res.file_kgb.length;
					if(total_kgb > 0) {
						$("span.count_file_kgb").html(total_kgb);
						res.file_kgb.forEach(function(item, index) {
						
							$("ul#file_kgb").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_kgb").html('0');
						$("ul#file_kgb").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					
					// FILE JAB
					var total_jab = res.file_jab.length;
					if(total_jab > 0) {
						$("span.count_file_jab").html(total_jab);
						res.file_jab.forEach(function(item, index) {
						
							$("ul#file_jab").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_jab").html('0');
						$("ul#file_jab").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					// FILE HD
					var total_hd = res.file_hd.length;
					if(total_hd > 0) {
						$("span.count_file_hd").html(total_hd);
						res.file_hd.forEach(function(item, index) {
						
							$("ul#file_hd").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_hd").html('0');
						$("ul#file_hd").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
					
					
					// FILE CP
					var total_cp = res.file_cp.length;
					if(total_cp > 0) {
						$("span.count_file_cp").html(total_cp);
						res.file_cp.forEach(function(item, index) {
						
							$("ul#file_cp").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
								${index}. 
                <a target="_blank" href="<?= base_url() ?>${item}">${item}</a>
                <button type="button" xdata="${item}" xurl="<?= base_url() ?>files/onefile" onclick="delone(this)" style="float:right;" class="btn btn-sm btn-link"><i class="glyphicon glyphicon-trash"></i></button>
							</li>`);	
						
						});
					} else {
						$("span.count_file_cp").html('0');
						$("ul#file_cp").append(`<li class="list-group-item d-flex justify-content-between align-items-center">
						File Tidak Ditemukan
						</li>`);	
					}
				}
			})
		}
		)
   
//	})
	
</script>