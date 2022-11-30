<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kinerja extends CI_Controller {

  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('fungsitanggal');    
    $this->load->helper('fungsiterbilang');
    $this->load->helper('fungsipegawai');
    $this->load->model('mpegawai');
    $this->load->model('mpppk');
    $this->load->model('madmin');
    $this->load->model('munker');
    $this->load->model('mtakah');
    $this->load->model('mkinerja');
    $this->load->model('mkinerja_pppk');
    $this->load->model('mhukdis');

    // untuk fpdf
    $this->load->library('fpdf');

    // untuk login session
    if (!$this->session->userdata('nama'))
    {
      redirect('login');
    }
  }
  
  public function index()
  {	  
  }

  function tampilunkernom()
  {
    //cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['content'] = 'kinerja/tampilunkernom';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function getkinerjapernip_json($nip, $thn, $bln) {
    // jika diambil dari tabel kinerja_bulanan

    $nilaiskp = $this->mkinerja->get_realisasikinerja($nip, $thn, $bln);
    return round($nilaiskp,2);

    /*
    // JIKA LANGSUNG REQUEST KE SERVER EKINERJA
    //$url = 'http://localhost/silka/assets/kinerja032019bkppdsetda.json';
    //$url = 'https://ekinerja.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
    $url = 'http://ekinerja.bkppd.local/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
    //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
    //$url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_blnunker_silka?thn='.$thn.'&bln='.$bln.'&uk='.$idunker_des;

    $konten = file_get_contents($url);
    $api = json_decode($konten);
    $jml = count($api);

    if ($konten == '{"hasil":[]}') {
      return 0;
    }

    // TO DO : proses data dari DES Web Service
    if ($jml != 0) {
      foreach($api->hasil as $d) :
        //$nilaiskp = $api->hasil[$i]->nilai_skp; // hasil adalah array response dari api pada server sebelah
        $nilaiskp = $d->nilai_skp;

        return round($nilaiskp,2);
      endforeach;
    } else {
      return 0;
    }

    */
  }

  // HITUNG IURAN BPJS
  function hitungiuranbpjs($nip, $jmlbersih)
  {
    /*
    $iuranbulanlalu = 0;
    for ($i=1; $i<=3; $i++) {
      $tottppmurni = $this->mkinerja->gettppmurni_pernipbln($nip, $i);  
      if ($tottppmurni >= 12000000) {
        $iuran = 120000;  
      } else {
        $iuran = 0.02 * $tottppmurni;    
      }
      $iuranbulanlalu = $iuranbulanlalu + $iuran;
    }
    */
       
    if ($jmlbersih >= 12000000) {
      $iuranbulanini = 240000;  
    } else {
      $iuranbulanini = 0.02 * $jmlbersih;   
    }  

    //$totaliuran = $iuranbulanlalu + $iuranbulanini;
    $totaliuran = $iuranbulanini;
 
    //return $totaliuran;
    return 0; 
  }

  function nomperunker()
  { 
    $idunker = $this->input->post('id_unker');
    $thn = $this->input->post('tahun');
    $bln = $this->input->post('bulan');
      
    // cek priviledge session user -- nominatif_priv
    // id unker harus dipilih terlebih dahulu
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($idunker != 0)) {
      // cek apakah unit kerja telah mengusulkan atau belum
      $telahusul = $this->mkinerja->unkertelahusul($idunker, $thn, $bln);
      if ($telahusul == false) {

        // ENTRI DATA USULAN UNIT KERJA
        $created = $this->session->userdata('nip');
        $time = $this->mlogin->datetime_saatini();

        // START QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodekin/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(0,0,0); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 20; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }

        $image_name = $idunker."-".$thn.$bln.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

        $params['data'] = $idunker."-".$thn.$bln.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // END QR CODE

        $pengantar = array(
          'fid_unker'       => $idunker,
          'tahun'           => $thn,
          'bulan'           => $bln,
	  'status'          => "ENTRI",
          'entri_at'        => $time,
          'entri_by'        => $created,
          'qrcode'          => $params['data']
          );
        // tambahkan data pengantar
        $this->mkinerja->input_unkertpp($pengantar);

        $idpengantar = $this->mkinerja->getidpengantar($idunker, $thn, $bln);

        $datapns = $this->munker->pegperunker($idunker)->result_array();
        $berhasil = 0;
        $gagal = 0;
        
        $nmunker = $this->munker->getnamaunker($idunker);

        $no = 1;
        foreach($datapns as $dp) :
          
          $nip = $dp['nip'];
          
          // untuk pengecekan
          //$nama = $this->mpegawai->getnama($nip);
          //echo "<br/>".$no."-".$nip."/".$nama;

          // Cek apakah PNS tersebut berhak atas TPP
          $berhaktpp = $this->mkinerja->get_haktpp($nip); 

          if ($berhaktpp == 'YA') { 

	    // Untuk menghitung khusus bulan desember
	    /*
	    $jnsjab = $this->mkinerja->get_jnsjab($nip);
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM")) {
              $nilaiskp = 100;
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "TEKNIS")) {
              $nilaiskp = 100;
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "PENYULUH")) {
              $nilaiskp = 100;
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
              $nilaiskp = 0;
            }
	    */
	    // End Khusus bulan Desember

	    // Untuk selain Bulan Desember
            $nilaiskp = $this->getkinerjapernip_json($nip, $thn, $bln);
            
            //echo "#".$no."-".$nip."-".$nilaiskp;

            if ($nilaiskp > 100) {
              $nilaiskp=0;
            }

            $jabatan = $this->mkinerja->getnamajabatan($nip);
            
	    //$nilai_absensi = 100;
            $nilai_absensi = $this->mkinerja->get_realisasiabsensi($nip, $thn, $bln);

            $idtingpen = $this->mkinerja->getidtingpenterakhir($nip);              

            $idgolru = $this->mhukdis->getidgolruterakhir($nip);
            $golru = $this->mpegawai->getnamagolru($idgolru);

            $jnsjab = $this->mkinerja->get_jnsjab($nip);
            if ($jnsjab == "STRUKTURAL") {
              $ideselon = $this->mpegawai->getfideselon($nip);
              $namaeselon = $this->mpegawai->getnamaeselon($ideselon);
              if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
                $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
                $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
                
                $cekkaskpd = $this->mkinerja->cek_kaskpd_eselon4($id_jabstruk);
                $ceksubkeukec = $this->mkinerja->ceksubkeukec_adabendahara($id_jabstruk);
                // cek apakah kasubbag perencanaan dan keuangan pada kecamatan, dan ada jfu bendaharanya
                if ($ceksubkeukec == true) {
                  $kelasjabatan = 9;
                } else if ($cekkaskpd == true) {
                  $kelasjabatan = 9;
                } else if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
                  $kelasjabatan = 8;    
                } else {
                  $kelasjabatan = 9;
                }
              } else {
                $kelasjabatan = $this->mkinerja->get_kelasjabstruk($nip);
              }
            } else if ($jnsjab == "FUNGSIONAL UMUM") {
              $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
            } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
              $kelasjabatan = $this->mkinerja->get_kelasjabft($nip);
            }

            // SET TPP FULL DISINI
            $pengali = 0.77;
            $tppfull = $this->mkinerja->gettppfull($kelasjabatan);
                
            // START UNTUK CPNS
              $status = $this->mpegawai->getstatpeg($nip);
              
              if ($status == "CPNS") {   
                $tppbasic = ($tppfull*$pengali) * 0.8; // cpns hanya mendapat 80% dari TPP yg ditetapkan
                
                $nilaiskp60p = 0.6*$nilaiskp;
                //$nilaiskp60p = 60;
		$tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
                $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

                $nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));

                $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi
                $cutisakit = 'TIDAK'; // CPNS dianggap tidak mungkin sakit lebih dari 6 bulan
                $cutibesar = 'TIDAK'; // CPNS tidak bisa mengambil cuti besar karena belum lima tahun
                $cpns = 'YA';
                $bendahara = 'TIDAK'; $tambahbendahara = 0;
                $terpencil = 'TIDAK'; $tambahterpencil = 0;
                $pokja = 'TIDAK'; $tambahpokja = 0;
                $tanpajfu = 'TIDAK'; $tambahtanpajfu = 0;                
                $radiografer = 'TIDAK'; $tambahradiografer = 0;
                $plt = 'TIDAK';
                $jabplt = '';
                $unkerplt = '';
                $kelasjabplt =0;
                $tambahplt = 0;
                $sekda ='TIDAK'; $tambahsekda = 0;
                $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;
                $inspektorat = 'TIDAK'; $tambahinspektorat = 0;
                $pengurangan = 0;
                $penambahan = 0;
                $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
                $pajak = $this->hitungpajak($nip, $jmlbersih);
                
		// HITUNG BPJS
                $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

		$jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

                //$input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $pokja, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahbendahara, $tambahpokja, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);               

                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }

                continue; // PENTING : loncat ke perulangan foreach berikutnya (nip selanjutnya)
              }
              // END UNTUK CPNS

              // START UNTUK CUTI SAKIT DAN CUTI BESAR
              // YBS akan mendapatkan cuti sakit jika melewati tgl 1 pada bulan usul TPP
              // misal : TPP Maret 2019, PNS A cuti sakit 6 bulan tgl 15 maret s/d 15 agustus
              // ybs tidak mendapatkan TPP cuti sakit pd bulan maret, karena tidak dari tgl 1
              // ybs baru mendapatkan TPP cuti sakit pada bulan april dst
              $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
              $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);

              if (($cekcutisakit == true) OR ($cekcutibesar == true)) {
                //$tppbasic = (($tppfull*$pengali) * 40) / 100; // cuti sakit lebih dari 6 bulan, 40% dari TPP yg ditetapkan
                $tppbasic = $tppfull*$pengali;

                // set nilai SKP 0, karena yg bersangkutan hnyar mendapat 40 %
                $nilaiskp = 0;
                $nilaiskp60p = 0.6*$nilaiskp;
                $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
                $tpp_kinerja = pembulatan(round($tpp_kinerja,0));
             

                // set nilai absensi 100, ybs hnya mmendapatkan absensi sja
                $nilai_absensi = 100;
                $nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));

                $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi
                if ($cekcutisakit == true) {
                  $cutisakit = 'YA';
                  $cutibesar = 'TIDAK'; // CPNS tidak bisa mengambil cuti besar karena belum lima tahun
                } else if ($cekcutibesar == true) {
                  $cutisakit = 'TIDAK';
                  $cutibesar = 'YA'; // CPNS tidak bisa mengambil cuti besar karena belum lima tahun
                }
                
                $cpns = 'TIDAK';
                $bendahara = 'TIDAK'; $tambahbendahara = 0;
                $terpencil = 'TIDAK'; $tambahterpencil = 0;
                $pokja = 'TIDAK'; $tambahpokja = 0;
                $tanpajfu = 'TIDAK'; $tambahtanpajfu = 0;                
                $radiografer = 'TIDAK'; $tambahradiografer = 0;
                $plt = 'TIDAK';
                $jabplt = '';
                $unkerplt = '';
                $kelasjabplt =0;
                $tambahplt = 0;
                $sekda ='TIDAK'; $tambahsekda = 0;
                $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;
                $inspektorat = 'TIDAK'; $tambahinspektorat = 0;
                $pengurangan = 0;
                $penambahan = 0;
                $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
                $pajak = $this->hitungpajak($nip, $jmlbersih);

		// HITUNG BPJS
                $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

                $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }

                continue; 
              }              
              // END UNTUK CUTI SAKIT DAN CUTI BESAR

              // START UNTUK PLT
              // YBS akan mendapatkan cuti sakit jika melewati tgl 1 pada bulan usul TPP
              // misal : TPP Maret 2019, PNS A cuti sakit 6 bulan tgl 15 maret s/d 15 agustus
              // ybs tidak mendapatkan TPP cuti sakit pd bulan maret, karena tidak dari tgl 1
              // ybs baru mendapatkan TPP cuti sakit pada bulan april dst
              $cek_sdgplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);

              if ($cek_sdgplt == true) {                
                $eselonplt = $this->mkinerja->get_eselonplt($nip);
                $eselonsaatini = $this->mpegawai->getfideselon($nip);
                if ($eselonplt < $eselonsaatini) { // fid eselon makin kecil, eselon makin tinggi
                  $jabplt = $this->mkinerja->get_jabplt($nip);
                  $unkerplt = $this->mkinerja->get_unkerplt($nip);
                  $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
                  $tppfull = $this->mkinerja->gettppfull($kelasjabplt);
                  $tambahplt = 0;
                }
                
                $plt = 'YA';

                $tppbasic = $tppfull*$pengali;
               
                $nilaiskp60p = 0.6*$nilaiskp;
                //$nilaiskp60p = 60;
		$tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
                $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

                $nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));

                $jmltpp = $tpp_kinerja + $tpp_absensi;
                $cutisakit = 'TIDAK';
                $cutibesar = 'TIDAK';
                $cpns = 'TIDAK';
                $bendahara = 'TIDAK'; $tambahbendahara = 0;
                $terpencil = 'TIDAK'; $tambahterpencil = 0;
                $pokja = 'TIDAK'; $tambahpokja = 0;
                $tanpajfu = 'TIDAK'; $tambahtanpajfu = 0;                
                $radiografer = 'TIDAK'; $tambahradiografer = 0;
                
                if ($eselonplt == $eselonsaatini) {             
                  $tambahplt = ($jmltpp * 20) / 100;
		  $jabplt = $this->mkinerja->get_jabplt($nip);
                  $unkerplt = $this->mkinerja->get_unkerplt($nip);
                  $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
                }                
                
                $sekda ='TIDAK'; $tambahsekda = 0;
                $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;
                
                $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
                  if ($cekinspektorat == true) {
                    $inspektorat = 'YA';
                    $tambahinspektorat = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $inspektorat = 'TIDAK';
                    $tambahinspektorat = 0;
                  }

                $pengurangan = 0;
                $penambahan = $tambahplt + $tambahinspektorat;
                $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
                $pajak = $this->hitungpajak($nip, $jmlbersih);

		// HITUNG BPJS
                $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

                $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }

                continue; 
              }              
              // END UNTUK PLT
            
              // START UNTUK KELANGKAAN PROFESI
              $ceksekda = $this->mkinerja->ceksekda($nip);

              if (($ceksekda == true) OR (($jnsjab == "FUNGSIONAL UMUM") AND (($kelasjabatan == 1) OR ($kelasjabatan == 3)))) {
                $tppbasic = $tppfull*$pengali; // cpns hanya mendapat 80% dari TPP yg ditetapkan
                
                $nilaiskp60p = 0.6*$nilaiskp;
                //$nilaiskp60p = 60;
		$tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
                $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

                $nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));

                $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi
                $cutisakit = 'TIDAK'; // CPNS dianggap tidak mungkin sakit lebih dari 6 bulan
                $cutibesar = 'TIDAK'; // CPNS tidak bisa mengambil cuti besar karena belum lima tahun
                $cpns = 'TIDAK';
                $bendahara = 'TIDAK'; $tambahbendahara = 0;
                $terpencil = 'TIDAK'; $tambahterpencil = 0;
                $pokja = 'TIDAK'; $tambahpokja = 0;
                $tanpajfu = 'TIDAK'; $tambahtanpajfu = 0;                
                $radiografer = 'TIDAK'; $tambahradiografer = 0;
                $plt = 'TIDAK';
                $jabplt = '';
                $unkerplt = '';
                $kelasjabplt =0;
                $tambahplt = 0;
                  if ($ceksekda == true) {
                    $sekda ='YA';
                    $tambahsekda = 22550220; // tambahanan unt sekda
                  } else {
                    $sekda ='TIDAK';
                    $tambahsekda = 0;
                  }

                if (($jnsjab == "FUNGSIONAL UMUM") AND (($kelasjabatan == 1) OR ($kelasjabatan == 3))) {
                  $kelas1dan3 = 'YA';
                  if ($kelasjabatan == 1) {
                    $tambahkelas1dan3 = ($jmltpp * 60) / 100; // tambahan 60 %
                  } else if ($kelasjabatan == 3) {
                    $tambahkelas1dan3 = ($jmltpp * 20) / 100; // tambahan 20 %
                  } 
                } else {
                  $kelas1dan3 ='TIDAK';
                  $tambahkelas1dan3 = 0;
                }

                $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
                  if ($cekinspektorat == true) {
                    $inspektorat = 'YA';
                    $tambahinspektorat = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $inspektorat = 'TIDAK';
                    $tambahinspektorat = 0;
                  }

                $pengurangan = 0;
                $penambahan = $tambahsekda + $tambahkelas1dan3 + $tambahinspektorat;
                $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
                $pajak = $this->hitungpajak($nip, $jmlbersih);
                
		 // HITUNG BPJS
                $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

                $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }

                continue; 
              }
              // END UNTUK KELANGKAAN PROFESI


              // START UNTUK KONDISI KERJA
              $cekradiografer = $this->mkinerja->cekradiografer($nip);
              $cek_sdgpokja = $this->mkinerja->cek_sdgpokja($nip, $bln, $thn);
              $cek_sdgbendahara = $this->mkinerja->cek_sdgbendahara($nip, $bln, $thn);
              $ideselon = $this->mpegawai->getfideselon($nip);
              $namaeselon = $this->mpegawai->getnamaeselon($ideselon);

              // kondisi kerja tidak ada JFU S1 hanya berlaku untuk PNS Struktural eselon IV definitif
              // pada unit kerja selain kecamatan, kelurahan dan kepala uptd
              
              $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
              $cekskpd = $this->mkinerja->cekskpd_nonkeckeluptd($id_jabstruk);

              if (($jnsjab == "STRUKTURAL") AND (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) AND ($cekskpd == true)) {
                //$id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
                $ceknonjfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
              } else {
                $ceknonjfu = false;
              }
              
              if (($cekradiografer == true) OR ($cek_sdgpokja == true) OR ($jabatan == "BENDAHARA") OR ($cek_sdgbendahara == true) OR ($ceknonjfu == true)) {
                $tppbasic = $tppfull*$pengali; // cpns hanya mendapat 80% dari TPP yg ditetapkan

		if ($cekradiografer == true) { // karena radiografer adalah JFT Kesehatan, maka kinerjanya NOL, hnya absensi sja
                        $nilaiskp60p = 0;
		} else { 
                	$nilaiskp60p = 0.6*$nilaiskp;
                	//$nilaiskp60p = 60;
		}
		$tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
                $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

                $nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));
                $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi
                $cutisakit = 'TIDAK'; // CPNS dianggap tidak mungkin sakit lebih dari 6 bulan
                $cutibesar = 'TIDAK'; // CPNS tidak bisa mengambil cuti besar karena belum lima tahun
                $cpns = 'TIDAK';
                
                  // Untuk Bendahara dan Pengadministrasi Keuangan sebagai Bendahara
                  // tahun 2020, yg mendapat tambahan bendahara harus yang berjabatan pengadministrasi keuangan
		  //if (($jabatan == "BENDAHARA") OR (($cek_sdgbendahara == true) AND ($jabatan == "PENGADMINISTRASI KEUANGAN"))) {
		  // tahun 2021, tidak harus berjabatan pengadministrasi keuangan, cukup ada SK bendahara dari bakeuda
		  if (($jabatan == "BENDAHARA") OR ($cek_sdgbendahara == true)) {
		    $bendahara ='YA';
                    $tambahbendahara = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $bendahara ='TIDAK';
                    $tambahbendahara = 0;
                  }

                  $terpencil = 'TIDAK'; $tambahterpencil = 0;
                  if ($cek_sdgpokja == true) {
                    $pokja ='YA';
                    $tambahpokja = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $pokja ='TIDAK';
                    $tambahpokja = 0;
                  }
                
                  if ($ceknonjfu == true) {
                    $tanpajfu ='YA';
                    $tambahtanpajfu = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $tanpajfu ='TIDAK';
                    $tambahtanpajfu = 0;
                  }

                  if ($cekradiografer == true) {
                    $radiografer = 'YA';
                    $tambahradiografer  = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $radiografer  = 'TIDAK';
                    $tambahradiografer  = 0;
                  }

		  $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
                  if ($cekinspektorat == true) {
                    $inspektorat = 'YA';
                    $tambahinspektorat = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $inspektorat = 'TIDAK';
                    $tambahinspektorat = 0;
                  }

                $plt = 'TIDAK';
                $jabplt = '';
                $unkerplt = '';
                $kelasjabplt =0;
                $tambahplt = 0;
                $sekda ='TIDAK'; $tambahsekda = 0;
                $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;
                $pengurangan = 0;
                $penambahan = $tambahbendahara + $tambahpokja + $tambahtanpajfu + $tambahradiografer + $tambahinspektorat;
                $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
                $pajak = $this->hitungpajak($nip, $jmlbersih);

		 // HITUNG BPJS
                $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

                $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }
                continue;
              }
              // END UNTUK KONDISI KERJA            

            // UNTUK KONDISI NORMAL TANPA INDIKATOR TAMBAHAN 
            $tppbasic = $tppfull*$pengali;

	    $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            if (($keltugasjft == "PENDIDIKAN") OR ($keltugasjft == "KESEHATAN")) {
              $nilaiskp60p = 0;
              $tpp_kinerja = 0;
            } else {
	      $nilaiskp60p = 0.6*$nilaiskp;
              //$nilaiskp60p = 60;
              $tpp_kinerja = (number_format($nilaiskp60p,2)/100)*$tppbasic;                  
              $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
              $tpp_kinerja = pembulatan(round($tpp_kinerja,0));
	    }

            //$tppbasic = $tppfull*$pengali;

            //$nilaiskp60p = 0.6*$nilaiskp;
            //$nilaiskp60p = 60;
	    //$tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
            //$tpp_kinerja = pembulatan(round($tpp_kinerja,0));

            $nilaiabsensi40p = 0.4*$nilai_absensi;
            $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
            $tpp_absensi = pembulatan(round($tpp_absensi,0));

            $jmltpp = $tpp_kinerja + $tpp_absensi;

            $cutisakit = 'TIDAK';
            $cutibesar = 'TIDAK';
            $cpns = 'TIDAK';
            $bendahara = 'TIDAK'; $tambahbendahara = 0;
            $terpencil = 'TIDAK'; $tambahterpencil = 0;
            $pokja = 'TIDAK'; $tambahpokja = 0;
            $tanpajfu = 'TIDAK'; $tambahtanpajfu = 0;                
            $radiografer = 'TIDAK'; $tambahradiografer = 0;
            $plt = 'TIDAK';
            $jabplt = '';
            $unkerplt = '';
            $kelasjabplt =0;
            $tambahplt = 0;
            $sekda ='TIDAK'; $tambahsekda = 0;
            $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;
            $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
            if ($cekinspektorat == true) {
              $inspektorat = 'YA';
              $tambahinspektorat = ($jmltpp * 10) / 100;
            } else {
              $inspektorat = 'TIDAK';
              $tambahinspektorat = 0;
            }

            $pengurangan = 0;
            $penambahan = $tambahinspektorat;
            $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
            
            $pajak = $this->hitungpajak($nip, $jmlbersih);

	    // HITUNG BPJS
            $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

            $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

            $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat,$plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);

            if ($input == true) {
              $berhasil++;
            } else if ($input == false) {
              $gagal++;
              $nama = $this->mpegawai->getnama($nip);
              //echo "<br/>".$no."-".$nip."/".$nama." GAGAL";
            }
            // UNTUK KONDISI NORMAL TANPA INDIKATOR TAMBAHAN            

          } // end $berhaktpp          

          $no++;
        endforeach; // end $datapns

        $data['thn'] = $thn;
        $data['bln'] = $bln;          

        $data['idunker'] = $idunker;
        $data['nmunker'] = $this->munker->getnamaunker($idunker);
        $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
        $data['pesan'] = "<b>SUKSES</b>, Data Realisasi Kinerja Bulanan ".$nmunker." Periode ".bulan($bln)." ".$thn.".<br/>Sebanyak ".$berhasil." data BERHASIL ditambahkan, dan ".$gagal." data GAGAL ditambahkan";
        $data['jnspesan'] = "alert alert-success";

        $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

        $data['content'] = 'kinerja/nomperunker';
        $this->load->view('template',$data);
      }
    }
  }  

  function tambahusul($idpengantar, $nip, $tahun, $bulan, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima) {
    $created = $this->session->userdata('nip');
    $time = $this->mlogin->datetime_saatini();
    $data = array(
      'fid_pengantar'   => $idpengantar,
      'nip'             => $nip,
      'tahun'           => $tahun,
      'bulan'           => $bulan,
      'jabatan'         => $jabatan,
      'fid_golru'       => $idgolru,
      'fid_unker'       => $idunker,
      'fid_tingpen'     => $idtingpen,
      'kelas_jab'       => $kelasjabatan,
      'pengali'         => $pengali,
      'tpp_basic'       => $tppbasic,
      'nilai_kinerja'   => $nilaiskp,
      'tpp_kinerja'     => $tpp_kinerja,
      'nilai_absensi'   => $nilai_absensi,
      'tpp_absensi'     => $tpp_absensi,            
      'jml_tpp_kotor'   => $jmltpp,
      'cuti_sakit'      => $cutisakit,
      'cuti_besar'      => $cutibesar,            
      'cpns'            => $cpns,         
      'bendahara'       => $bendahara, 
      'jml_tpp_bendahara'   => $tambahbendahara,
      'terpencil'           => $terpencil, 
      'jml_tpp_terpencil'   => $tambahterpencil,        
      'pokja'               => $pokja, 
      'jml_tpp_pokja'       => $tambahpokja,        
      'tanpajfu'            => $tanpajfu, 
      'jml_tpp_tanpajfu'    => $tambahtanpajfu,        
      'dokter'              => "TIDAK", 
      'jml_tpp_dokter'      => 0,        
      'radiografer'         => $radiografer, 
      'jml_tpp_radiografer' => $tambahradiografer,
      'inspektorat'         => $inspektorat, 
      'jml_tpp_inspektorat' => $tambahinspektorat,
      'plt'                 => $plt,
      'plt_namajab'         => $jabplt,
      'plt_unker'           => $unkerplt,
      'plt_kelasjab'        => $kelasjabplt,
      'jml_tpp_plt'         => $tambahplt,
      'sekda'               => $sekda,
      'jml_tpp_sekda'       => $tambahsekda,                
      'kelas1dan3'          => $kelas1dan3,
      'jml_tpp_kelas1dan3'  => $tambahkelas1dan3,
      'jml_pengurangan'     => $pengurangan,
      'jml_penambahan'      => $penambahan,
      'jml_tpp_murni'       => $jmlbersih,
      'jml_pajak'           => $pajak,
      'jml_iuran_bpjs'      => $iuranbpjs,
      'tpp_diterima'        => $jmlditerima,  
      'entri_at'            => $time,
      'entri_by'            => $created
      );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $tahun,
      'bulan'           => $bulan
      );           

    //$jmldata = $i+1;
    // data usul tpp blum ada ditabel
    if ($this->mkinerja->cektelahusul($nip, $tahun, $bulan) == 0) {
      if ($this->mkinerja->input_usultpp($data)) {
        return true;
      } else {
        return false;
      }              
    } 
    //else {
    // pernah usul
    //  if ($this->mkinerja->update_usultpp($where, $data)) {
    //    return true;  
    //  } else {
    //    return false;
    //  }
  }

  function cariusul() {
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('tpp_priv') == "Y")) {
      $data['content'] = 'kinerja/cariusul';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }


  function tampilusul() {
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');

    $sqlcari = $this->mkinerja->tampilusul($thn, $bln)->result_array();
    //$jml = count($this->mkgb->carirekap($idunker, $thn)->result_array());

    ?>
    <?php
    if ($this->session->userdata('level') == "ADMIN") {
    if (($thn != 0) AND ($bln != 0)) {
    ?>
      <div style='padding-right:0px; padding-bottom:20px; margin-top:0px'>
        <div class="col-md-2" align="left">
          <form method="POST" action="../kinerja/tambahusulunker">                
             <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
             <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
             <button type="submit" class="btn btn-danger btn-outline btn-sm">
                <span class="fa fa-shield" aria-hidden="true"></span> Tambah TPP
             </button>
          </form>
        </div>

	<div class="col-md-4" align='center'>
          <form role="form" method='POST' name='formkin' action="../kinerja/tambahusulsekolah">
            <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
            <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
             <div class="form-group input-group">    
               <span class="input-group-addon"><small>Hitung TPP Sekolah</small></span>
               <select class="form-control" name="id_kec" id="id_kec" required>
               <?php
                 $kec = $this->mpegawai->kecamatan()->result_array();                
                 echo "<option value='' selected>- Pilih Korwil Kecamatan -</option>";
                 foreach($kec as $v):
                   if (!$this->mkinerja->unkertelahusul($v['id_kecamatan'], $thn, $bln)) {
                     echo "<option value=".$v['id_kecamatan'].">".$v['id_kecamatan']." | ".$v['nama_kecamatan']."</option>";
                   }
                 endforeach;
               ?>
               </select>
               <span class="input-group-addon">
                 <button type="submit" class="btn btn-warning btn-xs" onClick="showData(formkin.nip.value, formkin.thn.value, formkin.bln.value)">
                   <span class="fa fa-shield" aria-hidden="true"></span> Hitung TPP
                 </button>    
               </span>
             </div>
          </form>
        </div>

	<div class="col-md-4" align='center'>
          <form role="form" method='POST' name='formkin' action="../kinerja/tambahusulrsudpkm">
            <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
            <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
              <div class="form-group input-group">    
                <span class="input-group-addon"><small>Hitung TPP Kesehatan</small></span>
                <select class="form-control" name="id_unker" id="id_unker" required>
                <?php
                  $kec = $this->mpegawai->rsud_puskesmas()->result_array();                
                  echo "<option value='' selected>- Pilih Unit Kerja -</option>";
                  foreach($kec as $v):
                    if (!$this->mkinerja->unkertelahusul($v['id_unit_kerja'], $thn, $bln)) {
                      echo "<option value=".$v['id_unit_kerja'].">".$v['nama_unit_kerja']."</option>";
                    }
                  endforeach;
                ?>
                </select>
                <span class="input-group-addon">
                <button type="submit" class="btn btn-success btn-xs" onClick="showData(formkin.nip.value, formkin.thn.value, formkin.bln.value)">
                  <span class="fa fa-shield" aria-hidden="true"></span> Hitung TPP
                </button>    
                </span>
              </div>
            </form>
          </div>
	<!--
        <div class="col-md-12" align="right">
          <form method="POST" action="../kinerja/cetakrekap_perperiode" target='_blank'>                
             <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
             <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
             <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Rekapitulasi
             </button>
          </form>
        </div>
	-->
      </div>     
    <?php
    }
    } // IF level ADMIN
    ?>

    <table class="table table-condensed table-hover"  style="font-size: 11px; margin-top:20px">
      <thead>
      <tr class='info'>
        <td align='center' width='20'><b>No</b></td>
        <td align='center' width='400'><b>UNIT KERJA</b></td>
	<td align='center' width='30' colspan='3'><b>AKSI</b></td>
        <td align='center' width='100'><b>KINERJA | ABSENSI</b></td>
        <td align='center' width='100'><b>JUMLAH<br/>USULAN</b></td>
        <td align='center' width='100'><b>TOTAL<br/>TPP REALISASI</b></td>        
        <td align='center' width='100'><b>TOTAL<br/>TAMBAHAN</b></td>
        <td align='center' width='100'><b>TOTAL<br/>SEBELUM PAJAK</b></td>
        <td align='center' width='100'><b>TOTAL PAJAK<br/><u>TOTAL IWP 1%</u></b></td>
        <td align='center' width='100'><b>TOTAL<br/>TPP DIBAYARKAN</b></td>
        <td align='center' width='170'><b>DIUSULKAN OLEH</b></td>
      </tr>     
      </thead>
      <tbody>
      <?php
      $totaltpp = 0;
      $no = 1; 
      foreach($sqlcari as $v):
        if ($v['totpns'] == 0) {
          if ($v['fid_unker'] == '12345') {
            $warna = "success";
          } else {  
            $warna = "warning";  
          }           
        } else {
          $warna = "default";
        }

        echo "<tr class=".$warna.">";
        echo "<td align='center'>$no</td>";
	$kecamatan = $this->mpegawai->getnamakecamatan($v['fid_unker']);
        if ($kecamatan) {
          $namaunker = "TK, SD, SMP SEDERAJAT KEC. ".$kecamatan;
        } else {
          $namaunker = $this->munker->getnamaunker($v['fid_unker']);
        }

	if ($v['status'] == "VERIFIKASI") {
		$status = "<span class='text-warning'>VERIFIKASI SKPD</span>";
	} else if ($v['status'] == "ENTRI") {
		$status = "<span class='text-danger'>ENTRI HITUNG BKPPD</span>";	
	} else if ($v['status'] == "CETAK") {
                $status = "<span class='text-primary'>CETAK REKAP SKPD</span>";
        } else {
		$status = "<span class='text-success'>".$v['status']."</span>";
	}
        echo "<td>".$namaunker."<br/><code>".$status."</code></td>";
        //$ratakinerja = $this->mkinerja->getratakinerja($v['fid_unker'], $thn, $bln);
        //$rataabsensi = $this->mkinerja->getrataabsensi($v['fid_unker'], $thn, $bln);
        //echo "<td align='center'>".number_format($ratakinerja,2)."<br/>".number_format($rataabsensi,2)."</td>";
        //$jmlusul = $this->mkinerja->getjumlahusul($v['fid_unker'], $thn, $bln);
        //echo "<td align='center'>".$jmlusul." PNS</td>";
 	?> 
	<td align='center' width='30'>
          <?php
          $cekrsudpkm = $this->mkinerja->cekrsudpkm($v['fid_unker']);
          if ($kecamatan) {
            //echo "<form method='POST' action='../kinerja/detail_pengantar_sekolahan'>";
	    echo "<form method='POST' action='../kinerja/detail_pengantar'>";
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-primary btn-xs'>";
            echo "<span class='glyphicon glyphicon-list' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else if ($cekrsudpkm) {
            //echo "<form method='POST' action='../kinerja/detail_pengantar_rsudpkm'>";
	    echo "<form method='POST' action='../kinerja/detail_pengantar'>";
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-warning btn-xs'>";
            echo "<span class='glyphicon glyphicon-list' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<form method='POST' action='../kinerja/detail_pengantar'>";
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
            echo "<button type='submit' class='btn btn-primary btn-outline btn-xs'>";
            echo "<span class='glyphicon glyphicon-list' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          }
          ?>
        </td>
	<td align='center' width='30'>
          <?php
          //if (($this->session->userdata('level') == "ADMIN")) {
            if ($this->mkinerja->getstatuspengantar($v['fid_unker'], $thn, $bln) == "ENTRI") {
              echo "<form method='POST' action='../kinerja/hapus_pengantar'>";
              echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
              echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
              echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
              echo "<button type='submit' class='btn btn-danger btn-outline btn-xs'>";
              echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br />Hapus";
              echo "</button>";
              echo "</form>";
            }
	  //} 
	  ?>
        </td>
        <td align='center' width='30'>
          <?php
          if (($this->session->userdata('level') == "ADMIN")) {
	    // Tambahkan tombol Update Status
            //  echo "<button type='button' class='btn btn-danger btn-outline btn-xs' data-toggle='modal' data-target='#upstatus".$v['id']."'>";
            //  echo "Update<br/>Status";
            //  echo "</button>";
          }
          ?>
	</td>
	  <div id="upstatus<?php echo $v['id'];?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl" role="document">            	
              <div class="modal-content">              	
                <div class="modal-body" align="left">
                <?php 
                	echo "<form method='POST' name='formkin' action='../kinerja/tambahusulsekolah'>"; 
                	echo "sdfsdf";
                	echo "</form></form>";
                ?>                
                </div>
              </div>
            </div>
          </div>	
        </td>
	<?php
        echo "<td align='center'>".number_format($v['rata_kinerja'],2)."<br/>".number_format($v['rata_absensi'],2)."</td>";
        echo "<td align='center'>".$v['totpns']."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottppkotor'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottambahan'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottpp_sebelumpajak'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['totpajak'],0,",",".")."<br><u>Rp. ".number_format($v['tot_iwp_bpjs'],0,",",".")."</u></td>";
        echo "<td align='center'>Rp. ".number_format($v['tottpp_dibayar'],0,",",".")."</td>";
        
        //$jmltppditerima = $this->mkinerja->gettotaltppditerima($v['fid_unker'], $thn, $bln);
        //echo "<td align='right'>Rp. ".number_format($jmltppditerima,0,",",".")."</td>";
        echo "<td><small>".tglwaktu_indo($v['entri_at'])."<br/>".$this->mpegawai->getnama($v['entri_by'])."</small></td>";        
        $no++;
        //$totaltpp = $totaltpp + $jmltppditerima;
        echo "</tr>";
      endforeach;
      ?>
      </tbody>    
    </table>

    <?php
    // if tabel statistik jumlah
    if (($this->session->userdata('level') == "ADMIN")) {
    ?> 
    <table class='table table-striped'>
        <tr>
        <td width='33%' style='padding: 10px;'>
        <?php
          $jmlpns = $this->mkinerja->totusul_perperiode($thn, $bln);
          $tottppkotor = $this->mkinerja->tottppkotor_perperiode($thn, $bln);
          $tottambahan = $this->mkinerja->tottambahan_perperiode($thn, $bln);
          $tottppmurni = $this->mkinerja->tottppmurni_perperiode($thn, $bln);
          $totpajak = $this->mkinerja->totpajak_perperiode($thn, $bln);	  
          $totiwp = $this->mkinerja->totiwp_perperiode($thn, $bln);
          $tottppditerima = $this->mkinerja->tottppditerima_perperiode($thn, $bln);
        ?>
	<small>
	  <div>Jumlah PNS (sudah disetujui & simpan)<span class='pull-right text-muted'><?php echo $jmlpns." Orang"; ?><span></div>
          <div>Total TPP Sesuai Realisasi<span class='pull-right text-muted'>Rp. <?php echo number_format($tottppkotor,0,",","."); ?><span></div>
	  <div>Total Tambahan<span class='pull-right text-muted'>Rp. <?php echo number_format($tottambahan,0,",","."); ?><span></div>
	  <div>Total TPP + Tambahan<span class='pull-right text-muted'>Rp. <?php echo number_format($tottppmurni,0,",","."); ?><span></div>
	  <div>Total Pajak<span class='pull-right text-muted'>Rp. <?php echo number_format($totpajak,0,",","."); ?><span></div>
 	  <div>Total IWP 1%<span class='pull-right text-muted'>Rp. <?php echo number_format($totiwp,0,",","."); ?><span></div>
	  <div>Total TPP Netto (Dibayarkan)<span class='pull-right text-muted'>Rp. <?php echo number_format($tottppditerima,0,",","."); ?><span></div>
        </small>
	</td>
        <td width='33%' style='padding: 10px;'>
          <b>TOTAL TPP YANG DIBAYARKAN : </b><br/>
          <?php
            $tottppditerimagol4 = $this->mkinerja->tottppditerima_perperiode_gol4($thn, $bln);
            $tottppditerimagol3 = $this->mkinerja->tottppditerima_perperiode_gol3($thn, $bln);
            $tottppditerimagol2 = $this->mkinerja->tottppditerima_perperiode_gol2($thn, $bln);
            $tottppditerimagol1 = $this->mkinerja->tottppditerima_perperiode_gol1($thn, $bln);
          ?>
	<small>
          Golongan IV 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerimagol4,0,",","."); ?></b></span><br/>

          Golongan III 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerimagol3,0,",","."); ?></b></span><br/>

          Golongan II
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerimagol2,0,",","."); ?></b></span><br/>

          Golongan I 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerimagol1,0,",","."); ?></b></span><br/>
        </small>
	</td>
        <td width='33%' style='padding: 10px;'>
	<small>
          <b>TOTAL TPP YANG DIBAYARKAN : </b><br/>
          <?php
            $tottppditerima_jpt = $this->mkinerja->tottppditerima_perperiode_jpt($thn, $bln);
            $tottppditerima_administrator = $this->mkinerja->tottppditerima_perperiode_administrator($thn, $bln);
            $tottppditerima_pengawas = $this->mkinerja->tottppditerima_perperiode_pengawas($thn, $bln);
            $tottppditerima_jfujft = $this->mkinerja->tottppditerima_perperiode_jfujft($thn, $bln);
          ?>
          JPT
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerima_jpt,0,",","."); ?></b></span><br/>

          ADMINISTRATOR 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerima_administrator,0,",","."); ?></b></span><br/>

          PENGAWAS
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerima_pengawas,0,",","."); ?></b></span><br/>

          JFU/JFT 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerima_jfujft,0,",","."); ?></b></span><br/>
        </small>
	</td>    
        </tr>
      </table> 
    <?php
    } // end if tabel statistik jumlah
    ?>
    <?php
  }
	
  function update_status_pengantar()
  {
  	$p    = $this->input->post();
  	$data = ['status' => $p['status']];
  	$whr  = ['id_pengatar' => $p['id'], 'bulan' => $p['bulan'], 'tahun' => $p['tahun']];
  	$db   = $this->mkinerja->update_status_pengantar('usul_tpp_pengantar', $whr, $data);
  	if($db)
  	{
  		$data['pesan'] = "Update status pengantar berhasil";
    		$data['jnspesan'] = 'alert alert-success';
  	} else {
  		$data['pesan'] = "Update status pengantar gagal";
    		$data['jnspesan'] = 'alert alert-danger';
  	}
  	$this->cariusul();
  }
  function tambahusulunker()
  {
    //cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
      $tahun = $this->input->post('tahun');
      $bulan = $this->input->post('bulan');
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['tahun'] = $tahun;
      $data['bulan'] = $bulan;
      $data['content'] = 'kinerja/tampilunkernom';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function hapus_pengantar(){
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $wherepengatar = array('id' => $idpengantar,
   	'tahun' => $thn,
   	'bulan' => $bln
    );

    $whereusul = array('fid_pengantar' => $idpengantar,
    	'tahun' => $thn,
   	'bulan' => $bln
    );

    //$nmunker = $this->munker->getnamaunker($fid_unker);
    if ($this->mkinerja->hapus_pengantar($wherepengatar)) {
        if ($this->mkinerja->hapus_usul($whereusul)) {// hapus seluruh usulan pada tabel usul_tpp
          $data['pesan'] = '<b>Sukses</b>, Usulan TPP periode '.bulan($bln).' '.$thn.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Sukses</b>, Usulan TPP periode '.bulan($bln).' '.$thn.' berhasil dihapus,<br/>tapi data usulan gagal dihapus';
          $data['jnspesan'] = 'alert alert-info';
        }
      } else {
        $data['pesan'] = '<b>Gagal</b>, Usulan TPP periode '.bulan($bln).' '.$thn.' gagal dihapus';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $data['content'] = 'kinerja/cariusul';
    $this->load->view('template', $data);
  }

  function detail_pengantar() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['pesan'] = '';
    $data['jnspesan'] = '';;
    $data['idpengantar'] = $idpengantar;
    $data['idunker'] = $idunker;
    if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104') OR
	($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
    	$data['nmunker'] = "SEKOLAHAN ".$this->mpegawai->getnamakecamatan($idunker);
    } else {
    	$data['nmunker'] = $this->munker->getnamaunker($idunker);
    }
    //$data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    //$data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    if ($thn >= '2021' AND $bln >= '3') {
    	$data['content'] = 'kinerja/nomperunker-baru';
    } else if ($thn >= '2022') {
        $data['content'] = 'kinerja/nomperunker-baru';
    } else {
	$data['content'] = 'kinerja/nomperunker';
    }
    $this->load->view('template',$data);
  }

  function detail_pengantar_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $fid_unker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['idpengantar'] = $idpengantar;
    $data['id_kec'] = $fid_unker;
    $data['nmunker'] = $this->mpegawai->getnamakecamatan($fid_unker);
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan';
    $this->load->view('template',$data);	
  }

  function detail_pengantar_rsudpkm() {
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['idunker'] = $idunker;
    $data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomrsudpkm';
    $this->load->view('template',$data);
  }

  function hapus_usul(){
    $idunker = addslashes($this->input->post('idunker'));    
    $nip = addslashes($this->input->post('nip'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $where = array('nip' => $nip,
        'tahun' => $thn,
    	'bulan' => $bln
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mkinerja->hapus_usul($where)) {// hapus seluruh usulan pada tabel usul_tpp
      $data['pesan'] = '<b>Sukses</b>, Usulan TPP  '.$nama.', periode '.bulan($bln).' '.$thn.' berhasil dihapus';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, Usulan TPP  '.$nama.', periode '.bulan($bln).' '.$thn.' berhasil dihapus,<br/>tapi data usulan gagal dihapus';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idunker'] = $idunker;
    $data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomperunker-baru';
    $this->load->view('template',$data);
  }

  function hapus_usul_sekolahan(){
    $idpengantar = addslashes($this->input->post('idpengantar')); 
    $id_kec = addslashes($this->input->post('id_kec'));    
    $nip = addslashes($this->input->post('nip'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $where = array('nip' => $nip,
        'tahun' => $thn,
        'bulan' => $bln
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mkinerja->hapus_usul($where)) {// hapus seluruh usulan pada tabel usul_tpp
      $data['pesan'] = '<b>Sukses</b>, Usulan TPP  '.$nama.', periode '.bulan($bln).' '.$thn.' berhasil dihapus';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, Usulan TPP  '.$nama.', periode '.bulan($bln).' '.$thn.' berhasil dihapus,<br/>tapi data usulan gagal dihapus';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idpengantar'] = $idpengantar;    
    $data['id_kec'] = $id_kec;
    $data['nmunker'] = "SEKOLAHAN";
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan';
    $this->load->view('template',$data);
  }

  // tambah usul PNS berdasarkan unit kerja, tahun dan bulan
  function tambahusulpns()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('level') == "ADMIN") {
      $idunker = $this->input->post('idunker');
      $thn = $this->input->post('tahun');
      $bln = $this->input->post('bulan');
      $data['idunker'] = $idunker;
      $data['thn'] = $thn;
      $data['bln'] = $bln;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'kinerja/tambahusulpns';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function tampilpnsusul() {
    $nip = $this->input->get('nip');
    $uk = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');

    $unkernip =  $this->mpegawai->getfidunker($nip);
    $telahusul =  $this->mkinerja->cektelahusul($nip, $thn, $bln);

    $nmunker = $this->munker->getnamaunker($uk);
    $berhaktpp = $this->mkinerja->get_haktpp($nip);

    if (($unkernip == $uk) AND ($telahusul == 0) AND ($berhaktpp == "YA")) {
      $nama = $this->mpegawai->getnama($nip);      
      $lokasifile = './photo/';
      $filename = "$nip.jpg";
      if (file_exists ($lokasifile.$filename)) {
        $photo = "../photo/$nip.jpg";
      } else {
        $photo = "../photo/nophoto.jpg";
      }
      
      $jnsjab = $this->mkinerja->get_jnsjab($nip);
        if ($jnsjab == "STRUKTURAL") {
          $ideselon = $this->mpegawai->getfideselon($nip);
          $namaeselon = $this->mpegawai->getnamaeselon($ideselon);
          if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
            $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
            $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
            
            $cekkaskpd = $this->mkinerja->cek_kaskpd_eselon4($id_jabstruk);
              $ceksubkeukec = $this->mkinerja->ceksubkeukec_adabendahara($id_jabstruk);
              // cek apakah kasubbag perencanaan dan keuangan pada kecamatan, dan ada jfu bendaharanya
              if ($ceksubkeukec == true) {
                $kelasjabatan = 9;
              } else if ($cekkaskpd == true) {
                $kelasjabatan = 9;
              } else if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
                $kelasjabatan = 8;    
              } else {
                $kelasjabatan = 9;
              }
          } else {
            $kelasjabatan = $this->mkinerja->get_kelasjabstruk($nip);
          }
        } else if ($jnsjab == "FUNGSIONAL UMUM") {
          $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
        } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
          $kelasjabatan = $this->mkinerja->get_kelasjabft($nip);
        }
     
      echo "<div align='center'>";
      echo '<table class="table table-condensed" style="width: 70%;">';
      echo "<tr class='info'>
            <td rowspan='3' align='center' width='80'>
              <img src='$photo' width='90' height='120' class='img-thumbnail'>
            </td>
            <td>$nama</td></tr>
            <tr class='info'>          
              <td>";
      echo $this->mpegawai->namajabnip($nip);
      echo " <b>(Kelas ".$kelasjabatan.")</b>";
      echo "</td>
            <tr class='info'>
            <td>";
      echo $nmunker;
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</div>";
      ?>
      <center>
      
      <table class="table success" style="width: 70%;">
      <tr class='success'>        
        <?php
        $cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
        $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
        $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);

        // Ini ngurus PLT
        // PLT. hanya diperbolehkan jika ybs dalam keadaan tidak sedang cuti sakit atau cuti besar
        if (($cekplt == true) AND ($cekcutisakit == false) AND ($cekcutibesar == false)) {
          $plt = "YA";
          $jabplt = $this->mkinerja->get_jabplt($nip);
          $unkerplt = $this->mkinerja->get_unkerplt($nip);
          $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
          //$hargajab = $this->mkinerja->get_hargajabplt($nip); 
          echo "<td align='right'><b>Jabatan PLT :</b></td>";
          echo "<td colspan='3'>".$jabplt."<br/>".$unkerplt."<b>(Kelas Jab : ".$kelasjabplt.")</b></td>";
        } else {
          $plt = "TIDAK";
          $jabplt = "-";
          $unkerplt = "-";
          $kelasjabplt = 0;
        }
        ?>
        
      </tr>      
      <tr>
      <form method="POST" name="formkal" action="">
        <input type='hidden' name='nippns' id='nippns' value='<?php echo $nip; ?>' required />
        <?php
        // get nilai_skp dari tabel kinerja_bulanan
        $nilaiskp = $this->getkinerjapernip_json($nip, $thn, $bln);

        /*
        // get nilai_skp langsung dari aplikasi ekinerja
        $url = 'https://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
        $konten = file_get_contents($url);
        $api = json_decode($konten);
        $jml = count($api);
      
        if ($konten == '{"hasil":[]}') {
          $nilaiskp = 0;
        }

        // TO DO : proses data dari DES Web Service
        if ($jml != 0) {
          foreach($api->hasil as $d) {
            if ($d->nilai_skp != null) {
              $nilaiskp = $d->nilai_skp;
            } else {
              $nilaiskp = 0;
            }
          }
        }
        */
         
        $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);

        if (($keltugasjft == "PENDIDIKAN") OR ($keltugasjft == "KESEHATAN")) {
          $nilaiskp = 0;
          ?>  
          <td align='right'><b>Nilai Kinerja Bulanan : 0</b></td>
          <td>
            <input type="hidden" name="kin" id="kin" size="3" maxlength="5" value=<?php echo $nilaiskp; ?> disabled /> 
            <!-- nip.value, dari komponen text input pada file tambahusulpns.php -->
          </td> 
          <?php
        } else {
          ?>  
          <td align='right'><b>Nilai Kinerja Bulanan : <?php echo number_format($nilaiskp,2); ?></b></td>
          <td>         
            <input type="hidden" name="kin" id="kin" size="3" maxlength="5" value=<?php echo number_format($nilaiskp,2); ?> required /> 
            <!-- nip.value, dari komponen text input pada file tambahusulpns.php -->
          </td> 
          <?php
        }

        $nilaiabsensi = $this->mkinerja->get_realisasiabsensi($nip, $thn, $bln);
        ?>
        <td align='right'><b>Nilai Absensi Bulanan : <?php echo number_format($nilaiabsensi,2); ?></b></td>
        <td>        
          <input type="hidden" name="absen" id="absen" size=3 maxlength="5" value=<?php echo number_format($nilaiabsensi,2); ?> required />
        </td>
        <td align='right'>
          <div align='center'>
          <button type='submit' class='btn btn-warning btn-sm' onCLick="showKalkulasi(nippns.value, <?php echo $thn.",".$bln.",".$kelasjabatan; ?>, kin.value, absen.value)">
          <span class='fa fa-spinner' aria-hidden='true'></span> Proses
          </button></div>
        </td>        
      </form>
      </tr>
      <tr>
        <td  colspan='5' align='center'>
          <div id='kalkulasi'></div>
        </td>
      </tr>
      </table>
      </center>
      <?php

    } else if ($telahusul == 1) { // sudah pernah diusulkan
      echo "<div class='alert alert-warning' role='alert'><center>PNS SUDAH DIUSULKAN PADA PERIODE INI</center></div>";
    } else if ($berhaktpp == "TIDAK") {
      echo "<div class='alert alert-info' role='alert'><center>PNS TIDAK BERHAK TPP</center></div>";
    } else {
      echo "<div class='alert alert-info' role='alert'><center>PNS TIDAK DITEMUKAN PADA ".$nmunker."</center></div>";
    }
  }

  /*
  function totaltppsesuaikelas($nip, $hargajab) {
    $hargasatuan = 5800;
    //$hargasatuan = 1;
    $totaltpp = $hargajab*$hargasatuan;

    $statcpns = $this->mpegawai->getstatpeg($nip);
    // jika CPNS, TPP 80%
    if ($statcpns == "CPNS") {
      $totaltpp = ($totaltpp * 80) / 100; 
    }    
    return $totaltpp;    
  }
  */

  /*
  function nilaiskp60p($nilaiskp) {
    $skp60p = (60/100)*$nilaiskp;
    return $skp60p;
  }

  function realisasikinerja($nilaiskp, $totaltpp) {
    $nilaiskp60p = $this->nilaiskp60p($nilaiskp);
    $tpp = (number_format($nilaiskp60p,2)/100)*$totaltpp;
    return $tpp;
  }

  function nilaiabsensi40p($nilai_absensi) {
    $abs40p = (40/100)*$nilai_absensi;
    return $abs40p;
  }

  function realisasiabsensi($nilai_absensi, $totaltpp) {
    $nilaiabsensi40p = $this->nilaiabsensi40p($nilai_absensi);
    $tpp = (number_format($nilaiabsensi40p,2)/100)*$totaltpp;
    return $tpp;
  }
  */

  function hitungpajak($nip, $totaltpp) {
    $idgolru = $this->mhukdis->getidgolruterakhir($nip);
    $golru = $this->mpegawai->getnamagolru($idgolru);

    if (($golru == "IV/E") OR ($golru == "IV/D") OR ($golru == "IV/C") OR ($golru == "IV/B") OR ($golru == "IV/A")) {
      $pajak = (15 * $totaltpp) / 100;
    } else if (($golru == "III/D") OR ($golru == "III/C") OR ($golru == "III/B") OR ($golru == "III/A")) {
      $pajak = (5 * $totaltpp) / 100;
    } else {
      $pajak = 0;
    }

    return $pajak;
  }

  function persenpajak($nip) {
    $idgolru = $this->mhukdis->getidgolruterakhir($nip);
    $golru = $this->mpegawai->getnamagolru($idgolru);

    if (($golru == "IV/E") OR ($golru == "IV/D") OR ($golru == "IV/C") OR ($golru == "IV/B") OR ($golru == "IV/A")) {
      $pajak = "15 %";
    } else if (($golru == "III/D") OR ($golru == "III/C") OR ($golru == "III/B") OR ($golru == "III/A")) {
      $pajak = "5 %";
    } else {
      $pajak = "0 %";
    }

    return $pajak;
  }

  function tampilkalkulasi() {
    $nip = $this->input->get('nip');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    $kelasjabatan = $this->input->get('kls');
    $nilaiskp = $this->input->get('kin');
    $nilai_absensi = $this->input->get('abs');

    $pengali = 0.77;
    $tppfull = $this->mkinerja->gettppfull($kelasjabatan);
    $tppbasic = $tppfull*$pengali;

    $status = $this->mpegawai->getstatpeg($nip);
    if ($status == "CPNS") {   
      $tppbasic = (($tppfull*$pengali) * 80) / 100; // cpns hanya mendapat 80% dari TPP yg ditetapkan

      $nilaiskp60p = 0.6*$nilaiskp;
      $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
      $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

      $nilaiabsensi40p = 0.4*$nilai_absensi;
      $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
      $tpp_absensi = pembulatan(round($tpp_absensi,0));
    }

    //$totaltpp = $this->totaltppsesuaikelas($nip, $hargajabatan);
    // CEK CUTI SAKIT, JADI 80 %
    $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
    if ($cekcutisakit == true) {
      $cutisakit = "YA";              
    } else {
      $cutisakit = "TIDAK";
    }

    $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);
    if ($cekcutibesar == true) {
      $cutibesar = "YA";              
    } else {
      $cutibesar = "TIDAK";
    }

    if (($cekcutisakit == true) OR ($cekcutibesar == true)) {
      // set nilai SKP 0, karena yg bersangkutan hnyar mendapat 40 %
      $nilaiskp = 0;
      $nilaiskp60p = 0.6*$nilaiskp;
      $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
      $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

      // set nilai absensi 100, ybs hnya mmendapatkan absensi sja
      $nilai_absensi = 100;
      $nilaiabsensi40p = 0.4*$nilai_absensi;
      $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
      $tpp_absensi = pembulatan(round($tpp_absensi,0));

    }

    $cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
    // Ini ngurus PLT
    if ($cekplt == true) {
      $plt = "YA";
      
      $jabplt = $this->mkinerja->get_jabplt($nip);
      $unkerplt = $this->mkinerja->get_unkerplt($nip);
      $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
      $tppfull = $this->mkinerja->gettppfull($kelasjabplt);
      
      $tppbasic = $tppfull*$pengali;

      $nilaiskp60p = 0.6*$nilaiskp;
      $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
      $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

      $nilaiabsensi40p = 0.4*$nilai_absensi;
      $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
      $tpp_absensi = pembulatan(round($tpp_absensi,0));
    } else {
      $nilaiskp60p = 0.6*$nilaiskp;
      $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
      $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

      $nilaiabsensi40p = 0.4*$nilai_absensi;
      $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
      $tpp_absensi = pembulatan(round($tpp_absensi,0));
    }

    $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi

    // START PENAMBAHAN
    $penambahan = 0;
    $pengurangan = 0;
    
    $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
    
    // Perhitungan Pajak
    $nompajak = $this->persenpajak($nip); // besar persentase pajak
    $pajak = $this->hitungpajak($nip, $jmlbersih);

    // jumlah diterima
    $jmlditerima = $jmlbersih - $pajak;

    echo "<form method='POST' action='../kinerja/tambahusulpns_aksi'>";

    echo "<input type='hidden' name='nip' id='nip' value='".$nip."' required />";
    echo "<input type='hidden' name='thn' id='thn' value='".$thn."' required />";
    echo "<input type='hidden' name='bln' id='bln' value='".$bln."' required />";
    echo "<input type='hidden' name='kelasjabatan' id='kelasjabatan' value='".$kelasjabatan."' required />";
    echo "<input type='hidden' name='nilaiskp' id='nilaiskp' value='".$nilaiskp."' required />";
    echo "<input type='hidden' name='nilai_absensi' id='nilai_absensi' value='".$nilai_absensi."' required />";

    $idgolru = $this->mhukdis->getidgolruterakhir($nip);
    $golru = $this->mpegawai->getnamagolru($idgolru);
    echo "<input type='hidden' name='idgolru' id='idgolru' value='".$idgolru."' required />";
    echo "<input type='hidden' name='golru' id='golru' value='".$golru."' required />";

    echo "<div class='col-md-6'>";
    echo "<div class='panel panel-info'>";
    echo "<div class='panel-heading'>";
    echo "<div class='text-primary' align='center'><b>PERHITUNGAN TPP BASIC</b></div>";
    echo "<div align='left'><small>TPP Basic</small>
           <span class='pull-right text-muted'>
            <div class='text-primary'>
              Rp. ".number_format($tppbasic,0,",",".")."
            </div>
           </span>
          </div>";

      $statcpns = $this->mpegawai->getstatpeg($nip);
      $cpns = "TIDAK";

      if ($statcpns == "CPNS") {
        $cpns = "YA";
        echo "<div class='text-danger' align='left'><span class='label label-warning'>CPNS (80 %)</span></div>";
      }

      if ($cekcutisakit == true) {  
        echo "<div class='text-danger' align='left'><span class='label label-warning'>CUTI SAKIT (40 %)</span></div>";
      }

      if ($cekcutibesar == true) {   
        echo "<div class='text-danger' align='left'><span class='label label-warning'>CUTI BESAR (40 %)</span></div>";
      }
      echo "<div align='left'><small>Realisasi Kinerja 60 %</small><span class='pull-right text-muted'><div class='text-success'>".number_format($nilaiskp60p,2)."</div><span></div>";  
      echo "<div align='left'><small>Realisasi Absensi 40%</small><span class='pull-right text-muted'><div class='text-success'>".number_format($nilaiabsensi40p,2)."</div><span></div>";  

      echo "<br/>
            <div align='left'><small>TPP KINERJA</small><span class='pull-right text-muted'><div class='text-primary'>
            Rp. ".number_format($tpp_kinerja,0,",",".")."
            </div></span></div>";

      echo "<div align='left'><small>TPP ABSENSI</small><span class='pull-right text-muted'><div class='text-primary'>
            Rp. ".number_format($tpp_absensi,0,",",".")."
            </div></span></div>";

      echo "<div align='left'><small>TPP GROSS</small><span class='pull-right text-muted'><div class='text-primary'><b>
            Rp. ".number_format($jmltpp,0,",",".")."
            </b></div></span></div>";
      
      echo "</div>"; // tutup heading panel
      echo "</div>"; // tutup panel
      echo "</div>"; // tutup column kiri

      echo "<div class='col-md-6'>";
      echo "<div class='panel panel-warning'>";
      echo "<div class='panel-heading'>";
      echo "<div class='text-danger' align='center'><b>INDIKATOR TAMBAHAN</b></div>";
      echo "<div align='left'><small>Sekretaris Daerah (+ Rp. 22.550.220)</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahsekda' id='tambahsekda' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></div><span></div>";
      $sepuluhpersen = $jmltpp * 0.1;
      echo "<br/><div align='left'><small>Tanpa JFU (+ Rp. ".number_format($sepuluhpersen,0,",",".").")</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahtanpajfu' id='tambahtanpajfu' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></b></div><span></div>";
      echo "<br/><div align='left'><small>Bendahara (+ Rp. ".number_format($sepuluhpersen,0,",",".").")</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahbendahara' id='tambahbendahara' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></b></div><span></div>";
      echo "<br/><div align='left'><small>Pokja UPPBJ (+ Rp. ".number_format($sepuluhpersen,0,",",".").")</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahpokja' id='tambahpokja' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></b></div><span></div>";
      echo "<br/><div align='left'><small>Dokter</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahdokter' id='tambahdokter' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></b></div><span></div>";
      echo "<br/><div align='left'><small>Radiografer (+ Rp. ".number_format($sepuluhpersen,0,",",".").")</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahradiografer' id='tambahradiografer' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></b></div><span></div>";
      echo "<br/><div align='left'><small>Jabatan Kelas 1 dan 3 (+ Rp. ".number_format($sepuluhpersen,0,",",".").")</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahkelas1dan3' id='tambahkelas1dan3' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></div><span></div>";      
      echo "<br/><div align='left'><small>Terpencil (+ Rp. ".number_format($sepuluhpersen,0,",",".").")</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahterpencil' id='tambahterpencil' onkeyup='validAngka(this)' size='8' maxlength='8' value='0' required /></div><span></div>";
      
      //echo "<br/>+ Sekda : ".$tambahsekda;
      //echo "<br/>+ Ajudan : ".$tambahajudan;
      echo "</div>"; // tutup heading panel
      echo "</div>"; // tutup panel

      //echo "<div><small>TPP SEBELUM PAJAK</small><span class='pull-right text-muted'><div class='text-success'><b>Rp. <input type='text' name='jmlbersih' id='jmlbersih' onkeyup='validAngka(this)' size='8' maxlength='8' value='".round($jmlbersih,0)."' required /></b></div><span></div>";
      //echo "<br/><div><small>PAJAK ".$nompajak."</small><span class='pull-right text-muted'><div class='text-success'>Rp. <input type='text' name='pajak' id='pajak' onkeyup='validAngka(this)' size='8' maxlength='8' value='".round($pajak,0)."' required /></div><span></div>";
      //echo "<br/><small>TPP DITERIMA</small><span class='pull-right text-muted'><div class='text-success'><b>Rp. <input type='text' name='jmlditerima' id='jmlditerima' onkeyup='validAngka(this)' size='8' maxlength='8' value='".round($jmlditerima,0)."' required /></b></div><span>";

    echo "<div align='center'><button type='submit' class='btn btn-danger btn-sm'>";
    echo "<span class='glyphicon glyphicon-save' aria-hidden='true'></span> SIMPAN";
    echo "</button></div>";

    echo "</div>"; // tutup panel
    echo "</div>"; // tutup column kanan

    echo "</form>";    
  }

  function tambahusulpns_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $idgolru = $this->mhukdis->getidgolruterakhir($nip);    
    $idunker =  $this->mpegawai->getfidunker($nip);
    $idtingpen = $this->mkinerja->getidtingpenterakhir($nip);   
    $jabatan = $this->mpegawai->namajabnip($nip);
    
    $pengali = 0.77;
    $kelasjabatan = addslashes($this->input->post('kelasjabatan'));
    $nilaiskp = addslashes($this->input->post('nilaiskp'));   
    $nilai_absensi = addslashes($this->input->post('nilai_absensi')); 
    $tppfull = $this->mkinerja->gettppfull($kelasjabatan);
    $tppbasic = $tppfull*$pengali;

    $nilaiskp60p = 0.6*$nilaiskp;
    $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
    $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

    $nilaiabsensi40p = 0.4*$nilai_absensi;
    $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
    $tpp_absensi = pembulatan(round($tpp_absensi,0));

    $jmltpp = $tpp_kinerja + $tpp_absensi;

    //$tppbasic = addslashes($this->input->post('tppbasic'));
    //$tpp_kinerja = addslashes($this->input->post('tpp_kinerja'));   
    //$tpp_absensi = addslashes($this->input->post('tpp_absensi')); 
    //$jmltpp = addslashes($this->input->post('jmltpp'));
    
    $status = $this->mpegawai->getstatpeg($nip);
    if ($status == "CPNS") {   
      $cpns = "YA";
      $tppbasic = (($tppfull*$pengali) * 80) / 100; // cpns hanya mendapat 80% dari TPP yg ditetapkan

      $nilaiskp60p = 0.6*$nilaiskp;
      $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
      $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

      $nilaiabsensi40p = 0.4*$nilai_absensi;
      $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
      $tpp_absensi = pembulatan(round($tpp_absensi,0));
      $jmltpp = $tpp_kinerja + $tpp_absensi;
    } else {
      $cpns = "TIDAK";  
    }

    $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
    if ($cekcutisakit == true) {
      $cutisakit = "YA";              
    } else {
      $cutisakit = "TIDAK";
    }

    $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);
    if ($cekcutibesar == true) {
      $cutibesar = "YA";              
    } else {
      $cutibesar = "TIDAK";
    }

    $cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
    // Ini ngurus PLT
    if ($cekplt == true) {
      $plt = "YA";
      
      $jabplt = $this->mkinerja->get_jabplt($nip);
      $unkerplt = $this->mkinerja->get_unkerplt($nip);
      $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
      $tppfull = $this->mkinerja->gettppfull($kelasjabplt);
      
      $tppbasic = $tppfull*$pengali;

      $nilaiskp60p = 0.6*$nilaiskp;
      $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
      $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

      $nilaiabsensi40p = 0.4*$nilai_absensi;
      $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
      $tpp_absensi = pembulatan(round($tpp_absensi,0));

      $jmltpp = $tpp_kinerja + $tpp_absensi;

      $eselonplt = $this->mkinerja->get_eselonplt($nip);
      $eselonsaatini = $this->mpegawai->getfideselon($nip);
      if ($eselonplt == $eselonsaatini) {                   
        $tambahplt = ($jmltpp * 20) / 100;
      } else if ($eselonplt < $eselonsaatini) {
        $tambahplt = 0;
      }
    } else {
      $plt = "TIDAK";
      $jabplt = "";
      $unkerplt = "";
      $kelasjabplt = 0;
      $tambahplt = 0;
    }    

    $tambahsekda = addslashes($this->input->post('tambahsekda'));
    if ($tambahsekda != 0) {
      $sekda = "YA";
    } else {
      $sekda = "TIDAK";
    }

    $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
    if ($cekinspektorat == true) {
      $inspektorat = 'YA';
      $tambahinspektorat = ($jmltpp * 10) / 100; // tambahan 10 %
    } else {
      $inspektorat = 'TIDAK';
      $tambahinspektorat = 0;
    }
    
    $tambahbendahara = strtoupper(addslashes($this->input->post('tambahbendahara'))); 
    if ($tambahbendahara != 0) {
      $bendahara = "YA";
    } else {
      $bendahara = "TIDAK";
    }
    
    $tambahkelas1dan3 = addslashes($this->input->post('tambahkelas1dan3'));  
    if ($tambahkelas1dan3 != 0) {
      $kelas1dan3 = "YA";
    } else {
      $kelas1dan3 = "TIDAK";
    }

    $tambahtanpajfu = addslashes($this->input->post('tambahtanpajfu'));  
    if ($tambahtanpajfu != 0) {
      $tanpajfu = "YA";
    } else {
      $tanpajfu = "TIDAK";
    }

    $tambahpokja = addslashes($this->input->post('tambahpokja'));  
    if ($tambahpokja != 0) {
      $pokja = "YA";
    } else {
      $pokja = "TIDAK";
    }

    $tambahdokter = addslashes($this->input->post('tambahdokter'));  
    if ($tambahdokter != 0) {
      $dokter = "YA";
    } else {
      $dokter = "TIDAK";
    }

    $tambahradiografer = addslashes($this->input->post('tambahradiografer'));  
    if ($tambahradiografer != 0) {
      $radiografer = "YA";
    } else {
      $radiografer = "TIDAK";
    }

    $tambahterpencil = addslashes($this->input->post('tambahterpencil'));  
    if ($tambahterpencil != 0) {
      $terpencil = "YA";
    } else {
      $terpencil = "TIDAK";
    }

    $penambahan = $tambahplt + $tambahsekda + $tambahbendahara + $tambahkelas1dan3 + $tambahtanpajfu + $tambahpokja + $tambahdokter + $tambahradiografer + $tambahterpencil;
    $pengurangan = 0;
    $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
    $pajak = $this->hitungpajak($nip, $jmlbersih);
    
    $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

    $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

    //$jmlbersih = addslashes($this->input->post('jmlbersih'));
    //$pajak = addslashes($this->input->post('pajak'));        
    //$jmlditerima = addslashes($this->input->post('jmlditerima'));

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $pengali = 0.77;
    $created = $this->session->userdata('nip');
    $time = $this->mlogin->datetime_saatini();
    $data = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln,
      'jabatan'         => $jabatan,
      'fid_golru'       => $idgolru,
      'fid_unker'       => $idunker,
      'fid_tingpen'     => $idtingpen,
      'kelas_jab'       => $kelasjabatan,
      'pengali'         => $pengali,
      'tpp_basic'       => $tppbasic,
      'nilai_kinerja'   => $nilaiskp,
      'tpp_kinerja'     => $tpp_kinerja,
      'nilai_absensi'   => $nilai_absensi,
      'tpp_absensi'     => $tpp_absensi,            
      'jml_tpp_kotor'   => $jmltpp,
      'cuti_sakit'      => $cutisakit,
      'cuti_besar'      => $cutibesar,
      'cpns'            => $cpns,
      'bendahara'       => $bendahara,
      'jml_tpp_bendahara'   => $tambahbendahara,
      'terpencil'           => $terpencil, 
      'jml_tpp_terpencil'   => $tambahterpencil,        
      'pokja'               => $pokja, 
      'jml_tpp_pokja'       => $tambahpokja,        
      'tanpajfu'            => $tanpajfu, 
      'jml_tpp_tanpajfu'    => $tambahtanpajfu,
      'dokter'              => $dokter, 
      'jml_tpp_dokter'      => $tambahdokter,
      'radiografer'         => $radiografer, 
      'jml_tpp_radiografer' => $tambahradiografer,
      'inspektorat'         => $inspektorat, 
      'jml_tpp_inspektorat' => $tambahinspektorat,
      'plt'                 => $plt,
      'plt_namajab'         => $jabplt,
      'plt_unker'           => $unkerplt,
      'plt_kelasjab'        => $kelasjabplt,
      'jml_tpp_plt'         => $tambahplt,
      'sekda'               => $sekda,
      'jml_tpp_sekda'       => $tambahsekda,                
      'kelas1dan3'          => $kelas1dan3,
      'jml_tpp_kelas1dan3'  => $tambahkelas1dan3,
      'jml_pengurangan'     => $pengurangan,
      'jml_penambahan'      => $penambahan,
      'jml_tpp_murni'       => $jmlbersih,
      'jml_pajak'           => $pajak,
      'jml_iuran_bpjs'      => $iuranbpjs,
      'tpp_diterima'        => $jmlditerima,  
      'entri_at'            => $time,
      'entri_by'            => $created
      );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln
      );           

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mkinerja->cektelahusul($nip, $thn, $bln) == 0) {
      if ($this->mkinerja->input_usultpp($data)) {
        $data['pesan'] = "<b>SUKSES</b>, Data Usulan TPP Bulanan ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL DITAMBAHKAN.";
        $data['jnspesan'] = "alert alert-success";  
      } else {
        $data['pesan'] = "<b>GAGAL</b>, Data Usulan TPP Bulanan ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL DITAMBAHKAN.";
        $data['jnspesan'] = "alert alert-warning";
      }              
    } else {
      // pernah usul
      if ($this->mkinerja->update_usultpp($where, $data)) {
        $data['pesan'] = "<b>SUKSES</b>, Data Usulan TPP Bulanan ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL DIUPDATE.";
        $data['jnspesan'] = "alert alert-success";  
      } else {
        $data['pesan'] = "<b>GAGAL</b>, Data Usulan TPP Bulanan ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL DIUPDATE.";
        $data['jnspesan'] = "alert alert-warning";
      }
    }

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunker'] = $idunker;
    $data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomperunker';
    $this->load->view('template',$data);
  }

  function simpankalkulasi() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    // MODE LAMA
    /*
    $ratakinerja = $this->mkinerja->getratakinerja($idunker, $thn, $bln);
    $rataabsensi = $this->mkinerja->getrataabsensi($idunker, $thn, $bln);
    // Jumlah TPP sebelum pajak
    $totpns = $this->mkinerja->getjumlahusul($idunker, $thn, $bln);
    $tottppkotor = $this->mkinerja->tottppkotor_perunkerperiode($idunker, $thn, $bln);
    $tottambahan = $this->mkinerja->tottambahan_perunkerperiode($idunker, $thn, $bln);
    $tottppmurni = $this->mkinerja->tottppmurni_perunkerperiode($idunker, $thn, $bln);
    
    $totpajak = $this->mkinerja->totpajak_perunkerperiode($idunker, $thn, $bln);
    $tottppditerima = $this->mkinerja->tottppditerima_perunkerperiode($idunker, $thn, $bln);
    $tottppditerimagol4 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"IV/");
    $tottppditerimagol3 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"III/");
    $tottppditerimagol2 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"II/");
    $tottppditerimagol1 = $this->mkinerja->tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln,"I/");
    $tottppditerima_jpt = $this->mkinerja->tottppditerima_perunkerperiode_jpt($idunker, $thn, $bln);
    $tottppditerima_administrator = $this->mkinerja->tottppditerima_perunkerperiode_administrator($idunker, $thn, $bln);
    $tottppditerima_pengawas = $this->mkinerja->tottppditerima_perunkerperiode_pengawas($idunker, $thn, $bln);
    $tottppditerima_jfujft = $this->mkinerja->tottppditerima_perunkerperiode_jfujft($idunker, $thn, $bln);
    */

    // MODE BARU
    // Baik Unor, PKM/RSUD atau Sekolahan, disimpan berdasarkan id_pengantar
    $ratakinerja = $this->mkinerja->getratakinerja_perpengantar($idpengantar, $thn, $bln);
    $rataabsensi = $this->mkinerja->getrataabsensi_perpengantar($idpengantar, $thn, $bln);

    $totpns = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $tottppkotor = $this->mkinerja->tottppkotor_perpengantarperiode($idpengantar, $thn, $bln);
    $tottambahan = $this->mkinerja->tottambahan_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppmurni = $this->mkinerja->tottppmurni_perpengantarperiode($idpengantar, $thn, $bln);

    $totpajak = $this->mkinerja->totpajak_perpengantarperiode($idpengantar, $thn, $bln);
    $totiwp = $this->mkinerja->totiwp_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppditerima = $this->mkinerja->tottppditerima_perpengantarperiode($idpengantar, $thn, $bln);

    $tottppditerimagol4 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"IV/");
    $tottppditerimagol3 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"III/");
    $tottppditerimagol2 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"II/");
    $tottppditerimagol1 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"I/");

    $tottppditerima_jpt = $this->mkinerja->tottppditerima_perpengantarperiode_jpt($idpengantar, $thn, $bln);
    $tottppditerima_administrator = $this->mkinerja->tottppditerima_perpengantarperiode_administrator($idpengantar, $thn, $bln);
    $tottppditerima_pengawas = $this->mkinerja->tottppditerima_perpengantarperiode_pengawas($idpengantar, $thn, $bln);
    $tottppditerima_jfujft = $this->mkinerja->tottppditerima_perpengantarperiode_jfujft($idpengantar, $thn, $bln);

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'status'              => "REKAP",
      'rata_kinerja'        => $ratakinerja,
      'rata_absensi'        => $rataabsensi,
      'totpns'              => $totpns,
      'tottppkotor'         => $tottppkotor,
      'tottambahan'         => $tottambahan,
      'tottpp_sebelumpajak' => $tottppmurni,
      'totpajak'        => $totpajak,
      'tot_iwp_bpjs'    =>  $totiwp,
      'tottpp_dibayar'  => $tottppditerima,
      'tottpp_gol4'     => $tottppditerimagol4,
      'tottpp_gol3'     => $tottppditerimagol3,
      'tottpp_gol2'     => $tottppditerimagol2,
      'tottpp_gol1'     => $tottppditerimagol1,
      'tottpp_jpt'      => $tottppditerima_jpt,            
      'tottpp_administrator'  => $tottppditerima_administrator,
      'tottpp_pengawas' => $tottppditerima_pengawas,
      'tottpp_jfujft'   => $tottppditerima_jfujft,
      'updated_at'      => $tgl_aksi,         
      'updated_by'      => $user
    );

    $where = array(
      'fid_unker'       => $idunker,
      'tahun'           => $thn,
      'bulan'           => $bln,
    );           

    $namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunker'] = $idunker;
    $data['idpengantar'] = $idpengantar;
    if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104') OR
        ($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
        $data['nmunker'] = "SEKOLAHAN ".$this->mpegawai->getnamakecamatan($idunker);
    } else {
        $data['nmunker'] = $this->munker->getnamaunker($idunker);
    }

    //$data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    //$data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    //$data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    if ($thn >= '2021' AND $bln >= '3') {
        $data['content'] = 'kinerja/nomperunker-baru';
    } else if ($thn >= '2022') {
        $data['content'] = 'kinerja/nomperunker-baru';
    } else {
        $data['content'] = 'kinerja/nomperunker';
    }

    $this->load->view('template',$data);
  }

  function lanjutverifikasi() {
    $idunker = addslashes($this->input->post('fid_unker'));
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data = array(
      'status'          => "VERIFIKASI"
    );

    $where = array(
      'fid_unker'       => $idunker,
      'tahun'           => $thn,
      'bulan'           => $bln,
    );           

    $namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Diverifikasi SKPD.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Verifikasi SKPD.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunker'] = $idunker;
    //$data['nmunker'] = $this->munker->getnamaunker($idunker);
    //$data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    //$data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['idpengantar'] = $idpengantar;
    if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104') OR
        ($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
        $data['nmunker'] = "SEKOLAHAN ".$this->mpegawai->getnamakecamatan($idunker);
    } else {
        $data['nmunker'] = $this->munker->getnamaunker($idunker);
    }

    //$data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomperunker-baru';
    $this->load->view('template',$data);
  }

  public function cetakrekapunor_perperiode()  
  {
    $idunker = addslashes($this->input->post('fid_unker'));
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));
    $status = "CETAK";  // status cuti : CETAUKUSUL

    // update status cuti : CETAKUSUL => 2
    $data = array(      
      'status'      => $status
    );

    $where = array(
      'id' 	  => $idpengantar,
      'fid_unker' => $idunker,
      'tahun'     => $thn,
      'bulan'     => $bln
    );

    if ($this->mkinerja->update_pengantartpp($where, $data))
    {
      $res['idunker'] = $idunker;
      $res['idpengantar'] = $idpengantar;
      $res['thn'] = $thn;
      $res['bln'] = $bln;
      //$res['data'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result();
      $res['data'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result();
      
      if ($thn >= '2021' AND $bln >= '3') {
        $this->load->view('/kinerja/cetakrekapunorperiode-baru', $res);
      } else if ($thn >= '2022') {
	$this->load->view('/kinerja/cetakrekapunorperiode-baru', $res);
      } else {
	$this->load->view('/kinerja/cetakrekapunorperiode',$res);
      }
      
      //$this->load->view('/kinerja/cetakrekapunorperiode',$res);  
    }      
  }

  public function cetakrekapsekolahan_perperiode()  
  {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));
    $status = "CETAK";  // status cuti : CETAUKUSUL
    $idunker = "12345";

    // update status cuti : CETAKUSUL => 2
    $data = array(      
      'status'	  => $status
    );

    $where = array(
      'id'        => $idpengantar,	
      'tahun'     => $thn,
      'bulan'     => $bln
    );

    if ($this->mkinerja->update_pengantartpp($where, $data))
    {
      $res['idunker'] = '12345';
      $res['thn'] = $thn;
      $res['bln'] = $bln;
      $res['data'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result();
      
      $this->load->view('/kinerja/cetakrekapsekolahanperiode',$res);  
    }      
  }

  public function cetakrekap_perperiode()  
  {
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('tahun'));
    $bln = addslashes($this->input->post('bulan'));
    
    $res['idunker'] = $idunker;
    $res['thn'] = $thn;
    $res['bln'] = $bln;
    $res['data'] = $this->mkinerja->tampilusul($thn, $bln)->result();
      
    $this->load->view('/kinerja/cetakrekapperiode',$res);  
  }

  // Start Statistika
  function statistika2020() {
    if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198309042007011001")){
        //$data['grafik'] = $this->mcuti->getjmlprosesbystatusgraphcuti();
        //$data['thncuti'] = $this->mcuti->gettahunrwycuti()->result_array(); 
        $data['rwyperbulan'] = $this->mkinerja->getjmlrwyperbulan('2020'); 
	$data['content'] = 'kinerja/statistika2020';
        $this->load->view('template',$data);
    }
  }

  function statistika2021() {
    if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198309042007011001")) {
      //$data['grafik'] = $this->mcuti->getjmlprosesbystatusgraphcuti();
      //$data['thncuti'] = $this->mcuti->gettahunrwycuti()->result_array();
      $data['rwyperbulan'] = $this->mkinerja->getjmlrwyperbulan('2021');
      $data['content'] = 'kinerja/statistika2021';
      $this->load->view('template',$data);
    }
  }

  function statistika2022() {
    if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198309042007011001")) {
      $data['rwyperbulan'] = $this->mkinerja->getjmlrwyperbulan('2022');
      $data['content'] = 'kinerja/statistika2022';
      $this->load->view('template',$data);
    }
  }


  // End Statistika

  function tambahusulsekolah() { 
    $id_kec = $this->input->post('id_kec'); // ID kecamatan digunakan untuk fid_unker
    $thn = $this->input->post('tahun');
    $bln = $this->input->post('bulan');
    
    $telahusul = $this->mkinerja->unkertelahusul($id_kec, $thn, $bln);
    if ($telahusul == false) {
        // ENTRI DATA USULAN UNIT KERJA
        $created = $this->session->userdata('nip');
        $time = $this->mlogin->datetime_saatini();

        // START QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodekin/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(0,0,0); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 20; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }

        $image_name = $id_kec."-".$thn.$bln.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

        $params['data'] = $id_kec."-".$thn.$bln.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // END QR CODE

        $pengantar = array(
          'fid_unker'       => $id_kec,
          'tahun'           => $thn,
          'bulan'           => $bln,
          'entri_at'        => $time,
          'entri_by'        => $created,
          'qrcode'          => $params['data']
          );
        // tambahkan data pengantar
        $this->mkinerja->input_unkertpp($pengantar);


        $idpengantar = $this->mkinerja->getidpengantar($id_kec, $thn, $bln);

        $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
        $datapns = $this->mkinerja->datapnssekolah($kecamatan)->result_array();
        $berhasil = 0;
        $gagal = 0;
        
        foreach($datapns as $dp) :
          $nip = $dp['nip'];

          $jabatan = $this->mkinerja->getnamajabatan($nip);
          $idunker = $this->mpegawai->getfidunker($nip);

          $nilai_absensi = $this->mkinerja->get_realisasiabsensi($nip, $thn, $bln);
	  //$nilai_absensi = 100; // khusus desember
          $idtingpen = $this->mkinerja->getidtingpenterakhir($nip);              

          $idgolru = $this->mhukdis->getidgolruterakhir($nip);
          $golru = $this->mpegawai->getnamagolru($idgolru);

          $jnsjab = $this->mkinerja->get_jnsjab($nip);
          
          if ($jnsjab == "FUNGSIONAL UMUM") {
            $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
            $nilaiskp = $this->getkinerjapernip_json($nip, $thn, $bln);
            //$nilaiskp = 100; // khusus desember
	    if ($nilaiskp > 100) {
              $nilaiskp=0;
            }
          } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
            // UNTUK JFT non pendidikan, tarik Nilai SKP nya
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            if ($keltugasjft == "TEKNIS") {
              $kelasjabatan = $this->mkinerja->get_kelasjabft($nip);
              $nilaiskp = $this->getkinerjapernip_json($nip, $thn, $bln);
	      //$nilaiskp = 100; // khusus desember
              if ($nilaiskp > 100) {
                $nilaiskp=0;
              }
            } else {
              $kelasjabatan = 8;
              $nilaiskp=0;
            }

	    //$kelasjabatan = 8; // Untuk JFT Guru Non Sertifikasi, disamakan dengan JFT Guru Pertama (kelas 8)
            //$nilaiskp=0;
          }
          
          $cekterpencil = $this->mkinerja->cek_terpencil($idunker);

          // SET TPP FULL DISINI
          $pengali = 0.77;
                    
          $tppfull = $this->mkinerja->gettppfull($kelasjabatan);

          $status = $this->mpegawai->getstatpeg($nip);
          if ($status == "CPNS") {   
            $tppbasic = ($tppfull*$pengali) * 0.8;
            $cpns = 'YA';
          } else {
            $tppbasic = $tppfull*$pengali;
            $cpns = 'TIDAK';
          }

          if ($jnsjab == "FUNGSIONAL UMUM") {
            $nilaiskp60p = 0.6*$nilaiskp;
            //$nilaiskp60p = 60;
	    $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
            $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

            $nilaiabsensi40p = 0.4*$nilai_absensi;
            $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
            $tpp_absensi = pembulatan(round($tpp_absensi,0));
          } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
            if ($keltugasjft == "TEKNIS") {
              $nilaiskp60p = 0.6*$nilaiskp;
              $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
              $tpp_kinerja = pembulatan(round($tpp_kinerja,0));
            } else {
              $nilaiskp60p = 0;
              $tpp_kinerja = 0;
            }

	    //$nilaiskp60p = 0;
            //$tpp_kinerja = 0;

            $nilaiabsensi40p = 0.4*$nilai_absensi;
            $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
            $tpp_absensi = pembulatan(round($tpp_absensi,0));
          }          

          $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi
          $cutisakit = 'TIDAK';
          $cutibesar = 'TIDAK';
          $bendahara = 'TIDAK'; $tambahbendahara = 0;

          if ($cekterpencil == "YA") {
            $terpencil = 'YA';
            $tambahterpencil = ($jmltpp * 10) / 100; // tambahan 10 %
          } else {
            $terpencil ='TIDAK';
            $tambahterpencil = 0;
          }

          $pokja = 'TIDAK'; $tambahpokja = 0;
          $tanpajfu = 'TIDAK'; $tambahtanpajfu = 0;                
          $radiografer = 'TIDAK'; $tambahradiografer = 0;
          $plt = 'TIDAK';
          $jabplt = '';
          $unkerplt = '';
          $kelasjabplt =0;
          $tambahplt = 0;
          $sekda ='TIDAK'; $tambahsekda = 0;

          if (($jnsjab == "FUNGSIONAL UMUM") AND (($kelasjabatan == 1) OR ($kelasjabatan == 3))) {
            $kelas1dan3 = 'YA';
            if ($kelasjabatan == 1) {
              $tambahkelas1dan3 = ($jmltpp * 60) / 100; // tambahan 60 %
            } else if ($kelasjabatan == 3) {
              $tambahkelas1dan3 = ($jmltpp * 20) / 100; // tambahan 20 %
            } 
          } else {
            $kelas1dan3 ='TIDAK';
            $tambahkelas1dan3 = 0;
          }
          $inspektorat = 'TIDAK'; $tambahinspektorat = 0;

          $pengurangan = 0;
          $penambahan = $tambahkelas1dan3 + $tambahterpencil;
          $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
	  if (($jnsjab == "FUNGSIONAL TERTENTU") AND (($golru == "II/A") OR ($golru == "II/B") OR ($golru == "II/C") OR ($golru == "II/D"))) {
            $jmlbersih = $jmlbersih * 0.75;
          }
          
	  $pajak = $this->hitungpajak($nip, $jmlbersih);
          
	  $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);
        
          $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

          $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat,$plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);

          if ($input == true) {
            $berhasil++;
          } else if ($input == false) {
            $gagal++;
          }
        endforeach; // end $datapns          
      }
      $data['thn'] = $thn;
      $data['bln'] = $bln;          

      $data['id_kec'] = $id_kec;
      $data['nmunker'] = $this->munker->getnamaunker($idunker);
      $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
      $data['pesan'] = "<b>SUKSES</b>, Data Realisasi Kinerja Bulanan SEKOLAH Periode ".bulan($bln)." ".$thn.".<br/>".$berhasil." data BERHASIL ditambahkan, dan ".$gagal." data GAGAL ditambahkan";
      $data['jnspesan'] = "alert alert-success";

      $data['idpengantar'] = $idpengantar;
      $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
      $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();


      $data['content'] = 'kinerja/nomsekolahan';
      $this->load->view('template',$data);
  }

  function simpankalkulasi_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $id_kec = addslashes($this->input->post('id_kec'));
    $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    //$idunker = '12345'; // ID untuk rakapan sekolahan

    $ratakinerja = $this->mkinerja->getratakinerja_perpengantar($idpengantar, $thn, $bln);
    $rataabsensi = $this->mkinerja->getrataabsensi_perpengantar($idpengantar, $thn, $bln);
    // Jumlah TPP sebelum pajak
    $totpns = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $tottppkotor = $this->mkinerja->tottppkotor_perpengantarperiode($idpengantar, $thn, $bln);
    $tottambahan = $this->mkinerja->tottambahan_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppmurni = $this->mkinerja->tottppmurni_perpengantarperiode($idpengantar, $thn, $bln);
    
    $totpajak = $this->mkinerja->totpajak_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppditerima = $this->mkinerja->tottppditerima_perpengantarperiode($idpengantar, $thn, $bln);

    $tottppditerimagol4 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"IV/");
    $tottppditerimagol3 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"III/");
    $tottppditerimagol2 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"II/");
    $tottppditerimagol1 = $this->mkinerja->tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln,"I/");

    $tottppditerima_jpt = $this->mkinerja->tottppditerima_perpengantarperiode_jpt($idpengantar, $thn, $bln);
    $tottppditerima_administrator = $this->mkinerja->tottppditerima_perpengantarperiode_administrator($idpengantar, $thn, $bln);
    $tottppditerima_pengawas = $this->mkinerja->tottppditerima_perpengantarperiode_pengawas($idpengantar, $thn, $bln);
    $tottppditerima_jfujft = $this->mkinerja->tottppditerima_perpengantarperiode_jfujft($idpengantar, $thn, $bln);
    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'status'              => "REKAP",
      'rata_kinerja'        => $ratakinerja,
      'rata_absensi'        => $rataabsensi,
      'totpns'              => $totpns,
      'tottppkotor'         => $tottppkotor,
      'tottambahan'         => $tottambahan,
      'tottpp_sebelumpajak' => $tottppmurni,
      'totpajak'            => $totpajak,
      'tottpp_dibayar'      => $tottppditerima,
      'tottpp_gol4'         => $tottppditerimagol4,
      'tottpp_gol3'         => $tottppditerimagol3,
      'tottpp_gol2'         => $tottppditerimagol2,
      'tottpp_gol1'         => $tottppditerimagol1,
      'tottpp_jpt'          => $tottppditerima_jpt,            
      'tottpp_administrator'  => $tottppditerima_administrator,
      'tottpp_pengawas'     => $tottppditerima_pengawas,
      'tottpp_jfujft'       => $tottppditerima_jfujft,
      'updated_at'          => $tgl_aksi,         
      'updated_by'          => $user
    );

    $where = array(
      'id'              => $idpengantar,
      'tahun'           => $thn,
      'bulan'           => $bln,
    );           

    //$namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP SEKOLAHAN ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP SEKOLAHAN ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idpengantar'] = $idpengantar;
    $data['id_kec'] = $id_kec;
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan';
    $this->load->view('template',$data);
  }

  function lanjutverifikasi_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $id_kec = addslashes($this->input->post('id_kec'));
    $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data = array(
      'status'          => "VERIFIKASI"
    );

    $where = array(
      'id'              => $idpengantar,
      'tahun'           => $thn,
      'bulan'           => $bln,
    );           

    //$namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP SEKOLAHAN ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP SEKOLAHAN ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idpengantar'] = $idpengantar;
    $data['id_kec'] = $id_kec;
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan';
    $this->load->view('template',$data);
  }

  function tambahusulrsudpkm() { 
    $id_unker = $this->input->post('id_unker'); // ID kecamatan digunakan untuk fid_unker
    $thn = $this->input->post('tahun');
    $bln = $this->input->post('bulan');
    
      $telahusul = $this->mkinerja->unkertelahusul($id_unker, $thn, $bln);
      if ($telahusul == false) {
        // ENTRI DATA USULAN UNIT KERJA
        $created = $this->session->userdata('nip');
        $time = $this->mlogin->datetime_saatini();

        // START QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodekin/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(0,0,0); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 20; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }

        $image_name = $id_unker."-".$thn.$bln.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

        $params['data'] = $id_unker."-".$thn.$bln.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // END QR CODE

        $pengantar = array(
          'fid_unker'       => $id_unker,
          'tahun'           => $thn,
          'bulan'           => $bln,
          'entri_at'        => $time,
          'entri_by'        => $created,
          'qrcode'          => $params['data']
        );
        
	// tambahkan data pengantar
        $this->mkinerja->input_unkertpp($pengantar);
        $idpengantar = $this->mkinerja->getidpengantar($id_unker, $thn, $bln);

        $datapns = $this->munker->pegperunker($id_unker)->result_array();
        $berhasil = 0;
        $gagal = 0;
        
        $nmunker = $this->munker->getnamaunker($id_unker);
        $berhasil = 0;
        $gagal = 0;
        
        foreach($datapns as $dp) :
          $nip = $dp['nip'];
          
          // Cek apakah PNS tersebut berhak atas TPP
          $berhaktpp = $this->mkinerja->get_haktpp($nip); 

          if ($berhaktpp == 'YA') { 
            $jnsjab = $this->mkinerja->get_jnsjab($nip);
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM")) {
	      //$nilaiskp = 100; // khusus untuk desember
              $nilaiskp = $this->getkinerjapernip_json($nip, $thn, $bln);
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
              $nilaiskp = 0;
            }
            
            if ($nilaiskp > 100) {
              $nilaiskp=0;
            }

            $jabatan = $this->mkinerja->getnamajabatan($nip);            
            $nilai_absensi = $this->mkinerja->get_realisasiabsensi($nip, $thn, $bln);
            //$nilai_absensi = 100; // khusus desember
	    $idtingpen = $this->mkinerja->getidtingpenterakhir($nip);
            $idgolru = $this->mhukdis->getidgolruterakhir($nip);
            $golru = $this->mpegawai->getnamagolru($idgolru);

            $jnsjab = $this->mkinerja->get_jnsjab($nip);
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            if ($jnsjab == "STRUKTURAL") {
              $ideselon = $this->mpegawai->getfideselon($nip);
              $namaeselon = $this->mpegawai->getnamaeselon($ideselon);
              if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
                $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
                $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
                
                $cekkaskpd = $this->mkinerja->cek_kaskpd_eselon4($id_jabstruk);
                if ($cekkaskpd == true) {
                  $kelasjabatan = 9;
                } else if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
                  $kelasjabatan = 8;    
                } else {
                  $kelasjabatan = 9;
                }
              } else {
                $kelasjabatan = $this->mkinerja->get_kelasjabstruk($nip);
              }
            } else if ($jnsjab == "FUNGSIONAL UMUM") {
              $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
              $kelasjabatan = $this->mkinerja->get_kelasjabft($nip);
            }

            // SET TPP FULL DISINI
            $pengali = 0.77;
            $tppfull = $this->mkinerja->gettppfull($kelasjabatan);

            // START UNTUK CPNS
            $status = $this->mpegawai->getstatpeg($nip);
            if ($status == "CPNS") {   
              $tppbasic = ($tppfull*$pengali) * 0.8; 
              $cpns = 'YA';
            } else {
              $tppbasic = $tppfull*$pengali;
              $cpns = 'TIDAK';              
            }

            // Hitung Pengurangan Jaspel
            if (($jnsjab == "STRUKTURAL") AND (($namaeselon == 'III/A') OR ($namaeselon == 'III/B'))) {
              $pengurangan = 2500000; // 2,5 juta
            } else if (($jnsjab == "STRUKTURAL") AND (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B'))) {
              $pengurangan = 1000000; // 1 juta
            } else if ($jnsjab == "FUNGSIONAL UMUM") {
              if (($kelasjabatan == 1) OR ($kelasjabatan == 3)) {
                $pengurangan = 0; // tidak ada pemotongan
              } else {
                $pengurangan = 500000; // 500 ribu
              }
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
              $cekspesialis = $this->mkinerja->cekspesialis($nip);
              $cekdokterumum = $this->mkinerja->cekdokterumum($nip);
              if ($cekspesialis == true) {
                $pengurangan = 0; // tidak ada pemotongan
              } else if ($cekdokterumum == true) {
                $pengurangan = 2000000; // 2 juta
              } else {
                $pengurangan = 1500000; // 1,5 juta
              }
            }
            // End Pengurangan jaspel

            // HITUNG TPP BASIC (dikurangi selisih jaspel)
            //$tppbasic = $tppbasic - $pengurangan;
            $tppbasic = pembulatan(round($tppbasic - $pengurangan,0));

            if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM")) {
              $cek_sdgplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);

              if ($cek_sdgplt == true) {
                $plt = 'YA';                
                $eselonplt = $this->mkinerja->get_eselonplt($nip);
                $eselonsaatini = $this->mpegawai->getfideselon($nip);
                if ($eselonplt < $eselonsaatini) {
                  $jabplt = $this->mkinerja->get_jabplt($nip);
                  $unkerplt = $this->mkinerja->get_unkerplt($nip);
                  $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
                  $tppfull = $this->mkinerja->gettppfull($kelasjabplt);
                  $tambahplt = 0;
                }     
              } else {
                $plt = 'TIDAK';
                $jabplt = '';
                $unkerplt = '';
                $kelasjabplt = 0;
                $tambahplt = 0;
              }
              
              $nilaiskp60p = 0.6*$nilaiskp;
              //$nilaiskp60p = 60;
              $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
              $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

              $nilaiabsensi40p = 0.4*$nilai_absensi;
              $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
              $tpp_absensi = pembulatan(round($tpp_absensi,0));                            
            } else if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
              $cekspesialis = $this->mkinerja->cekspesialis($nip);
              if ($cekspesialis == true) {
                $nilaiskp = 0;
                $tpp_kinerja = 0;
                $nilai_absensi = 0;
                $tpp_absensi = 0;
              } else {  
                $nilaiskp = 0;
                $tpp_kinerja = 0;

                //$nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilai_absensi,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));
              }
              $plt = 'TIDAK';
              $jabplt = '';
              $unkerplt = '';
              $kelasjabplt = 0;
              $tambahplt = 0;
            }

            // Start Cuti Sakit atau cuti besar
            $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
            $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);

            if (($cekcutisakit == true) OR ($cekcutibesar == true)) {
              $nilaiskp = 0;
              $tpp_kinerja = 0;

              $nilai_absensi = 100;
              $nilaiabsensi40p = 0.4*$nilai_absensi;
              $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
              $tpp_absensi = pembulatan(round($tpp_absensi,0));

              $jmltpp = $tpp_kinerja + $tpp_absensi;
              if ($cekcutisakit == true) {
                $cutisakit = 'YA';
                $cutibesar = 'TIDAK';
              } else if ($cekcutibesar == true) {
                $cutisakit = 'TIDAK';
                $cutibesar = 'YA';
              }
            } else {
              $cutisakit = 'TIDAK';
              $cutibesar = 'TIDAK';
            }
            // End Cuti Sakit atau cuti besar
            
            // HITUNG TPP REALISASI
            $jmltpp = $tpp_kinerja + $tpp_absensi;
            // Set TPP Realisasi unt Dokter Spesialis
            if (($jnsjab == "FUNGSIONAL TERTENTU") OR ($keltugasjft == "KESEHATAN")) {
              $cekspesialis = $this->mkinerja->cekspesialis($nip);
              if ($cekspesialis == true) {
                $jmltpp = 33000000;
              }
            }    

            // Untuk Bendahara dan Pengadministrasi Keuangan sebagai Bendahara            
            $cek_sdgbendahara = $this->mkinerja->cek_sdgbendahara($nip, $bln, $thn);
            if (($jabatan == "BENDAHARA") OR (($cek_sdgbendahara == true) AND ($jabatan == "PENGADMINISTRASI KEUANGAN"))) {
              $bendahara ='YA';
              $tambahbendahara = ($jmltpp * 10) / 100;
            } else {
              $bendahara ='TIDAK';
              $tambahbendahara = 0;
            }
            // End Bendahara

            // Start Terpencil
            //if ($cekterpencil == "YA") {
              //  $terpencil = 'YA';
              //  $tambahterpencil = ($jmltpp * 10) / 100; // tambahan 10 %
            //} else {
              $terpencil ='TIDAK';
              $tambahterpencil = 0;
            //}
            // End Terpencil

            $pokja = 'TIDAK'; $tambahpokja = 0;

            // Start No JFU
            $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
            $cekskpd = $this->mkinerja->cekskpd_nonkeckeluptd($id_jabstruk);
            if (($jnsjab == "STRUKTURAL") AND (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) AND ($cekskpd == true)) {
              $ceknonjfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
              if ($ceknonjfu == true) {
                $tanpajfu ='YA';
                $tambahtanpajfu = ($jmltpp * 10) / 100; // tambahan 10 %
              } else {
                $tanpajfu ='TIDAK';
                $tambahtanpajfu = 0;
              }              
            } else {
              $tanpajfu = 'TIDAK';
              $tambahtanpajfu = 0;
            }
            // End No JFU

            // Start Radiografer
            $cekradiografer = $this->mkinerja->cekradiografer($nip);
            if ($cekradiografer == true) {
              $radiografer = 'YA';
              $tambahradiografer  = ($jmltpp * 10) / 100;
            } else {
              $radiografer  = 'TIDAK';
              $tambahradiografer  = 0;
            }
            // End Radiografer
            
            $sekda ='TIDAK'; $tambahsekda = 0;
            
            // Start JFU kelas 1 dan 3
            if (($jnsjab == "FUNGSIONAL UMUM") AND (($kelasjabatan == 1) OR ($kelasjabatan == 3))) {
              $kelas1dan3 = 'YA';
              if ($kelasjabatan == 1) {
                $tambahkelas1dan3 = ($jmltpp * 60) / 100;
              } else if ($kelasjabatan == 3) {
                $tambahkelas1dan3 = ($jmltpp * 20) / 100;
              } 
            } else {
              $kelas1dan3 ='TIDAK';
              $tambahkelas1dan3 = 0;
            }
            // End JFU kelas 1 dan 3

            $inspektorat = 'TIDAK'; $tambahinspektorat = 0;
            
            $penambahan = $tambahkelas1dan3 + $tambahradiografer + $tambahtanpajfu +  $tambahpokja + $tambahterpencil + $tambahbendahara;
            $jmlbersih = $jmltpp + $penambahan;
            $pajak = $this->hitungpajak($nip, $jmlbersih);
            $iuranbpjs = $this->hitungiuranbpjs($nip, $jmlbersih);

            $jmlditerima = $jmlbersih - ($pajak + $iuranbpjs);

            $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $id_unker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $iuranbpjs, $jmlditerima);               

            if ($input == true) {
              $berhasil++;
            } else if ($input == false) {
              $gagal++;
            }


          } // AKHIR BERHAK TPP

        endforeach; // end $datapns          
      }
      $data['thn'] = $thn;
      $data['bln'] = $bln;          

      $data['idunker'] = $id_unker;
      $data['nmunker'] = $this->munker->getnamaunker($id_unker);
      $data['jmlpeg'] = $this->munker->getjmlpeg($id_unker);
      $data['pesan'] = "<b>SUKSES</b>, Data Realisasi Kinerja Bulanan ".$nmunker." Periode ".bulan($bln)." ".$thn.".<br/>Sebanyak ".$berhasil." data BERHASIL ditambahkan, dan ".$gagal." data GAGAL ditambahkan";
      $data['jnspesan'] = "alert alert-success";

      $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($id_unker, $thn, $bln)->result_array();

      $data['content'] = 'kinerja/nomrsudpkm';
      $this->load->view('template',$data);
  }

  // START UNTUK IMPORT DATA KINERJA DARI JSON
  function tampilimport() {
    $data['unker'] = $this->mkinerja->dd_unker_import()->result_array();
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $hariini = date('d');
      if ((($hariini >= 1) AND ($hariini <= 25)) OR ($this->session->userdata('nip') == "198104072009041002")) {
	$data['pesan'] = '';
        $data['jnspesan'] = '';
        $data['status'] = 1;
      } else {
        $data['pesan'] = "<b>INFORMASI ::: </b>Import data Nilai SKP Bulanan hanya dapat dilakukan pada tanggal 1 s/d 5 setiap bulan";
        $data['jnspesan'] = 'alert alert-info';
        $data['status'] = 0;
      }      
      //$data['unker'] = $this->mkinerja->dd_unker_import()->result_array();
      //$data['pesan'] = '';
      //$data['jnspesan'] = '';
      //$data['content'] = 'kinerja/importdata';
      //$this->load->view('template', $data);
    }
    $data['content'] = 'kinerja/importdata';
    $this->load->view('template', $data);
  }

  function tampilhasilimport() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'kinerja/hasilimportdata';
      $this->load->view('template', $data);
    }
  }
  
  function showkinbulanan() {
    $idunker = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');    
    $jns = $this->input->get('jns');
    
    ?>
    <br/>
    <small>
    <table class='table table-condensed table-hover' style='width: 80%'>
      <tr class='info'>
        <td align='center' rowspan='2' width='10'><b>NO</b></td>      
        <td align='center' rowspan='2' width='150'><b>NIP</b></td>
        <td align='center' colspan='4'><b>DATA PADA APLIKASI E-KINERJA</b></td>
	<td align='center' rowspan='2' width=80'><b>STATUS TPP</b></td>
      </tr>
      <tr class='info'>
        <td align='center' width='300'><b>JABATAN | UNIT KERJA</b></td>
        <td align='center' width='150'><b>ATASAN LANGSUNG</b></td>
        <td align='center' width='50'><b>NILAI SKP</b></td>
        <td align='center' width='120'><b>LOGIN TERAKHIR</b></td>
      </tr>
    <?php
    
    if ($jns == "pns") {
      $data = $this->munker->pegperunker($idunker)->result_array();
    } else if ($jns == "pppk") {
      $data = $this->munker->pppkperunker($idunker)->result_array();
    }

    $berhasil = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;
    $telahusultpp = 0;

    $nmunker = $this->munker->getnamaunker($idunker);

    $no = 1;
    $jml = 1;
    foreach($data as $dp) :      
      $nip = $dp['nip'];    
      // untuk pengecekan
      //$nama = $this->mpegawai->getnama($nip);
      //echo "<br/>".$no."-".$nip."/".$nama;
      // Cek apakah PNS tersebut berhak atas TPP
      if ($jns == "pns") {
        $berhaktpp = $this->mkinerja->get_haktpp($nip);
        $nama = $this->mpegawai->getnama($dp['nip']);
	$cekusultpp =  $this->mkinerja->cektelahusul($nip, $thn, $bln);
	$jml++;
      } else if ($jns == "pppk") {
        $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
        $nama = $this->mpppk->getnama_lengkap($dp['nip']);
	$cekusultpp =  $this->mkinerja_pppk->cektelahusul($nip, $thn, $bln);
	$jml++;
      }

      echo "<tr>";
      echo "<td align='center'>".$no."</td>";                           
      echo "<td>NIP. ".$dp['nip']."<br/>".$nama."</td>";            

      if ($berhaktpp == 'YA') { 
          //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?thn='.$thn.'&bln='.$bln.'&nip='.$nip;
	  //$url = 'https://ekinerja.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
          $url = 'http://ekinerja.bkppd.local/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
	  $konten = file_get_contents($url);
          $api = json_decode($konten);
          $jml = count($api);

          if ($konten == '{"hasil":[]}') {
            continue;
          }

          // TO DO : proses data dari DES Web Service
          if ($jml != 0) {            
            foreach($api->hasil as $d) :              
              //echo "<td>".bulan($d->bulan)." ".$d->tahun."</td>";
              echo "<td>".$d->jabatan."<br/>".$d->unit_kerja."</td>";
              echo "<td>NIP. ".$d->nip_atasan."<br/>".$d->nama_atasan."</td>";
              echo "<td align='center'>".round($d->nilai_skp,2)."</td>";
              echo "<td>".tglwaktu_indo($d->login_terakhir)."</td>";
            endforeach;
            $berhasil++;
          } else {
            echo "<td colspan='4' align='center' class='warning'><span class='text-danger'>DATA TIDAK DITEMUKAN</span></td>"; 
             $tidakditemukan++;   
          }
      } else {
        echo "<td colspan='4' align='center' class='success'><span class='text-info'>TIDAK BERHAK TPP</span></td>";
        $tidaktpp++;
      }

      if ($cekusultpp) {
	echo "<td align='center'><small><span class='text-danger'><b>TIDAK BISA IMPORT<br/>TPP TELAH DIHITUNG</b></span></small></td>";
	$telahusultpp++;
      } else {
	echo "<td align='center'><small><span class='text-success'><b>BISA IMPORT</b></span></small></td>";
      }

      echo "</tr>";
      $no++;
    endforeach;    

    echo "</table>";
    $no--;

    echo "<div class='row'>";    
    echo "<div class='col-md-3' align='right'>";
      echo "<h5><span class='label label-info'>Jumlah : ".$no."</span></h5>";
    echo "</div><div class='col-md-1' align='right'>";
      echo "<h5><span class='label label-success'>Data Valid : ".$berhasil."</span></h5>";
    echo "</div><div class='col-md-2' align='center'>";
      echo "<h5><span class='label label-warning'>Data Tidak ditemukan : ".$tidakditemukan."</span></h5>";
    echo "</div><div class='col-md-1' align='center'>";
      echo "<h5><span class='label label-danger'>Tidak berhak TPP : ".$tidaktpp."</span></h5>";
    echo "</div>";    
    echo "<div class='col-md-3'>";
      $tglini = date('d');
      $blnini = date('m');
      $thnini = date('Y');

      //echo $tglini." ".$blnini." ".$thnini;
      
      // pengecekan tanggal import
      // 1. hanya mengizinkan data bulan lalu yg di-import (paling lambat tanggal 4 bulan berikutnya)          
      // 2. data kinerja desember dapat diupload pada desember
      // 3. data kinerja desember dapat diupload pada januari

      //if ((($bln == $blnini-1) AND ($thn == $thnini) AND ($tglini <= '04')) // 1.
      //    OR (($bln == '12') AND ($blnini == '12') AND ($thn == $thnini)) // 2.
      //    OR (($bln == '12') AND ($blnini == '1') AND ($thn == $thnini-1)) // 3.
      //    ) {         

  	if ($jml >= $telahusultpp) {
          echo "<form method='POST' action='../kinerja/import'>                
                <input type='hidden' name='idunker' id='idunker' maxlength='10' value='".$idunker."'>
                <input type='hidden' name='thn' id='thn' maxlength='4' value='".$thn."'>
                <input type='hidden' name='bln' id='bln' maxlength='4' value='".$bln."'>
                <input type='hidden' name='jns' id='jns' maxlength='4' value='".$jns."'>
                <button type='submit' class='btn btn-danger btn-xxl'>
                  <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspImport Data Nilai SKP ke SILKa
                </button>
              </form>";
	}
      //}

    echo "</div>";

    echo "<div class='col-md-2'></div>";
    echo "</div>"; // tutup row

    echo "</small>";
  }

  public function import() {
    $idunker = $this->input->post('idunker');
    $thn = $this->input->post('thn');
    $bln = $this->input->post('bln');
    $jns = $this->input->post('jns');

    if ($jns == "pns") {
      $data = $this->munker->pegperunker($idunker)->result_array();
    } else if ($jns == "pppk") {
      $data = $this->munker->pppkperunker($idunker)->result_array();
    }

    $berhasil = 0;
    $gagal = 0;
    $nmunker = $this->munker->getnamaunker($idunker);

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $no = 1;
    foreach($data as $dp) :      
      $nip = $dp['nip'];
      if ($jns == "pns") {
        $berhaktpp = $this->mkinerja->get_haktpp($nip);
        $nama = $this->mpegawai->getnama($dp['nip']);
	$cekusultpp =  $this->mkinerja->cektelahusul($nip, $thn, $bln);
        if (!$cekusultpp) {
          $bisaimport = "YA";
        } else {
	  $bisaimport = "TIDAK";
	}
      } else if ($jns == "pppk") {
        $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
        $nama = $this->mpppk->getnama_lengkap($dp['nip']);
	$cekusultpp =  $this->mkinerja_pppk->cektelahusul($nip, $thn, $bln);
        if (!$cekusultpp) {
          $bisaimport = "YA";
        } else {
          $bisaimport = "TIDAK";
        }
      }

      // Cek apakah PNS tersebut berhak atas TPP
      if (($berhaktpp == 'YA') AND ($bisaimport == "YA")) { 
          //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?thn='.$thn.'&bln='.$bln.'&nip='.$nip;
	  //$url = 'https://ekinerja.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
          $url = 'http://ekinerja.bkppd.local/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
	  $konten = file_get_contents($url);
          $api = json_decode($konten);
          $jml = count($api);

          if ($konten == '{"hasil":[]}') {
            continue;
          }

          // TO DO : proses data dari DES Web Service
          if ($jml != 0) {            

            foreach($api->hasil as $d) :              
              if ($d->jabatan == null) $jabatan = ""; else $jabatan = $d->jabatan;
              if ($d->unit_kerja == null) $unit_kerja = ""; else $unit_kerja = $d->unit_kerja;
              if ($d->nama_atasan == null) $atasan_langsung = ""; else $atasan_langsung = $d->nama_atasan;

	      // KHUSUS UNTUK PNS
	      if ($jns == "pns") {
              	$data = array(
              	'nip'             => $nip,
              	'bulan'           => $bln,
              	'tahun'           => $thn,
              	'nilai_skp'       => round($d->nilai_skp,2),
              	'jabatan'         => $jabatan,
              	'unit_kerja'      => $unit_kerja,
              	'atasan_langsung' => $atasan_langsung,
              	'login_terakhir'  => $d->login_terakhir,
              	'import_by'       => $user,
              	'import_at'       => $tgl_aksi
              	);

              	if ($this->mkinerja->cekada_kinerja_bulanan($nip, $thn, $bln) == 0) {
                	if ($this->mkinerja->input_kinerja_bulanan($data)) {
                  		$berhasil++;
                	} else {
                  		$gagal++;
                	}
              	} else {
                	$where = array(
                  	  'nip'             => $nip,
                  	  'bulan'           => $bln,
                  	  'tahun'           => $thn
                	); 

                	if ($this->mkinerja->update_kinerja_bulanan($where, $data)) {
                  		$berhasil++;
                	} else {
                  		$gagal++;
                	}
              	}
	      } // END untuk PNS
	      // UNTUK PPPK
	      else if (($jns == "pppk") AND ($bisaimport == "YA")) {
                $data = array(
                'nipppk'          => $nip,
                'bulan'           => $bln,
                'tahun'           => $thn,
                'nilai_skp'       => round($d->nilai_skp,2),
                'jabatan'         => $jabatan,
                'unit_kerja'      => $unit_kerja,
                'atasan_langsung' => $atasan_langsung,
                'login_terakhir'  => $d->login_terakhir,
                'import_by'       => $user,
                'import_at'       => $tgl_aksi
                );

                if ($this->mkinerja_pppk->cekada_kinerja_bulanan_pppk($nip, $thn, $bln) == 0) {
                  if ($this->mkinerja_pppk->input_kinerja_bulanan_pppk($data)) {
                    $berhasil++;
                  } else {
                    $gagal++;
                  }
                } else {
                  $where = array(
                    'nipppk'             => $nip,
                    'bulan'           => $bln,
                    'tahun'           => $thn
                  ); 

                  if ($this->mkinerja_pppk->update_kinerja_bulanan_pppk($where, $data)) {
                    $berhasil++;
                  } else {
                    $gagal++;
                  }
                }
              } // END untuk PNS

            endforeach;
          }
      } 
      
    endforeach;

    $data['pesan'] = "<b>IMPORTING REALISASI KINERJA BULANAN ".strtoupper($jns)." DARI APLIKASI E-KINERJA</b>, ".$nmunker." bulan ".bulan($bln)." Tahun ".$thn."<br/>".$berhasil." Data berhasil disimpan, ".$gagal." Data gagal disimpan";
    $data['jnspesan'] = "alert alert-success";  

    $data['unker'] = $this->mkinerja->dd_unker()->result_array();
    //$data['content'] = 'kinerja/importdata';
    $data['content'] = 'kinerja/hasilimportdata';
    $this->load->view('template', $data);
  }
 
  function showhasilkinbulanan() {
    $idunker = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    $jns = $this->input->get('jns');
    
    ?>
    <br/>
    <small>
    <table class='table table-condensed table-hover' style='width: 80%'>
      <tr class='success'>
        <td align='center' width='10'><b>NO</b></td>      
        <td align='center' width='150'><b>NIP</b></td>
        <td align='center' width='300'><b>JABATAN | UNIT KERJA</b></td>
        <td align='center' width='150'><b>ATASAN LANGSUNG</b></td>
        <td align='center' width='50'><b>NILAI SKP</b></td>
        <td align='center' width='120'><b>LOGIN TERAKHIR</b></td>
      </tr>
    <?php

    if ($jns == "pns") {
      $data = $this->munker->pegperunker($idunker)->result_array();
    } else if ($jns == "pppk") {
      $data = $this->munker->pppkperunker($idunker)->result_array();
    }

    $ditemukan = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;

    $no = 1;
    foreach($data as $dp) :      
      $nip = $dp['nip'];
      // untuk pengecekan

      if ($jns == "pns") {
        $berhaktpp = $this->mkinerja->get_haktpp($nip);
        $nama = $this->mpegawai->getnama($dp['nip']);
      } else if ($jns == "pppk") {
        $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
        $nama = $this->mpppk->getnama_lengkap($dp['nip']);
      }

      echo "<tr>";
      echo "<td align='center'>".$no."</td>";                           
      echo "<td>NIP. ".$nip."<br/>".$nama."</td>";            

      if ($berhaktpp == 'YA') {
	if ($jns == "pns") {
          $datakin = $this->mkinerja->get_kinerja_bulanan_bynip($nip, $thn, $bln)->result_array();
        } else if ($jns == "pppk") {
          $datakin = $this->mkinerja_pppk->get_kinerja_bulanan_bynipppk($nip, $thn, $bln)->result_array();
        }

        if ($datakin) {
          foreach($datakin as $d) :
              echo "<td>".$d['jabatan']."<br/>".$d['unit_kerja']."</td>";
              echo "<td>".$d['atasan_langsung']."</td>";
              echo "<td align='center'>".round($d['nilai_skp'],2)."</td>";
              echo "<td>".tglwaktu_indo($d['login_terakhir'])."</td>";
          endforeach;
          $ditemukan++;
        } else {
          echo "<td colspan='4' align='center' class='success'><span class='text-info'>DATA TIDAK DITEMUKAN</span></td>";
          $tidakditemukan++;  
        }
      } else {
        echo "<td colspan='4' align='center' class='warning'><span class='text-info'>TIDAK BERHAK TPP</span></td>";
        $tidaktpp++;
      }
      echo "</tr>";
      $no++;
    endforeach;    
    $no--;

    echo "</table>";

    echo "<div class='row'>";    
    echo "<div class='col-md-4' align='right'>";
      echo "<h5><span class='label label-info'>Jumlah Data : ".$no."</span></h5>";
    echo "</div><div class='col-md-2' align='center'>";
      echo "<h5><span class='label label-success'>Data ditemukan : ".$ditemukan."</span></h5>";
    echo "</div><div class='col-md-2' align='center'>";
      echo "<h5><span class='label label-warning'>Data Tidak ditemukan : ".$tidakditemukan."</span></h5>";
    echo "</div><div class='col-md-2' align='center'>";
      echo "<h5><span class='label label-danger'>Tidak berhak TPP : ".$tidaktpp."</span></h5>";
    echo "</div>";    
    echo "<div class='col-md-2'></div>";
    echo "</div>";// tutup row

    echo "</small>";
  }

  // END UNTUK IMPORT DATA KINERJA DARI JSON


  // IMPORT DATA KINERJA PERORANGAN
  function tampilimportperorangan() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'kinerja/importdataperorangan';
      $this->load->view('template', $data);
    }
  }

  function showkinbulananperorangan() {
    $nip = $this->input->get('nip');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
        
    $berhasil = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;

      // Cek apakah PNS tersebut berhak atas TPP
            
      $ada = $this->mpegawai->getnipnama($nip)->result_array(); 
      if ($ada) {
        $berhaktpp = $this->mkinerja->get_haktpp($nip);
	if ($berhaktpp == 'YA') { 
            ?>
            <br/>
            <small>
            <table class='table table-condensed' style='width: 80%'>
              <tr class='danger'>
                <td align='center' rowspan='2' width='150'><b>NIP.<br/>NAMA</b></td>
                <td align='center' colspan='4'><b>DATA PADA APLIKASI E-KINERJA</b></td>
              </tr>
              <tr class='danger'>
                <td align='center' width='300'><b>JABATAN | UNIT KERJA</b></td>
                <td align='center' width='150'><b>ATASAN LANGSUNG</b></td>
                <td align='center' width='50'><b>NILAI SKP</b></td>
                <td align='center' width='120'><b>LOGIN TERAKHIR</b></td>
              </tr>
            <?php
            
            //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?thn='.$thn.'&bln='.$bln.'&nip='.$nip;
            //$url = 'https://ekinerja.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
            $url = 'http://ekinerja.bkppd.local/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
	    $konten = file_get_contents($url);
	    //var_dump($konten);
            $api = json_decode($konten);
            $jml = count($api);

            if ($konten == '{"hasil":[]}') {
              continue;
            }

            echo "<tr>";                    
            echo "<td>NIP. ".$nip."<br/>".$this->mpegawai->getnama($nip)."</td>";      

            // TO DO : proses data dari DES Web Service
            if ($jml != 0) {            
              foreach($api->hasil as $d) :              
                //echo "<td>".bulan($d->bulan)." ".$d->tahun."</td>";
                echo "<td>".$d->jabatan."<br/>".$d->unit_kerja."</td>";
                echo "<td>NIP. ".$d->nip_atasan."<br/>".$d->nama_atasan."</td>";
                echo "<td align='center'>".round($d->nilai_skp,2)."</td>";
                echo "<td>".tglwaktu_indo($d->login_terakhir)."</td>";
              endforeach;
              $berhasil++;

              echo "</table>";   
              echo "</small>";
	      
              $cekusultpp =  $this->mkinerja->cektelahusul($nip, $thn, $bln);
              if ($cekusultpp){
            	echo "<h5><span class='text-danger'>Kada kawa di-Impor karena TPP bulan ".bulan($bln)." ".$thn." sudah tuntung dihitung.</span></h5>";
              } else {	
              	echo "<div class='row'>";        
              	echo "<div class='col-md-12'>";
              	echo "<form method='POST' action='../kinerja/importperorangan'>                
                      <input type='hidden' name='nip' id='nip' maxlength='10' value='".$nip."'>
                      <input type='hidden' name='thn' id='thn' maxlength='4' value='".$thn."'>
                      <input type='hidden' name='bln' id='bln' maxlength='4' value='".$bln."'>
                      <button type='submit' class='btn btn-danger btn-sm'>
                        <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspImport Data Kinerja
                      </button>
                    </form>";
              	echo "</div>";
              	echo "<div class='col-md-2'></div>";
              	echo "</div>"; // tutup row
	      }
            } else {
              echo "<br/><h4><span class='text-warning'>DATA KINERJA TIDAK DITEMUKAN</span></h4>"; 
            }
        } else {
          echo "<br/><h4><span class='text-warning'>PNS TIDAK BERHAK TPP</span></h4>";
        }
      } else {
        echo "<br/><h4><span class='text-warning'>PERIKSA KEMBALI NIP, PNS TIDAK DITEMUKAN, ATAU DILUAR KEWENANGAN ANDA</span></h4>";
      }    
  }

  public function importperorangan() {
    $nip = $this->input->post('nip');
    $thn = $this->input->post('thn');
    $bln = $this->input->post('bln');
    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    // Cek apakah PNS tersebut berhak atas TPP
    $berhaktpp = $this->mkinerja->get_haktpp($nip); 
    if ($berhaktpp == 'YA') { 
          //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?thn='.$thn.'&bln='.$bln.'&nip='.$nip;
          //$url = 'https://ekinerja.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
          $url = 'http://ekinerja.bkppd.local/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
	  $konten = file_get_contents($url);
          $api = json_decode($konten);
          $jml = count($api);

          if ($konten == '{"hasil":[]}') {
            continue;
          }

          // TO DO : proses data dari DES Web Service
          if ($jml != 0) {            

            foreach($api->hasil as $d) :              
              if ($d->jabatan == null) $jabatan = ""; else $jabatan = $d->jabatan;
              if ($d->unit_kerja == null) $unit_kerja = ""; else $unit_kerja = $d->unit_kerja;
              if ($d->nama_atasan == null) $atasan_langsung = ""; else $atasan_langsung = $d->nama_atasan;

              $data = array(
              'nip'             => $nip,
              'bulan'           => $bln,
              'tahun'           => $thn,
              'nilai_skp'       => round($d->nilai_skp,2),
              'jabatan'         => $jabatan,
              'unit_kerja'      => $unit_kerja,
              'atasan_langsung' => $atasan_langsung,
              'login_terakhir'  => $d->login_terakhir,
              'import_by'       => $user,
              'import_at'       => $tgl_aksi
              );

              if ($this->mkinerja->cekada_kinerja_bulanan($nip, $thn, $bln) == 0) {
                if ($this->mkinerja->input_kinerja_bulanan($data)) {
                  $hasil = "BERHASIL";
                } else {
                  $hasil = "GAGAL";
                }
              } else {
                $where = array(
                  'nip'             => $nip,
                  'bulan'           => $bln,
                  'tahun'           => $thn
                ); 

                if ($this->mkinerja->update_kinerja_bulanan($where, $data)) {
                  $hasil= "BERHASIL";
                } else {
                  $hasil = "GAGAL";
                }
              }

            endforeach;
          }
      } 
      
    $nama = $this->mpegawai->getnama($nip);

    $data['pesan'] = $hasil." <b>IMPORT NILAI SKP </b>bulan ".bulan($bln)." Tahun ".$thn." A.n. ".$nama;
    $data['jnspesan'] = "alert alert-success";  

    $data['unker'] = $this->mkinerja->dd_unker()->result_array();
    //$data['content'] = 'kinerja/importdata';
    $data['content'] = 'kinerja/importdataperorangan';
    $this->load->view('template', $data);
  }
 
  // END IMPORT DATA KINERJA PERORANGAN

  // EDIT USUL PNS
  function editusulpns()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('level') == "ADMIN") {
      $idunker = $this->input->post('idunker');
      $thn = $this->input->post('thn');
      $bln = $this->input->post('bln');
      $nip = $this->input->post('nip');      
      $data['usul_tpp'] = $this->mkinerja->getdatausul($nip, $thn, $bln)->result_array();

      $data['idunker'] = $idunker;
      $data['nip'] = $nip;
      $data['thn'] = $thn;
      $data['bln'] = $bln;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'kinerja/editusulpns';
      $this->load->view('template',$data);
    }
  }

  function editusulpns_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));
    $idunker = addslashes($this->input->post('idunker'));

    $idgolru = $this->mhukdis->getidgolruterakhir($nip);    
    $idunker =  $this->mpegawai->getfidunker($nip);
    $idtingpen = $this->mkinerja->getidtingpenterakhir($nip);   
    $jabatan = $this->mpegawai->namajabnip($nip);
    
    $pengali = 0.77;
    $kelasjabatan = addslashes($this->input->post('kelasjabatan'));
    $nilaiskp = addslashes($this->input->post('kin'));   
    $nilai_absensi = addslashes($this->input->post('absen')); 
    $tppfull = $this->mkinerja->gettppfull($kelasjabatan);
    $tppbasic = $tppfull*$pengali;

    $nilaiskp60p = 0.6*$nilaiskp;
    $tpp_kinerja = addslashes($this->input->post('tppkin'));

    $nilaiabsensi40p = 0.4*$nilai_absensi;
    $tpp_absensi = addslashes($this->input->post('tppabs'));

    $jmltpp = $tpp_kinerja + $tpp_absensi;

    $status = $this->mpegawai->getstatpeg($nip);
    if ($status == "CPNS") {   
      $cpns = "YA";
      $tppbasic = (($tppfull*$pengali) * 80) / 100; // cpns hanya mendapat 80% dari TPP yg ditetapkan
    } else {
      $cpns = "TIDAK";  
    }

    $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
    if ($cekcutisakit == true) {
      $cutisakit = "YA";              
    } else {
      $cutisakit = "TIDAK";
    }

    $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);
    if ($cekcutibesar == true) {
      $cutibesar = "YA";              
    } else {
      $cutibesar = "TIDAK";
    }

    $cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
    // Ini ngurus PLT
    if ($cekplt == true) {
      $plt = "YA";
      
      $jabplt = $this->mkinerja->get_jabplt($nip);
      $unkerplt = $this->mkinerja->get_unkerplt($nip);
      $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
      $tppfull = $this->mkinerja->gettppfull($kelasjabplt);
      
      $tppbasic = $tppfull*$pengali; 

      $eselonplt = $this->mkinerja->get_eselonplt($nip);
      $eselonsaatini = $this->mpegawai->getfideselon($nip);
      if ($eselonplt == $eselonsaatini) {                   
        $tambahplt = ($jmltpp * 20) / 100;
      } else if ($eselonplt < $eselonsaatini) {
        $tambahplt = 0;
      }
    } else {
      $plt = "TIDAK";
      $jabplt = "";
      $unkerplt = "";
      $kelasjabplt = 0;
      $tambahplt = 0;
    }    

    $tambahsekda = addslashes($this->input->post('tambahsekda'));
    if ($tambahsekda != 0) {
      $sekda = "YA";
    } else {
      $sekda = "TIDAK";
    }

    $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
    if ($cekinspektorat == true) {
      $inspektorat = 'YA';
      $tambahinspektorat = ($jmltpp * 10) / 100; // tambahan 10 %
    } else {
      $inspektorat = 'TIDAK';
      $tambahinspektorat = 0;
    }
    
    $tambahbendahara = strtoupper(addslashes($this->input->post('tambahbendahara'))); 
    if ($tambahbendahara != 0) {
      $bendahara = "YA";
    } else {
      $bendahara = "TIDAK";
    }
    
    $tambahkelas1dan3 = addslashes($this->input->post('tambahkelas1dan3'));  
    if ($tambahkelas1dan3 != 0) {
      $kelas1dan3 = "YA";
    } else {
      $kelas1dan3 = "TIDAK";
    }

    $tambahtanpajfu = addslashes($this->input->post('tambahtanpajfu'));  
    if ($tambahtanpajfu != 0) {
      $tanpajfu = "YA";
    } else {
      $tanpajfu = "TIDAK";
    }

    $tambahpokja = addslashes($this->input->post('tambahpokja'));  
    if ($tambahpokja != 0) {
      $pokja = "YA";
    } else {
      $pokja = "TIDAK";
    }

    $tambahdokter = addslashes($this->input->post('tambahdokter'));  
    if ($tambahdokter != 0) {
      $dokter = "YA";
    } else {
      $dokter = "TIDAK";
    }

    $tambahradiografer = addslashes($this->input->post('tambahradiografer'));  
    if ($tambahradiografer != 0) {
      $radiografer = "YA";
    } else {
      $radiografer = "TIDAK";
    }

    $tambahterpencil = addslashes($this->input->post('tambahterpencil'));  
    if ($tambahterpencil != 0) {
      $terpencil = "YA";
    } else {
      $terpencil = "TIDAK";
    }

    $penambahan = $tambahplt + $tambahsekda + $tambahbendahara + $tambahkelas1dan3 + $tambahtanpajfu + $tambahpokja + $tambahdokter + $tambahradiografer + $tambahterpencil;
    $pengurangan = 0;
    $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
    $pajak = $this->hitungpajak($nip, $jmlbersih);
    $jmlditerima = $jmlbersih - $pajak;

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $pengali = 0.77;
    $created = $this->session->userdata('nip');
    $time = $this->mlogin->datetime_saatini();
    $data = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln,
      'jabatan'         => $jabatan,
      'fid_golru'       => $idgolru,
      'fid_unker'       => $idunker,
      'fid_tingpen'     => $idtingpen,
      'kelas_jab'       => $kelasjabatan,
      'pengali'         => $pengali,
      'tpp_basic'       => $tppbasic,
      'nilai_kinerja'   => $nilaiskp,
      'tpp_kinerja'     => $tpp_kinerja,
      'nilai_absensi'   => $nilai_absensi,
      'tpp_absensi'     => $tpp_absensi,            
      'jml_tpp_kotor'   => $jmltpp,
      'cuti_sakit'      => $cutisakit,
      'cuti_besar'      => $cutibesar,            
      'cpns'            => $cpns,         
      'bendahara'       => $bendahara, 
      'jml_tpp_bendahara'   => $tambahbendahara,
      'terpencil'           => $terpencil, 
      'jml_tpp_terpencil'   => $tambahterpencil,        
      'pokja'               => $pokja, 
      'jml_tpp_pokja'       => $tambahpokja,        
      'tanpajfu'            => $tanpajfu, 
      'jml_tpp_tanpajfu'    => $tambahtanpajfu,
      'dokter'              => $dokter, 
      'jml_tpp_dokter'      => $tambahdokter,
      'radiografer'         => $radiografer, 
      'jml_tpp_radiografer' => $tambahradiografer,
      'inspektorat'         => $inspektorat, 
      'jml_tpp_inspektorat' => $tambahinspektorat,
      'plt'                 => $plt,
      'plt_namajab'         => $jabplt,
      'plt_unker'           => $unkerplt,
      'plt_kelasjab'        => $kelasjabplt,
      'jml_tpp_plt'         => $tambahplt,
      'sekda'               => $sekda,
      'jml_tpp_sekda'       => $tambahsekda,                
      'kelas1dan3'          => $kelas1dan3,
      'jml_tpp_kelas1dan3'  => $tambahkelas1dan3,
      'jml_pengurangan'     => $pengurangan,
      'jml_penambahan'      => $penambahan,
      'jml_tpp_murni'       => $jmlbersih,
      'jml_pajak'           => $pajak,
      'tpp_diterima'        => $jmlditerima,  
      'update_at'            => $time,
      'update_by'            => $created
      );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln
      );           

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mkinerja->update_usultpp($where, $data)) {
        $data['pesan'] = "<b>SUKSES</b>, Data Usulan TPP Bulanan ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL DIUPDATE.";
        $data['jnspesan'] = "alert alert-success";  
      } else {
        $data['pesan'] = "<b>GAGAL</b>, Data Usulan TPP Bulanan ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL DIUPDATE.";
        $data['jnspesan'] = "alert alert-warning";
      }

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunker'] = $idunker;
    $data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomperunker';
    $this->load->view('template',$data);
  }
  
  // END EDIT USUL PNS

  // UNTUK TAMPIL HASIL IMPORT
  function cekhasilimport() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'kinerja/cekhasilimport';
      $this->load->view('template', $data);
    }
  }

  function showhasilimportbulanan() {
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    
    ?>
    <br/>
    <table class='table table-condensed table-hover' style='width: 80%'>
      <tr class='success'>
        <td align='center' width='10'><b>NO</b></td>      
        <td align='center' width='200'><b>UNIT KERJA</b></td>
        <td align='center' width='60'><b>JML<br/>PNS AKTIF</b></td>
        <td align='center' width='60'><b>JML<br/>BERHAK TPP</b></td>
        <td align='center' width='150'><b>JML<br/>DATA ABSENSI</b></td>
        <td align='center' width='150'><b>JML<br/>DATA KINERJA</b></td>
      </tr>
    <?php
    $dataunker = $this->mkinerja->dd_unker()->result_array();
    $no = 1;
    foreach($dataunker as $du) :      
      echo "<tr>";
      echo "<td align='center'>".$no."</td>";                           
      echo "<td>".$du['nama_unit_kerja']."</td>";
      $jmlaktif = $this->munker->getjmlpeg($du['id_unit_kerja']);                       
      echo "<td>".$jmlaktif."</td>";
      $jmlberhaktpp = $this->mkinerja->getjmlpeg_berhaktpp_perunker($du['id_unit_kerja']);         
      echo "<td>".$jmlberhaktpp."</td>";

      $jmlabsensi = $this->mkinerja->getjmlabsensi_perunker($du['id_unit_kerja'], $thn, $bln);
      if ($jmlberhaktpp != $jmlabsensi) {
        echo "<td class='danger'>".$jmlabsensi."</td>";
      } else {
        echo "<td>".$jmlabsensi."</td>";
      }
 
      $jmlkinerja = $this->mkinerja->getjmlkinerja_perunker($du['id_unit_kerja'], $thn, $bln);
      if ($jmlberhaktpp != $jmlkinerja) {
        echo "<td class='danger'>".$jmlkinerja."</td>";
      } else {
        echo "<td>".$jmlkinerja."</td>";
      }
      
      echo "</tr>";
      $no++;
    endforeach;  

    $datakec = $this->mpegawai->kecamatan()->result_array();                  
    foreach($datakec as $kc) :      
      echo "<tr>";
      echo "<td align='center'>".$no."</td>";    
      $kecamatan = $this->mpegawai->getnamakecamatan($kc['id_kecamatan']);                       
      echo "<td>SEKOLAHAN DI KEC. ".$kecamatan."</td>";
      $jmlaktif = $this->mkinerja->getjmlpegsekolah($kecamatan);   
      echo "<td>".$jmlaktif."</td>";                    
      
      $jmlberhaktpp = $this->mkinerja->getjmlpegsekolah_berhaktpp($kecamatan);         
      echo "<td>".$jmlberhaktpp."</td>";
      
      $jmlabsensi = $this->mkinerja->getjmlabsensisekolah_perkec($kecamatan, $thn, $bln);
      if ($jmlberhaktpp != $jmlabsensi) {
        echo "<td class='danger'>".$jmlabsensi."</td>";
      } else {
        echo "<td>".$jmlabsensi."</td>";
      }

      $jmlkinerja = $this->mkinerja->getjmlkinerjasekolah_perkec($kecamatan, $thn, $bln);
      if ($jmlberhaktpp != $jmlkinerja) {
        echo "<td class='danger'>".$jmlkinerja."</td>";
      } else {
        echo "<td>".$jmlkinerja."</td>";
      }
      echo "</tr>";
      $no++;
    endforeach; 

    echo "</table>";
  }
  // END TAMPIL HASIL IMPORT

  // START KALKULASI TPP MANDIRI
  function tampil_importhitung() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $hariini = date('d');
      if (($hariini >= 1) AND ($hariini <= 29)) {
        $data['unker'] = $this->mkinerja->dd_unker()->result_array();
        $data['unkes'] = $this->mpegawai->rsud_puskesmas()->result_array();
        $data['unsekolah'] = $this->mpegawai->kecamatan()->result_array();
        $data['pesan'] = '';
        $data['jnspesan'] = '';
        $data['status'] = 1;
      } else {
        $data['pesan'] = "IMPORT DATA ABSENSI HANYA DAPAT DILAKUKAN PADA TANGGAL 1 S/D 5 SETIAP BULAN";
        $data['jnspesan'] = 'alert alert-danger';
        $data['status'] = 0;
        //$data['content'] = 'content';
        //$this->load->view('template', $data);
      }      
    }
    $data['content'] = 'kinerja/importhitungmanual';
    $this->load->view('template', $data);
  }

  private $filename = "import_hitungtpp";
  public function formupload() {
    $data = array(); // Buat variabel $data sebagai array
    
    if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
      // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
      $upload = $this->mkinerja->upload_file($this->filename);
      
      if($upload['result'] == "success"){ // Jika proses upload sukses
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('exceltpp/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
        // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
        $data['sheet'] = $sheet; 
      }else{ // Jika proses upload gagal
        $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
      }
    }

    //$data['dataabsen'] = $this->mabsensi->tampilabsensi();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['status'] = 0;
    $data['content'] = 'kinerja/importhitungmanual';
    $this->load->view('template', $data);
  }

  public function import_hitungmanual(){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
    $excelreader = new PHPExcel_Reader_Excel2007();
    $loadexcel = $excelreader->load('exceltpp/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

    // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
    $data = array();
    
    $numrow = 1;
    $jml = 0;
    $bulanini = date('m');

    foreach($sheet as $row){
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){
        if ($row['A'] != "" or $row['B'] != "" or $row['F'] != "" or $row['G'] != "" or $row['I'] != "" or $row['G'] == $bulanini-1) {
          $idunker = $row['A'];
          $tahun = $row['F'];
          $bulan = $row['G'];
          // Cekapakah ada pengantar untuk usul ini
          //$pengantar = $this->mkinerja->unkertelahusul($idunker, $tahun, $bulan);          
          $pengantar = $this->mkinerja->unkertelahusul($idunker, $tahun, $bulan);
          
	  if (!$pengantar) { // tidak ada pengantar
            // BUAT PENGARTAR BARU
            // START QR CODE
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/qrcodekin/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            //$config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(0,0,0); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            // membuat nomor acak untuk data QRcode
            $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
            $string='';
            $pjg = 20; // jumlah karakter
            for ($i=0; $i < $pjg; $i++) {
              $pos = rand(0, strlen($karakter)-1);
              $string .= $karakter{$pos};
            }

            $image_name = $idunker."-".$tahun.$bulan.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

            $params['data'] = $idunker."-".$tahun.$bulan.$string; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

            // END QR CODE
	
	    $created = $this->session->userdata('nip');
	    if (!$created) {
	    	redirect(base_url('login'));
	    }
            $time = $this->mlogin->datetime_saatini();

            $pengantar = array(
            'fid_unker'       => $idunker,
            'tahun'           => $tahun,
            'bulan'           => $bulan,
            'status'          => "ENTRI",
            'entri_at'        => $time,
            'entri_by'        => $created,
            'qrcode'          => $params['data']
            );
            // tambahkan data pengantar
            $this->mkinerja->input_unkertpp($pengantar);
          }

          // End Buat Pengantar
          $nip = $row['B'];
          $jabatan = $row['E'];
          $kelas = $row['H'];
          $basic = $row['I'];
	  $indikator = $row['J'];
          $plt = strtoupper($row['K']);
          $tam_plt = $row['L'];
          $mk7h = strtoupper($row['M']);
          $ctk1b = strtoupper($row['N']);
          $ket = $row['O'];

          $statuspeg = $this->mpegawai->getstatpeg($nip);
	  if ($statuspeg == "CPNS") {
            $cpns = 'YA';
	    $basic = $basic * 0.8;
          } else {
            $cpns = 'TIDAK';
          }

          //START KINERJA
          $jnsjab = $this->mkinerja->get_jnsjab($nip);
          $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
          $nilai_skp = $this->mkinerja->get_realisasikinerja($nip, $tahun, $bulan);
          //if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH") OR (($keltugasjft == "KESEHATAN") AND ($plt == "YA"))) {
          if ($indikator == "AK") {
	    if ($nilai_skp >= 90) {
              $nilai_skp_pengali = 100;
              $kat_skp = "<span class='label label-primary'>SANGAT BAIK</span>";
            } else if (($nilai_skp >= 76) AND ($nilai_skp < 90)) {
              $nilai_skp_pengali = 90;
              $kat_skp = "<span class='label label-success'>BAIK</span>";
            } else if (($nilai_skp >= 61) AND ($nilai_skp < 76)) {
              $nilai_skp_pengali = 80;
              $kat_skp = "<span class='label label-warning'>CUKUP</span>";
            } else if (($nilai_skp >= 51) AND ($nilai_skp < 61)) {
              $nilai_skp_pengali = 70;
              $kat_skp = "<span class='label label-danger'>KURANG</span>";
            } else if (($nilai_skp >= 10) AND ($nilai_skp < 51)) {
              $nilai_skp_pengali = 40;
              $kat_skp = "<span class='label label-danger'>BURUK</span>";
            } else if ($nilai_skp < 10){
	      $nilai_skp_pengali = 0;
	      $kat_skp = "<span class='label label-danger'>DATA KINERJA TIDAK DITEMUKAN</span>";
	    }

            $nilaiskp60p = 0.6*$nilai_skp_pengali;
            //$tpp_kin = ($basic*round($nilaiskp60p,2))/100;
	    $tpp_kin = ($basic*$nilaiskp60p)/100;
	    //$tpp_kin = pembulatan_satuan($tpp_kin);
	    if ($mk7h == "YA") {
              $tpp_kin = $tpp_kin * 0.4; // Jika masuk kerja kurang dari 7 hari maka TPP Kinerja 40%
            }

            if ($ctk1b == "YA") {
              $tpp_kin = 0; // Jika masuk 1 bulan penuh, maka tpp kinerja 0
            }
          //} else if (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN")) { 
	  //} else if ((($keltugasjft == "KESEHATAN") AND ($plt == "TIDAK")) OR ($keltugasjft == "PENDIDIKAN")) {
	  } else if ($indikator == "A") {
		$tpp_kin = 0;
          }
	  $tpp_kin = pembulatan_satuan((int) $tpp_kin);
          //START KINERJA

          //START ABSENSI
          $jnsjab = $this->mkinerja->get_jnsjab($nip);
          $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);          
          $nilai_abs = $this->mkinerja->get_realisasiabsensi($nip, $tahun, $bulan);  
          //if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH") OR (($keltugasjft == "KESEHATAN") AND ($plt == "YA"))) {            
	  if ($indikator == "AK") {
            $nilaiabsensi40p = 0.4*$nilai_abs;
            $tpp_abs = ($basic*round($nilaiabsensi40p,2))/100;
          //} else if ((($keltugasjft == "KESEHATAN") AND ($plt == "TIDAK")) OR ($keltugasjft == "PENDIDIKAN")) { 
          } else if ($indikator == "A") {
	    $tpp_abs = ($basic*round($nilai_abs,2))/100;
          }
	  $tpp_abs = pembulatan_satuan((int) $tpp_abs);
          //END KINERJA
          
          $tpp_bruto = $tpp_kin + $tpp_abs;
          $tambahan = 0;
          if ($plt == 'YA') {
            if ($tam_plt != 0) { 
              $tambahan = $tambahan + $tam_plt;
              $tpp_bruto = $tpp_bruto + $tam_plt;
            }
          }
	 
	  // Hitung PPh
	  $status_ptkp =  $this->mkinerja->get_jnsptkp($nip);
	  $spesialis = $this->mkinerja->cekspesialis($nip);
          if ($spesialis == true) {
              $idgolru = $this->mpegawai->getidgolruterakhir($nip);
              if (($idgolru == "45") OR ($idgolru == "44") OR ($idgolru == "43") OR ($idgolru == "42") OR ($idgolru == "41")) {
                      $pph = $tpp_bruto * 0.15;
              } else if (($idgolru == "34") OR ($idgolru == "33") OR ($idgolru == "32") OR ($idgolru == "31")) {
                      $pph = $tpp_bruto * 0.05;
              }
          } else {
	      $pph = $this->hitungpph($nip, $tahun, $bulan, $tpp_bruto);
          }

	  // COBA pembulatan pph
	  $pph = pembulatan_satuan($pph);
          
          //if ($statuspeg == "CPNS") {
	  //  $cpns = 'YA';
	  //  $tpp_bruto = $tpp_bruto * 0.8;
          //  $tpp_netto = $tpp_bruto - $pph  - $iwp;
          //} else {
	  //  $cpns = 'TIDAK';
          $tpp_netto = round($tpp_bruto) - round($pph);
	  $iwp = $this->hitungiwp($nip, $tahun, $bulan, $tpp_netto);
	  
	  // COBA pembulatan IWP
	  $iwp = pembulatan_satuan($iwp);

	  $thp =  $tpp_netto - round($iwp);
          //}
	
	  $idgolru = $this->mpegawai->getidgolruterakhir($nip);
          $id_pengantar = $this->mkinerja->getidpengantar($idunker, $tahun, $bulan);
          $created = $this->session->userdata('nip');
	  if (!$created) {
          	redirect(base_url('login'));
          }
          $time = $this->mlogin->datetime_saatini();

          $data = array(
            'fid_pengantar'   => $id_pengantar,          
            'nip'             => $nip,
            'tahun'           => $tahun,
            'bulan'           => $bulan,
            'jabatan'         => $jabatan,
	    'fid_golru'       => $idgolru,
            'fid_unker'       => $idunker,
            'kelas_jab'       => $kelas,
            'tpp_basic'       => $basic,
            'nilai_kinerja'   => $nilai_skp,
            'tpp_kinerja'     => $tpp_kin,
            'nilai_absensi'   => $nilai_abs,
            'tpp_absensi'     => $tpp_abs,
	    'jml_tpp_kotor'   => $tpp_kin + $tpp_abs,
	    'cutitk_1bulan'   => $ctk1b,
            'plt'             => $plt,
            'jml_tpp_plt'     => $tam_plt,
            'jml_penambahan'  => $tambahan,
            'jml_tpp_murni'   => $tpp_bruto,
	    'cpns'	      => $cpns,
	    'status_ptkp'     => $status_ptkp,	
            'jml_pajak'       => $pph,
            'jml_iuran_bpjs'  => round($iwp),
            'tpp_diterima'    => round($thp),
	    'ket'	      => $ket,
            'entri_at'        => $time,
            'entri_by'        => $created
          );

          $where = array(
            'nip'             => $nip,
            'tahun'           => $tahun,
            'bulan'           => $bulan
          ); 

          // Cek apakah telah pernah usul
          if ($this->mkinerja->cektelahusul($nip, $tahun, $bulan) == 0) {
            $this->mkinerja->input_usultpp($data);
            $jml++;
          } else {
            $this->mkinerja->update_usultpp($where, $data);
            $jml++;
          }
        }
      }
      $numrow++; // Tambah 1 setiap kali looping
    }        
        
    $nmunker = $this->munker->getnamaunker($idunker);
    $data['content'] = 'kinerja/cariusul';
    $data['pesan'] = "Perhitungan TPP PNS pada ".$nmunker." periode ".bulan($bulan)." ".$tahun." sejumlah ".$jml." PNS BERHASIL DISIMPAN";
    $data['jnspesan'] = 'alert alert-info';
    $this->load->view('template', $data);
  }

  function hitungpph($nip, $thn, $bln, $tppbruto) {
    $gajibruto =  $this->mkinerja->get_gajibruto($nip, $thn, $bln);
    $jnsptkp =  $this->mkinerja->get_jnsptkp($nip);
    if (($jnsptkp == '') OR ($jnsptkp == null)) {
      // jika data ptkp kosong, maka dihitung TK/0
      $jnsptkp = 'TK/0';
      $ptkp =  $this->mkinerja->get_ptkp($jnsptkp);  
    } else {
      $ptkp =  $this->mkinerja->get_ptkp($jnsptkp);
    }


    $npwp =  $this->mkinerja->get_npwp($nip);

    $jmlpot =  $this->mkinerja->get_jmlpotongan($nip, $thn, $bln);

    $hasilbruto = $gajibruto + $tppbruto;
     // Biaya jabatan 5% maksimal 500ribu
    $biayajab = $hasilbruto * 0.05;
    if ($biayajab > 500000) {
      $biayajab = 500000;
    }

    $hasilnetto = $hasilbruto-($jmlpot + round($biayajab)); 
    $hasilnetto_tahun = $hasilnetto*12;
    
    $pkp = $hasilnetto_tahun - $ptkp;
    $pkp_b = pembulatan_ribuan(round($pkp));

    $pph = 0;
    if (($pkp_b >= 1) AND ($pkp_b <= 60000000)) {
      $pph = $pkp_b*0.05;
    } else if (($pkp_b > 60000000) AND ($pkp_b <= 250000000)) {
      $pph = $pph + 2500000 + (($pkp_b - 50000000) * 0.15);
    } else if (($pkp_b > 250000000) AND ($pkp_b <= 500000000)) {
      $pph = $pph + 32500000 + (($pkp_b-250000000) * 0.25);
    } else if ($pkp_b > 500000000) {
      $pph = $pph + 95000000 + (($pkp_b-500000000) * 0.30);
    }

    $pph_perbulan = $pph / 12;
    if ($npwp == '') {
             // jika NPWP tidak ada, maka PPh jadi 120%
      $pph_perbulan = $pph_perbulan * 1.2;
    }      

    $pphgaji = $this->mkinerja->get_pphgaji($nip, $thn, $bln);
    $pph_disetor = $pph_perbulan - $pphgaji;

    $created = $this->session->userdata('nip');
    $time = $this->mlogin->datetime_saatini();
    $data = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln,
      'tpp_bruto'       => $tppbruto,
      'gaji_bruto'      => $gajibruto,
      'biaya_jab'       => $biayajab,
      'jml_pot'         => $jmlpot,
      'peng_netto'      => $hasilnetto,
      'peng_netto_thn'  => $hasilnetto_tahun,
      'npwp'            => $npwp,
      'jns_ptkp'        => $jnsptkp,
      'ptkp'            => $ptkp,
      'pkp'             => $pkp,
      'pkp_bulat'       => $pkp_b,            
      'pph_tahun '      => $pph,
      'pph_bulan'       => $pph_disetor,
      'entri_at'        => $time,
      'entri_by'        => $created
      );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln
      );           

    if ($this->mkinerja->cekadapph($nip, $thn, $bln) == 0) {
      if ($this->mkinerja->input_pph($data)) {
        return round($pph_disetor);
      } else {
        return 0;
      }              
    } else {
      // pernah usul
      if ($this->mkinerja->update_pph($where, $data)) {
        return round($pph_disetor);
      } else {
        return 0;
      }
    }
  }

  function hitungiwp($nip, $thn, $bln, $tppbruto) {    
    // IWP
    $iwp_gaji =  $this->mkinerja->get_iwpgaji($nip, $thn, $bln);
    $iwp_tpp = $tppbruto*0.01; // IWP TPP 1% dari TPP bruto
    $iwp_total = $iwp_gaji + $iwp_tpp;
    if ($iwp_total > 120000) {
      $iwp_terhutang = 120000-$iwp_gaji;
    } else {
      $iwp_terhutang = $iwp_tpp;
    }
    // END IWP

    $data = array(
      'iwp_gaji'        => $iwp_gaji,            
      'iwp_tpp'         => $iwp_tpp,         
      'iwp_terhutang'   => $iwp_terhutang,  
      );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln
      );           

    if ($this->mkinerja->cekadapph($nip, $thn, $bln) == 0) {
      if ($this->mkinerja->input_pph($data)) {
        return round($iwp_terhutang);
      } else {
        return 0;
      }              
    } else {
      // pernah usul
      if ($this->mkinerja->update_pph($where, $data)) {
        return round($iwp_terhutang);
      } else {
        return 0;
      }
    }
  }

  public function export_tppmanual() {
    $idunker = $this->input->post('id_unker');
    $jns = $this->input->post('jns');

    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Wendy Ardhira')
                 ->setLastModifiedBy('Wendy Ardhira')
                 ->setTitle("Data Penerima TPP")
                 ->setSubject("PNS")
                 ->setDescription("Perhitungan TPP Kab. Balangan")
                 ->setKeywords("Data Penerima TPP PNS");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('size' => 10, 'bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'font' => array('size' => 9), // Set font nya jadi bold
      'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    //$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
    //$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    //$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    //$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
    //$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "ID"); // Set kolom A1 dengan tulisan "NO"
    // Warna Cell
    $excel->getSheet(0)->getStyle('A1:B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $excel->getSheet(0)->getStyle('A1:B1')->getFill()->getStartColor()->setRGB('FA8072'); 
    $excel->getSheet(0)->getStyle('F1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $excel->getSheet(0)->getStyle('F1:G1')->getFill()->getStartColor()->setRGB('FA8072'); // Merah Salmon
    $excel->getSheet(0)->getStyle('H1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $excel->getSheet(0)->getStyle('H1:I1')->getFill()->getStartColor()->setRGB('F0E68C'); // Kuning Khaki;
    $excel->getSheet(0)->getStyle('J1:N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $excel->getSheet(0)->getStyle('J1:N1')->getFill()->getStartColor()->setRGB('7FFFD4'); // Hijau Aquamarine;

    $excel->setActiveSheetIndex(0)->setCellValue('B1', "NIP"); // Set kolom B1 dengan tulisan "NIS"
    $excel->setActiveSheetIndex(0)->setCellValue('C1', "NAMA"); // Set kolom C1 dengan tulisan "NAMA"
    $excel->setActiveSheetIndex(0)->setCellValue('D1', "UNIT KERJA"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
    $excel->setActiveSheetIndex(0)->setCellValue('E1', "JABATAN DEFINITIF"); // Set kolom E1 dengan tulisan "ALAMAT"
    $excel->setActiveSheetIndex(0)->setCellValue('F1', "TAHUN");
    $excel->setActiveSheetIndex(0)->setCellValue('G1', "BULAN");
    $excel->setActiveSheetIndex(0)->setCellValue('H1', "KELAS");
    $excel->setActiveSheetIndex(0)->setCellValue('I1', "TPP BASIC");
    $excel->setActiveSheetIndex(0)->setCellValue('J1', "INDIKATOR");
    $excel->setActiveSheetIndex(0)->setCellValue('K1', "STATUS PLT");
    $excel->setActiveSheetIndex(0)->setCellValue('L1', "TAMBAHAN PLT");
    $excel->setActiveSheetIndex(0)->setCellValue('M1', "MK < 7H");
    $excel->setActiveSheetIndex(0)->setCellValue('N1', "CUTI/TK 1 BULAN");
    $excel->setActiveSheetIndex(0)->setCellValue('O1', "KETERANGAN");

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);    
    $excel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('L1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('M1')->applyFromArray($style_col);    
    $excel->getActiveSheet()->getStyle('N1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('O1')->applyFromArray($style_col);
    
    if ($jns == "pns") {
	if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104')OR ($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
      		$nmkecamatan = $this->mpegawai->getnamakecamatan($idunker);
      		$datatpp = $this->mkinerja->get_berhaktpp_sekolah($nmkecamatan)->result();
    	} else {
      		$datatpp = $this->mkinerja->get_berhaktpp($idunker)->result();
    	}
    } else if ($jns == "pppk") {
	if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104')OR ($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
        	$nmkecamatan = $this->mpegawai->getnamakecamatan($idunker);
        	$datatpp = $this->mkinerja_pppk->get_berhaktpp_sekolah($nmkecamatan)->result();
      	} else {
		$datatpp = $this->mkinerja_pppk->get_berhaktpp($idunker)->result();
	}    
    }
    
    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
    $blnini = date('m');
    $thnini = date('Y');
    foreach($datatpp as $data) {
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $idunker);
      $excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $data->nip, PHPExcel_Cell_DataType::TYPE_STRING);
      //$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nip);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->nama_unit_kerja);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->jabatan);
      $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $thnini);
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $blnini-1);
      $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->kelas);
      $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, "0");
      $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, "AK");
      $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, "TIDAK");
      $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, "0");
      $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, "TIDAK");
      $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, "TIDAK");

      // Warna Cell
      $excel->getSheet(0)->getStyle('A'.$numrow.':B'.$numrow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $excel->getSheet(0)->getStyle('A'.$numrow.':B'.$numrow)->getFill()->getStartColor()->setRGB('FA8072');
      $excel->getSheet(0)->getStyle('F'.$numrow.':G'.$numrow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $excel->getSheet(0)->getStyle('F'.$numrow.':G'.$numrow)->getFill()->getStartColor()->setRGB('FA8072'); // Merah Salmon
      $excel->getSheet(0)->getStyle('H'.$numrow.':J'.$numrow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $excel->getSheet(0)->getStyle('H'.$numrow.':J'.$numrow)->getFill()->getStartColor()->setRGB('F0E68C'); // Kuning Khakin
      $excel->getSheet(0)->getStyle('K'.$numrow.':O'.$numrow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $excel->getSheet(0)->getStyle('K'.$numrow.':O'.$numrow)->getFill()->getStartColor()->setRGB('7FFFD4'); // Hijau Aquamarine

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);

      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping
    }
    
    // Set width kolom
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(8); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);    
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
    $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
    $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);

    
    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $nmunker = $this->munker->getnamaunker($idunker);
    $excel->getActiveSheet(0)->setTitle("Daftar Penerima TPP.xlsx");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Daftar Penerima TPP.xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }
  // END KALKULASI TPP MANDIRI

}

/* End of file Akunpns.php */
/* Location: ./application/controllers/Akunpns.php */
