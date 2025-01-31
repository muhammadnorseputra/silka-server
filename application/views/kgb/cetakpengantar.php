<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{
    
                
	}

	function Content($data)
	{
        
        $opeg = new Mpegawai();
        $ounker = new Munker();
        $okgb = new Mkgb();
        $opeg->load->helper('fungsitanggal');
        $opeg->load->helper('fungsipegawai');

        
        $y = 50;        
        
        foreach ($data as $key) {

            $this->Ln(8);
            $this->setFont('Arial','',10);
            $this->setFillColor(255,255,255);
            //$this->Image(base_url().'assets/logo.jpg', 30, 12,'20','25','jpeg');
            $this->Image('assets/logo.jpg', 25, 12,'20','25','jpeg');
            $this->setFont('Arial','',14);
            $this->setXY(50,12);$this->MULTICELL(150,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
            $this->setFont('Arial','B',20);
            $lenunker = strlen($ounker->munker->getnamaunker($key->fid_unit_kerja));
            if ($lenunker <= 25) {
                $this->setFont('Arial','B',24);
                $this->setXY(50,20);$this->MULTICELL(150,8,$ounker->munker->getnamaunker($key->fid_unit_kerja),'','C',1);
            } else if (($lenunker > 25) AND ($lenunker <= 60)) {
                $this->setFont('Arial','B',21);
                $this->setXY(50,18);$this->MULTICELL(150,7,$ounker->munker->getnamaunker($key->fid_unit_kerja),'','C',1);
            } else if ($lenunker > 60) {
                $this->setFont('Arial','B',15);
                $this->setXY(50,18);$this->MULTICELL(150,6,$ounker->munker->getnamaunker($key->fid_unit_kerja),'','C',1);
            }
            
            $this->setFont('Arial','',10);
            $this->setXY(50,32);$this->MULTICELL(150,5,$ounker->munker->getalamatunker($key->fid_unit_kerja),'','C',1);
            
            //buat garis horizontal
            $this->Line(20,42,200,42);

            $this->setFont('Arial','',11);            
            $this->setFillColor(255,255,255);
            $this->setXY(25,$y+5);
            $this->cell(20,5,'Nomor',0,1,'L',1); 
            $this->setXY(45,$y+5);
            $this->cell(80,5,': '.$key->no_pengantar,0,1,'L',1); 
            $this->setXY(25,$y+10);
            $this->cell(20,5,'Lampiran',0,1,'L',1); 
            $this->setXY(45,$y+10);
            $this->cell(80,5,': '.count($okgb->mkgb->detailpengantar($key->id_pengantar)->result_array()).' set berkas',0,1,'L',1); 
            $this->setXY(25,$y+15);
            $this->cell(20,5,'Perihal',0,1,'L',1); 
            $this->setXY(45,$y+15);
            $this->cell(2.5,5,': ',0,1,'L',1); 
            $this->cell(2.5,5,': ',0,1,'L',1); 
            $this->setXY(47.5,$y+15);
            $this->MULTICELL(70,5,"Permohonan kenaikan gaji berkala",'','L',1); 
            $this->setXY(47.5,$y+20);
            if ($okgb->mkgb->getjmldetailpengantar($key->id_pengantar) > 1) {
                $this->MULTICELL(70,5,"a.n. ".$opeg->mpegawai->getnama($key->nip)." NIP. ".$key->nip.", Dkk.",'','L',1);     
            } else {
                $this->MULTICELL(70,5,"a.n. ".$opeg->mpegawai->getnama($key->nip)." NIP. ".$key->nip.".",'','L',1);     
            }
            

            $this->Ln(8);
            $this->setFont('Arial','',11);
            $this->setXY(140,$y);
            $this->setFillColor(255,255,255);
            $this->cell(60,5,'Balangan, '.tgl_indo($key->tgl_pengantar),0,1,'L',1); 

            $this->setXY(130,$y+20);
            $this->cell(60,5,"Kepada :",0,1,'L',1); 
            $this->setXY(122,$y+25);
            $this->cell(60,5,"Yth. BUPATI BALANGAN",0,1,'L',1);
	    $idins = $ounker->get_idinstansi($key->fid_unit_kerja);
            if (($idins == '152') OR ($idins == '152') OR ($idins == '152')) {
		$this->setXY(130,$y+30);
                $this->cell(60,5,"U.p. KEPALA DISDIKBUD",0,1,'L',1);
	    } else {
	    	$this->setXY(130,$y+30);
            	$this->cell(60,5,"U.p. KEPALA BKPSDM",0,1,'L',1); 
            }
	    $this->setXY(130,$y+35);
            $this->cell(60,5,"Kabupaten Balangan",0,1,'L',1); 
            $this->setXY(130,$y+40);
            $this->cell(60,5,"di -",0,1,'L',1); 
            $this->setXY(140,$y+45);
            $this->setFont('Arial','U',11);
            $this->cell(60,5,"Paringin",0,1,'L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(25,$y+60);
            $this->MULTICELL(170,5,"Bersama ini kami sampaikan usul kenaikan gaji berkala ASN pada ".$ounker->munker->getnamaunker($key->fid_unit_kerja).", dengan rincian sebagai berikut :",'','J',1); 

            
            $this->setFillColor(222,222,222);
            $this->setXY(25,$y+75);$this->MULTICELL(10,15,"NO.",1,'C',1); 
            $this->setXY(35,$y+75);$this->MULTICELL(70,15,"NAMA / NIP",1,'C',1); 
            $this->setXY(105,$y+75);$this->MULTICELL(90,15,"KETERANGAN GAJI TERAKHIR",1,'C',1); 
            $this->setFillColor(255,255,255);

            break;
        }

        $x = 25;
        $y = $y + 5;
        $no = 1;
        foreach ($data as $key) {
            $this->setFont('Arial','',10);
            $this->setXY($x,$y+85);$this->MULTICELL(10,15,$no,1,'C',1); 
            $this->setXY($x+11,$y+86);$this->MULTICELL(68,6.5,$opeg->mpegawai->getnama($key->nip),0,'L',1); 
            $this->setXY($x+11,$y+92.5);$this->MULTICELL(68,6.5,'NIP. '.$key->nip,0,'L',1); 

            //$this->setXY($x+81,$y+86);$this->MULTICELL(88,6.5,'Gaji Pokok Rp. '.indorupiah($key->gapok_lama).' TMT : '.tgl_indo($key->tmt_gaji_lama).'Masa Kerja : '.$key->mk_thn_lama.' Tahun, '.$key->mk_bln_lama.' Bulan',0,'C',1); 

            $this->setXY($x+81,$y+86);$this->MULTICELL(44,6.5,'Gapok : Rp. '.indorupiah($key->gapok_lama),0,'L',1); 
            $this->setXY($x+125,$y+86);$this->MULTICELL(44,6.5,'TMT : '.tgl_indo($key->tmt_gaji_lama),0,'L',1);             
            
            $this->setXY($x+81,$y+92.5);$this->MULTICELL(44,6.5,'MaKer : '.$key->mk_thn_lama.' Thn '.$key->mk_bln_lama.' Bln',0,'L',1); 
            $this->setXY($x+125,$y+92.5);$this->MULTICELL(44,6.5,'Golru : '.$opeg->mpegawai->getnamagolru($key->fid_golru_lama),0,'L',1); 

            $this->Line($x+10,$y+100,$x+170,$y+100); // garis datar bagian bawah setiap baris
            $this->Line($x+80,$y+85,$x+80,$y+100); // garis tegak antara nama/nip dgn keterangan
            $this->Line($x+170,$y+85,$x+170,$y+100); // garis tegak paling kanan setiap baris
            $y=$y+15;
            $no=$no+1;            
        }

        $this->setFont('Arial','',11);
        $this->setXY(25,$y+95);
        $this->MULTICELL(165,5,'Demikian permohonan ini disampaikan untuk dapat dipergunakan sebagaimana mestinya.','','J',1);

        $this->setXY(105,$y+105);
        $this->setFont('Arial','B',11);

	if (!$key->status) {
	    $this->MULTICELL(100,5,'',0,'C',0);	
        } else if ($key->status == 'DEFINITIF') {
            $this->MULTICELL(100,5,$key->jabatan_spesimen,0,'C',0); 
        } else if ($key->status == 'PLT') {
            $this->MULTICELL(100,5,'Plt. '.$key->jabatan_spesimen,0,'C',0); 
        } else if ($key->status == 'PLH') {
            $this->MULTICELL(100,5,'Plh. '.$key->jabatan_spesimen,0,'C',0); 
        } else if ($key->status == 'AN') {
            $this->MULTICELL(100,5,'a.n. '.$key->jabatan_spesimen,0,'C',0); 
            $this->setXY(105,$y+120);
            $this->MULTICELL(100,5,$opeg->mpegawai->namajabnip($key->nip_spesimen),0,'C',0);             
        } else {
	    $this->MULTICELL(100,5,'',0,'C',0);	
	}
        
        $this->setFont('Arial','',11);

        $this->setFont('Arial','U',11);
        $this->setXY(120,$y+130); $this->cell(70,5,$opeg->mpegawai->getnama($key->nip_spesimen),0,1,'C',1); 
        $this->setFont('Arial','',11);
        $this->setXY(120,$y+135); $this->cell(70,5,'NIP. '.$key->nip_spesimen,0,1,'C',1); 

        
	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
        $this->Cell(0,10,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');		
	}
}
 
$pdf = new PDF('P', 'mm', 'Legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output();
