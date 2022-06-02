<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlogin extends CI_Model {

    function cek($nip, $username, $password)
    {
    	$pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file admin.php pada tambahuser_aksi)
    	$pass=md5($pengacak1 . md5($password));

	    $this->db->where('nip', $nip);
	    $this->db->where('username', $username);
	    $this->db->where('password', $pass);
	    return $this->db->get(userportal);
    }

    //untuk menfgambil tanggal dan waktu saat ini, digunakan untuk mencatat waktu created dan update pada tabel database
    function datetime_saatini()
	  {
	    $q = $this->db->query("select now() as saatini");
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      return $row->saatini; 
	    }        
	  }

	  function getnamauser($nip)
	  {
	    $q = $this->db->query("select username from userportal where nip='$nip'");
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      return $row->username; 
	    }        
	  }

	  function getnipuser($nama)
	  {
	    $q = $this->db->query("select nip from userportal where username='$nama'");
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      return $row->nip; 
	    }        
	  }

	  function getpwd($nip)
	  {
	    $q = $this->db->query("select password from userportal where nip='$nip'");
	    if ($q->num_rows()>0)
	    {
	      $row=$q->row();
	      return $row->password; 
	    }        
	  }
}

/* End of file mlogin.php */
/* Location: ./application/models/mlogin.php */