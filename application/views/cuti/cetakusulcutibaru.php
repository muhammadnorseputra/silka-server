<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{                          
	}
 
	function Content($data)
	{
          $mpeg = new Mpegawai();
          $munker = new Munker();
          $mcuti = new Mcuti();
          $mpeg->load->helper('fungsitanggal');
          $mpeg->load->helper('fungsipegawai');

          foreach ($data as $key) {            
            $y = 5;        

            $this->Ln(8);
            $this->setFont('Arial','',11);
            $this->setXY(140,$y+10);
            $this->setFillColor(255,255,255);
            $this->cell(60,5,"Balangan, ".tgl_indo($key->tgl_pengantar),0,1,'L',1); 
            $this->setXY(120,$y+20);
            $this->cell(60,5,"Kepada :",0,1,'L',1); 
            $this->setXY(112,$y+25);
            $this->cell(60,5,"Yth. Bupati Balangan",0,1,'L',1); 
            $this->setXY(120,$y+30);
            $this->cell(60,5,"U.p. Kepala BKPSDM",0,1,'L',1); 
            $this->setXY(120,$y+35);
            $this->cell(60,5,"Kabupaten Balangan",0,1,'L',1); 
            $this->setXY(120,$y+40);
            $this->cell(60,5,"di -",0,1,'L',1); 
            $this->setXY(130,$y+45);
            $this->setFont('Arial','U',11);
            $this->cell(60,5,"Paringin",0,1,'L',1); 
            $this->setFont('Arial','',12);

            $this->setXY(25,$y+55);
            $this->cell(170,5,"FORMULIR PERMINTAAN DAN PEMBERIAN CUTI",0,1,'C',1); 
            $this->setFont('Arial','',10);

            // Awal data Pegawai
            $this->setXY(25,$y+60);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"I. DATA PEGAWAI",1,1,'L',1); 
            $this->setFillColor(255,255,255);
            //Baris I
                $this->setXY(25,$y+67);
                $this->cell(20,7,"Nama",1,1,'L',1); 
                $this->setXY(45,$y+67);
                $this->cell(100,7,$mpeg->mpegawai->getnama($key->nip),1,1,'L',1); 
                $this->setXY(145,$y+67);
                $this->cell(50,7,"NIP : ".$key->nip,1,1,'L',1); 
            //Baris II
                $this->setXY(25,$y+74);
                $this->MULTICELL(20,5,'Jabatan','LRT','J',1);
                $this->Line(25,$y+74,25,$y+89);
                $this->Line(195,$y+74,195,$y+89);
                //$this->cell(20,15,"Jabatan",1,1,'L',1); 
                $this->setXY(45,$y+74);

                $this->Line(45,$y+79,45,$y+89);

                if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
                }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
                }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
                }

                $this->setFont('Arial','',9);
                $this->MULTICELL(100,5,$mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab),'LT','L',1);
                //$this->setFont('Arial','',9);

                $this->setXY(145,$y+74);
                $this->cell(50,7,"Masa Kerja : ".hitungmkcpns($key->nip),1,1,'L',1); 
            //Baris III
                $this->setXY(25,$y+89);
                $this->cell(20,7,"Unit Kerja",1,1,'L',1); 
                $this->setXY(45,$y+89);
                $this->cell(150,7,$munker->munker->getnamaunker($key->fid_unit_kerja),1,1,'L',1); 
            // Akhir data Pegawai


            // Awal Jenis Cuti Yang Diambil
            $this->setXY(25,$y+100);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"II. JENIS CUTI YANG DIAMBIL",1,1,'L',1); 
            $this->setFillColor(255,255,255);

            $jnscuti = $mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti);
            $ctahunan = '';
            $cbesar = '';
            $csakit = '';
            $cbersalin = '';
            $ckap = '';
            $cltn = '';

            if ($jnscuti == 'CUTI TAHUNAN') {
                $ctahunan = 'X';
            } else if ($jnscuti == 'CUTI BESAR') {
                $cbesar = 'X';
            } else if ($jnscuti == 'CUTI SAKIT') {
                $csakit = 'X';
            } else if ($jnscuti == 'CUTI BERSALIN') {
                $cbersalin = 'X';
            } else if ($jnscuti == 'CUTI KARENA ALASAN PENTING') {
                $ckap = 'X';
            } else if ($jnscuti == 'CUTI DILUAR TANGGUNGAN NEGARA') {
                $cltn = 'X';
            } else {
                $ctahunan = '';
                $cbesar = '';
                $csakit = '';
                $cbersalin = '';
                $ckap = '';
                $cltn = '';
            }

            //Baris I
                $this->setXY(25,$y+107);
                if (($jnscuti == 'CUTI TAHUNAN') AND ($key->tambah_hari_tunda != 0)) {
                    $this->cell(70,7,"1. Cuti Tahunan + Cuti Tunda",1,1,'L',1); 
                } else {
                    $this->cell(70,7,"1. Cuti Tahunan",1,1,'L',1); 
                }
                $this->setXY(95,$y+107);
                $this->cell(15,7,$ctahunan,1,1,'C',1); 
                $this->setXY(110,$y+107);
                $this->cell(70,7,"2. Cuti Besar",1,1,'L',1); 
                $this->setXY(180,$y+107);
                $this->cell(15,7,$cbesar,1,1,'C',1); 
            //Baris I
                $this->setXY(25,$y+114);
                $this->cell(70,7,"3. Cuti Sakit",1,1,'L',1); 
                $this->setXY(95,$y+114);
                $this->cell(15,7,$csakit,1,1,'C',1);
                $this->setXY(110,$y+114);
                $this->cell(70,7,"4. Cuti Melahirkan",1,1,'L',1); 
                $this->setXY(180,$y+114);
                $this->cell(15,7,$cbersalin,1,1,'C',1);
            //Baris I
                $this->setXY(25,$y+121);
                $this->cell(70,7,"5. Cuti Karena Alasan Penting",1,1,'L',1); 
                $this->setXY(95,$y+121);              
                $this->cell(15,7,$ckap,1,1,'C',1); 
                $this->setXY(110,$y+121);
                $this->cell(70,7,"6. Cuti di Luar Tanggungan Negara",1,1,'L',1); 
                $this->setXY(180,$y+121);
                $this->cell(15,7,$cltn,1,1,'C',1); 
            // akhir Jenis Cuti Yang Diambil

            // Awal Alasan Cuti
            $this->setXY(25,$y+132);
            $this->setFillColor(222,222,222);
            $this->cell(30,7,"III. ALASAN CUTI",'LTB',1,'L',1);             
            $this->setXY(55,$y+132);
            $this->setFont('Arial','I',8);
            $this->cell(140,7,"Silahkan menggunakan tulisan tangan",'RTB',1,'L',1);             
            $this->setFont('Arial','',9);
            $this->setFillColor(255,255,255);
            //Baris I
                $this->setFont('Arial','',10);
                $this->setXY(25,$y+139);
                if ($jnscuti == 'CUTI BERSALIN') {
                    $this->cell(170,10,"Kelahiran Anak ke-".$key->ket_jns_cuti,1,1,'L',1); 
                } else {
                    $this->cell(170,10,$key->ket_jns_cuti,1,1,'L',1);     
                }                
                $this->setFont('Arial','',10);
            // Akhir Alasan Cuti

            // Awal Lamanya Cuti
            $this->setXY(25,$y+153);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"IV. LAMANYA CUTI",1,1,'L',1); 
            $this->setFillColor(255,255,255);
            //Baris I
                $this->setXY(25,$y+160);
                if (($jnscuti == 'CUTI TAHUNAN') AND ($key->tambah_hari_tunda != 0)) {
                    $jmlhari = $key->jml + $key->tambah_hari_tunda;
                    $this->cell(80,5,"Selama : ".$jmlhari." hari (".$key->jml." ".strtolower($key->satuan_jml)." + ".$key->tambah_hari_tunda." hari cuti tunda)",1,1,'L',1); 
                } else {
                    $this->cell(80,5,"Selama : ".$key->jml." ".strtolower($key->satuan_jml),1,1,'L',1); 
                }

                $this->setXY(105,$y+160);
                $this->cell(90,5,"Mulai Tanggal ".tgl_indo($key->tgl_mulai)." s/d ".tgl_indo($key->tgl_selesai),1,1,'L',1); 
                //$this->setXY(105,$y+160);
                //$this->cell(90,5,"31 Desember 2017 s/d 31 September 2018",1,1,'L',1); 
            // Akhir Lamanya Cuti

            // Awal Catatan Cuti
            $this->setXY(25,$y+168);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"V. CATATAN CUTI",1,1,'L',1);            
            $this->setFillColor(255,255,255); 
            $this->setFont('Arial','',10);
            $thnini = date('Y');

            // tahun ini 2018
            $jmlcutithnini = $mcuti->mcuti->getjmlharitahunan($thnini, $key->nip);
            $sisacutithnini = 12 - $jmlcutithnini;

            // tahun sebelumnya : 2017
            //$jmlcutithnlalu = $mcuti->mcuti->getjmlharitahunan($thnini-1, $key->nip);
            //$sisacutithnlalu = 6 - $jmlcutithnlalu;

            // tahun lusa : 2016
            //$jmlcutithnlusa = $mcuti->mcuti->getjmlharitahunan($thnini-2, $key->nip);
            //$sisacutithnlusa = 8 - $jmlcutithnlusa;

            //Baris I
                $this->setXY(25,$y+175);
                $this->cell(80,5,"1. CUTI TAHUNAN",1,1,'L',1); 
                $this->setXY(105,$y+175);
                $this->cell(70,5,"2. CUTI BESAR",1,1,'L',1); 
                $this->setXY(175,$y+175);
                $this->cell(20,5,"",1,1,'C',1); 
            //Baris II
                $this->setFillColor(222,222,222);
                $this->setXY(25,$y+180);
                $this->cell(20,5,"Tahun",1,1,'C',1); 
                $this->setXY(45,$y+180);
                $this->cell(20,5,"Sisa",1,1,'C',1); 
                $this->setXY(65,$y+180);
                $this->cell(40,5,"Keterangan",1,1,'C',1); 
                $this->setFillColor(255,255,255);
                $this->setXY(105,$y+180);
                $this->cell(70,5,"3. CUTI SAKIT",1,1,'L',1); 
                $this->setXY(175,$y+180);
                $this->cell(20,5,"",1,1,'C',1); 
            //Baris III
                $this->setXY(25,$y+185);
                $this->cell(20,5,$thnini-2,1,1,'L',1); 
                $this->setXY(45,$y+185);
                $this->cell(20,5,"",1,1,'C',1); 
                //$this->cell(20,5,$sisacutithnlusa." hari",1,1,'C',1); 
                $this->setXY(65,$y+185);
                $this->cell(40,5,"",1,1,'L',1); 
                $this->setXY(105,$y+185);
                $this->cell(70,5,"4. CUTI MELAHIRKAN",1,1,'L',1); 
                $this->setXY(175,$y+185);
                $this->cell(20,5,"",1,1,'C',1); 
            //Baris IV
                $jmltunda = $mcuti->mcuti->getjmltundathn($thnini-1, $key->nip);
                $this->setXY(25,$y+190);
                $this->cell(20,5,$thnini-1,1,1,'L',1); 
                $this->setXY(45,$y+190);
                //$this->cell(20,5,$sisacutithnlalu." hari",1,1,'C',1); 
                $this->cell(20,5,"",1,1,'C',1); 
                $this->setXY(65,$y+190);
                if ($jmltunda > 0) {
                    $this->cell(40,5,$jmltunda." Hari : Cuti Tunda",1,1,'L',1);     
                } else {
                    $this->cell(40,5,"",1,1,'L',1);     
                }                
                $this->setXY(105,$y+190);
                $this->cell(70,5,"5. CUTI KARENA ALASAN PENTING",1,1,'L',1); 
                $this->setXY(175,$y+190);
                $this->cell(20,5,"",1,1,'C',1); 
            //Baris V
                $this->setXY(25,$y+195);
                $this->cell(20,5,$thnini,1,1,'L',1); 
                $this->setXY(45,$y+195);
                $this->cell(20,5,$sisacutithnini." hari",1,1,'C',1); 
                $this->setXY(65,$y+195);
                $this->cell(40,5,"",1,1,'L',1); 
                $this->setXY(105,$y+195);
                $this->cell(70,5,"6. CUTI DILUAR TANGGUNGAN NEGARA",1,1,'L',1); 
                $this->setXY(175,$y+195);
                $this->cell(20,5,"",1,1,'C',1); 
            $this->setFont('Arial','',10);
            // Akhir Catatan Cuti

            // Awal alamat
            $this->setXY(25,$y+204);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"VI. ALAMAT SELAMA MENJALANKAN CUTI",1,1,'L',1); 
            $this->setFillColor(255,255,255);
            //Baris I
                $this->setXY(25,$y+211);
                $this->cell(80,5,"",'LRT',1,'L',1); 
                $this->setXY(105,$y+211);
                $this->cell(90,5,"No. Telp. ".$mpeg->mpegawai->getnotelpon($key->nip),1,1,'L',1); 
            //Baris II
                $this->setXY(25,$y+216);
                $this->Line(25,$y+216,25,$y+240); 
                $this->setFont('Arial','',8);
                $this->MULTICELL(80,5,strtoupper($key->alamat),'L','L',1);
                $this->setFont('Arial','',10);
                $this->Line(105,$y+216,105,$y+240); 
                $this->Line(25,$y+240,105,$y+240);  // garis lurus

                $this->setXY(105,$y+216);
                $this->cell(90,5,"Hormat saya,",'TLR',1,'C',1); 
                $this->Line(195,$y+221,195,$y+240);
                $this->setFont('Arial','U',10);
                $this->setXY(105,$y+230);
                $this->cell(90,5,$mpeg->mpegawai->getnama($key->nip),'LR',1,'C',1); 
                $this->setFont('Arial','',10);
                $this->setXY(105,$y+235);
                $this->cell(90,5,'NIP. '.$key->nip,'LRB',1,'C',1);
            // Akhir alamat

            // Awal Pertimbangan Atasan
            $this->setXY(25,$y+244);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"VII. PERTIMBANGAN ATASAN LANGSUNG*",1,1,'L',1);
            $this->setFillColor(255,255,255); 
            //Baris I
                $this->setXY(25,$y+251);
                $this->cell(25,5,"Disetujui",1,1,'C',1); 
                $this->setXY(50,$y+251);
                $this->cell(25,5,"Perubahan",1,1,'C',1); 
                $this->setXY(75,$y+251);
                $this->cell(25,5,"Ditangguhkan",1,1,'C',1); 
                $this->setXY(100,$y+251);
                $this->cell(25,5,"Tidak Disetujui",1,1,'C',1); 
                $this->setXY(125,$y+251);
                $this->setFont('Arial','',7);

                //$this->cell(70,10,"Atasan Langsung,",'LRT',1,'C',1);
                $atasanlangsung = $mcuti->mcuti->getatasanlangsung($key->fid_unit_kerja);
                $this->setXY(125,$y+251);
                $this->MULTICELL(70,5,strtoupper($atasanlangsung),'LRT','C',1);
                //$this->cell(70,10,$atasanlangsung,'LRT',1,'C',1); 
                $this->setFont('Arial','',10); 
            //Baris II
                $this->setXY(25,$y+256);
                $this->cell(25,5,"",1,1,'L',1); 
                $this->setXY(50,$y+256);
                $this->cell(25,5,"",1,1,'L',1); 
                $this->setXY(75,$y+256);
                $this->cell(25,5,"",1,1,'L',1); 
                $this->setXY(100,$y+256);
                $this->cell(25,5,"",1,1,'L',1); 
            //Baris III
                $this->setXY(25,$y+261);
                $this->setFont('Arial','',8);
                $this->Line(25,$y+261,25,$y+281); // garis tegak
                $this->Line(125,$y+261,125,$y+281); // garis tegak
                $this->Line(195,$y+261,195,$y+281); // garis tegak
                $this->cell(100,7,strtoupper($key->catatan_atasan),'LTR',1,'L',1); 
                $this->Line(25,$y+281,125,$y+281); // garis datar
                $this->setFont('Arial','',10);
                $this->setXY(125,$y+271);
                $this->cell(70,10,".........................................................",'LRB',1,'C',1); 
            // Akhir Pertimbangan Atasan

            // Awal Pejabat Berwenang
            $this->setXY(25,$y+285);
            $this->setFillColor(222,222,222);
            $this->cell(170,7,"VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI*",1,1,'L',1); 
            $this->setFillColor(255,255,255);
            //Baris I
                $this->setXY(25,$y+292);
                $this->cell(25,5,"Disetujui",1,1,'C',1); 
                $this->setXY(50,$y+292);
                $this->cell(25,5,"Perubahan",1,1,'C',1); 
                $this->setXY(75,$y+292);
                $this->cell(25,5,"Ditangguhkan",1,1,'C',1); 
                $this->setXY(100,$y+292);
                $this->cell(25,5,"Tidak Disetujui",1,1,'C',1); 
                $this->setXY(125,$y+292);
                $this->setFont('Arial','',8);
                $this->cell(70,10,"Pejabat Berwenang,",'LRT',1,'C',1);
                $this->setFont('Arial','',10); 
            //Baris II
                $this->setXY(25,$y+297);
                $this->cell(25,5,"",1,1,'L',1); 
                $this->setXY(50,$y+297);
                $this->cell(25,5,"",1,1,'L',1); 
                $this->setXY(100,$y+297);
                $this->cell(25,5,"",1,1,'L',1); 
            //Baris III
                $this->setXY(25,$y+302);
                $this->setFont('Arial','',8);
                $this->Line(25,$y+302,25,$y+322); // garis tegak
                $this->cell(100,7,strtoupper($key->keputusan_pej),'LTR',1,'L',1); 
                $this->Line(25,$y+322,125,$y+322); // garis datar 
                $this->setFont('Arial','',10);
                $this->setXY(125,$y+302);
                $this->cell(70,20,".........................................................",'LRB',1,'C',1); 
            // Akhir Pejabat Berwenang

            $this->setXY(25,$y+322);
            $this->setFont('Arial','',8);
            $this->cell(170,7,"*  Beri tanda centang, tuliskan alasan, dan tanda tangan cap stempel asli",0,1,'L',1); 
            $this->setFont('Arial','',8);            
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
$pdf->Output('usulcuti.pdf', 'I');
