<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Pppk extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api']);
        $this->load->helper('fungsipegawai');
        $this->config->set_item('rest_auth', 'basic');
        $this->config->set_item('auth_source', '');
    }

    public function index_post() {
        $uid = $this->post('unor_id');
        $data = $this->api->services_pppk_by_unker($uid);

        // Jika Params / Body unor_id tidak ada
        if(empty($uid)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `unor_id` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data PPPK Dengan UNOR_ID '.$uid.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND,
                'data' => []
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $body = [];
        foreach($data->result() as $r) {
            $body[] = [
                'nipppk' => $r->nipppk,
                'pppk_id' => $r->pppk_id,
                'nik' => polanip($r->nipppk),
                'nama' => $r->nama,
                'nama_lengkap' => namagelar($r->gelar_depan, $r->nama, $r->gelar_blk),
                'jabatan' => $r->nama_jabft,
                'golru' => $r->nama_golru,
                'status_data' => $r->status_data,
                'tpp_sync' => $r->tpp_sync,
                'kgb_sync' => $r->kgb_sync,
            ];
        }
        // Jika Berhasil
        $result = [
            'kind' => 'Data PPPK By Unor',
            'status' => true,
            'message' => count($body).' Data Pegawai Ditemukan',
            'data' => $body
        ];
        $this->response($result, REST_Controller::HTTP_OK);

    }

}