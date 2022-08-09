<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{                      
                //$login = new mLogin();
                //$this->setFont('Arial','',9);
                //$this->setFillColor(255,255,255);
                //$this->cell(100,5,"Cetak Usul Cuti",0,0,'L',1); 
                //$this->setFont('Arial','I',8);
                //$this->cell(90,5,'Dicetak oleh '.$login->session->userdata('nama').' ('.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
                
                //$this->SetY(15);
                //buat garis horizontal
                //$this->Line(10,$this->GetY(),200,$this->GetY());
                
                /*
                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(20,3,'',0,0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 22,'8','10','jpeg');
                $this->cell(100,4,'Badan Kepegawaian, Pendidikan dan Pelatihan Daerah',0,1,'L',1); 
                $this->cell(20,3,'',0,0,'C',0); 
                $this->cell(100,6,"Profil PNS",0,1,'L',1); 
                */
                //$this->cell(100,6,"Nama : ".date('M Y'),0,1,'L',1); 
                //$this->cell(23,4,'',0,0,'C',0); 
                //$this->cell(100,6,'NIP : Semarang, Jawa Tengah',0,1,'L',1); 
                
                
                //$this->Ln(5);
                //$this->setFont('Arial','',10);
                //$this->setFillColor(230,230,200);
                //$this->cell(10,6,'No.',1,0,'C',1);
                //$this->cell(105,6,'Nama Lengkap',1,0,'C',1);
                //$this->cell(30,6,'No. HP',1,0,'C',1);
                //$this->cell(50,6,'Jenis Kelamin',1,1,'C',1);
                
	}
 
	function Content($data)
	{
          $mpeg = new Mpegawai();
          $munker = new Munker();
          $mcuti = new Mcuti();
          $mpeg->load->helper('fungsitanggal');
          $mpeg->load->helper('fungsipegawai');

          foreach ($data as $key) {            
            $y = 50;        

            $this->Ln(8);
            $this->setFont('Arial','',11);
            $this->setXY(140,$y);
            $this->setFillColor(255,255,255);
            $this->cell(60,5,"Balangan, ".tgl_indo($key->tgl_pengantar),0,1,'L',1); 
            $this->setXY(120,$y+10);
            $this->cell(60,5,"Kepada :",0,1,'L',1); 
            $this->setXY(112,$y+15);
            $this->cell(60,5,"Yth. Bupati Balangan",0,1,'L',1); 
            $this->setXY(120,$y+20);
            $this->cell(60,5,"U.p. Kepala BKPSDM",0,1,'L',1); 
            $this->setXY(120,$y+25);
            $this->cell(60,5,"Kabupaten Balangan",0,1,'L',1); 
            $this->setXY(120,$y+30);
            $this->cell(60,5,"di -",0,1,'L',1); 
            $this->setXY(130,$y+35);
            $this->setFont('Arial','U',11);
            $this->cell(60,5,"Paringin",0,1,'L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(25,$y+50);
            $this->cell(100,5,"Yang bertanda tangan dibawah ini :",0,1,'L',1); 
            $this->setXY(35,$y+55); $this->cell(50,5,"Nama",0,1,'L',1); 
            $this->setXY(85,$y+55); $this->cell(50,5,": ".$mpeg->mpegawai->getnama($key->nip),0,1,'L',1); 
            $this->setXY(35,$y+60); $this->cell(50,5,"NIP",0,1,'L',1); 
            $this->setXY(85,$y+60); $this->cell(50,5,": ".$key->nip,0,1,'L',1); 
            $this->setXY(35,$y+65); $this->cell(50,5,"Pangkat / Gol. Ruang",0,1,'L',1); 
            $this->setXY(85,$y+65); $this->cell(50,5,": ".$mpeg->mpegawai->getnamapangkat($key->fid_golru_skr)." / (".$mpeg->mpegawai->getnamagolru($key->fid_golru_skr).")",0,1,'L',1); 
            $this->setXY(35,$y+70); $this->cell(50,5,"Jabatan",0,1,'L',1); 
            $this->setXY(85,$y+70); $this->cell(2.5,5,":",0,1,'L',1); 
            
            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }
            
            $this->setFont('Arial','',10);
            $lenjab = strlen($mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab));
            //$this->setXY(87.5,$y+70); $this->MULTICELL(105,5,'0123456789 0123456789 0123456789 0123456789 0123456789','','L',1); 
            $this->setXY(87.5,$y+70); $this->MULTICELL(105,5,$mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab),'','J',1); 
            if ($lenjab <= 40) {
                $y = $y+5;
            } else if (($lenjab > 40) AND ($lenjab <= 80)) {
                $y = $y+10;
            } else if ($lenjab > 80) {
                $y = $y+15;
            }
            
            $this->setFont('Arial','',11);
            $this->setXY(35,$y+70); $this->cell(50,5,"Unit Kerja",0,1,'L',1); 
            $this->setXY(85,$y+70); $this->cell(2.5,5,":",0,1,'L',1); 
            $this->setFont('Arial','',10);
            $this->setXY(87.5,$y+70); $this->MULTICELL(105,5,$munker->munker->getnamaunker($key->fid_unit_kerja),'','L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(25,$y+85);
            $jnscuti = $mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti);

            // untuk cuti tahunan + cuti tunda
            if (($jnscuti == 'CUTI TAHUNAN') AND ($key->tambah_hari_tunda != 0)) {
                $thn_cuti_tunda = ($key->thn_cuti)-1;
                $this->MULTICELL(165,5,'Dengan ini mengajukan permintaan izin '.strtolower($jnscuti).' tahun '.$key->thn_cuti.' selama '.$key->jml.' ('.terbilang($key->jml, $style=2).') '.strtolower($key->satuan_jml).' kerja, ditambah cuti tunda tahun '.$thn_cuti_tunda.' selama '.$key->tambah_hari_tunda.' ('.terbilang($key->tambah_hari_tunda, $style=2).') hari, terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).'. Selama menjalankan cuti alamat saya adalah di '.$key->alamat.'.','','J',1);

            // untuk cuti tahunan tanpa cuti tunda
            } else if (($jnscuti == 'CUTI TAHUNAN') AND ($key->tambah_hari_tunda == 0)) {
                $this->MULTICELL(165,5,'Dengan ini mengajukan permintaan izin '.strtolower($jnscuti).' tahun '.$key->thn_cuti.' selama '.$key->jml.' ('.terbilang($key->jml, $style=2).') '.strtolower($key->satuan_jml).' kerja terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).'. Selama menjalankan cuti alamat saya adalah di '.$key->alamat.'.','','J',1);

            // untuk selain cuti tahunan
            } else {
                $this->MULTICELL(165,5,'Dengan ini mengajukan permintaan izin '.strtolower($mcuti->mcuti->getnamajeniscuti($key->fid_jns_cuti)).' selama '.$key->jml.' ('.terbilang($key->jml, $style=2).') '.strtolower($key->satuan_jml).' kerja terhitung mulai tanggal '.tgl_indo($key->tgl_mulai).' sampai dengan tanggal '.tgl_indo($key->tgl_selesai).'. Selama menjalankan cuti alamat saya adalah di '.$key->alamat.'.','','J',1);
            }

            $this->setXY(25,$y+110);
            $this->MULTICELL(165,5,'Demikian permohonan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya.','','J',1);

            $this->setXY(120,$y+120);
            $this->cell(70,5,"Hormat saya,",0,1,'C',1); 
            $this->setFont('Arial','U',11);
            $this->setXY(120,$y+140); $this->cell(70,5,$mpeg->mpegawai->getnama($key->nip),0,1,'C',1); 
            $this->setFont('Arial','',11);
            $this->setXY(120,$y+145); $this->cell(70,5,'NIP. '.$key->nip,0,1,'C',1); 

            $this->setFont('Arial','',10);
            $this->setXY(25,$y+160);
            $this->MULTICELL(80,5,'CATATAN PEJABAT KEPEGAWAIAN','LRT','J',1);
            $this->setXY(25,$y+165);
            $this->MULTICELL(80,95,'','LRB','J',1);
            $this->setXY(30,$y+170);
            $this->MULTICELL(70,5,$key->catatan_pej_kepeg,'','L',1);
            $this->setXY(55,$y+250);
            $this->MULTICELL(45,5,'.........................................','','L',1);

            $this->setXY(105,$y+160);
            $this->MULTICELL(85,5,'CATATAN PERTIMBANGAN ATASAN LANGSUNG','LRT','L',1);
            $this->setXY(105,$y+165);
            $this->MULTICELL(85,45,'','LRB','L',1);
            $this->setXY(110,$y+170);
            $this->MULTICELL(75,5,$key->catatan_atasan,'','L',1);
            $this->setXY(140,$y+200);
            $this->MULTICELL(45,5,'.........................................','','L',1);

            $this->setXY(105,$y+210);
            $this->MULTICELL(85,5,'KEPUTUSAN PEJABAT BERWENANG','LRT','L',1);
            $this->setXY(105,$y+215);
            $this->MULTICELL(85,45,'','LRB','L',1);
            $this->setXY(110,$y+215);
            $this->MULTICELL(75,5,$key->keputusan_pej,'','L',1);
            $this->setXY(140,$y+250);
            $this->MULTICELL(45,5,'.........................................','','L',1);
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
        $this->Cell(0,10,'SILKa Online ::: copyright BKPSDM Kabupaten Balangan ' . date('Y'),0,0,'L');		
	}
}
 
$pdf = new PDF('P', 'mm', 'Legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('usulcuti.pdf', 'I');
