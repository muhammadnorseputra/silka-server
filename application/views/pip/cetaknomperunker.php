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
                $this->cell(150,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                //$this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                //atur posisi 1.5 cm dari bawah
                $this->SetY(15);
                //buat garis horizontal
                $this->Line(20,$this->GetY(),302,$this->GetY());
                
                /*
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(20,3,'',0,0,'C',0); 
                $this->Image(base_url().'assets/logo.jpg', 20, 22,'8','10','jpeg');
                $this->cell(100,4,'Badan Kepegawaian, Pendidikan dan Pelatihan Daerah',0,1,'L',1); 
                $this->cell(20,3,'',0,0,'C',0); 
                $this->cell(100,6,'Nominatif ',0,1,'L',1); 
                */
	}
 
	function Content($data)
	{
        $mpeg = new Mpegawai();
        $mun = new Munker();
        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,15,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(50,15,'NIP / NAMA','LTR','C',1);
        $this->setXY($x+60,$y);
        $this->MULTICELL(75,15,'JABATAN','LTR','C',1);
        $this->setXY($x+135,$y);
        $this->MULTICELL(20,15,'PENDIDIKAN','LTR','C',1);
        $this->setXY($x+155,$y);
        $this->MULTICELL(87,5,'SKOR INDIKATOR','LTR','C',1);
        $this->setXY($x+155,$y+5);
        $this->MULTICELL(20,10,'KUALIFIKASI','LTR','C',1);
        $this->setXY($x+175,$y+5);
        $this->MULTICELL(22,10,'KOMPETENSI','LTR','C',1);
        $this->setXY($x+197,$y+5);
        $this->MULTICELL(20,10,'KINERJA','LTR','C',1);
        $this->setXY($x+217,$y+5);
        $this->MULTICELL(20,10,'DISIPLIN','LTR','C',1);
        $this->setXY($x+237,$y);
        $this->MULTICELL(20,15,'NILAI','LTR','C',1);
        $this->setXY($x+257,$y);
        $this->MULTICELL(25,15,'KATEGORI','LTR','C',1);    

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 50;
        $no = 1;        
        $maxline=1;
        foreach ($data as $key) {
            if ($no==1) {                
                //$tahun = substr($key->tahun, 0,4);
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'NOMINATIF INDEKS PROFESIONALITAS ASN TAHUN '.$key->tahun,0,'L',1); 
                //$this->multicell(100,5,'NOMINATIF INDEKS PROFESIONALITAS ASN TAHUN',0,'L',1); 
                $this->setXY(30,25);
                $this->multicell(200,5,$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1); 
            }

           
            $maxline=$maxline % 10;            
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 35;
                $y = 50;
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'NOMINATIF INDEKS PROFESIONALITAS ASN TAHUN '.$key->tahun,0,'L',1); 
                $this->setXY(30,25);
                $this->multicell(200,5,$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1);                 

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,15,'NO.','LTR','C',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(50,15,'NIP / NAMA','LTR','C',1);
                $this->setXY($x+60,$y1);
                $this->MULTICELL(75,15,'JABATAN','LTR','C',1);
                $this->setXY($x+135,$y1);
                $this->MULTICELL(20,15,'PENDIDIKAN','LTR','C',1);
                $this->setXY($x+155,$y1);
                $this->MULTICELL(87,5,'SKOR INDIKATOR','LTR','C',1);
                $this->setXY($x+155,$y1+5);
                $this->MULTICELL(20,10,'KUALIFIKASI','LTR','C',1);
                $this->setXY($x+175,$y1+5);
                $this->MULTICELL(22,10,'KOMPETENSI','LTR','C',1);
                $this->setXY($x+197,$y1+5);
                $this->MULTICELL(20,10,'KINERJA','LTR','C',1);
                $this->setXY($x+217,$y1+5);
                $this->MULTICELL(20,10,'DISIPLIN','LTR','C',1);
                $this->setXY($x+237,$y1);
                $this->MULTICELL(20,15,'NILAI','LTR','C',1);
                $this->setXY($x+257,$y1);
                $this->MULTICELL(25,15,'KATEGORI','LTR','C',1);    
                $maxline=$maxline+1;
            }

            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,15,$no.'.','1','C',1); 
            $this->setXY($x+10,$y);
            $this->MULTICELL(50,5,$key->nip,'LTR','l',1);            
            $this->setXY($x+10,$y+5);
            $this->MULTICELL(50,5,$mpeg->getnama($key->nip),'L','L',1);            
            $this->setXY($x+60,$y);

            $this->MULTICELL(75,5,$key->jabatan,'T','L',1);            
            $this->setXY($x+135,$y);           
            $this->setFont('arial','',9);
            
                $this->setXY($x+135,$y);
                $this->setFont('arial','',8);
                $this->MULTICELL(20,15,$key->tingkat_pendidikan,'1','C',1);
            
            $this->setFont('arial','',9);
            $this->setXY($x+155,$y);
            $this->MULTICELL(20,15,$key->skor_kualifikasi,'1','C',1);
            $this->setXY($x+175,$y);
            $this->MULTICELL(22,15,$key->skor_kompetensi,'1','C',1);
            $this->setXY($x+197,$y);
            $this->MULTICELL(20,15,$key->skor_kinerja,'1','C',1);
            $this->setXY($x+217,$y);
            $this->MULTICELL(20,15,$key->skor_disiplin,'1','C',1);
            $this->setXY($x+237,$y);
            $this->MULTICELL(20,15,$key->nilai_pip,'1','C',1);
            $this->setXY($x+257,$y);
            $this->MULTICELL(25,7.5,$key->kategori_pip,'LTR','C',1);
            
            // garis tegak
            $this->Line($x+60,$y,$x+60,$y+15);            
            $this->Line($x+282,$y,$x+282,$y+15);
            // garis mendatar
            $this->Line($x,$y+15,$x+282,$y+15);

            $y=$y+15;
            $no=$no+1;
            $maxline=$maxline+1;
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
        $this->setXY(20,195);        
        $this->MULTICELL(200,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),'T','L',1);
		//nomor halaman
        $this->setXY(272,195);
		$this->MULTICELL(30,5,'Halaman '.$this->PageNo().' dari {nb}','T','R',1);
	}
}
 
$pdf = new PDF('L', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('nominatifpipperunker.pdf', 'I');
//$pdf->Output();
