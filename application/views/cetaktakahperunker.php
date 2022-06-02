<?php
class PDF extends FPDF
{
    function Header()
    {                                      
        $login = new mLogin();
        $peg = new mPegawai();
        $mun = new Munker();

        $this->SetXY(20,10);
        $this->setFont('Arial','',9);
        $this->setFillColor(255,255,255);
        $this->cell(130,5,"Nominatif Tata Naskah Tahun ".date('Y'),0,0,'L',1); 
        $this->setFont('Arial','I',7);
        $this->cell(170,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1); 
        $this->SetY(15);
        //buat garis horizontal
        $this->Line(20,$this->GetY(),320,$this->GetY());              
    }

    function Content($result_data) { 
        $mpeg = new Mpegawai();
        $mun = new Munker();
        $takah = new mtakah();
        $login = new mLogin();

        $x= 20;
        $y= 35;

        $this->setFillColor(222,222,222);
        $this->setFont('arial','B',8);
        $this->setXY($x,$y);
        $this->MULTICELL(10,15,'NO.','LTR','C',1); 
        $this->setXY($x+10,$y);
        $this->MULTICELL(50,15,'NIP / NAMA','LTR','C',1);
        $this->setXY($x+60,$y);
        $this->MULTICELL(120,5,'NASKAH KEDINASAN','LTR','C',1);
        $this->setFont('arial','',7);
        $this->setXY($x+60,$y+5);
        $this->MULTICELL(20,10,'CPNS / PNS','LTR','C',1);
        $this->setXY($x+80,$y+5);
        $this->MULTICELL(20,5,'JABATAN TERKAHIR','LTR','C',1);
        $this->setXY($x+100,$y+5);
        $this->MULTICELL(20,5,'PANGKAT TERKAHIR','LTR','C',1);
        $this->setXY($x+120,$y+5);
        $this->MULTICELL(20,5,'IJAZAH TERKAHIR','LTR','C',1);
        $this->setXY($x+140,$y+5);
        $this->MULTICELL(20,5,'SKP TERKAHIR','LTR','C',1);
        $this->setXY($x+160,$y+5);
        $this->MULTICELL(20,5,'KGB TERKAHIR','LTR','C',1);
        $this->setFont('arial','B',8);
        $this->setXY($x+180,$y);
        $this->MULTICELL(120,5,'NASKAH PRIBADI','LTR','C',1);
        $this->setFont('arial','',7);
        $this->setXY($x+180,$y+5);
        $this->MULTICELL(15,10,'KTP','LTR','C',1);
        $this->setXY($x+195,$y+5);
        $this->MULTICELL(15,10,'NPWP','LTR','C',1);
        $this->setXY($x+210,$y+5);
        $this->MULTICELL(20,10,'KARIS / KARSU','LTR','C',1);
        $this->setXY($x+230,$y+5);
        $this->MULTICELL(15,10,'KARPEG','LTR','C',1);
        $this->setXY($x+245,$y+5);
        $this->MULTICELL(15,10,'TASPEN','LTR','C',1);
        $this->setXY($x+260,$y+5);
        $this->MULTICELL(20,10,'BUKU NIKAH','LTR','C',1);
        $this->setXY($x+280,$y+5);
        $this->MULTICELL(20,5,'AKTE KELAHIRAN','LTR','C',1);

        $this->setFillColor(255,255,255);
        $this->setFont('arial','',8);

        $y = 50;
        $no = 1;        
        $maxline=1;
        
        foreach ($result_data as $key) {
          if ($no==1) {
            $this->Ln(1);
            $this->setFillColor(255,255,255);
            $this->cell(20,3,'',0,0,'C',0); 
            $this->Image(base_url().'assets/logo.jpg', 20, 22,'8','10','jpeg');

            $this->setFont('Arial','B',10);
            $this->setXY(30,21);
            $this->cell(100,6,'TATA NASKAH PNS DI LINGKUNGAN PEMERINTAH KABUPATEN BALANGAN',0,1,'L',1);

            $this->setFont('Arial','',10);
            $this->setXY(30,27);
            $this->cell(100,4, $mun->munker->getnamaunker($key->fid_unit_kerja) ,0,1,'L',1); 
            $this->cell(20,3,'',0,0,'C',0); 
            
          }

          $maxline=$maxline % 10;            
          if ($maxline == 0) {
              $this->AddPage();                
              $y1 = 35;
              $y = 50;
              $this->Ln(7);
              $this->setFont('Arial','',10);
              $this->setFillColor(255,255,255);
              $this->cell(20,3,'',0,0,'C',0); 
              $this->Image(base_url().'assets/logo.jpg', 20, 22,'8','10','jpeg');

              $this->setFont('Arial','B',10);
              $this->setXY(30,21);
              $this->cell(100,6,'TATA NASKAH PNS DI LINGKUNGAN PEMERINTAH KABUPATEN BALANGAN',0,1,'L',1);
  
              $this->setFont('Arial','',10);
              $this->setXY(30,27);
              $this->cell(100,4, $mun->munker->getnamaunker($key->fid_unit_kerja) ,0,1,'L',1); 
              $this->cell(20,3,'',0,0,'C',0); 
              
              $this->setFont('Arial','',10);
              $this->setFillColor(222,222,222);
              $this->setFont('arial','B',8);
              $this->setXY($x,$y1);
              $this->MULTICELL(10,15,'NO.','LTR','C',1); 
              $this->setXY($x+10,$y1);
              $this->MULTICELL(50,15,'NIP / NAMA','LTR','C',1);
              $this->setXY($x+60,$y1);
              $this->MULTICELL(120,5,'NASKAH KEDINASAN','LTR','C',1);
              $this->setFont('arial','',7);
              $this->setXY($x+60,$y1+5);
              $this->MULTICELL(20,10,'CPNS / PNS','LTR','C',1);
              $this->setXY($x+80,$y1+5);
              $this->MULTICELL(20,5,'JABATAN TERKAHIR','LTR','C',1);
              $this->setXY($x+100,$y1+5);
              $this->MULTICELL(20,5,'PANGKAT TERKAHIR','LTR','C',1);
              $this->setXY($x+120,$y1+5);
              $this->MULTICELL(20,5,'IJAZAH TERKAHIR','LTR','C',1);
              $this->setXY($x+140,$y1+5);
              $this->MULTICELL(20,5,'SKP TERKAHIR','LTR','C',1);
              $this->setXY($x+160,$y1+5);
              $this->MULTICELL(20,5,'KGB TERKAHIR','LTR','C',1);
              $this->setFont('arial','B',8);
              $this->setXY($x+180,$y1);
              $this->MULTICELL(120,5,'NASKAH PRIBADI','LTR','C',1);
              $this->setFont('arial','',7);
              $this->setXY($x+180,$y1+5);
              $this->MULTICELL(15,10,'KTP','LTR','C',1);
              $this->setXY($x+195,$y1+5);
              $this->MULTICELL(15,10,'NPWP','LTR','C',1);
              $this->setXY($x+210,$y1+5);
              $this->MULTICELL(20,10,'KARIS / KARSU','LTR','C',1);
              $this->setXY($x+230,$y1+5);
              $this->MULTICELL(15,10,'KARPEG','LTR','C',1);
              $this->setXY($x+245,$y1+5);
              $this->MULTICELL(15,10,'TASPEN','LTR','C',1);
              $this->setXY($x+260,$y1+5);
              $this->MULTICELL(20,10,'BUKU NIKAH','LTR','C',1);
              $this->setXY($x+280,$y1+5);
              $this->MULTICELL(20,5,'AKTE KELAHIRAN','LTR','C',1);
              $maxline=$maxline+1;
          }     
          
            

            $this->setFillColor(255,255,255);
            $this->setFont('arial','',8);
            $this->setXY($x,$y);
            $this->MULTICELL(10,5,$no.'.','','C',1); 
            $this->setXY($x+10,$y);
            $this->MULTICELL(50,5,$key->nip,'','l',1);            
            $this->setXY($x+10,$y+5);
            $this->MULTICELL(50,5,namagelar($key->gelar_depan,$key->nama,$key->gelar_belakang),'','L',1);
            
            $this->setXY($x+65,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafilecp($key->nip),'','C',1);
            $this->setXY($x+85,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafilejab($key->nip),'','C',1);
            $this->setXY($x+105,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafilekp($key->nip),'','C',1);
            $this->setXY($x+125,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafileijazah($key->nip),'','C',1);
            $this->setXY($x+145,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafileskp($key->nip),'','C',1);
            $this->setXY($x+165,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafilekgb($key->nip),'','C',1);
            $this->setXY($x+183,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 1),'','C',1);
            $this->setXY($x+198,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 2),'','C',1);
            $this->setXY($x+215,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 3),'','C',1);
            $this->setXY($x+233,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 4),'','C',1);
            $this->setXY($x+248,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 5),'','C',1);
            $this->setXY($x+265,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 6),'','C',1);
            $this->setXY($x+285,$y+5);
            $this->MULTICELL(10,5,$takah->mtakah->__cek_adafiletakah($key->nip, 7),'','C',1);

            // garis vertikal            
            $this->Line($x,$y,$x,$y+15);
            $this->Line($x+10,$y,$x+10,$y+15);
            $this->Line($x+60,$y,$x+60,$y+15);
            $this->Line($x+80,$y,$x+80,$y+15);
            $this->Line($x+100,$y,$x+100,$y+15);
            $this->Line($x+120,$y,$x+120,$y+15);
            $this->Line($x+140,$y,$x+140,$y+15);
            $this->Line($x+160,$y,$x+160,$y+15);
            $this->Line($x+180,$y,$x+180,$y+15);
            $this->Line($x+195,$y,$x+195,$y+15);
            $this->Line($x+210,$y,$x+210,$y+15);
            $this->Line($x+230,$y,$x+230,$y+15);
            $this->Line($x+245,$y,$x+245,$y+15);
            $this->Line($x+260,$y,$x+260,$y+15);
            $this->Line($x+280,$y,$x+280,$y+15);
            $this->Line($x+300,$y,$x+300,$y+15);

            // garis horizontal
            $this->Line($x,$y,$x+300,$y);
            $this->Line($x,$y+15,$x+300,$y+15);

            $y=$y+15;
            $no=$no+1;
            $maxline=$maxline+1;
        }

      	$jmppeg = $mun->munker->getjmlpeg($key->fid_unit_kerja);

        $sisa = $jmppeg % 9;
        if (($sisa == 0) OR ($sisa == 8)) {
            $this->AddPage();
            $y = 15;
        }

        //$this->setFont('Arial','',10);
        //$this->setXY(60,$y+20);
        //$this->cell(70,5,'Dientri oleh, ',0,1,'C',1); 
        //$this->setXY(60,$y+45);
        //$this->setFont('Arial','U',10);
        //$this->cell(70,5,$mpeg->mpegawai->getnama($login->session->userdata('nip')),0,1,'C',1); 
        //$this->setFont('Arial','',10);
        //$this->setXY(60,$y+50);
        //$this->cell(70,5,'NIP. '.$login->session->userdata('nip'),0,1,'C',1); 

        $this->setFont('Arial','',10);
        $this->setXY(210,$y+10);
        $this->cell(70,5,'Paringin, '.tgl_indo(date('Y-m-d')),0,1,'C',1); 
        $this->setXY(210,$y+15);
        $this->cell(70,5,'Mengetahui,',0,1,'C',1); 
        $this->setXY(195,$y+20);

      if ($key->status_spesimen == 'DEFINITIF') {
          $this->MULTICELL(100,5,$key->jabatan_spesimen,0,'C',0); 
      } else if ($key->status_spesimen == 'PLT') {
          $this->MULTICELL(100,5,'Plt. '.$key->jabatan_spesimen,0,'C',0); 
      } else if ($key->status_spesimen == 'PLH') {
          $this->MULTICELL(100,5,'Plh. '.$key->jabatan_spesimen,0,'C',0); 
      } else if ($key->status_spesimen == 'AN') {
          $this->MULTICELL(100,5,'A.n. '.$key->jabatan_spesimen,0,'C',0); 
          $this->setXY(195,$y+30);
          if ($key->nip_spesimen != '') {
              $this->MULTICELL(100,5,$mpeg->mpegawai->namajabnip($key->nip_spesimen),0,'C',0);             
          }
      }
    
      if ($key->nip_spesimen != '') {
        $this->setFont('Arial','U',10);
        $this->setXY(210,$y+50);
        $this->cell(70,5,$mpeg->mpegawai->getnama($key->nip_spesimen),0,1,'C',1); 
        $this->setFont('Arial','',10);
        $this->setXY(210,$y+55);
        $this->cell(70,5,'NIP. '.$key->nip_spesimen,0,1,'C',1); 
      } else {
          //$this->setXY(210,$y+45);
          $this->Line(220,$y+50,270,$y+50);
          //$this->cell(70,5,'-------------------------------------',0,1,'C',1); 
      }


    }

    function Footer()
    {
      $this->SetY(-15);
          $this->SetX(20);
      $this->Line(20,$this->GetY(),320,$this->GetY());
      $this->SetFont('Arial','I',7);
      $this->Cell(0,5,'SILKa Online ::: copyright BKPPD Kabupaten Balangan ' . date('Y'),0,0,'L');
      $this->Cell(0,5,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }   

}

$pdf = new PDF('L', 'mm', array('215','330'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($result_data);
$pdf->Output('nominatif takah.pdf', 'I');