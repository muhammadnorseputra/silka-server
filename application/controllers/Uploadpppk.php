<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadpppk extends CI_Controller {

  //var $limit=10;
  //var $offset=10;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url')); //load helper url         
        $this->load->model('mpegawai');
        $this->load->model('mnonpns');
        $this->load->model('mpppk');
        $this->load->helper('fungsitanggal');
        $this->load->helper('fungsipegawai');
        $this->load->model('munker');
    }
        
    public function uploadphoto() {      
        $nip = $this->input->post('nipppk');
        $filelama = $this->input->post('filelama');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 9;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$string.'.jpg'; //nama file nip + '-' + $id_golru (2 karakter) + nomor acak (19 karakter acak)
        $config['upload_path'] = './photononpns/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'jpg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '100'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['photo']['name'])
        {   
            if ($this->upload->do_upload('photo'))
            {
                // file lama akan dihapus ketika file baru berhasil diupload
                if (($filelama != '') AND (file_exists('./photononpns/'.$filelama))) {
                    unlink('./photononpns/'.$filelama);
                }

                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                );  

                $dataphoto = array(      
                  'photo'   => $nmfile
                );

                $where = array(
                  'nipppk'      => $nip
                );

                $this->mpppk->edit_pppk($where, $dataphoto);

                $data['pesan'] = '<b>Sukses</b>, Photo berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
                $data['detail'] = $this->mpppk->detail($nip)->result_array();
                $data['content'] = 'pppk/detail';
                $this->load->view('template', $data);
            } else{
                $data['pesan'] = '<b>Gagal</b>, Photo gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
                $data['detail'] = $this->mpppk->detail($nip)->result_array();
                $data['content'] = 'pppk/detail';
                $this->load->view('template', $data);
            }
        } else {
            $data['pesan'] = '<b>Gagal</b>, Photo gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
            $data['detail'] = $this->mpppk->detail($nip)->result_array();
            $data['content'] = 'pppk/detail';
            $this->load->view('template', $data);
        }
    }

    public function uploadberkas() {      
        $nik = $this->input->post('nik');
        $filelama = $this->input->post('filelama');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 9;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nik."-".$string.'.pdf'; //nama file nip + '-' + $id_golru (2 karakter) + nomor acak (19 karakter acak)
        $config['upload_path'] = './filenonpns/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '3048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['berkas']['name'])
        {   
            if ($this->upload->do_upload('berkas'))
            {
                // file lama akan dihapus ketika file baru berhasil diupload
                if (($filelama != '') AND (file_exists('./filenonpns/'.$filelama))) {
                    unlink('./filenonpns/'.$filelama);
                }

                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                  
                );  

                $databerkas = array(      
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nik'      => $nik
                );

                $this->mnonpns->edit_nonpns($where, $databerkas);

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok

                //$nik = $this->input->post('nik');
                $data['pesan'] = '<b>Sukses</b>, Berkas berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
                $data['detail'] = $this->mnonpns->detail($nik)->result_array();
                $data['content'] = 'nonpns/nonpnsdetail';
                $this->load->view('template', $data);
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
                $data['detail'] = $this->mnonpns->detail($nik)->result_array();
                $data['content'] = 'nonpns/nonpnsdetail';
                $this->load->view('template', $data);
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Gagal</b>, Berkas gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
            $data['detail'] = $this->mnonpns->detail($nik)->result_array();
            $data['content'] = 'nonpns/nonpnsdetail';
            $this->load->view('template', $data);
        }
    }

    
}