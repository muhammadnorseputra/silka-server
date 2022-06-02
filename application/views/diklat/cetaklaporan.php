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
        
		$this->SetFont('helvetica', 'B', 10, '', true);  
		$html = '<table border="1" cellspacing="0" cellpadding="5">
					    <tr>
					        <th align="center" width="25"><b>NO</b></th>
					        <th align="left" width="170"><b>NAMA PNS</b></th>
					        <th align="left" width="175"><b>JABATAN</b></th>
					        <th align="center" width="80"><b>TMT JABATAN</b></th>
					        <th align="center" width="215"><b>REKOMENDASI DIKLAT</b></th>
					        <th align="center" width="215"><b>RIWAYAT DIKLAT</b></th>
					    </tr>';	
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
	$this->ln();

	$this->SetFont('helvetica', 'B', 10, '', true);  
	$html = '<table border="1" cellspacing="0" cellpadding="5">
				    <tr>
				        <th align="center" width="25"><b>NO</b></th>
				        <th align="left" width="170"><b>NAMA PNS</b></th>
				        <th align="left" width="175"><b>JABATAN</b></th>
				        <th align="center" width="80"><b>TMT JABATAN</b></th>
				        <th align="center" width="215"><b>REKOMENDASI DIKLAT</b></th>
				        <th align="center" width="215"><b>RIWAYAT DIKLAT</b></th>
				    </tr>';
	$no = 1;
	$mrek = new Mdiklat();
    $ukr = new Munker();
	$maxline=1;
	foreach ($data_rows as $key) {
	$maxline=$maxline % 12;
	if($maxline == 0){
	$this->AddPage();
	$html .= '<table border="1" cellspacing="0" cellpadding="5">
				    <tr>
				        <th align="center" width="25"><b>NO</b></th>
				        <th align="left" width="170"><b>NAMA PNS</b></th>
				        <th align="left" width="175"><b>JABATAN</b></th>
				        <th align="center" width="80"><b>TMT JABATAN</b></th>
				        <th align="center" width="215"><b>REKOMENDASI DIKLAT</b></th>
				        <th align="center" width="215"><b>RIWAYAT DIKLAT</b></th>
				    </tr>';
	$maxline++;
	}

	$lenunker = strlen($ukr->munker->getnamaunker($key->fid_unit_kerja));

    	if ($lenunker <= 25) {
        $this->setFont('dejavusans','N',10);
        $this->setXY(27.5*10,17);
        $this->Cell(0,5,$ukr->munker->getnamaunker($key->fid_unit_kerja)." *",'','R',0);
       
    	} elseif (($lenunker > 25) AND ($lenunker <= 60)) {
        $this->setFont('dejavusans','N',8);
        $this->setXY(22*10,17);
        $this->Cell(0,5,$ukr->munker->getnamaunker($key->fid_unit_kerja)." *",'','R',0);
        
    	} elseif ($lenunker > 60) {
        $this->setFont('dejavusans','N',8);
        $this->setXY(20*10,17);
        $this->Cell(0,5,$ukr->munker->getnamaunker($key->fid_unit_kerja)." *",'','R',0);
 
    	}
	
	################################################### - col 1
	$nip_peg = $key->nip;
	$nm_peg = trim($key->nama_pegawai)."<br>NIP: ".$nip_peg;	
	################################################### - col 2
	$esl_peg = "Eselon: ".$key->nama_eselon;

	$jbt_s = $key->nama_jabatan;
	$jbt_jfu = $key->nama_jabfu;
	$jbt_jft = $key->nama_jabft;

	if($jbt_s != '' ? $jabatan_s = $jbt_s : $jabatan_s = '');
	if($jbt_jfu != '' ? $jabatan_jfu = $jbt_jfu : $jabatan_jfu = '');
	if($jbt_jft != '' ? $jabatan_jft = $jbt_jft : $jabatan_jft = '');

	$jab_or = $jabatan_s."".$jabatan_jfu."".$jabatan_jft; 

	$col_2 = $jab_or."<br>".$esl_peg; 

	$tmt_peg = $key->tmt_jabatan;

	//REKOMENDASI STRUKTURAL OTOMATIS 
	$esl = $key->nama_eselon;
	if($esl == 'II/A' || $esl == 'II/B'){
		$r_struktural = array('PIM II','PIM III','PIM IV');
	}elseif($esl == 'III/A' || $esl == 'III/B'){
		$r_struktural = array('PIM III','PIM IV','PRAJABATAN');
	}elseif($esl == 'IV/A' || $esl == 'IV/B' || $esl == 'IV/C' || $esl == 'IV/D'){
		$r_struktural = array('PIM IV','PRAJABATAN');
	}else{
		$r_struktural = array('');
	}
	$req = '';
	for($i=0;$i<count($r_struktural); $i++){
		if(count($r_struktural)>0){
			$req .= "- ".$r_struktural[$i]."<br>";
		}else{
			$req .= "";	
		}
	}

	$this->SetFont('helvetica', 'N', 8, '', true);  	
	$this->setXY(10,35);
	$html .= '<tr>
			        <th align="center" width="25">'.$no.'.</th>
			        <th align="left" width="170">'.$nm_peg.'</th>
			        <th align="left" width="175">'.$col_2.'</th>
			        <th align="center" width="80" vlign="middle">'.$tmt_peg.'</th>
			        <th align="left" width="215">#<span style="color:darkorange;"> Struktural</span><br>'.$req.'
			        	<br># <span style="color:blue;">Teknis</span> <span style="color:green;">Fungional</span> 
			        	<br>'.$mrek->md->getdatarekomendasi($key->fid_jabatan).'
			        </th>
			        <th align="left" width="215">#<span style="color:darkorange;"> Struktural</span> 
			        	<br>'.$mrek->md->getdatariwayat($key->nip).'
			        	<br>#<span style="color:blue;"> Teknis</span> <span style="color:green;"> Fungsional</span>
			        	'.$mrek->md->getdatariwayat_fungsional($key->nip).'
			        	<br>'.$mrek->md->getdatariwayat_teknis($key->nip).'
			        </th>
			    </tr>';
	$no++;
    }
	$html .= '</table>';

	// output the HTML content
	$this->writeHTML($html, true, false, true, false, '');	
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
