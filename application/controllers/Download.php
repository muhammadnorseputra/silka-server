<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

  var $limit=10;
  var $offset=10;

    public function __construct() {
        parent::__construct();
        //$this->load->model('model_upldgbr'); //load model model_upldgbr yang berada di folder model
        $this->load->helper(array('url')); //load helper url 
        $this->load->model('mpegawai');
        $this->load->helper('fungsitanggal');
        $this->load->helper('fungsipegawai');
        $this->load->model('munker');
        $this->load->library('ftp');
    }
    
    public function cpnspns() {
        $file = $this->input->post('file');       

        $config['hostname'] = '192.168.1.4';
        $config['username'] = 'silka_ftp';
        $config['password'] = 'FtpSanggam';
        $config['debug'] = TRUE;

        $this->ftp->connect($config);      

        $this->ftp->download($file, '/home/wenkdhira/Downloads/'.$file, 'ascii');

        $this->ftp->close(); 
    }
}
