<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "RUMAH SAKIT UMUM DAERAH BALANGAN";
      $j1 = "DIREKTUR";
      $j1t = "RUMAH SAKIT UMUM DAERAH BALANGAN";

      $j2 = "KABAG TATA USAHA";
      $j2t = "BAGIAN TATA USAHA";
      $j21 = "KASUBAG UMUM DAN KEPEGAWAIAN";
      $j21t = "SUBBAG UMUM DAN KEPEGAWAIAN";
      $j22 = "KASUBAG PROGRAM DAN KEUANGAN";
      $j22t = "SUBBAG PROGRAM DAN KEUANGAN";
      $j23 = "KASUBAG REKAM MEDIK & SISTEM INFORMASI MANAJEMEN RUMAH SAKIT";
      $j23t = "SUBBAG REKAM MEDIK & SISTEM INFORMASI MANAJEMEN RUMAH SAKIT";

      $j3 = "KABID PELAYANAN MEDIK DAN MUTU";
      $j3t = "BIDANG PELAYANAN MEDIK DAN MUTU";
      $j31 = "KASI PELAYANAN MEDIK";
      $j31t = "SEKSI PELAYANAN MEDIK";
      $j32 = "KASI MUTU PELAYANAN";
      $j32t = "SEKSI MUTU PELAYANAN";

      $j4 = "KABID PELAYANAN PENUNJANG";
      $j4t = "BIDANG PELAYANAN PENUNJANG";
      $j41 = "KASI PELAYANAN PENUNJANG MEDIK";
      $j41t = "SEKSI PELAYANAN PENUNJANG MEDIK";
      $j42 = "KASI PELAYANAN PENUNJANG NON MEDIK";
      $j42t = "SEKSI PELAYANAN PENUNJANG NON MEDIK";

      $j5 = "KABID KEPERAWATAN";
      $j5t = "BIDANG KEPERAWATAN";
      $j51 = "KASI ASUHAN KEPERAWATAN";
      $j51t = "SEKSI ASUHAN KEPERAWATAN";
      $j52 = "KASI SDM & LOGISTIK KEPERAWATAN";
      $j52t = "SEKSI SDM & LOGISTIK KEPERAWATAN";

      $j1photo = "sotk_nophoto.jpg"; $j1nama = "-"; $j1nip = "-"; $j1plt = "";
      $j2photo = "sotk_nophoto.jpg"; $j2nama = "-"; $j2nip = "-"; $j2plt = "";
      $j21photo = "sotk_nophoto.jpg"; $j21nama = "-"; $j21nip = "-"; $j21plt = "";
      $j22photo = "sotk_nophoto.jpg"; $j22nama = "-"; $j22nip = "-"; $j22plt = "";
      $j23photo = "sotk_nophoto.jpg"; $j23nama = "-"; $j23nip = "-"; $j23plt = "";
      $j3photo = "sotk_nophoto.jpg"; $j3nama = "-"; $j3nip = "-"; $j3plt = "";
      $j31photo = "sotk_nophoto.jpg"; $j31nama = "-"; $j31nip = "-"; $j31plt = "";
      $j32photo = "sotk_nophoto.jpg"; $j32nama = "-"; $j32nip = "-"; $j32plt = "";
      $j4photo = "sotk_nophoto.jpg"; $j4nama = "-"; $j4nip = "-"; $j4plt = "";
      $j41photo = "sotk_nophoto.jpg"; $j41nama = "-"; $j41nip = "-"; $j41plt = "";
      $j42photo = "sotk_nophoto.jpg"; $j42nama = "-"; $j42nip = "-"; $j42plt = "";
      $j5photo = "sotk_nophoto.jpg"; $j5nama = "-"; $j5nip = "-"; $j5plt = "";
      $j51photo = "sotk_nophoto.jpg"; $j51nama = "-"; $j51nip = "-"; $j51plt = "";
      $j52photo = "sotk_nophoto.jpg"; $j52nama = "-"; $j52nip = "-"; $j52plt = "";

      
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
        }else if ($nmjab == $j22) {
            $j22nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j22nip = $key->nip;
            $j22photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j22plt = " (PLT)";}
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
        }else if ($nmjab == $j31) {
            $j31nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j31nip = $key->nip;
            $j31photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j31plt = " (PLT)";}
        }else if ($nmjab == $j32) {
            $j32nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j32nip = $key->nip;
            $j32photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j32plt = " (PLT)";}
        }else if ($nmjab == $j4) {
            $j4nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j4nip = $key->nip;
            $j4photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j4plt = " (PLT)";}
        }else if ($nmjab == $j41) {
            $j41nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j41nip = $key->nip;
            $j41photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j41plt = " (PLT)";}
        }else if ($nmjab == $j42) {
            $j42nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j42nip = $key->nip;
            $j42photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j42plt = " (PLT)";}
        }else if ($nmjab == $j5) {
            $j5nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j5nip = $key->nip;
            $j5photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j5plt = " (PLT)";}
        }else if ($nmjab == $j51) {
            $j51nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j51nip = $key->nip;
            $j51photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j51plt = " (PLT)";}
        }else if ($nmjab == $j52) {
            $j52nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j52nip = $key->nip;
            $j52photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j52plt = " (PLT)";}
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
      $this->setXY(9.5,3.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,9.55,3.55,'1.4','1.9','jpg','');
      $this->setXY(11,3.5);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j1t.$j1plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(11,4.5);
      $this->MULTICELL(4.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(11,5);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22,6);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,22.05,6.05,'1.4','1.9','jpg','');
      $this->setXY(23.5,6);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(23.5,7);
      $this->MULTICELL(4.5,0.5,$j2nama,'LRT','C',0);
      $this->setXY(23.5,7.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j2nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(15.5,8.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j21photo,15.55,8.55,'1.4','1.9','jpg','');
      $this->setXY(17,8.5);
      $this->setFont('arial','',8);
      if ($j21plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4.5,0.5,$j21t.$j21plt,1,'C',1);
      }else {
      $this->MULTICELL(4.5,0.5,$j21t.$j21plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(17,9.5);
      $this->MULTICELL(4.5,0.5,$j21nama,'LRT','C',0);
      $this->setXY(17,10);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j21nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22,8.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j22photo,22.05,8.55,'1.4','1.9','jpg','');
      $this->setXY(23.5,8.5);
      $this->setFont('arial','',8);
      if ($j22plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4.5,0.5,$j22t.$j22plt,1,'C',1);
      }else {
      $this->MULTICELL(4.5,0.5,$j22t.$j22plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(23.5,9.5);
      $this->MULTICELL(4.5,0.5,$j22nama,'LRT','C',0);
      $this->setXY(23.5,10);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j22nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(28.5,8.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j23photo,28.55,8.55,'1.4','1.9','jpg','');
      $this->setXY(30,8.5);
      $this->setFont('arial','',7);
      if ($j23plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4.5,0.333,$j23t.$j23plt,1,'C',1);
      }else {
      $this->MULTICELL(4.5,0.333,$j23t.$j23plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(30,9.5);
      $this->MULTICELL(4.5,0.5,$j23nama,'LRT','C',0);
      $this->setXY(30,10);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j23nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(3.25,11.75);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,3.30,11.80,'1.4','1.9','jpg','');
      $this->setXY(4.75,11.75);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,0.5,$j3t.$j3plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(4.75,12.75);
      $this->MULTICELL(5.5,0.5,$j3nama,'LRT','C',0);
      $this->setXY(4.75,13.25);
      $this->MULTICELL(5.5,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(1.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j31photo,1.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(3,15.25);
      $this->setFont('arial','',9);
      if ($j31plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j31t.$j31plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j31t.$j31plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3,16.25);
      $this->MULTICELL(3.5,0.5,$j31nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(3,16.75);
      $this->MULTICELL(3.5,0.5,$j31nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(7,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j32photo,7.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(8.5,15.25);
      $this->setFont('arial','',9);
      if ($j32plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j32t.$j32plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j32t.$j32plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(8.5,16.25);
      $this->MULTICELL(3.5,0.334,$j32nama,'LRT','C',0);
      $this->setXY(8.5,16.75);
      $this->MULTICELL(3.5,0.5,$j32nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.75,11.75);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j4photo,14.80,11.80,'1.4','1.9','jpg','');
      $this->setXY(16.25,11.75);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,1,$j4t.$j4plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(16.25,12.75);
      $this->MULTICELL(5.5,0.5,$j4nama,'LRT','C',0);
      $this->setXY(16.25,13.25);
      $this->MULTICELL(5.5,0.5,$j4nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(13,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j41photo,13.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(14.5,15.25);
      $this->setFont('arial','',8);
      if ($j41plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j41t.$j41plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j41t.$j41plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(14.5,16.25);
      $this->MULTICELL(3.5,0.5,$j41nama,'LRT','C',0);
      $this->setXY(14.5,16.75);
      $this->MULTICELL(3.5,0.5,$j41nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(18.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j42photo,18.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(20,15.25);
      $this->setFont('arial','',8);
      if ($j42plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.333,$j42t.$j42plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.333,$j42t.$j42plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(20,16.25);
      $this->MULTICELL(3.5,0.334,$j42nama,'LRT','C',0);
      $this->setXY(20,16.75);
      $this->MULTICELL(3.5,0.5,$j42nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(25.75,11.75);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j5photo,25.80,11.80,'1.4','1.9','jpg','');
      $this->setXY(27.25,11.75);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,1,$j5t.$j5plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(27.25,12.75);
      $this->MULTICELL(5.5,0.5,$j5nama,'LRT','C',0);
      $this->setXY(27.25,13.25);
      $this->MULTICELL(5.5,0.5,$j5nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(24,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j51photo,24.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(25.5,15.25);
      $this->setFont('arial','',8);
      if ($j51plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j51t.$j51plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j51t.$j51plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(25.5,16.25);
      $this->MULTICELL(3.5,0.333,$j51nama,'LRT','C',0);
      $this->setXY(25.5,16.75);
      $this->MULTICELL(3.5,0.5,$j51nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j52photo,29.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(31,15.25);
      $this->setFont('arial','',8);
      if ($j52plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j52t.$j52plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j52t.$j52plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(31,16.25);
      $this->MULTICELL(3.5,0.333,$j52nama,'LRT','C',0);
      $this->setXY(31,16.75);
      $this->MULTICELL(3.5,0.5,$j52nip,'LRB','C',0);

      $this->setXY(11,18);
      $this->setFont('arial','B',10);
      $this->MULTICELL(3,1,'INSTALASI',1,'C',0);
      $this->setFont('arial','B',10);

	  $this->setXY(6.25,7);
      $this->setFont('arial','B',9);
      $this->MULTICELL(3,0.75,'POKJAFUNG',1,'C',0);
      $this->setFont('arial','',9);
	  $this->setXY(6.25,7.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(7,7.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(7.75,7.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(8.5,7.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(6.25,8.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(7,8.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
 	  $this->setXY(7.75,8.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(8.5,8.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);


      $this->Line(12.5,5.75,25,5.75); // Garis datar antara kepala dgn sekretaris
      $this->Line(25,5.75,25,6); // Garis tegak antara kepala dgn sekretaris

      $this->Line(18.5,8.25,31.5,8.25); // Garis datar antara sekretaris dgn subbag
      $this->Line(18.5,8.25,18.5,8.5); // Garis tegak antara sekretaris dgn subbag umum
      $this->Line(25,8,25,8.5); // Garis tegak antara sekretaris dgn subbag program
      $this->Line(31.5,8.25,31.5,8.5); // Garis tegak antara sekretaris dgn subbag keuangan

      $this->Line(12.5,5.5,12.5,18); // Garis tegak antara kepala dgn bidang & UPT
      $this->Line(6.75,11.5,29.25,11.5); // Garis datar antara kepala dgn bidang
      $this->Line(6.75,11.5,6.75,11.75); // Garis tegak antara kepala dgn bidang 1
      $this->Line(18.25,11.5,18.25,11.75); // Garis tegak antara kepala dgn bidang 2
      $this->Line(29.25,11.5,29.25,11.75); // Garis tegak antara kepala dgn bidang 3

      // Garis antara BIDANG PELAYANAN KESEHATAN DGN SEKSI NYA
      $this->Line(6.75,13.75,6.75,14.5);
      $this->Line(4,14.5,9.5,14.5);
      $this->Line(4,14.5,4,15.25);
      $this->Line(9.5,14.5,9.5,15.25);

      // Garis antara BIDANG PELAYANAN PENUNJANG DGN SEKSI NYA
      $this->Line(18.25,13.75,18.25,14.5);
      $this->Line(15.5,14.5,21,14.5);
      $this->Line(15.5,14.5,15.5,15.25);
      $this->Line(21,14.5,21,15.25);

      // Garis antara BIDANG KEPERAWATAN DGN SEKSI NYA
      $this->Line(29.25,13.75,29.25,14.5);
      $this->Line(26.5,14.5,32,14.5);
      $this->Line(26.5,14.5,26.5,15.25);
      $this->Line(32,14.5,32,15.25);


      // GARIS PUTUS2 BIDANG PELAYANAN KESEHATAN
      //1
      $this->Line(4,17.25,4,17.5);
      $this->Line(4,17.75,4,18);
      $this->Line(4,18.25,4,18.5);
      //2
      $this->Line(9.5,17.25,9.5,17.5);
      $this->Line(9.5,17.75,9.5,18);
      $this->Line(9.5,18.25,9.5,18.5);

      // GARIS PUTUS2 BIDANG PELAYANAN PENUNJANG
      //1
      $this->Line(15.5,17.25,15.5,17.5);
      $this->Line(15.5,17.75,15.5,18);
      $this->Line(15.5,18.25,15.5,18.5);
      //2
      $this->Line(21,17.25,21,17.5);
      $this->Line(21,17.75,21,18);
      $this->Line(21,18.25,21,18.5);

      // GARIS PUTUS2 BIDANG KEPERAWATAN
      //1
      $this->Line(26.5,17.25,26.5,17.5);
      $this->Line(26.5,17.75,26.5,18);
      $this->Line(26.5,18.25,26.5,18.5);
      //2
      $this->Line(32,17.25,32,17.5);
      $this->Line(32,17.75,32,18);
      $this->Line(32,18.25,32,18.5);


      // GARIS PUTUS2 DATAR
      $this->Line(4,18.5,4.25,18.5);
      $this->Line(4.5,18.5,4.75,18.5);
      $this->Line(5,18.5,5.25,18.5);
      $this->Line(5.5,18.5,5.75,18.5);
      $this->Line(6,18.5,6.25,18.5);
      $this->Line(6.5,18.5,6.75,18.5);
      $this->Line(7,18.5,7.25,18.5);
      $this->Line(7.5,18.5,7.75,18.5);
      $this->Line(8,18.5,8.25,18.5);
      $this->Line(8.5,18.5,8.75,18.5);
      $this->Line(9,18.5,9.25,18.5);
      $this->Line(9.5,18.5,9.75,18.5);
      $this->Line(10,18.5,10.25,18.5);
      $this->Line(10.5,18.5,10.75,18.5);

      $this->Line(14,18.5,14.25,18.5);
      $this->Line(14.5,18.5,14.75,18.5);
      $this->Line(15,18.5,15.25,18.5);
      $this->Line(15.5,18.5,15.75,18.5);
      $this->Line(16,18.5,16.25,18.5);
      $this->Line(16.5,18.5,16.75,18.5);
      $this->Line(17,18.5,17.25,18.5);
      $this->Line(17.5,18.5,17.75,18.5);
      $this->Line(18,18.5,18.25,18.5);
      $this->Line(18.5,18.5,18.75,18.5);
      $this->Line(19,18.5,19.25,18.5);
      $this->Line(19.5,18.5,19.75,18.5);
      $this->Line(20,18.5,20.25,18.5);
      $this->Line(20.5,18.5,20.75,18.5);
      $this->Line(21,18.5,21.25,18.5);
      $this->Line(21.5,18.5,21.75,18.5);
      $this->Line(22,18.5,22.25,18.5);
      $this->Line(22.5,18.5,22.75,18.5);
      $this->Line(23,18.5,23.25,18.5);
      $this->Line(23.5,18.5,23.75,18.5);
      $this->Line(24,18.5,24.25,18.5);
      $this->Line(24.5,18.5,24.75,18.5);
      $this->Line(25,18.5,25.25,18.5);
      $this->Line(25.5,18.5,25.75,18.5);
      $this->Line(26,18.5,26.25,18.5);
      $this->Line(26.5,18.5,26.75,18.5);
      $this->Line(27,18.5,27.25,18.5);
      $this->Line(27.5,18.5,27.75,18.5);
      $this->Line(28,18.5,28.25,18.5);
      $this->Line(28.5,18.5,28.75,18.5);
      $this->Line(29,18.5,29.25,18.5);
      $this->Line(29.5,18.5,29.75,18.5);
      $this->Line(30,18.5,30.25,18.5);
      $this->Line(30.5,18.5,30.75,18.5);
      $this->Line(31,18.5,31.25,18.5);
      $this->Line(31.5,18.5,31.75,18.5);               

      $this->Line(7.75,6.75,7.75,7); // Garis tegak antara kepala dgn jabfung
      $this->Line(7.75,6.75,12.5,6.75); // Garis datar antara kepala dgn jabfung
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
$pdf->Output('sotk rsud.pdf', 'I');
