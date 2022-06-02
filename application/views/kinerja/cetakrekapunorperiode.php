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
                
                /*
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(20,3,'',0,0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 22,'8','10','jpeg');
                $this->cell(100,4,'Badan Kepegawaian Daerah',0,1,'L',1); 
                $this->cell(20,3,'',0,0,'C',0); 
                $this->cell(100,6,'Nominatif ',0,1,'L',1); 
                */
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
        $this->MULTICELL(25,5,'STATUS','LR','L',1);    
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
        //$this->setXY($x+215,$y+5);
        //$this->MULTICELL(25,5,'+ BENDAHARA','LR','R',1);
        //$this->setXY($x+215,$y+10);
        //$this->MULTICELL(25,5,'+ KELAS 1 & 3','LR','R',1);    
        //$this->setXY($x+215,$y+15);
        //$this->MULTICELL(25,5,'TOTAL','LR','R',1);

        $this->setXY($x+240,$y);
        $this->MULTICELL(30,4,'TPP GROSS','LRT','R',1);
        $this->setXY($x+240,$y+4);
        $this->MULTICELL(30,4,'+ TAMBAHAN','LR','R',1);
        $this->setXY($x+240,$y+8);
        $this->MULTICELL(30,4,'- PAJAK','LR','R',1);    
        $this->setXY($x+240,$y+12);
        $this->MULTICELL(30,4,'','LR','R',1);
        $this->setXY($x+240,$y+16);
        $this->MULTICELL(30,4,'TPP DITERIMA','LR','R',1);

        $this->setXY($x+270,$y);
        $this->MULTICELL(30,20,'TANDA TANGAN','LRT','C',1);

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
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,$mun->munker->getnamaunker($k->fid_unker),0,'L',1);
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
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,$mun->munker->getnamaunker($k->fid_unker),0,'L',1); 
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
                $this->MULTICELL(25,5,'STATUS','LR','L',1);    
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

                /*
                $this->setXY($x+215,$y1);
                $this->MULTICELL(25,5,'+ SEKDA','LRT','R',1);
                $this->setXY($x+215,$y1+5);
                $this->MULTICELL(25,5,'+ BENDAHARA','LR','R',1);
                $this->setXY($x+215,$y1+10);
                $this->MULTICELL(25,5,'+ KELAS 1 & 3','LR','R',1);    
                $this->setXY($x+215,$y1+15);
                $this->MULTICELL(25,5,'TOTAL','LR','R',1);
                */

                $this->setXY($x+240,$y1);
                $this->MULTICELL(30,4,'TPP GROSS','LRT','R',1);
                $this->setXY($x+240,$y1+4);
                $this->MULTICELL(30,4,'+ TAMBAHAN','LR','R',1);
                $this->setXY($x+240,$y1+8);
                $this->MULTICELL(30,4,'- PAJAK','LR','R',1);    
                $this->setXY($x+240,$y1+12);
                $this->MULTICELL(30,4,'','LR','R',1);
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
            $this->MULTICELL(50,5,"NIP. ".$k->nip,'','L',1);            

	    if ($mpeg->mpegawai->getnama($k->nip)) {
                $this->setXY($x+10,$y+5);
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnama($k->nip),'','L',1);            
                $this->setXY($x+10,$y+10);
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnamapangkat($k->fid_golru).' ('.$mpeg->mpegawai->getnamagolru($k->fid_golru).')','','L',1);
                $this->setXY($x+60,$y);
                $this->MULTICELL(80,4,$mpeg->mpegawai->namajabnip($k->nip),'','L',1);
            } else {                
                // KHUSUS UNTUK YANG SUDAH PENSIUN
                $this->setXY($x+10,$y+5);
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnama_tblpensiun($k->nip),'','L',1);            
                $this->setXY($x+10,$y+10);
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnamapangkat($k->fid_golru).' ('.$mpeg->mpegawai->getnamagolru($k->fid_golru).')','','L',1);
                $this->setFont('arial','B',8);
                $this->setXY($x+10,$y+15);
                $this->MULTICELL(50,4,"PENSIUN / MUTASI KELUAR",'','L',1);
                $this->setFont('arial','',8);
                $this->setXY($x+60,$y);
                $this->MULTICELL(80,4,$mpeg->mpegawai->getjab_tblpensiun($k->nip),'','L',1);
            }

            $cekplt = $mkin->mkinerja->cek_sdgplt($k->nip, $k->bulan, $k->tahun);
            if (($cekplt == true) AND ($k->cuti_sakit == "TIDAK") AND ($k->cuti_besar == "TIDAK")) {
                $dataplt = $mkin->mkinerja->get_dataplt($k->nip); 
                $this->setXY($x+60,$y+5);
                $this->setFont('arial','',6);
                $this->MULTICELL(80,2,"PLT. ".$dataplt,'','L',1);
            }
                    
            $cekbendahara = $mkin->mkinerja->cek_sdgbendahara($k->nip, $k->bulan, $k->tahun);
            if ($cekbendahara == true) {
                $databendahara = $mkin->mkinerja->get_databendahara($k->nip);
                $this->setXY($x+60,$y+10);
                $this->setFont('arial','',6);
                $this->MULTICELL(80,2,$databendahara,'','L',1);
            }

            $this->setFont('arial','',8);
            $this->setXY($x+140,$y);
            if ($k->plt == "YA") {
                $this->MULTICELL(25,4,$k->plt_kelasjab,'','R',1);
            } else {
                $this->MULTICELL(25,4,$k->kelas_jab,'','R',1);    
            }
            //$this->setXY($x+140,$y+4);
            //$this->MULTICELL(25,4,$k->harga_jab,'','R',1);

            $this->setXY($x+140,$y+9);
            $this->setFont('arial','B',7);
            if ($k->cpns == "YA") {
                $this->setXY($x+140,$y+7);
                $this->MULTICELL(20,3,"CPNS (80%)",'','L',1);
            }

            if ($k->cuti_sakit == "YA") {
                $this->setXY($x+140,$y+11);
                $this->MULTICELL(25,3,"CUTI SAKIT (80%)",'','L',1);
            }

            if ($k->cuti_besar == "YA") {
                $this->setXY($x+140,$y+11);
                $this->MULTICELL(25,3,"CUTI BESAR (80%)",'','L',1);
            }
            $this->setFont('arial','',8);

            $this->setXY($x+140,$y+16);
            $this->MULTICELL(25,3,"Rp. ".number_format($k->tpp_basic,0,",","."),'','R',1);

            // KINERJA
            if ($k->nilai_kinerja <= 50) {
                $kurangdari50 = $kurangdari50+1;
            }

	    $jnsjab = $mkin->mkinerja->get_jnsjab($k->nip);
            $keltugasjft = $mpeg->mpegawai->getkeltugas_jft_nip($k->nip);
            if (($jnsjab != "FUNGSIONAL TERTENTU") OR ($keltugasjft != "KESEHATAN")) {                
            	$kinerja60p = (60/100) * $k->nilai_kinerja;
            	$this->setXY($x+165,$y);
            	$this->MULTICELL(25,5,number_format($k->nilai_kinerja,2),'','R',1);
            	$this->setXY($x+165,$y+5);
            	$this->MULTICELL(25,5,number_format($kinerja60p,2),'','R',1);
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

            // TAMBAHAN
            $this->setFont('arial','',7);
            if ($k->jml_tpp_plt != 0) {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"Plt",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_plt,0,",","."),'','R',1);
            }

            $this->setFont('arial','',7);
            if ($k->sekda == "YA") {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"Sekda",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_sekda,0,",","."),'','R',1);
            }

	    if ($k->dokter == "YA") {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"Dokter",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_dokter,0,",","."),'','R',1);
            }

            if ($k->pokja == "YA") {
                $this->setXY($x+215,$y+4);
                $this->MULTICELL(10,4,"Pokja",'','L',1);
                $this->setXY($x+225,$y+4);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_pokja,0,",","."),'','R',1);
            }

            if ($k->kelas1dan3 == "YA") {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"K 1n3",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_kelas1dan3,0,",","."),'','R',1);
            }

            if ($k->bendahara == "YA") {
                $this->setXY($x+215,$y);
                $this->MULTICELL(10,4,"Bend",'','L',1);
                $this->setXY($x+225,$y);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_bendahara,0,",","."),'','R',1);
            }

            if ($k->terpencil == "YA") {
                $this->setXY($x+215,$y+4);
                $this->MULTICELL(10,4,"Trpncil",'','L',1);
                $this->setXY($x+225,$y+4);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_terpencil,0,",","."),'','R',1);
            }

            if ($k->tanpajfu == "YA") {
                $this->setXY($x+215,$y+8);
                $this->MULTICELL(10,4,"NoJFU",'','L',1);
                $this->setXY($x+225,$y+8);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_tanpajfu,0,",","."),'','R',1);
            }

            if ($k->inspektorat == "YA") {
                $this->setXY($x+215,$y+8);
                $this->MULTICELL(10,4,"Inspk",'','L',1);
                $this->setXY($x+225,$y+8);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_inspektorat,0,",","."),'','R',1);
            }

            if ($k->radiografer == "YA") {
                $this->setXY($x+215,$y+8);
                $this->MULTICELL(10,4,"Radgf",'','L',1);
                $this->setXY($x+225,$y+8);
                $this->MULTICELL(15,4,number_format($k->jml_tpp_radiografer,0,",","."),'','R',1);
            }
            $this->setFont('arial','',8);

            $this->setXY($x+215,$y+15);
            $this->MULTICELL(25,4,"Rp. ".number_format($k->jml_penambahan,0,",","."),'','R',1);
          

            // kalkulasi
            $this->setXY($x+240,$y);
            $this->MULTICELL(30,4,number_format($k->jml_tpp_kotor,0,",","."),'','R',1);
            $this->setXY($x+240,$y+4);
            $this->MULTICELL(30,4,"".number_format($k->jml_penambahan,0,",","."),'','R',1);

	    $this->setXY($x+240,$y+8);
            $this->MULTICELL(30,4,"".number_format($k->jml_pajak,0,",","."),'','R',1);
            $this->setXY($x+240,$y+12);
            $this->MULTICELL(30,4,"",'','R',1);
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
            $this->MULTICELL(30,2,$mpeg->mpegawai->getnama($k->nip),'','C',1);
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
	var_dump($k->fid_unker);

        $ratakinerja = $mkin->mkinerja->getratakinerja($k->fid_unker, $k->tahun, $k->bulan);
        $rataabsensi = $mkin->mkinerja->getrataabsensi($k->fid_unker, $k->tahun, $k->bulan);
        $this->setXY($x,$y+20);$this->MULTICELL(60,5,"Rata-rata Kinerja",'L','L',1);
        $this->setXY($x+60,$y+20);$this->MULTICELL(15,5,number_format($ratakinerja,2),'R','R',1);
        $this->setXY($x,$y+25);$this->MULTICELL(60,5,"Rata-rata Absensi",'L','L',1);        
        $this->setXY($x+60,$y+25);$this->MULTICELL(15,5,number_format($rataabsensi,2),'R','R',1);
        $this->setXY($x,$y+30);$this->MULTICELL(75,5,"",'BLR','L',1);


        $tottppkotor = $mkin->mkinerja->tottppkotor_perunkerperiode($k->fid_unker, $k->tahun, $k->bulan);
        $tottambahan = $mkin->mkinerja->tottambahan_perunkerperiode($k->fid_unker, $k->tahun, $k->bulan);
        
        $tottppmurni = $mkin->mkinerja->tottppmurni_perunkerperiode($k->fid_unker, $k->tahun, $k->bulan);
        $totpajak = $mkin->mkinerja->totpajak_perunkerperiode($k->fid_unker, $k->tahun, $k->bulan);
        $tottppditerima = $mkin->mkinerja->tottppditerima_perunkerperiode($k->fid_unker, $k->tahun, $k->bulan);
        $this->setXY($x+75,$y+10);$this->MULTICELL(50,5,"Total TPP sesuai Realisasi",'TL','L',1);
        $this->setXY($x+125,$y+10);$this->MULTICELL(25,5,"Rp. ".number_format($tottppkotor,0,",","."),'TR','R',1);
        $this->setXY($x+75,$y+15);$this->MULTICELL(50,5,"Total Indikator Tambahan",'L','L',1);
        $this->setXY($x+125,$y+15);$this->MULTICELL(25,5,"Rp. ".number_format($tottambahan,0,",","."),'R','R',1);        
        $this->setXY($x+75,$y+20);$this->MULTICELL(50,5,"Total TPP (Sebelum Pajak)",'L','L',1);
        $this->setXY($x+125,$y+20);$this->MULTICELL(25,5,"Rp. ".number_format($tottppmurni,0,",","."),'R','R',1);
        $this->setXY($x+75,$y+25);$this->MULTICELL(50,5,"Total Pajak",'L','L',1);
        $this->setXY($x+125,$y+25);$this->MULTICELL(25,5,"Rp. ".number_format($totpajak,0,",","."),'R','R',1);
        $this->setXY($x+75,$y+30);$this->MULTICELL(50,5,"Total TPP yang dibayarkan",'BL','L',1);
        $this->setXY($x+125,$y+30);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima,0,",","."),'BR','R',1);
        //$this->setXY($x+75,$y+35);$this->MULTICELL(75,5,"",'L','L',1);
        //$this->setXY($x+75,$y+40);$this->MULTICELL(75,5,"",'LB','L',1);
    
        $tottppditerimagol4 = $mkin->mkinerja->tottppditerima_perunkerperiode_pergolru($k->fid_unker, $k->tahun, $k->bulan,"IV/");
        $tottppditerimagol3 = $mkin->mkinerja->tottppditerima_perunkerperiode_pergolru($k->fid_unker, $k->tahun, $k->bulan,"III/");
        $tottppditerimagol2 = $mkin->mkinerja->tottppditerima_perunkerperiode_pergolru($k->fid_unker, $k->tahun, $k->bulan,"II/");
        $tottppditerimagol1 = $mkin->mkinerja->tottppditerima_perunkerperiode_pergolru($k->fid_unker, $k->tahun, $k->bulan,"I/");
        $this->setXY($x+150,$y+10);$this->MULTICELL(75,5,"Total TPP yang dibayarkan (per Golongan Ruang)",'TL','L',1);
        $this->setXY($x+150,$y+15);$this->MULTICELL(50,5,"Golongan IV",'L','L',1);
        $this->setXY($x+200,$y+15);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerimagol4,0,",","."),'R','R',1);
        $this->setXY($x+150,$y+20);$this->MULTICELL(50,5,"Golongan III",'L','L',1);
        $this->setXY($x+200,$y+20);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerimagol3,0,",","."),'R','R',1);
        $this->setXY($x+150,$y+25);$this->MULTICELL(50,5,"Golongan II",'L','L',1);
        $this->setXY($x+200,$y+25);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerimagol2,0,",","."),'R','R',1);
        $this->setXY($x+150,$y+30);$this->MULTICELL(50,5,"Golongan I",'LB','L',1);
        $this->setXY($x+200,$y+30);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerimagol1,0,",","."),'BR','R',1);

        $tottppditerima_jpt = $mkin->mkinerja->tottppditerima_perunkerperiode_jpt($k->fid_unker, $k->tahun, $k->bulan);
        $tottppditerima_administrator = $mkin->mkinerja->tottppditerima_perunkerperiode_administrator($k->fid_unker, $k->tahun, $k->bulan);
        $tottppditerima_pengawas = $mkin->mkinerja->tottppditerima_perunkerperiode_pengawas($k->fid_unker, $k->tahun, $k->bulan);
        $tottppditerima_jfujft = $mkin->mkinerja->tottppditerima_perunkerperiode_jfujft($k->fid_unker, $k->tahun, $k->bulan);
        $this->setXY($x+225,$y+10); $this->MULTICELL(75,5,"Total TPP yang dibayarkan (per Kelompok Jabatan)",'TLR','L',1);
        $this->setXY($x+225,$y+15); $this->MULTICELL(50,5,"Jabatan Pimpinan Tinggi",'L','L',1);
        $this->setXY($x+275,$y+15);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima_jpt,0,",","."),'R','R',1);
        $this->setXY($x+225,$y+20); $this->MULTICELL(50,5,"Administrator",'L','L',1);
        $this->setXY($x+275,$y+20);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima_administrator,0,",","."),'R','R',1);
        $this->setXY($x+225,$y+25); $this->MULTICELL(50,5,"Pengawas",'L','L',1);
        $this->setXY($x+275,$y+25);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima_pengawas,0,",","."),'R','R',1);
        $this->setXY($x+225,$y+30); $this->MULTICELL(50,5,"JFU/JFT",'LB','L',1);
        $this->setXY($x+275,$y+30);$this->MULTICELL(25,5,"Rp. ".number_format($tottppditerima_jfujft,0,",","."),'BR','R',1);

        $this->setFont('arial','',8);
        $this->setXY($x+5,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR SKPD,",'','C',1);
	$this->setXY($x+5,$y+40); $this->MULTICELL(55,4,"PENGELOLA KEPEGAWAIAN",'','C',1);
        $this->setXY($x+5,$y+63); $this->MULTICELL(55,4,"NIP.",'T','L',1);

	$this->setXY($x+75,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR BKPPD,",'','C',1);        
        $this->setXY($x+75,$y+59); $this->MULTICELL(55,4,"ARSWENDI ARRISDHIRA, S.Kom",'','C',1);       
        $this->setXY($x+75,$y+63); $this->MULTICELL(55,4,"NIP. 198104072009041002",'T','C',1);

        // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
        $qrcode = $mkin->mkinerja->getqrcode($k->fid_unker, $k->tahun, $k->bulan);
        $this->Image('assets/qrcodekin/'.$qrcode.'.png', $x+140,$y+40,'25','25','png');

        $this->setXY($x+170,$y+36); $this->MULTICELL(55,5,"BENDAHARA PENGELUARAN,",'','C',1);
        $this->setXY($x+170,$y+63); $this->MULTICELL(55,4,"NIP.",'T','L',1);

        $this->setXY($x+240,$y+36); $this->MULTICELL(55,5,"MENGETAHUI DAN MENYETUJUI,",'','C',1);
        $this->setXY($x+240,$y+40); $this->MULTICELL(55,4,"KEPALA SKPD",'','C',1);
        $this->setXY($x+240,$y+63); $this->MULTICELL(55,4,"NIP.",'T','L',1);

        /*
        $maxline=$maxline % 5;            
        if ($maxline == 0) {
            $y = 20;
        } else {
            $this->AddPage();  
            $x = 10;
            $y = 10;    
        } 
        */       

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
