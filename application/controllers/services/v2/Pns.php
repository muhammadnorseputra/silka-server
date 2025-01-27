<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/

class Pns extends REST_Controller  {
    
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
                'nip' => $nip !== null ? $nip : $this->nip, // required
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        } else {
            $params = [
                'nip' => $this->nip, // required
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];  
        }

        $data = $this->pegawai->getPns($params);

        // Jika Params / Body NIP tidak ada
        if(empty($params['nip'])) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // PNS Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data PNS Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $response = [];
        foreach($data->result() as $row) {
            $response[] = [
                "pns_id" => $row->pns_id,
                "nip_lama" => $row->nip_lama,
                "nip" => $row->nip,
                "nama" => $row->nama,
                "gelar_depan" => $row->gelar_depan,
                "gelar_belakang" => $row->gelar_belakang,
                "tmp_lahir" => $row->tmp_lahir,
                "tgl_lahir" => $row->tgl_lahir,
                "alamat" => $row->alamat,
                "fid_alamat_kelurahan" => $row->fid_alamat_kelurahan,
                "alamat_ktp" => $row->alamat_ktp,
                "fid_kelurahan_ktp" => $row->fid_kelurahan_ktp,
                "telepon" => $row->telepon,
                "fid_agama" => $row->fid_agama,
                "jenis_kelamin" => $row->jenis_kelamin,
                "fid_status_kawin" => $row->fid_status_kawin,
                "fid_status_ptkp" => $row->fid_status_ptkp,
                "fid_tingkat_pendidikan" => $row->fid_tingkat_pendidikan,
                "fid_jurusan_pendidikan" => $row->fid_jurusan_pendidikan,
                "tahun_lulus" => $row->tahun_lulus,
                "fid_status_pegawai" => $row->fid_status_pegawai,
                "fid_golru_awal" => $row->fid_golru_awal,
                "tmt_golru_awal" => $row->tmt_golru_awal,
                "fid_golru_skr" => $row->fid_golru_skr,
                "tmt_golru_skr" => $row->tmt_golru_skr,
                "no_sk_cpns" => $row->no_sk_cpns,
                "tgl_sk_cpns" => $row->tgl_sk_cpns,
                "tmt_cpns" => $row->tmt_cpns,
                "no_sk_pns" => $row->no_sk_pns,
                "tgl_sk_pns" => $row->tgl_sk_pns,
                "tmt_pns" => $row->tmt_pns,
                "fid_jenis_pegawai" => $row->fid_jenis_pegawai,
                "makertotal_tahun" => $row->makertotal_tahun,
                "makertotal_bulan" => $row->makertotal_bulan,
                "fid_unit_kerja1" => $row->fid_unit_kerja1,
                "fid_jabatan1" => $row->fid_jabatan1,
                "fid_unit_kerja" => $row->fid_unit_kerja,
                "fid_jabatan" => $row->fid_jabatan,
                "fid_jnsjab" => $row->fid_jnsjab,
                "fid_jabfu" => $row->fid_jabfu,
                "fid_jabft" => $row->fid_jabft,
                "plt" => $row->plt,
                "fid_eselon" => $row->fid_eselon,
                "tmt_jabatan" => $row->tmt_jabatan,
                "no_karpeg" => $row->no_karpeg,
                "no_karis_karsu" => $row->no_karis_karsu,
                "no_askes" => $row->no_askes,
                "no_taspen" => $row->no_taspen,
                "no_ktp" => $row->no_ktp,
                "no_npwp" => $row->no_npwp,
                "email" => $row->email,
                "whatsapp" => $row->whatsapp,
                "instagram" => $row->instagram,
                "twitter" => $row->twitter,
                "facebook" => $row->facebook,
                "youtube" => $row->youtube,
                "google" => $row->google,
                "wajib_lhkpn" => $row->wajib_lhkpn,
                "no_nhk" => $row->no_nhk,
                "photo" => $row->photo,
                "note" => $row->note,
                "berkas" => $row->berkas,
                "no_berkas" => $row->no_berkas,
                "koderegpupns" => $row->koderegpupns,
                "tpp" => $row->tpp,
                "fid_jabstrukatasan" => $row->fid_jabstrukatasan,
                "created_at" => $row->created_at,
                "created_by" => $row->created_by,
                "updated_at" => $row->updated_at,
                "updated_by" => $row->updated_by,
                "nama_golru" => $row->nama_golru,
                "nama_pangkat" => $row->nama_pangkat,
                "unker_id" => $row->unker_id,
                "nama_unit_kerja" => $row->nama_unit_kerja,
                "simgaji_id_skpd" => $row->simgaji_id_skpd,
                "simgaji_id_satker" => $row->simgaji_id_satker,
                "nama_jabatan" => $row->nama_jabatan,
                "kode_jabatan" => $row->kode_jabatan,
                "kode_pangkat" => $row->kode_pangkat,
                "kode_eselon" => $row->kode_eselon,
                "induk_bank" => $row->induk_bank,
                "norek" => $row->norek,
                "kode_jenkel" => $row->kode_jenkel,
                "status_data" => $row->status_data,
                "nama_agama" => $row->nama_agama,
                "simgaji_id_agama" => $row->simgaji_id_agama,
                "update_at" => $row->update_at,
                "tmt_skmt" => $row->tmt_skmt,
                "kode_status_pegawai" => $row->kode_status_pegawai,
                "nama_statuspeg" => $row->nama_statuspeg,
                "kode_jenis_pegawai" => $row->kode_jenis_pegawai,
                "nama_jenis" => $row->nama_jenis,
                "kode_statkawin_simgaji" => $row->kode_statkawin_simgaji,
                "gapok" => $row->gapok,
                "jumlah_sutri" => $row->jumlah_sutri,
                "jumlah_anak" => $row->jumlah_anak,
                "tmt_capeg" => $row->tmt_capeg,
                "nama_tingkat_pendidikan" => $row->nama_tingkat_pendidikan,
                "tgl_spmt" => $row->tgl_spmt,
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