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
      $this->load->model('mpetajab');
      $this->load->model('mpppk');
      $this->load->model('mtppng');
      $this->load->model('mnonpns');
      $this->load->model('mstatistik');
      $this->load->model('munker');
      $this->load->model('mcuti');	
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
                'no_handphone' => $p['no_handphone'],
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
  		'tmt_jabatan' => tgl_sql($p['tmt_jabatan']),
  		'fid_golru_pppk' => $p['fid_golru_pppk'],
  		'tmt_golru_pppk' => tgl_sql($p['tmt_golru_pppk']),
  		'maker_tahun' => $p['maker_tahun'],
  		'maker_bulan' => $p['maker_bulan'],
                'tmt_pppk_awal' => tgl_sql($p['tmt_pppk_awal']),
  		'tmt_pppk_akhir' => tgl_sql($p['tmt_pppk_akhir']),
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
  		'tmt_jabatan' => tgl_sql($p['tmt_jabatan']),
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
        echo "<div style='padding:0px;overflow:auto;width:99%;height:100%;border:1px solid white' >";

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
	    <?php
                $detail_pejab = $this->mpetajab->detailKomponenJabatan($v['fid_peta_jabatan'])->result_array();
                foreach($detail_pejab as $dp) {
                        $nmjab_pj = $this->mpetajab->get_namajab($dp['id']);
                        $jnsjab_pj = $this->mpetajab->get_namajnsjab($dp['fid_jnsjab']);
                        $unor = $this->mpetajab->get_namaunor($dp['fid_atasan']);
                        echo $unor;
                        echo "</small>";
                        echo "<br/><span class='label label-info'>".$jnsjab_pj."</span><br/>".$nmjab_pj;
                        echo " <span class='text text-info'>(Kelas : ".$dp['kelas'].")</span>";
                }

	    ?>
            <?php //echo $v['nama_jabft'];?><br />
            <?php //echo $v['nama_unit_kerja'];?>        
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
      $data['pegrwyabs'] = $this->mpppk->rwyabsensi($nipppk)->result_array();
      $data['pegrwykin'] = $this->mpppk->rwykinerja($nipppk)->result_array();
      $data['pegrwykinbkn'] = $this->mpppk->rwykinerjabkn($nipppk)->result_array();	
      $data['pegrwytppng'] = $this->mpppk->rwytppng($nipppk)->result_array();	
      $data['pegrwycuti'] = $this->mpppk->rwycuti($nipppk)->result_array();	

      $data['nipppk'] = $nipppk;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'pppk/rwygaji';
      $this->load->view('template', $data);
    }
  }

  function tambahskpbulanan_aksi() {
    $nipppk = addslashes($this->input->post('nipppk'));
    $thn = '2024';
    $bln = addslashes($this->input->post('bln'));
    $jab = addslashes($this->input->post('jab'));
    $unker = addslashes($this->input->post('unker'));
    $nip_atasan = addslashes($this->input->post('nip_atasan'));
    $nama_atasan = addslashes($this->input->post('nama_atasan'));
    $jab_atasan = addslashes($this->input->post('jab_atasan'));
    $unker_atasan = addslashes($this->input->post('unker_atasan'));
    $hasilkerja = addslashes($this->input->post('hasilkerja'));
    $perilakukerja = addslashes($this->input->post('perilakukerja'));
    $predikatkinerja = addslashes($this->input->post('predikatkinerja'));

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $nama = $this->mpppk->getnama($nipppk);

    $data = array(
      'nip'                  => $nipppk,
      'nama'		     => $nama,	 	
      'tahun'                => $thn,
      'bulan'                => $bln,
      'skp_jabatan'          => $jab,
      'skp_unor'             => $unker,
      'pegawai_atasan_nip'   => $nip_atasan,
      'pegawai_atasan_nama'     => $nama_atasan,
      'pegawai_atasan_jabatan'  => $jab_atasan,
      'pegawai_atasan_unor'  => $unker_atasan,
      'hasil_kerja'          => $hasilkerja,
      'perilaku_kerja'       => $perilakukerja,
      'hasil_akhir'          => $predikatkinerja,
      'waktu_dinilai'        => $tgl_aksi,
    );

   if ($this->mpegawai->insert_table('riwayat_kinerja_bkn', $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Penilaian Kinerja ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL DITAMBAH.";
      $data['jnspesan'] = "alert alert-success";
   } else {
      $data['pesan'] = "<b>GAGAL</b>, TPP ".$nama." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL DITAMBAH.";
      $data['jnspesan'] = "alert alert-warning";
   }

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

  public function deleteskp2024()
  {
        $id = $this->input->post('id');
        $nipppk = $this->input->post('nip');
	$nmberkas = $this->input->post('nmberkas');

        $tbl = 'riwayat_kinerja_bkn';

        $nama = $this->mpppk->getnama($nipppk);

        // jika nip ada
        if($nipppk != '') {
                // hapus riwayat kinerja BKN berdasarkan id
                $del = $this->mpegawai->delete_table($tbl, ['id' => $id]);
                // jika hapus pada database, true
                if($del) {
	              	if (file_exists('./fileskpbulanan_pppk/'.$nmberkas.'.pdf')) {
	                  unlink('./fileskpbulanan_pppk/'.$nmberkas.'.pdf');
        	      	} elseif (file_exists('./fileskpbulanan_pppk/'.$nmberkas.'.PDF')) {
                	  unlink('./fileskpbulanan_pppk/'.$nmberkas.'.PDF');
              		}

                        // callback pesan, true
                        $data['pesan'] = '<b>Sukses</b>, Riwayat Kinerja BKN PNS <u>'.$nama.'</u> berhasil dihapus.';
        		$data['jnspesan'] = 'alert alert-success';
                } else {
                        // callback pesan, false
                        $data['pesan'] = '<b>Gagal</b>, Riwayat Kinerja BKN PNS <u>'.$nama.'</u> gagal dihapus.';
        		$data['jnspesan'] = 'alert alert-danger';
                }
        }

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

  function rwycuti()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") {
      $nipppk = $this->input->post('nipppk');
      $data['pegrwycuti'] = $this->mpppk->rwycuti($nipppk)->result_array();

      $data['nipppk'] = $nipppk;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'pppk/rwycuti';
      $this->load->view('template', $data);
    }
  }

  function rwykgb()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") {
      $nipppk = $this->input->post('nipppk');
      $data['pegrwykgb'] = $this->mpppk->rwykgb($nipppk)->result_array();

      $data['nipppk'] = $nipppk;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'pppk/rwykgb';
      $this->load->view('template', $data);
    }
  }

  function rwykel()
  {
    $nipppk = $this->input->post('nipppk');
    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nipppk)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nipppk)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nipppk)->result_array();
    $data['nipppk'] = $nipppk;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function tambahsutri_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $niksutri = addslashes($this->input->post('niksutri'));	
    $namasutri = strtoupper(addslashes($this->input->post('namasutri')));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $alamat = strtoupper($this->input->post('alamat'));
    $aktanikah = addslashes($this->input->post('aktanikah'));
    $tglnikah = tgl_sql($this->input->post('tglnikah'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));

    $sutri_ke = $this->mpegawai->cek_jmlsutri($nip)+1;

    $statuskawin = addslashes($this->input->post('statuskawin'));
    $statushidup = addslashes($this->input->post('statushidup'));
    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }

    $tanggungan = addslashes($this->input->post('tanggungan'));
    if ($tanggungan != 'YA') {
      $tanggungan = 'TIDAK';
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
      'nik_sutri'	  => $niksutri,  	
      'nipppk'               => $nip,
      'nama_sutri'        => $namasutri,
      'tgl_nikah'         => $tglnikah,
      'no_akta_nikah'     => $aktanikah,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'fid_agama'         => $fid_agama,
      'alamat'         	  => $alamat,
      'pekerjaan'         => $pekerjaan,
      'no_karisu'         => $nokarisu,
      'nip_sutri'         => $nipsutri,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tanggungan'        => $tanggungan,
      'tgl_cerai'         => $tglcerai,
      'no_akta_cerai'     => $aktacerai,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $nama = $this->mpppk->getnama($nip);
    $jnskel = $this->mpppk->getjnskel($nip);
    if ($jnskel == 'PRIA') {
      $ketsutri = "Istri";
    } else if ($jnskel == 'WANITA') {
      $ketsutri = "Suami";
    }

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpppk->cek_sutri($nip, $tglnikah) == 0) {
      if ($this->mpppk->input_sutri($datasutri))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data '.$ketsutri.' PPPK A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data '.$ketsutri.' PPPPK A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nip)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nip)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nip)->result_array();
    $data['nipppk'] = $nip;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function hapussutri_aksi(){
    $nipppk = addslashes($this->input->post('nipppk'));	
    $tgl_nikah = addslashes($this->input->post('tgl_nikah'));

    $nama = $this->mpppk->getnama($nipppk);
    $where = array('nipppk' => $nipppk,
                   'tgl_nikah' => $tgl_nikah
             );

    $nama = $this->mpppk->getnama($nipppk);
    $jnskel = $this->mpppk->getjnskel($nipppk);
    if ($jnskel == 'PRIA') {
      $ketsutri = "Istri";
    } else if ($jnskel == 'WANITA') {
      $ketsutri = "Suami";
    }

    // cek apakah data yang akan dihapus ada
    if ($this->mpppk->cek_adasutri($nipppk, $tgl_nikah) != 0) {
      if ($this->mpppk->hapus_sutri($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data '.$ketsutri.' PPPK A.n. <u>'.$nama.'</u> berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Data '.$ketsutri.' PPPK A.n. <u>'.$nama.'</u> gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nipppk)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nipppk)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nipppk)->result_array();
    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function editsutri_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $niksutri = addslashes($this->input->post('niksutri'));
    $tgl_nikah_lama = addslashes($this->input->post('tgl_nikah_lama'));

    $namasutri = strtoupper(addslashes($this->input->post('namasutri')));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $alamat = strtoupper($this->input->post('alamat'));

    $aktanikah = addslashes($this->input->post('aktanikah'));
    $tglnikah = tgl_sql($this->input->post('tglnikah'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));

    $statuskawin = $this->input->post('statuskawin');
    $statushidup = addslashes($this->input->post('statushidup'));
    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }

    $tanggungan = addslashes($this->input->post('tanggungan'));
    if ($tanggungan != 'YA') {
      $tanggungan = 'TIDAK';
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
      'nik_sutri'         => $niksutri,
      'nama_sutri'        => $namasutri,
      'no_akta_nikah'     => $aktanikah,
      'tgl_nikah'         => $tglnikah,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'fid_agama'         => $fid_agama,
      'alamat'            => $alamat,
      'pekerjaan'         => $pekerjaan,
      'no_karisu'         => $nokarisu,
      'nip_sutri'         => $nipsutri,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tanggungan'        => $tanggungan,
      'tgl_cerai'         => $tglcerai,
      'no_akta_cerai'     => $aktacerai,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'updated_at'        => $tgl_aksi,
      'updated_by'        => $user
      );

    $nama = $this->mpppk->getnama($nip);
    $jnskel = $this->mpppk->getjnskel($nip);
    if ($jnskel == 'PRIA') {
      $ketsutri = "Istri";
    } else if ($jnskel == 'WANITA') {
      $ketsutri = "Suami";
    }

    $where = array(
      'nipppk'    => $nip,
      'tgl_nikah'  => $tgl_nikah_lama
    );

    $nama = $this->mpppk->getnama($nip);
    if ($this->mpppk->edit_sutri($where, $datasutri))
    {
      // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data '.$ketsutri.' PPPK A.n. <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data '.$ketsutri.' PPPK A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nip)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nip)->result_array();
    //untuk anak`
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nip)->result_array();
    $data['nipppk'] = $nip;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function tambahanak_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $nikanak = addslashes($this->input->post('nikanak'));
    $namaanak = strtoupper(addslashes($this->input->post('namaanak')));
    $fidsutri = addslashes($this->input->post('fid_sutri'));
    $jnskelamin = addslashes($this->input->post('jns_kelamin'));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $alamat = strtoupper($this->input->post('alamat'));

    $aktalahir = addslashes($this->input->post('aktalahir'));
    $status = addslashes($this->input->post('status'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));
    $statuskawin = addslashes($this->input->post('statuskawin'));
    $statushidup = addslashes($this->input->post('statushidup'));
    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }
    $tanggungan = addslashes($this->input->post('tanggungan'));
    $tglmeninggal = $this->input->post('tglmeninggal');
    $aktameninggal = addslashes($this->input->post('aktameninggal'));

    if ($tglmeninggal != '') {
      $tglmeninggal = tgl_sql($tglmeninggal);
    } else {
      $tglmeninggal = null;
    }

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $dataanak = array(
      'nik_anak'          => $nikanak,
      'nipppk'            => $nip,
      'nama_anak'         => $namaanak,
      'fid_sutri'	  => $fidsutri,
      'jns_kelamin'	  => $jnskelamin, 	
      'tmp_lahir'         => $tmplahir,
      'fid_agama'         => $fid_agama,
      'alamat'            => $alamat,
      'no_akta_lahir'	  => $aktalahir,	
      'tgl_lahir'         => $tgllahir,
      'status'		  => $status,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'tanggungan'        => $tanggungan,
      'pekerjaan'         => $pekerjaan,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $nama = $this->mpppk->getnama($nip);
    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpppk->cek_anak($nip, $namaanak, $tgllahir) == 0) {
      if ($this->mpppk->input_anak($dataanak))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Anak PPPK A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Anak PPPPK A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nip)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nip)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nip)->result_array();
    $data['nipppk'] = $nip;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function hapusanak_aksi(){
    $nipppk = addslashes($this->input->post('nipppk'));
    $id = addslashes($this->input->post('id'));

    $nama = $this->mpppk->getnama($nipppk);
    $where = array('nipppk' => $nipppk,
                   'id' => $id
             );

    $nama = $this->mpppk->getnama($nipppk);

    // cek apakah data yang akan dihapus ada
    if ($this->mpppk->hapus_anak($where)) {
          $data['pesan'] = '<b>Sukses</b>, Data Anak PPPK A.n. <u>'.$nama.'</u> berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
    } else {
          $data['pesan'] = '<b>Gagal</b>, Data Anak PPPK A.n. <u>'.$nama.'</u> gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nipppk)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nipppk)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nipppk)->result_array();
    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function editanak_aksi() {
    $id = addslashes($this->input->post('id')); 
    $nip = addslashes($this->input->post('nip'));

    $nikanak = addslashes($this->input->post('nikanak'));
    $namaanak = strtoupper(addslashes($this->input->post('namaanak')));
    $fidsutri = addslashes($this->input->post('fid_sutri'));
    $jnskelamin = addslashes($this->input->post('jns_kelamin'));
    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $alamat = strtoupper($this->input->post('alamat'));

    $aktalahir = addslashes($this->input->post('aktalahir'));
    $status = addslashes($this->input->post('status'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));
    $statuskawin = addslashes($this->input->post('statuskawin'));
    $statushidup = addslashes($this->input->post('statushidup'));
    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }
    $tanggungan = addslashes($this->input->post('tanggungan'));
    $tglmeninggal = $this->input->post('tglmeninggal');
    $aktameninggal = addslashes($this->input->post('aktameninggal'));

    if ($tglmeninggal != '') {
      $tglmeninggal = tgl_sql($tglmeninggal);
    } else {
      $tglmeninggal = null;
    }

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $dataanak = array(
      'nik_anak'          => $nikanak,
      'nipppk'            => $nip,
      'nama_anak'         => $namaanak,
      'fid_sutri'         => $fidsutri,
      'jns_kelamin'       => $jnskelamin,
      'tmp_lahir'         => $tmplahir,
      'no_akta_lahir'     => $aktalahir,
      'tgl_lahir'         => $tgllahir,
      'fid_agama'         => $fid_agama,
      'alamat'            => $alamat,
      'status'            => $status,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'tanggungan'        => $tanggungan,
      'pekerjaan'         => $pekerjaan,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $where = array(
      'nipppk'  => $nip,
      'id'  	=> $id
    );

    $nama = $this->mpppk->getnama($nip);
    if ($this->mpppk->edit_anak($where, $dataanak))
    {
      // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data Anak PPPK A.n. <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data Anak PPPK A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nip)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nip)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nip)->result_array();
    $data['nipppk'] = $nip;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function tambahortu_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $jenis = strtoupper(addslashes($this->input->post('jenis')));
    $nikortu = addslashes($this->input->post('nikortu'));
    $namaortu = strtoupper(addslashes($this->input->post('namaortu')));

    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $alamat = strtoupper($this->input->post('alamat'));

    $niportu = addslashes($this->input->post('niportu'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));
    $statuskawin = addslashes($this->input->post('statuskawin'));
    $statushidup = addslashes($this->input->post('statushidup'));
    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }
    $tglmeninggal = $this->input->post('tglmeninggal');
    $aktameninggal = addslashes($this->input->post('aktameninggal'));

    if ($tglmeninggal != '') {
      $tglmeninggal = tgl_sql($tglmeninggal);
    } else {
      $tglmeninggal = null;
    }

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $dataortu = array(
      'nipppk'            => $nip,
      'nik_ortu'          => $nikortu,
      'nama_ortu'         => $namaortu,
      'jenis'		  => $jenis,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'	  => $tgllahir,	
      'fid_agama'         => $fid_agama,
      'alamat'            => $alamat,
      'nip_ortu'          => $niportu,
      'asn'               => $pekerjaan,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $nama = $this->mpppk->getnama($nip);
    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpppk->cek_adaortu($nip, $jenis) == 0) {
      if ($this->mpppk->input_ortu($dataortu))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data '.$jenis.' PPPK A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data '.$jenis.' PPPPK A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nip)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nip)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nip)->result_array();
    $data['nipppk'] = $nip;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function hapusortu_aksi(){
    $nipppk = addslashes($this->input->post('nipppk'));
    $jenis = addslashes($this->input->post('jenis'));

    $nama = $this->mpppk->getnama($nipppk);
    $where = array('nipppk' => $nipppk,
                   'jenis' => $jenis
             );

    $nama = $this->mpppk->getnama($nipppk);

    // cek apakah data yang akan dihapus ada
    if ($this->mpppk->hapus_ortu($where)) {
          $data['pesan'] = '<b>Sukses</b>, Data '.$jenis.' PPPK A.n. <u>'.$nama.'</u> berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
    } else {
          $data['pesan'] = '<b>Gagal</b>, Data '.$jenis.' PPPK A.n. <u>'.$nama.'</u> gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nipppk)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nipppk)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nipppk)->result_array();
    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  function editortu_aksi() {
    $id = addslashes($this->input->post('id'));
    $nip = addslashes($this->input->post('nip'));

    $jenis = strtoupper(addslashes($this->input->post('jenis')));
    $nikortu = addslashes($this->input->post('nikortu'));
    $namaortu = strtoupper(addslashes($this->input->post('namaortu')));

    $tmplahir = strtoupper(addslashes($this->input->post('tmplahir')));
    $tgllahir = tgl_sql($this->input->post('tgllahir'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $alamat = strtoupper($this->input->post('alamat'));

    $niportu = addslashes($this->input->post('niportu'));
    $pekerjaan = addslashes($this->input->post('pekerjaan'));
    $statuskawin = addslashes($this->input->post('statuskawin'));
    $statushidup = addslashes($this->input->post('statushidup'));
    if ($statushidup != 'YA') {
      $statushidup = 'TIDAK';
    }
    $tglmeninggal = $this->input->post('tglmeninggal');
    $aktameninggal = addslashes($this->input->post('aktameninggal'));

    if ($tglmeninggal != '') {
      $tglmeninggal = tgl_sql($tglmeninggal);
    } else {
      $tglmeninggal = null;
    }

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $where = array(
      'nipppk'  => $nip,
      'id'      => $id
    );

    $dataortu = array(
      'nik_ortu'          => $nikortu,
      'nama_ortu'         => $namaortu,
      'jenis'             => $jenis,
      'tmp_lahir'         => $tmplahir,
      'tgl_lahir'         => $tgllahir,
      'fid_agama'         => $fid_agama,
      'alamat'            => $alamat,
      'nip_ortu'          => $niportu,
      'asn'               => $pekerjaan,
      'status_kawin'      => $statuskawin,
      'status_hidup'      => $statushidup,
      'tgl_meninggal'     => $tglmeninggal,
      'no_akta_meninggal' => $aktameninggal,
      'created_at'        => $tgl_aksi,
      'created_by'        => $user
      );

    $nama = $this->mpppk->getnama($nip);
    if ($this->mpppk->edit_ortu($where, $dataortu))
    {
      // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data '.$jenis.' PPPK A.n. <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data '.$jenis.' PPPK A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }

    // untuk ortu
    $data['pegrwyot'] = $this->mpppk->rwyot($nip)->result_array();
    // untuk sutri
    $data['pegrwyst'] = $this->mpppk->rwyst($nip)->result_array();
    //untuk anak
    $data['pegrwyanak'] = $this->mpppk->rwyanak($nip)->result_array();
    $data['nipppk'] = $nip;
    $data['content'] = 'pppk/rwykel';
    $this->load->view('template', $data);
  }

  // Start Riwayat Diklat
  function rwydik()
  {
    $nipppk = $this->input->post('nipppk');
    // untuk diklat struktural
    //$data['pegrwyds'] = $this->mpppk->rwyds($nipppk)->result_array();
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function showtambahdikfung() {
    $nipppk = $this->input->get('nipppk');
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
          <form method='POST' action='../pppk/rwydik'>
            <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pppk/tambahdikfung_aksi'>
      <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
      <table class="table table-condensed table-hover">
        <tr>
          <td align='left' colspan='2'>
          <small class="text-muted" style="color: red;">SELURUH DATA HARUS DIISI LENGKAP<br/>
          Untuk data tanggal harus dengan format hari-bulan-tahun (dd-mm-yyyy)</small>
          </td>
        </tr>
        <tr>
          <td width='160' align='right'>Nama :</td>
          <td><?php echo $this->mpppk->getnama_lengkap($nipppk); ?></td>
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
          <td>Tgl. SK&nbsp&nbsp  <input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' required />
          <small>Wajib Diisi (format: dd-mm-yyyy)</small></td>
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
    $nipppk = addslashes($this->input->post('nipppk'));
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
      'nipppk'      => $nipppk,
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

    $nama = $this->mpegawai->getnama($nipppk);

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpppk->cek_dikfung($nipppk, $namadiklat, $tahun) == 0) {
      if ($this->mpppk->input_dikfung($datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Fungsional PPPK A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Fungsional PPPK A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function hapusdikfung_aksi(){
    $nipppk = addslashes($this->input->post('nipppk'));
    $no = addslashes($this->input->post('no'));
    $tahun = addslashes($this->input->post('tahun'));
    $nama = $this->mpegawai->getnama($nipppk);
    $where = array('nipppk' => $nipppk,
                   'no' => $no,
                   'tahun' => $tahun
             );

    // cek apakah data yang akan dihapus ada
    if ($this->mpppk->cek_adadikfung($nipppk, $no, $tahun) != 0) {
      if ($this->mpppk->hapus_dikfung($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Diklat Fungsional PPPK A.n. '.$nama.', Tahun '.$tahun.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Diklat Fungsional PPPK A.n. '.$nama.', Tahun '.$tahun.' gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function editdikfung() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") {
      $nipppk = $this->input->post('nipppk');
      $no = $this->input->post('no');
      $tahun = $this->input->post('tahun');

      $data['dikfung'] = $this->mpppk->detaildikfung($nipppk, $no, $tahun)->result_array();
      $data['nipppk'] = $nipppk;
      $data['no'] = $no;
      $data['tahun'] = $tahun;
      $data['content'] = 'pppk/editdikfung';
      $this->load->view('template', $data);
    }
  }

  function editdikfung_aksi() {
    $nipppk = addslashes($this->input->post('nipppk'));
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
      'nipppk'      => $nipppk,
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
      'nipppk'    => $nipppk,
      'no'     => $no,
      'tahun'  => $tahun_lama
    );

    $nama = $this->mpppk->getnama_lengkap($nipppk);

      if ($this->mpppk->edit_dikfung($where, $datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Fungsional PPPK A.n. <u>'.$nama.'</u> berhasil dirubah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Fungsional PPPK A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function showtambahdiktek() {
    $nipppk = $this->input->get('nipppk');
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
          <form method='POST' action='../pppk/rwydik'>
            <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pppk/tambahdiktek_aksi'>
      <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
      <table class="table table-condensed table-hover">
        <tr>
          <td align='left' colspan='2'>
          <small class="text-muted" style="color: red;">SELURUH DATA HARUS DIISI LENGKAP<br/>
          Untuk data tanggal harus dengan format hari-bulan-tahun (dd-mm-yyyy)</small>
          </td>
        </tr>
        <tr>
          <td width='160' align='right'>Nama :</td>
          <td><?php echo $this->mpppk->getnama_lengkap($nipppk); ?></td>
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
          <td>Tgl. SK&nbsp&nbsp  <input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' required /> <small>Wajib Diisi (format: dd-$
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
    $nipppk = addslashes($this->input->post('nipppk'));
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
      'nipppk'             => $nipppk,
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

    $nama = $this->mpppk->getnama_lengkap($nipppk);
    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpppk->cek_diktek($nipppk, $namadiklat, $tahun) == 0) {
      if ($this->mpppk->input_diktek($datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Teknis PPPK A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Teknis PPPK A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function hapusdiktek_aksi(){
    $nipppk = addslashes($this->input->post('nipppk'));
    $no = addslashes($this->input->post('no'));
    $tahun = addslashes($this->input->post('tahun'));
    $nama = $this->mpppk->getnama_lengkap($nipppk);
    $where = array('nipppk' => $nipppk,
                   'no' => $no,
                   'tahun' => $tahun
             );

    // cek apakah data yang akan dihapus ada
    if ($this->mpppk->cek_adadiktek($nipppk, $no, $tahun) != 0) {
      if ($this->mpppk->hapus_diktek($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Diklat Teknis PPPK A.n. '.$nama.', Tahun '.$tahun.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Diklat Teknis PPPK A.n. '.$nama.', Tahun '.$tahun.' gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function editdiktek() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") {
      $nipppk = $this->input->post('nipppk');
      $no = $this->input->post('no');
      $tahun = $this->input->post('tahun');

      $data['diktek'] = $this->mpppk->detaildiktek($nipppk, $no, $tahun)->result_array();
      $data['nipppk'] = $nipppk;
      $data['no'] = $no;
      $data['tahun'] = $tahun;
      $data['content'] = 'pppk/editdiktek';
      $this->load->view('template', $data);
    }
  }

  function editdiktek_aksi() {
    $nipppk = addslashes($this->input->post('nipppk'));
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
      'nipppk'                => $nipppk,
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
      'nipppk'    => $nipppk,
      'no'     => $no,
      'tahun'  => $tahun_lama
    );

    $nama = $this->mpppk->getnama_lengkap($nipppk);

      if ($this->mpppk->edit_diktek($where, $datadik))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Diklat Teknis PPPK A.n. <u>'.$nama.'</u> berhasil dirubah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Diklat Teknis PPPK A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }

    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();
    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function showtambahws() {
    $nipppk = $this->input->get('nipppk');
    ?>

    <div class="panel panel-info" style='width :800px'>
      <!-- Default panel contents -->
      <div class="panel-heading" align='center'><b>TAMBAH DATA PENGEMBANGAN KOMPETENSI LAINNYA</b></div>
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../pppk/rwydik'>
            <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' action='../pppk/tambahws_aksi'>
      <input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='<?php echo $nipppk; ?>'>
      <table class="table table-condensed table-hover">
        <tr>
          <td align='left' colspan='2'>
          <small class="text-muted" style="color: red;">SELURUH DATA HARUS DIISI LENGKAP<br/>
          Untuk data tanggal harus dengan format hari-bulan-tahun (dd-mm-yyyy)</small>
          </td>
                </tr>
        <tr>
          <td width='260' align='right'>Nama :</td>
          <td><?php echo $this->mpppk->getnama_lengkap($nipppk); ?></td>
        </tr>
        <tr>
          <td align='right'>Jenis Kegiatan :</td>
          <td>
            <select name="fid_jenis" id="fid_jenis" required >
              <option value='0' selected>-- Pilih Jenis --</option>
               <?php
               $jnsjd = $this->mpegawai->jenis_workshop()->result_array();
               foreach($jnsjd as $jd) {
                    echo "<option value='".$jd['id_jenis_workshop']."'>".$jd['nama_jenis_workshop']."</option>";
               }
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td align='right'>Rumpun Diklat :</td>
          <td>
            <select name="fid_rumpun" id="fid_rumpun" required >
              <option value='0' selected>-- Pilih Rumpun --</option>
               <?php
               $jnsw = $this->mpegawai->rumpun_diklat()->result_array();
               foreach($jnsw as $jw) {
                    echo "<option value='".$jw['id_rumpun_diklat']."'>".$jw['nama_rumpun_diklat']."</option>";
               }
               ?>
            </select>
          </td>
        </tr>
        <tr>
          <td align='right'>Nama Kegiatan :</td>
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
    $nipppk = addslashes($this->input->post('nipppk'));
    $fid_jenis = addslashes($this->input->post('fid_jenis'));
    $fid_rumpun = addslashes($this->input->post('fid_rumpun'));
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
      'nipppk'             => $nipppk,
      'fid_jenis_workshop'      => $fid_jenis,
      'fid_rumpun_diklat'      => $fid_rumpun,
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

    $nama = $this->mpppk->getnama_lengkap($nipppk);
    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mpppk->cek_ws($nipppk, $namaws, $tahun) == 0) {
      if ($this->mpppk->input_ws($dataws))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Pengembangan Kompetensi Lainnya PPPK A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Pengembangan Kompetensi Lainnya PPPK A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan.';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function hapusws_aksi(){
    $nipppk = addslashes($this->input->post('nipppk'));
    $no = addslashes($this->input->post('no'));
    $tahun = addslashes($this->input->post('tahun'));
    $nama = $this->mpppk->getnama_lengkap($nipppk);
    $where = array('nipppk' => $nipppk,
                   'no' => $no,
                   'tahun' => $tahun
             );

    // cek apakah data yang akan dihapus ada
    if ($this->mpppk->cek_adaws($nipppk, $no, $tahun) != 0) {
      if ($this->mpppk->hapus_ws($where)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Riwayat Kompetensi Lainnya PPPK A.n. '.$nama.', Tahun '.$tahun.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal</b>, Riwayat kompetensi Lainnya PPPK A.n. '.$nama.', Tahun '.$tahun.' gagal dihapus';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
    }

    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();

    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }

  function editws() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('edit_profil_priv') == "Y") {
      $nipppk = $this->input->post('nipppk');
      $no = $this->input->post('no');
      $tahun = $this->input->post('tahun');

      $data['diktek'] = $this->mpppk->detailws($nipppk, $no, $tahun)->result_array();
      $data['nipppk'] = $nipppk;
      $data['no'] = $no;
      $data['tahun'] = $tahun;
      $data['content'] = 'pppk/editws';
      $this->load->view('template', $data);
    }
  }

  function editws_aksi() {
    $nipppk = addslashes($this->input->post('nipppk'));
    $fid_jenis = addslashes($this->input->post('fid_jenis'));
    $fid_rumpun = addslashes($this->input->post('fid_rumpun'));
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
      'nipppk'                => $nipppk,
      'fid_jenis_workshop'      => $fid_jenis,
      'fid_rumpun_diklat'      => $fid_rumpun,
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
      'nipppk'    => $nipppk,
      'no'     => $no,
      'tahun'  => $tahun_lama
    );

    $nama = $this->mpppk->getnama_lengkap($nipppk);

    if ($this->mpppk->edit_ws($where, $datadik))
    {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Pengembangan Kompetensi Lainnya PPPK A.n. <u>'.$nama.'</u> berhasil dirubah.';
          $data['jnspesan'] = 'alert alert-success';
    } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Pengembangan Kompetensi Lainnya PPPK A.n. <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan.';
          $data['jnspesan'] = 'alert alert-danger';
    }

    // untuk diklat fungsional
    $data['pegrwydf'] = $this->mpppk->rwydf($nipppk)->result_array();
    //untuk diklat teknis
    $data['pegrwydt'] = $this->mpppk->rwydt($nipppk)->result_array();
    //untuk diklat workshop
    $data['pegrwyws'] = $this->mpppk->rwyws($nipppk)->result_array();
    $data['nipppk'] = $nipppk;
    $data['content'] = 'pppk/rwydik';
    $this->load->view('template', $data);
  }
  // End Riwayat Diklat


  function updateinfopersonal() {
    $nipppk = addslashes($this->input->post('nipppk'));
    $nik = addslashes($this->input->post('nik'));
    $npwp = addslashes($this->input->post('npwp'));
    $handphone = addslashes($this->input->post('handphone'));
    $email = addslashes($this->input->post('email'));
    $alamat = addslashes($this->input->post('alamat'));
    $id_keldesa = addslashes($this->input->post('id_keldesa'));
    $id_agama = addslashes($this->input->post('id_agama'));
    $id_statkaw = addslashes($this->input->post('id_statkaw'));

    $dataperso = array(
      'nik'                   => $nik,
      'no_npwp'               => $npwp,
      'no_handphone'          => $handphone,
      'email'     	      => $email,
      'alamat'                => $alamat,
      'fid_keldesa'           => $id_keldesa,
      'fid_agama'             => $id_agama,
      'fid_status_kawin'      => $id_statkaw
      );

    $where = array(
      'nipppk'    => $nipppk
    );

    $nama = $this->mpppk->getnama($nipppk);

    if ($this->mpppk->edit_pppk($where, $dataperso))
    {
      $data['pesan'] = '<b>Sukses</b>, Data Informasi Personal PPPK <u>'.$nama.'</u> berhasil dirubah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data Informasi Personal PPPK <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan.';
      $data['jnspesan'] = 'alert alert-danger';
    }

    $data['detail'] = $this->mpppk->detail($nipppk)->result_array();
    $data['nipppk'] = $nipppk;	
    $data['content'] = 'pppk/detail';
    $this->load->view('template', $data);
  }

  function tampilupdatejabpeta() {	
     $idpeta = $this->input->get('idpeta');
     if ($idpeta) {
        $pejab = $this->mpetajab->detailKomponenJabatan($idpeta)->result_array();
        foreach($pejab as $pj) {
           $kelas = $pj['kelas'];
           $ket = $pj['koord_subkoord'];
           $jml_kebutuhan = $pj['jml_kebutuhan'];
           $jml_bezzeting = $pj['jml_bezzeting'];
           $tpp = $pj['tpp_pk'] + $pj['tpp_bk'] + $pj['tpp_kk'] + $pj['tpp_tb'] + $pj['tpp_kp'];
        }
        ?>
        <div class='row'>
             <div class='col-md-12' align="right">
                <?php
                echo "<h5><small><span class='text-info'>Keterangan : ".$ket."</span></small> <code>
                        Kelas : ".$kelas."</code> <code class='text-primary'>Kebutuhan : ".$jml_kebutuhan."</code> <code class='text-warning'>
                        Bezzeting : ".$jml_bezzeting."</code> <code class='text-success'>TPP : Rp. ".number_format($tpp,2,",",".")."</code>
                        </h5><br/>";
                ?>
             </div>
        </div>

        <div class='row'>
             <div class='col-md-12' align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                        <span class="fa fa-ban" aria-hidden="true"></span> Batal</button>
                <button type="submit" class="btn btn-success">
                        <span class="fa fa-save" aria-hidden="true"></span> Update Jabatan</button>
             </div>
        </div>
	<?php
     }	
  }

  function update_rwyjabpeta_aksi() {
        $nipppk = $this->input->post('nipppk');
        $id_peta = $this->input->post('id_peta');

        $data = array(
          'fid_peta_jabatan'	=> $id_peta
        );

        $whr = array(
          'nipppk'	=> $nipppk
        );

    $db = $this->mpppk->edit_pppk($whr, $data);
    $nama = $this->mpppk->getnama($nipppk);
    if($db) {
      $data['pesan'] = '<b>Sukses</b>, Data PPPK A.n. <u>'.$nama.'</u> berhasil dirobah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data PPPK A.n. <u>'.$nama.'</u> gagal dirobah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }

    $data['detail'] = $this->mpppk->detail($nipppk)->result_array();
    $data['nipppk'] = $nipppk;

    $data['content'] = 'pppk/detail';
    $this->load->view('template', $data);
  } 

}
