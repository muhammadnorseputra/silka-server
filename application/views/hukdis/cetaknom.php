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
                $this->cell(130,5,"Badan Kepegawaian, Pendidikan dan Pelatihan Daerah Kab. Balangan",0,0,'L',1); 
                $this->setFont('Arial','I',7);
                $this->cell(160,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                //atur posisi 1.5 cm dari bawah
                $this->SetY(15);
                //buat garis horizontal
                $this->Line(20,$this->GetY(),310,$this->GetY());
                
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
        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,10,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(60,10,'NIP','LTR','C',1);
        $this->setXY($x+70,$y);
        $this->MULTICELL(85,10,'JABATAN / UNIT KERJA','LTR','C',1);
        $this->setXY($x+155,$y);
        $this->MULTICELL(90,10,'HUKUMAN DISIPLIN','LTR','C',1);
        $this->setXY($x+245,$y);
        $this->MULTICELL(45,10,'KETERANGAN','LTR','C',1);


        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 45;
        $no = 1;        
        $maxline=1;
        foreach ($data as $key) {

            if ($no==1) {
                $tahun = substr($key->tmt_hukuman, 0,4);
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'DAFTAR NOMINATIF PENJATUHAN HUKUMAN DISIPLIN TAHUN '.$tahun,0,'L',1); 
                //$this->setXY(30,25);
                //$this->multicell(200,5,$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1); 
            }
           
            $maxline=$maxline % 10;            
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 35;
                $y = 45;
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'DAFTAR NOMINATIF PENJATUHAN HUKUMAN DISIPLIN TAHUN '.$tahun,0,'L',1); 
                
                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,10,'NO.','LTR','C',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(60,10,'NIP','LTR','C',1);
                $this->setXY($x+70,$y1);
                $this->MULTICELL(85,10,'JABATAN / UNIT KERJA','LTR','C',1);
                $this->setXY($x+155,$y1);
                $this->MULTICELL(90,10,'HUKUMAN DISIPLIN','LTR','C',1);
                $this->setXY($x+245,$y1);
                $this->MULTICELL(45,10,'KETERANGAN','LTR','C',1);

                $maxline=$maxline+1;
            }

            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,10,$no,'T','C',1); 
            
            $this->setXY($x+10,$y);
            $this->MULTICELL(60,5,"NIP. ".$key->nip,'T','L',1);
            $this->setXY($x+10,$y+5);            
            $this->MULTICELL(60,5,$mpeg->mpegawai->getnama($key->nip),'','L',1);
            $this->setFont('arial','',7);            
            $this->setXY($x+10,$y+10);            
            $this->MULTICELL(60,5,$mpeg->mpegawai->getnamapangkat($key->fid_golru).' ('.$mpeg->mpegawai->getnamagolru($key->fid_golru).') TMT : '.tgl_indo($key->tmt_golru),'','L',1);
            $this->setXY($x+70,$y);
            $this->MULTICELL(85,3,$key->jabatan,'T','',1);

            $this->setXY($x+155,$y);
            $this->MULTICELL(90,4,$mpeg->mhukdis->getjnshukdis($key->fid_jenis_hukdis).' ('.$mpeg->mhukdis->gettingkathukdis($key->fid_jenis_hukdis).')','T','L',1);

            if ($key->akhir_hukuman != null) {
                $sd = " s/d ".tgl_indo($key->akhir_hukuman);
            } else {
                $sd = '';
            }

            $this->setXY($x+155,$y+4);
            $this->MULTICELL(90,3,"TMT : ".tgl_indo($key->tmt_hukuman).$sd,'','L',1);
            $this->setXY($x+155,$y+7);
            $this->MULTICELL(90,3,"Lama Hukuman : ".$key->lama_thn." Tahun ".$key->lama_bln." Bulan",'','L',1);

            $this->setXY($x+155,$y+11);
            $this->MULTICELL(60,3,"No. SK : ".$key->no_sk,'','L',1);
            $this->setXY($x+210,$y+11);
            $this->MULTICELL(35,3,"Tgl. SK : ".tgl_indo($key->tgl_sk),'','L',1);

            $this->setFont('arial','',6);
            $this->setXY($x+245,$y);
            $this->MULTICELL(45,3,$key->deskripsi,'','L',1);

            $this->setXY($x+155,$y+8);
            $this->Line($x,$y,$x,$y+15);
            $this->Line($x+10,$y,$x+10,$y+15);
            $this->Line($x+70,$y,$x+70,$y+15);
            //$this->Line($x+80,$y,$x+80,$y+15);
            $this->Line($x+155,$y,$x+155,$y+15);            
            $this->Line($x+245,$y,$x+245,$y+15);            
            $this->Line($x+290,$y,$x+290,$y+15);  
           
            // garis horizontal
            $this->Line($x,$y,$x+290,$y);
            $this->Line($x,$y+15,$x+290,$y+15);

            $y=$y+15;
            $no=$no+1;
            $maxline=$maxline+1;
        } 

	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
        $this->SetX(20);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),310,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',7);
        $this->Cell(0,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');
		//nomor halaman
		$this->Cell(-10,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
 
$pdf = new PDF('L', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('nominatifhukdis.pdf', 'I');
