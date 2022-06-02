<?php

class PDF extends FPDF
{     
    //Page header
  function Header()
  {                    
  }

  function Content($data)
  {
      $unker = "SEKRETARIAT DAERAH";
      $j1 = "SEKRETARIS DAERAH";
      $j1t = "SEKRETARIAT DAERAH";

      $j2 = "ASISTEN PEMERINTAHAN DAN KESEJAHTERAAN RAKYAT";
      $j2t = "ASISTEN PEMERINTAHAN DAN KESEJAHTERAAN RAKYAT";
      $j21 = "KEPALA BAGIAN PEMERINTAHAN";
      $j21t = "BAGIAN PEMERINTAHAN";
      $j211 = "KEPALA SUB BAGIAN ADMINISTRASI PEMERINTAHAN";
      $j211t = "SUB BAGIAN ADMINISTRASI PEMERINTAHAN";
      $j212 = "KEPALA SUB BAGIAN ADMINISTRASI KEWILAYAHAN";
      $j212t = "SUB BAGIAN ADMINISTRASI KEWILAYAHAN";
      $j213 = "KEPALA SUB BAGIAN KERJASAMA DAN OTONOMI DAERAH";
      $j213t = "SUB BAGIAN KERJASAMA DAN OTONOMI DAERAH";
      $j22 = "KEPALA BAGIAN KESEJAHTERAAN RAKYAT";
      $j22t = "BAGIAN KESEJAHTERAAN RAKYAT";
      $j221 = "KEPALA SUB BAGIAN BINA MENTAL SPRITUAL";
      $j221t = "SUB BAGIAN BINA MENTAL SPRITUAL";
      $j222 = "KEPALA SUB BAGIAN KESEJAHTERAAN SOSIAL";
      $j222t = "SUB BAGIAN KESEJAHTERAAN SOSIAL";
      $j223 = "KEPALA SUB BAGIAN KESEJAHTERAAN MASYARAKAT";
      $j223t = "SUB BAGIAN KESEJAHTERAAN MASYARAKAT";

      $j23 = "KEPALA BAGIAN HUKUM";
      $j23t = "BAGIAN HUKUM";
      $j231 = "KEPALA SUB BAGIAN PERUNDANG-UNDANGAN";
      $j231t = "SUB BAGIAN PERUNDANG- UNDANGAN";
      $j232 = "KEPALA SUB BAGIAN BANTUAN HUKUM";
      $j232t = "SUB BAGIAN BANTUAN HUKUM";
      $j233 = "KEPALA SUB BAGIAN DOKUMENTASI DAN INFORMASI";
      $j233t = "SUB BAGIAN DOKUMENTASI DAN INFORMASI";

      $j3 = "ASISTEN PEREKONOMIAN DAN PEMBANGUNAN";
      $j3t = "ASISTEN PEREKONOMIAN DAN PEMBANGUNAN";
      $j31 = "KEPALA BAGIAN PEREKONOMIAN DAN SUMBER DAYA ALAM";
      $j31t = "BAGIAN PEREKONOMIAN DAN SUMBER DAYA ALAM";
      $j311 = "KEPALA SUB BAGIAN PEMBINAAN BUMD DAN BLUD";
      $j311t = "SUB BAGIAN PEMBINAAN BUMD DAN BLUD";
      $j312 = "KEPALA SUB BAGIAN PEREKONOMIAN";
      $j312t = "SUB BAGIAN PEREKONOMIAN";
      $j313 = "KEPALA SUB BAGIAN SUMBER DAYA ALAM";
      $j313t = "SUB BAGIAN SUMBER DAYA ALAM";	

      $j32 = "KEPALA BAGIAN ADMINISTRASI PEMBANGUNAN";
      $j32t = "BAGIAN ADMINISTRASI PEMBANGUNAN";
      $j321 = "KEPALA SUB BAGIAN PENYUSUNAN PROGRAM";
      $j321t = "SUB BAGIAN PENYUSUNAN PROGRAM";
      $j322 = "KEPALA SUB BAGIAN PENGENDALIAN PROGRAM";
      $j322t = "SUB BAGIAN PENGENDALIAN PROGRAM";
      $j323 = "KEPALA SUB BAGIAN EVALUASI DAN PELAPORAN";
      $j323t = "SUB BAGIAN EVALUASI DAN PELAPORAN";

      $j33 = "KEPALA BAGIAN PENGADAAN BARANG DAN JASA";
      $j33t = "BAGIAN PENGADAAN BARANG DAN JASA";
      $j331 = "KEPALA SUB BAGIAN PENGELOLAAN PENGADAAN BARANG DAN JASA";
      $j331t = "SUB BAGIAN PENGELOLAAN PENGADAAN BARANG DAN JASA";
      $j332 = "KEPALA SUB BAGIAN PENGELOLAAN LAYANAN PENGADAAN SECARA ELEKTRONIK";
      $j332t = "SUB BAGIAN PENGELOLAAN LAYANAN PENGADAAN SECARA ELEKTRONIK";
      $j333 = "KEPALA SUB BAGIAN PEMBINAAN DAN ADVOKASI PENGADAAN BARANG DAN JASA";
      $j333t = "SUB BAGIAN PEMBINAAN DAN ADVOKASI PENGADAAN BARANG DAN JASA";

      $j4 = "ASISTEN ADMINISTRASI UMUM";
      $j4t = "ASISTEN ADMINISTRASI UMUM";
      $j41 = "KEPALA BAGIAN UMUM";
      $j41t = "BAGIAN UMUM";
      $j411 = "KEPALA SUB BAGIAN TATA USAHA PIMPINAN, STAF AHLI DAN KEPEGAWAIAN";
      $j411t = "SUB BAGIAN TATA USAHA PIMPINAN, STAF AHLI DAN KEPEGAWAIAN";
      $j412 = "KEPALA SUB BAGIAN KEUANGAN";
      $j412t = "SUB BAGIAN KEUANGAN";
      $j413 = "KEPALA SUB BAGIAN RUMAH TANGGA DAN PERLENGKAPAN";
      $j413t = "SUB BAGIAN RUMAH TANGGA DAN PERLENGKAPAN";
      
      $j42 = "KEPALA BAGIAN ORGANISASI";
      $j42t = "BAGIAN ORGANISASI";
      $j421 = "KEPALA SUB BAGIAN KELEMBAGAAN DAN ANALISIS JABATAN";
      $j421t = "SUB BAGIAN KELEMBAGAAN DAN ANALISIS JABATAN";
      $j422 = "KEPALA SUB BAGIAN PELAYANAN PUBLIK DAN TATA LAKSANA";
      $j422t = "SUB BAGIAN PELAYANAN PUBLIK DAN TATA LAKSANA";
      $j423 = "KEPALA SUB BAGIAN KINERJA DAN REFORMASI BIROKRASI";
      $j423t = "SUB BAGIAN KINERJA DAN REFORMASI BIROKRASI";
      
      $j43 = "KEPALA BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN";
      $j43t = "BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN";
      $j431 = "KEPALA SUB BAGIAN PROTOKOL";
      $j431t = "SUB BAGIAN PROTOKOL";
      $j432 = "KEPALA SUB BAGIAN KOMUNIKASI PIMPINAN";
      $j432t = "SUB BAGIAN KOMUNIKASI PIMPINAN";
      $j433 = "KEPALA SUB BAGIAN DOKUMENTASI PIMPINAN";
      $j433t = "SUB BAGIAN DOKUMENTASI PIMPINAN";

      $j5 = "STAF AHLI BIDANG PEMERINTAHAN, HUKUM DAN POLITIK";
      $j5t = "STAF AHLI BIDANG PEMERINTAHAN, HUKUM DAN POLITIK";
      $j6 = "STAF AHLI BIDANG PEMBANGUNAN, EKONOMI DAN KEUANGAN";
      $j6t = "STAF AHLI BIDANG PEMBANGUNAN, EKONOMI DAN KEUANGAN";
      $j7 = "STAF AHLI BIDANG KEMASYARAKATAN DAN SUMBER DAYA MANUSIA";
      $j7t = "STAF AHLI BIDANG KEMASYARAKATAN DAN SUMBER DAYA MANUSIA";

      $j1photo = "sotk_nophoto.jpg"; $j1nama = "-"; $j1nip = "-"; $j1plt = "";
      $j2photo = "sotk_nophoto.jpg"; $j2nama = "-"; $j2nip = "-"; $j2plt = "";
      $j21photo = "sotk_nophoto.jpg"; $j21nama = "-"; $j21nip = "-"; $j21plt = "";
      $j211photo = "sotk_nophoto.jpg"; $j211nama = "-"; $j211nip = "-"; $j211plt = "";
      $j212photo = "sotk_nophoto.jpg"; $j212nama = "-"; $j212nip = "-"; $j212plt = "";
      $j213photo = "sotk_nophoto.jpg"; $j213nama = "-"; $j213nip = "-"; $j213plt = "";
      $j22photo = "sotk_nophoto.jpg"; $j22nama = "-"; $j22nip = "-"; $j22plt = "";
      $j221photo = "sotk_nophoto.jpg"; $j221nama = "-"; $j221nip = "-"; $j221plt = "";
      $j222photo = "sotk_nophoto.jpg"; $j222nama = "-"; $j222nip = "-"; $j222plt = "";
      $j223photo = "sotk_nophoto.jpg"; $j223nama = "-"; $j223nip = "-"; $j223plt = "";
      $j23photo = "sotk_nophoto.jpg"; $j23nama = "-"; $j23nip = "-"; $j23plt = "";
      $j231photo = "sotk_nophoto.jpg"; $j231nama = "-"; $j231nip = "-"; $j231plt = "";
      $j232photo = "sotk_nophoto.jpg"; $j232nama = "-"; $j232nip = "-"; $j232plt = "";
      $j233photo = "sotk_nophoto.jpg"; $j233nama = "-"; $j233nip = "-"; $j233plt = "";

      $j3photo = "sotk_nophoto.jpg"; $j3nama = "-"; $j3nip = "-"; $j3plt = "";
      $j31photo = "sotk_nophoto.jpg"; $j31nama = "-"; $j31nip = "-"; $j31plt = "";
      $j311photo = "sotk_nophoto.jpg"; $j311nama = "-"; $j311nip = "-"; $j311plt = "";
      $j312photo = "sotk_nophoto.jpg"; $j312nama = "-"; $j312nip = "-"; $j312plt = "";
      $j313photo = "sotk_nophoto.jpg"; $j313nama = "-"; $j313nip = "-"; $j313plt = "";
      $j32photo = "sotk_nophoto.jpg"; $j32nama = "-"; $j32nip = "-"; $j32plt = "";
      $j321photo = "sotk_nophoto.jpg"; $j321nama = "-"; $j321nip = "-"; $j321plt = "";
      $j322photo = "sotk_nophoto.jpg"; $j322nama = "-"; $j322nip = "-"; $j322plt = "";	
      $j323photo = "sotk_nophoto.jpg"; $j323nama = "-"; $j323nip = "-"; $j323plt = "";

      $j33photo = "sotk_nophoto.jpg"; $j33nama = "-"; $j33nip = "-"; $j33plt = "";
      $j331photo = "sotk_nophoto.jpg"; $j331nama = "-"; $j331nip = "-"; $j331plt = "";
      $j332photo = "sotk_nophoto.jpg"; $j332nama = "-"; $j332nip = "-"; $j332plt = "";
      $j333photo = "sotk_nophoto.jpg"; $j333nama = "-"; $j333nip = "-"; $j333plt = "";

      $j4photo = "sotk_nophoto.jpg"; $j4nama = "-"; $j4nip = "-"; $j4plt = "";
      $j41photo = "sotk_nophoto.jpg"; $j41nama = "-"; $j41nip = "-"; $j41plt = "";
      $j411photo = "sotk_nophoto.jpg"; $j411nama = "-"; $j411nip = "-"; $j411plt = "";
      $j412photo = "sotk_nophoto.jpg"; $j412nama = "-"; $j412nip = "-"; $j412plt = "";
      $j413photo = "sotk_nophoto.jpg"; $j413nama = "-"; $j413nip = "-"; $j413plt = "";
      $j42photo = "sotk_nophoto.jpg"; $j42nama = "-"; $j42nip = "-"; $j42plt = "";
      $j421photo = "sotk_nophoto.jpg"; $j421nama = "-"; $j421nip = "-"; $j421plt = "";
      $j422photo = "sotk_nophoto.jpg"; $j422nama = "-"; $j422nip = "-"; $j422plt = "";
      $j423photo = "sotk_nophoto.jpg"; $j423nama = "-"; $j423nip = "-"; $j423plt = "";
      $j43photo = "sotk_nophoto.jpg"; $j43nama = "-"; $j43nip = "-"; $j43plt = "";
      $j431photo = "sotk_nophoto.jpg"; $j431nama = "-"; $j431nip = "-"; $j431plt = "";
      $j432photo = "sotk_nophoto.jpg"; $j432nama = "-"; $j432nip = "-"; $j432plt = "";
      $j433photo = "sotk_nophoto.jpg"; $j433nama = "-"; $j433nip = "-"; $j433plt = "";

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
            //	if ($key->plt == "YA") {$j1plt = " (PLT)";}
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
        }else if ($nmjab == $j211) {
            $j211nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j211nip = $key->nip;
            $j211photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j211plt = " (PLT)";}
        }else if ($nmjab == $j212) {
            $j212nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j212nip = $key->nip;
            $j212photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j212plt = " (PLT)";}
        }else if ($nmjab == $j213) {
            $j213nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j213nip = $key->nip;
            $j213photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j213plt = " (PLT)";}
        }else if ($nmjab == $j22) {
            $j22nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j22nip = $key->nip;
            $j22photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j22plt = " (PLT)";}
        }else if ($nmjab == $j221) {
            $j221nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j221nip = $key->nip;
            $j221photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j221plt = " (PLT)";}
        }else if ($nmjab == $j222) {
            $j222nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j222nip = $key->nip;
            $j222photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j222plt = " (PLT)";}
        }else if ($nmjab == $j223) {
            $j223nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j223nip = $key->nip;
            $j223photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j223plt = " (PLT)";}
        }else if ($nmjab == $j23) {
            $j23nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j23nip = $key->nip;
            $j23photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j23plt = " (PLT)";}
        }else if ($nmjab == $j231) {
            $j231nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j231nip = $key->nip;
            $j231photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j231plt = " (PLT)";}
        }else if ($nmjab == $j232) {
            $j232nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j232nip = $key->nip;
            $j232photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j232plt = " (PLT)";}
        }else if ($nmjab == $j233) {
            $j233nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j233nip = $key->nip;
            $j233photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j233plt = " (PLT)";}
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
        }else if ($nmjab == $j311) {
            $j311nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j311nip = $key->nip;
            $j311photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j311plt = " (PLT)";}
        }else if ($nmjab == $j312) {
            $j312nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j312nip = $key->nip;
            $j312photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j312plt = " (PLT)";}
        }else if ($nmjab == $j313) {
            $j313nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j313nip = $key->nip;
            $j313photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j312plt = " (PLT)";}
        }else if ($nmjab == $j32) {
            $j32nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j32nip = $key->nip;
            $j32photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j22plt = " (PLT)";}
        }else if ($nmjab == $j321) {
            $j321nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j321nip = $key->nip;
            $j321photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j321plt = " (PLT)";}
        }else if ($nmjab == $j322) {
            $j322nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j322nip = $key->nip;
            $j322photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j322plt = " (PLT)";}
        }else if ($nmjab == $j323) {
            $j323nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j323nip = $key->nip;
            $j323photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j323plt = " (PLT)";}
        }else if ($nmjab == $j331) {
            $j331nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j331nip = $key->nip;
            $j331photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j331plt = " (PLT)";}
        }else if ($nmjab == $j332) {
            $j332nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j332nip = $key->nip;
            $j332photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j332plt = " (PLT)";}
        }else if ($nmjab == $j33) {
            $j33nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j33nip = $key->nip;
            $j33photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j33plt = " (PLT)";}
        }else if ($nmjab == $j331) {
            $j331nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j331nip = $key->nip;
            $j331photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j331plt = " (PLT)";}
        }else if ($nmjab == $j332) {
            $j332nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j332nip = $key->nip;
            $j332photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j332plt = " (PLT)";}
        }else if ($nmjab == $j333) {
            $j333nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j333nip = $key->nip;
            $j333photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j333plt = " (PLT)";}
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
        }else if ($nmjab == $j411) {
            $j411nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j411nip = $key->nip;
            $j411photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j411plt = " (PLT)";}
        }else if ($nmjab == $j412) {
            $j412nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j412nip = $key->nip;
            $j412photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j412plt = " (PLT)";}
        }else if ($nmjab == $j413) {
            $j413nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j413nip = $key->nip;
            $j413photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j413plt = " (PLT)";}
        }else if ($nmjab == $j42) {
            $j42nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j42nip = $key->nip;
            $j42photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j42plt = " (PLT)";}
        }else if ($nmjab == $j421) {
            $j421nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j421nip = $key->nip;
            $j421photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j421plt = " (PLT)";}
        }else if ($nmjab == $j422) {
            $j422nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j422nip = $key->nip;
            $j422photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j422plt = " (PLT)";}
        }else if ($nmjab == $j423) {
            $j423nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j423nip = $key->nip;
            $j423photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j423plt = " (PLT)";}
        }else if ($nmjab == $j43) {
            $j43nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j43nip = $key->nip;
            $j43photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j43plt = " (PLT)";}
        }else if ($nmjab == $j431) {
            $j431nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j431nip = $key->nip;
            $j431photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j431plt = " (PLT)";}
        }else if ($nmjab == $j432) {
            $j432nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j432nip = $key->nip;
            $j432photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j432plt = " (PLT)";}
        }else if ($nmjab == $j433) {
            $j433nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j433nip = $key->nip;
            $j433photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j433plt = " (PLT)";}
        }else if ($nmjab == $j5) {
            $j5nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j5nip = $key->nip;
            $j5photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j5plt = " (PLT)";}
        }else if ($nmjab == $j6) {
            $j6nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j6nip = $key->nip;
            $j6photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j6plt = " (PLT)";}
        }else if ($nmjab == $j7) {
            $j7nama = $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang;
            $j7nip = $key->nip;
            $j7photo = cekphotopns($key->nip);
            //if ($key->plt == "YA") {$j7plt = " (PLT)";}
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
      $this->text(5,2.8,'SILKa Online ::: BKPSDM Kab. Balangan All rights reserved');

      $this->setFont('arial','',9);
      $this->setXY(17.25,2);
      $this->MULTICELL(1.5,2,'Photo','LTB','C',0);
      $this->Image('assets/bupati.jpg',17.30,2.05,'1.4','1.9','jpg','');
      $this->setXY(18.75,2);
      $this->setFont('arial','B',9);
      $this->MULTICELL(5,0.5,'BUPATI','TR','C',0);
      $this->setXY(18.75,2.5);
      $this->setFont('arial','B',9);
      $this->MULTICELL(5,0.5,'H. ABDUL HADI','RB','C',0);
      $this->setXY(18.75,3);
      $this->MULTICELL(5,0.5,'WAKIL BUPATI','LT','C',0);
      $this->setXY(18.75,3.5);
      $this->setFont('arial','B',9);
      $this->MULTICELL(5,0.5,'H. SUPIANI','LB','C',0);
      $this->setXY(23.75,2);
      $this->MULTICELL(1.5,2,'Photo','TRB','C',0);
      $this->Image('assets/wakil_bupati.jpg',23.80,2.05,'1.4','1.9','jpg','');

      $this->setFont('arial','',9);
      $this->setXY(17.75,5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j1photo,17.80,5.05,'1.4','1.9','jpg','');
      $this->setXY(19.25,5);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,1,$j1t.$j1plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(19.25,6);
      $this->MULTICELL(5.5,0.5,$j1nama,'LRT','C',0);
      $this->setXY(19.25,6.5);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,0.5,$j1nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(22,8.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j5photo,22.05,8.55,'1.4','1.9','jpg','');
      $this->setXY(23.5,8.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.334,$j5t.$j5plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(23.5,9.5);
      $this->MULTICELL(4.5,0.5,$j5nama,'LRT','C',0);
      $this->setXY(23.5,10);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j5nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(28.5,8.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j6photo,28.55,8.55,'1.4','1.9','jpg','');
      $this->setXY(30,8.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.334,$j6t.$j6plt,1,'C',0);
      $this->setFont('arial','',7.5);
      $this->setXY(30,9.5);
      $this->MULTICELL(4.5,0.5,$j6nama,'LRT','C',0);
      $this->setXY(30,10);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j6nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(35,8.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j7photo,35.05,8.55,'1.4','1.9','jpg','');
      $this->setXY(36.5,8.5);
      $this->setFont('arial','',8);
      $this->MULTICELL(4.5,0.334,$j7t.$j7plt,1,'C',0);
      $this->setFont('arial','',7.5);
      $this->setXY(36.5,9.5);
      $this->MULTICELL(4.5,0.5,$j7nama,'LRT','C',0);
      $this->setXY(36.5,10);
      $this->setFont('arial','',9);
      $this->MULTICELL(4.5,0.5,$j7nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(4,11.75);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j2photo,4.05,11.80,'1.4','1.9','jpg','');
      $this->setXY(5.5,11.75);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,0.5,$j2t.$j2plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(5.5,12.75);
      $this->MULTICELL(5.5,0.5,$j2nama,'LRT','C',0);
      $this->setXY(5.5,13.25);
      $this->MULTICELL(5.5,0.5,$j2nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(17.75,11.75);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j3photo,17.80,11.80,'1.4','1.9','jpg','');
      $this->setXY(19.25,11.75);
      $this->setFont('arial','',8);
      $this->MULTICELL(5.5,0.5,$j3t.$j3plt,1,'C',0);
      $this->setFont('arial','',8);
      $this->setXY(19.25,12.75);
      $this->MULTICELL(5.5,0.334,$j3nama,'LRT','C',0);
      $this->setXY(19.25,13.25);
      $this->MULTICELL(5.5,0.5,$j3nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(31,11.75);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j4photo,31.05,11.80,'1.4','1.9','jpg','');
      $this->setXY(32.5,11.75);
      $this->setFont('arial','',9);
      $this->MULTICELL(5.5,1,$j4t.$j4plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(32.5,12.75);
      $this->MULTICELL(5.5,0.5,$j4nama,'LRT','C',0);
      $this->setXY(32.5,13.25);
      $this->MULTICELL(5.5,0.5,$j4nip,'LRB','C',0);



      // BARISAN KEPALA BAGIAN
      $this->setFont('arial','',9);
      $this->setXY(0.8,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j21photo,0.85,15.30,'1.4','1.9','jpg','');
      $this->setXY(2.3,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,1,$j21t.$j21plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(0.8,17.25);
      $this->MULTICELL(4.2,0.334,$j21nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(0.8,17.75);
      $this->MULTICELL(4.2,0.5,$j21nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(5.3,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j22photo,5.35,15.30,'1.4','1.9','jpg','');
      $this->setXY(6.8,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,0.667,$j22t.$j22plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(5.3,17.25);
      $this->MULTICELL(4.2,0.5,$j22nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(5.3,17.75);
      $this->MULTICELL(4.2,0.5,$j22nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(9.8,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j23photo,9.85,15.30,'1.4','1.9','jpg','');
      $this->setXY(11.3,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,2,$j23t.$j23plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(9.8,17.25);
      $this->MULTICELL(4.2,0.5,$j23nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(9.8,17.75);
      $this->MULTICELL(4.2,0.5,$j23nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.3,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j31photo,14.35,15.30,'1.4','1.9','jpg','');
      $this->setXY(15.8,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,0.5,$j31t.$j31plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(14.3,17.25);
      $this->MULTICELL(4.2,0.5,$j31nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(14.3,17.75);
      $this->MULTICELL(4.2,0.5,$j31nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(18.8,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j32photo,18.85,15.30,'1.4','1.9','jpg','');
      $this->setXY(20.3,15.25);
      $this->setFont('arial','',7);
      $this->MULTICELL(2.7,0.667,$j32t.$j32plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(18.8,17.25);
      $this->MULTICELL(4.2,0.5,$j32nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(18.8,17.75);
      $this->MULTICELL(4.2,0.5,$j32nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.3,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j33photo,23.35,15.30,'1.4','1.9','jpg','');
      $this->setXY(24.8,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,0.5,$j33t.$j33plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(23.3,17.25);
      $this->MULTICELL(4.2,0.5,$j33nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(23.3,17.75);
      $this->MULTICELL(4.2,0.5,$j33nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(27.8,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j41photo,27.85,15.30,'1.4','1.9','jpg','');
      $this->setXY(29.3,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,2,$j41t.$j41plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(27.8,17.25);
      $this->MULTICELL(4.2,0.5,$j41nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(27.8,17.75);
      $this->MULTICELL(4.2,0.5,$j41nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(32.3,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j42photo,32.35,15.30,'1.4','1.9','jpg','');
      $this->setXY(33.8,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,1,$j42t.$j42plt,1,'C',0);
      $this->setFont('arial','',9);
      $this->setXY(32.3,17.25);
      $this->MULTICELL(4.2,0.5,$j42nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(32.3,17.75);
      $this->MULTICELL(4.2,0.5,$j42nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(36.8,15.25);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j43photo,36.85,15.30,'1.4','1.9','jpg','');
      $this->setXY(38.3,15.25);
      $this->setFont('arial','',8);
      $this->MULTICELL(2.7,0.5,$j43t.$j43plt,1,'C',0);
      $this->setFont('arial','',7);
      $this->setXY(36.8,17.25);
      $this->MULTICELL(4.2,0.5,$j43nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(36.8,17.75);
      $this->MULTICELL(4.2,0.5,$j43nip,'LRB','C',0);

      // BARISAN KEPALA SUB BAGIAN I
      $this->setFont('arial','',9);
      $this->setXY(1,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j211photo,1.05,19.05,'1.4','1.9','jpg','');
      $this->setXY(2.5,19);
      $this->setFont('arial','',8);
      if ($j211plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.666,$j211t.$j211plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.666,$j211t.$j211plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(1,21);
      $this->MULTICELL(4,0.334,$j211nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(1,21.5);
      $this->MULTICELL(4,0.5,$j211nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(5.5,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j221photo,5.55,19.05,'1.4','1.9','jpg','');
      $this->setXY(7,19);
      $this->setFont('arial','',8);
      if ($j221plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j221t.$j221plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j221t.$j221plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(5.5,21);
      $this->MULTICELL(4,0.5,$j221nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(5.5,21.5);
      $this->MULTICELL(4,0.5,$j221nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(10,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j231photo,10.05,19.05,'1.4','1.9','jpg','');
      $this->setXY(11.5,19);
      $this->setFont('arial','',8);
      if ($j231plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j231t.$j231plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j231t.$j231plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(10,21);
      $this->MULTICELL(4,0.5,$j231nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(10,21.5);
      $this->MULTICELL(4,0.5,$j231nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j311photo,14.55,19.05,'1.4','1.9','jpg','');
      $this->setXY(16,19);
      $this->setFont('arial','',7.5);
      if ($j311plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j311t.$j311plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j311t.$j311plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(14.5,21);
      $this->MULTICELL(4,0.5,$j311nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(14.5,21.5);
      $this->MULTICELL(4,0.5,$j311nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(19,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j321photo,19.05,19.05,'1.4','1.9','jpg','');
      $this->setXY(20.5,19);
      $this->setFont('arial','',8);
      if ($j321plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j321t.$j321plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j321t.$j321plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(19,21);
      $this->MULTICELL(4,0.5,$j321nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(19,21.5);
      $this->MULTICELL(4,0.5,$j321nip,'LRB','C',0);


      $this->setFont('arial','',9);
      $this->setXY(23.5,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j331photo,23.55,19.05,'1.4','1.9','jpg','');
      $this->setXY(25,19);
      $this->setFont('arial','',6.5);
      if ($j331plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j331t.$j331plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j331t.$j331plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(23.5,21);
      $this->MULTICELL(4,0.5,$j331nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(23.5,21.5);
      $this->MULTICELL(4,0.5,$j331nip,'LRB','C',0);


      $this->setFont('arial','',9);
      $this->setXY(28,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j411photo,28.05,19.05,'1.4','1.9','jpg','');
      $this->setXY(29.5,19);
      $this->setFont('arial','',7);
      if ($j411plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j411t.$j411plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j411t.$j411plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(28,21);
      $this->MULTICELL(4,0.5,$j411nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(28,21.5);
      $this->MULTICELL(4,0.5,$j411nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(32.5,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j421photo,32.55,19.05,'1.4','1.9','jpg','');
      $this->setXY(34,19);
      $this->setFont('arial','',8);
      if ($j421plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j421t.$j421plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j421t.$j421plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(32.5,21);
      $this->MULTICELL(4,0.5,$j421nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(32.5,21.5);
      $this->MULTICELL(4,0.5,$j421nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(37,19);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j431photo,37.05,19.05,'1.4','1.9','jpg','');
      $this->setXY(38.5,19);
      $this->setFont('arial','',8);
      if ($j431plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,1,$j431t.$j431plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,1,$j431t.$j431plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(37,21);
      $this->MULTICELL(4,0.5,$j431nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(37,21.5);
      $this->MULTICELL(4,0.5,$j431nip,'LRB','C',0);

      // BARISAN KEPALA SUB BAGIAN II
      $this->setFont('arial','',9);
      $this->setXY(1,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j212photo,1.05,22.55,'1.4','1.9','jpg','');
      $this->setXY(2.5,22.5);
      $this->setFont('arial','',8);
      if ($j212plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j212t.$j212plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j212t.$j212plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(1,24.5);
      $this->MULTICELL(4,0.5,$j212nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(1,25);
      $this->MULTICELL(4,0.5,$j212nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(5.5,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j222photo,5.55,22.55,'1.4','1.9','jpg','');
      $this->setXY(7,22.5);
      $this->setFont('arial','',7);
      if ($j222plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j222t.$j222plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j222t.$j222plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(5.5,24.5);
      $this->MULTICELL(4,0.5,$j222nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(5.5,25);
      $this->MULTICELL(4,0.5,$j222nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(10,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j232photo,10.05,22.55,'1.4','1.9','jpg','');
      $this->setXY(11.5,22.5);
      $this->setFont('arial','',7.5);
      if ($j232plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j232t.$j232plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j232t.$j232plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(10,24.5);
      $this->MULTICELL(4,0.5,$j232nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(10,25);
      $this->MULTICELL(4,0.5,$j232nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j312photo,14.55,22.55,'1.4','1.9','jpg','');
      $this->setXY(16,22.5);
      $this->setFont('arial','',7);
      if ($j312plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,1,$j312t.$j312plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,1,$j312t.$j312plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(14.5,24.5);
      $this->MULTICELL(4,0.5,$j312nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(14.5,25);
      $this->MULTICELL(4,0.5,$j312nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(19,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j322photo,19.05,22.55,'1.4','1.9','jpg','');
      $this->setXY(20.5,22.5);
      $this->setFont('arial','',7.5);
      if ($j322plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j322t.$j322plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j322t.$j322plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(19,24.5);
      $this->MULTICELL(4,0.5,$j322nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(19,25);
      $this->MULTICELL(4,0.5,$j322nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j332photo,23.55,22.55,'1.4','1.9','jpg','');
      $this->setXY(25,22.5);
      $this->setFont('arial','',7);
      if ($j332plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.33,$j332t.$j332plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.33,$j332t.$j332plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(23.5,24.5);
      $this->MULTICELL(4,0.334,$j332nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(23.5,25);
      $this->MULTICELL(4,0.5,$j332nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(28,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j412photo,28.05,22.55,'1.4','1.9','jpg','');
      $this->setXY(29.5,22.5);
      $this->setFont('arial','',7.5);
      if ($j412plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,1,$j412t.$j412plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,1,$j412t.$j412plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(28,24.5);
      $this->MULTICELL(4,0.5,$j412nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(28,25);
      $this->MULTICELL(4,0.5,$j412nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(32.5,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j422photo,32.55,22.55,'1.4','1.9','jpg','');
      $this->setXY(34,22.5);
      $this->setFont('arial','',8);
      if ($j422plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j422t.$j422plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j422t.$j422plt,1,'C',0);
      }
      $this->setFont('arial','',7.5);
      $this->setXY(32.5,24.5);
      $this->MULTICELL(4,0.5,$j422nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(32.5,25);
      $this->MULTICELL(4,0.5,$j422nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(37,22.5);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j432photo,37.05,22.55,'1.4','1.9','jpg','');
      $this->setXY(38.5,22.5);
      $this->setFont('arial','',7.5);
      if ($j432plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j432t.$j432plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j432t.$j432plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(37,24.5);
      $this->MULTICELL(4,0.5,$j432nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(37,25);
      $this->MULTICELL(4,0.5,$j432nip,'LRB','C',0);

      // BARISAN KEPALA SUB BAGIAN III
      $this->setFont('arial','',9);
      $this->setXY(1,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j213photo,1.05,26.05,'1.4','1.9','jpg','');
      $this->setXY(2.5,26);
      $this->setFont('arial','',8);
      if ($j213plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j213t.$j213plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j213t.$j213plt,1,'C',0);
      }
      $this->setFont('arial','',9);
      $this->setXY(1,28);
      $this->MULTICELL(4,0.5,$j213nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(1,28.5);
      $this->MULTICELL(4,0.5,$j213nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(5.5,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j223photo,5.55,26.05,'1.4','1.9','jpg','');
      $this->setXY(7,26);
      $this->setFont('arial','',7);
      if ($j223plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j223t.$j223plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j223t.$j223plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(5.5,28);
      $this->MULTICELL(4,0.34,$j223nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(5.5,28.5);
      $this->MULTICELL(4,0.5,$j223nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(10,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j233photo,10.05,26.05,'1.4','1.9','jpg','');
      $this->setXY(11.5,26);
      $this->setFont('arial','',8);
      if ($j233plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j233t.$j233plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j233t.$j233plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(10,28);
      $this->MULTICELL(4,0.34,$j233nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(10,28.5);
      $this->MULTICELL(4,0.5,$j233nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(14.5,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j313photo,14.55,26.05,'1.4','1.9','jpg','');
      $this->setXY(16,26);
      $this->setFont('arial','',8);
      if ($j313plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j313t.$j313plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j313t.$j313plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(14.5,28);
      $this->MULTICELL(4,0.5,$j313nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(14.5,28.5);
      $this->MULTICELL(4,0.5,$j313nip,'LRB','C',0);
   
      $this->setFont('arial','',9);
      $this->setXY(19,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j323photo,19.05,26.05,'1.4','1.9','jpg','');
      $this->setXY(20.5,26);
      $this->setFont('arial','',8);
      if ($j323plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j323t.$j323plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j323t.$j323plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(19,28);
      $this->MULTICELL(4,0.5,$j323nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(19,28.5);
      $this->MULTICELL(4,0.5,$j323nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(23.5,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j333photo,23.55,26.05,'1.4','1.9','jpg','');
      $this->setXY(25,26);
      $this->setFont('arial','',7);
      if ($j333plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.334,$j333t.$j333plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.334,$j333t.$j333plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(23.5,28);
      $this->MULTICELL(4,0.5,$j333nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(23.5,28.5);
      $this->MULTICELL(4,0.5,$j333nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(28,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j413photo,28.05,26.05,'1.4','1.9','jpg','');
      $this->setXY(29.5,26);
      $this->setFont('arial','',7.5);
      if ($j413plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j413t.$j413plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j413t.$j413plt,1,'C',0);
      }
      $this->setFont('arial','',8);
      $this->setXY(28,28);
      $this->MULTICELL(4,0.5,$j413nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(28,28.5);
      $this->MULTICELL(4,0.5,$j413nip,'LRB','C',0);

      $this->setFont('arial','',9);
      $this->setXY(32.5,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j423photo,32.55,26.05,'1.4','1.9','jpg','');
      $this->setXY(34,26);
      $this->setFont('arial','',8);
      if ($j422plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.5,$j423t.$j423plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.5,$j423t.$j423plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(32.5,28);
      $this->MULTICELL(4,0.2667,$j423nama,'LRT','C',0);
      $this->setFont('arial','',9);
      $this->setXY(32.5,28.5);
      $this->MULTICELL(4,0.5,$j423nip,'LRB','C',0);




      $this->setFont('arial','',9);
      $this->setXY(37,26);
      $this->MULTICELL(1.5,2,'Photo',1,'C',0);
      $this->Image('photo/'.$j433photo,37.05,26.05,'1.4','1.9','jpg','');
      $this->setXY(38.5,26);
      $this->setFont('arial','',7.5);
      if ($j433plt) {
        $this->setFillColor($pltcl);
        $this->MULTICELL(2.5,0.667,$j433t.$j433plt,1,'C',1);
      }else {
      $this->MULTICELL(2.5,0.667,$j433t.$j433plt,1,'C',0);
      }
      $this->setFont('arial','',7);
      $this->setXY(37,28);
      $this->MULTICELL(4,0.5,$j433nama,'LRT','C',0);
      $this->setFont('arial','',8);
      $this->setXY(37,28.5);
      $this->MULTICELL(4,0.5,$j433nip,'LRB','C',0);

      $this->setXY(7.25,8);
      $this->setFont('arial','B',9);
      $this->MULTICELL(3,0.75,'POKJAFUNG',1,'C',0);
      $this->setFont('arial','',9);
	  $this->setXY(7.25,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(8,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(8.75,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(9.5,8.75);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(7.25,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(8,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
 	  $this->setXY(8.75,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);
	  $this->setXY(9.5,9.5);
      $this->MULTICELL(0.75,0.75,'',1,'C',0);


      // Garis antara BIDANG ADM PEMERINTAHAN DAN SEKSI2 NYA
      $this->Line(0.8,18.65,0.8,27.5);
      $this->Line(0.8,18.65,3,18.65);
      $this->Line(3,18.25,3,18.65);
      $this->Line(0.8,20.5,1,20.5);
      $this->Line(0.8,24,1,24);
      $this->Line(0.8,27.5,1,27.5);

      // Garis antara BIDANG HUKUM DAN SEKSI2 NYA
      $this->Line(5.3,18.65,5.3,27.5);
      $this->Line(5.3,18.65,7.5,18.65);
      $this->Line(7.5,18.25,7.5,18.65);
      $this->Line(5.3,20.5,5.5,20.5);
      $this->Line(5.3,24,5.5,24);
      $this->Line(5.3,27.5,5.5,27.5);

      // Garis antara BIDANG BINA KESEJAHTERAAN SOSIAL DAN SEKSI2 NYA
      $this->Line(9.8,18.65,9.8,27.5);
      $this->Line(9.8,18.65,12,18.65);
      $this->Line(12,18.25,12,18.65);
      $this->Line(9.8,20.5,10,20.5);
      $this->Line(9.8,24,10,24);
      $this->Line(9.8,27.5,10,27.5);

      // Garis antara BIDANG PEREKONOMIAN DAN PEMBANGUNAN DAN SEKSI2 NYA
      $this->Line(14.3,18.65,14.3,24);
      $this->Line(14.3,18.65,16.5,18.65);
      $this->Line(16.5,18.25,16.5,18.65);
      $this->Line(14.3,20.5,14.5,20.5);
      $this->Line(14.3,24,14.5,24);

      // Garis antara BIDANG HUMAS PIMPINAN DAN KEPROTOKOLAN DAN SEKSI2 NYA
      $this->Line(18.8,18.65,18.8,24);
      $this->Line(18.8,18.65,21,18.65);
      $this->Line(21,18.25,21,18.65);
      $this->Line(18.8,20.5,19,20.5);
      $this->Line(18.8,24,19,24);

      // Garis antara BIDANG PENGADAAN BARANG JASA DAN SEKSI2 NYA
      $this->Line(23.3,18.65,23.3,27.5);
      $this->Line(23.3,18.65,25.5,18.65);
      $this->Line(25.5,18.25,25.5,18.65);
      $this->Line(23.3,20.5,23.5,20.5);
      $this->Line(23.3,24,23.5,24);
      $this->Line(23.3,27.5,23.5,27.5);

      // Garis antara BIDANG UMUM PERLENGKAPAN DAN SEKSI2 NYA
      $this->Line(27.8,18.65,27.8,27.5);
      $this->Line(27.8,18.65,30,18.65); // garis mendatar
      $this->Line(30,18.25,30,18.65);
      $this->Line(27.8,20.5,28,20.5);
      $this->Line(27.8,24,28,24);
      $this->Line(27.8,27.5,28,27.5);

      // Garis antara BIDANG PERENCANAAN DAN KEUANGAN DAN SEKSI2 NYA
      $this->Line(32.3,18.65,32.3,27.5);
      $this->Line(32.3,18.65,34.5,18.65);
      $this->Line(34.5,18.25,34.5,18.65);
      $this->Line(32.3,20.5,32.5,20.5);
      $this->Line(32.3,24,32.5,24);
      $this->Line(32.3,27.5,32.5,27.5);

      // Garis antara BIDANG ORGANISASI DAN SEKSI2 NYA
      $this->Line(36.8,18.65,36.8,27.5);
      $this->Line(36.8,18.65,39,18.65);
      $this->Line(39,18.25,39,18.65);
      $this->Line(36.8,20.5,37,20.5);
      $this->Line(36.8,24,37,24);
      $this->Line(36.8,27.5,37,27.5);

      // GARIS ANTARA ASISTEN PEMERINTAHAN KESRA DGN BAGIAN2 NYA
      $this->Line(3,14.5,12,14.5); //mendatar
      $this->Line(3,14.5,3,15.25);
      $this->Line(7.5,13.75,7.5,15.25);
      $this->Line(12,14.5,12,15.25);

      // GARIS ANTARA ASISTEN PEREKONOMIAN PEMBANGUNAN DAN KEHUMASAN DGN BAGIAN2 NYA
      $this->Line(16.75,14.5,25.75,14.5); //mendatar
      $this->Line(16.75,14.5,16.75,15.25);
      $this->Line(21.25,13.75,21.25,15.25);
      $this->Line(25.75,14.5,25.75,15.25);

      // GARIS ANTARA ASISTEN ADMINISTRASI UMUM DGN BAGIAN2 NYA
      $this->Line(30,14.5,39,14.5); // mendatar
      $this->Line(30,14.5,30,15.25);
      $this->Line(34.5,13.75,34.5,15.25);
      $this->Line(39,14.5,39,15.25);

      // GARIS ANTARA SETDA DGN ASISTEN2 NYA
      $this->Line(7.5,11.25,34.5,11.25); // mendatar
      $this->Line(7.5,11.25,7.5,11.75);
      $this->Line(21.25,7,21.25,11.75);
      $this->Line(34.5,11.25,34.5,11.75);

      // GARIS ANTARA SETDA DGN JABFUNG
      $this->Line(8.75,7.5,8.75,8);
      $this->Line(8.75,7.5,21.25,7.5);

      // GARIS ANTARA BUPATI DGN SETDA
      $this->Line(21.25,4,21.25,5);

      // GARIS ANTARA BUPATI DGN STAF AHLI
      $this->Line(22,4,22,4.5);
      $this->Line(22,4.5,31.5,4.5);
      $this->Line(25,8,38,8);
      $this->Line(25,8,25,8.5);
      $this->Line(31.5,4.5,31.5,8.5);
      $this->Line(38,8,38,8.5);

      // GARIS ANTARA SETDA DGN STAF AHLI
      $this->Line(22,7,22,7.25);
      $this->Line(22,7.5,22.25,7.5);
      $this->Line(22.5,7.5,22.75,7.5);
      $this->Line(23,7.5,23.25,7.5);
      $this->Line(23.5,7.5,23.75,7.5);
      $this->Line(24,7.5,24.25,7.5);
      $this->Line(24.5,7.5,24.75,7.5);
      $this->Line(25,7.5,25.25,7.5);
      $this->Line(25.5,7.5,25.75,7.5);
      $this->Line(26,7.5,26.25,7.5);
      $this->Line(26.5,7.5,26.75,7.5);
      $this->Line(27,7.5,27.25,7.5);
      $this->Line(27.5,7.5,27.75,7.5);
      $this->Line(28,7.5,28.25,7.5);
      $this->Line(28.5,7.5,28.75,7.5);
      $this->Line(29,7.5,29.25,7.5);
      $this->Line(29.5,7.5,29.75,7.5);
      $this->Line(30,7.5,30.25,7.5);
      $this->Line(30.5,7.5,30.75,7.5);
      $this->Line(30.75,7.75,30.75,8);
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
 
// ukuran kerja A3, landscape L
$pdf = new PDF('L', 'cm', array('29.7','42'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('sotk setda.pdf', 'I');
