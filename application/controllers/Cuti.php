<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuti extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');      
      $this->load->helper('fungsiterbilang');
      $this->load->model('mpegawai');
      $this->load->model('mpppk');
      $this->load->model('mstatistik');
      $this->load->model('munker');
      $this->load->model('mcuti');
      $this->load->model('datacetak');

      // untuk pagination
      $this->load->helper(array('url'));

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // untuk fpdf
      $this->load->library('fpdf');

      // untuk barcode
      //$this->load->library('zend');
      //$this->zend->load('Zend/Barcode');
    }
  
  function tampilpengantar()
  {
    if ($this->session->userdata('usulcuti_priv') == "Y") { 
      $data['cuti'] = $this->mcuti->tampilpengantar()->result_array();      
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'cuti/tampilpengantarcuti';
      $this->load->view('template',$data);
    }
  }

  function tampilproses()
  {
    if ($this->session->userdata('usulcuti_priv') == "Y") { 
      $data['cuti'] = $this->mcuti->tampilproses()->result_array();      
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'cuti/tampilprosescuti';
      $this->load->view('template',$data);
    }
  }

  // tampilkan detail usul cuti dalam 1 pengantar
  function detailpengantar() { //$nip = $this->input->post('nip');
    $idpengantar = $this->input->post('id_pengantar');
    $kelompok_cuti = $this->mcuti->getkelompok($idpengantar);
      
    $get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
    if ($get_jnsasn == "PNS") {
	$data['cuti'] = $this->mcuti->detailpengantar($idpengantar, $kelompok_cuti)->result_array();
	 $data['jmldata'] = count($this->mcuti->detailpengantar($idpengantar, $kelompok_cuti)->result_array());
    } else if ($get_jnsasn == "PPPK") {
	$data['cuti'] = $this->mcuti->detailpengantar_pppk($idpengantar)->result_array();
	$data['jmldata'] = count($this->mcuti->detailpengantar_pppk($idpengantar)->result_array());
    }	
    $data['nopengantar'] = $this->mcuti->getnopengantar($idpengantar);
    $data['idpengantar'] = $idpengantar;
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
      
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $data['content'] = 'cuti/detailpengantarcuti';   
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $data['content'] = 'cuti/detailpengantarcutitunda';   
    }
    
    $this->load->view('template', $data); 
  }

  // tampilkan detail usul cuti yg telah dikirim ke BKPPD, dgn status selain INBOXSKPD, CETAKUSUL
  // tanpa paging
  /*
  function tampilinbox() {
    if ($this->session->userdata('usulcuti_priv') == "Y") { 
      $data['cuti'] = $this->mcuti->tampilinbox()->result_array();
      $data['jmldata'] = count($this->mcuti->tampilinbox()->result_array());
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'tampilinbox';
      $this->load->view('template',$data);
    }    
  }
  */


  // tampilkan detail usul cuti yg telah dikirim ke BKPPD, dgn status selain INBOXSKPD, CETAKUSUL
  // tampil inbox dengan paging
  function tampilinbox() {
    if ($this->session->userdata('usulcuti_priv') == "Y") { 
      $data['jmldata'] = $this->mcuti->jmltampilinbox();  

      // untuk paging versi dumet
      $this->load->library('pagination');
      $config['base_url'] = base_url().'cuti/tampilinbox';
      $config['total_rows'] = $this->mcuti->jmltampilinbox();
      $config['per_page'] = $per_page = 4;
      $config['uri_segment'] = 3;
      $config['first_link'] = 'Awal';
      $config['last_link'] = 'Akhir';
      $config['next_link'] = 'Selanjutnya';
      $config['prev_link'] = 'Sebelumnya';

      //$config['cur_tag_open'] = ' <strong>';
      //$config['cur_tag_close'] = '</strong>';
      //Tambahan untuk styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

      $this->pagination->initialize($config);
      $data['paging'] = $this->pagination->create_links();
      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      
      $data['cuti'] = $this->mcuti->tampilinbox($per_page,$page)->result_array();
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'cuti/tampilinbox';     

      $this->load->view('template',$data);
    }
  }    

  // tampilkan detail usul proses cuti (status BKPPD) dalam 1 pengantar
  function detailproses() {
    if ($this->session->userdata('prosescuti_priv') == "Y") { 
      $idpengantar = $this->input->post('id_pengantar');
      $kelompok_cuti = $this->mcuti->getkelompok($idpengantar);
        
      $data['nopengantar'] = $this->mcuti->getnopengantar($idpengantar);
      $get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
      if ($get_jnsasn == "PNS") {		
      	$data['cuti'] = $this->mcuti->detailproses($idpengantar, $kelompok_cuti)->result_array();
      	$data['jmldata'] = count($this->mcuti->detailproses($idpengantar, $kelompok_cuti)->result_array());
      } else if ($get_jnsasn == "PPPK") {
	$data['cuti'] = $this->mcuti->detailproses_pppk($idpengantar, $kelompok_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailproses_pppk($idpengantar, $kelompok_cuti)->result_array());
      }		

      $data['idpengantar'] = $idpengantar;
      //$data['jmldata'] = count($this->mcuti->detailproses($idpengantar, $kelompok_cuti)->result_array());
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
        
      if ($kelompok_cuti == 'CUTI LAINNYA') {
        $data['content'] = 'cuti/detailprosescuti';   
      } else if ($kelompok_cuti == 'CUTI TUNDA') {
        $data['content'] = 'cuti/detailprosescutitunda';   
      }
      
      $this->load->view('template', $data);
    } 
  }

  function detailusul() {
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $idpengantar = $this->input->post('fid_pengantar');
    $get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
    $kelompok_cuti = $this->mcuti->getkelompok($idpengantar);
    $nip = $this->input->post('nip');

    if ($get_jnsasn == "PNS") {
        $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array());
    } else if ($get_jnsasn == "PPPK") {
        $data['cuti'] = $this->mcuti->detailusul_pppk($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array());
    }
    $data['content'] = 'cuti/detailusulcuti';
    $data['idpengantar'] = $idpengantar;

    /*
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();  
      $data['content'] = 'cuti/detailusulcuti';   
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $data['cuti'] = $this->mcuti->detailusultunda($nip, $idpengantar)->result_array();
      $data['content'] = 'cuti/detailusulcutitunda';   
    }
    */

    //$data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar)->result_array();
    //$data['content'] = 'detailusulcuti'; 
    $this->load->view('template', $data); 
  }
  
  function prosesusul() {
    $idpengantar = $this->input->post('fid_pengantar');
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $nip = $this->input->post('nip');
    $data['idpengantar'] = $idpengantar;
    $get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
    if ($get_jnsasn == "PNS") {
        $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array());
    } else if ($get_jnsasn == "PPPK") {
        $data['cuti'] = $this->mcuti->detailusul_pppk($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array());
    }

    //$data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();

    // untuk menampilkan riwayat SKP dan riwayat cuti
    $data['rwyskp'] = $this->mpegawai->dtlskp($nip, $thn_cuti-1)->result_array();
    $data['rwycuti'] = $this->mpegawai->rwycuti($nip)->result_array();       
    $data['rwycutitunda'] = $this->mpegawai->rwycutitunda($nip)->result_array();

    $data['content'] = 'cuti/detailprosesusul'; 
    $this->load->view('template', $data); 
  }

  function prosesusul_tunda() {
    $idpengantar = $this->input->post('fid_pengantar');
    $nip = $this->input->post('nip');
    $data['idpengantar'] = $idpengantar;
    $data['cuti'] = $this->mcuti->detailusultunda($nip, $idpengantar)->result_array();
    $data['content'] = 'cuti/detailprosesusultunda'; 
    $this->load->view('template', $data); 
  }

  function tambahpengantar(){           
    $data['unker'] = $this->munker->dd_unker()->result_array();
    //$data['golru'] = $this->mpegawai->golru()->result_array();
    $data['content'] = 'cuti/tambahpengantarcuti';
    $this->load->view('template', $data);
  }

  function tambahusul() {
    $data['idpengantar'] = $this->input->post('id_pengantar');
    $kelompok_cuti = $this->mcuti->getkelompok($data['idpengantar']);    
    
    $data['nopengantar'] = $this->mcuti->getnopengantar($data['idpengantar']);
    $data['tglpengantar'] = $this->mcuti->gettglpengantar($data['idpengantar']);
    
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $data['jnscuti'] = $this->mcuti->jnscuti()->result_array();
      $data['content'] = 'cuti/tambahusulcuti';
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $data['content'] = 'cuti/tambahusulcutitunda';
    }

    $this->load->view('template', $data);
  }

  function editusul() {
    $nip = $this->input->post('nip');
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $idpengantar = $this->input->post('fid_pengantar');    
    $data['nopengantar'] = $this->mcuti->getnopengantar($idpengantar);
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['tglpengantar'] = $this->mcuti->gettglpengantar($idpengantar);
    $data['nip'] = $nip;
    $data['fid_pengantar'] = $idpengantar;
    $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
    $data['jnscuti'] = $this->mcuti->jnscuti()->result_array();
    $data['content'] = 'cuti/editusulcuti';
    $this->load->view('template', $data);
  }

  function updatebtl() {
    $nip = $this->input->post('nip');
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $idpengantar = $this->input->post('fid_pengantar');

    $data['nopengantar'] = $this->mcuti->getnopengantar($idpengantar);
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['tglpengantar'] = $this->mcuti->gettglpengantar($idpengantar);
    $data['nip'] = $nip;
    $data['fid_pengantar'] = $idpengantar;
    $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
    $data['jnscuti'] = $this->mcuti->jnscuti()->result_array();
    $data['content'] = 'cuti/updateusulbtl';
    $this->load->view('template', $data);
  }

  function detailtms() {
    $idpengantar = $this->input->post('fid_pengantar');
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $kelompok_cuti = $this->mcuti->getkelompok($idpengantar);
    $nip = $this->input->post('nip');

    $data['idpengantar'] = $idpengantar;
    $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();  
    $data['content'] = 'cuti/detailusultms';   
    $this->load->view('template', $data); 
  }


  // untuk ajax data cuti dgn metode get
  function getdatacuti() {
    $nip = $this->input->get('nip');
    $idpengantar = $this->input->get('idpengantar');
    $jnsasn = $this->mcuti->get_jnsasn($idpengantar);

    $kel = $this->input->get('kel');
    $thnusul = $this->input->get('thn');	
    // cek apakah nip/nipppk berada pada unit kerja sesuai hak user, dgn metode getnama_session
    if ($jnsasn == "PNS") {
	$nama = $this->mpegawai->getnama_session($nip);
    } else if ($jnsasn == "PPPK") {
	$nama = $this->mpppk->getnama_lengkap($nip);
    }	
    // cek apakah NIP pernah diusulkan tahun ini date('Y')
    //$pernahusul = $this->mcuti->cektelahusul($nip, $thnusul, $kel);

    //cek SKP dan filenya
    $tahun = $thnusul-1;    
    $nmfile = $nip."-".$tahun;
    $skpada = $this->mpegawai->cekskpthn($nip, $tahun);

    //$tmtcpns = $this->mpegawai->gettmtcpns($nip);

    if ($nama) {
      $get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
      if ($get_jnsasn == "PNS") {
        $lokasifile = './photo/';
	$filename = "$nip.jpg";
      } else if ($get_jnsasn == "PPPK") {
	$lokasifile = './photononpns/';
        $filename = $this->mpppk->getphoto($nip);
      }	

      //$lokasifile = './photo/';
      //$filename = "$nip.jpg";

      if (file_exists ($lokasifile.$filename)) {
	if ($get_jnsasn == "PNS") {
        	$photo = "../photo/$nip.jpg";
	} else if ($get_jnsasn == "PPPK") {
		$photo = "../photononpns/$filename";
	}
      } else {
        $photo = "../photo/nophoto.jpg";
      }

      echo "<center><img src='$photo' width='75' height='90' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
 	
      /*
      if ($pernahusul) {
        // echo "<center><b><span style='color: #FF0000'>ASN pernah diusulkan pada pengantar<br />Nomor : ".$this->mcuti->getnopengantarbynip($nip,date('Y'))."<br />Tanggal : ".tgl_indo($this->mcuti->gettglpengantarbynip($nip,date('Y')))."</span></b></center>";
    	   echo "<center><img src='$photo' width='60' height='80' alt='$nip.jpg' class='img-thumbnail'><br />$nama";      
    	   echo "<center><b><span style='color: #FF0000'>Usul CUTI TAHUNAN Tahun ".$thnusul." sedang diproses</span></b></center>";
        // cek apakah data riwayat SKP ada	
      } 
	else if (($skpada == 0) AND ($tmtcpns != $tahun)) {
          echo "<center><img src='$photo' width='60' height='80' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
          echo "<center><b><span style='color: #FF0000'>Data SKP Tahun ".$tahun." tidak ditemukan dalam riwayat SKP</span></b></center>";
        // cek jika file SKP tidak ada
      } else if ((!file_exists('./fileskp/'.$nmfile.'.pdf')) AND (!file_exists('./fileskp/'.$nmfile.'.PDF')) AND ($tmtcpns != $tahun)) {
          echo "<center><img src='$photo' width='60' height='80' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
          echo "<center><b><span style='color: #FF0000'>File Berkas SKP Tahun ".$tahun." belum diupload</span></b></center>";
      } else {
          echo "<center><img src='$photo' width='60' height='80' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
          echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
          echo "<br />      
              <button type='submit' class='btn btn-success btn-sm'>
              <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
              </button>
              </center>";        
      } 
      */
    } else {
        echo "<center><b><span style='color: #FF0000'>ASN tidak ditemukan,<br/>atau berada diluar kewenangan anda.</span></b></center>";
    }    
    
  }

  // untuk ajax data cuti dgn metode post
  /*
  function postdatacuti() {
    $nip = $this->input->post('nip');    // kalau menggunakan metode post untuk ajax
    //$nip = $this->input->get('nip');    
    $nama = $this->mpegawai->getnama($nip);    
    echo "<center><img src='../photo/$nip.jpg' width='90' height='120' alt='$nip.jpg'>";
    echo "<br />$nama</center>";
  }
  */

  // untuk ajax tambahan keterangan sesuai jenis cuti dgn metode post  
  function showketcuti() {
    $idjc = $this->input->get('idjnscuti');
    $idpengantar = $this->input->get('idpengantar');
    $thnusul = $this->input->get('thn');
    $nip = $this->input->get('nip');
    $kel = $this->input->get('kel');
    $jnscuti = $this->mcuti->getnamajeniscuti($idjc);

    $jnsasn = $this->mcuti->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
	$nama = $this->mpegawai->getnama_session($nip);
    	if ($nip == "" OR $thnusul == "" OR $jnscuti == "") {
      		echo "<div align='center'><span class='text-warning'><b>Lengkapi data NIP, Tahun Cuti, dan Jenis Cuti</b></span></div>";	
    	} else if ($jnscuti == 'CUTI TAHUNAN') {
      		$sp = $this->mpegawai->getstatpeg($nip);
      		if ($sp == "PNS") {
      			echo "<input type='hidden' name='hari_tunda' size='10' maxlength='2' value='0' />";
      			//echo "+ cuti tunda : <input type='text' name='hari_tunda' size='10' maxlength='2' value='0' onkeyup='validAngka(this)' /> hari";
      
      			// cek apakah nip berada pada unit kerja sesuai hak user, dgn metode getnama_session
      			$nama = $this->mpegawai->getnama_session($nip);
      			// cek apakah NIP pernah diusulkan tahun ini date('Y')
      			$pernahusul = $this->mcuti->cektelahusul($nip, $thnusul, $kel);
      			$tahun = $thnusul-1;
      			$skpada = $this->mpegawai->cekskpthn($nip, $tahun);
      			$nmfile = $nip."-".$tahun;
      			$tmtcpns = $this->mpegawai->gettmtcpns($nip);
    
      			if ($pernahusul) {
        			echo "<div align='center'><b><span style='color: #FF0000'>Usul CUTI TAHUNAN Tahun ".$thnusul." sedang diproses</span></b></center>";
      			} 
      			//	else if (($skpada == 0) AND ($tmtcpns != $tahun)) {
      			//    echo "<br/><b><span style='color: #FF0000'>DATA SKP TAHUN ".$tahun."<br/>TIDAK DITEMUKAN DALAM RIWAYAT SKP</span></b></center>";
      			//} else if ((!file_exists('./fileskp/'.$nmfile.'.pdf')) AND (!file_exists('./fileskp/'.$nmfile.'.PDF')) AND ($tmtcpns != $tahun)) {
      			//    echo "<br/><b><span style='color: #FF0000'>FILE BERKAS SKP TAHUN ".$tahun."<br/>BELUM DIUPLOAD</span></b></center>";
      			//} 
			else {
          			echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
          			echo "<br /><div align='center'>
              				<button type='submit' class='btn btn-success btn-sm'>
              				<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan Usul
              			</button></div>";
      			}
      		} else if ($sp == "CPNS"){
			echo "<br/><div align='center'><span class='text-danger'><b>STATUS MASIH CPNS</b></span></div>";
      		}
	
    	} else if ($jnscuti == 'CUTI SAKIT') {
      		echo "<br/><div align='center'>Keterangan sakit : <input type='text' name='ketjnscuti' size='50' maxlength='' value='' required />";
      		echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
      		echo "<br /><br/>
	    		<button type='submit' class='btn btn-success btn-sm'>
            		<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan Usul
            		</button></div>";
    	} else if ($jnscuti == 'CUTI BERSALIN') {
      		echo "<br/><div align='center'>Untuk persalinan yang ke : <input type='text' name='ketjnscuti' size='10' maxlength='2' onkeyup='validAngka(this)' required />";  
      			echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
      		echo "<br /><br />
            		<button type='submit' class='btn btn-success btn-sm'>
            		<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan Usul
            		</button></div>";
    	} else if ($jnscuti == 'CUTI BESAR') {
      		$mkcpnsthn = getmkcpns_pilih($nip, "TAHUN");
      		$mkcpnsbln = getmkcpns_pilih($nip, "BULAN");
      		//echo $mkcpnsthn," ",$mkcpnsbln;
      		if ($mkcpnsthn >= '5') {
      			echo "<br/><div align='center'>Telah bekerja secara terus menerus selama : ".$mkcpnsthn." Tahun, ".$mkcpnsbln." Bulan";
	      		//echo "<input type='text' name='ketjnscuti' size='5' maxlength='' value='$mkcpnsthn' required disabled /> tahun";  
      			echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
      			echo "<br /><br />
            			<button type='submit' class='btn btn-success btn-sm'>
            			<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan Usul
            			</button></div>";
      		} else {
			echo "<br/><div align='center'><span class='text-danger'><b>MASA KERJA KURANG DARI 5 TAHUN</b></span></div>";
      		}
    	} else {
      		echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
      		echo "<br /><div align='center'>
            		<button type='submit' class='btn btn-success btn-sm'>
            		<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan Usul
            		</button></div>";
    	}
    } else if ($jnsasn == "PPPK") {
	$nama = $this->mpppk->getnama_lengkap($nip);
	if ($nip == "" OR $thnusul == "" OR $jnscuti == "") {
                echo "<div align='center'><span class='text-warning'><b>Lengkapi data NIPPPK, Tahun Cuti, dan Jenis Cuti</b></span></div><br/>";
        } else if ($nama) {
		echo "<br/><div align='center'>KETERANGAN ALASAN CUTI<br/>
		      <input type='text' name='ket_jns_cuti' size='70' maxlength='100' value='' required />";
                echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
                echo "<br /><br /><div align='center'>
                        <button type='submit' class='btn btn-success btn-sm'>
                        <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSIMPAN USUL CUTI
                        </button></div>";
	} else {
        	echo "<center><b><span style='color: #FF0000'>ASN tidak ditemukan,<br/>atau berada diluar kewenangan anda.</span></b></center>";
    	}
    }	
  }

  public function cetakusul()  
  {
    $res['data'] = $this->datacetak->datacetakusulcuti();
    $this->load->view('/cuti/cetakusulcutibaru',$res);    
  }

  // cetak pengantar khusu cuti lainnya tidak digabung dengan cuti tunda
  //public function cetakpengantar()  
  //{
  // $fid_unit_kerja = $this->input->post('fid_unit_kerja');
  // //$res['namaunker'] = $this->munker->getnamaunker($fid_unit_kerja);
  //  $res['data'] = $this->datacetak->datacetakpengantarcuti();
  //  $this->load->view('cetakpengantarcuti',$res);    
  //}

  // cetak pengant untuk cuti lainnya dan cuti tunda
  public function cetakpengantar()  
  {
    $id_pengantar = $this->input->post('id_pengantar');
    $fid_unit_kerja = $this->input->post('fid_unit_kerja');

    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $res['data'] = $this->datacetak->datacetakpengantarcuti();
      $this->load->view('/cuti/cetakpengantarcuti',$res);    
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $res['data'] = $this->datacetak->datacetakpengantarcutitunda();
      $this->load->view('/cuti/cetakpengantarcutitunda',$res);    
    }
  }

  public function cetaksk()  
  {
    $res['data'] = $this->datacetak->datacetakskcuti();
    $this->load->view('/cuti/cetakskcuti',$res);    
  }

  public function cetaksk_skpd()  
  {
    $res['data'] = $this->datacetak->datacetakskcuti();
    $this->load->view('/cuti/cetakskcuti_skpd',$res);    
  }

  public function cetaksk_tunda()  
  {
    $res['data'] = $this->datacetak->datacetakskcuti_tunda();
    $this->load->view('/cuti/cetakskcuti_tunda',$res);    
  }

  public function kirim_kebkppd()  
  {
    $id_pengantar = $this->input->post('id_pengantar');
    $fid_unit_kerja = $this->input->post('fid_unit_kerja');
    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    $tgl_kirim = $this->mlogin->datetime_saatini();

    // update status cuti : INBOXBKPPD => 3 berdasarkan id_pengantar
    $id_statcuti = 3;  // status cuti : INBOXBKPPD
    $datacuti = array(      
      'fid_status'      => $id_statcuti,
      'tgl_kirim_usul'  => $tgl_kirim
    );

    $wherecuti = array(
    'fid_pengantar'   => $id_pengantar
    );

    // update status pengantar : BKPPD => 3 berdasarkan id_pengantar dan fid_unit_kerja
    $id_statpengantar = 3;  // status pengantar : BKPPD
    $datapengantar = array(      
      'fid_status'      => $id_statpengantar
    );

    $wherepengantar = array(
    'id_pengantar'   => $id_pengantar,
    'fid_unit_kerja'   => $fid_unit_kerja
    );
    
    // rubah fid_status cuti sesuai data array diatas, 3 => INBOXBKPPD
    $jnsasn = $this->mcuti->get_jnsasn($id_pengantar);
    if ($jnsasn == "PNS") {
    	if ($this->mcuti->edit_usul($wherecuti, $datacuti)) {
        	// rubah status pengantar menjadi : 3 => BKPPD
        	$this->mcuti->edit_pengantar($wherepengantar, $datapengantar);

        	// kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        	$data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mcuti->getnopengantar($id_pengantar).'</u> berhasil dikirim.';
        	$data['jnspesan'] = 'alert alert-success';
    	} else {
        	$data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mcuti->getnopengantar($id_pengantar).'</u> gagal dikirim.';
        	$data['jnspesan'] = 'alert alert-danger';
    	}   
    } else if ($jnsasn == "PPPK") {
        if ($this->mcuti->edit_usul_pppk($wherecuti, $datacuti)) {
                // rubah status pengantar menjadi : 3 => BKPPD
                $this->mcuti->edit_pengantar($wherepengantar, $datapengantar);

                // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
                $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mcuti->getnopengantar($id_pengantar).'</u> berhasil dikirim.';
                $data['jnspesan'] = 'alert alert-success';
        } else {
                $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mcuti->getnopengantar($id_pengantar).'</u> gagal dikirim.';
                $data['jnspesan'] = 'alert alert-danger';
        }
    }


    $data['cuti'] = $this->mcuti->tampilpengantar()->result_array();
    $data['content'] = 'cuti/tampilpengantarcuti';
    $this->load->view('template', $data);

    //$data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    //$data['cuti'] = $this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array();
    //$data['idpengantar'] = $id_pengantar;
    //$data['jmldata'] = count($this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array());
    //$data['content'] = 'detailpengantarcuti'; 
    //$this->load->view('template', $data);
  }

  public function kirimtunda_kebkppd()  
  {
    $id_pengantar = $this->input->post('id_pengantar');
    $fid_unit_kerja = $this->input->post('fid_unit_kerja');
    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    $tgl_kirim = $this->mlogin->datetime_saatini();

    // update status cuti : INBOXBKPPD => 3 berdasarkan id_pengantar
    $id_statcuti = 3;  // status cuti : INBOXBKPPD
    $datacuti = array(      
      'fid_status'      => $id_statcuti,
      'tgl_kirim_usul'  => $tgl_kirim
    );

    $wherecuti = array(
    'fid_pengantar'   => $id_pengantar
    );

    // update status pengantar : BKPPD => 3 berdasarkan id_pengantar dan fid_unit_kerja
    $id_statpengantar = 3;  // status pengantar : BKPPD
    $datapengantar = array(      
      'fid_status'      => $id_statpengantar
    );

    $wherepengantar = array(
    'id_pengantar'   => $id_pengantar,
    'fid_unit_kerja'   => $fid_unit_kerja
    );


    
    // rubah fid_status cuti sesuai data array diatas, 3 => INBOXBKPPD
    if ($this->mcuti->edit_usultunda($wherecuti, $datacuti)) {

        // rubah status pengantar menjadi : 3 => BKPPD
        $this->mcuti->edit_pengantar($wherepengantar, $datapengantar);

        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda <u>'.$this->mcuti->getnopengantar($id_pengantar).'</u> berhasil dikirim.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti Tunda <u>'.$this->mcuti->getnopengantar($id_pengantar).'</u> gagal dikirim.';
        $data['jnspesan'] = 'alert alert-danger';
    }   

    $data['cuti'] = $this->mcuti->tampilpengantar()->result_array();
    $data['content'] = 'cuti/tampilpengantarcuti';
    $this->load->view('template', $data);
  }

  /*public function kirimusul()  
  {
    $nip = $this->input->post('nip');
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $fid_pengantar = $this->input->post('fid_pengantar');
    $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
    $id_jnscuti = 3;  // status cuti : INBOXBKPPD

    // update status cuti : INBOXBKPPD => 3
    $data = array(      
      'fid_status'      => $id_jnscuti
    );

    $where = array(
    'nip'             => $nip,
    'fid_jns_cuti'    => $fid_jns_cuti,
    'fid_pengantar'   => $fid_pengantar,
    'thn_cuti'        => $thn_cuti
    );
    
    // rubah fid_status sesuai data array diatas
    if ($this->mcuti->edit_usul($where, $data)) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> berhasil dikirim ke BKPPD.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti <u>'.$this->mpegawai->getnama($nip).'</u> gagal dikirim ke BKPPD.';
        $data['jnspesan'] = 'alert alert-danger';
    }   

    $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar($fid_pengantar, $kelompok_cuti)->result_array();
    $data['idpengantar'] = $fid_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar($fid_pengantar, $kelompok_cuti)->result_array());
    $data['content'] = 'detailpengantarcuti'; 
    $this->load->view('template', $data);
  }
  */

  function tambahusul_aksi() {
    $nip = addslashes($this->input->post('nipsimpan')); // diambil dari getdatacuti() hasil dari ajax
    $id_pengantar = $this->input->post('id_pengantar');
    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    $id_jnscuti = $this->input->post('id_jnscuti');    
    $jnscuti = $this->mcuti->getnamajeniscuti($id_jnscuti);
    if (($jnscuti == 'CUTI SAKIT') OR ($jnscuti == 'CUTI BERSALIN') OR ($jnscuti == 'CUTI BESAR')) {
      $ketjnscuti = addslashes($this->input->post('ketjnscuti'));      
    } else {
      $ketjnscuti = '';
    }

    if ($jnscuti == 'CUTI TAHUNAN') {
      $hari_tunda = $this->input->post('hari_tunda');      
    } else {
      $hari_tunda = '0';
    }

    $tahun = addslashes($this->input->post('tahun'));
    $tglmulai = tgl_sql($this->input->post('tglmulai'));
    $tglselesai = tgl_sql($this->input->post('tglselesai'));
    $jml_hk = $this->input->post('jml_hk');

    $jml = $this->hitung_jmlharicuti($jml_hk, $tglmulai, $tglselesai);
    //$jml = addslashes($this->input->post('jml'));
    //$satuan_jml = addslashes($this->input->post('satuan_jml'));
    $satuan_jml = "HARI";

    $alamat = addslashes($this->input->post('alamat'));
    $catatan_pej_kepeg = addslashes($this->input->post('catatan_pej_kepeg'));
    $catatan_atasan = addslashes($this->input->post('catatan_atasan'));
    $keputusan_pej = addslashes($this->input->post('keputusan_pej'));
    $dokumen = $this->input->post('dokumen');
    $id_status = 1; // untuk status cuti INBOXSKPD (pada tabel ref_statuscuti)

    $user_usul = $this->session->userdata('nip');
    $tgl_usul = $this->mlogin->datetime_saatini();

    $data = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar,
      'fid_jns_cuti'      => $id_jnscuti,
      'ket_jns_cuti'      => $ketjnscuti,
      'thn_cuti'          => $tahun,
      'jml'               => $jml,
      'tambah_hari_tunda' => $hari_tunda,
      'satuan_jml'        => $satuan_jml,
      'tgl_mulai'         => $tglmulai,
      'tgl_selesai'       => $tglselesai,
      'jml_hk'            => $jml_hk,
      'alamat'            => $alamat,
      'catatan_pej_kepeg' => $catatan_pej_kepeg,
      'catatan_atasan'    => $catatan_atasan,
      'keputusan_pej'     => $keputusan_pej,
      'dokumen'           => $dokumen,
      'fid_status'        => $id_status,
      'user_usul'         => $user_usul,
      'tgl_usul'          => $tgl_usul
      );

    // cek apakah sudah pernah usul, untuk menghindari refresh/reload pada page tambahusul_aksi
    if ($this->mcuti->cektelahusul($nip, $tahun, 'CUTI LAINNYA') == 0) {
      if ($this->mcuti->input_usul($data))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }   
    } else {
      // jika sudah pernah usul
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // tampilkan view cuti      
    $data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array());
    $data['content'] = 'cuti/detailpengantarcuti'; 
    $this->load->view('template', $data);
  }

  function tambahusulcutitunda_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('id_pengantar');
    $tahun = addslashes($this->input->post('tahun'));
    $jmlhari = addslashes($this->input->post('jmlhari'));
    $keputusan_pej = addslashes($this->input->post('keputusan_pej'));
    $id_status = 1; // untuk status cuti 1 => INBOXSKPD (pada tabel ref_statuscuti)

    $user_usul = $this->session->userdata('nip');
    $tgl_usul = $this->mlogin->datetime_saatini();

    $data = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar,
      'tahun'             => $tahun,
      'jml_hari'          => $jmlhari,
      'keputusan_pej'     => $keputusan_pej,
      'fid_status'        => $id_status,
      'user_usul'         => $user_usul,
      'tgl_usul'          => $tgl_usul
      );

    // cek apakah pernah usul sebelumnya
    if ($this->mcuti->cektelahusul($nip, $tahun, 'CUTI TUNDA') == 0) {
      if ($this->mcuti->input_usulcutitunda($data))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Usul Cuti Tunda <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }   
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // tampilkan view cuti tunda
    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);   
    $data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array());

    $data['content'] = 'cuti/detailpengantarcutitunda';   
    $this->load->view('template', $data);
    //header('location:detailpengantar');
    //redirect('cuti/detailpengantarcutitunda');
  }


  function editusul_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('fid_pengantar');

    $id_jnscuti = $this->input->post('id_jnscuti');    
    $jnscuti = $this->mcuti->getnamajeniscuti($id_jnscuti);
    if (($jnscuti == 'CUTI SAKIT') OR ($jnscuti == 'CUTI BERSALIN') OR ($jnscuti == 'CUTI BESAR')) {
      $ketjnscuti = addslashes($this->input->post('ketjnscuti'));      
      $hari_tunda = '0';
    } else if ($jnscuti == 'CUTI TAHUNAN') {
      //$hari_tunda = addslashes($this->input->post('hari_tunda'));
      $hari_tunda = '0';
      $ketjnscuti = '';
    } else {
      $hari_tunda = '0';
      $ketjnscuti = '';	
    }

    $tahun = addslashes($this->input->post('tahun'));
    $jmlhari = addslashes($this->input->post('jmlhari'));
    $tglmulai = tgl_sql($this->input->post('tglmulai'));
    $tglselesai = tgl_sql($this->input->post('tglselesai'));
    $alamat = addslashes($this->input->post('alamat'));
    $catatan_pej_kepeg = addslashes($this->input->post('catatan_pej_kepeg'));
    $catatan_atasan = addslashes($this->input->post('catatan_atasan'));
    $keputusan_pej = addslashes($this->input->post('keputusan_pej'));
    $id_status = 1; // untuk status cuti INBOXSKPD (pada tabel ref_statuscuti)

    $nama = $this->mpegawai->getnama($nip);

    //$user_usul = $this->session->userdata('nip');
    //$tgl_usul = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_jns_cuti'      => $id_jnscuti,
      'ket_jns_cuti'      => $ketjnscuti,
      'thn_cuti'          => $tahun,
      'jml'               => $jmlhari,
      'tambah_hari_tunda' => $hari_tunda,
      'tgl_mulai'         => $tglmulai,
      'tgl_selesai'       => $tglselesai,
      'alamat'            => $alamat,
      'catatan_pej_kepeg' => $catatan_pej_kepeg,
      'catatan_atasan'    => $catatan_atasan,
      'keputusan_pej'     => $keputusan_pej,
      'fid_status'        => $id_status
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar
    );

    if ($this->mcuti->edit_usul($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$nama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    // tampilkan view cuti      
    $data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array());
    $data['content'] = 'cuti/detailpengantarcuti'; 
    $this->load->view('template', $data);
  }

  function updateusulbtl_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('fid_pengantar');

    $id_jnscuti = $this->input->post('id_jnscuti');    
    $jnscuti = $this->mcuti->getnamajeniscuti($id_jnscuti);
    if (($jnscuti == 'CUTI SAKIT') OR ($jnscuti == 'CUTI BERSALIN') OR ($jnscuti == 'CUTI BESAR')) {
      $ketjnscuti = addslashes($this->input->post('ketjnscuti'));      
    } else {
      $ketjnscuti = '';
    }

    $tahun = addslashes($this->input->post('tahun'));
    $jmlhari = addslashes($this->input->post('jmlhari'));
    $tglmulai = tgl_sql($this->input->post('tglmulai'));
    $tglselesai = tgl_sql($this->input->post('tglselesai'));
    $alamat = addslashes($this->input->post('alamat'));
    $catatan_pej_kepeg = addslashes($this->input->post('catatan_pej_kepeg'));
    $catatan_atasan = addslashes($this->input->post('catatan_atasan'));
    $keputusan_pej = addslashes($this->input->post('keputusan_pej'));
    $id_status = 3; // data dikirimkan lagi ke BKPPD untuk status cuti INBOXBKPPD (pada tabel ref_statuscuti)

    $nama = $this->mpegawai->getnama($nip);

    //$user_usul = $this->session->userdata('nip');
    //$tgl_usul = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_jns_cuti'      => $id_jnscuti,
      'ket_jns_cuti'      => $ketjnscuti,
      'thn_cuti'          => $tahun,
      'jml'               => $jmlhari,
      'tgl_mulai'         => $tglmulai,
      'tgl_selesai'       => $tglselesai,
      'alamat'            => $alamat,
      'catatan_pej_kepeg' => $catatan_pej_kepeg,
      'catatan_atasan'    => $catatan_atasan,
      'keputusan_pej'     => $keputusan_pej,
      'fid_status'        => $id_status
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar
    );

    if ($this->mcuti->edit_usul($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti BTL <u>'.$nama.'</u> berhasil diupdate dan dikirim ke BKPPD.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti BTL <u>'.$nama.'</u> gagal diupdate';
        $data['jnspesan'] = 'alert alert-danger';
      }

    // tampilkan tampilinbox
    $data['jmldata'] = $this->mcuti->jmltampilinbox();  

      // untuk paging versi dumet
      $this->load->library('pagination');
      $config['base_url'] = base_url().'cuti/tampilinbox';
      $config['total_rows'] = $this->mcuti->jmltampilinbox();
      $config['per_page'] = $per_page = 4;
      $config['uri_segment'] = 3;
      $config['first_link'] = 'Awal';
      $config['last_link'] = 'Akhir';
      $config['next_link'] = 'Selanjutnya';
      $config['prev_link'] = 'Sebelumnya';

      //$config['cur_tag_open'] = ' <strong>';
      //$config['cur_tag_close'] = '</strong>';
      //Tambahan untuk styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

      $this->pagination->initialize($config);
      $data['paging'] = $this->pagination->create_links();
      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      
      $data['cuti'] = $this->mcuti->tampilinbox($per_page,$page)->result_array();
      $data['content'] = 'cuti/tampilinbox';     

      $this->load->view('template',$data);
  }

  function tambahpengantar_aksi() {
    $nopengantar = addslashes($this->input->post('nopengantar'));
    $tglpengantar = addslashes($this->input->post('tglpengantar'));
    $id_unker = addslashes($this->input->post('id_unker'));
    $id_kelcuti = addslashes($this->input->post('id_kelcuti'));
    $jns_asn = addslashes($this->input->post('jns_asn'));
    $id_status = '1'; // status awal adalah 1->SKPD

    // konversi ke format yyyy-mm-dd
    $tglpengantarbaru = tgl_sql($tglpengantar);
    $created = $this->session->userdata('nip');

    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $time = $this->mlogin->datetime_saatini();

    $data = array(
      'no_pengantar'    => $nopengantar,
      'tgl_pengantar'   => $tglpengantarbaru,
      'fid_unit_kerja'  => $id_unker,
      'jenis'		=> $jns_asn,	
      'kelompok_cuti'   => $id_kelcuti,
      'fid_status'      => $id_status,
      'created_at'      => $time,
      'created_by'      => $created
      );

    if ($this->mcuti->input_pengantar($data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        //$data['pesan'] = '<b>Sukses</b>, Pengantar Cuti Nomor '.$data['no_pengantar'].' berhasil ditambah';
        //$data['jnspesan'] = 'alert alert-success';
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, Pengantar Cuti Nomor '.$data['no_pengantar'].' berhasil ditambah');
        redirect('cuti/tampilpengantar');
      } else {
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti Nomor '.$data['no_pengantar'].' gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
        //$data['jnspesan'] = 'alert alert-danger';
        $this->session->set_flashdata('pesan', '<b>Gagal !</b>, Pengantar Cuti Nomor '.$data['no_pengantar'].' gagal ditambah.<br />Pastikan data sesuai dengan ketentuan');
        redirect('cuti/tampilpengantar');
      }

    // tampilkan view cuti
      //$data['cuti'] = $this->mcuti->tampilpengantar()->result_array();
      //$data['content'] = 'cuti/tampilpengantarcuti';
      //$this->load->view('template', $data);
  }

  function hapus_pengantar(){
    $idpengantar = addslashes($this->input->post('id_pengantar'));
    $nopengantar = addslashes($this->input->post('no_pengantar'));

    $where = array('id_pengantar' => $idpengantar,
		   'no_pengantar' => $nopengantar);

    if ($this->mcuti->hapus_pengantar($where)) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, Pengantar Cuti Nomor '.$nopengantar.' berhasil dihapus');
        //$data['pesan'] = '<b>Sukses</b>, Pengantar Cuti Nomor '.$nopengantar.' berhasil dihapus';
        //$data['jnspesan'] = 'alert alert-success';
        redirect('cuti/tampilpengantar');
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, Pengantar Cuti Nomor '.$nopengantar.' gagal dihapus');
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti Nomor '.$nopengantar.' gagal dihapus';
        //$data['jnspesan'] = 'alert alert-danger';
        redirect('cuti/tampilpengantar');
      }

    //$data['cuti'] = $this->mcuti->tampilpengantar()->result_array();
    //$data['content'] = 'cuti/tampilpengantarcuti';
    //$this->load->view('template', $data);

    //redirect('../cuti/tampilpengantar');
  }

  function hapus_cuti(){
    $nip = addslashes($this->input->post('nip'));
    $tahun = addslashes($this->input->post('tahun'));
    $fid_jns_cuti = addslashes($this->input->post('fid_jns_cuti'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $tgl_mulai = addslashes($this->input->post('tgl_mulai'));
    $tgl_selesai = addslashes($this->input->post('tgl_selesai'));

    $get_jnsasn = $this->mcuti->get_jnsasn($fid_pengantar);
    if ($get_jnsasn == "PNS") {
	 $nama = $this->mpegawai->getnama($nip);
    	$where = array('nip' => $nip,
                   'thn_cuti' => $tahun,
                   'fid_jns_cuti' => $fid_jns_cuti,
		   'fid_pengantar' => $fid_pengantar,
		   'tgl_mulai' => $tgl_mulai,
		   'tgl_selesai' => $tgl_selesai);
	$proses_hapus = $this->mcuti->hapus_cuti($where);
    } else if ($get_jnsasn == "PPPK") {
	 $nama = $this->mpppk->getnama_lengkap($nip);
	$where_pppk = array('nipppk' => $nip,
                   'thn_cuti' => $tahun,
                   'fid_jns_cuti' => $fid_jns_cuti,
                   'fid_pengantar' => $fid_pengantar,
                   'tgl_mulai' => $tgl_mulai,
                   'tgl_selesai' => $tgl_selesai);
	$proses_hapus = $this->mcuti->hapus_cuti_pppk($where_pppk);
    }
		
    if ($proses_hapus) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti '.$nama.', Tahun '.$tahun.' berhasil dihapus';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal</b>, Usul Cuti '.$nama.', Tahun '.$tahun.' gagal dihapus';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
    $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
    if ($get_jnsasn == "PNS") {
	$data['cuti'] = $this->mcuti->detailpengantar($fid_pengantar, $kelompok_cuti)->result_array();
	$data['jmldata'] = count($this->mcuti->detailpengantar($fid_pengantar, $kelompok_cuti)->result_array());
    } else if ($get_jnsasn == "PPPK") {
    	$data['cuti'] = $this->mcuti->detailpengantar_pppk($fid_pengantar)->result_array();
    	$data['jmldata'] = count($this->mcuti->detailpengantar_pppk($fid_pengantar)->result_array());
    }
    $data['idpengantar'] = $fid_pengantar;
    $data['content'] = 'cuti/detailpengantarcuti';
    $this->load->view('template', $data);

    //redirect('../cuti/tampilpengantar');
  }

  function hapus_tunda(){
    $nip = addslashes($this->input->post('nip'));
    $tahun = addslashes($this->input->post('tahun'));
    $id_pengantar = addslashes($this->input->post('fid_pengantar'));
    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'tahun' => $tahun,
                   'fid_pengantar' => $id_pengantar
             );

    if ($this->mcuti->hapus_tunda($where)) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda '.$nama.', Tahun '.$tahun.' berhasil dihapus';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal</b>, Usul Cuti Tunda '.$nama.', Tahun '.$tahun.' gagal dihapus';
        $data['jnspesan'] = 'alert alert-danger';
      }

    // tampilkan view cuti tunda
    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);   
    $data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array());

    $data['content'] = 'cuti/detailpengantarcutitunda';   
    $this->load->view('template', $data);
  }

  function prosesusulbtl() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $alasanbtl = $this->input->post('alasanbtl');
    $id_status = '5'; // BTL

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'alasan'          => $alasanbtl
      );

    $get_jnsasn = $this->mcuti->get_jnsasn($fid_pengantar);
    if ($get_jnsasn == "PNS") {
        $where = array(
        'nip'               => $nip,
        'fid_pengantar'     => $fid_pengantar
        );
        $update_usul = $this->mcuti->edit_usul($where, $data);
    } else if ($get_jnsasn == "PPPK") {
        $where = array(
        'nipppk'            => $nip,
        'fid_pengantar'     => $fid_pengantar
        );
        $update_usul = $this->mcuti->edit_usul_pppk($where, $data);
    }

    /*
    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );
    */

    //if ($this->mcuti->edit_usul($where, $data))
    if ($update_usul) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> berhasil BTL, dan dikirim ulang ke SKPD.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> gagal BTL.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
      if ($this->session->userdata('prosescuti_priv') == "Y") { 
      $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
        
      $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
      //$data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
      $data['idpengantar'] = $fid_pengantar;
      //$data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());

      if ($get_jnsasn == "PNS") {
        $data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
      } else if ($get_jnsasn == "PPPK") {
        $data['cuti'] = $this->mcuti->detailproses_pppk($fid_pengantar, $kelompok_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailproses_pppk($fid_pengantar, $kelompok_cuti)->result_array());
      }
        
      if ($kelompok_cuti == 'CUTI LAINNYA') {
        $data['content'] = 'cuti/detailprosescuti';   
      } else if ($kelompok_cuti == 'CUTI TUNDA') {
        $data['content'] = 'cuti/detailprosescutitunda';   
      }
      
      $this->load->view('template', $data);
    }
  }

  function prosesusultms() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $alasantms = $this->input->post('alasantms');
    $id_status = '6'; // TMS

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'alasan'          => $alasantms
      );

    $get_jnsasn = $this->mcuti->get_jnsasn($fid_pengantar);
    if ($get_jnsasn == "PNS") {
        $where = array(
        'nip'               => $nip,
        'fid_pengantar'     => $fid_pengantar
        );
        $update_usul = $this->mcuti->edit_usul($where, $data);
    } else if ($get_jnsasn == "PPPK") {
        $where = array(
        'nipppk'            => $nip,
        'fid_pengantar'     => $fid_pengantar
        );
        $update_usul = $this->mcuti->edit_usul_pppk($where, $data);
    }

    /*
    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );
    */

    //if ($this->mcuti->edit_usul($where, $data))
    if ($update_usul) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> berhasil TMS.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> gagal TMS.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
      if ($this->session->userdata('prosescuti_priv') == "Y") { 
      $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
        
      $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
      //$data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
      $data['idpengantar'] = $fid_pengantar;
      //$data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
        
      if ($get_jnsasn == "PNS") {
        $data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
      } else if ($get_jnsasn == "PPPK") {
        $data['cuti'] = $this->mcuti->detailproses_pppk($fid_pengantar, $kelompok_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailproses_pppk($fid_pengantar, $kelompok_cuti)->result_array());
      }
 
      if ($kelompok_cuti == 'CUTI LAINNYA') {
        $data['content'] = 'cuti/detailprosescuti';   
      } else if ($kelompok_cuti == 'CUTI TUNDA') {
        $data['content'] = 'cuti/detailprosescutitunda';   
      }
      
      $this->load->view('template', $data);
    }
  }

  function prosesusultms_tunda() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $alasantms = $this->input->post('alasantms');
    $id_status = '6'; // TMS

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'alasan'          => $alasantms
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );

    if ($this->mcuti->edit_usultunda($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda <u>'.$this->mpegawai->getnama($nip).'</u> berhasil TMS.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti Tunda <u>'.$this->mpegawai->getnama($nip).'</u> gagal TMS.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
      if ($this->session->userdata('prosescuti_priv') == "Y") { 
        $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
          
        $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
        $data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
        $data['idpengantar'] = $fid_pengantar;
        $data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
        
      if ($kelompok_cuti == 'CUTI LAINNYA') {
        $data['content'] = 'cuti/detailprosescuti';   
      } else if ($kelompok_cuti == 'CUTI TUNDA') {
        $data['content'] = 'cuti/detailprosescutitunda';   
      }
      
      $this->load->view('template', $data);
    }
  }

  function prosesusulsetuju() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $no_sk = addslashes($this->input->post('no_sk'));
    $tgl_sk = tgl_sql($this->input->post('tgl_sk'));
    $pejabat_sk = addslashes($this->input->post('pejabat_sk'));
    $id_status = '4'; // SETUJU

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'no_sk'           => $no_sk,
      'tgl_sk'          => $tgl_sk,
      'pejabat_sk'      => $pejabat_sk
      );
  
    $get_jnsasn = $this->mcuti->get_jnsasn($fid_pengantar);
    if ($get_jnsasn == "PNS") {
    	$where = array(
      	'nip'               => $nip,
      	'fid_pengantar'     => $fid_pengantar
    	);
	$update_usul = $this->mcuti->edit_usul($where, $data);
    } else if ($get_jnsasn == "PPPK") {
	$where = array(
        'nipppk'            => $nip,
        'fid_pengantar'     => $fid_pengantar
        );
	$update_usul = $this->mcuti->edit_usul_pppk($where, $data);
    }
    
    //if ($this->mcuti->edit_usul($where, $data))
    if ($update_usul) {	
	 // TODO QR CODE
        // Generate QR Code jika Berhasil
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodecuti/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']       = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 17; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $thnini = date('Y');
        $image_name = $nip."-".$thnini.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'
 
        //$image_name=$nip.'_'.$tgl_sk.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $nip."-".$thnini.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // entri QR Code pada database
        $data = array(      
          'qrcode'  => $params['data']
          );

	if ($get_jnsasn == "PNS") {
	  $where = array(
            'nip'               => $nip,
            'fid_pengantar'     => $fid_pengantar
          );
	  $this->mcuti->edit_usul($where, $data);
	} else if ($get_jnsasn == "PPPK") {
	  $where = array(
	    'nipppk'               => $nip,
            'fid_pengantar'     => $fid_pengantar
          );
 	  $this->mcuti->edit_usul_pppk($where, $data);
	}

        //$where = array(
        //  'nip'               => $nip,
        //  'fid_pengantar'     => $fid_pengantar
        //);
        //$this->mcuti->edit_usul($where, $data);
        // END QR CODE

        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> telah disetujui.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> tidak disetujui.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
    if ($this->session->userdata('prosescuti_priv') == "Y") { 
      $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
        
      $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
      //$data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
      $data['idpengantar'] = $fid_pengantar;
      //$data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
      
      if ($get_jnsasn == "PNS") {
	$data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
	$data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
      } else if ($get_jnsasn == "PPPK") {
	$data['cuti'] = $this->mcuti->detailproses_pppk($fid_pengantar, $kelompok_cuti)->result_array();
        $data['jmldata'] = count($this->mcuti->detailproses_pppk($fid_pengantar, $kelompok_cuti)->result_array());
      }		      
  
      if ($kelompok_cuti == 'CUTI LAINNYA') {
        $data['content'] = 'cuti/detailprosescuti';   
      } else if ($kelompok_cuti == 'CUTI TUNDA') {
        $data['content'] = 'cuti/detailprosescutitunda';   
      }
      
      $this->load->view('template', $data);
    }
  }

  function prosesusulsetuju_tunda() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $no_sk = addslashes($this->input->post('no_sk'));
    $tgl_sk = tgl_sql($this->input->post('tgl_sk'));
    $pejabat_sk = addslashes($this->input->post('pejabat_sk'));
    $id_status = '4'; // SETUJU

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'no_sk'           => $no_sk,
      'tgl_sk'          => $tgl_sk,
      'pejabat_sk'      => $pejabat_sk
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );

    if ($this->mcuti->edit_usultunda($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda<u>'.$this->mpegawai->getnama($nip).'</u> telah disetujui.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti Tunda<u>'.$this->mpegawai->getnama($nip).'</u> tidak disetujui.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
      if ($this->session->userdata('prosescuti_priv') == "Y") { 
      $kelompok_cuti = $this->mcuti->getkelompok($fid_pengantar);
        
      $data['nopengantar'] = $this->mcuti->getnopengantar($fid_pengantar);
      $data['cuti'] = $this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array();
      $data['idpengantar'] = $fid_pengantar;
      $data['jmldata'] = count($this->mcuti->detailproses($fid_pengantar, $kelompok_cuti)->result_array());
        
      if ($kelompok_cuti == 'CUTI LAINNYA') {
        $data['content'] = 'cuti/detailprosescuti';   
      } else if ($kelompok_cuti == 'CUTI TUNDA') {
        $data['content'] = 'cuti/detailprosescutitunda';   
      }
      
      $this->load->view('template', $data);
    }
  }

  function updatestatus(){           
    if ($this->session->userdata('prosescuti_priv') == "Y") {
      $data['content'] = 'cuti/updatestatus';
      //$data['pesan'] = '<b>Ketik NIP pada textbox dan tekan tombol Enter</b>.';
      //$data['jnspesan'] = 'alert alert-info';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function cariupdatestatus() {
    $nip = $this->input->get('nip');    // kalau menggunakan metode post untuk ajax
    $jns = $this->input->get('jns');

    // untuk cuti lainnya
    if ($jns == 'CUTI LAINNYA') {
      $sqlcari = $this->mcuti->cariupdatestatus($nip)->result_array();
      $jml = count($this->mcuti->cariupdatestatus($nip)->result_array());

      if ($jml == 0) {
        echo "<br /><div class='alert alert-info' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        echo "Usul Cuti NIP. ".$nip." <b>tidak ditemukan</b>";
        echo "</div>";
      } else {
        echo '<br/>';
        echo '<table class="table table-condensed table-hover">';
        echo "<tr class='success'>
              <td align='center'><b>No</b></td>
              <td align='center' width='220'><b>NIP | Nama</b></td>
              <td align='center'><b>Jabatan | Unit Kerja</b></td>
              <td align='center' width='120'><b>Jenis Cuti</b></td>
              <td align='center' width='250'><b>Lama</b></td>
              <td align='center' width='120'><b>Status</b></td>
              <td align='center' colspan='4'><b>Aksi</b></td>
            </tr>";

        $no = 1;
        foreach($sqlcari as $v):          
          echo "<td align='center'>".$no."</td>";
          echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';
          
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }

          echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja'],'</td>';
          echo "<td align='center'>".$v['nama_jenis_cuti']. "<br />Tahun ".$v['thn_cuti']."</td>";

          $jnscuti = $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
          if (($jnscuti == 'CUTI TAHUNAN') AND ($v['tambah_hari_tunda'] != 0)) {
            echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].' + '.$v['tambah_hari_tunda'].' HARI<br />'.tgl_indo($v['tgl_mulai']).'s/d '.tgl_indo($v['tgl_selesai'])."</td>";
          }  else {
            echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].'<br />'.tgl_indo($v['tgl_mulai']).'s/d '.tgl_indo($v['tgl_selesai'])."</td>";
          }

          $status = $this->mcuti->getstatuscuti($v['fid_status']);
          echo "<td align='center'>";
          if ($status == 'INBOXSKPD') {          
            echo "<h5><span class='label label-default'>Inbox SKPD</span></h5>";
          } else if ($status == 'CETAKUSUL') {
            echo "<h5><span class='label label-default'>Cetak Usul</span></h5>";
          } else if ($status == 'INBOXBKPPD') {          
            echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
          } else if ($status == 'BTL') {
            echo "<h5><span class='label label-warning'>B T L</span></h5>";
          } else if ($status == 'TMS') {
            echo "<h5><span class='label label-danger'>T M S</span></h5>";
          } else if ($status == 'SETUJU') {
            echo "<h5><span class='label label-success'>Setuju</span></h5>";
          } else if ($status == 'CETAKSK') {
            echo "<h5><span class='label label-default'>Cetak SK</span></h5>";
          } else if ($status == 'SELESAISETUJU') {
            echo "<h5><span class='label label-success'>Selesai Setuju</span></h5>";
          } else if ($status == 'SELESAIBTL') {
            echo "<h5><span class='label label-success'>Selesai BTL</span></h5>";
          } else if ($status == 'SELESAITMS') {
            echo "<h5><span class='label label-success'>Selesai TMS</span></h5>";
          }
          echo "</td>";

          if (($status == 'INBOXSKPD') OR ($status == 'CETALUSUL') OR ($status == 'INBOXBKPPD') OR ($status == 'BTL') OR ($status == 'TMS') OR ($status == 'SETUJU') OR ($status == 'CETAKSK')) {
            echo "<td align='center'>";
            echo "<form method='POST' action='../cuti/detailupdatestatus'>";          
                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
                echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
                echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                echo "<button type='submit' class='btn btn-success btn-xs'>";
                echo "<span class='glyphicon glyphicon-new-window' aria-hidden='true'></span><br />Update Status";
                echo "</button>";
                echo "</form>";
            echo '</td>';
          }

          echo "</tr>";

          $no++;
        endforeach;
      }
    // untuk cuti tunda
    } else if ($jns == 'CUTI TUNDA') {
      $sqlcari = $this->mcuti->cariupdatestatustunda($nip)->result_array();
      $jml = count($this->mcuti->cariupdatestatustunda($nip)->result_array());

      if ($jml == 0) {
        echo "<br /><div class='alert alert-info' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        echo "Usul Cuti Tunda NIP. ".$nip." <b>tidak ditemukan</b>";
        echo "</div>";
      } else {
        echo '<br/>';
        echo '<table class="table table-condensed table-hover">';
        echo "<tr class='warning'>
              <td align='center'><b>No</b></td>
              <td align='center' width='220'><b>NIP | Nama</b></td>
              <td align='center'><b>Jabatan | Unit Kerja</b></td>
              <td align='center' width='120'><b>Tahun</b></td>
              <td align='center' width='250'><b>Lama</b></td>
              <td align='center' width='120'><b>Status</b></td>
              <td align='center' colspan='4'><b>Aksi</b></td>
            </tr>";

        $no = 1;
        foreach($sqlcari as $v):          
          echo "<td align='center'>".$no."</td>";
          echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';
          
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }

          echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja'],'</td>';
          echo "<td align='center'>".$v['tahun']."</td>";
          echo "<td align='center'>".$v['jml_hari']." hari</td>";
          
          $status = $this->mcuti->getstatuscuti($v['fid_status']);
          echo "<td align='center'>";
          if ($status == 'INBOXBKPPD') {          
            echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
          } else if ($status == 'BTL') {
            echo "<h5><span class='label label-warning'>B T L</span></h5>";
          } else if ($status == 'TMS') {
            echo "<h5><span class='label label-danger'>T M S</span></h5>";
          } else if ($status == 'SETUJU') {
            echo "<h5><span class='label label-success'>SETUJU</span></h5>";
          } else if ($status == 'CETAKSK') {
            echo "<h5><span class='label label-default'>CETAK SK</span></h5>";
          } else if ($status == 'SELESAISETUJU') {
            echo "<h5><span class='label label-default'>SELESAI SETUJU</span></h5>";
          } else if ($status == 'SELESAIBTL') {
            echo "<h5><span class='label label-default'>SELESAI BTL</span></h5>";
          } else if ($status == 'SELESAITMS') {
            echo "<h5><span class='label label-default'>SELESAI TMS</span></h5>";
          }
          echo "</td>";

          echo "<td align='center'>";
          echo "<form method='POST' action='../cuti/detailupdatestatustunda'>";          
          echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
          echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
          echo "<button type='submit' class='btn btn-success btn-xs'>";
          echo "<span class='glyphicon glyphicon-new-window' aria-hidden='true'></span><br />Update Status";
          echo "</button>";
          echo "</form>";
          echo '</td>';

          $no++;
        endforeach;
      }
    }
  }

  function detailupdatestatus() {
    $idpengantar = $this->input->post('fid_pengantar');    
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $nip = $this->input->post('nip');
    $data['idpengantar'] = $idpengantar;
    $data['statuscuti'] = $this->mcuti->statuscuti()->result_array();
    $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();  
    $data['content'] = 'cuti/detailupdatestatus';   
    $this->load->view('template', $data); 
  }

  function detailupdatestatustunda() {
    $idpengantar = $this->input->post('fid_pengantar');
    $nip = $this->input->post('nip');
    $data['idpengantar'] = $idpengantar;
    $data['statuscuti'] = $this->mcuti->statuscuti()->result_array();
    $data['cuti'] = $this->mcuti->detailusultunda($nip, $idpengantar)->result_array();
    $data['content'] = 'cuti/detailupdatestatustunda';   
    $this->load->view('template', $data); 
  }

  function updatestatus_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $id_statuslama = $this->input->post('id_statuslama');
    $id_statusbaru = $this->input->post('id_statusbaru');
    
    $data = array(      
      'fid_status'      => $id_statusbaru
      );

    $where = array(
      'nip'             => $nip,
      'fid_pengantar'   => $fid_pengantar,
      'fid_status'      => $id_statuslama
    );

    if ($this->mcuti->edit_usul($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> berhasil update status.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mpegawai->getnama($nip).'</u> gagal update status.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('prosescuti_priv') == "Y") {
      $data['content'] = 'cuti/updatestatus';
      $this->load->view('template', $data);
    }
  }

  function updatestatustunda_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $id_statuslama = $this->input->post('id_statuslama');
    $id_statusbaru = $this->input->post('id_statusbaru');
    
    $data = array(      
      'fid_status'      => $id_statusbaru
      );

    $where = array(
      'nip'             => $nip,
      'fid_pengantar'   => $fid_pengantar,
      'fid_status'      => $id_statuslama
    );

    if ($this->mcuti->edit_usultunda($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda <u>'.$this->mpegawai->getnama($nip).'</u> berhasil update status.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti Tunda <u>'.$this->mpegawai->getnama($nip).'</u> gagal update status.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('prosescuti_priv') == "Y") {
      $data['content'] = 'cuti/updatestatus';
      $this->load->view('template', $data);
    }
  }

  function selesaikancuti_aksi() {
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $thn_cuti = $this->input->post('thn_cuti');
    
    $id_cetaksk = '7'; // id status CETAKSK
    $id_btl = '5'; // id status BTL
    $id_tms = '6'; // id status TMS
    $id_pengantarbkppd = '3'; // id status BKPPD (Pengantar)

    $id_selesaisetuju = '8'; // id status SELESAISETUJU
    $id_selesaibtl = '9'; // id status SELESAIBTL
    $id_selesaitms = '10'; // id status SELESAITMS
    $id_pengantarselesai = '4'; // id status SELESAI (Pengantar)

    $tgl_selesai = $this->mlogin->datetime_saatini();

    $get_jnsasn = $this->mcuti->get_jnsasn($id_pengantar);

    $datasetuju = array(      
      'fid_status'      => $id_selesaisetuju,
      'tgl_status_selesai' => $tgl_selesai
      );

    $databtl = array(      
      'fid_status'      => $id_selesaibtl,
      'tgl_status_selesai' => $tgl_selesai
      );

    $datatms = array(      
      'fid_status'      => $id_selesaitms,
      'tgl_status_selesai' => $tgl_selesai
      );

    $datapengantar = array(      
      'fid_status'      => $id_pengantarselesai
      );

    $wheresetuju = array(
      'fid_pengantar'   => $id_pengantar,
      'thn_cuti'      => $thn_cuti,
      'fid_status'      => $id_cetaksk
    );

    $wherebtl = array(
      'fid_pengantar'   => $id_pengantar,
      'thn_cuti'      => $thn_cuti,
      'fid_status'      => $id_btl
    );

    $wheretms = array(
      'fid_pengantar'   => $id_pengantar,
      'thn_cuti'      => $thn_cuti,
      'fid_status'      => $id_tms
    );

    $wherepengantar = array(
      'id_pengantar'   => $id_pengantar,
      'fid_status'      => $id_pengantarbkppd
    );
    
    if (($get_jnsasn == "PNS") AND ($this->mcuti->edit_pengantar($wherepengantar, $datapengantar)) AND ($this->mcuti->edit_usul($wheresetuju, $datasetuju)) 
	AND ($this->mcuti->edit_usul($wherebtl, $databtl)) AND ($this->mcuti->edit_usul($wheretms, $datatms))) {

        // input riwayat cuti
        $fid_status_selesai = '8'; // SELESAISETUJU -> yang berstatus SELESAISETUJU yang akan ditambahkan ke riwayat_cuti
       	if ($this->mcuti->input_riwayatcuti($id_pengantar, $thn_cuti, $fid_status_selesai)) {
       		// kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
       		$data['pesan'] = '<b>Sukses</b>, Usul Cuti PNS No. Pengantar '.$this->mcuti->getnopengantar($id_pengantar).'  berhasil diselesaikan.';
       		$data['jnspesan'] = 'alert alert-success';
      	}
    } else if (($get_jnsasn == "PPPK") AND ($this->mcuti->edit_pengantar($wherepengantar, $datapengantar)) AND ($this->mcuti->edit_usul_pppk($wheresetuju, $datasetuju))
        AND ($this->mcuti->edit_usul_pppk($wherebtl, $databtl)) AND ($this->mcuti->edit_usul_pppk($wheretms, $datatms))) {

        // input riwayat cuti
        $fid_status_selesai = '8'; // SELESAISETUJU -> yang berstatus SELESAISETUJU yang akan ditambahkan ke riwayat_cuti
        if ($this->mcuti->input_riwayatcutipppk($id_pengantar, $thn_cuti, $fid_status_selesai)) {
                // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
                $data['pesan'] = '<b>Sukses</b>, Usul Cuti PPPK No. Pengantar '.$this->mcuti->getnopengantar($id_pengantar).'  berhasil diselesaikan.';
                $data['jnspesan'] = 'alert alert-success';
        }
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti No. Pengantar '.$this->mcuti->getnopengantar($id_pengantar).' Tanggal '.$this->mcuti->gettglpengantar($id_pengantar).' gagal diselesaikan.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('usulcuti_priv') == "Y") { 
      $data['cuti'] = $this->mcuti->tampilproses()->result_array();      
      $data['content'] = 'cuti/tampilprosescuti';
      $this->load->view('template',$data);
    }
  }

  function selesaikancutitunda_aksi() {
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    //$thn_cuti = $this->input->post('thn_cuti');
    
    $id_cetaksk = '7'; // id status CETAKSK
    $id_btl = '5'; // id status BTL
    $id_tms = '6'; // id status TMS
    $id_pengantarbkppd = '3'; // id status BKPPD (Pengantar)

    $id_selesaisetuju = '8'; // id status SELESAISETUJU
    $id_selesaibtl = '9'; // id status SELESAIBTL
    $id_selesaitms = '10'; // id status SELESAITMS
    $id_pengantarselesai = '4'; // id status SELESAI (Pengantar)

    $tgl_selesai = $this->mlogin->datetime_saatini();

    $datasetuju = array(      
      'fid_status'      => $id_selesaisetuju,
      'tgl_status_selesai' => $tgl_selesai
      );

    $databtl = array(      
      'fid_status'      => $id_selesaibtl,
      'tgl_status_selesai' => $tgl_selesai
      );

    $datatms = array(      
      'fid_status'      => $id_selesaitms,
      'tgl_status_selesai' => $tgl_selesai
      );

    $datapengantar = array(      
      'fid_status'      => $id_pengantarselesai
      );

    $wheresetuju = array(
      'fid_pengantar'   => $id_pengantar,
      //'thn_cuti'      => $thn_cuti,
      'fid_status'      => $id_cetaksk
    );

    $wherebtl = array(
      'fid_pengantar'   => $id_pengantar,
      //'thn_cuti'      => $thn_cuti,
      'fid_status'      => $id_btl
    );

    $wheretms = array(
      'fid_pengantar'   => $id_pengantar,
      //'thn_cuti'      => $thn_cuti,
      'fid_status'      => $id_tms
    );

    $wherepengantar = array(
      'id_pengantar'   => $id_pengantar,
      'fid_status'      => $id_pengantarbkppd
    );
    
    if (($this->mcuti->edit_pengantar($wherepengantar, $datapengantar)) AND ($this->mcuti->edit_usultunda($wheresetuju, $datasetuju)) AND ($this->mcuti->edit_usultunda($wherebtl, $databtl)) AND ($this->mcuti->edit_usultunda($wheretms, $datatms))) {

        // input riwayat cuti
        $fid_status_selesai = '8'; // SELESAISETUJU -> yang berstatus SELESAISETUJU yang akan ditambahkan ke riwayat_cuti
        if ($this->mcuti->input_riwayatcutitunda($id_pengantar, $fid_status_selesai)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Usul Cuti Tunda No. Pengantar '.$this->mcuti->getnopengantar($id_pengantar).' Tanggal '.$this->mcuti->gettglpengantar($id_pengantar).' berhasil diselesaikan.';
          $data['jnspesan'] = 'alert alert-success';
        }        
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti Tunda No. Pengantar '.$this->mcuti->getnopengantar($id_pengantar).' Tanggal '.$this->mcuti->gettglpengantar($id_pengantar).' gagal diselesaikan.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('usulcuti_priv') == "Y") { 
      $data['cuti'] = $this->mcuti->tampilproses()->result_array();      
      $data['content'] = 'cuti/tampilprosescuti';
      $this->load->view('template',$data);
    }
  }

  function rekapitulasi() {
    if ($this->session->userdata('usulcuti_priv') == "Y") {
      $data['content'] = 'cuti/rekapcuti';
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['tahun'] = $this->mcuti->gettahuncuti()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function carirekap() {
    $idunker = $this->input->get('idunker');
    $thn = $this->input->get('thn');
    $jnsasn = $this->input->get('jnsasn');

    //echo $jnsasn;
    if ($jnsasn == "PNS") {
      $sqlcari = $this->mcuti->carirekap($idunker, $thn)->result_array();
      $jml = count($this->mcuti->carirekap($idunker, $thn)->result_array());
    } else if ($jnsasn == "PPPK") {
      $sqlcari = $this->mcuti->carirekap_pppk($idunker, $thn)->result_array();
      $jml = count($this->mcuti->carirekap_pppk($idunker, $thn)->result_array());
    }
    if ($jml != 0) {
      echo '<br/>';
      echo '<table class="table table-condensed table-hover">';
      echo "<tr class='info'>
        <td align='center'><b>No</b></td>
        <td align='center' width='220'><b>Nomor Induk | Nama</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center' width='120'><b>Jenis Cuti</b></td>
        <td align='center' width='250'><b>Lama</b></td>
        <td align='center' width='220'><b>Status</b></td>
        </tr>";

      $no = 1;
      foreach($sqlcari as $v):
	//var_dump($sqlcari);
	if ($jnsasn == "PNS") {
		$ni = $v['nip'];
		//$nama = namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']);
		$nama = $this->mpegawai->getnama($v['nip']);
		if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        	}else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        	}else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        	}
		$jab = $this->mpegawai->namajab($v['fid_jnsjab'],$idjab);
	} else if ($jnsasn == "PPPK") {
		$ni = $v['nipppk'];
		$nama = $this->mpppk->getnama_lengkap($v['nipppk']);
		$jab = $this->mpegawai->namajab("3",$v['fid_jabft']);
	}
	
        echo "<tr><td align='center'>".$no."</td>";
        //echo '<td>',$ni,'<br />',$nama,'</td>';
	echo "<td>".$ni."<br />".$nama."</td>";

	/*
        if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        }
	*/

        //echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab),'</td>';
	echo "<td>".$jab."</td>";
        if ($v['fid_jns_cuti'] != null) {
          $jnscuti = $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
          echo "<td align='center' class='danger'>".$jnscuti."</td>";
        
          
          if (($jnsasn == "PNS") AND ($jnscuti == 'CUTI TAHUNAN') AND ($v['tambah_hari_tunda'] != 0)) {
            echo "<td align='center' class='danger'>".$v['jml'].' '.$v['satuan_jml'].' + '.$v['tambah_hari_tunda'].' HARI<br />'.tgl_indo($v['tgl_mulai']).' s/d '.tgl_indo($v['tgl_selesai'])."</td>";
          }  else {
            echo "<td align='center' class='danger'>".$v['jml'].' '.$v['satuan_jml'].'<br />'.tgl_indo($v['tgl_mulai']).' s/d '.tgl_indo($v['tgl_selesai'])."</td>";
          }

          $status = $this->mcuti->getstatuscuti($v['fid_status']);
          echo "<td align='center' class='danger'>";
          if ($status == 'INBOXSKPD') {          
            echo "<h5><span class='label label-default'>Inbox SKPD</span></h5>";
          } else if ($status == 'CETAKUSUL') {
            echo "<h5><span class='label label-default'>Cetak Usul</span></h5>";
          } else if ($status == 'INBOXBKPPD') {          
            echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
          } else if ($status == 'BTL') {
            echo "<h5><span class='label label-warning'>B T L</span></h5>";
          } else if ($status == 'TMS') {
            echo "<h5><span class='label label-danger'>T M S</span></h5>";
          } else if ($status == 'SETUJU') {
            echo "<h5><span class='label label-success'>Setuju</span></h5>";
          } else if ($status == 'CETAKSK') {
            echo "<h5><span class='label label-info'>Cetak SK</span></h5>";
            //echo "<small>Diproses. ".tglwaktu_indo($v['tgl_proses'])."</small>";
            
            $cenvertedTime = new DateTime($v['tgl_proses']);
            $saatini = new DateTime();  
            $diff  = $cenvertedTime->diff($saatini);
            //print_r($diff);
            // tombol cetak akan tampil setelah 3 jam dari status Cetak SK BKPPD
            // UNTUK TOMBOL CETAK SK dilakukan oleh Umpeg SKPD
	    /*
	    if (($diff->h >= 3) OR (($diff->d >= 1) AND ($diff->h >= 0))) {
                echo "<form method='POST' action='../cuti/cetaksk_skpd' target='_blank'>";          
                echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[fid_pengantar]'>";
                echo "<input type='hidden' name='nip' id='nip' size='18' value='$v[nip]'>";
                echo "<input type='hidden' name='thn_cuti' id='thn_cuti' size='5' value='$v[thn_cuti]'>";
                echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' size='10' value='$v[fid_jns_cuti]'>";
              ?>
                <button type="submit" class="btn btn-info btn-xs">&nbsp
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbspCetak SK&nbsp&nbsp&nbsp
                </button>
              <?php
		echo "</form>";
            } else {
              echo "<h5><span class='label label-default'>On Progress</span></h5>";
            }
	    */
	  } else if ($status == 'SELESAISETUJU') {
            echo "<h5><span class='label label-success'>Selesai Setuju</span></h5>";
          } else if ($status == 'SELESAIBTL') {
            echo "<h5><span class='label label-success'>Selesai BTL</span></h5>";
          } else if ($status == 'SELESAITMS') {
            echo "<h5><span class='label label-success'>Selesai TMS</span></h5>";
          }
          echo "</td>";
          echo "<tr/>";
        } else {
          echo "<td class='success'></td>";
          echo "<td class='success'></td>";
          echo "<td class='success'></td>";
          echo "<tr/>";
        }

        $no++;
        endforeach;
      } else {
	echo "<br/><div class='alert alert-info' role='alert'>DATA TIDAK DITEMUKAN</div>";
      }
    }

    function statistika()
    {
      if ($this->session->userdata('prosescuti_priv') == "Y") { 
	$thn = date('Y');
        $data['grafik'] = $this->mcuti->getjmlprosesbystatusgraphcuti();
        $data['thncuti'] = $this->mcuti->gettahunrwycuti()->result_array(); 
        $data['rwyperbulan'] = $this->mcuti->getjmlrwyperbulan($thn); 
        $data['content'] = 'cuti/statistika';
        $this->load->view('template',$data);
      }
    }

    // START KHUSUS ADMIN, Update Pengatar dan Usul Cuti
    function admin_tampilupdatepengantar()
    {
      if ($this->session->userdata('level') == "ADMIN") { 
        $data['cuti'] = $this->mcuti->admin_tampilupdatepengantar()->result_array();      
        $data['pesan'] = '';    
        $data['jnspesan'] = '';
        $data['content'] = 'cuti/admin_tampilupdatepengantar';
        $this->load->view('template',$data);
      }
    }

    function admin_tampilupdateusul()
    {
      if ($this->session->userdata('level') == "ADMIN") { 
        //$data['cuti'] = $this->mcuti->admin_tampilupdatepengantar()->result_array();      
        $data['pesan'] = '';    
        $data['jnspesan'] = '';
        $data['content'] = 'cuti/admin_tampilupdateusul';
        $this->load->view('template',$data);
      }
    }

    function admin_updatepengantar()
    {
      if ($this->session->userdata('level') == "ADMIN") { 
        $id = $this->input->post('id_pengantar');
        $tgl = $this->input->post('tgl_pengantar');   
        $data['pengantar'] = $this->mcuti->admin_detailpengantar($id, $tgl)->result_array();
        $data['statuspengantar'] = $this->mcuti->statuspengantar($id)->result_array();
        $data['id_pengantar'] = $id;
        //$data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
        //$data['jnscuti'] = $this->mcuti->jnscuti()->result_array();
        $data['content'] = 'cuti/admin_updatepengantar';
        $this->load->view('template', $data);
      }
    }

    function admin_updatepengantar_aksi() {
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $nopengantar = $this->input->post('nopengantar');
    $tglpengantar = tgl_sql($this->input->post('tglpengantar'));
    $id_status = $this->input->post('id_status');

    $data = array(
      'no_pengantar'    => $nopengantar,
      'tgl_pengantar'   => $tglpengantar,            
      'fid_status'      => $id_status
      );

    $where = array(
      'id_pengantar'   => $id_pengantar,
    );

    if ($this->mcuti->edit_pengantar($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Pengantar Cuti Nomor <u>'.$nopengantar.'</u> berhasil update status.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti Nomor <u>'.$nopengantar.'</u> gagal update status.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('level') == "ADMIN") { 
        $data['cuti'] = $this->mcuti->admin_tampilupdatepengantar()->result_array();      
        $data['content'] = 'cuti/admin_tampilupdatepengantar';
        $this->load->view('template',$data);
      }
  }

  function cariupdateusul() {
    $nip = $this->input->get('nip');    // kalau menggunakan metode post untuk ajax
    $thn = $this->input->get('thn');

    $sqlcari = $this->mcuti->cariupdateusul($nip, $thn)->result_array();
    $jml = count($this->mcuti->cariupdateusul($nip, $thn)->result_array());

    $nama = $this->mpegawai->getnama($nip);
    
    $lokasifile = './photo/';
    $filename = "$nip.jpg";
    if (file_exists ($lokasifile.$filename)) {
      $photo = "../photo/$nip.jpg";
                     //$photo = "ftp://192.168.1.4/photo/$v[nip].jpg";
    } else {
      $photo = "../photo/nophoto.jpg";
                    //echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'>";
                    //echo "<img src='../photo/nophoto.jpg' width='60' height='80' alt='no image'";
    }

    echo "<div align='center'>";
    echo '<table class="table table-condensed" style="width: 40%;">';
    echo "<tr>
            <td rowspan='3' align='center' width='80'>
            <img src='$photo' width='90' height='120' class='img-thumbnail'>
            </td>
            <td>$nama</td></tr>
          <tr>          
          <td>";
    echo $this->mpegawai->namajabnip($nip);
    echo "</td>
          <tr>
          <td>";
    echo $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
   
    if ($jml == 0) {
      echo "<br /><div class='alert alert-danger' role='alert'>";
      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
      echo "Usul Cuti NIP. ".$nip." <b>tidak ditemukan</b>";
      echo "</div>";
    } else {
      echo '<br/>';
      echo '<table class="table table-condensed table-hover">';
      echo "<tr class='info'>
      <td align='center' width='40'><b>No</b></td>
      <td align='center' width='120'><b>Jenis Cuti</b></td>
      <td align='center' width='250'><b>Lama</b></td>
      <td align='center' width='120'><b>Status</b></td>
      <td align='center' width='100'><b>Aksi</b></td>
      </tr>";

      $no = 1;
      foreach($sqlcari as $v):          
        echo "<td align='center'>".$no."</td>";
        //echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';

        if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        }

        //echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br />', $v['nama_unit_kerja'],'</td>';
        echo "<td align='left'>".$v['nama_jenis_cuti']. "<br />TAHUN ".$v['thn_cuti']."</td>";

        $jnscuti = $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
        if (($jnscuti == 'CUTI TAHUNAN') AND ($v['tambah_hari_tunda'] != 0)) {
          echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].' + '.$v['tambah_hari_tunda'].' HARI<br />'.tgl_indo($v['tgl_mulai']).' s/d '.tgl_indo($v['tgl_selesai'])."</td>";
        }  else {
          echo "<td align='center'>".$v['jml'].' '.$v['satuan_jml'].'<br />'.tgl_indo($v['tgl_mulai']).' s/d '.tgl_indo($v['tgl_selesai'])."</td>";
        }

        $status = $this->mcuti->getstatuscuti($v['fid_status']);
        echo "<td align='center'>";
        if ($status == 'INBOXSKPD') {          
          echo "<h5><span class='label label-default'>INBOX SKPD</span></h5>";
        } else if ($status == 'CETAKUSUL') {
          echo "<h5><span class='label label-default'>CETAK USUL</span></h5>";
        } else if ($status == 'INBOXBKPPD') {          
          echo "<h5><span class='label label-default'>INBOX BKPPD</span></h5>";
        } else if ($status == 'BTL') {
          echo "<h5><span class='label label-warning'>B T L</span></h5>";
        } else if ($status == 'TMS') {
          echo "<h5><span class='label label-danger'>T M S</span></h5>";
        } else if ($status == 'SETUJU') {
          echo "<h5><span class='label label-success'>SETUJU</span></h5>";
        } else if ($status == 'CETAKSK') {
          echo "<h5><span class='label label-default'>CETAK SK</span></h5>";
        } else if ($status == 'SELESAISETUJU') {
          echo "<h5><span class='label label-success'>SELESAI SETUJU</span></h5>";
        } else if ($status == 'SELESAIBTL') {
          echo "<h5><span class='label label-success'>SELESAI BTL</span></h5>";
        } else if ($status == 'SELESAITMS') {
          echo "<h5><span class='label label-success'>SELESAI TMS</span></h5>";
        }
        echo "</td>";

          echo "<td align='center'>";
          echo "<form method='POST' action='../cuti/admin_updateusul'>";          
          echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
          echo "<input type='hidden' name='thn_cuti' id='thn_cuti' value='$v[thn_cuti]'>";
          echo "<input type='hidden' name='fid_jns_cuti' id='fid_jns_cuti' value='$v[fid_jns_cuti]'>";
          echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
          if (($status != 'SELESAISETUJU') && ($status != 'SELESAIBTL') && ($status != 'SELESAITMS')) {
          	echo "<button type='submit' class='btn btn-info btn-xs'>";
		echo "<span class='glyphicon glyphicon-new-window' aria-hidden='true'></span><br />Edit Usul";
          } else {
		echo "<button type='submit' class='btn btn-xs' Disabled>";
		echo "<span class='glyphicon glyphicon-new-window' aria-hidden='true'></span><br />Edit Usul";
	  }
	  echo "</button>";
          echo "</form>";
          echo '</td>';
        
        echo "</tr>";

        $no++;
      endforeach;
    }
  }

  function admin_updateusul() {
    $nip = $this->input->post('nip');    
    $thn_cuti = $this->input->post('thn_cuti');
    $fid_jns_cuti = $this->input->post('fid_jns_cuti');
    $idpengantar = $this->input->post('fid_pengantar');
    $data['nopengantar'] = $this->mcuti->getnopengantar($idpengantar);
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['tglpengantar'] = $this->mcuti->gettglpengantar($idpengantar);
    $data['nip'] = $nip;
    $data['fid_pengantar'] = $idpengantar;
    $data['jnscuti'] = $this->mcuti->jnscuti()->result_array();
    
    $data['statuscuti'] = $this->mcuti->statuscuti()->result_array();
    $data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();  
    $data['content'] = 'cuti/admin_updateusul';   
    $this->load->view('template', $data); 
  }

  function admin_updateusul_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('fid_pengantar');

    $id_jnscuti = $this->input->post('id_jnscuti');    
    $jnscuti = $this->mcuti->getnamajeniscuti($id_jnscuti);
    if (($jnscuti == 'CUTI SAKIT') OR ($jnscuti == 'CUTI BERSALIN') OR ($jnscuti == 'CUTI BESAR')) {
      $ketjnscuti = addslashes($this->input->post('ketjnscuti'));      
      $hari_tunda = 0;
    } else if ($jnscuti == 'CUTI TAHUNAN') {
      $hari_tunda = 0;
      $ketjnscuti = '';
    } else {
      $hari_tunda = 0;
      $ketjnscuti = ''; 
    }

    $tahun = addslashes($this->input->post('tahun'));
    $jmlhari = addslashes($this->input->post('jmlhari'));
    $tglmulai = tgl_sql($this->input->post('tglmulai'));
    $tglselesai = tgl_sql($this->input->post('tglselesai'));
    $alamat = addslashes($this->input->post('alamat'));
    $catatan_pej_kepeg = addslashes($this->input->post('catatan_pej_kepeg'));
    $catatan_atasan = addslashes($this->input->post('catatan_atasan'));
    $keputusan_pej = addslashes($this->input->post('keputusan_pej'));
    $id_status = addslashes($this->input->post('id_statusul'));

    $nama = $this->mpegawai->getnama($nip);

    $data = array(      
      'fid_jns_cuti'      => $id_jnscuti,
      'ket_jns_cuti'      => $ketjnscuti,
      'thn_cuti'          => $tahun,
      'jml'               => $jmlhari,
      'tambah_hari_tunda' => $hari_tunda,
      'tgl_mulai'         => $tglmulai,
      'tgl_selesai'       => $tglselesai,
      'alamat'            => $alamat,
      'catatan_pej_kepeg' => $catatan_pej_kepeg,
      'catatan_atasan'    => $catatan_atasan,
      'keputusan_pej'     => $keputusan_pej,
      'fid_status'        => $id_status
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar
    );

    if ($this->mcuti->edit_usul($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$nama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    // tampilkan view cuti      
    $data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar($id_pengantar, $kelompok_cuti)->result_array());
    $data['content'] = 'cuti/admin_tampilupdateusul'; 
    $this->load->view('template', $data);
  }
  // END KHUSUS ADMIN

  function showjmlhari() {
    $jmlhk = $this->input->get('jmlhk');
    $tglmulai = $this->input->get('tglmulai');
    $tglselesai = $this->input->get('tglselesai');
    //echo $jmlhk;
    if (($tglmulai == "") OR ($tglmulai == "0000-00-00")) $tglmulai = date('d-m-Y');
    if (($tglselesai == "") OR ($tglselesai == "0000-00-00")) $tglselesai = date('d-m-Y');
    $mulai = date('Y-m-d',strtotime(tgl_sql($tglmulai)));
    $selesai = date('Y-m-d',strtotime(tgl_sql($tglselesai)));
    $jmlharikerja = 0;
    $jmlliburcutber = 0;

    while ($mulai <= $selesai) {
	// dapatkan nama Hari
	$nmhari = date('D', strtotime($mulai));
	if ($jmlhk == "5") {
		if (($nmhari != "Sat") AND ($nmhari != "Sun")) {
			// Cek Libur dan Cuti Bersama
        		$liburcutber = $this->mcuti->cek_liburcutibersama($mulai);
        		if ($liburcutber) $jmlliburcutber++; // Hitung jumlah Cuti Bersama
			
			$jmlharikerja++;
			//echo $mulai." ".date('D', strtotime($mulai))."<br>";			
		}
	} else if ($jmlhk == "6") {
		if ($nmhari != "Sun") {
			// Cek Libur dan Cuti Bersama
        		$liburcutber = $this->mcuti->cek_liburcutibersama($mulai);
        		if ($liburcutber) $jmlliburcutber++; // Hitung jumlah Cuti Bersama

			$jmlharikerja++;
			//echo $mulai." ".date('D', strtotime($mulai))."<br>";
		}
	}
       	//echo $mulai." ".date('D', strtotime($mulai))."<br>";
       	$mulai = date('Y-m-d',strtotime('+1 days',strtotime($mulai)));
    }
    echo "<div class='text-info'><b>Step II.</b> Entri Tanggal Mulai, Tanggal Selesai dan Jumlah Hari Kerja per Minggu.</div>";	
    echo "<div class='text-info'><b>Step III.</b> Sistem secara otomatis akan menentukan jumlah hari kerja yang dihitung cuti.</div>";
    echo "<h6>Jumlah Hari Kerja <span class='label label-default'>".$jmlharikerja." Hari</span></h6>";
    echo "<h6>Jumlah Libur dan Cuti bersama <span class='label label-default'>".$jmlliburcutber." Hari</span></h6>";	
    $jmlharicuti = $jmlharikerja - $jmlliburcutber;
    echo "<h6><span class='text-danger'><b>Jumlah Hari Cuti</b></span> <span class='label label-danger'>".$jmlharicuti." Hari</span></h6>";
    echo "<input type='hidden' name='jmlharicuti' size='10' value='".$jmlharicuti."' disabled />";
  }

  function hitung_jmlharicuti($jmlhk, $tglmulai, $tglselesai) {
    if (($tglmulai == "") OR ($tglmulai == "0000-00-00")) $tglmulai = date('d-m-Y');
    if (($tglselesai == "") OR ($tglselesai == "0000-00-00")) $tglselesai = date('d-m-Y');
    $mulai = date('Y-m-d',strtotime(tgl_sql($tglmulai)));
    $selesai = date('Y-m-d',strtotime(tgl_sql($tglselesai)));
    $jmlharikerja = 0;
    $jmlliburcutber = 0;

    while ($mulai <= $selesai) {
        // dapatkan nama Hari
        $nmhari = date('D', strtotime($mulai));
        if ($jmlhk == "5") {
                if (($nmhari != "Sat") AND ($nmhari != "Sun")) {
                        // Cek Libur dan Cuti Bersama
                        $liburcutber = $this->mcuti->cek_liburcutibersama($mulai);
                        if ($liburcutber) $jmlliburcutber++; // Hitung jumlah Cuti Bersama

                        $jmlharikerja++;
                }
        } else if ($jmlhk == "6") {
                if ($nmhari != "Sun") {
                        // Cek Libur dan Cuti Bersama
                        $liburcutber = $this->mcuti->cek_liburcutibersama($mulai);
                        if ($liburcutber) $jmlliburcutber++; // Hitung jumlah Cuti Bersama

                        $jmlharikerja++;
                }
        }
        $mulai = date('Y-m-d',strtotime('+1 days',strtotime($mulai)));
    }
    $jmlharicuti = $jmlharikerja - $jmlliburcutber;
    return $jmlharicuti;
  }

  function tambahusulpppk_aksi() {
    $nipppk = addslashes($this->input->post('nipsimpan')); // diambil dari getdatacuti() hasil dari ajax
    $id_pengantar = $this->input->post('id_pengantar');
    $kelompok_cuti = $this->mcuti->getkelompok($id_pengantar);
    $id_jnscuti = $this->input->post('id_jnscuti');
    $jnscuti = $this->mcuti->getnamajeniscuti($id_jnscuti);
    //if (($jnscuti == 'CUTI SAKIT') OR ($jnscuti == 'CUTI BERSALIN') OR ($jnscuti == 'CUTI BESAR')) {
    $ket_jns_cuti = addslashes($this->input->post('ket_jns_cuti'));
    //} else {
    //  $ketjnscuti = '';
    //}

    $tahun = addslashes($this->input->post('tahun'));
    $tglmulai = tgl_sql($this->input->post('tglmulai'));
    $tglselesai = tgl_sql($this->input->post('tglselesai'));
    $jml_hk = $this->input->post('jml_hk');

    $jml = $this->hitung_jmlharicuti($jml_hk, $tglmulai, $tglselesai);
    //$satuan_jml = addslashes($this->input->post('satuan_jml'));
    $satuan_jml = "HARI";

    $alamat = addslashes($this->input->post('alamat'));
    $catatan_pej_kepeg = addslashes($this->input->post('catatan_pej_kepeg'));
    $catatan_atasan = addslashes($this->input->post('catatan_atasan'));
    $keputusan_pej = addslashes($this->input->post('keputusan_pej'));
    $dokumen = $this->input->post('dokumen');
    $id_status = 1; // untuk status cuti INBOXSKPD (pada tabel ref_statuscuti)

    $user_usul = $this->session->userdata('nip');
    $tgl_usul = $this->mlogin->datetime_saatini();

    $data = array(
      'nipppk'            => $nipppk,
      'fid_pengantar'     => $id_pengantar,
      'fid_jns_cuti'      => $id_jnscuti,
      'ket_jns_cuti'   	  => $ket_jns_cuti,
      'thn_cuti'          => $tahun,
      'jml'               => $jml,
      'satuan_jml'        => $satuan_jml,
      'tgl_mulai'         => $tglmulai,
      'tgl_selesai'       => $tglselesai,
      'jml_hk'		  => $jml_hk,	
      'alamat'            => $alamat,
      'catatan_pej_kepeg' => $catatan_pej_kepeg,
      'catatan_atasan'    => $catatan_atasan,
      'keputusan_pej'     => $keputusan_pej,
      'fid_status'        => $id_status,
      'dokumen'		  => $dokumen,
      'user_usul'         => $user_usul,
      'tgl_usul'          => $tgl_usul
      );

    // cek apakah sudah pernah usul, untuk menghindari refresh/reload pada page tambahusul_aksi
    if ($this->mcuti->cektelahusul_pppk($nipppk, $tahun) == 0) {
      if ($this->mcuti->inputpppk_usul($data))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Usul Cuti PPPK<u> '.$this->mpppk->getnama_lengkap($data['nipppk']).'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Usul Cuti PPPK<u> '.$this->mpppk->getnama_lengkap($data['nipppk']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika sudah pernah usul
      $data['pesan'] = '<b>Gagal !</b>, Usul Cuti PPPK<u> '.$this->mpppk->getnama_lengkap($data['nipppk']).'</u> gagal ditambah.<br />Terdapat usul yang belum diselesaikan';
      $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view cuti
    $data['nopengantar'] = $this->mcuti->getnopengantar($id_pengantar);
    $data['cuti'] = $this->mcuti->detailpengantar_pppk($id_pengantar)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mcuti->detailpengantar_pppk($id_pengantar)->result_array());
    $data['content'] = 'cuti/detailpengantarcuti';
    $this->load->view('template', $data);
  }          

  function rekap_sisa() {
    if ($this->session->userdata('usulcuti_priv') == "Y") {
      $data['content'] = 'cuti/rekap_sisa';
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['tahun'] = $this->mcuti->gettahuncuti()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function carirekap_sisa() {
    $idunker = $this->input->get('idunker');
    $bln = $this->input->get('bln');
    $thn = $this->input->get('thn');	
    $jnsasn = $this->input->get('jnsasn');
    $jmlhkpw = $this->input->get('jmlhkpw');

    if ($jnsasn == "PNS") {
      //$sqlcari = $this->mcuti->carirekap($idunker, $thn)->result_array();
      $sqlcari = $this->munker->pegperunker($idunker)->result_array();
      //$jml = count($this->mcuti->carirekap($idunker, $thn)->result_array());
      $jml = $this->munker->pegperunker($idunker)->result_array();	
    } else if ($jnsasn == "PPPK") {
      $sqlcari = $this->munker->pppkperunker($idunker)->result_array();
      $jml = $this->munker->pppkperunker($idunker)->result_array();	
      //$sqlcari = $this->mcuti->carirekap_pppk($idunker, $thn)->result_array();
      //$jml = count($this->mcuti->carirekap_pppk($idunker, $thn)->result_array());
    }

    if ($jml != 0) {
      echo '<br/>';
      echo '<table class="table table-condensed table-hover">';
      echo "<tr class='info'>
        <td align='center' width='50'><b>No</b></td>
        <td align='center' width='200'><b>Nomor Induk | Nama</b></td>
        <td align='center' width='400'><b>Jabatan</b></td>
        <td align='center' width='60'><b>Total Cuti ".$thn."</b></td>
        <td align='center' width='450'><b>Riwayat Cuti</b></td>
        <td align='center' width='150'><b>Keterangan</b></td>
        </tr>";

      $no = 1;
      foreach($sqlcari as $v):
        if ($jnsasn == "PNS") {
                $ni = $v['nip'];
                //$nama = namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']);
                $nama = $this->mpegawai->getnama($ni);
                if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
                }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
                }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
                }
                $jab = $this->mpegawai->namajab($v['fid_jnsjab'],$idjab);
        } else if ($jnsasn == "PPPK") {
                $ni = $v['nip'];
                $nama = $this->mpppk->getnama_lengkap($ni);
                $jab = $this->mpegawai->namajab("3",$v['fid_jabft']);
        }
        echo "<tr><td align='center'>".$no."</td>";
        //echo '<td>',$ni,'<br />',$nama,'</td>';
        echo "<td>".$ni."<br />".$nama."</td>";

        /*
        if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        }
        */

        //echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab),'</td>';
        echo "<td>".$jab."</td>";

	echo "<td align='center'>";
	if ($jnsasn == "PNS") {
	  $jmlcutitahunini = $this->mcuti->jml_cuti_tahun_sekarang($thn, $v['nip']);
        } else if ($jnsasn == "PPPK") {
	  $jmlcutitahunini = $this->mcuti->jml_cuti_tahun_sekarang_pppk($thn, $v['nip']);
        }

	echo $jmlcutitahunini;
	echo "</td>";

	if ($jnsasn == "PNS") {
	  $datarwy = $this->mcuti->getusulpns_perbulan($thn, $v['nip']);
	} else  if ($jnsasn == "PPPK") {
          $datarwy = $this->mcuti->getusulpppk_perbulan($thn, $v['nip']);
        }

	if ($datarwy) {
	  $totsisahk = 0;
	  $totjmlcuti = 0;
	  echo "<td align='left'>";
	  foreach($datarwy as $dr):
		//echo "<small>";
		$jnscuti = $this->mcuti->getnamajeniscuti($dr->fid_jns_cuti);
		//echo $jnscuti." - ".tgl_indo($dr->tgl_mulai)." s/d ".tgl_indo($dr->tgl_selesai)." (".$dr->jml." ".$dr->satuan_jml.")";
		echo $jnscuti." - ".tgl_indo($dr->tgl_mulai)." s/d ".tgl_indo($dr->tgl_selesai);
		$tglmulai = $dr->tgl_mulai;
		$tglselesai = $dr->tgl_selesai;
		//echo $tglmulai;
		//echo date("n", $tglmulai);
		$blnmulai = date("n", strtotime($tglmulai));
		$blnselesai = date("n", strtotime($tglselesai));
		// Cek sisa hari kerja bulan tersebut
		if (($blnmulai == $bln) OR ($blnselesai == $bln) OR ($blnmulai < $bln AND $blnselesai > $bln)) {
			//$lastdatemulai = date("Y-m-t", strtotime($tglmulai));
			//$firstdatemulai = date("Y-m-01", strtotime($tglmulai));
			//$lastdateselesai = date("Y-m-t", strtotime($tglselesai));
			//echo $dr->tgl_mulai." ";
			//echo date("Y-m-t", $tglmulai);
			//echo $lastdatemulai;
			//echo $firstdatemulai; 
		   		
			$jmlhk = $this->mcuti->getjmlhk_perbulan($bln, $thn, $jmlhkpw);
			if ($jmlhkpw == "5") {
			  //$jmlhk = $this->mcuti->getjmlhk_perbulan($bln, $thn, $jmlhkpw);
			  //echo $jmlhk_5;
			  $jmlcuti = $this->mcuti->getjmlhcuti_perbulan($tglmulai, $tglselesai, $bln, "5");
			  //$sisahk = $jmlhk_5 - $jmlcuti_5;
                          //echo " Jml Cuti ".$jmlcuti_5;
			  //echo "<span class='text text-primary'> Sisa ".bulan($bln)." : ".$sisahk_5." (5 HK)</span>";
			} else if ($jmlhkpw == "6") {	
			  //$jmlhk = $this->mcuti->getjmlhk_perbulan($bln, $thn, "6");
			  //echo $jmlhk_6;
			  $jmlcuti = $this->mcuti->getjmlhcuti_perbulan($tglmulai, $tglselesai, $bln, "6");
			  //$sisahk = $jmlhk_6 - $jmlcuti_6;
                          //echo " Jml Cuti ".$jmlcuti_6;
                          //echo "<span class='text text-primary'> Sisa ".bulan($bln)." : ".$sisahk_6." (6 HK)</span>";
			}
			$sisahk = $jmlhk - $jmlcuti;
			echo " (Cuti ".bulan($bln)." : ".$jmlcuti." HK)";
			//echo " - Sisa ".bulan($bln)." : ".$sisahk." HK";
			$status = $this->mcuti->getstatuscuti($dr->fid_status);
                	echo " <b><small><span class='text text-primary'>".$status."</span></small></b>";

                	$totjmlcuti = $totjmlcuti + $jmlcuti;				
		}
		//echo "</small>";
		echo "<br/>";
	  endforeach; 
	  echo "</td>";

	  echo "<td>";
	    if ($totjmlcuti != 0) {
              echo "<b>".strtoupper(bulan($bln))."</b><br/>";
              echo "Jml. HK : ".$jmlhk." / ";
	      echo "Jml. Cuti : ".$totjmlcuti." HK<br/>";
	      $totsisahk = $jmlhk - $totjmlcuti;
	      if ($totsisahk < 7) { 			
	      	echo "<b><span class='label label-danger'>SISA HK : ".$totsisahk."</span></b>";
	      } else {
 		echo "<b><span class='text text-success'>SISA HK : ".$totsisahk."</span></b>";
	      }	
	    }
	  echo "</td>";
		
 
	} else {
	  echo "<td></td>";
	  echo "<td></td>";
	}	
        $no++;
        endforeach;
    } else {
      echo "<br/><div class='alert alert-info' role='alert'>DATA TIDAK DITEMUKAN</div>";
    }
  }
	
}
