<?php 

class PDF extends FPDF
{ 
  
  function Content($parseData){
		foreach ($parseData['data'] as $d) 
		{
			//KOP KWITANSI
			$x = 15;
			$y = 15;
			$this->Image('assets/logo-balangan-blackwhite.png',$x+80,$y-8,20,23);
			$this->setFont('arial','B',11);
	    $this->setXY($x,$y+15);
	    $this->cell(180,10,'K W I T A N S I',0,1,'C',0);
	    
	    $this->setFont('arial','B',10);
	    $this->setXY($x,$y+20);
	    $this->cell(50,10,'SUDAH TERIMA DARI',0,1,'L',0); 
	    $this->setXY($x+40,$y+20);
	    $this->cell(5,10,':',0,1,'C',0); 
	    $this->setXY($x+50,$y+20);
	    $this->cell(50,10,'PENGELOLA IURAN KORPRI DAERAH KABUPATEN BALANGAN',0,1,'L',0); 
	    
	    $this->setXY($x,$y+30);
	    $this->cell(50,10,'UANG SEJUMLAH',0,1,'L',0); 
	    $this->setXY($x+40,$y+30);
	    $this->cell(5,10,':',0,1,'C',0); 
	    $this->setXY($x+50,$y+30);
	    $this->cell(5,10,'Rp '.nominal($d->besar_santunan),0,1,'L',0); 
	    
	    $this->setXY($x,$y+40);
	    $this->cell(50,10,'TERBILANG',0,1,'L',0); 
	    $this->setXY($x+40,$y+40);
	    $this->cell(5,10,':',0,1,'C',0); 
	    $this->setXY($x+50,$y+40);
	    $this->cell(5,10,terbilang($d->besar_santunan, 3)." Rupiah",0,1,'L',0); 
	    
	    $this->setXY($x,$y+50);
	    $this->cell(50,10,'UNTUK PEMBAYARAN',0,1,'L',0); 
	    $this->setXY($x+40,$y+50);
	    $this->cell(5,10,':',0,1,'C',0); 
	    $this->setXY($x+50,$y+52);
	    $this->MultiCell(140,5,$d->note,0,1,false);
	    
	    // PENANGGUNG JAWAB
	    $x = 15;
	    $y = 80;
	    $this->setFont('arial','',10);
	    $this->setXY($x+95,$y);
	    $this->cell(60,10,'Paringin, '.tgl_indo($d->tgl_cetak),0,1,'L',0); 
	    $this->setXY($x+95,$y+5);
	    $this->cell(60,10,'Yang Menerima',0,1,'L',0); 
	    $this->setXY($x+95,$y+30);
	    $this->cell(50,10,namagelar($d->gelar_depan, $d->nama, $d->gelar_belakang),0,1,'L',0); 
	    
	    $this->setXY($x,$y+5);
	    $this->cell(50,10,'Pengelola Iuran',0,1,'L',0); 
	    $this->setXY($x,$y+25);
	    $this->cell(50,10,'MARJANAH',0,1,'L',0); 
	    $this->setXY($x,$y+30);
	    $this->cell(50,10,'NIP. '.polanip("197412292007012008"),0,1,'L',0); 
	    
	    $this->setXY($x,$y+40);
	    $this->cell(50,10,"Mengetahui",0,1,'L',0); 
	    $this->setXY($x,$y+45);
	    $this->cell(50,10,"Ketua DP KORPRI Kab Balangan",0,1,'L',0); 
	    $this->setXY($x,$y+65);
	    $this->cell(50,10,'H. SUTIKNO, M.AP',0,1,'L',0); 
	    $this->setXY($x,$y+70);
	    $this->cell(50,10,'NIP. '.polanip("197604171994121001"),0,1,'L',0); 
	    
	    $this->setXY($x+95,$y+40);
	    $this->cell(60,10,'Lunas dibayar oleh',0,1,'L',0); 
	    $this->setXY($x+95,$y+45);
	    $this->cell(60,10,'Sekretaris DP KORPRI',0,1,'L',0); 
	    $this->setXY($x+95,$y+65);
	    $this->cell(50,10,'H. SUFRIANNOR, S.Sos, M.AP',0,1,'L',0); 
	    $this->setXY($x+95,$y+70);
	    $this->cell(50,10,'NIP. '.polanip("196810121989031009"),0,1,'L',0); 
	    
		}
  }

}

$pdf = new PDF('P', 'mm', array('215','330'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($parseData);
$pdf->Output($parseData['id'].'_santunan.pdf', 'I');