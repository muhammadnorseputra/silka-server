<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pip extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->helper('fungsiftp');       
      $this->load->model('munker');
      $this->load->model('mhukdis');      
      $this->load->model('mpip');
      $this->load->model('datacetak');     
      $this->load->model('mgraph');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // Load Class fpdf
      $this->load->library('fpdf');

    }

  public function index()
	{	  
	}

  function tampilukur()
  {    
    $nip = $this->input->post('nip');
    $data['nip'] = $nip;
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
    $data['content'] = 'pip/ukurtahun';
    $this->load->view('template', $data);
  }

  function ukurtahun_simpan() {
    $nip = addslashes($this->input->post('nip'));
    $thn = addslashes($this->input->post('thn'));
    
    $tingpen = addslashes($this->input->post('tingpen'));
    $skorkua = addslashes($this->input->post('skorkua'));
    
    $diks = addslashes($this->input->post('diks'));
    $dikf = addslashes($this->input->post('dikf'));
    $diktek = addslashes($this->input->post('diktek'));   
    $seminar = addslashes($this->input->post('seminar')); 
    $skorkompetensi = addslashes($this->input->post('skorkompetensi'));

    $nilaikin = addslashes($this->input->post('nilaikin'));
    $skorkin = addslashes($this->input->post('skorkin'));

    $rwyhukdis = addslashes($this->input->post('rwyhukdis'));
    $skordis = addslashes($this->input->post('skordis'));

    $nilaiip = addslashes($this->input->post('nilaiip'));
    $katip = $this->mpip->getkategoriip($nilaiip);

    $idgolru = $this->mhukdis->getidgolruterakhir($nip);
    $nmgolru = $this->mpegawai->getnamapangkat($idgolru).' ('.$this->mpegawai->getnamagolru($idgolru).')';
    $jenkel = $this->mpegawai->getjnskel($nip);
    $jnsjab = $this->mpip->getnamajnsjab($nip);

    $jabatan = $this->mpegawai->namajabnip($nip);
    $unker = $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(      
      'nip'                   => $nip,
      'tahun'                 => $thn,
      'golru'                 => $nmgolru,
      'jns_kelamin'                 => $jenkel,
      'jns_jabatan'                 => $jnsjab,
      'jabatan'                 => $jabatan,
      'unit_kerja'                 => $unker,
      'tingkat_pendidikan'                 => $tingpen,
      'diklat_pim'                 => $diks,
      'diklat_fung'                 => $dikf,
      'diklat_teknis'                 => $diktek,
      'seminar'                 => $seminar,
      'nilai_kinerja'                 => $nilaikin,
      'riwayat_disiplin'                 => $rwyhukdis,
      'skor_kualifikasi'                 => $skorkua,
      'skor_kompetensi'                 => $skorkompetensi,
      'skor_kinerja'                 => $skorkin,
      'skor_disiplin'                 => $skordis,
      'nilai_pip'                 => $nilaiip,
      'kategori_pip'                 => $katip,
      'created_by'                 => $user,
      'created_at'                 => $tgl_aksi
      );

    $where = array(      
      'nip'                   => $nip,
      'tahun'                 => $thn
    );

    $nama = $this->mpegawai->getnama($nip);
    $jmlpipa = $this->mpip->getjmlpip($nip, $thn);
    
    if ($jmlpipa == 1) {
      $this->mpip->hapus_pip($where);        
      if ($this->mpip->input_ipasn($data))   
      {
              // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Data Indeks Profesional PNS A.n. <u>'.$nama.'</u> Tahun '.$thn.' berhasil diupdate.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Data Indeks Profesional PNS A.n. <u>'.$nama.'</u> Tahun '.$thn.' gagal diupdate.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }
    } else {
      if ($this->mpip->input_ipasn($data))   
      {
              // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Data Indeks Profesional PNS A.n. <u>'.$nama.'</u> Tahun '.$thn.' berhasil disimpan.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Data Indeks Profesional PNS A.n. <u>'.$nama.'</u> Tahun '.$thn.' gagal disimpan.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }
    }
    
    $data['rwy'] = $this->mpegawai->rwypip($nip);
    $data['content'] = 'pip/tampilukurtahun';
    $data['nip'] = $nip;
    $this->load->view('template', $data);
  }

  function tampilhasilukur()
  { 
    $nip = $this->input->post('nip');
    $data['rwy'] = $this->mpegawai->rwypip($nip);
    $data['content'] = 'pip/tampilukurtahun';
    $data['nip'] = $nip;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $this->load->view('template', $data);
  }

  function hitungulang()
  {    
    $nip = $this->input->get('nip');
    ?>
      <center>
        <div class="panel panel-default" style="width:95%;height:100%;border:0px solid white">
          <div class="panel-body">
            <div class="panel panel-success" style="padding:10px;overflow:auto;width:100%;height:400px;">
                            
              <div style="width:90%; color: red;" align="justify">
                <small>
                  Pengukuran Indeks Profesionalitas adalah suatu instrumen yang digunakan untuk mengukur secara kuantitatif tingkat profesionalitas pegawai ASN yang hasilnya dapat digunakan sebagai dasar penilaian dan evaluasi dalam upaya pengembangan profesionalisme ASN. Berdasarkan Peraturan Kepala BKN Nomor 8 Tahun 2019 tentang Pedoman Tata Cara dan Pelaksanaan Pengukuran Indeks Profesionalitas ASN, terdapat 4 indikator (dimensi) yang digunakan untuk mengukur tingkat profesionalitas seorang PNS, yaitu : 
                  <ul>
                    <li>Dimensi Kualifikasi Pendidikan (Bobot 25%)</li>
                    <li>Dimensi kompetensi meliputi riwayat pengembangan kompetensi seperti diklat, bimtek, workshop, seminar, dll (Bobot 40%)</li>
                    <li>Dimensi Kinerja meliputi Sasaran Kerja Pegawai dan Prilaku Kerja dalam 1 tahun terakhir (Bobot 30%)</li>
                    <li>Dimensi Disiplin terkait riwayat penjatuhan hukuman disiplin dalam waktu 5 tahun terakhir (Bobot 5%)</li>
                  </ul>
                </small>
              </div>


              <form method='POST' action='../pip/ukurtahun_simpan'>
                <?php
                echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip' />";
                $thn = date("Y");
                echo "<input type='hidden' name='thn' id='thn' maxlength='4' value='$thn' />";            
                ?>

                <table class="table table-condensed table-hover">        
                  <tr>
                    <td class='info' colspan='4' align='center'><h4>Pengukuran Indeks Profesionalitas Tahun <?php echo $thn; ?></h4></td>
                  </tr>
                  <tr class='success'>
                    <td align='center'><b>DIMENSI</b></td>
                    <td align='center'><b>INDIKATOR</b></td>
                    <td align='center'><b>BOBOT (%)</b></td>
                    <td align='center'><b>BOBOT SKOR</b></td>
                  </tr>
                  <tr>
                    <td class='success'><h4>KUALIFIKASI<br/>Bobot 25%</h4></td>
                    <td>
                      <?php
                      $tingpen = $this->mpip->gettingpen($nip);
                      $penlengkap = $this->mpegawai->getpendidikan($nip);

                      if ($tingpen == 'S3') {
                        $skorkua = 25;
                      } else if ($tingpen == 'S2') {
                        $skorkua = 20;
                      } else if (($tingpen == 'S1') OR ($tingpen == 'D4')) {
                        $skorkua = 15;
                      } else if ($tingpen == 'D3') {
                        $skorkua = 10;
                      } else if (($tingpen == 'D2') OR ($tingpen == 'D1') OR ($tingpen == 'SMA')) {
                        $skorkua = 5;
                      } else {
                        $skorkua = 1;
                      }
                      echo "<h5>Kualifikasi Pendidikan Terakhir : ".$tingpen."</h5>";
                      echo "Sesuai data Riwayat Pendidikan, pendidikan terakhir saat ini adalah<br/><b>".$penlengkap."</b>";
                      echo "<br/><small style='color: blue;'>Silahkan hubungi Administrator BKPPD, jika terdapat kesalahan data pendidikan.</small>";
                      ?>
                      <input type='hidden' name='tingpen' maxlength='3' size='3' value='<?php echo $tingpen; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skorkua."</h4>";
                      ?>
                    </td>
                    <td align='center' class='info'>
                      <?php
                      echo "<h4>".$skorkua."</h4>";
                      ?>
                      <input type='hidden' name='skorkua' maxlength='2' size='2' value='<?php echo $skorkua; ?>' />
                    </td>
                  </tr>
                  <tr>
                    <td class='success' rowspan='6'><h4>KOMPETENSI<br/>Bobot 40%</h4></td>
                  </tr>
                  <tr>
                    <td><h5>Diklat Kepemimpinan</h5>
                      <?php
                      //$dssingkat = $this->mpegawai->getdssingkat($nip);

                      $eselon = $this->mpip->geteselon($nip);
                      //$dikstruk = $this->mpip->getdikstruk($nip);

		      echo "Sesuai data riwayat Diklat Struktural, ";	

                      if ((($eselon == 'IV/A') OR ($eselon == 'IV/B')) AND ($this->mpip->cekdikstruk($nip, 'PIM IV') == 'PIM IV')) {
                        $skords = 15;
                        $ketdiks = "SUDAH mengikuti <b>DIKLAT IV</b>";
			$diks = "SUDAH";
                      } else if ((($eselon == 'III/A') OR ($eselon == 'III/B')) AND ($this->mpip->cekdikstruk($nip, 'PIM III') == 'PIM III')) {
                        $skords = 15;
                        $ketdiks = "SUDAH mengikuti <b>DIKLAT PIM III</b>";
			$diks = "SUDAH";
                      } else if ((($eselon == 'II/A') OR ($eselon == 'II/B')) AND ($this->mpip->cekdikstruk($nip, 'PIM II') == 'PIM II')) {
                        $skords = 15;
                        $ketdiks = "SUDAH mengikuti <b>DIKLAT PIM II</b>";
			$diks = "SUDAH";
                      } else if ((($eselon == 'JFU') OR ($eselon == 'JFT')) AND ($this->mpip->cekdikstruk($nip, 'PRAJABATAN') == 'PRAJABATAN')) {
                        $skords = 0;
                        $ketdiks = " tidak ditemukan data Diklat Struktural</b>";
                        $diks = "BELUM";
                      } else {
                        $skords = 0;  
                        $ketdiks = " tidak ditemukan data Diklat Struktural</b>";
                        $diks = "BELUM";
			}
	
		      //echo "<b>".$diks." ".$dssingkat."</b>";
		      echo "<b>".$ketdiks."</b>";
                      echo "<br/><small style='color: blue;'>Silahkan hubungi Administrator BKPPD, jika terdapat kesalahan data Diklat Kepemimpian.</small>";

                      ?>
                      <input type='hidden' name='diks' maxlength='10' size='10' value='<?php echo $diks; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skords."</h4>";
                      ?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><h5>Diklat Fungsional</h5>
                      <?php             

                      // get data "apakah ada data riwayat diklat_fungsional"
                      $dikfung = $this->mpip->getdikfung($nip);
		      // untuk JFT Kesehatan dan Pendidikan, sudah dianggap melaksanakan diklat fungsional
                      // karena sudah ada AKTA4 dan STR    
                      $jikajftnonteknis = $this->mpip->cekjikajftnonteknis($nip);
		
		      if (((($eselon == 'JFT')) AND ($dikfung >= 1))) {                       
                      //if (((($eselon == 'JFT')) AND ($dikfung >= 1)) OR ($jikajftnonteknis == 1)) {
                        $skordf = 15;
                        $dikf = "SUDAH";
                      } else {
                        $skordf = 0;
                        $dikf = "BELUM";
                      }
                      echo "Sesuai data riwayat Diklat Fungsional, ".$dikf." mengikuti <b>Diklat Fungsional</b>";
                      echo "<br/><small style='color: red;'>Silahkan lakukan updating data diklat fungsional pada menu riwayat diklat fungsional.</small>";

                      ?>
                      <input type='hidden' name='dikf' maxlength='10' size='10' value='<?php echo $dikf; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skordf."</h4>";
                      ?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><h5>Diklat Teknis 20 JP</h5>
                      <?php             

                  // get data lama_bulan/lama_hari/lama_jam riwayat diklat teknis KHUSUS NON PELAKSANA (minimal 20 JP)
                      $dikteklb_np = $this->mpip->getlamadiktek_nonpelaksana($nip, 'lama_bulan');
                      $dikteklh_np = $this->mpip->getlamadiktek_nonpelaksana($nip, 'lama_hari');
                      $dikteklj_np = $this->mpip->getlamadiktek_nonpelaksana($nip, 'lama_jam');

                  // get data lama_bulan/lama_hari/lama_jam riwayat diklat teknis KHUSUS PELAKSANA (minimal 20 JP DALAM 1 TAHUN TERAKHIR)
                      $dikteklb_p = $this->mpip->getlamadiktek_pelaksana($nip, 'lama_bulan');
                      $dikteklh_p = $this->mpip->getlamadiktek_pelaksana($nip, 'lama_hari');
                      $dikteklj_p = $this->mpip->getlamadiktek_pelaksana($nip, 'lama_jam');

                      if (($eselon == 'JFU') AND (($dikteklb_p >= 1) OR ($dikteklh_p >= 3) OR ($dikteklj_p >= 20))) {
                        $skordt = 22.5;
                        $kepdt = "SUDAH mengikuti <b>Diklat Teknis lebih dari 20 JP</b> dalam 1 tahun terakhir";
                        $diktek = "SUDAH";
                      } else if ((($eselon == 'II/A') OR ($eselon == 'II/B') OR ($eselon == 'III/A') OR ($eselon == 'III/B') OR ($eselon == 'IV/A') OR ($eselon == 'IV/B') OR ($eselon == 'JFT')) AND (($dikteklb_np >= 1) OR ($dikteklh_np >= 3) OR ($dikteklj_np >= 20))) {
                        $skordt = 15;
                        $kepdt = "SUDAH mengikuti <b>Diklat Teknis lebih dari 20 JP</b>";
                        $diktek = "SUDAH";
                      } else {
                        $skordt = 0;
                        $kepdt = "BELUM mengikuti <b>Diklat Teknis</b> atau kurang dari 20 JP</b>";
                        $diktek = "BELUM";
                      }

                      echo "Sesuai data riwayat Diklat Teknis, ".$kepdt;
                      echo "<br/><small style='color: red;'>Silahkan lakukan updating data diklat teknis pada menu riwayat diklat teknis.</small>";

                      ?>
                      <input type='hidden' name='diktek' maxlength='10' size='10' value='<?php echo $diktek; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skordt."</h4>";
                      ?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><h5>Seminar/Workshop/Sejenisnya</h5>
                      <?php             

                  // get data data workshop (DALAM 2 TAHUN TERAKHIR)
                      $ws = $this->mpip->getlamaworkshop($nip);


                      if (($eselon == 'JFU') AND ($ws >= 1)) {
                        $skorws = 17.5;
                        $seminar = "SUDAH";
                      } else if ((($eselon == 'II/A') OR ($eselon == 'II/B') OR ($eselon == 'III/A') OR ($eselon == 'III/B') OR ($eselon == 'IV/A') OR ($eselon == 'IV/B') OR ($eselon == 'JFT')) AND ($ws >= 1)) {
                        $skorws = 10;
                        $seminar = "SUDAH";
                      } else {
                        $skorws = 0;
                        $seminar = "BELUM";
                      }

                      echo "Sesuai data riwayat Seminar/Workshop/Sejenisnya, ".$seminar." mengikuti <b>Seminar/Workshop/Sejenisnya </b>dalam 2 tahun terakhir</b>";
                      echo "<br/><small style='color: red;'>Silahkan lakukan updating data Seminar/Workshop/Sejenisnya pada menu riwayat Seminar/Workshop/Sejenisnya.</small>";
                      ?>
                      <input type='hidden' name='seminar' maxlength='10' size='10' value='<?php echo $seminar; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skorws."</h4>";
                      ?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan='2' align='right'>

                    </td>
                    <td align='center' class='info'>
                      <?php
                      $skorkompetensi = $skords+$skordf+$skordt+$skorws;
                      echo "<h4>".$skorkompetensi."</h4>";
                      ?>
                      <input type='hidden' name='skorkompetensi' maxlength='2' size='2' value='<?php echo $skorkompetensi; ?>' />
                    </td>
                  </tr>
                  <tr>
                    <td class='success'><h4>KINERJA<br/>Bobot 30%</h4></td>
                    <td>
                      <?php
                  // ambil data tahun lalu
                      $thnskp = date("Y")-1;
                      $cekskp = $this->mpegawai->cekskpthn($nip, $thnskp);                       
                      $nilaikin = $this->mpip->getnilaiskpthn($nip, $thnskp);
                      $sebutannilai = $this->mpegawai->getnilaiskp($nilaikin);

                      echo "<h5>Nilai Kinerja mencakup Sasaran Kerja dan Prilaku Kerja</h5>";

                            // data riwayat SKP tahun lalu ditemukan
                      if ($cekskp >= 1) {
                        echo "Sesuai data riwayat SKP, Nilai Kinerja tahun ".$thnskp." adalah <b>".round($nilaikin,2)." (".$sebutannilai .")</b>";
                        if ($nilaikin <= 50) {
                          $skorkin = 1;
                        } else if (($nilaikin >= 51) AND ($nilaikin <= 60)) {
                          $skorkin = 5;
                        } else if (($nilaikin > 60) AND ($nilaikin <= 75)) {
                          $skorkin = 15;
                        } else if (($nilaikin > 75) AND ($nilaikin <= 90)) {
                          $skorkin = 25;
                        } else if (($nilaikin > 90) AND ($nilaikin <= 100)) {
                          $skorkin = 30;
                        } else {
                          $skorkin = 0;
                        }
                      } else { 
                        echo "Riwayat SKP Tahun ".$thnskp." tidak ditemukan";
                        $skorkin = 0;
                        $nilaikin = 0;
                      }

                      echo "<br/><small style='color: red;'>Silahkan lakukan updating nilai Kinerja pada menu riwayat SKP.</small>";
                      ?>
                      <input type='hidden' name='nilaikin' maxlength='10' size='10' value='<?php echo $nilaikin; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skorkin."</h4>";
                      ?>
                    </td>
                    <td align='center' class='info'>
                      <?php
                      echo "<h4>".$skorkin."</h4>";
                      ?>
                      <input type='hidden' name='skorkin' maxlength='2' size='2' value='<?php echo $skorkin; ?>' enabled>
                    </td>
                  </tr>

                  <tr>
                    <td class='success'><h4>DISIPLIN<br/>Bobot 5%</h4></td>
                    <td>
                      <?php               
                      $pernahringan = $this->mpip->getpernahhukdis($nip, 'RINGAN');
                      $pernahsedang = $this->mpip->getpernahhukdis($nip, 'SEDANG');
                      $pernahberat = $this->mpip->getpernahhukdis($nip, 'BERAT');

                      echo "<h5>Hukuman Disiplin yang pernah diterima dalam 5 (lima) tahun terkahir</h5>";

                      if ($pernahberat >= 1) {         
                          // pernah hukdis berat dalma 5 tahun terakhir                 
                        $kephd = "pernah dijatuhi hukuman disiplin tingkat <b>Berat</b>";
                        $skordis = 1;
                        $rwyhukdis = "BERAT";
                      } else if ($pernahsedang >= 1) {               
                        // pernah hukdis sedang dalma 5 tahun terakhir           
                        $kephd = "pernah dijatuhi hukuman disiplin tingkat <b>Sedang</b>";
                        $skordis = 2;
                        $rwyhukdis = "SEDANG";
                      } else if ($pernahringan >= 1) {
                        // pernah hukdis ringan dalma 5 tahun terakhir                          
                        $kephd = "pernah dijatuhi hukuman disiplin tingkat <b>Ringan</b>";
                        $skordis = 3;
                        $rwyhukdis = "RINGAN";
                      } else {
                        // Tidak pernah dijatuhi hukdis
                        $kephd = "tidak pernah dijatuhi hukuman disiplin";
                        $skordis = 5;
                        $rwyhukdis = "TIDAK PERNAH";
                      }

                      echo "Sesuai data riwayat Hukuman Disiplin : ".$rwyhukdis;
                      echo "<br/><small style='color: blue;'>Silahkan hubungi Administrator BKPPD, atau laporkan pelanggaran disiplin yang terjadi melalui menu SIADIS.</small>";
                      ?>
                      <input type='hidden' name='rwyhukdis' maxlength='15' size='10' value='<?php echo $rwyhukdis; ?>' />
                    </td>
                    <td align='center'>
                      <?php
                      echo "<h4>".$skordis."</h4>";
                      ?>
                    </td>
                    <td align='center' class='info'>
                      <?php
                      echo "<h4>".$skordis."</h4>";
                      ?>
                      <input type='hidden' name='skordis' maxlength='2' size='2' value='<?php echo $skordis; ?>' />
                    </td>
                  </tr>
                  <tr>
                    <td class='info' colspan='3' align='right'><h4>NILAI INDEKS PROFESIONALITAS TAHUN <?php  echo $thn; ?></h4></td>
                    <td class='info' align='center'>
                      <?php
                      $nilaiip = $skorkua+$skorkompetensi+$skorkin+$skordis;
                      $katip = $this->mpip->getkategoriip($nilaiip);
                      echo "<h4><b>".$nilaiip."</b></h4><h4>[".$katip."]</h4>";
                      ?>
                      <input type='hidden' name='nilaiip' maxlength='2' size='2' value='<?php echo $nilaiip; ?>' />
                    </td>
                  </tr>
                </table>

                <div align='right' style='margin :20px'> 
                  <button type="submit" class="btn btn-success btn-xl">
                    <h4><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</h4>
                  </button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </center>  
  <?php
  }

  function tampilunkernom()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['tahun'] = $this->mpip->gettahunpip()->result_array();
      $data['content'] = 'pip/tampilunkernom';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template',$data);
    }
  }

  function cariunkernompip() {
    $idunker = $this->input->get('idunker');
    $tahun = $this->input->get('thn');

    $sqlcari = $this->mpip->carirekapunkerpip($idunker, $tahun)->result_array();
    //$jml = count($this->mpip->jmlunkerpip($idunker, $tahun)->result_array());
    $totalpip = $this->mpip->totalpip_unkerthn($idunker, $tahun);

    $jmlpegpip = $this->mpip->jmldatapip_unkerthn($idunker, $tahun);
    if ($totalpip != 0) {
      $ip_unker = round($totalpip/$jmlpegpip, 2);
    } else {
      $ip_unker = 0;
    }

    $warnaip = $this->mpip->warnabar($ip_unker);

    ?>
    <?php
    if (($idunker != '') AND ($tahun != '')) { // Jika selectbox unit kerja dipilih
    ?>
      <br />    
      <div align='left' style='width:90%;'>
        <div class="row">
          <div class="col-lg-2 col-md-6">
            Jumlah PNS
          </div>
          <div class="col-lg-2 col-md-6">: <?php echo $this->munker->getjmlpeg($idunker)." Orang"; ?></div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-md-6">
            Jumlah yang melaksanakan PIP
          </div>
          <div class="col-md-2">: <?php echo $this->mpip->jmldatapip_unkerthn($idunker,$tahun). " Orang"; ?></div>
        </div>  

        <b>RATA-RATA NILAI INDEKS PROFESIONALITAS ASN</b>
        <div class="progress">
          <div class="<?php echo $warnaip; ?>" role="progressbar" aria-valuenow="<?php echo $ip_unker; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width :'.$ip_unker.'%; color : black'; ?>;">
            <?php echo $ip_unker." [".$this->mpip->getkategoriip($ip_unker)."]"; ?>
          </div>
        </div>

<!--
        <div class="row">
          <div class="col-lg-3">
            <?php
            $totalkua = $this->mpip->totalkua_unkerthn($idunker, $tahun);
            $kua_unker = round($totalkua/$jmlpegpip, 2);
            $warnakua = $this->mpip->warnabar($kua_unker);
            ?>
            <b>RATA-RATA SKOR KUALIFIKASI</b>
            <div class="progress" style='width:100%;'>
              <div class="<?php echo $warnakua; ?>" role="progressbar" aria-valuenow="<?php echo $ip_unker; ?>" aria-valuemin="0" aria-valuemax="25" style="<?php echo 'width :'.$kua_unker.'%; color : black'; ?>;">
                <?php echo $kua_unker; ?>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <?php
            $totalkom = $this->mpip->totalkom_unkerthn($idunker, $tahun);
            $kom_unker = round($totalkom/$jmlpegpip, 2);
            $warnakom = $this->mpip->warnabar($kom_unker);
            ?>
            <b>RATA-RATA SKOR KOMPETENSI</b>
            <div class="progress" style='width:100%;'>
              <div class="<?php echo $warnakom; ?>" role="progressbar" aria-valuenow="<?php echo $ip_unker; ?>" aria-valuemin="0" aria-valuemax="40" style="<?php echo 'width :'.$kom_unker.'%; color : black'; ?>;">
                <?php echo $kom_unker; ?>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <?php
            $totalkin = $this->mpip->totalkin_unkerthn($idunker, $tahun);
            $kin_unker = round($totalkin/$jmlpegpip, 2);
            $warnakin = $this->mpip->warnabar($kin_unker);
            ?>
            <b>RATA-RATA SKOR KINERJA</b>
            <div class="progress" style='width:100%;'>
              <div class="<?php echo $warnakin; ?>" role="progressbar" aria-valuenow="<?php echo $ip_unker; ?>" aria-valuemin="0" aria-valuemax="30" style="<?php echo 'width :'.$kin_unker.'%; color : black'; ?>;">
                <?php echo $kin_unker; ?>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <?php
            $totaldis = $this->mpip->totaldis_unkerthn($idunker, $tahun);
            $dis_unker = round($totaldis/$jmlpegpip, 2);
            $warnadis = $this->mpip->warnabar($dis_unker);
            ?>
            <b>RATA-RATA SKOR DISIPLIN</b>
            <div class="progress" style='width:100%;'>
              <div class="<?php echo $warnadis; ?>" role="progressbar" aria-valuenow="<?php echo $ip_unker; ?>" aria-valuemin="0" aria-valuemax="5" style="<?php echo 'width :'.$dis_unker.'%; color : black'; ?>;">
                <?php echo $dis_unker; ?>
              </div>
            </div>
          </div>

          </div> <!-- tutup row rata-rata -->      


      </div>   

      
      <?php 

      if ($totalpip != 0) {
        echo "<div align='right' style='width:90%;'>";
        ?>
        <form method="POST" action="../pip/cetaknomperunker" target='_blank'>                
              <input type='hidden' name='idunker' id='idunker' maxlength='18' value='<?php echo $idunker; ?>'>
              <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $tahun; ?>'>
              <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Nominatif PIP
              </button>
            </form>
        <?php
        echo "</div><br/>";

        echo "<table class='table table-condensed table-hover' style='width:90%;'>";
        echo "
        <tr class='info'>
          <td align='center' width='30' rowspan='2'><b>No</b></td>
          <td align='center' width='220' rowspan='2'><b>NIP | Nama</b></td>
          <td align='center' width='520' rowspan='2'><b>Jabatan Saat Pengukuran</b></td>
          <td align='center' width='30' rowspan='2'><b>Pendidikan</b></td>
          <td align='center' width='120' colspan='4'><b>Skor Indikator</b></td>
          <td align='center' width='120' rowspan='2'><b>Nilai Indeks Profesionalitas</b></td>
        </tr>
        <tr class='info'>        
          <td align='center' width='50'><b>Kualifikasi</b></td>
          <td align='center' width='50'><b>Kompetensi</b></td>
          <td align='center' width='50'><b>Kinerja</b></td>
          <td align='center' width='50'><b>Disiplin</b></td>
        </tr>
        ";

        $no = 1;
        foreach($sqlcari as $v):          
          echo "<tr><td align='center'>".$no."</td>";
          echo '<td>'.$v['nip']. '<br />'. namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';

          echo '<td>'.$v['jns_jabatan'].'<br/>'.$v['jabatan'].'</td>';
          echo '<td align=center>'.$v['tingkat_pendidikan'].'</td>';

          if ($v['tahun'] != null) {
            echo '<td align=center>'.$v['skor_kualifikasi'].'</td>';
            echo '<td align=center>'.$v['skor_kompetensi'].'</td>';
            echo '<td align=center>'.$v['skor_kinerja'].'</td>';
            echo '<td align=center>'.$v['skor_disiplin'].'</td>';

            $nilaiip = $v['nilai_pip'];
            if ($nilaiip <= 60) {
              $warna = 'red';
            } else if (($nilaiip >= 60.01) AND ($nilaiip <= 70)) {
              $warna = 'orange';
            } else if (($nilaiip >= 70.01) AND ($nilaiip <= 80)) {
              $warna = 'black';
            } else if (($nilaiip >= 80.01) AND ($nilaiip <= 90)) {
              $warna = 'green';
            } else if (($nilaiip >= 90.01) AND ($nilaiip <= 100)) {
              $warna = 'blue';
            }

            echo "<td align='center' style='color:$warna;'>".$v['nilai_pip']."<br/>[".$v['kategori_pip']."]</td>";
            echo "<tr/>";
          } else {
            echo "<td class='danger' colspan='5'>";
            ?>
            <form method="POST" action="../pip/tampilhasilukur" target="_blank">
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $v['nip']; ?>'>
                <button type="submit" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Lakukan Pengukuran Indeks Profesionalitas !!!
                </button>
            </form>
            <?php
            echo "<tr/>";
          }

        $no++;
        endforeach;
        echo "</table>";     
      } 
    } else {
      echo "<br/>
            <div class='alert alert-warning' role='alert' style='width:40%;'><b>PERINGATAN</b><br/>
            Silahkan pilih Unit Kerja dan tahun pengukuran Indeks Profesionalitas terlebih dahulu</div>";
    }
  }

   function tampilrekappip2019()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['content'] = 'pip/tampilrekappip2019';
      $this->load->view('template',$data);
    }
  }

  function tampilrekappip2020()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['content'] = 'pip/tampilrekappip2020';
      $this->load->view('template',$data);
    }
  }

  function tampilrekappip2021()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['content'] = 'pip/tampilrekappip2021';
      $this->load->view('template',$data);
    }
  }

  public function cetaknomperunker()  
  {
    $idunker = $this->input->post('idunker');
    $tahun = $this->input->post('tahun');
    $res['data'] = $this->datacetak->datanompipperunker($idunker, $tahun);
    $this->load->view('pip/cetaknomperunker',$res);    
  }

  public function cetakrekaptahunan()  
  {
    $tahun = $this->input->post('tahun');
    //$res['data'] = $this->datacetak->datanompipperunker($tahun);
    $res['tahun'] = $tahun;
    $this->load->view('pip/cetakrekaptahunan',$res);    
  }

  // START REVIEW IPASN DJASN BKN
  function tampilunkernom_reviewdjasn()
  //function tampilunkernom1()  
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['tgllap'] = $this->mpip->gettgl_importdjasn()->result_array();
      $data['content'] = 'pip/tampilprogresdjasn';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template',$data);
    }
  }

  function cariprogress_ipasndjasn() {
    $idunker = $this->input->get('idunker');
    $tl = $this->input->get('tl');

    $sqlcari = $this->mpip->cariprogress_ipasn2021djasn($idunker, $tl)->result_array();
    $jml = count($this->mpip->cariprogress_ipasn2021djasn($idunker, $tl)->result_array());
    $jmlpeg = $this->munker->getjmlpeg($idunker);
    $persen = round(($jml/$jmlpeg)*100, 2);

    if ($persen <= 25) {
      $color = 'progress-bar progress-bar-danger progress-bar-striped';
    } else if (($persen > 25) AND ($persen < 75)) {
      $color = 'progress-bar progress-bar-warning progress-bar-striped';
    } else if ($persen >= 75) {
      $color = 'progress-bar progress-bar-success progress-bar-striped';
    }

    ?>
    <br/>
    <div class="row" style="width: 90%">
	<?php
	$sqlrata = $this->mpip->nilairata($idunker, $tl)->result_array();
	foreach($sqlrata as $v):
		echo "<div class='col-md-2'><blockquote>
			<small class='text-success' align='left'>Jumlah Data : <b>".$v['jmldata']."</b></small>
                      </blockquote></div>";
		echo "<div class='col-md-2'><blockquote>
                        <small class='text-warning' align='left'>Kualifikasi : <b>".round($v['ratakua'],2)."</b></small>
                      </blockquote></div>";
		echo "<div class='col-md-2'><blockquote>
                        <small class='text-info' align='left'>Kompetensi : <b>".round($v['ratakomp'],2)."</b></small>
                      </blockquote></div>";
		echo "<div class='col-md-2'><blockquote>
                        <small class='text-warning' align='left'>Kinerja : <b>".round($v['ratakin'],2)."</b></small>
                      </blockquote></div>";
		echo "<div class='col-md-2'><blockquote>
                        <small class='text-danger' align='left'>Disiplin : <b>".round($v['ratadis'],2)."</b></small>
                      </blockquote></div>";
		echo "<div class='col-md-2'><blockquote>
                        <small class='text-primary' align='left'>Total : <b>".round($v['ratatotal'],2)."</b></small>
                      </blockquote></div>";
	endforeach;
	?>
    </div>

    <?php
    if ($jml != 0) {
      echo '<br/>';
      echo '<table class="table table-bordered table-hover" style="width: 70%">';
      echo "
      <tr class='info'>
        <td align='center' width='20' rowspan='2'><b>No</b></td>
        <td align='center' width='220' rowspan='2'><b>NIP | Nama</b></td>
        <td align='center' width='120' rowspan='2'><b>Jabatan</b></td>
        <td align='center' colspan='4'><b>Indek Profesionalitas 2021</b></td>
        <td align='center' width='120' rowspan='2'><b>Total Nilai</b></td>
      </tr>
      <tr class='info'>
        <td align='center' width='80'><b>Kualifikasi</b></td>
        <td align='center' width='80'><b>Kompetensi</b></td>
        <td align='center' width='80'><b>Kinerja</b></td>
        <td align='center' width='80'><b>Disiplin</b></td>
      </tr>";
     $no = 1;
      foreach($sqlcari as $v):
        echo "<tr><td align='center'>".$no."</td>";
        echo '<td>NIP. ',$v['nippeg'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';
	if ($v['total']) {
	  echo '<td>',$v['jabatan'],'</td>';
          echo "<td align='center'><h4>",$v['kualifikasi'],'</h4></td>';
          echo "<td align='center'><h4>",$v['kompetensi'],'</h4></td>';
          echo "<td align='center'><h4>",$v['kinerja'],'</h4></td>';
          echo "<td align='center'><h4>",$v['disiplin'],'</h4></td>';
          echo "<td align='center'><h4>",$v['total'],'</h4></td>';
	} else {
	  echo "<td colspan='6' align='center'><b><h5 class='text-primary'>Data Tidak Ditemukan</h5></b></td>";
	}
        echo "<tr/>";
        $no++;
      endforeach;
      echo "</table>";
    }
  }


  // END REVIEW IPASN DJASN BKN
}

/* End of file Pip.php */
/* Location: ./application/controllers/Pip.php */
