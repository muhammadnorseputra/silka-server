<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{                      
	}
 
	function Content($data)
	{
        $mpeg = new Mpegawai();
        $munker = new Munker();
        $mcuti = new Mcuti();
        $mpeg->load->helper('fungsitanggal');
        $mpeg->load->helper('fungsipegawai');
        $mpeg->load->helper('fungsipegawai');

        foreach ($data as $key) {
            
            $this->Ln(8);
            $this->setFillColor(255,255,255);

            $this->Image('assets/logo.jpg', 30, 12,'20','25','jpeg');
            $this->setFont('Arial','',18);
            $this->setXY(60,12);$this->MULTICELL(130,5,'PEMERINTAH KABUPATEN BALANGAN','','C',1);
            $this->setFont('Arial','B',20);

            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }
            
            $nmjab = $mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab);

            if (($key->nama_eselon == 'II/A') OR ($key->nama_eselon == 'II/B') OR ($nmjab == 'CAMAT') OR ($nmjab == 'DIREKTUR')) {
                $this->setFont('Arial','B',30);
                $this->setXY(55,21);$this->MULTICELL(140,7,'SEKRETARIAT DAERAH','','C',1);
                $this->setFont('Arial','',10);
                $this->setXY(55,30);$this->MULTICELL(140,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028408 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);
            } else {
                $this->setFont('Arial','B',20);
                $this->setXY(55,18);$this->MULTICELL(140,7,'BADAN KEPEGAWAIAN, PENDIDIKAN DAN PELATIHAN DAERAH','','C',1);
                $this->setFont('Arial','',10);
                $this->setXY(55,32);$this->MULTICELL(140,5,'Jln. A. Yani Km. 4,5 Telp/Fax. (0526) 2028060 Kel. Batu Piring Kec. Paringin Selatan Kab. Balangan, Kode Pos 71462','','C',1);

                
            }                      
            
            //buat garis horizontal
            $this->Line(20,42,200,42);

            $y = 50;

            $this->Ln(8);
            $this->setFont('Arial','UB',16);
            $this->setFillColor(255,255,255);
            $this->setXY(20,$y+10);
            $this->cell(180,5,"SURAT IZIN CUTI TAHUNAN",0,1,'C',1); 
            //$this->cell(180,5,"SURAT IZIN CUTI TAHUNAN",0,1,'C',1); 
            $this->setFont('Arial','',11);
            $this->setXY(20,$y+15);
            $this->cell(180,5,"Nomor : ".$key->no_sk,0,1,'C',1); 

            $this->setXY(25,$y+30);
            $this->MULTICELL(170,5,"Sehubungan dengan surat pengantar Kepala ".$munker->munker->getnamaunker($key->fid_unit_kerja)." Nomor. ". $key->no_pengantar." Tanggal ".tgl_indo($key->tgl_pengantar)." Perihal Permohonan cuti tahunan tunda. Disampaikan bahwa Pegawai Negeri Sipil :",'','J',1); 
            $y=$y+10;
            $this->setXY(35,$y+40); $this->cell(50,5,"Nama",0,1,'L',1); 
            $this->setXY(85,$y+40); $this->cell(50,5,": ".$mpeg->mpegawai->getnama($key->nip),0,1,'L',1); 
            $this->setXY(35,$y+45); $this->cell(50,5,"NIP",0,1,'L',1); 
            $this->setXY(85,$y+45); $this->cell(50,5,": ".$key->nip,0,1,'L',1); 
            $this->setXY(35,$y+50); $this->cell(50,5,"Pangkat / Gol. Ruang",0,1,'L',1); 
            $this->setXY(85,$y+50); $this->cell(50,5,": ".$mpeg->mpegawai->getnamapangkat($key->fid_golru_skr)." / (".$mpeg->mpegawai->getnamagolru($key->fid_golru_skr).")",0,1,'L',1); 
            $this->setXY(35,$y+55); $this->cell(50,5,"Jabatan",0,1,'L',1); 
            $this->setXY(85,$y+55); $this->cell(2.5,5,":",0,1,'L',1); 
            
            if ($key->fid_jnsjab == 1) { $idjab = $key->fid_jabatan;
            }else if ($key->fid_jnsjab == 2) { $idjab = $key->fid_jabfu;
            }else if ($key->fid_jnsjab == 3) { $idjab = $key->fid_jabft;
            }
            
            $this->setFont('Arial','',10);
            $lenjab = strlen($mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab));
            //$this->setXY(87.5,$y+70); $this->MULTICELL(105,5,'0123456789 0123456789 0123456789 0123456789 0123456789','','L',1); 
            $this->setXY(87.5,$y+55); $this->MULTICELL(105,5,$mpeg->mpegawai->namajab($key->fid_jnsjab, $idjab),'','J',1); 
            if ($lenjab <= 40) {
                $y = $y+5;
            } else if (($lenjab > 40) AND ($lenjab <= 80)) {
                $y = $y+10;
            } else if ($lenjab > 80) {
                $y = $y+15;
            }
            
            $this->setFont('Arial','',11);
            $this->setXY(35,$y+55); $this->cell(50,5,"Unit Kerja",0,1,'L',1); 
            $this->setXY(85,$y+55); $this->cell(2.5,5,":",0,1,'L',1); 
            $this->setFont('Arial','',10);
            $this->setXY(87.5,$y+55); $this->MULTICELL(105,5,$munker->munker->getnamaunker($key->fid_unkerpeg),'','L',1); 
            $this->setFont('Arial','',11);

            $this->setXY(25,$y+70);

            $thnberikutnya = ($key->tahun)+1;
            $this->MULTICELL(165,5,'Sesuai dengan catatan / pertimbangan atasan langsung, cuti tahunan PNS tersebut diatas ditunda, maka kepada yang bersangkutan dapat mengajukan kembali cuti tahunan tahun '.$key->tahun.' pada tahun '.$thnberikutnya.', dengan ketentuan melampirkan surat izin cuti tunda ini','','J',1);                
            
            $this->setXY(25,$y+90);
            $this->MULTICELL(165,5,'Demikian surat izin cuti tahunan tunda ini dibuat untuk dipergunakan sebagaimana mestinya.','','J',1);

            $this->setXY(110,$y+110);
            $this->cell(70,5,"Paringin, ".tgl_indo($key->tgl_sk),0,1,'C',1); 

            if (($key->nama_eselon == 'II/A') OR ($key->nama_eselon == 'II/B') OR ($nmjab == 'CAMAT') OR ($nmjab == 'DIREKTUR')) {
                $this->setXY(100,$y+115);
                $this->MULTICELL(90,5,'SEKRETARIS DAERAH','','C',1);
                $this->setXY(100,$y+120);
                $this->MULTICELL(90,5,'KABUPATEN BALANGAN, ','','C',1);
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+150); $this->cell(70,5,'Ir. H. RUSKARIADI',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+155); $this->cell(70,5,'Pembina Utama Madya',0,1,'C',1); 
                $this->setXY(110,$y+160); $this->cell(70,5,'NIP. 19601001 198803 1 011',0,1,'C',1);                 
            } else {
                $this->setXY(100,$y+115);
                $this->MULTICELL(90,5,$key->pejabat_sk.',','','C',1);
                $this->setFont('Arial','U',11);
                $this->setXY(110,$y+150); $this->cell(70,5,'H. SUFRIANNOR, S.Sos, M.AP',0,1,'C',1); 
                $this->setFont('Arial','',11);
                $this->setXY(110,$y+155); $this->cell(70,5,'Pembina Tingkat I',0,1,'C',1); 
                $this->setXY(110,$y+160); $this->cell(70,5,'NIP. 19681012 198903 1 009',0,1,'C',1); 
            }
            /*
            $this->setXY(100,$y+115);
            $this->MULTICELL(90,5,$key->pejabat_sk.',','','C',1);
            $this->setFont('Arial','U',11);
            $this->setXY(110,$y+150); $this->cell(70,5,'H. SUFRIANNOR, S.Sos, M.AP',0,1,'C',1); 
            $this->setFont('Arial','',11);
            $this->setXY(110,$y+155); $this->cell(70,5,'Pembina Tingkat I',0,1,'C',1); 
            $this->setXY(110,$y+160); $this->cell(70,5,'NIP. 19681012 198903 1 009',0,1,'C',1); 
            
            $this->setFont('Arial','U',9);
            $this->setXY(20,$y+200); $this->cell(70,5,'Tembusan :',0,1,'L',1); 
            $this->setFont('Arial','',9);
            $this->setXY(25,$y+205); $this->cell(70,5,'1. Kepala '.$munker->munker->getnamaunker($key->fid_unkerpeg).' Kabupaten Balangan;',0,1,'L',1); 
            $this->setXY(25,$y+210); $this->cell(70,5,'2. Arsip.',0,1,'L',1); 
            */

            $this->setFont('Arial','U',9);
            $this->setXY(20,$y+220); $this->cell(70,5,'Tembusan :',0,1,'L',1); 
            $this->setFont('Arial','',9);
            if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'INSPEKTORAT') {
                $jabatan = 'Inspektur;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT DAERAH') {
                $jabatan = 'Sekretaris Daerah Kabupaten Balangan;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT DPRD') {
                $jabatan = 'Sekretaris DPRD;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'SEKRETARIAT KOMISI PEMILIHAN UMUM') {
                $jabatan = 'Sekretaris KPU Kabupaten Balangan;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'RUMAH SAKIT UMUM DAERAH BALANGAN') {
                $jabatan = 'Direktur RSUD Balangan;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN PARINGIN') {
                $jabatan = 'Camat Paringin;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN PARINGIN SELATAN') {
                $jabatan = 'Camat Paringin Selatan;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN BATUMANDI') {
                $jabatan = 'Camat Batumandi;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN LAMPIHONG') {
                $jabatan = 'Camat Lampihong;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN JUAI') {
                $jabatan = 'Camat Juai;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN HALONG') {
                $jabatan = 'Camat Halong;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN AWAYAN') {
                $jabatan = 'Camat Awayan;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KECAMATAN TEBING TINGGI') {
                $jabatan = 'Camat Tebing Tinggi;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN BATU PIRING') {
                $jabatan = 'Lurah Batu Piring;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN PARINGIN KOTA') {
                $jabatan = 'Lurah Paringin Kota;';
            } else if ($munker->munker->getnamaunker($key->fid_unit_kerja) == 'KELURAHAN Paringin Timur') {
                $jabatan = 'Lurah Paringin Timur;';
            } else {
                $jabatan = 'Kepala '.$munker->munker->getnamaunker($key->fid_unit_kerja).' Kabupaten Balangan;';
            }
            

            $this->setXY(25,$y+225); $this->cell(70,5,'1. '.$jabatan,0,1,'L',1); 
            //$this->setXY(25,$y+225); $this->cell(70,5,'1. Kepala '.$munker->munker->getnamaunker($key->fid_unit_kerja).' Kabupaten Balangan;',0,1,'L',1); 
            $this->setXY(25,$y+230); $this->cell(70,5,'2. Kepala Bagian Organisasi Sekretariat Daerah Kabupaten Balangan;',0,1,'L',1); 
            $this->setXY(25,$y+235); $this->cell(70,5,'3. Arsip.',0,1,'L',1);  

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
$pdf->Output('skizincutitunda.pdf', 'I');
