<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referensi extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }


  public function getStatusAsn($id, $params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select($params['field'])
    ->from('ref_status_pegawai as r');
    if(!empty($id)) {
      $this->db->where('r.id_status_pegawai', $id);
    }
    $this->db->order_by('r.id_status_pegawai', $params['orderBy']);
    return $db->get();
  }

  public function getStatusKgb($id, $params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select($params['field'])
    ->from('ref_statuskgb as r');
    if(!empty($id)) {
      $this->db->where('r.id_statuskgb', $id);
    }
    $this->db->order_by('r.id_statuskgb', $params['orderBy']);
    return $db->get();
  }

  public function getStatusPengantarKgb($id, $params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select($params['field'])
    ->from('ref_statuspengantarkgb as r');
    if(!empty($id)) {
      $this->db->where('r.id_statuspengantarkgb', $id);
    }
    $this->db->order_by('r.id_statuspengantarkgb', $params['orderBy']);
    return $db->get();
  }

  public function getStatusCuti($id, $params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select($params['field'])
    ->from('ref_statuscuti as r');
    if(!empty($id)) {
      $this->db->where('r.id_statuscuti', $id);
    }
    $this->db->order_by('r.id_statuscuti', $params['orderBy']);
    return $db->get();
  }

  public function getStatusPengantarCuti($id, $params) {
    $db = $this->db->limit($params['limit'], $params['offset'])->select($params['field'])
    ->from('ref_statuspengantarcuti as r');
    if(!empty($id)) {
      $this->db->where('r.id_statuspengantarcuti', $id);
    }
    $this->db->order_by('r.id_statuspengantarcuti', $params['orderBy']);
    return $db->get();
  }

}