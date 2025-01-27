<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Sutri extends REST_Controller  {
    
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
                'kind' => 'Riwayat Sutri#'.$params['jenis'],
                'status' => false,
                'message' => 'Parameter `statusAsn` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        if($params['jenis'] === 'pns') {
            $data = $this->rw->getRiwayatSutri($params);
        }

        if($params['jenis'] === 'pppk') {
            $data = $this->rw->getRiwayatSutriPppk($params);
        }

        if($params['jenis'] !== 'pns' && $params['jenis'] !== 'pppk')
        {
            return show_error("Status ASN Tidak Valid", 500, "Error");
        }
        
        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Sutri#'.$params['jenis'],
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Sutri#'.$params['jenis'],
                'status' => false,
                'message' => 'Data Tidak Ditemukan',
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                // "nip" => $row->nip,
                "nama_sutri" => $row->nama_sutri,
                "id" => (int) $row->id,
                "sutri_ke" => (int) $row->sutri_ke,
                "tgl_nikah" => $row->tgl_nikah,
                "no_akta_nikah" => $row->no_akta_nikah,
                "tmp_lahir" => $row->tmp_lahir,
                "tgl_lahir" => $row->tgl_lahir,
                "fid_tingkat_pendidikan_hapus" => (int) $row->fid_tingkat_pendidikan_hapus,
                "pekerjaan" => $row->pekerjaan,
                "no_karisu" => $row->no_karisu,
                "nip_sutri" => $row->nip_sutri,
                "status_kawin" => $row->status_kawin,
                "status_hidup" => $row->status_hidup,
                "tanggungan" => $row->tanggungan,
                "tgl_cerai" => $row->tgl_cerai,
                "no_akta_cerai" => $row->no_akta_cerai,
                "tgl_meninggal" => $row->tgl_meninggal,
                "no_akta_meninggal" => $row->no_akta_meninggal,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
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
            'kind' => 'Riwayat Sutri#'.$params['jenis'],
            'status' => true,
            'message' => 'Riwayat Sutri '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}