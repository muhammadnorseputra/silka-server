<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Petajab extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('fungsitanggal');
        $this->load->helper('fungsipegawai');  
        $this->load->model('mpegawai'); 
        $this->load->model('mpppk');
        $this->load->model('mstatistik');
        $this->load->model('munker');   
        $this->load->model('mpetajab'); 
        $this->load->model('mkinerja');
        $this->load->model('datacetak');

        // untuk fpdf
        $this->load->library('fpdf');
    }

    function tampil() {
        //if ($this->session->userdata('usulkgb_priv') == "Y") {
          $data['content'] = 'petajab/tampil';
          $data['unker'] = $this->munker->dd_unker()->result_array();
          $data['pesan'] = '';
          $data['jnspesan'] = '';
          $this->load->view('template', $data);
        //}
    }

    private function infopeta($id, $idjnsjab, $idjab, $idunker, $kelas, $jml) {
    $jnsjab = $this->mpetajab->get_namajnsjab($idjnsjab);    
    ?>
        <div class='row' align='left'>
                <div class='col-md-12 col-xs-12'>
                    <?php
                    $setuju = $this->mpetajab->cek_approve($id);
                    if ($setuju == "N") {                        
                        /*echo "<div class='col-md-2'>
                            <form method='POST' action='../takah/rwytakah'>
                                <input type='hidden' name='id' id='id' maxlength='18' value='".$id."'>
                                <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='18' value='".$idjnsjab."'>
                                <input type='hidden' name='idunker' id='idunker' maxlength='18' value='".$idunker."'>
                                <button type='submit' class='btn btn-warning btn-outline btn-xs'>
                                <span class='fa fa-pencil-square-o' aria-hidden='true'></span> Edit Jabatan
                                </button>
                            </form>
                        </div>";
                        */

                        //echo "<div class='col-md-1' aling='center'>
                        //    <button type='button' class='btn btn-outline btn-success btn-xs' data-toggle='modal' data-target='#tampileditjab'><span class='fa fa-edit' aria-hidden='true'></span> Edit</button>
                        //</div>";

                        //echo "<div class='col-md-2' aling='center'>
                        //    <button type='button' class='btn btn-outline btn-primary btn-xs' data-toggle='modal' data-target='#tampilgantiatasanjab'><span class='fa fa-edit' aria-hidden='true'></span> Ganti Atasan</button>
                        //</div>";
                        
                        $adabawahan = $this->mpetajab->cek_bawahan($id);
			$cekpemangku_pns = $this->mpetajab->get_pemangku_pns($id)->result_array();
                        $cekpemangku_pppk = $this->mpetajab->get_pemangku_pppk($id)->result_array();

                        if ($adabawahan == 0 AND !$cekpemangku_pns AND !$cekpemangku_pppk) {
                            echo "<br/><div class='col-md-12 col-xs-2' align=''>
                                <form method='POST' action='../petajab/hapus_peta'>
                                    <input type='hidden' name='id' id='id' maxlength='18' value='".$id."'>
                                    <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='18' value='".$idjnsjab."'>
                                    <input type='hidden' name='idunker' id='idunker' maxlength='18' value='".$idunker."'>
                                    <button type='submit' class='btn btn-danger btn-outline btn-xs'>
                                    <span class='fa fa-trash-o' aria-hidden='true'></span> Hapus Jabatan
                                    </button>
                                </form>
                            </div>";
                        }

                        /*echo "<div class='col-md-2'>
                            <form method='POST' action='../takah/rwytakah'>
                                <input type='hidden' name='idjnsjab' id='jnsjab' maxlength='18' value='".$jnsjab."'>
                                <input type='hidden' name='idjab' id='idjab' maxlength='18' value='".$idjab."'>
                                <input type='hidden' name='idunker' id='idunker' maxlength='18' value='".$idunker."'>
                                <button type='submit' class='btn btn-success btn-outline btn-xs'>
                                <span class='fa fa-thumbs-up' aria-hidden='true'></span> Approval
                                </button>
                            </form>
                        </div>";
                        */
                    } else if ($setuju == "Y") {
			/*
                        echo "<div class='col-md-2 col-xs-12'>
                            <form method='POST' action='../takah/rwytakah'>
                                <input type='hidden' name='idjnsjab' id='jnsjab' maxlength='18' value='".$idjnsjab."'>
                                <input type='hidden' name='idjab' id='idjab' maxlength='18' value='".$idjab."'>
                                <input type='hidden' name='idunker' id='idunker' maxlength='18' value='".$idunker."'>
                                <button type='submit' class='btn btn-danger btn-outline btn-xs'>
                                <span class='fa fa-thumbs-down' aria-hidden='true'></span> No Approval
                                </button>
                            </form>
                        </div>";
			*/
                    }                    
                    ?>
                </div>
        </div>
        <br/>

        <?php     
        /*
        // Unt Jab JFU dan JFT, bisa menambahkan PNS nya
        if ($idjnsjab != "1") {
            $datajf = $this->mpetajab->getnippemangku($id)->result_array();;
            foreach($datajf as $jf):
                $nip = $jf['nip'];
                $nama = $this->mpegawai->getnama($nip);
                $pdk = $this->mpegawai->getpendidikan($nip);
                $idgolru = $this->mpetajab->getidgolru($nip);
                $golru = $this->mpegawai->getnamagolru($idgolru);
                $pangkat = $this->mpegawai->getnamapangkat($idgolru);
                //$tmtgolru = $this->mpegawai->gettmtkpterakhir($nip);
                $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);

                $pemangku = $nama." (NIP. ".$nip.")";    
                $lokasifile = './photo/';
                $filename = "$nip.jpg";

                if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$nip.jpg";
                } else {
                    $photo = "../photo/nophoto.jpg";
                }

                echo "
                <small>
                <div class='row'>";
                echo "<div class='col-md-2' align='right'>
                        <img src='".$photo."' width='65' height='90' alt='' class='img-thumbnail'>
                    </div>";
                echo "<cite class='text-muted'>
                    <div class='col-md-10'>
                        <div class='row'>
                            <div class='col-md-12'><b>".$nama." (NIP. ".$nip.")</b></div>                 
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>Pendidikan</div>
                            <div class='col-md-10'>: ".$pdk."</div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>Pangkat / Golru</div>
                            <div class='col-md-10'>: ".$golru." (".$pangkat.")</div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>TMT Jabatan</div>
                            <div class='col-md-10'>: ".tgl_indo($tmtjab)."</div>
                        </div>";
                echo "
                    </div>
                    </cite>";
                    
                echo "<div class='col-md-2'>
                            <form method='POST' action='../petajab/hapus_pemangku'>
                                <input type='hidden' name='id' id='id' maxlength='18' value='".$id."'>
                                <input type='hidden' name='nip' id='nip' maxlength='18' value='".$nip."'>
                                <button type='submit' class='btn btn-warning btn-outline btn-xs'>
                                <span class='fa fa-trash' aria-hidden='true'></span> Hapus Pemangku : ".$nama."
                                </button>
                            </form>
                        </div>";
                echo" </div>
                </small>
                <br/>";
            endforeach;

        } else if ($idjnsjab == "1") {
            $nip = $this->mpetajab->getnip($idjnsjab, $idjab, $idunker);
            if ($nip) {
                $nama = $this->mpegawai->getnama($nip);
                $pdk = $this->mpegawai->getpendidikan($nip);
                $idgolru = $this->mpetajab->getidgolru($nip);
                $golru = $this->mpegawai->getnamagolru($idgolru);
                $pangkat = $this->mpegawai->getnamapangkat($idgolru);
                //$tmtgolru = $this->mpegawai->gettmtkpterakhir($nip);
                $tmtjab = $this->mpegawai->gettmtjabterakhir($nip);

                $pemangku = $nama." (NIP. ".$nip.")";    
                $lokasifile = './photo/';
                $filename = "$nip.jpg";

                if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$nip.jpg";
                } else {
                    $photo = "../photo/nophoto.jpg";
                }

		echo "
                <small>
                <div class='row'>
                    <cite class='text-muted'>
                    <div class='col-md-10'>
                        <div class='row'>
                            <div class='col-md-12'><b>IDENTITAS PEMANGKU</b></div>                 
                        </div>
                        <div class='row'>
                            <div class='col-md-2 col-xs-2'>NIP.</div>
                            <div class='col-md-10 col-xs-10'>: ".$nip."</div>                        
                        </div>
                        <div class='row'>
                            <div class='col-md-2 col-xs-2'>Nama</div>
                            <div class='col-md-10 col-xs-10'>: ".$nama."</div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2 col-xs-2'>Pendidikan</div>
                            <div class='col-md-10 col-xs-10'>: ".$pdk."</div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2 col-xs-3'>Pangkat/Golru</div>
                            <div class='col-md-10 col-xs-9'>: ".$golru." (".$pangkat.")</div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2 col-xs-3'>TMT Jabatan</div>
                            <div class='col-md-10 col-xs-9'>: ".tgl_indo($tmtjab)."</div>
                        </div>";
                echo "
                    </div>
                    </cite>
                    <div class='col-md-2' align='right'>
                        <img src='".$photo."' width='75' height='110' alt='' class='img-thumbnail'>
                    </div>
                </div>
                </small>
                <br/>";
            } else {
                echo "<code><b> <cite class='text-muted'>TIDAK ADA PEMANGKU JABATAN</cite></b></code><br/><br/>";
            }
        }
        */         
        /*
        echo "<blockquote>
                <small>
                    <cite class='text-muted'>Kelas : ".$kelas."</cite>
                </small>
                <small>
                    <cite class='text-muted'>Jenis Jabatan : ".$jnsjab."</cite>
                </small>
                <small>
                    <cite class='text-muted'>Kebutuhan : ".$jml."</cite>
                </small>
                <small>
                    <cite class='text-muted'>Ketersediaan : ".$nama." NIP. (".$nip.")</cite>
                </small>
            </blockquote>";
            
        <div class="well well-sm" >
                <img src='<?php echo $photo; ?>' width='120' height='160' alt='<?php echo $v['nip']; ?>.jpg' class="img-thumbnail">

        */
        
    }

    function tambahpns() {

    }

    function hapus_peta(){
        $idpeta = addslashes($this->input->post('id'));
        $idjnsjab = addslashes($this->input->post('idjnsjab'));
        $idunker = addslashes($this->input->post('idunker'));
        $where = array('id' => $idpeta,
                       'fid_jnsjab' => $idjnsjab,
                       'fid_unit_kerja' => $idunker
                 );

        $nmunker = $this->munker->getnamaunker($idunker);
        if ($this->mpetajab->hapus_peta($where)) {
            $wherepemangku = array('fid_peta' => $idpeta);
            $this->mpetajab->hapus_petajab_pemangku($wherepemangku);
            $data['pesan'] = '<b>Sukses</b>, Peta jabatan <u>'.$nmunker.'</u> BERHASIL diupdate.';
            $data['jnspesan'] = 'alert alert-success';            
        } else {
            $data['pesan'] = '<b>GAGAL</b>, Peta jabatan <u>'.$nmunker.'</u> GAGAL diupdate.';
            $data['jnspesan'] = 'alert alert-warning';
        }

        $data['content'] = 'petajab/tampil';
        $data['unker'] = $this->munker->dd_unker()->result_array();
        $this->load->view('template', $data);
      }

      private function setPoisisButton($id)
      {
	$setuju = $this->mpetajab->cek_approve($id);
        if ($setuju == "N") {
        //if($this->session->userdata('level') === 'USER'):
            return '<button type="button" class="btn btn-primary btn-xs btn-outline" onclick="updatePosisi(\''.$id.'\')">Update<br/>Atasan</button>';
        //endif;
	}
      }

      private function setKomponenButton($id)
      {
	$setuju = $this->mpetajab->cek_approve($id);
	if ($setuju == "N") {
        //if($this->session->userdata('level') === 'USER'):
            return '<button type="button" class="btn btn-warning btn-xs btn-outline" onclick="updateKomponen(\''.$id.'\')">Update<br/>Komponen</button>';
        //endif;
	}
      }

      function caripeta() {
       $idunker = $this->input->get('idunker');
        ?>        
        <br/>
        <div class='row'>
        <div class='col-md-8 col-xs-12' align='left'>

            <?php
            $kaunit = $this->mpetajab->getkepalaunit($idunker)->result_array();
            //var_dump($kaunit);
            foreach($kaunit as $v):
                $jnsjabkaunit = $this->mpetajab->get_namajnsjab($v['fid_jnsjab']);
		if ($jnsjabkaunit == "STRUKTURAL") {
			$nmkaunit = $this->mpegawai->namajab("1", $v['fid_jabstruk']);
                        //$nmkaunit = $this->mpegawai->namaunor($v['fid_jabstruk']);
		} else if ($jnsjabkaunit == "FUNGSIONAL UMUM") {
			$nmkaunit = $this->mpegawai->namajab("2", $v['fid_jabfu']);
                } else if ($jnsjabkaunit == "FUNGSIONAL TERTENTU") {
			$nmkaunit = $this->mpegawai->namajab("3", $v['fid_jabft']);
                }
                //$nmkaunit = $this->mpegawai->namajab("1", $v['fid_jabstruk']);
                
		////$jmlstokkaunit = $this->mpetajab->getnip_jml($v['fid_jnsjab'], $v['fid_jabstruk'], $idunker);
                ?>
                <div class="panel panel-danger" align='left'>
                    <div class="panel-heading">
                    <?php
			$tpp = $v['tpp_pk'] + $v['tpp_bk'] + $v['tpp_kk'] + $v['tpp_tb'] + $v['tpp_kp'];
                        echo $nmkaunit."<br/><span class='text-muted'><code class='text-muted'><b>".$jnsjabkaunit."</b></code> <code>
			Kelas : ".$v['kelas']."</code> <code class='text-primary'>Kebutuhan : ".$v['jml_kebutuhan']."</code> <code class='text-warning'>
			Bezzeting : ".$v['jml_bezzeting']."</code> <code class='text-success'>TPP : Rp. ".number_format($tpp,2,",",".")."</code>
			</span></a><br/>";
                        echo "<span class='text text-primary'>Pemangku : </span>";
                        $getpemangku_pns = $this->mpetajab->get_pemangku_pns($v['id'])->result_array();
                        foreach ($getpemangku_pns as $pns) {
                                echo "<span class='text text-info'>".$pns['nama']." (NIP. ".$pns['nip'].")</span>";
                                echo " - ";
                        }
                        $getpemangku_pppk = $this->mpetajab->get_pemangku_pppk($v['id'])->result_array();
                        foreach ($getpemangku_pppk as $pppk) {
                                echo "<span class='text text-info'>".$pppk['nama']." (NIPPPK. ".$pppk['nipppk'].")</span>";
                                echo " - ";
                        }

			// Cek apakah Sub Koordinator
                        // echo "<br/><small>".$v['koord_subkoord']."</small>";
                    ?>
                    </div>
                    <!-- .panel-heading -->

                    <div class="panel-body">    
                    <?php  

            echo "
			<span class='text-primary'><b>KOMPONEN TPP</b></span>
                	<div class='row'>
                    		<div class='col-md-2 col-xs-12'>Prestasi Kerja : Rp. ".number_format($v['tpp_pk'],0,",",".")."</div>
                    		<div class='col-md-2 col-xs-12'>Beban Kerja : Rp. ".number_format($v['tpp_bk'],0,",",".")."</div>
                    		<div class='col-md-2 col-xs-12'>Kondisi Kerja : Rp. ".number_format($v['tpp_kk'],0,",",".")."</div>
                    		<div class='col-md-2 col-xs-12'>Tempat Bertugas : Rp. ".number_format($v['tpp_tb'],0,",",".")."</div>
                    		<div class='col-md-2 col-xs-12'>Kelangkaan Profesi : Rp. ".number_format($v['tpp_kp'],0,",",".")."</div>
                    		<div class='col-md-2 col-xs-12'>".$this->setKomponenButton($v['id'])."</div>
				<!-- <div class='col-md-2 col-xs-12'>".$this->setPoisisButton($v['id'])." ".$this->setKomponenButton($v['id'])."</div> -->
                	</div>";

                        $this->infopeta($v['id'], $v['fid_jnsjab'], $v['fid_jabstruk'], $v['fid_unit_kerja'], $v['kelas'], $v['jml_kebutuhan']);
                    ?>
                        <div class="panel-group" id="accordionl2">                            
                            <?php
                                // Level 2
                                $lv2 = $this->mpetajab->getbawahan($idunker, $v['id'])->result_array();
                                //var_dump($lv2);
                                foreach($lv2 as $l2):
                                    $jnsjabl2 = $this->mpetajab->get_namajnsjab($l2['fid_jnsjab']);
                                    if ($l2['fid_jnsjab'] == "1") {
                                        $idjab = $l2['fid_jabstruk'];
                                        $panel = "panel-info";
                                    } else if ($l2['fid_jnsjab'] == "2") {
                                        $idjab = $l2['fid_jabfu'];
                                        $panel = "panel-warning";
                                    } else if ($l2['fid_jnsjab'] == "3") {
                                        $idjab = $l2['fid_jabft'];
                                        $panel = "panel-default";
                                    }
                                    $nmjablv2 = $this->mpegawai->namajab($l2['fid_jnsjab'], $idjab);
                                    //$jmlstokv2 = $this->mpetajab->getnip_jml($l2['fid_jnsjab'], $idjab, $idunker);

                                    echo "<div class='panel ".$panel."'>";
                                    //echo "<div class='panel panel-default'>";
				    $tppl2 = $l2['tpp_pk'] + $l2['tpp_bk'] + $l2['tpp_kk'] + $l2['tpp_tb'] + $l2['tpp_kp'];
                                    echo "<div class='panel-heading'>
                                                    <a data-toggle='collapse' data-parent='#accordionl2' href='#lv".$l2['id']."' aria-expanded='false' class='collapsed'>".$nmjablv2."<br/><span class='text-muted'>
							<code class='text-muted'><b>".$jnsjabl2."</b></code> <code>Kelas : ".$l2['kelas']."</code> <code class='text-primary'>Kebutuhan : ".$l2['jml_kebutuhan']."</code> <code class='text-warning'>Bezzeting : ".$l2['jml_bezzeting']."</code> 
							<code class='text-success'>TPP : Rp. ".number_format($tppl2,2,",",".")."</code></span></a>";
                                    echo "<br/><span class='text text-primary'>Pemangku : </span>";
                                    $getpemangku_pns = $this->mpetajab->get_pemangku_pns($l2['id'])->result_array();
                                    foreach ($getpemangku_pns as $pns) {
                                        echo "<span class='text text-info'>".$pns['nama']." (NIP. ".$pns['nip'].")</span>";
                                        echo " - ";
                                    }
                                    $getpemangku_pppk = $this->mpetajab->get_pemangku_pppk($l2['id'])->result_array();
                                    foreach ($getpemangku_pppk as $pppk) {
                                        echo "<span class='text text-info'>".$pppk['nama']." (NIPPPK. ".$pppk['nipppk'].")</span>";
                                        echo " - ";
                                    }

				    // Cek apakah Sub Koordinator
                                    //echo "<br/><span class='text-default'><small>".$l2['koord_subkoord']."</small></span>";
				    echo "</div>"; // End Panel Heading

                                    echo "<div id='lv".$l2['id']."' class='panel-collapse collapse' aria-expanded='false'>
                                          <div class='panel-body'>";
				    echo "
                        		<span class='text-primary'><b>KOMPONEN TPP</b></span>
                        		<div class='row'>
                                		<div class='col-md-2 col-xs-12'>Prestasi Kerja : Rp. ".number_format($l2['tpp_pk'],0,",",".")."</div>
                                		<div class='col-md-2 col-xs-12'>Beban Kerja : Rp. ".number_format($l2['tpp_bk'],0,",",".")."</div>
                                		<div class='col-md-2 col-xs-12'>Kondisi Kerja : Rp. ".number_format($l2['tpp_kk'],0,",",".")."</div>
                                		<div class='col-md-2 col-xs-12'>Tempat Bertugas : Rp. ".number_format($l2['tpp_tb'],0,",",".")."</div>
                                		<div class='col-md-2 col-xs-12'>Kelangkaan Profesi : Rp. ".number_format($l2['tpp_kp'],0,",",".")."</div>
                                        <div class='col-md-2 col-xs-12'>".$this->setPoisisButton($l2['id'])." ".$this->setKomponenButton($l2['id'])."</div>
                        	        </div>";

                                    $this->infopeta($l2['id'], $l2['fid_jnsjab'], $l2['fid_jabstruk'], $v['fid_unit_kerja'], $l2['kelas'], $l2['jml_kebutuhan']);

                                            // PANEL LV3
                                            echo "<div class='panel-group' id='accordionl3'>";
                                                $lv3 = $this->mpetajab->getbawahan($idunker, $l2['id'])->result_array();
                                                foreach($lv3 as $l3):
                                                    $jnsjabl3 = $this->mpetajab->get_namajnsjab($l3['fid_jnsjab']);
                                                    if ($l3['fid_jnsjab'] == "1") {
                                                        $idjab = $l3['fid_jabstruk'];
                                                        $panel = "panel-info";
                                                    } else if ($l3['fid_jnsjab'] == "2") {
                                                        $idjab = $l3['fid_jabfu'];
                                                        $panel = "panel-warning";
                                                    } else if ($l3['fid_jnsjab'] == "3") {
                                                        $idjab = $l3['fid_jabft'];
                                                        $panel = "panel-success";
                                                    }
                                                    $nmjablv3 = $this->mpegawai->namajab($l3['fid_jnsjab'], $idjab);
                                                    //$jmlstokv3 = $this->mpetajab->getnip_jml($l3['fid_jnsjab'], $idjab, $idunker);
                                                    //echo $nmjablv2;
                                                    echo "<div class='panel ".$panel."'>";
						    $tppl3 = $l3['tpp_pk'] + $l3['tpp_bk'] + $l3['tpp_kk'] + $l3['tpp_tb'] + $l3['tpp_kp'];
                                                    echo "<div class='panel-heading'>
                                                          <a data-toggle='collapse' data-parent='#accordionl3' href='#lv".$l3['id']."' aria-expanded='false' class='collapsed'>".$nmjablv3."<br/><span class='text-muted'>
							<code class='text-muted'><b>".$jnsjabl3."</b></code> <code>Kelas : ".$l3['kelas']."</code> <code class='text-primary'>Kebutuhan : ".$l3['jml_kebutuhan']."</code> <code class='text-warning'>Bezzeting : ".$l3['jml_bezzeting']."</code>
						    	<code class='text-success'>TPP : Rp. ".number_format($tppl3,2,",",".")."</code>
						    </span></a>";

                                                   echo "<br/><span class='text text-primary'>Pemangku : </span>";
                                                   $getpemangku_pns = $this->mpetajab->get_pemangku_pns($l3['id'])->result_array();
                                                   foreach ($getpemangku_pns as $pns) {
                                                        echo "<span class='text text-info'>".$pns['nama']." (NIP. ".$pns['nip'].")</span>";
                                                        echo " - ";
                                                   }

                                                   $getpemangku_pppk = $this->mpetajab->get_pemangku_pppk($l3['id'])->result_array();
                                                   foreach ($getpemangku_pppk as $pppk) {
                                                        echo "<span class='text text-info'>".$pppk['nama']." (NIPPPK. ".$pppk['nipppk'].")</span>";
                                                        echo " - ";
                                                   }
              
						    // Cek apakah Sub Koordinator
						    //echo "<br/><span class='text-default'><small>".$l3['koord_subkoord']."</small></span>";
	
						    echo "</div>"; // End Panel Heading
                                                    echo "<div id='lv".$l3['id']."' class='panel-collapse collapse' aria-expanded='false'>
                                                          <div class='panel-body'>";
                                                    echo "
                                        		<span class='text-primary'><b>KOMPONEN TPP</b></span>
                                        		<div class='row'>
                                                		<div class='col-md-2 col-xs-12'>Prestasi Kerja : Rp. ".number_format($l3['tpp_pk'],0,",",".")."</div>
                                                		<div class='col-md-2 col-xs-12'>Beban Kerja : Rp. ".number_format($l3['tpp_bk'],0,",",".")."</div>
                                                		<div class='col-md-2 col-xs-12'>Kondisi Kerja : Rp. ".number_format($l3['tpp_kk'],0,",",".")."</div>
                                                		<div class='col-md-2 col-xs-12'>Tempat Bertugas : Rp. ".number_format($l3['tpp_tb'],0,",",".")."</div>
                                                		<div class='col-md-2 col-xs-12'>Kelangkaan Profesi : Rp. ".number_format($l3['tpp_kp'],0,",",".")."</div>
                                                        <div class='col-md-2 col-xs-12'>".$this->setPoisisButton($l3['id'])." ".$this->setKomponenButton($l3['id'])."</div>
                                        		</div>";

						    $this->infopeta($l3['id'], $l3['fid_jnsjab'], $l3['fid_jabstruk'], $v['fid_unit_kerja'], $l3['kelas'], $l3['jml_kebutuhan']);        

                                                    // PANEL LV4
                                                    echo "<div class='panel-group' id='accordionl4'>";
                                                        $lv4 = $this->mpetajab->getbawahan($idunker, $l3['id'])->result_array();
                                                        foreach($lv4 as $l4):
                                                            $jnsjabl4 = $this->mpetajab->get_namajnsjab($l4['fid_jnsjab']);
                                                            if ($l4['fid_jnsjab'] == "1") {
                                                                $idjab = $l4['fid_jabstruk'];
                                                                $panel = "panel-info";
                                                            } else if ($l4['fid_jnsjab'] == "2") {
                                                                $idjab = $l4['fid_jabfu'];
                                                                $panel = "panel-warning";
                                                            } else if ($l4['fid_jnsjab'] == "3") {
                                                                $idjab = $l4['fid_jabft'];
                                                                $panel = "panel-success";
                                                            }
                                                            $nmjablv4 = $this->mpegawai->namajab($l4['fid_jnsjab'], $idjab);
                                                            //$jmlstokv4 = $this->mpetajab->getnip_jml($l4['fid_jnsjab'], $idjab, $idunker);
                                                            
                                                            echo "<div class='panel ".$panel."'>";
							    $tppl4 = $l4['tpp_pk'] + $l4['tpp_bk'] + $l4['tpp_kk'] + $l4['tpp_tb'] + $l4['tpp_kp'];
                                                            echo "<div class='panel-heading'>
                                                                        <a data-toggle='collapse' data-parent='#accordionl4' href='#lv".$l4['id']."' aria-expanded='false' class='collapsed'>".$nmjablv4."<br/><span class='text-muted'>
									<code class='text-muted'><b>".$jnsjabl4."</b></code> <code>Kelas : ".$l4['kelas']."</code> <code class='text-primary'>Kebutuhan : ".$l4['jml_kebutuhan']."</code> <code class='text-warning'>Bezzeting : ".$l4['jml_bezzeting']."</code>
									<code class='text-success'>TPP : Rp. ".number_format($tppl4,2,",",".")."</code>
									</span></a>";

                                                           echo "<br/><span class='text text-primary'>Pemangku : </span>";
                                                           $getpemangku_pns = $this->mpetajab->get_pemangku_pns($l4['id'])->result_array();
                                                           foreach ($getpemangku_pns as $pns) {
                                                                echo "<span class='text text-info'>".$pns['nama']." (NIP. ".$pns['nip'].")</span>";
                                                                echo " - ";
                                                           }
                                                           $getpemangku_pppk = $this->mpetajab->get_pemangku_pppk($l4['id'])->result_array();
                                                           foreach ($getpemangku_pppk as $pppk) {
                                                                echo "<span class='text text-info'>".$pppk['nama']." (NIPPPK. ".$pppk['nipppk'].")</span>";
                                                                echo " - ";
                                                           }

							    // Cek apakah Sub Koordinator
                                    			    //echo "<br/><span class='text-default'><small>".$l4['koord_subkoord']."</small></span>";
							    echo "</div>"; // End Panel Heading
							
                                                            echo "<div id='lv".$l4['id']."' class='panel-collapse collapse' aria-expanded='false'>
                                                                  <div class='panel-body'>";
							    echo "
                                        			<span class='text-primary'><b>KOMPONEN TPP</b></span>
                                        				<div class='row'>
                                                			<div class='col-md-2 col-xs-12'>Prestasi Kerja : Rp. ".number_format($l4['tpp_pk'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Beban Kerja : Rp. ".number_format($l4['tpp_bk'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Kondisi Kerja : Rp. ".number_format($l4['tpp_kk'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Tempat Bertugas : Rp. ".number_format($l4['tpp_tb'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Kelangkaan Profesi : Rp. ".number_format($l4['tpp_kp'],0,",",".")."</div>
                                                            <div class='col-md-2 col-xs-12'>".$this->setPoisisButton($l4['id'])." ".$this->setKomponenButton($l4['id'])."</div>
                                        			</div>";

                                                            $this->infopeta($l4['id'], $l4['fid_jnsjab'], $idjab, $v['fid_unit_kerja'], $l4['kelas'], $l4['jml_kebutuhan']);        

                                                            // PANEL LV5
                                                            echo "<div class='panel-group' id='accordionl5'>";
                                                                $lv5 = $this->mpetajab->getbawahan($idunker, $l4['id'])->result_array();
                                                                foreach($lv5 as $l5):
                                                                    $jnsjabl5 = $this->mpetajab->get_namajnsjab($l5['fid_jnsjab']);
                                                                    if ($l5['fid_jnsjab'] == "1") {
                                                                        $idjab = $l5['fid_jabstruk'];
                                                                        $panel = "panel-info";
                                                                    } else if ($l5['fid_jnsjab'] == "2") {
                                                                        $idjab = $l5['fid_jabfu'];
                                                                        $panel = "panel-warning";
                                                                    } else if ($l5['fid_jnsjab'] == "3") {
                                                                        $idjab = $l5['fid_jabft'];
                                                                        $panel = "panel-default";
                                                                    }
                                                                    $nmjablv5 = $this->mpegawai->namajab($l5['fid_jnsjab'], $idjab);
                                                                    //$jmlstokv5 = $this->mpetajab->getnip_jml($l5['fid_jnsjab'], $idjab, $idunker);
                                                                    
                                                                    echo "<div class='panel ".$panel."'>";
								    $tppl5 = $l5['tpp_pk'] + $l5['tpp_bk'] + $l5['tpp_kk'] + $l5['tpp_tb'] + $l5['tpp_kp'];
                                                                    echo "<div class='panel-heading'>
                                                                                <a data-toggle='collapse' data-parent='#accordion5' href='#lv".$l5['id']."' aria-expanded='false' class='collapsed'>".$nmjablv5."<br/><span class='text-muted'><code class='text-muted'><b>".$jnsjabl5."</b></code> <code>Kelas : ".$l5['kelas']."</code> <code class='text-primary'>Kebutuhan : ".$l5['jml_kebutuhan']."</code> <code class='text-warning'>Bezzeting : ".$l5['jml_bezzeting']."</code>
										<code class='text-success'>TPP : Rp. ".number_format($tppl5,2,",",".")."</code>
										</span></a>";
                                                                    echo "<br/><span class='text text-primary'>Pemangku : </span>";
                                                                    $getpemangku_pns = $this->mpetajab->get_pemangku_pns($l5['id'])->result_array();
                                                                    foreach ($getpemangku_pns as $pns) {
                                                                        echo "<span class='text text-info'>".$pns['nama']." (NIP. ".$pns['nip'].")</span>";
                                                                        echo " - ";
                                                                    }
                                                                    $getpemangku_pppk = $this->mpetajab->get_pemangku_pppk($l5['id'])->result_array();
                                                                    foreach ($getpemangku_pppk as $pppk) {
                                                                        echo "<span class='text text-info'>".$pppk['nama']." (NIPPPK. ".$pppk['nipppk'].")</span>";
                                                                        echo " - ";
                                                                    }

								    // Cek apakah Sub Koordinator
                                    				    //echo "<br/><span class='text-default'><small>".$l5['koord_subkoord']."</small></span>";
								    echo "</div>"; // End Panel Heading

                                                                    echo "<div id='lv".$l5['id']."' class='panel-collapse collapse' aria-expanded='false'>
                                                                          <div class='panel-body'>";
								    echo "
                                        				<span class='text-primary'><b>KOMPONEN TPP</b></span>
                                        				<div class='row'>
                                                			<div class='col-md-2 col-xs-12'>Prestasi Kerja : Rp. ".number_format($l5['tpp_pk'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Beban Kerja : Rp. ".number_format($l5['tpp_bk'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Kondisi Kerja : Rp. ".number_format($l5['tpp_kk'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Tempat Bertugas : Rp. ".number_format($l5['tpp_tb'],0,",",".")."</div>
                                                			<div class='col-md-2 col-xs-12'>Kelangkaan Profesi : Rp. ".number_format($l5['tpp_kp'],0,",",".")."</div>
                                                            <div class='col-md-2 col-xs-12'>".$this->setPoisisButton($l5['id'])." ".$this->setKomponenButton($l5['id'])."</div>
                                        			    </div>";

                                                                    $this->infopeta($l5['id'], $l5['fid_jnsjab'], $idjab, $v['fid_unit_kerja'], $l5['kelas'], $l4['jml_kebutuhan']);        

                                                                    echo "</div>"; // end <div class='panel-body'> LV5
                                                                    echo "</div>"; // end lv".$l5['id']."'
                                                                    echo "</div>"; // end panel LV5

                                                                endforeach;
                                                            
                                                            echo "</div>"; 
                                                            // END LEVEL 5

                                                            echo "</div>"; // end <div class='panel-body'> LV4
                                                            echo "</div>"; // end lv".$l4['id']."'
                                                            echo "</div>"; // end panel LV4

                                                        endforeach;
                                                    
                                                    echo "</div>"; 
                                                    // END LEVEL 4 


                                                    echo "</div>"; // end <div class='panel-body'> LV3
                                                    echo "</div>"; // end lv".$l3['id']."'
                                                    echo "</div>"; // end panel LV3

                                                endforeach;
                                            
                                            echo "</div>"; 
                                            // END LEVEL 3 

                                    echo "</div>"; // end <div class='panel-body'> LV2
                                    echo "</div>"; // end lv".$l2['id']."'
                                    echo "</div>"; // end panel LV2

                                endforeach;
                            ?>
                            
                        </div>
                    </div>
                </div>

            <?php
                endforeach;
            ?>
            </div> <!-- end div kolom kiri -->    
            <div class='col-md-4 col-xs-4' align='left'>
                <div class='row'>
                    <div class='col-md-4 col-xs-4' aling='right'>
                        <button type="button" class="btn btn-outline btn-info" data-toggle="modal" data-target="#tampiltambahjab">
				<span class="fa fa-plus" aria-hidden="true"></span> Tambah Jabatan</button>
                    <?php
                        /*
                        echo "<form method='POST' action='../takah/rwytakah'>
                                <input type='hidden' name='idunker' id='idunker' maxlength='18' value='".$idunker."'>
                                <button type='submit' class='btn btn-info btn-sm'>
                                <span class='fa fa-plus' aria-hidden='true'></span> Tambah Jabatan
                                </button>
                            </form>";
                        */
                    ?>
                    </div>
		    <!--	
                    <div class='col-md-4 col-xs-4' aling='right'>
                        <button type="button" class="btn btn-sm btn-outline btn-info" data-toggle="modal" data-target="#tampilsetjfujft">
			<span class="fa fa-user" aria-hidden="true"></span> Set JFU/JFT</button>                    
                    </div>
                    <div class='col-md-4 col-xs-4' aling='right'>
                        <form method='POST' name='formcetaksk' action='../petajab/cetakpeta' target='_blank'>
                          <input type='hidden' name='idunker' id='idunker' value='<?php echo $idunker; ?>'>
                          
                          <p align="right">
                            <button type="submit" class="btn btn-primary btn-sm">&nbsp
                            <span class="fa fa-print" aria-hidden="true"></span>Cetak Peta
                            </button>
                          </p>
                          </form>
                    </div>
		    -->
                </div>
                <br/>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class="panel panel-info" align='left'>
                            <div class="panel-heading">
                                REKAPITULASI
                            </div>
                            <div class="panel-body">
                            
                            <?php
				$peta = $this->mpetajab->get_peta_byunker($idunker)->result_array();
				$jmlkb = 0;
				$jmlpns = 0;
				$jmlpppk = 0;
				foreach($peta as $p) {
					$jmlkb = $jmlkb + $p['jml_kebutuhan'];
					$pns = $this->mpetajab->get_pemangku_pns($p['id'])->num_rows;
					$pppk = $this->mpetajab->get_pemangku_pppk($p['id'])->num_rows;
					$jmlpns = $jmlpns + $pns;
					$jmlpppk = $jmlpppk + $pppk;
				}
				$jmlkosong = $jmlkb - $jmlpns - $jmlpppk;

				echo "<small>
                                      <div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-3'>";
                                        echo "JML KEBUTUHAN";
                                        echo "<b><h5>".$jmlkb."</h5></b>";
                                    echo "</div>";
                                    echo "<div class='col-md-3 col-xs-3'>";
                                        echo "BEZZETING PNS";
                                        echo "<b><h5>".$jmlpns."</h5></b>";
                                    echo "</div>";
                                    echo "<div class='col-md-3 col-xs-3'>";
                                        echo "BEZZTING PPPK";
                                        echo "<b><h5>".$jmlpppk."</h5></b>";
                                    echo "</div>";
                                    echo "<div class='col-md-3 col-xs-3'>";
                                        echo "JABATAN KOSONG";
                                        echo "<b><h5>".$jmlkosong."</h5></b>";
                                    echo "</div>";
                                echo "</div>
                                      </small>";
                                echo "<br/>";
			 
			      
                                $jml2a = $this->mpetajab->jmljab_eselon($idunker, "II/A");
                                $jml2b = $this->mpetajab->jmljab_eselon($idunker, "II/B");
				$jmljpt = $jml2a + $jml2b;
                                $jml3a = $this->mpetajab->jmljab_eselon($idunker, "III/A");
                                $jml3b = $this->mpetajab->jmljab_eselon($idunker, "III/B");
				$jmladm = $jml3a + $jml3b;
                                $jml4a = $this->mpetajab->jmljab_eselon($idunker, "IV/A");
                                $jml4b = $this->mpetajab->jmljab_eselon($idunker, "IV/B");
				$jmlpengawas = $jml4a + $jml4b;
                                $jmljfu = $this->mpetajab->jmljab_jfu($idunker);
                                $jmljft = $this->mpetajab->jmljab_jft($idunker);
                                $totjab = $jmljpt + $jmladm + $jmlpengawas + $jmljfu + $jmljft;

                                $bezz2a = $this->mpetajab->jmlbezz_eselon($idunker, "II/A");
                                $bezz2b = $this->mpetajab->jmlbezz_eselon($idunker, "II/B");
				$bezzjpt = $bezz2a + $bezz2b;
                                $bezz3a = $this->mpetajab->jmlbezz_eselon($idunker, "III/A");
                                $bezz3b = $this->mpetajab->jmlbezz_eselon($idunker, "III/B");
				$bezzadm = $bezz3a + $bezz3b;
                                $bezz4a = $this->mpetajab->jmlbezz_eselon($idunker, "IV/A");
                                $bezz4b = $this->mpetajab->jmlbezz_eselon($idunker, "IV/B");
				$bezzpengawas = $bezz4a + $bezz4b;
                                $bezzjfu = $this->mpetajab->jmlbezz_jfu($idunker);
                                $bezzjft = $this->mpetajab->jmlbezz_jft($idunker);
                                $totbezz = $bezzjpt + $bezzadm + $bezzpengawas + $bezzjfu + $bezzjft;

                                $kosjpt = $jmljpt - $bezzjpt;
                                $kospengawas = $jmlpengawas - $bezzpengawas;
                                $kosadm = $jmladm - $bezzadm;
                                $kosjfu = $jmljfu - $bezzjfu;
                                $kosjft = $jmljft - $bezzjft;
                                $totkos = $kosjpt + $kosadm + $kospengawas + $kosjfu + $kosjft;

                                //echo "<br/>";

                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-3' align='left'><code class='text-primary'>Kelompok</code></div>";
                                    echo "<div class='col-md-3 col-xs-3'><code class='text-info'>Kebutuhan</code></div>";
                                    echo "<div class='col-md-3 col-xs-3'><code class='text-success'>Bezzeting</code></div>";
                                    echo "<div class='col-md-3 col-xs-3'><code class='text-danger'>Kosong</code></div>";
                                echo "</div>";
                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-4' align='left'><small>JPT</small></div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$jmljpt."</div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$bezzjpt."</div>";
                                    echo "<div class='col-md-3 col-xs-2'>".$kosjpt."</div>";
                                echo "</div>";
                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-4' align='left'><small>Administrator</small></div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$jmladm."</div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$bezzadm."</div>";
                                    echo "<div class='col-md-3 col-xs-2'>".$kosadm."</div>";
                                echo "</div>";
                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-4' align='left'><small>Pengawas</small></div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$jmlpengawas."</div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$bezzpengawas."</div>";
                                    echo "<div class='col-md-3 col-xs-2'>".$kospengawas."</div>";
                                echo "</div>";
                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-4' align='left'><small>JFU</small></div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$jmljfu."</div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$bezzjfu."</div>";
                                    echo "<div class='col-md-3 col-xs-2'>".$kosjfu."</div>";
                                echo "</div>";                                
                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-3 col-xs-4' align='left'><small>JFT</small></div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$jmljft."</div>";
                                    echo "<div class='col-md-3 col-xs-3'>".$bezzjft."</div>";
                                    echo "<div class='col-md-3 col-xs-2'>".$kosjft."</div>";
                                echo "</div>";
                                echo "</div>";

                                //echo "<br/>";
                                echo "<div class='row' align='center'>";
                                    echo "<div class='col-md-12' align='left'><b>ASN TANPA PETA JABATAN</b></div>";
				echo "</div>";
                                $pns_tp = $this->mpetajab->get_tnpapeta_pns($idunker)->result_array();
				$pppk_tp = $this->mpetajab->get_tnpapeta_pppk($idunker)->result_array();
                                echo "<small>";
                                $baris = 1;
                                foreach($pns_tp as $ptp)
                                {
				  $pns = $this->mpegawai->getnama($ptp['nip']);
                                  echo "<div class='row' align='left'>
				  	<div class='col-md-12 col-xs-12' align='left'>
					<span class='text text-info'>- ".$pns." (NIP. ".$ptp['nip'].")</span></div></div>";
				  //echo "<ul><li>".$pns." (NIP. ".$ptp['nip'].")</li></ul>";						
                                }
				foreach($pppk_tp as $ktp)
                                {
                                  $pppk = $this->mpppk->getnama($ktp['nipppk']);
                                  echo "<div class='row' align='left'>
                                        <div class='col-md-12 col-xs-12' align='left'>
					<span class='text text-success'>- ".$pppk." (NIPPPK. ".$ktp['nipppk'].")</span></div></div>";
                                  //echo "<ul><li>".$pppk." (NIPPPK. ".$ktp['nipppk'].")</li></ul>";
                                }
                                echo "</small>";

                                echo "<br/>";
                                echo "<div class='row' align='center'>";                                
                                    echo "<div class='col-md-12' align='left'><b>JABATAN KOSONG / KURANG</b></div>";
                                    //echo "<div class='col-md-1' align='left'></div>";
                                    echo "<div class='col-md-9 col-xs-9' align='center'><code class='text-danger'>JABATAN</code></div>";
                                    echo "<div class='col-md-1 col-xs-1' align='center'><code class='text-danger'>KLS</code></div>";
                                    echo "<div class='col-md-1 col-xs-1' align='center'><code class='text-danger'>KB</code></div>";;
                                    echo "<div class='col-md-1 col-xs-1' align='center'><code class='text-danger'>BZ</code></div>";

                                echo "</div>";                                

                                //echo "<blockquote style='font-size: 9px;'>";
                                $jab = $this->mpetajab->get_peta_byunker($idunker)->result_array();
                                echo "<small>";
				$baris = 1;
                                foreach($jab as $jk)
                                {
                                    $jml_pemangku_pns = $this->mpetajab->get_pemangku_pns($jk['id'])->num_rows;
                                    $jml_pemangku_pppk = $this->mpetajab->get_pemangku_pppk($jk['id'])->num_rows;
				    $jml_pemangku = $jml_pemangku_pns+$jml_pemangku_pppk;
				    if ($jk['jml_kebutuhan'] > $jml_pemangku) {	
					echo "<div class='row' align='center'>";
					if ($baris % 2 == 1) {
                                    		echo "<ul class='text-default'>";
					} else { 
						echo "<ul class='text-info'>";
					}
                                    	echo "<li>";
                                    	$namajab = $this->mpetajab->get_namajab($jk['id']);
                                    	$unoratasan = $this->mpetajab->get_namaunoratasan($jk['id']);
                                    	echo "<div class='col-md-9 col-xs-9' align='left'>".$namajab."<br/>[".$unoratasan."]</div>";
                                    	echo "<div class='col-md-1 col-xs-1' align='left'>".$jk['kelas']."</div>";
                                    	echo "<div class='col-md-1 col-xs-1' align='left'>".$jk['jml_kebutuhan']."</div>";
                                    	echo "<div class='col-md-1 col-xs-1' align='left'>".$jml_pemangku."</div>";
					echo "</li></ul>";
                                    	echo "</div>";
					$baris++;
				    }
                                }
                                echo "</small>";

                            ?>
                            </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end div kolom kanan -->  
        </div> <!-- end div row -->  

        <!-- Modal Tambah Jabatan -->
        <div id="tampiltambahjab" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">TAMBAH JABATAN</h4>
              </div>
              <!-- body modal -->
              <div class="modal-body" align="left" style="padding:10px;width:100%;height:100%;">   
                <form method='POST' name='formtambahjabatan' style='padding-top:8px' action='../petajab/tmbpeta_aksi'>
                    <div class='row'>                                                
                        <div class='col-md-12'>
                            <div class="form-group input-group">    
                            <span class="input-group-addon">Unit Kerja</span>
                            <?php
                                $nmunker = $this->munker->getnamaunker($idunker);
                            ?>
                            <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $nmunker; ?>" disabled="">
                            </div>                        
                        </div>
                    </div>
                    <div class='row'>                                                
                        <div class='col-md-8'>
                            <div class="form-group input-group">    
                            <span class="input-group-addon" style="width:140px;text-align: left;">Jenis Jabatan</span>
                            <?php
                                $jnsjab = $this->mpetajab->jnsjab()->result_array();
                            ?>
                            <input type="hidden" id='id_unker' name='id_unker' value="<?php echo $idunker; ?>">
                            <select class="form-control" name="id_jnsjab" id="id_jnsjab" required onChange="showDataTambahJab(this.value, formtambahjabatan.id_unker.value)">
                              <?php
                              echo "<option value='' selected>-- Jenis Jabatan --</option>";
                              foreach($jnsjab as $jj)
                              {
                                echo "<option value='".$jj['id_jenis_jabatan']."'>".$jj['nama_jenis_jabatan']."</option>";
                              }
                              ?>
                            </select>
                            </div>                        
                        </div>
                    </div>
                    <div class='row'>  
                        <div class='col-md-12'>
                            <div id='tampiljab'></div>
                        </div>
                    </div>
                    <div class='row'>  
                        <div class='col-md-12'>
                            <div id='tampildtljab'></div>
                        </div>
                    </div>
                </form>
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Tambah Jabatan -->

        <!-- Modal Set JFU/JFT -->
        <div id="tampilsetjfujft" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <h4 class="modal-title">Setting PNS Pemangku Jabatan JFU/JFT</h4>
              </div>
              <!-- body modal -->
              <div class="modal-body" align="left" style="padding:10px;width:100%;height:450px;">   
                <form method='POST' name='formsetjf' style='padding-top:8px' action='../petajab/setpemangku_aksi'>
                    <div class='row'>                                                
                        <div class='col-md-12'>
                            <div class="form-group input-group">    
                            <span class="input-group-addon">Unit Kerja</span>
                            <?php
                                $nmunker = $this->munker->getnamaunker($idunker);
                            ?>
                            <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $nmunker; ?>" disabled="" style='font-size: 12px !important;'>
                            </div>                        
                        </div>
                    </div>
                    <div class='row'>                                                
                        <div class='col-md-8'>
                            <div class="form-group input-group">    
                            <span class="input-group-addon" style="width:140px;text-align: left;">Jenis Jabatan</span>
                            <?php
                                $jnsjab = $this->mpetajab->jnsjab()->result_array();
                            ?>
                            <input type="hidden" id='id_unker' name='id_unker' value="<?php echo $idunker; ?>">
                            <select class="form-control" name="id_jnsjab" id="id_jnsjab" required onChange="showDataSetjf(this.value, formsetjf.id_unker.value)" style='font-size: 12px !important;'>
                              <?php
                              echo "<option value='' selected>-- Jenis Jabatan --</option>";
                              foreach($jnsjab as $jj)
                              {
                                if ($jj['nama_jenis_jabatan'] != "STRUKTURAL")
                                echo "<option value='".$jj['id_jenis_jabatan']."'>".$jj['nama_jenis_jabatan']."</option>";
                              }
                              ?>
                            </select>
                            </div>                        
                        </div>
                    </div>
                    <div class='row'>  
                        <div class='col-md-12'>
                            <div id='tampiljabSetjf'></div>
                        </div>
                    </div>
                    <div class='row'>  
                        <div class='col-md-12'>
                            <div id='tampildtlSetjf'></div>
                        </div>
                    </div>
                </form>
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Set JFU/JFT -->

        <!-- Modal Set JFU/JFT -->
        <div id="tampileditjab" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <h4 class="modal-title">Edit Jabatan<?php echo $idunker;?></h4>
              </div>
              <!-- body modal -->
              <div class="modal-body" align="left" style="padding:10px;width:100%;height:450px;">   
                
              </div> <!-- End Modal Body -->
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Set JFU/JFT -->    
        
        <!-- Modal Edit Komponen TPP -->
        <div id="modelEditKomponen" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <h4 class="modal-title">Edit Komponen TPP</h4>
              </div>
              <form method='POST' name='formsetkomponen' id="formsetkomponen" action='<?= base_url('petajab/setkomponen_aksi') ?>'>
              <!-- body modal -->
              <div class="modal-body">   
                <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
                <input type='hidden' name='idpetajab' id='idpetajab' maxlength='10' value='' >
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Kelas Jabatan</span>
                            <input type="number" class="form-control" min="1" id='kelas' name='kelas' 
                    onkeydown="return numbersonly(this, event);" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Keterangan</span>
                            <input type="text" class="form-control" id='keterangan' name='keterangan' required/>
                        </div>
                    </div>
                </div>
                <hr>
                <blockquote>
                <div class='row'>
                <div class='col-md-4'>
                            <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Beban Kerja</span>
                            <input type="text" class="form-control" id='tpp_bk' name='tpp_bk' value="" 
                    onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                            </div>
                        </div>
                <div class='col-md-4'>
                            <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Prestasi Kerja</span>
                            <input type="text" class="form-control" id='tpp_pk' name='tpp_pk' value=""
                                onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                            </div>
                        </div>
                <div class='col-md-4'>
                            <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Kondisi Kerja</span>
                            <input type="text" class="form-control" id='tpp_kk' name='tpp_kk' value=""
                    onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                            </div>
                        </div>
                <div class='col-md-4'>
                            <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Tempat Bertugas</span>
                            <input type="text" class="form-control" id='tpp_tb' name='tpp_tb' value=""
                    onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                            </div>
                        </div>
                <div class='col-md-4'>
                            <div class="form-group input-group">
                            <span class="input-group-addon" style="text-align: left;">Kelangkaan Profesi</span>
                            <input type="text" class="form-control" id='tpp_kp' name='tpp_kp' value=""
                    onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                            </div>
                        </div>
                    </div> <!-- End Row -->
                </blockquote> <!-- End Blockquote -->
              </div> <!-- End Modal Body -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm"><span class="fa fa-save" aria-hidden="true"></span> Simpan & Update</button>
              </div>
            </form>
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Edit Posisi Jabatan --> 

        <!-- Modal Edit Posisi Jabatan -->
        <div id="modelEditPosisiJabatan" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <h4 class="modal-title">Edit Posisi Jabatan</h4>
              </div>
              <form method='POST' name='formsetposisi' id="formsetposisi" action='<?= base_url('petajab/setposisi_aksi') ?>'>
              <!-- body modal -->
              <div class="modal-body">   
                <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
                <input type='hidden' name='idpetajab' id='idpetajab' maxlength='10' value='' >
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group input-group">    
                            <span class="input-group-addon">Jenis Jabatan</span>
                            <?php
                                $jnsjab = $this->mpetajab->jnsjab()->result_array();
                            ?>
                            <select class="form-control" name="id_jnsjab" id="id_jnsjab" required onchange="listJabatan(this.value, formsetposisi.idunker.value)">
                              <?php
                              echo "<option value='' selected>-- Jenis Jabatan --</option>";
                              foreach($jnsjab as $jj)
                              {
                                echo "<option value='".$jj['id_jenis_jabatan']."'>".$jj['nama_jenis_jabatan']."</option>";
                              }
                              ?>
                            </select>
                        </div> 
                    </div>
                </div>
                <div class='row'>                                                
                    <div class='col-md-12'>
                        <div id="listJabatan"></div>                      
                    </div>
                </div>
              </div> <!-- End Modal Body -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-save" aria-hidden="true"></span> Simpan</button>
              </div>
            </form>
            </div> <!-- End Modal Content -->
          </div> <!-- End Modal Dialog -->
        </div> <!-- End Modal Edit Posisi Jabatan --> 
    <?php
    }
    
    function detailkomponen($id) {
        $q = $this->mpetajab->detailKomponenJabatan($id);
        $row = $q->row();
        $data = [
            'id' => $row->id,
            'pk' => $row->tpp_pk,
            'bk' => $row->tpp_bk,
            'kk' => $row->tpp_kk,
            'tb' => $row->tpp_tb,
            'kp' => $row->tpp_kp,
            'kelas' => $row->kelas,
            'koord_subkoord' => $row->koord_subkoord
        ];  
        echo json_encode(['data' => $data]);
    }

    function setkomponen_aksi() {
        $post = $this->input->post();
        $update = [
            'koord_subkoord' => $post['keterangan'],
            'kelas' => $post['kelas'],
            'tpp_pk' => addslashes(str_replace(".", "", $post['tpp_pk'])),
            'tpp_bk' => addslashes(str_replace(".", "", $post['tpp_bk'])),
            'tpp_kk' => addslashes(str_replace(".", "", $post['tpp_kk'])),
            'tpp_tb' => addslashes(str_replace(".", "", $post['tpp_tb'])),
            'tpp_kp' => addslashes(str_replace(".", "", $post['tpp_kp'])),
        ];

        $whr = [
            'id' => $post['idpetajab']
        ];

        $db = $this->db->update('ref_peta_jabatan', $update, $whr);
        if($db) {
            $data['pesan'] = '<b>Sukses</b>, Update Data Komponen TPP BERHASIL';
            $data['jnspesan'] = 'alert alert-success';
        } else {
            $data['pesan'] = '<b>Sukses</b>, Update Data Komponen TPP GAGAL';
            $data['jnspesan'] = 'alert alert-danger';
        }

        $this->tampil();
        // echo json_encode($post);
    }


    function listJabatan() {
        $idjnsjab = $this->input->get('id');
        $idunker = $this->input->get('unker');

        if($idjnsjab == "1") {
            $jabstruk = $this->mpetajab->jabstruk_all($idunker)->result_array();
            $html = '<div class="row">                                                
                <div class="col-md-12">
                    <div class="form-group input-group">
                    <span class="input-group-addon">Jabatan Struktural</span>
                        <select class="form-control" name="id_jab" id="id_jab" required>
                            <option value="" selected>-- Jabatan Struktural --</option>';
                            foreach($jabstruk as $js)
                            {
                                $html .= "<option value='".$js['id_jabatan']."'>".$js['nama_jabatan']."</option>";
                            }

            $html .='  </select>
                    </div>                        
                </div>
            </div>';
            
            echo json_encode($html);

        } elseif($idjnsjab == "2") {
            $jabfu = $this->mpetajab->getjabfu_perunker($idunker)->result_array();
            $html = '<div class="row">                                                
                <div class="col-md-12">
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Fungsional Umum</span>
                        <select class="form-control" name="id_jab" id="id_jab" required">
                        <option value="" selected>-- Pilih Jabatan --</option>';
                          foreach($jabfu as $ju)
                          {
                            if ($ju['koord_subkoord'] == NULL) {
                                $atasan = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
                                $html .= "<option value='".$ju['id_jabfu']."'>".$ju['nama_jabfu']." (Atasan : ".$atasan.")</option>";    
                            } else if ($ju['koord_subkoord'] != NULL) {
                                $atasan = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
                                $html .="<option value='".$ju['id_jabfu']."'>".$ju['nama_jabfu']."-".$ju['koord_subkoord']."</option>";
                            }
                          }
            $html .= '</select>
                    </div>                        
                </div>
            </div>';
            echo json_encode($html);

        } elseif($idjnsjab == "3") {
            $jabft = $this->mpetajab->getjabft_perunker($idunker)->result_array();
            $html = '<div class="row">                                                
                <div class="col-md-12">
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Fungsional Tertentu</span>
                        <select class="form-control" name="id_jab" id="id_jab" required>
                        <option value="" selected>-- Pilih Jabatan --</option>';
                          
                          foreach($jabft as $jt)
                          {
                            if ($jt['koord_subkoord'] == NULL) {
                                $atasan = $this->mpetajab->get_namajabstruk($jt['fid_atasan']);
                                $html .= "<option value='".$jt['id_jabft']."'>".$jt['nama_jabft']." (Atasan : ".$atasan.")</option>";    
                            } else if ($jt['koord_subkoord'] != NULL) {
                                $atasan = $this->mpetajab->get_namajabstruk($jt['fid_atasan']);
                                $html .= "<option value='".$jt['id_jabft']."'>".$jt['nama_jabft']."-".$jt['koord_subkoord']."</option>";
                            }
                          }

            $html .= '</select>
                    </div>                        
                </div>
            </div>';
            echo json_encode($html);
        }

    }

    function setposisi_aksi()
    {
        $post = $this->input->post();

        $id = $post['idpetajab'];
        
        $unker_id = $post['idunker'];
        $jnsjab_id = $post['id_jnsjab'];
        $jab_id = $post['id_jab'];


        if($jnsjab_id === "1") {
            $db_jst = $this->db->select('id')->from('ref_peta_jabatan')->where('fid_jabstruk', $jab_id)->get();
            $count = $db_jst->num_rows();
            
            $idpeta = ($count > 0) ? $db_jst->row()->id : 0;

        } elseif($jnsjab_id === "2") {
            $db_jabfu = $this->db->select('id')->from('ref_peta_jabatan')->where('fid_jabfu', $jab_id)->get();
            $count = $db_jabfu->num_rows();
            
            $idpeta = ($count > 0) ? $db_jabfu->row()->id : 0;
        } elseif($jnsjab_id === "3") {
            $db_jabft = $this->db->select('id')->from('ref_peta_jabatan')->where('fid_jabft', $jab_id)->get();
            $count = $db_jabft->num_rows();
            
            $idpeta = ($count > 0) ? $db_jabft->row()->id : 0;
        }
        
        $data = [
            'id_jab' => $jab_id,
            'id_peta' => $idpeta,
            'id_unker' => $unker_id
        ];

        $db = $this->db->update('ref_peta_jabatan', ['fid_atasan' => $idpeta], ['fid_unit_kerja' => $unker_id, 'id' => $id]);
        if($db) {
            $msg = ['status' => 'Berhasil Update', 'data' => $data];
        } else {
            $msg = ['status' => 'Gagal Update', 'data' => null];
        }

        echo json_encode($msg);
    }

    function tampiljabSetjf() {        
        $idjnsjab = $this->input->get('idjnsjab');
        $idunker = $this->input->get('idunker');

        if ($idjnsjab == "2") { // Fungsional Umum
            ?>
            <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='10' value='<?php echo $idjnsjab; ?>' >
            <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Fungsional Umum</span>
                        <?php
                        $jabfu = $this->mpetajab->getjabfu_perunker($idunker)->result_array();
                        ?>
                        <select class="form-control" name="id_jabfu-atasan" id="id_jabfu-atasan" required onChange="showDataDetailSetjf(formsetjf.idjnsjab.value, formsetjf.idunker.value, this.value)" style='font-size: 12px !important;'>
                          <?php                          
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          echo "<optgroup label='Jabatan Kosong'>";
                          foreach($jabfu as $ju)
                          {
                            $atasan = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
                            $cek_full = $this->mpetajab->cek_jmlpemangkufull($idunker, $idjnsjab, $ju['id_jabfu'], $ju['fid_atasan']);
                            if (!$cek_full) {
                                echo "<option value='".$ju['id_jabfu']."-".$ju['fid_atasan']."'>".$ju['nama_jabfu']." (Atasan : ".$atasan.")</option>";
                            }
                          }
                          echo "</optgroup>";
                          echo "<optgroup label='Jabatan Penuh'>";
                          foreach($jabfu as $ju)
                          {
                            $atasan = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
                            $cek_full = $this->mpetajab->cek_jmlpemangkufull($idunker, $idjnsjab, $ju['id_jabfu'], $ju['fid_atasan']);
                            if ($cek_full) {
                                echo "<option value='".$ju['id_jabfu']."-".$ju['fid_atasan']."'>".$ju['nama_jabfu']." (Atasan : ".$atasan.")</option>";
                            }
                          }
                          echo "</optgroup>";
                        ?>
                        </select>
                    </div>                        
                </div>
            </div>      
            <?php
        } else if ($idjnsjab == "3") { // Fungsional Umum
            ?>
            <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='10' value='<?php echo $idjnsjab; ?>' >
            <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Fungsional Tertentu</span>
                        <?php
                        $jabft = $this->mpetajab->getjabft_perunker($idunker)->result_array();
                        ?>
                        <select class="form-control" name="id_jabft-atasan" id="id_jabft-atasan" required onChange="showDataDetailSetjf(formsetjf.idjnsjab.value, formsetjf.idunker.value, this.value)" style='font-size: 10px !important;'>
                          <?php
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          foreach($jabft as $jt)
                          {
                            if ($jt['koord_subkoord'] == NULL) {
                                $atasan = $this->mpetajab->get_namajabstruk($jt['fid_atasan']);
                                echo "<option value='".$jt['id_jabft']."-".$jt['fid_atasan']."'>".$jt['nama_jabft']." (Atasan : ".$atasan.")</option>";    
                            } else if ($jt['koord_subkoord'] != NULL) {
                                $atasan = $this->mpetajab->get_namajabstruk($jt['fid_atasan']);
                                echo "<option value='".$jt['id_jabft']."-".$jt['fid_atasan']."'>".$jt['nama_jabft']."-".$jt['koord_subkoord']."</option>";
                            }
                          }
                        ?>
                        </select>
                    </div>                        
                </div>
            </div>
            
            <?php

        }
    }

    function tampildetailSetjf() {
        $idjnsjab = $this->input->get('idjnsjab');
        $idunker = $this->input->get('idunker');
        $jabnatasan = $this->input->get('idjab'); // string berisi id jabatan dan id atasan, pecah string terlebih dahulu
        $pos = strpos($jabnatasan, '-');
        $idjab =  substr($this->input->get('idjab'), 0, $pos);
        $idatasan = substr($this->input->get('idjab'), $pos+1, strlen($jabnatasan));
        
        $idpeta = $this->mpetajab->get_idpeta($idunker, $idjnsjab, $idjab, $idatasan);
        $jmlkebutuhan = $this->mpetajab->get_jmlkebutuhan($idpeta);
        $jmlpemangku = $this->mpetajab->get_jmlpemangku($idpeta);

        ?>
        <div class='row'>                                                
            <div class='col-md-5'>
                <h5 class='text text-info'>Jumlah Kebutuhan : <?php echo $jmlkebutuhan;?></h5>
            </div>
            <div class='col-md-5'>
                <h5 class='text text-success'> Jumlah Pemangku : <?php echo $jmlpemangku;?></h5>
            </div>
        </div>
        <input type="hidden" id='id_atasan' name='id_atasan' value="<?php echo $idatasan; ?>">
        
        <?php            
        if ($jmlpemangku == $jmlkebutuhan) {
            echo "<h5 class='text text-danger'>Setting PNS Pemangku JabFU / JabFT tidak dapat dilakukan</h5>";
        } else {
            if ($idjnsjab == "2") { // JFU
                ?>
                <div class='row'>                                                
                    <div class='col-md-10'>
                        <div class="form-group input-group">    
                        <span class="input-group-addon" style="width:140px;text-align: left;">Pilih PNS</span>
                        <?php
                            $pnsjf = $this->mpetajab->getpnsjf($idjnsjab, $idunker);
                            ?>
                            <select class="form-control" name="nip_pnsjf" id="nip_pnsjf" style='font-size: 12px !important;'>
                              <?php
                              echo "<option value='' selected>-- Pilih PNS --</option>";
                              foreach($pnsjf as $p)
                              {
                                echo "<option value='".$p['nip']."'>NIP. ".$p['nip']."-".$p['nama']."</option>";
                              }
                            ?>
                            </select>
                        </div>                        
                    </div>
                </div>
                <div class='row'>                                                
                    <div class='col-md-12' align='center'>
                        <button type="submit" class="btn btn-outline btn-success">
                            <span class="fa fa-save" aria-hidden="true"></span> Simpan PNS JFU/JFT
                        </button>
                    </div>
                </div>
                <?php
            } else if ($idjnsjab == "3") { // JFT
                ?>
                <div class='row'>                                                
                    <div class='col-md-10'>
                        <div class="form-group input-group">    
                        <span class="input-group-addon" style="width:140px;text-align: left;">Pilih PNS</span>
                        <?php
                            $pnsjf = $this->mpetajab->getpnsjf($idjnsjab, $idunker);
                            ?>
                            <select class="form-control" name="nip_pnsjf" id="nip_pnsjf" style='font-size: 12px !important;'>
                              <?php
                              echo "<option value='' selected>-- Pilih PNS --</option>";
                              foreach($pnsjf as $p)
                              {
                                echo "<option value='".$p['nip']."'>NIP. ".$p['nip']."-".$p['nama']."</option>";
                              }
                            ?>
                            </select>
                        </div>                        
                    </div>
                </div>
                <div class='row'>                                                
                    <div class='col-md-12' align='center'>
                        <button type="submit" class="btn btn-outline btn-success">
                            <span class="fa fa-save" aria-hidden="true"></span> Simpan PNS JFU/JFT
                        </button>
                    </div>
                </div>
                <?php
            }
        }
    }
 

    function tampiljab() {        
        $idjnsjab = $this->input->get('idjnsjab');
        $idunker = $this->input->get('idunker');

        if ($idjnsjab == "1") { // Struktural
            ?>
            <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='10' value='<?php echo $idjnsjab; ?>' >
            <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Struktural</span>
                        <?php
                        $jabstruk = $this->mpetajab->jabstruk($idunker)->result_array();
                        ?>
                        <select class="form-control" name="id_jab" id="id_jab" required>
                          <?php
                          echo "<option value='' selected>-- Jabatan Struktural --</option>";
                          foreach($jabstruk as $js)
                          {
                            echo "<option value='".$js['id_jabatan']."'>".$js['nama_jabatan']."</option>";
                        }
                        ?>
                        </select>
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-4'>
                    <div class="form-group input-group">    
                        <span class="input-group-addon" style="width:140px;text-align: left;">Apakah Jabatan Kepala Unit ?</span>
                        <div class="form-control">
                                <input type="checkbox" id='ka_unit' name='ka_unit' value="Y">
                        </div>
                    </div>                        
                </div>
                <div class='col-md-6' align='left'>
                        <code>Centang jika jabatan tersebut adalah Kepala SKPD / Unit Kerja</code>
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">    
                    <span class="input-group-addon" style="width:140px;text-align: left;">Atasan Langsung</span>
                        <?php
                        $jabatasan = $this->mpetajab->jabstruk_peta($idunker)->result_array();
                        if ($jabatasan) {
                        ?>
                        <select class="form-control" name="id_atasan" id="id_atasan" required>
                          <?php
                          echo "<option value='' selected>-- Jabatan Struktural --</option>";
                          foreach($jabatasan as $ja)
                          {
                            echo "<option value='".$ja['id']."'>".$ja['nama_jabatan']."</option>";
                          }
                        ?>
                        </select>
                        <?php
                        } else {
                            $kaunit = $this->mpetajab->get_kepalaunit()->result_array();
                        ?>
                            <select class="form-control" name="id_atasan" id="id_atasan">
                            <?php
                                echo "<option value='' selected>-- Jabatan Struktural --</option>";
                                echo "<option value='1'>BUPATI BALANGAN</option>";
                                foreach($kaunit as $ku)
                                {   
                                    $nmunker = $this->munker->getnamaunker($ku['fid_unit_kerja']);
                                    echo "<option value='".$ku['id']."'>".$ku['nama_jabatan']."-".$nmunker."</option>";
                                }
                            ?>                             
                            </select>
                        <?php
                        }
                        ?>
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-4'>
                    <div class="form-group input-group">    
                    <span class="input-group-addon" style="width:140px;text-align: left;">Kelas Jabatan Struktural</span>
                    <input type="text" class="form-control" id='kelas' name='kelas' value="" onkeydown="return numbersonly(this, event);" />
                    </div>                        
                </div>
            </div>
	    <div class='row'>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jumlah Kebutuhan</span>
                    <input type="text" class="form-control" id='kebutuhan' name='kebutuhan' value="" onkeydown="return numbersonly(this, event);" />
                    </div>
                </div>
            </div>

	    <h5><span class='text-info'>Komponen TPP</span></h5>
	    <blockquote>
	    <div class='row'>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Beban Kerja</span>
                    <input type="text" class="form-control" id='tpp_bk' name='tpp_bk' value="" 
			onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Prestasi Kerja</span>
                    <input type="text" class="form-control" id='tpp_pk' name='tpp_pk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Kondisi Kerja</span>
                    <input type="text" class="form-control" id='tpp_kk' name='tpp_kk' value=""
			onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Tempat Bertugas</span>
                    <input type="text" class="form-control" id='tpp_tb' name='tpp_tb' value=""
			onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Kelangkaan Profesi</span>
                    <input type="text" class="form-control" id='tpp_kp' name='tpp_kp' value=""
			onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
            </div> <!-- End Row -->
	    </blockquote> <!-- End Blockquote -->

            <div class='row'>                                                
                <div class='col-md-12' align='center'>
                    <button type="submit" class="btn btn-outline btn-success">
                        <span class="fa fa-save" aria-hidden="true"></span> Simpan Jabatan
                    </button>
                </div>
            </div>
            <?php
        } else if ($idjnsjab == "2") { // Fungsional Umum
            ?>
            <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='10' value='<?php echo $idjnsjab; ?>' >
            <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Fungsional Umum</span>
                        <?php
                        $jabfu = $this->mpetajab->jabfu()->result_array();
                        ?>
                        <select class="form-control" name="id_jabfu" id="id_jabfu" required onChange="showDataDetailTambahJab(formtambahjabatan.idjnsjab.value, formtambahjabatan.idunker.value, this.value)">
                          <?php
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          foreach($jabfu as $ju)
                          {
                            echo "<option value='".$ju['id_jabfu']."'>".$ju['nama_jabfu']."</option>";
                        }
                        ?>
                        </select>
                    </div>                        
                </div>
            </div>
            
            <?php

        } else if ($idjnsjab == "3") { // Fungsional Tertentu
            ?>
            <input type='hidden' name='idjnsjab' id='idjnsjab' maxlength='10' value='<?php echo $idjnsjab; ?>' >
            <input type='hidden' name='idunker' id='idunker' maxlength='10' value='<?php echo $idunker; ?>' >
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jabatan Fungsional Tertentu</span>
                        <?php
                        $jabft = $this->mpetajab->jabft()->result_array();
                        ?>
                        <select class="form-control" name="id_jabft" id="id_jabft" required onChange="showDataDetailTambahJab(formtambahjabatan.idjnsjab.value, formtambahjabatan.idunker.value, this.value)">
                          <?php
                          echo "<option value='' selected>-- Pilih Jabatan --</option>";
                          foreach($jabft as $jt)
                          {
                            echo "<option value='".$jt['id_jabft']."'>".$jt['nama_jabft']."</option>";
                        }
                        ?>
                        </select>
                    </div>                        
                </div>
            </div>
            
            <?php

        }
    }

    function tampildetailjab() {
        $idjnsjab = $this->input->get('idjnsjab');
        $idunker = $this->input->get('idunker');
        $idjab = $this->input->get('idjab');

        if ($idjnsjab == "2") { // JFU
            ?>
            <div class='row'> 
                <div class='col-md-12'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Keterangan</span>
                    <textarea class="form-control" rows="2" id='kosubko' name='kosubko' value=""></textarea>
                    </div>
                </div>
                <div class='col-md-12'>
                    <div class="form-group input-group">            
                        <span class="input-group-addon" style="width:140px;text-align: left;">Atasan Langsung</span>  
                        <select class="form-control" name="id_atasan" id="id_atasan" >          
                        <?php
                        echo "<option value='' selected>-- Atasan Langsung --</option>";
                        $jabatasan = $this->mpetajab->jabstruk_peta($idunker)->result_array();
                        if ($jabatasan) {                          
                          foreach($jabatasan as $ja)
                          {
                            echo "<option value='".$ja['id']."'>".$ja['nama_jabatan']."</option>";
                          }                        
			}
			//$jabfu = $this->mpetajab->getjabfu_perunker($idunker)->result_array();
                        //if ($jabfu) {
                        //    foreach($jabfu as $ju)
                        //    {
                        //      $atasanju = $this->mpetajab->get_namajabstruk($ju['fid_atasan']);
                        //      echo "<option value='".$ju['id']."'>".$ju['nama_jabfu']." (Atasan : ".$atasanju.")</option>";
                        //    }
                        //}                              
                        $jabft = $this->mpetajab->getjabft_perunker($idunker)->result_array();
                        if ($jabft) {
                            foreach($jabft as $jt)
                            {
                              $atasanjt = $this->mpetajab->get_namajab($jt['fid_atasan']);
                              echo "<option value='".$jt['id']."'>".$jt['nama_jabft']." (Atasan : ".$atasanjt.")</option>";
                            }
                        }
                        ?>                        
                        </select>
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-5'>
                    <div class="form-group input-group">    
                    <?php
                        $kelasjab = $this->mkinerja->get_kelasjabfu_idkelas($idjab);
                    ?>
                    <span class="input-group-addon" style="width:140px;text-align: left;">Kelas JFU</span>
		    <input type="text" class="form-control" id='kelasjfu' name='kelasjfu' value="" onkeydown="return numbersonly(this, event);" />
                    <!-- <input type="text" class="form-control" id="kelasjfu" type="text" placeholder="<?php //echo $kelasjab; ?>" /> -->
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-5'>
                    <div class="form-group input-group">    
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jumlah Kebutuhan</span>
                    <input type="text" class="form-control" id='kebutuhan' name='kebutuhan' value="">
                    </div>                        
                </div>
            </div>

	    <h5><span class='text-info'>Komponen TPP</span></h5>
            <blockquote>
            <div class='row'>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Beban Kerja</span>
                    <input type="text" class="form-control" id='tpp_bk' name='tpp_bk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Prestasi Kerja</span>
                    <input type="text" class="form-control" id='tpp_pk' name='tpp_pk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Kondisi Kerja</span>
                    <input type="text" class="form-control" id='tpp_kk' name='tpp_kk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Tempat Bertugas</span>
                    <input type="text" class="form-control" id='tpp_tb' name='tpp_tb' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Kelangkaan Profesi</span>
                    <input type="text" class="form-control" id='tpp_kp' name='tpp_kp' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
            </div> <!-- End Row -->
            </blockquote> <!-- End Blockquote -->

            <div class='row'>                                                
                <div class='col-md-12' align='center'>
                    <button type="submit" class="btn btn-outline btn-success">
                        <span class="fa fa-save" aria-hidden="true"></span> Simpan Jabatan
                    </button>
                </div>
            </div>
            <?php
        } else if ($idjnsjab == "3") { // JFT
            ?>
	    <div class='row'>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                        <span class="input-group-addon" style="width:140px;text-align: left;">Apakah Jabatan Kepala Unit ?</span>
                        <div class="form-control">
                                <input type="checkbox" id='ka_unit' name='ka_unit' value="Y">
                        </div>
                    </div>
                </div>
                <div class='col-md-6' align='left'>
                        <code>Centang jika jabatan tersebut adalah Kepala SKPD / Unit Kerja</code>
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">    
                    <span class="input-group-addon" style="text-align: left;">Keterangan</span>
                    <textarea class="form-control" rows="2" id='kosubko' name='kosubko' value=""></textarea>
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-12'>
                    <div class="form-group input-group">    
                        <span class="input-group-addon" style="width:140px;text-align: left;">Atasan Langsung</span>
                        <select class="form-control" name="id_atasan" id="id_atasan" >
                        <?php                        
                        echo "<option value='' selected>-- Jabatan Struktural --</option>";
                        $jabatasan = $this->mpetajab->jabstruk_peta($idunker)->result_array();	
                        if ($jabatasan) {
                          foreach($jabatasan as $ja)
                          {
                            echo "<option value='".$ja['id']."'>".$ja['nama_jabatan']."</option>";
                          }
                        } 
			$jabft = $this->mpetajab->getjabft_perunker($idunker)->result_array();
                        if ($jabft) {
                            foreach($jabft as $jt)
                            {
                              $atasanjt = $this->mpetajab->get_namajab($jt['fid_atasan']);
                              echo "<option value='".$jt['id']."'>".$jt['nama_jabft']." (Atasan : ".$atasanjt.")</option>";
                            }
                        }
                        ?>
                        </select>
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-5'>
                    <div class="form-group input-group">    
                    <?php
                        $kelasjab = $this->mkinerja->get_kelasjabft_idkelas($idjab);
                    ?>
                    <span class="input-group-addon" style="width:140px;text-align: left;">Kelas JFT</span>
		    <input type="text" class="form-control" id='kelasjft' name='kelasjft' value="" onkeydown="return numbersonly(this, event);" />
                    <!-- <input type="text" class="form-control" id="kelasjft" type="text" placeholder="<?php echo $kelasjab; ?>" /> -->
                    </div>                        
                </div>
            </div>
            <div class='row'>                                                
                <div class='col-md-5'>
                    <div class="form-group input-group">    
                    <span class="input-group-addon" style="width:140px;text-align: left;">Jumlah Kebutuhan</span>
                    <input type="text" class="form-control" id='kebutuhan' name='kebutuhan' value="">
                    </div>                        
                </div>
            </div>

            <h5><span class='text-info'>Komponen TPP</span></h5>
	    <blockquote>
            <div class='row'>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Beban Kerja</span>
                    <input type="text" class="form-control" id='tpp_bk' name='tpp_bk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
		<div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Prestasi Kerja</span>
                    <input type="text" class="form-control" id='tpp_pk' name='tpp_pk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Kondisi Kerja</span>
                    <input type="text" class="form-control" id='tpp_kk' name='tpp_kk' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Tempat Bertugas</span>
                    <input type="text" class="form-control" id='tpp_tb' name='tpp_tb' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group input-group">
                    <span class="input-group-addon" style="text-align: left;">Kelangkaan Profesi</span>
                    <input type="text" class="form-control" id='tpp_kp' name='tpp_kp' value=""
                        onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
                    </div>
                </div>
            </div> <!-- End Row -->
            </blockquote> <!-- End Blockquote -->

            <div class='row'>                                                
                <div class='col-md-12' align='center'>
                    <button type="submit" class="btn btn-outline btn-success">
                        <span class="fa fa-save" aria-hidden="true"></span> Simpan Jabatan
                    </button>
                </div>
            </div>
            <?php
        }
    }

    function tmbpeta_aksi() {
        $idunker = addslashes($this->input->post('idunker'));
        $idjnsjab = addslashes($this->input->post('idjnsjab'));
        
        $ka_unit = addslashes($this->input->post('ka_unit'));
        if ($ka_unit != "Y") {
            $ka_unit = "N";            
        }
	// else if ($ka_unit == "Y") { 
        //    $id_atasan = null;
        //}
        $id_atasan = addslashes($this->input->post('id_atasan'));

        $kelas = addslashes($this->input->post('kelas'));  
        $kebutuhan = addslashes($this->input->post('kebutuhan'));  

        if ($idjnsjab == "1") {
            $id_jabstruk = addslashes($this->input->post('id_jab'));
            $id_jabfu = null;
            $id_jabft = null;
            $kosubko = null;
            $jmlbezz = $this->mpetajab->getnip_jml($idjnsjab, $id_jabstruk, $idunker);
	    $tpp_pk = addslashes(str_replace(".", "", $this->input->post('tpp_pk')));
            $tpp_bk = addslashes(str_replace(".", "", $this->input->post('tpp_bk')));
            $tpp_kk = addslashes(str_replace(".", "", $this->input->post('tpp_kk')));
            $tpp_tb = addslashes(str_replace(".", "", $this->input->post('tpp_tb')));
            $tpp_kp = addslashes(str_replace(".", "", $this->input->post('tpp_kp')));
        } else if ($idjnsjab == "2") {
            $id_jabstruk = null;
            $id_jabfu = addslashes($this->input->post('id_jabfu'));
            $id_jabft = null;
            $kosubko = strtoupper(addslashes($this->input->post('kosubko')));
            //$kelas = $this->mkinerja->get_kelasjabfu_idkelas($id_jabfu);
	    $kelas = addslashes($this->input->post('kelasjfu'));
	    $jmlbezz = 0;
            //$jmlbezz = $this->mpetajab->getnip_jml($idjnsjab, $id_jabfu, $idunker);
            $tpp_pk = addslashes(str_replace(".", "", $this->input->post('tpp_pk')));
            $tpp_bk = addslashes(str_replace(".", "", $this->input->post('tpp_bk')));
            $tpp_kk = addslashes(str_replace(".", "", $this->input->post('tpp_kk')));
            $tpp_tb = addslashes(str_replace(".", "", $this->input->post('tpp_tb')));
            $tpp_kp = addslashes(str_replace(".", "", $this->input->post('tpp_kp')));
        } else if ($idjnsjab == "3") {
            $id_jabstruk = null;
            $id_jabfu = null;
            $kosubko = strtoupper(addslashes($this->input->post('kosubko')));
            $id_jabft = addslashes($this->input->post('id_jabft'));
            //$kelas = $this->mkinerja->get_kelasjabft_idkelas($id_jabft);
	    $kelas = addslashes($this->input->post('kelasjft'));
            $jmlbezz = 0;
	    //$jmlbezz = $this->mpetajab->getnip_jml($idjnsjab, $id_jabft, $idunker);
            $tpp_pk = addslashes(str_replace(".", "", $this->input->post('tpp_pk')));
            $tpp_bk = addslashes(str_replace(".", "", $this->input->post('tpp_bk')));
            $tpp_kk = addslashes(str_replace(".", "", $this->input->post('tpp_kk')));
            $tpp_tb = addslashes(str_replace(".", "", $this->input->post('tpp_tb')));
            $tpp_kp = addslashes(str_replace(".", "", $this->input->post('tpp_kp')));
        }

        $user = $this->session->userdata('nip');
        $tgl_aksi = $this->mlogin->datetime_saatini();

        $data = array(      
          'fid_unit_kerja'  => $idunker,
          'fid_jnsjab'      => $idjnsjab,
          'fid_jabstruk'    => $id_jabstruk,
          'fid_jabfu'       => $id_jabfu,
          'fid_jabft'       => $id_jabft,          
          'kepala_unit'     => $ka_unit,
          'koord_subkoord'  => $kosubko,
          'fid_atasan'      => $id_atasan,
          'kelas'           => $kelas,
          'jml_kebutuhan'   => $kebutuhan,
          'jml_bezzeting'   => $jmlbezz,
	  'tpp_pk'	    => $tpp_pk, 
	  'tpp_bk'	    => $tpp_bk,
	  'tpp_kk'	    => $tpp_kk,
	  'tpp_tb'	    => $tpp_tb,
	  'tpp_kp'	    => $tpp_kp,
          'created_by'      => $user,
          'created_at'      => $tgl_aksi
          );

        $nmunker = $this->munker->getnamaunker($idunker);

        if ($this->mpetajab->input_petajab($data))
            {
	      // Set Pemangku KHUSUS STRUKTURAL
              if ($idjnsjab == "1") {
                $nip = $this->mpetajab->getnippegawai($idjnsjab, $id_jabstruk, $idunker);
                if ($nip) {
                    $idpeta = $this->mpetajab->get_idpeta($idunker, $idjnsjab, $id_jabstruk, $id_atasan);                    
                }                  
		
		        if ($nip) {
                	$datapemangku = array(
                  		'fid_peta'  => $idpeta,
                  		'nip'      => $nip
                	);
                	$this->mpetajab->input_setpemangku($datapemangku);
              	}
              }
	      /* 
		else if ($idjnsjab == "2") {
                $nip = $this->mpetajab->getnippegawai($idjnsjab, $id_jabfu, $idunker);
                if ($nip) {
                    $idpeta = $this->mpetajab->get_idpeta($idunker, $idjnsjab, $id_jabfu, $id_atasan);
                }                  
              } else if ($idjnsjab == "3") {
                $nip = $this->mpetajab->getnippegawai($idjnsjab, $id_jabft, $idunker);
                if ($nip) {
                    $idpeta = $this->mpetajab->get_idpeta($idunker, $idjnsjab, $id_jabft, $id_atasan);
                }                  
              }
	      */

              $data['pesan'] = '<b>Sukses</b>, Peta jabatan <u>'.$nmunker.'</u> berhasil ditambah.';
              $data['jnspesan'] = 'alert alert-success';
            } else {
              $data['pesan'] = '<b>Gagal !</b>, Peta jabatan <u>'.$nmunker.'</u> gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
              $data['jnspesan'] = 'alert alert-danger';
            }
               
        
        $data['content'] = 'petajab/tampil';
        $data['unker'] = $this->munker->dd_unker()->result_array();
        $this->load->view('template', $data);
    }


    function setpemangku_aksi() {
        $idunker = addslashes($this->input->post('idunker'));
        $idjnsjab = addslashes($this->input->post('idjnsjab'));
        $nip_pnsjf = addslashes($this->input->post('nip_pnsjf'));        
    
        if ($idjnsjab == "2") {
            $id_jabfu = addslashes($this->input->post('id_jabfu-atasan'));           
            $pos = strpos($id_jabfu, '-');
            $idjab =  substr($id_jabfu, 0, $pos);
            $idatasan = substr($id_jabfu, $pos+1, strlen($id_jabfu)); 
            $idpeta = $this->mpetajab->get_idpeta($idunker, $idjnsjab, $idjab, $idatasan);
        } else if ($idjnsjab == "3") {
            $id_jabft = addslashes($this->input->post('id_jabft-atasan'));
            $pos = strpos($id_jabft, '-');
            $idjab =  substr($id_jabft, 0, $pos);
            $idatasan = substr($id_jabft, $pos+1, strlen($id_jabft));
            $idpeta = $this->mpetajab->get_idpeta($idunker, $idjnsjab, $idjab, $idatasan);
        }

        $data = array(      
          'fid_peta'  => $idpeta,
          'nip'      => $nip_pnsjf
          );
       
        $cekadadata = $this->mpetajab->cek_adapemangku($nip_pnsjf);
        $nama = $this->mpegawai->getnama($nip_pnsjf);
        $nmjab = $this->mpegawai->namajab($idjnsjab, $idjab);
        
        if ($cekadadata >= 1) {
            $where = array(      
              'nip'  => $nip_pnsjf
            );
            $hapus = $this->mpetajab->hapus_petajab_pemangku($where); // hapus pemangku jabatan sebelumny terdahulu
        }    
        
        if ($this->mpetajab->input_setpemangku($data))
        {            
            // Update jumlah Bezzeting table Peta
            $jmlpemangku = $this->mpetajab->get_jmlpemangku($idpeta);
            $databezz = array(      
              'jml_bezzeting'   => $jmlpemangku
            );

            $wherebezz = array(      
              'id'  => $idpeta
            );
            $this->mpetajab->edit_peta($wherebezz, $databezz);

            $data['pesan'] = '<b>Sukses</b>, Update Data <u>'.$nama.'</u> dengan jabatan '.$nmjab.' BERHASIL';
            $data['jnspesan'] = 'alert alert-success';
        } else {
            $data['pesan'] = '<b>Gagal !</b>, Update Data <u>'.$nama.'</u> dengan jabatan '.$nmjab.' GAGAL';
            $data['jnspesan'] = 'alert alert-danger';
        }
                       
        
        $data['content'] = 'petajab/tampil';
        $data['unker'] = $this->munker->dd_unker()->result_array();
        $this->load->view('template', $data);
    }

    function hapus_pemangku() {
        $id = addslashes($this->input->post('id'));
        $nip = addslashes($this->input->post('nip'));
        $where = array('fid_peta' => $id,
                       'nip' => $nip
                 );

        $nama = $this->mpegawai->getnama($nip);
        if ($this->mpetajab->hapus_petajab_pemangku($where)) {

            // Update jumlah Bezzeting table Peta
            $jmlpemangku = $this->mpetajab->get_jmlpemangku($id);
            $databezz = array(      
              'jml_bezzeting'   => $jmlpemangku
            );

            $wherebezz = array(      
              'id'  => $id
            );
            $this->mpetajab->edit_peta($wherebezz, $databezz);

            $data['pesan'] = '<b>Sukses</b>, Pemangku A.n. <u>'.$nama.'</u> BERHASIL dihapus.';
            $data['jnspesan'] = 'alert alert-success';            
        } else {
            $data['pesan'] = '<b>GAGAL</b>, Pemangku A.n. <u>'.$nama.'</u> GAGAL dihapus.';
            $data['jnspesan'] = 'alert alert-warning';
        }

        $data['content'] = 'petajab/tampil';
        $data['unker'] = $this->munker->dd_unker()->result_array();
        $this->load->view('template', $data);
    }

    public function cetakpeta()  
    {
        $res['data'] = $this->datacetak->datacetakpetajab();
        $this->load->view('petajab/cetakpeta',$res);    
    }
}
