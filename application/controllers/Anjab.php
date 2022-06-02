<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anjab extends CI_Controller {
  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {            
    parent::__construct();
    $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');  
    $this->load->model('mAnjab','m');
      $this->load->model('mpegawai');
      $this->load->model('munker');
    $this->load->library('Pdf');

  }

public function sensus(){
  $idget = $this->input->get('idunker');

  $data['content'] = 'anjab/sopanjab';
  $data['peg'] = $this->m->get_pegawai()->result();
  $data['uk'] = $this->m->getunker('ref_unit_kerjav2')->result();

  $data['jab_struk'] = $this->m->getJs_sensus('ref_jabstruk', $idget)->result();
  $data['jab_ft'] = $this->m->getJft_sensus('ref_jabft')->result();
  $data['jab_fu'] = $this->m->getJfu_sensus('ref_jabfu')->result();

  $data['eselon_2'] = $this->m->eselon2('ref_jabstruk')->result();
  $data['eselon_3'] = $this->m->eselon3('ref_jabstruk')->result();
  $data['eselon_4'] = $this->m->eselon4('ref_jabstruk')->result();

  $data['n_jab'] = $this->m->ambil_nama_jabatan('aj_syaratjab')->result();

  $this->load->view('template', $data);
}

public function analisis(){
  $data['content'] = 'anjab/analisis';
  $data['p_pns'] = $this->m->get_pns()->result();
  $data['p_jabatan'] = $this->m->get_jabatan()->result();

  $this->load->view('template', $data);
}

public function anjabmaster(){
  $data['content'] = 'anjab/anjabmaster';
  $data['golru']   = $this->m->getGolru('ref_golru')->result();
  $data['getpdd']  = $this->m->m_pendidikan('ref_jurusan_pendidikan')->result();
  $data['tingpen']  = $this->m->t_pendidikan('ref_tingkat_pendidikan')->result();
  // $data['res2']     = $this->m->get_eselon_2('ref_jabstruk', 11)->result();
  $this->load->view('template', $data);
}

public function laporan(){
  $data['content'] = 'anjab/laporan';
  $this->load->view('template', $data);
}

public function cetaklaporan($unker){
  $data = $this->m->get_data_laporan('aj_syaratjab_analisis', $unker)->result();
  
  $dataque['data_rows'] = $data;
  $this->load->view('anjab/cetaklaporan', $dataque);

}


public function get_laporan(){
  $unker = $this->input->post('unkerid');
  $data= $this->m->get_data_laporan('aj_syaratjab_analisis', $unker)->result();
  echo json_encode($data);
}

public function get_unker(){
  $unkerselect = $this->m->getunker('ref_unit_kerjav2')->result();
  if(count($unkerselect)>0){
    $e_select = '';
    $e_select .= '<option value="">-- Pilih Unit Kerja-- </option>';
    foreach ($unkerselect as $q) {
       $e_select .= '<option value="'.$q->id_unit_kerja.'">'.$q->nama_unit_kerja.'</option>';
    }
  }else{
        $e_select = '<option value="">Eselon II Kosong</option>';
  }

    echo json_encode($e_select);  
}

public function getesl2(){
  $idselunker = $this->input->post('idselunker');

  $e2 = $this->m->esl2('ref_jabstruk', $idselunker)->result();
  if(count($e2)>0){
    $e_select = '';
    $e_select .= '<option value="">-- Eselon II -- </option>';
    foreach ($e2 as $q) {
       $e_select .= '<option value="'.$q->id_jabatan.'">'.$q->nama_jabatan.'</option>';
    }
  }else{
        $e_select = '<option value="">Eselon II Kosong</option>';
  }

    echo json_encode($e_select);
}

public function getesl3(){
  $idselunker = $this->input->post('idselunker');

  $e3 = $this->m->esl3('ref_jabstruk', $idselunker)->result();
  if(count($e3)>0){
    $e_select = '';
    $e_select .= '<option value="">-- Eselon III -- </option>';
    foreach ($e3 as $q) {
       $e_select .= '<option value="'.$q->id_jabatan.'">'.$q->nama_jabatan.'</option>';
    }
  }else{
        $e_select = '<option value="">Eselon III Kosong</option>';
  }
    echo json_encode($e_select);
}

public function getesl4(){
  $idselunker = $this->input->post('idselunker');

  $e4 = $this->m->esl4('ref_jabstruk', $idselunker)->result();
  if(count($e4)>0){
    $e_select = '';
    $e_select .= '<option value="">-- Eselon IV -- </option>';
    foreach ($e4 as $q) {
       $e_select .= '<option value="'.$q->id_jabatan.'">'.$q->nama_jabatan.'</option>';
    }
  }else{
        $e_select = '<option value="">Eselon IV Kosong</option>';
  }
    echo json_encode($e_select);
}

public function getjabstruk(){
  // $data['jabstruk']= $this->m->getJabStruk('ref_jabstruk')->result();
  $idselunker = $this->input->post('idselunker');

  $jbs = $this->m->getjabstruk($idselunker)->result();
  if(count($jbs)>0){
    $j_select = '';
    $j_select .= '<option value="">-- Select Jabatan Struktural -- </option>';
    foreach ($jbs as $r) {
       $j_select .= '<option value="'.$r->id_jabatan.'">'.$r->nama_jabatan.'</option>';
    }
    echo json_encode($j_select);
  }
}

public function getjabfu(){
  $datajabfu= $this->m->getJfu('ref_jabfu')->result();
  if(count($datajabfu)>0){
    $j_select = '';
    $j_select .= '<option value="">-- Select Jabatan Pelaksana -- </option>';
    foreach ($datajabfu as $r) {
       $j_select .= '<option value="'.$r->id_jabfu.'">'.$r->nama_jabfu.'</option>';
    }
    echo json_encode($j_select);
  }  
}

public function getjabft(){
  $datajabft= $this->m->getJft('ref_jabft')->result();
  if(count($datajabft)>0){
    $j_select = '';
    $j_select .= '<option value="">-- Select Jabatan Fungsional -- </option>';
    foreach ($datajabft as $r) {
       $j_select .= '<option value="'.$r->id_jabft.'">'.$r->nama_jabft.'</option>';
    }
    echo json_encode($j_select);
  }  
}


public function p_tambahdatamaster(){
  $unker = $this->input->post('unker');
  $jnsjb = $this->input->post('jnsjb');
  $jabstruk = $this->input->post('jabstruk');
  $jabfu = $this->input->post('jabfu');
  $n_jab = $this->input->post('n_jab');
  $jabft = $this->input->post('jabft');
  $esl2 = $this->input->post('esl2');
  $esl3 = $this->input->post('esl3');
  $esl4 = $this->input->post('esl4');
  $golru = $this->input->post('golru');

  $pdd = $this->input->post('pendidikan');
  $tingpen = $this->input->post('tingpen');  
  // $pdd     = $tingpen." - ".$jurusan;
  
  $klsjab = $this->input->post('klsjab');
  $skp = $this->input->post('skp');
  $jp = $this->input->post('jp');
  $csakit = $this->input->post('csakit');

  if($unker == ''){
    $msg['pesan'] = '<div class="alert alert-danger"><b>Peringatan!</b>, Unit kerja wajid dipilih</div>';
  }else{
    $msg['pesan'] = '';
    $data = array(
      'fid_unit_kerja' => $unker,
      'fid_jenis_jabatan' => $jnsjb,
      'fid_jabstruk' => $jabstruk,
      'fid_jabft' => $jabft,
      'fid_jabfu' => $jabfu,
      'fid_jabesl4' => $esl4,
      'fid_jabesl3' => $esl3,
      'fid_jabesl2' => $esl2,
      'kelas_jabatan' => $klsjab,
      'n_jabatan' => $n_jab,
      'fid_golru' => $golru,
      'fid_tingkat_pendidikan' => $tingpen,
      'pendidikan' => $pdd,
      'total_jp_diklat' => $jp,
      'skp' => $skp,
      'jml_cuti_sakit' => $csakit
    );

    $this->m->m_p_insert($data, 'aj_syaratjab');
  }

  echo json_encode($msg);
}

public function getdatamaster(){
 $datamaster = $this->m->getdatamaster('aj_syaratjab')->result();
  // $datamaster['content'] = 'anjab/anjabmaster';
  // $this->load->view('template', $datamaster);
  echo json_encode($datamaster);
}
  
public function hapusdata(){
  $id=$this->input->post('id');
  $where = array('id_aj_syaratjab' => $id);
  $this->m->hapusdatatable($where, 'aj_syaratjab');
}


public function updatedata(){
  $id = $this->input->post('id');
  $unker = $this->input->post('unker');
  $golru = $this->input->post('golru');  
  $klsjab = $this->input->post('klsjab');
  $skp = $this->input->post('skp');
  $jp = $this->input->post('jp');
  $csakit = $this->input->post('csakit');
  $nama_jab = $this->input->post('nama_jabatan');
  // $pdd = $this->input->post('pendidikan');

  if($unker == ''){
    $msg['pesan'] = 'Unit kerja wajid dipilih';
  }else{
    $whr = array('id_aj_syaratjab'=>$id);
    $msg['pesan'] = '';
    $data = array(
      'fid_unit_kerja' => $unker,
      'kelas_jabatan' => $klsjab,
      'n_jabatan' => $nama_jab,
      // 'pendidikan' => $pdd,
      'fid_golru' => $golru,
      'total_jp_diklat' => $jp,
      'skp' => $skp,
      'jml_cuti_sakit' => $csakit
    );

    $this->m->m_p_update($whr,$data, 'aj_syaratjab');
  }

  echo json_encode($msg);
}

public function updatedatapemangku(){
  $id = $this->input->post('id');
  $nj = $this->input->post('njab');

  $esel2 = $this->input->post('esel2');
  $esel3 = $this->input->post('esel3');
  $esel4 = $this->input->post('esel4');

  if($nj == ''){
    $msg['hasil1'] = '<div class="alert alert-danger" role="alert"><b>ERROR</b> JABATAN BELUM DIPILIH!</div>';
    $msg['status'] = "1";
  }else{
    $msg['status'] = "0";
    $msg['hasil'] = '<div class="alert alert-success" role="alert"><b>Success!</b> 1 Baris Terupdate</div>';
    $whr = array('aj_syaratjab_sensus'=>$id);
    $data = array(
      'n_jabatan' => $nj,
      'fid_jabesl2' => $esel2,
      'fid_jabesl3' => $esel3,
      'fid_jabesl4' => $esel4
    );    
    $this->m->m_p_update_pemangku($whr,$data, 'aj_syaratjab_sensus');
  }  
  echo json_encode($msg);
}

public function live_cari(){
  $search=  $this->input->post('search');
  $query = $this->m->getkata($search);
  echo json_encode ($query);
}

public function editId(){
  $ide = $this->input->post('id');
  $wheree = array('id_aj_syaratjab'=>$ide);
  $data = $this->m->ambilId('aj_syaratjab', $wheree)->result();

  echo json_encode($data);
}

public function editdatapemangku(){
  $id = $this->input->post('id');
  $wheree = array('aj_syaratjab_sensus'=>$id);
  $data = $this->m->ambil_pemangku('aj_syaratjab_sensus', $wheree)->result();

  echo json_encode($data);
}

// public function getprofil(){
//   $pola = $this->input->get('nip');
//   $wherenip = array('nip' => $pola);
//   $data = $this->m->getnip($wherenip)->result();

//   echo json_encode($data);  
// }

public function showdata(){
  $nip = $this->input->post('nip');
  $datapeg = $this->m->ambildatapeg('pegawai', $nip)->result();
  echo json_encode($datapeg);
}

public function p_simpandatasensus(){
  $nipsel = $this->input->post('nipsel');

  $nip_pns = $this->input->post('nip');
  $unker_pns = $this->input->post('unker');
  $j_jabatan_pns = $this->input->post('j_jab');


  $jabstruk_pns = $this->input->post('jbs');
  $jabft_pns = $this->input->post('jft');
  $jabfu_pns = $this->input->post('jfu');


  $esl2_pns = $this->input->post('esl2');
  $esl3_pns = $this->input->post('esl3');
  $esl4_pns = $this->input->post('esl4');


  $klsjab_pns = $this->input->post('klsjab');
  $njab_pns = $this->input->post('njab');
  $golru_pns = $this->input->post('golru');
  $tingpen = $this->input->post('tingpen');
  $jurusan = $this->input->post('jurusan');
  $jp_diklat_pns = $this->input->post('jp');
  $skp_pns = $this->input->post('skp');
  $csakit_pns = $this->input->post('csakit');

  $add = $this->session->userdata('nama');
  $at = date("Y-m-d H:i:s");

  //$ceknip = $this->m->get_data_sensus('aj_syaratjab_sensus')->result();

  if(empty($nipsel)){
    $role = "alert";
    $jpesan = "alert alert-danger";
    $pesan['msg1'] = "<div class='".$jpesan."' role='".$role."'><b>Error!</b> PNS Belum Anda tentukan</div>";
    $pesan['status'] = "1";
  }
  elseif(empty($njab_pns)){
    // $role = "alert";
    // $jpesan = "alert alert-warning";
    // $pesan['msg2'] = "<div class='".$jpesan."' role='".$role."'><b>Warning! (Jabatan: \"KOSONG\")</b> Anda Wajib Memilih Sesuai Jabatan Yang Anda Duduki Saat Ini</div>";
    // $pesan['status'] = "2";
    $pesan['msg2'] = "Jabatan: \"KOSONG\" Anda Wajib Memilih Sesuai Jabatan Yang Anda Duduki Saat Ini";
    $pesan['status'] = "2";

    
  }
  // elseif($nipsel == $ceknip['nip']){
  //   $role = "alert";
  //   $jpesan = "alert alert-info";
  //   $pesan['msg3'] = "<div class='".$jpesan."' role='".$role."'><b>Info!</b> NIP dengan jabatan tersebut, sudah ada!</div>";
  //   $pesan['status'] = "3";    
  // }
  else{
    $role = "alert";
    $jpesan = "alert alert-success";
    $pesan['msg'] = "<div class='".$jpesan."' role='".$role."'><b>Success!</b> 1 Baris Data Telah Di Tambahkan</div>";
    $pesan['status'] = "";

    $data = array(
      'nip' => $nip_pns,
      'fid_unit_kerja' => $unker_pns,
      'fid_jenis_jabatan' => $j_jabatan_pns,
      'fid_jabstruk' => $jabstruk_pns,
      'fid_jabft' => $jabft_pns,
      'fid_jabfu' => $jabfu_pns,
      'fid_jabesl4' => $esl4_pns,
      'fid_jabesl3' => $esl3_pns,
      'fid_jabesl2' => $esl2_pns,
      'kelas_jabatan' => $klsjab_pns,
      'n_jabatan' => $njab_pns,
      'fid_golru' => $golru_pns,
      'fid_tingkat_pendidikan' => $tingpen,
      'fid_jurusan_pendidikan' => $jurusan,
      'total_jp_diklat' => $jp_diklat_pns,
      'skp' => $skp_pns,
      'jml_cuti_sakit ' => $csakit_pns,
      'created_by' => $add,
      'created_at' => $at
    );

    $this->m->m_p_insert_sensus($data, 'aj_syaratjab_sensus');
  }
  echo json_encode($pesan);
}


public function getdatasensus(){
 $datasensus = $this->m->get_data_sensus('aj_syaratjab_sensus')->result();
  echo json_encode($datasensus);
}

public function hapusdatasensus(){
  $id=$this->input->post('id');
  $where = array('aj_syaratjab_sensus' => $id);
  $this->m->hapusdatasensus($where, 'aj_syaratjab_sensus');
}

public function hapusdatalaporan(){
  $id=$this->input->post('id');
  $this->m->hapusdatalaporan($id, 'aj_syaratjab_analisis');
  // $where = array('id_aj_syaratjab_analisis' => $id);
  // $this->m->hapusdatalaporan($where, 'aj_syaratjab_analisis');
}


//HALAMAN HASIL ANALISI
public function analisis_profil(){
  $kata = $this->input->post('katakunci');
  $load = $this->m->analisis_get_profil('aj_syaratjab_sensus', $kata)->result();
  echo json_encode($load);
}

public function analisis_jabatan(){
  $kata = $this->input->post('carijabatan');
  $load = $this->m->analisis_get_jabatan('aj_syaratjab', $kata)->result();
  echo json_encode($load);  
}

public function insert_profil_pns(){

  $id_jab = $this->input->post('id_aj_syaratjab');
  $id = $this->input->post('aj_syaratjab_sensus');
  $idunker = $this->input->post('id_unker');

  $kls_jab = $this->input->post('klsjab');
  $golru = $this->input->post('golru');
  $tingpen = $this->input->post('tingpen');
  $jurusan = $this->input->post('jurusan');
  $jp = $this->input->post('jp');
  $skp = $this->input->post('skp');
  $csakit = $this->input->post('csakit');

  $skor_kelas_jabatan = $this->input->post('skor_kelas_jabatan');
  $skor_golru = $this->input->post('skor_golru');
  $skor_jurusan = $this->input->post('skor_jurusan');
  $skor_jp = $this->input->post('skor_jp');
  $skor_skp = $this->input->post('skor_skp');
  $skor_cs = $this->input->post('skor_cs');

  $sts = $this->input->post('sts');

  $add = $this->session->userdata('nama');
  $at = date("Y-m-d H:i:s");

  if($id_jab == ''){
    $msg['hasil'] = "<div class='alert alert-danger' role='alert'><b>Error!</b> Pilih Jabatan Terlebih dahulu!!!</div>";
  }else{
    $msg['hasil'] = "";
    $data = array(
      'id_aj_syaratjab' => $id_jab,
      'fid_unit_kerja' => $idunker,
      'aj_syaratjab_sensus' => $id,
      'kelas_jabatan ' => $kls_jab,
      'fid_golru' => $golru,
      'fid_tingkat_pendidikan' => $tingpen,
      'fid_jurusan_pendidikan' => $jurusan,
      'total_jp_diklat' => $jp,
      'skp' => $skp,
      'jml_cuti_sakit ' => $csakit,
      'skor_kelas_jabatan' => $skor_kelas_jabatan,
      'skor_golru' => $skor_golru,
      'skor_jurusan' => $skor_jurusan,
      'skor_jp' => $skor_jp,
      'skor_skp' => $skor_skp,
      'skor_csakit' => $skor_cs,
      'sts' => $sts,
      'created_by' => $add, 
      'created_at' => $at,
      
    );
    $this->m->m_p_insert_pns($data, 'aj_syaratjab_analisis');
  }
echo json_encode($msg);
}

public function perbandingan(){
  $var = $this->input->post('val');
  $var2 = $this->input->post('syarat_jab');

  $data = $this->m->get_perbandingan('aj_syaratjab_analisis', $var, $var2)->result();
  echo json_encode($data);
}

public function gethasil(){
  $id = $this->input->post('id');
  $data= $this->m->hasil_analisis('aj_syaratjab_analisis', $id)->result();
  echo json_encode($data);
}

public function hapus_analisis_null(){
  $id = $this->input->post('id');
  $where = array('id_aj_syaratjab_analisis' => $id);
  $this->m->hapus_analisis('aj_syaratjab_analisis', $where);
}

public function update_analisis_null(){
  $id = $this->input->post('id');
  $msg['res'] = "Success";
  $whr = array('id_aj_syaratjab_analisis'=>$id);
  $data = array(
    'sts' => "1"
  );    
  $this->m->save_data_analisis($whr,$data, 'aj_syaratjab_analisis');
  echo json_encode($msg);


}

}

