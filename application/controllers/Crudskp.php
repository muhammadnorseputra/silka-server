<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CrudSkp extends CI_Controller{

	var $nip;
	var $nilaiprilaku;

	function __construct(){
		parent::__construct();		
      		$this->load->helper('form');
		//$this->load->model('m_skp');
		$this->load->helper('url');
      		$this->load->model('mpegawai');
		$this->load->model('mkinerja');
      		$this->load->model('mhukdis');		
                $this->load->model('mwsbkn');

      		$this->load->model('mskp');
      		$this->load->helper('fungsipegawai');
      		$this->load->helper('fungsitanggal');		
	 	$this->load->helper('security');
                $this->load->helper('fungsiwsbkn');
 
    	 	$this->load->model('munker');

		$this->load->helper('file');
	
		$this->load->library('fpdf');
	}

	function index(){		
	}

	function tambah(){
		$nip = $this->input->post('nip');    
		$data['unker'] = $this->munker->unker()->result_array();
		$data['golru'] = $this->mpegawai->golru()->result_array();
	    $data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
	    $data['nip'] = $nip;
	    $data['content'] = 'inskp';
    	$this->load->view('template', $data);
	}

 	function tambah2021(){
            $nip = $this->input->post('nip');
            $data['unker'] = $this->munker->unker()->result_array();
            $data['golru'] = $this->mpegawai->golru()->result_array();
            $data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();
            $data['nip'] = $nip;
            $data['content'] = 'inskp2021';
            $this->load->view('template', $data);
        }

	function tambahintegrasi(){
		$nip = $this->input->post('nip');    
		$data['unker'] = $this->munker->unker()->result_array();
		$data['golru'] = $this->mpegawai->golru()->result_array();
	    	$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
	    	$data['nip'] = $nip;
	    	$data['content'] = 'inskp-integrasi';
		$this->load->view('template', $data);
	}

	function tambah_aksi(){
		$nip = addslashes($this->input->post('nip'));
		$jenis = addslashes($this->input->post('jenis'));
		$tahun = addslashes($this->input->post('tahun'));
		$nilaiskp = addslashes($this->input->post('nilaiskp'));
		$orientasipelayanan = addslashes($this->input->post('orientasipelayanan'));
		$integritas = addslashes($this->input->post('integritas'));
		$komitmen = addslashes($this->input->post('komitmen'));
		$disiplin = addslashes($this->input->post('disiplin'));
		$kerjasama = addslashes($this->input->post('kerjasama'));
		$kepemimpinan = addslashes($this->input->post('kepemimpinan'));
		if ($kepemimpinan == '') {
			$kepemimpinan = 0;
		}			

		$jnspp = $this->input->post('jnspp');
		$namapp = addslashes($this->input->post('namapp'));
		$jabatanpp = addslashes($this->input->post('jabatanpp'));
		if ($jnspp == 'PNS') {
			$nippp = addslashes($this->input->post('nippp'));
			$id_golrupp = addslashes($this->input->post('id_golrupp'));
			//$id_unkerpp = addslashes($this->input->post('id_unkerpp'));
			//$nama_unkerpp = $this->munker->getnamaunker($id_unkerpp);	

			// nama unker ambil dari textbox 
			$nama_unkerpp = strtoupper(addslashes($this->input->post('namaunkerpp')));
		} else if ($jnspp == 'NONPNS') {
			$nippp = '';
			$id_golrupp = '';
			$nama_unkerpp = addslashes($this->input->post('unkerpp'));
		}
		

		$jnsapp = $this->input->post('jnsapp');
		$namaapp = addslashes($this->input->post('namaapp'));
		$jabatanapp = addslashes($this->input->post('jabatanapp'));

		if ($jnsapp == 'PNS') {			
			$nipapp = addslashes($this->input->post('nipapp'));
			$id_golruapp = addslashes($this->input->post('id_golruapp'));
			//$id_unkerapp = addslashes($this->input->post('id_unkerapp'));
			//$nama_unkerapp = $this->munker->getnamaunker($id_unkerapp);

			// nama unker ambil dari textbox
			$nama_unkerapp = strtoupper(addslashes($this->input->post('namaunkerapp')));
		} else if ($jnsapp == 'NONPNS') {
			$nipapp = '';
			$id_golruapp = '';
			$nama_unkerapp = addslashes($this->input->post('unkerapp'));
		} 
				
		$user_entri = $this->session->userdata('nip');
	    $tgl_entri = $this->mlogin->datetime_saatini();

		// menentukan pembagi nilai prilaku kerja
		// jika kepemimpinan kosong (tenaga staf, jfu, jft), prilaku kerja dibagi 5
		if (($kepemimpinan == '') || ($kepemimpinan == 0)) {
			$nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama)/5);
		// atau prilaku kerja dibagi 6 (kepemimpinan tidak kosong)
		} else {
			$nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan)/6);
		}

		//menentukan nilai prestasi kerja
		$nilai_prestasi_kerja = (0.6*$nilaiskp) + (0.4*$nilai_prilaku_kerja);

		$data = array(
			'nip' 					=> $nip,
			'jns_skp' 				=> $jenis,
			'tahun' 				=> $tahun,
			'nilai_skp' 			=> $nilaiskp,
			'orientasi_pelayanan' 	=> $orientasipelayanan,
			'integritas' 			=> $integritas,
			'komitmen' 				=> $komitmen,
			'disiplin' 				=> $disiplin,
			'kerjasama'				=> $kerjasama,
			'kepemimpinan' 			=> $kepemimpinan,
			'nilai_prilaku_kerja' 	=> $nilai_prilaku_kerja,
			'nilai_prestasi_kerja'	=> $nilai_prestasi_kerja,
			'nip_pp' 				=> $nippp,
			'nama_pp'				=> $namapp,
			'fid_golru_pp' 			=> $id_golrupp,
			'jab_pp' 				=> $jabatanpp,
			'unor_pp' 				=> $nama_unkerpp,
			'nip_app' 				=> $nipapp,
			'nama_app' 				=> $namaapp,
			'fid_golru_app' 		=> $id_golruapp,
			'jab_app' 				=> $jabatanapp,
			'unor_app' 				=> $nama_unkerapp,
			'created_at' 			=> $tgl_entri,
			'created_by' 			=> $user_entri
			);
		//$this->mskp->input_data($data);

		if ($this->mskp->cekskp($data['nip'], $data['tahun']) == 0) {
			// eksekusi model mskp untuk input data
			if ($this->mskp->input_data($data))
			{
				//redirect('../pegawai/berhasil'); //jika berhasil maka akan ditampilkan view berhasil
				//return true;

				// tampilkan view rwyskp
				//$data['nip'] = $nip;
				$data['pesan'] = '<b>Sukses</b>, Data SKP Tahun '.$data['tahun'].' berhasil ditambah';
				$data['jnspesan'] = 'alert alert-success';
				//$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
			    //$data['content'] = 'rwyskp';
			    //$this->load->view('template', $data);	
			} else {
				$data['pesan'] = '<b>Gagal !</b>, Data SKP Tahun '.$data['tahun'].' gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
				$data['jnspesan'] = 'alert alert-danger';
			}			
		} else {
			$data['pesan'] = '<b>Data rangkap !</b>, Data SKP Tahun '.$data['tahun'].' gagal ditambah.';
			$data['jnspesan'] = 'alert alert-danger';
			//$data['pesan'] = '';
			//$data['jnspesan'] = '';
		}

		// tampilkan view rwyskp
		$data['nip'] = $nip;
		$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
	    $data['content'] = 'rwyskp';
	    $this->load->view('template', $data);	


		/*
		if ($this->mskp->input_data($data))
		{
			//redirect('../pegawai/berhasil'); //jika berhasil maka akan ditampilkan view berhasil
			//return true;

			// tampilkan view rwyskp
			//$data['nip'] = $nip;
			$data['pesan'] = '<b>Data berhasil ditambah</b>';
			$data['jnspesan'] = 'alert alert-success';
			//$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
		    //$data['content'] = 'rwyskp';
		    //$this->load->view('template', $data);	
		} else {
			//redirect('../pegawai/gagal'); //jika gagal maka akan ditampilkan view gagal
			//return true;

			//$data['nip'] = $nip;
			$data['pesan'] = 'Data gagal ditambah';			
			$data['jnspesan'] = 'alert alert-danger';
			//$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
		    //$data['content'] = 'rwyskp';
		    //$this->load->view('template', $data);	
		}
		*/		
	}

	function tambah_aksi_integrasi(){
		$nip = addslashes($this->input->post('nip'));
		$jenis = addslashes($this->input->post('jenis'));
		$tahun = addslashes($this->input->post('tahun'));
		$jnsjab = $this->mkinerja->get_jnsjab($nip);
        	$keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
		
		if ($jenis != "STRUKTURAL") {
        	//if (($jnsjab == "FUNGSIONAL TERTENTU") AND (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN"))) {
			$nilaiskp = addslashes($this->input->post('nilaiskp'));
                        $orientasipelayanan = addslashes($this->input->post('orientasipelayanan'));
                        $integritas = addslashes($this->input->post('integritas'));
                        $komitmen = addslashes($this->input->post('komitmen'));
                        $disiplin = addslashes($this->input->post('disiplin'));
                        $kerjasama = addslashes($this->input->post('kerjasama'));
                        $kepemimpinan = 0;
		//} else if (($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "PENYULUH")) {
		//	$nilaiskp = addslashes(addslashes($this->input->post('nilaiskp')));
                //        $orientasipelayanan = addslashes($this->input->post('orientasipelayanan'));
                //        $integritas = addslashes($this->input->post('integritas'));
                //        $komitmen = addslashes($this->input->post('komitmen'));
                //        $disiplin = addslashes($this->input->post('disiplin'));
                //        $kerjasama = addslashes($this->input->post('kerjasama'));
                //        $kepemimpinan = 0;
			
			// menentukan pembagi nilai prilaku kerja
                	// jika kepemimpinan kosong (tenaga staf, jfu, jft), prilaku kerja dibagi 5
                	//if (($kepemimpinan == '') || ($kepemimpinan == 0)) {
                        //	$nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama)/5);
                	// atau prilaku kerja dibagi 6 (kepemimpinan tidak kosong)
                	//} else {
        	        //        $nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan)/6);
	                //}

		} else if ($jenis == "STRUKTURAL") {
			//$nilaiskp = decrypt_nilai(addslashes($this->input->post('nilaiskp')));
			$nilaiskp = addslashes($this->input->post('nilaiskp'));
			$orientasipelayanan = addslashes($this->input->post('orientasipelayanan'));
			$integritas = addslashes($this->input->post('integritas'));
			$komitmen = addslashes($this->input->post('komitmen'));
			$disiplin = addslashes($this->input->post('disiplin'));
			$kerjasama = addslashes($this->input->post('kerjasama'));
			$kepemimpinan = addslashes($this->input->post('kepemimpinan'));
			$nilai_prilaku_kerja = addslashes($this->input->post('nilaiprilakukerja'));
		}

		 // menentukan pembagi nilai prilaku kerja
                 // jika kepemimpinan kosong (tenaga staf, jfu, jft), prilaku kerja dibagi 5
                 if (($kepemimpinan == '') || ($kepemimpinan == 0)) {
                        $nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama)/5);
                 // atau prilaku kerja dibagi 6 (kepemimpinan tidak kosong)
                 } else {
                        $nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan)/6);
                 }

		$jnspp = $this->input->post('jnspp');
		$namapp = addslashes($this->input->post('namapp'));
		$jabatanpp = addslashes($this->input->post('jabatanpp'));
		if ($jnspp == 'PNS') {
			$nippp = addslashes($this->input->post('nippp'));
			$id_golrupp = addslashes($this->input->post('id_golrupp'));

			// nama unker ambil dari textbox 
			$nama_unkerpp = strtoupper(addslashes($this->input->post('namaunkerpp')));
		} else if ($jnspp == 'NONPNS') {
			$nippp = '';
			$id_golrupp = '';
			$nama_unkerpp = addslashes($this->input->post('unkerpp'));
		}
		

		$jnsapp = $this->input->post('jnsapp');
		$namaapp = addslashes($this->input->post('namaapp'));
		$jabatanapp = addslashes($this->input->post('jabatanapp'));

		if ($jnsapp == 'PNS') {			
			$nipapp = addslashes($this->input->post('nipapp'));
			$id_golruapp = addslashes($this->input->post('id_golruapp'));

			// nama unker ambil dari textbox
			$nama_unkerapp = strtoupper(addslashes($this->input->post('namaunkerapp')));
		} else if ($jnsapp == 'NONPNS') {
			$nipapp = '';
			$id_golruapp = '';
			$nama_unkerapp = addslashes($this->input->post('unkerapp'));
		} 
				
		$user_entri = $this->session->userdata('nip');
		$tgl_entri = $this->mlogin->datetime_saatini();
			
		//menentukan nilai prestasi kerja
		$nilai_prestasi_kerja = (0.6*$nilaiskp) + (0.4*$nilai_prilaku_kerja);

		$data = array(
			'nip' 					=> $nip,
			'jns_skp' 				=> $jenis,
			'tahun' 				=> $tahun,
			'nilai_skp' 			=> $nilaiskp,
			'orientasi_pelayanan' 	=> $orientasipelayanan,
			'integritas' 			=> $integritas,
			'komitmen' 				=> $komitmen,
			'disiplin' 				=> $disiplin,
			'kerjasama'				=> $kerjasama,
			'kepemimpinan' 			=> $kepemimpinan,
			'nilai_prilaku_kerja' 	=> $nilai_prilaku_kerja,
			'nilai_prestasi_kerja'	=> $nilai_prestasi_kerja,
			'nip_pp' 				=> $nippp,
			'nama_pp'				=> $namapp,
			'fid_golru_pp' 			=> $id_golrupp,
			'jab_pp' 				=> $jabatanpp,
			'unor_pp' 				=> $nama_unkerpp,
			'nip_app' 				=> $nipapp,
			'nama_app' 				=> $namaapp,
			'fid_golru_app' 		=> $id_golruapp,
			'jab_app' 				=> $jabatanapp,
			'unor_app' 				=> $nama_unkerapp,
			'created_at' 			=> $tgl_entri,
			'created_by' 			=> $user_entri
			);
		//$this->mskp->input_data($data);
		
		if ($this->mskp->cekskp($data['nip'], $data['tahun']) == 0) {
			// eksekusi model mskp untuk input data
			if ($this->mskp->input_data($data))
			{
				// Start Post Json SKP to SAPK Training
				$skp = $this->mskp->detail($nip, $tahun)->result_array();
        			//var_dump($skp);

        			//masukkan data kedalam variabel
        			$data['skp'] = $skp;

        			//deklarasi variabel array
        			//lopping data dari database
        			if ($skp) {
            				foreach ($skp as $hasil)
            				{                
                				$jml = round($hasil['orientasi_pelayanan'],2) + round($hasil['integritas'],2) 
							+ round($hasil['komitmen'],2) + round($hasil['disiplin'],2) + round($hasil['kerjasama'],2) 
							+ round($hasil['kepemimpinan'],2);

                				if ($hasil['jns_skp'] == "STRUKTURAL") {
                    					$rata = $jml / 6;
                    					$jnsjab = "1";
                				} else if ($hasil['jns_skp'] == "FUNGSIONAL TERTENTU") {
                    					$rata = $jml / 5;                    
                    					$jnsjab = "2";
                				} else if ($hasil['jns_skp'] == "FUNGSIONAL UMUM") {
                    					$rata = $jml / 5;                    
                    					$jnsjab = "4";
                				} 

                				//$pnsid_user = $this->mwsbkn->get_pnsid($this->session->userdata('nip'));
                				$pnsid = $this->mwsbkn->get_pnsid($nip);
                				$pnsid_pp = $this->mwsbkn->get_pnsid($hasil['nip_pp']);
                				$pnsid_app = $this->mwsbkn->get_pnsid($hasil['nip_app']);
                				//$pnsid_pp = "-";
                				//$pnsid_app = "-";

                				$tmtgolru_pp = $this->mpegawai->gettmtkpterakhir($hasil['nip_pp']);
                				$tmtgolru_app = $this->mpegawai->gettmtkpterakhir($hasil['nip_app']);
                				//$tmtgolru_pp = "-";
                				//$tmtgolru_app = "-";

                				$golru_pp = $this->mpegawai->getnamagolru($hasil['fid_golru_pp']);
                				$golru_app = $this->mpegawai->getnamagolru($hasil['fid_golru_app']);
                

                				$posts = array(
                    					"id" => null, 
                    					"tahun" => floatval($tahun),
                    					"nilaiSkp" => floatval($hasil['nilai_skp']),
                    					"orientasiPelayanan" => floatval($hasil['orientasi_pelayanan']),
                    					"integritas" => floatval($hasil['integritas']),
                    					"komitmen" => floatval($hasil['komitmen']),
                    					"disiplin" => floatval($hasil['disiplin']),
                    					"kerjasama" => floatval($hasil['kerjasama']),
                    					"nilaiPerilakuKerja" => floatval($hasil['nilai_prilaku_kerja']),
                    					"nilaiPrestasiKerja" => floatval($hasil['nilai_prestasi_kerja']),
                    					"kepemimpinan" => floatval($hasil['kepemimpinan']),
                    					"jumlah" => floatval($jml),
                    					"nilairatarata" => floatval($rata),
                    					"atasanPejabatPenilai" => $pnsid_app,
                    					"pejabatPenilai" => $pnsid_pp,
                    					"pnsDinilaiOrang" => $pnsid,
                    					"penilaiNipNrp" => $hasil['nip_pp'],
                    					"atasanPenilaiNipNrp" => $hasil['nip_app'],
                    					"penilaiNama" => $hasil['nama_pp'],
                    					"atasanPenilaiNama" => $hasil['nama_app'],
                    					"penilaiUnorNama" => $hasil['unor_pp'],
                    					"atasanPenilaiUnorNama" => $hasil['unor_app'],
                    					"penilaiJabatan" => $hasil['jab_pp'],
                    					"atasanPenilaiJabatan" => $hasil['jab_app'],
                    					"penilaiGolongan" => $golru_pp,
                    					"atasanPenilaiGolongan" => $golru_app,
                    					"penilaiTmtGolongan" => $tmtgolru_pp,
                    					"atasanPenilaiTmtGolongan" => $tmtgolru_app,
                    					"statusPenilai" => "PNS",
                    					"statusAtasanPenilai" => "PNS",
                    					"jenisJabatan" => $jnsjab,
                    					"pnsUserId" => "A8ACA7E42B1F3912E040640A040269BB" // pnsid Admin SAPK BKN 
                					//"pnsUserId" => '' // UNTUK UJICOBA ja supaya kada masuk datanya ke SAPK BKN
						);
						
						$data_string = json_encode($posts); 
						//var_dump($data_string);

    						// post into duplex ws training
    						//$resultApi = apiResult2('https://wsrv-duplex-training.bkn.go.id/api/skp/save', $data_string);
                				// post into duplex ws production
						$resultApi = apiResult2('https://wsrv-duplex.bkn.go.id/api/skp/save', $data_string);	
					
    						//var_dump($data_string);
    						$objRest = json_decode($resultApi, true);
						//var_dump($objRest);

    						if($objRest['success']) {
							$dataidbkn = array(
								'id_bkn' => $objRest['mapData']['rwSkpId']
							);
							$whereidbkn = array(
	      							'nip'    => $nip,
	      							'tahun'  => $tahun
	    						);
							if ($this->mskp->edit_skp($whereidbkn, $dataidbkn))
        						{
								$data['pesan'] = '<b>Sukses</b>, Data SKP Tahun '.$data['tahun'].' berhasil ditambah pada SILKa dan SAPK BKN';
                                				$data['jnspesan'] = 'alert alert-success';
							} else {
								$data['pesan'] = '<b>Warning</b>, ID Riwayat Data SKP Tahun '.$data['tahun'].' Tidak Berhasil ditambah pada SILKa';
                                                                $data['jnspesan'] = 'alert alert-warning';
                                                        }
						} else {
							$data['pesan'] = '<b>Gagal</b>, Data SKP Tahun '.$data['tahun'].' gagal ditambah pada SAPK';
                                			$data['jnspesan'] = 'alert alert-danger';
						}

					} // End Foreach
				} // End If
				// End Post Json SKP to SAPK
			} else {
				$data['pesan'] = '<b>Gagal !</b>, Data SKP Tahun '.$data['tahun'].' gagal ditambah.<br />Pastikan data sesuai dengan ketentuan';
				$data['jnspesan'] = 'alert alert-danger';
			}			
		} else {
			$data['pesan'] = '<b>Data rangkap !</b>, Data SKP Tahun '.$data['tahun'].' gagal ditambah.';
			$data['jnspesan'] = 'alert alert-danger';
			//$data['pesan'] = '';
			//$data['jnspesan'] = '';
		}

		// tampilkan view rwyskp
		$data['nip'] = $nip;
		$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
	    $data['content'] = 'rwyskp';
	    $this->load->view('template', $data);	
	}

	function hapus() {
		$nip = addslashes($this->input->post('nip'));
		$thn = addslashes($this->input->post('thn'));
		$where = array('nip' => $nip, 'tahun' => $thn);
		
		if ($this->mskp->cekskp($nip, $thn) != 0) {
			// eksekusi model mskp untuk hapus data
			if ($this->mskp->hapus_data($where))
			// jika sukses
			{				
				// hapus file jika ada
				$nmfile = $nip."-".$thn; //nama file nip + tahun skp
				if (file_exists('./fileskp/'.$nmfile.'.pdf')) {
					//chmod('./fileskp/'.$nmfile.'.pdf',0777);
					//chown('./fileskp/'.$nmfile.'.pdf',666);
					unlink('./fileskp/'.$nmfile.'.pdf');
										
					//delete_files('./fileskp/'.$nmfile.'.pdf');
		                }

				$data['pesan'] = '<b>Sukses</b>, Data SKP Tahun '.$thn.' berhasil dihapus';
				$data['jnspesan'] = 'alert alert-success';
			} else {
				$data['pesan'] = '<b>Gagal !</b>, Data SKP Tahun '.$thn.' gagal dihapus.';
				$data['jnspesan'] = 'alert alert-danger';
			}			
		} else {
			//$data['pesan'] = '<b>Data tidak ditemukan !</b>, Data SKP Tahun '.$thn.' gagal dihapus.';
			//$data['jnspesan'] = 'alert alert-danger';
			$data['pesan'] = '';
			$data['jnspesan'] = '';
		}

		// tampilkan view rwyskp
		$data['nip'] = $nip;		
    	$data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
	    $data['content'] = 'rwyskp';
	    $this->load->view('template', $data);
		/*
		if ($this->mskp->hapus_data($where))
		{
			redirect('../pegawai/berhasil'); //jika berhasil maka akan ditampilkan view berhasil
		} else {
			redirect('../pegawai/gagal'); //jika berhasil maka akan ditampilkan view gagal
		}
		*/
	}

	function getdatakep() {
	    $jnsjab = $this->input->get('jnsjab');
	    if ($jnsjab == 'STRUKTURAL') {
	    	echo "<input type='text' name='kepemimpinan' size='8' maxlength='5' onkeypress='return hanyaAngkaDesimal(event,6)' onChange='showHitung(formtambahskp.jenis.value, formtambahskp.orientasipelayanan.value, formtambahskp.integritas.value, formtambahskp.komitmen.value, formtambahskp.disiplin.value, formtambahskp.kerjasama.value, this.value, formtambahskp.nilaiskp.value)'>";
	    } else {
	    	echo "<input type='text' name='kepemimpinan' size='8' maxlength='5' value='0' disabled>";
	    }
	}

	function getdatahitung() {
		$jns = $this->input->get('jns');
		$ori = $this->input->get('ori');
		$integ = $this->input->get('integ');
		$kom = $this->input->get('kom');
		$dis = $this->input->get('dis');
		$ker = $this->input->get('ker');
		$kep = $this->input->get('kep');
		$skp = $this->input->get('skp');

		$jumlah = $ori + $integ + $kom + $dis + $ker + $kep;

		$nilaiskp = $skp*0.6;

		//$nilaiprilaku = $nilaiprilaku + $nilai;
		
		if ($jns == 'STRUKTURAL') {
			$prilaku = ($jumlah/6)*0.4;	
		} else {
			$prilaku = ($jumlah/5)*0.4;
		}

		$prestasi = $nilaiskp + $prilaku;
		

		//echo $temp;
		echo "<input type='text' size='8' maxlength='5' value='".$nilaiskp."' disabled><br/><br/>
		<input type='text' size='8' maxlength='5' value='".$prilaku."' disabled><br/><br/>
		<input type='text' size='8' maxlength='5' value='".$prestasi."' disabled>";
	}

	function getdatapp() {
		$jnspp = $this->input->get('jnspp');
		if ($jnspp == 'PNS') {
		
			echo "<table class='table table-condensed'>";
            echo "<tr>";
            echo "<td align='right' width='250'>NIP :</td>";
            echo "<td><input type='text' name='nippp' size='20' maxlength='18' onkeypress='return hanyaAngka(event)'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Nama :</td>";
            echo "<td><input type='text' name='namapp' size='40' maxlength='40'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Pangkat :</td>";
            echo "<td>";
	    $golru = $this->mpegawai->golru()->result_array();
            echo "<select name='id_golrupp' id='id_golrupp'>";            
	    echo "<option value=''>- Pilih Golongan Ruang / Pangkat -</option>";
	        foreach($golru as $gl)
	        {
	          	echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
	        }
            
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Jabatan :</td>";
            echo "<td><input type='text' name='jabatanpp' size='100' maxlength='100'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Unit Kerja :</td>";
            echo "<td>";
            $unker = $this->munker->unker()->result_array();
	    // tambah aksi onChange
            echo "<select name='id_unkerpp' id='id_unkerpp' onChange='showunkerpp(this.value)'>";
            echo "<option value='' selected>- Pilih Unit Kerja -</option>";
            echo "<option value='LUAR BALANGAN'>---DILUAR PEMKAB BALANGAN / TIDAK DITEMUKAN---</option>";

            //echo "<select name='id_unkerpp' id='id_unkerpp'>";
            //echo "<option value=''>- Pilih Unit Kerja -</option>";
            foreach($unker as $uk)
            {
             	echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
            }
            echo "</select>";

	    // tambah div tampilunker
            echo "<div id='tampilunkerpp'></div>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<div id='pegpp'></div>";

        } else if ($jnspp == 'NONPNS') {
        	echo "<table class='table table-condensed'>";
        	echo "<tr>";
            echo "<td align='right' width='250'>Nama :</td>";
            echo "<td><input type='text' name='namapp' size='40' maxlength='40'></td>";
            echo "</tr>";            
            echo "<tr>";
            echo "<td align='right'>Jabatan :</td>";
            echo "<td><input type='text' name='jabatanpp' size='70' maxlength='100'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Unit Kerja :</td>";
            echo "<td><input type='text' name='unkerpp' size='100' maxlength='100'></td>";
            echo "</tr>";
            echo "</table>";
        }
    }

    function getdataapp() {
		$jnspp = $this->input->get('jnsapp');
		if ($jnspp == 'PNS') {		
			echo "<table class='table table-condensed'>";
            echo "<tr>";
            echo "<td align='right' width='250'>NIP :</td>";
            echo "<td><input type='text' name='nipapp' size='20' maxlength='18' onkeypress='return hanyaAngka(event)'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Nama :</td>";
            echo "<td><input type='text' name='namaapp' size='40' maxlength='40'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Pangkat :</td>";
            echo "<td>";
	        $golru = $this->mpegawai->golru()->result_array();
            echo "<select name='id_golruapp' id='id_golruapp'>";            
	        echo "<option value=''>- Pilih Golongan Ruang / Pangkat -</option>";
	        foreach($golru as $gl)
	        {
	          	echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
	        }
            
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Jabatan :</td>";
            echo "<td><input type='text' name='jabatanapp' size='100' maxlength='100'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Unit Kerja :</td>";
            echo "<td>";
            $unker = $this->munker->unker()->result_array();
	
	    echo "<select name='id_unkerapp' id='id_unkerapp' onChange='showunkerapp(this.value)'>";
            echo "<option value=''>- Pilih Unit Kerja -</option>";
            echo "<option value='LUAR BALANGAN'>---DILUAR PEMKAB BALANGAN / TIDAK DITEMUKAN---</option>";
	
            //echo "<select name='id_unkerapp' id='id_unkerapp'>";
            //echo "<option value=''>- Pilih Unit Kerja -</option>";
            foreach($unker as $uk)
            {
             	echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
            }
            echo "</select>";

	    // tambah div tampilunker
            echo "<div id='tampilunkerapp'></div>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<div id='pegpp'></div>";

        } else if ($jnspp == 'NONPNS') {
        	echo "<table class='table table-condensed'>";
        	echo "<tr>";
            echo "<td align='right' width='250'>Nama :</td>";
            echo "<td><input type='text' name='namaapp' size='40' maxlength='40'></td>";
            echo "</tr>";            
            echo "<tr>";
            echo "<td align='right'>Jabatan :</td>";
            echo "<td><input type='text' name='jabatanapp' size='70' maxlength='100'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Unit Kerja :</td>";
            echo "<td><input type='text' name='unkerapp' size='100' maxlength='100'></td>";
            echo "</tr>";
            echo "</table>";
        }
    }

    function getdataunkerpp()
    { 
	  	$idunker = $this->input->get('idunker');

	  	if ($idunker == 'LUAR BALANGAN') {
	  		echo "<br />Silahkan ketik nama unit kerja pada kotak dibawah ini";
	  		echo "<input type='text' name='namaunkerpp' size='80' maxlength='100'>";
	  	} else {
	  		$namaunker = $this->munker->getnamaunker($idunker);
		  	echo "<input type='hidden' name='namaunkerpp' size='80' maxlength='100' value='$namaunker'>";
	  	}
	  	
    }

    function getdataunkerapp()
    { 
	  	$idunker = $this->input->get('idunker');

	  	if ($idunker == 'LUAR BALANGAN') {
	  		echo "<br />Silahkan ketik nama unit kerja pada kotak dibawah ini";
	  		echo "<input type='text' name='namaunkerapp' size='80' maxlength='100'>";
	  	} else {
	  		$namaunker = $this->munker->getnamaunker($idunker);
		  	echo "<input type='hidden' name='namaunkerapp' size='80' maxlength='100' value='$namaunker'>";
	  	}
	  	
    }

    // bagian untuk Edit SKP
	function editskp(){
		if ($this->session->userdata('edit_profil_priv') == "Y") { 
	    	$nip = $this->input->post('nip');    
			$thn = $this->input->post('thn');    

			$data['skp'] = $this->mskp->detail($nip, $thn)->result_array();
			$data['nip'] = $nip;
			$data['thn'] = $thn;
			$data['content'] = 'editskp';
			$this->load->view('template', $data);
	    }		
	}

	function getdatakepedit() {
	    $jnsjab = $this->input->get('jnsjab');
	    $nip = $this->input->get('nip');
	    $thn = $this->input->get('thn');
	    $nilaikep = $this->mskp->getkepemimpinan($nip, $thn);

	    if ($jnsjab == 'STRUKTURAL') {
	    	echo "<input type='text' name='kepemimpinan' value='$nilaikep' size='8' maxlength='5' onkeypress='return hanyaAngkaDesimal(event)'>";
	    	//echo "STRUKTURAL / NON STRUKTURAL";
	    } else if ($jnsjab != 'STRUKTURAL') {
	    	echo "<input type='text' name='kepemimpinan' size='8' maxlength='5' value='0' disabled>";
	    	//echo "NON STRUKTURAL / STRUKTURAL";
	    } 
	}

	function getdatappedit() {
	    $jnspp = $this->input->get('jnspp');
	    $nip = $this->input->get('nip');
	    $thn = $this->input->get('thn');
	    $skp = $this->mskp->getpp($nip, $thn)->result_array();

        foreach($skp as $v):

	    if ($jnspp == 'PNS') {		
			echo "<table class='table table-condensed'>";
            echo "<tr>";
            echo "<td align='right' width='250'>NIP :</td>";
            echo "<td><input type='text' name='nippp' size='20' maxlength='18' value='".$v['nip_pp']."' onkeypress='return hanyaAngka(event)'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Nama :</td>";
            echo "<td><input type='text' name='namapp' size='40' value='".$v['nama_pp']."' maxlength='40'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Pangkat :</td>";
            echo "<td>";
	        $golru = $this->mpegawai->golru()->result_array();
	        echo "<select name='id_golrupp' id='id_golrupp'>";  
	        foreach($golru as $gl)
	        {
	        	if ($v[fid_golru_pp] == $gl[id_golru]) {
	        		echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
	        	} else {
	        		echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
	        	}
	        }

	        echo "</select>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Jabatan :</td>";
            echo "<td><input type='text' name='jabatanpp' size='100' maxlength='100' value='".$v['jab_pp']."'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Unit Kerja :</td>";
            echo "<td><input type='text' name='unorpp' size='80' maxlength='100' value='".$v['unor_pp']."'></td>";
            echo "</tr>";
            echo "</table>";

        } else if ($jnspp == 'NONPNS') {
        	echo "<table class='table table-condensed'>";
        	echo "<tr>";
        	echo "<td align='right' width='250'>Nama :</td>";
        	echo "<td><input type='text' name='namapp' size='40' maxlength='40' value='".$v['nama_pp']."'></td>";
        	echo "</tr>";            
        	echo "<tr>";
        	echo "<td align='right'>Jabatan :</td>";
        	echo "<td><input type='text' name='jabatanpp' size='70' maxlength='100' value='".$v['jab_pp']."'></td>";
        	echo "</tr>";
        	echo "<tr>";
        	echo "<td align='right'>Unit Kerja :</td>";
        	echo "<td><input type='text' name='unorpp' size='100' maxlength='100' value='".$v['unor_pp']."'></td>";
        	echo "</tr>";
        	echo "</table>";
        }

        endforeach;
	}

	function getdataappedit() {
	    $jnsapp = $this->input->get('jnsapp');
	    $nip = $this->input->get('nip');
	    $thn = $this->input->get('thn');
	    $skp = $this->mskp->getapp($nip, $thn)->result_array();

        foreach($skp as $v):

	    if ($jnsapp == 'PNS') {		
			echo "<table class='table table-condensed'>";
            echo "<tr>";
            echo "<td align='right' width='250'>NIP :</td>";
            echo "<td><input type='text' name='nipapp' size='20' maxlength='18' value='".$v['nip_app']."' onkeypress='return hanyaAngka(event)'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Nama :</td>";
            echo "<td><input type='text' name='namaapp' size='40' value='".$v['nama_app']."' maxlength='40'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Pangkat :</td>";
            echo "<td>";
	        $golru = $this->mpegawai->golru()->result_array();
	        echo "<select name='id_golruapp' id='id_golruapp'>";  
	        foreach($golru as $gl)
	        {
	        	if ($v[fid_golru_app] == $gl[id_golru]) {
	        		echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
	        	} else {
	        		echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
	        	}
	        }

	        echo "</select>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Jabatan :</td>";
            echo "<td><input type='text' name='jabatanapp' size='100' maxlength='100' value='".$v['jab_app']."'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='right'>Unit Kerja :</td>";
            echo "<td><input type='text' name='unorapp' size='80' maxlength='100' value='".$v['unor_app']."'></td>";
            echo "</tr>";
            echo "</table>";

        } else if ($jnsapp == 'NONPNS') {
        	echo "<table class='table table-condensed'>";
        	echo "<tr>";
        	echo "<td align='right' width='250'>Nama :</td>";
        	echo "<td><input type='text' name='namaapp' size='40' maxlength='40' value='".$v['nama_app']."'></td>";
        	echo "</tr>";            
        	echo "<tr>";
        	echo "<td align='right'>Jabatan :</td>";
        	echo "<td><input type='text' name='jabatanapp' size='70' maxlength='100' value='".$v['jab_app']."'></td>";
        	echo "</tr>";
        	echo "<tr>";
        	echo "<td align='right'>Unit Kerja :</td>";
        	echo "<td><input type='text' name='unorapp' size='100' maxlength='100' value='".$v['unor_app']."'></td>";
        	echo "</tr>";
        	echo "</table>";
        }

        endforeach;
	}

	function edit_aksi(){
		$nip = addslashes($this->input->post('nip'));
		$thn = addslashes($this->input->post('thn'));

		$jenis = addslashes($this->input->post('jenis'));
		$nilaiskp = addslashes($this->input->post('nilaiskp'));
		$orientasipelayanan = addslashes($this->input->post('orientasipelayanan'));
		$integritas = addslashes($this->input->post('integritas'));
		$komitmen = addslashes($this->input->post('komitmen'));
		$disiplin = addslashes($this->input->post('disiplin'));
		$kerjasama = addslashes($this->input->post('kerjasama'));
		$kepemimpinan = addslashes($this->input->post('kepemimpinan'));
		if ($kepemimpinan == '') {
                        $kepemimpinan = 0;
                }

		$jnspp = $this->input->post('jnspp');
		$namapp = addslashes($this->input->post('namapp'));
		$jabatanpp = strtoupper(addslashes($this->input->post('jabatanpp')));
		if ($jnspp == 'PNS') {
			$nippp = addslashes($this->input->post('nippp'));
			$id_golrupp = addslashes($this->input->post('id_golrupp'));
			// nama unker ambil dari textbox 
			$nama_unkerpp = strtoupper(addslashes($this->input->post('unorpp')));
		} else if ($jnspp == 'NONPNS') {
			$nippp = '';
			$id_golrupp = '';
			$nama_unkerpp = strtoupper(addslashes($this->input->post('unorpp')));
		}
		

		$jnsapp = $this->input->post('jnsapp');
		$namaapp = addslashes($this->input->post('namaapp'));
		$jabatanapp = strtoupper(addslashes($this->input->post('jabatanapp')));

		if ($jnsapp == 'PNS') {			
			$nipapp = addslashes($this->input->post('nipapp'));
			$id_golruapp = addslashes($this->input->post('id_golruapp'));
			//$id_unkerapp = addslashes($this->input->post('id_unkerapp'));
			//$nama_unkerapp = $this->munker->getnamaunker($id_unkerapp);

			// nama unker ambil dari textbox
			$nama_unkerapp = strtoupper(addslashes($this->input->post('unorapp')));
		} else if ($jnsapp == 'NONPNS') {
			$nipapp = '';
			$id_golruapp = '';
			$nama_unkerapp = strtoupper(addslashes($this->input->post('unorapp')));
		} 
				
		$user_update = $this->session->userdata('nip');
	    $tgl_update = $this->mlogin->datetime_saatini();

		// menentukan pembagi nilai prilaku kerja
		// jika kepemimpinan kosong (tenaga staf, jfu, jft), prilaku kerja dibagi 5
		if (($kepemimpinan == '') || ($kepemimpinan == 0)) {
			$nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama)/5);
		// atau prilaku kerja dibagi 6 (kepemimpinan tidak kosong)
		} else {
			$nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan)/6);
		}

		//menentukan nilai prestasi kerja
		$nilai_prestasi_kerja = (0.6*$nilaiskp) + (0.4*$nilai_prilaku_kerja);

		$data = array(
			'jns_skp' 				=> $jenis,
			'tahun' 				=> $thn,
			'nilai_skp' 			=> $nilaiskp,
			'orientasi_pelayanan' 	=> $orientasipelayanan,
			'integritas' 			=> $integritas,
			'komitmen' 				=> $komitmen,
			'disiplin' 				=> $disiplin,
			'kerjasama'				=> $kerjasama,
			'kepemimpinan' 			=> $kepemimpinan,
			'nilai_prilaku_kerja' 	=> $nilai_prilaku_kerja,
			'nilai_prestasi_kerja'	=> $nilai_prestasi_kerja,
			'nip_pp' 				=> $nippp,
			'nama_pp'				=> $namapp,
			'fid_golru_pp' 			=> $id_golrupp,
			'jab_pp' 				=> $jabatanpp,
			'unor_pp' 				=> $nama_unkerpp,
			'nip_app' 				=> $nipapp,
			'nama_app' 				=> $namaapp,
			'fid_golru_app' 		=> $id_golruapp,
			'jab_app' 				=> $jabatanapp,
			'unor_app' 				=> $nama_unkerapp,
			'updated_at' 			=> $tgl_update,
			'updated_by' 			=> $user_update
		);

		$where = array(
	      'nip'    => $nip,
	      'tahun'  => $thn
	    );

	    $nama = $this->mpegawai->getnama($nip);

      	    if ($this->mskp->edit_skp($where, $data))
            {
            	// kirim konfirmasi pesan dan jenis pesan
          	$data['pesan'] = '<b>Sukses</b>, Data SKP PNS A.n. <u>'.$nama.'</u> tahun '.$thn.' berhasil dirubah.';
          	$data['jnspesan'] = 'alert alert-success';
            } else {
          	$data['pesan'] = '<b>Gagal !</b>, Data SKP PNS A.n. <u>'.$nama.'</u> tahun '.$thn.' gagal dirubah.<br />Pastikan data sesuai dengan ketentuan';
          	$data['jnspesan'] = 'alert alert-danger';
            }		

	    // tampilkan view rwyskp
	    $data['nip'] = $nip;
	    $data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();       
	    $data['content'] = 'rwyskp';
	    $this->load->view('template', $data);	
	}

	function getdatanilaiskp()
    	{ 
	  	$nip = $this->input->get('nip');
	  	$thn = $this->input->get('thn');
		$jns = $this->input->get('jenis');

	  	// cek wajib ekinerja
	  	$jnsjab = $this->mkinerja->get_jnsjab($nip);
        	$keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
		//if (($jns == "FUNGSIONAL TERTENTU") AND (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN"))) {
        	//if (($jnsjab == "FUNGSIONAL TERTENTU") AND (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN"))) {
        		?>
        		<!--
			<input type="text" name="nilaiskp" size='8' maxlength='5' value='0' onkeypress="return hanyaAngkaDesimal(event)" onChange="showHitung(formtambahskp.jenis.value, formtambahskp.orientasipelayanan.value, formtambahskp.integritas.value, formtambahskp.komitmen.value, formtambahskp.disiplin.value, formtambahskp.kerjasama.value, formtambahskp.kepemimpinan.value, this.value)" required>
        		<br/>
			-->
        		<?php	  			
        	//	echo "<small><span class='text-info'><b>Anda JFT Kesehatan / Pendidikan</b>, silahkan entri manual Nilai SKP Tahun ".$thn.".</span></small>";	 
        	//} else {
          		if ($thn != 0) {
				//$url = 'https://ekinerja.bkppd-balangankab.info/c_api/get_skp_thnnip_silka?nip='.$nip.'&thn='.$thn;
		        $url = 'http://ekinerja.bkppd.local/c_api/get_skp_thnnip_silka?nip='.$nip.'&thn='.$thn;
		              $konten = file_get_contents($url);
                		$api = json_decode($konten);
                		$jml = count($api);

			  	if ($konten == '{"hasil":[]}') {
			  		continue;
			  	}

		        	// TO DO : proses data dari DES Web Service
			  	if ($jml != 0) {            
			  		foreach($api->hasil as $d) : 
			  			if ($d->nilai == null) {
			  				echo "<span class='text-danger'><b>Nilai SKP Tahun ".$thn."</b> tidak ditemukan pada e-Kinerja, Pastikan Nilai SKP Tahun ".$thn." pada aplikasi ekinerja sudah bernilai.</span>";
							// Buka akses untuk edit nilai secara manual
                                                        echo "<br/>Entri Nilai SKP Manual : <input type='text' name='nilaiskp' size='8' value=''  required />";
                                                        // End akses edit manual	  					
			  			} else if ($d->nilai > 100 ) {
			  				echo "<span class='text-danger'><b>".round($d->nilai,2)."</b></span>";
							// Buka akses untuk edit nilai secara manual
							echo "<input type='text' name='nilaiskp' size='8' value='round($d->nilai,2)'  required />";
							echo "<b>Realisasi 60% = <?php echo round((0.6*$d->nilai),2); ?></b>";
							// End akses edit manual
			  				echo "<br/><small><span class='text-info'>Nilai SKP Tahunan lebih besar dari 100,<br />Pastikan Nilai SKP Tahunan pada aplikasi ekinerja Anda telah sesuai dengan ketentuan.</span></small>";
			  			} else if ($d->nilai <= 100 ) {             
							if ($thn <= 2019) {
								?>
                                                        	<input type="text" name="nilaiskp" size='8' value='<?php echo round($d->nilai,2); ?>'  required />
                                                        	<b>Realisasi 60% = <?php echo round((0.6*$d->nilai),2); ?></b>
                                                        	<?php
                                                        	echo "<small><span class='text-warning'><br/>Pastikan <b>Nilai SKP Tahunan</b> sesuai dengan e-Kinerja,<br />Jika terdapat lebih dari satu periode tahunan, maka NIlai SKP adalah nilai rata-rata.</span></small>";
							} else {           
			  				?>
			  				<input type="text" name="nilaiskp" size='8' maxlength='5' value='<?php echo round($d->nilai,2); ?>' required />
			  				<!--<input type="text" name="nilaiskp" size='8' value='<?php echo encrypt_nilai(round($d->nilai,2)); ?>'  required Readonly />-->
							<b>Realisasi 60% = <?php echo round((0.6*$d->nilai),2); ?></b>
			  				<?php
			  				echo "<small><span class='text-warning'><br/>Pastikan <b>Nilai SKP Tahunan</b> sesuai dengan e-Kinerja,<br />Jika terdapat lebih dari satu periode tahunan, maka NIlai SKP adalah nilai rata-rata.</span></small>";
					  		//echo $d->nip." / ".round($d->nilai,2);
							}
					  	}
			  		endforeach;
			  	} else {
			  		echo "<span class='text-danger'>Data tidak ditemukan</span>"; 
			  	}

		  	} else {
		  		echo "<span class='text-danger'>Lengkapi data Tahun Kinerja</span>";
		  	}
		//}
    	}
	
    function getdatanilaiprilaku()
    { 
	$nip = $this->input->get('nip');
	$thn = $this->input->get('thn');
	$jns = $this->input->get('jns');

	// cek wajib ekinerja
	$jnsjab = $this->mkinerja->get_jnsjab($nip);
        $keltugasjft = $this->mpegawai->getkeltugas_jft_nip($nip);
        if (($jnsjab == "FUNGSIONAL TERTENTU") AND (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN"))) {
        	?>
        	<div class="row"> <!-- Baris Awal -->
        		<div class="col-md-2" align='right'>Orientasi Pelayanan</div>
        		<div class="col-md-2">
        			<input type="text" name="orientasipelayanan" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)"required>
        		</div>
        		<div class="col-md-2" align='right'>Komitmen</div>
        		<div class="col-md-2">
        			<input type="text" name="komitmen" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>			
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-2" align='right'>Integritas</div>
        		<div class="col-md-2" align='left'>
        			<input type="text" name="integritas" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>			
        		</div>
        		<div class="col-md-2" align='right'>Kerjasama</div>
        		<div class="col-md-2" align='left'>
        			<input type="text" name="kerjasama" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>			
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-2" align='right'>Disiplin</div>
        		<div class="col-md-2" align='left'>
        			<input type="text" name="disiplin" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>			
        		</div>
        	</div>
        	<?php	  			
        	echo "<small><span class='text-info'><b>Anda JFT Kesehatan / Pendidikan</b>, silahkan entri manual Nilai Prilaku Kerja ".$thn.".</span></small>";	 
        } else {
          	if ($thn != 0) {
			  	$url = 'https://eprilaku.bkppd-balangankab.info/Api/get_nilai_thnnip_silka?thn='.$thn.'&nip='.$nip;
			  	$konten = file_get_contents($url);
			  	$api = json_decode($konten);
			  	$jml = count($api);

			  	if ($konten == '{"hasil":[]}') {
			  		continue;
			  	}

		        // TO DO : proses data dari DES Web Service
			  	if ($jml != 0) {            
			  		foreach($api->hasil as $d) : 
			  			if ($d->nilai_akhir == null) {
			  				?>
			  				<?php	  			
			  				echo "<small><span class='text-danger'><b>Nilai Prilaku Kerja Tahun ".$thn."</b> tidak ditemukan pada ePrilaku360,<br />Pastikan Nilai Prilaku Kerja Tahunan pada aplikasi ePrilaku360 sudah bernilai.</span></small>";	  					
			  			} else {             
			  				?>
							<div class="row"> <!-- Baris Awal -->
	    							<div class="col-md-2" align='right'>Orientasi Pelayanan</div>
	    							<div class="col-md-2">
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->orientasi_pelayanan,2); ?>' required Disabled />	
	    								<input type="hidden" name="orientasipelayanan" size='8' value='<?php echo round($d->orientasi_pelayanan,2); ?>' required readonly />
	    							</div>
	    							<div class="col-md-2" align='right'>Komitmen</div>
	    							<div class="col-md-2">
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->komitmen,2); ?>' required Disabled />
	    								<input type="hidden" name="komitmen" size='8' value='<?php echo round($d->komitmen,2); ?>' required readonly/>		
	    							</div>
    							</div>
    							<div class="row">
	    							<div class="col-md-2" align='right'>Integritas</div>
	    							<div class="col-md-2" align='left'>
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->integritas,2); ?>' required Disabled />
	    								<input type="hidden" name="integritas" size='8' value='<?php echo round($d->integritas,2); ?>' required readonly />			
	    							</div>
	    							<div class="col-md-2" align='right'>Kerjasama</div>
	    							<div class="col-md-2" align='left'>
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->kerjasama,2); ?>' required Disabled />
	    								<input type="hidden" name="kerjasama" size='8' value='<?php echo round($d->kerjasama,2); ?>' required readonly />			
	    							</div>
    							</div>
    							<div class="row">
	    							<div class="col-md-2" align='right'>Disiplin</div>
	    							<div class="col-md-2" align='left'>
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->disiplin,2); ?>' required Disabled />	    								
	    								<input type="hidden" name="disiplin" size='8' value='<?php echo round($d->disiplin,2); ?>' required Readonly/>			
	    							</div>
	    							<div class="col-md-2" align='right'>Kepemimpinan</div>
	    							<div class="col-md-2" align='left'>
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->kepemimpinan,2); ?>' required Disabled />		    								
	    								<input type="hidden" name="kepemimpinan" size='8' value='<?php echo round($d->kepemimpinan,2); ?>' required readonly/>			
	    							</div>
    							</div>
	    						<br/>
    							<div class="row">
	    							<div class="col-md-2" align='right'><b>Nilai Prilaku Kerja</b></div>
	    							<div class="col-md-2" align='left'>
	    								<input type="text" name="" size='8' maxlength='5' value='<?php echo round($d->nilai_akhir,2); ?>' required Disabled />		    								
	    								<input type="hidden" name="nilaiprilakukerja" value='<?php echo round($d->nilai_akhir,2); ?>' required readonly/>			
	    							</div>
	    							<div class="col-md-2" align='right'><b>Realisasi 40% = <?php echo round((0.4*$d->nilai_akhir),2); ?></b></div>
    							</div>
			  				<?php
			  				echo "<small><span class='text-warning'>Pastikan <b>Nilai Prilaku Kerja</b> sesuai dengan ePrilaku360, pada Menu Nilai Prilaku Kerja (Tahunan)</span></small>";
					  		//echo $d->nip." / ".round($d->nilai,2);
					  	}
			  		endforeach;
			  	} else {
			  		echo "<span class='text-danger'><b>Data Nilai Perilaku Kerja Tahun ".$thn."</b> tidak ditemukan pada aplikasi ePerilaku-360, Silahkan entri Manual</span>";
					?>
                			<div class="row"> <!-- Baris Awal -->
                        			<div class="col-md-2" align='right'>Orientasi Pelayanan</div>
                        			<div class="col-md-2">
                                			<input type="text" name="orientasipelayanan" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>
                        			</div>
                        			<div class="col-md-2" align='right'>Komitmen</div>
                        			<div class="col-md-2">
                                			<input type="text" name="komitmen" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>
                        			</div>
                			</div>
                			<div class="row">
                        			<div class="col-md-2" align='right'>Integritas</div>
                        			<div class="col-md-2" align='left'>
                                			<input type="text" name="integritas" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>
                        			</div>
                        			<div class="col-md-2" align='right'>Kerjasama</div>
                        			<div class="col-md-2" align='left'>
                                			<input type="text" name="kerjasama" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>
                        			</div>
                			</div>
                			<div class="row">
                        			<div class="col-md-2" align='right'>Disiplin</div>
                        			<div class="col-md-2" align='left'>
                                			<input type="text" name="disiplin" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>
                        			</div>
						<?php
						if ($jns == "STRUKTURAL") {
						?>
							<div class="col-md-2" align='right'>Kepemimpinan</div>
							<div class="col-md-2" align='left'>
                                                        <input type="text" name="kepemimpinan" size='8' maxlength='5' value='' onkeypress="return hanyaAngkaDesimal(event)" required>
                                                	</div>
						<?php
						}
						?>
                			</div>
                		<?php 
			  	}

		  	} else {
		  		echo "<span class='text-danger'>Lengkapi data Tahun Kinerja</span>";
		  	}
		}
    	}	

	public function cetakfpk()  
	{
		$nip = addslashes($this->input->post('nip'));
      		$thn = addslashes($this->input->post('thn'));
      		$periodeawal = tgl_sql($this->input->post('periodeawal'));	
      		$periodeakhir  = tgl_sql($this->input->post('periodeakhir'));
      		$nmunker = $this->input->post('nmunker');
      		$nmjab = $this->input->post('nmjab');
      		$idgolru = $this->mhukdis->getidgolruterakhir($nip);

      		$dibuatpenilai = tgl_sql($this->input->post('dibuatpenilai'));
      		$diterimapns = tgl_sql($this->input->post('diterimapns'));
      		$diterimaatasanpenilai = tgl_sql($this->input->post('diterimaatasanpenilai'));

      		$tglcetak = $this->mlogin->datetime_saatini();

	      	// TODO QR CODE
        	// Generate QR Code jika Berhasil
        	$this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
	        $config['cacheable']    = true; //boolean, the default is true
       	 	$config['cachedir']     = './assets/'; //string, the default is application/cache/
        	$config['errorlog']     = './assets/'; //string, the default is application/logs/
        	$config['imagedir']     = './assets/qrcodeskp/'; //direktori penyimpanan qr code
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

        	$image_name = $nip."-".$thn.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'
 
	        //$image_name=$nip.'_'.$tgl_sk.'.png'; //buat name dari qr code sesuai dengan nim
 
        	$params['data'] = $nip."-".$thn.$string; //data yang akan di jadikan QR CODE
        	$params['level'] = 'H'; //H=High
        	$params['size'] = 10;
        	$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        	$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
 
        	// END QR CODE

  	    	$data = array(
			'periodeawal' 				=> $periodeawal,
			'periodeakhir' 				=> $periodeakhir,
			'unitkerja' 				=> $nmunker,
			'jabatan' 					=> $nmjab,
			'fid_golru' 				=> $idgolru,
			'tgl_dibuatpenilai' 		=> $dibuatpenilai,
			'tgl_diterimapns' 			=> $diterimapns,
			'tgl_diterimaatasanpenilai' => $diterimaatasanpenilai,
			'tgl_cetak' 				=> $tglcetak,
			'qrcode'					=> $params['data']
		);

		$where = array(
		      	'nip'    => $nip,
	      		'tahun'  => $thn
	    	);

		$nama = $this->mpegawai->getnama($nip);

      		if ($this->mskp->edit_skp($where, $data))
        	{
			$res['data'] = $this->mskp->detail($nip, $thn)->result_array();  	
			//var_dump($res);
		    	$this->load->view('cetakfpk',$res);    
          
        	} else {
          		$data['pesan'] = '<b>Gagal !</b>, Form Prestasi Kerja PNS A.n. <u>'.$nama.'</u> tahun '.$thn.' gagal dicetak.<br />Pastikan data sesuai dengan ketentuan';
          		$data['jnspesan'] = 'alert alert-danger';
        	}		

	}


	// START ENTRI SKP 2021
	function getprilaku2021()
        {
                $jj = $this->input->get('jnsjab');
                $at = $this->input->get('aturan');
		?>
		<div class='row'>                                                
                	<div class='col-md-3'>
			  <div class="input-group navbar-form" align='right' >
                                <span class="input-group-addon" id="basic-addon"><span class="text-primary"><b>Nilai SKP</b></span></span>
                                <input class="form-control" type="text" name="nilaiskp" size='6' maxlength='6' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-3'>
			  <div class="input-group navbar-form" align='right'>
                                <span class="input-group-addon" id="basic-addon1">Orientasi Pelayanan</span>
                                <input class="form-control" type="text" name="orientasipelayanan" size='6' maxlength='6' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
			</div>
			<?php
                        if ($at == "PP46") {
                        ?>
			<div class='col-md-3'>
			  <div class="input-group navbar-form" align='right'>
                                <span class="input-group-addon" id="basic-addon1">Integritas</span>
                                <input class="form-control" type="text" name="integritas" size='6' maxlength='6' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
                        </div>
			<div class='col-md-3'>
			  <div class="input-group navbar-form">
                                <span class="input-group-addon" id="basic-addon1">Disiplin</span>
                                <input class="form-control" type="text" name="disiplin" size='6' maxlength='6' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
                        </div>
			<?php
                        } else if ($at == "PP30") {
                        ?>	
			<div class='col-md-3' align='left'>
			  <div class="input-group navbar-form" align='right'>
                                <span class="input-group-addon" id="basic-addon1">Inisiatif Kerja</span>
                                <input class="form-control" type="text" name="inisiatifkerja" size='5' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
                        </div>
			<?php
			}
			?>
		</div>
		<div class='row'>
			<div class='col-md-3'>
                            <div class="input-group navbar-form">
                                <span class="input-group-addon" id="basic-addon1">Komitmen</span>
                                <input class="form-control" type="text" name="komitmen" size='6' maxlength='6' onkeypress="return hanyaAngkaDesimal(event)" required />
                            </div>
			</div>
			<div class='col-md-3'>
                           <div class="input-group navbar-form">
                                <span class="input-group-addon" id="basic-addon1">Kerjasama</span>
                                <input class="form-control" type="text" name="kerjasama" size='6' maxlength='6' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
			</div>
			<div class='col-md-3'>
                          <?php
                          if ($jj == "STRUKTURAL") {
                          ?>
                           <div class="input-group navbar-form">
                                <span class="input-group-addon" id="basic-addon1">Kepemimpinan</span>
                                <input class="form-control" type="text" name="kepemimpinan" size='5' maxlength='5' onkeypress="return hanyaAngkaDesimal(event)" required />
                          </div>
                          <?php
                          }
                          ?>
			</div>
		</div>
	<?php

	}

	function tambah2021_aksi(){
                $nip = addslashes($this->input->post('nip'));
                $jenis = addslashes($this->input->post('jenis'));
                $aturan = addslashes($this->input->post('aturan'));
                $tahun = addslashes($this->input->post('tahun'));
                
		$nilaiskp = addslashes($this->input->post('nilaiskp'));
                $orientasipelayanan = addslashes($this->input->post('orientasipelayanan'));
                $integritas = addslashes($this->input->post('integritas'));
                $komitmen = addslashes($this->input->post('komitmen'));
                $disiplin = addslashes($this->input->post('disiplin'));
                $inisiatifkerja = addslashes($this->input->post('inisiatifkerja'));
                $kerjasama = addslashes($this->input->post('kerjasama'));
		$kepemimpinan = addslashes($this->input->post('kepemimpinan'));
                if ($kepemimpinan == '') {
                        $kepemimpinan = 0;
                }

		$jnspp = $this->input->post('jnspp');
                $namapp = addslashes($this->input->post('namapp'));
                $jabatanpp = addslashes($this->input->post('jabatanpp'));
                if ($jnspp == 'PNS') {
                        $nippp = addslashes($this->input->post('nippp'));
                        $id_golrupp = addslashes($this->input->post('id_golrupp'));
                        $id_unkerpp = addslashes($this->input->post('id_unkerpp'));
                        $nama_unkerpp = $this->munker->getnamaunker($id_unkerpp);

                        // nama unker ambil dari textbox
                        $nama_unkerpp = strtoupper(addslashes($this->input->post('namaunkerpp')));
                } else if ($jnspp == 'NONPNS') {
                        $nippp = '';
                        $id_golrupp = '';
                        $nama_unkerpp = addslashes($this->input->post('unkerpp'));
                }

		$jnsapp = $this->input->post('jnsapp');
                $namaapp = addslashes($this->input->post('namaapp'));
                $jabatanapp = addslashes($this->input->post('jabatanapp'));

                if ($jnsapp == 'PNS') {
                        $nipapp = addslashes($this->input->post('nipapp'));
                        $id_golruapp = addslashes($this->input->post('id_golruapp'));
                        $id_unkerapp = addslashes($this->input->post('id_unkerapp'));
                        $nama_unkerapp = $this->munker->getnamaunker($id_unkerapp);

                        // nama unker ambil dari textbox
                        $nama_unkerapp = strtoupper(addslashes($this->input->post('namaunkerapp')));
                } else if ($jnsapp == 'NONPNS') {
                        $nipapp = '';
                        $id_golruapp = '';
                        $nama_unkerapp = addslashes($this->input->post('unkerapp'));
                }

		$user_entri = $this->session->userdata('nip');
            	$tgl_entri = $this->mlogin->datetime_saatini();

                // menentukan pembagi nilai prilaku kerja
                // jika kepemimpinan kosong (tenaga staf, jfu, jft), prilaku kerja dibagi 5
                if (($kepemimpinan == '') || ($kepemimpinan == 0)) {
			if (($inisiatifkerja == '') OR ($inisiatifkerja == 0)) { // PP 46/2011
				$nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama)/5);

				//menentukan nilai prestasi kerja
                        	$nilai_prestasi_kerja = (0.6*$nilaiskp) + (0.4*$nilai_prilaku_kerja);
			} else { // PP 30/2019
				$nilai_prilaku_kerja = (($orientasipelayanan+$komitmen+$inisiatifkerja+$kerjasama)/4);
				
				//menentukan nilai prestasi kerja
                                $nilai_prestasi_kerja = (0.7*$nilaiskp) + (0.3*$nilai_prilaku_kerja);
			}
		} else {
			if (($inisiatifkerja == '') OR ($inisiatifkerja == 0)) { // PP 46/2011
                                $nilai_prilaku_kerja = (($orientasipelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan)/6);

				//menentukan nilai prestasi kerja
                                $nilai_prestasi_kerja = (0.6*$nilaiskp) + (0.4*$nilai_prilaku_kerja);
                        } else { // PP 30/2019
                                $nilai_prilaku_kerja = (($orientasipelayanan+$komitmen+$inisiatifkerja+$kerjasama+$kepemimpinan)/5);

				//menentukan nilai prestasi kerja
                                $nilai_prestasi_kerja = (0.7*$nilaiskp) + (0.3*$nilai_prilaku_kerja);
                        }
		}

		//menentukan nilai prestasi kerja
                //$nilai_prestasi_kerja = (0.6*$nilaiskp) + (0.4*$nilai_prilaku_kerja);

                $data = array(
                        'nip'                   => $nip,
                        'jns_skp'               => $jenis,
                        'tahun'                 => $tahun,
                        'nilai_skp'             => $nilaiskp,
                        'orientasi_pelayanan'   => $orientasipelayanan,
                        'integritas'            => $integritas,
                        'komitmen'              => $komitmen,
                        'disiplin'              => $disiplin,
                        'kerjasama'             => $kerjasama,
                        'inisiatifkerja'        => $inisiatifkerja,
			'kepemimpinan'          => $kepemimpinan,
                        'nilai_prilaku_kerja'   => $nilai_prilaku_kerja,
                        'nilai_prestasi_kerja'  => $nilai_prestasi_kerja,
                        'nip_pp'                => $nippp,
                        'nama_pp'               => $namapp,
                        'fid_golru_pp'          => $id_golrupp,
                        'jab_pp'                => $jabatanpp,
                        'unor_pp'               => $nama_unkerpp,
                        'nip_app'               => $nipapp,
                        'nama_app'              => $namaapp,
                        'fid_golru_app'         => $id_golruapp,
                        'jab_app'               => $jabatanapp,
                        'unor_app'              => $nama_unkerapp,
                        'created_at'            => $tgl_entri,
                        'created_by'            => $user_entri
                        );

                //$this->mskp->input_data($data);

	     	if (($this->mskp->cekskp($data['nip'], $data['tahun']) == 0) AND ($data['integritas'] != 0) AND ($data['disiplin'] != 0)) {
	     		// Entri SKP PP 46/2011
			if ($this->mskp->input_data($data))
                	{
                        	$data['pesan'] = '<b>Sukses</b>, Data SKP Tahun '.$data['tahun'].' PP 46/2011 berhasil ditambah';
                        	$data['jnspesan'] = 'alert alert-success';
				// Untuk Integrasi BKN
				$jnsPeraturan = "PP46";
				$inisiatifkerja = 0;				
                	} else {
                        	$data['pesan'] = '<b>Gagal !</b>, Data SKP Tahun '.$data['tahun'].' pp 46/2011 gagal ditambah';
                        	$data['jnspesan'] = 'alert alert-danger';
                	}
	     	} else if (($this->mskp->cekskp($data['nip'], $data['tahun']) == 1) AND ($this->mskp->cekskp2021_pp46($data['nip']))) {
                        // Entri SKP PP 30/2019
                        if ($this->mskp->input_data($data))
                        {
                                $data['pesan'] = '<b>Sukses</b>, Data SKP Tahun '.$data['tahun'].' PP 30/2019 berhasil ditambah';
                                $data['jnspesan'] = 'alert alert-success';
				// Untuk Integrasi BKN
				$jnsPeraturan = "PP30";
				$integritas = 0;
				$disiplin = 0;				
                        } else {
                                $data['pesan'] = '<b>Gagal !</b>, Data SKP Tahun '.$data['tahun'].' PP 30/2019 gagal ditambah';
                                $data['jnspesan'] = 'alert alert-danger';
                        }
                } else if ($data['inisiatifkerja'] != 0) {
			$data['pesan'] = '<b>Entri dahulu SKP 2021 sesuai PP 46/2011 Gaes</b>, Data SKP Tahun 2021 sesuai PP 30/2019 gagal ditambah.';
                        $data['jnspesan'] = 'alert alert-danger';
                } else {
			$data['pesan'] = '<b>Data Rangkap</b>, Data SKP Tahun 2021 gagal ditambah.';
                        $data['jnspesan'] = 'alert alert-danger';
		}

		// START INTEGRASI
		
		 	if ($jnsPeraturan)
                        {
                                // Start Post Json SKP to SAPK Training
                                $skp = $this->mskp->detail($nip, '2021')->result_array();
                                //var_dump($skp);

                                //masukkan data kedalam variabel
                                $data['skp'] = $skp;

                                //deklarasi variabel array
                                //lopping data dari database

				if ($skp) {
                                        foreach ($skp as $hasil)
                                        {
					    if ($jnsPeraturan == "PP46") {
                                                $jml = round($hasil['orientasi_pelayanan'],2) + round($hasil['integritas'],2)
                                                        + round($hasil['komitmen'],2) + round($hasil['disiplin'],2) + round($hasil['kerjasama'],2)
                                                        + round($hasil['kepemimpinan'],2);

                                                if ($hasil['jns_skp'] == "STRUKTURAL") {
                                                        $rata = $jml / 6;
                                                        $jnsjab = "1";
                                                } else if ($hasil['jns_skp'] == "FUNGSIONAL TERTENTU") {
                                                        $rata = $jml / 5;
                                                        $jnsjab = "2";
                                                } else if ($hasil['jns_skp'] == "FUNGSIONAL UMUM") {
                                                        $rata = $jml / 5;
                                                        $jnsjab = "4";
                                                }
					    } else if ($jnsPeraturan == "PP30") {
						$jml = round($hasil['orientasi_pelayanan'],2) + round($hasil['komitmen'],2) 
							+ round($hasil['kerjasama'],2)
                                                        + round($hasil['kepemimpinan'],2) + round($hasil['inisiatifkerja'],2);

                                                if ($hasil['jns_skp'] == "STRUKTURAL") {
                                                        $rata = $jml / 5;
                                                        $jnsjab = "1";
                                                } else if ($hasil['jns_skp'] == "FUNGSIONAL TERTENTU") {
                                                        $rata = $jml / 4;
                                                        $jnsjab = "2";
                                                } else if ($hasil['jns_skp'] == "FUNGSIONAL UMUM") {
                                                        $rata = $jml / 4;
                                                        $jnsjab = "4";
                                                }
					    }

						if (($hasil['tahun'] == '2021') AND ($hasil['integritas'] != '0') AND ($hasil['disiplin'] != '0')) {
                                        		$konversi = $this->mskp->konversiskp_pp46(round($hasil['nilai_prestasi_kerja'], 2));
							$nintegrasi = 0;
                                		} else if (($hasil['tahun'] == '2021') AND ($hasil['inisiatifkerja'] != '0')) {
							$konversi = 0;
                                        		$getnpk = $this->mskp->get_nilaiprestasikerja($nip,2021)->result_array();
                                        		$nintegrasi = 0;
                                        		foreach($getnpk as $np):
                                                		$nintegrasi = $nintegrasi + ($np['nilai_prestasi_kerja'] * 0.5);
                                        		endforeach;
                                        		//$predikat = $this->mskp->get_predikat2021($nintegrasi);
                                        		//echo "<br/><b><span class='text-danger'><small>INTEGRASI<br>".round($nintegrasi,3)."<br/>(".$predikat.")</small></span></b>";
                                		}

						//$pnsid_user = $this->mwsbkn->get_pnsid($this->session->userdata('nip'));
                                                $pnsid = $this->mwsbkn->get_pnsid($nip);
                                                $pnsid_pp = $this->mwsbkn->get_pnsid($hasil['nip_pp']);
                                                $pnsid_app = $this->mwsbkn->get_pnsid($hasil['nip_app']);
                                                //$pnsid_pp = "-";
                                                //$pnsid_app = "-";

                                                $tmtgolru_pp = $this->mpegawai->gettmtkpterakhir($hasil['nip_pp']);
                                                $tmtgolru_app = $this->mpegawai->gettmtkpterakhir($hasil['nip_app']);
                                                //$tmtgolru_pp = "-";
                                                //$tmtgolru_app = "-";

                                                $golru_pp = $this->mpegawai->getnamagolru($hasil['fid_golru_pp']);
                                                $golru_app = $this->mpegawai->getnamagolru($hasil['fid_golru_app']);

						$posts = array(
                                                        "id" => null,
                                                        "tahun" => floatval($tahun),
                                                        "nilaiSkp" => floatval($hasil['nilai_skp']),
                                                        "orientasiPelayanan" => floatval($hasil['orientasi_pelayanan']),
                                                        "integritas" => floatval($hasil['integritas']),
                                                        "komitmen" => floatval($hasil['komitmen']),
                                                        "disiplin" => floatval($hasil['disiplin']),
                                                        "kerjasama" => floatval($hasil['kerjasama']),
                                                        "nilaiPerilakuKerja" => floatval($hasil['nilai_prilaku_kerja']),
                                                        "nilaiPrestasiKerja" => floatval($hasil['nilai_prestasi_kerja']),
                                                        "kepemimpinan" => floatval($hasil['kepemimpinan']),
                                                        "jumlah" => floatval($jml),
                                                        "nilairatarata" => floatval($rata),
                                                        "atasanPejabatPenilai" => $pnsid_app,
                                                        "pejabatPenilai" => $pnsid_pp,
                                                        "pnsDinilaiOrang" => $pnsid,
                                                        "penilaiNipNrp" => $hasil['nip_pp'],
							"atasanPenilaiNipNrp" => $hasil['nip_app'],
                                                        "penilaiNama" => $hasil['nama_pp'],
                                                        "atasanPenilaiNama" => $hasil['nama_app'],
                                                        "penilaiUnorNama" => $hasil['unor_pp'],
                                                        "atasanPenilaiUnorNama" => $hasil['unor_app'],
                                                        "penilaiJabatan" => $hasil['jab_pp'],
                                                        "atasanPenilaiJabatan" => $hasil['jab_app'],
                                                        "penilaiGolongan" => $golru_pp,
                                                        "atasanPenilaiGolongan" => $golru_app,
                                                        "penilaiTmtGolongan" => $tmtgolru_pp,
                                                        "atasanPenilaiTmtGolongan" => $tmtgolru_app,
                                                        "statusPenilai" => "PNS",
                                                        "statusAtasanPenilai" => "PNS",
                                                        "jenisJabatan" => $jnsjab,
							"jenisPeraturanKinerjaKd" => $jnsPeraturan,
							"inisiatifKerja" => $inisiatifkerja,
							"konversiNilai" => $konversi,
							"nilaiIntegrasi" => $nintegrasi,
                                                        "pnsUserId" => "A8ACA7E42B1F3912E040640A040269BB" // pnsid Admin SAPK BKN
                                                        //"pnsUserId" => '' // UNTUK UJICOBA ja supaya kada masuk datanya ke SAPK BKN
                                                );
					$data_string = json_encode($posts);
                                        //var_dump($data_string);

                                        // post into duplex ws training
                                        //$resultApi = apiResult2('https://wsrv-duplex-training.bkn.go.id/api/skp/save', $data_string);
                                        // post into duplex ws production
                                        $resultApi = apiResult2('https://wsrv-duplex.bkn.go.id/api/skp/2021/save', $data_string);

                                        //var_dump($data_string);
                                        $objRest = json_decode($resultApi, true);
                                        //var_dump($objRest);
		
					if($objRest['success']) {
                                        	$dataidbkn = array(
                                                	'id_bkn' => $objRest['mapData']['rwSkpId']
                                                );
                                                $whereidbkn = array(
                                                	'nip'    => $nip,
                                                        'tahun'  => $tahun
                                                );
                                                
					        if ($this->mskp->edit_skp($whereidbkn, $dataidbkn))
                                                {
                                                	$data['pesan'] = '<b>Sukses</b>, Data SKP Tahun '.$data['tahun'].' berhasil ditambah pada SILKa dan SAPK BKN';
                                                        $data['jnspesan'] = 'alert alert-success';
                                                } else {
                                                        $data['pesan'] = '<b>Warning</b>, ID Riwayat Data SKP Tahun '.$data['tahun'].' Tidak Berhasil ditambah pada SILKa';
                                                        $data['jnspesan'] = 'alert alert-warning';
                                                }
                                         } else {
                                                $data['pesan'] = '<b>Gagal</b>, Data SKP Tahun '.$data['tahun'].' gagal ditambah pada SAPK';
                                                $data['jnspesan'] = 'alert alert-danger';
                                         }
				} // End Foreach
			} // End If
		} // End If				

		// END INTEGRASI
	     

                // tampilkan view rwyskp
                $data['nip'] = $nip;
                $data['pegrwyskp'] = $this->mpegawai->rwyskp($nip)->result_array();
            	$data['content'] = 'rwyskp';
            	$this->load->view('template', $data);
	}
	
  	// END ENTRI SKP 2021
}
