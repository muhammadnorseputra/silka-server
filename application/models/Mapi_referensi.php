<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapi_referensi extends CI_Model {
    public function getAgama($filter)
    {
        $this->db->select('*');
        $this->db->from('ref_agama');
        if(!empty($filter['id'])) {
            $this->db->where('id_agama', $filter['id']);
        }
        if(!empty($filter['id_bkn'])) {
            $this->db->where('id_bkn', $filter['id_bkn']);
        }
        $query = $this->db->get();
        return $query;
    }
    public function getSKPD($filter)
    {
        $this->db->select('*');
        $this->db->from('ref_unit_kerjav2');
        $this->db->where('aktif', 'Y');
        if(!empty($filter['id'])) {
            $this->db->where('id_unit_kerja', $filter['id']);
        }
        if(!empty($filter['id_skpd_simgaji'])) {
            $this->db->where('simgaji_id_skpd', $filter['id_skpd_simgaji']);
        }
        $this->db->not_like('nama_unit_kerja', '-');
        $query = $this->db->get();
        return $query;
    }
    public function getJenisPegawai($filter)
    {
        $this->db->select('*');
        $this->db->from('simgaji_jenis_pegawai');
        if(!empty($filter['id'])) {
            $this->db->where('kode_jenis', $filter['id']);
        }
        $query = $this->db->get();
        return $query;
    }
    public function getStatusPegawai($filter)
    {
        $this->db->select('*');
        $this->db->from('simgaji_status_pegawai');
        if(!empty($filter['id'])) {
            $this->db->where('kode_statuspeg', $filter['id']);
        }
        $query = $this->db->get();
        return $query;
    }
}