<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kgb extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');      
      $this->load->helper('fungsiterbilang');
      $this->load->model('mpegawai');
      $this->load->model('mstatistik');
      $this->load->model('munker');
      $this->load->model('mkgb');
      $this->load->model('datacetak');

      // untuk pagination
      $this->load->helper(array('url'));

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // untuk fpdf
      $this->load->library('fpdf');

      // untuk barcode
      //$this->load->library('zend');
      //$this->zend->load('Zend/Barcode');
    }
  
  function tampilpengantar()
  {
    if ($this->session->userdata('usulkgb_priv') == "Y") { 
      $data['kgb'] = $this->mkgb->tampilpengantar()->result_array();
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'kgb/tampilpengantar';
      $this->load->view('template',$data);
    }
  }

  function tambahpengantar(){           
    $data['unker'] = $this->munker->dd_unker()->result_array();
    //$data['golru'] = $this->mpegawai->golru()->result_array();
    $data['content'] = 'kgb/tambahpengantar';
    $this->load->view('template', $data);
  }

  function tambahpengantar_aksi() {
    $nopengantar = addslashes($this->input->post('nopengantar'));
    $tglpengantar = addslashes($this->input->post('tglpengantar'));
    $id_unker = addslashes($this->input->post('id_unker'));
    $id_status = '1'; // status awal adalah 1->SKPD

    // konversi ke format yyyy-mm-dd
    $tglpengantarbaru = tgl_sql($tglpengantar);
    $created = $this->session->userdata('nip');

    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $time = $this->mlogin->datetime_saatini();

    $data = array(
      'no_pengantar'           => $nopengantar,
      'tgl_pengantar'         => $tglpengantarbaru,
      'fid_unit_kerja'         => $id_unker,
      'fid_status'       => $id_status,
      'created_at'        => $time,
      'created_by'       => $created
      );

    if ($this->mkgb->input_pengantar($data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        //$data['pesan'] = '<b>Sukses</b>, Pengantar Cuti Nomor '.$data['no_pengantar'].' berhasil ditambah';
        //$data['jnspesan'] = 'alert alert-success';
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, Pengantar KGB Nomor '.$data['no_pengantar'].' berhasil ditambah');
        redirect('kgb/tampilpengantar');
      } else {
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti Nomor '.$data['no_pengantar'].' gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
        //$data['jnspesan'] = 'alert alert-danger';
        $this->session->set_flashdata('pesan', '<b>Gagal !</b>, Pengantar KGB Nomor '.$data['no_pengantar'].' gagal ditambah.<br />Pastikan data sesuai dengan ketentuan');
        redirect('kgb/tampilpengantar');
      }

    // tampilkan view cuti
      //$data['cuti'] = $this->mcuti->tampilpengantar()->result_array();
      //$data['content'] = 'cuti/tampilpengantarcuti';
      //$this->load->view('template', $data);
  }

  function editpengantar() {
    $id = $this->input->post('id_pengantar');
    $tgl = $this->input->post('tgl_pengantar');
    $data['kgb'] = $this->mkgb->detailusul($id, $tgl)->result_array();
    $data['content'] = 'kgb/editpengantar';
    $this->load->view('template', $data);
  }

  function editpengantar_aksi() {    
    $id = $this->input->post('idpengantar');
    $no_lama = $this->input->post('nopengantar_lama');
    $no = $this->input->post('nopengantar');
    $tgl = tgl_sql($this->input->post('tglpengantar'));    

    $data = array(
      'no_pengantar'     => $no,
      'tgl_pengantar'    => $tgl
      );

    $where = array(
      'id_pengantar'     => $id
    );

    if ($this->mkgb->edit_pengantar($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Pengantar KGB Nomor <u>'.$no_lama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar KGB Nomor <u>'.$no_lama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $data['kgb'] = $this->mkgb->tampilpengantar()->result_array();  
    $data['content'] = 'kgb/tampilpengantar';
    $this->load->view('template', $data);
  }

  function detailpengantar() {
    $idpengantar = $this->input->post('id_pengantar');
      
    $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
    $data['kgb'] = $this->mkgb->detailpengantar($idpengantar)->result_array();
    $data['idpengantar'] = $idpengantar;
    $data['jmldata'] = count($this->mkgb->detailpengantar($idpengantar)->result_array());
    $data['pesan'] = '';    
    $data['jnspesan'] = '';      
    $data['content'] = 'kgb/detailpengantar';   
    
    $this->load->view('template', $data); 
  }

  function hapus_pengantar(){
    $idpengantar = addslashes($this->input->post('id_pengantar'));
    $nopengantar = addslashes($this->input->post('no_pengantar'));
    $where = array('id_pengantar' => $idpengantar);

    if ($this->mkgb->hapus_pengantar($where)) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $this->session->set_flashdata('pesan', '<b>Sukses</b>, Pengantar KGB Nomor '.$nopengantar.' berhasil dihapus');
        //$data['pesan'] = '<b>Sukses</b>, Pengantar Cuti Nomor '.$nopengantar.' berhasil dihapus';
        //$data['jnspesan'] = 'alert alert-success';
        redirect('kgb/tampilpengantar');
      } else {
        $this->session->set_flashdata('pesan', '<b>Gagal</b>, Pengantar KGB Nomor '.$nopengantar.' gagal dihapus');
        //$data['pesan'] = '<b>Gagal !</b>, Pengantar Cuti Nomor '.$nopengantar.' gagal dihapus';
        //$data['jnspesan'] = 'alert alert-danger';
        redirect('kgb/tampilpengantar');
      }
  }

  function tambahusul() {
    $data['idpengantar'] = $this->input->post('id_pengantar');
    
    $data['nopengantar'] = $this->mkgb->getnopengantar($data['idpengantar']);
    $data['tglpengantar'] = $this->mkgb->gettglpengantar($data['idpengantar']);
    
    $data['content'] = 'kgb/tambahusul';
    $this->load->view('template', $data);
  } 

  // fungsi ini digunakan pada fungsi showDataTambah() untuk menampilkan status SKP pada setiap usulan
  // sebelum usulan tersebut disimpan
  
  function showStatusBerkas($nip) 
  {
    $nama = $this->mpegawai->getnama_session($nip);
    // cek apakah NIP tersebut pernah diusulkan tahun ini date('Y')
    $tahunini = date('Y');
    $pernahusul = $this->mkgb->cektelahusul($nip, $tahunini);

    //cek SKP dan filenya
    $tahun = $tahunini-1;    
    $nmfileskp = $nip."-".$tahun;
    $skpada = $this->mpegawai->cekskpthn($nip, $tahun);

    $jmlrwykp = $this->mpegawai->cek_jmlrwykp($nip);
    $nmfilekp = $this->mpegawai->getberkaskpterakhir($nip);

    $jmlrwykgb = $this->mpegawai->cek_jmlrwykgb($nip);
    $nmfilekgb = $this->mpegawai->getberkaskgbterakhir($nip);

    $nmfilecp = $this->mpegawai->getberkascpnspns($nip);

    if ($nama) {
      $lokasifile = './photo/';
      $filename = "$nip.jpg";

      if (file_exists ($lokasifile.$filename)) {
        $photo = "../photo/$nip.jpg";
      } else {
        $photo = "../photo/nophoto.jpg";
      }

      echo "<center><img src='$photo' width='105' height='140' alt='$nip.jpg' class='img-thumbnail'><br /><b>$nama</b><br/><br/>";

      if ($pernahusul) {
              //echo "<center><b><span style='color: #FF0000'>ASN pernah diusulkan pada pengantar<br />Nomor : ".$this->mcuti->getnopengantarbynip($nip,date('Y'))."<br />Tanggal : ".tgl_indo($this->mcuti->gettglpengantarbynip($nip,date('Y')))."</span></b></center>";
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<center><span style='color: #FF0000'>Usul KGB PNS ybs sedang diproses</span></center>";
      } else if ($skpada == 0) {
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<center><span style='color: #FF0000'>Data SKP Tahun ".$tahun." tidak ditemukan,<br/> Silahkan lakukan updating data<br />pada riwayat SKP.</span></center>";
      } else if ((!file_exists('./filecp/'.$nmfilecp.'.pdf')) AND (!file_exists('./filecp/'.$nmfilecp.'.PDF'))) {
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<center><span style='color: #FF0000'>File Berkas CPNS/PNS belum diupload</span></center>";
      } else if (((!file_exists('./filekgb/'.$nmfilekgb.'.pdf')) AND (!file_exists('./filekgb/'.$nmfilekgb.'.PDF'))) AND ($jmlrwykgb != 0)) {
        // kalau jumlah riwayat KGB ($jmlrwykgb) kosong, berarti blm pernah usul KGB dan file tidak ada
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<center><span style='color: #FF0000'>File Berkas KGB Terakhir belum diupload</span></center>";
      } else if (((!file_exists('./filekp/'.$nmfilekp.'.pdf')) AND (!file_exists('./filekp/'.$nmfilekp.'.PDF'))) AND ($jmlrwykp != 0)) {
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<center><span style='color: #FF0000'>File Berkas SK Kenaikan Pangkat Terakhir belum diupload</span></center>";
      } else if ((!file_exists('./fileskp/'.$nmfileskp.'.pdf')) AND (!file_exists('./fileskp/'.$nmfileskp.'.PDF'))) {
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<center><span style='color: #FF0000'>File Berkas SKP Tahun ".$tahun." belum diupload</span></center>";
      } else {
        //echo "<center><img src='".base_url()."photo/$nip.jpg' width='75' height='100' alt='$nip.jpg' class='img-thumbnail'><br />$nama";
        echo "<input type='hidden' name='nipsimpan' size='20' value='$nip' />";
        echo "
        <button type='submit' class='btn btn-success btn-sm'>
          <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
        </button>";        
      }   
      echo "</center>";        
    } else {
      echo "<center><b><span style='color: #FF0000'>PNS tidak ditemukan,<br/>atau berada diluar kewenangan anda.</span></b></center>";
    } 
  }

  function showDataTambah() {
    $idberkas = $this->input->get('idberkas');    // kalau menggunakan metode post untuk ajax
    $nip = $this->input->get('nip');

    if (($idberkas == 'SKKP') and ($nip != '')) {
      $datagolru = $this->mkgb->getdatagolru($nip)->result_array();
      foreach($datagolru as $v):
      ?>
      <div class='alert alert-info' role='alert'>
      <table class='table'>        
        <tr class='default'>
          <td align='center' colspan='4'><span style='color: #FF0000'>DATA PANGKAT TERAKHIR (Silahkan disesuaikan dengan SK Pangkat terakhir yang dimiliki)</span></td>
          <td rowspan='5'>
            <?php
              $this->showStatusBerkas($nip);
            ?>      
          </td>
        </tr>
        <tr class='info'>
          <td align='right' width='130'>No. SK :</td>
          <td align='left'><input type='text' name='nosk' value='<?php echo $v['no_sk']; ?>' /></td>
          <td align='right'>Tgl. SK :</td>
          <td align='left'><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tglsk' class='tanggal' value='<?php echo tgl_sql($v['tgl_sk']); ?>' />
            <small id="passwordHelpInline" class="text-muted">
              Hari-Bulan-Tahun (HH-BB-TTTT).
            </small>
          </td>
        </tr>
        <tr class='info'>
          <td align='right'>Pejabat :</td>
          <td align='left' colspan='3'><input type='text' size='80' maxlength='100' name='pjbpengantar' value='<?php echo $v['pejabat_sk']; ?>'/></td>
        </tr>
        <tr class='info'>
          <td align='right'>Masa Kerja :</td>
          <td align='left'>
            <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkthnlama' value='<?php echo $v['mkgol_thn']; ?>' /> Tahun
            <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkblnlama' value='<?php echo $v['mkgol_bln']; ?>' /> Bulan
          </td>
          <td align='right'>Gaji Pokok :</td>
          <td align='left'>
            Rp. <input type='text' size='10' maxlength='7' name='gapoklama' onkeyup='validAngka(this)' value='<?php echo $v['gapok']; ?>' />
            <small id="gajiHelpInline" class="text-muted">
              ditulis Tanpa titik
            </small>
          </td>
        </tr>
        <tr class='info'>
          <td align='right'>Pangkat/Golru :</td>
          <td align='left'>
          <?php
            $golru = $this->mpegawai->golru()->result_array();
            echo "<select name='fid_golru_lama' id='fid_golru_lama'>";  
            foreach($golru as $gl)
            {
              if ($v[fid_golru] == $gl[id_golru]) {
                echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
              } else {
                echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
              }
            }
          ?>
          </td>
          <td align='right'>TMT :</td>
          <td align='left'><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tmt' class='tanggal' value='<?php echo tgl_sql($v['tmt']); ?>' />
            <small id="passwordHelpInline" class="text-muted">
              Hari-Bulan-Tahun (HH-BB-TTTT).
            </small>
          </td>
        </tr>
      </table>
      </div>
      <?php
      endforeach;
    } else if (($idberkas == 'SKCPNS') and ($nip != '')) {
      $datacpns = $this->mkgb->getdatacpns($nip)->result_array();
      foreach($datacpns as $v):
      ?>
      <div class='alert alert-info' role='alert'>
      <table class='table'>        
        <tr class='default'>
          <td align='center' colspan='4'><span style='color: #FF0000'>DATA SK CPNS (Silahkan disesuaikan dengan SK CPNS/PNS yang dimiliki)</span></td>
          <td rowspan='5'>
            <?php
              $this->showStatusBerkas($nip);
            ?>      
          </td>
        </tr>
        <tr class='info'>
          <td align='right' width='130'>No. SK :</td>
          <td align='left'><input type='text' name='nosk' value='<?php echo $v['no_sk_cpns']; ?>' /></td>
          <td align='right'>Tgl. SK :</td>
          <td align='left'><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tglsk' class='tanggal' value='<?php echo tgl_sql($v['tgl_sk_cpns']); ?>' />
            <small id="passwordHelpInline" class="text-muted">
              Hari-Bulan-Tahun (HH-BB-TTTT).
            </small>
          </td>
        </tr>
        <tr class='info'>
          <td align='right'>Pejabat :</td>
          <td align='left' colspan='3'><input type='text' size='80' maxlength='100' name='pjbpengantar' value='<?php echo $v['pejabat_sk_cpns']; ?>'/></td>
        </tr>
        <tr class='info'>
          <td align='right'>Masa Kerja :</td>
          <td align='left'>
            <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkthnlama' value='<?php echo $v['mkthn_cpns']; ?>' /> Tahun
            <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkblnlama' value='<?php echo $v['mkbln_cpns']; ?>' /> Bulan
          </td>
          <td align='right'>Gaji Pokok :</td>
          <td align='left'>
            Rp. <input type='text' size='10' maxlength='7' name='gapoklama' onkeyup='validAngka(this)' value='<?php echo $v['gapok_cpns']; ?>' />
            <small id="gajiHelpInline" class="text-muted">
              ditulis Tanpa titik
            </small>
          </td>
        </tr>
        <tr class='info'>
          <td align='right'>Pangkat/Golru :</td>
          <td align='left'>
            <?php
              $golru = $this->mpegawai->golru()->result_array();
              echo "<select name='fid_golru_lama' id='fid_golru_lama'>";  
              foreach($golru as $gl)
              {
                if ($v[fid_golru_cpns] == $gl[id_golru]) {
                  echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                } else {
                  echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                }
              }
            ?>
          </td>
          <td align='right'>TMT :</td>
          <td align='left'><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tmt' class='tanggal' value='<?php echo tgl_sql($v['tmt_cpns']); ?>' />
            <small id="passwordHelpInline" class="text-muted">
              Hari-Bulan-Tahun (HH-BB-TTTT).
            </small>
          </td>
        </tr>
      </table>
      </div>
      <?php
      endforeach;
    } else if (($idberkas == 'SKKGB') and ($nip != '')) {
      $datakgb = $this->mkgb->getdatakgbakhir($nip)->result_array();
      $jmldatakgb = count($this->mkgb->getdatakgbakhir($nip)->result_array());
      if ($jmldatakgb == 0) {
        echo "<div class='alert alert-danger' role='alert'>
              <strong>Perhatian!</strong> Data Riwayat KGB terakhir tidak ditemukan, Silahkan hubungi administrator.
            </div>";
      }

      foreach($datakgb as $v):
      ?>
      <div class='alert alert-info' role='alert'>
      <table class='table'>        
        <tr class='default'>
          <td align='center' colspan='4'><span style='color: #FF0000'>DATA KENAIKAN GAJI BERKALA TERAKHIR (Silahkan disesuaikan dengan SK KGB terakhir yang dimiliki)</span></td>
          <td rowspan='5'>
            <?php
              $this->showStatusBerkas($nip);
            ?>      
          </td>
        </tr>
        <tr class='info'>
          <td align='right' width='130'>No. SK :</td>
          <td align='left'><input type='text' size='30' name='nosk' value='<?php echo $v['no_sk']; ?>' readonly /></td>
          <td align='right'>Tgl. SK :</td>
          <td align='left'><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tglsk' class='tanggal' value='<?php echo tgl_sql($v['tgl_sk']); ?>' readonly/>
            <small id="passwordHelpInline" class="text-muted">
              Hari-Bulan-Tahun (HH-BB-TTTT).
            </small>
          </td>
        </tr>
        <tr class='info'>
          <td align='right'>Pejabat :</td>
          <td align='left' colspan='3'><input type='text' size='80' maxlength='100' name='pjbpengantar' value='<?php echo $v['pejabat_sk']; ?>' readonly/></td>
        </tr>
        <tr class='info'>
          <td align='right'>Masa Kerja :</td>
          <td align='left'>
            <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkthnlama' value='<?php echo $v['mk_thn']; ?>' readonly /> Tahun
            <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkblnlama' value='<?php echo $v['mk_bln']; ?>' readonly /> Bulan
          </td>
          <td align='right'>Gaji Pokok :</td>
          <td align='left'>
            Rp. <input type='text' size='10' maxlength='7' name='gapoklama' onkeyup='validAngka(this)' value='<?php echo $v['gapok']; ?>' readonly />
            <small id="gajiHelpInline" class="text-muted">
              ditulis Tanpa titik
            </small>
          </td>
        </tr>
        <tr class='info'>
          <td align='right'>Pangkat/Golru :</td>
          <td align='left'>
            <?php
              $golru = $this->mpegawai->golru()->result_array();
              echo "<select name='fid_golru_lama' id='fid_golru_lama' />";  
              foreach($golru as $gl)
              {
                if ($v[fid_golru] == $gl[id_golru]) {
                  echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                } 
		//else {
                //  echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                //}
              }
	      echo "</select>";
            ?>
          </td>
          <td align='right'>TMT :</td>
          <td align='left'><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tmt' class='tanggal' value='<?php echo tgl_sql($v['tmt']); ?>' readonly />
            <small id="passwordHelpInline" class="text-muted">
              Hari-Bulan-Tahun (HH-BB-TTTT).
            </small>
          </td>
        </tr>
      </table>
      </div>
      <?php
      endforeach;
    } else if (($idberkas == '') or ($nip == '')) {
      echo "<div class='alert alert-danger' role='alert'>
              <strong>Perhatian!</strong> Silahkan masukkan NIP dan dokumen yang digunakan sebagai dasar penentuan gaji terakhir.
            </div>";
      //echo "<center><span style='color: #FF0000'><b>PERHATIAN !!!.</b> Silahkan masukkan NIP dan dokumen yang digunakan sebagai dasar penentuan gaji terakhir.</span></center>";
    }    
  }

  function tambahusul_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('id_pengantar');  

    $nosk = addslashes($this->input->post('nosk'));
    $tglsk = tgl_sql($this->input->post('tglsk'));
    $pjbpengantar = addslashes($this->input->post('pjbpengantar'));
    $mkthnlama = addslashes($this->input->post('mkthnlama'));
    $mkblnlama = addslashes($this->input->post('mkblnlama'));
    $gapoklama = addslashes($this->input->post('gapoklama'));
    $fid_golru_lama = addslashes($this->input->post('fid_golru_lama'));
    $tmt = tgl_sql($this->input->post('tmt'));
    $tahun = date('Y');
    $id_status = 1; // untuk status kgb INBOXSKPD (pada tabel ref_statuskgb)

    $user_usul = $this->session->userdata('nip');
    $tgl_usul = $this->mlogin->datetime_saatini();

    $data = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar,
      'gapok_lama'        => $gapoklama,
      'fid_golru_lama'    => $fid_golru_lama,
      'sk_lama_pejabat'   => $pjbpengantar,
      'sk_lama_tgl'       => $tglsk,
      'sk_lama_no'        => $nosk,
      'tmt_gaji_lama'     => $tmt,
      'mk_thn_lama'       => $mkthnlama,
      'mk_bln_lama'       => $mkblnlama,
      'fid_status'        => $id_status,
      'user_usul'         => $user_usul,
      'tgl_usul'          => $tgl_usul
      );

    // cek apakah sudah pernah usul, untuk menghindari refresh/reload pada page tambahusul_aksi
    if ($this->mkgb->cektelahusul($nip, $tahun) == 0) {
      if ($this->mkgb->input_usul($data))
        {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Usul KGB <u>'.$this->mpegawai->getnama($data['nip']).'</u> berhasil ditambah.';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Gagal !</b>, Usul KGB <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
          $data['jnspesan'] = 'alert alert-danger';
        }   
    } else {
      // jika sudah pernah usul
      $data['pesan'] = '<b>Gagal !</b>, Usul KGB <u>'.$this->mpegawai->getnama($data['nip']).'</u> gagal ditambah.<br />Usul KGB PNS yang bersangkutan sedang diproses';
      $data['jnspesan'] = 'alert alert-danger';
    }
   
    $idpengantar = $this->input->post('id_pengantar');
      
    $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
    $data['kgb'] = $this->mkgb->detailpengantar($idpengantar)->result_array();
    $data['idpengantar'] = $idpengantar;
    $data['jmldata'] = count($this->mkgb->detailpengantar($idpengantar)->result_array());
    $data['content'] = 'kgb/detailpengantar';
    $this->load->view('template', $data);
  }

  function detailusul() {
    $nip = $this->input->post('nip');
    $fid_pengantar = $this->input->post('fid_pengantar');

    $data['idpengantar'] = $fid_pengantar;
    
    $data['kgb'] = $this->mkgb->detailDataUsul($nip, $fid_pengantar)->result_array();
    $data['content'] = 'kgb/detailusul';   
    $this->load->view('template', $data); 
  }

  function hapus_usul()
  {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $nama = $this->mpegawai->getnama($nip);
    $where = array('nip' => $nip,
                   'fid_pengantar' => $fid_pengantar
             );

    if ($this->mkgb->hapus_usul($where)) {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB '.$nama.' berhasil dihapus';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal</b>, Usul Cuti '.$nama.' gagal dihapus';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $idpengantar = $fid_pengantar;
      
    $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
    $data['kgb'] = $this->mkgb->detailpengantar($idpengantar)->result_array();
    $data['idpengantar'] = $idpengantar;
    $data['jmldata'] = count($this->mkgb->detailpengantar($idpengantar)->result_array());
    $data['content'] = 'kgb/detailpengantar';
    $this->load->view('template', $data);
  }

  function editusul() {
    $nip = $this->input->post('nip');
    $idpengantar = $this->input->post('fid_pengantar');    
    $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['tglpengantar'] = $this->mkgb->gettglpengantar($idpengantar);
    $data['nip'] = $nip;
    $data['idpengantar'] = $idpengantar;
    $data['kgb'] = $this->mkgb->detailDataUsul($nip, $idpengantar)->result_array();
    $data['content'] = 'kgb/editusul';
    $this->load->view('template', $data);
  }

  function editusul_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('id_pengantar');
    
    $gapoklama = addslashes($this->input->post('gapoklama'));
    $tmtgajilama = tgl_sql($this->input->post('tmtgajilama'));
    $mkthnlama = $this->input->post('mkthnlama');
    $mkblnlama = $this->input->post('mkblnlama');
    $nosk = addslashes($this->input->post('nosk'));
    $tglsk = tgl_sql($this->input->post('tglsk'));
    $pjbpengantar = addslashes($this->input->post('pjbpengantar'));    
    $fid_golru_lama = addslashes($this->input->post('fid_golru_lama'));
    $id_status = 1; // untuk status kgb INBOXSKPD (pada tabel ref_statuskgb)

    $nama = $this->mpegawai->getnama($nip);

    //$user_usul = $this->session->userdata('nip');
    //$tgl_usul = $this->mlogin->datetime_saatini();  

    $data = array(      
      'gapok_lama'      => $gapoklama,
      'fid_golru_lama'  => $fid_golru_lama,
      'sk_lama_pejabat' => $pjbpengantar,
      'sk_lama_tgl'     => $tglsk,
      'sk_lama_no'      => $nosk,
      'tmt_gaji_lama'   => $tmtgajilama,
      'mk_thn_lama'     => $mkthnlama,
      'mk_bln_lama'     => $mkblnlama,
      'fid_status'      => $id_status
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar
    );

    if ($this->mkgb->edit_usul($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB atas nama<u> '.$nama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul KGB atas nama<u> '.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }
      
    $data['nopengantar'] = $this->mkgb->getnopengantar($id_pengantar);
    $data['kgb'] = $this->mkgb->detailpengantar($id_pengantar)->result_array();
    $data['idpengantar'] = $id_pengantar;
    $data['jmldata'] = count($this->mkgb->detailpengantar($id_pengantar)->result_array());
    $data['content'] = 'kgb/detailpengantar';
    $this->load->view('template', $data);
  }

  public function cetakpengantar()  
  {
    //$id_pengantar = $this->input->post('id_pengantar');
    //$fid_unit_kerja = $this->input->post('fid_unit_kerja');

    $res['data'] = $this->datacetak->datacetakpengantarkgb();
    
    $this->load->view('/kgb/cetakpengantar',$res);        
  }

  function tampilproses()
  {
    if ($this->session->userdata('proseskgb_priv') == "Y") { 
      $data['kgb'] = $this->mkgb->tampilproses()->result_array();      
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'kgb/tampilproses';
      $this->load->view('template',$data);
    }
  }

  public function kirim_kebkppd()  
  {
    $id_pengantar = $this->input->post('id_pengantar');
    $no_pengantar = $this->input->post('no_pengantar');
    $tgl_kirim = $this->mlogin->datetime_saatini();

    // update status kgb : INBOXBKPPD => 3 berdasarkan id_pengantar
    $id_statkgb = 3;  // status kgb : INBOXBKPPD
    $datakgb = array(      
      'fid_status'      => $id_statkgb,
      'tgl_kirim_usul'  => $tgl_kirim
    );

    $wherekgb = array(
    'fid_pengantar'   => $id_pengantar
    );

    // update status pengantar : BKPPD => 3 berdasarkan id_pengantar dan fid_unit_kerja
    $id_statpengantar = 3;  // status pengantar : BKPPD
    $datapengantar = array(      
      'fid_status'      => $id_statpengantar
    );

    $wherepengantar = array(
    'id_pengantar'   => $id_pengantar
    );
    
    // rubah fid_status kgb sesuai data array diatas, 3 => INBOXBKPPD
    if ($this->mkgb->edit_usul($wherekgb, $datakgb)) {

        // rubah status pengantar menjadi : 3 => BKPPD
        $this->mkgb->edit_pengantar($wherepengantar, $datapengantar);

        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB <u>'.$this->mkgb->getnopengantar($id_pengantar).'</u> berhasil dikirim.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul Cuti <u>'.$this->mkgb->getnopengantar($id_pengantar).'</u> gagal dikirim.';
        $data['jnspesan'] = 'alert alert-danger';
    }   

    $data['kgb'] = $this->mkgb->tampilpengantar()->result_array();
    $data['content'] = 'kgb/tampilpengantar';
    $this->load->view('template', $data);
  }

  function detailproses() {
    if ($this->session->userdata('proseskgb_priv') == "Y") { 
      $idpengantar = $this->input->post('id_pengantar');
        
      $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
      $data['kgb'] = $this->mkgb->detailproses($idpengantar)->result_array();
      $data['idpengantar'] = $idpengantar;
      $data['jmldata'] = count($this->mkgb->detailproses($idpengantar)->result_array());
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
        
      $data['content'] = 'kgb/detailproses';         
      $this->load->view('template', $data);
    } 
  }

  function prosesusul() {
    $fid_pengantar = $this->input->post('fid_pengantar');
    $nip = $this->input->post('nip');
    $data['idpengantar'] = $fid_pengantar;
    $data['kgb'] = $this->mkgb->detailDataUsul($nip, $fid_pengantar)->result_array();

    // untuk riwayat2
    $thnskp = date('Y')-1;
    $data['rwyskp'] = $this->mpegawai->dtlskp($nip, $thnskp)->result_array();
    $data['rwykgb'] = $this->mpegawai->rwykgb($nip)->result_array();
    $data['rwycp'] = $this->mpegawai->rwycp($nip)->result_array();
    $data['rwykp'] = $this->mpegawai->rwykp($nip)->result_array();

    $data['content'] = 'kgb/prosesusul'; 
    $this->load->view('template', $data); 
  } 

  // untuk menghitung KGB berikutnya pada form prosesusul.php
  function showHasilProses() {
    $fidgolru = $this->input->get('fidgolru'); 
    $mk_thn = $this->input->get('mkthn'); 
    $mk_bln = $this->input->get('mkbln'); 
    $tmt = $this->input->get('tmt');

    $tmt_thn = substr($tmt,0,4);
    $tmt_bln = substr($tmt,5,2);



    // cari selisih bulan mk untuk menambahkan 1 tahun
    $mk_blnbaru = 12-$mk_bln;
    $mk_bln = 0;
    //$mk_thn++;
    $tmt_bln = $tmt_bln+$mk_blnbaru;

    if ($tmt_bln > 12) {
      $tmt_thn=$tmt_thn+1;
      $tmt_bln = $tmt_bln-12;
    }

    /*$sisabln = $tmt_bln%12;
    if ($sisabln) {
      $tmt_bln = $sisabln;
      //$tmt_bln = $tmt_bln-12;
      //$tmt_thn++;
    }
    */

    // cek golongan, untuk golongan II/abcd dan I/bcd menggunakan kenaikan gaji ganjil    
    if (($fidgolru == '21') OR ($fidgolru == '22') OR ($fidgolru == '23') OR ($fidgolru == '24') OR ($fidgolru == '12') OR ($fidgolru == '13') OR ($fidgolru == '14')) {      
      if (!($mk_thn%2)) {
        // cek gaji disini    
        //$tmt_thn++;

        // NI NYA NAH (yg TMT tahun lalu mk genap, ditambahkannya 2 tahun, padahal 1 tahun ja untuk jadi mk ganjil)
        //$tmt_thn=$tmt_thn+1;

        //$mk_thn++;
        $mk_thn=$mk_thn+1;
        //echo '<br/>2 genap';
      } else {
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        $mk_thn=$mk_thn+2;
        //echo '<br/>2 ganjil';
      }
      //echo '<br/>golru 2 : '.$fidgolru;
    } else {
      // jika mk genap
      if (!($mk_thn%2)) {
        // cek gaji disini    
        //$tmt_thn++;
        
        $tmt_thn=$tmt_thn+1;
        $mk_thn=$mk_thn+2;

        //echo '<br/>134 genap';
      } else {
        //$tmt_thn++;
        
        // NI NYA NAH (yg TMT tahun lalu mk ganjil, ditambahkannya 2 tahun, padahal 1 tahun ja untuk jadi mk genap)
        //$tmt_thn=$tmt_thn+1;
        
        //$mk_thn++;
        $mk_thn=$mk_thn+1;
        //echo '<br/>134 ganjil';
      }
      //echo '<br/>golru 134 : '.$fidgolru;
    }       
    
    // diperlukan nama pangkat untuk query pada tabel ref_gaji
    $namgolru = $this->mpegawai->getnamagolru($fidgolru);
    $gaji = $this->mkgb->getgaji($namgolru, $mk_thn);

    /*
    echo '<br/>MK Tahun : '.$mk_thn;
    echo '<br/>MK Bulan : '.$mk_bln;
    echo '<br/>Golru : '.$namgolru;
    echo '<br/>TMT : '.$tmt_bln.'-'.$tmt_thn;
    echo '<br/>Gaji : Rp. '.indorupiah($gaji);
    */

    ?>
    <table class="table table-condensed">
      <tr class='success'>
        <td align='right'><b>Gaji Pokok Baru</b> :</td>
        <td>
        <input type="text" size='15' name="gapok" value="<?php echo $gaji; ?>" />
        <?php //echo 'Rp. '.indorupiah($gaji).',-'; ?>
        </td>
      </tr>                
      <tr class='success'>
        <td align='right'><b>Berdasarkan Masa Kerja</b> :</td>
        <td>
          <input type="text" size='3' maxlength='2' name="mkthn" value="<?php echo $mk_thn; ?>" /> Tahun
          <input type="text" size='3' maxlength='2' name="mkbln" value="<?php echo $mk_bln; ?>" /> Bulan
          <?php //echo $mk_thn.' Tahun, '.$mk_bln.' Bulan'; ?>
        </td>
      </tr>
      <tr class='success'>
        <td align='right'><b>Dalam Golru</b> :</td>
        <td>
          <?php echo $this->mpegawai->getnamapangkat($fidgolru).' ('.$this->mpegawai->getnamagolru($fidgolru).')';?>
          <input type="hidden" size='3' name="fid_golru_baru" value="<?php echo $fidgolru; ?>" />
        </td>                  
      </tr>
      <tr class='success'>
        <td align='right'><b>TMT KGB</b> :</td>
        <td>
          <input type="text" size='10' name="tmtkgb" class='tanggal' value="<?php echo '01-'.$tmt_bln.'-'.$tmt_thn; ?>" />
          <?php //echo '1 '.bulan($tmt_bln).' '.$tmt_thn; ?>
        </td>                  
      </tr>
      <tr class='success'>
        <td align='right'><b>TMT KGB Berikutnya</b> :</td>
        <td>
          <input type="text" size='10' name="tmtberikutnya" class='tanggal' value="<?php echo '01-'.$tmt_bln.'-'.($tmt_thn+2); ?>" />
          <?php //echo '1 '.bulan($tmt_bln).' '.($tmt_thn+2)  ; ?>
        </td>                  
      </tr>
      
    </table>
    <?php
  }

  function prosesusulsetuju() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $no_sk = addslashes($this->input->post('no_sk'));
    $tgl_sk = tgl_sql($this->input->post('tgl_sk'));
    $pejabat_sk = addslashes($this->input->post('pejabat_sk'));
    $id_status = '4'; // SETUJU

    $gapok = addslashes($this->input->post('gapok'));
    $mkthn = addslashes($this->input->post('mkthn'));
    $mkbln = addslashes($this->input->post('mkbln'));
    $fid_golru_baru = addslashes($this->input->post('fid_golru_baru'));
    $tmtkgb = tgl_sql($this->input->post('tmtkgb'));
    $tmtberikutnya = tgl_sql($this->input->post('tmtberikutnya'));

    //$data['pesan'] = '<b>Hasil</b>, Usul Cuti <u>'.$gapok.''.$mkthn.'/'.$mkbln.'/'.$tmtkgb.'/'.$tmtberikutnya.'</u> tidak disetujui.';
    //$data['jnspesan'] = 'alert alert-danger';

    
    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'no_sk'           => $no_sk,
      'tgl_sk'          => $tgl_sk,
      'pejabat_sk'      => $pejabat_sk,

      'gapok_baru'          => $gapok,
      'mk_thn_baru'         => $mkthn,
      'mk_bln_baru'         => $mkbln,
      'fid_golru_baru'      => $fid_golru_baru,
      'tmt_gaji_baru'       => $tmtkgb,
      'tmt_gaji_berikutnya' => $tmtberikutnya

      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );

    if ($this->mkgb->edit_usul($where, $data))
    {
	// TODO QR CODE
        // Generate QR Code jika Berhasil
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodekgb/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 17; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        }
        $thnini = date('Y');
        $image_name = $nip."-".$thnini.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'
 
        //$image_name=$nip.'_'.$tgl_sk.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $nip."-".$thnini.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // entri QR Code pada database
        $data = array(      
          'qrcode'  => $params['data']
          );

        $where = array(
          'nip'               => $nip,
          'fid_pengantar'     => $fid_pengantar
        );
        $this->mkgb->edit_usul($where, $data);
        // END QR CODE
	

        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB A.n. <u>'.$this->mpegawai->getnama($nip).'</u> telah disetujui.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul KGB A.n. <u>'.$this->mpegawai->getnama($nip).'</u> tidak disetujui.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
     if ($this->session->userdata('proseskgb_priv') == "Y") { 
      $idpengantar = $this->input->post('fid_pengantar');
        
      $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
      $data['kgb'] = $this->mkgb->detailproses($idpengantar)->result_array();
      $data['idpengantar'] = $idpengantar;
      $data['jmldata'] = count($this->mkgb->detailproses($idpengantar)->result_array());
        
      $data['content'] = 'kgb/detailproses';         
      $this->load->view('template', $data);
    }
  }

  function prosesusultms() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $alasantms = $this->input->post('alasantms');
    $id_status = '6'; // TMS

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'alasan'          => $alasantms
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );

    if ($this->mkgb->edit_usul($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB A.n. <u>'.$this->mpegawai->getnama($nip).'</u> berhasil TMS.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul KGB A.n. <u>'.$this->mpegawai->getnama($nip).'</u> gagal TMS.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
    if ($this->session->userdata('proseskgb_priv') == "Y") { 
      $idpengantar = $this->input->post('fid_pengantar');
        
      $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
      $data['kgb'] = $this->mkgb->detailproses($idpengantar)->result_array();
      $data['idpengantar'] = $idpengantar;
      $data['jmldata'] = count($this->mkgb->detailproses($idpengantar)->result_array());
        
      $data['content'] = 'kgb/detailproses';         
      $this->load->view('template', $data);
    }
  }

  function prosesusulbtl() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = addslashes($this->input->post('fid_pengantar'));
    $alasanbtl = $this->input->post('alasanbtl');
    $id_status = '5'; // BTL

    $user_proses = $this->session->userdata('nip');
    // panggil function datetime_saatini() pada mlogin untuk mendapatkan tanggal waktu saat ini
    $tgl_proses = $this->mlogin->datetime_saatini();

    $data = array(      
      'fid_status'      => $id_status,
      'user_proses'     => $user_proses,
      'tgl_proses'      => $tgl_proses,
      'alasan'          => $alasanbtl
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );

    if ($this->mkgb->edit_usul($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB A.n. <u>'.$this->mpegawai->getnama($nip).'</u> berhasil BTL, dan dikirim ulang ke SKPD.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul KGB A.n. <u>'.$this->mpegawai->getnama($nip).'</u> gagal BTL.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    // tampilkan view detailproses
    if ($this->session->userdata('proseskgb_priv') == "Y") { 
      $idpengantar = $this->input->post('fid_pengantar');
        
      $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
      $data['kgb'] = $this->mkgb->detailproses($idpengantar)->result_array();
      $data['idpengantar'] = $idpengantar;
      $data['jmldata'] = count($this->mkgb->detailproses($idpengantar)->result_array());
        
      $data['content'] = 'kgb/detailproses';         
      $this->load->view('template', $data);
    }
  }

  public function cetaksk()  
  {
    $res['data'] = $this->datacetak->datacetakskkgb();
    $this->load->view('kgb/cetaksk',$res);    
  }

  public function cetaksk_skpd()  
  {
    $res['data'] = $this->datacetak->datacetakskkgb();
    $this->load->view('kgb/cetaksk_skpd',$res);    
  }

  function tampilinbox() {
    if ($this->session->userdata('usulkgb_priv') == "Y") { 
      $data['jmldata'] = $this->mkgb->jmltampilinbox();  

      // untuk paging versi dumet
      $this->load->library('pagination');
      $config['base_url'] = base_url().'kgb/tampilinbox';
      $config['total_rows'] = $this->mkgb->jmltampilinbox();
      $config['per_page'] = $per_page = 4;
      $config['uri_segment'] = 3;
      $config['first_link'] = 'Awal';
      $config['last_link'] = 'Akhir';
      $config['next_link'] = 'Selanjutnya';
      $config['prev_link'] = 'Sebelumnya';

      //$config['cur_tag_open'] = ' <strong>';
      //$config['cur_tag_close'] = '</strong>';
      //Tambahan untuk styling
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

      $this->pagination->initialize($config);
      $data['paging'] = $this->pagination->create_links();
      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      
      $data['kgb'] = $this->mkgb->tampilinbox($per_page,$page)->result_array();
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'kgb/tampilinbox';     

      $this->load->view('template',$data);
    }
  }    

  function detailtms() {
    $idpengantar = $this->input->post('fid_pengantar');
    $nip = $this->input->post('nip');

    $data['idpengantar'] = $idpengantar;
    $data['kgb'] = $this->mkgb->detailDataUsul($nip, $idpengantar)->result_array();  
    $data['content'] = 'kgb/detailtms';   
    $this->load->view('template', $data); 
  }

  function updatebtl() {
    $nip = $this->input->post('nip');
    $idpengantar = $this->input->post('fid_pengantar');

    $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
    $data['nama'] = $this->mpegawai->getnama($nip);
    $data['tglpengantar'] = $this->mkgb->gettglpengantar($idpengantar);
    $data['nip'] = $nip;
    $data['fid_pengantar'] = $idpengantar;
    $data['kgb'] = $this->mkgb->detailDataUsul($nip, $idpengantar)->result_array();
    $data['content'] = 'kgb/updatebtl';
    $this->load->view('template', $data);
  }

  function updateusulbtl_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $fid_pengantar = $this->input->post('fid_pengantar');
    
    $gapoklama = addslashes($this->input->post('gapoklama'));
    $tmtgajilama = tgl_sql($this->input->post('tmtgajilama'));
    $mkthnlama = $this->input->post('mkthnlama');
    $mkblnlama = $this->input->post('mkblnlama');
    $nosk = addslashes($this->input->post('nosk'));
    $tglsk = tgl_sql($this->input->post('tglsk'));
    $pjbpengantar = addslashes($this->input->post('pjbpengantar'));    
    $fid_golru_lama = addslashes($this->input->post('fid_golru_lama'));
    $id_status = 3; // data dikirimkan lagi ke BKPPD untuk status kgb INBOXBKPPD (pada tabel ref_statuskgb)

    $nama = $this->mpegawai->getnama($nip);

    //$user_usul = $this->session->userdata('nip');
    //$tgl_usul = $this->mlogin->datetime_saatini();  

    $data = array(      
      'gapok_lama'      => $gapoklama,
      'fid_golru_lama'  => $fid_golru_lama,
      'sk_lama_pejabat' => $pjbpengantar,
      'sk_lama_tgl'     => $tglsk,
      'sk_lama_no'      => $nosk,
      'tmt_gaji_lama'   => $tmtgajilama,
      'mk_thn_lama'     => $mkthnlama,
      'mk_bln_lama'     => $mkblnlama,
      'fid_status'      => $id_status
    );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $fid_pengantar
    );

    if ($this->mkgb->edit_usul($where, $data))
    {
      $data['pesan'] = '<b>Sukses</b>, Usul KGB atas nama<u> '.$nama.'</u> berhasil dirubah dan dikirim ke Tim Teknis BKPPD.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Usul KGB atas nama<u> '.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }      
    
    // tampilkan tampilinbox
    $data['jmldata'] = $this->mkgb->jmltampilinbox();  

    // untuk paging versi dumet
    $this->load->library('pagination');
    $config['base_url'] = base_url().'kgb/tampilinbox';
    $config['total_rows'] = $this->mkgb->jmltampilinbox();
    $config['per_page'] = $per_page = 4;
    $config['uri_segment'] = 3;
    $config['first_link'] = 'Awal';
    $config['last_link'] = 'Akhir';
    $config['next_link'] = 'Selanjutnya';
    $config['prev_link'] = 'Sebelumnya';

    //$config['cur_tag_open'] = ' <strong>';
    //$config['cur_tag_close'] = '</strong>';
    //Tambahan untuk styling
    $config['full_tag_open'] = "<ul class='pagination'>";
    $config['full_tag_close'] ="</ul>";
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
    $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
    $config['next_tag_open'] = "<li>";
    $config['next_tagl_close'] = "</li>";
    $config['prev_tag_open'] = "<li>";
    $config['prev_tagl_close'] = "</li>";
    $config['first_tag_open'] = "<li>";
    $config['first_tagl_close'] = "</li>";
    $config['last_tag_open'] = "<li>";
    $config['last_tagl_close'] = "</li>";

    $this->pagination->initialize($config);
    $data['paging'] = $this->pagination->create_links();
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    $data['kgb'] = $this->mkgb->tampilinbox($per_page,$page)->result_array();
    $data['content'] = 'kgb/tampilinbox';     

    $this->load->view('template',$data);
  }

  function rekapitulasi() {
    if ($this->session->userdata('usulkgb_priv') == "Y") {
      $data['content'] = 'kgb/rekapkgb';
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function carirekap() {
    $idunker = $this->input->get('idunker');
    $thn = $this->input->get('thn');

      $sqlcari = $this->mkgb->carirekap($idunker, $thn)->result_array();
      $jml = count($this->mkgb->carirekap($idunker, $thn)->result_array());

      if ($jml != 0) {
        echo '<br/>';
        echo '<table class="table table-condensed table-hover">';
        echo "<tr class='info'>
        <td align='center'><b>No</b></td>
        <td align='center' width='220'><b>NIP | Nama</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center' width='180'><b>Gaji Pokok Terakhir<br />TMT KGB</b></td>
        <td align='center' width='180'><b>Masa Kerja<br /> Golru</b></td>
        <td align='center' width='230'><b>Status</b></td>
        </tr>";

        $no = 1;
        foreach($sqlcari as $v):          
        echo "<tr><td align='center'>".$no."</td>";
        echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';

        if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        }

        echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab),'</td>';
        if ($v['fid_pengantar'] != null) {          
          echo "<td align='center' class='danger'>Rp. ".indorupiah($v['gapok_lama']).',-<br />'.tgl_indo($v['tmt_gaji_lama'])."</td>";
          echo "<td align='center' class='danger'>".$v['mk_thn_lama'].' Tahun, '.$v['mk_bln_lama'].' Bulan<br />'.$this->mpegawai->getnamapangkat($v['fid_golru_lama']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_lama']).")</td>";


          $status = $this->mkgb->getstatuskgb($v['fid_status']);
          echo "<td align='center' class='danger'>";
          if ($status == 'INBOXSKPD') {          
            echo "<h5><span class='label label-default'>Inbox SKPD</span></h5>";
          } else if ($status == 'CETAKUSUL') {
            echo "<h5><span class='label label-default'>Cetak Usul</span></h5>";
          } else if ($status == 'INBOXBKPPD') {          
            echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
          } else if ($status == 'BTL') {
            echo "<h5><span class='label label-warning'>B T L</span></h5>";
          } else if ($status == 'TMS') {
            echo "<h5><span class='label label-danger'>T M S</span></h5>";
          } else if ($status == 'SETUJU') {
            echo "<h5><span class='label label-success'>Setuju</span></h5>";
          } else if ($status == 'CETAKSK') {
            echo "<h5><span class='label label-info'>Cetak SK</span></h5>";
            //echo "<small>Diproses. ".tglwaktu_indo($v['tgl_proses'])."</small>";
            
            $cenvertedTime = new DateTime($v['tgl_proses']);
            $saatini = new DateTime();  
            $diff  = $cenvertedTime->diff($saatini);
            //print_r($diff);
            // tombol cetak akan tampil setelah 3 jam dari status Cetak SK BKPPD
	    
	    // UNTUK CETAK SK dilakukan oleh Umpeg SKPD	
            /*
	    if (($diff->h >= 3) OR (($diff->d >= 1) AND ($diff->h >= 0))) {
              ?>
                <form method='POST' name='formcetaksk' action='../kgb/cetaksk_skpd' target='_blank'>
                <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $v['fid_pengantar']; ?>'>
                <input type='hidden' name='nip' id='nip' size='18' value='<?php echo $v['nip']; ?>'>
                
                  <button type="submit" class="btn btn-info btn-xs">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbspCetak SK&nbsp
                  </button>
                </form>
              <?php
            } else {
              echo "<h5><span class='label label-default'>On Progress</span></h5>";
            }  
	    */
	  } else if ($status == 'SELESAISETUJU') {
            echo "<h5><span class='label label-success'>Selesai Setuju</span></h5>";
          } else if ($status == 'SELESAIBTL') {
            echo "<h5><span class='label label-success'>Selesai BTL</span></h5>";
          } else if ($status == 'SELESAITMS') {
            echo "<h5><span class='label label-success'>Selesai TMS</span></h5>";
          }
          echo "</td>";
          echo "<tr/>";
        } else {
          echo "<td class='success'></td>";
          echo "<td class='success'></td>";
          echo "<td class='success'></td>";
          echo "<tr/>";
        }

        $no++;
        endforeach;
      }
  }

  function bukujaga() {
    if ($this->session->userdata('usulkgb_priv') == "Y") {
      $data['content'] = 'kgb/bukujaga';
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function getgajiberikutnya($fidgolru, $mk_thn, $mk_bln, $tmt) {
    $tmt_thn = substr($tmt,0,4);
    $tmt_bln = substr($tmt,5,2);

    // cari selisih bulan mk untuk menambahkan 1 tahun
    $mk_blnbaru = 12-$mk_bln;
    $mk_bln = 0;
    //$mk_thn++;
    $tmt_bln = $tmt_bln+$mk_blnbaru;

    if ($tmt_bln > 12) {
      $tmt_thn=$tmt_thn+1;
      $tmt_bln = $tmt_bln-12;
    }

    // cek golongan, untuk golongan II menggunakan kenaikan gaji ganjil    
    if (($fidgolru == '21') OR ($fidgolru == '22') OR ($fidgolru == '23') OR ($fidgolru == '24') OR ($fidgolru == '12') OR ($fidgolru == '13') OR ($fidgolru == '14')) {      
      if (!($mk_thn%2)) {
        // cek gaji disini    
        //$tmt_thn++;
        //$tmt_thn=$tmt_thn+1;
        //$mk_thn++;
        $mk_thn=$mk_thn+1;
        //echo '<br/>2 genap';
      } else {
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        $mk_thn=$mk_thn+2;
        //echo '<br/>2 ganjil';
      }
      //echo '<br/>golru 2 : '.$fidgolru;
    } else {
      if (!($mk_thn%2)) {
        // cek gaji disini    
        //$tmt_thn++;
        $tmt_thn=$tmt_thn+1;
        $mk_thn=$mk_thn+2;
        //echo '<br/>134 genap';
      } else {
        //$tmt_thn++;
        //$tmt_thn=$tmt_thn+1;
        //$mk_thn++;
        $mk_thn=$mk_thn+1;
        //echo '<br/>134 ganjil';
      }
      //echo '<br/>golru 134 : '.$fidgolru;
    }       
    
    // diperlukan nama pangkat untuk query pada tabel ref_gaji
    $namagolru = $this->mpegawai->getnamagolru($fidgolru);

    // jika pangkat mentok golru I/a maksimal MK_thn 27 tahun
    if (($mk_thn >= 26) AND ($fidgolru == '11')) {
      $mk_thn = 27;
    // jika pangkat mentok golru III/a keatas maksimal MK_thn 32 tahun
    } else if (($mk_thn >= 32) AND ($fidgolru >= '31')) {
      $mk_thn = 32;
    // jika pangkat mentok golru I/b sampai I/d maksimal MK_thn 27 tahun
    } else if (($mk_thn >= 27) AND (($fidgolru >= '12') AND ($fidgolru <= '14'))) {
      $mk_thn = 27;    
    } else if (($mk_thn >= 33) AND (($fidgolru >= '21') AND ($fidgolru <= '24'))) {
      $mk_thn = 33;
    }

    $gaji = $this->mkgb->getgaji($namagolru, $mk_thn);

    //$tmt = $tmt_thn."-".$tmt_bln."-01";
    //$ket = "Rp. ".indorupiah($gaji).",-<br/>MK Gol : ".$mk_thn." Tahun ".$mk_bln." Bulan<br /><h5><span class='label label-warning'>TMT : ".tgl_indo($tmt)."</span></h5>";

    $thnini = date('Y');
    $blnini = date('m');

    //$saatini = $blnini." ".$thnini;
    //$berikutnya = $tmt_bln." ".$tmt_thn;


    if (($tmt_thn < $thnini) OR (($tmt_thn == $thnini) AND ($tmt_bln == $blnini))) {
    //if ($saatini == $berikutnya) {
      $warnalabel = 'label label-danger';
    } else if (($tmt_thn == $thnini) AND (($tmt_bln == $blnini+1) OR ($tmt_bln == $blnini+2))) {
      $warnalabel = 'label label-warning';
    } else {
      $warnalabel = 'label label-success';
    }

    $ket = "Rp. ".indorupiah($gaji).",-<br/>MK Gol : ".$mk_thn." Tahun ".$mk_bln." Bulan<br />
    <h5><span class='".$warnalabel."'>TMT : 01 ".bulan($tmt_bln)." ".$tmt_thn."</span></h5>";

    

    return $ket;
  }

  function tampilbukujaga() {
      $idunker = $this->input->get('idunker');
      $thn = $this->input->get('thn');

      $sqlcari = $this->munker->pegperunker($idunker)->result_array();
      $jml = count($this->munker->pegperunker($idunker)->result_array());

      if ($jml != 0) {
        echo '<br/>';
        echo '<table class="table table-condensed table-hover">';
        echo "<tr class='info'>
        <td align='center'><b>No</b></td>
        <td align='center' width='220'><b>NIP | Nama</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center' width='80'><b>SK Acuan<br/>GaPok<br /></b></td>
        <td align='center' width='200'><b>Data Gaji Pokok Terakhir</td>
        <td align='center' width='220'><b>KGB<br />Berikutnya</b></td>
        <td align='center' width='250'><b>Status</b></td>
        </tr>";

        $no = 1;
        foreach($sqlcari as $v) :          
          echo "<tr><td align='center'>".$no."</td>";
          echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';

          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }            

          echo '<td>',$this->mpegawai->namajab($v['fid_jnsjab'],$idjab),'</td>';
          echo '<td align=center>',$this->mkgb->gettmtterakhir($v['nip']),'</td>';
                    //echo '<td colspan=2>',$this->mkgb->getgajiterakhir($v['nip']),'</td>';

          $tmtakhir = $this->mkgb->gettmtterakhir($v['nip']);


          if ($tmtakhir == 'SK KP') {
            $sqlgaji = $this->mkgb->getgajiterakhir($v['nip'], $tmtakhir)->result_array();
            foreach($sqlgaji as $g) :
              echo "<td>";
            echo "Rp. ".indorupiah($g['gapok']).",- pada Golru ".$this->mpegawai->getnamagolru($g['fid_golru'])."<br/>MK Gol : ".$g['mkgol_thn']." Tahun ".$g['mkgol_bln']." Bulan<br />TMT : ".tgl_indo($g['tmt']);
            echo "</td>";
            echo "<td>".$this->getgajiberikutnya($g['fid_golru'], $g['mkgol_thn'], $g['mkgol_bln'], $g['tmt'])."</td>";
            endforeach;
          } else if ($tmtakhir == 'SK CPNS') {
            $sqlgaji = $this->mkgb->getgajiterakhir($v['nip'], $tmtakhir)->result_array();
            foreach($sqlgaji as $g) :
              echo "<td>";
            echo "Rp. ".indorupiah($g['gapok_cpns']).",- pada Golru ".$this->mpegawai->getnamagolru($g['fid_golru_cpns'])."<br/>MK Gol : ".$g['mkthn_cpns']." Tahun ".$g['mkbln_cpns']." Bulan<br />TMT : ".tgl_indo($g['tmt_cpns']);
            echo "</td>";
            echo "<td>".$this->getgajiberikutnya($g['fid_golru_cpns'], $g['mkthn_cpns'], $g['mkbln_cpns'], $g['tmt_cpns'])."</td>";
            endforeach;
          } else if ($tmtakhir == 'SK KGB') {
            $sqlgaji = $this->mkgb->getgajiterakhir($v['nip'], $tmtakhir)->result_array();
            foreach($sqlgaji as $g) :
              echo "<td>";
            echo "Rp. ".indorupiah($g['gapok']).",- pada Golru ".$this->mpegawai->getnamagolru($g['fid_golru'])."<br/>MK Gol : ".$g['mk_thn']." Tahun ".$g['mk_bln']." Bulan<br />TMT : ".tgl_indo($g['tmt']);
            echo "</td>";
            echo "<td>".$this->getgajiberikutnya($g['fid_golru'], $g['mk_thn'], $g['mk_bln'], $g['tmt'])."</td>";
            endforeach;
          }


          //echo "<td>Rp. ".indorupiah($gapok).",- pada Golru ".$this->mpegawai->getnamagolru($fid_golru)."<br/>MK Gol : ".$mkgol_thn." Tahun ".$mkgol_bln." Bulan<br />TMT : ".tgl_indo($tmt)."</td>";
          //echo "<td>".$v['nip']."</td>";


          $sqlpernahusul = $this->mkgb->cektelahusul($v['nip'], date('Y'));
          $ket_usul = $this->mkgb->getdatapernahusul($v['nip'], date('Y'));
          if ($sqlpernahusul) {
            echo "<td><h5><span class='label label-info'>SEDANG DIUSULKAN</span></h5>".$ket_usul."</td>";
          } else {
            echo '<td></td>';              
          }         

          $no++;        
        endforeach;
      }
  }

  function selesaikankgb_aksi() {
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    
    $id_cetaksk = '7'; // id status CETAKSK
    $id_btl = '5'; // id status BTL
    $id_tms = '6'; // id status TMS
    $id_pengantarbkppd = '3'; // id status BKPPD (Pengantar)

    $id_selesaisetuju = '8'; // id status SELESAISETUJU
    $id_selesaibtl = '9'; // id status SELESAIBTL
    $id_selesaitms = '10'; // id status SELESAITMS
    $id_pengantarselesai = '4'; // id status SELESAI (Pengantar)

    $tgl_selesai = $this->mlogin->datetime_saatini();

    $datasetuju = array(      
      'fid_status'      => $id_selesaisetuju,
      'tgl_status_selesai' => $tgl_selesai
      );

    $databtl = array(      
      'fid_status'      => $id_selesaibtl,
      'tgl_status_selesai' => $tgl_selesai
      );

    $datatms = array(      
      'fid_status'      => $id_selesaitms,
      'tgl_status_selesai' => $tgl_selesai
      );

    $datapengantar = array(      
      'fid_status'      => $id_pengantarselesai
      );

    $wheresetuju = array(
      'fid_pengantar'   => $id_pengantar,
      'fid_status'      => $id_cetaksk
    );

    $wherebtl = array(
      'fid_pengantar'   => $id_pengantar,
      'fid_status'      => $id_btl
    );

    $wheretms = array(
      'fid_pengantar'   => $id_pengantar,
      'fid_status'      => $id_tms
    );

    $wherepengantar = array(
      'id_pengantar'   => $id_pengantar,
      'fid_status'      => $id_pengantarbkppd
    );
    
    if (($this->mkgb->edit_pengantar($wherepengantar, $datapengantar)) AND ($this->mkgb->edit_usul($wheresetuju, $datasetuju)) AND ($this->mkgb->edit_usul($wherebtl, $databtl)) AND ($this->mkgb->edit_usul($wheretms, $datatms))) {

        // input riwayat cuti
        $fid_status_selesai = '8'; // SELESAISETUJU -> yang berstatus SELESAISETUJU yang akan ditambahkan ke riwayat_cuti
        if ($this->mkgb->input_riwayatkgb($id_pengantar, $fid_status_selesai)) {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
          $data['pesan'] = '<b>Sukses</b>, Usul KGB No. Pengantar '.$this->mkgb->getnopengantar($id_pengantar).' Tanggal '.$this->mkgb->gettglpengantar($id_pengantar).' berhasil diselesaikan.';
          $data['jnspesan'] = 'alert alert-success';
        }        
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul KGB No. Pengantar '.$this->mkgb->getnopengantar($id_pengantar).' Tanggal '.$this->mkgb->gettglpengantar($id_pengantar).' gagal diselesaikan.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('proseskgb_priv') == "Y") { 
      $data['kgb'] = $this->mkgb->tampilproses()->result_array();   
      $data['content'] = 'kgb/tampilproses';
      $this->load->view('template',$data);
    }
  }

  function showSKAkhir() {
    $nip = $this->input->get('nip');
    $skakhir = $this->mkgb->gettmtterakhir($nip);

    echo '<select name="id_berkas" id="id_berkas" onChange="" required />';
    //echo "<option value=''>- Pilih Dokumen Gaji Terakhir -</option>";
    if ($skakhir == 'SK KP') {
      echo "<option value='SKCPNS' disabled>SK CPNS (Untuk KGB Pertama)</option>";
      echo "<option value='SKKP'>SK Pangkat Terakhir</option>";
      echo "<option value='SKKGB' disabled>SK KGB Terakhir</option>";
    } else if ($skakhir == 'SK CPNS') {
      echo "<option value='SKCPNS'>SK CPNS (Untuk KGB Pertama)</option>";
      echo "<option value='SKKP' disabled>SK Pangkat Terakhir</option>";
      echo "<option value='SKKGB' disabled>SK KGB Terakhir</option>";
    } else if ($skakhir == 'SK KGB') {
      echo "<option value='SKCPNS' disabled>SK CPNS (Untuk KGB Pertama)</option>";
      echo "<option value='SKKP' disabled>SK Pangkat Terakhir</option>";
      echo "<option value='SKKGB'>SK KGB Terakhir</option>";
    }

    echo '</select>&nbsp&nbsp';

    echo "<button type='button' class='btn btn-warning btn-sm' onClick='showDataKGB(formtambahusul.id_berkas.value, formtambahusul.nip.value)'>";
    echo "<span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>&nbsp&nbspTampilkan Data Gaji Terakhir</button><br/>";

    echo "<small id='berkasHelpInline' class='text-muted'>Sesuai data riwayat pada database, SK terakhir yang menjadi dasar perhitungan gaji saat ini adalah <b>".$skakhir."</b>.<br />Hubungi Tim Teknis BKPPD jika terdapat kekeliruan atau tidak sesuai dengan dokumen kepegawaian yang dimiliki.</small>";

  }

  function statistika()
    {
      if ($this->session->userdata('proseskgb_priv') == "Y") { 
        $data['grafik'] = $this->mkgb->getjmlprosesbystatusgraphkgb();
        $data['thnkgb'] = $this->mkgb->gettahunrwykgb()->result_array(); 
        $data['rwyperbulan'] = $this->mkgb->getjmlrwyperbulan(); 
        $data['content'] = 'kgb/statistika';
        $this->load->view('template',$data);
      }
    } 

      // START KHUSUS ADMIN, Update Pengatar dan Usul Kgb
  function admin_tampilupdatepengantar()
  {
    if ($this->session->userdata('level') == "ADMIN") { 
      $data['kgb'] = $this->mkgb->admin_tampilupdatepengantar()->result_array();      
      $data['pesan'] = '';    
      $data['jnspesan'] = '';
      $data['content'] = 'kgb/admin_tampilupdatepengantar';
      $this->load->view('template',$data);
    }
  }

  function admin_tampilupdateusul()
    {
      if ($this->session->userdata('level') == "ADMIN") {    
        $data['pesan'] = '';    
        $data['jnspesan'] = '';
        $data['content'] = 'kgb/admin_tampilupdateusul';
        $this->load->view('template',$data);
      }
    }

  function admin_updatepengantar()
    {
      if ($this->session->userdata('level') == "ADMIN") { 
        $id = $this->input->post('id_pengantar');
        $tgl = $this->input->post('tgl_pengantar');   
        $data['pengantar'] = $this->mkgb->admin_detailpengantar($id, $tgl)->result_array();
        $data['statuspengantar'] = $this->mkgb->statuspengantar()->result_array();
        $data['id_pengantar'] = $id;
        //$data['cuti'] = $this->mcuti->detailusul($nip, $idpengantar, $thn_cuti, $fid_jns_cuti)->result_array();
        //$data['jnscuti'] = $this->mcuti->jnscuti()->result_array();
        $data['content'] = 'kgb/admin_updatepengantar';
        $this->load->view('template', $data);
      }
    }

  function admin_updatepengantar_aksi() {
    $id_pengantar = addslashes($this->input->post('id_pengantar'));
    $nopengantar = $this->input->post('nopengantar');
    $tglpengantar = tgl_sql($this->input->post('tglpengantar'));
    $id_status = $this->input->post('id_status');

    $data = array(
      'no_pengantar'    => $nopengantar,
      'tgl_pengantar'   => $tglpengantar,            
      'fid_status'      => $id_status
      );

    $where = array(
      'id_pengantar'   => $id_pengantar,
    );

    $nope = $this->mkgb->getnopengantar($id_pengantar);

    if ($this->mkgb->edit_pengantar($where, $data))
    {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Pengantar KGB Nomor <u>'.$nope.'</u> berhasil update status.';
        $data['jnspesan'] = 'alert alert-success';
    } else {
        $data['pesan'] = '<b>Gagal !</b>, Pengantar KGB Nomor <u>'.$nope.'</u> gagal update status.';
        $data['jnspesan'] = 'alert alert-danger';
    }

    if ($this->session->userdata('level') == "ADMIN") { 
        $data['kgb'] = $this->mkgb->admin_tampilupdatepengantar()->result_array();      
        $data['content'] = 'kgb/admin_tampilupdatepengantar';
        $this->load->view('template',$data);
    }
  }

  function cariupdateusul() {
    $nip = $this->input->get('nip');    // kalau menggunakan metode post untuk ajax

    $sqlcari = $this->mkgb->cariupdateusul($nip)->result_array();
    $jml = count($this->mkgb->cariupdateusul($nip)->result_array());

    $nama = $this->mpegawai->getnama($nip);
    
    $lokasifile = './photo/';
    $filename = "$nip.jpg";
    if (file_exists ($lokasifile.$filename)) {
      $photo = "../photo/$nip.jpg";
                     //$photo = "ftp://192.168.1.4/photo/$v[nip].jpg";
    } else {
      $photo = "../photo/nophoto.jpg";
                    //echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'>";
                    //echo "<img src='../photo/nophoto.jpg' width='60' height='80' alt='no image'";
    }

    echo "<div align='center'>";
    echo '<table class="table table-condensed" style="width: 40%;">';
    echo "<tr>
            <td rowspan='3' align='center' width='80'>
            <img src='$photo' width='90' height='120' class='img-thumbnail'>
            </td>
            <td>$nama</td></tr>
          <tr>          
          <td>";
    echo $this->mpegawai->namajabnip($nip);
    echo "</td>
          <tr>
          <td>";
    echo $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
   
    if ($jml == 0) {
      echo "<br /><div class='alert alert-danger' role='alert'>";
      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
      echo "Usul KGB NIP. ".$nip." <b>tidak ditemukan</b>";
      echo "</div>";
    } else {
      echo '<br/>';
      echo '<table class="table table-condensed table-hover">';
      echo "<tr class='success'>
            <td align='center' width='40' rowspan='2'><b>No</b></td>      
            <td align='center' colspan='4'><b>Gaji Pokok Terakhir</b></td>      
            <td align='center' rowspan='2' width='200'><b>Entri Usul</b></td>
            <td align='center' rowspan='2' width='140'><b>Status</b></td>
            <td align='center' rowspan='2' width='140'><b>Aksi</b></td>
             </tr>
            <tr class='success'>
              <td align='center' width='100'><b>Gaji Pokok</b></td>
              <td align='center' width='80'><b>Dlm Golru</b></td>
              <td align='center' width='150'><b>Maker</b></td>
              <td align='center' width='120'><b>TMT</b></td>
            </tr>";

      $no = 1;
      foreach($sqlcari as $v):          
        echo "<td align='center'>".$no."</td>";
        //echo '<td>',$v['nip'], '<br />', namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']),'</td>';

        if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
        }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
        }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
        }

        ?>        
        <td align='center'><?php echo 'Rp. ',indorupiah($v['gapok_lama']); ?></td>
        <td align='center'><?php echo $this->mpegawai->getnamagolru($v['fid_golru_lama']); ?></td>
        <td align='center'><?php echo $v['mk_thn_lama'].' Tahun, '.$v['mk_bln_lama'].' Bulan'; ?></td>
        <td align='center'><?php echo tgl_indo($v['tmt_gaji_lama']); ?></td>
        <td align='center'><?php echo tglwaktu_indo($v['tgl_usul']); ?></td>
        <?php 

        $status = $this->mkgb->getstatuskgb($v['fid_status']);
        echo "<td align='center'>";
        if ($status == 'INBOXSKPD') {          
          echo "<h5><span class='label label-default'>Inbox SKPD</span></h5>";
        } else if ($status == 'CETAKUSUL') {
          echo "<h5><span class='label label-default'>Cetak Usul</span></h5>";
        } else if ($status == 'INBOXBKPPD') {          
          echo "<h5><span class='label label-default'>Inbox BKPPD</span></h5>";
        } else if ($status == 'BTL') {
          echo "<h5><span class='label label-warning'>B T L</span></h5>";
        } else if ($status == 'TMS') {
          echo "<h5><span class='label label-danger'>T M S</span></h5>";
        } else if ($status == 'SETUJU') {
          echo "<h5><span class='label label-success'>Setuju</span></h5>";
        } else if ($status == 'CETAKSK') {
          echo "<h5><span class='label label-default'>Cetak SK</span></h5>";
        } else if ($status == 'SELESAISETUJU') {
          echo "<h5><span class='label label-success'>Selesai Setuju</span></h5>";
        } else if ($status == 'SELESAIBTL') {
          echo "<h5><span class='label label-success'>Selesai BTL</span></h5>";
        } else if ($status == 'SELESAITMS') {
          echo "<h5><span class='label label-success'>Selesai TMS</span></h5>";
        }
        echo "</td>";

        echo "<td align='center'>";
        echo "<form method='POST' action='".base_url()."kgb/admin_updateusul'>";          
        echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[fid_pengantar]'>";
        echo "<input type='hidden' name='tmt_gaji_lama' id='tmt_gaji_lama' value='$v[tmt_gaji_lama]'>"; 

        echo "<button type='submit' class='btn btn-warning btn-xs'>";
        echo "<span class='glyphicon glyphicon-new-window' aria-hidden='true'></span><br />Update Usul";
        echo "</button>";
        echo "</form>";
        echo '</td>';        
        echo "</tr>";

        $no++;
      endforeach;
    }
  }

    function admin_updateusul() {
      $nip = $this->input->post('nip');    
      $tmt_lama = $this->input->post('tmt_gaji_lama');
      $idpengantar = $this->input->post('id_pengantar');      

      $data['nopengantar'] = $this->mkgb->getnopengantar($idpengantar);
      $data['nama'] = $this->mpegawai->getnama($nip);
      $data['tglpengantar'] = $this->mkgb->gettglpengantar($idpengantar);
      $tgl_pengantar = $this->mkgb->gettglpengantar($idpengantar);
      $data['nip'] = $nip;
      $data['fid_pengantar'] = $idpengantar;
      
      $data['statuskgb'] = $this->mkgb->statuskgb()->result_array();
      $data['kgb'] = $this->mkgb->admin_detailusul($nip, $tmt_lama, $idpengantar)->result_array();  
      $data['content'] = 'kgb/admin_updateusul';   
      $this->load->view('template', $data); 
    }

   function admin_updateusul_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $id_pengantar = $this->input->post('fid_pengantar');
   
    $gapoklama = addslashes($this->input->post('gapoklama'));
    $tmtgajilama = addslashes($this->input->post('tmtgajilama'));
    $mkthnlama = addslashes($this->input->post('mkthnlama'));
    $mkblnlama = addslashes($this->input->post('mkblnlama'));
    $fid_golru_lama = addslashes($this->input->post('fid_golru_lama'));
    $nosklama = addslashes($this->input->post('nosklama'));
    $tglsklama = addslashes($this->input->post('tglsklama'));
    $pjblama = addslashes($this->input->post('pjblama'));
    $gapokbaru = addslashes($this->input->post('gapokbaru'));
    $tmtgajibaru = addslashes($this->input->post('tmtgajibaru'));
    $mkthnbaru = addslashes($this->input->post('mkthnbaru'));
    $mkblnbaru = addslashes($this->input->post('mkblnbaru'));
    $fid_golru_baru = addslashes($this->input->post('fid_golru_baru'));
    $tmtberikutnya = addslashes($this->input->post('tmtberikutnya'));
    $id_statusul = addslashes($this->input->post('id_statusul'));

    $nama = $this->mpegawai->getnama($nip);

    if ($gapoklama == '') $gapoklama = '0';
    if ($mkthnlama == '') $mkthnlama = '0';
    if ($mkblnlama == '') $mkblnlama = '0';
    if ($gapokbaru == '') $gapokbaru = '0';
    if ($mkthnbaru == '') $mkthnbaru = '0';
    if ($mkblnbaru == '') $mkblnbaru = '0';

    if ($tmtgajilama == '') { $tmtgajilama = null; } else { $tmtgajilama = tgl_sql($tmtgajilama); }
    if ($tglsklama == '') { $tglsklama = null; } else { $tglsklama = tgl_sql($tglsklama); }
    if (($tmtgajibaru == '00-00-0000') || ($tmtgajibaru == '')) { $tmtgajibaru = null; } else { $tmtgajibaru = tgl_sql($tmtgajibaru); }
    if ($tmtberikutnya == '') { $tmtberikutnya = null; } else { $tmtberikutnya = tgl_sql($tmtberikutnya); }



    $data = array(      
      'gapok_lama'      => $gapoklama,
      'tmt_gaji_lama'   => $tmtgajilama,
      'mk_thn_lama'     => $mkthnlama,
      'mk_bln_lama'     => $mkblnlama,
      'fid_golru_lama' => $fid_golru_lama,
      'sk_lama_no'      => $nosklama,
      'sk_lama_tgl'     => $tglsklama,
      'sk_lama_pejabat' => $pjblama,
      'gapok_baru'      => $gapokbaru,
      'tmt_gaji_baru'  => $tmtgajibaru,
      'mk_thn_baru'     => $mkthnbaru,
      'mk_bln_baru'    => $mkblnbaru,
      'fid_golru_baru'  => $fid_golru_baru,
      'tmt_gaji_berikutnya'  => $tmtberikutnya,
      'fid_status'      => $id_statusul
      );

    $where = array(
      'nip'               => $nip,
      'fid_pengantar'     => $id_pengantar
    );

    if ($this->mkgb->edit_usul($where, $data))
      {
        // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
        $data['pesan'] = '<b>Sukses</b>, Usul KGB <u>'.$nama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Usul KGB <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $data['content'] = 'kgb/admin_tampilupdateusul'; 
    $this->load->view('template', $data);
  }

  // END KHUSUS ADMIN, Update Pengatar dan Usul Kgb
  
}
