<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sotk extends CI_Controller {
  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {            
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('msotk');
    $this->load->model('datacetak');
    $this->load->library('fpdf');
    $this->load->helper('fungsitanggal');
  }

	public function index()
	{
	}  
  
  public function tampilunker()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('sotk_priv') == "Y") { 
      $data['pilihunker'] = $this->msotk->pilihunker()->result_array();
      $data['content'] = 'sotk/tampilunker';
      $this->load->view('template',$data);
    }
  } 

  public function cetak()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('cetak_sotk_priv') == "Y") { 
      $idunker = $this->input->post('id_unker');
      //$res['data'] = $this->msotk->sotk($idunker);
      $res['data'] = $this->msotk->sotk($idunker)->result();

      $nmfile = 'sotk/'.$this->msotk->getnamafile($idunker);
      $this->load->view($nmfile,$res);
    }
  } 
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
