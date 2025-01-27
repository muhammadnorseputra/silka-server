
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

  var $limit=10;
  var $offset=10;

    public function __construct() {
        parent::__construct();
        //$this->load->model('model_upldgbr'); //load model model_upldgbr yang berada di folder model
        $this->load->helper(array('url')); //load helper url 
        $this->load->model('mpegawai');
	$this->load->model('mpppk');

        $this->load->helper('fungsitanggal');
        $this->load->helper('fungsipegawai');
        $this->load->model('munker');
        $this->load->model('mkinerja');
	$this->load->model('mpetajab');
	$this->load->model('mtppng');
	$this->load->model('mpip');
    }

    /*public function index($page=NULL,$offset='',$key=NULL)
    {        
        $data['query'] = $this->model_upldgbr->get_allimage(); //query dari model
        
        $this->load->view('home',$data); //tampilan awal ketika controller upload di akses
    }

    public function add() {
        //view yang tampil jika fungsi add diakses pada url
        $this->load->view('fupload');
       
    }
    */
    public function insertskp() {      

        $nip = $this->input->post('nip');    
        $thn = $this->input->post('thn'); 

        $this->load->library('upload');
        $nmfile = $nip."-".$thn; //nama file nip + tahun skp
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './fileskp/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '3072'; //maksimum besar file 3M, setting pada php.ini hanya 2MB
        //$config['max_width']  = '5000'; //lebar maksimum 5000 px
        //$config['max_height']  = '5000'; //tinggi maksimu 5000 px
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        
        if($_FILES['fileskp']['name'])
        {
            if (file_exists('./fileskp/'.$nmfile.'.pdf')) {
            unlink('./fileskp/'.$nmfile.'.pdf');
            }

            if (file_exists('./fileskp/'.$nmfile.'.PDF')) {
            unlink('./fileskp/'.$nmfile.'.PDF');
            }

            if ($this->upload->do_upload('fileskp'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                  
                );                
                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Berkas SKP Tahun <u>'.$thn.'</u> berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas SKP Tahun <u>'.$thn.'</u> gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';                
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas SKP Tahun <u>'.$thn.'</u> gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';                
        }
        
        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    public function insertcpnspns() {      
        // Awal menggunakan FTP
        /*
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');            
    
        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 21;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$string; //nama file nip (18 karakter) + '-' + nomor acak (21 karakter acak)
        $config['upload_path'] = './filecp/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya
      
        
        if($_FILES['filecp']['name'])
        {
            $this->load->library('ftp');

            $config['hostname'] = '192.168.1.4';
            $config['username'] = 'silka_ftp';
            $config['password'] = 'FtpSanggam';
            $config['debug'] = TRUE;

            $this->ftp->connect($config);

            if ($this->ftp->upload('filecp', '/filecp/'.$nmfile.'.pdf', 'ascii', 0775))
            {                         
                $this->ftp->close();

                $datacpnspns = array(      
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'      => $nip
                );

                $this->mpegawai->edit_cpnspns($where, $datacpnspns);

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Berkas CPNS / PNS berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas CPNS / PNS gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas CPNS / PNS gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }

        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);

        */
        // Akhir menggunakan FTP
        
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');    

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 21;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$string; //nama file nip (18 karakter) + '-' + nomor acak (21 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filecp/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        
        if($_FILES['filecp']['name'])
        {
            if ($this->upload->do_upload('filecp'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                  
                );                
                $datacpnspns = array(      
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'      => $nip
                );

                $this->mpegawai->edit_cpnspns($where, $datacpnspns);

		// file lama dihapus, karena 1 orang PNS hanya memiliki 1 SK CPNS dan 1 SK PNS
            	if (file_exists('./filecp/'.$nmberkaslama.'.pdf')) {
                	unlink('./filecp/'.$nmberkaslama.'.pdf');
            	}	

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Berkas CPNS / PNS berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas CPNS / PNS gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas CPNS / PNS gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }

        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    public function berkas_pns() {      
        
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');    

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 21;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-BERKASPNS-".$string; //nama file nip (18 karakter) + '-' + nomor acak (21 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filecp/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf|PDF'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '5120'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        
        if($_FILES['filecp']['name'])
        {
            if ($this->upload->do_upload('filecp'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                  
                );                
                $datapns = array(      
                  'berkas_pns'   => $nmfile
                );

                $where = array(
                  'nip'      => $nip
                );

                $this->mpegawai->edit_cpnspns($where, $datapns);

		// file lama dihapus, karena 1 orang PNS hanya memiliki 1 SK CPNS dan 1 SK PNS
            	if (file_exists('./filecp/'.$nmberkaslama.'.pdf')) {
                	unlink('./filecp/'.$nmberkaslama.'.pdf');
            	} else if (file_exists('./filecp/'.$nmberkaslama.'.PDF')) {
                        unlink('./filecp/'.$nmberkaslama.'.PDF');
                }	

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Kelangkapan Berkas berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Kelangkapan Berkas gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Kelangkapan Berkas gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }

        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    public function insertkp() {      

        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
        $id_golru = $this->input->post('id_golru');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 19;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$id_golru.$string; //nama file nip + '-' + $id_golru (2 karakter) + nomor acak (19 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filekp/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['filekp']['name'])
        {            
            if ($this->upload->do_upload('filekp'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                  
                );                
                $datakp = array(      
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'       => $nip,
                  'fid_golru' => $id_golru
                );

                $this->mpegawai->edit_kp($where, $datakp);

		if (file_exists('./filekp/'.$nmberkaslama.'.pdf')) {
                	unlink('./filekp/'.$nmberkaslama.'.pdf');
            	}

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Berkas SK Kenaikan Pangkat Terakhir berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas SK Kenaikan Pangkat Terakhir gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas SK Kenaikan Pangkat Terakhir gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }
        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    public function insertkgb() {      

        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
        $mkthn = $this->input->post('mkthn');
        $mkbln = $this->input->post('mkbln');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 17;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        //nama file nip (18 karakter) + '-' + $mkthn (2 karakter) + $mkbln (2 karakter) + nomor acak (17 karakter acak)
        $nmfile = $nip."-".$mkthn.$mkbln.$string; 
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filekgb/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['filekgb']['name'])
        {            
            if ($this->upload->do_upload('filekgb'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')
                  
                );                
                $datakp = array(      
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'      => $nip,
                  'mk_thn'      => $mkthn,
                  'mk_bln'      => $mkbln
                );

                $this->mpegawai->edit_kgb($where, $datakp);

		if (file_exists('./filekgb/'.$nmberkaslama.'.pdf')) {
                	unlink('./filekgb/'.$nmberkaslama.'.pdf');
            	}

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Berkas SK KGB Terakhir berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas SK KGB Terakhir gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas SK KGB Terakhir gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }
        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    public function insertcuti() {      

        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
        $jnscuti = $this->input->post('jeniscuti');
        $thncuti = $this->input->post('tahuncuti');
        $idcuti = $this->input->post('id');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 17;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        //nama file nip (18 karakter) + '-' + jenis cuti + tahuncuti nomor acak (17 karakter acak)
        $nmfile = $nip."-".$jnscuti."-".$thncuti.$string; 
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filecuti/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '1024'; //maksimum besar file 1M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['filecutiupload']['name'])
        {            
            if ($this->upload->do_upload('filecutiupload'))
            {
                $dataupload = $this->upload->data();
                $data = array(
                  'namafile' =>$dataupload['file_name'],
                  'type' =>$dataupload['file_type'],
                  'keterangan' =>$this->input->post('textket')
                );                
                $datatodb = array(      
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'      => $nip,
                  'id' => $idcuti
                );

                $this->mpegawai->edit_cuti($where, $datatodb);

		        if (file_exists('./filecuti/'.$nmberkaslama.'.pdf')) {
                	unlink('./filecuti/'.$nmberkaslama.'.pdf');
            	}

                //pesan yang muncul jika berhasil diupload pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\">Upload gambar berhasil !!</div></div>");
                
                //redirect('./pegawai/uploadok'); //jika berhasil maka akan ditampilkan view upload ok
                $data['pesan'] = '<b>Sukses</b>, Berkas SK CUTI Terakhir berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                //$this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                
                //redirect('./pegawai/uploadnok'); //jika gagal maka akan ditampilkan view upload not ok
                $data['pesan'] = '<b>Gagal</b>, Berkas SK CUTI Terakhir gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Gagal</b>, Berkas SK CUTI Terakhir gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }
        $data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    // TODO PROPER PAK SYAIFULL : Upload file SK Jabatan
    public function insertjab() {
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
        $tmtjab = $this->input->post('tmtjab');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 8;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$tmtjab.$string; //nama file nip + '-' + $tmt_jabatan (10 karakter) + nomor acak (8 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filejab/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

 	if($_FILES['filejab']['name'])
        {
            if ($this->upload->do_upload('filejab'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')

                );
                $datakp = array(
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'       => $nip,
                  'tmt_jabatan' => $tmtjab
                );

                $this->mpegawai->edit_rwyjab($where, $datakp);
		
		if (file_exists('./filejab/'.$nmberkaslama.'.pdf')) {
                	unlink('./filejab/'.$nmberkaslama.'.pdf');
            	}
		
                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, Berkas SK Jabatan berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
		//pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Berkas SK Jabatan gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas SK Jabatan gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }
        $data['nip'] = $nip;
	$data['peg'] = $this->mpegawai->detail($nip)->result_array();
    	$data['nip'] = $nip;
    	$data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

     public function insertpdk() {
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
        $thn_lulus = $this->input->post('thn_lulus');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 8;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$thn_lulus.$string; //nama file nip + '-' + $tmt_jabatan (10 karakter) + nomor acak (8 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filepdk/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '1024'; //maksimum besar file 2M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

	$this->upload->initialize($config);

        if($_FILES['filepdk']['name'])
        {
            if ($this->upload->do_upload('filepdk'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')

                );
                $datakp = array(
                  'berkas'   => $nmfile
                );

		 $where = array(
                  'nip'       => $nip,
                  'thn_lulus' => $thn_lulus
                );

                $this->mpegawai->edit_rwypdk($where, $datakp);

		if (file_exists('./filepdk/'.$nmberkaslama.'.pdf')) {
	                unlink('./filepdk/'.$nmberkaslama.'.pdf');
        	}

                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, Berkas Ijazah Pendidikan berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Berkas Ijazah Pendidikan gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas Ijazah Pendidikan gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }
	$data['nip'] = $nip;
        $data['peg'] = $this->mpegawai->detail($nip)->result_array();
        $data['nip'] = $nip;
        $data['content'] = 'pegdetail';
        $this->load->view('template', $data);
    }

    
    // START  PROPER DEWI : Upload SK Disiplin
    public function inserthd() {
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
        $tmt = $this->input->post('tmt');
        $jnshd = $this->input->post('jnshd');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 8;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        $nmfile = $nip."-".$string; //nama file nip + '-' + $tmt_jabatan (10 karakter) + nomor acak (8 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './filehd/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '1024'; //maksimum besar file dalam kilobyte
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['filehd']['name'])
        {
            if ($this->upload->do_upload('filehd'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')

                );
                $datakp = array(
                  'berkas'   => $nmfile
                );

                 $where = array(
                  'nip'       => $nip,
                  'tmt_hukuman' => $tmt,
                  'fid_jenis_hukdis' => $jnshd
                );

                $this->mpegawai->edit_rwyhd($where, $datakp);

                if (file_exists('./filehd/'.$nmberkaslama.'.pdf')) {
                        unlink('./filehd/'.$nmberkaslama.'.pdf');
                }

                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, Berkas SK Hukuman Disiplin berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Berkas SK Hukuman Disiplin gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Berkas SK Hukuman Disiplin gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }

    $data['pegrwyhd'] = $this->mpegawai->rwyhd($nip)->result_array();       
    $data['nip'] = $nip;
    $data['content'] = 'rwyhd';
    $this->load->view('template', $data);
    }
    // END PROPER DEWI : Upload SK Disiplin

    // START UPDATE PHOTO
    public function updatephoto() {
        $nip = $this->input->post('nip');
        $this->load->library('upload');

        $nmfile = $nip;
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './photo_temp/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'jpg'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '80'; //maksimum besar file 100 Kb
        $config['max_width']  = '250'; //lebar maksimum 450 px
        $config['max_height']  = '250'; //tinggi maksimu 450 px
        
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['filephoto']['tmp_name'])
        {
            if (file_exists('./photo_temp/'.$nip.'.jpg')) {
                unlink('./photo_temp/'.$nip.'.jpg');
            }

            if ($this->upload->do_upload('filephoto'))
            {
                $gbr = $this->upload->data();

                $user = $this->session->userdata('nip');
                $tgl_aksi = $this->mlogin->datetime_saatini();

                $image     = file_get_contents($_FILES['filephoto']['tmp_name']);
                $data = array(
                  'photo'    => $image,
                  'nip'      => $nip,
                  'approved' => "TIDAK",
                  'entry_by' => $user,
                  'entry_at' => $tgl_aksi
                );  

                $wherehapus = array('nip' => $nip);

                $nama = $this->mpegawai->getnama($nip);
                
                if ($this->mpegawai->rwyupdate($nip)) {
                    $this->mpegawai->hapus_updatephoto($wherehapus);
                }

                $this->mpegawai->input_updatephoto($data);                

                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, photo berhasil diupload, tunggu konfirmasi Admin BKPPD';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Photo gagal diupload, periksa kembali file yang diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Sukses</b>, Photo gagal diupload, periksa kembali file yang diupload';
            $data['jnspesan'] = 'alert alert-danger';
        }

        //$data['peg'] = $this->mpegawai->detail($nip)->result_array();
        //$data['content'] = 'pegdetail';
        //$this->load->view('template', $data);

        $data['nip'] = $nip;   
        $data['content'] = 'updatephoto';
        $this->load->view('template', $data);
    }

    // END UPDATE PHOTO

    // START UPLOAD DOKUMEN PENILAIAN KINERJA BULANAN
    public function insertskpbulanan() {
        $id = $this->input->post('id');
	$nip = $this->input->post('nip');
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
        $config['upload_path'] = './fileskpbulanan/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf|PDF'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '200'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['fileskpbulanan']['name'])
        {
            if ($this->upload->do_upload('fileskpbulanan'))
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
		  'id'	=> $id,
                  'nip' => $nip
                );

                $this->mpegawai->edit_rwyskpbulanan($where, $data);

                if (file_exists('./fileskpbulanan/'.$nmberkaslama.'.pdf')) {
                         unlink('./fileskpbulanan/'.$nmberkaslama.'.pdf');
                } else if (file_exists('./fileskpbulanan/'.$nmberkaslama.'.PDF')) {
                         unlink('./fileskpbulanan/'.$nmberkaslama.'.PDF');
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
        $data['nip'] = $nip;
	$data['pegrwyabs'] = $this->mpegawai->rwyabsensi($nip)->result_array();
    	$data['pegrwykinlama'] = $this->mpegawai->rwykinerja($nip)->result_array();
    	$data['pegrwykinbkn'] = $this->mpegawai->rwykinerjabkn($nip)->result_array();
    	$data['pegrwytpp'] = $this->mpegawai->rwytpp($nip)->result_array();
    	$data['pegrwytppng'] = $this->mpegawai->rwytppng($nip)->result_array();
    	$data['pegrwygaji'] = $this->mpegawai->rwygaji($nip)->result_array();
    	$data['content'] = 'rwytpp';

        $this->load->view('template', $data);
    }

    // START UPLOAD DOKUMEN PENILAIAN KINERJA BULANAN
    public function insertskp2024() {
        $nip = $this->input->post('nip');

        $this->load->library('upload');

        $nmfile = $nip."-SKP2024"; //nama file nip + '-' + $tmt_jabatan (10 karakter) + nomor acak (8 karakter acak)
        $config['upload_path'] = './fileskpbulanan/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf|PDF'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '200'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['fileskpbulanan']['name'])
        {
            if (file_exists('./fileskpbulanan/'.$nip.'-SKP2024.pdf')) {
               unlink('./fileskpbulanan/'.$nip.'-SKP2024.pdf');
            } else if (file_exists('./fileskpbulanan/'.$nip.'-SKP2024.PDF')) {
               unlink('./fileskpbulanan/'.$nip.'-SKP2024.PDF');
            }
	
            if ($this->upload->do_upload('fileskpbulanan'))
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
        $data['nip'] = $nip;
        $data['pegrwyabs'] = $this->mpegawai->rwyabsensi($nip)->result_array();
        $data['pegrwykinlama'] = $this->mpegawai->rwykinerja($nip)->result_array();
        $data['pegrwykinbkn'] = $this->mpegawai->rwykinerjabkn($nip)->result_array();
        $data['pegrwytpp'] = $this->mpegawai->rwytpp($nip)->result_array();
        $data['pegrwytppng'] = $this->mpegawai->rwytppng($nip)->result_array();
        $data['pegrwygaji'] = $this->mpegawai->rwygaji($nip)->result_array();
        $data['content'] = 'rwytpp';

        $this->load->view('template', $data);
    }

    // end UPLOAD DOKUMEN PENILAIAN KINERJA BULANAN	


    // START UPLOAD DOKUMEN TBN LHKPN
    public function insert_tbnlhkpn() {
        $nip = $this->input->post('nip');
        $thn = $this->input->post('thn');

        $this->load->library('upload');

        $nmfile = $nip."-".$thn; //nama file nip + '-' + $thn
        $config['upload_path'] = './filelhkpn/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf|PDF'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '1024'; //maksimum besar file 1M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['filetbn']['name'])
        {
            if (file_exists('./filelhkpn/'.$nip.'-'.$thn.'.pdf')) {
               unlink('./filelhkpn/'.$nip.'-'.$thn.'.pdf');
            } else if (file_exists('./filelhkpn/'.$nip.'-'.$thn.'.PDF')) {
               unlink('./filelhkpn/'.$nip.'-'.$thn.'.PDF');
            }

            if ($this->upload->do_upload('filetbn'))
            {
		$data = array(
                  'file_tbn'   => $nmfile
                );

                $where = array(
                  'nip' => $nip,
		  'tahun_wajib' => $thn
                );

                $this->mpegawai->edit_rwylhkpn($where, $data);

                //pesan yang muncul jika berhasil diupload pada session flashdata
                $data['pesan'] = '<b>Sukses</b>, Dokumen TBN LHKPN Tahun '.$thn.' Berhasil di-Upload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $data['pesan'] = '<b>Gagal</b>, Dokumen TBN LHKPN Tahun '.$thn.' Gagal di-Upload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Gagal</b>, Dokumen TBN LHKPN Tahun '.$thn.' Gagal di-Upload.';
            $data['jnspesan'] = 'alert alert-warning';
        }
        $data['nip'] = $nip;
	$data['pegrwylhkpn'] = $this->mpegawai->rwylhkpn($nip)->result_array();
    	$data['content'] = 'rwylhkpn';
        $this->load->view('template', $data);
    }
    // end UPLOAD DOKUMEN DOKUMEN TBN LHKPN

    public function insertpmk() {
        $nip = $this->input->post('nip');
        $nmberkaslama = $this->input->post('nmberkaslama');
	$tmt = $this->input->post('tmt');

        $this->load->library('upload');

        // membuat nomor acak untuk nama file
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string='';
        $pjg = 17;
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }

        //nama file nip (18 karakter) + '-' + $mkthn (2 karakter) + $mkbln (2 karakter) + nomor acak (17 karakter acak)
        $nmfile = $nip."-".$tmt."-".$string;
        $config['upload_path'] = './filepmk/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if($_FILES['filepmk']['name'])
        {
            if ($this->upload->do_upload('filepmk'))
            {
                $gbr = $this->upload->data();
                $data = array(
                  'namafile' =>$gbr['file_name'],
                  'type' =>$gbr['file_type'],
                  'keterangan' =>$this->input->post('textket')

                );
                $datapmk = array(
                  'berkas'   => $nmfile
                );

                $where = array(
                  'nip'      => $nip,
                  'tmt_baru' => $tmt,
                );

                $this->mpegawai->edit_rwypmk($where, $datapmk);

                if (file_exists('./filepmk/'.$nmberkaslama.'.pdf')) {
                        unlink('./filepmk/'.$nmberkaslama.'.pdf');
                }

                $data['pesan'] = '<b>Sukses</b>, Berkas SK PMK berhasil diupload.';
                $data['jnspesan'] = 'alert alert-success';
            } else{
                $data['pesan'] = '<b>Gagal</b>, Berkas SK PMK gagal diupload.';
                $data['jnspesan'] = 'alert alert-danger';
            }
        } else {
            //redirect('./pegawai/uploadnok'); //jika file belum dipilih maka akan ditampilkan view upload no ok
            $data['pesan'] = '<b>Gagal</b>, Berkas SK PMK gagal diupload.';
            $data['jnspesan'] = 'alert alert-danger';
        }
        $data['nip'] = $nip;
	$data['pegrwypmk'] = $this->mpegawai->rwypmk($nip)->result_array();
        $data['content'] = 'rwypmk';
        $this->load->view('template', $data);
    }


}
