<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mstatistik extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  // statistik status pegawai per unit kerja
  function unker_statpeg($id, $st)
  {
  	$q = $this->db->query("select count(sp.nama_status_pegawai) as 'jml' from pegawai as p, ref_status_pegawai as sp
  		where p.`fid_status_pegawai` = sp.`id_status_pegawai`
  		and sp.`nama_status_pegawai` = '$st' and p.fid_unit_kerja = '$id'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per eselonering
  function unker_esl($id, $esl)
  {
  	$q = $this->db->query("select count(e.nama_eselon) as 'jml' from pegawai as p, ref_eselon as e
  		where p.fid_eselon = e.id_eselon and e.`nama_eselon` = '$esl' and p.fid_unit_kerja = '$id'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per tingkat pendidikan
  function unker_tingpen($id, $tp)
  {
  	/*$q = $this->db->query("select count(tp.nama_tingkat_pendidikan) as 'jml'
							from pegawai as p, riwayat_pendidikan as rp, ref_tingkat_pendidikan as tp, ref_jurusan_pendidikan as jp
							where rp.fid_tingkat = tp.id_tingkat_pendidikan
							and rp.fid_jurusan = jp.id_jurusan_pendidikan
							and tp.nama_tingkat_pendidikan = '$tp'
							and rp.nip=p.nip
							and rp.tgl_sttb IN (select max(tgl_sttb) from riwayat_pendidikan where nip=p.nip)
							and p.fid_unit_kerja = '$id'");
    */
    $q = $this->db->query("select count(tp.nama_tingkat_pendidikan) as 'jml'
              from pegawai as p, ref_tingkat_pendidikan as tp
              where p.fid_tingkat_pendidikan = tp.id_tingkat_pendidikan
              and tp.nama_tingkat_pendidikan = '$tp'
              and p.fid_unit_kerja = '$id'");

  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per jenis kelamin
  function unker_jenkel($id, $jk)
  {
  	$q = $this->db->query("select count(p.jenis_kelamin) as 'jml' from pegawai as p
  		where p.jenis_kelamin = '$jk' and p.fid_unit_kerja = '$id'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per AGAMA
  function unker_agama($id, $ag)
  {
  	$q = $this->db->query("select count(a.nama_agama) as 'jml' from pegawai as p, ref_agama as a
  		where p.`fid_agama` = a.`id_agama`
  		and a.`nama_agama` = '$ag' and p.fid_unit_kerja = '$id'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per status kawin
  function unker_statkaw($id, $esl)
  {
  	$q = $this->db->query("select count(sk.nama_status_kawin) as 'jml' from pegawai as p, ref_status_kawin as sk
  		where p.`fid_status_kawin` = sk.`id_status_kawin` and sk.`nama_status_kawin` = '$esl' and p.fid_unit_kerja = '$id'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik status pegawai per unit kerja per golru
  function unker_statpeg_golru($id, $st, $gl)
  {
  	$q = $this->db->query("select count(sp.nama_status_pegawai) as 'jml' from pegawai as p, ref_status_pegawai as sp, ref_golru as g where p.`fid_status_pegawai` = sp.`id_status_pegawai` and p.fid_golru_skr = g.id_golru
  		and sp.`nama_status_pegawai` = '$st' and p.fid_unit_kerja = '$id' and g.nama_golru = '$gl'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per kelompok usia
  function unker_kelusia($id, $batasa, $batasb)
  {
    $q = $this->db->query("select count(nip) as jml from pegawai
		where fid_unit_kerja = '$id' and (((DateDiff(current_date(),tgl_lahir)/365) >= '$batasa') 
		AND ((DateDiff(current_date(),tgl_lahir)/365) <= '$batasb'))");
    if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->jml; 
  	}        
  }

  // statistik unit kerja per tahun bup
  function unker_thnbup($idunker, $thn)
  {
    //$q = $this->db->query("select count(p.nip) as jml from pegawai as p, ref_jabstruk as j where p.fid_jabatan = j.id_jabatan and p.fid_unit_kerja = '$idunker' and (YEAR(p.tgl_lahir)+j.usia_pensiun) = $thn");
    
    $sqljabstruk = mysql_query("select count(p.nip) as jml from pegawai as p, ref_jabstruk as j where p.fid_jabatan = j.id_jabatan and p.fid_unit_kerja = '$idunker' and (YEAR(p.tgl_lahir)+j.usia_pensiun) = $thn");
    $jmljabstruk = mysql_result($sqljabstruk,0,'jml');

    $sqljabfu = mysql_query("select count(p.nip) as jml from pegawai as p, ref_jabfu as j where p.fid_jabfu = j.id_jabfu and p.fid_unit_kerja = '$idunker' and (YEAR(p.tgl_lahir)+j.usia_pensiun) = $thn");
    $jmljabfu = mysql_result($sqljabfu,0,'jml');

    $sqljabft = mysql_query("select count(p.nip) as jml from pegawai as p, ref_jabft as j where p.fid_jabft = j.id_jabft and p.fid_unit_kerja = '$idunker' and (YEAR(p.tgl_lahir)+j.usia_pensiun) = $thn");
    $jmljabft = mysql_result($sqljabft,0,'jml');

  	return $jmljabstruk+$jmljabfu+$jmljabft; 
  }

  // statistik unit kerja per kelompk tugas
  function unker_keltu($id, $keltu)
  {
    $sqljabstruk = mysql_query("select count(p.nip) as jml from pegawai as p, ref_jabstruk as j
where p.fid_jabatan = j.`id_jabatan` and p.fid_unit_kerja = '$id' and j.kelompok_tugas = '$keltu'");
    $jmljabstruk = mysql_result($sqljabstruk,0,'jml');

    $sqljabfu = mysql_query("select count(p.nip) as jml from pegawai as p, ref_jabfu as j
where p.fid_jabfu = j.`id_jabfu` and p.fid_unit_kerja = '$id' and j.kelompok_tugas = '$keltu'");
    $jmljabfu = mysql_result($sqljabfu,0,'jml');

    $sqljabft = mysql_query("select count(p.nip) as jml from pegawai as p, ref_jabft as j
where p.fid_jabft = j.`id_jabft` and p.fid_unit_kerja = '$id' and j.kelompok_tugas = '$keltu'");
    $jmljabft = mysql_result($sqljabft,0,'jml');

    return $jmljabstruk+$jmljabfu+$jmljabft;       
  }
}
/* End of file mstatistik.php */
/* Location: ./application/models/mstatistik.php */
