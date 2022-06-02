<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdiklat extends CI_Model {

public function __construct(){
	parent::__construct();
}

	//MODEL DATA DIKLAT STRUKTURAL
	public $table = 'ref_syarat_diklat as t';
	public $select_colums = array('t.*','rj.nama_jabatan','u.nama_unit_kerja as unker');
	public $order_colums = array(null, 'rj.nama_jabatan', 't.nama_syarat_diklat');
	public $column_search = array('rj.nama_jabatan','t.nama_syarat_diklat');

	public function get_datasyarat_v2($unkerid, $jabatanid) {
		$this->db->select($this->select_colums);
		$this->db->from($this->table);
		$this->db->join('ref_jabstruk as rj', 't.fid_jabatan=rj.id_jabatan','left');
		$this->db->join('ref_unit_kerjav2 as u', 'rj.fid_unit_kerja=u.id_unit_kerja','left');
		$this->db->where('t.nip', '');
		if(!empty($unkerid) && !empty($jabatanid)){
			$this->db->where('u.id_unit_kerja', $unkerid);
			$this->db->where('rj.id_jabatan', $jabatanid);			
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
			$this->db->order_by("rj.nama_jabatan", "desc");
		}
	}

	public function fetch_datatable($unkerid, $jabatanid) {
		$this->get_datasyarat_v2($unkerid, $jabatanid);
		if($_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_filtered_data($unkerid, $jabatanid) {
		$this->get_datasyarat_v2($unkerid, $jabatanid);
		$query = $this->db->get();
		return $query->num_rows();
	}	
	
	public function get_all_data($unkerid, $jabatanid) {
		if (!empty($unkerid) && !empty($jabatanid)) {
				$this->db->where('u.id_unit_kerja', $unkerid);
				$this->db->where('rj.id_jabatan', $jabatanid);	
		} 
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('ref_jabstruk as rj', 't.fid_jabatan=rj.id_jabatan','left');
		$this->db->join('ref_unit_kerjav2 as u', 'rj.fid_unit_kerja=u.id_unit_kerja','left');
		$query = $this->db->count_all_results();
		return $query;
	}
	public function getnamalengkap($fid) {
		$q = $this->db->query("SELECT CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) AS nama_asn FROM `pegawai` AS p WHERE p.nip = '$fid'")->result();
		return $q[0]->nama_asn;
	}
	
	public function getnamajabtan($fid) {
		$q = $this->db->query("SELECT nama_jabatan FROM ref_jabstruk WHERE id_jabatan = '$fid'")->result();	
		return $q[0]->nama_jabatan;
	}
	
	public function getapprv($tbl, $id) {
		return $this->db->get_where($tbl, $id);
	}
	
	public function get_usulan_diklat_teknis_fungsional_jst($tbl, $nip) {
		return $this->db->get_where($tbl, array('nip' => $nip, 'sts_apprv !=' => '3'));
	}
	
	public function get_tahun_usul() {
		$q = $this->db->select('tahun')
			 ->from('ref_syarat_diklat')
			 ->where_not_in('tahun', ['NULL'])
			 ->group_by('tahun')
			 ->get()
			 ->result();
		return $q;	
	}

	//MODEL DATA DIKLAT JFU & JFT
	public $table_jf = 'ref_syarat_diklat as t';
	public $select_colums_jf = array('t.*','p.nip','CONCAT(p.gelar_depan," ",p.nama," ",p.gelar_belakang) AS nama_asn','u.nama_unit_kerja as unker', 'jfu.nama_jabfu', 'jft.nama_jabft');
	public $order_colums_jf = array(null, null, 't.nip', 'u.nama_unit_kerja', null, null, null, null, null, null, 't.sts_apprv',null);
	public $column_search_jf = array('t.nip','p.nama');
	
	public function get_datasyarat_v2_jf($unkerid, $checkjst, $checkstatus, $tahun) {
		$this->db->select($this->select_colums_jf);
		$this->db->from($this->table_jf);
		$this->db->join('pegawai as p', 't.nip=p.nip','left');
		$this->db->join('ref_jabfu as jfu', 'p.fid_jabfu = jfu.id_jabfu','left');
		$this->db->join('ref_jabft as jft', 'p.fid_jabft = jft.id_jabft','left');
		$this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
		$this->db->where('t.nip !=', '');
		$this->db->where('t.sts_apprv !=', '3');
		if(!empty($unkerid)){
			$this->db->where('u.id_unit_kerja', $unkerid);
		} 
		if($checkjst == '0') {
			$this->db->where('t.fid_jabatan !=', 'NULL');
		}
		if($checkstatus == '1') {
			$this->db->where('t.sts_apprv', '1');
		} elseif($checkstatus == '2') {
			$this->db->where('t.sts_apprv', '2');
		} elseif($checkstatus == '0') {
			$this->db->where('t.sts_apprv', '0');
		}
		if(!empty($tahun)) {
			$this->db->where('t.tahun', $tahun);
		}
		$i=0;
		foreach ($this->column_search_jf as $item) { // loop column 
                if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_jf) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
		
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_colums_jf[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by("t.nip", "desc");
		}
	}
	
	public function fetch_datatable_jf($unkerid,$checkjst,$checkstatus,$tahun) {
		$this->get_datasyarat_v2_jf($unkerid,$checkjst,$checkstatus,$tahun);
		if($_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function get_filtered_data_jf($unkerid,$checkjst, $checkstatus, $tahun) {
		$this->get_datasyarat_v2_jf($unkerid,$checkjst, $checkstatus, $tahun);
		$query = $this->db->get();
		return $query->num_rows();
	}	
	
	public function get_all_data_jf($unkerid,$checkjst, $checkstatus, $tahun) {
		if (!empty($unkerid)) {
				$this->db->where('u.id_unit_kerja', $unkerid);
		} 
		if($checkjst == '0') {
			$this->db->where('t.fid_jabatan !=', 'NULL');
		}
		if($checkstatus == '1') {
			$this->db->where('t.sts_apprv', '1');
		} elseif($checkstatus == '2') {
			$this->db->where('t.sts_apprv', '2');
		} elseif($checkstatus == '0') {
			$this->db->where('t.sts_apprv', '0');
		}
		if(!empty($tahun)) {
			$this->db->where('t.tahun', $tahun);
		}
		$this->db->select("*");
		$this->db->from($this->table_jf);
		$this->db->join('pegawai as p', 't.nip=p.nip','left');
		$this->db->join('ref_jabfu as jfu', 'p.fid_jabfu = jfu.id_jabfu','left');
		$this->db->join('ref_jabft as jft', 'p.fid_jabft = jft.id_jabft','left');
		$this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
		$this->db->where('t.nip !=', '');
		$this->db->where('t.sts_apprv !=', '3');
		$query = $this->db->count_all_results();
		return $query;
	}

public function insert_usulan($tbl, $data) {
	return $this->db->insert($tbl, $data);
}
public function update_status_usulan($tbl, $whr, $data) {
	$this->db->where($whr);
	$this->db->update($tbl, $data);
}

public function get_usulan_diklat_teknis($nip) {
	$this->db->where_in('sts_apprv', array('0','2'));
	$this->db->order_by('id_syarat_diklat', 'desc');
	return $this->db->get_where('ref_syarat_diklat', array('nip' => $nip));
}

public function get_usul_by_id($tbl, $id) {
	$this->db->where_in('sts_apprv', array('2','0'));
	return $this->db->get_where($tbl, array('id_syarat_diklat' => $id));
}

public function update_usul_by_id($tbl, $set, $id) {
	$this->db->where('id_syarat_diklat', $id);
	$this->db->update($tbl, $set);
}

public function get_rekomendasi_diklat_teknis($nip) {
	$this->db->where(array('nip' => $nip));
	$this->db->where_in('sts_apprv', array('1','3'));
	return $this->db->get('ref_syarat_diklat');
}

public function hapus_usulan($tbl, $whr) {
	$this->db->where('id_syarat_diklat', $whr);
	$this->db->delete($tbl);
}

//QUERY LIST DATA PERSAYARATAN DIKLAT
public function get_datasyarat($table,$idunker,$jabatanid){
	
	if($jabatanid == 0 && $idunker != 0){
		$war2 = "WHERE u.id_unit_kerja='$idunker' ORDER BY rj.nama_jabatan DESC";
	}elseif($idunker != 0 && $jabatanid != 0){
		$war2 = "WHERE u.id_unit_kerja='$idunker' AND t.fid_jabatan='$jabatanid' ORDER BY rj.nama_jabatan DESC";
	}elseif($idunker == 0 && $jabatanid == 0){
		$war2 = "ORDER BY rj.nama_jabatan DESC";
	}else{
		$war2 = "ORDER BY rj.nama_jabatan DESC";
	}

    $sql = "SELECT t.*, rj.nama_jabatan, u.nama_unit_kerja AS unker 
    		FROM $table AS t 
    		LEFT JOIN ref_jabstruk AS rj 
    			ON t.fid_jabatan=rj.id_jabatan
    		LEFT JOIN ref_unit_kerjav2 AS u 
    			ON rj.fid_unit_kerja=u.id_unit_kerja
    		$war2";
    return $this->db->query($sql);	
}

//QUERY EDIT DATA
public function get_editdata($table, $where){
    $sql = "SELECT t.*, u.nama_unit_kerja, rj.nama_jabatan, u.id_unit_kerja
    		FROM $table AS t 
    		LEFT JOIN ref_jabstruk AS rj 
    			ON t.fid_jabatan=rj.id_jabatan
    		LEFT JOIN ref_unit_kerjav2 AS u 
    			ON rj.fid_unit_kerja=u.id_unit_kerja
    		WHERE t.id_syarat_diklat = '$where'
    		ORDER BY t.id_syarat_diklat";    
    return $this->db->query($sql);
}

//QUERY UPDATE DATA 
public function p_update($whr,$data,$table){
    $this->db->where($whr);
    $this->db->update($table,$data);
}

// QUERY UNIT KERJA
public function getunker($table) {
    $nip = $this->session->userdata('nip');
    $sql = "select u.nama_unit_kerja, u.id_unit_kerja
            from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
            WHERE
            u.fid_instansi_userportal = i.id_instansi
            and up.nip = '$nip'
            and i.nip_user like '%$nip%' order by u.id_unit_kerja";
    return $this->db->query($sql);
}

public function get_unit_kerja($tbl, $search = '') {
	$select = array('u.nama_unit_kerja','u.id_unit_kerja');
	$nip = $this->session->userdata('nip');
	if(isset($search)) {
		$sql = "select u.nama_unit_kerja, u.id_unit_kerja
						from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
						WHERE
						u.fid_instansi_userportal = i.id_instansi
						and up.nip = '$nip' 
						and i.nip_user like '%$nip%'
						and u.nama_unit_kerja like '%$search%' order by u.id_unit_kerja";
		$res = $this->db->query($sql);
	} else {
		$sql = "select u.nama_unit_kerja, u.id_unit_kerja
						from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
						WHERE
						u.fid_instansi_userportal = i.id_instansi
						and up.nip = '$nip'
						and i.nip_user like '%$nip%' order by u.id_unit_kerja";
		$res = $this->db->query($sql);
	}

	return $res;
}

// QUERY JABATAN STRUKTURAL
public function getjabstruk($id) {
    $sql = "SELECT * FROM ref_jabstruk AS j 
    		LEFT JOIN ref_unit_kerjav2 AS u 
    		ON j.fid_unit_kerja=u.id_unit_kerja
    		WHERE j.fid_unit_kerja='$id'
    		ORDER BY j.id_jabatan";
    return $this->db->query($sql);
}

//QUERY JABATAN FUNGSIONAL UMUM
public function getjabfu($table) {
    $sql = "SELECT * FROM $table ORDER BY nama_jabfu DESC";
    return $this->db->query($sql);
}

//QUERY SIMPAN DATA DIKLAT
public function p_insert($data,$table){
	$this->db->insert($table,$data);
}

//QUERY HAPUS BARIS DATA 
public function hapus_datatable($where,$table){
	$this->db->where($where);
	$this->db->delete($table);
}

public function getjnsjabatan($tbl){
	return $this->db->get($tbl);
}

public function getpegawai($table,$whr,$whr2,$whr3,$whr4){
	$nip = $this->session->userdata('nip');
	$leveluser = $this->session->userdata('level');
	$userid = $this->session->userdata('nama');


	if($leveluser == 'USER'){
		if($whr2 == 0 && $whr != 0 && $whr3 == '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 != 0 && $whr3 == '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 == 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr == 0 && $whr2 == 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr2 != 0 && $whr2 == 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.fid_jnsjab='$whr2' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 != 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 != 0 && $whr4 != 0 && $whr3 == ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND t.fid_jabatan='$whr4' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}
		
		elseif($whr != 0 && $whr2 != 0 && $whr4 != 0 && $whr3 != ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND t.fid_jabatan='$whr4' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 == 0 && $whr4 != 0 && $whr3 == ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jabatan='$whr4' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}
		
		elseif($whr != 0 && $whr2 == 0 && $whr4 != 0 && $whr3 != ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jabatan='$whr4' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}

		else{
			$war = "WHERE t.fid_unit_kerja='$whr' AND i.nip_user like '%$nip%' ORDER BY g.nama_golru DESC";
		}
	}elseif($leveluser == 'ADMIN'){
				if($whr2 == 0 && $whr != 0 && $whr3 == '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 != 0 && $whr3 == '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 == 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr == 0 && $whr2 == 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr2 != 0 && $whr2 == 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.fid_jnsjab='$whr2' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 != 0 && $whr3 != '' && $whr4 == 0){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 != 0 && $whr4 != 0 && $whr3 == ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND t.fid_jabatan='$whr4' ORDER BY g.nama_golru DESC";
		}
		
		elseif($whr != 0 && $whr2 != 0 && $whr4 != 0 && $whr3 != ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jnsjab='$whr2' AND t.fid_jabatan='$whr4' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' ORDER BY g.nama_golru DESC";
		}

		elseif($whr != 0 && $whr2 == 0 && $whr4 != 0 && $whr3 == ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jabatan='$whr4' ORDER BY g.nama_golru DESC";
		}
		
		elseif($whr != 0 && $whr2 == 0 && $whr4 != 0 && $whr3 != ''){
			$war = "WHERE t.fid_unit_kerja='$whr' AND t.fid_jabatan='$whr4' AND t.nip LIKE '%$whr3%' OR t.nama LIKE '%$whr3%' ORDER BY g.nama_golru DESC";
		}

		else{
			$war = "WHERE t.fid_unit_kerja='$whr'' ORDER BY g.nama_golru DESC";
		}
	}
	$sql = "SELECT t.nama, t.nip, t.nip_lama,t.fid_jabatan, CONCAT(t.gelar_depan,' ',t.nama,' ',t.gelar_belakang) AS nama_pegawai,
			u.nama_unit_kerja, ## unit kerja 
			g.nama_golru, g.nama_pangkat,
			rj.nama_jabatan, ## jabstruk
			jfu.nama_jabfu, ## jabfu
			jft.nama_jabft, ## jabft
			rjj.nama_jenis_jabatan
			FROM $table AS t
			LEFT JOIN ref_unit_kerjav2 AS u ON t.fid_unit_kerja=u.id_unit_kerja
			LEFT JOIN ref_golru AS g ON t.fid_golru_skr=g.id_golru
			LEFT JOIN ref_jabstruk AS rj ON t.fid_jabatan=rj.id_jabatan
			LEFT JOIN ref_jabfu AS jfu ON t.fid_jabfu=jfu.id_jabfu 
			LEFT JOIN ref_jabft AS jft ON t.fid_jabft=jft.id_jabft
			LEFT JOIN ref_jenis_jabatan AS rjj ON t.fid_jnsjab=rjj.id_jenis_jabatan
			LEFT JOIN ref_instansi_userportal as i ON  u.fid_instansi_userportal = i.id_instansi
			LEFT JOIN userportal as up ON up.nip = '$nip'
			$war"; 
	return $this->db->query($sql);
}


public function getmorepegawai($table,$whr){
	$sql = "SELECT t.nama,t.tmp_lahir,t.tgl_lahir,t.jenis_kelamin, t.telepon, t.alamat, t.tahun_lulus,t.tmt_golru_skr, t.wajib_lhkpn, t.note, t.nip, t.nip_lama, t.fid_jabatan, t.fid_jabft, t.fid_jabfu, CONCAT(t.gelar_depan,' ',t.nama,' ',t.gelar_belakang) AS nama_pegawai,
			u.nama_unit_kerja, ## unit kerja 
			g.nama_golru, g.nama_pangkat,  ## golru
			e.nama_eselon, e.jab_asn, ## eselon
			a.nama_agama, ## agama
			rj.nama_jabatan, ## jabstruk
			jfu.nama_jabfu, ## jabfu
			jft.nama_jabft, ## jabft
			rjj.nama_jenis_jabatan, ## jenis jabatan
			rjp.nama_jenis_pegawai, ## jenis pegawai
			pdd.nama_jurusan_pendidikan, ## jurusan pendidikan
			tpdd.nama_tingkat_pendidikan, ## tingkat pendidikan
			rwyt_ds.instansi_penyelenggara,
			rsk.nama_status_kawin
			FROM $table AS t 
			LEFT JOIN ref_unit_kerjav2 AS u ON t.fid_unit_kerja=u.id_unit_kerja
			LEFT JOIN ref_golru AS g ON t.fid_golru_skr=g.id_golru
			LEFT JOIN ref_eselon AS e ON t.fid_eselon=e.id_eselon
			LEFT JOIN ref_agama AS a ON t.fid_agama=a.id_agama
			LEFT JOIN ref_jabstruk AS rj ON t.fid_jabatan=rj.id_jabatan
			LEFT JOIN ref_jabfu AS jfu ON t.fid_jabfu=jfu.id_jabfu 
			LEFT JOIN ref_jabft AS jft ON t.fid_jabft=jft.id_jabft
			LEFT JOIN ref_jenis_jabatan AS rjj ON t.fid_jnsjab=rjj.id_jenis_jabatan
			LEFT JOIN ref_jenis_pegawai AS rjp ON t.fid_jenis_pegawai=rjp.id_jenis_pegawai
			LEFT JOIN ref_jurusan_pendidikan AS pdd ON t.fid_jurusan_pendidikan=pdd.id_jurusan_pendidikan
			LEFT JOIN ref_tingkat_pendidikan AS tpdd ON t.fid_tingkat_pendidikan=tpdd.id_tingkat_pendidikan
			LEFT JOIN riwayat_diklat_struktural AS rwyt_ds ON t.nip=rwyt_ds.nip
			LEFT JOIN ref_status_kawin AS rsk ON t.fid_status_kawin=rsk.id_status_kawin
			WHERE t.nip = '$whr'
			ORDER BY g.nama_golru DESC";
	return $this->db->query($sql);
}

public function	getdatasyaratdiklat($id){
	$sql = "SELECT * FROM ref_syarat_diklat WHERE fid_jabatan='$id'";
	return $this->db->query($sql);
}

public function	getdatariwayatdiklat($nip){
	$sql = "SELECT s.*, rs.nama_diklat_struktural 
			FROM riwayat_diklat_struktural AS s 
			LEFT JOIN ref_diklat_struktural AS rs ON s.fid_diklat_struktural=rs.id_diklat_struktural
			WHERE LEFT(s.nip,16) = '$nip'";
	return $this->db->query($sql);
}

public function	getrwytdiklatfungsional($r){
	$sql = "SELECT * FROM riwayat_diklat_fungsional WHERE LEFT(nip,16) = '$r'";
	return $this->db->query($sql);
}

public function	getrwytdiklattekis($x){
	$sql = "SELECT * FROM riwayat_diklat_teknis WHERE LEFT(nip,16) = '$x'";
	return $this->db->query($sql);
}

public function cekjab($n){
	return $this->db->query("SELECT * FROM ref_syarat_diklat WHERE fid_jabatan='$n'");
}

public function getlaporandata($table,$q,$w){
	if($w == 0 && $q != 0){
		$qwe = "WHERE t.fid_unit_kerja='$q' GROUP BY t.nip ORDER BY t.fid_eselon, rj.nama_jabatan DESC";
	}elseif($q != 0 && $w != 0){
		$qwe = "WHERE t.fid_unit_kerja='$q' AND t.fid_jnsjab='$w' GROUP BY t.nip ORDER BY t.fid_eselon, rj.nama_jabatan DESC";
	}elseif($q == 0 && $w == 0){
		$qwe = "GROUP BY t.nip ORDER BY t.fid_eselon, rj.nama_jabatan DESC";
	}else{
		$qwe = "GROUP BY t.nip ORDER BY t.fid_eselon, rj.nama_jabatan DESC";
	}

    $sql = "SELECT COUNT(t.nip) AS jmlpns, t.nip, CONCAT(t.gelar_depan,' ',t.nama,' ',t.gelar_belakang) AS nama_pegawai, t.tmt_jabatan, re.nama_eselon, u.nama_unit_kerja AS unker, rj.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft, t.fid_jabatan, t.fid_jabfu, t.fid_jabft
    		FROM $table AS t 
    		LEFT JOIN ref_jabstruk AS rj 
    			ON t.fid_jabatan=rj.id_jabatan
			LEFT JOIN ref_jabfu AS jfu 
				ON t.fid_jabfu=jfu.id_jabfu 
			LEFT JOIN ref_jabft AS jft 
				ON t.fid_jabft=jft.id_jabft
    		LEFT JOIN ref_eselon AS re 
    			ON t.fid_eselon=re.id_eselon
    		LEFT JOIN ref_unit_kerjav2 AS u 
    			ON t.fid_unit_kerja=u.id_unit_kerja
    		$qwe";
    return $this->db->query($sql);	
}

//laporan
public function	getdatarekomendasi_l($jb){
	$sql = "SELECT * FROM ref_syarat_diklat WHERE fid_jabatan='$jb'";
	return $this->db->query($sql);
}

public function	getdatariwayat_l($ja){
	$sql = "SELECT * FROM riwayat_diklat_struktural AS a, ref_diklat_struktural AS b WHERE a.fid_diklat_struktural=b.id_diklat_struktural AND a.nip='$ja'";
	return $this->db->query($sql);
}

public function	getdatariwayat_l_teknis($nip){
	$sql = "SELECT nip, nama_diklat_teknis FROM riwayat_diklat_teknis WHERE nip='$nip'";
	return $this->db->query($sql);
}
public function	getdatariwayat_l_fungsional($nip){
	$sql = "SELECT nip, nama_diklat_fungsional FROM riwayat_diklat_fungsional WHERE nip='$nip'";
	return $this->db->query($sql);
}

//cetak
public function	getdatarekomendasi($jb){
	$sql = "SELECT * FROM ref_syarat_diklat WHERE fid_jabatan='$jb'";
	$query = $this->db->query($sql);

	if ($query->num_rows()>0)
    {
      $row=$query->row();
      return $row->nama_syarat_diklat; 
    } 
}

public function	getdatariwayat($ja){
	$sql = "SELECT * FROM riwayat_diklat_struktural AS a, ref_diklat_struktural AS b WHERE a.fid_diklat_struktural=b.id_diklat_struktural AND a.nip='$ja'";
	$query = $this->db->query($sql);
	if ($query->num_rows()>0)
    {
      $row=$query->row();
      return $row->nama_diklat_struktural; 
    } 
}

public function cetaklaporandiklat($q,$w){

	if($w == 0){
		$whr = "WHERE t.fid_unit_kerja='$q' ORDER BY t.fid_eselon, rj.nama_jabatan DESC";
	}else{
		$whr = "WHERE t.fid_unit_kerja='$q' AND t.fid_jnsjab='$w' ORDER BY t.fid_eselon, rj.nama_jabatan DESC";
	}

    $sql = "SELECT t.nip, CONCAT(t.gelar_depan,' ',t.nama,' ',t.gelar_belakang) AS nama_pegawai, t.tmt_jabatan, re.nama_eselon, u.nama_unit_kerja AS unker, rj.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft, t.fid_jabatan, t.fid_jabfu, t.fid_jabft, t.fid_unit_kerja
    		FROM pegawai AS t 
    		LEFT JOIN ref_jabstruk AS rj 
    			ON t.fid_jabatan=rj.id_jabatan
			LEFT JOIN ref_jabfu AS jfu 
				ON t.fid_jabfu=jfu.id_jabfu 
			LEFT JOIN ref_jabft AS jft 
				ON t.fid_jabft=jft.id_jabft
    		LEFT JOIN ref_eselon AS re 
    			ON t.fid_eselon=re.id_eselon
    		LEFT JOIN ref_unit_kerjav2 AS u 
    			ON t.fid_unit_kerja=u.id_unit_kerja
    		$whr";
    return $this->db->query($sql);	
}

 

public $table_rekap = 'ref_syarat_diklat as t';
public $select_colums_rekap = array('t.*','p.nip','CONCAT(p.gelar_depan," ",p.nama," ",p.gelar_belakang) AS nama_asn','u.nama_unit_kerja as unker', 'jfu.nama_jabfu', 'jft.nama_jabft');
public $order_colums_rekap = array(null, 't.nip', null, null, null, null, 't.biaya', null, 't.sts_apprv');
public $column_search_rekap = array('t.nip','p.nama');

public function datatable_rekap($unker, $checkstatus, $checkjabatan, $tahun) {
		$this->db->select($this->select_colums_rekap);
		$this->db->from($this->table_rekap);
		$this->db->join('pegawai as p', 't.nip=p.nip','left');
		$this->db->join('ref_jabfu as jfu', 'p.fid_jabfu = jfu.id_jabfu','left');
		$this->db->join('ref_jabft as jft', 'p.fid_jabft = jft.id_jabft','left');
		$this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
		$this->db->where_in('t.sts_apprv', array('1','3'));
		if(!empty($unker)){
			$this->db->where('u.id_unit_kerja', $unker);
		}
		if($checkstatus == '1') {
			$this->db->where('t.sts_apprv', '1');
		} elseif($checkstatus == '3') {
			$this->db->where('t.sts_apprv', '3');
		}
		if($checkjabatan == '1') {
			$this->db->where('t.fid_jabatan !=', 'NULL');
			$this->db->where('t.nip !=', '');
		}
		if(!empty($tahun)){
			$this->db->where('t.tahun !=', '0000');
			$this->db->where('t.tahun', $tahun);
		}
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

public function fetch_datatable_rekap($unker, $checkstatus, $checkjabatan, $tahun) {
	$this->datatable_rekap($unker, $checkstatus,$checkjabatan, $tahun);
	if($_POST['length'] != -1){
		$this->db->limit($_POST['length'], $_POST['start']);
	}
	$query = $this->db->get();
	return $query->result();
}

public function get_filtered_data_rekap($unker,$checkstatus,$checkjabatan, $tahun) {
	$this->datatable_rekap($unker,$checkstatus,$checkjabatan, $tahun);
	$query = $this->db->get();
	return $query->num_rows();
}

public function get_all_data_rekap($unker,$s,$j,$t) {
	 
	$this->db->select("*");
	$this->db->from($this->table_rekap);
	$this->db->join('pegawai as p', 't.nip=p.nip','left');
	$this->db->join('ref_jabfu as jfu', 'p.fid_jabfu = jfu.id_jabfu','left');
	$this->db->join('ref_jabft as jft', 'p.fid_jabft = jft.id_jabft','left');
	$this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
	// $this->db->where('t.nip !=', '');
	 if (!empty($unker)) {
			$this->db->where('u.id_unit_kerja', $unker);
	 }
	 if($s == '1') {
			$this->db->where('t.sts_apprv', '1');
		} elseif($s == '3') {
			$this->db->where('t.sts_apprv', '3');
		} else {
			$this->db->where_in('t.sts_apprv', array('1','3'));
		}
	 if($j == '1') {
			$this->db->where('t.fid_jabatan !=', 'NULL');
			$this->db->where('t.nip !=', '');
		}
	 if(!empty($t)){
			$this->db->where('t.tahun !=', '0000');
			$this->db->where('t.tahun', $t);
		}
		
	$query = $this->db->count_all_results();
	return $query;
}

public function cetaklaporan_v2($u,$s,$j,$t) {
	$select = array('t.*','p.nip','CONCAT(p.gelar_depan," ",p.nama," ",p.gelar_belakang) AS nama_asn','u.nama_unit_kerja as unker', 'p.fid_unit_kerja', 'jfu.nama_jabfu', 'jft.nama_jabft', 'rs.nip as nip_spesimen', 'rs.status as status_spesimen', 'rs.jabatan_spesimen');
	$this->db->select($select);
	$this->db->from($this->table_rekap);
	$this->db->join('pegawai as p', 't.nip=p.nip','left');
	$this->db->join('ref_spesimen as rs', 'p.fid_unit_kerja=rs.fid_unit_kerja', 'left');
	$this->db->join('ref_jabfu as jfu', 'p.fid_jabfu = jfu.id_jabfu','left');
	$this->db->join('ref_jabft as jft', 'p.fid_jabft = jft.id_jabft','left');
	$this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');

	if (!empty($u)) {
		$this->db->where('u.id_unit_kerja', $u);
	}
	 
	if($s == '1') {
		$this->db->where('t.sts_apprv', '1');
	} elseif($s == '3') {
		$this->db->where('t.sts_apprv', '3');
	} else {
		$this->db->where_in('t.sts_apprv', array('1','3'));
	}
	
	if($j == '1') {
		$this->db->where('t.fid_jabatan !=', 'NULL');
		$this->db->where('t.nip !=', '');
	}
	if(!empty($t)){
		$this->db->where('t.tahun !=', '0000');
		$this->db->where('t.tahun', $t);
	}
	
	$query = $this->db->get();
	return $query;
}



}
