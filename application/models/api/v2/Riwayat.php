<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }


  public function getRiwayatCuti($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_cuti as r')
    ->join('ref_jenis_cuti as rj', 'r.fid_jns_cuti=rj.id_jenis_cuti', 'left')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatKgb($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_kgb as r')
    ->join('ref_golru as rg', 'r.fid_golru=rg.id_golru', 'left')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatPmk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_pmk as r')
    ->join('ref_golru as rg', 'r.fid_golru=rg.id_golru', 'left')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatLhkpn($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_lhkpn as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatHukdis($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_hukdis as r')
    ->join('ref_jenis_hukdis as rjh', 'r.fid_jenis_hukdis=rjh.id_jenis_hukdis')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatPendidikan($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_pendidikan as r')
    ->join('ref_tingkat_pendidikan as rtp', 'r.fid_tingkat=rtp.id_tingkat_pendidikan')
    ->join('ref_jurusan_pendidikan as rjp', 'r.fid_jurusan=rjp.id_jurusan_pendidikan')
    ->where('r.nip', $params['nip'])
    ->order_by('r.fid_tingkat', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatPangkat($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_pekerjaan as r')
    ->join('ref_golru as rg', 'r.fid_golru=rg.id_golru')
    ->where('r.nip', $params['nip'])
    ->order_by('r.fid_golru', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatJabatan($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_jabatan as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatPlt($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_plt as r')
    ->join('ref_jabstruk as rj', 'r.fid_jabstruk=rj.id_jabatan')
    ->join('ref_eselon as re', 'r.fid_eselon=re.id_eselon')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatPokja($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_pokja as r')
    ->join('ref_pokja as rp', 'r.fid_pokja=rp.id_pokja')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatDiklatFungsional($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_diklat_fungsional as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.no', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatDiklatFungsionalPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_diklat_fungsional_pppk as r')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.no', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatDiklatStruktural($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_diklat_struktural as r')
    ->join('ref_diklat_struktural as rds', 'r.fid_diklat_struktural=rds.id_diklat_struktural')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatDiklatStrukturalPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_diklat_struktural_pppk as r')
    ->join('ref_diklat_struktural as rds', 'r.fid_diklat_struktural=rds.id_diklat_struktural')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatDiklatTeknis($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_diklat_teknis as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.no', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatDiklatTeknisPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_diklat_teknis_pppk as r')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.no', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatWorkshop($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_workshop as r')
    ->join('ref_jenis_workshop as rjw', 'r.fid_jenis_workshop=rjw.id_jenis_workshop', 'LEFT')
    ->join('ref_rumpun_diklat as rrd', 'r.fid_rumpun_diklat=rrd.id_rumpun_diklat', 'LEFT')
    ->where('r.nip', $params['nip'])
    ->order_by('r.no', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatWorkshopPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_workshop_pppk as r')
    ->join('ref_jenis_workshop as rjw', 'r.fid_jenis_workshop=rjw.id_jenis_workshop')
    ->join('ref_rumpun_diklat as rrd', 'r.fid_rumpun_diklat=rrd.id_rumpun_diklat')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.no', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatPenghargaan($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_tanhor as r')
    ->join('ref_jenis_tanhor as rjt', 'r.fid_jenis_tanhor=rjt.id_jenis_tanhor')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatSutri($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_sutri as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatSutriPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_sutri_pppk as r')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatAnak($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_anak as r')
    ->join('riwayat_sutri as rs', 'r.fid_sutri_ke=rs.sutri_ke')
    ->where('r.nip', $params['nip'])
    ->where('rs.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatAnakPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_anak_pppk as r')
    ->join('riwayat_sutri_pppk as rs', 'r.fid_sutri_ke=rs.sutri_ke')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatKinerjaBkn($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_kinerja_bkn as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatAbsensi($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('absensi as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatAbsensiPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('absensi_pppk as r')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.id', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatGaji($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_gaji as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.id_gaji', $params['orderBy']);
    return $db->get();
  }

  public function getRiwayatGajiPppk($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('riwayat_gaji_pppk as r')
    ->where('r.nipppk', $params['nip'])
    ->order_by('r.id_gaji', $params['orderBy']);
    return $db->get();
  }

  public function getCpnsPns($params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select('*')
    ->from('cpnspns as r')
    ->where('r.nip', $params['nip'])
    ->order_by('r.fid_status_pegawai', $params['orderBy']);
    return $db->get();
  }
}