<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapi extends CI_Model {

    /* SERVICES API WITH AUTH */
    public function services_pegawai($nip) {
    return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, u.id_unit_kerja as unker_id, u.nama_unit_kerja, CONCAT_WS(' ', jst.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft) AS nama_jabatan, 
    CONCAT_WS(' ', jst.id_jabatan, jfu.id_jabfu, jft.id_jabft) AS kode_jabatan", false)
    ->from('pegawai AS p')
    ->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru')
    ->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'left')
    ->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'left')
    ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
    ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
    ->where('p.nip', $nip)
    ->get();
    // return $this->db->get_where('pegawai', ['nip' => $nip]);
    }

    public function services_pegawai_by_nip_nama($nipnama,$jenis,$niplogin) {
        if($jenis === 'PNS') {
            $this->db->select('p.nip as nip,CONCAT(p.gelar_depan,"",p.nama," ",p.gelar_belakang) as nama_asn, p.photo, u.nama_unit_kerja, 
            CONCAT_WS(" ", jst.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft) AS nama_jabatan', false);
            $this->db->from('pegawai as p');
            $this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja');
            $this->db->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'left');
            $this->db->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'left');
            $this->db->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left');
            /* Akses Role */
            $this->db->join('ref_instansi_userportal as i', 'u.fid_instansi_userportal = i.id_instansi');
            $this->db->join('userportal as up', 'u.fid_instansi_userportal = i.id_instansi');
            $this->db->where('up.nip', $niplogin);
            $this->db->where('u.aktif', 'Y');
            $this->db->like('i.nip_user', $niplogin);
            /* End Akses Role */
            $this->db->group_start();
                $this->db->like('p.nama', $nipnama);
                $this->db->or_like('p.nip', $nipnama);
            $this->db->group_end();
            $this->db->group_by('p.nip');
            return $this->db->get();
        } 

        if($jenis === 'PPPK') {
            $this->db->select('p.nipppk as nip,CONCAT(p.gelar_depan,"",p.nama," ",p.gelar_blk) as nama_asn, p.photo, u.nama_unit_kerja, jft.nama_jabft as nama_jabatan', false);
            $this->db->from('pppk as p');
            $this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja');
            $this->db->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left');
            /* Akses Role */
            $this->db->join('ref_instansi_userportal as i', 'u.fid_instansi_userportal = i.id_instansi');
            $this->db->join('userportal as up', 'u.fid_instansi_userportal = i.id_instansi');
            $this->db->where('up.nip', $niplogin);
            $this->db->where('u.aktif', 'Y');
            $this->db->like('i.nip_user', $niplogin);
            /* End Akses Role */
            $this->db->group_start();
                $this->db->like('p.nama', $nipnama);
                $this->db->or_like('p.nipppk', $nipnama);
            $this->db->group_end();
            return $this->db->get();
        }
    }

    public function services_pegawai_by_nip($nip) {
        return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, u.id_unit_kerja as unker_id, u.nama_unit_kerja, u.simgaji_id_skpd,u.simgaji_id_satker, CONCAT_WS(' ', jst.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft) AS nama_jabatan, 
        CONCAT_WS(' ', jst.id_jabatan, jfu.id_jabfu, jft.id_jabft) AS kode_jabatan,g.id_simgaji as kode_pangkat,e.id_simgaji as kode_eselon,
        sp.induk_bank,sp.norek,sp.kode_jenkel,sp.status_data,ag.nama_agama,ag.id_bkn as simgaji_id_agama, sp.update_at,sp.tmt_skmt,
        ssp.kode_statuspeg AS kode_status_pegawai,ssp.nama_statuspeg,sjp.kode_jenis AS kode_jenis_pegawai,sjp.nama_jenis,rsk.id_simgaji as kode_statkawin_simgaji,
        (SELECT kgb.gapok FROM riwayat_kgb AS kgb WHERE p.nip=kgb.nip ORDER BY kgb.gapok DESC LIMIT 1) AS gapok,
        (SELECT COUNT(rs.nama_sutri) FROM riwayat_sutri AS rs WHERE p.nip=rs.nip AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_sutri,
        (SELECT COUNT(ra.nama_anak) FROM riwayat_anak AS ra WHERE p.nip=ra.nip AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_anak,
        (SELECT rs.no_karisu FROM riwayat_sutri AS rs WHERE p.nip=rs.nip AND status_hidup = 'YA' AND rs.status_kawin = 'MENIKAH' ORDER BY rs.no_karisu DESC LIMIT 1) AS no_karis_karsu,
        (SELECT cp.tmt_cpns FROM cpnspns AS cp WHERE p.nip=cp.nip) AS tmt_capeg,
        (SELECT cp.no_karpeg FROM cpnspns AS cp WHERE p.nip=cp.nip) AS no_karpeg,
        (SELECT tp.nama_tingkat_pendidikan FROM riwayat_pendidikan AS rp LEFT JOIN ref_tingkat_pendidikan as tp ON rp.fid_tingkat=tp.id_tingkat_pendidikan WHERE p.nip=rp.nip ORDER BY rp.fid_tingkat DESC LIMIT 1) AS nama_tingkat_pendidikan,
        (SELECT cp.tgl_spmt AS tgl_spmt FROM cpnspns AS cp WHERE p.nip=cp.nip) AS tgl_spmt", false)
        ->from('pegawai as p')
        ->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru')
        ->join('ref_eselon AS e', 'p.fid_eselon=e.id_eselon')
        ->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'left')
        ->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'left')
        ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
        ->join('ref_agama as ag', 'p.fid_agama=ag.id_agama', 'left')
        ->join('ref_status_kawin as rsk', 'p.fid_status_kawin=rsk.id_status_kawin', 'left')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('simgaji_pegawai AS sp', 'p.nip=sp.nip', 'left')
        ->join('simgaji_jenis_pegawai AS sjp', 'sp.kode_jenis_pegawai=sjp.kode_jenis', 'left')
        ->join('simgaji_status_pegawai AS ssp', 'sp.kode_status_pegawai=ssp.kode_statuspeg', 'left')
        ->where('p.nip', $nip)
        ->get();
    }

    public function services_pppk_by_nipppk($nipppk) {
        return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, g.id_simgaji as simgaji_id_pangkat, u.id_unit_kerja as unker_id, u.nama_unit_kerja, u.simgaji_id_skpd,u.simgaji_id_satker,ssp.nama_statuspeg,
        jft.nama_jabft AS nama_jabatan, p.gaji_pokok,ag.nama_agama,ag.id_bkn as simgaji_id_agama,tp.nama_tingkat_pendidikan,rsk.id_simgaji as simgaji_id_status_kawin,
        sp.kode_statuspeg,sp.status_data,sp.created_at as status_data_add,sp.created_by as status_data_add_by, sp.update_at as status_data_update,sp.update_by as status_data_update_by,
        (SELECT COUNT(rs.nama_sutri) FROM riwayat_sutri_pppk AS rs WHERE p.nipppk=rs.nipppk AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_sutri,
        (SELECT COUNT(ra.nama_anak) FROM riwayat_anak_pppk AS ra WHERE p.nipppk=ra.nipppk AND status_hidup = 'YA' AND tanggungan = 'YA') AS jumlah_anak", false)
        ->from('pppk as p')
        ->join('ref_golru_pppk AS g', 'p.fid_golru_pppk=g.id_golru')
        ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
        ->join('ref_agama as ag', 'p.fid_agama=ag.id_agama', 'left')
        ->join('ref_tingkat_pendidikan as tp', 'p.fid_tingkat_pendidikan=tp.id_tingkat_pendidikan', 'left')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_status_kawin as rsk', 'p.fid_status_kawin=rsk.id_status_kawin', 'left')
        ->join('simgaji_pppk AS sp', 'p.nipppk=sp.nipppk', 'left')
        ->join('simgaji_status_pegawai AS ssp', 'sp.kode_statuspeg=ssp.kode_statuspeg', 'left')
        ->where('p.nipppk', $nipppk)
        ->get();
    }

    public function services_pegawai_by_unker($uid) {
        return $this->db->select("p.*, g.nama_golru, g.nama_pangkat, u.id_unit_kerja as unker_id, u.nama_unit_kerja, 
        CONCAT_WS(' ', jst.nama_jabatan, jfu.nama_jabfu, jft.nama_jabft) AS nama_jabatan, 
        CONCAT_WS(' ', jst.id_jabatan, jfu.id_jabfu, jft.id_jabft) AS kode_jabatan,sp.status_data,
        (SELECT is_sync_simgaji FROM tppng as tpp LEFT JOIN tppng_periode AS tp ON tpp.fid_periode=tp.id WHERE p.nip=tpp.nip AND tp.status = 'OPEN' ORDER BY tp.id DESC LIMIT 1) AS tpp_sync,
        (SELECT is_sync_simgaji FROM riwayat_kgb as kgb WHERE p.nip=kgb.nip ORDER BY kgb.gapok DESC LIMIT 1) AS kgb_sync,
        (SELECT is_sync_simgaji FROM riwayat_pekerjaan as kp WHERE p.nip=kp.nip ORDER BY kp.id DESC LIMIT 1) AS pangkat_sync", false)
        ->from('pegawai AS p')
        ->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru')
        ->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'left')
        ->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'left')
        ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'left')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('simgaji_pegawai AS sp', 'p.nip=sp.nip', 'left')
        ->where('u.id_unit_kerja', $uid)
        ->order_by('p.fid_golru_skr', 'desc')
        ->order_by('p.tmt_golru_skr', 'desc')
        ->get();
    }

    public function services_pppk_by_unker($uid) {
        return $this->db->select("p.*, g.nama_golru, jft.nama_jabft, sp.status_data,
        (SELECT is_sync_simgaji FROM tppng as tpp LEFT JOIN tppng_periode AS tp ON tpp.fid_periode=tp.id WHERE p.nipppk=tpp.nip AND tp.status = 'OPEN' ORDER BY tp.id DESC LIMIT 1) AS tpp_sync,
        (SELECT is_sync_simgaji FROM riwayat_kgb_pppk as kgb WHERE p.nipppk=kgb.nipppk ORDER BY kgb.gapok DESC LIMIT 1) AS kgb_sync", false)
        ->from('pppk as p')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_golru_pppk as g', 'p.fid_golru_pppk=g.id_golru')
        ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft')
        ->join('simgaji_pppk AS sp', 'p.nipppk=sp.nipppk', 'left')
        ->where('u.id_unit_kerja', $uid)
        ->order_by('p.fid_golru_pppk', 'desc')
        ->order_by('p.tmt_golru_pppk')
        ->get();
    }

    // Services TPP
    public function getTppByNip($nip) {
        return $this->db->select('p.gelar_depan,p.nama,p.gelar_belakang,tpp.id,tpp.nip,tpp.jabatan,u.nama_unit_kerja,tpp.tpp_diterima,tpp.tahun,tpp.bulan,tpp.fid_status,tpp.statuspeg,tpp.catatan,
        tpp.basic_bk,tpp.basic_pk,tpp.basic_kk,tpp.basic_tb,tpp.basic_kp,tpp.jml_pph,tpp.iwp_gaji,tpp.jml_iwp,tpp.jml_bpjs,sp.status_data AS is_peremajaan,
        u.simgaji_id_skpd,u.simgaji_id_satker,tpp.is_sync_simgaji', false)
        ->from('tppng as tpp')
        ->join('tppng_periode as tp', 'tpp.fid_periode=tp.id')
        ->join('pegawai as p', 'tpp.nip=p.nip')
        ->join('simgaji_pegawai AS sp', 'p.nip=sp.nip', 'left')
        ->join('ref_unit_kerjav2 AS u', 'tpp.fid_unker=u.id_unit_kerja')
        ->where('tpp.nip', $nip)
        ->where('tp.status', 'OPEN')
        ->order_by('tpp.id,tp.id', 'desc')
        ->get();
    }

    public function getTppByNipppk($nipppk) {
        return $this->db->select('p.gelar_depan,p.nama,p.gelar_blk,tpp.id,tpp.nip,tpp.jabatan,tpp.tpp_diterima,tpp.tahun,tpp.bulan,tpp.fid_status,tpp.statuspeg,tpp.catatan,
        tpp.basic_bk,tpp.basic_pk,tpp.basic_kk,tpp.basic_tb,tpp.basic_kp,tpp.jml_pph,tpp.iwp_gaji,tpp.jml_iwp,tpp.jml_bpjs,sp.status_data AS is_peremajaan,
        u.simgaji_id_skpd,u.simgaji_id_satker,tpp.is_sync_simgaji', false)
        ->from('tppng as tpp')
        ->join('tppng_periode as tp', 'tpp.fid_periode=tp.id')
        ->join('pppk as p', 'tpp.nip=p.nipppk')
        ->join('simgaji_pppk AS sp', 'p.nipppk=sp.nipppk', 'left')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->where('tpp.nip', $nipppk)
        ->where('tp.status', 'OPEN')
        ->order_by('tpp.id,tp.id', 'desc')
        ->get();
    }

    // Service Riwyat Pangkat
    public function getRiwayatPangkatByNip($nip) {
        $this->db->select('p.nip_lama,p.nip,p.nama,p.gelar_depan,p.gelar_belakang,p.no_npwp,p.whatsapp,
        rp.id,rp.uraian,rp.gapok,rp.tmt,rp.mkgol_thn,rp.mkgol_bln,rp.pejabat_sk,rp.no_sk,rp.tgl_sk,rp.berkas,rp.created_at,rp.created_by,rp.is_sync_simgaji,
        rp.updated_at,rp.updated_by,rp.fid_golru,g.id_simgaji,g.nama_pangkat,g.nama_golru,e.id_eselon,e.nama_eselon,e.id_simgaji AS id_eselon_simgaji,
        u.nama_unit_kerja,u.simgaji_id_skpd,u.simgaji_id_satker,
        CONCAT_WS(" ",rj.nama_jabatan,fu.nama_jabfu,ft.nama_jabft) AS jabatan_sekarang,
        ssp.kode_statuspeg,ssp.nama_statuspeg,sjp.kode_jenis,sjp.nama_jenis,sp.status_data AS is_peremajaan', false);
        $this->db->from('riwayat_pekerjaan as rp');
        $this->db->join('pegawai as p', 'rp.nip=p.nip', 'left');
        $this->db->join('ref_golru as g', 'rp.fid_golru=g.id_golru', 'left');
        $this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
        $this->db->join('ref_eselon as e', 'p.fid_eselon=e.id_eselon','left');
        $this->db->join('simgaji_pegawai AS sp', 'rp.nip=sp.nip', 'left');
        $this->db->join('simgaji_jenis_pegawai AS sjp', 'sp.kode_jenis_pegawai=sjp.kode_jenis', 'left');
        $this->db->join('simgaji_status_pegawai AS ssp', 'sp.kode_status_pegawai=ssp.kode_statuspeg', 'left');
        $this->db->join('ref_jabstruk AS rj', 'p.fid_jabatan = rj.id_jabatan', 'left');
        $this->db->join('ref_jabfu AS fu', 'p.fid_jabfu = fu.id_jabfu', 'left');
        $this->db->join('ref_jabft AS ft', 'p.fid_jabft = ft.id_jabft', 'left');
        $this->db->where('rp.nip', $nip);
        // $this->db->where('rp.uraian', 'KENAIKAN PANGKAT');
        $this->db->order_by('rp.fid_golru', 'desc');
        $this->db->order_by('rp.id', 'desc');
        $this->db->limit(1);
        return $this->db->get();
    }

    // Services Riwayat KGB
    public function getKgb($nip) {
        $this->db->select('p.nip_lama,k.nip,p.nama,p.gelar_depan,p.gelar_belakang,
        k.id,k.gapok, k.mk_thn, k.mk_bln, k.tmt, k.no_sk, k.tgl_sk, k.pejabat_sk,g.id_simgaji, k.fid_golru,ssp.kode_statuspeg,ssp.nama_statuspeg,sjp.kode_jenis,sjp.nama_jenis,
        g.nama_golru,g.nama_pangkat,kgb.tmt_gaji_berikutnya,p.no_npwp,p.whatsapp, CONCAT_WS(" ",rj.nama_jabatan,fu.nama_jabfu,ft.nama_jabft) AS jabatan_sekarang,
        k.created_at,k.created_by,k.berkas,e.id_eselon,e.nama_eselon,e.id_simgaji AS id_eselon_simgaji,u.nama_unit_kerja,u.simgaji_id_skpd,u.simgaji_id_satker, sp.status_data AS is_peremajaan', false);
        $this->db->from('riwayat_kgb as k');
        $this->db->join('kgb', 'k.nip=kgb.nip', 'left');
        $this->db->join('pegawai as p', 'k.nip=p.nip', 'left');
        $this->db->join('ref_golru as g', 'k.fid_golru=g.id_golru', 'left');
        $this->db->join('simgaji_pegawai AS sp', 'k.nip=sp.nip', 'left');
        $this->db->join('simgaji_jenis_pegawai AS sjp', 'sp.kode_jenis_pegawai=sjp.kode_jenis', 'left');
        $this->db->join('simgaji_status_pegawai AS ssp', 'sp.kode_status_pegawai=ssp.kode_statuspeg', 'left');
        $this->db->join('ref_eselon as e', 'p.fid_eselon=e.id_eselon','left');
        $this->db->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left');
        $this->db->join('ref_jabstruk AS rj', 'p.fid_jabatan = rj.id_jabatan', 'left');
        $this->db->join('ref_jabfu AS fu', 'p.fid_jabfu = fu.id_jabfu', 'left');
        $this->db->join('ref_jabft AS ft', 'p.fid_jabft = ft.id_jabft', 'left');
        $this->db->where('k.nip', $nip);
        $this->db->order_by('k.gapok,kgb.gapok_baru', 'desc');
        return $this->db->get();
    }

    public function getKGBP3K($nip) {
        $this->db->select('k.*, p.nama, p.gelar_depan, p.gelar_blk,p.no_npwp,p.no_handphone,ft.nama_jabft,u.id_unit_kerja,p.kategori,sjp.nama_jenis,sjp.kode_jenis,
        u.nama_unit_kerja, u.simgaji_id_skpd,u.simgaji_id_satker')
        ->from('riwayat_kgb_pppk AS k')
        ->join('ppppk AS p', 'k.nipppk=p.nipppk', 'left')
        ->join('simgaji_pegawai_pppk AS sp', 'k.nipppk=sp.nipppk', 'left')
        ->join('simgaji_jenis_pegawai AS sjp', 'sp.kategori=sjp.kode_jenis', 'left')
        ->join('ref_jabft AS ft', 'p.fid_jabft = ft.id_jabft', 'left')
        ->join('ref_unit_kerjav2 as u', 'p.fid_unit_kerja=u.id_unit_kerja','left')
        ->where('k.nipppk', $nip)
        ->order_by('k.gapok', 'desc')
        ->get();
    }

    public function save($tbl, $data) {
        return $this->db->insert($tbl, $data);
    }

    public function update($tbl, $data, $whr) {
        $this->db->where($whr);
        return $this->db->update($tbl, $data);
    }
    public function getBerkasKgb($gapok) {
        $this->db->select('berkas');
        $this->db->from('riwayat_kgb');
        $this->db->where('gapok', $gapok);
        return $this->db->get();
    }

    public function getUnorListByRole($nip,$level) {
        if ($level == "ADMIN") { // khusus admin
            $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                    from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                    WHERE
                    u.fid_instansi_userportal = i.id_instansi
                    and up.nip = '$nip'
                    and i.nip_user like '%$nip%'
            and u.aktif = 'Y'
                    order by u.id_unit_kerja";
        } else {
                $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                    from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                    WHERE
                    u.fid_instansi_userportal = i.id_instansi
                    and up.nip = '$nip'
                    and i.nip_user like '%$nip%'
            and u.aktif = 'Y'
            order by u.id_unit_kerja";
            //and nama_unit_kerja not like '-%'
        }
        return $this->db->query($sql);
    }

    

    // Services ePensiun
    public function cekfile($nip, $jns) {
        $this->db->select('file');
        $this->db->from('riwayat_takah');
        $this->db->where('nip', $nip);
        $this->db->where('fid_jenis_takah', $jns);
        return $this->db->get();
    }

    public function cekpersonal($nip) {
        $this->db->select('no_ktp,no_npwp');
        $this->db->from('pegawai');
        $this->db->where('nip', $nip);
        return $this->db->get()->row();
    }
    // End ePensiun

    public function services_unkerid($id) {
        return $this->db->get_where('ref_unit_kerjav2', ['id_unit_kerja' => $id]);
    }
    /* END SERVICES API WITH AUTH */

	public function get_agama()
    {
        $query = $this->db->get("ref_agama");
        return $query->result();
    }
    
    public function filternipnik($d) {
		$q_pns = $this->db->select('nip,nama,jenis_kelamin,tgl_lahir')->get_where('pegawai', ['nip' => $d])->result();
		$q_non = $this->db->select('nik,nama,jns_kelamin,tgl_lahir')->get_where('nonpns', ['nik' => $d])->result();
    	return [$q_non,$q_pns];
    }

    ####################################################################    
    public function get_pertanyaan($jenis)
    {
        $query = $this->db->select('*')
                          ->from('surveypertanyaan2018')
                          ->where('jenis', $jenis)
                          ->order_by('id','asc')
                          ->get();

        return $query->result();
    }
    public function cekSurvey($nip)
    {
        return $this->db->select('s.nip','p.nama')
                        ->from('surveyjawaban2018 AS s')
                        ->join('pegawai AS p', 's.nip = p.nip', 'left')
                        ->like('s.nip', $nip)
                        ->group_by('s.nip')
                        ->get();
    }
    public function jmlPertanyaan(){
        return $this->db->get('surveypertanyaan2018')->num_rows();
    }	
    public function jmlJenis($jenis){
        return $this->db->get_where('surveypertanyaan2018', ['jenis' => $jenis])->num_rows();
    }	
    public function insert_survey($tbl,$values)
    {
        return $this->db->insert_batch($tbl,$values);
    }

    ####################################################################
    public function hasil_survey($tbl)
    {
        $this->db->select('u.nip,u.username,r.nama_unit_kerja AS unker, s.tgl_survey, p.nip')
                 ->from($tbl.' AS u')
                 ->join('pegawai AS p', 'p.nip = u.nip')
                 ->join('ref_unit_kerjav2 AS r', 'p.fid_unit_kerja = r.id_unit_kerja')
                 ->join('surveyjawaban2018 AS s', 'p.nip = s.nip', 'left')
                 ->group_by('p.nip')
                 ->order_by('s.tgl_survey');
        return $this->db->get();
    }
    public function showPesan($tbl,$nip)
    {
        $this->db->select('t.*, u.username')
                 ->from($tbl.' AS t')
                 ->join('userportal AS u', 't.nip = u.nip')
                 ->like('u.nip', $nip)
                // ->where_in('t.fid_pertanyaan', ['36','38']);
                ->where('t.fid_pertanyaan', '38');
        return $this->db->get()->result();
    }
    public function jmlPengisi($tbl)
    {
        return $this->db->query('SELECT p.nip FROM `surveyjawaban2018` GROUP BY nip')->num_rows();
    }
    public function resetSurvey($tbl,$nip)
    {
        $this->db->like('nip',$nip);
        $this->db->delete($tbl);
    }
    public function totalPengguna($tbl)
    {
        return $this->db->get($tbl)->num_rows();
    }
    ####################################################################
    public function ChartBarLabel($tbl,$jenis)
    {
        return $this->db->select('pertanyaan')->get_where($tbl,['jenis' => $jenis])->result();
    }
    public function CountJawab($tbl) {
        return $this->db->select('jawaban, COUNT(*) AS jmlData')->get($tbl)->result();
    }
    ####################################################################
    public function search_pegawai($nip,$nama) { 
        $this->db->select('nama, nip')
                 ->from('pegawai')
                 ->like('nip', $nip)
                 ->or_like('nama', $nama);
        return $this->db->get();
    }
    ####################################################################
    function filternipnama($tbl, $nip, $nama) { 
			$this->db->select('p.nip, p.nama');
			$this->db->from($tbl.' as p');
			$this->db->like('p.nip', $nip);
			$this->db->or_like('p.nama', $nama);
			$q = $this->db->get();
	   	return $q;
	  }
    public function jmlpns()
	  {
	    $q = $this->db->query("select nip from pegawai");
	    return $q->num_rows();
	  }
	  
	  public function jmlasn()
	  {
	    $a = $this->db->query("select nip from pegawai");
	    $b = $this->db->query("select nik from nonpns");
	    return $a->num_rows() + $b->num_rows();
	  }
	  
	  
	  public function jmlnonpns()
	  {
	    $q = $this->db->query("select nik from nonpns");
	    return $q->num_rows();
	  }
	  
	  public function jmlpensiun($tahun)
	  {
	    $q = $this->db->query("select nip from pensiun_detail where tmt_pensiun like '$tahun%'");
	    return $q->num_rows();
	  }

		public function get_profile_pegawai($nip) {
			$this->db->select('*');
			$this->db->from('pegawai');
			$this->db->where('nip', $nip);
			$q = $this->db->get();
			return $q;
		}

    #================================================================#
    # KHUSUS UNTUK CONTROLLER API
    public function detail_pns($nip) {
    	$query = $this->db->query("select p.nip, CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as nama, p.tmp_lahir, p.tgl_lahir, p.jenis_kelamin, sk.nama_status_kawin, ag.nama_agama, p.alamat, rl.nama_kelurahan, rk.nama_kecamatan, p.telepon, ns.nama_status_pegawai, p.fid_golru_skr, u.nama_unit_kerja, (select js.nama_jabatan from ref_jabstruk as js, pegawai as p where p.fid_jabatan=js.id_jabatan and p.nip='".$nip."') as jabstruk, (select ju.nama_jabfu from ref_jabfu as ju, pegawai as p where p.fid_jabfu=ju.id_jabfu and p.nip='".$nip."') as jabfu, (select jt.nama_jabft from ref_jabft as jt, pegawai as p where p.fid_jabft=jt.id_jabft and p.nip='".$nip."') as jabft, p.tmt_jabatan, g.nama_golru, p.tmt_golru_skr, CONCAT(tp.nama_tingkat_pendidikan,' - ',jp.nama_jurusan_pendidikan) as pendidikan, p.no_karpeg, p.no_ktp, p.no_npwp from pegawai as p, ref_status_pegawai as ns, ref_status_kawin as sk, ref_kelurahan as rl, ref_kecamatan as rk, ref_agama as ag, ref_golru as g, ref_tingkat_pendidikan as tp,ref_jurusan_pendidikan as jp, ref_unit_kerjav2 as u where p.fid_golru_skr = g.id_golru and p.fid_status_pegawai = ns.id_status_pegawai and p.fid_status_kawin = sk.id_status_kawin and p.fid_agama = ag.id_agama AND p.`fid_unit_kerja` = u.id_unit_kerja and p.`fid_tingkat_pendidikan` = tp.`id_tingkat_pendidikan` and p.`fid_jurusan_pendidikan` = jp.`id_jurusan_pendidikan` and p.fid_alamat_kelurahan = rl.id_kelurahan and rl.fid_kecamatan = rk.id_kecamatan and p.nip='".$nip."'");

        //$query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;    
        }
    }	

    function pnsperunker($idunker) {
        $query = $this->db->query("select p.nip, CONCAT(p.gelar_depan,' ',p.nama,' ',p.gelar_belakang) as nama, p.tmp_lahir, p.tgl_lahir, 
p.jenis_kelamin, ns.nama_status_pegawai, u.nama_unit_kerja,
p.tmt_jabatan, p.fid_golru_skr, g.nama_golru, p.tmt_golru_skr, 
CONCAT(tp.nama_tingkat_pendidikan,' - ',jp.nama_jurusan_pendidikan) as pendidikan, p.tahun_lulus 
from pegawai as p, ref_status_pegawai as ns, ref_golru as g, ref_tingkat_pendidikan as tp,ref_jurusan_pendidikan as jp, ref_unit_kerjav2 as u 
where p.fid_golru_skr = g.id_golru 
and p.fid_status_pegawai = ns.id_status_pegawai 
AND p.`fid_unit_kerja` = u.id_unit_kerja 
and p.`fid_tingkat_pendidikan` = tp.`id_tingkat_pendidikan` 
and p.`fid_jurusan_pendidikan` = jp.`id_jurusan_pendidikan` 
and p.fid_unit_kerja='".$idunker."' order by p.fid_golru_skr desc");

        //$query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;    
        }
    }	

    # END CONTROLLER API
    #================================================================#
}
