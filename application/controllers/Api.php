<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
    
    function __construct() {
		
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
    	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        //load model web
        $this->load->model('Mapi');
	$this->load->model('Mpegawai');	
 	$this->load->model('mpegawai');
        $this->load->model('Mskp');            
        $this->load->model('mwsbkn'); 
	$this->load->model('Mkinerja');
	$this->load->model('mgraph');	
        $this->load->helper('fungsitanggal');	
        $this->load->helper('fungsipegawai'); 
	$this->load->helper('fungsiwsbkn');
    }

    
    public function index()
    {
        //get data dari model
        $agama = $this->Mapi->get_agama();
        //masukkan data kedalam variabel
        $data['agam'] = $agama;
        //deklarasi variabel array
        $response = array();
        $posts = array();
        //lopping data dari database
        foreach ($agama as $hasil)
        {
            $posts[] = array(
                "id"                 =>  $hasil->id_agama,
                "nama"            =>  $hasil->nama_agama
            );
        }
        $response['agama'] = $posts;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);

    }
    
    function filternipnama() {
	   $nip = $this->input->post('nip');
	   $nama = $this->input->post('nama');
	   $db = $this->Mapi->filternipnama('pegawai', $nip, $nama);
		  if($db->num_rows() > 0) {
		    $row = $db->result();
		     $data = [];
		     foreach($row as $r) {
		     	
		     	//Cek file photo
		     	$lokasifile = './photo/';
          $filename = $r->nip.".jpg";
		      if (file_exists ($lokasifile.$filename)) {
		      	$photo = base_url()."photo/".$r->nip.".jpg";
		      } else {
		      	$photo = base_url()."/photo/nophoto.jpg";
		      }
		      
		      $data[] = ['nip' => $r->nip, 'nama' => $r->nama, 'photo' => $photo];
		    }
		   }
		   echo json_encode($data);
	   //var_dump(['data' => $data]);
		}
		
	 // API untuk SKM (Survei Kepuasan Masyarakat)
	 public function filternipnik($d=null) {
	 	$db = $this->Mapi->filternipnik($d);
	 	//var_dump();die();
		if(count($db[0]) > 0) {
			
			$jp = $db[0][0]->jns_kelamin == 'PRIA' ? 'L' : '';
			$jw = $db[0][0]->jns_kelamin == 'WANITA' ? 'P' : '';
			
			$tgl_lahir = explode('-',$db[0][0]->tgl_lahir);
			$umur = intval(date('Y') - $tgl_lahir[0]);
			
			$data[] = ['kind' => true, 
						  'message' => 'Data ditemukan pada SILKa Online Balangan', 
						  'id' => $db[0][0]->nik, 
						  'nama' => $db[0][0]->nama, 
						  'jk' => $jp.$jw,
						  'umur' => $umur,
						  'count' => count($db[0])];
		} elseif(count($db[1]) > 0) {
			$tgl_lahir = explode('-',$db[1][0]->tgl_lahir);
			$umur = intval(date('Y') - $tgl_lahir[0]);
			
			$data[] = ['kind' => true, 
						  'message' => 'Data ditemukan pada SILKa Online Balangan', 
						  'id' => $db[1][0]->nip,
						  'jk' => $db[1][0]->jenis_kelamin,
						  'umur' => $umur, 
						  'nama' => $db[1][0]->nama, 
						  'count' => count($db[1])];	
		} else {
			$data[] = ['kind' => false,'message' => 'Data tidak ditemukan pada SILKa Online Balangan'];
		}
	 	echo json_encode($data);
	 	//var_dump($db);
	 }
	
    function get_grap($method) {
    		if($method == 'pns') {
    			$response = $this->Mapi->jmlpns();
    		} elseif($method == 'nonpns') {
    			$response = $this->Mapi->jmlnonpns();
    		} elseif($method == 'pensiun') {
    			$response = $this->Mapi->jmlpensiun(date('Y'));
    		} elseif($method == 'asn') {
    			$response = $this->Mapi->jmlasn();
    		}
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);
    }

    function get_grap_all() {
        $response = [
            'pns' => $this->Mapi->jmlpns(),
            'nonpns' => $this->Mapi->jmlnonpns(),
            'pensiun' => $this->Mapi->jmlpensiun(date('Y')),
            'asn' => $this->Mapi->jmlasn(),
        ];
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);
    }
    
    function get_grap_pns($jenis) {
    	if($jenis == 'jenkel') {
    		$data = $this->mgraph->jenkel();
                foreach($data as $d) {
			if($d->jenis_kelamin == 'P') {
			 $jenisK = 'Perempuan';
			} else {
			 $jenisK = 'Laki - Laki';
			}
			$ress['name'] = $jenisK;
			$ress['y'] = (int) $d->jumlah;
			$res[] = $ress;
                }
		foreach($data as $n) {
			$nm[] = $n->jenis_kelamin;
		}

    	} elseif ($jenis == 'golru') {
    		$data = $this->mgraph->golru();
    		foreach($data as $d) {
    			$res[] = (int) $d->jumlah;
    		}
		foreach($data as $n) {
                        $nm[] = $n->nama_golru;
		}	
    	} elseif ($jenis == 'eselon') {
    		$data = $this->mgraph->eselon();
    		foreach($data as $d) {
			$ress['name'] = $d->nama_eselon;
    			$ress['data'] = [(int)$d->jumlah];
			$res[] = $ress;
    		}		
		foreach($data as $n) {
                        $nm[] = $n->nama_eselon;
                }
    	} elseif ($jenis == 'jenjab') {
    		$data = $this->mgraph->jenjab();
		foreach($data as $d) {
			$ress['name'] = $d->nama_jenis_jabatan;
                        $ress['y'] = (int) $d->jumlah;
			$res[] = $ress;
                }
                foreach($data as $n) {
                        $nm[] = $n->nama_jenis_jabatan;
                }
	
    	} elseif ($jenis == 'tingpen') {
    		$data = $this->mgraph->tingpen();
		foreach($data as $d) {
                        $res[] = (int) $d->jumlah;
                }
                foreach($data as $n) {
                        $nm[] = $n->nama_tingkat_pendidikan;
                }

    	}

			echo json_encode(['jml' => $res, 'nama' => $nm]);
		}
		
		function get_profile_pns() {
			$nip = $this->input->get('nip');
			$req = md5($nip);
			
			$pns = $this->Mapi->get_profile_pegawai($nip)->row();
			$output = [
				'nama' 	 => $pns->nama,
				'photo'  => 'http://192.168.1.4/photo/'.$nip.'.jpg',
				'alamat' => $pns->alamat
			];
			
			echo json_encode(['data' => $output]);
		}
    

    function get_agama() {
        $id = $this->input->get('id');
                        
        $this->db->select('nama_agama');
        $this->db->from('ref_agama');
        $this->db->where("id_agama !=", $id);
        //$this->db->where("nama_agama !=", "BUDHA");
        $agama=$this->db->get()->result();

        //$this->db->where('id_agama', $id);
        //$agama = $this->db->get('ref_agama')->result();

        $response['agama'] = $agama;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);
    }

    //http://localhost/silka/index.php/api/get_pns?nip=198104072009041002
    function get_pns() {
        $nip = $this->input->get('nip');
        $this->db->where('nip', $nip);
        $pns = $this->db->get('pegawai')->result();

        $response['get_pns'] = $pns;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);
    }
    	
    
    //http://localhost/silka/index.php/api/get_pns1?nip=198104072009041002
    /*
    function detail_pns() {        
        $nip = htmlspecialchars($this->input->post('nip'));
        $sql = "select p.nip, CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as nama, p.tmp_lahir as 'tmpl',
p.tgl_lahir as 'tgll', p.jenis_kelamin as 'jk', ns.nama_status_pegawai as 'stapeg', u.nama_unit_kerja as 'uk',
(select js.nama_jabatan from ref_jabstruk as js, pegawai as p where p.fid_jabatan=js.id_jabatan and p.nip='$nip') as js,
(select ju.nama_jabfu from ref_jabfu as ju, pegawai as p where p.fid_jabfu=ju.id_jabfu and p.nip='$nip') as jfu,
(select jt.nama_jabft from ref_jabft as jt, pegawai as p where p.fid_jabft=jt.id_jabft and p.nip='$nip') as jft,
p.tmt_jabatan as 'tmtjab', g.nama_golru as 'gl', p.tmt_golru_skr as 'tmtgl', 
CONCAT(tp.nama_tingkat_pendidikan,' - ',jp.nama_jurusan_pendidikan) as dikkir
from pegawai as p, ref_status_pegawai as ns, ref_golru as g, ref_tingkat_pendidikan as tp,
ref_jurusan_pendidikan as jp, ref_unit_kerjav2 as u
where
p.fid_golru_skr = g.id_golru
and p.fid_status_pegawai = ns.id_status_pegawai
and p.`fid_unit_kerja` = u.id_unit_kerja
and p.`fid_tingkat_pendidikan` = tp.`id_tingkat_pendidikan`
and p.`fid_jurusan_pendidikan` = jp.`id_jurusan_pendidikan`
and p.nip='$nip'";
        $hasil = $this->db->query($sql)->result();
        //$response['detail_pns'] = $hasil;
        header('Content-Type: application/json');
        echo json_encode($hasil,TRUE);   
    }
    */


    function detail_pns() {        
        $nip = $this->input->post('nip');

        $nilai = $this->Mapi->detail_pns($nip);
        //masukkan data kedalam variabel
        $data['nilai'] = $nilai;
        //deklarasi variabel array
        //lopping data dari database
        if ($nilai) {
            foreach ($nilai as $hasil)
            {
                if ($hasil->jenis_kelamin == "L") {
                    $jenkel = "LAKI-LAKI";
                } else {
                    $jenkel = "PEREMPUAN";
                }

                if ($hasil->jabstruk != null) {
                    $jabatan = $hasil->jabstruk;
                } else if ($hasil->jabfu != null) {
                    $jabatan = $hasil->jabfu;
                } else if ($hasil->jabft != null) {
                    $jabatan = $hasil->jabft;
                }

                if ($hasil->nama_kelurahan == "LUAR BALANGAN") {
                    $alamat = $hasil->alamat;
                } else {
                    $alamat = $hasil->alamat." ".$hasil->nama_kelurahan." KEC. ".$hasil->nama_kecamatan;
                }

		$lokasifile = './photo/';
                $filename = "$nip.jpg";
		if (file_exists ($lokasifile.$filename)) {
                    $photo = $nip;
                  } else {
                    $photo = "nophoto";
                  }

		$golru = $this->Mpegawai->getnamagolru($hasil->fid_golru_skr);
                $pangkat = $this->Mpegawai->getnamapangkat($hasil->fid_golru_skr);

                // untuk photo :
                // http://silka.bkppd-balangankab.info/photo/199404092016092004.jpg

                $posts[] = array(
                    //"nip"                 =>  $enk_nip,
                    "nip"            =>  $hasil->nip,
                    "nama"           =>  $hasil->nama,
                    "ttl"            =>  $hasil->tmp_lahir." / ".tgl_indo($hasil->tgl_lahir),
                    "jenkel"         =>  $jenkel,
                    "statkaw"        =>  $hasil->nama_status_kawin,
                    "agama"          =>  $hasil->nama_agama,
                    "statpeg"        =>  $hasil->nama_status_pegawai,
                    "unker"          =>  $hasil->nama_unit_kerja,
                    "jab"            =>  $jabatan,
                    "tmtjab"         =>  tgl_indo($hasil->tmt_jabatan),
                    "golru"          =>  $pangkat." (".$golru.")",
                    "tmtgolru"       =>  tgl_indo($hasil->tmt_golru_skr),                    
                    "pdk"            =>  $hasil->pendidikan,
                    //"nokarpeg"       =>  $hasil->no_karpeg,
                    //"noktp"          =>  $hasil->no_ktp,
                    //"nonpwp"         =>  $hasil->no_npwp,
                    //"alamat"         =>  $alamat,
                    //"telepon"        =>  $hasil->telepon,
		    //"photo"	     =>  $photo
                );
            }
        
        header('Accept: application/json');
	header('Content-Type: multipart/form-data');
	header('Authorization: Simgaji');
        echo json_encode($posts,TRUE);
        }   
    }

    
    //http://silka.bkppd.local/api/pnsperunker?id=40
    function pnsperunker() {        
        $idunker = $this->input->get('id');
        $nilai = $this->Mapi->pnsperunker($idunker);
        //masukkan data kedalam variabel
        $data['nilai'] = $nilai;
        //deklarasi variabel array
        //lopping data dari database
        if ($nilai) {
            foreach ($nilai as $hasil)
            {
                if ($hasil->jenis_kelamin == "L") {
                    $jenkel = "LAKI-LAKI";
                } else {
                    $jenkel = "PEREMPUAN";
                }
               
                $jabatan = $this->Mpegawai->namajabnip($hasil->nip);
                
                $golru = $this->Mpegawai->getnamagolru($hasil->fid_golru_skr);
                $pangkat = $this->Mpegawai->getnamapangkat($hasil->fid_golru_skr);


                // untuk photo :
                // http://silka.bkppd-balangankab.info/photo/199404092016092004.jpg

                $posts[] = array(
                    //"nip"                 =>  $enk_nip,
                    "nip"            =>  $hasil->nip,
                    "nama"           =>  $hasil->nama,
                    //"ttl"            =>  $hasil->tmp_lahir." / ".tgl_indo($hasil->tgl_lahir),
                    //"jenkel"         =>  $jenkel,
                    "statpeg"        =>  $hasil->nama_status_pegawai,
                    "unker"          =>  $hasil->nama_unit_kerja,
                    "jab"            =>  $jabatan,
                    //"tmtjab"         =>  tgl_indo($hasil->tmt_jabatan),
                    //"golru"          =>  $pangkat." (".$golru.")",
                    //"tmtgolru"       =>  tgl_indo($hasil->tmt_golru_skr),                    
                    //"pdk"            =>  $hasil->pendidikan,                    
                    //"thnlulus"            =>  $hasil->tahun_lulus
                );
            }
        
        header('Content-Type: application/json');
        echo json_encode($posts,TRUE);
        }   
    }

    function skp_tahun() {        
        $nip = $this->input->get('nip');
        $thn = $this->input->get('thn');

        $skp = $this->Mskp->detail($nip, $thn)->result_array();
        //var_dump($skp);

        //masukkan data kedalam variabel
        $data['skp'] = $skp;

        //deklarasi variabel array
        //lopping data dari database
        if ($skp) {
            foreach ($skp as $hasil)
            {                
                $jml = round($hasil['orientasi_pelayanan'],2) + round($hasil['integritas'],2) + round($hasil['komitmen'],2) + round($hasil['disiplin'],2) + round($hasil['kerjasama'],2) + round($hasil['kepemimpinan'],2);

                if ($hasil['jns_skp'] == 'STRUKTURAL') {
                    $rata = $jml / 6;
                    $jnsjab = '1';
                } else if ($hasil['jns_skp'] == 'FUNGSIONAL TERTENTU') {
                    $rata = $jml / 5;                    
                    $jnsjab = '2';
                } else if ($hasil['jns_skp'] == 'FUNGSIONAL UMUM') {
                    $rata = $jml / 5;                    
                    $jnsjab = '4';
                } 

                //$pnsid_user = $this->Mwsbkn->get_pnsid($this->session->userdata('nip'));
                $pnsid = $this->Mwsbkn->get_pnsid($nip);
                $pnsid_pp = $this->Mwsbkn->get_pnsid($hasil['nip_pp']);
                $pnsid_app = $this->Mwsbkn->get_pnsid($hasil['nip_app']);
                //$pnsid_pp = "-";
                //$pnsid_app = "-";

                $tmtgolru_pp = tgl_indo_pendek($this->Mpegawai->gettmtkpterakhir($hasil['nip_pp']));
                $tmtgolru_app = tgl_indo_pendek($this->Mpegawai->gettmtkpterakhir($hasil['nip_app']));
                //$tmtgolru_pp = "-";
                //$tmtgolru_app = "-";

                $golru_pp = $this->Mpegawai->getnamagolru($hasil['fid_golru_pp']);
                $golru_app = $this->Mpegawai->getnamagolru($hasil['fid_golru_app']);
                

                $posts = array(
                    "id" => null, 
                    "tahun" => floatval($thn),
                    "nilaiSkp" => floatval($hasil['nilai_skp']),
                    "orientasiPelayanan" => floatval($hasil['orientasi_pelayanan']),
                    "integritas" => floatval($hasil['integritas']),
                    "komitmen" => floatval($hasil['komitmen']),
                    "disiplin" => floatval($hasil['disiplin']),
                    "kerjasama" => floatval($hasil['kerjasama']),
                    "nilaiPerilakuKerja" => round($hasil['nilai_prilaku_kerja'],2),
                    "nilaiPrestasiKerja" => round($hasil['nilai_prestasi_kerja'],2),
                    "kepemimpinan" => floatval($hasil['kepemimpinan']),
                    "jumlah" => floatval($jml),
                    "nilairatarata" => round($rata,2),
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
                    "pnsUserId" => $pnsid,
                );
            }
        
        header('Content-Type: application/json');
        echo json_encode($posts,TRUE);
        }   
    }

    function upjabsapk() {        
        $nip = $this->input->post('nip');
        
        $data = $this->Mwsbkn->forupjabsapk($nip)->result_array();
        
	foreach ($data as $hasil)
        {
            if ($hasil['nama_jenis_jabatan'] == "STRUKTURAL") {
                $unorId = $hasil['idbkn_jab'];
                $eslId = $hasil['idbkn_esl'];
                $jabftId = "";
                $jabfuId = "";
                
                if ($hasil['tmt_pelantikan'] == "") {
                    $tgllantik = tgl_indo_pendek($hasil['tmt_jabatan']);
                } else {
                    $tgllantik = tgl_indo_pendek($hasil['tmt_pelantikan']);
                }

            } else if ($hasil['nama_jenis_jabatan'] == "FUNGSIONAL UMUM") {
                $unorId = $hasil['idbkn_unor'];
                $eslId = "";
                $jabftId = "";
                $jabfuId = $hasil['idbkn_jab'];
                $tgllantik = "";
            } else if ($hasil['nama_jenis_jabatan'] == "FUNGSIONAL TERTENTU") {
                $unorId = $hasil['idbkn_unor'];
                $eslId = "";
                $jabftId = $hasil['idbkn_jab'];
                $jabfuId = "";
                $tgllantik = "";                
            }

            $posts = array(
                 "id"           => null,
                 "jenisJabatan" => $hasil['idbkn_jnsjab'],
                 "unorId"       => $unorId,
                 "eselonId"     => $eslId,
                 "instansiId"   => "A5EB03E23CF4F6A0E040640A040252AD",
                 "pnsId"        => $hasil['idbkn_pns'],
                 "jabatanFungsionalId"      => $jabftId,
                 "jabatanFungsionalUmumId"  => $jabfuId,
                 "nomorSk"                  => $hasil['no_sk'],
                 "tanggalSk"                => tgl_indo_pendek($hasil['tgl_sk']),
                 "tmtJabatan"               => tgl_indo_pendek($hasil['tmt_jabatan']),
                 "tmtPelantikan"            => $tgllantik,
                 "pnsUserId"                => "A8ACA7E42B1F3912E040640A040269BB"
            );

            $data_string = json_encode($posts);
            $resultApi = apiResult2('https://wsrv-duplex.bkn.go.id/api/jabatan/save', $data_string);
            //var_dump($data_string);
            $objRest = json_decode($resultApi, true);
            //var_dump($objRest);

            if($objRest['success']) {
                $dataidbkn = array(
                    'id_bkn' => $objRest['mapData']['rwJabatanId']
                    );
                $whereidbkn = array(
                    'nip'           => $nip,
                    'tmt_jabatan'   => $hasil['tmt_jabatan'],
                    'tgl_sk'        => $hasil['tgl_sk']
                    );

                if ($this->Mpegawai->edit_rwyjab($whereidbkn, $dataidbkn))
                {
                    $data['pesan'] = '<b>Sukses</b>, Data Riwayat Jabatan BERHASIL diupdate pada SAPK BKN';
                    $data['jnspesan'] = 'alert alert-success';
                } else {
                    $data['pesan'] = '<b>Warning</b>, ID Riwayat Jabatan pada SAPK BKN, GAGAL disimpan pada Database Lokal';
                    $data['jnspesan'] = 'alert alert-warning';
                }
            } else {
                $data['pesan'] = '<b>Warning</b>, Data Riwayat Jabatan pada SAPK BKN GAGAL diupdate<br/>'.$objRest['message'];
                $data['jnspesan'] = 'alert alert-danger';
            }

        }
	$data['pegrwyjab']   = $this->mpegawai->rwyjab($nip)->result_array();
    	$data['pegrwyplt']   = $this->mpegawai->rwyplt($nip)->result_array();
    	$data['pegrwypokja'] = $this->mpegawai->rwypokja($nip)->result_array();
    	$data['nip'] = $nip;
    	$data['content'] = 'rwyjab';
    	$this->load->view('template', $data);
    }

    // ENKRIPSI DATA   
    function encrypt($s) {
        $cryptKey    ='da1243ty';
        $qEncoded    =base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5( $cryptKey), $s, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return($qEncoded);
    }
    function decrypt($s) {
        $cryptKey    ='da1243ty';
        $qDecoded    =rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($s), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return($qDecoded);
    }
    // END ENKRIPSI DATA

    //http://silka.bkppd.local/index.php/api/cek_pns_ekinerja?nip=198104072009041002
    function cek_pns_ekinerja() {
        $nip = $this->input->get('nip');
        $sql = "select nip, gelar_depan, nama, gelar_belakang, fid_jnsjab, fid_jabatan, fid_jabfu, fid_jabft, fid_golru_skr, fid_unit_kerja from pegawai where nip='$nip'";
        $jml = $this->db->query($sql)->num_rows();
	if ($jml == 0) {
		$sql = "select nipppk as 'nip', gelar_depan, nama, gelar_blk as 'gelar_belakang', '3' as fid_jnsjab, fid_jabft, fid_golru_pppk as 'fid_golru_skr', fid_unit_kerja from pppk where nipppk='$nip'";
	}
	$hasil = $this->db->query($sql)->result();
        if ($hasil) {
            $response['hasil'] = $hasil;
            //lopping data dari database
            foreach ($hasil as $hasil)
            {
                if ($hasil->gelar_depan) {
                    $nama = $hasil->gelar_depan.' '.$hasil->nama.' '.$hasil->gelar_belakang;
                } else {
                    $nama = $hasil->nama.' '.$hasil->gelar_belakang;
                }
                if ($hasil->fid_jnsjab == "1") {
                    $jab = $hasil->fid_jabatan;                    
                } else if ($hasil->fid_jnsjab == "2") {
                    $jab = $hasil->fid_jabfu;                    
                }else if ($hasil->fid_jnsjab == "3") {
                    $jab = $hasil->fid_jabft;                    
                }

                $idunker_kinerja = $this->Mkinerja->get_idunkerkinerja($hasil->fid_unit_kerja);

                $posts[] = array(
                    "a"  =>  $this->encrypt($hasil->nip),
                    "b"  =>  $this->encrypt($nama),
                    "c"  =>  $this->encrypt($hasil->fid_golru_skr),
                    "d"  =>  $this->encrypt($hasil->fid_jnsjab),
                    "e"  =>  $this->encrypt($jab),
                    "f"  =>  $this->encrypt($hasil->fid_unit_kerja),
                    "g"  =>  $this->encrypt($idunker_kinerja),
                );

          	$response['hasil'] = $posts;
		header('Content-Type: application/json');
        	echo json_encode($response,TRUE);
	    }
        } 
	//else {
        //    $posts[] = array(
        //            "mesg"       =>  "0",                    
        //            "pesan"      =>  "Data tidak ditemukan"
        //        );
        //}
        
	//$response['hasil'] = $posts;
        //header('Content-Type: application/json');
        //echo json_encode($response,TRUE);

    }

    // Save nilai SKP dari Ekinerja
    //http://localhost/silka/index.php/api/save_skpbln?nip=198104072009041002&th=2021&bl=1&nil=92&jab=jabatan&uk=bkppd&lo=2021-01-01&at=atasan
    function save_skpbln() {
        $nip = $this->input->get('nip');
        $thn = $this->input->get('th');
        $bln = $this->input->get('bl');
        $nilai = $this->input->get('nil');
        $jabatan = $this->input->get('jab');
        $unit_kerja = $this->input->get('uk');
        $login = $this->input->get('lo');
        $atasan = $this->input->get('at');

        //$sql = "select nip from pegawai where nip='$nip'";
        //$jumlah = $this->db->query($sql)->num_rows();

        $this->db->select('nip');
        $this->db->from('pegawai');
        $this->db->where('nip', $nip);
        $jumlah = $this->db->get()->num_rows();
        //var_dump($jumlah);

        // Khusus untuk PNS
        if ($jumlah == 1) {
            $tgl_aksi = $this->mlogin->datetime_saatini();

            $data = array(
                    'nip'       => $nip,
                    'bulan'     => $bln,
                    'tahun'     => $thn,
                    'nilai_skp' => round($nilai,2),
                    'jabatan'   => $jabatan,
                    'unit_kerja'        => $unit_kerja,
                    'atasan_langsung'   => $atasan,
                    'login_terakhir'    => $login,
                    'import_by' => $nip,
                    'import_at' => $tgl_aksi
                    );

            // Cek apakah ada data kinerja bulanan, jika ada, update data tsb
            if ($this->Mkinerja->cekada_kinerja_bulanan($nip, $thn, $bln) == 0) {
                if ($this->Mkinerja->input_kinerja_bulanan($data)) {
                    $posts[] = array(
                        "res"       =>  "1",                    
                        "mesg"      =>  "Data SKP Berhasil ditambah"
                    );
                } else {
                    $posts[] = array(
                        "res"       =>  "0",                    
                        "mesg"      =>  "Data Kinerja Gagal ditambah"
                    );
                }
            // jika tidak ada data kinerja bulanan, tambahkan
            } else {
                $where = array(
                    'nip'             => $nip,
                    'bulan'           => $bln,
                    'tahun'           => $thn
                ); 

                if ($this->Mkinerja->update_kinerja_bulanan($where, $data)) {
                    $posts[] = array(
                        "res"       =>  "1",                    
                        "mesg"      =>  "Data SKP Berhasil diupdate"
                    );
                } else {
                    $posts[] = array(
                        "res"       =>  "0",                    
                        "mesg"      =>  "Data SKP Gagal diupdate"
                    );
                }
            }


        } 
       
        $response['hasil'] = $posts;
        header('Content-Type: application/json');
        echo json_encode($response,TRUE);

    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
