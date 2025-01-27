<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Riwayat extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api']);
        $this->load->helper('fungsipegawai');
    }

    public function index_get() {
        $nip = $this->query('nip');
        $query = $this->api->getRiwayatPangkatByNip($nip);

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
                'message' => 'Riwayat Pangkat Terakhir NIP. '.$nip.' Tidak Ditemukan',
                'http_code' => REST_Controller::HTTP_NOT_FOUND
            ];
            return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
        }

        // Ambil 1 Data berdasarkan NIP
        $r = $query->row();
        $data_riwayat = [
            'nip_lama' => $r->nip_lama,
            'nip' => $r->nip,
            'nip_convert' => polanip($r->nip),
            'nama' => $r->nama,
            'nama_lengkap' => namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang),
            'npwp' => $r->no_npwp,
            'whatsapp' => $r->whatsapp,
            'row' => [
                'id' => $r->id,
                'uraian' => $r->uraian,
                'gapok' => $r->gapok,
                'tmt' => $r->tmt,
                'id_pangkat_simgaji' => $r->id_simgaji,
                "id_satker_simgaji" => $r->simgaji_id_satker,
                "id_skpd_simgaji" => $r->simgaji_id_skpd,
                "id_jenis_pegawai_simgaji" => $r->kode_jenis,
                "id_status_pegawai_simgaji" => $r->kode_statuspeg,
                "id_eselon_simgaji" => $r->id_eselon_simgaji,
                "id_eselon" => $r->id_eselon,
                "id_golru" => $r->fid_golru,
                'nama_pangkat' => $r->nama_pangkat,
                'nama_golru' => $r->nama_golru,
                "nama_unit_kerja" => $r->nama_unit_kerja,
                "nama_eselon" => $r->nama_eselon,
                'nama_jabatan' => $r->jabatan_sekarang,
                "nama_jenis_pegawai_simgaji" => $r->nama_jenis,
                "nama_status_pegawai_simgaji" => $r->nama_statuspeg,
                'mkgol_thn' => $r->mkgol_thn,
                'mkgol_bln' => $r->mkgol_bln,
                'pejabat_sk' => $r->pejabat_sk,
                'no_sk' => $r->no_sk,
                'tgl_sk' => $r->tgl_sk,
                'berkas' => 'http://silka.balangankab.go.id/filekp/'.$r->berkas.'.pdf',
                "created_at" => $r->created_at,
                "created_by" => $r->created_by,
                "update_at" => $r->updated_at,
                "update_by" => $r->updated_by,
                "is_sync_simgaji" => $r->is_sync_simgaji,
                "is_peremajaan" => $r->is_peremajaan
            ]
        ];
        // rp.id,rp.uraian,rp.gapok,rp.tmt,rp.mkgol_thn,rp.mkgol_bln,rp.pejabat_sk,rp.no_sk,rp.tgl_sk,rp.berkas
        $data = [
            'status' => true,
            'message' => 'Riwayat Pangkat Terakhir NIP. '.$nip.' Ditemukan',
            'http_code' => REST_Controller::HTTP_OK,
            'data' => $data_riwayat,
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
            $db = $this->api->update('riwayat_pekerjaan', $update, $whr);
            if($db) {
                // Jika Berhasil
                $result = [
                    'kind' => 'Data Riwayat Pekerjaan',
                    'status' => true,
                    'message' => 'Riwayat Pekerjaan Telah Sinkron'
                ];
                return $this->response($result, REST_Controller::HTTP_OK);
            }
    
            // Jika Gagal
            $result = [
                'kind' => 'Data Riwayat Pekerjaan',
                'status' => false,
                'message' => 'Riwayat Pekerjaan Gagal Sinkron'
            ];
            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $db = $this->api->update('riwayat_pekerjaan_pppk', $update, $whr);
            if($db) {
                // Jika Berhasil
                $result = [
                    'kind' => 'Data Riwayat Pekerjaan',
                    'status' => true,
                    'message' => 'Riwayat Pekerjaan PPPK Telah Sinkron'
                ];
                return $this->response($result, REST_Controller::HTTP_OK);
            }
    
            // Jika Gagal
            $result = [
                'kind' => 'Data Riwayat Pekerjaan',
                'status' => false,
                'message' => 'Riwayat Pekerjaan PPPK Gagal Sinkron'
            ];
            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        }
        
    }
}