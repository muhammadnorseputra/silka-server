<!-- Default panel contents -->
<center>
  <div class="panel panel-default"  style="width: 99%">
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

  <div class="panel panel-success">  
  <div class="panel-heading" align="left">
  <b>PERIODE TPP</b><br />
  <?php //echo "Jumlah Data : ", $this->mkgb->getjmlpengantarbystatus(3), " Pengantar"; ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:100%;border:1px solid white" >
  <table class="table table table-condensed table-hover">
      <tr class='success'>
        <td align='center' rowspan='2'><b>No.</b></td>
        <td align='center' width='120' rowspan='2'><b>Periode</b></td>
        <td align='center' width='120' rowspan='2'><b>Jumlah ASN</b></td>
        <td align='center' width='120' colspan='5'><b>KRITERIA TPP</b></td>            
        <td align='right' width='120' rowspan='2'><b>TAMBAHAN<br/>Tunj. BPJS</b></td>
        <td align='right' width='120' rowspan='2'><b>TPP BRUTO</b></td>
        <td align='right' width='120' rowspan='2'><b>POTONGAN<br/>PPh21<br/>IWP<br/>BPJS</b></td>
        <td align='center' width='120' rowspan='2'><b>TPP NETTO</b></td>
        <td align='center' width='120' rowspan='2'><b>Status</b></td>
        <td align='center' rowspan='3'><b>Aksi</b></td>
      </tr>
      <tr class='success'>
        <td align='right'><b>Beban Kerja</b></td>
        <td align='right'><b>Prestasi Kerja</b></td>
        <td align='right'><b>Kondisi Kerja</b></td>
        <td align='right'><b>Kelangkaan Profesi</b></td>
        <td align='right'><b>Total Realisasi</b></td>
      </tr>
      <tr class='success' style='font-size: 9px; font-style: italic;'>
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
	 <td align='center'>13</td>
      </tr>

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
      ?>
        <tr>
        <td align='center'><?php echo $no; ?></td>
        <td align='left'><?php echo strtoupper(bulan($v['bulan']))." ".$v['tahun']; ?></td>
	<?php
	if ($this->session->userdata('level') == "ADMIN") {
		$totreal = $this->mtppng->gettotalreal_perperiode($v['id']);
	?>
        <td align='center'><?php echo $this->mtppng->get_jmlperperiode($v['id']); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalbk_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalpk_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalkk_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalkp_perperiode($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($totreal,0,",","."); ?></td>
        <?php
          $totalpph = number_format($this->mtppng->gettotalpph_perperiode($v['id']),0,",",".");
          $totaliwp = number_format($this->mtppng->gettotaliwp_perperiode($v['id']),0,",",".");
  	  $totalbpjs = $this->mtppng->gettotalbpjs_perperiode($v['id']);
          $totalthp = number_format($this->mtppng->gettotalthp_perperiode($v['id']),0,",",".");
          $bruto = $totreal + $totalbpjs;
	?>
	<td align='right'><?php echo "Rp. ".number_format($totalbpjs,0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($bruto,0,",",".");?></td>
	<td align='right'><?php echo "Rp. ".$totalpph."<br/>Rp. ".$totaliwp."<br/>Rp. ".number_format($totalbpjs,0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".$totalthp; ?></td>
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
	<td align='center'><span class='label label-danger'><?php echo $v['status']; ?></span></td>
        <td align='center'>
          <?php
          echo "<form method='POST' action='../tppng/detailperiode'>";
          echo "<input type='hidden' name='id_periode' id='id_periode' value='$v[id]'>";
          ?>
          <button type="submit" class="btn btn-success btn-xs ">
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
	$jmldata = $this->mtppng->get_jmlperperiode($v['id']);
	$rata_kinerja = $this->mtppng->getratakinerja_perperiode($v['id']);
	$rata_absensi = $this->mtppng->getrataabsensi_perperiode($v['id']);

	$total_bk = $this->mtppng->gettotalbk_perperiode($v['id']);
	$total_pk = $this->mtppng->gettotalpk_perperiode($v['id']);
        $total_kk = $this->mtppng->gettotalkk_perperiode($v['id']);
        $total_kp = $this->mtppng->gettotalkp_perperiode($v['id']);
	$totalpph = $this->mtppng->gettotalpph_perperiode($v['id']);
        $totaliwp = $this->mtppng->gettotaliwp_perperiode($v['id']);
        $totalbpjs = $this->mtppng->gettotalbpjs_perperiode($v['id']);
        $totalthp = $this->mtppng->gettotalthp_perperiode($v['id']);

	$gtotaldata = $gtotaldata + $jmldata;
        $gtotal_kinerja = $gtotal_kinerja + $rata_kinerja;
	$gtotal_absensi = $gtotal_absensi + $rata_absensi;
	$gtotal_bk = $gtotal_bk + $total_bk;
 	$gtotal_pk = $gtotal_pk + $total_pk;
        $gtotal_kk = $gtotal_kk + $total_kk;
        $gtotal_kp = $gtotal_kp + $total_kp;
        $gtotal_real = $gtotal_real + $totreal;
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
  <small>	
   <?php
   if ($this->session->userdata('level') == "ADMIN") {		
   ?>	
   <div class='row'>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-6'>Jumlah Periode</div>
          <div class='col-md-6' align='right'><?php echo $jmlperiode." Periode"; ?></div>
        </div>
	<div class='row'>
          <div class='col-md-7'>Rata-rata Jumlah ASN per Periode</div>
          <div class='col-md-5' align='right'><?php echo number_format($gtotaldata/$jmlperiode,2,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Rata-rata Kinerja per Tahun</div>
          <div class='col-md-6' align='right'><?php echo number_format($gtotal_kinerja/$jmlperiode,3,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Rata-rata Absensi per Tahun</div>
          <div class='col-md-6' align='right'><?php echo number_format($gtotal_absensi/$jmlperiode,3,",","."); ?></div>
        </div>
      </blockquote>
    </div>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-6'>Total Beban Kerja</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_bk,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Prestasi Kerja</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_pk,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Kondisi Kerja</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_kk,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Kelangkaan Profesi</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_kp,0,",","."); ?></div>
        </div>
      </blockquote>
    </div>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-6'>Total Realisasi</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_real,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Pot. PPh21</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_pph,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Pot. IWP</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_iwp,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Pot. BPJS</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($gtotal_bpjs,0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'><b>Total Take Home Pay</b></div>
          <div class='col-md-6' align='right'><b><?php echo "Rp. ".number_format($gtotal_thp,0,",","."); ?></b></div>
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
</div>
</div>
</center>
