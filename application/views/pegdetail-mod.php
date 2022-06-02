<center>
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
  <div class="panel panel-default" style="width: 90%;">
    <div class="panel-body">    
      <?php
          foreach($peg as $v):
      ?>
      <table class='table table-condensed'>
        <tr>
	  <?php
          if ($this->session->userdata('edit_profil_priv') == "Y") {
          ?>
          <td align='right'>
            <form method="POST" action="../takah/rwytakah">
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                <button type="submit" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Dokumen Elektronik
                </button>
            </form>
          </td>
          <?php
          }

          //cek priviledge session user -- cetak_profil_priv
          if ($this->session->userdata('cetak_profil_priv') == "Y") { 
          ?>
          <td align='right' width='50'>
            <form method="POST" action="../pegawai/cetakdtlpeg" target='_blank'>
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Profil
                </button>
            </form>
          </td>
          <?php
          } //cek priviledge session user -- edit_profil_priv
          if ($this->session->userdata('edit_profil_priv') == "Y") { 
          ?>
          <td align='right' width='50'>
            <form method="POST" action="../pegawai/editpeg">
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                <button type="submit" class="btn btn-warning btn-sm">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update
                </button>
            </form>
          </td>
          <?php
          }
          ?>
          <td align='right' width='50'>
            <form method="POST" action="../home">
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            </form>
          </td>
        </tr>
      </table> 
      <?php
      // tulis panel
      echo $this->mpegawai->getpanelcolor($v['nip']);
      ?>	   
      <!-- <div class="panel panel-info"> -->
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
        
        <table class="table table-bordered table-condensed">
            <tr>
              <td align='right' width='160'><b>Nama Lengkap</b></td>
              <td colspan='3'><?php echo $v['nama']; ?></td>
              <td align='center' rowspan='13' width='250'>
                <?php
                  $lokasifile = './photo/';
                  $filename = "$v[nip].jpg";
			           
                  // loginFtp();
		  //$photo = "ftp://192.168.1.4/photo/$v[nip].JPG";

                  /* UJI COBA FTP
                  $this->load->library('ftp');
            		  $config['hostname'] = '192.168.1.4';
                  $config['username'] = 'silka_ftp';
                  $config['password'] = 'FtpSanggam';
                  $config['debug'] = TRUE;

                  $this->ftp->connect($config);
                  $list = $this->ftp->list_files('/pub/');

                  //print_r($list); 
            		  
                  //echo "<img src='$list[0]' >";
            		  $this->ftp->close();
                  */

                  if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$v[nip].jpg";
			               //$photo = "ftp://192.168.1.4/photo/$v[nip].jpg";
                  } else {
                    $photo = "../photo/nophoto.jpg";
                    //echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'>";
                    //echo "<img src='../photo/nophoto.jpg' width='60' height='80' alt='no image'";
                  }
                ?>
              <div class="well well-sm" >
                <img src='<?php echo $photo; ?>' width='120' height='160' alt='<?php echo $v['nip']; ?>.jpg' class="img-thumbnail">
                <h5><span class="label label-default">MK dari CPNS : <?php echo hitungmkcpns($v['nip']); ?></span></h5>
                <h5><span class="label label-primary">MK dari PNS : <?php echo hitungmkpns($v['nip']); ?></span></h5>
                <h5><span class="label label-success">MK Golru terakhir : <?php echo hitungmkgolru($v['nip']); ?></span></h5>
                <h5><span class="label label-info">MK Jabatan terakhir : <?php echo hitungmkjab($v['nip']); ?></span></h5>
                <h4><span class="label label-warning">
                TMT BUP : <?php echo $this->mpegawai->gettmtbup($idjab, $v['tgl_lahir'], $v['fid_jnsjab']);?></span></h4>
                <h4><span class="label label-danger">Usia : <?php echo hitungusia($v['nip']); ?></span></h4>

		<!-- API ke EKinerja -->                
                <?php                
                //$nipe = $v['nip'];
		$nipe = encrypt($v['nip']); // enkripsi nip (function pada helper pegawai)                
                $thn = date('Y');
                $bln = date('m')-1; // Tentukan bulan yang akan diambil data SKP nya
                $url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_bulan?n='.$nipe.'&t='.$thn.'&b='.$bln;
                $konten = file_get_contents($url);
                $api = json_decode($konten);
                
                if ($api != "") {
                  $nilaiskp = $api->hasil[0]->nilai_skp; // hasil adalah array response dari api pada server sebelah
                  //echo "<h5><span class='label label-default'>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : ".number_format($nilaiskp,2)."</span></h5>";
                  echo "<h5><b>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : ".number_format($nilaiskp,2)."</b></h5>";
		} else {
                   //echo "<h4><span class='label label-default'>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : -</span></h4>";
                   echo "<h5><b>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : -</b></h5>";
		}
                ?> 
                <!-- End API Kinerja -->     

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
              <td align='right'><b>Alamat</b></td>
              <td colspan='3'>
		<?php
		if ($this->session->userdata('level') != "TAMU") {
			echo $v['alamat'],' ',$this->mpegawai->getkelurahan($v['fid_alamat_kelurahan']),' TELP. ', $v['telepon'];
		} else {			
			echo $v['alamat'],' ',$this->mpegawai->getkelurahan($v['fid_alamat_kelurahan']);
		}
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
              <td><?php echo $this->mpegawai->getstatpeg($v['nip']); ?></td>
              <td align='right'><b>Status Kawin</b></td>
              <td><?php echo $this->mpegawai->getstatkawin($v['fid_status_kawin']); ?></td>
            </tr>
            <tr>
              <td align='right'><b>No. Karpeg</b></td>
              <td><?php echo $this->mpegawai->getnokarpeg($v['nip']); ?></td>
              <?php
                //$jnskel = $this->mpegawai->getjnskel($v['nip']);
                //if ($jnskel == 'LAKI-LAKI') {
                //  echo '<td align=right><b>No. Karis</b></td>';
                //} else if ($jnskel == 'PEREMPUAN') {
                //  echo '<td align=right><b>No. Karsu</b></td>';
                //}
              ?>              
            </tr>
            <tr>
              <td align='right'><b>No. Taspen</b></td>
              <td><?php echo $v['no_taspen']; ?></td>
              <td align='right'><b>No. Askes</b></td>
              <td><?php echo $v['no_askes']; ?></td>
            </tr>
            <tr>
              <td align='right'><b>No. KTP</b></td>
              <td><?php echo $v['no_ktp']; ?></td>
              <td align='right'><b>No. NPWP</b></td>
              <td><?php echo $v['no_npwp']; ?></td>
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
              <td colspan='3'><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab); ?><br />
              TMT : <?php echo tgl_indo($v['tmt_jabatan']); ?></td>
            </tr>
        </table>
      <?php
        endforeach;
      ?>      

      <script type='text/javascript'>
        function rwycp(nip)
        {
            document.location = "../pegawai/rwycp?nip="+nip;
        }

        function rwycp1()
        {
            document.location = "../pegawai/rwycp";
        }
      </script>
     	
      </div>
		
	<?php 
		$color_btn = $this->mpegawai->getbuttoncolor($v['nip']);
		// untuk navigasi data riwayat khusus untuk user terdaftar
		if ($this->session->userdata('level') != "TAMU"):
	?>
	<div class="btn-toolbar" role="toolbar" aria-label="btn-riwayat">
	  <div id="ajax-xhr-links" data-href="../pegawai/rwycp"   class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat" ><span class="glyphicon glyphicon-road" aria-hidden="true"></span>&nbspCPNS PNS</button></div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwydik"  class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>&nbspDiklat</button></div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwyjab"  class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-sort" aria-hidden="true"></span>&nbspJabatan</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwykp"   class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbspPangkat</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwypdk"  class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-education" aria-hidden="true"></span>&nbspPendidikan</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwykel"  class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbspKeluarga</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwyph"   class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-queen" aria-hidden="true"></span>&nbspPenghargaan</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwyskp"  class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-grain" aria-hidden="true"></span>&nbspSKP</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwykgb"  class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-plane" aria-hidden="true"></span>&nbspKGB</div>
	  <div id="ajax-xhr-links" data-href="../pegawai/rwycuti" class="btn-group <?= $color_btn ?>" role="group" aria-label="btn-riwayat"><span class="glyphicon glyphicon-plane" aria-hidden="true"></span>&nbspCuti</div>
		
		<!-- Menu Dropdown-->
		<div class="btn-group dropup">
		<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Fitur Lainnya</button>
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span class="caret"></span>
		    <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <ul class="dropdown-menu">
		    <!-- Dropdown menu links here -->
		    <li data-href="../pegawai/carinipnama"><a href="#">Halo Silka</a></li>
		  </ul>
		</div>

	</div>
	<?php endif; ?>
    </div>
  </div>
</center>

<script type="text/javascript">
	$(document).ready(function(){
		$(".btn-toolbar #ajax-xhr-links").on("click", function(e){
			e.preventDefault();
			let _href = $(this).attr('data-href');
			let _nip  = $("[name='nip']").val();
			$.post(_href, {nip: _nip}, function(result) {
				window.history.pushState({nip: _nip}, '', _href);
				$("body").empty().html(result);
			});
		});
	});
	
</script>
