<!-- Default panel contents -->
  <div class="panel panel-info" style="padding:3px;overflow:auto;width:100%;height:650px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>REKAPUTILASI DAN STATISTIKA INDEKS PROFESIONALITAS ASN</b>
        </div>

  <table class='table'>
    <tr>
	<?php
        if ($this->session->userdata('level') == "ADMIN") {
        ?>
      		<td align='right'>
        	<?php
          	//$thnini = date("Y");
          	$thnini = 2020;
        	?>
        	<form method="POST" action="../pip/cetakrekaptahunan" target='_blank'>
          		<input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thnini; ?>'>
          		<button type="submit" class="btn btn-success btn-sm">
            			<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Rekap IP ASN 2020
          		</button>
        	</form>
      		</td>
	<?php
	}
        ?>
      <td align='right' width='30'>
        <form method="POST" action="../pip/tampilunkernom">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 
  
  <center style="padding:10px;width:100%;">

  <div class="row"> <!-- Baris Pertama -->
    <div class="col-lg-4"> <!-- Kolom Pertama lebar 4 -->
      <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                            <?php
                              $jmlpns = $this->mgraph->jmlpns();
                              //$thnini = date("Y");
			      $thnini = '2020';	
                              $jmldata = $this->mpip->getjmlpertahun($thnini);
                              echo $jmldata;
                            ?>                          
                            </div>
                            <div><b><?php echo "Jumlah Data PIP ".$thnini; ?></b></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                  <?php
                    $persen = round(($jmldata/$jmlpns)*100, 2);
                  ?>
                  <span class="pull-left"><b><?php echo $persen." % dari ".$jmlpns." PNS"; ?></b></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-square-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                            <?php
                                $thnini = 2020;
                                $totalpip = $this->mpip->totalpip_thn($thnini);
                                $totaldatapip = $this->mpip->getjmlpertahun($thnini);
                                $skorpip = round(($totalpip/$totaldatapip),2);
                                echo $skorpip;
                            ?>
                            </div>
                            <div><b><?php echo "IP ASN TAHUN 2020"?></b></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                  <?php
                    $kategori = $this->mpip->getkategoriip($skorpip);
                  ?>
                  <span class="pull-left"><b><?php echo "Kriteria : ".$kategori; ?></b></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>      
      </div>

      <div class="row">
         <div class="col-lg-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-graduation-cap fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                            <?php
                              $thnini = 2020;
                              $totalkua = $this->mpip->totalkua_thn($thnini);
                              $totaldatapip = $this->mpip->getjmlpertahun($thnini);
                              $skorkua = round(($totalkua/$totaldatapip),2);
                              $rilkua = round(($totalkua/$totaldatapip)*(100/25),2);
                              echo $skorkua;
                            ?>                          
                            </div>
                            <div><b>KUALIFIKASI (25%)</b></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                  <?php
                    $katkua = $this->mpip->getkategoriip($rilkua);
                  ?>
                  <span class="pull-left"><b><?php echo $rilkua." - ".$katkua; ?></b></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
         <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-trophy fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                            <?php
                              $thnini = 2020;
                              $totalkom = $this->mpip->totalkom_thn($thnini);
                              $totaldatapip = $this->mpip->getjmlpertahun($thnini);
                              $skorkom = round(($totalkom/$totaldatapip),2);
                              $rilkom = round(($totalkom/$totaldatapip)*(100/40),2);
                              echo $skorkom;
                            ?>                          
                            </div>
                            <div><b>KOMPETENSI (40%)</b></div>
                        </div>
                    </div>
                </div>                
                <div class="panel-footer">
                  <?php
                    $katkom = $this->mpip->getkategoriip($rilkom);
                  ?>
                  <span class="pull-left"><b><?php echo $rilkom." - ".$katkom; ?></b></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
         <div class="col-lg-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bar-chart-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                            <?php
                              $thnini = 2020;
                              $totalkin = $this->mpip->totalkin_thn($thnini);
                              $totaldatapip = $this->mpip->getjmlpertahun($thnini);
                              $skorkin = round(($totalkin/$totaldatapip),2);
                              $rilkin = round(($totalkin/$totaldatapip)*(100/30),2);
                              echo $skorkin;
                            ?>                          
                            </div>
                            <div><b>KINERJA (30%)</b></div>
                        </div>
                    </div>
                </div>
                 <div class="panel-footer">
                  <?php
                    $katkin = $this->mpip->getkategoriip($rilkin);
                  ?>
                  <span class="pull-left"><b><?php echo $rilkin." - ".$katkin; ?></b></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
         <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-thumbs-up fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                            <?php
                              $thnini = 2020;
                              $totaldis = $this->mpip->totaldis_thn($thnini);
                              $totaldatapip = $this->mpip->getjmlpertahun($thnini);
                              $skordis = round(($totaldis/$totaldatapip),2);
                              $rildis = round(($totaldis/$totaldatapip)*(100/5),2);
                              echo $skordis;
                            ?>                            
                            </div>
                            <div><b>DISIPLIN (5%)</b></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                  <?php
                    $kattotaldis = $this->mpip->getkategoriip($rildis);
                  ?>
                  <span class="pull-left"><b><?php echo $rilkin." - ".$kattotaldis; ?></b></span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
      </div>
    </div> <!-- End Kolom Pertama lebar 4 -->


    <div class="col-lg-8"> <!-- Kolom Kedua lebar 8 -->
        <div style="height: 100%; width: 100%;">
        <ul class="nav nav-tabs">
          <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
          <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
          <li class='active'><a href='#rekap' data-toggle='tab'><b>REKAPITULASI</b></a></li>
          <li><a href='#jenkel' data-toggle='tab'>PER JENIS KELAMIN</a></li>
          <li><a href='#jab' data-toggle='tab'>PER JABATAN</a></li>
          <li><a href="#tingpen" data-toggle="tab">PER TINGKAT PENDIDIKAN</a></li>
        </ul>      

        <div class="tab-content">
          <div class="tab-pane face in active" id="rekap">
            <?php
            $tahun = 2020;
            //$sopd = $this->munker->unker()->result_array();
            $sopd = $this->munker->instansi()->result_array();	
            $total = $this->mpip->getjmlpertahun($tahun);


            echo "<div style='padding:0px;width:99%;border:1px solid white; padding-right:20px' >";
            echo "<br />
              <table class='table table-bordered'>
              <tr class='danger'>
                <td align='center' width='30'><b>No.</b></td>
                <td align='center' width='600'><b>Nama Unit Kerja<br/><code>SKOR INDEKS PROFESIONALITAS</code></b></td>
                <td align='center' width='100'><b>Kualifikasi<br/>(Maks. 25)</b></td>
                <td align='center' width='100'><b>Kompetensi<br/>(Maks. 40)</b></td>
                <td align='center' width='100'><b>Kinerja<br/>(Maks. 30)</b></td>
                <td align='center' width='100'><b>Disiplin<br/>(Maks. 5)</b></td>
              </tr>";
            echo "</table>";
            echo "</div>";      
            
            echo "<div style='padding:0px;overflow:auto;width:99%;height:430px;border:1px solid white' >";
            echo "<table class='table table-bordered table-hover'>";
                $no = 1;
                foreach($sopd as $v):          

                  $jml = $this->mpip->totalpip_insthn($v['id_instansi'], $tahun);
                  if ($jml != 0) {
                    $jmlpeg = $this->mpip->jmldatapip_insthn($v['id_instansi'], $tahun);
                    $ip_unker = round($jml/$jmlpeg, 2);
                  } else {
                    $jmlpeg = 0;
                    $ip_unker = 0;
                  }

                  $warnaip = $this->mpip->warnabar($ip_unker);

                  echo "<tr>";   
                  echo "<td align='center' width='30'>$no</td>";
                  echo '<td width=600>',$v['nama_instansi'],'<br/>';
                  $totalpeg = $this->munker->getjmlpeg_instansi($v['id_instansi']);
                  $jmlpegpip = $this->mpip->jmldatapip_insthn($v['id_instansi'], $tahun);                  
                  if ($totalpeg != 0) {
                    $persenpegpip = round(($jmlpegpip/$totalpeg)*100);
                  }
                  echo "<small>
                        Jumlah PNS : ".$totalpeg." | Jumlah Data PIP : ".$jmlpegpip." (".$persenpegpip." %)
                        </small><br/>";        
                  ?>
                      <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $ip_unker; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$ip_unker.'%; color : black'; ?>;">
                        <?php echo "<code>".$ip_unker." [".$this->mpip->getkategoriip($ip_unker)."]</code>"; ?>
                      </div>
                  <?php
                  
                  echo "</td>";

                  $totalkua = $this->mpip->totalkua_insthn($v['id_instansi'], $tahun);
                  if ($totalkua != 0) {
                    $skorkua = round($totalkua/$jmlpegpip, 2);
                    $katkua = $this->mpip->getkategoriip($skorkua*(100/25));
                  } else {
                    $skorkua = 0;
                  }
                  echo "<td width='100' align='center'>".$skorkua."<br/><small><code>".$katkua."</code></small></td>";

                  $totalkom = $this->mpip->totalkom_insthn($v['id_instansi'], $tahun);
                  if ($totalkom != 0) {
                    $skorkom = round($totalkom/$jmlpegpip, 2);
                    $katkom = $this->mpip->getkategoriip($skorkom*(100/40));
                  } else {
                    $skorkom = 0;
                  }
                  echo "<td width='100' align='center'>".$skorkom."<br/><small><code>".$katkom."</code></small></td>";

                  $totalkin = $this->mpip->totalkin_insthn($v['id_instansi'], $tahun);
                  if ($totalkin != 0) {
                    $skorkin = round($totalkin/$jmlpegpip, 2);
                    $katkin = $this->mpip->getkategoriip($skorkin*(100/30));
                  } else {
                    $skorkin = 0;
                  }
                  echo "<td width='100' align='center'>".$skorkin."<br/><small><code>".$katkin."</code></small></td>";

                  $totaldis = $this->mpip->totaldis_insthn($v['id_instansi'], $tahun);
                  if ($totaldis != 0) {
                    $skordis = round($totaldis/$jmlpegpip, 2);
                    $katdis = $this->mpip->getkategoriip($skordis*(100/5));
                  } else {
                    $skordis = 0;
                  }
                  echo "<td width='100' align='center'>".$skordis."<br/><small><code>".$katdis."</code></small></td>";
                  
                  echo "</tr>";
                  $no++;
                endforeach;
            echo "</table>";
            echo "</div>";
            ?>
          </div>

          <div class="tab-pane face" id="jenkel">
            <?php
              $tahun = 2020;
              // rata2 PIP
              $totalpip_laki = $this->mpip->totalpip_jenkelthn("LAKI-LAKI", $tahun);
              $jml_laki = $this->mpip->jmldatapip_jenkelthn("LAKI-LAKI", $tahun);
              $skorpip_laki = round($totalpip_laki/$jml_laki, 2);
              $katpip_laki = $this->mpip->getkategoriip($skorpip_laki);
              
              $totalpip_bini = $this->mpip->totalpip_jenkelthn("PEREMPUAN", $tahun);
              $jml_bini = $this->mpip->jmldatapip_jenkelthn("PEREMPUAN", $tahun);
              $skorpip_bini = round($totalpip_bini/$jml_bini, 2);
              $katpip_bini = $this->mpip->getkategoriip($skorpip_bini);
              
              // Kualifikasi
              $totalkua_laki = $this->mpip->totalkua_jenkelthn("LAKI-LAKI", $tahun);
              $skorkua_laki = round($totalkua_laki/$jml_laki, 2);
              
              $totalkua_bini = $this->mpip->totalkua_jenkelthn("PEREMPUAN", $tahun);
              $skorkua_bini = round($totalkua_bini/$jml_bini, 2);

              // Kompetensi
              $totalkom_laki = $this->mpip->totalkom_jenkelthn("LAKI-LAKI", $tahun);
              $skorkom_laki = round($totalkom_laki/$jml_laki, 2);
              
              $totalkom_bini = $this->mpip->totalkom_jenkelthn("PEREMPUAN", $tahun);
              $skorkom_bini = round($totalkom_bini/$jml_bini, 2);

              // Kinerja
              $totalkin_laki = $this->mpip->totalkin_jenkelthn("LAKI-LAKI", $tahun);
              $skorkin_laki = round($totalkin_laki/$jml_laki, 2);
              
              $totalkin_bini = $this->mpip->totalkin_jenkelthn("PEREMPUAN", $tahun);
              $skorkin_bini = round($totalkin_bini/$jml_bini, 2);

              // Disiplin
              $totaldis_laki = $this->mpip->totaldis_jenkelthn("LAKI-LAKI", $tahun);
              $skordis_laki = round($totaldis_laki/$jml_laki, 2);
              
              $totaldis_bini = $this->mpip->totaldis_jenkelthn("PEREMPUAN", $tahun);
              $skordis_bini = round($totaldis_bini/$jml_bini, 2);

              echo "<div style='padding:0px;width:99%;border:1px solid white; padding-right:20px' >";
              echo "<br />
                <table class='table table-bordered'>
                <tr class='danger'>
                  <td align='center' width='600'><b>Jenis Kelamin<br/><code>SKOR INDEKS PROFESIONALISME</code></b></td>
                  <td align='center' width='100'><b>Kualifikasi<br/>(Maks. 25)</b></td>
                  <td align='center' width='100'><b>Kompetensi<br/>(Maks. 40)</b></td>
                  <td align='center' width='100'><b>Kinerja<br/>(Maks. 30)</b></td>
                  <td align='center' width='100'><b>Disiplin<br/>(Maks. 5)</b></td>
                </tr>";
              //unt Laki Laki
              echo "<tr>";
              echo "<td>LAKI-LAKI<br/>
                    <small>Jumlah Data : ".$jml_laki." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_laki);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_laki; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_laki.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_laki." [".$katpip_laki."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_laki."</td>";
              echo "<td align='center'>".$skorkom_laki."</td>";
              echo "<td align='center'>".$skorkin_laki."</td>";
              echo "<td align='center'>".$skordis_laki."</td>";
              echo "</tr>";

              //unt Bibini
              echo "<tr>";
              echo "<td>PEREMPUAN<br/>
                    <small>Jumlah Data : ".$jml_bini." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_bini);
              ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_bini; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_bini.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_bini." [".$katpip_bini."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_bini."</td>";
              echo "<td align='center'>".$skorkom_bini."</td>";
              echo "<td align='center'>".$skorkin_bini."</td>";
              echo "<td align='center'>".$skordis_bini."</td>";
              echo "</tr>";

              echo "</table>";
              echo "</div>";  
            ?>
          </div>

          <div class="tab-pane face" id="jab">
            <?php
              $tahun = 2020;
              // rata2 PIP
              $totalpip_jpt = $this->mpip->totalpip_jenjabthn("JPT-PRATAMA", $tahun);
              $jml_jpt = $this->mpip->jmldatapip_jenjabthn("JPT-PRATAMA", $tahun);
              $skorpip_jpt = round($totalpip_jpt/$jml_jpt, 2);
              $katpip_jpt = $this->mpip->getkategoriip($skorpip_jpt);
              
              $totalpip_adm = $this->mpip->totalpip_jenjabthn("ADMINISTRASI-ADMINISTRATOR", $tahun);
              $jml_adm = $this->mpip->jmldatapip_jenjabthn("ADMINISTRASI-ADMINISTRATOR", $tahun);
              $skorpip_adm = round($totalpip_adm/$jml_adm, 2);
              $katpip_adm = $this->mpip->getkategoriip($skorpip_adm);

              $totalpip_pengawas = $this->mpip->totalpip_jenjabthn("ADMINISTRASI-PENGAWAS", $tahun);
              $jml_pengawas = $this->mpip->jmldatapip_jenjabthn("ADMINISTRASI-PENGAWAS", $tahun);
              $skorpip_pengawas = round($totalpip_pengawas/$jml_pengawas, 2);
              $katpip_pengawas = $this->mpip->getkategoriip($skorpip_pengawas);
              
              $totalpip_fung = $this->mpip->totalpip_jenjabthn("FUNGSIONAL", $tahun);
              $jml_fung = $this->mpip->jmldatapip_jenjabthn("FUNGSIONAL", $tahun);
              $skorpip_fung = round($totalpip_fung/$jml_fung, 2);
              $katpip_fung = $this->mpip->getkategoriip($skorpip_fung);
              
              $totalpip_staf = $this->mpip->totalpip_jenjabthn("PELAKSANA", $tahun);
              $jml_staf = $this->mpip->jmldatapip_jenjabthn("PELAKSANA", $tahun);
              $skorpip_staf = round($totalpip_staf/$jml_staf, 2);
              $katpip_staf = $this->mpip->getkategoriip($skorpip_staf);
              
              // Kualifikasi
              $totalkua_jpt = $this->mpip->totalkua_jenjabthn("JPT-PRATAMA", $tahun);
              $skorkua_jpt = round($totalkua_jpt/$jml_jpt, 2);
              
              $totalkua_adm = $this->mpip->totalkua_jenjabthn("ADMINISTRASI-ADMINISTRATOR", $tahun);
              $skorkua_adm = round($totalkua_adm/$jml_adm, 2);
             
              $totalkua_pengawas = $this->mpip->totalkua_jenjabthn("ADMINISTRASI-PENGAWAS", $tahun);
              $skorkua_pengawas = round($totalkua_pengawas/$jml_pengawas, 2);

              $totalkua_fung = $this->mpip->totalkua_jenjabthn("FUNGSIONAL", $tahun);
              $skorkua_fung = round($totalkua_fung/$jml_fung, 2);

              $totalkua_staf = $this->mpip->totalkua_jenjabthn("PELAKSANA", $tahun);
              $skorkua_staf = round($totalkua_staf/$jml_staf, 2);             

              // Kompetensi
              $totalkom_jpt = $this->mpip->totalkom_jenjabthn("JPT-PRATAMA", $tahun);
              $skorkom_jpt = round($totalkom_jpt/$jml_jpt, 2);
              
              $totalkom_adm = $this->mpip->totalkom_jenjabthn("ADMINISTRASI-ADMINISTRATOR", $tahun);
              $skorkom_adm = round($totalkom_adm/$jml_adm, 2);
             
              $totalkom_pengawas = $this->mpip->totalkom_jenjabthn("ADMINISTRASI-PENGAWAS", $tahun);
              $skorkom_pengawas = round($totalkom_pengawas/$jml_pengawas, 2);

              $totalkom_fung = $this->mpip->totalkom_jenjabthn("FUNGSIONAL", $tahun);
              $skorkom_fung = round($totalkom_fung/$jml_fung, 2);

              $totalkom_staf = $this->mpip->totalkom_jenjabthn("PELAKSANA", $tahun);
              $skorkom_staf = round($totalkom_staf/$jml_staf, 2); 

              // Kinerja
              $totalkin_jpt = $this->mpip->totalkin_jenjabthn("JPT-PRATAMA", $tahun);
              $skorkin_jpt = round($totalkin_jpt/$jml_jpt, 2);
              
              $totalkin_adm = $this->mpip->totalkin_jenjabthn("ADMINISTRASI-ADMINISTRATOR", $tahun);
              $skorkin_adm = round($totalkin_adm/$jml_adm, 2);
             
              $totalkin_pengawas = $this->mpip->totalkin_jenjabthn("ADMINISTRASI-PENGAWAS", $tahun);
              $skorkin_pengawas = round($totalkin_pengawas/$jml_pengawas, 2);

              $totalkin_fung = $this->mpip->totalkin_jenjabthn("FUNGSIONAL", $tahun);
              $skorkin_fung = round($totalkin_fung/$jml_fung, 2);

              $totalkin_staf = $this->mpip->totalkin_jenjabthn("PELAKSANA", $tahun);
              $skorkin_staf = round($totalkin_staf/$jml_staf, 2);
              

              // Disiplin
              $totaldis_jpt = $this->mpip->totaldis_jenjabthn("JPT-PRATAMA", $tahun);
              $skordis_jpt = round($totaldis_jpt/$jml_jpt, 2);
              
              $totaldis_adm = $this->mpip->totaldis_jenjabthn("ADMINISTRASI-ADMINISTRATOR", $tahun);
              $skordis_adm = round($totaldis_adm/$jml_adm, 2);
             
              $totaldis_pengawas = $this->mpip->totaldis_jenjabthn("ADMINISTRASI-PENGAWAS", $tahun);
              $skordis_pengawas = round($totaldis_pengawas/$jml_pengawas, 2);

              $totaldis_fung = $this->mpip->totaldis_jenjabthn("FUNGSIONAL", $tahun);
              $skordis_fung = round($totaldis_fung/$jml_fung, 2);

              $totaldis_staf = $this->mpip->totaldis_jenjabthn("PELAKSANA", $tahun);
              $skordis_staf = round($totaldis_staf/$jml_staf, 2);
              
              echo "<div style='padding:0px;width:99%;border:1px solid white; padding-right:20px' >";
              echo "<br />
                <table class='table table-bordered'>
                <tr class='danger'>
                  <td align='center' width='600'><b>Jenis Jabatan<br/><code>SKOR INDEKS PROFESIONALISME</code></b></td>
                  <td align='center' width='100'><b>Kualifikasi<br/>(Maks. 25)</b></td>
                  <td align='center' width='100'><b>Kompetensi<br/>(Maks. 40)</b></td>
                  <td align='center' width='100'><b>Kinerja<br/>(Maks. 30)</b></td>
                  <td align='center' width='100'><b>Disiplin<br/>(Maks. 5)</b></td>                  
                </tr>";

              //unt Jpt
              echo "<tr>";
              echo "<td>JPT-PRATAMA<br/>
                    <small>Jumlah Data : ".$jml_jpt." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_jpt);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_jpt; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_jpt.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_jpt." [".$katpip_jpt."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_jpt."</td>";
              echo "<td align='center'>".$skorkom_jpt."</td>";
              echo "<td align='center'>".$skorkin_jpt."</td>";
              echo "<td align='center'>".$skordis_jpt."</td>";
              //echo "<td align='center'>".$skorpip_jpt."<br/><code>".$katpip_jpt."</code></td>";
              echo "</tr>";

              //unt Adm
              echo "<tr>";
              echo "<td>ADMINISTRASI-ADMINISTRATOR<br/>
                    <small>Jumlah Data : ".$jml_adm." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_adm);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_adm; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_adm.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_adm." [".$katpip_adm."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_adm."</td>";
              echo "<td align='center'>".$skorkom_adm."</td>";
              echo "<td align='center'>".$skorkin_adm."</td>";
              echo "<td align='center'>".$skordis_adm."</td>";
              //echo "<td align='center'>".$skorpip_adm."<br/><code>".$katpip_adm."</code></td>";
              echo "</tr>";

              //unt Adm
              echo "<tr>";
              echo "<td>ADMINISTRASI-PENGAWAS<br/>
                    <small>Jumlah Data : ".$jml_pengawas." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_pengawas);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_pengawas; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_pengawas.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_pengawas." [".$katpip_pengawas."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_pengawas."</td>";
              echo "<td align='center'>".$skorkom_pengawas."</td>";
              echo "<td align='center'>".$skorkin_pengawas."</td>";
              echo "<td align='center'>".$skordis_pengawas."</td>";
              //echo "<td align='center'>".$skorpip_pengawas."<br/><code>".$katpip_pengawas."</code></td>";
              echo "</tr>";

              //unt Fungsional
              echo "<tr>";
              echo "<td>FUNGSIONAL<br/>
                    <small>Jumlah Data : ".$jml_fung." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_fung);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_fung; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_fung.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_fung." [".$katpip_fung."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_fung."</td>";
              echo "<td align='center'>".$skorkom_fung."</td>";
              echo "<td align='center'>".$skorkin_fung."</td>";
              echo "<td align='center'>".$skordis_fung."</td>";
              //echo "<td align='center'>".$skorpip_fung."<br/><code>".$katpip_fung."</code></td>";
              echo "</tr>";

              //unt Pelaksana
              echo "<tr>";
              echo "<td>PELAKSANA<br/>
                    <small>Jumlah Data : ".$jml_staf." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_staf);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_staf; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_staf.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_staf." [".$katpip_staf."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_staf."</td>";
              echo "<td align='center'>".$skorkom_staf."</td>";
              echo "<td align='center'>".$skorkin_staf."</td>";
              echo "<td align='center'>".$skordis_staf."</td>";
              //echo "<td align='center'>".$skorpip_staf."<br/><code>".$katpip_staf."</code></td>";
              echo "</tr>";

              echo "</table>";
              echo "</div>";  
            ?>
          </div>


          <div class="tab-pane face" id="tingpen">
            <?php
              $tahun = 2020;
              // rata2 PIP
              $totalpip_s3 = $this->mpip->totalpip_tingpenthn("S3", $tahun);
              $jml_s3 = $this->mpip->jmldatapip_tingpenthn("S3", $tahun);
              if ($jml_s3 != 0) {
                $skorpip_s3 = round($totalpip_s3/$jml_s3, 2);
              } else {
                $skorpip_s3 = 0;
              }
              $katpip_s3 = $this->mpip->getkategoriip($skorpip_s3);
              
              $totalpip_s2 = $this->mpip->totalpip_tingpenthn("S2", $tahun);
              $jml_s2 = $this->mpip->jmldatapip_tingpenthn("S2", $tahun);
              $skorpip_s2 = round($totalpip_s2/$jml_s2, 2);
              $katpip_s2 = $this->mpip->getkategoriip($skorpip_s2);

              $totalpip_s1 = $this->mpip->totalpip_tingpenthn("S1", $tahun);
              $jml_s1 = $this->mpip->jmldatapip_tingpenthn("S1", $tahun);
              $skorpip_s1 = round($totalpip_s1/$jml_s1, 2);
              $katpip_s1 = $this->mpip->getkategoriip($skorpip_s1);
              
              $totalpip_d4 = $this->mpip->totalpip_tingpenthn("D4", $tahun);
              $jml_d4 = $this->mpip->jmldatapip_tingpenthn("D4", $tahun);
              $skorpip_d4 = round($totalpip_d4/$jml_d4, 2);
              $katpip_d4 = $this->mpip->getkategoriip($skorpip_d4);
              
              $totalpip_d3 = $this->mpip->totalpip_tingpenthn("D3", $tahun);
              $jml_d3 = $this->mpip->jmldatapip_tingpenthn("D3", $tahun);
              $skorpip_d3 = round($totalpip_d3/$jml_d3, 2);
              $katpip_d3 = $this->mpip->getkategoriip($skorpip_d3);
              
              $totalpip_d2 = $this->mpip->totalpip_tingpenthn("D2", $tahun);
              $jml_d2 = $this->mpip->jmldatapip_tingpenthn("D2", $tahun);
              $skorpip_d2 = round($totalpip_d2/$jml_d2, 2);
              $katpip_d2 = $this->mpip->getkategoriip($skorpip_d2);

              $totalpip_d1 = $this->mpip->totalpip_tingpenthn("D1", $tahun);
              $jml_d1 = $this->mpip->jmldatapip_tingpenthn("D1", $tahun);
              if ($jml_d1 != 0) {
                $skorpip_d1 = round($totalpip_d1/$jml_d1, 2);  
              } else {
                $skorpip_d1 = 0;
              }              
              $katpip_d1 = $this->mpip->getkategoriip($skorpip_d1);

              $totalpip_sma = $this->mpip->totalpip_tingpenthn("SMA", $tahun);
              $jml_sma = $this->mpip->jmldatapip_tingpenthn("SMA", $tahun);
              $skorpip_sma = round($totalpip_sma/$jml_sma, 2);
              $katpip_sma = $this->mpip->getkategoriip($skorpip_sma);

              $totalpip_smp = $this->mpip->totalpip_tingpenthn("SMP", $tahun);
              $jml_smp = $this->mpip->jmldatapip_tingpenthn("SMP", $tahun);
              $skorpip_smp = round($totalpip_smp/$jml_smp, 2);
              $katpip_smp = $this->mpip->getkategoriip($skorpip_smp);

              $totalpip_sd = $this->mpip->totalpip_tingpenthn("SD", $tahun);
              $jml_sd = $this->mpip->jmldatapip_tingpenthn("SD", $tahun);
              $skorpip_sd = round($totalpip_sd/$jml_sd, 2);
              $katpip_sd = $this->mpip->getkategoriip($skorpip_sd);

              // Kualifikasi
              $totalkua_s3 = $this->mpip->totalkua_tingpenthn("S3", $tahun);
              $skorkua_s3 = round($totalkua_s3/$jml_s3, 2);
              
              $totalkua_s2 = $this->mpip->totalkua_tingpenthn("S2", $tahun);
              $skorkua_s2 = round($totalkua_s2/$jml_s2, 2);
             
              $totalkua_s1 = $this->mpip->totalkua_tingpenthn("S1", $tahun);
              $skorkua_s1 = round($totalkua_s1/$jml_s1, 2);

              $totalkua_d4 = $this->mpip->totalkua_tingpenthn("D4", $tahun);
              $skorkua_d4 = round($totalkua_d4/$jml_d4, 2);

              $totalkua_d3 = $this->mpip->totalkua_tingpenthn("D3", $tahun);
              $skorkua_d3 = round($totalkua_d3/$jml_d3, 2); 

              $totalkua_d2 = $this->mpip->totalkua_tingpenthn("D2", $tahun);
              $skorkua_d2 = round($totalkua_d2/$jml_d2, 2); 

              $totalkua_d1 = $this->mpip->totalkua_tingpenthn("D1", $tahun);
              $skorkua_d1 = round($totalkua_d1/$jml_d1, 2); 

              $totalkua_sma = $this->mpip->totalkua_tingpenthn("SMA", $tahun);
              $skorkua_sma = round($totalkua_sma/$jml_sma, 2); 

              $totalkua_smp = $this->mpip->totalkua_tingpenthn("SMP", $tahun);
              $skorkua_smp = round($totalkua_smp/$jml_smp, 2); 

              $totalkua_sd = $this->mpip->totalkua_tingpenthn("SD", $tahun);
              $skorkua_sd = round($totalkua_sd/$jml_sd, 2);    

              // Kompetensi
              $totalkom_s3 = $this->mpip->totalkom_tingpenthn("S3", $tahun);
              $skorkom_s3 = round($totalkom_s3/$jml_s3, 2);
              
              $totalkom_s2 = $this->mpip->totalkom_tingpenthn("S2", $tahun);
              $skorkom_s2 = round($totalkom_s2/$jml_s2, 2);
             
              $totalkom_s1 = $this->mpip->totalkom_tingpenthn("S1", $tahun);
              $skorkom_s1 = round($totalkom_s1/$jml_s1, 2);

              $totalkom_d4 = $this->mpip->totalkom_tingpenthn("D4", $tahun);
              $skorkom_d4 = round($totalkom_d4/$jml_d4, 2);

              $totalkom_d3 = $this->mpip->totalkom_tingpenthn("D3", $tahun);
              $skorkom_d3 = round($totalkom_d3/$jml_d3, 2); 

              $totalkom_d2 = $this->mpip->totalkom_tingpenthn("D2", $tahun);
              $skorkom_d2 = round($totalkom_d2/$jml_d2, 2); 

              $totalkom_d1 = $this->mpip->totalkom_tingpenthn("D1", $tahun);
              $skorkom_d1 = round($totalkom_d1/$jml_d1, 2); 

              $totalkom_sma = $this->mpip->totalkom_tingpenthn("SMA", $tahun);
              $skorkom_sma = round($totalkom_sma/$jml_sma, 2); 

              $totalkom_smp = $this->mpip->totalkom_tingpenthn("SMP", $tahun);
              $skorkom_smp = round($totalkom_smp/$jml_smp, 2); 

              $totalkom_sd = $this->mpip->totalkom_tingpenthn("SD", $tahun);
              $skorkom_sd = round($totalkom_sd/$jml_sd, 2);    

              // Kinerja
              $totalkin_s3 = $this->mpip->totalkin_tingpenthn("S3", $tahun);
              $skorkin_s3 = round($totalkin_s3/$jml_s3, 2);
              
              $totalkin_s2 = $this->mpip->totalkin_tingpenthn("S2", $tahun);
              $skorkin_s2 = round($totalkin_s2/$jml_s2, 2);
             
              $totalkin_s1 = $this->mpip->totalkin_tingpenthn("S1", $tahun);
              $skorkin_s1 = round($totalkin_s1/$jml_s1, 2);

              $totalkin_d4 = $this->mpip->totalkin_tingpenthn("D4", $tahun);
              $skorkin_d4 = round($totalkin_d4/$jml_d4, 2);

              $totalkin_d3 = $this->mpip->totalkin_tingpenthn("D3", $tahun);
              $skorkin_d3 = round($totalkin_d3/$jml_d3, 2); 

              $totalkin_d2 = $this->mpip->totalkin_tingpenthn("D2", $tahun);
              $skorkin_d2 = round($totalkin_d2/$jml_d2, 2); 

              $totalkin_d1 = $this->mpip->totalkin_tingpenthn("D1", $tahun);
              $skorkin_d1 = round($totalkin_d1/$jml_d1, 2); 

              $totalkin_sma = $this->mpip->totalkin_tingpenthn("SMA", $tahun);
              $skorkin_sma = round($totalkin_sma/$jml_sma, 2); 

              $totalkin_smp = $this->mpip->totalkin_tingpenthn("SMP", $tahun);
              $skorkin_smp = round($totalkin_smp/$jml_smp, 2); 

              $totalkin_sd = $this->mpip->totalkin_tingpenthn("SD", $tahun);
              $skorkin_sd = round($totalkin_sd/$jml_sd, 2);    

              // Disiplin
              $totaldis_s3 = $this->mpip->totaldis_tingpenthn("S3", $tahun);
              $skordis_s3 = round($totaldis_s3/$jml_s3, 2);
              
              $totaldis_s2 = $this->mpip->totaldis_tingpenthn("S2", $tahun);
              $skordis_s2 = round($totaldis_s2/$jml_s2, 2);
             
              $totaldis_s1 = $this->mpip->totaldis_tingpenthn("S1", $tahun);
              $skordis_s1 = round($totaldis_s1/$jml_s1, 2);

              $totaldis_d4 = $this->mpip->totaldis_tingpenthn("D4", $tahun);
              $skordis_d4 = round($totaldis_d4/$jml_d4, 2);

              $totaldis_d3 = $this->mpip->totaldis_tingpenthn("D3", $tahun);
              $skordis_d3 = round($totaldis_d3/$jml_d3, 2); 

              $totaldis_d2 = $this->mpip->totaldis_tingpenthn("D2", $tahun);
              $skordis_d2 = round($totaldis_d2/$jml_d2, 2); 

              $totaldis_d1 = $this->mpip->totaldis_tingpenthn("D1", $tahun);
              $skordis_d1 = round($totaldis_d1/$jml_d1, 2); 

              $totaldis_sma = $this->mpip->totaldis_tingpenthn("SMA", $tahun);
              $skordis_sma = round($totaldis_sma/$jml_sma, 2); 

              $totaldis_smp = $this->mpip->totaldis_tingpenthn("SMP", $tahun);
              $skordis_smp = round($totaldis_smp/$jml_smp, 2); 

              $totaldis_sd = $this->mpip->totaldis_tingpenthn("SD", $tahun);
              $skordis_sd = round($totaldis_sd/$jml_sd, 2);    

              echo "<div style='padding:0px;overflow:auto;width:99%;height:520px;border:1px solid white' >";
              //echo "<div style='padding:0px;width:99%;border:1px solid white; padding-right:20px' >";
              echo "<br />
                <table class='table table-bordered'>
                <tr class='danger'>
                  <td align='center' width='600'><b>Jenis Jabatan<br/><code>SKOR INDEKS PROFESIONALISME</code></b></td>
                  <td align='center' width='100'><b>Kualifikasi<br/>(Maks. 25)</b></td>
                  <td align='center' width='100'><b>Kompetensi<br/>(Maks. 40)</b></td>
                  <td align='center' width='100'><b>Kinerja<br/>(Maks. 30)</b></td>
                  <td align='center' width='100'><b>Disiplin<br/>(Maks. 5)</b></td>
                </tr>";

              //unt S3
              echo "<tr>";
              echo "<td>Strata 3 / DOCTORAL&nbsp
                    <small>Jumlah Data : ".$jml_s3." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_s3);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_s3; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_jpt.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_s3." [".$katpip_s3."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_s3."</td>";
              echo "<td align='center'>".$skorkom_s3."</td>";
              echo "<td align='center'>".$skorkin_s3."</td>";
              echo "<td align='center'>".$skordis_s3."</td>";
              //echo "<td align='center'>".$skorpip_s3."<br/><code>".$katpip_s3."</code></td>";
              echo "</tr>";

              //unt S2
              echo "<tr>";
              echo "<td>STRATA 2 / MAGISTER&nbsp
                    <small>Jumlah Data : ".$jml_s2." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_s2);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_s2; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_s2.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_s2." [".$katpip_s2."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_s2."</td>";
              echo "<td align='center'>".$skorkom_s2."</td>";
              echo "<td align='center'>".$skorkin_s2."</td>";
              echo "<td align='center'>".$skordis_s2."</td>";
              //echo "<td align='center'>".$skorpip_s2."<br/><code>".$katpip_s2."</code></td>";
              echo "</tr>";

              //unt S1
              echo "<tr>";
              echo "<td>STRATA 1 / SARJANA&nbsp
                    <small>Jumlah Data : ".$jml_s1." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_s1);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_s1; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_s1.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_s1." [".$katpip_s1."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_s1."</td>";
              echo "<td align='center'>".$skorkom_s1."</td>";
              echo "<td align='center'>".$skorkin_s1."</td>";
              echo "<td align='center'>".$skordis_s1."</td>";
              //echo "<td align='center'>".$skorpip_s1."<br/><code>".$katpip_s1."</code></td>";
              echo "</tr>";

              //unt D4
              echo "<tr>";
              echo "<td>DIPLOMA 4&nbsp
                    <small>Jumlah Data : ".$jml_d4." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_d4);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_d4; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_d4.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_d4." [".$katpip_d4."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_d4."</td>";
              echo "<td align='center'>".$skorkom_d4."</td>";
              echo "<td align='center'>".$skorkin_d4."</td>";
              echo "<td align='center'>".$skordis_d4."</td>";
              //echo "<td align='center'>".$skorpip_d4."<br/><code>".$katpip_d4."</code></td>";
              echo "</tr>";

              //unt D3
              echo "<tr>";
              echo "<td>DIPLOMA 3&nbsp
                    <small>Jumlah Data : ".$jml_d3." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_d3);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_d3; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_d3.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_d3." [".$katpip_d3."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_d3."</td>";
              echo "<td align='center'>".$skorkom_d3."</td>";
              echo "<td align='center'>".$skorkin_d3."</td>";
              echo "<td align='center'>".$skordis_d3."</td>";
              //echo "<td align='center'>".$skorpip_d3."<br/><code>".$katpip_d3."</code></td>";
              echo "</tr>";

              //unt D2
              echo "<tr>";
              echo "<td>DIPLOMA 2&nbsp
                    <small>Jumlah Data : ".$jml_d2." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_d2);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_d2; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_d2.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_d2." [".$katpip_d2."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_d2."</td>";
              echo "<td align='center'>".$skorkom_d2."</td>";
              echo "<td align='center'>".$skorkin_d2."</td>";
              echo "<td align='center'>".$skordis_d2."</td>";
              //echo "<td align='center'>".$skorpip_d2."<br/><code>".$katpip_d2."</code></td>";
              echo "</tr>";

              //unt D1
              echo "<tr>";
              echo "<td>DIPLOMA 1&nbsp
                    <small>Jumlah Data : ".$jml_d1." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_d1);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_d1; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_d1.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_d1." [".$katpip_d1."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_d1."</td>";
              echo "<td align='center'>".$skorkom_d1."</td>";
              echo "<td align='center'>".$skorkin_d1."</td>";
              echo "<td align='center'>".$skordis_d1."</td>";
              //echo "<td align='center'>".$skorpip_d1."<br/><code>".$katpip_d1."</code></td>";
              echo "</tr>";

              //unt SMA
              echo "<tr>";
              echo "<td>SMA SEDERAJAT&nbsp
                    <small>Jumlah Data : ".$jml_sma." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_sma);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_sma; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_sma.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_sma." [".$katpip_sma."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_sma."</td>";
              echo "<td align='center'>".$skorkom_sma."</td>";
              echo "<td align='center'>".$skorkin_sma."</td>";
              echo "<td align='center'>".$skordis_sma."</td>";
              //echo "<td align='center'>".$skorpip_sma."<br/><code>".$katpip_sma."</code></td>";
              echo "</tr>";

              //unt SMP
              echo "<tr>";
              echo "<td>SMP SEDERAJAT&nbsp
                    <small>Jumlah Data : ".$jml_smp." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_smp);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_smp; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_smp.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_smp." [".$katpip_smp."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_smp."</td>";
              echo "<td align='center'>".$skorkom_smp."</td>";
              echo "<td align='center'>".$skorkin_smp."</td>";
              echo "<td align='center'>".$skordis_smp."</td>";
              //echo "<td align='center'>".$skorpip_smp."<br/><code>".$katpip_smp."</code></td>";
              echo "</tr>";

              //unt SD
              echo "<tr>";
              echo "<td>SD SEDERAJAT&nbsp
                    <small>Jumlah Data : ".$jml_sd." PNS</small><br/>";
              $warnaip = $this->mpip->warnabar($skorpip_sd);
                    ?>
                    <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $skorpip_sd; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$skorpip_sd.'%; color : black'; ?>;">
                      <?php echo "<code>".$skorpip_sd." [".$katpip_sd."]</code>"; ?>
                    </div>
                    <?php
              echo "</td>";
              echo "<td align='center'>".$skorkua_sd."</td>";
              echo "<td align='center'>".$skorkom_sd."</td>";
              echo "<td align='center'>".$skorkin_sd."</td>";
              echo "<td align='center'>".$skordis_sd."</td>";
              //echo "<td align='center'>".$skorpip_sd."<br/><code>".$katpip_sd."</code></td>";
              echo "</tr>";

              echo "</table>";
              echo "</div>";  
            ?>
          </div>



        </div>
      </div>
      </div> <!-- End Kolom Kedua lebar 8 -->

    </div> <!-- End Baris Pertama -->
  </div>

    

      

    
  </center>

