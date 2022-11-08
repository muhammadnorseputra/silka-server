		
<b>Show Data Personal</b>
<input type="checkbox" name="show_data_personal" value="0"/>

<div style="max-height:600px; max-width:100%; overflow:scroll; background:#fff">
    <table class="table table-bordered table-hover table-condensed table-striped">
    <thead>
        <tr>
            <th rowspan="4" width="15" style="vertical-align: middle;">NO</th>
            <tr>
                <th colspan="12"  id="th_profile" class="text-center">PROFILE PEGAWAI</th>
                <th rowspan="3" class="text-center" style="vertical-align: middle;">Rekomendasi Pengembangan</th>
                <th rowspan="3" class="text-center" style="vertical-align: middle;">AKSI</th>
            </tr>
            <tr>
                <th colspan="3" id="th_datapersonal" class="text-center" style="vertical-align: middle;">DATA PERSONAL</th>
                <!-- JIKA SHOW 7 -->
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Nama SKPD (Instansi)/Unit Kerja/Bagian (Bidang)</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">KUALIFIKASI PENDIDIKAN</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">REKAM JEJAK JABATAN</th>
                <th colspan="3" class="text-center" style="vertical-align: middle;">Hasil Penilaian/Uji Kompetensi</th>
                <th colspan="2" class="text-center" style="vertical-align: middle;">SKP (2 Tahun Terakhir)</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Informasi Kepegawaian Lainnya</th>
            </tr>
            <th width="13%">NAMA</th>
            <th>NAMA JABATAN</th>
            <th>NIP</th>
            <th id="th_ttl" class="hide">TEMPAT, TANGGAL LAHIR</th>
            <th id="th_status_kawin" class="hide">STATUS PERKAWINAN</th>
            <th id="th_agama" class="hide">AGAMA</th>
            <th id="th_alamat" class="hide">ALAMAT</th>
            <th class="text-center" style="vertical-align: middle;">Nilai/Deskripsi Kompetensi Manajerial</th>
            <th class="text-center" style="vertical-align: middle;">Nilai/Deskripsi Kompetensi Sosiokultural</th>
            <th class="text-center" style="vertical-align: middle;">Nilai/Deskripsi Kompetensi Teknis</th>
            <th><?= date('Y')-2 ?></th>
            <th><?= date('Y')-1 ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $no=1;	
            foreach($peg as $p):
                // NAMA JABATAN
                if(!empty($p->nama_jabatan)) {
                    $nama_jab = $p->nama_jabatan;
                } elseif (!empty($p->nama_jabfu)) {
                    $nama_jab = $p->nama_jabfu;
                } elseif(!empty($p->nama_jabft)) {
                    $nama_jab = $p->nama_jabft;
                } else {
                    $nama_jab = "-";
                }

                // VALIDASI
                if(($p->status != 'DONE') && ($this->mrpk->cek_rpk_peta_jabatan($p->id_rpk_penilaian)->num_rows() == 0)) {
                    if(!empty($p->nilai_kompetensi_manajerial) && !empty($p->nilai_kompetensi_sosiokultural) && !empty($p->nilai_kompetensi_teknis) || $p->nilai_average === "0.00"){
                        $btn_action = '<button class="btn btn-sm btn-info btn-block" id="validasi" data-id="'.$p->id_rpk_penilaian.'" data-nip="'.$p->nip.'"><i class="glyphicon glyphicon-check"></i> <br> VALIDASI</button>';
                        $btn_action .= '<button id="input-nilai" class="btn btn-sm btn-warning btn-block" data-toggle="modal" data-target="#inputModal"  
                        data-nip="'.$p->nip.'" 
                        data-unker="'.$p->nama_unit_kerja.'"
                        data-nama="'.namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang).'"
                        data-nilai-manajerial="'.$p->nilai_kompetensi_manajerial.'" 
                        data-nilai-sosiokultural="'.$p->nilai_kompetensi_sosiokultural.'" 
                        data-nilai-teknis="'.$p->nilai_kompetensi_teknis.'" 
                        data-jenisjab="'.$p->fid_jnsjab.'"
                        data-rekomendasi="'.$p->rekomendasi_pengembangan.'"
                        data-unkerid="'.$p->id_unit_kerja.'"
                        data-jabatanid="'.$p->jabatanid.'"
                        data-golruid="'.$p->fid_golru_skr.'"
                        data-jabatan="'.$nama_jab.'"><i class="glyphicon glyphicon-signal"></i> <br> INPUT ULANG</button>';
                    } else {
                        $btn_action = '<button id="input-nilai" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#inputModal"  
                        data-nip="'.$p->nip.'" 
                        data-unker="'.$p->nama_unit_kerja.'"
                        data-nama="'.namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang).'" 
                        data-nilai-manajerial="'.$p->nilai_kompetensi_manajerial.'" 
                        data-nilai-sosiokultural="'.$p->nilai_kompetensi_sosiokultural.'" 
                        data-nilai-teknis="'.$p->nilai_kompetensi_teknis.'" 
                        data-jenisjab="'.$p->fid_jnsjab.'"
                        data-rekomendasi="'.$p->rekomendasi_pengembangan.'"
                        data-unkerid="'.$p->id_unit_kerja.'"
                        data-golruid="'.$p->fid_golru_skr.'"
                        data-jabatanid="'.$p->jabatanid.'"
                        data-jabatan="'.$nama_jab.'"><i class="glyphicon glyphicon-signal"></i> <br> INPUT</button>';
                    }
                } else {
                    $btn_action = '<center><i class="glyphicon glyphicon-check"></i> <br>DONE</center>';
                }

                $lokasifile = './photo/';
                $filename = $p->nip.".jpg";
        
                if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$filename";
                } else {
                    $photo = "../photo/nophoto.jpg";
                }
    ?>
        <tr style="<?= $p->status === 'DONE' ? 'opacity: 40%' : '';?>">
            <td class="text-center"><?= $no ?></td>
            <td class="text-left"><span class="text-success"><?= namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang) ?></span> <hr> <b><?= $p->nama_pangkat ?> (<?= $p->nama_golru ?>)</b></td>
            <td class="text-left"><?= $nama_jab ?></td>
            <td class="text-left"><?= $p->nip ?></td>
            <td class="text-left hide" id="th_ttl"><?= $p->tmp_lahir ?>, <?= $p->tgl_lahir ?></td>
            <td class="text-left hide" id="th_status_kawin"><?= $p->nama_status_kawin ?></td>
            <td class="text-left hide" id="th_agama"><?= $p->nama_agama ?></td>
            <td class="text-left hide" id="th_alamat"><?= $p->alamat ?></td>
            <td class="text-left"><?= $p->nama_unit_kerja ?></td>
            <td class="text-left"><?= $this->mrpk->pendidikan_terakhir($p->nip) ?></td>
            <!-- <td class="text-left"><div id="showrj-<?= $p->nip ?>"></div><button id="show_rekam_jejak" data-nip="<?= $p->nip ?>" class="btn btn-sm btn-primary">Liat Rekam Jejak</button></td> -->
            <td class="text-left">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#mymodal" id="show_rekam_jejak" data-profile="<?= namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang) ?>" data-nip="<?= $p->nip ?>" <?= $p->status === 'DONE' ? 'disabled' : '';?>>
            Liat Rekam Jejak
            </button>
            </td>
            <td class="text-left"><?= $p->nilai_kompetensi_manajerial ?></td>
            <td class="text-left"><?= $p->nilai_kompetensi_sosiokultural ?></td>
            <td class="text-left"><?= $p->nilai_kompetensi_teknis ?></td>
            <td class="text-left"><?= $this->mrpk->riwayat_skp($p->nip, date('Y')-2) ?></td>
            <td class="text-left"><?= $this->mrpk->riwayat_skp($p->nip, date('Y')-1) ?></td>
            <td class="text-left">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#mymodal" data-content="<?= $p->lainnya ?>" id="show_informasi_lainnya" data-profile="<?= namagelar($p->gelar_depan, $p->nama, $p->gelar_belakang) ?>" data-nip="<?= $p->nip ?>" <?= $p->status === 'DONE' ? 'disabled' : '';?>>
            Informasi Lainnya
            </button>
            </td>
            <td class="text-left"><?= $p->rekomendasi_pengembangan ?></td>
            <td class="text-left"><?= $btn_action ?></td>
        </tr>
    <?php
        $no++;
        endforeach;		
    ?>
    </tbody>
    </table>
    </div>
