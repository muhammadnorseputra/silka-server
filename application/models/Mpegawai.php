<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpegawai extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

	public function tampil()
	{
	  $sql = "SELECT nip, nama, tmp_lahir, tgl_lahir from pegawai";
      return $this->db->query($sql);
	  //return $this->db->get('ref_golru');
	}

  public function detail($nip)
  {
    $q = $this->db->query("select * from pegawai where nip='$nip'");
    return $q;
  }
  
  public function ref_kawin() {
  	$q = $this->db->get('ref_status_kawin');
  	return $q;	
  }

  public function ref_agama() {
        $q = $this->db->get('ref_agama');
        return $q;
  }

  function golru()
    {
        $sql = "SELECT * from ref_golru ORDER BY nama_golru";
        return $this->db->query($sql);
    }

  

  public function cetakprofpeg($nip)
  {
if ($this->mpegawai->cekpernahkp($nip)) { // pernah KP
      //$q = $this->db->query("select p.*, cp.* from pegawai as p, cpnspns as cp where cp.nip=p.nip and p.nip='$nip'");
      $q = $this->db->query("select p.nip, p.nama, p.gelar_depan, p.gelar_belakang, p.tmp_lahir, p.tgl_lahir, p.fid_agama,
      p.fid_status_kawin, p.alamat, p.fid_alamat_kelurahan, p.telepon, p.fid_golru_skr, p.tmt_golru_skr,
      p.fid_jabatan, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja, p.no_ktp, p. no_npwp, p.no_taspen, p.no_askes,
      cp.jabatan_cpns, cp. fid_golru_cpns, cp.tmt_cpns, cp.no_sk_cpns, cp.tgl_sk_cpns, cp. pejabat_sk_cpns,
      cp.jabatan_pns, cp.fid_golru_pns, cp.tmt_pns, cp.no_sk_pns, cp.tgl_sk_pns, cp.pejabat_sk_pns,
      rp.fid_jurusan, rp.fid_tingkat, rp.nama_sekolah, rp.thn_lulus, rp.nama_kepsek, rp.no_sttb, rp.tgl_sttb,
      rk.fid_golru, rk.tmt, rk.dlm_jabatan, rk.mkgol_thn, rk.mkgol_bln, rk.pejabat_sk as 'pejabat_sk_golru', rk.no_sk as 'no_sk_golru', rk.tgl_sk as 'tgl_sk_golru', rj.unit_kerja, rj.jabatan, rj.tmt_jabatan, rj.tgl_pelantikan, rj.no_sk_baperjakat, rj.pejabat_sk as 'pejabat_sk_jab', rj.no_sk as 'no_sk_jab', rj.tgl_sk as 'tgl_sk_jab'
      from pegawai as p, cpnspns as cp, riwayat_pendidikan as rp, riwayat_pekerjaan as rk, riwayat_jabatan as rj
      where p.nip='$nip'
      and cp.nip=p.nip
      and rp.nip=p.nip
      and rk.nip=p.nip
      and rj.nip=p.nip
      and rp.thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')
      and rk.tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')
      and rj.tmt_jabatan IN (select max(tmt_jabatan) from riwayat_jabatan where nip='$nip')
      ");
    } else { // tidak pernah KP, masih CPNS/PNS
      $q = $this->db->query("select p.nip, p.nama, p.gelar_depan, p.gelar_belakang, p.tmp_lahir, p.tgl_lahir, p.fid_agama,
      p.fid_status_kawin, p.alamat, p.fid_alamat_kelurahan, p.telepon, p.fid_golru_skr, p.tmt_golru_skr,
      p.fid_jabatan, p.fid_jnsjab, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja, p.no_ktp, p. no_npwp, p.no_taspen, p.no_askes,
      cp.jabatan_cpns, cp. fid_golru_cpns, cp.tmt_cpns, cp.no_sk_cpns, cp.tgl_sk_cpns, cp. pejabat_sk_cpns,
      cp.jabatan_pns, cp.fid_golru_pns, cp.tmt_pns, cp.no_sk_pns, cp.tgl_sk_pns, cp.pejabat_sk_pns,
      rp.fid_jurusan, rp.fid_tingkat, rp.nama_sekolah, rp.thn_lulus, rp.nama_kepsek, rp.no_sttb, rp.tgl_sttb,
      rj.unit_kerja, rj.jabatan, rj.tmt_jabatan, rj.tgl_pelantikan, rj.no_sk_baperjakat, rj.pejabat_sk as 'pejabat_sk_jab', rj.no_sk as 'no_sk_jab', rj.tgl_sk as 'tgl_sk_jab'
      from pegawai as p, cpnspns as cp, riwayat_pendidikan as rp, riwayat_jabatan as rj
      where p.nip='$nip'
      and cp.nip=p.nip
      and rp.nip=p.nip
      and rj.nip=p.nip
      and rp.tgl_sttb IN (select max(tgl_sttb) from riwayat_pendidikan where nip='$nip')
      and rj.tmt_jabatan IN (select max(tmt_jabatan) from riwayat_jabatan where nip='$nip')
      ");
    }
    //select * from riwayat_jabatan where nip='198104072009041002' and tmt_jabatan IN (select max(tmt_jabatan) from riwayat_jabatan where nip='198104072009041002')
    return $q;
  }

  public function rwycp($nip)
  {
    $sp = $this->getstatpeg($nip);
    if ($sp == 'PNS') {
      $q = $this->db->query("select cp.*, ds.* from cpnspns as cp, riwayat_diklat_struktural as ds, ref_diklat_struktural as rds where ds.nip=cp.nip and ds.fid_diklat_struktural = rds.id_diklat_struktural and rds.nama_diklat_struktural = 'PRAJABATAN' and cp.nip='$nip'");      
      return $q;
    } else if ($sp == 'CPNS') {
      $q = $this->db->query("select * from cpnspns where nip='$nip'");      
      return $q;
    }
  }
  
  public function jenis_dik_jst(){
  	return $this->db->get('ref_diklat_struktural');
  }
  
  public function rwyds($nip)
  {
    $q = $this->db->query("select ds.id, ds.nip, rds.nama_diklat_struktural, ds.instansi_penyelenggara, ds.tempat, ds.tahun, ds.lama_bulan, ds.lama_hari, ds.lama_jam, ds.pejabat_sk, ds.no_sk, ds.tgl_sk from riwayat_diklat_struktural as ds, ref_diklat_struktural as rds where ds.fid_diklat_struktural=rds.id_diklat_struktural and ds.nip='$nip' and rds.nama_diklat_struktural != 'PRAJABATAN' ORDER BY ds.tahun desc");    
    return $q;    
  }

  public function rwydf($nip)
  {
    $q = $this->db->query("select df.nip, df.no, df.nama_diklat_fungsional, df.instansi_penyelenggara, df.tempat, df.tahun, df.lama_bulan, df.lama_hari, df.lama_jam, df.pejabat_sk, df.no_sk, df.tgl_sk from riwayat_diklat_fungsional as df where df.nip='$nip' ORDER BY df.tahun desc");    
    return $q;    
  }

  public function rwydt($nip)
  {
    $q = $this->db->query("select dt.nip, dt.no, dt.nama_diklat_teknis, dt.instansi_penyelenggara, dt.tempat, dt.tanggal, dt.tahun, dt.lama_bulan, dt.lama_hari, dt.lama_jam, dt.pejabat_sk, dt.no_sk, dt.tgl_sk from riwayat_diklat_teknis as dt where dt.nip='$nip' ORDER BY dt.tahun desc");    
    return $q;    
  }

  public function rwykp($nip)
  {
    $q = $this->db->query("select * from riwayat_pekerjaan where nip='$nip' ORDER BY tmt desc");    
    return $q;    
  }

  public function rwykgb($nip)
  {
    $q = $this->db->query("select * from riwayat_kgb where nip='$nip' ORDER BY gapok desc");    
    return $q;    
  }
  
  public function simpan_rwy_kgb_terakhir($tbl, $data) {
  	$q = $this->db->insert($tbl, $data);
  	return $q;
  }
  
  public function editrwykgb($nip, $id) {
  	$q = $this->db->get_where('riwayat_kgb', array('id' => $id, 'nip' => $nip));
  	return $q;
  }
  
  public function update_rwy_kgb_aksi($tbl, $data, $whr) {
  	$this->db->where($whr);
  	$q = $this->db->update($tbl, $data);
  	return $q;
  }
  
  // query update args $tbl,$data,$whr
  public function update_table($tbl, $data, $whr) {
  	$this->db->where($whr);
  	$q = $this->db->update($tbl, $data);
  	return $q;
  }
  
  // query insert args $tbl,$data
  public function insert_table($tbl, $data) {
  	$q = $this->db->insert($tbl, $data);
  	return $q;
  }
  
  // query delete args $tbl,$whr
  public function delete_table($tbl, $whr) {
  	$q = $this->db->where($whr)->delete($tbl);
  	return $q;
  }
  
  // query select args $tbl,$whr
  public function select_table($tbl, $whr) {
  	$q = $this->db->where($whr)->get($tbl);
  	return $q;
  }
  
  
  public function rwypdk($nip)
  {
    $q = $this->db->query("select id, gelar_blk, gelar_dpn, fid_tingkat, fid_jurusan, thn_lulus, nama_sekolah, nama_kepsek, no_sttb, tgl_sttb, berkas from riwayat_pendidikan where nip='$nip' ORDER BY thn_lulus asc");    
    return $q;    
  }

  public function rwyst($nip)
  {
    $q = $this->db->query("select * from riwayat_sutri where nip='$nip' ORDER BY tgl_nikah desc");    
    return $q;    
  }

  public function rwyanak($nip)
  {
    $q = $this->db->query("select nama_anak, fid_sutri_ke, jns_kelamin, tmp_lahir, tgl_lahir, status, status_hidup, tanggungan from riwayat_anak where nip='$nip' ORDER BY tgl_lahir asc");    
    return $q;    
  }

  public function rwyskp($nip)
  {
    //$q = $this->db->query("select jns_skp, tahun, nilai_skp, nilai_prilaku_kerja, nilai_prestasi_kerja, nip_pp, nama_pp, fid_golru_pp, jab_pp, unor_pp, nip_app, nama_app, fid_golru_app, jab_app, unor_app from riwayat_skp where nip='$nip' ORDER BY tahun desc");    
    $q = $this->db->query("select * from riwayat_skp where nip='$nip' ORDER BY tahun desc");
    return $q;    
  }

  public function rwycuti($nip)
  {
    $q = $this->db->query("select * from riwayat_cuti where nip='$nip' ORDER BY thn_cuti desc");    
    return $q;    
  }

  public function rwycutitunda($nip)
  {
    $q = $this->db->query("select * from riwayat_cuti_tunda where nip='$nip' ORDER BY thn_cuti desc");    
    return $q;    
  }

  public function dtlskp($nip, $thn)
  {
    $q = $this->db->query("select * from riwayat_skp where nip='$nip' and tahun='$thn'");    
    return $q;    
  }

  function getnilaiskp($nilai)
  {
    if ($nilai <= 50.50) {
      return 'BURUK';
    } else if (($nilai >= 50.51) AND ($nilai <= 60.50)) {
      return 'KURANG';
    } else if (($nilai >= 60.51) AND ($nilai <= 75.50)) {
      return 'CUKUP';
    } else if (($nilai >= 75.51) AND ($nilai <= 90.50)) {
      return 'BAIK';
    } else if ($nilai >= 90.51) {
      return 'SANGAT BAIK';
    }
  }

  function getnamasutri($nip, $ke)
  {
    $q = $this->db->query("select nama_sutri from riwayat_sutri where nip='$nip' and sutri_ke='$ke'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_sutri; 
    }        
  }

  public function rwyph($nip)
  {
    $q = $this->db->query("select id, nama_tanhor, fid_jenis_tanhor, tahun, pejabat, no_keppres, tgl_keppres from riwayat_tanhor where nip='$nip' ORDER BY tahun desc");    
    return $q;    
  }

  function getnamaph($id)
  {
    $q = $this->db->query("select nama_jenis_tanhor from ref_jenis_tanhor where id_jenis_tanhor='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_tanhor; 
    }        
  }

  public function rwyjab($nip)
  {
    $q = $this->db->query("select id, unit_kerja, jns_jab, jabatan, eselon, angka_kredit, tunjangan, tmt_jabatan, no_sk_baperjakat, tgl_pelantikan, pejabat_sk, no_sk, tgl_sk, prosedur, berkas from riwayat_jabatan where nip='$nip' ORDER BY tmt_jabatan desc");    
    return $q;    
  }
  
  public function rwyplt($nip)
  {
    $q = $this->db->query("select plt.*, re.nama_eselon, re.id_eselon 
    from `riwayat_plt` as plt 
    left join `ref_eselon` as re on plt.fid_eselon=re.id_eselon
    where plt.nip='$nip' ORDER BY plt.tgl_sk desc");    
    return $q;    
  }

  public function get_eselon_byjabatan($id) 
  {
    return $this->db->query("select * from ref_jabstruk as j join ref_eselon as e on j.fid_eselon=e.id_eselon where j.id_jabatan = '$id'");
  }

  public function get_ideselon_byjabatan($id)
  {
    $q = $this->db->query("select fid_eselon from ref_jabstruk where id_jabatan = '$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_eselon;
    }
  }

  function hapus_rwyplt($where){
    $this->db->where($where);
    $this->db->delete('riwayat_plt');
    return true;
  }

  function hapus_rwyjab($where){
    $this->db->where($where);
    $this->db->delete('riwayat_jabatan');
    return true;
  }

  function hapus_rwy_kgb_aksi($tbl, $where){
    $this->db->where($where);
    $this->db->delete($tbl);
    return true;
  }
  
  public function rwypokja($nip) {
  	$q = $this->db->query("select p.*, rp.nama_pokja 
  	from `riwayat_pokja` as p 
  	left join `ref_pokja` as rp on p.fid_pokja=rp.id_pokja
  	where p.nip = '$nip' ORDER BY p.tgl_sk DESC");
  	return $q;
  }
  function hapus_rwypokja($where){
    $this->db->where($where);
    $this->db->delete('riwayat_pokja');
    return true;
  }
  function getjabstruk($id = '') {
  	$q = $this->db->select('ref_jabstruk.id_jabatan, ref_jabstruk.nama_jabatan, ref_unit_kerjav2.nama_unit_kerja')
  	->from('ref_jabstruk')
  	->join('ref_unit_kerjav2', 'ref_jabstruk.fid_unit_kerja=ref_unit_kerjav2.id_unit_kerja')
  	->where('ref_unit_kerjav2.nama_unit_kerja', $id)
  	->get();
  	return $q->result_array();
  }

  public function rwyplt_whereid($nip, $id)
  {
    $q = $this->db->query("select * from riwayat_plt where nip='".$nip."' and id='".$id."'");
    return $q;
  }
  
  public function rwypokja_whereid($nip, $id)
  {
    $q = $this->db->query("select * from riwayat_pokja where nip='".$nip."' and id='".$id."'");
    return $q;
  }

  public function namaunor($idjab)
  {
    $q = $this->db->query("select nama_unor from ref_jabstruk where id_jabatan='$idjab'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->nama_unor;
    }
  }

  public function namajab($idjnsjab, $idjab)
  {   
    $sqljnsjab = mysql_query("select * from ref_jenis_jabatan WHERE id_jenis_jabatan='".$idjnsjab."'");
    $jnsjab = mysql_result($sqljnsjab,0,'nama_jenis_jabatan');
    //var_dump($idjnsjab);
    if ($jnsjab == "STRUKTURAL") {
        $sqljab = $this->db->query("select j.nama_jabatan, e.jab_asn, j.usia_pensiun, j.kelompok_tugas, e.nama_eselon from ref_jabstruk as j, ref_eselon as e WHERE j.fid_eselon = e.id_eselon and id_jabatan='".$idjab."'");
        //$jabatan = mysql_result($sqljab,0,'nama_jabatan');
    	if ($sqljab->num_rows()>0)
        {
            $row=$sqljab->row();
            $jabatan=$row->nama_jabatan; 
        }
    } else if ($jnsjab == "FUNGSIONAL UMUM") {
        $sqljabfu = $this->db->query("select * from ref_jabfu WHERE id_jabfu='".$idjab."'");
        //$jabatan = mysql_result($sqljabfu,0,'nama_jabfu');
	if ($sqljabfu->num_rows()>0)
        {
            $row=$sqljabfu->row();
            $jabatan=$row->nama_jabfu;
        }
    } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
        $sqljabft = $this->db->query("select * from ref_jabft WHERE id_jabft='".$idjab."'");
        //$jabatan = mysql_result($sqljabft,0,'nama_jabft');
	if ($sqljabft->num_rows()>0)
        {
            $row=$sqljabft->row();
            $jabatan=$row->nama_jabft;
        }
    }
    return $jabatan;       
  }

  public function namajabnip($nip)
  {   
    $sqljnsjab = mysql_query("select fid_jnsjab, fid_jabatan, fid_jabft, fid_jabfu from pegawai WHERE nip='".$nip."'");
    $jnsjab = mysql_result($sqljnsjab,0,'fid_jnsjab');
    $fid_jabatan = mysql_result($sqljnsjab,0,'fid_jabatan');
    $fid_jabfu = mysql_result($sqljnsjab,0,'fid_jabfu');
    $fid_jabft = mysql_result($sqljnsjab,0,'fid_jabft');

    if ($jnsjab == 1) { $idjab = $fid_jabatan;
    }else if ($jnsjab == 2) { $idjab = $fid_jabfu;
    }else if ($jnsjab == 3) { $idjab = $fid_jabft;
    }

    $namajab = $this->namajab($jnsjab,$idjab);
    return $namajab;
  }
  
  public function tampilnipnama($data)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select * from pegawai where nip='$data'");
    //$q = $this->db->query("select p.* from pegawai as p, ref_unit_kerja as u, ref_instansi as i 
    //	where p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi 
    //	and i.nip_user like '%$sess_nip%' and nip='$data' order by u.id_unit_kerja");
    return $q;
  }

  public function getnama($nip)
  {
    $q = $this->db->query("select gelar_depan, nama, gelar_belakang from pegawai where nip='$nip'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_belakang);
      return $joinString;
    } 
  }

  public function getnama_only($nip)
  {
    $q = $this->db->query("select nama from pegawai where nip='$nip'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->nama;
    }
  }

  public function getnama_pppk($nipppk)
  {
    $q = $this->db->query("select gelar_depan, nama, gelar_blk from pppk where nipppk='$nipppk'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_blk);
      return $joinString;
    } 
  }

  public function getnama_tblpensiun($nip)
  {
    $q = $this->db->query("select gelar_depan, nama, gelar_belakang from pegawai_pensiun where nip='$nip'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_belakang);
      return $joinString;
    } 
  }

  public function getjab_tblpensiun($nip)
  {
    $q = $this->db->query("select nama_jabatan from pegawai_pensiun where nip='$nip'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->nama_jabatan;
    } 
  }

  public function getnama_session($nip)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.gelar_depan, p.nama, p.gelar_belakang from pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as i 
    				where nip='$nip' and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi 
        			and i.nip_user like '%$sess_nip%'");
    //$q = $this->db->query("select p.* from pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as i
    //    where p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi
    //    and i.nip_user like '%$sess_nip%' and nip='$nip' order by u.id_unit_kerja");

    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_belakang);
      return $joinString;
    } 
  }

  function getnipnama($data)
    {
      $sess_nip = $this->session->userdata('nip');
        $q = $this->db->query("select p.pns_id, p.nip, p.gelar_depan, p.nama, p.gelar_belakang, 
        g.nama_golru, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, p.fid_peta_jabatan, u.nama_unit_kerja, e.nama_eselon, p.tmt_golru_skr
        from pegawai as p, ref_eselon as e, ref_golru as g, ref_unit_kerjav2 as u, ref_instansi_userportal as i
        where p.fid_eselon = e.id_eselon
        and p.fid_golru_skr = g.id_golru
        and p.fid_unit_kerja = u.id_unit_kerja
        and u.fid_instansi_userportal = i.id_instansi 
        and i.nip_user like '%$sess_nip%'
        and (p.nip like '%$data%' OR p.nama like '%$data%')
        order by p.fid_golru_skr desc, p.tmt_golru_skr");
        //$q = $this->db->query("select * from pegawai where fid_unit_kerja='$id'");
        return $q;        
    }

  function getnamajab($id)
  {
    $q = $this->db->query("select nama_jabatan from ref_jabatan where id_jabatan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jabatan; 
    }        
  }

  function getnamagolru($id)
  {
    $q = $this->db->query("select nama_golru from ref_golru where id_golru='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_golru; 
    }        
  }

  function getnamapangkat($id)
  {
    $q = $this->db->query("select nama_pangkat from ref_golru where id_golru='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_pangkat; 
    }        
  }

  function getagama($id)
  {
    $q = $this->db->query("select nama_agama from ref_agama where id_agama='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_agama; 
    }        
  }

  function getjnskel($nip)
  {
    $q = $this->db->query("select jenis_kelamin from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();

      if ($row->jenis_kelamin == 'L')
      {
        return 'LAKI-LAKI';
      } else if ($row->jenis_kelamin == 'P')
      {
        return 'PEREMPUAN';
      }
    }        
  }

  function getnokarpeg($id)
  {
    $q = $this->db->query("select no_karpeg from cpnspns where nip='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->no_karpeg; 
    }        
  }
  
  //status TPP
  function cekstatusttp($id) {
  	$q = $this->db->query("select tpp from pegawai where nip='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if($row->tpp == 'YA') {
      	$status = 'Berhak';
      } else {
      	$status = 'Tidak Berhak';
      }
      return $status; 
    } 
  }

  function getnokarisu($id)
  {
    $q = $this->db->query("select no_karis_karsu from pegawai where nip='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->no_karis_karsu; 
    }        
  }

  function getstatkawin($id)
  {
    $q = $this->db->query("select nama_status_kawin from ref_status_kawin where id_status_kawin='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_status_kawin; 
    }        
  }

  function getstatkawinpns($nip)
  {
    $q = $this->db->query("select sk.nama_status_kawin from ref_status_kawin as sk, pegawai as p where p.fid_status_kawin = sk.id_status_kawin and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_status_kawin;
    }
  }


  //function getstatpeg($nip)
  //{
    //$q = $this->db->query("select sp.nama_status_pegawai from ref_status_pegawai as sp, cpnspns as cp where cp.fid_status_pegawai = sp.id_status_pegawai and cp.nip='$nip'");
    //if ($q->num_rows()>0)
    //{
      //$row=$q->row();
      //return $row->nama_status_pegawai; 
    //}        
  //}
  
  //FUNGSI AMBIL NAMA STATU PEGAWAI BERDASARKAN FID_STATUS_PEGAWAI PADA TABEL PEGAWAI
	function getstatpeg($nip)
	  {
	    $q = $this->db->query("select sp.nama_status_pegawai from ref_status_pegawai as sp, cpnspns as cp where cp.fid_status_pegawai = sp.id_status_pegawai and cp.nip='$nip'");
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      return $row->nama_status_pegawai; 
	    }        
	  }
  //FUNGSI AMBIL ID STATUS PEGAWAI PADA TABEL PEGAWAI BERDASARKAN FID_STATUS_PEGAWAI
  function getstatpegid($nip)
  {
    $q = $this->db->query("select sp.nama_status_pegawai, sp.id_status_pegawai from ref_status_pegawai as sp, pegawai as p 
    where p.fid_status_pegawai = sp.id_status_pegawai
    and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row; 
    }        
  }
   
  function getrefstatpeg() {
  	$q = $this->db->get('ref_status_pegawai')->result();
  	return $q;
  }

  public function getjnspeg($nip)
  {
    $q = $this->db->query("select jp.nama_jenis_pegawai from ref_jenis_pegawai as jp, pegawai as p where p.fid_jenis_pegawai = jp.id_jenis_pegawai and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_pegawai; 
    }        
  }

  function gettingpen($id)
  {
    $q = $this->db->query("select nama_tingkat_pendidikan from ref_tingkat_pendidikan where id_tingkat_pendidikan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_tingkat_pendidikan; 
    }        
  }

  function getjurpen($id)
  {
    $q = $this->db->query("select nama_jurusan_pendidikan from ref_jurusan_pendidikan where id_jurusan_pendidikan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jurusan_pendidikan; 
    }        
  }

  function getpendidikan($nip)
  {
    // ambil data riwayat pendidikan dengan thn_lulus paling terakhir
    $q = $this->db->query("select tp.nama_tingkat_pendidikan, jp.nama_jurusan_pendidikan, rp.thn_lulus, rp.nama_sekolah
          from riwayat_pendidikan as rp, ref_tingkat_pendidikan as tp, ref_jurusan_pendidikan as jp
          where rp.fid_tingkat = tp.id_tingkat_pendidikan
          and rp.fid_jurusan = jp.id_jurusan_pendidikan
          and rp.nip='$nip'
          and rp.thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')
");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $result = array($row->nama_tingkat_pendidikan, '-', $row->nama_jurusan_pendidikan, ' (Lulus tahun ', $row->thn_lulus, ' - ', $row->nama_sekolah, ')');
      $joinString = implode("", $result);
      return $joinString;

      //return $row->nama_status_pegawai; 
    }        
  }

  function getpendidikansingkat($nip)
  {
    // ambil data riwayat pendidikan dengan tgl_sttb paling terakhir
    $q = $this->db->query("select tp.nama_tingkat_pendidikan, jp.nama_jurusan_pendidikan, rp.thn_lulus
          from riwayat_pendidikan as rp, ref_tingkat_pendidikan as tp, ref_jurusan_pendidikan as jp
          where rp.fid_tingkat = tp.id_tingkat_pendidikan
          and rp.fid_jurusan = jp.id_jurusan_pendidikan
          and rp.nip='$nip'
          and rp.thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')
");

    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $result = array($row->nama_tingkat_pendidikan, '-', $row->nama_jurusan_pendidikan, ' (Tahun ', $row->thn_lulus, ')');
      $joinString = implode("", $result);
      return $joinString;

      //return $row->nama_status_pegawai; 
    }        
  }

  function getdssingkat($nip)
  {
    // ambil data riwayat pendidikan dengan tgl_sttb paling terakhir
    $q = $this->db->query("select ds.nama_diklat_struktural, rds.tahun
          from riwayat_diklat_struktural as rds, ref_diklat_struktural as ds
          where rds.fid_diklat_struktural = ds.id_diklat_struktural
          and rds.nip='$nip'
          and rds.tahun IN (select max(tahun) from riwayat_diklat_struktural where nip='$nip')
");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $result = array($row->nama_diklat_struktural, ' Tahun : ', $row->tahun);
      $joinString = implode("", $result);
      return $joinString;

      //return $row->nama_status_pegawai; 
    }        
  }

  function gettmtbup($idjab, $tgllahir, $idjnsjab)
  {
    $sqljnsjab = mysql_query("select * from ref_jenis_jabatan WHERE id_jenis_jabatan='".$idjnsjab."'");
    $jnsjab = mysql_result($sqljnsjab,0,'nama_jenis_jabatan');

   if ($jnsjab == "STRUKTURAL") {
        $q = $this->db->query("select usia_pensiun from ref_jabstruk WHERE id_jabatan='".$idjab."'");
    } else if ($jnsjab == "FUNGSIONAL UMUM") {
        $q = $this->db->query("select usia_pensiun from ref_jabfu WHERE id_jabfu='".$idjab."'");
    } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
        $q = $this->db->query("select usia_pensiun from ref_jabft WHERE id_jabft='".$idjab."'");
    }

    //$q = $this->db->query("select usia_pensiun from ref_jabatan where id_jabatan='$data'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $ubah = gmdate($tgllahir, time()+60*60*8);
      $pecah = explode("-",$ubah);  //memecah variabel berdasarkan -
      $tanggal = $pecah[2];
      $bulan = $pecah[1];
      
      // jika lahir bulan desember
      if ($bulan == 12)
      {
        // tmt pensiun bulan berikutnya (januari), tahun + 1
        $bulan = bulan($bulan+1);
        $tahun = $pecah[0]+1;
        $result = array('1 ',$bulan,' ',$tahun+$row->usia_pensiun);
      } else
      {
        // tmt pensiun bulan berikutnya (januari), tahun tidak bertambah
        $bulan = bulan($bulan+1);
        $tahun = $pecah[0];
        $result = array('1 ',$bulan,' ',$tahun+$row->usia_pensiun);
      }
      
      $joinString = implode("", $result);
      return $joinString;
    }        
  }

  function getkelurahan($id)
  {
    $q = $this->db->query("select kl.nama_kelurahan, kc.nama_kecamatan from ref_kelurahan as kl, ref_kecamatan as kc where kl.fid_kecamatan = kc.id_kecamatan and kl.id_kelurahan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if ($row->nama_kelurahan != 'LUAR BALANGAN')
      {
        $result = array($row->nama_kelurahan, ' KEC. ', $row->nama_kecamatan);  
        $joinString = implode(" ", $result);
        return $joinString;
      }
    }
  }

  function getjnspengadaan($id)
  {
    $q = $this->db->query("select nama_jns_pengadaan from ref_jns_pengadaan where id_jns_pengadaan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jns_pengadaan; 
    }        
  }

  function getfidunker($nip)
  {
    $q = $this->db->query("select fid_unit_kerja from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_unit_kerja; 
    }        
  }

  function getfideselon($nip)
  {
    $q = $this->db->query("select fid_eselon from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_eselon; 
    }        
  }

  function getnamaeselon($id)
  {
    $q = $this->db->query("select nama_eselon from ref_eselon where id_eselon='".$id."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_eselon; 
    }        
  }
	
  function kelurahan()
  {
    $sql = "SELECT * from ref_kelurahan ORDER BY nama_kelurahan";
    return $this->db->query($sql);
  }

  function kecamatan()
  {
    $sql = "SELECT * from ref_kecamatan WHERE nama_kecamatan != 'LUAR BALANGAN' ORDER BY nama_kecamatan";
    return $this->db->query($sql);
  }

  function getnamakecamatan($id)
  {
    $q = $this->db->query("select nama_kecamatan from ref_kecamatan where id_kecamatan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_kecamatan; 
    }        
  }

  function getkecamatan($idkel)
  {
    $q = $this->db->query("select kc.nama_kecamatan from ref_kecamatan as kc, ref_kelurahan as kl where kl.fid_kecamatan = kc.id_kecamatan and kl.id_kelurahan='$idkel'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if ($row->nama_kecamatan != 'LUAR BALANGAN') {
        return $row->nama_kecamatan; 
      }
    }        
  }

  function rsud_puskesmas()
  {
    $sql = "SELECT * from ref_unit_kerjav2 WHERE (nama_unit_kerja like 'PUSKESMAS%' OR nama_unit_kerja like '%RUMAH SAKIT%') ORDER BY nama_unit_kerja";
    return $this->db->query($sql);
  }

  function edit_peg($where, $data){
    $this->db->where($where);
    $this->db->update('pegawai',$data);
    return true;
  }

  function edit_cpnspns($where, $data){
    $this->db->where($where);
    $this->db->update('cpnspns',$data);
    return true;
  }

  function input_dikfung($data){
    $this->db->insert('riwayat_diklat_fungsional',$data);
    return true;
  }

  function edit_kp($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_pekerjaan',$data);
    return true;
  }

  function edit_kgb($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_kgb',$data);
    return true;
  }

  function edit_cuti($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_cuti',$data);
    return true;
  }

  // cek apakah nip, nama diklat dan tahun yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_dikfung($nip, $nama, $tahun)
  {    
    $q = $this->db->query("select no from riwayat_diklat_fungsional where nip='".$nip."' and nama_diklat_fungsional='".$nama."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function cek_adadikfung($nip, $no, $tahun)
  {    
    $q = $this->db->query("select no from riwayat_diklat_fungsional where nip='".$nip."' and no='".$no."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function hapus_dikfung($where){
    $this->db->where($where);
    $this->db->delete('riwayat_diklat_fungsional');
    return true;
  }

  public function detaildikfung($nip, $no, $tahun)
  {;
    $q = $this->db->query("select * from riwayat_diklat_fungsional where nip='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q;
  }

  function edit_dikfung($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_diklat_fungsional',$data);
    return true;
  }

  function input_diktek($data){
    $this->db->insert('riwayat_diklat_teknis',$data);
    return true;
  }
  function input_jnsjab($data){
    $this->db->insert('riwayat_plt',$data);
    return true;
  }
  function update_jnsjab($data, $whr) {
  	$this->db->where($whr);
  	$this->db->update('riwayat_plt', $data);
  	return true;
  }
  function update_pokja($data, $whr) {
  	$this->db->where($whr);
  	$this->db->update('riwayat_pokja', $data);
  	return true;
  }
  function input_rwypokja($data){
    $this->db->insert('riwayat_pokja',$data);
    return true;
  }

  // cek apakah nip, nama diklat dan tahun yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_diktek($nip, $nama, $tahun)
  {    
    $q = $this->db->query("select no from riwayat_diklat_teknis where nip='".$nip."' and nama_diklat_teknis='".$nama."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function cek_adadiktek($nip, $no, $tahun)
  {    
    $q = $this->db->query("select no from riwayat_diklat_teknis where nip='".$nip."' and no='".$no."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function hapus_diktek($where){
    $this->db->where($where);
    $this->db->delete('riwayat_diklat_teknis');
    return true;
  }

  public function detaildiktek($nip, $no, $tahun)
  {;
    $q = $this->db->query("select * from riwayat_diklat_teknis where nip='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q;
  }

  function edit_diktek($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_diklat_teknis',$data);
    return true;
  }

  function status_kawin()
  {
        $sql = "SELECT * from ref_status_kawin ORDER BY nama_status_kawin";
        return $this->db->query($sql);
  }

  function input_sutri($data){
    $this->db->insert('riwayat_sutri',$data);
    return true;
  }

  // cek apakah nip, nama dan tgl_nikah yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_sutri($nip, $tgl_nikah)
  {    
    $q = $this->db->query("select tgl_nikah from riwayat_sutri where nip='".$nip."' and tgl_nikah='".$tgl_nikah."'");  
    return $q->num_rows();
  }

  function cek_adasutri($nip, $sutri_ke, $tgl_nikah)
  {    
    $q = $this->db->query("select nama_sutri from riwayat_sutri where nip='".$nip."' and sutri_ke='".$sutri_ke."' and tgl_nikah='".$tgl_nikah."'");  
    return $q->num_rows();
  }

  function hapus_sutri($where){
    $this->db->where($where);
    $this->db->delete('riwayat_sutri');
    return true;
  }

  function cek_jmlsutri($nip) {    
    $q = $this->db->query("select nip from riwayat_sutri where nip='".$nip."'");  
    return $q->num_rows();
  }

  public function detailsutri($nip, $sutri_ke, $tgl_nikah) {
    $q = $this->db->query("select * from riwayat_sutri where nip='".$nip."' and sutri_ke='".$sutri_ke."' and tgl_nikah='".$tgl_nikah."'");
    return $q;
  }

  function edit_sutri($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_sutri',$data);
    return true;
  }

  public function getibubapak($nip) {
    $q = $this->db->query("select nama_sutri, sutri_ke from riwayat_sutri where nip='".$nip."'");
    return $q;
  }

  function input_anak($data){
    $this->db->insert('riwayat_anak',$data);
    return true;
  }

  // cek apakah nip, nama dan tgl_nikah yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_anak($nip, $nama, $tgl_lahir) {    
    $q = $this->db->query("select tgl_lahir from riwayat_anak where nip='".$nip."' and nama_anak='".$nama."' and tgl_lahir='".$tgl_lahir."'");  
    return $q->num_rows();
  }

  function hapus_anak($where) {
    $this->db->where($where);
    $this->db->delete('riwayat_anak');
    return true;
  }

   function cek_adaanak($nip, $nama_anak, $tgl_lahir) {    
    $q = $this->db->query("select nama_anak from riwayat_anak where nip='".$nip."' and nama_anak='".$nama_anak."' and tgl_lahir='".$tgl_lahir."'");  
    return $q->num_rows();
  }

  public function detailanak($nip, $nama_anak, $tgl_lahir) {
    $q = $this->db->query("select * from riwayat_anak where nip='".$nip."' and nama_anak='".$nama_anak."' and tgl_lahir='".$tgl_lahir."'");
    return $q;
  }

  function edit_anak($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_anak',$data);
    return true;
  }

  function getpanelcolor($nip)
  {
    $q = $this->db->query("select e.nama_eselon from ref_eselon as e, pegawai as p where p.fid_eselon = e.id_eselon and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $eselon = $row->nama_eselon;

      if (($eselon == 'II/A') OR ($eselon == 'II/B')) {
        return "<div class='panel panel-danger'>";
      } else if (($eselon == 'III/A') OR ($eselon == 'III/B')) {
        return "<div class='panel panel-primary'>";
      } else if (($eselon == 'IV/A') OR ($eselon == 'IV/B')) {
        return "<div class='panel panel-success'>";
      } else if (($eselon == 'V') OR ($eselon == 'JFU')) {
        return "<div class='panel panel-warning'>";
      } else if ($eselon == 'JFT') {
        return "<div class='panel panel-default'>";
      }
      //return $row->nama_eselon; 
      //}
    }        
  }

  function getbuttoncolor($nip)
  {
    $q = $this->db->query("select e.nama_eselon from ref_eselon as e, pegawai as p where p.fid_eselon = e.id_eselon and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $eselon = $row->nama_eselon;

      if (($eselon == 'II/A') OR ($eselon == 'II/B')) {
        return "btn btn-danger";
      } else if (($eselon == 'III/A') OR ($eselon == 'III/B')) {
        return "btn btn-primary";
      } else if (($eselon == 'IV/A') OR ($eselon == 'IV/B')) {
        return "btn btn-success";
      } else if (($eselon == 'V') OR ($eselon == 'JFU')) {
        return "btn btn-warning";
      } else if ($eselon == 'JFT') {
        return "btn btn-default";
      }
      //return $row->nama_eselon; 
      //}
    }        
  }
	
  public function geteselon() {
  	$q = $this->db->select('id_eselon, nama_eselon')->from('ref_eselon')->get()->result_array();
  	return $q;
  }
  

  public function getunitkerja() {
  	//$q = $this->db->select('id_unit_kerja, nama_unit_kerja')->from('ref_unit_kerjav2')->get()->result_array();
	$sess_level = $this->session->userdata('level');
	if ($sess_level == "ADMIN") {
		//$q = $this->db->select('id_unit_kerja, nama_unit_kerja')->from('ref_unit_kerjav2')->get()->result_array();
		$q = $this->db->query("select id_unit_kerja, nama_unit_kerja from ref_unit_kerjav2 where nama_unit_kerja not like '-%'")->result_array();
	} else {
  		$q = $this->db->query("select id_unit_kerja, nama_unit_kerja from ref_unit_kerjav2 where nama_unit_kerja not like '-%'")->result_array();
	}
	return $q;
  }
  
  public function getrefpokja() {
  	$q = $this->db->get('ref_pokja')->result_array();
  	return $q;
  }
  
  public function getjabatan($id) {
  	$q = $this->db->select('nama_jabatan')->from('ref_jabstruk')->where('fid_unit_kerja', $id)->get()->result_array();
  	return $q;
  }
    
  public function gettahunppk()
  {
    $q = $this->db->query("select tahun from riwayat_skp GROUP BY tahun");    
    return $q;    
  }

  public function carirekapunkerppk($idunker, $thn)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, p.fid_unit_kerja, p.fid_jnsjab, 
p.fid_jabatan, p.fid_jabfu, p.fid_jabft, rs.tahun, rs.nilai_skp, rs.orientasi_pelayanan, rs.integritas, rs.komitmen, rs.disiplin, rs.kerjasama, rs.kepemimpinan, rs.nilai_prilaku_kerja, rs.nilai_prestasi_kerja
FROM pegawai as p left join riwayat_skp as rs on rs.nip=p.nip and rs.tahun = '".$thn."', ref_unit_kerjav2 as u
WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");

    return $q;
  }

  public function jmlunkerppk($idunker, $thn)
  {
    $q = $this->db->query("select p.nip FROM pegawai as p join riwayat_skp as rs on rs.nip=p.nip and rs.tahun = '".$thn."', ref_unit_kerjav2 as u
WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");
    return $q;
  }

  function cekpernahkp($nip)
  {
    $q = $this->db->query("select p.fid_golru_skr, cp.fid_golru_cpns from pegawai as p, cpnspns as cp where p.nip=cp.nip and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();

      // cek apakah fid golru sekarang besar dari fid golru saat cpns
      if ($row->fid_golru_skr > $row->fid_golru_cpns)
      { // kalo YA berarti ybs pernah KP
        return true;
      } else { // kalo TIDAK berarti ybs masih CPNS
        return false;
      }
    }        
  }

  function get_jmlppk($tahun)
  {    
    $q = $this->db->query("select nip from riwayat_skp where tahun='".$tahun."'");  
    return $q->num_rows();
  }

  // cek apakah ada riwayat ckp pada tahun ini
  function cekskpthn($nip, $tahun)
  {    
    $q = $this->db->query("select nilai_skp from riwayat_skp where nip='".$nip."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function gettmtkpterakhir($nip) {
    $q = $this->db->query("select tmt from riwayat_pekerjaan where nip='$nip' and tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tmt = $row->tmt;
    }
    return $tmt;
  } 

  function gettmtkgbterakhir($nip) {
    $q = $this->db->query("select tmt from riwayat_kgb where nip='$nip' and tmt IN (select max(tmt) from riwayat_kgb where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tmt = $row->tmt;
    }
    return $tmt;
  }

  function getthnluluspdkterakhir($nip) {
    $q = $this->db->query("select thn_lulus from riwayat_pendidikan where nip='$nip' and thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tmt = $row->thn_lulus;
    }
    return $tmt;
  }

  function gettmtjabterakhir($nip) {
    $q = $this->db->query("select tmt_jabatan from riwayat_jabatan where nip='$nip' and tmt_jabatan IN (select max(tmt_jabatan) from riwayat_jabatan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tmt = $row->tmt_jabatan;
    }
    return $tmt;
  }

  function getberkaskpterakhir($nip) {
    $q = $this->db->query("select berkas from riwayat_pekerjaan where nip='$nip' and tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;
      return $berkas;
    }
  }

  function getberkaskgbterakhir($nip) {
    $q = $this->db->query("select berkas from riwayat_kgb where nip='$nip' and tmt IN (select max(tmt) from riwayat_kgb where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;      
      return $berkas;
    }
  }

  function getberkasjabterakhir($nip) {
    $q = $this->db->query("select berkas from riwayat_jabatan where nip='$nip' and tmt_jabatan IN (select max(tmt_jabatan) from riwayat_jabatan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;      
      return $berkas;
    }
  }

  function getijazahterakhir($nip) {
    $q = $this->db->query("select berkas from riwayat_pendidikan where nip='$nip' and thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;      
      return $berkas;
    }
  }

  function gettahunskpterakhir($nip) {
    $q = $this->db->query("select tahun from riwayat_skp where nip='$nip' and tahun IN (select max(tahun) from riwayat_skp where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tahun = $row->tahun;      
      return $tahun;
    }
  }

  function getberkascpnspns($nip) {
    $q = $this->db->query("select berkas from cpnspns where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;
      return $berkas;
    }    
  }

  function cek_jmlrwykgb($nip) {    
    $q = $this->db->query("select nip from riwayat_kgb where nip='".$nip."'");  
    return $q->num_rows();
  }

  function cek_jmlrwykp($nip) {    
    $q = $this->db->query("select nip from riwayat_pekerjaan where nip='".$nip."'");  
    return $q->num_rows();
  }
  
  function ref_jurusan_pendidikan($id) {
  	return $this->db->get_where('ref_jurusan_pendidikan', ['fid_tingkat_pendidikan' => $id]);
  }
  
  function ref_tingkat_pendidikan() {
  	return $this->db->get('ref_tingkat_pendidikan');
  }

  // digunakan pada controller nonpns
  function ting_pendidikan()
    {
        $sql = "SELECT * from ref_tingkat_pendidikan ORDER BY id_tingkat_pendidikan";
        return $this->db->query($sql);
    }
  // digunakan pada controller nonpns

  function getnotelpon($id)
  {
    $q = $this->db->query("select telepon from pegawai where nip='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->telepon; 
    }        
  }

  // TODO PROPER PAK SYAIFULLAH : Edit Riwayat Jabatan
  function edit_rwyjab($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_jabatan',$data);
    return true;
  }
 
  function edit_rwypdk($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_pendidikan',$data);
    return true;
  }

   // Untuk riwayat Workshop
  public function rwyws($nip)
  {
    $q = $this->db->query("select ws.* from riwayat_workshop as ws where ws.nip='$nip' ORDER BY ws.tahun desc");    
    return $q;    
  }

  function input_ws($data){
    $this->db->insert('riwayat_workshop',$data);
    return true;
  }

  // cek apakah nip, nama diklat dan tahun yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_ws($nip, $nama, $tahun)
  {    
    $q = $this->db->query("select no from riwayat_workshop where nip='".$nip."' and nama_workshop='".$nama."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function cek_adaws($nip, $no, $tahun)
  {    
    $q = $this->db->query("select no from riwayat_workshop where nip='".$nip."' and no='".$no."' and tahun='".$tahun."'");  
    return $q->num_rows();
  }

  function hapus_ws($where){
    $this->db->where($where);
    $this->db->delete('riwayat_workshop');
    return true;
  }

  public function detailws($nip, $no, $tahun)
  {;
    $q = $this->db->query("select * from riwayat_workshop where nip='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q;
  }

  function edit_ws($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_workshop',$data);
    return true;
  }
  // End Workshop

  // Start riwayat Hukuman Disiplin
  public function rwyhd($nip)
  {
    $q = $this->db->query("select * from riwayat_hukdis where nip='$nip'");    
    return $q;    
  }

  function getjnshukdis($id)
  {
    $q = $this->db->query("select nama_jenis_hukdis from ref_jenis_hukdis where id_jenis_hukdis='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $jhd = $row->nama_jenis_hukdis;
      return $jhd;
    }        
  }

  function input_rwyhd($data){
    $this->db->insert('riwayat_hukdis',$data);
    return true;
  }

   function hapus_rwyhd($where){
    $this->db->where($where);
    $this->db->delete('riwayat_hukdis');
    return true;
  }

  function edit_rwyhd($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_hukdis',$data);
    return true;
  }
  // End riwayat Hukuman Disiplin

  // START UPDATE PHOTO
  function input_updatephoto($data){
    $this->db->insert('pegawai_photo',$data);
    return true;
  }

  public function rwyupdate($nip)
  {
    $q = $this->db->query("select * from pegawai_photo where nip='".$nip."' and entry_at IN (select max(entry_at) from pegawai_photo where nip='$nip')");
    return $q;
  }

  public function rwyupdate_setuju($nip)
  {
    $q = $this->db->query("select * from pegawai_photo where nip='".$nip."' and entry_at IN (select max(entry_at) from pegawai_photo where nip='$nip' and approved='YA')");
    return $q->num_rows();
  }

  function hapus_updatephoto($where){
    $this->db->where($where);
    $this->db->delete('pegawai_photo');
    return true;
  }

  function show_photo_pegawai($nip) {
	//$q = $this->db->query("select * from pegawai_photo where nip='".$nip."' and approved != 'YA'");
        $q = $this->db->get_where('pegawai_photo', ['nip' => $nip]);
        $r = $q->result();
        if($q->num_rows() > 0) {
                $photo = $r[0]->photo;
        } else {
                $photo = "Photo tidak ada";
        }

        return $photo;
  }

  public function tampilusulan($status)
  {
    $q = $this->db->get_where('pegawai_photo', ['approved' => $status]);
    return $q;
  }

  function edit_updatephoto($where, $data){
    $this->db->where($where);
    $this->db->update('pegawai_photo',$data);
    return true;
  }
  
  // END UPDATE PHOTO

  // START : UPDATING ATASAN LANGSUNG JFU/JFT
  function getatasan_jabstruk($idjab)
  {
    $q = $this->db->query("select fid_jabatan_induk from ref_jabstruk where id_jabatan='$idjab'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $fid_jabatan_induk = $row->fid_jabatan_induk;      
      return $fid_jabatan_induk;
    }        
  }

  function getkepalaskpd($idunker)
  {
    $q = $this->db->query("SELECT CONCAT(j.nama_jabatan,' ',u.nama_unit_kerja) as kepala, max(j.kelas) FROM `ref_jabstruk` as j, ref_unit_kerjav2 as u where u.id_unit_kerja = j.fid_unit_kerja and j.fid_unit_kerja = '$idunker' group by j.fid_unit_kerja");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $kepala = $row->kepala;      
      return $kepala;
    }        
  }

  function getkepalaskpd_idjab($idunker)
  {
    $q = $this->db->query("SELECT j.id_jabatan, max(j.kelas) FROM `ref_jabstruk` as j, ref_unit_kerjav2 as u where u.id_unit_kerja = j.fid_unit_kerja and j.fid_unit_kerja = '$idunker' group by j.fid_unit_kerja, j.id_jabatan");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $id_jabatan = $row->id_jabatan;      
      return $id_jabatan;
    }        
  }

  public function getsemuaeselon4($idunker)
  {;
    $q = $this->db->query("select id_jabatan, nama_jabatan from ref_jabstruk where fid_eselon in ('0241','0242') and fid_unit_kerja='$idunker'");
    return $q;
  }

  function getnipatasan_jabstruk($idjab)
  {
    $q = $this->db->query("select nip from pegawai where fid_jabatan='$idjab'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $nip = $row->nip;      
      return $nip;
    }        
  }

  function getkeltugas_jft($idjab)
  {
    $q = $this->db->query("select kelompok_tugas from ref_jabft where id_jabft='$idjab'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $kelompok_tugas = $row->kelompok_tugas;      
      return $kelompok_tugas;
    }        
  }
  
  function getkeltugas_jft_nip($nip)
  {
    $q = $this->db->query("select j.kelompok_tugas from ref_jabft as j, pegawai as p where p.fid_jabft = j.id_jabft and p.fid_jnsjab = '3' and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $kelompok_tugas = $row->kelompok_tugas;      
      return $kelompok_tugas;
    }        
  }

  // END : UPDATING ATASAN LANGSUNG JFU/JFT
  


  public function rwyabsensi($nip)
  {
    $q = $this->db->query("select * from absensi where nip='$nip' ORDER BY tahun desc, bulan desc");    
    return $q;    
  }

  public function rwykinerja($nip)
  {
    $q = $this->db->query("select * from kinerja_bulanan where nip='$nip' ORDER BY tahun desc, bulan desc");    
    return $q;    
  }

  public function rwykinerjabkn($nip)
  {
    $q = $this->db->query("select * from riwayat_kinerja_bkn where nip='$nip' ORDER BY tahun desc, bulan desc");
    return $q;
  }

  public function rwykinerjabkn_tahunbulan($nip, $tahun, $bulan)
  {	
    $q = $this->db->query("select * from riwayat_kinerja_bkn where nip='$nip' AND tahun='$tahun' AND bulan='$bulan'");
    if ($q->num_rows()>0) {
      return $q;
    }	
  }

  public function jml_rwykinerjabkn_tahunbulan($nip, $tahun, $bulan)
  {
    $q = $this->db->query("select * from riwayat_kinerja_bkn where nip='$nip' AND tahun='$tahun' AND bulan='$bulan'");
      return $q->num_rows();
  }

  public function rwytpp($nip)
  {
    $q = $this->db->query("select * from usul_tpp as ut, usul_tpp_pengantar as pt where ut.nip='$nip' and ut.fid_pengantar = pt.id 
	 and pt.status in ('APPROVE','CETAK') ORDER BY ut.tahun desc, ut.bulan desc");    
    return $q;    
  }

  public function rwytppng($nip)
  {
    //$q = $this->db->query("select tp.*, st.nama_status from tppng as tp, ref_statustppng as st where tp.nip='$nip' and tp.fid_status = st.id_status
//	 ORDER BY tp.tahun desc, tp.bulan desc");
    
    $q = $this->db->query("select * from tppng where nip='$nip' ORDER BY tahun desc, bulan desc");
return $q;
  }

  public function status_ptkp()
  {
    $q = $this->db->query("select * from ref_status_ptkp order by id_status_ptkp");
    return $q;
  }

  public function rwygaji($nip)
  {
    $q = $this->db->query("select * from riwayat_gaji where nip='$nip' ORDER BY tahun desc, bulan desc");    
    return $q;    
  }

  function getidgolruterakhir($nip)
  {
    $q = $this->db->query("select fid_golru_skr from pegawai where nip='".$nip."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_golru_skr;
    }
  }

  function gettmtcpns($nip) {
    $q = $this->db->query("select tmt_cpns from cpnspns where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tmt = $row->tmt_cpns;
    }
    return $tmt;
  }
  /* UNTUK TAMBAH RIWAYAT JABATAN */
  function update_jabatan_rywtjab($tbl,$data,$whr) {
  	$this->db->where($whr);
  	$this->db->update($tbl, $data);
  }
  function insert_rwyjab($tbl, $data) {
  	$q = $this->db->insert($tbl, $data);
  	return $q;
  }
  function getJst($unkerId) {
  	return $this->db->get_where('ref_jabstruk', ['fid_unit_kerja' => $unkerId])->result_array();
  }
  function getJfu() {
	$this->db->select('*');
	$this->db->from('ref_jabfu');
	$this->db->order_by('nama_jabfu', 'ASC');
	$query = $this->db->get();
	return $query->result_array();
  	//return $this->db->get('ref_jabfu')->result_array();
  }
  function getJft() {
	$this->db->select('*');
        $this->db->from('ref_jabft');
        $this->db->order_by('nama_jabft', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
  	//return $this->db->get('ref_jabft')->result_array();
  }
  /* END */

  // GET TANGGAL LAPORAN REKAPAN PDM
  public function gettgllap_pdm()
  {
    $q = $this->db->query("select tgl_laporan from progress_pdm GROUP BY tgl_laporan");
    return $q;
  }

  // PROGRESS PDM
  public function carirekapprogresspdm($idunker, $tl)
  {
    $q = $this->db->query("select p.nip as 'nippeg', p.nama, p.gelar_belakang, p.gelar_depan, p.fid_unit_kerja, pd.*
    FROM pegawai as p left join progress_pdm as pd on pd.nip=p.nip and pd.tgl_laporan = '".$tl."', ref_unit_kerjav2 as u
WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");

    return $q;
  }

  // STATUS VAKSINASI
  public function caristatusvaksinasi($idunker)
  {
    $q = $this->db->query("select p.nip, CONCAT(p.gelar_depan,' ', p.nama,' ', p.gelar_belakang) as nama, u.nama_unit_kerja, rv.*
from pegawai as p left join riwayat_vaksinasi as rv on rv.nipnik = p.nip, ref_unit_kerjav2 as u
where p.fid_unit_kerja = u.id_unit_kerja
and u.id_unit_kerja = '$idunker'
order by p.fid_eselon, p.nip, p.fid_golru_skr, p.tmt_golru_skr");
//and rv.created_at = (Select MAX(created_at) from riwayat_vaksinasi where nipnik = p.nip group by nip)

    return $q;
  }

  public function rwypip($nip)
  {
    return $this->db->get_where('riwayat_ipasn', ['nip' => $nip])->result_array();
  }

  public function rwyvaksin($nip)
  {
    return $this->db->get_where('riwayat_vaksinasi', ['nipnik' => $nip]);
  }

  public function carikamusjab($nmjab, $jns)
  {
	if ($jns == "jft") {
		$sql = "SELECT * from ref_kelasjft_perbkn52021 WHERE nama_jft like '%$nmjab%' ORDER BY nama_jft";
  	} else if ($jns == "jfu") {
		$sql = "SELECT * from ref_kelasjfu_perbkn52021 WHERE nama_jfu like '%$nmjab%' ORDER BY nama_jfu";
	}

	return $this->db->query($sql);
  }

  public function cari_refjfubkn($nmjab=null)
  {		
  		if($nmjab!=null) {
        	$sql = "SELECT * from ref_jabfu_bkn WHERE nama like '%$nmjab%' ORDER BY nama";
		} else {
			$sql = "SELECT * from ref_jabfu_bkn order by nama";
		}
        return $this->db->query($sql);
  }

  public function cari_refjurpenbkn($nmjp)
  {
        $sql = "SELECT * from ref_jurpen_bkn WHERE nama like '%$nmjp%' ORDER BY grup_pendidikan, nama";

        return $this->db->query($sql);
  }

  public function cari_reflokasibkn($nmlok)
  {
        $sql = "SELECT * from ref_lokasi_bkn WHERE nama like '%$nmlok%' ORDER BY nama";

        return $this->db->query($sql);
  }

  public function cari_refunorbkn($nmunor)
  {
        $sql = "SELECT * from ref_unor_bkn WHERE (nama like 'INSPEKTORAT%' OR nama like 'SEKRETARIAT DAERAH' OR nama like 'SEKRETARIAT DPRD' OR nama like 'DINAS%'
		OR nama like 'BADAN%' OR nama like 'SMP%' OR nama like 'SD%' OR nama like 'TK%' OR nama like 'PUSKESMAS%'
		OR nama like 'UPT%' OR nama like 'KECAMATAN%' OR nama like 'KELURAHAN%' OR nama like 'PAUD%' OR nama like 'RUMAH SAKIT%'
		OR nama like 'SANGGAR KEGIATAN BELAJAR' OR nama like 'SATUAN POLISI%')
		AND nama like '%$nmunor%' ORDER BY nama";

        return $this->db->query($sql);
  }

  public function cari_refjenisttdbkn()
  {
        $sql = "SELECT * from ref_jenisttd_bkn ORDER BY nama";

        return $this->db->query($sql);
  }

  function getnama_jnsjabbkn($id)
  {
    $q = $this->db->query("select nama_jenis_jabatan from ref_jenis_jabatan_bkn where id_jenis_jabatan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_jabatan;
    }
  }

  public function edit_rwyskpbulanan($whr, $data) {
	$this->db->where($whr);
        $q = $this->db->update('riwayat_kinerja_bkn', $data);
        return $q;
  }

  //status LHKPN
  function cekstatuslhkpn($id) {
    $q = $this->db->query("select wajib_lhkpn from pegawai where nip='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if($row->wajib_lhkpn == 'YA') {
        $status = 'YA';
      } else {
        $status = 'TIDAK';
      }
      return $status;
    }
  }

  public function rwylhkpn($nip)
  {
    $q = $this->db->query("select * from riwayat_lhkpn where nip='$nip' ORDER BY tahun_wajib desc");
    return $q;
  }

  function edit_rwylhkpn($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_lhkpn',$data);
    return true;
  }

  public function cari_wllhkpn($idunker, $tahun)
  {
    $q = $this->db->query("select p.nip, CONCAT(p.gelar_depan,' ', p.nama,' ', p.gelar_belakang) as nama, u.nama_unit_kerja, rl.*
from pegawai as p left join riwayat_lhkpn as rl on rl.nip = p.nip, ref_unit_kerjav2 as u
where p.fid_unit_kerja = u.id_unit_kerja
and u.id_unit_kerja = '$idunker'
and rl.tahun_wajib = '$tahun'
order by p.fid_eselon, p.nip, p.fid_golru_skr, p.tmt_golru_skr");
  
  return $q;
  }

  public function rwypenkom($nip)
  {
    $q = $this->db->query("select * from riwayat_penkom where nip='$nip' ORDER BY check_in desc");
    return $q;
  }

  function jenis_workshop()
  {
    $sql = "SELECT * from ref_jenis_workshop ORDER BY id_jenis_workshop";
    return $this->db->query($sql);
  }

  function getnama_jnsworkshop($id)
  {
    $q = $this->db->query("select nama_jenis_workshop from ref_jenis_workshop where id_jenis_workshop='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_workshop;
    }
  }

  function rumpun_diklat()
  {
    $sql = "SELECT * from ref_rumpun_diklat ORDER BY nama_rumpun_diklat";
    return $this->db->query($sql);
  }

  function getnama_rumpundiklat($id)
  {
    $q = $this->db->query("select nama_rumpun_diklat from ref_rumpun_diklat where id_rumpun_diklat='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_rumpun_diklat;
    }
  }

  public function rwypmk($nip)
  {
    $q = $this->db->query("select * from riwayat_pmk where nip='$nip'");
    return $q;
  }

  function gettmtpmkterakhir($nip) {
    $q = $this->db->query("select tmt_baru from riwayat_pmk where nip='$nip' and tmt_baru IN (select max(tmt_baru) from riwayat_pmk where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $tmt = $row->tmt_baru;
    }
    return $tmt;
  }

  function edit_rwypmk($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_pmk',$data);
    return true;
  }

  function hapus_rwypmk($where){
    $this->db->where($where);
    $this->db->delete('riwayat_pmk');
    return true;
  }

  public function simpan_rwypmk_terakhir($tbl, $data) {
        $q = $this->db->insert($tbl, $data);
        return $q;
  }
  

}
/* End of file mpegawai.php */
/* Location: ./application/models/mpegawai.php */
