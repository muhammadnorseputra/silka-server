<?php 
class PDF extends FPDF
{ 

  
  function Content($detail, $profile, $spesimen){
  	$mpeg  = new Mpegawai();
    $mun   = new Munker();
    $petruk   = new mpetruk();
    $login = new mLogin();
    $x= 35;
    $y= 0;
    
    $no = 1;        
    $maxline=1;  
    
  	if ($no==1) {
      // HEADER
      $this->ln();
      $this->SetFont('arial', 'B', 12);
      $this->SetXY($x,$y);
      $this->Image('assets/logo.jpg', 20, 5,'10','13','jpeg');
      $this->Cell(0, 15, 'PENILAIAN INSTRUMEN KINERJA (PETRUK)', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 		

      $this->ln();
      $this->SetXY($x,$y+5);
      $this->Cell(0, 15, 'DI LINGKUNGAN PEMERINTAH DAERAH KABUPATEN BALANGAN', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

      $this->ln();
      $this->SetFont('arial', '', 12);
      $this->SetXY($x,$y+10);
      $this->Cell(0, 15, $mun->munker->getnamaunker($detail->fid_unit_kerja), 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
      $this->Line(20,$y+23,202,$y+23);
      $this->Line(20,$y+58,202,$y+58);
    }
    
    $x= 20;
    $y= 25;
    $this->SetFont('arial', '', 10);
    
    //Line Nama Lengkap
    $this->ln();
    $this->SetXY($x,$y);
    $this->MultiCell(40, 8, "NAMA LENGKAP", 0, "L", false);
    $this->SetXY($x+40,$y);
    $this->MultiCell(5, 8, ":", 0, "C", false); 
    $this->SetXY($x+45,$y);
    $this->MultiCell(100, 8, namagelar($profile->gelar_depan, $profile->nama, $profile->gelar_belakang), 0, "L", false); 
  	
  	//Line NIP
  	$this->ln();
    $this->SetXY($x,$y+10);
    $this->MultiCell(40, 8, "NIP", 0, "L", false);
    $this->SetXY($x+40,$y+10);
    $this->MultiCell(5, 8, ":", 0, "C", false); 
    $this->SetXY($x+45,$y+10);
    $this->MultiCell(100, 8, polanip($detail->nip), 0, "L", false);
    
  	//Line Jabatan
  	$this->ln();
    $this->SetXY($x,$y+20);
    $this->MultiCell(40, 8, "JABATAN", 0, "L", false);
    $this->SetXY($x+40,$y+20);
    $this->MultiCell(5, 8, ":",  0, "C", false); 
    $this->SetXY($x+45,$y+21.5);
    $this->MultiCell(135, 5, $mpeg->mpegawai->namajabnip($detail->nip), 0, "L", false);
    // $this->SetXY($x+150,$y);
    // $this->SetFont('arial', 'B', 34);
    // $this->Cell(30, 25, $detail->skor_total, 1, false, 'C', 0, '', 0, false, 'M', 'M');
    // $this->SetXY($x+150,$y+25);
    // $this->SetFont('arial', '', 11);
    // $this->Cell(30, 5, "Total Score", 1, false, 'C', 0, '', 0, false, 'M', 'M');
    
    $x= 20;
    $y= 60;
    
    //Line Indikator Kinerja
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y);
    $this->MultiCell(182, 8, "KINERJA", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+8);
    $this->MultiCell(140, 7, "Merupakan nilai SKP Tahunan bedasarkan predikat kinerja yang diberikan oleh pejabat penilai kinerja. Predikat Kinerja yang dipersyarakan minimal BAIK.", 0, "L", false);
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x+150,$y+5);
    $this->MultiCell(32, 20, $detail->predikat_kinerja, "L", "C", false);
    
    //Line Indikator Disiplin
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+40);
    $this->MultiCell(182, 8, "DISIPLIN (Tingkat Kehadiran)", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+48);
    $this->MultiCell(140, 7, "Merupakan hasil data rekapitulasi tingkat kehadiran pegawai yang diperoleh dari data tingkat kehadiran pada SILKa, dalam 3 bulan terakhir", 0, "L", false);
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x+150,$y+45);
    $this->MultiCell(32, 20, $detail->persentase_disiplin	."%", "L", "C", false);
    
    //Line Indikator Inovasi
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+80);
    $this->MultiCell(182, 8, "INOVASI", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+90);
    $this->SetTextColor(10,80,16);
    $this->MultiCell(180, 5, $detail->inovasi, 0, "L", false);
    $this->SetTextColor(0,0,0);
    // $this->SetXY($x,$y+85);
    // if($detail->skor_inovasi == 10):
    // 	$this->MultiCell(140, 7, "inovasi ada pada SKPD yang bersangkutan, namun tidak dilakukan tindaklanjut sehingga belum bisa dimanfaatkan ke pihak lain 
		// 					yang memerlukan.", "T", "L", false);
    // elseif($detail->skor_inovasi == 20):
    // 	$this->MultiCell(140, 7, "inovasi ada pada SKPD yang bersangkutan, hanya dapat dimanfaatkan oleh individu yang bersangkutan karena alasan tersentu.", "T", "L", false);
    // elseif($detail->skor_inovasi == 30):
    // 	$this->MultiCell(140, 7, "inovasi ada pada SKPD yang bersangkutan, bisa memberikan manfaat bagi seluruh pegawai lingkup SKPD tersebut.", "T", "L", false);
    // elseif($detail->skor_inovasi == 40):
    // 	$this->MultiCell(140, 7, "inovasi yang ada mampu memberikan manfaat bagi seluruh SKPD ataupun masyarakat secara umum, sehingga mampu mendorong kinerja pegawai, kesejahteraan masyarakat.", "T", "L", false);
    // endif;
    // $this->SetXY($x+150,$y+65);
    // $this->MultiCell(32, 25, $detail->skor_inovasi." (score)", "L", "C", false);
    
    //Line Indikator Perilaku
  	// $this->ln();
    // $this->SetFont('arial', 'B', 12);
    // $this->SetXY($x,$y+110);
    // $this->MultiCell(182, 8, "Indikator Perilaku", 0, "L", false);
    // $this->ln();
    // $this->SetFont('arial', '', 12);
    // $this->SetXY($x,$y+118);
    // $this->MultiCell(140, 8, "Nilai e-Perilaku Tahun 2020 pegawai yang bersangkutan apabila memenuhi nilai lebih dari atau sama dengan 76, terpenuhi score 10", 0, "L", false);
    // $this->SetXY($x+150,$y+115);
    // $this->MultiCell(32, 20, $detail->skor_prilaku." (score)", "L", "C", false);
    
    //Line Indikator TeamWork
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+70);
    $this->MultiCell(182, 8, "TIM WORK : ".strtoupper($detail->predikat_timwork), 0, "L", false);
    // $this->ln();
    // $this->SetFont('arial', '', 12);
    // $this->SetXY($x,$y+78);
    // $this->MultiCell(180, 8, "Berkaitan dengan pengelolaan pekerjaan yang dilakukan oleh suatu tim (kelompok) untuk mencapai tujuan yang disepakati dilihat dari kemampuan memimpinnya (leadership), kemampuan berkomunikasi (communication) dengan atasan langsung, saling bekerja sama dengan rekan dalam satu level jenjang jabatan dan bawahan sehingga memberikan output yang sesuai dengan target yang ditetapkan.", 0, "L", false);
    // $this->SetXY($x+150,$y+115);
    // $this->MultiCell(32, 20, $detail->skor_timwork." (score)", "L", "C", false);
    
    $x = 95;
    
    // TTD
    $this->setFont('Arial','',11);
    $this->setXY($x+15,$y+188);
    $this->MultiCell(70,5,'Paringin, '.tgl_indo(date('Y-m-d')),0, "C", false); 
     
    
    $this->setXY($x,$y+193);
    if ($spesimen->status_spesimen == 'DEFINITIF') {
        $this->MultiCell(100,5,$spesimen->jabatan_spesimen,0,'C',0); 
    } else if ($spesimen->status_spesimen == 'PJ') {
        $this->MultiCell(100,5,'PENJABAT '.$spesimen->jabatan_spesimen,0,'C',0); 
    } else if ($spesimen->status_spesimen == 'PLT') {
        $this->MultiCell(100,5,'Plt. '.$spesimen->jabatan_spesimen,0,'C',0); 
    } else if ($spesimen->status_spesimen == 'PLH') {
        $this->MultiCell(100,5,'Plh. '.$spesimen->jabatan_spesimen,0,'C',0); 
    } else if ($spesimen->status_spesimen == 'AN') {
        $this->MultiCell(100,5,'A.n. '.$spesimen->jabatan_spesimen,0,'C',0); 
        $this->setXY(195,$y+30);
        if ($spesimen->nip_spesimen != '') {
            $this->MULTICELL(100,5,$mpeg->mpegawai->namajabnip($spesimen->nip_spesimen),0,'C',0);             
        }
    } else {
    	$this->setXY($x+15,$y+193);
    	$this->MultiCell(70,5,'Mengetahui,',0, "C", false);
    }
    
    if ($spesimen->nip_spesimen != '') {
      $this->setFont('Arial','U',11);
      $this->setXY($x,$y+230);
      $this->MultiCell(100,5,$mpeg->mpegawai->getnama($spesimen->nip_spesimen),0, "C", false); 
      $this->setFont('Arial','',11);
      $this->setXY($x,$y+235);
      $this->MultiCell(100,5,'NIP. '.polanip($spesimen->nip_spesimen),0, "C", false); 
    }
 

  }
  
  function Footer() {
    $this->SetY(-15);
    $this->SetX(20);
    $this->Line(20,$this->GetY(),202,$this->GetY());
    $this->SetFont('Arial','I',7);
    $this->Cell(0,5,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan ' . date('Y'),0,0,'L');
    $this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
  } 
  
}

$pdf = new PDF('P', 'mm', array('215','330'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($detail, $profile, $spesimen);
$pdf->Output('Penilaian Instrumen Kinerja (Petruk).pdf', 'I');