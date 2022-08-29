<?php

class PDF extends FPDF
{     

    //Page header
	function Header()
	{                                      
                $login = new mLogin();
                $peg = new mPegawai();

                //$this->SetMargins(0,0,0);
                $this->SetXY(20,10);
                $this->setFont('Arial','',9);
                $this->setFillColor(255,255,255);
                $this->cell(130,5,"",0,0,'L',1); 
                $this->setFont('Arial','I',7);
                $this->cell(50,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                //atur posisi 1.5 cm dari bawah
                $this->SetY(15);
                //buat garis horizontal
                $this->Line(20,$this->GetY(),200,$this->GetY());
                
                
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->Image('assets/logo.jpg', 20, 20,'10','13','jpeg');
		$this->setXY(33,20);
		$this->MULTICELL(120,4,'Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia','','L',1);
		$this->setXY(33,25);
		$this->MULTICELL(120,4,'PROYEKSI PENSIUN BUP','','L',1);              
	}
 
	function Content($data)
	{
	
	$mpeg = new Mpegawai();
        $mun = new Munker();
        $x= 20;
        $y= 40;
	
        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,10,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(45,10,'NIP / NAMA','LTR','C',1);
        $this->setXY($x+55,$y);
        $this->MULTICELL(25,5,'TMP / TGL LAHIR','LTR','C',1);
        $this->setXY($x+80,$y);
        $this->MULTICELL(65,10,'JABATAN / UNIT KERJA','LTR','C',1);
        $this->setXY($x+145,$y);
        $this->MULTICELL(10,5,'GOLRU','LTR','C',1);
	$this->setXY($x+155,$y);
        $this->MULTICELL(10,5,'USIA BUP','LTR','C',1);
        $this->setXY($x+165,$y);
        $this->MULTICELL(15,10,'TMT BUP','LTR','C',1);
	
        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);
		
        $y = 50;
        $no = 1;        
        $maxline=1;
        foreach ($data as $v) {
            $maxline=$maxline % 18;            
            if ($maxline == 0) {
                $this->AddPage();                
                $y1 = 40;
                $y = 50;
                $this->Ln(8);
        	$this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->Image('assets/logo.jpg', 20, 20,'10','13','jpeg');
                $this->setXY(33,20);
                $this->MULTICELL(120,4,'Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia','','L',1);
                $this->setXY(33,25);
                $this->MULTICELL(120,4,'PROYEKSI PENSIUN BUP','','L',1);
        
		$this->setFillColor(222,222,222);
        	$this->setFont('arial','B',8);
        	$this->setXY($x,$y1);
        	$this->MULTICELL(10,10,'NO.','LTR','C',1);
        	$this->setXY($x+10,$y1);
        	$this->MULTICELL(45,10,'NIP / NAMA','LTR','C',1);
        	$this->setXY($x+55,$y1);
        	$this->MULTICELL(25,5,'TMP /  TGL LAHIR','LTR','C',1);
        	$this->setXY($x+80,$y1);
        	$this->MULTICELL(65,10,'JABATAN / UNIT KERJA','LTR','C',1);
        	$this->setXY($x+145,$y1);
        	$this->MULTICELL(10,5,'GOLRU','LTR','C',1);
		$this->setXY($x+155,$y1);
        	$this->MULTICELL(10,5,'USIA BUP','LTR','C',1);
        	$this->setXY($x+165,$y1);
        	$this->MULTICELL(15,10,'TMT BUP','LTR','C',1);
	
		$this->setFillColor(255,255,255);
        	$this->setFont('arial','',8);
                $maxline=$maxline+1;
            }
	
            $thn_lahir = substr($v['tgl_lahir'],0,4);
            $bln_lahir = substr($v['tgl_lahir'],5,2);
            $thn_bup = $thn_lahir + $v['usia_pensiun'];
            $nip = $v['nip'];

            if (($bln_lahir == 12) AND ($thn_bup == $v['tahun'])) {$thn_bup++;}
            if (($bln_lahir == 12) AND ($thn_bup == $v['tahun']-1)) {$thn_bup;}
	
            if (($thn_bup == $v['tahun']) OR (($thn_bup == $v['tahun']-1) AND ($bln_lahir == 12))) {
              	$this->setXY($x,$y); $this->MULTICELL(10,15,$no,'LTR','C',1);
		$this->setXY($x+10,$y); $this->MULTICELL(50,7.5,$mpeg->mpegawai->getnama($v['nip']),'LTR','L',1);
		$this->setXY($x+10,$y+7.5); $this->MULTICELL(45,7.5,"NIP. ".$v['nip'],'LR','L',1);
		$this->setFont('arial','',7);
		$this->setXY($x+55,$y); $this->MULTICELL(25,7.5,$v['tmp_lahir'],'LTR','L',1);
		$this->setXY($x+55,$y+7.5); $this->MULTICELL(25,7.5,tgl_indo($v['tgl_lahir']),'LR','L',1);
		$this->setFont('arial','',8);

		if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
            	}else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
            	}else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
            	}
		$this->setFont('arial','',7);
		$this->setXY($x+80,$y);
            	$this->MULTICELL(65,3.75,$mpeg->mpegawai->namajab($v['fid_jnsjab'],$idjab),'LTR','L',1);
		$this->setFont('arial','U',7);
		$this->setXY($x+80,$y+7.5);
                $this->MULTICELL(65,2.667,$mun->munker->getnamaunker($v['fid_unit_kerja']),'LR','L',1);
		$this->setFont('arial','',8);
		/*
                    $status = $this->mpensiun->getstatpeg($v['nip']);
                    if ($status == "PEGAWAI MPP") {
                      echo "<br/><span class='label label-success'>STATUS : PEGAWAI MPP</span>";
                      $jmlmpp++;
                    }
                $jnsjab = $this->mpip->getnamajnsjab($v['nip']);
                switch ($jnsjab) {
                    case "JPT-PRATAMA" : {$jmljpt++;break;}
                    case "ADMINISTRASI-ADMINISTRATOR" : {$jmladm++;break;}
                    case "ADMINISTRASI-PENGAWAS" : {$jmlpeng++;break;}
                    case "PELAKSANA" : {$jmljfu++;break;}
                    case "FUNGSIONAL" : {$jmljft++;break;}
                }
                echo $this->mpegawai->namajabnip($v['nip']).
                       "<br/><code>".$jnsjab."</code><br/>".
                       $this->munker->getnamaunker($v['fid_unit_kerja']);
		*/
		$this->setXY($x+145,$y); $this->MULTICELL(10,15,$mpeg->mpegawai->getnamagolru($v['fid_golru_skr']),'LTR','C',1);
		$this->setXY($x+155,$y); $this->MULTICELL(10,15,$v['usia_pensiun'],'LTR','C',1);
                $blntmt = $bln_lahir+1;
                if ($blntmt == 13) {
                    $blntmt = 1;
                    $thn_bup++;
                }
		/*
                switch ($blntmt) {
                    case 1 : {$jmljan++;;break;}
                    case 2 : {$jmlfeb++;break;}
                    case 3 : {$jmlmar++;break;}
                    case 4 : {$jmlapr++;break;}
                    case 5 : {$jmlmei++;break;}
                    case 6 : {$jmljun++;break;}
                    case 7 : {$jmljul++;break;}
                    case 8 : {$jmlagu++;break;}
                    case 9 : {$jmlsep++;break;}
                    case 10 : {$jmlokt++;break;}
                    case 11 : {$jmlnov++;break;}
                    case 12 : {$jmldes++;break;}
                }
		*/
		$this->setXY($x+165,$y); $this->MULTICELL(15,15,'1-'.$blntmt.'-'.$thn_bup,'LTR','L',1);
              	$no++;
		$y=$y+15;
		$maxline=$maxline+1;
	    }
	    
            // garis tegak
            //$this->Line($x+60,$y,$x+60,$y+15);            
           // $this->Line($x+200,$y,$x+200,$y+15);
            // garis mendatar
            $this->Line($x,$y,$x+180,$y);
        } 
	
	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
	        $this->SetX(20);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',7);
        	$this->setXY(20,310);        
        	$this->MULTICELL(200,5,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan','','L',0);
		//nomor halaman
        	$this->setXY(172,310);
		$this->MULTICELL(30,5,'Halaman '.$this->PageNo().' dari {nb}','','R',0);
	}
}

 
$pdf = new PDF('P', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('proyeksibup.pdf', 'I');
//$pdf->Output();
