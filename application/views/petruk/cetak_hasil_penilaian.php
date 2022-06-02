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
    $this->MultiCell(100, 5, $mpeg->mpegawai->namajabnip($detail->nip), 0, "L", false);
    $this->SetXY($x+150,$y);
    $this->SetFont('arial', 'B', 34);
    $this->Cell(30, 25, $detail->skor_total, 1, false, 'C', 0, '', 0, false, 'M', 'M');
    $this->SetXY($x+150,$y+25);
    $this->SetFont('arial', '', 11);
    $this->Cell(30, 5, "Total Score", 1, false, 'C', 0, '', 0, false, 'M', 'M');
    
    $x= 20;
    $y= 60;
    
    //Line Indikator Kinerja
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y);
    $this->MultiCell(182, 8, "Indikator Kinerja", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+8);
    $this->MultiCell(140, 8, "Nilai e-Kinerja bulan Maret 2021 dengan kriteria lebih dari atau sama dengan 85, terpenuhi score 10", 0, "L", false);
    $this->SetXY($x+150,$y+5);
    $this->MultiCell(32, 20, $detail->skor_kinerja." (score)", "L", "C", false);
    
    //Line Indikator Disiplin
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+30);
    $this->MultiCell(182, 8, "Indikator Disiplin", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+38);
    $this->MultiCell(140, 6, "Persentase tingkat kehadiran pegawai yang bersangkutan pada bulan maret, apabila memenuhi kriteria realisasi lebih dari atau sama dengan 95%, terpenuhi score 10", 0, "L", false);
    $this->SetXY($x+150,$y+35);
    $this->MultiCell(32, 20, $detail->skor_disiplin." (score)", "L", "C", false);
    
    //Line Indikator Inovasi
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+60);
    $this->MultiCell(182, 8, "Indikator Inovasi", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+68);
    $this->SetTextColor(90,190,106);
    $this->MultiCell(140, 7, $detail->inovasi, 0, "L", false);
    $this->SetTextColor(0,0,0);
    $this->SetXY($x,$y+85);
    if($detail->skor_inovasi == 10):
    	$this->MultiCell(140, 7, "inovasi ada pada SKPD yang bersangkutan, namun tidak dilakukan tindaklanjut sehingga belum bisa dimanfaatkan ke pihak lain 
							yang memerlukan.", "T", "L", false);
    elseif($detail->skor_inovasi == 20):
    	$this->MultiCell(140, 7, "inovasi ada pada SKPD yang bersangkutan, hanya dapat dimanfaatkan oleh individu yang bersangkutan karena alasan tersentu.", "T", "L", false);
    elseif($detail->skor_inovasi == 30):
    	$this->MultiCell(140, 7, "inovasi ada pada SKPD yang bersangkutan, bisa memberikan manfaat bagi seluruh pegawai lingkup SKPD tersebut.", "T", "L", false);
    elseif($detail->skor_inovasi == 40):
    	$this->MultiCell(140, 7, "inovasi yang ada mampu memberikan manfaat bagi seluruh SKPD ataupun masyarakat secara umum, sehingga mampu mendorong kinerja pegawai, kesejahteraan masyarakat.", "T", "L", false);
    endif;
    $this->SetXY($x+150,$y+65);
    $this->MultiCell(32, 25, $detail->skor_inovasi." (score)", "L", "C", false);
    
    //Line Indikator Perilaku
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+110);
    $this->MultiCell(182, 8, "Indikator Perilaku", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+118);
    $this->MultiCell(140, 8, "Nilai e-Perilaku Tahun 2020 pegawai yang bersangkutan apabila memenuhi nilai lebih dari atau sama dengan 76, terpenuhi score 10", 0, "L", false);
    $this->SetXY($x+150,$y+115);
    $this->MultiCell(32, 20, $detail->skor_prilaku." (score)", "L", "C", false);
    
    //Line Indikator TeamWork
  	$this->ln();
    $this->SetFont('arial', 'B', 12);
    $this->SetXY($x,$y+140);
    $this->MultiCell(182, 8, "Indikator Tim Work", 0, "L", false);
    $this->ln();
    $this->SetFont('arial', '', 12);
    $this->SetXY($x,$y+148);
    $this->MultiCell(140, 8, "Nilai berada pada range 10-30, secara objektif dilakukan oleh Kepala SKPD yang bersangkutan sesuai dengan kriteria yang telah ditentukan.", 0, "L", false);
    $this->SetXY($x+150,$y+145);
    $this->MultiCell(32, 20, $detail->skor_timwork." (score)", "L", "C", false);
    
    $x = 85;
    
    // TTD
    $this->setFont('Arial','',11);
    $this->setXY($x+15,$y+178);
    $this->MultiCell(70,5,'Paringin, '.tgl_indo(date('Y-m-d')),0, "C", false); 
     
    
    $this->setXY($x,$y+183);
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
    	$this->setXY($x+15,$y+183);
    	$this->MultiCell(70,5,'Mengetahui,',0, "C", false);
    }
    
    if ($spesimen->nip_spesimen != '') {
      $this->setFont('Arial','U',11);
      $this->setXY($x,$y+210);
      $this->MultiCell(100,5,$mpeg->mpegawai->getnama($spesimen->nip_spesimen),0, "C", false); 
      $this->setFont('Arial','',11);
      $this->setXY($x,$y+215);
      $this->MultiCell(100,5,'NIP. '.polanip($spesimen->nip_spesimen),0, "C", false); 
    }
 

  }
  
  function Footer() {
    $this->SetY(-15);
    $this->SetX(20);
    $this->Line(20,$this->GetY(),202,$this->GetY());
    $this->SetFont('Arial','I',7);
    $this->Cell(0,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');
    $this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
  } 
  
}

$pdf = new PDF('P', 'mm', array('215','330'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($detail, $profile, $spesimen);
$pdf->Output('Penilaian Instrumen Kinerja (Petruk).pdf', 'I');