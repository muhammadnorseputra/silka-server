<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapi extends CI_Controller {

	public function get_agama()
    {
        $query = $this->db->get("ref_agama");
        return $query->result();
    }	
}