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
    $this->load->model('madmin');
    $this->load->model('munker');
    $this->load->model('mtakah');
    $this->load->model('mkinerja');
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
    $url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
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

            //$nilaiskp = 100;
            $nilaiskp = $this->getkinerjapernip_json($nip, $thn, $bln);
            
            //echo "#".$no."-".$nip."-".$nilaiskp;

            if ($nilaiskp > 100) {
              $nilaiskp=0;
            }

            $jabatan = $this->mkinerja->getnamajabatan($nip);
            
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
                if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) {
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
                $jmlditerima = $jmlbersih - $pajak;

                //$input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $pokja, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahbendahara, $tambahpokja, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, "cpns", $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);               

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
                $jmlditerima = $jmlbersih - $pajak;

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, "cuti", $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);
                               
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
                if ($eselonplt < $eselonsaatini) {
                  $jabplt = $this->mkinerja->get_jabplt($nip);
                  $unkerplt = $this->mkinerja->get_unkerplt($nip);
                  $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
                  $tppfull = $this->mkinerja->gettppfull($kelasjabplt);
                  $tambahplt = 0;
                }                
                
                $plt = 'YA';
                
                $tppbasic = $tppfull*$pengali;
               
                $nilaiskp60p = 0.6*$nilaiskp;
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
                $jmlditerima = $jmlbersih - $pajak;

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, "plt", $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);
                               
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
                $jmlditerima = $jmlbersih - $pajak;

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, "sekdakls13", $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }

                continue; 
              }
              // END UNTUK KELANGKAAN PROFESI


              // START UNTUK KONDISI KERJA
              //$cekradiografer = $this->mkinerja->cekradiografer($nip);cekinspektorat
              $cek_sdgpokja = $this->mkinerja->cek_sdgpokja($nip, $bln, $thn);
              $cek_sdgbendahara = $this->mkinerja->cek_sdgbendahara($nip, $bln, $thn);

              $ideselon = $this->mpegawai->getfideselon($nip);
              $namaeselon = $this->mpegawai->getnamaeselon($ideselon);

              // kondisi kerja tidak ada JFU S1 hanya berlaku untuk PNS Struktural eselon IV definitif
              if (($jnsjab == "STRUKTURAL") AND (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B'))) {
                $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
                $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
              } else {
                $cektidakadajfu = false;
              }
              
              if (($cek_sdgpokja == true) OR ($jabatan == "BENDAHARA") OR (($cek_sdgbendahara == true) AND ($jabatan == "PENGADMINISTRASI KEUANGAN")) OR ($cektidakadajfu == true)) {
                $tppbasic = $tppfull*$pengali; // cpns hanya mendapat 80% dari TPP yg ditetapkan
                
                $nilaiskp60p = 0.6*$nilaiskp;
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
                  if (($jabatan == "BENDAHARA") OR (($cek_sdgbendahara == true) AND ($jabatan == "PENGADMINISTRASI KEUANGAN"))) {
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
                
                  if ($cektidakadajfu == true) {
                    $tanpajfu ='YA';
                    $tambahtanpajfu = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $tanpajfu ='TIDAK';
                    $tambahtanpajfu = 0;
                  }

                  $cekinspektorat = $this->mkinerja->cekinspektorat($nip);
                  if ($cekinspektorat == true) {
                    $inspektorat = 'YA';
                    $tambahinspektorat = ($jmltpp * 10) / 100; // tambahan 10 %
                  } else {
                    $inspektorat = 'TIDAK';
                    $tambahinspektorat = 0;
                  }

                $radiografer = 'TIDAK'; $tambahradiografer = 0;

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
                $jmlditerima = $jmlbersih - $pajak;

                $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, "bendnonjfu", $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }
                continue;
              }
              // END UNTUK KONDISI KERJA            

            // UNTUK KONDISI NORMAL TANPA INDIKATOR TAMBAHAN 
            /*
            $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
            if (($keltugasjft == "PENDIDIKAN") OR ($keltugasjft == "KESEHATAN")) {
              $nilaiskp60p = 0;
              $tpp_kinerja = 0;
            } else {
              $nilaiskp60p = (60/100)*$nilaiskp;
              $tpp_kinerja = (number_format($nilaiskp60p,2)/100)*$tppbasic;                  
            }
            */

            $tppbasic = $tppfull*$pengali;

            $nilaiskp60p = 0.6*$nilaiskp;
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
            $jmlditerima = $jmlbersih - $pajak;

            $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, "normal", $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat,$plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);

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

  function tambahusul($idpengantar, $nip, $tahun, $bulan, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat, $plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima) {
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
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
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
    if (($thn != 0) AND ($bln != 0)) {
    ?>
      <div style='padding-right:40px; padding-bottom: 20px; margin-top:20px'>
        <div class="col-md-7" align='center'></div>
        <div class="col-md-2" align='center'>
          <form method="POST" action="../kinerja/tambahusulunker">                
                <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
                <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
                <button type="submit" class="btn btn-danger btn-outline btn-sm">
                  <span class="fa fa-shield" aria-hidden="true"></span> Tambah TPP Tenaga TEKNIS
                </button>
              </form>
        </div>

        <div class="col-md-2" align='center'>
          <form method="POST" action="../kinerja/tambahusulsekolah">                
                <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
                <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
                <button type="submit" class="btn btn-warning btn-outline btn-sm">
                  <span class="fa fa-university" aria-hidden="true"></span> Tambah TPP Tenaga PENDIDIK
                </button>
              </form>
        </div>

        <div class="col-md-1" align="center">
          <form method="POST" action="../kinerja/cetakrekap_perperiode" target='_blank'>                
                <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
                <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
                <button type="submit" class="btn btn-success btn-sm">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Rekapitulasi
                </button>
              </form>
        </div>
      </div>     
    <?php
    }
    ?>

    <table class="table table-condensed table-hover"  style="font-size: 11px; margin-top:20px">
      <thead>
      <tr class='info'>
        <td align='center' width='20'><b>No</b></td>
        <td align='center' width='400'><b>UNIT KERJA</b></td>
        <td align='center' width='100'><b>KINERJA | ABSENSI</b></td>
        <td align='center' width='100'><b>JUMLAH<br/>USULAN</b></td>
        <td align='center' width='100'><b>TOTAL<br/>TPP REALISASI</b></td>        
        <td align='center' width='100'><b>TOTAL<br/>TAMBAHAN</b></td>
        <td align='center' width='100'><b>TOTAL<br/>SEBELUM PAJAK</b></td>
        <td align='center' width='100'><b>TOTAL<br/>PAJAK</b></td>
        <td align='center' width='100'><b>TOTAL<br/>TPP DIBAYARKAN</b></td>
        <td align='center' width='170'><b>DIUSULKAN OLEH</b></td>
        <td align='center' width='30' colspan='3'><b>AKSI</b></td>
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
        if ($v['fid_unker'] == '12345') {
          $namaunker = "TK, SD, SMP SEDERAJAT";
        } else {
          $namaunker = $this->munker->getnamaunker($v['fid_unker']);
        }
        echo "<td>".$namaunker."</td>";
        //$ratakinerja = $this->mkinerja->getratakinerja($v['fid_unker'], $thn, $bln);
        //$rataabsensi = $this->mkinerja->getrataabsensi($v['fid_unker'], $thn, $bln);
        //echo "<td align='center'>".number_format($ratakinerja,2)."<br/>".number_format($rataabsensi,2)."</td>";
        //$jmlusul = $this->mkinerja->getjumlahusul($v['fid_unker'], $thn, $bln);
        //echo "<td align='center'>".$jmlusul." PNS</td>";
        echo "<td align='center'>".number_format($v['rata_kinerja'],2)."<br/>".number_format($v['rata_absensi'],2)."</td>";
        echo "<td align='center'>".$v['totpns']."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottppkotor'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottambahan'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottpp_sebelumpajak'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['totpajak'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottpp_dibayar'],0,",",".")."</td>";
        
        //$jmltppditerima = $this->mkinerja->gettotaltppditerima($v['fid_unker'], $thn, $bln);
        //echo "<td align='right'>Rp. ".number_format($jmltppditerima,0,",",".")."</td>";
        echo "<td><small>".tglwaktu_indo($v['entri_at'])."<br/>".$this->mpegawai->getnama($v['entri_by'])."</small></td>";        
        ?>
        <td align='center' width='30'>
          <?php
          if ($v['fid_unker'] == '12345') {
            echo "<form method='POST' action='../kinerja/detail_pengantar_sekolahan'>";          
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";         
            echo "<button type='submit' class='btn btn-primary btn-xs'>";
            echo "<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<form method='POST' action='../kinerja/detail_pengantar'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";         
            echo "<button type='submit' class='btn btn-primary btn-outline btn-xs'>";
            echo "<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          }
          ?>
        </td>
        <td align='center' width='30'>
          <?php
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
          ?>
        </td>
        <?php
        $no++;
        //$totaltpp = $totaltpp + $jmltppditerima;
        echo "</tr>";
      endforeach;
      ?>
      </tbody>    
    </table>

    <table class='table table-striped'>
        <tr>
        <td width='33%' style='padding: 10px;'>
        <?php
          $jmlpns = $this->mkinerja->totusul_perperiode($thn, $bln);
          $tottppkotor = $this->mkinerja->tottppkotor_perperiode($thn, $bln);
          $tottambahan = $this->mkinerja->tottambahan_perperiode($thn, $bln);
          $tottppmurni = $this->mkinerja->tottppmurni_perperiode($thn, $bln);
          $totpajak = $this->mkinerja->totpajak_perperiode($thn, $bln);
          $tottppditerima = $this->mkinerja->tottppditerima_perperiode($thn, $bln);
        ?>
          Jumlah PNS 
          <span class='pull-right text-muted'><b>
          <?php echo $jmlpns." Orang"; ?></b></span><br/>
          
          Total TPP Sesuai Realisasi 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppkotor,0,",","."); ?></b></span><br/>

          Total Tambahan
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottambahan,0,",","."); ?></b></span><br/>

          Total TPP + Tambahan (Sebelum Pajak) 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppmurni,0,",","."); ?></b></span><br/>


          Total Pajak 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($totpajak,0,",","."); ?></b></span><br/>

          Total TPP yang Dibayarkan 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerima,0,",","."); ?></b></span><br/>
        </td>
        <td width='33%' style='padding: 10px;'>
          <b>TOTAL TPP YANG DIBAYARKAN : </b><br/>
          <?php
            $tottppditerimagol4 = $this->mkinerja->tottppditerima_perperiode_gol4($thn, $bln);
            $tottppditerimagol3 = $this->mkinerja->tottppditerima_perperiode_gol3($thn, $bln);
            $tottppditerimagol2 = $this->mkinerja->tottppditerima_perperiode_gol2($thn, $bln);
            $tottppditerimagol1 = $this->mkinerja->tottppditerima_perperiode_gol1($thn, $bln);
          ?>
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
        </td>
        <td width='33%' style='padding: 10px;'>
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
        </td>    
        </tr>
      </table> 
    <?php
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

    $data['content'] = 'kinerja/nomperunker';
    $this->load->view('template',$data);
  }

  function detail_pengantar_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['idpengantar'] = $idpengantar;
    $data['nmunker'] = "SEKOLAHAN";
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan';
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

    $data['content'] = 'kinerja/nomperunker';
    $this->load->view('template',$data);
  }

  function hapus_usul_sekolahan(){
    $idpengantar = addslashes($this->input->post('idpengantar'));    
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
            if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
              $kelasjab = 8; 
            } else {
              $kelasjab = 9;
            }
          } else {
            $kelasjab = $this->mkinerja->get_kelasjabstruk($nip);
          }
        } else if ($jnsjab == "FUNGSIONAL UMUM") {
          $kelasjab = $this->mkinerja->get_kelasjabfu($nip);
        } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
          $kelasjab = $this->mkinerja->get_kelasjabft($nip);
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
      echo " <b>(Kelas ".$kelasjab.")</b>";
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
        $url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
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
          <button type='submit' class='btn btn-warning btn-sm' onCLick="showKalkulasi(nippns.value, <?php echo $thn.",".$bln.",".$kelasjab; ?>, kin.value, absen.value)">
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
    $jmlditerima = $jmlbersih - $pajak;

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
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

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
    $data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomperunker';
    $this->load->view('template',$data);
  }

  public function cetakrekapunor_perperiode()  
  {
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));
    $status = "CETAK";  // status cuti : CETAUKUSUL

      // update status cuti : CETAKUSUL => 2
    $data = array(      
      'status'      => $status
      );

    $where = array(
      'fid_unker' => $idunker,
      'tahun'     => $thn,
      'bulan'     => $bln
      );

    if ($this->mkinerja->update_pengantartpp($where, $data))
    {
      $res['idunker'] = $idunker;
      $res['thn'] = $thn;
      $res['bln'] = $bln;
      $res['data'] = $this->mkinerja->tampil_usultpp($idunker, $thn, $bln)->result();
      
      $this->load->view('/kinerja/cetakrekapunorperiode',$res);  
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
      'status'      => $status
      );

    $where = array(
      'fid_unker'        => $idunker,
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
   function statistika()
    {
      if ($this->session->userdata('level') == "ADMIN") {
        //$data['grafik'] = $this->mcuti->getjmlprosesbystatusgraphcuti();
        //$data['thncuti'] = $this->mcuti->gettahunrwycuti()->result_array(); 
        $data['rwyperbulan'] = $this->mkinerja->getjmlrwyperbulan(); 
        $data['content'] = 'kinerja/statistika';
        $this->load->view('template',$data);
      }
    }

  // End Statistika

  function tambahusulsekolah() { 
    $idunker = '12345'; // ID Unker untuk semua sekolah
    $thn = $this->input->post('tahun');
    $bln = $this->input->post('bulan');
    
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
          'entri_at'        => $time,
          'entri_by'        => $created,
          'qrcode'          => $params['data']
          );
        // tambahkan data pengantar
        $this->mkinerja->input_unkertpp($pengantar);


        $idpengantar = $this->mkinerja->getidpengantar($idunker, $thn, $bln);

        $datapns = $this->mkinerja->datapnssekolah()->result_array();
        $berhasil = 0;
        $gagal = 0;
        
        foreach($datapns as $dp) :

          //$url = 'http://localhost/silka/assets/kinerja2019sekolahan.json';
          //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?nip='.$dp['nip'].'&thn='.$thn.'&bln='.$bln;
          $url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$dp['nip'].'&thn='.$thn.'&bln='.$bln;
	  $konten = file_get_contents($url);
          $api = json_decode($konten);
          $jml = count($api);

          $i = 0; 
          // TO DO : proses data dari DES Web Service
          if ($jml != 0) {
            $no = 1;            
            foreach($api->hasil as $d) :
              //$nip = $api->hasil[$i]->nip;
              $nip = $d->nip;
              $idunker = $dp['id_unit_kerja'];
              
              //$nilaiskp = $api->hasil[$i]->nilai_skp; // hasil adalah array response dari api pada server sebelah
              $nilaiskp = $d->nilai_skp;

              // Cek apakah PNS tersebut berhak atas TPP
              $berhaktpp = $this->mkinerja->get_haktpp($nip); 
              if (($nilaiskp != null) AND ($berhaktpp == 'YA')) {
                
                // jika nilai_skp lebih dari 100, maka nilai_skp = NOL, karena terdapat kesalahan pengentrian laporan kinerja
                if ($nilaiskp > 100) {
                  $nilaiskp=0;
                }

                $jabatan = $this->mkinerja->getnamajabatan($nip);
                $tahun = $d->tahun;
                $bulan = $d->bulan;

                $nilai_absensi = $this->mkinerja->get_realisasiabsensi($nip, $tahun, $bulan);

                $idtingpen = $this->mkinerja->getidtingpenterakhir($nip);              

                $idgolru = $this->mhukdis->getidgolruterakhir($nip);
                $golru = $this->mpegawai->getnamagolru($idgolru);

                $jnsjab = $this->mkinerja->get_jnsjab($nip);
                $cekterpencil = $this->mkinerja->cek_terpencil($idunker);

                $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
               
                // SET TPP FULL DISINI
                $pengali = 0.77;
                $tppfull = $this->mkinerja->gettppfull($kelasjabatan);

                $tppbasic = $tppfull*$pengali;

                $nilaiskp60p = 0.6*$nilaiskp;
                $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
                $tpp_kinerja = pembulatan(round($tpp_kinerja,0));

                $nilaiabsensi40p = 0.4*$nilai_absensi;
                $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
                $tpp_absensi = pembulatan(round($tpp_absensi,0));

                $jmltpp = $tpp_kinerja + $tpp_absensi; // TPP sesuai realisasi
                $cutisakit = 'TIDAK';
                $cutibesar = 'TIDAK';
                $cpns = 'TIDAK';
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
                $pajak = $this->hitungpajak($nip, $jmlbersih);
                $jmlditerima = $jmlbersih - $pajak;

                $input = $this->tambahusul($idpengantar, $nip, $tahun, $bulan, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $cutisakit, $cutibesar, $cpns, $bendahara, $tambahbendahara, $terpencil, $tambahterpencil, $pokja, $tambahpokja, $tanpajfu, $tambahtanpajfu, $radiografer, $tambahradiografer, $inspektorat, $tambahinspektorat,$plt, $jabplt, $unkerplt, $kelasjabplt, $tambahplt, $sekda, $tambahsekda, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);
                               
                if ($input == true) {
                  $berhasil++;
                } else if ($input == false) {
                  $gagal++;
                }

              $no++;
              }
            endforeach; // end $jml
          }
        endforeach; // end $datapns

          $data['thn'] = $thn;
          $data['bln'] = $bln;          

          $data['idunker'] = $idunker;
          $data['nmunker'] = $this->munker->getnamaunker($idunker);
          $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
          $data['pesan'] = "<b>SUKSES</b>, Data Realisasi Kinerja Bulanan SEKOLAH Periode ".bulan($bln)." ".$thn.".<br/>".$berhasil." data BERHASIL ditambahkan, dan ".$gagal." data GAGAL ditambahkan";
          $data['jnspesan'] = "alert alert-success";

          $data['idpengantar'] = $idpengantar;
          $data['nmunker'] = "SEKOLAHAN";
          $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
          $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();


          $data['content'] = 'kinerja/nomsekolahan';
          $this->load->view('template',$data);
        // END : proses data dari DES Web Service
        
      }
  }

  function simpankalkulasi_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $idunker = '12345'; // ID untuk rakapan sekolahan

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
      'fid_unker'       => $idunker,
      'tahun'           => $thn,
      'bulan'           => $bln,
      );           

    $namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP SEKOLAHAN Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP SEKOLAHAN Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idpengantar'] = $idpengantar;
    $data['idunker'] = $idunker;
    $data['nmunker'] = "SEKOLAHAN";
    $data['jmlpeg'] = $this->mkinerja->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan';
    $this->load->view('template',$data);
  }

  // START UNTUK IMPORT DATA KINERJA DARI JSON
  function tampilimport() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'kinerja/importdata';
      $this->load->view('template', $data);
    }
  }

  function tampilhasilimport() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
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
    
    ?>
    <br/>
    <small>
    <table class='table table-condensed table-hover' style='width: 80%'>
      <tr class='info'>
        <td align='center' rowspan='2' width='10'><b>NO</b></td>      
        <td align='center' rowspan='2' width='150'><b>NIP</b></td>
        <td align='center' colspan='4'><b>DATA PADA APLIKASI E-KINERJA</b></td>
      </tr>
      <tr class='info'>
        <td align='center' width='300'><b>JABATAN | UNIT KERJA</b></td>
        <td align='center' width='150'><b>ATASAN LANGSUNG</b></td>
        <td align='center' width='50'><b>NILAI SKP</b></td>
        <td align='center' width='120'><b>LOGIN TERAKHIR</b></td>
      </tr>
    <?php
    
    $datapns = $this->munker->pegperunker($idunker)->result_array();
    $berhasil = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;

    $nmunker = $this->munker->getnamaunker($idunker);

    $no = 1;
    foreach($datapns as $dp) :      
      $nip = $dp['nip'];
      // untuk pengecekan
      //$nama = $this->mpegawai->getnama($nip);
      //echo "<br/>".$no."-".$nip."/".$nama;
      // Cek apakah PNS tersebut berhak atas TPP
      $berhaktpp = $this->mkinerja->get_haktpp($nip); 
      echo "<tr>";
      echo "<td align='center'>".$no."</td>";                           
      echo "<td>NIP. ".$dp['nip']."<br/>".$this->mpegawai->getnama($dp['nip'])."</td>";            

      if ($berhaktpp == 'YA') { 
          //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?thn='.$thn.'&bln='.$bln.'&nip='.$nip;
	  $url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln;
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
      echo "</tr>";
      $no++;
    endforeach;    

    echo "</table>";

    echo "<div class='row'>";    
    echo "<div class='col-md-4' align='right'>";
      echo "<h5><span class='label label-info'>Jumlah : ".$no."</span></h5>";
    echo "</div><div class='col-md-1' align='right'>";
      echo "<h5><span class='label label-success'>Data Valid : ".$berhasil."</span></h5>";
    echo "</div><div class='col-md-2' align='center'>";
      echo "<h5><span class='label label-warning'>Data Tidak ditemukan : ".$tidakditemukan."</span></h5>";
    echo "</div><div class='col-md-1' align='center'>";
      echo "<h5><span class='label label-danger'>Tidak berhak TPP : ".$tidaktpp."</span></h5>";
    echo "</div>";    
    echo "<div class='col-md-2'>";
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
          echo "<form method='POST' action='../kinerja/import'>                
                <input type='hidden' name='idunker' id='idunker' maxlength='10' value='".$idunker."'>
                <input type='hidden' name='thn' id='thn' maxlength='4' value='".$thn."'>
                <input type='hidden' name='bln' id='bln' maxlength='4' value='".$bln."'>
                <button type='submit' class='btn btn-info btn-sm'>
                  <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspImport
                </button>
              </form>";
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
    
    $datapns = $this->munker->pegperunker($idunker)->result_array();
    $berhasil = 0;
    $gagal = 0;
    $nmunker = $this->munker->getnamaunker($idunker);

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $no = 1;
    foreach($datapns as $dp) :      
      $nip = $dp['nip'];
      
      // Cek apakah PNS tersebut berhak atas TPP
      $berhaktpp = $this->mkinerja->get_haktpp($nip); 
      if ($berhaktpp == 'YA') { 
          //$url = 'http://localhost/expneo-baru/index.php/c_api/get_skp_blnnip_silka?thn='.$thn.'&bln='.$bln.'&nip='.$nip;
	  $url = 'http://ekinerja-training.bkppd-balangankab.info/c_api/get_skp_blnnip_silka?nip='.$nip.'&thn='.$thn.'&bln='.$bln; 
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

            endforeach;
          }
      } 
      
    endforeach;

    $data['pesan'] = "<b>IMPORTING REALISASI KINERJA BULANAN DARI APLIKASI E-KINERJA</b>, ".$nmunker." bulan ".bulan($bln)." Tahun ".$thn."<br/>".$berhasil." Data berhasil disimpan, ".$gagal." Data gagal disimpan";
    $data['jnspesan'] = "alert alert-success";  

    $data['unker'] = $this->mkinerja->dd_unker()->result_array();
    $data['content'] = 'kinerja/importdata';
    $this->load->view('template', $data);
  }
 
  function showhasilkinbulanan() {
    $idunker = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    
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
    
    $datapns = $this->munker->pegperunker($idunker)->result_array();
    $ditemukan = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;

    $no = 1;
    foreach($datapns as $dp) :      
      $nip = $dp['nip'];
      // untuk pengecekan

      echo "<tr>";
      echo "<td align='center'>".$no."</td>";                           
      echo "<td>NIP. ".$nip."<br/>".$this->mpegawai->getnama($nip)."</td>";            

      $berhaktpp = $this->mkinerja->get_haktpp($nip); 
      if ($berhaktpp == 'YA') {
        $datakin = $this->mkinerja->get_kinerja_bulanan_bynip($nip, $thn, $bln)->result_array();
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

}

/* End of file Akunpns.php */
/* Location: ./application/controllers/Akunpns.php */
