<?php 
class Mskp extends CI_Model{

	var $tabel = 'riwayat_skp'; //variabel tabel
 
    function __construct() {
        parent::__construct();
    }

	//function tampil_data(){
	//	$this->db->from($this->tabel);
    //    $this->db->where('nip', $nip);
 
    //	$query = $this->db->get();
 
    //    if ($query->num_rows() == 1) {
    //        return $query->result();
    //    }

	//}

	function tampil_data(){
		return $this->db->get('riwayat_skp');
	}

	function input_data($data){
		$this->db->insert('riwayat_skp',$data);
		return true;
	}

	function hapus_data($where){
		$this->db->where($where);
		$this->db->delete('riwayat_skp');
		return true;
	}	

	// untuk memeriksa skp, supaya tidak double pada tahun yang sama
    function cekskp($nip, $thn)
    {
        $q = $this->db->query("select * from riwayat_skp where nip='$nip' AND tahun='$thn'");
        return $q->num_rows();
    }

    // untuk Edit SKP

    public function detail($nip, $thn)
    {
	    $q = $this->db->query("select * from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
	    return $q;
  	}

  	function getkepemimpinan($nip, $thn)
  	{
  		$q = $this->db->query("select kepemimpinan from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
  		if ($q->num_rows()>0)
  		{
  			$row=$q->row();
  			return $row->kepemimpinan; 
	      //}
  		}        
  	}

  	function getjenis_skp($nip, $thn)
  	{
  		$q = $this->db->query("select jns_skp from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
  		if ($q->num_rows()>0)
  		{
  			$row=$q->row();
  			return $row->jns_skp; 
	      //}
  		}        
  	}

  	// cek apakah PP atau APP mempunyai golru, jika ada berarti PNS, jika tidak ada golru berarti NONPNS  	
  	function cek_pp($nip, $thn)
  	{

  		$q = $this->db->query("select fid_golru_pp from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
  		if ($q->num_rows()>0)
  		{
  			$row=$q->row();
  			if ($row->fid_golru_pp)
  				return 'PNS'; 
  			else 
  				return 'NONPNS';
	      //}
  		}        
  	}

  	// cek apakah PP atau APP mempunyai golru, jika ada berarti PNS, jika tidak ada golru berarti NONPNS  	
  	function cek_app($nip, $thn)
  	{

  		$q = $this->db->query("select fid_golru_app from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
  		if ($q->num_rows()>0)
  		{
  			$row=$q->row();
  			if ($row->fid_golru_app)
  				return 'PNS'; 
  			else 
  				return 'NONPNS';
	      //}
  		}        
  	}

  	public function getpp($nip, $thn)
    {
	    $q = $this->db->query("select nip_pp, nama_pp, fid_golru_pp, jab_pp, unor_pp from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
	    return $q;
  	}

  	public function getapp($nip, $thn)
    {
	    $q = $this->db->query("select nip_app, nama_app, fid_golru_app, jab_app, unor_app from riwayat_skp where nip='".$nip."' and tahun='".$thn."'");
	    return $q;
  	}

  	function edit_skp($where, $data){
	    $this->db->where($where);
	    $this->db->update('riwayat_skp',$data);
	    return true;
	}

	// START SKP 2021
	function cekskp2021_pp46($nip)
        {
                $q = $this->db->query("select integritas, disiplin from riwayat_skp where nip='".$nip."' and tahun='2021'");
                if ($q->num_rows()>0)
                {
                        $row=$q->row();
                        if (($row->integritas != 0) AND ($row->disiplin != 0)){ // Ada SKP 2021 PP 46
                                return true;
			} else {
				return false;
			}
                }
        }
	
	function cekskp2021_pp30($nip)
        {
                $q = $this->db->query("select inisiatifkerja from riwayat_skp where nip='".$nip."' and tahun='2021'");
                if ($q->num_rows()>0)
                {
                        $row=$q->row();
                        if ($row->inisiatifkerja != 0) { // Ada SKP 2021 PP 30
                                return true;
                        } else {
                                return false;
                        }
                }
        }

	function konversiskp_pp46($nilai)
  	{
    		if ($nilai < 51) {
			$nilaikonv = ($nilai/50)*49;
    		} else if (($nilai >= 51) AND ($nilai < 61)) {
			$nilaikonv = 50 + (((69-50)/(60-51))*($nilai-51));
    		} else if (($nilai >= 61) AND ($nilai < 76)) {
			$nilaikonv = 70 + (((89-70)/(75-61))*($nilai-61));
    		} else if (($nilai >= 76) AND ($nilai < 91)) {
			$nilaikonv = 90 + (((109-90)/(90-76))*($nilai-76));
    		} else if (($nilai >= 91) AND ($nilai < 99)) {
                        $nilaikonv = 110 + (((120-110)/(99-91))*($nilai-91));
                } else if ($nilai > 99) {
			$nilaikonv = 120;
    		}
		return $nilaikonv;
  	}
	
	function get_nilaiprestasikerja($nip, $tahun)
	{
		$q = $this->db->query("select nilai_prestasi_kerja from riwayat_skp where nip='".$nip."' and tahun='".$tahun."'");
		return $q;                
	}

	function get_predikat2021($nilai)
	{
		if ($nilai < 50) {
                        $predikat = "SANGAT KURANG";
                } else if (($nilai >= 50) AND ($nilai < 70)) {
			$predikat = "KURANG";
                } else if (($nilai >= 70) AND ($nilai < 90)) {
			$predikat = "CUKUP";
                } else if (($nilai >= 90) AND ($nilai <= 120)) {
			$predikat = "BAIK";
		}    
            	return $predikat;
	}
	// END SKP 2021
}
