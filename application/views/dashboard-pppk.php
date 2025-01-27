<div class="col-lg-12 col-md-12">
<div class="row">
    <div class="col-lg-4 col-md-4">
	<div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Golongan Ruang
            </div>
            <div class="panel-body">
                <div id="golru_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>	
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Kelompok Tugas
            </div>
            <div class="panel-body">
                <div id="pokgas_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Jenis Kelamin
            </div>
            <div class="panel-body">
                <div id="jenkel_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
</div> <!-- End Row 1 -->

<div class="row"> <!-- Row 2 --> 
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Tingkat Pendidikan
            </div>
            <div class="panel-body">
                <div id="tingpen_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Agama
            </div>
            <div class="panel-body">
                <div id="agama_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Status Kawin
            </div>
            <div class="panel-body">
                <div id="statkaw_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
</div> <!-- End Row 2 -->
<div class="row"> <!-- Row 3 -->
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Kelompok Usia
            </div>
            <div class="panel-body">
                <div id="kelusia_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i>Jumlah PPPK Berdasarkan Awal Kontrak Kerja
            </div>
            <div class="panel-body">
                <div id="awalkontrak_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
         <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Jumlah PPPK Berdasarkan Akhir Kontrak Kerja
            </div>
            <div class="panel-body">
                <div id="akhirkontrak_pppk" style="height: 100%; width: 100%"></div>
            </div>
        </div>
    </div>
</row> <!-- End Row 3 -->
</div>
</div>
<!-- untuk pemanggilan Chart -->
<script type="text/javascript">
Highcharts.chart('golru_pppk', {
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
        categories: ['V', 'VII', 'IX', 'X'],
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
        colorByPoint: true,
        data :
        <?php
		$golru_pppk = $this->mgraph->golru_pppk();
                if(count($golru_pppk)>0)
                {
                	echo "[";
                        foreach ($golru_pppk as $data) {
                        	echo $data->jumlah .",";
                        }
                        echo "]";
                }
        ?>
    }]
});

Highcharts.chart('jenkel_pppk', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: true,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Jumlah : <b>{point.y:f}</b><br />{series.name}: <b>{point.percentage:.1f}%</b>'
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
        name: 'Persen ',
        colorByPoint: true,
        data: [
              <?php
			$jk_pppk = $this->mgraph->jenkel_pppk();
                        // data yang diambil dari database
                        if(count($jk_pppk)>0)
                        {
                                foreach ($jk_pppk as $data) {
                                        if ($data->jns_kelamin == 'PRIA') {
                                                $jenkel_pppk = 'LAKI-LAKI';
                                        } else if ($data->jns_kelamin == 'WANITA') {
                                                $jenkel_pppk = 'PEREMPUAN';
                                        }

                                        echo "['" .$jenkel_pppk . "'," . $data->jml ."],\n";
                                }
                        }
              ?>
              ]
    }]
});

Highcharts.chart('pokgas_pppk', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: true,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Jumlah : <b>{point.y:f}</b><br />{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                        format: '{point.name}<br/>{point.y:f} ({point.percentage:.1f} %)',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                },
                showInLegend: false
            }

    },
    series: [{
        type : 'pie',
        name: 'Persen ',
        colorByPoint: true,
        data: [
              <?php
                        $pg_pppk = $this->mgraph->pokgas_pppk();
                        // data yang diambil dari database
                        if(count($pg_pppk)>0)
                        {
                                foreach ($pg_pppk as $data) {
                                        if ($data->kelompok_tugas == 'KESEHATAN') {
                                                $pokgas_pppk = 'KESEHATAN';
                                        } else if ($data->kelompok_tugas == 'TEKNIS') {
                                                $pokgas_pppk = 'TEKNIS';
                                        } else if ($data->kelompok_tugas == 'PENDIDIKAN') {
                                                $pokgas_pppk = 'PENDIDIKAN';
                                        } else if ($data->kelompok_tugas == 'PENYULUH') {
                                                $pokgas_pppk = 'PENYULUH';
                                        }

                                        echo "['" .$pokgas_pppk . "'," . $data->jumlah ."],\n";
                                }
                        }
              ?>
              ]
    }]
});	

Highcharts.chart('tingpen_pppk', {
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
        //categories: ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
	categories:
	<?php
		$tingpen_pppk = $this->mgraph->tingpen_pppk();
                // data yang diambil dari database
                if(count($tingpen_pppk) > 0)
                {
                	echo "[";
                        foreach ($tingpen_pppk as $data) {
                        	echo "'",$data->nama_tingkat_pendidikan ."',";
	                }
                        echo "],";
                }
        ?>
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
        colorByPoint: true,
        data :
        <?php
			$tingpen_pppk = $this->mgraph->tingpen_pppk();
                        // data yang diambil dari database
                        if(count($tingpen_pppk) > 0)
                        {
                                echo "[";
                                foreach ($tingpen_pppk as $data) {
                                        //echo $data->jumlah .",";
                                        echo $data->jumlah .",";
                                        //echo "['" .$jenkel . " (".$data->jumlah.")'," . $data->jumlah ."],\n";
                                }
                                echo "]";
                        }
                        ?>
    }]
});

Highcharts.chart('agama_pppk', {
    chart: {
        type: 'pie',
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: 'Jumlah : <b>{point.y:f}</b><br />{series.name}: <b>{point.percentage:.1f}%</b>'
        //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    subtitle: {
        text: ''
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            //depth: 30,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
               enabled: true,
               format: '{point.name} : {point.y:f} [{point.percentage:.1f} %]',
               style: {
                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
               }
            },
            showInLegend: true
        },
    },
    series: [{
        name: 'Persentase',
        data: [
                <?php
                $agama_pppk = $this->mgraph->agama_pppk();
                foreach ($agama_pppk as $data) {
                    echo "['".$data->nama_agama."',".$data->jumlah ."],\n";
                }
                ?>
        ],
        //size: 150,
    }]
});

Highcharts.chart('statkaw_pppk', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 30
        }
    },
    title: {
        text: ''
    },
    credits: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Jumlah : <b>{point.y:f}</b><br />{series.name}: <b>{point.percentage:.1f}%</b>'
        //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    subtitle: {
        text: ''
    },
    plotOptions: {
        pie: {
            innerSize: 0,
            depth: 30,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
               enabled: true,
               format: '{point.name}<br/>{point.y:f} [{point.percentage:.1f} %]',
               style: {
                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
               }
            },
            showInLegend: true
        },
    },
    series: [{
        name: 'Persentase',
        data: [
                <?php
                $statkaw_pppk = $this->mgraph->jmlstatkaw_pppk();
                foreach ($statkaw_pppk as $data) {
                    echo "['".$data->nama_status_kawin."',".$data->jumlah ."],\n";
                }
                ?>
        ],
        //size: 150,
    }]
});

Highcharts.chart('kelusia_pppk', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    credits: {
        enabled: false
    },
    xAxis: {
        categories: ['18-25', '26-30', '31-35', '36-40', '41-45', '46-50', '51-55', '56-60'],
        title: {
            text: 'Kelompok Usia'
        }
    },
    yAxis: {
        min: 0,
        title: {
                text: 'Jumlah'
        },
        stackLabels: {
                enabled: false,
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
        enabled: false
    },

    tooltip: {
        headerFormat: 'Kelompok Usia <b>{point.x}</b><br/>',
        pointFormat: 'Jumlah: {point.y}'
    },
    plotOptions: {
        column: {
                //stacking: 'normal',
                dataLabels: {
                        enabled: true,
                },
        }
    },
    series: [{
        //name: 'Jumlah',
        colorByPoint: true,
        data: [
                <?php
                $j1825 = $this->mgraph->jmlkelusia_pppk(18, 25.99);
                echo "['18-25',".$j1825."],\n";

                $j2630 = $this->mgraph->jmlkelusia_pppk(26, 30.99);
                echo "['26-30',".$j2630."],\n";

                $j3135 = $this->mgraph->jmlkelusia_pppk(31, 35.99);
                echo "['31-35',".$j3135."],\n";

                $j3640 = $this->mgraph->jmlkelusia_pppk(36, 40.99);
                echo "['36-40',".$j3640."],\n";

                $j4145 = $this->mgraph->jmlkelusia_pppk(41, 45.99);
                echo "['41-45',".$j4145."],\n";

                $j4650 = $this->mgraph->jmlkelusia_pppk(46, 50.99);
                echo "['46-50',".$j4650."],\n";

                $j5155 = $this->mgraph->jmlkelusia_pppk(51, 55.99);
                echo "['51-55',".$j5155."],\n";

                $j5660 = $this->mgraph->jmlkelusia_pppk(56, 60.99);
                echo "['56-60',".$j5660."],\n";
                ?>
    ]
    }]
});

Highcharts.chart('akhirkontrak_pppk', {
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
        //categories: ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
        categories:
        <?php
                $akhirkontrak_pppk = $this->mgraph->akhirkontrak_pppk();
                // data yang diambil dari database
                if(count($akhirkontrak_pppk) > 0)
                {
                        echo "[";
                        foreach ($akhirkontrak_pppk as $data) {
                                echo "'",tgl_indo($data->tmt_pppk_akhir)."',";
                        }
                        echo "],";
                }
        ?>
        title: {
            text: 'Akhir Kontrak Kerja'
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
        colorByPoint: true,
        data :
        <?php
                        $akhirkontrak_pppk = $this->mgraph->akhirkontrak_pppk();
                        // data yang diambil dari database
                        if(count($akhirkontrak_pppk) > 0)
                        {
                                echo "[";
                                foreach ($akhirkontrak_pppk as $data) {
                                        echo $data->jumlah .",";
                                }
                                echo "]";
                        }
                        ?>
    }]
});

Highcharts.chart('awalkontrak_pppk', {
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
                $awalkontrak_pppk = $this->mgraph->awalkontrak_pppk();
                // data yang diambil dari database
                if(count($awalkontrak_pppk) > 0)
                {
                        echo "[";
                        foreach ($awalkontrak_pppk as $data) {
                                echo "'",tgl_indo($data->tmt_pppk_awal)."',";
                        }
                        echo "],";
                }
        ?>
        title: {
            text: 'Awal Kontrak Kerja'
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
        colorByPoint: true,
        data :
        <?php
		$awalkontrak_pppk = $this->mgraph->awalkontrak_pppk();
                // data yang diambil dari database
                if(count($awalkontrak_pppk) > 0)
                {
                  echo "[";
                  foreach ($awalkontrak_pppk as $data) {
                    echo $data->jumlah .",";
                  }
                  echo "]";
                }
       ?>
    }]
});


</script>
<!-- akhir pie chart -->
