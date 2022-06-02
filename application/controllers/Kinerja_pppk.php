<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kinerja_pppk extends CI_Controller {

  // function construct, disini digunakan untuk memanggil model mawal.php
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('fungsitanggal');    
    $this->load->helper('fungsiterbilang');
    $this->load->helper('fungsipegawai');
    $this->load->model('mpegawai');
    $this->load->model('madmin');
    $this->load->model('munker');
    $this->load->model('mpppk');
    $this->load->model('mkinerja');
    $this->load->model('mkinerja_pppk');
    $this->load->model('mhukdis');

    // untuk fpdf
    $this->load->library('fpdf');

    // untuk login session
    if (!$this->session->userdata('nama'))
    {
      redirect('login');
    }
  }

  function tampilunkernom_pppk()
  {
    //cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['content'] = 'kinerja/tampilunkernom_pppk';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function nomperunker_pppk()
  { 
    $idunker = $this->input->post('id_unker');
    $thn = $this->input->post('tahun');
    $bln = $this->input->post('bulan');
      
    // cek priviledge session user -- nominatif_priv
    // id unker harus dipilih terlebih dahulu
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($idunker != 0)) {
      // cek apakah unit kerja telah mengusulkan atau belum
      $telahusul = $this->mkinerja_pppk->unkertelahusul_pppk($idunker, $thn, $bln);
      if ($telahusul == false) {

        // ENTRI DATA USULAN UNIT KERJA
        $created = $this->session->userdata('nip');
        $time = $this->mlogin->datetime_saatini();

        // START QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodekin_pppk/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(0,0,0); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 20; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }

        $image_name = $idunker."-".$thn.$bln.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

        $params['data'] = $idunker."-".$thn.$bln.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // END QR CODE

        $pengantar = array(
          'fid_unker'       => $idunker,
          'tahun'           => $thn,
          'bulan'           => $bln,
          'status'          => "ENTRI",
          'entri_at'        => $time,
          'entri_by'        => $created,
          'qrcode'          => $params['data']
          );
        // tambahkan data pengantar
        $this->mkinerja_pppk->input_unkertpp_pppk($pengantar);

        $idpengantar = $this->mkinerja_pppk->getidpengantar_pppk($idunker, $thn, $bln);

        $datapppk = $this->mpppk->pppkperunker($idunker)->result_array();
        
        $berhasil = 0;
        $gagal = 0;
        
        $nmunker = $this->munker->getnamaunker($idunker);
        $no = 1;
        foreach($datapppk as $dp) :
          
          $nip = $dp['nipppk'];
          
          // untuk pengecekan
          //$nama = $this->mpegawai->getnama($nip);
          //echo "<br/>".$no."-".$nip."/".$nama;

          // Cek apakah PNS tersebut berhak atas TPP
          $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip); 

          if ($berhaktpp == 'YA') { 

            //$nilaiskp = 100;
            $skp = $this->mkinerja_pppk->get_realisasikinerja($nip, $thn, $bln); 
            $nilaiskp = round($skp,2);            
            if ($nilaiskp > 100) {
              $nilaiskp=0;
            }

            $jabatan = $this->mkinerja_pppk->getnamajabatan($nip);            
            $nilai_absensi = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thn, $bln);

            $idtingpen = $dp['fid_tingkat_pendidikan'];
            $idgolru = $dp['fid_golru_pppk'];
            $kelasjabatan = $this->mkinerja_pppk->get_kelasjabft($nip);
            
            // SET TPP FULL DISINI
            $pengali = 0.77;
            $tppfull = $this->mkinerja_pppk->gettppfull($kelasjabatan);
                
            // UNTUK KONDISI NORMAL TANPA INDIKATOR TAMBAHAN 
            $tppbasic = $tppfull*$pengali;

            $keltugasjft = $this->mkinerja_pppk->getkeltugas_jft($nip);
            if (($keltugasjft == "PENDIDIKAN") OR ($keltugasjft == "KESEHATAN")) {
              $nilaiskp60p = 0; 
              $tpp_kinerja = 0;
            } else {
              $nilaiskp60p = 0.6*$nilaiskp;
              //$nilaiskp60p = 60;
              $tpp_kinerja = (number_format($nilaiskp60p,2)/100)*$tppbasic;                  
              $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
              $tpp_kinerja = pembulatan(round($tpp_kinerja,0));
            }

            $nilaiabsensi40p = 0.4*$nilai_absensi;
            $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
            $tpp_absensi = pembulatan(round($tpp_absensi,0));

            $jmltpp = $tpp_kinerja + $tpp_absensi;
            
            // Fitur tambahan TERPENCIL
            $cekterpencil = $this->mkinerja_pppk->cek_terpencil($idunker);
            if ($cekterpencil == "YA") {
              $terpencil = 'YA';
              $tambahterpencil = ($jmltpp * 10) / 100; // tambahan 10 %
            } else {
              $terpencil ='TIDAK';
              $tambahterpencil = 0;
            }     

            // Tambahan Kelas 1 dan 3 PASTI tidak digunakan, karena semua PPPK adalah JFT            
            $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;

            $pengurangan = 0;
            $penambahan = $tambahkelas1dan3+$tambahterpencil;
            $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
            
            $pajak = $this->hitungpajak($nip, $jmlbersih);
            //$pajak = 0;

            $jmlditerima = $jmlbersih - $pajak;

            $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $terpencil, $tambahterpencil, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);

            if ($input == true) {
              $berhasil++;
            } else if ($input == false) {
              $gagal++;
              $nama = $this->mpppk->getnama($nip);
              //echo "<br/>".$no."-".$nip."/".$nama." GAGAL";
            }
            // UNTUK KONDISI NORMAL TANPA INDIKATOR TAMBAHAN            

          } // end $berhaktpp          

          $no++;
        endforeach; // end $datapns

        $data['thn'] = $thn;
        $data['bln'] = $bln;          

        $data['idunker'] = $idunker;
        $data['nmunker'] = $this->munker->getnamaunker($idunker);
        $data['jmlpeg'] = $this->munker->getjmlpppk($idunker);
        $data['pesan'] = "<b>SUKSES</b>, Data Realisasi Kinerja PPPK ".$nmunker." Periode ".bulan($bln)." ".$thn.".<br/>Sebanyak ".$berhasil." data BERHASIL ditambahkan, dan ".$gagal." data GAGAL ditambahkan";
        $data['jnspesan'] = "alert alert-success";

        $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp($idunker, $thn, $bln)->result_array();

        $data['content'] = 'kinerja/nomperunker_pppk';
        $this->load->view('template',$data);
      }
    }
  }  

  function tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $terpencil, $tambahterpencil, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima) {
    $created = $this->session->userdata('nip');
    $time = $this->mlogin->datetime_saatini();
    $data = array(
      'fid_pengantar'   => $idpengantar,
      'nipppk'             => $nip,
      'tahun'           => $thn,
      'bulan'           => $bln,
      'jabatan'         => $jabatan,
      'fid_golru'       => $idgolru,
      'fid_unker'       => $idunker,
      'fid_tingpen'     => $idtingpen,
      'kelas_jab'       => $kelasjabatan,
      'pengali'         => $pengali,
      'tpp_basic'       => $tppbasic,
      'nilai_kinerja'   => $nilaiskp,
      'tpp_kinerja'     => $tpp_kinerja,
      'nilai_absensi'   => $nilai_absensi,
      'tpp_absensi'     => $tpp_absensi,            
      'jml_tpp_kotor'   => $jmltpp,
      'terpencil'           => $terpencil, 
      'jml_tpp_terpencil'   => $tambahterpencil,   
      'kelas1dan3'          => $kelas1dan3,
      'jml_tpp_kelas1dan3'  => $tambahkelas1dan3,
      'jml_pengurangan'     => $pengurangan,
      'jml_penambahan'      => $penambahan,
      'jml_tpp_murni'       => $jmlbersih,
      'jml_pajak'           => $pajak,
      'tpp_diterima'        => $jmlditerima,  
      'entri_at'            => $time,
      'entri_by'            => $created
      );

    if ($this->mkinerja_pppk->cektelahusul($nip, $thn, $bln) == 0) {
      if ($this->mkinerja_pppk->input_usultpp($data)) {
        return true;
      } else {
        return false;
      }              
    } 
  }

  function hitungpajak($nipppk, $totaltpp) {
    $idgolru = $this->mpppk->getidgolruterakhir($nipppk);
    $golru = $this->mpppk->getnamagolru($idgolru);

    if (($golru == "XIII") OR ($golru == "XIV") OR ($golru == "XV") OR ($golru == "XVI") OR ($golru == "XVII")) {
      $pajak = (15 * $totaltpp) / 100;
    } else if (($golru == "IX") OR ($golru == "X") OR ($golru == "XI") OR ($golru == "XII")) {
      $pajak = (5 * $totaltpp) / 100;
    } else {
      $pajak = 0;
    }

    return $pajak;
  }

  function cariusul_pppk() {
    if (($this->session->userdata('nominatif_priv') == "Y") OR ($this->session->userdata('level') == "ADMIN")) {
      $data['content'] = 'kinerja/cariusul_pppk';
      $data['pesan'] = '';
      $data['jnspesan'] = '';
      $this->load->view('template', $data);
    }
  }

  function tampilusul_pppk() {
    $thn = $this->input->get('thn');
    $bln = $this->input->get('bln');

    $sqlcari = $this->mkinerja_pppk->tampilusul_pppk($thn, $bln)->result_array();

    ?>
    <?php
    if ($this->session->userdata('level') == "ADMIN") {
    if (($thn != 0) AND ($bln != 0)) {
    ?>
      <div style='padding-right:40px; padding-bottom: 20px; margin-top:20px'>
        <div class="col-md-2" align='left'>
          <form method="POST" action="../kinerja_pppk/tambahusulunker_pppk">                
                <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
                <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
                <button type="submit" class="btn btn-danger btn-outline btn-sm">
                  <span class="fa fa-shield" aria-hidden="true"></span> Tambah UNIT KERJA
                </button>
              </form>
        </div>
  
        <div class="col-md-4" align='center'>
          <form role="form" method='POST' name='formkin' action="../kinerja_pppk/tambahusulsekolah">
            <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $thn; ?>'>
            <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bln; ?>'>
              <div class="form-group input-group">    
                <span class="input-group-addon"><small>Hitung TPP Sekolah</small></span>
                <select class="form-control" name="id_kec" id="id_kec" required>
                <?php
                  $kec = $this->mpegawai->kecamatan()->result_array();                
                  echo "<option value='' selected>- Pilih Kecamatan -</option>";
                  foreach($kec as $v):
                    if (!$this->mkinerja_pppk->unkertelahusul_pppk($v['id_kecamatan'], $thn, $bln)) {
                      echo "<option value=".$v['id_kecamatan'].">".$v['id_kecamatan']." | ".$v['nama_kecamatan']."</option>";
                    }
                  endforeach;
                ?>
                </select>
                <span class="input-group-addon">
                <button type="submit" class="btn btn-warning btn-xs" onClick="showData(formkin.nip.value, formkin.thn.value, formkin.bln.value)">
                  <span class="fa fa-shield" aria-hidden="true"></span> Hitung TPP
                </button>    
                </span>
              </div>
            </form>
          </div>

        <!-- UNTUK RSUD DAN PUSKESMAS
        <div class="col-md-4" align='center'>
          <form role="form" method='POST' name='formkin' action="../kinerja_pppk/tambahusulrsudpkm">
            <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php //echo $thn; ?>'>
            <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php //echo $bln; ?>'>
              <div class="form-group input-group">    
                <span class="input-group-addon"><small>Hitung TPP Kesehatan</small></span>
                <select class="form-control" name="id_unker" id="id_unker" required>
                <?php
                  /*
                  $kec = $this->mpegawai->rsud_puskesmas()->result_array();                
                  echo "<option value='' selected>- Pilih Unit Kerja -</option>";
                  foreach($kec as $v):
                    if (!$this->mkinerja_pppk->unkertelahusul_pppk($v['id_unit_kerja'], $thn, $bln)) {
                      echo "<option value=".$v['id_unit_kerja'].">".$v['nama_unit_kerja']."</option>";
                    }
                  endforeach;
                  */
                ?>
                </select>
                <span class="input-group-addon">
                  <button type="submit" class="btn btn-success btn-xs" onClick="showData(formkin.nip.value, formkin.thn.value, formkin.bln.value)">
                    <span class="fa fa-shield" aria-hidden="true"></span> Hitung TPP
                  </button>    
                </span>
              </div>
          </form>
        </div>

        <div class="col-md-2" align="right" align='center'>
          <form method="POST" action="../kinerja_pppk/cetakrekap_perperiode" target='_blank'>                
                <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php //echo $thn; ?>'>
                <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php //echo $bln; ?>'>
                <button type="submit" class="btn btn-success btn-sm">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Rekapitulasi
                </button>
              </form>
        </div>        
        -->
      </div>     
    <?php
    }
    }
    ?>

    <table class="table table-condensed table-hover"  style="font-size: 11px; margin-top:20px">
      <thead>
      <tr class='info'>
        <td align='center' width='20'><b>No</b></td>
        <td align='center' width='400'><b>UNIT KERJA</b></td>
        <td align='center' width='100'><b>KINERJA | ABSENSI</b></td>
        <td align='center' width='100'><b>JUMLAH<br/>USULAN</b></td>
        <td align='center' width='100'><b>TOTAL<br/>TPP REALISASI</b></td>        
        <td align='center' width='100'><b>TOTAL<br/>TAMBAHAN</b></td>
        <td align='center' width='100'><b>TOTAL<br/>SEBELUM PAJAK</b></td>
        <td align='center' width='100'><b>TOTAL PAJAK<br/><u>TOTAL IWP 1%</u></b></td>
        <td align='center' width='100'><b>TOTAL<br/>TPP DIBAYARKAN</b></td>
        <td align='center' width='170'><b>DIUSULKAN OLEH</b></td>
        <td align='center' width='30' colspan='3'><b>AKSI</b></td>
      </tr>     
      </thead>
      <tbody>
      <?php
      $totaltpp = 0;
      $no = 1; 
      foreach($sqlcari as $v):
        if ($v['totpns'] == 0) {
          if ($v['fid_unker'] == '12345') {
            $warna = "success";
          } else {  
            $warna = "warning";  
          }           
        } else {
          $warna = "default";
        }

        echo "<tr class=".$warna.">";
        echo "<td align='center'>$no</td>";
        $kecamatan = $this->mpegawai->getnamakecamatan($v['fid_unker']);
        if ($kecamatan) {
          $namaunker = "TK, SD, SMP SEDERAJAT KEC. ".$kecamatan;
        } else {
          $namaunker = $this->munker->getnamaunker($v['fid_unker']);
        }
        echo "<td>".$namaunker."<br/><code>Status : ".$v['status']."</code></td>";
        echo "<td align='center'>".number_format($v['rata_kinerja'],2)."<br/>".number_format($v['rata_absensi'],2)."</td>";
        echo "<td align='center'>".$v['totpns']."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottppkotor'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottambahan'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['tottpp_sebelumpajak'],0,",",".")."</td>";
        echo "<td align='center'>Rp. ".number_format($v['totpajak'],0,",",".")."<br><u>Rp. ".number_format($v['tot_iwp_bpjs'],0,",",".")."</u></td>";
        echo "<td align='center'>Rp. ".number_format($v['tottpp_dibayar'],0,",",".")."</td>";
        
        echo "<td><small>".tglwaktu_indo($v['entri_at'])."<br/>".$this->mpegawai->getnama($v['entri_by'])."</small></td>";        
        ?>
        <td align='center' width='30'>
          <?php          
          $cekrsudpkm = $this->mkinerja_pppk->cekrsudpkm_pppk($v['fid_unker']);
          if ($kecamatan) {
            //echo "<form method='POST' action='../kinerja_pppk/detail_pengantar_sekolahan'>"; 
	    echo "<form method='POST' action='../kinerja_pppk/detail_pengantar'>";
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";         
            echo "<button type='submit' class='btn btn-primary btn-xs'>";
            echo "<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else if ($cekrsudpkm) {
            //echo "<form method='POST' action='../kinerja_pppk/detail_pengantar_rsudpkm'>";
	    echo "<form method='POST' action='../kinerja_pppk/detail_pengantar'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";         
            echo "<button type='submit' class='btn btn-warning btn-xs'>";
            echo "<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          } else {
            echo "<form method='POST' action='../kinerja_pppk/detail_pengantar'>";          
            echo "<input type='hidden' name='fid_unker' id='fid_unker' value='$v[fid_unker]'>";
            echo "<input type='hidden' name='idpengantar' id='idpengantar' value='$v[id]'>";
            echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
            echo "<input type='hidden' name='bln' id='bln' value='$bln'>";         
            echo "<button type='submit' class='btn btn-primary btn-outline btn-xs'>";
            echo "<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span><br />Detail";
            echo "</button>";
            echo "</form>";
          }
          ?>
        </td>
        <td align='center' width='30'>
          <?php
            if (($this->session->userdata('level') == "ADMIN")) {
              if ($this->mkinerja_pppk->getstatuspengantar_pppk($v['fid_unker'], $thn, $bln) == "ENTRI") {
                echo "<form method='POST' action='../kinerja_pppk/hapus_pengantar'>";           
                echo "<input type='hidden' name='id' id='id' value='$v[id]'>";
                echo "<input type='hidden' name='thn' id='thn' value='$thn'>";
                echo "<input type='hidden' name='bln' id='bln' value='$bln'>";
                echo "<button type='submit' class='btn btn-danger btn-outline btn-xs'>";
                echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span><br />Hapus";
                echo "</button>";
                echo "</form>";
              }
            }
          ?>
        </td>
        <?php
        $no++;
        //$totaltpp = $totaltpp + $jmltppditerima;
        echo "</tr>";
      endforeach;
      ?>
      </tbody>    
    </table>

    <?php
    // if tabel statistik jumlah
    if (($this->session->userdata('level') == "ADMIN")) {
    ?>      
    <table class='table table-striped'>
        <tr>
        <td width='33%' style='padding: 10px;'>
        <?php
          $jmlpns = $this->mkinerja_pppk->totusul_perperiode($thn, $bln);
          $tottppkotor = $this->mkinerja_pppk->tottppkotor_perperiode($thn, $bln);
          $tottambahan = $this->mkinerja_pppk->tottambahan_perperiode($thn, $bln);
          $tottppmurni = $this->mkinerja_pppk->tottppmurni_perperiode($thn, $bln);
          $totpajak = $this->mkinerja_pppk->totpajak_perperiode($thn, $bln);
          $tottppditerima = $this->mkinerja_pppk->tottppditerima_perperiode($thn, $bln);
        ?>
          Jumlah PPPK 
          <span class='pull-right text-muted'><b>
          <?php echo $jmlpns." Orang"; ?></b></span><br/>
          
          Total TPP Sesuai Realisasi 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppkotor,0,",","."); ?></b></span><br/>

          Total Tambahan
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottambahan,0,",","."); ?></b></span><br/>

          Total TPP + Tambahan (Sebelum Pajak) 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppmurni,0,",","."); ?></b></span><br/>

          Total Pajak 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($totpajak,0,",","."); ?></b></span><br/>

          Total TPP yang Dibayarkan 
          <span class='pull-right text-muted'><b>
          <?php echo "Rp. ".number_format($tottppditerima,0,",","."); ?></b></span><br/>
        </td>
        <td width='33%' style='padding: 10px;'>
        </td>
        <td width='33%' style='padding: 10px;'>
        </td>    
        </tr>
      </table> 
    <?php
    } // end if tabel statistik jumlah
    ?>
    <?php
  }

  function tambahusulsekolah() { 
    //$idunker = '12345'; // ID Unker untuk semua sekolah    
    $id_kec = $this->input->post('id_kec'); // ID kecamatan digunakan untuk fid_unker
    $thn = $this->input->post('tahun');
    $bln = $this->input->post('bulan');
    
      $telahusul = $this->mkinerja_pppk->unkertelahusul_pppk($id_kec, $thn, $bln);
      if ($telahusul == false) {
        // ENTRI DATA USULAN UNIT KERJA
        $created = $this->session->userdata('nip');
        $time = $this->mlogin->datetime_saatini();

        // START QR CODE
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcodekin_pppk/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        //$config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(0,0,0); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        // membuat nomor acak untuk data QRcode
        $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string='';
        $pjg = 20; // jumlah karakter
        for ($i=0; $i < $pjg; $i++) {
          $pos = rand(0, strlen($karakter)-1);
          $string .= $karakter{$pos};
        }

        $image_name = $id_kec."-".$thn.$bln.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

        $params['data'] = $id_kec."-".$thn.$bln.$string; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        // END QR CODE

        $pengantar = array(
          'fid_unker'       => $id_kec,
          'tahun'           => $thn,
          'bulan'           => $bln,
          'entri_at'        => $time,
          'entri_by'        => $created,
          'qrcode'          => $params['data']
          );

        // tambahkan data pengantar
        $this->mkinerja_pppk->input_unkertpp_pppk($pengantar);

        $idpengantar = $this->mkinerja_pppk->getidpengantar_pppk($id_kec, $thn, $bln);

        $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
        $datapppk = $this->mkinerja_pppk->datapppksekolah($kecamatan)->result_array();
        $berhasil = 0;
        $gagal = 0;
        $no = 1;
        
        foreach($datapppk as $dp) :
          $nip = $dp['nipppk'];
          
          // untuk pengecekan
          //$nama = $this->mpegawai->getnama($nip);
          //echo "<br/>".$no."-".$nip."/".$nama;

          // Cek apakah PNS tersebut berhak atas TPP
          $berhaktpp = $this->mkinerja_pppk->get_haktpp_pppk($nip); 

          if ($berhaktpp == 'YA') { 

            //$nilaiskp = 100;
            $skp = $this->mkinerja_pppk->get_realisasikinerja($nip, $thn, $bln);            
            $nilaiskp = round($skp,2);            
            if ($nilaiskp > 100) {
              $nilaiskp=0;
            }

            $jabatan = $this->mkinerja_pppk->getnamajabatan($nip);            
            $nilai_absensi = $this->mkinerja_pppk->get_realisasiabsensi($nip, $thn, $bln);

            $idtingpen = $dp['fid_tingkat_pendidikan'];
            $idgolru = $dp['fid_golru_pppk'];
            $kelasjabatan = $this->mkinerja_pppk->get_kelasjabft($nip);
            // SET TPP FULL DISINI
            $pengali = 0.77;
            $tppfull = $this->mkinerja_pppk->gettppfull($kelasjabatan);
                
            // UNTUK KONDISI NORMAL TANPA INDIKATOR TAMBAHAN 
            $tppbasic = $tppfull*$pengali;

            $keltugasjft = $this->mkinerja_pppk->getkeltugas_jft($nip);
            if (($keltugasjft == "PENDIDIKAN") OR ($keltugasjft == "KESEHATAN")) {
              $nilaiskp60p = 0; 
              $tpp_kinerja = 0;
            } else {
              $nilaiskp60p = 0.6*$nilaiskp;
              //$nilaiskp60p = 60;
              $tpp_kinerja = (number_format($nilaiskp60p,2)/100)*$tppbasic;                  
              $tpp_kinerja = ($tppbasic*round($nilaiskp60p,2))/100;
              $tpp_kinerja = pembulatan(round($tpp_kinerja,0));
            }

            $nilaiabsensi40p = 0.4*$nilai_absensi;
            $tpp_absensi = ($tppbasic*round($nilaiabsensi40p,2))/100;
            $tpp_absensi = pembulatan(round($tpp_absensi,0));

            $jmltpp = $tpp_kinerja + $tpp_absensi;
            
            // Fitur tambahan TERPENCIL
            $idunker = $dp['fid_unit_kerja'];
            $cekterpencil = $this->mkinerja_pppk->cek_terpencil($idunker);
            if ($cekterpencil == "YA") {
              $terpencil = 'YA';
              $tambahterpencil = ($jmltpp * 10) / 100; // tambahan 10 %
            } else {
              $terpencil ='TIDAK';
              $tambahterpencil = 0;
            }     

            // Tambahan Kelas 1 dan 3 PASTI tidak digunakan, karena semua PPPK adalah JFT            
            $kelas1dan3 = 'TIDAK'; $tambahkelas1dan3 = 0;

            $pengurangan = 0;
            $penambahan = $tambahkelas1dan3+$tambahterpencil;
            $jmlbersih = ($jmltpp + $penambahan) - $pengurangan;
            
            $pajak = $this->hitungpajak($nip, $jmlbersih);
            //$pajak = 0;

            $jmlditerima = $jmlbersih - $pajak;

            $input = $this->tambahusul($idpengantar, $nip, $thn, $bln, $jabatan, $idgolru, $idunker, $idtingpen, $kelasjabatan, $pengali, $tppbasic, $nilaiskp, $tpp_kinerja, $nilai_absensi, $tpp_absensi, $jmltpp, $terpencil, $tambahterpencil, $kelas1dan3, $tambahkelas1dan3, $pengurangan, $penambahan, $jmlbersih, $pajak, $jmlditerima);

            if ($input == true) {
              $berhasil++;
            } else if ($input == false) {
              $gagal++;
              $nama = $this->mpppk->getnama($nip);
              //echo "<br/>".$no."-".$nip."/".$nama." GAGAL";
            }
          } // end $berhaktpp          

          $no++;
        endforeach; // end $datapns          
      }

      $data['thn'] = $thn;
      $data['bln'] = $bln;          

      $data['id_kec'] = $id_kec;
      $data['nmunker'] = $this->munker->getnamaunker($idunker);
      $data['jmlpeg'] = $this->munker->getjmlpeg($idunker);
      $data['pesan'] = "<b>SUKSES</b>, Data Realisasi Kinerja Bulanan SEKOLAH Periode ".bulan($bln)." ".$thn.".<br/>".$berhasil." data BERHASIL ditambahkan, dan ".$gagal." data GAGAL ditambahkan";
      $data['jnspesan'] = "alert alert-success";

      $data['idpengantar'] = $idpengantar;
      $data['jmlpeg'] = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
      $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();


      $data['content'] = 'kinerja/nomsekolahan_pppk';
      $this->load->view('template',$data);        
  }

  function detail_pengantar_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $fid_unker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['idpengantar'] = $idpengantar;
    $data['id_kec'] = $fid_unker;
    $data['nmunker'] = $this->mpegawai->getnamakecamatan($fid_unker);
    $data['jmlpeg'] = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan_pppk';
    $this->load->view('template',$data);
  }
  
  function lanjutverifikasi_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $id_kec = addslashes($this->input->post('id_kec'));
    $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data = array(
      'status'              => "VERIFIKASI"
      );

    $where = array(
      'id'              => $idpengantar,
      'tahun'           => $thn,
      'bulan'           => $bln,
      );           

    //$namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja_pppk->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP PPPK SEKOLAH ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP PPPK SEKOLAH ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idpengantar'] = $idpengantar;
    $data['id_kec'] = $id_kec;
    $data['nmunker'] = $this->mpegawai->getnamakecamatan($id_kec);
    $data['jmlpeg'] = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan_pppk';
    $this->load->view('template',$data);
  }

  function simpankalkulasi_sekolahan() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $id_kec = addslashes($this->input->post('id_kec'));
    $kecamatan = $this->mpegawai->getnamakecamatan($id_kec);
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    //$idunker = '12345'; // ID untuk rakapan sekolahan

    $ratakinerja = $this->mkinerja_pppk->getratakinerja_perpengantar($idpengantar, $thn, $bln);
    $rataabsensi = $this->mkinerja_pppk->getrataabsensi_perpengantar($idpengantar, $thn, $bln);
    // Jumlah TPP sebelum pajak
    $totpns = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $tottppkotor = $this->mkinerja_pppk->tottppkotor_perpengantarperiode($idpengantar, $thn, $bln);
    $tottambahan = $this->mkinerja_pppk->tottambahan_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppmurni = $this->mkinerja_pppk->tottppmurni_perpengantarperiode($idpengantar, $thn, $bln);
    
    $totpajak = $this->mkinerja_pppk->totpajak_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppditerima = $this->mkinerja_pppk->tottppditerima_perpengantarperiode($idpengantar, $thn, $bln);
    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'status'              => "REKAP",
      'rata_kinerja'        => $ratakinerja,
      'rata_absensi'        => $rataabsensi,
      'totpns'              => $totpns,
      'tottppkotor'         => $tottppkotor,
      'tottambahan'         => $tottambahan,
      'tottpp_sebelumpajak' => $tottppmurni,
      'totpajak'            => $totpajak,
      'tottpp_dibayar'      => $tottppditerima,
      'updated_at'          => $tgl_aksi,         
      'updated_by'          => $user
      );

    $where = array(
      'id'              => $idpengantar,
      'tahun'           => $thn,
      'bulan'           => $bln,
      );           

    //$namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja_pppk->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP PPPK SEKOLAH ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP PPPK SEKOLAH ".$kecamatan." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idpengantar'] = $idpengantar;
    $data['id_kec'] = $id_kec;
    $data['nmunker'] = $this->mpegawai->getnamakecamatan($id_kec);
    $data['jmlpeg'] = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomsekolahan_pppk';
    $this->load->view('template',$data);
  }

  public function cetakrekapsekolahan_perperiode()  
  {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $id_kec = addslashes($this->input->post('id_kec'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));
    $status = "CETAK";  // status cuti : CETAUKUSUL
    $idunker = "12345";

      // update status cuti : CETAKUSUL => 2
    $data = array(      
      'status'      => $status
      );

    $where = array(
      'id'        => $idpengantar,
      'tahun'     => $thn,
      'bulan'     => $bln
      );

    if ($this->mkinerja_pppk->update_pengantartpp($where, $data))
    {
      $res['idunker'] = '12345';
      $res['thn'] = $thn;
      $res['bln'] = $bln;
      $res['data'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result();
      
      $this->load->view('/kinerja/cetakrekapsekolahanperiode_pppk',$res);  
    }      
  }

  function tambahusulunker_pppk()
  {
    //cek priviledge session user -- nominatif_priv
    if (($this->session->userdata('nominatif_priv') == "Y") AND ($this->session->userdata('level') == "ADMIN")) {
      $tahun = $this->input->post('tahun');
      $bulan = $this->input->post('bulan');
      $data['unker'] = $this->mkinerja->dd_unker()->result_array();
      $data['tahun'] = $tahun;
      $data['bulan'] = $bulan;
      $data['content'] = 'kinerja/tampilunkernom_pppk';
      $this->load->view('template',$data);
    } else {
      $data['content'] = 'khususadmin';
      $this->load->view('template',$data);
    }
  }

  function detail_pengantar() {
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['pesan'] = '';
    $data['jnspesan'] = '';
    $data['idpengantar'] = $idpengantar;
    $data['idunker'] = $idunker;
    if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104') OR
        ($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
        $data['nmunker'] = "SEKOLAHAN ".$this->mpegawai->getnamakecamatan($idunker);
    } else {
        $data['nmunker'] = $this->munker->getnamaunker($idunker);
    }

    //$data['jmlpeg'] = $this->munker->getjmlpppk($idunker);
    //$data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['jmlpeg'] = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();

    if ($thn >= '2021' AND $bln >= '3') {
        $data['content'] = 'kinerja/nomperunker_pppk-baru';
    } else {
        $data['content'] = 'kinerja/nomperunker_pppk';
    }

    $this->load->view('template',$data);
  }

  function hapus_pengantar(){
    $idpengantar = addslashes($this->input->post('id'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $wherepengantar = array('id' => $idpengantar,
                   'tahun' => $thn,
                   'bulan' => $bln
    );

    $whereusul = array('fid_pengantar' => $idpengantar,
                   'tahun' => $thn,
                   'bulan' => $bln
    );

    if ($this->mkinerja_pppk->hapus_pengantar($wherepengantar)) {
        if ($this->mkinerja_pppk->hapus_usul($whereusul)) {// hapus seluruh usulan pada tabel usul_tpp
          $data['pesan'] = '<b>Sukses</b>, Usulan TPP PPPK periode '.bulan($bln).' '.$thn.' berhasil dihapus';
          $data['jnspesan'] = 'alert alert-success';
        } else {
          $data['pesan'] = '<b>Sukses</b>, Pengantar TPP PPPK periode '.bulan($bln).' '.$thn.' berhasil dihapus,<br/>tapi data usulan gagal dihapus';
          $data['jnspesan'] = 'alert alert-info';
        }
      } else {
        $data['pesan'] = '<b>Gagal</b>, Usulan TPP PPPK periode '.bulan($bln).' '.$thn.' gagal dihapus';
        $data['jnspesan'] = 'alert alert-danger';
      }

    $data['content'] = 'kinerja/cariusul_pppk';
    $this->load->view('template', $data);
  }

  function lanjutverifikasi() {
    $idunker = addslashes($this->input->post('fid_unker'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $data = array(
      'status'          => "VERIFIKASI"
    );

    $where = array(
      'fid_unker'       => $idunker,
      'tahun'           => $thn,
      'bulan'           => $bln,
      );           

    $namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja_pppk->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP PPPK ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Diproses.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP PPPK ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Diproses.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    
    $data['idunker'] = $idunker;
    $data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->munker->getjmlpppk($idunker);
    $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp($idunker, $thn, $bln)->result_array();

    $data['content'] = 'kinerja/nomperunker_pppk';
    $this->load->view('template',$data);
  }

  function simpankalkulasi() {
    $idunker = addslashes($this->input->post('fid_unker'));
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));

    $ratakinerja = $this->mkinerja_pppk->getratakinerja_perpengantar($idpengantar, $thn, $bln);
    $rataabsensi = $this->mkinerja_pppk->getrataabsensi_perpengantar($idpengantar, $thn, $bln);
    // Jumlah TPP sebelum pajak
    $totpns = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $tottppkotor = $this->mkinerja_pppk->tottppkotor_perpengantarperiode($idpengantar, $thn, $bln);
    $tottambahan = $this->mkinerja_pppk->tottambahan_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppmurni = $this->mkinerja_pppk->tottppmurni_perpengantarperiode($idpengantar, $thn, $bln);
    
    $totpajak = $this->mkinerja_pppk->totpajak_perpengantarperiode($idpengantar, $thn, $bln);
    $totiwp = $this->mkinerja_pppk->totiwp_perpengantarperiode($idpengantar, $thn, $bln);
    $tottppditerima = $this->mkinerja_pppk->tottppditerima_perpengantarperiode($idpengantar, $thn, $bln);
    
    $user = addslashes($this->session->userdata('nip'));
    $tgl_aksi = $this->mlogin->datetime_saatini();

    $data = array(
      'status'              => "REKAP",
      'rata_kinerja'        => $ratakinerja,
      'rata_absensi'        => $rataabsensi,
      'totpns'              => $totpns,
      'tottppkotor'         => $tottppkotor,
      'tottambahan'         => $tottambahan,
      'tottpp_sebelumpajak' => $tottppmurni,
      'totpajak'            => $totpajak,
      'tot_iwp_bpjs'	    => $totiwp,
      'tottpp_dibayar'      => $tottppditerima,
      'updated_at'          => $tgl_aksi,         
      'updated_by'          => $user
      );

    $where = array(
      'fid_unker'       => $idunker,
      'tahun'           => $thn,
      'bulan'           => $bln,
      );           

    $namaunker = $this->munker->getnamaunker($idunker);
    if ($this->mkinerja_pppk->update_pengantartpp($where, $data)) {
      $data['pesan'] = "<b>SUKSES</b>, Rekapitulasi TPP PPPK ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." BERHASIL Disimpan.";
      $data['jnspesan'] = "alert alert-success";  
    } else {
      $data['pesan'] = "<b>GAGAL</b>, Rekapitulasi TPP PPPK ".$namaunker." Bulan ".bulan($bln)." Tahun ".$thn." GAGAL Disimpan.";
      $data['jnspesan'] = "alert alert-warning";
    }              
   
    $data['thn'] = $thn;
    $data['bln'] = $bln;
    $data['idunker'] = $idunker;
    $data['idpengantar'] = $idpengantar;
    if (($idunker == '631101') OR ($idunker == '631102') OR ($idunker == '631103') OR ($idunker == '631104') OR
        ($idunker == '631105') OR ($idunker == '631106') OR ($idunker == '631107') OR ($idunker == '631108')) {
        $data['nmunker'] = "SEKOLAHAN ".$this->mpegawai->getnamakecamatan($idunker);
    } else {
        $data['nmunker'] = $this->munker->getnamaunker($idunker);
    }

    //$data['nmunker'] = $this->munker->getnamaunker($idunker);
    $data['jmlpeg'] = $this->mkinerja_pppk->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
    $data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result_array();
    //$data['jmlpeg'] = $this->munker->getjmlpppk($idunker);
    //$data['usul_tpp'] = $this->mkinerja_pppk->tampil_usultpp($idunker, $thn, $bln)->result_array();

    if ($thn >= '2021' AND $bln >= '3') {
        $data['content'] = 'kinerja/nomperunker_pppk-baru';
    } else {
        $data['content'] = 'kinerja/nomperunker_pppk';
    }

    $this->load->view('template',$data);
  }

  public function cetakrekapunor_perperiode()  
  {
    $idunker = addslashes($this->input->post('fid_unker'));;
    $idpengantar = addslashes($this->input->post('idpengantar'));
    $thn = addslashes($this->input->post('thn'));
    $bln = addslashes($this->input->post('bln'));
    $status = "CETAK";  // status cuti : CETAUKUSUL

      // update status cuti : CETAKUSUL => 2
    $data = array(      
      'status'      => $status
      );

    $where = array(
      'id'        => $idpengantar,
      'fid_unker' => $idunker,
      'tahun'     => $thn,
      'bulan'     => $bln
      );

    if ($this->mkinerja_pppk->update_pengantartpp($where, $data))
    {
      $res['idunker'] = $idunker;
      $res['idpengantar'] = $idpengantar;
      $res['thn'] = $thn;
      $res['bln'] = $bln;
      $res['data'] = $this->mkinerja_pppk->tampil_usultpp($idunker, $thn, $bln)->result();
      //$res['data'] = $this->mkinerja_pppk->tampil_usultpp_perpengantar($idpengantar, $thn, $bln)->result();

      if (($thn >= '2021' AND $bln >= '3') OR ($thn >= '2022')) {
        $this->load->view('/kinerja/cetakrekapunorperiode_pppk-baru',$res);
      } else {
        $this->load->view('/kinerja/cetakrekapunorperiode_pppk',$res);
      }    
    }      
  }

  // Statistika PPPK
    function statistika2021()
    {
      if ($this->session->userdata('level') == "ADMIN") {
        //$data['grafik'] = $this->mcuti->getjmlprosesbystatusgraphcuti();
        //$data['thncuti'] = $this->mcuti->gettahunrwycuti()->result_array(); 
        $data['rwyperbulan'] = $this->mkinerja_pppk->getjmlrwyperbulan('2021'); 
        $data['content'] = 'kinerja/statistika2021_pppk';
        $this->load->view('template',$data);
      }
    }

  // HITUNG TPP MANUAL
  private $filename = "import_hitungtpp";
  public function import_hitungmanual(){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
    $excelreader = new PHPExcel_Reader_Excel2007();
    $loadexcel = $excelreader->load('exceltpp/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

    // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
    $data = array();
    
    $numrow = 1;
    $jml = 0;
    $bulanini = date('m');

    foreach($sheet as $row){
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){
        if ($row['A'] != "" or $row['B'] != "" or $row['F'] != "" or $row['G'] != "" or $row['I'] != "" or $row['G'] == $bulanini-1) {
          $idunker = $row['A'];
          $tahun = $row['F'];
          $bulan = $row['G'];
          // Cekapakah ada pengantar untuk usul ini  
          $pengantar = $this->mkinerja_pppk->unkertelahusul_pppk($idunker, $tahun, $bulan);
          if (!$pengantar) { // tidak ada pengantar
            // BUAT PENGARTAR BARU
            $created = $this->session->userdata('nip');
            $time = $this->mlogin->datetime_saatini();
            // START QR CODE
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/qrcodekin_pppk/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            //$config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(0,0,0); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            // membuat nomor acak untuk data QRcode
            $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
            $string='';
            $pjg = 20; // jumlah karakter
            for ($i=0; $i < $pjg; $i++) {
              $pos = rand(0, strlen($karakter)-1);
              $string .= $karakter{$pos};
            }

            $image_name = $idunker."-".$tahun.$bulan.$string.'.png'; //nama file nip (18 karakter) + '-' + nomor acak (17 karakter acak) + '.png'

            $params['data'] = $idunker."-".$tahun.$bulan.$string; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

            // END QR CODE

            $pengantar = array(
            'fid_unker'       => $idunker,
            'tahun'           => $tahun,
            'bulan'           => $bulan,
            'status'          => "VERIFIKASI",
            'entri_at'        => $time,
            'entri_by'        => $created,
            'qrcode'          => $params['data']
            );
            // tambahkan data pengantar
            $this->mkinerja_pppk->input_unkertpp_pppk($pengantar);
          }
          // End Buat Pengantar
          $nipppk = $row['B'];
          $jabatan = $row['E'];
          $kelas = $row['H'];
          $basic = $row['I'];
	  $indikator = $row['J'];
          $plt = $row['K'];
          $tam_plt = $row['L'];
          $mk7h = $row['M'];
          $ctk1b = $row['N'];
          $ket = $row['O'];

        // Indikator Kinerja
	$jnsjab = "FUNGSIONAL TERTENTU";
	$keltugasjft = $this->mpppk->getkeltugas_jft_nipppk($nipppk);
	$nilai_skp = $this->mkinerja_pppk->get_realisasikinerja($nipppk, $tahun, $bulan);
        if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH")) {
          if ($nilai_skp >= 90) {
            $nilai_skp_pengali = 100;
            $kat_skp = "<span class='label label-primary'>SANGAT BAIK</span>";
          } else if (($nilai_skp >= 76) AND ($nilai_skp < 90)) {
            $nilai_skp_pengali = 90;
            $kat_skp = "<span class='label label-success'>BAIK</span>";
          } else if (($nilai_skp >= 61) AND ($nilai_skp < 76)) {
            $nilai_skp_pengali = 80;
            $kat_skp = "<span class='label label-warning'>CUKUP</span>";
          } else if (($nilai_skp >= 51) AND ($nilai_skp < 61)) {
            $nilai_skp_pengali = 70;
            $kat_skp = "<span class='label label-danger'>KURANG</span>";
          } else if (($nilai_skp >= 10) AND ($nilai_skp < 51)) {
            $nilai_skp_pengali = 40;
            $kat_skp = "<span class='label label-danger'>BURUK</span>";
          }
          $nilaiskp60p = 0.6*$nilai_skp_pengali;
          //$tpp_kin = ($basic*round($nilaiskp60p,2))/100;
	  $tpp_kin = ($basic*$nilaiskp60p)/100;
	  
          if ($mk7h == "YA") {
            $tpp_kin = $tpp_kin * 0.4; // Jika masuk kerja kurang dari 7 hari maka TPP Kinerja 40%
          }

          if ($ctk1b == "YA") {
            $tpp_kin = 0; // Jika masuk kerja kurang dari 7 hari maka TPP Kinerja 40%
          }
	} else if (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN")) {
          $tpp_kin = 0;
        }
	$tpp_kin = pembulatan_satuan($tpp_kin);
        // End Indikator Kinerja

          // Start Indikator Absensi
          //$nilai_abs = $this->mkinerja_pppk->get_realisasiabsensi($nipppk, $tahun, $bulan);  
          //$nilaiabsensi40p = 0.4*$nilai_abs;
	  //$tpp_abs = ($basic*$nilaiabsensi40p)/100;
	  //$tpp_abs = pembulatan_satuan($tpp_abs);
	  // End Indikator Absensi

	  //START ABSENSI
          $jnsjab = "FUNGSIONAL TERTENTU";
          $keltugasjft = $this->mpppk->getkeltugas_jft_nipppk($nipppk);
          $nilai_abs = $this->mkinerja_pppk->get_realisasiabsensi($nipppk, $tahun, $bulan);
          if (($jnsjab == "STRUKTURAL") OR ($jnsjab == "FUNGSIONAL UMUM") OR ($keltugasjft == "TEKNIS") OR ($keltugasjft == "PENYULUH")) {
            $nilaiabsensi40p = 0.4*$nilai_abs;
            $tpp_abs = ($basic*round($nilaiabsensi40p,2))/100;
          } else if (($keltugasjft == "KESEHATAN") OR ($keltugasjft == "PENDIDIKAN")) {
            $tpp_abs = ($basic*round($nilai_abs,2))/100;
          }
          $tpp_abs = pembulatan_satuan($tpp_abs);
          //END ABSENSI

          //$tpp_bruto = $tpp_kin + $tpp_abs;
	  $tpp_bruto = pembulatan_satuan($tpp_kin) + pembulatan_satuan($tpp_abs);
          $tambahan = 0;
                    
          $pph = $this->hitungpph($nipppk, $tahun, $bulan, $tpp_bruto);

          $tpp_netto = round($tpp_bruto) - round($pph);
	  $iwp = $this->hitungiwp($nipppk, $tahun, $bulan, $tpp_netto);
	  $thp =  $tpp_netto - round($iwp);
          
	  $idgolru = $this->mpppk->getidgolruterakhir($nipppk);

          $id_pengantar = $this->mkinerja_pppk->getidpengantar_pppk($idunker, $tahun, $bulan);
          $created = $this->session->userdata('nip');
          $time = $this->mlogin->datetime_saatini();

          $data = array(
            'fid_pengantar'   => $id_pengantar,          
            'nipppk'          => $nipppk,
            'tahun'           => $tahun,
            'bulan'           => $bulan,
            'jabatan'         => $jabatan,
	    'fid_golru'       => $idgolru,
            'fid_unker'       => $idunker,
            'kelas_jab'       => $kelas,
            'tpp_basic'       => $basic,
            'nilai_kinerja'   => $nilai_skp,
            'tpp_kinerja'     => $tpp_kin,
            'nilai_absensi'   => $nilai_abs,
            'tpp_absensi'     => $tpp_abs,
            'jml_tpp_kotor'   => pembulatan_satuan($tpp_kin) + pembulatan_satuan($tpp_abs),
            'cutitk_1bulan'   => $ctk1b,
            'jml_penambahan'  => $tambahan,
            'jml_tpp_murni'   => $tpp_bruto,
            'jml_pajak'       => $pph,
            'jml_iuran_bpjs'  => round($iwp),
            'tpp_diterima'    => round($thp),
	    'ket'	      => $ket,
            'entri_at'        => $time,
            'entri_by'        => $created
          );

          $where = array(
            'nipppk'             => $nipppk,
            'tahun'           => $tahun,
            'bulan'           => $bulan
          ); 

          // Cek apakah telah pernah usul
          if ($this->mkinerja_pppk->cektelahusul($nipppk, $tahun, $bulan) == 0) {
            $this->mkinerja_pppk->input_usultpp($data);
            $jml++;
          } else {
            $this->mkinerja_pppk->update_usultpp($where, $data);
            $jml++;
          }
        }
      }
      $numrow++; // Tambah 1 setiap kali looping
    }        
        
    $nmunker = $this->munker->getnamaunker($idunker);
    $data['content'] = 'kinerja/cariusul_pppk';
    $data['pesan'] = "Perhitungan TPP PPPK pada ".$nmunker." periode ".bulan($bulan)." ".$tahun." sejumlah ".$jml." PNS BERHASIL DISIMPAN";
    $data['jnspesan'] = 'alert alert-info';
    $this->load->view('template', $data);
  }

  function hitungpph($nipppk, $thn, $bln, $tppbruto) {
    $gajibruto =  $this->mkinerja_pppk->get_gajibruto($nipppk, $thn, $bln);
    $jnsptkp =  $this->mkinerja_pppk->get_jnsptkp($nipppk);
    $jnskel =  $this->mpppk->getjnskel($nipppk);
    if (($jnsptkp == '') OR ($jnsptkp == null) OR ($jnskel == 'PEREMPUAN')) {
      // jika data ptkp kosong, maka dihitung TK/0
      $jnsptkp = 'TK/0';
      $ptkp =  $this->mkinerja_pppk->get_ptkp($jnsptkp);  
    } else {
      $ptkp =  $this->mkinerja_pppk->get_ptkp($jnsptkp);
    }


    $npwp =  $this->mkinerja_pppk->get_npwp($nipppk);

    $jmlpot =  $this->mkinerja_pppk->get_jmlpotongan($nipppk, $thn, $bln);

    $hasilbruto = $gajibruto + $tppbruto;
     // Biaya jabatan 5% maksimal 500ribu
    $biayajab = $hasilbruto * 0.05;
    if ($biayajab > 500000) {
      $biayajab = 500000;
    }

    $hasilnetto = $hasilbruto-($jmlpot + round($biayajab)); 
    $hasilnetto_tahun = $hasilnetto*12;

    $pkp = $hasilnetto_tahun - $ptkp;
    $pkp_b = pembulatan_ribuan(round($pkp));

    $pph = 0;
    if (($pkp_b >= 1) AND ($pkp_b <= 50000000)) {
      $pph = $pkp_b*0.05;
    } else if (($pkp_b > 50000000) AND ($pkp_b <= 250000000)) {
      $pph = $pph + 2500000 + (($pkp_b - 50000000) * 0.15);
    } else if (($pkp_b > 250000000) AND ($pkp_b <= 500000000)) {
      $pph = $pph + 32500000 + (($pkp_b-250000000) * 0.25);
    } else if ($pkp_b > 500000000) {
      $pph = $pph + 95000000 + (($pkp_b-500000000) * 0.30);
    }

    $pph_perbulan = $pph / 12;
    if ($npwp == '') {
             // jika NPWP tidak ada, maka PPh jadi 120%
      $pph_perbulan = $pph_perbulan * 1.2;
    }      

    $created = $this->session->userdata('nip');
    $time = $this->mlogin->datetime_saatini();
    $data = array(
      'nipppk'             => $nipppk,
      'tahun'           => $thn,
      'bulan'           => $bln,
      'tpp_bruto'       => $tppbruto,
      'gaji_bruto'      => $gajibruto,
      'biaya_jab'       => $biayajab,
      'jml_pot'         => $jmlpot,
      'peng_netto'      => $hasilnetto,
      'peng_netto_thn'  => $hasilnetto_tahun,
      'npwp'            => $npwp,
      'jns_ptkp'        => $jnsptkp,
      'ptkp'            => $ptkp,
      'pkp'             => $pkp,
      'pkp_bulat'       => $pkp_b,            
      'pph_tahun '      => $pph,
      'pph_bulan'       => $pph_perbulan,
      'entri_at'        => $time,
      'entri_by'        => $created
      );

    $where = array(
      'nipppk'             => $nipppk,
      'tahun'           => $thn,
      'bulan'           => $bln
      );           

    if ($this->mkinerja_pppk->cekadapph($nipppk, $thn, $bln) == 0) {
      if ($this->mkinerja_pppk->input_pph($data)) {
        return $pph_perbulan;
      } else {
        return 0;
      }              
    } else {
      // pernah usul
      if ($this->mkinerja_pppk->update_pph($where, $data)) {
        return $pph_perbulan;
      } else {
        return 0;
      }
    }
  }

  function hitungiwp($nipppk, $thn, $bln, $tppbruto) {    
    // IWP
    $iwp_gaji =  $this->mkinerja_pppk->get_iwpgaji($nipppk, $thn, $bln);
    $iwp_tpp = $tppbruto*0.01; // IWP TPP 1% dari TPP bruto
    $iwp_total = $iwp_gaji + $iwp_tpp;
    if ($iwp_total > 120000) {
      $iwp_terhutang = 120000-$iwp_gaji;
    } else {
      $iwp_terhutang = $iwp_tpp;
    }
    // END IWP

    $data = array(
      'iwp_gaji'        => $iwp_gaji,            
      'iwp_tpp'         => $iwp_tpp,         
      'iwp_terhutang'   => $iwp_terhutang,  
      );

    $where = array(
      'nipppk'             => $nipppk,
      'tahun'           => $thn,
      'bulan'           => $bln
      );           

    if ($this->mkinerja_pppk->cekadapph($nipppk, $thn, $bln) == 0) {
      if ($this->mkinerja_pppk->input_pph($data)) {
        return $iwp_terhutang;
      } else {
        return 0;
      }              
    } else {
      // pernah usul
      if ($this->mkinerja_pppk->update_pph($where, $data)) {
        return $iwp_terhutang;
      } else {
        return 0;
      }
    }
  }
  // END HITUNG TPP MANUAL

}


