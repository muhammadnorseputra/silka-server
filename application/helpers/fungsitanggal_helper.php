<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//untuk mengetahui bulan bulan
if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
            case 13: //khusus untuk menampilkan info BUP bulan 12 (desemeber) dgn TMT bulan 1 (januari) tahun berikutnya
                return "Januari";
                break;
	    case 14:
                return "THR";
                break;
	    case 15:
                return "TPP KE-13";
                break;
        }
    }
}

//untuk Konversi nama hari English ke Indonesia
if ( ! function_exists('namahari_indo'))
{
    function namahari_indo($hari)
    {
        switch ($hari)
        {
            case "Sunday":
                return "Minggu";
                break;
            case "Monday":
                return "Senin";
                break;
            case "Tuesday":
                return "Selasa";
                break;
            case "Wednesday":
                return "Rabu";
                break;
            case "Thursday":
                return "Kamis";
                break;
            case "Friday":
                return "Jum'at";
                break;
            case "Saturday":
                return "Sabtu";
                break;
	}
    }
}



if ( ! function_exists('list_bulan')) 
{
    function list_bulan($month_format="m"){
        $months =  [];
        for ($i = 1; $i <=12; $i++) {
            $months[] = date($month_format, mktime(0,0,0,$i));
        }
        return $months;
    }
}
//format tanggal yyyy-mm-dd
if ( ! function_exists('tgl_indo'))
{
    function tgl_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]); // cari nama bulan dari fungsi bulan diatas
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun; //hasil akhir
    }
}

//format tanggal dd-mm-yyyy menjadi yyyy-mm-dd
if ( ! function_exists('tgl_indo_pendek'))
{
    function tgl_indo_pendek($tgl)
    {
      if ($tgl) {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2];
        $bulan = $pecah[1]; // cari nama bulan dari fungsi bulan diatas
        $tahun = $pecah[0];
        return $tanggal.'-'.$bulan.'-'.$tahun; //hasil akhir
      } else {
	return "";
      }
    }
}

//format tanggal dd-mm-yyyy menjadi yyyy-mm-dd
if ( ! function_exists('tgl_sql'))
{
    function tgl_sql($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
        $tahun = $pecah[2];
        $bulan = $pecah[1];
        $tanggal = $pecah[0];
        return $tahun.'-'.$bulan.'-'.$tanggal; //hasil akhir
    }
    
    function tgl_sql_notime($tgl)
    {
        $pecah = explode("-",$tgl);  //memecah variabel berdasarkan -
        $tahun = $pecah[2];
        $bulan = $pecah[1];
        $tanggal = $pecah[0];
        return $tahun.'-'.$bulan.'-'.$tanggal; //hasil akhir
    }
}

//format tanggal timestamp
if( ! function_exists('tglwaktu_indo')){
 
function tglwaktu_indo($tglwaktu)
{
    //$inttime=date('Y-m-d H:i:s',$tgl); //mengubah format menjadi tanggal biasa
    $tglBaru=explode(" ",$tglwaktu); //memecah berdasarkan spaasi
     
    $tglBaru1=$tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
    $tglBaru2=$tglBaru[1]; //mendapatkan fotmat hh:ii:ss
    $tglBarua=explode("-",$tglBaru1); //lalu memecah variabel berdasarkan -
 
    $tgl=$tglBarua[2];
    $bln=$tglBarua[1];
    $thn=$tglBarua[0];
 
    $bln=bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
    $ubahTanggal="$tgl $bln $thn jam $tglBaru2 "; //hasil akhir tanggal
 
    return $ubahTanggal;
}

}

//format tanggal timestamp
if( ! function_exists('tgl_indo_timestamp')){
 
function tgl_indo_timestamp($tgl)
{
    $inttime=date('Y-m-d H:i:s',$tgl); //mengubah format menjadi tanggal biasa
    $tglBaru=explode(" ",$inttime); //memecah berdasarkan spaasi
     
    $tglBaru1=$tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
    $tglBaru2=$tglBaru[1]; //mendapatkan fotmat hh:ii:ss
    $tglBarua=explode("-",$tglBaru1); //lalu memecah variabel berdasarkan -
 
    $tgl=$tglBarua[2];
    $bln=$tglBarua[1];
    $thn=$tglBarua[0];
 
    $bln=bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
    $ubahTanggal="$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal
 
    return $ubahTanggal;
}

}
