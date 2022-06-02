<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgraph extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function agama()
  {
    $data = $this->db->query("select a.nama_agama, count(p.fid_agama) as jumlah from ref_agama as a, pegawai as p
                              where p.fid_agama = a.id_agama
                              group by a.id_agama");
    return $data->result();
  }

  public function jenkel()
  {
    $data = $this->db->query("select jenis_kelamin, COUNT(jenis_kelamin) as jumlah from pegawai group by jenis_kelamin desc");
    return $data->result();
  }

  public function jenjab()
  {
    $data = $this->db->query("select jj.nama_jenis_jabatan, COUNT(p.fid_jnsjab) as jumlah 
		from pegawai as p, ref_jenis_jabatan as jj where p.fid_jnsjab = jj.id_jenis_jabatan group by jj.nama_jenis_jabatan desc");
    return $data->result();
  }

  public function golru()
  {
    $query = $this->db->query("select g.nama_golru, COUNT(p.fid_golru_skr) as jumlah from pegawai as p, ref_golru as g where p.fid_golru_skr = g.id_golru group by g.id_golru");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  public function tingpen()
  {
    $query = $this->db->query("select tp.nama_tingkat_pendidikan, COUNT(p.fid_tingkat_pendidikan) as jumlah from pegawai as p, ref_tingkat_pendidikan as tp where p.fid_tingkat_pendidikan = tp.id_tingkat_pendidikan group by tp.id_tingkat_pendidikan");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  public function eselon()
  {
    $query = $this->db->query("select e.nama_eselon, COUNT(p.fid_eselon) as jumlah from pegawai as p, ref_eselon as e where p.fid_eselon = e.id_eselon and e.nama_eselon in ('II/A', 'II/B', 'III/A', 'III/B', 'IV/A', 'IV/B') group by e.id_eselon");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  public function jmlpns()
  {
    $q = $this->db->query("select nip from pegawai");
    return $q->num_rows();
  }

  public function jmlpensiun($tahun)
  {
    $q = $this->db->query("select nip from pensiun_detail where tmt_pensiun like '$tahun%'");
    return $q->num_rows();
  }

  public function jmlusulcutimasukbelumproses($tahun)
  {
    // ifd_status = 3 : untuk INBOXBKPPD
    $q = $this->db->query("select nip from cuti where thn_cuti like '$tahun%' and fid_status = '3'");
    return $q->num_rows();
  }

  public function jmlusulcutisetuju($tahun)
  {
    // ifd_status = 4: SETUJU, 7: CETAKSK, 8: SELESAISETUJU
    //$q = $this->db->query("select nip from cuti where thn_cuti like '$tahun%' and fid_status in ('4','7','8')");
    $q = $this->db->query("select nip from riwayat_cuti where thn_cuti = '$tahun'");
    return $q->num_rows();
  }

  public function jmlusulcutitundasetuju($tahun)
  {
    // ifd_status = 4: SETUJU, 7: CETAKSK, 8: SELESAISETUJU
    //$q = $this->db->query("select nip from cuti_tunda where tahun like '$tahun%' and fid_status in ('4','7','8')");
    $q = $this->db->query("select nip from cuti_tunda where tahun = '$tahun'");
    return $q->num_rows();
  }

  public function jmlusulkgb($tahun)
  {
    // ifd_status = 4: SETUJU, 7: CETAKSK, 8: SELESAISETUJU
    //$q = $this->db->query("select nip from cuti where thn_cuti like '$tahun%' and fid_status in ('4','7','8')");
    $q = $this->db->query("select nip from riwayat_kgb where tmt like '$tahun%'");
    return $q->num_rows();
  }

  public function jmluseronline()
  {
    $q = $this->db->query("select nip from userportal where status='ONLINE'");
    return $q->num_rows();
  }

  public function jmlnonpns()
  {
    $q = $this->db->query("select nik from nonpns");
    return $q->num_rows();
  }

  public function jmlcpns()
  {
    $q = $this->db->query("select nip from pegawai where fid_status_pegawai = '0401'");
    return $q->num_rows();
  }  
}
/* End of file mstatistik.php */
/* Location: ./application/models/mstatistik.php */
