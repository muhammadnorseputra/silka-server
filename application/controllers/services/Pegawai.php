<?php 
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

class Pegawai extends REST_Controller  {
    
    function __construct() {
		
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api']);
        $this->load->helper('fungsipegawai');
        $this->methods['index_post']['limit'] = 50;
    }

    function configToken(){
        $cnf['exp'] = 3600; //milisecond
        $cnf['secretkey'] = 'bkpsdm@2022';
        return $cnf;        
    }

    function authtoken(){
        $secret_key = $this->configToken()['secretkey']; 
        $token = null; 
        $authHeader = isset($this->input->request_headers()['Authorization']) ? $this->input->request_headers()['Authorization'] : 'AUTH BEARER_TOKEN_REQUIRED_FIELDS';  
        $arr = explode(" ", $authHeader); 
        $token = !empty($arr[1]) ? $arr[1] : 'TOKEN NULL';         
        if ($token){
            try{
                $decoded = JWT::decode($token, $this->configToken()['secretkey'], array('HS256'));          
                if ($decoded){
                    return [
                        'status' => true,
                        'token' => $token
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'token' => $token
                ];
            }
        }       
    }

    public function getToken_post(){
        $header_req = 'apiKey';
        $apikey =  $this->input->request_headers()[$header_req];
        $username = $this->post('username');               
        $password = $this->post('password');  
        
        if(empty($username) && empty($password)) {
            $msg = array('status' => false, 'message'=>'Username & Password Required');
            return $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED);
            die();  
        }

        $account = $this->db->get_where('services_account', ['username' => $username, 'password' => md5($password)]);
        if($account->num_rows() === 0) {
            $msg = array('status' => false, 'message'=>'Username & Password Not Found');
            return $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED); 
            die(); 
        }

        $exp = time() + 3600;
        $token = array(
            "iss" => 'apprestservice',
            "aud" => 'UserServicesApi',
            "iat" => time(),
            "nbf" => time() + 10,
            "exp" => $exp,
            "data" => array(
                "username" => $username,
                "password" => md5($password)
            )
        );       
    
        $jwt = JWT::encode($token, $this->configToken()['secretkey'], 'HS256');
        $output = [
                'status' => 200,
                'message' => 'Token Is Generated',
                "token" => $jwt,                
                "expireAt" => $token['exp']
            ];      
        $data = array('status' => true, 'message'=>'Access Token Generated', 'data'=>array('token'=>$jwt, 'exp'=>$exp));
        $this->response($data, REST_Controller::HTTP_OK);       
    }

    function cekfields($val) {
        return $val ? $val : NULL;
    }

    public function index_post()
    {
        $nip = $this->post('nip');
        $pegawai = $this->api->services_pegawai($nip);
        
        // Cek Token JWT
        if ($this->authtoken()['status'] === false){
            $msg = [
                'status'=> false, 
                'message' => 'Token Invalid',
                'token' => $this->authtoken()['token'] 
            ];
            return $this->response($msg, REST_Controller::HTTP_UNAUTHORIZED);
            die();
        }

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