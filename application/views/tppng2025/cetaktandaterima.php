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
		$this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .date('d F Y, h:i:s A'),0,1,'R',1);
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
        $mtppng = new Mtppng2025();
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
        $this->MULTICELL(15,2.5,'PENILAIAN KINERJA','LR','R',1);
        $this->setXY($x+130,$y+8);
        $this->MULTICELL(15,2.5,'DISIPLIN KERJA','LR','R',1);
        $this->setXY($x+130,$y+16);
        $this->MULTICELL(15,2.5,'CAPAIAN','LR','R',1);
        
	$this->setFont('arial','B',8);
        $this->setXY($x+145,$y);
        $this->MULTICELL(90,10,'KRITERIA','LRT','C',1);
        $this->setXY($x+145,$y+10);
        $this->MULTICELL(18,5,'BEBAN KERJA','LRT','C',1);
        $this->setXY($x+163,$y+10);
        $this->MULTICELL(18,5,'PRESTASI KERJA','LRT','C',1);
        $this->setXY($x+181,$y+10);
        $this->MULTICELL(18,5,'KONDISI KERJA','LRT','C',1);
	$this->setFont('arial','B',7);
        $this->setXY($x+199,$y+10);
        $this->MULTICELL(18,3.34,'KELANG KAAN PROFESI','LRT','C',1);
	$this->setFont('arial','B',8);
        $this->setXY($x+217,$y+10);
        $this->MULTICELL(18,10,'TOTAL','LRT','C',1);

        $this->setFont('arial','B',7);
        $this->setXY($x+235,$y);
        $this->MULTICELL(20,4,'Tunj. BPJS 4%','LRT','R',1);
        $this->setXY($x+235,$y+4);
        $this->MULTICELL(20,3,'Tunj. PPh 21','LR','R',1);
        $this->setXY($x+235,$y+7);
        $this->MULTICELL(20,3,'TOTAL TUNJ.','LR','R',1);
        $this->setXY($x+235,$y+10);
        $this->MULTICELL(20,3,'','LR','R',1);
        $this->setXY($x+235,$y+13);
        $this->MULTICELL(20,3,'','LR','R',1);
        $this->setXY($x+235,$y+16);
        $this->MULTICELL(20,4,'TPP BRUTO','LR','R',1);

	$this->setFont('arial','B',7);	
        $this->setXY($x+255,$y);
        $this->MULTICELL(20,4,'Pot. PPh 21','LRT','R',1);
	$this->setXY($x+255,$y+4);
        $this->MULTICELL(20,3,'Pot. IWP 1%','LR','R',1);
        $this->setXY($x+255,$y+7);
        $this->MULTICELL(20,3,'Pot. BPJS 4%','LR','R',1);
        $this->setXY($x+255,$y+10);
        $this->MULTICELL(20,3,'TOTAL POT.','LR','R',1);    
        $this->setXY($x+255,$y+13);
        $this->MULTICELL(20,3,'','LR','R',1);
        $this->setXY($x+255,$y+16);
        $this->MULTICELL(20,4,'TPP NETO','LR','R',1);

        $this->setXY($x+275,$y);
        $this->MULTICELL(25,20,'TANDA TANGAN','LRT','C',1);

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
                $jnsasn = $mtppng->mtppng2025->get_jnsasn($k['fid_pengantar']);
                if ($jnsasn == "PNS") {
                    $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1);
                } else if ($jnsasn == "PPPK") {
                    $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK',0,'L',1);
                } 
                $this->setXY(32,24);
                $this->multicell(200,5,$mun->munker->getnamaunker($k['fid_unker']),0,'L',1);
                $this->setXY(32,28);
                $this->multicell(200,5,'PERIODE '.strtoupper(bulan($k['bulan'])).' '.$k['tahun'],0,'L',1); 
		
                //$this->SetFont('Arial','B',50);
                //$this->SetTextColor(255,222,233);
                //$this->Text(200, 30, "DRAFT DEMO");
                //$this->SetTextColor(0,0,0);

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
                $jnsasn = $mtppng->mtppng2025->get_jnsasn($k['fid_pengantar']);
                if ($jnsasn == "PNS") {
                    $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1);
                } else if ($jnsasn == "PPPK") {
                    $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PPPK',0,'L',1);
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
                $this->MULTICELL(70,20,'INFORMASI JABATAN','LTR','L',1);
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
                $this->MULTICELL(90,10,'KRITERIA','LRT','C',1);
                $this->setXY($x+145,$y1+10);
                $this->MULTICELL(18,5,'BEBAN KERJA','LRT','C',1);
                $this->setXY($x+163,$y1+10);
                $this->MULTICELL(18,5,'PRESTASI KERJA','LRT','C',1);
                $this->setXY($x+181,$y1+10);
                $this->MULTICELL(18,5,'KONDISI KERJA','LRT','C',1);
                $this->setFont('arial','B',7);
		$this->setXY($x+199,$y1+10);
                $this->MULTICELL(18,3.34,'KELANG KAAN PROFESI','LRT','C',1);
		$this->setFont('arial','B',8);
                $this->setXY($x+217,$y1+10);
                $this->MULTICELL(18,10,'TOTAL','LRT','C',1);

		$this->setFont('arial','B',7);
        	$this->setXY($x+235,$y1);
        	$this->MULTICELL(20,4,'Tunj. BPJS 4%','LRT','R',1);
        	$this->setXY($x+235,$y1+4);
        	$this->MULTICELL(20,3,'Tunj. PPh 21','LR','R',1);
        	$this->setXY($x+235,$y1+7);
        	$this->MULTICELL(20,3,'TOTAL TUNJ.','LR','R',1);
        	$this->setXY($x+235,$y1+10);
        	$this->MULTICELL(20,3,'','LR','R',1);
        	$this->setXY($x+235,$y1+13);
        	$this->MULTICELL(20,3,'','LR','R',1);
        	$this->setXY($x+235,$y1+16);
	        $this->MULTICELL(20,4,'TPP BRUTO','LR','R',1);

		$this->setFont('arial','B',7);
                $this->setXY($x+255,$y1);
                $this->MULTICELL(20,4,'Pot. PPh 21','LRT','R',1);
		$this->setXY($x+255,$y1+4);
                $this->MULTICELL(20,3,'Pot. IWP 1%','LR','R',1);
                $this->setXY($x+255,$y1+7);
                $this->MULTICELL(20,3,'Pot. BPJS 4%','LR','R',1);
                $this->setXY($x+255,$y1+10);
                $this->MULTICELL(20,3,'TOTAL POT.','LR','R',1);    
                $this->setXY($x+255,$y1+13);
                $this->MULTICELL(20,3,'','LR','R',1);
                $this->setXY($x+255,$y1+16);
                $this->MULTICELL(20,4,'TPP NETO','LR','R',1);

                $this->setXY($x+275,$y1);
                $this->MULTICELL(25,20,'TANDA TANGAN','LRT','C',1);
		$this->setFont('arial','',8);
                $maxline=$maxline+1;
            }
           
            $this->setFillColor(255,255,255);
            $this->setFont('arial','',7);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $jnsasn = $mtppng->mtppng2025->get_jnsasn($k['fid_pengantar']);
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
            $this->setFont('arial','',6);
            $this->setXY($x+130,$y+1);
            //$this->MULTICELL(15,2.5,"Kin. ". $k['nilai_produktifitas'],'LR','R',1);
	    $this->MULTICELL(15,2,$k['capaian_produktifitas'],'LR','R',1);
            $this->setXY($x+130,$y+5);
	    $this->setFont('arial','',8);
            $this->setTextColor(65, 105, 225); //RoyalBlue
            $this->MULTICELL(15,3,$k['persen_produktifitas']." %",'LR','R',1);
            $this->setTextColor(0,0,0);
            $this->setXY($x+130,$y+9);
	    $this->setFont('arial','',7);	
            $this->MULTICELL(15,2.5,"ABS : ". $k['nilai_disiplin'],'LR','R',1);
            $this->setXY($x+130,$y+11.5);
            $this->setTextColor(65, 105, 225); //RoyalBlue
	    $this->setFont('arial','',8);
            $this->MULTICELL(15,3,$k['persen_disiplin']." %",'LR','R',1);
	    $this->setXY($x+130,$y+16);
	    $capaian = $k['persen_produktifitas'] + $k['persen_disiplin'];
	    $this->setFont('arial','B',8);            
            $this->MULTICELL(15,3,$capaian." %",'LR','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+145,$y);
            $this->MULTICELL(18,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+145,$y+4);
            $this->MULTICELL(18,5,number_format($k['basic_bk'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+145,$y+10);
            $this->MULTICELL(18,5,"REALISASI",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+145,$y+14);
            $this->setTextColor(255, 140, 0); //DarkOrange
            $this->MULTICELL(18,5,number_format($k['real_bk'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+163,$y);
            $this->MULTICELL(18,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+163,$y+4);
            $this->MULTICELL(18,5,number_format($k['basic_pk'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+163,$y+10);
            $this->MULTICELL(18,5,"REALISASI",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+163,$y+14);
            $this->setTextColor(255, 140, 0); //DarkOrange
            $this->MULTICELL(18,5,number_format($k['real_pk'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+181,$y);
            $this->MULTICELL(18,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+181,$y+4);
            $this->MULTICELL(18,5,number_format($k['basic_kk'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+181,$y+10);
            $this->MULTICELL(18,5,"REALISASI",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+181,$y+14);
            $this->setTextColor(255, 140, 0); //DarkOrange
            $this->MULTICELL(18,5,number_format($k['real_kk'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);        

            $this->setFont('arial','',6);
            $this->setXY($x+199,$y);
            $this->MULTICELL(18,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+199,$y+4);
            $this->MULTICELL(18,5,number_format($k['basic_kp'],0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+199,$y+10);
            $this->MULTICELL(18,5,"REALISASI",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+199,$y+14);
            $this->setTextColor(255, 140, 0); //DarkOrange
            $this->MULTICELL(18,5,number_format($k['real_kp'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

	    $tot_basic = $k['basic_bk'] + $k['basic_pk'] + $k['basic_kk'] + $k['basic_kp'];	    
	    $tot_real = $k['real_bk'] + $k['real_pk'] + $k['real_kk'] + $k['real_kp'];

            $this->setFont('arial','',6);
            $this->setXY($x+217,$y);
            $this->MULTICELL(18,5,"BASIC",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+217,$y+4);
            $this->MULTICELL(18,5,number_format($tot_basic,0,",","."),'','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+217,$y+10);
            $this->MULTICELL(18,5,"REALISASI",'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+217,$y+14);
            $this->setTextColor(255, 140, 0); //DarkOrange
            $this->MULTICELL(18,5,number_format($tot_real,0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',8);
            $this->setXY($x+235,$y+1);
            //$this->setTextColor(60, 179, 113); //MediumSeaGreen
            $this->MULTICELL(20,3,number_format($k['jml_bpjs'],0,",","."),'','R',1);
	    $this->setXY($x+235,$y+4);
            $this->MULTICELL(20,3,number_format($k['jml_pph'],0,",","."),'','R',1);
	    $this->Line($x+240,$y+7,$x+254,$y+7);
	    $this->setXY($x+235,$y+8);
            $this->setFont('arial','',8);
	    $this->setTextColor(0, 0, 0); //Green
            $this->MULTICELL(20,3,number_format($k['jml_bpjs'] + $k['jml_pph'],0,",","."),'','R',1);	
	    $this->setXY($x+235,$y+16);
	    $this->setTextColor(0, 128, 0); //Green	
	    $this->setFont('arial','',9);
            $this->MULTICELL(20,3,number_format($tot_real + $k['jml_bpjs'] + $k['jml_pph'],0,",","."),'','R',1);
	    $this->setFont('arial','',8);
            $this->setTextColor(0,0,0);
	    //$this->setFont('arial','',7);

	
            $this->setXY($x+255,$y+1);
            $this->MULTICELL(20,3,number_format($k['jml_pph'],0,",","."),'','R',1);
            $this->setXY($x+255,$y+4);
            $this->MULTICELL(20,3,number_format($k['jml_iwp'],0,",","."),'','R',1);
            $this->setXY($x+255,$y+7);
            $this->MULTICELL(20,3,number_format($k['jml_bpjs'],0,",","."),'','R',1);
	    $this->Line($x+260,$y+10,$x+274,$y+10);
	    $this->setXY($x+255,$y+10.5);	
	    $this->setFont('arial','',8);
	    $this->setTextColor(255, 0, 0); //Red
            $this->MULTICELL(20,3,"(".number_format($k['jml_pph'] + $k['jml_iwp'] + $k['jml_bpjs'],0,",",".").")",'','R',1);
            $this->setXY($x+255,$y+16);
	    $this->setFont('arial','B',9);
	    $this->setTextColor(65, 105, 225); //RoyalBlue	
            $this->MULTICELL(20,3,number_format($k['tpp_diterima'],0,",","."),'','R',1);
            $this->setTextColor(0,0,0);

            $this->setFont('arial','',6);
            $this->setXY($x+275,$y+15);
            if ($jnsasn == "PNS") {
                $this->MULTICELL(25,2,$mpeg->mpegawai->getnama($k['nip']),'','C',1);
            } else if ($jnsasn == "PPPK") {
                $this->MULTICELL(25,2,$mpppk->mpppk->getnama($k['nip']),'','C',1);
            }
            $this->setFont('arial','',9);

            // ISI DATA DISINI

            // garis vertikal            
            $this->Line($x,$y,$x,$y+20);
            $this->Line($x+10,$y,$x+10,$y+20);
            $this->Line($x+60,$y,$x+60,$y+20);
            $this->Line($x+130,$y,$x+130,$y+20);
            $this->Line($x+145,$y,$x+145,$y+20);
            $this->Line($x+163,$y,$x+163,$y+20);
            $this->Line($x+181,$y,$x+181,$y+20);
            $this->Line($x+199,$y,$x+199,$y+20);
            $this->Line($x+217,$y,$x+217,$y+20);
            $this->Line($x+235,$y,$x+235,$y+20);
            $this->Line($x+255,$y,$x+255,$y+20);;
            $this->Line($x+275,$y,$x+275,$y+20);
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
            $this->setFont('Arial','',10);
            $this->setFillColor(255,255,255);
            $this->multicell(20,3,'',0,'C',0);
            $this->Image('assets/logo.jpg', 20, 20,'10','12','jpeg');
            $this->setXY(32,20);
            $jnsasn = $mtppng->mtppng2025->get_jnsasn($k['fid_pengantar']);
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
        $this->setXY($x+55,$y+1); $this->MULTICELL(20,4,": ".$mtppng->mtppng2025->get_jmlperpengantar($k['fid_pengantar']),'','L',1);        
        $this->setXY($x+10,$y+5); $this->MULTICELL(45,4,"Rata-Rata Produktifitas Kerja",'','L',1);        
        $this->setXY($x+55,$y+5); $this->MULTICELL(20,4,": ".round($mtppng->mtppng2025->getratakinerja_perbulan($k['fid_pengantar']),2),'','L',1);
        $this->setXY($x+10,$y+9); $this->MULTICELL(45,4,"Rata-Rata Disiplin Kerja",'','L',1);
        $this->setXY($x+55,$y+9); $this->MULTICELL(20,4,": ".round($mtppng->mtppng2025->getrataabsensi_perbulan($k['fid_pengantar']),2),'','L',1);

	$totbk = round($mtppng->mtppng2025->gettotalbk_perbulan($k['fid_pengantar']));
	$totpk = round($mtppng->mtppng2025->gettotalpk_perbulan($k['fid_pengantar']));
	$totkk = round($mtppng->mtppng2025->gettotalkk_perbulan($k['fid_pengantar']));
	$totkp = round($mtppng->mtppng2025->gettotalkp_perbulan($k['fid_pengantar']));
	$tottunjbpjs = round($mtppng->mtppng2025->gettotalbpjs_perbulan($k['fid_pengantar']));
	$tottunjpph = round($mtppng->mtppng2025->gettotalpph_perbulan($k['fid_pengantar']));
	$totbeban = $totbk + $totpk + $totkk + $totkp + $tottunjbpjs + $tottunjpph; 

	$this->setXY($x+80,$y+1); $this->MULTICELL(35,4,"REALISASI KRITERIA",'','L',1);
        $this->setXY($x+80,$y+5); $this->MULTICELL(35,4,"Beban Kerja",'','L',1);
        $this->setXY($x+115,$y+5); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+5); $this->MULTICELL(25,4,number_format($totbk,0,",","."),'','R',1);
        $this->setXY($x+80,$y+9); $this->MULTICELL(35,4,"Prestasi Kerja",'','L',1);
        $this->setXY($x+115,$y+9); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+9); $this->MULTICELL(25,4,number_format($totpk,0,",","."),'','R',1);
        $this->setXY($x+80,$y+13); $this->MULTICELL(35,4,"Kondisi Kerja",'','L',1);
        $this->setXY($x+115,$y+13); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+13); $this->MULTICELL(25,4,number_format($totkk,0,",","."),'','R',1);
        $this->setXY($x+80,$y+17); $this->MULTICELL(35,4,"Kelangkaan Profesi",'','L',1);
        $this->setXY($x+115,$y+17); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+125,$y+17); $this->MULTICELL(25,4,number_format($totkp,0,",","."),'','R',1);
	//$this->setFont('arial','B',9);        
	//$this->setXY($x+80,$y+25); $this->MULTICELL(40,4,"Beban Pembayaran",'','L',1);
        //$this->setXY($x+115,$y+25); $this->MULTICELL(10,4,": Rp.",'','C',1);
        //$this->setXY($x+125,$y+25); $this->MULTICELL(25,4,number_format($totbeban,0,",","."),'','R',1);
	//$this->setFont('arial','',9);

        //$this->setXY($x+160,$y+1); $this->MULTICELL(35,5,"Total Bruto",'','L',1);
        //$this->setXY($x+185,$y+1); $this->MULTICELL(10,5,": Rp.",'','C',1);
        //$this->setXY($x+195,$y+1); $this->MULTICELL(20,5,number_format($mtppng->mtppng2025->gettotalreal_perbulan($k['fid_pengantar']),0,",","."),'','R',1);
        
	$this->setXY($x+160,$y+1); $this->MULTICELL(35,4,"Tunj. PPh 21",'','L',1);
        $this->setXY($x+195,$y+1); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+1); $this->MULTICELL(20,4,number_format($tottunjpph,0,",","."),'','R',1);
        $this->setXY($x+160,$y+5); $this->MULTICELL(35,4,"Tunj. BPJS 4%",'','L',1);
        $this->setXY($x+195,$y+5); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+5); $this->MULTICELL(20,4,number_format($tottunjbpjs,0,",","."),'','R',1);

	$totpph = round($mtppng->mtppng2025->gettotalpph_perbulan($k['fid_pengantar']));
	$totiwp = round($mtppng->mtppng2025->gettotaliwp_perbulan($k['fid_pengantar']));
	$totbpjs = round($mtppng->mtppng2025->gettotalbpjs_perbulan($k['fid_pengantar']));
	$totpot = $totpph + $totiwp + $totbpjs;
	$this->setXY($x+160,$y+13); $this->MULTICELL(35,4,"Pot. PPh 21",'','L',1);
        $this->setXY($x+195,$y+13); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+13); $this->MULTICELL(20,4,number_format($totpph,0,",","."),'','R',1);
        $this->setXY($x+160,$y+17); $this->MULTICELL(35,4,"Pot. IWP 1 %",'','L',1);
        $this->setXY($x+195,$y+17); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+17); $this->MULTICELL(20,4,number_format($totiwp,0,",","."),'','R',1);
        $this->setXY($x+160,$y+21); $this->MULTICELL(35,4,"Pot. BPJS 4 %",'','L',1);
        $this->setXY($x+195,$y+21); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+205,$y+21); $this->MULTICELL(20,4,number_format($totbpjs,0,",","."),'','R',1);

	$this->setXY($x+230,$y+1); $this->MULTICELL(35,4,"Total Realisasi",'','L',1);
        $this->setXY($x+260,$y+1); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+270,$y+1); $this->MULTICELL(20,4,number_format($totbk + $totpk + $totkk + $totkp,0,",","."),'','R',1);
        $this->setXY($x+230,$y+5); $this->MULTICELL(35,4,"Total Tunjangan",'','L',1);
        $this->setXY($x+260,$y+5); $this->MULTICELL(10,4,": Rp.",'','C',1);
        $this->setXY($x+270,$y+5); $this->MULTICELL(20,4,number_format($tottunjpph + $tottunjbpjs,0,",","."),'','R',1);
	$this->Line($x+263,$y+9,$x+289,$y+9);
        $this->setXY($x+230,$y+10); $this->MULTICELL(35,4,"Beban Pembayaran",'','L',1);
        $this->setXY($x+260,$y+10); $this->MULTICELL(10,4,": Rp.",'','C',1);
	$this->setTextColor(0, 128, 0); //Green
        $this->setXY($x+270,$y+10); $this->MULTICELL(20,4,number_format($totbeban,0,",","."),'','R',1);
	$this->setTextColor(0, 0, 0);
	$this->setXY($x+230,$y+14); $this->MULTICELL(35,4,"(Total Potongan)",'','L',1);
        $this->setXY($x+260,$y+14); $this->MULTICELL(10,4,": Rp.",'','C',1);
	$this->setTextColor(255, 0, 0); //Red
        $this->setXY($x+270,$y+14); $this->MULTICELL(21,4,"(".number_format($totpot,0,",",".").")",'','R',1);
	$this->setTextColor(0, 0, 0);

	$totthp = round($mtppng->mtppng2025->gettotalthp_perbulan($k['fid_pengantar']));
        $this->setFont('arial','B',9);
        $this->Line($x+263,$y+18,$x+289,$y+18);
        $this->setXY($x+230,$y+20); $this->MULTICELL(35,4,"TPP NETO",'','L',1);
        $this->setXY($x+260,$y+20); $this->MULTICELL(10,4,": Rp.",'','C',1);
	$this->setTextColor(65, 105, 225); //RoyalBlue
        $this->setXY($x+270,$y+20); $this->MULTICELL(20,4,number_format($totthp,0,",","."),'','R',1);
	$this->setTextColor(0, 0, 0);

        $this->setFont('arial','',8);
        $nipver = $mpeg->session->userdata('nip');
        $nmver = $mpeg->mpegawai->getnama($nipver);
        $this->setXY($x+5,$y+36); $this->MULTICELL(55,4,"OPERATOR SILKa,",'','C',1);
        $this->setXY($x+5,$y+40); $this->MULTICELL(55,4,"PENGELOLA KEPEGAWAIAN",'','C',1);
        //$this->setXY($x+5,$y+60); $this->MULTICELL(55,5,'BARKATULLAH AMIN, S.Sos','','C',1);
        //$this->setXY($x+5,$y+65); $this->MULTICELL(55,4,"NIP. 198309042007011001",'','C',1);
	$this->setXY($x+5,$y+60); $this->MULTICELL(55,5,$nmver,'','C',1);
        $this->setXY($x+5,$y+65); $this->MULTICELL(55,4,"NIP. ".$nipver,'','C',1);

        //$this->setXY($x+75,$y+36); $this->MULTICELL(55,4,"VERIFIKATOR BKPPD,",'','C',1);        
        //$this->setXY($x+75,$y+59); $this->MULTICELL(55,4,"ARSWENDI ARRISDHIRA, S.Kom",'','C',1);       
        //$this->setXY($x+75,$y+63); $this->MULTICELL(55,4,"NIP. 198104072009041002",'T','C',1);

        // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
        $qrcode = $mtppng->mtppng2025->getqrcode($k['fid_pengantar']);
        $this->Image('assets/qrcodetppng2025/'.$qrcode.'.png', $x+100,$y+35,'30','30','png');

        $nipbend = $mtppng->mtppng2025->get_nipbendahara($k['fid_pengantar']);
        $nipkep = $mtppng->mtppng2025->get_nipkepala($k['fid_pengantar']);
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
$pdf->Output('Tanda Terima TPPNG.pdf', 'I');

