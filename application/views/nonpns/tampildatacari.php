<!-- Default panel contents -->
  <center>
  <div class="panel panel-default"  style="width: 80%">
  <div class="panel-body">
  
  <form method="POST" action="../nonpns/tampilunker">
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
    echo '<b>Ditemukan '.$jmldata.' Data Non PNS</b><br />';
    echo '</div>';
  ?>
    <table class="table table-condensed table-hover">
      <tr class='info'>
        <td align='center'><b>No</b></td>
          <td align='center' colspan='2' width='230'><b>NIK<br/><u>NAMA</u></b></td>
          <td align='center'><b>Jenis Non PNS<br /><u>Sumber Gaji</u></b></td>
          <td align='center'><b>Jabatan<br/>Unit Kerja</b></td>
          <td align='center'><b>Status<br/>Dokumen</b></td>
          <td align='center' colspan='3'><b>Aksi</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($nonpnstnp as $v):          
          ?>
          <tr>
          <td width='10' align='center'><?php echo $no.'.'; ?></td>
          <td>
          <?php echo $v['nik']; ?><br />
          <?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_blk']); ?></td>
          <td align='center' width='50'>         

          <?php        
          $lokasiphoto='./photononpns/';
          $filephoto=$v['photo'];

          if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
            echo "<img src='../photononpns/$filephoto' width='48' height='64' alt='$v[nik].jpg'";
          } else {
            echo "<img src='../photononpns/nophoto.jpg' height='64' alt='no image'";
          }
          ?>
          </td>
          <td width='140' align='center'>
            <?php echo $this->mnonpns->getjnsnonpns($v['fid_jenis_nonpns']); ?>
            <br />
            <u><?php echo $this->mnonpns->getsumbergaji($v['fid_sumbergaji']); ?></u>
          </td>

          <td>
            <?php echo $v['nama_jabnonpns'];?><br />
            <?php echo $v['nama_unit_kerja'];?>        
          </td>
          <td align='right' width='100'>
           <?php
            $lokasiphoto='./photononpns/';
            $filephoto=$v['photo'];
            if ((file_exists ($lokasiphoto.$filephoto)) AND ($filephoto != '')) {
              echo "<h5><span class='label label-info'>
                    <span class='glyphicon glyphicon-ok' aria-hidden='true'>
                    </span> Photo Ada
                    </span></h5>";
            } else {
              echo "<h5><span class='label label-danger'>
                    <span class='glyphicon glyphicon-remove' aria-hidden='true'>
                    </span> Photo Tidak Ada
                    </span></h5>";
            }

            $lokasiberkas='./filenonpns/';
            $fileberkas=$v['berkas'];
            if ((file_exists ($lokasiberkas.$fileberkas)) AND ($fileberkas != '')) {
              echo "<h5><span class='label label-info'>
                    <span class='glyphicon glyphicon-ok' aria-hidden='true'>
                    </span> Berkas Ada
                    </span></h5>";
            } else {
              echo "<h5><span class='label label-danger'>
                    <span class='glyphicon glyphicon-remove' aria-hidden='true'>
                    </span> Berkas Tidak Ada
                    </span></h5>";
            }
            ?>
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../nonpns/nonpnsdetail'>";          
            echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
            ?>
            <button type="submit" class="btn btn-success btn-xs ">
            <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span>
            <br /> Detail
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
        <?php
        if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') != "TAMU")) { 
        ?>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../nonpns/editnonpns'>";          
            echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
            ?>
            <button type="submit" class="btn btn-warning btn-xs ">
            <span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span>
            <br />&nbspEdit&nbsp
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
          <td align='center' width='50'>
            <?php
            echo "<form method='POST' action='../nonpns/hapusnonpns'>";          
            echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$v[nik]'>";
            ?>
            <button type="submit" class="btn btn-danger btn-xs ">
            <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
            <br /> Hapus
            </button>
            <?php
              echo "</form>";
            ?>
          </td>
        <?php
        }
        ?>
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