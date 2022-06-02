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
        $this->MULTICELL(10,10,'NO.','LRT','C',1); 
	$this->setXY($x+10,$y);
        $this->MULTICELL(95,10,'UNIT KERJA','LRT','C',1);
        $this->setXY($x+105,$y);
        $this->MULTICELL(20,10,'RATA-RATA','LTR','C',1);
        $this->setXY($x+125,$y);
        $this->MULTICELL(15,10,'JML PNS','LTR','C',1);
        $this->setXY($x+140,$y);
        $this->MULTICELL(30,5,'TOTAL TPP SESUAI REALISASI','LRT','C',1);
        $this->setXY($x+170,$y);
        $this->MULTICELL(30,10,'TOTAL TAMBAHAN','LRT','C',1);
        $this->setXY($x+200,$y);
        $this->MULTICELL(30,5,'TOTAL TPP + TAMBAHAN','LRT','C',1);
        $this->setXY($x+230,$y);
        $this->MULTICELL(30,10,'TOTAL PAJAK','LTR','C',1);
        $this->setXY($x+260,$y);
        $this->MULTICELL(30,10,'TPP DIBAYARKAN','LTR','C',1);

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 45;
        $kurangdari50 = 1;
        $no = 1;        
        $maxline=1;
	
	$totpns = 0;
        $tottppkotor = 0;
        $tottambahan = 0;
        $tottpp_sebelumpajak = 0;
        $totpajak = 0;
        $tottpp_dibayar = 0;

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
                $this->multicell(200,5,'Periode '.bulan($k->bulan).' '.$k->tahun,0,'L',1); 
            }

           
            $maxline=$maxline % 15;            
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 35;
                $y = 45;
                //$this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'REKAPITULASI TAMBAHAN PENGHASILAN PNS',0,'L',1); 
                $this->setXY(30,24);
                $this->multicell(200,5,'Periode '.bulan($k->bulan).' '.$k->tahun,0,'L',1);                 

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,10,'NO.','LRT','C',1); 
		$this->setXY($x+10,$y1);
                $this->MULTICELL(95,10,'UNIT KERJA','LRT','C',1);
                $this->setXY($x+105,$y1);
                $this->MULTICELL(20,10,'RATA-RATA','LTR','C',1);
                $this->setXY($x+125,$y1);
                $this->MULTICELL(15,10,'JML PNS','LTR','C',1);
                $this->setXY($x+140,$y1);
                $this->MULTICELL(30,5,'TOTAL TPP SESUAI REALISASI','LRT','C',1);
                $this->setXY($x+170,$y1);
                $this->MULTICELL(30,10,'TOTAL TAMBAHAN','LRT','C',1);
                $this->setXY($x+200,$y1);
                $this->MULTICELL(30,5,'TOTAL TPP + TAMBAHAN','LRT','C',1);
                $this->setXY($x+230,$y1);
                $this->MULTICELL(30,10,'TOTAL PAJAK','LTR','C',1);
                $this->setXY($x+260,$y1);
                $this->MULTICELL(30,10,'TPP DIBAYARKAN','LTR','C',1);
                $maxline=$maxline+1;
            }
           
            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1);
            $this->setXY($x+10,$y);

	
	    $kec = $mpeg->mpegawai->getnamakecamatan($k->fid_unker);
            if (!$kec) {
                $this->MULTICELL(95,5,$mun->munker->getnamaunker($k->fid_unker),'','L',1);
            } else {
                $this->MULTICELL(95,5,"TK, SDN, SMPN SEDERAJAT KEC. ". $kec,'','L',1);
            }
                        
	    $this->setFont('arial','',8);
            $this->setXY($x+105,$y);
            $this->MULTICELL(10,5,"Kin",'L','L',1);
            $this->setXY($x+113,$y);
            $this->MULTICELL(12,5,number_format($k->rata_kinerja,2),'R','R',1);

            $this->setXY($x+105,$y+5);
            $this->MULTICELL(10,5,"Abs",'L','L',1);
            $this->setXY($x+113,$y+5);
            $this->MULTICELL(12,5,number_format($k->rata_absensi,2),'R','R',1);

	    $this->setFont('arial','',9);
	    $this->setXY($x+125,$y); 
            $this->MULTICELL(15,10,$k->totpns,'LTR','R',1);
            $this->setXY($x+140,$y);
            $this->MULTICELL(30,10,number_format($k->tottppkotor,0,",","."),'LRT','R',1);
            $this->setXY($x+170,$y);
            $this->MULTICELL(30,10,number_format($k->tottambahan,0,",","."),'LRT','R',1);
            $this->setXY($x+200,$y);
            $this->MULTICELL(30,10,number_format($k->tottpp_sebelumpajak,0,",","."),'LRT','R',1);
            $this->setXY($x+230,$y);
            $this->MULTICELL(30,10,number_format($k->totpajak,0,",","."),'LTR','R',1);
            $this->setXY($x+260,$y);
            $this->MULTICELL(30,10,number_format($k->tottpp_dibayar,0,",","."),'LTR','R',1);
           
            // garis vertikal            
            $this->Line($x,$y,$x,$y+10);
            $this->Line($x+10,$y,$x+10,$y+10);
            $this->Line($x+125,$y,$x+125,$y+10);
            $this->Line($x+140,$y,$x+140,$y+10);
            $this->Line($x+170,$y,$x+170,$y+10);
            $this->Line($x+200,$y,$x+200,$y+10);
            $this->Line($x+230,$y,$x+230,$y+10);
            $this->Line($x+260,$y,$x+260,$y+10);
            $this->Line($x+290,$y,$x+290,$y+10);

            // garis horizontal
            $this->Line($x,$y,$x+290,$y);
            $this->Line($x,$y+10,$x+290,$y+10);

            $y=$y+10;
            $no=$no+1;
            $maxline=$maxline+1;

	    $totpns = $totpns + $k->totpns;
            $tottppkotor = $tottppkotor + $k->tottppkotor;
            $tottambahan = $tottambahan + $k->tottambahan;
            $tottpp_sebelumpajak = $tottpp_sebelumpajak + $k->tottpp_sebelumpajak;
            $totpajak = $totpajak + $k->totpajak;
            $tottpp_dibayar = $tottpp_dibayar + $k->tottpp_dibayar;
        } 

	$this->setFont('arial','',9);
        $this->setXY($x,$y); 
        $this->MULTICELL(125,10,'JUMLAH','LTR','C',1);
        $this->setXY($x+125,$y); 
        $this->MULTICELL(15,10,$totpns,'LTR','R',1);
        $this->setXY($x+140,$y);
        $this->MULTICELL(30,10,"Rp. ".number_format($tottppkotor,0,",","."),'LRT','R',1);
        $this->setXY($x+170,$y);
        $this->MULTICELL(30,10,"Rp. ".number_format($tottambahan,0,",","."),'LRT','R',1);
        $this->setXY($x+200,$y);
        $this->MULTICELL(30,10,"Rp. ".number_format($tottpp_sebelumpajak,0,",","."),'LRT','R',1);
        $this->setXY($x+230,$y);
        $this->MULTICELL(30,10,"Rp. ".number_format($totpajak,0,",","."),'LTR','R',1);
        $this->setXY($x+260,$y);
        $this->MULTICELL(30,10,"Rp. ".number_format($tottpp_dibayar,0,",","."),'LTR','R',1);
        
        // garis vertikal            
        $this->Line($x,$y,$x,$y+10);
        $this->Line($x+125,$y,$x+125,$y+10);
        $this->Line($x+140,$y,$x+140,$y+10);
        $this->Line($x+170,$y,$x+170,$y+10);
        $this->Line($x+200,$y,$x+200,$y+10);
        $this->Line($x+230,$y,$x+230,$y+10);
        $this->Line($x+260,$y,$x+260,$y+10);
        $this->Line($x+290,$y,$x+290,$y+10);

            // garis horizontal
        $this->Line($x,$y,$x+290,$y);
        $this->Line($x,$y+10,$x+290,$y+10);
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
$pdf->Output('rekaptppbulanan.pdf', 'I');
