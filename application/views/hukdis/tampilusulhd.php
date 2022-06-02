<script type="text/javascript">
  $(document).ready(function () {
    $('.tanggal1').datepicker({
      format: "dd-mm-yyyy",
      todayHighlight: true,
      clearBtn: true,
      autoclose:true
    });
  });

  //validasi textbox khusus angka
  function validAngka(a)
  {
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }

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

  function showtambahhukdis(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahhukdis";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedTambahhd;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function showIsitambahhd(nip, id)
      {
        xmlhttp=GetXmlHttpObject();
        if (xmlhttp==null)
        {
          alert ("Browser does not support HTTP Request");
          return;
        }
        var url="showIsitambahhd";
        url=url+"?nip="+nip;                
        url=url+"&id="+id;        
        url=url+"&sid="+Math.random();
        xmlhttp.onreadystatechange=stateChangedIsitambahhd;
        xmlhttp.open("GET",url,true);
        xmlhttp.send(null);
      }

  function stateChangedTambahhd(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampil").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampil").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 

  function stateChangedIsitambahhd(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilisi").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilisi").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }

</script>

<center>  
  <div class="panel panel-info" style="width: 80%">
    <div class="panel-body">
      <?php
      echo "<form method='POST' action='../home'>";          
      ?>
      <p align="right">
        <button type="submit" class="btn btn-info btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
        </button>
      </p>
      <?php
      echo "</form>";          
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

      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
          <?php
          echo '<b>LAPOR HUKUMAN DISIPLIN</b><br />';
          ?>
        </div>

        <table class="table">
          <tr>
            <td align='center'>
              <div id='tampil'>            
              <?php
                  //cek priviledge session user -- edit_profil_priv
              if ($this->session->userdata('edit_profil_priv') == "Y") { 
                ?>
                <table class='table table-condensed' action=''>
                  <tr>
                    <td align='right' width='50'>
                      <form method="POST" name='ftambahhukdis'>                                                    
                        <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                        <button type='button' class="btn btn-success btn-sm" onClick='showtambahhukdis(ftambahhukdis.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbspTambah Hukdis</button>
                      </form>
                    </td>
                  </tr>
                </table>
                <?php
              }
              ?>
              </div>

              <table class='table table-hover table-condensed'>
                <tr class='info'>
                  <th width='20'><center>#</center></th>
                  <th width='200'><center>NIP / Nama</center></th>
                  <th width='300'><center>Jenis Hukuman<br/><u>Ketentuan yang dilanggar</u></center></th>
                  <th width='100'><center>TMT Hukuman<br/><u>Status Laporan</u></center></th>
                  <th colspan='3' width='5%'><center>Aksi</center></th>
                </tr>
                <?php
                $no=1;
                foreach($usulhd as $v):              
                $nip=$v['nip'];      
                ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>
                    <td><?php echo 'NIP. ',$v['nip'], '<br />', $this->mpegawai->getnama($v['nip']) ?></td>
                    <?php
                    $jnshd = $this->mhukdis->getjnshukdis($v['fid_jenis_hukdis']);
                    $peruu = $this->mhukdis->getperuu($v['fid_peruu']);
                    $tingkat = $this->mhukdis->gettingkathukdis($v['fid_jenis_hukdis']);

                    if ($tingkat == 'RINGAN') {
                      $fcolor = 'green';
                    } else if ($tingkat == 'SEDANG') {
                      $fcolor = 'orange';
                    } else if ($tingkat == 'BERAT') {
                      $fcolor = 'red';
                    }
                    ?>
                    <td><?php echo "<center style='color:$fcolor'><b>".$jnshd."</b></center>".$peruu; ?></td>
                    <?php
                      if ($v['status'] == 'NO VALID') {
                        $ket ='Tunggu Validasi';
                        $color = 'default';  
                      } else if ($v['status'] == 'VALID') {
                        $ket ='Setuju'; 
                        $color = 'info'; 
                      } else if ($v['status'] == 'CETAK SK') {
                        $ket ='Cetak SK';  
                        $color = 'success';
                      } else if ($v['status'] == 'SELESAI') {
                        $ket ='Selesai'; 
                        $color = 'default'; 
                      }
                    
                    echo "<td align='center'>".tgl_indo($v['tmt_hukuman'])."<h5><span class='label label-".$color."'>".$ket."</span></h5></td>";
                    ?>

                    <td align='center'>
                      <form method="POST" action='../hukdis/detailhd'>
                        <?php          
                        if ($this->session->userdata('edit_profil_priv') == "Y") { 
                          echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                          echo "<input type='hidden' name='tmt' id='tmt' value='$v[tmt_hukuman]'>";
                          echo "<input type='hidden' name='jnshd' id='jnshd' value='$v[fid_jenis_hukdis]'>";
                          ?>
                          <button type='submit' class="btn btn-success btn-sm">
                          <span class="glyphicon glyphicon-search" aria-hidden="true"></span><br/>&nbspDetail</button>
                        <?php
                        }
                        ?>
                        </form>
                    </td>
                    <td align='center'>                      
                        <?php          
                        if ($v['status'] == 'NO VALID') { 
                          echo "<form method='POST' action='../hukdis/edithd'>";
                          echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                          echo "<input type='hidden' name='tmt' id='tmt' value='$v[tmt_hukuman]'>";
                          echo "<input type='hidden' name='jnshd' id='jnshd' value='$v[fid_jenis_hukdis]'>";
                          ?>
                          <button type='submit' class="btn btn-warning btn-sm">
                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbspEdit&nbsp</button>
                          </form>
                        <?php
                        } else if ($v['fid_jenis_hukdis'] == '01') {
                          echo "<form method='POST' action='../hukdis/cetakskhd' target='_blank'>";
                          echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                          echo "<input type='hidden' name='tmt' id='tmt' value='$v[tmt_hukuman]'>";
                          echo "<input type='hidden' name='jnshd' id='jnshd' value='$v[fid_jenis_hukdis]'>";
                          ?>
                          <button type='submit' class="btn btn-info btn-sm">
                          <span class="glyphicon glyphicon-print" aria-hidden="true"></span><br/>&nbspCetak SK&nbsp</button>
                          </form>
                        <?php
                        }
                        ?>
                    </td>

                    <td align='center'>
                        <form method='POST' action='../hukdis/hapus_usul'>
                          <?php
                          if ($v['status'] == 'NO VALID') {  
                            echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
                            echo "<input type='hidden' name='tmt' id='tmt' value='$v[tmt_hukuman]'>";
                            echo "<input type='hidden' name='jnshd' id='jnshd' value='$v[fid_jenis_hukdis]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>&nbspHapus
                            </button>
                          <?php
                        }
                        ?>
                        </form>                      
                    </td>  
                  </tr>
                  <?php
                  $no++;
                  endforeach;
                  ?>
                </table> 
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </center>

