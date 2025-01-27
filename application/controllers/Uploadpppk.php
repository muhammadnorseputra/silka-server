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
        $this->load->model('mpetajab');;
        $this->load->model('mtppng');
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
        $config['max_size'] = '350'; //maksimum besar file 5M
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

    public function insertskp2024() {
        $nip = $this->input->post('nipppk');

        $this->load->library('upload');

        $nmfile = $nip."-SKP2024"; //nama file nip + '-' + $tmt_jabatan (10 karakter) + nomor acak (8 karakter acak)
        $config['upload_path'] = './fileskpbulanan_pppk/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf|PDF'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '200'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['fileskpbulanan_pppk']['name'])
        {
            if (file_exists('./fileskpbulanan_pppk/'.$nip.'-SKP2024.pdf')) {
               unlink('./fileskpbulanan_pppk/'.$nip.'-SKP2024.pdf');
            } else if (file_exists('./fileskpbulanan_pppk/'.$nip.'-SKP2024.PDF')) {
               unlink('./fileskpbulanan_pppk/'.$nip.'-SKP2024.PDF');
            }

            if ($this->upload->do_upload('fileskpbulanan_pppk'))
            {
                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, Dokumen SKP Tahun 2024 Berhasil di-Upload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Dokumen SKP Tahun 2024 Gagal di-Upload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Gagal</b>, Dokumen SKP Tahun 2024 Gagal di-Upload.';
            $data['jnspesan'] = 'alert alert-warning';
        }

        $nipppk = $nip;
        $data['rwygaji'] = $this->mpppk->rwygaji($nipppk)->result_array();
        $data['pegrwyabs'] = $this->mpppk->rwyabsensi($nipppk)->result_array();
        $data['pegrwykin'] = $this->mpppk->rwykinerja($nipppk)->result_array();
        $data['pegrwykinbkn'] = $this->mpppk->rwykinerjabkn($nipppk)->result_array();
        $data['pegrwytppng'] = $this->mpppk->rwytppng($nipppk)->result_array();
        $data['pegrwycuti'] = $this->mpppk->rwycuti($nipppk)->result_array();
        $data['nipppk'] = $nipppk;
        $data['content'] = 'pppk/rwygaji';
        $this->load->view('template', $data);
    }

    public function insertskpbulanan() {
        $id = $this->input->post('id');
        $nip = $this->input->post('nipppk');
        $thn = $this->input->post('thn');
        $bln = $this->input->post('bln');
        $nmberkaslama = $this->input->post('berkaslama');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 8;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }
        $nmfile = $nip."-".$bln.$thn."-".$string; //nama file nip + '-' + $tmt_jabatan (10 karakter) + nomor acak (8 karakter acak)
        $config['upload_path'] = './fileskpbulanan_pppk/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf|PDF'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '200'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        if($_FILES['fileskpbulanan_pppk']['name'])
        {
            if ($this->upload->do_upload('fileskpbulanan_pppk'))
            {
                /*
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')

                );
                */
                $data = array(
                  'berkas'   => $nmfile
                );

                $where = array(
                  'id'  => $id,
                  'nip' => $nip
                );

                $this->mpegawai->edit_rwyskpbulanan($where, $data);

                if (file_exists('./fileskpbulanan_pppk/'.$nmberkaslama.'.pdf')) {
                         unlink('./fileskpbulanan_pppk/'.$nmberkaslama.'.pdf');
                } else if (file_exists('./fileskpbulanan_pppk/'.$nmberkaslama.'.PDF')) {
                         unlink('./fileskpbulanan_pppk/'.$nmberkaslama.'.PDF');
                }

                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, Berkas Dokumen Penilaian Kinerja Bulanan Berhasil di-Upload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Berkas Dokumen Penilaian Kinerja Bulanan Gagal di-Upload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Gagal</b>, Berkas Dokumen Penilaian Kinerja Bulanan Gagal di-Upload.';
            $data['jnspesan'] = 'alert alert-warning';
        }
        $nipppk = $nip;
        $data['rwygaji'] = $this->mpppk->rwygaji($nipppk)->result_array();
        $data['pegrwyabs'] = $this->mpppk->rwyabsensi($nipppk)->result_array();
        $data['pegrwykin'] = $this->mpppk->rwykinerja($nipppk)->result_array();
        $data['pegrwykinbkn'] = $this->mpppk->rwykinerjabkn($nipppk)->result_array();
        $data['pegrwytppng'] = $this->mpppk->rwytppng($nipppk)->result_array();
        $data['pegrwycuti'] = $this->mpppk->rwycuti($nipppk)->result_array();
        $data['nipppk'] = $nipppk;
        $data['content'] = 'pppk/rwygaji';
        $this->load->view('template', $data);

    }




    
}
