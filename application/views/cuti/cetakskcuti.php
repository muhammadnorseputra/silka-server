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
                $this->Image('assets/logo.jpg', 20, 22,'8','10','jpeg');
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
                
	}
 
	function Content($data)
	{        
        $mpeg = new Mpegawai();
	$mpppk = new Mpppk();
        $munker = new Munker();
        $mcuti = new Mcuti();
        $mpeg->load->helper('fungsitanggal');
        $mpeg->load->helper('fungsipegawai');
        $mpeg->load->helper('fungsipegawai');

        foreach ($data as $key) {
            
            $this->Ln(8);
            $this->setFillColor(255,255,255);

            $this->Image('assets/logo.jpg', 20, 12,'20','25','jpeg');
            $this->setFont('Arial','',13);
            $this->setXY(45,12);$this->MULTICELL(155,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
            $this->setFont('Arial','B',20);
	
	  $get_jnsasn = $mcuti->mcuti->get_jnsasn($key->fid_pengantar);
          if ($get_jnsasn == "PNS") {	
            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }
            
            $nmjab = $mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab);
	    if ($key->pejabat_sk == "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN") {
              $this->setFont('Arial','B',22);
              $this->setXY(42,20);
              $this->MULTICELL(160,7,'DINAS PENDIDIKAN DAN KEBUDAYAAN','','C',1);
              $this->setFont('Arial','',10);
              $this->setXY(50,28);$this->MULTICELL(140,5,'Jln. A. Yani Km. 2,5 Telp/Fax. (0526) 2029521 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71662','','C',1);
            } else {
              if (($key->nama_eselon == 'II/A') OR ($key->nama_eselon == 'II/B') OR ($nmjab == 'CAMAT') OR ($nmjab == 'DIREKTUR')) {
                $this->setFont('Arial','B',30);
                $this->setXY(45,21);$this->MULTICELL(155,7,'SEKRETARIAT DAERAH','','C',1);
                $this->setFont('Arial','',10);
                $this->setXY(45,30);$this->MULTICELL(155,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028408 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);
              } else {
                $this->setFont('Arial','B',20);
                $this->setXY(45,18);$this->MULTICELL(155,8,'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA','','C',1);
                $this->setFont('Arial','',8);
                $this->setXY(45,35);$this->MULTICELL(155,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028060 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);
              }
	    }                      
          } else if ($get_jnsasn == "PPPK") {
            if ($key->pejabat_sk == "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN") {
              $this->setFont('Arial','B',22);
              $this->setXY(42,20);
              $this->MULTICELL(160,7,'DINAS PENDIDIKAN DAN KEBUDAYAAN','','C',1);
              $this->setFont('Arial','',10);
              $this->setXY(50,28);$this->MULTICELL(145,5,'Jln. A. Yani Km. 2,5 Telp/Fax. (0526) 2029521 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71662','','C',1);
            } else {
	      $this->setFont('Arial','B',20);
              $this->setXY(45,18);$this->MULTICELL(155,8,'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA','','C',1);
              $this->setFont('Arial','',8);
              $this->setXY(45,35);$this->MULTICELL(155,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028060 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);	
	    }
	  }
  
            //buat garis horizontal
            $this->Line(20,42,200,42);

            $y = 50;

            $this->Ln(8);
            $this->setFont('Arial','UB',16);
            $this->setFillColor(255,255,255);
            $this->setXY(20,$y+10);
            $this->cell(180,5,"SURAT IZIN ".$mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti),0,1,'C',1); 
            $this->setFont('Arial','',11);
            $this->setXY(20,$y+15);
            $this->cell(180,5,"Nomor : ".$key->no_sk,0,1,'C',1); 

            /*
	    $this->setXY(25,$y+30);
            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI TAHUNAN') {                
                $this->cell(100,5,"1. Diberikan ".strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti))." tahun ".$key->thn_cuti." kepada Pegawai Negeri Sipil : ",0,1,'L',1); 
            } else {
                $this->cell(100,5,"1. Diberikan ".strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti))." kepada Pegawai Negeri Sipil : ",0,1,'L',1); 
            }
	    */

            $this->setXY(35,$y+40); $this->cell(50,5,"Nama",0,1,'L',1); 
            if ($get_jnsasn == "PNS") {		
	        $this->setXY(85,$y+40); $this->cell(50,5,": ".$mpeg->mpegawai->getnama($key->nip),0,1,'L',1);
		$ni = $key->nip; 
		$nmjab = $mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab);
		$golru = $mpeg->mpegawai->getnamapangkat($key->fid_golru_skr)." / (".$mpeg->mpegawai->getnamagolru($key->fid_golru_skr).")";
		$ket = "Pegawai Negeri Sipil";
	    } else if ($get_jnsasn == "PPPK") {
                $this->setXY(85,$y+40); $this->cell(50,5,": ".$mpppk->mpppk->getnama_lengkap($key->nipppk),0,1,'L',1);
		$ni = $key->nipppk;
		$nmjab = $mpeg->mpegawai->namajab('3', $key->fid_jabft);
		$golru = $mpppk->mpppk->getnamagolru($key->fid_golru_pppk);
		$ket = "Pegawai Pemerintah dengan Perjanjian Kerja";
            }

	    $this->setXY(25,$y+30);
            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI TAHUNAN') {
                $this->cell(100,5,"1. Diberikan ".strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti))." tahun ".$key->thn_cuti." kepada ".$ket." : ",0,1,'L',1);
            } else {
                $this->cell(100,5,"1. Diberikan ".strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti))." kepada ".$ket." : ",0,1,'L',1);
            }
	
	    $this->setXY(35,$y+45); $this->cell(50,5,"NIP",0,1,'L',1);	    
            $this->setXY(85,$y+45); $this->cell(50,5,": ".$ni,0,1,'L',1); 
            $this->setXY(35,$y+50); $this->cell(50,5,"Pangkat / Gol. Ruang",0,1,'L',1); 
            $this->setXY(85,$y+50); $this->cell(50,5,": ".$golru,0,1,'L',1); 
            $this->setXY(35,$y+55); $this->cell(50,5,"Jabatan",0,1,'L',1); 
            $this->setXY(85,$y+55); $this->cell(2.5,5,":",0,1,'L',1); 
                        
            $this->setFont('Arial','',11);
            $lenjab = strlen($nmjab);
            //$this->setXY(87.5,$y+70); $this->MULTICELL(105,5,'0123456789 0123456789 0123456789 0123456789 0123456789','','L',1); 
            $this->setXY(87.5,$y+55); $this->MULTICELL(105,5,$nmjab,'','J',1); 
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
            $this->setFont('Arial','',11);
            $this->setXY(87.5,$y+55); $this->MULTICELL(105,5,$munker->munker->getnamaunker($key->fid_unit_kerja),'','L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(30,$y+70);
  	    if (($get_jnsasn == "PNS") AND ($key->tambah_hari_tunda != 0)) {
                $jmltotal = $key->jml + $key->tambah_hari_tunda;
            } else {
                $jmltotal = $key->jml;
            }

            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI SAKIT') {
                $this->MULTICELL(165,5,'Selama '.$jmltotal.' ('.terbilang($jmltotal, $style=2).') '.strtolower($key->satuan_jml).', terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan setelah berakhir jangka waktu cuti sakit tersebut, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana mestinya.','','J',1);
                $y = $y-15;
            } else if (($jmltotal == '1') AND ($key->satuan_jml == 'BULAN')) { 
                $this->MULTICELL(165,5,'Selama '.$jmltotal.' ('.terbilang($jmltotal, $style=2).') '.strtolower($key->satuan_jml).' terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan sebagai berikut :','','J',1);
    	    } else if (($jmltotal == '1') AND ($key->satuan_jml == 'HARI')) { 
                $this->MULTICELL(165,5,'Selama '.$jmltotal.' ('.terbilang($jmltotal, $style=2).') '.strtolower($key->satuan_jml).' pada tanggal '.tgl_indo($key->tgl_mulai).', dengan ketentuan sebagai berikut :','','J',1);
                $y = $y-10;
            } else {
    		$this->MULTICELL(165,5,'Selama '.$jmltotal.' ('.terbilang($jmltotal, $style=2).') '.strtolower($key->satuan_jml).', terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan sebagai berikut :','','J',1);
    	    }

            /*if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI SAKIT') {
                $this->MULTICELL(165,5,'Selama '.$key->jml.' ('.terbilang($key->jml, $style=2).') '.strtolower($key->satuan_jml).' kerja, terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan setelah berakhir jangka waktu cuti sakit tersebut, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana mestinya.','','J',1);
                $y = $y-15;
            } else {
                $this->MULTICELL(165,5,'Selama '.$key->jml.' ('.terbilang($key->jml, $style=2).') '.strtolower($key->satuan_jml).' kerja, terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).' dengan ketentuan sebagai berikut :','','J',1);
            }
		*/

            if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI TAHUNAN') {
                $this->setXY(30,$y+85);
                $this->MULTICELL(6,5,'a.','','J',1);
                $this->setXY(36,$y+85);
                $this->MULTICELL(159,5,'Sebelum menjalankan cuti tahunan wajib menyerahkan pekerjaan kepada atasan langsungnya atau pejabat lain yang ditunjuk.','','J',1);
                $this->setXY(30,$y+95);
                $this->MULTICELL(6,5,'b.','','J',1);
                $this->setXY(36,$y+95);
                $this->MULTICELL(159,5,'Setelah selesai menjalankan cuti tahunan wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.','','J',1);    
            } else if ($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti) == 'CUTI KARENA ALASAN PENTING') {
                $this->setXY(30,$y+85);
                $this->MULTICELL(6,5,'a.','','J',1);
                $this->setXY(36,$y+85);
                $this->MULTICELL(159,5,'Sebelum menjalankan cuti karena alasan penting, wajib menyerahkan pekerjaan kepada atasan langsungnya atau pejabat lain yang ditunjuk.','','J',1);
                $this->setXY(30,$y+95);
                $this->MULTICELL(6,5,'b.','','J',1);
                $this->setXY(36,$y+95);
                $this->MULTICELL(159,5,'Setelah selesai menjalankan cuti karena alasan penting, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.','','J',1);    
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

            $this->setXY(25,$y+109);
            $this->MULTICELL(165,5,'2. Demikian surat izin '.strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti)).' ini dibuat untuk dipergunakan sebagaimana mestinya.','','J',1);
	
		//$tgl_mulai = $key->tgl_mulai;
		//$tgl_selesai = $key->tgl_selesai;
		//if(($tgl_mulai >= '2019-05-23') AND ($tgl_selesai <= '2019-06-10')){
		//	$this->setXY(25, $y+115);
		//	$this->MULTICELL(6,5,'3.','','J',1);
		//	$this->setXY(30, $y+115);
		//	$this->setFont('Arial','B',11);
		//	$this->MULTICELL(159,5,'Apabila dikemudian hari diterbitkan surat edaran larangan cuti sebelum / sesudah cuti bersama lebaran, maka surat cuti ini tidak berlaku.','','J',1);
		//        $this->MULTICELL(165,5,'Apabila setelah dikeluarkannya surat cuti ini terdapat ketentuan yang melarang atau membatasi pemberian cuti, maka akan diadakan perbaikan sesuai ketentuan yang berlaku.','','J',1);
		//	}
	    $this->setFont('Arial','',11);
            $this->setXY(110,$y+120);
            $this->cell(70,5,"Paringin, ".tgl_indo($key->tgl_sk),0,1,'C',1); 
            
	  if ($get_jnsasn == "PNS") {
	   if ($key->pejabat_sk == "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN") {
            $this->setXY(110,$y+125);
            $this->MULTICELL(70,5,$key->pejabat_sk.',','','C',1);
            $this->setFont('Arial','U',11);
            $this->setXY(110,$y+160); $this->cell(70,5,'H. ABIJI, S.Pd, M.AP',0,1,'C',1);
            $this->setFont('Arial','',11);
            $this->setXY(110,$y+165); $this->cell(70,5,'Pembina Utama Muda (IV/c)',0,1,'C',1);
            $this->setXY(110,$y+170); $this->cell(70,5,'NIP. 196908131994121002',0,1,'C',1);
           } else {
            if (($key->nama_eselon == 'II/A') OR ($key->nama_eselon == 'II/B') OR ($nmjab == 'CAMAT') OR ($nmjab == 'DIREKTUR')) {
                $this->setXY(100,$y+125);
                $this->MULTICELL(90,5,'SEKRETARIS DAERAH','','C',1);
                $this->setXY(100,$y+130);
                $this->MULTICELL(90,5,'KABUPATEN BALANGAN, ','','C',1);
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+160); $this->cell(70,5,'H. SUTIKNO, M.AP',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+165); $this->cell(70,5,'Pembina Utama Madya',0,1,'C',1); 
                $this->setXY(110,$y+170); $this->cell(70,5,'NIP. 197604171994121001',0,1,'C',1);                 
            } else {
                $this->setXY(100,$y+125);
                $this->MULTICELL(90,5,$key->pejabat_sk,'','C',1);
        		
                ###### Bapa Agus Muslim #### Plh
                /*
		$this->setFont('Arial','',11);
        	    // $this->setXY(110,$y+145); $this->cell(70,5,'Plh. KEPALA BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA',0,1,'C',1);
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+160); $this->cell(70,5,'RUSMIN NURIADIN, S.Ag, S.Sos, MH',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+165); $this->cell(70,5,'PEMBINA TK I (IV/B)',0,1,'C',1); 
                $this->setXY(110,$y+170); $this->cell(70,5,'NIP. 19680321 199101 1 001',0,1,'C',1); 
		*/

                ####### Bapa Sufriannor ######## Atas Nama
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+160); $this->cell(70,5,'H. SUFRIANNOR, S.Sos, M.AP',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+165); $this->cell(70,5,'Pembina Utama Muda (IV/c)',0,1,'C',1); 
                $this->setXY(110,$y+170); $this->cell(70,5,'NIP. 19681012 198903 1 009',0,1,'C',1); 
            }
	   }
	  } else if ($get_jnsasn == "PPPK") {
	   if ($key->pejabat_sk == "KEPALA DINAS PENDIDIKAN DAN KEBUDAYAAN") {
            $this->setXY(90,$y+125);
            $this->MULTICELL(110,5,' '.$key->pejabat_sk.',','','C',1);
            $this->setFont('Arial','U',11);
            $this->setXY(90,$y+160); $this->cell(110,5,'H. ABIJI, S.Pd, M.AP',0,1,'C',1);
            $this->setFont('Arial','',11);
            $this->setXY(90,$y+165); $this->cell(110,5,'Pembina Utama Muda (IV/c)',0,1,'C',1);
            $this->setXY(90,$y+170); $this->cell(110,5,'NIP. 196908131994121002',0,1,'C',1);
           } else {
		$this->setXY(100,$y+125);
                $this->MULTICELL(90,5,$key->pejabat_sk,'','C',1);
		        ####### Bapa Sufriannor ######## Atas Nama
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+160); $this->cell(70,5,'H. SUFRIANNOR, S.Sos, M.AP',0,1,'C',1);
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+165); $this->cell(70,5,'Pembina Utama Muda (IV/c)',0,1,'C',1);
                $this->setXY(110,$y+170); $this->cell(70,5,'NIP. 19681012 198903 1 009',0,1,'C',1);

                // $this->MULTICELL(90,5,'Plh. '.$key->pejabat_sk,'','C',1);
                // $this->setFont('Arial','U',11);
                // $this->setXY(110,$y+160); $this->cell(70,5,'RUSMIN NURIADIN, S.Ag, S.Sos',0,1,'C',1);
                // $this->setFont('Arial','',11);
                // $this->setXY(110,$y+165); $this->cell(70,5,'PEMBINA TK I (IV/B)',0,1,'C',1);
                // $this->setXY(110,$y+170); $this->cell(70,5,'NIP. 19680321 199101 1 001',0,1,'C',1);

	   }	
	  }

 	    // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
            $this->Image('assets/qrcodecuti/'.$key->qrcode.'.png', 25, $y+120,'30','30','png');
	   
	    if ($get_jnsasn == "PNS") {
		 // TABEL RIWAYAT CUTI PER NIP & TAHUN CUTI -1 -2
                $get_tahun = array(
                    'thn_min_satu' => date('Y') - 1, //2019
                    'thn_min_dua' => date('Y') - 2, //2018
                    'thn_now' => date('Y') //2020
                );

                //THEAD
                $this->setFillColor(222,222,222);
                $this->setFont('Arial','',8);

                /*
                * KHUSUS CUTI TAHUNAN
                */
                $this->setXY(20,$y+188);
                $this->Cell(75, 5, 'CUTI TAHUNAN', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');                
                $this->setXY(20,$y+193);
                $this->Cell(20, 5, 'Tahun', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                $this->setXY(40,$y+193);
                $this->Cell(30, 5, 'Jenis', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                $this->setXY(70,$y+193);
                $this->Cell(25, 5, 'Lama', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                
                /*
                * SELAIN CUTI TAHUNAN
                */
                $this->setXY(95,$y+188);
                $this->Cell(100, 5, 'SELAIN CUTI TAHUNAN', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                $this->setXY(95,$y+193);
                $this->Cell(20, 5, 'Tahun', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                $this->setXY(115,$y+193);
                $this->Cell(55, 5, 'Jenis', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                $this->setXY(170,$y+193);
                $this->Cell(25, 5, 'Lama', 1, $ln=0, 'C', 1, '', 0, false, 'C', 'C');
                
                /*
                * KHUSUS UNTUK CUTI TAHUNAN
                * TAHUN 2019 (OTOMATIS)
                */
                $this->setFillColor(255,255,255);
                $this->setFont('Arial','',8);
                $this->setXY(20,$y+198);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '= 1')['tahun'] , 1,'C', 1, true);
                $this->setXY(40,$y+198);
                $this->MultiCell(30, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(70,$y+198);
                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '= 1')['jml_cuti'], 1,'C', 1, true);
                
                /*
                * SELAIN CUTI TAHUNAN   
                * TAHUN 2019 (OTOMATIS) 
                */
                if($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['jml_cuti'] == '') {
                $this->setXY(95,$y+198);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['tahun'] , 1,'C', 1, true);
                $this->setXY(115,$y+198);
                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(170,$y+198);
                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['jml_cuti'], 1,'C', 1, true);
                } else {
                $this->setXY(95,$y+198);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['tahun'] , 1,'C', 1, true);
                $this->setXY(115,$y+198);
                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(170,$y+198);
                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_dua'], $ni, '!= 1')['jml_cuti'], 1,'C', 1, true);
                }
               
                /*
                * KHUSUS UNTUK CUTI TAHUNAN
                * TAHUN 2020 (OTOMATIS)
                */
                
                //JIKA PADA RIWAYAT CUTI TAHUNAN KOSONG MAKA TAMPILKAN USULAN CUTI SEKARANG
                if($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['jml_cuti'] == ''){ 
                $this->setFillColor(255,255,255);
                $this->setFont('Arial','',8);
                $this->setXY(20,$y+204);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['tahun'], 1,'C', 1, true);
                $this->setXY(40,$y+204);
                $this->MultiCell(30, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(70,$y+204);
                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['jml_cuti'], 1,'C', 1, true);
                } else {
                //JIKA PADA RIWAYAT CUTI TAHUNAN TIDAK KOSONG MAKA JUMLAHKAN SEMUA RIWAYAT CUTI + CUTI YANG DIUSULKAN SEKARANG
                $this->setFillColor(255,255,255);
                $this->setFont('Arial','',8);
                $this->setXY(20,$y+204);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['tahun'], 1,'C', 1, true);
                $this->setXY(40,$y+204);
                $this->MultiCell(30, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(70,$y+204);
                $this->MultiCell(25, 6, ($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '= 1')['jml_cuti']) + ($mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $key->nip, '= 1')['jml_cuti']).' HARI', 1,'C', 1, true);
                }
                /*
                * SELAIN CUTI TAHUNAN   
                * TAHUN 2020 (OTOMATIS) 
                */
		if($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $key->nip, '!= 1')['jml_cuti'] == '') {
		$this->setXY(95,$y+204);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $ni, '!= 1')['tahun'] , 1,'C', 1, true);
                $this->setXY(115,$y+204);
                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $ni, '!= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(170,$y+204);
                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_min_satu'], $ni, '!= 1')['jml_cuti'], 1,'C', 1, true);		
								} else {
                $this->setXY(95,$y+204);
                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '!= 1')['tahun'] , 1,'C', 1, true);
                $this->setXY(115,$y+204);
                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '!= 1')['jenis'], 1,'C', 1, true);
                $this->setXY(170,$y+204);
                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_min_satu'], $ni, '!= 1')['jml_cuti'], 1,'C', 1, true);
                }
                /*
                * KHUSUS UNTUK CUTI TAHUNAN
                * TAHUN 2021 (OTOMATIS) 
                */
                
                //JIKA PADA RIWAYAT CUTI TAHUNAN KOSONG MAKA TAMPILKAN USULAN CUTI SEKARANG
                if($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $ni, '= 1')['jml_cuti'] == ''){ 
	                $this->setFillColor(255,255,255);
	                $this->setFont('Arial','',8);
	                $this->setXY(20,$y+210);
	                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $ni, '= 1')['tahun'], 1,'C', 1, true);
	                $this->setXY(40,$y+210);
	                $this->MultiCell(30, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $ni, '= 1')['jenis'], 1,'C', 1, true);
	                $this->setXY(70,$y+210);
	                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $ni, '= 1')['jml_cuti'], 1,'C', 1, true);
                } else {
                //JIKA PADA RIWAYAT CUTI TAHUNAN TIDAK KOSONG MAKA JUMLAHKAN SEMUA RIWAYAT CUTI + CUTI YANG DIUSULKAN SEKARANG
                    $this->setFillColor(255,255,255);
	                $this->setFont('Arial','',8);
	                $this->setXY(20,$y+210);
	                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $ni, '= 1')['tahun'], 1,'C', 1, true);
	                $this->setXY(40,$y+210);
	                $this->MultiCell(30, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $ni, '= 1')['jenis'], 1,'C', 1, true);
	                $this->setXY(70,$y+210);
	                $this->MultiCell(25, 6, ($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $ni, '= 1')['jml_cuti']) + ($mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '= 1')['jml_cuti']).' HARI', 1,'C', 1, true);
                }
                /*
                * SELAIN CUTI TAHUNAN   
                * TAHUN 2021 (OTOMATIS) 
                */
                // JIKA PADA RIWAYAT CUTI KOSONG PADA TAHUN INI
                if($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $ni, '!= 1')['jml_cuti'] == '') {
                	$this->setXY(95,$y+210);
	                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $ni, '!= 1')['tahun'] , 1,'C', 1, true);
	                $this->setXY(115,$y+210);
	                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $ni, '!= 1')['jenis'], 1,'C', 1, true);
                	$this->setXY(170,$y+210);
	                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $ni, '!= 1')['jml_cuti'], 1,'C', 1, true);
                }else {
                	//JIKA JENIS CUTINYA SAMA, MAKA HANYA JUMLAHKAN RIWAYAT CUTI + CUTI SEKARANG
                	if(($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis']) == ($mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis'])) {
                	$this->setXY(95,$y+210);
	                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['tahun'] , 1,'C', 1, true);
	                $this->setXY(115,$y+210);
	                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis'], 1,'C', 1, true);
	                $this->setXY(170,$y+210);
	                	// JIKA SATUAN JUMLAH CUTI SAMA DENGAN HARI
	                	if(($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['satuan_jml'] == 'HARI' AND $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['satuan_jml'] == 'HARI') OR ($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['satuan_jml'] == 'BULAN' AND $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['satuan_jml'] == 'BULAN')){
	                		$this->MultiCell(25, 6, ($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti']) + ($mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti'])." ".$mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['satuan_jml'], 1,'C', 1, true);	
                		} else {
                			$this->setFont('Arial','',6);
	                		$this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti']."+".$mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti'], 1,'C', 1, true);	                		
                		}
                	} else {
                		if(count($mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis']) > 1){
		                	$this->setFont('Arial','',6);
			                $this->setXY(95,$y+210);
			                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['tahun'] , 1,'C', 1, true);
			                $this->setXY(115,$y+210);
			                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis']. " + ".$mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis'], 1,'C', 1, true);
			                $this->setXY(170,$y+210);
			                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti']. " + ". $mcuti->mcuti->get_riwayat_cuti('cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti'], 1,'C', 1, true);
                		} else {
                			$this->setFont('Arial','',8);
			                $this->setXY(95,$y+210);
			                $this->MultiCell(20, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['tahun'] , 1,'C', 1, true);
			                $this->setXY(115,$y+210);
			                $this->MultiCell(55, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jenis'], 1,'C', 1, true);
			                $this->setXY(170,$y+210);
			                $this->MultiCell(25, 6, $mcuti->mcuti->get_riwayat_cuti('riwayat_cuti', $get_tahun['thn_now'], $key->nip, '!= 1')['jml_cuti'], 1,'C', 1, true);
                		}
                	}
                }
	    } // End IF ($get_jnsasn == "PNS")

	    $y = 60;	
            $this->setFont('Arial','U',8);
            $this->setXY(20,$y+220); $this->cell(70,5,'Tembusan :',0,1,'L',1); 
            $this->setFont('Arial','',8);

            if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT DAERAH') {
                $jabatan = 'Sekretaris Daerah Kabupaten Balangan;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT DPRD') {
                $jabatan = 'Sekretaris DPRD;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT KOMISI PEMILIHAN UMUM') {
                $jabatan = 'Sekretaris KPU Kabupaten Balangan;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'RUMAH SAKIT UMUM DAERAH BALANGAN') {
                $jabatan = 'Direktur RSUD Balangan;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN PARINGIN') {
                $jabatan = 'Camat Paringin;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN PARINGIN SELATAN') {
                $jabatan = 'Camat Paringin Selatan;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN BATUMANDI') {
                $jabatan = 'Camat Batumandi;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN LAMPIHONG') {
                $jabatan = 'Camat Lampihong;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN JUAI') {
                $jabatan = 'Camat Juai;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN HALONG') {
                $jabatan = 'Camat Halong;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN AWAYAN') {
                $jabatan = 'Camat Awayan;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN TEBING TINGGI') {
                $jabatan = 'Camat Tebing Tinggi;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN BATU PIRING') {
                $jabatan = 'Lurah Batu Piring;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN PARINGIN KOTA') {
                $jabatan = 'Lurah Paringin Kota;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN PARINGIN TIMUR') {
                $jabatan = 'Lurah Paringin Timur;';
            } elseif ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'INSPEKTORAT ') {
                $jabatan = 'Inspektur;';
            } else {
                $jabatan = 'Kepala '.$munker->munker->getnamaunker($key->fid_unit_kerja).' Kabupaten Balangan;';
            }          

            $this->setXY(25,$y+225); $this->cell(70,3,'1. '.$jabatan,0,1,'L',1); 
            //$this->setXY(25,$y+225); $this->cell(70,5,'1. Kepala '.$munker->munker->getnamaunker($key->fid_unit_kerja).' Kabupaten Balangan;',0,1,'L',1); 
            $this->setXY(25,$y+228); $this->cell(70,3,'2. Kepala Bagian Organisasi Sekretariat Daerah Kabupaten Balangan;',0,1,'L',1); 
            $this->setXY(25,$y+231); $this->cell(70,3,'3. Arsip.',0,1,'L',1);             

                $y = 50;
                $this->setFont('Arial','',8);
                $this->setXY(10,$y+276); $this->cell(165,3,'- UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1',0,1,'R',1);
                $this->setFont('Arial','I',8);
                $this->setXY(10,$y+279); $this->cell(165,3,'"Informasi Elektronik dan/atau Dokumen Elektronik hasil cetaknya merupakan alat bukti hukum yang sah"',0,1,'R',1);
                $this->setFont('Arial','',8);
                $this->setXY(10,$y+282); $this->cell(165,3,'- Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan BSrE',0,1,'R',1);
                $this->Image('assets/tte_logo.png', 175, 325,'25','10','png');


            $y = 45;
            $this->SetXY(20, $y+274);
            //buat garis horizontal
            $this->Line(20,$this->GetY()+5,200,$this->GetY()+5);
            //Arial italic 9
            $this->SetFont('Arial','I',9);
            $this->Cell(0,5,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan ' . date('Y'),0,0,'L');

        }        
	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		//$this->SetY(-15);
		//buat garis horizontal
		//$this->Line(10,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		//$this->SetFont('Arial','I',9);
        	//$this->Cell(0,10,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan ' . date('Y'),0,0,'L');		
	}
}
 
$pdf = new PDF('P', 'mm', 'Legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('skizincuti.pdf', 'I');
