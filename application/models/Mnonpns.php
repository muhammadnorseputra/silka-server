<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnonpns extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

	function agama()
  {
    $sql = "SELECT * from ref_agama";
    return $this->db->query($sql);
  }

  function kelurahan()
  {
    $sql = "SELECT * from ref_kelurahan ORDER BY nama_kelurahan";
    return $this->db->query($sql);
  }

  function jenis_nonpns()
  {
    $sql = "SELECT * from ref_jenis_nonpns ORDER BY nama_jenis_nonpns";
    return $this->db->query($sql);
  }

  function jurpen($idtp)
  {
    $sql = "SELECT * from ref_jurusan_pendidikan WHERE fid_tingkat_pendidikan = '".$idtp."' ORDER BY nama_jurusan_pendidikan";
    return $this->db->query($sql);
  }

  function jabatan()
  {
    $sql = "SELECT * from ref_jabnonpns ORDER BY nama_jabnonpns";
    return $this->db->query($sql);
  }

  function getjabatan($idjab)
  {
    $q = $this->db->query("select nama_jabnonpns from ref_jabnonpns where id_jabnonpns='$idjab'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jabnonpns; 
    }        
  }

  function getketjabatan($nik)
  {
    $q = $this->db->query("select ket_jabnonpns from nonpns where nik='$nik'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->ket_jabnonpns; 
    }        
  }

  function getjnsnonpns($idjns)
  {
    $q = $this->db->query("select nama_jenis_nonpns from ref_jenis_nonpns where id_jenis_nonpns='$idjns'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_nonpns; 
    }        
  }

  public function getnama($nik)
  {
    $q = $this->db->query("select gelar_depan, nama, gelar_blk from nonpns where nik='$nik'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_blk);
      return $joinString;
    } 
  }

  function cek_nik($nik)
  {    
    $q = $this->db->query("select nik from nonpns where nik='".$nik."'");  
    return $q->num_rows();
  }

  function input_nonpns($data){
    $this->db->insert('nonpns',$data);
    return true;
  }

  function nonpnsperunker($id)
  {
    $q = $this->db->query("select np.nik, np.gelar_depan, np.nama, np.gelar_blk, np.tgl_lahir, np.photo, np.berkas,
      np.fid_jenis_nonpns, np.fid_sumbergaji, u.nama_unit_kerja, j.nama_jabnonpns, np.tmt_sk_awal
      from nonpns as np, ref_unit_kerjav2 as u, ref_jabnonpns as j, ref_sumbergaji as sg
      where np.fid_unit_kerja = u.id_unit_kerja
      and np.fid_jabnonpns = j.id_jabnonpns
      and np.fid_sumbergaji = sg.id_sumbergaji
      and fid_unit_kerja='$id'
      order by np.created_at asc");
    return $q;
  }

  function getjmlperunker($id)
  {
    $q = $this->db->query("select * from nonpns where fid_unit_kerja='$id'");
    return $q->num_rows();
  }

   public function detail($nik)
  {
    $q = $this->db->query("select * from nonpns where nik='$nik'");
    return $q;
  }

  function edit_nonpns($where, $data){
    $this->db->where($where);
    $this->db->update('nonpns',$data);
    return true;
  }

  function hapus_nonpns($where){
    $this->db->where($where);
    $this->db->delete('nonpns');
    return true;
  }

  function nomperunker($id)
    {
        $q = $this->db->query("select np.*, rs.nip as 'nip_spesimen', rs.status as 'status_spesimen', rs.jabatan_spesimen from nonpns as np, ref_spesimen as rs where np.fid_unit_kerja='$id' and np.fid_unit_kerja=rs.fid_unit_kerja order by np.tmt_sk_awal, np.fid_tingkat_pendidikan desc, np.tahun_lulus, np.tgl_lahir asc");
        return $q;
    }

  function getphoto($nik)
  {
    $q = $this->db->query("select photo from nonpns where nik='$nik'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->photo; 
    }        
  }

  function getberkas($nik)
  {
    $q = $this->db->query("select berkas from nonpns where nik='$nik'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->berkas; 
    }        
  }

  // untuk graph statistik
  public function jmlnonpns()
  {
    $q = $this->db->query("select nik from nonpns");
    return $q->num_rows();
  }

  public function jmlnonpns_apbd()
  {
    $q = $this->db->query("select nik from nonpns where fid_sumbergaji='2'");
    return $q->num_rows();
  }

  public function graph_jenkel()
  {
    $data = $this->db->query("select jns_kelamin, COUNT(jns_kelamin) as jumlah from nonpns group by jns_kelamin desc");
    return $data->result();
  }

  public function graph_tingpen()
  {
    $query = $this->db->query("select tp.nama_tingkat_pendidikan as 'namatingpen', COUNT(p.fid_tingkat_pendidikan) as jumlah from nonpns as p, ref_tingkat_pendidikan as tp where p.fid_tingkat_pendidikan = tp.id_tingkat_pendidikan group by tp.id_tingkat_pendidikan");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }  

  public function graph_sumgaji()
  {
    $data = $this->db->query("select sg.nama_sumbergaji, COUNT(sg.nama_sumbergaji) as jumlah from nonpns as np, ref_sumbergaji as sg where np.fid_sumbergaji=sg.id_sumbergaji group by sg.nama_sumbergaji desc");
    return $data->result();
  }

  public function graph_jnshon()
  {
    $data = $this->db->query("select jj.nama_jenis_nonpns, COUNT(p.fid_jenis_nonpns) as jumlah from nonpns as p, ref_jenis_nonpns as jj where p.fid_jenis_nonpns = jj.id_jenis_nonpns group by jj.nama_jenis_nonpns");
    return $data->result();
  }

  public function graph_jabnonpns()
  {
    $query = $this->db->query("select g.nama_jabnonpns, COUNT(p.fid_jabnonpns) as jumlah from nonpns as p, ref_jabnonpns as g where p.fid_jabnonpns = g.id_jabnonpns group by g.id_jabnonpns");

    if($query->num_rows() > 0){
      foreach($query->result() as $data){
        $hasil[] = $data;
      }
      return $hasil;
    }
  }


  public function getbynik($data)
    {
      $sess_nip = $this->session->userdata('nip');
        $q = $this->db->query("
          select np.nik, np.gelar_depan, np.nama, np.gelar_blk, np.photo, np.berkas,
      np.fid_jenis_nonpns, fid_sumbergaji, u.nama_unit_kerja, j.nama_jabnonpns, np.tmt_sk_awal
      from nonpns as np, ref_unit_kerjav2 as u, ref_jabnonpns as j, ref_instansi_userportal as i
      where np.fid_unit_kerja = u.id_unit_kerja      
      and u.fid_instansi_userportal = i.id_instansi 
      and np.fid_jabnonpns = j.id_jabnonpns
      and i.nip_user like '%$sess_nip%'
      and np.nik = '$data'
      order by np.tmt_sk_awal desc, np.created_at asc");
        return $q;        
    }

  public function getbyniknama($data)
    {
      $sess_nip = $this->session->userdata('nip');
        $q = $this->db->query("
          select np.nik, np.gelar_depan, np.nama, np.gelar_blk, np.photo, np.berkas,
      np.fid_jenis_nonpns, np.fid_sumbergaji, u.nama_unit_kerja, j.nama_jabnonpns, np.tmt_sk_awal
      from nonpns as np, ref_unit_kerjav2 as u, ref_jabnonpns as j, ref_instansi_userportal as i
      where np.fid_unit_kerja = u.id_unit_kerja      
      and u.fid_instansi_userportal = i.id_instansi 
      and np.fid_jabnonpns = j.id_jabnonpns
      and i.nip_user like '%$sess_nip%'
      and (np.nik = '$data' OR np.nama like '%$data%')
      order by np.tmt_sk_awal desc, np.created_at asc");
        return $q;        
    }

  public function graph_perinstansi()
  {
    $query = $this->db->query("select i.nama_instansi as 'namainstansi', COUNT(np.fid_unit_kerja) as 'jumlah' from nonpns as np, ref_unit_kerjav2 as u, ref_instansiv2 as i where np.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi group by u.fid_instansi");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  // untuk riwayat pendidikan
  public function rwypdk($nik)
  {
    $q = $this->db->query("select fid_tingkat, fid_jurusan, gelar, thn_lulus, nama_sekolah, nama_kepsek, no_sttb, tgl_sttb from nonpns_rwy_pendidikan where nik='$nik' ORDER BY thn_lulus desc");    
    return $q;    
  } 

  function input_rwypdk($data){
    $this->db->insert('nonpns_rwy_pendidikan',$data);
    return true;
  }

  function hapus_rwypdk($where){
    $this->db->where($where);
    $this->db->delete('nonpns_rwy_pendidikan');
    return true;
  }

  function edit_rwypdk($where, $data){
    $this->db->where($where);
    $this->db->update('nonpns_rwy_pendidikan',$data);
    return true;
  }

  public function detailrwypdk($nik, $fid_tingkat)
  {
    $q = $this->db->query("select * from nonpns_rwy_pendidikan where nik='$nik' and fid_tingkat='$fid_tingkat'");
    return $q;
  }

  // untuk riwayat pekerjaan
  public function rwypkj($nik)
  {
    $q = $this->db->query("select * from nonpns_rwy_pekerjaan where nik='$nik' ORDER BY tmt_awal desc");    
    return $q;    
  }

  function input_rwypkj($data){
    $this->db->insert('nonpns_rwy_pekerjaan',$data);
    return true;
  }

   function hapus_rwypkj($where){
    $this->db->where($where);
    $this->db->delete('nonpns_rwy_pekerjaan');
    return true;
  }

  public function getdatarwypkj($nik, $tmt_awal)
  {
    $q = $this->db->query("select * from nonpns_rwy_pekerjaan where nik='$nik' and tmt_awal='$tmt_awal'");    
    return $q;    
  }

  public function sumbergaji()
  {
    $q = $this->db->query("select * from ref_sumbergaji");
    return $q;
  }

  function getsumbergaji($id)
  {
    $q = $this->db->query("select nama_sumbergaji from ref_sumbergaji where id_sumbergaji='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_sumbergaji; 
    }        
  }

  function edit_rwypkj($where, $data){
    $this->db->where($where);
    $this->db->update('nonpns_rwy_pekerjaan',$data);
    return true;
  }

  public function getskawal($nik)
  {
    $q = $this->db->query("select * from nonpns_rwy_pekerjaan where tmt_awal = (select min(tmt_awal) from nonpns_rwy_pekerjaan where nik='$nik') and nik='$nik'");    
    return $q;    
  }

  public function getskakhir($nik)
  {
    $q = $this->db->query("select * from nonpns_rwy_pekerjaan where tmt_awal = (select max(tmt_awal) from nonpns_rwy_pekerjaan where nik='$nik') and nik='$nik'");    
    return $q;    
  }

}
/* End of file mpegawai.php */
/* Location: ./application/models/mpegawai.php */