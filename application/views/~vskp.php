<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
    <table class='table table-condensed'>
        <tr>
          <td align='right'>
            <form method="POST" action="../crudskp/tambah">
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah SKP
                </button>
            </form>
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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-grain" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT SKP</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

        <table class="table">
          <tr>
            <td align='center'>
              <table class='table table-condensed table-hover table-bordered'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='50'><center>Tahun</center></th>
                    <th align='200'><center>Jenis</center></th>
                    <th width='50'><center>Nilai<br />SKP</center></th>
                    <th width='50'><center>Nilai<br />Prilaku Kerja</center></th>
                    <th width='50'><center>Nilai<br />Prestasi Kerja</center></th>
                    <th width='300'><center>Pejabat Penilai</center></th>
                    <th width='300'><center>Atasan Pejabat Penilai</center></th>
                    <th width='100'><center>Aksi</center></th>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwyskp as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='center'><?php echo $v['tahun']; ?></td>
                    <td><?php echo $v['jns_skp']; ?></td>
                    <td><?php echo $v['nilai_skp']; ?></td>
                    <td><?php echo $v['nilai_prilaku_kerja']; ?></td>
                    <td><?php echo $v['nilai_prestasi_kerja']; ?></td>
                    <td><?php echo $v['nip_pp'].'<br />'.$v['nama_pp'].'<br />'.$this->mpegawai->getnamapangkat($v['fid_golru_pp']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_pp']).')<br />'.$v['jab_pp'].'<br />'.$v['unor_pp']; ?></td>                    
                    <td><?php echo $v['nip_app'].'<br />'.$v['nama_app'].'<br />'.$this->mpegawai->getnamapangkat($v['fid_golru_app']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_app']).')<br />'.$v['jab_app'].'<br />'.$v['unor_app']; ?></td>
                    <td align='center'>
                    <?php
                    echo "<form method='POST' action='../pegawai/dtlskp'>";          
                    echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
                    echo "<input type='hidden' name='thn' id='nip' maxlength='4' value='$v[tahun]'>";
                    ?>
                    <button type="submit" class="btn btn-success btn-xs ">
                    <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span> Detail
                    </button>
                    <?php
                      echo "</form>";
                    ?>

                    <!-- memeriksa file skp -->
                    <?php
                      $lokasifile='./fileskp/';
                      $namafile=$nip.'-'.$v['tahun'].'.pdf';
                      if (file_exists ($lokasifile.$namafile))
                        echo "<br /><a class='btn btn-info btn-xs' href='../fileskp/$namafile' target='_blank' role='button'>
                              <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                              Download</a>";
                      else
                        echo "<br /><h5><span class='label label-danger'>File Tidak Ada</span></h5>";
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
      </div>    
    </div>
  </div>  
</center>