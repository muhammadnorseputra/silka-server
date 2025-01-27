<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Plt extends REST_Controller  {
    
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
        $data = $this->rw->getRiwayatPlt($params);

        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Plt',
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
                
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Plt',
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
                "no_sk" => $row->no_sk,
                "tmt_awal" => $row->tmt_awal,
                "tmt_akhir" => $row->tmt_akhir,
                "jns_jabatan" => $row->jns_jabatan,
                "tgl_sk" => $row->tgl_sk,
                "pejabat_sk" => $row->pejabat_sk,
                "fid_jabstruk" => $row->fid_jabstruk,
                "fid_eselon" => $row->fid_eselon,
                "jabatan" => $row->jabatan,
                "unit_kerja" => $row->unit_kerja,
                "id_jabatan" => $row->id_jabatan,
                "id_bkn" => $row->id_bkn,
                "nama_jabatan" => $row->nama_jabatan,
                "nama_unor" => $row->nama_unor,
                "aktif" => $row->aktif,
                "usia_pensiun" => $row->usia_pensiun,
                "kelompok_tugas" => $row->kelompok_tugas,
                "fid_jabatan_induk" => $row->fid_jabatan_induk,
                "fid_unit_kerja" => $row->fid_unit_kerja,
                "kelas" => $row->kelas,
                "harga" => $row->harga,
                "no_urut" => $row->no_urut,
                "id_eselon" => $row->id_eselon,
                "id_simgaji" => $row->id_simgaji,
                "nama_eselon" => $row->nama_eselon,
                "jab_asn" => $row->jab_asn,
                "level_terendah" => $row->level_terendah,
                "level_tertinggi" => $row->level_tertinggi,
                "tunjangan" => $row->tunjangan,
                "ref_jabstruk" => [
                    "id_jabatan" => $row->id_jabatan,
                    "nama_jabatan" => $row->nama_jabatan
                ],
                "ref_eselon" => [
                    "id_eselon" => $row->id_eselon,
                    "nama_eselon" => $row->nama_eselon
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
            'kind' => 'Riwayat Plt',
            'status' => true,
            'message' => 'Riwayat Plt '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}