<center>  
  <div class="panel panel-info" style="width: 80%">
    <div class="panel-body">
      <?php
      echo "<form method='POST' action='../pegawai/detail'>";          
      echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
      <p align="right">
        <button type="submit" class="btn btn-warning btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
        </button>
      </p>
      <?php
      echo "</form>";          
      if ($pesan != '') {
        ?>
        <div class="<?php echo $jnspesan; ?>" alert-info role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php
          echo $pesan;
          ?>          
        </div> 
        <?php
      }
      ?> 

      <div class="panel panel-warning">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
          <?php
          echo '<b>RIWAYAT HUKUMAN DISIPLIN</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
          ?>
          <br/>
          <small style="color:red">Penambahan dan Update Riwayat Hukuman Disiplin hanya dapat dilakukan melalui Layanan SIADIS</small>
        </div>

        <div style="padding:3px;overflow:auto;width:99%;height:390px;border:1px solid white" >
          <table class='table table-hover table-condensed'>
            <tr class='success'>
              <th width='20'><center>#</center></th>
              <th width='350'><center>Jenis Hukuman</center></th>
              <th width='120'><center>TMT Hukuman</center></th>
              <th width='80'><center>Lama Hukuman</center></th>
              <th width='250'><center>Surat Keputusan</center></th>
              <th width='50' colspan='2'><center>Aksi</center></th>
            </tr>
            <?php
            $no=1;
            foreach($pegrwyhd as $v):                    
              ?>
            <tr>
              <td align='center'><?php echo $no;?></td>
              <?php
              $jnshd = $this->mpegawai->getjnshukdis($v['fid_jenis_hukdis']);
              ?>
              <td><?php
                    echo '<b>'.$jnshd.'</b>';
                    echo '<br/><small style=color:blue><small>'.$v['deskripsi'].'</small></small>';
                  ?>
              </td>
              <td align='center'>
                <?php 
                  echo tgl_indo($v['tmt_hukuman']);
                  if ($v['akhir_hukuman'] != null) {
                  echo '<br/>s/d<br/><u>'.tgl_indo($v['akhir_hukuman']).'</u>';
                  }
                ?>
              </td>
              <td align='center'><?php echo $v['lama_thn'].' Tahun<br/>'.$v['lama_bln'].' Bulan'; ?></td>
              <td><?php echo '<small>'.$v['pejabat_sk'].'<br/>No. SK. '.$v['no_sk'].'<br/>Tgl. SK. '.tgl_indo($v['tgl_sk']).'</small>'; ?>
                <?php
                $lokasifile = './filehd/';
                $namafile = $v['berkas'];

                if (file_exists($lokasifile.$namafile.'.pdf')) {
                  $namafile=$namafile.'.pdf';
                } else {
                  $namafile=$namafile.'.PDF';
                }   

                if (file_exists ($lokasifile.$namafile)) {
                    echo "<div>";
                    echo "<a class='btn btn-warning btn-xs' href='../filehd/$namafile' target='_blank' role='button'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>&nbspDownload SK</a>";  
                    echo "</div>";
                } else {
                  echo "<div style='color: red'>File SK tidak tersedia, silahkan upload !!!</div>";
                }
                ?>
              </td>
              <td align='center' width='30'>
                <form method='POST' action='../hukdis/hapushd_aksi'>
                  <?php
                  if ($this->session->userdata('edit_profil_priv') == "Y") { 
                    echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                    echo "<input type='hidden' name='tmt' id='tmt' value='$v[tmt_hukuman]'>";
                    echo "<input type='hidden' name='jnshd' id='jnshd' value='$v[fid_jenis_hukdis]'>";
                    ?>
                    <button type="submit" class="btn btn-danger btn-xs">
                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>&nbspHapus
                    </button>
                    <?php
                  }
                  ?>
                </form>                      
              </td>  
              <td align='left'>
                <?php
                $lokasifile = './filehd/';
                $namafile = $v['berkas'];

                if (file_exists($lokasifile.$namafile.'.pdf')) {
                  $namafile=$namafile.'.pdf';
                } else {
                  $namafile=$namafile.'.PDF';
                }   

                if (file_exists ($lokasifile.$namafile)) {
                  echo "Upload ulang untuk mengganti file";
                }
                ?>
                <form action="<?=base_url()?>upload/inserthd" method="post" enctype="multipart/form-data">
                  <input type="file" name="filehd" size="40" class="btn btn-xs btn-info" />
                  <input type='hidden' name='nmberkaslama' id='nmberkaslama' maxlength='20' value='<?php echo $v['berkas']; ?>'>
                  <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                  <input type='hidden' name='tmt' id='tmt' value='<?php echo $v['tmt_hukuman']; ?>'>
                  <input type='hidden' name='jnshd' id='jnshd' value='<?php echo $v['fid_jenis_hukdis']; ?>'>
                  <button type="submit" value="upload" class="btn btn-xs btn-success">
                    <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>                          
                </form> 
              </td>
            </tr>
            <?php
            $no++;
            endforeach;
            ?>
          </table>              
        </div>
      </div>
    </div>
  </center>

