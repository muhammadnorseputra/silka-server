<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mwsbkn extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Mwsbkn');
    $this->load->model('Mkinerja');
  }

  function gettmtcpns($nip) {
  	$this->db->select('tmt_cpns');
	$this->db->from('cpnspns');
        $this->db->where('nip', $nip);
        $get = $this->db->get()->row();

	return $get->tmt_cpns;
  } 

  function getnoskcpns($nip) {
  	$this->db->select('no_sk_cpns');
	$this->db->from('cpnspns');
        $this->db->where('nip', $nip);
        $get = $this->db->get()->row();
  } 

  function gettglskcpns($nip) {
  	$this->db->select('tgl_sk_cpns');
	$this->db->from('cpnspns');
        $this->db->where('nip', $nip);
        $get = $this->db->get()->row();

	return $get->tgl_sk_cpns;
  } 

  function gettmtpns($nip) {
  	$this->db->select('tmt_pns');
        $get = $this->db->get_where('cpnspns',array('nip'=>$nip))->row();

	return $get->tmt_pns;
  } 

  function getnoskpns($nip) {
  	$this->db->select('no_sk_pns');
        $get = $this->db->get_where('cpnspns',array('nip'=>$nip))->row();

	return $get->no_sk_pns;
  }

  function gettglskpns($nip) {
  	$this->db->select('tgl_sk_pns');
        $get = $this->db->get_where('cpnspns',array('nip'=>$nip))->row();

	return $get->tgl_sk_pns;
  } 

  function getgolrucpns($nip) {
  	$this->db->select('fid_golru_cpns');
        $get = $this->db->get_where('cpnspns',array('nip'=>$nip))->row();

	return $get->fid_golru_cpns;
  } 

  function getidbkn_golru($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_golru',array('id_golru'=>$id))->row();

	return $get->id_bkn;
  } 

  function getidbkn_eselon($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_eselon',array('id_eselon'=>$id))->row();

	return $get->id_bkn;
  } 

  function getidbkn_statkaw($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_status_kawin',array('id_status_kawin'=>$id))->row();

	return $get->id_bkn;
  } 

  function getmkthn_golru($nip, $id_golru) {
  	$this->db->select('mkgol_thn');
        $get = $this->db->get_where('riwayat_pekerjaan',array('nip'=>$nip, 'fid_golru'=>$id_golru))->row();
	
	if ($get) {
		return $get->mkgol_thn;
	}
  } 

  function getmkbln_golru($nip, $id_golru) {
  	$this->db->select('mkgol_bln');
        $get = $this->db->get_where('riwayat_pekerjaan',array('nip'=>$nip, 'fid_golru'=>$id_golru))->row();

	if ($get) {
		return $get->mkgol_bln;
	}
  }

  function gettmtjab($nip) {
  	$this->db->select_max('tmt_jabatan'); // seleksi nilai tertinggi dari tmt_jabatan
        $get = $this->db->get_where('riwayat_jabatan',array('nip'=>$nip))->row();

	return $get->tmt_jabatan;
  } 

  function getnamajnsjab($id) {
  	$this->db->select('nama_jenis_jabatan');
        $get = $this->db->get_where('ref_jenis_jabatan',array('id_bkn'=>$id))->row();

	return $get->nama_jenis_jabatan;
  } 

  function getidbkn_agama($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_agama',array('id_agama'=>$id))->row();

	return $get->id_bkn;
  }
  
  function getidbkn_tingpen_rwy($nip, $thnlulus) {
    	$search = "r.id_tingkat_pendidikan = rp.fid_tingkat and rp.nip='$nip' and rp.thn_lulus ='$thnlulus'";
    	$this->db->select('id_bkn');
	$this->db->from('ref_tingkat_pendidikan as r, riwayat_pendidikan as rp');
	$this->db->where($search);
    	$get = $this->db->get()->row();

	return $get->id_bkn;
  }

  function getidbkn_jurpen_rwy($nip, $thnlulus) {
	$search = "r.id_jurusan_pendidikan = rp.fid_jurusan and rp.nip='$nip' and rp.thn_lulus ='$thnlulus'";
	$this->db->select('id_bkn');
	$this->db->from('ref_jurusan_pendidikan as r, riwayat_pendidikan as rp');
	$this->db->where($search);
	$get = $this->db->get()->row();

	return $get->id_bkn;  	
  }

  function getidbkn_jft($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_jabft',array('id_jabft'=>$id))->row();

	return $get->id_bkn;
  } 

  function getidbkn_jfu($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_jabfu',array('id_jabfu'=>$id))->row();

	return $get->id_bkn;
  } 

  function getidbkn_jabstruk($id) {
  	$this->db->select('id_bkn');
        $get = $this->db->get_where('ref_jabstruk',array('id_jabatan'=>$id))->row();

	return $get->id_bkn;
  } 

  function get_pnsid($nip) {
    $this->db->select('pns_id');
    $this->db->from('pegawai');
    $this->db->where('nip', $nip);
    $get = $this->db->get()->row();

    return $get->pns_id; 
  }
  
  function forupjabsapk($nip)
  {
    $jnsjab = $this->Mkinerja->get_jnsjab($nip);
    
    if ($jnsjab == "STRUKTURAL") {
      $q = $this->db->query("select p.pns_id as 'idbkn_pns', concat(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as 'nama', jj.id_bkn as 'idbkn_jnsjab', jj.nama_jenis_jabatan, j.id_bkn as 'idbkn_jab', j.nama_jabatan, u.id_bkn as 'idbkn_unor',  u.nama_unit_kerja, e.id_bkn 'idbkn_esl', e.nama_eselon,
                          (select no_sk from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as no_sk,
                          (select tgl_sk from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tgl_sk,
                          (select tmt_jabatan from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tmt_jabatan,
                          (select tgl_pelantikan from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tmt_pelantikan
                          from pegawai as p, ref_jabstruk as j, ref_unit_kerjav2 as u, ref_eselon as e, ref_jenis_jabatan as jj
                          where p.fid_jabatan = j.id_jabatan
                          and p.fid_unit_kerja = u.id_unit_kerja
                          and j.fid_eselon = e.id_eselon
                          and p.fid_jnsjab = jj.id_jenis_jabatan
                          and p.nip = '".$nip."'");
    } else if ($jnsjab == "FUNGSIONAL UMUM") {
      $q = $this->db->query("select p.pns_id as 'idbkn_pns', concat(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as 'nama', jj.id_bkn as 'idbkn_jnsjab', jj.nama_jenis_jabatan, j.id_bkn as 'idbkn_jab', j.nama_jabfu as 'nama_jabatan', u.id_bkn as 'idbkn_unor',  u.nama_unit_kerja,
                          (select no_sk from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as no_sk,
                          (select tgl_sk from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tgl_sk,
                          (select tmt_jabatan from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tmt_jabatan,
                          (select tgl_pelantikan from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tmt_pelantikan
                          from pegawai as p, ref_jabfu as j, ref_unit_kerjav2 as u, ref_jenis_jabatan as jj
                          where p.fid_jabfu = j.id_jabfu
                          and p.fid_unit_kerja = u.id_unit_kerja
                          and p.fid_jnsjab = jj.id_jenis_jabatan
                          and p.nip = '".$nip."'");
    } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
      $q = $this->db->query("select p.pns_id as 'idbkn_pns', concat(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as 'nama', jj.id_bkn as 'idbkn_jnsjab', 
			  jj.nama_jenis_jabatan, j.id_bkn as 'idbkn_jab', j.nama_jabft as 'nama_jabatan', u.id_bkn as 'idbkn_unor',  u.nama_unit_kerja,
                          (select no_sk from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as no_sk,
                          (select tgl_sk from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tgl_sk,
                          (select tmt_jabatan from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tmt_jabatan,
                          (select tgl_pelantikan from riwayat_jabatan where nip=p.nip and tmt_jabatan = p.tmt_jabatan) as tmt_pelantikan
                          from pegawai as p, ref_jabft as j, ref_unit_kerjav2 as u, ref_jenis_jabatan as jj
                          where p.fid_jabft = j.id_jabft
                          and p.fid_unit_kerja = u.id_unit_kerja
                          and p.fid_jnsjab = jj.id_jenis_jabatan
                          and p.nip = '".$nip."'");
    }
    return $q;
  }

}
