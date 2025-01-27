<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/

class PegawaiWithBasicAuth extends REST_Controller  {
    
    function __construct() {		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api']);
        $this->load->helper('fungsipegawai');
        $this->methods['index_post']['limit'] = 50;
        $this->methods['pnsintegrasi_post']['limit'] = 10;
    }

    function cekfields($val) {
        return $val ? $val : NULL;
    }

    public function index_post()
    {
        $nip = $this->post('nip');
        $pegawai = $this->api->services_pegawai($nip);
        
        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter NIP Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Pegawai Tidak Ditemukan Pada Database
        if($pegawai->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Pegawai NIP. '.$nip.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Ambil 1 Data berdasarkan NIP
        $row = $pegawai->row();
        $unker_nama = $this->api->services_unkerid($row->fid_unit_kerja)->row();
        $data = [
            'kind' => 'Data Pegawai Perorangan',
            'status' => true,
            'message' => $pegawai->num_rows().' Data Ditemukan',
            'data' => [
                'pegawai_id' => $this->cekfields($row->pns_id),
                'nip_lama' => $this->cekfields($row->nip_lama),
                'nip_baru' => $row->nip,
                'nama' => $row->nama,
                'gelar_depan' => $this->cekfields($row->gelar_depan),
                'gelar_belakang' => $this->cekfields($row->gelar_belakang),
                'npwp' => $row->no_npwp,
                'no_telp' => $row->whatsapp,
            
                'kepegawaian' => [
                    'kdeselon' => (int) $row->fid_eselon,
                    'pangkat_id' => (int) $row->fid_golru_skr,
                    'pangkat_nama' => $row->nama_pangkat, 
                    'masa_kerja_tahun' => (int) getMkCpns($nip)['tahun'],
                    'masa_kerja_bulan' => (int) getMkCpns($nip)['bulan'],
                    'satuan_kerja_id' => (int) $row->fid_unit_kerja,
                    'satuan_kerja_nama' => $unker_nama->nama_unit_kerja,
                    'kdjabatan' =>  (int) $row->kode_jabatan,
                    'nama_jabatan' => $row->nama_jabatan,
                ]
            ]
        ];
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function pnsintegrasi_post()
    {
        $nip = $this->post('nip');
        $pegawai = $this->api->services_pegawai($nip);
        
        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter NIP Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Pegawai Tidak Ditemukan Pada Database
        if($pegawai->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Pegawai NIP. '.$nip.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Ambil 1 Data berdasarkan NIP
        $row = $pegawai->row();
        $unker_nama = $this->api->services_unkerid($row->fid_unit_kerja)->row();
        $data = [
            'kind' => 'Data Pegawai Perorangan',
            'status' => true,
            'message' => $pegawai->num_rows().' Data Ditemukan',
            'data' => [
                'nip_lama' => $this->cekfields($row->nip_lama),
                'nip_baru' => $row->nip,
                'nama' => $row->nama,
                'gelar_depan' => $this->cekfields($row->gelar_depan),
                'gelar_belakang' => $this->cekfields($row->gelar_belakang),
                'npwp' => $row->no_npwp,
                'no_telp' => $row->whatsapp,
                'alamat' => $row->alamat,
                'kepegawaian' => [
                    'pangkat_nama' => $row->nama_pangkat, 
                    'satuan_kerja_nama' => $unker_nama->nama_unit_kerja,
                    'nama_jabatan' => $row->nama_jabatan,
                ]
            ]
        ];
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function getPegawaiByUnor_post() {
        $uid = $this->post('unor_id');
        $data = $this->api->services_pegawai_by_unker($uid);

        // Jika Params / Body unor_id tidak ada
        if(empty($uid)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `unor_id` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data Pegawai Dengan UNOR_ID '.$uid.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND,
                'data' => []
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $body = [];
        foreach($data->result() as $r) {
            $body[] = [
                'nip_lama' => $r->nip_lama,
                'nip_baru' => $r->nip,
                'nip_baru_convert' => polanip($r->nip),
                'nama' => $r->nama,
                'nama_lengkap' => namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang),
                'jabatan' => $r->nama_jabatan,
                'pangkat' => $r->nama_pangkat,
                'golru' => $r->nama_golru,
                'tpp_sync' => $r->tpp_sync,
                'kgb_sync' => $r->kgb_sync,
                'pangkat_sync' => $r->pangkat_sync,
                'status_data' => $r->status_data
            ];
        }
        // Jika Berhasil
        $result = [
            'kind' => 'Data Pegawai By Unor',
            'status' => true,
            'message' => count($body).' Data Pegawai Ditemukan',
            'data' => $body
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function getUnorByRole_post() {
        $nip = $this->post('nip');
        $role = $this->post('role');

        $data = $this->api->getUnorListByRole($nip,$role);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Jika Params / Body Role tidak ada
        if(empty($role)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `role` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data Unor Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Jika Berhasil
        $this->response($data->result(), REST_Controller::HTTP_OK);
    }

    public function getTppByNip_get() {
        $nip = $this->post('nip');
        $data = $this->api->getTppByNip($nip);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($data->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data TPP Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($data->result(), REST_Controller::HTTP_OK);
    }

    private function cekValue($value) {
        return $value === "" ? NULL : $value;
    }

    public function getSKPD_get() {
        $nip = $this->query('nip');
        $role = $this->query('role');
        $skpd = $this->api->getUnorListByRole($nip,$role);
        if($skpd->num_rows() > 0) {
            $msg = [
                'status' => true,
                'message' => 'Data SKPD Ditemukan',
                'http_code' => REST_Controller::HTTP_OK,
                'count' => $skpd->num_rows(),
                'data' => $skpd->result()
            ];
            return $this->response($msg, REST_Controller::HTTP_OK);
        }

        $msg = [
            'status' => false,
            'message' => 'Data SKPD Tidak Ditemukan',
            'http_code' => REST_Controller::HTTP_NOT_FOUND,
            'count' => $skpd->num_rows(),
            'data' => [],
        ];
        return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
    }

    public function searchPegawai_post() {
	    $nipnama = strtolower($this->post('nipnama'));
        $jenis = $this->post('jenis');
        $niplogin = $this->post('account_login');
        $profile = $this->api->services_pegawai_by_nip_nama($nipnama,$jenis,$niplogin);

        // jika params / body jenis tidak ada
        if(empty($jenis)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter "jenis" Pegawai Tidak Ada',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED,
                'jenis_pegawai' => $jenis,
                'data' => []
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Jika Params / Body NIP tidak ada
        if(empty($nipnama)) {
            $msg = [
                'status' => false,
                'message' => 'Silahkan Ketikan NIP atau NAMA',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED,
                'jenis_pegawai' => $jenis,
                'data' => []
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Pegawai Tidak Ditemukan Pada Database
        if($profile->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data Pegawai Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND,
                'count' => $profile->num_rows(),
                'jenis_pegawai' => $jenis,
                'data' => []
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        if(!empty($nipnama)) {
            $data = [
                'status' => true,
                'message' => "Ditemukan ({$profile->num_rows()}) Data Pegawai dengan Kata Kunci '".$nipnama."' pada Database $jenis.",
                'http_code' => REST_Controller::HTTP_OK,
                'count' => $profile->num_rows(),
                'jenis_pegawai' => $jenis,
                'data' => $profile->result()
            ];
        } 
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function getProfileByNip_get() {
        $nip = $this->get('nip');
        $profile = $this->api->services_pegawai_by_nip($nip);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($profile->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data Profile Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($profile->row(), REST_Controller::HTTP_OK);
    }

    public function getProfileByNipppk_get() {
        $nipppk = $this->get('nipppk');
        $profile = $this->api->services_pppk_by_nipppk($nipppk);

        // Jika Params / Body NIP tidak ada
        if(empty($nipppk)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nipppk` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Unor Tidak Ditemukan Pada Database
        if($profile->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Data Profile Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($profile->row(), REST_Controller::HTTP_OK);
    }


    public function updateStatusValidasiPegawai_post() {
        $nip = $this->post('nip');
        $status = $this->post('status');
        $update = $this->api->update('simgaji_pegawai', ['status_data' => $status], ['nip' => $nip]);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Jika Params / Body NIP tidak ada
        if(empty($status)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `status` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        if($update) {
            $msg = [
                'status' => true,
                'message' => 'Validasi Berhasil Diperbaharui',
                'http_code' => REST_Controller::HTTP_OK
            ];
            return $this->response($msg, REST_Controller::HTTP_OK);
        }

        $msg = [
            'status' => false,
            'message' => 'Validasi gagal diperbaharui atau data tidak ditemukan',
            'http_code' => REST_Controller::HTTP_NOT_FOUND
        ];
        return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
    }

    public function updateStatusValidasiPppk_post() {
        $nipppk = $this->post('nipppk');
        $status = $this->post('status');
        $update = $this->api->update('simgaji_pppk', ['status_data' => $status], ['nipppk' => $nipppk]);

        // Jika Params / Body NIP tidak ada
        if(empty($nipppk)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nipppk` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Jika Params / Body NIP tidak ada
        if(empty($status)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `status` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        if($update) {
            $msg = [
                'status' => true,
                'message' => 'Validasi Berhasil Diperbaharui',
                'http_code' => REST_Controller::HTTP_OK
            ];
            return $this->response($msg, REST_Controller::HTTP_OK);
        }

        $msg = [
            'status' => false,
            'message' => 'Validasi gagal diperbaharui atau data tidak ditemukan',
            'http_code' => REST_Controller::HTTP_NOT_FOUND
        ];
        return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
    }
}
