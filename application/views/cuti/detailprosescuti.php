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
      <td align='right' width='50'>
        <form method="POST" action="../cuti/tampilproses">
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
  <b>qPengantar Nomor : <?php echo $nopengantar; ?></b><br />
  <?php echo $this->mcuti->getunker_pengantar($idpengantar); ?>
  <?php echo "<br/>Jenis ASN : ".$ket_jnsasn; ?>
  <?php echo " | Jumlah Data : ", $jmldata, " Usul"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:300px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='<?php echo $cljns;?>'>
        <td align='center' width='10'><b>No</b></td>
        <td align='center' width='250'><b>NIP | Nama</b></td>
        <td align='center' width='500'><b>Jabatan</b></td>
        <td align='center' width='120'><b>Jenis Cuti</b></td>
        <td align='center' width='150'><b>Lama</b></td>
        <td align='center'><b>Entry Usul | User Usul</b><br/><b><u>Kirim Usul</u></b></td>
        <td align='center' width='120' colspan='2'><b>Status</b></td>
        <td align='center' width='50'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($cuti as $v):          
      ?>

      <?php 
	$get_jnsasn = $this->mcuti->get_jnsasn($v['id_pengantar']);
        if ($get_jnsasn == "PNS") {
	  $ni = $v['nip'];
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }
	} else if ($get_jnsasn == "PPPK") {
          $ni = $v['nipppk'];
	}
      ?>

      <tr>
        <td align='center'><?php echo $no; ?></td>
	<?php
	if ($get_jnsasn == "PNS") {
		echo "<td>".$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang'])."</td>";
		echo "<td>".$this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja']."</td>";
	} else if ($get_jnsasn == "PPPK") {
		echo "<td>".$v['nipppk'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk'])."</td>";
		echo "<td>".$this->mpegawai->namajab(3,$v['fid_jabft']), '<br />', $v['nama_unit_kerja']."</td>";
	}
	?>
        
        <td align='center'><?php echo $v['nama_jenis_cuti'], '<br />Tahun ',$v['thn_cuti']; ?></td>

	<td align='center'>
        <?php
	
        if (($get_jnsasn == "PNS") AND ($v['tambah_hari_tunda'] != 0)) {
          $jmltotal = $v['jml'] + $v['tambah_hari_tunda'];
          echo $jmltotal." (".$v['jml']." + ".$v['tambah_hari_tunda']." Cuti Tunda)";
        } else {
          $jmltotal = $v['jml'];
          echo $jmltotal.' '.$v['satuan_jml'];
        }
        ?>
        <?php echo '<br />',tgl_indo($v['tgl_mulai']),'<br />s/d ',tgl_indo($v['tgl_selesai']); ?></td>

        <td align='center'><?php echo $v['tgl_usul'].'<br/>'.$this->mlogin->getnamauser($v['user_usul']); ?><br/><u><?php echo $v['tgl_kirim_usul']; ?></u></td>

        <td align='center'>
        <?php
        $status = $this->mcuti->getstatuscuti($v['fid_status']);
        if ($status == 'INBOXBKPPD') {          
          echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
        } else if ($status == 'BTL') {
          echo "<h5><span class='label label-warning'>B T L</span></h5>";
        } else if ($status == 'TMS') {
          echo "<h5><span class='label label-danger'>T M S</span></h5>";
        } else if ($status == 'SETUJU') {
          echo "<h5><span class='label label-success'>SETUJU</span></h5>";
        } else if ($status == 'CETAKSK') {
          echo "<h5><span class='label label-default'>CETAK SK</span></h5>";
        } else if ($status == 'SELESAI') {
          echo "<h5><span class='label label-default'>SELESAI</span></h5>";
        }
        ?>          
        </td>
	<td>
          <?php
            if (($status == 'SETUJU') OR ($status == 'CETAKSK')) {
              ?>
              <img style="width: 50px;" src="<?php echo base_url().'assets/qrcodecuti/'.$v['qrcode'] .'.png';?>">
              <?php
            }
          ?>
        </td>

        <td align='center'>
          <?php
          if ($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXBKPPD') {
            echo "<form method='POST' action='../cuti/prosesusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$ni'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-info btn-xs'>";
            echo "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span><br />Proses";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<form method='POST' action='../cuti/prosesusul'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$ni'>";
            echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
            echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
            echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
            echo "<button type='submit' class='btn btn-default btn-xs'>";
            echo "<span class='glyphicon glyphicon-list' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
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
      <!--
            <form method='POST' action='../cuti/hapus_pengantar'>
            <input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>
            <input type='hidden' name='no_pengantar' id='no_pengantar' value='$nopengantar'>
            <button type="submit" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Turun Status
            </button>
            </form>
      -->
        <?php
          if ($this->mcuti->getstatuspengantar_byidpengantar($idpengantar) == 'BKPPD') {
	    if ($get_jnsasn == "PNS") {
		$cekstatus = $this->mcuti->cek_selainsetujubtltms($idpengantar);
	    } else if ($get_jnsasn == "PPPK") {
		$cekstatus = $this->mcuti->cek_selainsetujubtltms_pppk($idpengantar);
	    }
	
	    if ($cekstatus == TRUE) {
            //if ($this->mcuti->cek_selainsetujubtltms($idpengantar) == TRUE) {
              echo "<form method='POST' action='../cuti/selesaikancuti_aksi'>";          
              echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
              echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
              ?>
              <p align="right">
              <button type="submit" class="btn btn-success btn-sm">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Selesaikan
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
