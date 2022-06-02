<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "KELURAHAN BATU PIRING";
      $j1 = "LURAH";
      $j1t = "KELURAHAN BATU PIRING";

      $j2 = "SEKRETARIS";
      $j2t = "SEKRETARIAT";

      $j3 = "KEPALA SEKSI PEMERINTAHAN";
      $j3t = "SEKSI PEMERINTAHAN";

      $j5 = "KEPALA SEKSI PEREKONOMIAN DAN PEMBANGUNAN";
      $j5t = "SEKSI PEREKONOMIAN DAN PEMBANGUNAN";

      $j6 = "KEPALA SEKSI KESEJAHTERAAN RAKYAT, KETENTERAMAN DAN KETERTIBAN UMUM";
      $j6t = "SEKSI KESEJAHTERAAN RAKYAT, KETENTERAMAN DAN KETERTIBAN UMUM";

      $j1photo = "sotk_nophoto.jpg"; $j1nama = "-"; $j1nip = "-"; $j1plt = "";
      $j2photo = "sotk_nophoto.jpg"; $j2nama = "-"; $j2nip = "-"; $j2plt = "";
      $j3photo = "sotk_nophoto.jpg"; $j3nama = "-"; $j3nip = "-"; $j3plt = "";
      $j5photo = "sotk_nophoto.jpg"; $j5nama = "-"; $j5nip = "-"; $j5plt = "";
      $j6photo = "sotk_nophoto.jpg"; $j6nama = "-"; $j6nip = "-"; $j6plt = "";

      
      $sotk = new Msotk();
      foreach ($data as $key) {

        $nmjab = $sotk->msotk->getnamajab($unker,$key->fid_jabatan);

        if ($nmjab == $j1) {
            $j1nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j1nip = $key->nip;
            $j1photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j1plt = " (PLT)";}
        }else if ($nmjab == $j2) {
            $j2nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j2nip = $key->nip;
            $j2photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j2plt = " (PLT)";}
        }else if ($nmjab == $j3) {
            $j3nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j3nip = $key->nip;
            $j3photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j3plt = " (PLT)";}
        }else if ($nmjab == $j5) {
            $j5nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j5nip = $key->nip;
            $j5photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j5plt = " (PLT)";}
        }else if ($nmjab == $j6) {
            $j6nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j6nip = $key->nip;
            $j6photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j6plt = " (PLT)";}
        }
      }

      $pltcl = "210,210,210";

      $this->setAutoPageBreak(false);
      $this->setFont('courier','',11);
      // text (left margin, top margin)
      $this->Image('assets/logo.jpg','3','1','1.5','2','jpg','');
      $this->setFont('courier','B',12);
      $this->text(5,1.3,'BAGAN STRUKTUR ORGANISASI');
      $this->text(5,1.8,$unker);
      $this->setFont('arial','B',8);
      $this->text(5,2.3,'Tgl. Cetak : '. date('d-m-Y'));
      $this->text(5,2.8,'SILKa Online ::: BKPPD Kab. Balangan All rights reserved');

      $this->setFont('arial','',9);
      $this->setXY(15,4.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,15.05,4.55,'1.4','1.9','jpg','');
      $this->setXY(16.5,4.5);
      $this->setFont('arial','',9);
       if ($j1plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4.5,1,$j1t.$j1plt,1,'C',1);
      }else {
      $this->MULTICELL(4.5,1,$j1t.$j1plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(16.5,5.5);
      $this->MULTICELL(4.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(16.5,6);
      $this->MULTICELL(4.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,7);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,23.55,7.05,'1.4','1.9','jpg','');
      $this->setXY(25,7);
      $this->setFont('arial','',9);
       if ($j2plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',1);
      }else {
      $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(25,8);
      $this->MULTICELL(4.5,0.5,$j2nama,'LRT','C',0);
      $this->setXY(25,8.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j2nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,2.05,12.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,12.25);
      $this->setFont('arial','',8);
       if ($j3plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j3t.$j3plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j3t.$j3plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,13.25);
      $this->MULTICELL(5.5,0.5,$j3nama,'LRT','C',0);
      $this->setXY(3.5,13.75);
      $this->MULTICELL(5.5,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j5photo,14.55,12.30,'1.4','1.9','jpg','');
      $this->setXY(16,12.25);
      $this->setFont('arial','',8);
       if ($j5plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.5,$j5t.$j5plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.5,$j5t.$j5plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(16,13.25);
      $this->MULTICELL(5.5,0.5,$j5nama,'LRT','C',0);
      $this->setXY(16,13.75);
      $this->MULTICELL(5.5,0.5,$j5nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j6photo,27.55,12.30,'1.4','1.9','jpg','');
      $this->setXY(29,12.25);
      $this->setFont('arial','',8);
      if ($j6plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0,333,$j6t.$j6plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.333,$j6t.$j6plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(29,13.25);
      $this->MULTICELL(5.5,0.5,$j6nama,'LRT','C',0);
      $this->setXY(29,13.75);
      $this->MULTICELL(5.5,0.5,$j6nip,'LRB','C',0);

	$this->setXY(8.25,8);
      $this->setFont('arial','B',9);
      $this->MULTICELL(3,0.75,'POKJAFUNG',1,'C',0);
      $this->setFont('arial','',9);
	$this->setXY(8.25,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(9,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(9.75,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(10.5,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(8.25,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(9,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
 	$this->setXY(9.75,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(10.5,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);

      //$this->Rect(18,10,4,3,'F');

      $this->Line(18,6.75,26.5,6.75);
      $this->Line(26.5,6.75,26.5,7);

      $this->Line(18,6.5,18,12.25);
      $this->Line(5.5,12,31,12);
      $this->Line(5.5,12,5.5,12.25);
      //$this->Line(22.5,12,22.5,12.25);
      $this->Line(31,12,31,12.25);
      $this->Line(9.75,7.75,9.75,8); // Garis tegak antara kepala dgn jabfung
      $this->Line(9.75,7.75,18,7.75); // Garis datar antara kepala dgn jabfung
  }

  function Footer()
  {
    //atur posisi 1.5 cm dari bawah
    //$this->SetY(-15);
    //buat garis horizontal
    //$this->Line(10,$this->GetY(),320,$this->GetY());
    //Arial italic 9
    //$this->SetFont('Arial','I',9);
    //    $this->Cell(0,10,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');   
  }
}
 
$pdf = new PDF('L', 'cm', array('21.6','35.5'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('sotk lurah_batpir.pdf', 'I');
