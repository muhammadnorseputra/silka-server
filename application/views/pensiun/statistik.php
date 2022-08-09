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
    		xAxis: {
        		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agust', 'Sept', 'Okt', 'Nov', 'Des']
    		},
    		yAxis: {
        		min: 0,
        		title: {
            			text: 'Jumlah (PNS)'
        	},
        	stackLabels: {
            		enabled: true,
            		style: {
                		fontWeight: 'bold',
                		color: ( // theme
                    			Highcharts.defaultOptions.title.style &&
                    			Highcharts.defaultOptions.title.style.color
                		) || 'grey'
            		}
        	}
    		},
		
    		legend: {
        		//align: 'right',
        		//x: -30,
        		//verticalAlign: 'top',
        		//y: 25,
        		floating: false,
        		backgroundColor: 'red',
        		borderColor: '#111',
        		borderWidth: 2,
        		shadow: false
    		},

    		tooltip: {
        		headerFormat: '<b>{point.x}</b><br/>',
        		pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    		},
		
    		plotOptions: {
        		column: {
            			stacking: 'normal',
            			dataLabels: {
                			enabled: true,
					style: {
                                                fontWeight: 'bold',
						fontSize: '23px',
                                                color : 'red'
                                        }
            			},
        		}
    		},
		
    		series: [{
        		name: 'BUP',
        		data: 
				<?php
					$jmlbup = $this->mpensiun->getjmlperjnsbulan('2022','1');
					echo "[";				
                        		foreach($jmlbup as $v):
                                        	echo $v->jumlah.",";
					endforeach;
                        		echo "]";
                                ?>
    		}, {
        		name: 'Janda/Duda',
        		data: 
				<?php
                                        $jmljadu = $this->mpensiun->getjmlperjnsbulan('2022','6');
                                        echo "[";
                                        foreach($jmljadu as $v):
                                                echo $v->jumlah.",";
                                        endforeach;
                                        echo "]";
                                ?>
    		}, {
        		name: 'APS',
        		data: 
				<?php
                                        $jmlaps = $this->mpensiun->getjmlperjnsbulan('2022','7');
                                        echo "[";
                                        foreach($jmlaps as $v):
                                                echo $v->jumlah.",";
                                        endforeach;
                                        echo "]";
                                ?>
		}
		]
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
    <div class="col-lg-12'" align='center'>
      <pre><div class='text-success'>GRAFIK AKUMULASI TAHUNAN</div></pre>
    </div>
    <div class="col-lg-12'" align='center'>
	<div id="rwytahunperjns" style="height: 100%; width: 100%"></div>
	<script type="text/javascript">
          Highcharts.chart('rwytahunperjns', {
              chart: {
                  type: 'Combination chart'
              },
              title: {
                  text: ''
              },
              subtitle: {
                  //text: ''
              },
	      	
              xAxis: {
		  min : 0,
		  title: {
                        text: 'TAHUN'
                  },
                  categories: 
		  <?php
			echo "[";
			foreach($thncuti as $v):
				$jmlbup = $this->mpensiun->getjmlbyjenis('1',$v['tahun']);
            			$jmljadu = $this->mpensiun->getjmlbyjenis('6',$v['tahun']);
            			$jmlaps = $this->mpensiun->getjmlbyjenis('7',$v['tahun']);
			        $total = $jmlbup+$jmljadu+$jmlaps;
				echo $v['tahun'].",";
				//echo $v['tahun']."".$total;
				//echo ",";
			endforeach;
			echo "]";
		  ?>,
		  crosshair: true
              },
              yAxis: {
		min: 0,
        	title: {
            		text: 'JUMLAH (PNS)'
        	}
              },
	      
              tooltip: {
		headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><table>',
        	pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name} </td>' +
            		'<td style="padding:0"><b>{point.y:.0f} PNS</b></td></tr>',
        	footerFormat: '</table>',
        	shared: true,
        	useHTML: true
              },
	
	      plotOptions: {
		column: {
			dataLabels: {
                          enabled: true
                      	},
            		pointPadding: 0,
            		borderWidth: 0,
			showInLegend: true
        	},
		spline: {
                        dataLabels: {
                          enabled: true,
			},
		},
		pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '{point.y:f} [{point.percentage:.1f} %]',
                        },
                        showInLegend: false
                    }
              },
	      /*	
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
	      */
              credits: {
                  enabled: false
              },
	      series: [{
		type: 'column',
		name : 'BUP',
                data : 
			<?php
			echo "[";
                        foreach($thncuti as $v):
				$jmlbup = $this->mpensiun->getjmlbyjenis('1',$v['tahun']);
                                echo $jmlbup.",";
                        endforeach;
                        echo "]";
			?>
		},{
		type: 'column',
		name : 'Janda/Duda',
                data : 
			<?php
                        echo "[";
                        foreach($thncuti as $v):
				$jmljadu = $this->mpensiun->getjmlbyjenis('6',$v['tahun']);
                                echo $jmljadu.",";
                        endforeach;
                        echo "]";
                        ?>
		},{
		type: 'column',
                name : 'APS',
                data :
                        <?php
                        echo "[";
                        foreach($thncuti as $v):
				$jmlaps = $this->mpensiun->getjmlbyjenis('7',$v['tahun']);
                                echo $jmlaps.",";
                        endforeach;
                        echo "]";
                        ?>
		},{
		type: 'spline',
        	name: 'TOTAL',
        	data: 
		<?php
                        echo "[";
                        foreach($thncuti as $v):
                                $jmlbup = $this->mpensiun->getjmlbyjenis('1',$v['tahun']);
                                $jmljadu = $this->mpensiun->getjmlbyjenis('6',$v['tahun']);
                                $jmlaps = $this->mpensiun->getjmlbyjenis('7',$v['tahun']);
                                $total = $jmlbup+$jmljadu+$jmlaps;
                                echo $total.",";
                        endforeach;
                        echo "]";
                ?>,
        	marker: {
            		lineWidth: 2,
            		fillColor: 'white'
        		}
		},{
		type: 'pie',
        	name: 'Total :',
        	data: [{
            			name: 'BUP',
            			y:
				<?php
					$totbup = $this->mpensiun->gettotalbyjenis('1');
					echo $totbup.",";
				?> 
        		}, {
            			name: 'Janda/Duda',
            			y: 
				<?php
                                        $totjadu = $this->mpensiun->gettotalbyjenis('6');
                                        echo $totjadu.",";
                                ?>			
        		}, {
            			name: 'APS',
            			y: 
				<?php
                                        $totaps = $this->mpensiun->gettotalbyjenis('7');
                                        echo $totaps.",";
                                ?>
        		}],
        	center: [120, 80],
        	size: 120,
		}
              ]
          });
          </script>


    </div>
    </div>
    <!-- end row kedua -->


    <!-- row ketiga -->
    <!--
    <div class="row">
    <div class="col-lg-12" align='center'>
      <pre><div class='text-success'>AKUMULASI PENSIUN TAHUNAN</div></pre>
        </div>
        <table class='table table-hover table-condensed'>
          <tr>
            <td width='30'><center><b>TAHUN</b></center></td>
            <td width='30' title=''><center><b>BUP</b></center></td>
            <td width='30' title=''><center><b>JANDA DUDA</b></center></td>
            <td width='30' title=''><center><b>ATAS PERMINTAAN SENDIRI</b></center></td>
            <td width='30'><center><b><u>JUMLAH</u></b></center></td>
          </tr>
          <?php
            //$no = 1;
            //foreach($thncuti as $v):       
            //$jmlbup = $this->mpensiun->getjmlbyjenis('1',$v['tahun']);
            //$jmljadu = $this->mpensiun->getjmlbyjenis('6',$v['tahun']);
            //$jmlaps = $this->mpensiun->getjmlbyjenis('7',$v['tahun']);
            //$total = $jmlbup+$jmljadu+$jmlaps;
          ?>
          <tr>
            <td><center><?php //echo $v['tahun']; ?></center></td>
            <td><center><?php //echo $jmlbup; ?></center></td>
            <td><center><?php //echo $jmljadu; ?></center></td>
            <td><center><?php //echo $jmlaps; ?></center></td>
            <td><center><?php //echo $total; ?></center></td>
          </tr>          
          <?php
            //$no++;
            //endforeach;
          ?>
        </table>
    </div>
  </div>
  -->
  <!-- end row ketiga -->

  
  </div>
</center>
