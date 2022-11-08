<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load Helper 
        $this->load->helper(array('url','form','fungsitanggal','fungsipegawai'));
        // Load Model
        $this->load->model(array('mpegawai','munker','mrpk','mkinerja'));
        // Cek Session
        if (!$this->session->userdata('nama'))
        {
            redirect('login');
        }
    }
    
    // --------------- Bismillah Started -----------------//
    public function index(){
    	$data['unker'] = $this->munker->dd_unker()->result_array();      
        $data['content'] = 'rpk/profile';
        $this->load->view('template',$data);
    }
    public function tampilperunker()
	{
		$idunker = $this->input->get('idunker');
		if ($idunker) {
            $data['peg'] = $this->mrpk->nomperunker($idunker)->result();      
            $this->load->view('rpk/profile_list',$data);	
		} else {
            echo "<div class='alert alert-info' role='alert'>";
            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";        
            echo "Silahkan pilih unit kerja.";
            echo "</div>";
        } 
    }
    public function rekam_jejak_jabatan() 
    {
        $nip = $this->input->get('nip');
        $rekam_jejak = $this->mrpk->rekam_jejak_jabatan($nip);
        $total = count($rekam_jejak);
        $row = "<ol style='margin:0px 0px 0px 15px;padding:10px;'>";
        foreach($rekam_jejak as $r => $v):
            if($total == 1) {
                $row .= $v;
            } else {
                $row .= "<li style='margin:10px 0px;'>".$v."</li>";
            }
        endforeach; 
        $row .= "</ol>";
        echo json_encode(["count"=>$total,"data" => $row]);
    }
    public function rekam_jejak_jabatan_save_to_string() 
    {
        $nip = $this->input->get('nip');
        $rekam_jejak = $this->mrpk->rekam_jejak_jabatan($nip);
        $total = count($rekam_jejak);
        $no=1;
        $row = "";
        foreach($rekam_jejak as $r => $v):
            if($total == 1) {
                $row .= $v;
            } else {
                $row .= $no.". ".$v."\n";
            }
        $no++;
        endforeach; 
        return $row;
    }
    public function informasi_lain() 
    {
        $nip = $this->input->get('nip');
        $satyalencana = $this->mrpk->riwayat_satyalencana($nip);
        $hukdis = $this->mrpk->riwayat_hukdis($nip);
        $inovasi = $this->mrpk->riwayat_inovasi($nip);
        $pip = $this->mrpk->riwayat_pip($nip);
        echo json_encode(['satyalencana' => $satyalencana, 'hukdis' => $hukdis, 'inovasi' => $inovasi, 'pip' => $pip]);
    }	
    public function informasi_lain_save_to_string() 
    {
        $nip = $this->input->get('nip');
        $satyalencana = $this->mrpk->riwayat_satyalencana($nip);
        $hukdis = $this->mrpk->riwayat_hukdis($nip);
        $inovasi = $this->mrpk->riwayat_inovasi($nip);
        $pip = $this->mrpk->riwayat_pip($nip);
        
        
        $data_satyalencana = '';
        $data_hukdis='';
        $data_inovasi='';
        $data_pip='';
        if($satyalencana != '-') {
            foreach($satyalencana as $v) {
                $data_satyalencana .= "SATYA LENCANA : ".$v."\n";
            }
        }
        if($hukdis != '-') {
            foreach($hukdis as $v) {
                $data_hukdis .= "HUKDIS : ".$v."\n";
            }
        }
        if($inovasi != '-') {
            foreach($inovasi as $v) {
                $data_inovasi .= "INOVASI : ".$v."\n";
            }
        }
        if($pip != '-') {
            foreach($pip as $v) {
                $data_pip .= "IP ASN : ".$v."\n";
            }
        }
        $data_marge = ['satyalencana' => $data_satyalencana, 'hukdis' => $data_hukdis, 'inovasi' => $data_inovasi, 'pip' => $data_pip];
        $row = '';
        foreach($data_marge as $dm) {
            $row .= $dm;
        }
        return $row;
    }	
    public function input_nilai()
    {
        $nip = $this->input->post('nip');
        $unker = $this->input->post('unker');
        $unker_id = $this->input->post('unker_id');
        $jabatan_id = $this->input->post('jabatan_id');
        $namajabatan = $this->input->post('namajabatan');
        $nilai_manajerial = $this->input->post('nilai-manajerial');
        $nilai_sosiokultural = $this->input->post('nilai-sosiokultural');
        $nilai_teknis = $this->input->post('nilai-teknis');
        $fid_golru = $this->input->post('golru_id');
        $nilai_average = number_format(($nilai_manajerial + $nilai_sosiokultural + $nilai_teknis) / 3, 2);
        $data = [
            'nip' => $nip,
            'input_tahun' => date('Y'),
            'nama_jabatan' => $namajabatan,
            'jabatan_id' => $jabatan_id,
            'unker' => $unker,
            'unker_id' => $unker_id,
            'fid_golru' => $fid_golru,
            'kualifikasi_pendidikan' => $this->mrpk->pendidikan_terakhir($nip),
            'nilai_kompetensi_manajerial' => $nilai_manajerial,
            'nilai_kompetensi_sosiokultural' => $this->input->post('nilai-sosiokultural'),
            'nilai_kompetensi_teknis' => $this->input->post('nilai-teknis'),
            'nilai_average' => $nilai_average,
            'tahun_skp_1' => date('Y')-1,
            'tahun_skp_2' => date('Y')-2,
            'nilai_skp_1' => $this->mrpk->riwayat_skp($nip, date('Y')-1),
            'nilai_skp_2' => $this->mrpk->riwayat_skp($nip, date('Y')-2),
            'rekomendasi_pengembangan' => $this->input->post('rekomendasi_pengembangan')
        ];
        // CEK NIP APAKAH SUDAH ADA DI NILAI
        $cek = $this->mrpk->ceknip('rpk_penilaian', ['nip' => $nip]);
        if($cek->num_rows() > 0) {
            // UPDATE
            $new_arr = array_merge($data, ['update_at' => date('Y:m:d H:i:s')]);
            $update = $this->mrpk->update_nilai('rpk_penilaian', $new_arr, ['nip' => $nip]);
            if($update) {
                $msg= ["msg" => "PENILAIAN BERHASIL DI PERBAHARUI", "code" => 200];
            } else {
                $msg= ["msg" => "PENILAIAN GAGAL DI PERBAHARUI", "code" => 500];
            }
            echo json_encode($msg);
            return false;
        }
        // INPUT
        $new_arr = array_merge($data, ['created_at' => date('Y:m:d H:i:s')]);
        $insert = $this->mrpk->insert_nilai('rpk_penilaian', $new_arr);
        if($insert) {
            $msg= ["msg" => "PENILAIAN BERHASIL DI TAMBAHKAN", "code" => 200];
        } else {
            $msg= ["msg" => "PENILAIAN GAGAL DI TAMBAHKAN", "code" => 500];
        }
        echo json_encode($msg);
    }

    public function validasi()
    {
        $nip = $this->input->get('nip');
        $id_rpk_penilai = $this->input->get('id_rpk_penilai');
        $rekam_jejak = $this->rekam_jejak_jabatan_save_to_string();
        $lainnya = $this->informasi_lain_save_to_string();
        $getNilai = $this->mrpk->getNilai($nip)->row();
        $rekomendasi = $this->mrpk->isRekomendasi($getNilai->nilai_average);
        // UPDATE STATUS JADI 'DONE'
        $this->mrpk->update_nilai('rpk_penilaian', ['status'=>'DONE','rekam_jejak' => $rekam_jejak, 'rekomendasi_pengembangan' => $rekomendasi, 'lainnya' => $lainnya], ['nip' => $nip]);
        // INSERT KE TABLE 'rpk_peta_jabatan'
        $validasi = $this->mrpk->insert_nilai('rpk_peta_jabatan', ['fid_rpk_penilaian' => $id_rpk_penilai]);
        if($validasi) {
            $msg = 'DATA TELAH DI DIVALIDASI';
        } else {
            $msg = 'DATA GAGAL DI DIVALIDASI';
        }
        echo json_encode($msg);
    }
    public function getUnker() 
    {
        $search = $this->input->post('searchParm');
        $row = $this->mrpk->get_unit_kerja('ref_unit_kerjav2', $search)->result_array();
        $data = array();
        foreach($row as $r) {
          $data[] = array(
            "id" => $r['id_unit_kerja'],
            "text" => $r['nama_unit_kerja']
          );
        }
        echo json_encode(['items' => $data]);
    }
    function getJabatan() {
        $unkerId = $this->input->post('unkerId');
        $search = $this->input->post('searchParm');
        
        $getjab = $this->mrpk->getJst($unkerId,$search);
        $getjabfu = $this->mrpk->getJfu($search);
        $getjabft = $this->mrpk->getJft($search);
        
        $data = array();
        foreach($getjab as $r) {
            $data[] = array(
                "id" => $r['nama_jabatan'],
                "text" => $r['nama_jabatan']
            );
        }
        foreach($getjabfu as $r) {
            $data[] = array(
                "id" => $r['nama_jabfu'],
                "text" => $r['nama_jabfu']
            );
        }
        foreach($getjabft as $r) {
            $data[] = array(
                "id" => $r['nama_jabft'],
                "text" => $r['nama_jabft']
            );
        }


      echo json_encode(['items' => $data]);
    }
    // SCREEN RPK "PETA JABATAN"
    public function petajabatan()
    {
        $data['content'] = 'rpk/petajabatan';
        $data['script_petajabatan']  = 'rpk/lib/script_petajabatan';
        $this->load->view('template', $data); 
    }
    public function get_kelas_jabatan($nip) 
    {
        $ideselon = $this->mpegawai->getfideselon($nip);
        $namaeselon = $this->mpegawai->getnamaeselon($ideselon);

        $jnsjab = $this->mkinerja->get_jnsjab($nip);
        if ($jnsjab == "STRUKTURAL") {            
        if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
            $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
            $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);

            $cekkaskpd = $this->mkinerja->cek_kaskpd_eselon4($id_jabstruk);
            $ceksubkeukec = $this->mkinerja->ceksubkeukec_adabendahara($id_jabstruk);
            // cek apakah kasubbag perencanaan dan keuangan pada kecamatan, dan ada jfu bendaharanya
            if ($ceksubkeukec == true) {
            $kelasjabatan = 9;
            } else if ($cekkaskpd == true) {
            $kelasjabatan = 9;
            } else if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
            $kelasjabatan = 8;    
            } else {
            $kelasjabatan = 9;
            }

        } else {
            $kelasjabatan = $this->mkinerja->get_kelasjabstruk($nip);
        }            
        $hargajabatan = $this->mkinerja->get_hargajabstruk($nip);
        //$kelasjabatan = $this->mkinerja->get_kelasjabstruk($nip);
        } else if ($jnsjab == "FUNGSIONAL UMUM") {
        $kelasjabatan = $this->mkinerja->get_kelasjabfu($nip);
        $hargajabatan = $this->mkinerja->get_hargajabfu($nip);
        //$kelasjabatan = "-";
        //$hargajabatan = "-";
        } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
        $kelasjabatan = $this->mkinerja->get_kelasjabft($nip);
        $hargajabatan = $this->mkinerja->get_hargajabft($nip);
        //$kelasjabatan = "-";
        //$hargajabatan = "-";
        }
        return $kelasjabatan;
    }
    function posisi_jabatan($jnsposisi, $posisi_db, $deskposisi) {
        if($jnsposisi === $posisi_db) {
            $posisi = strtoupper($deskposisi);
        } elseif($jnsposisi === $posisi_db) {
            $posisi = strtoupper($deskposisi);
        }elseif($jnsposisi === $posisi_db) {
            $posisi = strtoupper($deskposisi);
        }elseif($jnsposisi === $posisi_db) {
            $posisi = strtoupper($deskposisi);
        }elseif($jnsposisi === $posisi_db) {
            $posisi = strtoupper($deskposisi);
        } else {
            $posisi = '';
        }
        return $posisi;
    }
    public function ajax_petajabatan() {
        $unker = $this->input->post('unkerid');

        $get_data = $this->mrpk->fetch_datatable_petajabatan($unker);
        $data = array();
        $no = $_POST['start'];
      
        foreach($get_data as $r) {
        $kelas = $this->get_kelas_jabatan($r->nip);
        $name = namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang);
        $button = '<button class="btn btn-primary btn-sm btn-block" id="Review" data-toggle="modal" data-target="#inputModal" data-id="'.$r->id.'" data-kelasjab="'.$kelas.'" data-nama="'.$name.'" data-nip="'.$r->nip.'" data-jabatan="'.$r->nama_jabatan.'"><i class="glyphicon glyphicon-signal"></i> REVIEW</button>';
        $button .= '<button class="btn btn-danger btn-sm btn-block" id="Delete" data-id="'.$r->id.'" data-nip="'.$r->nip.'" data-rpk-penilaian="'.$r->fid_rpk_penilaian.'"><i class="glyphicon glyphicon-trash"></i> HAPUS</button>';
        $sub_array = array();
          $sub_array[] = $no+1;
          $sub_array[] = $name."<br>NIP. <b>".$r->nip."</b>";
          $sub_array[] = $r->nama_jabatan;
          $sub_array[] = $this->posisi_jabatan('JPT', $r->posisi_jabatan, $r->deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JA', $r->posisi_jabatan, $r->deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JF_TERAMPIL', $r->posisi_jabatan, $r->deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JF_AHLI', $r->posisi_jabatan, $r->deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JF_FUNGSIONAL', $r->posisi_jabatan, $r->deskripsi_posisi_jabatan);
          $sub_array[] = $kelas;
          $sub_array[] = $r->rekomendasi_pengembangan;
          $sub_array[] = $r->proyeksi_jabatan;
          $sub_array[] = $button;
          $data[] = $sub_array;
      
        $no++;
        }
      
        $output = array(
          'draw'  		  => intval($_POST['draw']),
          'recordsTotal' 	  => $this->mrpk->get_all_data_petajabatan($unker),
          'recordsFiltered' => $this->mrpk->get_filtered_data_petajabatan($unker),
          'data'			  => $data			
        );
      
        echo json_encode($output); 
      }
      public function delete_petajabatan()
      {
        $id = $this->input->post('id');
        $id_rpk_penilai = $this->input->post('id_rpk_penilai');
        $nip = $this->input->post('nip');
        $delete = $this->mrpk->delete_petajabatan('rpk_peta_jabatan', ['id' => $id]);
        if($delete) {
            $this->mrpk->update_nilai('rpk_penilaian', ['status'=>'REVIEW'], ['nip' => $nip]);
            $this->mrpk->delete_instansi('rpk_instansi', ['fid_rpk_peta_jabatan' => $id]);
            $this->mrpk->delete_instansi('rpk_pns', ['fid_rpk_penilaian' => $id_rpk_penilai]);
            $msg = 'DELETED SUCCESS';
        } else {
            $msg = 'DELETED GAGAL';
        }
        echo json_encode($msg);
      }
      public function input_review()
      {
          // From Post
          $p = $this->input->post();
          $id = $p['id'];
          $pj = $p['pj'];
          $posisi_jabatan = !empty($pj) ? $pj : 'JF_FUNGSIONAL';
          $deskripsi_jabatan = array_filter($p['posisi_jabatan']);
          $kelasjab = $p['kelas'];
          // from db 
          $isPetajabatan = $this->mrpk->isPetajabatan($id)->row();
          $isRpkPenilaian = $this->mrpk->isRpkPenilaian($isPetajabatan->fid_rpk_penilaian)->row();
          $proyeksi = $p['proyeksi_jabatan'] != 0 ? $p['proyeksi_jabatan'] : $isPetajabatan->proyeksi_jabatan;
          $rekomendasi = !empty($p['rekomendasi_pengembangan']) ? $p['rekomendasi_pengembangan'] : $isRpkPenilaian->rekomendasi_pengembangan;

        if($posisi_jabatan === 'JPT') {
            $deskjab = !empty($deskripsi_jabatan[0]) ? $deskripsi_jabatan[0] : '';
        } elseif($posisi_jabatan === 'JA') {
            $deskjab = !empty($deskripsi_jabatan[1]) ? $deskripsi_jabatan[1] : '';
        } elseif($posisi_jabatan === 'JF_TERAMPIL') {
            $deskjab = !empty($deskripsi_jabatan[2]) ? $deskripsi_jabatan[2] : '';
        } elseif($posisi_jabatan === 'JF_AHLI') {
            $deskjab = !empty($deskripsi_jabatan[3]) ? $deskripsi_jabatan[3] : ''; 
        } elseif($posisi_jabatan === 'JF_FUNGSIONAL') {
            $deskjab = !empty($deskripsi_jabatan[4]) ? $deskripsi_jabatan[4] : '';  
        }
        
        $deks_jabatan = count($deskripsi_jabatan) > 0 ? $deskjab : $isPetajabatan->deskripsi_posisi_jabatan; 
        if(count($deskripsi_jabatan) > 0) {
            $data = ['posisi_jabatan' => $posisi_jabatan,'deskripsi_posisi_jabatan' => $deks_jabatan,'kelas_jabatan' => $kelasjab,'proyeksi_jabatan' => $proyeksi];
        } else {
            $data = ['deskripsi_posisi_jabatan' => $deks_jabatan,'kelas_jabatan' => $kelasjab,'proyeksi_jabatan' => $proyeksi];
        }
        
        $update = $this->mrpk->update('rpk_peta_jabatan', $data, ['id' => $id]);
        if($update) {
            // CEK APAKAH SUDAH ADA DATA PADA TABLE 'rpk_instansi'
            $cek = $this->mrpk->cek_rpk_instansi($id);
            if($cek->num_rows() == 0) {
                $this->mrpk->insert('rpk_instansi', ['fid_rpk_peta_jabatan' => $id, 'fid_rpk_penilaian' => $isPetajabatan->fid_rpk_penilaian]);
            }
            $this->mrpk->update('rpk_penilaian', ['rekomendasi_pengembangan' => $rekomendasi], ['id' => $isPetajabatan->fid_rpk_penilaian]);
            $msg= ["msg" => "RENCANA PETA JABATAN BERHASIL DI PERBAHARUI", "code" => 200];
        } else {
            $msg= ["msg" => "RENCANA PETA JABATAN GAGAL DI PERBAHARUI", "code" => 500];
        }
        echo json_encode($msg);
      }

    // SCREEN RPK "INSTANSI"
    public function instansi()
    {
        $data['content'] = 'rpk/instansi';
        $data['script_instansi']  = 'rpk/lib/script_instansi';
        $this->load->view('template', $data); 
    }
    public function ajax_instansi() {
        $unker = $this->input->post('unkerid');

        $get_data = $this->mrpk->fetch_datatable_instansi($unker);
        $data = array();
        $no = $_POST['start'];
        foreach($get_data as $r) {
        $name = namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang);
        $action = '<button class="btn btn-primary btn-sm btn-block" id="Input" data-toggle="modal" data-target="#inputModal" data-id="'.$r->id.'" data-nip="'.$r->nip.'" data-nama="'.$name.'" data-jabatan="'.$r->nama_jabatan.'"><i class="glyphicon glyphicon-option-horizontal"></i></button>';
        $sub_array = array();
          $sub_array[] = $no+1;
          $sub_array[] = $name."<br>NIP. <b>".$r->nip."</b>";
          $sub_array[] = $r->nama_jabatan;
          $sub_array[] = $r->rekomendasi_jabatan;
          $sub_array[] = $r->nama_unit_kerja;
          $sub_array[] = $r->lowongan_jabatan;
          $sub_array[] = $this->posisi_jabatan('JPT', $r->rencana_posisi_jabatan, $r->rencana_deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JA', $r->rencana_posisi_jabatan, $r->rencana_deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JF_TERAMPIL', $r->rencana_posisi_jabatan, $r->rencana_deskripsi_posisi_jabatan);
          $sub_array[] = $this->posisi_jabatan('JF_AHLI', $r->rencana_posisi_jabatan, $r-> 	rencana_deskripsi_posisi_jabatan);
          $sub_array[] = $r->bentuk_pengembangan;
          $sub_array[] = $r->tahun_pelaksanaan_ke;
          $sub_array[] = $r->mekanisme_pengisian;
          $sub_array[] = $r->prosedur_pengisian;
          $sub_array[] = $action;
          $data[] = $sub_array;
          $no++;
        }
      
        $output = array(
          'draw'  		  => intval($_POST['draw']),
          'recordsTotal' 	  => $this->mrpk->get_all_data_instansi($unker),
          'recordsFiltered' => $this->mrpk->get_filtered_data_instansi($unker),
          'data'			  => $data			
        );
      
        echo json_encode($output); 
    }
    public function inputRpk()
    {
        $p = $this->input->post();
        $id = $p['id'];
        $pj = $p['pj'];
        $posisi_jabatan = !empty($pj) ? $pj : 'JF_FUNGSIONAL';
        $deskripsi_jabatan = array_filter($p['rencana_posisi_jabatan']);
        // from db 
        $isRpkInstansi = $this->mrpk->isRpkInstansi($id)->row();

        $prosedur = !empty($p['prosedur_pengisian']) ? $p['prosedur_pengisian'] : $isRpkInstansi->prosedur_pengisian;
        $mekanisme = !empty($p['mekanisme_pengisian']) ? $p['mekanisme_pengisian'] : $isRpkInstansi->mekanisme_pengisian;
        $bentuk_pengembangan = !empty($p['bentuk_pengembangan_karir']) ? $p['bentuk_pengembangan_karir'] : $isRpkInstansi->bentuk_pengembangan;
        $lowongan_jabatan = !empty($p['lowongan_jabatan']) ? $p['lowongan_jabatan'] : $isRpkInstansi->lowongan_jabatan;
        $rencana_penempatan = !empty($p['rekomendasi_penempatan']) ? $p['rekomendasi_penempatan'] : $isRpkInstansi->rencana_penempatan;
        $rekomen_jabatan = !empty($p['rekomendasi_jabatan']) ? $p['rekomendasi_jabatan'] : $isRpkInstansi->rekomendasi_jabatan;
        $tahun_pelaksanaan_ke = !empty($p['waktu_pelaksanaan']) ? $p['waktu_pelaksanaan'] : $isRpkInstansi->tahun_pelaksanaan_ke;
        $tahun_pelaksanaan = date('Y') + $tahun_pelaksanaan_ke;

        if($posisi_jabatan === 'JPT') {
            $deskjab = !empty($deskripsi_jabatan[0]) ? $deskripsi_jabatan[0] : '';
        } elseif($posisi_jabatan === 'JA') {
            $deskjab = !empty($deskripsi_jabatan[1]) ? $deskripsi_jabatan[1] : '';
        } elseif($posisi_jabatan === 'JF_TERAMPIL') {
            $deskjab = !empty($deskripsi_jabatan[2]) ? $deskripsi_jabatan[2] : '';
        } elseif($posisi_jabatan === 'JF_AHLI') {
            $deskjab = !empty($deskripsi_jabatan[3]) ? $deskripsi_jabatan[3] : ''; 
        } elseif($posisi_jabatan === 'JF_FUNGSIONAL') {
            $deskjab = !empty($deskripsi_jabatan[4]) ? $deskripsi_jabatan[4] : '';  
        }
        $deks_jabatan = count($deskripsi_jabatan) > 0 ? $deskjab : $isRpkInstansi->rencana_deskripsi_posisi_jabatan; 
        if(count($deskripsi_jabatan) > 0) {
            $new_arr = [
                'rencana_posisi_jabatan' => $posisi_jabatan,
                'rencana_deskripsi_posisi_jabatan' => $deks_jabatan,
                'rekomendasi_jabatan' => $rekomen_jabatan,
                'rencana_penempatan' => $rencana_penempatan,
                'lowongan_jabatan' => $lowongan_jabatan,
                'bentuk_pengembangan' => $bentuk_pengembangan,
                'tahun_pelaksanaan' => $tahun_pelaksanaan,
                'tahun_pelaksanaan_ke' => $tahun_pelaksanaan_ke,
                'mekanisme_pengisian' => $mekanisme,
                'prosedur_pengisian' => $prosedur
            ];
        } else {
            $new_arr = [
                'rekomendasi_jabatan' => $rekomen_jabatan,
                'rencana_penempatan' => $rencana_penempatan,
                'lowongan_jabatan' => $lowongan_jabatan,
                'bentuk_pengembangan' => $bentuk_pengembangan,
                'tahun_pelaksanaan' => $tahun_pelaksanaan,
                'tahun_pelaksanaan_ke' => $tahun_pelaksanaan_ke,
                'mekanisme_pengisian' => $mekanisme,
                'prosedur_pengisian' => $prosedur
            ];
        }

        $update = $this->mrpk->update('rpk_instansi', $new_arr, ['id' => $id]);
        if($update) {
            // CEK APAKAH SUDAH ADA DATA PADA TABLE 'rpk_pns'
            $cek = $this->mrpk->cek_rpk_pns($id);
            if($cek->num_rows() == 0) {
                $this->mrpk->insert('rpk_pns', ['fid_rpk_instansi' => $id, 'fid_rpk_penilaian' => $isRpkInstansi->fid_rpk_penilaian]);
            }
            $msg= ["msg" => "RENCANA PENGEMBANGAN KARIR BERHASIL DI PERBAHARUI", "code" => 200];
        } else {
            $msg= ["msg" => "RENCANA PENGEMBANGAN KARIR GAGAL DI PERBAHARUI", "code" => 500];
        }
        echo json_encode($msg);        
    }

    // SCREEN RPK "PENYELARASAN KOMPETENSI"
    public function kompetensi()
    {
        $data['content'] = 'rpk/kompetensi';
        $data['script_kompetensi']  = 'rpk/lib/script_kompetensi';
        $this->load->view('template', $data); 
    }
    public function ajax_kompetensi() {
        $unker = $this->input->post('unkerid');

        $get_data = $this->mrpk->fetch_datatable_kompetensi($unker);
        $data = array();
        $no = $_POST['start'];
        foreach($get_data as $r) {
        $disabled = ($r->nilai_kompetensi_manajerial == 0) || ($r->nilai_kompetensi_sosiokultural == 0) || ($r->nilai_kompetensi_teknis == 0) ? 'disabled' : '';
        $name = namagelar($r->gelar_depan, $r->nama, $r->gelar_belakang);
        $action = '<button type="button" class="btn btn-primary btn-sm btn-block" id="Input" 
        data-toggle="modal" 
        data-target="#inputModal" 
        data-nilai-manajerial="'.$r->syarat_nilai_kompetensi_manajerial.'"
        data-nilai-sosiokultural="'.$r->syarat_nilai_kompetensi_sosiokultural.'"
        data-nilai-teknis="'.$r->syarat_nilai_kompetensi_teknis.'"
        data-kompetensi-jabatan="'.$r->penyelarasan_jabatan.'"
        data-id="'.$r->id.'" data-nip="'.$r->nip.'" data-nama="'.$name.'"><i class="glyphicon glyphicon-signal"></i></button>';
        if($disabled === 'disabled') {
            $action .= '<button class="btn btn-info btn-sm btn-block" type="button" id="Update" 
            data-toggle="modal" 
            data-target="#updateModal"
            data-nilai-manajerial="'.$r->nilai_kompetensi_manajerial.'"
            data-nilai-sosiokultural="'.$r->nilai_kompetensi_sosiokultural.'"
            data-nilai-teknis="'.$r->nilai_kompetensi_teknis.'"
            data-id="'.$r->fid_rpk_penilaian.'" data-nip="'.$r->nip.'" data-nama="'.$name.'">Update UJIKOM</button>';
        }
        $sub_array = array();
          $sub_array[] = $no+1;
          $sub_array[] = $name."<br>NIP. <b>".$r->nip."</b>";
          $sub_array[] = $r->nilai_kompetensi_manajerial;
          $sub_array[] = $r->nilai_kompetensi_sosiokultural;
          $sub_array[] = $r->nilai_kompetensi_teknis;
          $sub_array[] = $r->tahun_pelaksanaan_ke;
          $sub_array[] = $r->syarat_nilai_kompetensi_manajerial;
          $sub_array[] = $r->syarat_nilai_kompetensi_sosiokultural;
          $sub_array[] = $r->syarat_nilai_kompetensi_teknis;
          $sub_array[] = $r->penyelarasan_jabatan;
          $sub_array[] = $action;
          $data[] = $sub_array;
          $no++;
        }
      
        $output = array(
          'draw'  		  => intval($_POST['draw']),
          'recordsTotal' 	  => $this->mrpk->get_all_data_kompetensi($unker),
          'recordsFiltered' => $this->mrpk->get_filtered_data_kompetensi($unker),
          'data'			  => $data			
        );
      
        echo json_encode($output); 
    }
    public function inputKompetensi()
    {
        $p = $this->input->post();
        $id = $p['id'];
        $kompetensi_jabatan = $p['kompetensi_jabatan'];
        $manajerial = $p['nilai-manajerial'];
        $sosiokultural = $p['nilai-sosiokultural'];
        $teknis = $p['nilai-teknis'];
        // from db 
        $isRpkPns = $this->mrpk->isRpkPns($id)->row();
        $new_arr = [
            'syarat_nilai_kompetensi_manajerial' => !empty($manajerial) ? $manajerial : $isRpkPns->syarat_nilai_kompetensi_manajerial,
            'syarat_nilai_kompetensi_sosiokultural' => !empty($sosiokultural) ? $sosiokultural : $isRpkPns->syarat_nilai_kompetensi_sosiokultural,
            'syarat_nilai_kompetensi_teknis' => !empty($teknis) ? $teknis : $isRpkPns->syarat_nilai_kompetensi_teknis,
            'penyelarasan_jabatan' => !empty($kompetensi_jabatan) ? $kompetensi_jabatan : $isRpkPns->penyelarasan_jabatan
        ];
        $update = $this->mrpk->update('rpk_pns', $new_arr, ['id' => $id]);
        if($update) {
            $msg= ["msg" => "PENYELARASAN JABATAN BERHASIL DI PERBAHARUI", "code" => 200];
        } else {
            $msg= ["msg" => "PENYELARASAN JABATAN GAGAL DI PERBAHARUI", "code" => 500];
        }
        echo json_encode($msg);
    }
    public function updateUjiKom()
    {
        $p = $this->input->post();
        $id = $p['id'];
        // from db 
        $isRpkPenilaian = $this->mrpk->isRpkPenilaian($id)->row();
        $manajerial = !empty($p['nilai-manajerial']) ? $p['nilai-manajerial'] : $isRpkPenilaian->nilai_kompetensi_manajerial;
        $sosiokultural = !empty($p['nilai-sosiokultural']) ? $p['nilai-sosiokultural'] : $isRpkPenilaian->nilai_kompetensi_sosiokultural;
        $teknis = !empty($p['nilai-teknis']) ? $p['nilai-teknis'] : $isRpkPenilaian->nilai_kompetensi_teknis;
        $rekomendasi = !empty($p['rekomendasi_pengembangan']) ? $p['rekomendasi_pengembangan'] : $isRpkPenilaian->rekomendasi_pengembangan;
        $nilai_average = number_format(($manajerial + $sosiokultural + $teknis) / 3, 2);
        $new_arr = [
            'nilai_kompetensi_manajerial' => $manajerial,
            'nilai_kompetensi_sosiokultural' => $sosiokultural,
            'nilai_kompetensi_teknis' => $teknis,
            'rekomendasi_pengembangan' => $rekomendasi,
            'nilai_average' => $nilai_average
        ];
        $update = $this->mrpk->update('rpk_penilaian', $new_arr, ['id' => $id]);
        if($update) {
            $msg= ["msg" => "PENYELARASAN JABATAN BERHASIL DI PERBAHARUI", "code" => 200];
        } else {
            $msg= ["msg" => "PENYELARASAN JABATAN GAGAL DI PERBAHARUI", "code" => 500];
        }
        echo json_encode($msg);
    }

    // SCREEN RPK "REKAP"
    public function rekap()
    {
        $data['content'] = 'rpk/rekap';
        $data['data'] = $this->mrpk->allunker();
        $data['script_rekap']  = 'rpk/lib/script_rekap';
        $this->load->view('template', $data); 
    }
    public function ajax_rekap()
    {
        $id = $this->input->get('id');
        $peg_perunker = $this->mrpk->ceknip('pegawai', ['fid_unit_kerja' => $id])->num_rows();
        $data_perunker = $this->mrpk->ceknip('rpk_penilaian', ['unker_id' => $id]);
        $data_perunker_validasi = $this->mrpk->ceknip('rpk_penilaian', ['unker_id' => $id, 'status' => 'DONE']);
        $total_all = $data_perunker->num_rows();
        $total_validasi = $data_perunker_validasi->num_rows();
        $total_input_nilai = $this->db->where('status', 'DONE')->where('unker_id', $id)->get('rpk_penilaian')->num_rows();
        $data = [
            'total_all' => $peg_perunker,
            'total_input_nilai' => ($peg_perunker - $total_input_nilai),
            'total_validasi' => $total_validasi
        ];
        echo json_encode($data);
    }
    public function unduhData($unker_id)
    {
        $data_profile = $this->mrpk->rekap($unker_id);
        $data_pemetaan = $this->mrpk->rekap_pemetaan($unker_id);
        $data_instansi = $this->mrpk->rekap_instansi($unker_id);
        $data_kompetensi = $this->mrpk->rekap_kompetensi($unker_id);
        require(APPPATH.'third_party/PHPExcel/PHPExcel.php');
        // $obj = new PHPExcel();
        $objPHPExcel = PHPExcel_IOFactory::load("./excel/RPK_TEMPLATE.xlsx");
        // var_dump($data->result());
        $style_cell = [
            'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
                )
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            ),
            'font' => [
                'size' => 10
            ]
        ];
            
            // 1. SHEET PROFILE
            $baris=8;
            $nomor=1;
            foreach($data_profile->result() as $d) {
            $name = namagelar($d->gelar_depan, $d->nama, $d->gelar_belakang);
            $manajerial = $d->nilai_kompetensi_manajerial != 0 ? $d->nilai_kompetensi_manajerial : '-'; 
            $sosiokultural = $d->nilai_kompetensi_sosiokultural != 0 ? $d->nilai_kompetensi_sosiokultural : '-'; 
            $teknis = $d->nilai_kompetensi_teknis != 0 ? $d->nilai_kompetensi_teknis : '-'; 
            
            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, $nomor)
                            ->setCellValue('B'.$baris, $name)
                            ->setCellValue('C'.$baris, $d->nama_jabatan)
                            ->setCellValue('D'.$baris, $d->nip_asn)
                            ->setCellValue('E'.$baris, $d->nama_golru)
                            ->setCellValue('F'.$baris, $d->nama_pangkat)
                            
                            ->setCellValue('G'.$baris, $d->ttl)
                            ->setCellValue('H'.$baris, $d->nama_status_kawin)
                            
                            ->setCellValue('I'.$baris, $d->nama_agama)
                            ->setCellValue('J'.$baris, $d->alamat)
                            ->setCellValue('K'.$baris, $d->nama_unit_kerja)
                            ->setCellValue('L'.$baris, $this->mrpk->pendidikan_terakhir($d->nip))
                            ->setCellValue('M'.$baris, $d->rekam_jejak)
                            ->setCellValue('N'.$baris, $manajerial)
                            ->setCellValue('O'.$baris, $sosiokultural)
                            ->setCellValue('P'.$baris, $teknis)
                            ->setCellValue('Q'.$baris, $this->mrpk->riwayat_skp($d->nip, date('Y')-2))
                            ->setCellValue('R'.$baris, $this->mrpk->riwayat_skp($d->nip, date('Y')-1))
                            ->setCellValue('S'.$baris, $d->lainnya)
                            ->setCellValue('T'.$baris, $d->rekomendasi_pengembangan);

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$baris.':T'.$baris)->applyFromArray($style_cell);                
            
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('J'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('M'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('N'.$baris.':R'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('S'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('T'.$baris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $baris++;
            $nomor++;
        }
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('M')->setWidth(118);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('J')->setWidth(40);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setAutoSize(true);

        // 2. SHEET PEMETAAN JABATAN
        $nomor_pemetaan=1;
        $baris_pemetaan=7;
        $sheet_pemetaan=1;
        foreach($data_pemetaan->result() as $p) {
            $name = namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang);
            $nip = $p->nip_asn;
            $posisijab = strtoupper($p->deskripsi_posisi_jabatan);
            $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)
                            ->setCellValue('A'.$baris_pemetaan, $nomor_pemetaan)
                            ->setCellValue('B'.$baris_pemetaan, $nip)
                            ->setCellValue('C'.$baris_pemetaan, $name)
                            ->setCellValue('D'.$baris_pemetaan, $p->nama_jabatan)
                            ->setCellValue('E'.$baris_pemetaan, $p->unker)
                            ->setCellValue('K'.$baris_pemetaan, $p->kelas_jabatan)
                            ->setCellValue('L'.$baris_pemetaan, $p->proyeksi_jabatan);
            if($p->posisi_jabatan === 'JPT') {
                $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->setCellValue('F'.$baris_pemetaan, $posisijab);
            } elseif($p->posisi_jabatan === 'JA') {
                $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->setCellValue('G'.$baris_pemetaan, $posisijab);
            } elseif($p->posisi_jabatan === 'JF_TERAMPIL') {
                $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->setCellValue('H'.$baris_pemetaan, $posisijab);
            } elseif($p->posisi_jabatan === 'JF_AHLI') {
                $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->setCellValue('I'.$baris_pemetaan, $posisijab);
            } elseif($p->posisi_jabatan === 'JF_FUNGSIONAL') {
                $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->setCellValue('J'.$baris_pemetaan, $posisijab);
            } 
            // COL STYLE
            $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->getStyle('A'.$baris_pemetaan.':L'.$baris_pemetaan)->applyFromArray($style_cell);
            $objPHPExcel->setActiveSheetIndex($sheet_pemetaan)->getStyle('A'.$baris_pemetaan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $baris_pemetaan++;
            $nomor_pemetaan++;  
        }
        // COL WIDTH PEMETAAN
        foreach(range('B','E') as $columnID) {
            $objPHPExcel->getActiveSheet($sheet_pemetaan)->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 3. SHEET RENCANA PENGEMBANGAN KARIR
        $nomor_instansi=1;
        $baris_instansi=7;
        $sheet_instansi=3;
        foreach($data_instansi->result() as $i) {
            $name = namagelar($i->gelar_depan, $i->nama, $i->gelar_belakang);
            $nip = $i->nip_asn;
            $rencana_posisijab = strtoupper($i->rencana_deskripsi_posisi_jabatan);
            $objPHPExcel->setActiveSheetIndex($sheet_instansi)
                            ->setCellValue('A'.$baris_instansi, $nomor_instansi)
                            ->setCellValue('B'.$baris_instansi, $nip)
                            ->setCellValue('C'.$baris_instansi, $name)
                            ->setCellValue('D'.$baris_instansi, $i->nama_jabatan)
                            ->setCellValue('E'.$baris_instansi, $i->rekomendasi_jabatan)
                            ->setCellValue('F'.$baris_instansi, $i->nama_unit_kerja)
                            ->setCellValue('G'.$baris_instansi, $i->lowongan_jabatan)
                            ->setCellValue('L'.$baris_instansi, $i->bentuk_pengembangan)
                            ->setCellValue('M'.$baris_instansi, $i->tahun_pelaksanaan_ke)
                            ->setCellValue('N'.$baris_instansi, $i->mekanisme_pengisian)
                            ->setCellValue('O'.$baris_instansi, $i->prosedur_pengisian);
            if($i->rencana_posisi_jabatan === 'JPT') {
                $objPHPExcel->setActiveSheetIndex($sheet_instansi)->setCellValue('H'.$baris_instansi, $rencana_posisijab);
            } elseif($i->rencana_posisi_jabatan === 'JA') {
                $objPHPExcel->setActiveSheetIndex($sheet_instansi)->setCellValue('I'.$baris_instansi, $rencana_posisijab);
            } elseif($i->rencana_posisi_jabatan === 'JF_TERAMPIL') {
                $objPHPExcel->setActiveSheetIndex($sheet_instansi)->setCellValue('J'.$baris_instansi, $rencana_posisijab);
            } elseif($i->rencana_posisi_jabatan === 'JF_AHLI') {
                $objPHPExcel->setActiveSheetIndex($sheet_instansi)->setCellValue('K'.$baris_instansi, $rencana_posisijab);
            }
            $objPHPExcel->setActiveSheetIndex($sheet_instansi)->getStyle('A'.$baris_instansi.':O'.$baris_instansi)->applyFromArray($style_cell);
            $objPHPExcel->setActiveSheetIndex($sheet_instansi)->getStyle('A'.$baris_instansi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $baris_instansi++;
            $nomor_instansi++; 
        }
        // COL WIDTH RENCANA PENGEMBANGAN KARIR
        foreach(range('B','F') as $columnID) {
            $objPHPExcel->getActiveSheet($sheet_instansi)->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 4. SHEET PENYELARASAN KOMPETENSI
        $nomor_kompetensi=1;
        $baris_kompetensi=6;
        $sheet_kompetensi=4;
        foreach($data_kompetensi->result() as $k) {
            $name = namagelar($k->gelar_depan, $k->nama, $k->gelar_belakang);
            $nip = $k->nip_asn;
            $objPHPExcel->setActiveSheetIndex($sheet_kompetensi)
                            ->setCellValue('A'.$baris_kompetensi, $nomor_kompetensi)
                            ->setCellValue('B'.$baris_kompetensi, $nip)
                            ->setCellValue('C'.$baris_kompetensi, $name)
                            ->setCellValue('D'.$baris_kompetensi, $k->nilai_kompetensi_manajerial)
                            ->setCellValue('E'.$baris_kompetensi, $k->nilai_kompetensi_sosiokultural)
                            ->setCellValue('F'.$baris_kompetensi, $k->nilai_kompetensi_teknis)
                            ->setCellValue('G'.$baris_kompetensi, $k->tahun_pelaksanaan_ke)
                            ->setCellValue('H'.$baris_kompetensi, $k->syarat_nilai_kompetensi_manajerial)
                            ->setCellValue('I'.$baris_kompetensi, $k->syarat_nilai_kompetensi_sosiokultural)
                            ->setCellValue('J'.$baris_kompetensi, $k->syarat_nilai_kompetensi_teknis)
                            ->setCellValue('K'.$baris_kompetensi, $k->penyelarasan_jabatan);
            
            $objPHPExcel->setActiveSheetIndex($sheet_kompetensi)->getStyle('A'.$baris_kompetensi.':K'.$baris_kompetensi)->applyFromArray($style_cell);
            $objPHPExcel->setActiveSheetIndex($sheet_kompetensi)->getStyle('A'.$baris_kompetensi)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $baris_kompetensi++;
            $nomor_kompetensi++; 
        }
        // COL WIDTH PENYELARASAN KOMPETENSI
        foreach(range('B','C') as $columnID) {
            $objPHPExcel->getActiveSheet($sheet_kompetensi)->getColumnDimension($columnID)->setAutoSize(true);
        }
        $filename = 'DataRPK-'.$this->mrpk->unker_name($unker_id).' '.date('Y').'.xlsx';
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Proteksi Excel untuk sheet pertama 'profile'
        // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
        // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('1');
        
        
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        
        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
}