<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 

  <?php
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
  <div class="panel-heading" align="left">
  <b>PROSES CUTI</b><br />
  <?php echo "Jumlah Data : ", $this->mcuti->getjmlpengantarbystatus(3), " Pengantar"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:380px;border:1px solid white" >
  <table class="table table table-condensed table-hover">
      <tr class='warning'>
        <td align='center' width='30'><b>No.</b></td>
        <td align='center' width='200'><b>No. Pengantar</b><br/>Tgl. Pengantar</td>
        <td align='center' ><b>Unit Kerja</b></td>
        <!--<td align='center' width='150'><b>Kelompok Cuti</b></td>-->
        <td align='center' width='50'><b>Jumlah Usul</b></td>
        <!--<td align='center' width='200'><b>Created</b></td>-->
        <td align='center' colspan='2' width='50'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($cuti as $v):          
      ?>

      <?php
      if ($v['kelompok_cuti'] == 'CUTI TUNDA' ) {
        echo "<tr class='danger'>";
      } else {
        echo "<tr>";
      }
      ?>      
        <td align='center'><?php echo $no; ?></td>
        <td><?php echo $v['no_pengantar'].'<br/>'.tgl_indo($v['tgl_pengantar']); ?></td>
	<?php
	$get_jnsasn = $this->mcuti->get_jnsasn($v['id_pengantar']);
	$kelompok_cuti = $this->mcuti->getkelompok($v['id_pengantar']);

        if ($get_jnsasn == "PNS") {
		$jml = $this->mcuti->getjmldetailpengantar($v['id_pengantar'], $kelompok_cuti);
		$jenis = "<span class='label label-success'>PNS</span>";
	} else if ($get_jnsasn == "PPPK") {
		$jml = $this->mcuti->getjmldetailpengantar_pppk($v['id_pengantar'], $kelompok_cuti);
		$jenis = "<span class='label label-warning'>PPPK</span>";
	}
	echo "<td>".$this->munker->getnamaunker($v['fid_unit_kerja'])."<br/>".$jenis."</td>";
	?>
        <!--
	<td><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
        <td><?php //echo $v['kelompok_cuti']; ?></td>
	-->
        <td align='center'><span class="badge"><?php echo $jml; ?></span></td>
        <!--<td><?php //echo tglwaktu_indo($v['created_at']).'<br />'.$this->mpegawai->getnama($v['created_by']); ?></td>-->
        
        <td align='center'>
          <?php
          echo "<form method='POST' action='../cuti/detailproses'>";          
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
          echo "<input type='hidden' name='kelompok_cuti' id='kelompok_cuti' value='$v[kelompok_cuti]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-xs ">
          <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Detail Usul
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
        <!--
        <td align='right'>
          <?php          
            echo "<form method='POST' action='../cuti/cetakpengantar' target='_blank'>";          
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
            echo "<input type='hidden' name='tgl_pengantar' id='tgl_pengantar' value='$v[tgl_pengantar]'>";
            echo "<input type='hidden' name='id_unker' id='id_unker' value='$v[fid_unit_kerja]'>";
            ?>
            <button type="submit" class="btn btn-primary btn-xs">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Cetak Pengantar
            </button>
            </form>
        </td>        
        -->
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>
</div>
</div>
</div>
</div>
</center>
