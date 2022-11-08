<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diklat extends CI_Controller {
  // function construct, disini digunakan untuk memanggil model mawal.php
public function __construct()
{
  parent::__construct();
  $this->load->helper('form');
  $this->load->helper('fungsitanggal');
  $this->load->helper('fungsipegawai');
  $this->load->helper('fungsiterbilang');
  $this->load->helper('text');
  $this->load->model('mDiklat','md');
  $this->load->model('mpegawai');
  $this->load->model('munker');
  $this->load->library('fpdf');
  // untuk login session
  if (!$this->session->userdata('nama'))
  {
    redirect('login');
  }
}


/*
######################## HALAMAN INPUT SYARAT DIKLAT #########################
*/
//VIEW HALAMAN SYARAT DIKLAT
public function syarat_diklat(){
  $data['content'] = 'diklat/syaratdiklat';
  $data['syarat_diklat']  = 'diklat/script/syarat_diklat';

  $this->load->view('template', $data);
}

// TAMPIL DATA SYARAT DIKLAT
public function get_syarat(){  
  $unkerid = $this->input->post('unkerid');
  $jabatanid =$this->input->post('jabatanid');
  
  $fetch_data = $this->md->fetch_datatable($unkerid, $jabatanid);
  $data = array();
  $no = $_POST['start'];
  foreach($fetch_data as $row) {
    $sub_array = array();
    $sub_array[] = $no+1;
    $sub_array[] = $row->nama_jabatan;
    $sub_array[] = $row->nama_syarat_diklat;
    $sub_array[] = $row->jenis_syarat_diklat ;
    //$sub_array[] = '<button type="button" class="btn btn-xs btn-success" onclick="apprv('.$row->id_syarat_diklat.')" data-toggle="modal" class="modal" data-target="#myModalApprv"><i class="glyphicon glyphicon-check"></i></button>';;
    $sub_array[] = '<button type="button" class="btn btn-xs btn-primary" onclick="edit('.$row->id_syarat_diklat.')" data-toggle="modal" class="modal" data-target="#myModalEdit"><i class="glyphicon glyphicon-edit"></i></button>';
    $sub_array[] = '<button type="button" class="btn btn-xs btn-danger" onclick="hapus('.$row->id_syarat_diklat.')"><i class="glyphicon glyphicon-trash"></i></button>';
    $data[] = $sub_array;
  $no++;
  }

  $output = array(
    'draw'  		  => intval($_POST['draw']),
    'recordsTotal' 	  => $this->md->get_all_data($unkerid, $jabatanid),
    'recordsFiltered' => $this->md->get_filtered_data($unkerid, $jabatanid),
    'data'			  => $data			
  );

  echo json_encode($output);
}

public function get_usul_diklat() {
  $unkerid = $this->input->post('unkerid');
  $checkjst = $this->input->post('checkjst');
  $checkstatus = $this->input->post('checkstatus');
  $tahun = $this->input->post('tahun');
  
  $fetch_data = $this->md->fetch_datatable_jf($unkerid, $checkjst,$checkstatus,$tahun);
  $data = array();
  $no = $_POST['start'];
  foreach($fetch_data as $row) {
    if($row->sts_apprv == 1 ? $setuju = 'selected' :$setuju = '');
    if($row->sts_apprv == 2 ? $inbox = 'selected' :$inbox = '');
    if($row->sts_apprv != 0 ? $dis = 'disabled' :$dis = '');
    if($row->sts_apprv == 0 ? $tidak = 'selected' : $tidak = '');
     
    $status  = "<select class='form-control' onchange='update_status(".$row->id_syarat_diklat.", this.value)'>
                  <option value='0' $tidak class='bg-danger'>TIDAK SETUJU</option>
                  <option value='1' $setuju>SETUJU</option>
                  <option value='2' $inbox class='bg-info'>DALAM PROSES BKPPD</option>
                </select>";
    $btn_hapus = '<a href="#" class="text-danger" onclick="hapus_usulan('.$row->id_syarat_diklat.')">
    					<i class="glyphicon glyphicon-trash"></i>
    				</a>';
    if($row->fid_jabatan != '') {				
   	$btn_sysc  = '| <a href="#" class="text-success" onclick="sysc_usulan('.$row->id_syarat_diklat.')">
    					<i class="glyphicon glyphicon-check"></i>
    				</a>';
    } else {
    $btn_sysc = '';
    }
   	
    $sub_array = array();
    $sub_array[] = $no+1;
    $sub_array[] = $row->nama_asn." <br> NIP.". $row->nip;
    $sub_array[] = $row->tupoksi;
    $sub_array[] = $row->unker;
    $sub_array[] = $row->nama_syarat_diklat;
    $sub_array[] = $row->jp;
    $sub_array[] = $row->penyelenggara;
    $sub_array[] = $row->tempat;
    $sub_array[] = $row->tahun;
    $sub_array[] = "Rp. ".nominal($row->biaya);
    $sub_array[] = $row->capaian;
    $sub_array[] = "<span class='msg'></span><br><textarea onBlur='update_catatan($row->id_syarat_diklat, this.value)' class='form-control' name='catatan' row='3' cols='100%' $dis>$row->ctt</textarea>";
    $sub_array[] = $status;
    $sub_array[] = $btn_hapus." ".$btn_sysc;
    $data[] = $sub_array;
  $no++;
  }

  $output = array(
    'draw'  		  => intval($_POST['draw']),
    'recordsTotal' 	  => $this->md->get_all_data_jf($unkerid, $checkjst, $checkstatus, $tahun),
    'recordsFiltered' => $this->md->get_filtered_data_jf($unkerid, $checkjst, $checkstatus, $tahun),
    'data'			  => $data			
  );

  echo json_encode($output);  
}

public function update_status() {
  $id = $this->input->post('getid');
  $val = $this->input->post('setdata');
  $set = [
    'sts_apprv' => $val
  ];
  $whr = [
    'id_syarat_diklat' => $id
  ];

  $send = $this->db->where($whr)->update('ref_syarat_diklat', $set);
  if($send) {
    $msg = "True";
  } else {
    $msg = "False";
  }
  echo json_encode($msg);
}

public function update_catatan() {
  $id = $this->input->post('id');
  $val = $this->input->post('data');
  $set = [
    'ctt' => $val
  ];
  $whr = [
    'id_syarat_diklat' => $id
  ];

  $send = $this->db->where($whr)->update('ref_syarat_diklat', $set);
  if($send) {
    $msg = "Tersimpan";
  } else {
    $msg = "Gagal Tersimpan";
  }
  echo json_encode($msg);
}

public function usul_diklat() {
  $nip = $this->input->post('bynip');
  $nama_diklat = $this->input->post('nama_diklat_usul', true);

  if(!empty($nama_diklat)){
    $data = [
      'nip' => $nip,
      'tupoksi' => $this->input->post('tupoksi'),
      'nama_syarat_diklat' => strtoupper($nama_diklat),
      'jenis_syarat_diklat' => 'TEKNIS FUNGSIONAL',
      'jp' => $this->input->post('jp'),
      'penyelenggara' => $this->input->post('penyelenggara'),
      'biaya' => $this->input->post('biaya'),
      'capaian' => $this->input->post('capaian'),
      'sts_apprv' => '2',
      'user_usul' => $this->input->post('user_usul') 
    ];

    $do_insert = $this->md->insert_usulan('ref_syarat_diklat', $data);
    if($do_insert) {
      $msg = ['sts' => 'ok', 'type' => 'success', 'content' => 'Usulan Berhasil Dikirim, Tunggu Persetujuan BKPPD!']; 
    } else {
      $msg = ['sts' => 'gagal', 'type' => 'error', 'content' => 'Usulan Gagal! Harap Isi Semua Form']; 
    }
  } else {
    $msg = ['sts' => 'error', 'type' => 'warning', 'content' => 'Nama Diklat Tidak Boleh Kosong.'];
  }

  echo json_encode($msg);
}

public function usul_diklat_struktural() {
  $nip = $this->input->post('bynip');
  $nama_diklat = $this->input->post('nama_diklat_usul', true);

  if(!empty($nama_diklat)){
    $data = [
      'nip' => $nip,
      'tupoksi' => $this->input->post('tupoksi'),
      'fid_jabatan' => $this->input->post('fid_jabatan'),
      'nama_syarat_diklat' => strtoupper($nama_diklat),
      'jenis_syarat_diklat' => $this->input->post('jns_syarat_diklat'),
      'jp' => $this->input->post('jp'),
      'penyelenggara' => $this->input->post('penyelenggara'),
      'biaya' => $this->input->post('biaya'),
      'capaian' => $this->input->post('capaian'),
      'tempat' => $this->input->post('tempat'),
      'tahun' => $this->input->post('tahun'),
      'sts_apprv' => '2',
      'user_usul' => $this->input->post('user_usul') 
    ];

    $do_insert = $this->md->insert_usulan('ref_syarat_diklat', $data);
    if($do_insert) {
      $msg = ['sts' => 'ok', 'type' => 'success', 'content' => 'Usulan Berhasil Dikirim, Tunggu Persetujuan BKPPD!']; 
    } else {
      $msg = ['sts' => 'gagal', 'type' => 'error', 'content' => 'Usulan Gagal! Harap Isi Semua Form']; 
    }
  } else {
    $msg = ['sts' => 'error', 'type' => 'warning', 'content' => 'Nama Diklat Tidak Boleh Kosong.'];
  }

  echo json_encode($msg);	
}

// EDIT DATA
public function editdata(){
  $id = $this->input->post('id');
  $data = $this->md->get_editdata('ref_syarat_diklat', $id)->result();
  echo json_encode($data);
}

// PROSES UPDATE DATA
public function updatedata(){
  $id = $this->input->post('id');
  $diklat = $this->input->post('diklat');
  $jnsjab = $this->input->post('jnsjab');
  $jab = $this->input->post('jab');

  $whr = array('id_syarat_diklat'=>$id);
    $data = array(
      'fid_jabatan' => $jab,
      'jenis_syarat_diklat' => $jnsjab,
      'nama_syarat_diklat' => $diklat
    );    
    $oke = $this->md->p_update($whr,$data, 'ref_syarat_diklat');  
  echo json_encode($oke);
}

//HAPUS BARIS DATA 
public function hapus_data(){
  $id=$this->input->post('id');
  $where = array('id_syarat_diklat' => $id);
  $this->md->hapus_datatable($where, 'ref_syarat_diklat');
}

//AMBIL DATA UNIT KERJA
public function get_unker(){
   $unkerselect = $this->md->getunker('ref_unit_kerjav2')->result();
  if(count($unkerselect)>0){
    $e_select = '';
    $e_select .= '<option value="0">-- Pilih Unit Kerja -- </option>';
    foreach ($unkerselect as $q) {
       $e_select .= '<option value="'.$q->id_unit_kerja.'">'.$q->nama_unit_kerja.'</option>';
    }
  }else{
        $e_select = '<option value="">Unit Kerja Kosong</option>';
  }

    echo json_encode($e_select); 
}

//AMBIL DATA JENIS JABATAN
public function get_jns_jabatan(){
   $unkerselect = $this->md->getjnsjabatan('ref_jenis_jabatan')->result();
  if(count($unkerselect)>0){
    $e_select = '';
    $e_select .= '<option value="0" selected>All</option>';
    foreach ($unkerselect as $q) {
       $e_select .= '<option value="'.$q->id_jenis_jabatan.'">'.$q->nama_jenis_jabatan.'</option>';
    }
  }else{
        $e_select = '<option value="">Jenis Jabatan Kosong</option>';
  }

    echo json_encode($e_select); 
}

//AMBIL DATA JABATAN STRUKTURAL
public function get_jabstruk(){
  $unker = $this->input->post('idunker');

  $jbs = $this->md->getjabstruk($unker)->result();
  if(count($jbs)>0){
    $j_select = '';
    $j_select .= '<option value="0">-- Select Jabatan Struktural -- </option>';
    foreach ($jbs as $r) {
       $j_select .= '<option value="'.$r->id_jabatan.'">'.$r->nama_jabatan.'</option>';
    }
    echo json_encode($j_select);
  }
}

//AMBIL DATA JABATAN FUNGSIONAL UMUM
public function get_jabfu(){
    $datajabfu= $this->md->getjabfu('ref_jabfu')->result();
    if(count($datajabfu)>0){
      $j_select = '';
      $j_select .= '<option value="0">-- Select Jabatan Fungsional -- </option>';
      foreach ($datajabfu as $r) {
         $j_select .= '<option value="'.$r->id_jabfu.'">'.$r->nama_jabfu.'</option>';
      }
      echo json_encode($j_select);
    }  
  }


//SAVE DATA DIKLAT
public function p_tambahdata(){
  $n_jab = $this->input->post('n_jab');
  $jnsjab = $this->input->post('jns_jab');
  $nm_dik = $this->input->post('nm_dik');

  $jmlbaris = $this->md->cekjab($n_jab)->num_rows();
  // $cekjabs = $this->md->cekjab($n_jab);
  if(empty($nm_dik)){
    $msg['pesan'] = '<script>swal({title:"Error", text: "Riwayat Diklat Belum Diisi!!!",showConfirmButton: false, type: "error", timer: 2000});</script>';
  }elseif($jnsjab == 'undefined'){
    $msg['pesan'] = '<script>swal({title:"Error", text: "Jenis Diklat Belum Dipilih!!!",showConfirmButton: false, type: "error", timer: 2000});</script>';
  }elseif($jnsjab == '1' && $jmlbaris <= 5){
    $msg['pesan'] = '<script>swal({title:"Error", text: "Max 5 Diklat Untuk Jabatan Struktural",showConfirmButton: true, type: "error", timer: 2000});</script>';
  }elseif(empty($n_jab)){
    $msg['pesan'] = '<script>swal({title:"Error", text: "Jabatan Belum Dipilih!!!",showConfirmButton: true, type: "error"});</script>';
  }else{
    // $msg['pesan'] = '<div class="alert alert-info"><b>Success!</b>, Data Telah Tersimpan</div>';
    $msg['pesan'] = '<script>swal({title:"Sukses", text: "1 Baris Data Telah Ditambahkan",showConfirmButton: false, type: "success", timer: 2000});</script>';
    $data = array(
      'fid_jabatan' => $n_jab,
      'nama_syarat_diklat' => $nm_dik,
      'jenis_syarat_diklat ' => $jnsjab
    );

    $this->md->p_insert($data, 'ref_syarat_diklat');
  }

  echo json_encode($msg);
}

public function apprv_diklat_struktural() {
	$id = $this->input->get('id');
	$data = $this->md->getapprv('ref_syarat_diklat', array('id_syarat_diklat' => $id));
	if($data->num_rows() > 0) {
		$r = $data->result();
		$tbl = '
			<table class="table table-bordered">
				<tr>
					<td width="30%">NIP</td>
					<td>'.$r[0]->nip.'</td>
				</tr>
				<tr>
					<td width="30%">Nama</td>
					<td>'.$this->md->getnamalengkap($r[0]->nip).'</td>
				</tr>
				<tr>
					<td width="30%">Jabatan</td>
					<td>'.$this->md->getnamajabtan($r[0]->fid_jabatan).'</td>
				</tr>
				<tr>
					<td width="30%">Nama Diklat</td>
					<td>'.$r[0]->nama_syarat_diklat.'</td>
				</tr>
				<tr>
					<td width="30%">Penyelenggara</td>
					<td>'.$r[0]->penyelenggara.'</td>
				</tr>
			</table>
			<hr>
			
		';
		$tbl .= '
			<form action="'.base_url('diklat/sinkron_usulan').'" method="post" name="sinkron_usulan">
				<input type="hidden" name="id_syarat_diklat" value="'.$id.'">
				<input type="hidden" name="nip" value="'.$r[0]->nip.'">
				<input type="hidden" class="form-control" id="namadiklat" name="namadiklat" value="'.$r[0]->nama_syarat_diklat.'">
				<input type="hidden" class="form-control" id="penyelenggaradiklat" name="penyelenggaradiklat" value="'.$r[0]->penyelenggara.'">
				
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Tempat</div>
					    <input type="text" class="form-control" id="tempatdiklat" name="tempatdiklat" placeholder="Masukan tempat diklat" readonly  value="'.$r[0]->tempat.'">
					</div>
				</div>
				
				<div class="form-inline">
				<div class="row">
				
				<div class="col-sm-3">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Thn</div>
						    	<input type="text" class="form-control" id="tahundiklat" name="tahundiklat" placeholder="Tahun" readonly value="'.$r[0]->tahun.'">
							
						</div> 
					</div>  
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Bulan</div>
						    	<input type="text" class="form-control" id="lamabulandiklat" name="lamabulandiklat" readonly value="0">
							
						</div> 
					</div>  
				</div>
				
				<div class="col-sm-3">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Hari</div>
					    <input type="text" class="form-control" id="lamaharidiklat" name="lamaharidiklat" readonly value="0">
					</div> 
				</div> 
				</div> 
				
				<div class="col-sm-3">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Jam</div>
						    <input type="text" class="form-control" id="lamajamdiklat" name="lamajamdiklat" readonly value="'.$r[0]->jp.'">
						</div> 
					</div> 
				</div> 
				
				</div> 
				</div> 
				
				<div class="clearfix"><br></div>
				
				<div class="form-inline">
				<div class="row">
				
				<div class="col-sm-6">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Jenis</div>
						    	<input type="text" class="form-control" id="jenisdiklat" name="jenisdiklat" readonly value="'.$r[0]->jenis_syarat_diklat.'">
							
						</div> 
					</div>  
				</div>
				
				
				<div class="col-sm-6">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Biaya</div>
						    <input type="text" class="form-control" id="biayadiklat" name="biayadiklat" disabled value="'.$r[0]->biaya.'">
						</div> 
					</div> 
				</div> 
				
				</div> 
				</div> 
				
				
				<div class="clearfix"><br></div>
				
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Pejabat SK</div>
					    <input type="text" class="form-control" id="pejabatsk" name="pejabatsk" placeholder="Masukan Pejabat SK" required>
					</div>
				</div>
				
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Nomor SK</div>
					    <input type="text" class="form-control" id="nomorsk" name="nomorsk" placeholder="Masukan Nomor SK" required>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<div class="col-md-8">
					<div class="input-group">
						<div class="input-group-addon">Tanggal SK</div>
					    <input type="text" class="form-control" id="tanggalsk" name="tanggalsk" placeholder="Masukan Tanggal SK" required> 
						<div class="input-group-addon">tttt - bln - hari</div>
					</div>
					</div>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn btn-sm btn-warning">Sinkronkan</button>
			</form>
		
		';
	} else {
		$tbl = '<h3>Data Tidak Ditemukan</h3>';
	}
	echo $tbl;
}

public function sinkron_usulan() {
	
	$id 		   = $this->input->post('id_syarat_diklat');
	$nip           = $this->input->post('nip');
	$nama_diklat   = $this->input->post('namadiklat');
	$tahun         = $this->input->post('tahundiklat');
	$penyelenggara = $this->input->post('penyelenggaradiklat');
	$tempat        = $this->input->post('tempatdiklat');
	$jenis		   = $this->input->post('jenisdiklat');
	
	$lama_bln  = $this->input->post('lamabulandiklat');
	$lama_hari = $this->input->post('lamaharidiklat');
	$lama_jam  = $this->input->post('lamajamdiklat');
	
	$pejabat_sk = $this->input->post('pejabatsk');
	$nomor_sk   = $this->input->post('nomorsk');
	$tanggal_sk = $this->input->post('tanggalsk');
	
	$created_at = date('Y-m-d H:i:s');
	$created_by = $this->session->userdata('nip');
	
	if($jenis == 'TEKNIS') {
		$kolum_teknis = array(
			'nip' => $nip,
			'nama_diklat_teknis' => $nama_diklat,
			'tahun' => $tahun,
			'instansi_penyelenggara' => $penyelenggara,
			'tempat' => $tempat,
			'lama_bulan' => $lama_bln,
			'lama_hari' => $lama_hari,
			'lama_jam' => $lama_jam,
			'pejabat_sk' => $pejabat_sk,
			'no_sk' => $nomor_sk,
			'tgl_sk' => $tanggal_sk,
			'created_at' => $created_at,
			'created_by' => $created_by
		);
	
		$this->md->insert_usulan('riwayat_diklat_teknis', $kolum_teknis);
		$this->md->update_status_usulan('ref_syarat_diklat', array('id_syarat_diklat' => $id), array('sts_apprv' => '3'));
		$msg = array('pesan' => 'Success Sinkronisasi pada diklat '.$jenis);
	} elseif($jenis == 'FUNGSIONAL') {
		$kolum_fungsional = array(
			'nip' => $nip,
			'nama_diklat_fungsional' => $nama_diklat,
			'tahun' => $tahun,
			'instansi_penyelenggara' => $penyelenggara,
			'tempat' => $tempat,
			'lama_bulan' => $lama_bln,
			'lama_hari' => $lama_hari,
			'lama_jam' => $lama_jam,
			'pejabat_sk' => $pejabat_sk,
			'no_sk' => $nomor_sk,
			'tgl_sk' => $tanggal_sk,
			'created_at' => $created_at,
			'created_by' => $created_by
		);
		$this->md->insert_usulan('riwayat_diklat_fungsional', $kolum_fungsional);
		$this->md->update_status_usulan('ref_syarat_diklat', array('id_syarat_diklat' => $id), array('sts_apprv' => '3'));
		$msg = array('pesan' => 'Success Sinkronisasi pada diklat '.$jenis);
	} else {
		$msg = array('pesan' => 'Proses Gagal');
	}

	echo json_encode($msg);
	
	
}
/*
######################## HALAMAN ANALISIS DIKLAT #########################
*/
//VIEW HALAMAN ANALISIS DIKLAT
public function analisis_diklat(){
  $data['content'] = 'diklat/analisisdiklat';
  $data['analisis_diklat']  = 'diklat/script/analisis_diklat';
  $this->load->view('template', $data);
}

public function get_pegawai(){
  
  $unkerid = $this->input->post('idunker');
  $jabid = $this->input->post('idjab');
  $nip = $this->input->post('carinip');
  $jab = $this->input->post('jab');

  $data = $this->md->getpegawai('pegawai',$unkerid,$jabid,$nip,$jab)->result();
  echo json_encode($data);
}

public function get_more_pegawai(){
  $nip = $this->input->post('nip');
  $nipmy = substr($nip,0,16);

  $data = $this->md->getmorepegawai('pegawai',$nip)->result();
  echo json_encode($data);
}

public function get_datasyaratdiklat(){
  $idnya = $this->input->post('id');
  $data = $this->md->getdatasyaratdiklat($idnya)->result();
  echo json_encode($data);
}

public function get_datariwayatdiklat(){
  $nip = $this->input->POST('nip');
  $data = $this->md->getdatariwayatdiklat($nip)->result();
  echo json_encode($data);
}

public function get_rwyt_diklat_fungsional(){
  $nip_fu = $this->input->get('nip_fu');
  $data = $this->md->getrwytdiklatfungsional($nip_fu)->result();
  echo json_encode($data);
}

public function get_rwyt_diklat_teknis(){
  $nip_tk = $this->input->get('nip_tk');
  $data = $this->md->getrwytdiklattekis($nip_tk)->result();
  echo json_encode($data);
}

public function get_usulan_diklat_teknis() {
  $nip= $this->input->post('nip');
  $result = $this->md->get_usulan_diklat_teknis($nip)->result();
  if(count($result) != 0){
    $no = 1;
    $tr = '';
    foreach($result as $v){
      if($v->sts_apprv == '2') {
        $sts = '<span class="label label-warning">DALAM PROSES BKPPD</span>';
        $disabled = '';
      } elseif ($v->sts_apprv == '0') {
        $sts = '<span class="label label-danger">TIDAK DISETUJUI</span>';
        $disabled = 'disabled';
      } else {
        $sts = '<span class="label label-default">PROSES ANTRI</span>';
        $disabled = '';
      }
      
      $tr .= '<tr>
                <td>'.$no.'</td>
                <td>'.$v->nama_syarat_diklat.'</td>
                <td>'.$sts.'</td>
                <td><button class="btn btn-xs btn-success" onClick="edit_usulan('.$v->id_syarat_diklat.', \'detail\', '.$v->sts_apprv.')" class="text-info"><i class="glyphicon glyphicon-eye-open"></i></button></td>
                <td><button class="btn btn-xs btn-info" '.$disabled.' onClick="edit_usulan('.$v->id_syarat_diklat.', \'edit\', '.$v->sts_apprv.')" class="text-info"><i class="glyphicon glyphicon-edit"></i></button></td>
                <td><button class="btn btn-xs btn-danger" '.$disabled.' onClick="hapus_usulan('.$v->id_syarat_diklat.')" class="text-danger"><i class="glyphicon glyphicon-trash"></i></></td>
              </tr>';
    $no++;
    }
  } else {
      $tr = '<tr><td colspan="3" class="text-center">Data Usulan Kosong</td></tr>';
  }
  echo json_encode($tr); 
}

public function get_usul_by_id($id) {
  $data = $this->md->get_usul_by_id('ref_syarat_diklat', $id)->result();
  echo json_encode($data);
}

public function get_update_usul_by_id($id) {
  $name = $this->input->post('usul_edit');
  $tusi = $this->input->post('tupoksi');
  $penyelenggara = $this->input->post('penyelenggara');
  $jp = $this->input->post('jp');
  $biaya = $this->input->post('biaya');
  $capaian = $this->input->post('capaian');

  $set = [
    'nama_syarat_diklat' => $name,
    'tupoksi' => $tusi,
    'jp' => $jp,
    'penyelenggara' => $penyelenggara,
    'biaya' => $biaya,
    'capaian' => $capaian
  ];

  $send = $this->md->update_usul_by_id('ref_syarat_diklat', $set, $id);
  if(!empty($send)) {
    $msg = "false";
  } else {
    $msg = "Updated Success.";
  }
  echo json_encode($msg);
}

public function get_rekomendasi_diklat_teknis() {
  $nip= $this->input->post('nip');
  $result = $this->md->get_rekomendasi_diklat_teknis($nip)->result();
  if(count($result) != 0){
    $no = 1;
    $tr = '';
    foreach($result as $v){
      if($v->sts_apprv == '3') {
        $status = '<span class="label label-success">Terlaksana</span>';
        $cek_status = 'checked';
      } else {
        $status = '<span class="label label-danger">Belum Terlaksana</span>';
        $cek_status = '';        
      }     
      $tr .= '<tr>
                <td>'.$no.'</td>
                <td>'.$v->tahun.'</td>
                <td>'.$v->nama_syarat_diklat.'</td>
                <td>'.$status.'</td>
                <td class="text-center"><input disabled type="checkbox" class="cekStatus'.$v->id_syarat_diklat.'" onchange="update_status('.$v->id_syarat_diklat.')" '.$cek_status.' title="Verifikasi hanya dapat dilakukan oleh admin BKPSDM"></td>
              </tr>';
    $no++;
    }
  } else {
      $tr = '<tr><td colspan="3" class="text-center">Tidak ada rekomendasi diklat teknis</td></tr>';
  }
  echo json_encode($tr); 
}

public function hapus_usulan($id) {
  $data = $this->md->hapus_usulan('ref_syarat_diklat', $id);
  if($data) {
    $msg = 'Gagal Dihapus';
  } else {
    $msg = 'Data Usulan Terhapus';
  }
  echo json_encode($msg);
}

public function get_usulan_diklat_teknis_fungsional_jst() {
	$nip = $this->input->post('nip');
	$data = $this->md->get_usulan_diklat_teknis_fungsional_jst('ref_syarat_diklat', $nip);
	if($data->num_rows() > 0) {
		$row = $data->result();
		$no = 1;
		$table = '<table class="table table-bordered table-hover table-striped" style="margin-top:10px;">
                        <thead>
                          <th width="10">No</th>
                          <th>Nama Diklat</th>
                          <th width="200">Status usulan</th>
                          
                        </thead>
                        <tbody>';
       
                	foreach($row as $r){
                		if($r->sts_apprv == 0) {
                			$status = '<label class="text-danger">Tidak Disetujui</label>';
                			$aksi   = '';
                			$keterangan  = $r->ctt;
                		}elseif($r->sts_apprv == 1) {
                			$status = '<label class="text-success">Disetujui</label>';
                			$aksi   = '<button class="btn btn-sm btn-success" disabled><i class="glyphicon glyphicon-pencil"></i></button>';
                			$keterangan  = '';
                		}elseif($r->sts_apprv == 2) {
                			$status = '<label class="text-primary">Dalam Proses BKPPD</label>';
                			$aksi   = '<button class="btn btn-sm btn-success" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>';
                			$keterangan  = '';
                		}
	                	$table .= '
	                		<tr>
	                			<td>'.$no.'</td>
	                			<td>'.$r->nama_syarat_diklat.'</td>
	                			<td>'.$status.'<br><i>'.$keterangan.'</i></td>
	                		</tr>		
	                	';
	                	
                		$no++;
                	}
                        	
        $table .= '		</tbody>
                   </table>';
	} else {
		$table = '<center><h4>Data Usulan Kosong</h4></center>';
	}
	
	echo $table;
}

/*
######################## HALAMAN LAPORAN #########################
*/
//VIEW HALAMAN SYARAT DIKLAT LAPORAN
public function laporan_diklat(){
  $data['content'] = 'diklat/syaratlaporan';
  $this->load->view('template', $data);
}

public function laporan_diklat_v2() {
  $data['content'] = 'diklat/laporan_v2';
  $data['laporan_v2']  = 'diklat/script/laporan_v2';
  $this->load->view('template', $data);  
}

public function get_laporandata(){
  $unkerid = $this->input->post('idunker');
  $jabid = $this->input->post('idjnsjab');

  $data = $this->md->getlaporandata('pegawai',$unkerid,$jabid)->result();
  echo json_encode($data);
}

public function get_rekap_v2() {
  $unker = $this->input->post('unkerid');
  $checkstatus = $this->input->post('checkstatus');
  $checkjabatan = $this->input->post('checkjabatan');
  $tahun = $this->input->post('tahun');

  $get_data = $this->md->fetch_datatable_rekap($unker, $checkstatus, $checkjabatan, $tahun);
  $data = array();
  $no = $_POST['start'];

  foreach($get_data as $r) {
  $namapns = $r->nama_asn."<br> <b>NIP.</b>".$r->nip;
  if($r->sts_apprv == 0 ? $status = "<label class='label label-danger'>Tidak Disetujui</label>" : "");
  if($r->sts_apprv == 1 ? $status = "<label class='label label-success'>Disetujui</label>" : "");
  if($r->sts_apprv == 2 ? $status = "<label class='label label-warning'>DALAM PROSES BKPPD</label>" : "");
  if($r->sts_apprv == 3 ? $status = "<label class='label label-info'>Terlaksana</label>" : "");

  $sub_array = array();
    $sub_array[] = $no+1;
    $sub_array[] = $namapns;
    $sub_array[] = $r->nama_syarat_diklat;
    $sub_array[] = character_limiter($r->tupoksi, 25);
    $sub_array[] = $r->jp;
    $sub_array[] = character_limiter($r->penyelenggara, 25);
    $sub_array[] = "Rp. ".nominal($r->biaya);
    $sub_array[] = character_limiter($r->capaian, 25);
    $sub_array[] = $status;
    $data[] = $sub_array;

  $no++;
  }

  $output = array(
    'draw'  		  => intval($_POST['draw']),
    'recordsTotal' 	  => $this->md->get_all_data_rekap($unker, $checkstatus, $checkjabatan, $tahun),
    'recordsFiltered' => $this->md->get_filtered_data_rekap($unker, $checkstatus, $checkjabatan, $tahun),
    'data'			  => $data			
  );

  echo json_encode($output); 
}

//laporan
public function get_unit_kerja() {
  $search = $this->input->post('searchParm');
  $row = $this->md->get_unit_kerja('ref_unit_kerjav2', $search)->result_array();
  $data = array();
  foreach($row as $r) {
    $data[] = array(
      "id" => $r['id_unit_kerja'],
      "text" => $r['nama_unit_kerja']
    );
  }
  echo json_encode(['items' => $data]);
}

public function get_data_rekomendasi_l(){
  $myjab = $this->input->post('jab');
  $data = $this->md->getdatarekomendasi_l($myjab)->result();
  echo json_encode($data);
}

public function get_data_riwayat_l(){
  $mynip = $this->input->post('nippns');
  $data = $this->md->getdatariwayat_l($mynip)->result();
  echo json_encode($data);
}

public function get_data_riwayat_l_teknis(){
  $mynip = $this->input->post('nip');
  $data = $this->md->getdatariwayat_l_teknis($mynip)->result();
  echo json_encode($data);
}

public function get_data_riwayat_l_fungsional(){
  $mynip = $this->input->post('nip');
  $data = $this->md->getdatariwayat_l_fungsional($mynip)->result();
  echo json_encode($data);
}


//cetak
public function getdata_rekomendasi(){
  $myjab = $this->input->get('jab');
  $data = $this->md->getdatarekomendasi($myjab)->result();
  echo json_encode($data);
}

public function get_data_riwayat(){
  $mynip = $this->input->post('nippns');
  $data = $this->md->getdatariwayat($mynip)->result();
  echo json_encode($data);
}

public function cetaklaporan($unkerid,$jabid){
  // $jab = $this->input->post("idjab");
  // $data_rekomedasi = $this->md->getdatarekomendasi($jab)->result();
  $data = $this->md->cetaklaporandiklat($unkerid,$jabid)->result();
  
  //$dataque['data_rek'] = $data_rekomedasi;
  $dataque['data_rows'] = $data;
  $this->load->view('diklat/cetaklaporan', $dataque);
}

public function cetaklaporan_v2($unkerid,$s,$j,$t) {
  
  $data = $this->md->cetaklaporan_v2($unkerid,$s,$j,$t)->result();
  $result['parseData'] = array('data' => $data, 's' => $s, 'j' => $j, 't' => $t);
  $this->load->view('diklat/cetaklaporan_v2', $result);
}

}
