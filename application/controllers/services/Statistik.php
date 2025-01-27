<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Statistik extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api', 'mpensiun']);
        $this->load->helper('fungsipegawai');
    }

    public function index_post()
    {
        $tahun = date('Y');
        
        // Jumlah berdasarkan proyeksi pensiun
        $total_proyeksi_pensiun = 0;
        if($tahun) {
            $proyeksi_pensiun = $this->mpensiun->proyeksi()->result_array();
            foreach($proyeksi_pensiun as $v):
                $thn_lahir = substr($v['tgl_lahir'],0,4);
                $bln_lahir = substr($v['tgl_lahir'],5,2);
                $thn_bup = $thn_lahir + $v['usia_pensiun'];

                if (($bln_lahir == 12) AND ($thn_bup == $tahun)) {$thn_bup++;}
                if (($bln_lahir == 12) AND ($thn_bup == $tahun-1)) {$thn_bup;}

                if (($thn_bup == $tahun) OR (($thn_bup == $tahun-1) AND ($bln_lahir == 12))) {
                    $total_proyeksi_pensiun += count($v['nip']);
                }
            endforeach;
        }
        
        // Jumlah berdasarkan rekapitulasi pensiun
        $sqlcari = $this->mpensiun->tampilrekappertahun($tahun)->result_array();
        $jmlpen = count($sqlcari);

        // Total proyeksi per tahun ini $tahun
        $total = ($total_proyeksi_pensiun + $jmlpen);

        $data = [
            'pns' => $this->api->jmlpns(),
            'nonpns' => $this->api->jmlnonpns(),
            'pensiun' => $this->api->jmlpensiun(date('Y')),
            'proyeksi_pensiun' => $total,
            'asn' => $this->api->jmlasn(),
        ];
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function listunor_get() {
        $db = $this->db->select('id_unit_kerja,nama_unit_kerja')->from('ref_unit_kerjav2')->where('aktif', 'Y')->get();
        $this->response($db->result(), REST_Controller::HTTP_OK);
    }
}