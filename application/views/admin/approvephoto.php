<!-- Default panel contents -->
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-info">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
  <center>
  <div class="panel panel-default"  style="width: 70%;">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-outline btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 
  
  <div class="panel panel-danger">  
  <div class="panel-heading" align="left">
  <b>Approve Usulan Ganti Photo</b><br />
  
  </div>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='danger'>
        <td align='center' width='30'>No.</td>
        <td align='center' width='500'>Identitas</td>
        <td align='center' width='80'>Foto Lama</td>
        <td align='center' width='80'>Foto Baru</td>
        <td align='center' colspan='3'>Aksi</td>
      </tr>
      <?php
        $no = 1;
        foreach($data as $v):          
      ?>
      <tr>    
        <td align='center'><?php echo $no; ?></td>
        <td>
          <?php
            echo 'NIP. '.$v['nip'].' | '.$this->mpegawai->getnama($v['nip']);
            echo "<br/>";
            echo $this->munker->getnamaunker($this->mpegawai->getfidunker($v['nip']));
            echo '<br/><small>Diupload oleh <b>'.$this->mpegawai->getnama($v['entry_by']).'</b> pada <u>'.tglwaktu_indo($v['entry_at']).'</u></small>';
            
          ?>
        <td>
        <?php
          $lokasifile = './photo/';
          $filename = $v['nip'].".jpg";

          if (file_exists ($lokasifile.$filename)) {
            $photo = "../photo/".$v['nip'].".jpg";
          } else {
            $photo = "../photo/nophoto.jpg";
          }

          echo "<center><img src='$photo' width='70' class='img-thumbnail'></center>";
        ?>
        <?php //echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab).'<br /><u>'.$this->munker->getnamaunker($v['fid_unit_kerja']).'</u>'; 
        ?>
        </td>
        
        <td align='center'>
        <?php
          $lokasitemp = './photo_temp/';
          $filetemp = $v['nip'].".jpg";

          if (file_exists ($lokasitemp.$filetemp)) {
            $photo_temp = "../photo_temp/".$v['nip'].".jpg";
          } else {
            $photo_temp = "../photo_temp/nophoto.jpg";
          }

          //echo "<center><img src='$photo_temp' width='70' class='img-thumbnail'></center>";
	  $imgblob =  'data:image/jpeg;base64,'.base64_encode( $this->mpegawai->show_photo_pegawai($v['nip']));
          echo "<center><img src='$imgblob' width='70' class='img-thumbnail'></center>";
          
	  $iden = get_file_info(APPPATH.$photo_temp);
          //echo $iden['name'];
          $ukuran = $iden['size'] / 1024;
          echo "<small>".round($ukuran,2)." Kbyte</small>";
          ?>    
        </td>

        <td align='center' width='20'>
          <?php          
            echo "<form method='POST' action='../admin/setujuupdatephoto_aksi'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";              
          ?>
          <button type="submit" class="btn btn-info btn-outline btn-xs">
          <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><br />Setuju<br/>&nbsp
          </button>
          </form>
        </td>
        <td align='center' width='20'>
          <?php
            echo "<form method='POST' action='../admin/tolakupdatephoto_aksi'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";              
          ?>
          <button type="submit" class="btn btn-warning btn-outline btn-xs">
          <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span><br />Tolak<br/>&nbsp
          </button>
          </form>
        </td>        
        <td  align='center' width='20'>
          <?php
            echo "<form method='POST' action='../admin/hapusupdatephoto_aksi'>";          
            echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
          ?>
          <button type="submit" class="btn btn-danger btn-outline btn-xs">
          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br />Hapus<br/>&nbsp
          </button>
          </form>
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
</div>
</center>
