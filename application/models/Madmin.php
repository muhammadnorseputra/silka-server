<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madmin extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function listuser()
  {
    //$q = $this->db->query("select up.*, p.fid_jabatan, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja from userportal as up, pegawai as p where up.nip = p.nip order by level desc");
    $q = $this->db->query("select up.*, p.fid_jabatan, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja from userportal as up left join pegawai as p on up.nip = p.nip");
    return $q;
  }

  public function listsopduser()
  {
    //$q = $this->db->query("select * from ref_instansi_userportal order by id_instansi");
    $q = $this->db->get("ref_instansi_userportal");
	return $q;
  }

  function getjmluser()
  {
    //$q = $this->db->query("select * from userportal");
    //$q=$this->db->get("userportal");
    //return $q->num_rows();
  
	$q=$this->db->count_all('userportal');
	return $q;
  }

  public function getuser($nip, $username, $level)
  {
    	//$q = $this->db->query("select * from userportal where nip = '".$nip."' AND username = '".$username."' AND level = '".$level."'");    
    	//$this->db->where('nip', $nip);
	//$this->db->where('username', $username);
	//$this->db->where('level', $level);
	//$q = $this->db->get('userportal');
	//return $q;

	return $this->db->get_where('userportal', array('nip' => $nip, 'username' => $username, 'level' => $level));    
  }

  function input_user($data){
    $this->db->insert('userportal',$data);
    return true;
  }

  function edit_user($where, $data){
    $this->db->where($where);
    $this->db->update('userportal',$data);
    return true;
  }
  

  function cek_userada($nip)
  {    
    //$q = $this->db->query("select nip from userportal where nip = '".$nip."'");    
    $this->db->where('nip', $nip);
    $q = $this->db->get("userportal");	

    $jml = $q->num_rows();
    if ($jml == 0) {
      return true; // true : data tidak ditemukan
    } else {
      return false;
    }
  }

  function hapus_user($where){
    $this->db->where($where);
    $this->db->delete('userportal');
    return true;
  }

  public function getsopduser($idinstansi, $namainstansi)
  {
    //$q = $this->db->query("select * from ref_instansi_userportal where id_instansi = '".$idinstansi."' AND nama_instansi = '".$namainstansi."'");    
    	$this->db->where('id_instansi', $idinstansi);
	$this->db->where('nama_instansi', $namainstansi);
	$q = $this->db->get("ref_instansi_userportal");
	return $q;    
  }

  function edit_sopduser($where, $data){
    $this->db->where($where);
    $this->db->update('ref_instansi_userportal',$data);
    return true;
  }

  public function getspesimen($idunker)
  {
    $q = $this->db->query("select rs.*, p.fid_jabatan, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft from ref_spesimen as rs, pegawai as p where p.nip = rs.nip and rs.fid_unit_kerja = '".$idunker."'");    
    return $q;    
  }

  function edit_spesimen($where, $data){
    $this->db->where($where);
    $this->db->update('ref_spesimen',$data);
    return true;
  }
}
