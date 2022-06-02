<?php

class PDF extends FPDF
{     

    //Page header
	function Header()
	{                                      
                $login = new mLogin();
                $peg = new mPegawai();

                //$this->SetMargins(0,0,0);
                $this->SetXY(20,10);
                $this->setFont('Arial','',9);
                $this->setFillColor(255,255,255);
                $this->cell(130,5,"",0,0,'L',1); 
                $this->setFont('Arial','I',7);
                $this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                //atur posisi 1.5 cm dari bawah
                $this->SetY(15);
                //buat garis horizontal
                $this->Line(20,$this->GetY(),320,$this->GetY());
	}

	function Content($data)
	{
        $mpeg = new Mpegawai();
        $mun = new Munker();
        $mkin = new Mkinerja();
        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,20,'NO.','LRT','L',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(50,5,'NIP','LRT','L',1);
        $this->setXY($x+10,$y+5);
        $this->MULTICELL(50,5,'NAMA','LR','L',1);
        $this->setXY($x+10,$y+10);
        $this->MULTICELL(50,5,'GOLRU','LR','L',1);    
        $this->setXY($x+10,$y+15);
        $this->MULTICELL(50,5,'','LR','C',1);
        $this->setXY($x+60,$y);
        $this->MULTICELL(80,20,'KETERANGAN JABATAN','LTR','L',1);
        $this->setXY($x+140,$y);
        $this->MULTICELL(25,5,'KELAS JAB.','LRT','R',1);
        $this->setXY($x+140,$y+5);
        $this->MULTICELL(25,5,'','LR','R',1);
        $this->setXY($x+140,$y+10);
        $this->MULTICELL(25,5,'','LR','L',1);    
        $this->setXY($x+140,$y+15);
        $this->MULTICELL(25,5,'TPP BASIC','LR','R',1);

        $this->setXY($x+165,$y);
        $this->MULTICELL(25,5,'REAL KINERJA','LRT','R',1);
        $this->setXY($x+165,$y+5);
        $this->MULTICELL(25,5,'60 % KINERJA','LR','R',1);
        $this->setXY($x+165,$y+10);
        $this->MULTICELL(25,5,'TPP KINERJA','LR','R',1);    
        $this->setXY($x+165,$y+15);
        $this->MULTICELL(25,5,'','LR','C',1);

        $this->setXY($x+190,$y);
        $this->MULTICELL(25,5,'REAL ABSENSI','LRT','R',1);
        $this->setXY($x+190,$y+5);
        $this->MULTICELL(25,5,'40 % ABSENSI','LR','R',1);
        $this->setXY($x+190,$y+10);
        $this->MULTICELL(25,5,'TPP ABSENSI','LR','R',1);    
        $this->setXY($x+190,$y+15);
        $this->MULTICELL(25,5,'','LR','C',1);

        $this->setXY($x+215,$y);
        $this->MULTICELL(25,5,'INDIKATOR TAMBAHAN','LRT','R',1);
        $this->setXY($x+215,$y+10);
        $this->MULTICELL(25,10,'','LR','R',1);

        $this->setXY($x+240,$y);
        $this->MULTICELL(30,4,'TPP GROSS','LRT','R',1);
        $this->setXY($x+240,$y+4);
        $this->MULTICELL(30,4,'+ TAMBAHAN','LR','R',1);
        $this->setXY($x+240,$y+8);
        $this->MULTICELL(30,4,'JUMLAH','LR','R',1);    
        $this->setXY($x+240,$y+12);
        $this->MULTICELL(30,4,'- PAJAK','LR','R',1);
        $this->setXY($x+240,$y+16);
        $this->MULTICELL(30,4,'TPP DITERIMA','LR','R',1);

        $this->setXY($x+270,$y);
        $this->MULTICELL(30,20,'TANDA TANGAN','LRT','L',1);

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 55;
        $kurangdari50 = 1;
        $no = 1;        
        $maxline=1;
        foreach ($data as $k) {
            if ($no==1) {
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 21, 21,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,'TK / SDN / SMPN SEDERAJAT KEC. '.$mpeg->mpegawai->getnamakecamatan($k->fid_unker_pengantar),0,'L',1);
                $this->setXY(30,28);
                $this->multicell(200,5,'Periode '.bulan($k->bulan).' '.$k->tahun,0,'L',1); 
            }

           
            $maxline=$maxline % 8;            
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 35;
                $y = 55;
                //$this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,'TK / SDN / SMPN SEDERAJAT',0,'L',1); 
                $this->setXY(30,28);
                $this->multicell(200,5,'Periode '.bulan($k->bulan).' '.$k->tahun,0,'L',1);                 

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,20,'NO.','LRT','L',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(50,5,'NIP','LRT','L',1);
                $this->setXY($x+10,$y1+5);
                $this->MULTICELL(50,5,'NAMA','LR','L',1);
                $this->setXY($x+10,$y1+10);
                $this->MULTICELL(50,5,'GOLRU','LR','L',1);    
                $this->setXY($x+10,$y1+15);
                $this->MULTICELL(50,5,'','LR','C',1);
                $this->setXY($x+60,$y1);
                $this->MULTICELL(80,20,'KETERANGAN JABATAN','LTR','L',1);
                $this->setXY($x+140,$y1);
                $this->MULTICELL(25,5,'KELAS JAB.','LRT','R',1);
                $this->setXY($x+140,$y1+5);
                $this->MULTICELL(25,5,'','LR','R',1);
                $this->setXY($x+140,$y1+10);
                $this->MULTICELL(25,5,'','LR','L',1);    
                $this->setXY($x+140,$y1+15);
                $this->MULTICELL(25,5,'TPP BASIC','LR','R',1);

                $this->setXY($x+165,$y1);
                $this->MULTICELL(25,5,'REAL KINERJA','LRT','R',1);
                $this->setXY($x+165,$y1+5);
                $this->MULTICELL(25,5,'60 % KINERJA','LR','R',1);
                $this->setXY($x+165,$y1+10);
                $this->MULTICELL(25,5,'TPP KINERJA','LR','R',1);    
                $this->setXY($x+165,$y1+15);
                $this->MULTICELL(25,5,'','LR','C',1);

                $this->setXY($x+190,$y1);
                $this->MULTICELL(25,5,'REAL ABSENSI','LRT','R',1);
                $this->setXY($x+190,$y1+5);
                $this->MULTICELL(25,5,'40 % ABSENSI','LR','R',1);
                $this->setXY($x+190,$y1+10);
                $this->MULTICELL(25,5,'TPP ABSENSI','LR','R',1);    
                $this->setXY($x+190,$y1+15);
                $this->MULTICELL(25,5,'','LR','C',1);

                $this->setXY($x+215,$y1);
                $this->MULTICELL(25,5,'INDIKATOR TAMBAHAN','LRT','R',1);
                $this->setXY($x+215,$y1+10);
                $this->MULTICELL(25,10,'','LR','R',1);

                $this->setXY($x+240,$y1);
                $this->MULTICELL(30,4,'TPP GROSS','LRT','R',1);
                $this->setXY($x+240,$y1+4);
                $this->MULTICELL(30,4,'+ TAMBAHAN','LR','R',1);
                $this->setXY($x+240,$y1+8);
                $this->MULTICELL(30,4,'JUMLAH','LR','R',1);    
                $this->setXY($x+240,$y1+12);
                $this->MULTICELL(30,4,'- PAJAK','LR','R',1);
                $this->setXY($x+240,$y1+16);
                $this->MULTICELL(30,4,'TPP DITERIMA','LR','R',1);

                $this->setXY($x+270,$y1);
                $this->MULTICELL(30,20,'TANDA TANGAN','LRT','L',1);
                $maxline=$maxline+1;
            }
           
            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $this->MULTICELL(50,5,"NIPPPK. ".$k->nipppk,'','L',1);            
            $this->setXY($x+10,$y+5);
            $this->MULTICELL(50,5,$mpeg->mpppk->getnama($k->nipppk),'','L',1);            
            $this->setXY($x+10,$y+10);
            $golru = $mpeg->mpegawai->getnamagolru($k->fid_golru);
            $this->MULTICELL(50,5,$mpeg->mpegawai->getnamapangkat($k->fid_golru).' ('.$mpeg->mpppk->getnamagolru($k->fid_golru).')','','L',1);
            $this->setXY($x+60,$y);
            $this->MULTICELL(80,5,$k->jabatan,'','L',1);
            $this->setXY($x+60,$y+5);
            $this->MULTICELL(80,5,$mun->munker->getnamaunker($mpeg->mpppk->getfidunker($k->nipppk)),'','L',1);
     

            $this->setFont('arial','',8);
            $this->setXY($x+140,$y);
            $this->MULTICELL(25,4,$k->kelas_jab,'','R',1);  
            $this->setXY($x+140,$y+16);
            $this->MULTICELL(25,3,"Rp. ".number_format($k->tpp_basic,0,",","."),'','R',1);

            // KINERJA
            if ($k->nilai_kinerja <= 50) {
                $kurangdari50 = $kurangdari50+1;
            }
            $kinerja60p = (60/100) * $k->nilai_kinerja;
            $this->setXY($x+165,$y);
            $this->MULTICELL(25,5,number_format($k->nilai_kinerja,2),'','R',1);
            $this->setXY($x+165,$y+5);
            $this->MULTICELL(25,5,number_format($kinerja60p,2),'','R',1);
            $this->setXY($x+165,$y+10);
            $this->MULTICELL(25,5,"Rp. ".number_format($k->tpp_kinerja,0,",","."),'','R',1);

            // ABSENSI
            $absensi40p = (40/100) * $k->nilai_absensi;
            $this->setXY($x+190,$y);
            $this->MULTICELL(25,5,number_format($k->nilai_absensi,2),'','R',1);
            $this->setXY($x+190,$y+5);
            $this->MULTICELL(25,5,number_format($absensi40p,2),'','R',1);
            $this->setXY($x+190,$y+10);
            $this->MULTICELL(25,5,"Rp. ".number_format($k->tpp_absensi,0,",","."),'','R',1);

            // TAMBAHAN            
            if ($k->kelas1dan3 == "YA") {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"Kls 1/3",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_kelas1dan3,0,",","."),'','R',1);
            }
            
            if ($k->terpencil == "YA") {
                $this->setXY($x+215,$y+4);
                $this->MULTICELL(10,4,"Tpncil",'','L',1);
                $this->setXY($x+225,$y+4);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_terpencil,0,",","."),'','R',1);
            }
           
            $this->setXY($x+215,$y+15);
            $this->MULTICELL(25,4,"Rp. ".number_format($k->jml_penambahan,0,",","."),'','R',1);
          

            // kalkulasi
            $this->setXY($x+240,$y);
            $this->MULTICELL(30,4,number_format($k->jml_tpp_kotor,0,",","."),'','R',1);
            $this->setXY($x+240,$y+4);
            $this->MULTICELL(30,4,number_format($k->jml_penambahan,0,",","."),'','R',1);

            // UNTUK YANG BELUM S1 / MASIH GOLONGAN II, DIBERIKAN 75%
            $jnsjab = $mkin->mkinerja->get_jnsjab($k->nipppk);
              if (($jnsjab == "FUNGSIONAL TERTENTU") AND (($golru == "II/A") OR ($golru == "II/B") OR ($golru == "II/C") OR ($golru == "II/D"))) {
                $ketthp = '75 %';               
              } else {
                $ketthp = '';
              }
            $this->setFont('arial','B',7);
            $this->setXY($x+240,$y+8);
            $this->MULTICELL(30,3,$ketthp,'','R',1);
            
            $this->setFont('arial','',8);
            $this->setXY($x+240,$y+8);
            $this->MULTICELL(30,3,number_format($k->jml_tpp_murni,0,",","."),'','R',1);
            $this->setXY($x+240,$y+12);
            $this->MULTICELL(30,4,number_format($k->jml_pajak,0,",","."),'','R',1);
            
            $this->setXY($x+248,$y+16);
            $this->MULTICELL(22,3,"Rp. ".number_format($k->tpp_diterima,0,",","."),'','R',1);

            // tanda tangan
            $this->setFont('arial','',7);
            $this->setXY($x+270,$y);
            $this->MULTICELL(5,5,$no.".",'','L',1);

            $this->setXY($x+275,$y);
            $this->MULTICELL(25,5,"Rp. ".number_format($k->tpp_diterima,0,",","."),'','R',1);
            $this->setFont('arial','',5);
            $this->setXY($x+270,$y+15);
            $this->MULTICELL(30,2,$mpeg->mpegawai->getnama($k->nipppk),'','C',1);
            $this->setFont('arial','',8);

            // garis vertikal            
            $this->Line($x,$y,$x,$y+20);
            $this->Line($x+10,$y,$x+10,$y+20);
            $this->Line($x+60,$y,$x+60,$y+20);
            $this->Line($x+140,$y,$x+140,$y+20);
            $this->Line($x+165,$y,$x+165,$y+20);
            $this->Line($x+190,$y,$x+190,$y+20);
            $this->Line($x+215,$y,$x+215,$y+20);
            $this->Line($x+240,$y,$x+240,$y+20);
            $this->Line($x+270,$y,$x+270,$y+20);
            $this->Line($x+300,$y,$x+300,$y+20);

            // garis horizontal
            $this->Line($x,$y,$x+300,$y);
            $this->Line($x,$y+20,$x+300,$y+20);
            
            $y=$y+20;
            $no=$no+1;
            $maxline=$maxline+1;
        } 


        $maxline1=$maxline % 5;
        $maxline2=$maxline % 6;
        $maxline3=$maxline % 7; 
        $maxline4=$maxline % 8;          
        // untuk mengatur halaman trekapitulasi (halaman terakhir) supaya tidak berantakan pada beberapa halaman terakhir  
        if (($maxline == 0) OR ($maxline2 == 0) OR ($maxline3 == 0) OR ($maxline4 == 0)) {
            $this->AddPage(); 
            $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,'TK / SDN / SMPN SEDERAJAT',0,'L',1); 
                $this->setXY(30,28);
                $this->multicell(200,5,'Periode '.bulan($k->bulan).' '.$k->tahun,0,'L',1); 
            $y =35;
	    }
        $x = 20;
        $y = $y-8;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','',10);        

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);
        $this->setXY($x,$y+10); $this->MULTICELL(60,5,"Jumlah Data",'TL','L',1);        
        $this->setXY($x+60,$y+10);$this->MULTICELL(15,5,$no-1,'TR','R',1);        
        $this->setXY($x,$y+15); $this->MULTICELL(60,5,"Jumlah Kinerja dibawah 50",'L','L',1);        
        $this->setXY($x+60,$y+15);$this->MULTICELL(15,5,$kurangdari50-1,'R','R',1);

        $ratakinerja = $mkin->mkinerja_pppk->getratakinerja_perpengantar($k->fid_pengantar, $k->tahun, $k->bulan);
        $rataabsensi = $mkin->mkinerja_pppk->getrataabsensi_perpengantar($k->fid_pengantar, $k->tahun, $k->bulan);
        $this->setXY($x,$y+20);$this->MULTICELL(60,5,"Rata-rata Kinerja",'L','L',1);
        $this->setXY($x+60,$y+20);$this->MULTICELL(15,5,number_format($ratakinerja,2),'R','R',1);
        $this->setXY($x,$y+25);$this->MULTICELL(60,5,"Rata-rata Absensi",'L','L',1);        
        $this->setXY($x+60,$y+25);$this->MULTICELL(15,5,number_format($rataabsensi,2),'R','R',1);
        $this->setXY($x,$y+30);$this->MULTICELL(75,5,"",'BLR','L',1);

        $tottppkotor = $mkin->mkinerja_pppk->tottppkotor_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $tottambahan = $mkin->mkinerja_pppk->tottambahan_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        
        $tottppmurni = $mkin->mkinerja_pppk->tottppmurni_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $totpajak = $mkin->mkinerja_pppk->totpajak_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $tottppditerima = $mkin->mkinerja_pppk->tottppditerima_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);

        $this->setXY($x+75,$y+10);$this->MULTICELL(50,5,"Total TPP sesuai Realisasi",'TL','L',1);
        $this->setXY($x+125,$y+10);$this->MULTICELL(25,5,"Rp. ".number_format($tottppkotor,0,",","."),'TR','R',1);
        $this->setXY($x+75,$y+15);$this->MULTICELL(50,5,"Total Tambahan",'L','L',1);
        $this->setXY($x+125,$y+15);$this->MULTICELL(25,5,"Rp. ".number_format($tottambahan,0,",","."),'R','R',1);        
        $this->setXY($x+75,$y+20);$this->MULTICELL(50,5,"Total TPP (Sebelum Pajak)",'L','L',1);
        $this->setXY($x+125,$y+20);$this->MULTICELL(25,5,"Rp. ".number_format($tottppmurni,0,",","."),'R','R',1);
        $this->setXY($x+75,$y+25);$this->MULTICELL(50,5,"Total Pajak",'L','L',1);
        $this->setXY($x+125,$y+25);$this->MULTICELL(25,5,"Rp. ".number_format($totpajak,0,",","."),'R','R',1);
        $this->setXY($x+75,$y+30);$this->MULTICELL(50,5,"Total TPP yang dibayarkan",'BL','L',1);
        $this->setXY($x+125,$y+30);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima,0,",","."),'BR','R',1);

	$this->setFont('arial','',8);
        $this->setXY($x+5,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR SKPD,",'','C',1);
        $this->setXY($x+5,$y+40); $this->MULTICELL(55,4,"PENGELOLA KEPEGAWAIAN",'','C',1);
        $this->setXY($x+5,$y+63); $this->MULTICELL(55,4,"NIP.",'T','L',1);

        $this->setXY($x+75,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR BKPPD,",'','C',1);
        $this->setXY($x+75,$y+59); $this->MULTICELL(55,4,"ARSWENDI ARRISDHIRA, S.Kom",'','C',1);
        $this->setXY($x+75,$y+63); $this->MULTICELL(55,4,"NIP. 198104072009041002",'T','C',1);

        // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
	$qrcode = $mkin->mkinerja_pppk->getqrcodeperpengantar($k->fid_pengantar, $k->tahun, $k->bulan);
	//var_dump($qrcode);
        $this->Image('assets/qrcodekin_pppk/'.$qrcode.'.png', $x+140,$y+40,'25','25','png');

        $this->setXY($x+170,$y+36); $this->MULTICELL(55,5,"BENDAHARA PENGELUARAN,",'','C',1);
        $this->setXY($x+170,$y+63); $this->MULTICELL(55,4,"NIP.",'T','L',1);

        $this->setXY($x+240,$y+36); $this->MULTICELL(55,5,"MENGETAHUI DAN MENYETUJUI,",'','C',1);
        $this->setXY($x+240,$y+40); $this->MULTICELL(55,4,"KEPALA SKPD",'','C',1);
        $this->setXY($x+240,$y+63); $this->MULTICELL(55,4,"NIP.",'T','L',1);
    }
        

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-10);
        $this->SetX(20);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),320,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',7);
        $this->Cell(0,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');
		//nomor halaman
		$this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
 
$pdf = new PDF('L', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('nominatifsopd.pdf', 'I');

