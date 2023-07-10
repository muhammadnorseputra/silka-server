<?php if (!defined("BASEPATH")) exit("No direct script access allowed");
if ( ! function_exists('curlApi'))
{
    function curlApi($url, $req) {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json', 'Content-Type:multipart/form-data', 'Authorization:Bearer bkpp'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For HTTPS
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // For HTTPS
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json', 'Authorization:Bearer bkpp'));
        $output = curl_exec($ch); 
        curl_close($ch);
	//var_dump($output);      
        return $output;
    }
}
?>
