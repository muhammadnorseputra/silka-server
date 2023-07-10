<script type="text/javascript">
  function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
    {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }   

  function showuploadtakah(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showuploadtakah";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedTakah;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedTakah(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("takah").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("takah").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
</script>


<center>
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
 

  <div class="panel panel-default" style="width: 70%">
    <div class="panel-body">

     <?php
     echo "<form method='POST' action='../pegawai/detail'>";          
     echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
     ?>
     <p align="right">
      <button type="submit" class="btn btn-danger btn-sm">
        <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
      </button>
    </p>
    <?php
    echo "</form>";          
    ?>

    <?php
    if (($this->session->userdata('level') == "PNS") OR ($this->session->userdata('edit_profil_priv') == "Y")) {
      ?>
      <div id='takah' align='right'>
        <form method="POST" name='uploadtakah'>
          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' >
          <button type="submit" class="btn btn-info btn-outline btn-sm" onClick='showuploadtakah(uploadtakah.nip.value)' >
            <i class="fa fa-files-o fa-fw"></i></span> Upload Dokumen
          </button>
        </form>
      </div>      
      <?php
    }
    ?>

    <br/>
    
    <div class="panel panel-info">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-star" aria-hidden="true"></span>        
        <?php
        echo '<b>DOKUMEN ELEKTRONIK</b><br />';
        echo $this->mpegawai->getnama($nip);
        echo " ::: ".$nip
        ?>
      </div>
      
      <!--
      <div style="padding:3px;overflow:auto;width:99%;height:390px;border:1px solid white" >
        <table class="table table-bordered">
          <tr>
            <td colspan='2' align='center'>                            
              <table class='table table-condensed table-hover'>
                <tr class='warning'>
                  <th width='300'>Dokumen</th>
                  <th width='500'>Di Upload Oleh</th>
                  <th colspan='2'><center>Aksi</center></th>
                </tr>
                <?php
                //$no=1;
                //foreach($rwytakah as $v):     
                  //$namatakah = $this->mtakah->getjnstakah($v['fid_jenis_takah']);               
                  ?>
                  <tr>
                  <td align='left'><?php //echo $namatakah?></td>
                  <?php
                    //$thn = substr($v['upload_at'], 0, 10);
                    //$jam = substr($v['upload_at'], 11, 8);

                    //$tglindo = tgl_indo($thn);
                  ?>
                  <td align='left'>
                    <?php 
                      //echo $this->mpegawai->getnama($v['upload_by']).' pada tanggal '.$tglindo.' jam '.$jam;
                    ?>
                  </td>
                  <td align='right'>
                      <?php
                      //$lokasifile = './fileperso/';
                      //$namafile = $v['file'];
                      //if (file_exists ($lokasifile.$namafile)) {
                        //  echo "<div>";
                        //  echo "<a class='btn btn-warning btn-outline btn-xs' href='../fileperso/$namafile' role='button' target='_blank'><i class='fa fa-download fa-fw'></i><br/>Download</a>";  
                    //  }
                      ?>
                  </td>
                  <td align='left'>
                      <form method='POST' action='../takah/hapustakah_aksi'>
                            <?php
                          //  echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                          //  echo "<input type='hidden' name='fidjenis' id='fidjenis' value='$v[fid_jenis_takah]'>";
                          //  echo "<input type='hidden' name='file' id='file' value='$v[file]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-outline btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                            </button>
                          </form>
                  </td>
                </tr>
                <?php
                //$no++;
                //endforeach;
                ?>
              </table>
            </td>
          </tr>
        </table>  
      </div>
      -->
      
     
      <div style="padding:20px;overflow:auto;width:99%;height:450px;border:1px solid white" >
      <ul class="timeline">
        
        <?php
        $no=1;
        foreach($rwytakah as $v):
          //$karakter = '12345';
          $pos = rand(1, 5);
          if ($pos % 2 == 1) {
            $jns = 'timeline';
          } else if ($pos % 2 == 0) {
            $jns = 'timeline-inverted';
          } 

          if ($pos / 1 == 1) {
            $warna = 'info';
          } else if ($pos / 2 == 1) {
            $warna = 'warning';
          } else if ($pos / 3 == 1) {
            $warna = 'info';
          } else if ($pos / 4 == 1) {
            $warna = 'success';
          } else if ($pos / 5 == 1) {
            $warna = 'danger';
          }

          $namatakah = $this->mtakah->getjnstakah($v['fid_jenis_takah']);
          $thn = substr($v['upload_at'], 0, 10);
          $jam = substr($v['upload_at'], 11, 8);

          $tglindo = tgl_indo($thn);

          if ($v['fid_jenis_takah'] == 1) {
            $icon = 'fa fa-user';
          } else if ($v['fid_jenis_takah'] == 2) {
            $icon = 'fa fa-bookmark';
          } else if ($v['fid_jenis_takah'] == 3) {
            $icon = 'fa fa-home';
          } else if ($v['fid_jenis_takah'] == 4) {
            $icon = 'fa fa-credit-card';
          } else if ($v['fid_jenis_takah'] == 5) {
            $icon = 'fa fa-institution';
          } else if ($v['fid_jenis_takah'] == 6) {
            $icon = 'fa fa-heart';
          } else if ($v['fid_jenis_takah'] == 7) {
            $icon = 'fa fa-child';
          } else if ($v['fid_jenis_takah'] == 8) {
            $icon = 'fa fa-credit-card';
          }

          ?>
          <li class="<?php echo $jns; ?>">
            <div class="timeline-badge <?php echo $warna; ?>"><i class="<?php echo $icon; ?>"></i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <table class="table table-condensed">
                  <tr>
                    <td align='left' width='300'>
                      <h4 class="timeline-title"><i class='fa fa-file-pdf-o'></i>&nbsp<?php echo $namatakah; ?></h4>                      
                    </td>
                    <td align='right'>
                      <?php
                      $lokasifile = './fileperso/';
                      $namafile = $v['file'];
                      if (file_exists ($lokasifile.$namafile)) {
                          echo "<div>";
                          echo "<a class='btn btn-warning btn-outline btn-xs' href='../fileperso/$namafile' role='button' target='_blank'><i class='fa fa-download fa-fw'></i>Download</a>";  
                      }
                      ?>
                    </td>
                    <td align='right'>
                      <form method='POST' action='../takah/hapustakah_aksi'>
                            <?php
                              echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                              echo "<input type='hidden' name='fidjenis' id='fidjenis' value='$v[fid_jenis_takah]'>";
                              echo "<input type='hidden' name='file' id='file' value='$v[file]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-outline btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Hapus
                            </button>
                          </form>
                    </td>
                  </tr>
                  </table>
                      
                </div>
                <div class="timeline-body" align='left'>
                  <i class="fa fa-clock-o"></i><small class="text-muted"> Diupload oleh<br/><?php echo $this->mpegawai->getnama($v['upload_by']).' pada '.$tglindo.' jam '.$jam; ?> </small>
                    
                </div>              
              </div>
            </li>
            <?php
            $no++;
            endforeach;
            ?>
      </ul>
    </div>

    </div>
  </div> 
</div>
</center>