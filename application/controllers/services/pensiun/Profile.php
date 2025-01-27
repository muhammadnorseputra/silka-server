<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Profile extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api', 'mpensiun']);
        $this->load->helper(['fungsipegawai','storage']);
    }
    
    protected function cekfields($val) {
        return $val ? $val : false;
    }

    public function cekfile_post() {
        $nip = $this->post('nip');

        // Jika nip tidak di isi
        if(empty($nip)) {
            $msg = array('status' => false, 'message'=>'Params NIP tidak ditemukan !');
            return $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED);
            die();  
        }
        
        // cek file perso pada database
        $file_rekening = $this->api->cekfile($nip, 8);
        $file_ktp = $this->api->cekfile($nip, 1);
        $file_npwp = $this->api->cekfile($nip, 2);
        $file_suket_anak = $this->api->cekfile($nip, 9);

        // cek profile pada info personal
        $personal = $this->api->cekpersonal($nip);

        $data = [
            'status' => true,
            'message' => 'Prosess Cek Peremajaan Data ASN pada SILKa Online.',
            'data' => [
                'no_ktp' => $this->cekfields($personal->no_ktp),
                'no_npwp' => $this->cekfields($personal->no_npwp),
                'file_rekening' => $this->cekfields(@$file_rekening->row()->file),
                'file_ktp' => $this->cekfields(@$file_ktp->row()->file),
                'file_npwp' => $this->cekfields(@$file_npwp->row()->file),
                'file_suket_anak' => $this->cekfields(@$file_suket_anak->row()->file),
            ],
        ];

        return $this->response($data, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $nip = $this->post('nip');
        $role = $this->post('session');
        
        $profile = $this->mpensiun->proyeksiByNip($nip, $role)->row();
        $idjnsjab = @$profile->fid_jnsjab;

        if(@$profile->fid_jabatan != null) {
            $idjab = @$profile->fid_jabatan;
        } elseif(@$profile->fid_jabft != null) {
            $idjab = @$profile->fid_jabft;
        } elseif(@$profile->fid_jabfu != null) {
            $idjab = @$profile->fid_jabfu;
        }

        if(!empty($nip) && COUNT($profile) > 0) {
            @$profile->picture = base_url('photo/'.$nip.'.jpg'); 
            @$profile->nama_jabatan = $this->mpensiun->namajab($idjnsjab, $idjab);
            $data = [
                "status" => true,
                "message" => 'Data <strong>'.$nip.'</strong> Ditemukan pada <strong>'.$profile->nama_unit_kerja.'</strong>',
                "data" => $profile
            ];

            
            return $this->response($data, REST_Controller::HTTP_OK);
        }

        $error = [
            "status" => false,
            "message" => 'Data tidak ditemukan atau diluar kewenangan anda, silahkan periksa kembali NIP yang dimasukan.',
            "data" => null
        ];
        $this->response($error, REST_Controller::HTTP_NOT_FOUND);
    }
}