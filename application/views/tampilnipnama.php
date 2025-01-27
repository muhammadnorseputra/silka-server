<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 80%">
  <div class="panel-body">
  
  <form method="POST" action="../pegawai/carinipnama">
  <p align="right">
  <button type="submit" class="btn btn-primary btn-sm">
  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
  </button>
  </p>
  </form>
  <?php
  if ($jmldata==0) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<b>Data tidak ditemukan atau berada diluar kewenangan anda</b>';
    echo '</div>';
  } else { // jika data ditemukan
    echo '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<b>Ditemukan '.$jmldata.' Data</b><br />';
    echo '</div>';
  ?>
    <table class="table table-condensed">
      <tr class='info'>
        <td align='center'><b>#</b></td>
        <td align='center'><b>NIP</b></td>
        <td align='center' colspan='2'><b>Nama</b></td>
        <td align='center'><b>Golongan Ruang</b></td>
        <td align='center'><b>Unker/Jabatan</b></td>
        <td align='center' colspan='3'><b>Aksi</b></td>
      </tr>
      <?php
        $no = 1;
        foreach($pegtnp as $v):
      ?>
      <tr>
        <td width='10' align='center'><?php echo $no; ?></td>
        <td width='150'><?php echo $v['nip']; ?></td>
        <td><?php
		echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); 
		echo "<br/><small><span class='text-muted' style='color: white';>".$v['pns_id']."</span></small>";
	    ?>
	</td>
        <td align='center'>         
          <?php
            $lokasifile = './photo/';
                  $filename = "$v[nip].jpg";

                  if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$v[nip].jpg";
                  } else {
                    $photo = "../photo/nophoto.jpg";
                    //echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'>";
                    //echo "<img src='../photo/nophoto.jpg' width='60' height='80' alt='no image'";
                  }
          ?>
            <img src='<?php echo $photo; ?>' width='60' height='80' alt='<?php echo $v['nip']; ?>.jpg'>          
        </td>
        <td width='140' align='center'>
          <?php echo $v['nama_golru'];?>
          <br />
          <?php echo 'TMT : ',tgl_indo($v['tmt_golru_skr']); ?>
        </td>
	<?php	
	  if (!$v['fid_peta_jabatan']) { 
	?>
        <td><?php echo $v['nama_unit_kerja']; ?><br/><br/>
        <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }

          echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab); 
	  $ideselon = $this->mpegawai->getfideselon($v['nip']);
          $namaeselon = $this->mpegawai->getnamaeselon($ideselon);

          $jnsjab = $this->mkinerja->get_jnsjab($v['nip']);
          if ($jnsjab == "STRUKTURAL") {            
            if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
              $id_jabstruk = $this->mkinerja->getfidjabstruk($v['nip']);
              $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
	
	      $cekkaskpd = $this->mkinerja->cek_kaskpd_eselon4($id_jabstruk);
              $ceksubkeukec = $this->mkinerja->ceksubkeukec_adabendahara($id_jabstruk);
              // cek apakah kasubbag perencanaan dan keuangan pada kecamatan, dan ada jfu bendaharanya
              if ($ceksubkeukec == true) {
                $kelasjabatan = 9;
              } else if ($cekkaskpd == true) {
                $kelasjabatan = 9;
              } else if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
                $kelasjabatan = 8;    
              } else {
                $kelasjabatan = 9;
              }

            } else {
              $kelasjabatan = $this->mkinerja->get_kelasjabstruk($v['nip']);
            }            
            $hargajabatan = $this->mkinerja->get_hargajabstruk($v['nip']);
            //$kelasjabatan = $this->mkinerja->get_kelasjabstruk($v['nip']);
          } else if ($jnsjab == "FUNGSIONAL UMUM") {
            $kelasjabatan = $this->mkinerja->get_kelasjabfu($v['nip']);
            $hargajabatan = $this->mkinerja->get_hargajabfu($v['nip']);
            //$kelasjabatan = "-";
            //$hargajabatan = "-";
          } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
            $kelasjabatan = $this->mkinerja->get_kelasjabft($v['nip']);
            $hargajabatan = $this->mkinerja->get_hargajabft($v['nip']);
            //$kelasjabatan = "-";
            //$hargajabatan = "-";
          }

          //echo "<br/><code>Kelas Jabatan : ".$kelasjabatan."</code>";

	} else {
	  echo "<td>";
                $detail_pejab = $this->mpetajab->detailKomponenJabatan($v['fid_peta_jabatan'])->result_array();
                foreach($detail_pejab as $dp) {
                        $nmunker_pj = $this->munker->getnamaunker($dp['fid_unit_kerja']);
                        $nmjab_pj = $this->mpetajab->get_namajab($dp['id']);
                        $jnsjab_pj = $this->mpetajab->get_namajnsjab($dp['fid_jnsjab']);
                        $unor = $this->mpetajab->get_namaunor($dp['fid_atasan']);
                        echo "<small>".$nmunker_pj;
                        echo "<br/>-".$unor;
			echo "</small>";
                        echo "<br/><span class='label label-info'>".$jnsjab_pj."</span><br/>".$nmjab_pj;
                        echo " <span class='text text-info'>(Kelas : ".$dp['kelas'].")</span>";
                }
	  echo "</td>";	

	}// End if peta jabatan
  
	
	  /*
	  if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
            $id_jabstruk = $this->mkinerja->getfidjabstruk($v['nip']);
            $datajf= $this->mkinerja->getdatajfubawahan($id_jabstruk)->result_array();
            echo "<br/><small  class='text-danger'>";
            foreach ($datajf as $jf) {
              $namajf = $this->mpegawai->getnama($jf['nip']);
	      if ($jf['fid_jnsjab'] == '2') {
                $jabjf = $this->mpegawai->namajab('2',$jf['fid_jabfu']);
              } else if ($jf['fid_jnsjab'] == '3') {
                $jabjf = $this->mpegawai->namajab('3',$jf['fid_jabft']);
              }
              $idtingpenjf = $this->mkinerja->getidtingpenterakhir($jf['nip']);
              $tingpenjf = $this->mpegawai->gettingpen($idtingpenjf); 
              echo "+ ";
              echo $jabjf." - ".$namajf." [".$tingpenjf."]";
              echo "<br/>";
            }
            echo "</small>";
          }
	  */

        ?>
        </td>
	<?php
	if ($this->session->userdata('level') == "ADMIN") {
	?>
        <td align='center'>
          <?php
          echo "<form method='POST' action='../pegawai/rwykgb'>";          
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-xs ">
          <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span><br/>Rwy KGB
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
	<?php
	}
	?>	
        </td>
	<!--
	 <td align='center' width='30'>
          <?php
          echo "<form method='POST' action='../pip/tampilhasilukur' target='_blank'>";
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-success btn-xs">
          <span class="fa fa-trophy" aria-hidden="true"></span><br/>IP ASN 2021
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
	--> 
	<td align='center' width='30'>
          <?php
          echo "<form method='POST' action='../pegawai/detail'>";
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-info btn-xs">
          <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span><br/>Detail
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
  <?php
  // tutup else if jika data ditemukan
  }
  ?>
</div>
</div>
</div>
</center>
