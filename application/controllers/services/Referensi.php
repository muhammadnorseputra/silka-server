<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Referensi extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi_referensi' => 'referensi']);
        $this->load->helper('fungsipegawai');
    }

    public function agama_get()
    {
        $id = $this->query('id');
        $id_bkn = $this->query('id_bkn');
        $filter = [
            'id' => $id,
            'id_bkn' => $id_bkn
        ];
       $db = $this->referensi->getAgama($filter);
       if($db->num_rows() > 0) {
        return $this->response([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $db->result()
        ], REST_Controller::HTTP_OK);
       }
       $this->response([
        'status' => false,
        'message' => 'Data Tidak Ditemukan',
        'data' => [],
       ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function skpd_get()
    {
       $id = $this->query('id');
       $filter = [
        'id' => $id,
        'id_skpd_simgaji' => $this->query('id_skpd_simgaji')
       ];
       $db = $this->referensi->getSKPD($filter);
       if($db->num_rows() > 0) {
        return $this->response([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $db->result()
        ], REST_Controller::HTTP_OK);
       }
       $this->response([
        'status' => false,
        'message' => 'Data Tidak Ditemukan',
        'data' => [],
       ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function jenis_pegawai_get()
    {
       $id = $this->query('id');
       $filter = [
        'id' => $id,
       ];
       $db = $this->referensi->getJenisPegawai($filter);
       if($db->num_rows() > 0) {
        return $this->response([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $db->result()
        ], REST_Controller::HTTP_OK);
       }
       $this->response([
        'status' => false,
        'message' => 'Data Tidak Ditemukan',
        'data' => [],
       ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function status_pegawai_get()
    {
       $id = $this->query('id');
       $filter = [
        'id' => $id,
       ];
       $db = $this->referensi->getStatusPegawai($filter);
       if($db->num_rows() > 0) {
        return $this->response([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $db->result()
        ], REST_Controller::HTTP_OK);
       }
       $this->response([
        'status' => false,
        'message' => 'Data Tidak Ditemukan',
        'data' => [],
       ], REST_Controller::HTTP_NOT_FOUND);
    }

}