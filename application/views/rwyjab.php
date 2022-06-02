<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<script>
	$(document).ready(function () {
		$('.tanggal').datepicker({
		  format: "dd-mm-yyyy",
		  todayHighlight: true,
		  clearBtn: true,
		  autoclose:true
		});
		$("select[name='unitkerja']").select2({
      	width: '100%',
      	dropdownParent: $('body')
      });	
    });
</script>
<script>
function pilih_jns_jab(jns)
{
	var unker = $('select[name="unitkerja"]').val();
	var pecah_str = unker.split("-");
	
	var unkerId = pecah_str[0]; 
	var unkerName = pecah_str[1];
	
	if(jns == 'JST') {
		pilih_jabatan(jns, unkerId);
	}
	if(jns == 'JFU') {
		pilih_jabatan(jns);
	}
	if(jns == 'JFT') {
		pilih_jabatan(jns);
	}
}

function pilih_jabatan(jns, unkerId='null') {
	
	$("[name='eselon']").val('0');
	if(jns == 'JST') {
		$.getJSON('<?= base_url("pegawai/getJst/") ?>', {unkerId: unkerId}, function(result) {
			$("select[name='pilih_jabatan_skr']").html(result);
		});
	}
	if(jns == 'JFU') {
		$.getJSON('<?= base_url("pegawai/getJfu/") ?>', function(result) {
			$("select[name='pilih_jabatan_skr']").html(result);
		});
	}
	if(jns == 'JFT') {
		$.getJSON('<?= base_url("pegawai/getJft/") ?>', function(result) {
			$("select[name='pilih_jabatan_skr']").html(result);
		});
	}
}

function piliheselon(id) {
	var pecah_str = id.split("-");
	var ids	      = pecah_str[0];
	var jns = $("input[type='radio'][name='jns_jab']:checked").val();
	$.getJSON('<?= base_url("pegawai/geteselon_byjabatan_rwyjab/") ?>', {id: ids}, function(result) {
		if(result != 0) {
			$("[name='eselon']").val(result);
		}
		if((result == 0) && (jns == 'JFU')) {
			$("[name='eselon']").val('0255-JFU');
		}
		if((result == 0) && (jns == 'JFT')) {
			$("[name='eselon']").val('0256-JFT');
		}
	});
}

function removeCheck() {
	$("input[name='jns_jab']").prop("checked", false);
}
	        
function pilihjabatan(id) {
	var pecah_str = id.split("-");
	var ids	      = pecah_str[0];
	$.getJSON('<?= base_url("pegawai/geteselon_byjabatan/") ?>', {id: ids}, function(result) {
		$("[name='eselon']").val(result);
	});
}

function pilihunker() {
        var id = $("[name = 'unitkerja']").val();
        $.get('<?= base_url("pegawai/getjab/") ?>',{unker: id}, function(result){
                $("[name = 'jabstruk']").html(result);
        pilihjabatan("0");
        });
}
function pilihpokja() {
	$.get('<?= base_url("pegawai/getpokja/") ?>', function(result){
		$("[name = 'nm_pokja']").html(result);
	}, 'json');
}

function input_pokjabaru() {
	var newval = prompt('Masukan nama pokja baru ...');
	if (newval == null || newval == "") {
	  return "User cancelled the prompt.";
	} else {
	  $.post('<?= base_url("pegawai/input_pokjabaru_proses/") ?>', {newpokja: newval}, function(result){
			alert(result.pesan);
			pilihpokja();
		}, 'json');
	}
	
}
</script>			
<script>
function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
      {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
      }
    if (window.ActiveXObject)
      {
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }  
function showtambah_rwyt_jabatan(nip) {
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahrwyjab";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedJabatan;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
}
function stateChangedJabatan(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("riwayat_jab").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("riwayat_jab").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }
  
function showtambahpltplh(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahjnsjab";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedPltPlh;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedPltPlh(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("riwayat_pltplh").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("riwayat_pltplh").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
  
  
  function showtambahrwypokja(nip)
  {
  
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahrwypokja";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedRwyPokja;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedRwyPokja(){
    if (xmlhttp.readyState==4)
    {pilihpokja();
      document.getElementById("riwayat_pokja").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("riwayat_pokja").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
			
    }
  } 
</script>
<center>  
  <div class="panel panel-default" style="width: 80%;">
    <div class="panel-body">
	<table class='table table-condensed'>
        <tr>
          <td align='left'>
            <?php
	    $intbkn_session = $this->session->userdata('intbkn_priv');
            if ($intbkn_session == "YA") {
              ?>
 	      <div class="row">        
                <div class="col-md-3" align='left'>
              		<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#tampiljabsapk"><span class="fa fa-exchange" aria-hidden="true"></span> Komparasi Data Jabatan SAPK</button>
                </div>
                <!--
		<div class="col-md-3" align='left'>            
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#tampilupdatejabsapk"><span class="fa fa-cloud-upload" aria-hidden="true"></span> Update SAPK BKN sesuai Jabatan Saat Ini</button>
                </div>
		-->
              </div>
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

      <?php
      if (isset($pesan) != '') {
      ?>
        <div class="<?php echo $jnspesan; ?>" alert-info" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
      <?php
      	}
      ?> 
      
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-sort" aria-hidden="true"></span>        
        <?php
          echo '<b>RIWAYAT JABATAN</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <div style="padding:3px;overflow:auto;width:99%;border:1px solid white" >
        <table class="table table-bordered">
          <tr>
            <td colspan='2' align='center'>  
              <ul class="nav nav-tabs">
	            <li class="active"><a href="#riwayat_jab" data-toggle="tab">Riwayat Jabatan</a></li>
	            <li><a href="#riwayat_pltplh" data-toggle="tab">Riwayat Plt / Plh</a></li>
	            <li><a href="#riwayat_pokja" data-toggle="tab">Riwayat Pokja</a></li>
	          </ul>
	          
	          <div class="tab-content">
                <div class="tab-pane fade in active" id="riwayat_jab">
                <br>
	          		<?php 
                	if(($this->session->userdata('level') == 'ADMIN') || ($this->session->userdata('nama') == 'fitriani')){
               	?>
                	 <form method="POST" name='tambah_rwyt_jabatan' style="margin-bottom:15px;">                                                    
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="pull-right btn btn-success btn-sm" onClick='showtambah_rwyt_jabatan(tambah_rwyt_jabatan.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Riwayat Jabatan
                          </button>
                      </form>
                <?php } ?> 
              <div class="clearfix"><br></div>
              <table class='table table-condensed table-hover'>
                <tr class='warning'>
                  <th width='20'><center>#</center></th>
                  <th width='400'><center><u>Jabatan</u><br />Unit Kerja</center></th>
                  <th align='30'><center>Eselon</center></th>                    
                  <th width='150'><center><u>TMT Jabatan</u><br/>Prosedur</center></th>
                  <th width='200'><center>Surat Keputusan</center></th>
		  <th><center>Files</center></th>
		  <th><center>Hapus</center></th>
                </tr>
                <?php
                $no=1;
                foreach($pegrwyjab as $v):                    
                  ?>
                <tr>
                  <td align='center'><?php echo $no;?></td>
                  <td><?php echo '<u>'.$v['jabatan'].'</u><br />'.$v['unit_kerja']; ?></td>
                  <td><?php echo $v['eselon']; ?></td>                    
                  <td><?php echo "<u>".tgl_indo($v['tmt_jabatan'])."</u><br/><span class='label label-info'>".$v['prosedur']."</span>"; ?></td>
                  <td width='300'><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
                
		  <td align='left'>
                          <?php
                          $lokasifile = './filejab/';
                          $namafile = $v['berkas'];

                          if (file_exists($lokasifile.$namafile.'.pdf')) {
                            $namafile=$namafile.'.pdf';
                          } else {
                            $namafile=$namafile.'.PDF';
                          }

                          // Jika file berkas ditemukan
                          if (file_exists ($lokasifile.$namafile)) {
                            if ($this->mpegawai->gettmtjabterakhir($nip) == $v['tmt_jabatan']) {
                              echo "<a class='btn btn-warning btn-xs' href='../filejab/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>&nbspDownload</a>";
                            ?>
                            <br/>
                            Silahkan upload untuk update file
                            <form action="<?=base_url()?>upload/insertjab" method="post" enctype="multipart/form-data">
                              <input type="file" name="filejab" class="btn btn-xs btn-info">
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='tmtjab' id='tmtjab' value='<?php echo $v['tmt_jabatan']; ?>'>
                              <button type="submit" value="upload" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                              </form>
                              <?php
                            } else {
                              echo "<br/><a class='btn btn-warning btn-xs' href='../filejab/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span><br/>Download</a>";
                            }
                          }
			
						  // Jika file berkas tidak ditemukan
                          if (!file_exists ($lokasifile.$namafile)) {
                            if ($this->mpegawai->gettmtjabterakhir($nip) == $v['tmt_jabatan']) {
                              echo "<div style='color: red'>File tidak tersedia, silahkan upload !!!</div>";
                            ?>
                            <form action="<?=base_url()?>upload/insertjab" method="post" enctype="multipart/form-data">
                              <input type="file" name="filejab" class="btn btn-xs btn-info" />
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='tmtjab' id='tmtjab' value='<?php echo $v['tmt_jabatan']; ?>'>
                              <button type="submit" value="upload" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                              </form>
                              <?php
                            }
                          }

                         ?>
                         
                         
			</td>
			<?php
			if($this->session->userdata('level') == 'ADMIN') {
			?>
			<td>
				<form method='POST' action='../pegawai/hapusrwyjab_aksi'>
                    		<?php
                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                    		echo "<input type='hidden' name='id' id='id' value='$v[id]'>";
                    		?>
                    		<button type="submit" class="btn btn-danger btn-xs">
                    			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
                    		</button>
                    		</form>
			</td>
			<?php
			}
			?>
		</tr>
                <?php
                $no++;
                endforeach;
                ?>
              </table>
              </div>
              
                <div class="tab-pane fade in" id="riwayat_pltplh">
                <br />
                <?php 
                	if ($this->session->userdata('level') == 'ADMIN') {
               	?>
                	 <form method="POST" name='tambahpltplh' style="margin-bottom:10px;">                                                    
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="pull-right btn btn-info btn-sm" onClick='showtambahpltplh(tambahpltplh.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Riwayat Plt/Plh
                          </button>
                      </form>
                <?php } ?> 
                <div class="clearfix"><br></div>
                <table class='table table-condensed table-hover' style="margin-top:15px;">
                <tr class='warning'>
                  <th width='20'><center>#</center></th>
                  <th width='300'><center><u>Jabatan</u><br>Unit Kerja</center></th>
                  <th width='50'>Eselon</th>
                  <th width='100'><center><u>TMT Awal</u><br>TMT Akhir</center></th>    
                  <th width='200'><center>Surat Keputusan</center></th>
		  		  <th width='100'><center>Aksi</center></th>
                </tr>
                <?php
                	$no = 1;
                	foreach($pegrwyplt as $plt):
                	
                ?>
                <tr>
                	<td><?= $no ?></td>
                	<td>
                	<u><b><?= strtoupper($plt['jns_jabatan']) ?></b> <?= strtoupper($plt['jabatan']) ?></u><br>
                	<?= $plt['unit_kerja'] ?>
                	</td>
                	<td><?= $plt['nama_eselon'] ?></td>
                	<td align="center"><?= tgl_indo($plt['tmt_awal']) ?><br>s/d<br><?= tgl_indo($plt['tmt_akhir']) ?></td>
                	<td>
                		<?= strtoupper($plt['pejabat_sk']) ?><br>
                		Nomor SK   :<?= $plt['no_sk'] ?><br>
                		Tgl SK 	   :<?= tgl_indo($plt['tgl_sk']) ?>
                	</td>
                		
			  					<td align='center' width='30'>
                		<form method='POST' name='editjnsplt' action='../pegawai/editrwyplt'>
                            <?php          
                               
                            echo "<input type='hidden' name='nip' id='nip' value='$plt[nip]'>";
                        	echo "<input type='hidden' name='id' id='id' value='$plt[id]'>";
                            ?>
                                  <button type='submit' class="btn pull-left mr-5 btn-warning btn-xs" >
                                  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbsp&nbspEdit&nbsp&nbsp
                                  </button>
                        </form>
			  			
                        <form method='POST' action='../pegawai/hapusrwyplt_aksi'>
                        <?php
                        echo "<input type='hidden' name='nip' id='nip' value='$plt[nip]'>";
                        echo "<input type='hidden' name='id' id='id' value='$plt[id]'>";
                        ?>
                        <button type="submit" class="btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                        </button>
                        </form>
                		</td>
                </tr>
                
                <?php $no++; endforeach; ?>
                </table>    
                </div>
                
                <div class="tab-pane fade in" id="riwayat_pokja">
                <br />
	            <?php 
                	if(($this->session->userdata('level') == 'ADMIN') || ($this->session->userdata('nama') == 'fitriani')){
	            ?>
                	 		<form method="POST" name='tambahrwypokja'>                                                    
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="pull-right btn btn-info btn-sm" onClick='showtambahrwypokja(tambahrwypokja.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Riwayat Pokja
                          </button>
                      </form>
                      
                      <form method="POST" name='tambahtgstambahan'>                                                    
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="pull-right btn btn-warning btn-sm" style="margin-right:10px;" onClick='showtambahtgstambahan(tambahrwypokja.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tugas Tambahan
                          </button>
                      </form>
                <?php } ?> 
	            <br>
	            <table class='table table-condensed table-hover' style="margin-top:25px;">
                <tr class='warning'>
                  <th width='20'><center>#</center></th>
                  <th width='300'>Nama Pokja</th>
                  <th width='100'><center><u>TMT Awal</u><br>TMT Akhir</center></th>    
                  <th width='250'><center>Surat Keputusan</center></th>
		  		  			<th width='100'><center>Aksi</center></th>
                </tr>
                <?php
                	$no = 1;
                	foreach($pegrwypokja as $pkj):
                	
                ?>
                <tr>
                	<td><?= $no ?></td>
                	<td><?= $pkj['nama_pokja'] ?></td>
                	<td align="center"><?= tgl_indo($pkj['tmt_awal']) ?><br>s/d<br><?= tgl_indo($pkj['tmt_akhir']) ?></td>
                	<td>
                		<?= strtoupper($pkj['pejabat_sk']) ?><br>
                		Nomor SK   :<?= $pkj['no_sk'] ?><br>
                		Tgl SK 	   :<?= tgl_indo($pkj['tgl_sk']) ?>
                	</td>
                	<td align='center' width='30'>
            				<form method='POST' name='editrwypokja' action='../pegawai/editrwypokja'>
                       <?php          
                        echo "<input type='hidden' name='nip' id='nip' value='$pkj[nip]'>";
                    		echo "<input type='hidden' name='id' id='id' value='$pkj[id]'>";
                        ?>
                        <button type='submit' class="btn pull-left mr-5 btn-warning btn-xs" >
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbsp&nbspEdit&nbsp&nbsp
                        </button>
                    </form>
			  			
                    <form method='POST' action='../pegawai/hapusrwypokja_aksi'>
                    <?php
                    echo "<input type='hidden' name='nip' id='nip' value='$pkj[nip]'>";
                    echo "<input type='hidden' name='id' id='id' value='$pkj[id]'>";
                    ?>
                    <button type="submit" class="btn btn-danger btn-xs">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                    </button>
                    </form>
                		</td>
                </tr>
                <?php $no++; endforeach; ?>
                </table>
	            </div> 
              
              </div>
            </td>
          </tr>
        </table>
        </div>  
        
                   
      </div>                
    </div>
  </div>  
</center>

<!-- Start Modal Update data BKN-->
<?php
if ($intbkn_session == "YA") {
?>
<div id="tampilupdatejabsapk" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Update data Riwayat SAPK BKN</h4>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:550px;border:1px solid white">     
        <?php
          $data = $this->mwsbkn->forupjabsapk($nip)->result_array();;
          foreach($data as $d):
            ?>
            <small>
	      <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-5"><b>DATA</b></div>
                <div class="col-md-5"><b>JSON ID</b></div>
              </div>
              <div class="row" style='margin-top:10px; margin-bottom:10px'>
                <div class="col-md-2 text-primary"><?php echo "Nama"; ?></div>
                <div class="col-md-5"><?php echo $d['nama']; ?></div>
                <div class="col-md-5"><?php echo $d['idbkn_pns']; ?></div>
              </div>
              <div class="row" style='margin-top:10px; margin-bottom:10px'>
                <div class="col-md-2 text-primary"><?php echo "Jenis Jabatan"; ?></div>
                <div class="col-md-5"><?php echo $d['nama_jenis_jabatan']; ?></div>
                <div class="col-md-5"><?php echo $d['idbkn_jnsjab']; ?></div>
              </div>  
              <div class="row" style='margin-top:10px; margin-bottom:10px'>
                <div class="col-md-2 text-primary"><?php echo "Jabatan"; ?></div>
                <div class="col-md-5"><?php echo $d['nama_jabatan']; ?></div>
                <div class="col-md-5"><?php echo $d['idbkn_jab']; ?></div>
              </div> 
              <div class="row" style='margin-top:10px; margin-bottom:10px'>
                <div class="col-md-2 text-primary"><?php echo "Unor"; ?></div>
                <div class="col-md-5"><?php echo $d['nama_unit_kerja']; ?></div>
                <div class="col-md-5"><?php echo $d['idbkn_unor']; ?></div>
              </div> 
              <?php
              if ($d['nama_jenis_jabatan'] == "STRUKTURAL") {
              ?>
                <div class="row" style='margin-top:10px; margin-bottom:10px'>
                  <div class="col-md-2 text-primary"><?php echo "Eselon"; ?></div>
                  <div class="col-md-5"><?php echo $d['nama_eselon']; ?></div>
                  <div class="col-md-5"><?php echo $d['idbkn_esl']; ?></div>
                </div>
              <?php
              }
              ?> 
              <div class="row">
                <div class="col-md-2 text-primary"><?php echo "No. SK"; ?></div>
                <div class="col-md-10"><?php echo $d['no_sk']; ?></div>
              </div> 
              <div class="row">
                <div class="col-md-2 text-primary"><?php echo "Tgl. SK"; ?></div>
                <div class="col-md-10"><?php echo tgl_indo($d['tgl_sk']); ?></div>
              </div> 
              <div class="row">
                <div class="col-md-2 text-primary"><?php echo "TMT Jabatan"; ?></div>
                <div class="col-md-10"><?php echo tgl_indo($d['tmt_jabatan']); ?></div>
              </div> 
              <?php
                if ($d['nama_jenis_jabatan'] == "STRUKTURAL") {
                  if ($d['tmt_pelantikan'] == "") {
                    $tgllantik = tgl_indo($d['tmt_jabatan']);
                  } else {
                    $tgllantik = tgl_indo($d['tmt_pelantikan']);
                  }
                } else {
                  $tgllantik = '';
                }
              ?>
              <div class="row">
                <div class="col-md-2 text-primary"><?php echo "Tgl Pelantikan"; ?></div>
                <div class="col-md-10"><?php echo $tgllantik; ?></div>
              </div>
              <div class="row" style='margin-top:20px';>
                <div class="col-md-12" align='center'>
                  <form method='POST' action='../api/upjabsapk'>
                    <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                    <button type="submit" class="btn btn-outline btn-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Tooltip on bottom">
                    <span class="fa fa-cloud-upload" aria-hidden="true"></span> Simpan Jabatan Terakhir pada SAPK BKN
                    </button>
                  </form>
                </div>
              </div> 
            </small>
            <?php
          endforeach;
        ?>     
      </div>
    </div>
  </div>
</div>
<!-- End Modal Update data BKN-->
<?php
}
?>


<?php
if ($intbkn_session == "YA") {
?>
<!-- Modal Tampil data BKN-->
<div id="tampiljabsapk" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Komparasi Riwayat Jabatan pada SAPK</h4>
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
                  foreach ($pegrwyjab as $v)
                  {
                    $tgltmt = date_create($v['tmt_jabatan']);

                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <div class='panel-title'>
                              <small><a data-toggle='collapse' data-parent='#accordionsilka' href='#silka".$v['tmt_jabatan']."' aria-expanded='false' class='collapsed'>".date_format($tgltmt, 'Y')." - ".$v['jabatan']."</a></small>
                            </div>
                          </div>";
                    echo "<div id='silka".$v['tmt_jabatan']."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Jenis"; ?></div>
                            <div class="col-md-9"><?php echo $v['jns_jab']; ?></div>
                          </div> 
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Jabatan"; ?></div>
                            <div class="col-md-9"><?php echo $v['jabatan']; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Eselon"; ?></div>
                            <div class="col-md-9"><?php echo $v['eselon']; ?></div>
                          </div> 
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Unit Kerja"; ?></div>
                            <div class="col-md-9"><?php echo $v['unit_kerja']; ?></div>
                          </div>
                          <br/>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "TMT Jabatan"; ?></div>
                            <div class="col-md-8"><?php echo tgl_indo($v['tmt_jabatan']); ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Tgl. Pelantikan"; ?></div>
                            <div class="col-md-8">
				<?php
					if (($v['tgl_pelantikan']) AND ($v['tgl_pelantikan'] != '0000-00-00')) {
						echo tgl_indo($v['tgl_pelantikan']);
					}
				?>
			    </div>
                          </div>                          
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Surat Keputusan"; ?></div>    
                          </div> 
                          <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11"><?php echo $v['pejabat_sk']; ?></div>
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
                  //$resultApi = apiResult('https://wsrv.bkn.go.id/api/pns/rw-jabatan/'.$nip);
		  $resultApi = apiResult('https://wsrv-duplex.bkn.go.id/api/jabatan/pns/'.$nip);
                  //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/198104072009041002');
                  $obj = json_decode($resultApi);
                  //print_r($obj);
                  //var_dump($obj);

                  // Jika menggunakan file Json                  
                  //$url = 'http://localhost/silka/assets/rwjab.json';
                  //$konten = file_get_contents($url);
                  //$obj = json_decode($konten, true);
                  //var_dump($obj);
                  
                  //foreach ($obj->data as $data) // jika menggunakan wsrv.bkn.go.id
                  foreach ($obj->mapData->data as $data) // jika menggunakan wsrv-duplex.bkn.go.id
		  {
                    $tgltmt = date_create($data->tmtJabatan);
                    if ($data->jenisJabatan == "STRUKTURAL") {
                      $jabatan = $data->unorNama;
                      $eselon = $data->eselon;
                    } else if ($data->jenisJabatan == "FUNGSIONAL_UMUM") {
                      $jabatan = $data->jabatanFungsionalUmumNama;
                      $eselon = "-";
                    } else if ($data->jenisJabatan == "FUNGSIONAL_TERTENTU") {
                      $jabatan = $data->jabatanFungsionalNama;
                      $eselon = "-";
                    }

                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                    <div class='panel-title'>
                    <small><a data-toggle='collapse' data-parent='#accordionsapk' href='#sapk".$data->tmtJabatan."' aria-expanded='false' class='collapsed'>".date_format($tgltmt, 'Y')." - ".$jabatan."</a></small>
                            </div>
                          </div>";
                    echo "<div id='sapk".$data->tmtJabatan."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>";
                    echo "<div class='panel-body'>";
                    ?>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Jenis"; ?></div>
                            <div class="col-md-9"><?php echo $data->jenisJabatan; ?></div>
                          </div>                          
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Jabatan"; ?></div>
                            <div class="col-md-9"><?php echo $jabatan; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Eselon"; ?></div>
                            <div class="col-md-9"><?php echo $eselon; ?></div>
                          </div>                          
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Unit Kerja"; ?></div>
                            <div class="col-md-9"><?php echo $data->namaUnor; ?></div>
                          </div>
                          <br/>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "TMT Jabatan"; ?></div>
                            <div class="col-md-8"><?php echo $data->tmtJabatan; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 text-primary"><?php echo "Tgl. Pelantikan"; ?></div>
                            <div class="col-md-8"><?php echo $data->tmtPelantikan; ?></div>
                          </div>                          
                          <div class="row">
                            <div class="col-md-3 text-primary"><?php echo "Surat Keputusan"; ?></div>    
                            <div class="col-md-9" align='left'><?php echo "Nomor. ".$data->nomorSk."<br/> Tanggal. ".$data->tanggalSk; ?></div>
                          </div>
                    <?php
                    echo "</div>
                          </div>
                        </div>";                                          
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
