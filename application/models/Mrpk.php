<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mrpk extends CI_Model {
    function nomperunker($id)
    {
        $this->db->select("p.*,rp.id AS id_rpk_penilaian,
        rp.nilai_average,rp.nilai_kompetensi_manajerial,rp.nilai_kompetensi_sosiokultural,rp.nilai_kompetensi_teknis,
        rp.lainnya,rp.rekomendasi_pengembangan,rp.status,jst.nama_jabatan,jfu.nama_jabfu,jft.nama_jabft,rsk.nama_status_kawin,
        ra.nama_agama, u.nama_unit_kerja, u.id_unit_kerja, CONCAT_WS(' ', jst.id_jabatan,jfu.id_jabfu,jft.id_jabft) AS jabatanid, g.nama_golru, g.nama_pangkat", false);
        $this->db->from("pegawai AS p");
        $this->db->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'LEFT');
        $this->db->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'LEFT');
        $this->db->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'LEFT');
        $this->db->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru');
        $this->db->join('ref_status_kawin AS rsk', 'p.fid_status_kawin=rsk.id_status_kawin', 'LEFT');
        $this->db->join('ref_agama AS ra', 'p.fid_agama=ra.id_agama', 'LEFT');
        $this->db->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja', 'LEFT');
        $this->db->join('rpk_penilaian AS rp', 'p.nip=rp.nip', 'LEFT');
        $this->db->where("p.fid_unit_kerja", $id);
        // $this->db->where_in("p.fid_eselon", ['0231','0232','0241','0242','0253','0254','0251','0255','0256']);
        $this->db->order_by("p.fid_eselon");
        $q = $this->db->get();
        return $q;
    }
    function rekap($unkerid)
    {
        $this->db->select("rpk.*,CONCAT('\'',rpk.nip) AS nip_asn,p.nama,p.gelar_depan,p.gelar_belakang,CONCAT(p.tmp_lahir,', ',p.tgl_lahir) AS ttl,
        rsk.nama_status_kawin, ra.nama_agama, p.alamat, u.nama_unit_kerja, rpk.rekam_jejak, rpk.nilai_kompetensi_manajerial,rpk.nilai_kompetensi_sosiokultural,rpk.nilai_kompetensi_teknis,
        CONCAT_WS(' ', jst.nama_jabatan,jfu.nama_jabfu,jft.nama_jabft) AS jabatan, g.nama_golru, g.nama_pangkat", false)
        ->from("rpk_penilaian AS rpk")
        ->join('pegawai AS p', 'rpk.nip=p.nip', 'left')
        ->join('ref_jabstruk AS jst', 'p.fid_jabatan=jst.id_jabatan', 'LEFT')
        ->join('ref_jabfu AS jfu', 'p.fid_jabfu=jfu.id_jabfu', 'LEFT')
        ->join('ref_jabft AS jft', 'p.fid_jabft=jft.id_jabft', 'LEFT')
        ->join('ref_golru AS g', 'p.fid_golru_skr=g.id_golru')
        ->join('ref_status_kawin AS rsk', 'p.fid_status_kawin=rsk.id_status_kawin', 'LEFT')
        ->join('ref_agama AS ra', 'p.fid_agama=ra.id_agama', 'LEFT')
        ->join('ref_unit_kerjav2 AS u', 'p.fid_unit_kerja=u.id_unit_kerja', 'LEFT')
        ->where("p.fid_unit_kerja", $unkerid)
        ->where('rpk.status', 'DONE')
        ->order_by("p.fid_eselon, p.fid_golru_skr desc, p.tmt_golru_skr, p.tmt_cpns, p.fid_tingkat_pendidikan desc, p.tahun_lulus, p.tgl_lahir asc");
        $q = $this->db->get();
        return $q;

    }
    public function rekap_pemetaan($unkerId) 
    {
        $this->db->select("rpj.*,CONCAT('\'',rpp.nip) AS nip_asn,rpp.nama_jabatan,rpp.unker,p.nama,p.gelar_depan,p.gelar_belakang", false)
        ->from('rpk_peta_jabatan AS rpj')
        ->join('rpk_penilaian AS rpp', 'rpj.fid_rpk_penilaian=rpp.id', 'left')
        ->join('pegawai AS p', 'rpp.nip=p.nip')
        ->where('rpp.unker_id', $unkerId)
        ->where('rpj.posisi_jabatan !=', 'null')
        ->where('rpj.kelas_jabatan !=', 'null');
        $q = $this->db->get();
        return $q;
    }
    public function rekap_instansi($unkerId)
    {
        $this->db->select("rpi.*,CONCAT('\'',rpp.nip) AS nip_asn,rpp.nama_jabatan,p.nama,p.gelar_depan,p.gelar_belakang,u.nama_unit_kerja",false)
        ->from('rpk_instansi AS rpi')
        ->join('rpk_penilaian AS rpp', 'rpi.fid_rpk_penilaian=rpp.id', 'left')
        ->join('pegawai AS p', 'rpp.nip=p.nip')
        ->join('ref_unit_kerjav2 AS u', 'rpi.rencana_penempatan=u.id_unit_kerja')
        ->where('rpp.unker_id', $unkerId)
        ->where('rpi.rekomendasi_jabatan !=', 'null')
        ->where('rpi.rencana_penempatan !=', 'null');
        $q = $this->db->get();
        return $q;
    }
    public function rekap_kompetensi($unkerId)
    {
        $this->db->select("pns.*,CONCAT('\'',rpp.nip) AS nip_asn,rpp.nilai_kompetensi_manajerial,rpp.nilai_kompetensi_sosiokultural,rpp.nilai_kompetensi_teknis,p.nama,p.gelar_depan,p.gelar_belakang,rpi.tahun_pelaksanaan_ke",false)
        ->from('rpk_pns AS pns')
        ->join('rpk_penilaian AS rpp', 'pns.fid_rpk_penilaian=rpp.id', 'left')
        ->join('rpk_instansi AS rpi', 'pns.fid_rpk_instansi=rpi.id', 'left')
        ->join('pegawai AS p', 'rpp.nip=p.nip')
        ->where('rpp.unker_id', $unkerId);
        // ->where('pns.syarat_nilai_kompetensi_manajerial !=', 'null')
        // ->where('pns.syarat_nilai_kompetensi_sosiokultural !=', 'null')
        // ->where('pns.syarat_nilai_kompetensi_teknis !=', 'null');
        $q = $this->db->get();
        return $q;
    }
    public function allunker()
    {
        $q = $this->db->query("select id_unit_kerja, nama_unit_kerja from ref_unit_kerjav2 
        where nama_unit_kerja not like '-%' 
        AND nama_unit_kerja not like 'SMP%'
        AND nama_unit_kerja not like 'TK%'
        AND nama_unit_kerja not like 'PAUD%'
        AND nama_unit_kerja not like 'KB%'
        AND nama_unit_kerja not like 'SPS%'
        AND nama_unit_kerja not like 'SD%'
        AND nama_unit_kerja not like 'TPA%'
        AND nama_unit_kerja not like 'RA%'
        AND nama_unit_kerja not like 'SEKOLAH%'
        AND nama_unit_kerja not like 'KOORDINATOR%'
        ");
        return $q;
    }
    function unker_name($id)
    {
        return $this->db->select('nama_unit_kerja')->from('ref_unit_kerjav2')->where('id_unit_kerja', $id)->get()->row()->nama_unit_kerja;
    }
    public function pendidikan_terakhir($nip) 
    {
        $q=$this->db->select('p.*,tp.nama_tingkat_pendidikan,jp.nama_jurusan_pendidikan')
        ->from('riwayat_pendidikan AS p')
        ->join('ref_tingkat_pendidikan AS tp', 'p.fid_tingkat=tp.id_tingkat_pendidikan')
        ->join('ref_jurusan_pendidikan AS jp', 'p.fid_jurusan=jp.id_jurusan_pendidikan')
        ->where('p.nip', $nip)
        ->order_by('fid_tingkat', 'desc')
        ->limit(1)
        ->get()->row();
        $pendidikan = $q->nama_tingkat_pendidikan." ".$q->nama_jurusan_pendidikan;
        return $pendidikan;
    }
    public function rekam_jejak_jabatan($nip) 
    {
        $q=$this->db->select('*')->from('riwayat_jabatan')->where('nip', $nip)->get();
        $jabatan=[];
        foreach($q->result() as $r => $v):
            $tmt_jabatan = $v->tmt_jabatan;
            $tmt_jabatan_pecah = explode("-",$tmt_jabatan);
            $tmt_jabatan_tahun = $tmt_jabatan_pecah[0];
            $nextRow = @$q->result()[$r+1];
            $nextID = @(int) $nextRow->id;
            $tmt_next = $this->rekam_jejak_get_tahun($nip,$nextID);
            if(!empty($tmt_next)) {
                $tmt = $tmt_next;
            } else {
                $tmt = 'SEKARANG';
            }
            $jabatan[] = $v->jabatan." ".$v->unit_kerja." (".$tmt_jabatan_tahun." - ".$tmt.")";
        endforeach;
        
        return $jabatan;
    }
    public function rekam_jejak_get_tahun($nip, $id)
    {
        $q = $this->db->select('tmt_jabatan')->from('riwayat_jabatan')->where('nip', $nip)->where('id', $id)->get()->row();
        $tmt = @$q->tmt_jabatan;
        $tmt_jabatan_pecah = explode('-', $tmt);
        $tahun = $tmt_jabatan_pecah[0];
        return $tahun;
    }
    public function riwayat_skp($nip,$tahun) {
        $q=$this->db->select('nilai_skp')->from('riwayat_skp')->where('nip', $nip)->where('tahun', $tahun)->get()->row();
        if(!empty($q)) {
            return $q->nilai_skp;
        }
        return "-";
    }
    public function riwayat_satyalencana($nip)
    {
        $q=$this->db->select('rt.*, jt.nama_jenis_tanhor')
        ->from('riwayat_tanhor as rt')
        ->join('ref_jenis_tanhor AS jt', 'rt.fid_jenis_tanhor=jt.id_jenis_tanhor')
        ->where('rt.nip', $nip)
        ->get();
        $tanhor=[];
        foreach($q->result() as $r):
            $tahun = $r->tahun;
            $tanhor[] = $r->nama_jenis_tanhor." (TAHUN ".$tahun.")";
        endforeach;
        
        return !empty($tanhor) ? $tanhor : '-';
    }
    public function riwayat_hukdis($nip)
    {
        $q=$this->db->select('rh.*, jh.nama_jenis_hukdis')
        ->from('riwayat_hukdis as rh')
        ->join('ref_jenis_hukdis AS jh', 'rh.fid_jenis_hukdis=jh.id_jenis_hukdis')
        ->where('rh.nip', $nip)
        ->get();
        $hukdis=[];
        foreach($q->result() as $r):
            $dec = $r->deskripsi;
            $hukdis[] = $r->nama_jenis_hukdis." (".$dec.")";
        endforeach;
        
        return !empty($hukdis) ? $hukdis : '-';
    }
    public function riwayat_inovasi($nip)
    {
        $q=$this->db->select('inovasi')
        ->from('petruk')
        ->where('nip', $nip)
        ->get();
        $inovasi=[];
        foreach($q->result() as $r):
            $inovasi[] = $r->inovasi;
        endforeach;
        
        return !empty($inovasi) ? $inovasi : '-';
    }
    public function riwayat_pip($nip)
    {
        $q=$this->db->select('nilai_pip, kategori_pip, tahun')
        ->from('riwayat_ipasn')
        ->where('nip', $nip)
        ->limit(1)
        ->order_by('id','desc')
        ->get();
        $pip=[];
        foreach($q->result() as $r):
            $pip[] = $r->tahun." - ".$r->kategori_pip." (".$r->nilai_pip.")";
        endforeach;
        
        return !empty($pip) ? $pip : '-';
    }
    public function ceknip($tbl, $whr)
    {
        $q = $this->db->get_where($tbl, $whr);
        return $q;
    }
    public function update_nilai($tbl, $data, $whr)
    {
        return $this->db->where($whr)->update($tbl, $data);
    }
    public function insert_nilai($tbl, $data)
    {
        return $this->db->insert($tbl, $data);
    }
    public function cek_rpk_peta_jabatan($id)
    {
        $q = $this->db->get_where('rpk_peta_jabatan', ['fid_rpk_penilaian' => $id]);
        return $q;
    }
    public function get_unit_kerja($tbl, $search = '') {
        $select = array('u.nama_unit_kerja','u.id_unit_kerja');
        $nip = $this->session->userdata('nip');
        if(isset($search)) {
            $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                            from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                            WHERE
                            u.fid_instansi_userportal = i.id_instansi
                            and up.nip = '$nip' 
                            and i.nip_user like '%$nip%'
                            and u.nama_unit_kerja NOT LIKE '-%'
                            AND nama_unit_kerja not like 'SMP%'
                            AND nama_unit_kerja not like 'TK%'
                            AND nama_unit_kerja not like 'PAUD%'
                            AND nama_unit_kerja not like 'KB%'
                            AND nama_unit_kerja not like 'SPS%'
                            AND nama_unit_kerja not like 'SD%'
                            AND nama_unit_kerja not like 'TPA%'
                            AND nama_unit_kerja not like 'RA%'
                            AND nama_unit_kerja not like 'SEKOLAH%'
                            AND nama_unit_kerja not like 'KOORDINATOR%'
                            and u.nama_unit_kerja like '%$search%' 
                            order by u.id_unit_kerja";
            $res = $this->db->query($sql);
        } else {
            $sql = "select u.nama_unit_kerja, u.id_unit_kerja
                            from ref_unit_kerjav2 as u, ref_instansi_userportal as i, userportal as up
                            WHERE
                            u.fid_instansi_userportal = i.id_instansi
                            and up.nip = '$nip'
                            and u.nama_unit_kerja NOT LIKE '-%'
                            AND nama_unit_kerja not like 'SMP%'
                            AND nama_unit_kerja not like 'TK%'
                            AND nama_unit_kerja not like 'PAUD%'
                            AND nama_unit_kerja not like 'KB%'
                            AND nama_unit_kerja not like 'SPS%'
                            AND nama_unit_kerja not like 'SD%'
                            AND nama_unit_kerja not like 'TPA%'
                            AND nama_unit_kerja not like 'RA%'
                            AND nama_unit_kerja not like 'SEKOLAH%'
                            AND nama_unit_kerja not like 'KOORDINATOR%'
                            and i.nip_user like '%$nip%' 
                            order by u.id_unit_kerja";
            $res = $this->db->query($sql);
        }
    
        return $res;
    }
    // PAGE PETAJABATAN
    public $table_petajabatan = 'rpk_peta_jabatan AS pj';
    public $select_colums_petajabatan = array('pj.*','rp.nip','rp.unker', 'rp.nama_jabatan','rp.rekomendasi_pengembangan','p.nama','p.gelar_depan','p.gelar_belakang');
    public $order_colums_petajabatan = array(null, 'pj.id', null, null, null, null, null, null, null, null);
    public $column_search_petajabatan = array('rp.nip','p.nama');

    public function datatable_petajabatan($unkerid) {
            $this->db->select($this->select_colums_petajabatan);
            $this->db->from($this->table_petajabatan);
            $this->db->join('rpk_penilaian AS rp', 'pj.fid_rpk_penilaian=rp.id','left');
            $this->db->join('pegawai AS p', 'rp.nip=p.nip','left');
            if(!empty($unkerid)){
                $this->db->where('p.fid_unit_kerja', $unkerid);
            }
            $i=0;
            foreach ($this->column_search_petajabatan as $item) { // loop column 
                    if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                    if ($i === 0) { // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if (count($this->column_search_petajabatan) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
            
            if(isset($_POST["order"])){
                $this->db->order_by($this->order_colums_petajabatan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by("pj.id", "desc");
            }
    }

    public function fetch_datatable_petajabatan($unkerid) {
        $this->datatable_petajabatan($unkerid);
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_petajabatan($unkerid) {
        $this->datatable_petajabatan($unkerid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data_petajabatan($unkerid) {
        
        $this->db->select("pj.*");
        $this->db->from($this->table_petajabatan);
        $this->db->join('rpk_penilaian AS rp', 'pj.fid_rpk_penilaian=rp.id','left');
        $this->db->join('pegawai AS p', 'rp.nip=p.nip','left');
        if(!empty($unkerid)){
            $this->db->where('p.fid_unit_kerja', $unkerid);
        }
        $query = $this->db->count_all_results();
        return $query;
    }
    public function delete_petajabatan($tbl, $id)
    {
        return $this->db->delete($tbl, $id);
    }
    public function update($tbl, $data, $whr)
    {
        return $this->db->where($whr)->update($tbl, $data);
    }
    public function getNilai($nip) {
        return $this->db->select('nilai_average')->get_where('rpk_penilaian', ['nip' => $nip]);
    }
    public function isRekomendasi($nilai) {
        if($nilai >= '91.00') {
            $rekomendasi = 'Karir';
        } else {
            $rekomendasi = 'Kompetensi';
        }
        return $rekomendasi;
    }
    public function insert($tbl, $data)
    {
        return $this->db->insert($tbl, $data);
    }
    public function isPetajabatan($id)
    {
        return $this->db->select('proyeksi_jabatan, deskripsi_posisi_jabatan, fid_rpk_penilaian')->get_where('rpk_peta_jabatan', ['id' => $id]);
    }
    public function isRpkInstansi($id)
    {
        return $this->db->get_where('rpk_instansi', ['id' => $id]);
    }
    public function isRpkPns($id)
    {
        return $this->db->get_where('rpk_pns', ['id' => $id]);
    }
    public function isRpkPenilaian($id)
    {
        return $this->db->get_where('rpk_penilaian', ['id' => $id]);
    }
    public function delete_instansi($tbl, $id)
    {
        return $this->db->delete($tbl, $id);
    }
    public function cek_rpk_instansi($id)
    {
        $q = $this->db->get_where('rpk_instansi', ['fid_rpk_peta_jabatan' => $id]);
        return $q;
    }
    public function cek_rpk_pns($id)
    {
        $q = $this->db->get_where('rpk_pns', ['fid_rpk_instansi' => $id]);
        return $q;
    }

    // PAGE RENCANA PENGEMBANGAN KARIR
    public $table_instansi = 'rpk_instansi AS pi';
    public $select_colums_instansi = array('pi.*','rp.nip','rp.nama_jabatan','p.nama','p.gelar_depan','p.gelar_belakang','u.nama_unit_kerja');
    public $order_colums_instansi = array(NULL, 'pi.id', null, null, null, null, null, null, null, null, null, null, null);
    public $column_search_instansi = array('rp.nip','p.nama');

    public function datatable_instansi($unkerid='') {
        $this->db->select($this->select_colums_instansi);
        $this->db->from($this->table_instansi);
        $this->db->join('rpk_peta_jabatan AS rpj', 'pi.fid_rpk_peta_jabatan=rpj.id','left');
        $this->db->join('rpk_penilaian AS rp', 'pi.fid_rpk_penilaian=rp.id','left');
        $this->db->join('pegawai AS p', 'rp.nip=p.nip','left');
        $this->db->join('ref_unit_kerjav2 AS u', 'pi.rencana_penempatan=u.id_unit_kerja','left');
        if(!empty($unkerid)){
            $this->db->where('p.fid_unit_kerja', $unkerid);
        }
        $i=0;
        foreach ($this->column_search_instansi as $item) { // loop column 
                if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_instansi) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST["order"])){
            $this->db->order_by($this->order_colums_instansi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("pi.id", "desc");
        }
    }
    public function fetch_datatable_instansi($unkerid='') {
        $this->datatable_instansi($unkerid);
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_instansi($unkerid='') {
        $this->datatable_instansi($unkerid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data_instansi($unkerid='') {
        
        $this->db->select("pi.*");
        $this->db->from($this->table_instansi);
        $this->db->join('rpk_peta_jabatan AS rpj', 'pi.fid_rpk_peta_jabatan=rpj.id','left');
        $this->db->join('rpk_penilaian AS rp', 'pi.fid_rpk_penilaian=rp.id','left');
        $this->db->join('pegawai AS p', 'rp.nip=p.nip','left');
        if(!empty($unkerid)){
            $this->db->where('p.fid_unit_kerja', $unkerid);
        }
        $query = $this->db->count_all_results();
        return $query;
    }
    function getJst($unkerId,$search='') 
    {
        return $this->db->like('nama_jabatan', $search)->get_where('ref_jabstruk', ['fid_unit_kerja' => $unkerId])->result_array();
    }
    function getJfu($search) 
    {
      $this->db->select('*');
      $this->db->from('ref_jabfu');
      $this->db->like('nama_jabfu', $search);
      $this->db->order_by('nama_jabfu', 'ASC');
      $query = $this->db->get();
      return $query->result_array();
        //return $this->db->get('ref_jabfu')->result_array();
    }
    function getJft($search) 
    {
        $this->db->select('*');
        $this->db->from('ref_jabft');
        $this->db->like('nama_jabft', $search);
        $this->db->order_by('nama_jabft', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
        //return $this->db->get('ref_jabft')->result_array();
    }

    // PAGE PENYELARASAN KOMPETENSI
    public $table_kompetensi = 'rpk_pns AS t';
    public $select_colums_kompetensi = array('t.*','ri.tahun_pelaksanaan_ke','rp.nip','p.nama','p.gelar_depan','p.gelar_belakang',
    'rp.nilai_kompetensi_manajerial','rp.nilai_kompetensi_sosiokultural','rp.nilai_kompetensi_teknis');
    public $order_colums_kompetensi = array(NULL, 't.id', null, null, null, 'ri.tahun_pelaksanaan_ke', null, null, null, null, null);
    public $column_search_kompetensi = array('rp.nip','p.nama');

    public function datatable_kompetensi($unkerid='') {
        $this->db->select($this->select_colums_kompetensi);
        $this->db->from($this->table_kompetensi);
        $this->db->join('rpk_instansi AS ri', 't.fid_rpk_instansi=ri.id','left');
        $this->db->join('rpk_penilaian AS rp', 't.fid_rpk_penilaian=rp.id','left');
        $this->db->join('pegawai AS p', 'rp.nip=p.nip','left');
        if(!empty($unkerid)){
            $this->db->where('p.fid_unit_kerja', $unkerid);
        }
        $i=0;
        foreach ($this->column_search_kompetensi as $item) { // loop column 
                if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_kompetensi) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST["order"])){
            $this->db->order_by($this->order_colums_kompetensi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("t.id", "desc");
        }
    }
    public function fetch_datatable_kompetensi($unkerid='') {
        $this->datatable_kompetensi($unkerid);
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_kompetensi($unkerid='') {
        $this->datatable_kompetensi($unkerid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data_kompetensi($unkerid='') {
        
        $this->db->select('t.*');
        $this->db->from($this->table_kompetensi);
        $this->db->join('rpk_instansi AS ri', 't.fid_rpk_instansi=ri.id','left');
        $this->db->join('rpk_penilaian AS rp', 't.fid_rpk_penilaian=rp.id','left');
        $this->db->join('pegawai AS p', 'rp.nip=p.nip','left');
        if(!empty($unkerid)){
            $this->db->where('p.fid_unit_kerja', $unkerid);
        }
        $query = $this->db->count_all_results();
        return $query;
    }
}