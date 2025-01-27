<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Tpp extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['api/v2/TppModel' => 'tpp']);
        $this->load->helper('fungsipegawai');
        // Cek Token JWT
        $this->authverify = $this->authverify->verifyToken();
        if (!$this->authverify['status']) {
            return $this->response($this->authverify, REST_Controller::HTTP_UNAUTHORIZED);
            die();
        }

        // token decode
        $token = \Firebase\JWT\JWT::decode($this->authverify['data'], $this->config->item('secretkey'), array('HS256'));
        $this->level = $token->data->level;
        $this->nip   = $token->data->nip;
    }

    public function periode_get($id=null) {
        $params = [
            'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : 'desc',
            'tahun' => $this->query('tahun'),
            'limit' => $this->query('limit'),
            'offset' => $this->query('offset'),
        ];

        $data = $this->tpp->periode($id,$params);

        // PNS Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Periode TPP Tidak Ada'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

         // Jika Berhasil
         $result = [
            'kind' => 'TPP#Periode',
            'status' => true,
            'message' => 'Periode TPP Ditemukan',
            'count' => $data->num_rows(),
            'data' => $data->result()
        ];

        return $this->response($result, REST_Controller::HTTP_OK);
    }

    public function pns_get($nip=null) {
        if($this->level === 'ADMIN') {
            $params = [
                'nip' => $nip ? $nip : $this->nip,
                'periode' => $this->query('periodeId'),
                'pengantar' => $this->query('pengantarId'),
                'status' => $this->query('status') ? $this->query('status') : 'OPEN',
                'bulan' => $this->query('bulan'),
                'tahun' => $this->query('tahun'),
                'limit' => $this->query('limit'),
                'offset' => $this->query('offset'),
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : 'desc',
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        } else {
            $params = [
                'nip' => $this->nip,
                'periode' => $this->query('periodeId'),
                'pengantar' => $this->query('pengantarId'),
                'status' => $this->query('status') ? $this->query('status') : 'OPEN',
                'bulan' => $this->query('bulan'),
                'tahun' => $this->query('tahun'),
                'limit' => $this->query('limit'),
                'offset' => $this->query('offset'),
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : 'desc',
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        }
        $data = $this->tpp->getTppByNip($params);

        // Jika Params / Body NIP tidak ada
        if(empty($params['nip'])) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
                'responseCode' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data TPP Tidak Ditemukan',
                'responseCode' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "gelar_depan" => $row->gelar_depan,
                "nama" => $row->nama,
                "gelar_belakang" => $row->gelar_belakang,
                "id" => $row->id,
                "nip" => $row->nip,
                "jabatan" => $row->jabatan,
                "nama_unit_kerja" => $row->nama_unit_kerja,
                "tpp_diterima" => $row->tpp_diterima,
                "tahun" => $row->tahun,
                "bulan" => $row->bulan,
                "fid_status" => $row->fid_status,
                "statuspeg" => $row->statuspeg,
                "catatan" => $row->catatan,
                "basic_bk" => $row->basic_bk,
                "basic_pk" => $row->basic_pk,
                "basic_kk" => $row->basic_kk,
                "basic_tb" => $row->basic_tb,
                "basic_kp" => $row->basic_kp,
                "jml_pph" => $row->jml_pph,
                "iwp_gaji" => $row->iwp_gaji,
                "jml_iwp" => $row->jml_iwp,
                "jml_bpjs" => $row->jml_bpjs,
                "is_peremajaan" => $row->is_peremajaan,
                "simgaji_id_skpd" => $row->simgaji_id_skpd,
                "simgaji_id_satker" => $row->simgaji_id_satker,
                "is_sync_simgaji" => $row->is_sync_simgaji,
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
            'kind' => 'Data TPP',
            'status' => true,
            'message' => 'TPP '.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function pppk_get($nipppk=null) {
        if($this->level === 'ADMIN') {
            $params = [
                'nipppk' => $nipppk ? $nipppk : $this->nip,
                'periode' => $this->query('periodeId'),
                'pengantar' => $this->query('pengantarId'),
                'status' => $this->query('status') ? $this->query('status') : 'OPEN',
                'bulan' => $this->query('bulan'),
                'tahun' => $this->query('tahun'),
                'limit' => $this->query('limit'),
                'offset' => $this->query('offset'),
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : 'desc',
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        } else {
            $params = [
                'nipppk' => $this->nip,
                'periode' => $this->query('periodeId'),
                'pengantar' => $this->query('pengantarId'),
                'status' => $this->query('status') ? $this->query('status') : 'OPEN',
                'bulan' => $this->query('bulan'),
                'tahun' => $this->query('tahun'),
                'limit' => $this->query('limit'),
                'offset' => $this->query('offset'),
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : 'desc',
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        }
        $data = $this->tpp->getTppByNipppk($params);

        // Jika Params / Body NIP tidak ada
        if(empty($params['nipppk'])) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nipppk` Wajib Ditambahkan',
                'responseCode' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data TPP Tidak Ditemukan',
                'responseCode' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "gelar_depan" => $row->gelar_depan,
                "nama" => $row->nama,
                "gelar_belakang" => $row->gelar_blk,
                "id" => $row->id,
                "nipppk" => $row->nip,
                "jabatan" => $row->jabatan,
                "nama_unit_kerja" => $row->nama_unit_kerja,
                "tpp_diterima" => $row->tpp_diterima,
                "tahun" => $row->tahun,
                "bulan" => $row->bulan,
                "fid_status" => $row->fid_status,
                "statuspeg" => $row->statuspeg,
                "catatan" => $row->catatan,
                "basic_bk" => $row->basic_bk,
                "basic_pk" => $row->basic_pk,
                "basic_kk" => $row->basic_kk,
                "basic_tb" => $row->basic_tb,
                "basic_kp" => $row->basic_kp,
                "jml_pph" => $row->jml_pph,
                "iwp_gaji" => $row->iwp_gaji,
                "jml_iwp" => $row->jml_iwp,
                "jml_bpjs" => $row->jml_bpjs,
                "is_peremajaan" => $row->is_peremajaan,
                "simgaji_id_skpd" => $row->simgaji_id_skpd,
                "simgaji_id_satker" => $row->simgaji_id_satker,
                "is_sync_simgaji" => $row->is_sync_simgaji,
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
            'kind' => 'Data TPP',
            'status' => true,
            'message' => 'TPP '.$params['nipppk'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function inexis_patch() {
        $id = (int) $this->patch('id');
        $is_sync = $this->patch('is_sync');

        // Jika Params / Body NIP tidak ada
        if(empty($id) || $is_sync === "") {
            $msg = [
                'status' => false,
                'message' => 'Request `id` || `is_sync` Wajib Ditambahkan',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        $whr = [
            'id' => $id
        ];

        $update = [
            'is_sync_simgaji' => $is_sync
        ];

        $db = $this->tpp->update('tppng', $update, $whr);
        if($db) {
            // Jika Berhasil
            $result = [
                'kind' => 'Data TPP',
                'status' => true,
                'message' => 'TPP Telah Sinkron'
            ];
            return $this->response($result, REST_Controller::HTTP_OK);
        }

        // Jika Gagal
        $result = [
            'kind' => 'Data TPP',
            'status' => false,
            'message' => 'TPP Gagal Sinkron'
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}