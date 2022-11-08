<?php
// Jika yang login adalah PNS
if ($this->session->userdata('level') == "PNS") {
?>
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid ">
    <!-- Brand and toggle get grouped for better mobile display oke -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?php echo base_url('home') ?>">
        <?php
        echo "<img src=".base_url()."assets/silka3copy.png width='150' height='50'>";
        ?>        
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>-->
        <li><a href="<?php echo base_url('pegawai/detail_dataku') ?>" >CEK DATAKU</a></li>    


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">DOKUMENTASI<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('home/maninfo') ?>" >Informasi Kepegawaian</a></li>
            <li><a href="<?php echo base_url('home/manfile') ?>" >Upload/Download File Berkas</a></li> 
            <li role='separator' class='divider'></li>
            <li><a href="<?php echo base_url('home/laykarpeg') ?>" >Kartu PNS (Karpeg)</a></li>
            <li><a href='<?php echo base_url()."assets/Layanan-Karisu.pdf"; ?>' target='_blank'>Karis Karsu</a></li>     
          </ul>
        </li>
      </ul>

      <!-- dropdown bagian kanan -->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: #0020ff">
            <?php 
            $nip = $this->session->userdata('nip');
            $usernama = $this->session->userdata('nama');
            echo "<b>Hai, ".$usernama."</b>";
            ?>
            <i class="glyphicon glyphicon-user"></i><i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">

            <li>
              <?php
                $lokasifile = './photo/';
                $filename = "$nip.jpg";

                if (file_exists ($lokasifile.$filename)) {
                  $photo = "../photo/$nip.jpg";
                } else {
                  $photo = "../photo/nophoto.jpg";
                }

                echo "<center><img src='$photo' width=75' height='90'></center>";
                echo "</li>";
                echo "<li class='divider'></li>";
                echo "<li><a href='".base_url('akunpns/gantipassword')."' style='color: #0020ff'><i class='fa fa-key fa-fw'></i> Ganti Password</a>";
                echo "</li>";
                echo "<li class='divider'></li>";
                echo "<li><a href='#' onclick='logout()' style='color: #0020ff'><i class='glyphicon glyphicon-log-out'></i> Logout</a>";
                echo "</li>";
              ?>
              </li>
            </ul>
            <!-- /.dropdown-user -->
          </li>
        </ul>
    </div>
  </div>
</nav>
<?php
} else {
// untuk login umpeg / selain PNS
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?php echo base_url('home') ?>">
      <?php
      echo "<img src=".base_url()."assets/silka3copy.png width='150' height='50'>";
      ?>        
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>-->
        <?php
	if ($this->session->userdata('level') == "ADMIN") {
        	echo "<li><a href='".base_url('home/dashboard')."'>Dashboard</a></li>";
	}        
        ?>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pegawai<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <?php
            if ($this->session->userdata('profil_priv') == "Y") {
          		if ($this->session->userdata('level') == "TAMU") {
          	           echo "<li><a href='".base_url('pegawai/carinipnama')."'><span>Cari PNS</span> <span>Alt + ?</span></a> </li>";  
          		} else {	           
          		   echo "<li><a href='".base_url('pegawai/carinipnama')."' style='display: flex; justify-content: space-between; align-items: center'><span>Cari PNS</span> <span style='font-size: 10px; background: #eee; border-radius: 50px;padding-left:5px; padding-right:5px; position: relative; right: -16px;'>Ctrl + ?</span></a></li>";  
          		   echo "<li><a href='".base_url('home/tampilunker')."' style='display: flex; justify-content: space-between; align-items: center'><span>Tampil per Unker </span> <span style='font-size: 10px; background: #eee; border-radius: 50px;padding-left:5px; padding-right:5px; position: relative; right: -16px;'>Alt + /</span></a></li>";	
          		}
            }
            //if ($this->session->userdata('profil_priv') == "Y") {
	    if ($this->session->userdata('level') == "ADMIN") {
              echo "<li role='separator' class='divider'></li>";
              echo "<li><a href='".base_url('nonpns/tampilunker')."'>Non PNS</a></li>";  
            }
            if($this->session->userdata('profil_priv') == "Y"){
            	echo "<li role='separator' class='divider'></li>";
              echo "<li><a href='".base_url('pppk/tampilunker')."'>PPPK</a></li>";
            }

            ?>
            <?php echo "<li role='separator' class='divider'></li>"; ?>
            <li class="dropdown-submenu">
              <a href="#" >Laporan</a>
              <ul class="dropdown-menu">
                <?php
		//if ($this->session->userdata('level') == "ADMIN") {
		if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a class='btn-info' href='".base_url('pip/tampilunkernom_reviewdjasn')."'>Progress IPASN 2021 <sup><code>Versi DJASN BKN</code></sup></a></li>";
                }
                if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('pegawai/tampilunkernom')."'>Nominatif</a></li>";  
                }

                if ($this->session->userdata('statistik_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('pegawai/tampilunkerstat')."'>Statistik</a></li>";  
                }

                if ($this->session->userdata('nip') == "198104072009041002" || $this->session->userdata('nama') == "putra") {
							//if ($this->session->userdata('sotk_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('sotk/tampilunker')."'>Cetak SOTK</a></li>";
                }

                if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('pegawai/tampilprogresspdm')."'>Progress PDM MySAPK <sup><code>Baru</code></sup></a></li>";  
                } 

		if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('pegawai/tampilstatusvaksinasi')."'>Status Vaksinasi COVID-19 <sup><code>Baru</code></sup></a></li>";
                }

		if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('pegawai/tampilunkernomppk')."'>Nominatif PPK</a></li>";
                }

		if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('takah/tampilunkernomtakah')."'>Nominatif Takah</a></li>";  
                } 

		if ($this->session->userdata('nominatif_priv') == "Y") {
                  echo "<li><a tabindex='-1' href='".base_url('pip/tampilunkernom')."'>Nominatif IP-ASN</a></li>";  
                }
                ?>
              </ul>
            </li>
	    <li role='separator' class='divider'></li>
            <li><a tabindex='-1' href="<?php echo base_url('perilaku/kroscekhasil') ?>">Croscek ePerilaku360</a></li>
          </ul>
            
        </li>

        <!-- <?php        
        if (($this->session->userdata('nominatif_priv') == "Y") OR ($this->session->userdata('statistik_priv') == "Y")) {
        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
            if ($this->session->userdata('nominatif_priv') == "Y") {
              echo "<li><a href='".base_url('pegawai/tampilunkernom')."'>Nominatif</a></li>";  
            }

            if ($this->session->userdata('statistik_priv') == "Y") {
              echo "<li><a href='".base_url('pegawai/tampilunkerstat')."'>Statistik</a></li>";  
            }

	    if ($this->session->userdata('nip') == "198104072009041002") {
            //if ($this->session->userdata('sotk_priv') == "Y") {
              echo "<li><a href='".base_url('sotk/tampilunker')."'>Cetak SOTK</a></li>";
            }

	         if ($this->session->userdata('nominatif_priv') == "Y") {
              echo "<li><a href='".base_url('pegawai/tampilunkernomppk')."'>Nominatif PPK</a></li>";  
            }	
            ?>
          </ul>
        </li>
        <?php
        }
        ?> -->
        
        <?php        
        // awal layanan cuti
        if ($this->session->userdata('usulcuti_priv') == "Y") {
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cuti<span class="caret"></span></a>
      	
            <ul class="dropdown-menu">
            <?php
            if ($this->session->userdata('usulcuti_priv') == "Y") {
              echo "<li><a href='".base_url('cuti/tampilpengantar')."'>Buat Usul</a></li>";  
              echo "<li><a href='".base_url('cuti/tampilinbox')."'>Inbox</a></li>";  
              echo "<li><a href='".base_url('cuti/rekapitulasi')."'>Rekapitulasi</a></li>";
            }

            echo "<li role='separator' class='divider'></li>";

            if ($this->session->userdata('prosescuti_priv') == "Y") {
              echo "<li><a href='".base_url('cuti/tampilproses')."'>Proses</a></li>";              
              echo "<li><a href='".base_url('cuti/updatestatus')."'>Update Status</a></li>";  
              echo "<li><a href='".base_url('cuti/statistika')."'>Statistik</a></li>";  
            }

	    // KHUSUS ADMIN, Untuk Edit Pengantar dan Usul Cuti
            echo "<li role='separator' class='divider'></li>";
            if ($this->session->userdata('level') == "ADMIN") {
              echo "<li><a class='btn-warning' href='".base_url('cuti/admin_tampilupdatepengantar')."'>Update Pengantar</a></li>";              
              echo "<li><a class='btn-danger' href='".base_url('cuti/admin_tampilupdateusul')."'>Update Usul</a></li>";
            }
            //
		
            ?>
          </ul>
        </li>
        <?php
        }
        // akhir layanan cuti
        ?>

        <?php
        // awal layanan kgb        
        if ($this->session->userdata('usulkgb_priv') == "Y") {
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gaji Berkala<span class="caret"></span></a>
            <ul class="dropdown-menu">
            <?php            
            if ($this->session->userdata('usulkgb_priv') == "Y") {
              echo "<li><a href='".base_url('kgb/tampilpengantar')."'>Buat Usul</a></li>";  
              //echo "<li><a href='".base_url('kgb/tampilinbox')."'>Inbox</a></li>";  
              echo "<li><a href='".base_url('kgb/rekapitulasi')."'>Rekapitulasi</a></li>";
              echo "<li><a href='".base_url('kgb/bukujaga')."'>Buku Jaga</a></li>";
            }

            echo "<li role='separator' class='divider'></li>";

            if ($this->session->userdata('proseskgb_priv') == "Y") {
              echo "<li><a href='".base_url('kgb/tampilproses')."'>Proses</a></li>";  
            }

            if ($this->session->userdata('proseskgb_priv') == "Y") {
              //echo "<li><a href='".base_url('kgb/updatestatus')."'>Update Status</a></li>";  
            }

            if ($this->session->userdata('proseskgb_priv') == "Y") {
              echo "<li><a href='".base_url('kgb/statistika')."'>Statistik</a></li>";  
            }

	    // KHUSUS ADMIN, Untuk Edit Pengantar dan Usul KGB
            echo "<li role='separator' class='divider'></li>";
            if ($this->session->userdata('level') == "ADMIN") {
              echo "<li><a class='btn-warning' href='".base_url('kgb/admin_tampilupdatepengantar')."'>Update Pengantar</a></li>";              
              echo "<li><a class='btn-danger' href='".base_url('kgb/admin_tampilupdateusul')."'>Update Usul</a></li>";
            }
            //
	
            ?>
          </ul>
        </li>

        <?php
        }
        // akhir layanan kgb	
        ?>

	<?php
        // awal layanan tukin        
	if ($this->session->userdata('tpp_priv') == "Y") {
        //if ($this->session->userdata('level') == "ADMIN") {
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tunjangan Kinerja<span class="caret"></span></a>
            <ul class="dropdown-menu">

	    <?php
            //if ($this->session->userdata('tpp_priv') == "Y") {
	    if ($this->session->userdata('level') == "ADMIN") {
                echo "<li><a tabindex='-1' href='".base_url('absensi/tampilimport')."'>Import Absensi<sup></sup></a></li>";
            	echo "<li><a tabindex='-1' href='".base_url('absensi/tampilimportepresensi')."'>Import e-Presensi<sup><code>Kolektif</code></sup></a></li>";
	    }

            if ($this->session->userdata('tpp_priv') == "Y") {
	      echo "<li><a tabindex='-1' href='".base_url('absensi/tampilimportperorangan')."'>Import e-Presensi<sup><code>Perorangan</code></sup></a></li>";
              echo "<li><a tabindex='-1' href='".base_url('absensi/tampilabsensi')."'>Tampil e-Presensi<sup></sup></a></li>";
            }
            ?>

	    <li role='separator' class='divider'></li>
            <?php
	      //if ($this->session->userdata('level') == "ADMIN") {
              if ($this->session->userdata('tpp_priv') == "Y") {
                echo "<li><a tabindex='-1' href='".base_url('kinerja/tampilimport')."'>Import Kinerja</a></li>";
              }
            ?>

            <?php
	      //if ($this->session->userdata('level') == "USER") {
              if ($this->session->userdata('tpp_priv') == "Y") {
                echo "<li><a tabindex='-1' href='".base_url('kinerja/tampilhasilimport')."'>Tampil Kinerja</a></li>";
              }
            ?>
	    <li role='separator' class='divider'></li>
            <?php
              if ($this->session->userdata('tpp_priv') == "Y") {
	      //if ($this->session->userdata('level') == "ADMIN") {
                echo "<li><a tabindex='-1' href='".base_url('kinerja/tampil_importhitung')."'>Kalkulasi TPP Mandiri <sup><code>Baru</code></sup></a></li>";
              }
            ?>
            
            <?php
	    if ($this->session->userdata('tpp_priv') == "Y") {
	    //if ($this->session->userdata('level') == "ADMIN") {
	    //if (($this->session->userdata('level') == "ADMIN") || ($this->session->userdata('nama') == "uda") || ($this->session->userdata('level') == "USER")) {
                echo "<li><a tabindex='-1' href='".base_url('kinerja/cariusul')."'>Rekapitulasi TPP PNS</a></li>";
                echo "<li><a tabindex='-1' href='".base_url('kinerja_pppk/cariusul_pppk')."'>Rekapitulasi TPP PPPK</a></li>";
		echo "<li role='separator' class='divider'></li>";
		echo "<li><a tabindex='-1' href='".base_url('kinerja/cekhasilimport')."'>Croscek Hasil Import</a></li>"; 
	    }  
                            
            if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198309042007011001") ) {
                echo "<li><a href='".base_url('kinerja/statistika2020')."'>Statistik PNS 2020</a></li>"; 
		echo "<li><a href='".base_url('kinerja/statistika2021')."'>Statistik PNS 2021</a></li>";
		echo "<li><a href='".base_url('kinerja_pppk/statistika2021')."'>Statistik PPPK 2021</a></li>";
		echo "<li><a href='".base_url('kinerja/statistika2022')."'>Statistik PNS 2022</a></li>";
                echo "<li><a href='".base_url('kinerja_pppk/statistika2022')."'>Statistik PPPK 2022</a></li>";
            }

            ?>
          </ul>
        </li>

        <?php
        //}
	}
        // akhir layanan tukin
        ?>
	
	<?php
        // khusus untuk level ADMIN dan USER
        if (($this->session->userdata('level') == "ADMIN") || ($this->session->userdata('level') == "USER")) {
        ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dokumentasi<span class="caret"></span></a>
            
            <ul class="dropdown-menu">
              <li class="dropdown-submenu">
	              <a href="#" >Manual</a>
	              <ul class="dropdown-menu">
			<!--
	                <li><a href="<?php echo base_url('home/maninfo') ?>" >Informasi Kepegawaian</a></li>
	                <li><a href="<?php echo base_url('home/mancuti') ?>" >Cuti</a></li>
	                <li><a href="<?php echo base_url('home/mankgb') ?>" >Kenaikan Gaji Berkala</a></li>
	                <li><a href="<?php echo base_url('home/manfile') ?>" >Upload/Download File Berkas</a></li>
	                <li><a href="<?php echo base_url('home/mannonpns') ?>" >Pendataan Non PNS</a></li>                
			-->
			<li><a href="<?php echo base_url('assets/Manual-Infopeg.pdf') ?>" target='_blank'>Informasi Kepegawaian</a></li>
                        <li><a href="<?php echo base_url('assets/Manual-Cuti.pdf') ?>" target='_blank'>Cuti</a></li>
                        <li><a href="<?php echo base_url('assets/Manual-Kgb.pdf') ?>" target='_blank'>Kenaikan Gaji Berkala</a></li>
                        <li><a href="<?php echo base_url('assets/Manual-File.pdf') ?>" target='_blank'>Upload/Download File Berkas</a></li>
                        <!--<li><a href="<?php echo base_url('assets/Manual-NonPNS.pdf') ?>" target='_blank'>Pendataan Non PNS</a></li>-->
	              </ul>
              </li>
              
              <li class="dropdown-submenu">
	              <a href="#" >Layanan</a>
	              <ul class="dropdown-menu">
	                <li><a href='<?php echo base_url()."assets/Layanan-Karpeg.pdf"; ?>' target='_blank'>Kartu PNS (Karpeg)</a></li>
			<li><a href='<?php echo base_url()."assets/Layanan-Karisu.pdf"; ?>' target='_blank'>Karis Karsu</a></li>
	              </ul>
	      </li>
	      
	      <?php
                //if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198309042007011001") ) {
                //        echo "<li><a href='".base_url('home/kamusjabatan')."'>Kamus Kelas Jabatan</a></li>";
			?>
			<li class="dropdown-submenu">
                      		<a href="#">Data Referensi Pendataan Non PNS 2022</a>
                      		<ul class="dropdown-menu">
                        		<li><a href='<?php echo base_url()."home/ref_jabfu_bkn"; ?>' target=''>Jabatan</a></li>
                        		<li><a href='<?php echo base_url()."home/ref_jurpen_bkn"; ?>' target=''>Pendidikan</a></li>
					<li><a href='<?php echo base_url()."home/ref_lokasi_bkn"; ?>' target=''>Tempat Lahir</a></li>
        				<li><a href='<?php echo base_url()."home/ref_unor_bkn"; ?>' target=''>Unit Kerja</a></li>
					<li><a href='<?php echo base_url()."home/ref_jenisttd_bkn"; ?>' target=''>Pejabat Tandatangan SK</a></li>
				</ul>
              		</li>

			<?php
                //}
             ?>	
	    </ul>
	</li>

<!--         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manual<span class="caret"></span></a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('home/maninfo') ?>" >Informasi Kepegawaian</a></li>
            <li><a href="<?php echo base_url('home/mancuti') ?>" >Cuti</a></li>
            <li><a href="<?php echo base_url('home/mankgb') ?>" >Kenaikan Gaji Berkala</a></li>
            <li><a href="<?php echo base_url('home/manfile') ?>" >Upload/Download File Berkas</a></li>
            <li><a href="<?php echo base_url('home/mannonpns') ?>" >Pendataan Non PNS</a></li>
          </ul>
        </li>
 -->
<!-- 	      <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Formulir Layanan<span class="caret"></span></a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('home/laykarpeg') ?>" >Kartu PNS (Karpeg)</a></li>
            <li><a href="<?php echo base_url('home/laykarisu') ?>" >Karis Karsu</a></li>
            
              <li><a href="<?php echo base_url()."assets/Layanan-Karisu.docx" ?>" target=_blank>Karis Karsu</a></li>            
              <li><a href="<?php echo base_url()."assets/Layanan-Karpeg.pdf" ?>" target=_blank>Karpeg</a></li>            
           
          </ul>
        </li>  -->
        <?php
        }
        ?>

        <?php
        // khusus untuk level admin
        if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('level') == "USER")) {
        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengaturan<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
            if ($this->session->userdata('edit_profil_priv') == "Y") {
              echo "<li><a href='".base_url('admin/carispesimen')."'>Spesimen</a></li>";  
            }

	    if ($this->session->userdata('akunpns_priv') == "Y") {
              echo "<li><a href='".base_url('akunpns/listakun')."'>Akun PNS</a></li>";  
            }
            ?>
          </ul>
        </li>
        <?php
        }
        ?>        

        <?php
        // khusus untuk level admin
        if ($this->session->userdata('level') == "ADMIN") {
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
            <ul class="dropdown-menu">
	            <li><a href="<?php echo base_url('admin/listuser') ?>">User</a></li>            
	            <li><a href="<?php echo base_url('admin/listsopduser') ?>">SOPD User</a></li>            
	            <li><a href="<?php echo base_url('admin/approvephoto') ?>">Approve Photo</a></li>
              <li><a href="<?php echo base_url('files') ?>">Manajemen Files</a></li>
	  		</ul>
          </li>
        <?php
        }
        ?>
				
				<?php
        // khusus untuk level admin
        if ($this->session->userdata('nama')=="kholik"){
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Si-ATUN <span class="caret"></span></a>
            <ul class="dropdown-menu">
									<li><a href="<?php echo base_url('santunan_korpri/entri_santunan') ?>">Entri Santunan</a></li>
									<li><a href="<?php echo base_url('santunan_korpri/rekapitulasi_santunan') ?>">Rekapitulasi</a></li>  
				    </ul>
          </li>
        <?php
        }
        ?>
        
        
        <?php
        // khusus untuk level admin
        if (($this->session->userdata('level') == "ADMIN") || ($this->session->userdata('nama')=="kholik")) {
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pensiun & Mutasi Keluar <span class="caret"></span></a>
            <ul class="dropdown-menu">
					<li><a href="<?php echo base_url('pensiun/proyeksi') ?>">Proyeksi BUP 5 Tahun</a></li>
			          	<li><a href="<?php echo base_url('pensiun/rekap') ?>">Rekapitulasi Pensiun</a></li>
					<?php if($this->session->userdata('nama') == "uda" || $this->session->userdata('nama') == "putra" || $this->session->userdata('nama') == "fitriani"): ?>
                                        <li><a href='<?php echo base_url('pensiun/statistik') ?>'>Statistik</a></li>
					<li role='separator' class='divider'></li>
			          	<li><a href="<?php echo base_url('pensiun/cari_pegawai') ?>">Entri Non BUP & Mutasi</a></li>
					<li><a href="<?php echo base_url('pensiun/rekap_mutasi') ?>">Rekapitulasi Mutasi</a></li> 
					<li role='separator' class='divider'></li>
			          	<?php endif; ?>  
				    </ul>
          </li>
        <?php
        }
        ?>
		
	<!-- Fitur Lainnya -->
	<?php
	if ($this->session->userdata('edit_profil_priv') == "Y") {
        ?>
	<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" role="button" aria-haspopup="true" aria-expanded="false">Fitur Lainnya<span class="caret"></span></a>
            
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
       
              	<?php
		        // khusus untuk level admin
		        if ($this->session->userdata('nama') == "salasiah" || $this->session->userdata('level') == "USER" || $this->session->userdata('level')=="ADMIN") {
		        ?>
		        <li class="dropdown-submenu">
		            <a href="#">Analisis Jabatan</a>
		            <ul class="dropdown-menu">
		              <?php if($this->session->userdata('level') == "ADMIN" || $this->session->userdata('nama') == "salasiah" || $this->session->userdata('nama') == "kholik" ): ?>
		                <li><a href="<?php echo base_url('anjab/anjabmaster') ?>">Syarat Jabatan</a></li>
		                <li><a href="<?php echo base_url('anjab/analisis') ?>">Analisis</a></li>
		                <li role='separator' class='divider'></li>
		                <li><a href="<?php echo base_url('anjab/sensus') ?>">Sensus Anjab</a></li>
		              <?php endif ?>
		              <li><a href="<?php echo base_url('anjab/laporan') ?>">Laporan</a></li>
		            </ul>
		        </li>
		        <?php } ?>
		        
              
            <li class="dropdown-submenu">
		            <a href="#">Diklat</a>
		            <ul class="dropdown-menu">
		               <?php
		                // khusus untuk level admin
		                if ($this->session->userdata('level')=="ADMIN" || $this->session->userdata('nama')=="tamu" || $this->session->userdata('level')=="USER") {
		                ?>
		                <?php if($this->session->userdata('level')=="ADMIN" || $this->session->userdata('nama')=="197912292007011018"){ ?> 
		                  <li><a onclick="menuLink('diklat/syarat_diklat')" href="javascript:void(0)">Syarat Diklat</a></li>
		                <?php } ?>                
		                <li><a onclick="menuLink('diklat/analisis_diklat')" href="javascript:void(0)">Analisa</a></li>
		                <!-- <li role='separator' class='divider'></li> -->
		              <!--<li><a onclick="menuLink('diklat/laporan_diklat')" href="javascript:void(0)">Laporan</a></li>-->
		              <?php } ?>
		
		            </ul>
		        </li>
							
			  <li class="dropdown-submenu">
		            <a href="#">Si - TINA</a>
		            <ul class="dropdown-menu">
		               <?php
		                // khusus untuk level admin
		                if ($this->session->userdata('level')=="ADMIN" || $this->session->userdata('level')=="USER") {
				  		echo "<li><a tabindex='-1' href='".base_url('diklat/laporan_diklat_v2')."'>Analisis Kebutuhan Diklat</a></li>";
						}
			     		 ?>
		            </ul>
		       </li>
		       
		       <li class="dropdown-submenu">
		            <a href="#">Si - ADIS</a>
		            <ul class="dropdown-menu">
		               <?php
		                // khusus untuk level admin
		                //if (($this->session->userdata('level')=="ADMIN") OR ($this->session->userdata('nip') == "198705242010012015")) {
		                  if (($this->session->userdata('edit_profil_priv') == "Y") OR ($this->session->userdata('nip') == "198705242010012015")){
		                  ?>                
		                  <li><a href="<?php echo base_url('hukdis/tampilusulhukdis') ?>">Laporkan Hukdis</a></li>
		                  <?php
		                  }
		                  // khusus untuk level admin
				 		  if (($this->session->userdata('level')=="ADMIN") OR ($this->session->userdata('nip') == "198705242010012015")) {
		                  //if ($this->session->userdata('level')=="ADMIN") {
		                  ?>
				  		  <li role='separator' class='divider'></li>
		                  <li><a href="<?php echo base_url('hukdis/tampilvalidasi') ?>">Validasi</a></li>
		                  <li><a href="<?php echo base_url('hukdis/statistika') ?>">Statistik</a></li>
			              <?php 
			                } 
			              ?>
			              <li role='separator' class='divider'></li>
			              <li><a href="<?php echo base_url('home/panduan_siadis') ?>" >Panduan SiAdis</a></li>  
		
		            </ul>
		        </li>
		        <li class="dropdown-submenu">
	            <a href="#">Si - PETRUK </a>
	            <ul class="dropdown-menu">
										<li><a href="<?php echo base_url('petruk/penilaian') ?>">Penilaian</a></li>
			              <li role='separator' class='divider'></li>
			              <li><a href="<?php echo base_url('home/panduan_sipetruk') ?>" >User Guide</a></li>  
										<?php 
											if (($this->session->userdata('level')=="ADMIN") || ($this->session->userdata('nama')=="sukiman")) {
										?>
											<li><a href="<?php echo base_url('petruk/rekapitulasi') ?>">Rekapitulasi</a></li>  
										<?php } ?>
					    </ul>
	          </li>
          
		        <?php
		                // khusus untuk level admin
		                if ($this->session->userdata('level')=="ADMIN") { ?>
		        <li class="dropdown-submenu">
		            <a href="#">Si - ATUN</a>
		            <ul class="dropdown-menu">
		           <?php
								  		echo "<li><a tabindex='-1' href='".base_url('santunan_korpri/entri_santunan')."'>Entri Santunan</a></li>";
								  		echo "<li><a tabindex='-1' href='".base_url('santunan_korpri/rekapitulasi_santunan')."'>Rekapitulasi</a></li>";
										
			     		 ?>
		            </ul>
		       </li>
		              <?php } ?>

            
              <li class="dropdown-submenu" aria-haspopup="true">
              <a href="#">Rancangan Pengembangan Karir</a>
                  <ul class="dropdown-menu">
                  <?php
                          echo "<li><a tabindex='-1' href='".base_url('/rpk')."'>Profile</a></li>";            
                          echo "<li><a tabindex='-1' href='".base_url('/rpk/petajabatan')."'>Pemetaan</a></li>";            
                          echo "<li><a tabindex='-1' href='".base_url('/rpk/instansi')."'>Instansi</a></li>";            
                          echo "<li><a tabindex='-1' href='".base_url('/rpk/kompetensi')."'>Penyelarasan Kompetensi</a></li>";    
                          echo "<li role='separator' class='divider'></li>";        
                          echo "<li><a tabindex='-1' href='".base_url('/rpk/rekap')."'>Rekapitulasi</a></li>";            
                  ?>
                  </ul>
              </li>
		        
		    </ul>
		</li>
	<?php
	}
	?>
      </ul>
	


      <!--
      <form class="navbar-form navbar-left" role="search" method="POST" action="../pegawai/tampilnipnama">
        <div class="form-group">
          <input type="text" name="data" id="data" class="form-control" placeholder="Ketik NIP atau Nama" size='25' maxlength='25'>
        </div>
        <button type="submit" class="btn btn-primary">
          <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Cari Pegawai</button>
      </form>      
      -->
      <ul class="nav navbar-nav navbar-right">        
      
      <!-- /.dropdown -->
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          <?php 
          $nip = $this->session->userdata('nip');
          $usernama = $this->session->userdata('nama');
          //$nama = $this->mpegawai->getnama($nip);
          echo "<b>Hai, ".$usernama."</b>";
          ?>
          <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">

          <li>
          <?php
            if ($this->session->userdata('level') != "TAMU") {
              $lokasifile = './photo/';
              $filename = "$nip.jpg";

              if (file_exists ($lokasifile.$filename)) {
                $photo = "../photo/$nip.jpg";
              } else {
                $photo = "../photo/nophoto.jpg";
              }

              echo "<center><img src='$photo' width=75' height='90'></center>";
              echo "</li>";
              echo "<li class='divider'></li>";
              echo "<li><a href='".base_url('login/gantipassword')."'><i class='fa fa-key fa-fw'></i> Ganti Password</a>";
              echo "</li>";
              echo "<li class='divider'></li>";
              echo "<li><a href='#' onclick='logout()' style='display: flex; justify-content: space-between; align-items: center'><span><i class='fa fa-sign-out fa-fw'></i> Logout<span> <span style='font-size: 10px; background: #eee; border-radius: 50px;padding-left:5px; padding-right:5px; position: relative; right: -16px;'>Ctrl + q</span></a>";
              
              if($this->session->userdata('level') == 'ADMIN'):
              echo "<li class='divider'></li>";
              echo "<li class='text-center'>
			              	Switch to dark mode
			              	<div class='custom-control custom-switch'>
											  <input type='checkbox' class='custom-control-input' id='darkSwitch'>
											  <label class='custom-control-label' for='darkSwitch'>Dark Mode</label>
											</div>
			              </li>";
              endif;
              
              echo "</li>";
            } else if ($this->session->userdata('level') == "TAMU") {
              echo "<li><a href='".base_url('login/keluar')."'><span><i class='fa fa-sign-out fa-fw'></i> Logout</span></a>";
              echo "</li>";
            }
          ?>
          
          
        </ul>
        <!-- /.dropdown-user -->
      </li>
      <!-- /.dropdown -->

        <!--
        <p class="navbar-text">Anda Login sebagai 
        <?php 
          //$nip = $this->session->userdata('nip');
          //$usernama = $this->session->userdata('nama');
          //$nama = $this->mpegawai->getnama($nip);
          //echo "<b>".$usernama."</b>";
        ?> | 
        <a href="<?php echo base_url('login/gantipassword') ?>">Ganti Password</a></p>
        
        <li><a href="<?php echo base_url('login/keluar') ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbspLogout</a></li>
        </button>
        -->
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php
// Akhir menu jika yg login selain PNS
}
?>

<style type="text/css">
  .dropdown-submenu {
  position: relative;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>.dropdown-menu {
  display: block;
}
.dropdown-submenu .dropdown-menu {
  left: 100%;
  top: -8px; 
  margin-left: 2px;
}
.dropdown-submenu .pull-left {
  float: none;
}


</style>
<script src="<?php echo base_url('assets/dark-mode/dark-mode-switch.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/sweetalert/sweetalert.js') ?>"></script>

<script type="text/javascript">
window.addEventListener("keydown", function (event) {
	if(event.altKey && event.keyCode === 191) {
		window.location.replace(`<?= base_url('home/tampilunker') ?>`)
	} else if(event.ctrlKey && event.keyCode === 191) {
		window.location.replace(`<?= base_url('pegawai/carinipnama') ?>`)
	} else if(event.ctrlKey && event.keyCode === 81) {
		return logout();
	}
	//console.log(event.keyCode)
});

function menuLink(link) {
  $.ajax({
    url: '<?php echo base_url() ?>'+link,
    method: 'POST',
    dataType: 'html',
    success: function(data){
      //$("#content-data").html(data)
      window.location.href='<?php echo base_url() ?>'+link;
    }
  });
}
function logout(){
  swal({
    title: "SILKa Menyatakan!",
    text: "Apakah anda yakin akan keluar dari system?",
    type: "info",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Ya, keluar!",
    cancelButtonText: "No, cancel !",
    closeOnConfirm: true,
    closeOnCancel: true,
    showLoaderOnConfirm: true
  },
  function(isConfirm) {
    if (isConfirm) {
      window.location="<?php echo base_url('login/keluar') ?>";
    } else {
      //swal("Cancelled", "Your imaginary file is safe :)", "error");
    }
  });
}
</script>
