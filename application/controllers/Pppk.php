<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pppk extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('mpppk');
      $this->load->model('mnonpns');
      $this->load->model('mstatistik');
      $this->load->model('munker');
      $this->load->model('datacetaknonpns');

      // untuk login session, jika session nama tidak ada, kembali ke form login
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // untuk fpdf
      $this->load->library('fpdf');
      
    }  

	public function index()
	{	  

	}
  
  function tampilunker()
  {
    if ($this->session->userdata('profil_priv') == "Y") { 
      $data['unker'] = $this->munker->dd_unker()->result_array();      
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'pppk/tampilunker';
      $this->load->view('template',$data);
    }
  }  
  
  function tampildatacari()
  {
    $data = $this->input->post('data');
    if ($data != '') {
      if ($this->session->userdata('nonpns_priv') == "Y") { 
        $data = $this->input->post('data');
        // dapatkan data dengan nipppk dan nama
        $datatnp['datapppk'] = $this->mpppk->getnipnama($data)->result_array();
        $datatnp['jmldata'] = count($this->mpppk->getnipnama($data)->result_array());
        $datatnp['content'] = 'pppk/tampildatacari';
        $this->load->view('template', $datatnp);
      }
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Pencarian data gagal, silahkan entri NIP atau Nama.';
      $data['jnspesan'] = 'alert alert-danger';

      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'pppk/tampilunker';
      $this->load->view('template', $data);
    }
  }
  
  //untuk detail pppk
  function detail() {
  	//cek priviledge session user -- profil_priv
    if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') == "TAMU")) { 
      $nip = $this->input->post('nipppk');
      $data['detail'] = $this->mpppk->detail($nip)->result_array();
      $data['nipppk'] = $nip;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'pppk/detail';
      $this->load->view('template', $data);
    }
  }
  
  // tambah data pppk
  function add()
  {
    //cek priviledge session user -- edit_profil_priv
    //if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
    if ($this->session->userdata('level') == "ADMIN") {
    	$data['keldes'] = $this->mnonpns->kelurahan()->result_array();
    	$data['agama'] = $this->mnonpns->agama()->result_array();
      $data['tingpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['statkaw'] = $this->mpegawai->status_kawin()->result_array();
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['jab'] = $this->mpppk->jabatan()->result_array();
      $data['golrupppk'] = $this->mpppk->golru()->result_array();
      $data['ptkp'] = $this->mpppk->status_ptkp()->result_array();
      $data['content'] = 'pppk/addpppk';
      $this->load->view('template', $data);
    }
  }
  
  
  // untuk halaman edit pppk
  function edit() {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nip = $this->input->post('nipppk');
      $data['detail'] = $this->mpppk->detail($nip)->result_array();
      $data['keldes'] = $this->mnonpns->kelurahan()->result_array();
      $data['agama'] = $this->mnonpns->agama()->result_array();
      $data['tingpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['statkaw'] = $this->mpegawai->status_kawin()->result_array();
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['jab'] = $this->mpppk->jabatan()->result_array();
      $data['golrupppk'] = $this->mpppk->golru()->result_array();
      $data['ptkp'] = $this->mpppk->status_ptkp()->result_array();
      $data['content'] = 'pppk/edit';
      $this->load->view('template', $data);
    }
  }
  
  // aksi edit pppk
  function edit_aksi() {
    $p = $_POST;
  	$nip = $p['nipppk'];
  	$data = [
  		'nipppk' => $nip,
  		'nama' => $p['nama'],
  		'gelar_depan' => $p['gelar_depan'],
  		'gelar_blk' => $p['gelar_blk'],
  		'tmp_lahir' => $p['tmp_lahir'],
  		'tgl_lahir' => tgl_sql($p['tgl_lahir']),
  		'alamat' => $p['alamat'],
  		'no_npwp' => $p['no_npwp'],
  		'fid_keldesa' => $p['fid_keldesa'],
  		'jns_kelamin' => $p['jns_kelamin'],
  		'fid_agama' => $p['fid_agama'],
  		'fid_tingkat_pendidikan' => $p['fid_tingkat_pendidikan'],
  		'fid_jurusan_pendidikan' => $p['fid_jurusan_pendidikan'],
  		'nama_sekolah' => $p['nama_sekolah'],
  		'tahun_lulus' => $p['tahun_lulus'],
  		'fid_status_kawin' => $p['fid_status_kawin'],
  		'fid_status_ptkp' => $p['fid_status_ptkp'],
  		'fid_unit_kerja' => $p['fid_unit_kerja'],
  		'fid_jabft' => $p['fid_jabft'],
  		'tmt_jabft' => tgl_sql($p['tmt_jabft']),
  		'fid_golru_pppk' => $p['fid_golru_pppk'],
  		'tmt_golru_pppk' => tgl_sql($p['tmt_golru_pppk']),
  		'maker_tahun' => $p['maker_tahun'],
  		'maker_bulan' => $p['maker_bulan'],
  		'tmt_pppk' => tgl_sql($p['tmt_pppk']),
  		'gaji_pokok' => $p['gaji_pokok'],
  		'nomor_sk' => $p['nomor_sk'],
  		'pejabat_sk' => $p['pejabat_sk'],
  		'tpp' => $p['tpp'],
  		'tgl_sk' => tgl_sql($p['tgl_sk']),
  		'updated_at' => date('Y-m-d H:i:s'),
  		'updated_by' => $this->session->userdata('nip')
  	];
  	
    $whr = ['nipppk' => $nip];
    
    $db = $this->mpppk->edit_pppk($whr, $data);
  	if($db) {
      $data['pesan'] = '<b>Sukses</b>, Data PPPK A.n. <u>'.$p['nama'].'</u> berhasil dirobah.';
      $data['jnspesan'] = 'alert alert-success';
  	}	else {
  		$data['pesan'] = '<b>Gagal !</b>, Data PPPK A.n. <u>'.$p['nama'].'</u> gagal dirobah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
  	}
  	
    $data['detail'] = $this->mpppk->detail($nip)->result_array();
    $data['nipppk'] = $nip;
  	
  	$data['content'] = 'pppk/detail';
    $this->load->view('template', $data);
  }
  
  public function add_aksi()
  {
  	$p = $_POST;
  	$data = [
  		'nipppk' => $p['nipppk'],
  		'nama' => $p['nama'],
  		'gelar_depan' => $p['gelar_depan'],
  		'gelar_blk' => $p['gelar_blk'],
  		'tmp_lahir' => $p['tmp_lahir'],
  		'tgl_lahir' => tgl_sql($p['tgl_lahir']),
  		'alamat' => $p['alamat'],
  		'no_npwp' => $p['no_npwp'],
  		'fid_keldesa' => $p['idkel'],
  		'jns_kelamin' => $p['jns_kelamin'],
  		'fid_agama' => $p['fid_agama'],
  		'fid_tingkat_pendidikan' => $p['fid_tingkat_pendidikan'],
  		'fid_jurusan_pendidikan' => $p['fid_jurusan_pendidikan'],
  		'nama_sekolah' => $p['nama_sekolah'],
  		'tahun_lulus' => $p['tahun_lulus'],
  		'fid_status_kawin' => $p['fid_status_kawin'],
  		'fid_status_ptkp' => $p['fid_status_ptkp'],
  		'fid_unit_kerja' => $p['fid_unit_kerja'],
  		'fid_jabft' => $p['fid_jabft'],
  		'tmt_jabft' => tgl_sql($p['tmt_jabft']),
  		'fid_golru_pppk' => $p['fid_golru_pppk'],
  		'tmt_golru_pppk' => tgl_sql($p['tmt_golru_pppk']),
  		'maker_tahun' => $p['maker_tahun'],
  		'maker_bulan' => $p['maker_bulan'],
  		'tmt_pppk' => tgl_sql($p['tmt_pppk']),
  		'gaji_pokok' => $p['gapok'],
  		'nomor_sk' => $p['no_sk'],
  		'pejabat_sk' => $p['pejabat_sk'],
  		'tpp' => $p['tpp'],
  		'tgl_sk' => tgl_sql($p['tgl_sk']),
  		'created_at' => date('Y-m-d H:i:s'),
  		'created_by' => $this->session->userdata('nip')
  	];
  	$db = $this->mpppk->insert_pppk($data);
  	if($db) {
      $data['pesan'] = '<b>Sukses</b>, Data PPPK A.n. <u>'.$p['nama'].'</u> berhasil ditambah.';
      $data['jnspesan'] = 'alert alert-success';
  	}	else {
  		$data['pesan'] = '<b>Gagal !</b>, Data PPPK A.n. <u>'.$p['nama'].'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
  	}
    
    $data['unker'] = $this->munker->dd_unker()->result_array();  
  	$data['content'] = 'pppk/tampilunker';
    $this->load->view('template',$data);
  }
  
  
  // untuk ajax jurusan pendidikan pada form add
  function showjurpen()
  {
    $idtp = $this->input->get('idtp');
    $jurpen = $this->mnonpns->jurpen($idtp)->result_array();
    ?>
    <table class="table table-condensed">
      <tr>
        <td width='100' bgcolor='#D9EDF7' align='right'><b>Jurusan</b></td>
        <td>
          <select name='fid_jurusan_pendidikan' id='fid_jurusan_pendidikan' required>
          <option value=''>-- Pilih Jurusan --</option>
          <?php
          foreach($jurpen as $jp) {              
            echo "<option value='".$jp['id_jurusan_pendidikan']."'>".$jp['nama_jurusan_pendidikan']."</option>";
          }
          ?>
          </select>
        </td>
      </tr>
      <tr>
        <td width='100' bgcolor='#D9EDF7' align='right'><b>Nama Sekolah</b></td>
        <td><input type="text" name="nama_sekolah" size='75' maxlength='100' required /></td>
      </tr>
      <tr>
        <td bgcolor='#D9EDF7' align='right'><b>Tahun Lulus</b></td>
        <td><input type="text" name="tahun_lulus" size='6' maxlength='4' required /></td>
      </tr>
      <tr><td colspan='2'></td></tr>
    </table>
    <?php
  }

  // untuk ajax kecamatan pada form add
  function showKecamatan()
  {
    $idkel = $this->input->get('idkel');
    $kecamatan = $this->mpegawai->getkecamatan($idkel);
    if ($kecamatan != "LUAR BALANGAN") {      
      echo '<b>Kec. '.$kecamatan.'</b>';
    }     
  }
  
  // untuk ajax tampil per unker
  function tampilperunker() {
    $idunker = $this->input->get('idunker');

    if ($idunker) {
      $sqlcari = $this->mpppk->p3kperunker($idunker)->result_array();
      $nmunker = $this->munker->getnamaunker($idunker);
      $jmlnonpns = $this->mpppk->getjmlperunker($idunker);

      if ($jmlnonpns == 0) {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";        
        echo "Data PPPK tidak ditemukan pada ".$nmunker;
        echo "</div>";
      } else {
        echo "<div class='panel panel-default' style='width: 80%'>";        
        echo "<div class='panel-body'>";

        // mencari apakah ada data yang belum memiliki file photo
        $jmlphoto = 0;
        foreach($sqlcari as $v):          
          $lokasiphoto='./photononpns/';
          $filephoto=$v['photo'];
          if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
            $jmlphoto++;
          }        
        endforeach;      

        echo "<div class='panel panel-success'>";
        echo "<div class='panel-heading' align='left'><b>$nmunker</b><br />";
        echo "Jumlah PPPK : ".$jmlnonpns." orang";
        echo "</div>";
        echo "<div style='padding:0px;overflow:auto;width:99%;height:280px;border:1px solid white' >";

        echo "<table class='table table-condensed'>";
        echo "<tr>
          <td align='center'><b>No</b></td>
          <td align='center' colspan='2' width='230'><b>NIP PPPK<br/><u>NAMA</u></b><br/><i>Tgl. Lahir</i></td>
          <td align='center'><b><u>Golongan Ruang</u></b><br/><i>TMT Golru</i></td>
          <td align='center'><b>Jabatan<br/>Unit Kerja</b></td>
          <td align='center' colspan='3'><b>Aksi</b></td>";
        echo "</tr>";    
        
        $no = 1;
        foreach($sqlcari as $v):          
          ?>
          <tr>
          <td width='10' align='center'><?php echo $no.'.'; ?></td>
          <td>
            <?php echo $v['nipppk']; ?><br />
            <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk']); ?><br/>
            <i><?php echo tgl_indo($v['tgl_lahir']); ?></i> <br>
            <b style="color: #fff"><?= $v['pppk_id'] ?></b>
          </td>
          <td align='center' width='50'>         

          <?php        
          $lokasiphoto='./photononpns/';
          $filephoto=$v['photo'];

          if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
            echo "<img src='../photononpns/$filephoto' width='48' height='64' alt='$v[nipppk].jpg'";
          } else {
            echo "<img src='../photononpns/nophoto.jpg' height='64' alt='no image'";
          }
          ?>
          </td>
          <td width='140' align='center'>
            (<b><?php echo $v['nama_golru']; ?></b>)
            <u><?php //echo $this->mnonpns->getsumbergaji($v['fid_sumbergaji']); ?></u><br />
            <i><?php echo tgl_indo($v['tmt_golru_pppk']); ?></i>
          </td>

          <td>
            <?php echo $v['nama_jabft'];?><br />
            <?php echo $v['nama_unit_kerja'];?>        
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../pppk/detail'>";          
            echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$v[nipppk]'>";
            ?>
            <button type="submit" class="btn btn-success btn-xs ">
            <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span>
            <br /> Detail
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
          <?php 
          	if($this->session->userdata('level') === 'ADMIN'):
          ?>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../pppk/hapuspppk'>";          
            echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$v[nipppk]'>";
            ?>
            <button type="submit" class="btn btn-danger btn-xs " disabled>
            <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
            <br /> Hapus
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
          <?php endif; ?>
        </tr>
        <?php
          $no++;
        endforeach;
        echo "</div>"; // div scrolbar
        echo "</div>"; // div panel-info
        echo "</div>"; // div body
        echo "</div>"; // div panel
      }
    } else {
      echo "<div class='alert alert-info' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";        
        echo "Silahkan pilih unit kerja.";
        echo "</div>";
    }
  }
  function hapuspppk(){
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nip = addslashes($this->input->post('nipppk'));
      $nama = $this->mpppk->getnama($nip);

      $where = array('nipppk' => $nip);

      $filephoto=$this->mpppk->getphoto($nip);          
        if (file_exists('./photononpns/'.$filephoto)) {
          unlink('./photononpns/'.$filephoto);
        }

      if ($this->mpppk->hapus_pppk($where)) {        
        $data['pesan'] = '<b>Sukses !</b>, Data PPPK A.n. <u>'.$nama.'</u> berhasil dihapus.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Data PPPK A.n. <u>'.$nama.'</u> gagal dihapus.';
        $data['jnspesan'] = 'alert alert-danger';
      }

      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'pppk/tampilunker';
      $this->load->view('template',$data);
    }
  }

  function rwygaji()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") {
      $nipppk = $this->input->post('nipppk');
      $data['rwygaji'] = $this->mpppk->rwygaji($nipppk)->result_array();
      $data['nipppk'] = $nipppk;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'pppk/rwygaji';
      $this->load->view('template', $data);
    }
  }
}
