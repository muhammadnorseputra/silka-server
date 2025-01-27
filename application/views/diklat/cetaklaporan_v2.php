<?php 

class PDF extends FPDF
{ 
  function header(){
    $login = new mLogin();   
    $peg = new mPegawai();
    $mun = new Munker();

    $this->SetXY(20,10);
    $this->setFont('Arial','',9);
    $this->setFillColor(255,255,255);
    $this->cell(130,5,"Lampiran Tahun ".date('Y'),0,0,'L',1); 
    $this->setFont('Arial','I',7);
    $this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
    $this->SetY(15);
    //buat garis horizontal
    $this->Line(20,$this->GetY(),320,$this->GetY());   
  }

  function Content($parseData){

    $mpeg  = new Mpegawai();
    $mun   = new Munker();
    $dik   = new mDiklat();
    $login = new mLogin();
    
    $x= 20;
    $y= 40;

    //TABLE THEAD
    $this->setFillColor(222,222,222);
    $this->setFont('arial','B',8);
    $this->setXY($x,$y);
    $this->MULTICELL(10,10,'NO.','LTR','C',1); 
    $this->setXY($x+10,$y);
    $this->MULTICELL(40,10,'NAMA / NIP','LTR','C',1); 
    $this->setXY($x+50,$y);
    $this->MULTICELL(50,10,'NAMA DIKLAT','LTR','C',1); 
    $this->setXY($x+100,$y);
    $this->MULTICELL(70,10,'TUPOKSI','LTR','C',1); 
    $this->setXY($x+170,$y);
    $this->MULTICELL(10,10,'JP','LTR','C',1); 
    $this->setXY($x+180,$y);
    $this->MULTICELL(30,10,'BIAYA','LTR','C',1); 
    $this->setXY($x+210,$y);
    $this->MULTICELL(30,10,'PENYELENGGARA','LTR','C',1); 
    $this->setXY($x+240,$y);
    $this->MULTICELL(60,10,'HASIL YANG DIHARAPKAN','LTR','C',1); 

    $y = 50;
    $no = 1;        
    $maxline=1;
    foreach($parseData['data'] as $key) {
      if ($no==1) {
        // HEADER
        $this->ln();
        $this->SetFont('arial', 'B', 12);
        $this->Image('assets/logo.jpg', 20, 18,'10','13','jpeg');
        $this->SetXY(35,13);
        $this->Cell(0, 15, 'REKAP ANALISIS KEBUTUHAN DIKLAT (AKD)', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 		

        $this->ln();
        $this->SetXY(35,18);
        $this->Cell(0, 15, 'DI LINGKUNGAN PEMERINTAH DAERAH KABUPATEN BALANGAN', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

        $this->ln();
        $this->SetFont('arial', '', 12);
        $this->SetXY(35,24);
        $this->Cell(0, 15, $mun->munker->getnamaunker($key->fid_unit_kerja), 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
      }

      $maxline=$maxline % 10;
      if ($maxline == 0) {
        $this->AddPage();                
        $y1 = 40;
        $y = 50;
        $this->Ln(7);
        $this->SetFont('arial', 'B', 12);
        $this->Image('assets/logo.jpg', 20, 18,'10','13','jpeg');
        $this->SetXY(35,13);
        $this->Cell(0, 15, 'REKAP ANALISIS KEBUTUHAN DIKLAT (AKD)', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 		

        $this->ln();
        $this->SetXY(35,18);
        $this->Cell(0, 15, 'DI LINGKUNGAN PEMERINTAH DAERAH KABUPATEN BALANGAN', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

        $this->ln();
        $this->SetFont('arial', '', 12);
        $this->SetXY(35,24);
        $this->Cell(0, 15, $mun->munker->getnamaunker($key->fid_unit_kerja), 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

        //TABLE THEAD
        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y1);
        $this->MULTICELL(10,10,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y1);
        $this->MULTICELL(40,10,'NAMA / NIP','LTR','C',1); 
        $this->setXY($x+50,$y1);
        $this->MULTICELL(50,10,'NAMA DIKLAT','LTR','C',1); 
        $this->setXY($x+100,$y1);
        $this->MULTICELL(70,10,'TUPOKSI','LTR','C',1); 
        $this->setXY($x+170,$y1);
        $this->MULTICELL(10,10,'JP','LTR','C',1); 
        $this->setXY($x+180,$y1);
        $this->MULTICELL(30,10,'BIAYA','LTR','C',1); 
        $this->setXY($x+210,$y1);
        $this->MULTICELL(30,10,'PENYELENGGARA','LTR','C',1); 
        $this->setXY($x+240,$y1);
        $this->MULTICELL(60,10,'HASIL YANG DIHARAPKAN','LTR','C',1); 
        $maxline=$maxline+1;
      }


      $this->setFillColor(255,255,255);
      $this->setFont('arial','',8);
      $this->setXY($x,$y);
      $this->MULTICELL(10,5,$no.'.','','C',1); 
      $this->setXY($x+10,$y);
      if($key->fid_jnsjab == 3) {
        $jabid = $key->fid_jabft;
      } elseif($key->fid_jnsjab == 2) {
        $jabid = $key->fid_jabfu;
      } else {
        $jabid = $key->fid_jabatan;
      }
      $this->MULTICELL(45,5,$key->nama_asn."\n NIP. ".$key->nip,'','L',0);
      $this->setXY($x+50,$y);
      $this->MULTICELL(50,5,$key->nama_syarat_diklat,'','L',1);
      $this->setXY($x+100,$y);
      
      // for tupoksi logic
  		$tupoksilimited = strlen($key->tupoksi); // function php get count this word.
      if ($tupoksilimited <= 150) { 
          $this->setFont('arial','',8);
          $tupoksi = $key->tupoksi;
      } else if (($tupoksilimited > 150) AND ($tupoksilimited <= 300)) {
          $this->setFont('arial','',6);
          $tupoksi = $key->tupoksi;
      } else if ($tupoksilimited > 300) {
          $this->setFont('arial','',5);
          $tupoksi = $key->tupoksi;
      }
      // $rekomendasi=$dik->md->getRekomendasiDiklat($jabid);
      // // var_dump($rekomendasi->id_jabatan);
      // if($rekomendasi->id_jabatan != NULL) {
      //   $rekomendasiDiklat = $rekomendasi->id_jabatan;
      // } else {
      //   $rekomendasiDiklat ="";
      // }
      $this->MULTICELL(70,3,$tupoksi,'L',1);
      
      $this->setFont('arial','',8);
      $this->setXY($x+170,$y);
      $this->MULTICELL(10,5,$key->jp,'','C',1);
      $this->setXY($x+180,$y);
      $this->MULTICELL(30,5,"Rp. ".nominal($key->biaya),'','C',1);
      $this->setXY($x+210,$y);
      
      // for penyelenggara logic
  		$pyllimited = strlen($key->penyelenggara); // function php get count this word.
	if ($pyllimited <= 25) { 
        $this->setFont('arial','',8);
        $penyelenggara = $key->penyelenggara;
    } else if (($pyllimited > 25) AND ($pyllimited <= 60)) {
        $this->setFont('arial','',6);
        $penyelenggara = $key->penyelenggara;
    } else if ($pyllimited > 60) {
        $this->setFont('arial','',5);
        $penyelenggara = $key->penyelenggara;
    }
      $this->MULTICELL(30,3,ucwords($penyelenggara),'','L',1);
      $this->setXY($x+240,$y);
      
      $this->setFont('arial','',8);
      // for capaian logic
  		$cpllimited = strlen($key->capaian); // function php get count this word.
	if ($cpllimited <= 100) { 
        $this->setFont('arial','',8);
        $capaian = $key->capaian;
    } else if (($cpllimited > 100) AND ($cpllimited <= 150)) {
        $this->setFont('arial','',6);
        $capaian = $key->capaian;
    } else if ($cpllimited > 150) {
        $this->setFont('arial','',5);
        $capaian = $key->capaian;
    }
      $this->MULTICELL(60,3,ucwords($capaian),'','L',1);

      // garis vertikal            
      $this->Line($x,$y,$x,$y+15);
      $this->Line($x+10,$y,$x+10,$y+15);
      $this->Line($x+50,$y,$x+50,$y+15);
      $this->Line($x+100,$y,$x+100,$y+15);
      $this->Line($x+170,$y,$x+170,$y+15);
      $this->Line($x+180,$y,$x+180,$y+15);
      $this->Line($x+210,$y,$x+210,$y+15);
      $this->Line($x+240,$y,$x+240,$y+15);
      $this->Line($x+300,$y,$x+300,$y+15);
      // garis horizontal
      $this->Line($x,$y,$x+300,$y);
      $this->Line($x,$y+15,$x+300,$y+15);

      $y=$y+15;
      $no=$no+1;
      $maxline=$maxline+1;
    } 	

    		$jmppeg = $dik->md->get_all_data_rekap($key->fid_unit_kerja, $parseData['s'], $parseData['j'], $parseData['t']);

        $sisa = $jmppeg % 9;
        if (($sisa == 0) OR ($sisa == 8)  OR ($sisa == 7)  OR ($sisa == 6)) {
            $this->AddPage();
            $y = 15;
        }

        //$this->setFont('Arial','',10);
        //$this->setXY(60,$y+20);
        //$this->cell(70,5,'Dientri oleh, ',0,1,'C',1); 
        //$this->setXY(60,$y+45);
        //$this->setFont('Arial','U',10);
        //$this->cell(70,5,$mpeg->mpegawai->getnama($login->session->userdata('nip')),0,1,'C',1); 
        //$this->setFont('Arial','',10);
        //$this->setXY(60,$y+50);
        //$this->cell(70,5,'NIP. '.$login->session->userdata('nip'),0,1,'C',1); 

        $this->setFont('Arial','',10);
        $this->setXY(210,$y+10);
        $this->cell(70,5,'Paringin, '.tgl_indo(date('Y-m-d')),0,1,'C',1); 
        $this->setXY(210,$y+15);
        $this->cell(70,5,'Mengetahui,',0,1,'C',1); 
        $this->setXY(195,$y+20);

      if ($key->status_spesimen == 'DEFINITIF') {
          $this->MULTICELL(100,5,$key->jabatan_spesimen,0,'C',0); 
      } else if ($key->status_spesimen == 'PLT') {
          $this->MULTICELL(100,5,'Plt. '.$key->jabatan_spesimen,0,'C',0); 
      } else if ($key->status_spesimen == 'PLH') {
          $this->MULTICELL(100,5,'Plh. '.$key->jabatan_spesimen,0,'C',0); 
      } else if ($key->status_spesimen == 'AN') {
          $this->MULTICELL(100,5,'A.n. '.$key->jabatan_spesimen,0,'C',0); 
          $this->setXY(195,$y+30);
          if ($key->nip_spesimen != '') {
              $this->MULTICELL(100,5,$mpeg->mpegawai->namajabnip($key->nip_spesimen),0,'C',0);             
          }
      }
    
      if ($key->nip_spesimen != '') {
        $this->setFont('Arial','U',10);
        $this->setXY(210,$y+50);
        $this->cell(70,5,$mpeg->mpegawai->getnama($key->nip_spesimen),0,1,'C',1); 
        $this->setFont('Arial','',10);
        $this->setXY(210,$y+55);
        $this->cell(70,5,'NIP. '.$key->nip_spesimen,0,1,'C',1); 
      } else {
          //$this->setXY(210,$y+45);
          $this->Line(220,$y+50,270,$y+50);
          //$this->cell(70,5,'-------------------------------------',0,1,'C',1); 
      }

  }


  // Page footer
  function Footer() {
    $this->SetY(-15);
    $this->SetX(20);
    $this->Line(20,$this->GetY(),320,$this->GetY());
    $this->SetFont('Arial','I',7);
    $this->Cell(0,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');
    $this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
  }  
}

$pdf = new PDF('L', 'mm', array('215','330'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($parseData);
$pdf->Output('rekap_diklat.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+