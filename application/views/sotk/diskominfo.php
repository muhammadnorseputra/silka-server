<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "DINAS KOMUNIKASI DAN INFORMATIKA";
      $j1 = "KEPALA";
      $j1t = "DINAS KOMUNIKASI DAN INFORMATIKA";

      $j2 = "SEKRETARIS";
      $j2t = "SEKRETARIAT";
      $j21 = "KEPALA SUB BAGIAN PERENCANAAN DAN PELAPORAN";
      $j21t = "SUB BAGIAN PERENCANAAN DAN PELAPORAN";
      $j22 = "KEPALA SUB BAGIAN KEUANGAN";
      $j22t = "SUB BAGIAN KEUANGAN";
      $j23 = "KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN";
      $j23t = "SUB BAGIAN UMUM DAN KEPEGAWAIAN";

      $j3 = "KEPALA BIDANG STATISTIK SEKTORAL";
      $j3t = "BIDANG STATISTIK SEKTORAL";
      $j31 = "KEPALA SEKSI PENGELOLAAN DATA STATISTIK INFRASTRUKTUR";
      $j31t = "SEKSI PENGELOLAAN DATA STATISTIK INFRASTRUKTUR";
      $j32 = "KEPALA SEKSI PENGELOLAAN DATA STATISTIK EKONOMI";
      $j32t = "SEKSI PENGELOLAAN DATA STATISTIK EKONOMI";
      $j33 = "KEPALA SEKSI PENGELOLAAN DATA STATISTIK SOSIAL BUDAYA";
      $j33t = "SEKSI PENGELOLAAN DATA STATISTIK SOSIAL BUDAYA";

      $j4 = "KEPALA BIDANG PENGELOLAAN INFORMASI DAN SALURAN KOMUNIKASI PUBLIK";
      $j4t = "BIDANG PENGELOLAAN INFORMASI DAN SALURAN KOMUNIKASI PUBLIK";
      $j41 = "KEPALA SEKSI PENGELOLAAN ASPIRASI PUBLIK";
      $j41t = "SEKSI PENGELOLAAN ASPIRASI PUBLIK";
      $j42 = "KEPALA SEKSI PRODUKSI DAN REPRODUKSI INFORMASI";
      $j42t = "SEKSI PRODUKSI DAN REPRODUKSI INFORMASI";
      $j43 = "KEPALA SEKSI PENGELOLAAN SALURAN KOMUNIKASI PUBLIK";
      $j43t = "SEKSI PENGELOLAAN SALURAN KOMUNIKASI PUBLIK";

      $j5 = "KEPALA BIDANG PENGEMBANGAN KOMUNIKASI PUBLIK";
      $j5t = "BIDANG PENGEMBANGAN KOMUNIKASI PUBLIK";
      $j51 = "KEPALA SEKSI KEMITRAAN KOMUNIKASI PUBLIK";
      $j51t = "SEKSI KEMITRAAN KOMUNIKASI PUBLIK";
      $j52 = "KEPALA SEKSI PELAYANAN INFORMASI PUBLIK";
      $j52t = "SEKSI PELAYANAN INFORMASI PUBLIK";
      $j53 = "KEPALA SEKSI PENGELOLAAN KOMUNIKASI";
      $j53t = "SEKSI PENGELOLAAN KOMUNIKASI";

      $j6 = "KEPALA BIDANG PENGELOLAAN INFRASTRUKTUR E-GOVERNMENT";
      $j6t = "BIDANG PENGELOLAAN INFRASTRUKTUR E-GOVERNMENT";
      $j61 = "KEPALA SEKSI INFRASTRUKTUR DAN TEKNOLOGI";
      $j61t = "SEKSI INFRASTRUKTUR DAN TEKNOLOGI";
      $j62 = "KEPALA SEKSI PENGELOLAAN DATA DAN INTEROPERABILITAS";
      $j62t = "SEKSI PENGELOLAAN DATA DAN INTEROPERABILITAS";
      $j63 = "KEPALA SEKSI KEAMANAN INFORMASI DAN PERSANDIAN";
      $j63t = "SEKSI KEAMANAN INFORMASI DAN PERSANDIAN";

      $j7 = "KEPALA BIDANG LAYANAN E-GOVERNMENT";
      $j7t = "BIDANG LAYANAN E-GOVERNMENT";
      $j71 = "KEPALA SEKSI TATA KELOLA E-GOVERNMENT";
      $j71t = "SEKSI TATA KELOLA E-GOVERNMENT";
      $j72 = "KEPALA SEKSI PENGEMBANGAN APLIKASI PUBLIK";
      $j72t = "SEKSI PENGEMBANGAN APLIKASI PUBLIK";
      $j73 = "KEPALA SEKSI PENGEMBANGAN APLIKASI KEPEMERINTAHAN";
      $j73t = "SEKSI PENGEMBANGAN APLIKASI KEPEMERINTAHAN";

      $j1photo = "sotk_nophoto.jpg"; $j1nama = "-"; $j1nip = "-"; $j1plt = "";
      $j2photo = "sotk_nophoto.jpg"; $j2nama = "-"; $j2nip = "-"; $j2plt = "";
      $j21photo = "sotk_nophoto.jpg"; $j21nama = "-"; $j21nip = "-"; $j21plt = "";
      $j22photo = "sotk_nophoto.jpg"; $j22nama = "-"; $j22nip = "-"; $j22plt = "";
      $j23photo = "sotk_nophoto.jpg"; $j23nama = "-"; $j23nip = "-"; $j23plt = "";
      $j3photo = "sotk_nophoto.jpg"; $j3nama = "-"; $j3nip = "-"; $j3plt = "";
      $j31photo = "sotk_nophoto.jpg"; $j31nama = "-"; $j31nip = "-"; $j31plt = "";
      $j32photo = "sotk_nophoto.jpg"; $j32nama = "-"; $j32nip = "-"; $j32plt = "";
      $j33photo = "sotk_nophoto.jpg"; $j33nama = "-"; $j33nip = "-"; $j33plt = "";
      $j4photo = "sotk_nophoto.jpg"; $j4nama = "-"; $j4nip = "-"; $j4plt = "";
      $j41photo = "sotk_nophoto.jpg"; $j41nama = "-"; $j41nip = "-"; $j41plt = "";
      $j42photo = "sotk_nophoto.jpg"; $j42nama = "-"; $j42nip = "-"; $j42plt = "";
      $j43photo = "sotk_nophoto.jpg"; $j43nama = "-"; $j43nip = "-"; $j43plt = "";
      $j5photo = "sotk_nophoto.jpg"; $j5nama = "-"; $j5nip = "-"; $j5plt = "";
      $j51photo = "sotk_nophoto.jpg"; $j51nama = "-"; $j51nip = "-"; $j51plt = "";
      $j52photo = "sotk_nophoto.jpg"; $j52nama = "-"; $j52nip = "-"; $j52plt = "";
      $j53photo = "sotk_nophoto.jpg"; $j53nama = "-"; $j53nip = "-"; $j53plt = "";
      $j6photo = "sotk_nophoto.jpg"; $j6nama = "-"; $j6nip = "-"; $j6plt = "";
      $j61photo = "sotk_nophoto.jpg"; $j61nama = "-"; $j61nip = "-"; $j61plt = "";
      $j62photo = "sotk_nophoto.jpg"; $j62nama = "-"; $j62nip = "-"; $j62plt = "";
      $j63photo = "sotk_nophoto.jpg"; $j63nama = "-"; $j63nip = "-"; $j63plt = "";
      $j7photo = "sotk_nophoto.jpg"; $j7nama = "-"; $j7nip = "-"; $j7plt = "";
      $j71photo = "sotk_nophoto.jpg"; $j71nama = "-"; $j71nip = "-"; $j71plt = "";
      $j72photo = "sotk_nophoto.jpg"; $j72nama = "-"; $j72nip = "-"; $j72plt = "";
      $j73photo = "sotk_nophoto.jpg"; $j73nama = "-"; $j73nip = "-"; $j73plt = "";


      $sqlpeg = mysql_query("select * from pegawai as p, ref_unit_kerjav2 as u
                             where p.fid_unit_kerja = u.id_unit_kerja
                             and u.nama_unit_kerja = '".$unker."'");

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
        }else if ($nmjab == $j33) {
            $j33nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j33nip = $key->nip;
            $j33photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j33plt = " (PLT)";}
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
        }else if ($nmjab == $j43) {
            $j43nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j43nip = $key->nip;
            $j43photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j43plt = " (PLT)";}
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
        }else if ($nmjab == $j53) {
            $j53nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j53nip = $key->nip;
            $j53photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j53plt = " (PLT)";}
        }else if ($nmjab == $j6) {
            $j6nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j6nip = $key->nip;
            $j6photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j6plt = " (PLT)";}
        }else if ($nmjab == $j61) {
            $j61nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j61nip = $key->nip;
            $j61photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j61plt = " (PLT)";}
        }else if ($nmjab == $j62) {
            $j62nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j62nip = $key->nip;
            $j62photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j62plt = " (PLT)";}
        }else if ($nmjab == $j63) {
            $j63nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j63nip = $key->nip;
            $j63photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j63plt = " (PLT)";}
        }else if ($nmjab == $j7) {
            $j7nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j7nip = $key->nip;
            $j7photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j7plt = " (PLT)";}
        }else if ($nmjab == $j71) {
            $j71nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j71nip = $key->nip;
            $j71photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j71plt = " (PLT)";}
        }else if ($nmjab == $j72) {
            $j72nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j72nip = $key->nip;
            $j72photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j72plt = " (PLT)";}
        }else if ($nmjab == $j73) {
            $j73nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j73nip = $key->nip;
            $j73photo = cekphotopns($key->nip);
            if ($key->plt == "YA") {$j73plt = " (PLT)";}
        }
      }

       $pltcl = "210,210,210";

      $this->setAutoPageBreak(false);
      $this->setFont('courier','',11);
      // text (left margin, top margin)
      $this->Image('assets/logo.jpg','2','1','1.5','2','jpg','');
      $this->setFont('courier','B',12);
      $this->text(4,1.3,'BAGAN STRUKTUR ORGANISASI');
      $this->text(4,1.8,$unker);
      $this->setFont('arial','B',8);
      $this->text(4,2.3,'Tgl. Cetak : '. date('d-m-Y'));
      $this->text(4,2.8,'SILKa Online ::: BKPPD Kab. Balangan All rights reserved');


      $this->setFont('arial','',9);
      $this->setXY(12,2.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,12.05,2.55,'1.4','1.9','jpg','');
      $this->setXY(13.5,2.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.5,$j1t.$j1plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(13.5,3.5);
      $this->MULTICELL(4.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(13.5,4);
      $this->MULTICELL(4.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,23.55,5.05,'1.4','1.9','jpg','');
      $this->setXY(25,5);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,1,$j2t.$j2plt,1,'C',0);
      $this->setFont('arial','',7.5);
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
      $this->setFont('arial','',7);
      if ($j21plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.334,$j21t.$j21plt,1,'C',1);
      }else {
      $this->MULTICELL(3.5,0.334,$j21t.$j21plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(20,8.5);
      $this->MULTICELL(3.5,0.5,$j21nama,'LRT','C',0);
	  $this->setXY(20,9);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j21nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(24,7.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j22photo,24.05,7.55,'1.4','1.9','jpg','');
      $this->setXY(25.5,7.5);
      $this->setFont('arial','',8);
      if ($j22plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(3.5,0.5,$j22t.$j22plt,1,'C',1);
      }
      else {
      $this->MULTICELL(3.5,0.5,$j22t.$j22plt,1,'C',0);
      }
      $this->setFont('arial','',6);
      $this->setXY(25.5,8.5);
      $this->MULTICELL(3.5,0.33,$j22nama,'LRT','C',0);
      $this->setXY(25.5,9);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j22nip,'LRB','C',0);

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
      $this->setFont('arial','',7);
      $this->setXY(31,8.5);
      $this->MULTICELL(3.5,0.333,$j23nama,'LRT','C',0);
      $this->setXY(31,9);
      $this->setFont('arial','',8);
      $this->MULTICELL(3.5,0.5,$j23nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,2.05,10.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(4,0.5,$j3t.$j3plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(3.5,11.25);
      $this->MULTICELL(4,0.5,$j3nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(3.5,11.75);
      $this->MULTICELL(4,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j31photo,2.05,13.05,'1.4','1.9','jpg','');
      $this->setXY(3.5,13);
      $this->setFont('arial','',7.5);
      if ($j31plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j31t.$j31plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j31t.$j31plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,14);
      $this->MULTICELL(4,0.5,$j31nama,'LRT','C',0);
      $this->setXY(3.5,14.5);
      $this->MULTICELL(4,0.5,$j31nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j32photo,2.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(3.5,15.25);
      $this->setFont('arial','',8);
      if ($j32plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j32t.$j32plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j32t.$j32plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(3.5,16.25);
      $this->MULTICELL(4,0.5,$j32nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(3.5,16.75);
      $this->MULTICELL(4,0.5,$j32nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(2,17.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j33photo,2.05,17.55,'1.4','1.9','jpg','');
      $this->setXY(3.5,17.5);
      $this->setFont('arial','',8);
      if ($j33plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.333,$j33t.$j33plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.333,$j33t.$j33plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(3.5,18.5);
      $this->MULTICELL(4,0.5,$j33nama,'LRT','C',0);
      $this->setXY(3.5,19);
      $this->MULTICELL(4,0.5,$j33nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(8.5,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j4photo,8.55,10.30,'1.4','1.9','jpg','');
      $this->setXY(10,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(4,0.333,$j4t.$j4plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(10,11.25);
      $this->MULTICELL(4,0.33,$j4nama,'LRT','C',0);
      $this->setXY(10,11.75);
      $this->MULTICELL(4,0.5,$j4nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(8.5,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j41photo,8.55,13.05,'1.4','1.9','jpg','');
      $this->setXY(10,13);
      $this->setFont('arial','',8);
      if ($j41plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j41t.$j41plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j41t.$j41plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(10,14);
      $this->MULTICELL(4,0.334,$j41nama,'LRT','C',0);
      $this->setXY(10,14.5);
      $this->MULTICELL(4,0.5,$j41nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(8.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j42photo,8.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(10,15.25);
      $this->setFont('arial','',8);
      if ($j42plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j42t.$j42plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j42t.$j42plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(10,16.25);
      $this->MULTICELL(4,0.5,$j42nama,'LRT','C',0);
      $this->setXY(10,16.75);
      $this->MULTICELL(4,0.5,$j42nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(8.5,17.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j43photo,8.55,17.55,'1.4','1.9','jpg','');
      $this->setXY(10,17.5);
      $this->setFont('arial','',8);
      if ($j43plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.333,$j43t.$j43plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.333,$j43t.$j43plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(10,18.5);
      $this->MULTICELL(4,0.5,$j43nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(10,19);
      $this->MULTICELL(4,0.5,$j43nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(16,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j5photo,16.05,10.30,'1.4','1.9','jpg','');
      $this->setXY(17.5,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(4,0.5,$j5t.$j5plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(17.5,11.25);
      $this->MULTICELL(4,0.5,$j5nama,'LRT','C',0);
      $this->setXY(17.5,11.75);
      $this->MULTICELL(4,0.5,$j5nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(16,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j51photo,16.05,13.05,'1.4','1.9','jpg','');
      $this->setXY(17.5,13);
      $this->setFont('arial','',8);
      if ($j51plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j51t.$j51plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j51t.$j51plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(17.5,14);
      $this->MULTICELL(4,0.5,$j51nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(17.5,14.5);
      $this->MULTICELL(4,0.5,$j51nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(16,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j52photo,16.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(17.5,15.25);
      $this->setFont('arial','',8);
      if ($j52plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j52t.$j52plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j52t.$j52plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(17.5,16.25);
      $this->MULTICELL(4,0.5,$j52nama,'LRT','C',0);
      $this->setXY(17.5,16.75);
      $this->MULTICELL(4,0.5,$j52nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(16,17.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j53photo,16.05,17.55,'1.4','1.9','jpg','');
      $this->setXY(17.5,17.5);
      $this->setFont('arial','',8);
      if ($j53plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j53t.$j53plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j53t.$j53plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(17.5,18.5);
      $this->MULTICELL(4,0.5,$j53nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(17.5,19);
      $this->MULTICELL(4,0.5,$j53nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22.5,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j6photo,22.55,10.30,'1.4','1.9','jpg','');
      $this->setXY(24,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(4,0.33,$j6t.$j6plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(24,11.25);
      $this->MULTICELL(4,0.5,$j6nama,'LRT','C',0);
      $this->setXY(24,11.75);
      $this->MULTICELL(4,0.5,$j6nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22.5,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j61photo,22.55,13.05,'1.4','1.9','jpg','');
      $this->setXY(24,13);
      $this->setFont('arial','',8);
      if ($j61plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j61t.$j61plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j61t.$j61plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(24,14);
      $this->MULTICELL(4,0.5,$j61nama,'LRT','C',0);
      $this->setXY(24,14.5);
      $this->MULTICELL(4,0.5,$j61nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22.5,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j62photo,22.55,15.30,'1.4','1.9','jpg','');
      $this->setXY(24,15.25);
      $this->setFont('arial','',8);
      if ($j62plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.333,$j62t.$j62plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.333,$j62t.$j62plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(24,16.25);
      $this->MULTICELL(4,0.5,$j62nama,'LRT','C',0);
      $this->setXY(24,16.75);
      $this->MULTICELL(4,0.5,$j62nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22.5,17.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j63photo,22.55,17.55,'1.4','1.9','jpg','');
      $this->setXY(24,17.5);
      $this->setFont('arial','',8);
      if ($j63plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.333,$j63t.$j63plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.333,$j63t.$j63plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(24,18.5);
      $this->MULTICELL(4,0.5,$j63nama,'LRT','C',0);
      $this->setXY(24,19);
      $this->MULTICELL(4,0.5,$j63nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29,10.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j7photo,29.05,10.30,'1.4','1.9','jpg','');
      $this->setXY(30.5,10.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(4,0.5,$j7t.$j7plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(30.5,11.25);
      $this->MULTICELL(4,0.5,$j7nama,'LRT','C',0);
      $this->setXY(30.5,11.75);
      $this->MULTICELL(4,0.5,$j7nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29,13);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j71photo,29.05,13.05,'1.4','1.9','jpg','');
      $this->setXY(30.5,13);
      $this->setFont('arial','',8);
      if ($j71plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j71t.$j71plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j71t.$j71plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(30.5,14);
      $this->MULTICELL(4,0.5,$j71nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(30.5,14.5);
      $this->MULTICELL(4,0.5,$j71nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j72photo,29.05,15.30,'1.4','1.9','jpg','');
      $this->setXY(30.5,15.25);
      $this->setFont('arial','',8);
      if ($j72plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.5,$j72t.$j72plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.5,$j72t.$j72plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(30.5,16.25);
      $this->MULTICELL(4,0.5,$j72nama,'LRT','C',0);
      $this->setXY(30.5,16.75);
      $this->MULTICELL(4,0.5,$j72nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(29,17.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j73photo,29.05,17.55,'1.4','1.9','jpg','');
      $this->setXY(30.5,17.5);
      $this->setFont('arial','',8);
      if ($j73plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(4,0.333,$j73t.$j73plt,1,'C',1);
      }else {
      $this->MULTICELL(4,0.333,$j73t.$j73plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(30.5,18.5);
      $this->MULTICELL(4,0.5,$j73nama,'LRT','C',0);
      $this->setXY(30.5,19);
      $this->MULTICELL(4,0.5,$j73nip,'LRB','C',0);


      $this->setXY(13.5,20);
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




      $this->Line(15,4.75,26.5,4.75); // Garis datar antara kepala dgn sekretaris
      $this->Line(26.5,4.75,26.5,5); // Garis datar antara kepala dgn sekretaris

      $this->Line(21,7.25,32,7.25); // Garis datar antara sekretaris dgn subbag
      $this->Line(21,7.25,21,7.5); // Garis tegak antara sekretaris dgn subbag umum
      $this->Line(26.5,7,26.5,7.5); // Garis tegak antara sekretaris dgn subbag program
      $this->Line(32,7.25,32,7.5); // Garis tegak antara sekretaris dgn subbag keuangan

      $this->Line(15,4.5,15,20); // Garis tegak antara kepala dgn bidang
      $this->Line(5,10,32,10); // Garis datar antara kepala dgn bidang
      $this->Line(5,10,5,10.25); // Garis tegak antara kepala dgn bidang rehabilitasi
      $this->Line(11.5,10,11.5,10.25); // Garis tegak antara kepala dgn bidang pemberdayaan
      $this->Line(19,10,19,10.25); // Garis tegak antara kepala dgn bidang kependudukan
      $this->Line(25.5,10,25.5,10.25); // Garis tegak antara kepala dgn bidang kependudukan
      $this->Line(32,10,32,10.25); // Garis tegak antara kepala dgn bidang tenaga kerja

      $this->Line(1.75,12.5,1.75,18.5); // Garis tegak antara bidang rehabilitasi dgn seksi
      $this->Line(5,12.25,5,12.5); // Garis tegak antara bidang rehabilitasi dgn seksi (pendek)
      $this->Line(1.75,12.5,5,12.5); // Garis datar antara bidang rehabilitasi dgn seksi
      $this->Line(1.75,14,2,14); // Garis datar antara bidang rehabilitasi dgn seksi pelayanan bantuan korban
      $this->Line(1.75,16.25,2,16.25); // Garis datar antara bidang rehabilitasi dgn seksi pelayanan dan rehabilitasi
      $this->Line(1.75,18.5,2,18.5); // Garis datar antara bidang rehabilitasi dgn seksi pembinaan dan pemberdayaan

      $this->Line(8.25,12.5,8.25,18.5); // Garis tegak antara bidang pemberdayaan dgn seksi
      $this->Line(11.5,12.25,11.5,12.5); // Garis tegak antara bidang pemberdayaan dgn seksi (pendek)
      $this->Line(8.25,12.5,11.5,12.5); // Garis datar antara bidang pemberdayaan dgn seksi
      $this->Line(8.25,14,8.5,14); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan panti
      $this->Line(8.25,16.25,8.5,16.25); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan tenaga kessos
      $this->Line(8.25,18.5,8.5,18.5); // Garis datar antara bidang pemberdayaan dgn seksi pemberdayyan sosial

      $this->Line(15.75,12.5,15.75,18.5); // Garis tegak antara bidang pemberdayaan dgn seksi
      $this->Line(19,12.25,19,12.5); // Garis tegak antara bidang pemberdayaan dgn seksi (pendek)
      $this->Line(15.75,12.5,19,12.5); // Garis datar antara bidang pemberdayaan dgn seksi
      $this->Line(15.75,14,16,14); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan panti
      $this->Line(15.75,16.25,16,16.25); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan tenaga kessos
      $this->Line(15.75,18.5,16,18.5); // Garis datar antara bidang pemberdayaan dgn seksi pemberdayyan sosial

      $this->Line(22.25,12.5,22.25,18.5); // Garis tegak antara bidang pemberdayaan dgn seksi
      $this->Line(25.5,12.25,25.5,12.5); // Garis tegak antara bidang pemberdayaan dgn seksi (pendek)
      $this->Line(22.25,12.5,25.5,12.5); // Garis datar antara bidang pemberdayaan dgn seksi
      $this->Line(22.25,14,22.5,14); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan panti
      $this->Line(22.25,16.25,22.5,16.25); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan tenaga kessos
      $this->Line(22.25,18.5,22.5,18.5); // Garis datar antara bidang pemberdayaan dgn seksi pemberdayyan sosial

      $this->Line(28.75,12.5,28.75,18.5); // Garis tegak antara bidang pemberdayaan dgn seksi
      $this->Line(32,12.25,32,12.5); // Garis tegak antara bidang pemberdayaan dgn seksi (pendek)
      $this->Line(28.75,12.5,32,12.5); // Garis datar antara bidang pemberdayaan dgn seksi
      $this->Line(28.75,14,29,14); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan panti
      $this->Line(28.75,16.25,29,16.25); // Garis datar antara bidang pemberdayaan dgn seksi pembinaan tenaga kessos
      $this->Line(28.75,18.5,29,18.5); // Garis datar antara bidang pemberdayaan dgn seksi pemberdayyan sosial
      /*
      $this->Line(18.75,12.5,18.75,18.5); // Garis tegak antara bidang kependudukan dgn seksi
      $this->Line(22.5,12.25,22.5,12.5); // Garis tegak antara bidang kependudukan dgn seksi (pendek)
      $this->Line(18.75,12.5,22.5,12.5); // Garis datar antara bidang kependudukan dgn seksi
      $this->Line(18.75,14,19,14); // Garis datar antara bidang kependudukan dgn seksi administrasi
      $this->Line(18.75,16.25,19,16.25); // Garis datar antara bidang kependudukan dgn seksi pelayanan catpil
      $this->Line(18.75,18.5,19,18.5); // Garis datar antara bidang kependudukan dgn seksi pelayanan siak

      $this->Line(27.25,12.5,27.25,18.5); // Garis tegak antara bidang nakertrans dgn seksi
      $this->Line(31,12.25,31,12.5); // Garis tegak antara bidang nakertrans dgn seksi (pendek)
      $this->Line(27.25,12.5,31,12.5); // Garis datar antara bidang nakertrans dgn seksi
      $this->Line(27.25,14,27.5,14); // Garis datar antara bidang nakertrans dgn seksi penempatan
      $this->Line(27.25,16.25,27.5,16.25); // Garis datar antara bidang nakertrans dgn seksi hubungan industri
      $this->Line(27.25,18.5,27.5,18.5); // Garis datar antara bidang nakertrans dgn seksi transmmigrasi
      */
      $this->Line(9.75,5.75,9.75,6); // Garis tegak antara kepala dgn jabfung
      $this->Line(9.75,5.75,15,5.75); // Garis datar antara kepala dgn jabfung
    
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
$pdf->Output('sotk diskominfo.pdf', 'I');
