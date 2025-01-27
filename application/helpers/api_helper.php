<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

if ( ! function_exists('PostApi'))
{
    function PostApi($url, $req=[]) {

        // set post fields
        $post = $req;
        // set headers
        $headers = [
            'apiKey:Pensiun6811',
            'Content-Type:application/x-www-form-urlencoded',
            'Accept:application/json'
        ];

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
