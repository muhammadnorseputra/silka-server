<?php

class PDF extends FPDF
{     
    protected $lasthal = "N";

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
                //$this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1);
		$this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP1. '.$login->session->userdata('nip').') pada ' .date('d F Y, h:i:s A'),0,1,'R',1);
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
        $mpppk = new Mpppk();
        $mtppng = new Mtppng();
        $mun = new Munker();
        $mpeta = new Mpetajab();
        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,20,'NO.','LRT','L',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(50,20,'IDENTITAS','LRT','L',1);
        $this->setXY($x+60,$y);
        $this->MULTICELL(70,20,'INFORMASI JABATAN','LTR','L',1);
        $this->setFont('arial','B',6);
	$this->setXY($x+130,$y);
        $this->MULTICELL(15,20,'','LTR','L',1);
        $this->setXY($x+130,$y+1);
        $this->MULTICELL(15,2.5,'PRODUKTIFITAS KERJA','LR','R',1);
        $this->setXY($x+130,$y+8);
        $this->MULTICELL(15,2.5,'DISIPLIN KERJA','LR','R',1);
        $this->setXY($x+130,$y+16);
        $this->MULTICELL(15,2.5,'CAPAIAN','LR','R',1);
        
	$this->setFont('arial','B',8);
        $this->setXY($x+145,$y);
        $this->MULTICELL(100,10,'KRITERIA','LRT','C',1);
        $this->setXY($x+145,$y+10);
        $this->MULTICELL(20,5,'BEBAN KERJA','LRT','C',1);
        $this->setXY($x+165,$y+10);
        $this->MULTICELL(20,5,'PRESTASI KERJA','LRT','C',1);
        $this->setXY($x+185,$y+10);
        $this->MULTICELL(20,5,'KONDISI KERJA','LRT','C',1);
	$this->setFont('arial','B',7);
        $this->setXY($x+205,$y+10);
        $this->MULTICELL(20,5,'KELANGKAAN PROFESI','LRT','C',1);
	$this->setFont('arial','B',8);
        $this->setXY($x+225,$y+10);
        $this->MULTICELL(20,10,'TOTAL','LRT','C',1);

	$this->setFont('arial','B',7);	
        $this->setXY($x+245,$y);
        $this->MULTICELL(25,4,'Tunj. BPJS 4%','LRT','R',1);
	$this->setXY($x+245,$y+4);
        $this->MULTICELL(25,3,'TPP BRUTO','LR','R',1);
        $this->setXY($x+245,$y+7);
        $this->MULTICELL(25,3,'(Pot. PPh 21)','LR','R',1);
        $this->setXY($x+245,$y+10);
        $this->MULTICELL(25,3,'(Pot. IWP 1%)','LR','R',1);    
        $this->setXY($x+245,$y+13);
        $this->MULTICELL(25,3,'(Pot. BPJS 4%)','LR','R',1);
        $this->setXY($x+245,$y+16);
        $this->MULTICELL(25,4,'TPP NETO','LR','R',1);

        $this->setXY($x+270,$y);
        $this->MULTICELL(30,20,'TANDA TANGAN','LRT','C',1);

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 55;
        $no = 1;        
        $maxline=1;
        foreach ($data as $k) {
            if ($no==1) {
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'10','12','jpeg');
                $this->setXY(32,20);
                $jnsasn = $mtppng->mtppng->get_jnsasn($k['fid_pengantar']);
                if ($jnsasn == "PNS") {
                    $this->multicell(200,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS KE-13 TAHUN 2023',0,'L',1);
                } else if ($jnsasn == "PPPK") {
                    $this->multicell(200,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK KE-13 TAHUN 2023',0,'L',1);
                } 
                $this->setXY(32,24);
                $this->multicell(200,5,$mun->munker->getnamaunker($k['fid_unker']),0,'L',1);
                $this->setXY(32,28);
                $this->multicell(200,5,'PERIODE '.strtoupper(bulan($k['bulan'])).' '.$k['tahun'],0,'L',1); 
		
                $this->SetFont('Arial','B',40);
                //$this->SetTextColor(176,224,230); // Powder Blue
		//$this->SetTextColor(173,216,230); // Light Blue
		$this->SetTextColor(222, 184, 135); // burly wood
                $this->Text(210, 30, "TPP KE-13 2023");
                $this->SetTextColor(0,0,0);

	}

           
            $maxline=$maxline % 7;            
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 35;
                $y = 55;
                //$this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'10','12','jpeg');
                $this->setXY(32,20);
                $jnsasn = $mtppng->mtppng->get_jnsasn($k['fid_pengantar']);
                if ($jnsasn == "PNS") {
                    $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS KE-13 TAHUN 2023',0,'L',1);
                } else if ($jnsasn == "PPPK") {
                    $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK KE-13 TAHUN 2023',0,'L',1);
                } 	
                $this->setXY(32,24);
                $this->multicell(200,5,$mun->munker->getnamaunker($k['fid_unker']),0,'L',1);
                $this->setXY(32,28);
                $this->multicell(200,5,'PERIODE '.strtoupper(bulan($k['bulan'])).' '.$k['tahun'],0,'L',1);

		// Darft Demo
		//$this->SetFont('Arial','B',50);
        	//$this->SetTextColor(255,222,233);
		//$this->Text(200, 30, "DRAFT DEMO");
		//$this->SetTextColor(0,0,0);

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,20,'NO.','LRT','L',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(50,20,'IDENTITAS','LRT','L',1);
                $this->setXY($x+60,$y1);
                $this->MULTICELL(70,20,'IFORMASI JABATAN','LTR','L',1);
		$this->setFont('arial','B',6);
        	$this->setXY($x+130,$y1);
        	$this->MULTICELL(15,20,'','LTR','L',1);
        	$this->setXY($x+130,$y1+1);
        	$this->MULTICELL(15,2.5,'PRODUKTIFITAS KERJA','LR','R',1);
        	$this->setXY($x+130,$y1+8);
        	$this->MULTICELL(15,2.5,'DISIPLIN KERJA','LR','R',1);
        	$this->setXY($x+130,$y1+16);
        	$this->MULTICELL(15,2.5,'CAPAIAN','LR','R',1);

		$this->setFont('arial','B',8);
                $this->setXY($x+145,$y1);
                $this->MULTICELL(100,10,'KRITERIA','LRT','C',1);
                $this->setXY($x+145,$y1+10);
                $this->MULTICELL(20,5,'BEBAN KERJA','LRT','C',1);
                $this->setXY($x+165,$y1+10);
                $this->MULTICELL(20,5,'PRESTASI KERJA','LRT','C',1);
                $this->setXY($x+185,$y1+10);
                $this->MULTICELL(20,5,'KONDISI KERJA','LRT','C',1);
                $this->setFont('arial','B',7);
		$this->setXY($x+205,$y1+10);
                $this->MULTICELL(20,5,'KELANGKAAN PROFESI','LRT','C',1);
		$this->setFont('arial','B',8);
                $this->setXY($x+225,$y1+10);
                $this->MULTICELL(20,10,'TOTAL','LRT','C',1);

		$this->setFont('arial','B',7);
                $this->setXY($x+245,$y1);
                $this->MULTICELL(25,4,'Tunj. BPJS 4%','LRT','R',1);
		$this->setXY($x+245,$y1+4);
                $this->MULTICELL(25,3,'TPP Bruto','LR','R',1);
                $this->setXY($x+245,$y1+7);
                $this->MULTICELL(25,3,'(Pot. PPh 21)','LR','R',1);
                $this->setXY($x+245,$y1+10);
                $this->MULTICELL(25,3,'(Pot. IWP 1%)','LR','R',1);    
                $this->setXY($x+245,$y1+13);
                $this->MULTICELL(25,3,'(Pot. BPJS 4%)','LR','R',1);
                $this->setXY($x+245,$y1+16);
                $this->MULTICELL(25,4,'TPP NETO','LR','R',1);

		$this->setFont('arial','',8);
                $this->setXY($x+270,$y1);
                $this->MULTICELL(30,20,'TANDA TANGAN','LRT','C',1);
                $maxline=$maxline+1;
            }
           
            $this->setFillColor(255,255,255);
            $this->setFont('arial','',7);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $jnsasn = $mtppng->mtppng->get_jnsasn($k['fid_pengantar']);
            if ($jnsasn == "PNS") {
                $this->MULTICELL(50,5,"NIP. ".$k['nip'],'','L',1);
            } else if ($jnsasn == "PPPK") {
                $this->MULTICELL(50,5,"NIPPPK. ".$k['nip'],'','L',1);
            }
            
            $this->setXY($x+10,$y+4);

            if ($jnsasn == "PNS") {
                $this->MULTICELL(50,5,$mpeg->mpegawai->getnama($k['nip']),'','L',1);
            } else if ($jnsasn == "PPPK") {
                $this->MULTICELL(50,5,$mpppk->mpppk->getnama($k['nip']),'','L',1);
            }

            $this->setFont('arial','',7);
            $this->setXY($x+10,$y+8);
            if ($jnsasn == "PNS") {
                $idgolru = $mpeta->mpetajab->getidgolru($k['nip']);
                $golru = $mpeg->mpegawai->getnamagolru($idgolru);
                $this->MULTICELL(20,5,"Golru : ".$golru,'','L',1);
            } else if ($jnsasn == "PPPK") {
                $idgolru = $mpppk->mpppk->getidgolruterakhir($k['nip']);
                $golru = $mpppk->mpppk->getnamagolru($idgolru);
                $this->MULTICELL(20,5,"Golru : ".$golru,'','L',1);
            }
	
            //if ($k['statuspeg'] == "CPNS") {
            //    $this->setXY($x+10,$y+15); $this->MULTICELL(10,5,"CPNS",'','L',1);
            //} else {
            $this->setXY($x+35,$y+8); $this->MULTICELL(25,4,"Status : ".$k['statuspeg'],'','L',1);
            //}
            
            if ($k['jns_ptkp']) {
                $this->setXY($x+10,$y+12);$this->MULTICELL(25,4,"Jenis PTKP : ".$k['jns_ptkp'],'','L',1);
            } 

            if ($k['npwp']) {
                $this->setXY($x+35,$y+12);$this->MULTICELL(25,4,"NPWP : ADA",'','L',1);
            } else {
                $this->setXY($x+35,$y+12);$this->MULTICELL(25,4,"NPWP : TIDAK ADA",'','L',1);
            } 
            $this->setFont('arial','',8);

            if ($k['ket_pengurang'] != "") {
                $this->setTextColor(225, 69, 0); //OrangeRed
                $this->setXY($x+10,$y+16);$this->MULTICELL(50,4,"Pengurang : ".$k['ket_pengurang'],'','L',1);
            }
            $this->setTextColor(0,0,0);
            /*
            if ($v['persen_pengurang'] == 100) {
                $this->setXY($x+10,$y+15);
                $this->MULTICELL(50,5,"CPNS",'','L',1);
            } else if ($v['persen_pengurang'] == 40) {
              echo "<br/><span class='label label-danger'>PENGURANG 40 %</span>";
            }  else if ($v['persen_pengurang'] == 20) {
              echo "<br/><span class='label label-danger'>PENGURANG 20 %</span>";
            }
            */
            
           
            $this->setFont('arial','',6.5);
	    $koord = $mpeta->mpetajab->get_koorsubkoord($k['fid_jabpeta']);
	    if ($koord) {            
            	$this->setXY($x+60,$y);
            	$this->MULTICELL(70,3,$k['jabatan']." [".$koord."]",'','L',1);
		$kelasjab = $k['kelasjab'];
            } else {
		$this->setXY($x+60,$y);
                $this->MULTICELL(70,3,$k['jabatan'],'','L',1);
		$kelasjab = $k['kelasjab'];
	    }

            if ($k['persen_plt'] == '100') {
                $this->setXY($x+60,$y+10);
                $this->MULTICELL(70,2,"PLT. ".$k['jabatan_plt']." [100 %]",'','L',1);
		$kelasjab = $k['kelasjab_plt'];
            } else if ($k['persen_plt'] == '20') {
                $this->setXY($x+60,$y+10);
                $this->MULTICELL(70,2,"PLT. ".$k['jabatan_plt']." [20 %]",'','L',1);
		$kelasjab = $k['kelasjab_plt'];
            }
		//$this->setXY($x+60,$y+10);
		//$this->MULTICELL(70,3,"PLT. ",'1','L',1);
            
	    $this->setXY($x+60,$y+16);
            $this->MULTICELL(15,3,"Kelas : ".$kelasjab,'','L',1);

	/*
	$this->setFont('arial','B',6);
        $this->setXY($x+130,$y);
        $this->MULTICELL(15,20,'','LTR','L',1);
        $this->setXY($x+130,$y+1);
        $this->MULTICELL(15,2.5,'PRODUKTIFITAS KERJA','LR','L',1);
        $this->setXY($x+130,$y+8);
        $this->MULTICELL(15,2.5,'DISIPLIN KERJA','LR','L',1);
        $this->setXY($x+130,$y+16);
        $this->MULTICELL(15,2.5,'CAPAIAN','LR','L',1);
	*/
            $this->setFont('arial','',7);
            $this->setXY($x+130,$y+1);
            $this->MULTICELL(15,2.5,"Kin. ". $k['nilai_produktifitas'],'LR','R',1);
            $this->setXY($x+130,$y+3.5);
            $this->setTextColor(65, 105, 225); //RoyalBlue
            $this->MULTICELL(15,3,$k['persen_produktifitas']." %",'LR','R',1);
            $this->setTextColor(0,0,0);
            $this->setXY($x+130,$y+8);
            $this->MULTICELL(15,2.5,"Abs. ". $k['nilai_disiplin'],'LR','R',1);
            $this->setXY($x+130,$y+10.5);
            $this->setTextColor(65, 105, 225); //RoyalBlue
            $this->MULTICELL(15,3,$k['persen_disiplin']." %",'LR','R',1);
	    $this->setXY($x+130,$y+16);
	    $capaian = $k['persen_produktifitas'] + $k['persen_disiplin'];
	    $this->setFont('arial','B',8);            
            $this->MULTICELL(15,3,$capaian." %",'LR','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+145,$y);
            $this->MULTICELL(20,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+145,$y+4);
            $this->MULTICELL(20,5,number_format($k['basic_bk'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+145,$y+10);
            $this->MULTICELL(20,5,"TPP KE-13 (50%)",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+145,$y+14);            
            $this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(20,5,number_format($k['real_bk'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+165,$y);
            $this->MULTICELL(20,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+165,$y+4);
            $this->MULTICELL(20,5,number_format($k['basic_pk'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+165,$y+10);
            $this->MULTICELL(20,5,"TPP KE-13 (50%)",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+165,$y+14);                        
            $this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(20,5,number_format($k['real_pk'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+185,$y);
            $this->MULTICELL(20,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+185,$y+4);
            $this->MULTICELL(20,5,number_format($k['basic_kk'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+185,$y+10);
            $this->MULTICELL(20,5,"TPP KE-13 (50%)",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+185,$y+14);
            $this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(20,5,number_format($k['real_kk'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);        

            $this->setFont('arial','',6);
            $this->setXY($x+205,$y);
            $this->MULTICELL(20,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+205,$y+4);
            $this->MULTICELL(20,5,number_format($k['basic_kp'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+205,$y+10);
            $this->MULTICELL(20,5,"TPP KE-13 (50%)",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+205,$y+14);
            $this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(20,5,number_format($k['real_kp'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

	    $tot_basic = $k['basic_bk'] + $k['basic_pk'] + $k['basic_kk'] + $k['basic_kp'];	    
	    $tot_real = $k['real_bk'] + $k['real_pk'] + $k['real_kk'] + $k['real_kp'];

            $this->setFont('arial','',6);
            $this->setXY($x+225,$y);
            $this->MULTICELL(20,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+225,$y+4);
            $this->MULTICELL(20,5,number_format($tot_basic,0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+225,$y+10);
            $this->MULTICELL(20,5,"TPP KE-13 (50%)",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+225,$y+14);
            $this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(20,5,number_format($tot_real,0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',8);
            $this->setXY($x+245,$y+1);
            //$this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(25,3,number_format($k['jml_bpjs'],0,",","."),'','R',1);
            //$this->setTextColor(0,0,0);
	    //$this->setFont('arial','',7);

	
	    $this->setXY($x+245,$y+4);
            $this->MULTICELL(25,3,number_format($tot_real + $k['jml_bpjs'],0,",","."),'','R',1);
            $this->setXY($x+245,$y+7);
            $this->MULTICELL(25,3,"(".number_format($k['jml_pph'],0,",",".").")",'','R',1);
            $this->setXY($x+245,$y+10);
            $this->MULTICELL(25,3,"(".number_format($k['jml_iwp'],0,",",".").")",'','R',1);
            $this->setXY($x+245,$y+13);
            $this->MULTICELL(25,3,"(".number_format($k['jml_bpjs'],0,",",".").")",'','R',1);
            $this->setXY($x+245,$y+16);
            $this->setFont('arial','B',8);
            //$this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(25,3,number_format($k['tpp_diterima'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',5);
            $this->setXY($x+270,$y+16);
            if ($jnsasn == "PNS") {
                $this->MULTICELL(30,2,$mpeg->mpegawai->getnama($k['nip']),'','C',1);
            } else if ($jnsasn == "PPPK") {
                $this->MULTICELL(30,2,$mpppk->mpppk->getnama($k['nip']),'','C',1);
            }
            $this->setFont('arial','',9);

            // ISI DATA DISINI

            // garis vertikal            
            $this->Line($x,$y,$x,$y+20);
            $this->Line($x+10,$y,$x+10,$y+20);
            $this->Line($x+60,$y,$x+60,$y+20);
            $this->Line($x+130,$y,$x+130,$y+20);
            $this->Line($x+145,$y,$x+145,$y+20);
            $this->Line($x+165,$y,$x+165,$y+20);
            $this->Line($x+185,$y,$x+185,$y+20);
            $this->Line($x+205,$y,$x+205,$y+20);
            $this->Line($x+225,$y,$x+225,$y+20);
            $this->Line($x+245,$y,$x+245,$y+20);
            $this->Line($x+270,$y,$x+270,$y+20);
            $this->Line($x+300,$y,$x+300,$y+20);
            
            // garis horizontal
            $this->Line($x,$y,$x+300,$y);
            $this->Line($x,$y+20,$x+300,$y+20);

            $y=$y+20;
            $no=$no+1;
            $maxline=$maxline+1;
        }      
	
        $this->setFont('arial','',9);
        $maxline1=$maxline % 5;
        $maxline2=$maxline % 6;
        $maxline3=$maxline % 7; 
        $maxline4=$maxline % 8;          
        // untuk mengatur halaman trekapitulasi (halaman terakhir) supaya tidak berantakan pada beberapa halaman terakhir  
        if (($maxline1 == 0) OR ($maxline2 == 0) OR ($maxline3 == 0) OR ($maxline4 == 0)) {
            $this->AddPage(); 
	    //$this->lasthal = "Y";
            $this->setFont('Arial','',10);
            $this->setFillColor(255,255,255);
            $this->multicell(20,3,'',0,'C',0);
            $this->Image('assets/logo.jpg', 20, 20,'10','12','jpeg');
            $this->setXY(32,20);
            $jnsasn = $mtppng->mtppng->get_jnsasn($k['fid_pengantar']);
            if ($jnsasn == "PNS") {
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1);
            } else if ($jnsasn == "PPPK") {
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK',0,'L',1);
            } 
            $this->setXY(32,24);
            $this->multicell(200,5,$mun->munker->getnamaunker($k['fid_unker']),0,'L',1); 
            $this->setXY(32,28);
            $this->multicell(200,5,'Periode '.bulan($k['bulan']).' '.$k['tahun'],0,'L',1); 
            $y =35;
	}
        $x = 20;
        $y = $y;

	$this->lasthal = "Y";
        $this->setFont('arial','',9);
        $this->setXY($x,$y); $this->MULTICELL(300,30,"",'1','C',1);
        $this->setXY($x+10,$y+1); $this->MULTICELL(45,4,"Jumlah ASN",'','L',1);
        $this->setXY($x+55,$y+1); $this->MULTICELL(20,4,": ".$mtppng->mtppng->get_jmlperpengantar($k['fid_pengantar']),'','L',1);        
        $this->setXY($x+10,$y+5); $this->MULTICELL(45,4,"Rata-Rata Produktifitas Kerja",'','L',1);        
        $this->setXY($x+55,$y+5); $this->MULTICELL(20,4,": ".round($mtppng->mtppng->getratakinerja_perbulan($k['fid_pengantar']),2),'','L',1);
        $this->setXY($x+10,$y+9); $this->MULTICELL(45,4,"Rata-Rata Disiplin Kerja",'','L',1);
        $this->setXY($x+55,$y+9); $this->MULTICELL(20,4,": ".round($mtppng->mtppng->getrataabsensi_perbulan($k['fid_pengantar']),2),'','L',1);

	$totbk = round($mtppng->mtppng->gettotalbk_perbulan($k['fid_pengantar']));
	$totpk = round($mtppng->mtppng->gettotalpk_perbulan($k['fid_pengantar']));
	$totkk = round($mtppng->mtppng->gettotalkk_perbulan($k['fid_pengantar']));
	$totkp = round($mtppng->mtppng->gettotalkp_perbulan($k['fid_pengantar']));
	$tottunjbpjs = round($mtppng->mtppng->gettotalbpjs_perbulan($k['fid_pengantar']));
	$totbeban = $totbk + $totpk + $totkk + $totkp + $tottunjbpjs; 

        $this->setXY($x+80,$y+1); $this->MULTICELL(35,4,"Beban Kerja",'','L',1);
        $this->setXY($x+115,$y+1); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+1); $this->MULTICELL(25,4,number_format($totbk,0,",","."),'','R',1);
        $this->setXY($x+80,$y+5); $this->MULTICELL(35,4,"Prestasi Kerja",'','L',1);
        $this->setXY($x+115,$y+5); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+5); $this->MULTICELL(25,4,number_format($totpk,0,",","."),'','R',1);
        $this->setXY($x+80,$y+9); $this->MULTICELL(35,4,"Kondisi Kerja",'','L',1);
        $this->setXY($x+115,$y+9); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+9); $this->MULTICELL(25,4,number_format($totkk,0,",","."),'','R',1);
        $this->setXY($x+80,$y+13); $this->MULTICELL(35,4,"Kelangkaan Profesi",'','L',1);
        $this->setXY($x+115,$y+13); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+13); $this->MULTICELL(25,4,number_format($totkp,0,",","."),'','R',1);
	$this->setXY($x+80,$y+17); $this->MULTICELL(35,4,"Tunj. BPJS 4%",'','L',1);
	$this->setXY($x+115,$y+17); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+17); $this->MULTICELL(25,4,number_format($tottunjbpjs,0,",","."),'','R',1);
	$this->setFont('arial','B',9);        
	$this->setXY($x+80,$y+21); $this->MULTICELL(40,4,"Beban Pembayaran",'','L',1);
        $this->setXY($x+115,$y+21); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+21); $this->MULTICELL(25,4,number_format($totbeban,0,",","."),'','R',1);
	$this->setFont('arial','',9);

        //$this->setXY($x+160,$y+1); $this->MULTICELL(35,5,"Total Bruto",'','L',1);
        //$this->setXY($x+185,$y+1); $this->MULTICELL(10,5,": Rp.",'','C',1);
        //$this->setXY($x+195,$y+1); $this->MULTICELL(20,5,number_format($mtppng->mtppng->gettotalreal_perbulan($k['fid_pengantar']),0,",","."),'','R',1);
        
	$totpph = round($mtppng->mtppng->gettotalpph_perbulan($k['fid_pengantar']));
	$totiwp = round($mtppng->mtppng->gettotaliwp_perbulan($k['fid_pengantar']));
	$totbpjs = round($mtppng->mtppng->gettotalbpjs_perbulan($k['fid_pengantar']));
	$totpot = $totpph + $totiwp + $totbpjs;
	$this->setXY($x+160,$y+9); $this->MULTICELL(35,4,"Pot. PPh 21",'','L',1);
        $this->setXY($x+195,$y+9); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+9); $this->MULTICELL(20,4,number_format($totpph,0,",","."),'','R',1);
        $this->setXY($x+160,$y+13); $this->MULTICELL(35,4,"Pot. IWP 1 %",'','L',1);
        $this->setXY($x+195,$y+13); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+13); $this->MULTICELL(20,4,number_format($totiwp,0,",","."),'','R',1);
        $this->setXY($x+160,$y+17); $this->MULTICELL(35,4,"Pot. BPJS 4 %",'','L',1);
        $this->setXY($x+195,$y+17); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+17); $this->MULTICELL(20,4,number_format($totbpjs,0,",","."),'','R',1);
	$this->setFont('arial','B',9);
	$this->setXY($x+160,$y+21); $this->MULTICELL(35,4,"Jumlah Potongan",'','L',1);
        $this->setXY($x+195,$y+21); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+21); $this->MULTICELL(20,4,number_format($totpot,0,",","."),'','R',1);        
	$this->setFont('arial','',9);

	$totthp = round($mtppng->mtppng->gettotalthp_perbulan($k['fid_pengantar']));
        $this->setFont('arial','B',9);
        $this->setXY($x+225,$y+21); $this->MULTICELL(35,4,"Total TPP NETTO",'','R',1);
        $this->setXY($x+260,$y+21); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+270,$y+21); $this->MULTICELL(20,4,number_format($totthp,0,",","."),'','R',1);

        $this->setFont('arial','',8);
        $nipver = $mpeg->session->userdata('nip');
        $nmver = $mpeg->mpegawai->getnama($nipver);
        $this->setXY($x+5,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR SKPD,",'','C',1);
        $this->setXY($x+5,$y+40); $this->MULTICELL(55,4,"PENGELOLA KEPEGAWAIAN",'','C',1);
        $this->setXY($x+5,$y+60); $this->MULTICELL(55,5,$nmver,'','C',1);
        $this->setXY($x+5,$y+65); $this->MULTICELL(55,4,"NIP. ".$nipver,'','C',1);

        //$this->setXY($x+75,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR BKPPD,",'','C',1);        
        //$this->setXY($x+75,$y+59); $this->MULTICELL(55,4,"ARSWENDI ARRISDHIRA, S.Kom",'','C',1);       
        //$this->setXY($x+75,$y+63); $this->MULTICELL(55,4,"NIP. 198104072009041002",'T','C',1);

        // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
        $qrcode = $mtppng->mtppng->getqrcode($k['fid_pengantar']);
        $this->Image('assets/qrcodetppng/'.$qrcode.'.png', $x+100,$y+35,'30','30','png');

        $nipbend = $mtppng->mtppng->get_nipbendahara($k['fid_pengantar']);
        $nipkep = $mtppng->mtppng->get_nipkepala($k['fid_pengantar']);
        $nmkep = $mpeg->mpegawai->getnama($nipkep);
        $nmbend = $mpeg->mpegawai->getnama($nipbend);

        $this->setXY($x+170,$y+36); $this->MULTICELL(55,5,"BENDAHARA PENGELUARAN,",'','C',1);
        $this->setXY($x+170,$y+60); $this->MULTICELL(55,5,$nmbend,'','C',1);
        $this->setXY($x+178,$y+65); $this->MULTICELL(38,4,"NIP. ".$nipbend,'','L',1);

        $this->setXY($x+240,$y+36); $this->MULTICELL(55,5,"MENGETAHUI DAN MENYETUJUI,",'','C',1);
        $this->setXY($x+240,$y+40); $this->MULTICELL(55,4,"KEPALA SKPD",'','C',1);
        $this->setXY($x+240,$y+60); $this->MULTICELL(55,5,$nmkep,'','C',1);
        $this->setXY($x+248,$y+65); $this->MULTICELL(38,4,"NIP. ".$nipkep,'','L',1);

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
		// Paraf halaman
		if ($this->lasthal == "N") {
		$this->SetFont('Arial','',6);
            	$this->setXY(290,181); $this->MULTICELL(30,4,"DIVERIFIKASI OLEH :",'1','C',1);
		$this->setXY(290,185); $this->MULTICELL(15,4,"OPERATOR",'LTR','C',1);
		$this->setXY(305,185); $this->MULTICELL(15,4,"KA. SKPD",'LTR','C',1);
		$this->setXY(290,189); $this->MULTICELL(15,15,"",'LBR','C',1);
		$this->setXY(305,189); $this->MULTICELL(15,15,"",'LBR','C',1);
		}

		//atur posisi 1.5 cm dari bawah
		$this->SetY(-10);
        	$this->SetX(20);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),320,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',7);
        	$this->Cell(0,5,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan ' . date('Y'),0,0,'L');
		//nomor halaman
		$this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
 
$pdf = new PDF('L', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('Tanda Terima TPP KE-13 2023.pdf', 'I');

