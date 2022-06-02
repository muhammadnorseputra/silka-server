<center>  
  <div class="panel panel-info" style="width: 80%">
    <div class="panel-body">
      <?php
      echo "<form method='POST' action='../hukdis/tampilusulhukdis'>";          
      ?>
      <p align="right">
        <button type="submit" class="btn btn-info btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
        </button>
      </p>     

      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
          <?php
          echo '<b>DETAIL HUKUMAN DISIPLIN</b><br />';
          ?>
        </div>
        <?php
        foreach($detailhd as $v):              
        ?>
        <table class="table">
          <tr>
            <td align='center'>
              <table class='table table-condensed'>
                <tr class='success'>
                  <td align='center' width='120'><b>IDENTITAS PNS<br/>Pada saat dijatuhi<br/>Hukuman Disiplin</b></td>
                  <td>
                  <table class='table table-condensed'>
                  <tr>
                    <td readonly width="12%">NIP</td>
                    <td readonly width="1%">:</td>
                    <td><?php echo $v['nip'];?></td>
                  </tr>
                  <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td><?php echo $this->mpegawai->getnama($v['nip']),'</b>' ?></td>
                  </tr>
                  <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php echo $v['jabatan']."<br/>TMT Jabatan : ".tgl_indo($v['tmt_jabatan']); ?></td>
                  </tr>
                  <tr>
                    <td>Pangkat (Golru)</td>
                    <td>:</td>
                    <td><?php echo $this->mpegawai->getnamapangkat($v['fid_golru'])." (".$this->mpegawai->getnamagolru($v['fid_golru']).")<br/>TMT Pangkat (Golru) : ".tgl_indo($v['tmt_golru']); ?></td>
                  </tr>
                  <tr>
                    <td>Gaji</td>
                    <td>:</td>
                    <td><?php echo "Rp. ".indorupiah($v['gaji'])."<br/>TMT Gaji : ".tgl_indo($v['tmt_golru']); ?></td>
                  </tr>
                  </table>
                  </td>
                  <td colspan='2' align='center'>
                  <?php
                    $lokasifile = './photo/';
                    $filename = "$v[nip].jpg";
                    if (file_exists ($lokasifile.$filename)) {
                      $photo = "../photo/$v[nip].jpg";
                    } else {
                      $photo = "../photo/nophoto.jpg";
                    }
                  ?>
                  <img src='<?php echo $photo; ?>' width='120' height='160' alt='<?php echo $v['nip']; ?>.jpg' class="img-thumbnail">
                  </td>
                </tr>
                <tr class='warning'>
                  <td align='center'><b>DETAIL<br/>Hukuman Disiplin</b></td>
                  <td colspan='2'>
                  <table class='table table-condensed'>
                  <tr>
                    <td readonly width="16%">Jenis Hukuman</td>
                    <td readonly width="1%">:</td>
                    <td><?php echo $this->mhukdis->getjnshukdis($v['fid_jenis_hukdis'])."<br/>Hukuman Disiplin Tingkat. <b>".$this->mhukdis->gettingkathukdis($v['fid_jenis_hukdis'])."</b>";?></td>
                  </tr>
                  <tr>
                    <td>Panggilan Pertama</td>
                    <td>:</td>
                    <td>
                      <?php 
                      echo "No. Surat Penggilan. <b>".$v['pemanggilan1_nosurat']."</b> (Tanggal ".tgl_indo($v['pemanggilan1_tglsurat']).")";
                      echo "<br/>Pemeriksaan Pertama pada tanggal <b>".tgl_indo($v['pemeriksaan1_tgl'])."</b>";
                       ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Panggilan Kedua</td>
                    <td>:</td>
                    <td>
                      <?php 
                      if ($v['pemanggilan2_tglsurat'] != null) {
                        echo "No. Surat Penggilan. <b>".$v['pemanggilan2_nosurat']."</b> (Tanggal ".tgl_indo($v['pemanggilan2_tglsurat']).")";
                      } else {
                        echo "Panggilan Kedua tidak dilakukan";
                      }

                      if ($v['pemeriksaan2_tgl'] != null) {
                        echo "<br/>Pemeriksaan Kedua pada tanggal <b>".tgl_indo($v['pemeriksaan2_tgl'])."</b>";
                      } else {
                        echo "<br/>Pemeriksaan Kedua tidak dilakukan"; 
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Peraturan yang dilanggar</td>
                    <td>:</td>
                    <td><?php echo $this->mhukdis->getperuu($v['fid_peruu']); ?></td>
                  </tr>
                  <tr>
                    <td>Masa Hukuman</td>
                    <td>:</td>
                    <td>
                    <?php
                      echo "Terhitung mulai. <b>".tgl_indo($v['tmt_hukuman'])."</b>";
                      if ($v['akhir_hukuman'] != null) {
                      echo "<br/>sampai dengan. <b>".tgl_indo($v['akhir_hukuman'])."</b>";
                      }
                    ?>
                    </td>
		  </tr>
                  <tr>
                    <td>Lama Hukuman</td>
                    <td>:</td>
                    <td><?php echo $v['lama_thn']." Tahun, ".$v['lama_bln']." Bulan"; ?></td>
                  </tr>
                  <tr>
                    <td>Deskripsi Kasus</td>
                    <td>:</td>
                    <td><?php echo $v['deskripsi']; ?></td>
                  </tr>
                  <tr>
                    <td>Surat Keputusan</td>
                    <td>:</td>
                    <td><?php 
                      $namapjb = $this->mpegawai->getnama($v['nippejabat_sk']);
                      $jabpjb = $this->mpegawai->namajabnip($v['nippejabat_sk']);
                      echo "Pejabat berwenang. <b>".$namapjb."</b> (".$jabpjb.")";
                      echo "<br/>Nomor. <b>".$v['no_sk']."</b>";
                      echo "<br/>Tanggal. <b>".tgl_indo($v['tgl_sk'])."</b>";
                       ?>
                    </td>
                  </tr>
                  </table>
                  </td>
                </tr>
                <tr class='info'>
                  <td align='center'><b>Status Laporan</b></td>
                  <td colspan='2'>
                  <?php
                    if ($v['status'] == 'NO VALID') {
                      $ket ='TUNGGU VALIDASI';
                      $color = 'default';  
                    } else if ($v['status'] == 'VALID') {
                      $ket ='SETUJU'; 
                      $color = 'info'; 
                    } else if ($v['status'] == 'CETAK SK') {
                      $ket ='CETAK SK';  
                      $color = 'success';
                    } else if ($v['status'] == 'SELESAI') {
                      $ket ='SELESAI'; 
                      $color = 'default'; 
                    }
                    echo "<b><h5><span class='label label-".$color."'>".$ket."</span></h5></b>";
                    echo "Dilaporkan oleh ".$this->mpegawai->getnama($v['dilaporkan_oleh'])." pada tanggal ".$v['dilaporkan_pada'];
                    
                    if ($v['status'] != 'NO VALID') {
                      echo "<br/>Divalidasi oleh ".$this->mpegawai->getnama($v['disetujui_oleh'])." pada tanggal ".$v['disetujui_pada'];
                    }

                  ?>
                  </td>
                </tr>                
                </table> 
              </td>
            </tr>
          </table>
          <?php
          endforeach;
          ?>
        </div>
      </div>
    </div>
  </center>

