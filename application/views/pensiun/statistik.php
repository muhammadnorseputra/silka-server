<!-- Default panel contents -->
  <center>
  <div class="panel panel-info"   style="padding:3px;overflow:auto;width:98%;height:600px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>STATISTIK DATA PENSIUN</b>
        </div>
  
  <div class='text-danger'>
   <?php
      echo "<h4 align='right'>Hari ini : ".tgl_indo(date('yy-m-d'))."</h4>";
    ?>
  </div>

  <div class="row">
    <div class="col-lg-4" align='center'>
        <pre><div class='text-primary'><i class="fa fa-bar-chart-o fa-fw"></i> JUMLAH PENSIUN TAHUN <?php echo $thn; ?> YANG TELAH DIPROSES</div></pre>
        <div id="jenpen" style="height: 100%; width: 100%"></div>
        <!-- untuk pemanggilan Pie Chart Jenis Jabatan-->
        <script type="text/javascript">
        Highcharts.chart('jenpen', {
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
                          format: '{point.y:f}<br />{point.percentage:.1f} %',
                          style: {
                              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          }
                        },
                        showInLegend: true
                    }

            },
            series: [{
              type : 'pie',
                name: 'Persentase ',
                colorByPoint: true,
                data: [
                  <?php                
                  $jmlbup = $this->mpensiun->getjmlbyjenis('1',$thn);
                  $jmljadu = $this->mpensiun->getjmlbyjenis('6',$thn);
                  $jmlaps = $this->mpensiun->getjmlbyjenis('7',$thn);

                  if(count($jenpen)>0)
                  {
                    foreach ($jenpen as $datac) {
                      if ($datac->nama_jenis_pensiun == 'BUP') {
                        echo "['BUP'," . $jmlbup ."],\n";
                      } else if ($datac->nama_jenis_pensiun == 'MENINGGAL DUNIA') {
                        echo "['JANDA DUDA'," . $jmljadu ."],\n";
                      } else if ($datac->nama_jenis_pensiun == 'ATAS PERMINTAAN SENDIRI') {
                        echo "['APS'," . $jmlaps ."],\n";
                      }
                    }
                  }                  
                ?>
              ]
            }]
        });
        </script>
        <!-- akhir pie chart Jenis Jabatan -->
    </div>

    <div class="col-lg-4" align='center'>
        <pre><div class='text-success'><i class="fa fa-bar-chart-o fa-fw"></i> TREN PENSIUN BULANAN TAHUN <?php echo $thn; ?></div></pre>
        <div id="rwybulan" style="height: 100%; width: 100%"></div>
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
                      text: 'BULAN TMT'
                  }
              },
              yAxis: {
                  min: 0,
                  title: {
                      text: 'JUMLAH',
                      align: 'right',
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
                  backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FF0000'),
                  shadow: true
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
                    //echo $data->jumlah1 .",";
                    echo $data->jumlah .",";
                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                  }
                  echo "]";
                }
                ?>
              }]
          });
          </script>
      </div>

      <div class="col-lg-4" align='center'>
        <pre><div class='text-primary'><i class="fa fa-bar-chart-o fa-fw"></i> JUMLAH PENSIUN TAHUN <?php echo $thn; ?> BERDASARKAN JABATAN</div></pre>
        <div id="perjab" style="height: 100%; width: 100%"></div>
        <!-- untuk pemanggilan Pie Chart Jenis Jabatan-->
        <script type="text/javascript">
        Highcharts.chart('perjab', {
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
                          format: '{point.y:f}<br />{point.percentage:.1f} %',
                          style: {
                              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          }
                        },
                        showInLegend: true
                    }

            },
            series: [{
              type : 'pie',
                name: 'Persentase ',
                colorByPoint: true,
                data: [
                  <?php                
                  $jmljpt = $this->mpensiun->getjmlbyjabasn('JPT-PRATAMA',$thn);
                  $jmladm = $this->mpensiun->getjmlbyjabasn('ADMINISTRASI-ADMINISTRATOR',$thn);
                  $jmlpeng = $this->mpensiun->getjmlbyjabasn('ADMINISTRASI-PENGAWAS',$thn);
                  $jmljfu = $this->mpensiun->getjmlbyjabasn('PELAKSANA',$thn);
                  $jmljft = $this->mpensiun->getjmlbyjabasn('FUNGSIONAL',$thn);

                  if(count($jabasn)>0)
                  {
                    foreach ($jabasn as $datac) {
                      if ($datac->jab_asn == 'JPT-PRATAMA') {
                        echo "['JPT-PRATAMA'," . $jmljpt ."],\n";
                      } else if ($datac->jab_asn == 'ADMINISTRASI-ADMINISTRATOR') {
                        echo "['ADMINISTRATOR'," . $jmladm ."],\n";
                      } else if ($datac->jab_asn == 'ADMINISTRASI-PENGAWAS') {
                        echo "['PENGAWAS'," . $jmlpeng ."],\n";
                      } else if ($datac->jab_asn == 'PELAKSANA') {
                        echo "['PELAKSANA'," . $jmljfu ."],\n";
                      } else if ($datac->jab_asn == 'FUNGSIONAL') {
                        echo "['FUNGSIONAL'," . $jmljft ."],\n";
                      }
                    }
                  }                  
                ?>
              ]
            }]
        });
        </script>
        <!-- akhir pie chart Jenis Jabatan -->
    </div>
    </div> <!-- end row baris pertama -->

    <!-- row kedua -->
    <div class="row">
    <div class="col-lg-12" align='center'>
      <pre><div class='text-success'>AKUMULASI PENSIUN TAHUNAN</div></pre>
        </div>
        <table class='table table-hover table-condensed'>
          <tr>
            <td width='30'><center><b>TAHUN</b></center></td>
            <!--<td width='30' title=''><center><b>CUTI TUNDA</b></center></td>-->
            <td width='30' title=''><center><b>BUP</b></center></td>
            <!--<td width='30' title=''><center><b>CUTI TAHUNAN<br />+ TUNDA</b></center></td>-->
            <td width='30' title=''><center><b>JANDA DUDA</b></center></td>
            <td width='30' title=''><center><b>ATAS PERMINTAAN SENDIRI</b></center></td>
            <td width='30'><center><b><u>JUMLAH</u></b></center></td>
          </tr>
          <?php
            $no = 1;
            foreach($thncuti as $v):       
            $jmlbup = $this->mpensiun->getjmlbyjenis('1',$v['tahun']);
            $jmljadu = $this->mpensiun->getjmlbyjenis('6',$v['tahun']);
            $jmlaps = $this->mpensiun->getjmlbyjenis('7',$v['tahun']);
            $total = $jmlbup+$jmljadu+$jmlaps;
          ?>
          <tr>
            <td><center><?php echo $v['tahun']; ?></center></td>
            <td><center><?php echo $jmlbup; ?></center></td>
            <td><center><?php echo $jmljadu; ?></center></td>
            <td><center><?php echo $jmlaps; ?></center></td>
            <td><center><?php echo $total; ?></center></td>
          </tr>          
          <?php
            $no++;
            endforeach;
          ?>
        </table>
    </div>
  </div>
  <!-- end row kedua -->

  
  </div>
</center>
