<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Jabatan extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['api/v2/Riwayat' => 'rw']);
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
        $data = $this->rw->getRiwayatJabatan($params);

        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Jabatan',
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada'
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Jabatan',
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "id" => $row->id,
                "id_bkn" => $row->id_bkn,
                // "nip" => $row->nip,
                "unit_kerja" => $row->unit_kerja,
                "jabatan" => $row->jabatan,
                "jns_jab" => $row->jns_jab,
                "eselon" => $row->eselon,
                "kelas" => $row->kelas,
                "harga" => $row->harga,
                "angka_kredit" => $row->angka_kredit,
                "tunjangan" => $row->tunjangan,
                "tmt_jabatan" => $row->tmt_jabatan,
                "no_sk_baperjakat" => $row->no_sk_baperjakat,
                "tgl_pelantikan" => $row->tgl_pelantikan,
                "pejabat_sk" => $row->pejabat_sk,
                "no_sk" => $row->no_sk,
                "tgl_sk" => $row->tgl_sk,
                "prosedur" => $row->prosedur,
                "note" => $row->note,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
                "berkas" => $row->berkas,
                "id_siasn" => $row->id_siasn,
                "path_siasn" => $row->path_siasn,
                "jenisJabatan" => $row->jenisJabatan,
                "jabatanFungsionalId" => $row->jabatanFungsionalId,
                "jabatanFungsionalUmumId" => $row->jabatanFungsionalUmumId,
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
            'kind' => 'Riwayat Jabatan',
            'status' => true,
            'message' => 'Riwayat Jabatan '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}