<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Makunpns extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  // TODO
  public function listakun()
  {
    $nip = $this->session->userdata('nip');
    $q = $this->db->query("select up.*, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_jabatan, p.fid_unit_kerja from userportal_pns as up, pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as iu
                            where up.nip = p.nip
                            and p.fid_unit_kerja = u.id_unit_kerja
                            and u.fid_instansi = iu.id_instansi
                            and iu.nip_user like '%$nip%' order by p.nama");
    return $q;
  }
  
  // TODO BY NIP/NAMA
  public function listakun_bynipnama($nipnama)
  {
    $nip = $this->session->userdata('nip');
    $q = $this->db->query("select up.*, 
    												p.fid_jnsjab, 
    												p.fid_jabfu, 
    												p.fid_jabft, 
    												p.fid_jabatan, 
    												p.fid_unit_kerja 
    												from userportal_pns as up, pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as iu
                            where up.nip = p.nip
                            and (p.nip like '%$nipnama%' OR p.nama like '%$nipnama%')
                            and p.fid_unit_kerja = u.id_unit_kerja
                            and u.fid_instansi = iu.id_instansi
                            and iu.nip_user like '%$nip%' order by p.nama");
    return $q;
  }

  // TODO
  function gettotalakun()
  {
    $nip = $this->session->userdata('nip');
    $q = $this->db->query("select up.*, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_jabatan, p.fid_unit_kerja from userportal_pns as up, pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as iu
                            where up.nip = p.nip
                            and p.fid_unit_kerja = u.id_unit_kerja
                            and u.fid_instansi = iu.id_instansi
                            and iu.nip_user like '%$nip%'");
    
    return $q->num_rows();
  }

  // TODO
  function getjmlakunaktif()
  {
    $nip = $this->session->userdata('nip');
    $q = $this->db->query("select up.*, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_jabatan, p.fid_unit_kerja from userportal_pns as up, pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as iu
                            where up.nip = p.nip
                            and p.fid_unit_kerja = u.id_unit_kerja
                            and u.fid_instansi = iu.id_instansi
                            and iu.nip_user like '%$nip%'
                            and up.status = 'AKTIF'");
    
    return $q->num_rows();
  }

  // TODO
  function getjmlakunnonaktif()
  {
    $nip = $this->session->userdata('nip');
    $q = $this->db->query("select up.*, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_jabatan, p.fid_unit_kerja from userportal_pns as up, pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as iu
                            where up.nip = p.nip
                            and p.fid_unit_kerja = u.id_unit_kerja
                            and u.fid_instansi = iu.id_instansi
                            and iu.nip_user like '%$nip%'
                            and up.status = 'NONAKTIF'");
    
    return $q->num_rows();
  }

  // TODO
  public function getakun($nip)
  {
    $q = $this->db->query("select * from userportal_pns where nip = '".$nip."'");    
    return $q;    
  }

  // TODO
  function input_akun($data){
    $this->db->insert('userportal_pns',$data);
    return true;
  }

  // TODO
  function edit_akun($where, $data){
    $this->db->where($where);
    $this->db->update('userportal_pns',$data);
    return true;
  }
  
  // TODO
  function cek_akunada($nip)
  {    
    $q = $this->db->query("select nip from userportal_pns where nip = '".$nip."'");    

    $jml = $q->num_rows();
    if ($jml == 0) {
      // cek apakah nip akun dalam kewenangan user login
      $nipuser = $this->session->userdata('nip');
      $ceknip = $this->db->query("select p.nip, p.nama from pegawai as p, ref_instansi_userportal as iu, ref_unit_kerjav2 as u where 
                              p.fid_unit_kerja = u.id_unit_kerja
                              and u.fid_instansi = iu.id_instansi
                              and iu.nip_user like '%".$nipuser."%'
                              and p.nip = '".$nip."'");    
      $jmldata = $ceknip->num_rows();
      if ($jmldata == 0) {        
        return 2; // akun diluar kewenangan user
      } else {          
        return 0; // true : akun dalam kewenangan user
      }
    } else {
      return 1; // true : data ditemukan (akun sudah terdaftar)
    }
  }

  // TODO
  function hapus_akun($where){
    $this->db->where($where);
    $this->db->delete('userportal_pns');
    return true;
  }

  // TODO
  function getstatusakun($nip)
    {
      $q = $this->db->query("select status from userportal_pns where nip='$nip'");
      if ($q->num_rows()>0)
      {
        $row=$q->row();
        return $row->status; 
      }        
    }

  // TODO
  function getpwd($nip)
    {
      $q = $this->db->query("select password from userportal_pns where nip='$nip'");
      if ($q->num_rows()>0)
      {
        $row=$q->row();
        return $row->password; 
      }        
    }  
}
