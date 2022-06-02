<?php

class PDF extends FPDF
{     

    //Page header
	function Header()
	{                                      
        $login = new mLogin();
        $mpeg = new Mpegawai();

        $this->SetXY(20,10);
        $this->setFont('Arial','',9);
        $this->setFillColor(255,255,255);
        //$this->cell(130,5,"Daftar Nominatif Tenaga Kontrak / Non PNS per Unit Kerja ",0,0,'L',1); 
        $this->cell(130,5,"",0,0,'L',1); 
        $this->setFont('Arial','I',8);
        $this->cell(170,5,'Dicetak oleh '.$mpeg->mpegawai->getnama($login->session->userdata('nip')).' ('.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 

        $this->SetY(15);
        $this->Line(20,$this->GetY(),320,$this->GetY());	}

	function Content($data)
	{
        $mno = new Mnonpns();
        $login = new mLogin();
        $mpeg = new Mpegawai();
        $mun = new Munker();
        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,10,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(50,5,'NIK','LTR','C',1);
        $this->setXY($x+10,$y+5);
        $this->MULTICELL(50,5,'NAMA','LR','C',1);
        $this->setXY($x+60,$y);
        $this->MULTICELL(15,5,'JENIS KELAMIN','LTR','C',1);
        $this->setXY($x+75,$y);
        $this->MULTICELL(60,5,'TUGAS JABATAN SAAT INI','LTR','C',1);
        $this->setXY($x+75,$y+5);
        $this->MULTICELL(60,5,'PENDIDIKAN TERAKHIR','LR','C',1);
        $this->setXY($x+135,$y);
        $this->MULTICELL(70,10,'SK PENGANGKATAN AWAL','LTR','C',1);
        $this->setXY($x+205,$y);
        $this->MULTICELL(70,10,'SK PENGANGKATAN AKHIR','LTR','C',1);
        $this->setXY($x+275,$y);
        $this->MULTICELL(25,5,'JENIS NON PNS','LTR','C',1);    
        $this->setXY($x+275,$y+5);
        $this->MULTICELL(25,5,'SUMBER GAJI','LR','C',1);    

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 45;
        $no = 1;        
        $maxline=1;
        foreach ($data as $key) {
            if ($no==1) {
                $this->Ln(8);
                $this->setFont('Arial','b',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                //$this->Image(base_url().'assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'DAFTAR NOMINATIF TENAGA KONTRAK / NON PNS',0,'L',1); 
                $this->setXY(30,25);
                $this->setFont('Arial','',10);
                $this->multicell(200,5,'UNIT KERJA : '.$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1); 
            }

           
            $maxline=$maxline % 6;
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 35;
                $y = 45;
                $this->Ln(8);
                $this->setFont('Arial','b',10);
                $this->setFillColor(255,255,255);
                $this->multicell(20,3,'',0,'C',0); 
                //$this->Image(base_url().'assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->Image('assets/logo.jpg', 20, 20,'8','10','jpeg');
                $this->setXY(30,20);
                $this->multicell(100,5,'DAFTAR NOMINATIF TENAGA KONTRAK / NON PNS',0,'L',1); 
                $this->setXY(30,25);
                $this->setFont('Arial','',10);
                $this->multicell(200,5,'UNIT KERJA : '.$mun->munker->getnamaunker($key->fid_unit_kerja),0,'L',1);                 

                $this->setFillColor(222,222,222);
                $this->setFont('arial','B',8);
                $this->setXY($x,$y1);
                $this->MULTICELL(10,10,'NO.','LTR','C',1); 
                $this->setXY($x+10,$y1);
                $this->MULTICELL(50,5,'NIK','LTR','C',1);
                $this->setXY($x+10,$y1+5);
                $this->MULTICELL(50,5,'NAMA','LR','C',1);
                $this->setXY($x+60,$y1);
                $this->MULTICELL(15,5,'JENIS KELAMIN','LTR','C',1);
                $this->setXY($x+75,$y1);
                $this->MULTICELL(60,5,'TUGAS JABATAN SAAT INI','LTR','C',1);
                $this->setXY($x+75,$y1+5);
                $this->MULTICELL(60,5,'PENDIDIKAN TERAKHIR','LR','C',1);
                $this->setXY($x+135,$y1);
                $this->MULTICELL(70,10,'SK PENGANGKATAN AWAL','LTR','C',1);
                $this->setXY($x+205,$y1);
                $this->MULTICELL(70,10,'SK PENGANGKATAN AKHIR','LTR','C',1);
                $this->setXY($x+275,$y1);
                $this->MULTICELL(25,5,'JENIS NON PNS','LTR','C',1);    
                $this->setXY($x+275,$y1+5);
                $this->MULTICELL(25,5,'SUMBER GAJI','LR','C',1);  
                $maxline=$maxline+1;
            }



            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $this->MULTICELL(50,5,$key->nik,'','L',1);            
            $this->setXY($x+10,$y+5);
            $this->MULTICELL(50,5,namagelar($key->gelar_depan,$key->nama,$key->gelar_blk),'','L',1);            
            $this->setXY($x+60,$y);
            $this->MULTICELL(15,5,$key->jns_kelamin,'','C',1);
            $this->setXY($x+75,$y);
            $this->setFont('arial','',8);            
            $this->MULTICELL(60,5,$mno->mnonpns->getjabatan($key->fid_jabnonpns),'','L',1);
            $this->setXY($x+75,$y+5);
            $this->MULTICELL(60,5,$mpeg->mpegawai->gettingpen($key->fid_tingkat_pendidikan).' - '.$mpeg->mpegawai->getjurpen($key->fid_jurusan_pendidikan),'','L',1);
            $skawal = $mno->mnonpns->getskawal($key->nik)->result_array();
            foreach($skawal as $awal):
                $this->setXY($x+135,$y);
                $this->MULTICELL(70,5,$awal['pejabat_sk'],'','L',1);
                $this->setXY($x+135,$y+5);
                $this->MULTICELL(70,5,$awal['no_sk'],'','L',1);
                $this->setXY($x+135,$y+10);
                $this->MULTICELL(70,5,'Tgl SK : '.tgl_indo($awal['tgl_sk']),'','L',1);
                $this->setXY($x+135,$y+15);
                $this->MULTICELL(70,5,'TMT : '.tgl_indo($awal['tmt_awal']),'','L',1);
                $this->setXY($x+135,$y+20);
                $this->MULTICELL(70,5,'Gaji : Rp. '.indorupiah($awal['gaji']),'','L',1);
            endforeach;

            $skakhir = $mno->mnonpns->getskakhir($key->nik)->result_array();
            foreach($skakhir as $akhir):
                $this->setXY($x+205,$y);
                $this->MULTICELL(70,5,$akhir['pejabat_sk'],'','L',1);
                $this->setXY($x+205,$y+5);
                $this->MULTICELL(70,5,$akhir['no_sk'],'','L',1);
                $this->setXY($x+205,$y+10);
                $this->MULTICELL(70,5,'Tgl SK : '.tgl_indo($akhir['tgl_sk']),'','L',1);
                $this->setXY($x+205,$y+15);
                $this->MULTICELL(70,5,'TMT : '.tgl_indo($akhir['tmt_awal']),'','L',1);
                $this->setXY($x+205,$y+20);
                $this->MULTICELL(70,5,'Gaji : Rp. '.indorupiah($akhir['gaji']),'','L',1);
            endforeach;

            $this->setXY($x+275,$y);
            $this->setFont('arial','',7);
            $this->MULTICELL(25,5,$mno->mnonpns->getjnsnonpns($key->fid_jenis_nonpns),'','L',1);
            $this->setFont('arial','',8);
            $this->setXY($x+275,$y+10);
            $this->MULTICELL(25,5,$mno->mnonpns->getsumbergaji($key->fid_sumbergaji),'','L',1);
            
            // garis vertikal            
            $this->Line($x,$y,$x,$y+30);
            $this->Line($x+10,$y,$x+10,$y+30);
            $this->Line($x+60,$y,$x+60,$y+30);
            $this->Line($x+75,$y,$x+75,$y+30);
            $this->Line($x+135,$y,$x+135,$y+30);
            $this->Line($x+205,$y,$x+205,$y+30);
            $this->Line($x+275,$y,$x+275,$y+30);
            $this->Line($x+300,$y,$x+300,$y+30);

            // garis horizontal
            $this->Line($x,$y,$x+300,$y);
            $this->Line($x,$y+30,$x+300,$y+30);
            
            $y=$y+30;
            $no=$no+1;
            $maxline=$maxline+1;            

            //$fid_unit_kerja = $key->fid_unit_kerja;
            //$jabatan_spesimen = $key->jabatan_spesimen;
            //$status_spesimen = $key->status_spesimen;
            //$key->nip_spesimen = $key->nip_spesimen;
        }        


        $jmlnonpns = $mno->mnonpns->getjmlperunker($key->fid_unit_kerja);

        $sisa = $jmlnonpns % 5;
        if (($sisa == 0) OR ($sisa == 4) ) {
        //if (($jmlnonpns == '5') OR ($jmlnonpns == '9') OR ($jmlnonpns == '10') OR ($jmlnonpns == '14') OR ($jmlnonpns == '15') OR ($jmlnonpns == '34')) {
            $this->AddPage();
            $y = 15;
        }



        $this->setFont('Arial','',10);
        $this->setXY(60,$y+20);
        $this->cell(70,5,'Dientri oleh, ',0,1,'C',1); 
        $this->setXY(60,$y+45);
        $this->setFont('Arial','U',10);
        $this->cell(70,5,$mpeg->mpegawai->getnama($login->session->userdata('nip')),0,1,'C',1); 
        $this->setFont('Arial','',10);
        $this->setXY(60,$y+50);
        $this->cell(70,5,'NIP. '.$login->session->userdata('nip'),0,1,'C',1); 

        $this->setFont('Arial','',10);
        $this->setXY(210,$y+10);
        //if (date('F') == 'December') $bulan='Desember';
        //else if (date('F') == 'January') $bulan='Januari';
        $this->cell(70,5,'Paringin, '.tgl_indo(date('Y-m-d')),0,1,'C',1); 
        $this->setXY(210,$y+15);
        $this->cell(70,5,'Mengetahui,',0,1,'C',1); 
        $this->setXY(195,$y+20);
        //$this->cell(70,5,'Kepala',1,1,'C',1); 

        if ($key->status_spesimen == 'DEFINITIF') {
            $this->MULTICELL(100,5,$key->jabatan_spesimen,0,'C',0); 
        } else if ($key->status_spesimen == 'PLT') {
            $this->MULTICELL(100,5,'Plt. '.$key->jabatan_spesimen,0,'C',0); 
        } else if ($key->status_spesimen == 'PLH') {
            $this->MULTICELL(100,5,'Plh. '.$key->jabatan_spesimen,0,'C',0); 
        } else if ($key->status_spesimen == 'AN') {
            $this->MULTICELL(100,5,'A.n. '.$key->jabatan_spesimen,0,'C',0); 
            $this->setXY(195,$y+25);
            if ($key->nip_spesimen != '') {
                $this->MULTICELL(100,5,$mpeg->mpegawai->namajabnip($key->nip_spesimen),0,'C',0);             
            }
        }

        
        if ($key->nip_spesimen != '') {
            $this->setFont('Arial','U',10);
            $this->setXY(210,$y+45);
            $this->cell(70,5,$mpeg->mpegawai->getnama($key->nip_spesimen),0,1,'C',1); 
            $this->setFont('Arial','',10);
            $this->setXY(210,$y+50);
            $this->cell(70,5,'NIP. '.$key->nip_spesimen,0,1,'C',1); 
        } else {
            //$this->setXY(210,$y+45);
            $this->Line(220,$y+50,270,$y+50);
            //$this->cell(70,5,'-------------------------------------',0,1,'C',1); 
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
		$this->SetFont('Arial','I',9);
        $this->Cell(0,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan 2017',0,0,'L');
		//nomor halaman
		$this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
 
$pdf = new PDF('L', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
//$pdf->Output('nominatif per unker', 'D');
$pdf->Output();
