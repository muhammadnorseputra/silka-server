<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{           

	}
 
	function Content($data)
	{        
        $ounker = new Munker();
        $mpeg = new Mpegawai();
        $mpeta = new Mpetajab();
        $this->Ln(8);
        $this->setFillColor(255,255,255);
        $this->setFont('Arial','',10);
        $this->setXY(32,16);
        $this->cell(100,27,'Dicetak pada ' .tglwaktu_indo(date('Y-m-d h:m:d')),0,1,'L',1);

        $x= 15;
        $y= 40;
        $this->setXY($x,$y);
        $this->MULTICELL(115,10,'JABATAN','LTR','C',1);
        $this->setXY($x+115,$y);
        $this->MULTICELL(10,10,'KLS','LTBR','C',1);
        $this->setXY($x+125,$y);
        $this->MULTICELL(10,10,'K/B','LTBR','C',1);
        $this->setXY($x+135,$y);
        $this->MULTICELL(50,10,'PEMANGKU','LTR','C',1);
        
        $y = 50;
        $no = 1;        
        $maxline=1;
        //$this->Line($x+185,$y+10,$x+185,$y+280); // Line tegak samping paling kanan
        foreach ($data as $key) {
            $this->Image('assets/logo.jpg', 15, 12,'15','20','jpeg');
            $this->setFont('Arial','',10);
            $this->setXY(32,12);$this->MULTICELL(200,5,'BADAN KEPEFGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA','','L',1);
            $this->setXY(32,17);$this->MULTICELL(200,5,'PETA JABATAN','','L',1);       
        
            //var_dump($data);
            $nmunker = $ounker->munker->getnamaunker($key->fid_unit_kerja);
            $this->setXY(32,22);
            $this->MULTICELL(200,5,$nmunker,'','L',1);

            $this->setFont('arial','',8);
            if ($key->fid_jnsjab == "1") {
            	$idjab = $key->fid_jabstruk;
            } else if ($key->fid_jnsjab == "2") {
            	$idjab = $key->fid_jabfu;
            } else if ($key->fid_jnsjab == "3") {
            	$idjab = $key->fid_jabft;
            }
            
            $nmjab = $mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab);
            if ($key->fid_atasan == "1") {
            	$atasan = "BUPATI BALANGAN";
            } else {
            	$atasan = $mpeta->mpetajab->get_namajabstruk($key->fid_atasan);            	
            }
  			
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            //$this->Line($x,$y+10,$x+190,$y+10); // Line diawal nama jabatan
	        $this->MULTICELL(115,10,$nmjab,'LTB','L',1);
	        $this->setFont('arial','IU',8);
	        //$this->setXY($x+15,$y+8);
	        //$this->MULTICELL(100,10,'Atasan Langsung : '.$atasan,'R','L',1);
	        $this->setFont('arial','',8);
	        $this->setXY($x+115,$y);
	        $this->MULTICELL(10,10,$key->kelas,'TB','C',1);
	        $this->setXY($x+125,$y);
	        $this->MULTICELL(10,10,$key->jml_kebutuhan." / ".$key->jml_bezzeting,'TB','C',1);

            //$nip = $mpeta->mpetajab->getnippegawai($key->fid_jnsjab, $idjab, $key->fid_unit_kerja);
            $nip = $mpeta->mpetajab->get_nippemangku($key->id);
            if ($nip) {
	            $nama = $mpeg->mpegawai->getnama($nip);	            
	            $this->setXY($x+135,$y);
	            $this->MULTICELL(50,5,$nama,'TR','L',1);
	            $this->setXY($x+135,$y+5);
	            $this->MULTICELL(50,5,'NIP. '.$nip,'BR','L',1); 
	        } else {
	        	$this->setXY($x+135,$y);
	            $this->MULTICELL(50,5,'','TR','L',1);
	            $this->setXY($x+135,$y+5);
	            $this->MULTICELL(50,5,'','BR','L',1);
	        }

	        $lev2 = $mpeta->mpetajab->get_jab_byatasan($key->fid_unit_kerja, $key->id)->result();
	        foreach ($lev2 as $l2) {
	        	$y=$y+10;	        	
            	$no=$no+1;
	        	$this->setFont('arial','',8);
            	if ($l2->fid_jnsjab == "1") {
            	$idjabl2 = $l2->fid_jabstruk;
	            } else if ($l2->fid_jnsjab == "2") {
	            	$idjabl2 = $l2->fid_jabfu;
	            } else if ($l2->fid_jnsjab == "3") {
	            	$idjabl2 = $l2->fid_jabft;
	            }
	        	$nmjab = $mpeg->mpegawai->namajab($l2->fid_jnsjab, $idjabl2);
	            $this->setXY($x+10,$y);	            	            
	           	$this->Line($x+10,$y+10,$x+120,$y+10); // Line diawal nama jabatan
	            $this->Line($x+10,$y,$x+10,$y+10); // Line diawal nama jabatan
		        $this->MULTICELL(105,4,$nmjab,'TR','L',0);
		        $this->setFont('arial','IU',8);
		        //$this->setXY($x+15,$y+8);
		        //$this->MULTICELL(100,4,'Atasan Langsung : '.$atasan,'R','L',1);
		        $this->setFont('arial','',8);
		        $this->setXY($x+115,$y);
		        $this->MULTICELL(10,10,$l2->kelas,'TB','C',1);
		        $this->setXY($x+125,$y);
		        $this->MULTICELL(10,10,$l2->jml_kebutuhan." / ".$l2->jml_bezzeting,'TB','C',1);

	            //$nip = $mpeta->mpetajab->getnippegawai($l2->fid_jnsjab, $idjabl2, $l2->fid_unit_kerja);
	            $nip = $mpeta->mpetajab->get_nippemangku($l2->id);
	            if ($nip) {
		            $nama = $mpeg->mpegawai->getnama($nip);	            
		            $this->setXY($x+135,$y);
		            $this->MULTICELL(50,5,$nama,'TR','L',1);
		            $this->setXY($x+135,$y+5);
		            $this->MULTICELL(50,5,'NIP. '.$nip,'BR','L',1); 
		        } else {
		        	$this->setXY($x+135,$y);
		            $this->MULTICELL(50,5,'','TR','L',1);
		            $this->setXY($x+135,$y+5);
		            $this->MULTICELL(50,5,'','BR','L',1);
		        }

		        $lev3 = $mpeta->mpetajab->get_jab_byatasan($l2->fid_unit_kerja, $l2->id)->result();
		        foreach ($lev3 as $l3) {
		        	$y=$y+10;	        	
	            	$no=$no+1;
		        	$this->setFont('arial','',8);
	            	if ($l3->fid_jnsjab == "1") {
	            		$idjabl3 = $l3->fid_jabstruk;
		            } else if ($l3->fid_jnsjab == "2") {
		            	$idjabl3 = $l3->fid_jabfu;
		            } else if ($l3->fid_jnsjab == "3") {
		            	$idjabl3 = $l3->fid_jabft;
		            }
		        	$nmjab = $mpeg->mpegawai->namajab($l3->fid_jnsjab, $idjabl3);
		            $this->setXY($x+20,$y);	            
			        $this->Line($x+20,$y+10,$x+110,$y+10); // Line diawal nama jabatan
		            $this->Line($x+20,$y,$x+20,$y+10); // Line diawal nama jabatan	            
		            $this->MULTICELL(95,4,$nmjab,'TR','L',0);
			        $this->setFont('arial','IU',8);
			        //$this->setXY($x+15,$y+8);
			        //$this->MULTICELL(100,4,'Atasan Langsung : '.$atasan,'R','L',1);
			        $this->setFont('arial','',8);
			        $this->setXY($x+115,$y);
			        $this->MULTICELL(10,10,$l3->kelas,'TB','C',1);
			        $this->setXY($x+125,$y);
			        $this->MULTICELL(10,10,$l3->jml_kebutuhan." / ".$l3->jml_bezzeting,'TB','C',1);

		            //$nip = $mpeta->mpetajab->getnippegawai($l3->fid_jnsjab, $idjabl3, $l3->fid_unit_kerja);
		            $nip = $mpeta->mpetajab->get_nippemangku($l3->id);
		            if ($nip) {
			            $nama = $mpeg->mpegawai->getnama($nip);	            
			            $this->setXY($x+135,$y);
			            $this->MULTICELL(50,5,$nama,'TR','L',1);
			            $this->setXY($x+135,$y+5);
			            $this->MULTICELL(50,5,'NIP. '.$nip,'BR','L',1); 
			        } else {
			        	$this->setXY($x+135,$y);
			            $this->MULTICELL(50,5,'','TR','L',1);
			            $this->setXY($x+135,$y+5);
			            $this->MULTICELL(50,5,'','BR','L',1);
			        }

			        // Level Pelaksana dibawah Pengawas
			        $lev4 = $mpeta->mpetajab->get_jab_byatasan($l3->fid_unit_kerja, $l3->id)->result();
			        foreach ($lev4 as $l4) {
			        	$y=$y+10;     	
		            	$no=$no+1;
			        	$this->setFont('arial','',8);
		            	if ($l4->fid_jnsjab == "1") {
		            		$idjabl4 = $l4->fid_jabstruk;
			            } else if ($l4->fid_jnsjab == "2") {
			            	$idjabl4 = $l4->fid_jabfu;
			            } else if ($l4->fid_jnsjab == "3") {
			            	$idjabl4 = $l4->fid_jabft;
			            }
			        	$nmjab = $mpeg->mpegawai->namajab($l4->fid_jnsjab, $idjabl4);
			            $this->setXY($x+30,$y);
			            //$this->Line($x+30,$y+10,$x+100,$y+10); // Line dibawah nama jabatan
			            
				        $this->MULTICELL(85,4,$nmjab,'LT','L',0);
				        $this->setFont('arial','IU',8);
				        //$this->setXY($x+15,$y+8);
				        //$this->MULTICELL(100,4,'Atasan Langsung : '.$atasan,'R','L',1);
				        $this->setFont('arial','',8);
				        $this->setXY($x+115,$y);
				        $this->MULTICELL(10,10,$l4->kelas,'T','C',1);
				        $this->setXY($x+125,$y);
				        $this->MULTICELL(10,10,$l4->jml_kebutuhan." / ".$l4->jml_bezzeting,'T','C',1);

			            //$nip = $mpeta->mpetajab->getnippegawai($l4->fid_jnsjab, $idjabl4, $l4->fid_unit_kerja);
			            $nipl5 = $mpeta->mpetajab->getnippemangku($l4->id)->result();
			            $this->Line($x+135,$y,$x+185,$y); // Line diatas nama pemangku
			            foreach ($nipl5 as $nl5) {
				            if ($nl5->nip) {				            	
					            $nama = $mpeg->mpegawai->getnama($nl5->nip);
					            $this->setFont('arial','',6);	            
					            $this->setXY($x+135,$y+1);
					            $this->MULTICELL(50,3,$nama,'R','L',1);
					            //$y=$y+3;
					            //$this->setXY($x+135,$y+5);
					            //$this->MULTICELL(50,5,'NIP. '.$nl5->nip,'BR','L',1); 
					        } else {
					        	$this->setXY($x+135,$y);
					            $this->MULTICELL(50,3,'','TR','L',1);
					            //$this->setXY($x+135,$y+5);
					            //$this->MULTICELL(50,5,'','BR','L',1);
					        }
					        $y=$y+3;			
					        $this->Line($x+30,$y,$x+30,$y+10); // Line diawal nama jabatan
					        $this->Line($x+185,$y-3,$x+185,$y+10); // Line diakhir nama pemmangku	
					    }	        
					    $this->Line($x+30,$y,$x+30,$y+10); // Line diawal nama jabatan
					    $this->Line($x+30,$y+10,$x+40,$y+10); // Line dibawah nama jabatan
					    $this->Line($x+185,$y-3,$x+185,$y+10); // Line diakhir nama pemmangku	

				        $lev5 = $mpeta->mpetajab->get_jab_byatasan($l4->fid_unit_kerja, $l4->id)->result();
				        foreach ($lev5 as $l5) {
				        	$y=$y+10;	        	
			            	$no=$no+1;
				        	$this->setFont('arial','',8);
			            	if ($l5->fid_jnsjab == "1") {
			            		$idjabl5 = $l5->fid_jabstruk;
				            } else if ($l5->fid_jnsjab == "2") {
				            	$idjabl5 = $l5->fid_jabfu;
				            } else if ($l5->fid_jnsjab == "3") {
				            	$idjabl5 = $l5->fid_jabft;
				            }
				        	$nmjab = $mpeg->mpegawai->namajab($l5->fid_jnsjab, $idjabl5);
				            $this->setXY($x+40,$y);
				            $this->Line($x+40,$y,$x+90,$y); // Line diawal nama jabatan
				            $this->Line($x+40,$y,$x+40,$y+10); // Line diawal nama jabatan
					        $this->MULTICELL(75,4,$nmjab,'T','L',0);
					        $this->setFont('arial','IU',8);
					        //$this->setXY($x+15,$y+8);
					        //$this->MULTICELL(100,4,'Atasan Langsung : '.$atasan,'R','L',1);
					        $this->setFont('arial','',8);
					        $this->setXY($x+115,$y);
					        $this->MULTICELL(10,10,$l5->kelas,'TB','C',1);
					        $this->setXY($x+125,$y);
					        $this->MULTICELL(10,10,$l5->jml_kebutuhan." / ".$l5->jml_bezzeting,'TB','C',1);

				            //$nip = $mpeta->mpetajab->getnippegawai($l5->fid_jnsjab, $idjabl5, $l5->fid_unit_kerja);
				            $nip = $mpeta->mpetajab->get_nippemangku($l5->id);
				            if ($nip) {
					            $nama = $mpeg->mpegawai->getnama($nip);	            
					            $this->setXY($x+135,$y);
					            $this->MULTICELL(50,5,$nama,'TR','L',1);
					            $this->setXY($x+135,$y+5);
					            $this->MULTICELL(50,5,'NIP. '.$nip,'BR','L',1); 
					        } else {
					        	$this->setXY($x+135,$y);
					            $this->MULTICELL(50,5,'','TR','L',1);
					            $this->setXY($x+135,$y+5);
					            $this->MULTICELL(50,5,'','BR','L',1);
					        }

					        if ($y >= 310) {
							    $this->AddPage();      
							    $y = 15;
							    $this->setFont('Arial','',10);
							    $this->setFillColor(255,255,255); 
							}

				        } // End level 5
				        if ($y >= 310) {
						    $this->AddPage();      
						    $y = 15;
						    $this->setFont('Arial','',10);
						    $this->setFillColor(255,255,255); 
						}
				        
			        } // End level 4
			        if ($y >= 310) {
				            $this->AddPage();      
				            $y = 15;
				            $this->setFont('Arial','',10);
				            $this->setFillColor(255,255,255); 
					}
		        } // End level 3
		        if ($y >= 310) {
				    $this->AddPage();      
				    $y = 15;
				    $this->setFont('Arial','',10);
				    $this->setFillColor(255,255,255); 
				}
	        } // End level 2

            //$y=$y+10;
            //$maxline=$maxline+1;
        }
	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
        $this->Cell(0,10,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');		
	}
}
 
$pdf = new PDF('P', 'mm', 'Legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('cetakpeta.pdf', 'I');
