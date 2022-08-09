<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pensiun extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load Helper 
        $this->load->helper(array('url','form','fungsitanggal','fungsipegawai','file','storage','number'));
        // Load Model
        $this->load->model(array('mpegawai','mpensiun','munker','mpip', 'msantunan_korpri' => 'korpri'));
		
				// Cek Session
		    if (!$this->session->userdata('nama'))
		    {
		      redirect('login');
		    }
    }

    /*=============================================
	BEGIN REKAPITULASI, STATISTIK, DAN PROYEKSI
    */
 
    function rekap() {
    //if ($this->session->userdata('usulkgb_priv') == "Y") {
      $data['tahun'] = $this->mpensiun->gettahuntmt()->result_array();
      $data['content'] = 'pensiun/rekap';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    //}
  }
  
  function bulan($number) {
  	switch ($number) {
  		case 1: echo 'Januari'; break;
  		case 2: echo 'Februari'; break;
  		case 3: echo 'Maret'; break;
  		case 4: echo 'April'; break;
  		case 5: echo 'Mei'; break;
  		case 6: echo 'Juni'; break;
  		case 7: echo 'Juli'; break;
  		case 8: echo 'Agustus'; break;
  		case 9: echo 'September'; break;
  		case 10: echo 'Oktober'; break;
  		case 11: echo 'November'; break;
  		case 12: echo 'Desember'; break;
  	}
  }

  function tampilrekap() {
    $tahun = $this->input->get('thn'); 

    if ($tahun) {
      $sqlcari = $this->mpensiun->tampilrekappertahun($tahun)->result_array();
      $jmlpen = count($this->mpensiun->tampilrekappertahun($tahun)->result_array());

      echo "<div class='panel panel-default' style='padding:3px;width: 95%;height:100%;''>";
      echo "<div class='panel-heading' align='left'><b>REKAPITULASI PENSIUN TAHUN $tahun</b><br />";
      //echo "Jumlah : ".$jmlpen;
      echo "</div>";
      echo "<div style='padding:0px;overflow:auto;width:99%;height:420px;border:5px solid white' >";

      echo "<table class='table table-condensed'>";
      echo "<tr>
        <td align='center'><b>NO</b></td>
        <td align='center'><b>NIP</b></td>
        <td align='center'><b>NAMA</b></td>
        <td align='center'><b>JABATAN</b></td>
        <td align='center'><b>JENIS PENSIUN</b></td>
        <td align='center'><b>TMT</b></td> 
        <td align='center'></td>";
      echo "</tr>";    
      
      $no = 1;
      $jmlbup = 0;
      $jmlaps = 0;
      $jmljadu = 0;
      foreach($sqlcari as $v):    
      //var_dump($v);die;   
      $nip = $v['nip'];
      
      //CEK FILES
      $jml_files = multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'jml');
      $size_files = multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'size');
        
      $marge_jml_total = array_multisum($jml_files);
      $marge_size_total = byte_format(array_multisum($size_files));
      
      $showfiles = $marge_jml_total > 0 ? " <b>(Files :".$marge_jml_total." - ". $marge_size_total .")</b>" : '';
      
      	$ceksantunan = $this->korpri->cekstatus_santunan($v['nip']);
      	if(!empty($ceksantunan)) {
      		$santunan = "hidden";
      		$status_santunan = "<code>Santunan: <b>".$ceksantunan."</b></code>";
      	} else {
      		$santunan = "d-block";
      		$status_santunan = "";
      	}
      	
      	$tmt = $v['tmt_pensiun'];
      	$pecah_tmt = explode('-', $tmt);
      	$arr = $pecah_tmt;
      	//$bulan_pensiun = );
        ?>
        
        <tr>
        <td width='10' align='center'><?php echo $no.'.'; ?></td>
        <td width='150'><?php echo $v['nip']; ?> <?= $showfiles ?></td>
        <td><?php echo $v['nama']; ?></td>
        <?php $jnsjab = $this->mpensiun->getjnsjab($v['nip']); ?>
        <td><?php echo $v['nama_jabatan']."<small><code>".$jnsjab."</code></small>"."</br>".$v['nama_unit_kerja']; ?> <br> <?= $status_santunan ?></td>
        <td><?php echo $v['nama_jenis_pensiun']; ?></td>
        <td><?php echo tgl_indo($v['tmt_pensiun']); ?></td>
        <td>
	     <?php
			if($this->session->userdata('nama') == "kholik" || $this->session->userdata('nama') == "uda" || $this->session->userdata('nama') == "putra"):
				if($v['nama_jenis_pensiun'] == 'BUP'):
		  ?>
	        <form method="POST" action="../santunan_korpri/entri_santunan">
	          <input type="hidden" name="thn_bup" value="<?= $tahun ?>"> 
	          <input type="hidden" name="bulan_bup" value="<?= $this->bulan($arr['1']) ?>"> 
	          <input type="hidden" name="nip" id="nip" maxlength="18" value="<?= $nip ?>">   
	          <input type="hidden" name="jenis" id="jenis" maxlength="18" value="BUP">          
	          <button type="submit" class="btn btn-success btn-xs btn-block <?= $santunan ?>">
	          	<i class="glyphicon glyphicon-user"></i><br>Entri Santunan
	          </button>
	        </form>
			<?php else: ?> 
				<form method="POST" action="../santunan_korpri/entri_santunan">  
	          <input type="hidden" name="nip" id="nip" maxlength="18" value="<?= $nip ?>">   
	          <input type="hidden" name="jenis" id="jenis" maxlength="18" value="NONBUP">            
	          <button type="submit" class="btn btn-warning btn-xs btn-block <?= $santunan ?>">
	          	<i class="glyphicon glyphicon-user"></i><br>Entri Santunan
	          </button>
	        </form>
			<?php
			endif; endif; 
			?>
  			</td>
      </tr>
      <?php
        if ($v['nama_jenis_pensiun'] == "BUP") $jmlbup++;
        else if ($v['nama_jenis_pensiun'] == "ATAS PERMINTAAN SENDIRI") $jmlaps++;
        else if ($v['nama_jenis_pensiun'] == "MENINGGAL DUNIA") $jmljadu++;
        $no++;
      endforeach;      
      ?>
      <div class="row" style="margin:20px;">
        <div class="col-lg-3 col-md-2">
        <pre><div class='text-primary'><b>TOTAL : <?php echo $jmlpen;?> PNS</b></div></pre>
        </div>
        <div class="col-lg-3 col-md-2">
        <pre><div class='text-success'>Batas Usia Pensiun : <?php echo $jmlbup;?> PNS</div></pre>
        </div>
        <div class="col-lg-3 col-md-2">        
        <pre><div class='text-danger'>Janda Duda : <?php echo $jmljadu;?> PNS</div></pre>
        </div>
        <div class="col-lg-3 col-md-2">
        <pre><div class='text-info'>Atas Permintaan Sendiri : <?php echo $jmlaps;?> PNS</div></pre>
        </div>

      <?php
      echo "</div>"; // div scrolbar
      echo "</div>"; // div panel-info
    }
  }

  function tampilperorangan() {
    $data = $this->input->get('data');

    if ($data) {
      $sqlcari = $this->mpensiun->tampilperorangan($data)->result_array();
      $jmlpen = count($this->mpensiun->tampilperorangan($data)->result_array());

      echo "<div class='panel panel-success' style='padding:3px;width: 95%;height:100%;''>";
      echo "<div class='panel-heading' align='left'><b>TAMPIL DATA PENSIUN ... ".$data."...</b><br />";
      echo "</div>";
      echo "<div style='padding:0px;overflow:auto;width:99%;height:420px;border:5px solid white' >";

      echo "<table class='table table-condensed'>";
      echo "<tr>
        <td align='center'><b>NO</b></td>
        <td align='center'><b>NIP</b></td>
        <td align='center' width='250'><b>NAMA</b></td>
        <td align='center'><b>JABATAN</b></td>
        <td align='center' width='250'><b>JENIS PENSIUN</b></td>
        <td align='center' width='150'><b>TMT</b></td>";
      echo "</tr>";    
      
      $no = 1;
      $jmlbup = 0;
      $jmlaps = 0;
      $jmljadu = 0;
      foreach($sqlcari as $v): 
      	$ceksantunan = $this->korpri->cekstatus_santunan_rekap($v['nip']);
      	if(!empty($ceksantunan)) {
      		$santunan = "<code>Santunan: <b>".$ceksantunan."</b></code>";
      	} else {
      		$santunan = "";
      	}            
        ?>
        <tr>
        <td width='10' align='center'><?php echo $no.'.'; ?></td>
        <td width='150'><?php echo $v['nip']; ?> <?= $santunan ?></td>
        <td><?php echo $v['nama']; ?></td>
        <?php $jnsjab = $this->mpensiun->getjnsjab($v['nip']); ?>
        <td><?php echo $v['nama_jabatan']."<small><code>".$jnsjab."</code></small>"."</br>".$v['nama_unit_kerja']; ?></td>
        <td><?php echo $v['nama_jenis_pensiun']; ?></td>
        <td><?php echo tgl_indo($v['tmt_pensiun']); ?></td>
      </tr>
      <?php
        if ($v['nama_jenis_pensiun'] == "BUP") $jmlbup++;
        else if ($v['nama_jenis_pensiun'] == "ATAS PERMINTAAN SENDIRI") $jmlaps++;
        else if ($v['nama_jenis_pensiun'] == "MENINGGAL DUNIA") $jmljadu++;
        $no++;
      endforeach;      
      ?>
      <div class="row" style="margin:20px;">
        <div class="col-lg-3 col-md-2">
          <div class="alert alert-success alert-dismissable">                               
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b>TOTAL : <?php echo $jmlpen;?> Data</b>
          </div>
        </div>
        <div class="col-lg-3 col-md-2">
          <div class="alert alert-info alert-dismissable">                               
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Batas Usia Pensiun : <?php echo $jmlbup;?> Data
          </div>
        </div>
        <div class="col-lg-3 col-md-2">        
          <div class="alert alert-warning alert-dismissable">                               
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              Janda Duda : <?php echo $jmljadu;?> Data
          </div>
        </div>
        <div class="col-lg-3 col-md-2">
          <div class="alert alert-danger alert-dismissable">                               
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Atas Permintaan Sendiri : <?php echo $jmlaps;?> Data
          </div>
        </div>

      <?php
      echo "</div>"; // div scrolbar
      echo "</div>"; // div panel-info
    }
  }

  function statistik()
    {
      if ($this->session->userdata('level')=="ADMIN") { 
        $data['jenpen'] = $this->mpensiun->getjenispensiun();
        $data['jabasn'] = $this->mpensiun->getjabasn();
        $data['thncuti'] = $this->mpensiun->gettahuntmt()->result_array();      
        $thn = date('Y');
        //$thn = 2019;
        $data['thn'] = $thn;
        //$data['rwyperbulan'] = $this->mpensiun->getjmltmtperbulan($thn);
	//$data['rwyperjnsbulan'] = $this->mpensiun->getjmlperjnsbulan($thn);
        $data['content'] = 'pensiun/statistik';
        $this->load->view('template',$data);
      }
    }

    function proyeksi() {
    //if ($this->session->userdata('usulkgb_priv') == "Y") {
      $data['tahun'] = $this->mpensiun->gettahuntmt()->result_array();
      $data['content'] = 'pensiun/proyeksi';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    //}
  }

  function tampilproyeksi() {
    $tahun = $this->input->get('thn'); 

    if ($tahun) {
      $sqlcari = $this->mpensiun->proyeksi()->result_array();

      echo "<div class='row'>";         
      echo "<div class='col-lg-8' align='center'>";      
        echo "<div class='panel panel-info' style='padding:3px;width: 100%;height:100%;'>";
        echo "<div class='panel-heading' align='left'><b>PROYEKSI PNS BUP TAHUN $tahun</b><br />";
        echo "</div>";
        // Scrollbar
        echo "<div style='padding:0px;overflow:auto;width:99%;height:420px;border:5px solid white' >";
        echo "<small>
              <table class='table table-hover table-bordered'>";
        echo "<tr>
          <td align='center'><b>NO1</b></td>
          <td align='center'><b>NAMA/NIP</b></td>
          <td align='center'><b>JABATAN</b></td>
          <td align='center' width=80'><b>USIA BUP</b></td>
          <td align='center' width='100'><b>TMT</b></td>
          <td>TTL</td>
          <td>Alamat</td>
          
          <td></td>";
        echo "</tr>";    
        
        $no = 1;
        $jmljan = 0;
        $jmlfeb = 0;
        $jmlmar = 0;
        $jmlapr = 0;
        $jmlmei = 0;
        $jmljun = 0;
        $jmljul = 0;
        $jmlagu = 0;
        $jmlsep = 0;
        $jmlokt = 0;
        $jmlnov = 0;
        $jmldes = 0;

        $jmljpt = 0;
        $jmladm = 0;
        $jmlpeng = 0;
        $jmljfu = 0;
        $jmljft = 0;

        $jmlmpp = 0;

        foreach($sqlcari as $v):          
            $thn_lahir = substr($v['tgl_lahir'],0,4);
            $bln_lahir = substr($v['tgl_lahir'],5,2);
            $thn_bup = $thn_lahir + $v['usia_pensiun'];
            $nip = $v['nip'];

            if (($bln_lahir == 12) AND ($thn_bup == $tahun)) {$thn_bup++;}
            if (($bln_lahir == 12) AND ($thn_bup == $tahun-1)) {$thn_bup;}
            
       

            if (($thn_bup == $tahun) OR (($thn_bup == $tahun-1) AND ($bln_lahir == 12))) {
              ?>
                <tr>
                <td width='10' align='center'><?php echo $no.'.'; ?></td>
                <td width='150'>
                <?= $this->mpegawai->getnama($v['nip']) ?><br>NIP.<?php echo $v['nip']; ?> <br> 
                <?php
                    $status = $this->mpensiun->getstatpeg($v['nip']);
                    if ($status == "PEGAWAI MPP") {
                      echo "<br/><span class='label label-success'>STATUS : PEGAWAI MPP</span>";
                      $jmlmpp++;
                    }
                  ?>
                </td>

                <td>
                <?php
                  $jnsjab = $this->mpip->getnamajnsjab($v['nip']);
                  switch ($jnsjab) {
                    case "JPT-PRATAMA" : {$jmljpt++;break;}
                    case "ADMINISTRASI-ADMINISTRATOR" : {$jmladm++;break;}
                    case "ADMINISTRASI-PENGAWAS" : {$jmlpeng++;break;}
                    case "PELAKSANA" : {$jmljfu++;break;}
                    case "FUNGSIONAL" : {$jmljft++;break;}
                  }

                  echo $this->mpegawai->namajabnip($v['nip']).
                       "<br/><code>".$jnsjab."</code><br/>".
                       $this->munker->getnamaunker($v['fid_unit_kerja']); 
                ?></td>
                <td><?php echo $v['usia_pensiun']; ?></td>
                <td>
                <?php
                  $blntmt = $bln_lahir+1;
                  if ($blntmt == 13) {
                    $blntmt = 1;
                    $thn_bup++;
                  }

                  switch ($blntmt) {
                    case 1 : {$jmljan++;;break;}
                    case 2 : {$jmlfeb++;break;}
                    case 3 : {$jmlmar++;break;}
                    case 4 : {$jmlapr++;break;}
                    case 5 : {$jmlmei++;break;}
                    case 6 : {$jmljun++;break;}
                    case 7 : {$jmljul++;break;}
                    case 8 : {$jmlagu++;break;}
                    case 9 : {$jmlsep++;break;}
                    case 10 : {$jmlokt++;break;}
                    case 11 : {$jmlnov++;break;}
                    case 12 : {$jmldes++;break;}
                  }
                  echo bulan($blntmt)." ".$thn_bup;
                ?>
                </td>
                <td>
                <?= $v['tmp_lahir'] ?>, <?= tgl_indo($v['tgl_lahir']) ?> 
                </td>
                <td>
                <?= $v['alamat'] ?>
                </td>
                <td>
		<?php
	             if ($this->session->userdata('level') == "ADMIN") {
            	?>
                <form method="POST" action="../pensiun/detail/bup">
				          <input type="hidden" name="nip" id="nip" maxlength="18" value="<?= $nip ?>">          
				          <button type="submit" class="btn btn-success btn-xs btn-block">
				          	<i class="glyphicon glyphicon-user"></i><br>Entri Pensiun </button>
				        </form>
                <?php
		}
		?>
		</td>
              </tr>
              <?php
              $no++;
            }        
        endforeach;      
        echo "</table>
              </small>";
       
        echo "</div>"; // div scrolbar
        echo "</div>"; // div panel-info
      echo "</div>"; // div colomn 10

      echo "<div class='col-lg-2' align='left'>";
        ?>
        <ul class="list-group">
          <li class="list-group-item">Januari
          <span class="badge"><?php echo $jmljan; ?></span>
          </li>
          <li class="list-group-item">Februari
          <span class="badge"><?php echo $jmlfeb; ?></span>
          </li>
          <li class="list-group-item">Maret
          <span class="badge"><?php echo $jmlmar; ?></span>
          </li>
          <li class="list-group-item">April
          <span class="badge"><?php echo $jmlapr; ?></span>
          </li>
          <li class="list-group-item">Mei
          <span class="badge"><?php echo $jmlmei; ?></span>
          </li>
          <li class="list-group-item">Juni
          <span class="badge"><?php echo $jmljun; ?></span>
          </li>
          <li class="list-group-item">Juli
          <span class="badge"><?php echo $jmljul; ?></span>
          </li>
          <li class="list-group-item">Agustus
          <span class="badge"><?php echo $jmlagu; ?></span>
          </li>
          <li class="list-group-item">September
          <span class="badge"><?php echo $jmlsep; ?></span>
          </li>
          <li class="list-group-item">Oktober
          <span class="badge"><?php echo $jmlokt; ?></span>
          </li>
          <li class="list-group-item">November
          <span class="badge"><?php echo $jmlnov; ?></span>
          </li>
          <li class="list-group-item">Desember
          <span class="badge"><?php echo $jmldes; ?></span>
          </li>
        </ul>
        <?php
      echo "</div>"; // div colomn 2
      echo "<div class='col-lg-2' align='left'>";
      ?>
        <b>
        <ul class="list-group">
          <li class="list-group-item"><span class="text-danger">JPT</span>
          <span class="pull-right text-danger"><?php echo $jmljpt ?></span>
          </li>
          <li class="list-group-item"><span class="text-primary">ADMINISTRATOR</span>
          <span class="pull-right text-primary"><?php echo $jmladm; ?></span>
          </li>
          <li class="list-group-item"><span class="text-success">PENGAWAS</span>
          <span class="pull-right text-success"><?php echo $jmlpeng; ?></span>
          </li>
          <li class="list-group-item"><span class="text-warning">JFU</span>
          <span class="pull-right text-warning"><?php echo $jmljfu; ?></span>
          </li>
          <li class="list-group-item">JFT
          <span class="pull-right text-default"><?php echo $jmljft; ?></span>
          </li>
        </ul>
        </b>

        <b>
        <div class="alert alert-success">
          <?php echo "Status MPP : ".$jmlmpp; ?>
        </div>
        </b>
      <?php
      echo "</div>"; // div col terakhir

      echo "</div>"; // div row
    }
  }

    /* ------------------------------------------------------------------
	END REKAPITULASI DAN STATISTIK
       -----------------------------------------------------------------
    */


    
  // -------------------------- start-norsptr ---------------------------//
  public function rekap_mutasi() {
  	$data['content'] = 'pensiun/rekap_mutasi';
      	$this->load->view('template',$data);
  }
	
	public function data_rekap_mutasi()
	{
		$get_data = $this->mpensiun->fetch_datatable_rekap();
	  $data = array();
	  $no = $_POST['start'];
	  
	  foreach($get_data as $r) {

        //CEK FILES
        $nip = $r->nip;
        $jml_files = multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'jml');
        $size_files = multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'size');
        
        $marge_jml_total = array_multisum($jml_files);
        $marge_size_total = byte_format(array_multisum($size_files));
        
        $showfiles = $marge_jml_total > 0 ? " (Files :".$marge_jml_total." - ". $marge_size_total .")" : '';
        
	  	 	$sub_array = array();
		    $sub_array[] = $no+1;
		    $sub_array[] = $r->nip.$showfiles;
		    $sub_array[] = $r->nama_asn;
		    $sub_array[] = $r->nama_jabatan;
		    $sub_array[] = $r->note;
		    
		    $data[] = $sub_array;
        $all_jml_total[] = $marge_jml_total;
        $all_size_total[] = $marge_size_total;
		
		  $no++;
	  }
	  
	  $output = array(
	    'draw'  		  => intval($_POST['draw']),
	    'recordsTotal' 	  => $this->mpensiun->get_all_data_rekap(),
	    'recordsFiltered' => $this->mpensiun->get_filtered_data_rekap(),
	    'data'			  => $data,
      'total_files' => $all_jml_total,
      'total_sizes' => $all_size_total
	  );
	
	  echo json_encode($output); 
	}
	
	public function cari_pegawai() {
		$data['content'] = 'pensiun/pensiun_cari_pegawai';
      	$this->load->view('template',$data);
	}
	
	function filternipnama() {
	   $nip = $this->input->post('nip');
	   $nama = $this->input->post('nama');
	   $db = $this->mpensiun->filternipnama('pegawai', $nip, $nama);
	  if($db->num_rows() > 0) {
	    $row = $db->result();
	     $data = array();
	     foreach($row as $r) {
	      $data[] = $r->nip;
	      $data[] = $r->nama;
	      //$data[] = $r->gelar_depan.' '.$r->nama.' '.$r->gelar_belakang;
	    }
	   }
	   echo json_encode($data);
	   //var_dump($data);
	}
	
	public function tampilnipnama() {
	   $filter = trim($this->input->post('filter', true));
	   $data['content'] = 'pensiun/pensiun_nipnama';
	   $data['data'] = $this->mpensiun->pensiun_nipnama($filter)->result();
	   $data['count_data'] = count($this->mpensiun->pensiun_nipnama($filter)->result());

       $this->load->view('template',$data);
	}
	
	public function detail($jns) {
		$nip = $this->input->post('nip');
		
		if($jns == 'bup') {
			$data['content'] = 'pensiun/pensiun_detail_bup';
	  } else {
			$data['content'] = 'pensiun/pensiun_detail_nonbup';
	  }
	    $data['data'] = $this->mpensiun->pensiun_detail($nip)->result();

        $this->load->view('template',$data);
	}
	
	public function mutasi() {
		$nip = $this->input->post('nip');
		$data['content'] = 'pensiun/mutasi_detail';
	  $data['data'] = $this->mpensiun->mutasi_detail($nip)->result();

        $this->load->view('template',$data);
	}
	
	public function mutasi_aksi() {
		$nip = $this->input->post('nip');
	  $d = $this->mpensiun->mutasi_detail($nip)->result();
		$r = $d[0];
		$nama = $r->nama; 
		$gelar_d = $r->gelar_depan; 
		$gelar_b = $r->gelar_belakang; 
		$tmp_lahir = $r->tmp_lahir; 
		$tgl_lahir = $r->tgl_lahir;
		$alamat = $r->alamat; 
		$fid_kelurahan = $r->fid_alamat_kelurahan; 
		$tlp = $r->telepon; 
		$agama = $r->fid_agama; 
		$jk = $r->jenis_kelamin;
		$fid_kawin = $r->fid_status_kawin; 
		$fid_tingkat_p = $r->fid_tingkat_pendidikan; 
		$fid_jurusan_p = $r->fid_jurusan_pendidikan;
		$th = $r->tahun_lulus; 
		$fid_status_pegawai = $r->fid_status_pegawai; 
		$fid_gol_awal = $r->fid_golru_awal; 
		$tmt_gol_awal = $r->tmt_golru_awal;
		$fid_gol_skr = $r->fid_golru_skr; 
		$tmt_gol_skr = $r->tmt_golru_skr;
		$no_sk_cpns = $r->no_sk_cpns; 
		$tgl_sk_cpns = $r->tgl_sk_cpns;
		$tmt_cpns = $r->tmt_cpns;
		$no_sk_pns = $r->no_sk_pns; 
		$tgl_sk_pns = $r->tgl_sk_pns;
		$tmt_pns = $r->tmt_pns;
		$jns_pegawai = $r->fid_jenis_pegawai;
		$mk_total_tahun = $r->makertotal_tahun;
		$mk_total_bulan = $r->makertotal_bulan;
		$nm_unker = $this->input->post('nm_unker');
		$nm_instansi = $this->input->post('nm_instansi');
		$nm_jabatan = $this->input->post('nm_jabatan');
		$fid_eslon = $r->fid_eselon;
		$tmt_jabatan = $r->tmt_jabatan;
		$no_karpeg = $r->no_karpeg;
		$no_karis_karsu = $r->no_karis_karsu;
		$photo = $r->photo;
		$note = $this->input->post('keterangan_mutasi');
		$no_berkas = $r->no_berkas;
		
		$data = [
			'nip' => $nip,
			'nama' => $nama,
			'gelar_depan' => $gelar_d,
			'gelar_belakang' => $gelar_b,
			'tmp_lahir' => $tmp_lahir,
			'tgl_lahir' => $tgl_lahir,
			'alamat' => $alamat,
			'fid_alamat_kelurahan' => $fid_kelurahan,
			'telepon' => $tlp,
			'fid_agama' => $agama,
			'jenis_kelamin' => $jk,
			'fid_status_kawin' => $fid_kawin,
			'fid_tingkat_pendidikan' => $fid_tingkat_p,
			'fid_jurusan_pendidikan' => $fid_jurusan_p,
			'tahun_lulus' => $th,
			'fid_status_pegawai' => $fid_status_pegawai,
			'fid_golru_awal' => $fid_gol_awal,
			'tmt_golru_awal' => $tmt_gol_awal,
			'fid_golru_skr' => $fid_gol_skr,
			'tmt_golru_skr' => $tmt_gol_skr,
			'no_sk_cpns' => $no_sk_cpns,
			'tgl_sk_cpns' => $tgl_sk_cpns,
			'tmt_cpns' => $tmt_cpns,		
			'no_sk_pns' => $no_sk_pns,
			'tgl_sk_pns' => $tgl_sk_pns,
			'tmt_pns' => $tmt_pns,
			'fid_jenis_pegawai' => $jns_pegawai,
			'makertotal_tahun' => $mk_total_tahun,
			'makertotal_bulan' => $mk_total_bulan,
			'nama_unit_kerja' => $nm_unker,
			'nama_instansi' => $nm_instansi,
			'nama_jabatan' => $nm_jabatan,
			'fid_eselon' => $fid_eslon,
			'tmt_jabatan' => $tmt_jabatan,
			'no_karpeg' => $no_karpeg,
			'no_karis_karsu' => $no_karis_karsu,
			'photo' => $photo,
			'note' => $note,
			'no_berkas' => $no_berkas,
				
		];
		
		$whr = [
			'nip' => $nip
		];
		
		//var_dump($data);
		$db = $this->mpensiun->insert_mutasi('pegawai_pensiun', $data);
		if($db) {
      // Hapus semua file ybs
      multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'del');
			$msg = array('valid' => true, 'mode' => 'success', 'pesan' => '<center><h3>Berhasil <i class="glyphicon glyphicon-check"></i></h3> <br>Pegawai <b>'.$nama.' <b> ( '.$nip.' ) Telah Dimutasikan Keluar</center>');
			$this->session->set_flashdata($msg);
			$this->mpensiun->delete_pegawai_mutasi('pegawai', $whr);
		} else {
			$msg = array('valid' => false, 'mode' => 'danger', 'pesan' => 'Pegawai '.$nama.' Gagal Dimutasi, coba periksa data yang bersangkutan');
			$this->session->set_flashdata($msg);
		}
		
		redirect(base_url('pensiun/status'));
	}
	
	public function pensiun_aksi($type) {
		$nip = $this->input->post('nip');
	  $d = $this->mpensiun->pensiun_detail($nip)->result();
		$r = $d[0];
		$nama = $r->nama; 
		$gelar_d = $r->gelar_depan; 
		$gelar_b = $r->gelar_belakang; 
		$tmp_lahir = $r->tmp_lahir; 
		$tgl_lahir = $r->tgl_lahir;
		$alamat = $r->alamat; 
		$fid_kelurahan = $r->fid_alamat_kelurahan; 
		$tlp = $r->telepon; 
		$agama = $r->fid_agama; 
		$jk = $r->jenis_kelamin;
		$fid_kawin = $r->fid_status_kawin; 
		$fid_tingkat_p = $r->fid_tingkat_pendidikan; 
		$fid_jurusan_p = $r->fid_jurusan_pendidikan;
		$th = $r->tahun_lulus; 
		$fid_status_pegawai = $r->fid_status_pegawai; 
		$fid_gol_awal = $r->fid_golru_awal; 
		$tmt_gol_awal = $r->tmt_golru_awal;
		$fid_gol_skr = $r->fid_golru_skr; 
		$tmt_gol_skr = $r->tmt_golru_skr;
		$no_sk_cpns = $r->no_sk_cpns; 
		$tgl_sk_cpns = $r->tgl_sk_cpns;
		$tmt_cpns = $r->tmt_cpns;
		$no_sk_pns = $r->no_sk_pns; 
		$tgl_sk_pns = $r->tgl_sk_pns;
		$tmt_pns = $r->tmt_pns;
		$jns_pegawai = $r->fid_jenis_pegawai;
		$mk_total_tahun = $r->makertotal_tahun;
		$mk_total_bulan = $r->makertotal_bulan;
		$nm_unker = $this->input->post('nm_unker');
		$nm_instansi = $this->input->post('nm_instansi');
		$nm_jabatan = $this->input->post('nm_jabatan');
		$fid_eslon = $r->fid_eselon;
		$tmt_jabatan = $r->tmt_jabatan;
		$no_karpeg = $r->no_karpeg;
		$no_karis_karsu = $r->no_karis_karsu;
		$photo = $r->photo;
		$note = $this->input->post('note');
		$no_berkas = $r->no_berkas;
		
		// Insert ke table `pegawai pensiun`
		$data_pensiun_pegawai = [
			'nip' => $nip,
			'nama' => $nama,
			'gelar_depan' => $gelar_d,
			'gelar_belakang' => $gelar_b,
			'tmp_lahir' => $tmp_lahir,
			'tgl_lahir' => $tgl_lahir,
			'alamat' => $alamat,
			'fid_alamat_kelurahan' => $fid_kelurahan,
			'telepon' => $tlp,
			'fid_agama' => $agama,
			'jenis_kelamin' => $jk,
			'fid_status_kawin' => $fid_kawin,
			'fid_tingkat_pendidikan' => $fid_tingkat_p,
			'fid_jurusan_pendidikan' => $fid_jurusan_p,
			'tahun_lulus' => $th,
			'fid_status_pegawai' => $fid_status_pegawai,
			'fid_golru_awal' => $fid_gol_awal,
			'tmt_golru_awal' => $tmt_gol_awal,
			'fid_golru_skr' => $fid_gol_skr,
			'tmt_golru_skr' => $tmt_gol_skr,
			'no_sk_cpns' => $no_sk_cpns,
			'tgl_sk_cpns' => $tgl_sk_cpns,
			'tmt_cpns' => $tmt_cpns,		
			'no_sk_pns' => $no_sk_pns,
			'tgl_sk_pns' => $tgl_sk_pns,
			'tmt_pns' => $tmt_pns,
			'fid_jenis_pegawai' => $jns_pegawai,
			'makertotal_tahun' => $mk_total_tahun,
			'makertotal_bulan' => $mk_total_bulan,
			'nama_unit_kerja' => $nm_unker,
			'nama_instansi' => $nm_instansi,
			'nama_jabatan' => $nm_jabatan,
			'fid_eselon' => $fid_eslon,
			'tmt_jabatan' => $tmt_jabatan,
			'no_karpeg' => $no_karpeg,
			'no_karis_karsu' => $no_karis_karsu,
			'photo' => $photo,
			'note' => $note,
			'no_berkas' => $no_berkas,
				
		];
		
		
		//insert ke table `pensiun_detail`
		$jns_pens = $this->input->post('jns_pens');
		$id_jns_pens = $this->input->post('id_jns_pens');
		$nosk = $this->input->post('no_sk');
		$tglsk = tgl_sql($this->input->post('tgl_sk'));
		$tmt_pensiun = tgl_sql($this->input->post('tmt_pens'));
		$nama_penerima = $this->input->post('nm_pnrima');
		
		$tgl_mngl = tgl_sql($this->input->post('tgl_meninggal'));
		$tgl_lahir_penerima = tgl_sql($this->input->post('tl_pnrima'));
		
		$hub_kel = $this->input->post('hub_kel');
		$alamat_pensiun = $this->input->post('alamat_pens');
		$note = $this->input->post('note');

		if($type == 'bup')
		{
			$data_pensiun = [
				'nip' => $nip,
				'fid_jenis_pensiun' => $jns_pens,
				'no_sk' => $nosk,
				'tgl_sk' => $tglsk,
				'tmt_pensiun' => $tmt_pensiun,
				'nama_penerima' => $nama_penerima,
				'tgl_lahir_penerima' => $tgl_lahir_penerima,
				'hub_kel' => $hub_kel,
				'alamat_pensiun' => $alamat_pensiun,
				'note' => $note
			];
		} else {
			$data_pensiun = [
				'nip' => $nip,
				'fid_jenis_pensiun' => $id_jns_pens,
				'no_sk' => $nosk,
				'tgl_sk' => $tglsk,
				'tgl_mngl' => $tgl_mngl,
				'tmt_pensiun' => $tmt_pensiun,
				'nama_penerima' => $nama_penerima,
				'tgl_lahir_penerima' => $tgl_lahir_penerima,
				'hub_kel' => $hub_kel,
				'alamat_pensiun' => $alamat_pensiun,
				'note' => $note
			];
		}
		
		$whr = [
			'nip' => $nip
		];
		
		$insert_tbl_pensiun_detail = $this->mpensiun->insert_pensiun_detail('pensiun_detail', $data_pensiun);

		if($insert_tbl_pensiun_detail) {
			$msg = array('valid' => true, 'mode' => 'success', 'pesan' => '<center><h3>Berhasil <i class="glyphicon glyphicon-check"></i></h3> <br>Pegawai <b>'.$nama.' <b> ( '.$nip.' ) Telah Dipensiunkan</center>');
			$this->session->set_flashdata($msg);
      //Hapus semua file ybs
      multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'del');
			
			// Masukan data ke pegawai_pensiun
			$this->mpensiun->insert_pegawai_pensiun('pegawai_pensiun', $data_pensiun_pegawai);
			
			$this->mpensiun->delete_pegawai_mutasi('pegawai', $whr);
		} else {
			$msg = array('valid' => false, 'mode' => 'danger', 'pesan' => 'Pegawai '.$nama.' Pensiunan Gagal Diproses, coba periksa data yang bersangkutan');
			$this->session->set_flashdata($msg);
		}
		
		redirect(base_url('pensiun/status'));
	}
	
	public function status() {
	   $data['content'] = 'pensiun/pensiun_mutasi_status';
		 $this->load->view('template',$data);
	}
	// -------------------------- end-norsptr ---------------------------//
	
	
	
}
