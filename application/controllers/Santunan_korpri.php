<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Santunan_korpri extends CI_Controller {

    public function __construct() {
		
        parent::__construct();
        // Load Helper 
        $this->load->helper(array('url','form','fungsitanggal','fungsipegawai','fungsiterbilang'));
        // Load Model
        $this->load->model(array('mpegawai','munker','msantunan_korpri' => 'korpri'));
  			$this->load->library('fpdf');
				// Cek Session
		    if (!$this->session->userdata('nama'))
		    {
		      redirect('login');
		    }
    }
    
    // --------------- Bismillah Started -----------------//
    public function index(){
    	return "Hai, ".$this->session->userdata('nama');
    }

	// ---------------- Statistik -------------------//
    public function statistik() {
		$thn = $this->input->get('tahun');
    	$data = [
    		'content' => 'santunan_korpri/statistik',
			'jenis' => $this->korpri->ref_santunan()->result(),
			'tahun' => $thn,
			'list_tahun' => $this->korpri->list_tahun()->result(),
			'js'	  => 'santunan_korpri/statistik_santunan_js',
    	];
      $this->load->view('template', $data);
    }
    
    // ---------------- Rekapitulasi -------------------//
    public function rekapitulasi_santunan() {
    	$data = [
    		'content' => 'santunan_korpri/rekap_santunan',
    		'js'	  => 'santunan_korpri/rekap_santunan_js',
			'jenis' => $this->korpri->ref_santunan()->result()
    	];
      $this->load->view('template', $data);
    }
    
    public function data_rekapitulasi_santunan() {
    	$tahun = $this->input->post('tahun');
    	$bulan = $this->input->post('bulan');
    	$jns_santunan = $this->input->post('jns_santunan');
    	$fetch_data = $this->korpri->fetch_datatable($tahun, $bulan, $jns_santunan);
    	
    	$data = array();
  		$no = $_POST['start'];
  		foreach($fetch_data as $row) {
  			
  			if($row->fid_jenis_tali_asih == 1) {
		    	$ket = $row->tgl_bup; 
		    } elseif($row->fid_jenis_tali_asih == 2 || $row->fid_jenis_tali_asih == 4 || $row->fid_jenis_tali_asih == 5) {
		    	$ket = $row->tgl_meninggal;
		    } else {
		    	$ket = $row->tgl_kebakaran;
		    }
		    
		    if($row->tgl_cetak == "") {
		    	$iconprint = '<i class="glyphicon glyphicon-check"></i>';
		    	$colorbtn  = 'warning';
		    } else {
		    	$iconprint = '<i class="glyphicon glyphicon-print"></i>';
		    	$colorbtn  = 'success';
		    }
		    
		    $gelar_depan = $row->gelar_depan ? $row->gelar_depan : $row->gd_pensiun;
		    $nama = $row->nama ? $row->nama : $row->nama_pensiun;
		    $gelar_belakang = $row->gelar_belakang ? $row->gelar_belakang : $row->gb_pensiun;
		    
		    $sub_array = array();
		    $sub_array[] = $no+1;
		    $sub_array[] = $row->nip;
		    $sub_array[] = "<b>".namagelar($gelar_depan, $nama, $gelar_belakang)."</b>";
		    $sub_array[] = "<b>".$this->korpri->jenis($row->fid_jenis_tali_asih)."</b><br>".tgl_indo($ket);
		    $sub_array[] = $row->bulan;
		    $sub_array[] = $row->tahun;
		    $sub_array[] = "Rp. ".nominal($row->besar_santunan);
		    $sub_array[] = $row->unit_kerja;
		    $sub_array[] = $row->note;
		    $sub_array[] = '<button type="button" onClick="cetak_kwt('.$row->id_tali_asih.')" class="btn btn-md btn-'.$colorbtn.'"><span id="icon-check-'.$row->id_tali_asih.'">'.$iconprint.'</span></button>';
		    $data[] = $sub_array;
		  $no++;
		  }
		
		  $output = array(
		    'draw'  		  => intval($_POST['draw']),
		    'recordsTotal' 	  => $this->korpri->get_all_data($tahun, $bulan, $jns_santunan),
		    'recordsFiltered' => $this->korpri->get_filtered_data($tahun, $bulan, $jns_santunan),
		    'data'			  => $data			
		  );
		
		  echo json_encode($output);
    }
    
    // ---------------- Entri santunan -------------------//
    public function cekpenggunasantunan() {
    	$nip = $this->input->post('nip');
    	$response = array();
    	if(isset($nip)) {
    		$dbnip = $this->korpri->dbnip($nip);
    		if($dbnip != true) {
    			$response = array('valid' => false, 'message' => 'ASN ybs, sudah mendapat santunan');
    		} else {
    			$response = array('valid' => true);
    		}
    	}
    	echo json_encode($response);
    }
    
    public function ceknip2() {
    	$nip = $this->input->get('nip');
    	$unitkerja = $this->korpri->cekunitkerja($nip);
    	$data = $this->korpri->ceknip($nip);
    	if($data->num_rows() > 0) {
    		$d = $data->row();
    		
		$dbnip = $this->korpri->dbnip($nip);
		if($dbnip == true) {
			$icon = "<i class='fa fa-check-circle fa-3x text-success'></i>";
		} else {
			$icon = "<i class='fa fa-times-circle fa-3x text-danger'></i>";
		}
    		
    	$lokasifile = './photo/';
        $filename = "$nip.jpg";
    	if (file_exists ($lokasifile.$filename)) {
          $photo = "../photo/$nip.jpg";
        } else {
          $photo = "../photo/nophoto.jpg";
        }
	      
		$rwysetuju = $this->mpegawai->rwyupdate_setuju($nip);
	      if ($rwysetuju == 1) {
	    		$img = '<img src="data:image/jpeg;base64,'.base64_encode($this->mpegawai->show_photo_pegawai($nip)).'" alt="'.$nip.'" width="110" height="140"  class="img-thumbnail"/>';
	      } else {
					$img = "<img src='$photo' width='110' height='140' alt='$nip' class='img-thumbnail'>";
				}
				
				$html = $img;
				$html .= "<hr>";
    		$html .= "<b>".namagelar($d->gelar_depan, $d->nama, $d->gelar_belakang)."</b><br><br>".$icon;
    		$unker = $unitkerja->nama_unit_kerja;
    	} else {
    		$html = "<span class='text-danger'>PNS tidak ditemukan</span>"; 
    		$unker = "";
    	}
    	
    	echo json_encode(['data' => $html, 'unker' => $unker]);
    }

	public function ceknip() {
    	$nip = $this->input->get('nip');
    	$data = $this->korpri->ceknip($nip);
		$dbnip = $this->korpri->dbnip($nip);

		if($dbnip == false) {
			$result = '<b>ERROR</b>, DATA SANTUNAN SUDAH ADA';
			$result_status = false;
			$unor = null;
		} else {
			if($data->num_rows() > 0) {
			$d = $data->row();	

				if($dbnip == true) {
					$icon = "<i class='fa fa-check-circle fa-3x text-success'></i>";
				} else {
					$icon = "<i class='fa fa-times-circle fa-3x text-danger'></i>";
				}

				$lokasifile = './photo/';
				$filename = "$nip.jpg";
				if (file_exists ($lokasifile.$filename)) {
					$photo = "../photo/$nip.jpg";
				} else {
					$photo = "../photo/nophoto.jpg";
				}

				$rwysetuju = $this->mpegawai->rwyupdate_setuju($nip);
				if ($rwysetuju == 1) {
					$img = '<img src="data:image/jpeg;base64,'.base64_encode($this->mpegawai->show_photo_pegawai($nip)).'" alt="'.$nip.'" width="80" height="110"  class="img-thumbnail"/>';
				} else {
					$img = "<img src='$photo' width='80' height='110' alt='$nip' class='img-thumbnail'>";
				}

				if(isset($d->nama_unit_kerja) != "") {
					$unor = $d->nama_unit_kerja;
				} else {
					$unor = $this->korpri->getnamaunitkerja($d->fid_unit_kerja);
				}

				if(isset($d->fid_jnsjab) != "") {
					
					if ($d->fid_jnsjab == 1) { $idjab = $d->fid_jabatan;
					}elseif ($d->fid_jnsjab == 2) { $idjab = $d->fid_jabfu;
					}elseif ($d->fid_jnsjab == 3) { $idjab = $d->fid_jabft;
					}

					$tmtbup = '<span>TMT BUP <br><b>'.$this->mpegawai->gettmtbup($idjab, $d->tgl_lahir, $d->fid_jnsjab).'</b></span>';
				} else {
					$tmtbup = '';
				}

				$result = '
					<div style="display: flex; justify-content: start; align-item: center; gap: 12px; border: 1px dashed blue; background:#eaeaea; padding: 8px">
						<div>
							'.$img.'
						</div>
						<div style="display: flex; flex-direction: column; justify-content: start; gap: 4px;">
							<span>NAMA <br><b>'.namagelar($d->gelar_depan, $d->nama, $d->gelar_belakang).'</b></span>
							<span>NIP <br><b>'.polanip($d->nip).'</b></span>
							'.$tmtbup.'
							<span>UNIT KERJA <br><b>'.$unor.'</b></span>
						</div>
					</div>
				';
				$result_status = true;
			} else {
				$result = '<b>WARNING</b>, DATA TIDAK DITEMUKAN';
				$result_status = false;
				$unor = null;
			}
		}
    	echo json_encode(['data' => $result, 'status' => $result_status, 'unor' => $unor]);
    }
    
    public function entri_santunan() {
    	
    	$nip = $this->input->post('nip');
    	$thn_bup = $this->input->post('thn_bup');
    	$bulan_bup = $this->input->post('bulan_bup');
    	$jenis = $this->input->post('jenis');
    	// jika santunan bup
    	if($jenis == 'BUP') {
    		$data['type'] = array(
    			'jenis' => 'bup', 
    			'unker' => $this->munker->dd_unker()->result(),
    			'pegsantunan_js' => 'santunan_korpri/pegsantunan_js',
    			'tahun_bup' => $thn_bup,
    			'bulan_bup' => $bulan_bup,
    			'nip' => $nip);
    	} 
    	//jika santunan non bup
    	else 
    	{
    		$data['type'] = array(
    			'jenis' => 'non_bup',
    			'nip' => $nip,
    			'pegsantunan_js' => 'santunan_korpri/pegsantunan_js',
    			'unker' => $this->munker->dd_unker()->result(),
    			);
    	} 
    	
      $data['content'] = 'santunan_korpri/pegsantunan';
      $this->load->view('template', $data);
    	
    }
    
    public function save() {
    	$nip = $this->input->post('nip');
    	$unker = $this->input->post('unit_kerja');
    	$jta = $this->input->post('jenis_santunan_korpri');
    	$besar_santunan = $this->input->post('besar_santunan');
    	$tahun = $this->input->post('tahun');
    	$bulan = $this->input->post('bulan');
    	$tgl_bup = $this->input->post('tgl_bup');
    	$tgl_meninggal = $this->input->post('tgl_meninggal');
    	$tgl_kebakaran = $this->input->post('tgl_kebakaran');
    	$note = $this->input->post('note');
    	
    	
    	$data = [
    		'nip' => $nip,
    		'fid_jenis_tali_asih' => $jta,
    		'tahun' => $tahun,
    		'bulan' => $bulan,
    		'unit_kerja' => $unker,
    		'besar_santunan' => str_replace(".", "", $besar_santunan),
    		'tgl_meninggal' => $tgl_meninggal,
    		'tgl_bup' => $tgl_bup,
    		'tgl_kebakaran' => $tgl_kebakaran,
    		'nip_petugas' => $this->session->userdata('nip'),
    		'note' => $note
    	];
    	
    	$cekdata = $this->korpri->ceknip($nip);
    	if($cekdata->num_rows() > 0) {
    		$db = $this->korpri->save_santunan($data);
    		if($db) {
    			$msg = array("stsCode" => 200, "msg" => "Sukses, santunan berhasil ditambahkan");
    		} else {
    			$msg = array("stsCode" => 301, "msg" => "Gagal, terjadi kesalahan. Coba prikasa kembali");
    		}
    	} else {
    		$msg = array("stsCode" => 301, "msg" => "Data tidak valid");
    	}
    	
    	echo json_encode($msg);
    }
    
    public function cetak($tahun,$bulan,$jenis) {
		  $data = $this->korpri->cetakrekapitulasi($tahun,$bulan,$jenis)->result();
		  $result['parseData'] = array('data' => $data, 'tahun' => $tahun, 'bulan' => $bulan, 'jenis' => $jenis);
			$this->load->view('santunan_korpri/cetak', $result);
		}
		public function update_tgl_cetak($id) {
			$date = ['tgl_cetak' => date('Y-m-d')];
			$this->korpri->update_tgl_cetak($id,$date);
			echo json_encode("Tanggal Cetak: ".tgl_indo($date['tgl_cetak']));
		}
    public function cetak_kwitansi($id) {
		  $data = $this->korpri->cetak_kwitansi($id)->result();
		  $result['parseData'] = array('data' => $data, 'id' => $id);
			$this->load->view('santunan_korpri/cetak_kwt', $result);
		}  
}