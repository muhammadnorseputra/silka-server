<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpensiun extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  /* 
   * BEGIN Rekapitulasi dan Statistik Pensiun 
   * by Uda Wendy
  */ 

  public function gettahuntmt()
  {
    $q = $this->db->query("select YEAR(tmt_pensiun) as tahun from pensiun_detail group by YEAR(tmt_pensiun)");
    return $q; 
  }

  public function tampilrekappertahun($thn)
  {
    $q = $this->db->query("select pp.nip, concat(pp.gelar_depan,' ',pp.nama,' ',pp.gelar_belakang) as nama, pp.nama_jabatan, 
		pp.nama_unit_kerja, jp.nama_jenis_pensiun, pd.tmt_pensiun 
		from pegawai_pensiun as pp, pensiun_detail as pd, ref_jenis_pensiun as jp
		where pp.nip = pd.nip 
		and pd.fid_jenis_pensiun = jp.id_jenis_pensiun 
		and pd.tmt_pensiun like '".$thn."-%'		
		order by pd.tmt_pensiun, pd.fid_jenis_pensiun");
    return $q; 
  }

  public function tampilperorangan($nip)
  {
    $q = $this->db->query("select pp.nip, concat(pp.gelar_depan,' ',pp.nama,' ',pp.gelar_belakang) as nama, pp.nama_jabatan, pp.nama_unit_kerja, jp.nama_jenis_pensiun, pd.tmt_pensiun from pegawai_pensiun as pp, pensiun_detail as pd, ref_jenis_pensiun as jp where pp.nip = pd.nip and pd.fid_jenis_pensiun = jp.id_jenis_pensiun and (pp.nip like '".$nip."%' OR pp.nama like '%".$nip."%')  order by pd.tmt_pensiun, pd.fid_jenis_pensiun");
    return $q; 
  }

  public function getjenispensiun()
  {
    $data = $this->db->query("select nama_jenis_pensiun from ref_jenis_pensiun where nama_jenis_pensiun in ('BUP', 'MENINGGAL DUNIA', 'ATAS PERMINTAAN SENDIRI')");
    return $data->result();
  }


  public function getjmltmtperbulan($tahun)
  {
    $query = $this->db->query("select MONTH(tmt_pensiun), count(nip) as 'jumlah', count(nip) as 'jumlah1' from pensiun_detail where tmt_pensiun like '".$tahun."-%' group by MONTH(tmt_pensiun) order by MONTH(tmt_pensiun)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  function getjmlbyjenis($jenis, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select nip from pensiun_detail where fid_jenis_pensiun = '$jenis' and tmt_pensiun like '".$thn."-%'");
    return $q->num_rows();
  }

  public function getjabasn()
  {
    $data = $this->db->query("select jab_asn from ref_eselon where nama_eselon in ('II/A', 'III/A', 'IV/A', 'JFU', 'JFT')");
    return $data->result();
  }

  function getjmlbyjabasn($jabasn, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select pd.nip from pensiun_detail as pd, pegawai_pensiun as pp, ref_eselon as e where pp.nip = pd.nip and pp.fid_eselon = e.id_eselon and e.jab_asn =  '".$jabasn."' and pd.tmt_pensiun like '".$thn."-%'");
    return $q->num_rows();
  }

  function getjnsjab($nip)
  {
    $q = $this->db->query("select e.jab_asn from pegawai_pensiun as pp, ref_eselon as e where pp.fid_eselon = e.id_eselon and pp.nip = '".$nip."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->jab_asn; 
    } 
  }

  function proyeksi()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.tgl_lahir, p.fid_unit_kerja, p.tmp_lahir, p.tgl_lahir, p.alamat, p.fid_jnsjab, p.fid_jabft, p.fid_jabfu, p.fid_jabatan,
            CASE
              WHEN p.fid_jnsjab = '1' THEN (select usia_pensiun from ref_jabstruk where id_jabatan = p.fid_jabatan)
              WHEN p.fid_jnsjab = '2' THEN (select usia_pensiun from ref_jabfu where id_jabfu = p.fid_jabfu)
               WHEN p.fid_jnsjab = '3' THEN (select usia_pensiun from ref_jabft where id_jabft = p.fid_jabft)
            ELSE 0 
            END AS usia_pensiun
          from pegawai as p, ref_unit_kerjav2 as u, ref_instansi_userportal as i
          where p.fid_unit_kerja=u.id_unit_kerja
	  and u.fid_instansi_userportal = i.id_instansi
          and i.nip_user like '%$sess_nip%'
	  order by p.tgl_lahir");
    return $q;
  }

  function getstatpeg($nip)
  {
    $q = $this->db->query("select sp.nama_status_pegawai from ref_status_pegawai as sp, pegawai as p where p.fid_status_pegawai = sp.id_status_pegawai and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_status_pegawai; 
    }        
  }
  
  /*
   ----------------------+++++---------------------
   END Rekapitulasi dan Statistik Pensiun 
   ----------------------+++++---------------------
  */

  // FILTERING NIP & NAMA DENGAN SARAN
  function filternipnama($tbl, $nip, $nama) { 
	$this->db->select('p.nip, p.nama');
	$this->db->from($tbl.' as p');
	$this->db->like('p.nip', $nip);
	$this->db->or_like('p.nama', $nama);
	$q = $this->db->get();
   	return $q;
  }
  
  //TAMPILKAN LIST YANG DI CARI
  function pensiun_nipnama($data) {
	    $sess_nip = $this->session->userdata('nip');
	    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, 
	    g.nama_golru, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, e.nama_eselon, p.tmt_golru_skr
	    from pegawai as p, ref_eselon as e, ref_golru as g, ref_unit_kerjav2 as u, ref_instansi_userportal as i
	    where p.fid_eselon = e.id_eselon
	    and p.fid_golru_skr = g.id_golru
	    and p.fid_unit_kerja = u.id_unit_kerja
	    and u.fid_instansi_userportal = i.id_instansi 
	    and i.nip_user like '%$sess_nip%'
	    and (p.nip like '%$data%' OR p.nama like '%$data%')
	    order by p.fid_golru_skr desc, p.tmt_golru_skr");
	    //$q = $this->db->query("select * from pegawai where fid_unit_kerja='$id'");
	    return $q;        
	}
	
   // DETAIL PENSIUN
   public function pensiun_detail($nip) {
   	return $this->db->get_where('pegawai', ['nip' => $nip]);
   }
   
   // MUTASI DETAIL
   public function mutasi_detail($nip) {
   	return $this->db->get_where('pegawai', ['nip' => $nip]);
   }
   
   
   // get kelurahan
   function getkelurahan($id)
   {
    $q = $this->db->query("select kl.nama_kelurahan, kc.nama_kecamatan from ref_kelurahan as kl, ref_kecamatan as kc where kl.fid_kecamatan = kc.id_kecamatan and kl.id_kelurahan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if ($row->nama_kelurahan != 'LUAR BALANGAN')
      {
        $result = $row->nama_kelurahan;  
        return $result;
      }
    }
   }
  
  // get kecamatan 
  function getkecamatan($id)
   {
    $q = $this->db->query("select kl.nama_kelurahan, kc.nama_kecamatan from ref_kelurahan as kl, ref_kecamatan as kc where kl.fid_kecamatan = kc.id_kecamatan and kl.id_kelurahan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      if ($row->nama_kecamatan != 'LUAR BALANGAN')
      {
        $result = $row->nama_kecamatan;  
        return $result;
      }
    }
   }
   
  // get agama
  function getagama($id)
  {
    $q = $this->db->query("select nama_agama from ref_agama where id_agama='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_agama; 
    }        
  }
  
  // get status kawin
  function getstatkawin($id)
  {
    $q = $this->db->query("select nama_status_kawin from ref_status_kawin where id_status_kawin='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_status_kawin; 
    }        
  }
  
  // get tingkat pendidikan
  function gettingpen($id)
  {
    $q = $this->db->query("select nama_tingkat_pendidikan from ref_tingkat_pendidikan where id_tingkat_pendidikan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_tingkat_pendidikan; 
    }        
  }
  
  // get jurusan pendidikan
  function getjurpen($id)
  {
    $q = $this->db->query("select nama_jurusan_pendidikan from ref_jurusan_pendidikan where id_jurusan_pendidikan='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jurusan_pendidikan; 
    }        
  }
  
  // get status pegawai
  function getstatpegid($nip)
  {
    $q = $this->db->query("select sp.nama_status_pegawai, sp.id_status_pegawai from ref_status_pegawai as sp, pegawai as p 
    where p.fid_status_pegawai = sp.id_status_pegawai
    and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_status_pegawai; 
    }        
  }
  
  // get nama golru
  function getnamagolru($id)
  {
    $q = $this->db->query("select nama_golru from ref_golru where id_golru='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_golru; 
    }        
  }
  
  // get jenis pegawai
  public function getjnspeg($nip)
  {
    $q = $this->db->query("select jp.nama_jenis_pegawai from ref_jenis_pegawai as jp, pegawai as p where p.fid_jenis_pegawai = jp.id_jenis_pegawai and p.nip='$nip'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_pegawai; 
    }        
  }
  
  // get unit_kerja
  public function getunitkerja($id) {
  	$q = $this->db->select('nama_unit_kerja')->from('ref_unit_kerjav2')->where('id_unit_kerja', $id)->get()->row();
  	return $q->nama_unit_kerja;
  }
  
  // get jabatan
  public function namajab($idjnsjab, $idjab)
  {   
    $sqljnsjab = mysql_query("select * from ref_jenis_jabatan WHERE id_jenis_jabatan='".$idjnsjab."'");
    $jnsjab = mysql_result($sqljnsjab,0,'nama_jenis_jabatan');

   if ($jnsjab == "STRUKTURAL") {
        $sqljab = mysql_query("select j.nama_jabatan, e.jab_asn, j.usia_pensiun, j.kelompok_tugas, e.nama_eselon from ref_jabstruk as j, ref_eselon as e WHERE j.fid_eselon = e.id_eselon and id_jabatan='".$idjab."'");
        $jabatan = mysql_result($sqljab,0,'nama_jabatan');
    } else if ($jnsjab == "FUNGSIONAL UMUM") {
        $sqljab = mysql_query("select * from ref_jabfu WHERE id_jabfu='".$idjab."'");
        $jabatan = mysql_result($sqljab,0,'nama_jabfu');
    } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
        $sqljab = mysql_query("select * from ref_jabft WHERE id_jabft='".$idjab."'");
        $jabatan = mysql_result($sqljab,0,'nama_jabft');
    }
    return $jabatan;       
  }
  
  public function namajabnip($nip)
  {   
    $sqljnsjab = mysql_query("select fid_jnsjab, fid_jabatan, fid_jabft, fid_jabfu from pegawai WHERE nip='".$nip."'");
    $jnsjab = mysql_result($sqljnsjab,0,'fid_jnsjab');
    $fid_jabatan = mysql_result($sqljnsjab,0,'fid_jabatan');
    $fid_jabfu = mysql_result($sqljnsjab,0,'fid_jabfu');
    $fid_jabft = mysql_result($sqljnsjab,0,'fid_jabft');

    if ($jnsjab == 1) { $idjab = $fid_jabatan;
    }else if ($jnsjab == 2) { $idjab = $fid_jabfu;
    }else if ($jnsjab == 3) { $idjab = $fid_jabft;
    }

    $namajab = $this->namajab($jnsjab,$idjab);
    return $namajab;
  }
  
  // get nama eselon
  function getnamaeselon($id)
  {
    $q = $this->db->query("select nama_eselon from ref_eselon where id_eselon='".$id."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_eselon; 
    }        
  }
  
  //get instansi unitkerja 
  function getinstansi($idunker) {
  	$this->db->select('i.nama_instansi');
  	$this->db->from('ref_unit_kerjav2 AS u');
  	$this->db->join('ref_instansiv2 AS i', 'u.fid_instansi = i.id_instansi');
  	$this->db->where('u.id_unit_kerja', $idunker);
  	$q = $this->db->get()->row();
  	return $q->nama_instansi;
  }
  
  // simpan pegawai mutasi ke tabel pegawai_pensiun
  public function insert_mutasi($tbl, $data) {
  	return $this->db->insert($tbl, $data);
  }
  
  // simpan pegawai pensiun ke tabel pegawai_pensiun
  public function insert_pegawai_pensiun($tbl, $data) {
  	return $this->db->insert($tbl, $data);
  }

  // simpan pegawai pensiun ke tabel pegawai_pensiun
  public function insert_pensiun_detail($tbl, $data) {
  	return $this->db->insert($tbl, $data);
  }
    
  // hapus data pegawai yang mutasi
  public function delete_pegawai_mutasi($tbl, $whr) {
  	$this->db->where($whr);
  	$this->db->delete($tbl);
  }
  
  // simpan pegawai pensiun ke tabel pegawai_pensiun
  public function insert_pensiun($tbl, $data) {
  	return $this->db->insert($tbl, $data);
  }
  
  // hapus data pegawai yang pensiun pensiun
  public function delete_pegawai_pensiun($tbl, $whr) {
  	$this->db->where($whr);
  	$this->db->delete($tbl);
  }
	
	//rekap mutasi
	public $table_rekap = 'pegawai_pensiun as t';
	public $select_colums_rekap = array('t.*','CONCAT(t.gelar_depan," ",t.nama," ",t.gelar_belakang) AS nama_asn');
	public $order_colums_rekap = array(null, 't.nip', 't.nama', null, null);
	public $column_search_rekap = array('t.nip','t.nama');
	
	public function datatable_rekap() {
			$this->db->select($this->select_colums_rekap);
			$this->db->from($this->table_rekap);
			$this->db->where("not exists (select * from pensiun_detail where pensiun_detail.nip = t.nip)",null,false);
			$this->db->not_like('t.note', 'P3D');
			
			$i=0;
			foreach ($this->column_search_rekap as $item) { // loop column 
	                if (!empty($_POST['search']['value'])) { // if datatable send POST for search
	                if ($i === 0) { // first loop
	                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
	                    $this->db->like($item, $_POST['search']['value']);
	                } else {
	                    $this->db->or_like($item, $_POST['search']['value']);
	                }
	
	                if (count($this->column_search_rekap) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        }
			
			if(isset($_POST["order"])){
				$this->db->order_by($this->order_colums_rekap[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else {
				$this->db->order_by("t.nip", "desc");
			}
	}
	
	public function fetch_datatable_rekap() {
		$this->datatable_rekap();
		if($_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_filtered_data_rekap() {
		$this->datatable_rekap();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_all_data_rekap() {
		 
		$this->db->select("*");
		$this->db->from($this->table_rekap);
		$this->db->where("not exists (select * from pensiun_detail where pensiun_detail.nip = t.nip)",null,false);
		$this->db->not_like('t.note', 'P3D');
			
			
		$query = $this->db->count_all_results();
		return $query;
	}
	
}

