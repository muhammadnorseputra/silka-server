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

  //function showtambahsutri(nip) {
  //$.ajax({
  //  type: "POST",
  //  url: "<?php echo site_url('pegawai/showtambahsutri'); ?>",
  //  data: "nip="+nip,
  //  success: function(data) {
  //    $("#datasutri").html(data);
  //  },
  //  error:function (XMLHttpRequest) {
  //    alert(XMLHttpRequest.responseText);
  //  }
  //  })
  //};

  function showtambahsutri(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahsutri";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedSutri;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedSutri(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("datasutri").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("datasutri").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
  

  //function showtambahanak(nip) {
  //$.ajax({
  //  type: "POST",
  //  url: "<?php echo site_url('pegawai/showtambahanak'); ?>",
  //  data: "nip="+nip,
  //  success: function(data) {
  //    $("#dataanak").html(data);
  //  },
  //  error:function (XMLHttpRequest) {
  //    alert(XMLHttpRequest.responseText);
  //  }
  //  })
  //};

  
  function showtambahanak(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahanak";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedAnak;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedAnak(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("dataanak").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("dataanak").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
  
</script>

<center>  
  <div class="panel panel-info" style="width: 80%">
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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT KELUARGA</b><br />';
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
              <?php
              $jnskel = $this->mpegawai->getjnskel($nip);
              if ($jnskel == 'LAKI-LAKI') {
                echo "<li class='active'><a href='#sutri' data-toggle='tab'>ISTRI</a></li>";
              } else if ($jnskel == 'PEREMPUAN') {
                echo "<li class='active'><a href='#sutri' data-toggle='tab'>SUAMI</a></li>";
              }
              ?>
              <li><a href="#anak" data-toggle="tab">ANAK</a></li>
            </ul>

            <!-- Tab panes, ini content dari tab di atas -->
            <div class="tab-content">
              <div class="tab-pane face in active" id="sutri">
                <br />
                <?php
                  //cek priviledge session user -- edit_profil_priv
                if ($this->session->userdata('edit_profil_priv') == "Y") { 
                ?>
                  <div id='datasutri'>
                    <table class='table table-condensed' action=''>
                      <tr>
                        <td align='right' width='50'>
                          <form method="POST" name='tambahsutri'>                                                    
                            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                            <button type='button' class="btn btn-info btn-sm" onClick='showtambahsutri(tambahsutri.nip.value)' >
                              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                              <?php 
                              $jnskel = $this->mpegawai->getjnskel($nip);
                              if ($jnskel == 'LAKI-LAKI') {
                                echo "Tambah Istri";
                              } else if ($jnskel == 'PEREMPUAN') {
                                echo "Tambah Suami";
                              }
                              ?>
                            </button>
                          </form>
                        </td>
                      </tr>
                    </table>
                  </div> <!-- tutup div=sutri-->      
                  <?php
                }
                ?>

                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                <div class="panel panel-info">
                  <?php
                  $jnskel = $this->mpegawai->getjnskel($nip);
                  if ($jnskel == 'LAKI-LAKI') {
                    echo "<div class='panel-heading'><b>ISTRI</b></div>";
                  } else if ($jnskel == 'PEREMPUAN') {
                    echo "<div class='panel-heading'><b>SUAMI</b></div>";
                  }
                  ?>
                  <table class='table table-condensed table-hover'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='250'><center>Nama</center></th>
                      <th width='250'><center><u>Tgl. Nikah</u><br />No. Akta Nikah</center></th>
                      <th align='100'><center><u>Tmp. Lahir</u><br />Tgl. Lahir</center></th>
                      <th width='150'><center>Pekerjaan</center></th>
                      <th width='250'><center><u>Status Kawin</u><br />Status Hidup<br />Tanggungan</center></th>
                      <th width='250'><center><u>Tgl. Cerai</u><br />Akta Cerai</center></th>
                      <th width='250'><center><u>Tgl. Meninggal</u><br />Akta Meninggal</center></th>
                      <th width='150' colspan='2'><center>Aksi</center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwyst as $v):                    
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td><?php echo $v['nama_sutri']; ?></td>
                      <td><?php echo '<u>'.tgl_indo($v['tgl_nikah']).'</u><br />'.$v['no_akta_nikah']; ?></td>
                      <td><?php echo '<u>'.$v['tmp_lahir'].'</u><br />'.tgl_indo($v['tgl_lahir']); ?></td>
                      <?php
                      if ($this->mpegawai->getnama($v['nip_sutri']) == '') {
                        echo '<td>'.$v['pekerjaan'].'</td>';
                      }else {
                        echo '<td align=center><img src=../photo/'.$v['nip_sutri'].'.jpg width=60 height=80>';

                        echo "<form method='POST' action='../pegawai/detail'>";          
                        echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$v[nip_sutri]'>";
                        echo "<button type='submit' class='btn btn-success btn-xs'>";
                        echo "<span class='glyphicon glyphicon glyphicon-user' aria-hidden='true'></span> Detail</button>";
                        echo "</form></td>";
                      }

                      if (($v['tgl_cerai'] != '0000-00-00') AND ($v['tgl_cerai'] != null)) {
                        $tglcerai = tgl_indo($v['tgl_cerai']);
                      } else {
                        $tglcerai = '';
                      }

                      if (($v['tgl_meninggal'] != '0000-00-00') and ($v['tgl_meninggal'] != null))  {
                        $tglmeninggal = tgl_indo($v['tgl_meninggal']);
                      } else {
                        $tglmeninggal = '';
                      }

                      ?>


                      <td><?php echo '<u>'.$v['status_kawin'].'</u><br /> Status Hidup : '.$v['status_hidup'].'<br/>Tanggungan : '.$v['tanggungan']; ?></td>
                      <td><?php echo '<u>'.$tglcerai.'</u><br />'.$v['no_akta_cerai']; ?></td>
                      <td><?php echo '<u>'.$tglmeninggal.'</u><br />'.$v['no_akta_meninggal']; ?></td>
                      <td align='center' width='30'>
                        <form method='POST' name='editsutri' action='../pegawai/editsutri'>
                          <?php          
                          if ($this->session->userdata('edit_profil_priv') == "Y") { 

                            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                            echo "<input type='hidden' name='sutri_ke' id='sutri_ke' value='$v[sutri_ke]'>";
                            echo "<input type='hidden' name='tgl_nikah' id='tgl_nikah' value='$v[tgl_nikah]'>";
                            ?>
                            <button type='submit' class="btn btn-warning btn-xs" >
                              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                            </button>
                          </form>
                      </td>
		      <td align='center' width='30'>
                          <form method='POST' action='../pegawai/hapussutri_aksi'>
                            <?php
                            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                            echo "<input type='hidden' name='sutri_ke' id='sutri_ke' value='$v[sutri_ke]'>";
                            echo "<input type='hidden' name='tgl_nikah' id='tgl_nikah' value='$v[tgl_nikah]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                            </button>
                          </form>
                          <?php
                        }
                        ?>
                      </td>  
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>
                </div>            
              </div> <!-- akhir konten tab sutri -->

              <div class="tab-pane" id="anak">
                <br />
                <?php
                  //cek priviledge session user -- edit_profil_priv
                if ($this->session->userdata('edit_profil_priv') == "Y") { 
                ?>
                  <div id='dataanak'>
                    <table class='table table-condensed' action=''>
                      <tr>
                        <td align='right' width='50'>
                          <form method="POST" name='tambahanak'> 
                            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                            <button type='button' class="btn btn-info btn-sm" onClick='showtambahanak(tambahanak.nip.value)' >
                              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbspTambah Anak                           
                            </button>
                          </form>
                        </td>
                      </tr>
                    </table>
                  </div> <!-- tutup div=sutri-->      
                  <?php
                }
                ?>
                <div class="panel panel-info">
                  <div class="panel-heading"><b>ANAK</b></div>
                  <table class='table table-condensed table-hover'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='250'><center>Nama</center></th>
                      <?php
                      if ($jnskel == 'LAKI-LAKI') {
                        echo '<th align=250><center>Nama Ibu</center></th>';
                      } else if ($jnskel == 'PEREMPUAN') {
                        echo '<th align=250><center>Nama Bapak</center></th>';
                      }
                      ?>                    
                      <th align='30'><center>Jenis Kelamin</center></th>
                      <th width='200'><center><u>Tempat Lahir</u><br />Tgl. lahir</center></th>
                      <th width='150'><center><u>Status Anak</u><br />Status Hidup<br/>Tanggungan</center></th>
                      <th width='100' colspan='2'><center>Aksi</center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwyanak as $v):                    
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td><?php echo $v['nama_anak']; ?></td>
                      <td><?php echo $this->mpegawai->getnamasutri($nip,$v['fid_sutri_ke']); ?></td>
                      <td><?php echo $v['jns_kelamin']; ?></td>
                      <td><?php echo '<u>'.$v['tmp_lahir'].'</u><br />'.tgl_indo($v['tgl_lahir']); ?></td>
                      <td><?php echo '<u>'.$v['status'].'</u><br /> Status Hidup : '.$v['status_hidup'].'<br/>Tanggungan : '.$v['tanggungan']; ?></td>
                      <td align='center' width='30'>
                        <form method='POST' name='editsutri' action='../pegawai/editanak'>
                          <?php          
                          if ($this->session->userdata('edit_profil_priv') == "Y") { 

                            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                            echo "<input type='hidden' name='nama_anak' id='nama_anak' value='$v[nama_anak]'>";
                            echo "<input type='hidden' name='tgl_lahir' id='tgl_lahir' value='$v[tgl_lahir]'>";
                            ?>
                            <button type='submit' class="btn btn-warning btn-xs" >
                              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                            </button>
                          </form>
                      </td>
		      <td align='center' width='30'>
                          <form method='POST' action='../pegawai/hapusanak_aksi'>
                            <?php
                            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                            echo "<input type='hidden' name='nama_anak' id='nama_anak' value='$v[nama_anak]'>";
                            echo "<input type='hidden' name='tgl_lahir' id='tgl_lahir' value='$v[tgl_lahir]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                            </button>
                          </form>
                          <?php
                        }
                        ?>
                      </td>  
                    </tr>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                  </table>                  
                </div>            
              </div> <!-- akhir konten tab anak -->
            </div> <!-- akhir konten tab-content -->
          </td>
        </tr>
      </table>
  </div> <!-- akhir panel body-->
</div> <!-- akhir panel -->
</div>
</center>
