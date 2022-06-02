<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpip extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  function gettingpen($nip)
  {
    // ambil data riwayat pendidikan dengan thn_lulus paling terakhir
    $q = $this->db->query("select tp.nama_tingkat_pendidikan from riwayat_pendidikan as rp, ref_tingkat_pendidikan as tp
          where rp.fid_tingkat = tp.id_tingkat_pendidikan
          and rp.nip='$nip'
          and rp.thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_tingkat_pendidikan;

      //return $row->nama_status_pegawai; 
    }        
  }

  function getdikstruk($nip)
  {
    // ambil data riwayat pendidikan dengan tgl_sttb paling terakhir
    $q = $this->db->query("select ds.nama_diklat_struktural, rds.tahun
          from riwayat_diklat_struktural as rds, ref_diklat_struktural as ds
          where rds.fid_diklat_struktural = ds.id_diklat_struktural
          and rds.nip='$nip'
          and rds.tahun IN (select max(tahun) from riwayat_diklat_struktural where nip='$nip')");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_diklat_struktural;
    }        
  }
 
  function cekdikstruk($nip, $diks)
  {
    // ambil data riwayat pendidikan dengan tgl_sttb paling terakhir
    $q = $this->db->query("select ds.nama_diklat_struktural, rds.tahun
          from riwayat_diklat_struktural as rds, ref_diklat_struktural as ds
          where rds.fid_diklat_struktural = ds.id_diklat_struktural
          and rds.nip='$nip'
          and ds.nama_diklat_struktural = '$diks'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_diklat_struktural;
    }
  }

  public function geteselon($nip)
  {
    $q = $this->db->query("select e.nama_eselon from pegawai as p, ref_eselon as e where p.nip='$nip' and p.fid_eselon = e.id_eselon");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->nama_eselon;
    } 
  }

  // diklat fungsional
  function getdikfung($nip)
  {    
    $q = $this->db->query("select no from riwayat_diklat_fungsional where nip='".$nip."'");  
    if ($q->num_rows() > 0)
    {
      return $q->num_rows();
    }
  }


  // diklat teknis nonpelaksana, minimal 20 JP
  // $ket adalah salah satu dari field lama_bulan / lama_hari / lama_jam
  function getlamadiktek_nonpelaksana($nip, $ket)
  {    
    $q = $this->db->query("select SUM($ket) as 'lama' from riwayat_diklat_teknis where nip='".$nip."' group by '".$ket."'");  
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->lama;
    }
  }

  // diklat teknis untuk pelaksana, minimal 20 JP dalam 1 tahun terakhir
  function getlamadiktek_pelaksana($nip, $ket)
  { 
    $thn = date('Y'); // ambil tahun saat ini
    $thnlalu = $thn-1; // ambil tahun saat ini

    //$q = $this->db->query("select SUM($ket) as 'lama' from riwayat_diklat_teknis where nip='$nip' and (tahun='".$thn."' OR tahun='".$thnlalu."') group by '".$ket."'");  
    // Get riwayat jika diktek hnya tahun ini
    $q = $this->db->query("select SUM($ket) as 'lama' from riwayat_diklat_teknis where nip='$nip' and tahun='".$thn."' group by '".$ket."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->lama;
    }
  }

  // diklat workshop
  // khusus workshop untuk pelaksana, minimal 20 JP dalam 1 tahun terakhir
  function getlamaworkshop($nip)
  {    
    $thn = date('Y');
    $thnlalu = date('Y')-1;

    $q = $this->db->query("select tahun from riwayat_workshop where nip='".$nip."' and (tahun='".$thn."' OR tahun='".$thnlalu."')");  
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->tahun;
    }
  }

  function getnilaiskpthn($nip, $tahun)
  {    
    $q = $this->db->query("select nilai_prestasi_kerja from riwayat_skp where nip='".$nip."' and tahun='".$tahun."'");  
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->nilai_prestasi_kerja;
    }
  }

  function getpernahhukdis($nip, $tingkat)
  {
    $thn1 = date('Y');
    $thn2 = $thn1-1;
    $thn3 = $thn1-2;
    $thn4 = $thn1-3;
    $thn5 = $thn1-4;

    //$q = $this->db->query("select jh.nama_jenis_hukdis, jh.tingkat, rh.tmt_hukuman from riwayat_hukdis as rh, ref_jenis_hukdis as jh where jh.id_jenis_hukdis = rh.fid_jenis_hukdis and rh.nip='198104072009041002' and jh.tingkat = '".$tingkat."' and (rh.tmt_hukuman LIKE '$thn1%' OR rh.tmt_hukuman LIKE '$thn2%' OR rh.tmt_hukuman LIKE '$thn3%' OR rh.tmt_hukuman LIKE '$thn4%' OR rh.tmt_hukuman LIKE '$thn5%')");

    $q = $this->db->query("select jh.nama_jenis_hukdis, jh.tingkat, rh.tmt_hukuman from riwayat_hukdis as rh, ref_jenis_hukdis as jh where jh.id_jenis_hukdis = rh.fid_jenis_hukdis and rh.nip='$nip' and jh.tingkat = '".$tingkat."' and ((rh.tmt_hukuman LIKE '$thn1%') OR (rh.tmt_hukuman LIKE '$thn2%') OR (rh.tmt_hukuman LIKE '$thn3%') OR (rh.tmt_hukuman LIKE '$thn4%') OR (rh.tmt_hukuman LIKE '$thn5%'))");
    
    if ($q->num_rows() >= 0)
    {
      return $q->num_rows();
    }      
  }

   public function getnamajnsjab($nip)
  {
    $q = $this->db->query("select e.jab_asn from ref_eselon as e, pegawai as p WHERE p.fid_eselon = e.id_eselon and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->jab_asn; 
    }
  }

  function input_ipasn($data){
    $this->db->insert('riwayat_ipasn',$data);
    return true;
  }

  function getkategoriip($nilaiip){
    if ($nilaiip <= 60) {
      $katip = "SANGAT RENDAH";
    } else if (($nilaiip >= 60.01) AND ($nilaiip <= 70)) {
      $katip = "RENDAH";
    } else if (($nilaiip >= 70.01) AND ($nilaiip <= 80)) {
      $katip = "SEDANG";
    } else if (($nilaiip >= 80.01) AND ($nilaiip <= 90)) {
      $katip = "TINGGI";
    } else if (($nilaiip >= 90.01) AND ($nilaiip <= 100)) {
      $katip = "SANGAT TINGGI";
    }

    return $katip;
  }

  function getnilaiip($nip, $tahun)
  {    
    $q = $this->db->query("select nilai_pip from riwayat_ipasn where nip='".$nip."' and tahun='".$tahun."'");  
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->nilai_pip;
    }
  }

  public function detailpip($nip, $tahun)
  {
    $q = $this->db->query("select * from riwayat_ipasn where nip='$nip' and tahun='$tahun'");    
    return $q;    
  }

  public function getjmlpip($nip, $tahun)
  {
    $q = $this->db->query("select * from riwayat_ipasn where nip='$nip' and tahun='$tahun'");    
    return $q->num_rows();    
  }

  function hapus_pip($where){
    $this->db->where($where);
    $this->db->delete('riwayat_ipasn');
    return true;
  }

  public function gettahunpip()
  {
    $q = $this->db->query("select tahun from riwayat_ipasn GROUP BY tahun");    
    return $q;    
  }

  public function carirekapunkerpip($idunker, $thn)
  {
    //$q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, p.fid_unit_kerja, ri.* FROM pegawai as p left join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");

    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, p.fid_unit_kerja, ri.tahun, ri.jns_jabatan, ri.jabatan, ri.tingkat_pendidikan, ri.skor_kualifikasi, ri.skor_kompetensi, ri.skor_disiplin, ri.skor_kinerja, ri.nilai_pip, ri.kategori_pip FROM pegawai as p left join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");

    return $q;
  }

  public function jmldatapip_unkerthn($idunker, $thn)
  {
    $q = $this->db->query("select p.nip FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");
    return $q->num_rows();
  }

  public function totalpip_unkerthn($idunker, $thn)
  {
    $q = $this->db->query("select sum(nilai_pip) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function getjmlpertahun($tahun)
  {
    $q = $this->db->query("select nip from riwayat_ipasn where tahun='$tahun'");    
    return $q->num_rows();
  }

  public function totalkua_unkerthn($idunker, $thn)
  {
    $q = $this->db->query("select sum(skor_kualifikasi) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkom_unkerthn($idunker, $thn)
  {
    $q = $this->db->query("select sum(skor_kompetensi) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkin_unkerthn($idunker, $thn)
  {
    $q = $this->db->query("select sum(skor_kinerja) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totaldis_unkerthn($idunker, $thn)
  {
    $q = $this->db->query("select sum(skor_disiplin) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  function warnabar($nilai)
  {
    if ($nilai <= 25) {
      $warna = 'progress-bar progress-bar-warning progress-bar-striped active';
    } else if (($nilai > 25) AND ($nilai < 70)) {
      $warna = 'progress-bar progress-bar-info progress-bar-striped active';
    } else if ($nilai >= 70) {
      $warna = 'progress-bar progress-bar-success progress-bar-striped active';
    }

    return $warna;
  }

  // untuk jabatan JFT Non Teknis, Diklat Fungsional dianggap telah dilaksanakan karena sudah ada AKTA 4 (Guru) dan STR (Kesehatan)
  public function cekjikajftnonteknis($nip)
  {
    $q = $this->db->query("select j.nama_jabft from pegawai as p, ref_jabft as j where p.nip='".$nip."' AND j.id_jabft = p.fid_jabft AND j.kelompok_tugas != 'TEKNIS'");
    return $q->num_rows();
  }

  // STATISTIKA
  // PER INSTANSI
  public function totalpip_insthn($idins, $thn)
  {
    $q = $this->db->query("select sum(nilai_pip) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u, ref_instansiv2 as i WHERE p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '".$idins."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function jmldatapip_insthn($idins, $thn)
  {
    $q = $this->db->query("select p.nip FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u, ref_instansiv2 as i WHERE p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '".$idins."'");
    return $q->num_rows();
  }

  public function totalkua_insthn($idins, $thn)
  {
    $q = $this->db->query("select sum(skor_kualifikasi) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u,ref_instansiv2 as i WHERE p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '".$idins."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkom_insthn($idins, $thn)
  {
    $q = $this->db->query("select sum(skor_kompetensi) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u, ref_instansiv2 as i WHERE p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '".$idins."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkin_insthn($idins, $thn)
  {
    $q = $this->db->query("select sum(skor_kinerja) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u, ref_instansiv2 as i WHERE p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '".$idins."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totaldis_insthn($idins, $thn)
  {
    $q = $this->db->query("select sum(skor_disiplin) as jumlah FROM pegawai as p join riwayat_ipasn as ri on ri.nip=p.nip and ri.tahun = '".$thn."', ref_unit_kerjav2 as u, ref_instansiv2 as i WHERE p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '".$idins."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalpip_thn($thn)
  {
    $q = $this->db->query("select sum(nilai_pip) as jumlah FROM riwayat_ipasn WHERE tahun = '".$thn."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkua_thn($thn)
  {
    $q = $this->db->query("select sum(skor_kualifikasi) as jumlah FROM riwayat_ipasn WHERE tahun = '".$thn."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkom_thn($thn)
  {
    $q = $this->db->query("select sum(skor_kompetensi) as jumlah FROM riwayat_ipasn WHERE tahun = '".$thn."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkin_thn($thn)
  {
    $q = $this->db->query("select sum(skor_kinerja) as jumlah FROM riwayat_ipasn WHERE tahun = '".$thn."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totaldis_thn($thn)
  {
    $q = $this->db->query("select sum(skor_disiplin) as jumlah FROM riwayat_ipasn WHERE tahun = '".$thn."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  // STATISTIK BERDASARKAN JENIS KELAMIN

  public function totalpip_jenkelthn($jenkel, $thn)
  {
    $q = $this->db->query("select sum(ri.nilai_pip) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_kelamin = '".$jenkel."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function jmldatapip_jenkelthn($jenkel, $thn)
  {
    $q = $this->db->query("select ri.nip as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_kelamin = '".$jenkel."'");
    return $q->num_rows();
  }

  public function totalkin_jenkelthn($jenkel, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kinerja) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_kelamin = '".$jenkel."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkua_jenkelthn($jenkel, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kualifikasi) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_kelamin = '".$jenkel."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkom_jenkelthn($jenkel, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kompetensi) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_kelamin = '".$jenkel."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totaldis_jenkelthn($jenkel, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_disiplin) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_kelamin = '".$jenkel."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  // STATISTIK BEDASARKAN JENIS JABATAN
  public function totalpip_jenjabthn($jenjab, $thn)
  {
    $q = $this->db->query("select sum(ri.nilai_pip) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_jabatan = '".$jenjab."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function jmldatapip_jenjabthn($jenjab, $thn)
  {
    $q = $this->db->query("select ri.nip as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_jabatan = '".$jenjab."'");
    return $q->num_rows();
  }

  public function totalkin_jenjabthn($jenjab, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kinerja) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_jabatan = '".$jenjab."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkua_jenjabthn($jenjab, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kualifikasi) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_jabatan = '".$jenjab."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkom_jenjabthn($jenjab, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kompetensi) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_jabatan = '".$jenjab."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totaldis_jenjabthn($jenjab, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_disiplin) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.jns_jabatan = '".$jenjab."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  // STATISTIK BEDASARKAN TINGKAT PENDIDIKAN
  public function totalpip_tingpenthn($tingpen, $thn)
  {
    $q = $this->db->query("select sum(ri.nilai_pip) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.tingkat_pendidikan = '".$tingpen."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function jmldatapip_tingpenthn($tingpen, $thn)
  {
    $q = $this->db->query("select ri.nip as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.tingkat_pendidikan = '".$tingpen."'");
    return $q->num_rows();
  }

  public function totalkin_tingpenthn($tingpen, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kinerja) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.tingkat_pendidikan = '".$tingpen."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkua_tingpenthn($tingpen, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kualifikasi) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.tingkat_pendidikan = '".$tingpen."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totalkom_tingpenthn($tingpen, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_kompetensi) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.tingkat_pendidikan = '".$tingpen."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  public function totaldis_tingpenthn($tingpen, $thn)
  {
    $q = $this->db->query("select sum(ri.skor_disiplin) as jumlah FROM riwayat_ipasn as ri where ri.tahun = '".$thn."' and ri.tingkat_pendidikan = '".$tingpen."'");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->jumlah;
    }
  }

  // START Review Progress IPASN 2021 DJASN BKN
  public function gettgl_importdjasn()
  {
    $q = $this->db->query("select tgl_update from progress_ipasn2021djasn GROUP BY tgl_update");
    return $q;
  }

  public function cariprogress_ipasn2021djasn($idunker, $tl)
  {
    $q = $this->db->query("select p.nip as 'nippeg', p.nama, p.gelar_belakang, p.gelar_depan, p.fid_unit_kerja, pd.*
    FROM pegawai as p left join progress_ipasn2021djasn as pd on pd.nip=p.nip and pd.tgl_update = '".$tl."', ref_unit_kerjav2 as u
WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.fid_golru_skr desc, p.fid_eselon");

    return $q;
  }

  public function nilairata($idunker, $tl)
  {
    $q = $this->db->query("select count(pd.nip) as jmldata, avg(pd.kualifikasi) as ratakua, avg(pd.kompetensi) as ratakomp, avg(pd.kinerja) as ratakin, 
	avg(pd.disiplin) as ratadis, avg(pd.total) as ratatotal FROM pegawai as p left join progress_ipasn2021djasn as pd
        on pd.nip=p.nip and pd.tgl_update = '".$tl."' WHERE p.fid_unit_kerja = '".$idunker."'");

      return $q;
  }

  public function tgl_updateterakhir()
  {
    $q = $this->db->query("select max(tgl_update) as tgl_update from progress_ipasn2021djasn");
    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->tgl_update;
    }
  }

  public function nilairata_pertanggal($tl)
  {
    $q = $this->db->query("select count(pd.nip) as jmldata, avg(pd.kualifikasi) as ratakua, avg(pd.kompetensi) as ratakomp, avg(pd.kinerja) as ratakin,
        avg(pd.disiplin) as ratadis, avg(pd.total) as ratatotal FROM progress_ipasn2021djasn as pd WHERE pd.tgl_update = '".$tl."'");

      return $q;
  }


  // END Review Progress IPASN 2021 DJASN BKN

}
/* End of file mpegawai.php */
/* Location: ./application/models/mpegawai.php */
