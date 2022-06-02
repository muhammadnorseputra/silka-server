<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('file');	
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('madmin');
      $this->load->model('munker');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }
    }
  
	public function index()
	{	  
	}

  function listuser()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('level') == "ADMIN") { 
      $data['user'] = $this->madmin->listuser()->result_array();
      $data['content'] = 'admin/listuser';
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function tambahuser() {
    $data['content'] = 'admin/tambahuser';

    $this->load->view('template', $data);
  }

  function getdatauser() {
    $nip = $this->input->get('nip');
    $ada = $this->madmin->cek_userada($nip);

    $nama = $this->mpegawai->getnama($nip);
    $fidunker = $this->mpegawai->getfidunker($nip);

    if ($nama) {      
      if ($ada) {
        $namajab = $this->mpegawai->namajabnip($nip);
        $namaunker = $this->munker->getnamaunker($fidunker);
        echo "<table class='table table-condensed'>";
        echo "<tr>";
        echo "<td rowspan='3' width='100'>";
        
        $lokasifile = './photo/';
        $filename = "$nip.jpg";

        if (file_exists ($lokasifile.$filename)) {
          $photo = "../photo/$nip.jpg";
        } else {
          $photo = "../photo/nophoto.jpg";
        }

        echo "<center><img class='img-thumbnail' src='$photo' width='90' height='120' alt='$nip.jpg'></center>";
        echo "</td>";
        echo "<td>$nama</td>";
        echo "<tr><td>$namajab</td></tr>";
        echo "<tr><td>$namaunker</td></tr>";
        echo "<td align='center' colspan='2'>";
        echo "<button type='submit' class='btn btn-success btn-sm'>
              <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
              </button>";                      
        echo "</td>
              </tr>
              </table>";
      } else {
        echo "<center><b><span style='color: #0000FF'>User telah terdaftar.</span></b></center>";
      }
    } else {
        echo "<center><b><span style='color: #FF0000'>Data tidak ditemukan.</span></b></center>";
    }
  }

  function resetpassword() {
    $nip = addslashes($this->input->post('nip'));
    $username = addslashes($this->input->post('username'));
    $level = addslashes($this->input->post('level'));

    $data['user'] = $this->madmin->getuser($nip, $username, $level)->result_array();
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['content'] = 'admin/resetpassword';
    $this->load->view('template', $data);
  }

  function tambahuser_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $username = addslashes($this->input->post('username'));
    $password = addslashes($this->input->post('password'));
    $level = addslashes($this->input->post('level'));

    $pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pass=md5($pengacak1 . md5($password));

    $profil = $this->input->post('profil');
    $edit_profil = $this->input->post('edit_profil');
    $cetakprofil = $this->input->post('cetakprofil');
    $nominatif = $this->input->post('nominatif');
    $cetaknominatif = $this->input->post('cetaknominatif');
    $statistik = $this->input->post('statistik');
    $cetakstatistik = $this->input->post('cetakstatistik');
    $sotk = $this->input->post('sotk');
    $cetaksotk = $this->input->post('cetaksotk');
    $usulcuti = $this->input->post('usulcuti');
    $prosescuti = $this->input->post('prosescuti');
    $usulkgb = $this->input->post('usulkgb');
    $proseskgb = $this->input->post('proseskgb');
    $nonpns = $this->input->post('nonpns');
    $akunpns = $this->input->post('akunpns');	
    $tpp = $this->input->post('tpp');	

    $data = array(
      'nip'               => $nip,
      'username'          => $username,
      'password'          => $pass,
      'level'             => $level,
      'profil'            => $profil,
      'edit_profil'       => $edit_profil,
      'cetak_profil'      => $cetakprofil,
      'nominatif'         => $nominatif,
      'cetak_nominatif'   => $cetaknominatif,
      'statistik'         => $statistik,
      'cetak_statistik'   => $cetakstatistik,
      'sotk'              => $sotk,
      'cetak_sotk'        => $cetaksotk,
      'usulcuti'          => $usulcuti,
      'prosescuti'        => $prosescuti,
      'usulkgb'           => $usulkgb,
      'proseskgb'         => $proseskgb,
      'nonpns'            => $nonpns,
      'akunpns'           => $akunpns,
      'tpp'               => $tpp
      );

    if ($this->madmin->input_user($data))
      {
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, User <u>'.$username.' (NIP. '.$nip.')</u> berhasil ditambahkan.');
        redirect('admin/listuser');
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        //$data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
        //$data['jnspesan'] = 'alert alert-success';
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, User <u>'.$username.' (NIP. '.$nip.')</u> gagal ditambahkan.');
        redirect('admin/listuser');
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
        //$data['jnspesan'] = 'alert alert-danger';
      }       
  }

  function hapususer_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $nama = addslashes($this->input->post('nama'));
    $level = addslashes($this->input->post('level'));

    $where = array('nip' => $nip,
                   'username' => $nama,
                   'level' => $level
             );

    if ($this->madmin->hapus_user($where)) {
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, User <u>'.$nama.' (NIP. '.$nip.')</u> berhasil dihapus.');
        redirect('admin/listuser');
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, User <u>'.$nama.' (NIP. '.$nip.')</u> gagal dihapus.');
        redirect('admin/listuser');
      }
  }

  function ceksamapassword() {
    $pbaru = addslashes($this->input->get('pbaru'));
    $pbarulagi = addslashes($this->input->get('pbarulagi'));

    if ($pbaru != $pbarulagi) {
      echo "Password tidak sama";
    } else {
      echo "<button type='submit' class='btn btn-success btn-sm'>";
      echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspReset Password";
      echo "</button>";
    }
  }

  function prosesresetpassword() {
    $nip = addslashes($this->input->post('nip'));
    $username = addslashes($this->input->post('username'));
    $pwdbaru = addslashes($this->input->post('pwdbaru'));
    $pwdbarulagi = addslashes($this->input->post('pwdbarulagi'));  

    $pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file mlogin.php)
    $pass=md5($pengacak1 . md5($pwdbaru));

    $data = array(      
      'password' => $pass
      );

    $where = array(
      'nip'      => $nip,
      'username'     => $username
    );

    if ($this->madmin->edit_user($where, $data))
    {
      $this->session->set_flashdata('pesan', '<b>Berhasil</b>, Password <u>'.$username.' (NIP. '.$nip.')</u> berhasil direset.');
        redirect('admin/listuser');
    } else {
      $this->session->set_flashdata('pesan', '<b>Gagal</b>, Password <u>'.$username.' (NIP. '.$nip.')</u> gagal direset.');
        redirect('admin/listuser');
    }
  }

  function edituser() {
    $nip = addslashes($this->input->post('nip'));
    $username = addslashes($this->input->post('username'));
    $level = addslashes($this->input->post('level'));

    $data['user'] = $this->madmin->getuser($nip, $username, $level)->result_array();
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['content'] = 'admin/edituser';
    $this->load->view('template', $data);
  }

  function edituser_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $unamelama = addslashes($this->input->post('unamelama'));
    $unamebaru = addslashes($this->input->post('unamebaru'));
    $level = addslashes($this->input->post('level'));

    $profil = $this->input->post('profil');
    $edit_profil = $this->input->post('edit_profil');
    $cetakprofil = $this->input->post('cetakprofil');
    $nominatif = $this->input->post('nominatif');
    $cetaknominatif = $this->input->post('cetaknominatif');
    $statistik = $this->input->post('statistik');
    $cetakstatistik = $this->input->post('cetakstatistik');
    $sotk = $this->input->post('sotk');
    $cetaksotk = $this->input->post('cetaksotk');
    $usulcuti = $this->input->post('usulcuti');
    $prosescuti = $this->input->post('prosescuti');
    $usulkgb = $this->input->post('usulkgb');
    $proseskgb = $this->input->post('proseskgb');
    $nonpns = $this->input->post('nonpns');
    $akunpns = $this->input->post('akunpns');
    $tpp = $this->input->post('tpp');

    $data = array(
      'nip'               => $nip,
      'username'          => $unamebaru,
      'level'             => $level,
      'profil'            => $profil,
      'edit_profil'       => $edit_profil,
      'cetak_profil'      => $cetakprofil,
      'nominatif'         => $nominatif,
      'cetak_nominatif'   => $cetaknominatif,
      'statistik'         => $statistik,
      'cetak_statistik'   => $cetakstatistik,
      'sotk'              => $sotk,
      'cetak_sotk'        => $cetaksotk,
      'usulcuti'          => $usulcuti,
      'prosescuti'        => $prosescuti,
      'usulkgb'           => $usulkgb,
      'proseskgb'         => $proseskgb,
      'nonpns'            => $nonpns,
      'akunpns'           => $akunpns,
      'tpp'               => $tpp
      );

    $where = array(
      'nip'      => $nip,
      'username' => $unamelama
    );

    if ($this->madmin->edit_user($where, $data))
      {
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, User '.$unamelama.' (NIP. '.$nip.') berhasil diedit.');
        redirect('admin/listuser');
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        //$data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
        //$data['jnspesan'] = 'alert alert-success';
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, User '.$unamelama.' (NIP. '.$nip.') gagal diedit.');
        redirect('admin/listuser');
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
        //$data['jnspesan'] = 'alert alert-danger';
      }       
  }

  function listsopduser()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('level') == "ADMIN") { 
      $data['sopd'] = $this->madmin->listsopduser()->result_array();
      $data['jmldata'] = count($this->madmin->listsopduser()->result_array());
      $data['content'] = 'admin/listsopduser';
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function editsopduser()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('level') == "ADMIN") { 
      $id_instansi = addslashes($this->input->post('id_instansi'));
      $nama_instansi = addslashes($this->input->post('nama_instansi'));

      $data['user'] = $this->madmin->getsopduser($id_instansi, $nama_instansi)->result_array();
      $data['content'] = 'admin/editsopduser';
      $this->load->view('template', $data);
    }
  }

  function editsopduser_aksi() {
    $id_instansi = addslashes($this->input->post('id_instansi'));
    $nip_user = addslashes($this->input->post('nip_user'));
    $nama_instansi = addslashes($this->input->post('nama_instansi'));

    $data = array(
      'nip_user' => $nip_user
      );

    $where = array(
      'id_instansi'      => $id_instansi
    );

    if ($this->madmin->edit_sopduser($where, $data))
      {
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, SOPD User '.$nama_instansi.' berhasil diedit.');
        redirect('admin/listsopduser');
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        //$data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
        //$data['jnspesan'] = 'alert alert-success';
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, SOPD User '.$nama_instansi.' gagal diedit.');
        redirect('admin/listsopduser');
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
        //$data['jnspesan'] = 'alert alert-danger';
      }       
  }

  function carispesimen()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'admin/carispesimen';
      $this->load->view('template',$data);
    }
  }

  function tampilspesimen() {
    $idunker = $this->input->get('idunker');
     
    if ($idunker) {      
        $sqlcari = $this->madmin->getspesimen($idunker)->result_array();

        $namaunker = $this->munker->getnamaunker($idunker);

        echo "<div class='panel panel-default' style='width: 70%'>";
        echo "<div class='panel-body'>";
        echo "<form method='POST' action='../admin/editspesimen'>";
        echo "<input type='hidden' name='id_unker' size='30' maxlength='18' value='$idunker' />";
        echo "<div class='panel panel-warning'>";
        echo "<div class='panel-heading' align='left'><b>$namaunker</b><br />";
        echo "</div>";
        echo "<div style='padding:0px;overflow:auto;width:99%;height:170px;border:1px solid white' >";

        echo "<table class='table table-condensed'>";
        foreach($sqlcari as $v):
          echo "<tr>";
          echo "<td align='right'><b>Status :</b></td>";
          if ($v['status'] == 'DEFINITIF') {
            $namastatus = 'Definitif';
            $jabok = $v['jabatan_spesimen'];
          } else if ($v['status'] == 'PLT') {
            $namastatus = 'Pelaksana Tugas';
            $jabok = 'Plt. '.$v['jabatan_spesimen'];
          } else if ($v['status'] == 'PLH') {
            $namastatus = 'Pelaksana Harian';
            $jabok = 'Plh. '.$v['jabatan_spesimen'];
          } else if ($v['status'] == 'AN') {
            $namastatus = 'Atas Nama';
            $jabok = 'A.n. '.$v['jabatan_spesimen'];
          } else if ($v['status'] == 'PJ') {
            $namastatus = 'Penjabat';
            $jabok = 'Penjabat. '.$v['jabatan_spesimen'];
          }

          echo "<td>".$namastatus."</td>";       
          echo "<td rowspan='4' width='120'>
                <center><img src=".base_url()."photo/".$v['nip'].".jpg width='90' height='120' alt=''></center></td>";             
          echo "</tr>
                <tr>";
          echo "<td align='right' width='150'><b>NIP :</b></td>";
          echo "<td>".$v['nip']."</td>";          
          echo "</tr>
                <tr>";
          $nama = $this->mpegawai->getnama($v['nip']);
          echo "<td align='right'><b>Nama :</b></td>";
          echo "<td>".$nama."</td>";          
          echo "</tr>
                <tr>";          
          echo "<td align='right'><b>Jabatan Spesimen :</b></td>";

          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }
          $namajab = $this->mpegawai->namajab($v['fid_jnsjab'],$idjab); 
          
          if ($v['status'] == 'AN') {
            echo "<td align='center'>".$jabok."<br />".$namajab."</td>";
          } else {
            echo "<td align='center'>".$jabok."</td>";
          }
          
          
          echo "</tr>";
          //echo "<button type='submit' class='btn btn-success btn-sm'>
          //      <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
          //      </button>";                     
        endforeach;

        echo "</table>";        
        echo "</div>"; // div scrolbar
        echo "</div>"; // div panel-info
        echo "<p align='right'>";
        echo "<button type='submit' class='btn btn-warning btn-sm'>
              <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>&nbsp&nbspEdit
              </button>";  
        echo "</p";        
        
        echo "</div>"; // div body
        echo "</div>"; // div panel
    } 
  }

  function editspesimen()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $idunker = $this->input->post('id_unker');
      $data['nmunker'] = $this->munker->getnamaunker($idunker);
      $data['spes'] = $this->madmin->getspesimen($idunker)->result_array();
      $data['content'] = 'admin/editspesimen';
      $this->load->view('template',$data);
    }
  }

  function getdataspesimen() {
    $status = $this->input->get('status');
    $nip = $this->input->get('nip');
    $jabasli = $this->input->get('jab');

    $nama = $this->mpegawai->getnama($nip);
    $fidunker = $this->mpegawai->getfidunker($nip);

    if ($nama) {      
      if ($status == 'DEFINITIF') {
        $jabok = $jabasli; 
      } else if ($status == 'PLT') {
        $jabok = 'PLT. '.$jabasli; 
      } else if ($status == 'PLH') {
        $jabok = 'PLH. '.$jabasli; 
      } else if ($status == 'AN') {
        $jabspes = $this->mpegawai->namajabnip($nip);
        $jabok = 'A.n. '.$jabasli.'<br />'.$jabspes; 
      } else if ($status == 'PJ') {
        $jabok = 'Penjabat. '.$jabasli;
      }
        $jabspes = $this->mpegawai->namajabnip($nip);
        echo "<table class='table table-condensed'>";
        echo "<tr>";
        echo "<td rowspan='4' align='center'>";
        echo "<img src=".base_url()."photo/".$nip.".jpg width='60' height='80' alt='$nip.jpg'>";
        echo "</td>";
        echo "</tr>";
        echo "<tr><td align='center'>$jabok<br /></td></tr>";        
        echo "<tr><td align='center'><br /></td></tr>";        
        echo "<tr><td align='center'>$nama<br />(NIP. $nip)</td></tr>";
        echo "<tr><td align='right' colspan='2'>";
        echo "<button type='submit' class='btn btn-success btn-sm'>
              <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
              </button>";                      
        echo "</td>
              </tr>
              </table>";
    } else {
        echo "<center><b><span style='color: #FF0000'>Data tidak ditemukan.</span></b></center>";
    }
  }

  function editspesimen_aksi() {
    $idunker = addslashes($this->input->post('idunker'));
    $status = addslashes($this->input->post('status'));
    $nip_lama = addslashes($this->input->post('nip_lama'));
    $nip = addslashes($this->input->post('nip'));
    $jabatan = addslashes($this->input->post('jabatan')); 

    $nmunker = $this->munker->getnamaunker($idunker);   

    $data = array(
      'nip'              => $nip,
      'status'           => $status,
      'jabatan_spesimen' => $jabatan
    );

    $where = array(
      'fid_unit_kerja'  => $idunker,
      'nip'             => $nip_lama
    );

    if ($this->madmin->edit_spesimen($where, $data))
      {
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, Spesimen '.$nmunker.' berhasil diedit.');
        redirect('admin/carispesimen');
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        //$data['pesan'] = '<b>Sukses</b>, Usul Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
        //$data['jnspesan'] = 'alert alert-success';
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, Spesimen '.$nmunker.' gagal diedit.');
        redirect('admin/carispesimen');
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
        //$data['jnspesan'] = 'alert alert-danger';
      }       
  }

  // START UPDATE PHOTO
  function approvephoto()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('level') == "ADMIN") { 
      $data['data'] = $this->mpegawai->tampilusulan("TIDAK")->result_array();
      $data['content'] = 'admin/approvephoto';
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function hapusupdatephoto_aksi(){
    $nip = addslashes($this->input->post('nip'));

    $where = array('nip' => $nip);

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mpegawai->hapus_updatephoto($where)) {
        // hapus file nya
        if (file_exists('./photo_temp/'.$nip.'.jpg')) {
          unlink('./photo_temp/'.$nip.'.jpg');
        }
        $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Usulan Update Photo <u>'.$nama.' (NIP. '.$nip.')</u> <b>BERHASIL DIHAPUS</b>.');
    } else {
        $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Usulan Update Photo <u>'.$nama.' (NIP. '.$nip.')</u> <b>GAGAL DIHAPUS</b>.');
    }

    $data['data'] = $this->mpegawai->tampilusulan("TIDAK")->result_array();  
    $data['content'] = 'admin/approvephoto';
    $this->load->view('template', $data);
  }  

  function setujuupdatephoto_aksi(){
    $nip = addslashes($this->input->post('nip'));

    $where = array('nip' => $nip);
    $data = array('approved' => "YA");

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mpegawai->edit_updatephoto($where, $data)) {
        // CUT PHOTO KE TEMPAT ASLINYA
        $photo_asli = "./photo/".$nip.".jpg";
        $photo_temp = "./photo_temp/".$nip.".jpg";
        
        if (copy($photo_temp, $photo_asli)) {
          //unlink('./photo_temp/'.$nip.'.jpg');
          $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Usulan Update Photo <u>'.$nama.' (NIP. '.$nip.')</u> <b>BERHASIL DISETUJUI</b>.');
        }     
    } else {
        $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Usulan Update Photo <u>'.$nama.' (NIP. '.$nip.')</u> <b>GAGAL DISETUJUI</b>.');
    }

    $data['data'] = $this->mpegawai->tampilusulan("TIDAK")->result_array();  
    $data['content'] = 'admin/approvephoto';
    $this->load->view('template', $data);
  }

  function tolakupdatephoto_aksi(){
    $nip = addslashes($this->input->post('nip'));

    $where = array('nip' => $nip);
    $data = array('approved' => "DITOLAK");

    $nama = $this->mpegawai->getnama($nip);
    if ($this->mpegawai->edit_updatephoto($where, $data)) {
      //unlink('./photo_temp/'.$nip.'.jpg');
      $this->session->set_flashdata('pesan', '<b>SUKSES</b>, Usulan Update Photo <u>'.$nama.' (NIP. '.$nip.')</u> <b>BERHASIL DITOLAK</b>.');   
    } else {
      $this->session->set_flashdata('pesan', '<b>GAGAL</b>, Usulan Update Photo <u>'.$nama.' (NIP. '.$nip.')</u> <b>GAGAL DITOLAK</b>.');
    }

    $data['data'] = $this->mpegawai->tampilusulan("TIDAK")->result_array();  
    $data['content'] = 'admin/approvephoto';
    $this->load->view('template', $data);
  }
  // END UPDATE PHOTO
  
  

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
