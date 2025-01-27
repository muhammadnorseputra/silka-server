<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Absensi extends REST_Controller  {
    
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
                'nip' => !empty($nip) ? $nip : $this->nip, // required
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
                'kind' => 'Riwayat Absensi#'.$params['jenis'],
                'status' => false,
                'message' => 'Parameter `statusAsn` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        if($params['jenis'] === 'pns') {
            $data = $this->rw->getRiwayatAbsensi($params);
        }

        if($params['jenis'] === 'pppk') {
            $data = $this->rw->getRiwayatAbsensiPppk($params);
        }

        if($params['jenis'] !== 'pns' && $params['jenis'] !== 'pppk')
        {
            return show_error("Status ASN Tidak Valid", 500, "Error");
        }
        
        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'Riwayat Absensi#'.$params['jenis'],
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'Riwayat Absensi#'.$params['jenis'],
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
                "bulan" => $row->bulan,
                "tahun" => $row->tahun,
                "jml_hari" => $row->jml_hari,
                "hadir_old" => $row->hadir_old,
                "izin_old" => $row->izin_old,
                "sakit_old" => $row->sakit_old,
                "terlambat_old" => $row->terlambat_old,
                "pulang_cepat_old" => $row->pulang_cepat_old,
                "tk_old" => $row->tk_old,
                "cuti_old" => $row->cuti_old,
                "tudin_old" => $row->tudin_old,
                "tubel_old" => $row->tubel_old,
                "total_pengurang_old" => $row->total_pengurang_old,
                "realisasi_old" => $row->realisasi_old,
                "hadir" => $row->hadir,
                "izin" => $row->izin,
                "sakit" => $row->sakit,
                "terlambat" => $row->terlambat,
                "pulang_cepat" => $row->pulang_cepat,
                "tk" => $row->tk,
                "cuti" => $row->cuti,
                "tudin" => $row->tudin,
                "tepat_waktu" => $row->tepat_waktu,
                "izin_terlambat" => $row->izin_terlambat,
                "izin_pulangcepat" => $row->izin_pulangcepat,
                "total_pengurang" => $row->total_pengurang,
                "realisasi" => $row->realisasi,
                "entry_by" => $row->entry_by,
                "entry_at" => $row->entry_at,
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
            'kind' => 'Riwayat Absensi#'.$params['jenis'],
            'status' => true,
            'message' => 'Riwayat Absensi '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}