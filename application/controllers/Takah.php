<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Takah extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->library('fpdf');
      $this->load->model('mtakah');
      $this->load->model('munker');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }
    }
  
	public function index()
	{	  
	}

  // UNTUK TATA NASKAH
  function rwytakah()
  {    
    $nip = $this->input->post('nip');
    $data['rwytakah'] = $this->mtakah->rwytakah($nip)->result_array();
    $data['nip'] = $nip;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'rwytakah';
    $this->load->view('template', $data);
  }  

  function showuploadtakah() {
    //$nip = $this->input->post('nip'); // jika menggunakan metode post pada ajax
    $nip = $this->input->get('nip'); 
    ?>
  
    <div class="panel panel-default" style='width :800px'>
    <div class="panel-heading" align='left'><b>UPLOAD DOKUMEN</b>

    <form method='POST' action='../takah/uploadtakah' enctype='multipart/form-data'>
    <small style='color: red'>File yang dapat di-upload harus dalam format .pdf dengan ukuran maksimal 500 Kb</small>
    <table class="table table-condensed">
    <tr>      
      <td>
        <?php
        $jnstakah = $this->mtakah->jnstakah()->result_array();
        echo "<select name='id_jnstakah' class='btn btn-info btn-outline' required>";            
        echo "<option value=''>- Pilih Jenis Dokumen -</option>";
        foreach($jnstakah as $jt)
        {
          echo "<option value='".$jt['id_jenis_takah']."'>".$jt['nama_jenis_takah']."</option>";
        }
        echo "</select>"
        ?>            
      </td>      
      <td>
          <input type="file" name="filetakah" class="btn btn-sm btn-info btn-outline" required/>
          <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
      </td>
      <td>
          <button type="submit" class="btn btn-sm btn-info btn-outline">
          <i class="fa fa-upload fa-fw"></i>&nbspUpload Dokumen</button>
      </td>
      </form>
      <td width='300' align='right'>        
        <form method='POST' action='../takah/rwytakah'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-warning btn-outline btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp
            </button>
        </form>
      </td>    
    </tr>
    </table>
    </div>
    <?php
  }

  function uploadtakah() {
    $nip = $this->input->post('nip');
    $id_jnstakah = $this->input->post('id_jnstakah');
    //$filetakah = $this->input->post('filetakah');
     
      // Menggunakan library CI
      /*
      $config['hostname'] = 'localhost';
      $config['username'] = 'root';
      $config['password'] = 'root';
      $config['debug']    = TRUE;

      $konek = $this->ftp->connect($config);

      if($konek){
                  //echo "Connected as $ftpUsername@$ftpHost";
        $data['pesan'] = '<b>Sukses</b>, Koneksi Berhasil';
        $data['jnspesan'] = 'alert alert-success';
      }else{
                  //echo "Couldn't connect as $ftpUsername";
        $data['pesan'] = '<b>Sukses</b>, Koneksi Gagal';
        $data['jnspesan'] = 'alert alert-danger';
      }
      

      // Untuk List File pada remote FTP Server
      //$list = $this->ftp->list_files('');
      //print_r($list);

      // untuk uplaod file
      $this->ftp->upload('D:\Balangan.pdf', 'Balangan.pdf', 'auto', 0775);
      
      // untuk tutup koneksi
      $this->ftp->close();

      // close / Tutup the connection
      //ftp_close($connId);
      */
      
      $this->load->library('upload');

      // membuat nomor acak untuk nama file
      $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $string='';
      $pjg = 7;
      for ($i=0; $i < $pjg; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};
      }

        $nmfile = $nip."-".$id_jnstakah.$string.".pdf"; //nama file nip + '-' + $id_golru (2 karakter) + nomor acak (19 karakter acak)
        //$nmfile = "file_".time(); //nama file + fungsi time
        //$config['upload_path'] = './assets/uploads/'; //Folder untuk menyimpan hasil upload
        $config['upload_path'] = './fileperso/'; //Folder untuk menyimpan hasil upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '1028'; //maksimum besar file 5M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['filetakah']['name'])
        {   
          // cek apakah data takah sudah ada sesuai jenis yang dipilih         
          if ($this->mtakah->cek_adatakah($nip,  $id_jnstakah)) {
            // jika ada, hapus file di server, karena akan digantikan dengan file baru yang akan diupload
            $berkas = $this->mtakah->getfiletakah($nip,  $id_jnstakah);
            if (file_exists('./fileperso/'.$berkas)) {
              unlink('./fileperso/'.$berkas);
            }

            if ($this->upload->do_upload('filetakah'))
            {
              $user = addslashes($this->session->userdata('nip'));
              $tgl_aksi = $this->mlogin->datetime_saatini();

              $datatakah = array(      
                'file'   => $nmfile,
                'upload_at' => $tgl_aksi,
                'upload_by' => $user
                );

              $where = array(
                'nip'       => $nip,
                'fid_jenis_takah'   => $id_jnstakah
                );

              $this->mtakah->edit_takah($where, $datatakah);
                  
              $data['pesan'] = '<b>Sukses</b>, Berkas Tata Naskah berhasil diupload.';
              $data['jnspesan'] = 'alert alert-success';
            } else{
              $data['pesan'] = '<b>Gagal</b>, Berkas Tata Naskah gagal diupload.';
              $data['jnspesan'] = 'alert alert-danger';
            }
          // jika data tidak ada, berarti ditambahkan (input)
          } else {
            if ($this->upload->do_upload('filetakah'))
            {              
              $user = addslashes($this->session->userdata('nip'));
              $tgl_aksi = $this->mlogin->datetime_saatini();

              $datatakah = array(      
              'nip'               => $nip,
              'fid_jenis_takah'   => $id_jnstakah,
              'file'              => $nmfile,
              'upload_at'         => $tgl_aksi,
              'upload_by'         => $user
              );
              $this->mtakah->input_takah($datatakah);
                  
              $data['pesan'] = '<b>Sukses</b>, Berkas Tata Naskah berhasil ditambah.';
              $data['jnspesan'] = 'alert alert-success';
            } else{
              $data['pesan'] = '<b>Gagal</b>, Berkas Tata Naskah gagal ditambah.';
              $data['jnspesan'] = 'alert alert-danger';
            }
          }
        }

      $data['nip'] = $nip;
      $data['rwytakah'] = $this->mtakah->rwytakah($nip)->result_array();
      $data['content'] = 'rwytakah';
      $this->load->view('template', $data);
    }

  function hapustakah_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $fidjenis = addslashes($this->input->post('fidjenis'));
      $file = $this->input->post('file');

    // hapus file
    if (file_exists('./fileperso/'.$file)) {
        unlink('./fileperso/'.$file);
    }

    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'fid_jenis_takah' => $fidjenis
             );
    
    $nama = $this->mpegawai->getnama($nip);
    if ($this->mtakah->hapus_takah($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data Tata Naskah PNS A.n. <u>'.$nama.'</u> berhasil dihapus';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal</b>, Data Tata Naskah PNS A.n. <u>'.$nama.'</u> gagal dihapus';
      $data['jnspesan'] = 'alert alert-danger';
    }
 
    $data['nip'] = $nip;
    $data['rwytakah'] = $this->mtakah->rwytakah($nip)->result_array();
    $data['content'] = 'rwytakah';
    $this->load->view('template', $data);
  }

    function downloadtakah() {
      $nip = $this->input->post('nip');
      $id_jnstakah = $this->input->post('id_jnstakah');

      $user = addslashes($this->session->userdata('nip'));
      $tgl_aksi = $this->mlogin->datetime_saatini();

      
      $datatakah = array(
        'download_at' => $tgl_aksi,
        'download_by' => $user
        );

      $where = array(
        'nip'       => $nip,
        'fid_jenis_takah'   => $id_jnstakah
        );

      $this->mtakah->edit_takah($where, $datatakah);

      $data['pesan'] = '<b>Sukses</b>, Berkas Tata Naskah berhasil diupload.';
      $data['jnspesan'] = 'alert alert-success';

    $data['nip'] = $nip;
    $data['rwytakah'] = $this->mtakah->rwytakah($nip)->result_array();
    $data['content'] = 'rwytakah';
    $this->load->view('template', $data);
  }

  function tampilunkernomtakah()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'tampilunkernomtakah';
      $this->load->view('template',$data);
    }
  }

  function nomtakahperunker()
  { 
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $id = $this->input->post('id_unker');
      $data['peg'] = $this->mtakah->nomtakahperunker($id)->result_array();
      $data['idunker'] = $id;
      $data['nmunker'] = $this->munker->getnamaunker($id);
      $data['jmlpeg'] = $this->munker->getjmlpeg($id);
      $data['content'] = 'nomtakahperunker';
      $this->load->view('template',$data);
    }
  }  

  function cekadafilenom($nip, $id_jenis)
  {    
    $hasil = $this->mtakah->cek_adafiletakah($nip, $id_takah);
    if ($hasil == 1) { // file ada 
      echo "<span class='label label-success'>Download File</span>";
    } else if ($hasil == 0) { // file tidak ada

    }
  }
  
  public function cetaknomperunker()
  {
    $unkerid = $this->input->post('id');
    $data = $this->mtakah->nomtakahperunker($unkerid)->result();
    
    $send['result_data'] = $data;
    $this->load->view('cetaktakahperunker', $send);
    // echo $unkerid;
  }
}

/* End of file Akunpns.php */
/* Location: ./application/controllers/Akunpns.php */
