<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nonpns extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');
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
      $data['content'] = 'nonpns/tampilunker';
      $this->load->view('template',$data);
    }
  }  

  function add()
  {
    //cek priviledge session user -- edit_profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
    //if ($this->session->userdata('level') == "ADMIN") {
      $nip = $this->input->post('nip');
      $data['keldes'] = $this->mnonpns->kelurahan()->result_array();
      $data['agama'] = $this->mnonpns->agama()->result_array();
      $data['tingpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['statkaw'] = $this->mpegawai->status_kawin()->result_array();
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['jab'] = $this->mnonpns->jabatan()->result_array();
      $data['jnsnonpns'] = $this->mnonpns->jenis_nonpns()->result_array();
      $data['sumbergaji'] = $this->mnonpns->sumbergaji()->result_array();
      $data['content'] = 'nonpns/addnonpns';
      $this->load->view('template', $data);
    }
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
    

  function add_aksi() {
    $nik = addslashes($this->input->post('nik'));
    $nama = strtoupper(addslashes($this->input->post('nama')));
    $gelar_depan = addslashes($this->input->post('gelar_depan'));
    $gelar_blk = addslashes($this->input->post('gelar_blk'));
    $tmp_lahir = strtoupper(addslashes($this->input->post('tmp_lahir')));
    $tgl_lahir = tgl_sql($this->input->post('tgl_lahir'));
    $alamat = strtoupper(addslashes($this->input->post('alamat')));
    $idkel = addslashes($this->input->post('idkel'));
    $no_telp_rumah = addslashes($this->input->post('no_telp_rumah'));
    $no_hape = addslashes($this->input->post('no_hape'));
    $jns_kelamin = addslashes($this->input->post('jns_kelamin'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $fid_tingkat_pendidikan = addslashes($this->input->post('fid_tingkat_pendidikan'));
    $fid_jurusan_pendidikan = addslashes($this->input->post('fid_jurusan_pendidikan'));
    $nama_sekolah = strtoupper(addslashes($this->input->post('nama_sekolah')));
    $tahun_lulus = addslashes($this->input->post('tahun_lulus'));
    $fid_status_kawin = addslashes($this->input->post('fid_status_kawin'));
    $no_npwp = addslashes($this->input->post('no_npwp'));
    $no_bpjs = addslashes($this->input->post('no_bpjs'));
    $fid_unit_kerja = addslashes($this->input->post('fid_unit_kerja'));
    $fid_jabatan = addslashes($this->input->post('fid_jabatan'));

    $fid_jenis_nonpns = addslashes($this->input->post('fid_jenis_nonpns'));
    $fid_sumbergaji = strtoupper(addslashes($this->input->post('fid_sumbergaji')));

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(      
      'nik'                     => $nik,
      'nama'                    => $nama,
      'gelar_depan'             => $gelar_depan,
      'gelar_blk'               => $gelar_blk,
      'tmp_lahir'               => $tmp_lahir,
      'tgl_lahir '              => $tgl_lahir,
      'jns_kelamin'             => $jns_kelamin,
      'fid_agama'               => $fid_agama,
      'alamat'                  => $alamat,
      'fid_keldesa'             => $idkel,
      'no_telp_rumah'           => $no_telp_rumah,
      'no_hp'                   => $no_hape,
      'fid_status_kawin'        => $fid_status_kawin,
      'fid_tingkat_pendidikan'  => $fid_tingkat_pendidikan,
      'fid_jurusan_pendidikan'  => $fid_jurusan_pendidikan,
      'nama_sekolah'            => $nama_sekolah,
      'tahun_lulus'             => $tahun_lulus,
      'fid_unit_kerja'          => $fid_unit_kerja,
      'fid_jabnonpns'           => $fid_jabatan,
      'fid_jenis_nonpns'        => $fid_jenis_nonpns,
      'fid_sumbergaji'          => $fid_sumbergaji,
      'no_bpjs'                 => $no_bpjs,
      'no_npwp'                 => $no_npwp,
      'created_at'              => $tgl_aksi,
      'created_by'              => $user
      );

    // cek apakah data yang sama pernah dientri sebelumnya
    if (($this->mnonpns->cek_nik($nik) == 0) AND (strlen($nik) == 16)) {
      if ($this->mnonpns->input_nonpns($data))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Non PNS A.n. <u>'.$nama.'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Non PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      // jika pernah kosongkan pesan dan jenis pesan
      $data['pesan'] = '<b>Gagal !</b>, Data Non PNS A.n. <u>'.$nama.'</u> gagal ditambah.<br />NIK telah digunakan atau NIK <u>'.$nik.'</u> kurang dari 16 karakter';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['unker'] = $this->munker->dd_unker()->result_array();
    $data['content'] = 'nonpns/tampilunker';
    $this->load->view('template', $data);
  }

  function edit_aksi() {
    $nik = addslashes($this->input->post('nik'));
    $nama = strtoupper(addslashes($this->input->post('nama')));
    $gelar_depan = addslashes($this->input->post('gelar_depan'));
    $gelar_blk = addslashes($this->input->post('gelar_blk'));
    $tmp_lahir = strtoupper(addslashes($this->input->post('tmp_lahir')));
    $tgl_lahir = tgl_sql($this->input->post('tgl_lahir'));
    $alamat = strtoupper(addslashes($this->input->post('alamat')));
    $idkel = addslashes($this->input->post('idkel'));
    $no_telp_rumah = addslashes($this->input->post('no_telp_rumah'));
    $no_hape = addslashes($this->input->post('no_hape'));
    $jns_kelamin = addslashes($this->input->post('jns_kelamin'));
    $fid_agama = addslashes($this->input->post('fid_agama'));
    $fid_tingkat_pendidikan = addslashes($this->input->post('fid_tingkat_pendidikan'));
    $fid_jurusan_pendidikan = addslashes($this->input->post('fid_jurusan_pendidikan'));
    $nama_sekolah = strtoupper(addslashes($this->input->post('nama_sekolah')));
    $tahun_lulus = addslashes($this->input->post('tahun_lulus'));
    $fid_status_kawin = addslashes($this->input->post('fid_status_kawin'));
    $no_npwp = addslashes($this->input->post('no_npwp'));
    $no_bpjs = addslashes($this->input->post('no_bpjs'));
    $fid_unit_kerja = addslashes($this->input->post('fid_unit_kerja'));
    $fid_jabatan = addslashes($this->input->post('fid_jabatan'));
    $ket_jab = strtoupper(addslashes($this->input->post('ket_jab')));

    $fid_jenis_nonpns = addslashes($this->input->post('fid_jenis_nonpns'));
    $fid_sumbergaji = strtoupper(addslashes($this->input->post('fid_sumbergaji')));

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'nama'                    => $nama,
      'gelar_depan'             => $gelar_depan,
      'gelar_blk'               => $gelar_blk,
      'tmp_lahir'               => $tmp_lahir,
      'tgl_lahir '              => $tgl_lahir,
      'jns_kelamin'             => $jns_kelamin,
      'fid_agama'               => $fid_agama,
      'alamat'                  => $alamat,
      'fid_keldesa'             => $idkel,
      'no_telp_rumah'           => $no_telp_rumah,
      'no_hp'                   => $no_hape,
      'fid_status_kawin'        => $fid_status_kawin,
      'fid_tingkat_pendidikan'  => $fid_tingkat_pendidikan,
      'fid_jurusan_pendidikan'  => $fid_jurusan_pendidikan,
      'nama_sekolah'            => $nama_sekolah,
      'tahun_lulus'             => $tahun_lulus,
      'fid_unit_kerja'          => $fid_unit_kerja,
      'fid_jabnonpns'           => $fid_jabatan,
      'ket_jabnonpns'           => $ket_jab,
      'fid_jenis_nonpns'        => $fid_jenis_nonpns,
      'fid_sumbergaji'          => $fid_sumbergaji,
      'no_bpjs'                 => $no_bpjs,
      'no_npwp'                 => $no_npwp,
      'updated_at'              => $tgl_aksi,
      'updated_by'              => $user
      );

    $where = array(
      'nik'               => $nik
    );

    $namalama = $this->mnonpns->getnama($nik);

    // cek apakah data yang sama pernah dientri sebelumnya
    if ($this->mnonpns->cek_nik($nik) == 1) { //berarti data ditemukan
      if ($this->mnonpns->edit_nonpns($where, $data))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Data Non PNS A.n. <u>'.$namalama.'</u> berhasil dirobah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Data Non PNS A.n. <u>'.$namalama.'</u> gagal dirobah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data Non PNS A.n. <u>'.$namalama.'</u> gagal dirobah.<br />Data tidak ditemukan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['unker'] = $this->munker->dd_unker()->result_array();
    $data['content'] = 'nonpns/tampilunker';
    $this->load->view('template', $data);
  }

  // untuk ajax tampil per unker
  function tampilperunker() {
    $idunker = $this->input->get('idunker');

    if ($idunker) {
      $sqlcari = $this->mnonpns->nonpnsperunker($idunker)->result_array();
      $nmunker = $this->munker->getnamaunker($idunker);
      $jmlnonpns = $this->mnonpns->getjmlperunker($idunker);

      if ($jmlnonpns == 0) {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";        
        echo "Data Non PNS tidak ditemukan pada ".$nmunker;
        echo "</div>";
      } else {
        echo "<div class='panel panel-default' style='width: 80%'>";        
        echo "<div class='panel-body'>";

        // mencari apakah ada data yang belum memiliki file photo dan berkas
        $jmlphoto = 0;
        $jmlberkas = 0;
        foreach($sqlcari as $v):          
          $lokasiphoto='./photononpns/';
          $filephoto=$v['photo'];
          if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
            $jmlphoto++;
          }  
          
          $lokasiberkas='./filenonpns/';
          $fileberkas=$v['berkas'];
            if ((file_exists ($lokasiberkas.$fileberkas)) AND ($fileberkas != '')) {
            $jmlberkas++;
          }        
        endforeach;

        if (($jmlnonpns == $jmlphoto) AND ($jmlnonpns == $jmlberkas)) {
          ?>
          <div align='right'>
          <form method="POST" action="../nonpns/cetaknomperunker" target='_blank'>
            <input type='hidden' name='idunker' id='idunker' maxlength='18' value='<?php echo $idunker; ?>'>
            <button type="submit" class="btn btn-info btn-sm">
              <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Nominatif
            </button>
          </form>
          </div>
          <br/>
          <?php  
        } else {
          ?>
          <div align='right'>
          <form method="POST" action="../nonpns/add">
            <button type="submit" class="btn btn-warning btn-sm" disabled>
              <span class="glyphicon glyphicon-print" aria-hidden="true" ></span> Cetak Nominatif
            </button>
          </form>
          Tombol "Cetak Nominatif" akan aktif jika SEMUA DATA telah dilengkapi dengan photo dan berkas pendukung,<br/>yakni keterangan pada kolom Status berwarna Biru seluruhnya
          <span class='label label-info'>
            <span class='glyphicon glyphicon-ok' aria-hidden='true'>
            </span> Photo Ada
          </span>&nbsp
          <span class='label label-info'>
            <span class='glyphicon glyphicon-ok' aria-hidden='true'>
            </span> Berkas Ada
          </span>
          <br/>
          <br/>
          <?php  
        }       

        echo "<div class='panel panel-danger'>";
        echo "<div class='panel-heading' align='left'><b>$nmunker</b><br />";
        echo "Jumlah Non PNS : ".$jmlnonpns." orang";
        echo "</div>";
        echo "<div style='padding:0px;overflow:auto;width:99%;height:280px;border:1px solid white' >";

        echo "<table class='table table-condensed'>";
        echo "<tr>
          <td align='center'><b>No</b></td>
          <td align='center' colspan='2' width='230'><b>NIK<br/><u>NAMA</u></b><br/><i>Tgl. Lahir</i></td>
          <td align='center'><b>Jenis Non PNS<br /><u>Sumber Gaji</u></b><br/><i>TMT Awal</i></td>
          <td align='center'><b>Jabatan<br/>Unit Kerja</b></td>
          <td align='center'><b>Status<br/>Dokumen</b></td>
          <td align='center' colspan='3'><b>Aksi</b></td>";
        echo "</tr>";    
        
        $no = 1;
        foreach($sqlcari as $v):          
          ?>
          <tr>
          <td width='10' align='center'><?php echo $no.'.'; ?></td>
          <td>
            <?php echo $v['nik']; ?><br />
            <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk']); ?><br/>
            <i><?php echo tgl_indo($v['tgl_lahir']); ?></i>
          </td>
          <td align='center' width='50'>         

          <?php        
          $lokasiphoto='./photononpns/';
          $filephoto=$v['photo'];

          if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
            echo "<img src='../photononpns/$filephoto' width='48' height='64' alt='$v[nik].jpg'";
          } else {
            echo "<img src='../photononpns/nophoto.jpg' height='64' alt='no image'";
          }
          ?>
          </td>
          <td width='140' align='center'>
            <?php echo $this->mnonpns->getjnsnonpns($v['fid_jenis_nonpns']); ?>
            <br />
            <u><?php echo $this->mnonpns->getsumbergaji($v['fid_sumbergaji']); ?></u><br />
            <i><?php //echo tgl_indo($v['tmt_sk_awal']); ?></i>
          </td>

          <td>
            <?php echo $v['nama_jabnonpns'];?><br />
            <?php echo $v['nama_unit_kerja'];?>        
          </td>
          <td align='right' width='100'>
           <?php
            $lokasiphoto='./photononpns/';
            $filephoto=$v['photo'];
            if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
              echo "<h5><span class='label label-info'>
                    <span class='glyphicon glyphicon-ok' aria-hidden='true'>
                    </span> Photo Ada
                    </span></h5>";
            } else {
              echo "<h5><span class='label label-danger'>
                    <span class='glyphicon glyphicon-remove' aria-hidden='true'>
                    </span> Photo Tidak Ada
                    </span></h5>";
            }

            $lokasiberkas='./filenonpns/';
            $fileberkas=$v['berkas'];
            if ((file_exists ($lokasiberkas.$fileberkas)) AND ($fileberkas != '')) {
              echo "<h5><span class='label label-info'>
                    <span class='glyphicon glyphicon-ok' aria-hidden='true'>
                    </span> Berkas Ada
                    </span></h5>";
            } else {
              echo "<h5><span class='label label-danger'>
                    <span class='glyphicon glyphicon-remove' aria-hidden='true'>
                    </span> Berkas Tidak Ada
                    </span></h5>";
            }
            ?>
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../nonpns/nonpnsdetail'>";          
            echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
            ?>
            <button type="submit" class="btn btn-success btn-xs ">
            <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span>
            <br /> Detail
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../nonpns/editnonpns'>";          
            echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
            ?>
            <button type="submit" class="btn btn-warning btn-xs ">
            <span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span>
            <br />&nbspEdit&nbsp
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../nonpns/hapusnonpns'>";          
            echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
            ?>
            <button type="submit" class="btn btn-danger btn-xs ">
            <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
            <br /> Hapus
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
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

  function nonpnsdetail()
  {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') == "TAMU")) { 
      $nik = $this->input->post('nik');
      $data['detail'] = $this->mnonpns->detail($nik)->result_array();
      $data['skawal'] = $this->mnonpns->getskawal($nik)->result_array();
      $data['skakhir'] = $this->mnonpns->getskakhir($nik)->result_array();
      $data['nik'] = $nik;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'nonpns/nonpnsdetail';
      $this->load->view('template', $data);
    }
  }

  function hapusnonpns(){
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nik = addslashes($this->input->post('nik'));
      $nama = $this->mnonpns->getnama($nik);

      $where = array('nik' => $nik);

      $filephoto=$this->mnonpns->getphoto($nik);          
        if (file_exists('./photononpns/'.$filephoto)) {
          unlink('./photononpns/'.$filephoto);
        }

        $fileberkas=$this->mnonpns->getberkas($nik);
        if (file_exists('./filenonpns/'.$fileberkas)) {
          unlink('./filenonpns/'.$fileberkas);
        }

      if ($this->mnonpns->hapus_nonpns($where)) {        
        $data['pesan'] = '<b>Sukses !</b>, Data Non PNS A.n. <u>'.$nama.'</u> berhasil dihapus.';
        $data['jnspesan'] = 'alert alert-success';
        


      } else {
        $data['pesan'] = '<b>Gagal !</b>, Data Non PNS A.n. <u>'.$nama.'</u> gagal dihapus.';
        $data['jnspesan'] = 'alert alert-danger';
      }

      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'nonpns/tampilunker';
      $this->load->view('template',$data);
    }
  }

  public function cetaknomperunker() {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") { 
      $idunker = $this->input->post('idunker');
      $res['data'] = $this->datacetaknonpns->datanomperunker();
      $this->load->view('nonpns/cetaknomperunker',$res);    
    }
  }

  function editnonpns() {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nik = $this->input->post('nik');
      $data['nonpns'] = $this->mnonpns->detail($nik)->result_array();
      $data['keldes'] = $this->mnonpns->kelurahan()->result_array();
      $data['agama'] = $this->mnonpns->agama()->result_array();
      $data['tingpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['statkaw'] = $this->mpegawai->status_kawin()->result_array();
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['jab'] = $this->mnonpns->jabatan()->result_array();
      $data['jnsnonpns'] = $this->mnonpns->jenis_nonpns()->result_array();
      $data['sumbergaji'] = $this->mnonpns->sumbergaji()->result_array();
      $data['content'] = 'nonpns/editnonpns';
      $this->load->view('template', $data);
    }
  }

  function statistik()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") { 
      $data['jenkel'] = $this->mnonpns->graph_jenkel();
      $data['tingpen'] = $this->mnonpns->graph_tingpen();    
      $data['sumgaji'] = $this->mnonpns->graph_sumgaji();
      $data['jnshon'] = $this->mnonpns->graph_jnshon();
      $data['jabnonpns'] = $this->mnonpns->graph_jabnonpns();
      $data['perinstansi'] = $this->mnonpns->graph_perinstansi();


      $data['content'] = 'nonpns/statistik';
      $this->load->view('template',$data);
    }
  }

  function tampildatacari()
  {
    $data = $this->input->post('data');
    if ($data != '') {
      if ($this->session->userdata('level') == "TAMU") { 
        $data = $this->input->post('data');
        // dapatkan data dengan nik saja
        $datatnp['nonpnstnp'] = $this->mnonpns->getbynik($data)->result_array();
        $datatnp['jmldata'] = count($this->mnonpns->getbynik($data)->result_array());
        $datatnp['content'] = 'nonpns/tampildatacari';
        $this->load->view('template', $datatnp);

      } else if ($this->session->userdata('nonpns_priv') == "Y") { 
        $data = $this->input->post('data');
        // dapatkan data dengan nik dan nama
        $datatnp['nonpnstnp'] = $this->mnonpns->getbyniknama($data)->result_array();
        $datatnp['jmldata'] = count($this->mnonpns->getbyniknama($data)->result_array());
        $datatnp['content'] = 'nonpns/tampildatacari';
        $this->load->view('template', $datatnp);
      }
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Pencarian data gagal, silahkan entri NIK atau Nama.';
      $data['jnspesan'] = 'alert alert-danger';

      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'nonpns/tampilunker';
      $this->load->view('template', $data);
    }
  }

  // untuk riwayat pendidikan
  function rwypendidikan()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") { 
      $nik = $this->input->post('nik');
      $data['rwypdk'] = $this->mnonpns->rwypdk($nik)->result_array();
      $data['nik'] = $nik;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'nonpns/rwypendidikan';
      $this->load->view('template', $data);
    }
  }

  function tambahrwypdk() {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nik = $this->input->post('nik');
      $data['tingpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['nik'] = $nik;    
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'nonpns/tambahrwypendidikan';
      $this->load->view('template', $data);    
    }
  }

  // untuk ajax jurusan pendidikan pada form riwayat
  function showjurpenrwy()
  {
    $idtp = $this->input->get('idtp');
    $jurpen = $this->mnonpns->jurpen($idtp)->result_array();
    ?>
    <select name='fid_jurpen' id='fid_jurpen' required>
      <option value=''>-- Pilih Jurusan --</option>
      <?php
      foreach($jurpen as $jp) {              
        echo "<option value='".$jp['id_jurusan_pendidikan']."'>".$jp['nama_jurusan_pendidikan']."</option>";
      }
      ?>
    </select>
    <?php
    $nmtingpen = $this->mpegawai->gettingpen($idtp);
    if (($nmtingpen != 'SD') AND ($nmtingpen != 'SMP') AND ($nmtingpen != 'SMA')) {
      echo "Gelar Akademik : <input type='text' name='gelar' size='6' maxlength='10' />";
    } else {
      echo "<input type='hidden' name='gelar' size='6' maxlength='10' value='' readonly/>";
    }
  }

  function tambahrwypdk_aksi() {
    $nik = addslashes($this->input->post('nik'));
    $fid_tingpen = addslashes($this->input->post('fid_tingpen'));
    $fid_jurpen = addslashes($this->input->post('fid_jurpen'));
    $tahunlulus = addslashes($this->input->post('tahunlulus'));
    $namasekolah = strtoupper(addslashes($this->input->post('namasekolah')));
    $namakepsek = addslashes($this->input->post('namakepsek'));
    $noijazah = addslashes($this->input->post('noijazah'));
    $tglijazah = tgl_sql($this->input->post('tglijazah'));
    $gelar = addslashes($this->input->post('gelar'));    

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(      
      'nik'                 => $nik,
      'fid_tingkat'         => $fid_tingpen,
      'fid_jurusan'         => $fid_jurpen,
      'thn_lulus'           => $tahunlulus,
      'gelar'               => $gelar,
      'nama_sekolah'        => $namasekolah,
      'nama_kepsek'         => $namakepsek,
      'no_sttb'             => $noijazah,
      'tgl_sttb'            => $tglijazah,
      'created_at'          => $tgl_aksi,
      'created_by'          => $user
      );

    $nama = $this->mnonpns->getnama($nik);

    if ($this->mnonpns->input_rwypdk($data))
    {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Pendidikan A.n. <u>'.$nama.'</u> berhasil ditambah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat Pendidikan A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $nik = $this->input->post('nik');
    $data['rwypdk'] = $this->mnonpns->rwypdk($nik)->result_array();
    $data['nik'] = $nik;    
    $data['content'] = 'nonpns/rwypendidikan';
    $this->load->view('template', $data);
  }

  function hapusrwypdk(){
    $nik = addslashes($this->input->post('nik'));
    $fid_tingkat = addslashes($this->input->post('fid_tingkat'));

    $nama = $this->mnonpns->getnama($nik);

    $where = array('nik' => $nik,
                   'fid_tingkat' => $fid_tingkat
            );
    
    if ($this->mnonpns->hapus_rwypdk($where)) {        
      $data['pesan'] = '<b>Sukses !</b>, Riwayat Pendidikan A.n. <u>'.$nama.'</u> berhasil dihapus.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat Pendidikan A.n. <u>'.$nama.'</u> gagal dihapus.';
      $data['jnspesan'] = 'alert alert-danger';
    }

    $nik = $this->input->post('nik');
    $data['rwypdk'] = $this->mnonpns->rwypdk($nik)->result_array();
    $data['nik'] = $nik;    
    $data['content'] = 'nonpns/rwypendidikan';
    $this->load->view('template', $data);
  }

  function editrwypdk() {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nik = $this->input->post('nik');
      $fid_tingkat = $this->input->post('fid_tingkat');
      $data['detailrwypdk'] = $this->mnonpns->detailrwypdk($nik, $fid_tingkat)->result_array();      
      $data['tingpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['jurpen'] = $this->mpegawai->ting_pendidikan()->result_array();
      $data['nik'] = $nik;
      $data['fid_tingkat'] = $fid_tingkat;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'nonpns/editrwypendidikan';
      $this->load->view('template', $data);
    }
  }

  function editrwypdk_aksi() {
    $nik = addslashes($this->input->post('nik'));
    $fid_tingpen_lama = addslashes($this->input->post('fid_tingkat_lama'));

    $fid_tingpen = addslashes($this->input->post('fid_tingpen'));
    $fid_jurpen = addslashes($this->input->post('fid_jurpen'));
    $tahunlulus = addslashes($this->input->post('tahunlulus'));
    $namasekolah = strtoupper(addslashes($this->input->post('namasekolah')));
    $namakepsek = addslashes($this->input->post('namakepsek'));
    $noijazah = addslashes($this->input->post('noijazah'));
    $tglijazah = tgl_sql($this->input->post('tglijazah'));
    $gelar = addslashes($this->input->post('gelar'));    

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'fid_tingkat'         => $fid_tingpen,
      'fid_jurusan'         => $fid_jurpen,
      'thn_lulus'           => $tahunlulus,
      'gelar'               => $gelar,
      'nama_sekolah'        => $namasekolah,
      'nama_kepsek'         => $namakepsek,
      'no_sttb'             => $noijazah,
      'tgl_sttb'            => $tglijazah,
      'created_at'          => $tgl_aksi,
      'created_by'          => $user
      );

    $where = array(
      'nik'                 => $nik,
      'fid_tingkat'         => $fid_tingpen_lama,
    );

    $nama = $this->mnonpns->getnama($nik);

    if ($this->mnonpns->edit_rwypdk($where, $data))
    {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Pendidikan A.n. <u>'.$nama.'</u> berhasil dirobah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat Pendidikan A.n. <u>'.$nama.'</u> gagal dirobah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $nik = $this->input->post('nik');
    $data['rwypdk'] = $this->mnonpns->rwypdk($nik)->result_array();
    $data['nik'] = $nik;    
    $data['content'] = 'nonpns/rwypendidikan';
    $this->load->view('template', $data);
  }

  // untuk riwayat pekerjaan
  function rwypekerjaan()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('nonpns_priv') == "Y") { 
      $nik = $this->input->post('nik');
      $data['rwypdk'] = $this->mnonpns->rwypkj($nik)->result_array();
      $data['nik'] = $nik;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'nonpns/rwypekerjaan';
      $this->load->view('template', $data);
    }
  }

  function showtambahrwypkj() {
    $nik = $this->input->post('nik');
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
      <div class="panel-heading" align='center'><b>Tambah Riwayat Pekerjaan</b></div>      
        <div align='right' style='width :99%'>
          <br />
          <form method='POST' action='../nonpns/rwypekerjaan'>
            <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>'>
            <button type="submit" class="btn btn-warning btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
          <br />
        </div>
      <form method='POST' action='../nonpns/tambahrwypkj_aksi'>
      <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>'>
      <table class="table table-condensed table-hover">        
        <tr>
          <td align='right' width='150' class='info'><b>Jenis Non PNS :</b></td>
          <td colspan='3'>
            <select name="fid_jenis" id="fid_jenis" required>
              <?php
                //echo "<option value='-'>-- Pilih Jenis --</option>";
                $jnsnonpns = $this->mnonpns->jenis_nonpns()->result_array();
                echo "<option value='-'>-- Pilih Jenis --</option>";
              foreach($jnsnonpns as $jn)
              {
                if ($v['fid_jenis_nonpns']==$jn['id_jenis_nonpns']) {
                  echo "<option value='".$jn['id_jenis_nonpns']."' selected>".$jn['nama_jenis_nonpns']."</option>";
                } else {
                  echo "<option value='".$jn['id_jenis_nonpns']."'>".$jn['nama_jenis_nonpns']."</option>";
                }              
                  //echo "<option value='".$u['id_jenis_nonpns']."'>".$u['nama_jenis_nonpns']."</option>";
              }
              ?>
            </select>                          
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Tugas Pekerjaan</b></td>
          <td colspan='3'>
            <select name="fid_jabatan" id="fid_jabatan" onChange="showKetJab(this.value)" required>
              <?php
              $jab = $this->mnonpns->jabatan()->result_array();
              echo "<option value='-'>-- Pilih Tugas --</option>";
              foreach($jab as $j)
              { 
                  // supaya pilihan "LAIN-LAIN" terletak diurutan terakhir
                if ($j['nama_jabnonpns'] == 'LAIN-LAIN') {
                    // simpan idjab dan namajab "LAIN-LAIN"
                  $idjab = $j['id_jabnonpns'];
                  $nmjab = $j['nama_jabnonpns'];
                } else {
                  echo "<option value='".$j['id_jabnonpns']."'>".$j['nama_jabnonpns']."</option>";
                }
              }
              echo "<option value='".$idjab."'>".$nmjab."</option>";
              ?>
            </select>              
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Unit Kerja</b></td>
          <td colspan='3'>
            <select name="fid_unker" id="fid_unker" onChange='showunker(this.value)' required>
            <option value=''>- Pilih Unit Kerja -</option>
            <option value='LUAR BALANGAN' style='color :red'>- DILUAR BALANGAN / UNOR LAMA / TIDAK DITEMUKAN -</option>
              <?php
              //echo "<option value=''>- Pilih Unit Kerja -</option>";
              //echo "<option value='LUAR BALANGAN'>---DILUAR PEMKAB BALANGAN / TIDAK DITEMUKAN---</option>";
              $unker = $this->munker->unker()->result_array();
              //$unker = $this->munker->dd_unker()->result_array();
              foreach($unker as $u)
              {              
                echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
              }
              ?>
            </select>
            <small class="text-muted">** WAJIB DIISI</small>
            <div id='tampilunker'></div>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Sumber Gaji</b></td>
          <td>
            <select name="fid_sumbergaji" id="fid_sumbergaji" required>
              <?php
              $gaji = $this->mnonpns->sumbergaji()->result_array();                      
              echo "<option value='-'>-- Pilih Sumber Gaji --</option>";
              foreach($gaji as $g)
              {              
                echo "<option value='".$g['id_sumbergaji']."'>".$g['nama_sumbergaji']."</option>";
              }
              ?>
            </select>
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
          <td align='right' bgcolor='#D9EDF7'><b>Gaji</b></td>
          <td><input type="text" name="gaji" size='12' maxlength='8' onkeyup='validAngka(this)' />
            <small class="text-muted">Hanya angka, tanpa Rp. dan tanpa titik</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Tgl Mulai Bekerja :</b></td>
          <td><input type="text" name="tmtawal" class="tanggal" size='15' maxlength='10' />              
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
          <td align='right' bgcolor='#D9EDF7'><b>Sampai Tanggal :</b></td>
          <td><input type="text" name="tmtakhir" class="tanggal" size='15' maxlength='10' />              
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Surat Keputusan :</b></td>
          <td colspan='4'>
            <table class="table">
              <tr>
                <td width='100' align='right'>No. SK</td>
                <td>
                  <input type="text" name="no_sk" size='40' maxlength='50' required />
                </td>
                <td width='80' align='right'>Tgl. SK</td>
                <td>
                  <input type="text" class='tanggal' name="tgl_sk" size='12' maxlength='10' required />
                </td>
              </tr>
              <tr>
                <td width='100' align='right'>Pejabat yang memutuskan</td>
                <td colspan='3'>
                  <input type="text" name="pejabat_sk" size='70' maxlength='50' required /><br />
                  <small class="text-muted">Diisi dengan nama jabatan, bukan nama orang yang menduduki jabatan.</small>
                </td>
              </tr>              
            </table>
          </td>
        </tr>
        <tr>
          <td colspan='5'>
            <p align="right">
              <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
              </button>
            </p>
          </td>
        </tr>
      </table>
      </form>
    </div>
    <?php
  }

  function getdataunker()
  { 
    $idunker = $this->input->get('idunker');

    if ($idunker == 'LUAR BALANGAN') {
      echo "<br />Silahkan ketik nama unit kerja pada kotak dibawah ini";
      echo "<input type='text' name='namaunker' size='80' maxlength='100'>";
    } else {
      $namaunker = $this->munker->getnamaunker($idunker);
      echo "<input type='hidden' name='namaunker' size='80' maxlength='100' value='$namaunker'>";
    }      
  }

  function tambahrwypkj_aksi() {
    $nik = addslashes($this->input->post('nik'));
    $fid_jenis = addslashes($this->input->post('fid_jenis'));
    $fid_jabatan = addslashes($this->input->post('fid_jabatan'));
    $namaunker = strtoupper(addslashes($this->input->post('namaunker')));
    $fid_sumbergaji = addslashes($this->input->post('fid_sumbergaji'));
    $gaji = addslashes($this->input->post('gaji'));
    $tmtawal = tgl_sql(addslashes($this->input->post('tmtawal')));
    $tmtakhir = tgl_sql($this->input->post('tmtakhir'));
    $no_sk = addslashes($this->input->post('no_sk'));    
    $tgl_sk = tgl_sql(addslashes($this->input->post('tgl_sk')));    
    $pejabat_sk = strtoupper(addslashes($this->input->post('pejabat_sk')));    

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(      
      'nik'                 => $nik,
      'pejabat_sk'          => $pejabat_sk,
      'no_sk'               => $no_sk,
      'tgl_sk'              => $tgl_sk,
      'gaji'                => $gaji,
      'tmt_awal'            => $tmtawal,
      'tmt_akhir'           => $tmtakhir,
      'fid_jenis_nonpns'    => $fid_jenis,
      'fid_sumbergaji'      => $fid_sumbergaji,
      'nama_unit_kerja'      => $namaunker,
      'fid_jabnonpns'       => $fid_jabatan,
      'created_at'          => $tgl_aksi,
      'created_by'          => $user
      );

    $nama = $this->mnonpns->getnama($nik);

    if ($this->mnonpns->input_rwypkj($data))
    {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Pekerjaan A.n. <u>'.$nama.'</u> berhasil ditambah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat Pekerjaan A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $nik = $this->input->post('nik');
    $data['rwypdk'] = $this->mnonpns->rwypkj($nik)->result_array();
    $data['nik'] = $nik;    
    $data['content'] = 'nonpns/rwypekerjaan';
    $this->load->view('template', $data);
  }

  function hapusrwypkj(){
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nik = addslashes($this->input->post('nik'));
      $tmt_awal = addslashes($this->input->post('tmt_awal'));

      $nama = $this->mnonpns->getnama($nik);
   
      $where = array('nik' => $nik,
                     'tmt_awal' => $tmt_awal
              );
      
      if ($this->mnonpns->hapus_rwypkj($where)) {        
        $data['pesan'] = '<b>Sukses !</b>, Riwayat Pekerjaan A.n. <u>'.$nama.'</u> berhasil dihapus.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Riwayat Pekerjaan A.n. <u>'.$nama.'</u> gagal dihapus.';
        $data['jnspesan'] = 'alert alert-danger';
      }

      $nik = $this->input->post('nik');
      $data['rwypdk'] = $this->mnonpns->rwypkj($nik)->result_array();
      $data['nik'] = $nik;    
      $data['content'] = 'nonpns/rwypekerjaan';
      $this->load->view('template', $data);
    }
  }

  function editrwypkj() {
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') != "TAMU") OR ($this->session->userdata('nonpns_priv') == "Y")) { 
      $nik = $this->input->post('nik');
      $tmt_awal = $this->input->post('tmt_awal');
      $data['editrwypkj'] = $this->mnonpns->getdatarwypkj($nik, $tmt_awal)->result_array();
      $data['jnsnonpns'] = $this->mnonpns->jenis_nonpns()->result_array();
      $data['jab'] = $this->mnonpns->jabatan()->result_array();
      $data['gaji'] = $this->mnonpns->sumbergaji()->result_array();
      $data['unker'] = $this->munker->dd_unker()->result_array();                      
      $data['nik'] = $nik;
      $data['tmt_awal'] = $tmt_awal;
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'nonpns/editrwypekerjaan';
      $this->load->view('template', $data);
    }
  }

  function editrwypkj_aksi() {
    $nik = addslashes($this->input->post('nik'));
    $tmt_awal = addslashes($this->input->post('tmt_awal'));

    $fid_jenis = addslashes($this->input->post('fid_jenis'));
    $fid_jabatan = addslashes($this->input->post('fid_jabatan'));
    $nama_unker = strtoupper(addslashes($this->input->post('nama_unker')));
    $fid_sumbergaji = addslashes($this->input->post('fid_sumbergaji'));
    $gaji = addslashes($this->input->post('gaji'));
    $tmtawal = tgl_sql(addslashes($this->input->post('tmtawal')));
    $tmtakhir = tgl_sql($this->input->post('tmtakhir'));
    $no_sk = addslashes($this->input->post('no_sk'));    
    $tgl_sk = tgl_sql(addslashes($this->input->post('tgl_sk')));    
    $pejabat_sk = strtoupper(addslashes($this->input->post('pejabat_sk')));    

    $user = $this->session->userdata('nip');
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(      
      'pejabat_sk'          => $pejabat_sk,
      'no_sk'               => $no_sk,
      'tgl_sk'              => $tgl_sk,
      'gaji'                => $gaji,
      'tmt_awal'            => $tmtawal,
      'tmt_akhir'           => $tmtakhir,
      'fid_jenis_nonpns'    => $fid_jenis,
      'fid_sumbergaji'      => $fid_sumbergaji,
      'nama_unit_kerja'      => $nama_unker,
      'fid_jabnonpns'       => $fid_jabatan,
      'created_at'          => $tgl_aksi,
      'created_by'          => $user
      );

    $where = array(
      'nik'                 => $nik,
      'tmt_awal'            => $tmt_awal,
    );

    $nama = $this->mnonpns->getnama($nik);

    if ($this->mnonpns->edit_rwypkj($where, $data))
    {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Pekerjaan A.n. <u>'.$nama.'</u> berhasil ditambah.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Riwayat Pekerjaan A.n. <u>'.$nama.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $nik = $this->input->post('nik');
    $data['rwypdk'] = $this->mnonpns->rwypkj($nik)->result_array();
    $data['nik'] = $nik;    
    $data['content'] = 'nonpns/rwypekerjaan';
    $this->load->view('template', $data);
  }


}

/* End of file pegawai.php */
/* Location: ./application/controllers/pegawai.php */
