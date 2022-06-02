<?php
class Datacetaknonpns extends CI_Model {
    //put your code here
    function __construct(){
      parent::__construct();
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('munker');      
      $this->load->model('madmin');
    }   
    

    function datanomperunker() {
      $idunker = $this->input->post('idunker');      
      $query = $this->mnonpns->nomperunker($idunker);

      return $query->result();

    }
}