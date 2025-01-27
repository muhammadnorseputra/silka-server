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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT KENAIKAN GAJI BERKALA</b><br />';
          echo $this->mpppk->getnama($nipppk);
          echo " ::: NIPPPK. ".$nipppk
        ?>
        </div>
	<div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
                <br />
		  <table class='table table-hover table-condensed'>
                    <tr class='warning'>
                      <th width='20'><center>#</center></th>
                      <th width='150'><center>TMT</center></th>
                      <th width='150'><center>Masa Kerja</center></th>
                      <th width='200'><center>Gaji Pokok</center></th>
                      <th width='150'><center>Golru</center></th>
                      <th width='400'><center>Surat Keputusan</center></th>
                    </tr>
                    <?php
                      $no=1;
                      foreach($pegrwykgb as $v):
			//var_dump($v);
                    ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td align='center'><?php echo tgl_indo($v['tmt']);?></td>
                      <td align='center'><?php echo $v['mk_thn']." Tahun ".$v['mk_bln']." Bulan"; ?></td>
                      <td align='center'><?php echo "Rp. ".indorupiah($v['gapok']); ?></td>
                      <td align='center'><?php echo $this->mpppk->getnamagolru($v['fid_golru']); ?></td>
                      <td><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
		    </tr>
                    <?php
                      $no++;
                      endforeach;
                    ?>
                  </table>	
			
	</div> <!-- End Scroll -->
</center>
