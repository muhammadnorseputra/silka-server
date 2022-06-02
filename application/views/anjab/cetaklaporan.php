<?php

class MYPDF extends TCPDF {
 function header(){
        $this->SetFont('helvetica', 'B', 12);

        $this->SetY(8);
        $this->SetX(200);
        $this->Cell(0, 15, 'LAMPIRAN', 0, false, 'R', 0, '', 0, false, 'M', 'M'); 

        $this->SetFont('dejavusans', 'B', 12);
		$this->SetY(25);
		$this->Cell(0, 15, 'DAFTAR NAMA JABATAN, KELAS JABATAN, DAN PEMANGKU JABATAN', 0, false, 'C', 0, '', 0, false, 'M', 'M'); 		

		$this->ln();
		$this->SetY(30);
		$this->Cell(0, 15, 'DI LINGKUNGAN PEMERINTAH KABUPATEN BALANGAN', 0, false, 'C', 0, '', 0, false, 'M', 'M'); 	
		
        }
function Content($data_rows){


		$this->ln();
		$this->SetFont('dejavusans', 'I', 8);
		$this->SetY(37);
		$this->Cell(0, 11, 'Tgl Cetak: '.date("d-m-Y"), 0, false, 'R', 0, '', 0, false, 'M', 'M'); 	

    $opeg = new Mpegawai();
    $ounker = new Munker();
    $opeg->load->helper('fungsitanggal');
    $opeg->load->helper('fungsipegawai');

		$yx = 40;
		

		$this->SetY($yx);
		$this->SetFont('helvetica', 'B', 8, '', true);
		
		//thead
		$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);

	    $this->setCellPaddings(1,5,1,1);
		$this->MultiCell(10, 15, 'NO', 1,'C', 1, 0);

		$this->setCellPaddings(1,5,1,1);
		$this->MultiCell(40, 15, 'NAMA JABATAN', 1, 'C', 1, 0);

		$this->setCellPaddings(1,5,1,1);
		$this->MultiCell(60, 15, 'UNIT KERJA', 1,'C', 1, 0);

		$this->setCellPaddings(1,3,1,1);
		$this->MultiCell(22, 15, 'KELAS JABATAN', 1, 'C', 1, 0);
		$this->SetFillColor(233,233,233);

		$this->setCellPaddings(1,1.5,1,1);
		$this->MultiCell(130, 8, 'PEMANGKU JABATAN', 1, 'C', 1, 1);

		$this->SetX($yx+102);
		$this->MultiCell(45, 7, 'NAMA', 1, 'C', 1, 0);	
		$this->MultiCell(45, 7, 'NIP', 1, 'C', 1, 0);	
		$this->MultiCell(40, 7, 'PANGKAT/GOLRU', 1, 'C', 1, 1);	

		$this->SetY(40);
		$this->SetX($yx+232);
		$this->SetFillColor(255,255,255);
	    $this->setCellPaddings(1,5,1,1);
		$this->MultiCell(48, 15, 'KETERANGAN', 1, 'C', 1, 1);	



		//rows baru number
		$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
		$this->SetFillColor(233,233,233);
		$this->SetTextColor(190,190,190);

		$this->setCellPaddings(1,1,1,1);
		$this->MultiCell(10, 5, '1', 1,'C', 1, 0);
		$this->MultiCell(40, 5, '2', 1,'C', 1, 0);
		$this->MultiCell(60, 5, '3', 1,'C', 1, 0);
		$this->MultiCell(22, 5, '4', 1,'C', 1, 0);
		$this->MultiCell(45, 5, '5', 1,'C', 1, 0);
		$this->MultiCell(45, 5, '6', 1,'C', 1, 0);
		$this->MultiCell(40, 5, '7', 1,'C', 1, 0);
		$this->MultiCell(48, 5, '8', 1,'C', 1, 0);

	//rows data
    $y = 45;     
	$no = 1; 
	$maxline=1;
	foreach ($data_rows as $key) {

	if($no >= 12){
		$maxline=$maxline % 12;
	}elseif($no <= 10){
		$maxline=$maxline % 10;	
	}	

	if($maxline == 0){
		$this->AddPage();
		$yx = 40;
		

		$this->SetY($yx);
		$this->SetFont('helvetica', 'B', 8, '', true);
		
		//thead
		$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);

	    $this->setCellPaddings(1,5,1,1);
		$this->MultiCell(10, 15, 'NO', 1,'C', 1, 0);

		$this->setCellPaddings(1,5,1,1);
		$this->MultiCell(40, 15, 'NAMA JABATAN', 1, 'C', 1, 0);

		$this->setCellPaddings(1,5,1,1);
		$this->MultiCell(60, 15, 'UNIT KERJA', 1,'C', 1, 0);

		$this->setCellPaddings(1,3,1,1);
		$this->MultiCell(22, 15, 'KELAS JABATAN', 1, 'C', 1, 0);
		$this->SetFillColor(233,233,233);

		$this->setCellPaddings(1,1.5,1,1);
		$this->MultiCell(130, 8, 'PEMANGKU JABATAN', 1, 'C', 1, 1);

		$this->SetX($yx+102);
		$this->MultiCell(45, 7, 'NAMA', 1, 'C', 1, 0);	
		$this->MultiCell(45, 7, 'NIP', 1, 'C', 1, 0);	
		$this->MultiCell(40, 7, 'PANGKAT/GOLRU', 1, 'C', 1, 1);	

		$this->SetY(40);
		$this->SetX($yx+232);
		$this->SetFillColor(255,255,255);
	    $this->setCellPaddings(1,5,1,1);
		$this->MultiCell(48, 15, 'KETERANGAN', 1, 'C', 1, 1);	



		//rows baru number
		$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
		$this->SetFillColor(233,233,233);
		$this->SetTextColor(190,190,190);

		$this->setCellPaddings(1,1,1,1);
		$this->MultiCell(10, 5, '1', 1,'C', 1, 0);
		$this->MultiCell(40, 5, '2', 1,'C', 1, 0);
		$this->MultiCell(60, 5, '3', 1,'C', 1, 0);
		$this->MultiCell(22, 5, '4', 1,'C', 1, 0);
		$this->MultiCell(45, 5, '5', 1,'C', 1, 0);
		$this->MultiCell(45, 5, '6', 1,'C', 1, 0);
		$this->MultiCell(40, 5, '7', 1,'C', 1, 0);
		$this->MultiCell(48, 5, '8', 1,'C', 1, 0);

	$maxline++;
	}


	$this->Ln();
	$this->SetFont('helvetica', 'N', 8);
	$this->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(120, 120, 120)));
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);

	$nj  = $key->nama_jabatan;
	$uk  = $key->unker;
	$kls = $key->kelas_jabatan;
	$nm  = $key->nama;
	$nip = $key->nip;
	$np  = $key->nama_pangkat;
	$gol = $key->nama_golru;


	if($nj != '' ? $nj_pns = $nj : $nj_pns = "");		
	if($uk != '' ? $uk_pns = $uk : $uk_pns = "");	
	if($kls != '0' ? $kls_pns = $kls : $kls_pns = "");	
	if($nm != '' ? $nm_pns = $nm : $nm_pns = "");	
	if($nip != '' ? $nip_pns = $nip : $nip_pns = "");	
	if($np != '' ? $np_pns = $np : $np_pns = "");	
	if($gol != '' ? $gol_pns = " (".$gol.") " : $gol_pns = "");

	//$this->setCellPaddings(1,1.5,1,1);
	$this->MultiCell(10, 10, $no, 1,'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	$this->MultiCell(40, 10, $nj_pns, 1,'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
	$this->MultiCell(60, 10, $uk_pns, 1,'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	$this->MultiCell(22, 10, $kls_pns, 1,'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	$this->MultiCell(45, 10, $nm_pns, 1,'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
	$this->MultiCell(45, 10, $nip_pns, 1,'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
	$this->MultiCell(40, 10, $np_pns ."". $gol_pns, 1,'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

	$nilai = $key->jml_mms;
	$ms    = "MEMENUHI SYARAT";
	$mms   = "MASIH MEMENUHI SYARAT";
	$kms   = "KURANG MEMENUHI SYARAT";

	$s_kls = $key->skor_kelas_jabatan;
	$s_gol = $key->skor_golru;
	$s_jur = $key->skor_jurusan;
	$s_jp  = $key->skor_jp;
	$s_skp = $key->skor_skp;
	$s_cs  = $key->skor_csakit;

	$jml_score = $key->jml_mms;
	$this->SetFont('helvetica', 'I', 8);
	if($s_kls != '0' && $s_gol != '0' && $s_jur != '0' && $s_jp != '0' && $s_skp != '0' && $s_cs != '0')
	{		
		$this->SetTextColor(0,0,255);
		$sts = $ms;
	}
	elseif($s_kls != '0' && $s_gol != '0' && $s_jur != '0' || $jml_score >= '0.7')
	{
		//$this->SetAlpha(0.5);
		$this->SetTextColor(0, 0, 0);
		$this->SetFillColor(178,255,175);
		$sts = $mms."\n SCORE(". $jml_score .")";

	}
	elseif($s_kls != '0' && $s_gol != '0' && $s_jur != '0' || $jml_score <= '0.7')
	{
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,204,204);
		$sts = $kms."\n SCORE (". $jml_score .")";
	}

	if($key->unker ==  '' && $key->kelas_jabatan == '0' && $key->nama ==  '' && $key->nip == '' && $key->nama_pangkat == '' && $key->nama_golru == '')
	{
		$this->SetTextColor(255,0,225);
		$this->SetFillColor(255,255,255);
		$ket = "FORMASI TERSEDIA";
	}else{
		$ket = $sts;
	}

	$this->MultiCell(48, 10, $ket, 1,'C', 1, 0, '', '', true, 0, false, true, 10, 'M');	


	$no++;
	$maxline++;
	}


	$kali = 1;
	foreach ($data_rows as $spe) {
		if($kali == 1){
			// set auto page breaks
			$this->SetAutoPageBreak(TRUE,'0');

			$x=210;
			$y=155;

			$this->SetTextColor(0,0,0);
			$this->SetFillColor(255,255,'255');
			$this->SetFont('helvetica', 'N', 11);		
			$this->setXY($x,$y);
	    	if ($spe->status == 'DEFINITIF') {
	    		$this->MULTICELL(100,10,$spe->jabatan_spesimen,0,'C',1 , 1); 
	    	} else if ($spe->status == 'PLT') {
	    		$this->MULTICELL(100,10,'Plt. '.$spe->jabatan_spesimen,0,'C',1 , 1);
	    	} else if ($spe->status == 'PLH') {
	    		$this->MULTICELL(100,10,'Plh. '.$spe->jabatan_spesimen,0,'C',1 , 1); 
	    	} else if ($spe->status == 'AN') {
	    		$this->MULTICELL(100,10,'A.n. '.$spe->jabatan_spesimen,0,'C',1 , 1);
	    	}


			$this->SetFont('helvetica', 'U', 11);
			$this->setXY($x+18,$y+30);	
			$this->MultiCell(65, 10, $opeg->mpegawai->getnama($key->nip_spesimen), 0, 'C', 1, 1);

			$this->SetFont('helvetica', 'N', 11);
			$this->setXY($x+18,$y+35);	
			$this->MultiCell(65, 10, "NIP ".$spe->nip_spesimen, 0, 'C', 1, 1);		
		}else{
			$this->Ln();
		}
		$kali--;

	}
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
// $pdf->SetDisplayMode($zoom='fullwidth', $layout='OneColumn', $mode='false');
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