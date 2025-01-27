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
			// $cek_penilaian = $this->mpetruk->detail_penilaian_by_unker($nip, $idunker, 2024);
			// if($cek_penilaian->num_rows() > 0) {
			// 	$cek = $cek_penilaian->row();
			// 	$row = '
			// 		<div class="container">
			// 			<div class="row">			
			// 				<div class="col-md-6 col-md-offset-3">
			// 					<div class="alert alert-warning" role="alert">
			// 					<h4>Penilaian Telah Tercatat pada BKPPD</h4>
			// 					<a href="'.base_url('petruk/review_penilaian/'.$cek->nip).'" class="btn btn-block btn-info"><i class="glyphicon glyphicon-check"></i> Review Hasil Penilaian</a>
			// 					</div>
			// 				</div>
			// 			</div>
			// 		</div>
			// 	';
			// } else {
				$row = '<div class="container">
								<div class="row">			
								<div class="col-md-6 col-md-offset-3" style="max-height:400px; overflow-y:scroll; overflow-x:hidden; background:#fff; padding:5px;">

								<table class="table table-bordered table-hover table-condensed">';
			foreach($peg as $p):

			// cek apakah sudah dinilai atau belum
			$disabled = $this->mpetruk->detail_penilaian_by_unker($p->nip, $idunker, date('Y'));
			if($disabled->num_rows() > 0) {
				$btnAksi = '<a href="'.base_url('petruk/review_penilaian/'.$p->nip).'" class="btn btn-lg btn-info"><i class="glyphicon glyphicon-check"></i> <br> Hasil Penilaian</a>';
			} else {
				$btnAksi = '<a href="'.base_url("petruk/appraisement?nip=".$p->nip."&tahun=".date('Y')).'" class="btn btn-lg btn-warning"><i class="glyphicon glyphicon-star"></i> <br> Lakukan penilaian </a>';
			}


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
										'.$btnAksi.'
									</td>
					
								 </tr>';
			endforeach;
			$row .= '</table></div></div></div>';
			// }
			
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
		$tahun = $_GET['tahun'];
		if (!empty($nip)) { 
			$cek_penilaian = $this->mpetruk->detail_penilaian_by_nip($nip, $tahun);
			if($cek_penilaian->num_rows() > 0) {
				redirect(base_url('petruk/penilaian'));
			} else {
				// data pegawai
				$data['peg'] = $this->mpegawai->detail($nip)->row(); 
				// ambil nilai ekinerja berdasarkan nip, bulan, tahun
				$data['kinerja'] = $this->mpetruk->kinerja_bulanan($nip, 3, 2024);   
				// ambil absensi bulanan
				//   $data['absen'] = $this->mpetruk->absensi_bulanan($nip, 3, 2021);  
				// ambil absen bulanan
				@$april = $this->mpetruk->absensi_bulanan($nip, 4, 2024)->realisasi;
				@$mei = $this->mpetruk->absensi_bulanan($nip, 5, 2024)->realisasi;
				@$juni = $this->mpetruk->absensi_bulanan($nip, 6, 2024)->realisasi;
				
				//   Indokator Disiplin
				$sum_absen = number_format(($april + $mei + $juni), 2);
				$persentase_absen = ($sum_absen/3);
				$persentase_format = $persentase_absen;
				$persentase_akhir = $persentase_format;
				$data['absen'] = number_format($persentase_akhir,2, ",",".");
				$data['absen_info'] = "April : ".$april." - Mei :".$mei." - Juni :".$juni;

				// nilai perilaku tahunan
				$data['perilaku'] = $this->mpetruk->perilaku_tahunan($nip, 2020);
					
				$data['content'] = 'petruk/penilaian2024';
				$this->load->view('template',$data);
				}
    	}
	}
	
	public function simpan_penilaian()
	{
		$nip = base64_decode($this->input->post('nip'));
		$unit_kerja = $this->input->post('unit_kerja');
		
		$predikat_kinerja = $this->input->post('kinerja');
		$persentase_absen = $this->input->post('absensi');
		$nama_inovasi = $this->input->post('nama_inovasi');
		$predikat_timwork = $this->input->post('timwork');
		
		
		$this->form_validation->set_rules('nama_inovasi', 'Inovasi', 'required');
		$this->form_validation->set_rules('kinerja', 'Predikat Kinerja', 'required');
		$this->form_validation->set_rules('timwork', 'Predikat Team Work', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->session->set_flashdata('msg', validation_errors());
			redirect(base_url('petruk/appraisement?nip='.$nip."&tahun=".date('Y')));
		}
    	else
		{
			$tbl = 'petruk';
			$data = [
				'nip' => $nip,
				'fid_unit_kerja' => base64_decode($unit_kerja),
				'bulan' => date('m'),
				'tahun' => date('Y'),
				'predikat_kinerja' => $predikat_kinerja,
				'persentase_disiplin' => base64_decode($persentase_absen),
				'inovasi' => $nama_inovasi,
				'predikat_timwork' => $predikat_timwork,
				'created_by' => $this->session->userdata('nip')
			];
			$db = $this->mpetruk->insert_penilaian($tbl, $data);
			if($db)
			{
				$this->session->set_flashdata('msg', 'Penilaian <b>'.$nip.'</b> Telah Berhasil Dikirim');
				redirect(base_url('petruk/review_penilaian/'.$nip));
			} else {
				$this->session->set_flashdata('msg', 'Penilaian <b>'.$nip.'</b> Gagal Dikirim Ke BKPPD');
				redirect(base_url('petruk/appraisement?nip='.$nip."&tahun=".date('Y')));
			}
		}
	}

	private function SkorPredikatKinerja($predikat) {
		if($predikat == 'SANGAT BAIK') {
			$skor = 100;
		} elseif($predikat == 'BAIK') {
			$skor = 90;
		} elseif($predikat == 'BUTUH PERBAIKAN') {
			$skor = 70;
		} elseif($predikat == 'KURANG') {
			$skor = 50;
		} elseif($predikat == 'SANGAT KURANG') {
			$skor = 30;
		} else {
			$skor = 0;
		}

		return $skor;
	}

	private function SkorPredikatSertifikat($predikat) {
		if($predikat == 'TINGKAT NASIONAL') {
			$skor = 100;
		} elseif($predikat == 'TINGKAT PROVINSI') {
			$skor = 90;
		} elseif($predikat == 'TINGKAT KABUPATEN') {
			$skor = 80;
		}  else {
			$skor = 0;
		}

		return $skor;
	}

	public function simpan_penilaian_2024()
	{
		$nip = base64_decode($this->input->post('nip'));
		$unit_kerja = $this->input->post('unit_kerja');
		
		$surat_usulan = $this->input->post('surat_usulan');
		$daftar_riwayat_hidup = $this->input->post('daftar_riwayat_hidup');
		$sk_pangkat_terakhir = $this->input->post('sk_pangkat_terakhir');
		$sk_jabatan_terakhir = $this->input->post('sk_jabatan_terakhir');
		$penilaian_kinerja = $this->input->post('penilaian_kinerja');
		$is_sertifikat = $this->input->post('is_sertifikat');
		$super_hukdis = $this->input->post('super_hukdis');
		$proposal_inovasi = $this->input->post('proposal_inovasi');
		$skor_disiplin = $this->input->post('absensi');

		$this->form_validation->set_rules('surat_usulan', 'Surat Usulan Wajib Dipilih.', 'required');
		$this->form_validation->set_rules('daftar_riwayat_hidup', 'Daftar Riwayat Hidup Wajib Dipilih', 'required');
		$this->form_validation->set_rules('sk_pangkat_terakhir', 'SK Pangkat Terakhir Wajib Dipilih', 'required');
		$this->form_validation->set_rules('penilaian_kinerja', 'Penilaian Kinerja Wajib Dipilih', 'required');
		$this->form_validation->set_rules('super_hukdis', 'Super HUKDIS Wajib Dipilih', 'required');
		$this->form_validation->set_rules('proposal_inovasi', 'Proposal Inovasi Wajib Dipilih', 'required');
		$this->form_validation->set_rules('absensi', 'Daftar Kehadiran Diisi.', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->session->set_flashdata('msg', validation_errors());
			redirect(base_url('petruk/appraisement?nip='.$nip."&tahun=".date('Y')));
		}
    	else
		{
			$tbl = 'petruk';
			$data = [
				'nip' => $nip,
				'fid_unit_kerja' => base64_decode($unit_kerja),
				'bulan' => date('m'),
				'tahun' => date('Y'),
				'surat_usulan' => $surat_usulan,
				'daftar_riwayat_hidup' => $daftar_riwayat_hidup,
				'sk_pangkat_terakhir' => $sk_pangkat_terakhir,
				'sk_jabatan_terakhir' => $sk_jabatan_terakhir,
				'penilaian_kinerja' => $penilaian_kinerja,
				'is_sertifikat' => $is_sertifikat,
				'super_hukdis' => $super_hukdis,
				'proposal_inovasi' => $proposal_inovasi,
				'persentase_disiplin' => base64_decode($skor_disiplin),
				'created_by' => $this->session->userdata('nip')
			];
			$db = $this->mpetruk->insert_penilaian($tbl, $data);
			if($db)
			{
				$this->session->set_flashdata('msg', 'Penilaian <b>'.$nip.'</b> Telah Berhasil Dikirim');
				redirect(base_url('petruk/review_penilaian/'.$nip));
			} else {
				$this->session->set_flashdata('msg', 'Penilaian <b>'.$nip.'</b> Gagal Dikirim Ke BKPPD');
				redirect(base_url('petruk/appraisement?nip='.$nip."&tahun=".date('Y')));
			}
		}
	}
	
	public function review_penilaian($nip)
	{
		if ($this->session->userdata('profil_priv') == "Y") { 
			$data['profile'] = $this->mpetruk->profile_pegawai($nip)->row();
      $data['detail'] = $this->mpetruk->detail_penilaian_by_nip($nip, date('Y'))->row();      
      $data['content'] = 'petruk/review_penilaian';
      $this->load->view('template',$data);
	  
    }
	}
	
	public function piagam_penghargaan($unkerid, $nip)
	{
		$data['profile'] = $this->mpetruk->profile_pegawai($nip)->row();
    $data['detail'] = $this->mpetruk->detail_penilaian_by_nip($nip, date('Y'))->row();
    $data['spesimen'] = $this->mpetruk->spesimen($unkerid)->row();   
    $content = 'petruk/cetak_piagamv2';
    $this->load->view($content,$data);
	}
	
	public function cetak_hasil_penilaian($unkerid, $nip)
	{
		$data['profile'] = $this->mpetruk->profile_pegawai($nip)->row();
    $data['detail'] = $this->mpetruk->detail_penilaian_by_nip($nip, date('Y'))->row();
    $data['spesimen'] = $this->mpetruk->spesimen($unkerid)->row();   
    $content = 'petruk/cetak_hasil_penilaianv2';
    $this->load->view($content,$data);
	}
	
	public function rekapitulasi()
	{
		if ($this->session->userdata('profil_priv') == "Y") { 
	  $data['f_tahun'] = $this->mpetruk->f_tahun();     
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

			$nilai_tambahan = [
				'skor_orisinalitas' => $r->skor_orisinalitas,
				'skor_efesiansi' => $r->skor_efesiansi,
				'skor_keberlanjutan' => $r->skor_keberlanjutan,
				'skor_manfaat' => $r->skor_manfaat,
				'skor_dampak_organisasi' => $r->skor_dampak_organisasi,
				'skor_keterlibatan' => $r->skor_keterlibatan,
				'skor_disiplin' => $r->skor_disiplin,
				'skor_kopeten' => $r->skor_kopeten,
				'skor_pengalaman_jabatan' => $r->skor_pengalaman_jabatan,
				'skor_pengembangan_kopetensi' => $r->skor_pengembangan_kopetensi,
				'skor_penghargaan_diterima' => $r->skor_penghargaan_diterima,
				'skor_moralitas' => $r->skor_moralitas,
				'skor_tingkat_pendidikan' => $r->skor_tingkat_pendidikan,
				'skor_integritas' => $r->skor_integritas,
			];
	  		
	  		$btn_piagam = '<a href="'.base_url('petruk/piagam_penghargaan/'.$r->fid_unit_kerja.'/'.$r->nip).'" class="btn btn-sm btn-warning '.$ceknomor.'"><i class="glyphicon glyphicon-print"></i> Piagam</a>';
	  		$btn_nomor  = '<a href="'.base_url('petruk/nomor_piagam/').'" set_tgl="'.$r->tgl_piagam.'" set_nomor="'.$r->nomor_piagam.'" id_petruk="'.$r->id_petruk.'" id="nomor_piagam" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-leaf"></i> Proses</a>';
	  	 	if($this->input->post('tahun') === "2024") {
				$btn_tambahan_nilai = '<a href="'.base_url('petruk/simpan_tambahan_nilai/').'" id_petruk="'.$r->id_petruk.'" data-nilai='.json_encode(["data" =>$nilai_tambahan]).' id="TAMBAH_NILAI" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Penilaian Mandiri</a>';
			} else {
				$btn_tambahan_nilai = '';
			}

			// Nilai total
			$total = $r->skor_total;

			// Jumlah bidang
			$jumlah_bidang = 3;

			// Nilai per bidang
			$nilai_per_bidang = $total / $jumlah_bidang;
			
			$sub_array = array();
		    $sub_array[] = $no+1;
		    
		    $sub_array[] = $r->nip;
		    $sub_array[] = namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang);
		    $sub_array[] = $r->nama_unit_kerja;
		    $sub_array[] = '('.$r->surat_usulan.')';
		    $sub_array[] = '('.$r->daftar_riwayat_hidup.')';
		    $sub_array[] = '('.$r->sk_pangkat_terakhir.')';
		    $sub_array[] = '('.$r->sk_jabatan_terakhir.')';
		    $sub_array[] = '('.$r->penilaian_kinerja.')';
		    $sub_array[] = '('.$r->is_sertifikat.')';
		    $sub_array[] = '('.$r->super_hukdis.')';
		    $sub_array[] = '('.$r->proposal_inovasi.')';
		    $sub_array[] = '('.$r->persentase_disiplin.')';
		    $sub_array[] = "<b>".($r->skor_total ? number_format($nilai_per_bidang, 2) : 0)."</b>";
		    $sub_array[] = $btn_piagam.' '.$btn_nomor.' '.$btn_tambahan_nilai;
		    
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
	
	public function simpan_tambahan_nilai()
	{
		$tbl = 'petruk';
		$p = $this->input->post();
		$whr = ['id_petruk' => $p['id']];

		$total_skor = ($p['skor_orisinalitas'] + $p['skor_efesiansi'] + $p['skor_keberlanjutan'] + 
		$p['skor_manfaat'] + $p['skor_dampak_organisasi'] + $p['skor_keterlibatan'] + $p['skor_disiplin'] + $p['skor_pengalaman_jabatan']  + 
		$p['skor_pengembangan_kopetensi'] + $p['skor_penghargaan_diterima'] + $p['skor_moralitas'] + $p['skor_tingkat_pendidikan'] + $p['skor_integritas']);
		$data = [
			'skor_orisinalitas' => $p['skor_orisinalitas'], 
			'skor_efesiansi' => $p['skor_efesiansi'],
			'skor_keberlanjutan' => $p['skor_keberlanjutan'],
			'skor_manfaat' => $p['skor_manfaat'],
			'skor_dampak_organisasi' => $p['skor_dampak_organisasi'],
			'skor_keterlibatan' => $p['skor_keterlibatan'],
			'skor_disiplin' => $p['skor_disiplin'],
			'skor_pengalaman_jabatan' => $p['skor_pengalaman_jabatan'],
			'skor_pengembangan_kopetensi' => $p['skor_pengembangan_kopetensi'],
			'skor_penghargaan_diterima' => $p['skor_penghargaan_diterima'],
			'skor_moralitas' => $p['skor_moralitas'],
			'skor_tingkat_pendidikan' => $p['skor_tingkat_pendidikan'],
			'skor_integritas' => $p['skor_integritas'],
			'skor_total' => $total_skor
		];
		
		if($this->mpetruk->simpan_nomor($tbl, $data, $whr)):
			$msg = 'Tambahan Nilai Berhasil Diperbaharui';
		else:
			$msg = 'Tambahan Nilai Gagal Diperbaharui';
		endif;
		echo json_encode($msg);
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
		$this->load->view('petruk/cetak_rekapitulasi2024', $result);
	}
}