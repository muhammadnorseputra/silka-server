<script type="text/javascript">

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

  function showUpdateJabPeta(str1, str2)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilupdatejabpeta";
    url=url+"?idjnsjab="+str2;
    url=url+"&idunker="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataJabPeta;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataJabPeta(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampiljabpeta").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljabpeta").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  function showUpdateJabPeta1(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilupdatejabpeta1";
    url=url+"?idjab="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataJabPeta1;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataJabPeta1(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampiljabpeta1").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljabpeta1").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

</script>

<center>
<?php
  $intbkn_session = $this->session->userdata('intbkn_priv');

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
  <div class="panel panel-default" style="width: 80%;">
    <div class="panel-body">    
      <?php
          foreach($peg as $v):
      ?>
      <table class='table table-condensed'>
        <tr>
	  <?php
            if (($this->session->userdata('level') == "PNS") OR ($this->session->userdata('edit_profil_priv') == "Y")) {
            //if ($this->session->userdata('level') == "ADMIN") {
            ?>
	  <td align='left'>
                <?php
                //if ($this->session->userdata('level') == "ADMIN") {
                ?>
                <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal" data-target="#rwyvaksin">
		<span class="fa fa-ambulance" aria-hidden="true"></span> Riwayat Vaksinasi Covid</button>
                <?php
                //}
                ?>
          </td>	 
 
          <td align='left'>
		<?php
		if ($intbkn_session == "YA") {
		?>
		<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#compare"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Komparasi Data BKN</button>
          	<?php 
		} 
		?>
	  </td>
	  <td align='right' width='50'>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#personal">
                <b><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> INFO PERSONAL</b><sup class="text-danger">Baru</sup>
                </button>
          </td>
          <?php
            }
          ?>

	  <!-- <td align='right' width='50'>
            <?php
             if (($this->session->userdata('level') == "PNS") OR ($this->session->userdata('edit_profil_priv') == "Y")) {
	     //if ($this->session->userdata('level') == "ADMIN") {
            ?>
           
		<form method="POST" action="../pip/tampilhasilukur">
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> INDEKS PROFESIONALITAS 2021
                </button>
            	</form>
	   
            <?php
            }
            ?>
          </td> -->
	  <?php
          if ($this->session->userdata('edit_profil_priv') == "Y") {
          ?>
          <td align='right' width='50'>
            <form method="POST" action="../takah/rwytakah">
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                <button type="submit" class="btn btn-sm">
                <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Dokumen Elektronik
                </button>
            </form>
          </td>
          <?php
          }

          //cek priviledge session user -- cetak_profil_priv
	  if ($this->session->userdata('nip') == "198104072009041002") {	  
          //if ($this->session->userdata('cetak_profil_priv') == "Y") { 
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
        
        <table class="table table-condensed">
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
	      //$this->output->set_header("content-type: image/jpeg");	  
              //echo '<img src="data:image/jpeg;base64,'.base64_encode($this->mpegawai->show_photo_pegawai($v['nip'])).'" width="120" height="160"  class="img-thumbnail"/>';
                ?>
              <div class="well well-sm" >
		<!--<img src='<?php echo $photo; ?>' width='120' height='160' alt='<?php echo $v['nip']; ?>.jpg' class="img-thumbnail">-->
                <?php
		$rwysetuju = $this->mpegawai->rwyupdate_setuju($v['nip']);
                if ($rwysetuju == 1) {
	    		echo '<img src="data:image/jpeg;base64,'.base64_encode($this->mpegawai->show_photo_pegawai($v['nip'])).'" width="120" height="160"  class="img-thumbnail"/>';
            	} else {
			echo "<img src='$photo' width='120' height='160' alt='' class='img-thumbnail'>";
		}
		?>
		
		<?php
                //  if ($this->session->userdata('level') == "ADMIN") {
                ?>
                <form method="POST" action="../pegawai/updatephoto">
                    <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                    <button type="submit" class="btn btn-danger btn-xs">
                    <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Ganti Photo
                    </button>
                </form>
                <?php
                //  }
                ?>

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
	//	$nipe = encrypt($v['nip']); // enkripsi nip (function pada helper pegawai)                
        //        $thn = date('Y');
        //        $bln = date('m')-1; // Tentukan bulan yang akan diambil data SKP nya
        //        $url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_bulan?n='.$nipe.'&t='.$thn.'&b='.$bln;
        //        $konten = file_get_contents($url);
        //        $api = json_decode($konten);
                
        //        if ($api != "") {
        //          $nilaiskp = $api->hasil[0]->nilai_skp; // hasil adalah array response dari api pada server sebelah
                  //echo "<h5><span class='label label-default'>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : ".number_format($nilaiskp,2)."</span></h5>";
        //          echo "<h5><b>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : ".number_format($nilaiskp,2)."</b></h5>";
	//	} else {
                   //echo "<h4><span class='label label-default'>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : -</span></h4>";
        //           echo "<h5><b>Kinerja Bulan ".bulan($bln)."<br/>(dari aplikasi e-Kinerja) : -</b></h5>";
	//	}
                ?> 
                <!-- End API Kinerja -->     
		
		<?php
                $thn = date("Y");
                $nilaiip = $this->mpip->getnilaiip($v['nip'], $thn); 
                $katip = $this->mpip->getkategoriip($nilaiip);
                ?>
                <h4><span class="label label-default">Indeks Profesionalitas <?php echo $thn." : ".$nilaiip; ?></span></h4>
                
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
              <td><?php echo $this->mpegawai->getstatpegid($v['nip'])->nama_status_pegawai; //$this->mpegawai->getstatpeg($v['nip']); ?></td>
              <td align='right'><b>Status Kawin</b></td>
              <td><?php echo $this->mpegawai->getstatkawin($v['fid_status_kawin']); ?></td>
            </tr>
            <tr>
              <td align='right'><b>No. Karpeg</b></td>
              <td><?php echo $this->mpegawai->getnokarpeg($v['nip']); ?></td>
              <?php
		//if ($this->session->userdata('level') == "ADMIN") { ?>
              		<td align=right><b>TPP</b></td>
              		<td>
			<?php 
				echo $this->mpegawai->cekstatusttp($v['nip']);
			?>
			</td>
              <?php
		//} 
 	      ?>
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
	      <td align='right'><b>Wajib LHKPN</b></td>
              <td><?php echo $v['wajib_lhkpn']; ?></td>	
            </tr>
            <tr>
              <td align='right'><b>Unit Kerja</b></td>
              <td colspan='3'><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
            </tr>
            <tr>
              <td align='right'><b>Jabatan</b></td>              
              <td colspan='3'>
              <?php
		//var_dump($v[fid_jabstrukatasan]);
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

                  //$kelasjabatan = $this->mkinerja->get_kelasjabstruk($v['nip']);
                  //$hargajabatan = $this->mkinerja->get_hargajabstruk($v['nip']);
		  $idjabinduk = $this->mpegawai->getatasan_jabstruk($idjab);
                  $jabinduk = $this->mpegawai->namajab('1', $idjabinduk);
                } else if ($jnsjab == "FUNGSIONAL UMUM") {
                  $kelasjabatan = $this->mkinerja->get_kelasjabfu($v['nip']);
                  //$hargajabatan = $this->mkinerja->get_hargajabfu($v['nip']);
		  if ($v['fid_jabstrukatasan'] != '') {
                    $jabinduk = $this->mpegawai->namajab('1', $v['fid_jabstrukatasan']);
		  } else {
                    $jabinduk = '-';
                  }
		} else if ($jnsjab == "FUNGSIONAL TERTENTU") {
                  $kelasjabatan = $this->mkinerja->get_kelasjabft($v['nip']);
                  if ($v['fid_jabstrukatasan'] != '') {
                    $jabinduk = $this->mpegawai->namajab('1', $v['fid_jabstrukatasan']);
                  } else {
                    $jabinduk = '-';
                  }
                }
                echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab);
		echo "<br/>".tgl_indo($v['tmt_jabatan']);
                //echo "<br/><small style='color:blue;'>ATASAN : ".$jabinduk."</small>";
                //echo "<br/><code>Kelas Jabatan : ".$kelasjabatan.", Harga Jabatan : ".$hargajabatan."</code>";
                //echo "<br/><code>Kelas Jabatan : ".$kelasjabatan."</code>";
                if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
                  $id_jabstruk = $this->mkinerja->getfidjabstruk($v['nip']);
                  $datajf= $this->mkinerja->getdatajfubawahan($id_jabstruk)->result_array();
                  echo "<br/><small class='text-danger'>";
                  foreach ($datajf as $jf) {
                    $namajf = $this->mpegawai->getnama($jf['nip']);
                    if ($jf['fid_jnsjab'] == '2') {
                	$jabjf = $this->mpegawai->namajab('2',$jf['fid_jabfu']);
                    } else if ($jf['fid_jnsjab'] == '3') {
               		 $jabjf = $this->mpegawai->namajab('3',$jf['fid_jabft']);
              	    }
                    $idtingpenjf = $this->mkinerja->getidtingpenterakhir($jf['nip']);
                    $tingpenjf = $this->mpegawai->gettingpen($idtingpenjf); 
                    //echo "+ ";
                    //echo $jabjf." - ".$namajf." [".$tingpenjf."]";
                    //echo "<br/>";
                  }
                  echo "</small>";
                }

		//echo " <code>Kelas Jabatan : ".$kelasjabatan."</code>";
		//echo "<br/><small style='color:blue;'>ATASAN : ".$jabinduk."</small>";
                //echo "<br/><code>Kelas Jabatan : ".$kelasjabatan.", Harga Jabatan : ".$hargajabatan."</code>";
	      ?>
	      </td>
            </tr>
	  <?php
	  //if ($this->session->userdata('level') == "ADMIN") {
	  ?>  
 	    <tr>
              <td align='right'><b>Peta Jabatan</b>
	      <?php
                if ($this->session->userdata('level') == "ADMIN") {
              ?>	
	      <button type="button" class="form-control btn btn-info btn-outline btn-sm" data-toggle="modal" data-target="#updatejab" >
                 <span class="fa fa-refresh" aria-hidden="true"></span> Mapping Peta Jabatan
                </button>	
	      <?php
                }
              ?>	
	      </td>
              <td colspan='3'>
		<?php
		$detail_pejab = $this->mpetajab->detailKomponenJabatan($v['fid_peta_jabatan'])->result_array();
		//var_dump($detail_pejab);
		if ($detail_pejab) {
		  foreach($detail_pejab as $dp) {
			$nmunker_pj = $this->munker->getnamaunker($dp['fid_unit_kerja']);
			$nmjab_pj = $this->mpetajab->get_namajab($dp['id']);
			$jnsjab_pj = $this->mpetajab->get_namajnsjab($dp['fid_jnsjab']);
			$unor = $this->mpetajab->get_namaunor($dp['fid_atasan']);
			//echo $nmunker_pj;
			//echo "<br/>".$unor;
			//echo "<br/><span class='label label-info'>".$jnsjab_pj."</span> ".$nmjab_pj;
			//echo " <span class='text text-info'>(Kelas : ".$dp['kelas'].")</span>";
		  }				

		  $namajab = $this->mpegawai->namajab($v['fid_jnsjab'],$idjab);
		  //if (($dp['fid_unit_kerja'] == $v['fid_unit_kerja']) AND ($dp['fid_jnsjab'] == $v['fid_jnsjab']) AND ($namajab == $nmjab_pj)) {
		  if (($dp['fid_unit_kerja'] == $v['fid_unit_kerja']) AND ($dp['fid_jnsjab'] == $v['fid_jnsjab'])) {
			echo $nmunker_pj;
                        echo "<br/>".$unor;
                        echo "<br/><span class='label label-info'>".$jnsjab_pj."</span> ".$nmjab_pj;
                        echo " <span class='text text-info'>(Kelas : ".$dp['kelas'].")</span>";
		  }
		}
		?>
	      </td>
	    </tr> 	 	
	  <?php
	  //} // End If session tipe user	
	  ?>
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
	// untuk navigasi data riwayat khusus untuk user terdaftar
	//if ($this->session->userdata('level') != "TAMU") {
	?>
	<div class="row"> <!-- Baris Awal -->
    	<div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwycp'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
          <span class="glyphicon glyphicon-road" aria-hidden="true"></span>&nbspCPNS PNS</button>
          <?php
              echo "</form>";
          ?>
	</div>
    	<div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwydik'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
          <span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>&nbspDiklat</button>
          <?php
              echo "</form>";
          ?>
	</div>
    	<div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwyjab'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-sort" aria-hidden="true"></span>&nbspJabatan
          </button>
          <?php
              echo "</form>";
          ?>
	</div>
        <div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwykp'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">          
          <span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbspPangkat
          </button>
          <?php
            echo "</form>";
          ?>
	</div>
        <div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwypdk'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-education" aria-hidden="true"></span>&nbspPendidikan</button>
          <?php
              echo "</form>";
          ?>
	</div>
	<div class="col-md-2">
    	<?php
            echo "<form method='POST' action='../pegawai/rwytpp'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-danger btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span>&nbspTPP</button>

          <?php
              echo "</form>";
          ?>
    	</div>
	</div> <!-- Akhir Baris Pertama -->
  	<br/>
  	<div class="row"> <!-- Baris Kedua -->
        <div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwykel'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbspKeluarga</button>
          <?php
              echo "</form>";
          ?>
	</div>
        <div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwyph'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-queen" aria-hidden="true"></span>&nbspPenghargaan</button>
          <?php
              echo "</form>";
          ?>
	</div>
        <div class="col-md-1">
          <?php
            echo "<form method='POST' action='../pegawai/rwyskp'>";
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-grain" aria-hidden="true"></span>&nbspSKP</button>

          <?php
              echo "</form>";
          ?>
        </div>
        <div class="col-md-1">
          <?php
            echo "<form method='POST' action='../pegawai/rwykgb'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-plane" aria-hidden="true"></span>&nbspKGB</button>

          <?php
              echo "</form>";
          ?>
	</div>
        <div class="col-md-1">
          <?php
            echo "<form method='POST' action='../pegawai/rwyhukdis'>";
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span>&nbspHukdis</button>

          <?php
              echo "</form>";
          ?>
        </div>
        <div class="col-md-1">
          <?php
            echo "<form method='POST' action='../pegawai/rwycuti'>";          
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-plane" aria-hidden="true"></span>&nbspCuti</button>

          <?php
              echo "</form>";
          ?>
	</div>
        <div class="col-md-1">
          <?php
            echo "<form method='POST' action='../pegawai/rwypmk'>";
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbspPMK</button>

          <?php
              echo "</form>";
          ?>
        </div>
        <div class="col-md-1">
          <?php
            echo "<form method='POST' action='../pegawai/rwylhkpn'>";
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="<?php echo $this->mpegawai->getbuttoncolor($v['nip']); ?> btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span>&nbspLHKPN</button>

          <?php
              echo "</form>";
          ?>
        </div>
	<div class="col-md-2">
          <?php
            echo "<form method='POST' action='../pegawai/rwypenkom'>";
            echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-block btn-outline btn-sm">
            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbspPenKom</button>
          <?php
              echo "</form>";
          ?>
        </div>
  	</div> <!-- Akhir Baris Kedua -->
	<?php
	//}
	?>
	
    </div>
  </div>
</center>

<!-- Modal Info Personal-->
<div id="personal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="dialog">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <form method="POST" action="../pegawai/updateinfopersonal">
        <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>

      <div class="modal-header">
        <h5 class="modal-title">Informasi Personal ::: <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></h5>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:550px;border:1px solid white">
        <?php
          foreach($peg as $v):
        ?>
        
                
        <div class="panel panel-default">
          <div class="panel-body">              
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>NIK</b><br/>
                  <sub><div class='text-danger'>Sesuai NIK pada KTP/KK</div></sub>
                </div>
                <div class="col-md-9 col-xs-10">
                  <input type='text' name='ktp' id='ktp' maxlength='16' value='<?php echo $v['no_ktp']; ?>' required />
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>NPWP</b>
                </div>
                <div class="col-md-9 col-xs-10">
                  <input type='text' name='npwp' id='npwp' maxlength='20' value='<?php echo $v['no_npwp']; ?>'>                  
                  <br/><small class='text-info'>Tulis selengkapnya termasuk Titik dan Strip, Contoh : 67.123.456.0-731.000</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>No. Handphone</b>
                </div>
                <div class="col-md-9 col-xs-5">
                  <input type='text' name='telepon' id='telepon' maxlength='20' value='<?php echo $v['telepon']; ?>' required />                  
                  <sub><span class='text-danger'>WAJIB : Digunakan untuk otentikasi Aplikasi MySAPK</span></sub>
                  <small class='text-info'>Hanya satu No Handphone Aktif, ditulis lengkap tanpa spasi</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Email</b>
                </div>
                <div class="col-md-9 col-xs-10">
                  <input type='text' name='email' id='email' maxlength='50' value='<?php echo $v['email']; ?>' required />                 
                  <sub><span class='text-danger'>WAJIB : Digunakan untuk otentikasi Aplikasi MySAPK</span></sub>
                  <br/><small class='text-info'>Disarankan sesuai dengan email aktif pada Handphone</small>
                </div>
              </div>
	      <div class="row bg-warning" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Status PTKP<br/>PPh 21</b>
                </div>
                <div class="col-md-9 col-xs-10">
		   <?php
			// Ambil PTKP dari Riwayat Keluarga
			$jns_ptkp = $this->mtppng->get_jnsptkp_rwykel($v['nip']);
			$ket_ptkp = $this->mtppng->get_ketptkp($jns_ptkp);
			echo "<b>".$jns_ptkp." - ".$ket_ptkp."</b>";
			// End PTKP dari Riwayat Keluarga

		   //$status_ptkp = $this->mkinerja->get_jnsptkp($v['nip']);
		   //$ket_ptkp = $this->mkinerja->get_ketptkp($v['fid_status_ptkp']);
		   //if ($user = $this->session->userdata('level') == "ADMIN") {
		   ?>		   
		   <!--<input type='hidden' name='id_status_ptkp' id='id_status_ptkp' value='<?php //echo $v['fid_status_ptkp']; ?>' />-->
		   <!--<input type='text' size='40' value='<?php //echo $status_ptkp.' - '.$ket_ptkp; ?>' disabled /> -->
		   <!--<select name="id_status_ptkp" id="id_status_ptkp" required>-->
                    <?php		    
		      /*
                      $sptkp = $this->mpegawai->status_ptkp()->result_array();
                      echo "<option value='' selected>- Pilih Status PTKP -</option>";
                      foreach($sptkp as $sp):
                        if ($v['fid_status_ptkp'] == $sp['id_status_ptkp']) {
                          echo "<option value=".$sp['id_status_ptkp']." selected>".$sp['status']." - ".$sp['keterangan']."</option>";
                        } else {
			  echo "<option value=".$sp['id_status_ptkp'].">".$sp['status']." - ".$sp['keterangan']."</option>";
                        }
                      endforeach;
		      */
                    ?>
                    <!--</select>-->
		    <?php
		    //} else {
		    //  echo "<b>".$status_ptkp." - ".$ket_ptkp."</b>";
		    //}
		    ?>
                  <br/><small class='text-info'>Sesuai dengan keadaan pada awal tahun</small><br/>
		  <small class='text-danger'>WAJIB DIISI : Digunakan untuk perhitungan PPh 21 tahun berjalan, jika kosong maka dihitung sebagai TK/0 (Tidak Kawin tidak ada tanggungan)</small>
		</div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Alamat Rumah</b><br/>
                  <sub><div class='text-danger'>Domisili / Tempat Tinggal</div></sub>
                </div>
                <div class="col-md-9 col-xs-6">
                  <input type='text' name='alamat_rumah' id='alamat_rumah' maxlength='100' size='50' value='<?php echo $v['alamat']; ?>' required />
                  <select name="id_kel_rumah" id="id_kel_rumah" required>
                    <?php
                      $kel = $this->mpegawai->kelurahan()->result_array();                
                      echo "<option value='' selected>- Pilih Desa / Kelurahan -</option>";
                      foreach($kel as $kr):
                        if ($v['fid_alamat_kelurahan'] == $kr['id_kelurahan']) {
                          echo "<option value=".$kr['id_kelurahan']." selected>".$kr['nama_kelurahan']."</option>";
                        } else {
                          echo "<option value=".$kr['id_kelurahan'].">".$kr['nama_kelurahan']."</option>";
                        }
                      endforeach;
                    ?>
                  </select>
                  <br/><small class='text-info'>Jika diluar Balangan, tulis alamat lengkap dan Desa/Kelurahan LUAR BALANGAN</small>
                </div>
              </div>
              <div class="row" style="padding:5px;">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Alamat Sesuai KTP</b>
                </div>
                <div class="col-md-9 col-xs-6">
                  <input type='text' name='alamat_ktp' id='alamat_ktp' maxlength='100' size='50' value='<?php echo $v['alamat_ktp']; ?>' required />
                  <select name="id_kel_ktp" id="id_kel_ktp" required>
                    <?php
                      $kel = $this->mpegawai->kelurahan()->result_array();                
                      echo "<option value='' selected>- Pilih Desa / Kelurahan -</option>";
                      foreach($kel as $kt):
                        if ($v['fid_kelurahan_ktp'] == $kt['id_kelurahan']) {
                          echo "<option value=".$kt['id_kelurahan']." selected>".$kt['nama_kelurahan']."</option>";
                        } else {
                          echo "<option value=".$kt['id_kelurahan'].">".$kt['nama_kelurahan']."</option>";
                        }
                      endforeach;
                    ?>
                  </select>
                  <br/><small class='text-info'>Jika diluar Balangan, tulis alamat lengkap dan Desa/Kelurahan LUAR BALANGAN</small>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 col-xs-2" align='right'>
                  <b>Akun Media Sosial</b><br/>
                  <sub><div class='text-danger'>Boleh dikosongkan</div></sub>
                </div>
                <div class="col-md-9 col-xs-6">
                  <div class="row" style="padding:5px;">
                    <div class="col-md-9 col-xs-10">
                      <div class="col-md-2 col-xs-2"><span class="fa fa-whatsapp fa-2x" aria-hidden="true"></span></div>
                      <div class="col-md-10 col-xs-10">
                        <input type='text' name='whatsapp' id='whatsapp' maxlength='20' size='20' value='<?php echo $v['whatsapp']; ?>' />
                      </div>
                    </div>
                    <div class="col-md-9 col-xs-10">
                      <div class="col-md-2 col-xs-2"><span class="fa fa-instagram fa-2x" aria-hidden="true"></span></div>
                      <div class="col-md-10 col-xs-10">
                        <input type='text' name='instagram' id='instagram' maxlength='20' size='20' value='<?php echo $v['instagram']; ?>' />
                      </div>
                    </div>
                    <div class="col-md-9 col-xs-10">
                      <div class="col-md-2 col-xs-2"><span class="fa fa-twitter-square fa-2x" aria-hidden="true"></span></div>
                      <div class="col-md-10 col-xs-10" >
                        <input type='text' name='twitter' id='twitter' maxlength='20' size='20' value='<?php echo $v['twitter']; ?>' />
                      </div>
                    </div>
                    <div class="col-md-9 col-xs-10">
                      <div class="col-md-2 col-xs-2"><span class="fa fa-facebook-square fa-2x" aria-hidden="true"></span></div>
                      <div class="col-md-10 col-xs-10">
                        <input type='text' name='facebook' id='facebook' maxlength='20' size='20' value='<?php echo $v['facebook']; ?>' />
                      </div>
                    </div>
                    <div class="col-md-9 col-xs-10">
                      <div class="col-md-2 col-xs-2"><span class="fa fa-youtube-square fa-2x" aria-hidden="true"></span></div>
                      <div class="col-md-10 col-xs-10">
                        <input type='text' name='youtube' id='youtube' maxlength='20' size='20' value='<?php echo $v['youtube']; ?>'/>
                      </div>
                    </div>
                    <div class="col-md-9 col-xs-10">
                      <div class="col-md-2 col-xs-2"><span class="fa fa-google-plus fa-2x" aria-hidden="true"></span></div>
                      <div class="col-md-10 col-xs-10">
                        <input type='text' name='google' id='google ' maxlength='20' size='20' value='<?php echo $v['google']; ?>' />
                      </div>
                    </div>


                  </div>
                </div>
              </div>

          </div> <!-- End Panel Body -->
        </div> <!-- End Panel -->
          

        <?php
          endforeach;
        ?> 
      </div> <!-- End Body Modal -->
      <!-- footer modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          <span class="fa fa-ban" aria-hidden="true"></span> Close</button>
        <button type="submit" class="btn btn-success">
          <span class="fa fa-save" aria-hidden="true"></span> Update</button>
      </div> <!-- End footer modal -->
      </form>
    </div> <!-- End Content Modal -->
  </div> <!-- End Dialog Modal -->
</div> <!-- End Modal Info Personal -->

<?php
if ($intbkn_session == "YA") {
?>
<!-- Modal Komparasi SAPK-->
<div id="compare" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Komparasi Data Utama SAPK</h4>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:550px;border:1px solid white">
        <?php
        //apiNewTokenAccess();

        // Jika menggunakan Json API
        $resultApi = apiResult('https://wsrv.bkn.go.id/api/pns/data-utama/'.$v['nip']);
        //$resultApi = apiResult('https://wstraining.bkn.go.id/bkn-resources-server/api/pns/data-utama/198104072009041002');
        $obj = json_decode($resultApi, true);
        //var_dump($obj);

        // Jika menggunakan file Json
        //$url = 'http://localhost/silka/assets/datautama_wsbkn.json';
        //$konten = file_get_contents($url);
        //$obj = json_decode($konten, true);

        //var_dump($obj);

        if(isset($obj['data'])) {
          $data = json_decode($obj['data'], true);
          if(isset($data['id'])) {
            ?>
            <div class="panel">
              <div class="panel-body">
                <small>
                  <table class="table table-condensed table-hover">
                    <thead>
                      <td align='center' width='160'></td>
                      <td align='center' width='320' class='success'><b>DATA SILKa</b></td>
                      <td align='center' class='info'><b>DATA BKN</b></td>
                    </thead>
                    <tr>
                      <td align='right'><b>NIP Baru</b></td>
                      <td><?php echo $v['nip']; ?></td>
                      <td><?php echo $data['nipBaru']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>NIP Lama</b></td>
                      <td><?php echo $v['nip_lama']; ?></td>
                      <td><?php echo $data['nipLama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'
                      <?php echo ($data['gelarDepan'] != $v['gelar_depan']) ? 'style="background-color:LightCoral;"' : '';?>><b>Gelar Depan</b></td>
                      <td><?php echo $v['gelar_depan']; ?></td>
                      <td><?php echo $data['gelarDepan']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'
                      <?php echo ($data['nama'] != $v['nama']) ? 'style="background-color:LightCoral;"' : '';?>><b>Nama</b></td>
                      <td><?php echo $v['nama']; ?></td>
                      <td><?php echo $data['nama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'
                      <?php echo ($data['gelarBelakang'] != $v['gelar_belakang']) ? 'style="background-color:LightCoral;"' : '';?>><b>Gelar Belakang</b></td>
                      <td><?php echo $v['gelar_belakang']; ?></td>
                      <td><?php echo $data['gelarBelakang']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'
                      <?php echo ($data['tempatLahir'] != $v['tmp_lahir']) ? 'style="background-color:LightCoral;"' : '';?>><b>Tempat Lahir</b></td>
                      <td><?php echo $v['tmp_lahir']; ?></td>
                      <td><?php echo $data['tempatLahir']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'
                      <?php echo ($data['tglLahir'] != tgl_indo_pendek($v['tgl_lahir'])) ? 'style="background-color:LightCoral;"' : '';?>><b>Tanggal Lahir</b></td>
                      <td><?php echo tgl_indo_pendek($v['tgl_lahir']); ?></td>
                      <td><?php echo $data['tglLahir']; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $idbkn_agama = $this->mwsbkn->getidbkn_agama($v['fid_agama']);
                      $agama = $this->mpegawai->getagama($v['fid_agama']);
                      ?>
                      <td align='right'
                      <?php echo ($data['agamaId'] != $idbkn_agama) ? 'style="background-color:LightCoral;"' : '';?>><b>Agama</b></td>
                      <td><?php echo $agama; ?></td>
                      <td><?php echo $data['agama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Email</b></td>
                      <td><?php echo $v['email']; ?></td>
                      <td class='warning'><?php echo $data['email']; ?> <code><<< digunakan untuk Login MySAPK</code></td>
                    </tr>
                    <tr>
                      <td align='right'
                      <?php echo ($data['nik'] != $v['no_ktp']) ? 'style="background-color:LightCoral;"' : '';?>><b>NIK</b></td>
                      <td><?php echo $v['no_ktp']; ?></td>
                      <td><?php echo $data['nik']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Alamat</b></td>
                      <td><?php echo $v['alamat'],' ',$this->mpegawai->getkelurahan($v['fid_alamat_kelurahan']);; ?></td>
                      <td><?php echo $data['alamat']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>No. HP/Telepon</b></td>
                      <td><?php echo $v['telepon']; ?></td>
                      <td><?php echo $data['noHp']." / ".$data['noTelp']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Jenis Pegawai</b></td>
                      <td><?php echo $this->mpegawai->getjnspeg($v['nip']); ?></td>
                      <td><?php echo $data['jenisPegawaiNama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Kedudukan</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['kedudukanPnsNama']; ?></td>
                    </tr>
                    <tr>
                      <?php $statpeg = $this->mpegawai->getstatpeg($v['nip']); ?>
                      <td align='right'>
                        <b>Status Pegawai</b></td>
                        <td><?php echo $statpeg; ?></td>
                        <td><?php echo $data['statusPegawai']; ?></td>
                      </tr>
                      <tr>
                       <?php
                       if ($this->mpegawai->getjnskel($v['nip']) == "LAKI-LAKI") {
                        $jenkel = "Pria";
                      } else {
                        $jenkel = "Wanita";
                      }
                      ?>
                      <td align='right' <?php echo ($data['jenisKelamin'] != $jenkel) ? 'style="background-color:LightCoral;"' : '';?>><b>Jenis Kelamin</b></td>                                   
                      <td><?php echo $this->mpegawai->getjnskel($v['nip']); ?></td>
                      <td><?php echo $data['jenisKelamin']; ?></td>
                    </tr>
                    <tr>
                      <td align='right' <?php echo ($data['noSeriKarpeg'] != $v['no_karpeg']) ? 'style="background-color:LightCoral;"' : '';?>><b>No Karpeg</b></td>
                      <td><?php echo $v['no_karpeg']; ?></td>
                      <td><?php echo $data['noSeriKarpeg']; ?></td>
                    </tr>
                    <tr>
		      <?php
                        $thnlulus = $this->mpegawai->getthnluluspdkterakhir($v['nip']);
                        $idbkn_tingpen = $this->mwsbkn->getidbkn_tingpen_rwy($v['nip'], $thnlulus);                         
                        $idbkn_jurpen = $this->mwsbkn->getidbkn_jurpen_rwy($v['nip'], $thnlulus); 
                      ?>
                      <td align='right' <?php echo (($data['tkPendidikanTerakhirId'] != $idbkn_tingpen) OR ($data['pendidikanTerakhirId'] != $idbkn_jurpen)) ? 'style="background-color:LightCoral;"' : '';?>><b>Pendidikan Terakhir</b></td>
                      <td><?php echo $this->mpegawai->getpendidikansingkat($v['nip']); ?>
		      	<abbr title="Sesuai data pendidikan terakhir pada riwayat pendidikan">
                        <span class="glyphicon glyphicon-question-sign text-primary" aria-hidden="true"></span>
                        </abbr>
		      </td>
                      <td><?php echo $data['pendidikanTerakhirNama']." (Lulus ".$data['tahunLulus'].")"; ?></td>
                    </tr>
                    <tr>
                      <?php $tmtcpns = tgl_indo_pendek($this->mwsbkn->gettmtcpns($v['nip'])); ?>                              
                      <?php $noskcpns = $this->mwsbkn->getnoskcpns($v['nip']); ?>                         
                      <?php $tglskcpns = tgl_indo_pendek($this->mwsbkn->gettglskcpns($v['nip'])); ?>
                      <td align='right' <?php echo (($data['tmtCpns'] != $tmtcpns) OR ($data['tglSkCpns'] != $tglskcpns)) ? 'style="background-color:LightCoral;"' : '';?>><b>TMT CPNS<br/>No. SK / Tgl. SK CPNS</b></td>
                      <td><?php echo $tmtcpns."<br/>".$noskcpns." Tgl. ".$tglskcpns; ?></td>
                      <td><?php echo $data['tmtCpns']."<br/>".$data['nomorSkCpns']." Tgl. ".$data['tglSkCpns']; ?></td>
                    </tr>
                    <tr>
		    <?php
		    if ($data['tmtPns']) {
		    ?>
                      <?php $tmtpns = tgl_indo_pendek($this->mwsbkn->gettmtpns($v['nip'])); ?>                                
                      <?php $noskpns = $this->mwsbkn->getnoskpns($v['nip']); ?>                                           
                      <?php $tglskpns = tgl_indo_pendek($this->mwsbkn->gettglskpns($v['nip'])); ?>
                      <td align='right' <?php echo (($data['tmtPns'] != $tmtpns) OR ($data['tglSkPns'] != $tglskpns)) ? 'style="background-color:LightCoral;"' : '';?>><b>TMT PNS<br/>No. SK / Tgl. SK PNS</b></td>
                      <td><?php echo $tmtpns."<br/>".$noskpns." Tgl. ".$tglskpns; ?></td>
                      <td><?php echo $data['tmtPns']."<br/>".$data['nomorSkPns']." Tgl. ".$data['tglSkPns']; ?></td>
                    <?php
		    }
		    ?>
		    </tr>
                    <tr>
                      <td align='right'><b>Kantor Regional BKN</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['kanregNama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Instansi Induk</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['instansiIndukNama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Satuan Kerja Induk</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['satuanKerjaIndukNama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Instansi Kerja</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['instansiKerjaNama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Satuan Kerja</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['satuanKerjaKerjaNama']; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $namaunor = $this->munker->getnamaunker($this->mpegawai->getfidunker($v['nip']));
                      ?> 
                      <td align='right' <?php //echo ($data['unorIndukNama'] != $namaunor) ? 'style="background-color:LightCoral;"' : '';?>><b>Unor Induk</b></td>
                      <td><?php echo $namaunor; ?></td>
                      <td><?php echo $data['unorIndukNama']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Unor</b></td>
                      <td><?php echo $namaunor; ?></td>
                      <td><?php echo $data['unorNama']; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $jnsjab = $this->mkinerja->get_jnsjab($v['nip']);
                      $jnsjabbkn = $data['jenisJabatan'];
                      if ($jnsjabbkn == "FUNGSIONAL_TERTENTU") $jnsjabbkn = "FUNGSIONAL TERTENTU";
                      else if ($jnsjabbkn == "FUNGSIONAL_UMUM") $jnsjabbkn = "FUNGSIONAL UMUM";                   
                      ?> 
                      <td align='right' <?php echo ($jnsjabbkn != $jnsjab) ? 'style="background-color:LightCoral;"' : '';?>><b>Jenis Jabatan</b></td>
                      <td><?php echo $jnsjab; ?></td>
                      <td><?php echo $jnsjabbkn; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Nama Jabatan</b></td>
                      <td><?php echo ""; ?></td>
                      <td><?php echo $data['jabatanNama']; ?></td>
                    </tr>
                    <tr>
		      <?php
                      if ($v['fid_jnsjab'] == '1') { // Jika ybs Struktural
                        $idbkn_jabstruk = $this->mwsbkn->getidbkn_jabstruk($v['fid_jabatan']);
                        $nmjabstruk = $this->mpegawai->namajab($v['fid_jnsjab'], $v['fid_jabatan']);
                      } else {
                        $nmjabstruk = "";
                      }
                      ?>   
                      <td align='right' <?php echo (($v['fid_jnsjab'] == '1') AND ($data['jabatanStrukturalId'] != $idbkn_jabstruk)) ? 'style="background-color:LightCoral;"' : '';?>><b>Nama Jabatan Struktural</b></td>
                      <td><?php echo $nmjabstruk; ?></td>
                      <td><?php echo $data['jabatanStrukturalNama']; ?></td>
                    </tr>
                    <tr>
		      <?php
                      if ($v['fid_jnsjab'] == '2') { // Jika ybs JFU
                        $idbkn_jfu = $this->mwsbkn->getidbkn_jfu($v['fid_jabfu']);
                        $nmjabfu = $this->mpegawai->namajab($v['fid_jnsjab'], $v['fid_jabfu']);
                      } else {
                        $nmjabfu = "";
                      }
                      ?>                      
                      <td align='right' <?php echo (($v['fid_jnsjab'] == '2') AND ($data['jabatanFungsionalUmumId'] != $idbkn_jfu)) ? 'style="background-color:LightCoral;"' : '';?>><b>JFU</b></td>
                      <td><?php echo $nmjabfu; ?></td>
                      <td><?php echo $data['jabatanFungsionalUmumNama']; ?></td>
                    </tr>
                    <tr>
		    <?php
                      if ($v['fid_jnsjab'] == '3') { // Jika ybs JFT
                        $idbkn_jft = $this->mwsbkn->getidbkn_jft($v['fid_jabft']);
                        $nmjabft = $this->mpegawai->namajab($v['fid_jnsjab'], $v['fid_jabft']);
                      } else {
                        $nmjabft = "";
                      }
                      ?>
                      <td align='right' <?php echo (($v['fid_jnsjab'] == '3') AND ($data['jabatanFungsionalId'] != $idbkn_jft)) ? 'style="background-color:LightCoral;"' : '';?>><b>JFT</b></td>
                      <td><?php echo $nmjabft; ?></td>
                      <td><?php echo $data['jabatanFungsionalNama']; ?></td>
                    </tr>                                  
                    <tr>
                      <?php
                      $tmtjab = tgl_indo_pendek($this->mwsbkn->gettmtjab($v['nip']));
                      ?>
                      <td align='right' <?php echo ($data['tmtJabatan'] != $tmtjab) ? 'style="background-color:LightCoral;"' : '';?>><b>TMT Jabatan Terakhir</b></td>
                      <td><?php echo $tmtjab; ?></td>
                      <td><?php echo $data['tmtJabatan']; ?></td>
                    </tr>
                    <tr>
                      <td align='right'><b>Lokasi Kerja</b></td>
                      <td><?php echo "BALANGAN"; ?></td>
                      <td><?php echo $data['lokasiKerja']; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $idgolrucpns = $this->mwsbkn->getgolrucpns($v['nip']);
                      $golrucpns = $this->mpegawai->getnamagolru($idgolrucpns);
                      $idbkn_golrucpns = $this->mwsbkn->getidbkn_golru($idgolrucpns);
                      ?>
                      <td align='right' <?php echo ($data['golRuangAwalId'] != $idbkn_golrucpns) ? 'style="background-color:LightCoral;"' : '';?>><b>Gol. Ruang Awal</b></td>
                      <td><?php echo $golrucpns; ?></td>
                      <td><?php echo $data['golRuangAwal']; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $idbkn_golruskr = $this->mwsbkn->getidbkn_golru($v['fid_golru_skr']);
                      $golruskr = $this->mpegawai->getnamagolru($v['fid_golru_skr']);
                      ?>
                      <td align='right' <?php echo (($data['golRuangAkhirId'] != $idbkn_golruskr) OR ($data['tmtGolAkhir'] != tgl_indo_pendek($v['tmt_golru_skr']))) ? 'style="background-color:LightCoral;"' : '';?>><b>Gol. Ruang Akhir</b></td>
                      <td><?php echo $golruskr." <u>TMT : ".tgl_indo_pendek($v['tmt_golru_skr'])."</u>"; ?></td>
                      <td><?php echo $data['golRuangAkhir']." <u>TMT : ".$data['tmtGolAkhir']."</u>"; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $mkthn = $this->mwsbkn->getmkthn_golru($v['nip'], $v['fid_golru_skr']);                                     
                      $mkbln = $this->mwsbkn->getmkbln_golru($v['nip'], $v['fid_golru_skr']);
                      ?>
                      <td align='right' <?php echo (($data['mkTahun'] != $mkthn) OR ($data['mkBulan'] != $mkbln)) ? 'style="background-color:LightCoral;"' : '';?>><b>Masa Kerja Pangkat Terakhir</b></td>
                      <td><?php echo $mkthn." Tahun ".$mkbln." Bulan"; ?></td>
                      <td><?php echo $data['mkTahun']." Tahun ".$data['mkBulan']." Bulan"; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $idbkn_eselon = $this->mwsbkn->getidbkn_eselon($v['fid_eselon']);
                      $eselon = $this->mpegawai->getnamaeselon($v['fid_eselon']);
                      ?>
                      <td align='right' <?php echo (($data['eselonId'] != "Non Eselon") AND ($data['eselonId'] != $idbkn_eselon)) ? 'style="background-color:LightCoral;"' : '';?>><b>Eselon</b></td>
                      <td><?php echo $eselon." TMT : ".$v['tmt_jabatan']; ?></td>
                      <td><?php echo $data['eselon']." TMT : ".$data['tmtEselon']; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $idbkn_statuskawin = $this->mwsbkn->getidbkn_statkaw($v['fid_status_kawin']);
                      $nm_statuskawin = $this->mpegawai->getstatkawin($v['fid_status_kawin']);
                      ?>
                      <td align='right' <?php echo ($data['jenisKawinId'] != $idbkn_statuskawin) ? 'style="background-color:LightCoral;"' : '';?>><b>Status Kawin</b></td>
                      <td><?php echo $nm_statuskawin; ?></td>
                      <td><?php echo $data['statusPerkawinan']; ?></td>
                    </tr>
                    <tr>
                      <td align='right' <?php echo ($data['noNpwp'] != $v['no_npwp']) ? 'style="background-color:LightCoral;"' : '';?>><b>No. NPWP / Tanggal</b></td>
                      <td><?php echo $v['no_npwp']; ?></td>
                      <td><?php echo $data['noNpwp']." Tgl. : ".$data['tglNpwp']; ?></td>
                    </tr>

                  </table>
                </small>
              </div>
            </div>
            <?php
            } // END IF data Json ada      
            else {
              echo "<center><h3><span class='text-info'>SAPK BKN : </span><span class='text-danger'>".$obj['data']."</span></h3>";
              echo "<h5>Silahkan hubungi Administrator SAPK BKN pada BKPPD Kab. Balangan</h5></center>";
            }
          }                
      ?>
      </div> <!-- End Body Modal -->

      <!-- footer modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> <!-- End footer modal -->
    </div> <!-- End Content Modal -->
  </div> <!-- End Dialog Modal -->
</div> <!-- End Modal Komparasi SAPK -->
<?php
}
?>

<!-- MODAL RIWAYAT VAKSINASI-->
<div id="rwyvaksin" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h5 class="modal-title">Riwayat Vaksinasi COVID-19 ::: <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></h5>
      </div>
      <!-- body modal -->
      <div class="modal-body" align="left" style="padding:10px;overflow:auto;width:100%;height:550px;border:1px solid white">
      <small>
      <?php
	echo '<table class="table table-condensed table-hover">';
      	echo "
      	<tr class='info'>
	<thead>
        <td align='center' width='120'><b>Tanggal Lapor</b></t>
        <td align='center' width='50'><b>Status<br/>Vaksinasi</b></td>
        <td align='center' width='150' class='success'><b>VAKSINASI PERTAMA</b></td>
        <td align='center' width='150' class='success'><b>VAKSINASI KEDUA</b></td>
        <td align='center' width='150'><b>Alasan <br/>(Bagi yang belum/tidak Vaksin)</b></td>
      	</thead>
	</tr>";

	foreach($rwyvaksin as $rv):
	echo "<td>".tglwaktu_indo($rv['created_at'])."</td>";
        if ($rv['status_vaksinasi'] == "SUDAH") {
                echo "<td align='center'>".$rv['status_vaksinasi']."</td>";
                echo "<td>Tgl. Vaksin : ".tgl_indo($rv['vaksin_pertama_tgl'])."<br/>";
		echo "Jenis Vaksin : ".$rv['vaksin_pertama_jenis']."<br/>";
		//echo "QRCode : ".$rv['vaksin_pertama_ticket']."<br/>";
		echo "Lokasi : ".$rv['vaksin_pertama_lokasi'];
		echo "<p class='text-success'><H6>
		<a href=".$rv['vaksin_pertama_bukti']." class='text text-primary' target='_blank'>Lihat Sertifikat Vaksin Pertama</a></H6></p>";
		echo "</td>";
                if (($rv['vaksin_kedua_tgl'] != "1900-01-00") AND ($rv['vaksin_kedua_jenis'] != "")) {
                        echo "<td>Tgl. Vaksin : ".tgl_indo($rv['vaksin_kedua_tgl'])."<br/>";
			echo "Jenis Vaksin : ".$rv['vaksin_kedua_jenis']."<br/>";
			//echo "QRCode : ".$rv['vaksin_kedua_ticket']."<br/>";
			echo "Lokasi : ".$rv['vaksin_kedua_lokasi'];
			echo "<p class='text-success'><H6>
                	<a href=".$rv['vaksin_kedua_bukti']." class='text text-primary' target='_blank'>
			Lihat Sertifikat Vaksin Kedua</a></H6></p>";
			echo "</td>";	
                } else {
                        echo "<td class='warning'>BELUM VAKSIN Ke-2</td>";
                }
                echo "<td>".$rv['alasan']."</td>";
                echo "<tr/>";
	} else if ($rv['status_vaksinasi'] == "BELUM") {
                echo "<td class='danger' align='center'>".$rv['status_vaksinasi']."</td>";
                echo "<td class='danger' colspan='2'></td>";
                echo "<td class='danger'>".$rv['alasan']."</td>";
        } 
	echo "</tr>";
	endforeach;
	echo "</table>";
      ?> 
      </small>
      </div> <!-- end modal body -->
    </div> <!-- end modal content -->
  </div> <!-- end modal dialog -->
</div> <!-- End Modal rwyvaksin -->	
<!-- END MODAL RIWAYAT VAKSINASI -->

<!-- Modal Update Jabatan -->
	<div id="updatejab" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">UPDATE JABATAN</h4>
              </div>
              <!-- body modal -->
              <div class="modal-body" align="left" style="padding:10px;width:100%;height:100%;">
                <form method='POST' name='formupdatejab' style='padding-top:8px' action='../pegawai/update_rwyjabpeta_aksi' enctype='multipart/form-data'>
		    <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class="form-group input-group">
                            <span class="input-group-addon">Unit Kerja</span>
                            <?php
                                //$nmunker = $this->munker->getnamaunker($dp['fid_unit_kerja']);
				$unker = $this->munker->dd_unker()->result_array();
                            ?>
                            <select class="form-control" name="id_unker" id="id_unker" required
                                onChange="showUpdateJabPeta(this.value, formupdatejab.id_jnsjab.value)" style="font-size: 11px;">
                              <?php
                              foreach($unker as $u)
                              {
				if ($dp['fid_unit_kerja'] == $u['id_unit_kerja']) {
                                   echo "<option value='".$u['id_unit_kerja']."' selected>".$u['nama_unit_kerja']."</option>";
				} else {
				   if ($this->session->userdata('level') == "ADMIN") {				   	
					echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
				   }
				}
                              }
                              ?>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <div class="form-group input-group">
                            <span class="input-group-addon" style="width:140px;text-align: left;">Jenis Jabatan</span>
                            <?php
                                $jnsjab = $this->mpetajab->jnsjab()->result_array();
                            ?>
                            <select class="form-control" name="id_jnsjab" id="id_jnsjab" required 
				onChange="showUpdateJabPeta(formupdatejab.id_unker.value, this.value)" style="font-size: 11px;">				
                              <?php
                              echo "<option value='' selected>-- Jenis Jabatan --</option>";
                              foreach($jnsjab as $jj)
                              {
				if (($this->session->userdata('level') == "USER") AND ($jj['nama_jenis_jabatan'] == "FUNGSIONAL UMUM")) {
                                  echo "<option value='".$jj['id_jenis_jabatan']."'>".$jj['nama_jenis_jabatan']."</option>";
				} else if ($this->session->userdata('level') == "ADMIN") {
				  echo "<option value='".$jj['id_jenis_jabatan']."'>".$jj['nama_jenis_jabatan']."</option>";
				}
                              }
                              ?>
                            </select>
                            </div>
                        </div>
                    </div>
		    <div id='tampiljabpeta'></div>
		    <div id='tampiljabpeta1'></div>	
                </form>
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div>
<!-- End Modal Tambah Jabatan -->
