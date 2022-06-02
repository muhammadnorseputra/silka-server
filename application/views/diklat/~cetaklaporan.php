<?php

class MYPDF extends TCPDF {
 function header(){
		$login = new mLogin();
        $peg = new mPegawai(); 	
        $this->SetXY(10,10);
        $this->setFont('dejavusans','',9);
        $this->setFillColor(255,255,255);
        $this->cell(120,5,"Daftar Nominatif Diklat per Unit Kerja | Jenis Jabatan ",0,0,'L',1); 
        $this->setFont('dejavusans','I',7);
        $this->cell(190,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
        //atur posisi 1.5 cm dari bawah
        $this->SetY(15);
        //buat garis horizontal
        $this->Line(10,$this->GetY(),320,$this->GetY());                

		$this->setFont('dejavusans','',12);
        $this->SetXY(200,8);
        $this->Cell(0, 15, 'LAMPIRAN', 0, false, 'R', 0, '', 0, false, 'M', 'M'); 
	
        }
function Content($data_rows){

	// header
	$this->ln();
	$this->Image('assets/logo.jpg', 10, 18,'10','13','jpeg');
    $this->SetFont('dejavusans', 'B', 12);
	$this->SetXY(23,20);
	$this->Cell(0, 15, 'DAFTAR REKOMENDASI DIKLAT DAN DIKLAT YANG TELAH DILAKSANAKAN ', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 		

	$this->ln();
    $this->SetFont('dejavusans', 'B', 12);
	$this->SetXY(23,26);
	$this->Cell(0, 15, 'DI LINGKUNGAN PEMERINTAH DAERAH KABUPATEN BALANGAN', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

	$y = 35;
	
	$this->SetY($y);
	$this->SetFont('helvetica', 'B', 8, '', true);
	
	//thead
	$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);

    $this->setCellPaddings(1,3,1,1);
	$this->MultiCell(10, 10, 'NO', 1,'C', 1, 0);

	$this->setCellPaddings(3,3,1,1);
	$this->MultiCell(52, 10, 'NAMA PNS', 1, 'L', 1, 0);

	$this->setCellPaddings(3,3,1,1);
	$this->MultiCell(73, 10, 'JABATAN', 1,'L', 1, 0);

	$this->setCellPaddings(2.5,3,1,1);
	$this->MultiCell(25, 10, 'TMT JABATAN', 1,'L', 1, 0);

	$this->setCellPaddings(1,3,1,1);
	$this->MultiCell(75, 10, 'REKOMENDASI DIKLAT', 1,'C', 1, 0);

	$this->setCellPaddings(1,3,1,1);
	$this->MultiCell(75, 10, 'RIWAYAT DIKLAT', 1,'C', 1, 1);

	//rows baru number
	$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(190,190,190);

	$this->setCellPaddings(1,2,1,1);
	$this->MultiCell(10, 7, '0', 1,'C', 1, 0);
	$this->MultiCell(52, 7, '1', 1,'C', 1, 0);
	$this->MultiCell(73, 7, '2', 1,'C', 1, 0);
	$this->MultiCell(25, 7, '3', 1,'C', 1, 0);
	$this->MultiCell(75, 7, '4', 1,'C', 1, 0);
	$this->MultiCell(75, 7, '5', 1,'C', 1, 0);

	//rows data
	$no = 1;
	$y = 30; 

	$mrek = new Mdiklat();
    $ukr = new Munker();

	$maxline=1;
	foreach ($data_rows as $key) {
	$maxline=$maxline % 10; 
	if($maxline == 0){
	// $lenunker = strlen($ukr->munker->getnamaunker($key->fid_unit_kerja));
 //    if ($lenunker <= 25) {
 //        $this->setFont('dejavusans','N',10);
 //        $this->setXY(24.5*9,17);$this->MULTICELL(100,2,$ukr->munker->getnamaunker($key->fid_unit_kerja)." *",'','R',1);
 //    } else if (($lenunker > 25) AND ($lenunker <= 60)) {
 //        $this->setFont('dejavusans','N',8);
 //        $this->setXY(24.5*9,17);$this->MULTICELL(100,2,$ukr->munker->getnamaunker($key->fid_unit_kerja)." *",'','R',1);
 //    } else if ($lenunker > 60) {
 //        $this->setFont('dejavusans','N',8);
 //        $this->setXY(24.5*9,17);$this->MULTICELL(100,2,$ukr->munker->getnamaunker($key->fid_unit_kerja)." *",'','R',1);
 //    }	
	$y = 40; 
	$this->AddPage(); 
	$this->SetFont('helvetica', 'B', 8, '', true);  
	//thead
	$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);

    $this->setCellPaddings(1,3,1,1);
	$this->MultiCell(10, 10, 'NO', 1,'C', 1, 0);

	$this->setCellPaddings(3,3,1,1);
	$this->MultiCell(52, 10, 'NAMA PNS', 1, 'L', 1, 0);

	$this->setCellPaddings(3,3,1,1);
	$this->MultiCell(73, 10, 'JABATAN', 1,'L', 1, 0);

	$this->setCellPaddings(2.5,3,1,1);
	$this->MultiCell(25, 10, 'TMT JABATAN', 1,'L', 1, 0);

	$this->setCellPaddings(1,3,1,1);
	$this->MultiCell(75, 10, 'REKOMENDASI DIKLAT', 1,'C', 1, 0);

	$this->setCellPaddings(1,3,1,1);
	$this->MultiCell(75, 10, 'RIWAYAT DIKLAT', 1,'C', 1, 1);

	//rows baru number
	$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(190,190,190);

	$this->setCellPaddings(1,2,1,1);
	$this->MultiCell(10, 7, '0', 1,'C', 1, 0);
	$this->MultiCell(52, 7, '1', 1,'C', 1, 0);
	$this->MultiCell(73, 7, '2', 1,'C', 1, 0);
	$this->MultiCell(25, 7, '3', 1,'C', 1, 0);
	$this->MultiCell(75, 7, '4', 1,'C', 1, 0);
	$this->MultiCell(75, 7, '5', 1,'C', 1, 0);
	}

	if($no > 0){

		################################################### - col 1
		$nip_peg = $key->nip;
		$nm_peg = trim($key->nama_pegawai)."\nNIP: ".$nip_peg;

		################################################### - col 2
		$esl_peg = "Eselon: ".$key->nama_eselon;

		$jbt_s = $key->nama_jabatan;
		$jbt_jfu = $key->nama_jabfu;
		$jbt_jft = $key->nama_jabft;

		if($jbt_s != '' ? $jabatan_s = $jbt_s : $jabatan_s = '');
		if($jbt_jfu != '' ? $jabatan_jfu = $jbt_jfu : $jabatan_jfu = '');
		if($jbt_jft != '' ? $jabatan_jft = $jbt_jft : $jabatan_jft = '');

		$jab_or = $jabatan_s."".$jabatan_jfu."".$jabatan_jft; 

		$col_2 = $jab_or."\n".$esl_peg; 

		################################################## - col 3
		$tmt_peg = $key->tmt_jabatan;		


		$this->Ln();
		$this->SetFont('helvetica', 'N', 8);
		$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);		

		$this->setCellPaddings(1,1.5,1,1);
		$this->MultiCell(10, 15, $no, 1,'C', 1, 0);
		$this->MultiCell(52, 15, $nm_peg, 1,'L', 1, 0);		
		$this->MultiCell(73, 15, $col_2, 1,'L', 1, 0);
		$this->MultiCell(25, 15, $tmt_peg, 1,'C', 1, 0);
		$this->MultiCell(75, 15, $mrek->md->getdatarekomendasi($key->fid_jabatan), 1,'L', 1, 0);
		$this->MultiCell(75, 15, $mrek->md->getdatariwayat($key->nip), 1,'L', 1, 0);
		
	}

    $maxline=$maxline+1;
	$no++;
	}
	
		$this->SetAutoPageBreak(TRUE, '0');		
}


// Page footer
function Footer() {

	    // Position at 15 mm from bottom
	    $this->SetY(-15);
	    // Set font
		$this->Line(10,$this->GetY(),320,$this->GetY());
	    $this->SetFont('helvetica', 'I', 8);
	    // Page number
        $this->Cell(0,10,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');
		$this->Cell(12, 10, 'Halaman '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	    
}   

}

$pdf = new MYPDF('L', 'mm', array('215','330'));
$pdf->setTitle("CETAK LAPORAN");
$pdf->SetDisplayMode($zoom='fullwidth', $layout='OneColumn', $mode='false');
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$pdf->SetMargins(10, 25, 10); // kiri, atas, kanan
$pdf->SetHeaderMargin(5); // mengatur jarak antara header dan top margin
$pdf->SetFooterMargin(10); //  mengatur jarak minimum antara footer dan bottom margin
$pdf->AddPage();
$pdf->Content($data_rows);
$pdf->Output('cetaklaporan.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>