<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "KECAMATAN TEBING TINGGI";
      $j1 = "CAMAT";
      $j1t = "KECAMATAN TEBING TINGGI";

      $j2 = "SEKRETARIS";
      $j2t = "SEKRETARIAT";
      $j21 = "KEPALA SUB BAGIAN PERENCANAAN DAN KEUANGAN";
      $j21t = "SUB BAGIAN PERENCANAAN DAN KEUANGAN";
      $j23 = "KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN";
      $j23t = "SUB BAGIAN UMUM DAN KEPEGAWAIAN";

      $j3 = "KEPALA SEKSI PEMERINTAHAN";
      $j3t = "SEKSI PEMERINTAHAN";

      $j4 = "KEPALA SEKSI KETENTRAMAN & KETERTIBAN UMUM";
      $j4t = "SEKSI KETENTRAMAN & KETERTIBAN UMUM";

      $j5 = "KEPALA SEKSI PEREKONOMIAN DAN PEMBANGUNAN";
      $j5t = "SEKSI PEREKONOMIAN DAN PEMBANGUNAN";

      $j6 = "KEPALA SEKSI KESEJAHTERAAN RAKYAT";
      $j6t = "SEKSI KESEJAHTERAAN RAKYAT";

      $j7 = "KEPALA SEKSI PELAYANAN UMUM";
      $j7t = "SEKSI PELAYANAN UMUM";

       $j1photo = "sotk_nophoto.jpg"; $j1nama = "-"; $j1nip = "-"; $j1plt = "";
      $j2photo = "sotk_nophoto.jpg"; $j2nama = "-"; $j2nip = "-"; $j2plt = "";
      $j21photo = "sotk_nophoto.jpg"; $j21nama = "-"; $j21nip = "-"; $j21plt = "";
      $j23photo = "sotk_nophoto.jpg"; $j23nama = "-"; $j23nip = "-"; $j23plt = "";
      $j3photo = "sotk_nophoto.jpg"; $j3nama = "-"; $j3nip = "-"; $j3plt = "";
      $j4photo = "sotk_nophoto.jpg"; $j4nama = "-"; $j4nip = "-"; $j4plt = "";
      $j5photo = "sotk_nophoto.jpg"; $j5nama = "-"; $j5nip = "-"; $j5plt = "";
      $j6photo = "sotk_nophoto.jpg"; $j6nama = "-"; $j6nip = "-"; $j6plt = "";
      $j7photo = "sotk_nophoto.jpg"; $j7nama = "-"; $j7nip = "-"; $j7plt = "";

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
        }else if ($nmjab == $j21) {
            $j21nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j21nip = $key->nip;
            $j21photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j21plt = " (PLT)";}
        }else if ($nmjab == $j23) {
            $j23nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j23nip = $key->nip;
            $j23photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j23plt = " (PLT)";}
        }else if ($nmjab == $j3) {
            $j3nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j3nip = $key->nip;
            $j3photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j3plt = " (PLT)";}
        }else if ($nmjab == $j4) {
            $j4nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j4nip = $key->nip;
            $j4photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j4plt = " (PLT)";}
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
        }else if ($nmjab == $j7) {
            $j7nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j7nip = $key->nip;
            $j7photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j7plt = " (PLT)";}
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
      $this->setXY(11.5,4.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,11.55,4.55,'1.4','1.9','jpg','');
      $this->setXY(13,4.5);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j1t.$j1plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(13,5.5);
      $this->MULTICELL(4.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(13,6);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,7);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,23.55,7.05,'1.4','1.9','jpg','');
      $this->setXY(25,7);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(25,8);
      $this->MULTICELL(4.5,0.5,$j2nama,'LRT','C',0);
      $this->setXY(25,8.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j2nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(18.5,9.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j21photo,18.55,9.55,'1.4','1.9','jpg','');
      $this->setXY(20,9.5);
      $this->setFont('arial','',7.5);
      if ($j21plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.333,$j21t.$j21plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.333,$j21t.$j21plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(20,10.5);
      $this->MULTICELL(3.5,0.5,$j21nama,'LRT','C',0);
	$this->setXY(20,11);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j21nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29.5,9.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j23photo,29.55,9.55,'1.4','1.9','jpg','');
      $this->setXY(31,9.5);
      $this->setFont('arial','',8);
      if ($j23plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j23t.$j23plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j23t.$j23plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(31,10.5);
      $this->MULTICELL(3.5,0.5,$j23nama,'LRT','C',0);
      $this->setXY(31,11);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j23nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,2.05,12.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,12.25);
      $this->setFont('arial','',8);
      if ($j3plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,1,$j3t.$j3plt,1,'C',1);
      }else {
      $this->MULTICELL(4,1,$j3t.$j3plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,13.25);
      $this->MULTICELL(4,0.5,$j3nama,'LRT','C',0);
      $this->setXY(3.5,13.75);
      $this->MULTICELL(4,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(8.5,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j4photo,8.55,12.30,'1.4','1.9','jpg','');
      $this->setXY(10,12.25);
      $this->setFont('arial','',8);
      if ($j4plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j4t.$j4plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j4t.$j4plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(10,13.25);
      $this->MULTICELL(4,0.5,$j4nama,'LRT','C',0);
      $this->setXY(10,13.75);
      $this->MULTICELL(4,0.5,$j4nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(16,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j5photo,16.05,12.30,'1.4','1.9','jpg','');
      $this->setXY(17.5,12.25);
      $this->setFont('arial','',8);
      if ($j5plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j5t.$j5plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j5t.$j5plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(17.5,13.25);
      $this->MULTICELL(4,0.5,$j5nama,'LRT','C',0);
      $this->setXY(17.5,13.75);
      $this->MULTICELL(4,0.5,$j5nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22.5,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j6photo,22.55,12.30,'1.4','1.9','jpg','');
      $this->setXY(24,12.25);
      $this->setFont('arial','',8);
      if ($j6plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j6t.$j6plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j6t.$j6plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(24,13.25);
      $this->MULTICELL(4,0.5,$j6nama,'LRT','C',0);
      $this->setXY(24,13.75);
      $this->MULTICELL(4,0.5,$j6nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29,12.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j7photo,29.05,12.30,'1.4','1.9','jpg','');
      $this->setXY(30.5,12.25);
      $this->setFont('arial','',8);
      if ($j7plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,1,$j7t.$j7plt,1,'C',1);
      }else {
      $this->MULTICELL(4,1,$j7t.$j7plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(30.5,13.25);
      $this->MULTICELL(4,0.5,$j7nama,'LRT','C',0);
      $this->setXY(30.5,13.75);
      $this->MULTICELL(4,0.5,$j7nip,'LRB','C',0);

      $this->setXY(16.5,15.75);
      $this->setFont('arial','B',10);
      $this->MULTICELL(3,1,'KELURAHAN',1,'C',0);
      $this->setFont('arial','B',10);

      $this->setXY(10,15.75);
      $this->setFont('arial','B',10);
      $this->MULTICELL(3,1,'DESA',1,'C',0);
      $this->setFont('arial','B',10);

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


      $this->Line(15.5,6.75,26.5,6.75); // Garis datar antara kepala dgn sekretaris
      $this->Line(26.5,6.75,26.5,7); // Garis tegak antara kepala dgn sekretaris

      $this->Line(21,9.25,32,9.25); // Garis datar antara sekretaris dgn subbag
      $this->Line(21,9.25,21,9.5); // Garis tegak antara sekretaris dgn subbag umum
      $this->Line(26.5,9,26.5,9.25); // Garis tegak antara sekretaris dgn subbag program
      $this->Line(32,9.25,32,9.5); // Garis tegak antara sekretaris dgn subbag keuangan

      $this->Line(15.5,6.5,15.5,12);// Garis tegak antara kepala dgn bidang & UPT
      $this->Line(5.5,12,32,12); // Garis datar antara kepala dgn bidang
      $this->Line(5.5,12,5.5,12.25); // Garis tegak antara kepala dgn bidang 1
      $this->Line(11.5,12,11.5,12.25); // Garis tegak antara kepala dgn bidang 2
      $this->Line(19,12,19,12.25); // Garis tegak antara kepala dgn bidang 3
      $this->Line(25.5,12,25.5,12.25); // Garis tegak antara kepala dgn bidang 4
      $this->Line(32,12,32,12.25); // Garis tegak antara kepala dgn bidang 5

      $this->Line(14,6.5,14,7.75);
      $this->Line(9.75,7.75,9.75,8); // Garis tegak antara kepala dgn jabfung
      $this->Line(9.75,7.75,14,7.75); // Garis datar antara kepala dgn jabfung

      $this->Line(15,6.5,15,16.25); // Garis tegak antara kepala dgn kelurahan
      $this->Line(15,16.25,16.5,16.25); // Garis datar antara kepala dgn kelurahan

      // Garis putus2 tegak
      $this->Line(14.5,6.5,14.5,6.75);
      $this->Line(14.5,7,14.5,7.25);
      $this->Line(14.5,7.5,14.5,7.75);
      $this->Line(14.5,8,14.5,8.25);
      $this->Line(14.5,8.5,14.5,8.75);
      $this->Line(14.5,9,14.5,9.25);
      $this->Line(14.5,9.5,14.5,9.75);
      $this->Line(14.5,10,14.5,10.25);
      $this->Line(14.5,10.5,14.5,10.75);
      $this->Line(14.5,11,14.5,11.25);
      $this->Line(14.5,11.5,14.5,11.75);
      $this->Line(14.5,12,14.5,12.25);
      $this->Line(14.5,12.5,14.5,12.75);
      $this->Line(14.5,13,14.5,13.25);
      $this->Line(14.5,13.5,14.5,13.75);
      $this->Line(14.5,14,14.5,14.25);
      $this->Line(14.5,14.5,14.5,14.75);
      $this->Line(14.5,15,14.5,15.25);
      $this->Line(14.5,15.5,14.5,15.75);
      $this->Line(14.5,16,14.5,16.25);

      // Garis putus2 datar
      $this->Line(13,16.25,13.25,16.25);
      $this->Line(13.5,16.25,13.75,16.25);
      $this->Line(14,16.25,14.25,16.25);

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
$pdf->Output('sotk camat_tbtg.pdf', 'I');
