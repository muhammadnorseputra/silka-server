<?php 
class PDF extends FPDF
{ 
  function header(){

    $this->SetXY(20,10);
    $this->setFont('Arial','',9);
    $this->setFillColor(255,255,255);
    $this->cell(140,5,"Rekapitulasi Penilaian Instrumemen Kinerja :: ".tgl_indo(date('Y-m-d')),0,0,'L',1); 
    $this->SetY(15);
    //buat garis horizontal
    $this->Line(20,$this->GetY(),320,$this->GetY());  
  }
  
  function Content($parse){
  	$mpeg  = new Mpegawai();
    $mun   = new Munker();
    $petruk = new mpetruk();
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
    $this->MULTICELL(60,10,'UNIT KERJA','LTR','C',1); 
    $this->setXY($x+120,$y);
    $this->MULTICELL(180,5,'SCORE TIM MANDIRI','LTR','C',1);
    $this->setXY($x+120,$y+5);
    $this->MULTICELL(50,5,'INOVATIF','LTR','C',1); 
    $this->setXY($x+170,$y+5);
    $this->MULTICELL(50,5,'REKAM JEJAK','LTR','C',1); 
    $this->setXY($x+215,$y+5);
    $this->MULTICELL(50,5,'KINERJA & DISIPLIN','LTR','C',1); 
    $this->setXY($x+265,$y+5);
    $this->MULTICELL(35,5,'RATA-RATA','LTR','C',1);
    
    $y = 30;
    $no = 1;        
    $maxline=1;
    foreach($parse['data'] as $key) {
	    $maxline=$maxline % 11;
	    if ($maxline == 0) {
	    	$this->AddPage();              
         $y1 = 20;
	      $y = 30;
	    	$this->setFillColor(222,222,222);
		    $this->setFont('arial','B',8);
		    $this->setXY($x,$y1);
		    $this->MULTICELL(10,10,'NO.','LTR','C',1); 
		    $this->setXY($x+10,$y1);
		    $this->MULTICELL(50,10,'NAMA / NIP','LTR','C',1); 
		    $this->setXY($x+60,$y1);
		    $this->MULTICELL(60,10,'UNIT KERJA','LTR','C',1); 
		    // $this->setXY($x+120,$y1);
		    // $this->MULTICELL(60,10,'INOVASI','LTR','C',1); 
        $this->setXY($x+120,$y);
        $this->MULTICELL(180,5,'SCORE TIM MANDIRI','LTR','C',1);
        $this->setXY($x+120,$y+5);
        $this->MULTICELL(50,5,'INOVATIF','LTR','C',1); 
        $this->setXY($x+170,$y+5);
        $this->MULTICELL(50,5,'REKAM JEJAK','LTR','C',1); 
        $this->setXY($x+215,$y+5);
        $this->MULTICELL(50,5,'KINERJA & DISIPLIN','LTR','C',1); 
		    $this->setXY($x+265,$y1+5);
		    $this->MULTICELL(35,5,'RATA-RATA','LTR','C',1);
		    $maxline=$maxline+1;
	    }
	    
	   $this->setFillColor(255,255,255);
      $this->setFont('arial','',8);
      $this->setXY($x,$y);
      $this->MULTICELL(10,5,$no.'.','','C',1); 
      $this->setXY($x+10,$y);
      $this->MULTICELL(45,5,namagelar($key->gelar_depan,$key->nama,$key->gelar_belakang)."\nNIP. ".polanip($key->nip),'','L',0);
      $this->setXY($x+60,$y);
      $this->MULTICELL(60,5,$key->nama_unit_kerja,'','L',1);
      // Total skor
      $skor_inovatif = $key->skor_orisinalitas + $key->skor_efesiansi + $key->skor_keberlanjutan + $key->skor_manfaat;
      $rekam_jejak = $key->skor_pengalaman_jabatan + $key->skor_pengembangan_kopetensi + $key->skor_penghargaan_diterima + $key->skor_moralitas + 
                      $key->skor_tingkat_pendidikan + $key->skor_integritas;
      $skor_disiplin = $key->skor_dampak_organisasi + $key->skor_keterlibatan + $key->skor_disiplin;
      // Persentase skor
      $persentase_inovatif = ($skor_inovatif/3);
      $persentase_rekamjejak = ($rekam_jejak/3);
      $persentase_disiplin = ($skor_disiplin/3);

		  $this->setFont('arial','B',12);
		  $this->setXY($x+120,$y);	  
		  $this->MULTICELL(50,15, $skor_inovatif." (".number_format($persentase_inovatif, 2)."%)", 0, 'C',0);
		  $this->setXY($x+170,$y);
		  $this->MULTICELL(50,15, $rekam_jejak." (".number_format($persentase_rekamjejak, 2)."%)", 0, 'C',0);
		  $this->setXY($x+215,$y);
		  $this->MULTICELL(50,15, $skor_disiplin." (".number_format($persentase_disiplin, 2)."%)", 0, 'C',0);
		  $this->setXY($x+265,$y);
		  if($key->skor_total <= 150):
		  	$this->SetFillColor(255, 165, 165);
		  	$this->MULTICELL(35,15, $key->skor_total." / ".number_format($key->skor_total/3, 2)."%", 0, 'C',1);
		  elseif($key->skor_total <= 200):
		  	$this->SetFillColor(255, 215, 121);
		  	$this->MULTICELL(35,15, $key->skor_total." / ".number_format($key->skor_total/3, 2)."%", 0, 'C',1);
		  elseif($key->skor_total >= 250):
		  	$this->SetFillColor(215, 253, 165);
		  	$this->MULTICELL(35,15, $key->skor_total." / ".number_format($key->skor_total/3, 2)."%", 0, 'C',1);
		  else:
		  	$this->SetFillColor(255, 215, 121);
		  	$this->MULTICELL(35,15, $key->skor_total." / ".number_format($key->skor_total/3, 2)."%", 0, 'C',0);
      endif;
      // garis vertikal            
      $this->Line($x,$y,$x,$y+15);
      $this->Line($x+10,$y,$x+10,$y+15);
      $this->Line($x+60,$y,$x+60,$y+15);
      $this->Line($x+120,$y,$x+120,$y+15);
      $this->Line($x+170,$y,$x+170,$y+15);
      $this->Line($x+215,$y,$x+215,$y+15);

      $this->Line($x+265,$y,$x+265,$y+15);
      $this->Line($x+300,$y,$x+300,$y+15);
      // garis horizontal
      $this->Line($x,$y,$x+300,$y);
      $this->Line($x,$y+15,$x+300,$y+15);
    	
    	$y=$y+15;
      $no=$no+1;
      $maxline=$maxline+1;
    }
    
    $jmppeg = $petruk->get_all_data_rekap($parse['bulan'], $parse['tahun'], $parse['skor']);

    $sisa = $jmppeg % 10;
    if (($sisa == 0) OR ($sisa == 8) OR ($sisa == 9) OR ($sisa == 11)) {
        $this->AddPage();
        $y = 15;
    }
    
    $x = 40;
    // $this->setFont('arial','',8);
    // $this->setXY($x,$y+10);
    // $this->MULTICELL(80,5,'Paringin, '.tgl_indo(date('Y-m-d')), 0, 'C',0); 
    // $this->setXY($x,$y+15);
    // $this->MULTICELL(80,5,'KEPALA SUB BIDANG PENILAIAN DAN EVALUASI KINERJA APARATUR', 0, 'C',0); 
   	// $this->setXY($x,$y+35);
    // $this->MULTICELL(80,5,'SUKIMAN, S.Sos, MPA', 0, 'C',0); 
   	// $this->setXY($x,$y+40);
    // $this->MULTICELL(80,5,'NIP. '.polanip('198001252010011011'), 0, 'C',0);
    
    $x=210;
    $this->setFont('arial','B',9);
    $this->setXY($x,$y+10);
    $this->MULTICELL(90,5,'Mengetahui,',0, 'C',0); 
    $this->setXY($x,$y+15);
    $this->MULTICELL(90,5,'KEPALA BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA KAB. BALANGAN',0, 'C',0); 
   	$this->setXY($x,$y+35);
    $this->MULTICELL(90,5, 'H. SUFRIANNOR, S.Sos, M.AP',0, 'C',0); 
   	$this->setXY($x,$y+40);
    $this->MULTICELL(90,5,'NIP. '.polanip('196810121989031009'),0, 'C',0);
    
    
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
$pdf->Content($parse);
$pdf->Output('rekapitulasi_instrumen_penilaian_kinerja.pdf', 'I');