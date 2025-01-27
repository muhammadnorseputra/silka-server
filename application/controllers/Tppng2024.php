<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tppng2024 extends CI_Controller {

  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('fungsitanggal');    
    $this->load->helper('fungsiterbilang');
    $this->load->helper('fungsipegawai');
    $this->load->model('mpegawai');;
    $this->load->model('mabsensi');
    $this->load->model('mpppk');
    //$this->load->model('mpppk');
    //$this->load->model('madmin');
    $this->load->model('mtppng2024');    
    $this->load->model('munker');
    $this->load->model('mpetajab');
    $this->load->model('mkinerja');
    $this->load->model('mkinerja_pppk');
    //$this->load->model('mhukdis');

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

  function periode() {
    $data['content'] = 'tppng2024/periode';
    $data['periode'] = $this->mtppng2024->periode()->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $this->load->view('template', $data);
  }

  function periode2025() {
    $data['content'] = 'tppng2024/periode2025';
    $data['periode'] = $this->mtppng2024->periode2025()->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $this->load->view('template', $data);
  }

  function detailperiode() {
    $idperiode = addslashes($this->input->post('id_periode'));
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->get_pengantar($idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiode';
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $this->load->view('template', $data);
  }

  function detailperiodeunor() {
    $idperiode = addslashes($this->input->post('id_periode'));
    $idpengantar = addslashes($this->input->post('id_pengantar'));
    $idunor = addslashes($this->input->post('id_unor'));
    $data['idunor'] = $idunor;
    $data['idpengantar'] = $idpengantar;
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiodeunor';
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $this->load->view('template', $data);
  }

  function kirim_tandaterima() {
    $i = $this->input->post();

    $idpengantar = $i['idpengantar']; 
    $idperiode = $i['idperiode']; 
    $idunor = $i['id_unor'];
    
    $nospm = $i['nospm']; 
    $tglspm = tgl_sql($i['tglspm']); 
    $nosp2d = $i['nosp2d']; 
    $tglsp2d = tgl_sql($i['tglsp2d']); 
    $jml_dipinta = $i['jml_dipinta']; 
    $jml_potongan = $i['jml_potongan']; 
    $jml_dibayar = $i['jml_dibayar'];
    
    $nmberkaslama = $i['berkaslama'];

    $this->load->library('upload');
    // membuat nomor acak untuk nama file
    $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $string='';
    $pjg = 17;
    for ($i=0; $i < $pjg; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};
    }

    $nmfile = $idunor."-".$idpengantar."-".$idperiode."-".$string; 
    $config['upload_path'] = './filetppng2024/'; //Folder untuk menyimpan hasil upload
    $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
    $config['max_size'] = 1024 * 1.5; //maksimum besar file 1.5M
    $config['file_name'] = $nmfile; //nama yang terupload nantinya

    $this->upload->initialize($config);

    if($_FILES['berkastppng_pengantar']['name'])
        {            
          if ($this->upload->do_upload('berkastppng_pengantar'))
          {
              $dataupload = $this->upload->data();
              $data = array(
                'namafile' =>$dataupload['file_name'],
                'type' =>$dataupload['file_type'],
                'keterangan' =>$this->input->post('textket')
              );                
              $datatodb = array(      
                'berkas'   => $nmfile,
                'jml_dibayar' => addslashes(str_replace(".", "", $jml_dibayar)),
                'jml_potongan' => addslashes(str_replace(".", "", $jml_potongan)),
                'jml_diminta' => addslashes(str_replace(".", "", $jml_dipinta)),
                'tgl_sp2d' => $tglsp2d,
                'no_sp2d' => $nosp2d,
                'tgl_spm' => $tglspm,
                'no_spm' => $nospm,
                'status' => 'SELESAI'
              );

              $where = array(
                'fid_periode' => $idperiode,
                'fid_unker' => $idunor,
                'id' => $idpengantar
              );

              $this->mtppng2024->update_pembayaran($where, $datatodb);
              $this->mtppng2024->update_status('tppng', ['fid_status' => 6], ['fid_pengantar' => $idpengantar]);

              if (file_exists('./filetppng2024/'.$nmberkaslama.'.pdf')) {
                unlink('./filetppng2024/'.$nmberkaslama.'.pdf');
              } elseif (file_exists('./filetppng2024/'.$nmberkaslama.'.PDF')) {
                      unlink('./filetppng2024/'.$nmberkaslama.'.PDF');
              }	

              //pesan yang muncul jika berhasil diupload pada session flashdata
              //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
              
              //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
              $data['pesan'] = '<b>Sukses</b>, Formulir Bukti Pembayaran Berhasil Dikirim.';
              $data['jnspesan'] = 'alert alert-success';
          } else{
              //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
              //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
              
              //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
              $data['pesan'] = '<b>Gagal</b>, Formulir Bukti Pembayaran Gagal Dikirim.';
              $data['jnspesan'] = 'alert alert-danger';
          }
      } else {
          //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
          $data['pesan'] = '<b>Gagal</b>, Formulir Bukti Pembayaran Gagal Upload.';
          $data['jnspesan'] = 'alert alert-danger';
      }
      $data['idunor'] = $idunor;
      $data['idpengantar'] = $idpengantar;
      $data['idperiode'] = $idperiode;
      $data['data'] = $this->mtppng2024->tampil_tppng($idpengantar, $idperiode)->result_array();
      $data['content'] = 'tppng2024/detailperiodeunor';
      $this->load->view('template', $data);
  }

  function tampilkalkulasi() {
    $nip = addslashes($this->input->get('nip'));
    $idpengantar = addslashes($this->input->get('idpengantar'));    
    $idperiode = addslashes($this->input->get('idperiode'));
    $idjabpeta = addslashes($this->input->get('idjabpeta'));
    $idjabpltpeta = addslashes($this->input->get('idjabpltpeta'));
    $jnsplt = addslashes($this->input->get('jnsplt'));
    $pengurang = addslashes($this->input->get('pengurang'));
	
    $blnperiode = $this->mtppng2024->get_bulanperiode($idperiode);
    $thnperiode = $this->mtppng2024->get_tahunperiode($idperiode); 

    $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $nama = $this->mpegawai->getnama($nip);
      $id_unker_nip = $this->mtppng2024->get_idunker_pns($nip);
    } else if ($jnsasn == "PPPK") {
      $nama = $this->mpppk->getnama($nip);
      $id_unker_nip = $this->mtppng2024->get_idunker_pppk($nip);
    }

    $telahusul = $this->mtppng2024->cektelahusul($nip, $thnperiode, $blnperiode);
    //$id_unker_nip = $this->mkinerja->get_idunker($nip);
    $id_unker_pengantar = $this->mtppng2024->get_idunker($idpengantar);

    if (!$nama) {
      echo "<div align='center' class='text text-warning'>Data tidak ditemukan, cek kembali data NIP.</div>";
    } else if ($id_unker_nip != $id_unker_pengantar) {
      echo "<div align='center' class='text text-primary'>PNS bukan ASN pada ".$this->munker->getnamaunker($id_unker_pengantar)."</div>";
    } else if ($telahusul != '0') {
      echo "<div align='center' class='text text-info'>TPP Bulan ".bulan($blnperiode)." ".$thnperiode." A.n. ".$nama."  TELAH DIHITUNG.
            <br/> Kalau ingin Hitung Ulang, hapus dulu perhitungan sebelumnya.</div>";
    } else {
        if ($jnsasn == "PNS") {
          $statpeg = $this->mpegawai->getstatpeg($nip);
          $idgolru = $this->mpetajab->getidgolru($nip);
          $golru = $this->mpegawai->getnamagolru($idgolru);
          $pangkat = $this->mpegawai->getnamapangkat($idgolru);
          $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);
          $npwp = $this->mkinerja->get_npwp($nip);
	  $jnsptkp = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode); // Ambil jenis PTKP dari Data Gaji	
          //$jnsptkp = $this->mtppng2024->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga        
        } else if ($jnsasn == "PPPK") {
          $statpeg = "PPPK";
          $idgolru = $this->mpppk->getidgolruterakhir($nip);
          $golru = $this->mpppk->getnamagolru($idgolru);
          $pangkat = "";
          $tmtjab = "";
          $npwp = $this->mkinerja_pppk->get_npwp($nip);;
          //$jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
	  $jnsptkp = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode); // Ambil jenis PTKP dari Data Gaji
        }

        if (($jnsplt == 'plt100') AND ($idjabpltpeta != '')) {
          $kelasjab = $this->mpetajab->get_kelas($idjabpltpeta);
        } else {
          $kelasjab = $this->mpetajab->get_kelas($idjabpeta);  
        }
        //echo "<br/>";
	$nmjab_atasan = $this->mpetajab->get_namajabatasan($idjabpeta);
        echo "<div class='row'>";
        echo "<div class='col-md-6'>
                <div class='well well-sm' style='font-size: 11px;'>
                <span class='text text-success'><b>IDENTITAS</b></span>
                  <div class='row'>
                    <div class='col-md-4'><b>NAMA</b></div>
                    <div class='col-md-8' align='left'>".$nama."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>STATUS</b></div>
                    <div class='col-md-8' align='left'>".$statpeg."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>PANGKAT/GOLRU</b></div>
                    <div class='col-md-8' align='left'>".$golru." (".$pangkat.")</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>KELAS JABATAN</b></div>
                    <div class='col-md-8' align='left'>".$kelasjab."</div>
                  </div>
		  <div class='row'>
                    <div class='col-md-4'><b>ATASAN LANGSUNG</b></div>
                    <div class='col-md-8' align='left'>".$nmjab_atasan."</div>
                  </div>
                </div>
              </div>";

        if ($jnsasn == "PNS") {
          $haktpp = $this->mkinerja->get_haktpp($nip);
          $abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
	  $kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
	  //$kin = 0; // Gasan Arbaniansyah Kec. Lampihong
	  $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
        } if ($jnsasn == "PPPK") {
          $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
          $abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
          $kin = $this->mkinerja_pppk->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
          $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
        }

        echo "<div class='col-md-6'>
                <div class='well well-sm' style='font-size: 11px;'>
                <span class='text text-success' ><b>SYARAT PERHITUNGAN</b></span>
                <br/>";
        echo "<div class='row'>";
        if ($haktpp == "YA") {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>BERHAK TPP                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>BERHAK TPP                    
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }

        if ($abs != NULL) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>ABSENSI BULANAN                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>ABSENSI BULANAN                    
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }

	echo "</div>"; // End Row 1

	echo "<div class='row'>"; // Start Row 2
	if ($pengurang == '' OR $pengurang == 'mkd7h') { // Hanya tnpa potongan dan masuk kerja 7 hari yg dicek kinerja bulanannya
          if ($kin != NULL) {
            echo "<div class='col-md-6'>
                  <span class='label label-success'>KINERJA BULANAN             
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
          } else {
            echo "<div class='col-md-6'>
                  <span class='label label-danger'>KINERJA BULANAN                    
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
          }	  
	} else {
	  $kin = true;
	}
	
	if ($pengurang == '' OR $pengurang == 'mkd7h') { // Hanya tnpa potongan dan masuk kerja 7 hari yg dicek kinerja bulanannya
	  if ($jnsasn == "PNS"){
            if ((file_exists('./fileskpbulanan/'.$nip.'-SKP2024.pdf')) OR (file_exists('./fileskpbulanan/'.$nip.'-SKP2024.PDF'))) {
                $dokskptahunan = true;
            } else {
                $dokskptahunan = false;
            }
	  } else if ($jnsasn == "PPPK"){
            if ((file_exists('./fileskpbulanan_pppk/'.$nip.'-SKP2024.pdf')) OR (file_exists('./fileskpbulanan_pppk/'.$nip.'-SKP2024.PDF'))) {
                $dokskptahunan = true;
            } else {
                $dokskptahunan = false;
            }
          }
	
	  if ($dokskptahunan) {
            echo "<div class='col-md-6'>
                  <span class='label label-success'>DOKUMEN SKP TAHUNAN
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
          } else {
            echo "<div class='col-md-6'>
                  <span class='label label-danger'>DOKUMEN SKP TAHUNAN
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
          }
	} else { // yg potongan 20, 40 dan 100%, tnpa dilihat syarat SKP tahunan
	  $dokskptahunan = true;
	}

	echo "</div>"; // End Row 2

        echo "<div class='row'>"; // Start Row 3
	
	if ($pengurang == '' OR $pengurang == 'mkd7h') { // Hanya tnpa potongan dan masuk kerja 7 hari yg dicek kinerja bulanannya
          $berkas = $this->mtppng2024->get_berkasskpbulanan($nip, $thnperiode, $blnperiode);
	  if ($jnsasn == "PNS"){
            if ((file_exists('./fileskpbulanan/'.$berkas.'.pdf')) OR (file_exists('./fileskpbulanan/'.$berkas.'.PDF'))) {
                $dokskpbulanan = true;
            } else {
                $dokskpbulanan = false;
            }
	  } else if ($jnsasn == "PPPK"){
            if ((file_exists('./fileskpbulanan_pppk/'.$berkas.'.pdf')) OR (file_exists('./fileskpbulanan_pppk/'.$berkas.'.PDF'))) {
                $dokskpbulanan = true;
            } else {
                $dokskpbulanan = false;
            }
          }

	  if ($dokskpbulanan) {
            echo "<div class='col-md-6'>
                  <span class='label label-success'>DOKUMEN PENILAIAN SKP BULANAN
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
          } else {
            echo "<div class='col-md-4'>
                  <span class='label label-danger'>DOKUMEN PENILAIAN SKP BULANAN
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
          }
	} else { // yg potongan 20, 40 dan 100%, tnpa dilihat syarat SKP bulanan
          $dokskpbulanan = true;
        }
        echo "</div>"; // End Row 2

        echo "<div class='row'>"; // Start Row 3
        if ($gaji) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>GAJI BULANAN                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>GAJI BULANAN
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }

        if ($jnsptkp) {
          echo "<div class='col-md-6'>
                  <span class='label label-default'>JNS PTKP : ".$jnsptkp."                
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-default'>JNS PTKP : ".$jnsptkp."
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
	echo "</div>"; // End Row 3

	echo "<div class='row'>"; // Start Row 4
	// CEK LHKPN
	$wajiblhkpn = $this->mpegawai->cekstatuslhkpn($nip);
	if (($wajiblhkpn == "YA") AND ($blnperiode >= 4)) {
	  $lhkpn = true;
	  
	  $cekberkaslhkpn = $this->mtppng2024->get_berkaslhkpn($nip, '2023');
	  if ((file_exists('./filelhkpn/'.$cekberkaslhkpn.'.pdf')) OR (file_exists('./filelhkpn/'.$cekberkaslhkpn.'.PDF'))) {
             $doklhkpn = true;
          } else {
             $doklhkpn = false;
          }
	} else if ($wajiblhkpn == "TIDAK") {
	  $lhkpn = false;
	  $doklhkpn = true;
	} else {
	  $lhkpn = true;
          $doklhkpn = true;
	}

	// Set LHKPN dan dokumen TBN true
	$lhkpn = true;
        $doklhkpn = true;

        if ($wajiblhkpn == "YA") {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>WAJIB LHKPN : ".$wajiblhkpn."
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";

	  if (($doklhkpn) AND ($blnperiode >= 4)) {
            echo "<div class='col-md-6'>
                  <span class='label label-success'>DOKUMEN TBN LHKPN
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
          } else if ((!$doklhkpn) AND ($blnperiode >= 4)) {
            echo "<div class='col-md-6'>
                  <span class='label label-danger'>DOKUMEN TBN LHKPN
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
          }
        } else if ($wajiblhkpn == "TIDAK") {
          echo "<div class='col-md-6'>
                  <span class='label label-default'>WAJIB LHKPN : ".$wajiblhkpn."
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
	// END CEK LHKPN

        echo "</div>"; // End ROw 4
        echo "</div>"; // End Well
        echo "</div>"; // End Kolom

        echo "</div>"; //End Row baris Kesatu
	
        if ($haktpp AND ($abs != NULL) AND ($kin != NULL) AND $gaji AND $jnsptkp AND $dokskpbulanan AND $dokskptahunan AND $doklhkpn) {
	//if ($haktpp AND ($abs != NULL) AND $gaji AND $jnsptkp AND $dokskptahunan AND $doklhkpn) { // Gasan Arbaniansyah Kec. Lampihong
	  // Jika Absensi NOL (TK sebulanan), maka Kinerja juga 0
	  if ($abs == 0) $kin = 0;
	
	  $kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
	  if (($kin == 'sangat baik') OR ($kin == 'baik')) {
              $ckin = 100;
              $kkin = "SANGAT BAIK";
          } else if ($kin == 'butuh perbaikan') {
              $ckin = 80;
              $kkin = "BUTUH PERBAIKAN";
          } else if ($kin == 'kurang') {
              $ckin = 60;
              $kkin = "KURANG";
          } else if ($kin == 'sangat kurang') {
              $ckin = 40;
              $kkin = "SANGAT KURANG";
          } else {
	      $ckin = 0;
              $kkin = "SANGAT KURANG SEKALI";	
	  }
	  //$ckin = 0; // Gasan Arbaniansyah Kec. Lampihong

	  /*
	  PERHITUNGAN LAMA
	  // khusus Nakes,cek ada tidak nilai di field jml_aktifitas_nakes
	  if ($jnsasn == "PNS") {
	  	$kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
          } else if ($jnsasn == "PPPK") {
		$kinnakes = $this->mkinerja_pppk->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
	  }
	  if ($kinnakes != 0) {
		if ($kin >= 30) {
			$ckin = 100;
			$kkin = "SANGAT BAIK";
		} else if (($kin >= 25) AND ($kin < 30)) {
                        $ckin = 90;
                        $kkin = "BAIK";
                } else if (($kin >= 20) AND ($kin < 25)) {
                        $ckin = 80;
                        $kkin = "CUKUP";
                } else if (($kin >= 16) AND ($kin < 20)) {
                        $ckin = 70;
                        $kkin = "KURANG";
                } else if ($kin <= 15) {
                        $ckin = 40;
                        $kkin = "BURUK";
                } 
	  } else { // Selain Nakes
          	if ($kin >= 90) {
            		$ckin = 100; // capaian kinerja
            		$kkin = "SANGAT BAIK"; // keterangan kinerja
          	} else if (($kin >= 76) AND ($kin < 90)) {
            		$ckin = 90;
            		$kkin = "BAIK";
          	} else if (($kin >= 61) AND ($kin < 76)) {
            		$ckin = 80;
            		$kkin = "CUKUP";
          	} else if (($kin >= 51) AND ($kin < 61)) {
            		$ckin = 70;
            		$kkin = "KURANG";
          	} else if (($kin >= 10) AND ($kin < 51)) {
            		$ckin = 40;
            		$kkin = "BURUK";
          	} else if ($kin < 10) {
            		$ckin = 0;
            		$kkin = "";
          	}
	  }
	  */
          
        $pabs = 0.4 * $abs; // persentase absensi (40%)
          
        echo "<div class='row'>"; // Start Row Penilaian Kinerja dan Kalkulasi
        echo "<div class='col-lg-6'>";
        echo "<div class='well well-sm' style='font-size: 11px;'>";
          echo "<div class='row'>"; // Row dalam Penilaian Kinerja
	  echo "<div class='col-lg-6'>";	
          if ($pengurang == "mkd7h") {
	    echo "<span class='text text-danger'><b>MASUK KERJA KURANG DARI 7 HARI</b></span><br/>";
            $pkin = 0.4 * $ckin; // Hitung 40% dari pembulatan realisasi kinerja 
            echo "<span class='text text-primary'><b>PENILAIAN KINERJA</b></span>
                    <br/>Nilai SKP : ".$kin."              
                    <br/>Capaian : ".$ckin." (".$kkin.")
                    <br/>Persentase : ".$pkin;
            echo "<br/><br/>
                  <span class='text text-primary'><b>DISIPLIN KERJA</b></span>
                    <br/>Nilai Absensi : ".$abs."
                    <br/>Persentase : ".$pabs;
	    $realisasi = $pkin + $pabs;	
          } else if ($pengurang == "k20") {
            echo "<span class='text text-danger'><b>CUTI 6 SAMPAI 12 BULAN</b></span>";
	    $realisasi = 20;	
          } else if ($pengurang == "k40") {
            echo "<span class='text text-danger'><b>CUTI KURANG DARI 6 BULAN</b></span>";
            $realisasi = 40;
          } else if ($pengurang == "k100") {
            echo "<span class='text text-danger'><b>CUTI DIATAS 12 BULAN, MPP, HUKUMAN DISIPLIN, CLTN, ASN TITIPAN/DIPERBANTUKAN</b></span>";
            $realisasi = 0;
          }else {
            $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)
            echo "<span class='text text-primary'><b>PENILAIAN KINERJA</b></span>
                    <br/>Nilai Kinerja : ".strtoupper($kin)."
                    <br/>Capaian : ".$ckin."
                    <br/>Persentase : ".$pkin;
            echo "<br/><br/>
                  <span class='text text-primary'><b>DISIPLIN KERJA</b></span>
                    <br/>Nilai Absensi : ".$abs."
                    <br/>Persentase : ".$pabs;
	    $realisasi = $pkin + $pabs;
          }


	  echo "</div>"; // End kolom

          echo "<div class='col-md-6'>";
	  echo "<span class='text text-success'><b>PERSENTASE PEROLEHAN TPP</b></span>
                    <h4><span class='text text-success'>".$realisasi." %</span></h4>";
	  echo "</div>"; // End Kolom ke 2 dalam penilaian kinerja
	  echo "</div>"; // End Row dalam penilaian kinerja

        echo "</div>"; // End Well Penilaian Kinerja
	echo "</div>"; // End Kolom

	  if (($statpeg == 'PNS') OR ($jnsasn == "PPPK")) {
            if ($idjabpltpeta == '') {
              $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta);
              $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta);
              $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta);
              $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta);
            } else if ($idjabpltpeta != '') {
              if ($jnsplt == 'plt100') {
                $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpltpeta);
                $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpltpeta);
                $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpltpeta);
                $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpltpeta);
              } else if ($jnsplt == 'plt20') {
                $tpp_pk_plt = $this->mpetajab->get_tpp_pk($idjabpltpeta);
                $tpp_bk_plt = $this->mpetajab->get_tpp_bk($idjabpltpeta);
                $tpp_kk_plt = $this->mpetajab->get_tpp_kk($idjabpltpeta);
                $tpp_kp_plt = $this->mpetajab->get_tpp_kp($idjabpltpeta);

                $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) + ($tpp_pk_plt * 0.2);
                $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) + ($tpp_bk_plt * 0.2);
                $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) + ($tpp_kk_plt * 0.2);
                $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) + ($tpp_kp_plt * 0.2);              
              } else {
                $tpp_pk = 0;
                $tpp_bk = 0;
                $tpp_kk = 0;
                $tpp_kp = 0;
              }
            }
          } else if ($statpeg == 'CPNS') {
	    $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) * 0.8;
            $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) * 0.8;
            $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) * 0.8;
            $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) * 0.8;
	  }          

          $tpp_basic =  round($tpp_pk) +  round($tpp_bk) +  round($tpp_kk) +  round($tpp_kp);

          if (($pengurang == '') OR ($pengurang == 'mkd7h')) {
            $rea_pk = ($realisasi * $tpp_pk) / 100;
            $rea_bk = ($realisasi * $tpp_bk) / 100;
            $rea_kk = ($realisasi * $tpp_kk) / 100;
            $rea_kp = ($realisasi * $tpp_kp) / 100;
          } else if ($pengurang == 'k100') {
            $rea_pk = 0;
            $rea_bk = 0;
            $rea_kk = 0;
            $rea_kp = 0;
          } else if ($pengurang == 'k40') {
            $rea_pk = $tpp_pk * 0.4;
            $rea_bk = $tpp_bk * 0.4;
            $rea_kk = $tpp_kk * 0.4;
            $rea_kp = $tpp_kp * 0.4;
          } else if ($pengurang == 'k20') {
            $rea_pk = $tpp_pk * 0.2;
            $rea_bk = $tpp_bk * 0.2;
            $rea_kk = $tpp_kk * 0.2;
            $rea_kp = $tpp_kp * 0.2;
          }
          
          $rea_bruto = round($rea_pk) + round($rea_bk) + round($rea_kk) + round($rea_kp);
	
	  if ($statpeg == 'CPNS') {
	    $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpeta)." : 80%";	
	  } else if ($idjabpltpeta == '') {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpeta);
          } else if (($jnsplt == 'plt100') AND ($idjabpltpeta != '')) {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpltpeta);
          } else if (($jnsplt == 'plt20') AND ($idjabpltpeta != '')) {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpeta)." + 20% Basic Kelas ".$this->mpetajab->get_kelas($idjabpltpeta);
          } else {
            $ket = "Data kurang lengkap";
          }

          echo "<div class='col-md-6'>
		  <div class='well well-sm' style='font-size: 12px;'>
                  <span class='text text-primary'><b>KALKULASI TPP (".$ket.")</b></span>
	                    <div class='row'>
                      <div class='col-md-5'><b>KRITERIA</b></div>
                      <div class='col-md-4' align='right'><b>BASIC</b></div>
                      <div class='col-md-3' align='right'><b>REALISASI (".$realisasi."%)</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>BEBAN KERJA</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_bk),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_bk),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>PRESTASI KERJA</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_pk),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_pk),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>KONDISI KERJA</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_kk),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_kk),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>KELANGKAAN PROFESI</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_kp),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_kp),2,',','.')."</div>
                    </div>                  
                    <div class='row'>
                      <div class='col-md-5'><span class='text-success'><b>TOTAL</b></span></div>
                      <div class='col-md-4' align='right'><span class='text-success'><b>".number_format($tpp_basic,2,',','.')."</b></span></div>
                      <div class='col-md-3' align='right'><span class='text-success'><b>".number_format($rea_bruto,2,',','.')."</b></span></div>
                    </div>
                  </div>
                </div>";

          echo "</div>"; // end ROW KEDUA
	  echo "</div>"; // End Row Penilaian dan Kalkulasi	

          if ($jnsasn == "PNS") {
            $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
            $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
            $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
            $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
            $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($nip, $thnperiode, $blnperiode);
          } else if ($jnsasn == "PPPK") {
            $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
            $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode);
            $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode);
            $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode);
            $bpjs_gaji = $this->mtppng2024->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
          }

          $hasil_bruto = $gaji_bruto + $rea_bruto;

	  if ($jnsasn == "PNS") {
		$pph_bayar = $this->mtppng2024->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
		$ptkpgaji = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode);
          } else if ($jnsasn == "PPPK") {
		$pph_bayar = $this->mtppng2024->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
		$ptkpgaji = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode);
          }

	  $katpajak = $this->mtppng2024->get_kategori_pp582023($jnsptkp);          
	  
          echo "<div class='row'>"; // Start Row 3 (PPH, IWP, BPJS)
          echo "<div class='col-md-4'>
                  <div class='well well-sm' style='font-size: 11px;'>
                    <span class='text text-primary'><b>PPh 21</b></span>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Gaji Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($gaji_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>TPP Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($rea_bruto,2,',','.')."</div>
                    </div>
		    <div class='row'>
                      <div class='col-md-6' align='left'>Penghasilan Bruto</div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'>".number_format($rea_bruto+$gaji_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-7'>PTKP | Kategori</div>
                      <div class='col-md-5' align='right'>".$ptkpgaji." | ".$katpajak."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tarif Pajak</div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'>".$this->mtppng2024->get_tarifpph21_pp582023($katpajak, $hasil_bruto)." %</div>
                    </div>
		    <div class='row'>
                      <div class='col-md-6'>PPh 21 TPP</div>
                      <div class='col-md-6' align='right'>".number_format($pph_bayar,2,',','.')."</div>
                    </div>	
                    <div class='row'>
                      <div class='col-md-6'>PPh 21 Gaji</div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'>(".number_format($pph_gaji,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Potongan PPh 21</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($pph_bayar-$pph_gaji,2,',','.')."</b></span></div>
                    </div>
                  </div>
                </div>";
          
          // IWP 1%
          $iwp_tpp = $rea_bruto * 0.01;
          $iwp_total = $iwp_gaji + $iwp_tpp;
          if ($iwp_total > 120000) {
            $iwp_terhutang = 120000-$iwp_gaji;
          } else {
            $iwp_terhutang = $iwp_tpp; 
          }
          // End IWP 1%

          // BPJS 4%
          $bpjs_tpp = $rea_bruto * 0.04;
          $bpjs_total = $bpjs_gaji + $bpjs_tpp;
          if ($bpjs_total > 480000) {
            $bpjs_terhutang = 480000-$bpjs_gaji;
          } else {
            $bpjs_terhutang = $bpjs_tpp; 
          }
          //End BPJS 4%
          
          echo "<div class='col-md-4'>
                  <div class='well well-sm' style='font-size: 11px;'>
                    <span class='text text-primary'><b>IWP 1%</b> <span class='text text-muted'>(Gaji + TPP) Maks. 120.000</span></span>
                    <div class='row'>
                      <div class='col-md-6'>IWP Gaji</div>
                      <div class='col-md-6' align='right'>".number_format($iwp_gaji,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>IWP TPP</div>
                      <div class='col-md-6' align='right'>".number_format($iwp_tpp,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Potongan IWP</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($iwp_terhutang,2,',','.')."</b></span></div>
                    </div>
                  </div>";

          echo "    <div class='well well-sm' style='font-size: 11px;'>
                    <span class='text text-primary'><b>BPJS 4%</b> <span class='text text-muted'>(Gaji + TPP) Maks. 480.000</span></span>
                    <div class='row'>
                      <div class='col-md-6'>BPJS Gaji</div>
                      <div class='col-md-6' align='right'>".number_format($bpjs_gaji,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>BPJS TPP</div>
                      <div class='col-md-6' align='right'>".number_format($bpjs_tpp,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Potongan BPJS</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($bpjs_terhutang,2,',','.')."</b></span></div>
                    </div>                    
                  </div>";
          echo"   </div>"; // End kolom 2 Row 3
          
          //if ($statpeg == "PNS") {
          //if (($statpeg == "PNS") OR ($statpeg == "PPPK")) {
            $thp = round($rea_bruto) + round($bpjs_terhutang) + round($pph_bayar)- (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
          //  $ket_statpeg = "";
          //} else if ($statpeg == "CPNS") {
          //  $thp = ($rea_bruto + $bpjs_terhutang - ($pph_bayar+$iwp_terhutang+$bpjs_terhutang)) * 0.8; // CPNS 80%
          //  $ket_statpeg = "(CPNS 80%)";  
          //}          
/*<blockquote style='font-size: 11px;'>*/

          echo "<div class='col-md-4'>
		<div class='well well-sm' style='font-size: 11px;'> 
                  <span class='text text-danger'><b>KALKULASI AKHIR</b></span><br/>
                    <div class='row'>
                      <div class='col-md-6' align='left'><b>Realisasi TPP</b></div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'><b>".number_format(round($rea_bruto),2,',','.')."</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tunjangan PPh 21</div>
                      <div class='col-md-6' align='right'>".number_format(round($pph_bayar),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tunjangan BPJS</div>
                      <div class='col-md-6' align='right'>".number_format(round($bpjs_terhutang),2,',','.')."</div>
                    </div>	
		    <div class='row'>
                      <div class='col-md-6' align='left' style='margin-bottom:5px;'><b>Total Tunjangan</b></div>
                      <div class='col-md-6' align='right'><b>".number_format(round($pph_bayar+$bpjs_terhutang),2,',','.')."</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Potongan PPh 21</div>
                      <div class='col-md-6' align='right'>(".number_format(round($pph_bayar),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Potongan IWP</div>
                      <div class='col-md-6' align='right'>(".number_format(round($iwp_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Potongan BPJS</div>
                      <div class='col-md-6' align='right'>(".number_format(round($bpjs_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left' style='margin-bottom:5px;'><b>Total Potongan</b></div>
                      <div class='col-md-6' align='right'><b>".number_format(round($pph_bayar+$iwp_terhutang+$bpjs_terhutang),2,',','.')."</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><b><span class='text text-danger'>TPP NETO</span></b></div>
                      <div class='col-md-6' align='right'>
                          <b><span class='text text-danger'>".number_format(round($thp,0),2,',','.')."</span></b>
                        </div>
                    </div>
		</div>	
                </div>";
          echo "</div>"; // End Row 3

          echo "<div>"; // Start Row 4
          echo "<div class='col-md-10'>
                  <textarea class='form-control' rows='3' id='catatan' name='catatan' placeholder='WAJIB : Tulis catatan terkait kalkulasi TPP disini' value='' required></textarea>
                </div>
                <div class='col-md-2' align='right'>";
	  //if ($this->session->userdata('nip') == "198104072009041002") {
  	  echo "  <button type='submit' class='btn btn-success btn-outline' onclick=''>
                          <span class='glyphicon glyphicon-save' aria-hidden='true'></span><br/>SETUJU<br/>SIMPAN
                  </button>";
	  //}
          echo "</div>"; // End Kolom tombol Simpan
          echo "</div>"; // End ROW 4

        } else {
          echo "<div align='center' class='text text-warning'>TIDAK DAPAT DILANJUTKAN, SYARAT PERHITUNGAN TIDAK LENGKAP</div>";
      }
    } // End Cek NIP

  }

  function tmbkalk_aksi() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));
    $nip = addslashes($this->input->post('nip'));
    $idjabpeta = addslashes($this->input->post('idjabpeta'));
    $jabatan = $this->mpetajab->get_namajab($idjabpeta);

    $blnperiode = $this->mtppng2024->get_bulanperiode($idperiode);
    $thnperiode = $this->mtppng2024->get_tahunperiode($idperiode);

    $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $statpeg = $this->mpegawai->getstatpeg($nip);
      $idgolru = $this->mpetajab->getidgolru($nip);
      $golru = $this->mpegawai->getnamagolru($idgolru);
      $pangkat = $this->mpegawai->getnamapangkat($idgolru);
      $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);
      $npwp = $this->mkinerja->get_npwp($nip);
      $jnsptkp = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode); // Ambil jenis PTKP dari Data Gaji	
      //$jnsptkp = $this->mtppng2024->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga	
    } else if ($jnsasn == "PPPK") {
      $statpeg = "PPPK";
      $idgolru = $this->mpppk->getidgolruterakhir($nip);
      $golru = $this->mpppk->getnamagolru($idgolru);
      $pangkat = "";
      $tmtjab = "";
      $npwp = $this->mkinerja_pppk->get_npwp($nip);
      $jnsptkp = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode); // Ambil jenis PTKP dari Data Gaji
      //$jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
    }

    //$idgolru = $this->mpetajab->getidgolru($nip);
    $id_unker = $this->mtppng2024->get_idunker($idpengantar);
    $idjabpltpeta = addslashes($this->input->post('idjabpltpeta'));
    $jabatanplt = $this->mpetajab->get_namajab($idjabpltpeta);
    $jnsplt = addslashes($this->input->post('jnsplt'));
    $pengurang = addslashes($this->input->post('pengurang'));

    //$statpeg = $this->mpegawai->getstatpeg($nip);
    
    if ($jnsasn == "PNS") {
      $haktpp = $this->mkinerja->get_haktpp($nip);
      $abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      $kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);	
      $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($nip, $thnperiode, $blnperiode);
    } if ($jnsasn == "PPPK") {
      $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
      $abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      $kin = $this->mkinerja_pppk->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);	
      //$kin = 0; // Gasan Arbaniansyah Kec. Lampihong	
      $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
    }

    if (($jnsplt == 'plt100') AND ($idjabpltpeta != '')) {
      $kelasjabplt = $this->mpetajab->get_kelas($idjabpltpeta);
      $kelasjab = $this->mpetajab->get_kelas($idjabpeta);
    } else {
      $kelasjabplt = '';
      $kelasjab = $this->mpetajab->get_kelas($idjabpeta);  
    }

    //$kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
    
    // Jika Absensi NOL (TK sebulanan), maka Kinerja juga 0
    if ($abs == 0) $kin = 0;

    $kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
    if (($kin == 'sangat baik') OR ($kin == 'baik')) {
        $ckin = 100;
    	$kkin = "SANGAT BAIK";
    } else if ($kin == 'butuh perbaikan') {
        $ckin = 80;
    	$kkin = "BUTUH PERBAIKAN";
    } else if ($kin == 'kurang') {
        $ckin = 60;
    	$kkin = "KURANG";
    } else if ($kin == 'sangat kurang') {
    	$ckin = 40;
    	$kkin = "SANGAT KURANG";
    }
 
    //$ckin = 0; // Gasan Arbaniansyah Kec. Lampihong
 
    // khusus Nakes,cek ada tidak nilai di field jml_aktifitas_nakes
    //$kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
    /*	
    if ($jnsasn == "PNS") {
    	$kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
    } else if ($jnsasn == "PPPK") {
        $kinnakes = $this->mkinerja_pppk->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
    }
    if ($kinnakes != 0) {
    	if ($kin >= 30) {
           $ckin = 100;
	   $kkin = "SANGAT BAIK";
        } else if (($kin >= 25) AND ($kin < 30)) {
           $ckin = 90;
           $kkin = "BAIK";
        } else if (($kin >= 20) AND ($kin < 25)) {
           $ckin = 80;
           $kkin = "CUKUP";
        } else if (($kin >= 16) AND ($kin < 20)) {
           $ckin = 70;
           $kkin = "KURANG";
        } else if ($kin <= 15) {
           $ckin = 40;
           $kkin = "BURUK";
        }
    } else { // Selain Nakes          
    	if ($kin >= 90) {
      	  $ckin = 100; // capaian kinerja
      	  $kkin = "SANGAT BAIK"; // keterangan kinerja
        } else if (($kin >= 76) AND ($kin < 90)) {
          $ckin = 90;
          $kkin = "BAIK";
    	} else if (($kin >= 61) AND ($kin < 76)) {
          $ckin = 80;
          $kkin = "CUKUP";
    	} else if (($kin >= 51) AND ($kin < 61)) {
      	  $ckin = 70;
      	  $kkin = "KURANG";
    	} else if (($kin >= 10) AND ($kin < 51)) {
      	  $ckin = 40;
      	  $kkin = "BURUK";
        } else if ($kin < 10) {
      	  $ckin = 0;
      	  $kkin = "";
    	}
    }
    */

    $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)
    
    if ($pengurang != "mkd7h") {
            $pkin = 0.6 * $ckin;
    } else if ($pengurang == "mkd7h") {
            $pkin = 0.4 * $ckin;
    }

    //$abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
    $pabs = 0.4 * $abs; // persentase absensi (40%)
    $realisasi = $pkin + $pabs;
    
    if (($statpeg == 'PNS') OR ($jnsasn == "PPPK")) {	
      if ($idjabpltpeta == '') {
        $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta);
        $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta);
        $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta);
        $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta);
        $persenplt = 0;
      } else if ($idjabpltpeta != '') {
        if ($jnsplt == 'plt100') {
          $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpltpeta);
          $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpltpeta);
          $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpltpeta);
          $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpltpeta);
          $persenplt = 100;
        } else if ($jnsplt == 'plt20') {
          $tpp_pk_plt = $this->mpetajab->get_tpp_pk($idjabpltpeta);
          $tpp_bk_plt = $this->mpetajab->get_tpp_bk($idjabpltpeta);
          $tpp_kk_plt = $this->mpetajab->get_tpp_kk($idjabpltpeta);
          $tpp_kp_plt = $this->mpetajab->get_tpp_kp($idjabpltpeta);

          $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) + ($tpp_pk_plt * 0.2);
          $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) + ($tpp_bk_plt * 0.2);
          $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) + ($tpp_kk_plt * 0.2);
          $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) + ($tpp_kp_plt * 0.2);  
          $persenplt = 20;            
        } else {
          $tpp_pk = 0;
          $tpp_bk = 0;
          $tpp_kk = 0;
          $tpp_kp = 0;
        }
      }
    } else if ($statpeg == 'CPNS') {
      $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) * 0.8;
      $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) * 0.8;
      $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) * 0.8;
      $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) * 0.8;
      $persenplt = 0;
    }                        

    $tpp_basic = round($tpp_pk) + round($tpp_bk) + round($tpp_kk) + round($tpp_kp);

    if ($pengurang == '') {
      $ket_pengurang = "";
      $rea_pk = ($realisasi * $tpp_pk) / 100;
      $rea_bk = ($realisasi * $tpp_bk) / 100;
      $rea_kk = ($realisasi * $tpp_kk) / 100;
      $rea_kp = ($realisasi * $tpp_kp) / 100;
    } else if ($pengurang == 'mkd7h') {
      $ket_pengurang = "40 % Produktifitas";
      $rea_pk = ($realisasi * $tpp_pk) / 100;
      $rea_bk = ($realisasi * $tpp_bk) / 100;
      $rea_kk = ($realisasi * $tpp_kk) / 100;
      $rea_kp = ($realisasi * $tpp_kp) / 100;
    } else if ($pengurang == 'k100') {
      $ket_pengurang = "100 % Basic";
      $rea_pk = 0;
      $rea_bk = 0;
      $rea_kk = 0;
      $rea_kp = 0;
    } else if ($pengurang == 'k40') {
      $ket_pengurang = "40 % Basic";
      $rea_pk = $tpp_pk * 0.4;
      $rea_bk = $tpp_bk * 0.4;
      $rea_kk = $tpp_kk * 0.4;
      $rea_kp = $tpp_kp * 0.4;
    } else if ($pengurang == 'k20') {
      $ket_pengurang = "20 % Basic";
      $rea_pk = $tpp_pk * 0.2;
      $rea_bk = $tpp_bk * 0.2;
      $rea_kk = $tpp_kk * 0.2;
      $rea_kp = $tpp_kp * 0.2;
    }   
    $rea_bruto = round($rea_pk) + round($rea_bk) + round($rea_kk) + round($rea_kp);
    
    if ($jnsasn == "PNS") {
      $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
      $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
      $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
      $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($nip, $thnperiode, $blnperiode);	
    } else if ($jnsasn == "PPPK") {
      $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
      $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode);
      $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode);
      $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
    }

    //$gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
    //$pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
    //$pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
    $hasil_bruto = $gaji_bruto + $rea_bruto;

    /* 	
    //Perhitungan Baru Tanpa Biaya Jabatan	
    $biaya_jab = $hasil_bruto * 0.05;
    if ($biaya_jab > 500000) {
      $biaya_jab = 500000;
    }
    */
    $biaya_jab = 0;	

    //$npwp = $this->mkinerja->get_npwp($nip);
    //$jnsptkp = $this->mkinerja->get_jnsptkp($nip);

    // Hitung PPh21  
    //$ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    //$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    if ($jnsasn == "PNS") {
	$ptkp = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode);
	$pph_bayar = $this->mtppng2024->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    } else if ($jnsasn == "PPPK") {
	$ptkp = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode);
       	$pph_bayar = $this->mtppng2024->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
    }

    //$iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
    $iwp_tpp = $rea_bruto * 0.01;
    $iwp_total = $iwp_gaji + $iwp_tpp;
    if ($iwp_total > 120000) {
      $iwp_terhutang = 120000-$iwp_gaji;
    } else {
      $iwp_terhutang = $iwp_tpp; 
    }

    // BPJS 4%
    $bpjs_tpp = $rea_bruto * 0.04;
    $bpjs_total = $bpjs_gaji + $bpjs_tpp;
    if ($bpjs_total > 480000) {
      $bpjs_terhutang = 480000-$bpjs_gaji;
    } else {
      $bpjs_terhutang = $bpjs_tpp; 
    }
    
    //if (($statpeg == "PNS") OR ($statpeg == "PPPK")) {
    $thp = (round($rea_bruto) + round($bpjs_terhutang) + round($pph_bayar)) - (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
    //} else if ($statpeg == "CPNS") {
    //  $thp = ($rea_bruto + $bpjs_terhutang - ($pph_bayar+$iwp_terhutang+$bpjs_terhutang)) * 0.8; // CPNS 80%
    //}
    $catatan = addslashes($this->input->post('catatan'));

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();
    $data = array(
      'fid_pengantar'         => $idpengantar,
      'fid_periode'           => $idperiode,
      'nip'                   => $nip,
      'tahun'                 => $thnperiode,
      'bulan'                 => $blnperiode,
      'fid_jabpeta'           => $idjabpeta,
      'jabatan'               => $jabatan,
      'fid_golru'             => $idgolru,
      'fid_unker'             => $id_unker,
      'kelasjab'              => $kelasjab,
      'fid_jabpeta_plt'       => $idjabpltpeta,
      'jabatan_plt'           => $jabatanplt,
      'kelasjab_plt'          => $kelasjabplt,
      'persen_plt'            => $persenplt,
      'statuspeg'             => $statpeg,
      'nilai_produktifitas'   => $ckin,
      'capaian_produktifitas' => $kkin,
      'persen_produktifitas'  => $pkin,
      'nilai_disiplin'        => $abs,
      'persen_disiplin'       => $pabs,
      'realisasi_kinerja'     => $realisasi,
      'basic_bk'              => round($tpp_bk),
      'basic_pk'              => round($tpp_pk),
      'basic_kk'              => round($tpp_kk),
      'basic_kp'              => round($tpp_kp),
      'basic_total'           => round($tpp_basic),
      'ket_pengurang'         => $ket_pengurang,
      'real_bk'               => round($rea_bk),
      'real_pk'               => round($rea_pk),
      'real_kk'               => round($rea_kk),
      'real_kp'               => round($rea_kp),
      'real_total'            => round($rea_bruto),
      'gaji_bruto'            => $gaji_bruto,
      'pot_gaji'              => $pot_gaji,
      'pph_gaji'              => $pph_gaji,
      'biaya_jab'             => round($biaya_jab),
      'npwp'                  => $npwp,
      'jns_ptkp'              => $jnsptkp,
      'ptkp'                  => $ptkp,
      'jml_pph'               => round($pph_bayar),
      'iwp_gaji'              => round($iwp_gaji),
      'jml_iwp'               => round($iwp_terhutang),
      'jml_bpjs'              => round($bpjs_terhutang),
      'tpp_diterima'          => round($thp),
      'catatan'               => $catatan,
      'fid_status'            => '1', // status INPUT      
      'entri_at'              => $tgl_aksi,
      'entri_by'              => $user
    );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $thnperiode,
      'bulan'           => $blnperiode
    );

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mtppng2024->cektelahusul($nip, $thnperiode, $blnperiode) == 0) {
      if ($this->mtppng2024->input_tppng($data)) {
        $data['pesan'] = "<b>SUKSES</b>, TPP ".$nama." Bulan ".bulan($blnperiode)." Tahun ".$thnperiode." BERHASIL DITAMBAH.";
        $data['jnspesan'] = "alert alert-success";  
      } else {
        $data['pesan'] = "<b>GAGAL</b>, TPP ".$nama." Bulan ".bulan($blnperiode)." Tahun ".$thnperiode." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-warning";
      }              
    } else {// pernah usul
        $data['pesan'] = "<b>DATA RANGKAP</b>, TPP ".$nama." Bulan ".bulan($blnperiode)." Tahun ".$thnperiode." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-info";
    }

    $data['thn'] = $thnperiode;
    $data['bln'] = $blnperiode;
    
    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $idpengantar;
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function hapustppng(){    
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng2024->get_idunker($id_pengantar);
    $bln = $this->mtppng2024->get_bulanperiode($id_periode);
    $thn = $this->mtppng2024->get_tahunperiode($id_periode);

    $where = array('nip' => $nip,
                   'fid_pengantar' => $id_pengantar,
                   'fid_periode' => $id_periode
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mtppng2024->hapustppng($where)) {// hapus seluruh usulan pada tabel usul_tpp
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nama.', periode '.bulan($bln).' '.$thn.' BERHASIL DIHAPUS';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nama.', periode '.bulan($bln).' '.$thn.' GAGAL DIHAPUS';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $id_pengantar;
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng2024->tampil_tppng($id_pengantar, $id_periode)->result_array();
    $data['content'] = 'tppng2024/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function tmbunorperiode_aksi() {
    $idperiode = addslashes($this->input->post('idperiode'));
    $idunor = addslashes($this->input->post('idunor'));
    $jnsasn = addslashes($this->input->post('jnsasn'));

    $bln = $this->mtppng2024->get_bulanperiode($idperiode);
    $thn = $this->mtppng2024->get_tahunperiode($idperiode);

    // START QR CODE
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/qrcodetppng2024/'; //direktori penyimpanan qr code
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

            $image_name = $thn.$bln."-".$idunor."-".$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

            $params['data'] = $thn.$bln."-".$idunor."-".$string; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

    // END QR CODE

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();
    $data = array(
      'fid_periode' => $idperiode,
      'fid_unker'   => $idunor,
      'jenis_asn'   => $jnsasn,
      'status'      => "SKPD",
      'entri_at'    => $tgl_aksi,
      'entri_by'    => $user,
      'qrcode'      => $params['data'],
    );

    $nmunker = $this->munker->getnamaunker($idunor);

    if ($this->session->userdata('level') == "ADMIN") { // ADMIN dapat menambah banyak pengantar
      $telahusul = 0;
      $cekstatusberkasbulanlalu = TRUE;		
    } else {
      $telahusul = $this->mtppng2024->cektelahusul_pengantar($idperiode, $idunor, $jnsasn);
      //$cekstatusberkasbulanlalu = $this->mtppng2024->cekstatusberkaspengantar_bulanlalu($idperiode, $idunor, $jnsasn);
      $cekstatusberkasbulanlalu = TRUE;	
    }

    if (($telahusul == 0) AND ($cekstatusberkasbulanlalu)) {
      if ($this->mtppng2024->input_tppng_pengantar($data)) {
        $data['pesan'] = "<b>SUKSES</b>, TPP ".$nmunker." BERHASIL DITAMBAH.";
        $data['jnspesan'] = "alert alert-success";  
      } else {
        $data['pesan'] = "<b>GAGAL</b>, TPP ".$nmunker." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-danger";
      }              
    } else {// pernah usul
        $data['pesan'] = "<b>GAGAL</b>, TPP ".$nmunker." GAGAL DITAMBAH<br/><span class='text-primary'>Data RANGKAP, atau STATUS bulan lalu belum SELESAI</span>";
        $data['jnspesan'] = "alert alert-warning";
    }

    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->get_pengantar($idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiode';
    $this->load->view('template', $data);
  }

  function hapuspengantar(){    
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng2024->get_idunker($id_pengantar);
    $bln = $this->mtppng2024->get_bulanperiode($id_periode);
    $thn = $this->mtppng2024->get_tahunperiode($id_periode);

    $where = array('id' => $id_pengantar,
                   'fid_unker' => $id_unker,
                   'fid_periode' => $id_periode
    );

    $nmunker = $this->munker->getnamaunker($id_unker);
    if ($this->mtppng2024->hapustppng_pengantar($where)) {// hapus seluruh usulan pada tabel usul_tpp
      $qrcode = $this->mtppng2024->getqrcode($id_pengantar);
      
      if (is_file("../assets/qrcodetppng2024/".$qrcode.".png")) {
        unlink("../assets/qrcodetppng2024/".$qrcode.".png");
      }
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.', periode '.bulan($bln).' '.$thn.' BERHASIL DIHAPUS';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.', periode '.bulan($bln).' '.$thn.' GAGAL DIHAPUS';
      $data['jnspesan'] = 'alert alert-info';
    }
    
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng2024->get_pengantar($id_periode)->result_array();
    $data['content'] = 'tppng2024/detailperiode';
    $this->load->view('template', $data);
  }

  function valid_tppng() {
    $id = addslashes($this->input->post('id'));
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng2024->get_idunker($id_pengantar);
    $bln = $this->mtppng2024->get_bulanperiode($id_periode);
    $thn = $this->mtppng2024->get_tahunperiode($id_periode);

    $data = array(
      'fid_status'         => '2', // VALID
    );

    $where = array('id' => $id
    );

    $this->mtppng2024->edit_tppng($where, $data);
    
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $id_pengantar;
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng2024->tampil_tppng($id_pengantar, $id_periode)->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'tppng2024/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function invalid_tppng() {
    $id = addslashes($this->input->post('id'));
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng2024->get_idunker($id_pengantar);
    $bln = $this->mtppng2024->get_bulanperiode($id_periode);
    $thn = $this->mtppng2024->get_tahunperiode($id_periode);

    $data = array(
      'fid_status'  => '1', // VALID
    );

    $where = array('id' => $id
    );

    $this->mtppng2024->edit_tppng($where, $data);
    
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $id_pengantar;
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng2024->tampil_tppng($id_pengantar, $id_periode)->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'tppng2024/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function valid_pengantar() { // Kirim pengantar ke BKPSDM
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    // Update status pengantar
    $data_pengantar = array(
      'status'         => 'BKPSDM', // VALID
    );

    $where_pengantar = array('id' => $id_pengantar
    );

    // UPDATE STATUS TPPNG
    $data_tppng = array(
      'fid_status'  => '3', // tunggu approval
    );

    $where_tppng = array('fid_pengantar' => $id_pengantar
    );

    $id_unker = $this->mtppng2024->get_idunker($id_pengantar);
    $nmunker = $this->munker->getnamaunker($id_unker);

    if (($this->mtppng2024->edit_tppng($where_tppng, $data_tppng)) AND ($this->mtppng2024->edit_tppngpengantar($where_pengantar, $data_pengantar))) {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.' BERHASIL DIKIRIM KE BKPSDM';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.' GAGAL DIKIRIM KE BKPSDM';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng2024->get_pengantar($id_periode)->result_array();
    $data['content'] = 'tppng2024/detailperiode';
    $this->load->view('template', $data);
  }

  function approve_pengantar() { // BKPSDM menyetujui kalkulasi, selanjutnya cetak oleh SKPD
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    // Update status pengantar
    $data_pengantar = array(
      'status'         => 'APPROVED', // VALID
    );

    $where_pengantar = array('id' => $id_pengantar
    );

    // UPDATE STATUS TPPNG
    $data_tppng = array(
      'fid_status'  => '4', // Approve
    );

    $where_tppng = array('fid_pengantar' => $id_pengantar
    );

    $id_unker = $this->mtppng2024->get_idunker($id_pengantar);
    $nmunker = $this->munker->getnamaunker($id_unker);

    if (($this->mtppng2024->edit_tppng($where_tppng, $data_tppng)) AND ($this->mtppng2024->edit_tppngpengantar($where_pengantar, $data_pengantar))) {
      $data['pesan'] = '<b>Sukses</b>, TPP '.$nmunker.' BERHASIL DI-APPROVE';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal</b>, TPP '.$nmunker.' GAGAL DI-APPROVE';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng2024->get_pengantar($id_periode)->result_array();
    $data['content'] = 'tppng2024/detailperiode';
    $this->load->view('template', $data);
  }
  
  public function tampilSpesimenBendahara()  
  {
    $nip = addslashes($this->input->get('nip'));
    echo $this->mpegawai->getnama($nip);
  }

  public function tampilSpesimenKepala()  
  {
    $nip = addslashes($this->input->get('nip'));
    echo $this->mpegawai->getnama($nip);
  }

  public function cetak_tandaterima()  
  {
    $nipbend = addslashes($this->input->post('nipbend'));
    $namabend = $this->mpegawai->getnama($nipbend);
    $nipkep = addslashes($this->input->post('nipkep'));
    $namakep = $this->mpegawai->getnama($nipkep);
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));

    $data_pengantar = array(
      'nip_bendahara'   => $nipbend,
      'nama_bendahara'  => $namabend,
      'nip_kepala'      => $nipkep,
      'nama_kepala'     => $namakep,
      'status'		=> 'CETAK'
    );

    $where_pengantar = array(
      'id' => $idpengantar
    );

    $data_tppng = array(
      'fid_status'  => '5', // Print
    );

    $where_tppng = array('fid_pengantar' => $idpengantar
    );

    if ($this->mtppng2024->edit_tppngpengantar($where_pengantar, $data_pengantar)) {
      // Update status masing2 usulan PNS menjadi PRINT	
      $this->mtppng2024->edit_tppng($where_tppng, $data_tppng);
	
      $data['pesan'] = '<b>SUKSES</b>, Spesimen Berhasil Disimpan';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>GAGAL</b>, Spesimen Gagal Disimpan';
      $data['jnspesan'] = 'alert alert-warning';
    }

    $data['$idpengantar'] = $idpengantar;
    $data['data'] = $this->mtppng2024->cetak_tandaterima($idpengantar, $idperiode)->result_array();
    $this->load->view('/tppng2024/cetaktandaterima',$data);     
  }

  function tampilkalkulasithr() {
    $nip = addslashes($this->input->get('nip'));
    $idpengantar = addslashes($this->input->get('idpengantar'));
    $idperiode = addslashes($this->input->get('idperiode'));
    $idjabpeta = addslashes($this->input->get('idjabpeta'));
    $idjabpltpeta = addslashes($this->input->get('idjabpltpeta'));
    $jnsplt = addslashes($this->input->get('jnsplt'));
    //$pengurang = addslashes($this->input->get('pengurang'));

    $blnperiode = $this->mtppng2024->get_bulanperiode($idperiode);
    $blnperiode_gaji = '3'; // Pakai gaji bulan Maret 2024
    $thnperiode = $this->mtppng2024->get_tahunperiode($idperiode);

    // Get data fid peta jabatan pada TPP bulan Februari dan nanti compare dengan jabatan yang dipilih untuk THR
    $idjabpeta_tppfebruari = $this->mtppng2024->get_idjabpeta_tpp_bulanan($nip, $thnperiode, '2');
    $idjabpetaplt_tppfebruari = $this->mtppng2024->get_idjabpetaplt_tpp_bulanan($nip, $thnperiode, '2');

    $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $nama = $this->mpegawai->getnama($nip);
      $id_unker_nip = $this->mtppng2024->get_idunker_pns($nip);
    } else if ($jnsasn == "PPPK") {
      $nama = $this->mpppk->getnama($nip);
      $id_unker_nip = $this->mtppng2024->get_idunker_pppk($nip);
    }

    $telahusul = $this->mtppng2024->cektelahusul($nip, $thnperiode, $blnperiode);
    //$id_unker_nip = $this->mkinerja->get_idunker($nip);
    $id_unker_pengantar = $this->mtppng2024->get_idunker($idpengantar);

    if (!$nama) {
      echo "<div align='center' class='text text-warning'>Data tidak ditemukan, cek kembali data NIP.</div>";
    } else if ($id_unker_nip != $id_unker_pengantar) {
      echo "<div align='center' class='text text-primary'>Bukan ASN pada ".$this->munker->getnamaunker($id_unker_pengantar)."</div>";
    } else if ($telahusul != '0') {
      echo "<div align='center' class='text text-info'>TPP Bulan ".bulan($blnperiode)." ".$thnperiode." A.n. ".$nama."  TELAH DIHITUNG.
            <br/> Kalau ingin Hitung Ulang, hapus dulu perhitungan sebelumnya.</div>";
    } else if ($idjabpeta_tppfebruari == NULL) { // Jika ID peta jabatan TPP Februari tidak ditemukan brarti ybs tidak berhak TPP THR 2024
      echo "<div align='center' class='text text-danger'><b>TIDAK BERHAK THR TPP 2024</b></div>";
    } else if (($idjabpeta != $idjabpeta_tppfebruari) OR ($idjabpltpeta != $idjabpetaplt_tppfebruari)) {
      echo "<div align='center' class='text text-warning'>JABATAN YANG DIPILIH TIDAK SESUAI DENGAN JABATAN PADA TPP PERIODE FEBRUARI 2024</div>";	
    } else {
        if ($jnsasn == "PNS") {
          $statpeg = $this->mpegawai->getstatpeg($nip);
          $idgolru = $this->mpetajab->getidgolru($nip);
          $golru = $this->mpegawai->getnamagolru($idgolru);
          $pangkat = $this->mpegawai->getnamapangkat($idgolru);
          $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);
          $npwp = $this->mkinerja->get_npwp($nip);
          $jnsptkp = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode_gaji); // Ambil jenis PTKP dari Data Gaji
          //$jnsptkp = $this->mtppng2024->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga
        } else if ($jnsasn == "PPPK") {
          $statpeg = "PPPK";
          $idgolru = $this->mpppk->getidgolruterakhir($nip);
          $golru = $this->mpppk->getnamagolru($idgolru);
          $pangkat = "";
          $tmtjab = "";
          $npwp = $this->mkinerja_pppk->get_npwp($nip);;
          $jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
        }
	
        if (($jnsplt == 'plt100') AND ($idjabpltpeta != '')) {
          $kelasjab = $this->mpetajab->get_kelas($idjabpltpeta);
        } else {
          $kelasjab = $this->mpetajab->get_kelas($idjabpeta);
        }
        //echo "<br/>";
        $nmjab_atasan = $this->mpetajab->get_namajabatasan($idjabpeta);
        echo "<div class='row'>";
        echo "<div class='col-md-6'>
                <div class='well well-sm' style='font-size: 11px;'>
                <span class='text text-success'><b>IDENTITAS</b></span>
                  <div class='row'>
                    <div class='col-md-4'><b>NAMA</b></div>
                    <div class='col-md-8' align='left'>".$nama."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>STATUS</b></div>
                    <div class='col-md-8' align='left'>".$statpeg."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>PANGKAT/GOLRU</b></div>
                    <div class='col-md-8' align='left'>".$golru." (".$pangkat.")</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>KELAS JABATAN</b></div>
                    <div class='col-md-8' align='left'>".$kelasjab."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-4'><b>ATASAN LANGSUNG</b></div>
                    <div class='col-md-8' align='left'>".$nmjab_atasan."</div>
                  </div>
                </div>
              </div>";

        if ($jnsasn == "PNS") {
          $haktpp = $this->mkinerja->get_haktpp($nip);
          //$abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
          //$kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
          $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
        } if ($jnsasn == "PPPK") {
          $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
          //$abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
          //$kin = $this->mkinerja_pppk->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
          $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
        }

	$abs = 100;
	$kin = 100;

        echo "<div class='col-md-6'>
                <div class='well well-sm' style='font-size: 11px;'>
                <span class='text text-success' ><b>SYARAT PERHITUNGAN</b></span>
                <br/>";

        echo "<div class='row'>";
        if ($haktpp == "YA") {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>BERHAK TPP
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>BERHAK TPP
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
	echo "</div>";

	echo "<div class='row'>";
        if ($gaji) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>GAJI BULAN MARET
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>GAJI BULAN MARET
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>"; // End Row 3

	echo "<div class='row'>";
	// Cek apakah ybs mendapatkan TPP februari(2) yang diterima bulan maret
	$tppmaret = $this->mtppng2024->get_tpp_bulanan($nip, $thnperiode, '2')->result_array();
        if ($tppmaret) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>TPP BULAN MARET
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>TPP BULAN MARET
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>"; // End Row 3

        echo "<div class='row'>"; // Start Row 4
        echo "</div>"; // End ROw 4
        echo "</div>"; // End Well
        echo "</div>"; // End Kolom

        echo "</div>"; //End Row baris Kesatu

        //if ($haktpp AND ($abs != NULL) AND ($kin != NULL) AND $gaji AND $jnsptkp AND $dokskpbulanan AND $dokskptahunan AND $doklhkpn) {
	if ($haktpp AND $gaji AND $tppmaret) {
          // Jika Absensi NOL (TK sebulanan), maka Kinerja juga 0
          //if ($abs == 0) $kin = 0;

          $kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
          if (($kin == 'sangat baik') OR ($kin == 'baik')) {
              $ckin = 100;
              $kkin = "SANGAT BAIK";
          } else if ($kin == 'butuh perbaikan') {
              $ckin = 80;
              $kkin = "BUTUH PERBAIKAN";
          } else if ($kin == 'kurang') {
              $ckin = 60;
              $kkin = "KURANG";
          } else if ($kin == 'sangat kurang') {
              $ckin = 40;
              $kkin = "SANGAT KURANG";
          }
          $pabs = 0.4 * $abs; // persentase absensi (40%)

          echo "<div class='row'>"; // Start Row Penilaian Kinerja dan Kalkulasi
          echo "<div class='col-lg-6'>";
          echo "<div class='well well-sm' style='font-size: 11px;'>";
          echo "<div class='row'>"; // Row dalam Penilaian Kinerja
          echo "<div class='col-lg-6'>";
            $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)
            echo "<span class='text text-primary'><b>PENILAIAN KINERJA</b></span>
                    <br/>Nilai Kinerja : ".strtoupper($kin)."
                    <br/>Capaian : ".$ckin."
                    <br/>Persentase : ".$pkin;
            echo "<br/><br/>
                  <span class='text text-primary'><b>DISIPLIN KERJA</b></span>
                    <br/>Nilai Absensi : ".$abs."
                    <br/>Persentase : ".$pabs;
            $realisasi = $pkin + $pabs;

          echo "</div>"; // End kolom

          echo "<div class='col-md-6'>";
          echo "<span class='text text-success'><b>PERSENTASE PEROLEHAN TPP</b></span>
                    <h4><span class='text text-success'>".$realisasi." %</span></h4>";
          echo "</div>"; // End Kolom ke 2 dalam penilaian kinerja
          echo "</div>"; // End Row dalam penilaian kinerja

          echo "</div>"; // End Well Penilaian Kinerja
          echo "</div>"; // End Kolom

          if (($statpeg == 'PNS') OR ($jnsasn == "PPPK")) {
            if ($idjabpltpeta == '0') {
              $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta);
              $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta);
              $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta);
              $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta);
            } else if ($idjabpltpeta != '0') {
              if ($jnsplt == 'plt100') {
                $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpltpeta);
                $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpltpeta);
                $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpltpeta);
                $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpltpeta);
              } else if ($jnsplt == 'plt20') {
                $tpp_pk_plt = $this->mpetajab->get_tpp_pk($idjabpltpeta);
                $tpp_bk_plt = $this->mpetajab->get_tpp_bk($idjabpltpeta);
                $tpp_kk_plt = $this->mpetajab->get_tpp_kk($idjabpltpeta);
                $tpp_kp_plt = $this->mpetajab->get_tpp_kp($idjabpltpeta);

                $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) + ($tpp_pk_plt * 0.2);
                $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) + ($tpp_bk_plt * 0.2);
                $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) + ($tpp_kk_plt * 0.2);
                $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) + ($tpp_kp_plt * 0.2);
              } else {
                $tpp_pk = 0;
                $tpp_bk = 0;
                $tpp_kk = 0;
                $tpp_kp = 0;
              }
            }
          } else if ($statpeg == 'CPNS') {
            $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) * 0.8;
            $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) * 0.8;
            $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) * 0.8;
            $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) * 0.8;
          }

          $tpp_basic =  round($tpp_pk) +  round($tpp_bk) +  round($tpp_kk) +  round($tpp_kp);

          $rea_pk = ($realisasi * $tpp_pk) / 100;
          $rea_bk = ($realisasi * $tpp_bk) / 100;
          $rea_kk = ($realisasi * $tpp_kk) / 100;
          $rea_kp = ($realisasi * $tpp_kp) / 100;
          $rea_bruto = round($rea_pk) + round($rea_bk) + round($rea_kk) + round($rea_kp);

          if ($statpeg == 'CPNS') {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpeta)." : 80%";
          } else if ($idjabpltpeta == '') {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpeta);
          } else if (($jnsplt == 'plt100') AND ($idjabpltpeta != '')) {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpltpeta);
          } else if (($jnsplt == 'plt20') AND ($idjabpltpeta != '')) {
            $ket = "Basic Kelas ".$this->mpetajab->get_kelas($idjabpeta)." + 20% Basic Kelas ".$this->mpetajab->get_kelas($idjabpltpeta);
          } else {
            $ket = "Data kurang lengkap";
          }

          echo "<div class='col-md-6'>
                  <div class='well well-sm' style='font-size: 12px;'>
                  <span class='text text-primary'><b>KALKULASI TPP (".$ket.")</b></span>
                            <div class='row'>
                      <div class='col-md-5'><b>KRITERIA</b></div>
                      <div class='col-md-4' align='right'><b>BASIC</b></div>
                      <div class='col-md-3' align='right'><b>REALISASI (".$realisasi."%)</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>BEBAN KERJA</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_bk),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_bk),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>PRESTASI KERJA</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_pk),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_pk),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>KONDISI KERJA</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_kk),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_kk),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'>KELANGKAAN PROFESI</div>
                      <div class='col-md-4' align='right'>".number_format(round($tpp_kp),2,',','.')."</div>
                      <div class='col-md-3' align='right'>".number_format(round($rea_kp),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-5'><span class='text-success'><b>TOTAL</b></span></div>
                      <div class='col-md-4' align='right'><span class='text-success'><b>".number_format($tpp_basic,2,',','.')."</b></span></div>
                      <div class='col-md-3' align='right'><span class='text-success'><b>".number_format($rea_bruto,2,',','.')."</b></span></div>
                    </div>
                  </div>
                </div>";

          echo "</div>"; // end ROW KEDUA
          echo "</div>"; // End Row Penilaian dan Kalkulasi

          if ($jnsasn == "PNS") {
            $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
            $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
            $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
            $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
            $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($nip, $thnperiode, $blnperiode);
          } else if ($jnsasn == "PPPK") {
            $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
            $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode);
            $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode);
            $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode);
            $bpjs_gaji = $this->mtppng2024->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
          }

          $hasil_bruto = $gaji_bruto + $rea_bruto;


          if ($jnsasn == "PNS") {
                $pph_bayar = $this->mtppng2024->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
                $ptkpgaji = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode);
          } else if ($jnsasn == "PPPK") {
                $pph_bayar = $this->mtppng2024->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
                $ptkpgaji = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode);
          }

          $katpajak = $this->mtppng2024->get_kategori_pp582023($jnsptkp);

          echo "<div class='row'>"; // Start Row 3 (PPH, IWP, BPJS)
          echo "<div class='col-md-4'>
                  <div class='well well-sm' style='font-size: 11px;'>
                    <span class='text text-primary'><b>PPh 21</b></span>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Gaji Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($gaji_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>TPP Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($rea_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Penghasilan Bruto</div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'>".number_format($rea_bruto+$gaji_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-7'>PTKP | Kategori</div>
                      <div class='col-md-5' align='right'>".$ptkpgaji." | ".$katpajak."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tarif Pajak</div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'>".$this->mtppng2024->get_tarifpph21_pp582023($katpajak, $hasil_bruto)." %</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>PPh 21 TPP</div>
                      <div class='col-md-6' align='right'>".number_format($pph_bayar,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>PPh 21 Gaji</div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'>(".number_format($pph_gaji,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Potongan PPh 21</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($pph_bayar-$pph_gaji,2,',','.')."</b></span></div>
                    </div>
                  </div>
                </div>";

          // IWP 1%
          $iwp_tpp = $rea_bruto * 0.01;
          $iwp_total = $iwp_gaji + $iwp_tpp;
          if ($iwp_total > 120000) {
            $iwp_terhutang = 120000-$iwp_gaji;
          } else {
            $iwp_terhutang = $iwp_tpp;
          }
	  // Ketentuan THR 2024 Tnpa Potongan IWP
	  $iwp_tpp = 0;
	  $iwp_terhutang = 0;
          // End IWP 1%

          // BPJS 4%
          $bpjs_tpp = $rea_bruto * 0.04;
          $bpjs_total = $bpjs_gaji + $bpjs_tpp;
          if ($bpjs_total > 480000) {
            $bpjs_terhutang = 480000-$bpjs_gaji;
          } else {
            $bpjs_terhutang = $bpjs_tpp;
          }
	  // Ketentuan THR 2024 tanpa potongan BPJS
	  $bpjs_tpp = 0;
	  $bpjs_terhutang = 0;	  
	
          //End BPJS 4%

          echo "<div class='col-md-4'>
                  <div class='well well-sm' style='font-size: 11px;'>
                    <span class='text text-primary'><b>IWP 1%</b> <span class='text text-muted'>(Gaji + TPP) Maks. 120.000</span></span>
                    <div class='row'>
                      <div class='col-md-6'>IWP Gaji</div>
                      <div class='col-md-6' align='right'>".number_format($iwp_gaji,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>IWP TPP</div>
                      <div class='col-md-6' align='right'>".number_format($iwp_tpp,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Potongan IWP</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>TANPA POTONGAN</b></span></div>
                    </div>
                  </div>";


          echo "    <div class='well well-sm' style='font-size: 11px;'>
                    <span class='text text-primary'><b>BPJS 4%</b> <span class='text text-muted'>(Gaji + TPP) Maks. 480.000</span></span>
                    <div class='row'>
                      <div class='col-md-6'>BPJS Gaji</div>
                      <div class='col-md-6' align='right'>".number_format($bpjs_gaji,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>BPJS TPP</div>
                      <div class='col-md-6' align='right'>".number_format($bpjs_tpp,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Potongan BPJS</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>TANPA POTONGAN</b></span></div>
                    </div>
                  </div>";
          echo"   </div>"; // End kolom 2 Row 3

          //if ($statpeg == "PNS") {
          //if (($statpeg == "PNS") OR ($statpeg == "PPPK")) {
            $thp = round($rea_bruto) + round($bpjs_terhutang) + round($pph_bayar)- (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
          //  $ket_statpeg = "";
          //} else if ($statpeg == "CPNS") {
          //  $thp = ($rea_bruto + $bpjs_terhutang - ($pph_bayar+$iwp_terhutang+$bpjs_terhutang)) * 0.8; // CPNS 80%
          //  $ket_statpeg = "(CPNS 80%)";
          //}

          echo "<div class='col-md-4'>
                <div class='well well-sm' style='font-size: 11px;'>
                  <span class='text text-danger'><b>KALKULASI AKHIR</b></span><br/>
                    <div class='row'>
                      <div class='col-md-6' align='left'><b>Realisasi TPP</b></div>
                      <div class='col-md-6' align='right' style='margin-bottom:5px;'><b>".number_format(round($rea_bruto),2,',','.')."</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tunjangan PPh 21</div>
                      <div class='col-md-6' align='right'>".number_format(round($pph_bayar),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tunjangan BPJS</div>
                      <div class='col-md-6' align='right'>".number_format(round($bpjs_terhutang),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left' style='margin-bottom:5px;'><b>Total Tunjangan</b></div>
                      <div class='col-md-6' align='right'><b>".number_format(round($pph_bayar+$bpjs_terhutang),2,',','.')."</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Potongan PPh 21</div>
                      <div class='col-md-6' align='right'>(".number_format(round($pph_bayar),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Potongan IWP</div>
                      <div class='col-md-6' align='right'>(".number_format(round($iwp_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Potongan BPJS</div>
                      <div class='col-md-6' align='right'>(".number_format(round($bpjs_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left' style='margin-bottom:5px;'><b>Total Potongan</b></div>
                      <div class='col-md-6' align='right'><b>".number_format(round($pph_bayar+$iwp_terhutang+$bpjs_terhutang),2,',','.')."</b></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><b><span class='text text-danger'>TPP NETO</span></b></div>
                      <div class='col-md-6' align='right'>
                          <b><span class='text text-danger'>".number_format(round($thp,0),2,',','.')."</span></b>
                        </div>
                    </div>
                </div>
                </div>";
          echo "</div>"; // End Row 3

          echo "<div>"; // Start Row 4
          echo "<div class='col-md-10'>
                  <textarea class='form-control' rows='3' id='catatan' name='catatan' placeholder='WAJIB : Tulis catatan terkait kalkulasi TPP disini' value='' required>TPP THR 2024</textarea>
                </div>
                <div class='col-md-2' align='right'>";
          //if ($this->session->userdata('nip') == "198104072009041002") {
          echo "  <button type='submit' class='btn btn-success btn-outline' onclick=''>
                          <span class='glyphicon glyphicon-save' aria-hidden='true'></span><br/>SETUJU<br/>SIMPAN
                  </button>";
          //}
          echo "</div>"; // End Kolom tombol Simpan
          echo "</div>"; // End ROW 4

        } else {
          echo "<div align='center' class='text text-warning'>KALKULASI THR TIDAK DAPAT DILANJUTKAN, SYARAT PERHITUNGAN TIDAK LENGKAP</div>";
        }
    } // End Cek NIP
  } // End tampilkalkulasithr	 		 

  function tmbkalkthr_aksi() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));
    $nip = addslashes($this->input->post('nip'));
    $idjabpeta = addslashes($this->input->post('idjabpeta'));
    $jabatan = $this->mpetajab->get_namajab($idjabpeta);

    $blnperiode = $this->mtppng2024->get_bulanperiode($idperiode);
    $blnperiode_gaji = '3'; // Pakai gaji bulan Maret 2024
    $thnperiode = $this->mtppng2024->get_tahunperiode($idperiode);

    $jnsasn = $this->mtppng2024->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $statpeg = $this->mpegawai->getstatpeg($nip);
      $idgolru = $this->mpetajab->getidgolru($nip);
      $golru = $this->mpegawai->getnamagolru($idgolru);
      $pangkat = $this->mpegawai->getnamapangkat($idgolru);
      $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);
      $npwp = $this->mkinerja->get_npwp($nip);
      $jnsptkp = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode_gaji); // Ambil jenis PTKP dari Data Gaji
      //$jnsptkp = $this->mtppng2024->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga
    } else if ($jnsasn == "PPPK") {
      $statpeg = "PPPK";
      $idgolru = $this->mpppk->getidgolruterakhir($nip);
      $golru = $this->mpppk->getnamagolru($idgolru);
      $pangkat = "";
      $tmtjab = "";
      $npwp = $this->mkinerja_pppk->get_npwp($nip);
      $jnsptkp = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode_gaji); // Ambil jenis PTKP dari Data Gaji
      //$jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
    }

    //$idgolru = $this->mpetajab->getidgolru($nip);
    $id_unker = $this->mtppng2024->get_idunker($idpengantar);
    $idjabpltpeta = addslashes($this->input->post('idjabpltpeta'));
    $jabatanplt = $this->mpetajab->get_namajab($idjabpltpeta);
    $jnsplt = addslashes($this->input->post('jnsplt'));
    $pengurang = addslashes($this->input->post('pengurang'));

    //$statpeg = $this->mpegawai->getstatpeg($nip);

    if ($jnsasn == "PNS") {
      $haktpp = $this->mkinerja->get_haktpp($nip);
      //$abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      //$kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
      $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($nip, $thnperiode, $blnperiode_gaji);
    } if ($jnsasn == "PPPK") {
      $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
      //$abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      //$kin = $this->mkinerja_pppk->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
      $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode_gaji);
    }

    $abs = 100;
    $kin = 100;	

    if (($jnsplt == 'plt100') AND ($idjabpltpeta != '')) {
      $kelasjabplt = $this->mpetajab->get_kelas($idjabpltpeta);
      $kelasjab = $this->mpetajab->get_kelas($idjabpeta);
    } else {
      $kelasjabplt = '';
      $kelasjab = $this->mpetajab->get_kelas($idjabpeta);
    }

    //$kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);

    // Jika Absensi NOL (TK sebulanan), maka Kinerja juga 0
    //if ($abs == 0) $kin = 0;

    $kin = $this->mkinerja->get_realisasikinerja2024($nip, $thnperiode, $blnperiode);
    if (($kin == 'sangat baik') OR ($kin == 'baik')) {
        $ckin = 100;
        $kkin = "SANGAT BAIK";
    } else if ($kin == 'butuh perbaikan') {
        $ckin = 80;
        $kkin = "BUTUH PERBAIKAN";
    } else if ($kin == 'kurang') {
        $ckin = 60;
        $kkin = "KURANG";
    } else if ($kin == 'sangat kurang') {
        $ckin = 40;
        $kkin = "SANGAT KURANG";
    }

    $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)

    if ($pengurang != "mkd7h") {
            $pkin = 0.6 * $ckin;
    } else if ($pengurang == "mkd7h") {
            $pkin = 0.4 * $ckin;
    }

    //$abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
    $pabs = 0.4 * $abs; // persentase absensi (40%)
    $realisasi = $pkin + $pabs;

    if (($statpeg == 'PNS') OR ($jnsasn == "PPPK")) {
      if ($idjabpltpeta == '0') {
        $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta);
        $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta);
        $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta);
        $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta);
        $persenplt = 0;
      } else if ($idjabpltpeta != '0') {
        if ($jnsplt == 'plt100') {
          $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpltpeta);
          $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpltpeta);
          $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpltpeta);
          $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpltpeta);
          $persenplt = 100;
        } else if ($jnsplt == 'plt20') {
          $tpp_pk_plt = $this->mpetajab->get_tpp_pk($idjabpltpeta);
          $tpp_bk_plt = $this->mpetajab->get_tpp_bk($idjabpltpeta);
          $tpp_kk_plt = $this->mpetajab->get_tpp_kk($idjabpltpeta);
          $tpp_kp_plt = $this->mpetajab->get_tpp_kp($idjabpltpeta);

          $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) + ($tpp_pk_plt * 0.2);
          $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) + ($tpp_bk_plt * 0.2);
          $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) + ($tpp_kk_plt * 0.2);
          $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) + ($tpp_kp_plt * 0.2);
          $persenplt = 20;
        } else {
          $tpp_pk = 0;
          $tpp_bk = 0;
          $tpp_kk = 0;
          $tpp_kp = 0;
        }
      }
    } else if ($statpeg == 'CPNS') {
      $tpp_pk = $this->mpetajab->get_tpp_pk($idjabpeta) * 0.8;
      $tpp_bk = $this->mpetajab->get_tpp_bk($idjabpeta) * 0.8;
      $tpp_kk = $this->mpetajab->get_tpp_kk($idjabpeta) * 0.8;
      $tpp_kp = $this->mpetajab->get_tpp_kp($idjabpeta) * 0.8;
      $persenplt = 0;
    }

    $tpp_basic = round($tpp_pk) + round($tpp_bk) + round($tpp_kk) + round($tpp_kp);

    if ($pengurang == '') {
      $ket_pengurang = "";
      $rea_pk = ($realisasi * $tpp_pk) / 100;
      $rea_bk = ($realisasi * $tpp_bk) / 100;
      $rea_kk = ($realisasi * $tpp_kk) / 100;
      $rea_kp = ($realisasi * $tpp_kp) / 100;
    } else if ($pengurang == 'mkd7h') {
      $ket_pengurang = "40 % Produktifitas";
      $rea_pk = ($realisasi * $tpp_pk) / 100;
      $rea_bk = ($realisasi * $tpp_bk) / 100;
      $rea_kk = ($realisasi * $tpp_kk) / 100;
      $rea_kp = ($realisasi * $tpp_kp) / 100;
    } else if ($pengurang == 'k100') {
      $ket_pengurang = "100 % Basic";
      $rea_pk = 0;
      $rea_bk = 0;
      $rea_kk = 0;
      $rea_kp = 0;
    } else if ($pengurang == 'k40') {
      $ket_pengurang = "40 % Basic";
      $rea_pk = $tpp_pk * 0.4;
      $rea_bk = $tpp_bk * 0.4;
      $rea_kk = $tpp_kk * 0.4;
      $rea_kp = $tpp_kp * 0.4;
    } else if ($pengurang == 'k20') {
      $ket_pengurang = "20 % Basic";
      $rea_pk = $tpp_pk * 0.2;
      $rea_bk = $tpp_bk * 0.2;
      $rea_kk = $tpp_kk * 0.2;
      $rea_kp = $tpp_kp * 0.2;
    }
    $rea_bruto = round($rea_pk) + round($rea_bk) + round($rea_kk) + round($rea_kp);

    if ($jnsasn == "PNS") {
      $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
      $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
      $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
      $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji($nip, $thnperiode, $blnperiode);
    } else if ($jnsasn == "PPPK") {
      $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
      $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode);
      $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode);
      $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng2024->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
    }

    $hasil_bruto = $gaji_bruto + $rea_bruto;

    $biaya_jab = 0;

    //$npwp = $this->mkinerja->get_npwp($nip);
    //$jnsptkp = $this->mkinerja->get_jnsptkp($nip);
    // Hitung PPh21
    //$ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    //$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    if ($jnsasn == "PNS") {
        $ptkp = $this->mtppng2024->get_ptkpgaji_pns($nip, $thnperiode, $blnperiode_gaji);
        $pph_bayar = $this->mtppng2024->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    } else if ($jnsasn == "PPPK") {
        $ptkp = $this->mtppng2024->get_ptkpgaji_pppk($nip, $thnperiode, $blnperiode_gaji);
        $pph_bayar = $this->mtppng2024->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
    }

    //$iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);

    // IWP - Tidak dipotong
    $iwp_terhutang = 0;
    /*	
    $iwp_tpp = $rea_bruto * 0.01;
    $iwp_total = $iwp_gaji + $iwp_tpp;
    if ($iwp_total > 120000) {
      $iwp_terhutang = 120000-$iwp_gaji;
    } else {
      $iwp_terhutang = $iwp_tpp;
    }
    */

    // BPJS 4% - TIDAK TIPOTONG
    $bpjs_terhutang = 0;	
    /*	
    $bpjs_tpp = $rea_bruto * 0.04;
    $bpjs_total = $bpjs_gaji + $bpjs_tpp;
    if ($bpjs_total > 480000) {
      $bpjs_terhutang = 480000-$bpjs_gaji;
    } else {
      $bpjs_terhutang = $bpjs_tpp;
    }
    */


    $thp = (round($rea_bruto) + round($bpjs_terhutang) + round($pph_bayar)) - (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
    $catatan = addslashes($this->input->post('catatan'));

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();
    $data = array(
      'fid_pengantar'         => $idpengantar,
      'fid_periode'           => $idperiode,
      'nip'                   => $nip,
      'tahun'                 => $thnperiode,
      'bulan'                 => $blnperiode,
      'fid_jabpeta'           => $idjabpeta,
      'jabatan'               => $jabatan,
      'fid_golru'             => $idgolru,
      'fid_unker'             => $id_unker,
      'kelasjab'              => $kelasjab,
      'fid_jabpeta_plt'       => $idjabpltpeta,
      'jabatan_plt'           => $jabatanplt,
      'kelasjab_plt'          => $kelasjabplt,
      'persen_plt'            => $persenplt,
      'statuspeg'             => $statpeg,
      'nilai_produktifitas'   => $ckin,
      'capaian_produktifitas' => $kkin,
      'persen_produktifitas'  => $pkin,
      'nilai_disiplin'        => $abs,
      'persen_disiplin'       => $pabs,
      'realisasi_kinerja'     => $realisasi,
      'basic_bk'              => round($tpp_bk),
      'basic_pk'              => round($tpp_pk),
      'basic_kk'              => round($tpp_kk),
      'basic_kp'              => round($tpp_kp),
      'basic_total'           => round($tpp_basic),
      'ket_pengurang'         => $ket_pengurang,
      'real_bk'               => round($rea_bk),
      'real_pk'               => round($rea_pk),
      'real_kk'               => round($rea_kk),
      'real_kp'               => round($rea_kp),
      'real_total'            => round($rea_bruto),
      'gaji_bruto'            => $gaji_bruto,
      'pot_gaji'              => $pot_gaji,
      'pph_gaji'              => $pph_gaji,
      'biaya_jab'             => round($biaya_jab),
      'npwp'                  => $npwp,
      'jns_ptkp'              => $jnsptkp,
      'ptkp'                  => $ptkp,
      'jml_pph'               => round($pph_bayar),
      'iwp_gaji'              => round($iwp_gaji),
      'jml_iwp'               => round($iwp_terhutang),
      'jml_bpjs'              => round($bpjs_terhutang),
      'tpp_diterima'          => round($thp),
      'catatan'               => $catatan,
      'fid_status'            => '1', // status INPUT
      'entri_at'              => $tgl_aksi,
      'entri_by'              => $user
    );

    $where = array(
      'nip'             => $nip,
      'tahun'           => $thnperiode,
      'bulan'           => $blnperiode
    );

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mtppng2024->cektelahusul($nip, $thnperiode, $blnperiode) == 0) {
      if ($this->mtppng2024->input_tppng($data)) {
        $data['pesan'] = "<b>SUKSES</b>, TPP THR 2024 A.n. ".$nama." Bulan BERHASIL DITAMBAH.";
        $data['jnspesan'] = "alert alert-success";
      } else {
        $data['pesan'] = "<b>GAGAL</b>, TPP THR 2024 A.n. ".$nama." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-warning";
      }
    } else {// pernah usul
        $data['pesan'] = "<b>DATA RANGKAP</b>, TPP THR 2024 A.n. ".$nama." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-info";
    }

    $data['thn'] = $thnperiode;
    $data['bln'] = $blnperiode;

    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $idpengantar;
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiodeunor';
    $this->load->view('template', $data);

  }	

  public function cetak_tandaterimathr()
  {
    $nipbend = addslashes($this->input->post('nipbend'));
    $namabend = $this->mpegawai->getnama($nipbend);
    $nipkep = addslashes($this->input->post('nipkep'));
    $namakep = $this->mpegawai->getnama($nipkep);
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));

    $data = array(
      'nip_bendahara'   => $nipbend,
      'nama_bendahara'  => $namabend,
      'nip_kepala'      => $nipkep,
      'nama_kepala'     => $namakep
    );

    $where = array(
      'id' => $idpengantar
    );

    if ($this->mtppng2024->edit_tppngpengantar($where, $data)) {
      $data['pesan'] = '<b>SUKSES</b>, Spesimen Berhasil Disimpan';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>GAGAL</b>, Spesimen Gagal Disimpan';
      $data['jnspesan'] = 'alert alert-warning';
    }

    $data['$idpengantar'] = $idpengantar;
    $data['data'] = $this->mtppng2024->cetak_tandaterima($idpengantar, $idperiode)->result_array();
    $this->load->view('/tppng2024/cetaktandaterimathr',$data);
  }	

  function tampilskpbulanan() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'tppng2024/tampilskpbulanan';
      $this->load->view('template', $data);
    }
  }

  function showskpbulanan() {
    $idunker = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    $jns = $this->input->get('jns');
    if ($jns == "pns") {
      $warnatoptabel = "info";
      $ni = "NIP";	
    } else if ($jns == "pppk") {
      $warnatoptabel = "success";
      $ni = "NIPPPK";		
    }

    ?>
    <br/>
    <table class='table table-condensed table-hover' style='width: 95%'>
      <tr class='<?php echo $warnatoptabel; ?>'>
        <td align='center' width='10'><b>NO</b></td>
        <td align='left' width='150'><b><?php echo $ni; ?><br/>NAMA</b></td>
        <td align='left' width='350'><b>JABATAN | UNIT KERJA</b></td>
        <td align='left' width='300'><b>ATASAN PENILAI</b></td>
        <td align='left' width='150'><b>HASIL PENILAIAN</b></td>
        <td align='left' width='20'><b>DOKUMEN PENILAIAN</b></td>
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
      if ($jns == "pns") {
        echo "<td>NIP. ".$nip."<br/>".$nama."</td>";
      } else if ($jns == "pppk") {
        echo "<td>NIPPPK. ".$nip."<br/>".$nama."</td>";
      }
      if ($berhaktpp == 'YA') {
        $datakin = $this->mtppng2024->get_kinerja_bulanan($nip, $thn, $bln)->result_array();

        if ($datakin) {
          foreach($datakin as $d) :
	    if ($d['hasil_akhir'] == "") {
	      $blumdinilai = "danger";  		
	    } else {
	      $blumdinilai = "";		
	    }
	    if ($d['nip'] == $nip) {
	    //if (($d['nip'] == $nip) AND ($d['waktu_dinilai'])){

	      //var_dump($d['waktu_dinilai']);		
              echo "<td><small>".$d['skp_jabatan']."<br/>".$d['skp_unor']."<br/>".$d['skp_unor_induk']."</small></td>";
              //echo "<td><small><b>".$d['pegawai_atasan_nama']." (NIP. ".$d['pegawai_atasan_nip'].")</b><br/>".$d['pegawai_atasan_jabatan']."<br/>".$d['pegawai_atasan_unor']."</small></td>";
              echo "<td><small><b>".$d['pegawai_atasan_nama']." (NIP. ".$d['pegawai_atasan_nip'].")</b><br/>".$d['pegawai_atasan_jabatan']."</small></td>";
	      echo "<td align='right' class='".$blumdinilai."'>
		    <span class='text text-primary pull-left'>Hasil Kerja</span>
                    <span class='label label-primary'>".strtoupper($d['hasil_kerja'])."</span><br/>";
              echo "<span class='text text-warning pull-left'>Perilaku  Kerja</span>
                    <span class='label label-warning'>".strtoupper($d['perilaku_kerja'])."</span><br />";
              echo "<span class='text text-success pull-left'><small><b>PREDIKAT KINERJA</b></small></span>
                    <span class='label label-success'>".strtoupper($d['hasil_akhir'])."</span><br />";
	      echo "<small><span class='text text-muted pull-left'>Dinilai pada&nbsp</span>
                                <span class='text text-muted pull-left'>".tglwaktu_indo($d['waktu_dinilai'])."</span></small>";	
	      echo "</td>";

              //echo "<td>".tglwaktu_indo($d['waktu_dinilai'])."</td>";

	      if ($jns == "pns") {	
		if (file_exists('./fileskpbulanan/'.$d['berkas'].'.pdf')) {
                  $jnsfile = ".pdf";
              	} else if (file_exists('./fileskpbulanan/'.$d['berkas'].'.PDF')) {
                  $jnsfile = ".PDF";
              	}

	      	if ((file_exists('./fileskpbulanan/'.$d['berkas'].'.pdf')) OR (file_exists('./fileskpbulanan/'.$d['berkas'].'.PDF'))) {
              	?>
                  <td align='center'><a class='btn btn-info btn-outline btn-xs' href='../fileskpbulanan/<?php echo $d['berkas'].$jnsfile; ?>' target='_blank' role='button'>
                    <span class='fa fa-eye' aria-hidden='true'></span><br />Lihat Dokumen</a>
		  </td>	
              	<?php
              	} else {
	      	?> 	
		   <td align='center' class='danger'><span class='text text-muted'>Dokumen<br/>Belum Diupload</span></td>
	        <?php	
	        }
	      } else if ($jns == "pppk") {
		if (file_exists('./fileskpbulanan_pppk/'.$d['berkas'].'.pdf')) {
                  $jnsfile = ".pdf";
              	} else if (file_exists('./fileskpbulanan_pppk/'.$d['berkas'].'.PDF')) {
                  $jnsfile = ".PDF";
              	}
               
		if ((file_exists('./fileskpbulanan_pppk/'.$d['berkas'].'.pdf')) OR (file_exists('./fileskpbulanan_pppk/'.$d['berkas'].'.PDF'))) {
                ?>
                  <td align='center'><a class='btn btn-success btn-outline btn-xs' href='../fileskpbulanan_pppk/<?php echo $d['berkas'].$jnsfile; ?>' target='_blank' role='button'>
                    <span class='fa fa-eye' aria-hidden='true'></span><br />Lihat Dokumen</a>
                  </td>
                <?php
                } else {
                ?>
                   <td align='center' class='danger'><span class='text text-muted'>Dokumen<br/>Belum Diupload</span></td>
                <?php
                }
              }	 		
	  }
          endforeach;
          $ditemukan++;
        } else {
          echo "<td colspan='7' align='center' class='danger'><span class='text-danger'><b>DATA TIDAK DITEMUKAN</b></span></td>";
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

  }

  function updatestatuspengantar_aksi() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));
    $status = addslashes($this->input->post('status'));

    $data = array(
      'status'   => $status
    );

    $where = array(
      'fid_periode' => $idperiode,
      'id'          => $idpengantar
    );

    if ($this->mtppng2024->edit_tppngpengantar($where, $data)) {
      $data['pesan'] = '<b>Sukses</b>, Update Status Pengantar Berhasil';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, Update Status Pengantar Gagal';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->get_pengantar($idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiode';
    $this->load->view('template', $data);
  }

  function updatestatusperorangan_aksi() {
    $idperiode = addslashes($this->input->post('idperiode'));
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idunor = addslashes($this->input->post('id_unor'));	
    $id = addslashes($this->input->post('id'));
    $id_status = addslashes($this->input->post('status'));

    $data = array(
      'fid_status'   => $id_status
    );

    $where = array(
      'fid_periode' => $idperiode,	
      'fid_pengantar' => $idpengantar,
      'id'          => $id
    );

    if ($this->mtppng2024->edit_tppng($where, $data)) {
      $data['pesan'] = '<b>Sukses</b>, Update Status Perorangan Berhasil';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, Update Status Perorangan Gagal';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['idunor'] = $idunor;
    $data['idpengantar'] = $idpengantar;
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng2024->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng2024/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function tampilJabBlnLalu() {
    $nip = addslashes($this->input->get('nip'));
    $idperiode = addslashes($this->input->get('idperiode'));
    $jnsasn = addslashes($this->input->get('jnsasn'));
	
    $tahun = $this->mtppng2024->get_tahunperiode($idperiode-1);
    $bulan = $this->mtppng2024->get_bulanperiode($idperiode-1);	
    $data = $this->mtppng2024->get_tpp_bulanan($nip, $tahun, $bulan)->result_array();
    foreach($data as $d) {
	echo "<small>JABATAN PERIODE SEBELUMNYA (".strtoupper(bulan($bulan))." ".$tahun.") :<br/>";
	if ($d['jabatan_plt']) {
		echo "<span class='text text-success'>PLT. ".$d['jabatan_plt']." (KELAS : ".$d['kelasjab_plt'].")</span>";
	} else {
		echo "<span class='text text-success'>".$d['jabatan']." (KELAS : ".$d['kelasjab'].")</span>";
	}
	echo "<br/><span class='text text-success'>".$this->munker->getnamaunker($d['fid_unker'])."</span><br/><br/>";		
	echo "</small>";
    }
    
    // Untuk TPP Tahun 2025, jabatan otomatis dari peta jabatan
    /*
    if ($jnsasn == "PNS") {	
      $petajab_pns = $this->mpetajab->detailKomponenJabatan_pns($nip)->result_array();
      $detail_pns = $this->mpegawai->detail($nip)->result_array();
      if ($petajab_pns) {
        foreach($detail_pns as $pns) {
          $id_jnsjab = $pns['fid_jnsjab'];
          if ($id_jnsjab == '1') {
            $id_jab = $pns['fid_jabatan'];
          } else if ($id_jnsjab == '2') {
            $id_jab = $pns['fid_jabfu'];
          } else if ($id_jnsjab == '3') {
            $id_jab = $pns['fid_jabft'];
          }

          $id_unker = $pns['fid_unit_kerja'];
        }

	foreach($petajab_pns as $dp) {
          $idjabpeta = $dp['id'];
          $idunker_pj = $dp['fid_unit_kerja'];
          $nmjab_pj = $this->mpetajab->get_namajab($dp['id']);
          $idjnsjab_pj = $dp['fid_jnsjab'];
          if ($idjnsjab_pj == '1') {
            $idjab_pj = $dp['fid_jabstruk'];
          } else if ($idjnsjab_pj == '2') {
            $idjab_pj = $dp['fid_jabfu'];
          } else if ($idjnsjab_pj == '3') {
            $idjab_pj = $dp['fid_jabft'];
          }
          $unor = $this->mpetajab->get_namaunor($dp['fid_atasan']);
          $kelas = $dp['kelas'];
        }
	$status = "DONE";
      } else {
        echo "<div class='form-group input-group'>
            <span class='input-group-addon' style='font-size: 12px;'><span class='text text-danger'>JABATAN ASN TIDAK TERDAPAT PADA PETA JABATAN</span></span>";
        echo "</div>";
	$status = "FAILURE";
      }	

    } else if ($jnsasn == "PPPK") {
      $petajab_pppk = $this->mpetajab->detailKomponenJabatan_pppk($nip)->result_array();
      $detail_pppk = $this->mpppk->detail($nip)->result_array();
      if ($petajab_pppk) {
        foreach($detail_pppk as $pppk) {
          $id_jab = $pppk['fid_jabft'];
	  $id_jnsjab = 3; // Hanya JFT
          $id_unker = $pppk['fid_unit_kerja'];
        }

        foreach($petajab_pppk as $dk) {
          $idjabpeta = $dk['id'];
          $idunker_pj = $dk['fid_unit_kerja'];
          $nmjab_pj = $this->mpetajab->get_namajab($dk['id']);
          $idjnsjab_pj = $dk['fid_jnsjab'];
          if ($idjnsjab_pj == '1') {
            $idjab_pj = $dk['fid_jabstruk'];
          } else if ($idjnsjab_pj == '2') {
            $idjab_pj = $dk['fid_jabfu'];
          } else if ($idjnsjab_pj == '3') {
            $idjab_pj = $dk['fid_jabft'];
          }
          $unor = $this->mpetajab->get_namaunor($dk['fid_atasan']);
          $kelas = $dk['kelas'];
        }
        $status = "DONE";
      }	
    }

    if ($status == "DONE") {
      if (($id_unker == $idunker_pj) AND ($id_jnsjab == $idjnsjab_pj) AND ($id_jab == $idjab_pj)) {
        echo "<span class='text text-info'>Jabatan Definitif untuk perhitungan TPP Periode ".bulan($bulan+1)." ".$tahun."</span>";
        echo "<div class='form-group input-group'>
            <span class='input-group-addon' style='font-size: 12px;'>Jabatan Definitif</span>";
        echo "<textarea class='form-control' style='font-size: 12px;' disabled>".$nmjab_pj." (KELAS : ".$kelas.")
".$unor."</textarea>";
        echo "<input class='form-control' name='idjabpeta' id='idjabpeta' type='hidden' value='".$idjabpeta."'  style='font-size: 12px;' disabled>";
        echo "</div>";
      } else {
        echo "<div class='form-group input-group'>
            <span class='input-group-addon' style='font-size: 12px;'><span class='text text-warning'>JABATAN PROFIL ASN TIDAK SESUAI DENGAN JABATAN PADA PETA JABATAN</span></span>";
        echo "</div>";
      } 
    }
    */
	
    // End untuk TPP 2025
  }

}
