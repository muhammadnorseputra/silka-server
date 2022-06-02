<?php
require('code128.php');

$pdf=new PDF_Code128();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

$anggota =  array();
$anggota[] = array("nama"=> "Unyil", "kode" => "0001");
$anggota[] = array("nama"=> "Usro",  "kode" => "0002");
$anggota[] = array("nama"=> "Ucrit", "kode" => "0003");

$y = 20;
foreach($anggota as $a) {
    $pdf->Code128(20,$y,$a["kode"],80,20);
    $pdf->SetXY(20,$y+25);
    $pdf->Write(0,'Nama: '.$a["nama"]." - Kode: ".$a["kode"]);
    $y+=50;
}
$pdf->Output();
?>