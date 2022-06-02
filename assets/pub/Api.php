<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {

        parent::__construct();
        //load model web
        $this->load->model('Mapi');
    }

    public function index()
    {
        //get data dari model
        $agama = $this->Mapi->get_agama();
        //masukkan data kedalam variabel
        $data['agam'] = $agama;
        //deklarasi variabel array
        $response = array();
        $posts = array();
        //lopping data dari database
        foreach ($agama as $hasil)
        {
            $posts[] = array(
                "id"                 =>  $hasil->id_agama,
                "nama"            =>  $hasil->nama_agama
            );
        }
        $response['agama'] = $posts;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);

    }

    function get_agama() {
        $id = $this->input->get('id');
                        
        $this->db->select('nama_agama');
        $this->db->from('ref_agama');
        $this->db->where("id_agama !=", $id);
        //$this->db->where("nama_agama !=", "BUDHA");
        $agama=$this->db->get()->result();

        //$this->db->where('id_agama', $id);
        //$agama = $this->db->get('ref_agama')->result();

        $response['agama'] = $agama;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);
    }

    //http://localhost/silka/index.php/api/get_pns?nip=198104072009041002
    function get_pns() {
        $nip = $this->input->get('nip');
        $this->db->where('nip', $nip);
        $pns = $this->db->get('pegawai')->result();

        $response['get_pns'] = $pns;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);
    }

    //http://localhost/silka/index.php/api/get_pns1?nip=198104072009041002
    function detail_pns() {        
        $nip = $this->input->get('nip');
        $sql = "select p.nip, CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as nama, p.tmp_lahir,
p.tgl_lahir,p.jenis_kelamin, ns.nama_status_pegawai, u.nama_unit_kerja,
(select js.nama_jabatan from ref_jabstruk as js, pegawai as p where p.fid_jabatan=js.id_jabatan and p.nip='$nip') as jabstruk,
(select ju.nama_jabfu from ref_jabfu as ju, pegawai as p where p.fid_jabfu=ju.id_jabfu and p.nip='$nip') as jabfu,
(select jt.nama_jabft from ref_jabft as jt, pegawai as p where p.fid_jabft=jt.id_jabft and p.nip='$nip') as jabft,
p.tmt_jabatan, g.nama_golru, p.tmt_golru_skr, 
CONCAT(tp.nama_tingkat_pendidikan,' - ',jp.nama_jurusan_pendidikan) as pendidikan
from pegawai as p, ref_status_pegawai as ns, ref_golru as g, ref_tingkat_pendidikan as tp,
ref_jurusan_pendidikan as jp, ref_unit_kerjav2 as u
where
p.fid_golru_skr = g.id_golru
and p.fid_status_pegawai = ns.id_status_pegawai
and p.`fid_unit_kerja` = u.id_unit_kerja
and p.`fid_tingkat_pendidikan` = tp.`id_tingkat_pendidikan`
and p.`fid_jurusan_pendidikan` = jp.`id_jurusan_pendidikan`
and p.nip='$nip'";
        $hasil = $this->db->query($sql)->result();
        $response['detail pns'] = $hasil;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);   
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
