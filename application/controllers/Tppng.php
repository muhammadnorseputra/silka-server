<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tppng extends CI_Controller {

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
    //$this->load->model('mpppk');
    //$this->load->model('madmin');
    $this->load->model('mtppng');    
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
    $data['content'] = 'tppng/periode';
    $data['periode'] = $this->mtppng->periode()->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $this->load->view('template', $data);
  }

  function detailperiode() {
    $idperiode = addslashes($this->input->post('id_periode'));
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng->get_pengantar($idperiode)->result_array();
    $data['content'] = 'tppng/detailperiode';
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
    $data['data'] = $this->mtppng->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng/detailperiodeunor';
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
    $config['upload_path'] = './filetppng/'; //Folder untuk menyimpan hasil upload
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

              $this->mtppng->update_pembayaran($where, $datatodb);
              $this->mtppng->update_status('tppng', ['fid_status' => 6], ['fid_pengantar' => $idpengantar]);

              if (file_exists('./filetppng/'.$nmberkaslama.'.pdf')) {
                unlink('./filetppng/'.$nmberkaslama.'.pdf');
              } elseif (file_exists('./filetppng/'.$nmberkaslama.'.PDF')) {
                      unlink('./filetppng/'.$nmberkaslama.'.PDF');
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
      $data['data'] = $this->mtppng->tampil_tppng($idpengantar, $idperiode)->result_array();
      $data['content'] = 'tppng/detailperiodeunor';
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

    $blnperiode = $this->mtppng->get_bulanperiode($idperiode);
    $thnperiode = $this->mtppng->get_tahunperiode($idperiode); 

    $jnsasn = $this->mtppng->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $nama = $this->mpegawai->getnama($nip);
      $id_unker_nip = $this->mtppng->get_idunker_pns($nip);
    } else if ($jnsasn == "PPPK") {
      $nama = $this->mpppk->getnama($nip);
      $id_unker_nip = $this->mtppng->get_idunker_pppk($nip);
    }

    $telahusul = $this->mtppng->cektelahusul($nip, $thnperiode, $blnperiode);
    //$id_unker_nip = $this->mkinerja->get_idunker($nip);
    $id_unker_pengantar = $this->mtppng->get_idunker($idpengantar);

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
          $jnsptkp = $this->mtppng->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga        
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
        echo "<div class='col-md-8'>
                <blockquote style='font-size: 10px;'>
                <span class='text text-success'><b>IDENTITAS</b></span>
                  <div class='row'>
                    <div class='col-md-3'><b>NAMA</b></div>
                    <div class='col-md-4' align='left'>".$nama."</div>
                    <div class='col-md-2' align='right'><b>NPWP</b></div>
                    <div class='col-md-3' align='left'>".$npwp."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>STATUS</b></div>
                    <div class='col-md-4' align='left'>".$statpeg."</div>
                    <div class='col-md-2' align='right'><b>Jenis PTKP</b></div>
                    <div class='col-md-3' align='left'>".$jnsptkp."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>PANGKAT/GOLRU</b></div>
                    <div class='col-md-4' align='left'>".$golru." (".$pangkat.")</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>KELAS JABATAN</b></div>
                    <div class='col-md-4' align='left'>".$kelasjab."</div>
                  </div>
		  <div class='row'>
                    <div class='col-md-3'><b>ATASAN LANGSUNG</b></div>
                    <div class='col-md-9' align='left'>".$nmjab_atasan."</div>
                  </div>
                </blockquote>
              </div>";

        if ($jnsasn == "PNS") {
          $haktpp = $this->mkinerja->get_haktpp($nip);
          $abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
	  // cek nakes atau tidak
	  $kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
	  if ($kinnakes != 0) {
		$kin = $kinnakes; // isinya jml aktifitas nakes
	  } else {
          	$kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
          }
	  $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
        } if ($jnsasn == "PPPK") {
          $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
          $abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
          //$kin = $this->mkinerja_pppk->get_realisasikinerja($nip, $thnperiode, $blnperiode);
	  $kinnakes = $this->mkinerja_pppk->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
          if ($kinnakes != 0) {
                $kin = $kinnakes; // isinya jml aktifitas nakes
          } else {
                $kin = $this->mkinerja_pppk->get_realisasikinerja($nip, $thnperiode, $blnperiode);
          }
          $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
        }
        echo "<div class='col-md-4'>
                <blockquote  style='font-size: 10px;'>
                <span class='text text-success' ><b>SYARAT PERHITUNGAN</b></span>
                <br/>";
        echo "<div class='row'>";
        if ($haktpp == "YA") {
          echo "<div class='col-md-2'>
                  <span class='label label-success'>BERHAK TPP                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-2'>
                  <span class='label label-danger'>BERHAK TPP                    
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>";

        echo "<div class='row'>";
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

        if ($kin != NULL) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>NILAI KINERJA                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>NILAI KINERJA                    
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>";

        echo "<div class='row'>";
        if ($gaji) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>GAJI                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>GAJI
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }

        if ($jnsptkp) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>JNS PTKP                    
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>JNS PTKP
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>";
        echo "</blockquote>";
        echo "</div>"; // End Kolom
        echo "</div>"; // End ROW IDENTITAS

        if ($haktpp AND ($abs != NULL) AND ($kin != NULL) AND $gaji AND $jnsptkp) {
	  // Jika Absensi NOL (TK sebulanan), maka Kinerja juga 0
	  if ($abs == 0) $kin = 0;
	
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
          
          $pabs = 0.4 * $abs; // persentase absensi (40%)
          
          echo "<div class='row'>";
          if ($pengurang != "mkd7h") { // Masuk kerja kurang dari 7 hari
            $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)
            echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-primary'><b>PRODUKTIFITAS KERJA</b></span>
                    <br/>Nilai Kinerja : ".$kin."              
                    <br/>Capaian : ".$ckin." (".$kkin.")
                    <br/>Persentase : ".$pkin."
                  ";
          } else if ($pengurang == "mkd7h") {
            $pkin = 0.4 * $kin; // Hitung 40% dari pembulatan realisasi kinerja 
            echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-primary'><b>PRODUKTIFITAS KERJA</b></span>
                    <br/>Nilai SKP : ".$kin."              
                    <br/>Capaian : ".$ckin." (".$kkin.")
                    <br/>Persentase : ".$pkin."<br/><span class='text text-warning'>(Masuk Kerja kurang dari 7 Hari)</span>
                  ";
          }
          
          echo "<br/><br/>
                  <span class='text text-danger'><b>DISIPLIN KERJA</b></span>
                    <br/>Nilai Absensi : ".$abs."
                    <br/>Persentase : ".$pabs."
                  </blockquote>
                </div>";

          $realisasi = $pkin + $pabs;
          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-success'><b>PERSENTASE KINERJA</b></span>
                    <h5>".$realisasi."</h5>
                  </blockquote>
                </div>";

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
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-primary'><b>KALKULASI TPP (".$ket.")</b></span>
	                    <div class='row'>
                      <div class='col-md-5'><b>KRITERIA</b></div>
                      <div class='col-md-4' align='right'><b>BASIC</b></div>
                      <div class='col-md-3' align='right'><b>REALISASI</b></div>
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
                  </blockquote>
                </div>";

          echo "</div>"; // end ROW KEDUA

          if ($jnsasn == "PNS") {
            $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
            $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
            $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
            $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
            $bpjs_gaji = $this->mtppng->get_bpjsgaji($nip, $thnperiode, $blnperiode);
          } else if ($jnsasn == "PPPK") {
            $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
            $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode);
            $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode);
            $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode);
            $bpjs_gaji = $this->mtppng->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
          }

          $hasil_bruto = $gaji_bruto + $rea_bruto;
          $biaya_jab = $hasil_bruto * 0.05;
          if ($biaya_jab > 500000) {
            $biaya_jab = 500000;
          }

	  if ($jnsasn == "PNS") {
		$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
          } else if ($jnsasn == "PPPK") {
		$pph_bayar = $this->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
          }
          
          echo "<div class='row'>";
          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                    <span class='text text-primary'><b>PPh 21 Non Final</b></span>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Gaji Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($gaji_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>TPP Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($rea_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>Pot. Gaji</div>
                      <div class='col-md-6' align='right'>(".number_format($pot_gaji,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>PPh 21 Gaji</div>
                      <div class='col-md-6' align='right'>(".number_format($pph_gaji,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>Biaya Jab</div>
                      <div class='col-md-6' align='right'>(".number_format($biaya_jab,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Pot. PPh 21</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($pph_bayar,2,',','.')."</b></span></div>
                    </div>
                  </blockquote>
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
          
          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                    <span class='text text-primary'><b>IWP 1%</b></span>
                    <div class='row'>
                      <div class='col-md-12'><span class='text text-muted'>1% (Gaji + TPP) Maks. 120.000</span></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>IWP Gaji</div>
                      <div class='col-md-6' align='right'>".number_format($iwp_gaji,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>IWP TPP</div>
                      <div class='col-md-6' align='right'>".number_format($iwp_tpp,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Pot. IWP</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($iwp_terhutang,2,',','.')."</b></span></div>
                    </div>
                  </blockquote>
                </div>";

          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                    <span class='text text-primary'><b>BPJS 4%</b></span>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Tunj. BPJS</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($bpjs_terhutang,2,',','.')."</b></span></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-12'><span class='text text-muted'>4% (Gaji + TPP) Maks. 480.000</span></div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>BPJS Gaji</div>
                      <div class='col-md-6' align='right'>".number_format($bpjs_gaji,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>BPJS TPP</div>
                      <div class='col-md-6' align='right'>".number_format($bpjs_tpp,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Pot. BPJS</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($bpjs_terhutang,2,',','.')."</b></span></div>
                    </div>                    
                  </blockquote>
                </div>";

          
          //if ($statpeg == "PNS") {
          //if (($statpeg == "PNS") OR ($statpeg == "PPPK")) {
            $thp = round($rea_bruto) + round($bpjs_terhutang) - (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
          //  $ket_statpeg = "";
          //} else if ($statpeg == "CPNS") {
          //  $thp = ($rea_bruto + $bpjs_terhutang - ($pph_bayar+$iwp_terhutang+$bpjs_terhutang)) * 0.8; // CPNS 80%
          //  $ket_statpeg = "(CPNS 80%)";  
          //}          

          
          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-danger'><b>TAKE HOME PAY</b></span><br/>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Real. TPP</div>
                      <div class='col-md-6' align='right'>".number_format(round($rea_bruto),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tunj. BPJS</div>
                      <div class='col-md-6' align='right'>".number_format(round($bpjs_terhutang),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Pot. PPh 21</div>
                      <div class='col-md-6' align='right'>(".number_format(round($pph_bayar),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Pot IWP</div>
                      <div class='col-md-6' align='right'>(".number_format(round($iwp_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Pot BPJS</div>
                      <div class='col-md-6' align='right'>(".number_format(round($bpjs_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><b><span class='text text-danger'>TPP NETO</span></b></div>
                      <div class='col-md-6' align='right'>
                          <b><span class='text text-danger'>".number_format(round($thp,0),2,',','.')."</span></b>
                        </div>
                    </div>
                </div>";

          echo "</div>"; // End ROW KETIGA
          echo "<div class='row'>";
          echo "<div class='col-md-10'>
                  <textarea class='form-control' rows='2' id='catatan' name='catatan' placeholder='WAJIB : Tulis catatan terkait kalkulasi TPP disini' value='' required></textarea>
                </div>
                <div class='col-md-2'>";
	  //if ($this->session->userdata('nip') == "198104072009041002") {
  	  echo "  <button type='submit' class='btn btn-success btn-outline btn-sm' onclick='' >
                          <span class='glyphicon glyphicon-save' aria-hidden='true'></span><br/>SIMPAN
                  </button>";
	  //}
          echo "</div>"; // End Kolom tombol Simpan
          echo "</div>"; // End ROW THP

        } else {
        echo "<div align='center' class='text text-warning'>1TIDAK DAPAT DILANJUTKAN, SYARAT PERHITUNGAN TIDAK LENGKAP</div>";
      }
    } // End Cek NIP

  }

  function hitungpph($nip, $thn, $bln, $tppbruto) {
    $gajibruto =  $this->mkinerja->get_gajibruto($nip, $thn, $bln);
    //$jnsptkp =  $this->mkinerja->get_jnsptkp($nip); // Jenis PTKP dari tabel Pegawai
    $jnsptkp = $this->mtppng->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga
    $jnskel =  $this->mpegawai->getjnskel($nip);
    //if (($jnsptkp == '') OR ($jnsptkp == NULL) OR ($jnskel == 'PEREMPUAN')) { // PNS wanita dihitung TK/0
    if (($jnsptkp == '') OR ($jnsptkp == NULL)) { // jika data ptkp kosong, maka dihitung TK/0
      $jnsptkp = 'TK/0';
      $ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    } else {
      $ptkp =  $this->mkinerja->get_ptkp($jnsptkp);
      //echo $ptkp;
    }
    
    $npwp =  $this->mkinerja->get_npwp($nip);

    $jmlpot =  $this->mkinerja->get_jmlpotongan($nip, $thn, $bln);

    $hasilbruto = $gajibruto + $tppbruto;
     // Biaya jabatan 5% maksimal 500ribu
    $biayajab = $hasilbruto * 0.05;
    if ($biayajab > 500000) {
      $biayajab = 500000;
    }

    //$hasilnetto = $hasilbruto-($jmlpot + round($biayajab)); 
    $hasilnetto = $hasilbruto-($jmlpot + $biayajab);
    $hasilnetto_tahun = $hasilnetto*12;
//echo $biayajab;
    $pkp = $hasilnetto_tahun - $ptkp;
    $pkp_b = pembulatan_ribuan(round($pkp));
//echo $pkp_b;
    $pph = 0;
    if (($pkp_b >= 1) AND ($pkp_b <= 60000000)) {
      $pph = $pkp_b*0.05;
    } else if (($pkp_b > 60000000) AND ($pkp_b <= 250000000)) {
      $pph = $pph + 3000000 + (($pkp_b - 60000000) * 0.15); // 3juta -> 60juta * 5%
    } else if (($pkp_b > 250000000) AND ($pkp_b <= 500000000)) {
      $pph = $pph + 31500000 + (($pkp_b-250000000) * 0.25); // 31,5juta -> ((60jt*5%)+(190jt*15%))
    } else if ($pkp_b > 500000000) {
      $pph = $pph + 94000000 + (($pkp_b-500000000) * 0.30); // 94jt -> ((60jt*5%) + (190jt*15%) + (250jt*25%))
    }
//echo $pph;
    $pph_perbulan = $pph / 12;
    if ($npwp == '') {
      // jika NPWP tidak ada, maka PPh jadi 120%
      $pph_perbulan = $pph_perbulan * 1.2;
    }

    $pphgaji = $this->mkinerja->get_pphgaji($nip,$thn, $bln);
    $pph_disetor = $pph_perbulan - $pphgaji;
//echo $pph_perbulan;
    return $pph_disetor;
  }

  function hitungpph_pppk($nip, $thn, $bln, $tppbruto) {
    $gajibruto =  $this->mkinerja_pppk->get_gajibruto($nip, $thn, $bln);
    $jnsptkp =  $this->mkinerja_pppk->get_jnsptkp($nip); // Jenis PTKP dari tabel PPPK
    $jnskel =  $this->mpppk->getjnskel($nip);
    //if (($jnsptkp == '') OR ($jnsptkp == NULL) OR ($jnskel == 'PEREMPUAN')) { // PPPK Wanita dihitung TK/0
    if (($jnsptkp == '') OR ($jnsptkp == NULL)) {
      // jika data ptkp kosong, maka dihitung TK/0
      $jnsptkp = 'TK/0';
      $ptkp = $this->mkinerja_pppk->get_ptkp($jnsptkp);
    } else {
      $ptkp =  $this->mkinerja_pppk->get_ptkp($jnsptkp);
      //echo $ptkp;
    }

    $npwp =  $this->mkinerja_pppk->get_npwp($nip);

    $jmlpot =  $this->mkinerja_pppk->get_jmlpotongan($nip, $thn, $bln);

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
      $pph = $pph + 3000000 + (($pkp_b - 60000000) * 0.15);
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

    $pphgaji = $this->mkinerja_pppk->get_pphgaji($nip,$thn, $bln);
    $pph_disetor = $pph_perbulan - $pphgaji;

    return $pph_disetor;
  }


  function tmbkalk_aksi() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));
    $nip = addslashes($this->input->post('nip'));
    $idjabpeta = addslashes($this->input->post('idjabpeta'));
    $jabatan = $this->mpetajab->get_namajab($idjabpeta);

    $jnsasn = $this->mtppng->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $statpeg = $this->mpegawai->getstatpeg($nip);
      $idgolru = $this->mpetajab->getidgolru($nip);
      $golru = $this->mpegawai->getnamagolru($idgolru);
      $pangkat = $this->mpegawai->getnamapangkat($idgolru);
      $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);
      $npwp = $this->mkinerja->get_npwp($nip);
      //$jnsptkp = $this->mkinerja->get_jnsptkp($nip);        
      $jnsptkp = $this->mtppng->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga	
    } else if ($jnsasn == "PPPK") {
      $statpeg = "PPPK";
      $idgolru = $this->mpppk->getidgolruterakhir($nip);
      $golru = $this->mpppk->getnamagolru($idgolru);
      $pangkat = "";
      $tmtjab = "";
      $npwp = $this->mkinerja_pppk->get_npwp($nip);;
      $jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
    }

    //$idgolru = $this->mpetajab->getidgolru($nip);
    $id_unker = $this->mtppng->get_idunker($idpengantar);
    $idjabpltpeta = addslashes($this->input->post('idjabpltpeta'));
    $jabatanplt = $this->mpetajab->get_namajab($idjabpltpeta);
    $jnsplt = addslashes($this->input->post('jnsplt'));
    $pengurang = addslashes($this->input->post('pengurang'));

    $blnperiode = $this->mtppng->get_bulanperiode($idperiode);
    $thnperiode = $this->mtppng->get_tahunperiode($idperiode); 

    //$statpeg = $this->mpegawai->getstatpeg($nip);
    
    if ($jnsasn == "PNS") {
      $haktpp = $this->mkinerja->get_haktpp($nip);
      $abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      // cek nakes atau tidak
      $kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
      if ($kinnakes != 0) {
         $kin = $kinnakes; // isinya jml aktifitas nakes
      } else {
         $kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      }	

      //$kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng->get_bpjsgaji($nip, $thnperiode, $blnperiode);
    } if ($jnsasn == "PPPK") {
      $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
      $abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      //$kin = $this->mkinerja_pppk->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      $kinnakes = $this->mkinerja_pppk->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
      if ($kinnakes != 0) {
      	$kin = $kinnakes; // isinya jml aktifitas nakes
      } else {
      	$kin = $this->mkinerja_pppk->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      }
      $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
      $bpjs_gaji = $this->mtppng->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
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

    // khusus Nakes,cek ada tidak nilai di field jml_aktifitas_nakes
    //$kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
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

    $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)
    
    if ($pengurang != "mkd7h") {
            $pkin = 0.6 * $ckin;
    } else if ($pengurang == "mkd7h") {
            $pkin = 0.4 * $kin;
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
    } else if ($jnsasn == "PPPK") {
      $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
      $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode);
      $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode);
      $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode);
    }

    //$gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
    //$pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
    //$pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
    $hasil_bruto = $gaji_bruto + $rea_bruto;
    $biaya_jab = $hasil_bruto * 0.05;
    if ($biaya_jab > 500000) {
      $biaya_jab = 500000;
    }
    //$npwp = $this->mkinerja->get_npwp($nip);
    //$jnsptkp = $this->mkinerja->get_jnsptkp($nip);

    // Hitung PPh21  
    //$ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    //$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    if ($jnsasn == "PNS") {
       	$ptkp = $this->mkinerja->get_ptkp($jnsptkp);
	$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    } else if ($jnsasn == "PPPK") {
	$ptkp = $this->mkinerja_pppk->get_ptkp($jnsptkp);
       	$pph_bayar = $this->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
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
      $thp = round($rea_bruto) + round($bpjs_terhutang) - (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
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
      'nilai_produktifitas'   => $kin,
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

    if ($this->mtppng->cektelahusul($nip, $thnperiode, $blnperiode) == 0) {
      if ($this->mtppng->input_tppng($data)) {
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
    $data['data'] = $this->mtppng->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function hapustppng(){    
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng->get_idunker($id_pengantar);
    $bln = $this->mtppng->get_bulanperiode($id_periode);
    $thn = $this->mtppng->get_tahunperiode($id_periode);

    $where = array('nip' => $nip,
                   'fid_pengantar' => $id_pengantar,
                   'fid_periode' => $id_periode
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mtppng->hapustppng($where)) {// hapus seluruh usulan pada tabel usul_tpp
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
    $data['data'] = $this->mtppng->tampil_tppng($id_pengantar, $id_periode)->result_array();
    $data['content'] = 'tppng/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function tmbunorperiode_aksi() {
    $idperiode = addslashes($this->input->post('idperiode'));
    $idunor = addslashes($this->input->post('idunor'));
    $jnsasn = addslashes($this->input->post('jnsasn'));

    $bln = $this->mtppng->get_bulanperiode($idperiode);
    $thn = $this->mtppng->get_tahunperiode($idperiode);

    // START QR CODE
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/qrcodetppng/'; //direktori penyimpanan qr code
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

    $telahusul = $this->mtppng->cektelahusul_pengantar($idperiode, $idunor, $jnsasn);
    $cekstatusberkasbulanlalu = $this->mtppng->cekstatusberkaspengantar_bulanlalu($idperiode, $idunor, $jnsasn);
    if (($telahusul == 0) AND ($cekstatusberkasbulanlalu)) {
      if ($this->mtppng->input_tppng_pengantar($data)) {
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
    $data['data'] = $this->mtppng->get_pengantar($idperiode)->result_array();
    $data['content'] = 'tppng/detailperiode';
    $this->load->view('template', $data);
  }

  function hapuspengantar(){    
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng->get_idunker($id_pengantar);
    $bln = $this->mtppng->get_bulanperiode($id_periode);
    $thn = $this->mtppng->get_tahunperiode($id_periode);

    $where = array('id' => $id_pengantar,
                   'fid_unker' => $id_unker,
                   'fid_periode' => $id_periode
    );

    $nmunker = $this->munker->getnamaunker($id_unker);
    if ($this->mtppng->hapustppng_pengantar($where)) {// hapus seluruh usulan pada tabel usul_tpp
      $qrcode = $this->mtppng->getqrcode($id_pengantar);
      
      if (is_file("../assets/qrcodetppng/".$qrcode.".png")) {
        unlink("../assets/qrcodetppng/".$qrcode.".png");
      }
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.', periode '.bulan($bln).' '.$thn.' BERHASIL DIHAPUS';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.', periode '.bulan($bln).' '.$thn.' GAGAL DIHAPUS';
      $data['jnspesan'] = 'alert alert-info';
    }
    
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng->get_pengantar($id_periode)->result_array();
    $data['content'] = 'tppng/detailperiode';
    $this->load->view('template', $data);
  }

  function valid_tppng() {
    $id = addslashes($this->input->post('id'));
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng->get_idunker($id_pengantar);
    $bln = $this->mtppng->get_bulanperiode($id_periode);
    $thn = $this->mtppng->get_tahunperiode($id_periode);

    $data = array(
      'fid_status'         => '2', // VALID
    );

    $where = array('id' => $id
    );

    $this->mtppng->edit_tppng($where, $data);
    
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $id_pengantar;
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng->tampil_tppng($id_pengantar, $id_periode)->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'tppng/detailperiodeunor';
    $this->load->view('template', $data);
  }

  function invalid_tppng() {
    $id = addslashes($this->input->post('id'));
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $id_periode = addslashes($this->input->post('id_periode'));

    $id_unker = $this->mtppng->get_idunker($id_pengantar);
    $bln = $this->mtppng->get_bulanperiode($id_periode);
    $thn = $this->mtppng->get_tahunperiode($id_periode);

    $data = array(
      'fid_status'  => '1', // VALID
    );

    $where = array('id' => $id
    );

    $this->mtppng->edit_tppng($where, $data);
    
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $id_pengantar;
    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng->tampil_tppng($id_pengantar, $id_periode)->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'tppng/detailperiodeunor';
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

    $id_unker = $this->mtppng->get_idunker($id_pengantar);
    $nmunker = $this->munker->getnamaunker($id_unker);

    if (($this->mtppng->edit_tppng($where_tppng, $data_tppng)) AND ($this->mtppng->edit_tppngpengantar($where_pengantar, $data_pengantar))) {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.' BERHASIL DIKIRIM KE BKPSDM';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Sukses</b>, TPP  '.$nmunker.' GAGAL DIKIRIM KE BKPSDM';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng->get_pengantar($id_periode)->result_array();
    $data['content'] = 'tppng/detailperiode';
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

    $id_unker = $this->mtppng->get_idunker($id_pengantar);
    $nmunker = $this->munker->getnamaunker($id_unker);

    if (($this->mtppng->edit_tppng($where_tppng, $data_tppng)) AND ($this->mtppng->edit_tppngpengantar($where_pengantar, $data_pengantar))) {
      $data['pesan'] = '<b>Sukses</b>, TPP '.$nmunker.' BERHASIL DI-APPROVE';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal</b>, TPP '.$nmunker.' GAGAL DI-APPROVE';
      $data['jnspesan'] = 'alert alert-info';
    }

    $data['idperiode'] = $id_periode;
    $data['data'] = $this->mtppng->get_pengantar($id_periode)->result_array();
    $data['content'] = 'tppng/detailperiode';
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

    if ($this->mtppng->edit_tppngpengantar($where_pengantar, $data_pengantar)) {
      // Update status masing2 usulan PNS menjadi PRINT	
      $this->mtppng->edit_tppng($where_tppng, $data_tppng);
	
      $data['pesan'] = '<b>SUKSES</b>, Spesimen Berhasil Disimpan';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>GAGAL</b>, Spesimen Gagal Disimpan';
      $data['jnspesan'] = 'alert alert-warning';
    }

    $data['$idpengantar'] = $idpengantar;
    $data['data'] = $this->mtppng->cetak_tandaterima($idpengantar, $idperiode)->result_array();
    $this->load->view('/tppng/cetaktandaterima',$data);     
  }

  function tampilkalkulasithr() {
    $nip = addslashes($this->input->get('nip'));
    $idpengantar = addslashes($this->input->get('idpengantar'));
    $idperiode = addslashes($this->input->get('idperiode'));
    $idjabpeta = addslashes($this->input->get('idjabpeta'));
    $idjabpltpeta = addslashes($this->input->get('idjabpltpeta'));
    $jnsplt = addslashes($this->input->get('jnsplt'));
    //$pengurang = addslashes($this->input->get('pengurang'));
    $pengurang = '';

    $blnperiode = $this->mtppng->get_bulanperiode($idperiode);
    $blnperiode_gaji = '5';
    $thnperiode = $this->mtppng->get_tahunperiode($idperiode);

    $jnsasn = $this->mtppng->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $nama = $this->mpegawai->getnama($nip);
      $id_unker_nip = $this->mtppng->get_idunker_pns($nip);
    } else if ($jnsasn == "PPPK") {
      $nama = $this->mpppk->getnama($nip);
      $id_unker_nip = $this->mtppng->get_idunker_pppk($nip);
    }

    $telahusul = $this->mtppng->cektelahusul($nip, $thnperiode, $blnperiode);
    //$id_unker_nip = $this->mkinerja->get_idunker($nip);
    $id_unker_pengantar = $this->mtppng->get_idunker($idpengantar);
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
          $jnsptkp = $this->mtppng->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga
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
        echo "<div class='col-md-8'>
                <blockquote style='font-size: 10px;'>
                <span class='text text-success'><b>IDENTITAS</b></span>
                  <div class='row'>
                    <div class='col-md-3'><b>NAMA</b></div>
                    <div class='col-md-4' align='left'>".$nama."</div>
                    <div class='col-md-2' align='right'><b>NPWP</b></div>
                    <div class='col-md-3' align='left'>".$npwp."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>STATUS</b></div>
                    <div class='col-md-4' align='left'>".$statpeg."</div>
                    <div class='col-md-2' align='right'><b>Jenis PTKP</b></div>
                    <div class='col-md-3' align='left'>".$jnsptkp."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>PANGKAT/GOLRU</b></div>
                    <div class='col-md-4' align='left'>".$golru." (".$pangkat.")</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>KELAS JABATAN</b></div>
                    <div class='col-md-4' align='left'>".$kelasjab."</div>
                  </div>
                  <div class='row'>
                    <div class='col-md-3'><b>ATASAN LANGSUNG</b></div>
                    <div class='col-md-9' align='left'>".$nmjab_atasan."</div>
                  </div>
                </blockquote>
	      </div>";
	if ($jnsasn == "PNS") {
          $haktpp = $this->mkinerja->get_haktpp($nip);
	  $abs = 100;
          //$abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
          
	  // cek nakes atau tidak
          //$kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
          //if ($kinnakes != 0) {
          //      $kin = $kinnakes; // isinya jml aktifitas nakes
          //} else {
          //      $kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
          //}
	  $kin = 100;
          //$gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
	  $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode_gaji); // Gunakan Gaji bulan Mei
        } if ($jnsasn == "PPPK") {
          $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
          //$abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
          //$kin = $this->mkinerja_pppk->get_realisasikinerja($nip, $thnperiode, $blnperiode);
          //$gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode);
 	  $abs = 100;
	  $kin = 100;
	  $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode_gaji); // Gunakan Gaji bulan Mei
        }
	echo "<div class='col-md-4'>
                <blockquote  style='font-size: 10px;'>
                <span class='text text-success' ><b>SYARAT PERHITUNGAN</b></span>
                <br/>";
        echo "<div class='row'>";
        if ($haktpp == "YA") {
          echo "<div class='col-md-2'>
                  <span class='label label-success'>BERHAK TPP
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-2'>
                  <span class='label label-danger'>BERHAK TPP
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>";
	
	echo "<div class='row'>";
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

        if ($kin != NULL) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>NILAI KINERJA
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>NILAI KINERJA
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>";

	echo "<div class='row'>";
        if ($gaji) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>GAJI
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
          echo "<div class='col-md-6'>
                  <span class='label label-danger'>GAJI
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }

        if ($jnsptkp) {
          echo "<div class='col-md-6'>
                  <span class='label label-success'>JNS PTKP
                    <span class='glyphicon glyphicon-ok'></span>
                  </span>
                </div>";
        } else {
	  echo "<div class='col-md-6'>
                  <span class='label label-danger'>JNS PTKP
                    <span class='glyphicon glyphicon-remove'></span>
                  </span>
                </div>";
        }
        echo "</div>";
        echo "</blockquote>";
        echo "</div>"; // End Kolom
        echo "</div>"; // End ROW IDENTITAS

	if ($haktpp AND ($abs != NULL) AND ($kin != NULL) AND $gaji AND $jnsptkp) {
          // Jika Absensi NOL (TK sebulanan), maka Kinerja juga 0
          //if ($abs == 0) $kin = 0;

          // khusus Nakes,cek ada tidak nilai di field jml_aktifitas_nakes
          $kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
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

          $pabs = 0.4 * $abs; // persentase absensi (40%)	
	  
          echo "<div class='row'>";
          if ($pengurang != "mkd7h") { // Masuk kerja kurang dari 7 hari
            $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)
            echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-primary'><b>PRODUKTIFITAS KERJA</b></span>
                    <br/>Nilai Kinerja : ".$kin."
                    <br/>Capaian : ".$ckin." (".$kkin.")
                    <br/>Persentase : ".$pkin."
                  ";
	   } else if ($pengurang == "mkd7h") {
            $pkin = 0.4 * $kin; // Hitung 40% dari pembulatan realisasi kinerja
            echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-primary'><b>PRODUKTIFITAS KERJA</b></span>
                    <br/>Nilai SKP : ".$kin."
                    <br/>Capaian : ".$ckin." (".$kkin.")
                    <br/>Persentase : ".$pkin."<br/><span class='text text-warning'>(Masuk Kerja kurang dari 7 Hari)</span>
                  ";
          }
	  
          echo "<br/><br/>
                  <span class='text text-danger'><b>DISIPLIN KERJA</b></span>
                    <br/>Nilai Absensi : ".$abs."
                    <br/>Persentase : ".$pabs."
                  </blockquote>
                </div>";

          $realisasi = $pkin + $pabs;
          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-success'><b>PERSENTASE KINERJA</b></span>
                    <h5>".$realisasi."</h5>
                  </blockquote>
                </div>";

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
            $rea_pk = (($realisasi * $tpp_pk) / 100) * 0.5;
            $rea_bk = (($realisasi * $tpp_bk) / 100) * 0.5;
            $rea_kk = (($realisasi * $tpp_kk) / 100) * 0.5;
            $rea_kp = (($realisasi * $tpp_kp) / 100) * 0.5;
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
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-primary'><b>KALKULASI TPP (".$ket.")</b></span>
                            <div class='row'>
                      <div class='col-md-5'><b>KRITERIA</b></div>
                      <div class='col-md-4' align='right'><b>BASIC</b></div>
                      <div class='col-md-3' align='right'><b>REALISASI</b></div>
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
                  </blockquote>
                </div>";

          echo "</div>"; // end ROW KEDUA

	  // Gunakan Gaji bulan Mei
	  if ($jnsasn == "PNS") {
            $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
            $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode_gaji);
            $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode_gaji);
            $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode_gaji);
            $bpjs_gaji = $this->mtppng->get_bpjsgaji($nip, $thnperiode, $blnperiode_gaji);
          } else if ($jnsasn == "PPPK") {
            $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
            $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode_gaji);
            $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode_gaji);
            $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode_gaji);
            $bpjs_gaji = $this->mtppng->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode_gaji);
          }

          $hasil_bruto = $gaji_bruto + $rea_bruto;
          $biaya_jab = $hasil_bruto * 0.05;
          if ($biaya_jab > 500000) {
            $biaya_jab = 500000;
          }

	   if ($jnsasn == "PNS") {
                //$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
		$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode_gaji, $rea_bruto);
          } else if ($jnsasn == "PPPK") {
                $pph_bayar = $this->hitungpph_pppk($nip, $thnperiode, $blnperiode, $rea_bruto);
		$pph_bayar = $this->hitungpph_pppk($nip, $thnperiode, $blnperiode_gaji, $rea_bruto);
          }

	   echo "<div class='row'>";
          echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                    <span class='text text-primary'><b>PPh 21 Non Final</b></span>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Gaji Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($gaji_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>TPP Bruto</div>
                      <div class='col-md-6' align='right'>".number_format($rea_bruto,2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>Pot. Gaji</div>
                      <div class='col-md-6' align='right'>(".number_format($pot_gaji,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'>PPh 21 Gaji</div>
                      <div class='col-md-6' align='right'>(".number_format($pph_gaji,2,',','.').")</div>
                    </div>
		    <div class='row'>
                      <div class='col-md-6'>Biaya Jab</div>
                      <div class='col-md-6' align='right'>(".number_format($biaya_jab,2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><span class='text-success'><b>Pot. PPh 21</b></span></div>
                      <div class='col-md-6' align='right'><span class='text-success'><b>".number_format($pph_bayar,2,',','.')."</b></span></div>
                    </div>
                  </blockquote>
                </div>";

          // IWP 1%
	  $iwp_terhutang = 0;
          // End IWP 1%

          // BPJS 4%
	  $bpjs_terhutang = 0;
          //End BPJS 4%

	  echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                    <span class='text text-primary'><b>IWP 1%</b></span>
                    <div class='row'>
                      <div class='col-md-12'><span class='text text-muted'>TANPA POTONGAN</span></div>
                    </div>
                  </blockquote>
                </div>";

	    echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                    <span class='text text-primary'><b>BPJS 4%</b></span>
		    <div class='row'>
                      <div class='col-md-12'><span class='text text-muted'>TANPA POTONGAN</span></div>
                    </div>
                  </blockquote>
                </div>";

	    $thp = round($rea_bruto) + round($bpjs_terhutang) - (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
	    echo "<div class='col-md-3'>
                  <blockquote style='font-size: 10px;'>
                  <span class='text text-danger'><b>TAKE HOME PAY</b></span><br/>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Real. TPP</div>
                      <div class='col-md-6' align='right'>".number_format(round($rea_bruto),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Tunj. BPJS</div>
                      <div class='col-md-6' align='right'>".number_format(round($bpjs_terhutang),2,',','.')."</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Pot. PPh 21</div>
                      <div class='col-md-6' align='right'>(".number_format(round($pph_bayar),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Pot IWP</div>
                      <div class='col-md-6' align='right'>(".number_format(round($iwp_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6' align='left'>Pot BPJS</div>
                      <div class='col-md-6' align='right'>(".number_format(round($bpjs_terhutang),2,',','.').")</div>
                    </div>
                    <div class='row'>
                      <div class='col-md-6'><b><span class='text text-danger'>TPP NETO</span></b></div>
                      <div class='col-md-6' align='right'>
                          <b><span class='text text-danger'>".number_format(round($thp,0),2,',','.')."</span></b>
                        </div>
                    </div>
		   </div>";

	    echo "</div>"; // End ROW KETIGA
          echo "<div class='row'>";
          echo "<div class='col-md-10'>
                  <textarea class='form-control' rows='2' id='catatan' name='catatan' placeholder='Silahkan tulis catatan terkait kalkulasi TPP disini' value=''>TPP KE-13 TAHUN 2023</textarea>
                </div>
                <div class='col-md-2'>
                  <button type='submit' class='btn btn-success btn-outline btn-sm' onclick='' >
                          <span class='glyphicon glyphicon-save' aria-hidden='true'></span><br/>SIMPAN
                        </button>
                </div>";
          echo "</div>"; // End ROW THP

        } else {
        echo "<div align='center' class='text text-warning'>TIDAK DAPAT DILANJUTKAN, SYARAT PERHITUNGAN TIDAK LENGKAP</div>";
      }
    } // End Cek NIP
  } 	 		 

  function tmbkalkthr_aksi() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idperiode = addslashes($this->input->post('idperiode'));
    $nip = addslashes($this->input->post('nip'));
    $idjabpeta = addslashes($this->input->post('idjabpeta'));
    $jabatan = $this->mpetajab->get_namajab($idjabpeta);

    $jnsasn = $this->mtppng->get_jnsasn($idpengantar);
    if ($jnsasn == "PNS") {
      $statpeg = $this->mpegawai->getstatpeg($nip);
      $idgolru = $this->mpetajab->getidgolru($nip);
      $golru = $this->mpegawai->getnamagolru($idgolru);
      $pangkat = $this->mpegawai->getnamapangkat($idgolru);
      $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);
      $npwp = $this->mkinerja->get_npwp($nip);
      //$jnsptkp = $this->mkinerja->get_jnsptkp($nip);
      $jnsptkp = $this->mtppng->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga
    } else if ($jnsasn == "PPPK") {
      $statpeg = "PPPK";
      $idgolru = $this->mpppk->getidgolruterakhir($nip);
      $golru = $this->mpppk->getnamagolru($idgolru);
      $pangkat = "";
      $tmtjab = "";
      $npwp = $this->mkinerja_pppk->get_npwp($nip);;
      $jnsptkp = $this->mkinerja_pppk->get_jnsptkp($nip);
    }

    //$idgolru = $this->mpetajab->getidgolru($nip);
    $id_unker = $this->mtppng->get_idunker($idpengantar);
    $idjabpltpeta = addslashes($this->input->post('idjabpltpeta'));
    $jabatanplt = $this->mpetajab->get_namajab($idjabpltpeta);
    $jnsplt = addslashes($this->input->post('jnsplt'));
    //$pengurang = addslashes($this->input->post('pengurang'));
    $pengurang = '';

    $blnperiode = $this->mtppng->get_bulanperiode($idperiode);
    $blnperiode_gaji = '5';
    $thnperiode = $this->mtppng->get_tahunperiode($idperiode);
  

    //$statpeg = $this->mpegawai->getstatpeg($nip);

    if ($jnsasn == "PNS") {
      $haktpp = $this->mkinerja->get_haktpp($nip);
      //$abs = $this->mkinerja->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      // cek nakes atau tidak
      //$kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
      //if ($kinnakes != 0) {
      //   $kin = $kinnakes; // isinya jml aktifitas nakes
      //} else {
      //   $kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      //}

      //$kin = $this->mkinerja->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      $gaji = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode_gaji); // Gunakan Gaji bulan Mei
      $kin = 100;
      $abs = 100;	
      //$bpjs_gaji = $this->mtppng->get_bpjsgaji($nip, $thnperiode, $blnperiode);
    } if ($jnsasn == "PPPK") {
      $haktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);;
      //$abs = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thnperiode, $blnperiode);
      //$kin = $this->mkinerja_pppk->get_realisasikinerja($nip, $thnperiode, $blnperiode);
      $gaji = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode_gaji); // Gunakan Gaji bulan Mei
      $kin = 100;
      $abs = 100; 	
      //$bpjs_gaji = $this->mtppng->get_bpjsgaji_pppk($nip, $thnperiode, $blnperiode);
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
    //if ($abs == 0) $kin = 0;

    // khusus Nakes,cek ada tidak nilai di field jml_aktifitas_nakes
    $kinnakes = $this->mkinerja->get_realisasikinerja_nakes($nip, $thnperiode, $blnperiode);
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

     $pkin = 0.6 * $ckin; // persentase capaian kinerja (60%)

    if ($pengurang != "mkd7h") {
            $pkin = 0.6 * $ckin;
    } else if ($pengurang == "mkd7h") {
            $pkin = 0.4 * $kin;
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
      $rea_pk = (($realisasi * $tpp_pk) / 100) * 0.5;
      $rea_bk = (($realisasi * $tpp_bk) / 100) * 0.5;
      $rea_kk = (($realisasi * $tpp_kk) / 100) * 0.5;
      $rea_kp = (($realisasi * $tpp_kp) / 100) * 0.5;
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
      $gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
      $pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode_gaji);
      $pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode_gaji);
      $iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode_gaji);
    } else if ($jnsasn == "PPPK") {
      $gaji_bruto = $this->mkinerja_pppk->get_gajibruto($nip, $thnperiode, $blnperiode_gaji);
      $pot_gaji = $this->mkinerja_pppk->get_jmlpotongan($nip, $thnperiode, $blnperiode_gaji);
      $pph_gaji = $this->mkinerja_pppk->get_pphgaji($nip, $thnperiode, $blnperiode_gaji);
      $iwp_gaji = $this->mkinerja_pppk->get_iwpgaji($nip, $thnperiode, $blnperiode_gaji);
    }

    //$gaji_bruto = $this->mkinerja->get_gajibruto($nip, $thnperiode, $blnperiode);
    //$pot_gaji = $this->mkinerja->get_jmlpotongan($nip, $thnperiode, $blnperiode);
    //$pph_gaji = $this->mkinerja->get_pphgaji($nip, $thnperiode, $blnperiode);
    $hasil_bruto = $gaji_bruto + $rea_bruto;
    $biaya_jab = $hasil_bruto * 0.05;
    if ($biaya_jab > 500000) {
      $biaya_jab = 500000;
    }
    //$npwp = $this->mkinerja->get_npwp($nip);
    //$jnsptkp = $this->mkinerja->get_jnsptkp($nip);

    // Hitung PPh21
    //$ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    //$pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode, $rea_bruto);
    if ($jnsasn == "PNS") {
        $ptkp = $this->mkinerja->get_ptkp($jnsptkp);
        $pph_bayar = $this->hitungpph($nip, $thnperiode, $blnperiode_gaji, $rea_bruto);
    } else if ($jnsasn == "PPPK") {
        $ptkp = $this->mkinerja_pppk->get_ptkp($jnsptkp);
        $pph_bayar = $this->hitungpph_pppk($nip, $thnperiode, $blnperiode_gaji, $rea_bruto);
    }

    //$iwp_gaji = $this->mkinerja->get_iwpgaji($nip, $thnperiode, $blnperiode);
    //$iwp_tpp = $rea_bruto * 0.01;
    //$iwp_total = $iwp_gaji + $iwp_tpp;
    //if ($iwp_total > 120000) {
    //  $iwp_terhutang = 120000-$iwp_gaji;
    //} else {
    //  $iwp_terhutang = $iwp_tpp;
    //}
    $iwp_terhutang = 0;

    // BPJS 4%
    //$bpjs_tpp = $rea_bruto * 0.04;
    //$bpjs_total = $bpjs_gaji + $bpjs_tpp;
    //if ($bpjs_total > 480000) {
    //  $bpjs_terhutang = 480000-$bpjs_gaji;
    //} else {
    //  $bpjs_terhutang = $bpjs_tpp;
    //}
    $bpjs_terhutang = 0;

    //if (($statpeg == "PNS") OR ($statpeg == "PPPK")) {
    $thp = round($rea_bruto) + round($bpjs_terhutang) - (round($pph_bayar)+round($iwp_terhutang)+round($bpjs_terhutang));
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
      'nilai_produktifitas'   => $kin,
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
      'iwp_gaji'              => 0,
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

    if ($this->mtppng->cektelahusul($nip, $thnperiode, $blnperiode) == 0) {
      if ($this->mtppng->input_tppng($data)) {
        $data['pesan'] = "<b>SUKSES</b>, THR TPP ".$nama." Tahun ".$thnperiode." BERHASIL DITAMBAH.";
        $data['jnspesan'] = "alert alert-success";
      } else {
        $data['pesan'] = "<b>GAGAL</b>, THR TPP ".$nama." Tahun ".$thnperiode." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-warning";
      }
    } else {// pernah usul
        $data['pesan'] = "<b>DATA RANGKAP</b>, THR TPP ".$nama." Tahun ".$thnperiode." GAGAL DITAMBAH.";
        $data['jnspesan'] = "alert alert-info";
    }

    $data['thn'] = $thnperiode;
    $data['bln'] = $blnperiode;

    $data['idunor'] = $id_unker;
    $data['idpengantar'] = $idpengantar;
    $data['idperiode'] = $idperiode;
    $data['data'] = $this->mtppng->tampil_tppng($idpengantar, $idperiode)->result_array();
    $data['content'] = 'tppng/detailperiodeunor';
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

    if ($this->mtppng->edit_tppngpengantar($where, $data)) {
      $data['pesan'] = '<b>SUKSES</b>, Spesimen Berhasil Disimpan';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>GAGAL</b>, Spesimen Gagal Disimpan';
      $data['jnspesan'] = 'alert alert-warning';
    }

    $data['$idpengantar'] = $idpengantar;
    $data['data'] = $this->mtppng->cetak_tandaterima($idpengantar, $idperiode)->result_array();
    $this->load->view('/tppng/cetaktandaterimathr',$data);
  }	
}
