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
	if ($this->mtppng->get_statusperiode($idperiode) == "OPEN") {
	//if ($this->session->userdata('level') == "ADMIN") {
      ?>     
      <td align='right'>
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tampiltambah">
	<span class="fa fa-plus-square-o" aria-hidden="true"></span> Tambah Unit Kerja</button>
      </td>
      <?php
        } 
      ?>
     
      <td align='right' width='50'>
        <form method="POST" action="../tppng/periode">
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
  <b>KALKULASI TPP</b>
  <?php
    $blnperiode = $this->mtppng->get_bulanperiode($idperiode);
    $thnperiode = $this->mtppng->get_tahunperiode($idperiode);
    echo "<b>PERIODE ".strtoupper(bulan($blnperiode))." ".$thnperiode."</b>"; 
  ?>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:380px;border:1px solid white" >
  <table class="table table table-condensed table-hover"  style='font-size: 11px;'>
      <tr class='success'>
        <td align='center' rowspan='2'><b>No.</b></td>
        <td align='center' width='' rowspan='2'><b>Unit Kerja</b></td>
        <td align='center' width='100' rowspan='2'><b>Rata Kinerja<br/>Rata Absensi</b></td>
        <td align='center' width='100' rowspan='2'><b>Jenis<br/>Jml Data<br/>Jml ASN Berhak TPP</b></td>
        <td align='center' colspan='4'><b>Total Kriteria</b></td>            
        <td align='center' width='120' rowspan='2'><b>Total Realisasi</b></td>
        <td align='center' width='120' rowspan='2'><b>Total PPh21<br/>Total IWP 1%<br/>Total BPJS 4%</b></td>
        <td align='center' width='120' rowspan='2'><b>Total THP</b></td>
        <td align='center' width='120' rowspan='2'><b>Status Posisi</b></td>
        <td align='center' rowspan='3' colspan='2' width='50'><b>Aksi</b></td>
      </tr>
      <tr class='success'>
        <td align='center' width='90'><b>Beban Kerja</b></td>
        <td align='center' width='90'><b>Prestasi Kerja</b></td>
        <td align='center' width='90'><b>Kondisi Kerja</b></td>
        <td align='center' width='90'><b>Kelangkaan Profesi</b></td>
      </tr>
      <tr class='success' style='font-size: 9px; font-style: italic;'>
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
        <td align='center'>11 (9-10)</td>
        <td align='center'>12</td>
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
        <td align='center'><?php echo round($this->mtppng->getratakinerja_perbulan($v['id']),2)."<br/>".round($this->mtppng->getrataabsensi_perbulan($v['id']),2); ?></td>
        <td align='center'>
          <?php 
            $jnsasn = $this->mtppng->get_jnsasn($v['id']);
            if ($jnsasn == "PNS") {
              echo "<span class='label label-primary'><b>".$v['jenis_asn']."</b></span>";
	      $jmlasn = $this->mkinerja->getjmlpeg_berhaktpp_perunker($v['fid_unker']);
            } else if ($jnsasn == "PPPK") {
              echo "<span class='label label-default'><b>".$v['jenis_asn']."</b></span>";
	      $jmlasn = $this->mkinerja_pppk->getjmlpeg_berhaktpp_perunker($v['fid_unker']);
            } 
            echo "<br/>".$this->mtppng->get_jmlperpengantar($v['id']);
	    echo "<br/>".$jmlasn;
          ?>
        </td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalbk_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalpk_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalkk_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalkp_perbulan($v['id']),0,",","."); ?></td>
        <td align='right'><?php echo "Rp. ".number_format($this->mtppng->gettotalreal_perbulan($v['id']),0,",",".") ?></td>
        <?php
          $totalpph = number_format($this->mtppng->gettotalpph_perbulan($v['id']),0,",",".");
          $totaliwp = number_format($this->mtppng->gettotaliwp_perbulan($v['id']),0,",",".");
          $totaliwp = number_format($this->mtppng->gettotalbpjs_perbulan($v['id']),0,",",".");
          $totalthp = number_format($this->mtppng->gettotalthp_perbulan($v['id']),0,",",".");
        ?>
        <td align='right'><?php echo "Rp. ".$totalpph."<br/>Rp. ".$totaliwp; ?></td>
        <td align='right'><?php echo "Rp. ".$totalthp; ?></td>
        <td align='center'>
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
        <td align='center'>
          <?php
          echo "<form method='POST' action='../tppng/detailperiodeunor'>";
          echo "<input type='hidden' name='id_periode' id='id_periode' value='$v[fid_periode]'>";
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id]'>";
          echo "<input type='hidden' name='id_unor' id='id_unor' value='$v[fid_unker]'>";
          ?>
          <button type="submit" class="btn btn-success btn-outline btn-xs ">
          <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Detail
          </button>
          <?php
            echo "</form>";
          ?>
        </td>   
        <?php
        $jmldata = $this->mtppng->get_jmlperpengantar($v['id']);
        if ($jmldata == 0) {
        ?>
        <td align='center'>
          <?php
          echo "<form method='POST' action='../tppng/hapuspengantar'>";
          echo "<input type='hidden' name='id_periode' id='id_periode' value='$v[fid_periode]'>";
          echo "<input type='hidden' name='id_unor' id='id_unor' value='$v[fid_unker]'>";
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-outline btn-xs ">
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
        <h4 class="modal-title">Tambah Unit Kerja</h4>
      </div>
      <div class="modal-body" align="left"">   
        <form method='POST' name='formkalk' style='padding-top:8px' action='../tppng/tmbunorperiode_aksi'>
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
                <button type="submit" class="btn btn-success btn-outline btn-sm" >
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Simpan
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
