<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/* 
   Jika menggunakan controller ini, robah settingan 'config/rest.php' 
   Cari 'rest_auth' = 'basic' dan 'auth_source' = ''
*/
class SavePegawai extends REST_Controller  {

    function __construct() {
        
        parent::__construct();
        //load model services
        $this->load->model(['Mapi' => 'api']);
        $this->load->helper('fungsipegawai');
        header('Access-Control-Allow-Origin: *');
    }

    protected function cekValue($value) {
        return $value === "" ? NULL : $value;
    }

    public function pns_post() {
        $nip = $this->post('nip');

        $insert = [
            'nip' => $this->cekValue($this->post('nip')),
            'nama' => $this->cekValue($this->post('nama')),
            'gelar_depan' => $this->cekValue($this->post('gelar_depan')),
            'gelar_belakang' => $this->cekValue($this->post('gelar_belakang')),
            'kode_jenkel' => $this->cekValue($this->post('kode_jenkel')),
            'tempat_lahir' => $this->cekValue($this->post('tempat_lahir')),
            'tanggal_lahir' => $this->cekValue($this->post('tanggal_lahir')),
            'agama' => $this->cekValue($this->post('agama')),
            'zakat_dg' => null,
            'pendidikan_terakhir' => $this->cekValue($this->post('pendidikan')),
            'tmt_capeg' => $this->cekValue($this->post('tmt_capeg')),
            'tmt_skmt' => $this->cekValue($this->post('tmt_skmt')), //noted
            'kode_status_kawin' => $this->cekValue($this->post('kode_kawin')),
            'jumlah_sutri' => $this->cekValue($this->post('jumlah_sutri')),
            'jumlah_anak' => $this->cekValue($this->post('jumlah_anak')),
            'kode_status_pegawai' => $this->cekValue($this->post('kode_status_pegawai')),
            'nama_status_pegawai' => $this->cekValue($this->post('nama_status_pegawai')),
            'kode_pangkat' => $this->cekValue($this->post('kode_pangkat')),
            'nama_pangkat' => $this->cekValue($this->post('nama_pangkat')),
            'masakerja_golongan_tahun' => $this->cekValue($this->post('masker_tahun')),
            'masakerja_golongan_bulan' => $this->cekValue($this->post('masker_bulan')),
            'masakerja' => $this->cekValue($this->post('masker')),
            'prsngapok' => null,
            'kode_eselon' => $this->cekValue($this->post('kode_eselon')),
            'tunjangan_eselon' => null, //noted
            'kode_fungsi1' => null,
            'kode_fungsi' => null,
            'tunjangan_fungsi' => null,
            'kode_struktural' => null, //noted
            'tunjangan_struktural' => null, //noted
            'kode_guru' => null, //noted
            'kode_skpd' => $this->cekValue($this->post('kode_skpd')),
            'nama_skpd' => $this->cekValue($this->post('nama_skpd')),
            'kode_skpd_simpeg' => $this->cekValue($this->post('kode_skpd_simpeg')),
            'kode_satker' => $this->cekValue($this->post('kode_satker')),
            'nama_satker' => $this->cekValue($this->post('kode_satker')),
            'alamat' => $this->cekValue($this->post('alamat')),
            'kddati1' => 16,
            'kddati2' => 12,
            'no_telpon' => $this->cekValue($this->post('no_telpon')),
            'no_ktp' => $this->cekValue($this->post('no_ktp')),
            'npwp' => $this->cekValue($this->post('npwp')),
            'kode_hitung' => null, //noted
            'induk_bank' => $this->cekValue($this->post('induk_bank')),
            'norek' => $this->cekValue($this->post('norek')),
            'tmt_berlaku' => $this->cekValue($this->post('tmt_berlaku')),
            'kode_jns_transaksi' => null, //noted
            'inputer' => $this->cekValue($this->post('created_by')),
            'kode_jenis_pegawai' => $this->cekValue($this->post('kode_jenis_pegawai')),
            'nama_jenis_pegawai' => $this->cekValue($this->post('nama_jenis_pegawai')),
            'status_data' => 'VERIFIKASI',
        ];

        $update = [
            'nama' => $this->cekValue($this->post('nama')),
            'gelar_depan' => $this->cekValue($this->post('gelar_depan')),
            'gelar_belakang' => $this->cekValue($this->post('gelar_belakang')),
            'kode_jenkel' => $this->cekValue($this->post('kode_jenkel')),
            'tempat_lahir' => $this->cekValue($this->post('tempat_lahir')),
            'tanggal_lahir' => $this->cekValue($this->post('tanggal_lahir')),
            'agama' => $this->cekValue($this->post('agama')),
            'zakat_dg' => null,
            'pendidikan_terakhir' => $this->cekValue($this->post('pendidikan')),
            'tmt_capeg' => $this->cekValue($this->post('tmt_capeg')),
            'tmt_skmt' => $this->cekValue($this->post('tmt_skmt')),
            'kode_status_kawin' => $this->cekValue($this->post('kode_kawin')),
            'jumlah_sutri' => $this->cekValue($this->post('jumlah_sutri')),
            'jumlah_anak' => $this->cekValue($this->post('jumlah_anak')),
            'kode_status_pegawai' => $this->cekValue($this->post('kode_status_pegawai')),
            'nama_status_pegawai' => $this->cekValue($this->post('nama_status_pegawai')),
            'kode_pangkat' => $this->cekValue($this->post('kode_pangkat')),
            'nama_pangkat' => $this->cekValue($this->post('nama_pangkat')),
            'masakerja_golongan_tahun' => $this->cekValue($this->post('masker_tahun')),
            'masakerja_golongan_bulan' => $this->cekValue($this->post('masker_bulan')),
            'masakerja' => $this->cekValue($this->post('masker')),
            'prsngapok' => null,
            'kode_eselon' => $this->cekValue($this->post('kode_eselon')),
            'tunjangan_eselon' => null, //noted
            'kode_fungsi1' => null,
            'kode_fungsi' => null,
            'tunjangan_fungsi' => null,
            'kode_struktural' => null, //noted
            'tunjangan_struktural' => null, //noted
            'kode_guru' => null, //noted
            'kode_skpd' => $this->cekValue($this->post('kode_skpd')),
            'nama_skpd' => $this->cekValue($this->post('nama_skpd')),
            'kode_skpd_simpeg' => $this->cekValue($this->post('kode_skpd_simpeg')),
            'kode_satker' => $this->cekValue($this->post('kode_satker')),
            'nama_satker' => $this->cekValue($this->post('nama_satker')),
            'alamat' => $this->cekValue($this->post('alamat')),
            'kddati1' => 16,
            'kddati2' => 12,
            'no_telpon' => $this->cekValue($this->post('no_telpon')),
            'no_ktp' => $this->cekValue($this->post('no_ktp')),
            'npwp' => $this->cekValue($this->post('npwp')),
            'kode_hitung' => null, //noted
            'induk_bank' => $this->cekValue($this->post('induk_bank')),
            'norek' => $this->cekValue($this->post('norek')),
            'tmt_berlaku' => $this->cekValue($this->post('tmt_berlaku')),
            'kode_jns_transaksi' => null, //noted
            'inputer' => $this->cekValue($this->post('created_by')),
            'kode_jenis_pegawai' => $this->cekValue($this->post('kode_jenis_pegawai')),
            'nama_jenis_pegawai' => $this->cekValue($this->post('nama_jenis_pegawai')),
            'status_data' => 'VERIFIKASI',
        ];

        $whr = [
            'nip' => $nip
        ];

        // Jika Params / Body NIP tidak ada
        if(empty($nip)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nip` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        $cekdb = $this->db->get_where('simgaji_pegawai', ['nip' => $nip])->num_rows();
        if($cekdb > 0) {
            $db = $this->api->update('simgaji_pegawai', $update, $whr);
            // update tgl_spmt pada table cpnspns
            $this->api->update('cpnspns', ['tgl_spmt' => $this->post('tmt_skmt')], $whr);
            
            $msg = [
                'status' => true,
                'message' => 'Data SIMGAJI Pegawai '.$nip.' Berhasil Diperbaharui',
                'http_code' => REST_Controller::HTTP_OK 
            ]; 
        } 

        if($cekdb == 0) {
            $db = $this->api->save('simgaji_pegawai', $insert);
            // update tgl_spmt pada table cpnspns
            $this->api->update('cpnspns', ['tgl_spmt' => $this->post('tmt_skmt')], $whr);
            $msg = [
                'status' => true,
                'message' => 'Data SIMGAJI Pegawai '.$nip.' Berhasil Ditambahkan',
                'http_code' => REST_Controller::HTTP_CREATED  
            ];
        }

        if($db) {
            return $this->response($msg, REST_Controller::HTTP_OK);
        }

        $msg = [
            'status' => false,
            'message' => 'Data SIMGAJI Pegawai Gagal Diperbaharui',
            'http_code' => REST_Controller::HTTP_NOT_FOUND
        ];
        $this->response($msg, REST_Controller::HTTP_NOT_FOUND);

    }

    public function pppk_post() {
        $nipppk = $this->post('nipppk');
        $insert = [
            'nipppk' => $this->cekValue($this->post('nipppk')),
            'nama'  => $this->cekValue($this->post('nama')),
            'gelar_depan' => $this->cekValue($this->post('gelar_depan')),
            'gelar_belakang' => $this->cekValue($this->post('gelar_belakang')),
            'kode_jenkel' => $this->cekValue($this->post('kode_jenkel')),
            'tempat_lahir' => $this->cekValue($this->post('tempat_lahir')),
            'tanggal_lahir' => $this->cekValue($this->post('tanggal_lahir')),
            'jumlah_sutri' => $this->cekValue($this->post('jumlah_sutri')),
            'jumlah_anak' => $this->cekValue($this->post('jumlah_anak')),
            'kode_statuspeg' => $this->cekValue($this->post('kode_statuspeg')),
            'kode_pangkat' => $this->cekValue($this->post('kode_pangkat')),
            'gapok' => $this->cekValue($this->post('gapok')),
            'masakerja_tahun' => $this->cekValue($this->post('masker_tahun')),
            'kode_skpd' => $this->cekValue($this->post('kode_skpd')),
            'kode_skpd_simpeg' => $this->cekValue($this->post('kode_skpd_simpeg')),
            'kode_satker' => $this->cekValue($this->post('kode_satker')),
            'keterangan' => $this->cekValue($this->post('keterangan')),
            'tmt_gaji' => $this->cekValue($this->post('tmt_gaji')),
            'induk_bank' => $this->cekValue($this->post('bank')),
            'norek' => $this->cekValue($this->post('norek')),
            'noktp' => $this->cekValue($this->post('noktp')),
            'npwp' => $this->cekValue($this->post('npwp')),
            'notelpon' => $this->cekValue($this->post('notelpon')),
            'nomor_sk' => $this->cekValue($this->post('nosk')),
            'penerbit_sk' => $this->cekValue($this->post('penerbitsk')),
            'tgl_sk' => $this->cekValue($this->post('tglsk')),
            'kode_guru' => null, //noted
            'kategori' => $this->cekValue($this->post('kategori')),
            'formasi' => $this->cekValue($this->post('formasi')),
            'akhir_kontrak' => $this->cekValue($this->post('akhir_kontrak')),
            'status_data' => 'VERIFIKASI',
            'created_by' => $this->cekValue($this->post('created_by')),
        ];
        $update = [
            'nama'  => $this->cekValue($this->post('nama')),
            'gelar_depan' => $this->cekValue($this->post('gelar_depan')),
            'gelar_belakang' => $this->cekValue($this->post('gelar_belakang')),
            'kode_jenkel' => $this->cekValue($this->post('kode_jenkel')),
            'tempat_lahir' => $this->cekValue($this->post('tempat_lahir')),
            'tanggal_lahir' => $this->cekValue($this->post('tanggal_lahir')),
            'jumlah_sutri' => $this->cekValue($this->post('jumlah_sutri')),
            'jumlah_anak' => $this->cekValue($this->post('jumlah_anak')),
            'kode_statuspeg' => $this->cekValue($this->post('kode_statuspeg')),
            'kode_pangkat' => $this->cekValue($this->post('kode_pangkat')),
            'gapok' => $this->cekValue($this->post('gapok')),
            'masakerja_tahun' => $this->cekValue($this->post('masker_tahun')),
            'kode_skpd' => $this->cekValue($this->post('kode_skpd')),
            'kode_skpd_simpeg' => $this->cekValue($this->post('kode_skpd_simpeg')),
            'kode_satker' => $this->cekValue($this->post('kode_satker')),
            'keterangan' => $this->cekValue($this->post('keterangan')),
            'tmt_gaji' => $this->cekValue($this->post('tmt_gaji')),
            'induk_bank' => $this->cekValue($this->post('bank')),
            'norek' => $this->cekValue($this->post('norek')),
            'noktp' => $this->cekValue($this->post('noktp')),
            'npwp' => $this->cekValue($this->post('npwp')),
            'notelpon' => $this->cekValue($this->post('notelpon')),
            'nomor_sk' => $this->cekValue($this->post('nosk')),
            'penerbit_sk' => $this->cekValue($this->post('penerbitsk')),
            'tgl_sk' => $this->cekValue($this->post('tglsk')),
            'kode_guru' => null, //noted
            'kategori' => $this->cekValue($this->post('kategori')),
            'formasi' => $this->cekValue($this->post('formasi')),
            'akhir_kontrak' => $this->cekValue($this->post('akhir_kontrak')),
            'status_data' => 'VERIFIKASI',
            'update_by' => $this->cekValue($this->post('update_by')),
        ];

        $whr = [
            'nipppk' => $this->post('nipppk')
        ];
        // Jika Params / Body NIP tidak ada
        if(empty($nipppk)) {
            $msg = [
                'status' => false,
                'message' => 'Parameter `nipppk` Wajib Ditambahkan',
                'http_code' => REST_Controller::HTTP_LENGTH_REQUIRED
            ];
            return $this->response($msg, REST_Controller::HTTP_LENGTH_REQUIRED);
        }

        $cekdb = $this->db->get_where('simgaji_pppk', ['nipppk' => $nipppk])->num_rows();
        if($cekdb > 0) {
            $db = $this->api->update('simgaji_pppk', $update, $whr);
            $msg = [
                'status' => true,
                'message' => 'Data SIMGAJI PPPK '.$nipppk.' Berhasil Diperbaharui',
                'http_code' => REST_Controller::HTTP_OK 
            ]; 
        } 

        if($cekdb == 0) {
            $db = $this->api->save('simgaji_pppk', $insert);
            $msg = [
                'status' => true,
                'message' => 'Data SIMGAJI PPPK '.$nipppk.' Berhasil Ditambahkan',
                'http_code' => REST_Controller::HTTP_CREATED  
            ];
        }

        if($db) {
            return $this->response($msg, REST_Controller::HTTP_OK);
        }

        $msg = [
            'status' => false,
            'message' => 'Data SIMGAJI PPPK Gagal Diperbaharui',
            'http_code' => REST_Controller::HTTP_NOT_FOUND
        ];
        return $this->response($msg, REST_Controller::HTTP_NOT_FOUND);
    }
}