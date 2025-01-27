<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpppk extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  function getnipnama($data)
  {
  	$sess_nip = $this->session->userdata('nip');
  	$q = $this->db->query("select p.nipppk, p.gelar_depan, p.nama, p.gelar_blk, 
  		g.nama_golru, j.nama_jabft, p.fid_peta_jabatan, u.nama_unit_kerja, p.tmt_golru_pppk, p.photo
  		from pppk as p, ref_golru_pppk as g, ref_jabft as j, ref_unit_kerjav2 as u, ref_instansi_userportal as i
  		where
  		p.fid_golru_pppk = g.id_golru
		and p.fid_jabft = j.id_jabft
  		and p.fid_unit_kerja = u.id_unit_kerja
  		and u.fid_instansi_userportal = i.id_instansi 
  		and i.nip_user like '%$sess_nip%'
  		and (p.nipppk like '%$data%' OR p.nama like '%$data%')
  		order by p.fid_golru_pppk desc, p.tmt_golru_pppk");
  	return $q;        
  }
  
  /*
  function getnipnama($data)
    {
      $sess_nip = $this->session->userdata('nip');
        $q = $this->db->query("select p.nipppk, p.gelar_depan, p.nama, p.gelar_blk,
        g.nama_golru, p.fid_jabft, u.nama_unit_kerja, p.tmt_golru_skr
        from pppk as p, ref_golru_pppk as g, ref_unit_kerjav2 as u, ref_instansi_userportal as i
        where p.fid_golru_pppk = g.id_golru
        and p.fid_unit_kerja = u.id_unit_kerja
        and u.fid_instansi_userportal = i.id_instansi
        and i.nip_user like '%$sess_nip%'
        and (p.nipppk like '%$data%' OR p.nama like '%$data%')
        order by p.fid_golru_pppk desc, p.tmt_golru_skr");
        //$q = $this->db->query("select * from pegawai where fid_unit_kerja='$id'");
        return $q;
    }
  */

  function getfidunker($nipppk)
  {
  	$q = $this->db->query("select fid_unit_kerja from pppk where nipppk='$nipppk'");
  	if ($q->num_rows()>0)
  	{
  		$row=$q->row();
  		return $row->fid_unit_kerja; 
  	}        
  }  

  function getkeltugas_jft_nipppk($nipppk)
  {
    $q = $this->db->query("select j.kelompok_tugas from ref_jabft as j, pppk as p where p.fid_jabft = j.id_jabft and p.nipppk='$nipppk'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $kelompok_tugas = $row->kelompok_tugas;      
      return $kelompok_tugas;
    }        
  }

  public function getnama_lengkap($nipppk)
  {
  	$q = $this->db->query("select gelar_depan, nama, gelar_blk from pppk where nipppk='$nipppk'");
  	if ($q->num_rows() > 0)
  	{
  		$row=$q->row();
  		$joinString = namagelar($row->gelar_depan, $row->nama, $row->gelar_blk);
  		return $joinString;
  	} 
  }

  function getnama($nip)
 	{
 		$q= $this->db->get_where('pppk', ['nipppk' => $nip])->row();
 		return $q->nama;
 	}
 
   function getjnskel($nip)
        {
                $q= $this->db->get_where('pppk', ['nipppk' => $nip])->row();
                return $q->jns_kelamin;
        }

 function getphoto($nip)
 	{
 		$q= $this->db->get_where('pppk', ['nipppk' => $nip])->row();
 		return $q->photo;
 	}
  
  function p3kperunker($id)
  {
    $q = $this->db->query("select p3k.*, u.nama_unit_kerja, j.nama_jabft, g.nama_golru      
    	from pppk as p3k, ref_unit_kerjav2 as u, ref_jabft as j, ref_golru_pppk as g
      where p3k.fid_unit_kerja = u.id_unit_kerja
      and p3k.fid_jabft = j.id_jabft
      and p3k.fid_golru_pppk = g.id_golru
      and p3k.fid_unit_kerja='$id'
      order by p3k.created_at asc");
    return $q;
  }
  
  function getjmlperunker($id)
  {
    $q = $this->db->query("select * from pppk where fid_unit_kerja='$id'");
    return $q->num_rows();
  }
  
  public function getbyniknama($data)
    {
        
     	$this->db->select('np.*, u.nama_unit_kerja, j.nama_jabft, g.nama_golru');  
     	$this->db->from('pppk as np');
     	$this->db->join('ref_unit_kerjav2 as u', 'np.fid_unit_kerja = u.id_unit_kerja'); 
     	$this->db->join('ref_jabft as j', 'np.fid_jabft = j.id_jabft');      
     	$this->db->join('ref_golru_pppk as g', 'np.fid_golru_pppk = g.id_golru');    
     	$this->db->where('np.nipppk', $data);
     	$this->db->or_like('np.nama', $data);
     	$this->db->order_by('np.created_at', 'asc');
     	return $this->db->get();  
    }
    
  public function detail($nip) {
  	return $this->db->select('p.*, a.nama_agama, sk.nama_status_kawin, kel.nama_kelurahan, kec.nama_kecamatan, tp.nama_tingkat_pendidikan,
  						jp.nama_jurusan_pendidikan, u.nama_unit_kerja, jft.nama_jabft, g.nama_golru')
  						->from('pppk AS p')
  						->join('ref_agama AS a', 'p.fid_agama = a.id_agama')
  						->join('ref_status_kawin AS sk', 'p.fid_status_kawin = sk.id_status_kawin')
  						->join('ref_kelurahan AS kel', 'p.fid_keldesa = kel.id_kelurahan')
  						->join('ref_kecamatan AS kec', 'kel.fid_kecamatan = kec.id_kecamatan')
  						->join('ref_tingkat_pendidikan AS tp', 'p.fid_tingkat_pendidikan = tp.id_tingkat_pendidikan')
  						->join('ref_jurusan_pendidikan AS jp', 'p.fid_jurusan_pendidikan = jp.id_jurusan_pendidikan')
  						->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja = u.id_unit_kerja')
  						->join('ref_jabft AS jft', 'p.fid_jabft = jft.id_jabft')
  						->join('ref_golru_pppk AS g', 'p.fid_golru_pppk = g.id_golru')
  						->where('nipppk', $nip)
  						->get();
  }
  function jabatan()
  {
    $sql = "SELECT * from ref_jabft ORDER BY nama_jabft";
    return $this->db->query($sql);
  }
  function golru() 
  {
  	return $this->db->order_by('id_golru', 'asc')->get('ref_golru_pppk');
  }
  function insert_pppk($data) {
  	return $this->db->insert('pppk', $data);
  }
  function edit_pppk($whr, $data) {
  	$this->db->where($whr);
  	$this->db->update('pppk', $data);
  	return true;
  }
  function hapus_pppk($where){
    $this->db->where($where);
    $this->db->delete('pppk');
    return true;
  }
 
  function pppkperunker($id)
    {
        $q = $this->db->query("select p.*, g.nama_golru
        from pppk as p, ref_golru_pppk as g
        where p.fid_golru_pppk = g.id_golru
        and p.fid_unit_kerja='$id'
        order by p.fid_golru_pppk desc, p.tmt_golru_pppk");
        return $q;
    }

  function getnamagolru($id)
  {
    $q = $this->db->query("select nama_golru from ref_golru_pppk where id_golru='".$id."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_golru; 
    }        
  }

  function getidgolruterakhir($nipppk)
  {
    $q = $this->db->query("select fid_golru_pppk from pppk where nipppk='".$nipppk."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->fid_golru_pppk; 
    }        
  }  
	
	function status_ptkp() {
		$q = $this->db->get('ref_status_ptkp');
		return $q;
	}
	
	function getstatus_ptkp($id) {
		$q = $this->db->get_where('ref_status_ptkp', ['id_status_ptkp' => $id]);
		if($q->num_rows() > 0) {
			$row = $q->row();
			$var = $row->status;
		} else {
			$var = "Status PTKP Belum ditentukan";
		}
		return $var;
	}
	function getketerangan_ptkp($id) {
		$q = $this->db->get_where('ref_status_ptkp', ['id_status_ptkp' => $id]);
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->keterangan;
		}
	}

	public function rwygaji($nipppk)
  	{
    		$q = $this->db->query("select * from riwayat_gaji_pppk where nipppk='$nipppk' ORDER BY tahun desc, bulan desc");
    		return $q;
  	}

	public function rwytppng($nip)
  	{
    		$q = $this->db->query("select * from tppng where nip='$nip' ORDER BY tahun desc, bulan desc");
		return $q;
  	}


	public function rwykinerja($nip)
  	{
    		$q = $this->db->query("select * from kinerja_bulanan_pppk where nipppk='$nip' ORDER BY tahun desc, bulan desc");
    		return $q;
  	}

        public function rwykinerjabkn($nip)
        {
                $q = $this->db->query("select * from riwayat_kinerja_bkn where nip='$nip' ORDER BY tahun desc, bulan desc");
                return $q;
        }

	public function rwyabsensi($nip)
  	{
    		$q = $this->db->query("select * from absensi_pppk where nipppk='$nip' ORDER BY tahun desc, bulan desc");
    		return $q;
  	}

	public function rwycuti($nip)
  	{
    		$q = $this->db->query("select * from riwayat_cuti_pppk where nipppk='$nip' ORDER BY thn_cuti desc");
    		return $q;
  	}

        public function rwykgb($nip)
        {
                $q = $this->db->query("select * from riwayat_kgb_pppk where nipppk='$nip' ORDER BY tmt desc");
                return $q;
        }

        public function rwyot($nip)
        {
         $q = $this->db->query("select * from riwayat_ortu_pppk where nipppk='$nip' ORDER BY jenis asc");
         return $q;
        }

  	public function rwyst($nip)
  	{
    	 $q = $this->db->query("select * from riwayat_sutri_pppk where nipppk='$nip' ORDER BY tgl_nikah desc");
    	 return $q;
  	}

  	public function rwyanak($nip)
  	{
    	 $q = $this->db->query("select * from riwayat_anak_pppk where nipppk='$nip' ORDER BY tgl_lahir asc");
    	 return $q;
  	}

  function input_sutri($data){
    $this->db->insert('riwayat_sutri_pppk',$data);
    return true;
  }

  // cek apakah nip, nama dan tgl_nikah yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_sutri($nip, $tgl_nikah)
  {
    $q = $this->db->query("select tgl_nikah from riwayat_sutri_pppk where nipppk='".$nip."' and tgl_nikah='".$tgl_nikah."'");
    return $q->num_rows();
  }

  function get_sutri_id($id)
  {
    $q = $this->db->query("select * from riwayat_sutri_pppk where id='".$id."'");
    return $q;
  }

  function cek_adasutri($nip, $tgl_nikah)
  {
    $q = $this->db->query("select nama_sutri from riwayat_sutri_pppk where nipppk='".$nip."' and tgl_nikah='".$tgl_nikah."'");
    return $q->num_rows();
  }

  function hapus_sutri($where){
    $this->db->where($where);
    $this->db->delete('riwayat_sutri_pppk');
    return true;
  }

  function cek_jmlsutri($nip) {
    $q = $this->db->query("select nip from riwayat_sutri_pppk where nipppk='".$nip."'");
    return $q->num_rows();
  }

  public function detailsutri($nip, $tgl_nikah) {
    $q = $this->db->query("select * from riwayat_sutri_pppk where nipppk='".$nip."' and tgl_nikah='".$tgl_nikah."'");
    return $q;
  }
  function edit_sutri($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_sutri_pppk',$data);
    return true;
  }

  public function getnamaibubapak($id) {
    $q = $this->db->query("select nama_sutri from riwayat_sutri_pppk where id='".$id."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_sutri;
    }
  }

  public function getibubapak($nip) {
    $q = $this->db->query("select id, nama_sutri from riwayat_sutri_pppk where nipppk='".$nip."'");
    return $q;	
  }

  function input_anak($data){
    $this->db->insert('riwayat_anak_pppk',$data);
    return true;
  }

  // cek apakah nip, nama dan tgl_nikah yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_anak($nip, $nama, $tgl_lahir) {
    $q = $this->db->query("select tgl_lahir from riwayat_anak_pppk where nipppk='".$nip."' and nama_anak='".$nama."' and tgl_lahir='".$tgl_lahir."'");
    return $q->num_rows();
  }

  function get_anak_id($id)
  {
    $q = $this->db->query("select * from riwayat_anak_pppk where id='".$id."'");
    return $q;
  }

  function hapus_anak($where) {
    $this->db->where($where);
    $this->db->delete('riwayat_anak_pppk');
    return true;
  }

   function cek_adaanak($nip, $nama_anak, $tgl_lahir) {
    $q = $this->db->query("select nama_anak from riwayat_anak_pppk where nipppk='".$nip."' and nama_anak='".$nama_anak."' and tgl_lahir='".$tgl_lahir."'");
    return $q->num_rows();
  }

  function cek_sutriadaanak($nip, $id_sutri) {
    $q = $this->db->query("select nama_anak from riwayat_anak_pppk where nipppk='".$nip."' and fid_sutri='".$id_sutri."'");
    return $q->num_rows();
  }

  public function detailanak($nip, $nama_anak, $tgl_lahir) {
    $q = $this->db->query("select * from riwayat_anak_pppk where nipppk='".$nip."' and nama_anak='".$nama_anak."' and tgl_lahir='".$tgl_lahir."'");
    return $q;
  }

  function edit_anak($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_anak_pppk',$data);
    return true;
  }

  function cek_adaortu($nip, $jenis)
  {
    $q = $this->db->query("select jenis from riwayat_ortu_pppk where nipppk='".$nip."' AND jenis='".$jenis."'");
    return $q->num_rows();
  }

  function input_ortu($data){
    $this->db->insert('riwayat_ortu_pppk',$data);
    return true;
  }

  function edit_ortu($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_ortu_pppk',$data);
    return true;
  }

  function hapus_ortu($where) {
    $this->db->where($where);
    $this->db->delete('riwayat_ortu_pppk');
    return true;
  }

  function get_ortu_id($id)
  {
    $q = $this->db->query("select * from riwayat_ortu_pppk where id='".$id."'");
    return $q;
  }

  // Start Riwayat Diklat

  public function rwydf($nip)
  {
    $q = $this->db->query("select df.nipppk, df.no, df.nama_diklat_fungsional, df.instansi_penyelenggara, df.tempat, df.tahun,
        df.lama_bulan, df.lama_hari, df.lama_jam, df.pejabat_sk, df.no_sk, df.tgl_sk
        from riwayat_diklat_fungsional_pppk as df where df.nipppk='$nip' ORDER BY df.tahun desc");
    return $q;
  }

  public function rwydt($nip)
  {
    $q = $this->db->query("select dt.nipppk, dt.no, dt.nama_diklat_teknis, dt.instansi_penyelenggara, dt.tempat, dt.tanggal, dt.tahun,
        dt.lama_bulan, dt.lama_hari, dt.lama_jam, dt.pejabat_sk, dt.no_sk, dt.tgl_sk from riwayat_diklat_teknis_pppk as dt where dt.nipppk='$nip' ORDER BY dt.tahun desc");
    return $q;
  }

  public function rwyws($nip)
  {
    $q = $this->db->query("select ws.* from riwayat_workshop_pppk as ws where ws.nipppk='$nip' ORDER BY ws.tahun desc");
    return $q;
  }

  function input_dikfung($data){
    $this->db->insert('riwayat_diklat_fungsional_pppk',$data);
    return true;
  }

  function cek_dikfung($nip, $nama, $tahun)
  {
    $q = $this->db->query("select no from riwayat_diklat_fungsional_pppk where nipppk='".$nip."' and nama_diklat_fungsional='".$nama."' and tahun='".$tahun."'");
    return $q->num_rows();
  }

  function cek_adadikfung($nip, $no, $tahun)
  {
    $q = $this->db->query("select no from riwayat_diklat_fungsional_pppk where nipppk='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q->num_rows();
  }

  function hapus_dikfung($where){
    $this->db->where($where);
    $this->db->delete('riwayat_diklat_fungsional_pppk');
    return true;
  }

  public function detaildikfung($nip, $no, $tahun)
  {;
    $q = $this->db->query("select * from riwayat_diklat_fungsional_pppk where nipppk='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q;
  }

  function edit_dikfung($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_diklat_fungsional_pppk',$data);
    return true;
  }

  function input_diktek($data){
    $this->db->insert('riwayat_diklat_teknis_pppk',$data);
    return true;
  }

  function cek_diktek($nip, $nama, $tahun)
  {
    $q = $this->db->query("select no from riwayat_diklat_teknis_pppk where nipppk='".$nip."' and nama_diklat_teknis='".$nama."' and tahun='".$tahun."'");
    return $q->num_rows();
  }
  function cek_adadiktek($nip, $no, $tahun)
  {
    $q = $this->db->query("select no from riwayat_diklat_teknis_pppk where nipppk='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q->num_rows();
  }

  function hapus_diktek($where){
    $this->db->where($where);
    $this->db->delete('riwayat_diklat_teknis_pppk');
    return true;
  }

  public function detaildiktek($nip, $no, $tahun)
  {;
    $q = $this->db->query("select * from riwayat_diklat_teknis_pppk where nipppk='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q;
  }
  function edit_diktek($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_diklat_teknis_pppk',$data);
    return true;
  }

  function input_ws($data){
    $this->db->insert('riwayat_workshop_pppk',$data);
    return true;
  }

  // cek apakah nip, nama diklat dan tahun yang sama sudah pernah dientri, untuk menghindari entri data rangkap
  function cek_ws($nip, $nama, $tahun)
  {
    $q = $this->db->query("select no from riwayat_workshop_pppk where nipppk='".$nip."' and nama_workshop='".$nama."' and tahun='".$tahun."'");
    return $q->num_rows();
  }

  function cek_adaws($nip, $no, $tahun)
  {
    $q = $this->db->query("select no from riwayat_workshop_pppk where nipppk='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q->num_rows();
  }

  function hapus_ws($where){
    $this->db->where($where);
    $this->db->delete('riwayat_workshop_pppk');
    return true;
  }

  public function detailws($nip, $no, $tahun)
  {;
    $q = $this->db->query("select * from riwayat_workshop_pppk where nipppk='".$nip."' and no='".$no."' and tahun='".$tahun."'");
    return $q;
  }

  function edit_ws($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_workshop_pppk',$data);
    return true;
  }



  // End Riwayat Diklat

}
