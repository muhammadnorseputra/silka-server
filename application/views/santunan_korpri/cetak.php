<?php 
class PDF extends FPDF
{ 
  function header(){

    $this->SetXY(20,10);
    $this->setFont('Arial','',9);
    $this->setFillColor(255,255,255);
    $this->cell(130,5,"Rekapitulasi Santunan Korpri",0,0,'L',1); 
    $this->SetY(15);
    //buat garis horizontal
    $this->Line(20,$this->GetY(),320,$this->GetY());  
  }
  
  function Content($parseData){

    $mpeg  = new Mpegawai();
    $mun   = new Munker();
    $korpri   = new msantunan_korpri();
    $login = new mLogin();
    
    $x= 20;
    $y= 20;
    
    //TABLE THEAD
    $this->setFillColor(222,222,222);
    $this->setFont('arial','B',8);
    $this->setXY($x,$y);
    $this->MULTICELL(10,10,'NO.','LTR','C',1); 
    $this->setXY($x+10,$y);
    $this->MULTICELL(50,10,'NAMA / NIP','LTR','C',1); 
    $this->setXY($x+60,$y);
    $this->MULTICELL(50,10,'UNIT KERJA','LTR','C',1); 
    $this->setXY($x+110,$y);
    $this->MULTICELL(40,10,'BESAR SANTUNAN','LTR','C',1); 
    $this->setXY($x+150,$y);
    $this->MULTICELL(30,10,'JENIS SANTUNAN','LTR','C',1); 
    $this->setXY($x+180,$y);
    $this->MULTICELL(30,10,'BULAN','LTR','C',1); 
    $this->setXY($x+210,$y);
    $this->MULTICELL(30,10,'TAHUN','LTR','C',1); 
    $this->setXY($x+240,$y);
    $this->MULTICELL(60,10,'KETERANGAN','LTR','C',1);
    
    $y = 30;
    $no = 1;        
    $maxline=1;
    foreach($parseData['data'] as $key) {
    
    $maxline=$maxline % 12;
    if ($maxline == 0) {
    	$this->AddPage();
    	$y1 = 40;
      $y = 30;
    	//TABLE THEAD
	    $this->setFillColor(222,222,222);
	    $this->setFont('arial','B',8);
	    $this->setXY($x,$y);
	    $this->MULTICELL(10,10,'NO.','LTR','C',1); 
	    $this->setXY($x+10,$y);
	    $this->MULTICELL(50,10,'NAMA / NIP','LTR','C',1); 
	    $this->setXY($x+60,$y);
	    $this->MULTICELL(50,10,'UNIT KERJA','LTR','C',1); 
	    $this->setXY($x+110,$y);
	    $this->MULTICELL(40,10,'BESAR SANTUNAN','LTR','C',1); 
	    $this->setXY($x+150,$y);
	    $this->MULTICELL(30,10,'JENIS SANTUNAN','LTR','C',1); 
	    $this->setXY($x+180,$y);
	    $this->MULTICELL(30,10,'BULAN','LTR','C',1); 
	    $this->setXY($x+210,$y);
	    $this->MULTICELL(30,10,'TAHUN','LTR','C',1); 
	    $this->setXY($x+240,$y);
	    $this->MULTICELL(60,10,'KETERANGAN','LTR','C',1);
    }
    	$gelar_depan = $key->gelar_depan ? $key->gelar_depan : $key->gd_pensiun;
	    $nama = $key->nama ? $key->nama : $key->nama_pensiun;
	    $gelar_belakang = $key->gelar_belakang ? $key->gelar_belakang : $key->gb_pensiun;
	    
    	$this->setFillColor(255,255,255);
      $this->setFont('arial','',8);
      $this->setXY($x,$y);
      $this->MULTICELL(10,5,$no.'.','','C',1); 
      $this->setXY($x+10,$y);
      $this->MULTICELL(45,5,namagelar($gelar_depan,$nama,$gelar_belakang)."\nNIP. ".polanip($key->nip),'','L',0);
      $this->setXY($x+60,$y);
      $this->MULTICELL(50,5,$key->unit_kerja,'','L',1);
      $this->setXY($x+110,$y);
	    $this->MULTICELL(40,5,'Rp. '.nominal($key->besar_santunan),'','C',1); 
	    
	    if($key->fid_jenis_tali_asih == 1) {
	    	$ket = $key->tgl_bup; 
	    } elseif($key->fid_jenis_tali_asih == 2) {
	    	$ket = $key->tgl_meninggal;
	    } else {
	    	$ket = $key->tgl_kebakaran;
	    }
	    $this->setXY($x+150,$y);
	    $this->MULTICELL(30,5,$korpri->jenis($key->fid_jenis_tali_asih)." / ".tgl_indo($ket),'LTE','L',1); 
	    
	    $this->setXY($x+180,$y);
	    $this->MULTICELL(30,5,strtoupper($key->bulan),'LTR','C',1); 
	    $this->setXY($x+210,$y);
	    $this->MULTICELL(30,5,$key->tahun,'LTR','C',1); 
	    $this->setXY($x+240,$y);
	    $this->MULTICELL(60,5,$key->note,'L','L',1);
      
      // garis vertikal            
      $this->Line($x,$y,$x,$y+15);
      $this->Line($x+10,$y,$x+10,$y+15);
      $this->Line($x+60,$y,$x+60,$y+15);
      $this->Line($x+110,$y,$x+110,$y+15);
      $this->Line($x+150,$y,$x+150,$y+15);
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
    
    $jmppeg = $korpri->get_all_data($parseData['tahun'], $parseData['bulan'], $parseData['jenis']);

    $sisa = $jmppeg % 11;
    if (($sisa == 0) OR ($sisa == 8) OR ($sisa == 9) OR ($sisa == 11)) {
        $this->AddPage();
        $y = 15;
    }
    
    $this->setFont('arial','IU',7);
    $this->setXY(20,$y+10);
    $this->cell(80,5,'KETERANGAN REKAP SANTUNAN',0,1,'L',1); 
    $this->setFont('arial','',7);
    $this->setXY(20,$y+15);
    $this->cell(80,8,'Tahun : '.(empty($parseData['tahun']) ? "~" : $parseData['tahun']),0,1,'L',1); 
    $this->setXY(20,$y+22);
    $this->cell(80,8,'Bulan : '.(empty($parseData['bulan']) ? "~" : $parseData['bulan']),0,1,'L',1); 
    $this->setXY(20,$y+29);
    $this->cell(80,8,'Jenis Santunan : '.(empty($parseData['jenis']) ? "~" : $korpri->jenis($parseData['jenis'])),0,1,'L',1); 
    $this->setXY(20,$y+35);
    $this->cell(80,8,'Tanggal Cetak : '.tgl_indo(date('Y-m-d')).", ".date('h:i')." WIB",0,1,'L',1); 
    $this->setXY(20,$y+41);
    $this->cell(80,8,'Dicetak Oleh : '.$mpeg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.polanip($login->session->userdata('nip')).')',0,1,'L',1); 
    
    $this->setFont('arial','',8);
    $this->setXY(140,$y+10);
    $this->cell(80,5,'Mengetahui,',0,1,'L',1); 
    $this->setXY(140,$y+15);
    $this->setFont('arial','B',8);
    $this->MultiCell(100,5,'KEPALA BIDANG PENGADAAN, PEMBERHENTIAN, INFORMASI KEPEGAWAIAN, MUTASI DAN PROMOSI ASN',0,"L"); 
   	$this->setXY(140,$y+40);
    $this->cell(80,5,'SUMEDI, M.Pd',0,1,'L',1); 
   	$this->setXY(140,$y+45);
    $this->setFont('arial','',8);
    $this->cell(80,5,'NIP. '.polanip('197106081993031006'),0,1,'L',1);
    
    $this->setFont('arial','',8);
    $this->setXY(240,$y+10);
    $this->cell(80,5,'Paringin, '.tgl_indo(date('Y-m-d')),0,1,'L',1); 
    $this->setXY(240,$y+15);
    $this->setFont('arial','B',8);
    $this->MultiCell(80,5,'JF ANALIS SUMBER DAYA MANUSIA APARATUR AHLI MUDA',0,'L'); 
   	$this->setXY(240,$y+40);
    $this->cell(80,5,'HJ. RINAWATI, S.Sos',0,1,'L',1); 
   	$this->setXY(240,$y+45);
    $this->setFont('arial','',8);
    $this->cell(80,5,'NIP. '.polanip('198204212006041008'),0,1,'L',1);  
  }
  
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
$pdf->Output('rekap_tali_asih.pdf', 'I');
