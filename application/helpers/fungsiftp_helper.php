<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//format tanggal timestamp
if( ! function_exists('loginFtp')){
 
function loginFtp()
{
	$ftpHost = '192.168.1.4';
	$ftpUsername = 'silka_ftp';
	$ftpPassword = 'FtpSanggam';

	$connId = ftp_connect($ftpHost) or die ("Tidak bisa terhubung ke FTP Server");
	
	if (@ftp_login($connId, $ftpUsername, $ftpPassword)) {
		echo "FTP Connected";
	} else {
		echo "FTP Disconnected";
	}

	echo "<img src='ftp://photo/nophoto.jpg'>";

	//ftp_close($connId);
}

}
