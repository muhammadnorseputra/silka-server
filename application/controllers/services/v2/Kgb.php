<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Kgb extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['api/v2/KgbModel' => 'kgb']);
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

    public function pengantar_get($id=null) {
        if($this->level === 'ADMIN') {
            $params = [
                'id' => $id,
                'nomor' => $this->query('nomor')
            ];
        } 

        $query = $this->kgb->getPengantar($params);

        // Jika Params / Body NIP tidak ada
        if(empty($params['nomor']) && empty($params['id'])) {
            $msg = [
                'status' => false,
                'message' => 'Silahkan masukan nomor pengantar dengan parameter `nomor` atau berdasarkan segment `id`',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // Pengantar KGB Tidak Ditemukan Pada Database
        if($query->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Surat Pengantar Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        $data = [
            'kind' => "Surat Pengantar KGB",
            'status' => true,
            'message' => 'Surat Pengantar Ditemukan',
            'data' => $query->result(),
        ];
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function pengantar_patch($id) {

    }

    public function inexis_get($nip=null) {
        if($this->level === 'ADMIN') {
            $params = [
                'nip' => $nip ? $nip : $this->nip,
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        } else {
            $params = [
                'nip' => $this->nip,
                'field' => $this->query('field') ? explode(',', $this->query('field')) : []
            ];
        }
        $query = $this->kgb->getKgb($params);

        // Jika Params / Body NIP tidak ada
        if(empty($params['nip'])) {
            $msg = [
                'status' => false,
                'message' => 'Parameter NIP Wajib Ditambahkan',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // KGB Tidak Ditemukan Pada Database
        if($query->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Usulan Kenaikan Gaji Berkala NIP. '.$params['nip'].' Tidak Ditemukan'
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Ambil 1 Data berdasarkan NIP
        $response = [];
        foreach($query->result() as $r) {
            $response[] = [
                'nip_lama' => $r->nip_lama,
                'nip' => $r->nip,
                'nip_convert' => polanip($r->nip),
                'nama' => $r->nama,
                'nama_lengkap' => namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang),
                'jabatan' => $r->jabatan_sekarang,
                'id' => $r->id,
                'npwp' => $r->no_npwp,
                'whatsapp' => $r->whatsapp,
                'gapok_baru' => $r->gapok,
                "mk_thn" => $r->mk_thn,
                "mk_bln" => $r->mk_bln,
                "tmt" => $r->tmt,
                "tmt_berikutnya" => $r->tmt_gaji_berikutnya,
                "pejabat_sk" => $r->pejabat_sk,
                "no_sk" => $r->no_sk,
                "tgl_sk" => $r->tgl_sk,
                "tgl_selesai_proses" => $r->created_at,
                "nama_unit_kerja" => $r->nama_unit_kerja,
                "id_jenis_pegawai_simgaji" => $r->kode_jenis,
                "jenis_pegawai_simgaji" => $r->nama_jenis,
                "id_status_pegawai_simgaji" => $r->kode_statuspeg,
                "status_pegawai_simgaji" => $r->nama_statuspeg,
                "id_eselon" => $r->id_eselon,
                "id_eselon_simgaji" => $r->id_eselon_simgaji,
                "nama_eselon" => $r->nama_eselon,
                "pangkat_id_simgaji" => $r->id_simgaji,
                "golru_id" => $r->fid_golru,
                "golru_nama" => $r->nama_golru,
                "pangkat_nama" => $r->nama_pangkat,
                "kode_satker" => $r->simgaji_id_satker,
                "kode_skpd" => $r->simgaji_id_skpd,
                "berkas" => 'http://silka.balangankab.go.id/filekgb/'.$r->berkas.'.pdf',
                "created_at" => $r->created_at,
                "created_by" => $r->created_by,
                "is_peremajaan" => $r->is_peremajaan
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

        $data = [
            'kind' => "Integrasi#INEXIS",
            'status' => true,
            'message' => 'Usulan Kenaikan Gaji Berkala Terakhir NIP. '.$params['nip'].' Ditemukan',
            'data' => $filteredResponse,
        ];
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function pppk_get() {
        $nip = $this->query('nipppk');
        $query = $this->api->getKgbP3K($nip);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter NIPPPK Wajib Ditambahkan',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // KGB Tidak Ditemukan Pada Database
        if($query->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Usulan Kenaikan Gaji Berkala NIP. '.$nip.' Tidak Ditemukan',
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Ambil 1 Data berdasarkan NIP
        $r = $query->row();
        $data_usulan = [
            'nipppk' => $r->nipppk,
            'nama' => $r->nama,
            'nama_lengkap' => namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang),
            'jabatan' => $r->nama_jabft,
            'id' => $r->id,
            'npwp' => $r->no_npwp,
            'no_handphone' => $r->no_handphone,
            'gapok_baru' => $r->gapok,
            "mk_thn" => $r->mk_thn,
            "mk_bln" => $r->mk_bln,
            "tmt" => $r->tmt,
            "pejabat_sk" => $r->pejabat_sk,
            "no_sk" => $r->no_sk,
            "tgl_sk" => $r->tgl_sk,
            "tgl_selesai_proses" => $r->created_at,
            "kode_satker" => $r->simgaji_id_satker,
            "kode_skpd" => $r->simgaji_id_skpd,
            "nama_unit_kerja" => $r->nama_unit_kerja,
            "id_jenis_pegawai_simgaji" => $r->kode_jenis,
            "jenis_pegawai_simgaji" => $r->nama_jenis,
            // "pangkat_id" => $r->id_simgaji,
            // "golru_id" => $r->fid_golru,
            // "golru_nama" => $r->nama_golru,
            // "pangkat_nama" => $r->nama_pangkat,
            // "berkas" => 'http://silka.balangankab.go.id/filekgb/'.$r->berkas.'.pdf',
            // "created_at" => $r->created_at,
            // "created_by" => $r->created_by
        ];
        $data = [
            'status' => true,
            'message' => 'Usulan Kenaikan Gaji Berkala NIP. '.$nip.' Ditemukan',
            'http_code' => REST_Controller::HTTP_OK,
            'data' => $data_usulan,
        ];
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function inexis_patch() {
        $id = (int) $this->patch('id');
        $is_sync = $this->patch('is_sync');
        $jenis_pegawai = $this->patch('type');

        // Jika body kosong
        if(empty($id) || $is_sync === ""  || empty($jenis_pegawai) ) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `id` | `is_sync` | `type` Wajib Ditambahkan',
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        $whr = [
            'id' =>  $id
        ];

        $update = [
            'is_sync_simgaji' => $is_sync
        ];
        if($jenis_pegawai === 'PNS') {
            $db = $this->kgb->update('riwayat_kgb', $update, $whr);
            if($db) {
                // Jika Berhasil
                $result = [
                    'kind' => 'Data Kenaikan Gaji Berkala',
                    'status' => true,
                    'message' => 'Kenaikan Gaji Berkala Telah Sinkron'
                ];
                return $this->response($result, REST_Controller::HTTP_OK);
            }
    
            // Jika Gagal
            $result = [
                'kind' => 'Data Kenaikan Gaji Berkala',
                'status' => false,
                'message' => 'Kenaikan Gaji Berkala Gagal Sinkron'
            ];
            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $db = $this->kgb->update('riwayat_kgb_pppk', $update, $whr);
            if($db) {
                // Jika Berhasil
                $result = [
                    'kind' => 'Data Kenaikan Gaji Berkala',
                    'status' => true,
                    'message' => 'Kenaikan Gaji Berkala PPPK Telah Sinkron'
                ];
                return $this->response($result, REST_Controller::HTTP_OK);
            }
    
            // Jika Gagal
            $result = [
                'kind' => 'Data Kenaikan Gaji Berkala',
                'status' => false,
                'message' => 'Kenaikan Gaji Berkala PPPK Gagal Sinkron'
            ];
            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        }
        
    }
}