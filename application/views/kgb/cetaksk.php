<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{                      
                //$login = new mLogin();
                //$this->setFont('Arial','',9);
                //$this->setFillColor(255,255,255);
                //$this->cell(100,5,"Cetak Usul Cuti",0,0,'L',1); 
                //$this->setFont('Arial','I',8);
                //$this->cell(90,5,'Dicetak oleh '.$login->session->userdata('nama').' ('.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                
                //$this->SetY(15);
                //buat garis horizontal
                //$this->Line(10,$this->GetY(),200,$this->GetY());
                
                /*
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(20,3,'',0,0,'C',0); 
                $this->Image(base_url().'assets/logo.jpg', 20, 22,'8','10','jpeg');
                $this->cell(100,4,'Badan Kepegawaian, Pendidikan dan Pelatihan Daerah',0,1,'L',1); 
                $this->cell(20,3,'',0,0,'C',0); 
                $this->cell(100,6,"Profil PNS",0,1,'L',1); 
                */
                //$this->cell(100,6,"Nama : ".date('M Y'),0,1,'L',1); 
                //$this->cell(23,4,'',0,0,'C',0); 
                //$this->cell(100,6,'NIP : Semarang, Jawa Tengah',0,1,'L',1); 
                
                
                //$this->Ln(5);
                //$this->setFont('Arial','',10);
                //$this->setFillColor(230,230,200);
                //$this->cell(10,6,'No.',1,0,'C',1);
                //$this->cell(105,6,'Nama Lengkap',1,0,'C',1);
                //$this->cell(30,6,'No. HP',1,0,'C',1);
                //$this->cell(50,6,'Jenis Kelamin',1,1,'C',1);
                //$this->cell(50,6,$this->template,1,1,'C',1);
	}
 
	function Content($data)
	{        
        $opeg = new Mpegawai();
        $ounker = new Munker();
        $okgb = new Mkgb();
        $opeg->load->helper('fungsitanggal');
        $opeg->load->helper('fungsipegawai');
        $opeg->load->helper('fungsipegawai');

        foreach ($data as $key) {
            
            $this->Ln(8);
            $this->setFillColor(255,255,255);

            //$this->Image(base_url().'assets/logo.jpg', 30, 12,'20','25','jpeg');
            //$this->Image('assets/logo.jpg', 30, 12,'20','25','jpeg');
            //$this->setFont('Arial','',18);
            //$this->setXY(60,12);$this->MULTICELL(130,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
            //$this->setFont('Arial','B',20);

            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }

	  $nmjab = $opeg->mpegawai->namajab($key->fid_jnsjab, $idjab);
	  $idins = $opeg->munker->get_idinstansi($key->fid_unit_kerja);
	  if ($key->pejabat_sk == "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN") {
	    $this->Image('assets/logo.jpg', 22, 12,'20','25','jpeg');
            $this->setFont('Arial','',14);
            $this->setXY(55,14);$this->MULTICELL(130,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
            $this->setFont('Arial','B',22);
            $this->setXY(42,20);
            $this->MULTICELL(160,7,'DINAS PENDIDIKAN DAN KEBUDAYAAN','','C',1);
            $this->setFont('Arial','',10);
            $this->setXY(50,28);$this->MULTICELL(140,5,'Jln. A. Yani Km. 2,5 Telp/Fax. (0526) 2029521 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71662','','C',1);
	  } else {	
            if ($key->nama_eselon == 'II/A') {
		$this->Image('assets/garudahp.jpg', 95, 3,'25','27','jpeg');
                $this->setFont('Arial','B',20);
                $this->setXY(40,32);$this->MULTICELL(140,7,'BUPATI BALANGAN','','C',1);
                $this->setFont('Arial','',10);
            } else if (($key->nama_eselon == 'II/A') OR ($key->nama_eselon == 'II/B')  OR ($nmjab == 'CAMAT') OR ($nmjab == 'DIREKTUR')) {
                $this->Image('assets/logo.jpg', 30, 12,'20','25','jpeg');
	        $this->setFont('Arial','',18);
            	$this->setXY(60,12);$this->MULTICELL(130,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
                $this->setFont('Arial','B',20);

		$this->setFont('Arial','B',30);
                $this->setXY(55,21);$this->MULTICELL(140,7,'SEKRETARIAT DAERAH','','C',1);
                $this->setFont('Arial','',10);
                $this->setXY(55,30);$this->MULTICELL(140,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028408 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);
            } else {
                $this->Image('assets/logo.jpg', 20, 12,'20','25','jpeg');
            	$this->setFont('Arial','',18);
            	$this->setXY(55,12);$this->MULTICELL(130,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
	        $this->setFont('Arial','B',20);

		$this->setFont('Arial','B',20);
                //$this->setXY(55,18);$this->MULTICELL(140,7,'BADAN KEPEGAWAIAN, PENDIDIKAN DAN PELATIHAN DAERAH','','C',1);
		$this->setXY(42,18);
		$this->MULTICELL(160,7,'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA','','C',1);
                $this->setFont('Arial','',10);
                $this->setXY(50,32);$this->MULTICELL(140,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028060 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);
            }                      
	} // end if tempalte            

            //buat garis horizontal
            $this->Line(20,42,200,42);

            $y = 40;

            $this->setFont('Arial','',11);            
            $this->setFillColor(255,255,255);
            $this->setXY(25,$y+5);
            $this->cell(20,5,'Nomor',0,1,'L',1); 
            $this->setXY(45,$y+5);
            $this->cell(80,5,': '.$key->no_sk,0,1,'L',1); 

            $this->setXY(145,$y+5);
            $this->cell(20,5,'Paringin, '.tgl_indo($key->tgl_sk),0,1,'L',1); 

            $this->setXY(25,$y+10);
            $this->cell(20,5,'Lampiran',0,1,'L',1); 
            $this->setXY(45,$y+10);
            $this->cell(80,5,': -',0,1,'L',1); 
            $this->setXY(25,$y+15);
            $this->cell(20,5,'Perihal',0,1,'L',1); 
            $this->setXY(45,$y+15);
            $this->cell(2.5,5,': Kenaikan Gaji Berkala',0,1,'L',1); 

            $this->setFont('Arial','',10);
            $this->setXY(120,$y+20);
            $this->cell(60,5,"KEPADA :",0,1,'L',1); 
            $this->setXY(120,$y+25);
            $this->MULTICELL(80,4,"KEPALA BADAN PENGELOLAAN KEUANGAN, PENDAPATAN DAN ASET DAERAH",0,'L',1); 
            $this->setXY(120,$y+33);
            $this->cell(60,5,"KABUPATEN BALANGAN",0,1,'L',1); 
            $this->setXY(120,$y+37);
            $this->cell(60,5,"di -",0,1,'L',1); 
            $this->setXY(127,$y+41);
            $this->setFont('Arial','U',10);
            $this->cell(60,5,"Paringin",0,1,'L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(50,$y+55);
            $this->MULTICELL(140,5,"Dengan ini diberitahukan bahwa berhubung dengan dipenuhinya masa kerja dan syarat-syarat lainnya kepada : ",'','J',1); 

            $this->setXY(50,$y+65); $this->cell(55,5,"1. Nama dan Tanggal Lahir",0,1,'L',1); 
            $this->setXY(110,$y+65); $this->cell(3,5,": ",0,1,'L',1);
            $this->setXY(113,$y+65); $this->cell(80,5,$opeg->mpegawai->getnama($key->nip),0,1,'L',1);
            $this->setXY(113,$y+70); $this->cell(50,5,tgl_indo($key->tgl_lahir),0,1,'L',1);
            $this->setXY(50,$y+75); $this->cell(55,5,"2. Nomor Induk Pegawai (NIP)",0,1,'L',1);             
            $this->setXY(110,$y+75); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setXY(113,$y+75); $this->cell(80,5,$key->nip,0,1,'L',1);
            $this->setXY(50,$y+80); $this->cell(55,5,"3. Pangkat / Jabatan",0,1,'L',1);
            $this->setXY(110,$y+80); $this->cell(3,4,": ",0,1,'L',1);
            $this->setFont('Arial','',9);
	    $this->setXY(113,$y+80); $this->cell(80,4,$opeg->mpegawai->getnamapangkat($key->fid_golru_skr)." (".$opeg->mpegawai->getnamagolru($key->fid_golru_skr).")",0,1,'L',1);

            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }

            $this->setFont('Arial','',9);
            $this->setXY(113,$y+84);
	    		if($opeg->mpegawai->namajab($key->fid_jnsjab, $idjab) == '=SEMENTARA=') {
	    			$this->MULTICELL(80,4,'-','','L',1);
	    		} else {
	    			$this->MULTICELL(80,4,strtoupper($opeg->mpegawai->namajab($key->fid_jnsjab, $idjab)),'','L',1);	
	    		}
	    		
            $lenjab = strlen($opeg->mpegawai->namajab($key->fid_jnsjab, $idjab));
            if ($lenjab <= 40) {
                $y = $y;
            } else if (($lenjab > 40) AND ($lenjab <= 80)) {
                $y = $y+4;
            } else if ($lenjab > 80) {
                $y = $y+7;
            }

            $this->setFont('Arial','',11);
            $this->setXY(50,$y+93); // 93 => 90 (default)
	    $this->cell(55,4,"4. Unit Kerja",0,1,'L',1); 
            $this->setXY(110,$y+93); // 93 => 90 (default)
	    $this->cell(3,4,": ",0,1,'L',1);            
            $this->setFont('Arial','',9);
            $this->setXY(113,$y+93); // 93 => 90 (default)
	    $this->MULTICELL(90,4,$ounker->munker->getnamaunker($key->fid_unit_kerja),'','L',1); 
            $lenunker = strlen($ounker->munker->getnamaunker($key->fid_unit_kerja));
            if ($lenunker <= 38) {
                $y = $y+4; 
            } else if (($lenunker > 38) AND ($lenunker <= 80)) {
                $y = $y+9; //8 => 10
            } else if ($lenunker > 80) {
                $y = $y+12;
            }

            $this->setFont('Arial','',11);
            $this->setXY(50,$y+93); $this->cell(55,5,"5. Gaji Pokok Lama",0,1,'L',1); 
            $this->setXY(110,$y+93); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setXY(113,$y+93); $this->cell(80,5,"Rp. ".indorupiah($key->gapok_lama).",-",0,1,'L',1);
            
            $this->setXY(50,$y+100);
            $this->MULTICELL(140,5,"Atas dasar surat keputusan terakhir tentang gaji/pangkat yang ditetapkan :",'','J',1); 
            $this->setXY(50,$y+105); $this->cell(55,5,"a. Oleh Pejabat",0,1,'L',1); 
            $this->setXY(110,$y+105); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setFont('Arial','',9);
            $this->setXY(113,$y+105); $this->cell(80,5,$key->sk_lama_pejabat,0,1,'L',1);
            $this->setFont('Arial','',11);
            $this->setXY(50,$y+110); $this->cell(55,5,"b. Tanggal / Nomor",0,1,'L',1); 
            $this->setXY(110,$y+110); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setFont('Arial','',11);
            $this->setXY(113,$y+110); $this->cell(80,5,tgl_indo($key->sk_lama_tgl),0,1,'L',1);
            $this->setXY(113,$y+115); $this->cell(80,5,$key->sk_lama_no,0,1,'L',1);
            $this->setFont('Arial','',11);
            $this->setXY(50,$y+120); $this->cell(55,5,"c. Tanggal mulai gaji tersebut",0,1,'L',1); 
            $this->setXY(110,$y+120); $this->cell(3,5,": ",0,1,'L',1);
            $this->setFont('Arial','',11);
            $this->setXY(113,$y+120); $this->cell(80,5,tgl_indo($key->tmt_gaji_lama),0,1,'L',1);
            $this->setFont('Arial','',11);
            $this->setXY(50,$y+125); $this->cell(55,5,"d. Masa kerja golongan",0,1,'L',1); 
            $this->setXY(55,$y+130); $this->cell(55,5,"pada tanggal tersebut",0,1,'L',1); 
            $this->setXY(110,$y+125); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setFont('Arial','',11);
            $this->setXY(113,$y+125); $this->cell(80,5,$key->mk_thn_lama.' Tahun '.$key->mk_bln_lama.' Bulan',0,1,'L',1);
            $this->setFont('Arial','',11);

            $this->setXY(50,$y+140);
            $this->MULTICELL(140,5,"Diberitahukan kenaikan gaji berkala hingga memperoleh :",'','J',1); 
            $this->setXY(50,$y+145); $this->cell(55,5,"6. Gaji pokok baru",0,1,'L',1); 
            $this->setXY(110,$y+145); $this->cell(3,5,": ",0,1,'L',1);
            $this->setXY(113,$y+145); $this->MULTICELL(85,5,"Rp. ".indorupiah($key->gapok_baru).",- (".terbilang($key->gapok_baru).' rupiah)','','L',1);
            $this->setXY(50,$y+155); $this->cell(55,5,"7. Berdasarkan masa kerja",0,1,'L',1); 
            $this->setXY(110,$y+155); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setXY(113,$y+155); $this->cell(80,5,$key->mk_thn_baru.' Tahun '.$key->mk_bln_baru.' Bulan',0,1,'L',1);
            $this->setXY(50,$y+160); $this->cell(55,5,"8. Dalam golongan ruang",0,1,'L',1);
            $this->setXY(110,$y+160); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setXY(113,$y+160); $this->cell(80,5,$opeg->mpegawai->getnamapangkat($key->fid_golru_baru)." (".$opeg->mpegawai->getnamagolru($key->fid_golru_baru).")",0,1,'L',1);
            $this->setXY(50,$y+165); $this->cell(55,5,"9. Terhitung mulai tanggal",0,1,'L',1);
            $this->setXY(110,$y+165); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setXY(113,$y+165); $this->cell(80,5,tgl_indo($key->tmt_gaji_baru),0,1,'L',1); 
            $this->setXY(50,$y+170); $this->cell(55,5,"10. Kenaikan berkala berikutnya",0,1,'L',1);
            $this->setXY(110,$y+170); $this->cell(3,5,": ",0,1,'L',1);            
            $this->setXY(113,$y+170); $this->cell(80,5,tgl_indo($key->tmt_gaji_berikutnya),0,1,'L',1); 

            $this->setXY(50,$y+180);
            $this->MULTICELL(140,5,"Di harap agar sesuai dengan Peraturan Pemerintah Nomor 15 Tahun 2019 kepada Pegawai Negeri Sipil tersebut dapat dibayarkan penghasilannya berdasarkan gaji pokok yang baru.",'','J',1); 






            /*
            $this->setXY(25,$y+30);
            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI TAHUNAN') {                
                $this->cell(100,5,"1. Diberikan ".strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti))." tahun ".$key->thn_cuti." kepada Pegawai Negeri Sipil : ",0,1,'L',1); 
            } else {
                $this->cell(100,5,"1. Diberikan ".strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti))." kepada Pegawai Negeri Sipil : ",0,1,'L',1); 
            }
            $this->setXY(35,$y+40); $this->cell(50,5,"Nama",0,1,'L',1); 
            $this->setXY(85,$y+40); $this->cell(50,5,": ".$mpeg->mpegawai->getnama($key->nip),0,1,'L',1); 
            $this->setXY(35,$y+45); $this->cell(50,5,"NIP",0,1,'L',1); 
            $this->setXY(85,$y+45); $this->cell(50,5,": ".$key->nip,0,1,'L',1); 
            $this->setXY(35,$y+50); $this->cell(50,5,"Pangkat / Gol. Ruang",0,1,'L',1); 
            $this->setXY(85,$y+50); $this->cell(50,5,": ".$mpeg->mpegawai->getnamapangkat($key->fid_golru_skr)." / (".$mpeg->mpegawai->getnamagolru($key->fid_golru_skr).")",0,1,'L',1); 
            $this->setXY(35,$y+55); $this->cell(50,5,"Jabatan",0,1,'L',1); 
            $this->setXY(85,$y+55); $this->cell(2.5,5,":",0,1,'L',1); 
            
            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }
            
            $this->setFont('Arial','',10);
            $lenjab = strlen($mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab));
            //$this->setXY(87.5,$y+70); $this->MULTICELL(105,5,'0123456789 0123456789 0123456789 0123456789 0123456789','','L',1); 
            $this->setXY(87.5,$y+55); $this->MULTICELL(105,5,$mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab),'','J',1); 
            if ($lenjab <= 40) {
                $y = $y+5;
            } else if (($lenjab > 40) AND ($lenjab <= 80)) {
                $y = $y+10;
            } else if ($lenjab > 80) {
                $y = $y+15;
            }
            
            $this->setFont('Arial','',11);
            $this->setXY(35,$y+55); $this->cell(50,5,"Unit Kerja",0,1,'L',1); 
            $this->setXY(85,$y+55); $this->cell(2.5,5,":",0,1,'L',1); 
            $this->setFont('Arial','',10);
            $this->setXY(87.5,$y+55); $this->MULTICELL(105,5,$munker->munker->getnamaunker($key->fid_unit_kerja),'','L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(30,$y+70);
            
            if ($key->tambah_hari_tunda != 0) {
                $jmltotal = $key->jml + $key->tambah_hari_tunda;
            } else {
                $jmltotal = $key->jml;
            }

            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI SAKIT') {
                $this->MULTICELL(165,5,'Selama '.$jmltotal.' ('.terbilang($jmltotal, $style=2).') '.strtolower($key->satuan_jml).' kerja, terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan setelah berakhir jangka waktu cuti sakit tersebut, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana mestinya.','','J',1);
                $y = $y-15;
            } else {
                $this->MULTICELL(165,5,'Selama '.$jmltotal.' ('.terbilang($jmltotal, $style=2).') '.strtolower($key->satuan_jml).' kerja, terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan sebagai berikut :','','J',1);
            }

            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI TAHUNAN') {
                $this->setXY(30,$y+85);
                $this->MULTICELL(6,5,'a.','','J',1);
                $this->setXY(36,$y+85);
                $this->MULTICELL(159,5,'Sebelum menjalankan cuti tahunan wajib menyerahkan pekerjaan kepada atasan langsungnya atau pejabat lain yang ditunjuk.','','J',1);
                $this->setXY(30,$y+95);
                $this->MULTICELL(6,5,'b.','','J',1);
                $this->setXY(36,$y+95);
                $this->MULTICELL(159,5,'Setelah selesai menjalankan cuti tahunan wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.','','J',1);    
            } else if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI BESAR') {
                $this->setXY(30,$y+85);
                $this->MULTICELL(6,5,'a.','','J',1);
                $this->setXY(36,$y+85);
                $this->MULTICELL(159,5,'Sebelum menjalankan cuti besar wajib menyerahkan pekerjaan kepada atasan langsungnya atau pejabat lain yang ditunjuk.','','J',1);

                $this->setXY(30,$y+95);
                $this->MULTICELL(6,5,'b.','','J',1);
                $this->setXY(36,$y+95);
                $this->MULTICELL(159,5,'Selama menjalankan cuti besar, tidak berhak atas tunjangan jabatan.','','J',1);    

                $this->setXY(30,$y+100);
                $this->MULTICELL(6,5,'c.','','J',1);
                $this->setXY(36,$y+100);
                $this->MULTICELL(159,5,'Setelah selesai menjalankan cuti besar wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.','','J',1);    
                $y=$y+10;
            } else if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI BERSALIN') {
                $this->setXY(30,$y+85);
                $this->MULTICELL(6,5,'a.','','J',1);
                $this->setXY(36,$y+85);
                $this->MULTICELL(159,5,'Sebelum menjalankan cuti bersalin wajib menyerahkan pekerjaan kepada atasan langsungnya atau pejabat lain yang ditunjuk.','','J',1);

                $this->setXY(30,$y+95);
                $this->MULTICELL(6,5,'b.','','J',1);
                $this->setXY(36,$y+95);
                $this->MULTICELL(159,5,'Segera setelah persalinan yang bersangkutan supaya memberitahukan tanggal persalinan kepada pejabat yang berwenang memberikan cuti.','','J',1);    

                $this->setXY(30,$y+105);
                $this->MULTICELL(6,5,'c.','','J',1);
                $this->setXY(36,$y+105);
                $this->MULTICELL(159,5,'Setelah selesai menjalankan cuti bersalin wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.','','J',1);    
                $y=$y+10;
            }
    
            $this->setXY(25,$y+110);
            $this->MULTICELL(165,5,'2. Demikian surat izin '.strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti)).' ini dibuat untuk dipergunakan sebagaimana mestinya.','','J',1);
            */

        $this->setXY(110,$y+200);
	if ($key->pejabat_sk == "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN") {
            $this->setXY(90,$y+205);
            $this->MULTICELL(110,5,' '.$key->pejabat_sk.',','','C',1);
            $this->setFont('Arial','U',11);
            $this->setXY(110,$y+230); $this->cell(70,5,'RIBOWO, S.Pd, M.AP',0,1,'C',1);
            $this->setFont('Arial','',11);
            $this->setXY(110,$y+235); $this->cell(70,5,'Pembina Utama Muda (IV/c)',0,1,'C',1);
            $this->setXY(110,$y+240); $this->cell(70,5,'NIP. 19661002 199001 1 002',0,1,'C',1);		
	} else {     	    
	    if ($key->nama_eselon == 'II/A') {
                $this->setXY(100,$y+205);
			$this->setFont('Arial','',12);
                $this->MULTICELL(90,5,'BUPATI BALANGAN,','','C',1);
                $this->setXY(110,$y+235);
			$this->cell(70,5,'H. Abdul Hadi, S.Ag, M.I.Kom',0,1,'C',1);
            } else if (($key->nama_eselon == 'II/B') OR ($nmjab == 'CAMAT') OR ($nmjab == 'DIREKTUR')) {
                $this->setXY(100,$y+205);
                $this->MULTICELL(90,5,'SEKRETARIS DAERAH','','C',1);
                $this->setXY(100,$y+210);
                $this->MULTICELL(90,5,'KABUPATEN BALANGAN, ','','C',1);
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+235); $this->cell(70,5,'H. SUTIKNO, M.AP',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+240); $this->cell(70,5,'Pembina Utama Madya',0,1,'C',1); 
                $this->setXY(110,$y+245); $this->cell(70,5,'NIP. 197604171994121001',0,1,'C',1);                 
            } else {
                $this->setXY(100,$y+205);
                $this->MULTICELL(90,5,' '.$key->pejabat_sk.',','','C',1);
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+235); $this->cell(70,5,'H. SUFRIANNOR, S.Sos, M.AP',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+240); $this->cell(70,5,'Pembina Utama Muda (IV/c)',0,1,'C',1); 
                $this->setXY(110,$y+245); $this->cell(70,5,'NIP. 19681012 198903 1 009',0,1,'C',1); 
            }
	}

	    // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
            $this->Image('assets/qrcodekgb/'.$key->qrcode.'.png', 50, 260,'30','30','png');


            $this->setFont('Arial','U',8);
            $this->setXY(20,$y+255); $this->cell(70,5,'Tembusan :',0,1,'L',1); 
            $this->setFont('Arial','',8);
            if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'INSPEKTORAT') {
                $jabatan = 'Inspektur;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT DAERAH') {
                $jabatan = 'Sekretaris Daerah Kabupaten Balangan;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT DPRD') {
                $jabatan = 'Sekretaris DPRD;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT KOMISI PEMILIHAN UMUM') {
                $jabatan = 'Sekretaris KPU Kabupaten Balangan;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'RUMAH SAKIT UMUM DAERAH BALANGAN') {
                $jabatan = 'Direktur RSUD Balangan;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN PARINGIN') {
                $jabatan = 'Camat Paringin;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN PARINGIN SELATAN') {
                $jabatan = 'Camat Paringin Selatan;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN BATUMANDI') {
                $jabatan = 'Camat Batumandi;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN LAMPIHONG') {
                $jabatan = 'Camat Lampihong;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN JUAI') {
                $jabatan = 'Camat Juai;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN HALONG') {
                $jabatan = 'Camat Halong;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN AWAYAN') {
                $jabatan = 'Camat Awayan;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN TEBING TINGGI') {
                $jabatan = 'Camat Tebing Tinggi;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN BATU PIRING') {
                $jabatan = 'Lurah Batu Piring;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN PARINGIN KOTA') {
                $jabatan = 'Lurah Paringin Kota;';
            } else if ($ounker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN Paringin Timur') {
                $jabatan = 'Lurah Paringin Timur;';
            } else {
                $jabatan = 'KEPALA '.$ounker->munker->getnamaunker($key->fid_unit_kerja).';';
            }

            //$this->setFont('Arial','U',8);
            //$this->setXY(20,$y+255); $this->cell(70,5,'Tembusan :',0,1,'L',1); 
            //$this->setFont('Arial','',8);            
            //$this->setXY(25,$y+260); $this->cell(70,5,'1. Kepala '.$ounker->munker->getnamaunker($key->fid_unit_kerja).';',0,1,'L',1); 
            $this->setXY(25,$y+259); $this->multicell(180,5,'1. '.$jabatan,0,'L',1); 
            $this->setXY(25,$y+263); $this->cell(70,5,'2. Bendahara Gaji Kantor / Instansi yang bersangkutan;',0,1,'L',1); 
            $this->setXY(25,$y+267); $this->cell(70,5,'3. PNS yang bersangkutan.',0,1,'L',1);             
        }        
	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
        $this->Cell(0,10,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan ' . date('Y'),0,0,'L');		
	}
}
 
$pdf = new PDF('P', 'mm', 'Legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output();
