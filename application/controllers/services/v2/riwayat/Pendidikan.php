<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Pendidikan extends REST_Controller  {
    
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
        $data = $this->rw->getRiwayatPendidikan($params);

        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Pendidikan',
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada'
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Pendidikan',
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "id" => $row->id,
                // "nip" => $row->nip,
                "fid_tingkat" => $row->fid_tingkat,
                "fid_jurusan" => $row->fid_jurusan,
                "thn_lulus" => $row->thn_lulus,
                "nama_sekolah" => $row->nama_sekolah,
                "nama_kepsek" => $row->nama_kepsek,
                "no_sttb" => $row->no_sttb,
                "tgl_sttb" => $row->tgl_sttb,
                "gelar_dpn" => $row->gelar_dpn,
                "gelar_blk" => $row->gelar_blk,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
                "berkas" => $row->berkas,
                "id_siasn" => $row->id_siasn,
                "path_siasn" => $row->path_siasn,
                "pendidikan_siasn" => $row->pendidikan_siasn,
                "id_tingkat_pendidikan" => $row->id_tingkat_pendidikan,
                "id_bkn" => $row->id_bkn,
                "ref_tingkat_pendidikan" => [
                    "id_tingkat_pendidikan" => $row->id_tingkat_pendidikan,
                    "nama_tingkat_pendidikan" => $row->nama_tingkat_pendidikan,
                ],
                "ref_jurusan_pendidikan" => [
                    "id_jurusan_pendidikan" => $row->id_jurusan_pendidikan,
                    "nama_jurusan_pendidikan" => $row->nama_jurusan_pendidikan,
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
            'kind' => 'Riwayat Pendidikan',
            'status' => true,
            'message' => 'Riwayat Pendidikan '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}