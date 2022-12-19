<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Mkinerja_pppk extends CI_Model
{
	public function tampilusul_pppk($thn, $bln)
    {           
        $nip = $this->session->userdata('nip');
        if ($this->session->userdata('level') == "ADMIN") {
            $q = $this->db->query("select * from usul_tpp_pppk_pengantar WHERE tahun = '".$thn."' and bulan = '".$bln."' order by fid_unker");
        } else if ($this->session->userdata('nip') == "197703132007011011") { // KHUSUS UNTUK DINAS PENDIDIKAN (pak rahmadi)
	    $q = $this->db->query("select ut.* from usul_tpp_pppk_pengantar as ut
                where ut.tahun = '".$thn."'
                and ut.bulan = '".$bln."'
                and ut.fid_unker in ('631101','631102','631103','631104','631105','631106','631107','631108')
                and ut.status != 'ENTRI'");
	    /*
            $q = $this->db->query("select ut.* from usul_tpp_pppk_pengantar as ut, ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up WHERE
                ut.tahun = '".$thn."'
                and ut.bulan = '".$bln."'
                and (ut.fid_unker = u.id_unit_kerja OR ut.fid_unker in ('631101','631102','631103','631104','631105','631106','631107','631108'))
                and u.fid_instansi_userportal = i.id_instansi
                and u.unker_ekinerja != ''
                and up.nip = '".$nip."'
                and ut.status != 'ENTRI'
                and i.nip_user like '%".$nip."%' order by fid_unker");
	     */	
        } else if ($this->session->userdata('level') == "USER") {            
            $q = $this->db->query("select ut.* from usul_tpp_pppk_pengantar as ut, ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up WHERE
                ut.tahun = '".$thn."'
                and ut.bulan = '".$bln."'
                and ut.fid_unker = u.id_unit_kerja
                and u.fid_instansi_userportal = i.id_instansi
                and u.unker_ekinerja != ''
                and up.nip = '".$nip."'
                and i.nip_user like '%".$nip."%'
                and ut.status != 'ENTRI'");
        }
        return $q;
    }

    public function unkertelahusul_pppk($idunker, $tahun, $bulan)
    {
        $q = $this->db->query("select fid_unker from usul_tpp_pppk_pengantar where fid_unker='".$idunker."' and tahun='".$tahun."' and bulan='".$bulan."'");
        if ($q->num_rows() > 0)
        {
            return true; // data ditemukan / telah diusulkan
        }    
    }

    function get_haktpp_pppk($nipppk)
    {
        $q = $this->db->query("select tpp from pppk where nipppk='$nipppk'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->tpp; 
        }        
    }

    function input_kinerja_bulanan_pppk($data){
        $this->db->insert('kinerja_bulanan_pppk',$data);
        return true;
    }

    function update_kinerja_bulanan_pppk($where, $data)
    {
      $this->db->where($where);
      $this->db->update('kinerja_bulanan_pppk',$data);
      return true;
    }
    
    function cekada_kinerja_bulanan_pppk($nipppk, $tahun, $bulan)
    { 
      $q = $this->db->query("select nipppk from kinerja_bulanan_pppk where nipppk='".$nipppk."' and tahun='".$tahun."' and bulan='".$bulan."'");  
      return $q->num_rows();
    }

    function get_kinerja_bulanan_bynipppk($nipppk, $tahun, $bulan)
    { 
      $q = $this->db->query("select * from kinerja_bulanan_pppk where nipppk='".$nipppk."' and tahun='".$tahun."' and bulan='".$bulan."'");  
      return $q;
    }

    // Kalkulasi per periode

    // jumlah usulan per periode yang diambil dari tabel usul_tpp_pppk_pengantar, tabel ini akan terisi setelah dilakukan SIMPAN KALKULASI oleh operator
    function totusul_perperiode($thn, $bln)
    {
    	$q = $this->db->query("select sum(ut.totpns) as totpns from usul_tpp_pppk_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

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
    	$q = $this->db->query("select sum(ut.tottppkotor) as tpp_kotor from usul_tpp_pppk_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

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
    	$q = $this->db->query("select sum(ut.tottambahan) as jml_penambahan from usul_tpp_pppk_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

    	if ($q->num_rows() > 0)
    	{
    		$row=$q->row();
    		$hasil = $row->jml_penambahan;
    		return $hasil; 
    	}
    }

    public function tottppmurni_perperiode($thn, $bln)
    {
    	$q = $this->db->query("select sum(ut.tottpp_sebelumpajak) as tpp_murni from usul_tpp_pppk_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

    	if ($q->num_rows() > 0)
    	{
    		$row=$q->row();
    		$hasil = $row->tpp_murni;
    		return $hasil; 
    	}
    }

    public function totpajak_perperiode($thn, $bln)
    {
    	$q = $this->db->query("select sum(ut.totpajak) as pajak from usul_tpp_pppk_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

    	if ($q->num_rows() > 0)
    	{
    		$row=$q->row();
    		$hasil = $row->pajak;
    		return $hasil; 
    	}
    }

    public function tottppditerima_perperiode($thn, $bln)
    {
    	$q = $this->db->query("select sum(ut.tottpp_dibayar) as tpp_diterima from usul_tpp_pppk_pengantar as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

    	if ($q->num_rows() > 0)
    	{
    		$row=$q->row();
    		$hasil = $row->tpp_diterima;
    		return $hasil; 
    	}
    }

    public function cekrsudpkm_pppk($id_unker)
    {
    	$q = $this->db->query("select nama_unit_kerja from ref_unit_kerjav2 where id_unit_kerja = '$id_unker' and (nama_unit_kerja like 'RUMAH SAKIT%' OR nama_unit_kerja like 'PUSKESMAS%')");
    	if ($q->num_rows()>0)
    	{
    		return true;
    	} else{
    		return false;
    	}        
    }

    function getstatuspengantar_pppk($idunker, $thn, $bln)
    {
    	$sqlspk = $this->db->query("select status from usul_tpp_pppk_pengantar WHERE fid_unker = '".$idunker."' and tahun = '".$thn."' and bulan = '".$bln."'");
    	if ($sqlspk->num_rows()>0)
    	{
    		$row=$sqlspk->row();
    		return $row->status; 
    	}    
    }

    function input_unkertpp_pppk($data){
    	$this->db->insert('usul_tpp_pppk_pengantar',$data);
    	return true;
    }

    function getidpengantar_pppk($idunker, $thn, $bln)
    {
    	$sqlspk = $this->db->query("select id from usul_tpp_pppk_pengantar WHERE fid_unker = '".$idunker."' and tahun = '".$thn."' and bulan = '".$bln."'");
    	if ($sqlspk->num_rows()>0)
    	{
    		$row=$sqlspk->row();
    		return $row->id; 
    	}    
    }


    function getnamajabatan($nipppk)
    {
    	$q = $this->db->query("select fid_jabft from pppk where nipppk='$nipppk'");
    	if ($q->num_rows()>0)
    	{
    		$row=$q->row();
    		$nmjab = $this->mpegawai->namajab('3',$row->fid_jabft); 
    		return $nmjab;
    	}        
    	return false;
    }

    function get_realisasiabsensi($nipppk, $thn, $bln)
    {
    	$q = $this->db->query("select realisasi from absensi_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
    	if ($q->num_rows()>0)
    	{
    		$row=$q->row();
    		return $row->realisasi; 
    	} else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
    		return 0;
    	}
    }

    function getidtingpenterakhir($nipppk)
    {
    	$q = $this->db->query("select fid_tingkat from riwayat_pendidikan where nipppk='$nipppk' and thn_lulus IN (select max(thn_lulus) from riwayat_pendidikan where nipppk='$nipppk')");
    	if ($q->num_rows()>0)
    	{
    		$row=$q->row();
    		return $row->fid_tingkat; 
    	}
    }

    

  function getkeltugas_jft($nipppk)
  {
    $q = $this->db->query("select j.kelompok_tugas from ref_jabft as j, pppk as p where p.fid_jabft = j.id_jabft and p.nipppk='$nipppk'");
    if ($q->num_rows()>0)
    {
      $row=$q->row();      
      $kelompok_tugas = $row->kelompok_tugas;      
      return $kelompok_tugas;
    }        
  }

  function cektelahusul($nipppk, $tahun, $bulan)
      { 
        $q = $this->db->query("select nipppk from usul_tpp_pppk where nipppk='".$nipppk."' and tahun='".$tahun."' and bulan='".$bulan."'");  

        return $q->num_rows();
      }

    function input_usultpp($data){
        $this->db->insert('usul_tpp_pppk',$data);
        return true;
    }

    function update_usultpp($where, $data)
      {
        $this->db->where($where);
        $this->db->update('usul_tpp_pppk',$data);
        return true;
      }

    function get_kelasjabft($nipppk)
    {
        $q = $this->db->query("select j.kelas from ref_jabft as j, pppk as p where p.fid_jabft=j.id_jabft and p.nipppk='$nipppk'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->kelas; 
        }        
    }

    function get_hargajabft($nipppk)
    {
        $q = $this->db->query("select j.harga from ref_jabft as j, pppk as p where p.fid_jabft=j.id_jabft and p.nipppk='$nipppk'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->harga; 
        }        
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

     public function tampil_usultpp($idunker, $tahun, $bulan)
      {
        $q = $this->db->query("select * from usul_tpp_pppk where fid_unker='".$idunker."' and tahun='".$tahun."' and bulan='".$bulan."' order by kelas_jab desc, fid_golru desc");
        return $q;    
      }

      function get_realisasikinerja($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select nilai_skp from kinerja_bulanan_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->nilai_skp; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    public function getratakinerja($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.nilai_kinerja) as nilai from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul_wajibekin($idunker, $thn, $bln);
            if ($jml != 0) {
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    function getjumlahusul_wajibekin($idunker, $thn, $bln)
    {
        $q = $this->db->query("select ut.nipppk, ut.tahun, ut.bulan, ut.fid_unker from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.nilai_kinerja != 0 and ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    public function getrataabsensi($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.nilai_absensi) as nilai from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

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

    function getjumlahusul($idunker, $thn, $bln)
    {
        $q = $this->db->query("select ut.nipppk, ut.tahun, ut.bulan, ut.fid_unker from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    public function tottppkotor_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_tpp_kotor) as tpp_kotor from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_kotor;
            return $hasil; 
        }
    }

    public function tottambahan_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_penambahan) as jml_penambahan from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->jml_penambahan;
            return $hasil; 
        }
    }

    public function tottppmurni_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_tpp_murni) as tpp_murni from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_murni;
            return $hasil; 
        }
    }

    public function totpajak_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.jml_pajak) as pajak from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->pajak;
            return $hasil; 
        }
    }

    public function tottppditerima_perunkerperiode($idunker, $thn, $bln)
    {
        $q = $this->db->query("select sum(ut.tpp_diterima) as tpp_diterima from usul_tpp_pppk as ut, ref_unit_kerjav2 as u WHERE ut.fid_unker = u.id_unit_kerja and ut.fid_unker = '".$idunker."' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    function gettppfull($kelas)
    {
        $q = $this->db->query("select tukin from ref_tukin_perkelas where kelas='$kelas'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->tukin; 
        }        
    }

    function hapus_pengantar($where){
        $this->db->where($where);
        $this->db->delete('usul_tpp_pppk_pengantar');
        return true;
    }

    function hapus_usul($where){
        $this->db->where($where);
        $this->db->delete('usul_tpp_pppk');
        return true;
    }

    function update_pengantartpp($where, $data)
      {
        $this->db->where($where);
        $this->db->update('usul_tpp_pppk_pengantar',$data);
        return true;
      }

    function getqrcode($idunker, $thn, $bln)
      {
        $sqlspk = $this->db->query("select qrcode from usul_tpp_pppk_pengantar WHERE fid_unker = '".$idunker."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->qrcode; 
        }    
      }

    public function tampil_usultpp_perpengantar($idpengantar, $tahun, $bulan)
    {
        $q = $this->db->query("select utp.fid_unker as 'fid_unker_pengantar', ut.* from usul_tpp_pppk as ut, usul_tpp_pppk_pengantar as utp, pppk as p where ut.fid_pengantar = utp.id and ut.nipppk = p.nipppk and ut.fid_pengantar='".$idpengantar."' and ut.tahun='".$tahun."' and ut.bulan='".$bulan."' order by ut.fid_unker, ut.kelas_jab desc, ut.fid_golru desc");
        return $q;    
    }

    function getjumlahusul_perpengantar($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select nipppk, tahun, bulan from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    public function datapppksekolah($kecamatan)
      {
        $q = $this->db->query("select p.*, u.id_unit_kerja from pppk as p, ref_unit_kerjav2 as u, ref_instansiv2 as i where p.tpp='YA' and p.fid_unit_kerja = u.id_unit_kerja and u.fid_instansi = i.id_instansi and u.kecamatan = '$kecamatan' and i.nama_instansi in ('SMP SEDERAJAT','SD SEDERAJAT','TK SEDERAJAT')");
        
        return $q;    
      }

    function getstatuspengantar_perid($idpengantar, $thn, $bln)
      {
        $sqlspk = $this->db->query("select status from usul_tpp_pppk_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->status; 
        }    
      }

    public function getratakinerja_perpengantar($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(nilai_kinerja) as nilai from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul_perpengantar_wajibekin($idpengantar, $thn, $bln);
            if ($jml != 0) {
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    function getjumlahusul_perpengantar_wajibekin($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select nipppk, tahun, bulan from usul_tpp_pppk WHERE nilai_kinerja != 0 and fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    public function getrataabsensi_perpengantar($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(nilai_absensi) as nilai from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

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

    public function tottppkotor_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_tpp_kotor) as tpp_kotor from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_kotor;
            return $hasil; 
        }
    }

    public function tottambahan_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_penambahan) as jml_penambahan from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->jml_penambahan;
            return $hasil; 
        }
    }

    public function tottppmurni_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_tpp_murni) as tpp_murni from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_murni;
            return $hasil; 
        }
    }

     public function totpajak_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_pajak) as pajak from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->pajak;
            return $hasil; 
        }
    }

    public function totiwp_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(jml_iuran_bpjs) as iwp from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->iwp;
            return $hasil;
        }
    }

    public function tottppditerima_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select sum(tpp_diterima) as tpp_diterima from usul_tpp_pppk WHERE fid_pengantar = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_diterima;
            return $hasil; 
        }
    }

    function getqrcodeperpengantar($idpengantar, $thn, $bln)
      {
        $sqlspk = $this->db->query("select qrcode from usul_tpp_pppk_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($sqlspk->num_rows()>0)
        {
          $row=$sqlspk->row();
          return $row->qrcode; 
        }    
      }

    // START STATISTIK
    public function getjmlrwyperbulan($tahun)
      {
        $query = $this->db->query("select bulan, sum(tpp_diterima) as 'jumlah' from usul_tpp_pppk where tahun = '".$tahun."' group by bulan order by bulan");
             
            if($query->num_rows() > 0){
                foreach($query->result() as $data){
                    $hasil[] = $data;
                }
                return $hasil;
        }
      }

    public function tottppmurni_perbulan($thn, $bln)
        {
            $q = $this->db->query("select sum(ut.jml_tpp_murni) as tpp_murni from usul_tpp_pppk as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

            if ($q->num_rows() > 0)
            {
                $row=$q->row();
                $hasil = $row->tpp_murni;
                return $hasil; 
            }
        }

    public function getjumlahusul_perperiode($thn, $bln)
    {
        $q = $this->db->query("select ut.nipppk, ut.tahun, ut.bulan from usul_tpp_pppk as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
          return $q->num_rows();
        }
    }

    public function getratakinerja_perbulan($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.nilai_kinerja) as nilai from usul_tpp_pppk as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjmlwajibekin($thn, $bln);
            if ($jml != 0) {
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    public function getrataabsensi_perbulan($thn, $bln)
    {
        $q = $this->db->query("select sum(ut.nilai_absensi) as nilai from usul_tpp_pppk as ut WHERE ut.tahun = '".$thn."' and ut.bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $nilai = $row->nilai;
            $jml = $this->getjumlahusul_perperiode($thn, $bln);
            if ($jml != 0) {
                $rata = $nilai / $jml;
            } else {
                $rata = 0;
            }
            return $rata; 
        }
    }

    public function getjmlwajibekin($thn, $bln)
    {
        // YANG TIDAK WAJIB EKINERJA HANYA LAH TENAGA JFT KESEHATAN DAN PENDIDIKAN, dan AJUDAN
        $qjmljft = $this->db->query("SELECT ut.nipppk, ut.jabatan FROM usul_tpp_pppk as ut, ref_jabft as jt WHERE ut.jabatan = jt.nama_jabft and tahun = '".$thn."' and bulan = '".$bln."' and jt.kelompok_tugas in ('KESEHATAN','PENDIDIKAN')");
             
            if($qjmljft->num_rows() > 0) {
                $jmljft = $qjmljft->num_rows();     
            } else {
		$jmljft = 0;
	    }
        
        // Jumlah Wajib ekinerja
        $jmlusul = $this->getjumlahusul_perperiode($thn, $bln);
        return $jmlusul - $jmljft;           
    }

    public function getjmlekinnol($thn, $bln)
    {
        $query = $this->db->query("SELECT ut.nipppk, ut.jabatan FROM usul_tpp_pppk as ut, pppk as p WHERE ut.nilai_kinerja = 0 and ut.jabatan != 'AJUDAN' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nipppk = ut.nipppk");
             
            if($query->num_rows() > 0) {
                $jmlnol = $query->num_rows();     
            } else {
		$jmlnol = 0;
	    }

        // Jumlah Wajib ekinerja
        $jmlusul = $this->getjumlahusul_perperiode($thn, $bln);
        $jmlwajibekin = $this->getjmlwajibekin($thn, $bln);
        $jmltdkwajibekin = $jmlusul - $jmlwajibekin;

        return $jmlnol - $jmltdkwajibekin;           
    }

    public function getjmlekinmin60($thn, $bln)
    {
        $query = $this->db->query("SELECT ut.nipppk, ut.jabatan FROM usul_tpp_pppk as ut WHERE nilai_kinerja > 0 and nilai_kinerja < 60 and tahun = '".$thn."' and bulan = '".$bln."'");
             
            if($query->num_rows() > 0) {
                return $query->num_rows();     
            }
    }

    public function getjmlekinatas92($thn, $bln)
    {
        $query = $this->db->query("SELECT ut.nipppk, ut.jabatan FROM usul_tpp_pppk as ut WHERE nilai_kinerja > 92 and tahun = '".$thn."' and bulan = '".$bln."'");
             
            if($query->num_rows() > 0) {
                return $query->num_rows();     
            }          
    }

    public function getekintertinggi($thn, $bln)
    {
        $q = $this->db->query("SELECT MAX(nilai_kinerja) as tertinggi FROM usul_tpp_pppk as ut WHERE tahun = '".$thn."' and bulan = '".$bln."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->tertinggi; 
        }         
    }

    public function getekinterendah($thn, $bln)
    {
        $q = $this->db->query("SELECT MIN(nilai_kinerja) as tertinggi FROM usul_tpp_pppk as ut WHERE nilai_kinerja != 0 and tahun = '".$thn."' and bulan = '".$bln."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->tertinggi; 
        }         
    }
    
    public function getjmlabsennol($thn, $bln)
    {
        $query = $this->db->query("SELECT ut.nipppk, ut.jabatan FROM usul_tpp_pppk as ut, pppk as p WHERE ut.nilai_absensi = 0 and ut.jabatan not like 'JF DOKTER SPESIALIS%' and ut.tahun = '".$thn."' and ut.bulan = '".$bln."' and p.nipppk = ut.nipppk");
             
            if($query->num_rows() > 0) {
                return $query->num_rows();     
            } 
    }

     public function getjmlabsenmin40($thn, $bln)
    {
        $query = $this->db->query("SELECT ut.nipppk, ut.jabatan FROM usul_tpp_pppk as ut WHERE nilai_absensi > 0 and nilai_absensi < 40 and tahun = '".$thn."' and bulan = '".$bln."'");
             
            if($query->num_rows() > 0) {
                return $query->num_rows();     
            } 
    }
    // END STATISTIK

    // UNTUK HITUNG PPH
    function get_gajibruto($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select gaji_bruto from riwayat_gaji_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->gaji_bruto; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_jmlpotongan($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select jml_potongan from riwayat_gaji_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->jml_potongan; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_pphgaji($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select pajak from riwayat_gaji_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->pajak; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_biayajab($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select biaya_jab from usul_tpp_pppk_pph where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->biaya_jab; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    public function get_tppbruto($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select jml_tpp_murni as tpp_murni from usul_tpp_pppk WHERE tahun='".$thn."' and bulan='".$bln."' and nipppk='".$nipppk."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->tpp_murni;
            return $hasil; 
        }
    }

    public function get_jnsptkp($nipppk)
    {
        $q = $this->db->query("select jp.jenis_ptkp from ref_ptkp as jp, pppk as p WHERE jp.id_ptkp=p.fid_status_ptkp and p.nipppk='".$nipppk."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->jenis_ptkp;
            return $hasil; 
        }
    }

    public function get_ptkp($jnsptkp)
    {
        $q = $this->db->query("select ptkp from ref_ptkp WHERE jenis_ptkp='".$jnsptkp."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->ptkp;
            return $hasil; 
        }
    }

    public function get_npwp($nipppk)
    {
        $q = $this->db->query("select no_npwp from pppk WHERE nipppk='".$nipppk."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->no_npwp;
            return $hasil; 
        }
    }

    function cekadapph($nipppk, $tahun, $bulan)
      { 
        $q = $this->db->query("select nipppk from usul_tpp_pppk_pph where nipppk='".$nipppk."' and tahun='".$tahun."' and bulan='".$bulan."'");  

        return $q->num_rows();
      }

    function input_pph($data){
        $this->db->insert('usul_tpp_pppk_pph',$data);
        return true;
    }

    function update_pph($where, $data)
      {
        $this->db->where($where);
        $this->db->update('usul_tpp_pppk_pph',$data);
        return true;
      }

    function get_iwpgaji($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select iwp_peg from riwayat_gaji_pppk where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->iwp_peg; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_iwpterhutang($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select iwp_terhutang from usul_tpp_pppk_pph where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->iwp_terhutang; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }

    function get_pphbulan($nipppk, $thn, $bln)
    {
        $q = $this->db->query("select pph_bulan from usul_tpp_pppk_pph where tahun = '".$thn."' and bulan = '".$bln."' and nipppk='".$nipppk."'");
        if ($q->num_rows()>0)
        {
            $row=$q->row();
            return $row->pph_bulan; 
        } else {
            // jika data absensi tidak ditemukan, set dengan nilai 0 NOL
            return 0;
        }
    }    
    // END HITUNG PPH


    function get_berhaktpp($idunker)
    { 
        $q = $this->db->query("select p.nipppk as nip, concat(p.gelar_depan, ' ', p.nama, ' ', p.gelar_blk) as nama, u.nama_unit_kerja, j.nama_jabft as jabatan, j.kelas
            from ref_jabft as j, pppk as p, ref_unit_kerjav2 as u
            where p.fid_unit_kerja = u.id_unit_kerja
            and p.tpp = 'YA'
            and p.fid_jabft = j.id_jabft
            and p.fid_unit_kerja = '".$idunker."'
            order by j.kelas desc");  
        return $q;
    }

    function get_berhaktpp_sekolah($kecamatan)
    { 
        $q = $this->db->query("select p.nipppk as nip, concat(p.gelar_depan, ' ', p.nama, ' ', p.gelar_blk) as nama, u.nama_unit_kerja, j.nama_jabft as jabatan, j.kelas
            from ref_jabft as j, pppk as p, ref_unit_kerjav2 as u, ref_instansiv2 as i
            where p.fid_unit_kerja = u.id_unit_kerja
            and p.tpp = 'YA'
            and p.fid_jabft = j.id_jabft
            and u.fid_instansi = i.id_instansi 
                and u.kecamatan = '".$kecamatan."'
                and i.nama_instansi in ('SMP SEDERAJAT','SD SEDERAJAT','TK SEDERAJAT')");  
        return $q;
    }

    public function getpetugasentry_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select entri_by from usul_tpp_pppk_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->entri_by;
            return $hasil;
        }
    }
  
    public function gettglentry_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select entri_at from usul_tpp_pppk_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->entri_at;
            return $hasil;
        }
    }
 
    public function getpetugasupdate_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select updated_by from usul_tpp_pppk_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->updated_by;
            return $hasil;
        }
    }

    public function gettglupdate_perpengantarperiode($idpengantar, $thn, $bln)
    {
        $q = $this->db->query("select updated_at from usul_tpp_pppk_pengantar WHERE id = '".$idpengantar."' and tahun = '".$thn."' and bulan = '".$bln."'");

        if ($q->num_rows() > 0)
        {
            $row=$q->row();
            $hasil = $row->updated_at;
            return $hasil;
        }
    }

    function cekadagaji($nipppk, $tahun, $bulan)
      {
        $q = $this->db->query("select nipppk from riwayat_gaji_pppk where nipppk='".$nipppk."' and tahun='".$tahun."' and bulan='".$bulan."'");

        return $q->num_rows();
      }

}
