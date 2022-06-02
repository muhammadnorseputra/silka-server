<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpppk extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  function getnipnama($data)
  {
  	$sess_nip = $this->session->userdata('nip');
  	$q = $this->db->query("select p.nipppk, p.gelar_depan, p.nama, p.gelar_blk, 
  		g.nama_golru, p.fid_jabft, u.nama_unit_kerja, p.tmt_golru_pppk
  		from pppk as p, ref_golru_pppk as g, ref_unit_kerjav2 as u, ref_instansi_userportal as i
  		where
  		p.fid_golru_pppk = g.id_golru
  		and p.fid_unit_kerja = u.id_unit_kerja
  		and u.fid_instansi_userportal = i.id_instansi 
  		and i.nip_user like '%$sess_nip%'
  		and (p.nipppk like '%$data%' OR p.nama like '%$data%')
  		order by p.fid_golru_pppk desc, p.tmt_golru_pppk");
  	return $q;        
  }

  function getfidunker($nipppk)
  {
  	$q = $this->db->query("select fid_unit_kerja from pppk where nipppk='$nipppk'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->fid_unit_kerja; 
  	}        
  }  

  function getkeltugas_jft_nipppk($nipppk)
  {
    $q = $this->db->query("select j.kelompok_tugas from ref_jabft as j, pppk as p where p.fid_jabft = j.id_jabft and p.nipppk='$nipppk'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $kelompok_tugas = $row->kelompok_tugas;      
      return $kelompok_tugas;
    }        
  }

  public function getnama_lengkap($nipppk)
  {
  	$q = $this->db->query("select gelar_depan, nama, gelar_blk from pppk where nipppk='$nipppk'");
  	if ($q->num_rows() > 0)
  	{
  		$row=$q->row();
  		$joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_blk);
  		return $joinString;
  	} 
  }

  function getnama($nip)
 	{
 		$q= $this->db->get_where('pppk', ['nipppk' => $nip])->row();
 		return $q->nama;
 	}
 
   function getjnskel($nip)
        {
                $q= $this->db->get_where('pppk', ['nipppk' => $nip])->row();
                return $q->jns_kelamin;
        }

 function getphoto($nip)
 	{
 		$q= $this->db->get_where('pppk', ['nipppk' => $nip])->row();
 		return $q->photo;
 	}
  
  function p3kperunker($id)
  {
    $q = $this->db->query("select p3k.*, u.nama_unit_kerja, j.nama_jabft, g.nama_golru      
    	from pppk as p3k, ref_unit_kerjav2 as u, ref_jabft as j, ref_golru_pppk as g
      where p3k.fid_unit_kerja = u.id_unit_kerja
      and p3k.fid_jabft = j.id_jabft
      and p3k.fid_golru_pppk = g.id_golru
      and p3k.fid_unit_kerja='$id'
      order by p3k.created_at asc");
    return $q;
  }
  
  function getjmlperunker($id)
  {
    $q = $this->db->query("select * from pppk where fid_unit_kerja='$id'");
    return $q->num_rows();
  }
  
  public function getbyniknama($data)
    {
        
     	$this->db->select('np.*, u.nama_unit_kerja, j.nama_jabft, g.nama_golru');  
     	$this->db->from('pppk as np');
     	$this->db->join('ref_unit_kerjav2 as u', 'np.fid_unit_kerja = u.id_unit_kerja'); 
     	$this->db->join('ref_jabft as j', 'np.fid_jabft = j.id_jabft');      
     	$this->db->join('ref_golru_pppk as g', 'np.fid_golru_pppk = g.id_golru');    
     	$this->db->where('np.nipppk', $data);
     	$this->db->or_like('np.nama', $data);
     	$this->db->order_by('np.created_at', 'asc');
     	return $this->db->get();  
    }
    
  public function detail($nip) {
  	return $this->db->select('p.*, a.nama_agama, sk.nama_status_kawin, kel.nama_kelurahan, kec.nama_kecamatan, tp.nama_tingkat_pendidikan,
  						jp.nama_jurusan_pendidikan, u.nama_unit_kerja, jft.nama_jabft, g.nama_golru')
  						->from('pppk AS p')
  						->join('ref_agama AS a', 'p.fid_agama = a.id_agama')
  						->join('ref_status_kawin AS sk', 'p.fid_status_kawin = sk.id_status_kawin')
  						->join('ref_kelurahan AS kel', 'p.fid_keldesa = kel.id_kelurahan')
  						->join('ref_kecamatan AS kec', 'kel.fid_kecamatan = kec.id_kecamatan')
  						->join('ref_tingkat_pendidikan AS tp', 'p.fid_tingkat_pendidikan = tp.id_tingkat_pendidikan')
  						->join('ref_jurusan_pendidikan AS jp', 'p.fid_jurusan_pendidikan = jp.id_jurusan_pendidikan')
  						->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja = u.id_unit_kerja')
  						->join('ref_jabft AS jft', 'p.fid_jabft = jft.id_jabft')
  						->join('ref_golru_pppk AS g', 'p.fid_golru_pppk = g.id_golru')
  						->where('nipppk', $nip)
  						->get();
  }
  function jabatan()
  {
    $sql = "SELECT * from ref_jabft ORDER BY nama_jabft";
    return $this->db->query($sql);
  }
  function golru() 
  {
  	return $this->db->order_by('id_golru', 'asc')->get('ref_golru_pppk');
  }
  function insert_pppk($data) {
  	return $this->db->insert('pppk', $data);
  }
  function edit_pppk($whr, $data) {
  	$this->db->where($whr);
  	$this->db->update('pppk', $data);
  	return true;
  }
  function hapus_pppk($where){
    $this->db->where($where);
    $this->db->delete('pppk');
    return true;
  }
 
  function pppkperunker($id)
    {
        $q = $this->db->query("select p.*, g.nama_golru
        from pppk as p, ref_golru_pppk as g
        where p.fid_golru_pppk = g.id_golru
        and p.fid_unit_kerja='$id'
        order by p.fid_golru_pppk desc, p.tmt_golru_pppk");
        return $q;
    }

  function getnamagolru($id)
  {
    $q = $this->db->query("select nama_golru from ref_golru_pppk where id_golru='".$id."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_golru; 
    }        
  }

  function getidgolruterakhir($nipppk)
  {
    $q = $this->db->query("select fid_golru_pppk from pppk where nipppk='".$nipppk."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_golru_pppk; 
    }        
  }  
	
	function status_ptkp() {
		$q = $this->db->get('ref_status_ptkp');
		return $q;
	}
	
	function getstatus_ptkp($id) {
		$q = $this->db->get_where('ref_status_ptkp', ['id_status_ptkp' => $id]);
		if($q->num_rows() > 0) {
			$row = $q->row();
			$var = $row->status;
		} else {
			$var = "Status PTKP Belum ditentukan";
		}
		return $var;
	}
	function getketerangan_ptkp($id) {
		$q = $this->db->get_where('ref_status_ptkp', ['id_status_ptkp' => $id]);
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->keterangan;
		}
	}
}
