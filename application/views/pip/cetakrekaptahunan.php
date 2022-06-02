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
                //$this->cell(170,5,'Dicetak oleh '.$login->session->userdata('nama').' ('.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                $this->cell(50,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                //$this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                //atur posisi 1.5 cm dari bawah
                $this->SetY(15);
                //buat garis horizontal
                $this->Line(20,$this->GetY(),200,$this->GetY());
	}
 
	function Content($tahun)
	{
        $peg = new Mpegawai();
        $un = new Munker();
        $pip = new Mpip();        
        $graph = new Mgraph();
       
        $this->Ln(8);
        $this->setFont('Arial','',10);
        $this->setFillColor(255,255,255);
        /*
        $this->cell(20,3,'',0,0,'C',0); 
        $this->Image(base_url().'assets/logo.jpg', 20, 22,'8','10','jpeg');
        $this->cell(100,4,'REKAPITULASI INDEK PROFESIONALITAS ASN TAHUN '.$tahun,0,1,'L',1); 
        $this->cell(20,3,'',0,0,'C',0); 
        $this->cell(100,6,'PEMERINTAH DAERAH KABUPATE BALANGAN',0,1,'L',1); 
        */

        $this->setFont('arial','B',8);
        $this->setXY(20,40); $this->MULTICELL(60,20,'',1,'C',1);
        $this->setFont('arial','',10);        
        $jmldata = $pip->mpip->getjmlpertahun($tahun);
        $jmlpns = $graph->mgraph->jmlpns();
        $jmlpersen = round(($jmldata/$jmlpns)*100, 2);        
        $this->setXY(22,42); $this->CELL(30,5,'Jml PNS',0,1,'L',1);
        $this->setXY(52,42); $this->CELL(10,5,': '.$jmlpns,0,1,'L',1);
        $this->setXY(22,47); $this->CELL(30,5,'Jml Responden',0,1,'L',1);
        $this->setXY(52,47); $this->CELL(10,5,': '.$jmldata,0,1,'L',1);
        $this->setXY(22,52); $this->CELL(30,5,'Persentase',0,1,'L',1);
        $this->setXY(52,52); $this->CELL(10,5,': '.$jmlpersen.' %',0,1,'L',1);
                
        $this->setFont('arial','B',10);
        $this->setXY(85,40); $this->MULTICELL(60,20,'',1,'C',1);
        $totalpip = $pip->mpip->totalpip_thn($tahun);
        $totaldatapip = $pip->mpip->getjmlpertahun($tahun);
        $skorpip = round(($totalpip/$totaldatapip),2);
        if ($pip->mpip->getkategoriip($skorpip) == "SANGAT RENDAH") {
            $this->setFillColor(240,128,128);                
        } else if ($pip->mpip->getkategoriip($skorpip) == "RENDAH") {
            $this->setFillColor(255,239,213);                
        }         
        $this->setXY(85,40); $this->MULTICELL(60,20,'',1,1,1);
        $this->setXY(87,42); $this->CELL(10,5,'IP ASN Tahun '.$tahun,0,1,'L',1);
        $this->setFont('arial','',22); 
        $this->setXY(87,47); $this->CELL(55,5,$skorpip,0,1,'R',1);
        $this->setFont('arial','B',10);
        $kategori = $pip->mpip->getkategoriip($skorpip);
        $this->setXY(87,53); $this->CELL(55,5,'Kategori : '.$kategori,0,1,'R',1);
        $this->setFillColor(255,255,255); 
        
	$this->setFont('arial','',8);
	$this->setXY(20,65);
        $this->MULTICELL(40,10,'',1,'C',1);
        $this->setXY(21,66); $this->MULTICELL(20,4,'KUALIFIKASI (25 %)',0,'L',1);
        $totalkua = $pip->mpip->totalkua_thn($tahun);
        $totaldatapip = $pip->mpip->getjmlpertahun($tahun);
        $skorkua = round(($totalkua/$totaldatapip),2);
        $this->setFont('arial','',14);        
        $this->setXY(40,67); $this->CELL(19,5,$skorkua,0,1,'R',1);

        $this->setFont('arial','',8);
        $this->setXY(65,65);
        $this->MULTICELL(40,10,'',1,'C',1);
        $this->setXY(66,66); $this->MULTICELL(22,4,'KOMPETENSI (40 %)',0,'L',1);
        $totalkom = $pip->mpip->totalkom_thn($tahun);
        $totaldatapip = $pip->mpip->getjmlpertahun($tahun);
        $skorkom = round(($totalkom/$totaldatapip),2);
        $this->setFont('arial','',14);        
        $this->setXY(88,67); $this->CELL(16,5,$skorkom,0,1,'R',1);

        $this->setFont('arial','',8);
        $this->setXY(110,65);
        $this->MULTICELL(40,10,'',1,'C',1);
        $this->setXY(111,66); $this->MULTICELL(18,4,'KINERJA (30 %)',0,'L',1);
        $totalkin = $pip->mpip->totalkin_thn($tahun);
        $totaldatapip = $pip->mpip->getjmlpertahun($tahun);
        $skorkin = round(($totalkin/$totaldatapip),2);
        $this->setFont('arial','',14);        
        $this->setXY(130,67); $this->CELL(19,5,$skorkin,0,1,'R',1);

        $this->setFont('arial','',8);
        $this->setXY(155,65);
        $this->MULTICELL(40,10,'',1,'C',1);
        $this->setXY(156,66); $this->MULTICELL(16,4,'DISIPLIN (5 %)',0,'L',1);
        $totaldis = $pip->mpip->totaldis_thn($tahun);
        $totaldatapip = $pip->mpip->getjmlpertahun($tahun);
        $skordis = round(($totaldis/$totaldatapip),2);
        $this->setFont('arial','',14);        
        $this->setXY(175,67); $this->CELL(19,5,$skordis,0,1,'R',1);

        $x= 20;
        $y= 80;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,15,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(75,15,'UNIT KERJA','LTR','C',1);
        $this->setXY($x+85,$y);
        $this->MULTICELL(87,5,'SKOR INDIKATOR','LTR','C',1);
        $this->setXY($x+85,$y+5);
        $this->MULTICELL(20,10,'KUALIFIKASI','LTR','C',1);
        $this->setXY($x+105,$y+5);
        $this->MULTICELL(22,10,'KOMPETENSI','LTR','C',1);
        $this->setXY($x+127,$y+5);
        $this->MULTICELL(20,10,'KINERJA','LTR','C',1);
        $this->setXY($x+147,$y+5);
        $this->MULTICELL(20,10,'DISIPLIN','LTR','C',1);
        $this->setXY($x+167,$y);
        $this->MULTICELL(21,15,'NILAI','LTR','C',1);

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $sopd = $un->munker->instansi()->result_array();
        $y = 95;
        $no = 1;        
        $maxline = 1;
        $hal = 1;
        foreach ($sopd as $key) {
            
            if ($no==1) {
                $this->Ln(8);
                $this->setFont('Arial','',8);
                $this->setFillColor(255,255,255);
                $this->setXY(35,20);
                $this->Image(base_url().'assets/logo.jpg', 20, 20,'12','15','jpeg');
                $this->cell(100,4,'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA KABUPATEN BALANGAN',0,1,'L',1); 
                $this->setXY(35,26);
                $this->setFont('Arial','',10);
                $this->cell(100,4,'HASIL PENGUKURAN INDEK PROFESIONALITAS ASN TAHUN '.$tahun,0,1,'L',1); 
            	$this->setXY(35,31);
		$this->cell(100,4,'Kondisi tanggal '.tgl_indo(date('Y-m-d'))." jam ".date('H:i:s'),0,1,'L',1);
	    }            

            if ($hal == 1) {
                $maxline=$maxline % 15;                
            } else {
                $maxline=$maxline % 17;
            }

            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 40;
                $y = 55;
                $this->Ln(8);
                $this->setFont('Arial','',8);
                $this->setFillColor(255,255,255);
                $this->setXY(35,20);
                $this->Image(base_url().'assets/logo.jpg', 20, 20,'12','15','jpeg');
                $this->cell(100,4,'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA KABUPATEN BALANGAN',0,1,'L',1); 
                $this->setXY(35,25);
                $this->setFont('Arial','',10);
                $this->cell(100,4,'HASIL PENGUKURAN INDEK PROFESIONALITAS ASN TAHUN '.$tahun,0,1,'L',1);
		$this->setXY(35,30);
                $this->cell(100,4,'Kondisi tanggal '.tgl_indo(date('Y-m-d'))." jam ".date('H:i:s'),0,1,'L',1);

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,15,'NO.','LTR','C',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(75,15,'UNIT KERJA','LTR','C',1);
                $this->setXY($x+85,$y1);
                $this->MULTICELL(87,5,'SKOR INDIKATOR','LTR','C',1);
                $this->setXY($x+85,$y1+5);
                $this->MULTICELL(20,10,'KUALIFIKASI','LTR','C',1);
                $this->setXY($x+105,$y1+5);
                $this->MULTICELL(22,10,'KOMPETENSI','LTR','C',1);
                $this->setXY($x+127,$y1+5);
                $this->MULTICELL(20,10,'KINERJA','LTR','C',1);
                $this->setXY($x+147,$y1+5);
                $this->MULTICELL(20,10,'DISIPLIN','LTR','C',1);
                $this->setXY($x+167,$y1);
                $this->MULTICELL(21,15,'NILAI','LTR','C',1);   

                $maxline=$maxline+1;
                $hal = $hal + 1;
            }           

            $totalpeg = $un->munker->getjmlpeg_instansi($key['id_instansi']);
	if ($totalpeg != 0) {
            $jmlpegpip = $pip->mpip->jmldatapip_insthn($key['id_instansi'], $tahun);                  
            if ($totalpeg != 0) {
                $persenpegpip = round(($jmlpegpip/$totalpeg)*100);
            }

            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,15,$no.'.','1','C',1);             
            $this->setFont('arial','',8);
            $this->setXY($x+10,$y); $this->MULTICELL(75,3.6,$key['nama_instansi'],'LTR','l',1);
            $this->setFont('arial','',8);
	    if ($persenpegpip < 50) {
	      $this->setTextColor(240,128,128);
	      $this->setFont('arial','B',8);
	    } 
            $this->setXY($x+10,$y+10); $this->MULTICELL(75,5,"Jml PNS : ".$totalpeg.", Jml Responden : ".$jmlpegpip." (".$persenpegpip."%)",'L','l',1);    
	    $this->setTextColor(0,0,0);

            $this->setFont('arial','',10);
            $totalkua = $pip->mpip->totalkua_insthn($key['id_instansi'], $tahun);
            if ($totalkua != 0) {
                $skorkua = round($totalkua/$jmlpegpip, 2);
                $katkua = $pip->mpip->getkategoriip($skorkua*(100/25));
            } else {
                $skorkua = 0;
            }

            $this->setXY($x+85,$y); $this->MULTICELL(20,15,$skorkua,'LTR','R',1);
            
            $totalkom = $pip->mpip->totalkom_insthn($key['id_instansi'], $tahun);
            if ($totalkom != 0) {
                $skorkom = round($totalkom/$jmlpegpip, 2);
                $katkom = $pip->mpip->getkategoriip($skorkom*(100/40));
            } else {
                $skorkom = 0;
            }
            $this->setXY($x+105,$y); $this->MULTICELL(22,15,$skorkom,'LTR','R',1);

            $totalkin = $pip->mpip->totalkin_insthn($key['id_instansi'], $tahun);
            if ($totalkin != 0) {
                $skorkin = round($totalkin/$jmlpegpip, 2);
                $katkin = $pip->mpip->getkategoriip($skorkin*(100/30));
            } else {
                $skorkin = 0;
            }
            $this->setXY($x+127,$y); $this->MULTICELL(20,15,$skorkin,'LTR','R',1);

            $totaldis = $pip->mpip->totaldis_insthn($key['id_instansi'], $tahun);
            if ($totaldis != 0) {
                $skordis = round($totaldis/$jmlpegpip, 2);
                $katdis = $pip->mpip->getkategoriip($skordis*(100/5));
            } else {
                $skordis = 0;
            }
            $this->setXY($x+147,$y); $this->MULTICELL(20,15,$skordis,'LTR','R',1);

            $jml = $pip->mpip->totalpip_insthn($key['id_instansi'], $tahun);
            if ($jml != 0) {
                $jmlpeg = $pip->mpip->jmldatapip_insthn($key['id_instansi'], $tahun);
                $ip_unker = round($jml/$jmlpeg, 2);
            } else {
                $jmlpeg = 0;
                $ip_unker = 0;
            }

            if ($pip->mpip->getkategoriip($ip_unker) == "SANGAT RENDAH") {
                $this->setFillColor(240,128,128);                
            } else if ($pip->mpip->getkategoriip($ip_unker) == "RENDAH") {
                $this->setFillColor(255,239,213);                
            } 

            $this->setXY($x+167,$y); $this->MULTICELL(21,15,$ip_unker,'LTR','R',1);
            $this->setFont('arial','',6);
            $this->setXY($x+167,$y+10); $this->MULTICELL(21,5,$pip->mpip->getkategoriip($ip_unker),'','L',1);
            $this->setFillColor(255,255,255);

            // garis tegak
            $this->Line($x+85,$y,$x+85,$y+15);
            $this->Line($x+105,$y,$x+105,$y+15);
            $this->Line($x+127,$y,$x+127,$y+15);
            $this->Line($x+147,$y,$x+147,$y+15);
            $this->Line($x+167,$y,$x+167,$y+15);
            $this->Line($x+188,$y,$x+188,$y+15);
            // garis mendatar
            $this->Line($x,$y+15,$x+188,$y+15);

            $y=$y+15;
            $no=$no+1;
            $maxline=$maxline+1;
	}
        }

    }

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
        $this->SetX(20);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),302,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',7);
        $this->setXY(20,310);        
        $this->MULTICELL(200,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),'T','L',1);
		//nomor halaman
        $this->setXY(272,195);
		$this->MULTICELL(30,5,'Halaman '.$this->PageNo().' dari {nb}','T','R',1);
	}
}
 
$pdf = new PDF('P', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($tahun);
$pdf->Output('piprekaptahunan.pdf', 'I');
//$pdf->Output();
