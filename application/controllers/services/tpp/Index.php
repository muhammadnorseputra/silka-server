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

    public function periode_get() {
        $db = $this->db->select('*')->from('tppng_periode')->order_by('id','desc')->limit('1')->get()->row();
        return $this->response($db, REST_Controller::HTTP_OK);
    }
    public function jumlahasn_get() {
	$unorid = $this->query('id');
    $skpd_satker = $this->db->select('simgaji_id_skpd, simgaji_id_satker')->from('ref_unit_kerjav2')->where('id_unit_kerja', $unorid)->get()->row();
	$pns = $this->db->select('*')->from('pegawai')->where('fid_unit_kerja', $unorid)->get()->num_rows();
	$pppk = $this->db->select('*')->from('pppk')->where('fid_unit_kerja', $unorid)->get()->num_rows();
	
	if(($pns == 0) OR ($pppk == 0)) {
		$data = [
			'status' => false,
			'message' => 'Data tidak temukan',
			'data' => []
		];
		return $this->response($data, REST_Controller::HTTP_NOT_FOUND);
	}
	
	$total = $pns + $pppk;
	$data = [
	 'status' => true,
	 'message' => 'Data Ditemukan',
	 'data' => [
		'unorid' => $unorid,
        'id_skpd_simgaji' => $skpd_satker->simgaji_id_skpd,
        'id_satker_simgaji' => $skpd_satker->simgaji_id_satker,
		'pns' => $pns,
		'pppk' => $pppk,
		'total' => $total,
	 ]
	];
	return $this->response($data, REST_Controller::HTTP_OK);

}


    public function getTppByNip_get() {
        $nip = $this->get('nip');
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
        
        // Jika Berhasil
        $result = [
            'kind' => 'Data TPP',
            'status' => true,
            'message' => 'TPP '.$nip.' Ditemukan',
            'data' => $data->row()
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function pppk_get() {
        $nip = $this->get('nipppk');
        $data = $this->api->getTppByNipppk($nip);

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nippppk` Wajib Ditambahkan',
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
        
        // Jika Berhasil
        $result = [
            'kind' => 'Data TPP',
            'status' => true,
            'message' => 'TPP '.$nip.' Ditemukan',
            'data' => $data->row()
        ];
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function index_post() {
        $id = $this->post('id');
        $is_sync = $this->post('is_sync');
        // Jika Params / Body NIP tidak ada
        if(empty($id) || empty($is_sync)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `id` || `is_sync` Wajib Ditambahkan',
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

        $db = $this->api->update('tppng', $update, $whr);
        if($db) {
            // Jika Berhasil
            $result = [
                'kind' => 'Data TPP',
                'status' => true,
                'message' => 'TPP Telah Sinkron'
            ];
            $this->response($result, REST_Controller::HTTP_OK);
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
