<!-- Default panel contents -->
<?php
if ($nmunker == '')
{     
?>
    <center>
    <div class="panel panel-default" style="width: 50%">
        <div class="panel-body">
           <div class="alert alert-danger alert-dismissible" role="alert">              
              <b>Kesalahan...</b><br />Silahkan pilih unit kerja terlebih dahulu
            </div>  
          <button type="button" class="btn btn-success btn-sm" onclick="history.back(-1)">
          <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Kembali</button>
        </div>
        </div>
    </center>
  <?php
}else
{
?>
  <center>
  <div class="panel panel-default"  style="width: 80%">
  <div class="panel-body">
  
  <form method="POST" action="../home/tampilunker">
  <p align="right">
  <button type="submit" class="btn btn-primary btn-sm">
  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
  </button>
  </p>
  </form>

  <div class="panel panel-info">  
  <div class="panel-heading" align="left"><b><?php echo $nmunker ?></b><br />
  <?php echo "Jumlah ASN : ".$jmlpeg ?>
  </div>
  
  <table class="table table-bordered">
      <tr>
        <td align='center'><b>No</b></td>
        <td align='center'><b>NIP</b></td>
        <td align='center' colspan='2'><b>Nama</b></td>
        <td align='center'><b>Golongan Ruang</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center'><b>Aksi</b></td>
      </tr>
      <?php
        $no = 1;
        foreach($peg as $v):
      ?>
      <tr>
        <td width='10' align='center'><?php echo $no; ?></td>
        <td width='150'><?php echo $v['nip']; ?></td>
        <td><?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></td>
        <td align='center'>         

        <?php
        //echo "<img src='../photo/$v[nip].jpg' width='60' height='80' alt='$v[nip].jpg'>";
        //$filename = '../photo/'.$v['nip'].'.jpg';
        
        $url = base_url();
        $filename = "$url/photo/$v[nip].jpg";

        if (file_exists($filename)) {
          //echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'";
          echo "<img src='../photo/noimage.jpg' width='60' height='80' alt='no image'";
        } else {
          echo "<img src='$filename' width='60' height='80' alt='$v[nip].jpg'";
          //echo "<img src='../photo/noimage.jpg' width='60' height='80' alt='no image'";
        }   
        ?>         

        </td>
        <td width='140' align='center'>
          <?php echo $v['nama_golru'];?>
          <br />
          <?php echo 'TMT : ',tgl_indo($v['tmt_golru_skr']); ?>
        </td>
        <!--<td><?php //echo $v['nama_jabatan']; ?></td> -->

        <td>
        <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }

          echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab); 
        ?>          
        </td>
        <td align='center'>
          <?php
          echo "<form method='POST' action='../pegawai/detail'>";          
          echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-success btn-xs ">
          <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span> Detail
          </button>
          <?php
            echo "</form>";
          ?>
        </td>
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>
</div>
</div>
</div>
</center>
<?php
}
?>
