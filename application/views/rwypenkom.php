<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
	<table class='table table-condensed'>
        <tr>
          <td align='right' width='50'>
            <?php
              echo "<form method='POST' action='../pegawai/detail'>";          
              echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
            ?>
              <p align="right">
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
              </p>
            <?php
              echo "</form>";          
            ?>
          </td>
        </tr>
      </table>
 		
      <?php
      if (isset($pesan) != '') {
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
      <div class="panel panel-info" style="padding:3px;overflow:auto;width:100%;height:420px;border:1px solid white">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-education" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT PENILAIAN KOMPETENSI</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>
        <table class="table">
       	  <?php if (($this->session->userdata('level') == 'ADMIN') AND ($this->mpegawai->cekstatuslhkpn($nip) == 'YA')): ?>
          <tr>
            <td class="text-right">
        	<button class="btn btn-primary btn-outline" data-toggle="modal" data-target="#entripdk">+ Tambah</button>
            </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td align='center'>
                <table class='table table-condensed table-hover'>
                  <tr class='warning'>
                    <th width='20'><center>#</center></th>
                    <th align='80'><center>Pelaksanaan</center></th>
                    <th width='35%'><center>Jabatan / Unit Kerja</center></th>
                    <th width='120'><center>Manajemen<br/>Sosial Kultural</center></th>
                    <th width='120'><center>Literasi Digital</center></th>
                    <th width='120'><center>Emerging Skills</center></th>
                    <th width='150'><center>Prediksi Potensi sesuai Permenpanrb 3/2020</center></th>
		    <th colspan='5'><center></center></th>
                  </tr>
                  <?php
                    $no=1;
                    foreach($pegrwypenkom as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td align='center'><small><?php echo $v['lokasi']."<br/><span class='text text-muted'>".tglwaktu_indo($v['check_in'])."</span></small>"; ?></td>
                    <td><small><?php echo $v['unker']."<br/><span class='text text-muted'>".$v['unker_induk']."</span></small>"; ?></td>
                    <td align='center' style='padding :5px;'>
			<?php
			echo "<span class='text text-primary pull-left'>Total</span>
                              <span class='label label-primary pull-right'>".strtoupper($v['mansoskul_total'])."</span><br/>";
			echo "<span class='text text-primary pull-left'>Standar</span>
                                <span class='label label-success pull-right'>".strtoupper($v['mansoskul_standar'])."</span><br/>";
			echo "<span class='text text-primary pull-left'><abbr title='(Job Person Match) adalah persentase kesesuaian level Kompetensi Pegawai terhadap SKJ.'>JPM</abbr></span>
                                <span class='label label-warning pull-right'>".strtoupper($v['mansoskul_jpm'])." %</span><br/>";
			echo "<span class='text text-primary pull-left'><b>".$v['mansoskul_kategori']."</b></span>";
			?>
		    </td>
                    <td align='center' style='padding :5px;'>
			<?php
                        echo "<span class='text text-primary pull-left'>Total</span>
                              <span class='label label-primary pull-right'>".strtoupper($v['litdig_total'])."</span><br/>";
                        echo "<span class='text text-primary pull-left'>Standar</span>
                                <span class='label label-success pull-right'>".strtoupper($v['litdig_standar'])."</span><br/>";
                        echo "<span class='text text-primary pull-left'>JPM</span>
                                <span class='label label-warning pull-right'>".strtoupper($v['litdig_jpm'])." %</span><br/>";
                        echo "<span class='text text-primary pull-left'><b>".$v['litdig_kategori']."</b></span>";
                        ?>
		    </td>
                    <td align='center' style='padding :5px;'>
			<?php
                        echo "<span class='text text-primary pull-left'>Total</span>
                              <span class='label label-primary pull-right'>".strtoupper($v['emskil_total'])."</span><br/>";
                        echo "<span class='text text-primary pull-left'>Standar</span>
                                <span class='label label-success pull-right'>".strtoupper($v['emskil_standar'])."</span><br/>";
                        echo "<span class='text text-primary pull-left'>JPM</span>
                                <span class='label label-warning pull-right'>".strtoupper($v['emskil_jpm'])." %</span><br/>";
                        echo "<span class='text text-primary pull-left'><b>".$v['emskil_kategori']."</b></span>";
                        ?>
		    </td>
                    <td align='center'>
			 <?php
                        echo "<span class='text text-primary pull-left'>Total</span>
                              <span class='label label-primary pull-right'>".strtoupper($v['permenpan3-2020_total'])."</span><br/>";
                        echo "<span class='text text-primary pull-left'>Standar</span>
                              <span class='label label-success pull-right'>".strtoupper($v['permenpan3-2020_standar'])."</span><br/>";
                        echo "<span class='text text-primary pull-left'>JPM</span>
                              <span class='label label-warning pull-right'>".strtoupper($v['permenpan3-2020_jpm'])." %</span><br/>";
                        ?>
		   </td>
		   <?php if($this->session->userdata('nip') === '198104072009041002'): ?>
		    <td align='center'>
                          <?php
			  $nama = $this->mpegawai->getnama_only($v['nip']);
			  /*
			  if (file_exists('./filepenkom/laporan/'.$v['nip'].'_'.$nama.'.pdf')) {
                                $ket = "Upload Ulang<br/>Laporan";
                                $jnsfile = ".pdf";
                                $btncolor = "btn-warning";
                          } else if (file_exists('./filepenkom/laporan/'.$v['nip'].'_'.$nama.'.PDF')) {
                                $ket = "Upload Ulang<b/>Laporan";
                                $jnsfile = ".PDF";
                                $btncolor = "btn-warning";
                          } else {
                                $ket = "Upload<br/>Laporan";
                                $btncolor = "btn-info";
                          }
			  */
			  ?>	
			
 			  <!--
                          <button type='button' class='btn <?php echo $btncolor; ?> btn-outline btn-xs' data-toggle='modal' data-target='#uploadlap<?php echo $v['id']; ?>'>
                            <?php echo $ket; ?>
                          </button>
			  -->	

                          <?php
                          if ((file_exists('./filepenkom/laporan/'.$v['nip'].'_'.$nama.'.pdf')) OR (file_exists('./filepenkom/'.$v['nip'].'_'.$nama.'.PDF'))) {
                          ?>
                            <a class='btn btn-info btn-outline btn-xs' href='../filepenkom/laporan/<?php echo $v['nip'].'_'.$nama.'.pdf'; ?>' target='_blank' role='button'>
                            View<br/>Laporan</a>
                          <?php
                          }
                          ?>
                        <!-- Modal Upload Laporan -->
                        <div id="uploadlap<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-primary'>UPLOAD DOKUMEN LAPORAN PENILAIAN KOMPETENSI</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
					$tgl = date('Y-m-d', strtotime($v['check_in']));
                                        echo "<span class='text text-primary'>".$v['lokasi']."<br /> Tanggal ".tgl_indo($tgl)."</span>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                  <form method="POST" name="formuploadlappenkom" action="<?=base_url()?>upload/insert_lappenkom" enctype="multipart/form-data">
                                  <input type='hidden' name='id' id='id' value='<?php echo $v['id']; ?>' >
                                  <input type='hidden' name='nip' id='nip' value='<?php echo $v['nip']; ?>' >
                                  <input type='hidden' name='berkaslama' id='berkaslama' value='<?php echo $v['file_laporan']; ?>' >
                                  <div class="row"'>
                                    <div class="col-md-4"><span class='text text-primary'>Pilih file dokumen dengan format .pdf maks 500 KByte.</span>
                                    </div>
                                    <div class="col-md-5">
                                      <input type="file" name="filetbn" class="btn btn-xs btn-info">
                                    </div>
                                    <div class="col-md-3" align='center'>
                                      <button type="submit" value="upload" class="btn btn-sm btn-primary btn-outline">
                                        <span class="fa fa-upload" aria-hidden="false"></span>&nbspUpload File
                                      </button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal Upload Laporan -->

                        </td>
                    	<td align='center'>
                          <?php
			  $nama = $this->mpegawai->getnama_only($v['nip']);
			  /*
                          if (file_exists('./filepenkom/sert/'.$v['nip'].'_'.$nama.'.pdf')) {
                                $ket = "Upload Ulang<br/>Sertifikat";
                                $jnsfile = ".pdf";
                                $btncolor = "btn-warning";
                          } else if (file_exists('./filepenkom/'.$v['nip'].'_'.$nama.'.PDF')) {
                                $ket = "Upload Ulang<br/>Sertifikat";
                                $jnsfile = ".PDF";
                                $btncolor = "btn-warning";
                          } else {
                                $ket = "Upload<br/>Sertifikat";
                                $btncolor = "btn-success";
                          }
			  */
                          ?>

			  <!--
                          <button type='button' class='btn <?php echo $btncolor; ?> btn-outline btn-xs' data-toggle='modal' data-target='#uploadsert<?php echo $v['id']; ?>'>
                            <?php echo $ket; ?>
                          </button>
			  -->

                          <?php
                          if ((file_exists('./filepenkom/sert/'.$v['nip'].'_'.$nama.'.pdf')) OR (file_exists('./filepenkom/sert/'.$v['nip'].'_'.$nama.'.PDF'))) {
                          ?>
                            <a class='btn btn-success btn-outline btn-xs' href='../filepenkom/sert/<?php echo $v['nip'].'_'.$nama.'.pdf'; ?>' target='_blank' role='button'>
                            View<br/>Sertifikat</a>
                          <?php
                          }
                          ?>
                        <!-- Modal Upload Sertifikat -->
                        <div id="uploadtbn<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-primary'>UPLOAD DOKUMEN TAMBAHAN BERITA NEGARA LHKPN</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
					$tgl = date('Y-m-d', strtotime($v['check_in']));
                                        echo "<span class='text text-primary'>".$v['lokasi']."<br /> Tanggal ".tgl_indo($tgl)."</span>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                  <form method="POST" name="formuploadsertpenkom" action="<?=base_url()?>upload/insert_sertpenkom" enctype="multipart/form-data">
                                  <input type='hidden' name='id' id='id' value='<?php echo $v['id']; ?>' >
                                  <input type='hidden' name='nip' id='nip' value='<?php echo $v['nip']; ?>' >
                                  <input type='hidden' name='berkaslama' id='berkaslama' value='<?php echo $v['file_sertifikat']; ?>' >
                                  <div class="row"'>
                                    <div class="col-md-4"><span class='text text-primary'>Pilih file dokumen dengan format .pdf maks 1 Mega Byte.</span>
                                    </div>
                                    <div class="col-md-5">
                                      <input type="file" name="filetbn" class="btn btn-xs btn-info">
                                    </div>
                                    <div class="col-md-3" align='center'>
                                      <button type="submit" value="upload" class="btn btn-sm btn-primary btn-outline">
                                        <span class="fa fa-upload" aria-hidden="false"></span>&nbspUpload File
                                      </button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal Upload Sertifikat -->
                        </td>
                        <td width='20'>
			  <button type='button' class='btn btn-warning btn-outline btn-xs' data-toggle='modal' data-target='#dtlpenkom<?php echo $v['id']; ?>'>Detail Hasil<br/>Penilaian</button>
                          <!-- Modal Detail Penkom -->
                          <div id="dtlpenkom<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                           <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document" style="width: 90%;">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-primary'>DETAIL PENILAIAN KOMPETENSI</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
					$tgl = date('Y-m-d', strtotime($v['check_in']));
                                        echo "<span class='text text-primary'>".$v['lokasi']." Tanggal ".tgl_indo($tgl)."</span>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
					<?php
                                        echo "<span class='text text-muted'>JABATAN : ".$v['unker']."</span><br/>";
                                        echo "<span class='text text-muted'>UNIT KERJA : ".$v['unker_induk']."</span>";
                                	?>
				    <!-- <div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" > --> <!-- Scroll Up Down -->
				     <div class="row"> <!-- Row Mansosku dan Litdig -->
                                       <div class="col-lg-6">	
					<div class="panel panel-primary">
						<!--<div class="panel-heading">Kompetensi Manajerial dan Sosial Kultural</div>-->
  						<div class="panel-body">
						   <h5 class='modal-title text text-primary'>KOMPETENSI MANAJERIAL DAN SOSIAL KULTURAL</h5>	
						   <div class="row">
						     <div class="col-lg-6">	
							<span class='text text-default'>KRITERIA <?php echo strtoupper($v['mansoskul_level']);?></span>
							<table class='table table-condensed table-hover'>
                  						<tr class='info'>
                    							<th width='10'><center>#</center></th>
                    							<th align='80'><center>Aspek</center></th>
                    							<th width='300'><center>Standar</center></th>
                    							<th width='120'><center>Capaian</center></th>
                    							<th width='120'><center>GAP</center></th>
                  						</tr>
								<tr><td colspan='5'>MANAJERIAL</td></tr>
								<tr>
									<td width='10'><center>1</center></td>
                                                                        <td width='80%'>
									<abbr title="Konsisten berperilaku selaras dengan nilai, norma, dan/atau etika organisasi, dan jujur dalam hubungan dengan manajemen, rekan kerja, bawahan langsung, dan pemangku kepentingan. Menciptakan budaya etika tinggi, bertanggungjawab atas tindakan atau keputusan beserta risiko yang menyertainya."><b>Integritas</b></abbr>
									</td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_itg']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_itg']-3; ?></td>
								</tr>
								<tr>
                                                                        <td width='10'><center>2</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan menjalin, membina, mempertahankan hubungan kerja yang efektif, memiliki komitmen saling membantu dalam penyelesaian tugas, dan mengoptimalkan segala sumber daya untuk mencapai tujuan strategis organisasi."><b>Kerjasama</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_kjs']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_kjs']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>3</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan untuk menerangkan pandangan dan gagasan secara jelas, sistematis disertai argumentasi yang logis dengan cara-cara yang sesuai baik secara lisan maupun tertulis; memastikan pemahaman; mendengarkan secara aktif dan efektif; mempersuasi, meyakinkan dan membujuk orang lain dalam rangka mencapai tujuan organisasi."><b>Komunikasi</b></abbr> 
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_kom']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_kom']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>4</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan mempertahankan komitmen pribadi yang tinggi untuk menyelesaikan tugas, dapat diandalkan, bertanggung jawab, mampu secara sistimatis mengidentifikasi risiko dan peluang dengan memperhatikan keterhubungan antara perencanaan dan hasil, untuk keberhasilan organisasi."><b>Orientasi pada Hasil</b></abbr>
                                                                        </th>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_oph']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_oph']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>5</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan dalam melaksanakan tugas-tugas pemerintahan, pembangunan dan kegiatan pemenuhan kebutuhan pelayanan publik secara profesional, transparan, mengikuti standar pelayanan yang objektif, netral, tidak memihak, tidak diskriminatif, serta tidak terpengaruh kepentingan pribadi/ kelompok/ golongan/ partai politik."><b>Pelayanan Publik</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_pep']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_pep']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>6</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan untuk meningkatkan pengetahuan dan menyempurnakan keterampilan diri; menginspirasi orang lain untuk mengembangkan dan menyempurnakan pengetahuan dan keterampilan yang relevan dengan pekerjaan dan pengembangan karir jangka panjang, mendorong kemauan belajar sepanjang hidup, memberikan saran/bantuan, umpan balik, bimbingan untuk membantu orang lain 	untuk mengembangkan potensi dirinya."><b>Pengembangan Diri dan Orang Lain</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_pdo']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_pdo']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>7</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan dalam menyesuaikan diri dengan situasi yang baru atau berubah dan tidak bergantung secara berlebihan pada metode dan proses lama, mengambil tindakan untuk mendukung dan melaksanakan insiatif perubahan, memimpin usaha perubahan, mengambil tanggung jawab pribadi untuk memastikan perubahan berhasil diimplementasikan secara efektif."><b>Mengelola Perubahan</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_mpu']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_mpu']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>8</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan membuat keputusan yang baik secara tepat waktu dan dengan keyakinan diri setelah mempertimbangkan prinsip kehati-hatian, dirumuskan secara sistematis dan seksama berdasarkan berbagai informasi, alternatif pemecahan masalah dan konsekuensinya, serta bertanggung jawab atas keputusan yang diambil."><b>Pengambilan Keputusan</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_pkp']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_pkp']-3; ?></td>
                                                                </tr>
								<tr><td colspan='5'>SOSIAL KULTURAL</td></tr>
                                                                <tr>
                                                                        <td width='10'><center>9</center></td>
                                                                        <td width='80%'>
									<abbr title="Kemampuan dalam mempromosikan sikap toleransi, keterbukaan, peka terhadap perbedaan individu/kelompok masyarakat; mampu menjadi	perpanjangan tangan pemerintah dalam mempersatukan masyarakat dan membangun hubungan sosial psikologis dengan masyarakat di tengah kemajemukan Indonesia sehingga menciptakan kelekatan yang kuat antara ASN dan para pemangku kepentingan serta diantara para pemangku kepentingan itu sendiri; menjaga, mengembangkan, dan mewujudkan rasa persatuan dan kesatuan dalam kehidupan bermasyarakat, berbangsa dan bernegara Indonesia."><b>Perekat Bangsa</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['mansoskul_prb']; ?></td>
                                                                        <td align='center'><?php echo $v['mansoskul_prb']-3; ?></td>
                                                                </tr>
								<tr>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>TOTAL</b></td>
                                                                        <td align='center'><b><?php echo $v['mansoskul_standar']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['mansoskul_total']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['mansoskul_total']-$v['mansoskul_standar']; ?></b></td>
                                                                </tr>
								<?php
									if ($v['mansoskul_level'] == "Level 2") {
										$totjabatas = 27;
										$lvjabatas = "Level 3";
									} else if ($v['mansoskul_level'] == "Level 3") {
										$totjabatas = 36;
                                                                                $lvjabatas = "Level 4";
									} else if ($v['mansoskul_level'] == "Level 4") {
                                                                                $totjabatas = 45;
                                                                                $lvjabatas = "Level 5";
                                                                        }
                                                                        $persen_jabatas = ($v['mansoskul_total'] / $totjabatas) * 100;

									if ($persen_jabatas < 68) $kat_jabatas = "Kurang Memenuhi Syarat";
									else if ($persen_jabatas >= 68 AND $persen_jabatas < 80) $kat_jabatas = "Masih Memenuhi Syarat";
									else if ($persen_jabatas >= 80) $kat_jabatas = "Memenuhi Syarat";

								?>
                                                                <tr class='info'>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>JPM (KATEGORI)</b></td>
                                                                        <td align='center' colspan='3'><b><span class='text text-primary'><?php echo $v['mansoskul_jpm']." % (".$v['mansoskul_kategori'].")"; ?></b></span></td>
								</tr>
								<tr class='warning'>
                                                                        <td width='80%' colspan='5' align='left'>JPM Proyeksi Jabatan satu tingkat diatas
										<?php echo " - ".$lvjabatas." (Standar : ".$totjabatas.")"; ?>
									<br/>
									<span class='text text-primary'><?php echo number_format($persen_jabatas,2,",",".")." % (".$kat_jabatas.")"; ?></span>
                                                                </tr>
							</table>
						     </div> <!-- End Kolom -->
						     <div class="col-lg-6" align='center'>
							<div id="mansoskul_chart" style="height: 100%; width: 100%"></div>
						     </div> <!-- End Kolom Chart -->			
						   </div> <!-- End Row -->		
						</div>
					  </div> <!-- End Panel Primary -->
					</div> <!-- End Kolom Mansosku -->

					<div class="col-lg-6" align='left'> <!-- Kolom Litdig --> 
					  <div class="panel panel-success">
                                                <div class="panel-body">
                                                   <h5 class='modal-title text text-success'>LITERASI DIGITAL</h5>
                                                   <div class="row">
                                                     <div class="col-lg-6">
                                                        <span class='text text-default'>KRITERIA <?php echo strtoupper($v['litdig_level']);?></span>
                                                        <table class='table table-condensed table-hover'>
                                                                <tr class='success'>
                                                                        <th width='10'><center>#</center></th>
                                                                        <th align='80'><center>Aspek</center></th>
                                                                        <th width='300'><center>Standar</center></th>
                                                                        <th width='120'><center>Capaian</center></th>
                                                                        <th width='120'><center>GAP</center></th>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>1</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan individu dalam mengetahui, memahami, dan menggunakan perangkat keras dan piranti lunak TIK serta sistem operasi digital."><b>Digital Skills</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['litdig_dsk']; ?></td>
                                                                        <td align='center'><?php echo $v['litdig_dsk']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>2</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan individu dalam membaca, menguraikan, membiasakan, memeriksa, dan membangun wawasan kebangsaan, nilai Pancasila, dan Bhinneka Tunggal Ika dalam kehidupan sehari-hari."><b>Digital Culture</b></abbr>
                                                                        </td>
                                                                        <td align='center'>4</td>
                                                                        <td align='center'><?php echo $v['litdig_dc']; ?></td>
                                                                        <td align='center'><?php echo $v['litdig_dc']-4; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>3</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan individu dalam menyadari, mencontohkan, menyesuaikan diri, merasionalkan, mempertimbangkan, dan mengembangkan tata kelola etika digital (netiquette) dalam kehidupan sehari-hari."><b>Digital Ethic</b></abbr>
                                                                        </td>
                                                                        <td align='center'>4</td>
                                                                        <td align='center'><?php echo $v['litdig_de']; ?></td>
                                                                        <td align='center'><?php echo $v['litdig_de']-4; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>4</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan individu dalam mengenali, mempolakan, menerapkan, menganalisis, dan meningkatkan kesadaran keamanan digital dalam kehidupan sehari-hari."><b>Digital Safety</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['litdig_dsa']; ?></td>
                                                                        <td align='center'><?php echo $v['litdig_dsa']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>TOTAL</b></td>
                                                                        <td align='center'><b><?php echo $v['litdig_standar']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['litdig_total']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['litdig_total']-$v['litdig_standar']; ?></b></td>
                                                                </tr>
                                                                <tr class='success'>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>JPM (KATEGORI)</b></td>
                                                                        <td align='center' colspan='3'><b><span class='text text-success'><?php echo $v['litdig_jpm']." % (".$v['litdig_kategori'].")"; ?></b></span></td>
                                                                </tr>
							</table>
						     </div> <!-- End Coloum -->
						     <div class="col-lg-6" align='center'>
                                                        <div id="litdig_chart" style="height: 80%; width: 100%"></div>
                                                     </div> <!-- End Kolom Chart -->
						   </div> <!-- End Row -->
						</div> <!-- End Panel Body Literasi Digital -->
					  </div> <!-- End Panel Literasi Digital -->
					 </div> <!-- End Kolom Litdig -->
					</div> <!-- End Row Mansosku dan Litdig-->
	

					<div class="row"> <!-- Row EmSkill dan Potensi Permenpan -->
					 <div class="col-lg-7"> <!-- Kolom Emskill -->
                                          <div class="panel panel-warning">
                                                <!--<div class="panel-heading">Kompetensi Manajerial dan Sosial Kultural</div>-->
                                                <div class="panel-body">
                                                   <h5 class='modal-title text text-warning'>EMERGING SKILLS</h5>
                                                   <div class="row">
                                                     <div class="col-lg-6">
                                                        <table class='table table-condensed table-hover'>
                                                                <tr class='warning'>
                                                                        <th width='10'><center>#</center></th>
                                                                        <th align='80'><center>Aspek</center></th>
                                                                        <th width='300'><center>Standar</center></th>
                                                                        <th width='120'><center>Capaian</center></th>
                                                                        <th width='120'><center>GAP</center></th>
                                                                </tr>
                                                                <tr><td colspan='5'>KEMAMPUAN KOGNITIF</td></tr>
                                                                <tr>
                                                                        <td width='10'><center>1</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk menelaah dan memilah fakta dan informasi berdasarkan kekuatan dan kelemahannya untuk menyelesaikan permasalahan."><b>Analytical Thinking</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_at']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_at']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>2</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk menghubungkan/ menciptakan sesuatu/ide dari hal-hal yang sebelumnya tidak memiliki hubungan."><b>Problem Solving</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_ps']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_ps']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>3</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk menyelesaikan suatu permasalahan, dimulai dari mengenali permasalahan, menganalisis, dan menemukan solusi."><b>Creativity and Innovation</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_ps']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_ps']-3; ?></td>
                                                                </tr>
                                                                <tr><td colspan='5'>KEMAMPUAN MANAJERIAL</td></tr>
                                                                <tr>
                                                                        <td width='10'><center>4</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kesediaan untuk mengambil peran sebagai pemimpin dalam mengarahkan dan mengembangkan pihak lain untuk mencapai tujuan bagi kelompok maupun organisasi."><b>Leadership</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_ld']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_ld']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>5</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kecenderungan individu secara proaktif menemukenali kebutuhan dan melayani pihak lain untuk mencapai kepuasan pelanggan (internal maupun eksternal)."><b>Service Orientation</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_so']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_so']-3; ?></td>
                                                                </tr>
                                                                <tr><td colspan='5'>KEMAMPUAN PSIKOLOGIS - PENGELOLAAN DIRI</td></tr>
                                                                <tr>
                                                                        <td width='10'><center>6</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan individu untuk tetap tenang dalam situasi sulit dan penuh tantangan, sehingga dapat segera bangkit dan melakukan upaya terbaik guna mengatasi persoalan yang dihadapi."><b>Adaptability and Resilience</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_ar']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_ar']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>7</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kapasitas individu untuk mengenali dan mengelola perasaannya serta peka dan peduli terhadap kondisi orang lain, mudah berinteraksi dan bekerjasama dengan orang lain."><b>Emotional Intelligence</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_ei']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_ei']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>8</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Upaya aktif dan terus menerus dalam memahami berbagai informasi baru dan menggunakan strategi yang terbaik untuk meningkatkan kemampuan diri di pekerjaan."><b>Continuous Learning</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_cl']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_cl']-3; ?></td>
                                                                </tr>
                                                                <tr><td colspan='5'>KEMAMPUAN TEKNIS TEKNOLOGI INFORMASI</td></tr>
                                                                <tr>
                                                                        <td width='10'><center>9</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk mencari penyebab kesalahan operasi dan interaksi, serta memutuskan solusi dan apa yang harus dilakukan untuk mengatasinya."><b>Troubleshooting and User Experience</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_tue']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_tue']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>10</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk menulis program komputer untuk tujuan tertentu dan menyesuaikan peralatan dan teknologi untuk melayani kebutuhan pengguna."><b>Technology Design and Programming</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_tdp']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_tdp']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>11</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk menentukan alat teknologi yang sesuai untuk pekerjaan tertentu, menggunakan peralatan teknologi dan sistem, memantau peralatan teknologi saat berjalan, dan menganalisis kebutuhan teknologi."><b>Technology Use, Monitoring, and Control</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_tumc']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_tumc']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>12</center></td>
                                                                        <td width='80%'>
                                                                        <abbr title="Kemampuan untuk mempertimbangkan biaya dan manfaat relatif untuk menentukan tindakan yang akan diambil untuk memilih opsi yang paling tepat, menentukan bagaimana sistem harus bekerja dan bagaimana perubahan kondisi, operasi dan lingkungan akan mempengaruhi hasil, dan mengidentifikasi indikator kinerja sistem dan tindakan yang diperlukan untuk meningkatkan atau memperbaiki kinerja, sesuai dengan tujuan sistem."><b>System Analysis and Evaluation</b></abbr>
                                                                        </td>
                                                                        <td align='center'>3</td>
                                                                        <td align='center'><?php echo $v['emskil_sae']; ?></td>
                                                                        <td align='center'><?php echo $v['emskil_sae']-3; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>TOTAL</b></td>
                                                                        <td align='center'><b><?php echo $v['emskil_standar']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['emskil_total']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['emskil_total']-$v['emskil_standar']; ?></b></td>
                                                                </tr>
                                                                <tr class='warning'>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>JPM (KATEGORI)</b></td>
                                                                        <td align='center' colspan='3'><b><span class='text text-warning'><?php echo $v['emskil_jpm']." % (".$v['emskil_kategori'].")"; ?></b></span></td>
                                                                </tr>
                                                        </table>
                                                     </div> <!-- End Coloum -->
						     <div class="col-lg-6" align='center'>
                                                        <div id="emskil_chart" style="height: 80%; width: 100%"></div>
                                                     </div> <!-- End Kolom Chart -->	
                                                   </div> <!-- End Row -->
                                                </div> <!-- End Panel Body Emerging Skills -->
                                          </div> <!-- End Panel Emerging Skills -->
					 </div> <!-- End Kolom Emskill -->	
		
					 <div class="col-lg-5"> <!-- End Kolom Potensi Permenpan -->				 
                                          <div class="panel panel-danger">
                                                <div class="panel-body">
                                                   <h5 class='modal-title text text-warning'>PREDIKSI POTENSI BERDASARKAN PERMENPAN-RB NO. 03 TAHUN 2020</h5>
                                                        <table class='table table-condensed table-hover'>
                                                                <tr class='danger'>
                                                                        <th width='10'><center>#</center></th>
                                                                        <th align='80'><center>Aspek</center></th>
                                                                        <th align='80'><center>Standar</center></th>
                                                                        <th width='120'><center>Capaian</center></th>
                                                                        <th align='80'><center>GAP</center></th>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>1</center></td>
                                                                        <td width='80%'>Kemampuan Intelektual</td>
									<td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_ki']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>2</center></td>
                                                                        <td width='80%'>Kemampuan Berpikir Kritis dan Strategis</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_kbks']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>3</center></td>
                                                                        <td width='80%'>Kemampuan Menyelesaikan Permasalahan (Problem Solving</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_kmp']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>4</center></td>
                                                                        <td width='80%'>Motivasi dan Komitmen (Grit)</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_mk']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>5</center></td>
                                                                        <td width='80%'>Kesadaran Diri (Self Awareness)</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_kd']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>6</center></td>
                                                                        <td width='80%'>Kecerdasan Emosional (Emotional Quotient)</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_ke']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>7</center></td>
                                                                        <td width='80%'>Kemampuan Belajar Cepat dan Mengembangkan Diri (Growth Mindset)</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_kbcmd']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'><center>8</center></td>
                                                                        <td width='80%'>Kemampuan Interpersonal</td>
                                                                        <td align='center'></td>
                                                                        <td align='center'><?php echo $v['permenpan3-2020_kip']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>TOTAL</b></td>
                                                                        <td align='center'><b><?php echo $v['permenpan3-2020_standar']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['permenpan3-2020_total']; ?></b></td>
                                                                        <td align='center'><b><?php echo $v['permenpan3-2020_total']-$v['permenpan3-2020_standar']; ?></b></td>
                                                                </tr>
                                                                <tr class='danger'>
                                                                        <td width='10'></td>
                                                                        <td width='80%' align='center'><b>JPM</b></td>
                                                                        <td align='center' colspan='3'><b><span class='text text-danger'><?php echo $v['permenpan3-2020_jpm']." %"; ?></b></span></td>
                                                                </tr>
                                                        </table>
                                                </div> <!-- End Panel Body Potensi Permenpan -->
                                           </div> <!-- End Panel Emerging Skills -->
					  </div> <!-- End Kolom Prediksi Permenpan -->
					</div> <!-- End Row Prediksi Permenpan -->


				    <!-- </div> --><!-- End Scroll Up Down -->
                                </div> <!-- End Modal Body -->
                            </div>
                           </div>
                          </div>
                          <!-- End Modal Detail -->
                        </td>
			<td>
			  <button type='button' class='btn btn-default btn-outline btn-xs' data-toggle='modal' data-target='#dtlTalenta<?php echo $v['id']; ?>'>Peta<br/>Talenta</button>
			  <!-- Modal Talenta -->
                          <div id="dtlTalenta<?php echo $v['id']; ?>" class="modal fade" role="dialog">
                           <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                            <div class="modal-content">
                                <div class='modal-header'>
                                <?php
                                        echo "<h5 class='modal-title text text-primary'>PEMETAAN TALENTA</h5>";
                                        echo "<h5 class='modal-title text text-muted'>".$this->mpegawai->getnama($v['nip'])."</h5>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
				  <div class='row'>
				     <div class='col-md-6'> <!-- Kolom Kinerja -->
                          		<div class='well well-sm' style='font-size: 10px;'>
					  <?php
						//$kin2023 = $this->mpegawai->rwykinerjabkn_tahunbulan($nip, "2023", "13")->result_array();
					      $jmlkin2023 = $this->mpegawai->jml_rwykinerjabkn_tahunbulan($nip, "2023", "13");						
					      if ($jmlkin2023 != 0) {
						$kin2023 = $this->mpegawai->rwykinerjabkn_tahunbulan($nip, "2023", "13")->result_array();
						foreach($kin2023 as $k):
							$jabatan = $k['skp_jabatan'];
							$unor = $k['skp_unor_induk'];
							$atasan_nama = $k['pegawai_atasan_nama'];
							$atasan_jabatan = $k['pegawai_atasan_jabatan'];
							$atasan_unor = $k['pegawai_atasan_unor'];
							$hasil_kerja = $k['hasil_kerja'];	
							$perilaku_kerja = $k['perilaku_kerja'];
							$hasil_akhir = $k['hasil_akhir'];
						endforeach;
					      } else {
							$jabatan = '';
                                                        $unor = '';
                                                        $atasan_nama = '';
                                                        $atasan_jabatan = '';
                                                        $atasan_unor = '';
                                                        $hasil_kerja = 'DATA TIDAK DITEMUKAN';
                                                        $perilaku_kerja = 'DATA TIDAK DITEMUKAN';
                                                        $hasil_akhir = 'DATA TIDAK DITEMUKAN';
					      }
					  ?>
                                	  <span class='text text-primary'><b>KINERJA TAHUN 2023</b></span>
					    <div class='row'>
                                                <div class='col-md-3'>Jabatan</div>
                                                <div class='col-md-9'><?php echo strtoupper($jabatan); ?></div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-3'>Unit Kerja</div>
                                                <div class='col-md-9'><?php echo strtoupper($unor); ?></div>
                                            </div><br/>						
                                            <div class='row'>
                                                <div class='col-md-4'>Atasan Nama</div>
                                                <div class='col-md-8'><?php echo strtoupper($atasan_nama); ?></div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-4'>Atasan Jabatan</div>
                                                <div class='col-md-8'><?php echo strtoupper($atasan_jabatan); ?></div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-4'>Atasan Unit Kerja</div>
                                                <div class='col-md-8'><?php echo strtoupper($atasan_unor); ?></div>
                                            </div><BR/>
                                	    <div class='row text-primary'>
                                  		<div class='col-md-4'><b>HASIL KERJA</b></div>
                                  		<div class='col-md-6' align='left'><b><?php echo strtoupper($hasil_kerja); ?></b></div>
                                	    </div>
                                	    <div class='row'>
                                  		<div class='col-md-4'>PERILAKU KERJA</div>
                                  		<div class='col-md-6' align='left'><?php echo strtoupper($perilaku_kerja); ?></div>
                                	    </div>
                                	    <div class='row'>
                                  		<div class='col-md-4'><span class='text-primary'>PREDIKAT KINERJA</span></div>
                                  		<div class='col-md-6' align='left'><span class='text-primary'><?php echo strtoupper($hasil_akhir); ?></span></div>
                                	    </div>
                          		</div>	<!-- End Well Kinerja -->
				      </div> <!-- End Kolom Kinerja -->

				      <div class='col-md-6'> <!-- Kolom Potensial -->
                                        <div class='well well-sm' style='font-size: 11px;'>
					  <span class='text text-success'><b>POTENSIAL</b></span>
					  <div class='row'>
                                                <div class='col-md-3'>Unit Kerja</div>
                                                <div class='col-md-9'><?php echo strtoupper($v['unker']); ?></div>
                                          </div>
                                          <div class='row'>
                                                <div class='col-md-3'>Unker Induk</div>
                                                <div class='col-md-9'><?php echo strtoupper($v['unker_induk']); ?></div>
                                          </div><br/>
					  <div class='row'>
                                                <div class='col-md-4'>1. POTENSI</div>
                                                <div class='col-md-7' align='left'>
						   <ul>
							<li>TOTAL : <span class='text text-default pull-right'><?php echo $v['permenpan3-2020_total']; ?></span></li>
							<li>STANDAR : <span class='text text-default pull-right'><?php echo $v['permenpan3-2020_standar']; ?></span></li>
							<li><span class='text text-success pull-left'>JPM :</span><span class='text text-success pull-right'><?php echo $v['permenpan3-2020_jpm']." %"; ?></span></li>
						   </ul>							
						</div>
					   </div>
					   <div class='row'>	
						<div class='col-md-4'>2. KOMPETENSI</div>
                                                <div class='col-md-7' align='left'>
                                                   <ul>
                                                        <li>MANSOSKUL : <span class='text text-default pull-right'><?php echo $v['mansoskul_jpm']. "%"; ?></span></li>
                                                        <li>LITERASI DIGITAL : <span class='text text-default pull-right'><?php echo $v['litdig_jpm']. " %"; ?></span></li>
                                                        <li>EMERGING SKILL : <span class='text text-default pull-right'><?php echo $v['emskil_jpm']." %"; ?></span></li>
							<?php
							  $avg = ($v['mansoskul_jpm']+$v['litdig_jpm']+$v['emskil_jpm'])/3;
							?>
                                                        <li><span class='text text-success pull-left'>AVERAGE :</span><span class='text text-success pull-right'><?php echo  number_format($avg,2,",",".")." %"; ?></span></li>
                                                   </ul>
                                                </div>
                                           </div>	
                                           <div class='row text-success'>
                                                <div class='col-md-5'><b>NILAI POTENSIAL (AVG)</b></div>
                                                <div class='col-md-7' align='left'><b>
						<?php
							$avg_p = ($v['permenpan3-2020_jpm'] + $avg) / 2;
							echo number_format($avg_p,2,",",".");
						?>			
                                                </b></div>
                                           </div>
                                           <div class='row text-success'>
                                                <div class='col-md-5'><b>KATEGORI</b></div>
                                                <div class='col-md-7' align='left'><b>
                                                <?php
							if ($avg_p >= 90) $kat_p = "TINGGI";
							else if ($avg_p >= 78 AND $avg_p < 90) $kat_p = "MENENGAH";
							else if ($avg_p < 78) $kat_p = "RENDAH";
                                                        echo $kat_p;
                                                ?>
                                                </b></div>
                                           </div>
				        </div> <!-- End Well Potensial -->
                                      </div> <!-- End Kolom Potensial -->						      	
				   </div> <!-- End Row -->
			
				   <?php
					if ($hasil_kerja == 'diatas' AND $kat_p == 'TINGGI') { 
					  $kotak9 = 'label-success';
					  $rekom = "1.Dipromosikan dan dipertahankan.<br/>2. Masuk kelompok rencana suksesi Instansi/Nasional.<br/>3. Penghargaan.";
					} else if ($hasil_kerja == 'diatas' AND $kat_p == 'MENENGAH') {
					  $kotak7 = 'label-success';
					  $rekom = "1. Dipertahankan.<br/>2. Masuk kelompok rencana suksesi Instansi/Nasional.<br/>3. Rotasi/Pengayaan Jabatan.<br/>4. Pengembangan kompetensi.<br/>5. Tugas Belajar.";
					} else if ($hasil_kerja == 'diatas' AND $kat_p == 'RENDAH') {
					  $kotak4 = 'label-info';
					  $rekom = "1. Rotasi.<br/>2. Pengembangan kompetensi.";
					} else if ($hasil_kerja == 'sesuai' AND $kat_p == 'TINGGI') {
					  $kotak8 = 'label-success';
					  $rekom = "1. Dipertahankan.<br/>2. Masuk kelompok rencana suksesi Instansi/Nasional.<br/>3. Rotasi/Perluasan Jabatan.<br/>4. Bimbingan Kinerja.";
					} else if ($hasil_kerja == 'sesuai' AND $kat_p == 'MENENGAH') {
					  $kotak5 = 'label-info';
					  $rekom = "1. Penempatan yang sesuai.<br/>2. Bimbingan kinerja<br/>3. Pengembangan kompetensi.";
					} else if ($hasil_kerja == 'sesuai' AND $kat_p == 'RENDAH') {
					  $kotak2 = 'label-warning';
					  $rekom = "1. Bimbingan kinerja.<br/>2. Pengembangan Kompetensi.<br/>3. Penempatan yang sesuai.";
					} else if ($hasil_kerja == 'dibawah' AND $kat_p == 'TINGGI') {
					  $kotak6 = 'label-info';
					  $rekom = "1. Penempatan yang sesuai.<br/>2. Bimbingan kinerja<br/>3. Konseling Kinerja.";
					} else if ($hasil_kerja == 'dibawah' AND $kat_p == 'MENENGAH') {
					  $kotak3 = 'label-warning';
					  $rekom = "1. Bimbingan kinerja.<br/>2. Konseling kinerja<br/>3. Pengembangan Kompetensi.<br/>4. Penempatan yang sesuai.";
					} else if ($hasil_kerja == 'dibawah' AND $kat_p == 'RENDAH') {
					  $kotak1 = 'label-danger';
					  $rekom = "Diproses sesuai ketentuan yang berlaku.";
					} else {
					  $kotak1 = '';
					  $rekom = "DATA TIDAK LENGKAP";	
					}
				   ?>		

				   <div class='row'> <!-- Row Kotak 9 Talenta -->
					<div class='col-md-12 col-xs-12'> <!-- Kolom Kotak Talenta -->
                                          <div class='well' style='font-size: 12px;'>
					    <div class='row'> <!-- Row 1 -->
					      <div class='col-md-1 col-xs-1' style='text-orientation: upright; writing-mode: vertical-lr; letter-spacing: 3px;'><b class='text text-primary'><center>KINERJA</center></b></div>
					      <div class='col-md-10 col-xs-10'>	
						<div class='row'>
							<div class='col-md-2' style='padding-top:3%;' align='right'>DIATAS</div>
							<div class='col-md-3 col-xs-3 <?php echo $kotak4; ?>' style='margin: 2px; border: double;'><center>4.<br/>Kinerja diatas ekspektasi dan potensial rendah.</center></div>
							<div class='col-md-3 col-xs-4 <?php echo $kotak7; ?>' style='margin: 2px; border: double;'><center>7.<br/>Kinerja diatas ekspektasi dan potensial menengah.</center></div>
                                                        <div class='col-md-3 col-xs-4 <?php echo $kotak9; ?>' style='margin: 2px; border: double;'><center>9.<br/>Kinerja diatas ekspektasi dan potensial tinggi.</center></div>
						</div>
                                                <div class='row'>
							<div class='col-md-2' style='padding-top:3%' align='right'>SESUAI</div>
                                                        <div class='col-md-3 col-xs-3 <?php echo $kotak2; ?>' style='margin: 2px; border: double;'><center>2.<br/>Kinerja sesuai ekspektasi dan potensial rendah.</center></div>
                                                        <div class='col-md-3 col-xs-4 <?php echo $kotak5; ?>' style='margin: 2px; border: double;'><center>5.<br/>Kinerja sesuai ekspektasi dan potensial menengah.</center></div>
                                                        <div class='col-md-3 col-xs-4 <?php echo $kotak8; ?>' style='margin: 2px; border: double;'><center>8.<br/>Kinerja sesuai ekspektasi dan potensial tinggi.</center></div>
                                                </div>
                                                <div class='row'>
							<div class='col-md-2' style='padding-top:3%' align='right'>DIBAWAH</div>
                                                        <div class='col-md-3 col-xs-3 <?php echo $kotak1; ?>' style='margin: 2px; border: double;'><center>1.<br/>Kinerja dibawah skspektasi dan potensial rendah.</center></div>
                                                        <div class='col-md-3 col-xs-4 <?php echo $kotak3; ?>' style='margin: 2px; border: double;'><center>3.<br/>Kinerja dibawah ekspektasi dan potensial menengah.</center></div>
                                                        <div class='col-md-3 col-xs-4 <?php echo $kotak6; ?>' style='margin: 2px; border: double;'><center>6.<br/>Kinerja dibawah ekspektasi dan potensial tinggi.</center></div>
                                                </div>
					      </div>
					    </div> <!-- End Row 1 -->
                                            <div class='row'> <!-- Row 2 -->
                                              <div class='col-md-2 col-xs-2'></div>
                                              <div class='col-md-3 col-xs-2' align='center'>RENDAH</div>
					      <div class='col-md-3 col-xs-2' align='center'>MENENGAH</div>
					      <div class='col-md-3 col-xs-2' align='center'>TINGGI</div>
                                            </div> <!-- End Row 2 --><br/>
					    <div class='row'> <!-- Row 3 -->
                                              <div class='col-md-2 col-xs-2'></div>
                                              <div class='col-md-10 col-xs-10' align='center' style='letter-spacing: 3px;'><b class='text text-success'>POTENSIAL</b></div>
					    </div> <!-- End Row 3 --><br/>	
					    <div class='row'> <!-- Row 4 -->
                                              <div class='col-md-12 col-xs-12'><span class='text text-info'><b>REKOMENDASI</b></span><br/>
                                                <?php echo $rekom;?>
                                              </div>
					    </div> <!-- End Row 4 -->
					  </div> <!-- End Well Kotal 9 -->
					</div> <!-- End Kolom Kotak Telanta -->
				   </div> <!-- End Row Kotak 9 Talenta -->
                                </div> <!-- End Modal Body -->
                            </div>
                           </div>
                          </div>
                          <!-- End Modal Talenta -->

			</td>                        
		     <?php endif; ?>
		  </tr>
                  <?php
                    $no++;
                    endforeach;
                  ?>
                </table>
            </td>
          </tr>
        </table>        
      </div>
    </div>
  </div>  
</center>

<!-- untuk pemanggilan Pie Chart -->
<script type="text/javascript"> 
Highcharts.chart('mansoskul_chart', { 
    chart: {
        polar: true,
        type: 'line'
    	},

    accessibility: {
        description: "Kompetensi Manajerial dan Sosial Kultural"
	},

    title: {
        text: '',
        x: 0
    },
    pane: {
        size: '100%'
    },
    xAxis: {
        categories: ['Integritas', 'Kerjasama', 'Komunikasi', 'Orientasi Hasil', 'Pelayanan Publik', 'Pengembangan Diri dan Orang Lain', 'Mengelola Perubahan', 'Pengambilan Keputusan', 'Perekat Bangsa'],
        tickmarkPlacement: 'on',
        lineWidth: 0
    },
    yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
    },
    tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.2f}</b><br/>'
    },
    legend: {
        align: 'rigth',
        verticalAlign: 'middle',
        layout: 'vertical'
    },
	
    <?php
	$pegrwypenkom = $this->mpegawai->rwypenkom($nip)->result_array();
	foreach($pegrwypenkom as $v):
		$itg = $v['mansoskul_itg'];
		$kom = $v['mansoskul_kom'];
		$kjs = $v['mansoskul_kjs'];
                $oph = $v['mansoskul_oph'];
                $pep = $v['mansoskul_pep'];
                $pdo = $v['mansoskul_pdo'];
                $mpu = $v['mansoskul_mpu'];
                $pkp = $v['mansoskul_pkp'];
                $prb = $v['mansoskul_prb'];		
	endforeach;
    ?>
    series: [{
        name: 'Standar',
        data: [3, 3, 3, 3, 3, 3, 3, 3, 3,],
        pointPlacement: 'off'
    }, {
        name: 'Total Capaian',
	data :
	<?php
            echo "[".$itg.",".$kjs.",".$kom.",".$oph.",".$pep.",".$pdo.",".$mpu.",".$pkp.",".$prb."],";
        ?>
        //data: [50000, 39000, 42000, 31000, 26000, 14000, 43000, 19000, 60000,],
        pointPlacement: 'on'
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    align: 'left',
                    verticalAlign: 'bottom',
                    layout: 'horizontal'
                },
                pane: {
                    size: '60%'
                }
            }
        }]
    }

});

Highcharts.chart('litdig_chart', {
    chart: {
        polar: true,
        type: 'line'
        },

    accessibility: {
        description: "Literasi Digital"
        },

    title: {
        text: '',
        x: 0
    },
    pane: {
        size: '80%'
    },
    xAxis: {
        categories: ['Digital Skills', 'Digital Culture', 'Digital Ethic', 'Digital Safety'],
        tickmarkPlacement: 'on',
        lineWidth: 0
    },
    yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
    },
    tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.2f}</b><br/>'
    },
    <?php
        $pegrwypenkom = $this->mpegawai->rwypenkom($nip)->result_array();
        foreach($pegrwypenkom as $v):
                $ld_dsk = $v['litdig_dsk'];
                $ld_dc = $v['litdig_dc'];
                $ld_de = $v['litdig_de'];
                $ld_dsa = $v['litdig_dsa'];
        endforeach;
    ?>
    series: [{
        name: 'Standar',
        data: [3, 4, 4, 3,],
        pointPlacement: 'off'
    }, {
        name: 'Total Capaian',
        data :
        <?php
            echo "[".$ld_dsk.",".$ld_dc.",".$ld_de.",".$ld_dsa."],";
        ?>
        //data: [50000, 39000, 42000, 31000, 26000, 14000, 43000, 19000, 60000,],
        pointPlacement: 'on'
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 0
            },
            chartOptions: {
                legend: {
                    align: 'left',
                    verticalAlign: 'bottom',
                    layout: 'horizontal'
                },
                pane: {
                    size: '50%'
                }
            }
        }]
    }

});

Highcharts.chart('emskil_chart', {
    chart: {
        polar: true,
        type: 'line'
        },

    accessibility: {
        description: "Literasi Digital"
        },

    title: {
        text: '',
        x: 0
    },
    pane: {
        size: '70%'
    },
    xAxis: {
        categories: ['Analytical Thinking', 'Problem Solving', 'Creativity and Innovation', 'Leadership', 'Service Orientation', 
		'Adaptability and Resilience', 'Emotional Intelligence', 'Continuous Learning', 'Troubleshooting and User Experience', 
		'Technology Design and Programming', 'Technology Use, Monitoring, and Control', 'System Analysis and Evaluation'],
        tickmarkPlacement: 'on',
        lineWidth: 0
    },
    yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
    },
    tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.2f}</b><br/>'
    },
    <?php
        $pegrwypenkom = $this->mpegawai->rwypenkom($nip)->result_array();
        foreach($pegrwypenkom as $v):
                $es_ar = $v['emskil_ar'];
                $es_cl = $v['emskil_cl'];
                $es_ei = $v['emskil_ei'];
                $es_ld = $v['emskil_ld'];
                $es_so = $v['emskil_so'];
                $es_at = $v['emskil_at'];
                $es_cr = $v['emskil_cr'];
                $es_ps = $v['emskil_ps'];
                $es_tue = $v['emskil_tue'];
                $es_tdp = $v['emskil_tdp'];
                $es_tumc = $v['emskil_tumc'];
                $es_sae = $v['emskil_sae'];
        endforeach;
    ?>
    series: [{
        name: 'Standar',
        data: [3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3,],
        pointPlacement: 'off'
    }, {
        name: 'Total Capaian',
        data :
        <?php
            echo "[".$es_at.",".$es_ps.",".$es_cr.",".$es_ld.",".$es_so.",".$es_ar.",".$es_ei.",".$es_cl.",".$es_tue.",".$es_tdp.",".$es_tumc.",".$es_sae."],";
        ?>
        pointPlacement: 'on'
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 0
            },
            chartOptions: {
                legend: {
                    align: 'left',
                    verticalAlign: 'bottom',
                    layout: 'horizontal'
                }
            }
        }]
    }

});

</script>
<!-- akhir mansoskul chart -->
