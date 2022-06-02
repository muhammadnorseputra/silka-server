<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
    <table class='table table-condensed'>
        <tr>
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
      if ($pesan != '') {
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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT CUTI</b><br />';
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
                    <th width='60'><center>Tahun</center></th>
                    <th align='200'><center>Jenis Cuti</center></th>
                    <th width='80'><center>Lama</center></th>
                    <th width='150'><center>Tgl. Mulai<br />Tgl. Selesai</center></th>
                    <th><center>Alamat</center></th>
                    <th width='400'><center>Surat Keputusan</center></th>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwycuti as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='center'><?php echo $v['thn_cuti']; ?></td>
                    <td><?php echo $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']); ?></td>
                    <td align='center'><?php echo $v['jml'].' '.$v['satuan_jml']; ?></td>
                    <td align='center'><?php echo tgl_indo($v['tgl_mulai']).'<br />s/d<br />'.tgl_indo($v['tgl_selesai']); ?></td>
                    <td><?php echo $v['alamat']; ?></td>
                    <td><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.$v['tgl_sk']; ?></td>                    
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