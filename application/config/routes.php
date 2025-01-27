<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/* Route API Web Services */
$route['services/v2/pns/(:num)'] = 'services/v2/pns/$1';
$route['services/v2/pns/tpp'] = 'services/v2/tpp/pns';
$route['services/v2/pns/(:num)/tpp'] = 'services/v2/tpp/pns/$1';
$route['services/v2/pppk/tpp'] = 'services/v2/tpp/pppk';
$route['services/v2/pppk/(:num)/tpp'] = 'services/v2/tpp/pppk/$1';
$route['services/v2/kgb/(:num)/inexis'] = 'services/v2/kgb/inexis/$1';

/* Route Riwayat */
$route['services/v2/riwayat/(:num)/absensi']            = 'services/v2/riwayat/absensi/$1';
$route['services/v2/riwayat/(:num)/cuti']               = 'services/v2/riwayat/cuti/$1';
$route['services/v2/riwayat/(:num)/kgb']                = 'services/v2/riwayat/kgb/$1';
$route['services/v2/riwayat/(:num)/pmk']                = 'services/v2/riwayat/pmk/$1';
$route['services/v2/riwayat/(:num)/lhkpn']              = 'services/v2/riwayat/lhkpn/$1';
$route['services/v2/riwayat/(:num)/hukdis']             = 'services/v2/riwayat/hukdis/$1';
$route['services/v2/riwayat/(:num)/pendidikan']         = 'services/v2/riwayat/pendidikan/$1';
$route['services/v2/riwayat/(:num)/pangkat']            = 'services/v2/riwayat/pangkat/$1';
$route['services/v2/riwayat/(:num)/jabatan']            = 'services/v2/riwayat/jabatan/$1';
$route['services/v2/riwayat/(:num)/pokja']              = 'services/v2/riwayat/pokja/$1';
$route['services/v2/riwayat/(:num)/penghargaan']        = 'services/v2/riwayat/penghargaan/$1';
$route['services/v2/riwayat/(:num)/plt']                = 'services/v2/riwayat/plt/$1';

$route['services/v2/riwayat/diklat-fungsional']         = 'services/v2/riwayat/diklatFungsional';
$route['services/v2/riwayat/(:num)/diklat-fungsional']  = 'services/v2/riwayat/diklatFungsional/$1';

$route['services/v2/riwayat/diklat-teknis']             = 'services/v2/riwayat/diklatTeknis';
$route['services/v2/riwayat/(:num)/diklat-teknis']      = 'services/v2/riwayat/diklatTeknis/$1';

$route['services/v2/riwayat/diklat-struktural']         = 'services/v2/riwayat/diklatStruktural';
$route['services/v2/riwayat/(:num)/diklat-struktural']  = 'services/v2/riwayat/diklatStruktural/$1';

$route['services/v2/riwayat/(:num)/workshop']           = 'services/v2/riwayat/workshop/$1';

$route['services/v2/riwayat/cpns-pns']                  = 'services/v2/riwayat/cpnsPns';
$route['services/v2/riwayat/(:num)/cpns-pns']           = 'services/v2/riwayat/cpnsPns/$1';

$route['services/v2/riwayat/suami-istri']               = 'services/v2/riwayat/sutri';
$route['services/v2/riwayat/(:num)/suami-istri']        = 'services/v2/riwayat/sutri/$1';

$route['services/v2/riwayat/kinerja-bkn']               = 'services/v2/riwayat/kinerjaBkn';
$route['services/v2/riwayat/(:num)/kinerja-bkn']        = 'services/v2/riwayat/kinerjaBkn/$1';

$route['services/v2/riwayat/(:num)/anak']               = 'services/v2/riwayat/anak/$1';
$route['services/v2/riwayat/(:num)/gaji']               = 'services/v2/riwayat/gaji/$1';
/* End Riwayat */

/* Route Referensi */
$route['services/v2/referensi/status-asn'] = 'services/v2/referensi/statusAsn';
$route['services/v2/referensi/status-asn/(:num)'] = 'services/v2/referensi/statusAsn/$1';
/* End Referensi */

/* End Route API Web Service */

$route['default_controller'] = "Login";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/* End of file routes.php */
/* Location: ./application/config/routes.php */
