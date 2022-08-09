<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcuti extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function tampilpengantar()
  {
  	$sess_nip = $this->session->userdata('nip');
  	//$q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.tgl_usul, c.no_pengantar from pegawai as p, cuti as c, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip	and c.fid_jns_cuti = jc.id_jenis_cuti	and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%'	order by c.thn_cuti desc, jc.id_jenis_cuti");
  	
    // tampilkan pengantar cuti dengan id_status 1:SKPD atau 2:CETAK 
    $q = $this->db->query("select cp.* from cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where cp.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and cp.fid_status in ('1','2') order by cp.tgl_pengantar desc");
	 return $q;
  }

   public function tampilproses()
  {
    //$sess_nip = $this->session->userdata('nip');     
    //tampilkan cuti pengantar dgn status = 3 (BKPPD)
    $q = $this->db->query("select cp.* from cuti_pengantar as cp where fid_status='3' order by cp.tgl_pengantar desc");
    return $q;
  }

  function getjml()
  {
  	$sess_nip = $this->session->userdata('nip');
  	$q = $this->db->query("select c.nip, c.thn_cuti, c.jml
  		from pegawai as p, cuti as c, ref_unit_kerjav2 as u, ref_instansi_userportal as i
  		where c.nip = p.nip
  		and p.fid_unit_kerja = u.id_unit_kerja
  		and u.fid_instansi_userportal = i.id_instansi 
  		and i.nip_user like '%$sess_nip%'");
  	return $q->num_rows();
  }

  function getjmlpengantarskpd()
  {
  	$sess_nip = $this->session->userdata('nip');
  	$q = $this->db->query("select cp.* from cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where cp.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and cp.fid_status in('1','2')");
  	return $q->num_rows();
  }

  function getjmlpengantar()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select cp.* from cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where cp.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%'");
    return $q->num_rows();
  }

  function getjmlpengantarbystatus($status)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select id_pengantar from cuti_pengantar where fid_status = '$status'");
    //$q=$this->db->select('id_pengantar')
             //->from('cuti_pengantar')
             //->where(array('fid_status' => $status));
    return $q->num_rows();
  }

  public function detailpengantar($idpengantar, $kelompok_cuti)
  {
  	//$q = $this->db->query("select * from cuti where fid_pengantar='$idpengantar'");
    $sess_nip = $this->session->userdata('nip');
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, c.tambah_hari_tunda, c.satuan_jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.tgl_usul, c.fid_pengantar, cp.fid_unit_kerja, cp.id_pengantar, c.fid_jns_cuti, c.fid_status from pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.fid_pengantar = cp.id_pengantar and c.fid_pengantar='$idpengantar' and cp.kelompok_cuti='$kelompok_cuti' order by c.thn_cuti desc, jc.id_jenis_cuti");
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, cp.id_pengantar, cp.fid_unit_kerja, u.nama_unit_kerja, c.tahun, c.jml_hari, c.tgl_usul, c.fid_pengantar, c.fid_status from pegawai as p, cuti_tunda as c, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and c.fid_pengantar = cp.id_pengantar and c.fid_pengantar='$idpengantar' and cp.kelompok_cuti='$kelompok_cuti' order by c.tahun desc");  
    }

  	return $q;
  }

  // tanpa paging
  /*public function tampilinbox()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, c.tambah_hari_tunda, c.satuan_jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.tgl_usul, c.fid_pengantar, cp.tgl_pengantar, cp.no_pengantar, c.fid_jns_cuti, c.fid_status from pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and  c.fid_status in ('3','4','5','6','7','8') order by c.fid_status, c.thn_cuti desc");
    return $q;
  }
  */

  // dengan  paging
  public function tampilinbox($number, $offset)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, c.tambah_hari_tunda, c.satuan_jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.tgl_usul, c.fid_pengantar, cp.tgl_pengantar, cp.no_pengantar, c.fid_jns_cuti, c.fid_status from pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.fid_status in ('3','4','5','6','7') and i.nip_user like '%$sess_nip%' order by p.nama, c.fid_status desc LIMIT $offset, $number");
    return $q;
  }

  public function jmltampilinbox()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, c.tambah_hari_tunda, c.satuan_jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.tgl_usul, c.fid_pengantar, cp.tgl_pengantar, cp.no_pengantar, c.fid_jns_cuti, c.fid_status from pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.fid_status in ('3','4','5','6','7') and i.nip_user like '%$sess_nip%'");
   return $q->num_rows();
  }

  public function detailproses($idpengantar, $kelompok_cuti)
  {
    //$q = $this->db->query("select * from cuti where fid_pengantar='$idpengantar'");
    $sess_nip = $this->session->userdata('nip');
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, c.thn_cuti, c.jml, c.satuan_jml, c.tambah_hari_tunda, c.satuan_jml, jc.nama_jenis_cuti, c.tgl_mulai, c.tgl_selesai, c.user_usul, c.tgl_usul, c.tgl_kirim_usul, c.fid_pengantar, cp.fid_unit_kerja, cp.id_pengantar, c.fid_jns_cuti, c.fid_status, c.qrcode from pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u where c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and p.fid_unit_kerja = u.id_unit_kerja and c.fid_pengantar = cp.id_pengantar and c.fid_pengantar='$idpengantar' and cp.kelompok_cuti='$kelompok_cuti' and cp.fid_status = '3' order by c.thn_cuti desc, jc.id_jenis_cuti");
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, cp.fid_unit_kerja, u.nama_unit_kerja, c.* from pegawai as p, cuti_tunda as c, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where c.nip = p.nip and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.fid_pengantar = cp.id_pengantar and c.fid_pengantar='$idpengantar' and cp.kelompok_cuti='$kelompok_cuti' order by c.tahun desc");  
    }

    return $q;
  }

  public function detailusul($nip, $idpengantar, $thn, $fid_jns)
  {
    //$q = $this->db->query("select * from cuti where fid_pengantar='$idpengantar'");
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, c.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, jc.nama_jenis_cuti, cp.no_pengantar, cp.tgl_pengantar FROM pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.fid_pengantar='".$idpengantar."' and c.nip='".$nip."' and c.thn_cuti='".$thn."' and c.fid_jns_cuti='".$fid_jns."' and i.nip_user like '%$sess_nip%' order by c.thn_cuti desc, jc.id_jenis_cuti");

    return $q;
  }

  /* // function sama dengan function detailusultunda dibawah
  public function detailusul_tunda($nip, $idpengantar)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, c.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, cp.no_pengantar, cp.tgl_pengantar FROM pegawai as p, cuti_tunda as c, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE c.nip = p.nip and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and c.fid_pengantar='".$idpengantar."' and c.nip='".$nip."' order by c.tahun desc");

    return $q;
  }
  */

  public function detailusultunda($nip, $idpengantar)
  {
    //$q = $this->db->query("select * from cuti where fid_pengantar='$idpengantar'");
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, c.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, cp.no_pengantar, cp.tgl_pengantar FROM pegawai as p, cuti_tunda as c, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE c.nip = p.nip and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and c.fid_pengantar='".$idpengantar."' and c.nip='".$nip."' order by c.tahun desc");

    return $q;
  }

  function getjmldetailpengantar($idpengantar, $kelompok_cuti)
  {
    //$sess_nip = $this->session->userdata('nip');
    if ($kelompok_cuti == 'CUTI LAINNYA') {
      $q = $this->db->query("select * from cuti where fid_pengantar='$idpengantar'");
      //$this->db->whare(array('fid_pengantar' => $idpengantar));
      //$q = $this->db->get('cuti');
    } else if ($kelompok_cuti == 'CUTI TUNDA') {
      $q = $this->db->query("select * from cuti_tunda where fid_pengantar='$idpengantar'");
      //$q = $this->db->get_whare('cuti_tunda', array('fid_pengantar' => $idpengantar)); 
    }
    
    return $q->num_rows();
  }

  // cek apakah nip pernah diusulkan dan status usulannya belum SELESAIBTL:9 atau SELESAITMS:10
  function cektelahusul($nip, $tahun, $kel)
  {    
    if ($kel == 'CUTI TUNDA') {
      $q = $this->db->query("select fid_pengantar from cuti_tunda where nip='".$nip."' and fid_status not in ('8', '9', '10') and tahun='".$tahun."'");  
    } else if ($kel == 'CUTI LAINNYA') {
      // cek apakah belum pernah mengambil CUTI TAHUNAN:1 atau CUTI BESAR:2 pada tahun $tahun
      $q = $this->db->query("select fid_pengantar from cuti where nip='".$nip."' and fid_status not in ('8', '9', '10') and thn_cuti='".$tahun."' and fid_jns_cuti in ('1', '2')");  
    }
    
    return $q->num_rows();
  }

  function cek_selainsetujubtltms($id_pengatar)
  {    
    $q = $this->db->query("select c.* from cuti as c, cuti_pengantar as cp, ref_statuscuti as sc where c.fid_pengantar = cp.id_pengantar and cp.id_pengantar = '".$id_pengatar."' and c.fid_status=sc.id_statuscuti and sc.nama_statuscuti not in ('TMS','BTL','CETAKSK')");    

    $jml = $q->num_rows();
    if ($jml == 0) {
      return true; // true : data tidak ditemukan
    } else {
      return false;
    }
  }

  function cek_selainsetujubtltms_tunda($id_pengantar)
  {    
    $q = $this->db->query("select c.fid_pengantar from cuti_tunda as c, cuti_pengantar as cp, ref_statuscuti as sc where c.fid_pengantar = cp.id_pengantar and cp.id_pengantar = '".$id_pengantar."' and c.fid_status=sc.id_statuscuti and sc.nama_statuscuti not in ('TMS','BTL','CETAKSK')");    

    $jml = $q->num_rows();
    if ($jml == 0) {
      return true; // true : data tidak ditemukan
    } else {
      return false;
    }
  }

  function input_pengantar($data){
    $this->db->insert('cuti_pengantar',$data);
    return true;
  }

  function input_usul($data){
    $this->db->insert('cuti',$data);
    return true;
  }

  function input_usulcutitunda($data){
    $this->db->insert('cuti_tunda',$data);
    return true;
  }

  function input_riwayatcuti($id_pengantar, $thn_cuti, $fid_status) {
    $q = $this->db->query("insert into riwayat_cuti(nip, fid_jns_cuti, thn_cuti, jml, satuan_jml, tambah_hari_tunda, tgl_mulai, tgl_selesai, alamat, no_sk, tgl_sk, pejabat_sk) select nip, fid_jns_cuti, thn_cuti, jml, satuan_jml, tambah_hari_tunda, tgl_mulai, tgl_selesai, alamat, no_sk, tgl_sk, pejabat_sk from cuti where fid_pengantar = '".$id_pengantar."' and thn_cuti='".$thn_cuti."' and fid_status='".$fid_status."'");

    return $q;
  }

  function input_riwayatcutitunda($id_pengantar, $fid_status) {
    $q = $this->db->query("insert into riwayat_cuti_tunda(nip, thn_cuti, jml, no_sk, tgl_sk, pejabat_sk) select nip, tahun, jml_hari, no_sk, tgl_sk, pejabat_sk from cuti_tunda where fid_pengantar = '".$id_pengantar."' and fid_status='".$fid_status."'");

    return $q;
  }

  function edit_usul($where, $data){
    $this->db->where($where);
    $this->db->update('cuti',$data);
    return true;
  }

  function edit_usultunda($where, $data){
    $this->db->where($where);
    $this->db->update('cuti_tunda',$data);
    return true;
  }

  function edit_pengantar($where, $data){
    $this->db->where($where);
    $this->db->update('cuti_pengantar',$data);
    return true;
  }

  function hapus_pengantar($where){
    $this->db->where($where);
    $this->db->delete('cuti_pengantar');
    return true;
  }

  function hapus_cuti($where){
    $this->db->where($where);
    $this->db->delete('cuti');
    return true;
  }

  function hapus_tunda($where){
    $this->db->where($where);
    $this->db->delete('cuti_tunda');
    return true;
  }

  function getnopengantar($id)
  {
    $sqlnop = mysql_query("select no_pengantar from cuti_pengantar WHERE id_pengantar='".$id."'");
    $nopengantar = mysql_result($sqlnop,0,'no_pengantar');       
    return $nopengantar;
  }

  function getkelompok($id)
  {
    $sqlnop = mysql_query("select kelompok_cuti from cuti_pengantar WHERE id_pengantar='".$id."'");
    $kelompok_cuti = mysql_result($sqlnop,0,'kelompok_cuti');       
    return $kelompok_cuti;
  }

  function getnopengantarbynip($nip, $tahun)
  {
    $sqlnop = mysql_query("select cp.no_pengantar from cuti_pengantar as cp, cuti as c WHERE c.fid_pengantar = cp.id_pengantar and c.nip='".$nip."' and c.thn_cuti='".$tahun."'");
    $nopengantar = mysql_result($sqlnop,0,'no_pengantar');       
    return $nopengantar;
  }

  function gettglpengantarbynip($nip, $tahun)
  {
    $sqltglp = mysql_query("select cp.tgl_pengantar from cuti_pengantar as cp, cuti as c WHERE c.fid_pengantar = cp.id_pengantar and c.nip='".$nip."' and c.thn_cuti='".$tahun."'");
    $tglpengantar = mysql_result($sqltglp,0,'tgl_pengantar');       
    return $tglpengantar;
  }

  function gettglpengantar($id)
  {
    $sqltglp = mysql_query("select tgl_pengantar from cuti_pengantar WHERE id_pengantar='".$id."'");
    $tglpengantar = mysql_result($sqltglp,0,'tgl_pengantar');       
    return $tglpengantar;
  }

  public function jnscuti()
  {
    $q = $this->db->query("select * from ref_jenis_cuti ORDER BY id_jenis_cuti");    
    return $q;    
  }

  public function cetakusulcuti($nip, $tahun, $fid_jns_cuti, $fid_pengantar)
  {
    $q = $this->db->query("select p.nip, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja, c.*, cp.tgl_pengantar from cuti as c, cuti_pengantar as cp, pegawai as p where p.nip=c.nip and c.fid_pengantar='".$fid_pengantar."' and cp.id_pengantar=c.fid_pengantar and c.nip='".$nip."' and c.thn_cuti='".$tahun."' and c.fid_jns_cuti='".$fid_jns_cuti."'");    
    return $q;    
  }

  public function cetakskcuti($nip, $tahun, $fid_jns_cuti, $fid_pengantar)
  {
    $q = $this->db->query("select p.nip, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja, e.nama_eselon, c.*, cp.tgl_pengantar from cuti as c, cuti_pengantar as cp, pegawai as p, ref_eselon as e where p.fid_eselon=e.id_eselon and p.nip=c.nip and c.fid_pengantar='".$fid_pengantar."' and cp.id_pengantar=c.fid_pengantar and c.nip='".$nip."' and c.thn_cuti='".$tahun."' and c.fid_jns_cuti='".$fid_jns_cuti."'");    
    return $q;    
  }

  public function cetakskcuti_tunda($nip, $tahun, $fid_pengantar)
  {
    // fid_unkerpeg diambil dari tabel pegawai untuk unit kerja pegawai, cp.fid_unit_kerja untuk surat pengantar
    $q = $this->db->query("select p.nip, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja as 'fid_unkerpeg', e.nama_eselon, c.*, cp.* from cuti_tunda as c, cuti_pengantar as cp, pegawai as p, ref_eselon as e where p.fid_eselon=e.id_eselon and p.nip=c.nip and c.fid_pengantar=cp.id_pengantar and c.fid_pengantar='".$fid_pengantar."' and c.nip='".$nip."' and c.tahun='".$tahun."'");    
    return $q;    
  }

  public function cetakpengantar($id, $tgl, $id_unker)
  {
    $q = $this->db->query("select p.nip, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, cp.fid_unit_kerja, cp.*, c.tgl_mulai, c.tgl_selesai, c.fid_jns_cuti, c.jml, c.tambah_hari_tunda, c.satuan_jml, rs.nip as 'nip_spesimen', rs.status, rs.jabatan_spesimen from cuti as c, pegawai as p, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_spesimen as rs where p.nip=c.nip and c.fid_pengantar=cp.id_pengantar and cp.fid_unit_kerja=u.id_unit_kerja and cp.id_pengantar='".$id."' and cp.tgl_pengantar='".$tgl."' and cp.fid_unit_kerja='".$id_unker."' and rs.fid_unit_kerja = u.id_unit_kerja");    
    return $q;    
  }

  public function cetakpengantartunda($id, $tgl, $id_unker)
  {
    $q = $this->db->query("select p.nip, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, cp.fid_unit_kerja, cp.*, c.*, rs.nip as 'nip_spesimen', rs.status, rs.jabatan_spesimen from cuti_tunda as c, pegawai as p, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_spesimen as rs where p.nip=c.nip and c.fid_pengantar=cp.id_pengantar and cp.fid_unit_kerja=u.id_unit_kerja and cp.id_pengantar='".$id."' and cp.tgl_pengantar='".$tgl."' and cp.fid_unit_kerja='".$id_unker."' and rs.fid_unit_kerja = u.id_unit_kerja");    
    return $q;    
  }

  function getstatuscuti($id)
  {
    $sqlsc = mysql_query("select nama_statuscuti from ref_statuscuti WHERE id_statuscuti='".$id."'");
    $nama_sc = mysql_result($sqlsc,0,'nama_statuscuti');       
    return $nama_sc;
  }

  function getstatuspengantarcuti($id)
  {
    $sqlspc = mysql_query("select nama_statuspengantarcuti from ref_statuspengantarcuti WHERE id_statuspengantarcuti='".$id."'");
    $nama_spc = mysql_result($sqlspc,0,'nama_statuspengantarcuti');       
    return $nama_spc;
  }

  function getstatuspengantar_byidpengantar($idpengantar)
  {
    $sqlspc = mysql_query("select spc.nama_statuspengantarcuti from ref_statuspengantarcuti as spc, cuti_pengantar as cp WHERE cp.id_pengantar='".$idpengantar."' and cp.fid_status = spc.id_statuspengantarcuti");
    $nama_spc = mysql_result($sqlspc,0,'nama_statuspengantarcuti');       
    return $nama_spc;
  }

  function getnamajeniscuti($id)
  {
    if ($id != '') {
      $sqljc = mysql_query("select nama_jenis_cuti from ref_jenis_cuti WHERE id_jenis_cuti='".$id."'");
      $nama_jc = mysql_result($sqljc,0,'nama_jenis_cuti');       
      return $nama_jc;
    }
  }

  public function cariupdatestatus($nip)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, c.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, jc.nama_jenis_cuti, cp.no_pengantar, cp.tgl_pengantar FROM pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.nip='".$nip."' order by c.thn_cuti desc, jc.id_jenis_cuti");

    return $q;
  }

  public function statuscuti()
  {
    $q = $this->db->query("select * from ref_statuscuti ORDER BY nama_statuscuti");    
    return $q;    
  }

  public function cariupdatestatustunda($nip)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, c.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, cp.no_pengantar, cp.tgl_pengantar FROM pegawai as p, cuti_tunda as c, cuti_pengantar as cp, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE c.nip = p.nip and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.nip='".$nip."' order by c.tahun desc");

    return $q;
  }

  public function gettahuncuti()
  {
    $q = $this->db->query("select thn_cuti from cuti GROUP BY thn_cuti");    
    return $q;    
  }

  public function carirekap($idunker, $thn)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, p.fid_jnsjab, 
p.fid_jabatan, p.fid_jabfu, p.fid_jabft, c.fid_jns_cuti, c.jml, c.satuan_jml, c.tgl_mulai, c.tgl_selesai, c.fid_status,
c.tambah_hari_tunda, c.fid_pengantar, c.thn_cuti, c.tgl_proses
FROM pegawai as p left join cuti as c on c.nip=p.nip and c.thn_cuti = '".$thn."', ref_unit_kerjav2 as u
WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_eselon");

    return $q;
  }

  public function gettahunrwycuti()
  {
    $q = $this->db->query("select thn_cuti from riwayat_cuti WHERE thn_cuti >= '2017' GROUP BY thn_cuti");    
    return $q;    
  }

  function getjmlrwybythnstatus($thn, $fid_status)
  {
    $q = $this->db->query("select * from riwayat_cuti where thn_cuti='$thn' and fid_jns_cuti='$fid_status'");
    
    return $q->num_rows();
  }

  function getjmlrwytahunanplustunda($thn)
  {
    $q = $this->db->query("select * from riwayat_cuti where thn_cuti='$thn' and tambah_hari_tunda != 0");
    
    return $q->num_rows();
  }

  function getjmlrwytunda($thn)
  {
    $q = $this->db->query("select * from riwayat_cuti_tunda where thn_cuti='$thn'");
    
    return $q->num_rows();
  }

  function getjmlprosesbystatus($status, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    //$q = $this->db->query("select nip from cuti where fid_status = '$status' and thn_cuti = '$thn'");
    //return $q->num_rows();

    $q = $this->db->query("select nip from cuti where fid_status = '$status' and thn_cuti = '$thn'");
    $jmlcuti = $q->num_rows();

    $q = $this->db->query("select nip from cuti_tunda where fid_status = '$status' and tahun = '$thn'");
    $jmlcutitunda = $q->num_rows();

    return $jmlcuti+$jmlcutitunda;
  }

  function getjmlprosesbystatuscuti($status, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select nip from cuti where fid_status = '$status' and thn_cuti = '$thn'");
    return $q->num_rows();
  }

  function getjmlprosesbystatuscutitunda($status, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select nip from cuti_tunda where fid_status = '$status' and tahun = '$thn'");
    return $q->num_rows();
  }

  public function getjmlprosesbystatusgraphcuti()
  {
    //$data = $this->db->query("select sc.nama_statuscuti, COUNT(c.nip) as jumlah from ref_statuscuti as sc, cuti_tunda as c where c.fid_status = sc.id_statuscuti and sc.nama_statuscuti in ('INBOXSKPD', 'CETAKUSUL', 'INBOXBKPPD', 'CETAKSK') group by sc.id_statuscuti");

    $data = $this->db->query("select nama_statuscuti from ref_statuscuti where nama_statuscuti in ('INBOXSKPD', 'CETAKUSUL', 'INBOXBKPPD', 'CETAKSK')");
    return $data->result();
  }

  public function getjmlrwyperbulan()
  {
    $query = $this->db->query("select MONTH(tgl_mulai), count(nip) as 'jumlah' from riwayat_cuti where thn_cuti = '2022' group by MONTH(tgl_mulai) order by MONTH(tgl_mulai)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  function getjmlharitahunan($thn, $nip)
  {
    $qgetjml = $this->db->query("select sum(jml) as 'jml' from riwayat_cuti WHERE nip='".$nip."' and thn_cuti='".$thn."' and fid_jns_cuti='1' group by nip");

    if ($qgetjml->num_rows()>0)
    {
      $row=$qgetjml->row();
      $jml = $row->jml;
      return $jml;
    }
  }

  function getjmltundathn($thn, $nip)
  {
    $qgetjml = $this->db->query("select jml from riwayat_cuti_tunda WHERE nip='".$nip."' and thn_cuti='".$thn."'");

    if ($qgetjml->num_rows()>0)
    {
      $row=$qgetjml->row();
      $jml = $row->jml;
      return $jml;
    }
  }

  function getatasanlangsung($idunker)
  {
    $unker = $this->munker->getnamaunker($idunker);
    if ($this->munker->getnamaunker($idunker) == 'INSPEKTORAT') {
      $jabatan = 'Inspektur;';
    } else if ($unker == 'SEKRETARIAT DAERAH') {
      $jabatan = 'ATASAN LANGSUNG';
    } else if ($unker == 'SEKRETARIAT DPRD') {
      $jabatan = 'Sekretaris DPRD,';
    } else if ($unker == 'SEKRETARIAT KOMISI PEMILIHAN UMUM') {
      $jabatan = 'Sekretaris KPU Kabupaten Balangan,';
    } else if ($unker == 'RUMAH SAKIT UMUM DAERAH BALANGAN') {
      $jabatan = 'Atasan Langsung,';
    } else if ($unker == 'KECAMATAN PARINGIN') {
      $jabatan = 'Camat Paringin,';
    } else if ($unker == 'KECAMATAN PARINGIN SELATAN') {
      $jabatan = 'Camat Paringin Selatan,';
    } else if ($unker == 'KECAMATAN BATUMANDI') {
      $jabatan = 'Camat Batumandi,';
    } else if ($unker == 'KECAMATAN LAMPIHONG') {
      $jabatan = 'Camat Lampihong,';
    } else if ($unker == 'KECAMATAN JUAI') {
      $jabatan = 'Camat Juai,';
    } else if ($unker == 'KECAMATAN HALONG') {
      $jabatan = 'Camat Halong,';
    } else if ($unker == 'KECAMATAN AWAYAN') {
      $jabatan = 'Camat Awayan,';
    } else if ($unker == 'KECAMATAN TEBING TINGGI') {
      $jabatan = 'Camat Tebing Tinggi,';
    } else if ($unker == 'KELURAHAN BATU PIRING') {
      $jabatan = 'Camat Paringin Selatan,';
    } else if ($unker == 'KELURAHAN PARINGIN KOTA') {
      $jabatan = 'Camat Paringin,';
    } else if ($unker == 'KELURAHAN PARINGIN TIMUR') {
      $jabatan = 'Camat Paringin,';
    } else if (($unker == 'PUSKESMAS PARINGIN') OR ($unker == 'PUSKESMAS PARINGIN SELATAN') OR ($unker == 'PUSKESMAS JUAI') OR ($unker == 'PUSKESMAS HALONG') OR ($unker == 'PUSKESMAS UREN') OR ($unker == 'PUSKESMAS PIRSUS II JUAI') OR ($unker == 'PUSKESMAS BATUMANDI') OR ($unker == 'PUSKESMAS LOKBATU') OR ($unker == 'LAMPIHONG') OR ($unker == 'PUSKESMAS TANAH HABANG') OR ($unker == 'PUSKESMAS AWAYAN') OR ($unker == 'PUSKESMAS TEBING TINGGI')) {
      $jabatan = 'KEPALA DINAS KESEHATAN,';
    } else {
      //$jabatan = 'KEPALA '.$unker;
	$jabatan = 'ATASAN LANGSUNG';
    }

    return $jabatan;
  }

  public function jml_cuti_tahun_sebelumnya($thn, $nip)
  {
    $q = $this->db->select('SUM(jml) AS jml_hari')
                  ->from('riwayat_cuti')
                  ->where(array('thn_cuti' => $thn, 'nip' => $nip, 'fid_jns_cuti' => '1'))
                  ->get();
    if($q->num_rows() > 0)
    {
      $rows = $q->result();
      foreach($rows as $row){
        $jml = $row->jml_hari;
        if($jml != '')
        {
          $count = $jml;
        }
        else
        {
          $count = 0;
        }
      }
    }
    
    return $count;
  }

  public function jml_cuti_tahun_sekarang($thn, $nip)
  {
    $q = $this->db->select('SUM(jml) AS jml_hari, thn_cuti')
                  ->from('riwayat_cuti')
                  ->where(array('thn_cuti' => $thn, 'nip' => $nip, 'fid_jns_cuti' => '1'))
                  ->get();
    if($q->num_rows() > 0){
      $rows = $q->result();
      foreach($rows as $row){
        $jml = $row->jml_hari;
        if($jml != '')
        {
          $count = $jml;
        }
        else
        {
          $count = 0;
        }
      }
      return $count;
    }
  }
  
  /* 
  * RIWAYAT CUTI FOR CETAK PDF SK CUTI 
  */
  public function get_riwayat_cuti($tbl, $thn, $nip, $jenis) 
  {

    if($tbl == 'cuti'){
        $status_usulan = "AND rc.fid_status != '10' AND rc.fid_status != '9'";
		$status_usul   = ', rc.fid_status';
		$status_us	   = "AND rc.fid_status != '8' AND rc.fid_status != '3'";
    } else {
        $status_usulan = '';
		$status_usul   = '';
		$status_us	   = '';
    }
    
    

    //Query Mysql (per NIP, per Tahun, per Jenis Cuti)
    $q = $this->db->query("
    SELECT SUM(rc.jml) AS jml_hari,
    rc.satuan_jml, rc.thn_cuti, rj.nama_jenis_cuti $status_usul
    FROM `$tbl` AS rc, ref_jenis_cuti AS rj
    WHERE rc.fid_jns_cuti = rj.id_jenis_cuti
    AND rc.thn_cuti = '$thn'
    AND rc.fid_jns_cuti $jenis
    AND rc.nip = '$nip'
    $status_usulan
    $status_us
    GROUP BY rc.fid_jns_cuti, rc.satuan_jml $status_usul
    ");

    if($q->num_rows() > 0){
      $rows = $q->row();
      
      //RESULT JUMLAH HARI
      if($rows->jml_hari != 0) {
        $jml = $rows->jml_hari." ".$rows->satuan_jml;
      } else {
        $jml = " ";
      }

      //PARSING DATA ARRAY KE CETAK SK CUTI
      $dataresult = array(
        'jml_cuti' => $jml,
        'jenis' => $rows->nama_jenis_cuti,
        'tahun' => $thn,
        'satuan_jml' => $rows->satuan_jml
      );
      return $dataresult;
    }
  } 
  
  // START KHUSUS ADMIN, Update Pengatar dan Usul Cuti
  public function admin_tampilupdatepengantar()
  {    
    // tampilkan semua pengantar cuti dengan id_status 1:SKPD, 2:CETAK, 3:BKPPD 
    $q = $this->db->query("select cp.* from cuti_pengantar as cp, ref_unit_kerjav2 as u where cp.fid_unit_kerja = u.id_unit_kerja and cp.fid_status in ('1','2', '3') order by cp.fid_status, cp.tgl_pengantar");
    return $q;
  }

  function getjml_tampilupdatepengantar()
  {
    $q = $this->db->query("select cp.* from cuti_pengantar as cp, ref_unit_kerjav2 as u where cp.fid_unit_kerja = u.id_unit_kerja and cp.fid_status in ('1','2', '3')");
    return $q->num_rows();
  }

  public function admin_detailpengantar($idpengantar, $tglpengantar)
  {
        $q = $this->db->query("select * from cuti_pengantar where id_pengantar = '".$idpengantar."' and tgl_pengantar = '".$tglpengantar."'");
    return $q;
  }

  public function statuspengantar()
  {
    $q = $this->db->query("select * from ref_statuspengantarcuti");    
    return $q;    
  }

  public function cariupdateusul($nip, $thn)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, c.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, jc.nama_jenis_cuti, cp.no_pengantar, cp.tgl_pengantar FROM pegawai as p, cuti as c, cuti_pengantar as cp, ref_jenis_cuti as jc, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE c.nip = p.nip and c.fid_jns_cuti = jc.id_jenis_cuti and c.fid_pengantar = cp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and c.nip='".$nip."' and c.thn_cuti='".$thn."' order by c.thn_cuti desc, jc.id_jenis_cuti");

    return $q;
  }
  // END KHUSUS ADMIN, Update Pengatar dan Usul Cuti
  
}
