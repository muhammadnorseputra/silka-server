<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {
  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {            
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('Mlogin');
  }

	public function index()
	{
	  $d['title'] = 'SILKa Online BKD Kabupaten Balangan';
    	$d['judul'] = 'Login SILKa Online';
    	$this->load->view('home', $d);
	}

  function gantipassword(){
    //$data['nip'] = $this->session->userdata('nip');
    //$data['nama'] = $this->mlogin->getnamauser($data['nip']);
    $data['content'] = 'gantipassword';
    $this->load->view('template', $data);
  }

  function cekgantipassword() {
    $nip = $this->input->get('nip');
    $plama = addslashes($this->input->get('plama'));
    $pbaru = addslashes($this->input->get('pbaru'));
    $pbarulagi = addslashes($this->input->get('pbarulagi'));

    $pengacak = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pwdlama=$this->mlogin->getpwd($nip);
    $passlama=md5($pengacak.md5($plama));

    if ($passlama != $pwdlama) {
      echo "Password lama salah";
    } else if ($pbaru != $pbarulagi) {
      echo "Password baru tidak sama";
    } else if (($passlama == $pwdlama) AND ($pbaru == '')) {
      echo "";
    } else if (($passlama == $pwdlama) AND ($pbaru == $pbarulagi)) {
      echo "<button type='submit' class='btn btn-success btn-sm'>";
      echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspProses";
      echo "</button>";
    }
  }

  function prosesgantipassword() {
    $nip = $this->session->userdata('nip');
    $nama = $this->session->userdata('nama');
    $pwdlama = addslashes($this->input->post('pwdlama'));
    $pwdbaru = addslashes($this->input->post('pwdbaru'));
    $pwdbarulagi = addslashes($this->input->post('pwdbarulagi'));  

    $pengacak = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pass=md5($pengacak.md5($pwdbaru));
    $passlama=md5($pengacak.md5($pwdlama));

    $data = array(      
      'password' => $pass
      );

    $where = array(
      'nip'      => $nip,
      'username'     => $nama,
      'password' => $passlama
    );

    if ($this->mlogin->edit_user($where, $data))
    {
      $this->session->set_flashdata('pesan', '<b>Silahkan login kembali</b>, Password anda berhasil diganti.');
      redirect('login');
    } else {
      $this->session->set_flashdata('pesan', '<b>Gagal</b>, Password gagal diganti.');
      redirect('login');
    }
  }

  function masuk()
  {
    $username = $this->input->post('username');
    $nip = $this->mlogin->getnipuser($username);
    $password = $this->input->post('password');

    //model mlogin telah diload pada file config/autoload.php
    $cek = $this->mlogin->cek($nip, $username, $password);

    if($cek->num_rows() == 1)
    {
      foreach($cek->result() as $data)
      {
        // simpan isi field pada tabel use_portal ke dalam session
        $sess_data['nip'] = $data->nip;
        $sess_data['nama'] = $data->username;
        $sess_data['level'] = $data->level;
        $sess_data['profil_priv'] = $data->profil;
        $sess_data['cetak_profil_priv'] = $data->cetak_profil;
        $sess_data['nominatif_priv'] = $data->nominatif;
        $sess_data['cetak_nominatif_priv'] = $data->cetak_nominatif;
        $sess_data['statistik_priv'] = $data->statistik;
        $sess_data['cetak_statistik_priv'] = $data->cetak_statistik;
        $sess_data['sotk_priv'] = $data->sotk;
        $sess_data['cetak_sotk_priv'] = $data->cetak_sotk;
        $sess_data['usulcuti_priv'] = $data->usulcuti;
        $sess_data['prosescuti_priv'] = $data->prosescuti;
        $this->session->set_userdata($sess_data);
      }
      // masuk halaman login
      redirect('home');
    }
    else
    {
      $this->session->set_flashdata('pesan', 'Maaf, username dan password salah');
      redirect('login');
    }
  }

  function keluar()
  {
    $this->session->sess_destroy();
    redirect('login');
  }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
