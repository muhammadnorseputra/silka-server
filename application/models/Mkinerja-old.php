<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Mkinerja extends CI_Model
{
    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
    }

    function dd_unker()
    {
        //$sql = "SELECT * from ref_unit_kerja";
        $nip = $this->session->userdata('nip');
        $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                WHERE
                u.fid_instansi_userportal = i.id_instansi
                and u.unker_ekinerja != ''
                and up.nip = '$nip'
                and i.nip_user like '%$nip%' order by u.id_unit_kerja";
        return $this->db->query($sql);
    }

    function get_idunkerkinerja($id)
    {
        $q = $this->db->query("select unker_ekinerja from ref_unit_kerjav2 where id_unit_kerja='$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->unker_ekinerja; 
        }        
    }

    public function get_jnsjab($nip)
      {
        $q = $this->db->query("select jj.nama_jenis_jabatan from ref_jenis_jabatan as jj, pegawai as p where p.fid_jnsjab = jj.id_jenis_jabatan and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->nama_jenis_jabatan; 
        }        
      }

    function get_kelasjabstruk($nip)
    {
        $q = $this->db->query("select j.kelas from ref_jabstruk as j, pegawai as p where p.fid_jabatan=j.id_jabatan and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas; 
        }        
    }

    function get_hargajabstruk($nip)
    {
        $q = $this->db->query("select j.harga from ref_jabstruk as j, pegawai as p where p.fid_jabatan=j.id_jabatan and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->harga; 
        }        
    }

    function get_kelasjabfu($nip)
    {
        $q = $this->db->query("select j.kelas from ref_jabfu as j, pegawai as p where p.fid_jabfu=j.id_jabfu and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas;
        }
    }


}
 
/* End of file Mkinerja.php */
/* Location: ./application/models/Mkinerja.php */
