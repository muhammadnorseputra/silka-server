<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapi extends CI_Model {

    /* SERVICES API WITH AUTH */
    public function services_pegawai($nip) {
    return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, CONCAT_WS(' ', jst.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft) AS nama_jabatan, 
    CONCAT_WS(' ', jst.id_jabatan, jfu.id_jabfu, jft.id_jabft) AS kode_jabatan", false)
    ->from('pegawai AS p')
    ->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru')
    ->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'left')
    ->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'left')
    ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
    ->where('p.nip', $nip)
    ->get();
    // return $this->db->get_where('pegawai', ['nip' => $nip]);
    }

    public function services_unkerid($id) {
        return $this->db->get_where('ref_unit_kerjav2', ['id_unit_kerja' => $id]);
    }
    /* END SERVICES API WITH AUTH */

	public function get_agama()
    {
        $query = $this->db->get("ref_agama");
        return $query->result();
    }
    
    public function filternipnik($d) {
		$q_pns = $this->db->select('nip,nama,jenis_kelamin,tgl_lahir')->get_where('pegawai', ['nip' => $d])->result();
		$q_non = $this->db->select('nik,nama,jns_kelamin,tgl_lahir')->get_where('nonpns', ['nik' => $d])->result();
    	return [$q_non,$q_pns];
    }

    ####################################################################    
    public function get_pertanyaan($jenis)
    {
        $query = $this->db->select('*')
                          ->from('surveypertanyaan2018')
                          ->where('jenis', $jenis)
                          ->order_by('id','asc')
                          ->get();

        return $query->result();
    }
    public function cekSurvey($nip)
    {
        return $this->db->select('s.nip','p.nama')
                        ->from('surveyjawaban2018 AS s')
                        ->join('pegawai AS p', 's.nip = p.nip', 'left')
                        ->like('s.nip', $nip)
                        ->group_by('s.nip')
                        ->get();
    }
    public function jmlPertanyaan(){
        return $this->db->get('surveypertanyaan2018')->num_rows();
    }	
    public function jmlJenis($jenis){
        return $this->db->get_where('surveypertanyaan2018', ['jenis' => $jenis])->num_rows();
    }	
    public function insert_survey($tbl,$values)
    {
        return $this->db->insert_batch($tbl,$values);
    }

    ####################################################################
    public function hasil_survey($tbl)
    {
        $this->db->select('u.nip,u.username,r.nama_unit_kerja AS unker, s.tgl_survey, p.nip')
                 ->from($tbl.' AS u')
                 ->join('pegawai AS p', 'p.nip = u.nip')
                 ->join('ref_unit_kerjav2 AS r', 'p.fid_unit_kerja = r.id_unit_kerja')
                 ->join('surveyjawaban2018 AS s', 'p.nip = s.nip', 'left')
                 ->group_by('p.nip')
                 ->order_by('s.tgl_survey');
        return $this->db->get();
    }
    public function showPesan($tbl,$nip)
    {
        $this->db->select('t.*, u.username')
                 ->from($tbl.' AS t')
                 ->join('userportal AS u', 't.nip = u.nip')
                 ->like('u.nip', $nip)
                // ->where_in('t.fid_pertanyaan', ['36','38']);
                ->where('t.fid_pertanyaan', '38');
        return $this->db->get()->result();
    }
    public function jmlPengisi($tbl)
    {
        return $this->db->query('SELECT p.nip FROM `surveyjawaban2018` GROUP BY nip')->num_rows();
    }
    public function resetSurvey($tbl,$nip)
    {
        $this->db->like('nip',$nip);
        $this->db->delete($tbl);
    }
    public function totalPengguna($tbl)
    {
        return $this->db->get($tbl)->num_rows();
    }
    ####################################################################
    public function ChartBarLabel($tbl,$jenis)
    {
        return $this->db->select('pertanyaan')->get_where($tbl,['jenis' => $jenis])->result();
    }
    public function CountJawab($tbl) {
        return $this->db->select('jawaban, COUNT(*) AS jmlData')->get($tbl)->result();
    }
    ####################################################################
    public function search_pegawai($nip,$nama) { 
        $this->db->select('nama, nip')
                 ->from('pegawai')
                 ->like('nip', $nip)
                 ->or_like('nama', $nama);
        return $this->db->get();
    }
    ####################################################################
    function filternipnama($tbl, $nip, $nama) { 
			$this->db->select('p.nip, p.nama');
			$this->db->from($tbl.' as p');
			$this->db->like('p.nip', $nip);
			$this->db->or_like('p.nama', $nama);
			$q = $this->db->get();
	   	return $q;
	  }
    public function jmlpns()
	  {
	    $q = $this->db->query("select nip from pegawai");
	    return $q->num_rows();
	  }
	  
	  public function jmlasn()
	  {
	    $a = $this->db->query("select nip from pegawai");
	    $b = $this->db->query("select nik from nonpns");
	    return $a->num_rows() + $b->num_rows();
	  }
	  
	  
	  public function jmlnonpns()
	  {
	    $q = $this->db->query("select nik from nonpns");
	    return $q->num_rows();
	  }
	  
	  public function jmlpensiun($tahun)
	  {
	    $q = $this->db->query("select nip from pensiun_detail where tmt_pensiun like '$tahun%'");
	    return $q->num_rows();
	  }

		public function get_profile_pegawai($nip) {
			$this->db->select('*');
			$this->db->from('pegawai');
			$this->db->where('nip', $nip);
			$q = $this->db->get();
			return $q;
		}

    #================================================================#
    # KHUSUS UNTUK CONTROLLER API
    public function detail_pns($nip) {
    	$query = $this->db->query("select p.nip, CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as nama, p.tmp_lahir, p.tgl_lahir, p.jenis_kelamin, sk.nama_status_kawin, ag.nama_agama, p.alamat, rl.nama_kelurahan, rk.nama_kecamatan, p.telepon, ns.nama_status_pegawai, p.fid_golru_skr, u.nama_unit_kerja, (select js.nama_jabatan from ref_jabstruk as js, pegawai as p where p.fid_jabatan=js.id_jabatan and p.nip='".$nip."') as jabstruk, (select ju.nama_jabfu from ref_jabfu as ju, pegawai as p where p.fid_jabfu=ju.id_jabfu and p.nip='".$nip."') as jabfu, (select jt.nama_jabft from ref_jabft as jt, pegawai as p where p.fid_jabft=jt.id_jabft and p.nip='".$nip."') as jabft, p.tmt_jabatan, g.nama_golru, p.tmt_golru_skr, CONCAT(tp.nama_tingkat_pendidikan,' - ',jp.nama_jurusan_pendidikan) as pendidikan, p.no_karpeg, p.no_ktp, p.no_npwp from pegawai as p, ref_status_pegawai as ns, ref_status_kawin as sk, ref_kelurahan as rl, ref_kecamatan as rk, ref_agama as ag, ref_golru as g, ref_tingkat_pendidikan as tp,ref_jurusan_pendidikan as jp, ref_unit_kerjav2 as u where p.fid_golru_skr = g.id_golru and p.fid_status_pegawai = ns.id_status_pegawai and p.fid_status_kawin = sk.id_status_kawin and p.fid_agama = ag.id_agama AND p.`fid_unit_kerja` = u.id_unit_kerja and p.`fid_tingkat_pendidikan` = tp.`id_tingkat_pendidikan` and p.`fid_jurusan_pendidikan` = jp.`id_jurusan_pendidikan` and p.fid_alamat_kelurahan = rl.id_kelurahan and rl.fid_kecamatan = rk.id_kecamatan and p.nip='".$nip."'");

        //$query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;    
        }
    }	

    function pnsperunker($idunker) {
        $query = $this->db->query("select p.nip, CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as nama, p.tmp_lahir, p.tgl_lahir, 
p.jenis_kelamin, ns.nama_status_pegawai, u.nama_unit_kerja,
p.tmt_jabatan, p.fid_golru_skr, g.nama_golru, p.tmt_golru_skr, 
CONCAT(tp.nama_tingkat_pendidikan,' - ',jp.nama_jurusan_pendidikan) as pendidikan, p.tahun_lulus 
from pegawai as p, ref_status_pegawai as ns, ref_golru as g, ref_tingkat_pendidikan as tp,ref_jurusan_pendidikan as jp, ref_unit_kerjav2 as u 
where p.fid_golru_skr = g.id_golru 
and p.fid_status_pegawai = ns.id_status_pegawai 
AND p.`fid_unit_kerja` = u.id_unit_kerja 
and p.`fid_tingkat_pendidikan` = tp.`id_tingkat_pendidikan` 
and p.`fid_jurusan_pendidikan` = jp.`id_jurusan_pendidikan` 
and p.fid_unit_kerja='".$idunker."' order by p.fid_golru_skr desc");

        //$query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;    
        }
    }	

    # END CONTROLLER API
    #================================================================#
}
