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
        $this->config->set_item('rest_auth', 'basic');
        $this->config->set_item('auth_source', '');
        $this->methods['index_post']['limit'] = 50;
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
}