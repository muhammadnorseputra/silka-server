<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpetruk extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }
  
  function profile_pegawai($nip) 
  {
  	$q = $this->db->get_where('pegawai', ['nip' => $nip]);
  	return $q;
  }
  
  function spesimen($unkerid)
  {
  	$this->db->select('p.*, s.nip as nip_spesimen, s.status as status_spesimen, s.jabatan_spesimen');
  	$this->db->from('pegawai AS p');
  	$this->db->join('ref_spesimen AS s', 'p.fid_unit_kerja=s.fid_unit_kerja', 'left');
		$this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
		$this->db->where('p.fid_unit_kerja', $unkerid);
  	$q = $this->db->get();
  	return $q;
  }
  
  function namaunker($id) {
  	$q = $this->db->get_where('ref_unit_kerjav2', ['id_unit_kerja' => $id])->row();
  	return $q->nama_unit_kerja;
  }
  
  function nomperunker($id)
  {
      $q = $this->db->query("select * from pegawai where fid_unit_kerja='$id' and fid_eselon in ('0231','0232','0241','0242','0253','0254','0251','0255','0256') order by fid_eselon, fid_golru_skr desc,tmt_golru_skr, tmt_cpns, fid_tingkat_pendidikan desc, tahun_lulus, tgl_lahir asc");
      return $q;
  }
  function detail_penilaian_by_unker($id)
  {
  		return $this->db->get_where('petruk', ['fid_unit_kerja' => $id]);
  }
  function detail_penilaian_by_nip($nip)
  {
  		return $this->db->get_where('petruk', ['nip' => $nip]);
  }
  function kinerja_bulanan($nip, $bln, $thn) {
  	$sql = $this->db->get_where('kinerja_bulanan', ['nip' => $nip, 'bulan' => $bln, 'tahun' => $thn])->row();
  	return $sql;
  }
  function absensi_bulanan($nip, $bln, $thn) {
  	$sql = $this->db->get_where('absensi', ['nip' => $nip, 'bulan' => $bln, 'tahun' => $thn])->row();
  	return $sql;
  }
  function perilaku_tahunan($nip, $thn) {
  	$sql = $this->db->get_where('riwayat_skp', ['nip' => $nip, 'tahun' => $thn])->row();
  	return $sql;
  }
  function insert_penilaian($tbl, $data)
  {
  	return $this->db->insert($tbl, $data);
  }
  function simpan_total_score($nip, $total) 
  {
  	$this->db->where('nip', $nip);
  	$this->db->update('petruk', ['skor_total' => $total]);
  	return true;
  }
  
  public $table_rekap = 'petruk as t';
	public $select_colums_rekap = array('t.*','p.*','u.nama_unit_kerja');
	public $order_colums_rekap = array(null, 't.nip', 'p.nama', 'u.id_unit_kerja', null, null, null, null, null, null, 't.skor_total');
	public $column_search_rekap = array('t.nip','p.nama');
	
	public function datatable_rekap($filter) {
			$this->db->select($this->select_colums_rekap);
			$this->db->from($this->table_rekap);
			$this->db->join('pegawai AS p','t.nip=p.nip');
			$this->db->join('ref_unit_kerjav2 AS u','t.fid_unit_kerja=u.id_unit_kerja');
			if(!empty($filter['bulan'])):
				$this->db->where('t.bulan', $filter['bulan']);
			elseif(!empty($filter['tahun'])):
				$this->db->where('t.tahun', $filter['tahun']);
			elseif(!empty($filter['skor'])):
				$this->db->order_by('t.skor_total', $filter['skor']);
			endif;
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
	
	public function fetch_datatable_rekap($filter) {
		$this->datatable_rekap($filter);
		if($_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_filtered_data_rekap($filter) {
		$this->datatable_rekap($filter);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_all_data_rekap($filter) {
		 
		$this->db->select("*");
		$this->db->from($this->table_rekap);
		$this->db->join('pegawai AS p','t.nip=p.nip');
		$this->db->join('ref_unit_kerjav2 AS u','t.fid_unit_kerja=u.id_unit_kerja');
		
		if(!empty($filter['bulan'])):
			$this->db->where('t.bulan', $filter['bulan']);
		elseif(!empty($filter['tahun'])):
			$this->db->where('t.tahun', $filter['tahun']);
		elseif(!empty($filter['skor'])):
			$this->db->order_by('t.skor_total', $filter['skor']);
		endif;
			
		$query = $this->db->count_all_results();
		return $query;
	}
	public function cetakrekapitulasi($x,$y,$z) {
		$this->db->select($this->select_colums_rekap);
		$this->db->from($this->table_rekap);
		$this->db->join('pegawai AS p','t.nip=p.nip');
		$this->db->join('ref_unit_kerjav2 AS u','t.fid_unit_kerja=u.id_unit_kerja');
		if(!empty($x)){
			$this->db->where('t.bulan', $x);			
		} 
		if(!empty($y)) {
			$this->db->where('t.tahun', $y);
		}
		if(!empty($z)) {
			$this->db->order_by('t.skor_total', $z);	
		} else {
			$this->db->order_by("t.nip", "desc");
		}
		return $this->db->get();
	}
	public function simpan_nomor($tbl, $data, $whr) {
		$this->db->where($whr);
		return $this->db->update($tbl, $data);
	}
}