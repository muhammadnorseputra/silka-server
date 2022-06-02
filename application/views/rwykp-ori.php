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
      
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-star" aria-hidden="true"></span>        
        <?php
          echo '<b>RIWAYAT PANGKAT</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <div style="padding:3px;overflow:auto;width:99%;height:390px;border:1px solid white" >
        <table class="table table-bordered">
          <tr>
            <td colspan='2' align='center'>                            
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='200'><center>Pangkat / Golru<br />TMT<br/>Gaji Pokok</center></th>
                    <th width='300'><center><u>Dalam Jabatan</u><br />Angka Kredit<br /><i>Masa Kerja</i></center></th>
                    <th width='200'><center>Surat Keputusan</center></th>
                    <th width='80'></th>
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
                    <td align='center'>
                      <?php
                        if ($this->mpegawai->gettmtkpterakhir($nip) == $v['tmt']) {
                          ?>
                          <tr>
                          <td></td>
                          <td colspan='2' align='center'>
                          <?php
                          $lokasifile = './filekp/';
                          $namafile = $v['berkas'];

                          if (file_exists($lokasifile.$namafile.'.pdf')) {
                            $namafile=$namafile.'.pdf';
                          } else {
                            $namafile=$namafile.'.PDF';
                          }

                          if (file_exists ($lokasifile.$namafile))
                            echo "<a class='btn btn-info btn-xs' href='../filekp/$namafile' target='_blank' role='button'>
                          <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                          Download File Berkas SK KP Terakhir</a><br />Silahkan upload untuk memperbarui file, 
                          harus dengan format .pdf ukuran maksimal 2 MB !!!";
                          else
                            echo "<h4><span class='label label-warning'>File berkas SK Pangkat Terakhir tidak tersedia, silahkan upload !!!</span></h4>";
                          ?>
                          </td>
                          <form action="<?=base_url()?>upload/insertkp" method="post" enctype="multipart/form-data">
                          <td align='right'>
                            <input type="file" name="filekp" size="40" class="btn btn-sm btn-info" />
                            <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                            <input type='hidden' name='nmberkaslama' id='nmberkaslama' value='<?php echo $v['berkas']; ?>'>
                            <input type='hidden' name='id_golru' id='id_golru' value='<?php echo $v['fid_golru']; ?>'>
                          </td>
                          <td align='left'>
                            <button type="submit" value="upload" class="btn btn-sm btn-success">
                            <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspUpload</button>
                          </td>
                          </form>
                        <?php
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