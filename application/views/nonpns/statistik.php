<form method="POST" action="../nonpns/tampilunker">
  <!--
  <p align="right">
  <button type="submit" class="btn btn-danger btn-sm">
  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
  </button>
  </p>
  -->
</form>
<!-- /.row -->
<div class="row" style="height: 125px;">
     <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah Non PNS Berdasarkan Tugas Pekerjaan
                <div class="pull-right">
                </div>
            </div>
            <div class="panel-body">
                <div id="tugas" style="height: 750px; width: 400px"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    

    <div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah Non PNS Berdasarkan Jenis
            </div>
            <div class="panel-body">
                <div id="jenis" style="height: 400px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>    
    
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-group fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                            echo $this->mnonpns->jmlnonpns();
                        ?>                          
                        </div>
                        <div>Total Non PNS</div>
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left"></span>
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
                        <i class="fa fa-dollar fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php                           
                            echo $this->mnonpns->jmlnonpns_apbd();
                        ?>  
                        </div>
                        <div>Sumber Gaji APBD</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>    
</div>

<div class="row">

    <div class="col-lg-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah Non PNS Berdasarkan Sumber Gaji
            </div>
            <div class="panel-body">
                <div id="gaji" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
       

	<!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah Non PNS Berdasarkan Tingkat Pendidikan
            </div>
            <div class="panel-body">
                <div id="tingpen" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>

	<div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah Non PNS Berdasarkan Jenis Kelamin
            </div>
            <div class="panel-body">
                <div id="jenkel" style="height: 250px; width: 400px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Perbandingan Jumlah Non PNS per Unit Kerja
            </div>
            <div class="panel-body">
                <div id="perinstansi" style="height: 750px"></div>

                <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

    

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
    credits: {
        enabled: false
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
					if ($data->jns_kelamin == 'PRIA') {
						$jenkel = 'PRIA';
					} else if ($data->jns_kelamin == 'WANITA') {
						$jenkel = 'WANITA';
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
Highcharts.chart('tugas', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    subtitle: {
        //text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        categories: 
        <?php 
            // data yang diambil dari database
            if(count($jabnonpns)>0)
            {
                echo "[";
                foreach ($jabnonpns as $data) {
                    //echo $data->jumlah .",";
                    echo "'". $data->nama_jabnonpns ."' ,";
                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                }
                echo "],";
            }
            ?>
        //['STAF', 'DOKTER', 'LAIN-LAIN', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'],
        title: {
            text: ''
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
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
			if(count($jabnonpns)>0)
			{
				echo "[";
				foreach ($jabnonpns as $data) {
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
Highcharts.chart('jenis', {
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
        categories: 
        <?php 
            // data yang diambil dari database
            if(count($jnshon)>0)
            {
                echo "[";
                foreach ($jnshon as $data) {
                    //echo $data->jumlah .",";
                    echo "'". $data->nama_jenis_nonpns ."', ";
                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                }
                echo "],";
            }
            ?>
        // ['HONORER', 'KOMITE', 'PTT KAB', 'PTT PROV', 'PTT PUSAT', 'KONTRAK', 'THL', 'TKS'],
        title: {
            text: ''
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
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
			if(count($jnshon)>0)
			{
				echo "[";
				foreach ($jnshon as $data) {
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

<!-- untuk pemanggilan Pie Chart Sumber Gaji-->
<script type="text/javascript">
Highcharts.chart('gaji', {
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
    credits: {
        enabled: false
    },
    series: [{
    	type : 'pie',
        name: 'Persentase ',
        colorByPoint: true,
        data: [
        	<?php 
			// data yang diambil dari database
			if(count($sumgaji)>0)
            {   
                foreach ($sumgaji as $data) {
                    if ($data->nama_sumbergaji == 'APBN') {
                        $sumgaji = 'APBN';
                    } else if ($data->nama_sumbergaji == 'APBD') {
                        $sumgaji = 'APBD';
                    } else if ($data->nama_sumbergaji == 'SWADANA') {
                        $sumgaji = 'SWADANA';
                    } else if ($data->nama_sumbergaji == 'DANABOS') {
                        $sumgaji = 'DANA BOS';
                    } else if ($data->nama_sumbergaji == 'YAYASAN') {
                        $sumgaji = 'YAYASAN';
                    }

                    echo "['" .$sumgaji . "'," . $data->jumlah ."],\n";
                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                }
            }
			?>
		]
    }]
});
</script>
<!-- akhir pie chart Sumber Gaji -->

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
        categories: 
        <?php 
            // data yang diambil dari database
            if(count($tingpen)>0)
            {
                echo "[";
                foreach ($tingpen as $data) {
                    //echo $data->jumlah .",";
                    echo "'". $data->namatingpen ."', ";

                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                }
                echo "],";
            }
            ?>
        //['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
        title: {
            text: ''
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
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

<!-- awal bar chart perunor -->
<script type="text/javascript">
Highcharts.chart('perinstansi', {
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
        categories: 
        <?php 
            // data yang diambil dari database
            if(count($perinstansi)>0)
            {
                echo "[";
                foreach ($perinstansi as $data) {
                    //echo $data->jumlah .",";
                    echo "'". $data->namainstansi ."', ";

                    //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                }
                echo "],";
            }
            ?>
        //['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
        title: {
            text: ''
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
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
            if(count($perinstansi)>0)
            {
                echo "[";
                foreach ($perinstansi as $data) {
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
<!-- akhir bar chart perunor-->
