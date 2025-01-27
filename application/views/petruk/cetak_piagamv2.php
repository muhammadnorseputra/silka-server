<?php 
class PDF extends FPDF
{ 
	function Content($detail, $profile){
	
    $petruk = new mpetruk();
    
    $y= 0;
    //$this->SetMargins(5,5,5,5);
    $this->setFont('arial','B',11);
    //Nomor
    $this->setXY(200,$y);
    $this->MULTICELL(80,10,'Nomor : '.$detail->nomor_piagam, 0, 'L', 0); 
    //Logo
    $img_file = 'https://1.bp.blogspot.com/-Rohbf4rrQa4/X21VdqJIsnI/AAAAAAAAFaI/9autwaTm56ope2eO2aVAI2oYXdil8pNzgCLcBGAsYHQ/w1200-h630-p-k-no-nu/FRAME%2BSERTIFIKAT%2B2.jpg';
    $this->Image($img_file, 0, 0, 297, 215, '', '', '', false, 400, '', false, false, 0);
    $this->Image('assets/garuda.png', 135, $y+10, '45','45','png');
    //Sambutan
    $x = 100;
    $this->setFont('arial','B',14);
    $this->setXY($x,$y+60);
    $this->MULTICELL(120,8,'PIAGAM PENGHARGAAN', 0, 'C', 0);
    $this->setXY($x,$y+67);
    $this->MULTICELL(120,8,'DENGAN RAHMAT TUHAN YANG MAHA ESA', 0, 'C', 0);  
    $this->setXY($x,$y+75);
    $this->MULTICELL(120,8,'BUPATI BALANGAN', 0, 'C', 0);
    $this->setFont('arial','',12); 
    $this->setXY($x,$y+85);
    $this->MULTICELL(120,8,'Menganugerahkan Piagam Penghargaan', 0, 'C', 0);
    $this->setXY($x,$y+92);
    $this->MULTICELL(120,8,'Kepada:', 0, 'C', 0);
    $this->setFont('arial','B',14); 
    $this->setXY($x-55,$y+103);
    $this->MULTICELL(230,8,namagelar($profile->gelar_depan,$profile->nama,$profile->gelar_belakang).' / '.polanip($detail->nip), 0, 'C', 0);
		$this->setFont('arial','',12); 
		$this->setXY($x-30,$y+113);
    $this->MULTICELL(180,8,'Sebagai:', 0, 'C', 0);
		$this->setXY($x-30,$y+120);
    $this->MULTICELL(180,8,'Aparatur Sipil Negara Berprestasi/Berkinerja Terbaik', 0, 'C', 0);
    $this->setFont('arial','',14); 
		$this->setXY($x-30,$y+127);
    $this->MULTICELL(180,8, $petruk->namaunker($detail->fid_unit_kerja) , 0, 'C', 0);
    
    // TTD
    $this->setFont('arial','',12); 
    $this->setXY($x-55,$y+148);
    $this->MULTICELL(120,8, "Paringin, ".tgl_indo($detail->tgl_piagam), 0, 'C', 0);
    $this->setXY($x-55,$y+155);
    $this->MULTICELL(120,8, "BUPATI BALANGAN", 0, 'C', 0);
    $this->setFont('arial','B',12);
    $this->setXY($x-55,$y+182);
    $this->MULTICELL(120,9, "H. ABDUL HADI, S.Ag, M.I.Kom", 0, 'C', 0);
    
    $this->setFont('arial','',12); 
    $this->setXY($x+65,$y+150);
    $this->MULTICELL(100,5, "KEPALA BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA", 0, 'C', 0);
    $this->setFont('arial','UB',12);
    $this->setXY($x+55,$y+182);
    $this->MULTICELL(120,8, "H. SUFRIANNOR, S.Sos, M.AP", 0, 'C', 0);
    $this->setFont('arial','',12);
    $this->setXY($x+55,$y+189);
    $this->MULTICELL(120,5,'NIP. '.polanip('196810121989031009'),0, 'C',0);
    
    //FRAME
    // $x = 5;
    // $y = 5;
    // $this->SetLineWidth(2);
    // $this->Line($x,$y,290,$y);
    // $this->Line($x,$y,$x,$y+205);
    // $this->Line($x,$y+205,$x+287,$y+205);
    // $this->Line($x+287,$y+205,$x+287,$y);
	}
}

$pdf = new PDF('L', 'mm', array('215','297'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($detail, $profile);
$pdf->Output('PIAGAM PENGHARGAAN '.$profile->nama.' ('.$profile->nip.').pdf', 'I');