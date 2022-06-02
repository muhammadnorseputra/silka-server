<!-- Default panel contents -->
<?php
if ($pesan != '') {
  ?>
  <div class="<?php echo $jnspesan; ?>" alert-info role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php
    echo $pesan;
    ?>          
  </div> 
  <?php
}
?>

<center>
  <div class="panel panel-default" style="width:99%;height:640px;border:0px solid white">
    <div class="panel-body">

      <div class="panel panel-success" style="padding:1px;width:90%;height:610px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
          <b>UPDATE PHOTO</b>
          <br/>
          <?php echo $this->mpegawai->getnama($nip)." ::: ".$nip; ?>
        </div>       

        <table class="table table-condensed">
          <tr>      
            <td>
              <form method='POST' action='../pegawai/detail'>
                <?php
                echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
                ?>
                <p align="right">
                  <button type="submit" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                  </button>
                </p>
              </form>
            </td>
          </tr>
        </table>
    
          <div class="row">
            <div class="col-sm-1 col-md-1"></div>
            <div class="col-sm-5 col-md-5" class="info">
              <div>
              <?php
                  $lokasifile = './photo/';
                  $filename = "$nip.jpg";
                  if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/$nip.jpg";
                  } else {
                    $photo = "../photo/nophoto.jpg";
                  }
              ?>
              <img src='<?php echo $photo; ?>' width='120' alt='<?php echo $nip; ?>.jpg' class="img-thumbnail">
              <div class="caption" align='center'>
                SILAHKAN UPLOAD FILE UNTUK MENGGANTI PHOTO
                <br/>
                <small>
                File image yang dapat diupload harus ber-ekstensi .jpg<br/>
                dengan dimensi maksimal lebar: 250 px, tinggi: 250 px, atau ukuran file maksimal 75 Kbyte 
                </small>
                <div class="row">
                  <form action="<?=base_url()?>upload/updatephoto" method="post" enctype="multipart/form-data">                    
                    <div class="col-sm-8 col-md-8" align="right">
                      <input type="file" name="filephoto" class="btn btn-sm btn-info"> 
                    </div>
                    <div class="col-sm-4 col-md-4" align="left">
                      <input type='hidden' name='nip' id='nip' maxlength='20' value='<?php echo $nip; ?>'>
                      <button type="submit" value="upload" class="btn btn-sm btn-success">
                        <span class="glyphicon glyphicon-upload" aria-hidden="false"></span>&nbspProses
                      </button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
          <?php
            $rwy = $this->mpegawai->rwyupdate($nip)->result_array();
            if ($rwy)
            {
          ?>
          <div class="col-sm-5 col-md-5">
            <div class="panel panel-default">
            <div class="panel-heading">
            <?php
                echo "UPDATE PHOTO YANG PERNAH DIUSULKAN<br/>";
		/*	
                $lokasifile = './photo_temp/';
                $filename = "$nip.jpg";
                if (file_exists ($lokasifile.$filename)) {
                  $photo = "../photo_temp/$nip.jpg";
                } else {
                  $photo = "../photo_temp/nophoto.jpg";
                }
		echo "<img src='$photo' width='120' alt='' class='img-thumbnail'><br/>";
		*/

		$imgblob =  'data:image/jpeg;base64,'.base64_encode( $this->mpegawai->show_photo_pegawai($nip));
		echo "<img src='$imgblob' width='120' class='img-thumbnail'>";

		//echo getImage(100,100, $this->mpegawai->show_photo_pegawai($nip));
		echo "<br/>Diusulkan oleh : ";
		

                $rwy = $this->mpegawai->rwyupdate($nip)->result_array();
                if ($rwy) {
                  foreach($rwy as $v):
                    echo $this->mpegawai->getnama($v['entry_by']);
                    echo "<br/>pada ".tglwaktu_indo($v['entry_at']);
                    //echo "<br/>Status Usulan :";
                    if ($v['approved'] == "TIDAK") {
                      echo "<h5><span class='label label-info'>Status : BELUM DISETUJUI</span></h5>";
                    } else if ($v['approved'] == "YA") {
                      echo "<h5><span class='label label-success'>Status : DISETUJUI</span></h5>";
                    } else if ($v['approved'] == "DITOLAK") {
                      echo "<h5><span class='label label-warning'>Status : DITOLAK</span></h5>";
                    }
                  endforeach;
                }
            ?>  
          </div> <!-- end col -->
          </div> <!-- end panel -->
          </div> <!-- end panel-heading -->
          <?php
          }
          ?>
          <div class="col-sm-1 col-md-1"></div>
          </div> <!-- End Row -->
      </div>
    </div>
  </div>
</center>
