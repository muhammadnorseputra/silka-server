<?php

class PDF extends FPDF
{     
    //Page header
	function Header()
	{                      
                $login = new mLogin();
                $peg = new mPegawai();

                $this->setFont('Arial','',9);
                $this->setFillColor(255,255,255);
                $this->cell(100,5,"Profil ASN",0,0,'L',1); 
                $this->setFont('Arial','I',7);
                $this->cell(90,5,'Dicetak oleh '.$peg->mpegawai->getnama($login->session->userdata('nip')).' (NIP. '.$login->session->userdata('nip').') pada ' .tgl_indo(date('Y-m-d')),0,1,'R',1);                
                $this->SetY(15);
                $this->Line(10,$this->GetY(),200,$this->GetY());
                

                $this->Ln(8);
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(20,3,'',0,0,'C',0); 
                $this->Image('assets/logo.jpg', 20, 22,'8','10','jpeg');
                $this->cell(100,4,'Badan Kepegawaian, Pendidikan dan Pelatihan Daerah',0,1,'L',1); 
                $this->cell(20,3,'',0,0,'C',0); 
                $this->cell(100,6,"Profil PNS",0,1,'L',1); 
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
        $x= 20;
        $y= 35;

        $mpeg->load->helper('fungsitanggal');
        $mpeg->load->helper('fungsipegawai');

        foreach ($data as $key) {
		$lokasi_file = './photo/';
		$filename = $key->nip.".jpg";
		
		if (file_exists($lokasi_file.$filename)) {
			$photo = "./photo/$filename";
            $this->Image($photo, 167, 41, '22', '27', 'jpg');
		} else {
			$photo = "./photo/nophoto.jpg";
            $this->Image($photo, 167, 41, '22', '22', 'jpg');
		}
            //$this->Image('photo/'.$key->nip.'.jpg', 167, 41,'22','27','jpg');
		//$this->Image($photo, 167, 41, '22', '27', 'jpg');

            $this->setFillColor(222,222,222);
            $this->setFont('arial','B',8);
            $this->setXY($x,$y);
            $this->MULTICELL(170,5,'IDENTITAS PRIBADI','LTR','C',1);
            $this->setFont('arial','',8);
            $this->setFillColor(255,255,255);
            $this->setXY($x,$y+5);
            $this->MULTICELL(35,5,'NIP Lama / Baru:','L','R',1);
            $this->setXY($x+35,$y+5);
            $this->MULTICELL(100,5,$key->nip,'','L',1);
            $this->setXY($x,$y+10);
            $this->MULTICELL(35,5,'Nama :','L','R',1);
            $this->setXY($x+35,$y+10);
            //$this->MULTICELL(100,5,$key->nama,'TBR','L',1);
            //$this->MULTICELL(100,5,$this->mpegawai->getnama($key->nip),'TBR','L',1);
            $this->MULTICELL(100,5,namagelar($key->gelar_depan,$key->nama,$key->gelar_belakang),'','L',1);
            $this->setXY($x,$y+15);
            $this->MULTICELL(35,5,'Tempat/Tanggal Lahir :','L','R',1);
            $this->setXY($x+35,$y+15);
            $this->MULTICELL(100,5,$key->tmp_lahir.' / '.tgl_indo($key->tgl_lahir),'','L',1);
            
            $this->setXY($x,$y+20);
            $this->MULTICELL(35,5,'Agama :','L','R',1);
            $this->setXY($x+35,$y+20);
            $this->MULTICELL(100,5,$mpeg->mpegawai->getagama($key->fid_agama),'','L',1);

            //$this->setXY($x,$y+25);
            //$this->MULTICELL(35,5,'Status Kawin :','LR','R',1);
            //$this->setXY($x+35,$y+25);
            //$this->MULTICELL(100,5,$mpeg->mpegawai->getstatkawin($key->fid_status_kawin),'','L',1);

            $this->setXY($x,$y+25);
            $this->MULTICELL(35,5,'Jenis Kelamin :','L','R',1);
            $this->setXY($x+35,$y+25);
            $this->MULTICELL(35,5,$mpeg->mpegawai->getjnskel($key->nip),'','L',1);

            $this->setXY($x,$y+30);
            $this->MULTICELL(35,5,'Status Kawin :','','R',1);
            $this->setXY($x+35,$y+30);
            $this->MULTICELL(30,5,$mpeg->mpegawai->getstatkawin($key->fid_status_kawin),'','L',1);

            $this->setXY($x,$y+35);
            $this->MULTICELL(35,5,'Alamat :','L','R',1);
            $this->setXY($x+35,$y+35);
            $this->MULTICELL(100,5,$key->alamat.' '.$mpeg->mpegawai->getkelurahan($key->fid_alamat_kelurahan).' Telp. '. $key->telepon,'','L',1);
            
            $this->setXY($x,$y+40);
            $this->MULTICELL(35,5,'Status Kepegawaian :','L','R',1);
            $this->setXY($x+35,$y+40);
            $this->MULTICELL(80,5,$mpeg->mpegawai->getstatpeg($key->nip),'','L',1);

            $this->setXY($x+85,$y+40);
            $this->MULTICELL(35,5,'Jenis Kepegawaian :','','R',1);
            $this->setXY($x+120,$y+40);
            $this->MULTICELL(135,5,$mpeg->mpegawai->getjnspeg($key->nip),'','L',1);

            $this->setXY($x,$y+45);
            $this->MULTICELL(35,5,'No. Karpeg :','L','R',1);
            $this->setXY($x+35,$y+45);
            $this->MULTICELL(80,5,$mpeg->mpegawai->getnokarpeg($key->nip),'','L',1);

            $this->setXY($x+90,$y+45);
            $this->MULTICELL(30,5,'No. Karis Karsu :','','R',1);
            $this->setXY($x+120,$y+45);
            $this->MULTICELL(60,5,$mpeg->mpegawai->getnokarisu($key->nip),'','L',1);

            $this->setXY($x,$y+50);
            $this->MULTICELL(35,5,'KTP :','L','R',1);
            $this->setXY($x+35,$y+50);
            $this->MULTICELL(135,5,$key->no_ktp,'','L',1);

            $this->setXY($x+90,$y+50);
            $this->MULTICELL(30,5,'NPWP :','','R',1);
            $this->setXY($x+120,$y+50);
            $this->MULTICELL(60,5,$key->no_npwp,'','L',1);

            $this->setXY($x,$y+55);
            $this->MULTICELL(35,5,'No. Taspen :','L','R',1);            
            $this->setXY($x+35,$y+55);
            $this->MULTICELL(55,5,$key->no_taspen,'','L',1);

            $this->setXY($x+90,$y+55);
            $this->MULTICELL(30,5,'No. Askes :','','R',1);            
            $this->setXY($x+120,$y+55);
            $this->MULTICELL(50,5,$key->no_askes,'','L',1);

            // Tabel Masa Kerja
           
            $this->setXY($x,$y+60);
            $this->MULTICELL(10,5,'','L','R',1); // garis kiri kanan

            $this->setFont('arial','',8);
            $this->setFillColor(255,255,255);

            $this->setXY($x,$y+65);
            $this->MULTICELL(45,5,'Masa Kerja CPNS :','L','R',1);
            $this->setXY($x+45,$y+65);
            $this->MULTICELL(40,5,hitungmkcpns($key->nip),'','L',1);

            $this->setXY($x+90,$y+65);
            $this->MULTICELL(30,5,'TMT Pensiun BUP :','','R',1);
            $this->setXY($x+120,$y+65);
            $this->MULTICELL(50,5,$mpeg->mpegawai->gettmtbup($key->fid_jabatan, $key->tgl_lahir, $key->fid_jnsjab),'R','L',1);

            $this->setXY($x,$y+70);
            $this->MULTICELL(45,5,'Masa Kerja Pangkat Terakhir :','L','R',1);
            $this->setXY($x+45,$y+70);
            $this->MULTICELL(40,5,hitungmkgolru($key->nip),'','L',1);

            $this->setXY($x+90,$y+70);
            $this->MULTICELL(30,5,'Usia :','','R',1);
            $this->setXY($x+120,$y+70);
            $this->MULTICELL(50,5,hitungusia($key->nip),'R','L',1);

            $this->setXY($x,$y+75);
            $this->MULTICELL(45,5,'Masa Kerja Jabatan Terakhir :','BL','R',1);
            $this->setXY($x+45,$y+75);
            $this->MULTICELL(40,5,hitungmkjab($key->nip),'B','L',1);

            $this->setXY($x+80,$y+75); // daerah kosong dibawah usia
            $this->MULTICELL(90,5,'','BR','',1);


            // Tabel Pengangkatan CPNS
            $this->setFillColor(222,222,222);
            $this->setFont('arial','B',8);
            $this->setXY($x,$y+85);
            $this->MULTICELL(170,5,'CPNS','LTR','C',1);

            $this->setFont('arial','',8);
            $this->setFillColor(255,255,255);
            $this->setXY($x,$y+90);
            $this->MULTICELL(35,5,'Jabatan :','L','R',1);
            $this->setXY($x+35,$y+90);
            $this->MULTICELL(135,5,$key->jabatan_cpns,'R','L',1);

            $this->setXY($x,$y+95);
            $this->MULTICELL(35,5,'Golongan Ruang :','L','R',1);
            $this->setXY($x+35,$y+95);
            $this->MULTICELL(100,5,$mpeg->mpegawai->getnamapangkat($key->fid_golru_cpns).' ('.$mpeg->mpegawai->getnamagolru($key->fid_golru_cpns).')','','L',1);

            $this->setXY($x+70,$y+95);
            $this->MULTICELL(30,5,'TMT :','','R',1);
            $this->setXY($x+100,$y+95);
            $this->MULTICELL(70,5,tgl_indo($key->tmt_cpns),'R','L',1);

            $this->setXY($x,$y+100);
            $this->MULTICELL(35,5,'No. SK :','L','R',1);
            $this->setXY($x+35,$y+100);
            $this->MULTICELL(100,5,$key->no_sk_cpns,'','L',1);

            $this->setXY($x+70,$y+100);
            $this->MULTICELL(30,5,'Tgl. SK :','','R',1);
            $this->setXY($x+100 ,$y+100);
            $this->MULTICELL(70,5,tgl_indo($key->tgl_sk_cpns),'R','L',1);

            $this->setXY($x,$y+105);
            $this->MULTICELL(35,5,'Pejabat SK :','BL','R',1);
            $this->setXY($x+35,$y+105);
            $this->MULTICELL(135,5,$key->pejabat_sk_cpns,'BR','L',1);

            // Tabel Pengangkatan PNS
            $this->setFillColor(222,222,222);
            $this->setFont('arial','B',8);
            $this->setXY($x,$y+115);
            $this->MULTICELL(170,5,'PNS','LTR','C',1);
            
            if ($mpeg->mpegawai->getstatpeg($key->nip) == 'PNS') {
                $this->setFont('arial','',8);
                $this->setFillColor(255,255,255);
                $this->setXY($x,$y+120);
                $this->MULTICELL(35,5,'Jabatan :','L','R',1);
                $this->setXY($x+35,$y+120);
                $this->MULTICELL(135,5,$key->jabatan_pns,'R','L',1);

                $this->setXY($x,$y+125);
                $this->MULTICELL(35,5,'Golongan Ruang :','L','R',1);
                $this->setXY($x+35,$y+125);
                $this->MULTICELL(100,5,$mpeg->mpegawai->getnamapangkat($key->fid_golru_pns).' ('.$mpeg->mpegawai->getnamagolru($key->fid_golru_pns).')','','L',1);

                $this->setXY($x+70,$y+125);
                $this->MULTICELL(30,5,'TMT :','','R',1);
                $this->setXY($x+100,$y+125);
                $this->MULTICELL(70,5,tgl_indo($key->tmt_pns),'R','L',1);

                $this->setXY($x,$y+130);
                $this->MULTICELL(35,5,'No. SK :','L','R',1);
                $this->setXY($x+35,$y+130);
                $this->MULTICELL(100,5,$key->no_sk_pns,'','L',1);

                $this->setXY($x+70,$y+130);
                $this->MULTICELL(30,5,'Tgl. SK :','','R',1);
                $this->setXY($x+100,$y+130);
                $this->MULTICELL(70,5,tgl_indo($key->tgl_sk_pns),'R','L',1);

                $this->setXY($x,$y+135);
                $this->MULTICELL(35,5,'Pejabat SK :','BL','R',1);
                $this->setXY($x+35,$y+135);
                $this->MULTICELL(135,5,$key->pejabat_sk_pns,'BR','L',1);
            } else {
                $this->setFont('arial','',8);
                $this->setFillColor(255,255,255);
                $this->setXY($x,$y+120);
                $this->MULTICELL(35,5,'Jabatan :','L','R',1);
                $this->setXY($x+35,$y+120);
                $this->MULTICELL(135,5,'','R','L',1);

                $this->setXY($x,$y+125);
                $this->MULTICELL(35,5,'Golongan Ruang :','L','R',1);
                $this->setXY($x+35,$y+125);
                $this->MULTICELL(100,5,'','',1);

                $this->setXY($x+70,$y+125);
                $this->MULTICELL(30,5,'TMT :','','R',1);
                $this->setXY($x+100,$y+125);
                $this->MULTICELL(70,5,'','R','L',1);

                $this->setXY($x,$y+130);
                $this->MULTICELL(35,5,'No. SK :','L','R',1);
                $this->setXY($x+35,$y+130);
                $this->MULTICELL(100,5,'','','L',1);

                $this->setXY($x+70,$y+130);
                $this->MULTICELL(30,5,'Tgl. SK :','','R',1);
                $this->setXY($x+100,$y+130);
                $this->MULTICELL(70,5,'','R','L',1);

                $this->setXY($x,$y+135);
                $this->MULTICELL(35,5,'Pejabat SK :','BL','R',1);
                $this->setXY($x+35,$y+135);
                $this->MULTICELL(135,5,'','BR','L',1);
            }

            // Tabel Golongan Ruang terakhir
            $this->setFillColor(222,222,222);
            $this->setFont('arial','B',8);
            $this->setXY($x,$y+145);
            $this->MULTICELL(170,5,'GOLONGAN RUANG TERAKHIR','LTR','C',1);

            if ($mpeg->mpegawai->cekpernahkp($key->nip)) {
                $this->setFont('arial','',8);
                $this->setFillColor(255,255,255);
                $this->setXY($x,$y+150);
                $this->MULTICELL(35,5,'Golongan Ruang :','L','R',1);
                $this->setXY($x+35,$y+150);
                $this->MULTICELL(45,5,$mpeg->mpegawai->getnamapangkat($key->fid_golru).' ('.$mpeg->mpegawai->getnamagolru($key->fid_golru).')','','L',1);

                $this->setXY($x+85,$y+150);
                $this->MULTICELL(10,5,'TMT :','','L',1);
                $this->setXY($x+95,$y+150);
                $this->MULTICELL(30,5,tgl_indo($key->tmt),'','L',1);

                $this->setXY($x+120,$y+150);
                $this->MULTICELL(20,5,'Masa Kerja :','','R',1);
                $this->setXY($x+140,$y+150);
                $this->MULTICELL(30,5,$key->mkgol_thn.' Tahun, '.$key->mkgol_bln.' Bulan','R','L',1);

                $this->setXY($x,$y+155);
                $this->MULTICELL(35,5,'Dalam Jabatan :','L','R',1);
                $this->setXY($x+35,$y+155);
                $this->MULTICELL(135,5,$key->dlm_jabatan,'R','L',1);

                $this->setXY($x,$y+160);
                $this->MULTICELL(35,5,'No. SK :','L','R',1);
                $this->setXY($x+35,$y+160);
                $this->MULTICELL(50,5,$key->no_sk_golru,'','L',1);

                $this->setXY($x+85,$y+160);
                $this->MULTICELL(15,5,'Tgl. SK :','','L',1);
                $this->setXY($x+100,$y+160);
                $this->MULTICELL(70,5,tgl_indo($key->tgl_sk_golru),'R','L',1);

                $this->setXY($x,$y+165);
                $this->MULTICELL(35,5,'Pejabat SK :','BL','R',1);
                $this->setXY($x+35,$y+165);
                $this->MULTICELL(135,5,$key->pejabat_sk_golru,'BR','L',1);            
            } else {
                $this->setFont('arial','',8);
                $this->setFillColor(255,255,255);
                $this->setXY($x,$y+150);
                $this->MULTICELL(170,20,'Sama dengan CPNS / PNS','BRL','C',1);
            }            

            // Tabel Pendidikan Terakhir
            $this->setFillColor(222,222,222);
            $this->setFont('arial','B',8);
            $this->setXY($x,$y+175);
            $this->MULTICELL(170,5,'PENDIDIKAN TERAKHIR','LTR','C',1);

            $this->setFont('arial','',8);
            $this->setFillColor(255,255,255);
            $this->setXY($x,$y+180);
            $this->MULTICELL(35,5,'Tingkat - Jurusan :','L','R',1);
            $this->setXY($x+35,$y+180);
            $this->MULTICELL(100,5,$mpeg->mpegawai->gettingpen($key->fid_tingkat).' - '.$mpeg->mpegawai->getjurpen($key->fid_jurusan),'','L',1);

            $this->setXY($x+135,$y+180);
            $this->MULTICELL(20,5,'Tahun Lulus :','','R',1);
            $this->setXY($x+155,$y+180);
            $this->MULTICELL(15,5,$key->thn_lulus,'R','L',1);

            $this->setXY($x,$y+185);
            $this->MULTICELL(35,5,'Nama Sekolah :','L','R',1);
            $this->setXY($x+35,$y+185);
            $this->MULTICELL(135,5,$key->nama_sekolah,'R','L',1);

            $this->setXY($x,$y+190);
            $this->MULTICELL(35,5,'No. Ijazah :','L','R',1);
            $this->setXY($x+35,$y+190);
            $this->MULTICELL(70,5,$key->no_sttb,'','L',1);

            $this->setXY($x+105,$y+190);
            $this->MULTICELL(30,5,'Tgl. Ijazah :','','R',1);
            $this->setXY($x+135,$y+190);
            $this->MULTICELL(35,5,tgl_indo($key->tgl_sttb),'R','L',1);

            $this->setXY($x,$y+195);
            $this->MULTICELL(35,5,'Kepala Sekolah/Rektor :','BL','R',1);
            $this->setXY($x+35,$y+195);
            $this->MULTICELL(135,5,$key->nama_kepsek,'BR','L',1);

            // Tabel Jabatan Terakhir
            $this->setFillColor(222,222,222);
            $this->setFont('arial','B',8);
            $this->setXY($x,$y+205);
            $this->MULTICELL(170,5,'JABATAN TERAKHIR','LTR','C',1);

            $this->setFont('arial','',8);
            $this->setFillColor(255,255,255);
            $this->setXY($x,$y+210);
            $this->MULTICELL(35,5,'Jabatan :','L','R',1);
            $this->setXY($x+35,$y+210);
            $this->MULTICELL(135,5,$key->jabatan,'R','L',1);

            $this->setXY($x,$y+215);
            $this->MULTICELL(35,5,'Unit Kerja :','L','R',1);
            $this->setXY($x+35,$y+215);
            $this->MULTICELL(135,5,$key->unit_kerja,'R','L',1);

            $this->setXY($x,$y+220);
            $this->MULTICELL(35,5,'TMT. :','L','R',1);
            $this->setXY($x+35,$y+220);
            $this->MULTICELL(135,5,tgl_indo($key->tmt_jabatan),'R','L',1);

            $this->setXY($x+70,$y+220);
            $this->MULTICELL(30,5,'Tgl. Pelantikan :','','R',1);
            $this->setXY($x+100,$y+220);
	    if (($key->tgl_pelantikan == '0000-00-00') OR ($key->tgl_pelantikan == '') OR ($key->tgl_pelantikan == 'NULL')) {
            	$this->MULTICELL(70,5,'','R','L',1);
	    } else {
            	$this->MULTICELL(70,5,tgl_indo($key->tgl_pelantikan),'R','L',1);
	    }
	
            $this->setXY($x,$y+225);
            $this->MULTICELL(35,5,'No. SK :','L','R',1);
            $this->setXY($x+35,$y+225);
            $this->MULTICELL(100,5,$key->no_sk_jab,'','L',1);

            $this->setXY($x+70,$y+225);
            $this->MULTICELL(30,5,'Tgl. SK :','','R',1);
            $this->setXY($x+100,$y+225);
	    $this->MULTICELL(70,5,tgl_indo($key->tgl_sk_jab),'R','L',1);

            $this->setXY($x,$y+230);
            $this->MULTICELL(35,5,'Pejabat SK :','BL','R',1);
            $this->setXY($x+35,$y+230);
            $this->MULTICELL(135,5,$key->pejabat_sk_jab,'BR','L',1);
            
        } 
        // garis vertikal kiri identitas pegawai
        $this->Line(20,35,20,90);

        // garis vertikal kanan identitas pegawai
        $this->Line(190,40,190,100);
	}

	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',7);
        $this->Cell(0,10,'SILKa Online ::: copyright BKD Kabupaten Balangan ' . date('Y'),0,0,'L');
		//nomor halaman
		$this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
 
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
//$pdf->Output();
$pdf->Output('profilpns.pdf','I');
