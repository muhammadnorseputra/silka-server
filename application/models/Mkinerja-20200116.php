<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Mkinerja extends CI_Model
{
    // function construct, disini digunakan untuk memanggil model mawal.php
    public function __construct()
    {
      parent::__construct();
    }

    
    function dd_unker()
    {
        //$sql = "SELECT * from ref_unit_kerja";
        $nip = $this->session->userdata('nip');
        $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                WHERE
                u.fid_instansi_userportal = i.id_instansi
                and u.unker_ekinerja != ''
                and up.nip = '$nip'
                and i.nip_user like '%$nip%' order by u.id_unit_kerja";
        return $this->db->query($sql);
    }

    function get_idunkerkinerja($id)
    {
        $q = $this->db->query("select unker_ekinerja from ref_unit_kerjav2 where id_unit_kerja='$id'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->unker_ekinerja; 
        }        
    }

    function get_idunker($nip)
    {
        $q = $this->db->query("select fid_unit_kerja from pegawai where nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->fid_unit_kerja; 
        }        
    }

    public function get_jnsjab($nip)
      {
        $q = $this->db->query("select jj.nama_jenis_jabatan from ref_jenis_jabatan as jj, pegawai as p where p.fid_jnsjab = jj.id_jenis_jabatan and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->nama_jenis_jabatan; 
        }        
      }

    function get_kelasjabstruk($nip)
    {
        $q = $this->db->query("select j.kelas from ref_jabstruk as j, pegawai as p where p.fid_jabatan=j.id_jabatan and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas; 
        }        
    }

    function get_hargajabstruk($nip)
    {
        $q = $this->db->query("select j.harga from ref_jabstruk as j, pegawai as p where p.fid_jabatan=j.id_jabatan and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->harga; 
        }        
    }

    function get_kelasjabfu($nip)
    {
        $q = $this->db->query("select j.kelas from ref_jabfu as j, pegawai as p where p.fid_jabfu=j.id_jabfu and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas; 
        }        
    }

    function get_hargajabfu($nip)
    {
        $q = $this->db->query("select j.harga from ref_jabfu as j, pegawai as p where p.fid_jabfu=j.id_jabfu and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->harga; 
        }        
    }

    function get_kelasjabft($nip)
    {
        $q = $this->db->query("select j.kelas from ref_jabft as j, pegawai as p where p.fid_jabft=j.id_jabft and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas; 
        }        
    }

    function get_hargajabft($nip)
    {
        $q = $this->db->query("select j.harga from ref_jabft as j, pegawai as p where p.fid_jabft=j.id_jabft and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->harga; 
        }        
    }

    function input_usultpp($data){
        $this->db->insert('usul_tpp',$data);
        return true;
    }

    function cektelahusul($nip, $tahun, $bulan)
      { 
        $q = $this->db->query("select nip from usul_tpp where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");  

        return $q->num_rows();
      }

    function update_usultpp($where, $data)
      {
        $this->db->where($where);
        $this->db->update('usul_tpp',$data);
        return true;
      }

    function update_pengantartpp($where, $data)
      {
        $this->db->where($where);
        $this->db->update('usul_tpp_pengantar',$data);
        return true;
      }


    public function tampil_usultpp($idunker, $tahun, $bulan)
      {
        $q = $this->db->query("select * from usul_tpp where fid_unker='".$idunker."' and tahun='".$tahun."' and bulan='".$bulan."' order by kelas_jab desc, fid_golru desc");
        return $q;    
      }

    public function tampil_usultpp_perpengantar($idpengantar, $tahun, $bulan)
      {
        $q = $this->db->query("select ut.* from usul_tpp as ut, pegawai as p where ut.nip = p.nip and ut.fid_pengantar='".$idpengantar."' and ut.tahun='".$tahun."' and ut.bulan='".$bulan."' order by p.nama, ut.kelas_jab desc, ut.fid_golru desc");
        return $q;    
      }


    function cek_pejdefinitifplt($idjabstruk)
    {
        $q = $this->db->query("select nip, fid_jabatan, tmt_jabatan from pegawai where fid_jabatan='".$idjabstruk."'");
        return $q->num_rows();       
    }

    /*
    // Cek riwayat PLT cara pertama
    function cek_sdgplt($nip, $bulan, $tahun)
      {    
        $q = $this->db->query("select nip, fid_jabstruk, tmt_awal, tmt_akhir from riwayat_plt where nip='".$nip."'");    

        $jml = $q->num_rows();
        if ($jml != 0) {
            $row=$q->row();
            //$tmtawal = substr($row->tmt_awal,5,2);
            //$tmtakhir = substr($row->tmt_akhir,5,2);
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidjabstruk = $row->fid_jabstruk;
            
            // cek apakah ada pejabat definitif nya
            if ($this->cek_pejdefinitifplt($fidjabstruk) == 1) { // berarti ada definitfnya, stop perhitungan, return false
                return false;
            } else { // jika tidak ada definitifnya, lanjutkan perhitungan TPP PLT nya
                $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

                // bandingkana apakah bulan usul tpp, masuk dalam rentang tmt awal dan akhir Plt-nya
                while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                    if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                        return true;
                    }
                    $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
                }
            }

            return false;
        }
      }
    */

    // KETENTUAN LOGIKA :
    // Cek dan pilih data pada riwayat PLT dengan tmt_awal paling terakhir -> MAX(tmt_awal)
    // bandingkan bulan tahun usul TPP, apakah masuk dalam range tmt_awal dan tmt_akhir riwayat jabatan PLT tersebut
    // cek apakah ada pejabat definitif untuk jabatan PLT tersebut, jika ada, return false
    // jika masuk dalam range tmt tersebut return true (masih PLT), jika tidak return false
    function cek_sdgplt($nip, $bulan, $tahun)
      {    
        $q = $this->db->query("select nip, fid_jabstruk, tmt_awal, tmt_akhir from riwayat_plt where nip='".$nip."' and tmt_awal IN (select MAX(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        $jml = $q->num_rows();
        if ($jml == 1) {
            $row=$q->row();
            //$tmtawal = substr($row->tmt_awal,5,2);
            //$tmtakhir = substr($row->tmt_akhir,5,2);
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidjabstruk = $row->fid_jabstruk;
            
            // cek apakah ada pejabat definitif nya
            if ($this->cek_pejdefinitifplt($fidjabstruk) == 1) { // berarti ada definitfnya, stop perhitungan, return false
                return false;
            } else { // jika tidak ada definitifnya, lanjutkan perhitungan TPP PLT nya
                $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

                // bandingkana apakah bulan usul tpp, masuk dalam rentang tmt awal dan akhir Plt-nya
                /*
                while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                    if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                        return true; 
                    }
                    // untuk perulangan operasi WHILE, tambahkan tmt_awal sebanyak 1 hari.
                    $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
                }
                */
                $c = 0;
                while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                    if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                        return true; 
                    }
                    // untuk perulangan operasi WHILE, tambahkan tmt_awal sebanyak 1 hari.
                    $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
                    $c++;
                }
            }
            return false;
        }
      }

    /*
    // Start jika Plt. dihitung harian
    function cek_sdgplt($nip, $bulan, $tahun)
      {    
        $q = $this->db->query("select nip, fid_jabstruk, tmt_awal, tmt_akhir from riwayat_plt where nip='".$nip."' and tmt_awal IN (select MAX(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        $jml = $q->num_rows();
        if ($jml == 1) {
            $row=$q->row();
            //$tmtawal = substr($row->tmt_awal,5,2);
            //$tmtakhir = substr($row->tmt_akhir,5,2);
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidjabstruk = $row->fid_jabstruk;
            
            // cek apakah ada pejabat definitif nya
            if ($this->cek_pejdefinitifplt($fidjabstruk) == 1) { // berarti ada definitfnya, stop perhitungan, return false
                return false;
            } else { // jika tidak ada definitifnya, lanjutkan perhitungan TPP PLT nya
                $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

                // bandingkana apakah bulan usul tpp, masuk dalam rentang tmt awal dan akhir Plt-nya
                while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                    if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                        // PNS bersangkutan masih menjabat PLT
                        // Hitung jumlah hari menjabat PLT.
                        $jmlharibulanini = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); // jumlah hari bulan ini
                        $bulantmtawal = substr($row->tmt_awal,5,2);
                        $tgltmtawal = substr($row->tmt_awal,8,2);
                        $bulantmtakhir = substr($row->tmt_akhir,5,2);
                        $tgltmtakhir = substr($row->tmt_akhir,8,2);
                        
                        if ($bulantmtawal == $bulan) {
                            $jmlhariplt = $jmlharibulanini-$tgltmtawal;
                            if ($jmlhariplt >= 19) {
                                return true;
                            } else {
                                return false;
                            }
                        } else if ($bulantmtakhir == $bulan) {
                            $jmlhariplt = $jmlharibulanini-$tgltmtakhir;
                            if ($jmlhariplt >= 19) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return true;
                        } 
                    }
                    // untuk perulangan operasi WHILE, tambahkan tmt_awal sebanyak 1 hari.
                    $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
                }
            }

            //return false;
        }
      }
    // End jika Plt. dihitung harian
    */

    function get_dataplt($nip)
      {    
        $q = $this->db->query("select nip, fid_jabstruk, tmt_awal, tmt_akhir from riwayat_plt where nip='".$nip."' and tmt_awal IN (select max(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        $jml = $q->num_rows();
        if ($jml != 0) {
            $row=$q->row();
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidjabstruk = $row->fid_jabstruk;
            $namajab = $this->mpegawai->namajab(1, $fidjabstruk);
            
            return $namajab." (TMT. ".tgl_indo($tmtawal)." s/d ".tgl_indo($tmtakhir).")";
        } else {
            return false;
        }
      }

    function get_jabplt($nip)
      {    
        $q = $this->db->query("select nip, fid_jabstruk from riwayat_plt where nip='".$nip."' and tmt_awal IN (select max(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        if ($q->num_rows()>0)
        {
            $row=$q->row();
            $fidjabstruk = $row->fid_jabstruk;
            $namajab = $this->mpegawai->namajab(1, $fidjabstruk);

            return $namajab; 
        }
      }

    function get_unkerplt($nip)
      {    
        $q = $this->db->query("select nip, unit_kerja from riwayat_plt where nip='".$nip."' and tmt_awal IN (select max(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->unit_kerja; 
        }
      }

    function get_kelasjabplt($nip)
      {    
        $q = $this->db->query("select rp.fid_jabstruk, rj.kelas from riwayat_plt as rp, ref_jabstruk as rj where rp.nip='".$nip."' and rp.fid_jabstruk=rj.id_jabatan and rp.tmt_awal IN (select max(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas; 
        }
      }

    function get_eselonplt($nip)
      {    
        $q = $this->db->query("select fid_jabstruk, fid_eselon from riwayat_plt where nip='".$nip."' and tmt_awal IN (select max(tmt_awal) from riwayat_plt where nip='".$nip."')");    

        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->fid_eselon; 
        }
      }
   

    function cek_sdgbendahara($nip, $bulan, $tahun)
      {    
        // fid_pokja untuk BENDAHARA = 2
        $q = $this->db->query("select nip, fid_pokja, tmt_awal, tmt_akhir from riwayat_pokja where nip='".$nip."' and fid_pokja='2' and tmt_awal IN (select max(tmt_awal) from riwayat_pokja where nip='".$nip."' and fid_pokja='2')");    

        $jml = $q->num_rows();
        if ($jml == 1) {
            $row=$q->row();
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidpokja = $row->fid_pokja;
            
            $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

            // bandingkana apakah bulan usul tpp, masuk dalam rentang tmt awal dan akhir Plt-nya
            while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                    return true;
                }
                $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
            }
            return false;
        }
    }

    function get_databendahara($nip)
      {    
        $q = $this->db->query("select nip, fid_pokja, tmt_awal, tmt_akhir from riwayat_pokja where nip='".$nip."' and fid_pokja='2' and tmt_awal IN (select max(tmt_awal) from riwayat_pokja where nip='".$nip."' and fid_pokja='2')");    

        $jml = $q->num_rows();
        if ($jml != 0) {
            $row=$q->row();
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidpokja = $row->fid_pokja;
            $namapokja = $this->get_namapokja($fidpokja);
            
            return $namapokja." (TMT. ".tgl_indo($tmtawal)." s/d ".tgl_indo($tmtakhir).")";
        } else {
            return false;
        }
      }

    function cek_sdgpokja($nip, $bulan, $tahun)
      {    
        // fid_pokja untuk POKJA UKPPJ = 1
        $q = $this->db->query("select nip, fid_pokja, tmt_awal, tmt_akhir from riwayat_pokja where nip='".$nip."' and fid_pokja='1' and tmt_awal IN (select max(tmt_awal) from riwayat_pokja where nip='".$nip."' and fid_pokja='1')");    

        $jml = $q->num_rows();
        if ($jml == 1) {
            $row=$q->row();
            $tmtawal = $row->tmt_awal;
            $tmtakhir = $row->tmt_akhir;
            $fidpokja = $row->fid_pokja;
            
            $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

            // bandingkana apakah bulan usul tpp, masuk dalam rentang tmt awal dan akhir Plt-nya
            while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                    return true;
                }
                $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
            }
            return false;
        }
    }

    function get_namapokja($id)
      {    
        $q = $this->db->query("select nama_pokja from ref_pokja where id_pokja='".$id."'");    

        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->nama_pokja; 
        }
      }


    // METODE BARU
    function input_unkertpp($data){
        $this->db->insert('usul_tpp_pengantar',$data);
        return true;
    }

    public function tampilusul($thn, $bln)
    {
        //$q = $this->db->query("select u.id_unit_kerja, u.nama_unit_kerja, t.* from usul_tpp_pengantar as t, ref_unit_kerjav2 as u WHERE t.fid_unker = u.id_unit_kerja and t.tahun = '".$thn."' and t.bulan = '".$bln."' order by u.id_unit_kerja desc");
        $q = $this->db->query("select * from usul_tpp_pengantar WHERE tahun = '".$thn."' and bulan = '".$bln."' order by fid_unker desc");

        return $q;
    }

    function getjumlahusul($idunker, $thn, $bln)
    {
        $q = $this->db->query("select ut.nip, ut.tahun, ut.bulan, ut.fid_unker from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    function getjumlahusul_perpengantar($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select nip, tahun, bulan from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    function getjumlahusul_perperiode($thn, $bln)
    {
        $q = $this->db->query("select ut.nip, ut.tahun, ut.bulan from usul_tpp as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    public function gettotaltppditerima($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as total from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            return $row->total; 
        }
    }

    public function getratakinerja($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.nilai_kinerja) as nilai from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul($idunker, $thn, $bln);
            if ($jml != 0) {
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    public function getratakinerja_perpengantar($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(nilai_kinerja) as nilai from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
            if ($jml != 0) {
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    public function getrataabsensi($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.nilai_absensi) as nilai from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul($idunker, $thn, $bln);
            if ($jml != 0) {                
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    public function getrataabsensi_perpengantar($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(nilai_absensi) as nilai from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul_perpengantar($idpengantar, $thn, $bln);
            if ($jml != 0) {                
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    public function unkertelahusul($idunker, $tahun, $bulan)
    {
        $q = $this->db->query("select fid_unker from usul_tpp_pengantar where fid_unker='".$idunker."' and tahun='".$tahun."' and bulan='".$bulan."'");
        if ($q->num_rows() > 0)
        {
            return true; // data ditemukan / telah diusulkan
        }    
    }

    function hapus_pengantar($where){
        $this->db->where($where);
        $this->db->delete('usul_tpp_pengantar');
        return true;
    }

    function hapus_usul($where){
        $this->db->where($where);
        $this->db->delete('usul_tpp');
        return true;
    }

    function cek_sdgcutisakit($nip, $bulan, $tahun)
      {    
        // fid_pokja untuk CUTI SAKIT = 3
        // jml >= 6 dan satuan_jml = 'BULAN'
        // atau jml >= 180 dan satuan_jml = 'HARI'
        $q = $this->db->query("select nip, fid_jns_cuti, tgl_mulai, tgl_selesai from riwayat_cuti where nip='".$nip."' and fid_jns_cuti='3' and ((jml >= 6 and satuan_jml = 'BULAN') OR (jml >= 180 and satuan_jml = 'HARI')) and tgl_mulai IN (select max(tgl_mulai) from riwayat_cuti where nip='".$nip."' and fid_jns_cuti='3')");    

        $jml = $q->num_rows();
        if ($jml == 1) {
            $row=$q->row();
            $tmtawal = $row->tgl_mulai;
            $tmtakhir = $row->tgl_selesai;
            
            $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

            // bandingkana apakah bulan usul tpp, masuk dalam rentang tgl mulai dan selesai cuti sakitnya
            while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                // YBS akan mendapatkan cuti sakit jika melewati tgl 1 pada bulan usul TPP
                if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {       
                    return true;
                }
                $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
            }
            return false;
        }
    }

    function cek_sdgcutibesar($nip, $bulan, $tahun)
    {    
        // fid_pokja untuk CUTI BESAR = 2
        $q = $this->db->query("select nip, fid_jns_cuti, tgl_mulai, tgl_selesai from riwayat_cuti where nip='".$nip."' and fid_jns_cuti='2' and ((jml >= 6 and satuan_jml = 'BULAN') OR (jml >= 180 and satuan_jml = 'HARI')) and tgl_mulai IN (select max(tgl_mulai) from riwayat_cuti where nip='".$nip."' and fid_jns_cuti='2')");    

        $jml = $q->num_rows();
        if ($jml == 1) {
            $row=$q->row();
            $tmtawal = $row->tgl_mulai;
            $tmtakhir = $row->tgl_selesai;
            
            $bulan_usultpp = $tahun."-".$bulan."-01"; // buat string tanggal usul tpp (tgl -01)

            // bandingkana apakah bulan usul tpp, masuk dalam rentang tgl mulai dan selesai cuti sakitnya
            while (strtotime($tmtawal) <= strtotime($tmtakhir)) {
                if (strtotime($bulan_usultpp) == strtotime($tmtawal)) {
                    return true;
                }
                $tmtawal = date ("Y-m-d", strtotime("+1 day", strtotime($tmtawal)));
            }
            return false;
        }
    }

    public function ceksekda($nip)
      {
        $q = $this->db->query("select rj.nama_jabatan from ref_jabstruk as rj, pegawai as p where p.fid_jabatan = rj.id_jabatan and p.fid_jnsjab='1' and p.nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            if ($row->nama_jabatan == "SEKRETARIS DAERAH") {
                return true;
            } else{
                return false;
            } 
        }        
      }

    public function cektidakadajfu($fid_jabstrukatasan)
    // cek apakah ada terdapat pns dgn fid_jnsjab = 2 (JFU) dan tingpen minimal S1/DIV dgn fid_jabstrukatasan
      {
        //$q = $this->db->query("select e.nama_eselon, p.nip, p.nama from ref_eselon as e, pegawai as p where p.fid_eselon = e.id_eselon and p.fid_jabstrukatasan = '$fid_jabstrukatasan' and p.fid_jnsjab='2' and e.nama_eselon='JFU'");
        $cekunor = $this->db->query("select u.nama_unit_kerja from ref_unit_kerjav2 as u, ref_jabstruk as j where j.fid_unit_kerja = u.id_unit_kerja and j.id_jabatan = '$fid_jabstrukatasan' and ((u.nama_unit_kerja like 'SEKRETARIAT%') OR (u.nama_unit_kerja like 'BADAN%') OR (u.nama_unit_kerja like 'DINAS%') OR (u.nama_unit_kerja like 'RUMAH SAKIT%'))");
        

        // cek unor, indikator tambahan non JFU tidak berlaku untuk Kec, Kel dan UPT
        if ($cekunor->num_rows()>0) { // berarti Unor masuk 
            // Cek apakah ada JFU dengan tingpen minimal S1/DIV
            //$q = $this->db->query("select e.nama_eselon, p.nip, p.nama from ref_eselon as e, pegawai as p, ref_unit_kerjav2 as u where p.fid_eselon = e.id_eselon and p.fid_jabstrukatasan = '$fid_jabstrukatasan' and p.fid_jnsjab='2' and e.nama_eselon='JFU' and p.fid_unit_kerja=u.id_unit_kerja and ((u.nama_unit_kerja like 'SEKRETARIAT%') OR (u.nama_unit_kerja like 'BADAN%') OR (u.nama_unit_kerja like 'DINAS%') OR (u.nama_unit_kerja like 'RUMAH SAKIT%'))");
            
            // untuk mendapatkan id_unker atasan
            $idunkeratasan = $this->getfidunker_idjab($fid_jabstrukatasan);
            // jangan lupa, cek id_unker atasan harus sama dengan id_unker jfu nya (jika ditemukan)
            // jangan sampai, jfu yg ditemukan untuk jabatan atasan tersebut ada pada skpd yang berbeda
            $q = $this->db->query("select e.nama_eselon, p.nip, p.nama from ref_eselon as e, pegawai as p, ref_tingkat_pendidikan as tp, ref_unit_kerjav2 as u where p.fid_eselon = e.id_eselon and p.fid_tingkat_pendidikan = tp.id_tingkat_pendidikan and (tp.nama_tingkat_pendidikan = 'D4' OR tp.nama_tingkat_pendidikan = 'S1' OR tp.nama_tingkat_pendidikan = 'S2' OR tp.nama_tingkat_pendidikan = 'S3') and p.fid_jabstrukatasan = '$fid_jabstrukatasan' and p.fid_jnsjab='2' and e.nama_eselon='JFU' and p.fid_unit_kerja='$idunkeratasan' and p.fid_unit_kerja=u.id_unit_kerja and ((u.nama_unit_kerja like 'SEKRETARIAT%') OR (u.nama_unit_kerja like 'BADAN%') OR (u.nama_unit_kerja like 'DINAS%') OR (u.nama_unit_kerja like 'RUMAH SAKIT%'))");
        
            if ($q->num_rows()>0)
            {
                return false; // memiliki staf JFU 
            } else {
                return true; // tidak memiliki staf JFU
            }
        } else {
            return "nocategory";
        }
                
      }

    function getfidunker_idjab($idjab)
      {
        $q = $this->db->query("select fid_unit_kerja from ref_jabstruk where id_jabatan='$idjab'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->fid_unit_kerja; 
        }        
      }

    function getdatajfubawahan($idjabstruk)
      {
        // untuk mendapatkan id_unker atasan
        $idunkeratasan = $this->getfidunker_idjab($idjabstruk);
        // cek unit kerja antara atasan dan jfu harus sama
        $q = $this->db->query("SELECT nip, fid_jabfu FROM pegawai WHERE fid_unit_kerja = '$idunkeratasan' and fid_jabstrukatasan = '$idjabstruk' and fid_jnsjab = '2'");
        return $q;       
      }

    public function cekradiografer($nip)
      {
        $q = $this->db->query("select rj.nama_jabft from ref_jabft as rj, pegawai as p where p.fid_jabft = rj.id_jabft and p.fid_jnsjab='3' and p.nip='$nip' and rj.nama_jabft like '%".$nip."%'");
        if ($q->num_rows()>0)
        {
            return true;
        } else {
            return false;
        }        
      }

    public function cekinspektorat($nip)
      {
        $q = $this->db->query("select u.nama_unit_kerja from ref_unit_kerjav2 as u, pegawai as p where p.fid_unit_kerja = u.id_unit_kerja and p.nip='$nip' and u.nama_unit_kerja = 'INSPEKTORAT'");
        if ($q->num_rows()>0)
        {
            return true;
        } else {
            return false;
        }        
      }

    function getfidjabstruk($nip)
      {
        $q = $this->db->query("select fid_jabatan from pegawai where fid_jnsjab = '1' and nip='$nip'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->fid_jabatan; 
        }        
      }

    function getnamajabatan($nip)
      {
        $q = $this->db->query("select fid_jnsjab, fid_jabatan, fid_jabft, fid_jabfu from pegawai where nip='$nip'");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          $idjnsjab = $row->fid_jnsjab;
          if ($row->fid_jnsjab == '1') {
            $nmjab = $this->mpegawai->namajab($idjnsjab,$row->fid_jabatan); 
          } else if ($row->fid_jnsjab == '2') {
            $nmjab = $this->mpegawai->namajab($idjnsjab,$row->fid_jabfu); 
          } else if ($row->fid_jnsjab == '3') {
            $nmjab = $this->mpegawai->namajab($idjnsjab,$row->fid_jabft); 
          }
          return $nmjab;
        }        
        return false;
      }
    
    function getstatuspengantar($idunker, $thn, $bln)
      {
        $sqlspk = $this->db->query("select status from usul_tpp_pengantar WHERE fid_unker = '".$idunker."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->status; 
        }    
      }

    function getstatuspengantar_perid($idpengantar, $thn, $bln)
      {
        $sqlspk = $this->db->query("select status from usul_tpp_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->status; 
        }    
      }

    function getidpengantar($idunker, $thn, $bln)
      {
        $sqlspk = $this->db->query("select id from usul_tpp_pengantar WHERE fid_unker = '".$idunker."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->id; 
        }    
      }

    function getqrcode($idunker, $thn, $bln)
      {
        $sqlspk = $this->db->query("select qrcode from usul_tpp_pengantar WHERE fid_unker = '".$idunker."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->qrcode; 
        }    
      }

    // END METODE BARU



    // START KALKULASI
    // Kalkulasi per periode per unit kerja
    
    // Jumlah TPP Gross (hasil realisasi) sebelum ada penambahan
    public function tottppkotor_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_tpp_kotor) as tpp_kotor from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_kotor;
            return $hasil; 
        }
    }

    public function tottppkotor_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_tpp_kotor) as tpp_kotor from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_kotor;
            return $hasil; 
        }
    }

    // Jumlah Tambahan
    public function tottambahan_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_penambahan) as jml_penambahan from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->jml_penambahan;
            return $hasil; 
        }
    }

    public function tottambahan_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_penambahan) as jml_penambahan from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->jml_penambahan;
            return $hasil; 
        }
    }


    // Jumlah TPP murni, yaitu TPP gross ditambah dengan tambahan (sebelum pajak)
    public function tottppmurni_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_tpp_murni) as tpp_murni from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_murni;
            return $hasil; 
        }
    }

    public function tottppmurni_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_tpp_murni) as tpp_murni from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_murni;
            return $hasil; 
        }
    }

    public function totpajak_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_pajak) as pajak from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->pajak;
            return $hasil; 
        }
    }

    public function totpajak_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_pajak) as pajak from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->pajak;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(tpp_diterima) as tpp_diterima from usul_tpp WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode_pergolru($idunker, $thn, $bln, $golru)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_golru as g, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_golru_skr = g.id_golru and g.nama_golru like '".$golru."%'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perpengantarperiode_pergolru($idpengantar, $thn, $bln, $golru)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_golru as g WHERE ut.fid_pengantar = '".$idpengantar."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_golru_skr = g.id_golru and g.nama_golru like '".$golru."%'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode_jpt($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('I/A','I/B','II/A','II/B')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perpengantarperiode_jpt($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e WHERE ut.fid_pengantar = '".$idpengantar."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('I/A','I/B','II/A','II/B')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode_administrator($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('III/A','III/B')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perpengantarperiode_administrator($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e WHERE ut.fid_pengantar = '".$idpengantar."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('III/A','III/B')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode_pengawas($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('IV/A','IV/B')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perpengantarperiode_pengawas($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e WHERE ut.fid_pengantar = '".$idpengantar."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('IV/A','IV/B')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode_jfujft($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('JFU','JFT','STAF','JABFUNG')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perpengantarperiode_jfujft($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp as ut, pegawai as p, ref_eselon as e WHERE ut.fid_pengantar = '".$idpengantar."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nip=ut.nip and p.fid_eselon = e.id_eselon and e.nama_eselon in ('JFU','JFT','STAF','JABFUNG')");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    // Kalkulasi per periode

    // jumlah usulan per periode yang diambil dari tabel usul_tpp_pengantar, tabel ini akan terisi setelah dilakukan SIMPAN KALKULASI oleh operator
    function totusul_perperiode($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.totpns) as totpns from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->totpns;
            return $hasil; 
        }
    }

    // Jumlah TPP Gross (hasil realisasi) sebelum ada penambahan
    public function tottppkotor_perperiode($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottppkotor) as tpp_kotor from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_kotor;
            return $hasil; 
        }
    }

    // Jumlah Tambahan
    public function tottambahan_perperiode($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottambahan) as jml_penambahan from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->jml_penambahan;
            return $hasil; 
        }
    }

    public function tottppmurni_perperiode($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_sebelumpajak) as tpp_murni from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_murni;
            return $hasil; 
        }
    }

    public function totpajak_perperiode($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.totpajak) as pajak from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->pajak;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_dibayar) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_gol4($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_gol4) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_gol3($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_gol3) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_gol2($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_gol2) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_gol1($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_gol1) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_jpt($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_jpt) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_administrator($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_administrator) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_pengawas($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_pengawas) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    public function tottppditerima_perperiode_jfujft($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tottpp_jfujft) as tpp_diterima from usul_tpp_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    // END KALKULASI

    // START STATISTIK
    public function getjmlrwyperbulan()
      {
        $query = $this->db->query("select bulan, sum(tpp_diterima) as 'jumlah' from usul_tpp where tahun = '2019' group by bulan order by bulan");
             
            if($query->num_rows() > 0){
                foreach($query->result() as $data){
                    $hasil[] = $data;
                }
                return $hasil;
        }
      }

    // END STATISTIK

    
    function gettppfull($kelas)
    {
        $q = $this->db->query("select tukin from ref_tukin_perkelas where kelas='$kelas'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->tukin; 
        }        
    }
    

    function get_realisasiabsensi($nip, $thn, $bln)
    {
        $q = $this->db->query("select realisasi from absensi where tahun = '".$thn."' and bulan = '".$bln."' and nip='".$nip."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->realisasi; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_realisasikinerja($nip, $thn, $bln)
    {
        $q = $this->db->query("select nilai_skp from kinerja_bulanan where tahun = '".$thn."' and bulan = '".$bln."' and nip='".$nip."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->nilai_skp; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_haktpp($nip)
    {
        $q = $this->db->query("select tpp from pegawai where nip='$nip'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->tpp; 
        }        
    }

    function getidtingpenterakhir($nip)
    {
        $q = $this->db->query("select fid_tingkat from riwayat_pendidikan where nip='$nip' and thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nip='$nip')");
        if ($q->num_rows()>0)
        {
          $row=$q->row();
          return $row->fid_tingkat; 
        }
    }

    // START UNTUK SEKOLAH
     public function datapnssekolah()
      {
        $q = $this->db->query("select p.nip, p.nama,
                                j.nama_jabfu, p.tmt_jabatan, u.id_unit_kerja
                                from pegawai as p, ref_jabfu as j, ref_unit_kerjav2 as u, ref_instansiv2 as i
                                where p.fid_jabfu = j.id_jabfu
                                and p.fid_unit_kerja = u.id_unit_kerja
                                and u.fid_instansi = i.id_instansi
                                and i.nama_instansi in ('SMA SEDERAJAT','SMP SEDERAJAT','SD SEDERAJAT','TK SEDERAJAT')");
        return $q;    
      }

    function cek_terpencil($idunker)
      {    
        $q = $this->db->query("select terpencil from ref_unit_kerjav2 where id_unit_kerja='".$idunker."'");    

        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->terpencil; 
        }
      }

    // END UNTUK SEKOLAH

    // START UNTUK IMPORT DATA VIA JSON
    public function tampilkinerja(){
        $q = $this->db->query("select * from kinerja_bulanan");
        return $q->result();
    }

    function input_kinerja_bulanan($data){
        $this->db->insert('kinerja_bulanan',$data);
        return true;
    }

    function update_kinerja_bulanan($where, $data)
    {
      $this->db->where($where);
      $this->db->update('kinerja_bulanan',$data);
      return true;
    }

    function cekada_kinerja_bulanan($nip, $tahun, $bulan)
    { 
      $q = $this->db->query("select nip from kinerja_bulanan where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");  
      return $q->num_rows();
    }

    function get_kinerja_bulanan_bynip($nip, $tahun, $bulan)
    { 
      $q = $this->db->query("select * from kinerja_bulanan where nip='".$nip."' and tahun='".$tahun."' and bulan='".$bulan."'");  
      return $q;
    }

    // END IMPORT DATA VIA JSON


}
 
/* End of file Mkinerja.php */
/* Location: ./application/models/Mkinerja.php */
