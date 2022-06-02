<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT");
      parent::__construct();
      $this->load->helper('form');
      $this->load->model('mpegawai');
      $this->load->helper('fungsitanggal');
      $this->load->helper('fungsipegawai');
      $this->load->model('munker');
      $this->load->model('mkinerja');
      $this->load->model('mlogin');
      $this->load->model('mgraph');
      $this->load->model('Mapi');

      // untuk login session
      if (!$this->session->userdata('nama'))
      {
        redirect('login');
      }
    }

	public function index()
	{
	  $data['content'] = 'content';
    $this->load->view('template', $data);
	}

  public function tampilpeg()
  {
      $data['data'] = $this->mpegawai->tampil()->result_array();

      $data['content'] = 'tampil';
      $this->load->view('template', $data);
  }
  public function hasil_survey()
  {
    $data = $this->Mapi->hasil_survey('userportal')->result();
    header('Content-Type: application/json');
    echo json_encode($data, TRUE);    
  }
  public function totalPengguna()
  {
    $data = $this->Mapi->totalPengguna('userportal');
    header('Content-Type: application/json');
    echo json_encode($data, TRUE); 
  }
  public function showPesan()
  {
    $nip = substr($this->input->get('np'),0,16);
    $data = $this->Mapi->showPesan('surveyjawaban2018', $nip);
    header('Content-Type: application/json');
    echo json_encode($data, TRUE);     
  }
  public function resetSurvey()
  {
    $nip = substr($this->input->get('np'),0,16);
    $data = $this->Mapi->resetSurvey('surveyjawaban2018', $nip);
    header('Content-Type: application/json');
    echo json_encode($data, TRUE);     
  }
  public function jmlPengisi()
  {
    $data = $this->Mapi->jmlPengisi('surveyjawaban2018');
    header('Content-Type: application/json');
    echo json_encode($data, TRUE);     
  }    
  public function bukusurvey() 
  {

	  $data['content'] = 'bukusurvey';
    $this->load->view('template', $data);    
  }
  public function cekSurvey()
  {
    $nip = $this->input->post('nipuser');
    $data = $this->Mapi->cekSurvey($nip)->result();
    header('Content-Type: application/json');
    echo json_encode($data, TRUE);
  }
  public function simpanSurvey()
  {
    $nip = $this->input->post('nip_survey');
    $id_pertanyaan = $this->input->post('idpertanyaan[]');

    $values = array();
    foreach($id_pertanyaan as $key){
    $jawaban = $this->input->post('mySurvey'.$key);
      array_push($values, array(
        'nip' => $nip,
        'fid_pertanyaan' => $key,
        'jawaban' => $jawaban
      ));
    }

    if(count($values) == 0){
      $pesan['type'] = 'warning';
      $pesan['content'] = "Mohon isi survey keseluruhan !";
    }elseif(!empty($nip) && $jawaban != ''){
      $pesan['type'] = 'success';
      $pesan['content'] = "Terimakasih Telah Menyelesaikan Survey !";
      $this->Mapi->insert_survey('surveyjawaban2018', $values);
    } else {
      $pesan['type'] = 'error';
      $pesan['content'] = "Terjadi Kesalahan Pada Pengisian Survey. Coba Cek Kembali.. ";
    } 
    header('Content-Type: application/json');
    echo json_encode($pesan, TRUE);
  }

  public function ChartBarLabel()
  {
    $label = $this->Mapi->ChartBarLabel('surveypertanyaan2018', 'HARAPAN');
    $jmlJawaban = $this->Mapi->CountJawab('surveyjawaban2018');
    header('Content-Type: application/json');
    $data = '';
    foreach($label as $v) {
      $data[] = $v->pertanyaan;
    }

    $res = '';
    foreach($jmlJawaban as $r) {
      $res[] = $r->jmlData;
    }

    $json = json_encode(['label' => $data, 'count' => $res]);
    echo $json;
    
  }

 
  function tampilunker()
  {
    //cek priviledge session user -- profil_priv
    if ($this->session->userdata('profil_priv') == "Y") { 
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['content'] = 'tampilunker';
      $this->load->view('template',$data);
    }
  }

  // untuk ajax tampil unker.php  
  function tampilpegunker() {
    $idunker = $this->input->get('idunker');

    if ($idunker) {
      $sqlcari = $this->munker->pegperunker($idunker)->result_array();
      $nmunker = $this->munker->getnamaunker($idunker);
      $jmlpeg = count($this->munker->pegperunker($idunker)->result_array());

      echo "<div class='panel panel-default' style='width: 80%'>";
      echo "<div class='panel-body'>";
      echo "<div class='panel panel-info'>";
      echo "<div class='panel-heading' align='left'><b>$nmunker</b><br />";
      echo "Jumlah ASN : ".$jmlpeg;
      echo "</div>";
      echo "<div style='padding:0px;overflow:auto;width:99%;height:450px;border:1px solid white' >";

      echo "<table class='table table-condensed'>";
      echo "<tr>
        <td align='center'><b>No</b></td>
        <td align='center'><b>NIP</b></td>
        <td align='center' colspan='2'><b>Nama</b></td>
        <td align='center'><b>Golongan Ruang</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center'><b>Aksi</b></td>";
      echo "</tr>";    
      
      $no = 1;
      foreach($sqlcari as $v): 
	if ($v['fid_jabfu'] == '603') {  
		echo "<tr class='danger'>";
	} else {
		echo "<tr>";
	}       
        ?>	
        <td width='10' align='center'><?php echo $no.'.'; ?></td>
        <td width='150'><?php echo $v['nip']; ?></td>
        <td><?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></td>
        <td align='center'>         

        <?php
        //echo "<img src='../photo/$v[nip].jpg' width='60' height='80' alt='$v[nip].jpg'>";
        //$filename = '../photo/'.$v['nip'].'.jpg';
        
        //$url = base_url();
        $lokasifile = './photo/';
        $filename = "$v[nip].jpg";

        //if (file_exists($filename)) {
        if (file_exists ($lokasifile.$filename)) {
          echo "<img src='../photo/$filename' width='60' height='80' alt='$v[nip].jpg'";
          //echo "<img src='$url/photo/noimage.jpg' width='60' height='80' alt='no image'>";
        } else {
          //echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'>";
          echo "<img src='../photo/nophoto.jpg' width='60' height='80' alt='no image'";
        }   
        ?>         

        </td>
        <td width='140' align='center'>
          <?php echo $v['nama_golru'];?>
          <br />
          <?php echo 'TMT : ',tgl_indo($v['tmt_golru_skr']); ?>
        </td>
        <!--<td><?php //echo $v['nama_jabatan']; ?></td> -->

        <td>
        <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }

          if ($this->session->userdata('level') == "ADMIN") {            
	    echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab);           
	  } else {
            echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab); 
          }
	  $ideselon = $this->mpegawai->getfideselon($v['nip']);
          $namaeselon = $this->mpegawai->getnamaeselon($ideselon);

	  // menampilkan jabtan PLTnya, kalau ada
          $blnini = date('m');
          $thnini = date('Y');
          $cekplt = $this->mkinerja->cek_sdgplt($v['nip'], $blnini, $thnini);
          //if ($cekplt == "Y") {
	  if ($cekplt == true) {
            $kelasplt = $this->mkinerja->get_dataplt($v['nip']);            
            echo "<br/><small><small><div class='text-primary'>PLT. ".$kelasplt."</div></small></small>";
          }
          // End PLT nya

	  $jnsjab = $this->mkinerja->get_jnsjab($v['nip']);
          if ($jnsjab == "STRUKTURAL") {
	    if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
              $id_jabstruk = $this->mkinerja->getfidjabstruk($v['nip']);
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
              $kelasjabatan = $this->mkinerja->get_kelasjabstruk($v['nip']);
            }
	    $warna="danger";
            //$kelasjabatan = $this->mkinerja->get_kelasjabstruk($v['nip']);
            //$hargajabatan = $this->mkinerja->get_hargajabstruk($v['nip']);
          } else if ($jnsjab == "FUNGSIONAL UMUM") {
	    $warna="success";
            $kelasjabatan = $this->mkinerja->get_kelasjabfu($v['nip']);
            //$hargajabatan = $this->mkinerja->get_hargajabfu($v['nip']);
          } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
	    $warna="info";
            //echo " <code><b>JFT</b></code>";
            $kelasjabatan = $this->mkinerja->get_kelasjabft($v['nip']);
            //$hargajabatan = $this->mkinerja->get_hargajabft($v['nip']);
          } else {
	    $warna="default";
            $kelasjabatan = "-";
            //$hargajabatan = "-";
          }
          //echo "<br/><code>Kelas Jabatan : <b>".$kelasjabatan."</b>, Harga Jabatan : <b>".$hargajabatan."</b></code>";
          echo "<br/><code>Kelas Definitif : <b>".$kelasjabatan."</b></code>";
	  if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
            $id_jabstruk = $this->mkinerja->getfidjabstruk($v['nip']);
            $datajf= $this->mkinerja->getdatajfubawahan($id_jabstruk)->result_array();
            echo "<br/><small class='text-danger'>";
            foreach ($datajf as $jf) {
              $namajf = $this->mpegawai->getnama($jf['nip']);
              if ($jf['fid_jnsjab'] == '2') {
                $jabjf = $this->mpegawai->namajab('2',$jf['fid_jabfu']);
		$kelasjf = $this->mkinerja->get_kelasjabfu_idkelas($jf['fid_jabfu']);
              } else if ($jf['fid_jnsjab'] == '3') {
                $jabjf = $this->mpegawai->namajab('3',$jf['fid_jabft']);
		$kelasjf = $this->mkinerja->get_kelasjabft_idkelas($jf['fid_jabft']);
              }
              $idtingpenjf = $this->mkinerja->getidtingpenterakhir($jf['nip']);
              $tingpenjf = $this->mpegawai->gettingpen($idtingpenjf); 
              echo "+ ";
	      echo $jabjf." [".$kelasjf."] - ".$namajf." [".$tingpenjf."]";
              //echo $jabjf." - ".$namajf." [".$tingpenjf."]";
              echo "<br/>";
            }
            echo "</small>";
          }

        ?>          
        </td>
	<?php
        if ($this->session->userdata('level') == "ADMIN") {
        ?>
        <td align='center'>
          <?php
          echo "<form method='POST' action='../pegawai/rwyjab' target='_blank'>";
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-warning btn-xs">
          <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span><br/>Rwy Jab
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
        <?php
        }
        ?>
        <td align='center' width='30'>
          <?php
          echo "<form method='POST' action='../pip/tampilhasilukur' target='_blank'>";
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-success btn-xs">
          <span class="fa fa-trophy" aria-hidden="true"></span><br/>IP ASN 2021
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
        <td align='center' width='30'>
          <?php
          echo "<form method='POST' action='../pegawai/detail'>";          
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn <?php echo "btn-".$warna;?> btn-xs">
          <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span><br/>Detail
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
  }

  public function dashboard()
  {
    $data['jenkel'] = $this->mgraph->jenkel();
    $data['golru'] = $this->mgraph->golru();
    $data['eselon'] = $this->mgraph->eselon();
    $data['jenjab'] = $this->mgraph->jenjab();
    $data['tingpen'] = $this->mgraph->tingpen();
    $data['content'] = 'dashboard';
    $this->load->view('template', $data);
  }

  public function mancuti()
  {
    $data['content'] = 'mancuti';
    $this->load->view('template', $data);
  }

  public function maninfo()
  {
    $data['content'] = 'maninfo';
    $this->load->view('template', $data);
  }

  public function mankgb()
  {
    $data['content'] = 'mankgb';
    $this->load->view('template', $data);
  }

  public function manfile()
  {
    $data['content'] = 'manfile';
    $this->load->view('template', $data);
  }

  public function laykarpeg()
  {
    $data['content'] = 'laykarpeg';
    $this->load->view('template', $data);
  }

  public function laykarisu()
  {
    $data['content'] = 'laykarisu';
    $this->load->view('template', $data);
  }
  
  public function panduan_siadis()
  {
    $data['content'] = 'hukdis/panduan';
    $this->load->view('template', $data);
  }
  
  public function panduan_sipetruk()
  {
  	$data['content'] = 'petruk/panduan';
    $this->load->view('template', $data);
  }

  public function mannonpns()
  {
    $data['content'] = 'mannonpns';
    $this->load->view('template', $data);
  }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
