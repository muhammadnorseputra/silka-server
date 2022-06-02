<div class="row">
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-group fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
				$jmlpns =  $this->mgraph->jmlpns();
				$jmlnonpns =  $this->mgraph->jmlnonpns();
			
                        	echo $jmlpns+$jmlnonpns;
                        ?>                        	
                        </div>
                        <div>Jumlah ASN</div>
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left">PNS + CPNS + Non PNS</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user-md fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                                echo $this->mgraph->jmlpns();
                        ?>
                        </div>
                        <div>Jumlah PNS + CPNS</div>
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left">termasuk CPNS - 
		    <?php
                                echo $this->mgraph->jmlcpns();
                    ?>
		    </span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-2 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user  fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                            echo $this->mgraph->jmlnonpns();
                        ?>
                        </div>
                        <div>Jumlah Non PNS</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('nonpns/statistik') ?>">
                <div class="panel-footer">
                    <span class="pull-left">seluruh kategori</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-wheelchair fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	//$tgl = getdate();
				//$thn = $tgl["year"];

                        	$thn = 2021;
				//$thn = date('Y');
                        	//echo $this->mgraph->jmlpensiun('2017');
				echo $this->mgraph->jmlpensiun($thn);
                        ?>	
                        </div>
                        <div>Pensiunan Tahun Ini</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('pensiun/statistik') ?>">
                <div class="panel-footer">
                    <span class="pull-left">yang sudah mencapai TMT</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-briefcase fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	$thn = '2021';
				//$thn = date('Y');
                        	echo $this->mgraph->jmlusulkgb($thn);
                        ?>	
                        </div>
                        <div>Usul KGB Tahun ini</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('kgb/statistika') ?>">
                <div class="panel-footer">
                    <span class="pull-left">yang telah disetujui</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-check-square-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	//$thn = date('Y');
                        	echo $this->mgraph->jmlusulcutisetuju('2021');
                        ?>
                        </div>
                        <div>Usul Cuti Tahun Ini</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('cuti/statistika') ?>">
                <div class="panel-footer">
                    <span class="pull-left">yang telah disetujui</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
	
    <!--
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-ticket fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	//$thn = date('Y');
                        	echo $this->mgraph->jmlusulcutitundasetuju('2021');
                        ?>
                        </div>
                        <div>Cuti Tunda Tahun Ini</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">yang telah disetujui</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    -->    
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PNS Berdasarkan Golongan Ruang
                <div class="pull-right">
                    <!--
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Actions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="#">Action</a>
                            </li>
                            <li><a href="#">Another action</a>
                            </li>
                            <li><a href="#">Something else here</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a>
                            </li>
                        </ul>
                    </div>
                    -->
                </div>
            </div>
            <div class="panel-body">
            	<div id="golru" style="height: 600px; width: 400px"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-red">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PNS Berdasarkan Jenis Kelamin
            </div>
            <div class="panel-body">
                <div id="jenkel" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>

	<!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PNS Berdasarkan Eselonering
            </div>
            <div class="panel-body">
                <div id="eselon" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>

	<!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PNS Berdasarkan Tingkat Pendidikan
            </div>
            <div class="panel-body">
                <div id="tingpen" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>

	<!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PNS Berdasarkan Jenis Jabatan
            </div>
            <div class="panel-body">
                <div id="jenjab" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>




<!-- untuk pemanggilan Pie Chart -->
<script type="text/javascript">
Highcharts.chart('jenkel', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
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
			// data yang diambil dari database
			if(count($jenkel)>0)
			{
				foreach ($jenkel as $data) {
					if ($data->jenis_kelamin == 'L') {
						$jenkel = 'LAKI-LAKI';
					} else if ($data->jenis_kelamin == 'P') {
						$jenkel = 'PEREMPUAN';
					}

					echo "['" .$jenkel . "'," . $data->jumlah ."],\n";
					//echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
				}
			}
			?>
		]
    }]
});
</script>
<!-- akhir pie chart -->

<!-- awal bar chart golru -->
<script type="text/javascript">
Highcharts.chart('golru', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Jumlah PNS berdasarkan Golongan Ruang'
    },
    subtitle: {
        //text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        categories: ['I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'],
        title: {
            text: 'Golongan Ruang'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        //valueSuffix: ' orang'
        pointFormat: 'Jumlah : <b>{point.y:f}</b> orang'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            },
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
			if(count($golru)>0)
			{
				echo "[";
				foreach ($golru as $data) {
					//echo $data->jumlah .",";
					echo $data->jumlah .",";
					//echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
				}
				echo "]";
			}
			?>
        //data: [107, 31, 635, 203, 133, 156, 947, 408, 6, 1052, 954, 450, 740, 38, 408, 6, 1052,]
    }]
});
</script>
<!-- akhir bar chart golru -->

<!-- awal bar chart eselon -->
<script type="text/javascript">
Highcharts.chart('eselon', {
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
        categories: ['II/a', 'II/b', 'III/a', 'III/b', 'IV/a', 'IV/b'],
        title: {
            text: 'Eselon'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah',
            align: 'high'
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
			if(count($eselon)>0)
			{
				echo "[";
				foreach ($eselon as $data) {
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
<!-- akhir bar chart eselon -->

<!-- untuk pemanggilan Pie Chart Jenis Jabatan-->
<script type="text/javascript">
Highcharts.chart('jenjab', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
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
			// data yang diambil dari database
			if(count($jenjab)>0)
			{
				foreach ($jenjab as $data) {
					echo "['" .$data->nama_jenis_jabatan . "'," . $data->jumlah ."],\n";
					//echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
				}
			}
			?>
		]
    }]
});
</script>
<!-- akhir pie chart Jenis Jabatan -->

<!-- awal bar chart tingpen -->
<script type="text/javascript">
Highcharts.chart('tingpen', {
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
        categories: ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
        title: {
            text: 'Tingkat Pendidikan'
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
			if(count($tingpen)>0)
			{
				echo "[";
				foreach ($tingpen as $data) {
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
<!-- akhir bar chart tingpen-->
