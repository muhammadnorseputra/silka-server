<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KgbModel extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function getKgb($params) {
        $this->db->select('p.nip_lama,k.nip,p.nama,p.gelar_depan,p.gelar_belakang,
        k.id,k.gapok, k.mk_thn, k.mk_bln, k.tmt, k.no_sk, k.tgl_sk, k.pejabat_sk,g.id_simgaji, k.fid_golru,ssp.kode_statuspeg,ssp.nama_statuspeg,sjp.kode_jenis,sjp.nama_jenis,
        g.nama_golru,g.nama_pangkat,kgb.tmt_gaji_berikutnya,p.no_npwp,p.whatsapp, CONCAT_WS(" ",rj.nama_jabatan,fu.nama_jabfu,ft.nama_jabft) AS jabatan_sekarang,
        k.created_at,k.created_by,k.berkas,e.id_eselon,e.nama_eselon,e.id_simgaji AS id_eselon_simgaji,u.nama_unit_kerja,u.simgaji_id_skpd,u.simgaji_id_satker, sp.status_data AS is_peremajaan', false);
        $this->db->from('riwayat_kgb as k');
        $this->db->join('kgb', 'k.nip=kgb.nip', 'left');
        $this->db->join('pegawai as p', 'k.nip=p.nip', 'left');
        $this->db->join('ref_golru as g', 'k.fid_golru=g.id_golru', 'left');
        $this->db->join('simgaji_pegawai AS sp', 'k.nip=sp.nip', 'left');
        $this->db->join('simgaji_jenis_pegawai AS sjp', 'sp.kode_jenis_pegawai=sjp.kode_jenis', 'left');
        $this->db->join('simgaji_status_pegawai AS ssp', 'sp.kode_status_pegawai=ssp.kode_statuspeg', 'left');
        $this->db->join('ref_eselon as e', 'p.fid_eselon=e.id_eselon','left');
        $this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
        $this->db->join('ref_jabstruk AS rj', 'p.fid_jabatan = rj.id_jabatan', 'left');
        $this->db->join('ref_jabfu AS fu', 'p.fid_jabfu = fu.id_jabfu', 'left');
        $this->db->join('ref_jabft AS ft', 'p.fid_jabft = ft.id_jabft', 'left');
        $this->db->where('k.nip', $params['nip']);
        $this->db->order_by('k.gapok,kgb.gapok_baru', 'desc');
        return $this->db->get();
    }

    public function getKGBP3K($nip) {
        return $this->db->select('k.*, p.nama, p.gelar_depan, p.gelar_blk,p.no_npwp,p.no_handphone,ft.nama_jabft,u.id_unit_kerja,p.kategori,sjp.nama_jenis,sjp.kode_jenis,
        u.nama_unit_kerja, u.simgaji_id_skpd,u.simgaji_id_satker')
        ->from('riwayat_kgb_pppk AS k')
        ->join('ppppk AS p', 'k.nipppk=p.nipppk', 'left')
        ->join('simgaji_pegawai_pppk AS sp', 'k.nipppk=sp.nipppk', 'left')
        ->join('simgaji_jenis_pegawai AS sjp', 'sp.kategori=sjp.kode_jenis', 'left')
        ->join('ref_jabft AS ft', 'p.fid_jabft = ft.id_jabft', 'left')
        ->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left')
        ->where('k.nipppk', $nip)
        ->order_by('k.gapok', 'desc')
        ->get();
    }

    public function getPengantar($params)
    {
      $this->db->select('*')->from('kgb_pengantar');
      if(!empty($params['id'])) {
        $this->db->where('id_pengantar', $params['id']);
      }
      if(!empty($params['nomor'])) {
        $this->db->like('no_pengantar', $params['nomor']);
      }
      return $this->db->get();
    }

    public function update($tbl, $data, $whr) {
      $this->db->where($whr);
      return $this->db->update($tbl, $data);
    }

}