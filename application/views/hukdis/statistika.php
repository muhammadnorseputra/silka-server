<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:540px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-info"   style="padding:3px;overflow:auto;width:90%;height:600px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>STATISTIK DATA HUKUMAN DISIPLIN</b>
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
    $cjml01 = $this->mhukdis->getjmlrwyhd('01',$thn);
    $cjml02 = $this->mhukdis->getjmlrwyhd('02',$thn);
    $cjml03 = $this->mhukdis->getjmlrwyhd('03',$thn);
    $cjml04 = $this->mhukdis->getjmlrwyhd('04',$thn);
    $cjml06 = $this->mhukdis->getjmlrwyhd('06',$thn);
    $cjml07 = $this->mhukdis->getjmlrwyhd('07',$thn);
    $cjml08 = $this->mhukdis->getjmlrwyhd('08',$thn);
    $cjml09 = $this->mhukdis->getjmlrwyhd('09',$thn);
    $cjml10 = $this->mhukdis->getjmlrwyhd('10',$thn);
    $cjml11 = $this->mhukdis->getjmlrwyhd('11',$thn);    
    $cjml12 = $this->mhukdis->getjmlrwyhd('12',$thn);

    $cjmlvalid = $this->mhukdis->getjmlusulhd('VALID',$thn);
    $cjmlnovalid = $this->mhukdis->getjmlusulhd('NO VALID',$thn); 
    $cjmlcetaksk = $this->mhukdis->getjmlusulhd('CETAK SK',$thn);   
  ?>
  <table class='table table-bordered'>
    <tr>
      <td width='35%'>
        <ul class="list-group">
          <li class="list-group-item list-group-item-success" ><center><b>REKAPITULASI HUKUMAN DISPLIN TAHUN 2019</b></center>
          </li>
          <li class="list-group-item"><small>TEGURAN LISAN</small>
          <span class="badge"><?php echo $cjml01; ?></span>
          </li>
          <li class="list-group-item"><small>TEGURAN TERTULIS</small>
          <span class="badge"><?php echo $cjml02; ?></span>
          </li>
          <li class="list-group-item"><small>PERNYATAAN TIDAK PUAS SECARA TERTULIS</small>
          <span class="badge"><?php echo $cjml03; ?></span>
          </li>
          <li class="list-group-item"><small>PENUNDAAN KGB SELAMA 1 TAHUN</small>
          <span class="badge"><?php echo $cjml04; ?></span>
          </li>
          <li class="list-group-item"><small>PENUNDAAN KENAIKAN PANGKAT SELAMA 1 TAHUN</small>
          <span class="badge"><?php echo $cjml06; ?></span>
          </li>
          <li class="list-group-item"><small>PENURUNAN PANGKAT 1 TINGKAT SELAMA 1 TAHUN</small>
          <span class="badge"><?php echo $cjml07; ?></span>
          </li>
          <li class="list-group-item"><small>PENURUNAN PANGKAT 1 TINGKAT SELAMA 3 TAHUN</small>
          <span class="badge"><?php echo $cjml08; ?></span>
          </li>
          <li class="list-group-item"><small>PEMINDAHAN DALAM RANGKA PENURUNAN JABATAN</small>
          <span class="badge"><?php echo $cjml09; ?></span>
          </li>
          <li class="list-group-item"><small>PEMBEBASAN JABATAN</small>
          <span class="badge"><?php echo $cjml10; ?></span>
          </li>
          <li class="list-group-item"><small>PEMBERHENTIAN DENGAN HORMAT TIDAK APS</small>
          <span class="badge"><?php echo $cjml11; ?></span>
          </li>
          <li class="list-group-item"><small>PEMBERHENTIAN TIDAK DENGAN HORMAT SEBAGAI PNS</small>
          <span class="badge"><?php echo $cjml12; ?></span>
          </li>
        </ul>
      </td>      
      <td width='40%' align='center'>
        <div class="panel-heading">
        LAPORAN HUKUMAN DISIPLIN YANG SEDANG DIPROSES HARI INI
        </div>
        
        <div class="panel-body">
          <div id="hukdis" style="height: 350px; width: 400px"></div>

          <!--<a href="#" class="btn btn-default btn-block">View Details</a>-->
        </div>

        <!-- untuk pemanggilan Pie Chart Jenis Jabatan-->
        <script type="text/javascript">
        Highcharts.chart('hukdis', {
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
                  echo "['Laporan Masuk', $cjmlnovalid],\n";                  
                  echo "['Laporan Disetujui', $cjmlvalid],\n";                                    
                  echo "['Cetak SK', $cjmlcetaksk],\n";
                  /*if(count($grafik)>0)
                  {
                    foreach ($grafik as $datac) {
                      if ($datac->status == 'VALID') {
                        echo "['Usul Masuk / Tunggu Validasi'," . $tvalid ."],\n";
                      } else if ($datac->status == 'NO VALID') {
                        echo "['Usul Disetujui'," . $tnovalid ."],\n";
                      }
                    }
                  } 
                  */                 
                ?>
              ]
            }]
        });
        </script>
        <!-- akhir pie chart Jenis Jabatan -->
      </td>
      <td>
        <table class='table table-hover table-bordered'>
          <tr class='success'>
            <td width='50'><center><b>TAHUN</b></center></td>
            <td width='30'><center><b>TOTAL PELANGGARAN</b></center></td>
          </tr>
          <?php
            $no = 1;
            foreach($thnhd as $v):        
            $thn =  $v['tahun'];
            $jml = $this->mhukdis->getjmlrwybythnstatus($thn);

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
    </tr>
  </table>

  
  </div>
</div>
</div>
</center>