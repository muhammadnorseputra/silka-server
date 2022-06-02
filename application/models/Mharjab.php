<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Mharjab extends CI_Model
{
    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
    }
    
    function get_hargajabfu($nip)
    {
        $q = $this->db->query("select j.harga from ref_jabfu as j, pegawai as p where p.fid_jabfu=j.id_jabfu and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->harga;
        }
    }
    
    function get_namajabatan_byid($id) {
    		$q = $this->db->query("select nama_jabatan from ref_jabstruk where id_jabatan = '$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->nama_jabatan;
        }
    }
    
    function get_namajabatan_byid_jfu($id) {
    		$q = $this->db->query("select nama_jabfu from ref_jabfu where id_jabfu = '$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->nama_jabfu;
        }
    }
    
    function get_data_jst($tbl, $unker) {
    		$this->db->select('j.*, e.nama_eselon');
    		$this->db->from($tbl.' AS j');
    		$this->db->join('ref_eselon AS e', 'j.fid_eselon = e.id_eselon');
    		$this->db->where('j.fid_unit_kerja', $unker);
    		$q = $this->db->get()->result();
    		return $q;
    }
    
    public function get_data_jfu($tbl, $join, $unkerid) {
    		$this->db->select('j.id_jabfu, j.nama_jabfu, j.kelompok_tugas, j.kelas, j.harga');
    		$this->db->from($tbl.' AS p');
    		$this->db->join($join.' AS j', 'p.fid_jabfu = j.id_jabfu');
    		$this->db->where('p.fid_unit_kerja', $unkerid);
    		$this->db->group_by('p.fid_jabfu');
    		$q = $this->db->get()->result();
    		return $q;
    }
    
    public function get_data_jft($tbl, $join, $unkerid) {
    		$this->db->select('j.nama_jabft, j.kelompok_tugas, j.kelas, j.harga');
    		$this->db->from($tbl.' AS p');
    		$this->db->join($join.' AS j', 'p.fid_jabft = j.id_jabft');
    		$this->db->where('p.fid_unit_kerja', $unkerid);
    		$this->db->group_by('p.fid_jabft');
    		$q = $this->db->get()->result();
    		return $q;
    }
    
    
    public function get_jabatan_induk($id) {
    	$q = $this->db->query("select nama_jabatan from `ref_jabstruk` where id_jabatan = '$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->nama_jabatan;
        }
    }
    
    public function get_data_byid($tbl, $id) {
    	return $this->db->get_where($tbl, $id)->result();
    }
    
    public function update_data_jst($tbl, $data, $whr) {
    	$this->db->where($whr);
    	$this->db->update($tbl, $data);
    	return true;
    }
    
    public function update_data_jfu($tbl, $data, $whr) {
    	$this->db->where($whr);
    	$this->db->update($tbl, $data);
    	return true;
    }
  }