<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class KinerjaBkn extends REST_Controller  {
    
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
        $data = $this->rw->getRiwayatKinerjaBkn($params);

        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Kinerja BKN',
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
                
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Kinerja BKN',
                'status' => false,
                'message' => 'Data Tidak Ditemukan',
                
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "id" => (int) $row->id,
                "tahun" => (int) $row->tahun,
                "bulan" => $row->bulan,
                "jenis" => $row->jenis,
                "id_bkn" => (int) $row->id_bkn,
                "nip" => $row->nip,
                "nama" => $row->nama,
                "skp_unor_id" => $row->skp_unor_id,
                "skp_unor" => $row->skp_unor,
                "skp_unor_induk" => $row->skp_unor_induk,
                "skp_jabatan" => $row->skp_jabatan,
                "skp_jenis_jabatan" => $row->skp_jenis_jabatan,
                "is_skp_plt_plh_pjb" => $row->is_skp_plt_plh_pjb,
                "hasil_kerja" => $row->hasil_kerja,
                "perilaku_kerja" => $row->perilaku_kerja,
                "hasil_akhir" => $row->hasil_akhir,
                "pegawai_atasan_id" => $row->pegawai_atasan_id,
                "pegawai_atasan_nip" => $row->pegawai_atasan_nip,
                "pegawai_atasan_nama" => $row->pegawai_atasan_nama,
                "pegawai_atasan_unor_id" => $row->pegawai_atasan_unor_id,
                "pegawai_atasan_unor" => $row->pegawai_atasan_unor,
                "pegawai_atasan_jabatan" => $row->pegawai_atasan_jabatan,
                "pegawai_atasan_golru" => $row->pegawai_atasan_golru,
                "waktu_dinilai" => $row->waktu_dinilai,
                "pegawai_penilai_id" => $row->pegawai_penilai_id,
                "tgl_tarikdata" => $row->tgl_tarikdata,
                "berkas" => $row->berkas,
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
            'kind' => 'Riwayat Kinerja BKN',
            'status' => true,
            'message' => 'Riwayat Kinerja BKN '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}