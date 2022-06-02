<center>
  <div class="panel panel-default" style="width: 80%">
  <div class="panel-body">
  
  <form method="POST" action="../pensiun/cari_pegawai">
  <p align="right">
  <button type="submit" class="btn btn-primary btn-sm">
  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
  </button>
  </p>
  </form>
  
  <?php
  if ($count_data==0) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<b>Data tidak ditemukan atau berada diluar kewenangan anda</b>';
    echo '</div>';
  } else { // jika data ditemukan
    echo '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<b>Ditemukan '.$count_data.' Data</b><br />';
    echo '</div>';
  }
  ?>
  
  <table class="table table-condensed table-hover">
    <thead>
      <tr class="info">
        <td align="center"><b>#</b></td>
        <td align="center"><b>NIP</b></td>
        <td colspan="2" align="center"><b>Nama</b></td>
        <td align="center"><b>Golongan Ruang</b></td>
        <td align="center"><b>Unker/Jabatan</b></td>
      	<td align="center"></td>
      	<td align="center"></td>

      </tr>
    </thead>
    <tbody>
      <?php
        $no = 1;
        foreach($data as $d):
      ?>
      <tr>
        <td width="10" align="center"><?= $no; ?></td>
        <td width="150"><?= $d->nip ?></td>
        <td><?php echo namagelar($d->gelar_depan,$d->nama,$d->gelar_belakang); ?></td>
        <td align="center">         
          <?php
            $lokasifile = './photo/';
                  $filename = $d->nip.".jpg";

                  if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$d->nip.jpg";
                  } else {
                    $photo = "../photo/nophoto.jpg";
                  }
          ?>      
          <img src='<?php echo $photo; ?>' width='60' height='80' alt='<?php echo $d->nip; ?>.jpg'>  
        </td>
        <td width="140" align="center">
        <?php echo $d->nama_golru;?>
          <br />
          <?php echo 'TMT : ',tgl_indo($d->tmt_golru_skr); ?>  
        </td>
        <td><?php echo $d->nama_unit_kerja; ?></td>
        <td>
          <form method="POST" action="../pensiun/detail/non_bup">
	          <input type="hidden" name="nip" id="nip" maxlength="18" value="<?= $d->nip ?>">          
	          <button type="submit" class="btn btn-info btn-xs pull-left m-r-3">
	          	<br>&nbsp;<span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span><br>NON BUP <br>&nbsp;
	          </button>
          </form>
        </td>
        <td>
          <form method="POST" action="../pensiun/mutasi">
	          <input type="hidden" name="nip" id="nip" maxlength="18" value="<?= $d->nip ?>">          
	          <button type="submit" class="btn btn-danger btn-xs pull-left m-r-3">
	          	<br>&nbsp;<span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span><br>Mutasi Keluar <br>&nbsp;
	          </button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
     </tbody>
   </table>
  </div>
</div>
</center>