<!-- Default panel contents -->
<!-- <center>
  <div class="panel panel-default" style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-warning btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 
-->
  <?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>

  <div class="panel panel-info">  
  <div class="panel-heading" align="center">
  <b>TPP TAHUN 2025</b><br />
  <?php //echo "Jumlah Data : ", $this->mkgb->getjmlpengantarbystatus(3), " Pengantar"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:5px;overflow:auto;width:100%;height:100%;border:1px solid white" >

  <table class="table table table-condensed table-hover">
<!--
      <tr class='info'>
        <td align='center' rowspan='2'><b>NO.</b></td>
        <td align='center' width='120' rowspan='2'><b>PERIODE</b></td>
        <td align='center' width='50' rowspan='2'><b>JML ASN</b></td>
        <td align='center' width='120' colspan='5'><b>KRITERIA TPP</b></td>            
        <td align='right' width='170' rowspan='2'><b>TAMBAHAN<br/>PPh21<br/>BPJS 4%</b></td>
        <td align='right' width='170' rowspan='2'><b>TPP BRUTO</b></td>
        <td align='right' width='170' rowspan='2'><b>POTONGAN<br/>PPh21<br/>IWP 1%<br/>BPJS 4%</b></td>
        <td align='center' width='170' rowspan='2'><b>TPP NETTO</b></td>
        <td align='center' rowspan='3'><b>Aksi</b></td>
      </tr>
      <tr class='info'>
        <td align='right' width='150'><b>Beban Kerja</b></td>
        <td align='right' width='150'><b>Prestasi Kerja</b></td>
        <td align='right' width='150'><b>Kondisi Kerja</b></td>
        <td align='right' width='150'><b>Kelangkaan Profesi</b></td>
        <td align='right' width='150'><b>Total Realisasi</b></td>
      </tr>
      <tr class='info' style='font-size: 9px; font-style: italic;'>
        <td align='center'>1</td>
        <td align='center'>2</td>
        <td align='center'>3</td>
        <td align='center'>4</td>
        <td align='center'>5</td>
        <td align='center'>6</td>
        <td align='center'>7</td>
        <td align='center'>8 (4+5+6+7)</td>
        <td align='center'>9</td>
        <td align='center'>10 (8+9)</td>
        <td align='center'>11</td>
	<td align='center'>12 (10-11)</td>
      </tr>
-->
      <?php
        $no = 1;
	
	$jmlperiode = 0;
	$gtotaldata = 0;
        $gtotal_kinerja = 0;
        $gtotal_absensi = 0;
	$gtotal_bk = 0;
	$gtotal_pk = 0;
	$gtotal_kk = 0;
	$gtotal_kp = 0;
	$gtotal_real = 0;
	$gtotal_pph = 0;
	$gtotal_iwp = 0;
	$gtotal_bpjs = 0;
	$gtotal_thp = 0;
	$gtotal_bruto = 0;
	$gtotal_thp = 0;	
	
        foreach($periode as $v):          
	//var_dump($v);
	if ($v['status'] == "OPEN") {
	  //$stcolor = "#BDE7BD";	// green
	  $stcolor = "#D9EDF7"; // blue bootstrap
	} else if ($v['status'] == "CLOSE") {
	  //$stcolor = "#FFD5D4"; // red
	  $stcolor = "#F5F5F5"; // default bootstrap
	}
      ?> 	
       <!-- Model Kotak -->
  	<!-- <div class="row"> -->
   	 <div class="col-sm-3 col-md-3">
    	  <div class="thumbnail">
      	    <!-- <img src="..." alt="..."> -->
      	    <div class="caption" style='background-color: <?php echo $stcolor; ?>'>
            	<h3 align='center'><?php echo strtoupper(bulan($v['bulan']))." ".$v['tahun']; ?></h3>
		<div class="row">
		  <div class="col-xs-6 col-md-6" align='left'>Jml ASN</div>
		  <div class="col-xs-6 col-md-6" align='right'><?php echo 1726;//$this->mtppng2025->get_jmlperperiode($v['id']); ?> ASN</div>
		</div>
                <div class="row">
                  <div class="col-xs-6 col-md-6" align='left'>1. Beban Kerja</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "3.704.295.788";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-6" align='left'>2. Prestasi Kerja</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "5.763.582.232";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-6" align='left'>3. Kondisi Kerja</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "3.436.233.744";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-6" align='left'>4. Kelangkaan Profesi</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "393.573.955";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
		 <span class='text text-success'>
                  <div class="col-xs-6 col-md-7" align='left'>5. Total Realisasi (1+2+3+4)</div>
                  <div class="col-xs-6 col-md-5" align='right'><?php echo "13.297.685.719";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
		 </span>
                </div>
                <div class="row" style='padding-top:5px;'>
                  <div class="col-xs-6 col-md-6" align='left'>6. PPh 21</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "1.078.377.590";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-6" align='left'>7. BPJS 4%</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "399.133.868";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
		  <span class='text text-primary'>
                  <div class="col-xs-6 col-md-6" align='left'>8. BRUTO (5+6+7)</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "14.775.197.177";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
		 </span>
                </div>
                <div class="row" style='padding-top:5px;'>
                  <div class="col-xs-6 col-md-6" align='left'>9. IWP 1%</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "99.444.337";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
                </div>
                <div class="row">
		 <span class='text text-danger'>
                  <div class="col-xs-7 col-md-7" align='left'>10. Total Potongan (6+7+9)</div>
                  <div class="col-xs-5 col-md-5" align='right'><?php echo "1.576.955.795";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
		 </span>
                </div>
                <div class="row" style='padding-top:5px;'>
		 <span class='text text-primary'> 
                  <div class="col-xs-6 col-md-6" align='left'>11. NETTO (8-10)</div>
                  <div class="col-xs-6 col-md-6" align='right'><?php echo "13.198.241.382";//$this->mtppng2025->get_jmlperperiode($v['id']); ?> IDR</div>
		 </span>
                </div>
            	<p align='right' style='padding-top:10px;'>
		<?php if ($v['status'] == "OPEN") { ?>
          	  <form method='POST' action='../tppng2025/detailperiode'>
          	    <input type='hidden' name='id_periode' id='id_periode' value='<?php echo $v['id']; ?>'>
          	    <button type="submit" class="btn btn-success">
          	    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> OPEN
          	    </button>
            	  </form>
		<?php } else if ($v['status'] == "CLOSE") { ?>
		  <button type="#" class="btn btn-danger" disabled>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> CLOSE
                    </button>
		<?php } ?>
		</p>
      	    </div> <!-- End Caption -->
    	  </div> <!-- End Thumbnail -->
   	 </div> <!-- End Kolom -->
  	<!-- </div> End Row -->

        <tr>
        <td align='center'><?php echo $no; ?></td>
        <td align='left'><?php echo strtoupper(bulan($v['bulan']))." ".$v['tahun']; ?></td>
	<?php
	if ($this->session->userdata('level') == "ADMIN") {
		$totreal = $this->mtppng2025->gettotalreal_perperiode($v['id']);
	?>
        <td align='center'><?php echo $this->mtppng2025->get_jmlperperiode($v['id']); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalbk_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalpk_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalkk_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalkp_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($totreal,0,",","."); ?></td>
        <?php
          $totalpph = $this->mtppng2025->gettotalpph_perperiode($v['id']);
          $totaliwp = $this->mtppng2025->gettotaliwp_perperiode($v['id']);
  	  $totalbpjs = $this->mtppng2025->gettotalbpjs_perperiode($v['id']);
          $totalthp = $this->mtppng2025->gettotalthp_perperiode($v['id']);

	  $tottamb = $totalpph + $totalbpjs;
	  $totpot = $totalpph + $totaliwp + $totalbpjs;
          $bruto = $totreal + $totalbpjs;
	?>
	<td align='right'><?php echo "<span class='pull-left'>PPh.</span>Rp. ".number_format($totalpph,0,",",".").
		"<br/><span class='pull-left'>BPJS</span>Rp. ".number_format($totalbpjs,0,",",".").
		"<br/><span class='text text-success'><b>Rp. ".number_format($tottamb,0,",",".")."</b></span>"; ?>
	
	</td>
        <td align='right'><?php echo "Rp. ".number_format($bruto,0,",",".");?></td>
	<td align='right'><?php echo "<span class='pull-left'>PPh.</span>Rp. ".number_format($totalpph,0,",",".").
		"<br/><span class='pull-left'>IWP.</span>Rp. ".number_format($totaliwp,0,",",".").
		"<br/><span class='pull-left'>BPJS.</span>Rp. ".number_format($totalbpjs,0,",",".").
		"<br/><span class='text text-danger'><b>Rp. ".number_format($totpot,0,",",".")."</b></span>"; ?>
	</td>
        <td align='right'>
		<?php echo "<span class='pull-left'>Real.</span>Rp. ".number_format($totreal,0,",",".").
                "<br/><span class='pull-left'>Tamb.</span>Rp. ".number_format($tottamb,0,",",".").
                "<br/><span class='pull-left'>Pot.</span>Rp. ".number_format($totpot,0,",",".").
                "<br/><span class='text text-primary pull-left'>THP</span><b><span class='text text-primary'>Rp. ".number_format($totalthp,0,",",".")."</span></b></span>"; ?>
	</td>
        <?php
	} else {
		
		echo "<td align='right'>#####</td>";
		echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
                echo "<td align='right'>#####</td>";
	}
	?>
        <td align='center'>
	    <?php 
		if ($v['status'] == 'OPEN') {
			echo "<span class='label label-success'>OPEN</span>"; 
		} else if ($v['status'] == 'CLOSE') {
                        echo "<span class='label label-danger'>CLOSE</span>";
                }
	    ?>
	  <br/><br/>
          <?php
          echo "<form method='POST' action='../tppng2025/detailperiode'>";
          echo "<input type='hidden' name='id_periode' id='id_periode' value='$v[id]'>";
          ?>
          <button type="submit" class="btn btn-info btn-sm btn-outline">
          <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Detail Periode
          </button>
          <?php
            echo "</form>";
          ?>
        </td>        
      </tr>
      <?php
       if ($this->session->userdata('level') == "ADMIN") {	
	$jmlperiode = $jmlperiode + 1;
	$jmldata = $this->mtppng2025->get_jmlperperiode($v['id']);
	$rata_kinerja = $this->mtppng2025->getratakinerja_perperiode($v['id']);
	$rata_absensi = $this->mtppng2025->getrataabsensi_perperiode($v['id']);

	$total_bk = $this->mtppng2025->gettotalbk_perperiode($v['id']);
	$total_pk = $this->mtppng2025->gettotalpk_perperiode($v['id']);
        $total_kk = $this->mtppng2025->gettotalkk_perperiode($v['id']);
        $total_kp = $this->mtppng2025->gettotalkp_perperiode($v['id']);
	$total_real = $total_bk + $total_pk + $total_kk + $total_kp;

	$totalpph = $this->mtppng2025->gettotalpph_perperiode($v['id']);
        $totaliwp = $this->mtppng2025->gettotaliwp_perperiode($v['id']);
        $totalbpjs = $this->mtppng2025->gettotalbpjs_perperiode($v['id']);
        $totalthp = $this->mtppng2025->gettotalthp_perperiode($v['id']);

	$gtotaldata = $gtotaldata + $jmldata;
        $gtotal_kinerja = $gtotal_kinerja + $rata_kinerja;
	$gtotal_absensi = $gtotal_absensi + $rata_absensi;
	$gtotal_bk = $gtotal_bk + $total_bk;
 	$gtotal_pk = $gtotal_pk + $total_pk;
        $gtotal_kk = $gtotal_kk + $total_kk;
        $gtotal_kp = $gtotal_kp + $total_kp;
	$gtotal_real = $gtotal_bk + $gtotal_pk + $gtotal_kk + $gtotal_kp;
	
        //$gtotal_real = $gtotal_real + $totreal;
        $gtotal_pph = $gtotal_pph + $totalpph;
        $gtotal_iwp = $gtotal_iwp + $totaliwp;
        $gtotal_bpjs = $gtotal_bpjs + $totalbpjs;
        $gtotal_thp = $gtotal_thp + $totalthp;
        $gtotal_bruto = $gtotal_bruto + $bruto;
       }	

       $no++;
       endforeach;
      ?>
  </table>
  </div> <!-- End Scroll bar -->
  <small>	
   <?php
   if ($this->session->userdata('level') == "ADMIN") {		
   ?>	
   <div class='row'>
    <div class='col-xs-12 col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Jumlah Periode</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo $jmlperiode." Periode"; ?></div>
        </div>
	<div class='row'>
          <div class='col-xs-7 col-md-7'>Rata-rata Jumlah ASN per Periode</div>
          <div class='col-xs-5 col-md-5' align='right'><?php echo number_format($gtotaldata/$jmlperiode,2,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Rata-rata Kinerja per Tahun</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo number_format($gtotal_kinerja/$jmlperiode,3,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Rata-rata Absensi per Tahun</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo number_format($gtotal_absensi/$jmlperiode,3,",","."); ?></div>
        </div>
      </blockquote>
    </div>
    <div class='col-xs-12 col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Beban Kerja</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_bk,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Prestasi Kerja</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_pk,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Kondisi Kerja</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_kk,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Kelangkaan Profesi</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_kp,0,",","."); ?></div>
        </div>
        <div class='row text text-success'>
          <div class='col-xs-6 col-md-6'><b>Total Realisasi</b></div>
          <div class='col-xs-6 col-md-6' align='right'><b><?php echo "Rp. ".number_format($gtotal_real,0,",","."); ?></b></div>
        </div>
      </blockquote>
    </div>
    <div class='col-xs-12 col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Tamb. PPh21</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_pph,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Tamb. BPJS</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_bpjs,0,",","."); ?></div>
        </div>
        <div class='row text text-success'>
          <div class='col-xs-6 col-md-6'><b>Total Tambahan</b></div>
          <div class='col-xs-6 col-md-6' align='right'><b><?php echo "Rp. ".number_format($gtotal_pph + $gtotal_bpjs,0,",","."); ?></b></div>
        </div>
      </blockquote>
    </div>
    <div class='col-xs-12 col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Pot. PPh21</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_pph,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Pot. IWP</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_iwp,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-xs-6 col-md-6'>Total Pot. BPJS</div>
          <div class='col-xs-6 col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_bpjs,0,",","."); ?></div>
        </div>
        <div class='row text text-danger'>
          <div class='col-xs-6 col-md-6'><b>Total Potongan</b></div>
          <div class='col-xs-6 col-md-6' align='right'><b><?php echo "Rp. ".number_format($gtotal_pph + $gtotal_iwp + $gtotal_bpjs,0,",","."); ?></b></div>
        </div><br/>
        <div class='row text text-primary'>
          <div class='col-xs-6 col-md-6'><b>TOTAL TAKE HOME PAY</b></div>
          <div class='col-xs-6 col-md-6' align='right'><b><?php echo "Rp. ".number_format($gtotal_thp,0,",","."); ?></b></div>
        </div>
      </blockquote>
    </div>
   </div> <!-- End ROW
   <?php
   } // End If Grand Total
   ?>
  </small> 
</div>
</div>

<!--
</div>
</div>
</center>
-->
