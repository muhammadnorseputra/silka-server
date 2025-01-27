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
          echo '<b>RIWAYAT KENAIKAN GAJI BERKALA</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <div style="padding:3px;overflow:auto;width:99%;height:390px;border:1px solid white" >
        <?php
	// Aksesn unt Admin dan Bani Disdikbud
	 if (($this->session->userdata('level') == 'ADMIN') OR ($this->session->userdata('nip') == '198305142009041003')){ ?>
        <form method='POST' action='../pegawai/tambah_rwy_kgb_terakhir/'>
        <input type='hidden' name='nip' id='nip' maxlength='18' value='<?= $nip ?>'>
        <button type="submit" class="btn btn-sm btn-primary pull-right" style="margin-bottom:15px; margin-top:15px;">
        	<i class="glyphicon glyphicon-plus"></i>	Tambah KGB Terakhir
        </button>
        </form>
        <?php } ?>
        <table class="table table-bordered">
          <tr>
            <td align='center'>   
              
        <div class="alert alert-danger" role="alert">
          <b>UNTUK PERHATIAN</b> <br>Pastikan format file yang diupload <code>pdf</code> huruf kecil dan maksimal ukuran file <code>800kb</code>
        </div>                         
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th align='150'><center>Gaji Pokok</center></th>
                    <th width='150'><center>Dalam Pangkat /<br />Golongan Ruang</center></th>
                    <th align='50'><center>TMT<br />Masa Kerja</center></th>
                    <th><center>Surat Keputusan</center></th>
                    <th><center>Aksi</center></th>
                    <?php if(($this->session->userdata('level') == 'ADMIN') OR ($this->session->userdata('nip') == '198305142009041003')): ?>
                    <th>Edit</th>
                    <th>Hapus</th>
                    <?php endif; ?>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwykgb as $k => $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='left'>
			<?php
				echo 'Rp. ',indorupiah($v['gapok']);
				if ($v['is_sync_simgaji'] == 1)
				echo "<br/><span class='label label-info'><span class='glyphicon glyphicon-ok'></span> Sync INEXIS</span>";

			?>
		    </td>
                    <td><?php echo $this->mpegawai->getnamapangkat($v['fid_golru']).'<br />'.$this->mpegawai->getnamagolru($v['fid_golru']); ?></td>
                    <td align='center'><?php echo tgl_indo($v['tmt']); ?><br />
                      <?php                    
                      echo $v['mk_thn'].' Tahun '.$v['mk_bln'].' Bulan</td>';
                      ?>
                    </td>
                    <td width='300'><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
                    <td align='left'>
                      <?php
                      $lokasifile = './filekgb/';
                      $namafile = $v['berkas'];
                    
                      if (file_exists($lokasifile.$namafile.'.pdf')) {
                        $namafile=$namafile.'.pdf';
                      } else {
                        $namafile=$namafile.'.PDF';
                      }   

                      if (file_exists ($lokasifile.$namafile)) {
                        if ($this->mpegawai->gettmtkgbterakhir($nip) == $v['tmt']) {
                          echo "<div>";
                          echo "<a class='btn btn-warning btn-xs' href='../filekgb/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>&nbspDownload</a>";  
                          ?>
                          <br />
                          Silahkan upload untuk update file
                          <form action="<?=base_url()?>upload/insertkgb" method="post" enctype="multipart/form-data">
                            <input type="file" name="filekgb" size="40" class="btn btn-xs btn-info" />
                            <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                            <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                            <input type='hidden' name='mkthn' id='mkthn' value='<?php echo $v['mk_thn']; ?>'>
                            <input type='hidden' name='mkbln' id='mkbln' value='<?php echo $v['mk_bln']; ?>'>
                            <button type="submit" value="upload" class="btn btn-xs btn-success">
                              <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>                          
                            </form>  
                            <?php
                            echo "</div>";
                          } else {
                            echo "<br/><a class='btn btn-warning btn-xs' href='../filekgb/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span><br/>Download</a>";
                          }
                        }

                        if (!file_exists ($lokasifile.$namafile)) {
                          if ($this->mpegawai->gettmtkgbterakhir($nip) == $v['tmt']) {                           
                            echo "<div style='color: red'>File tidak tersedia, silahkan upload !!!</div>";
                            ?>
                            <form action="<?=base_url()?>upload/insertkgb" method="post" enctype="multipart/form-data">
                              <input type="file" name="filekgb" size="40" class="btn btn-xs btn-info" />
                              <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                              <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                              <input type='hidden' name='mkthn' id='mkthn' value='<?php echo $v['mk_thn']; ?>'>
                              <input type='hidden' name='mkbln' id='mkbln' value='<?php echo $v['mk_bln']; ?>'>
                              <button type="submit" value="upload" class="btn btn-xs btn-success">
                                <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>                          
                              </form> 
                              <?php
                            }
                          }
                          ?>
                        </td>
                        <?php if(($this->session->userdata('level') == 'ADMIN') OR ($this->session->userdata('nip') == '198305142009041003')): ?>
                        	<td>
                        		<form action="/pegawai/edit_rwy_kgb" method="post" enctype="multipart/form-data">
                        		<input type='hidden' name='nip' maxlength='20' value='<?php echo $nip; ?>'>
                        		<input type='hidden' name='id' maxlength='20' value='<?php echo $v['id']; ?>'>
                        		<button type="submit" value="Edit" class="btn btn-xs btn-success">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="false"></span>&nbspEdit
                            </button>                          
                            </form> 
                        	</td>
                          <?php 
                          $found=false;//If no duplicate found then it will be zero
                          $duplicate = [];
                          foreach ($pegrwykgb as $r => $s) {
                              if($s['gapok']===$v['gapok']){
                                  // Duplicate Exist
                                  $found=true;
                                  $duplicate = $r;
                                  break;
                              }
                          }
                          ?>
                          <?php if($found && $duplicate === 0 && count($duplicate) > 0): ?>
                          <td>
                        		<form action="/pegawai/hapus_rwy_kgb" method="post" enctype="multipart/form-data">
                        		<input type='hidden' name='nip' maxlength='20' value='<?php echo $nip; ?>'>
                        		<input type='hidden' name='id' maxlength='20' value='<?php echo $v['id']; ?>'>
                        		<button type="submit" value="Hapus" class="btn btn-xs btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="false"></span>&nbspHapus
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
