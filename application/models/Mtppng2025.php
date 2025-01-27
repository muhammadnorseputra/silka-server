<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtppng2025 extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  function dd_unker()
  {
        //$sql = "SELECT * from ref_unit_kerja";
    $nip = $this->session->userdata('nip');
    $sql = "select u.nama_unit_kerja, u.id_unit_kerja
    from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
    WHERE
    u.fid_instansi_userportal = i.id_instansi
    and u.unker_ekinerja != ''
    and up.nip = '$nip'
    and i.nip_user like '%$nip%'
    order by u.id_unit_kerja";
    return $this->db->query($sql);
	//and (nama_unit_kerja not like 'RUMAH SAKIT%' OR nama_unit_kerja not like 'PUSKESMAS%')	 
 }

  function periode()
  {
    $q = $this->db->query("select * from tppng_periode where tahun='2025' order by id asc");
    return $q;
  }

  function periode2025()
  {
    $q = $this->db->query("select * from tppng_periode where tahun='2025' order by id desc");
    return $q;
  }

  function get_pengantar($id_periode)
  {
    $nip = $this->session->userdata('nip');
    //$q = $this->db->query("select * from tppng_pengantar where fid_periode = '".$id_periode."'");
    $q = $this->db->query("select tp.* from tppng_pengantar as tp, ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
      where tp.fid_periode = '".$id_periode."'
      and u.fid_instansi_userportal = i.id_instansi
      and tp.fid_unker = u.id_unit_kerja
      and up.nip = '$nip'
      and i.nip_user like '%$nip%'
      order by status asc, entri_at asc");
    return $q;
  }

  function get_pengantar_orderunor($id_periode)
  {
    $nip = $this->session->userdata('nip');
    //$q = $this->db->query("select * from tppng_pengantar where fid_periode = '".$id_periode."'");
    $q = $this->db->query("select tp.* from tppng_pengantar as tp, ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
      where tp.fid_periode = '".$id_periode."'
      and u.fid_instansi_userportal = i.id_instansi
      and tp.fid_unker = u.id_unit_kerja
      and up.nip = '$nip'
      and i.nip_user like '%$nip%'
      order by u.nama_unit_kerja");
    return $q;
  }

  function tampil_tppng($idpengantar, $idperiode)
  {
    $q = $this->db->query("select tppng.*, tppng_pengantar.berkas from tppng JOIN tppng_pengantar ON tppng.fid_pengantar=tppng_pengantar.id where tppng.fid_pengantar = '".$idpengantar."' AND tppng.fid_periode = '".$idperiode."'");
    return $q;
  }

  function cetak_tandaterima($idpengantar, $idperiode)
  {
    $q = $this->db->query("select * from tppng where fid_pengantar = '".$idpengantar."' AND fid_periode = '".$idperiode."' order by kelasjab desc, basic_total desc");
    return $q;
  }

  public function get_tahunperiode($idperiode)
  {
    $q = $this->db->query("select tahun from tppng_periode where id = '$idperiode'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->tahun; 
    }        
  }

  public function get_bulanperiode($idperiode)
  {
    $q = $this->db->query("select bulan from tppng_periode where id = '$idperiode'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->bulan; 
    }        
  }

  public function get_idunker($idpengantar)
  {
    $q = $this->db->query("select fid_unker from tppng_pengantar where id = '$idpengantar'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_unker; 
    }        
  }

  public function get_jnsasn($idpengantar)
  {
    $q = $this->db->query("select jenis_asn from tppng_pengantar where id = '$idpengantar'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->jenis_asn; 
    }        
  }

  function cektelahusul($nip, $tahun, $bulan)
  { 
    $q = $this->db->query("select nip from tppng where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");  

    return $q->num_rows();
  }

  function input_tppng($data)
  {
    $this->db->insert('tppng',$data);
    return true;
  }

  function get_statustppng($idstatus)
  {
    $q = $this->db->query("select nama_status from ref_statustppng where id_status='$idstatus'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_status; 
    }        
  }

  function hapustppng($where){
    $this->db->where($where);
    $this->db->delete('tppng');
    return true;
  }

  public function get_jmlperpengantar($idpengantar)
  {
    $query = $this->db->query("SELECT * FROM tppng WHERE fid_pengantar = '".$idpengantar."'");

    if($query->num_rows() > 0) {
      return $query->num_rows();     
    }
  }

  public function get_jmlperperiode($idperiode)
  {
    $query = $this->db->query("SELECT * FROM tppng WHERE fid_periode = '".$idperiode."'");

    if($query->num_rows() > 0) {
      return $query->num_rows();     
    }
  }

  public function getratakinerja_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(nilai_produktifitas) as nilai from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $nilai = $row->nilai;
      $jml = $this->get_jmlperpengantar($idpengantar);
      if ($jml != 0) {
        $rata = $nilai / $jml;
      } else {
        $rata = 0;
      }
      return $rata; 
    }
  }

  public function getrataabsensi_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(nilai_disiplin) as nilai from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $nilai = $row->nilai;
      $jml = $this->get_jmlperpengantar($idpengantar);
      if ($jml != 0) {
        $rata = $nilai / $jml;
      } else {
        $rata = 0;
      }
      return $rata; 
    }
  }

  public function gettotalbk_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(real_bk) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalpk_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(real_pk) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalkk_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(real_kk) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotaltb_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(real_tb) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalkp_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(real_kp) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalreal_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(real_total) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalpph_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(jml_pph) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotaliwp_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(jml_iwp) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalbpjs_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(jml_bpjs) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalthp_perbulan($idpengantar)
  {
    $q = $this->db->query("select sum(tpp_diterima) as total from tppng WHERE fid_pengantar = '".$idpengantar."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  function cektelahusul_pengantar($idperiode, $idunker, $jnsasn)
  { 
    $q = $this->db->query("select status from tppng_pengantar where fid_periode='".$idperiode."' and fid_unker='".$idunker."' and jenis_asn='".$jnsasn."'");  

    return $q->num_rows();
  }

  function input_tppng_pengantar($data)
  {
    $this->db->insert('tppng_pengantar',$data);
    return true;
  }

  function hapustppng_pengantar($where){
    $this->db->where($where);
    $this->db->delete('tppng_pengantar');
    return true;
  }

  function edit_tppng($where, $data){
    $this->db->where($where);
    $this->db->update('tppng',$data);
    return true;
  }

  function edit_tppngpengantar($where, $data){
    $this->db->where($where);
    $this->db->update('tppng_pengantar',$data);
    return true;
  }

  public function cek_adastatusinput($idpengantar)
  {
    $q = $this->db->query("select fid_status from tppng WHERE fid_pengantar = '".$idpengantar."' AND fid_status='1'");
    return $q->num_rows();
  }

  public function get_statuspengantar($idpengantar)
  {
    $q = $this->db->query("select status from tppng_pengantar where id = '$idpengantar'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->status; 
    }        
  }

  // Get Total Per Periode
  public function getratakinerja_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(nilai_produktifitas) as nilai from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $nilai = $row->nilai;
      $jml = $this->get_jmlperperiode($idperiode);
      if ($jml != 0) {
        $rata = $nilai / $jml;
      } else {
        $rata = 0;
      }
      return $rata; 
    }
  }

  public function getrataabsensi_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(nilai_disiplin) as nilai from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      $nilai = $row->nilai;
      $jml = $this->get_jmlperperiode($idperiode);
      if ($jml != 0) {
        $rata = $nilai / $jml;
      } else {
        $rata = 0;
      }
      return $rata; 
    }
  }

  public function gettotalbk_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(real_bk) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalpk_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(real_pk) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalkk_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(real_kk) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotaltb_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(real_tb) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalkp_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(real_kp) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalreal_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(real_total) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalpph_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(jml_pph) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotaliwp_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(jml_iwp) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalbpjs_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(jml_bpjs) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }

  public function gettotalthp_perperiode($idperiode)
  {
    $q = $this->db->query("select sum(tpp_diterima) as total from tppng WHERE fid_periode = '".$idperiode."'");

    if ($q->num_rows() > 0)
    {
      $row=$q->row();
      return $row->total;
    }
  }
  // End Total Per Periode

  function get_idunker_pns($nip)
  {
    $q = $this->db->query("select fid_unit_kerja from pegawai where nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_unit_kerja; 
    }        
  }

  function get_idunker_pppk($nipppk)
  {
    $q = $this->db->query("select fid_unit_kerja from pppk where nipppk='$nipppk'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_unit_kerja; 
    }        
  }

  function getqrcode($idpengantar)
  {
    $sqlspk = $this->db->query("select qrcode from tppng_pengantar WHERE id = '".$idpengantar."'");
    if ($sqlspk->num_rows()>0)
    {
      $row=$sqlspk->row();
      return $row->qrcode; 
    }    
  }

  function get_bpjsgaji($nip, $thn, $bln)
  {
    $q = $this->db->query("select bpjs from riwayat_gaji where tahun = '".$thn."' and bulan = '".$bln."' and nip='".$nip."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->bpjs; 
    } else {
      return 0;
    }
  }

  function get_bpjsgaji_pppk($nip, $thn, $bln)
  {
    $q = $this->db->query("select bpjs from riwayat_gaji_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nip."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->bpjs; 
    } else {
      return 0;
    }
  }

  function get_nipkepala($idpengantar)
  {
    $sqlspk = $this->db->query("select nip_kepala from tppng_pengantar WHERE id = '".$idpengantar."'");
    if ($sqlspk->num_rows()>0)
    {
      $row=$sqlspk->row();
      return $row->nip_kepala; 
    }    
  }

  function get_nipbendahara($idpengantar)
  {
    $sqlspk = $this->db->query("select nip_bendahara from tppng_pengantar WHERE id = '".$idpengantar."'");
    if ($sqlspk->num_rows()>0)
    {
      $row=$sqlspk->row();
      return $row->nip_bendahara; 
    }    
  }

  function get_jnsptkp_rwykel($nip) {
	$st = $this->db->query("select nip from riwayat_sutri where nip='".$nip."' and tanggungan = 'YA' and status_hidup = 'YA'");
	$jml_sutri = $st->num_rows();
	if ($jml_sutri > "1") $jml_sutri = 1; // maksimal 1 istri

	$anak = $this->db->query("select nip from riwayat_anak where nip='".$nip."' and tanggungan = 'YA' and status_hidup = 'YA'");
        $jml_anak = $anak->num_rows();
	if ($jml_anak > "3") $jml_anak = 3; // maksimal 3 anak
	
	$jns_ptkp = $this->db->query("select jenis_ptkp from ref_ptkp where jml_sutri='".$jml_sutri."' and jml_anak='".$jml_anak."'");
	if ($jns_ptkp->num_rows() > 0) {
		$row = $jns_ptkp->row();
		$hasil = $row->jenis_ptkp;
		return $hasil;
	} else {
		return "TK/0";
	}
  }

  function get_ketptkp($jns_ptkp) {
    $sqlspk = $this->db->query("select keterangan from ref_status_ptkp WHERE status = '".$jns_ptkp."'");
    if ($sqlspk->num_rows()>0)
    {
      $row=$sqlspk->row();
      return $row->keterangan;
    }
  }

  function update_pembayaran($whr, $data) {
    $this->db->where($whr);
    $this->db->update('tppng_pengantar', $data);
  }
  function update_status($tbl, $data, $whr) {
    $this->db->where($whr);
    $this->db->update($tbl, $data);
  }

  function cekstatusberkaspengantar_bulanlalu($idperiode, $idunker, $jnsasn)
  {
    $tahun = $this->get_tahunperiode($idperiode);
    $bulan = $this->get_bulanperiode($idperiode);
    $bulanlalu = $bulan-1;
    /*
    if ($bulan == '14') { // Untuk THR 2023 pada bulan April
  	$bulanlalu = '3';  
    } else {
    	$bulanlalu = $bulan-1;
    }
    */
 
    if ($bulan == '1') {
	$bulanlalu = '12';
	$tahun = $tahun-1;	
    }
	
    //var_dump($bulanlalu);
    $getperiode_bulanlalu = $this->db->query("select id from tppng_periode where tahun = '$tahun' AND bulan = '$bulanlalu'");
    //var_dump($getperiode_bulanlalu);
    if ($getperiode_bulanlalu->num_rows()>0)
    {
      $row=$getperiode_bulanlalu->row();
      $idperiode_bulanlalu = $row->id;
    }
    //var_dump($idperiode_bulanlalu);

    $getstatus_bulanlalu = $this->db->query("select status from tppng_pengantar where fid_periode = '$idperiode_bulanlalu' AND fid_unker = '$idunker' AND jenis_asn = '$jnsasn'");
    if ($getstatus_bulanlalu->num_rows()>0)
    {
      $row=$getstatus_bulanlalu->row();
      $status_bulanlalu = $row->status;
    }
    //var_dump($status_bulanlalu);
    
    $getberkas_bulanlalu = $this->db->query("select berkas from tppng_pengantar where fid_periode = '$idperiode_bulanlalu' AND fid_unker = '$idunker' AND jenis_asn = '$jnsasn'");
    
    if ($getberkas_bulanlalu->num_rows()>0)
    {
      $row=$getberkas_bulanlalu->row();
      $berkas_bulanlalu = $row->berkas;
    }
    //var_dump($berkas_bulanlalu);

    if (($status_bulanlalu = 'SELESAI') AND ($berkas_bulanlalu != '')) { // Bulan lalu status selesai dan berkas ada
    //if ($status_bulanlalu = 'SELESAI') { // Bulan lalu status selesai dan berkas ada
	return true;
    } else { 
	return false;
    }
  }

  public function get_statusperiode($idperiode)
  {
    $q = $this->db->query("select status from tppng_periode where id = '$idperiode'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->status;
    }
  }

  function get_tarifpph21_pp582023($kat, $pengbruto)
  {
    $sqlspk = $this->db->query("select tarif from ref_tarifpph21_pp582023 WHERE kategori = '".$kat."' AND (bruto_min <= '".$pengbruto."' AND bruto_maks >= '".$pengbruto."')");
    if ($sqlspk->num_rows()>0)
    {
      $row=$sqlspk->row();
      return $row->tarif;
    }
  }

  function get_kategori_pp582023($jnsptkp)
  {
    if ($jnsptkp == 'TK/0' OR $jnsptkp == 'TK/1' OR $jnsptkp == 'K/0') {
        $kategori = 'A';
    } else if ($jnsptkp == 'TK/2' OR $jnsptkp == 'TK/3' OR $jnsptkp == 'K/1' OR $jnsptkp == 'K/2') {
        $kategori = 'B';
    } else if ($jnsptkp == 'K/3') {
        $kategori = 'C';
    }

    return $kategori;
  }

  public function get_ptkpgaji_pns($nip, $thn, $bln)
  {
    $q = $this->db->query("select ptkp from riwayat_gaji where nip = '$nip' AND tahun = '$thn' AND bulan = '$bln'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->ptkp;
    }
  }

  public function get_ptkpgaji_pppk($nipppk, $thn, $bln)
  {
    $q = $this->db->query("select ptkp from riwayat_gaji_pppk where nipppk = '$nipppk' AND tahun = '$thn' AND bulan = '$bln'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->ptkp;
    }
  }

  public function get_berkasskpbulanan($nip, $thn, $bln)
  {
    $q = $this->db->query("select berkas from riwayat_kinerja_bkn where nip = '$nip' AND tahun = '$thn' AND bulan = '$bln'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->berkas;
    }
  }

  public function get_berkaslhkpn($nip, $thn)
  {
    $q = $this->db->query("select file_tbn from riwayat_lhkpn where nip = '$nip' AND tahun_wajib = '$thn'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->file_tbn;
    }
  }

  public function hitungpph($nip, $thn, $bln, $tppbruto) {
    $gajibruto =  $this->mkinerja->get_gajibruto($nip, $thn, $bln);
    if ($bln == '14') {
        $bkn = '2';
        $gajibruto = 0;
    } else if ($bln == '15') {
        $bln = '4';
        $gajibruto = 0;
    }
    //$jnsptkp =  $this->mkinerja->get_jnsptkp($nip); // Jenis PTKP dari tabel Pegawai
    //$jnsptkp = $this->mtppng2025->get_jnsptkp_rwykel($nip); // Ambil jenis PTKP dari Riwayat Keluarga
    $jnsptkp = $this->mtppng2025->get_ptkpgaji_pns($nip, $thn, $bln); // Ambil jenis PTKP dari Data Gaji
    $jnskel =  $this->mpegawai->getjnskel($nip);
    //if (($jnsptkp == '') OR ($jnsptkp == NULL) OR ($jnskel == 'PEREMPUAN')) { // PNS wanita dihitung TK/0
    if (($jnsptkp == '') OR ($jnsptkp == NULL)) { // jika data ptkp kosong, maka dihitung TK/0
      $jnsptkp = 'TK/0';
      $ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    } else {
      $ptkp =  $this->mkinerja->get_ptkp($jnsptkp);
      //echo $ptkp;
    }

    $npwp =  $this->mkinerja->get_npwp($nip);

    $jmlpot =  $this->mkinerja->get_jmlpotongan($nip, $thn, $bln);

    $pengbruto = $gajibruto + $tppbruto;

    //$pengnetto = $pengbruto-$jmlpot;

    $kategori = $this->mtppng2025->get_kategori_pp582023($jnsptkp);

    $tarif =  $this->mtppng2025->get_tarifpph21_pp582023($kategori, $pengbruto);
    $pph_kotor = ($pengbruto * $tarif)/100;
    return $pph_kotor;
  }

  public function hitungpph_pppk($nip, $thn, $bln, $tppbruto) {
    $gajibruto =  $this->mkinerja_pppk->get_gajibruto($nip, $thn, $bln);
    if ($bln == '14') {
        $bkn = '2';
	$gajibruto = 0;
    } else if ($bln == '15') {
        $bln = '4';
	$gajibruto = 0;
    }
    $jnsptkp = $this->mtppng2025->get_ptkpgaji_pppk($nip, $thn, $bln); // Ambil jenis PTKP dari Data Gaji
    if (($jnsptkp == '') OR ($jnsptkp == NULL)) { // jika data ptkp kosong, maka dihitung TK/0
      $jnsptkp = 'TK/0';
      $ptkp = $this->mkinerja->get_ptkp($jnsptkp);
    } else {
      $ptkp =  $this->mkinerja->get_ptkp($jnsptkp);
      //echo $ptkp;
    }

    $npwp =  $this->mkinerja->get_npwp($nip);

    $jmlpot =  $this->mkinerja->get_jmlpotongan($nip, $thn, $bln);

    $pengbruto = $gajibruto + $tppbruto;

    //$pengnetto = $pengbruto-$jmlpot;

    $kategori = $this->mtppng2025->get_kategori_pp582023($jnsptkp);

    $tarif =  $this->mtppng2025->get_tarifpph21_pp582023($kategori, $pengbruto);
    $pph_kotor = ($pengbruto * $tarif)/100;
    return $pph_kotor;
  }

  function get_kinerja_bulanan($nip, $tahun, $bulan)
  {
      $q = $this->db->query("select * from riwayat_kinerja_bkn 
		where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");
      return $q;
  }

  function statustppng()
  {
    $q = $this->db->query("select * from ref_statustppng order by id_status");
    return $q;
  }

  function get_tpp_bulanan($nip, $tahun, $bulan)
  {
      $q = $this->db->query("select * from tppng where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");
      return $q;
  }

  function get_idjabpeta_tpp_bulanan($nip, $tahun, $bulan)
  {
      $q = $this->db->query("select fid_jabpeta from tppng where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");
      if ($q->num_rows()>0)
      {
        $row=$q->row();
        return $row->fid_jabpeta;
      } 	
  }  

  function get_idjabpetaplt_tpp_bulanan($nip, $tahun, $bulan)
  {
      $q = $this->db->query("select fid_jabpeta_plt from tppng where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");
      if ($q->num_rows()>0)
      {
        $row=$q->row();
        return $row->fid_jabpeta_plt;
      }
  }

  function get_persenplt_tpp_bulanan($nip, $tahun, $bulan)
  {
      $q = $this->db->query("select persen_plt from tppng where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");
      if ($q->num_rows()>0)
      {
        $row=$q->row();
        return $row->persen_plt;
      }
  }

  function pegperunker($id)
  {
        $q = $this->db->query("select p.nip, p.nama
        from pegawai as p
        where p.fid_unit_kerja='$id' order by p.nama");
        return $q;
  }

  function pppkperunker($id)
  {
        $q = $this->db->query("select p.nipppk as 'nip', p.nama
        from pppk as p
        where p.fid_unit_kerja='$id' order by p.nama");
        return $q;
  }

  public function cek_adabelumsyncgaji($idpengantar)
  {
    $q = $this->db->query("select is_sync_simgaji from tppng WHERE fid_pengantar = '".$idpengantar."' AND is_sync_simgaji='0'");
    return $q->num_rows();
  }

}
