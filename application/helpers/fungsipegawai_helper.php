<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if ( ! function_exists('namagelar'))
{
    function namagelar($gd, $nama, $gb)
    {        
        if (($gd == '') AND ($gb == '')) {                      
            return $nama;
        } else if (($gd != '') AND ($gb == '')) {
            $arrayWord = array($gd, '. ', $nama);
            $joinString = implode("", $arrayWord);
            return $joinString;
        } else if (($gd == '') AND ($gb != '')) {
            $arrayWord = array($nama, ', ', $gb);
            $joinString = implode("", $arrayWord);
            return $joinString;
        } else {
            $arrayWord = array($gd, '. ', $nama, ', ', $gb);
            $joinString = implode("", $arrayWord);
            return $joinString;
        }
    }
}

if ( ! function_exists('polanip'))
{
    function polanip($nip)
    {        
        $pola1 = substr($nip, 0, 8);
        $pola2 = substr($nip, 8, 6);
        $pola3 = substr($nip, 14, 1);
        $pola4 = substr($nip, 15, 3);
   
        return $pola1." ".$pola2." ".$pola3." ".$pola4;
    }
}

if ( ! function_exists('indorupiah'))
{
    function indorupiah($rp)
    {        
        $pnjgp = strlen($rp);
        if ($pnjgp > 5) {
            $gp3 = substr($rp,$pnjgp-3,3);
            $gp2 = substr($rp,$pnjgp-6,3);
            $gp1 = substr($rp,$pnjgp-$pnjgp,1);
        } else if ($pnjgp <= 5) {
            $gp2 = substr($rp,$pnjgp-3,3);
            $gp1 = substr($rp,$pnjgp-$pnjgp,2);
        }

        if ($pnjgp >= 7) {
                $arrayWord = array($gp1, '.', $gp2, '.', $gp3);
                $joinString = implode("", $arrayWord);
                //echo "$gp1.$gp2.$gp3,-";
        } else if (($pnjgp > 5) AND ($pnjgp < 7)) {
                $arrayWord = array($gp2, '.', $gp3);
                $joinString = implode("", $arrayWord);
                //echo "$gp2.$gp3,-";
        } else if ($pnjgp <= 5) {
                $arrayWord = array($gp1, '.', $gp2);
                $joinString = implode("", $arrayWord);                
               //echo "$gp1.$gp2,-";
        }
        return $joinString;
    }        
}

if ( ! function_exists('hitungmkcpns'))
{
    function hitungmkcpns($nip)
    {        
        $sqlmkcpns = mysql_query("SELECT (((YEAR(NOW())-YEAR(tmt_cpns))*12)+(MONTH(NOW())-MONTH(tmt_cpns))) as maker_cpns FROM cpnspns where nip='$nip'");
        $mkcpns = mysql_result($sqlmkcpns,0,'maker_cpns');

        $mkcpns_bln = $mkcpns%12; // ambil sisa bagi
        $mkcpns_thn = ($mkcpns-$mkcpns_bln)/12; // untuk menghindari hasil berkoma, kurangi dulu dgn bulannya
        
        $result = array($mkcpns_thn, ' Tahun, ', $mkcpns_bln, ' Bulan');
        $joinString = implode("", $result);
        return $joinString;
    }
}

if ( ! function_exists('hitungmkpns'))
{
    function hitungmkpns($nip)
    {        
        $sqlmkpns = mysql_query("SELECT (((YEAR(NOW())-YEAR(tmt_pns))*12)+(MONTH(NOW())-MONTH(tmt_pns))) as maker_pns FROM cpnspns where nip='$nip'");
        $mkpns = mysql_result($sqlmkpns,0,'maker_pns');

        $mkpns_bln = $mkpns%12; // ambil sisa bagi
        $mkpns_thn = ($mkpns-$mkpns_bln)/12; // untuk menghindari hasil berkoma, kurangi dulu dgn bulannya
        
        $result = array($mkpns_thn, ' Tahun, ', $mkpns_bln, ' Bulan');
        $joinString = implode("", $result);
        return $joinString;
    }
}

if ( ! function_exists('hitungusia'))
{
    function hitungusia($nip)
    {        
        $sqlusia = mysql_query("SELECT (((YEAR(NOW())-YEAR(tgl_lahir))*12)+(MONTH(NOW())-MONTH(tgl_lahir))) as tgl_lahir FROM pegawai where nip='$nip'");
        $usia = mysql_result($sqlusia,0,'tgl_lahir');

        $usia_bln = $usia%12; // ambil sisa bagi
        $usia_thn = ($usia-$usia_bln)/12; // untuk menghindari hasil berkoma, kurangi dulu dgn bulannya
        
        $result = array($usia_thn, ' Tahun, ', $usia_bln, ' Bulan');
        $joinString = implode("", $result);
        return $joinString;
    }
}

if ( ! function_exists('hitungmkgolru'))
{
    function hitungmkgolru($nip)
    {        
        $q = mysql_query("select p.fid_golru_skr, cp.fid_golru_cpns from pegawai as p, cpnspns as cp where p.nip=cp.nip and p.nip='$nip'");
        $fid_golru_skr = mysql_result($q,0,'fid_golru_skr');
        $fid_golru_cpns = mysql_result($q,0,'fid_golru_cpns');

          // cek apakah fid golru sekarang besar dari fid golru saat cpns
          if ($fid_golru_skr > $fid_golru_cpns)
          { // kalo YA berarti ybs pernah KP
                $sqlmkgolru = mysql_query("SELECT (((YEAR(NOW())-YEAR(tmt))*12)+(MONTH(NOW())-MONTH(tmt))) as tmt
                FROM riwayat_pekerjaan
                where nip='$nip'
                and tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')");    
          } else { // kalo TIDAK berarti ybs masih CPNS
                $sqlmkgolru = mysql_query("SELECT (((YEAR(NOW())-YEAR(tmt_cpns))*12)+(MONTH(NOW())-MONTH(tmt_cpns))) as tmt
                FROM cpnspns
                where nip='$nip'
                and tmt_cpns IN (select max(tmt_cpns) from cpnspns where nip='$nip')");    
          }
        
        $mkgolru = mysql_result($sqlmkgolru,0,'tmt');

        $mkgolru_bln = $mkgolru%12; // ambil sisa bagi
        $mkgolru_thn = ($mkgolru-$mkgolru_bln)/12; // untuk menghindari hasil berkoma, kurangi dulu dgn bulannya
        
        $result = array($mkgolru_thn, ' Tahun, ', $mkgolru_bln, ' Bulan');
        $joinString = implode("", $result);
        return $joinString;
    }
}

if ( ! function_exists('hitungmkjab'))
{
    function hitungmkjab($nip)
    {        
        $sqlmkjab = mysql_query("SELECT (((YEAR(NOW())-YEAR(tmt_jabatan))*12)+(MONTH(NOW())-MONTH(tmt_jabatan))) as tmt
                FROM riwayat_jabatan
                where nip='$nip'
                and tmt_jabatan IN (select max(tmt_jabatan) from riwayat_jabatan where nip='$nip')");
        $mkjab = mysql_result($sqlmkjab,0,'tmt');

        $mkjab_bln = $mkjab%12; // ambil sisa bagi
        $mkjab_thn = ($mkjab-$mkjab_bln)/12; // untuk menghindari hasil berkoma, kurangi dulu dgn bulannya
        
        $result = array($mkjab_thn, ' Tahun, ', $mkjab_bln, ' Bulan');
        $joinString = implode("", $result);
        return $joinString;
    }
}

if ( ! function_exists('cekphotopns'))
{
    function cekphotopns($nip)
    {     
        $lokasifile = './photo/';   
        $filename = "$nip.jpg";

        if (file_exists ($lokasifile.$filename)) {
            $photo = "../photo/$nip.jpg";
        } else {
            $photo = "../photo/nophoto.jpg";
        }
        return $photo;
    }
}

// START : REQUEST JSON EKINERJA
if( ! function_exists('encrypt')){
	function encrypt($s) {
		$cryptKey = 'da1243ty';
		$qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $s, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
	        //$qEncoded = base64_encode($s);
		return urlencode($qEncoded);
	}
}

if( ! function_exists('decrypt')){
	function decrypt($s) {
		$cryptKey = 'da1243ty';
		$qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($s), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
		return urldecode($qDecoded);   
	}
}
// END : REQUEST JSON EKINERJA
