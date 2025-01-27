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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-usd" aria-hidden="true"></span>        
        <?php
          echo '<b>RIWAYAT PENINJAUAN MASA KERJA</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <div style="padding:3px;overflow:auto;width:99%;height:390px;border:1px solid white" >
        <?php
	// Aksesn unt Admin dan Bani Disdikbud
	 if (($this->session->userdata('level') == 'ADMIN') OR ($this->session->userdata('nip') == '198305142009041003')){ ?>
	   <div align='right'>
                <button type='button' class='btn btn-success btn-outline btn-sm' data-toggle='modal' data-target='#entripmk'>
                        <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>&nbspTambah Riwayat PMK
                </button>
	   </div>	
	   <br/>
        <?php } ?>
        <table class="table table-bordered">
          <tr>
            <td align='center'>                            
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th align='150'><center>Dalam Pangkat</center></th>
                    <th width='150'><center>Masa Kerja Lama</center></th>
                    <th align='50'><center>Masa Kerja Baru</center></th>
                    <th align='50'><center>Pertimbangan Teknis</center></th>
                    <th><center>Surat Keputusan</center></th>
                    <th><center>Berkas</center></th>
                    <?php if(($this->session->userdata('level') == 'ADMIN') OR ($this->session->userdata('nip') == '198305142009041003')): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwypmk as $k => $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='left'>
			<?php
				echo $this->mpegawai->getnamapangkat($v['fid_golru']).'<br />'.$this->mpegawai->getnamagolru($v['fid_golru']);
			?>
		    </td>
                    <td><?php echo $v['mklama_thn']." Thn ".$v['mklama_bln']." Bln<br/>Rp. ".indorupiah($v['gapok_lama'])."<br/>".tgl_indo($v['tmt_lama']); ?></td>
		    <td><?php echo $v['mkbaru_thn']." Thn ".$v['mkbaru_bln']." Bln<br/>Rp. ".indorupiah($v['gapok_baru'])."<br/>".tgl_indo($v['tmt_baru']); ?></td>
                    <td align='left'>
                      <?php                    
                      echo $v['no_pertek']."<br/>".tgl_indo($v['tgl_pertek']);
                      ?>
                    </td>
                    <td width='300'><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
                    <td align='left'>
                      <?php
                      $lokasifile = './filepmk/';
                      $namafile = $v['berkas'];
                    
                      if (file_exists($lokasifile.$namafile.'.pdf')) {
                        $namafile=$namafile.'.pdf';
                      } else {
                        $namafile=$namafile.'.PDF';
                      }   

                      if (file_exists ($lokasifile.$namafile)) {
                        if ($this->mpegawai->gettmtpmkterakhir($nip) == $v['tmt_baru']) {
                          echo "<div>";
                          echo "<a class='btn btn-warning btn-xs' href='../filepmk/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>&nbspDownload</a>";  
                          ?>
                          <br />
                          Silahkan upload untuk update file
                          <form action="<?=base_url()?>upload/insertpmk" method="post" enctype="multipart/form-data">
                            <input type="file" name="filepmk" size="40" class="btn btn-xs btn-info" />
			    <input type='hidden' name='tmt' id='tmt' maxlength='20' value='<?php echo $v['tmt_baru']; ?>'>
                            <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                            <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                            <button type="submit" value="upload" class="btn btn-xs btn-success btn-outline">
                              <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>                          
                            </form>  
                            <?php
                            echo "</div>";
                          } else {
                            echo "<br/><a class='btn btn-warning btn-xs' href='../filepmk/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span><br/>Download</a>";
                          }
                        }

                        if (!file_exists ($lokasifile.$namafile)) {
                          if ($this->mpegawai->gettmtpmkterakhir($nip) == $v['tmt_baru']) {                           
                            echo "<div style='color: red'>File tidak tersedia, silahkan upload !!!</div>";
                            ?>
                            <form action="<?=base_url()?>upload/insertpmk" method="post" enctype="multipart/form-data">
                              <input type="file" name="filepmk" size="40" class="btn btn-xs btn-info" />
			      <input type='hidden' name='tmt' id='tmt' maxlength='20' value='<?php echo $v['tmt_baru']; ?>'>
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <button type="submit" value="upload" class="btn btn-xs btn-success btn-outline">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>                          
                              </form> 
                              <?php
                            }
                          }
                          ?>
                        </td>
                        <?php if(($this->session->userdata('level') == 'ADMIN') OR ($this->session->userdata('nip') == '198305142009041003')): ?>
                          <?php 
                          $found=false;//If no duplicate found then it will be zero
                          $duplicate = [];
                          foreach ($pegrwypmk as $r => $s) {
                              if($s['tmt_baru']===$v['tmt_baru']){
                                  // Duplicate Exist
                                  $found=true;
                                  $duplicate = $r;
                                  break;
                              }
                          }
                          ?>
                          <?php if($found && $duplicate === 0 && count($duplicate) > 0): ?>
			<td>
                        		<form action="/pegawai/hapus_rwy_pmk" method="post" enctype="multipart/form-data">
                        		<input type='hidden' name='nip' maxlength='20' value='<?php echo $nip; ?>'>
                        		<input type='hidden' name='id' maxlength='20' value='<?php echo $v['id']; ?>'>
                        		<button type="submit" value="Hapus" class="btn btn-sm btn-danger btn-outline">
                                <span class="glyphicon glyphicon-trash" aria-hidden="false"></span><br/>Hapus
                            </button>                          
                            </form> 
                        </td>
                          <?php endif; ?>
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

<div id="entripmk" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
        	<div class="modal-content">
                	<form method='POST' name='f_entripmk' action='../pegawai/tambah_rwypmk_aksi'>
                        	<input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                                <div class='modal-header'>
                                	<span class='text-info'>Tambah Riwayat PMK<br/><b><?php echo $this->mpegawai->getnama($nip);?></b></span>
                                </div>
                                <div class="modal-body" align="left" style='width: 100%;'>
					<div class='row' style='padding-bottom: 10px; padding-left: 5px;'>
						<div class='col-md-8' align='center'>
                                        	  <div class="input-group input-group-sm">
                                                       <span class="input-group-addon">Pangkat / Golru</span>
                                                       <select class="form-control" name="fid_golru" id="fid_golru" required>
                                                       <?php
                                                         $golru = $this->mpegawai->golru()->result_array();
                                                         echo "<option value='-'>-- Pilih Pangkat/Golru --</option>";
                                                         foreach($golru as $g)
                                                         {
                                                            echo "<option value='".$g['id_golru']."'>".$g['nama_pangkat']." (".$g['nama_golru'].")</option>";
                                                         }
                                                       ?>
                                                       </select>
                                                  </div>
						</div>
                                         </div>
                                         <div class='row' style='padding: 3px;'>
                                                <div class='col-md-6' align='center'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">MK Lama Tahun</span>
                                                        <input type="text" name='mklama_thn' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                                <div class='col-md-6' align='right'>
                                                    <div class="input-group input-group-sm">
                                                         <span class="input-group-addon">MK Lama Bulan</span>
                                                         <input type="text" name='mklama_bln' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                         </div>
                                         <div class='row' style='padding:3px;'>
                                                <div class='col-md-6' align='left'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">TMT Lama</span>
                                                        <input type="text" name='tmt_lama' class="form-control" placeholder="" value="" />
                                                    </div>
						    <span class='text text-info'>Format : hh-bb-tttt</span>
                                                </div>
                                                <div class='col-md-6' align='right'>
                                                    <div class="input-group input-group-sm">
                                                         <span class="input-group-addon">Gapok Lama</span>
                                                         <input type="text" name='gapok_lama' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                         </div>
                                         <div class='row' style='padding-left: 5px; padding-top:10px; padding-right:5px''>
                                                <div class='col-md-6' align='center'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">MK Baru Tahun</span>
                                                        <input type="text" name='mkbaru_thn' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                                <div class='col-md-6' align='right'>
                                                    <div class="input-group input-group-sm">
                                                         <span class="input-group-addon">MK Baru Bulan</span>
                                                         <input type="text" name='mkbaru_bln' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                         </div>
                                         <div class='row' style='padding:5px;'>
                                                <div class='col-md-6' align='left'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">TMT Baru</span>
                                                        <input type="text" name='tmt_baru' class="form-control" placeholder="" value="" />
                                                    </div>
						    <span class='text text-info'>Format : hh-bb-tttt</span>	
                                                </div>
                                                <div class='col-md-6' align='right'>
                                                    <div class="input-group input-group-sm">
                                                         <span class="input-group-addon">Gapok Baru</span>
                                                         <input type="text" name='gapok_baru' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                         </div>
                                         <div class='row' style='padding-top:10px; padding-left: 5px; padding-right:5px'>
                                                <div class='col-md-7' align='center'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">No. Pertek</span>
                                                        <input type="text" name='no_pertek' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                                <div class='col-md-5' align='left'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">Tgl. Pertek</span>
                                                        <input type="text" name='tgl_pertek' class="form-control" placeholder="" value="" />
                                                    </div>
						    <span class='text text-info'>Format : hh-bb-tttt</span>
                                                </div>
					 </div>
                                         <div class='row' style='padding-top:10px; padding-left: 5px; padding-right:5px'>
                                                <div class='col-md-7' align='center'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">Pejabat SK</span>
                                                        <input type="text" name='pejabat_sk' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                         </div>
                                         <div class='row' style='padding:5px;'>
                                                <div class='col-md-7' align='center'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">No. SK</span>
                                                        <input type="text" name='no_sk' class="form-control" placeholder="" value="" />
                                                    </div>
                                                </div>
                                                <div class='col-md-5' align='left'>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">Tgl. SK</span>
                                                        <input type="text" name='tgl_sk' class="form-control" placeholder="" value="" />
                                                    </div>
						    <span class='text text-info'>Format : hh-bb-tttt</span>
                                                </div>
                                         </div>

				</div> <!-- end modal body -->
                                <div class="modal-footer">
                                	<button type="submit" class="btn btn-success btn-outline">
                                           <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
                                        </button>

                                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
                                           <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspClose
                                        </button>
				</div> <!-- end footer -->
			</form> <!-- end form -->
 		</div> <!-- end modal-content -->
	</div> <!-- end modal-dialog -->
</div> <!-- end modal Tambah -->
