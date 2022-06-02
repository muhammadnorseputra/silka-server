<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK";
      $j1 = "KEPALA";
      $j1t = "DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK";

      $j2 = "SEKRETARIS";
      $j2t = "SEKRETARIAT";
      $j21 = "KEPALA SUB BAGIAN PERENCANAAN DAN KEUANGAN";
      $j21t = "SUB BAGIAN PERENCANAAN DAN KEUANGAN";
      $j23 = "KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN";
      $j23t = "SUB BAGIAN UMUM DAN KEPEGAWAIAN";

      $j3 = "KEPALA BIDANG KUALITAS HIDUP PEREMPUAN DAN KELUARGA";
      $j3t = "BIDANG KUALITAS HIDUP PEREMPUAN DAN KELUARGA";
      $j31 = "KEPALA SEKSI KUALITAS HIDUP PEREMPUAN DAN KUALITAS KELUARGA";
      $j31t = "SEKSI KUALITAS HIDUP PEREMPUAN DAN KUALITAS KELUARGA";
      $j32 = "KEPALA SEKSI KUALITAS HIDUP PEREMPUAN BIDANG SOSIAL, POLITIK DAN HUKUM";
      $j32t = "SEKSI KUALITAS HIDUP PEREMPUAN BIDANG SOSIAL, POLITIK DAN HUKUM";

      $j4 = "KEPALA BIDANG PEMENUHAN HAK ANAK";
      $j4t = "BIDANG PEMENUHAN HAK ANAK";
      $j41 = "KEPALA SEKSI LINGKUNGAN KELUARGA, PENGASUHAN ALTERNATIF DAN PENDIDIKAN, PEMANFAATAN WAKTU LUANG DAN KEGIATAN BUDAYA";
      $j41t = "SEKSI LINGKUNGAN KELUARGA, PENGASUHAN ALTERNATIF DAN PENDIDIKAN, PEMANFAATAN WAKTU LUANG DAN KEGIATAN BUDAYA";
      $j42 = "KEPALA SEKSI HAK SIPIL, INFORMASI, PARTISIPASI, KESEHATAN DASAR DAN KESEJAHTERAAN";
      $j42t = "SEKSI HAK SIPIL, INFORMASI, PARTISIPASI, KESEHATAN DASAR DAN KESEJAHTERAAN";

      $j6 = "KEPALA BIDANG PERLINDUNGAN PEREMPUAN DAN ANAK";
      $j6t = "BIDANG PERLINDUNGAN PEREMPUAN DAN ANAK";
      $j61 = "KEPALA SEKSI PERLINDUNGAN PEREMPUAN DAN PERLINDUNGAN KHUSUS ANAK";
      $j61t = "SEKSI PERLINDUNGAN PEREMPUAN DAN PERLINDUNGAN KHUSUS ANAK";
      $j62 = "KEPALA SEKSI DATA KEKERASAN PEREMPUAN, ANAK DAN SISTEM DATA INFORMASI";
      $j62t = "SEKSI DATA KEKERASAN PEREMPUAN, ANAK DAN SISTEM DATA INFORMASI";

      $j1photo = "sotk_nophoto.jpg"; $j1nama = "-"; $j1nip = "-"; $j1plt = "";
      $j2photo = "sotk_nophoto.jpg"; $j2nama = "-"; $j2nip = "-"; $j2plt = "";
      $j21photo = "sotk_nophoto.jpg"; $j21nama = "-"; $j21nip = "-"; $j21plt = "";
      $j23photo = "sotk_nophoto.jpg"; $j23nama = "-"; $j23nip = "-"; $j23plt = "";
      $j3photo = "sotk_nophoto.jpg"; $j3nama = "-"; $j3nip = "-"; $j3plt = "";
      $j31photo = "sotk_nophoto.jpg"; $j31nama = "-"; $j31nip = "-"; $j31plt = "";
      $j32photo = "sotk_nophoto.jpg"; $j32nama = "-"; $j32nip = "-"; $j32plt = "";
      $j4photo = "sotk_nophoto.jpg"; $j4nama = "-"; $j4nip = "-"; $j4plt = "";
      $j41photo = "sotk_nophoto.jpg"; $j41nama = "-"; $j41nip = "-"; $j41plt = "";
      $j42photo = "sotk_nophoto.jpg"; $j42nama = "-"; $j42nip = "-"; $j42plt = "";
      $j6photo = "sotk_nophoto.jpg"; $j6nama = "-"; $j6nip = "-"; $j6plt = "";
      $j61photo = "sotk_nophoto.jpg"; $j61nama = "-"; $j61nip = "-"; $j61plt = "";
      $j62photo = "sotk_nophoto.jpg"; $j62nama = "-"; $j62nip = "-"; $j62plt = "";


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
        }else if ($nmjab == $j6) {
            $j6nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j6nip = $key->nip;
            $j6photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j6plt = " (PLT)";}
        }else if ($nmjab == $j61) {
            $j61nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j61nip = $key->nip;
            $j61photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j61plt = " (PLT)";}
        }else if ($nmjab == $j62) {
            $j62nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j62nip = $key->nip;
            $j62photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j62plt = " (PLT)";}
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
      $this->setXY(15,2.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,15.05,2.55,'1.4','1.9','jpg','');
      $this->setXY(16.5,2.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.333,$j1t.$j1plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(16.5,3.5);
      $this->MULTICELL(4.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(16.5,4);
      $this->MULTICELL(4.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,23.55,5.05,'1.4','1.9','jpg','');
      $this->setXY(25,5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(25,6);
      $this->MULTICELL(4.5,0.5,$j2nama,'LRT','C',0);
      $this->setXY(25,6.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j2nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(18.5,7.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j21photo,18.55,7.55,'1.4','1.9','jpg','');
      $this->setXY(20,7.5);
      $this->setFont('arial','',8);
      if ($j21plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.333,$j21t.$j21plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.333,$j21t.$j21plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(20,8.5);
      $this->MULTICELL(3.5,0.5,$j21nama,'LRT','C',0);
	  $this->setXY(20,9);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j21nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29.5,7.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j23photo,29.55,7.55,'1.4','1.9','jpg','');
      $this->setXY(31,7.5);
      $this->setFont('arial','',8);
      if ($j23plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j23t.$j23plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.5,$j23t.$j23plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(31,8.5);
      $this->MULTICELL(3.5,0.5,$j23nama,'LRT','C',0);
      $this->setXY(31,9);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j23nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,2.05,10.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j3t.$j3plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(3.5,11.25);
      $this->MULTICELL(5.5,0.5,$j3nama,'LRT','C',0);
      $this->setXY(3.5,11.75);
      $this->MULTICELL(5.5,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j31photo,2.05,13.05,'1.4','1.9','jpg','');
      $this->setXY(3.5,13);
      $this->setFont('arial','',8);
      if ($j31plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.5,$j31t.$j31plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.5,$j31t.$j31plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,14);
      $this->MULTICELL(5.5,0.5,$j31nama,'LRT','C',0);
      $this->setXY(3.5,14.5);
      $this->MULTICELL(5.5,0.5,$j31nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j32photo,2.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,15.25);
      $this->setFont('arial','',8);
      if ($j32plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.5,$j32t.$j32plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.5,$j32t.$j32plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,16.25);
      $this->MULTICELL(5.5,0.5,$j32nama,'LRT','C',0);
      $this->setXY(3.5,16.75);
      $this->MULTICELL(5.5,0.5,$j32nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(10.5,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j4photo,10.55,10.30,'1.4','1.9','jpg','');
      $this->setXY(12,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,1,$j4t.$j4plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(12,11.25);
      $this->MULTICELL(5.5,0.5,$j4nama,'LRT','C',0);
      $this->setXY(12,11.75);
      $this->MULTICELL(5.5,0.5,$j4nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(10.5,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j41photo,10.55,13.05,'1.4','1.9','jpg','');
      $this->setXY(12,13);
      $this->setFont('arial','',6);
      if ($j41plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.333,$j41t.$j41plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.333,$j41t.$j41plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(12,14);
      $this->MULTICELL(5.5,0.5,$j41nama,'LRT','C',0);
      $this->setXY(12,14.5);
      $this->MULTICELL(5.5,0.5,$j41nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(10.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j42photo,10.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(12,15.25);
      $this->setFont('arial','',7);
      if ($j42plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.5,$j42t.$j42plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.5,$j42t.$j42plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(12,16.25);
      $this->MULTICELL(5.5,0.5,$j42nama,'LRT','C',0);
      $this->setXY(12,16.75);
      $this->MULTICELL(5.5,0.5,$j42nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j6photo,27.55,10.30,'1.4','1.9','jpg','');
      $this->setXY(29,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j6t.$j6plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(29,11.25);
      $this->MULTICELL(5.5,0.5,$j6nama,'LRT','C',0);
      $this->setXY(29,11.75);
      $this->MULTICELL(5.5,0.5,$j6nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j61photo,27.55,13.05,'1.4','1.9','jpg','');
      $this->setXY(29,13);
      $this->setFont('arial','',8);
      if ($j61plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.5,$j61t.$j61plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.5,$j61t.$j61plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(29,14);
      $this->MULTICELL(5.5,0.5,$j61nama,'LRT','C',0);
      $this->setXY(29,14.5);
      $this->MULTICELL(5.5,0.5,$j61nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j62photo,27.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(29,15.25);
      $this->setFont('arial','',8);
      if ($j62plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(5.5,0.333,$j62t.$j62plt,1,'C',1);
      }else {
      $this->MULTICELL(5.5,0.333,$j62t.$j62plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(29,16.25);
      $this->MULTICELL(5.5,0.5,$j62nama,'LRT','C',0);
      $this->setXY(29,16.75);
      $this->MULTICELL(5.5,0.5,$j62nip,'LRB','C',0);

      $this->setXY(16.5,20);
      $this->setFont('arial','B',10);
      $this->MULTICELL(3,1,'UPT',1,'C',0);
      $this->setFont('arial','B',10);

	  $this->setXY(8.25,6);
      $this->setFont('arial','B',9);
      $this->MULTICELL(3,0.75,'POKJAFUNG',1,'C',0);
      $this->setFont('arial','',9);
	  $this->setXY(8.25,6.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(9,6.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(9.75,6.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(10.5,6.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(8.25,7.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(9,7.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
 	  $this->setXY(9.75,7.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(10.5,7.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);




      $this->Line(18,4.75,26.5,4.75); // Garis datar antara kepala dgn sekretaris
      $this->Line(26.5,4.75,26.5,5); // Garis datar antara kepala dgn sekretaris

      $this->Line(21,7.25,32,7.25); // Garis datar antara sekretaris dgn subbag
      $this->Line(21,7.25,21,7.5); // Garis tegak antara sekretaris dgn subbag umum
      $this->Line(26.5,7,26.5,7.25); // Garis tegak antara sekretaris dgn subbag program
      $this->Line(32,7.25,32,7.5); // Garis tegak antara sekretaris dgn subbag keuangan

      $this->Line(18,4.5,18,20); // Garis tegak antara kepala dgn bidang
      $this->Line(5.5,10,31,10); // Garis datar antara kepala dgn bidang
      $this->Line(5.5,10,5.5,10.25); // Garis tegak antara kepala dgn bidang rehabilitasi
      $this->Line(14,10,14,10.25); // Garis tegak antara kepala dgn bidang pemberdayaan
      $this->Line(31,10,31,10.25); // Garis tegak antara kepala dgn bidang tenaga kerja

      $this->Line(1.75,12.5,1.75,16.25); // Garis tegak antara bidang rehabilitasi dgn seksi
      $this->Line(5.5,12.25,5.5,12.5); // Garis tegak antara bidang rehabilitasi dgn seksi (pendek)
      $this->Line(1.75,12.5,5.5,12.5); // Garis datar antara bidang rehabilitasi dgn seksi
      $this->Line(1.75,14,2,14); // Garis datar antara bidang rehabilitasi dgn seksi pelayanan bantuan korban
      $this->Line(1.75,16.25,2,16.25); // Garis datar antara bidang rehabilitasi dgn seksi pelayanan dan rehabilitasi

      $this->Line(10.25,12.5,10.25,16.25); // Garis tegak antara bidang pemberdayaan dgn seksi
      $this->Line(14,12.25,14,12.5); // Garis tegak antara bidang pemberdayaan dgn seksi (pendek)
      $this->Line(10.25,12.5,14,12.5); // Garis datar antara bidang pemberdayaan dgn seksi
      $this->Line(10.25,14,10.5,14); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan panti
      $this->Line(10.25,16.25,10.5,16.25); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan tenaga kessos

      $this->Line(27.25,12.5,27.25,16.25); // Garis tegak antara bidang nakertrans dgn seksi
      $this->Line(31,12.25,31,12.5); // Garis tegak antara bidang nakertrans dgn seksi (pendek)
      $this->Line(27.25,12.5,31,12.5); // Garis datar antara bidang nakertrans dgn seksi
      $this->Line(27.25,14,27.5,14); // Garis datar antara bidang nakertrans dgn seksi penempatan
      $this->Line(27.25,16.25,27.5,16.25); // Garis datar antara bidang nakertrans dgn seksi hubungan industri

      $this->Line(9.75,5.75,9.75,6); // Garis tegak antara kepala dgn jabfung
      $this->Line(9.75,5.75,18,5.75); // Garis datar antara kepala dgn jabfung

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
$pdf->Output('sotk dispppa.pdf', 'I');
