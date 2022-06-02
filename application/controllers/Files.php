<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load Helper 
        $this->load->helper(array('url','form','fungsitanggal','fungsipegawai','file','storage','number'));
        // Load Model
        $this->load->model(array('mpegawai','mpensiun'));
		
				// Cek Session
		    if (!$this->session->userdata('nama'))
		    {
		      redirect('login');
		    }
    }
    
  // -------------------------- start-storages ------------------------//
	public function index() {
  	 //cek priviledge session user -- profil_priv
    if ($this->session->userdata('level') == "ADMIN") { 
      $data['content'] = 'admin/storages';
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
   }
   
   public function cek_nip() {
   	$nip = $this->input->post('nip');
   	
   	$file_photo = filechek($nip, 'photo', 'read');
   	$file_perso = filechek($nip, 'fileperso', 'read');
   	$file_skp = filechek($nip, 'fileskp', 'read');
   	$file_pdk = filechek($nip, 'filepdk', 'read');
   	$file_kp = filechek($nip, 'filekp', 'read');
   	$file_kgb = filechek($nip, 'filekgb', 'read');
   	$file_jab = filechek($nip, 'filejab', 'read');
   	$file_hd = filechek($nip, 'filehd', 'read');
   	$file_cp = filechek($nip, 'filecp', 'read');
   	
		$marge = [
			'photo' => $file_photo,
			'file_perso' => $file_perso,
			'file_skp' => $file_skp,
			'file_pdk' => $file_pdk,
			'file_kp' => $file_kp,
			'file_kgb' => $file_kgb,
			'file_jab' => $file_jab,
			'file_hd' => $file_hd,
			'file_cp' => $file_cp
		];
   	echo json_encode($marge);
   }
   
   public function cek_nip_multidel() {
     $nip = $this->input->post('nip');
     
     $jml_files = multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'jml');
     $size_files = multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'size');
        
     $marge_jml_total = array_multisum($jml_files);
     $marge_size_total = byte_format(array_multisum($size_files));
    
     $data = ['nip' => $nip, 'total_files' => $marge_jml_total, 'total_sizes' => $marge_size_total, 'uri_next' => base_url('files/multidel')];
   
     echo json_encode($data);
   }
   

  public function onefile() {  
    $filename = $this->input->post('file');
    
    if(file_exists($filename)) {
      $msg = ['status' => true, 'file' => "DELETE(".$filename.")"];
      unlink($filename);
    } else {
      $msg = ['status' => false, 'file' => 'FILE NOT FOUND !'];
    }
    echo json_encode($msg);
  }		
  
  public function multidel() {
    $nip = trim($this->input->post('nip'), " ");
    $is_pns_aktif = $this->mpegawai->detail($nip)->num_rows();
    if($is_pns_aktif == 0) {
      if(!empty($nip) && is_numeric($nip)) {
        multicheckfiles($nip, ['photo','fileperso','fileskp','filepdk','filekp','filekgb','filejab','filehd','filecp'], 'del');
        $msg = ['status' => true, 'file' => "SEMUA FILES {$nip} TERLAH DIHAPUS !"];
      } else {
        $msg = ['status' => false, 'file' => 'FILES SUDAH BERSIH !'];
      }
    } else {
      $msg = ['status' => false, 'file' => 'STATUS PNS AKTIF ! '];
    }
    echo json_encode($msg);
  }			
	// -------------------------- end-storages ------------------------//   
    
    
}