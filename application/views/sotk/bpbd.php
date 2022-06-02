<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "BADAN PENANGGULANGAN BENCANA DAERAH";
      $j1 = "KEPALA PELAKSANA";
      $j1t = "KEPALA PELAKSANA";

      $j2 = "SEKRETARIS";
      $j2t = "SEKRETARIAT";
      $j21 = "KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN";
      $j21t = "SUB BAGIAN UMUM DAN KEPEGAWAIAN";
      $j22 = "KEPALA SUB BAGIAN PERENCANAAN DAN PELAPORAN";
      $j22t = "SUB BAGIAN PERENCANAAN DAN PELAPORAN";
      $j23 = "KEPALA SUB BAGIAN KEUANGAN";
      $j23t = "SUB BAGIAN KEUANGAN";

      $j3 = "KEPALA BIDANG PENCEGAHAN DAN KESIAPSIAGAAN";
      $j3t = "BIDANG PENCEGAHAN DAN KESIAPSIAGAAN";
      $j31 = "KEPALA SEKSI PENCEGAHAN";
      $j31t = "SEKSI PENCEGAHAN";
      $j32 = "KEPALA SEKSI KESIAPSIAGAAN";
      $j32t = "SEKSI KESIAPSIAGAAN";

      $j4 = "KEPALA BIDANG KEDARURATAN DAN LOGISTIK";
      $j4t = "BIDANG KEDARURATAN DAN LOGISTIK";
      $j41 = "KEPALA SEKSI KEDARURATAN";
      $j41t = "SEKSI KEDARURATAN";
      $j42 = "KEPALA SEKSI LOGISTIK";
      $j42t = "SEKSI LOGISTIK";

      $j5 = "KEPALA BIDANG REHABILITASI DAN REKONSTRUKSI";
      $j5t = "BIDANG REHABILITASI DAN REKONSTRUKSI";
      $j51 = "KEPALA SEKSI REHABILITASI";
      $j51t = "SEKSI REHABILITASI";
      $j52 = "KEPALA SEKSI REKONSTRUKSI";
      $j52t = "SEKSI REKONSTRUKSI";

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
            //if ($key->plt == "YA") {$j1plt = " (PLT)";}
        }else if ($nmjab == $j2) {
            $j2nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j2nip = $key->nip;
            $j2photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j2plt = " (PLT)";}
        }else if ($nmjab == $j21) {
            $j21nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j21nip = $key->nip;
            $j21photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j21plt = " (PLT)";}
        }else if ($nmjab == $j22) {
            $j22nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j22nip = $key->nip;
            $j22photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j22plt = " (PLT)";}
        }else if ($nmjab == $j23) {
            $j23nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j23nip = $key->nip;
            $j23photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j23plt = " (PLT)";}
        }else if ($nmjab == $j3) {
            $j3nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j3nip = $key->nip;
            $j3photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j3plt = " (PLT)";}
        }else if ($nmjab == $j31) {
            $j31nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j31nip = $key->nip;
            $j31photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j31plt = " (PLT)";}
        }else if ($nmjab == $j32) {
            $j32nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j32nip = $key->nip;
            $j32photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j32plt = " (PLT)";}
        }else if ($nmjab == $j4) {
            $j4nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j4nip = $key->nip;
            $j4photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j4plt = " (PLT)";}
        }else if ($nmjab == $j41) {
            $j41nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j41nip = $key->nip;
            $j41photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j41plt = " (PLT)";}
        }else if ($nmjab == $j42) {
            $j42nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j42nip = $key->nip;
            $j42photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j42plt = " (PLT)";}
        }else if ($nmjab == $j5) {
            $j5nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j5nip = $key->nip;
            $j5photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j5plt = " (PLT)";}
        }else if ($nmjab == $j51) {
            $j51nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j51nip = $key->nip;
            $j51photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j51plt = " (PLT)";}
        }else if ($nmjab == $j52) {
            $j52nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j52nip = $key->nip;
            $j52photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j52plt = " (PLT)";}
        }
      }

      $pltcl = "210,210,210";

      //$this=new FPDF("legal","L");
 	    //$this->AddPage();
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
      $this->setXY(8,3);
      $this->MULTICELL(13,1,'BADAN PENANGGULANGAN BENCANA DAERAH','LRTB','C',0);
      $this->setXY(8,4);
      $this->setFont('arial','',9);
      $this->MULTICELL(13,0.5,'Kepala (ex-officio dijabat Sekretaris Daerah)','LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(8,5.5);
      $this->MULTICELL(6,1,'UNSUR PENGARAH','LRT','C',0);
      $this->setXY(8,6.5);
      $this->setFont('arial','',9);
      $this->MULTICELL(6,0.5,'- Instansi','TLR','L',0);
      $this->setXY(8,7);
      $this->MULTICELL(6,0.5,'- Profesional/Ahli','LRB','L',0);

      $this->Line(11,5,18,5); // Garis datar antara pengarah dan kepala pelaksana
      $this->Line(11,5,11,5.5); // Garis tegak antara kepala dengan pengarah
      $this->Line(18,5,18,5.5); // Garis tegak antara kepala dengan kepala pelaksana
      $this->Line(14.5,4.5,14.5,5); // Garis tegak antara sekretaris dgn subbag keuangan

      $this->setFont('arial','',9);
      $this->setXY(15,5.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,15.05,5.55,'1.4','1.9','jpg','');
      $this->setXY(16.5,5.5);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,1,$j1t.$j1plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(16.5,6.5);
      $this->MULTICELL(4.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(16.5,7);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,8);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,23.55,8.05,'1.4','1.9','jpg','');
      $this->setXY(25,8);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(25,9);
      $this->MULTICELL(4.5,0.5,$j2nama,'LRT','C',0);
      $this->setXY(25,9.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j2nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(18.5,10.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j21photo,18.55,10.55,'1.4','1.9','jpg','');
      $this->setXY(20,10.5);
      $this->setFont('arial','',8);
      if ($j21plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j21t.$j21plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j21t.$j21plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(20,11.5);
      $this->MULTICELL(3.5,0.5,$j21nama,'LRT','C',0);
	  $this->setXY(20,12);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j21nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(24,10.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j22photo,24.05,10.55,'1.4','1.9','jpg','');
      $this->setXY(25.5,10.5);
      $this->setFont('arial','',8);
      if ($j22plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.333,$j22t.$j22plt,1,'C',1);
      }
      else {
      $this->MULTICELL(3.5,0.333,$j22t.$j22plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(25.5,11.5);
      $this->MULTICELL(3.5,0.5,$j22nama,'LRT','C',0);
      $this->setXY(25.5,12);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j22nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29.5,10.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j23photo,29.55,10.55,'1.4','1.9','jpg','');
      $this->setXY(31,10.5);
      $this->setFont('arial','',8);
      if ($j23plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j23t.$j23plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j23t.$j23plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(31,11.5);
      $this->MULTICELL(3.5,0.5,$j23nama,'LRT','C',0);
      $this->setXY(31,12);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j23nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,13.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,2.05,13.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,13.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j3t.$j3plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(3.5,14.25);
      $this->MULTICELL(5.5,0.5,$j3nama,'LRT','C',0);
      $this->setXY(3.5,14.75);
      $this->MULTICELL(5.5,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,16);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j31photo,2.05,16.05,'1.4','1.9','jpg','');
      $this->setXY(3.5,16);
      $this->setFont('arial','',8);
      if ($j31plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j31t.$j31plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j31t.$j31plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(3.5,17);
      $this->MULTICELL(5.5,0.5,$j31nama,'LRT','C',0);
      $this->setXY(3.5,17.5);
      $this->MULTICELL(5.5,0.5,$j31nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,18.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j32photo,2.05,18.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,18.25);
      $this->setFont('arial','',8);
      if ($j32plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j32t.$j32plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j32t.$j32plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,19.25);
      $this->MULTICELL(5.5,0.5,$j32nama,'LRT','C',0);
      $this->setXY(3.5,19.75);
      $this->MULTICELL(5.5,0.5,$j32nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,13.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j4photo,14.55,13.30,'1.4','1.9','jpg','');
      $this->setXY(16,13.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j4t.$j4plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(16,14.25);
      $this->MULTICELL(5.5,0.5,$j4nama,'LRT','C',0);
      $this->setXY(16,14.75);
      $this->MULTICELL(5.5,0.5,$j4nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,16);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j41photo,14.55,16.05,'1.4','1.9','jpg','');
      $this->setXY(16,16);
      $this->setFont('arial','',8);
      if ($j41plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j41t.$j41plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j41t.$j41plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(16,17);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j41nama,'LRT','C',0);
      $this->setXY(16,17.5);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,0.5,$j41nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,18.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j42photo,14.55,18.30,'1.4','1.9','jpg','');
      $this->setXY(16,18.25);
      $this->setFont('arial','',8);
      if ($j42plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j42t.$j42plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j42t.$j42plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(16,19.25);
      $this->MULTICELL(5.5,0.5,$j42nama,'LRT','C',0);
      $this->setXY(16,19.75);
      $this->MULTICELL(5.5,0.5,$j42nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,13.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j5photo,27.55,13.30,'1.4','1.9','jpg','');
      $this->setXY(29,13.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j5t.$j5plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(29,14.25);
      $this->MULTICELL(5.5,0.5,$j5nama,'LRT','C',0);
      $this->setXY(29,14.75);
      $this->MULTICELL(5.5,0.5,$j5nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,16);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j51photo,27.55,16.05,'1.4','1.9','jpg','');
      $this->setXY(29,16);
      $this->setFont('arial','',8);
      if ($j51plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j51t.$j51plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j51t.$j51plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(29,17);
      $this->MULTICELL(5.5,0.5,$j51nama,'LRT','C',0);
      $this->setXY(29,17.5);
      $this->MULTICELL(5.5,0.5,$j51nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,18.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j52photo,27.55,18.30,'1.4','1.9','jpg','');
      $this->setXY(29,18.25);
      $this->setFont('arial','',8);
      if ($j52plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,1,$j52t.$j52plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,1,$j52t.$j52plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(29,19.25);
      $this->MULTICELL(5.5,0.5,$j52nama,'LRT','C',0);
      $this->setXY(29,19.75);
      $this->MULTICELL(5.5,0.5,$j52nip,'LRB','C',0);

     	$this->setXY(8.25,9);
      $this->setFont('arial','B',9);
      $this->MULTICELL(3,0.75,'POKJAFUNG',1,'C',0);
      $this->setFont('arial','',9);
	$this->setXY(8.25,9.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(9,9.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(9.75,9.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(10.5,9.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(8.25,10.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(9,10.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
 	$this->setXY(9.75,10.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	$this->setXY(10.5,10.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);


      $this->Line(18,7.75,26.5,7.75); // Garis datar antara kepala dgn sekretaris
      $this->Line(26.5,7.75,26.5,8); // Garis datar antara kepala dgn sekretaris

      $this->Line(21,10.25,32,10.25); // Garis datar antara sekretaris dgn subbag
      $this->Line(21,10.25,21,10.5); // Garis tegak antara sekretaris dgn subbag umum
      $this->Line(26.5,10,26.5,10.5); // Garis tegak antara sekretaris dgn subbag program
      $this->Line(32,10.25,32,10.5); // Garis tegak antara sekretaris dgn subbag keuangan

      $this->Line(18,7.5,18,13); // Garis tegak antara kepala dgn bidang
      $this->Line(5.5,13,31,13); // Garis datar antara kepala dgn bidang
      $this->Line(5.5,13,5.5,13.25); // Garis tegak antara kepala dgn bidang 3
      $this->Line(18,13,18,13.25); // Garis tegak antara kepala dgn bidang 4
      $this->Line(31,13,31,13.25); // Garis tegak antara kepala dgn bidang 5

      $this->Line(1.75,15.5,1.75,19.25); // Garis tegak antara bidang 3 dgn seksi
      $this->Line(5.5,15.25,5.5,15.5); // Garis tegak antara bidang 3 dgn seksi (pendek)
      $this->Line(1.75,15.5,5.5,15.5); // Garis datar antara bidang 3 dgn seksi
      $this->Line(1.75,17,2,17); // Garis datar antara bidang 3 dgn seksi 31
      $this->Line(1.75,19.25,2,19.25); // Garis datar antara bidang 3 dgn seksi 32

      $this->Line(14.25,15.5,14.25,19.25); // Garis tegak antara bidang 4 dgn seksi
      $this->Line(18,15.25,18,15.5); // Garis tegak antara bidang 4 dgn seksi (pendek)
      $this->Line(14.25,15.5,18,15.5); // Garis datar antara bidang 4 dgn seksi
      $this->Line(14.25,17,14.5,17); // Garis datar antara bidang 4 dgn seksi 41
      $this->Line(14.25,19.25,14.5,19.25); // Garis datar antara bidang 4 dgn seksi 42

      $this->Line(27.25,15.5,27.25,19.25); // Garis tegak antara bidang 5 dgn seksi
      $this->Line(31,15.25,31,15.5); // Garis tegak antara bidang 5 dgn seksi (pendek)
      $this->Line(27.25,15.5,31,15.5); // Garis datar antara bidang 5 dgn seksi
      $this->Line(27.25,17,27.5,17); // Garis datar antara bidang 5 dgn seksi 51
      $this->Line(27.25,19.25,27.5,19.25); // Garis datar antara bidang 5 dgn seksi 52

      $this->Line(9.75,8.75,9.75,9); // Garis tegak antara kepala dgn jabfung
      $this->Line(9.75,8.75,18,8.75); // Garis datar antara kepala dgn jabfung

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
$pdf->Output('sotk bpbd.pdf', 'I');
