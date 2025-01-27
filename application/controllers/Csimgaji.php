<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csimgaji extends CI_Controller {

  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {
    parent::__construct();
    $this->load->model('mabsensi');

    $this->load->helper('form');
    $this->load->helper('fungsitanggal');
    $this->load->helper('fungsipegawai');
    $this->load->helper('absensi');
    $this->load->model('mpegawai');
    $this->load->model('mpppk');
    $this->load->model('madmin');
    $this->load->model('mkinerja');
    $this->load->model('mkinerja_pppk');
    $this->load->model('munker');
    $this->load->model('mabsensi');

    // untuk fpdf
    //$this->load->library('fpdf');

    // untuk login session
    if (!$this->session->userdata('nama'))
    {
      redirect('login');
    }
  }
 
  function curl($url){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    curl_close($ch);      
    return $output;
  }

  public function coba() {
	// A sample PHP Script to POST data using cURL
	// Data in JSON format
 
	$data = array(
    	  'username' => 'sharkwifi',
    	  'password' => 'loginwifiwithsocialmedia'
	);
 
	$payload = json_encode($data);
 	
	// Prepare new cURL resource
	$ch = curl_init('http://silka.balangankab.go.id/Csimgaji/coba');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
 
	// Set HTTP Header for POST request
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	  'Content-Type: application/json',
    	  'Content-Length: ' . strlen($payload))
	);
 
	// Submit the POST request
	$result = curl_exec($ch);
 
	// Close cURL session handle
	curl_close($ch);
   }

}
