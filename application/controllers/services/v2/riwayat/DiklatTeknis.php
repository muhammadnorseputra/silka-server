<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class DiklatTeknis extends REST_Controller  {
    
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
                'jenis' => strtolower($this->query('statusAsn'))
            ];
        } else {
            $params = [
                'nip' => $this->nip, // required
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : "desc", // default = desc
                'limit' => $this->query('limit'),  //default = 10
                'offset' => $this->query('offset'),
                'field' => $this->query('field') ? explode(',', $this->query('field')) : [],
                'jenis' => strtolower($this->query('statusAsn'))
            ];
        }

        // Params Wajib
        if(empty($params['jenis'])) {
            $msg = [
                'kind' => 'Riwayat Diklat#Teknis '.$params['jenis'],
                'status' => false,
                'message' => 'Parameter `statusAsn` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        if($params['jenis'] === 'pns') {
            $data = $this->rw->getRiwayatDiklatTeknis($params);
        }
        if($params['jenis'] === 'pppk') {
            $data = $this->rw->getRiwayatDiklatTeknisPppk($params);
        }

        if($params['jenis'] !== 'pns' && $params['jenis'] !== 'pppk')
        {
            $msg = [
                'kind' => 'Riwayat Workshop#'.$params['jenis'],
                'status' => false,
                'message' => 'INTERNAL SERVER ERROR !',
            ];
            return $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Diklat#Teknis '.$params['jenis'],
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Diklat#Teknis '.$params['jenis'],
                'status' => false,
                'message' => 'Data Tidak Ditemukan',
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                // "nip" => $row->nip,
                "no" => $row->no,
                "nama_diklat_teknis" => $row->nama_diklat_teknis,
                "tahun" => (int) $row->tahun,
                "instansi_penyelenggara" => $row->instansi_penyelenggara,
                "tempat" => $row->tempat,
                "tanggal_lama" => $row->tanggal_lama,
                "tanggal" => $row->tanggal,
                "lama_bulan" => $row->lama_bulan,
                "lama_hari" => $row->lama_hari,
                "lama_jam" => $row->lama_jam,
                "pejabat_sk" => $row->pejabat_sk,
                "no_sk" => $row->no_sk,
                "tgl_sk" => $row->tgl_sk,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
                "id_siasn" => $row->id_siasn,
                "path_siasn" => $row->path_siasn,
                "jenis_diklat_siasn" => $row->jenis_diklat_siasn,
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
            'kind' => 'Riwayat Diklat#Teknis '.$params['jenis'],
            'status' => true,
            'message' => 'Riwayat Diklat#Teknis '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}