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
                $this->cell(130,5,"Daftar Nominatif ASN per Unit Kerja ",0,0,'L',1); 
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
        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,10,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(35,10,'NIP','LTR','C',1);
        $this->setXY($x+45,$y);
        $this->MULTICELL(40,10,'NAMA','LTR','C',1);
        $this->setXY($x+85,$y);
        $this->MULTICELL(10,5,'JNS. KEL','LTR','C',1);
        $this->setXY($x+95,$y);
        $this->MULTICELL(35,5,'PANGKAT / GOLONGAN RUANG','LTR','C',1);
        $this->setXY($x+130,$y);
        $this->MULTICELL(60,10,'JABATAN','LTR','C',1);
        $this->setXY($x+190,$y);
        $this->MULTICELL(15,5,'MASA KERJA','LTR','C',1);
        $this->setXY($x+205,$y);
        $this->MULTICELL(25,10,'DIKLAT','LTR','C',1);
        $this->setXY($x+230,$y);
        $this->MULTICELL(45,10,'PENDIDIKAN','LTR','C',1);
        $this->setXY($x+275,$y);
        $this->MULTICELL(25,5,'TEMPAT / TGL. LAHIR','LTR','C',1);    

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 45;
        $no = 1;        
        $maxline=1;
        foreach ($data as $key) {
            if ($no==1) {
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'DAFTAR NOMINATIF ASN',0,'L',1); 
                $this->setXY(30,25);
                $this->multicell(200,5,$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1); 
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
                $this->multicell(100,5,'DAFTAR NOMINATIF ASN',0,'L',1); 
                $this->setXY(30,25);
                $this->multicell(200,5,$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1);                 

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,10,'NO.','LTR','C',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(35,10,'NIP','LTR','C',1);
                $this->setXY($x+45,$y1);
                $this->MULTICELL(40,10,'NAMA','LTR','C',1);
                $this->setXY($x+85,$y1);
                $this->MULTICELL(10,5,'JNS. KEL','LTR','C',1);
                $this->setXY($x+95,$y1);
                $this->MULTICELL(35,5,'PANGKAT / GOLONGAN RUANG','LTR','C',1);
                $this->setXY($x+130,$y1);
                $this->MULTICELL(60,10,'JABATAN','LTR','C',1);
                $this->setXY($x+190,$y1);
                $this->MULTICELL(15,5,'MASA KERJA','LTR','C',1);
                $this->setXY($x+205,$y1);
                $this->MULTICELL(25,10,'DIKLAT','LTR','C',1);
                $this->setXY($x+230,$y1);
                $this->MULTICELL(45,10,'PENDIDIKAN','LTR','C',1);
                $this->setXY($x+275,$y1);
                $this->MULTICELL(25,5,'TEMPAT / TANGGAL LAHIR','LTR','C',1);
                $maxline=$maxline+1;
            }

            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $this->MULTICELL(35,5,$key->nip,'','C',1);            
            $this->setXY($x+45,$y);
            $this->MULTICELL(40,5,namagelar($key->gelar_depan,$key->nama,$key->gelar_belakang),'','L',1);            
            $this->setXY($x+85,$y);
            $this->MULTICELL(10,5,$key->jenis_kelamin,'','C',1);
            $this->setXY($x+95,$y);
            $this->setFont('arial','',7);
            $this->MULTICELL(35,5,$mpeg->mpegawai->getnamapangkat($key->fid_golru_skr).' ('.$mpeg->mpegawai->getnamagolru($key->fid_golru_skr).')','','L',1);
            $this->setXY($x+95,$y+10);
            $this->MULTICELL(35,5,'TMT : '.tgl_indo($key->tmt_golru_skr),'','L',1);
            $this->setXY($x+130,$y);
            $this->setFont('arial','',7);

            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }

            $this->MULTICELL(60,5,$mpeg->mpegawai->namajab($key->fid_jnsjab,$idjab),'','L',1);
            $this->setXY($x+130,$y+10);
            $this->MULTICELL(60,5,'TMT : '.tgl_indo($key->tmt_jabatan),'','L',1);
            $this->setXY($x+190,$y);
            $this->setFont('arial','',8);
            $this->MULTICELL(15,5,hitungmkcpns($key->nip),'','L',1);
            $this->setXY($x+205,$y);
            $this->MULTICELL(25,5,$mpeg->mpegawai->getdssingkat($key->nip),'','L',1);
            $this->setXY($x+230,$y);
            $this->MULTICELL(45,5,$mpeg->mpegawai->getpendidikansingkat($key->nip),'','L',1);
            $this->setXY($x+275,$y);
            $this->MULTICELL(25,5,$key->tmp_lahir.' / '.tgl_indo($key->tgl_lahir),'','L',1);
            
            // garis vertikal            
            $this->Line($x,$y,$x,$y+15);
            $this->Line($x+10,$y,$x+10,$y+15);
            $this->Line($x+45,$y,$x+45,$y+15);
            $this->Line($x+85,$y,$x+85,$y+15);
            $this->Line($x+95,$y,$x+95,$y+15);
            $this->Line($x+130,$y,$x+130,$y+15);
            $this->Line($x+190,$y,$x+190,$y+15);
            $this->Line($x+205,$y,$x+205,$y+15);
            $this->Line($x+230,$y,$x+230,$y+15);
            $this->Line($x+275,$y,$x+275,$y+15);
            $this->Line($x+300,$y,$x+300,$y+15);

            // garis horizontal
            $this->Line($x,$y,$x+300,$y);
            $this->Line($x,$y+15,$x+300,$y+15);
            
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
