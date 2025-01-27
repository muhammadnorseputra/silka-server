<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/

class Pppk extends REST_Controller  {
    
    function __construct() {		
        parent::__construct();
        //load model services
        $this->load->model(['api/v2/Pegawai' => 'pegawai']);
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

    public function index_get($nip=null) {
        
        if($this->level === 'ADMIN') {
            $params = [
                'nipppk' => $nip !== null ? $nip : $this->nip, // required
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        } else {
            $params = [
                'nipppk' => $this->nip, // required
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        }

        $data = $this->pegawai->getPppk($params);

        // Jika Params / Body NIP tidak ada
        if(empty($params['nipppk'])) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nipppk` Wajib Ditambahkan',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // PNS Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data PPPK Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "nipppk" => $row->nipppk,
                "pppk_id" => $row->pppk_id,
                "nik" => $row->nik,
                "nama" => $row->nama,
                "gelar_depan" => $row->gelar_depan,
                "gelar_blk" => $row->gelar_blk,
                "tmp_lahir" => $row->tmp_lahir,
                "tgl_lahir" => $row->tgl_lahir,
                "jns_kelamin" => $row->jns_kelamin,
                "alamat" => $row->alamat,
                "no_handphone" => $row->no_handphone,
                "email" => $row->email,
                "no_npwp" => $row->no_npwp,
                "fid_agama" => $row->fid_agama,
                "fid_status_kawin" => $row->fid_status_kawin,
                "fid_status_ptkp" => $row->fid_status_ptkp,
                "fid_keldesa" => $row->fid_keldesa,
                "fid_tingkat_pendidikan" => $row->fid_tingkat_pendidikan,
                "fid_jurusan_pendidikan" => $row->fid_jurusan_pendidikan,
                "nama_sekolah" => $row->nama_sekolah,
                "tahun_lulus" => $row->tahun_lulus,
                "jenis_formasi" => $row->jenis_formasi,
                "tahun_formasi" => $row->tahun_formasi,
                "fid_unit_kerja" => $row->fid_unit_kerja,
                "fid_jabft" => $row->fid_jabft,
                "tmt_jabatan" => $row->tmt_jabatan,
                "tmt_spmt" => $row->tmt_spmt,
                "no_spmt" => $row->no_spmt,
                "pejabat_spmt" => $row->pejabat_spmt,
                "fid_golru_pppk" => $row->fid_golru_pppk,
                "tmt_golru_pppk" => $row->tmt_golru_pppk,
                "gaji_pokok" => $row->gaji_pokok,
                "maker_tahun" => $row->maker_tahun,
                "maker_bulan" => $row->maker_bulan,
                "tmt_pppk_awal" => $row->tmt_pppk_awal,
                "masakontrak_thn" => $row->masakontrak_thn,
                "masakontrak_bln" => $row->masakontrak_bln,
                "tmt_pppk_akhir" => $row->tmt_pppk_akhir,
                "nomor_sk" => $row->nomor_sk,
                "tgl_sk" => $row->tgl_sk,
                "pejabat_sk" => $row->pejabat_sk,
                "tpp" => $row->tpp,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
                "photo" => $row->photo,
                "status" => $row->status,
                "ket_status" => $row->ket_status,
                "nama_golru" => $row->nama_golru,
                "nama_pangkat" => $row->nama_pangkat,
                "unker_id" => $row->unker_id,
                "nama_unit_kerja" => $row->nama_unit_kerja,
                "simgaji_id_skpd" => $row->simgaji_id_skpd,
                "simgaji_id_satker" => $row->simgaji_id_satker,
                "nama_jabatan" => $row->nama_jabatan,
                "nama_agama" => $row->nama_agama,
                "nama_tingkat_pendidikan" => $row->nama_tingkat_pendidikan,
                "kode_statuspeg" => $row->kode_statuspeg,
                "status_data" => $row->status_data,
                "status_data_add" => $row->status_data_add,
                "status_data_add_by" => $row->status_data_add_by,
                "status_data_update" => $row->status_data_update,
                "status_data_update_by" => $row->status_data_update_by,
                "jumlah_sutri" => $row->jumlah_sutri,
                "jumlah_anak" => $row->jumlah_anak,

            ];
        }

        // Filter data berdasarkan query string atau tampilkan semua jika tidak ada parameter
        foreach ($response as $row) {
            if (empty($params['field'])) {
                // Jika tidak ada parameter, tampilkan semua field
                $filteredResponse = $row;
            } else {
                // Jika ada parameter, filter data
                $filteredRow = [];
                foreach ($params['field'] as $field) {
                    if (isset($row[$field])) {
                        $filteredRow[$field] = $row[$field];
                    }
                }
                $filteredResponse = $filteredRow;
            } 
        }

        // Jika Berhasil
        $result = [
            'kind' => 'Profile',
            'status' => true,
            'message' => 'Profile Ditemukan',
            'count' => $data->num_rows(),
            'data' => $filteredResponse
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

}