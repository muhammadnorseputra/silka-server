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
        $this->MULTICELL(50,5,'NIPPPK','LRT','L',1);
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
        $this->MULTICELL(30,4,'TPP REAL','LRT','R',1);
        $this->setXY($x+240,$y+4);
        $this->MULTICELL(30,4,'+ TAMBAHAN','LR','R',1);
        $this->setXY($x+240,$y+8);
        $this->MULTICELL(30,4,'- PAJAK','LR','R',1);    
        $this->setXY($x+240,$y+12);
        $this->MULTICELL(30,4,'- IWP 1%','LR','R',1);

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
		$idunker = $k->fid_unker;
                if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104')OR ($idunker == '631105')
                 OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
                        $this->multicell(200,5,'TK / SDN / SMPN SEDERAJAT KEC. '.$mpeg->mpegawai->getnamakecamatan($idunker),0,'L',1);
                } else {
                        $this->multicell(200,5,$mun->munker->getnamaunker($k->fid_unker),0,'L',1);
                }
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
		$idunker = $k->fid_unker;
                if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104')OR ($idunker == '631105')
                 OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
                        $this->multicell(200,5,'TK / SDN / SMPN SEDERAJAT KEC. '.$mpeg->mpegawai->getnamakecamatan($idunker),0,'L',1);
                } else {
                        $this->multicell(200,5,$mun->munker->getnamaunker($k->fid_unker),0,'L',1);
                }
                $this->setXY(30,28);
                $this->multicell(200,5,'Periode '.bulan($k->bulan).' '.$k->tahun,0,'L',1);                 

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,20,'NO.','LRT','L',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(50,5,'NIPPPK','LRT','L',1);
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
                $this->MULTICELL(30,4,'TPP REAL','LRT','R',1);
                $this->setXY($x+240,$y1+4);
                $this->MULTICELL(30,4,'+ TAMBAHAN','LR','R',1);
                $this->setXY($x+240,$y1+8);
                $this->MULTICELL(30,4,'- PAJAK','LR','R',1);    
                $this->setXY($x+240,$y1+12);
                $this->MULTICELL(30,4,'- IWP 1%','LR','R',1);
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
            

            if ($mpeg->mpppk->getnama($k->nipppk)) {
                $this->setXY($x+10,$y+5);
                $this->MULTICELL(50,5,$mpeg->mpppk->getnama($k->nipppk),'','L',1);            
                $this->setXY($x+10,$y+10);
                $this->MULTICELL(50,5,'Golru : '.$mpeg->mpppk->getnamagolru($k->fid_golru),'','L',1);
                $this->setXY($x+60,$y);
                $this->MULTICELL(80,4,$k->jabatan,'','L',1);
		if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104')OR ($idunker == '631105')
                 OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
                        $nmunker = $mun->munker->getnamaunker($mpeg->mpppk->getfidunker($k->nipppk));
                        $this->setXY($x+60,$y+5);
                        $this->MULTICELL(80,4,$nmunker,'','L',1);
                }
            } else {                
                // KHUSUS UNTUK YANG SUDAH PENSIUN
                /*
                $this->setXY($x+10,$y+5);
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnama_tblpensiun($k->nip),'','L',1);            
                $this->setXY($x+10,$y+10);
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnamapangkat($k->fid_golru).' ('.$mpeg->mpegawai->getnamagolru($k->fid_golru).')','','L',1);
                $this->setFont('arial','B',8);
                $this->setXY($x+10,$y+15);
                $this->MULTICELL(50,4,"PENSIUN / MUTASI",'','L',1);
                $this->setFont('arial','',8);
                $this->setXY($x+60,$y);
                $this->MULTICELL(80,4,$mpeg->mpegawai->getjab_tblpensiun($k->nip),'','L',1);
                */
            }          

            $this->setFont('arial','',8);
            $this->setXY($x+140,$y);
            $this->MULTICELL(25,4,$k->kelas_jab,'','R',1);    
            
            $this->setFont('arial','',8);
            $this->setXY($x+140,$y+16);
            $this->MULTICELL(25,3,"Rp. ".number_format($k->tpp_basic,0,",","."),'','R',1);

            // KINERJA
            if ($k->nilai_kinerja <= 50) {
                $kurangdari50 = $kurangdari50+1;
            }

	    $jnsjab = "FUNGSIONAL TERTENTU";
            $keltugasjft = $mpeg->mpppk->getkeltugas_jft_nipppk($k->nipppk);
            if (($jnsjab != "FUNGSIONAL TERTENTU") OR ($keltugasjft != "KESEHATAN")) {
                //$kinerja60p = (60/100) * $k->nilai_kinerja;
                if ($k->nilai_kinerja >= 90) {
                        $kat_skp = "SANGAT BAIK";
                } else if (($k->nilai_kinerja >= 76) AND ($k->nilai_kinerja < 90)) {
                        $kat_skp = "BAIK";
                } else if (($k->nilai_kinerja >= 61) AND ($k->nilai_kinerja < 76)) {
                        $kat_skp = "CUKUP";
                } else if (($k->nilai_kinerja >= 51) AND ($k->nilai_kinerja < 61)) {
                        $kat_skp = "KURANG";
                } else if (($k->nilai_kinerja >= 10) AND ($k->nilai_kinerja < 51)) {
                        $kat_skp = "BURUK";
                } else if ($k->nilai_kinerja == 0) {
                        $kat_skp = "NILAI SKP TIDAK ADA";
                }
                $this->setXY($x+165,$y);
                $this->MULTICELL(25,5,number_format($k->nilai_kinerja,2),'','R',1);
                $this->setFont('arial','',6);
                $this->setXY($x+165,$y+5);
                $this->MULTICELL(25,5,$kat_skp,'','R',1);
                $this->setFont('arial','',8);
                $this->setXY($x+165,$y+10);
                $this->MULTICELL(25,5,"Rp. ".number_format($k->tpp_kinerja,0,",","."),'','R',1);
            }

            // ABSENSI
            $absensi40p = (40/100) * $k->nilai_absensi;
            $this->setXY($x+190,$y);
            $this->MULTICELL(25,5,number_format($k->nilai_absensi,2),'','R',1);
            $this->setXY($x+190,$y+5);
            $this->MULTICELL(25,5,number_format($absensi40p,2),'','R',1);
            $this->setXY($x+190,$y+10);
            $this->MULTICELL(25,5,"Rp. ".number_format($k->tpp_absensi,0,",","."),'','R',1);

            
            if ($k->kelas1dan3 == "YA") {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"K 1n3",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_kelas1dan3,0,",","."),'','R',1);
            }

            if ($k->terpencil == "YA") {
                $this->setXY($x+215,$y+4);
                $this->MULTICELL(10,4,"Tpncil",'','L',1);
                $this->setXY($x+225,$y+4);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_terpencil,0,",","."),'','R',1);
            }   

            $this->setFont('arial','',8);

            $this->setXY($x+215,$y+15);
            $this->MULTICELL(25,4,"Rp. ".number_format($k->jml_penambahan,0,",","."),'','R',1);
          

            // kalkulasi
            $this->setXY($x+240,$y);
            $this->MULTICELL(30,4,number_format($k->jml_tpp_kotor,0,",","."),'','R',1);
            $this->setXY($x+240,$y+4);
            $this->MULTICELL(30,4,number_format($k->jml_penambahan,0,",","."),'','R',1);
            $this->setXY($x+240,$y+8);
            $this->MULTICELL(30,4,"(".number_format($k->jml_pajak,0,",",".").")",'','R',1);
            $this->setXY($x+240,$y+12);
            $this->MULTICELL(30,4,"(".number_format($k->jml_iuran_bpjs,0,",",".").")",'','R',1);
            $this->setXY($x+240,$y+16);
            $this->MULTICELL(30,3,"Rp. ".number_format($k->tpp_diterima,0,",","."),'','R',1);

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
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,$mun->munker->getnamaunker($k->fid_unker),0,'L',1); 
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
        $totiwp = $mkin->mkinerja_pppk->totiwp_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $tottppditerima = $mkin->mkinerja_pppk->tottppditerima_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);


        $this->setXY($x+75,$y+10);$this->MULTICELL(50,5,"Total TPP sesuai Realisasi",'TL','L',1);
        $this->setXY($x+125,$y+10);$this->MULTICELL(25,5,"Rp. ".number_format($tottppkotor,0,",","."),'TR','R',1);
        $this->setXY($x+75,$y+15);$this->MULTICELL(50,5,"Total TPP Bruto (Sebelum Pajak)",'L','L',1);
        $this->setXY($x+125,$y+15);$this->MULTICELL(25,5,"Rp. ".number_format($tottppmurni,0,",","."),'R','R',1);        
        $this->setXY($x+75,$y+20);$this->MULTICELL(50,5,"Total Pajak)",'L','L',1);
        $this->setXY($x+125,$y+20);$this->MULTICELL(25,5,"Rp. ".number_format($totpajak,0,",","."),'R','R',1);
        $this->setXY($x+75,$y+25);$this->MULTICELL(50,5,"Total IWP 1%",'L','L',1);
        $this->setXY($x+125,$y+25);$this->MULTICELL(25,5,"Rp. ".number_format($totiwp,0,",","."),'R','R',1);
        $this->setXY($x+75,$y+30);$this->MULTICELL(50,5,"Total TPP yang dibayarkan",'BL','L',1);
        $this->setXY($x+125,$y+30);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima,0,",","."),'BR','R',1);

	$entrioleh = $mkin->mkinerja_pppk->getpetugasentry_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $entritgl = $mkin->mkinerja_pppk->gettglentry_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $updateoleh = $mkin->mkinerja_pppk->getpetugasupdate_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);
        $updatetgl = $mkin->mkinerja_pppk->gettglupdate_perpengantarperiode($k->fid_pengantar, $k->tahun, $k->bulan);

        if ($updatetgl >= $entritgl) {
                $nippetugas = $updateoleh;
                $tglproses = $updatetgl;
        } else {
                $nippetugas = $entrioleh;
                $tglproses = $entritgl;
        }

	$this->setFont('arial','',8);
        $this->setXY($x+5,$y+36); $this->MULTICELL(55,4,"OPERATOR DAN VERIFIKATOR SKPD,",'','C',1);
        $this->setXY($x+5,$y+59); $this->MULTICELL(55,4,$mpeg->mpegawai->getnama($nippetugas),'','C',1);
        $this->setXY($x+5,$y+63); $this->MULTICELL(55,4,"NIP. ".$nippetugas,'T','C',1);

        //$this->setXY($x+75,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR BKPPD,",'','C',1);
        //$this->setXY($x+75,$y+59); $this->MULTICELL(55,4,$mpeg->mpegawai->getnama($nippetugas),'','C',1);
        //$this->setXY($x+75,$y+63); $this->MULTICELL(55,4,"NIP. ".$nippetugas,'T','C',1);

        // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
        $qrcode = $mkin->mkinerja_pppk->getqrcode($k->fid_unker, $k->tahun, $k->bulan);
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
$pdf->Output('RekapTPP.pdf', 'I');

