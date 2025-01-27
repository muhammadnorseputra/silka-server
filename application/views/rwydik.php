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
      // code for IE6, IE5 Support
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }   

function showtambahdikjst(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahdikjst";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDikJst;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedDikJst(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("dikjst").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("dikjst").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }

function showtambahdikfung(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahdikfung";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDikFung;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedDikFung(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("dikfung").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("dikfung").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 


  function showtambahdiktek(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahdiktek";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedDikTek;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedDikTek(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("diktek").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("diktek").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
  
  // start untuk workshop
  function showtambahws(nip)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showtambahws";
    url=url+"?nip="+nip;        
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedWS;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedWS(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("workshop").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("workshop").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
  // end workshop
	
</script>

<center>  
  <div class="panel panel-info" style="width: 90%">
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
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-blackboard" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT DIKLAT</b><br />';
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
                <li><a href="#struk" data-toggle="tab">STRUKTURAL</a></li>
                <li><a href="#fung" data-toggle="tab">FUNGSIONAL</a></li>
                <li><a href="#tek" data-toggle="tab">TEKNIS</a></li>
                <li class="active"><a href="#ws" data-toggle="tab">PENGEMBANGAN KOMPETENSI LAINNYA</a></li>
	      </ul>

              <!-- Tab panes, ini content dari tab di atas -->
              <div class="tab-content">
                <div class="tab-pane" id="struk">
                <br />
                <?php
                    //cek priviledge session user -- edit_profil_priv
                    //if ($this->session->userdata('level') == "ADMIN" || $this->session->userdata('nama') == "197912292007011018") { 
                    ?>
                    <div id='dikjst'>
                    <table class='table table-condensed'>
                    <tr>
                    <td align='right' width='50'>
                      <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#entridik">+ Tambah Diklat Struktural</button>
                    </td>
                    </tr>
                    </table>
                    </div> <!-- tutup div=dikfung-->      
                    <?php
                    //}
                    ?>
                    
                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                  <div class="panel panel-default">
                    <div class="panel-heading"><b>DIKLAT STRUKTURAL</b></div>
                    <table class='table table-condensed table-hover'>
                        <tr class='warning'>
                          <th width='20'><center>#</center></th>
                          <th width='150'><center>Nama Diklat</center></th>
                          <th><center>Tahun</center></th>
                          <th width='350'><center><u>Instansi Penyelenggara</u><br />Tempat Pelaksanaan</center></th>
                          <th width='100'><center>Lama</center></th>
                          <th width='350'><center>STTPL</center></th>
                          <?php //if($this->session->userdata('level') === 'ADMIN'): ?>
                          <th width='100' colspan='2'><center>Aksi</center></th>
                          <?php //endif; ?>
                        </tr>
                        <?php
                          $no=1;
                          foreach($pegrwyds as $v):                    
                        ?>
                        <tr>
                          <td align='center'><?php echo $no;?></td>
                          <td>
				<?php
					echo $v['nama_diklat_struktural']; 
				?>
			  </td>
                          <td><?php echo $v['tahun']; ?></td>
                          <td><?php echo '<u>'.$v['instansi_penyelenggara'].'</u><br />'.$v['tempat']; ?></td>
                          <?php
                          if ($v['lama_bulan'] != 0){
                            echo '<td>'.$v['lama_bulan'].' Bulan</td>';
                          } else if ($v['lama_hari'] != 0){
                            echo '<td>'.$v['lama_hari'].' Hari</td>';
                          } else if ($v['lama_jam'] != 0){
                            echo '<td>'.$v['lama_jam'].' Jam</td>';
                          }
                          ?>
                          <td width='300'>
				<?php echo 'No. STTPL : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']).'<br />Pejabat : '.$v['pejabat_sk']; ?>
			  </td>
                          <?php //if($this->session->userdata('level') === 'ADMIN'): ?>
                          <td align='center'>
                          	<form method='POST' action='../pegawai/hapusrwydik_aksi'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-warning btn-xs">
	                    			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
	                    		</button>
	                    		</form>
                          </td>
                          <td align='center'>
                        	<form method='POST' action='../pegawai/editrwydik'>
	                    		<?php
	                    		echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
	                    		echo "<input type='hidden' name='id' id='id' value='".$v['id']."'>";
	                    		?>
	                    		<button type="submit" class="btn btn-danger btn-xs">
	                    			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><br/>Edit
	                    		</button>
	                    		</form>
                        </td>
                          <?php //endif; ?>
                        </tr>
                        <?php
                          $no++;
                          endforeach;
                        ?>
                      </table>
                  </div>            
                </div> <!-- akhir konten tab struktural -->
                
                <div class="tab-pane" id="fung">
                  <br />
                    <?php
                    //cek priviledge session user -- edit_profil_priv
                    if ($this->session->userdata('edit_profil_priv') == "Y") { 
                    ?>
                    <div id='dikfung'>
                    <table class='table table-condensed' action=''>
                    <tr>
                    <td align='right' width='50'>
                      <form method="POST" name='tambahdikfung'>                                                    
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="btn btn-success btn-sm" onClick='showtambahdikfung(tambahdikfung.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Diklat Fungsional
                          </button>
                      </form>
                    </td>
                    </tr>
                    </table>
                    </div> <!-- tutup div=dikfung-->      
                    <?php
                    }
                    ?>                    
                    
                    <div class="panel panel-info">
                        <div class="panel-heading"><b>DIKLAT FUNGSIONAL</b></div>
                        <table class='table table-condensed table-hover'>
                          <tr class='info'>
                            <th width='20'><center>#</center></th>
                            <th width='150'><center>Nama Diklat</center></th>
                            <th width='30'><center>Tahun</center></th>
                            <th width='250'><center><u>Instansi Penyelenggara</u><br />Tempat Pelaksanaan</center></th>
                            <th width='100'><center>Lama</center></th>
                            <th width='250'><center>STTPL</center></th>
                            <th width='100' colspan='2'><center>Aksi</center></th>
                          </tr>
                          <?php
                            $no=1;
                            foreach($pegrwydf as $v):                    
                          ?>
                          <tr>
                            <td align='center'><?php echo $no;?></td>
                            <td><?php echo $v['nama_diklat_fungsional']; ?></td>
                            <td><?php echo $v['tahun']; ?></td>
                            <td><?php echo '<u>'.$v['instansi_penyelenggara'].'</u><br />'.$v['tempat']; ?></td>
                            <?php
                            if ($v['lama_bulan'] != 0){
                              echo '<td>'.$v['lama_bulan'].' Bulan</td>';
                            } else if ($v['lama_hari'] != 0){
                              echo '<td>'.$v['lama_hari'].' Hari</td>';
                            } else if ($v['lama_jam'] != 0){
                              echo '<td>'.$v['lama_jam'].' Jam</td>';
                            }
                            ?>
                            <td><?php echo 'No. STTPL : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']).'<br />Pejabat : '.$v['pejabat_sk']; ?></td>
                            <td align='center' width='30'>
                              <form method='POST' name='editdikfung' action='../pegawai/editdikfung'>
                              <?php          
                              if ($this->session->userdata('edit_profil_priv') == "Y") { 
                                
                                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                                echo "<input type='hidden' name='no' id='no' value='$v[no]'>";
                                echo "<input type='hidden' name='tahun' id='tahun' value='$v[tahun]'>";
                                ?>
                                  <button type='submit' class="btn btn-warning btn-xs" >
                                  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                                  </button>
                                </form>
                            </td>
			    <td align='center' width='30'>
                                <form method='POST' action='../pegawai/hapusdikfung_aksi'>
                                <?php
                                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                                echo "<input type='hidden' name='no' id='no' value='$v[no]'>";
                                echo "<input type='hidden' name='tahun' id='tahun' value='$v[tahun]'>";
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
                    </div> <!-- end dvi panel info -->
                </div> <!-- akhir konten tab fungsional -->

                <div class="tab-pane" id="tek">
                <br />
                    <?php
                    //cek priviledge session user -- edit_profil_priv
                    if ($this->session->userdata('edit_profil_priv') == "Y") { 
                    ?>
                    <div id='diktek'>
                    <table class='table table-condensed' action=''>
                    <tr>
                    <td align='right' width='50'>
                      <form method="POST" name='tambahdiktek'>
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="btn btn-success btn-sm" onClick='showtambahdiktek(tambahdiktek.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Diklat Teknis
                          </button>
                      </form>
                    </td>
                    </tr>
                    </table>
                    </div> <!-- tutup div=diktek-->      
                    <?php
                    }
                    ?>

                  <div class="panel panel-info">
                    <div class="panel-heading"><b>DIKLAT TEKNIS</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='info'>
                          <th width='20'><center>#</center></th>
                          <th width='150'><center>Nama Diklat</center></th>
                          <th width='30'><center>Tahun</center></th>
                          <th width='350'><center><u>Instansi Penyelenggara</u><br />Tempat Pelaksanaan</center></th>
                          <th width='100'><center>Lama</center></th>
                          <th width='350'><center>STTPL</center></th>
                          <th width='100' colspan='2'><center>Aksi</center></th>
                        </tr>
                        <?php
                          $no=1;
                          foreach($pegrwydt as $v):                    
                        ?>
                        <tr>
                          <td align='center'><?php echo $no;?></td>
                          <td><?php echo $v['nama_diklat_teknis']; ?></td>
                          <td><?php echo $v['tahun']; ?></td>
                          <td><?php echo '<u>'.$v['instansi_penyelenggara'].'</u><br />'.$v['tempat']; ?></td>
                          
                          <?php
                          echo "<td align=center>";
                          if ($v['lama_bulan'] != 0){
                            echo $v['lama_bulan'].' Bulan';
                          } else if ($v['lama_hari'] != 0){
                            echo $v['lama_hari'].' Hari';
                          } else if ($v['lama_jam'] != 0){
                            echo $v['lama_jam'].' Jam';
                          } else {
                            echo '';
                          }

                          if ($v['tanggal'] != NULL) {
                          echo "<br/>".tgl_indo($v['tanggal'])."</td>";
                          } else {
                          echo "</td>";
                          }
                          ?>
			
			  <?php
			  /*
			  if ($v['lama_bulan'] != 0){
                            echo '<td>'.$v['lama_bulan'].' Bulan</td>';
                          } else if ($v['lama_hari'] != 0){
                            echo '<td>'.$v['lama_hari'].' Hari</td>';
                          } else if ($v['lama_jam'] != 0){
                            echo '<td>'.$v['lama_jam'].' Jam</td>';
                          } else {
                            echo '<td></td>';
                          }
			  */
                          ?>
                          <!--
			  <td width='300'><?php echo 'No. STTPL : '.$v['no_sk'].'<br />Tanggal : '.tgl_indo($v['tgl_sk']).'<br />Pejabat : '.$v['pejabat_sk']; ?></td>
			  -->
			  <td width='300'>
                                <?php
                                        echo "No. : ".$v['no_sk'];
                                        if ($v['tgl_sk'] != NULL) {
                                          $tglsk = tgl_indo($v['tgl_sk']);
                                        } else {
                                          $tglsk = '';
                                        }

                                        echo "<br />Tanggal : ".$tglsk."<br />Pejabat : ".$v['pejabat_sk'];
                                ?>
                          </td>


                          <td align='center' width='30'>
                            <form method='POST' name='editdiktek' action='../pegawai/editdiktek'>
                            <?php          
                              if ($this->session->userdata('edit_profil_priv') == "Y") { 
                                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                                echo "<input type='hidden' name='no' id='no' value='$v[no]'>";
                                echo "<input type='hidden' name='tahun' id='tahun' value='$v[tahun]'>";
                                ?>
                                  <button type='submit' class="btn btn-warning btn-xs" >
                                  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbsp&nbspEdit&nbsp&nbsp
                                  </button>
                                </form>
			  </td>
			  <td align='center' width='30'>
                                <form method='POST' action='../pegawai/hapusdiktek_aksi'>
                                <?php
                                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                                echo "<input type='hidden' name='no' id='no' value='$v[no]'>";
                                echo "<input type='hidden' name='tahun' id='tahun' value='$v[tahun]'>";
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
                    </div>  <!-- akhir panel info -->
                </div> <!-- akhir konten tab teknis -->
              
		<!-- awal konten tab workshop -->                
                <div class="tab-pane face in active" id="ws">
                <br />
                    <?php
                    //cek priviledge session user -- edit_profil_priv
                    if ($this->session->userdata('edit_profil_priv') == "Y") { 
                    ?>
                    <div id='workshop'>
                    <table class='table table-condensed' action=''>
                    <tr>
                    <td align='right' width='50'>
                      <form method="POST" name='tambahws'>
                          <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>' />
                          <button type='button' class="btn btn-success btn-sm" onClick='showtambahws(tambahws.nip.value)' >
                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Pengembangan Kompetensi Lainnya
                          </button>
                      </form>
                    </td>
                    </tr>
                    </table>
                    </div> <!-- tutup div=workshop-->      
                    <?php
                    }
                    ?>

                  <div class="panel panel-info">
                    <div class="panel-heading"><b>PENGEMBANGAN KOMPETENSI LAINNYA</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='info'>
                          <th width='20'><center>#</center></th>
                          <th width='300'><center>Nama Kegiatan</center></th>
                          <th width='30'><center>Tahun</center></th>
                          <th width='250'><center><u>Instansi Penyelenggara</u><br />Tempat Pelaksanaan</center></th>
                          <th width='100'><center>Lama<br/>Tanggal</center></th>
                          <th width='250'><center>Sertifikat</center></th>
                            <th colspan='2'><center>Aksi</center></th>
                        </tr>
                        <?php
                          $no=1;
                          foreach($pegrwyws as $v):                    
                        ?>
                        <tr>
                          <td align='center'><?php echo $no;?></td>
                          <td><?php
                                $nmjns = $this->mpegawai->getnama_jnsworkshop($v['fid_jenis_workshop']); 
				$nmrd = $this->mpegawai->getnama_rumpundiklat($v['fid_rumpun_diklat']);
				echo "<span class='text text-primary'>".$nmjns."</span><br/>".$v['nama_workshop'];
                                echo "<br/><small><span class='text text-success'>RUMPUN : ".$nmrd."</span></small>";
			      ?>
			  </td>
                          <td><?php echo $v['tahun']; ?></td>
                          <td><?php echo '<u>'.$v['instansi_penyelenggara'].'</u><br />'.$v['tempat']; ?></td>
                          <?php
                          echo "<td align=center>";
                          if ($v['lama_bulan'] != 0){
                            echo $v['lama_bulan'].' Bulan';
                          } else if ($v['lama_hari'] != 0){
                            echo $v['lama_hari'].' Hari';
                          } else if ($v['lama_jam'] != 0){
                            echo $v['lama_jam'].' Jam';
                          } else {
                            echo '';
                          }
			  
			  if ($v['tanggal'] != NULL) {
                          echo "<br/>".tgl_indo($v['tanggal'])."</td>";
                          } else {
			  echo "</td>";
			  }
			  ?>
                          <td width='300'>
				<?php
					echo "No. : ".$v['no_sk'];
					if ($v['tgl_sk'] != NULL) {
		                          $tglsk = tgl_indo($v['tgl_sk']);
                		        } else {
                          		  $tglsk = '';
                         		}

					echo "<br />Tanggal : ".$tglsk."<br />Pejabat : ".$v['pejabat_sk'];
				?>
			  </td>
                          <td align='center' width='30'>
                            <form method='POST' name='editdiktek' action='../pegawai/editws'>
                            <?php          
                              if ($this->session->userdata('edit_profil_priv') == "Y") { 
                                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                                echo "<input type='hidden' name='no' id='no' value='$v[no]'>";
                                echo "<input type='hidden' name='tahun' id='tahun' value='$v[tahun]'>";
                                ?>
                                  <button type='submit' class="btn btn-warning btn-xs" >
                                  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                                  </button>
                                </form>
                          </td>
                          <td align='center' width='30'>
                                <form method='POST' action='../pegawai/hapusws_aksi'>
                                <?php
                                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                                echo "<input type='hidden' name='no' id='no' value='$v[no]'>";
                                echo "<input type='hidden' name='tahun' id='tahun' value='$v[tahun]'>";
                                ?>
                                <button type="submit" class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                                </button>
                                </form>
                              </td>
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
                    </div>  <!-- akhir panel info -->
                </div> <!-- akhir konten tab workshop -->
		
	      </div> <!-- akhir konten tab-content -->

            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</center>

<!-- Modal Entri Riwayat Diklat -->
<div id="entridik" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<?= form_open(base_url('pegawai/entri_dik_aksi'), ['id' => 'f_entridik', 'class' => 'form-horizontal'], ['nip' => $nip]); ?>
			<div class="modal-header">
	        <h4 class="modal-title">Tambah Riwayat Diklat Struktural</h4>
	        <?= $this->mpegawai->getnama($nip); ?> - <?= $nip ?>
	      </div>
	      <div class="modal-body">
	        <div class="col-md-2">
		        <div class="form-group">
				    <label for="jns_dik">Pilih Jenis Diklat</label>
				    <select class="form-control" name="jenis_diklat">
				    	<option value="">-- Jenis Diklat --</option>
				    	<?php foreach($jenis_dik_jst as $j): ?>
				    	<option value="<?= $j->id_diklat_struktural ?>"><?= $j->nama_diklat_struktural ?></option>	
				    	<?php endforeach; ?>
				    </select>
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="tahun_pelaksanaan">Tahun Pelaksanaan</label>
				    <input class="form-control" type="number" id="tahun_pelaksanaan" name="tahun_pelaksanaan" placeholder="Tahun Pelaksanaan">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="col-md-8">
		        <div class="form-group">
				    <label for="instansi_dik">Instansi Penyelenggara</label>
				    <input class="form-control" type="text" id="instansi_dik" name="intansi_penyelenggara" placeholder="Instansi Penyelenggara">
				  </div>
			  </div>
			  <div class="col-md-3" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="tempat_pelaksanaan">Tempat Pelaksanaan</label>
				    <input class="form-control" type="text" id="tempat_pelaksanaan" name="tempat_pelaksanaan" placeholder="Tempat Pelaksanaan">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="col-md-2">
		        <div class="form-group">
				    <label for="bulan">Bulan</label>
				    <input class="form-control" type="number" id="bulan" name="bulan" placeholder="Bulan">
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="hari">Hari</label>
				    <input class="form-control" type="number" id="hari" name="hari" placeholder="Hari">
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="jam">Jam</label>
				    <input class="form-control" type="number" id="jam" name="jam" placeholder="Jam">
				  </div>
			  </div>
			  <div class="clearfix"></div>
			  <hr>
			  <div class="col-md-3">
		        <div class="form-group">
				    <label for="pejabat">Pejabat</label>
				    <input class="form-control" type="text" id="pejabat" name="pejabat" placeholder="Pejabat">
				  </div>
			  </div>
			  <div class="col-md-6" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="nomor">Nomor</label>
				    <input class="form-control" type="text" id="nomor" name="nomor" placeholder="Nomor">
				  </div>
			  </div>
			  <div class="col-md-2" style="margin-left: 10px;">
		        <div class="form-group">
				    <label for="tgl">Tanggal</label>
				    <input class="form-control" type="date" id="tgl" name="tgl" placeholder="Tanggal">
				  </div>
			  </div>
			  <div class="clearfix"></div>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	      	<button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
	      <?= form_close() ?>
		</div>
	</div>
</div>
<script>
	$(function() {
		var $modal = $('#entridik');
		var $form = $("#f_entridik");
		$modal.on('shown.bs.modal', function () {
		  //$('input[name="gd"]').focus(); 
		});
		
		$modal.on('hide.bs.modal', function () {
		  $form.get(0).reset();
		  //$("select[name='jp']").html(`<option value="">Pilih Jurusan Pendidikan</option>`);
		})
		  
	});
</script>
