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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-queen" aria-hidden="true"></span>        
        <?php
          echo '<b>RIWAYAT PENGHARGAAN</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <table class="table table-bordered">
          <tr>
            <td colspan='2' align='center'>                            
                <table class='table table-condensed table-hover table-bordered'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th width='550'><center>Nama</center></th>
                    <th align='50'><center>Tahun</center></th>
                    <th width='400'><center>Surat Keputusan</center></th>
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