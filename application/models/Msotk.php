<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msotk extends CI_Model {

	public function sotk($idunker)
	{    
	    $q = $this->db->query("select p.nip, p.nama, p.gelar_depan, p.gelar_belakang, p.fid_jabatan, u.nama_unit_kerja, p.photo, p.plt from pegawai as p, ref_unit_kerjav2 as u where p.fid_unit_kerja = u.id_unit_kerja and fid_jabatan != ''
	and u.id_unit_kerja='$idunker'");
	    return $q;
	}

	public function pilihunker()
    {
        //$sql = "SELECT * from ref_unit_kerja";
        $nip = $this->session->userdata('nip');
        $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                WHERE
                u.fid_instansi_userportal = i.id_instansi
                and up.nip = '$nip'
                and u.filesotk != ''
		and u.nama_unit_kerja not like '-%'
                and i.nip_user like '%$nip%' order by u.id_unit_kerja";
        return $this->db->query($sql);
    }

    public function getnamafile($idunker)
  	{
	    $q = $this->db->query("select filesotk from ref_unit_kerjav2 where id_unit_kerja = '".$idunker."'");    
	    if ($q->num_rows()>0)
	    {	    	
	      $row=$q->row();
	      return $row->filesotk;
	    }      
	}

	public function getnamajab($unker, $idjab)
  	{
	    $q = $this->db->query("select j.nama_jabatan from pegawai as p, ref_unit_kerjav2 as u, ref_jabstruk as j where p.fid_jabatan = j.id_jabatan and p.fid_unit_kerja = u.id_unit_kerja and u.nama_unit_kerja = '".$unker."' and j.id_jabatan = '".$idjab."'");    
	    if ($q->num_rows()>0)
	    {	    	
	      $row=$q->row();
	      return $row->nama_jabatan;
	    }      
	}

	/*
	public function getnip($unker, $jab)
  	{
	    $q = $this->db->query("select p.nip from pegawai as p, ref_unit_kerjav2 as u, ref_jabstruk as j where p.fid_jabatan = j.id_jabatan and p.fid_unit_kerja = u.id_unit_kerja and u.nama_unit_kerja = '".$unker."' and j.nama_jabatan = '".$jab."'");    
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      return $row->nip; 
	    }     
	}

	public function getnama($unker, $jab)
  	{
	    $q = $this->db->query("select p.nama, p.gelar_belakang, p.gelar_depan from pegawai as p, ref_unit_kerjav2 as u, ref_jabstruk as j where p.fid_jabatan = j.id_jabatan and p.fid_unit_kerja = u.id_unit_kerja and u.nama_unit_kerja = '".$unker."' and j.nama_jabatan = '".$jab."'");    
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      $joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_belakang);
	      return $joinString;
	    }      
	}

	public function cekjab($unker, $jab, $jabt)
  	{
	    $q = $this->db->query("select p.plt from pegawai as p, ref_unit_kerjav2 as u, ref_jabstruk as j where p.fid_jabatan = j.id_jabatan and p.fid_unit_kerja = u.id_unit_kerja and u.nama_unit_kerja = '".$unker."' and j.nama_jabatan = '".$jab."'");    
	    if ($q->num_rows()>0)
	    {	    	
	      $row=$q->row();
	      if (($row->plt) == 'YA') {
	      	$joinString = $jabt.' (PLT)';
	      } else {
		  	$joinString = $jabt;
		  }
	      return $joinString;
	    }      
	}

	
	*/

}

/* End of file mlogin.php */
/* Location: ./application/models/mlogin.php */
