<?php
	function apiNewTokenAccess(){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,"https://wsrv-auth.bkn.go.id/oauth/token");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_POST, true);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($curl, CURLOPT_POSTFIELDS,"client_id=balangankabws&grant_type=client_credentials");
		curl_setopt($curl, CURLOPT_USERPWD, "balangankabws:xpZWRkZ2Ru");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','origin: http://localhost:20000'));

		// receive server response ...
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


		if(($jsondata = curl_exec($curl)) === false)
		{
			exit( 'Curl error: ' . curl_error($curl));
		}
		else
		{
			$obj = json_decode($jsondata, true);
			//var_dump($obj);
			if(isset($obj['access_token'])){
				$token_file = fopen("token-key.txt", "w+") or die("Unable to open file!");
				//$txt = "ini-nanti-diisi-token-key";
				fwrite($token_file, $obj['access_token']);
				fclose($token_file);
				
				// return Token
				//return $obj;
				//var_dump($obj);
			}
		}
		
		curl_close ($curl);
	}

	function apiNewTokenAccesstraining(){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,"https://wstraining.bkn.go.id/oauth/token");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_POST, true);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($curl, CURLOPT_POSTFIELDS,"client_id=6811training&grant_type=client_credentials");
		curl_setopt($curl, CURLOPT_USERPWD, "6811training:12345zxtqw");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','origin: http://localhost:20000'));

		// receive server response ...
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


		if(($jsondata = curl_exec($curl)) === false)
		{
			exit( 'Curl error: ' . curl_error($curl));
		}
		else
		{
			$obj = json_decode($jsondata, true);
			//var_dump($obj);
			if(isset($obj['access_token'])){
				$token_file = fopen("token-key-training.txt", "w") or die("Unable to open file!");
				$txt = "ini-nanti-diisi-token-key";
				fwrite($token_file, $obj['access_token']);
				fclose($token_file);
				
				// return Token
				//return $obj;
			}
		}
		
		curl_close ($curl);
		
	}


	function apiResult($url = ''){
		apiNewTokenAccess(); // Request token access
		$token_file = fopen("token-key.txt", "r") or die("Unable to open file!");
		$tokenKey = fgets($token_file);
		//$tokenKey = fread($token_file,filesize("token-key.txt"));
		fclose($token_file);
		
		//var_dump($url);
		//var_dump($tokenKey);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS,"client_id=balangankabws&grant_type=client_credentials");
                curl_setopt($curl, CURLOPT_USERPWD, "balangankabws:xpZWRkZ2Ru");

		//curl_setopt($curl, CURLOPT_POSTFIELDS,"client_id=6811training&grant_type=client_credentials");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data','Origin: http://localhost:20000', 'Authorization: Bearer '. $tokenKey));

		// receive server response ...
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		return curl_exec($curl);
		//$eks = curl_exec($curl);
		//var_dump($eks);
	}

function apiResult2( $url = '', $jsonData){ // UNTUK POST
	apiNewTokenAccess(); // Request token access
	$token_file = fopen("token-key.txt", "r") or die("Unable to open file!");
	//$tokenKey = fread($token_file,filesize("token-key.txt"));
	$tokenKey = fgets($token_file);
	fclose($token_file);
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Origin: http://localhost:20000', 
		'Authorization: Bearer '. $tokenKey
	));


	// receive server response ...
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	return curl_exec($curl);
}
	
