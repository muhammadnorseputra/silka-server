<?php
class Datacetak extends CI_Model {
    //put your code here
    function __construct(){
      parent::__construct();
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
      $this->load->model('munker');
    }
    
    function dataprofpeg() {
      //$query = $this->db->get('ref_golru');
      $nip = $this->input->post('nip');
    	//$query = $this->mpegawai->detail($nip);
      $query = $this->mpegawai->cetakprofpeg($nip);

      return $query->result();
    }

    function datanomperunker() {
      $idunker = $this->input->post('id');      
      $query = $this->munker->nomperunker($idunker);

      return $query->result();
    }

    function datacetakusulcuti() {
      $nip = $this->input->post('nip');
      $thn_cuti = $this->input->post('thn_cuti');
      $fid_jns_cuti = $this->input->post('fid_jns_cuti');
      $fid_pengantar = $this->input->post('fid_pengantar');
      $id_status = 2;  // status cuti : CETAUKUSUL

      // update status cuti : CETAKUSUL => 2
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'nip'             => $nip,
      'fid_jns_cuti'    => $fid_jns_cuti,
      'fid_pengantar'   => $fid_pengantar,
      'thn_cuti'        => $thn_cuti
      );

      if ($this->mcuti->edit_usul($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul Cuti berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mcuti->cetakusulcuti($nip, $thn_cuti, $fid_jns_cuti, $fid_pengantar);

      return $query->result();
    }

    function datacetakpengantarcuti() {
      $id_pengantar = $this->input->post('id_pengantar');
      $tgl_pengantar = $this->input->post('tgl_pengantar');
      $fid_unit_kerja = $this->input->post('id_unker');
      $id_status = 2;  // status pengantar : CETAK

      // update status pengantar : CETAK => 2
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'id_pengantar'    => $id_pengantar,
      'fid_unit_kerja'  => $fid_unit_kerja,
      'tgl_pengantar'   => $tgl_pengantar
      );

      if ($this->mcuti->edit_pengantar($where, $data))
      {
        $data['pesan'] = '<b>Sukses</b>, Pengantar Usul Cuti berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar Usul Cuti gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mcuti->cetakpengantar($id_pengantar, $tgl_pengantar, $fid_unit_kerja);

      return $query->result();
    }

    function datacetakpengantarcutitunda() {
      $id_pengantar = $this->input->post('id_pengantar');
      $tgl_pengantar = $this->input->post('tgl_pengantar');
      $fid_unit_kerja = $this->input->post('id_unker');
      $id_status = 2;  // status pengantar : CETAK

      // update status pengantar : CETAK => 2
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'id_pengantar'    => $id_pengantar,
      'fid_unit_kerja'  => $fid_unit_kerja,
      'tgl_pengantar'   => $tgl_pengantar
      );

      if ($this->mcuti->edit_pengantar($where, $data))
      {
        $data['pesan'] = '<b>Sukses</b>, Pengantar Usul Cuti berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar Usul Cuti gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mcuti->cetakpengantartunda($id_pengantar, $tgl_pengantar, $fid_unit_kerja);

      return $query->result();
    }

    function datacetakskcuti() {
      $id_pengantar = $this->input->post('id_pengantar');
      $nip = $this->input->post('nip');
      $thn_cuti = $this->input->post('thn_cuti');
      $fid_jns_cuti = $this->input->post('fid_jns_cuti');
      $id_status = 7;  // status cuti : CETAKSK

      // update status cuti : CETAKSK => 7
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'fid_pengantar'  => $id_pengantar,
      'nip'            => $nip,
      'thn_cuti'       => $thn_cuti,
      'fid_jns_cuti'   => $fid_jns_cuti
      );

      if ($this->mcuti->edit_usul($where, $data))
      {
        $data['pesan'] = '<b>Sukses</b>, SK Cuti berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, SK Cuti gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mcuti->cetakskcuti($nip, $thn_cuti, $fid_jns_cuti, $id_pengantar);

      return $query->result();
    }

    function datacetakskcuti_tunda() {
      $id_pengantar = $this->input->post('id_pengantar');
      $nip = $this->input->post('nip');
      $tahun = $this->input->post('tahun');
      $id_status = 7;  // status cuti : CETAKSK

      // update status cuti : CETAKSK => 7
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'fid_pengantar'  => $id_pengantar,
      'nip'            => $nip,
      'tahun'          => $tahun
      );

      if ($this->mcuti->edit_usultunda($where, $data))
      {
        $data['pesan'] = '<b>Sukses</b>, SK Cuti Tunda berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, SK Cuti Tunda gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mcuti->cetakskcuti_tunda($nip, $tahun, $id_pengantar);

      return $query->result();
    }

    function datanomppkperunker() {
      $idunker = $this->input->post('idunker');      
      $tahun = $this->input->post('tahun');      
      $query = $this->mpegawai->carirekapunkerppk($idunker, $tahun);

      return $query->result();
    }

    function datacetakpengantarkgb() {
      $id_pengantar = $this->input->post('id_pengantar');
      $tgl_pengantar = $this->input->post('tgl_pengantar');
      $fid_unit_kerja = $this->input->post('id_unker');
      $id_status = 2;  // status pengantar : CETAK

      // update status pengantar : CETAK => 2
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'id_pengantar'    => $id_pengantar,
      'fid_unit_kerja'  => $fid_unit_kerja,
      'tgl_pengantar'   => $tgl_pengantar
      );

      if ($this->mkgb->edit_pengantar($where, $data))
      {
        $data['pesan'] = '<b>Sukses</b>, Pengantar Usul KGB berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar Usul KGB gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mkgb->cetakpengantar($id_pengantar, $tgl_pengantar, $fid_unit_kerja);

      return $query->result();
    }

    function datacetakskkgb() {
      $id_pengantar = $this->input->post('id_pengantar');
      $nip = $this->input->post('nip');
      $id_status = 7;  // status cuti : CETAKSK

      // update status cuti : CETAKSK => 7
       $data = array(      
        'fid_status'      => $id_status
      );

      $where = array(
      'fid_pengantar'  => $id_pengantar,
      'nip'            => $nip
      );

      if ($this->mkgb->edit_usul($where, $data))
      {
        $data['pesan'] = '<b>Sukses</b>, SK KGB berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, SK KGB gagal dicetak.';
        $data['jnspesan'] = 'alert alert-danger';
      }      

      $query = $this->mkgb->cetaksk($nip, $id_pengantar);

      return $query->result();
    }

    function datacetakskhd() {
      $nip = $this->input->post('nip');
      $tmt = $this->input->post('tmt');
      $jnshd = $this->input->post('jnshd');
      $status = 'CETAK SK'; 

      $data = array(      
        'status'      => $status
      );

      $where = array(
      'nip'               => $nip,
      'tmt_hukuman'               => $tmt,
      'fid_jenis_hukdis'  => $jnshd
      );

      $nama = $this->mpegawai->getnama($nip);

      if ($this->mhukdis->edit_usul($where, $data)) {
        $data['pesan'] = '<b>Sukses</b>, SK Hukuman Disiplin <u>'.$nama.'</u> berhasil dicetak.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, SK Hukuman Disiplin <u>'.$nama.'</u> gagal dicetak.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      } 

      $query = $this->mhukdis->detailhd($nip, $tmt, $jnshd);

      return $query->result();
    }

    function datacetaknomhukdis() {
      $thn = $this->input->post('thn');        
      
      $query = $this->mhukdis->carivalusul($thn);

      return $query->result();
    }

    function datanompipperunker() {
      $idunker = $this->input->post('idunker');      
      $tahun = $this->input->post('tahun');      
      $query = $this->mpip->carirekapunkerpip($idunker, $tahun);

      return $query->result();
    }

    //function datacetakproyeksipensiun() {
    //  $tahun = $this->input->post('tahun');
    //  $query = $this->mpensiun->proyeksi();	

    //  return $query->result();
    //}
}
