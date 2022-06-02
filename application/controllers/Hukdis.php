<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hukdis extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('mpegawai');      
      $this->load->model('mhukdis');      
      $this->load->model('mkgb');
      $this->load->model('mstatistik');
      $this->load->model('munker');
      $this->load->model('datacetak');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }

      // Load Class fpdf
      $this->load->library('fpdf');

    }

  public function index()
	{	  
	}

  /*function detail()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $data['peg'] = $this->mpegawai->detail($nip)->result_array();
      $data['content'] = 'pegdetail';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }
  
  function carinipnama()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $datacnp['content'] = 'hukdis/carinipnama';
      $this->load->view('template',$datacnp);
    }
  }

  function tampilnipnama()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      //$data = mysql_real_escape_string(trim($this->input->post('data')));
      $data = trim($this->input->post('data'));
    	if ($data != '') {
    		// nip dan nama akan dicari pada instansi sesuai kewenangan user yang login
    		$datatnp['pegtnp'] = $this->mpegawai->getnipnama($data)->result_array();
    		$datatnp['jmldata'] = count($this->mpegawai->getnipnama($data)->result_array());
    		$datatnp['content'] = 'hukdis/tampilnipnama';
    	      	$this->load->view('template', $datatnp);
    	} else {
    		$this->session->set_flashdata('pesan', '<b>Pencarian data gagal</b><br />Ketik NIP atau Nama terlebih dahulu');
    		redirect('pegawai/carinipnama');
    	}
    }
  }

  */

  function tampilusulhukdis()
  {    
    $data['usulhd'] = $this->mhukdis->tampilusulhd()->result_array();
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
    $data['content'] = 'hukdis/tampilusulhd';
    $this->load->view('template', $data);
  }

  function showtambahhukdis() {
    //$nip = $this->input->post('nip'); // jika menggunakan metode post pada ajax
    $nip = $this->input->get('nip'); 
    ?>

    <div class="panel panel-info" style='width :850px'>
      <!-- Default panel contents -->
      
      <div class="panel-heading" align='center'><b>TAMBAH USUL HUKUMAN DISIPLIN</b></div>      
        <br />
        <div align='right' style='width :99%'>
          <form method='POST' action='../hukdis/tampilusulhukdis'>
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="submit" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspBatal&nbsp&nbsp&nbsp
            </button>&nbsp
          </form>
        </div>
      <form method='POST' name='fusulhukdis' action='../hukdis/tambahhukdis_aksi'>
      <table class="table table-condensed table-hover">
        <tr>
        <td align='right'>NIP :</td>
        <td><input type="text" name="nip" id="nip" size='25' placeholder="Ketik NIP lengkap tanpa spasi" maxlength='18' onChange="showIsitambahhd(this.value, fusulhukdis.jnshukdis.value)" required /></td>
        </tr>        
        <tr>
          <td align='right' width='150'>Jenis Hukdis :</td>
          <td colspan='3'>
          <select name="jnshukdis" id="jnshukdis" onChange="showIsitambahhd(fusulhukdis.nip.value, this.value)" required />
          <option value='' selected>-- Pilih Jenis Hukdis --</option>
            <?php
              $jnshukdis = $this->mhukdis->jnshukdis()->result_array();
              foreach($jnshukdis as $hd)
              {
                // SKPD hnya diber wewenang entri data hukdis tingkat RINGAN
                if (($this->session->userdata('edit_profil_priv') == "Y") AND (($this->session->userdata('level') == "USER"))) {
                  if ($hd['tingkat'] == 'RINGAN') {
                    echo "<option value='".$hd['id_jenis_hukdis']."'>".$hd['tingkat']." - ".$hd['nama_jenis_hukdis']."</option>";
                  } else {
                    echo "<option value='".$hd['id_jenis_hukdis']."' disabled>".$hd['tingkat']." - ".$hd['nama_jenis_hukdis']."</option>";
                  }
                } else if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198705242010012015")) {
                  echo "<option value='".$hd['id_jenis_hukdis']."'>".$hd['tingkat']." - ".$hd['nama_jenis_hukdis']."</option>";
                }                
                  
              }
            ?>
          </select></td>
        </tr>
        <tr>
        <td align='center' colspan='4'>
          <div id='tampilisi'></div>
        </td>
        </tr>        
      </table>
    <?php
  }

  function showIsitambahhd() {
    $nip = $this->input->get('nip');
    $idhukdis = $this->input->get('id'); 
    
    // cek apakah NIP dalam kewenangan
    $ceknip = $this->mhukdis->ceknip($nip);
    if (($nip == '') OR ($idhukdis == '')) {
        echo "<br /><div class='alert alert-info' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        echo "<b>Silahkan...</b> Pilih NIP dan Jenis Hukuman Disiplin";
        echo "</div>";
    } else if ($ceknip == 0) {
      echo "<br /><div class='alert alert-danger' role='alert'>";
        echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        echo "NIP. ".$nip." <b>tidak ditemukan</b>, atau diluar kewenangan Anda";
        echo "</div>";
    } else 
    if (($nip != '') AND ($idhukdis != '')) {
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

      echo "<div align='left'>";
      echo '<table class="table table-condensed " style="width: 100%;">';
      echo "<tr class='info'>
              <td rowspan='3' align='center' width='80'>
              <img src='$photo' width='90' height='120' class='img-thumbnail'>
              </td>
              <td>$nama</td></tr>
            <tr class='info'>          
            <td>";
      echo $this->mpegawai->namajabnip($nip);
      echo "</td>
            <tr class='info'>
            <td>";
      echo $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</div>";
      ?>

      <table class="table table-condensed table-hover">        
        <tr>
          <?php
          // Kasus ketidakhadiran khusus untuk Teguran Lisan
          if ($idhukdis == '01') {
          ?>
            <td align='right'>Kasus Ketidakhadiran :</td>
            <td colspan='3'>
            <select name="tdkhadir" id="tdkhadir" required >
              <option value='' selected>-- Kasus Ketidakhadiran --</option>
              <option value='YA'>YA</option>
              <option value='TIDAK'>TIDAK</option>
            </select>
            <small>Pilih YA, jika kasus yang dilaporkan berkaitan dengan KETIDAKHADIRAN</small>
            </td>
          <?php
          }
          ?>
        </tr>
        <tr class='success'>
          <td align='right'>Panggilan I :</td>
          <td colspan='3'>
            <table class="table table-condensed">
            <tr>
              <td align='right' width='20%'>No. Surat :</td>
              <td colspan='3'><input type="text" name="nopanggil1" size='40' maxlength='50' required />
            <tr></td>
            </tr>        
              <td align='right'>Tgl. Surat :</td>
              <td colspan='3'><input type="text" name="tglpanggil1" class="tanggal" size='15' maxlength='10' required />
                <small>dd-mm-yyyy</small>
              </td>
            </tr>
            <tr>
              <td align='right'>Tgl. Pemeriksaan I :</td>
              <td colspan='3'><input type="text" name="tglperiksa1" class="tanggal" size='15' maxlength='10' required />
                <small>dd-mm-yyyy</small>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        <!-- Panggilan ke II tidak required -->
        <tr class='warning'>
          <td align='right'>Panggilan II :</td>
          <td colspan='3'>
            <table class="table table-condensed">
            <tr>
              <td align='right' width='20%'>No. Surat :</td>
              <td colspan='3'><input type="text" name="nopanggil2" size='40' maxlength='50' /></td>
            </tr>        
            <tr>
              <td align='right'>Tgl. Surat :</td>
              <td colspan='3'><input type="text" name="tglpanggil2" class="tanggal" size='15' maxlength='10' />
                <small>dd-mm-yyyy</small>
              </td>
            </tr>
            <tr>
              <td align='right'>Tgl. Pemeriksaan II :</td>
              <td colspan='3'><input type="text" name="tglperiksa2" class="tanggal" size='15' maxlength='10' />
                <small>dd-mm-yyyy</small>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align='right'>TMT Hukuman :</td>
          <td><input type="text" name="tmthukdis" class="tanggal" size='15' maxlength='10' required />
            <small>dd-mm-yyyy</small></td>
            <?php
            // input akhir hukuman jika : Penundaan KGB, Penundaan KP, Penurunan KP 1 Tingkat 1 Tahun, Penurunan KP 1 Tingkat 3 Tahun
            if (($idhukdis == '04') OR ($idhukdis == '06') OR ($idhukdis == '07') OR ($idhukdis == '08')) {
            ?>        
            <td align='right' width='150'>Akhir Hukuman :</td>
            <td><input type="text" name="akhirhukdis" class="tanggal" size='15' maxlength='10' required />
              <small>dd-mm-yyyy</small></td>
            <?php
            }
            // input gaji dan TMT Gaji jika : Penundaan KGB atau Penurunan Gaji
            if ($idhukdis == '04') {
              $acuangaji = $this->mkgb->gettmtterakhir($nip);
              $gaji = $this->mhukdis->getnilaigajiterakhir($nip, $acuangaji);
              $tmtgaji = $this->mhukdis->gettmtgajiterakhir($nip, $acuangaji);            
              ?>
              </tr>
              <tr class='warning'>        
              <td align='right' width='150'>Gaji Saat Ini :</td>
              <td><input type="text" name="gaji" value='<?php echo $gaji; ?>' size='15' maxlength='8' required />
                <small>Tulis angka tanpa titik</small></td>
              <td align='right' width='150'>TMT Gaji Saat Ini :</td>
              <td><input type="text" name="tmtgaji" value='<?php echo tgl_sql($tmtgaji); ?>' class="tanggal" size='15' maxlength='10' required />
                <small>dd-mm-yyyy</small></td>
              </tr>
              <?php
            }

            // input golru dan TMT golru jika : Penundaan KP, Penurunan KP 1 Tingkat 1 Tahun, Penurunan KP 1 Tingkat 3 Tahun
            if (($idhukdis == '06') OR ($idhukdis == '07') OR ($idhukdis == '08')) {             
              $idgolru = $this->mhukdis->getidgolruterakhir($nip);
              $tmtgolru = $this->mhukdis->gettmtgolruterakhir($nip);
              ?>
              <tr class='warning'>        
              <td align='right' width='150'>Pangkat Saat Ini :</td>
              <td>
              <select name="idgolru" id="idgolru" required >
                <?php
                  $golru = $this->mpegawai->golru()->result_array();
                  foreach($golru as $gl)
                  {
                    if ($gl['id_golru'] == $idgolru) {
                      echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_pangkat']." (".$gl['nama_golru'].")</option>";
                    } else {
                      echo "<option value='".$gl['id_golru']."'>".$gl['nama_pangkat']." (".$gl['nama_golru'].")</option>";
                    }
                  }
                ?>
              </select>
              </td>
              <td align='right' width='150'>TMT Pangkat Saat Ini :</td>
              <td><input type="text" name="tmtgolru" value='<?php echo tgl_sql($tmtgolru); ?>' class="tanggal" size='15' maxlength='10' required />
                <small>dd-mm-yyyy</small></td>
              </tr>            
              <?php
            }

            // input Jabatan dan TMT Jabatan jika : Pemindahan dalam rangka penurunan jabatan atau Pembebasan Jabatan
            if (($idhukdis == '09') OR ($idhukdis == '10')) {
              $jabatan = $this->mpegawai->namajabnip($nip);          
              $unker = $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
              $tmtjabatan = $this->mpegawai->gettmtjabterakhir($nip);          
              ?>
              <tr class='warning'>        
              <td align='right' width='150'>Jabatan Saat Ini :</td>
              <td>
                <div>
                  <textarea class="form-control rounded-0" width='200' name="jabatan" id="jabatan" rows="2" required><?php echo $jabatan,' PADA ',$unker; ?></textarea>
                  <small>Tulis nama JABATAN serta UNIT KERJA dengan lengkap</small>
                </div>
              </td>
              </tr>
              <tr class='warning'>  
              <td align='right' width='150'>TMT Jabatan Saat Ini :</td>
              <td><input type="text" name="tmtjabatan" value='<?php echo tgl_sql($tmtjabatan); ?>' class="tanggal" size='15' maxlength='10' required />
                <small>dd-mm-yyyy</small></td>
              </tr>
              <?php
            }
            ?>
          </tr>
            <tr class='warning'>
              <?php
              // input akhir hukuman jika : Penundaan KGB, Penundaan KP, Penurunan KP 1 Tingkat 1 Tahun, Penurunan KP 1 Tingkat 3 Tahun
              if (($idhukdis == '04') OR ($idhukdis == '06') OR ($idhukdis == '07') OR ($idhukdis == '08')) {
              ?>
                <td align='right'>Lama Hukuman (Thn) :</td>
                <td><input type="text" name="lamathn" size='4' maxlength='2' onkeyup="validAngka(this)" required /></td>
                <td align='right'>Lama Hukuman (Bln) :</td>
                <td><input type="text" name="lamabln" size='4' maxlength='2' onkeyup="validAngka(this)" required /></td>
              <?php
              } 
              ?>
            </tr>        
            <tr>
              <td align='right'>Deskripsi Kesalahan :</td>
              <td colspan='3'>
                <div class="form-group">
                  <textarea class="form-control rounded-0" name="deskripsi" id="deskripsi" maxlength="140" rows="2"></textarea>
                </div>
              </td>
            </tr>
            <tr>
              <td align='right'>Peraturan terkait :</td>
              <td colspan='3'>
                <select name="peruu" id="peruu" required >
                <option value='0'>-- Pilih PerUU yang Dilanggar --</option>
                <?php
                  $peruu = $this->mhukdis->peruu()->result_array();
                  foreach($peruu as $uu)
                  {
                    echo "<option value='".$uu['id_peruu_hukdis']."'>".$uu['nama_peruu_hukdis']."</option>";
                  }
                ?>
              </select>
              </td>
            </tr>
            <tr>
              <td align='right'>Pejabat YBW :</td>
              <td colspan='3'>
              <select name="nip_pejabat" id="nip_pejabat" required >
                <option value='0' selected>-- Pilih pejabat yang berwenang --</option>
                <?php
                  $atasan = $this->mhukdis->getatasan()->result_array();
                  foreach($atasan as $at)
                  {
                    echo "<option value='".$at['nip']."'>".$at['gelar_depan']." ".$at['nama']." ".$at['gelar_belakang']." - NIP. ".$at['nip']."</option>";
                  }
                ?>
              </select>
              </td>
            </tr>        
            <tr>
              <td align='right'>No. SK :</td>
              <td colspan='3'><input type="text" name="nosk" size='40' maxlength='50' required /></td>
            </tr>        
            <tr>
              <td align='right'>Tgl. SK :</td>
              <td colspan='3'><input type="text" name="tglsk" class="tanggal" size='15' maxlength='10' required />
                <small>dd-mm-yyyy</small></td>
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
  }

  function tambahhukdis_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $jnshukdis = addslashes($this->input->post('jnshukdis'));
    $tmthukdis = tgl_sql($this->input->post('tmthukdis'));
    
    $tdkhadir = addslashes($this->input->post('tdkhadir'));
    $nopanggil1 = addslashes($this->input->post('nopanggil1'));
    $tglpanggil1 = tgl_sql($this->input->post('tglpanggil1'));   
    $tglperiksa1 = tgl_sql($this->input->post('tglperiksa1')); 
    $nopanggil2 = addslashes($this->input->post('nopanggil2'));
    $tglpanggil2 = $this->input->post('tglpanggil2');   
    $tglperiksa2 = $this->input->post('tglperiksa2'); 

    if ($tdkhadir == '') {
      $tdkhadir = "TIDAK";
    }

    if ($tglpanggil2 == '') {
      $tglpanggil2 = null;
    } else {
      $tglpanggil2 = tgl_sql($tglpanggil2);
    }

    if ($tglperiksa2 == '') {
      $tglperiksa2 = null;
    } else {
      $tglperiksa2 = tgl_sql($tglperiksa2);
    }


    $lamathn = addslashes($this->input->post('lamathn'));
    $lamabln = addslashes($this->input->post('lamabln'));

    $deskripsi = strtoupper(addslashes($this->input->post('deskripsi'))); 
    $nip_pejabat = addslashes($this->input->post('nip_pejabat'));  
    $nosk = addslashes($this->input->post('nosk'));
    $tglsk = tgl_sql($this->input->post('tglsk')); 

      $gaji = addslashes($this->input->post('gaji'));
      $tmtgaji = $this->input->post('tmtgaji');
        
      $idgolru = addslashes($this->input->post('idgolru'));
      $tmtgolru = $this->input->post('tmtgolru');

      $jabatan = addslashes($this->input->post('jabatan'));          
      $tmtjabatan = $this->input->post('tmtjabatan');
    
    if ($gaji == '') {
      $acuangaji = $this->mkgb->gettmtterakhir($nip);
      $gaji = $this->mhukdis->getnilaigajiterakhir($nip, $acuangaji);
    }
    
    if ($tmtgaji == '') {
      $acuangaji = $this->mkgb->gettmtterakhir($nip);
      $tmtgaji = $this->mhukdis->gettmtgajiterakhir($nip, $acuangaji);
    } else {
      $tmtgaji = tgl_sql($tmtgaji);
    }

    if ($idgolru == '') {
      $idgolru = $this->mhukdis->getidgolruterakhir($nip);
    }
    
    if ($tmtgolru == '') {
      $tmtgolru = $this->mhukdis->gettmtgolruterakhir($nip);
    } else {
      $tmtgolru = tgl_sql($tmtgolru);
    }

    if ($jabatan == '') {
      $unker = $this->munker->getnamaunker($this->mpegawai->getfidunker($nip));
      $jabatan = $this->mpegawai->namajabnip($nip).' PADA '.$unker;    
    }

    if ($tmtjabatan == '') {
      $tmtjabatan = $this->mpegawai->gettmtjabterakhir($nip);   
    } else {
      $tmtjabatan = tgl_sql($tmtjabatan);
    }

    $akhirhukdis = $this->input->post('akhirhukdis');
    if ($akhirhukdis == '') {
      $akhirhukdis = null;
    } else {
      $akhirhukdis = tgl_sql($akhirhukdis);
    }

    if ($lamathn == '') {
      $lamathn = 0;
    }

    if ($lamabln == '') {
      $lamabln = 0;
    }  
    
    $peruu = $this->input->post('peruu');

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $datahukdis = array(      
      'nip'               => $nip,
      'fid_jenis_hukdis'  => $jnshukdis,
      'ketidakhadiran'    => $tdkhadir,
      'pemanggilan1_nosurat'  => $nopanggil1,
      'pemanggilan1_tglsurat' => $tglpanggil1,
      'pemeriksaan1_tgl'  =>  $tglperiksa1,
      'pemanggilan2_nosurat'  => $nopanggil2,
      'pemanggilan2_tglsurat' => $tglpanggil2,
      'pemeriksaan2_tgl'  =>  $tglperiksa2,
      'no_sk'             => $nosk,
      'tgl_sk'            => $tglsk,
      'nippejabat_sk'     => $nip_pejabat,
      'tmt_hukuman'       => $tmthukdis,
      'gaji'              => $gaji,
      'tmt_gaji'          => $tmtgaji,
      'fid_golru'         => $idgolru,
      'tmt_golru'         => $tmtgolru,
      'jabatan'           => $jabatan,
      'tmt_jabatan'       => $tmtjabatan,
      'lama_thn'          => $lamathn,
      'lama_bln'          => $lamabln,
      'akhir_hukuman'     => $akhirhukdis,
      'fid_peruu'         => $peruu,
      'deskripsi'         => $deskripsi,
      'dilaporkan_pada'   => $tgl_aksi,
      'dilaporkan_oleh'   => $user,
      'status'            => 'NO VALID'
      );

    $nama = $this->mpegawai->getnama($nip);

    if ($this->mhukdis->input_hukdis($datahukdis))   
    {
          // kirim konfirmasi pesan dan jenis pesan yang ada pada file tampilpengantarcuti.php
      $data['pesan'] = '<b>Sukses</b>, Data Hukuman Disiplin PNS A.n. <u>'.$nama.'</u> berhasil ditambahkan.';
      $data['jnspesan'] = 'alert alert-success';
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Data Hukuman Disiplin PNS A.n. <u>'.$nama.'</u> gagal ditambahkan.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['usulhd'] = $this->mhukdis->tampilusulhd()->result_array();
    $data['content'] = 'hukdis/tampilusulhd';
    $this->load->view('template', $data);
  }

  function detailhd()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $tmt = $this->input->post('tmt');
      $jnshd = $this->input->post('jnshd');

      $data['detailhd'] = $this->mhukdis->detailhd($nip, $tmt, $jnshd)->result_array();
      $data['content'] = 'hukdis/detailhd';
      $this->load->view('template', $data);
    }
  }

  function showdetailhukdis()
  {
      $nip = $this->input->post('nip');
      $tmt = $this->input->post('tmt');
      $jns = $this->input->post('jns');

      echo $nip,' ',$tmt,' ',$jns;
  }

  function hapus_usul()
  {
    $nip = addslashes($this->input->post('nip'));
    $tmt = addslashes($this->input->post('tmt'));
    $jnshd = addslashes($this->input->post('jnshd'));
    
    $nama = $this->mpegawai->getnama($nip);
    
    $where = array('nip' => $nip,
                   'tmt_hukuman' => $tmt,
                   'fid_jenis_hukdis' => $jnshd,
             );

    if ($this->mhukdis->hapus_usul($where)) {
        $data['pesan'] = '<b>Sukses</b>, Laporan Hukuman Disiplin '.$nama.' berhasil dihapus';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal</b>, Laporan Hukuman Disiplin '.$nama.' gagal dihapus';
        $data['jnspesan'] = 'alert alert-danger';
      }
      
    $data['usulhd'] = $this->mhukdis->tampilusulhd()->result_array();
    $data['content'] = 'hukdis/tampilusulhd';
    $this->load->view('template', $data);
  }

  function edithd()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $nip = $this->input->post('nip');
      $tmt = $this->input->post('tmt');
      $jnshd = $this->input->post('jnshd');

      $data['edithd'] = $this->mhukdis->detailhd($nip, $tmt, $jnshd)->result_array();
      $data['nip'] = $nip;
      $data['tmt'] = $tmt;
      $data['jnshd'] = $jnshd;
      $data['content'] = 'hukdis/edithd';
      $this->load->view('template', $data);
    }
  }

  function editusul_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $fid_jnshd = addslashes($this->input->post('fid_jnshd'));
    $fid_peruu = addslashes($this->input->post('fid_peruu'));
    $tmtmulai = tgl_sql($this->input->post('tmtmulai'));    
    $tmtakhir = $this->input->post('tmtakhir');
    
    $tdkhadir = addslashes($this->input->post('tdkhadir'));
    $nopanggil1 = addslashes($this->input->post('nopanggil1'));
    $tglpanggil1 = tgl_sql($this->input->post('tglpanggil1'));   
    $tglperiksa1 = tgl_sql($this->input->post('tglperiksa1')); 
    $nopanggil2 = addslashes($this->input->post('nopanggil2'));
    $tglpanggil2 = $this->input->post('tglpanggil2');   
    $tglperiksa2 = $this->input->post('tglperiksa2'); 

    if ($tdkhadir == '') {
      $tdkhadir = "TIDAK";
    }

    if (($tglpanggil2 == '') OR ($tglpanggil2 == '0000-00-00'))  {
      $tglpanggil2 = null;
    } else {
      $tglpanggil2 = tgl_sql($tglpanggil2);
    }

    if (($tglperiksa2 == '') OR ($tglperiksa2 == '00-00-0000')) {
      $tglperiksa2 = null;
    } else {
      $tglperiksa2 = tgl_sql($tglperiksa2);
    }

    $lamathn = addslashes($this->input->post('lamathn'));
    $lamabln = addslashes($this->input->post('lamabln'));

    $deskripsi = strtoupper(addslashes($this->input->post('deskripsi'))); 
    $nip_pejabat = addslashes($this->input->post('nip_pejabat'));  
    $nosk = addslashes($this->input->post('nosk'));
    $tglsk = tgl_sql($this->input->post('tglsk')); 
   
    if (($tmtakhir == '') OR ($tmtakhir == '00-00-0000')) {
      $tmtakhir = null;
    } else {
      $tmtakhir = tgl_sql($tmtakhir);
    }

    if ($lamathn == '') {
      $lamathn = 0;
    }

    if ($lamabln == '') {
      $lamabln = 0;
    }  

    $jnshd_lama = addslashes($this->input->post('jnshd_lama'));
    $tmt_lama = $this->input->post('tmt_lama');     

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $nama = $this->mpegawai->getnama($nip);

     $datahukdis = array(      
      'fid_jenis_hukdis'  => $fid_jnshd,
      'ketidakhadiran'    => $tdkhadir,
      'pemanggilan1_nosurat'  => $nopanggil1,
      'pemanggilan1_tglsurat' => $tglpanggil1,
      'pemeriksaan1_tgl'  =>  $tglperiksa1,
      'pemanggilan2_nosurat'  => $nopanggil2,
      'pemanggilan2_tglsurat' => $tglpanggil2,
      'pemeriksaan2_tgl'  =>  $tglperiksa2,
      'no_sk'             => $nosk,
      'tgl_sk'            => $tglsk,
      'nippejabat_sk'     => $nip_pejabat,
      'tmt_hukuman'       => $tmtmulai,
      'lama_thn'          => $lamathn,
      'lama_bln'          => $lamabln,
      'akhir_hukuman'     => $tmtakhir,
      'fid_peruu'         => $fid_peruu,
      'deskripsi'         => $deskripsi,
      'dilaporkan_pada'   => $tgl_aksi,
      'dilaporkan_oleh'   => $user,      
      'status'            => 'NO VALID'      
      );

    $where = array(
      'nip'               => $nip,
      'tmt_hukuman'       => $tmt_lama,
      'fid_jenis_hukdis'  => $jnshd_lama
    );
    
    if ($this->mhukdis->edit_usul($where, $datahukdis))
      {
        $data['pesan'] = '<b>Sukses</b>, Data Laporan Hukuman Disiplin <u>'.$nama.'</u> berhasil dirubah.';
        $data['jnspesan'] = 'alert alert-success';
      } else {
        $data['pesan'] = '<b>Gagal !</b>, Data Laporan Hukuman Disiplin <u>'.$nama.'</u> gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
        $data['jnspesan'] = 'alert alert-danger';
      }
    
    $data['usulhd'] = $this->mhukdis->tampilusulhd()->result_array();
    $data['content'] = 'hukdis/tampilusulhd';
    $this->load->view('template', $data);
  }

  function tampilvalidasi()
  {    
    //$data['thntmt'] = $this->mhukdis->gettahuntmt()->result_array();
    $data['pesan'] = '';    
    $data['jnspesan'] = '';
    $data['content'] = 'hukdis/tampilvalidasi';
    $this->load->view('template', $data);
  }

  function carivalusul() {
    $thn = $this->input->get('thn');

    $sqlcari = $this->mhukdis->carivalusul($thn)->result_array();

    $jml = count($sqlcari);
    
    if ($jml == 0) {
      echo "<br /><div class='alert alert-danger' role='alert'>";
      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
      echo "Data <b>tidak ditemukan</b>";
      echo "</div>";
    } else {
      ?>
      <br/>
      <div align='right'>
      <form method="POST" action='../hukdis/cetaknom' target='_blank'>
         <?php
         if ($this->session->userdata('edit_profil_priv') == "Y") { 
              echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
              ?>
              <button type='submit' class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbspCetak Nominatif Tahun <?php echo $thn;?></button>
                <?php
              }
        ?>
      </form>
      </div>
      <?php
      echo '<br/>';
      echo '<table class="table table-condensed table-hover" style="width:95%;">';
      echo "<tr class='success'>
      <th width='20'><center>#</center></th>
      <th width='200' width='20%'><center>NIP / Nama</center></th>
      <th width='200'><center>Jabatan / Unit Kerja<br/>pada saat Hukdis</center></th>
      <th width='300'><center>Jenis Hukuman<br/><u>Ketentuan yang dilanggar</u></center></th>
      <th width='100'><center>TMT Hukuman<br/><u>Status Laporan</u></center></th>
      <th width='5%'><center>Aksi</center></th>";

      $no = 1;
      foreach($sqlcari as $v):          
        ?>
      <tr>
        <td align='center'><?php echo $no;?></td>
        <td><?php echo 'NIP. ',$v['nip'], '<br />', $this->mpegawai->getnama($v['nip']) ?></td>
        <td><?php echo $v['jabatan'] ?></td>
        <?php
        $jnshd = $this->mhukdis->getjnshukdis($v['fid_jenis_hukdis']);
        $peruu = $this->mhukdis->getperuu($v['fid_peruu']);
        $tingkat = $this->mhukdis->gettingkathukdis($v['fid_jenis_hukdis']);

        if ($tingkat == 'RINGAN') {
          $fcolor = 'green';
        } else if ($tingkat == 'SEDANG') {
          $fcolor = 'orange';
        } else if ($tingkat == 'BERAT') {
          $fcolor = 'red';
        }
        ?>
        <td><?php echo "<center style='color:$fcolor'><b>".$jnshd."</b></center>".$peruu; ?></td>
        <?php
        if ($v['status'] == 'NO VALID') {
          $ket ='Tunggu Validasi';
          $color = 'default';  
        } else if ($v['status'] == 'VALID') {
          $ket ='Setuju'; 
          $color = 'info'; 
        } else if ($v['status'] == 'CETAK SK') {
          $ket ='Cetak SK';  
          $color = 'success';
        } else if ($v['status'] == 'SELESAI') {
          $ket ='Selesai'; 
          $color = 'default'; 
        }

        echo "<td align='center'>".tgl_indo($v['tmt_hukuman'])."<h5><span class='label label-".$color."'>".$ket."</span></h5></td>";
        ?>       

        <td align='center'>
          <form method="POST" action='../hukdis/validasihd'>
            <?php          
            if ($this->session->userdata('edit_profil_priv') == "Y") { 
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              echo "<input type='hidden' name='tmt' id='tmt' value='$v[tmt_hukuman]'>";
              echo "<input type='hidden' name='jnshd' id='jnshd' value='$v[fid_jenis_hukdis]'>";
              ?>
              <button type='submit' class="btn btn-warning btn-sm">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span><br/>&nbspValidasi</button>
                <?php
              }
              ?>
            </form>
        </td>
      </tr>
      <?php

      $no++;
      endforeach;
      ?>
      </table>
      <?php
    }
  }

  function validasihd()
  {    
    //cek priviledge session user -- profil_priv
    if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198705242010012015")) { 
      $nip = $this->input->post('nip');
      $tmt = $this->input->post('tmt');
      $jnshd = $this->input->post('jnshd');

      $data['valhd'] = $this->mhukdis->detailhd($nip, $tmt, $jnshd)->result_array();
      $data['content'] = 'hukdis/validasihd';
      $this->load->view('template', $data);
    }
  }

  function validasihd_aksi() {
    $nip = addslashes($this->input->post('nip'));
    $tmt = $this->input->post('tmt');
    $jnshd = $this->input->post('jnshd'); 
   
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $nama = $this->mpegawai->getnama($nip);

    $status = 'VALID';
    $data = array(
      'status'           => $status,
      'disetujui_pada'   => $tgl_aksi,
      'disetujui_oleh'   => $user      
      );


    $where = array(
      'nip'               => $nip,
      'tmt_hukuman'       => $tmt,
      'fid_jenis_hukdis'  => $jnshd
    );
    
    if ($this->mhukdis->edit_usul($where, $data))
    {
      // jika status berhasil di-valid (setuju), maka langsung ENTRI KE RIWAYAT
      $dtl_hd = $this->mhukdis->detailhd($nip, $tmt, $jnshd)->result_array();;
      foreach($dtl_hd as $v):
        $datarwy = array(
          'nip'             => $v['nip'],
          'fid_jenis_hukdis'=> $v['fid_jenis_hukdis'],
          'no_sk'           => $v['no_sk'],
          'tgl_sk'          => $v['tgl_sk'],
          'pejabat_sk'      => $this->mpegawai->namajabnip($v['nippejabat_sk']),
          'tmt_hukuman'     => $v['tmt_hukuman'],
          'lama_thn'        => $v['lama_thn'],
          'lama_bln'        => $v['lama_bln'],
          'akhir_hukuman'   => $v['akhir_hukuman'],
          'deskripsi'       => $v['deskripsi'],
          'created_by'      => $user,
          'created_at'      => $tgl_aksi   
          );           

      if ($this->mpegawai->input_rwyhd($datarwy)) {
        $data['pesan'] = '<b>Sukses</b>, Laporan Hukuman Disiplin <u>'.$nama.'</u> telah disetujui,<br/>dan telah ditambahkan ke riwayat Hukuman Disiplin';
        $data['jnspesan'] = 'alert alert-success';    
      }
      endforeach;        
    } else {
      $data['pesan'] = '<b>Gagal !</b>, Laporan Hukuman Disiplin <u>'.$nama.'</u> DITOLAK.<br />Pastikan data sesuai dengan ketentuan';
      $data['jnspesan'] = 'alert alert-danger';
    }
    $data['content'] = 'hukdis/tampilvalidasi';
    $this->load->view('template', $data);
  }

  function hapushd_aksi(){
    $nip = addslashes($this->input->post('nip'));
    $tmt = addslashes($this->input->post('tmt'));
    $jnshd = addslashes($this->input->post('jnshd'));
    $nama = $this->mpegawai->getnama($nip);

    $where = array(
      'nip'               => $nip,
      'tmt_hukuman'       => $tmt,
      'fid_jenis_hukdis'  => $jnshd
    );
    
    if ($this->mpegawai->hapus_rwyhd($where)) {
      $data['pesan'] = '<b>Sukses</b>, Riwayat Hukuman Disiplin <u>'.$nama.'</u> berhasil dihapus';
      $data['jnspesan'] = 'alert alert-success';  
    } else {
      $data['pesan'] = '<b>Gagal</b>, Riwayat Hukuman Disiplin <u>'.$nama.'</u> gagal dihapus';
      $data['jnspesan'] = 'alert alert-danger';
    }
    
    $data['pegrwyhd'] = $this->mpegawai->rwyhd($nip)->result_array();       
    $data['nip'] = $nip;
    $data['content'] = 'rwyhd';
    $this->load->view('template', $data);
  }

  function statistika()
  {
   if (($this->session->userdata('level') == "ADMIN") OR ($this->session->userdata('nip') == "198705242010012015")) {  
      $data['grafik'] = $this->mhukdis->getjmlprosesbystatusgraph();
      $data['thnhd'] = $this->mhukdis->gettahunrwyhd()->result_array(); 
      $data['rwyperbulan'] = $this->mhukdis->getjmlrwyperbulan(); 
      $data['content'] = 'hukdis/statistika';
      $this->load->view('template',$data);
    }
  }

  public function cetakskhd()  
  {
    $res['data'] = $this->datacetak->datacetakskhd();
    $this->load->view('/hukdis/cetaksk',$res);        
  }

  public function cetaknom()  
  {
    $thn = $this->input->post('thn');
    $data['thn'] = $thn;
    $res['data'] = $this->datacetak->datacetaknomhukdis();
    $this->load->view('/hukdis/cetaknom',$res);        
  }
}

/* End of file pegawai.php */
/* Location: ./application/controllers/pegawai.php */
