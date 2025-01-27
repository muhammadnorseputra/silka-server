<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Upload extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api', 'mpensiun']);
        $this->load->helper('fungsipegawai');
    }

    public function skpensiun_post()
    {
        $nip = $this->post('nip');
        $file = $this->post('file');

        $config['upload_path'] = './fileskpensiun/';
        $config['allowed_types'] = 'pdf|PDF';
        $config['max_size'] = '2048';
        $config['file_ext_tolower'] = true;
        $config['overwrite'] = true;
        $config['file_name'] = $nip;

        $this->load->library('upload', $config);
        if ( !$this->upload->do_upload('file'))
        {
                $error = array('error' => $this->upload->display_errors());
                $this->response([
                    'status' => FALSE,
                    'message' => 'Uplaod Gagal !',
                    'data' => $error
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            $data = $this->upload->data();
            $this->response([
                'status' => TRUE,
                'message' => 'Upload SK Pensiun Berhasil !',
                'data' => $data
                
            ], REST_Controller::HTTP_OK);
        }

    }
}