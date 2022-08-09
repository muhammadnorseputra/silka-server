<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mkgb extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function tampilpengantar()
  {
  	$sess_nip = $this->session->userdata('nip');
    // tampilkan pengantar kgb dengan id_status 1:SKPD atau 2:CETAK 
    $q = $this->db->query("select kp.* from kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where kp.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and kp.fid_status in ('1','2') order by kp.tgl_pengantar desc");
    return $q;
  }  

  function getjmlpengantarskpd()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select kp.* from kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where kp.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and kp.fid_status in ('1','2')");
    return $q->num_rows();
  } 

  function getjmldetailpengantar($idpengantar)
  {
    $q = $this->db->query("select * from kgb where fid_pengantar='$idpengantar'");
    return $q->num_rows();
  }

  function getstatuspengantar($id)
  {
    $sqlspk = mysql_query("select nama_statuspengantarkgb from ref_statuspengantarkgb WHERE id_statuspengantarkgb='".$id."'");
    $nama_spk = mysql_result($sqlspk,0,'nama_statuspengantarkgb');       
    return $nama_spk;
  }

  function getstatuspengantar_byidpengantar($idpengantar)
  {
    $sqlspk = mysql_query("select spk.nama_statuspengantarkgb from ref_statuspengantarkgb as spk, kgb_pengantar as kp WHERE kp.id_pengantar='".$idpengantar."' and kp.fid_status = spk.id_statuspengantarkgb");
    $nama_spk = mysql_result($sqlspk,0,'nama_statuspengantarkgb');       
    return $nama_spk;
  }

  function input_pengantar($data)
  {
    $this->db->insert('kgb_pengantar',$data);
    return true;
  }

  function edit_pengantar($where, $data)
  {
    $this->db->where($where);
    $this->db->update('kgb_pengantar',$data);
    return true;
  }

  public function detailusul($id, $tgl)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select kp.* FROM kgb_pengantar as kp WHERE kp.id_pengantar='".$id."' and kp.tgl_pengantar='".$tgl."'");

    return $q;
  }  

  function getnopengantar($id)
  {
    $sqlnop = mysql_query("select no_pengantar from kgb_pengantar WHERE id_pengantar='".$id."'");
    $nopengantar = mysql_result($sqlnop,0,'no_pengantar');       
    return $nopengantar;
  }

  function gettglpengantar($id)
  {
    $sqltglp = mysql_query("select tgl_pengantar from kgb_pengantar WHERE id_pengantar='".$id."'");
    $tglpengantar = mysql_result($sqltglp,0,'tgl_pengantar');       
    return $tglpengantar;
  }

   public function detailpengantar($idpengantar)
  {    
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, k.gapok_lama, k.fid_golru_lama, k.tmt_gaji_lama, k.mk_thn_lama, k.mk_bln_lama, k.tgl_usul, k.fid_pengantar, k.fid_status from pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where k.nip = p.nip and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and k.fid_pengantar = kp.id_pengantar and k.fid_pengantar='$idpengantar' order by k.tmt_gaji_lama desc");
    return $q;
  }

  function getstatuskgb($id)
  {
    $sqlsk = mysql_query("select nama_statuskgb from ref_statuskgb WHERE id_statuskgb='".$id."'");
    $nama_sk = mysql_result($sqlsk,0,'nama_statuskgb');       
    return $nama_sk;
  }

  function hapus_pengantar($where){
    $this->db->where($where);
    $this->db->delete('kgb_pengantar');
    return true;
  }  

  function getdatagolru($nip)
  {
    $q = $this->db->query("select rp.fid_golru, rp.tmt, rp.gapok, rp.mkgol_thn, rp.mkgol_bln, rp.pejabat_sk, rp.no_sk, rp.tgl_sk from riwayat_pekerjaan as rp where rp.nip='$nip' and rp.fid_golru = (select max(fid_golru) from riwayat_pekerjaan where nip='$nip')");
    return $q;
  }

  function getdatacpns($nip)
  {
    $q = $this->db->query("select cp.fid_golru_cpns, cp.tmt_cpns, cp.gapok_cpns, cp.mkthn_cpns, cp.mkbln_cpns, cp.pejabat_sk_cpns, cp.no_sk_cpns, cp.tgl_sk_cpns from cpnspns as cp where cp.nip='$nip'");
    return $q;
  }

  function getdatakgbakhir($nip)
  {
    $q = $this->db->query("select rp.fid_golru, rp.tmt, rp.gapok, rp.mk_thn, rp.mk_bln, rp.pejabat_sk, rp.no_sk, rp.tgl_sk from riwayat_kgb as rp where rp.nip='$nip' and rp.tmt = (select max(tmt) from riwayat_kgb where nip='$nip')");
    return $q;
  }

  function cektelahusul($nip, $tahun)
  { 
    $q = $this->db->query("select fid_pengantar from kgb where nip='".$nip."' and fid_status not in ('8', '9', '10') and tgl_usul like '".$tahun."%'");  

    return $q->num_rows();
  }

  function getdatapernahusul($nip, $tahun)
  {       
    //$qgettgl = $this->db->query("select tgl_usul from kgb where nip='".$nip."' and fid_status not in ('8', '9', '10') and tgl_usul like '".$tahun."%'");
    $qgettgl = $this->db->query("select kp.no_pengantar, kp.tgl_pengantar, sk.nama_statuskgb from kgb k, kgb_pengantar as kp, ref_statuskgb as sk where k.fid_pengantar = kp.id_pengantar and k.fid_status = sk.id_statuskgb and k.nip='".$nip."' and k.fid_status not in ('8', '9', '10') and k.tgl_usul like '".$tahun."%'");

    if ($qgettgl->num_rows()>0)
    {
      $row=$qgettgl->row();
      $no_pengantar = $row->no_pengantar;
      $tgl_pengantar = $row->tgl_pengantar;
      $nama_statuskgb = $row->nama_statuskgb;
      return "<h5>Status usulan <span class='label label-success'>".$nama_statuskgb."</span></h5>No. ".$no_pengantar."<br/>Tgl. ".tgl_indo($tgl_pengantar);
      //return $tglusul;
    }
  }

  function input_usul($data)
  {
    $this->db->insert('kgb',$data);
    return true;
  }

  public function detailDataUsul($nip, $fidpengantar)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, k.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, kp.no_pengantar, kp.tgl_pengantar FROM pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE k.nip = p.nip and k.fid_pengantar = kp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and i.nip_user like '%$sess_nip%' and k.fid_pengantar='".$fidpengantar."' and k.nip='".$nip."'");

    return $q;
  }

  function hapus_usul($where)
  {
    $this->db->where($where);
    $this->db->delete('kgb');
    return true;
  }

  function edit_usul($where, $data)
  {
    $this->db->where($where);
    $this->db->update('kgb',$data);
    return true;
  }

  public function cetakpengantar($id, $tgl, $id_unker)
  {    
    // update untuk spesimen
    $q = $this->db->query("select p.nip, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, kp.fid_unit_kerja, kp.*, k.gapok_lama, k.tmt_gaji_lama, k.fid_golru_lama, k.mk_thn_lama, k.mk_bln_lama, rs.nip as 'nip_spesimen', rs.status, rs.jabatan_spesimen from kgb as k, pegawai as p, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_spesimen as rs where p.nip=k.nip and k.fid_pengantar=kp.id_pengantar and kp.fid_unit_kerja=u.id_unit_kerja and kp.id_pengantar='".$id."' and kp.tgl_pengantar='".$tgl."' and kp.fid_unit_kerja='".$id_unker."' and rs.fid_unit_kerja = u.id_unit_kerja");    

    return $q;    
  }

  public function tampilproses()
  {
    $q = $this->db->query("select kp.* from kgb_pengantar as kp where fid_status='3' order by kp.tgl_pengantar desc");
    return $q;
  }

  function getjmlpengantarbystatus($status)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select id_pengantar from kgb_pengantar where fid_status = '$status'");
    return $q->num_rows();
  }

  public function detailproses($idpengantar)
  {     
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, k.*, kp.fid_unit_kerja, kp.id_pengantar from pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u where k.nip = p.nip and p.fid_unit_kerja = u.id_unit_kerja and k.fid_pengantar = kp.id_pengantar and k.fid_pengantar='$idpengantar' and kp.fid_status = '3' order by k.tmt_gaji_lama");
    
    return $q;
  }

  function cek_selainsetujubtltms($id_pengatar)
  {    
    $q = $this->db->query("select k.* from kgb as k, kgb_pengantar as kp, ref_statuskgb as sk where k.fid_pengantar = kp.id_pengantar and kp.id_pengantar = '".$id_pengatar."' and k.fid_status=sk.id_statuskgb and sk.nama_statuskgb not in ('TMS','BTL','CETAKSK')");    

    $jml = $q->num_rows();
    if ($jml == 0) {
      return true; // true : data tidak ditemukan
    } else {
      return false;
    }
  }

  function getgaji($golru, $mkg)
  {
    $sqlgaji = mysql_query("select * from ref_gaji WHERE MKG='".$mkg."'");
    $gaji = mysql_result($sqlgaji,0,$golru);
    return $gaji;
  }

  public function cetaksk($nip, $fid_pengantar)
  {
    $q = $this->db->query("select p.nip, p.tgl_lahir, p.fid_golru_skr, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, p.fid_unit_kerja, e.nama_eselon, k.* from kgb as k, pegawai as p, ref_eselon as e where p.fid_eselon=e.id_eselon and p.nip=k.nip and k.fid_pengantar='".$fid_pengantar."' and k.nip='".$nip."'");    
    return $q;    
  }

  // dengan  paging
  public function tampilinbox($number, $offset)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, k.gapok_lama, k.mk_thn_lama, k.mk_bln_lama, k.tmt_gaji_lama, k.gapok_baru, k.mk_thn_baru, k.mk_bln_baru, k.tmt_gaji_baru, k.fid_pengantar, kp.tgl_pengantar, kp.no_pengantar, k.fid_status from pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where k.nip = p.nip and k.fid_pengantar = kp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and k.fid_status in ('3','4','5','6','7') and i.nip_user like '%$sess_nip%' order by p.nama, k.fid_status desc LIMIT $offset, $number");

    return $q;
  }

  public function jmltampilinbox()
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, p.gelar_depan, p.nama, p.gelar_belakang, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, k.gapok_lama, k.mk_thn_lama, k.mk_bln_lama, k.tmt_gaji_lama, k.gapok_baru, k.mk_thn_baru, k.mk_bln_baru, k.tmt_gaji_baru, k.fid_pengantar, kp.tgl_pengantar, kp.no_pengantar, k.fid_status from pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i where k.nip = p.nip and k.fid_pengantar = kp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and k.fid_status in ('3','4','5','6','7') and i.nip_user like '%$sess_nip%'");
   return $q->num_rows();
  }

  public function carirekap($idunker, $thn)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, k.fid_pengantar, k.fid_golru_lama, k.gapok_lama, k.mk_thn_lama, k.mk_bln_lama, k.tmt_gaji_lama, k.fid_status, k.tgl_proses FROM pegawai as p left join kgb as k on k.nip=p.nip and k.tgl_usul like '".$thn."%', ref_unit_kerjav2 as u WHERE p.fid_unit_kerja = u.id_unit_kerja and p.fid_unit_kerja = '".$idunker."' order by p.nip, p.fid_eselon");

    return $q;
  }

  function gettmtterakhir($nip)
  {
    $qgettmt = $this->db->query("select (select max(tmt) from riwayat_pekerjaan where nip='$nip') as 'tmtgolru', (select max(tmt_cpns) from cpnspns where nip='$nip') as 'tmtcpns', (select max(tmt) from riwayat_kgb where nip='$nip') as 'tmtkgb'");

    if ($qgettmt->num_rows()>0)
    {
      $row=$qgettmt->row();
      $tmtgolru = $row->tmtgolru;
      $tmtcpns = $row->tmtcpns;
      $tmtkgb = $row->tmtkgb;

      if (($tmtgolru>$tmtcpns) AND ($tmtgolru>$tmtkgb)) {
        return "SK KP";
      } else if (($tmtcpns>=$tmtgolru) AND ($tmtcpns>$tmtkgb)) {
        return "SK CPNS";
      } else if (($tmtkgb>$tmtgolru) AND ($tmtkgb>$tmtcpns)) {
        return "SK KGB";
      } else if (($tmtgolru>$tmtcpns) AND ($tmtgolru=$tmtkgb)) {
        return "SK KP";
      }
    }
  }

  function getgajiterakhir($nip, $ket) {
    if ($ket=='SK KP') {
     $q = $this->db->query("select tmt, fid_golru, gapok, mkgol_thn, mkgol_bln from riwayat_pekerjaan where nip='$nip' and tmt IN (select max(tmt) from riwayat_pekerjaan where nip='$nip')");
    } else if ($ket=='SK CPNS') {
     $q = $this->db->query("select tmt_cpns, fid_golru_cpns, gapok_cpns, mkthn_cpns, mkbln_cpns from cpnspns where nip='$nip' and tmt_cpns IN (select max(tmt_cpns) from cpnspns where nip='$nip')");
    } else if ($ket=='SK KGB') {
     $q = $this->db->query("select tmt, fid_golru, gapok, mk_thn, mk_bln from riwayat_kgb where nip='$nip' and tmt IN (select max(tmt) from riwayat_kgb where nip='$nip')");
    }

    return $q;

  }    

  function input_riwayatkgb($id_pengantar, $fid_status) {
    $q = $this->db->query("insert into riwayat_kgb(nip, fid_golru, gapok, mk_thn, mk_bln, tmt, pejabat_sk, no_sk, tgl_sk, created_at, created_by) select nip, fid_golru_baru, gapok_baru, mk_thn_baru, mk_bln_baru, tmt_gaji_baru, pejabat_sk, no_sk, tgl_sk, now(), 'by system' from kgb where fid_pengantar = '".$id_pengantar."' and fid_status='".$fid_status."'");

    return $q;
  }

  // utuk statistik
  public function getjmlprosesbystatusgraphkgb()
  {
    //$data = $this->db->query("select sc.nama_statuscuti, COUNT(c.nip) as jumlah from ref_statuscuti as sc, cuti_tunda as c where c.fid_status = sc.id_statuscuti and sc.nama_statuscuti in ('INBOXSKPD', 'CETAKUSUL', 'INBOXBKPPD', 'CETAKSK') group by sc.id_statuscuti");

    $data = $this->db->query("select nama_statuskgb from ref_statuskgb where nama_statuskgb in ('INBOXSKPD', 'CETAKUSUL', 'INBOXBKPPD', 'CETAKSK')");
    return $data->result();
  }

  public function gettahunrwykgb()
  {
    $q = $this->db->query("select substring(tmt,1,4) as 'tahun' from riwayat_kgb WHERE substring(tmt,1,4) >= '2018' GROUP BY substring(tmt,1,4)");
    return $q;    
  }

  public function getjmlrwyperbulan()
  {
    $query = $this->db->query("select MONTH(tmt), count(nip) as 'jumlah', count(nip) as 'jumlah1' from riwayat_kgb where tmt like '2022%' group by MONTH(tmt) order by MONTH(tmt)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }
  }

  function getjmlprosesbystatuskgb($status, $thn)
  {
    //$sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select nip from kgb where fid_status = '$status' and tgl_usul like '$thn%'");
    return $q->num_rows();
  }

  function getjmlrwybythnstatus($thn)
  {
    $q = $this->db->query("select * from riwayat_kgb where tmt like '$thn%'");
    
    return $q->num_rows();
  }

  // START KHUSUS ADMIN, Update Pengatar dan Usul KGB
  public function admin_tampilupdatepengantar()
  {    
    // tampilkan semua pengantar kgb dengan id_status 1:SKPD, 2:CETAK, 3:BKPPD 
    $q = $this->db->query("select kp.* from kgb_pengantar as kp, ref_unit_kerjav2 as u where kp.fid_unit_kerja = u.id_unit_kerja and kp.fid_status in ('1','2', '3') order by kp.fid_status, kp.tgl_pengantar");
    return $q;
  }

  function getjml_tampilupdatepengantar()
  {
    $q = $this->db->query("select kp.* from kgb_pengantar as kp, ref_unit_kerjav2 as u where kp.fid_unit_kerja = u.id_unit_kerja and kp.fid_status in ('1','2', '3')");
    return $q->num_rows();
  }

  public function admin_detailpengantar($idpengantar, $tglpengantar)
  {
        $q = $this->db->query("select * from kgb_pengantar where id_pengantar = '".$idpengantar."' and tgl_pengantar = '".$tglpengantar."'");
    return $q;
  }

  public function statuspengantar()
  {
    $q = $this->db->query("select * from ref_statuspengantarkgb");    
    return $q;    
  }

  public function cariupdateusul($nip)
  {
    $q = $this->db->query("select p.nip, p.nama, p.gelar_belakang, p.gelar_depan, k.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, kp.no_pengantar, kp.tgl_pengantar FROM pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i WHERE k.nip = p.nip and k.fid_pengantar = kp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi and k.nip='".$nip."' order by k.tmt_gaji_lama desc");

    return $q;
  }

  public function statuskgb()
  {
    $q = $this->db->query("select * from ref_statuskgb ORDER BY nama_statuskgb");    
    return $q;    
  }

  public function admin_detailusul($nip, $tmt, $id)
  {
    $sess_nip = $this->session->userdata('nip');
    $q = $this->db->query("select p.nip, k.*, p.fid_jnsjab, p.fid_jabatan, p.fid_jabfu, p.fid_jabft, u.nama_unit_kerja, kp.no_pengantar, kp.tgl_pengantar
        FROM pegawai as p, kgb as k, kgb_pengantar as kp, ref_unit_kerjav2 as u, ref_instansi_userportal as i
        WHERE k.nip = p.nip and k.fid_pengantar = kp.id_pengantar and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi_userportal = i.id_instansi
                and k.nip='".$nip."' and k.fid_pengantar = '".$id."' and k.tmt_gaji_lama = '".$tmt."' and i.nip_user like '%$sess_nip%'");

    return $q;
  }

  // END KHUSUS ADMIN, Update Pengatar dan Usul KGB
}
