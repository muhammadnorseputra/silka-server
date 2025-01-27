<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class AuthVerify {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('rest'); // Load your 'rest' config file if you have one
    }

    public function verifyToken() {
        $secret_key = $this->CI->config->item('secretkey'); // Adjust key name if needed
        $token = null;

        $authHeader = @$this->CI->input->request_headers()['Authorization'];
        if(empty($authHeader)) {
            return [
                'status' => false,
                'message' => 'ACCESS TOKEN REQUIRED !',
                'responseCode' => 411
            ];
        }
        

        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));
                if ($decoded) {
                    return [
                        'status' => true,
                        'message' => 'ACCESS TOKEN VALID',
                        'data' => $token
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'message' => 'ACCESS TOKEN EXPIRED !',
                    'responseCode' => 401
                ];
            }
        }
    }
}