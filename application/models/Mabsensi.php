<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mabsensi extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function tampilabsensi(){
    //$q = $this->db->get('absensi'); // Tampilkan semua data yang ada di tabel siswa
    //return $q;

    $q = $this->db->query("select * from absensi");
    return $q->result();
  }

  // Fungsi untuk melakukan proses upload file
  public function upload_file($filename){
    $this->load->library('upload'); // Load librari upload
    
    $config['upload_path'] = './excel/';
    $config['allowed_types'] = 'xlsx';
    $config['max_size']  = '2048';
    $config['overwrite'] = true;
    $config['file_name'] = $filename;
  
    $this->upload->initialize($config); // Load konfigurasi uploadnya
    if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
      // Jika berhasil :
      $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
      return $return;
    }else{
      // Jika gagal :
      $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
      return $return;
    }
  }
  
  // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
  public function insert_multiple($data){
    $this->db->insert_batch('absensi', $data);
  }

  public function insert_multiple_pppk($data){
    $this->db->insert_batch('absensi_pppk', $data);
  }
  
  function cekadadata($nip, $bulan, $tahun)
  { 
    $q = $this->db->query("select nip from absensi where nip='".$nip."' and bulan='".$bulan."' and tahun='".$tahun."'");  
    $jml = $q->num_rows();
    if ($jml >= 1) {
      return true;
    }
  }

  function cekadadata_pppk($nipppk, $bulan, $tahun)
  { 
    $q = $this->db->query("select nipppk from absensi_pppk where nipppk='".$nipppk."' and bulan='".$bulan."' and tahun='".$tahun."'");  
    $jml = $q->num_rows();
    if ($jml >= 1) {
      return true;
    }
  }

  function input_absensi($data){
    $this->db->insert('absensi',$data);
    return true;
  }

  function update_absensi($where, $data)
  {
    $this->db->where($where);
    $this->db->update('absensi',$data);
    return true;
  }

  function hapus_absensi($where){
        $this->db->where($where);
        $this->db->delete('absensi');
        return true;
  }

  function input_absensi_pppk($data){
    $this->db->insert('absensi_pppk',$data);
    return true;
  }

  function update_absensi_pppk($where, $data)
  {
    $this->db->where($where);
    $this->db->update('absensi_pppk',$data);
    return true;
  }

  function hapus_absensi_pppk($where){
        $this->db->where($where);
        $this->db->delete('absensi_pppk');
        return true;
  }

  function tampilabsensi_perunker($uk, $tahun, $bulan)
  { 
    $q = $this->db->query("select a.* from absensi as a, pegawai as p, ref_unit_kerjav2 as u where p.nip=a.nip and p.fid_unit_kerja = u.id_unit_kerja and u.id_unit_kerja='".$uk."' and a.bulan='".$bulan."' and a.tahun='".$tahun."'");  
    return $q->result();
  }

  function tampilabsensi_perunker_pppk($uk, $tahun, $bulan)
  { 
    $q = $this->db->query("select a.* from absensi_pppk as a, pppk as p, ref_unit_kerjav2 as u where p.nipppk=a.nipppk and p.fid_unit_kerja = u.id_unit_kerja and u.id_unit_kerja='".$uk."' and a.bulan='".$bulan."' and a.tahun='".$tahun."'");  
    return $q->result();
  }

  function getabsensi_nikbulantahun($nip, $bulan, $tahun)
  {
    $q = $this->db->query("select * from absensi where nip='".$nip."' and bulan='".$bulan."' and tahun='".$tahun."'");
    return $q;	
  }

  function getabsensi_nipppkbulantahun($nipppk, $bulan, $tahun)
  {
    $q = $this->db->query("select * from absensi_pppk where nipppk='".$nipppk."' and bulan='".$bulan."' and tahun='".$tahun."'");
    return $q;
  }

}
