<center>
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
    <table class='table table-condensed'>
        <tr>
          <td align='right' width='50'>
            <form method='POST' action='../pegawai/detail'>
                <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            </form>
          </td>
        </tr>
      </table>

      <?php
      if ($pesan != '') {
      ?>
      <div class="<?php echo $jnspesan; ?>" alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
          echo $pesan;
      ?>
      </div>
      <?php
      }
      ?>

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT CUTI</b><br />';
          echo $this->mpegawai->getnama($nip);
          echo " ::: ".$nip
        ?>
        </div>

        <table class="table">
          <tr>
            <td align='center'>
              <ul class="nav nav-tabs">
              <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
              <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
                <li class="active"><a href="#cuti" data-toggle="tab">CUTI</a></li>
                <li><a href="#cutitunda" data-toggle="tab">CUTI TUNDA</a></li>
              </ul>

              <!-- Tab panes, ini content dari tab di atas -->
              <div class="tab-content">
                <div class="tab-pane face in active" id="cuti">
                  <br />
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='warning'>
                      <th width='20'><center>#</center></th>
                      <th width='60'><center>Tahun</center></th>
                      <th width='200'><center>Jenis Cuti</center></th>
                      <th width='150'><center>Lama</center></th>
                      <th width='150'><center>Tgl. Mulai<br />Tgl. Selesai</center></th>
                      <!--<th><center>Alamat</center></th>-->
                      <th width='400'><center>Surat Keputusan</center></th>
                    </tr>
                    <?php
                      $no=1;
                      foreach($pegrwycuti as $v):
                    ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td align='center'><?php echo $v['thn_cuti']; ?></td>
                      <td><?php echo $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']); ?></td>
                      <td align='center'>
                        <?php echo $v['jml'].' '.$v['satuan_jml']; ?>
                        <br />
                        <?php echo '+ TUNDA : '. $v['tambah_hari_tunda'].' HARI'; ?>
                      </td>
                      <td align='center'><?php echo tgl_indo($v['tgl_mulai']).'<br />s/d<br />'.tgl_indo($v['tgl_selesai']); ?></td>
                      <!--<td><?php //echo $v['alamat']; ?></td>-->
                      <td><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
                    </tr>
                    <?php
                      $no++;
                      endforeach;
                    ?>
                  </table>
                </div>

                <div class="tab-pane" id="cutitunda">
                  <br />
                  <table class='table table-condensed table-hover table-bordered'>
                    <tr class='warning'>
                      <th width='20'><center>#</center></th>
                      <th width='60'><center>Tahun Cuti yang Ditunda</center></th>
                      <th width='80'><center>Lama</center></th>
                      <th width='400'><center>Surat Keputusan</center></th>
                    </tr>
                    <?php
                      $no=1;
                      foreach($pegrwycutitunda as $v):
                    ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td align='center'><?php echo $v['thn_cuti']; ?></td>
                      <td align='center'><?php echo $v['jml'].' HARI'; ?></td>
                      <td><?php echo $v['pejabat_sk'].'<br />Nomor : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']); ?></td>
                    </tr>
                    <?php
                      $no++;
                      endforeach;
                    ?>
                  </table>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
            <?php if($this->session->userdata('nama') == 'salasiah' || $this->session->userdata('level') == 'ADMIN'): ?>
      <?php
        $year_now = date('Y');

        $thn_sebelummya = $year_now - 1;
        $thn_sekarang = $year_now;
        $thn_selanjutnya = $year_now + 1;
      ?>
      <!-- Info Kouta Cuti  -->
      <div class="panel panel-danger">
      <!-- <div class='panel-heading text-left'>::: <b>Akumulasi Cuti</b></div> -->
      <table class="table table-striped table-bordered tabel-hover">
          <thead class="bg-success">
            <tr>
              <th>Tahun Cuti</th>
              <th>Jumlah Cuti Tahunan Diambil</th>
              <th>Sisa Cuti Tahunan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <?= $thn_sebelummya ?>
              </td>
              <td>
                <?php
                  //Jumlah Cuti Yang Diambil
                  $getJmlCuti_sebelumnya = $this->mcuti->jml_cuti_tahun_sebelumnya($thn_sebelummya, $nip);
                  echo "<b>".$getJmlCuti_sebelumnya."</b> Hari";
                ?>
              </td>
              <td>
              	
                <?php
          		$sisa_cuti = (12 - $getJmlCuti_sebelumnya);
                if($thn_sebelummya == '2018'){
                  //Jumlah Sisa Cuti Hanya Jika Tahun 2018
                  if($getJmlCuti_sebelumnya >= 6 ? $jmlCutiSebelumnya = "<b>0</b>" : $jmlCutiSebelumnya = ($sisa_cuti - $getJmlCuti_sebelumnya));
                  echo "<b>".$jmlCutiSebelumnya."</b> Hari";
                
                }
                else {
                  //Jumlah Sisa Cuti
                  if($getJmlCuti_sebelumnya < 6 ? $jmlCutiSebelumnya = "<b>6</b>" : $jmlCutiSebelumnya = ($sisa_cuti - $getJmlCuti_sebelumnya));
                  echo "<b>".$jmlCutiSebelumnya."</b> Hari";
                }

                ?>
              </td>
            </tr>

            <tr>
              <td>
              <?= $thn_sekarang ?>
              </td>
              <td>
              <?php
                  //Jumlah Cuti Yang Diambil
                  $getJmlCuti_sekarang = $this->mcuti->jml_cuti_tahun_sekarang($thn_sekarang, $nip);
                  $jatahCuti_skr = 12;

                  echo "<b>".$getJmlCuti_sekarang."</b> Hari";
              ?>
              </td>
              <td>
                <?php 
                  //Jumlah Sisa Cuti
                  $sisaCutiTahunIni = (12 - $getJmlCuti_sekarang);
                  if($getJmlCuti_sekarang >= 6)
                  {
                    $jmlCuti_skr = $sisaCutiTahunIni;
                  }
                  elseif 
                  ($getJmlCuti_sekarang < 6)
                  {
                    $jmlCuti_skr = 12 - $getJmlCuti_sekarang;
                  }
                  if($jatahCuti_skr >= 6)
                  {
                    $sisa = " <b>Jatah Cuti ".$jatahCuti_skr ." - ". $getJmlCuti_sekarang." = </b>";
                  }
                  else
                  {
                    $sisa = "";
                  }

                  if($jmlCuti_skr > 6){
                    $lebihdari = 6;
                    $sisaCuti = $jmlCuti_skr - $lebihdari; 
                    $tahun_sekarang = $getJmlCuti_sekarang;
                    $opertator_lebihdari = ">=";
                    $opertator_kurang = "-";
                    $opertator_samadengan = "=";
                  }else{
                    $sisaCuti = $jmlCuti_skr;
                    $lebihdari = "";
                    $tahun_sekarang = '';
                    $opertator_lebihdari = "";
                    $opertator_kurang = "";
                    $opertator_samadengan = "";
                  }
                  //echo $sisa." <b class='text-danger'>".$jmlCuti_skr." ".$opertator_lebihdari." ".$lebihdari."</b> ( <b>".$lebihdari." ".$opertator_kurang." ".$tahun_sekarang." ".$opertator_samadengan." </b>  Sisa <b class='text-success'>". $sisaCuti ."</b> Hari )";
                  //echo "<b class='text-danger'>".$sisaCuti." Hari"; // Publis 2019
		  echo "<b class='text-danger'>".$jmlCuti_skr." Hari";
		?>
              </td>
            </tr>          

            <tr>
              <td>
              <?= $thn_selanjutnya ?>
              </td>
              <td class="bg-info" colspan="2">
              <?php
                $jatahCuti = 12;
                $kouta = $jatahCuti+$sisaCuti+$jmlCutiSebelumnya;
              ?>
                  Komulatif jumlah cuti tahunan yang dapat di ambil  : 
                  <!--
			<b><?= $jatahCuti ?> Hari </b> + 
                  	<b><?= $sisaCuti ?> Hari</b> + 
                  	<b><?= $jmlCutiSebelumnya ?> Hari</b> =
		  -->
                  <b class="text-success"><?= $kouta ?></b> Hari
               </td>
            </tr>          

          </tbody>
      </table>  
      
      </div>
      <?php endif ?>     
    </div>
  </div>  
</center>
