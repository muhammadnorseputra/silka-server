<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends CI_Controller {

  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {
    parent::__construct();
    $this->load->model('mabsensi');

    $this->load->helper('form');
    $this->load->helper('fungsitanggal');
    $this->load->helper('fungsipegawai');
    $this->load->helper('absensi');
    $this->load->model('mpegawai');
    $this->load->model('mpppk');
    $this->load->model('madmin');
    $this->load->model('mkinerja');    
    $this->load->model('mkinerja_pppk');
    $this->load->model('munker');
    $this->load->model('mabsensi');

    // untuk fpdf
    //$this->load->library('fpdf');

    // untuk login session
    if (!$this->session->userdata('nama'))
    {
      redirect('login');
    }
  }
  
  public function index()
  {
    $data['dataabsen'] = $this->mabsensi->tampilabsensi();
    $this->load->view('template', $data);	  
  }

  // METODE BARU
  function tampilabsensi() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['unker'] = $this->munker->dd_unker()->result_array();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'absensi/tampilabsensi';
      $this->load->view('template', $data);
    }
  }

  // START IMPORT EXPORT DARI CSV
  function tampilexport() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['dataabsen'] = $this->mabsensi->tampilabsensi();
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'absensi/exportdata';
      $this->load->view('template', $data);
    }
  }

  // START UNTUK EXPORT DATA KE EXCEL
  public function exportexcel() {
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Wendy Ardhira')
                 ->setLastModifiedBy('Wendy Ardhira')
                 ->setTitle("Data Absensi")
                 ->setSubject("PNS")
                 ->setDescription("Laporan Data Absensi PNS Kab. Balangan")
                 ->setKeywords("Data Absensi PNS");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    // Buat header tabel nya pada baris ke 3
    /*$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
    $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIS"); // Set kolom B3 dengan tulisan "NIS"
    $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
    $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    $excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"
    */

    $excel->setActiveSheetIndex(0)->setCellValue('A1', "NO"); // Set kolom A1 dengan tulisan "NO"
    $excel->setActiveSheetIndex(0)->setCellValue('B1', "NIP"); // Set kolom B1 dengan tulisan "NIS"
    $excel->setActiveSheetIndex(0)->setCellValue('C1', "BULAN"); // Set kolom C1 dengan tulisan "NAMA"
    $excel->setActiveSheetIndex(0)->setCellValue('D1', "TAHUN"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
    $excel->setActiveSheetIndex(0)->setCellValue('E1', "JUMLAH HARI"); // Set kolom E1 dengan tulisan "ALAMAT"
    $excel->setActiveSheetIndex(0)->setCellValue('F1', "HADIR");
    $excel->setActiveSheetIndex(0)->setCellValue('G1', "IZIN");
    $excel->setActiveSheetIndex(0)->setCellValue('H1', "SAKIT");
    $excel->setActiveSheetIndex(0)->setCellValue('I1', "TERLAMBAT");
    $excel->setActiveSheetIndex(0)->setCellValue('J1', "PULANG CEPAT");
    $excel->setActiveSheetIndex(0)->setCellValue('K1', "TANPA KETERANGAN");
    $excel->setActiveSheetIndex(0)->setCellValue('L1', "CUTI");
    $excel->setActiveSheetIndex(0)->setCellValue('M1', "TUGAS DINAS");
    $excel->setActiveSheetIndex(0)->setCellValue('N1', "TUGAS BELAJAR");

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);    
    $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);    
    $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
    
    // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
    $dataabsen = $this->mabsensi->tampilabsensi();
    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach($dataabsen as $data) { // Lakukan looping pada variabel siswa
      /*
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nis);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->jenis_kelamin);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat); 
      */
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nip);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->bulan);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->tahun);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->jml_hari);
      $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->hadir);
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->izin);
      $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->sakit);
      $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->terlambat);
      $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data->pulang_cepat);
      $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data->tk);
      $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data->cuti);
      $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data->tudin);
      $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data->tubel);
      
      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
      
      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping
    }
    // Set width kolom
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('L')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('M')->setWidth(30); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('N')->setWidth(30); // Set width kolom E

    
    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Laporan Data Absensi");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Data Absensi.xls"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }
  // END UNTUK EXPORT DATA KE EXCEL

  // START UNTUK IMPORT DATA KE EXCEL
  function tampilimport() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $hariini = date('d');
      if ((($hariini >= 1) AND ($hariini <= 5)) OR ($this->session->userdata('nip') == "198104072009041002") OR ($this->session->userdata('nama') == "putra")) {
        $data['dataabsen'] = $this->mabsensi->tampilabsensi();
        $data['pesan'] = '';
        $data['jnspesan'] = '';
        $data['status'] = 1;
      } else {
        $data['pesan'] = "<b>INFORMASI ::: </b>Import data absensi hanya dapat dilakukan pada tanggal 1 s/d 5 setiap bulan";
        $data['jnspesan'] = 'alert alert-info';
        $data['status'] = 0;
        //$data['content'] = 'content';
        //$this->load->view('template', $data);
      }      
    }
    $data['content'] = 'absensi/importdata';
    $this->load->view('template', $data);
  }

  private $filename = "import_data";

  public function form(){
    $data = array(); // Buat variabel $data sebagai array
    
    if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
      // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
      $upload = $this->mabsensi->upload_file($this->filename);
      
      if($upload['result'] == "success"){ // Jika proses upload sukses
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
        // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
        $data['sheet'] = $sheet; 
      }else{ // Jika proses upload gagal
        $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
      }
    }

    //$data['dataabsen'] = $this->mabsensi->tampilabsensi();
    $data['pesan'] = '';
    $data['jnspesan'] = '';    
    $data['status'] = 0;
    $data['content'] = 'absensi/importdata';
    $this->load->view('template', $data);
  }
  
  public function import(){
    $jns = $this->input->post('jns');

    if ($jns == 'pns') {
      $id = 'nip';
    } else if ($jns == 'pppk') {
      $id = 'nipppk';
    }

    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
    $excelreader = new PHPExcel_Reader_Excel2007();
    $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
    
    // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
    $data = array();
    
    $numrow = 1;
    $bulanini = date('m');

    foreach($sheet as $row){
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){
        if ($row['A'] != "" or $row['B'] != "" or $row['C'] != "" or $row['D'] != "" or $row['E'] != "" or $row['B'] == $bulanini-1) {
     	  if ($jns == 'pns') {
            $cekadadata = $this->mabsensi->cekadadata($row['A'], $row['B'], $row['C']);
          } else if ($jns == 'pppk') {
            $cekadadata = $this->mabsensi->cekadadata_pppk($row['A'], $row['B'], $row['C']);
          }

          if ($cekadadata == true) {
            // hapus data lama 
            $where = array($id => $row['A'],
                     'bulan' => $row['B'],
                     'tahun' => $row['C']
            );
	    if ($jns == 'pns') {
              $this->mabsensi->hapus_absensi($where);
            } else if ($jns == 'pppk') {
              $this->mabsensi->hapus_absensi_pppk($where);
            }
          }

	  // Hitung pengurang
          // Untuk kasus jumlah hari kerja kurang dari 20 hari, dan
          // jika jumlah hari kerja == jumlah TK, maka total pengurang 100
          //if ($row['D'] == $row['J']) {
          //  $totpengurang = 100;
          //} else {
          //  $totpengurang = (2*$row['H']) + (2*$row['I']) + (5*$row['J']);
          //}

	  $totpengurang = $row['F'];
          if ($totpengurang > 100) {
            $realisasi = 0; 
          } else {
            $realisasi = 100-$totpengurang;
          }

          $user = $this->session->userdata('nip');
          $tgl_aksi = $this->mlogin->datetime_saatini();

          // Kita push (add) array data ke variabel data
          array_push($data, array(
            $id=>$row['A'], // Insert data nis dari kolom A di excel
            'bulan'=>$row['B'], // Insert data nama dari kolom B di excel
            'tahun'=>$row['C'], // Insert data jenis kelamin dari kolom C di excel
            'jml_hari'=>$row['D'], // Insert data alamat dari kolom D di excel
            'hadir'=>$row['E'],
            //'izin'=>$row['F'],
            //'sakit'=>$row['G'],
            //'terlambat'=>$row['H'],
            //'pulang_cepat'=>$row['I'],
            //'tk'=>$row['J'],
            //'cuti'=>$row['K'],
            //'tudin'=>$row['L'],
            //'tubel'=>$row['M'],
            'total_pengurang'=>$totpengurang,
            'realisasi'=>$realisasi,
            'entry_by'=>$user,
            'entry_at'=>$tgl_aksi,
          ));
        }
      }
      
      $numrow++; // Tambah 1 setiap kali looping
    }
    // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
    if ($jns == 'pns') {
      $this->mabsensi->insert_multiple($data);
    } else if ($jns == 'pppk') {
      $this->mabsensi->insert_multiple_pppk($data);
    }
    
    $data['dataabsen'] = $this->mabsensi->tampilabsensi();    
    $data['unker'] = $this->mkinerja->dd_unker()->result_array();
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['content'] = 'absensi/tampilabsensi';
    $this->load->view('template', $data);
  }

  // END UNTUK IMPORT DATA KE EXCEL

  function showtampilabsensi() {
    $uk = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    $jns = $this->input->get('jns');
  
    if ($jns == 'pns') {
      $dataabsen = $this->mabsensi->tampilabsensi_perunker($uk, $thn, $bln);
    } else if ($jns == 'pppk') {
      $dataabsen = $this->mabsensi->tampilabsensi_perunker_pppk($uk, $thn, $bln);
    }

    ?>
    <br/>
    <table cellpadding="8" class='table table-condensed table-hover' style='width: 80%'>
      <tr class='info'>
        <td align='center' width='50'>NO</td>      
        <td align='center' width='300'>NIP</td>
        <td align='center' width='80'>JUMLAH HK</td>
        <td align='center' width='80'>HADIR</td>
        <td align='center' width='80'>IZIN</td>
        <td align='center' width='80'>SAKIT</td>
        <td align='center' width='80' class='warning'>TERLAMBAT</td>
        <td align='center' width='80'>PULANG CEPAT</td>
        <td align='center' width='80' class='danger'>TANPA KETERANGAN</td>
        <td align='center' width='80'>CUTI</td>
        <td align='center' width='80'>TUGAS DINAS</td>
        <td align='center' width='80'>TOTAL PENGURANG</td>
        <td align='center' width='80'><b>REALISASI</b></td>
      </tr>
      <?php
      if( ! empty($dataabsen)){ // Jika data pada database tidak sama dengan empty (alias ada datanya)
        $no = 1;
        foreach($dataabsen as $data){ // Lakukan looping pada variabel siswa dari controller
	  if ($jns == 'pns') {
            $id = $data->nip;
            $nama = $this->mpegawai->getnama($id);
          } else if ($jns == 'pppk') {
            $id = $data->nipppk;
            $nama = $this->mpppk->getnama_lengkap($id);
          }

          echo "<tr align='center'>";
          echo "<td>".$no."</td>";
          echo "<td align='left'>NIP. ".$id."<br/>".$nama."</td>";
          echo "<td>".$data->jml_hari."</td>";
          echo "<td>".$data->hadir."</td>";
          echo "<td>".$data->izin."</td>";
          echo "<td>".$data->sakit."</td>";
          echo "<td class='warning'>".$data->terlambat."</td>";
          echo "<td>".$data->pulang_cepat."</td>";
          echo "<td class='danger'>".$data->tk."</td>";
          echo "<td>".$data->cuti."</td>";
          echo "<td>".$data->tudin."</td>";
          if ($data->total_pengurang != 0) {
            echo "<td style='color: red'>".$data->total_pengurang."</td>";
            echo "<td style='color: red'><b>".round($data->realisasi,2)."</b></td>";
          } else {
            echo "<td>".$data->total_pengurang."</td>";
            echo "<td><b>".round($data->realisasi,2)."</b></td>";
          } 
          echo "</tr>";
          $no++;
        }
      }else{ // Jika data tidak ada
        echo "<tr><td colspan='11' align='center' style='color: red;'>DATA TIDAK DITEMUKAN</td></tr>";
      }
      ?>
      </table>
      <?php
  }

    // UNTUK EPRESENSI
  function tampilimportepresensi() {
    $data['unker'] = $this->mkinerja->dd_unker()->result_array();
    //if ($this->session->userdata('nominatif_priv') == "Y") {
    if ($this->session->userdata('level') == "ADMIN") {
      $hariini = date('d');
      if (($hariini >= 1) AND ($hariini <= 31)) {
        $data['pesan'] = '';
        $data['jnspesan'] = '';
        $data['status'] = 1;
      } else {
        $data['pesan'] = "<b>INFORMASI ::: </b>Import data Absensi Bulanan hanya dapat dilakukan pada tanggal 1 s/d 5 setiap bulan";
        $data['jnspesan'] = 'alert alert-info';
        $data['status'] = 0;
        //$data['content'] = 'content';
        //$this->load->view('template', $data);
      }      
    } else {
      $data['pesan'] = "<b>INFORMASI ::: </b>DILUAR KEWENANGAN ANDA";
      $data['jnspesan'] = 'alert alert-info';
      $data['status'] = 0;
    }
    $data['content'] = 'absensi/importdataepresensi';
    $this->load->view('template', $data);
  }

  function curl($url, $data) {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json', 'Content-Type:multipart/form-data; boundary=---011000010111000001101001', 'Authorization:Bearer bkpp'));
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json', 'Authorization:Bearer bkpp'));
    $output = curl_exec($ch); 
    //var_dump($output);
    curl_close($ch);      
    return $output;
  }


  function showabsbulanannip() {
    $nip = $this->input->get('nip');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');

    $dataparam = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
    $send = $this->curl("https://e-office.balangankab.go.id/silka/report/pegawai",$dataparam);

    var_dump($dataparam);
    //echo json_encode(array('respon'=>$send),JSON_UNESCAPED_SLASHES);
    $data = json_decode($send, true);
    echo "Jumlah Hari Kerja : ".$data['data']['jumlah_hari_kerja'];
    //echo "Total Potongan : ".$data['data']['absen_pegawai']['dataPegawai']['pegawai_nama'];
   
    foreach($data['data']['absen_pegawai'] as $d) :
      echo "Nama : ".$d['dataPegawai']['pegawai_nama'];
      echo "Total Potongan : ".$d['absenStatusPegawai']['totalPotongan'];
    endforeach;
    //var_dump($data);
  }

  function showabsbulanan() {
    $idunker = $this->input->get('uk');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    $jns = $this->input->get('jns');

    ?>
    <br/>
    <small>
    <table class='table table-hover table-condensed' style='width: 80%'>
      <tr class='info'>
        <td align='center' width='10'><b>NO</b></td>      
        <td align='center' width='220'><b>NIP / NAMA</b></td>
        <td align='center' width='150'><b>JML HARI KERJA</b></td>
        <td class='warning' align='center' width='100'><b>TERLAMBAT</b></td>
        <td align='center' width='100'><b>TEPAT WAKTU</b></td>
        <td align='center' width='100'><b>HADIR</b></td>
        <td class='warning' align='center' width='100'><b>TANPA KETERANGAN</b></td>
        <td align='center' width='100'><b>IZIN</b></td>
        <td align='center' width='100'><b>SAKIT</b></td>
        <td align='center' width='100'><b>CUTI</b></td>
        <td align='center' width='100'><b>TUGAS LUAR</b></td>
        <td align='center' width='100'><b>IZIN TERLAMBAT</b></td>
        <td align='center' width='150'><b>IZIN PULANG CEPAT</b></td>
        <td class='danger' width='100' align='center'><b>TOTAL POTONGAN</b></td>
        <td width='150' align='center'><b>REALISASI</b></td>
      </tr>
    <?php
    if ($jns == "pns") {
      $data = $this->munker->pegperunker($idunker)->result_array();
    } else if ($jns == "pppk") {
      $data = $this->munker->pppkperunker($idunker)->result_array();
    }
    
    $berhasil = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;

    $nmunker = $this->munker->getnamaunker($idunker);

    $no = 1;
    foreach($data as $dp) :      
      $nip = $dp['nip'];
      // Cek apakah PNS tersebut berhak atas TPP
      if ($jns == "pns") {
        $berhaktpp = $this->mkinerja->get_haktpp($nip);
        $nama = $this->mpegawai->getnama($dp['nip']);
      } else if ($jns == "pppk") {
        $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
        $nama = $this->mpegawai->getnama_pppk($dp['nip']);
      }
      
      echo "<tr>"; 
      echo "<td align='center'>".$no."</td>";                           
      echo "<td>NIP. ".$dp['nip']."<br/>".$nama."</td>";            

      if ($berhaktpp == 'YA') {
          $posts[] = array(
            "pegawai_nip" => $nip,
            "year"        => $thn,
            "month"       => $bln
          );

          //$data = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
          //$send = $this->curl("https://e-office.balangankab.go.id/silka/report/pegawai",$data);
          //$data = json_decode($send, true);
	  //$jml = count($data);

	  $data = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
          $send = curlApi("https://e-office.balangankab.go.id/silka/report/pegawai",$data);
      	  $data = json_decode($send, true);
      	  $jml = count($data);
	  //var_dump($data);
          if ($jml != 0) {
            if ($data['message'] == "Too Many Attempts.") { // "Too Many Attempts." (ada titiknya)
              echo "<td colspan='13' align='center' class='warning'><span class='text-danger'>DATA GAGAL DIAMBIL</span></td>";
              $tidakditemukan++;
		//var_dump($data);
            } else if ($data['message'] == "Data tidak ditemukan") {
              echo "<td colspan='13' align='center' class='danger'><span class='text-danger'>DATA TIDAK DITEMUKAN</span></td>"; 
               $tidakditemukan++;   
		//var_dump($data);
            } else if ($data['text'] == "success") {
	      echo "<td align='center'>".$data['data']['jumlah_hari_kerja']."</td>";
	      echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['terlambat']."</td>";
              echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['tepatWaktu']."</td>";
              echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['H']."</td>";
              echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['A']."</td>";
              echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['I']."</td>";
              echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['S']."</td>";
              echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['C']."</td>";
              echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['TL']."</td>";
              echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['IT']."</td>";
              echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['IPC']."</td>";
	      
	      if ($data['data']['jumlah_hari_kerja'] == $data['data']['absen_pegawai']['absenStatusPegawai']['A']) {
                $realisasi = 0;
              	$potongan = 100;
              } else {
                $potongan = $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
                $realisasi = 100 - $potongan;
              }

              echo "<td class='danger' align='center'>".$potongan." %</td>";
              echo "<td class='info' align='center'><b>".$realisasi."</b></td>";

              //echo "<td class='danger' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan']." %</td>";
              //$realisasi = 100 - $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];

              //echo "<td class='info' align='center'><b>".$realisasi."</b></td>";
              $berhasil++;
	    }
          }
      } else {
        echo "<td colspan='4' align='center' class='success'><span class='text-info'>TIDAK BERHAK TPP</span></td>";
        $tidaktpp++;
      }
      echo "</tr>";
      $no++;
    endforeach;    

    echo "</table>";
    echo "</small>";
    $no--;

    echo "<div class='row'>";    
    echo "<div class='col-md-4' align='right'>";
      echo "<h5><span class='label label-info'>Jumlah : ".$no."</span></h5>";
    echo "</div><div class='col-md-1' align='right'>";
      echo "<h5><span class='label label-success'>Data Valid : ".$berhasil."</span></h5>";
    echo "</div><div class='col-md-2' align='center'>";
      echo "<h5><span class='label label-warning'>Data Tidak ditemukan : ".$tidakditemukan."</span></h5>";
    echo "</div><div class='col-md-1' align='center'>";
      echo "<h5><span class='label label-danger'>Tidak berhak TPP : ".$tidaktpp."</span></h5>";
    echo "</div>";    
    echo "<div class='col-md-2'>";
      $tglini = date('d');
      $blnini = date('m');
      $thnini = date('Y');

      //echo $tglini." ".$blnini." ".$thnini;
      
      // pengecekan tanggal import
      // 1. hanya mengizinkan data bulan lalu yg di-import (paling lambat tanggal 4 bulan berikutnya)          
      // 2. data kinerja desember dapat diupload pada desember
      // 3. data kinerja desember dapat diupload pada januari

      if ((($bln == $blnini-1) AND ($thn == $thnini) AND ($tglini <= '28')) // 1.
          OR (($bln == '12') AND ($blnini == '12') AND ($thn == $thnini)) // 2.
          OR (($bln == '12') AND ($blnini == '1') AND ($thn == $thnini-1)) // 3.
          ) {         
          echo "<form method='POST' action='../absensi/importunker'>                
                <input type='hidden' name='idunker' id='idunker' maxlength='10' value='".$idunker."'>
                <input type='hidden' name='thn' id='thn' maxlength='4' value='".$thn."'>
                <input type='hidden' name='bln' id='bln' maxlength='4' value='".$bln."'>
                <input type='hidden' name='jns' id='bln' maxlength='4' value='".$jns."'>
                <button type='submit' class='btn btn-info btn-sm'>
                  <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspImport
                </button>
              </form>";
      }

    echo "</div>";

    echo "<div class='col-md-2'></div>";
    echo "</div>"; // tutup row

  }

  function tampilimportperorangan() {
    if ($this->session->userdata('nominatif_priv') == "Y") {
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $data['content'] = 'absensi/importdataperorangan';
      $this->load->view('template', $data);
    }
  }

  function showabsbulananperorangan() {
    $nip = $this->input->get('nip');
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');
    $jns = $this->input->get('jns');
    
    //echo $nip." ".$thn." ".$bln." ".$jns;

    $berhasil = 0;
    $tidakditemukan = 0;
    $tidaktpp = 0;

    if ($jns == "pns") {
      $berhaktpp = $this->mkinerja->get_haktpp($nip);
      $nama = $this->mpegawai->getnama($nip);
      $ket = 'NIP';
      // Cek apakah PNS yg dicari tersebut masuk kewenangan umpeg
      $masuk = count($this->mpegawai->getnipnama($nip)->result_array());
    } else if ($jns == "pppk") {
      $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
      $nama = $this->mpegawai->getnama_pppk($nip);
      $ket = 'NIPPPK';
      // Cek apakah PNS yg dicari tersebut masuk kewenangan umpeg
      $masuk = count($this->mpppk->getnipnama($nip)->result_array());
    }

    if ($masuk) {       
      if ($berhaktpp == 'YA') { 
        ?>
        <br/>
        <small>
          <table class='table table-bordered' style='width: 85%'>
            <tr class='info'> 
              <td align='center' width='250'><b><?php echo $ket; ?>/ NAMA</b></td>
	      <td align='center' width='100'><b>HARI KERJA</b></td>
              <td class='warning' align='center' width='100'><b>TERLAMBAT</b></td>
              <td align='center' width='100'><b>TEPAT WAKTU</b></td>
              <td align='center' width='100'><b>HADIR</b></td>
              <td class='warning' align='center' width='100'><b>TANPA KETERANGAN</b></td>
              <td align='center' width='100'><b>IZIN</b></td>
              <td align='center' width='100'><b>SAKIT</b></td>
              <td align='center' width='100'><b>CUTI</b></td>
              <td align='center' width='100'><b>TUGAS LUAR</b></td>
              <td class='warning' align='center' width='100'><b>IZIN TERLAMBAT</b></td>
              <td class='warning' align='center' width='150'><b>IZIN PULANG CEPAT</b></td>
              <td class='danger' width='100' align='center'><b>TOTAL POTONGAN</b></td>
              <td width='150' align='center'><b>REALISASI</b></td>
            </tr>
            <?php
            
            $posts[] = array(
              "pegawai_nip" => $nip,
              "year"        => $thn,
              "month"       => $bln
            );
	
	    $data = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
	    $url = "https://e-office.balangankab.go.id/silka/report/pegawai";
            $send = curlApi($url,$data);
	    $data = json_decode($send, true);
	
      	    //$dataparm = array("pegawai_nip"=>$nip,"year"=> $thn,"month"=> $bln);
	    //$send = curlApi("https://e-office.balangankab.go.id/silka/report/pegawai", $dataparm);
	    //$send = $this->curl("https://e-office.balangankab.go.id/silka/report/pegawai", $dataparm);
	    //var_dump($url);
            //var_dump($send);
	    //$data = json_decode($send, true);
	    //var_dump($data);

            $jml = count($data);
            if ($jml != 0) {
              echo "<small>";          
              echo "<tr>";
	      
              if ($data['text'] == "success") { 
                echo "<tr>";
                echo "<td>".$ket.".".$nip."<br/>".$nama."</td>"; 
                echo "<td align='center'>".$data['data']['jumlah_hari_kerja']."</td>";
		echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['terlambat']."</td>";
                echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['tepatWaktu']."</td>";
                echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['H']."</td>";
                echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['A']."</td>";
                echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['I']."</td>";
                echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['S']."</td>";
                echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['C']."</td>";
                echo "<td align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['TL']."</td>";
                echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['IT']."</td>";
                echo "<td class='warning' align='center'>".$data['data']['absen_pegawai']['absenStatusPegawai']['IPC']."</td>";
                
                if ($data['data']['jumlah_hari_kerja'] == $data['data']['absen_pegawai']['absenStatusPegawai']['A']) {
			$realisasi = 0;
			$potongan = 100;
		} else {
			$potongan = $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
			$realisasi = 100 - $potongan;
		}
	
		echo "<td class='danger' align='center'>".$potongan." %</td>";
                echo "<td class='info' align='center'><b>".$realisasi."</b></td>";            
		echo "</tr>";
		echo "</table>";
		
		$blnini = date('n'); // Ambil bulan tanpa diawali 0
		$thnini = date('Y');
		$sudahhitungtpp = $this->mkinerja->cektelahusul_tppng($nip, $thn, $bln);

		if ($sudahhitungtpp) {
			echo "<h4><span class='text-danger'>Kada kawa di-Impor karena TPP bulan ".bulan($bln)." ".$thn." sudah tuntung dihitung.</span></h4>";
		//} else if (($thnini == $thn) AND ($blnini == $bln+1) AND (!$sudahhitungtpp)) {
		} else {
		//} else if (($thnini == '2023')  AND (!$sudahhitungtpp)) {
		//} else if (($bln == '12') AND ($blnini == '1') AND ($thn == $thnini-1)) {
			echo "<div class='row'>";
            		echo "<div class='col-md-12'>";
            		echo "<form method='POST' action='../absensi/importperorangan'>
                    		<input type='hidden' name='nip' id='nip' maxlength='10' value='".$nip."'>
                    		<input type='hidden' name='thn' id='thn' maxlength='4' value='".$thn."'>
                    		<input type='hidden' name='bln' id='bln' maxlength='4' value='".$bln."'>
                    		<input type='hidden' name='jns' id='jns' maxlength='4' value='".$jns."'>
                    		<button type='submit' class='btn btn-danger btn-outline'>
                      		   <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspSimpan ePresensi
                   		</button>
                  	      </form>";
            		echo "</div>";
            		echo "<div class='col-md-2'></div>";
            		echo "</div>";
		}
                $berhasil++;
              } else {
                echo "<td colspan='14' align='center' class='info'><span class='text-danger'>DATA TIDAK DITEMUKAN</span></td>"; 
                $tidakditemukan++;   
              }
              //echo "<tr>";
	      //echo "<td colspan='14' align='center' class='warning'><span class='text-danger'>DATA TIDAK DITEMUKAN</span></td>";
              //echo "</small>";
            }

            echo "</table>";   
            echo "</small>";

            /*
	    echo "<div class='row'>";        
            echo "<div class='col-md-12'>";
            echo "<form method='POST' action='../absensi/importperorangan'>                
                    <input type='hidden' name='nip' id='nip' maxlength='10' value='".$nip."'>
                    <input type='hidden' name='thn' id='thn' maxlength='4' value='".$thn."'>
                    <input type='hidden' name='bln' id='bln' maxlength='4' value='".$bln."'>
                    <input type='hidden' name='jns' id='jns' maxlength='4' value='".$jns."'>
                    <button type='submit' class='btn btn-danger btn-sm'>
                      <span class='glyphicon glyphicon-import' aria-hidden='false'></span>&nbspImport Data ePresensi
                   </button>
                  </form>";
            echo "</div>";
            echo "<div class='col-md-2'></div>";
            echo "</div>";
	    */
        } else {
          echo "<br/><h4><span class='text-info'>PNS / PPPK Tidak Berhak TPP</span></h4>";
        }
      } else {
        echo "<br/><h5><span class='text-danger'>Data Tidak Ditemukan atau Diluar Kewenangan Pian</span></h5>";
      }    
  }

  public function importperorangan() {
    $nip = $this->input->post('nip');
    $thn = $this->input->post('thn');
    $bln = $this->input->post('bln');  
    $jns = $this->input->post('jns');

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    // Cek apakah PNS tersebut berhak atas TPP
    if ($jns == "pns") {
      $berhaktpp = $this->mkinerja->get_haktpp($nip);
      $nama = $this->mpegawai->getnama($nip);
    } else if ($jns == "pppk") {
      $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
      $nama = $this->mpegawai->getnama_pppk($nip);
    }

    if ($berhaktpp == 'YA') { 
      $data = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
      $send = curlApi("https://e-office.balangankab.go.id/silka/report/pegawai",$data);

      $data = json_decode($send, true);
      $jml = count($data);
      if ($jml != 0) {
        if ($data['message'] != "Data tidak ditemukan") { 
          $status = $data['text'];
	  $jml_hk = $data['data']['jumlah_hari_kerja'];
	  
	  // cek dlu apakah hasil API success dan hari kerja tidak nol
          if (($jns == "pns") AND ($status == "success") AND ($jml_hk != 0)) {
	    if ($jml_hk == $data['data']['absen_pegawai']['absenStatusPegawai']['A']) {
                $realisasi = 0;
                $potongan = 100;
            } else {
                $potongan = $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
            	$realisasi = 100 - $potongan;
            }
            //$realisasi = 100 - $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];

            $data = array(
            'nip'             => $nip,
            'bulan'           => $bln,
            'tahun'           => $thn,
            'jml_hari'        => $data['data']['jumlah_hari_kerja'],
            'hadir'           => $data['data']['absen_pegawai']['absenStatusPegawai']['H'],
            'izin'            => $data['data']['absen_pegawai']['absenStatusPegawai']['I'],
            'sakit'           => $data['data']['absen_pegawai']['absenStatusPegawai']['S'],
            'terlambat'       => $data['data']['absen_pegawai']['absenStatusPegawai']['terlambat'],
            'pulang_cepat'    => 0,
            'tk'              => $data['data']['absen_pegawai']['absenStatusPegawai']['A'],
            'cuti'            => $data['data']['absen_pegawai']['absenStatusPegawai']['C'],
            'tudin'           => $data['data']['absen_pegawai']['absenStatusPegawai']['TL'],
            'tepat_waktu'     => $data['data']['absen_pegawai']['absenStatusPegawai']['tepatWaktu'],
            'izin_terlambat'  => $data['data']['absen_pegawai']['absenStatusPegawai']['IT'],
            'izin_pulangcepat' => $data['data']['absen_pegawai']['absenStatusPegawai']['IPC'],
            'total_pengurang' => $potongan,
            'realisasi'       => $realisasi,
            'entry_by'       => $user,
            'entry_at'       => $tgl_aksi
            );

            if ($this->mabsensi->cekadadata($nip, $bln, $thn) == false) {
              if ($this->mabsensi->input_absensi($data)) {
                $hasil = "BERHASIL";
              } else {
                $hasil = "GAGAL";
              }
            } else {
              $where = array(
                'nip'             => $nip,
                'bulan'           => $bln,
                'tahun'           => $thn
                ); 

              if ($this->mabsensi->update_absensi($where, $data)) {
                $hasil= "BERHASIL";
              } else {
                $hasil = "GAGAL";
              }
            }
          } else if (($jns == "pppk") AND ($status == "success") AND ($jml_hk != 0)) {
	    if ($jml_hk == $data['data']['absen_pegawai']['absenStatusPegawai']['A']) {
                $realisasi = 0;
                $potongan = 100;
            } else {
                $potongan = $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
                $realisasi = 100 - $potongan;
            }
            //$realisasi = 100 - $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];

            $data = array(
            'nipppk'          => $nip,
            'bulan'           => $bln,
            'tahun'           => $thn,
            'jml_hari'        => $data['data']['jumlah_hari_kerja'],
            'hadir'           => $data['data']['absen_pegawai']['absenStatusPegawai']['H'],
            'izin'            => $data['data']['absen_pegawai']['absenStatusPegawai']['I'],
            'sakit'           => $data['data']['absen_pegawai']['absenStatusPegawai']['S'],
            'terlambat'       => $data['data']['absen_pegawai']['absenStatusPegawai']['terlambat'],
            'pulang_cepat'    => 0,
            'tk'              => $data['data']['absen_pegawai']['absenStatusPegawai']['A'],
            'cuti'            => $data['data']['absen_pegawai']['absenStatusPegawai']['C'],
            'tudin'           => $data['data']['absen_pegawai']['absenStatusPegawai']['TL'],
            'tepat_waktu'     => $data['data']['absen_pegawai']['absenStatusPegawai']['tepatWaktu'],
            'izin_terlambat'  => $data['data']['absen_pegawai']['absenStatusPegawai']['IT'],
            'izin_pulangcepat' => $data['data']['absen_pegawai']['absenStatusPegawai']['IPC'],
            'total_pengurang' => $potongan,
            'realisasi'       => $realisasi,
            'entry_by'       => $user,
            'entry_at'       => $tgl_aksi
            );

            if ($this->mabsensi->cekadadata_pppk($nip, $bln, $thn) == 0) {
              if ($this->mabsensi->input_absensi_pppk($data)) {
                $hasil = "BERHASIL";
              } else {
                $hasil = "GAGAL";
              }
            } else {
              $where = array(
                'nipppk'          => $nip,
                'bulan'           => $bln,
                'tahun'           => $thn
                ); 

              if ($this->mabsensi->update_absensi_pppk($where, $data)) {
                $hasil= "BERHASIL";
              } else {
                $hasil = "GAGAL";
              }
            }
          }
        } 
      }
    }

    $data['pesan'] = $hasil." <b>IMPORT NILAI ePRESENSI </b>bulan ".bulan($bln)." Tahun ".$thn." A.n. ".$nama;
    $data['jnspesan'] = "alert alert-success";  

    $data['unker'] = $this->mkinerja->dd_unker()->result_array();
    //$data['content'] = 'kinerja/importdata';
    $data['content'] = 'absensi/importdataperorangan';
    $this->load->view('template', $data);
  }

  public function importunker() {
    $idunker = $this->input->post('idunker');
    $thn = $this->input->post('thn');
    $bln = $this->input->post('bln');  
    $jns = $this->input->post('jns');

    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $nmunker = $this->munker->getnamaunker($idunker);
    // Cek apakah PNS tersebut berhak atas TPP
    if ($jns == "pns") {
      $data = $this->munker->pegperunker($idunker)->result_array();
    } else if ($jns == "pppk") {
      $data = $this->munker->pppkperunker($idunker)->result_array();
    }

    $no = 1;
    foreach($data as $dp) :      
      $nip = $dp['nip'];

      // Cek apakah PNS tersebut berhak atas TPP
      if ($jns == "pns") {
        $berhaktpp = $this->mkinerja->get_haktpp($nip);
      } else if ($jns == "pppk") {
        $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip);
      }

      if ($berhaktpp == 'YA') { 
        //$data = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
        //$send = $this->curl("https://e-office.balangankab.go.id/silka/report/pegawai",$data);
        //$data = json_decode($send, true);
        //$jml = count($data);

	$data = array("pegawai_nip"=>$nip,"year"=>$thn,"month"=>$bln);
      	$send = curlApi("https://e-office.balangankab.go.id/silka/report/pegawai",$data);

      	$data = json_decode($send, true);
      	$jml = count($data);
	//var_dump($jml);
        if ($jml != 0) {
          //if ($data['message'] != "Data tidak ditemukan") {             
	    $status = $data['text'];
            $jml_hk = $data['data']['jumlah_hari_kerja'];
            // cek dlu apakah hasil API success dan hari kerja tidak nol
            if (($jns == "pns") AND ($status == "success") AND ($jml_hk != 0)) {
	      if ($jml_hk != 0) {
		if ($jml_hk == $data['data']['absen_pegawai']['absenStatusPegawai']['A']) {
                	$realisasi = 0;
                        $potongan = 100;
                } else {
                        $potongan = $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
                        $realisasi = 100 - $potongan;
                }
              	//$realisasi = 100 - $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
	      } else {
		$realisasi = 0;
		$potongan = 100;
	      }

              $data = array(
              'nip'             => $nip,
              'bulan'           => $bln,
              'tahun'           => $thn,
              'jml_hari'        => $data['data']['jumlah_hari_kerja'],
              'hadir'           => $data['data']['absen_pegawai']['absenStatusPegawai']['H'],
              'izin'            => $data['data']['absen_pegawai']['absenStatusPegawai']['I'],
              'sakit'           => $data['data']['absen_pegawai']['absenStatusPegawai']['S'],
              'terlambat'       => $data['data']['absen_pegawai']['absenStatusPegawai']['terlambat'],
              'pulang_cepat'    => 0,
              'tk'              => $data['data']['absen_pegawai']['absenStatusPegawai']['A'],
              'cuti'            => $data['data']['absen_pegawai']['absenStatusPegawai']['C'],
              'tudin'           => $data['data']['absen_pegawai']['absenStatusPegawai']['TL'],
              'tepat_waktu'     => $data['data']['absen_pegawai']['absenStatusPegawai']['tepatWaktu'],
              'izin_terlambat'  => $data['data']['absen_pegawai']['absenStatusPegawai']['IT'],
              'izin_pulangcepat' => $data['data']['absen_pegawai']['absenStatusPegawai']['IPC'],
              'total_pengurang' => $potongan,
              'realisasi'       => $realisasi,
              'entry_by'       => $user,
              'entry_at'       => $tgl_aksi
              );

	      //'total_pengurang' => $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'],

              if ($this->mabsensi->cekadadata($nip, $bln, $thn) == 0) {
                if ($this->mabsensi->input_absensi($data)) {
                  $hasil = "BERHASIL";
                } else {
                  $hasil = "GAGAL";
                }
              } else {
                $where = array(
                  'nip'             => $nip,
                  'bulan'           => $bln,
                  'tahun'           => $thn
                  ); 

                if ($this->mabsensi->update_absensi($where, $data)) {
                  $hasil= "BERHASIL";
                } else {
                  $hasil = "GAGAL";
                }
              }
            } else if (($jns == "pppk") AND ($status == "success") AND ($jml_hk != 0)) {
              if ($jml_hk != 0) {
	      	if ($jml_hk == $data['data']['absen_pegawai']['absenStatusPegawai']['A']) {
                        $realisasi = 0;
                        $potongan = 100;
                } else {
                        $potongan = $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
                        $realisasi = 100 - $potongan;
                }
		//$realisasi = 100 - $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'];
	      } else {
                $realisasi = 0;
		$potongan = 100;
              }		

              $data = array(
              'nipppk'             => $nip,
              'bulan'           => $bln,
              'tahun'           => $thn,
              'jml_hari'        => $data['data']['jumlah_hari_kerja'],
              'hadir'           => $data['data']['absen_pegawai']['absenStatusPegawai']['H'],
              'izin'            => $data['data']['absen_pegawai']['absenStatusPegawai']['I'],
              'sakit'           => $data['data']['absen_pegawai']['absenStatusPegawai']['S'],
              'terlambat'       => $data['data']['absen_pegawai']['absenStatusPegawai']['terlambat'],
              'pulang_cepat'    => 0,
              'tk'              => $data['data']['absen_pegawai']['absenStatusPegawai']['A'],
              'cuti'            => $data['data']['absen_pegawai']['absenStatusPegawai']['C'],
              'tudin'           => $data['data']['absen_pegawai']['absenStatusPegawai']['TL'],
              'tepat_waktu'     => $data['data']['absen_pegawai']['absenStatusPegawai']['tepatWaktu'],
              'izin_terlambat'  => $data['data']['absen_pegawai']['absenStatusPegawai']['IT'],
              'izin_pulangcepat' => $data['data']['absen_pegawai']['absenStatusPegawai']['IPC'],
              'total_pengurang' => $data['data']['absen_pegawai']['absenStatusPegawai']['totalPotongan'],
              'realisasi'       => $realisasi,
              'entry_by'       => $user,
              'entry_at'       => $tgl_aksi
              );

              if ($this->mabsensi->cekadadata_pppk($nip, $bln, $thn) == 0) {
                if ($this->mabsensi->input_absensi_pppk($data)) {
                  $hasil = "BERHASIL";
                } else {
                  $hasil = "GAGAL";
                }
              } else {
                $where = array(
                  'nipppk'             => $nip,
                  'bulan'           => $bln,
                  'tahun'           => $thn
                  ); 

                if ($this->mabsensi->update_absensi_pppk($where, $data)) {
                  $hasil= "BERHASIL";
                } else {
                  $hasil = "GAGAL";
                }
              }
            }  // End PPPK
          // } // End Data ditemukan
        } // End jumlah != 0
      } // End berhak TPP

    endforeach;
    $data['unker'] = $this->munker->dd_unker()->result_array();
    $data['pesan'] = $hasil." <b>IMPORT NILAI ePRESENSI </b>bulan ".bulan($bln)." Tahun ".$thn." ".$nmunker;
    $data['jnspesan'] = "alert alert-success";
    $data['content'] = 'absensi/tampilabsensi';
    $this->load->view('template', $data);
  }

}




/* End of file Akunpns.php */
/* Location: ./application/controllers/Akunpns.php */
