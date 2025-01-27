<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpetajab extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function detailKomponenJabatan($id)
  { 
    $this->db->select('*');
    $this->db->from('ref_peta_jabatan');
    $this->db->where('id', $id);
    $q = $this->db->get();
    return $q;
  }

  function detailKomponenJabatan_pns($nip)
  {
    $q = $this->db->query("select pj.* from ref_peta_jabatan as pj, pegawai as p where pj.id = p.fid_peta_jabatan and p.nip = '$nip'");
    return $q;
  }

  function detailKomponenJabatan_pppk($nipppk)
  {
    $q = $this->db->query("select pj.* from ref_peta_jabatan as pj, pppk as p where pj.id = p.fid_peta_jabatan and p.nipppk = '$nipppk'");
    return $q;
  }

  function getkepalaunit($id_unker)
  {
    $q = $this->db->query("select * from ref_peta_jabatan where fid_unit_kerja = '".$id_unker."' and kepala_unit = 'Y'");
    return $q;
  }

  function getbawahan($id_unker, $id_atasan)
  {
    $q = $this->db->query("select * from ref_peta_jabatan where fid_unit_kerja = '".$id_unker."' and fid_atasan = '".$id_atasan."'");
    return $q;
  }

  function jnsjab()
  {
    $q = $this->db->query("select * from ref_jenis_jabatan");
    return $q;
  }

  public function get_namajnsjab($id)
      {
        $q = $this->db->query("select nama_jenis_jabatan from ref_jenis_jabatan where id_jenis_jabatan = '$id'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->nama_jenis_jabatan; 
        }        
      }

  public function cek_approve($id)
      {
        $q = $this->db->query("select approved from ref_peta_jabatan where id = '$id'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->approved; 
        }        
      }

  function hapus_peta($where){
    $this->db->where($where);
    $this->db->delete('ref_peta_jabatan');
    return true;
  }

  function edit_peta($where, $data){
    $this->db->where($where);
    $this->db->update('ref_peta_jabatan',$data);
    return true;
  }

  public function cek_bawahan($id)
  {
    $q = $this->db->query("select fid_atasan from ref_peta_jabatan where fid_atasan = '$id'");
    return $q->num_rows(); 
  }


   function getnip($idjnsjab, $idjab, $idunker)
      {
        if ($idjnsjab == "1") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabatan='".$idjab."' and fid_unit_kerja='".$idunker."'");         
        } else if ($idjnsjab == "2") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabfu='".$idjab."' and fid_unit_kerja='".$idunker."'");         
        } else if ($idjnsjab == "3") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabft='".$idjab."' and fid_unit_kerja='".$idunker."'");         
        }
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->nip; 
        }        
      }

  function getnippemangku($idpeta)
  {
    $q = $this->db->query("select * from ref_peta_jabatan_pemangku where fid_peta = '".$idpeta."'");        
    return $q; 
    //if ($q->num_rows()>0)
    //{
    //  $row=$q->row();
    //  return $row->nip; 
    //}        
  }

  function get_nippemangku($idpeta)
  {
    $q = $this->db->query("select * from ref_peta_jabatan_pemangku where fid_peta = '".$idpeta."' order by id desc");        
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nip; 
    }        
  }

  function getnippegawai($idjnsjab, $idjab, $idunker)
  {
    if ($idjnsjab == "1") {
      $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabatan='".$idjab."' and fid_unit_kerja='".$idunker."'");      
    } else if ($idjnsjab == "2") {
      $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabfu='".$idjab."' and fid_unit_kerja='".$idunker."'");        
    } else if ($idjnsjab == "3") {
      $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabft='".$idjab."' and fid_unit_kerja='".$idunker."'");         
    }

    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nip; 
    } else {
      return false;
    }        
  }

  function getnip_jml($idjnsjab, $idjab, $idunker)
      {
        if ($idjnsjab == "1") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabatan='".$idjab."' and fid_unit_kerja='".$idunker."'");         
        } else if ($idjnsjab == "2") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabfu='".$idjab."' and fid_unit_kerja='".$idunker."'");         
        } else if ($idjnsjab == "3") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_jabft='".$idjab."' and fid_unit_kerja='".$idunker."'");         
        }
        return $q->num_rows();
      }
  
  function getnip_jmlperjnsjab($idjnsjab, $idunker)
      {
        if ($idjnsjab == "1") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_unit_kerja='".$idunker."'");         
        } else if ($idjnsjab == "2") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_unit_kerja='".$idunker."'");         
        } else if ($idjnsjab == "3") {
          $q = $this->db->query("select nip from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_unit_kerja='".$idunker."'");         
        }
        return $q->num_rows();
      }

  function getidgolru($nip)
  {
    $q = $this->db->query("select fid_golru_skr from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_golru_skr; 
    }        
  }
  
  function jabstruk_all($id_unker)
  {
    $q = $this->db->query("select j.id_jabatan, j.nama_jabatan, j.fid_unit_kerja 
    from ref_jabstruk as j 
    left join ref_unit_kerjav2 as u ON j.fid_unit_kerja = u.id_unit_kerja where j.fid_unit_kerja = $id_unker");
    return $q;
  }

  function jabstruk($id_unker)
  {
    $q = $this->db->query("select j.id_jabatan, j.nama_jabatan, p.fid_unit_kerja from ref_jabstruk as j left join ref_peta_jabatan as p on j.id_jabatan = p.fid_jabstruk and j.fid_unit_kerja = p.fid_unit_kerja where j.fid_unit_kerja = '".$id_unker."' and p.fid_unit_kerja is null");
    return $q;
  }

  function jabfu()
  {
    $q = $this->db->query("select * from ref_jabfu where aktif = 'Y' order by nama_jabfu");
    return $q;
  }

  function jabft()
  {
    $q = $this->db->query("select * from ref_jabft where nama_jabft like 'JF%' order by nama_jabft");
    return $q;
  }

  function jabstruk_peta($id_unker)
  {
    $q = $this->db->query("select j.nama_jabatan, p.* from ref_peta_jabatan as p, ref_jabstruk as j 
	where p.fid_jabstruk = j.id_jabatan and p.fid_jnsjab='1' and p.fid_unit_kerja = '$id_unker' and p.approved = 'Y' order by j.nama_jabatan");
    return $q;
  }

  function jabfu_peta($id_unker)
  {
    $q = $this->db->query("select j.nama_jabfu, p.* from ref_peta_jabatan as p, ref_jabfu as j
        where p.fid_jabfu = j.id_jabfu and p.fid_jnsjab='2' and p.fid_unit_kerja = '$id_unker' and p.approved = 'Y' order by j.nama_jabfu");
    return $q;
  }

  function jabft_peta($id_unker)
  {
    $q = $this->db->query("select j.nama_jabft, p.* from ref_peta_jabatan as p, ref_jabft as j
        where p.fid_jabft = j.id_jabft and p.fid_jnsjab='3' and p.fid_unit_kerja = '$id_unker' and p.approved = 'Y' order by j.nama_jabft");
    return $q;
  }

  function get_kepalaunit()
  {
    $q = $this->db->query("select j.nama_jabatan, p.id, j.fid_unit_kerja from ref_peta_jabatan as p, ref_jabstruk as j where p.fid_jabstruk = j.id_jabatan and p.fid_jnsjab='1' and kepala_unit = 'Y'");
    return $q;
  }

  function input_petajab($data){
    $this->db->insert('ref_peta_jabatan',$data);
    return true;
  }

  public function jmljab($idunker)
  {
    $q = $this->db->query("select fid_unit_kerja FROM ref_peta_jabatan where fid_unit_kerja = '".$idunker."'");
    return $q->num_rows();
  }

  public function jmljab_isi($idunker)
  {
    $q = $this->db->query("select pj.id, count(p.nip) from pegawai as p, ref_peta_jabatan as pj
      where p.fid_jnsjab = pj.fid_jnsjab
      and p.fid_unit_kerja = pj.fid_unit_kerja
      and pj.fid_unit_kerja = '".$idunker."'
      and (p.fid_jabfu = pj.fid_jabfu OR p.fid_jabft = pj.fid_jabft OR p.fid_jabatan = pj.fid_jabstruk) group by pj.id");
    return $q->num_rows();
  }

  public function jmljab_eselon($idunker, $eselon)
  {
    $q = $this->db->query("select pj.fid_jabstruk FROM ref_peta_jabatan as pj, ref_jabstruk as j, ref_eselon as e where pj.fid_unit_kerja = '".$idunker."' and pj.fid_jnsjab='1' and pj.fid_jabstruk = j.id_jabatan and j.fid_eselon = e.id_eselon and e.nama_eselon = '".$eselon."'");
    return $q->num_rows();
  }

  public function jmljab_jfu($idunker)
  {
    $q = $this->db->query("select sum(jml_kebutuhan) as jumlah FROM ref_peta_jabatan where fid_unit_kerja = '".$idunker."' and fid_jnsjab = '2'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->jumlah; 
    } 
  }

  public function jmljab_jft($idunker)
  {
    $q = $this->db->query("select sum(jml_kebutuhan) as jumlah FROM ref_peta_jabatan where fid_unit_kerja = '".$idunker."' and fid_jnsjab = '3'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->jumlah; 
    } 
  }

  public function jmlbezz_eselon($idunker, $eselon)
  {
    $q = $this->db->query("select pj.fid_jabstruk, p.nama from pegawai as p, ref_peta_jabatan as pj, ref_jabstruk as j, ref_eselon as e where p.fid_jnsjab = pj.fid_jnsjab and p.fid_unit_kerja = pj.fid_unit_kerja and pj.fid_unit_kerja = '".$idunker."' and pj.fid_jnsjab='1' and pj.fid_jabstruk = j.id_jabatan and p.fid_jabatan = j.id_jabatan and j.fid_eselon = e.id_eselon and e.nama_eselon = '".$eselon."'");
    return $q->num_rows();
  }

  public function jmlbezz_jfu($idunker)
  {
    //$q = $this->db->query("select pj.fid_jabfu, p.nama from pegawai as p, ref_peta_jabatan as pj, ref_jabfu as j where p.fid_jnsjab = pj.fid_jnsjab and p.fid_unit_kerja = pj.fid_unit_kerja and pj.fid_unit_kerja = '".$idunker."' and pj.fid_jabfu = j.id_jabfu and p.fid_jabfu = j.id_jabfu and pj.fid_jnsjab = '2'");
    $q = $this->db->query("select j.id, pj.nip from ref_peta_jabatan as j, ref_peta_jabatan_pemangku as pj where j.fid_jnsjab = '2' and j.fid_unit_kerja = '".$idunker."' and j.id = pj.fid_peta");
    return $q->num_rows();
  }

  public function jmlbezz_jft($idunker)
  {
    //$q = $this->db->query("select pj.fid_jabft, p.nama from pegawai as p, ref_peta_jabatan as pj, ref_jabft as j where p.fid_jnsjab = pj.fid_jnsjab and p.fid_unit_kerja = pj.fid_unit_kerja and pj.fid_unit_kerja = '".$idunker."' and pj.fid_jabft = j.id_jabft and p.fid_jabft = j.id_jabft and pj.fid_jnsjab = '3'");
    $q = $this->db->query("select j.id, pj.nip from ref_peta_jabatan as j, ref_peta_jabatan_pemangku as pj where j.fid_jnsjab = '3' and j.fid_unit_kerja = '".$idunker."' and j.id = pj.fid_peta");
    return $q->num_rows();
  }

  function getjabfu_perunker($id_unker)
  {
    $q = $this->db->query("select j.id_jabfu, j.nama_jabfu, p.koord_subkoord, p.id, p.fid_atasan, p.approved from ref_peta_jabatan as p, ref_jabfu as j where p.fid_jabfu = j.id_jabfu and p.fid_jnsjab='2' and p.fid_unit_kerja = '$id_unker' order by j.nama_jabfu");
    return $q;
  }

  function getjabft_perunker($id_unker)
  {
    $q = $this->db->query("select j.id_jabft, j.nama_jabft, p.koord_subkoord, p.id, p.fid_atasan, p.approved from ref_peta_jabatan as p, ref_jabft as j where p.fid_jabft = j.id_jabft and p.fid_jnsjab='3' and p.fid_unit_kerja = '$id_unker' order by j.nama_jabft");
    return $q;
  }

  // cek jumlah pemangku sudah full (sesuai jumlah bezzeting)
  public function cek_jmlpemangkufull($id_unker, $id_jnsjab, $id_jab, $id_atasan)
  {
    if ($id_jnsjab == "2") {
      $q = $this->db->query("select id, jml_kebutuhan FROM ref_peta_jabatan as p where fid_unit_kerja  = '".$id_unker."' and fid_jnsjab  = '".$id_jnsjab."' and fid_jabfu  = '".$id_jab."' and fid_atasan  = '".$id_atasan."'");
    } else if ($id_jnsjab == "3") {
      $q = $this->db->query("select id, jml_kebutuhan FROM ref_peta_jabatan as p where fid_unit_kerja  = '".$id_unker."' and fid_jnsjab  = '".$id_jnsjab."' and fid_jabft  = '".$id_jab."' and fid_atasan  = '".$id_atasan."'");
    }
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $jmlpemangku = $this->get_jmlpemangku($row->id);
      if ($jmlpemangku >= $row->jml_kebutuhan) {
        return true; // berarti jumlah pemangku (bezzeting)pada sudah sama dengan kebutuhan
      } else {
        return false; // berarti jumlah pemangku (bezzeting)pada sudah sama dengan kebutuhan
      }       
    } 
  }


  function getpnsjf($idjnsjab, $idunker)
      {
        //if ($idjnsjab == "2") {
          $q = $this->db->query("select nip, CONCAT(gelar_depan,' ',nama,' ', gelar_belakang) as nama from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_unit_kerja='".$idunker."'");         
        //} else if ($idjnsjab == "3") {
        //  $q = $this->db->query("select nip, CONCAT(gelar_depan,' ',nama,' ', gelar_belakang) as nama from pegawai where fid_jnsjab = '".$idjnsjab."' and fid_unit_kerja='".$idunker."'");         
        //}
        if ($q->num_rows()>0)
        {
          return $q->result_array(); 
        } else {
          return 0;
        }       
      }

  public function get_namajabstruk($fid_atasan)
  {
    $q = $this->db->query("select nama_jabatan FROM ref_jabstruk as j, ref_peta_jabatan as p where j.id_jabatan = p.fid_jabstruk and p.id = '".$fid_atasan."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jabatan; 
    } 
  }

  public function get_namaunor($fid_atasan)
  {
    $q = $this->db->query("select nama_unor FROM ref_jabstruk as j, ref_peta_jabatan as p where j.id_jabatan = p.fid_jabstruk and p.id = '".$fid_atasan."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_unor;
    }
  }

  public function get_namajabatasan($id_peta)
  {
    $q = $this->db->query("select fid_atasan FROM ref_peta_jabatan where id = '".$id_peta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $this->get_namajabstruk($row->fid_atasan);
    }
  }

  public function get_namaunoratasan($id_peta)
  {
    $q = $this->db->query("select fid_atasan FROM ref_peta_jabatan where id = '".$id_peta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $this->get_namaunor($row->fid_atasan);
    }
  }

  public function get_namajab($idpeta)
  {
    $q = $this->db->query("select fid_jnsjab, fid_jabstruk, fid_jabfu, fid_jabft FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if ($row->fid_jnsjab == '1') {
        $js = $this->db->query("select nama_jabatan from ref_jabstruk where id_jabatan = '".$row->fid_jabstruk."'");
        if ($js->num_rows()>0)
        {
          $row=$js->row();
          return $row->nama_jabatan; 
        }
      } else if ($row->fid_jnsjab == '2') {
        $ju = $this->db->query("select nama_jabfu from ref_jabfu where id_jabfu = '".$row->fid_jabfu."'");
        if ($ju->num_rows()>0)
        {
          $row=$ju->row();
          return $row->nama_jabfu; 
        }
      } else if ($row->fid_jnsjab == '3') {
        $jt = $this->db->query("select nama_jabft from ref_jabft where id_jabft = '".$row->fid_jabft."'");
        if ($jt->num_rows()>0)
        {
          $row=$jt->row();
          return $row->nama_jabft; 
        }
      }  
    } 
  }

  public function get_jmlpemangku($idpeta)
  {
    $q = $this->db->query("select nip FROM ref_peta_jabatan_pemangku where fid_peta = '".$idpeta."'");
    return $q->num_rows(); 
  }

  public function cek_adapemangku($nip)
  {
    $q = $this->db->query("select nip FROM ref_peta_jabatan_pemangku where nip = '".$nip."'");
    return $q->num_rows(); 
  }

  public function get_jmlkebutuhan($idpeta)
  {
    $q = $this->db->query("select jml_kebutuhan FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->jml_kebutuhan; 
    } 
  }

  public function get_idpeta($id_unker, $id_jnsjab, $id_jab, $id_atasan)
  {
    if ($id_jnsjab == "1") {
      $q = $this->db->query("select id FROM ref_peta_jabatan where fid_unit_kerja  = '".$id_unker."' and fid_jnsjab  = '".$id_jnsjab."' and fid_jabstruk  = '".$id_jab."' and fid_atasan  = '".$id_atasan."'");
    } else if ($id_jnsjab == "2") {
      $q = $this->db->query("select id FROM ref_peta_jabatan where fid_unit_kerja  = '".$id_unker."' and fid_jnsjab  = '".$id_jnsjab."' and fid_jabfu  = '".$id_jab."' and fid_atasan  = '".$id_atasan."'");
    } else if ($id_jnsjab == "3") {
      $q = $this->db->query("select id FROM ref_peta_jabatan where fid_unit_kerja  = '".$id_unker."' and fid_jnsjab  = '".$id_jnsjab."' and fid_jabft  = '".$id_jab."' and fid_atasan  = '".$id_atasan."'");
    }
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->id; 
    } 
  }

  function input_setpemangku($data){
    $this->db->insert('ref_peta_jabatan_pemangku',$data);
    return true;
  }

  function edit_setpemangku($where, $data){
    $this->db->where($where);
    $this->db->update('ref_peta_jabatan_pemangku',$data);
    return true;
  }

  function hapus_petajab_pemangku($where){
    $this->db->where($where);
    $this->db->delete('ref_peta_jabatan_pemangku');
    return true;
  }

  function get_strukkosong($id_unker)
  {
    $q = $this->db->query("select pj.fid_jabstruk, j.nama_jabatan, pj.kelas, pj.jml_kebutuhan, p.nama
                          from ref_peta_jabatan as pj left join pegawai as p on pj.fid_jabstruk = p.fid_jabatan, ref_jabstruk as j
                          where pj.fid_unit_kerja = '".$id_unker."'
                          and pj.fid_jnsjab = '1'
                          and j.id_jabatan = pj.fid_jabstruk
                          and p.fid_jabatan is null");
    return $q;
  }

  function get_jfukosong($id_unker)
  {
    $q = $this->db->query("select pj.fid_jnsjab, j.nama_jabfu, pj.kelas, pj.jml_kebutuhan, pj.fid_atasan, pp.fid_peta, pp.nip
                          from ref_peta_jabatan as pj left join ref_peta_jabatan_pemangku as pp on pj.id = pp.fid_peta, ref_jabfu as j
                          where pj.fid_jnsjab = '2'
                          and pj.fid_unit_kerja = '".$id_unker."' 
                          and pj.fid_jabfu = j.id_jabfu
                          and nip is null order by pj.fid_atasan");
    return $q;
  }

  function get_jfukurang($id_unker)
  {
    $q = $this->db->query("select pj.fid_jnsjab, j.nama_jabfu, pj.kelas, pj.jml_kebutuhan, pj.fid_atasan, count(pp.fid_peta) as 'bezz'
                          from ref_peta_jabatan as pj left join ref_peta_jabatan_pemangku as pp on pj.id = pp.fid_peta, ref_jabfu as j
                          where pj.fid_jnsjab = '2'
                          and pj.fid_unit_kerja = '".$id_unker."' 
                          and pj.fid_jabfu = j.id_jabfu
                          and pj.id = pp.fid_peta
                          and pp.fid_peta is not NULL
                          group by pp.fid_peta");
    return $q;
  }

  function get_jftkosong($id_unker)
  {
    $q = $this->db->query("select pj.fid_jnsjab, j.nama_jabft, pj.kelas, pj.jml_kebutuhan, pj.fid_atasan, pp.fid_peta, pp.nip
                          from ref_peta_jabatan as pj left join ref_peta_jabatan_pemangku as pp on pj.id = pp.fid_peta, ref_jabft as j
                          where pj.fid_jnsjab = '3'
                          and pj.fid_unit_kerja = '".$id_unker."' 
                          and pj.fid_jabft = j.id_jabft
                          and nip is null order by pj.fid_atasan");
    return $q;
  }

  function get_jftkurang($id_unker)
  {
    $q = $this->db->query("select pj.fid_jnsjab, j.nama_jabft, pj.kelas, pj.jml_kebutuhan, pj.fid_atasan, count(pp.fid_peta) as 'bezz'
                          from ref_peta_jabatan as pj left join ref_peta_jabatan_pemangku as pp on pj.id = pp.fid_peta, ref_jabft as j
                          where pj.fid_jnsjab = '3'
                          and pj.fid_unit_kerja = '".$id_unker."' 
                          and pj.fid_jabft = j.id_jabft
                          and pj.id = pp.fid_peta
                          and pp.fid_peta is not NULL
                          group by pp.fid_peta");
    return $q;
  }

  function get_pnsstruknonjab($id_unker)
  {
    $q = $this->db->query("select p.nip, p.nama, pj.id, pj.fid_jnsjab, p.fid_jabatan, pj.fid_jabstruk, p.fid_unit_kerja from pegawai as p left join ref_peta_jabatan as pj on p.fid_unit_kerja = pj.fid_unit_kerja and p.fid_jabatan = pj.fid_jabstruk where p.fid_unit_kerja = '".$id_unker."' and p.fid_jnsjab = '1' and pj.id is NULL");
    return $q;
  }

  /*public function cetakpeta($id)
  {
    $q = $this->db->query("select * from ref_peta_jabatan
                          where fid_unit_kerja = '".$id."'
                          and fid_jabstruk is not null
                          order by kepala_unit asc, kelas desc");    
    return $q;    
  }
  */

  public function get_kepalaunit_idunker($id_unker)
  {
    $q = $this->db->query("select * from ref_peta_jabatan where fid_unit_kerja = '".$id_unker."' and kepala_unit = 'Y'");    
    return $q;    
  }
  

  public function get_jab_byatasan($id_unker, $id_atasan)
  {
    $q = $this->db->query("select * from ref_peta_jabatan
                          where fid_unit_kerja = '".$id_unker."' and fid_atasan = '".$id_atasan."'
                          order by kelas desc");    
    return $q;    
  }

  // UNTUK CONTROLLER TPP NG
  public function get_tpp_pk($idpeta)
  {
    $q = $this->db->query("select tpp_pk FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tpp_pk; 
    } 
  }

  public function get_tpp_bk($idpeta)
  {
    $q = $this->db->query("select tpp_bk FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tpp_bk; 
    } 
  }

  public function get_tpp_kk($idpeta)
  {
    $q = $this->db->query("select tpp_kk FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tpp_kk; 
    } 
  }

  public function get_tpp_tb($idpeta)
  {
    $q = $this->db->query("select tpp_tb FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tpp_tb; 
    } 
  }

  public function get_tpp_kp($idpeta)
  {
    $q = $this->db->query("select tpp_kp FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tpp_kp; 
    } 
  }

  public function get_kelas($idpeta)
  {
    $q = $this->db->query("select kelas FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->kelas; 
    } 
  }

  public function get_koorsubkoord($idpeta)
  {
    $q = $this->db->query("select koord_subkoord FROM ref_peta_jabatan where id = '".$idpeta."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->koord_subkoord;
    }
  }

  public function get_peta_byunker($id_unker)
  {
    $q = $this->db->query("select * from ref_peta_jabatan where fid_unit_kerja = '".$id_unker."' order by kelas desc, fid_atasan desc");
    return $q;
  }

  public function get_pemangku_pns($id_peta)
  {
    $q = $this->db->query("select nip, CONCAT(gelar_depan,' ' ,nama,' ',gelar_belakang) as nama
		 from pegawai where fid_peta_jabatan = '".$id_peta."' order by fid_eselon asc");
    return $q;
  }

  public function get_pemangku_pppk($id_peta)
  {
    $q = $this->db->query("select nipppk, CONCAT(gelar_depan,' ',nama,' ',gelar_blk) as nama
		 from pppk where fid_peta_jabatan = '".$id_peta."' AND status = 'AKTIF' order by tmt_jabatan desc");
    return $q;
  }

  public function get_tnpapeta_pns($id_unker)
  {
    $q = $this->db->query("select p.nip, pj.id from pegawai as p left join ref_peta_jabatan as pj on p.fid_peta_jabatan = pj.id
		where p.fid_unit_kerja = '".$id_unker."' AND pj.id IS null ORDER BY p.fid_peta_jabatan DESC");
    return $q;	
  }

  public function get_tnpapeta_pppk($id_unker)
  {
    $q = $this->db->query("select p.nipppk, pj.id from pppk as p left join ref_peta_jabatan as pj on p.fid_peta_jabatan = pj.id
                where p.fid_unit_kerja = '".$id_unker."' AND pj.id IS null AND status = 'AKTIF' ORDER BY p.fid_peta_jabatan DESC");
    return $q;
  }

}
