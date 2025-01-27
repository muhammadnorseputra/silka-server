<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }


  public function getPns($params) {
    return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, u.id_unit_kerja as unker_id, u.nama_unit_kerja, u.simgaji_id_skpd,u.simgaji_id_satker, CONCAT_WS(' ', jst.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft) AS nama_jabatan, 
        CONCAT_WS(' ', jst.id_jabatan, jfu.id_jabfu, jft.id_jabft) AS kode_jabatan,g.id_simgaji as kode_pangkat,e.id_simgaji as kode_eselon,
        sp.induk_bank,sp.norek,sp.kode_jenkel,sp.status_data,ag.nama_agama,ag.id_bkn as simgaji_id_agama, sp.update_at,sp.tmt_skmt,
        ssp.kode_statuspeg AS kode_status_pegawai,ssp.nama_statuspeg,sjp.kode_jenis AS kode_jenis_pegawai,sjp.nama_jenis,rsk.id_simgaji as kode_statkawin_simgaji,
        (SELECT kgb.gapok FROM riwayat_kgb AS kgb WHERE p.nip=kgb.nip ORDER BY kgb.gapok DESC LIMIT 1) AS gapok,
        (SELECT COUNT(rs.nama_sutri) FROM riwayat_sutri AS rs WHERE p.nip=rs.nip AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_sutri,
        (SELECT COUNT(ra.nama_anak) FROM riwayat_anak AS ra WHERE p.nip=ra.nip AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_anak,
        (SELECT rs.no_karisu FROM riwayat_sutri AS rs WHERE p.nip=rs.nip AND status_hidup = 'YA' AND rs.status_kawin = 'MENIKAH' ORDER BY rs.no_karisu DESC LIMIT 1) AS no_karis_karsu,
        (SELECT cp.tmt_cpns FROM cpnspns AS cp WHERE p.nip=cp.nip) AS tmt_capeg,
        (SELECT cp.no_karpeg FROM cpnspns AS cp WHERE p.nip=cp.nip) AS no_karpeg,
        (SELECT tp.nama_tingkat_pendidikan FROM riwayat_pendidikan AS rp LEFT JOIN ref_tingkat_pendidikan as tp ON rp.fid_tingkat=tp.id_tingkat_pendidikan WHERE p.nip=rp.nip ORDER BY rp.fid_tingkat DESC LIMIT 1) AS nama_tingkat_pendidikan,
        (SELECT cp.tgl_spmt AS tgl_spmt FROM cpnspns AS cp WHERE p.nip=cp.nip) AS tgl_spmt", false)
        ->from('pegawai as p')
        ->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru')
        ->join('ref_eselon AS e', 'p.fid_eselon=e.id_eselon')
        ->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'left')
        ->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'left')
        ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
        ->join('ref_agama as ag', 'p.fid_agama=ag.id_agama', 'left')
        ->join('ref_status_kawin as rsk', 'p.fid_status_kawin=rsk.id_status_kawin', 'left')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('simgaji_pegawai AS sp', 'p.nip=sp.nip', 'left')
        ->join('simgaji_jenis_pegawai AS sjp', 'sp.kode_jenis_pegawai=sjp.kode_jenis', 'left')
        ->join('simgaji_status_pegawai AS ssp', 'sp.kode_status_pegawai=ssp.kode_statuspeg', 'left')
        ->where('p.nip', $params['nip'])
        ->get();
  }

  public function getPppk($params) {
    return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, g.id_simgaji as simgaji_id_pangkat, u.id_unit_kerja as unker_id, u.nama_unit_kerja, u.simgaji_id_skpd,u.simgaji_id_satker,ssp.nama_statuspeg,
    jft.nama_jabft AS nama_jabatan, p.gaji_pokok,ag.nama_agama,ag.id_bkn as simgaji_id_agama,tp.nama_tingkat_pendidikan,rsk.id_simgaji as simgaji_id_status_kawin,
    sp.kode_statuspeg,sp.status_data,sp.created_at as status_data_add,sp.created_by as status_data_add_by, sp.update_at as status_data_update,sp.update_by as status_data_update_by,
    (SELECT COUNT(rs.nama_sutri) FROM riwayat_sutri_pppk AS rs WHERE p.nipppk=rs.nipppk AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_sutri,
    (SELECT COUNT(ra.nama_anak) FROM riwayat_anak_pppk AS ra WHERE p.nipppk=ra.nipppk AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_anak", false)
    ->from('pppk as p')
    ->join('ref_golru_pppk AS g', 'p.fid_golru_pppk=g.id_golru')
    ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
    ->join('ref_agama as ag', 'p.fid_agama=ag.id_agama', 'left')
    ->join('ref_tingkat_pendidikan as tp', 'p.fid_tingkat_pendidikan=tp.id_tingkat_pendidikan', 'left')
    ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
    ->join('ref_status_kawin as rsk', 'p.fid_status_kawin=rsk.id_status_kawin', 'left')
    ->join('simgaji_pppk AS sp', 'p.nipppk=sp.nipppk', 'left')
    ->join('simgaji_status_pegawai AS ssp', 'sp.kode_statuspeg=ssp.kode_statuspeg', 'left')
    ->where('p.nipppk', $params['nipppk'])
    ->get();
}

}