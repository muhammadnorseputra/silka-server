<!-- Default panel contents -->
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

  function showDataKalkulasi(str1, str2, str3, str4, str5, str6, str7)
  // (nip, idperiode, idpengantar, idjabpeta, idjabpltpeta, jnsplt, pengurang)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilkalkulasi";
    url=url+"?nip="+str1;
    url=url+"&idperiode="+str2;
    url=url+"&idpengantar="+str3;
    url=url+"&idjabpeta="+str4;
    url=url+"&idjabpltpeta="+str5;
    url=url+"&jnsplt="+str6;
    url=url+"&pengurang="+str7;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataKal;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataKal(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkal").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkal").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

  function showDataKalkulasiThr(str1, str2, str3, str4, str5, str6)
  // (nip, idperiode, idpengantar, idjabpeta, idjabpltpeta, jnsplt)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilkalkulasithr";
    url=url+"?nip="+str1;
    url=url+"&idperiode="+str2;
    url=url+"&idpengantar="+str3;
    url=url+"&idjabpeta="+str4;
    url=url+"&idjabpltpeta="+str5;
    url=url+"&jnsplt="+str6;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataKalThr;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataKalThr(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkalthr").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkalthr").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
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

  function showData_jabblnlalu(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilJabBlnLalu";;
    url=url+"?nip="+str1;;
    url=url+"&idperiode="+str2;
    url=url+"&jnsasn="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDataJabLalu;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedDataJabLalu(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampil_jabblnlalu").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampil_jabblnlalu").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  }

</script>

<script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      });

      //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
    </script>
<center>
  <div class="panel panel-default" style="width: 99%; height:630px;">
  <div class="panel-body">
  <!--
  <div class='alert alert-danger' role='alert'><b>Hai Kaka...</b>Kalkulasi TPP untuk sementara kita CLOSE dlu ya,
                karena harus dilakukan updating SILKa terkait Kalkulasi TPP khusus untuk PPPK Tenaga Kesehatan.</div> 
  -->
  <table class='table table-condensed'>
    <tr>      
      <?php
        if ($this->session->userdata('level') == "ADMIN") {
      ?>
      <td align='right'>
        <button type="button" class="btn btn-danger btn-outline" data-toggle="modal" data-target="#updatestatus<?php echo $idpengantar; ?>">
        <span class="fa fa-pencil" aria-hidden="true"></span> Update Status ASN</button>
      </td>
      <?php
        }
      ?>
      <td align='right' width='50'>
        <?php
        $statuspengantar = $this->mtppng2024->get_statuspengantar($idpengantar);
	$tahunperiode = $this->mtppng2024->get_tahunperiode($idperiode);
	$bulanperiode = $this->mtppng2024->get_bulanperiode($idperiode);
	//if (($statuspengantar == "SKPD") AND (($this->session->userdata('nip') == "198104072009041002") OR ($this->session->userdata('nip') == "197708232006042022"))) {
        if ($statuspengantar == "SKPD") {
	  if (($tahunperiode == '2024') AND ($bulanperiode == '14')) { // Tambah Data THR
	    ?>
          	<button type="button" class="btn btn-outline btn-info" data-toggle="modal" data-target="#tampiltambahthr"><span class="fa fa-plus-square-o" aria-hidden="true"></span> Tambah ASN TPP THR</button>
            <?php	
	  } else { 
            ?>
                <button type="button" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#tampiltambah"><span class="fa fa-plus" aria-hidden="true"></span> Tambah ASN</button>
            <?php
          }
	}
        ?>
      </td>
      <td align='right'  width='50'>
        <form method="POST" action="../tppng2024/detailperiode">
          <input type='hidden' name='id_periode' id='id_periode' value='<?php echo $idperiode ?>'>
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

  <?php
  // Untuk warna modal, b3dakan PNS dengan PPPK
  $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      echo "<div class='panel panel-info'>";
    } else if ($jnsasn == "PPPK") {
      echo "<div class='panel panel-default'>";
    }

  ?>  
  <div class="panel-heading" align="left">
  <b>DETAIL TPP ::: <?php echo $this->munker->getnamaunker($idunor); ?></b><br />
  Periode <?php echo bulan($this->mtppng2024->get_bulanperiode($idperiode))." ".$this->mtppng2024->get_tahunperiode($idperiode); ?>
  <br/>
  <?php
  if ($jnsasn == "PNS") {
    echo "<span class='label label-primary'>JENIS ASN : ".$this->mtppng2024->get_jnsasn($idpengantar)."</span>";
  } else if ($jnsasn == "PPPK") {
    echo "<span class='label label-default'>JENIS ASN : ".$this->mtppng2024->get_jnsasn($idpengantar)."</span>";
  }
   
  echo "<br/><span class='label label-warning'>STATUS : ".$statuspengantar."</span>";
  ?>
  
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:460px;border:1px solid white" >
  <table class="table table table-condensed table-hover"  style='font-size: 11px;'>
      <tr class='info'>
        <td align='center' width='10px' rowspan='2'><b>No.</b></td>
        <td align='center' width='220' rowspan='2'>
        <?php
        if ($jnsasn == "PNS") {
          echo "<b>NIP / NAMA</b>";
        } else if ($jnsasn == "PPPK") {
          echo "<b>NIPPPK / NAMA</b>";
        } 
        ?>
        </td>
	<td align='center' width='250' rowspan='2'><b>JABATAN</b></td>
        <td align='center' width='80' rowspan='2'><b>PENILAIAN KINERJA</b></td>
        <td align='center' width='50' rowspan='2'><b>DISIPLIN KERJA</b></td>
        <td align='center' colspan='5'><b>TOTAL KRITERIA</b></td>            
	<td align='center' width='150' rowspan='2'><b>TAMBAHAN<br/>PPh21<br/>BPJS 4%</b></td>
        <td align='center' width='150' rowspan='2'><b>POTONGAN<br/>PPh21<br/>IWP 1%<br/>BPJS 4%</b></td>
        <td align='center' width='150' rowspan='2'><b>TAKE HOME PAY</b></td>
        <td align='center' width='80' rowspan='3'><b>STATUS</b></td>
        <td align='center' rowspan='3' colspan='3'><b>AKSI</b></td>
      </tr>
      <tr class='info'>
        <td align='center' width='110'><b>Beban Kerja</b></td>
        <td align='center' width='110'><b>Prestasi Kerja</b></td>
        <td align='center' width='110'><b>Kondisi Kerja</b></td>
        <td align='center' width='110'><b>Kelangkaan Profesi</b></td>
        <td align='center' width='110'><b>Total</b></td>
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
        <td align='center'>9</td>
        <td align='center'>10 (6+7+8+9)</td>
        <td align='center'>11</td>
	<td align='center'>12</td>	
        <td align='center'>13 (10+11-12)</td>
      </tr>

      <?php
        $no = 1;
        foreach($data as $v):          
      ?>
        <tr>
        <td align='center'><?php echo $no; ?></td>
        <td>
          <?php
            $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
            if ($jnsasn == "PNS") {
              echo "NIP. ".$v['nip'];
              echo "<br/>".$this->mpegawai->getnama($v['nip']);
            } if ($jnsasn == "PPPK") {
              echo "NIPPPK. ".$v['nip'];
              echo "<br/>".$this->mpppk->getnama($v['nip']);
            }  

            if ($v['statuspeg'] == "CPNS") {
              echo "<br/><span class='label label-success'><b>CPNS 80%</b></span>";
            }

            if ($v['ket_pengurang'] != "") {
              echo "<br/><span class='label label-danger'><b>PENGURANG ".$v['ket_pengurang']."</b></span>";
            }           
          ?>            
        </td>
	<td align='left'>
	<?php
	    echo "<small>".$v['jabatan']."</small>";
            if ($v['persen_plt'] == '100') {
              echo "<br/><small>PLT. ".$v['jabatan_plt']."</small>";
              echo " <span class='label label-info'>PLT 100%</span>";
            } else if ($v['persen_plt'] == '20') {
              echo "<br/><small>PLT. ".$v['jabatan_plt']."</small>";
              echo " <span class='label label-info'>PLT 20%</span>";
            }
	    
	    $koord = $this->mpetajab->get_koorsubkoord($v['fid_jabpeta']);
	    if ($koord) {
		echo "<br/><small><u>".$koord."</u></small>";
	    }
	?>
	</td>
        <td align='center'><?php echo "<small>".$v['capaian_produktifitas']."</small><br/>(".$v['nilai_produktifitas'].")<br/>".$v['persen_produktifitas']." %"; ?></td>
        <td align='center'><?php echo $v['nilai_disiplin']."<br/>".$v['persen_disiplin']." %"; ?></td>
        <td align='right'>
          <?php 
            echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_bk'],0,",",".");
            echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_bk'],0,",",".");
          ?>
        </td>
        <td align='right'>
          <?php
            echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_pk'],0,",",".");
            echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_pk'],0,",",".");
          ?>
        </td>
        <td align='right'>
          <?php
            echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_kk'],0,",",".");
            echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_kk'],0,",",".");
          ?>
        </td>
        <td align='right'>
          <?php
            echo "<span class='label label-success pull-left'>B</span> ".number_format($v['basic_kp'],0,",",".");
            echo "<br/><span class='label label-info pull-left'>R</span> ".number_format($v['real_kp'],0,",",".");
          ?>
          </td>
        <td align='right'>
	<?php
		$tot_basic = $v['basic_bk'] + $v['basic_pk'] + $v['basic_kk'] + $v['basic_kp'];
            	$tot_real = $v['real_bk'] + $v['real_pk'] + $v['real_kk'] + $v['real_kp'];
		echo "<span class='label label-success pull-left'>B</span> ".number_format($tot_basic,0,",",".");
            	echo "<br/><span class='label label-info pull-left'>R</span><b>".number_format($v['real_total'],0,",",".")."</b>";
		//echo number_format($v['real_total'],0,",",".");
	?>
	</td>
	<td align='right' style='padding-left:10px;'>
	  <?php
	    $tottamb = $v['jml_pph'] + $v['jml_bpjs'];
            echo "<span class='pull-left'>PPh.</span>".number_format($v['jml_pph'],0,",",".")."<br/>";
	    echo "<span class='pull-left'>BPJS.</span>".number_format($v['jml_bpjs'],0,",",".");
            echo "<br/><b>".number_format($tottamb,0,",",".")."</b>";
          ?>	  
	</td>
        <td align='right' style='padding-left:10px;'>
          <?php
	    $katpajak = $this->mtppng2024->get_kategori_pp582023($v['jns_ptkp']);
            $hasil_bruto = $v['gaji_bruto'] + $v['real_total'];
            $tarifpajak = $this->mtppng2024->get_tarifpph21_pp582023($katpajak, $hasil_bruto);
		
            if ($v['jns_ptkp']) {
              echo "<span class='label label-info' align='left'>".$v['jns_ptkp']." | ".$katpajak." | ".$tarifpajak." %</span>";
            } 

            if ($v['npwp']) {
              echo " <span class='label label-success' align='left'>NPWP</span>";
            } else {
	      echo " <span class='label label-danger' align='left'><del>NPWP<del></span>";
	    }
            echo "<br/>";
	    $totpot = $v['jml_pph'] + $v['jml_iwp'] + $v['jml_bpjs'];
            echo "<span class='pull-left'>PPh.</span>".number_format($v['jml_pph'],0,",",".")."<br/>";
	    echo "<span class='pull-left'>IWP.</span>".number_format($v['jml_iwp'],0,",",".")."<br/>";
	    echo "<span class='pull-left'>BPJS.</span>".number_format($v['jml_bpjs'],0,",",".");
	    echo "<br/><b>".number_format($totpot,0,",",".")."</b>";
          ?>
          </td>
        <td align='right' style='padding-left:10px;'>
	  <?php
	    echo "<span class='pull-left'>Real.</span>".number_format($v['real_total'],0,",",".")."<br/>";
	    echo "<span class='pull-left'>Tamb.</span>".number_format($tottamb,0,",",".")."<br/>";
	    echo "<span class='pull-left'>Pot.</span>(".number_format($totpot,0,",",".").")<br/>"; 
	    echo "<b><span class='text text-primary pull-left'>THP</span><span class='text text-primary'>".number_format($v['tpp_diterima'],0,",",".")."</span></b>";
	  ?>
	</td>
        <td align='center'>
          <?php
            $status = $this->mtppng2024->get_statustppng($v['fid_status']);
            if ($status == "INPUT") {
              echo "<span class='label label-default'>INPUT</span>";
            } else if ($status == "VALID") {
               echo "<span class='label label-info'>VALID</span>";
            } else if ($status == "TUNGGU APPROVAL") {
              echo "<span class='label label-success'>TUNGGU APPROVAL</span>";
            } else if ($status == "APPROVE") {
              echo "<span class='label label-warning'>APPROVED</span>";
            } else if ($status == "PRINT") {
              echo "<span class='label label-danger'>CETAK</span>";
            } else if ($status == "SELESAI") {
              echo "<span class='label label-default'>SELESAI</span>";
            }

	    // Status Sync SiGapok
	    	
	    echo "<br/>";
            if ($v['is_sync_simgaji'] == '1')
		echo "<span class='label label-success'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Sync INEXIS</span>";
	    else if ($v['is_sync_simgaji'] == '0')
		echo "<span class='label label-default'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Sync INEXIS</span>";

          ?>
          </td>
        <td align='center' width='40px'>
          <?php

          $statuspengantar = $this->mtppng2024->get_statuspengantar($v['fid_pengantar']);
          if (($status == "INPUT") AND ($statuspengantar == "SKPD") AND ($v['bulan'] != "14") AND ($v['bulan'] != "15")) {
            echo "<form method='POST' action='../tppng2024/valid_tppng'>";
            echo "<input type='hidden' name='id' id='id' value='$v[id]'>";
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='id_periode' id='id_periode' value='$idperiode'>";

            ?>
            <button type="submit" class="btn btn-success btn-outline btn-sm">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span><br/>Valid
            </button>
            <?php
              echo "</form>";
          } else if (($status == "VALID") AND ($statuspengantar == "SKPD")) {
            echo "<form method='POST' action='../tppng2024/invalid_tppng'>";
            echo "<input type='hidden' name='id' id='id' value='$v[id]'>";
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='id_periode' id='id_periode' value='$idperiode'>";

            ?>
            <button type="submit" class="btn btn-danger btn-outline btn-sm">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span><br/>Invalid
            </button>
            <?php
              echo "</form>";
          } 
          ?>
	  
        </td>
        <td align='center' width='40px'>
          <?php
          if ($v['catatan'] != "") {
          ?>        
            <button type='button' class='btn btn-info btn-outline btn-sm' data-toggle='modal' data-target='#detail<?php echo $v['nip']; ?>'>
              <span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span><br/>Detail Kalkulasi
            </button>
          <?php
          }
          ?>
          <!--
          <form method='POST' name='formdtltpp' action='' >
          <input type='hidden' name='nip' id='nip' value='<?php //echo $v['nip']; ?>' >
          <input type='hidden' name='idpengantar' id='idpengantar' value='<?php //echo $idpengantar; ?>' >
          <input type='hidden' name='idperiode' id='idperiode' value='<?php //echo $idperiode; ?>' >
                 
          <button type="button" class="btn btn-success btn-outline btn-xs" onClick="" >
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span><br />Detail
          </button>
          
          <button type="submit" class="btn btn-success btn-outline btn-xs ">
          <span class="glyphicon glyphicon-tags" aria-hidden="true"></span><br />Detail
          </button>
          -->
          </form>
          <!-- Modal Detail -->
          <div id="detail<?php echo $v['nip']; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl" role="document" style='width: 50%;'>
              <div class="modal-content">
                <div class='modal-header'>
                  <?php
                  $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
                  if ($jnsasn == "PNS") { 
		    $nama = $this->mpegawai->getnama($v['nip']);
		    $golru = $this->mpegawai->getnamagolru($v['fid_golru']);	
		    $pangkat = $this->mpegawai->getnamapangkat($v['fid_golru']);
                  } else if ($jnsasn == "PPPK") {
		    $nama = $this->mpppk->getnama($v['nip']);
                    $golru = $this->mpppk->getnamagolru($v['fid_golru']);
		    $pangkat = '';	
                  } 
		  echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>Detail Kalkulasi TPP Periode ".bulan($v['bulan'])." ".$v['tahun']."</span>";
		  echo "<br/><h5 class='modal-title text text-muted'>".$nama."</h5>";
                  ?>
                </div> <!-- End Header -->
                <div class="modal-body" align="left">
                  <?php
		  echo "<div class='row'>";
                    echo "<div class='col-md-12'><span class='text text-primary'>IDENTITAS ASN</span></div>";
                  echo "</div>";
		  echo "<div class='row'>";
		    echo "<div class='col-md-2'>NIP</div>";
		    echo "<div class='col-md-10'>: ".$v['nip']."</div>";
		  echo "</div>";
		  echo "<div class='row'>";
                    echo "<div class='col-md-2'>Nama</div>";
                    echo "<div class='col-md-10'>: ".$nama."</div>";
                  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-2'>Jabatan</div>";
		    if ($v['jabatan_plt']) {
		      echo "<div class='col-md-10 text-warning'>: ".$v['jabatan']."<br />&nbspPlt. ".
				$v['jabatan_plt']."<br/>&nbsp(Kelas : ".$v['kelasjab_plt'].")<br/>&nbspPersentase : ".
				$v['persen_plt']." %
			    </div>";	
		    } else {
		      echo "<div class='col-md-10'>: ".$v['jabatan']."<br/>&nbsp(Kelas : ".$v['kelasjab'].")</div>";	
		    }
		  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-2'>Unit Kerja</div>";
                    echo "<div class='col-md-10'>: ".$this->munker->getnamaunker($v['fid_unker'])."</div>";
                  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-2'>Status</div>";
                    echo "<div class='col-md-10'>: ".$v['statuspeg']."</div>";
                  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-2'>Pangkat/Golru</div>";
                    echo "<div class='col-md-10'>: ".$pangkat." (".$golru.")</div>";
                  echo "</div>";
		
		  echo "<br />";
		  echo "<div class='well well-sm' style='font-size: 11px;'>";
		  echo "<div class='row'>";
                    echo "<div class='col-md-6'><span class='text text-primary'>KINERJA BULANAN - 60 %</span>";
		      echo "<div class='row'>";	
		        echo "<div class='col-md-3'>Capaian</div>";
		        echo "<div class='col-md-9'>: ".$v['capaian_produktifitas']."</div>";
			echo "<div class='col-md-3'>Nilai</div>";
                        echo "<div class='col-md-9'>: ".$v['nilai_produktifitas']."</div>";
			echo "<div class='col-md-3'>Persentase</div>";
                        echo "<div class='col-md-9'>: ".$v['persen_produktifitas']." %</div>";
		      echo "</div>";
		    echo "</div>"; // End Kolom Kinerja Bulanan
		
                    echo "<div class='col-md-6'><span class='text text-primary'>ABSENSI BULANAN - 40 %</span>";
                      echo "<div class='row'>";
                        echo "<div class='col-md-3'>Nilai</div>";
                        echo "<div class='col-md-9'>: ".$v['nilai_disiplin']."</div>";
                        echo "<div class='col-md-3'>Persentase</div>";
                        echo "<div class='col-md-9'>: ".$v['persen_disiplin']." %</div>";
                      echo "</div>";
		    echo "</div>"; // End Kolom Kinerja Bulanan
		  echo "</div>";

		  echo "<div class='row'>";
                    echo "<div class='col-md-10'>
			  <span class='text text-success'>REALISASI KINERJA : "
			.$v['persen_produktifitas']." + ".$v['persen_disiplin']." = ".$v['realisasi_kinerja']." %</span>";

        	    if ($v['ket_pengurang'] != "") {
                        echo "<br/><span class='text text-danger'><b>PENGURANG ".$v['ket_pengurang']."</b></span>";
                    }	        
		    echo "</div>";// end kolom
		  echo "</div>"; // end row 
		
		  echo "<br/><div class='row'>";
                     echo "<div class='col-md-12'><span class='text text-warning'>DETAIL ABSENSI ".strtoupper(bulan($v['bulan']))." ".$v['tahun']."</span>";
			echo "<div class='row' align='center'>";
                    	  echo "<div class='col-md-1'><abbr title='Jumlah Hari Kerja' class='initialism'>JHK</abbr></div>";
                          echo "<div class='col-md-2'><span class='text text-success'><abbr title='Hadir / Tepat Waktu' class='initialism'>Hadir / TW</abbr></span></div>";
                          echo "<div class='col-md-1'><abbr title='Izin' class='initialism'>Izin</abbr></div>";
                          echo "<div class='col-md-1'><abbr title='Sakit' class='initialism'>Sakit</abbr></div>";
                          echo "<div class='col-md-1'><abbr title='Terlambat / Izin Terlambat' class='initialism'><span class='text text-danger'>T</span> / IT</abbr></div>";
                          echo "<div class='col-md-2'><abbr title='Pulang Cepat / Izin Pulang Cepat' class='initialism'><span class='text text-danger'>PC</span> / IPC</abbr></div>";
                          echo "<div class='col-md-1'><abbr title='Tanpa Keterangan / Cuti' class='initialism'><span class='text text-danger'>TK</span>/cuti</abbr></div>";
                          echo "<div class='col-md-1'><abbr title='Tugas Dinas' class='initialism'>Tudin</abbr></div>";
                          echo "<div class='col-md-2'><abbr title='Total Potongan / Realisasi' class='initialism'><span class='text text-danger'>TP</span> / <span class='text text-success'>Real</span></abbr></div>";
			echo "</div>"; // end row
			
			if ($jnsasn == "PNS") {
                            $abs = $this->mabsensi->getabsensi_nikbulantahun($v['nip'], $v['bulan'], $v['tahun'])->result_array();
                        } else if ($jnsasn == "PPPK") {
                            $abs = $this->mabsensi->getabsensi_nipppkbulantahun($v['nip'], $v['bulan'], $v['tahun'])->result_array();
                        }
			
			foreach($abs as $a):
			  echo "<div class='row' align='center'>";
                            echo "<div class='col-md-1'>".$a['jml_hari']."</div>";
                            echo "<div class='col-md-2'><span class='text text-success'>".$a['hadir']." / ".$a['tepat_waktu']."</span></div>";
                            echo "<div class='col-md-1'>".$a['izin']."</div>";
                            echo "<div class='col-md-1'>".$a['sakit']."</div>";
                            echo "<div class='col-md-1'><span class='text text-danger'>".$a['terlambat']."</span> / ".$a['izin_terlambat']."</div>";
                            echo "<div class='col-md-2'><span class='text text-danger'>".$a['pulang_cepat']."</span> / ".$a['izin_pulangcepat']."</div>";
                            echo "<div class='col-md-1'><span class='text text-danger'>".$a['tk']."</span> / ".$a['cuti']."</div>";
                            echo "<div class='col-md-1'>".$a['tudin']."</div>";
                            echo "<div class='col-md-2'><span class='text text-danger'>".$a['total_pengurang']."</span> / <span class='text text-success'>".$a['realisasi']."</span></div>";
                          echo "</div>"; // end row
			endforeach;	
		     echo "</div>"; //end col
		  echo "</div>"; // end row

	   	  echo "</div>"; // End Well

		  echo "<div class='well well-sm' style='font-size: 11px;'>";
		  echo "<div class='row'>";
		    if ($v['statuspeg'] == 'CPNS') {
                        $ket = "Basic Kelas ".$this->mpetajab->get_kelas($v['fid_jabpeta'])." : 80%";
                    } else if ($v['fid_jabpeta_plt'] == 0) {
                        $ket = "Basic Kelas ".$this->mpetajab->get_kelas($v['fid_jabpeta']);
                    } else if (($v['persen_plt'] == '100') AND ($v['fid_jabpeta_plt'] != '')) {
                        $ket = "Basic Kelas ".$this->mpetajab->get_kelas($v['fid_jabpeta_plt']);
                    } else if (($v['persen_plt'] == '20') AND ($v['fid_jabpeta_plt'] != '')) {
                        $ket = "Basic Kelas ".$this->mpetajab->get_kelas($v['fid_jabpeta'])." + 20% Basic Kelas ".$this->mpetajab->get_kelas($v['fid_jabpeta_plt']);
                    } else {
                        $ket = "Data kurang lengkap";
                    }	
                    echo "<div class='col-md-12'><span class='text text-primary'>KALKULASI (".$ket.")</span></div>";
                  echo "</div>";
		  echo "<div class='row'>";
                    echo "<div class='col-md-4'><b>KRITERIA</b></div>";
                    echo "<div class='col-md-4' align='right'>";
		    if ($v['statuspeg'] == "CPNS") {
			echo "<span class='text text-danger'><b>BASIC CPNS 80% </b></span></div>";
		    } else {
			echo "<b>BASIC</b></div>";
		    }	

                    echo "<div class='col-md-4' align='right'>";
		    if ($v['ket_pengurang'] != "") {
			echo "<span class='text text-danger'><b>REALISASI - ".$v['ket_pengurang']."</b></span></div>";
		    } else {
			echo "<b>REALISASI - ".$v['realisasi_kinerja']." %</b></div>";
		    }
                  echo "</div>";
		  echo "<div class='row'>";
                    echo "<div class='col-md-4'>BEBAN KERJA</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['basic_bk'],0,",",".")."</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['real_bk'],0,",",".")."</div>";
                  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-4'>PRESTASI KERJA</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['basic_pk'],0,",",".")."</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['real_pk'],0,",",".")."</div>";
                  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-4'>KONDISI KERJA</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['basic_kk'],0,",",".")."</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['real_kk'],0,",",".")."</div>";
                  echo "</div>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-4'>KELANGKAAN PROFESI</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['basic_kp'],0,",",".")."</div>";
                    echo "<div class='col-md-4' align='right'>".number_format($v['real_kp'],0,",",".")."</div>";
                  echo "</div>";
                  echo "<div class='row text text-success'>";
                    echo "<div class='col-md-4'><b>TOTAL</b></div>";
                    echo "<div class='col-md-4' align='right'><b>".number_format($v['basic_total'],0,",",".")."</b></div>";
                    echo "<div class='col-md-4' align='right'><b>".number_format($v['real_total'],0,",",".")."</b></div>";
                  echo "</div>";
                  echo "</div>"; // End Well

		  $hasil_bruto = $v['gaji_bruto'] + $v['real_total'];

          	  if ($jnsasn == "PNS") {
                	$pph_bayar = $this->mtppng2024->hitungpph($v['nip'], $v['tahun'], $v['bulan'], $v['real_total']);
          	  } else if ($jnsasn == "PPPK") {
			$pph_bayar = $this->mtppng2024->hitungpph_pppk($v['nip'], $v['tahun'], $v['bulan'], $v['real_total']);
          	  }

          	  $katpajak = $this->mtppng2024->get_kategori_pp582023($v['jns_ptkp']);
          	  $ptkpgaji = $this->mtppng2024->get_ptkpgaji_pns($v['nip'], $v['tahun'], $v['bulan']);

		  echo "<div class='row'>";
	          echo "<div class='col-md-4'>
                  	  <div class='well well-sm' style='font-size: 10px;'>
                    	     <span class='text text-primary'><b>PPh 21</b></span>
                    	     <div class='row'>
                      		<div class='col-md-6' align='left'>Gaji Bruto</div>
                      		<div class='col-md-6' align='right'>".number_format($v['gaji_bruto'],0,',','.')."</div>
                    	     </div>
                    	     <div class='row'>
                      		<div class='col-md-6' align='left'>TPP Bruto</div>
                      		<div class='col-md-6' align='right'>".number_format($v['real_total'],0,',','.')."</div>
                    	     </div>
                    	     <div class='row'>
                      		<div class='col-md-6' align='left'>Peng. Bruto</div>
                      		<div class='col-md-6' align='right' style='margin-bottom:5px;'>".number_format($hasil_bruto,0,',','.')."</div>
                    	     </div>
                    	     <div class='row'>
                      		<div class='col-md-7'>PTKP | Kategori</div>
                      		<div class='col-md-5' align='right'>".$v['jns_ptkp']." | ".$katpajak."</div>
                    	     </div>
                    	     <div class='row'>
                      		<div class='col-md-6' align='left'>Tarif Pajak</div>
                      		<div class='col-md-6' align='right' style='margin-bottom:5px;'>".$this->mtppng2024->get_tarifpph21_pp582023($katpajak, $hasil_bruto)." %</div>
                    	     </div>
                    	     <div class='row'>
                      		<div class='col-md-6'>PPh 21 TPP</div>
                      		<div class='col-md-6' align='right'>".number_format($pph_bayar,0,',','.')."</div>
                    	     </div>
			     <div class='row'>
                      		<div class='col-md-6'>PPh 21 Gaji</div>
                      		<div class='col-md-6' align='right' style='margin-bottom:5px;'>(".number_format($v['pph_gaji'],0,',','.').")</div>
                    	     </div>
                    	     <div class='row'>
                      		<div class='col-md-6'><span class='text-success'><b>Pot PPh 21</b></span></div>
                      		<div class='col-md-6' align='right'><span class='text-success'><b>".number_format($v['jml_pph'],0,',','.')."</b></span></div>
                    	     </div>
                	  </div>";
		    echo "</div>"; // End Kolom PPh 21
		   
		    // IWP 1%
          	    $iwp_tpp = $v['real_total'] * 0.01;
           	    $iwp_total = $v['iwp_gaji'] + $iwp_tpp;
          	    if ($iwp_total > 120000) {
            		$iwp_terhutang = 120000-$v['iwp_gaji'];
          	    } else {
            		$iwp_terhutang = $iwp_tpp;
          	    }

		    if (($v['bulan'] == '14') OR ($v['bulan'] == '15')) {
			$v['iwp_gaji'] = 0;
			$iwp_tpp = 0;
			$iwp_terhutang = 0;
    		    } 
          	    // End IWP 1%		
		    echo "<div class='col-md-4'>
                  	  <div class='well well-sm' style='font-size: 10px;'>
                    		<span class='text text-primary'><b>IWP 1% Pengh.</b> <span class='text text-muted'>Maks. 120.000</span></span>
                    		<div class='row'>
                      		  <div class='col-md-6'>IWP Gaji</div>
                      		  <div class='col-md-6' align='right'>".number_format($v['iwp_gaji'],0,',','.')."</div>
                    		</div>
                    		<div class='row'>
                      		  <div class='col-md-6'>IWP TPP</div>
                      		  <div class='col-md-6' align='right'>".number_format($iwp_tpp,0,',','.')."</div>
                    		</div>
                    		<div class='row'>
                      		  <div class='col-md-6'><span class='text-success'><b>Pot IWP</b></span></div>
                      		  <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($iwp_terhutang,0,',','.')."</b></span></div>
                    		</div>
                  	  </div>";
		   
		    // BPJS 4%
          	    $bpjs_tpp = $v['real_total'] * 0.04;
		    $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($v['nip'], $v['tahun'], $v['bulan']); 
          	    $bpjs_total = $bpjs_gaji + $bpjs_tpp;
          	    if ($bpjs_total > 480000) {
            		$bpjs_terhutang = 480000-$bpjs_gaji;
          	    } else {
            	    	$bpjs_terhutang = $bpjs_tpp;
          	    }

		    if (($v['bulan'] == '14') OR ($v['bulan'] == '15')) {
                        $v['bpjs_gaji'] = 0;
                        $bpjs_tpp = 0;
                        $bpjs_terhutang = 0;
                    }
          	    //End BPJS 4%	
                    echo "<div class='well well-sm' style='font-size: 10px;'>
                    	  	<span class='text text-primary'><b>BPJS 4% Pengh.</b> <span class='text text-muted'>Maks. 480.000</span></span>
                    		<div class='row'>
                      		  <div class='col-md-6'>BPJS Gaji</div>
                      		  <div class='col-md-6' align='right'>".number_format($bpjs_gaji,0,',','.')."</div>
                    		</div>
                    		<div class='row'>
                      		  <div class='col-md-6'>BPJS TPP</div>
                      		  <div class='col-md-6' align='right'>".number_format($bpjs_tpp,0,',','.')."</div>
                    		</div>
                    		<div class='row'>
                      		  <div class='col-md-6'><span class='text-success'><b>Pot BPJS</b></span></div>
                      		  <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($bpjs_terhutang,0,',','.')."</b></span></div>
                    		</div>
                  	  </div>";	
		echo "</div>"; // End Kolom BPJS IWP

          	echo "<div class='col-md-4'>
                       <div class='well well-sm' style='font-size: 10px;'>
                       <span class='text text-danger'><b>KALKULASI AKHIR</b></span><br/>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left'><b>Real TPP</b></div>
                       	  <div class='col-md-6' align='right' style='margin-bottom:5px;'><b>".number_format(round($v['real_total']),0,',','.')."</b></div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left'>Tunj PPh 21</div>
                      	  <div class='col-md-6' align='right'>".number_format(round($v['jml_pph']),0,',','.')."</div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left'>Tunj BPJS</div>
                      	  <div class='col-md-6' align='right'>".number_format(round($bpjs_terhutang),0,',','.')."</div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left' style='margin-bottom:5px;'><b>Total Tunj</b></div>
                      	  <div class='col-md-6' align='right'><b>".number_format(round($v['jml_pph']+$bpjs_terhutang),0,',','.')."</b></div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left'>Pot PPh 21</div>
                      	  <div class='col-md-6' align='right'>(".number_format(round($pph_bayar),0,',','.').")</div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left'>Pot IWP</div>
                      	  <div class='col-md-6' align='right'>(".number_format(round($iwp_terhutang),0,',','.').")</div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left'>Pot BPJS</div>
                      	  <div class='col-md-6' align='right'>(".number_format(round($bpjs_terhutang),0,',','.').")</div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6' align='left' style='margin-bottom:5px;'><b>Total Pot</b></div>
                      	  <div class='col-md-6' align='right'><b>".number_format(round($v['jml_pph']+$v['jml_iwp']+$v['jml_bpjs']),0,',','.')."</b></div>
                    	</div>
                    	<div class='row'>
                      	  <div class='col-md-6'><b><span class='text text-danger'>TPP NETO</span></b></div>
                      	  <div class='col-md-6' align='right'>
                            <b><span class='text text-danger'>".number_format(round($v['tpp_diterima'],0),0,',','.')."</span></b>
			  </div>
			</div>
                       </div>
		      </div>";
                echo "</div>"; // End Row PPh, IWP, BPJS, Kalkulasi

		echo "<div class='row'>";
                  echo "<div class='col-md-12'>
			<div class='well well-sm' style='font-size: 11px;'>";
		  echo "Catatan : ".$v['catatan'];
		  echo "</div>
			</div>";
		echo "</div>"; 
                ?>
		</div> <!-- End Modal body -->
              </div>
            </div>
          </div>
	  </div>
	  <!-- End Modal Detail -->

        </td>
        <td align='center' width='40px'>
          <?php
          if (($status == "INPUT") AND ($v['bulan'] != "14") AND ($v['bulan'] != "15")) {
            echo "<form method='POST' action='../tppng2024/hapustppng'>";
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
            echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
            echo "<input type='hidden' name='id_periode' id='id_periode' value='$idperiode'>";
            ?>
            <button type="submit" class="btn btn-warning btn-outline btn-sm" >
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
            </button>
            <?php
              echo "</form>";
          }
          ?>
        </td>        
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>

  <small>
  <div class='row'>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-6'>Jumlah Data</div>
          <div class='col-md-6' align='right'><?php echo $this->mtppng2024->get_jmlperpengantar($idpengantar); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Rata-rata Kinerja</div>
          <div class='col-md-6' align='right'><?php echo round($this->mtppng2024->getratakinerja_perbulan($idpengantar),2); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Rata-rata Absensi</div>
          <div class='col-md-6' align='right'><?php echo round($this->mtppng2024->getrataabsensi_perbulan($idpengantar),2); ?></div>
        </div>                    
      </blockquote>
    </div>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-7'>Total Beban Kerja</div>
          <div class='col-md-5' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalbk_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-7'>Total Prestasi Kerja</div>
          <div class='col-md-5' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalpk_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-7'>Total Kondisi Kerja</div>
          <div class='col-md-5' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalkk_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-7'>Total Kelangkaan Profesi</div>
          <div class='col-md-5' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalkp_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row text text-success'>
          <div class='col-md-7'><b>Total Realisasi</b></div>
          <div class='col-md-5' align='right'><b><?php echo "Rp. ".number_format($this->mtppng2024->gettotalreal_perbulan($idpengantar),0,",","."); ?></b></div>
        </div>
      </blockquote>
    </div>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-6'>Total Tamb. PPh21</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalpph_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Tamb. BPJS</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalbpjs_perbulan($idpengantar),0,",","."); ?></div>
        </div>
	<?php
	$totaltamb = $this->mtppng2024->gettotalpph_perbulan($idpengantar) + $this->mtppng2024->gettotalbpjs_perbulan($idpengantar);
	?>
        <div class='row text text-success'>
          <div class='col-md-6'><b>Total Tambahan</b></div>
          <div class='col-md-6' align='right'><b><?php echo "Rp. ".number_format($totaltamb,0,",","."); ?></b></div>
        </div>
      </blockquote>
    </div>
    <div class='col-md-3' align='left'>
      <blockquote style='font-size: 11px;'>
        <div class='row'>
          <div class='col-md-6'>Total Pot. PPh21</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalpph_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Pot. IWP</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotaliwp_perbulan($idpengantar),0,",","."); ?></div>
        </div>
        <div class='row'>
          <div class='col-md-6'>Total Pot. BPJS</div>
          <div class='col-md-6' align='right'><?php echo "Rp. ".number_format($this->mtppng2024->gettotalbpjs_perbulan($idpengantar),0,",","."); ?></div>
        </div>
	<?php
	$totpoto = $this->mtppng2024->gettotalpph_perbulan($idpengantar) + $this->mtppng2024->gettotaliwp_perbulan($idpengantar) + $this->mtppng2024->gettotalbpjs_perbulan($idpengantar); 
	?>
	<div class='row text text-danger'>
          <div class='col-md-6'><b>Total Potongan</b></div>
          <div class='col-md-6' align='right'><b><?php echo "Rp. ".number_format($totpoto,0,",","."); ?></b></div>
        </div>
	<br />
        <div class='row text text-primary'>
          <div class='col-md-6'><b>TOTAL TAKE HOME PAY</b></div>
          <div class='col-md-6' align='right'><b><?php echo "Rp. ".number_format($this->mtppng2024->gettotalthp_perbulan($idpengantar),0,",","."); ?></b></div>
        </div>
      </blockquote>
    </div>
  </div>
  </small>

</div>
</div>
<div align='right'>
<?php
  $jml = $this->mtppng2024->get_jmlperpengantar($idpengantar);
  $uda = $this->session->userdata('nip');
  if ($jml != 0) {
    $cekstatusinput = $this->mtppng2024->cek_adastatusinput($idpengantar);
    $statuspengantar = $this->mtppng2024->get_statuspengantar($idpengantar);

    // Cek apakah masih ada yg belum Sync dengan SiGapok
    $cekstatussyncgaji = $this->mtppng2024->cek_adabelumsyncgaji($idpengantar);

    if (($cekstatusinput == 0) AND ($statuspengantar == "SKPD")) {
      echo "<form method='POST' action='../tppng2024/valid_pengantar'>";
      echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
      echo "<input type='hidden' name='id_periode' id='id_periode' value='$idperiode'>";
      ?>
      <button type="submit" class="btn btn-primary btn-outline btn-xl ">
        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>&nbspKirim ke BKPSDM untuk Approval
      </button>
      <?php
      echo "</form>";
    } else if (($statuspengantar == "BKPSDM") AND ($uda == '198104072009041002')) {
      echo "<form method='POST' action='../tppng2024/approve_pengantar'>";
      echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
      echo "<input type='hidden' name='id_periode' id='id_periode' value='$idperiode'>";
      ?>
      <button type="submit" class="btn btn-primary btn-outline btn-xl ">
        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>&nbspAPPROVE KALKULASI
      </button>
      <?php
      echo "</form>";
    } else if (($cekstatussyncgaji == 0) AND ($statuspengantar == "APPROVED")) {
    //} else if (($statuspengantar == "APPROVED") AND ($uda == '198104072009041002')) {
      if (($tahunperiode == '2024') AND ($bulanperiode == '14')) { // Tambah Data THR 	
      ?>	
        <!--
	<button type='button' class='btn btn-primary btn-outline btn-xl' data-toggle='modal' data-target='#spesimen'>
              <span class='glyphicon glyphicon-print' aria-hidden='true'></span><br/>Spesimen dan Cetak TPP THR 2024
        </button>
	-->
      <?php
      } else {
      ?>
	<button type='button' class='btn btn-info btn-outline btn-xl' data-toggle='modal' data-target='#spesimen'>
              <span class='glyphicon glyphicon-print' aria-hidden='true'></span><br/>Spesimen dan Cetak
        </button>
      <?php	
      }	
    }

    //if (($statuspengantar == "CETAK") AND ($uda == '198104072009041002') OR ($uda == '199204072015032002')) {
    if (($statuspengantar == "CETAK") AND ($cekstatussyncgaji == 0)) {
    //if ($statuspengantar == "CETAK") {
      if (($tahunperiode == '2024') AND ($bulanperiode == '14')) { // Tambah Data THR
      ?>
	<button type='button' class='btn btn-info btn-outline btn-xl' data-toggle='modal' data-target='#spesimen'>
              <span class='glyphicon glyphicon-print' aria-hidden='true'></span><br/>Spesimen dan Cetak TPP THR 2024
        </button>      	
        <button type='button' class='btn btn-success btn-outline btn-xl' data-toggle='modal' data-target='#uploadsp2d'>
              <span class='glyphicon glyphicon-open-file' aria-hidden='true'></span><br/>Upload Tanda Terima
        </button>
      <?php
      } else {
      ?>	
	<button type='button' class='btn btn-info btn-outline btn-xl' data-toggle='modal' data-target='#spesimen'>
              <span class='glyphicon glyphicon-print' aria-hidden='true'></span><br/>Spesimen dan Cetak
        </button>
        <button type='button' class='btn btn-success btn-outline btn-xl' data-toggle='modal' data-target='#uploadsp2d'>
              <span class='glyphicon glyphicon-open-file' aria-hidden='true'></span><br/>Upload Tanda Terima
        </button>	
      <?php
      }
    }

  }
?>
</div>
</div>
</div>
</center>
<script>
  function inputAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
      return true;
  }

  // Fungsi menambahkan titik pada input angka (lanjutan dari fungsi numberonly)
  function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");
	b=b.replace("-","");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)){
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	if (_minus) c = "-" + c ;
	return c;
  }

  // Fungsi input data hanya angka
  function numbersonly(ini, e){
	if (e.keyCode>=49){
		if(e.keyCode<=57){
			a = ini.value.toString().replace(".","");
			b = a.replace(/[^\d]/g,"");
			b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
			ini.value = tandaPemisahTitik(b);
			return false;
		}
		else if(e.keyCode<=105){
			if(e.keyCode>=96){
				//e.keycode = e.keycode - 47;
				a = ini.value.toString().replace(".","");	
				b = a.replace(/[^\d]/g,"");
				b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
				ini.value = tandaPemisahTitik(b);
				//alert(e.keycode);
				return false;
			}
			else {return false;}
		}
		else {
			return false;
		}
	}else if (e.keyCode==48){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==95){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==8 || e.keycode==46){
		a = ini.value.replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = b.substr(0,b.length -1);
		if (tandaPemisahTitik(b)!=""){
			ini.value = tandaPemisahTitik(b);
		} else {
			ini.value = "";
		}
		return false;
	} else if (e.keyCode==9){
		return true;
	} else if (e.keyCode==17){
		return true;
	} else {
		alert (e.keyCode);
	return false;
	}
  }
</script>

<!-- MOdal SP2D -->
<!-- Modal -->
<div class="modal fade" id="uploadsp2d" tabindex="-1" role="dialog" aria-labelledby="uploadsp2dLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form method='POST' name='formtandaterima' action='../tppng2024/kirim_tandaterima' enctype="multipart/form-data">
  <input type='hidden' name='idpengantar' id='idpengantar' value='<?php echo $v['fid_pengantar']; ?>' />
  <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $v['fid_periode']; ?>' />  
  <input type='hidden' name='id_unor' id='id_unor' value='<?php echo $v['fid_unker']; ?>' />  
  <input type='hidden' name='berkaslama' id='berkaslama' value='<?php echo $v['berkas']; ?>' /> 
  
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class='modal-title' style="font-weight:bold;">PEMBAYARAN</h5>
        <div>UPLOAD BUKTI PEMBAYARAN</div>
        
      </div>
      <div class="modal-body">
        <?php 
          if($v['berkas'] != ''):
        ?>
        <div style="display:flex; justify-content: space-between; align-items: center; background: pink; border: 1px dashed #ededed; padding: 8px; border-radius: 8px">
          <b>
            Unduh/Download File
            <br>
            <?php
              echo $v['berkas'];
            ?>
          </b>
          <div>
            <a href="<?= base_url('filetppng2024/'.$v['berkas'].'.pdf') ?>" target="_blank" class="btn btn-sm btn-success"><span class='glyphicon glyphicon-download' aria-hidden='true'></span> Download</a>
          </div>
        </div>
        <hr>
        <?php endif; ?>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#form" aria-controls="form" role="tab" data-toggle="tab">Data Pembayaran</a></li>
          <li role="presentation"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">Upload Eviden</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="form" style="padding-top: 3%">
            <!-- SPM -->
            <div class="form-inline">
                <div class="form-group">
                  <label for="nospm">NO. SPM</label> <br>
                  <input type="text" class="form-control" name="nospm" id="nospm" size="40" aria-describedby="emailHelp" placeholder="NOMOR SPM" required="required">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="tglspm">TGL SPM</label> <br>
                  <input type="text" class="form-control tanggal" name="tglspm" id="tglspm" aria-describedby="emailHelp" required="required">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
            </div>
            <hr>
            <!-- SP2D -->
            <div class="form-inline">
              <div class="form-group">
                <label for="nosp2d">NO. SP2D</label><br>
                <input type="text" class="form-control" name="nosp2d"  size="40" id="nosp2d" aria-describedby="emailHelp" placeholder="NOMOR SP2D" required="required">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>

              <div class="form-group" style="width:20%">
                <label for="tglsp2d">TGL SP2D</label><br>
                <input type="text" class="form-control tanggal" name="tglsp2d" id="tglsp2d" aria-describedby="emailHelp" required="required">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>
            </div>
            <hr>
            <!-- COUNTING -->
            <div class="form-inline">
              <div class="form-group" style="width:30%">
                <label for="jml_dipinta">JUMLAH DIPINTA</label><br>
                <input type="text" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" name="jml_dipinta" id="jml_dipinta" style="width:100%" placeholder="DIPINTA" required="required">
              </div>

              <div class="form-group" style="width:30%">
                <label for="jml_potongan">JUMLAH POTONGAN</label><br>
                <input type="text" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" name="jml_potongan" id="jml_potongan"style="width:100%" placeholder="POTONGAN" required="required">
              </div>

              <div class="form-group" style="width:30%">
                <label for="jml_dibayar">JUMLAH DIBAYAR</label><br>
                <input type="text" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" name="jml_dibayar" id="jml_dibayar"style="width:100%" placeholder="DIBAYARKAN" required="required">
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="upload" style="padding-top: 3%">
            <div class="form-group" style="border-left: 3px solid #ededed; padding-left: 15px;">
              <label for="berkastppng_pengantar">File Upload</label> 
              <input type="file" name="berkastppng_pengantar" id="berkastppng_pengantar" required="required">
              <p class="help-block">Silahkan upload file Tanda Terima yang sudah ditandatangani lengkap, SP2D dan SPM,<br/>file format PDF dan maksimal ukuran 1,5 MB.</p>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-open-file' aria-hidden='true'></span> KIRIM</button>
      </div>
    </div>
  </form>
  </div>
</div>
<!-- End Modal SP2D -->


<!-- Modal Spesimen -->
          <div id="spesimen" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xs modal-dialog-centered">
              <div class="modal-content">
                <div class='modal-header'>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class='modal-title' style="font-weight:bold;">SPESIMEN</h5>
                  <?php
                    $id_unker_pengantar = $this->mtppng2024->get_idunker($idpengantar);
                    echo $this->munker->getnamaunker($id_unker_pengantar);
                  ?>                  

                </div> <!-- End Header -->
                <div class="modal-body" align="left">
		  <?php
		  if (($tahunperiode == '2023') AND ($bulanperiode == '15')) { // Tambah Data THR
		  ?>
                     <form method='POST' name='formspesimen' action='../tppng2024/cetak_tandaterimathr' target='_blank'>
                  <?php
		  } else {
		  ?>
		     <form method='POST' name='formspesimen' action='../tppng2024/cetak_tandaterima' target='_blank'>	
		  <?php
		  }
		  ?>
		  <input type='hidden' name='idpengantar' id='idpengantar' value='<?php echo $v['fid_pengantar']; ?>' />
                  <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $v['fid_periode']; ?>' />
                  <div class='row'>
                    <div class='col-md-6' align="left">
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">BENDAHARA</span></span>
                        <input class="form-control" type="text" name="nipbend" id="nipbend" placeholder="Entri NIP Bendahara" value="" width="20" maxlength="18" />
                      </div>
                    </div>
                    <div class='col-md-1' align="right">
                      <div class="form-group input-group">
                        <button type="button" class="btn btn-success btn-outline" onClick="showDataBendahara(nipbend.value)" >
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        </button>
                      </div>
                    </div>
                    <div class='col-md-5' align="right">
                      <h6><div id='tampilbendahara'></div></h6>
                    </div>
                  </div> <!-- End Row NIP Bendahara -->
                  <div class='row'>
                    <div class='col-md-6' align="left">
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 11px;"><span class="text text-primary">KEPALA SKPD</span></span>
                        <input class="form-control" type="text" name="nipkep" id="nipkep" placeholder="Entri NIP Kepala SKPD" value="" width="20" maxlength="18" />
                      </div>
                    </div>
                    <div class='col-md-1' align="right">
                      <div class="form-group input-group">
                        <button type="button" class="btn btn-primary btn-outline" onClick="showDataKepala(nipkep.value)" >
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="false"></span>
                        </button>
                      </div>
                    </div>
                    <div class='col-md-5' align="right">
                      <h6><div id='tampilkepala'></div></h6>
                    </div>
                  </div> <!-- End Row NIP Bendahara -->
                  <div class='row'>         
                      <div class='col-md-12' align="right">
                        <div class="form-group input-group">
                          <button type="submit" class="btn btn-success btn-outline btn-sm">
                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span><br/>Cetak PDF
                          </button>
                        </div>
                      </div>
                  </div> <!-- End Row Tombol -->
                  </form> <!-- End Form formspesimen -->
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal Spesimen -->


<!-- Modal Tambah Data -->
<div id="tampiltambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
<!--<div id="tampiltambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="padding:10px;overflow:auto;width:100%;height:90%;">-->
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" style="padding:10px;width:60%;height:auto;">
    <!-- konten modal-->
    <div class="modal-content">
      <?php
        $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
	$tahun = $this->mtppng2024->get_tahunperiode($idperiode);
        $bulan = $this->mtppng2024->get_bulanperiode($idperiode);
      ?>
      <!-- heading modal -->
      <?php
      // Untuk Header Modal
      if ($jnsasn == "PNS") {
        echo "<div class='modal-header' style='background-color : #BDB76B;'>";
        echo "<h4 class='modal-title'>Tambah Kalkulasi TPP PNS Periode ".bulan($bulan)." ".$tahun."</h4>";
        echo "</div>";
      } else if ($jnsasn == "PPPK") {
        echo "<div class='modal-header' style='background-color : #778899;'>";
        echo "<h4 class='modal-title'>Tambah Kalkulasi TPP PPPK Periode ".bulan($bulan)." ".$tahun."</h4>";
        echo "</div>";
      }
      ?>
              <!-- body modal-->
              
              <div class="modal-body" align="left"">   
                <form method='POST' name='formkalk' style='padding-top:8px' action='../tppng2024/tmbkalk_aksi'>
                  <input type='hidden' name='idpengantar' id='idpengantar' value='<?php echo $idpengantar; ?>'>
                  <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $idperiode; ?>'>
                  <input type='hidden' name='jnsasn' id='jnsasn' value='<?php echo $jnsasn; ?>'>
                  <div class='row'>                                                
                    <div class='col-md-12'>
                      <div class="form-group input-group">    
                        <span class="input-group-addon" style="font-size: 12px;">Unit Kerja</span>
                        <?php
                        $nmunker = $this->munker->getnamaunker($idunor);
                        ?>
                        <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $nmunker; ?>" disabled=""  style="font-size: 12px;">
                      </div>                        
                    </div>
                  </div> <!-- End Row Unit Kerja -->
                  <div class='row'>                       
                    <div class='col-md-4' align="right">
                      <div class="form-group input-group">
                        <?php 
                          if ($jnsasn == "PNS") {
			    $ident = "NIP";	
			    $pegunker = $this->munker-> pegperunker($idunor)->result_array();
                            echo "<span class='input-group-addon' style='font-size: 12px;'>Pilih PNS</span>";
                          } else if ($jnsasn == "PPPK") {
			    $pegunker = $this->munker-> pppkperunker($idunor)->result_array();
			    $ident = "NIPPPK";
                            echo "<span class='input-group-addon' style='font-size: 12px;'>Pilih PPPK</span>";
                          }
                        ?>                        
			<!--
                        <input class="form-control" type='text' name='nip' id='nip' value='' width="10" maxlength="18" />
			-->	
			<?php
			// Start Select NIP
			//if ($this->session->userdata('nip') == "198104072009041002") {
			  echo "<select class='form-control' name='nip' id='nip' required style='font-size: 12px; width: 200%;' 
				onChange='showData_jabblnlalu(formkalk.nip.value, formkalk.idperiode.value, formkalk.jnsasn.value)' >";
			  echo "<option value='' selected>".$ident." - NAMA</option>";
                          if ($pegunker) {
                            foreach($pegunker as $pu)
                            {
				$telahusul = $this->mtppng2024->cektelahusul($pu['nip'], $tahunperiode, $bulanperiode);
				if ($telahusul == '0') {
                              	   echo "<option value='".$pu['nip']."'>".$pu['nip']." - ".$pu['nama']."</option>";
				}
                            }
			  }	
			  echo "</select>";
			//}
			// End entri Select NIP
			?>

                      </div>
                    </div>       
                  </div> <!-- End Row NIP -->
		  <div id='tampil_jabblnlalu'></div>

                  <span class='text text-info'>Pilih Jabatan Definitif yang akan digunakan untuk perhitungan TPP Periode <?php echo bulan($bulan)." ".$tahun; ?></span>
                  <div class='row'>                       
                    <div class='col-md-12' align="right">
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 12px;">Jabatan Definitif</span>
                        <select class="form-control" name="idjabpeta" id="idjabpeta" required style="font-size: 11px;">
                          <?php
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          $jabstruk = $this->mpetajab->jabstruk_peta($idunor)->result_array();
                          if ($jabstruk) {
                            foreach($jabstruk as $js)
                            {
			      if ($js['approved'] == 'Y') {	
                              	echo "<option value='".$js['id']."'>".$js['nama_jabatan']."</option>";
			      }		
                            }
                          }
                          $jabfu = $this->mpetajab->getjabfu_perunker($idunor)->result_array();
                          if ($jabfu) {
                            foreach($jabfu as $ju)
                            {
                              //$atasanju = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
			      if ($ju['approved'] == 'Y') {
			      	$atasanju = $this->mpetajab->get_namajab($ju['fid_atasan']);
			      	$kelasju = $this->mpetajab->get_kelas($ju['id']);
                              	echo "<option value='".$ju['id']."'>".$ju['nama_jabfu']." - ".$ju['koord_subkoord']." (Kelas : ".$kelasju.") (Atasan : ".$atasanju.")</option>";
			      }
                            }
                          }                              
                          $jabft = $this->mpetajab->getjabft_perunker($idunor)->result_array();
                          if ($jabft) {
                            foreach($jabft as $jt)
                            {
			      if ($jt['approved'] == 'Y') {
                                $atasanjt = $this->mpetajab->get_namajab($jt['fid_atasan']);
			        $kelasjt = $this->mpetajab->get_kelas($jt['id']);
			        //if ($jt['koord_subkoord']) {
				  //$ket = $jt['koord_subkoord'];
			        //} else {
				  //$ket = "Atasan : ".$atasanjt;
			        //}
			        echo "<option value='".$jt['id']."'>".$jt['nama_jabft']." - ".$jt['koord_subkoord']." (Kelas : ".$kelasjt.") (Atasan : ".$atasanjt.")</option>";
                                //echo "<option value='".$jt['id']."'>".$jt['nama_jabft']." (".$ket.")</option>";
			      } 
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div> <!-- End Row Jabatan Definitif -->
	
                  <?php
                    //if ($jnsasn == "PNS") {
                  ?>
                  <span class='text text-info'>Pilih Jabatan PLT (Jika ada) dan Persentase Tambahan PLT,</span>
                  <span class='text text-danger'>SYARAT minimal 1 (satu) bulan Kalender</span>
                  <div class='row'>                       
                    <div class='col-md-9' align="right">
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 12px;">Jabatan PLT (JIka Ada)</span>
                        <select class="form-control" name="idjabpltpeta" id="idjabpltpeta" style="font-size: 11px;">
                          <?php
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          $jabstruk = $this->mpetajab->jabstruk_peta($idunor)->result_array();
                          if ($jabstruk) {
                            foreach($jabstruk as $js)
                            {
			      if ($js['approved'] == 'Y') {	
                              	echo "<option value='".$js['id']."'>".$js['nama_jabatan']."</option>";
			      }
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class='col-md-3' align="right">
                      <select class="form-control" name="jnsplt" id="jnsplt" style="font-size: 11px;">
                        <option value="">-- % Tambahan PLT --</option>
                        <option value="plt100">100% (Satu tingkat diatas)</option>
                        <option value="plt20">20% (Setingkat)</option>
                      </select>
                    </div>
                  </div> <!-- End Row PLT -->
                  <?php
                  //}
                  ?>
                  <div class='row'>
                    <div class='col-md-8'>
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 12px;">Faktor Pengurangan</span>
                        <select class='form-control' name='pengurang' id='pengurang' style="font-size: 11px;">
                          <option value='' selected>-- TANPA FAKTOR PENGURANG --</option>
                          <option value='mkd7h'>MASUK KERJA KURANG DARI 7 HARI</option>
                          <option value='k40'>CUTI 1 SAMPAI 6 BULAN</option>
                          <option value='k20'>CUTI 6 SAMPAI 12 BULAN</option>
                          <option value='k100'>CUTI DIATAS 12 BULAN, MPP, HUKDIS, CLTN, ASN TITIPAN/DIPERBANTUKAN</option>
                        </select>
                      </div>
                    </div>   
                    <!--     
                    <div class='col-md-8'>
                      <small>
                        20 % : Cuti sakit 6 sampai 12 bulan<br/>
                        40 % : Cuti besar dan cuti sakit kurang dari 6 bulan<br/>
                        100 % : Cuti sakit diatas 12 bulan, MPP, Pegawai Titipan, Menjalani Hukdis, CLTN, diperbantukan<br/>
                        Masuk Kerja kuang dari 7 (tujuh) Hari, baik karena Cuti, TL, TK atau Alasan lainnya<br/>

                      </small>
                    </div>
                    -->
                  </div> <!-- end ROW FAKTOR PENGURANG -->

                  <div class='row'>
                    <div class='col-md-12' align="center">
                      <button type="button" class="btn btn-success btn-outline btn-lg" 
			onclick="showDataKalkulasi(formkalk.nip.value, formkalk.idperiode.value, formkalk.idpengantar.value, 
				formkalk.idjabpeta.value, formkalk.idjabpltpeta.value, formkalk.jnsplt.value, formkalk.pengurang.value)" >
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Kalkulasi TPP
                      </button>
                    </div>
                  </div>
                  <div class='row'>  
                    <div class='col-md-12' style="padding:10px;width:100%;height:100%;">
                      <div id='tampilkal'></div>
                    </div>
                  </div>
                </form>
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Tambah Data -->

<!-- Modal Tambah Data THR -->
<div id="tampiltambahthr" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
<!--<div id="tampiltambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="padding:10px;overflow:auto;width:100%;height:90%;">-->
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" style="padding:10px;width:60%;height:auto;">
    <!-- konten modal-->
    <div class="modal-content">
      <?php
        $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
      ?>
      <!-- heading modal -->
      <?php
      // Untuk Header Modal
      if ($jnsasn == "PNS") {
        echo "<div class='modal-header' style='background-color : #BDB76B;'>";
        echo "<h4 class='modal-title'>Tambah Kalkulasi TPP THR PNS</h4>";
        echo "</div>";
      } else if ($jnsasn == "PPPK") {
        echo "<div class='modal-header' style='background-color : #778899;'>";
        echo "<h4 class='modal-title'>Tambah Kalkulasi TPP THR PPPK</h4>";
        echo "</div>";
      }
      ?>
              <!-- body modal-->
              <div class="modal-body" align="left"">
                <form method='POST' name='formkalkthr' style='padding-top:8px' action='../tppng2024/tmbkalkthr_aksi'>
                  <input type='hidden' name='idpengantar' id='idpengantar' value='<?php echo $idpengantar; ?>'>
                  <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $idperiode; ?>'>
                  <div class='row'>
		    <div class='col-md-12'>
                        <div class="alert alert-info" role="alert"><strong>PERHATIAN !</strong><br/>
			- TPP THR Tahun 2024 berdasarkan status kedudukan dan posisi jabatan ASN sesuai TPP  Februari 2024<br/>
			- ASN yang berhak TPP THR Tahun 2024 adalah ASN yang menerima TPP Februari 2024 (dibayarkan Maret 2024)<br/>
			- ASN PPPK formasi tahun 2023 (SPMT 1 Maret 2024) tidak berhak menerima TPP THR Tahun 2024
			</div>
                    </div>	
                    <div class='col-md-12'>
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 12px;">Unit Kerja</span>
                        <?php
                        $nmunker = $this->munker->getnamaunker($idunor);
                        ?>
                        <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $nmunker; ?>" disabled=""  style="font-size: 12px;">
                      </div>
                    </div>
                  </div> <!-- End Row Unit Kerja -->
                  <div class='row'>
                    <div class='col-md-4' align="right">
                      <div class="form-group input-group">
                        <?php
                          if ($jnsasn == "PNS") {
                            $ident = "NIP";
                            $pegunker = $this->mtppng2024->pegperunker($idunor)->result_array();
                            echo "<span class='input-group-addon' style='font-size: 12px;'>Pilih PNS</span>";
                          } else if ($jnsasn == "PPPK") {
                            $pegunker = $this->mtppng2024->pppkperunker($idunor)->result_array();
                            $ident = "NIPPPK";
                            echo "<span class='input-group-addon' style='font-size: 12px;'>Pilih PPPK</span>";
                          }
                        ?>
                        <!--
                        <input class="form-control" type='text' name='nip' id='nip' value='' width="10" maxlength="18" />
                        -->
                        <?php
                        // Start Select NIP
                        //if ($this->session->userdata('nip') == "198104072009041002") {
                          echo "<select class='form-control' name='nip' id='nip' required style='font-size: 12px; width: 200%;'>";
                          echo "<option value='' selected>".$ident." - NAMA</option>";
                          if ($pegunker) {
                            foreach($pegunker as $pu)
                            {
                                $telahusul = $this->mtppng2024->cektelahusul($pu['nip'], $tahunperiode, $bulanperiode);
                                if ($telahusul == '0') {
                                   echo "<option value='".$pu['nip']."'>".$pu['nip']." - ".$pu['nama']."</option>";
                                }
                            }
                          }
                          echo "</select>";
                        //}
                        // End entri Select NIP
                        ?>

                      </div>
                    </div>
                  </div> <!-- End Row NIP -->
                  <span class='text text-info'>Pilih Jabatan Definitif yang akan digunakan untuk perhitungan TPP THR 2024</span>, 
		  <span class='text text-danger'>WAJIB sama dengan jabatan pada TPP Februari 2024</span>
                  <div class='row'>
                    <div class='col-md-12' align="right">
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 12px;">Jabatan Definitif</span>
                        <select class="form-control" name="idjabpeta" id="idjabpeta" required style="font-size: 11px;">
                          <?php
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          $jabstruk = $this->mpetajab->jabstruk_peta($idunor)->result_array();
                          if ($jabstruk) {
                            foreach($jabstruk as $js)
                            {
			      if ($js['approved'] == 'Y') {	
                              	echo "<option value='".$js['id']."'>".$js['nama_jabatan']."</option>";
			      }
                            }
                          }
                          $jabfu = $this->mpetajab->getjabfu_perunker($idunor)->result_array();
                          if ($jabfu) {
                            foreach($jabfu as $ju)
                            {
			      if ($ju['approved'] == 'Y') {	
                              	//$atasanju = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
                              	$atasanju = $this->mpetajab->get_namajab($ju['fid_atasan']);
                              	$kelasju = $this->mpetajab->get_kelas($ju['id']);
                              	echo "<option value='".$ju['id']."'>".$ju['nama_jabfu']." - ".$ju['koord_subkoord']." (Kelas : ".$kelasju.") (Atasan : ".$atasanju.")</option>";
			      } 	
                            }
                          }
                          $jabft = $this->mpetajab->getjabft_perunker($idunor)->result_array();
                          if ($jabft) {
                            foreach($jabft as $jt)
                            {
			      if ($jt['approved'] == 'Y') {	
                              	$atasanjt = $this->mpetajab->get_namajab($jt['fid_atasan']);
                              	$kelasjt = $this->mpetajab->get_kelas($jt['id']);
                              	//if ($jt['koord_subkoord']) {
                                	//$ket = $jt['koord_subkoord'];
                              	//} else {
                                	//$ket = "Atasan : ".$atasanjt;
                              	//}
                              	echo "<option value='".$jt['id']."'>".$jt['nama_jabft']." - ".$jt['koord_subkoord']." (Kelas : ".$kelasjt.") (Atasan : ".$atasanjt.")</option>";
                                //echo "<option value='".$jt['id']."'>".$jt['nama_jabft']." (".$ket.")</option>";
			      }	
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div> <!-- End Row Jabatan Definitif -->
                  <?php
                    //if ($jnsasn == "PNS") {
                  ?>
                  <span class='text text-info'>Pilih Jabatan PLT (Jika ada) dan Persentase Tambahan PLT,</span>
                  <span class='text text-danger'>SYARAT minimal 1 (satu) bulan Kalender</span>
                  <div class='row'>
                    <div class='col-md-9' align="right">
                      <div class="form-group input-group">
                        <span class="input-group-addon" style="font-size: 12px;">Jabatan PLT (JIka Ada)</span>
                        <select class="form-control" name="idjabpltpeta" id="idjabpltpeta" style="font-size: 11px;">
                          <?php
                          echo "<option value='0' selected>-- Pilih Jabatan --</option>";
                          $jabstruk = $this->mpetajab->jabstruk_peta($idunor)->result_array();
                          if ($jabstruk) {
                            foreach($jabstruk as $js)
                            {
			      if ($js['approved'] == 'Y') {	
	                      	echo "<option value='".$js['id']."'>".$js['nama_jabatan']."</option>";
			      }
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class='col-md-3' align="right">
                      <select class="form-control" name="jnsplt" id="jnsplt" style="font-size: 11px;">
                        <option value="">-- % Tambahan PLT --</option>
                        <option value="plt100">100% (Satu tingkat diatas)</option>
                        <option value="plt20">20% (Setingkat)</option>
                      </select>
                    </div>
                  </div> <!-- End Row PLT -->
                  <?php
                  //}
                  ?>

                  <div class='row'>
                    <div class='col-md-12' align="center">
                      <button type="button" class="btn btn-success btn-outline btn-lg"
                        onclick="showDataKalkulasiThr(formkalkthr.nip.value, formkalkthr.idperiode.value, formkalkthr.idpengantar.value,
                                formkalkthr.idjabpeta.value, formkalkthr.idjabpltpeta.value, formkalkthr.jnsplt.value)" >
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Kalkulasi TPP THR 2024
                      </button>
                    </div>
                  </div>
                  <div class='row'>
                    <div class='col-md-12' style="padding:10px;width:100%;height:100%;">
                      <div id='tampilkalthr'></div>
                    </div>
                  </div>
                </form>
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Tambah Data -->

<!-- End Modal Tambah Data THR -->


<!-- Modal Update Status -->
<div id="updatestatus<?php echo $idpengantar; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class='modal-header'>
      <?php
        $bln = $this->mtppng2024->get_bulanperiode($idperiode);
        $thn = $this->mtppng2024->get_tahunperiode($idperiode);
        echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>Updating Status TPP Perorangan";
        echo "<br/><h5 class='modal-title text text-muted'>".$this->munker->getnamaunker($idunor)."</h5>";
        echo "<h5 class='modal-title text text-muted'>Periode ".bulan($bln)." ".$thn."</h5>";
	echo "<h5 class='modal-title text text-muted'>Jenis ASN : ".$this->mtppng2024->get_jnsasn($idpengantar)."</h5>";
      ?>
      </div> <!-- End Header -->
      <div class="modal-body" align="left">
        <form method='POST' name='formupdatestatus' style='padding-top:8px' action='../tppng2024/updatestatusperorangan_aksi'>
          <input type='hidden' name='idpengantar' id='idpengantar' value='<?php echo $idpengantar; ?>'>
          <input type='hidden' name='idperiode' id='idperiode' value='<?php echo $idperiode; ?>'>
	  <input type='hidden' name='idunor' id='idunor' value='<?php echo $idunor; ?>'>
          <div class='row'>
            <div class='col-md-12'>
              <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;">ASN</span>
                  <select class="form-control" name="id" id="id" required style="font-size: 12px;">
                    <?php
                    echo "<option value='' selected>-- Pilih ASN --</option>";
		    $no = 1;	
                    foreach($data as $d)
                    {
                      $nama = $this->mpegawai->getnama($d['nip']);
                      echo "<option value='".$d['id']."'>".$no.". ".$nama." - NIP. ".$d['nip']."</option>";
		      $no++;	
                    }
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
		    <?php
                    echo "<option value='0' selected>-- Pilih Status --</option>";
		    $stat = $this->mtppng2024->statustppng()->result_array();
                    foreach($stat as $s)
                    {
                      echo "<option value='".$s['id_status']."'>".$s['nama_status']."</option>";
                      $no++;
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-12' align="right">
                <button type="submit" class="btn btn-success btn-outline btn-xl" >
                  <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Update Status
                </button>
              </div>
            </div>
          </form>
        </div> <!-- End Modal body -->
      </div>
    </div>
  </div>
</div>
<!-- End Modal Update Status -->
