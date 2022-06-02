<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Harjab extends CI_Controller {

	public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('madmin');
      $this->load->model('munker');
      $this->load->model('mtakah');
      $this->load->model('mharjab');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }
    }
  public function index()
	{	  
	}
	function cekharjab() {
  	//cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y")) {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'harjab/tampilunkerharjab-kinerja';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }
  
  function tampiltabelharjab() {
  	//result_table
  	$idunker = $this->input->get('id');
  	$data = [
  		'id' => $idunker,
  		'nunker' => $this->munker->getnamaunker($idunker),
  		'jml_pns' => count($this->munker->pegperunker($idunker)->result_array()),
  		'data_jst' => $this->mharjab->get_data_jst('ref_jabstruk', $idunker),
  		'data_jfu' => $this->mharjab->get_data_jfu('pegawai', 'ref_jabfu', $idunker),
  		'data_jft' => $this->mharjab->get_data_jft('pegawai', 'ref_jabft', $idunker)
  	];
  	$this->load->view('harjab/getharjab-kinerja', $data);
  }
  
  function detailharjab() {
  	$id = $this->input->get('id');
  	$data = $this->mharjab->get_data_byid('ref_jabstruk', array('id_jabatan' => $id));
  	echo json_encode($data);
  }
  
  function detailharjab_jfu() {
  	$id = $this->input->get('id');
  	$data = $this->mharjab->get_data_byid('ref_jabfu', array('id_jabfu' => $id));
  	echo json_encode($data);
  }
  
  
  // Update JST
  function updateharjab() {
  	
  	//ID
  	$id = $this->input->post('id_jabatan');
  	
  	//To post
  	$kelas = $this->input->post('kelasjabatan');
  	$harga = $this->input->post('hargajabatan');
		
		//Helpers
  	$namajabatan = $this->mharjab->get_namajabatan_byid($id);
  	$kelasjabatan = $kelas != '' ? "(Kelas Jabatan : <b>".$kelas."</b>)" : '';
  	$hargajabatan = $harga != '' ? "(Harga Jabatan : <b>".$harga."</b>)" : '';
  	  	
  	$post = [
  		'kelas' => $kelas,
  		'harga' => $harga
  	];
  	
  	$whr  = [
  		'id_jabatan' => $id
  	];
  	
  	$send = $this->mharjab->update_data_jst('ref_jabstruk', $post, $whr);
  	if($send == true) {
      $this->session->set_flashdata('message', '<b>'.$namajabatan.'</b>, berhasil diupdate. '.$kelasjabatan.' '.$hargajabatan);
  	} else {
  		$this->session->set_flashdata('message', '<b>'.$namajabatan.'</b>, gagal diupdate.');
  	}
  	
  	redirect(base_url('harjab/cekharjab'));
  }
  
  //Update JFU
  function updateharjab_jfu() {
  	
  	//ID
  	$id = $this->input->post('id_jabfu');
  	
  	//To post
  	$kelas = $this->input->post('kelasjabatan');
  	$harga = $this->input->post('hargajabatan');
		
		//Helpers
  	$namajabatan = $this->mharjab->get_namajabatan_byid_jfu($id);
  	$kelasjabatan = $kelas != '' ? "(Kelas Jabatan : <b>".$kelas."</b>)" : '';
  	$hargajabatan = $harga != '' ? "(Harga Jabatan : <b>".$harga."</b>)" : '';
  	  	
  	$post = [
  		'kelas' => $kelas,
  		'harga' => $harga
  	];
  	
  	$whr  = [
  		'id_jabfu' => $id
  	];
  	
  	$send = $this->mharjab->update_data_jfu('ref_jabfu', $post, $whr);
  	if($send == true) {
      $this->session->set_flashdata('message', '<b>'.$namajabatan.'</b>, berhasil diupdate. '.$kelasjabatan.' '.$hargajabatan);
  	} else {
  		$this->session->set_flashdata('message', '<b>'.$namajabatan.'</b>, gagal diupdate.');
  	}
  	
  	redirect(base_url('harjab/cekharjab'));
  }
}
