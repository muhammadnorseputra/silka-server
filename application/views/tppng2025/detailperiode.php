<script type="text/javascript">
  //validasi textbox khusus angka
  function validAngka(a)
  {
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }

  function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
      {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
      }
    if (window.ActiveXObject)
      { 
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }

  function showDataBendahara(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilSpesimenBendahara";
    url=url+"?nip="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataBendahara;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataBendahara(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilbendahara").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilbendahara").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  function showDataKepala(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilSpesimenKepala";
    url=url+"?nip="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataKepala;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataKepala(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkepala").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkepala").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

</script>

<!-- Default panel contents -->
<center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <?php
        if ($this->session->userdata('level') == "ADMIN") {
      ?>
      <td align='right'>
        <button type="button" class="btn btn-danger btn-outline" data-toggle="modal" data-target="#updatestatus<?php echo $idperiode; ?>">
        <span class="fa fa-pencil" aria-hidden="true"></span> Update Status Unit Kerja</button>
      </td>
      <?php
        }
      ?>	      
      <?php
	//if ($this->mtppng2025->get_statusperiode($idperiode) == "OPEN") {
	//if ($this->session->userdata('level') == "ADMIN") {
      ?>  
      <td align='right' width='50'>
	<?php
        //$statuspengantar = $this->mtppng2025->get_statuspengantar($idpengantar);
        $tahunperiode = $this->mtppng2025->get_tahunperiode($idperiode);
        $bulanperiode = $this->mtppng2025->get_bulanperiode($idperiode);
        //if (($statuspengantar == "SKPD") AND (($this->session->userdata('nip') == "198104072009041002") OR ($this->session->userdata('nip') == "197708232006042022"))) {
        //if ($statuspengantar == "SKPD") {
	if ($this->mtppng2025->get_statusperiode($idperiode) == "OPEN") {
          if (($tahunperiode == '2025') AND ($bulanperiode == '15') AND ($this->mtppng2025->get_statusperiode($idperiode) == "OPEN")) { // Tambah Data THR
            ?>
                <button type="button" class="btn btn-outline btn-success" data-toggle="modal" data-target="#tampiltambahthr"><span class="fa fa-plus-square-o" aria-hidden="true"></span> Tambah Unit Kerja TPP-13 2025</button>
            <?php
          } else if (($tahunperiode == '2025') AND ($bulanperiode != '14')) {
            ?>
                <button type="button" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#tampiltambah"><span class="fa fa-plus" aria-hidden="true"></span> Tambah Unit Kerja</button>
            <?php
          }
        }
        ?>

	<!--
        <button type="button" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#tampiltambah">
	<span class="fa fa-plus" aria-hidden="true"></span> Tambah Unit Kerja</button>
	-->
      </td>
      <?php
        //} 
      ?>
     
      <td align='right' width='50'>
        <form method="POST" action="../tppng2025/periode">
          <button type="submit" class="btn btn-warning btn-outline">
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

  <div class="panel panel-info">  
  <div class="panel-heading" align="left">
  <b>KALKULASI TPP</b>
  <?php
    $blnperiode = $this->mtppng2025->get_bulanperiode($idperiode);
    $thnperiode = $this->mtppng2025->get_tahunperiode($idperiode);
    echo "<b>PERIODE ".strtoupper(bulan($blnperiode))." ".$thnperiode."</b>"; 
    $status = $this->mtppng2025->get_statusperiode($idperiode);
    echo "<br/><span class='text text-danger'>STATUS : ".$status." CALCULATION</span>";
  ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:550px;border:1px solid white" >
  <table class="table table table-condensed table-hover"  style='font-size: 11px;'>
      <tr class='info'>
        <td align='center' rowspan='2' width='10'><b>NO.</b></td>
        <td align='center' width='250' rowspan='2'><b>UNIT KERJA</b></td>
        <td align='center' width='100' rowspan='2'><b>RATA KINERJA<br/>RATA ABSENSI</b></td>
        <td align='center' width='100' rowspan='2'><b>JENIS<br/>JML DATA<br/>JML BERHAK TPP</b></td>
        <td align='center' colspan='4'><b>TOTAL KRITERIA</b></td>            
        <td align='center' width='120' rowspan='2'><b>TOTAL REALISASI</b></td>
        <td align='center' width='150' rowspan='2'><b>TAMBAHAN<br/>PPh21<br/>BPJS 4%</b></b></td>
        <td align='center' width='150' rowspan='2'><b>POTONGAN<br/>PPh21<br/>IWP 1%<br/>BPJS 4%</b></td>
        <td align='center' width='150' rowspan='2'><b>TAKE HOME PAY</b></td>
        <td align='center' width='80' rowspan='3'><b>STATUS</b></td>
        <td align='center' rowspan='3' colspan='2' width='50'><b>AKSI</b></td>
      </tr>
      <tr class='info'>
        <td align='center' width='110'><b>Beban Kerja</b></td>
        <td align='center' width='110'><b>Prestasi Kerja</b></td>
        <td align='center' width='110'><b>Kondisi Kerja</b></td>
        <td align='center' width='110'><b>Kelangkaan Profesi</b></td>
      </tr>
      <tr class='info' style='font-size: 9px; font-style: italic;'>
        <td align='center'>1</td>
        <td align='center'>2</td>
        <td align='center'>3</td>
        <td align='center'>4</td>
        <td align='center'>5</td>
        <td align='center'>6</td>
        <td align='center'>7</td>
        <td align='center'>8</td>
        <td align='center'>9 (5+6+7+8)</td>
        <td align='center'>10</td>
        <td align='center'>11</td>
        <td align='center'>12 (9+10-11)</td>
      </tr>

      <?php
        $no = 1;
        foreach($data as $v):          
      ?>
        <tr>
        <td align='center'><?php echo $no; ?></td>
        <td><?php
		echo $this->munker->getnamaunker($v['fid_unker']);
		echo "<br />";
		if ($this->session->userdata('level') == "ADMIN") {
		   echo "<small>".$this->mpegawai->getnama($v['entri_by'])." ::: ".tglwaktu_indo($v['entri_at'])."</small>";
		}		
	    ?>
	</td>
        <td align='center'><?php echo round($this->mtppng2025->getratakinerja_perbulan($v['id']),2)."<br/>".round($this->mtppng2025->getrataabsensi_perbulan($v['id']),2); ?></td>
        <td align='center'>
          <?php 
            $jnsasn = $this->mtppng2025->get_jnsasn($v['id']);
            if ($jnsasn == "PNS") {
              echo "<span class='label label-primary'><b>".$v['jenis_asn']."</b></span>";
	      $jmlasn = $this->mkinerja->getjmlpeg_berhaktpp_perunker($v['fid_unker']);
            } else if ($jnsasn == "PPPK") {
              echo "<span class='label label-default'><b>".$v['jenis_asn']."</b></span>";
	      $jmlasn = $this->mkinerja_pppk->getjmlpeg_berhaktpp_perunker($v['fid_unker']);
            } 
            echo "<br/>".$this->mtppng2025->get_jmlperpengantar($v['id']);
	    echo "<br/>".$jmlasn;
          ?>
        </td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalbk_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalpk_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalkk_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalkp_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng2025->gettotalreal_perbulan($v['id']),0,",",".") ?></td>
        <?php
          $totalpph = $this->mtppng2025->gettotalpph_perbulan($v['id']);
          $totaliwp = $this->mtppng2025->gettotaliwp_perbulan($v['id']);
          $totalbpjs = $this->mtppng2025->gettotalbpjs_perbulan($v['id']);
          $totalthp = $this->mtppng2025->gettotalthp_perbulan($v['id']);

	  $totreal = $this->mtppng2025->gettotalreal_perbulan($v['id']);
	  $tottamb = $totalpph + $totalbpjs;
	  $totpot = $totalpph + $totaliwp + $totalbpjs;

	  $thp = $totreal + $tottamb - $totpot;
        ?>
        <td align='right'><?php echo "<span class='pull-left'>PPh.</span>Rp. ".number_format($totalpph,0,",",".").
			"<br/><span class='pull-left'>BPJS</span>Rp. ".number_format($totalbpjs,0,",","."); ?></td>
        <td align='right'><?php echo "<span class='pull-left'>PPh.</span>Rp. ".number_format($totalpph,0,",",".").
			"<br/><span class='pull-left'>IWP.</span>Rp. ".number_format($totaliwp,0,",",".").
			"<br/><span class='pull-left'>BPJS</span>Rp. ".number_format($totalbpjs,0,",","."); ?></td>
        <td align='right'><?php echo "<span class='pull-left'>Real.</span>Rp. ".number_format($totreal,0,",",".").
			"<br/><span class='pull-left'>Tamb.</span>Rp. ".number_format($tottamb,0,",",".").
			"<br/><span class='pull-left'>Pot.</span>Rp. ".number_format($totpot,0,",",".").
			"<br/><span class='text text-primary pull-left'>THP.</span><span class='text text-primary'>Rp. ".number_format($thp,0,",",".")."</span>"; ?></td>
        <td align='center' width='40'>
          <?php
            if ($v['status'] == "SKPD") {
              echo "<span class='label label-default'>SKPD</span>";
            } else if ($v['status'] == "BKPSDM") {
               echo "<span class='label label-info'>BKPSDM</span>";
            } else if ($v['status'] == "APPROVED") {
              echo "<span class='label label-warning'>APPROVED</span>";
            } else if ($v['status'] == "CETAK") {
              echo "<span class='label label-danger'>CETAK</span>";
            }else if ($v['status'] == "SELESAI") {
              echo "<span class='label label-default'>SELESAI</span>";
            } 
          ?>
          </td>
        <td align='center' width='40'>
          <?php
          echo "<form method='POST' action='../tppng2025/detailperiodeunor'>";
          echo "<input type='hidden' name='id_periode' id='id_periode' value='$v[fid_periode]'>";
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id]'>";
          echo "<input type='hidden' name='id_unor' id='id_unor' value='$v[fid_unker]'>";
          ?>
          <button type="submit" class="btn btn-success btn-outline btn-sm">
          <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Detail
          </button>
          <?php
            echo "</form>";
          ?>
        </td>   
        <?php
        $jmldata = $this->mtppng2025->get_jmlperpengantar($v['id']);
        if ($jmldata == 0) {
        ?>
        <td align='center' width='40'>
          <?php
          echo "<form method='POST' action='../tppng2025/hapuspengantar'>";
          echo "<input type='hidden' name='id_periode' id='id_periode' value='$v[fid_periode]'>";
          echo "<input type='hidden' name='id_unor' id='id_unor' value='$v[fid_unker]'>";
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-outline btn-sm">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br />Hapus
          </button>
          <?php
            echo "</form>";
          ?>
        </td>  
        <?php
        }
        ?>
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>
</div>
</div>
</div>
</div>
</center>

<div id="tampiltambah" class="modal modal-lg fade" role="dialog"  style="padding:10px;overflow:auto;width:100%;height:100%;">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Unit Kerja TPP Periode <?php echo bulan($blnperiode); ?> 2025</h4>
      </div>
      <div class="modal-body" align="left"">   
        <form method='POST' name='formkalk' style='padding-top:8px' action='../tppng2025/tmbunorperiode_aksi'>
          <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $idperiode; ?>'>
          <div class='row'>                                                
            <div class='col-md-12'>
              <div class="form-group input-group">    
                  <span class="input-group-addon" style="font-size: 12px;">Unit Kerja</span>
                  <select class="form-control" name="idunor" id="idunor" required style="font-size: 11px;">
                    <?php
                    echo "<option value='' selected>-- Pilih Jabatan --</option>";
                    $unor = $this->munker->dd_unker()->result_array();
                    if ($unor) {
                      foreach($unor as $u)
                      {
			// cek telah usul (sementara untuk mencek SKPD mana yg blum menghitung)
			//if (!$this->mtppng2025->cektelahusul_pengantar($idperiode, $u['id_unit_kerja'], "PNS")) {
                        echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
			//}	
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-4'>
                <div class="form-group input-group">    
                  <span class="input-group-addon" style="font-size: 12px;">Jenis ASN</span>
                  <select class="form-control" name="jnsasn" id="jnsasn" required style="font-size: 11px;">
                    <option value='' selected>-- Pilih Jenis ASN --</option>
                    <option value='PNS'>PNS</option>
                    <option value='PPPK'>PPPK</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-12' align="right">
                <button type="submit" class="btn btn-success btn-outline" >
                  <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Simpan
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah THR -->
<div id="tampiltambahthr" class="modal modal-lg fade" role="dialog"  style="padding:10px;overflow:auto;width:100%;height:100%;">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Unit Kerja TPP <?php echo bulan($blnperiode); ?> 2025</h4>
      </div>
      <div class="modal-body" align="left"">
	  <form method='POST' name='formkalk' style='padding-top:8px' action='../tppng2025/tmbunorperiode_aksi'>
          <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $idperiode; ?>'>
          <div class='row'>
            <div class='col-md-12'>
              <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;">Unit Kerja</span>
                  <select class="form-control" name="idunor" id="idunor" required style="font-size: 11px;">
                    <?php
                    echo "<option value='' selected>-- Pilih Jabatan --</option>";
                    $unor = $this->munker->dd_unker()->result_array();
                    if ($unor) {
                      foreach($unor as $u)
                      {
                        echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-4'>
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;">Jenis ASN</span>
                  <select class="form-control" name="jnsasn" id="jnsasn" required style="font-size: 11px;">
                    <option value='' selected>-- Pilih Jenis ASN --</option>
                    <option value='PNS'>PNS</option>
                    <option value='PPPK'>PPPK</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-12' align="right">
                <button type="submit" class="btn btn-success btn-outline" >
                  <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Simpan
                </button>
              </div>
            </div>
          </div>
        </form>	  
      </div> <!-- End Modal Body -->
    </div> <!-- End modal content -->	
  </div> <!-- End modal dialog -->
</div> <!-- End div tambah THR --> 
<!-- End Modal Tambah Unor THR -->

<!-- Modal Update Status -->
<div id="updatestatus<?php echo $idperiode; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class='modal-header'>
      <?php
  	$bln = $this->mtppng2025->get_bulanperiode($idperiode);
        $thn = $this->mtppng2025->get_tahunperiode($idperiode);
        echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>Updating Status Pengantar TPP";
        echo "<br/><h5 class='modal-title text text-muted'>".bulan($bln)." ".$thn."</h5>";
      ?>
      </div> <!-- End Header -->
      <div class="modal-body" align="left">
        <form method='POST' name='formkalk' style='padding-top:8px' action='../tppng2025/updatestatuspengantar_aksi'>
          <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $idperiode; ?>'>
          <div class='row'>
            <div class='col-md-12'>
              <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;">Unit Kerja</span>
                  <select class="form-control" name="idpengantar" id="idpengantar" required style="font-size: 11px;">
                    <?php
                    echo "<option value='' selected>-- Pilih Pengantar --</option>";
                    $unor = $this->mtppng2025->get_pengantar_orderunor($idperiode)->result_array();
                    //if ($unor) {
                      foreach($unor as $u)
		      {
		        $nmunker = $this->munker->getnamaunker($u['fid_unker']);
                        echo "<option value='".$u['id']."'>".$nmunker." - ".$u['jenis_asn']." - ".$u['status']." - ".tglwaktu_indo($u['entri_at'])."</option>";
                      }
                    //}
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-6'>
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;">Status</span>
                  <select class="form-control" name="status" id="status" required style="font-size: 12px;">
                    <option value='' selected>-- Pilih Status --</option>
                    <option value='SKPD'>SKPD</option>
                    <option value='BKPSDM'>BKPSDM</option>
                    <option value='APPROVED'>APPROVED</option>
                    <option value='CETAK'>CETAK</option>
                    <option value='SELESAI'>SELESAI</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-12' align="right">
                <button type="submit" class="btn btn-success btn-outline btn-xl" >
                  <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Simpan
                </button>
              </div>
            </div>
	  </form>
        </div> <!-- End Modal body -->
      </div>
    </div>
  </div>
</div>
<!-- End Modal Detail -->
