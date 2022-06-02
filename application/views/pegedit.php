<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.tanggal').datepicker({
      format: "dd-mm-yyyy",
      todayHighlight: true,
      clearBtn: true,
      autoclose:true
    });
  });

  
  function showKecamatan(idkel) {
  $.ajax({
    type: "POST",
    url: "<?php echo site_url('pegawai/showkecamatan'); ?>",
    data: "idkel="+idkel,
    success: function(data) {
      $("#tampilkecamatan").html(data);
    },
    error:function (XMLHttpRequest) {
      alert(XMLHttpRequest.responseText);
    }
    })
  };

  function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
      {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
      }
    if (window.ActiveXObject)
      {
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }  
  
</script>
<center>
  <div class="panel panel-default" style="width: 80%;">
    <div class="panel-body">    
      <?php
          foreach($peg as $v):
      ?>
      <table class='table table-condensed'>
        <tr>         
          <td align='right' width='50'>
          <?php
          echo "<form method='POST' action='../pegawai/detail'>";          
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-danger btn-sm">
          <span class="glyphicon glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
          <?php
            echo "</form>";
          ?>
          </td>  
        </tr>
      </table>    
      <form method='POST' action='../pegawai/editpeg_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
      <div class="panel panel-info">        
        <div class='panel-heading' align='left'>
        <b>
        <?php
        echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']);
        ?>
        <?php echo "::: ".$v['nip']; ?></b>
        </div>

        <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }
        ?>
        
        <table class="table table-bordered">
            <tr>
              <td align='right' width='160'><b>Nama Lengkap</b></td>
              <td colspan='3'><?php echo $v['nama']; ?></td>
              <td align='center' rowspan='13' width='250'>
              <div class="well well-sm" >
                <img src='../photo/<?php echo $v['nip']; ?>.jpg' width='120' height='160' alt='<?php echo $v['nip']; ?>.jpg'>
                <h5><span class="label label-default">MK dari CPNS : <?php echo hitungmkcpns($v['nip']); ?></span></h5>
                <h5><span class="label label-primary">MK dari PNS : <?php echo hitungmkpns($v['nip']); ?></span></h5>
                <h5><span class="label label-success">MK Golru terakhir : <?php echo hitungmkgolru($v['nip']); ?></span></h5>
                <h5><span class="label label-info">MK Jabatan terakhir : <?php echo hitungmkjab($v['nip']); ?></span></h5>
                <h4><span class="label label-warning">
                TMT BUP : <?php echo $this->mpegawai->gettmtbup($idjab, $v['tgl_lahir'], $v['fid_jnsjab']);?></span></h4>
                <h4><span class="label label-danger">Usia : <?php echo hitungusia($v['nip']); ?></span></h4>

                <!--  
                <ul class="list-group">
                  <li class="list-group-item list-group-item-info">MK dari CPNS : 10 Tahun 6 Bulan</li>
                  <li class="list-group-item list-group-item-warning">Cras sit amet nibh libero</li>
                  <li class="list-group-item list-group-item-success">Dapibus ac facilisis in</li>
                  <li class="list-group-item list-group-item-info">Cras sit amet nibh libero</li>
                  <li class="list-group-item list-group-item-warning">Porta ac consectetur ac</li>
                  <li class="list-group-item list-group-item-danger">Usia : 36 Tahun 7 Bulan</li>
                </ul>
                -->
              </div>
              </td>
            </tr>
            <tr>
              <td align='right'><b>Gelar Depan</b></td>
              <td><?php echo $v['gelar_depan']; ?></td>
              <td align='right' width='120'><b>Gelar Belakang</b></td>
              <td><?php echo $v['gelar_belakang']; ?></td>
            </tr>
            <tr>
              <td align='right'><b>Tempat/Tanggal Lahir</b></td>
              <td colspan='3'><?php echo $v['tmp_lahir'],' / ',tgl_indo($v['tgl_lahir']); ?></td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>Alamat</b></td>
              <td colspan='3' bgcolor='#D9EDF7'>
              <input type="text" name="alamat" size='100' maxlength='200' value="<?php echo $v['alamat']; ?>" />
              <select name="idkel" id="idkel" onChange="showKecamatan(this.value)" required />
                <?php
                foreach($keldes as $kel)
                {
                  if ($v['fid_alamat_kelurahan']==$kel['id_kelurahan']) {
                    echo "<option value='".$kel['id_kelurahan']."' selected>".$kel['nama_kelurahan']."</option>";
                  } else {
                    echo "<option value='".$kel['id_kelurahan']."'>".$kel['nama_kelurahan']."</option>";
                  }

                }
                ?>
              </select>
              <div id='tampilkecamatan'></div><br />
	      <b>No. Telepon : </b><input type="text" name="telepon" size="30" maxlength="50" value="<?php echo $v['telepon']; ?>" />	
              <?php              
              //echo $v['alamat'],' ',$this->mpegawai->getkelurahan($v['fid_alamat_kelurahan']),' TELP. ', $v['telepon']
              ?>                
              </td>
            </tr>
            <tr>
              <td align='right'><b>Jenis Kelamin</b></td><td><?php echo $this->mpegawai->getjnskel($v['nip']); ?></td>              
              <td align='right'><b>Agama</b></td>
              <td><?php echo $this->mpegawai->getagama($v['fid_agama']); ?></td>
            </tr>
            <tr>
              <td align='right'><b>Pendidikan</b></td>
              <td colspan='3'><?php echo $this->mpegawai->getpendidikan($v['nip']); ?></td>
            </tr>            
            <tr>
              <td align='right'><b>Status Kepegawaian</b></td>
              
              <?php if($this->session->userdata('level') == 'ADMIN'){ ?>
              <td>
              	<select name="status_pegawai">
              		<?php 
              		 	$idstspeg = $this->mpegawai->getstatpegid($v['nip'])->id_status_pegawai;
              			foreach($this->mpegawai->getrefstatpeg() as $sp):
              				if($idstspeg == $sp->id_status_pegawai) {
              					echo '<option value="'. $sp->id_status_pegawai .'" selected>'. $sp->nama_status_pegawai .'</option>';
              				} else {
              					echo '<option value="'. $sp->id_status_pegawai .'">'. $sp->nama_status_pegawai .'</option>';
              				}
              			endforeach;
              		?>
              	</select>
              	</td>
              	<?php } else { ?>
              	<td><?php echo $this->mpegawai->getstatpeg($v['nip']); ?></td>
              	<?php } ?>
              
              <td align='right'><b>Status Kawin</b></td>
              <td>
              	<?php 
              		$id_status = $v['fid_status_kawin'];
              	?>
              	
              	<select name="status_kawin">
              		<option value="0501" <?= $id_status === '0501' ? "selected" : "" ?>>BELUM KAWIN</option>
              		<option value="0502" <?= $id_status === '0502' ? "selected" : "" ?>>KAWIN</option>
              		<option value="0503" <?= $id_status === '0503' ? "selected" : "" ?>>JANDA/DUDA</option>
              		<option value="0504" <?= $id_status === '0504' ? "selected" : "" ?>>CERAI</option>
              	</select>
              </td>
            </tr>
            <tr>
              <td align='left' bgcolor='#D9EDF7'><b>No. Karpeg</b></td>
              <td  bgcolor='#D9EDF7'>
              <input type="text" name="nokarpeg" size='10' maxlength='30' value="<?php echo $this->mpegawai->getnokarpeg($v['nip']); ?>" />              
              </td>
              
              <?php if($this->session->userdata('level') == 'ADMIN'){ ?>
              <td align='right' bgcolor='pink'><b>TPP</b></td>
              <td  bgcolor='pink'>
              	<select name="tpp">
              		<?php
              			if($v['tpp'] == 'YA') {
              		?>
              		<option value="YA" selected>Ya</option>
              		<option value="TIDAK">Tidak Berhak</option>
              		<?php } else { ?>
              		<option value="YA">Ya</option>
              		<option value="TIDAK" selected>Tidak Berhak</option>
              		<?php } ?>
              	</select>            
              </td>
              <?php } else { ?>
              <td align='right' bgcolor='#D9EDF7'><b>TPP</b></td>
              <td   bgcolor='#D9EDF7'><?php echo $this->mpegawai->cekstatusttp($v['nip']); ?></td>
              <?php } ?>
              
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>No. Taspen</b></td>
              <td bgcolor='#D9EDF7'>
              <input type="text" name="notaspen" size='20' maxlength='30' value="<?php echo $v['no_taspen']; ?>" />
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>No. Askes</b></td>
              <td bgcolor='#D9EDF7'>
              <input type="text" name="noaskes" size='20' maxlength='30' value="<?php echo $v['no_askes']; ?>" />
              </td>
            </tr>
            <tr>
              <td align='right' bgcolor='#D9EDF7'><b>No. KTP</b></td>
              <td bgcolor='#D9EDF7'>
              <input type="text" name="noktp" size='20' maxlength='30' value="<?php echo $v['no_ktp']; ?>" />              
              </td>
              <td align='right' bgcolor='#D9EDF7'><b>No. NPWP</b></td>
              <td bgcolor='#D9EDF7'>
              <input type="text" name="nonpwp" size='20' maxlength='30' value="<?php echo $v['no_npwp']; ?>" />              
              </td>
            </tr>
            <tr>              
              <td align='right'><b>Pangkat</b></td>
              <td><?php echo $this->mpegawai->getnamapangkat($v['fid_golru_skr']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_skr']).')'; ?>
              --- TMT : <?php echo tgl_indo($v['tmt_golru_skr']); ?></td>
            </tr>
            <tr>
              <td align='right'><b>Unit Kerja</b></td>
              <td colspan='3'><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
            </tr>
            <tr>
              <td align='right'><b>Jabatan</b></td>              
	      <td colspan='3'>
              <?php
                $namajab = $this->mpegawai->namajab($v['fid_jnsjab'],$idjab);                
                $keltugas = $this->mpegawai->getkeltugas_jft($idjab);
                echo $namajab; ?><br />
              TMT : <?php echo tgl_indo($v['tmt_jabatan']); ?></td>
            </tr>
	    <tr>
	      <td align='right'><b>Atasan Langsung</b></td>              
              <td colspan='3'>  
                <?php
                
		$jnsjab = $this->mkinerja->get_jnsjab($v['nip']);
                echo "<input type='hidden' id='idjab' name='idjab' value='$idjab' />";  
                if (($jnsjab == "FUNGSIONAL UMUM") OR (($jnsjab == "FUNGSIONAL TERTENTU") AND ($keltugas != 'PENDIDIKAN'))) {
                  $idjabkepalaskpd = $this->mpegawai->getkepalaskpd_idjab($v['fid_unit_kerja']);
		  if ($idjabkepalaskpd != NULL) {
		  	$namajabkepalaskpd = $this->mpegawai->namajab('1',$idjabkepalaskpd);
                  	$nipkepalaskpd = $this->mpegawai->getnipatasan_jabstruk($idjabkepalaskpd);
                  	$namakepalaskpd = $this->mpegawai->getnama($nipkepalaskpd);
		  }
                  $eselon4nya = $this->mpegawai->getsemuaeselon4($v['fid_unit_kerja'])->result_array();
                  echo "<small><select name='idjabatasan' id='idjabatasan' >";
                  if ($v['fid_jabstrukatasan'] == '') {
                    echo "<option value=''>-- Pilih Atasan Langsung --</option>";
                    //echo "<option value='$idjabkepalaskpd'>".$namakepalaskpd." -- KEPALA UNIT KERJA</option>";
                  }
                  
                  if ($v['fid_jabstrukatasan']==$idjabkepalaskpd) {
                    echo "<option value='$idjabkepalaskpd' selected>".$namakepalaskpd." -- ".$namajabkepalaskpd."</option>";
                  } else {
                    echo "<option value='$idjabkepalaskpd'>".$namakepalaskpd." -- ".$namajabkepalaskpd."</option>";  
                  }
                  
                  foreach($eselon4nya as $data)
                  {
                    $nippejabat = $this->mpegawai->getnipatasan_jabstruk($data['id_jabatan']);
                    $namapejabat = $this->mpegawai->getnama($nippejabat);
                    if ($v['fid_jabstrukatasan']==$data['id_jabatan']) {
                      echo "<option value='".$data['id_jabatan']."' selected>".$data['nama_jabatan']."</option>";
                    } 
                    else {
                      echo "<option value='".$data['id_jabatan']."'>".$data['nama_jabatan']."</option>";
                    }

                  }
                }
		
                ?>
                </select></small>
              </td>
            </tr>
        </table>
      <?php
        endforeach;
      ?>      
      </div> <!--panel panel-info-->
      <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
      </p>
    </div> <!--panel-body-->
  </div> <!--panel panel-default-->
</center>
