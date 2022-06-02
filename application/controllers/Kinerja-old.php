<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kinerja extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
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
      $this->load->model('mkinerja');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }
    }
  
	public function index()
	{	  
	}

  function tampilunkernom()
  {
    //cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['content'] = 'kinerja/tampilunkernom';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function nomperunker()
  { 
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $id = $this->input->post('id_unker');
      $thn = $this->input->post('thn');
      $bln = $this->input->post('bln');

      $data['thn'] = $thn;
      $data['bln'] = $bln;

      $data['idunker'] = $this->mkinerja->get_idunkerkinerja($id);
      $data['nmunker'] = $this->munker->getnamaunker($id);
      $data['jmlpeg'] = $this->munker->getjmlpeg($id);
      $data['content'] = 'kinerja/nomperunker';
      $this->load->view('template',$data);
    }
  }
  
  function cekharjab() {
  	//cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y")) {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['content'] = 'kinerja/tampilunkerharjab';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }
  
  function tampiltabelharjab() {
  	//result_table
  	$idunker = $this->input->post('id');
  	$data = [
  		'id' => $idunker,
  		'nunker' => $this->munker->getnamaunker($idunker),
  		'jml_pns' => count($this->munker->pegperunker($idunker)->result_array()),
  		'data_jst' => $this->mkinerja->get_data_jst('ref_jabstruk', $idunker),
  		'data_jfu' => $this->mkinerja->get_data_jfu('pegawai', 'ref_jabfu', $idunker),
  		'data_jft' => $this->mkinerja->get_data_jft('pegawai', 'ref_jabft', $idunker)
  	];
  	$this->load->view('kinerja/getharjab', $data);
  }
    
 }

/* End of file Akunpns.php */
/* Location: ./application/controllers/Akunpns.php */
