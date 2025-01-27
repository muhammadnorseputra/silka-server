<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">

  <?php
	$get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
	if ($get_jnsasn == "PNS") {
		$ket_jnsasn = "PNS";
		$cljns = "success";
		$lbspan = "<span class='label label-success'>Jenis ASN : PNS</span>";
       	} else if ($get_jnsasn == "PPPK") {
		$ket_jnsasn = "PPPK";
		$cljns = "warning";
		$lbspan = "<span class='label label-warning'>Jenis ASN : PPPK</span>";
        }
  ?>
  
  <table class='table table-condensed'>
    <tr>
      <td align='right'>
      <?php
      // cek privilegde user session -- usulcuti_priv
      if ($this->session->userdata('usulcuti_priv') == "Y") { 
      ?>
      <td align='right'>
        <?php
        // jika status sudah cetak maka tidak bisa tambah usul lagi
        if ($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'SKPD') {
        ?>
          <form method="POST" action="../cuti/tambahusul">
            <?php
            echo "<input type='hidden' name='id_pengantar' id='fid_pengantar' value='$idpengantar'>";
            ?>
            <button type="submit" class="btn btn-<?php echo $cljns; ?> btn-sm">
              <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Tambah Usul <?php echo $ket_jnsasn;?>
            </button>
          </form>
        <?php
        }
        ?>
      </td>
      <?php
      }
      ?>
      </td>
      <td align='right' width='50'>
        <form method="POST" action="../cuti/tampilpengantar">
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

  <div class="panel panel-<?php echo $cljns; ?>">  
  <div class="panel-heading" align="left">
  <b>Pengantar Nomor : <?php echo $nopengantar; ?></b><br />
  <?php echo $this->mcuti->getunker_pengantar($idpengantar); ?>	
  <?php echo "<br/>Jenis ASN : ".$ket_jnsasn; ?>
  <?php echo " | Jumlah Data : ", $jmldata, " Usul"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:300px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='<?php echo $cljns;?>'>
        <td align='center'><b>No</b></td>
        <td align='center' width='220'><b>Nomor Induk <?php echo $ket_jnsasn; ?> | Nama</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center' width='120'><b>Jenis Cuti</b></td>
        <td align='center' width='150'><b>Lama</b></td>
        <!--<td align='center' width='120'><b>Entry Usul</b></td>-->
        <td align='center' width='120'><b>Status</b></td>
        <td align='center' colspan='3'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($cuti as $v):          
      ?>

      <tr>
        <td align='center'><?php echo $no; ?></td>
	<?php
	$get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
        if ($get_jnsasn == "PNS") {
		$nip = $v['nip'];
		if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          	}else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          	}else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          	}
	?>
		<td><?php echo $v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></td>
        	<td><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja']; ; ?></td>
	<?php	
        } else if ($get_jnsasn == "PPPK") {
		$nip = $v['nipppk'];
	?>
		<td><?php echo $v['nipppk'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk']); ?></td>
   		<td><?php echo $this->mpegawai->namajab('3',$v['fid_jabft']), '<br />', $v['nama_unit_kerja']; ?></td>
	<?php
        }
	?>
        <td align='center'><?php echo $v['nama_jenis_cuti'], '<br />Tahun ',$v['thn_cuti']; ?></td>
        <?php
        $jnscuti = $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
        //if (($jnscuti == 'CUTI TAHUNAN') AND ($v['tambah_hari_tunda'] != 0)) {
        //  echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].' + '.$v['tambah_hari_tunda'].' HARI<br />'.tgl_indo($v['tgl_mulai']).'<br />s/d '.tgl_indo($v['tgl_selesai'])."</td>";
        //}  else {
          echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].'<br />'.tgl_indo($v['tgl_mulai']).'<br />s/d '.tgl_indo($v['tgl_selesai'])."</td>";
        //}
        ?>
        <!--<td align='center'><?php //echo $v['tgl_usul']; ?></td>-->
        <td align='center'><?php echo $this->mcuti->getstatuscuti($v['fid_status']); ?></td>
        <td align='center'>
          <?php
          if (($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXSKPD') OR ($this->mcuti->getstatuscuti($v['fid_status']) == 'CETAKUSUL')) {
            echo "<form method='POST' action='../cuti/detailusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-success btn-xs'>";
            echo "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-success btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span><br />Detail";
            echo "</button>";
          }
          ?>
        </td>
        <td align='center'>
          <?php
          if (($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXSKPD') OR ($this->mcuti->getstatuscuti($v['fid_status']) == 'CETAKUSUL')) {
            echo "<form method='POST' action='../cuti/cetakusul' target='_blank'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";          
            echo "<button type='submit' class='btn btn-primary btn-xs'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span><br />Cetak";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-primary btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span><br />Cetak";
            echo "</button>";
          }
          ?>
        </td>
	<!--
        <td align='center'>
          <?php
          if (($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'SKPD') AND (($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXSKPD') OR ($this->mcuti->getstatuscuti($v['fid_status']) == 'CETAKUSUL'))) {
            echo "<form method='POST' action='../cuti/editusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-warning btn-xs'>";
            echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span><br />&nbspEdit&nbsp";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-warning btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span><br />&nbspEdit&nbsp";
            echo "</button>";            
          }
          ?>
        </td>
	-->
        <td align='center'>
          <?php
          if (($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'SKPD') AND 
	     (($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXSKPD') OR ($this->mcuti->getstatuscuti($v['fid_status']) == 'CETAKUSUL'))) {
            echo "<form method='POST' action='../cuti/hapus_cuti'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
            echo "<input type='hidden' name='tahun' id='tahun' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<input type='hidden' name='tgl_mulai' id='tgl_mulai' value='$v[tgl_mulai]'>";
	    echo "<input type='hidden' name='tgl_selesai' id='tgl_selesai' value='$v[tgl_selesai]'>";
	    echo "<button type='submit' class='btn btn-danger btn-xs'>";
            echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br />Hapus";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<button class='btn btn-danger btn-xs disabled'>";
            echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br />Hapus";
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
        <?php
	if ($get_jnsasn == "PNS") {
          if ($this->mcuti->getjmldetailpengantar($idpengantar, 'CUTI LAINNYA') == 0) {
            echo "<form method='POST' action='../cuti/hapus_pengantar'>";          
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='no_pengantar' id='no_pengantar' value='$nopengantar'>";
            ?>
            <p align="right">
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus Pengantar
            </button>
            </p>
            </form>
          <?php
          } else if ($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'CETAK') {
            echo "<form method='POST' action='../cuti/kirim_kebkppd'>";          
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
            echo "<input type='hidden' name='fid_unit_kerja' id='fid_unit_kerja' value='$v[fid_unit_kerja]'>";
            ?>
            <p align="right">
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Kirim Pengantar
            </button>
            </p>
            </form>
          <?php
          }
	} else if ($get_jnsasn == "PPPK") {
	  if ($this->mcuti->getjmldetailpengantar_pppk($idpengantar, 'CUTI LAINNYA') == 0) {
            echo "<form method='POST' action='../cuti/hapus_pengantar'>";
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='no_pengantar' id='no_pengantar' value='$nopengantar'>";
            ?>
            <p align="right">
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus Pengantar
            </button>
            </p>
            </form>
          <?php
          } else if ($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'CETAK') {
            echo "<form method='POST' action='../cuti/kirim_kebkppd'>";
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
            echo "<input type='hidden' name='fid_unit_kerja' id='fid_unit_kerja' value='$v[fid_unit_kerja]'>";
            ?>
            <p align="right">
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Kirim Pengantar
            </button>
            </p>
            </form>
          <?php
          }

	}
          ?>            
</div>
</div>
</center>
