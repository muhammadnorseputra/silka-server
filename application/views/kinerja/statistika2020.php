<script async src="<?php echo base_url('assets/js/tablesorter/jquery.tablesorter.js'); ?>"></script> 
<script async src="<?php echo base_url('assets/js/tablesorter/tables.js'); ?>"></script> 

<!-- Default panel contents -->
  <center>
  <div class="panel panel-info" style="padding:5px;overflow:auto;width:100%;height:610px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>STATISTIK TAMBAHAN PENGHASILAN PEGAWAI</b>
        </div>
  
  <?php
    //$thn = date('Y');
    $thn = 2020;
  ?>

  <div class="row" style="margin-top:20px;">
    <div class="col-lg-2 col-md-2">
      <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2 text-left"><i class="fa fa-money fa-4x">&nbspRp.</i></div>
                    <div class="col-xs-12 text-right">
                        <?php
                          $total = 0;
                          for ($i=1; $i<=12; $i++) {
                            $jml = $this->mkinerja->tottppmurni_perbulan($thn, $i);
                            if ($jml != 0) {
                              $total = $total + $jml;  
                            }                            
                          } 
                          echo "<h3>".number_format($total,0,",",".")."</h3>";
                        ?>                          
                        <div>Realisasi TPP Gross</div>
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left">sebelum dikurangi pajak</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>

        <ul class="list-group" style="padding-top:12px;overflow:auto;width:auto;height:250px;"> 
          <li class="list-group-item list-group-item-default"><center><b>JUMLAH USULAN TPP PER BULAN</b></center>
          </li>	  
          <?php
            for ($i=1; $i<=12; $i++) {
              $jml = $this->mkinerja->getjumlahusul_perperiode($thn, $i);
              if ($jml != 0) {
                echo "<li class='list-group-item' align='left'>".bulan($i)." <span class='badge'><small>".$jml."</small></span></li>";
              }
            } 
          ?>    
        </ul>
    </div>
    <div class="col-lg-2 col-md-2" style="padding:3px;width:250px;height:auto;">
      <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-1 text-left"><i class="fa fa-pagelines fa-4x"></i></div>
                    <div class="col-xs-10 text-right">
                        <?php
                          $totkin = 0;
                          for ($i=1; $i<=12; $i++) {
                            $jml = $this->mkinerja->getjumlahusul_perperiode($thn, $i);                            
                            if ($jml != 0) {
                              $kin = $this->mkinerja->getratakinerja_perbulan($thn, $i);
                              $totkin = $totkin + $kin;  
                              $jmlbulan = $i;
                            }                            
                          } 
                          $ratakin = $totkin / $jmlbulan;
                          echo "<h1><sup><small>Kinerja. </small></sup>".number_format($ratakin,2)."</h1>";

                          $totabs = 0;
                          for ($i=1; $i<=12; $i++) {
                            $jml = $this->mkinerja->getjumlahusul_perperiode($thn, $i);                            
                            if ($jml != 0) {
                              $abs = $this->mkinerja->getrataabsensi_perbulan($thn, $i);
                              $totabs = $totabs + $abs;  
                              $jmlbulan = $i;
                            }                            
                          } 
                          $rataabs = $totabs / $jmlbulan;

                          //echo "<h2>".number_format($ratakin,2)." | ".number_format($rataabs,2)."</h2>";
                          
                          echo "<h1><sup><small>Absensi. </small></sup>".number_format($rataabs,2)."</h1>";
                        ?>                          
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left">Rata-Rata Tahunan</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>

        <ul class="list-group" style="padding:3px;overflow:auto;width:250px;height:250px;"> 
          <li class="list-group-item list-group-item-default"><center><b>REALISASI TPP GROSS BULANAN</b><br/><small class='text-muted'>SEBELUM PAJAK</small></center>
          </li>
          <?php
            for ($i=1; $i<=12; $i++) {
              $jml = $this->mkinerja->tottppmurni_perbulan($thn, $i);
              if ($jml != 0) {
                echo "<li class='list-group-item' align='left'>".bulan($i)." <code>Rp. ".number_format($jml,0,",",".")."</code></li>";
              }
            } 
          ?>        
        </ul>
    </div>

    <div class="col-lg-8 col-md-8">
      <div class="panel panel-warning">
        <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> REALISASI TPP YANG DIBAYARKAN (TAKE HOME PAY)
        </div>
        <div class="panel-body">
          <div id="rwybulan" style="height: 400px; width: auto"></div>
        </div>
        <script type="text/javascript">
          Highcharts.chart('rwybulan', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: ''
              },
              subtitle: {
                  //text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
              },
              xAxis: {
                  categories: [
                  //'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agust', 'Sept', 'Okt', 'Nov', 'Des'
                  <?php
                  if(count($rwyperbulan)>0)
                  {
                    foreach ($rwyperbulan as $data) {
                      echo "'".bulan($data->bulan). "',";
                    }
                  }
                  ?>
                  ],
                  
                  title: {
                      text: 'PERIODE BULAN'
                  }
              },
              yAxis: {
                  min: 2,
                  title: {
                      text: 'TAKE HOME PAY (RUPIAH)',
                      align: 'middle',
                      color: 'red'
                  },
                  labels: {
                      overflow: 'justify'
                  }
              },
              tooltip: {
                  pointFormat: 'Jumlah : Rp. {point.y:f}'
              },
              plotOptions: {
                  column: {
                    dataLabels: {
                          enabled: true
                      },
                      pointPadding: 0.02,
                      borderWidth: 0,
                    showInLegend: false
                  }
              },
              legend: {
                  layout: 'vertical',
                  align: 'right',
                  verticalAlign: 'top',
                  x: -40,
                  y: 80,
                  floating: false,
                  borderWidth: 1,
                  backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                  shadow: false
              },
              credits: {
                  enabled: false
              },
              series: [{
                data :
                <?php 
                // data yang diambil dari database
                if(count($rwyperbulan)>0)
                {
                  echo "[";
                  foreach ($rwyperbulan as $data) {
                    echo $data->jumlah.",";
                    //echo "['" .$bulan . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                  }
                  echo "]";
                }
                ?>
              }]
          });
          </script>
        </div>
    </div>
  </div>
  <!-- End Baris Pertama -->

  <!-- Baris Kedua -->
  <div class="row">
    <div class="col-lg-12 col-md-2">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
              <tr>
                <th><p class='text-muted'>No.</p></th>
                <th><p class='text-muted'>PERIODE<br/>BULAN</p></th>
                <th>Jumlah<br/>Usul PNS <i class="fa fa-sort"></i></th>
                <th>Jml<br/>Struktural <i class="fa fa-sort"></i></th>
                <th><p>Jml JFU</p> <i class="fa fa-sort"></i></th>
                <th><p>Jml JFT</p> <i class="fa fa-sort"></i></th>
                <th>Jml JFT<br/>Kesehatan <i class="fa fa-sort"></i></th>
                <th>Jml JFT<br/>Pendidikan <i class="fa fa-sort"></i></th>
                <th>Jml JFT<br/>Lainnya <i class="fa fa-sort"></i></th>
                <th class='info'>Jml Wajib<br/>Ekinerja <i class="fa fa-sort"></i></th>
                <th class='info'>Rata2<br/>Kinerja <i class="fa fa-sort"></i></th>
                <th class='info'><div class='text-danger'>Kinerja<br/>NOL</div> <i class="fa fa-sort"></i></th>
                <th class='info'>Kinerja<br/>< 60 <i class="fa fa-sort"></i></th>
                <th class='info'>Kinerja<br/>> 92 <i class="fa fa-sort"></i></th>                
                <th class='info'>Kinerja<br/>Tertinggi <i class="fa fa-sort"></i></th>                
                <th class='info'>Kinerja<br/>Terendah <i class="fa fa-sort"></i></th>
                <th class='success'>Rata2<br/>Absensi <i class="fa fa-sort"></i></th>
                <th class='success'><div class='text-danger'>Absensi<br/>NOL</div> <i class="fa fa-sort"></i></th>
                <th class='success'>Absensi<br/>< 40 <i class="fa fa-sort"></i></th>                
              </tr>
            </thead>
            <tbody>
              <?php 
                for ($i=1; $i<=12; $i++) {
                  $jmlusul = $this->mkinerja->getjumlahusul_perperiode($thn, $i);
                  if ($jmlusul != 0) {
                    $jmljft = $this->mkinerja->getjmlusuljft($thn, $i);
                    $jmljfu = $this->mkinerja->getjmlusuljfu($thn, $i);
                    $jmlstruktural = $jmlusul -  $jmljfu - $jmljft;
                    echo "<tr>";
                    echo "<td align='center'>".$i."</td>";
                    echo "<td class='danger'><p class='text-muted'>".bulan($i)." 2020</p></td>";                    
                    echo "<td>".$jmlusul."</td>";
                    echo "<td>".$jmlstruktural."</td>";
                    echo "<td>".$jmljfu."</td>";
                    echo "<td>".$jmljft."</td>";

                    $jmlusuljftkesehatan = $this->mkinerja->getjmlusuljftkesehatan($thn, $i);
                    echo "<td>".$jmlusuljftkesehatan."</td>";

                    $jmlusuljftpendidikan = $this->mkinerja->getjmlusuljftpendidikan($thn, $i);
                    echo "<td>".$jmlusuljftpendidikan."</td>";

                    $jmlusuljftlainnya = $jmljft - $jmlusuljftkesehatan - $jmlusuljftpendidikan;
                    echo "<td>".$jmlusuljftlainnya."</td>";

                    $jmlwajibekin = $this->mkinerja->getjmlwajibekin($thn, $i);
                    echo "<td class='info'>".$jmlwajibekin."</td>";

                    $ratakin = $this->mkinerja->getratakinerja_perbulan($thn, $i);
                    echo "<td class='info'>".number_format($ratakin,2)."</td>";

                    $jmlekinnol = $this->mkinerja->getjmlekinnol($thn, $i);
                    echo "<td class='info'><div class='text-danger'>".$jmlekinnol."</div></td>";

                    $jmlekinmin60 = $this->mkinerja->getjmlekinmin60($thn, $i);
                    echo "<td class='info'>".$jmlekinmin60."</td>";

                    $jmlekinatas92 = $this->mkinerja->getjmlekinatas92($thn, $i);
                    echo "<td class='info'>".$jmlekinatas92."</td>";

                    $ekintertinggi = $this->mkinerja->getekintertinggi($thn, $i);
                    echo "<td class='info'>".number_format($ekintertinggi,2)."</td>";

                    $ekinterendah = $this->mkinerja->getekinterendah($thn, $i);
                    echo "<td class='info'>".number_format($ekinterendah,2)."</td>";

                    $rataabsen = $this->mkinerja->getrataabsensi_perbulan($thn, $i);
                    echo "<td class='success'>".number_format($rataabsen,2)."</td>";

                    $jmlabsennol = $this->mkinerja->getjmlabsennol($thn, $i);
                    echo "<td class='success'><div class='text-danger'>".$jmlabsennol."</div></td>";

                    $jmlabsenmin40 = $this->mkinerja->getjmlabsenmin40($thn, $i);
                    echo "<td class='success'>".$jmlabsenmin40."</td>";                    
                    echo "<tr>";
                  }
                }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
    </div>
  </div>
  <!-- End Baris Kedua -->
  
</div>
</center>
