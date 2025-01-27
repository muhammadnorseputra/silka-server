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
          <td align='right' width='50'>
            <?php
              echo "<form method='POST' action='../pppk/detail'>";          
              echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$nipppk'>";
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

      <div id='rwypkj'></div>
    
      <div class="panel panel-default">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-plane" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT CUTI</b><br />';
          echo $this->mpppk->getnama($nipppk);
          echo " ::: NIPPPK. ".$nipppk
        ?>
        </div>
	<div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
		  <table class='table table-condensed table-hover'>
                    <tr class='warning'>
                      <th width='20'><center>#</center></th>
                      <th width='60'><center>Tahun</center></th>
                      <th width='200'><center>Jenis Cuti</center></th>
                      <th width='150'><center>Lama</center></th>
                      <th width='150'><center>Tgl. Mulai<br />Tgl. Selesai</center></th>
                      <!--<th><center>Alamat</center></th>-->
                      <th width='400'><center>Surat Keputusan</center></th>
                    </tr>
                    <?php
                      $no=1;
                      foreach($pegrwycuti as $v):
                    ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td align='center'><?php echo $v['thn_cuti']; ?></td>
                      <td>
			<?php 
				echo $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
				echo "<br/><small>".$v['ket_jns_cuti']."</small>";
			?>
		      </td>
                      <td align='center'>
                        <?php echo $v['jml'].' '.$v['satuan_jml']; ?>
                      </td>
                      <td align='center'><?php echo tgl_indo($v['tgl_mulai']).'<br />s/d<br />'.tgl_indo($v['tgl_selesai']); ?></td>
                      <!--<td><?php //echo $v['alamat']; ?></td>-->
                      <td><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
		    </tr>
                    <?php
                      $no++;
                      endforeach;
                    ?>
                  </table>	
			
	</div> <!-- End Scroll -->
</center>
