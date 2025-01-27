<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class Basic extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['mlogin' => 'login', 'mpegawai' => 'pegawai', 'Mapi' => 'api']);
        $this->load->helper(['fungsipegawai','fungsitanggal']);
        $this->config->set_item('rest_auth', FALSE);
    }

    public function index_post()
    {
        $type     = $this->post('type');
        $username = $this->post('username');
        $password = $this->post('password');

        if($type === 'PERSONAL') {
            $nip = $this->login->getnipuser($username);
            $nama = $this->pegawai->getnama($username);
            $ceklogin_pns = $this->login->ceklogin_pns($username, $password);
            if($ceklogin_pns->num_rows() == 1)
            {
                // Jika password sama dengan username
                if($username == $password) {
                    $msg = [
                        'status' => false,
                        'message' => 'Password tidak boleh sama dengan NIP',
                        'http_code' => REST_Controller::HTTP_UNAUTHORIZED
                    ];
                    return $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED);
                }
                $pegawai = $this->api->services_pegawai($username)->row();
                foreach($ceklogin_pns->result() as $data)
                {

                    // Cek tmt bup pns
                    if ($pegawai->fid_jnsjab == 1) { $idjab = $pegawai->fid_jabatan;
                    }else if ($pegawai->fid_jnsjab == 2) { $idjab = $pegawai->fid_jabfu;
                    }else if ($pegawai->fid_jnsjab == 3) { $idjab = $pegawai->fid_jabft;
                    }

                    $tmt_bup = $this->pegawai->gettmtbup($idjab, $pegawai->tgl_lahir, $pegawai->fid_jnsjab);

                    // Send data api
                    $sess_data = [
                        'nip' => $username,
                        'user_nama' => $username,
                        'nama_lengkap' => $nama,
                        'level' => "PNS",
                        'picture' => base_url('photo/'.$username.'.jpg'),
                        'tmtbup' => $tmt_bup,
                        'pegawai' => [
                            'nama_pangkat' => $pegawai->nama_pangkat,
                            'nama_jabatan' => $pegawai->nama_jabatan,
                            'tgl_lahir' => $pegawai->tgl_lahir,
                            'jenis_kelamin' => $pegawai->jenis_kelamin,
                            'unker' => $pegawai->nama_unit_kerja,
                            'unker_id' => $pegawai->unker_id
                        ]
                    ];

                    // result
                    $msg = [
                        'status' => true,
                        'message' => 'Login Personal berhasil !',
                        'http_code' => REST_Controller::HTTP_OK,
                        'data' => $sess_data
                    ];
                    $this->response($msg, REST_Controller::HTTP_OK);

                } // end foreach
            } else {
                $msg = [
                    'status' => false,
                    'message' => 'PNS tidak terdaftar atau akun Non Aktif',
                    'http_code' => REST_Controller::HTTP_UNAUTHORIZED
                ];
                $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED);
            }
            return false;
        }

        if($type === 'UMPEG') 
        {
            $nip = $this->login->getnipuser($username);
            $nama = $this->pegawai->getnama($nip);
            //model login telah diload pada file config/autoload.php
            $cek = $this->login->cek($nip, $username, $password);
            if($cek->num_rows() == 1)
            {
                $pegawai = $this->api->services_pegawai($nip)->row();
                foreach($cek->result() as $data)
                {

                // Cek tmt bup pns
                if ($pegawai->fid_jnsjab == 1) { $idjab = $pegawai->fid_jabatan;
                }else if ($pegawai->fid_jnsjab == 2) { $idjab = $pegawai->fid_jabfu;
                }else if ($pegawai->fid_jnsjab == 3) { $idjab = $pegawai->fid_jabft;
                }

                $tmt_bup = $this->pegawai->gettmtbup($idjab, $pegawai->tgl_lahir, $pegawai->fid_jnsjab);

                $sess_data = [
                    'nip' => $data->nip,
                    'user_nama' => $data->username,
                    'level' => $data->level,
                    'nama_lengkap' => $nama,
                    'picture' => base_url('photo/'.$data->nip.'.jpg'),
                    'tmtbup' => $tmt_bup,
                    'pegawai' => [
                        'nama_pangkat' => $pegawai->nama_pangkat,
                        'nama_jabatan' => $pegawai->nama_jabatan,
                        'tgl_lahir' => $pegawai->tgl_lahir,
                        'jenis_kelamin' => $pegawai->jenis_kelamin,
                        'unker' => $pegawai->nama_unit_kerja,
                        'unker_id' => $pegawai->unker_id
                    ]
                ];
                // result
                $msg = [
                    'status' => true,
                    'message' => 'Login Pengelola Kepegawaian berhasil !',
                    'http_code' => REST_Controller::HTTP_OK,
                    'data' => $sess_data
                ];
                $this->response($msg, REST_Controller::HTTP_OK);
                }
            }
            else
            {
                $msg = [
                    'status' => false,
                    'message' => 'Username & Password Salah',
                    'http_code' => REST_Controller::HTTP_UNAUTHORIZED
                ];
                $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }
}