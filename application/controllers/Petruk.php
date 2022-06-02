<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Petruk extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('mpetruk');
      $this->load->model('mnonpns');
      $this->load->model('munker');
      
			$this->load->library('form_validation');
			$this->load->library('fpdf');

      // untuk login session, jika session nama tidak ada, kembali ke form login
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // untuk fpdf
      $this->load->library('fpdf');
    }  

	public function index()
	{	  

	}
	public function penilaian()
	{
		if ($this->session->userdata('profil_priv') == "Y") { 
      $data['unker'] = $this->munker->dd_unker()->result_array();      
      $data['content'] = 'petruk/pegawai';
      $this->load->view('template',$data);
    }
	}
	public function tampilperunker()
	{
		$idunker = $this->input->get('idunker');
		if ($idunker) {
			$peg = $this->mpetruk->nomperunker($idunker)->result();
			$cek_penilaian = $this->mpetruk->detail_penilaian_by_unker($idunker);
			if($cek_penilaian->num_rows() > 0) {
				$cek = $cek_penilaian->row();
				$row = '
					<div class="container">
						<div class="row">			
							<div class="col-md-6 col-md-offset-3">
								<div class="alert alert-warning" role="alert">
								<h4>Penilaian Telah Tercatat pada BKPPD</h4>
								<a href="'.base_url('petruk/review_penilaian/'.$cek->nip).'" class="btn btn-block btn-info"><i class="glyphicon glyphicon-check"></i> Review Hasil Penilaian</a>
								</div>
							</div>
						</div>
					</div>
				';
			} else {
				$row = '<div class="container">
								<div class="row">			
								<div class="col-md-6 col-md-offset-3" style="max-height:400px; overflow-y:scroll; overflow-x:hidden; background:#fff; padding:5px;">

								<table class="table table-bordered table-hover table-condensed">';
			foreach($peg as $p):
			$lokasifile = './photo/';
      $filename = $p->nip.".jpg";
      
      if (file_exists ($lokasifile.$filename)) {
        $photo = "../photo/$filename";
      } else {
        $photo = "../photo/nophoto.jpg";
      }
			
					$row .= '<tr>
									<td>
										<img src="'.$photo.'" width="80" height="90" class="img-thumbnail">
									</td>
									<td>
										<u><b>'.namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang).'</b></u> 
										<br>
										NIP. '.polanip($p->nip).'
										<br>
										'.$this->mpegawai->namajabnip($p->nip).'
									</td>
									<td width="200">
										<a href="'.base_url("petruk/appraisement?nip=".$p->nip).'" class="btn btn-lg btn-warning"><i class="glyphicon glyphicon-star"></i> <br> Lakukan penilaian </a>
									</td>
					
								 </tr>';
			endforeach;
			$row .= '</table></div></div></div>';
			}
			
			echo $row;
			
		} else {
      echo "<div class='alert alert-info' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";        
        echo "Silahkan pilih unit kerja.";
        echo "</div>";
    } 
	}	
	
	public function appraisement()
	{
		$nip = $_GET['nip'];
		if (!empty($nip)) { 
			$cek_penilaian = $this->mpetruk->detail_penilaian_by_nip($nip);
			if($cek_penilaian->num_rows() > 0) {
				redirect(base_url('petruk/penilaian'));
			} else {
			
				// data pegawai
	      $data['peg'] = $this->mpegawai->detail($nip)->row(); 
	      // ambil nilai ekinerja berdasarkan nip, bulan, tahun
	      $data['kinerja'] = $this->mpetruk->kinerja_bulanan($nip, 3, 2021);   
	      // ambil absensi bulanan
	      $data['absen'] = $this->mpetruk->absensi_bulanan($nip, 3, 2021);  
	      // nilai perilaku tahunan
	      $data['perilaku'] = $this->mpetruk->perilaku_tahunan($nip, 2020);
	        
	      $data['content'] = 'petruk/penilaian';
	      $this->load->view('template',$data);
    	}
    }
	}
	
	public function simpan_penilaian()
	{
		$nip = base64_decode($this->input->post('nip'));
		$unit_kerja = $this->input->post('unit_kerja');
		
		$skor_kinerja = $this->input->post('skor_kinerja');
		$skor_kehadiran = $this->input->post('skor_absensi');
		$skor_inovasi = $this->input->post('skor_inovasi');
		$nama_inovasi = $this->input->post('nama_inovasi');
		$skor_perilaku = $this->input->post('skor_perilaku');
		$skor_teamwork = $this->input->post('skor_teamwork');
		
		
  	$this->form_validation->set_rules('nama_inovasi', 'Inovasi', 'required');
  	$this->form_validation->set_rules('skor_inovasi', 'Skor Inovasi', 'required');
  	$this->form_validation->set_rules('skor_teamwork', 'Skor Team Work', 'required');
		
		if ($this->form_validation->run() == FALSE)
    {

  		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
  		$this->session->set_flashdata('msg', validation_errors());
  		redirect(base_url('petruk/appraisement?nip='.$nip));
    }
    else
    {
    	$tbl = 'petruk';
    	$data = [
    		'nip' => $nip,
    		'fid_unit_kerja' => base64_decode($unit_kerja),
    		'bulan' => date('m'),
    		'tahun' => date('Y'),
    		'skor_kinerja' => base64_decode($skor_kinerja),
    		'skor_disiplin' => base64_decode($skor_kehadiran),
    		'inovasi' => $nama_inovasi,
    		'skor_inovasi' => base64_decode($skor_inovasi),
    		'skor_prilaku' => base64_decode($skor_perilaku),
    		'skor_timwork' => base64_decode($skor_teamwork),
   			'created_by' => $this->session->userdata('nip')
    	];
    	$db = $this->mpetruk->insert_penilaian($tbl, $data);
    	if($db)
    	{
    		$this->session->set_flashdata('msg', 'Penilaian <b>'.$nip.'</b> Telah Berhasil Dikirim');
    	redirect(base_url('petruk/review_penilaian/'.$nip));
    	} else {
    		$this->session->set_flashdata('msg', 'Penilaian <b>'.$nip.'</b> Gagal Dikirim Ke BKPPD');
    		redirect(base_url('petruk/appraisement?nip='.$nip));
    	}
    }
	}
	
	public function review_penilaian($nip)
	{
		if ($this->session->userdata('profil_priv') == "Y") { 
			$data['profile'] = $this->mpetruk->profile_pegawai($nip)->row();
      $data['detail'] = $this->mpetruk->detail_penilaian_by_nip($nip)->row();      
      $data['content'] = 'petruk/review_penilaian';
      $this->load->view('template',$data);
    }
	}
	
	public function piagam_penghargaan($unkerid, $nip)
	{
		$data['profile'] = $this->mpetruk->profile_pegawai($nip)->row();
    $data['detail'] = $this->mpetruk->detail_penilaian_by_nip($nip)->row();
    $data['spesimen'] = $this->mpetruk->spesimen($unkerid)->row();   
    $content = 'petruk/cetak_piagam';
    $this->load->view($content,$data);
	}
	
	public function cetak_hasil_penilaian($unkerid, $nip)
	{
		$data['profile'] = $this->mpetruk->profile_pegawai($nip)->row();
    $data['detail'] = $this->mpetruk->detail_penilaian_by_nip($nip)->row();
    $data['spesimen'] = $this->mpetruk->spesimen($unkerid)->row();   
    $content = 'petruk/cetak_hasil_penilaian';
    $this->load->view($content,$data);
	}
	
	public function rekapitulasi()
	{
		if ($this->session->userdata('profil_priv') == "Y") {      
      $data['content'] = 'petruk/rekapitulasi';
      $this->load->view('template',$data);
    }
	}
	
	public function list_hasil_penilaian()
	{
		$filter = [
			'bulan' => $this->input->post('bulan'),
			'tahun' => $this->input->post('tahun'),
			'skor'	=> $this->input->post('skor')
 		];
		$get_data = $this->mpetruk->fetch_datatable_rekap($filter);
	  $data = array();
	  $no = $_POST['start'];
	  
	  foreach($get_data as $r) {
	  		$ceknomor = ($r->nomor_piagam != null) ? '' : 'hidden';
	  		
	  		$btn_piagam = '<a href="'.base_url('petruk/piagam_penghargaan/'.$r->fid_unit_kerja.'/'.$r->nip).'" class="btn btn-sm btn-warning '.$ceknomor.'"><i class="glyphicon glyphicon-print"></i> Piagam</a>';
	  		$btn_nomor  = '<a href="'.base_url('petruk/nomor_piagam/').'" set_tgl="'.$r->tgl_piagam.'" set_nomor="'.$r->nomor_piagam.'" id_petruk="'.$r->id_petruk.'" id="nomor_piagam" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-leaf"></i> Proses</a>';
	  	 	$sub_array = array();
		    $sub_array[] = $no+1;
		    
		    $sub_array[] = $r->nip;
		    $sub_array[] = namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang);
		    $sub_array[] = $r->nama_unit_kerja;
		    $sub_array[] = $r->skor_kinerja;
		    $sub_array[] = $r->skor_disiplin;
		    $sub_array[] = $r->inovasi;
		    $sub_array[] = $r->skor_inovasi;
		    $sub_array[] = $r->skor_prilaku;
		    $sub_array[] = $r->skor_timwork;
		    $sub_array[] = "<b>".($r->skor_total ? $r->skor_total : 0)."</b>";
		    $sub_array[] = $btn_piagam.' '.$btn_nomor;
		    
		    $data[] = $sub_array;
		
		  $no++;
	  }
	  
	  $output = array(
	    'draw'  		  => intval($_POST['draw']),
	    'recordsTotal' 	  => $this->mpetruk->get_all_data_rekap($filter),
	    'recordsFiltered' => $this->mpetruk->get_filtered_data_rekap($filter),
	    'data'			  => $data			
	  );
	
	  echo json_encode($output); 
	}
	
	public function simpan_nomor_piagam()
	{
		$tbl = 'petruk';
		$p = $this->input->post();
		$whr = ['id_petruk' => $p['id']];
		$data = ['nomor_piagam' => $p['nomor_piagam'], 'tgl_piagam' => $p['tgl_piagam']];
		
		if($this->mpetruk->simpan_nomor($tbl, $data, $whr)):
			$msg = 'Nomor berhasil dirobah';
		else:
			$msg = 'Nomor gagal dirobah';
		endif;
		echo json_encode($msg);
	}
	
	public function cetak_rekapitulasi($bulan,$tahun,$skor) {
	  $data = $this->mpetruk->cetakrekapitulasi($bulan,$tahun,$skor)->result();
	  $result['parse'] = array('data' => $data, 'bulan' => $bulan, 'tahun' => $tahun, 'skor' => $skor);
		$this->load->view('petruk/cetak_rekapitulasi', $result);
	}
}