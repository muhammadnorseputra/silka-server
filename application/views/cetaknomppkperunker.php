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
                $this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                //$this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                //atur posisi 1.5 cm dari bawah
                $this->SetY(15);
                //buat garis horizontal
                $this->Line(20,$this->GetY(),320,$this->GetY());
                
                /*
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(20,3,'',0,0,'C',0); 
                $this->Image(base_url().'assets/logo.jpg', 20, 22,'8','10','jpeg');
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
        $this->MULTICELL(10,15,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(50,15,'NIP / NAMA','LTR','C',1);
        $this->setXY($x+60,$y);
        $this->MULTICELL(75,15,'JABATAN','LTR','C',1);
        $this->setXY($x+135,$y);
        $this->MULTICELL(20,15,'NILAI SKP','LTR','C',1);
        $this->setXY($x+155,$y);
        $this->MULTICELL(115,5,'PRILAKU KERJA','LTR','C',1);
        $this->setFont('arial','',7);
        $this->setXY($x+155,$y+5);
        $this->MULTICELL(20,5,'ORIENTASI PELAYANAN','LTR','C',1);
        $this->setXY($x+175,$y+5);
        $this->MULTICELL(15,5,'INTE GRITAS','LTR','C',1);
        $this->setXY($x+190,$y+5);
        $this->MULTICELL(15,5,'KOMIT MEN','LTR','C',1);
        $this->setXY($x+205,$y+5);
        $this->MULTICELL(15,10,'DISIPLIN','LTR','C',1);
        $this->setXY($x+220,$y+5);
        $this->MULTICELL(15,5,'KERJA SAMA','LTR','C',1);
        $this->setXY($x+235,$y+5);
        $this->MULTICELL(15,5,'KEPEMIMPINAN','LTR','C',1);    
        $this->setXY($x+250,$y+5);
        $this->setFont('arial','B',7);
        $this->MULTICELL(20,3.34,'NILAI PRILAKU KERJA','LTR','C',1);    
        $this->setFont('arial','B',8);
        $this->setXY($x+270,$y);
        $this->MULTICELL(20,5,'NILAI PRETASI KERJA','LTR','C',1);    

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 50;
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
                $this->multicell(100,5,'NOMINATIF PENILAIAN PRESTASI KERJA TAHUN '.$key->tahun,0,'L',1); 
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
                $this->multicell(100,5,'NOMINATIF PENILAIAN PRESTASI KERJA TAHUN '.$key->tahun,0,'L',1); 
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
                $this->MULTICELL(20,15,'NILAI SKP','LTR','C',1);
                $this->setXY($x+155,$y1);
                $this->MULTICELL(115,5,'PRILAKU KERJA','LTR','C',1);
                $this->setFont('arial','',7);
                $this->setXY($x+155,$y1+5);
                $this->MULTICELL(20,5,'ORIENTASI PELAYANAN','LTR','C',1);
                $this->setXY($x+175,$y1+5);
                $this->MULTICELL(15,5,'INTE GRITAS','LTR','C',1);
                $this->setXY($x+190,$y1+5);
                $this->MULTICELL(15,5,'KOMIT MEN','LTR','C',1);
                $this->setXY($x+205,$y1+5);
                $this->MULTICELL(15,10,'DISIPLIN','LTR','C',1);
                $this->setXY($x+220,$y1+5);
                $this->MULTICELL(15,5,'KERJA SAMA','LTR','C',1);
                $this->setXY($x+235,$y1+5);
                $this->MULTICELL(15,5,'KEPEMIMPINAN','LTR','C',1);    
                $this->setXY($x+250,$y1+5);
                $this->setFont('arial','B',7);
                $this->MULTICELL(20,3.34,'NILAI PRILAKU KERJA','LTR','C',1);    
                $this->setFont('arial','B',8);
                $this->setXY($x+270,$y1);
                $this->MULTICELL(20,5,'NILAI PRETASI KERJA','LTR','C',1);
                $maxline=$maxline+1;
            }

            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $this->MULTICELL(50,5,$key->nip,'','l',1);            
            $this->setXY($x+10,$y+5);
            $this->MULTICELL(50,5,namagelar($key->gelar_depan,$key->nama,$key->gelar_belakang),'','L',1);            
            $this->setXY($x+60,$y);

            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }

            $this->MULTICELL(75,5,$mpeg->mpegawai->namajab($key->fid_jnsjab,$idjab),'','L',1);            
            $this->setXY($x+135,$y);           
            $this->setFont('arial','',9);

            if ($key->nilai_skp == 0) {
                $this->MULTICELL(20,8,'','','C',1);
            } else {
                $this->MULTICELL(20,8,round($key->nilai_skp, 2),'','C',1);
                $this->setXY($x+135,$y+6);
                $this->setFont('arial','',8);
                $this->MULTICELL(20,4,$mpeg->mpegawai->getnilaiskp($key->nilai_skp),'','C',1);
            }            
            
            $this->setFont('arial','',9);
            $this->setXY($x+155,$y);
            $this->MULTICELL(20,15,$key->orientasi_pelayanan,'','C',1);
            $this->setXY($x+175,$y);
            $this->MULTICELL(15,15,$key->integritas,'','C',1);
            $this->setXY($x+190,$y);
            $this->MULTICELL(15,15,$key->komitmen,'','C',1);
            $this->setXY($x+205,$y);
            $this->MULTICELL(15,15,$key->disiplin,'','C',1);
            $this->setXY($x+220,$y);
            $this->MULTICELL(15,15,$key->kerjasama,'','C',1);
            $this->setXY($x+235,$y);
            $this->MULTICELL(15,15,$key->kepemimpinan,'','C',1);
            $this->setXY($x+250,$y);
            if ($key->nilai_prilaku_kerja == 0) {
                $this->MULTICELL(20,7.5,'','','C',1);
            } else {
                $this->MULTICELL(20,7.5,round($key->nilai_prilaku_kerja, 2),'','C',1);
                $this->setXY($x+250,$y+6);
                $this->setFont('arial','',8);
                $this->MULTICELL(20,4,$mpeg->mpegawai->getnilaiskp($key->nilai_skp),'','C',1);    
            }
            
            $this->setFont('arial','',9);
            $this->setXY($x+270,$y);

            if ($key->nilai_prestasi_kerja == 0) {
                $this->MULTICELL(20,7.5,'','','C',1);            
            } else {
                $this->MULTICELL(20,7.5,round($key->nilai_prestasi_kerja, 2),'','C',1);            
                $this->setXY($x+270,$y+6);
                $this->setFont('arial','',8);
                $this->MULTICELL(20,4,$mpeg->mpegawai->getnilaiskp($key->nilai_skp),'','C',1);
            }
            
            $this->setFont('arial','',9);

            // garis vertikal            
            $this->Line($x,$y,$x,$y+15);
            $this->Line($x+10,$y,$x+10,$y+15);
            $this->Line($x+60,$y,$x+60,$y+15);
            $this->Line($x+135,$y,$x+135,$y+15);
            $this->Line($x+155,$y,$x+155,$y+15);
            $this->Line($x+175,$y,$x+175,$y+15);
            $this->Line($x+190,$y,$x+190,$y+15);
            $this->Line($x+205,$y,$x+205,$y+15);
            $this->Line($x+220,$y,$x+220,$y+15);
            $this->Line($x+235,$y,$x+235,$y+15);
            $this->Line($x+250,$y,$x+250,$y+15);
            $this->Line($x+270,$y,$x+270,$y+15);
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
$pdf->Output('nominatif ppk per unker.pdf', 'D');
//$pdf->Output();
