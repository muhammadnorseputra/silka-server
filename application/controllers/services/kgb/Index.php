<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Index extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api']);
        $this->load->helper('fungsipegawai');
        
        
    }

    public function index_get() {
        $nip = $this->query('nip');
        $query = $this->api->getKgb($nip);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter NIP Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // KGB Tidak Ditemukan Pada Database
        if($query->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Usulan Kenaikan Gaji Berkala NIP. '.$nip.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Ambil 1 Data berdasarkan NIP
        $r = $query->row();
            $data_usulan = [
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
        $data = [
            'status' => true,
            'message' => 'Usulan Kenaikan Gaji Berkala NIP. '.$nip.' Ditemukan',
            'http_code' => REST_Controller::HTTP_OK,
            'data' => $data_usulan,
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
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        // KGB Tidak Ditemukan Pada Database
        if($query->num_rows() == 0) {
            $msg = [
                'status' => false,
                'message' => 'Usulan Kenaikan Gaji Berkala NIP. '.$nip.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
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

    public function index_post() {
        $id = $this->post('id');
        $is_sync = $this->post('is_sync');
        $jenis_pegawai = $this->post('type');
        // Jika Params / Body NIP tidak ada
        if(empty($id) || empty($is_sync) || empty($jenis_pegawai) ) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `id` | `is_sync` | `type` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        $whr = [
            'id' => $id
        ];

        $update = [
            'is_sync_simgaji' => $is_sync
        ];
        if($jenis_pegawai === 'PNS') {
            $db = $this->api->update('riwayat_kgb', $update, $whr);
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
            $db = $this->api->update('riwayat_kgb_pppk', $update, $whr);
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