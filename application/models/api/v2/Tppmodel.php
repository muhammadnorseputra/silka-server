<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TppModel extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function periode($id, $params) {
    $this->db->limit($params['limit'], $params['offset'])->select('*')->from('tppng_periode');
    if(!empty($params['tahun'])) {
        $this->db->where('tahun', $params['tahun']);
    }
    
    if(!empty($id)) {
        $this->db->where('id', $id);       
    }
    $this->db->order_by('id',$params['orderBy']);
    return $this->db->get();
  }

  public function getTppByNip($params) {
    $this->db->select('tpp.*,p.gelar_depan,p.nama,p.gelar_belakang,u.nama_unit_kerja,sp.status_data AS is_peremajaan,u.simgaji_id_skpd,u.simgaji_id_satker', false)
    ->from('tppng as tpp')
    ->join('tppng_periode as tp', 'tpp.fid_periode=tp.id')
    ->join('pegawai as p', 'tpp.nip=p.nip')
    ->join('simgaji_pegawai AS sp', 'p.nip=sp.nip', 'left')
    ->join('ref_unit_kerjav2 AS u', 'tpp.fid_unker=u.id_unit_kerja')
    ->where('tpp.nip', $params['nip'])
    ->where('tp.status', $params['status']);
    if(!empty($params['periode'])) {
        $this->db->where('tpp.fid_periode', $params['periode']);
    }
    if(!empty($params['pengantar'])) {
        $this->db->where('tpp.fid_pengantar', $params['pengantar']);
    }
    if(!empty($params['tahun'])) {
        $this->db->where('tpp.tahun', $params['tahun']);
    }
    if(!empty($params['bulan'])) {
        $this->db->where('tpp.bulan', $params['bulan']);
    }
    return $this->db->order_by('tpp.id,tp.id', $params['orderBy'])->limit($params['limit'], $params['offset'])->get();
    }

    public function getTppByNipppk($params) {
        $this->db->select('tpp.*,p.gelar_depan,p.nama,p.gelar_blk,u.nama_unit_kerja,sp.status_data AS is_peremajaan, u.simgaji_id_skpd,u.simgaji_id_satker', false)
        ->from('tppng as tpp')
        ->join('tppng_periode as tp', 'tpp.fid_periode=tp.id')
        ->join('pppk as p', 'tpp.nip=p.nipppk')
        ->join('simgaji_pppk AS sp', 'p.nipppk=sp.nipppk', 'left')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->where('tpp.nip', $params['nipppk'])
        ->where('tp.status', $params['status']);
        if(!empty($params['periode'])) {
            $this->db->where('tpp.fid_periode', $params['periode']);
        }
        if(!empty($params['pengantar'])) {
            $this->db->where('tpp.fid_pengantar', $params['pengantar']);
        }
        if(!empty($params['tahun'])) {
            $this->db->where('tpp.tahun', $params['tahun']);
        }
        if(!empty($params['bulan'])) {
            $this->db->where('tpp.bulan', $params['bulan']);
        }
        return $this->db->order_by('tpp.id,tp.id', 'desc')->limit($params['limit'], $params['offset'])->get();
    }

    public function update($tbl, $data, $whr) {
        $this->db->where($whr);
        return $this->db->update($tbl, $data);
    }

}