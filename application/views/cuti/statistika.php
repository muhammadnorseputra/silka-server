<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:580px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-info"   style="padding:3px;overflow:auto;width:98%;height:540px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>STATISTIK CUTI</b>
        </div>
  
  <!--
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
  -->
  <?php
    $thn = date('Y');
    $cjmlinboxskpd = $this->mcuti->getjmlprosesbystatuscuti('1',$thn);
    $cjmlcetakusul = $this->mcuti->getjmlprosesbystatuscuti('2',$thn);
    $cjmlinboxbkppd = $this->mcuti->getjmlprosesbystatuscuti('3',$thn);
    $cjmlsetuju = $this->mcuti->getjmlprosesbystatuscuti('4',$thn);
    $cjmlbtl = $this->mcuti->getjmlprosesbystatuscuti('5',$thn);
    $cjmltms = $this->mcuti->getjmlprosesbystatuscuti('6',$thn);
    $cjmlcetaksk = $this->mcuti->getjmlprosesbystatuscuti('7',$thn);

    $ctotal = $cjmlinboxskpd + $cjmlcetakusul + $cjmlinboxbkppd + $cjmlsetuju + $cjmlbtl + $cjmltms + $cjmlcetaksk;

    $ctjmlinboxskpd = $this->mcuti->getjmlprosesbystatuscutitunda('1',$thn);
    $ctjmlcetakusul = $this->mcuti->getjmlprosesbystatuscutitunda('2',$thn);
    $ctjmlinboxbkppd = $this->mcuti->getjmlprosesbystatuscutitunda('3',$thn);
    $ctjmlsetuju = $this->mcuti->getjmlprosesbystatuscutitunda('4',$thn);
    $ctjmlbtl = $this->mcuti->getjmlprosesbystatuscutitunda('5',$thn);
    $ctjmltms = $this->mcuti->getjmlprosesbystatuscutitunda('6',$thn);
    $ctjmlcetaksk = $this->mcuti->getjmlprosesbystatuscutitunda('7',$thn);

    $cttotal = $ctjmlinboxskpd + $ctjmlcetakusul + $ctjmlinboxbkppd + $ctjmlsetuju + $ctjmlbtl + $ctjmltms + $ctjmlcetaksk;
  ?>
  <table class='table table-bordered'>
    <tr>
      <td width='300'>
        <ul class="list-group">
          <li class="list-group-item list-group-item-default"><center>Jumlah Usulan per Status</center>
          </li>
          <li class="list-group-item">Inbox SKPD
          <span class="badge"><?php echo $cjmlinboxskpd; ?></span>
          </li>
          <li class="list-group-item">Cetak Usul
          <span class="badge"><?php echo $cjmlcetakusul; ?></span>
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

      <!--
      <td width='200'>
        <ul class="list-group">
          <li class="list-group-item list-group-item-default"><center>USULAN CUTI TUNDA</center>
          </li>
          <li class="list-group-item">Inbox SKPD
          <span class="badge"><?php echo $ctjmlinboxskpd; ?></span>
          </li>
          <li class="list-group-item"><br/>
          <span class="badge"></span>
          </li>
          <li class="list-group-item">Inbox BKPPD
          <span class="badge"><?php echo $ctjmlinboxbkppd; ?></span>
          </li>          
          <li class="list-group-item">Cetak SK
          <span class="badge"><?php echo $ctjmlcetaksk; ?></span>
          </li>
          <li class="list-group-item">SETUJU
          <span class="badge"><?php echo $ctjmlsetuju; ?></span>
          </li>
          <li class="list-group-item">BTL
          <span class="badge"><?php echo $ctjmlbtl; ?></span>
          </li>
          <li class="list-group-item">TMS
          <span class="badge"><?php echo $ctjmltms; ?></span>
          </li>
          <li class="list-group-item"><u>Jumlah Data Usulan</u>
          <span class="badge"><?php echo $cttotal; ?></span>
          </li>
        </ul>        
      </td>
      -->

      <td>
        <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> Persentase Usulan yang sedang diproses saat ini
        </div>
        <div class="panel-body">
	  <center>
          <div id="jenjab" style="height: 300px; width: 450px"></div>
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
                        allowPointSelect: true,
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
                name: 'Persentase',
                colorByPoint: true,
                data: [
                  <?php                   
                  $tinboxskpd = $cjmlinboxskpd+$ctjmlinboxskpd;
                  $tcetakusul = $cjmlcetakusul+$ctjmlcetakusul;
                  $tinboxbkppd = $cjmlinboxbkppd+$ctjmlinboxbkppd;
                  $tcetaksk = $cjmlcetaksk+$ctjmlcetaksk;

                  if(count($grafik) > 0) {
                    foreach ($grafik as $datac) {
                      if ($datac->nama_statuscuti == 'INBOXSKPD') {
                        echo "['Inbox SKPD'," . $tinboxskpd ."],\n";
                        //$cjmlinskpd = $datac->jumlah;
                      } else if ($datac->nama_statuscuti == 'INBOXBKPPD') {
                        echo "['Inbox BKPPD'," . $tinboxbkppd ."],\n";
                        //$cjmlinbkppd = $datac->jumlah;
                      } else if ($datac->nama_statuscuti == 'CETAKSK') {
                        echo "['Cetak SK BKPPD'," . $tcetaksk ."],\n";
                        //$cjmlcsk = $datac->jumlah;
                      } else if ($datac->nama_statuscuti == 'CETAKUSUL') {
                        echo "['Cetak Usul SKPD'," . $tcetakusul ."],\n";                        
                        //$cjmlcusul = $datac->jumlah;
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
        <i class="fa fa-bar-chart-o fa-fw"></i> Tren Riwayat Cuti setiap bulan (Status Usulan SELESAI)
        </div>
        <div class="panel-body">
          <center>
	  <div id="rwybulan" style="height: 300px; width: 450px"></div>
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
                      text: 'Bulan Cuti'
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
        <table class='table table-hover table-bordered' style='font-size:10px; width:80%; align: center'>
          <tr>
            <td width='30'><center><b>TAHUN</b></center></td>
            <!--<td width='30' title=''><center><b>CUTI TUNDA</b></center></td>-->
            <td width='30' title=''><center><b>CUTI TAHUNAN</b></center></td>
            <!--<td width='30' title=''><center><b>CUTI TAHUNAN<br />+ TUNDA</b></center></td>-->
            <td width='30' title=''><center><b>CUTI SAKIT</b></center></td>
            <td width='30' title=''><center><b>CUTI BERSALIN</b></center></td>
            <td width='30' title=''><center><b>CUTI BESAR</b></center></td>
            <td width='30' title=''><center><b>CUTI KARENA ALASAN PENTING</b></center></td>
            <td width='30' title=''><center><b>CUTI DILUAR<br/>TANGGUNGAN NEGARA</b></center></td>
            <td width='30'><center><b><u>JUMLAH</u></b></center></td>
          </tr>
          <?php
            $no = 1;
            foreach($thncuti as $v):
            $thn =  $v['thn_cuti'];
            //$jmltunda = $this->mcuti->getjmlrwytunda($thn);
            $jmltahunan = $this->mcuti->getjmlrwybythnstatus($thn, '1');
            //$jmltahunantunda = $this->mcuti->getjmlrwytahunanplustunda($thn);
            $jmlsakit = $this->mcuti->getjmlrwybythnstatus($thn, '3');
            $jmlbersalin = $this->mcuti->getjmlrwybythnstatus($thn, '4');
            $jmlbesar = $this->mcuti->getjmlrwybythnstatus($thn, '2');
            $jmlckap = $this->mcuti->getjmlrwybythnstatus($thn, '5');
            $jmlcltn = $this->mcuti->getjmlrwybythnstatus($thn, '6');
            //$total = $jmltunda+$jmltahunan+$jmltahunantunda+$jmlsakit+$jmlbersalin+$jmlbesar+$jmlckap+$jmlcltn;
            $total = $jmltahunan+$jmlsakit+$jmlbersalin+$jmlbesar+$jmlckap+$jmlcltn;
          ?>
          <tr>
            <td><center><?php echo $thn; ?></center></td>
            <!--<td><center><?php echo $jmltunda; ?></center></td>-->
            <td><center><?php echo $jmltahunan; ?></center></td>
            <!--<td><center><?php echo $jmltahunantunda; ?></center></td>-->
            <td><center><?php echo $jmlsakit; ?></center></td>
            <td><center><?php echo $jmlbersalin; ?></center></td>
            <td><center><?php echo $jmlbesar; ?></center></td>
            <td><center><?php echo $jmlckap; ?></center></td>
            <td><center><?php echo $jmlcltn; ?></center></td>
            <td><center><?php echo $total; ?></center></td>
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
