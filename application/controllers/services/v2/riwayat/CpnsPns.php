<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class CpnsPns extends REST_Controller  {
    
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
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        } else {
            $params = [
                'nip' => $this->nip, // required
                'orderBy' => $this->query('orderBy') ? $this->query('orderBy') : "desc", // default = desc
                'limit' => $this->query('limit'),  //default = 10
                'offset' => $this->query('offset'),
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        }

        $data = $this->rw->getCpnsPns($params);
        
        // Params Wajib
        if(empty($params['nip'])) {
            $msg = [
                'kind' => 'CPNS-PNS',
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ada',
                
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Tidak Ditemukan Pada Database
        if($data->num_rows() === 0) {
            $msg = [
                'kind' => 'CPNS-PNS',
                'status' => false,
                'message' => 'Data Tidak Ditemukan',
                
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                // "nip" => $row->nip,
                "fid_status_pegawai" => $row->fid_status_pegawai,
                "tmt_cpns" => $row->tmt_cpns,
                "tgl_sk_cpns" => $row->tgl_sk_cpns,
                "no_sk_cpns" => $row->no_sk_cpns,
                "fid_golru_cpns" => $row->fid_golru_cpns,
                "gapok_cpns" => $row->gapok_cpns,
                "jabatan_cpns" => $row->jabatan_cpns,
                "unker_cpns" => $row->unker_cpns,
                "mkthn_cpns" => $row->mkthn_cpns,
                "mkbln_cpns" => $row->mkbln_cpns,
                "pejabat_sk_cpns" => $row->pejabat_sk_cpns,
                "fid_jns_pengadaan" => $row->fid_jns_pengadaan,
                "tgl_spmt" => $row->tgl_spmt,
                "no_sk_spmt" => $row->no_sk_spmt,
                "tmt_pns" => $row->tmt_pns,
                "tgl_sk_pns" => $row->tgl_sk_pns,
                "no_sk_pns" => $row->no_sk_pns,
                "fid_golru_pns" => $row->fid_golru_pns,
                "gapok_pns" => $row->gapok_pns,
                "jabatan_pns" => $row->jabatan_pns,
                "unker_pns" => $row->unker_pns,
                "mkthn_pns" => $row->mkthn_pns,
                "mkbln_pns" => $row->mkbln_pns,
                "pejabat_sk_pns" => $row->pejabat_sk_pns,
                "tgl_pertek_c2th" => $row->tgl_pertek_c2th,
                "no_sk_pertek_c2th" => $row->no_sk_pertek_c2th,
                "no_karpeg" => $row->no_karpeg,
                "tgl_dokter" => $row->tgl_dokter,
                "no_surat_dokter" => $row->no_surat_dokter,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
                "berkas" => $row->berkas,
                "berkas_pns" => $row->berkas_pns,
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
            'kind' => 'CPNS-PNS',
            'status' => true,
            'message' => 'CPNS PNS'.$params['nip'].' Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}