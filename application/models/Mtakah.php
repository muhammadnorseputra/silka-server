<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Mtakah extends CI_Model
{
    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
    }

    // UNTUK TATA NASKAH
  public function rwytakah($nip)
  {
    $q = $this->db->query("select * from riwayat_takah where nip='$nip' order by upload_at desc");    
    return $q;    
  }

  function jnstakah()
  {
    $q = $this->db->query("select * from ref_jenis_takah");
    return $q;        
  }

  function getjnstakah($id)
  {
    $q = $this->db->query("select nama_jenis_takah from ref_jenis_takah where id_jenis_takah='$id'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->nama_jenis_takah; 
    }        
  }

  function nomtakahperunker($id)
    {
        //$q = $this->db->query("select p.nip, p.nama, p.gelar_depan, p.gelar_belakang from pegawai as p where p.fid_unit_kerja = '$id' order by p.fid_eselon, p.fid_golru_skr desc, p.tmt_golru_skr, p.tmt_cpns, p.fid_tingkat_pendidikan desc, p.tahun_lulus, p.tgl_lahir asc");
        $q = $this->db->query("select p.nip, p.nama, p.gelar_depan, p.gelar_belakang, p.fid_unit_kerja, rs.nip as 'nip_spesimen', rs.status as 'status_spesimen', rs.jabatan_spesimen from pegawai as p,ref_spesimen as rs where p.fid_unit_kerja = '$id' and p.fid_unit_kerja=rs.fid_unit_kerja order by p.fid_eselon, p.fid_golru_skr desc, p.tmt_golru_skr, p.tmt_cpns, p.fid_tingkat_pendidikan desc, p.tahun_lulus, p.tgl_lahir asc");
        return $q;
    }

  function cek_adatakah($nip, $id_jenis) {    
    $q = $this->db->query("select fid_jenis_takah from riwayat_takah where nip='".$nip."' and fid_jenis_takah='".$id_jenis."'");  
    return $q->num_rows();
  }

  function cek_adafiletakah($nip, $id_jenis) {    
    $q = $this->db->query("select fid_jenis_takah, file from riwayat_takah where nip='".$nip."' and fid_jenis_takah='".$id_jenis."'");    
    $nama = $this->mpegawai->getnama($nip);
    $namatakah = $this->getjnstakah($id_jenis);
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->file;
      if (file_exists('./fileperso/'.$berkas)) {
        if ($this->mpegawai->getjnskel($nip) == 'LAKI-LAKI') {
            return "<a class='btn btn-info btn-xs' href='../fileperso/$berkas' role='button' target='_blank' title='Berkas $namatakah : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>"; // ADA untuk laki-laki
        } else {
            return "<a class='btn btn-warning btn-xs' href='../fileperso/$berkas' role='button' target='_blank' title='Berkas $namatakah : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>"; // ADA untuk perempuan
        }
      } 
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }

  function getfiletakah($nip, $id_jenis)
  {
    $q = $this->db->query("select file from riwayat_takah where nip='".$nip."' and fid_jenis_takah='".$id_jenis."'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      return $row->file; 
    }        
  }

   function edit_takah($where, $data){
    $this->db->where($where);
    $this->db->update('riwayat_takah',$data);
    return true;
  }

  function input_takah($data){
    $this->db->insert('riwayat_takah',$data);
    return true;
  }

  function hapus_takah($where) {
    $this->db->where($where);
    $this->db->delete('riwayat_takah');
    return true;
  }

  function cek_adafilecp($nip) {    
    $q = $this->db->query("select berkas from cpnspns where nip='".$nip."'");
    $nama = $this->mpegawai->getnama($nip);
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;
       $pos1 = rand(1, 5);
      if ($pos1 % 2 == 1) {
            $jnsbtn = 'btn-outline';
          } else if ($pos1 % 2 == 0) {
            $jnsbtn = 'btn-inline';
          }
     $pos = rand(1, 5);
     if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

      if (file_exists('./filecp/'.$berkas.'.pdf')) {
         return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filecp/$berkas.pdf' role='button' target='_blank' title='Berkas CPNS/PNS : $nama'>
		<i class='fa fa-download fa-fw'></i><br/>Download</a>";
      } else if (file_exists('./filecp/'.$berkas.'.PDF')) {
         return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filecp/$berkas.PDF' role='button' target='_blank' title='Berkas CPNS/PNS : $nama'>
		<i class='fa fa-download fa-fw'></i><br/>Download</a>";
      }     
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }

  function cek_adafilekp($nip) { 
    $berkas = $this->mpegawai->getberkaskpterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
     $pos1 = rand(1, 5);
      if ($pos1 % 2 == 1) {
            $jnsbtn = 'btn-outline';
          } else if ($pos1 % 2 == 0) {
            $jnsbtn = 'btn-inline';
          }
     $pos = rand(1, 5);
     if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

    if (file_exists('./filekp/'.$berkas.'.pdf')) {
            return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filekp/$berkas.pdf' role='button' target='_blank' title='Berkas KP Terakhir : $nama'>
		<i class='fa fa-download fa-fw'></i><br/>Download</a>"; // ADA untuk laki-laki
    } else if (file_exists('./filekp/'.$berkas.'.PDF')) {
            return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filekp/$berkas.PDF' role='button' target='_blank' title='Berkas KP Terakhir : $nama'>
                <i class='fa fa-download fa-fw'></i><br/>Download</a>"; // ADA untuk laki-laki
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }

  function cek_adafilekgb($nip) { 
    $berkas = $this->mpegawai->getberkaskgbterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
     $pos1 = rand(1, 5);
      if ($pos1 % 2 == 1) {
            $jnsbtn = 'btn-outline';
          } else if ($pos1 % 2 == 0) {
            $jnsbtn = 'btn-inline';
          }
     $pos = rand(1, 5);
     if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

    if (file_exists('./filekgb/'.$berkas.'.pdf')) {
            return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filekgb/$berkas.pdf' role='button' target='_blank' title='Berkas KGB Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    } else if (file_exists('./filekgb/'.$berkas.'.PDF')) {
            return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filekgb/$berkas.PDF' role='button' target='_blank' title='Berkas KGB Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }

  function cek_adafilejab($nip) { 
    $berkas = $this->mpegawai->getberkasjabterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
     $pos1 = rand(1, 5);
      if ($pos1 % 2 == 1) {
            $jnsbtn = 'btn-outline';
          } else if ($pos1 % 2 == 0) {
            $jnsbtn = 'btn-inline';
          }
     $pos = rand(1, 5);
     if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

    if (file_exists('./filejab/'.$berkas.'.pdf')) {
            return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filejab/$berkas.pdf' role='button' target='_blank' title='Berkas Jabatan Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    } else if (file_exists('./filejab/'.$berkas.'.PDF')) {
            return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filejab/$berkas.PDF' role='button' target='_blank' title='Berkas Jabatan Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }

  function cek_adafileijazah($nip) { 
    $berkas = $this->mpegawai->getijazahterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
     $pos1 = rand(1, 5);
      if ($pos1 % 2 == 1) {
            $jnsbtn = 'btn-outline';
          } else if ($pos1 % 2 == 0) {
            $jnsbtn = 'btn-inline';
          }
     $pos = rand(1, 5);
     if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

    if (file_exists('./filepdk/'.$berkas.'.pdf')) {
        return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filepdk/$berkas.pdf' role='button' target='_blank' title='Berkas Ijazah Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    } else if (file_exists('./filepdk/'.$berkas.'.PDF')) {
        return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../filepdk/$berkas.PDF' role='button' target='_blank' title='Berkas Ijazah Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }

  function cek_adafileskp($nip) { 
    $tahun = $this->mpegawai->gettahunskpterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
    $pos1 = rand(1, 5);
      if ($pos1 % 2 == 1) {
            $jnsbtn = 'btn-outline';
          } else if ($pos1 % 2 == 0) {
            $jnsbtn = 'btn-inline';
          }
     $pos = rand(1, 5); 
      if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

    if (file_exists('./fileskp/'.$nip.'-'.$tahun.'.pdf')) {
        return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../fileskp/$nip-$tahun.pdf' role='button' target='_blank' title='Berkas SKP Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    } else if (file_exists('./fileskp/'.$nip.'-'.$tahun.'.PDF')) {
        return "<a class='btn btn-$warna $jnsbtn btn-xs' href='../fileskp/$nip-$tahun.PDF' role='button' target='_blank' title='Berkas SKP Terakhir : $nama'><i class='fa fa-download fa-fw'></i><br/>Download</a>";
    }
    return "<i class='fa fa-times fa-lg'></i>"; // TIDAK ADA 
  }
  

  /*
  * FUNCTION UNTUK CETAK LAPORAN
  * dipanggil pada file views/cetaktakahperunker.php 
  */

  function __cek_adafilecp($nip) {    
    $q = $this->db->query("select berkas from cpnspns where nip='".$nip."'");
    $nama = $this->mpegawai->getnama($nip);
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->berkas;
    if (file_exists('./filecp/'.$berkas.'.pdf')) {
         return "ADA";
      } else if (file_exists('./filecp/'.$berkas.'.PDF')) {
         return "ADA";
      }     
    }
    return "X"; // TIDAK ADA 
  }

  function __cek_adafilejab($nip) { 
    $berkas = $this->mpegawai->getberkasjabterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
    if (file_exists('./filejab/'.$berkas.'.pdf')) {
            return "ADA";
    } else if (file_exists('./filejab/'.$berkas.'.PDF')) {
            return "ADA";
    }
    return "X"; // TIDAK ADA 
  }

  function __cek_adafilekp($nip) { 
    $berkas = $this->mpegawai->getberkaskpterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);

    if (file_exists('./filekp/'.$berkas.'.pdf')) {
            return "ADA";
    } else if (file_exists('./filekp/'.$berkas.'.PDF')) {
            return "ADA";
    }
    return "X"; // TIDAK ADA 
  }
  
  function __cek_adafileijazah($nip) { 
    $berkas = $this->mpegawai->getijazahterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
    if (file_exists('./filepdk/'.$berkas.'.pdf')) {
        return "ADA";
    } else if (file_exists('./filepdk/'.$berkas.'.PDF')) {
        return "ADA";
    }
    return "X"; // TIDAK ADA 
  }

  function __cek_adafileskp($nip) { 
    $tahun = $this->mpegawai->gettahunskpterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
    if (file_exists('./fileskp/'.$nip.'-'.$tahun.'.pdf')) {
        return "ADA";
    } else if (file_exists('./fileskp/'.$nip.'-'.$tahun.'.PDF')) {
        return "ADA";
    }
    return "X"; // TIDAK ADA  
  }
  function __cek_adafilekgb($nip) { 
    $berkas = $this->mpegawai->getberkaskgbterakhir($nip);
    $nama = $this->mpegawai->getnama($nip);
    if (file_exists('./filekgb/'.$berkas.'.pdf')) {
             return "ADA";
    } else if (file_exists('./filekgb/'.$berkas.'.PDF')) {
             return "ADA";
    }
    return "X"; // TIDAK ADA  
  }
  function __cek_adafiletakah($nip, $id_jenis) {    
    $q = $this->db->query("select fid_jenis_takah, file from riwayat_takah where nip='".$nip."' and fid_jenis_takah='".$id_jenis."'");    
    $nama = $this->mpegawai->getnama($nip);
    $namatakah = $this->getjnstakah($id_jenis);
    if ($q->num_rows()>0)
    {
      $row=$q->row();
      $berkas = $row->file;
      if (file_exists('./fileperso/'.$berkas)) {
        if ($this->mpegawai->getjnskel($nip) == 'LAKI-LAKI') {
            return "ADA";
        } else {
            return "ADA";
        }
      } 
    }
    return "X"; // TIDAK ADA
  }    
}
 
/* End of file unker.php */
/* Location: ./application/models/unker.php */
