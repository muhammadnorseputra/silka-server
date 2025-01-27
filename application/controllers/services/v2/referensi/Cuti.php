<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Cuti extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['api/v2/Referensi' => 'ref']);
        // Cek Token JWT
        $this->authverify = $this->authverify->verifyToken();
        if (!$this->authverify['status']){
            return $this->response($this->authverify, REST_Controller::HTTP_UNAUTHORIZED);
            die();
        }
    }

    public function index_get($id=null)
    {
        $params = [
            'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : "desc", // default = desc
            'limit' => $this->query('limit'),  //default = 10
            'offset' => $this->query('offset'),
            'field' => $this->query('field') ? explode(',', $this->query('field')) : []
        ];

        $data = $this->ref->getStatusCuti((int) $id, $params);
        

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Referensi#Status Cuti',
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Jika Berhasil
        $result = [
            'kind' => 'Referensi#Status Cuti',
            'status' => true,
            'message' => 'Referensi Ditemukan',
            'count' => $data->num_rows(),
            'data' => $data->result()
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function pengantar_get($id=null)
    {
        $params = [
            'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : "desc", // default = desc
            'limit' => $this->query('limit'),  //default = 10
            'offset' => $this->query('offset'),
            'field' => $this->query('field') ? explode(',', $this->query('field')) : []
        ];

        $data = $this->ref->getStatusPengantarCuti((int)$id, $params);
        

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Referensi#Status Pengantar Cuti',
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Jika Berhasil
        $result = [
            'kind' => 'Referensi#Status Pengantar Cuti',
            'status' => true,
            'message' => 'Referensi Ditemukan',
            'count' => $data->num_rows(),
            'data' => $data->result()
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }


}