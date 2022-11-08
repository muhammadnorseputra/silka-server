<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Munker extends CI_Model
{
    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
    }

    // get data dropdown unit kerja sesuai hak akses user
    function dd_unker()
    {
        //$sql = "SELECT * from ref_unit_kerja";
        $nip = $this->session->userdata('nip');
	$level = $this->session->userdata('level');

	if ($level == "ADMIN") { // khusus admin
		$sql = "select u.nama_unit_kerja, u.id_unit_kerja
                from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                WHERE
                u.fid_instansi_userportal = i.id_instansi
                and up.nip = '$nip'
                and i.nip_user like '%$nip%'
                and u.nama_unit_kerja NOT LIKE '-%'
                order by u.id_unit_kerja";
	} else {
        	$sql = "select u.nama_unit_kerja, u.id_unit_kerja
                from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                WHERE
                u.fid_instansi_userportal = i.id_instansi
                and up.nip = '$nip'
                and i.nip_user like '%$nip%'
                and u.nama_unit_kerja NOT LIKE '-%'
		and nama_unit_kerja not like '-%'
		order by u.id_unit_kerja";
		//and nama_unit_kerja not like '-%'
	}
        return $this->db->query($sql);
    }

    // get data dropdown semua unit kerja tanpa melihat hak akses user
    function unker()
    {
        $sql = "SELECT * from ref_unit_kerjav2";
        return $this->db->query($sql);
    }

    function pegperunker($id)
    {
        $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, 
        g.nama_golru, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, e.nama_eselon, p.tmt_golru_skr
        from pegawai as p, ref_eselon as e, ref_golru as g
        where p.fid_eselon = e.id_eselon
        and p.fid_golru_skr = g.id_golru
        and p.fid_unit_kerja='$id' order by p.fid_golru_skr desc, p.tmt_golru_skr");
        //$q = $this->db->query("select * from pegawai where fid_unit_kerja='$id'");
        return $q;
    }

    function pppkperunker($id)
    {
        $q = $this->db->query("select p.nipppk as 'nip', p.gelar_depan, p.nama, p.gelar_blk, 
        g.nama_golru, p.fid_jabft, p.tmt_golru_pppk
        from pppk as p, ref_golru_pppk as g
        where p.fid_golru_pppk = g.id_golru
        and p.fid_unit_kerja='$id' order by p.fid_golru_pppk desc, p.tmt_golru_pppk");
        return $q;
    }

    function nomperunker($id)
    {
        $q = $this->db->query("select * from pegawai where fid_unit_kerja='$id' order by fid_golru_skr desc,tmt_golru_skr, fid_eselon, tmt_cpns, fid_tingkat_pendidikan desc, tahun_lulus, tgl_lahir asc");
        return $q;
    }

    function getjmlpeg($id)
    {
        $q = $this->db->query("select * from pegawai where fid_unit_kerja='$id'");
        return $q->num_rows();
    }

    function getjmlpppk($id)
    {
        $q = $this->db->query("select * from pppk where fid_unit_kerja='$id'");
        return $q->num_rows();
    }

    function getnamaunker($id)
    {
        $q = $this->db->query("select nama_unit_kerja from ref_unit_kerjav2 where id_unit_kerja='$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
	    $nmunker = $row->nama_unit_kerja;
	    $nmstrip = substr($nmunker,0,1);
	    $nmlength = strlen($nmunker);
	    if ($nmstrip == "-") {
	 	$nmunker = substr($nmunker,1,$nmlength);
	    }
            return $nmunker; 
        }        
    }

    function getalamatunker($id)
    {
        $q = $this->db->query("select alamat, kecamatan, telepon from ref_unit_kerjav2 where id_unit_kerja='$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            if ($row->telepon == '') {
                $result = array($row->alamat, ' Kec. ', $row->kecamatan, ' Kab. Balangan');    
            } else {
                $result = array($row->alamat, ' Kec. ', $row->kecamatan, ' Telp. ', $row->telepon, ' Kab. Balangan');
            }
            
            $joinString = implode("", $result);
            return $joinString;
        }        
    }

    // INSTANSI
    function instansi()
    {
        $sql = "SELECT * from ref_instansiv2 where id_instansi != '101' AND id_instansi != '155' and nama_instansi not like '-%'";
        return $this->db->query($sql);
    }

    function getjmlpeg_instansi($id)
    {
        $q = $this->db->query("select p.nama from pegawai as p, ref_instansiv2 as i, ref_unit_kerjav2 as u where p.fid_unit_kerja=u.id_unit_kerja and u.fid_instansi = i.id_instansi and i.id_instansi = '$id'");
        return $q->num_rows();
    }

    function get_idinstansi($idunker)
    {
    	$q = $this->db->query("select fid_instansi from ref_unit_kerjav2 where id_unit_kerja='$idunker'");
    	if ($q->num_rows()>0) {
      		$row=$q->row();
      		return $row->fid_instansi;
    	}
     }
}
 
/* End of file unker.php */
/* Location: ./application/models/unker.php */
