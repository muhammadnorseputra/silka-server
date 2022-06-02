<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akunpns extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('madmin');
      $this->load->model('munker');
      $this->load->model('makunpns');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }
    }
  
	public function index()
	{	  
	}

  // TODO
  function listakun_old()
  {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') == "ADMIN") || ($this->session->userdata('level') == "USER")) { 
      $data['user'] = $this->makunpns->listakun()->result_array();
      $data['content'] = 'akunpns/listakun';
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }
  
  // TODO
  function listakun()
  {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') == "ADMIN") || ($this->session->userdata('level') == "USER")) { 
      $nipnama = mysql_real_escape_string(trim($this->input->get('nipnama')));
      if ($nipnama != '') {
      	$data['user'] = $this->makunpns->listakun_bynipnama($nipnama)->result_array();
      } 
      $data['content'] = 'akunpns/listakun';
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  // TODO
  function tambahakun() {
    $data['content'] = 'akunpns/tambahakun';

    $this->load->view('template', $data);
  }

  // TODO
  function getdataakun() {
    $nip = $this->input->get('nip');
    $ada = $this->makunpns->cek_akunada($nip);

    $nama = $this->mpegawai->getnama($nip);
    $fidunker = $this->mpegawai->getfidunker($nip);

    if ($nama) {   
      // jika data tidak ditemukan   
      if ($ada == 0) {
        $namajab = $this->mpegawai->namajabnip($nip);
        $namaunker = $this->munker->getnamaunker($fidunker);
        echo "<table class='table table-condensed'>";
        echo "<tr>";
        echo "<td rowspan='2' width='100'>";
        
        $lokasifile = './photo/';
        $filename = "$nip.jpg";

        if (file_exists ($lokasifile.$filename)) {
          $photo = "../photo/$nip.jpg";
        } else {
          $photo = "../photo/nophoto.jpg";
        }

        echo "<center><img class='img-thumbnail' src='$photo' width='90' height='120' alt='$nip.jpg'></center>";
        echo "</td>";
        echo "<td>$nama";
        echo "<br/>$namajab";
        echo "<br/>$namaunker";
        echo "</td></tr>
              <tr>
              <td align='left'>";
        echo "<button type='submit' class='btn btn-success btn-sm'>
              <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspBuat Akun
              </button>";                      
        echo "</td>
              </tr>
              </table>";
      // jika data ditemukan (akun sudah terdaftar)
      } else if ($ada == 1) {
        echo "<center><b><span style='color: #0000FF'>AKUN TELAH TERDAFTAR.</span></b></center>";
      // jika data ditemukan tapi berada diluar kewenangan user
      } else if ($ada == 2) {
        echo "<center><b><span style='color: orange'>PNS DILUAR KEWENANGAN ANDA.</span></b></center>";
      }
    } else {
        echo "<center><b><span style='color: #FF0000'>DATA TIDAK DITEMUKAN.</span></b></center>";
    }
  }

  // TODO
  function resetpassword() {
    $nip = addslashes($this->input->post('nip'));

    $data['user'] = $this->makunpns->getakun($nip)->result_array();
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['content'] = 'akunpns/resetpassword';
    $this->load->view('template', $data);
  }

  // TODO
  function gantipassword(){
    $data['content'] = 'akunpns/gantipassword';
    $this->load->view('template', $data);
  }

  // TODO
  function tambahakun_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $password = addslashes($this->input->post('password'));
    $status = addslashes($this->input->post('status'));

    $pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pass=md5($pengacak1 . md5($password));

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'nip'               => $nip,
      'password'          => $pass,
      'status'             => $status,
      'created_at '     => $tgl_aksi,
      'created_by '     => $user
      );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->makunpns->input_akun($data))
      {
        $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>BERHASIL DITAMBAH</b>.');
        redirect('akunpns/listakun');
      } else {
        $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>GAGAL DITAMBAH</b>.');
        redirect('akunpns/listakun');
      }       
  }

  // TODO
  function hapusakun_aksi(){
    $nip = addslashes($this->input->post('nip'));

    $where = array('nip' => $nip
             );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->makunpns->hapus_akun($where)) {
        $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>BERHASIL DIHAPUS</b>.');
        redirect('akunpns/listakun');
      } else {
        $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>GAGAL DIHAPUS</b>.');
        redirect('akunpns/listakun');
      }
  }

  // TODO
  function ceksamapassword() {
    $pbaru = addslashes($this->input->get('pbaru'));
    $pbarulagi = addslashes($this->input->get('pbarulagi'));
    $len = strlen($pbaru);

    if (($len < 8) || ($pbaru != $pbarulagi)) {
      echo "PASSWORD TIDAK SAMA ATAU KURANG DARI 8 KARAKTER";
    } else {
      echo "<button type='submit' class='btn btn-success btn-sm'>";
      echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspReset Password";
      echo "</button>";
    }
  }

  // TODO
  function prosesresetpassword() {
    $nip = addslashes($this->input->post('nip'));
    $pwdbaru = addslashes($this->input->post('pwdbaru'));
    $pwdbarulagi = addslashes($this->input->post('pwdbarulagi'));  

    $pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pass=md5($pengacak1 . md5($pwdbaru));

    $data = array(      
      'password' => $pass
      );

    $where = array(
      'nip'      => $nip
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->makunpns->edit_akun($where, $data))
    {
      $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Password <u>'.$nama.' (NIP. '.$nip.')</u> <b>BERHASIL DIRESET</b>.');
        redirect('akunpns/listakun');
    } else {
      $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Password <u>'.$nama.' (NIP. '.$nip.')</u> <b>GAGAL DIRESET</b>.');
        redirect('akunpns/listakun');
    }
  }

  // TODO
  function aktifkanakun() {
    $nip = addslashes($this->input->post('nip'));  

    $data = array(      
      'status' => 'AKTIF'
      );

    $where = array(
      'nip'      => $nip
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->makunpns->edit_akun($where, $data))
    {
      $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>TELAH AKTIF</b>.');
        redirect('akunpns/listakun');
    } else {
      $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>MASIH NON AKTIF</b>.');
        redirect('akunpns/listakun');
    }
  }

  // TODO
  function nonaktifkanakun() {
    $nip = addslashes($this->input->post('nip'));  

    $data = array(      
      'status' => 'NONAKTIF'
      );

    $where = array(
      'nip'      => $nip
    );

    $nama = $this->mpegawai->getnama($nip);
    if ($this->makunpns->edit_akun($where, $data))
    {
      $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>TELAH NON AKTIF</b>.');
        redirect('akunpns/listakun');
    } else {
      $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Akun <u>'.$nama.' (NIP. '.$nip.')</u> <b>MASIH AKTIF</b>.');
        redirect('akunpns/listakun');
    }
  }

  // TODO
  function cekgantipassword() {
    $nip = $this->input->get('nip');
    $plama = addslashes($this->input->get('plama'));
    $pbaru = addslashes($this->input->get('pbaru'));
    $pbarulagi = addslashes($this->input->get('pbarulagi'));

    $pengacak = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pwdlama=$this->makunpns->getpwd($nip);
    $passlama=md5($pengacak.md5($plama));

    $len = strlen($pbaru);

      if ($passlama != $pwdlama) {
        echo "PASSWORD LAMA SALAH";
      } else if ($pbaru != $pbarulagi) {
        echo "PASSWORD BARU TIDAK SAMA";
      } else if (($passlama == $pwdlama) AND ($len < 8)) {
        echo "PASSWORD BARU KOSONG ATAU KURANG DARI 8 KARAKTER";
      } else if (($passlama == $pwdlama) AND ($pbaru == $pbarulagi) AND ($len >= 8)) {
        echo "<button type='submit' class='btn btn-success btn-sm'>";
        echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspGanti Password";
        echo "</button>";
      }
  }

  // TODO
  function prosesgantipassword() {
    $nip = $this->session->userdata('nip');
    $pwdlama = addslashes($this->input->post('pwdlama'));
    $pwdbaru = addslashes($this->input->post('pwdbaru'));
    $pwdbarulagi = addslashes($this->input->post('pwdbarulagi'));  

    $pengacak = "da1243ty";
    $pass=md5($pengacak.md5($pwdbaru));
    $passlama=md5($pengacak.md5($pwdlama));

    $data = array(      
      'password' => $pass
      );

    $where = array(
      'nip'      => $nip,
      'password' => $passlama
    );

    if ($this->makunpns->edit_akun($where, $data))
    {
      $this->session->set_flashdata('pesan', '<center><b>SILAHKAN LOGIN KEMBALI MENGGUNAKAN PASSWORD BARU</b><br />PASSSWORD ANDA TELAH DIGANTI.</center>');
      redirect('login');
    } else {
      $this->session->set_flashdata('pesan', '<b>GAGAL</b>, PASSWORD GAGAL DIGANTI.');
      redirect('login');
    }
  }
}

/* End of file Akunpns.php */
/* Location: ./application/controllers/Akunpns.php */
