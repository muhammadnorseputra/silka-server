<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Kgb extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['api/v2/Riwayat' => 'rw']);
        $this->load->helper('fungsipegawai');
        // Cek Token JWT
        $this->authverify = $this->authverify->verifyToken();
        if (!$this->authverify['status']){
            return $this->response($this->authverify, REST_Controller::HTTP_UNAUTHORIZED);
            die();
        }

        // token decode
        $token = \Firebase\JWT\JWT::decode($this->authverify['data'], $this->config->item('secretkey'), array('HS256'));
        $this->level = $token->data->level;
        $this->nip   = $token->data->nip;
    }

    public function index_get($nip=null)
    {
        

        if($this->level === 'ADMIN') {
            $params = [
                'nip' => $nip !== null ? $nip : $this->nip, // required
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : "desc", // default = desc
                'limit' => $this->query('limit'),  //default = 10
                'offset' => $this->query('offset'),
                'field' => $this->query('field') ? explode(',', $this->query('field')) : [], 
            ];
        } else {
            $params = [
                'nip' => $this->nip, // required
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : "desc", // default = desc
                'limit' => $this->query('limit'),  //default = 10
                'offset' => $this->query('offset'),
                'field' => $this->query('field') ? explode(',', $this->query('field')) : [], 
            ];
        }
        $data = $this->rw->getRiwayatKgb($params);

        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat KGB',
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat KGB',
                'status' => false,
                'message' => 'Data Tidak Ditemukan',
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "id" => $row->id,
                // "nip" => $row->nip,
                "fid_golru" => $row->fid_golru,
                "gapok" => $row->gapok,
                "mk_thn" => $row->mk_thn,
                "mk_bln" => $row->mk_bln,
                "tmt" => $row->tmt,
                "pejabat_sk" => $row->pejabat_sk,
                "no_sk" => $row->no_sk,
                "tgl_sk" => $row->tgl_sk,
                "is_sync_simgaji" => $row->is_sync_simgaji,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "berkas" => $row->berkas,
                "id_golru" => $row->id_golru,
                "id_bkn" => $row->id_bkn,
                "id_simgaji" => $row->id_simgaji,
                "ref_golru" => [
                    "nama_golru" => $row->nama_golru,
                    "nama_pangkat" => $row->nama_pangkat,
                ]
            ];
        }

        // Filter data berdasarkan query string atau tampilkan semua jika tidak ada parameter
        $filteredResponse = [];
        foreach ($response as $row) {
            if (empty($params['field'])) {
                // Jika tidak ada parameter, tampilkan semua field
                $filteredResponse[] = $row;
            } else {
                // Jika ada parameter, filter data
                $filteredRow = [];
                foreach ($params['field'] as $field) {
                    if (isset($row[$field])) {
                        $filteredRow[$field] = $row[$field];
                    }
                }
                $filteredResponse[] = $filteredRow;
            } 
        }

        // Jika Berhasil
        $result = [
            'kind' => 'Riwayat KGB',
            'status' => true,
            'message' => 'Riwayat KGB '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}