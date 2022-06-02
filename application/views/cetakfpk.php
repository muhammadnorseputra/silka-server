<?php

class PDF extends FPDF
{     
    	//Page header
	function Header()
	{                          
        	//$this->SetFont('Arial', 'B', 40);
        	//$this->SetTextColor(255,192,203);
        	//$this->Text(176, 30, "CONTOH", 45);
		//$this->SetFont('Arial', 'B', 20);
		//$this->Text(176, 36, "FPK Hasil Integrasi", 45);
		//$this->SetFont('Arial', 'B', 12);
		//$this->Text(176, 41, "eKinerja + ePerilaku 360 >>> SILKa", 45);
    	}

	function Content($data)
	{
        $mpeg = new Mpegawai();
        $munker = new Munker();
        $mpeg->load->helper('fungsitanggal');
        $mpeg->load->helper('fungsipegawai');

        foreach ($data as $k) {
            $this->Ln(1);
            $this->setFont('Arial','',9);
            $this->setFillColor(255,255,255);
            $this->setXY(10,10);
            $this->MULTICELL(145,60,"",'1','L',1);
            $this->setXY(12,12);
            $this->MULTICELL(50,5,"8. REKOMENDASI",'','B',1);
            
            // Kotak Tanda Tangan
                $this->setXY(10,70);
                $this->setFont('Arial','',9);      
                //Garis untuk Kotak            
                $this->Line(10,10,10,200);
                $this->Line(10,200,155,200);
                $this->Line(10,200,155,200);
                $this->Line(155,10,155,200);
                
                $this->setXY(82,80); $this->MULTICELL(70,5,"9. Dibuat Tanggal, ".tgl_indo($k['tgl_dibuatpenilai']),'','C',1);
                $this->setXY(82,85); $this->MULTICELL(70,3,"PEJABAT PENILAI,",'','C',1);
                $this->setFont('Arial','U',9);  
                $this->setXY(82,105); $this->MULTICELL(70,5,$k['nama_pp'],'','C',1);
                $this->setFont('Arial','',9);  
                $this->setXY(82,110); $this->MULTICELL(70,3,"NIP. ".$k['nip_pp'],'','C',1);
                $this->setXY(12,120); $this->MULTICELL(70,5,"10. Diterima Tanggal, ".tgl_indo($k['tgl_diterimapns']),'','C',1);
                $this->setXY(12,125); $this->MULTICELL(70,3,"PEGAWAI NEGERI SIPIL YANG DINILAI,",'','C',1);
                $this->setFont('Arial','U',9);  
                $this->setXY(12,145); $this->MULTICELL(70,5,$mpeg->mpegawai->getnama($k['nip']),'','C',1);
                $this->setFont('Arial','',9);  
                $this->setXY(12,150); $this->MULTICELL(70,3,"NIP. ".$k['nip'],'','C',1);
                $this->setXY(82,160); $this->MULTICELL(70,5,"11. Diterima Tanggal, ".tgl_indo($k['tgl_diterimaatasanpenilai']),'','C',1);
                $this->setXY(82,165); $this->MULTICELL(70,3,"ATASAN PEJABAT YANG MENILAI,",'','C',1);
                $this->setFont('Arial','U',9);  
                $this->setXY(82,185); $this->MULTICELL(70,5,$k['nama_app'],'','C',1);
                $this->setFont('Arial','',9);  
		if ($k['nip_app'] != '') {
                	$this->setXY(82,190); $this->MULTICELL(70,3,"NIP. ".$k['nip_app'],'','C',1);
                }
	     // End Kotak Tanda Tangan
           
            $this->setFont('Arial','B',11);
            $this->Image('assets/garuda3d.png', 240, 10,'27','30','png');
            $this->setXY(220,42);
            $this->MULTICELL(70,5,"PENILAIAN PRESTASI KERJA PEGAWAI NEGERI SIPIL",'','C',1);
            $this->setFont('Arial','',7); 
            $this->setXY(175,55);
            $this->MULTICELL(90,5,"PEMERINTAH KABUPATEN BALANGAN",'','L',1);
            $this->setXY(175,60);
            $this->MULTICELL(90,5,$k['unitkerja'],'','L',1);
            $this->setFont('Arial','',8); 
            $this->setXY(270,55);
            $this->MULTICELL(55,5,"JANGKA WAKTU PENILAIAN",'','L',1);
            $this->setXY(270,60);
            $this->MULTICELL(55,5,tgl_indo($k['periodeawal'])." s/d ".tgl_indo($k['periodeakhir']),'','L',1);


            $this->setFont('Arial','',9); 
            $this->setXY(175,65); $this->MULTICELL(5,5,"1.",'LT','L',1);
            $this->setXY(175,70); $this->MULTICELL(5,35,"",'LBR','L',1);
            $this->setXY(180,65);
            $this->MULTICELL(140,5,"YANG DINILAI",'1','L',1);
            $this->setFont('Arial','',8); 
            $this->setXY(180,70); $this->MULTICELL(55,5,"a. Nama",'1','L',1);
            $this->setXY(235,70); $this->MULTICELL(85,5,$mpeg->mpegawai->getnama($k['nip']),'1','L',1);
            $this->setXY(180,75); $this->MULTICELL(55,5,"b. NIP",'1','L',1);
            $this->setXY(235,75); $this->MULTICELL(85,5,$k['nip'],'1','L',1);
            $this->setXY(180,80); $this->MULTICELL(55,5,"c. Pangkat, Golongan Ruang, TMT",'1','L',1);
            $this->setXY(235,80); $this->MULTICELL(85,5,$mpeg->mpegawai->getnamapangkat($k['fid_golru']).' ('.$mpeg->mpegawai->getnamagolru($k['fid_golru']).')','1','L',1);
            $this->setXY(180,85); $this->MULTICELL(55,5,"d. Jabatan",'LTR','L',1);
            $this->Line(235,85,235,105);
            $this->setXY(235,85); $this->MULTICELL(85,5,$k['jabatan'],'LTR','L',1);
            $this->Line(320,85,320,105);            
            $this->setXY(180,95); $this->MULTICELL(55,5,"e. Unit Organisasi",'LTR','L',1);
            $this->setXY(235,95); $this->MULTICELL(85,5,$k['unitkerja'],'LTR','L',1);

            $this->setFont('Arial','',9); 
            $this->setXY(175,105); $this->MULTICELL(5,5,"2.",'LT','L',1);
            $this->setXY(175,110); $this->MULTICELL(5,35,"",'LBR','L',1);
            $this->setXY(180,105);
            $this->MULTICELL(140,5,"PEJABAT PENILAI",'1','L',1);
            $this->setFont('Arial','',8); 
            $this->setXY(180,110); $this->MULTICELL(55,5,"a. Nama",'1','L',1);
            $this->setXY(235,110); $this->MULTICELL(85,5,$k['nama_pp'],'1','L',1);            
	    $this->setXY(180,115); $this->MULTICELL(55,5,"b. NIP",'1','L',1);            
            if ($k['nip_pp'] != '') {
 	    	$this->setXY(235,115); $this->MULTICELL(85,5,$k['nip_pp'],'1','L',1);
	    }
            $this->setXY(180,120); $this->MULTICELL(55,5,"c. Pangkat, Golongan Ruang, TMT",'1','L',1);
            if ($k['nip_pp'] != '') {
	    	$this->setXY(235,120); $this->MULTICELL(85,5,$mpeg->mpegawai->getnamapangkat($k['fid_golru_pp']).' ('.$mpeg->mpegawai->getnamagolru($k['fid_golru_pp']).')','1','L',1);           
            }
	    $this->Line(235,125,235,145);
            $this->setXY(180,125); $this->MULTICELL(55,5,"d. Jabatan",'LTR','L',1);
            $this->setXY(235,125); $this->MULTICELL(85,5,$k['jab_pp'],'LTR','L',1); 
            $this->Line(320,125,320,145);            
            $this->setXY(180,135); $this->MULTICELL(55,5,"e. Unit Organisasi",'LTR','L',1);
            $this->setXY(235,135); $this->MULTICELL(85,5,$k['unor_pp'],'LTR','L',1);
            
            $this->setFont('Arial','',9); 
            $this->setXY(175,145); $this->MULTICELL(5,5,"3.",'LT','L',1);
            $this->setXY(175,150); $this->MULTICELL(5,35,"",'LBR','L',1);
            $this->setXY(180,145);
            $this->MULTICELL(140,5,"ATASAN PEJABAT PENILAI",'1','L',1);
            $this->setFont('Arial','',8); 
            $this->setXY(180,150); $this->MULTICELL(55,5,"a. Nama",'1','L',1);
            $this->setXY(235,150); $this->MULTICELL(85,5,$k['nama_app'],'1','L',1);
	    $this->setXY(180,155); $this->MULTICELL(55,5,"b. NIP",'1','L',1);     
            if ($k['nip_app'] != '') {
	    	$this->setXY(235,155); $this->MULTICELL(85,5,$k['nip_app'],'1','L',1);
	    } else {
		$this->setXY(235,155); $this->MULTICELL(85,5,'','1','L',1);
	    }
            $this->setXY(180,160); $this->MULTICELL(55,5,"c. Pangkat, Golongan Ruang, TMT",'1','L',1);
            if ($k['nip_app'] != '') {
	    	$this->setXY(235,160); $this->MULTICELL(85,5,$mpeg->mpegawai->getnamapangkat($k['fid_golru_app']).' ('.$mpeg->mpegawai->getnamagolru($k['fid_golru_app']).')','1','L',1);           
            } else {
		$this->setXY(235,160); $this->MULTICELL(85,5,'','1','L',1);
	    }
	    $this->Line(235,165,235,185);
            $this->setXY(180,165); $this->MULTICELL(55,5,"d. Jabatan",'LTR','L',1);
            $this->setXY(235,165); $this->MULTICELL(85,5,$k['jab_app'],'LTR','L',1); 
            $this->Line(320,165,320,185);            
            $this->setXY(180,175); $this->MULTICELL(55,5,"e. Unit Organisasi",'LTR','L',1);
            $this->setXY(235,175); $this->MULTICELL(85,5,$k['unor_app'],'LTR','L',1); 
            $this->Line(180,185,320,185); // Garis tutup bagian bawah       

            $this->setFont('Arial','',6);
            $namauser = $mpeg->mpegawai->getnama($mpeg->session->userdata('nip'));
            $this->setXY(200,188); $this->MULTICELL(120,3,"Dicetak oleh ".$namauser." (NIP. ".$mpeg->session->userdata('nip')."), tanggal ".tglwaktu_indo($k['tgl_cetak']),0,'R',1); 
            $this->setFont('Arial','',8); 
            // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
            $this->Image('assets/qrcodeskp/'.$k['qrcode'].'.png', 180, 187,'15','15','png');


            $this->AddPage();
            $this->setFont('Arial','',9);
            $this->setFillColor(255,255,255);
            $this->setXY(10,10); $this->MULTICELL(5,110,"",'1','L',1);
            $this->setXY(10,12); $this->MULTICELL(5,5,"4.",'LR','L',1);
            $this->setXY(15,10); $this->MULTICELL(115,10,"UNSUR YANG DINILAI",'1','L',1);
            $this->setXY(130,10); $this->MULTICELL(25,10,"JUMLAH",'1','C',1);
            $this->setXY(15,20); $this->MULTICELL(90,10,"a. Sasaran Kerja Pegawai (SKP)",'LTB','B',1);
            $this->setXY(90,20); $this->MULTICELL(40,10,round($k['nilai_skp'],2)." X 60%",'TRB','C',1);
            $this->setXY(130,20); $this->MULTICELL(25,10,round($k['nilai_skp']*0.6,2),'1','C',1);
            $this->setXY(15,30); $this->MULTICELL(25,90,"b. Prilaku Kerja",'1','B',1);
            $this->setXY(40,30); $this->MULTICELL(40,10,"1. Orientasi Pelayanan",'1','B',1);           
            $this->setXY(80,30); $this->MULTICELL(20,10,round($k['orientasi_pelayanan'],2),'1','C',1);            
            $this->setXY(100,30); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['orientasi_pelayanan'],2)),'1','C',1);
            $this->setXY(40,40); $this->MULTICELL(40,10,"2. Integritas",'1','B',1);
            $this->setXY(80,40); $this->MULTICELL(20,10,round($k['integritas'],2),'1','C',1);            
            $this->setXY(100,40); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['integritas'],2)),'1','C',1);
            $this->setXY(40,50); $this->MULTICELL(40,10,"3. Komitmen",'1','B',1);
            $this->setXY(80,50); $this->MULTICELL(20,10,round($k['komitmen'],2),'1','C',1);            
            $this->setXY(100,50); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['komitmen'],2)),'1','C',1);
            $this->setXY(40,60); $this->MULTICELL(40,10,"4. Disiplin",'1','B',1);
            $this->setXY(80,60); $this->MULTICELL(20,10,round($k['disiplin'],2),'1','C',1);            
            $this->setXY(100,60); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['disiplin'],2)),'1','C',1);
            $this->setXY(40,70); $this->MULTICELL(40,10,"5. Kerjasama",'1','B',1);
            $this->setXY(80,70); $this->MULTICELL(20,10,round($k['kerjasama'],2),'1','C',1);            
            $this->setXY(100,70); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['kerjasama'],2)),'1','C',1);
            $this->setXY(40,80); $this->MULTICELL(40,10,"6. Kepemimpinan",'1','B',1);
            if ($k['jns_skp'] == 'STRUKTURAL') {
                $this->setXY(80,80); $this->MULTICELL(20,10,round($k['kepemimpinan'],2),'1','C',1);            
                $this->setXY(100,80); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['kepemimpinan'],2)),'1','C',1);            
            } else {
                $this->setXY(80,80); $this->MULTICELL(20,10,"-",'1','C',1);            
                $this->setXY(100,80); $this->MULTICELL(30,10,"-",'1','C',1);            }
            
            $jml = round($k['orientasi_pelayanan'],2) + round($k['integritas'],2) + round($k['komitmen'],2) + round($k['disiplin'],2) + round($k['kerjasama'],2) + round($k['kepemimpinan'],2);
            
            $this->setXY(40,90); $this->MULTICELL(40,10,"Jumlah",'1','B',1);
            $this->setXY(80,90); $this->MULTICELL(20,10,round($jml,2),'LTB','C',1);
            $this->setXY(100,90); $this->MULTICELL(30,10,"",'TBR','C',1);
            $this->setXY(40,100); $this->MULTICELL(40,10,"Nilai Rata-rata",'1','B',1);
            $this->setXY(80,100); $this->MULTICELL(20,10,round($k['nilai_prilaku_kerja'],2),'1','C',1);      
            $this->setXY(100,100); $this->MULTICELL(30,10,$mpeg->mpegawai->getnilaiskp(round($k['nilai_prilaku_kerja'],2)),'1','C',1);
            $this->setXY(40,110); $this->MULTICELL(90,10,"Nilai Prilaku Kerja",'1','L',1);
            $this->setXY(90,110); $this->MULTICELL(40,10,round($k['nilai_prilaku_kerja'],2)." X 40%",'TRB','C',1);
            $this->setXY(130,110); $this->MULTICELL(25,10,round($k['nilai_prilaku_kerja']*0.4,2),'1','C',1);
            $this->setFont('Arial','B',11);
            $this->setXY(10,120); $this->MULTICELL(120,14,"NILAI PRESTASI KERJA",'1','C',1);
            $this->setXY(130,120); $this->MULTICELL(25,8,round($k['nilai_prestasi_kerja'],2),'LTR','C',1);

            $this->setXY(130,30); $this->MULTICELL(25,80,"",'1','C',1);
            $this->setFont('Arial','',8);
            $this->setXY(130,128); $this->MULTICELL(25,6,"(".$mpeg->mpegawai->getnilaiskp(round($k['nilai_prestasi_kerja'],2)).")",'LBR','C',1);

            $this->Line(10,110,10,205);                        
            $this->Line(10,205,155,205);                        
            $this->Line(155,120,155,205);
            $this->setFont('Arial','',9);            
            $this->setXY(12,137); $this->MULTICELL(120,5,"5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI (APABILA ADA)",'','L',1);
            $this->setFont('Arial','',8);            
            $this->setXY(105,185); $this->MULTICELL(45,5,"Tanggal, ................................",'','L',1);
            
            // Kotak No 6 dan 7
            $this->Line(175,10,320,10);
            $this->Line(175,10,175,185);
            $this->Line(175,185,320,185);
            $this->Line(320,10,320,185);
            $this->Line(175,110,320,110);
            $this->setFont('Arial','',9);            
            $this->setXY(177,12); $this->MULTICELL(120,5,"6. TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN",'','L',1);
            $this->setFont('Arial','',8);
            $this->setXY(270,90); $this->MULTICELL(45,5,"Tanggal, ................................",'','L',1);
            $this->setFont('Arial','',9);
            $this->setXY(177,112); $this->MULTICELL(120,5,"7. KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN",'','L',1);
            $this->setFont('Arial','',8);
            $this->setXY(270,165); $this->MULTICELL(45,5,"Tanggal, ................................",'','L',1);
            
	    $this->setFont('Arial','',6);
   	    $this->setXY(180,188); $this->CELL(140,5,"Dicetak oleh ".$namauser." (NIP. ".$mpeg->session->userdata('nip').", tanggal ".tglwaktu_indo($k['tgl_cetak']),0,1,'R',1);
            // Tampilkan QR Code dalam bentuk file png, ukuran 35 x 35
            $this->Image('assets/qrcodeskp/'.$k['qrcode'].'.png', 180, 187,'15','15','png');

            break;
        }
	}

	function Footer()
	{	
	}
}
 
$pdf = new PDF('L', 'mm', array('215','330'));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output('pppk.pdf', 'I');
