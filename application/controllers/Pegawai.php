<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');        
      $this->load->helper('fungsiwsbkn');  
      $this->load->helper('fungsiftp');
      $this->load->helper('blob');	
      $this->load->helper('fungsiterbilang');	
      $this->load->model('mpegawai');
      $this->load->model('mstatistik');
      $this->load->model('mkinerja');
      $this->load->model('munker');
      $this->load->model('mcuti'); // untuk riwayat cuti
      $this->load->model('datacetak');
      $this->load->model('mpip');
      $this->load->model('mwsbkn');
      $this->load->model('mskp');      

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // untuk fpdf
      $this->load->library('fpdf');

      $this->load->library('ftp');
   }

  public function cetakdtlpeg()  
  {
    $res['data'] = $this->datacetak->dataprofpeg();
    $this->load->view('cetakdtlpeg',$res);
  }

	public function index()
	{	  
	}

  function detail()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $data['peg'] = $this->mpegawai->detail($nip)->result_array();
      $data['rwyvaksin'] = $this->mpegawai->rwyvaksin($nip)->result_array();
      $data['content'] = 'pegdetail';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  // UNTUK LOGIN PNS
  function detail_dataku()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $nip = $this->session->userdata('nip');
      $data['peg'] = $this->mpegawai->detail($nip)->result_array();
      $data['rwyvaksin'] = $this->mpegawai->rwyvaksin($nip)->result_array();
      $data['content'] = 'pegdetail';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function rwycp()
  {
    //$nip = $this->input->get('nip');
    $nip 		 	 = $this->input->post('nip');
    $data['peg'] 	 = $this->mpegawai->rwycp($nip)->result_array();    
    $data['content'] = 'rwycp';
    $this->load->view('template', $data);
  }

  function rwydik()
  {    
    $nip = $this->input->post('nip');
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();
    //untuk jenis diklat struktural
    $data['jenis_dik_jst'] = $this->mpegawai->jenis_dik_jst()->result();

    $data['nip'] = $nip;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }
  
  public function entri_dik_aksi() 
  {
  	$p = $this->input->post();
  	$nama = $this->mpegawai->getnama($p['nip']);

  	$t = 'riwayat_diklat_struktural';
  	$i = [
  		'nip' => $p['nip'],
  		'fid_diklat_struktural' => $p['jenis_diklat'],
  		'instansi_penyelenggara' => $p['intansi_penyelenggara'],
  		'tempat' => $p['tempat_pelaksanaan'],
  		'tahun' => $p['tahun_pelaksanaan'],
  		'lama_bulan' => !empty($p['bulan']) ? $p['bulan'] : 0,
  		'lama_hari' => !empty($p['hari']) ? $p['hari'] : 0,
  		'lama_jam' => !empty($p['jam']) ? $p['jam'] : 0,
  		'pejabat_sk' => $p['pejabat'],
  		'no_sk' => $p['nomor'],
  		'tgl_sk' => $p['tgl'],
  		'created_at' => date('Y-m-d H:i:s'),
  		'created_by' => $this->session->userdata('nip')
  	];
  	if($p != null) 
  	{
  		$db = $this->mpegawai->insert_table($t, $i);
  		if($db)
  		{
  			// callback pesan, true
  			$data['pesan'] = '<b>Sukses</b>, Riwayat Diklat Struktural PNS <u>'.$nama.'</u> berhasil ditambahkan.';
      	$data['jnspesan'] = 'alert alert-success';
  		} else {
  			// callback pesan, true
  			$data['pesan'] = '<b>Gagal</b>, Riwayat Diklat Struktural PNS <u>'.$nama.'</u> gagal ditambahkan.';
      	$data['jnspesan'] = 'alert alert-danger';
  		}
  	}
  	
  	$this->rwydik();
  	
  }
  
  public function editrwydik()
  {
  
  	$t = 'riwayat_diklat_struktural';
  	$nip = $this->input->post('nip');
  	$id  = $this->input->post('id');
  	$db = $this->mpegawai->select_table($t, ['id' => $id])->row();
  	
  	$data = [
  		'row' => $db,
  		'nip' => $nip,
  		'id' => $id,
  		'jenis_dik_jst' => $this->mpegawai->jenis_dik_jst()->result(),
  		'content' => 'rwydik_edit'
  	];
  	$this->load->view('template', $data);
  	
  }
  
  public function edit_dik_aksi() {
  	$p = $this->input->post();
  	$id = $p['id'];
  	$nip = $p['nip'];
  	
	$t = 'riwayat_diklat_struktural';
  	$nama = $this->mpegawai->getnama($nip);
  	
  	// data untuk update table riwayat_pendidikan
  	$i = [
  		'nip' => $p['nip'],
  		'fid_diklat_struktural' => $p['jenis_diklat'],
  		'instansi_penyelenggara' => $p['intansi_penyelenggara'],
  		'tempat' => $p['tempat_pelaksanaan'],
  		'tahun' => $p['tahun_pelaksanaan'],
  		'lama_bulan' => !empty($p['bulan']) ? $p['bulan'] : 0,
  		'lama_hari' => !empty($p['hari']) ? $p['hari'] : 0,
  		'lama_jam' => !empty($p['jam']) ? $p['jam'] : 0,
  		'pejabat_sk' => $p['pejabat'],
  		'no_sk' => $p['nomor'],
  		'tgl_sk' => $p['tgl'],
		'updated_at' => date('Y-m-d H:i:s'),
		'updated_by' => $this->session->userdata('nip')
  	];
  	
  	if($nip != '') {
  		$up = $this->mpegawai->update_table($t, $i, ['id' => $id]);
  		if($up) {
			// callback pesan, true
  			$data['pesan'] = '<b>Sukses</b>, Riwayat Diklat PNS <u>'.$nama.'</u> berhasil diupdate.';
      	$data['jnspesan'] = 'alert alert-success';
  		} else {
  		
  			// callback pesan, false
  			$data['pesan'] = '<b>Gagal</b>, Riwayat Diklat PNS <u>'.$nama.'</u> gagal diupdate.';
      	$data['jnspesan'] = 'alert alert-danger';
  		}
  	}
	$this->rwydik();  	
  }

  public function hapusrwydik_aksi()
  {
  	$nip = $this->input->post('nip');
  	$id  = $this->input->post('id');

  	$tbl = 'riwayat_diklat_struktural';
  	
  	$nama = $this->mpegawai->getnama($nip);
  
  	// jika nip ada	
  	if($nip != '') {
  		// hapus riwayat pendidikan berdasarkan id
  		$del = $this->mpegawai->delete_table($tbl, ['id' => $id]);
  		// jika hapus pada database, true
  		if($del) {
			// callback pesan, true
  			$data['pesan'] = '<b>Sukses</b>, Riwayat Diklat PNS <u>'.$nama.'</u> berhasil dihapus.';
      	$data['jnspesan'] = 'alert alert-success';

  		} else {
  			// callback pesan, false
  			$data['pesan'] = '<b>Gagal</b>, Riwayat Diklat PNS <u>'.$nama.'</u> gagal dihapus.';
      	$data['jnspesan'] = 'alert alert-danger';
  		}
  	}
  	
  	$this->rwydik();
  }


  function rwykp()
  {    
    $nip = $this->input->post('nip');
    $data['pegrwykp'] = $this->mpegawai->rwykp($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykp';
    $this->load->view('template', $data);
  }

  function rwykgb()
  {    
    $nip = $this->input->post('nip');
    $data['pegrwykgb'] = $this->mpegawai->rwykgb($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykgb';
    $this->load->view('template', $data);
  }

  function tambah_rwy_kgb_terakhir() { 
    $nip = $this->input->post('nip');
    $data['nip'] = $nip;
    $data['content'] = 'form_rwyt_kgb';
    $this->load->view('template', $data);
  } 
  
  function tambah_rwy_kgb_aksi() {
  	$nip = $this->input->post('nip');
  	$golru = $this->input->post('golru');
  	$gapok = $this->input->post('gapok');
  	$mk_tahun = $this->input->post('mk_tahun');
  	$mk_bulan = $this->input->post('mk_bulan');
  	$tmt = $this->input->post('tmt');
  	$pejabat_sk = $this->input->post('pejabat_sk');
  	$nomor_sk = $this->input->post('no_sk');
  	$tgl_sk = $this->input->post('tgl_sk');
  	
  	$nama = $this->mpegawai->getnama($nip);
  	
  	$data_req = array(
  		'nip' => $nip,
  		'fid_golru' => $golru,
  		'gapok' => $gapok,
  		'mk_thn' => $mk_tahun,
  		'mk_bln' => $mk_bulan,
  		'tmt' => $tmt,
  		'pejabat_sk' => $pejabat_sk,
  		'no_sk' => $nomor_sk,
  		'tgl_sk' => $tgl_sk,
  		'created_at' => date('Y-m-d H:i:s'),
  		'created_by' => $this->session->userdata('nama')
  	);
  	
  	$send = $this->mpegawai->simpan_rwy_kgb_terakhir('riwayat_kgb', $data_req);
  	
  	if($send) {
  		$data['pesan'] = '<b>Sukses</b>, Riwayat KGB PNS <u>'.$nama.'</u> berhasil ditambahkan.';
      $data['jnspesan'] = 'alert alert-success';
  	} else {
  		$data['pesan'] = '<b>Gagal</b>, Riwayat KGB PNS <u>'.$nama.'</u> Gagal ditambahkan.';
      $data['jnspesan'] = 'alert alert-danger';
  	}
  	
  	$data['pegrwykgb'] = $this->mpegawai->rwykgb($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykgb';
    $this->load->view('template', $data);
  }
	
	function edit_rwy_kgb() {
		$id = $this->input->post('id');
		$nip = $this->input->post('nip');
		
		$data['editriwayatkgb'] = $this->mpegawai->editrwykgb($nip, $id)->result();
    $data['nip'] = $nip;
    $data['id'] = $id;
    $data['content'] = 'edit_rwykgb';
    $this->load->view('template', $data);
		
	}
	
	function update_rwy_kgb_aksi() {
		$id = $this->input->post('id');
		$nip = $this->input->post('nip');
		
		$golru = $this->input->post('golru');
  	$gapok = $this->input->post('gapok');
  	$mk_tahun = $this->input->post('mk_tahun');
  	$mk_bulan = $this->input->post('mk_bulan');
  	$tmt = $this->input->post('tmt');
  	$pejabat_sk = $this->input->post('pejabat_sk');
  	$nomor_sk = $this->input->post('no_sk');
  	$tgl_sk = $this->input->post('tgl_sk');
  	
  	$nama = $this->mpegawai->getnama($nip);
  	
  	$data_req = array(
  		'fid_golru' => $golru,
  		'gapok' => $gapok,
  		'mk_thn' => $mk_tahun,
  		'mk_bln' => $mk_bulan,
  		'tmt' => $tmt,
  		'pejabat_sk' => $pejabat_sk,
  		'no_sk' => $nomor_sk,
  		'tgl_sk' => $tgl_sk
  	);
  	
  	$whr  = array(
  		'id' => $id,
  		'nip' => $nip
  	);
  	
  	$send = $this->mpegawai->update_rwy_kgb_aksi('riwayat_kgb', $data_req, $whr);
  	if($send) {
  		$data['pesan'] = '<b>Sukses</b>, Riwayat KGB PNS <u>'.$nama.'</u> berhasil diupdate.';
      $data['jnspesan'] = 'alert alert-success';
  	} else {
  		$data['pesan'] = '<b>Gagal</b>, Riwayat KGB PNS <u>'.$nama.'</u> Gagal diupdate.';
      $data['jnspesan'] = 'alert alert-danger';
  	}
  	
  	$data['pegrwykgb'] = $this->mpegawai->rwykgb($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykgb';
    $this->load->view('template', $data);
	}
	
  function rwypdk()
  {    
    $nip = $this->input->post('nip');
    $data['pegrwypdk'] = $this->mpegawai->rwypdk($nip)->result_array();
    $data['ref_tingkat_pendidikan'] = $this->mpegawai->ref_tingkat_pendidikan()->result();
    $data['nip'] = $nip;
    $data['content'] = 'rwypdk';
    $this->load->view('template', $data);
  }
  
  public function list_jurusan_pendidikan() {
  	$id = $this->input->get('id');
  	$id_jp = $this->input->get('id_jurpen');
  	$db = $this->mpegawai->ref_jurusan_pendidikan($id)->result();
  	$sel = "";
  	foreach($db as $jp) {
  		$current = $id_jp === $jp->id_jurusan_pendidikan ? 'selected' : '';	
  		$sel .= "<option value='".$jp->id_jurusan_pendidikan."' ".$current.">".$jp->nama_jurusan_pendidikan."</option>";
  	}
  	echo json_encode($sel);
  }
	
  public function entri_pdk_aksi() {
  	
  	// ambil semua inputan, ubah dalam bentuk array
  	$p = $this->input->post();
  	
  	$tbl_pegawai = 'pegawai';
  	$tbl_riwayat = 'riwayat_pendidikan';
  	
  	$nama = $this->mpegawai->getnama($p['nip']);
  	
  	// data untuk table riwayat_pendidikan, menambahkan riwayat terakhir
  	$data_riwayat = [
  		'nip' => $p['nip'],
  		'fid_tingkat' => $p['tp'],
  		'fid_jurusan' => $p['jp'],
  		'thn_lulus' => $p['tahun_lulus'],
  		'nama_sekolah' => $p['nama_sekolah'],
  		'nama_kepsek' => $p['nama_kepsek'],
  		'no_sttb' => $p['no_sttb'],
  		'tgl_sttb' => $p['tgl_sttb'],
  		'gelar_dpn' => $p['gd'],
  		'gelar_blk' => $p['gb'],
		'created_at' => date('Y-m-d H:i:s'),
		'created_by' => $this->session->userdata('nip')
  	];
  	
  	// data untuk mengupdate pada table pegawai
  	$data_pegawai = [
  		'gelar_depan' => $p['gd'],
  		'gelar_belakang' => $p['gb'],
  		'fid_tingkat_pendidikan' => $p['tp'],
  		'fid_jurusan_pendidikan' => $p['jp'],
  		'tahun_lulus' => $p['tahun_lulus']
  	];
  	
  	// jika nip tidak, null
  	if($p['nip'] != '') {
  		// simpan ke database pada table riwayat_pendidikan
  		$db = $this->mpegawai->insert_table($tbl_riwayat, $data_riwayat);
  		// jika simpan ke database, true
  		if($db) {
  			// update pada table pegawai berdasarkan nip
  			$this->mpegawai->update_table($tbl_pegawai, $data_pegawai, ['nip' => $p['nip']]);
  			
  			// callback pesan, true
  			$data['pesan'] = '<b>Sukses</b>, Riwayat Pendidikan PNS <u>'.$nama.'</u> berhasil diupdate & ditambahkan.';
      	$data['jnspesan'] = 'alert alert-success';
  			
  		} else {
  			// callback pesan, false
  			$data['pesan'] = '<b>Gagal</b>, Riwayat Pendidikan PNS <u>'.$nama.'</u> gagal update.';
      	$data['jnspesan'] = 'alert alert-danger';
  		} 
  		
  	}
  	
  	 $nip = $p['nip'];
    $data['pegrwypdk'] = $this->mpegawai->rwypdk($nip)->result_array();
    $data['ref_tingkat_pendidikan'] = $this->mpegawai->ref_tingkat_pendidikan()->result();
    $data['nip'] = $nip;
    $data['content'] = 'rwypdk';
    $this->load->view('template', $data);
  	 //echo json_encode($p);
  }
  
  public function hapusrwypdk_aksi()
  {
  	$nip = $this->input->post('nip');
  	$id  = $this->input->post('id');

  	$tbl_pegawai = 'pegawai';
  	$tbl_riwayat = 'riwayat_pendidikan';
  	
  	$nama = $this->mpegawai->getnama($nip);
  
  	// jika nip ada	
  	if($nip != '') {
  		// hapus riwayat pendidikan berdasarkan id
  		$del = $this->mpegawai->delete_table($tbl_riwayat, ['id' => $id]);
  		// jika hapus pada database, true
  		if($del) {
  			// ambil 1 data riwayat pendidikan terakhir
  			$rywpdk_last = $this->mpegawai->rwypdk($nip)->row();
		  	$data_pegawai = [
		  		'gelar_depan' => $rywpdk_last->gelar_dpn,
		  		'gelar_belakang' => $rywpdk_last->gelar_blk,
		  		'fid_tingkat_pendidikan' => $rywpdk_last->fid_tingkat,
		  		'fid_jurusan_pendidikan' => $rywpdk_last->fid_jurusan,
		  		'tahun_lulus' => $rywpdk_last->thn_lulus
		  	];
		  	
		  	// jika berhasil dihapus update tabel pegawai sesuai pendidikan yang terakhir berdasarkan nip
		  	$this->mpegawai->update_table($tbl_pegawai, $data_pegawai, ['nip' => $nip]);
  			
			// callback pesan, true
  			$data['pesan'] = '<b>Sukses</b>, Riwayat Pendidikan PNS <u>'.$nama.'</u> berhasil dihapus.';
      	$data['jnspesan'] = 'alert alert-success';

  		} else {
  			// callback pesan, false
  			$data['pesan'] = '<b>Gagal</b>, Riwayat Pendidikan PNS <u>'.$nama.'</u> gagal dihapus.';
      	$data['jnspesan'] = 'alert alert-danger';
  		}
  	}
  	
    $data['pegrwypdk'] = $this->mpegawai->rwypdk($nip)->result_array();
    $data['ref_tingkat_pendidikan'] = $this->mpegawai->ref_tingkat_pendidikan()->result();
    $data['nip'] = $nip;
    $data['content'] = 'rwypdk';
    $this->load->view('template', $data);
    
  	//echo json_encode($id);
  }
  
  public function editrwypdk()
  {
  	$nip = $this->input->post('nip');
  	$id  = $this->input->post('id');
  	$db = $this->mpegawai->select_table('riwayat_pendidikan', ['id' => $id])->row();
  	
  	$data = [
  		'row' => $db,
  		'nip' => $nip,
  		'id' => $id,
  		'tingpen' => $this->mpegawai->ref_tingkat_pendidikan()->result(),
  		'content' => 'rwypdk_edit'
  	];
  	$this->load->view('template', $data);
  	//echo json_encode($db);
  }
  
  public function edit_pdk_aksi() {
  	$p = $this->input->post();
  	$id = $p['id'];
  	$nip = $p['nip'];

  	$nama = $this->mpegawai->getnama($nip);
  	
  	// data untuk update table riwayat_pendidikan
  	$data_riwayat = [
  		'fid_tingkat' => $p['tp'],
  		'fid_jurusan' => $p['jp'],
  		'thn_lulus' => $p['tahun_lulus'],
  		'nama_sekolah' => $p['nama_sekolah'],
  		'nama_kepsek' => $p['nama_kepsek'],
  		'no_sttb' => $p['no_sttb'],
  		'tgl_sttb' => $p['tgl_sttb'],
  		'gelar_dpn' => $p['gd'],
  		'gelar_blk' => $p['gb'],
		'updated_at' => date('Y-m-d H:i:s'),
		'updated_by' => $this->session->userdata('nip')
  	];
  	
  	// data untuk mengupdate pada table pegawai
  	$data_pegawai = [
  		'gelar_depan' => $p['gd'],
  		'gelar_belakang' => $p['gb'],
  		'fid_tingkat_pendidikan' => $p['tp'],
  		'fid_jurusan_pendidikan' => $p['jp'],
  		'tahun_lulus' => $p['tahun_lulus']
  	];
  	
  	if($nip != '') {
  		$up = $this->mpegawai->update_table('riwayat_pendidikan', $data_riwayat, ['id' => $id]);
  		if($up) {
  			$this->mpegawai->update_table('pegawai', $data_pegawai, ['nip' => $nip]);
			// callback pesan, true
  			$data['pesan'] = '<b>Sukses</b>, Riwayat Pendidikan PNS <u>'.$nama.'</u> berhasil diupdate.';
      	$data['jnspesan'] = 'alert alert-success';
  		} else {
  		
  			// callback pesan, false
  			$data['pesan'] = '<b>Gagal</b>, Riwayat Pendidikan PNS <u>'.$nama.'</u> gagal diupdate.';
      	$data['jnspesan'] = 'alert alert-danger';
  		}
  	}
    $data['pegrwypdk'] = $this->mpegawai->rwypdk($nip)->result_array();
    $data['ref_tingkat_pendidikan'] = $this->mpegawai->ref_tingkat_pendidikan()->result();
    $data['nip'] = $nip;
    $data['content'] = 'rwypdk';
    $this->load->view('template', $data);

    //echo json_encode($p);
  	
  }
  
  function rwykel()
  {    
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();       
    //untuk anak
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();       
    $data['nip'] = $nip;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function rwyph()
  {    
    $nip = $this->input->post('nip');    
    $data['pegrwyph'] = $this->mpegawai->rwyph($nip)->result_array();       
    $data['nip'] = $nip;
    $data['content'] = 'rwyph';
    $this->load->view('template', $data);
  }

  function rwyjab()
  {    
    $nip = $this->input->post('nip');    
    $data['pegrwyjab'] 	 = $this->mpegawai->rwyjab($nip)->result_array();  
    $data['pegrwyplt'] 	 = $this->mpegawai->rwyplt($nip)->result_array(); 
    $data['pegrwypokja'] = $this->mpegawai->rwypokja($nip)->result_array();      
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data);
  }

  // untuk riwayat skp  
  function rwyskp()
  {    
    $nip = $this->input->post('nip');    
    $data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
    $data['nip'] = $nip;
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
    $data['content'] = 'rwyskp';
    $this->load->view('template', $data);
  }

  // untuk riwayat cuti
  function rwycuti()
  {    
    $nip = $this->input->post('nip');    
    $data['pegrwycuti'] = $this->mpegawai->rwycuti($nip)->result_array();     
    $data['pegrwycutitunda'] = $this->mpegawai->rwycutitunda($nip)->result_array();         
    $data['nip'] = $nip;
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
    $data['content'] = 'rwycuti';
    $this->load->view('template', $data);
  }

  function dtlskp()
  {    
    $nip = $this->input->post('nip');    
    $thn = $this->input->post('thn');    
    $data['pegdtlskp'] = $this->mpegawai->dtlskp($nip, $thn)->result_array();
    $data['nip'] = $nip;
    $data['thn'] = $thn;
    $data['content'] = 'dtlskp';
    $this->load->view('template', $data);
  }
  
  function carinipnama()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $datacnp['content'] = 'carinipnama';
      $this->load->view('template',$datacnp);
    }
  }
	

  public function show_autocomplete() {
  $query = $this->input->post('q');
  $data = $this->mpegawai->getnipnama($query)->result_array();
  echo json_encode(["items" => $data, "inputPhrase"=> "eac"]);
  }
  function tampilnipnama()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $data = mysql_real_escape_string(trim($this->input->post('data')));
    	if ($data != '') {
    		// nip dan nama akan dicari pada instansi sesuai kewenangan user yang login
    		$datatnp['pegtnp'] = $this->mpegawai->getnipnama($data)->result_array();
    		$datatnp['jmldata'] = count($this->mpegawai->getnipnama($data)->result_array());
    		$datatnp['content'] = 'tampilnipnama';
    	      	$this->load->view('template', $datatnp);
    	} else {
    		$this->session->set_flashdata('pesan', '<b>Pencarian data gagal</b><br />Ketik NIP atau Nama terlebih dahulu');
    		redirect('pegawai/carinipnama');
    	}
    }
  }

  function tampilunkernom()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'tampilunkernom';
      $this->load->view('template',$data);
    }
  }

  function nomperunker()
  { 
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $id = $this->input->post('id_unker');
      $data['peg'] = $this->munker->nomperunker($id)->result_array();
      $data['idunker'] = $id;
      $data['nmunker'] = $this->munker->getnamaunker($id);
      $data['jmlpeg'] = $this->munker->getjmlpeg($id);
      $data['content'] = 'nomperunker';
      $this->load->view('template',$data);
    }
  }

  public function cetaknomperunker()  
  {
    $id = $this->input->post('id');
    $res['data'] = $this->datacetak->datanomperunker();
    //$res['idunker'] = $id;
    //$res['nmunker'] = $this->munker->getnamaunker($id);    
    $this->load->view('cetaknomperunker',$res);    
  }

  function tampilunkerstat()
  {
    //cek priviledge session user -- statistik_priv
    if ($this->session->userdata('statistik_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'tampilunkerstat';
      $this->load->view('template',$data);
    }    
  }

  function statperunker()
  {
    $id = $this->input->post('id_unker');
    // untuk cpns
    $data['stcpns'] = $this->mstatistik->unker_statpeg($id, 'CPNS');
    $data['stcpns1a'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'I/A');
    $data['stcpns1b'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'I/B');
    $data['stcpns1c'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'I/C');
    $data['stcpns1d'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'I/D');
    $data['stcpns2a'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'II/A');
    $data['stcpns2b'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'II/B');
    $data['stcpns2c'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'II/C');
    $data['stcpns2d'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'II/D');
    $data['stcpns3a'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'III/A');
    $data['stcpns3b'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'III/B');
    $data['stcpns3c'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'III/C');
    $data['stcpns3d'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'III/D');
    $data['stcpns4a'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'IV/A');
    $data['stcpns4b'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'IV/B');
    $data['stcpns4c'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'IV/C');
    $data['stcpns4d'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'IV/D');
    $data['stcpns4e'] = $this->mstatistik->unker_statpeg_golru($id, 'CPNS', 'IV/E');
    // untuk pns
    $data['stpns'] = $this->mstatistik->unker_statpeg($id, 'PNS');       
    $data['stpns1a'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'I/A');
    $data['stpns1b'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'I/B');
    $data['stpns1c'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'I/C');
    $data['stpns1d'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'I/D');
    $data['stpns2a'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'II/A');
    $data['stpns2b'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'II/B');
    $data['stpns2c'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'II/C');
    $data['stpns2d'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'II/D');
    $data['stpns3a'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'III/A');
    $data['stpns3b'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'III/B');
    $data['stpns3c'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'III/C');
    $data['stpns3d'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'III/D');
    $data['stpns4a'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'IV/A');
    $data['stpns4b'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'IV/B');
    $data['stpns4c'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'IV/C');
    $data['stpns4d'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'IV/D');
    $data['stpns4e'] = $this->mstatistik->unker_statpeg_golru($id, 'PNS', 'IV/E');

    // untuk eselon
    $data['esl2a'] = $this->mstatistik->unker_esl($id, 'II/A');
    $data['esl2b'] = $this->mstatistik->unker_esl($id, 'II/B');
    $data['esl3a'] = $this->mstatistik->unker_esl($id, 'III/A');
    $data['esl3b'] = $this->mstatistik->unker_esl($id, 'III/B');
    $data['esl4a'] = $this->mstatistik->unker_esl($id, 'IV/A');
    $data['esl4b'] = $this->mstatistik->unker_esl($id, 'IV/B');
    $data['esl5'] = $this->mstatistik->unker_esl($id, 'V');
    $data['esljfu'] = $this->mstatistik->unker_esl($id, 'JFU');
    $data['esljft'] = $this->mstatistik->unker_esl($id, 'JFT');

    // untuk tingkat pendidikan
    $data['tpsd'] = $this->mstatistik->unker_tingpen($id, 'SD');
    $data['tpsmp'] = $this->mstatistik->unker_tingpen($id, 'SMP');
    $data['tpsma'] = $this->mstatistik->unker_tingpen($id, 'SMA');
    $data['tpd1'] = $this->mstatistik->unker_tingpen($id, 'D1');
    $data['tpd2'] = $this->mstatistik->unker_tingpen($id, 'D2');
    $data['tpd3'] = $this->mstatistik->unker_tingpen($id, 'D3');
    $data['tpd4'] = $this->mstatistik->unker_tingpen($id, 'D4');
    $data['tps1'] = $this->mstatistik->unker_tingpen($id, 'S1');
    $data['tps2'] = $this->mstatistik->unker_tingpen($id, 'S2');
    $data['tps3'] = $this->mstatistik->unker_tingpen($id, 'S3');

    // untuk jenis kelamin
    $data['lk'] = $this->mstatistik->unker_jenkel($id, 'L');
    $data['pr'] = $this->mstatistik->unker_jenkel($id, 'P');

    // untuk agama
    $data['agislam'] = $this->mstatistik->unker_agama($id, 'ISLAM');
    $data['agprotestan'] = $this->mstatistik->unker_agama($id, 'PROTESTAN');
    $data['agkatholik'] = $this->mstatistik->unker_agama($id, 'KATHOLIK');
    $data['agbudha'] = $this->mstatistik->unker_agama($id, 'BUDHA');
    $data['aghindu'] = $this->mstatistik->unker_agama($id, 'HINDU');
    $data['agkonghuchu'] = $this->mstatistik->unker_agama($id, 'KONGHUCHU');

    // untuk status kawin
    $data['skbelumkawin'] = $this->mstatistik->unker_statkaw($id, 'BELUM KAWIN');
    $data['skkawin'] = $this->mstatistik->unker_statkaw($id, 'KAWIN');
    $data['skjandaduda'] = $this->mstatistik->unker_statkaw($id, 'JANDA/DUDA');
    
    // untuk kelompok usia (idunit_kerja, batas awal, batas akhir)
    // angka .99 di belakang batas akhir, digunakna untuk mendapatkan usia yang berkoma pada rentang batas akhir
    $data['usia1825'] = $this->mstatistik->unker_kelusia($id, 18, 25.99);
    $data['usia2630'] = $this->mstatistik->unker_kelusia($id, 26, 30.99);
    $data['usia3135'] = $this->mstatistik->unker_kelusia($id, 31, 35.99);
    $data['usia3640'] = $this->mstatistik->unker_kelusia($id, 36, 40.99);
    $data['usia4145'] = $this->mstatistik->unker_kelusia($id, 41, 45.99);
    $data['usia4650'] = $this->mstatistik->unker_kelusia($id, 46, 50.99);
    $data['usia5155'] = $this->mstatistik->unker_kelusia($id, 51, 55.99);
    $data['usia5660'] = $this->mstatistik->unker_kelusia($id, 56, 60.99);

    // untuk tahun BUP
    $data['bup2017'] = $this->mstatistik->unker_thnbup($id, 2022);
    $data['bup2018'] = $this->mstatistik->unker_thnbup($id, 2023);
    $data['bup2019'] = $this->mstatistik->unker_thnbup($id, 2024);
    $data['bup2020'] = $this->mstatistik->unker_thnbup($id, 2025);
    $data['bup2021'] = $this->mstatistik->unker_thnbup($id, 2026);

    // untuk kelompok tugas
    $data['keltupendidikan'] = $this->mstatistik->unker_keltu($id, 'PENDIDIKAN');
    $data['keltukesehatan'] = $this->mstatistik->unker_keltu($id, 'KESEHATAN');
    $data['keltupenyuluh'] = $this->mstatistik->unker_keltu($id, 'PENYULUH');
    $data['keltuteknis'] = $this->mstatistik->unker_keltu($id, 'TEKNIS');


    $data['idunker'] = $id;
    $data['nmunker'] = $this->munker->getnamaunker($id);
    $data['jmlpeg'] = $this->munker->getjmlpeg($id);
    $data['content'] = 'statperunker';
    $this->load->view('template',$data);
  }

  function uploadok()
  {
    //$data['unker'] = $this->munker->dd_unker()->result_array();
    $data['content'] = 'uploadok';
    $this->load->view('template',$data);
  }

  function uploadnok()
  {
    //$data['unker'] = $this->munker->dd_unker()->result_array();
    $data['content'] = 'uploadnok';
    $this->load->view('template',$data);
  }
	
  function editpeg()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $data['peg'] = $this->mpegawai->detail($nip)->result_array();
      $data['keldes'] = $this->mpegawai->kelurahan()->result_array();
      $data['content'] = 'pegedit';
      $this->load->view('template', $data);
    }
  }

  // untuk ajax kecamatan pada form editpeg
  function showkecamatan() {
    $idkel = $this->input->post('idkel');    // kalau menggunakan metode post untuk ajax
    $kecamatan = $this->mpegawai->getkecamatan($idkel);
    echo '<b>'.$kecamatan.'</b>';
  }

  function editpeg_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $alamat = $this->input->post('alamat');
    $idkel = $this->input->post('idkel');
    $telepon = $this->input->post('telepon');  
    $nokarpeg = $this->input->post('nokarpeg');  
    $notaspen = $this->input->post('notaspen');  
    $noaskes = $this->input->post('noaskes');  
    $noktp = $this->input->post('noktp');  
    $nonpwp = $this->input->post('nonpwp');  
    $nama = $this->mpegawai->getnama($nip);
    $status_kawin = $this->input->post('status_kawin');
   
    $jnsjab = $this->mkinerja->get_jnsjab($nip);
    if ($jnsjab == "STRUKTURAL") {      
      $idjab = $this->input->post('idjab');
      $idjabatasan = $this->mpegawai->getatasan_jabstruk($idjab);
    } else if ($jnsjab == "FUNGSIONAL UMUM") {
      $idjabatasan = $this->input->post('idjabatasan');
    } else if ($jnsjab == "FUNGSIONAL TERTENTU") {      
      $idjabatasan = $this->input->post('idjabatasan');
    }

    if($this->session->userdata('level') == 'ADMIN') {
    //hanya admin
    $stspeg = $this->input->post('status_pegawai');
    $tpp = $this->input->post('tpp');
    
     $datapeg = array(      
      'alamat'      => $alamat,
      'fid_alamat_kelurahan'      => $idkel,
      'fid_status_pegawai' => $stspeg,
      'tpp' => $tpp,
      'telepon'     => $telepon,
      'no_taspen'   => $notaspen,
      'no_askes'    => $noaskes,
      'no_ktp '     => $noktp,
      'no_npwp'     => $nonpwp,
      'fid_jabstrukatasan'  => $idjabatasan,
      'fid_status_kawin' => $status_kawin
      );
    } else {
    $datapeg = array(      
      'alamat'      => $alamat,
      'fid_alamat_kelurahan'      => $idkel,
      'telepon'     => $telepon,
      'no_taspen'   => $notaspen,
      'no_askes'    => $noaskes,
      'no_ktp '     => $noktp,
      'no_npwp'     => $nonpwp,
      'fid_jabstrukatasan'  => $idjabatasan,
      'fid_status_kawin' => $status_kawin
      );
    }

    $where = array(
      'nip'               => $nip
    );

    $datacpnspns = array(      
      'no_karpeg'   => $nokarpeg
      );

    $where = array(
      'nip'               => $nip
    );

    if (($this->mpegawai->edit_peg($where, $datapeg)) AND ($this->mpegawai->edit_cpnspns($where, $datacpnspns)))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Data PNS <u>'.$nama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Data PNS <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }
    
    $data['peg'] = $this->mpegawai->detail($nip)->result_array();
    $data['content'] = 'pegdetail';
    $this->load->view('template', $data);
  }
	function showtambahdikjst() {
		$nip = $this->input->get('nip');
	?>
	<h2>Hi</h2>
	
	<?php
	}
  function showtambahdikfung() {
    $nip = $this->input->get('nip');
    //$nip = $this->input->post('nip'); // jika menggunakan metode post pada ajax
    ?>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      });

      //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
    </script>



    <div class="panel panel-info" style='width :700px'>
      <!-- Default panel contents -->
      <div class="panel-heading" align='center'><b>TAMBAH DIKLAT FUNGSIONAL</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwydik'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pegawai/tambahdikfung_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <table class="table table-condensed table-hover">
        <tr>        
          <td align='left' colspan='2'>
          <small class="text-muted" style="color: red;">SELURUH DATA HARUS DIISI LENGKAP<br/>
          Untuk data tanggal harus dengan format hari-bulan-tahun (dd-mm-yyyy)</small>
	  </td>
        </tr>
        <tr>
          <td width='160' align='right'>Nama :</td>
          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
        </tr>
        <tr>
          <td align='right'>Nama Diklat :</td>
          <td><input type="text" name="namadiklat" size='80' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tahun :</td>
          <td><input type="text" name="tahun" size="10" onkeyup="validAngka(this)" maxlength="4" required /></td>
        </tr>
        <tr>
          <td align='right'>Instansi Penyelenggara :</td>
          <td><input type="text" name="penyelenggara" size='50' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tempat :</td>
          <td><input type="text" name="tempat" size='40' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Lama :</td>
          <td>
            <input type="text" name="lama" size='5' onkeyup="validAngka(this)" maxlength='3' />

            <select name="satuan_lama" id="satuan_lama" required >
              <option value='' selected>-- Pilih Satuan --</option>
              <option value='BULAN'>BULAN</option>
              <option value='HARI'>HARI</option>
              <option value='JAM'>JAM</option>
            </select>
          </td>
        </tr>
        <tr>
          <td rowspan='3' align='right'>Surat Keputusan :</td>
          <td>Pejabat&nbsp <input type="text" name="pejabatsk" size='50' maxlength='200' required /></td>
        </tr>
        <tr>
          <td>No. SK&nbsp&nbsp   <input type="text" name="nosk" size='30' maxlength='100' required /></td>
        </tr>
        <tr>
          <td>Tgl. SK&nbsp&nbsp  <input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' required /> <small>Wajib Diisi (format: dd-mm-yyyy)</small></td>
        </tr>
        <tr>
          <td align='right' colspan='2'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
                </button>
          </td>
        </tr>
      </table>
      </form>
    </div>
    <?php
  }

  function tambahdikfung_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $namadiklat = strtoupper(addslashes($this->input->post('namadiklat')));
    $tahun = $this->input->post('tahun');
    $penyelenggara = strtoupper(addslashes($this->input->post('penyelenggara')));  
    $tempat = strtoupper(addslashes($this->input->post('tempat')));  
    $lama = $this->input->post('lama');
    $satuan_lama = $this->input->post('satuan_lama');  
    if ($satuan_lama == 'BULAN') {
      $lamabulan = $lama;
      $lamahari = 0;
      $lamajam = 0;
    } else if ($satuan_lama == 'HARI') {
      $lamabulan = 0;
      $lamahari = $lama;
      $lamajam = 0;
    } else if ($satuan_lama == 'JAM') {
      $lamabulan = 0;
      $lamahari = 0;
      $lamajam = $lama;
    }

    $pejabatsk = strtoupper(addslashes($this->input->post('pejabatsk')));  
    $nosk = $this->input->post('nosk');  
    $tglsk = tgl_sql($this->input->post('tglsk'));  

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datadik = array(      
      'nip'      => $nip,
      'nama_diklat_fungsional'      => $namadiklat,
      'tahun'     => $tahun,
      'instansi_penyelenggara'   => $penyelenggara,
      'tempat'    => $tempat,
      'lama_bulan '     => $lamabulan,
      'lama_hari'     => $lamahari,
      'lama_jam '     => $lamajam,
      'pejabat_sk '     => $pejabatsk,
      'no_sk '     => $nosk,
      'tgl_sk '     => $tglsk,
      'created_at '     => $tgl_aksi,
      'created_by '     => $user
      );

    $nama = $this->mpegawai->getnama($nip);

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpegawai->cek_dikfung($nip, $namadiklat, $tahun) == 0) {
      if ($this->mpegawai->input_dikfung($datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Fungsional PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Fungsional PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function hapusdikfung_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $no = addslashes($this->input->post('no'));
    $tahun = addslashes($this->input->post('tahun'));
    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'no' => $no,
                   'tahun' => $tahun
             );
    
    // cek apakah data yang akan dihapus ada
    if ($this->mpegawai->cek_adadikfung($nip, $no, $tahun) != 0) {
      if ($this->mpegawai->hapus_dikfung($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Diklat Fungsional A.n. '.$nama.', Tahun '.$tahun.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Diklat Fungsional A.n. '.$nama.', Tahun '.$tahun.' gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
 
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function editdikfung() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $no = $this->input->post('no');
      $tahun = $this->input->post('tahun');

      $data['dikfung'] = $this->mpegawai->detaildikfung($nip, $no, $tahun)->result_array();
      $data['nip'] = $nip;
      $data['no'] = $no;
      $data['tahun'] = $tahun;
      $data['content'] = 'editdikfung';
      $this->load->view('template', $data);
    }
  }

  function editdikfung_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $no = addslashes($this->input->post('no'));
    $tahun_lama = addslashes($this->input->post('tahun_lama'));


    $namadiklat = strtoupper(addslashes($this->input->post('namadiklat')));
    $tahun = addslashes($this->input->post('tahun'));
    $penyelenggara = strtoupper(addslashes($this->input->post('penyelenggara')));  
    $tempat = strtoupper(addslashes($this->input->post('tempat')));  
    $lama = addslashes($this->input->post('lama'));
    $satuan_lama = addslashes($this->input->post('satuan_lama'));  
    if ($satuan_lama == 'BULAN') {
      $lamabulan = $lama;
      $lamahari = 0;
      $lamajam = 0;
    } else if ($satuan_lama == 'HARI') {
      $lamabulan = 0;
      $lamahari = $lama;
      $lamajam = 0;
    } else if ($satuan_lama == 'JAM') {
      $lamabulan = 0;
      $lamahari = 0;
      $lamajam = $lama;
    }

    $pejabatsk = strtoupper(addslashes($this->input->post('pejabatsk')));  
    $nosk = addslashes($this->input->post('nosk'));  
    $tglsk = tgl_sql($this->input->post('tglsk'));  

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datadik = array(      
      'nip'      => $nip,
      'nama_diklat_fungsional'      => $namadiklat,
      'tahun'     => $tahun,
      'instansi_penyelenggara'   => $penyelenggara,
      'tempat'    => $tempat,
      'lama_bulan '     => $lamabulan,
      'lama_hari'     => $lamahari,
      'lama_jam '     => $lamajam,
      'pejabat_sk '     => $pejabatsk,
      'no_sk '     => $nosk,
      'tgl_sk '     => $tglsk,
      'updated_at '     => $tgl_aksi,
      'updated_by '     => $user
      );

    $where = array(
      'nip'    => $nip,
      'no'     => $no,
      'tahun'  => $tahun_lama
    );

    $nama = $this->mpegawai->getnama($nip);

      if ($this->mpegawai->edit_dikfung($where, $datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Fungsional PNS A.n. <u>'.$nama.'</u> berhasil dirubah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Fungsional PNS A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }
  
  function getjab() {
  	$id = $this->input->get('unker');
  	$getjabstruk = $this->mpegawai->getjabstruk($id);
  	
  	$val = '';
  	if(count($getjabstruk) > 0) {
		foreach($getjabstruk as $s) {
			$val .= "<option value='".$s['id_jabatan']."-".$s['nama_jabatan']."'>".$s['nama_jabatan']."</option>";
		}
  	} else {
  		$val .= '<option value="0">Pilih Jabatan Struktural</option>';
  	}
	echo $val;
  }
  function showtambahrwypokja() {
  $nip = $this->input->get('nip');
  ?>
  <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
  <script>
		pilihpokja();
  </script>
	<br>
  <div class="panel panel-info" style='width :700px'>
	  <!-- Default panel contents -->
	  <div class="panel-heading" align='center'><b>TAMBAH RIWAYAT POKJA</b></div>      
	    <br />
	    <div align='right' style='width :99%'>
	      <form method='POST' action='../pegawai/rwyjab'>
	        <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
	        <button type="submit" class="btn btn-danger btn-sm">
	          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
	        </button>&nbsp
	      </form>
	    </div>
  		<form method='POST' action='../pegawai/tambahrwypokja_aksi'>
	    		<input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
	        <table class="table table-condensed table-hover">

	        <tr>
	          <td width='160' align='right'>Nama :</td>
	          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Pokja :</td>
	          <td>
	          	
	          	<select name="nm_pokja">
	          		<option value="0">Pilih Pokja</option>
	          	</select>
	          	<button type="button" onclick="input_pokjabaru()" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah Pokja</button>
	          	
	          </td>
	        </tr>
	        
	        <tr>
          		<td align='right'>TMT Awal :</td>
          		<td><input type="date" name="tmt_awal" size='15' maxlength='10' required /></td>
        	</tr>
        	<tr>
        		<td align='right'>TMT Akhir:</td>
          		<td><input type="date" name="tmt_akhir" size='15' maxlength='10' required /></td>
        	</tr>
	        <tr bgcolor="pink">
	          <td align='right'>Nomor SK :</td>
	          <td><input type="text" name="no_sk" size='50' maxlength='200' required /></td>
	        </tr>
	        
	        <tr bgcolor="pink">
	          <td align='right'>Pejabat SK :</td>
	          <td><input type="text" name="pejabat_sk" size='50' maxlength='200' required /></td>
	        </tr>
	        
	        <tr bgcolor="pink">
          		<td align='right'>Tgl. SK :</td>
          		<td>  <input type="date" name="tgl_sk"  size='15' maxlength='10' required /></td>
        	</tr>
	        
	        <tr>
	          <td align='right' colspan='2'>
	                <button type="submit" class="btn btn-success btn-sm">
	                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
	                </button>
	          </td>
	        </tr>
	      </table>
        </form>
  </div>
  <?php
  }
  
  function getpokja() {
 
		$get_ref_pokja = $this->mpegawai->getrefpokja();
		$val = '';
		if(count($get_ref_pokja) > 0) {
			foreach($get_ref_pokja as $p) {
				$val .= "<option value='".$p['id_pokja']."'>".$p['nama_pokja']."</option>";
			}
		} else {
				$val = 'Pilih Pokja';
		}
		echo json_encode($val);
  }
  
  function input_pokjabaru_proses() {
  	$new_pokja = $this->input->post('newpokja');
  	$insert = $this->db->insert('ref_pokja', array('nama_pokja' => $new_pokja));
  	if($insert) {
  		$msg = array('pesan' => 'Pokja Berhasil Ditambahkan');
  	} else {
  		$msg = array('pesan' => 'Pokja Gagal Ditambahkan');
  	}
  	echo json_encode($msg);
  }
  
  function tambahrwypokja_aksi() {
	$nip 	     = addslashes($this->input->post('nip'));  
  $tmt_awl   = $this->input->post('tmt_awal');  
  $tmt_akr   = $this->input->post('tmt_akhir');  
  $nosk 	   = addslashes($this->input->post('no_sk'));  
  $tglsk 	   = $this->input->post('tgl_sk');  
  $pejabatsk = addslashes($this->input->post('pejabat_sk'));
	$pokja	   = $this->input->post('nm_pokja');
	
    
    $datarwypokja = array(      
      'nip'         => $nip,
      'fid_pokja'				=> $pokja,
      'tmt_awal'    => $tmt_awl,
      'tmt_akhir'   => $tmt_akr,
      'no_sk'   		=> $nosk,
      'pejabat_sk'  => $pejabatsk,
      'tgl_sk'     	=> $tglsk
      );
    
    $nama = $this->mpegawai->getnama($nip);
    
    if ($this->mpegawai->input_rwypokja($datarwypokja))
    {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Pokja PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat Pokja PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
    $data['pegrwypokja'] = $this->mpegawai->rwypokja($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data); 
    
  }
  
  function editrwypokja() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $id = $this->input->post('id');
      
      $data['detailrwypokja'] = $this->mpegawai->rwypokja_whereid($nip, $id)->result_array();
      $data['nip'] = $nip;
      $data['id'] = $id;
      $data['content'] = 'editrwypokja';
      $this->load->view('template', $data);
    }
  }
  
  function editrwypokja_aksi() {
  	$nip = $this->input->post('nip');
  	$id  = $this->input->post('id');
  	 
    $pokja   = addslashes($this->input->post('nm_pokja'));  
    
    $tmt_awl   = $this->input->post('tmt_awal');  
    $tmt_akr   = $this->input->post('tmt_akhir');  
    
  	$nosk 	   = strtoupper(addslashes($this->input->post('no_sk'))); 
    $tglsk 	   = $this->input->post('tgl_sk');  
    $pejabatsk = addslashes($this->input->post('pejabat_sk'));
    
		$datarwypokja = array(      
      'fid_pokja'   => $pokja,
      'tmt_awal'    => $tmt_awl,
      'tmt_akhir'   => $tmt_akr,
      'no_sk'				=> $nosk,
      'pejabat_sk'  => $pejabatsk,
      'tgl_sk'     	=> $tglsk
      );
      
    $whr = array(
    	'nip' => $nip,
    	'id'  => $id
    );
    
    $nama = $this->mpegawai->getnama($nip);
    if ($this->mpegawai->update_pokja($datarwypokja, $whr))
    {
      $data['pesan'] = '<b>Sukses</b>, Update Riwayat Pokja PNS A.n. <u>'.$nama.'</u> berhasil diubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Update Riwayat Pokja PNS A.n. <u>'.$nama.'</u> gagal diubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
    $data['pegrwypokja'] = $this->mpegawai->rwypokja($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data);
  }
  
  function hapusrwypokja_aksi(){
    $nip   = addslashes($this->input->post('nip'));
    $nama  = $this->mpegawai->getnama($nip);
    $id    = $this->input->post('id');
    $where = array('nip' => $nip, 'id' => $id);
    
    if ($this->mpegawai->hapus_rwypokja($where)) {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Pokja A.n. '.$nama.' berhasil dihapus';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal</b>, Riwayat Pokja A.n. '.$nama.' gagal dihapus';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
    $data['pegrwypokja'] = $this->mpegawai->rwypokja($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data); 
  }
  
  function showtambahrwyjab() {
  	$nip = $this->input->get('nip');
  	$unker_skr = $this->mpegawai->detail($nip)->row();
  ?>
  <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      
      });
		//validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
        console.log(a);
      }
      
    </script>
	
	
  <br>
  <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading" align='center'><b>TAMBAH RIWAYAT JABATAN</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwyjab'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
        <form method='POST' action='../pegawai/tambahrwyjab_aksi'>
			<input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
			<table class="table table-condensed table-hover">
	        <tr>
	          <td width='160' align='right'>Nama :</td>
	          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Unit Kerja :</td>
	          <td>
	           
	          	<select name="unitkerja" onChange="removeCheck()">
	          		<option value="0">Pilih Unit Kerja</option>
	          		<?php
	          		$getunker = $this->mpegawai->getunitkerja();
	          		foreach($getunker as $u) {
	          		
	          		$selected = $u['id_unit_kerja'] == $unker_skr->fid_unit_kerja ? 'selected' : '';
						echo "<option value='".$u['id_unit_kerja']."-".$u['nama_unit_kerja']."' ".$selected.">".$u['nama_unit_kerja']."</option>";
					}
					?>
	          	</select>
	          	
	          </td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Jenis Jabatan :</td>
	          <td>
	          	<input type="radio" name="jns_jab" value="JST" onChange="pilih_jns_jab(this.value)" required> Struktural
	          	<input type="radio" name="jns_jab" value="JFU" onChange="pilih_jns_jab(this.value)" required> JFU
	          	<input type="radio" name="jns_jab" value="JFT" onChange="pilih_jns_jab(this.value)" required> JFT
	          </td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Jabatan :</td>
	          <td>
	          	<select name="pilih_jabatan_skr" onchange="piliheselon(this.value)">
	          		<option value="0" selected>Pilih Jabatan</option>
	          	</select>
	          </td>
	        </tr>
	        <tr id="angka_kredit_rows" class="hidden" style="width: 100%">
	        	<td align='right'>Angka Kredit :</td>
	        	<td>
	        		<input type="text" name="angka_kredit" size='5' maxlength='10'/>
	        		<span style="margin:0 10px; border-right: 1px solid #ccc"></span> Tunjangan Jabatan :
	        		<input type="text" name="tunjangan" size='20' maxlength='100' onkeyup="isRupiah(this)" onchange="isRupiah(this)"/> / <span id="toRupiah"></span>
	        	</td>
	        </tr>
	        <tr>
	          <td align='right'>Eselon :</td>
	          <td>
	          	<select name="eselon" required>
	          		<option value="0">Pilih Eselon</option>
	          		<?php
	          			$geteselon = $this->mpegawai->geteselon();
	          			foreach($geteselon as $e) {
	          				
	          				echo "<option value='".$e['id_eselon']."-".$e['nama_eselon']."'>".$e['nama_eselon']."</option>";
	          			}
	          		?>
	          	</select>
	          </td>
	        </tr>
	        
	        <tr>
          		<td align='right'>TMT Jabatan :</td>
          		<td><input type="date" class="tanggal" name="tmt_jabatan" size='15' maxlength='10' value='2022-10-10' required /></td>
        	  </tr>
        	  <tr>
          		<td align='right'>Tanggal Pelantikan :</td>
          		<td>
          			<input type="date" class="tanggal" name="tgl_pelantikan" size='15' value='2022-10-10' maxlength='10'/>
          			<p class="help-block text-danger">*(Boleh dikosongi bila kadida.) <br></p>
          		</td>
        	  </tr>
        	  <tr>
          		<td align='right'>No. SK Beperjakat :</td>
          		<td>
          			<input type="text" name="no_beperjakat" size='50' maxlength='200'/>
          			<p class="help-block text-danger">*(Boleh dikosongi bila kadida.) <br></p>
          		</td>
        	  </tr>
        	<tr class='warning'>
        	  	<td></td>
        	  	<td>*(Nang ngini wajib pian isi sesuai lawan SK nang pian terima.)</td>
        	</tr>
        	<tr class='warning'>
	          <td align='right'>Nomor SK :</td>
	          <td><input type="text" name="nosk" size='50' maxlength='200' value='821/218/BKPSDM-BLG/2022' required /></td>
	        </tr>
	        
	        <tr class='warning'>
	          <td align='right'>Pejabat SK :</td>
	          <td><input type="text" name="pejabatsk" size='50' maxlength='200' value='BUPATI BALANGAN' required /></td>
	        </tr>
	        
	        <tr class='warning'>
          		<td align='right'>Tgl. SK :</td>
          		<td><input type="date" name="tglsk" class="tanggal" size='15' maxlength='10'  value='2022-10-10' required /></td>
        	</tr>
                <tr class='danger'>
                  <td align='right'>Jenis Prosedur</td>
                  <td>
                        <select name="prosedur" required>
                                <option value="0">Pilih Prosedur</option>
                                <?php
                                        echo "<option selected value='MUTASI' selected>MUTASI</option>";
                                        echo "<option value='KP'>KENAIKAN PANGKAT</option>";
                                        echo "<option value='HUKDIS'>HUKUMAN DISIPLIN</option>";
                                ?>
                        </select>
                  </td>
                </tr>
		<tr class='danger'>
                  <td align='right'>Integrasi SAPK</td>
                  <td>
                        <select name="integrasi" required>
                                <option value="0">Pilih Integrasi</option>
                                <?php
                                        echo "<option value='YA' selected>YA</option>";
                                        echo "<option value='TIDAK'>TIDAK</option>";
                                ?>
                        </select>
                  </td>
		</tr>
		<tr class='danger'>
                  <td align='right'>Save To Table </td>
                  <td>
                        <select name="aksi_table" required>
                                <option value="0">-- Change Table --</option>
                                <?php
                                        echo "<option value='0' selected>Riwayat & Update Profile</option>";
                                        echo "<option value='1'>Only Riwayat</option>";
                                ?>
                        </select>
                  </td>
		</tr>
        	<tr>
        		 <td></td>
	          <td>
	                <button type="submit" class="btn btn-success btn-sm">
	                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
	                </button>
	          </td>
		</tr>
	      </tr>
	      </table>
		</form>
		</div>
	</div>  
  <?php
  }
  
  function getJst() {
  	$unkerId = $this->input->get('unkerId');
  	
  	$getjab = $this->mpegawai->getJst($unkerId);
  	
  	$val = '';
  	if(count($getjab) > 0) {
		foreach($getjab as $s) {
			$val .= "<option value='".$s['id_jabatan']."-".$s['nama_jabatan']."'>".$s['nama_jabatan']."</option>";
		}
  	} else {
  		$val .= '<option value="0">Pilih Jabatan Struktural</option>';
  	}
	echo json_encode($val);
  }
  
  function getJfu() {
  	
  	$getjab = $this->mpegawai->getJfu();
  	
  	$val = '<option value="0" selected>Pilih Jabatan Fungsional Umum</option>';
  	if(count($getjab) > 0) {
		foreach($getjab as $s) {
			$val .= "<option value='".$s['id_jabfu']."-".$s['nama_jabfu']."'>".$s['nama_jabfu']."</option>";
		}
  	} else {
  		$val .= '<option value="0">Pilih Jabatan Fungsional Umum</option>';
  	}
	echo json_encode($val);
  }
  
  function getJft() {
  	
  	$getjab = $this->mpegawai->getJft();
  	
  	$val = '<option value="0">Pilih Jabatan Fungsional Tertentu</option>';
  	if(count($getjab) > 0) {
		foreach($getjab as $s) {
			$val .= "<option value='".$s['id_jabft']."-".$s['nama_jabft']."'>".$s['nama_jabft']."</option>";
		}
  	} else {
  		$val .= '<option value="0">Pilih Jabatan Fungsional Tertentu</option>';
  	}
	echo json_encode($val);
  }
  
  function geteselon_byjabatan_rwyjab() {
	$id = $this->input->get('id');
	$get_eselon = $this->mpegawai->get_eselon_byjabatan($id);
	if(($get_eselon->num_rows() > 0) && ($id != null)) {
	$e = $get_eselon->result();	
	$eselon = $e[0]->fid_eselon."-".$e[0]->nama_eselon;
	} else {
	$eselon = 0;
	}
	
	echo json_encode($eselon);
  }
  
  function tambahrwyjab_aksi()
  {
  		$p = $this->input->post();
  		$nip = $p['nip'];
  		
  		$pecah_jabatan = explode("-",$p['pilih_jabatan_skr']);
  		$jabatan_id = $pecah_jabatan[0];
  		$jabatan_name = $pecah_jabatan[1];
  		
  		$pecah_unitkerja = explode("-",$p['unitkerja']);
  		$unitkerja_id = $pecah_unitkerja[0];
  		$unitkerja_name = $pecah_unitkerja[1];
  		
  		$pecah_eselon = explode("-",$p['eselon']);
  		$eselon_id = $pecah_eselon[0];
  		$eselon_name = $pecah_eselon[1];
  		
  		/* 
  		jika aksi ?
  		0 : simpan ke table riwayat dan update profile
  		1 : hanya simpan ke table riwayat
  		*/
  		$aksi_table = $p['aksi_table'];
  		
  		if($p['jns_jab'] == 'JST'){
  			$jenis_jabatan = 'STRUKTURAL';
  			$data_pegawai = [
  				'fid_unit_kerja' => $unitkerja_id,
  				'fid_jabatan' => $jabatan_id,
				'fid_jabfu' => null,
				'fid_jabft' => null,
  				'fid_eselon' => $eselon_id,
  				'tmt_jabatan' => $p['tmt_jabatan'],
  				'fid_jnsjab' => '1'
  			];
  		} elseif($p['jns_jab'] == 'JFU'){
  			$jenis_jabatan = 'FUNGSIONAL UMUM';
  			$data_pegawai = [
  				'fid_unit_kerja' => $unitkerja_id,
  				'fid_jabfu' => $jabatan_id,
				'fid_jabft' => null,
				'fid_jabatan' => null,
  				'fid_eselon' => $eselon_id,
  				'tmt_jabatan' => $p['tmt_jabatan'],
  				'fid_jnsjab' => '2'
  			];
  		} elseif($p['jns_jab'] == 'JFT'){
  			$jenis_jabatan = 'FUNGSIONAL TERTENTU';
  			$data_pegawai = [
  				'fid_unit_kerja' => $unitkerja_id,
  				'fid_jabft' => $jabatan_id,
				'fid_jabatan' => null,
				'fid_jabfu' => null,
  				'fid_eselon' => $eselon_id,
  				'tmt_jabatan' => $p['tmt_jabatan'],
  				'fid_jnsjab' => '3'
  			];
  		}
  		
  		$data_riwayat = [
			'nip' => $p['nip'],
			'unit_kerja' => $unitkerja_name,
			'jabatan' => $jabatan_name,
			'angka_kredit' => !empty($p['angka_kredit']) ? $p['angka_kredit'] : null,
			'tunjangan' => !empty($p['tunjangan']) ? $p['tunjangan'] : null,
        	'jns_jab' => $jenis_jabatan,
			'eselon' => $eselon_name,
			'tmt_jabatan' => $p['tmt_jabatan'],
			'no_sk_baperjakat' => $p['no_beperjakat'],
			'tgl_pelantikan' => $p['tgl_pelantikan'],
			'pejabat_sk' => $p['pejabatsk'],	
			'no_sk' => $p['nosk'],
			'tgl_sk' => $p['tglsk'],
         'prosedur' => $p['prosedur'],
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->session->userdata('nip')
		];
		
		$nama = $this->mpegawai->getnama($nip);
		//var_dump($aksi_table);die();
		
		$db_riwayat = $this->mpegawai->insert_rwyjab('riwayat_jabatan', $data_riwayat);
		if($db_riwayat) {
			if($aksi_table == "0") {
		   	$this->mpegawai->update_jabatan_rywtjab('pegawai', $data_pegawai, ['nip' => $nip]);
		   }
		   // START jika Integrasi SAPK
                   if ($p['integrasi'] == "YA") {
				$data = $this->mwsbkn->forupjabsapk($nip)->result_array();
				//var_dump($data);
        			foreach ($data as $hasil)
        			{
            				if ($hasil['nama_jenis_jabatan'] == "STRUKTURAL") {
                				$unorId = $hasil['idbkn_jab'];
                				$eslId = $hasil['idbkn_esl'];
                				$jabftId = "";
                				$jabfuId = "";

                				if ($hasil['tmt_pelantikan'] == "") {
                    					$tgllantik = tgl_indo_pendek($hasil['tmt_jabatan']);
                				} else {
                    					$tgllantik = tgl_indo_pendek($hasil['tmt_pelantikan']);
                				}

            				} else if ($hasil['nama_jenis_jabatan'] == "FUNGSIONAL UMUM") {
                				$unorId = $hasil['idbkn_unor'];
                				$eslId = "";
                				$jabftId = "";
                				$jabfuId = $hasil['idbkn_jab'];
                				$tgllantik = "";
            				} else if ($hasil['nama_jenis_jabatan'] == "FUNGSIONAL TERTENTU") {
                				$unorId = $hasil['idbkn_unor'];
                				$eslId = "";
						$jabftId = $hasil['idbkn_jab'];
                				$jabfuId = "";
                				$tgllantik = "";
            				}

            				$posts = array(
                 				"id"           => null,
                 				"jenisJabatan" => $hasil['idbkn_jnsjab'],
                 				"unorId"       => $unorId,
                 				"eselonId"     => $eslId,
                 				"instansiId"   => "A5EB03E23CF4F6A0E040640A040252AD", // Instansi ID Balangan
                 				"pnsId"        => $hasil['idbkn_pns'],
                 				"jabatanFungsionalId"      => $jabftId,
                 				"jabatanFungsionalUmumId"  => $jabfuId,
                 				"nomorSk"                  => $hasil['no_sk'],
                 				"tanggalSk"                => tgl_indo_pendek($hasil['tgl_sk']),
                 				"tmtJabatan"               => tgl_indo_pendek($hasil['tmt_jabatan']),
                 				"tmtPelantikan"            => $tgllantik,
                 				"pnsUserId"                => "A8ACA7E42B1F3912E040640A040269BB" // PNS ID Admin SAPK
            				);

	    				$data_string = json_encode($posts);
            				$resultApi = apiResult2('https://wsrv-duplex.bkn.go.id/api/jabatan/save', $data_string);
            				//var_dump($data_string);
            				$objRest = json_decode($resultApi, true);
            				//var_dump($objRest);

            				if($objRest['success']) {
                				$dataidbkn = array(
                    					'id_bkn' => $objRest['mapData']['rwJabatanId']
                    				);
                				$whereidbkn = array(
                    					'nip'           => $nip,
                    					'tmt_jabatan'   => $hasil['tmt_jabatan'],
                    					'tgl_sk'        => $hasil['tgl_sk']
                    				);
					// Update ID Riwayat Jabatan SAPK pada SILKa
					$this->mpegawai->edit_rwyjab($whereidbkn, $dataidbkn);
            			} 
				$data['pesan'] = '<b>Sukses</b>, Riwayat Jabatan PNS A.n. <u>'.$nama.'</u> berhasil ditambah, dan diupdate pada SAPK BKN.';
                        	$data['jnspesan'] = 'alert alert-success';
			}

		   } // END jika Integrasi SAPK
		   else {
  		   $data['pesan'] = '<b>Sukses</b>, Riwayat Jabatan PNS A.n. <u>'.$nama.'</u> berhasil ditambah, SAPK BKN TIDAK DIUPDATE.';
      		   	$data['jnspesan'] = 'alert alert-info';
		   }
		} else {
			$data['pesan'] = '<b>Gagal</b>, Riwayat Jabatan PNS A.n. <u>'.$nama.'</u> gagal, pastikan data yang anda input benar.';
      			$data['jnspesan'] = 'alert alert-danger';
		}
		
	    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
	    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
	    $data['nip'] = $nip;
	    $data['content'] = 'rwyjab';
	    $this->load->view('template', $data);
  }
  
  function showtambahjnsjab() {
  	$nip = $this->input->get('nip');
  ?>
   
  <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
        
      });
		
      //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
    </script>

  <br>
  <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading" align='center'><b>TAMBAH RIWAYAT JABATAN PLT / PLH</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwyjab'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
        
        <form method='POST' action='../pegawai/tambahjnsjab_aksi'>
	    		<input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
	        <table class="table table-condensed table-hover">

	        <tr>
	          <td width='160' align='right'>Nama :</td>
	          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
	        </tr>
	        
	        <tr>
	          <td align='right'>Jenis Jabatan :</td>
	          <td>
	          	<input type="radio" name="jns_jab" value="Plt" required> Plt
	          	<input type="radio" name="jns_jab" value="Plh" required> Plh
	          </td>
	        </tr>
	        
	         <tr>
	          <td align='right'>Unit Kerja :</td>
	          <td>
	          
	          	<select name="unitkerja" onchange="pilihunker()">
	          		<option value="0">Pilih Unit Kerja</option>
	          		<?php
	          		$getunker = $this->mpegawai->getunitkerja();
	          		foreach($getunker as $u) {
						echo "<option id='".$u['id_unit_kerja']."' value='".$u['nama_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
					}
					?>
	          	</select>
	          	
	          </td>
	        </tr>
	    
	        <tr>
	          <td align='right'>Jabatan :</td>
	          <td>
	          	<select name="jabstruk" onchange="pilihjabatan(this.value)">
	          		<option value="0">Pilih Jabatan Struktural</option>
	          	</select>
	          </td>
	        </tr>
	        
	        <!--<tr>
	          <td align='right'>Jabatan :</td>
	          <td>
	          	<input type="text" name="jabatan" size='70' maxlength='200' required />
	          </td>
	        </tr>-->
	        
	        
	        <tr>
	          <td align='right'>Eselon :</td>
	          <td>
	          	<select name="eselon">
	          		<option value="0">Pilih Eselon</option>
	          		<?php
	          			$geteselon = $this->mpegawai->geteselon();
	          			foreach($geteselon as $e) {
	          				
	          				echo "<option value='".$e['id_eselon']."'>".$e['nama_eselon']."</option>";
	          			}
	          		?>
	          	</select>
			<p class="help-block">(eselon automatis dipilih, berdasarkan jabatan yang di pilih)</p>
	          </td>
	        </tr>
	        
	        <tr>
          		<td align='right'>TMT Awal :</td>
          		<td><input type="date" name="tmt_awal" size='15' maxlength='10'  required /></td>
        	</tr>
        	<tr>
        		<td align='right'>TMT Akhir:</td>
          		<td><input type="date" name="tmt_akhir" size='15' maxlength='10' required /></td>
        	</tr>
	        <tr bgcolor="pink">
	          <td align='right'>Nomor SK :</td>
	          <td><input type="text" name="nosk" size='50' maxlength='200' required /></td>
	        </tr>
	        
	        <tr bgcolor="pink">
	          <td align='right'>Pejabat SK :</td>
	          <td><input type="text" name="pejabatsk" size='50' maxlength='200' required /></td>
	        </tr>
	        
	        <tr bgcolor="pink">
          		<td align='right'>Tgl. SK :</td>
          		<td><input type="date" name="tglsk"  size='15' maxlength='10' required /></td>
        	</tr>
	        
	        <tr>
	          <td align='right' colspan='2'>
	                <button type="submit" class="btn btn-success btn-sm">
	                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
	                </button>
	          </td>
	        </tr>
	      </table>
        </form>
        
  </div>
  <?php
  }
  function geteselon_byjabatan() {
	$id = $this->input->get('id');
	$get_eselon = $this->mpegawai->get_eselon_byjabatan($id);
	if(($get_eselon->num_rows() > 0) && ($id != null)) {
	$e = $get_eselon->result();	
	$eselon = $e[0]->fid_eselon;
	} else {
	$eselon = 0;
	}
	
	echo json_encode($eselon);
  }
  function tambahjnsjab_aksi() {
  	$nip 	   = addslashes($this->input->post('nip'));  
    $nosk 	   = strtoupper(addslashes($this->input->post('nosk')));  
    $tmt_awl   = $this->input->post('tmt_awal');  
    $tmt_akr   = $this->input->post('tmt_akhir');  
    $jns_jab   = addslashes($this->input->post('jns_jab'));  
    $tglsk 	   = $this->input->post('tglsk');  
    $pejabatsk = addslashes($this->input->post('pejabatsk'));
	$eselon    = $this->input->post('eselon');
	$unker     = $this->input->post('unitkerja');
	$jab	   = $this->input->post('jabstruk');
	$pecah_jab = explode("-", $jab);
	$jabatan   = $pecah_jab[1];
	$idjst	   = $pecah_jab[0];
	
    
    $datajnsjab = array(      
      'nip'             => $nip,
      'no_sk'   		=> $nosk,
      'tmt_awal'        => $tmt_awl,
      'tmt_akhir'   	=> $tmt_akr,
      'jns_jabatan'     => $jns_jab,
      'tgl_sk'     		=> $tglsk,
      'pejabat_sk'      => $pejabatsk,
      'fid_jabstruk'	=> $idjst,
      'fid_eselon' 		=> $eselon,
      'jabatan'			=> $jabatan,
      'unit_kerja'		=> $unker
      );
    
    $nama = $this->mpegawai->getnama($nip);
    
    if ($this->mpegawai->input_jnsjab($datajnsjab))
    {
      $data['pesan'] = '<b>Sukses</b>, Riwayat '. $jns_jab .' PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat ' . $jns_jab . ' PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data); 
    
    //Update Data Pegawai Dengan Merubah Status Jabatannya PLT/Tidak
    if(!empty($jns_jab)) {
    	$this->db->where('nip', $nip);
    	$this->db->update('pegawai', array('plt' => 'YA'));
    }
  }
  
  function editrwyplt() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $id = $this->input->post('id');
      
      $data['detailrwyplt'] = $this->mpegawai->rwyplt_whereid($nip, $id)->result_array();
      $data['nip'] = $nip;
      $data['id'] = $id;
      $data['content'] = 'editrwyplt';
      $this->load->view('template', $data);
    }
  }
  
  function editrwyplt_aksi() {
  	$nip = $this->input->post('nip');
  	$id = $this->input->post('id');
  	
  	$nosk 	   = strtoupper(addslashes($this->input->post('nosk')));  
    $tmt_awl   = $this->input->post('tmt_awal');  
    $tmt_akr   = $this->input->post('tmt_akhir');  
    $jns_jab   = addslashes($this->input->post('jns_jab'));  
    $tglsk 	   = $this->input->post('tglsk');  
    $pejabatsk = addslashes($this->input->post('pejabatsk'));
	$eselon    = $this->input->post('eselon');
	$unker     = $this->input->post('unitkerja');
	
	$jab   	   = $this->input->post('jabstruk');
	$jab_pecah = explode("-", $jab);
	$jabatan   = $jab_pecah[1];
	$idjst	   = $jab_pecah[0];
	
	$datarwyplt = array(      
      'no_sk'   		=> $nosk,
      'tmt_awal'        => $tmt_awl,
      'tmt_akhir'   	=> $tmt_akr,
      'jns_jabatan'     => $jns_jab,
      'tgl_sk'     		=> $tglsk,
      'pejabat_sk'      => $pejabatsk,
      'fid_jabstruk'	=> $idjst,
      'fid_eselon' 		=> $eselon,
      'jabatan'			=> $jabatan,
      'unit_kerja'		=> $unker
      );
    $whr = array(
    	'nip' => $nip,
    	'id'  => $id
    );
    
    $nama = $this->mpegawai->getnama($nip);
    if ($this->mpegawai->update_jnsjab($datarwyplt, $whr))
    {
      $data['pesan'] = '<b>Sukses</b>, Update Riwayat '. $jns_jab .' PNS A.n. <u>'.$nama.'</u> berhasil diubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Update Riwayat ' . $jns_jab . ' PNS A.n. <u>'.$nama.'</u> gagal diubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data);
  }
  
  function hapusrwyplt_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $nama = $this->mpegawai->getnama($nip);
    $id  = $this->input->post('id');
    $where = array('nip' => $nip, 'id' => $id);
    
    if ($this->mpegawai->hapus_rwyplt($where)) {
      // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Riwayat Jabatan A.n. '.$nama.' berhasil dihapus';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal</b>, Riwayat Jabatan A.n. '.$nama.' gagal dihapus';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyjab'] = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt'] = $this->mpegawai->rwyplt($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data); 
    
    //Update Data Pegawai Dengan Merubah Status Jabatannya PLT/Tidak
    //$get_order_plt = $this->db->query("select id from `riwayat_plt` order by id desc limit 1")->result();
    //if($get_order_plt[0]->id == $id) {
    //	$this->db->where('nip', $nip);
    //	$this->db->update('pegawai', array('plt' => 'TIDAK'));
    //}
  }
  
  function showtambahdiktek() {
    $nip = $this->input->get('nip');
    //$nip = $this->input->post('nip'); // jika menggunakan metode post pada ajax
  ?>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      });

      //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
    </script>



    <div class="panel panel-info" style='width :700px'>
      <!-- Default panel contents -->
      <div class="panel-heading" align='center'><b>TAMBAH DIKLAT TEKNIS</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwydik'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pegawai/tambahdiktek_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <table class="table table-condensed table-hover">
        <tr>        
          <td align='left' colspan='2'>
          <small class="text-muted" style="color: red;">SELURUH DATA HARUS DIISI LENGKAP<br/>
          Untuk data tanggal harus dengan format hari-bulan-tahun (dd-mm-yyyy)</small>
	  </td>
        </tr>
        <tr>
          <td width='160' align='right'>Nama :</td>
          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
        </tr>
        <tr>
          <td align='right'>Nama Diklat :</td>
          <td><input type="text" name="namadiklat" size='80' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tahun :</td>
          <td><input type="text" name="tahun" size="10" onkeyup="validAngka(this)" maxlength="4" required /></td>
        </tr>
        <tr>
          <td align='right'>Instansi Penyelenggara :</td>
          <td><input type="text" name="penyelenggara" size='50' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tempat :</td>
          <td><input type="text" name="tempat" size='40' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Lama :</td>
          <td>
            <input type="text" name="lama" size='5' onkeyup="validAngka(this)" maxlength='3' />

            <select name="satuan_lama" id="satuan_lama" required >
              <option value='' selected>-- Pilih Satuan --</option>
              <option value='BULAN'>BULAN</option>
              <option value='HARI'>HARI</option>
              <option value='JAM'>JAM</option>
            </select>
          </td>
        </tr>
        <tr>
          <td rowspan='3' align='right'>Surat Keputusan :</td>
          <td>Pejabat&nbsp <input type="text" name="pejabatsk" size='50' maxlength='200' required /></td>
        </tr>
        <tr>
          <td>No. SK&nbsp&nbsp   <input type="text" name="nosk" size='30' maxlength='100' required /></td>
        </tr>
        <tr>
          <td>Tgl. SK&nbsp&nbsp  <input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' required /> <small>Wajib Diisi (format: dd-mm-yyyy)</small></td>
        </tr>
        <tr>
          <td align='right' colspan='2'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
                </button>
          </td>
        </tr>
      </table>
      </form>
    </div>
    <?php
  }

  function tambahdiktek_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $namadiklat = strtoupper(addslashes($this->input->post('namadiklat')));
    $tahun = addslashes($this->input->post('tahun'));
    $penyelenggara = strtoupper(addslashes($this->input->post('penyelenggara')));  
    $tempat = strtoupper(addslashes($this->input->post('tempat')));  
    $lama = addslashes($this->input->post('lama'));
    $satuan_lama = addslashes($this->input->post('satuan_lama'));  
    if ($satuan_lama == 'BULAN') {
      $lamabulan = $lama;
      $lamahari = 0;
      $lamajam = 0;
    } else if ($satuan_lama == 'HARI') {
      $lamabulan = 0;
      $lamahari = $lama;
      $lamajam = 0;
    } else if ($satuan_lama == 'JAM') {
      $lamabulan = 0;
      $lamahari = 0;
      $lamajam = $lama;
    }

    $pejabatsk = strtoupper(addslashes($this->input->post('pejabatsk')));  
    $nosk = strtoupper(addslashes($this->input->post('nosk')));  
    $tglsk = tgl_sql($this->input->post('tglsk'));  

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datadik = array(      
      'nip'             => $nip,
      'nama_diklat_teknis'   => $namadiklat,
      'tahun'           => $tahun,
      'instansi_penyelenggara'   => $penyelenggara,
      'tempat'          => $tempat,
      'lama_bulan '     => $lamabulan,
      'lama_hari'       => $lamahari,
      'lama_jam'        => $lamajam,
      'pejabat_sk'      => $pejabatsk,
      'no_sk'           => $nosk,
      'tgl_sk'          => $tglsk,
      'created_at'      => $tgl_aksi,
      'created_by'      => $user
      );

    $nama = $this->mpegawai->getnama($nip);

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpegawai->cek_diktek($nip, $namadiklat, $tahun) == 0) {
      if ($this->mpegawai->input_diktek($datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Teknis PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Teknis PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function hapusdiktek_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $no = addslashes($this->input->post('no'));
    $tahun = addslashes($this->input->post('tahun'));
    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'no' => $no,
                   'tahun' => $tahun
             );
    
    // cek apakah data yang akan dihapus ada
    if ($this->mpegawai->cek_adadiktek($nip, $no, $tahun) != 0) {
      if ($this->mpegawai->hapus_diktek($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Diklat Teknis A.n. '.$nama.', Tahun '.$tahun.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Diklat Teknis A.n. '.$nama.', Tahun '.$tahun.' gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
 
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function editdiktek() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $no = $this->input->post('no');
      $tahun = $this->input->post('tahun');

      $data['diktek'] = $this->mpegawai->detaildiktek($nip, $no, $tahun)->result_array();
      $data['nip'] = $nip;
      $data['no'] = $no;
      $data['tahun'] = $tahun;
      $data['content'] = 'editdiktek';
      $this->load->view('template', $data);
    }
  }

  function editdiktek_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $no = addslashes($this->input->post('no'));
    $tahun_lama = addslashes($this->input->post('tahun_lama'));


    $namadiklat = strtoupper(addslashes($this->input->post('namadiklat')));
    $tahun = addslashes($this->input->post('tahun'));
    $penyelenggara = strtoupper(addslashes($this->input->post('penyelenggara')));  
    $tempat = strtoupper(addslashes($this->input->post('tempat')));  
    $lama = addslashes($this->input->post('lama'));
    $satuan_lama = addslashes($this->input->post('satuan_lama'));  
    if ($satuan_lama == 'BULAN') {
      $lamabulan = $lama;
      $lamahari = 0;
      $lamajam = 0;
    } else if ($satuan_lama == 'HARI') {
      $lamabulan = 0;
      $lamahari = $lama;
      $lamajam = 0;
    } else if ($satuan_lama == 'JAM') {
      $lamabulan = 0;
      $lamahari = 0;
      $lamajam = $lama;
    }

    $pejabatsk = strtoupper(addslashes($this->input->post('pejabatsk')));  
    $nosk = addslashes($this->input->post('nosk'));  
    $tglsk = tgl_sql($this->input->post('tglsk'));  

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datadik = array(      
      'nip'                => $nip,
      'nama_diklat_teknis' => $namadiklat,
      'tahun'              => $tahun,
      'instansi_penyelenggara'   => $penyelenggara,
      'tempat'             => $tempat,
      'lama_bulan'         => $lamabulan,
      'lama_hari'          => $lamahari,
      'lama_jam'           => $lamajam,
      'pejabat_sk'         => $pejabatsk,
      'no_sk'              => $nosk,
      'tgl_sk'             => $tglsk,
      'updated_at'         => $tgl_aksi,
      'updated_by'         => $user
      );

    $where = array(
      'nip'    => $nip,
      'no'     => $no,
      'tahun'  => $tahun_lama
    );

    $nama = $this->mpegawai->getnama($nip);

      if ($this->mpegawai->edit_diktek($where, $datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Teknis PNS A.n. <u>'.$nama.'</u> berhasil dirubah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Teknis PNS A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function showtambahsutri() {
    //$nip = $this->input->post('nip'); // jika menggunakan metode post pada ajax
    $nip = $this->input->get('nip'); 
    ?>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      });

      //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
    </script>
    <div class="panel panel-info" style='width :850px'>
      <!-- Default panel contents -->
      <?php
      $jnskel = $this->mpegawai->getjnskel($nip);
        if ($jnskel == 'LAKI-LAKI') {
          $ketsutri = "Istri";
        } else if ($jnskel == 'PEREMPUAN') {
          $ketsutri = "Suami";
        }
      ?>
      <div class="panel-heading" align='center'><b>Tambah <?php echo $ketsutri; ?></b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwykel'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pegawai/tambahsutri_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <table class="table table-condensed table-hover">        
        <tr class='danger'>
          <td align='right' width='150'>Nama <?php echo $ketsutri; ?> :</td>
          <td colspan='3'><input type="text" name="namasutri" size='40' maxlength='50' required /></td>
        </tr>
        <tr class='danger'>
          <td align='right'>Tempat Lahir :</td>
          <td><input type="text" name="tmplahir" size='30' maxlength='30' required /></td>        
          <td align='right' width='150'>Tanggal Lahir :</td>
          <td><input type="text" name="tgllahir" class="tanggal" size='15' maxlength='10' required />
	  <small>dd-mm-yyyy (contoh : 31-01-1982)</small>
	  </td>
        </tr>
        <tr class='danger'>
          <td align='right'>No. Akta Nikah :</td>
          <td><input type="text" name="aktanikah" size='30' maxlength='100' required /></td>
          <td align='right'>Tanggal Nikah :</td>
          <td><input type="text" name="tglnikah" class="tanggal" size='15' maxlength='10' required />
	  <small>dd-mm-yyyy (contoh : 31-12-2012)</small>
	  </td>
        </tr>
        <tr class='danger'>
          <td align='right'>Pekerjaan :</td>
          <td colspan='3'>
            <select name="pekerjaan" id="pekerjaan" required >
              <option value='' selected>-- Pilih Pekerjaan --</option>
              <option value='PEGAWAI NEGERI'>PEGAWAI NEGERI</option>
              <option value='PEGAWAI SWASTA'>PEGAWAI SWASTA</option>              
              <option value='WIRASWASTA'>WIRASWASTA</option>
              <option value='HONORER'>HONORER</option>
              <option value='RUMAH TANGGA'>RUMAH TANGGA</option>
            </select>
          </td>
        </tr>
        <tr class='danger'>
          <td align='right'>Status :</td>
          <td>
            <select name="statuskawin" id="statuskawin" required >
              <option value='' selected>-- Pilih Status --</option>
              <option value='MENIKAH'>MENIKAH</option>
              <option value='JANDA/DUDA'>JANDA / DUDA</option>
            </select>
          </td>
          <td align='right'>Status Hidup :</td>
          <td><input id="statushidup" name="statushidup" type="checkbox" value="YA" checked="checked">
          </td>
        </tr>
        <tr class='success'>
          <td align='right'>NIP <?php echo $ketsutri; ?> (Jika PNS):</td>
          <td><input type="text" name="nipsutri"  size='25' maxlength='18' /></td>
          <td align='right'>No. Kartu <?php echo $ketsutri; ?> :</td>
          <td><input type="text" name="nokarisu" size='20' maxlength='15' /></td>
        </tr>
        <tr class='success'>
          <td align='right'>Tanggal Cerai :</td>
          <td><input type="text" name="tglcerai" class="tanggal" size='15' maxlength='10' /></td>
          <td align='right'>No. Akta Cerai :</td>
          <td><input type="text" name="aktacerai" size='40' maxlength='50' /></td>
        </tr>        
        <tr class='success'>
          <td align='right'>Tanggal Meninggal :</td>
          <td><input type="text" name="tglmeninggal" class="tanggal" size='15' maxlength='10' /></td>
          <td align='right'>No. Akta Meninggal :</td>
          <td><input type="text" name="aktameninggal" size='40' maxlength='50' /></td>
        </tr>
	<tr>
		<td colspan='3'>
		<small> Catatan : 
			<br/>- Warna merah wajib diisi
			<br/>- Warna hijau boleh dikosongkah
			<br/>- Format tanggal : dd-mm-yyyy
		</small>
		</td>
	</tr>
        <tr>
          <td align='right' colspan='4'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
                </button>
          </td>
        </tr>
      </table>
      </form>
    </div>
    <?php
  }

  function tambahsutri_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $namasutri = strtoupper(addslashes($this->input->post('namasutri')));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));  
    $aktanikah = addslashes($this->input->post('aktanikah'));  
    $tglnikah = tgl_sql($this->input->post('tglnikah'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));

    $sutri_ke = $this->mpegawai->cek_jmlsutri($nip)+1;

    $statuskawin = addslashes($this->input->post('statuskawin'));
    $statushidup = addslashes($this->input->post('statushidup'));

    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }

    $nipsutri = addslashes($this->input->post('nipsutri'));  
    $nokarisu = addslashes($this->input->post('nokarisu'));  
    $tglcerai = $this->input->post('tglcerai');
    $aktacerai = addslashes($this->input->post('aktacerai'));  
    $tglmeninggal = $this->input->post('tglmeninggal');
    $aktameninggal = addslashes($this->input->post('aktameninggal'));  

    if ($tglcerai != '') {
      $tglcerai = tgl_sql($tglcerai);
    } else {
      $tglcerai = null;
    }

    if ($tglmeninggal != '') {
      $tglmeninggal = tgl_sql($tglmeninggal);
    } else {
      $tglmeninggal = null;
    }

    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datasutri = array(      
      'nip'               => $nip,
      'nama_sutri'        => $namasutri,
      'sutri_ke'          => $sutri_ke,
      'tgl_nikah'         => $tglnikah,
      'no_akta_nikah'     => $aktanikah,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'pekerjaan'         => $pekerjaan,
      'no_karisu'         => $nokarisu,
      'nip_sutri'         => $nipsutri,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tgl_cerai'         => $tglcerai,
      'no_akta_cerai'     => $aktacerai,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $nama = $this->mpegawai->getnama($nip);
    $jnskel = $this->mpegawai->getjnskel($nip);
    if ($jnskel == 'LAKI-LAKI') {
      $ketsutri = "Istri";
    } else if ($jnskel == 'PEREMPUAN') {
      $ketsutri = "Suami";
    }

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpegawai->cek_sutri($nip, $tglnikah) == 0) {
      if ($this->mpegawai->input_sutri($datasutri))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data '.$ketsutri.' PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data '.$ketsutri.' PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();      
    //untuk anak
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function hapussutri_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $sutri_ke = addslashes($this->input->post('sutri_ke'));
    $tgl_nikah = addslashes($this->input->post('tgl_nikah'));

    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'sutri_ke' => $sutri_ke,
                   'tgl_nikah' => $tgl_nikah
             );
    
    $nama = $this->mpegawai->getnama($nip);
    $jnskel = $this->mpegawai->getjnskel($nip);
    if ($jnskel == 'LAKI-LAKI') {
      $ketsutri = "Istri";
    } else if ($jnskel == 'PEREMPUAN') {
      $ketsutri = "Suami";
    }

    // cek apakah data yang akan dihapus ada
    if ($this->mpegawai->cek_adasutri($nip, $sutri_ke, $tgl_nikah) != 0) {
      if ($this->mpegawai->hapus_sutri($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data '.$ketsutri.' PNS A.n. <u>'.$nama.'</u> berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Data '.$ketsutri.' PNS A.n. <u>'.$nama.'</u> gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
 
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();      
    //untuk anak
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function editsutri() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $sutri_ke = $this->input->post('sutri_ke');
      $tgl_nikah = $this->input->post('tgl_nikah');

      $data['sutri'] = $this->mpegawai->detailsutri($nip, $sutri_ke, $tgl_nikah)->result_array();
      $data['nip'] = $nip;
      $data['sutri_ke'] = $sutri_ke;
      $data['tgl_nikah'] = $tgl_nikah;
      $data['content'] = 'editsutri';
      $this->load->view('template', $data);
    }
  }

  function editsutri_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $sutri_ke = addslashes($this->input->post('sutri_ke'));
    $tgl_nikah_lama = addslashes($this->input->post('tgl_nikah_lama'));

    $namasutri = strtoupper(addslashes($this->input->post('namasutri')));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));  
    $aktanikah = addslashes($this->input->post('aktanikah'));  
    $tglnikah = tgl_sql($this->input->post('tglnikah'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));   

    $statuskawin = $this->input->post('statuskawin');
    $statushidup = addslashes($this->input->post('statushidup'));

    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }

    $nipsutri = addslashes($this->input->post('nipsutri'));  
    $nokarisu = addslashes($this->input->post('nokarisu'));  
    $tglcerai = $this->input->post('tglcerai');
    $aktacerai = addslashes($this->input->post('aktacerai'));  
    $tglmeninggal = $this->input->post('tglmeninggal');
    $aktameninggal = addslashes($this->input->post('aktameninggal'));  

    if ($tglcerai != '') {
      $tglcerai = tgl_sql($tglcerai);
    } else {
      $tglcerai = null;
    }

    if ($tglmeninggal != '') {
      $tglmeninggal = tgl_sql($tglmeninggal);
    } else {
      $tglmeninggal = null;
    }

    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datasutri = array(      
      'nama_sutri'        => $namasutri,
      'no_akta_nikah'     => $aktanikah,
      'tgl_nikah'         => $tglnikah,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'pekerjaan'         => $pekerjaan,
      'no_karisu'         => $nokarisu,
      'nip_sutri'         => $nipsutri,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tgl_cerai'         => $tglcerai,
      'no_akta_cerai'     => $aktacerai,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'updated_at'        => $tgl_aksi,
      'updated_by'        => $user
      );

    $nama = $this->mpegawai->getnama($nip);
    $jnskel = $this->mpegawai->getjnskel($nip);
    if ($jnskel == 'LAKI-LAKI') {
      $ketsutri = "Istri";
    } else if ($jnskel == 'PEREMPUAN') {
      $ketsutri = "Suami";
    }

    $where = array(
      'nip'    => $nip,
      'sutri_ke'     => $sutri_ke,
      'tgl_nikah'  => $tgl_nikah_lama
    );

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mpegawai->edit_sutri($where, $datasutri))   
    {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data '.$ketsutri.' PNS A.n. <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data '.$ketsutri.' PNS A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();      
    //untuk anak`
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function showtambahanak() {
    $nip = $this->input->get('nip'); // jika menggunakan metode get
    //$nip = $this->input->post('nip');
    ?>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      });

      //validasi textbox khusus angka
      function validAngka(a)
      {
        if(!/^[0-9.]+$/.test(a.value))
        {
        a.value = a.value.substring(0,a.value.length-1000);
        }
      }
    </script>
    <div class="panel panel-info" style='width :850px'>
      <!-- Default panel contents -->
      <?php
      $jnskel = $this->mpegawai->getjnskel($nip);
        if ($jnskel == 'LAKI-LAKI') {
          $ketibubapak = "Ibu";
        } else if ($jnskel == 'PEREMPUAN') {
          $ketibubapak = "Bapak";
        }
      ?>
      <div class="panel-heading" align='center'><b>Tambah Anak</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwykel'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pegawai/tambahanak_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <table class="table table-condensed table-hover">        
        <tr>
          <td align='right' width='150'>Nama Anak :</td>
          <td colspan='3'><input type="text" name="namaanak" size='40' maxlength='50' required /></td>
        </tr>
        <tr>
          <td align='right'>Tempat Lahir :</td>
          <td><input type="text" name="tmplahir" size='30' maxlength='30' required /></td>        
          <td align='right' width='150'>Tanggal Lahir :</td>
          <td><input type="text" name="tgllahir" class="tanggal" size='15' maxlength='10' required /></td>
        </tr>
        <tr>
          <td align='right'>Nama <?php echo $ketibubapak; ?></td>
          <td>          
          <select name="sutri_ke" id="sutri_ke" required >
          <option value='' selected>-- Pilih <?php echo $ketibubapak; ?> --</option>
            <?php
              $ibubapak = $this->mpegawai->getibubapak($nip)->result_array();
              foreach($ibubapak as $ib)
              {                
                  echo "<option value='".$ib['sutri_ke']."'>".$ib['nama_sutri']."</option>";
              }
            ?>
          </select>
          </td>
          <td align='right'>Jenis Kelamin:</td>
          <td>
            <select name="jnskel" id="jnskel" required >
              <option value='' selected>-- Pilih Jenis Kelamin --</option>
              <option value='PRIA'>PRIA</option>
              <option value='WANITA'>WANITA</option>              
            </select>
          </td>
        </tr>
        <tr>
          <td align='right'>Status Anak:</td>
          <td colspan='3'>
            <select name="status" id="status" required >
              <option value='' selected>-- Pilih Status --</option>
              <option value='KANDUNG'>KANDUNG</option>
              <option value='TIRI'>TIRI</option>              
              <option value='ANGKAT'>ANGKAT</option>
            </select>
          </td>
        </tr>
        <tr>
          <td align='right'>Status Hidup :</td>
          <td colspan='3'><input id="statushidup" name="statushidup" type="checkbox" value="YA" checked="checked" />
          </td>
        </tr>        
        <tr>
          <td align='right' colspan='4'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
                </button>
          </td>
        </tr>
      </table>
      </form>
    </div>
    <?php
  }

  function tambahanak_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $namaanak = strtoupper(addslashes($this->input->post('namaanak')));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));  
    $sutri_ke = addslashes($this->input->post('sutri_ke'));  
    $jnskel = addslashes($this->input->post('jnskel'));
    $status = addslashes($this->input->post('status'));
    $statushidup = addslashes($this->input->post('statushidup'));

    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }
    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $dataanak = array(      
      'nip'               => $nip,
      'nama_anak'         => $namaanak,
      'fid_sutri_ke'      => $sutri_ke,
      'jns_kelamin'       => $jnskel,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'status'            => $status,
      'status_hidup'      => $statushidup,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $nama = $this->mpegawai->getnama($nip);

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpegawai->cek_anak($nip, $namaanak, $tgllahir) == 0) {
      if ($this->mpegawai->input_anak($dataanak))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Anak PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Anak PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();      
    //untuk anak
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function hapusanak_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $nama_anak = addslashes($this->input->post('nama_anak'));
    $tgl_lahir = addslashes($this->input->post('tgl_lahir'));

    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'nama_anak' => $nama_anak,
                   'tgl_lahir' => $tgl_lahir
             );
    
    $nama = $this->mpegawai->getnama($nip);
    // cek apakah data yang akan dihapus ada
    if ($this->mpegawai->cek_adaanak($nip, $nama_anak, $tgl_lahir) != 0) {
      if ($this->mpegawai->hapus_anak($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Anak PNS A.n. <u>'.$nama.'</u> berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Data Anak PNS A.n. <u>'.$nama.'</u> gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
 
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();      
    //untuk anak
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function editanak() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $nama_anak = $this->input->post('nama_anak');
      $tgl_lahir = $this->input->post('tgl_lahir');

      $data['anak'] = $this->mpegawai->detailanak($nip, $nama_anak, $tgl_lahir)->result_array();
      $data['nip'] = $nip;
      $data['nama_anak'] = $nama_anak;
      $data['tgl_lahir'] = $tgl_lahir;
      $data['content'] = 'editanak';
      $this->load->view('template', $data);
    }
  }

  function editanak_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $nama_anak_lama = addslashes($this->input->post('nama_anak_lama'));
    $tgl_lahir_lama = addslashes($this->input->post('tgl_lahir_lama'));

    $namaanak = strtoupper(addslashes($this->input->post('namaanak')));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));  
    $sutri_ke = addslashes($this->input->post('sutri_ke'));  
    $jnskel = addslashes($this->input->post('jnskel'));
    $status = addslashes($this->input->post('status'));   
    $statushidup = addslashes($this->input->post('statushidup'));

    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }  
    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $dataanak = array(      
      'nama_anak'         => $namaanak,
      'fid_sutri_ke'      => $sutri_ke,
      'jns_kelamin'       => $jnskel,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'status'            => $status,
      'status_hidup'      => $statushidup,
      'updated_at'        => $tgl_aksi,
      'updated_by'        => $user
      );

    $nama = $this->mpegawai->getnama($nip);
    
    $where = array(
      'nip'        => $nip,
      'nama_anak'  => $nama_anak_lama,
      'tgl_lahir'  => $tgl_lahir_lama
    );

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mpegawai->edit_anak($where, $dataanak))   
    {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data Anak PNS A.n. <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data Anak PNS A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $nip = $this->input->post('nip');
    // untuk sutri
    $data['pegrwyst'] = $this->mpegawai->rwyst($nip)->result_array();      
    //untuk anak`
    $data['pegrwyanak'] = $this->mpegawai->rwyanak($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwykel';
    $this->load->view('template', $data);
  }

  function tampilunkernomppk()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['tahun'] = $this->mpegawai->gettahunppk()->result_array();
      $data['content'] = 'tampilunkernomppk';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template',$data);
    }
  }

  function cariunkernomppk() {
    $idunker = $this->input->get('idunker');
    $tahun = $this->input->get('thn');

    $sqlcari = $this->mpegawai->carirekapunkerppk($idunker, $tahun)->result_array();
    $jml = count($this->mpegawai->jmlunkerppk($idunker, $tahun)->result_array());
    $jmlpeg = $this->munker->getjmlpeg($idunker);
    $persen = round(($jml/$jmlpeg)*100, 2);
    
    if ($persen <= 25) {
      $color = 'progress-bar progress-bar-danger progress-bar-striped';
    } else if (($persen > 25) AND ($persen < 75)) {
      $color = 'progress-bar progress-bar-warning progress-bar-striped';
    } else if ($persen >= 75) {
      $color = 'progress-bar progress-bar-success progress-bar-striped';
    }	

    ?>
    <br />
    <div class="progress">
      <div class="<?php echo $color; ?>" role="progressbar" aria-valuenow="<?php echo $jml; ?>" aria-valuemin="0" aria-valuemax="<?php echo $jmlpeg; ?>" style="<?php echo 'width :'.$persen.'%'; ?>;">
          <?php echo $persen.' % Complete'; ?>
      </div>
    </div>
    
    <?php 

    if ($jml != 0) {
      echo '<br/>';
      echo "<div align='right'>";
      ?>
      <form method="POST" action="../pegawai/cetaknomppkperunker" target='_blank'>                
            <input type='hidden' name='idunker' id='idunker' maxlength='18' value='<?php echo $idunker; ?>'>
            <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $tahun; ?>'>
            <button type="submit" class="btn btn-success btn-sm">
              <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Nominatif PPK
            </button>
          </form>
      <?php
      echo "<?div><br/>";
      echo '<table class="table table-bordered table-hover">';
      echo "
      <tr class='info'>
        <td align='center' rowspan='2'><b>No</b></td>
        <td align='center' width='220' rowspan='2'><b>NIP | Nama</b></td>
        <td align='center' width='520' rowspan='2'><b>Jabatan</b></td>
        <td align='center' width='120' rowspan='2'><b>Nilai SKP</b></td>
        <td align='center' width='120' colspan='7'><b>Prilaku</b></td>
        <td align='center' width='100' rowspan='2'><b>Nilai Prestasi Kerja</b></td>
      </tr>
      <tr class='info'>        
        <td align='center' width='50'><b>Orientasi<br />Pelayanan</b></td>
        <td align='center' width='50'><b>Inte<br />gritas</b></td>
        <td align='center' width='50'><b>Komit<br />men</b></td>
        <td align='center' width='50'><b>Disi<br />plin</b></td>
        <td align='center' width='50'><b>Kerja<br />sama</b></td>
        <td align='center' width='50'><b>Kepemim<br />pinan</b></td>
        <td align='center' width='100'><b>Nilai Prilaku Kerja</b></td>
      </tr>
      ";

      $no = 1;
      foreach($sqlcari as $v):          
        echo "<tr><td align='center'>".$no."</td>";
        echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';

        if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        }

        echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab),'</td>';
        if ($v['tahun'] != null) {
          $sebutanskp = $this->mpegawai->getnilaiskp($v['nilai_skp']);
          echo '<td align=center>',$v['nilai_skp'],'<br />',$sebutanskp,'</td>';
          echo '<td align=center>',$v['orientasi_pelayanan'],'</td>';
          echo '<td align=center>',$v['integritas'],'</td>';
          echo '<td align=center>',$v['komitmen'],'</td>';
          echo '<td align=center>',$v['disiplin'],'</td>';
          echo '<td align=center>',$v['kerjasama'],'</td>';
          echo '<td align=center>',$v['kepemimpinan'],'</td>';
          $sebutanprilaku = $this->mpegawai->getnilaiskp($v['nilai_prilaku_kerja']);
          echo '<td align=center>',round($v['nilai_prilaku_kerja'], 2),'<br />',$sebutanprilaku,'</td>';
          $sebutanprestasi = $this->mpegawai->getnilaiskp($v['nilai_prestasi_kerja']);
          echo '<td align=center>',round($v['nilai_prestasi_kerja'], 2),'<br />',$sebutanprestasi,'</td>';

          echo "</td>";
          echo "<tr/>";
        } else {
          echo "<td class='danger' colspan='9'></td>";
          echo "<tr/>";
        }

      $no++;
      endforeach;
      echo "</table>";      
    }
  }

  public function cetaknomppkperunker()  
  {
    $idunker = $this->input->post('idunker');
    $thn = $this->input->post('tahun');
    $res['data'] = $this->datacetak->datanomppkperunker();
    $this->load->view('cetaknomppkperunker',$res);    
  }

  function tampilrekapunkerppk()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {      
      $data['tahun'] = $this->mpegawai->gettahunppk()->result_array();
      $data['content'] = 'tampilrekapunkerppk';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template',$data);
    }
  }

  function carirekapunkerppk()
  {
    $tahun = $this->input->get('thn');
    $sopd = $this->munker->unker()->result_array();
    $total = $this->mpegawai->get_jmlppk($tahun);

    echo "<br />
      <table class='table table-condensed'>
      <div class='well well-sm'><b>TOTAL : ".$total." Data</b></div>  	
      <tr class='danger'>
        <td align='center' width='30'><b>No.</b></td>
        <td align='center' width='450'><b>Nama Unit Kerja</b></td>
        <td align='center' width='650'><b>Progress</b></td>
      </tr>
    </table>";
  
    
    echo "<div style='padding:3px;overflow:auto;width:99%;height:280px;border:1px solid white' >";
    echo "<table class='table table-condensed table-hover'>";
        $no = 1;
        foreach($sopd as $v):          

          $jml = count($this->mpegawai->jmlunkerppk($v['id_unit_kerja'], $tahun)->result_array());
          if ($jml != 0) {
            $jmlpeg = $this->munker->getjmlpeg($v['id_unit_kerja']);
            $persen = round(($jml/$jmlpeg)*100, 2);
          } else {
            $jmlpeg = 0;
            $persen = 0;
          }

          echo "<tr>";   
          echo "<td align='center' width='30'>$no</td>";
          echo '<td width=450>',$v['nama_unit_kerja'],'</td>';        
          //echo "<td align='center'>".$jml." / ".$jmlpeg." / ".$persen."</td>";
          echo "<td align='center'>";
          if ($persen <= 25) {
            $color = 'progress-bar progress-bar-danger progress-bar-striped';
          } else if (($persen > 25) AND ($persen < 75)) {
            $color = 'progress-bar progress-bar-warning progress-bar-striped';
          } else if ($persen >= 75) {
            $color = 'progress-bar progress-bar-success progress-bar-striped';
          }

          ?>
            <div class="progress">
              <div class="<?php echo $color; ?>" role="progressbar" aria-valuenow="<?php echo $jml; ?>" aria-valuemin="0" aria-valuemax="<?php echo $jmlpeg; ?>" style="<?php echo 'width :'.$persen.'%'; ?>;">
                  <?php echo $persen.' % Complete'; ?>
              </div>
            </div>
          <?php

          echo "</td>";
          echo "</tr>";
          $no++;
        endforeach;
    echo "</table>";
    echo "</div>";
  }  

  // Untuk Riwayat Workshop
  function showtambahws() {
    $nip = $this->input->get('nip');
    //$nip = $this->input->post('nip'); // jika menggunakan metode post pada ajax
    ?>

    <div class="panel panel-info" style='width :750px'>
      <!-- Default panel contents -->
      <div class="panel-heading" align='center'><b>TAMBAH WORKSHOP / SEMINAR / LAINNYA</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pegawai/rwydik'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pegawai/tambahws_aksi'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <table class="table table-condensed table-hover">
        <tr>        
          <td align='left' colspan='2'>
	  <small class="text-muted" style="color: red;">SELURUH DATA HARUS DIISI LENGKAP<br/>
          Untuk data tanggal harus dengan format hari-bulan-tahun (dd-mm-yyyy)</small>
          </td>
        </tr>
        <tr>
          <td width='260' align='right'>Nama :</td>
          <td><?php echo $this->mpegawai->getnama($nip); ?></td>
        </tr>
        <tr>
          <td align='right'>Nama Workshop / Seminar :</td>
          <td><input type="text" name="namaws" size='80' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tahun :</td>
          <td><input type="text" name="tahun" size="10" onkeyup="validAngka(this)" maxlength="4" required /></td>
        </tr>
        <tr>
          <td align='right'>Instansi Penyelenggara :</td>
          <td><input type="text" name="penyelenggara" size='50' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tempat :</td>
          <td><input type="text" name="tempat" size='40' maxlength='200' required /></td>
        </tr>
        <tr>
          <td align='right'>Tgl. Pelaksanaan :</td>
          <td><input type="text" name="tgl" class="tanggal" size='15' maxlength='10' required /> <small>Wajib Diisi dengan tanggal / hari pertama pelaksanaan (format: dd-mm-yyyy)</small></td>
        </tr>
        <tr>
          <td align='right'>Lama :</td>
          <td>
            <input type="text" name="lama" size='5' onkeyup="validAngka(this)" maxlength='3' />

            <select name="satuan_lama" id="satuan_lama" required >
              <option value='' selected>-- Pilih Satuan --</option>
              <option value='BULAN'>BULAN</option>
              <option value='HARI'>HARI</option>
              <option value='JAM'>JAM</option>
            </select>
          </td>
        </tr>
        <tr>
          <td rowspan='3' align='right'>Sertifikat :</td>
          <td>Pejabat&nbsp <input type="text" name="pejabatsk" size='50' maxlength='200' required /></td>
        </tr>
        <tr>
          <td>No. &nbsp&nbsp   <input type="text" name="nosk" size='30' maxlength='100' required /></td>
        </tr>
        <tr>
          <td>Tgl. &nbsp&nbsp  <input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' required /> <small>Wajib Diisi (format: dd-mm-yyyy)</small></td>
        </tr>
        <tr>
          <td align='right' colspan='2'>
                <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
                </button>
          </td>
        </tr>
      </table>
      </form>
    </div>
    <?php
  }

  function tambahws_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $namaws = strtoupper(addslashes($this->input->post('namaws')));
    $tahun = addslashes($this->input->post('tahun'));
    $penyelenggara = strtoupper(addslashes($this->input->post('penyelenggara')));  
    $tempat = strtoupper(addslashes($this->input->post('tempat')));
    $tgl = tgl_sql($this->input->post('tgl'));  
    $lama = addslashes($this->input->post('lama'));
    $satuan_lama = addslashes($this->input->post('satuan_lama'));  
    if ($satuan_lama == 'BULAN') {
      $lamabulan = $lama;
      $lamahari = 0;
      $lamajam = 0;
    } else if ($satuan_lama == 'HARI') {
      $lamabulan = 0;
      $lamahari = $lama;
      $lamajam = 0;
    } else if ($satuan_lama == 'JAM') {
      $lamabulan = 0;
      $lamahari = 0;
      $lamajam = $lama;
    }

    $pejabatsk = strtoupper(addslashes($this->input->post('pejabatsk')));  
    $nosk = strtoupper(addslashes($this->input->post('nosk')));  
    $tglsk = tgl_sql($this->input->post('tglsk'));  

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $dataws = array(      
      'nip'             => $nip,
      'nama_workshop'   => $namaws,
      'tahun'           => $tahun,
      'instansi_penyelenggara'   => $penyelenggara,
      'tempat'          => $tempat,
      'tanggal'         => $tgl,
      'lama_bulan '     => $lamabulan,
      'lama_hari'       => $lamahari,
      'lama_jam'        => $lamajam,
      'pejabat_sk'      => $pejabatsk,
      'no_sk'           => $nosk,
      'tgl_sk'          => $tglsk,
      'created_at'      => $tgl_aksi,
      'created_by'      => $user
      );

    $nama = $this->mpegawai->getnama($nip);

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpegawai->cek_ws($nip, $namaws, $tahun) == 0) {
      if ($this->mpegawai->input_ws($dataws))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Workshop / Seminar PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Workshop / Seminar PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();       
    
    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function hapusws_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $no = addslashes($this->input->post('no'));
    $tahun = addslashes($this->input->post('tahun'));
    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'no' => $no,
                   'tahun' => $tahun
             );
    
    // cek apakah data yang akan dihapus ada
    if ($this->mpegawai->cek_adaws($nip, $no, $tahun) != 0) {
      if ($this->mpegawai->hapus_ws($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Riwayat Workshop / Seminar A.n. '.$nama.', Tahun '.$tahun.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Riwayat Workshop / Seminar A.n. '.$nama.', Tahun '.$tahun.' gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
 
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();       
    

    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  function editws() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $no = $this->input->post('no');
      $tahun = $this->input->post('tahun');

      $data['diktek'] = $this->mpegawai->detailws($nip, $no, $tahun)->result_array();
      $data['nip'] = $nip;
      $data['no'] = $no;
      $data['tahun'] = $tahun;
      $data['content'] = 'editws';
      $this->load->view('template', $data);
    }
  }

  function editws_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $no = addslashes($this->input->post('no'));
    $tahun_lama = addslashes($this->input->post('tahun_lama'));

    $namaws = strtoupper(addslashes($this->input->post('namaws')));
    $tahun = addslashes($this->input->post('tahun'));
    $penyelenggara = strtoupper(addslashes($this->input->post('penyelenggara')));  
    $tempat = strtoupper(addslashes($this->input->post('tempat')));  
    $tgl = tgl_sql($this->input->post('tgl'));
    $lama = addslashes($this->input->post('lama'));
    $satuan_lama = addslashes($this->input->post('satuan_lama'));  
    if ($satuan_lama == 'BULAN') {
      $lamabulan = $lama;
      $lamahari = 0;
      $lamajam = 0;
    } else if ($satuan_lama == 'HARI') {
      $lamabulan = 0;
      $lamahari = $lama;
      $lamajam = 0;
    } else if ($satuan_lama == 'JAM') {
      $lamabulan = 0;
      $lamahari = 0;
      $lamajam = $lama;
    }

    $pejabatsk = strtoupper(addslashes($this->input->post('pejabatsk')));  
    $nosk = addslashes($this->input->post('nosk'));  
    $tglsk = tgl_sql($this->input->post('tglsk'));  

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datadik = array(      
      'nip'                => $nip,
      'nama_workshop'      => $namaws,
      'tahun'              => $tahun,
      'instansi_penyelenggara'   => $penyelenggara,
      'tempat'             => $tempat,
      'tanggal'             => $tgl,
      'lama_bulan'         => $lamabulan,
      'lama_hari'          => $lamahari,
      'lama_jam'           => $lamajam,
      'pejabat_sk'         => $pejabatsk,
      'no_sk'              => $nosk,
      'tgl_sk'             => $tglsk,
      'updated_at'         => $tgl_aksi,
      'updated_by'         => $user
      );

    $where = array(
      'nip'    => $nip,
      'no'     => $no,
      'tahun'  => $tahun_lama
    );

    $nama = $this->mpegawai->getnama($nip);

      if ($this->mpegawai->edit_ws($where, $datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Workshop / Seminar PNS A.n. <u>'.$nama.'</u> berhasil dirubah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Workshop / Seminar PNS A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    
    // untuk diklat struktural
    $data['pegrwyds'] = $this->mpegawai->rwyds($nip)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpegawai->rwydf($nip)->result_array();       
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpegawai->rwydt($nip)->result_array();       
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpegawai->rwyws($nip)->result_array();       
    $data['nip'] = $nip;
    $data['content'] = 'rwydik';
    $this->load->view('template', $data);
  }

  // Akhir Riwayat Workshop

  // Awal riwayat Hukuman Disiplin
  function rwyhukdis()
  {    
    $nip = $this->input->post('nip');    
    $data['pegrwyhd'] = $this->mpegawai->rwyhd($nip)->result_array();       
    $data['nip'] = $nip;
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
    $data['content'] = 'rwyhd';
    $this->load->view('template', $data);
  }

  // AWAL UPDATE PHOTO  
  function updatephoto()
  {
    $nip = $this->input->post('nip');
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['nip'] = $nip;   
    $data['content'] = 'updatephoto';
    $this->load->view('template', $data);
  }
  // AKHIR UPDATE PHOTO 

  function rwytpp()
  {    
    $nip = $this->input->post('nip');
    $data['pegrwyabs'] = $this->mpegawai->rwyabsensi($nip)->result_array();
    $data['pegrwykin'] = $this->mpegawai->rwykinerja($nip)->result_array();
    $data['pegrwytpp'] = $this->mpegawai->rwytpp($nip)->result_array();
    $data['pegrwygaji'] = $this->mpegawai->rwygaji($nip)->result_array();
    $data['nip'] = $nip;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'rwytpp';
    $this->load->view('template', $data);
  }

  function updateinfopersonal() {
    $nip = addslashes($this->input->post('nip'));

    $ktp = addslashes($this->input->post('ktp'));
    $npwp = addslashes($this->input->post('npwp'));
    $telepon = addslashes($this->input->post('telepon'));
    $email = addslashes($this->input->post('email'));
    $ptkp = addslashes($this->input->post('id_status_ptkp'));
    $alamat_rumah = addslashes($this->input->post('alamat_rumah'));
    $id_kel_rumah = addslashes($this->input->post('id_kel_rumah'));
    $alamat_ktp = addslashes($this->input->post('alamat_ktp'));
    $id_kel_ktp = addslashes($this->input->post('id_kel_ktp'));
    $whatsapp = addslashes($this->input->post('whatsapp'));
    $instagram = addslashes($this->input->post('instagram'));
    $twitter = addslashes($this->input->post('twitter'));
    $facebook = addslashes($this->input->post('facebook'));
    $youtube = addslashes($this->input->post('youtube'));
    $google = addslashes($this->input->post('google'));

   
    $dataperso = array(      
      'alamat'                => $alamat_rumah,
      'fid_alamat_kelurahan'  => $id_kel_rumah,
      'alamat_ktp'            => $alamat_ktp,
      'fid_kelurahan_ktp'     => $id_kel_ktp,
      'telepon'               => $telepon,
      'no_ktp'                => $ktp,
      'no_npwp'               => $npwp,
      'email'                 => $email,
      'fid_status_ptkp'       => $ptkp,
      'whatsapp'              => $whatsapp,
      'instagram'             => $instagram,
      'twitter'               => $twitter,
      'facebook'              => $facebook,
      'youtube'               => $youtube,
      'google'                => $google
      );

    $where = array(
      'nip'    => $nip
    );

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mpegawai->edit_peg($where, $dataperso))
    {
      $data['pesan'] = '<b>Sukses</b>, Data Informasi Personal <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data Informasi Personal <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }

    $nip = $this->input->post('nip');
    $data['peg'] = $this->mpegawai->detail($nip)->result_array();
    $data['content'] = 'pegdetail';
    $this->load->view('template', $data);
  }

  function hapusrwyjab_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $id = addslashes($this->input->post('id'));
    $where = array('nip' => $nip,
                   'id' => $id
             );
    
    $nama = $this->mpegawai->getnama($nip);
    if ($this->mpegawai->hapus_rwyjab($where)) {
       $data['pesan'] = '<b>Sukses</b>, Riwayat Jabatan A.n. '.$nama.' berhasil dihapus';
       $data['jnspesan'] = 'alert alert-success';
    } else {
       $data['pesan'] = '<b>Gagal</b>, Riwayat Jabatan A.n. '.$nama.' gagal dihapus';
       $data['jnspesan'] = 'alert alert-danger';
    }

    $nip = $this->input->post('nip');
    $data['pegrwyjab']   = $this->mpegawai->rwyjab($nip)->result_array();
    $data['pegrwyplt']   = $this->mpegawai->rwyplt($nip)->result_array();
    $data['pegrwypokja'] = $this->mpegawai->rwypokja($nip)->result_array();
    $data['nip'] = $nip;
    $data['content'] = 'rwyjab';
    $this->load->view('template', $data);
  }

  // PROGRESS PDM MYSAPK
  function tampilprogresspdm()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['tgllap'] = $this->mpegawai->gettgllap_pdm()->result_array();
      $data['content'] = 'tampilprogresspdm';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template',$data);
    }
  }
 
  function warnapdm($status) {
        if ($status == "TRUE") {
                return "<td align=center class='success'><span class='fa fa-check' style='color:green;'></span></td>";
        } else if ($status == "FALSE") {
                return "<td align=center class='danger'><span class='fa fa-times' style='color:red;'></span></td>";
        }
	//return $ret;
  }

  function cariprogrsspdm() {
    $idunker = $this->input->get('idunker');
    $tl = $this->input->get('tl');

    $sqlcari = $this->mpegawai->carirekapprogresspdm($idunker, $tl)->result_array();
    $jml = count($this->mpegawai->carirekapprogresspdm($idunker, $tl)->result_array());
    $jmlpeg = $this->munker->getjmlpeg($idunker);
    $persen = round(($jml/$jmlpeg)*100, 2);

    if ($persen <= 25) {
      $color = 'progress-bar progress-bar-danger progress-bar-striped';
    } else if (($persen > 25) AND ($persen < 75)) {
      $color = 'progress-bar progress-bar-warning progress-bar-striped';
    } else if ($persen >= 75) {
      $color = 'progress-bar progress-bar-success progress-bar-striped';
    }

    ?>
    <br />
    <!--
    <div class="progress">
      <div class="<?php echo $color; ?>" role="progressbar" aria-valuenow="<?php echo $jml; ?>" aria-valuemin="0" aria-valuemax="<?php echo $jmlpeg; ?>" style="<?php echo 'width :'.$persen.'%'; ?>;">
          <?php echo $persen.' % Complete'; ?>
      </div>
    </div>
    -->

    <?php

    if ($jml != 0) {
      echo '<br/>';
      echo '<table class="table table-bordered table-hover">';
      echo "
      <tr class='info'>
        <td align='center' rowspan='2'><b>No</b></td>
        <td align='center' width='220' rowspan='2'><b>NIP | Nama</b></td>
        <td align='center' width='520' rowspan='2'><b>Unit Verifikasi</b></td>
        <td align='center' width='50' rowspan='2'><b>Aktivasi Email</b></td>
        <td align='center' width='120' colspan='12'><b>HASIL PDM</b></td>
      </tr>
      <tr class='info'>
        <td align='center' width='50'><b>Data<br />Pribadi</b></td>
        <td align='center' width='50'><b>Golo<br/>ngan</b></td>
        <td align='center' width='50'><b>Pendi<br/>dikan</b></td>
        <td align='center' width='50'><b>Jaba<br/>tan</b></td>
        <td align='center' width='50'><b>PMK</b></td>
        <td align='center' width='50'><b>CPNS<br/>PNS</b></td>
        <td align='center' width='50'><b>Diklat</b></td>
        <td align='center' width='50'><b>Kelu<br/>arga</b></td>
        <td align='center' width='50'><b>SKP</b></td>
        <td align='center' width='50'><b>Peng<br/>hargaan</b></td>
        <td align='center' width='50'><b>Orga<br/>nisasi</b></td>
        <td align='center' width='50'><b>CLTN</b></td>
      </tr>
      ";

      $no = 1;
      foreach($sqlcari as $v):
        echo "<tr><td align='center'>".$no."</td>";
        echo '<td>NIP. ',$v['nippeg'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';
        echo '<td>',$v['unit_verifikator'],'</td>';
          echo $this->warnapdm($v['aktivasi']);
          echo $this->warnapdm($v['data_pribadi']);
          echo $this->warnapdm($v['golongan']);
          echo $this->warnapdm($v['pendidikan']);
          echo $this->warnapdm($v['jabatan']);
          echo $this->warnapdm($v['pmk']);
          echo $this->warnapdm($v['cpnspns']);
	  echo $this->warnapdm($v['diklat']);
	  echo $this->warnapdm($v['keluarga']);
	  echo $this->warnapdm($v['skp']);
	  echo $this->warnapdm($v['penghargaan']);
	  echo $this->warnapdm($v['organisasi']);
	  echo $this->warnapdm($v['cltn']);
        echo "<tr/>";
	$no++;
      endforeach;
      echo "</table>";
    }
  }
  
  // PROGRESS STATUS VAKSINASI
  function tampilstatusvaksinasi()
  {
    //cek priviledge session user -- nominatif_priv
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'tampilstatusvaksinasi';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template',$data);
    }
  }

  function caristatusvaksinasi() {
    $idunker = $this->input->get('idunker');

    $sqlcari = $this->mpegawai->caristatusvaksinasi($idunker)->result_array();
    $jml = count($this->mpegawai->caristatusvaksinasi($idunker)->result_array());
    $jmlpeg = $this->munker->getjmlpeg($idunker);
    $persen = round(($jml/$jmlpeg)*100, 2);

    if ($persen <= 25) {
      $color = 'progress-bar progress-bar-danger progress-bar-striped';
    } else if (($persen > 25) AND ($persen < 75)) {
      $color = 'progress-bar progress-bar-warning progress-bar-striped';
    } else if ($persen >= 75) {
      $color = 'progress-bar progress-bar-success progress-bar-striped';
    }
    
    $sdhlapor = 0;
    $laportdkvaksin = 0;
    $blmlapor = 0;
    $vaksin12 = 0;
    $blmvaksin2 = 0;

    if ($jml != 0) {
      echo '<br/>';
      echo '<table class="table table-bordered table-hover">';
      echo "
      <tr class='info'>
        <td align='center' width='20'><b>No</b></td>
        <td align='center' width='150'><b>NIP | Nama</b></td>
        <td align='center' width='50'><b>Status<br/>Vaksinasi</b></td>
	<td align='center' width='150'><b>Vaksinasi Pertama</b></td>
	<td align='center' width='150'><b>Vaksinasi Kedua</b></td>
        <td align='center' width='150'><b>Alasan <br/>(Bagi yang belum/tidak Vaksin)</b></td>
	<td align='center' width='120'><b>Tanggal Lapor</b></td>
      </tr>
      ";

      $no = 1;
      foreach($sqlcari as $v):
       	echo "<tr><td align='center'>".$no."</td>";
       	echo '<td>NIP. ',$v['nip'], '<br />', $v['nama'],'</td>';
        if ($v['status_vaksinasi'] == "SUDAH") {	
		echo "<td>".$v['status_vaksinasi']."</td>";
       	 	echo "<td>Tgl. Vaksin : ".tgl_indo($v['vaksin_pertama_tgl'])."<br/>Jenis Vaksin : ".$v['vaksin_pertama_jenis']."</td>";
		if (($v['vaksin_kedua_tgl'] != "1900-01-00") AND ($v['vaksin_kedua_jenis'] != "")) {
			echo "<td>Tgl. Vaksin : ".tgl_indo($v['vaksin_kedua_tgl'])."<br/>Jenis Vaksin : ".$v['vaksin_kedua_jenis']."</td>";
			$vaksin12++;
        	} else {
			echo "<td class='success'>BELUM VAKSIN Ke-2</td>";
			$blmvaksin2++;
		}
		echo "<td>".$v['alasan']."</td>";
		echo "<td>".tglwaktu_indo($v['created_at'])."</td>";
        	echo "<tr/>";
		$sdhlapor++;
	} else if ($v['status_vaksinasi'] == "BELUM") {
		echo "<td class='info'>".$v['status_vaksinasi']."</td>";
		echo "<td class='info' colspan='2'></td>";
		echo "<td class='info'>".$v['alasan']."</td>";
		echo "<td>".tglwaktu_indo($v['created_at'])."</td>";
		$laportdkvaksin++;
		$sdhlapor++;
	} else {
                echo "<td class='danger' colspan='5'>DATA TIDAK DITEMUKAN</td>";
		$blmlapor++;	
	}
	$no++;

      endforeach;
      echo "<div align='left'><H5>";
      echo "Jumlah PNS : ".$jmlpeg."<br/>";
      $jmllaporan = $sdhlapor+$blmlapor;
      echo "Jumlah Laporan : ".$jmllaporan."<br/>";
      echo "<span class='text text-danger'>Jumlah Belum Lapor : ".$blmlapor."</span><br/>";
      //echo "<span class='text text-info'>Jumlah Tidak Vaksin : ".$laportdkvaksin."</span><br/>";
      //echo "<span class='text text-success'>Jumlah Belum Vaksin ke-2 : ".$blmvaksin2."</span>";
      //echo "</H5></div>";

      echo "</table>";
    }
  }
}

/* End of file pegawai.php */
/* Location: ./application/controllers/pegawai.php */
