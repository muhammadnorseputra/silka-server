<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mhukdis extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

	// Awal Hukuman Disiplin
  //public function rwyhd($nip)
  //{
  //  $q = $this->db->query("select * from riwayat_hukdis where nip='$nip' ORDER BY tmt_hukuman desc");    
  //  return $q;    
  //}

  // Awal Hukuman Disiplin (Proper Bu Dewi)
  public function rwyhd($nip)
  {
    $q = $this->db->query("select * from riwayat_hukdis where nip='$nip' ORDER BY tmt_hukuman desc");    
    return $q;    
  }

  function jnshukdis()
  {
    $sql = "SELECT * from ref_jenis_hukdis ORDER BY id_jenis_hukdis";
    return $this->db->query($sql);
  }

  function getjnshukdis($id) {
    $q = $this->db->query("select nama_jenis_hukdis from ref_jenis_hukdis where id_jenis_hukdis='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $namahd = $row->nama_jenis_hukdis;
    }
    return $namahd;
  }

  function getnilaigajiterakhir($nip, $ket) {
    if ($ket=='SK KP') {
     $q = $this->db->query("select tmt, fid_golru, gapok, mkgol_thn, mkgol_bln from riwayat_pekerjaan where nip='$nip' and tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')");
    } else if ($ket=='SK CPNS') {
     $q = $this->db->query("select tmt_cpns, fid_golru_cpns, gapok_cpns, mkthn_cpns, mkbln_cpns from cpnspns where nip='$nip' and tmt_cpns IN (select max(tmt_cpns) from cpnspns where nip='$nip')");
    } else if ($ket=='SK KGB') {
     $q = $this->db->query("select tmt, fid_golru, gapok, mk_thn, mk_bln from riwayat_kgb where nip='$nip' and tmt IN (select max(tmt) from riwayat_kgb where nip='$nip')");
    }

    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->gapok; 
    } 
  }

  function gettmtgajiterakhir($nip, $ket) {
    if ($ket=='SK KP') {
     $q = $this->db->query("select tmt, fid_golru, gapok, mkgol_thn, mkgol_bln from riwayat_pekerjaan where nip='$nip' and tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')");
    } else if ($ket=='SK CPNS') {
     $q = $this->db->query("select tmt_cpns as 'tmt', fid_golru_cpns, gapok_cpns, mkthn_cpns, mkbln_cpns from cpnspns where nip='$nip' and tmt_cpns IN (select max(tmt_cpns) from cpnspns where nip='$nip')");
    } else if ($ket=='SK KGB') {
     $q = $this->db->query("select tmt, fid_golru, gapok, mk_thn, mk_bln from riwayat_kgb where nip='$nip' and tmt IN (select max(tmt) from riwayat_kgb where nip='$nip')");
    }

    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tmt; 
    } 
  }

  function getidgolruterakhir($nip)
  {
    $q = $this->db->query("select fid_golru_skr from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_golru_skr; 
    }        
  }

  function gettmtgolruterakhir($nip)
  {
    $q = $this->db->query("select tmt_golru_skr from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tmt_golru_skr; 
    }        
  }
  // End Hukuman Disiplin



  public function tampilusulhd()
  {
    $sess_nip = $this->session->userdata('nip');
    //$q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.tgl_usul, c.no_pengantar from pegawai as p, cuti as c, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%'  order by c.thn_cuti desc, jc.id_jenis_cuti");
    
    // tampilkan pengantar cuti dengan id_status 1:SKPD atau 2:CETAK 
    $q = $this->db->query("select lh.* from lapor_hukdis as lh, pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as i where lh.nip=p.nip and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' order by lh.nip, lh.tmt_hukuman desc");
    return $q;
  }

   function gettingkathukdis($id) {
    $q = $this->db->query("select tingkat from ref_jenis_hukdis where id_jenis_hukdis='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $namahd = $row->tingkat;
    }
    return $namahd;
  }

  function input_hukdis($data){
    $this->db->insert('lapor_hukdis',$data);
    return true;
  }

  public function detailhd($nip, $tmt, $jnshd)
  {
    $q = $this->db->query("select * from lapor_hukdis where nip='".$nip."' and tmt_hukuman='".$tmt."' and fid_jenis_hukdis='".$jnshd."' ORDER BY tmt_hukuman desc");    
    return $q;    
  }

  function peruu()
  {
    $sql = "SELECT * from ref_peruu_hukdis ORDER BY id_peruu_hukdis";
    return $this->db->query($sql);
  }

  function hapus_usul($where){
    $this->db->where($where);
    $this->db->delete('lapor_hukdis');
    return true;
  }

  function getperuu($id) {
    $q = $this->db->query("select nama_peruu_hukdis from ref_peruu_hukdis where id_peruu_hukdis='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $peruu = $row->nama_peruu_hukdis;
    }
    return $peruu;
  }

  function ceknip($nip)
  {
    $nipuser = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, u.nama_unit_kerja, u.id_unit_kerja from pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up WHERE p.nip='$nip' and p.fid_unit_kerja=u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and up.nip = '$nipuser' and i.nip_user like '%$nipuser%'");
    return $q->num_rows();
  }

  function edit_usul($where, $data){
    $this->db->where($where);
    $this->db->update('lapor_hukdis',$data);
    return true;
  }

  public function gettahuntmt()
  {
    $q = $this->db->query("SELECT YEAR(tmt_hukuman) AS 'tahun' FROM `lapor_hukdis` group by YEAR(tmt_hukuman)");    
    return $q;    
  }

  public function carivalusul($thn)
  {
    $q = $this->db->query("select * from lapor_hukdis where tmt_hukuman like '$thn%' ORDER BY nip, tmt_hukuman");    
    return $q;    
  }

  // Akhir Riwayat Hukuman Disiplin
  
  function getjmlrwyhd($idjns, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select nip from riwayat_hukdis where fid_jenis_hukdis = '$idjns' and tmt_hukuman like '$thn%'");
    return $q->num_rows();
  }

  public function getjmlrwyperbulan()
  {
    $query = $this->db->query("select MONTH(tmt_hukuman), count(nip) as 'jumlah', count(nip) as 'jumlah1' from riwayat_hukdis where tmt_hukuman like '2019%' group by MONTH(tmt_hukuman) order by MONTH(tmt_hukuman)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  function getjmlusulhd($status, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select nip from lapor_hukdis where status = '$status' and tmt_hukuman like '$thn%'");
    return $q->num_rows();
  }

  public function getjmlprosesbystatusgraph()
  {
    $data = $this->db->query("select status from lapor_hukdis where status in ('VALID', 'NO VALID')");
    return $data->result();
  }

  public function gettahunrwyhd()
  {
    $q = $this->db->query("select substring(tmt_hukuman,1,4) as 'tahun' from riwayat_hukdis WHERE substring(tmt_hukuman,1,4) >= '2015' GROUP BY substring(tmt_hukuman,1,4)");
    return $q;    
  }

  function getjmlrwybythnstatus($thn)
  {
    $q = $this->db->query("select * from riwayat_hukdis where tmt_hukuman like '$thn%'");
    
    return $q->num_rows();
  }

  public function getatasan()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, j.nama_jabatan from pegawai as p, ref_eselon as e, ref_unit_kerjav2 as u, ref_jabstruk as j, ref_instansi_userportal as i where p.fid_eselon = e.id_eselon and p.fid_unit_kerja = u.id_unit_kerja and p.fid_jabatan = j.id_jabatan and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and e.nama_eselon like 'I%' order by e.id_eselon");
    return $q;
  }

}
/* End of file mpegawai.php */
/* Location: ./application/models/mpegawai.php */
