
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {
  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {            
      
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('mlogin');
     $this->load->helper('fungsipegawai');
    $this->load->model('mpegawai');	    

    $this->load->library('form_validation');
    

    //if (!$this->session->sess_read()) {
	//redirect('home');
    //}	
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

    if ($this->mlogin->edit_userportal($where, $data))
    {
      $this->session->set_flashdata('pesan', '<center><b>Silahkan login kembali</b><br />Password anda berhasil diganti.</center>');
      redirect('login');
    } else {
      $this->session->set_flashdata('pesan', '<b>Gagal</b>, Password gagal diganti.');
      redirect('login');
    }
  }

  // Fungsi Masuk baru setelah setiap PNS diizinkan login
  function masuk()
  {    
    //$username = mysql_real_escape_string(trim($this->input->post('username')));
    //$password = mysql_real_escape_string(trim($this->input->post('password')));
    $username = trim($this->input->post('username'));
    $password = trim($this->input->post('password'));
    if ($this->input->post('intbkn') == 'YA') { 
    	$intbkn = $this->input->post('intbkn');
    } else {
	$intbkn = "TIDAK";
    }
    var_dump($intbkn);

    $cekuser_pns = $this->mlogin->cekuser_pns($username);
    // Jika login menggunakan NIP berarti PNS
    if ($cekuser_pns) {
      $nama = $this->mpegawai->getnama($username);
      $ceklogin_pns = $this->mlogin->ceklogin_pns($username, $password);
      
      if($ceklogin_pns->num_rows() == 1)
      {
	if ($username == $password) {
          $this->session->set_flashdata('pesan', 'Password tidak boleh sama dengan NIP');
          redirect('login');  
        } else {
          foreach($ceklogin_pns->result() as $data)
          {
            $sess_data['nip'] = $username;
            $sess_data['nama'] = $nama;
            $sess_data['level'] = "PNS";
            $sess_data['profil_priv'] = "Y";
            $sess_data['edit_profil_priv'] = "Y";
            $sess_data['cetak_profil_priv'] = "Y";
            $this->session->set_userdata($sess_data);

            //$last_login = $this->mlogin->datetime_saatini();
	    $last_login = date('Y-m-d h:i:s');          
         
	    $data = array(      
              'last_login' => $last_login
            );

            $where = array(
              'nip'      => $nip
            );

            // update status user ONLINE
            $this->mlogin->edit_userportal_pns($where, $data);
          } // end foreach
          // masuk halaman login
          redirect('home');
        }
      }
      else
      {
        $this->session->set_flashdata('pesan', 'PNS tidak terdaftar atau akun Non Aktif');
        redirect('login');
      }
    } else {
      $nip = $this->mlogin->getnipuser($username);

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
          $sess_data['edit_profil_priv'] = $data->edit_profil;
          $sess_data['cetak_profil_priv'] = $data->cetak_profil;
          $sess_data['nominatif_priv'] = $data->nominatif;
          $sess_data['cetak_nominatif_priv'] = $data->cetak_nominatif;
          $sess_data['statistik_priv'] = $data->statistik;
          $sess_data['cetak_statistik_priv'] = $data->cetak_statistik;
          $sess_data['sotk_priv'] = $data->sotk;
          $sess_data['cetak_sotk_priv'] = $data->cetak_sotk;
          $sess_data['usulcuti_priv'] = $data->usulcuti;
          $sess_data['prosescuti_priv'] = $data->prosescuti;
          $sess_data['usulkgb_priv'] = $data->usulkgb;
          $sess_data['proseskgb_priv'] = $data->proseskgb;
          $sess_data['nonpns_priv'] = $data->nonpns;          
          $sess_data['akunpns_priv'] = $data->akunpns;
	  $sess_data['tpp_priv'] = $data->tpp;
	  $sess_data['intbkn_priv'] = $intbkn;
          $this->session->set_userdata($sess_data);

          $last_login = $this->mlogin->datetime_saatini();

          $data = array(      
            'status' => 'ONLINE',
            'last_login' => $last_login
          );

          $where = array(
            'nip'      => $nip,
            'username' => $username
          );

          // update status user ONLINE
          $this->mlogin->edit_userportal($where, $data);

        }
        // masuk halaman login
        redirect('home');
      }
      else
      {
        $this->session->set_flashdata('pesan', 'Username dan password salah');
        redirect('login');
      }
    }
  }

  /*
  // fungsi masuk lama sebelum masing2 PNS diizinkan Login
  function masuk()
  {
    $username = mysql_real_escape_string(trim($this->input->post('username')));
    $nip = $this->mlogin->getnipuser($username);
    $password = mysql_real_escape_string(trim($this->input->post('password')));
    if ($this->input->post('intbkn') == 'YA') {
        $intbkn = $this->input->post('intbkn');
    } else {
        $intbkn = "TIDAK";
    }

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
        $sess_data['edit_profil_priv'] = $data->edit_profil;
        $sess_data['cetak_profil_priv'] = $data->cetak_profil;
        $sess_data['nominatif_priv'] = $data->nominatif;
        $sess_data['cetak_nominatif_priv'] = $data->cetak_nominatif;
        $sess_data['statistik_priv'] = $data->statistik;
        $sess_data['cetak_statistik_priv'] = $data->cetak_statistik;
        $sess_data['sotk_priv'] = $data->sotk;
        $sess_data['cetak_sotk_priv'] = $data->cetak_sotk;
        $sess_data['usulcuti_priv'] = $data->usulcuti;
        $sess_data['prosescuti_priv'] = $data->prosescuti;
        $sess_data['usulkgb_priv'] = $data->usulkgb;
        $sess_data['proseskgb_priv'] = $data->proseskgb;
        $sess_data['nonpns_priv'] = $data->nonpns; 	          
        $sess_data['akunpns_priv'] = $data->akunpns;
	$sess_data['tpp_priv'] = $data->tpp;
        $sess_data['intbkn_priv'] = $intbkn;
        $this->session->set_userdata($sess_data);

        $last_login = $this->mlogin->datetime_saatini();

        $data = array(      
          'status' => 'ONLINE',
          'last_login' => $last_login
        );

        $where = array(
          'nip'      => $nip,
          'username' => $username
        );

        // update status user ONLINE
        $this->mlogin->edit_userportal($where, $data);

      }
      // masuk halaman login
      redirect('home');
    }
    else
    {
      $this->session->set_flashdata('pesan', 'Username dan password salah');
      redirect('login');
    }
  }
  */	


  /* LOGIN TAMU TIDAK DIPERBOLEHKAN
  function logintamu()
  {
    $username = 'tamu';
    $nip = $this->mlogin->getnipuser($username);
    $password = 'tamu';

    //model mlogin telah diload pada file config/autoload.php
    $cek = $this->mlogin->cek($nip, $username, $password);

    if($cek->num_rows() == 1)
    {
      foreach($cek->result() as $data)
      {
        // simpan isi  session
        $sess_data['nip'] = $data->nip;
        $sess_data['nama'] = $data->username;
        $sess_data['level'] = $data->level;
        $sess_data['profil_priv'] = $data->profil;
        //$sess_data['edit_profil_priv'] = $data->edit_profil;
        //$sess_data['cetak_profil_priv'] = $data->cetak_profil;
        //$sess_data['nominatif_priv'] = $data->nominatif;
        //$sess_data['cetak_nominatif_priv'] = $data->cetak_nominatif;
        //$sess_data['statistik_priv'] = $data->statistik;
        //$sess_data['cetak_statistik_priv'] = $data->cetak_statistik;
        //$sess_data['sotk_priv'] = $data->sotk;
        //$sess_data['cetak_sotk_priv'] = $data->cetak_sotk;
        //$sess_data['usulcuti_priv'] = $data->usulcuti;
        //$sess_data['prosescuti_priv'] = $data->prosescuti;
        //$sess_data['usulkgb_priv'] = $data->usulkgb;
        //$sess_data['proseskgb_priv'] = $data->proseskgb;
        $this->session->set_userdata($sess_data);
        
        $last_login = $this->mlogin->datetime_saatini();

        $data = array(      
          'status' => 'ONLINE',
          'last_login' => $last_login
        );

        $where = array(
          'nip'      => $nip,
          'username' => $username
        );

        // update status user ONLINE
        $this->mlogin->edit_userportal($where, $data);

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
  */
  

  function keluar()
  {
    $nip = $this->session->userdata('nip');
    $username = $this->session->userdata('nama');

    $data = array(      
      'status' => 'OFFLINE'
    );

    $where = array(
      'nip'      => $nip,
      'username' => $username
    );

    // update status user OFFLINE
    $this->mlogin->edit_userportal($where, $data);

    $this->session->sess_destroy();
    redirect('login');
  }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
