<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msantunan_korpri extends CI_Model {
	public function dbnip($nip) {
		$q = $this->db->get_where('tali_asih_korpri', ['nip' => $nip]);
		if($q->num_rows() > 0) {
			$result = false;
		} else {
			$result = true;
		}
		return $result;
	}
	public function ceknip($nip) {
		return $this->db->get_where('pegawai_pensiun', array('nip' => $nip));
	}
	public function cekunitkerja($nip) {
		$this->db->select('nama_unit_kerja');
		$this->db->from('pegawai_pensiun');
		$this->db->where('nip', $nip);
		return $this->db->get()->row();
	}
	public function save_santunan($data) {
		$this->db->insert('tali_asih_korpri', $data);
		return true;
	}
	
	// ---------------- Rekapitulasi --------------------//
	//MODEL DATA DIKLAT STRUKTURAL
	public $table = 'tali_asih_korpri as t';
	public $select_colums = array('t.*','p.gelar_depan','p.gelar_belakang','p.nama',
																'pp.gelar_depan as gd_pensiun','pp.gelar_belakang as gb_pensiun','pp.nama as nama_pensiun');
	public $order_colums = array('t.id_tali_asih');
	public $column_search = array('t.nip','p.nama', 'pp.nama');

	public function get_data_santunan($tahun, $bulan, $jns_santunan) {
		$this->db->select($this->select_colums);
		$this->db->from($this->table);
		$this->db->join('pegawai as p', 't.nip=p.nip', 'left');
		$this->db->join('pegawai_pensiun as pp', 't.nip=pp.nip', 'left');
		if(!empty($tahun)){
			$this->db->where('t.tahun', $tahun);			
		} 
		if(!empty($bulan)) {
			$this->db->where('t.bulan', $bulan);
		}
		if(!empty($jns_santunan)) {
			$this->db->where('t.fid_jenis_tali_asih', $jns_santunan);	
		}
		$i=0;
		foreach ($this->column_search as $item) { // loop column 
                if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
		
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_colums[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by("t.id_tali_asih", "desc");
		}
	}

	public function fetch_datatable($tahun, $bulan, $jns_santunan) {
		$this->get_data_santunan($tahun, $bulan, $jns_santunan);
		if($_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_filtered_data($tahun, $bulan, $jns_santunan) {
		$this->get_data_santunan($tahun, $bulan, $jns_santunan);
		$query = $this->db->get();
		return $query->num_rows();
	}	
	
	public function get_all_data($tahun, $bulan, $jns_santunan) { 
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('pegawai as p', 't.nip=p.nip', 'left');
		$this->db->join('pegawai_pensiun as pp', 't.nip=pp.nip', 'left');
		if(!empty($tahun)){
			$this->db->where('t.tahun', $tahun);			
		} 
		if(!empty($bulan)) {
			$this->db->where('t.bulan', $bulan);
		}
		if(!empty($jns_santunan)) {
			$this->db->where('t.fid_jenis_tali_asih', $jns_santunan);	
		}
		$query = $this->db->count_all_results();
		return $query;
	}
	
	public function jenis($id) {
		$q = $this->db->get_where('ref_jenis_tali_asih', ['id_jenis_tali_asih' => $id]);
		if($q->num_rows() > 0) {
			$r = $q->row();
			$result = $r->nama_jenis_tali_asih;
		}
		return $result;
	}
	
	public function cetakrekapitulasi($x,$y,$z) {
		$this->db->select($this->select_colums);
		$this->db->from($this->table);
		$this->db->join("pegawai AS p", 't.nip=p.nip', 'left');
		$this->db->join('pegawai_pensiun as pp', 't.nip=pp.nip', 'left');
		if(!empty($x)){
			$this->db->where('t.tahun', $x);			
		} 
		if(!empty($y)) {
			$this->db->where('t.bulan', $y);
		}
		if(!empty($z)) {
			$this->db->where('t.fid_jenis_tali_asih', $z);	
		}
		$this->db->order_by("t.id_tali_asih");
		return $this->db->get();
	}
	
	public function cetak_kwitansi($id) {
		$this->db->select($this->select_colums);
		$this->db->from($this->table);
		$this->db->join("pegawai AS p", 't.nip=p.nip', 'left');
		$this->db->join('pegawai_pensiun as pp', 't.nip=pp.nip', 'left');
		$this->db->where('t.id_tali_asih', $id);			
		return $this->db->get();
	}	
	
	public function update_tgl_cetak($id,$date) {
		$this->db->where('id_tali_asih', $id);
		$this->db->update('tali_asih_korpri', $date);
		return true;
	}
	
	public function cekstatus_santunan($nip) {
		$this->db->select('jts.nama_jenis_tali_asih');
		$this->db->from('tali_asih_korpri AS tak');
		$this->db->join('ref_jenis_tali_asih AS jts', 'tak.fid_jenis_tali_asih=jts.id_jenis_tali_asih', 'left');
		$this->db->join('pegawai AS p', 'tak.nip=p.nip', 'left');
		$this->db->join('pegawai_pensiun as pp', 'tak.nip=pp.nip', 'left');
		$this->db->where('tak.nip', $nip);
		$q = $this->db->get();
		if($q->num_rows() > 0) {
			$r = $q->row();
			return $r->nama_jenis_tali_asih;
		}   
	}
	
	public function cekstatus_santunan_rekap($nip) {
		$this->db->select('jts.nama_jenis_tali_asih');
		$this->db->from('tali_asih_korpri AS tak');
		$this->db->join('ref_jenis_tali_asih AS jts', 'tak.fid_jenis_tali_asih=jts.id_jenis_tali_asih', 'left');
		$this->db->join('pegawai AS p', 'tak.nip=p.nip', 'left');
		$this->db->join('pegawai_pensiun AS pp', 'tak.nip=pp.nip');
		$this->db->where('tak.nip', $nip);
		$q = $this->db->get();
		if($q->num_rows() > 0) {
			$r = $q->row();
			return $r->nama_jenis_tali_asih;
		}   
	}
}
