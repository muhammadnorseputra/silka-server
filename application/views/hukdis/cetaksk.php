<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{
    
                
	}

	function Content($data)
	{
        
        $opeg = new Mpegawai();
        $ounker = new Munker();
        $ohd = new Mhukdis();
        $opeg->load->helper('fungsitanggal');
        $opeg->load->helper('fungsipegawai');
        
        $y = 45;        
        
        foreach ($data as $key) {

            //$this->Ln(8);
            $this->setFont('Arial','',10);
            $this->setFillColor(255,255,255);
            //$this->Image(base_url().'assets/logo.jpg', 30, 12,'20','25','jpeg');
            $this->Image('assets/logo.jpg', 30, 12,'20','25','jpeg');
            $this->setFont('Arial','',18);
            $this->setXY(60,12);$this->MULTICELL(130,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
            $this->setFont('Arial','B',20);
            $nmunker = $ounker->munker->getnamaunker($opeg->mpegawai->getfidunker($key->nip));
            $lenunker = strlen($nmunker);
            if ($lenunker <= 25) {
                $this->setFont('Arial','B',24);
                $this->setXY(60,20);$this->MULTICELL(130,8,$nmunker,'','C',1);
            } else if (($lenunker > 25) AND ($lenunker <= 60)) {
                $this->setFont('Arial','B',20);
                $this->setXY(55,18);$this->MULTICELL(140,7,$nmunker,'','C',1);
            } else if ($lenunker > 60) {
                $this->setFont('Arial','B',15);
                $this->setXY(60,18);$this->MULTICELL(130,6,$nmunker,'','C',1);
            }
            
            $this->setFont('Arial','',10);
            $this->setXY(60,32);$this->MULTICELL(130,5,$ounker->munker->getalamatunker($opeg->mpegawai->getfidunker($key->nip)),'','C',1);
            
            //buat garis horizontal
            $this->Line(20,42,200,42);
            
            $this->setFont('Arial','',11);
            //$this->setXY(25,$y);
            //$this->MULTICELL(170,5,"KEPUTUSAN HUKUMAN DISIPLIN ".$ohd->mhukdis->getjnshukdis($key->fid_jenis_hukdis),'','C',1);
            $this->setFont('Arial','B',14);
            $this->setXY(25,$y+7.5);
            $this->MULTICELL(170,5,"RAHASIA",'','C',1);
        
            $this->setFont('Arial','',10);
            $this->setXY(25,$y+15);
            $this->MULTICELL(170,5,"KEPUTUSAN ".$opeg->mpegawai->namajabnip($key->nippejabat_sk)." ".$nmunker,'','C',1);
            $this->setXY(25,$y+20);
            $this->MULTICELL(170,5,"NOMOR. ".$key->no_sk,'','C',1);
            
            $this->setXY(25,$y+27.5);
            $this->setFont('Arial','',10);
            $this->MULTICELL(170,5,"DENGAN RAHMAT TUHAN YANG MAHA ESA",'','C',1);
            
            $y = $y-5;
            $this->setXY(20,$y+40);$this->CELL(30,5,"Membaca",0,1,'L',1);
            $this->setXY(45,$y+40);$this->CELL(5,5,":",0,1,'C',1);
            $this->setXY(50,$y+40);$this->MULTICELL(5,5,"1.",'0','J',1);
            $this->setXY(55,$y+40);$this->MULTICELL(145,5,"Berita Acara Pemeriksaan tanggal ".tgl_indo($key->pemeriksaan1_tgl),'0','J',1);
            if ($key->pemeriksaan2_tgl != null) {
                $this->setXY(50,$y+45);$this->MULTICELL(5,5,"2.",'0','J',1);
                $this->setXY(55,$y+45);$this->MULTICELL(145,5,"Berita Acara Pemeriksaan tanggal ".tgl_indo($key->pemeriksaan2_tgl),'0','J',1);
            }

            $this->setXY(20,$y+50);$this->CELL(30,5,"Menimbang",0,1,'L',1);
            $this->setXY(45,$y+50);$this->CELL(5,5,":",0,1,'C',1);
            
            $jnskel = $opeg->mpegawai->getjnskel($key->nip);
            if ($jnskel == "LAKI-LAKI") {
                $pgl = "Sdr";
            } else if ($jnskel == "PEREMPUAN") {
                $pgl = "Sdri";
            }

            $this->setXY(50,$y+50);$this->MULTICELL(5,5,"a.\n\n\nb.\n\nc.\n\nd.",'','J',1);
            // $this->setXY(55,$y+50);$this->MULTICELL(145,5,"Bahwa menurut hasil pemeriksaan tersebut, ".$pgl." ".$opeg->mpegawai->getnama($key->nip)." telah melakukan perbuatan berupa Tidak Masuk Kerja dan meninggalkan tugas serta tanggung jawab sebagai PNS;\nBahwa perbuatan tersebut merupakan pelanggaran terhadap ketentuan Pasal 3 angka 11 Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin Pegawai Negeri Sipil;\nBahwa untuk menegakkan disiplin, perlu menjatuhkan hukuman disiplin yang setimpal dengan pelanggaran disiplin yang dilakukannya;\nBahwa berdasarkan pertimbangan sebagaimana dimaksud dalam huruf a dan huruf b menetapkan Keputusan tentang Penjatuhan Hukuman Disiplin Teguran Lisan;"
            //     ,'0','J',1);
            $this->setXY(55,$y+50);$this->MULTICELL(145,5,"Bahwa menurut hasil pemeriksaan tersebut, ".$pgl." ".$opeg->mpegawai->getnama($key->nip)." telah melakukan perbuatan berupa Tidak Masuk Kerja dan meninggalkan tugas serta tanggung jawab sebagai PNS;\nBahwa perbuatan tersebut merupakan pelanggaran terhadap ketentuan Pasal 4 Huruf F Peraturan Pemerintah Nomor 94 Tahun 2021 tentang Disiplin Pegawai Negeri Sipil;\nBahwa untuk menegakkan disiplin, perlu menjatuhkan hukuman disiplin yang setimpal dengan pelanggaran disiplin yang dilakukannya;\nBahwa berdasarkan pertimbangan sebagaimana dimaksud dalam huruf a dan huruf b menetapkan Keputusan tentang Penjatuhan Hukuman Disiplin Teguran Lisan;"
                ,'0','J',1);

            $this->setXY(20,$y+95);$this->CELL(30,5,"Mengingat",0,1,'L',1);
            $this->setXY(45,$y+95);$this->CELL(5,5,":",0,1,'C',1);
            
            $this->setXY(50,$y+95);$this->MULTICELL(5,5,"1.\n2.\n3.\n\n4.",'','J',1);
            // $this->setXY(55,$y+95);$this->MULTICELL(145,5,"Undang-Undang Nomor 5 Tahun 2014 tentang Aparatur Sipil Negara;\nPeraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin Pegawai Negeri Sipil;\nPeraturan Kepala Badan Kepegawaian Negara Nomor 21 Tahun 2010 tentang Ketentuan Pelaksanaan Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin Pegawai Negeri Sipil;"
            //     ,'0','J',1);
            $this->setXY(55,$y+95);$this->MULTICELL(145,5,"Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara;\nPeraturan Pemerintah Nomor 94 Tahun 2021 tentang Disiplin Pegawai Negeri Sipil;\nPeraturan Bupati Balangan Nomor 92 Tahun 2022 Tentang Pedoman Pelaksanaan Penegakan Disiplin Pegawai Negeri Sipil;\nPeraturan Badan Kepegawaian Negara Nomor 6 Tahun 2022 tentang Peraturan Pelaksanaan Peraturan Pemerintah Nomor 94 Tahun 2021 tentang Disiplin Pegawai Negeri Sipil;"
                ,'0','J',1);            
            $this->setXY(20,$y+130);$this->MULTICELL(180,5,"MEMUTUSKAN",'0','C',1);           
            $this->setXY(20,$y+135);$this->CELL(30,5,"Menetapkan",0,1,'L',1);

            $this->setXY(20,$y+140);$this->CELL(30,5,"KESATU",0,1,'L',1);
            $this->setXY(45,$y+140);$this->CELL(5,5,":",0,1,'C',1);
            $this->setXY(50,$y+140);$this->MULTICELL(135,5,"Menjatuhkan hukuman disiplin berupa Teguran Lisan kepada :",'','J',1);
           
            $this->setXY(50,$y+140);$this->MULTICELL(20,5,"Nama\nNIP\nPangkat\nJabatan",'0','J',1);
            $this->setXY(65,$y+140);$this->MULTICELL(5,5,":\n:\n:\n:",'0','C',1);
            $this->setXY(70,$y+140);$this->MULTICELL(130,5,$opeg->mpegawai->getnama($key->nip)."\n".$key->nip."\n".$opeg->mpegawai->getnamapangkat($key->fid_golru)." (".$opeg->mpegawai->getnamagolru($key->fid_golru).")\n".$opeg->mpegawai->namajabnip($key->nip),'0','J',1);

            // $this->setXY(50,$y+170);$this->MULTICELL(150,5,"karena yang bersangkutan telah melakukan perbuatan yang melanggar ketentuan Pasal 3 angka 11 Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin Pegawai Negeri Sipil.",'0','J',1);
            $this->setXY(50,$y+163);$this->MULTICELL(150,5,"karena yang bersangkutan telah melakukan perbuatan yang melanggar ketentuan Pasal 4 Huruf F Peraturan Pemerintah Nomor 94 Tahun 2021.",'0','J',1);
            
            $this->setXY(20,$y+175);$this->CELL(30,5,"KEDUA",0,1,'L',1);
            $this->setXY(45,$y+175);$this->CELL(5,5,":",0,1,'C',1);
            $this->setXY(50,$y+175);$this->MULTICELL(150,5,"Keputusan ini mulai berlaku pada hari kerja ke-15 (lima belas) terhitung mulai tanggal PNS yang bersangkutan menerima keputusan atau hari kerja ke-15 (lima belas) sejak tanggal diterimanya keputusan Hukuman Disiplin yang dikirim ke alamat PNS yang bersangkutan.",'','J',1);

            $this->setXY(20,$y+190);$this->CELL(30,5,"KETIGA",0,1,'L',1);
            $this->setXY(45,$y+190);$this->CELL(5,5,":",0,1,'C',1);
            $this->setXY(50,$y+190);$this->MULTICELL(150,5,"Keputusan ini disampaikan kepada yang bersangkutan untuk dilaksanakan sebagaimana mestinya.",'0','J',1);

        }

        $this->setFont('Arial','',10);
        $this->setXY(115,$y+205); $this->cell(70,5,'Ditetapkan di  : Paringin',0,1,'L',1);
        $this->setXY(115,$y+210); $this->cell(70,5,'Pada Tanggal : '.tgl_indo($key->tgl_sk),0,1,'L',1);
        
        $this->setXY(100,$y+215);
        $this->setFont('Arial','B',10);

        $this->MULTICELL(100,5,$opeg->mpegawai->namajabnip($key->nippejabat_sk),0,'C',0); 
      
        $this->setFont('Arial','U',10);
        
        $this->setXY(115,$y+245); $this->cell(70,5,$opeg->mpegawai->getnama($key->nippejabat_sk),0,1,'C',1); 
        $this->setFont('Arial','',10);
        $this->setXY(115,$y+250); $this->cell(70,5,'NIP. '.$key->nippejabat_sk,0,1,'C',1); 

	}

	function Footer()
	{
		$x = 295;
		$this->SetFont('Arial','',9);
        $this->setXY(25,$x);$this->Cell(0,10,'Tembusan Yth.',0,0,'L');
        $this->setXY(25,$x+4);$this->Cell(0,10,'1. Bupati Balangan (sebagai laporan);',0,0,'L');		
	    $this->setXY(25,$x+8);$this->Cell(0,10,'2. Sekretaris Daerah Kabupaten Balangan;',0,0,'L');
        $this->setXY(25,$x+12);$this->Cell(0,10,'3. Inspektur Kabupaten Balangan;',0,0,'L');
        $this->setXY(25,$x+16);$this->Cell(0,10,'4. Kepala Badan Kepegawaian, Pendidikan dan Pelatihan Daerah Kabupaten Balangan;',0,0,'L');     
       
    }
}

$pdf = new PDF('P', 'mm', array('215','330'));
// posisi kertas landscape ukuran F4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('SK Hukdis.pdf', 'I');
