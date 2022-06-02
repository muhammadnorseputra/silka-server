<?php
  if ($pesan != '') {
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

<center>  
  <div class="panel panel-default" style="width: 80%;">
    <div class="panel-body">
      <table class='table table-condensed'>
        <tr> 
          <td align='right'>
            <?php
            if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') != "TAMU")) { 
              echo "<form method='POST' action='../nonpns/tambahrwypdk'>";
            ?>               
                <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>' />        
                <button type='submit' class='btn btn-success btn-sm'>
                  <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>&nbspTambah Riwayat Pendidikan
                </button>
            <?php
               echo "</form>";
            }
            ?>
          </td>  

          <td align='right' width='50'>
            <?php
              echo "<form method='POST' action='../nonpns/nonpnsdetail'>";          
              echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$nik'>";
            ?>
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            <?php
              echo "</form>";          
            ?>
          </td>  
        </tr>
      </table> 

      <div class="panel panel-success">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-education" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT PENDIDIKAN</b><br />';
          echo $this->mnonpns->getnama($nik);
          echo " ::: NIK. ".$nik
        ?>
        </div>
        <table class="table table-condensed">
          <tr>
            <td align='center'>
                <table class='table table-hover table-condensed'>
                  <tr class='success'>
                    <th width='20'><center>#</center></th>
                    <th width='250'><center>Tingkat<br />Jurusan</center></th>
                    <th align='50'><center>Tahun Lulus</center></th>                    
                    <th align='100'><center>Gelar Akademik</center></th>
                    <th width='350'><center>Nama Sekolah</center></th>
                    <th width='350'><center>Ijazah / STTB</center></th>
                    <th colspan='4'><center>Aksi</center></th>
                  </tr>
                  <?php
                    $no=1;
                    foreach($rwypdk as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <?php
                      $tingpen = $this->mpegawai->gettingpen($v['fid_tingkat']);
                      if ($tingpen == 'SD') {
                        echo '<td>'.$this->mpegawai->getjurpen($v['fid_jurusan']).'</td>';                      
                      } else {
                        echo '<td>'.$tingpen.'<br />'.$this->mpegawai->getjurpen($v['fid_jurusan']).'</td>';
                        
                      }
                    ?>
                    <td align='center'><?php echo $v['thn_lulus']; ?></td>
                    <td align='center'><?php echo $v['gelar']; ?></td>
                    <td><?php echo $v['nama_sekolah']; ?></td>                    
                    <td width='300'><?php echo $v['nama_kepsek'].'<br />Nomor : '.$v['no_sttb'].'<br />Tanggal : '.tgl_indo($v['tgl_sttb']); ?></td>

                    <td align='center'>
                      <?php
                      echo "<form method='POST' action='../nonpns/editrwypdk'>";          
                      echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$nik'>";
                      echo "<input type='hidden' name='fid_tingkat' id='fid_tingkat' maxlength='4' value='$v[fid_tingkat]'>";
                      ?>
                      <button type="submit" class="btn btn-success btn-xs ">
                      <span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                      </button>
                      <?php
                        echo "</form>";
                      ?>
                    </td>
                    <td align='center'>
                      <?php
                      echo "<form method='POST' action='../nonpns/hapusrwypdk'>";          
                      echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$nik'>";
                      echo "<input type='hidden' name='fid_tingkat' id='fid_tingkat' maxlength='4' value='$v[fid_tingkat]'>";
                      ?>
                      <button type="submit" class="btn btn-warning btn-xs ">
                      <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
                      </button>
                      <?php
                        echo "</form>";
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