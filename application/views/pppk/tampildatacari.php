<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 80%">
  <div class="panel-body">
  
  <form method="POST" action="../pppk/tampilunker">
  <p align="right">
  <button type="submit" class="btn btn-primary btn-sm">
  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
  </button>
  </p>
  </form>
  <?php
  if ($jmldata==0) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<b>Data tidak ditemukan atau berada diluar kewenangan anda</b>';
    echo '</div>';
  } else { // jika data ditemukan
    echo '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<b>Ditemukan '.$jmldata.' Data PPPK</b><br />';
    echo '</div>';
  ?>
    <table class="table table-condensed table-hover">
      <tr class='info'>
        <td align='center'><b>No</b></td>
          <td align='center' colspan='2' width='230'><b>NIP PPPK<br/><u>NAMA</u></b></td>
          <td align='center'><b>Golongan Ruang<br /><u>TMT Golru</u></b></td>
          <td align='center'><b>Jabatan<br/>Unit Kerja</b></td>
          <td align='center' colspan='3'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($datapppk as $v):          
          ?>
          <tr>
          <td width='10' align='center'><?php echo $no.'.'; ?></td>
          <td>
          <?php echo $v['nipppk']; ?><br />
          <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk']); ?></td>
          <td align='center' width='50'>         

          <?php        
          $lokasiphoto='./photononpns/';
          $filephoto=$v['photo'];

          if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
            echo "<img src='../photononpns/$filephoto' width='48' height='64' alt='$v[nipppk].jpg'";
          } else {
            echo "<img src='../photononpns/nophoto.jpg' height='64' alt='no image'";
          }
          ?>
          </td>
          <td width='140' align='center'>
            (<b><?php echo $v['nama_golru']; ?></b>)
            <br />
            <i><?php echo tgl_indo($v['tmt_golru_pppk']); ?></i>
          </td>

          <td>
            <?php echo $v['nama_jabft'];?><br />
            <?php echo $v['nama_unit_kerja'];?>        
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../pppk/detail'>";          
            echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$v[nipppk]'>";
            ?>
            <button type="submit" class="btn btn-success btn-xs ">
            <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span>
            <br /> Detail
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
        </tr>
        <?php
          $no++;
        endforeach;
        echo "</div>"; // div scrolbar
        echo "</div>"; // div panel-info
        echo "</div>"; // div body
        echo "</div>"; // div panel
        ?>
    </table>
  <?php
  // tutup else if jika data ditemukan
  }
  ?>
</div>
</div>
</div>
</center>