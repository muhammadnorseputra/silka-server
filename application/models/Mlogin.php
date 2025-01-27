<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlogin extends CI_Model {

    function cek($nip, $username, $password)
    {
    	$pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file admin.php pada tambahuser_aksi)
    	$pass=md5($pengacak1 . md5($password));

	    
	    // start metode 1
	    $this->db->where('nip', $nip);
	    $this->db->where('username', $username);
	    $this->db->where('password', $pass);

	    return $this->db->get('userportal');
	   	// end 1
	    

	    // start metode 2
		//$this->db->select()->from('userportal')->where(array('nip'=>$nip, 'username'=>$username, 'password'=>$pass));
		//return $this->db->get();    
	    // end 2

	    // start metode 3
		//return $this->db->get_where('userportal', array('nip'=>$nip, 'username'=>$username, 'password'=>$pass));
		// end 3

		// start metode 4
		//$query = 'SELECT * FROM userportal WHERE nip='.$this->db->escape($nip).' AND username='.$this->db->escape($username).' AND password='.$this->db->escape($pass); 
		//return $this->db->query($query);
		// end 4
		
    }

    // untuk login PNS
    function ceklogin_pns($nip, $password)
    {	    
    	$pengacak1 = "da1243ty"; // karakter pengacak1 (juga ditentukan pada file admin.php pada tambahuser_aksi)
    	$pass=md5($pengacak1 . md5($password));

	    // start metode 1
	    $this->db->where('nip', $nip);
	    $this->db->where('password', $pass);
	    $this->db->where('status', 'AKTIF');

	    return $this->db->get('userportal_pns');
	 	
    }

    // untuk login sebagai PNS
	  function cekuser_pns($nip)
	  {
	    $q = $this->db->query("select nip from userportal_pns where nip='$nip'");
	    if ($q->num_rows()>0)
	    {	      
	      return true; 
	    }        
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

	  function edit_userportal($where, $data){
	    $this->db->where($where);
	    $this->db->update('userportal',$data);
	    return true;
	  }

	 // untuk login sebagai PNS
	  function edit_userportal_pns($where, $data) {
	    $this->db->where($where);
	    $this->db->update('userportal_pns',$data);
	    return true;
	  }

}

/* End of file mlogin.php */
/* Location: ./application/models/mlogin.php */
