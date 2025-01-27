<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:640px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-info"   style="padding:3px;overflow:auto;width:98%;height:610px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>STATISTIK DATA KGB</b>
        </div>
  
  <table class='table table-bordered'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 
  <?php
    $thn = date('Y');
    $cjmlinboxskpd = $this->mkgb->getjmlprosesbystatuskgb('1',$thn);
    //$cjmlcetakusul = $this->mkgb->getjmlprosesbystatuskgb('2',$thn);
    $cjmlinboxbkppd = $this->mkgb->getjmlprosesbystatuskgb('3',$thn);
    $cjmlsetuju = $this->mkgb->getjmlprosesbystatuskgb('4',$thn);
    $cjmlbtl = $this->mkgb->getjmlprosesbystatuskgb('5',$thn);
    $cjmltms = $this->mkgb->getjmlprosesbystatuskgb('6',$thn);
    $cjmlcetaksk = $this->mkgb->getjmlprosesbystatuskgb('7',$thn);

    $ctotal = $cjmlinboxskpd + $cjmlinboxbkppd + $cjmlsetuju + $cjmlbtl + $cjmltms + $cjmlcetaksk;
    
  ?>
  <table class='table table-bordered'>
    <tr>
      <td width='400'>
        <ul class="list-group">
          <li class="list-group-item list-group-item-default"><center>Jumlah Usulan per Status</center>
          </li>
          <li class="list-group-item">Inbox SKPD
          <span class="badge"><?php echo $cjmlinboxskpd; ?></span>
          </li>
          <li class="list-group-item">Cetak Usul
          <span class="badge"><?php //echo $cjmlcetakusul; ?></span>
          </li>
          <li class="list-group-item">Inbox BKPPD
          <span class="badge"><?php echo $cjmlinboxbkppd; ?></span>
          </li>
          <li class="list-group-item">Cetak SK
          <span class="badge"><?php echo $cjmlcetaksk; ?></span>
          </li>
          <li class="list-group-item">SETUJU
          <span class="badge"><?php echo $cjmlsetuju; ?></span>
          </li>
          <li class="list-group-item">BTL
          <span class="badge"><?php echo $cjmlbtl; ?></span>
          </li>
          <li class="list-group-item">TMS
          <span class="badge"><?php echo $cjmltms; ?></span>
          </li>
          <li class="list-group-item"><u>Jumlah Data Usulan</u>
          <span class="badge"><?php echo $ctotal; ?></span>
          </li>
        </ul>
      </td>      
      <td>
        <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Usulan yang sedang diproses saat ini
        </div>
        <div class="panel-body">
	  <center>
          <div id="jenjab" style="height: 300px; width: 400px"></div>
	  </center>	
          <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
        </div>

        <!-- untuk pemanggilan Pie Chart Jenis Jabatan-->
        <script type="text/javascript">
        Highcharts.chart('jenjab', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: 'Jumlah : <b>{point.y:f}</b><br />{series.name}: <b>{point.percentage:.1f}%</b>'
                //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
              pie: {
                        allowPointSelect: false,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '<span style="font-size: 11px">{point.name}<br/>Jml : {point.y:f}<br />{point.percentage:.1f} %</span>',
                          style: {
                              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          }
                        },
                        showInLegend: false
                    }

            },
            series: [{
              type : 'pie',
                name: 'Persentase ',
                colorByPoint: true,
                data: [
                  <?php                   
                  $tinboxskpd = $cjmlinboxskpd;
                  //$tcetakusul = $cjmlcetakusul;
                  $tinboxbkppd = $cjmlinboxbkppd;
                  $tcetaksk = $cjmlcetaksk;

                  if(count($grafik)>0)
                  {
                    foreach ($grafik as $datac) {
                      if ($datac->nama_statuskgb == 'INBOXSKPD') {
                        echo "['Inbox SKPD'," . $tinboxskpd ."],\n";
                        //$cjmlinskpd = $datac->jumlah;
                      } else if ($datac->nama_statuskgb == 'INBOXBKPPD') {
                        echo "['Inbox BKPPD'," . $tinboxbkppd ."],\n";
                        //$cjmlinbkppd = $datac->jumlah;
                      } else if ($datac->nama_statuskgb == 'CETAKSK') {
                        echo "['Cetak SK BKPPD'," . $tcetaksk ."],\n";
                        //$cjmlcsk = $datac->jumlah;
                      }
                    }
                  }                  
                ?>
              ]
            }]
        });
        </script>
        <!-- akhir pie chart Jenis Jabatan -->
      </td>
      <td>
        <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Tren Riwayat KGB setiap bulan (Status Usulan SELESAI)
        </div>
        <div class="panel-body">
          <center>
	  <div id="rwybulan" style="height: 300px; width: 400px"></div>
	  </center>
          <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
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
                  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agust', 'Sept', 'Okt', 'Nov', 'Des'],
                  title: {
                      text: 'Bulan KGB'
                  }
              },
              yAxis: {
                  min: 0,
                  title: {
                      text: 'Jumlah',
                      align: 'high',
                      color: 'red'
                  },
                  labels: {
                      overflow: 'justify'
                  }
              },
              tooltip: {
                  //valueSuffix: ' orang',
                  pointFormat: 'Jumlah : <b>{point.y:f}</b> orang'
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
                  floating: true,
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
                    //echo $data->jumlah .",";
                    echo $data->jumlah .",";
                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                  }
                  echo "]";
                }
                ?>
              }]
          });
          </script>
      </td>
    </tr>
    <tr class='info'>
      <td width='1000' colspan='4'>
        <table class='table table-hover table-bordered'>
          <tr>
            <td width='30'><center><b>TAHUN</b></center></td>
            <td width='30'><center><b><u>JUMLAH RIWAYAT</u></b></center></td>
          </tr>
          <?php
            $no = 1;
            foreach($thnkgb as $v):        
            $thn =  $v['tahun'];
            $jml = $this->mkgb->getjmlrwybythnstatus($thn);

            ?>
            <tr>
              <td><center><?php echo $thn; ?></center></td>
              <td><center><?php echo $jml; ?></center></td>
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
