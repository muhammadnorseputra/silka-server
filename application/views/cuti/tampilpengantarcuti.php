<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 90%;">
  <div class="panel-body">

  <?php
  if ($this->session->flashdata('pesan') <> ''){
    ?>
    <div class="alert alert-dismissible alert-danger">
      <?php echo $this->session->flashdata('pesan');?>
    </div>
    <?php
  }
  ?>
  
  <table class='table table-condensed'>
    <tr>
      <?php
      // cek privilegde user session -- usulcuti_priv
      if ($this->session->userdata('usulcuti_priv') == "Y") { 
      ?>
      <td align='right'>
        <form method="POST" action="../cuti/tambahpengantar">
          <button type="submit" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Buat Pengantar
          </button>
        </form>
      </td>
      <?php
      }
      ?>
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

  <div class="panel panel-info">  
  <div class="panel-heading" align="left">
  <b>Pengantar Cuti</b><br />
  <?php echo "Jumlah Data : ", $this->mcuti->getjmlpengantarskpd(), " Pengantar"; ?>
  </div>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:450px;border:1px solid white" >
  <table class="table table table-condensed table-hover">
      <tr class='success'>
        <td align='center' width='40'><b>No.</b></td>
        <td align='center' width='200'><b>No. Pengantar<br/>Tgl. Pengantar</b></td>
        <td align='center' width='450'><b>Unit Kerja</b></td>
        <!--<td align='center' width='150'><b>Kelompok Cuti</b></td>-->
        <td align='center' width='50'><b>Jumlah Usul</b></td>
        <td align='center' width='50'><b>Status</b></td>
        <!--<td align='center' width='200'><b>Created</b></td>-->
        <td align='center' colspan='2'><b>Aksi</b></td>
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
        <td><?php
		echo $this->munker->getnamaunker($v['fid_unit_kerja']);
		if ($v['jenis'] == "PNS") {
			echo "<br/><span class='label label-success'>".$v['jenis']."</span>";
		} else if ($v['jenis'] == "PPPK") {
			echo "<br/><span class='label label-warning'>".$v['jenis']."</span>";
		}
	    ?>
	</td>
        <!--<td><?php //echo $v['kelompok_cuti']; ?></td>-->
        <?php
          $kelompok_cuti = $this->mcuti->getkelompok($v['id_pengantar']);
        ?>
        <td align='center'>
	<?php 
		if ($v['jenis'] == "PNS") {
			echo $this->mcuti->getjmldetailpengantar($v['id_pengantar'], $kelompok_cuti);
                } else if ($v['jenis'] == "PPPK") {
			echo $this->mcuti->getjmldetailpengantar_pppk($v['id_pengantar'], $kelompok_cuti);
                }
		//echo $this->mcuti->getjmldetailpengantar($v['id_pengantar'], $kelompok_cuti);
	?>
	</td>
        <td align='center'><?php echo $this->mcuti->getstatuspengantarcuti($v['fid_status']); ?></td>        
        <!--<td><?php //echo tglwaktu_indo($v['created_at']); ?></td>-->
        <td align='center' width='100'>
          <?php
          echo "<form method='POST' action='../cuti/detailpengantar'>";          
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
          echo "<input type='hidden' name='kelompok_cuti' id='kelompok_cuti' value='$v[kelompok_cuti]'>";
          ?>
          <button type="submit" class="btn btn-success btn-xs ">
          <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Lihat Usul
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
        <td align='right' width='100'>
          <?php 
	  
            if (($v['jenis'] == "PNS") AND ($this->mcuti->getjmldetailpengantar($v['id_pengantar'], $kelompok_cuti) != 0) 
		AND (($this->mcuti->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'SKPD') OR ($this->mcuti->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'CETAK'))) {
              echo "<form method='POST' action='../cuti/cetakpengantar' target='_blank'>";          
              echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
              echo "<input type='hidden' name='tgl_pengantar' id='tgl_pengantar' value='$v[tgl_pengantar]'>";
              echo "<input type='hidden' name='id_unker' id='id_unker' value='$v[fid_unit_kerja]'>";
              ?>
              <button type="submit" class="btn btn-primary btn-xs">
              <span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Cetak Pengantar
              </button>
              </form>
              <?php
	    } else if (($v['jenis'] == "PPPK") AND ($this->mcuti->getjmldetailpengantar_pppk($v['id_pengantar'], $kelompok_cuti) != 0)
                AND (($this->mcuti->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'SKPD') OR ($this->mcuti->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'CETAK'))) {
              echo "<form method='POST' action='../cuti/cetakpengantar' target='_blank'>";
              echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
              echo "<input type='hidden' name='tgl_pengantar' id='tgl_pengantar' value='$v[tgl_pengantar]'>";
              echo "<input type='hidden' name='id_unker' id='id_unker' value='$v[fid_unit_kerja]'>";
              ?>
              <button type="submit" class="btn btn-primary btn-xs">
              <span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Cetak Pengantar
              </button>
              </form>
              <?php
            } else {
              echo "<button class='btn btn-primary btn-xs disabled'>";
              echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span><br />Cetak Pengantar";
              echo "</button>";
            }
            ?>
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
</div>
</center>
