<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manjab extends CI_Model {

public function __construct()
{
parent::__construct();
}

public function getdatamaster($table){
    $nip = $this->session->userdata('nip');
    $sql = "SELECT t.id_aj_syaratjab,t.skp,t.fid_jabesl2,t.fid_jabesl3,t.fid_jabesl4, ja.id_jabatan, ja.nama_jabatan, jb.id_jabatan, jb.nama_jabatan, jc.id_jabatan, jc.nama_jabatan,t.fid_unit_kerja, t.fid_jenis_jabatan, t.fid_jabstruk, t.fid_jabft, t.fid_jabfu, t.kelas_jabatan, t.n_jabatan, t.fid_golru, t.pendidikan, t.total_jp_diklat, t.jml_cuti_sakit, t.fid_tingkat_pendidikan, j.id_jabatan, j.nama_jabatan, j.fid_eselon, u.id_unit_kerja, u.nama_unit_kerja, g.id_golru,g.nama_golru,g.nama_pangkat, ju.id_jabfu, ju.nama_jabfu, jt.id_jabft,jt.nama_jabft, jjb.id_jenis_jabatan, jjb.nama_jenis_jabatan,if(t.fid_jabesl4=jc.id_jabatan,jc.nama_jabatan,'') AS eselon4,
    if(t.fid_jabesl3=jb.id_jabatan,jb.nama_jabatan,'') AS eselon3,if(t.fid_jabesl2=ja.id_jabatan,ja.nama_jabatan,'') AS eselon2,i.id_instansi,up.nip,i.nip_user, tp.id_tingkat_pendidikan, tp.nama_tingkat_pendidikan
      FROM $table t 
            LEFT JOIN ref_jabstruk AS j
                ON t.fid_jabstruk=j.id_jabatan
            LEFT JOIN ref_jabstruk AS ja 
              ON t.fid_jabesl2=ja.id_jabatan
            LEFT JOIN ref_jabstruk AS jb 
              ON t.fid_jabesl3=jb.id_jabatan
            LEFT JOIN ref_jabstruk AS jc 
              ON t.fid_jabesl4=jc.id_jabatan                  
            LEFT JOIN ref_unit_kerjav2 AS u 
                ON t.fid_unit_kerja=u.id_unit_kerja 
            JOIN ref_instansi_userportal i
                ON u.fid_instansi_userportal = i.id_instansi
            JOIN userportal up 
                ON up.nip='$nip'                  
            LEFT JOIN ref_golru AS g
                ON t.fid_golru=g.id_golru
            LEFT JOIN ref_jabfu AS ju 
                ON t.fid_jabfu=ju.id_jabfu 
            LEFT JOIN ref_jabft AS jt 
                ON t.fid_jabft=jt.id_jabft 
            LEFT JOIN ref_jenis_jabatan AS jjb
              ON t.fid_jenis_jabatan=jjb.id_jenis_jabatan
            LEFT JOIN ref_tingkat_pendidikan AS tp 
              ON t.fid_tingkat_pendidikan=tp.id_tingkat_pendidikan
            WHERE i.nip_user like '%$nip%'  
            GROUP BY t.id_aj_syaratjab DESC";

    
	return $this->db->query($sql);
}

public function getunker($table) {
    $nip = $this->session->userdata('nip');
    $sql = "select u.nama_unit_kerja, u.id_unit_kerja
            from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
            WHERE
            u.fid_instansi_userportal = i.id_instansi
            and up.nip = '$nip'
            and i.nip_user like '%$nip%' order by u.id_unit_kerja";
    return $this->db->query($sql);
}

public function getjabstruk($id) {

    $sql = "SELECT * FROM ref_jabstruk j 
    		LEFT JOIN ref_unit_kerjav2 u 
    		ON j.fid_unit_kerja=u.id_unit_kerja
    		WHERE j.fid_unit_kerja='$id'
    		ORDER BY j.id_jabatan";
    return $this->db->query($sql);
}

public function m_p_insert($data,$table){
	  $this->db->insert($table,$data);
}

public function m_p_insert_sensus($data,$table){
    $this->db->insert($table,$data);
}

public function m_p_insert_pns($data,$table){
    $this->db->insert($table,$data);
}

public function m_p_update($whr,$data,$table){
    $this->db->where($whr);
    $this->db->update($table,$data);
}

public function m_p_update_pemangku($whr,$data,$table){
    $this->db->where($whr);
    $this->db->update($table,$data);
}


public function getJfu($table) {
    $sql = "SELECT * FROM $table ORDER BY nama_jabfu DESC";
    return $this->db->query($sql);
}

public function getJft($table) {
    $sql = "SELECT * FROM $table ORDER BY nama_jabft DESC";
    return $this->db->query($sql);
}


public function getJs_sensus($table,$ids){
    $sql = "SELECT j.id_jabatan, j.nama_jabatan, u.id_unit_kerja, u.nama_unit_kerja, j.fid_unit_kerja 
            FROM $table j, ref_unit_kerjav2 u 
            WHERE j.fid_unit_kerja=u.id_unit_kerja 
            AND j.fid_unit_kerja LIKE '%$ids'
            ORDER BY j.fid_unit_kerja";
    return $this->db->query($sql);
}

public function getJfu_sensus($table) {
    $sql = "SELECT * FROM $table ORDER BY nama_jabfu";
    return $this->db->query($sql);
}

public function getJft_sensus($table) {
    $sql = "SELECT * FROM $table ORDER BY nama_jabft";
    return $this->db->query($sql);
}


public function getGolru($table) {
    $sql = "SELECT * FROM ref_golru ORDER BY id_golru DESC";
    return $this->db->query($sql);
}

public function hapusdatatable($where,$table){
	$this->db->where($where);
	$this->db->delete($table);
// 	$sql = "DELETE FROM $table WHERE aj_syaratjab = '$where'";
// 	return $this->db->query($sql);
// }
}

public function hapusdatasensus($where,$table){
    $this->db->where($where);
    $this->db->delete($table);
}

public function hapusdatalaporan($where,$table){
    $this->db->where_in('id_aj_syaratjab_analisis', $where);
    $this->db->delete($table);
}


public function esl2($table, $id){
    $sql = "SELECT * FROM $table j 
            JOIN ref_eselon e 
            ON j.fid_eselon=e.id_eselon 
            WHERE e.nama_eselon 
            IN ('II/a','II/b') AND j.fid_unit_kerja='$id' ORDER BY j.fid_eselon";
    return $this->db->query($sql);
}

public function esl3($table, $id){
    $sql = "SELECT * FROM $table j 
            JOIN ref_eselon e 
            ON  j.fid_eselon=e.id_eselon  
            WHERE e.nama_eselon 
            IN ('III/a','III/b') AND j.fid_unit_kerja='$id' ORDER BY j.fid_eselon";
    return $this->db->query($sql);
}

public function esl4($table, $id){
    $sql = "SELECT * FROM $table j 
            JOIN ref_eselon e 
            ON j.fid_eselon=e.id_eselon 
            WHERE e.nama_eselon 
            IN ('IV/a','IV/b') AND j.fid_unit_kerja='$id' ORDER BY j.fid_eselon";
    return $this->db->query($sql);
}

public function m_pendidikan($table) {
    $sql = "SELECT * FROM $table GROUP BY nama_jurusan_pendidikan";
    return $this->db->query($sql);
}

public function t_pendidikan($table) {
    $sql = "SELECT * FROM $table GROUP BY id_tingkat_pendidikan";
    return $this->db->query($sql);
}

public function ambilId($table, $where){
    return $this->db->get_where($table,$where);
}

public function ambil_pemangku($table, $where){
    return $this->db->get_where($table,$where);
}

public function get_eselon_2($table, $id){
    return $this->db->query("SELECT * FROM $table j 
            JOIN ref_eselon e 
            ON j.fid_eselon=e.id_eselon 
            WHERE e.nama_eselon 
            IN ('IV/a','IV/b') AND j.fid_unit_kerja='$id' ORDER BY j.fid_eselon");
}

public function getkata($search){
  // $this->db->select("nip,nama");
  // $whereCondition = array('nip' =>$search);
  // $this->db->where($whereCondition);
  // $this->db->from('pegawai');
  // $query = $this->db->get();
  
  $query = $this->db->query("SELECT nip,nama FROM pegawai WHERE nip LIKE '%".$search."%'");
  return $query->result();
 }

// public function getnip($whr){
//   $sql= "SELECT p.nip, p.nama, p.gelar_depan, p.gelar_belakang, p.tgl_lahir, p.fid_unit_kerja, u.id_unit_kerja, u.nama_unit_kerja FROM pegawai AS p LEFT JOIN ref_unit_kerjav2 u ON p.fid_unit_kerja=u.id_unit_kerja
//                             WHERE p.nip='$whr' ORDER BY p.nip";
  
//   $query = $this->db->query($sql);
//   return $query;
// }

public function eselon2($table){
    $nip_pns = $this->session->userdata('nip');
    $sql = "SELECT * FROM $table AS j 
            JOIN ref_eselon AS e 
              ON j.fid_eselon=e.id_eselon 
            JOIN ref_unit_kerjav2 AS u 
              ON j.fid_unit_kerja=u.id_unit_kerja
            JOIN ref_instansi_userportal AS i
              ON u.fid_instansi_userportal = i.id_instansi
            JOIN userportal AS up 
              ON up.nip='$nip_pns'
            WHERE e.nama_eselon 
            IN ('II/a','II/b') AND i.nip_user LIKE '%$nip_pns%' ORDER BY j.fid_eselon";
    return $this->db->query($sql);
}

public function eselon3($table){
    $nip_pns = $this->session->userdata('nip');
    $sql = "SELECT * FROM $table AS j 
            JOIN ref_eselon AS e 
              ON j.fid_eselon=e.id_eselon 
            JOIN ref_unit_kerjav2 AS u 
              ON j.fid_unit_kerja=u.id_unit_kerja
            JOIN ref_instansi_userportal AS i
              ON u.fid_instansi_userportal = i.id_instansi
            JOIN userportal AS up 
              ON up.nip='$nip_pns'
            WHERE e.nama_eselon 
            IN ('III/a','III/b') AND i.nip_user LIKE '%$nip_pns%' ORDER BY j.fid_eselon";
    return $this->db->query($sql);
}

public function eselon4($table){
    $nip_pns = $this->session->userdata('nip');
    $sql = "SELECT * FROM $table AS j 
            JOIN ref_eselon AS e 
              ON j.fid_eselon=e.id_eselon 
            JOIN ref_unit_kerjav2 AS u 
              ON j.fid_unit_kerja=u.id_unit_kerja
            JOIN ref_instansi_userportal AS i
              ON u.fid_instansi_userportal = i.id_instansi
            JOIN userportal AS up 
              ON up.nip='$nip_pns'
            WHERE e.nama_eselon 
            IN ('IV/a','IV/b') AND i.nip_user LIKE '%$nip_pns%' ORDER BY j.fid_eselon";
    return $this->db->query($sql);
}

 public function get_pegawai(){
    $nip = $this->session->userdata('nip');
    $sql = "SELECT p.nip,p.nama,p.fid_unit_kerja, u.id_unit_kerja AS idunker, u.nama_unit_kerja
            FROM pegawai p 
            JOIN ref_unit_kerjav2 u 
                ON p.fid_unit_kerja=u.id_unit_kerja
            JOIN ref_instansi_userportal i
                ON u.fid_instansi_userportal = i.id_instansi
            JOIN userportal up 
                ON up.nip='$nip'  
            WHERE i.nip_user like '%$nip%'
            ORDER BY p.fid_unit_kerja";
    return $this->db->query($sql);
 }


 public function ambildatapeg($table, $where){
   $sql = "SELECT t.nip AS nip_pns, t.nama, t.fid_jnsjab, t.fid_unit_kerja, t.fid_jabft, t.fid_jabfu, t.fid_jabatan, t.fid_golru_skr, t.fid_jurusan_pendidikan, t.fid_tingkat_pendidikan, u.id_unit_kerja, u.nama_unit_kerja, jj.id_jenis_jabatan, jj.nama_jenis_jabatan, jt.id_jabft, jf.id_jabfu, js.id_jabatan, js.nama_jabatan, g.id_golru, g.nama_golru, g.nama_pangkat, jp.id_jurusan_pendidikan, jp.nama_jurusan_pendidikan, tp.id_tingkat_pendidikan, tp.nama_tingkat_pendidikan, rs.nip, rs.nilai_skp, rs.tahun, rc.nip, rc.jml, rc.satuan_jml, rc.fid_jns_cuti, rc.thn_cuti, rd.lama_jam 
          FROM $table AS t 
          LEFT JOIN ref_jenis_jabatan AS jj
            ON t.fid_jnsjab=jj.id_jenis_jabatan
          LEFT JOIN ref_unit_kerjav2 u
            ON t.fid_unit_kerja=u.id_unit_kerja
          LEFT JOIN ref_jabfu jf 
            ON t.fid_jabfu=jf.id_jabfu
          LEFT JOIN ref_jabft jt 
            ON t.fid_jabft=jt.id_jabft
          LEFT JOIN ref_jabstruk js 
            ON t.fid_jabatan=js.id_jabatan
          LEFT JOIN ref_golru g 
            ON t.fid_golru_skr=g.id_golru
          LEFT JOIN ref_jurusan_pendidikan jp 
            ON t.fid_jurusan_pendidikan=jp.id_jurusan_pendidikan
          LEFT JOIN ref_tingkat_pendidikan tp 
            ON t.fid_tingkat_pendidikan=tp.id_tingkat_pendidikan
          LEFT JOIN riwayat_skp AS rs 
            ON t.nip=rs.nip AND rs.tahun='2017'
          LEFT JOIN riwayat_cuti AS rc
            ON t.nip=rc.nip AND rc.fid_jns_cuti='3' AND rc.thn_cuti='2017'
          LEFT JOIN riwayat_diklat_teknis AS rd
            ON t.nip=rd.nip
          WHERE t.nip='$where'
          ORDER BY t.nip";
   return $this->db->query($sql);
 }


public function ambil_nama_jabatan($table){
    $nip = $this->session->userdata('nip');
    $sql = "SELECT t.n_jabatan, t.id_aj_syaratjab 
            FROM $table AS t 
            JOIN ref_unit_kerjav2 u 
                ON t.fid_unit_kerja=u.id_unit_kerja
            JOIN ref_instansi_userportal i
                ON u.fid_instansi_userportal = i.id_instansi
            JOIN userportal up 
                ON up.nip='$nip'  
            WHERE i.nip_user like '%$nip%'            
            ORDER BY t.id_aj_syaratjab";
    return $this->db->query($sql);
}

public function get_data_sensus($sensus){
  $sesi = $this->session->userdata('nama');
   $sql2 = "SELECT t.nip,t.aj_syaratjab_sensus,t.fid_unit_kerja,u.id_unit_kerja,u.nama_unit_kerja AS unker,t.fid_jenis_jabatan,t.fid_jabstruk,t.fid_jabfu,t.fid_jabft, t.kelas_jabatan,t.skp,t.total_jp_diklat AS jp_diklat, t.jml_cuti_sakit, p.nip AS nip_p,p.nama,q.id_jenis_jabatan,q.nama_jenis_jabatan,jb.id_jabatan,jb.nama_jabatan AS nama_jab,rj.id_jabfu,rj.nama_jabfu, jt.id_jabft, jt.nama_jabft, rtp.nama_tingkat_pendidikan AS tingpen, t.fid_tingkat_pendidikan, rtp.id_tingkat_pendidikan, rjp.nama_jurusan_pendidikan AS jurusan, t.fid_jurusan_pendidikan, rjp.id_jurusan_pendidikan,t.n_jabatan,ajs.n_jabatan AS n_jab, ajs.id_aj_syaratjab,if(t.fid_jabesl4=jc.id_jabatan,jc.nama_jabatan,'') AS eselon4,
    if(t.fid_jabesl3=jbq.id_jabatan,jbq.nama_jabatan,'') AS eselon3,if(t.fid_jabesl2=ja.id_jabatan,ja.nama_jabatan,'') AS eselon2, ja.id_jabatan, ja.nama_jabatan, jbq.id_jabatan, jbq.nama_jabatan, jc.id_jabatan, jc.nama_jabatan 
           FROM aj_syaratjab_sensus AS t
           LEFT JOIN ref_unit_kerjav2 AS u 
            ON t.fid_unit_kerja=u.id_unit_kerja
           LEFT JOIN pegawai AS p 
            ON t.nip=p.nip 
           LEFT JOIN ref_jenis_jabatan AS q
            ON t.fid_jenis_jabatan=q.id_jenis_jabatan
           LEFT JOIN ref_jabstruk AS jb 
            ON t.fid_jabstruk=jb.id_jabatan
          LEFT JOIN ref_jabstruk AS ja 
            ON t.fid_jabesl2=ja.id_jabatan
          LEFT JOIN ref_jabstruk AS jbq 
            ON t.fid_jabesl3=jbq.id_jabatan
          LEFT JOIN ref_jabstruk AS jc 
            ON t.fid_jabesl4=jc.id_jabatan              
           LEFT JOIN ref_jabfu AS rj 
            ON t.fid_jabfu=rj.id_jabfu
           LEFT JOIN ref_jabft AS jt 
            ON t.fid_jabft=jt.id_jabft
           LEFT JOIN ref_tingkat_pendidikan AS rtp 
            ON t.fid_tingkat_pendidikan=rtp.id_tingkat_pendidikan
           LEFT JOIN ref_jurusan_pendidikan AS rjp 
            ON t.fid_jurusan_pendidikan=rjp.id_jurusan_pendidikan
           LEFT JOIN aj_syaratjab AS ajs
            ON t.n_jabatan=ajs.id_aj_syaratjab
           WHERE t.created_by='$sesi'
           ORDER BY t.aj_syaratjab_sensus DESC";
   return $this->db->query($sql2);
}


//MODEL HALAMAN HASIL ANALISI JABATAN
public function get_pns(){
  $nip = $this->session->userdata('nip');
  $sql = "SELECT a.nip, p.nama AS nama_pns, a.n_jabatan, a.fid_unit_kerja, u.id_unit_kerja, u.nama_unit_kerja AS unker 
          FROM aj_syaratjab_sensus AS a
          LEFT JOIN pegawai p 
            ON a.nip=p.nip
          LEFT JOIN ref_unit_kerjav2 u 
            ON a.fid_unit_kerja=u.id_unit_kerja
          JOIN ref_instansi_userportal i
            ON u.fid_instansi_userportal = i.id_instansi
          JOIN userportal up 
            ON up.nip='$nip'  
          WHERE i.nip_user like '%$nip%'
          ORDER BY a.aj_syaratjab_sensus DESC";
  return $this->db->query($sql);
}

public function get_jabatan(){
  $nip = $this->session->userdata('nip');
  $sql = "SELECT t.* 
          FROM aj_syaratjab AS t
          LEFT JOIN ref_unit_kerjav2 u 
            ON t.fid_unit_kerja=u.id_unit_kerja
          JOIN ref_instansi_userportal AS i
            ON u.fid_instansi_userportal = i.id_instansi
          JOIN userportal AS up 
            ON up.nip='$nip'  
          WHERE i.nip_user like '%$nip%'           
          ORDER BY t.id_aj_syaratjab";
  return $this->db->query($sql);
}

public function analisis_get_profil($table,$kata){
  $sql = "SELECT t.aj_syaratjab_sensus, t.nip AS nip_pns, t.fid_unit_kerja, t.fid_jenis_jabatan, t.fid_jabstruk, t.fid_jabft, t.fid_jabfu, t.fid_jabesl4, t.fid_jabesl3, t.fid_jabesl2, t.kelas_jabatan, t.n_jabatan, t.fid_golru, t.fid_tingkat_pendidikan, t.fid_jurusan_pendidikan, t.total_jp_diklat, t.skp, t.jml_cuti_sakit, p.nip, p.nama, p.gelar_belakang AS g_belakang, p.gelar_depan AS g_depan, u.id_unit_kerja, u.nama_unit_kerja AS unker, aj.id_aj_syaratjab, aj.n_jabatan, jb.id_jabatan, jb.nama_jabatan, rj.id_jabfu, rj.nama_jabfu, jt.id_jabft, jt.nama_jabft, rg.id_golru, rg.nama_golru, rg.nama_pangkat, rtp.id_tingkat_pendidikan, rtp.nama_tingkat_pendidikan AS tingpen, rjp.id_jurusan_pendidikan, rjp.nama_jurusan_pendidikan AS jurusan, rs.nip, rs.nilai_skp, count(rs.nilai_skp) AS ada, rs.tahun, rc.nip, rc.jml, rc.satuan_jml, rc.fid_jns_cuti, rc.thn_cuti, rd.lama_jam,if(t.fid_jabesl4=jc.id_jabatan,jc.nama_jabatan,'') AS eselon4,
    if(t.fid_jabesl3=jbq.id_jabatan,jbq.nama_jabatan,'') AS eselon3,if(t.fid_jabesl2=ja.id_jabatan,ja.nama_jabatan,'') AS eselon2, ja.id_jabatan, ja.nama_jabatan, jbq.id_jabatan, jbq.nama_jabatan, jc.id_jabatan, jc.nama_jabatan,ja.id_jabatan, ja.nama_jabatan, jbq.id_jabatan, jbq.nama_jabatan, jc.id_jabatan, jc.nama_jabatan
          FROM $table AS t
          LEFT JOIN pegawai AS p 
            ON t.nip=p.nip
          LEFT JOIN ref_unit_kerjav2 AS u 
            ON t.fid_unit_kerja=u.id_unit_kerja
          LEFT JOIN aj_syaratjab AS aj 
            ON t.n_jabatan=aj.id_aj_syaratjab
          LEFT JOIN ref_jabstruk AS jb 
            ON t.fid_jabstruk=jb.id_jabatan
           LEFT JOIN ref_jabfu AS rj 
            ON t.fid_jabfu=rj.id_jabfu
           LEFT JOIN ref_jabft AS jt 
            ON t.fid_jabft=jt.id_jabft
          LEFT JOIN ref_jabstruk AS ja 
            ON t.fid_jabesl2=ja.id_jabatan
          LEFT JOIN ref_jabstruk AS jbq 
            ON t.fid_jabesl3=jbq.id_jabatan
          LEFT JOIN ref_jabstruk AS jc 
            ON t.fid_jabesl4=jc.id_jabatan           
           LEFT JOIN ref_golru AS rg 
            ON t.fid_golru=rg.id_golru
           LEFT JOIN ref_tingkat_pendidikan AS rtp 
            ON t.fid_tingkat_pendidikan=rtp.id_tingkat_pendidikan
           LEFT JOIN ref_jurusan_pendidikan AS rjp 
            ON t.fid_jurusan_pendidikan=rjp.id_jurusan_pendidikan
          LEFT JOIN riwayat_skp AS rs 
            ON t.nip=rs.nip AND rs.tahun='2017'
          LEFT JOIN riwayat_cuti AS rc
            ON t.nip=rc.nip AND rc.fid_jns_cuti='3' AND rc.thn_cuti='2017'
          LEFT JOIN riwayat_diklat_fungsional AS rd
            ON t.nip=rd.nip
          WHERE t.nip = '$kata'
          ORDER BY t.aj_syaratjab_sensus";

  return $this->db->query($sql);
}

public function analisis_get_jabatan($table,$kata){
  $sql = "SELECT *, u.id_unit_kerja, u.nama_unit_kerja, a.id_jabatan, a.nama_jabatan, b.id_jabft, b.nama_jabft, c.id_jabfu, c.nama_jabfu, rg.id_golru, rg.nama_golru, rg.nama_pangkat,if(t.fid_jabesl4=jc.id_jabatan,jc.nama_jabatan,'') AS eselon4,if(t.fid_jabesl3=jbq.id_jabatan,jbq.nama_jabatan,'') AS eselon3,if(t.fid_jabesl2=ja.id_jabatan,ja.nama_jabatan,'') AS eselon2, ja.id_jabatan, ja.nama_jabatan, jbq.id_jabatan, jbq.nama_jabatan, jc.id_jabatan, jc.nama_jabatan,ja.id_jabatan, ja.nama_jabatan, jbq.id_jabatan, jbq.nama_jabatan, jc.id_jabatan, jc.nama_jabatan
          FROM $table AS t 
          LEFT JOIN ref_unit_kerjav2 AS u 
           ON t.fid_unit_kerja=u.id_unit_kerja
          LEFT JOIN ref_jabstruk AS a 
           ON t.fid_jabstruk=a.id_jabatan
          LEFT JOIN ref_jabft AS b
           ON t.fid_jabft=b.id_jabft
          LEFT JOIN ref_jabfu AS c 
           ON t.fid_jabfu=c.id_jabfu
          LEFT JOIN ref_jabstruk AS ja 
            ON t.fid_jabesl2=ja.id_jabatan
          LEFT JOIN ref_jabstruk AS jbq 
            ON t.fid_jabesl3=jbq.id_jabatan
          LEFT JOIN ref_jabstruk AS jc 
            ON t.fid_jabesl4=jc.id_jabatan            
          LEFT JOIN ref_golru AS rg 
           ON t.fid_golru=rg.id_golru
          WHERE t.id_aj_syaratjab='$kata'
          ORDER BY t.id_aj_syaratjab";
  return $this->db->query($sql);
}

public function get_perbandingan($table,$val,$id_aj){
  $sql = "SELECT t.*, s.aj_syaratjab_sensus, s.nip, s.skp, r.id_aj_syaratjab, t.kelas_jabatan AS s_klsjab, r.kelas_jabatan AS r_klsjab, t.fid_golru AS s_golru, r.fid_golru AS r_golru
          FROM $table AS t 
          LEFT JOIN aj_syaratjab_sensus AS s 
            ON t.aj_syaratjab_sensus=s.aj_syaratjab_sensus
          LEFT JOIN aj_syaratjab AS r 
            ON t.id_aj_syaratjab=r.id_aj_syaratjab
          WHERE t.aj_syaratjab_sensus='$val' AND t.id_aj_syaratjab='$id_aj'
          GROUP BY t.id_aj_syaratjab_analisis DESC LIMIT 1";
  return $this->db->query($sql);
}

public function hasil_analisis($table, $id){
  $sql = "SELECT id_aj_syaratjab_analisis, skor_kelas_jabatan AS klsjab, skor_golru AS golru, skor_jurusan AS jurusan, skor_jp AS jp, skor_skp AS skp, skor_csakit AS csakit, LEFT(SUM(skor_kelas_jabatan+skor_golru+skor_jurusan+skor_jp+skor_skp+skor_csakit),3) AS jml_mms
          FROM $table 
          WHERE id_aj_syaratjab_analisis='$id'
          ORDER BY id_aj_syaratjab_analisis";
  return $this->db->query($sql);
}

public function hapus_analisis($table,$where){
    $this->db->where($where);
    $this->db->delete($table);
}

public function save_data_analisis($whr,$data,$table){
    $this->db->where($whr);
    $this->db->update($table,$data);
}
//HALAMAN LAPORAN CETAK PER UNKER

public function get_data_laporan($table, $unker){
  $sql = "SELECT t.*, ass.aj_syaratjab_sensus AS syarat, ass.fid_unit_kerja, u.id_unit_kerja, u.nama_unit_kerja AS unker, g.id_golru, g.nama_golru, g.nama_pangkat, ass.nip, ass.n_jabatan, p.nip, p.nama, js.id_aj_syaratjab, js.n_jabatan AS nama_jabatan, LEFT(SUM(t.skor_kelas_jabatan+t.skor_golru+t.skor_jurusan+t.skor_jp+t.skor_skp+t.skor_csakit),3) AS jml_mms, js.fid_unit_kerja, count(t.id_aj_syaratjab_analisis) AS jml_baris, rsp.nip AS nip_spesimen, rsp.jabatan_spesimen, rsp.status, if(rsp.nip=p.nip, p.nama, '') AS nama_ttd
          FROM $table AS t
          LEFT JOIN aj_syaratjab_sensus AS ass 
            ON t.aj_syaratjab_sensus=ass.aj_syaratjab_sensus
          LEFT JOIN ref_unit_kerjav2 AS u 
           ON ass.fid_unit_kerja=u.id_unit_kerja
          LEFT JOIN pegawai AS p 
            ON ass.nip=p.nip
          LEFT JOIN ref_golru AS g 
            ON t.fid_golru=g.id_golru
          LEFT JOIN aj_syaratjab AS js 
            ON t.id_aj_syaratjab=js.id_aj_syaratjab
          JOIN ref_spesimen AS rsp
            ON t.fid_unit_kerja=rsp.fid_unit_kerja
          WHERE t.fid_unit_kerja='$unker' AND js.id_aj_syaratjab!='' AND sts='1'
          GROUP BY t.id_aj_syaratjab_analisis
          ORDER BY p.nama";
  return $this->db->query($sql);
}



}
