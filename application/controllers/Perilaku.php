<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perilaku extends CI_Controller {

  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('fungsitanggal');    
    $this->load->helper('fungsiterbilang');
    $this->load->helper('fungsipegawai');
    $this->load->model('mpegawai');
    $this->load->model('madmin');
    $this->load->model('munker');
    $this->load->model('mtakah');
    $this->load->model('mkinerja');
    $this->load->model('mhukdis');

    // untuk fpdf
    $this->load->library('fpdf');

    // untuk login session
    if (!$this->session->userdata('nama'))
    {
      redirect('login');
    }
  }
  
  public function index()
  {	  
  }

  function kroscekhasil() {
    //cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['content'] = 'perilaku/croscekhasil';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function tampilkroscekhasil() {
    $idunker = $this->input->get('uk');
    $tahun = $this->input->get('thn');

    ?>
    <br/>
    <small>    
    <?php
    
    $datapns = $this->munker->pegperunker($idunker)->result_array();

    $no = 1;
    foreach($datapns as $dp) :      
      $nip = $dp['nip'];
          $url = 'https://eprilaku.bkppd-balangankab.info/Api/get_perilaku_thnnip_silka?thn='.$tahun.'&nip='.$nip;
          $konten = file_get_contents($url);
          $api = json_decode($konten);
          $jml = count($api);

          // TO DO : proses data dari DES Web Service
          if ($jml != 0) {            
            if ($no % 4 == 0) {
	      echo "</div>"; // tutup row sebelumnya
              echo "<div class='row'>";
            }
            ?>
            
              <div class="col-lg-3 col-md-2">
                <div class="panel panel-info">
                  <div class="panel-heading" align='left'>
                    <?php
                      echo $no.". ".$this->mpegawai->getnama($dp['nip']);
                      echo "<br/><small><code>".$this->mkinerja->getnamajabatan($dp['nip'])."</code></small>";
                    ?>
                  </div>
                  <div class="panel-body" align='left'>
                    <?php
                      echo "<div class='row'>";
                      echo "<div class='col-lg-2'>LEVEL</div><div class='col-lg-2'><span class='label label-info'>".$api->status."</span></div>";
                     
                      //foreach($api->bobot as $db) :
                        if ($api->jenis_jabatan == "JST") {
                          $jnsjab = "STUKTURAL";
                        } else if ($api->jenis_jabatan == "JFT") {
                          $jnsjab = "JFU / JFT";
                        }
                        echo "<div class='col-lg-4'>JNS JABATAN</div><div class='col-lg-4'><span class='label label-success'>".$jnsjab."</span></div>";
                        echo "</div>";
                        echo "<b>BOBOT</b>";
                        echo "<div class='row'>";                       
                        echo "<div class='col-lg-4'>Atasan : ".$api->bobot_atasan."%</div>";
                        echo "<div class='col-lg-4'>Peer : ".$api->bobot_teman."%</div>";
                        echo "<div class='col-lg-4'>Bawahan : ".$api->bobot_bawahan."%</div>";
                        echo "</div>";                
                      //endforeach;

                      echo "<b><br/>EVALUATOR</b>";
                      foreach($api->evaluator as $de) :
			echo "<div class='row'>";         
                        echo "<div class='col-lg-2 text-success'><small>".$de->flag_evaluator."</small></div>";
                        if ($de->urutan != NULL) {
                          echo "<div class='col-lg-1' align='left'><span class='label label-warning'>".$de->urutan."</span></div>";
                        }
                        echo "<div class='col-lg-8' align='left'>".$this->mpegawai->getnama($de->nip)."</div>";                       
                        echo "</div>";
                        echo "<div class='row'>";                        
                        echo "<div class='col-lg-2'></div>";
                        echo "<div class='col-lg-10' align='left'><small><code>".$this->mkinerja->getnamajabatan($de->nip)."</code></small></div>";
                        echo "</div>";      
                      endforeach;
		      

                      echo "<br/>";
		      if ($api->nilai_tahunan != "") {
			echo "<b><br/>NILAI TAHUNAN</b>";
                      	foreach($api->nilai_tahunan as $dn) :   
                        	echo "<div class='row'>";           
                        	echo "<div class='col-lg-5'>Orientasi Pelayanan</div><div class='col-lg-7'>".$dn->orientasi_pelayanan."</div>";
                        	echo "<div class='col-lg-5'>Komitmen</div><div class='col-lg-7'>".$dn->komitmen."</div>";
                        	echo "<div class='col-lg-5'>integritas</div><div class='col-lg-7'>".$dn->integritas."</div>";
                        	echo "<div class='col-lg-5'>Kerjasama</div><div class='col-lg-7'>".$dn->kerjasama."</div>";
                        	echo "<div class='col-lg-5'>Disiplin</div><div class='col-lg-7'>".$dn->disiplin."</div>";
                        	echo "<div class='col-lg-5'>Kepemimpinan</div><div class='col-lg-7'>".$dn->kepemimpinan."</div>";
                        	echo "<b class='text-primary'><div class='col-lg-5'>Nilai Akhir</div><div class='col-lg-7'>".round($dn->nilai_akhir,2)."</div></b>";
                        	echo "<div class='col-lg-12 text-muted'>Disimpan pada ".tglwaktu_indo($dn->simpan_tgl)."</div>";
                      	endforeach;
			//break;
		      }
		      
                      
                    ?>                  
                  </div>
                </div>
              </div>
            <?php
            
            echo "</div>";  
	    $no++;
          } 
	  // else {
            //echo "<td colspan='4' align='center' class='warning'><span class='text-danger'>".$this->mpegawai->getnama($dp['nip'])."<br/>DATA TIDAK DITEMUKAN</span></td>"; 
          //}   
    endforeach;    
  }
}
