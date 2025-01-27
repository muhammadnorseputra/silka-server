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
  <div class="panel panel-warning" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../pppk/detail'>";          
        echo "<input type='hidden' name='nipppk' id='nipppk' maxlength='18' value='$nipppk'>";
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
          echo $this->mpppk->getnama($nipppk);
          echo " ::: ".$nipppk
        ?>
        </div>

      <table class="table">
        <tr>
          <td align='center'>
            <ul class="nav nav-tabs">
              <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
              <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
	      <li class='active'><a href="#ortu" data-toggle="tab">ORANG TUA KANDUNG</a></li>	
              <?php
              $jnskel = $this->mpppk->getjnskel($nipppk);
              if ($jnskel == 'PRIA') {
                echo "<li><a href='#sutri' data-toggle='tab'>ISTRI</a></li>";
              } else if ($jnskel == 'WANITA') {
                echo "<li><a href='#sutri' data-toggle='tab'>SUAMI</a></li>";
              }
              ?>
              <li><a href="#anak" data-toggle="tab">ANAK</a></li>
            </ul>

	    <!-- Tab panes, ini content dari tab di atas -->
            <div class="tab-content">
              <div class="tab-pane face in active" id="ortu">
                <br />
                <?php
                  //cek priviledge session user -- edit_profil_priv
                if ($this->session->userdata('edit_profil_priv') == "Y") {
                ?>
                  <div id='dataanak'>
                    <table class='table table-condensed' action=''>
                      <tr>
                        <td align='right' width='50'>
			  <?php
			    if (!$this->mpppk->cek_adaortu($nipppk, "AYAH") OR !$this->mpppk->cek_adaortu($nipppk, "IBU")) {	
                              echo "<button type='button' class='btn btn-success btn-outline' data-toggle='modal' data-target='#tmbortu$nipppk'>
                               		<span class='fa fa-pencil' aria-hidden='true'></span> TAMBAH DATA ORANG TUA
                              	    </button>";
			    }
			  ?>
                        </td>
                      </tr>
                    </table>
                  </div> <!-- tutup div=sutri-->
                  <?php
                }
                ?>
                <div class="panel panel-success">
                  <div class="panel-heading"><b>ORANG TUA</b></div>
                  <table class='table table-condensed table-hover'>
                    <tr class='info'>
                      <th width='100'>#</th>	
                      <th width='180'>NIK<br/>Nama</th>
                      <th width='150'>Tempat Lahir<br />Tgl. lahir</th>
                      <th width='180'>Alamat</center></th>
                      <th width='80'><u>ASN Aktif</u><br/>Status Kawin</th>
                      <th width='80'><u>Agama</u><br/>Status Hidup</th>
                      <th width='150'><u>No. Akta Meninggal</u><br/>Tgl. Meninggal</th>
                      <th colspan='2'><center>Aksi</center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwyot as $vo):
		    ?>
                    <tr>
                      <td align='left'><?php echo $vo['jenis'];?></td>
                      <td><?php echo "NIK. ".$vo['nik_ortu']."<br/>".$vo['nama_ortu']; ?></td>
                      <td><?php echo $vo['tmp_lahir'].'<br />'.tgl_indo($vo['tgl_lahir']); ?></td>
		      <td><?php echo $vo['alamat']; ?></td>	
                      <td><?php echo '<u>'.$vo['asn'].'</u><br />'.$vo['status_kawin']; ?></td>
		      <td><?php echo '<u>'.$this->mpegawai->getagama($vo['fid_agama']).'</u><br/>'.$vo['status_hidup']; ?></td>	
		      <?php
		      if (($vo['tgl_meninggal'] != '0000-00-00') and ($vo['tgl_meninggal'] != null))  {
                        $tglmeninggalot = tgl_indo($vo['tgl_meninggal']);
                      } else {
                        $tglmeninggalot = '';
                      }	
		      ?>	
                      <td><?php echo '<u>'.$tglmeninggalot.'</u><br />'.$vo['no_akta_meninggal']; ?></td>
                      <td align='left' width='30'>
                        <button type="button" class="btn btn-success btn-outline btn-xs" data-toggle="modal" data-target="#editortu<?php echo $vo['id']; ?>">
                        <span class="fa fa-pencil" aria-hidden="true"></span><br/>&nbspEDIT <?php echo $vo['jenis']; ?>
                        </button>
                      </td>
                        <!-- Modal Edit Ortu -->
                          <div id="editortu<?php echo $vo['id']; ?>" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                               <form method='POST' name='formkalk' style='padding-top:8px' action='../pppk/editortu_aksi'>
                                <div class='modal-header'>
                                <?php
                                  echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>EDIT DATA ORTU";
                                  echo "<br/><h5 class='modal-title text text-muted'>".$this->mpppk->getnama_lengkap($nipppk)."</h5>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
                                <?php
                                  $ortu = $this->mpppk->get_ortu_id($vo['id'])->result_array();
                                  foreach($ortu as $o):
                                ?>
          <input type='hidden' name='id' id='id' value='<?php echo $o['id']; ?>'>
          <input type='hidden' name='nip' id='nip' value='<?php echo $nipppk; ?>'>
          <div class='row'>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ORANG TUA</span></span>
                  <select class="form-control" name="jenis" id="jenis" required >
                    <?php
                        if ($o['jenis'] == "AYAH"){
                                echo "<option value='AYAH' selected>AYAH</option>
                                <option value='IBU' disabled>IBU</option>";
                        } else if ($o['jenis'] == "IBU"){
                                echo "<option value='AYAH' disabled>AYAH</option>
                                <option value='IBU' selected>IBU</option>";
                        } else
                    ?>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NIK <?php echo $o['jenis'];?></span></span>
                  <input class="form-control" type="text" name="nikortu" id="nikortu" placeholder="" value="<?php echo $o['nik_ortu']; ?>" width="30" maxlength="20" required />
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA <?php echo $o['jenis'];?></span></span>
                  <input class="form-control" type="text" name="namaortu" id="namaortu" placeholder="" value="<?php echo $o['nama_ortu']; ?>" width="40" maxlength="50" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TEMPAT LAHIR</span></span>
                  <input class="form-control" type="text" name="tmplahir" id="tmplahir" placeholder="" value="<?php echo $o['tmp_lahir']; ?>" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL LAHIR</span></span>
                  <input class="form-control" type="text" name="tgllahir" id="tgllahir" class="tanggal" placeholder="" value="<?php echo tgl_indo_pendek($o['tgl_lahir']); ?>" width="15" maxlength="10" required />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">AGAMA</span></span>
                  <select class="form-control" name="fid_agama" id="fid_agama" style="font-size: 12px;" required >
                    <?php
                    $agama = $this->mnonpns->agama()->result_array();
                    foreach($agama as $ag)
                    {
                        if ($ag['id_agama'] == $o['fid_agama']) {
                          echo "<option value='".$ag['id_agama']."' selected>".$ag['nama_agama']."</option>";
                        } else {
                          echo "<option value='".$ag['id_agama']."'>".$ag['nama_agama']."</option>";
                        }
                    }
                    ?>	
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ALAMAT DOMISILI</span></span>
                  <input class="form-control" type="text" name="alamat" id="alamat" placeholder="" value="<?php echo $o['alamat']; ?>" width="50" maxlength="200" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">APAKAH ASN AKTIF</span></span>
                  <select class="form-control" name="pekerjaan" id="pekerjaan" style="font-size: 12px;" required >
                    <?php
                        if ($o['asn'] == "YA"){
                    		echo "<option value='YA' selected>YA, PNS / PPPK AKTIF</option>
                    		<option value='TIDAK'>BUKAN PNS / PPPK</option>";
                        } else if ($o['asn'] == "TIDAK"){
                                echo "<option value='YA'>YA, PNS / PPPK AKTIF</option>
                                <option value='TIDAK' selected>BUKAN PNS / PPPK</option>";
                        } else
                    ?>
                  </select>
                </div>
             </div>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">STATUS NIKAH</span></span>
                  <select class="form-control" name="statuskawin" id="statuskawin" style="font-size: 12px;" required >
                    <?php
                        if ($o['status_kawin'] == "MENIKAH"){
                                echo "<option value='MENIKAH' selected>MENIKAH</option>
                                <option value='JANDA/DUDA'>JANDA / DUDA</option>";
                        } else if ($o['status_kawin'] == "JANDA/DUDA"){
                                echo "<option value='MENIKAH'>MENIKAH</option>
                                <option value='JANDA/DUDA' selected>JANDA / DUDA</option>";
                        } else
                    ?>
                  </select>
                </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS HIDUP</span></span>
                  <select class="form-control" name="statushidup" id="statushidup" style="font-size: 12px;" required >
                    <?php
                        if ($o['status_hidup'] == "YA"){
                          echo "<option value='YA' selected>YA</option>
                                <option value='TIDAK'>TIDAK</option>";
                        } else if ($o['status_hidup'] == "TIDAK"){
                          echo "<option value='YA'>YA</option>
                                <option value='TIDAK' selected>TIDAK</option>";
                        }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NIP / NIPPPK</span></span>
                  <input class="form-control" type="text" name="niportu" id="niportu" placeholder="" value="<?php echo $o['nip_ortu']; ?>" width="25" maxlength="18" />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA MENINGGAL</span></span>
                  <input class="form-control" type="text" name="aktameninggal" id="aktameninggal" placeholder="" value="<?php echo $o['no_akta_meninggal']; ?>" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. MENINGGAL</span></span>
                  <input class="form-control" type="text" name="tglmeninggal" id="tglmeninggal"  class="tanggal" placeholder="" value="<?php echo tgl_indo_pendek($o['tgl_meninggal']); ?>" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-success'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
                                <?php
                                  endforeach; // End $sutri
                                ?>

                                </div><!-- End Modal Body -->
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-danger btn-outline">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbspSIMPAN
                                  </button>

                                  <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspBATAL
                                  </button>
                                </div> <!-- end footer -->
                               </form> <!-- End Form Edit Ortu -->
                              </div> <!-- End Modal Content -->
                            </div> <!-- End modal dialog -->
                          </div> <!-- End div modal -->
                        <!-- End Modal Edit Ortu-->

                      <td align='left' width='30'>
                          <form method='POST' action='../pppk/hapusortu_aksi'>
                            <?php
                            echo "<input type='hidden' name='nipppk' id='nipppk' value='$nipppk'>";
                            echo "<input type='hidden' name='jenis' id='jenis' value='$vo[jenis]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-outline btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus <?php echo $vo['jenis']; ?>
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
              </div> <!-- akhir konten tab ortu -->

              <div class="tab-pane" id="sutri">
                <br />
                <?php
                  //cek priviledge session user -- edit_profil_priv
                if ($this->session->userdata('edit_profil_priv') == "Y") { 
                ?>
                  <div id='datasutri'>
                    <table class='table table-condensed' action=''>
                      <tr>
                        <td align='right' width='50'>
			  <button type="button" class="btn btn-success btn-outline" data-toggle="modal" data-target="#tmbsutri<?php echo $nipppk; ?>">
		          <span class="fa fa-pencil" aria-hidden="true"></span>
			    <?php
                              $jnskel = $this->mpppk->getjnskel($nipppk);
                              if ($jnskel == 'PRIA') {
                                echo "TAMBAH DATA ISTRI";
                              } else if ($jnskel == 'WANITA') {
                                echo "TAMBAH DATA SUAMI";
                              }
                              ?>
                          </button>	
                        </td>
                      </tr>
                    </table>
                  </div> <!-- tutup div=sutri-->      
                  <?php
                }
                ?>

                <!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
                <div class="panel panel-success">
                  <?php
                  $jnskel = $this->mpppk->getjnskel($nipppk);
                  if ($jnskel == 'PRIA') {
                    echo "<div class='panel-heading'><b>ISTRI</b></div>";
                  } else if ($jnskel == 'WANITA') {
                    echo "<div class='panel-heading'><b>SUAMI</b></div>";
                  }
                  ?>
                  <table class='table table-condensed table-hover'>
                    <tr class='info'>
                      <th width='20'><center>#</center></th>
                      <th width='200'>NIK<br/>Nama</th>
                      <th width='200'><u>Tgl. Nikah</u><br />No. Akta Nikah<br/>Agama</th>
                      <th align='150'><u>Tmp. Lahir</u><br />Tgl. Lahir</th>
                      <th width='200'>Alamat Domililsi</th>
                      <th width='100'>Pekerjaan</th>
                      <th width='150'><u>Status Kawin</u><br />Status Hidup<br />Tanggungan</th>
                      <th width='150'><u>Tgl. Cerai</u><br />Akta Cerai</th>
                      <th width='150'><u>Tgl. Meninggal</u><br />Akta Meninggal</th>
                      <th width='150' colspan='2'>Aksi</th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwyst as $v):                    
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td><?php echo "NIK. ".$v['nik_sutri']."<br/>".$v['nama_sutri']; ?></td>
                      <td><?php echo '<u>'.tgl_indo($v['tgl_nikah']).'</u><br />'.$v['no_akta_nikah'].'<br/>Agama : '.$this->mpegawai->getagama($v['fid_agama']); ?></td>
                      <td><?php echo '<u>'.$v['tmp_lahir'].'</u><br />'.tgl_indo($v['tgl_lahir']); ?></td>
		      <td><?php echo $v['alamat'];?></td>	
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
			<button type="button" class="btn btn-success btn-outline btn-xs" data-toggle="modal" data-target="#editsutri<?php echo $v['id']; ?>">
			<span class="fa fa-pencil" aria-hidden="true"></span><br/>&nbspEdit&nbsp
			</button>
                      </td>
                        <!-- Modal Edit Sutri -->
                          <div id="editsutri<?php echo $v['id']; ?>" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
			       <form method='POST' name='formkalk' style='padding-top:8px' action='../pppk/editsutri_aksi'>         	
                                <div class='modal-header'>
                                <?php
                                  $jnskel = $this->mpppk->getjnskel($nipppk);
                                  if ($jnskel == 'PRIA') {
                                    $ket = "ISTRI";
                                  } else if ($jnskel == 'WANITA') {
                                    $ket = "SUAMI";
                                  }
                                  echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>EDIT DATA ".$ket;
                                  echo "<br/><h5 class='modal-title text text-muted'>".$this->mpppk->getnama_lengkap($nipppk)."</h5>";
                                ?>
                                </div> <!-- End Header -->
                                <div class="modal-body" align="left">
				<?php
				  $sutri = $this->mpppk->get_sutri_id($v['id'])->result_array();
				  foreach($sutri as $s):
				?>
          <input type='hidden' name='nip' id='nip' value='<?php echo $s['nipppk']; ?>'>
          <input type='hidden' name='tgl_nikah_lama' id='tgl_nikah_lama' value='<?php echo $s['tgl_nikah']; ?>'>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NIK <?php echo $ket;?></span></span>
                  <input class="form-control" type="text" name="niksutri" id="niksutri" placeholder="" value="<?php echo $s['nik_sutri']; ?>" width="30" maxlength="20" required />
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA <?php echo $ket;?></span></span>
                  <input class="form-control" type="text" name="namasutri" id="namasutri" placeholder="" value="<?php echo $s['nama_sutri']; ?>" width="40" maxlength="50" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TEMPAT LAHIR</span></span>
                  <input class="form-control" type="text" name="tmplahir" id="tmplahir" value="<?php echo $s['tmp_lahir']; ?>" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL LAHIR</span></span>
                  <input class="form-control" type="text" name="tgllahir" id="tgllahir"  placeholder="" value="<?php echo tgl_indo_pendek($s['tgl_lahir']); ?>" width="15" maxlength="10" required />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">AGAMA</span></span>
                  <select class="form-control" name="fid_agama" id="fid_agama" required >
                    <option value='' selected>-- Pilih Agama --</option>
                    <?php
                    $agama = $this->mnonpns->agama()->result_array();
                    foreach($agama as $ag)
                    {
			if ($ag['id_agama'] == $v['fid_agama']) {
                          echo "<option value='".$ag['id_agama']."' selected>".$ag['nama_agama']."</option>";
			} else {
			  echo "<option value='".$ag['id_agama']."'>".$ag['nama_agama']."</option>";
			}
                    }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ALAMAT DOMISILI</span></span>
                  <input class="form-control" type="text" name="alamat" id="alamat" placeholder="" value="<?php echo $s['alamat']; ?>" width="50" maxlength="200" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NO. AKTA NIKAH</span></span>
                  <input class="form-control" type="text" name="aktanikah" id="aktanikah" class="tanggal" placeholder="" value="<?php echo $s['no_akta_nikah']; ?>" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL NIKAH</span></span>
                  <input class="form-control" type="text" name="tglnikah" id="tglnikah" placeholder="" value="<?php echo tgl_indo_pendek($s['tgl_nikah']); ?>" width="30" maxlength="30" required />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">PEKERJAAN</span></span>
                  <select class="form-control" name="pekerjaan" id="pekerjaan" style="font-size: 12px;" required >
                    <?php
                        if ($s['pekerjaan'] == "ASN"){
			  echo "<option value='ASN' selected>ASN</option>
                    		<option value='NON ASN'>NON ASN</option>
                    		<option value='KARYAWAN SWASTA'>KARYAWAN SWASTA</option>
                    		<option value='WIRASWASTA'>WIRASWASTA</option>
                    		<option value='PROFESIONAL'>PROFESIONAL</option>
                    		<option value='LAIN-LAIN'>LAIN-LAIN</option>";
			} else if ($s['pekerjaan'] == "NON ASN"){
                          echo "<option value='ASN'>ASN</option>
                                <option value='NON ASN' selected>NON ASN</option>
                                <option value='KARYAWAN SWASTA'>KARYAWAN SWASTA</option>
                                <option value='WIRASWASTA'>WIRASWASTA</option>
                                <option value='PROFESIONAL'>PROFESIONAL</option>
                                <option value='LAIN-LAIN'>LAIN-LAIN</option>";
                        } else if ($s['pekerjaan'] == "KARYAWAN SWASTA"){
                          echo "<option value='ASN'>ASN</option>
                                <option value='NON ASN'>NON ASN</option>
                                <option value='KARYAWAN SWASTA' selected>KARYAWAN SWASTA</option>
                                <option value='WIRASWASTA'>WIRASWASTA</option>
                                <option value='PROFESIONAL'>PROFESIONAL</option>
                                <option value='LAIN-LAIN'>LAIN-LAIN</option>";
                        } else if ($s['pekerjaan'] == "WIRASWASTA"){
                          echo "<option value='ASN'>ASN</option>
                                <option value='NON ASN'>NON ASN</option>
                                <option value='KARYAWAN SWASTA'>KARYAWAN SWASTA</option>
                                <option value='WIRASWASTA' selected>WIRASWASTA</option>
                                <option value='PROFESIONAL'>PROFESIONAL</option>
                                <option value='LAIN-LAIN'>LAIN-LAIN</option>";
                        } else if ($s['pekerjaan'] == "PROFESIONAL"){
                          echo "<option value='ASN'>ASN</option>
                                <option value='NON ASN'>NON ASN</option>
                                <option value='KARYAWAN SWASTA'>KARYAWAN SWASTA</option>
                                <option value='WIRASWASTA'>WIRASWASTA</option>
                                <option value='PROFESIONAL' selected>PROFESIONAL</option>
                                <option value='LAIN-LAIN'>LAIN-LAIN</option>";
                        } else if ($s['pekerjaan'] == "LAIN-LAIN"){
                          echo "<option value='ASN'>ASN</option>
                                <option value='NON ASN'>NON ASN</option>
                                <option value='KARYAWAN SWASTA'>KARYAWAN SWASTA</option>
                                <option value='WIRASWASTA'>WIRASWASTA</option>
                                <option value='PROFESIONAL'>PROFESIONAL</option>
                                <option value='LAIN-LAIN' selected>LAIN-LAIN</option>";
                        }
		    ?>             
                  </select>
                </div>
             </div>
             <div class='col-md-4' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">STATUS NIKAH</span></span>
                  <select class="form-control" name="statuskawin" id="statuskawin" required >
                    <?php
                        if ($s['status_kawin'] == "JANDA/DUDA"){
			  echo "<option value='MENIKAH'>MENIKAH</option>
                    		<option value='JANDA/DUDA' selected>JANDA / DUDA</option>";
			} else if ($s['status_kawin'] == "MENIKAH"){
                          echo "<option value='MENIKAH' selected>MENIKAH</option>
                                <option value='JANDA/DUDA'>JANDA / DUDA</option>";
                        }
                    ?>
                  </select>
                </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS HIDUP</span></span>
                  <select class="form-control" name="statushidup" id="statushidup" required >
                    <?php
                        if ($s['status_hidup'] == "YA"){
                          echo "<option value='YA' selected>YA</option>
                                <option value='TIDAK'>TIDAK</option>";
                        } else if ($s['status_hidup'] == "TIDAK"){
                          echo "<option value='YA'>YA</option>
                                <option value='TIDAK' selected>TIDAK</option>";
                        }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGUNGAN</span></span>
                  <select class="form-control" name="tanggungan" id="tanggungan" required >
                    <?php
                        if ($s['tanggungan'] == "YA"){
                          echo "<option value='YA' selected>YA</option>
                                <option value='TIDAK'>TIDAK</option>";
                        } else if ($s['tanggungan'] == "TIDAK"){
                          echo "<option value='YA'>YA</option>
                                <option value='TIDAK' selected>TIDAK</option>";
                        }
                    ?>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NIP / NIPPPK</span></span>
                  <input class="form-control" type="text" name="nipsutri" id="nipsutri" placeholder="" value="<?php echo $s['nip_sutri']; ?>" width="25" maxlength="18" />
               </div>
             </div>
             <div class='col-md-2' align="left"><span class='text-success'>Jika <?php echo $ket; ?> <br/>PNS/PPPK</span>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. KARTU <?php echo $ket;?></span></span>
                  <input class="form-control" type="text" name="nokarisu" id="nokarisu" placeholder="" value="<?php echo $s['no_karisu']; ?>" width="20" maxlength="15" />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA CERAI</span></span>
                  <input class="form-control" type="text" name="aktacerai" id="aktacerai"  placeholder="" value="<?php echo $s['no_akta_cerai']; ?>" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. CERAI</span></span>
                  <input class="form-control" type="text" name="tglcerai" id="tglcerai"  class="tanggal" placeholder="" value="<?php echo tgl_indo_pendek($s['tgl_cerai']); ?>" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-success'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA MENINGGAL</span></span>
                  <input class="form-control" type="text" name="aktameninggal" id="aktameninggal"  placeholder="" value="<?php echo $s['no_akta_meninggal']; ?>" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. MENINGGAL</span></span>
                  <input class="form-control" type="text" name="tglmeninggal" id="tglmeninggal"  class="tanggal" placeholder="" value="<?php echo tgl_indo_pendek($s['tgl_meninggal']); ?>" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-success'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
				<?php
				  endforeach; // End $sutri
				?>
                                </div><!-- End Modal Body -->
      				<div class="modal-footer">
          			  <button type="submit" class="btn btn-danger btn-outline">
            			    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbspSIMPAN
          			  </button>

          			  <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
            			    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspBATAL
          			  </button>
      				</div> <!-- end footer -->
			       </form> <!-- End Form Edit Sutri -->     	
                              </div> <!-- End Modal Content -->
                            </div> <!-- End modal dialog -->
                          </div> <!-- End div modal -->
                        <!-- End Modal Edit Sutri-->

		      <td align='center' width='30'>
			<?php if ($this->mpppk->cek_sutriadaanak($v['nipppk'], $v['id']) == '') { ?>
                          <form method='POST' action='../pppk/hapussutri_aksi'>
                            <?php
                            echo "<input type='hidden' name='nipppk' id='nipppk' value='$nipppk'>";
                            echo "<input type='hidden' name='tgl_nikah' id='tgl_nikah' value='$v[tgl_nikah]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-outline btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
                            </button>
                          </form>
			<?php } else { 
				echo "<span class='text text-danger'>ADA<br/>ANAK</span>";
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
			  <button type="button" class="btn btn-success btn-outline" data-toggle="modal" data-target="#tmbanak<?php echo $nipppk; ?>">
                            <span class="fa fa-pencil" aria-hidden="true"></span> TAMBAH DATA ANAK
                          </button>
                        </td>
                      </tr>
                    </table>
                  </div> <!-- tutup div=sutri-->      
                  <?php
                }
                ?>
                <div class="panel panel-success">
                  <div class="panel-heading"><b>ANAK</b></div>
                  <table class='table table-condensed table-hover'>
                    <tr class='info'>
                      <th width='20'>#</th>
                      <th width='200'>NIK<br/>Nama</th>
                      <?php
                      if ($jnskel == 'PRIA') {
                        echo "<th width='150'>Nama Ibu</th>";
                      } else if ($jnskel == 'WANITA') {
                        echo "<th width='150'>Nama Bapak</th>";
                      }
                      ?>                    
                      <th width='150'>Jenis Kelamin<br/>Agama</center></th>
		      <th width='100'>Alamat</center></th>	
                      <th width='150'>No. Akta Lahir<br/><u>Tempat Lahir</u><br />Tgl. lahir</th>
                      <th width='150'>Pekerjaan<br/><u>Status Kawin</u><br/>Tanggungan</th>
                      <th width='150'><u>Status Anak</u><br />Status Hidup</th>
                      <th width='150'><u>No. Akta Meninggal</u><br/>Tgl. Meninggal</th>
                      <th width='100' colspan='2'><center>Aksi</center></th>
                    </tr>
                    <?php
                    $no=1;
                    foreach($pegrwyanak as $va):
                      ?>
                    <tr>
                      <td align='center'><?php echo $no;?></td>
                      <td><?php echo "NIK .".$va['nik_anak']."<br/>".$va['nama_anak']; ?></td>
                      <td><?php echo $this->mpppk->getnamaibubapak($va['fid_sutri']); ?></td>
                      <td><?php echo $va['jns_kelamin'].'<br/>Agama : '.$this->mpegawai->getagama($va['fid_agama']); ?></td>
		      <td><?php echo $va['alamat']; ?></td>
                      <td><?php echo $va['no_akta_lahir'].'<br/><u>'.$va['tmp_lahir'].'</u><br />'.tgl_indo($va['tgl_lahir']); ?></td>
                      <td><?php echo $va['pekerjaan'].'<u><br/>'.$v['status_kawin'].'</u><br/>Tanggungan : '.$va['tanggungan']; ?></td>
                      <td><?php echo '<u>'.$va['status'].'</u><br /> Status Hidup : '.$va['status_hidup']; ?></td>
		      <?php	
                      if (($va['tgl_meninggal'] != '0000-00-00') and ($va['tgl_meninggal'] != null))  {
                        $tglmeninggalanak = tgl_indo($va['tgl_meninggal']);
                      } else {
                        $tglmeninggalanak = '';
                      }
		      ?>	
                      <td><?php echo '<u>'.$va['no_akta_meninggal'].'</u><br />'.$tglmeninggalanak; ?></td>
                      <td align='center' width='30'>
                        <button type="button" class="btn btn-success btn-outline btn-xs" data-toggle="modal" data-target="#editanak<?php echo $va['id']; ?>">
                        <span class="fa fa-pencil" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                        </button>
                      </td>
			<!-- Modal Tambah Sutri -->
			  <div id="editanak<?php echo $va['id']; ?>" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  			    <div class="modal-dialog modal-lg" role="document">
    			      <div class="modal-content">
                               <form method='POST' name='formkalk' style='padding-top:8px' action='../pppk/editanak_aksi'>
      				<div class='modal-header'>
      				<?php
        			  echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>EDIT DATA ANAK";
        			  echo "<br/><h5 class='modal-title text text-muted'>".$this->mpppk->getnama_lengkap($nipppk)."</h5>";
      				?>
      				</div> <!-- End Header -->
      				<div class="modal-body" align="left">
                                <?php
                                  $anak = $this->mpppk->get_anak_id($va['id'])->result_array();
                                  foreach($anak as $a):
                                ?>
          <input type='hidden' name='id' id='id' value='<?php echo $a['id']; ?>'>
          <input type='hidden' name='nip' id='nip' value='<?php echo $nipppk; ?>'>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NIK ANAK</span></span>
                  <input class="form-control" type="text" name="nikanak" id="nikanak" placeholder="Entri NIK" value="<?php echo $a['nik_anak']; ?>" width="30" maxlength="20" required />
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA ANAK</span></span>
                  <input class="form-control" type="text" name="namaanak" id="namaanak" placeholder="" value="<?php echo $a['nama_anak']; ?>" width="40" maxlength="50" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <?php
                  $jnskel = $this->mpppk->getjnskel($nipppk);
                  if ($jnskel == 'PRIA') {
                    $ketibubapak = "IBU";
                  } else if ($jnskel == 'WANITA') {
                    $ketibubapak = "AYAH";
                  }
                  ?>
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA <?php echo $ketibubapak; ?></span></span>
                  <select class="form-control" name="fid_sutri" id="fid_sutri" required >
                    <option value='' selected>-- Pilih <?php echo $ketibubapak; ?> --</option>
                    <?php
                    $ibubapak = $this->mpppk->getibubapak($nipppk)->result_array();
                    foreach($ibubapak as $ib)
                    {
			if ($ib['id'] == $a['fid_sutri']) {
                          echo "<option value='".$ib['id']."' selected>".$ib['nama_sutri']."</option>";
			} else {
			  echo "<option value='".$ib['id']."'>".$ib['nama_sutri']."</option>";
			}			
                    }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">JENIS KELAMIN</span></span>
                  <select class="form-control" name="jns_kelamin" id="jns_kelamin" required >
                    <?php
                        if ($a['jns_kelamin'] == "PRIA"){
                          echo "<option value='PRIA' selected>PRIA</option>
                                <option value='WANITA'>WANITA</option>";
                        } else if ($a['jns_kelamin'] == "WANITA"){
                          echo "<option value='PRIA'>PRIA</option>
                                <option value='WANITA' selected>WANITA</option>";
                        }
                    ?>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TEMPAT LAHIR</span></span>
                  <input class="form-control" type="text" name="tmplahir" id="tmplahir" placeholder="" value="<?php echo $a['tmp_lahir']; ?>" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL LAHIR</span></span>
                  <input class="form-control" type="text" name="tgllahir" id="tgllahir" class="tanggal" placeholder="" value="<?php echo tgl_indo_pendek($a['tgl_lahir']); ?>" width="15" maxlength="10" required />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">AGAMA</span></span>
                  <select class="form-control" name="fid_agama" id="fid_agama" required >
                    <option value='' selected>-- Pilih Agama --</option>
                    <?php
                    $agama = $this->mnonpns->agama()->result_array();
                    foreach($agama as $ag)
                    {
                        if ($ag['id_agama'] == $a['fid_agama']) {
                          echo "<option value='".$ag['id_agama']."' selected>".$ag['nama_agama']."</option>";
                        } else {
                          echo "<option value='".$ag['id_agama']."'>".$ag['nama_agama']."</option>";
                        }
                    }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ALAMAT DOMISILI</span></span>
                  <input class="form-control" type="text" name="alamat" id="alamat" placeholder="" value="<?php echo $s['alamat']; ?>" width="50" maxlength="200" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NO. AKTA LAHIR</span></span>
                  <input class="form-control" type="text" name="aktalahir" id="aktalahir" class="tanggal" placeholder="" value="<?php echo $a['no_akta_lahir']; ?>" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                 <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS ANAK</span></span>
                 <select class="form-control" name="status" id="status" required >
                    <?php
                        if ($a['status'] == "KANDUNG"){
                          echo "<option value='KANDUNG' selected>KANDUNG</option>
                    		<option value='TIRI'>TIRI</option>
                    		<option value='ANGKAT'>ANGKAT</option>";
                        } else if ($a['status'] == "TIRI"){
                          echo "<option value='KANDUNG'>KANDUNG</option>
                                <option value='TIRI' selected>TIRI</option>
                                <option value='ANGKAT'>ANGKAT</option>";
                        } else if ($a['status'] == "ANGKAT"){
                          echo "<option value='KANDUNG'>KANDUNG</option>
                                <option value='TIRI'>TIRI</option>
                                <option value='ANGKAT' selected>ANGKAT</option>";
                        }
		     ?>	
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">PEKERJAAN</span></span>
                  <select class="form-control" name="pekerjaan" id="pekerjaan" style="font-size: 12px;" required >
		    <?php	
                        if ($a['pekerjaan'] == "PELAJAR"){
                          echo "<option value='PELAJAR' selected>PELAJAR</option>
                    		<option value='BEKERJA'>BEKERJA</option>
                    		<option value='LAIN-LAIN'>LAIN-LAIN</option>";
			} else if ($a['pekerjaan'] == "BEKERJA"){
                          echo "<option value='PELAJAR'>PELAJAR</option>
                                <option value='BEKERJA' selected>BEKERJA</option>
                                <option value='LAIN-LAIN'>LAIN-LAIN</option>";
                        } else if ($a['pekerjaan'] == "LAIN-LAIN"){
                          echo "<option value='PELAJAR'>PELAJAR</option>
                                <option value='BEKERJA'>BEKERJA</option>
                                <option value='LAIN-LAIN' selected>LAIN-LAIN</option>";
                        } 
		    ?> 
                  </select>
                </div>
             </div>
             <div class='col-md-4' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">STATUS NIKAH</span></span>
                  <select class="form-control" name="statuskawin" id="statuskawin" required >
                    <?php
                        if ($a['status_kawin'] == "BELUM MENIKAH"){
                          echo "<option value='BELUM MENIKAH' selected>BELUM MENIKAH</option>
                    		<option value='MENIKAH'>MENIKAH</option>
                    		<option value='JANDA/DUDA'>JANDA / DUDA</option>";
                        } else if ($a['status_kawin'] == "MENIKAH"){
                          echo "<option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                <option value='MENIKAH' selected>MENIKAH</option>
                                <option value='JANDA/DUDA'>JANDA / DUDA</option>";;
                        } else if ($a['status_kawin'] == "JANDA/DUDA"){
                          echo "<option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                <option value='MENIKAH'>MENIKAH</option>
                                <option value='JANDA/DUDA' selected>JANDA / DUDA</option>";
                        }
                    ?>
                  </select>
                </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS HIDUP</span></span>
                  <select class="form-control" name="statushidup" id="statushidup" required >
                    <?php
                        if ($a['status_hidup'] == "YA"){
                          echo "<option value='YA' selected>YA</option>
                                <option value='TIDAK'>TIDAK</option>";
                        } else if ($a['status_hidup'] == "TIDAK"){
                          echo "<option value='YA'>YA</option>
                                <option value='TIDAK' selected>TIDAK</option>";
                        }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGUNGAN</span></span>
                  <select class="form-control" name="tanggungan" id="tanggungan" required >
                    <?php
                        if ($a['tanggungan'] == "YA"){
                          echo "<option value='YA' selected>YA</option>
                                <option value='TIDAK'>TIDAK</option>";
                        } else if ($a['tanggungan'] == "TIDAK"){
                          echo "<option value='YA'>YA</option>
                                <option value='TIDAK' selected>TIDAK</option>";
                        }
                    ?>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA MENINGGAL</span></span>
                  <input class="form-control" type="text" name="aktameninggal" id="aktameninggal" class="tanggal" placeholder="" value="<?php echo $a['no_akta_meninggal']; ?>" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. MENINGGAL</span></span>
                  <input class="form-control" type="text" name="tglmeninggal" id="tglmeninggal"  class="tanggal" placeholder="" value="<?php echo tgl_indo_pendek($a['tgl_meninggal']); ?>" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-success'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>

                                <?php
                                  endforeach; // End $sutri
                                ?>
    
      				</div><!-- End Modal Body -->	
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-danger btn-outline">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbspSIMPAN
                                  </button>

                                  <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspBATAL
                                  </button>
                                </div> <!-- end footer -->
                               </form> <!-- End Form Edit Sutri -->
    			      </div> <!-- End Modal Content -->	
  			    </div> <!-- End modal dialog -->
			  </div> <!-- End div modal -->
			<!-- End Modal Edit Sutri-->

		      <td align='center' width='30'>
                          <form method='POST' action='../pppk/hapusanak_aksi'>
                            <?php
                            echo "<input type='hidden' name='nipppk' id='nipppk' value='$nipppk'>";
                            echo "<input type='hidden' name='id' id='id' value='$va[id]'>";
                            ?>
                            <button type="submit" class="btn btn-danger btn-outline btn-xs">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br/>Hapus
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
              </div> <!-- akhir konten tab anak -->
            </div> <!-- akhir konten tab-content -->
          </td>
        </tr>
      </table>
  </div> <!-- akhir panel body-->
</div> <!-- akhir panel -->
</div>
</center>

<!-- Modal Tambah Ortu -->
<div id="tmbortu<?php echo $nipppk; ?>" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <form method='POST' name='formtmbanak' style='padding-top:8px' action='../pppk/tambahortu_aksi'>
      <div class='modal-header'>
      <?php
        echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>TAMBAH DATA ORANG TUA";
        echo "<br/><h5 class='modal-title text text-muted'>".$this->mpppk->getnama_lengkap($nipppk)."</h5>";
      ?>
      </div> <!-- End Header -->
      <div class="modal-body" align="left">
          <input type='hidden' name='nip' id='nip' value='<?php echo $nipppk; ?>'>
	  <div class='row'>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ORANG TUA</span></span>
                  <select class="form-control" name="jenis" id="jenis" required >
		  <?php
		    $adaayah = $this->mpppk->cek_adaortu($nipppk,"AYAH");
		    if ($adaayah) {	
		      $jnsortu = "IBU";	
                      echo "<option value='AYAH' disabled>AYAH</option>
                    	    <option value='IBU' selected>IBU</option>";
  		    } else {
		      $jnsortu = "AYAH";	
                      echo "<option value='AYAH' selected>AYAH</option>
                            <option value='IBU' disabled>IBU</option>";
                    }
		  ?>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NIK <?php echo $jnsortu;?></span></span>
                  <input class="form-control" type="text" name="nikortu" id="nikortu" placeholder="" value="" width="30" maxlength="20" required />
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA <?php echo $jnsortu;?></span></span>
                  <input class="form-control" type="text" name="namaortu" id="namaortu" placeholder="" value="" width="40" maxlength="50" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TEMPAT LAHIR</span></span>
                  <input class="form-control" type="text" name="tmplahir" id="tmplahir" placeholder="" value="" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL LAHIR</span></span>
                  <input class="form-control" type="text" name="tgllahir" id="tgllahir" class="tanggal" placeholder="" value="" width="15" maxlength="10" required />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">AGAMA</span></span>
                  <select class="form-control" name="fid_agama" id="fid_agama" style="font-size: 12px;" required >
                    <option value='' selected>-- Pilih Agama --</option>
                    <?php
                    $agama = $this->mnonpns->agama()->result_array();
                    foreach($agama as $ag)
                    {
                        echo "<option value='".$ag['id_agama']."'>".$ag['nama_agama']."</option>";
                    }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ALAMAT DOMISILI</span></span>
                  <input class="form-control" type="text" name="alamat" id="alamat" placeholder="" value="" width="50" maxlength="200" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">APAKAH ASN AKTIF</span></span>
                  <select class="form-control" name="pekerjaan" id="pekerjaan" style="font-size: 12px;" required >
                    <option value='' selected>-- Pilih --</option>
                    <option value='YA'>YA, PNS / PPPK AKTIF</option>
                    <option value='TIDAK'>BUKAN PNS / PPPK</option>
                  </select>
                </div>
             </div>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">STATUS NIKAH</span></span>
                  <select class="form-control" name="statuskawin" id="statuskawin" style="font-size: 12px;" required >
                    <option value='MENIKAH'>MENIKAH</option>
                    <option value='JANDA/DUDA'>JANDA / DUDA</option>
                  </select>
                </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS HIDUP</span></span>
                  <select class="form-control" name="statushidup" id="statushidup" style="font-size: 12px;" required >
                    <option value='YA' selected>YA</option>
                    <option value='TIDAK'>TIDAK</option>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NIP / NIPPPK</span></span>
                  <input class="form-control" type="text" name="niportu" id="niportu" placeholder="" value="" width="25" maxlength="18" />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA MENINGGAL</span></span>
                  <input class="form-control" type="text" name="aktameninggal" id="aktameninggal" class="tanggal" placeholder="" value="" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. MENINGGAL</span></span>
                  <input class="form-control" type="text" name="tglmeninggal" id="tglmeninggal"  class="tanggal" placeholder="" value="" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-success'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
      </div> <!-- End Modal Body -->
      <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-outline">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbspSIMPAN DATA <?php echo $jnsortu;?>
          </button>

          <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspBATAL
          </button>
      </div> <!-- end footer -->
     </form>
    </div> <!-- End Modal Content -->
  </div>
</div>
<!-- End Modal Tambah Ortu -->

<!-- Modal Tambah Sutri -->
<div id="tmbsutri<?php echo $nipppk; ?>" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <form method='POST' name='formkalk' style='padding-top:8px' action='../pppk/tambahsutri_aksi'>
      <div class='modal-header'>
      <?php
	$jnskel = $this->mpppk->getjnskel($nipppk);
        if ($jnskel == 'PRIA') {
	  $ket = "ISTRI";
        } else if ($jnskel == 'WANITA') {
	  $ket = "SUAMI";
        }
        echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>TAMBAH DATA ".$ket;
        echo "<br/><h5 class='modal-title text text-muted'>".$this->mpppk->getnama_lengkap($nipppk)."</h5>";
      ?>
      </div> <!-- End Header -->
      <div class="modal-body" align="left">
          <input type='hidden' name='nip' id='nip' value='<?php echo $nipppk; ?>'>
  	  <div class='row'>
	     <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NIK <?php echo $ket;?></span></span>
                  <input class="form-control" type="text" name="niksutri" id="niksutri" placeholder="Entri NIK" value="" width="30" maxlength="20" required />
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA <?php echo $ket;?></span></span>
                  <input class="form-control" type="text" name="namasutri" id="namasutri" placeholder="" value="" width="40" maxlength="50" required />
               </div>
             </div>
	  </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TEMPAT LAHIR</span></span>
                  <input class="form-control" type="text" name="tmplahir" id="tmplahir" placeholder="" value="" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL LAHIR</span></span>
                  <input class="form-control" type="text" name="tgllahir" id="tgllahir" class="tanggal" placeholder="" value="" width="15" maxlength="10" required />
	       </div>
             </div>
	     <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">AGAMA</span></span>
                  <select class="form-control" name="fid_agama" id="fid_agama" required >
                    <option value='' selected>-- Pilih Agama --</option>
                    <?php
                    $agama = $this->mnonpns->agama()->result_array();
                    foreach($agama as $ag)
                    {
                        echo "<option value='".$ag['id_agama']."'>".$ag['nama_agama']."</option>";
                    }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ALAMAT DOMISILI</span></span>
                  <input class="form-control" type="text" name="alamat" id="alamat" placeholder="" value="" width="50" maxlength="200" required />
               </div>
             </div>
          </div>          
	  <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NO. AKTA NIKAH</span></span>
                  <input class="form-control" type="text" name="aktanikah" id="aktanikah" class="tanggal" placeholder="" value="" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL NIKAH</span></span>
                  <input class="form-control" type="text" name="tglnikah" id="tglnikah" placeholder="" value="" width="30" maxlength="30" required />
               </div>
             </div>
	     <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>	
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">PEKERJAAN</span></span>
                  <select class="form-control" name="pekerjaan" id="pekerjaan" style="font-size: 12px;" required >
                    <option value='' selected>-- Pilih Pekerjaan --</option>
              	    <option value='ASN'>ASN</option>
                    <option value='NON ASN'>NON ASN</option>
                    <option value='KARYAWAN SWASTA'>KARYAWAN SWASTA</option>
                    <option value='WIRASWASTA'>WIRASWASTA</option>
                    <option value='PROFESIONAL'>PROFESIONAL</option>
                    <option value='LAIN-LAIN'>LAIN-LAIN</option>
                  </select>
                </div>
             </div>
             <div class='col-md-4' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">STATUS NIKAH</span></span>
            	  <select class="form-control" name="statuskawin" id="statuskawin" required >
                    <option value='MENIKAH' selected>MENIKAH</option>
                    <option value='JANDA/DUDA'>JANDA / DUDA</option>
                  </select>
                </div>
             </div>		
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS HIDUP</span></span>
		  <select class="form-control" name="statushidup" id="statushidup" required >
                    <option value='YA' selected>YA</option>
                    <option value='TIDAK'>TIDAK</option>
                  </select>
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGUNGAN</span></span>
                  <select class="form-control" name="tanggungan" id="tanggungan" required >
                    <option value='YA' selected>YA</option>
                    <option value='TIDAK'>TIDAK</option>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NIP / NIPPPK</span></span>
                  <input class="form-control" type="text" name="nipsutri" id="nipsutri" placeholder="" value="" width="25" maxlength="18" />
               </div>
             </div>
	     <div class='col-md-2' align="left"><span class='text-danger'>Jika <?php echo $ket; ?> <br/>PNS/PPPK</span>
	     </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. KARTU <?php echo $ket;?></span></span>
                  <input class="form-control" type="text" name="nokarisu" id="nokarisu" placeholder="" value="" width="20" maxlength="15" />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA CERAI</span></span>
                  <input class="form-control" type="text" name="aktacerai" id="aktacerai" class="tanggal" placeholder="" value="" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. CERAI</span></span>
                  <input class="form-control" type="text" name="tglcerai" id="tglcerai"  class="tanggal" placeholder="" value="" width="15" maxlength="10" />
               </div>
             </div>
	     <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>	
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA MENINGGAL</span></span>
                  <input class="form-control" type="text" name="aktameninggal" id="aktameninggal" class="tanggal" placeholder="" value="" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. MENINGGAL</span></span>
                  <input class="form-control" type="text" name="tglmeninggal" id="tglmeninggal"  class="tanggal" placeholder="" value="" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
      </div> <!-- End Modal Body -->
      <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-outline">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbspSIMPAN
          </button>

          <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspBATAL
          </button>
      </div> <!-- end footer -->
     </form>	 	
    </div> <!-- End Modal Content -->
  </div>
</div>
<!-- End Modal Tambah Sutri -->

<!-- Modal Tambah Anak -->
<div id="tmbanak<?php echo $nipppk; ?>" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <form method='POST' name='formtmbanak' style='padding-top:8px' action='../pppk/tambahanak_aksi'>
      <div class='modal-header'>
      <?php
        echo "<h5 class='modal-title text text-primary'><span class='text text-primary'>TAMBAH DATA ANAK";
        echo "<br/><h5 class='modal-title text text-muted'>".$this->mpppk->getnama_lengkap($nipppk)."</h5>";
      ?>
      </div> <!-- End Header -->
      <div class="modal-body" align="left">
          <input type='hidden' name='nip' id='nip' value='<?php echo $nipppk; ?>'>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NIK ANAK</span></span>
                  <input class="form-control" type="text" name="nikanak" id="nikanak" placeholder="Entri NIK" value="" width="30" maxlength="20" required />
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA ANAK</span></span>
                  <input class="form-control" type="text" name="namaanak" id="namaanak" placeholder="" value="" width="40" maxlength="50" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
		  <?php
        	  $jnskel = $this->mpppk->getjnskel($nipppk);
        	  if ($jnskel == 'PRIA') {
          	    $ketibubapak = "IBU";
        	  } else if ($jnskel == 'WANITA') {
          	    $ketibubapak = "AYAH";
        	  }
		  ?>
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NAMA <?php echo $ketibubapak; ?></span></span>
                  <select class="form-control" name="fid_sutri" id="fid_sutri" required >
                    <option value='' selected>-- Pilih <?php echo $ketibubapak; ?> --</option>
                    <?php
                    $ibubapak = $this->mpppk->getibubapak($nipppk)->result_array();
                    foreach($ibubapak as $ib)
                    {
                  	echo "<option value='".$ib['id']."'>".$ib['nama_sutri']."</option>";
              	    }
            	    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">JENIS KELAMIN</span></span>
		  <select class="form-control" name="jns_kelamin" id="jns_kelamin" required >
                    <option value='PRIA' selected>PRIA</option>
                    <option value='WANITA'>WANITA</option>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TEMPAT LAHIR</span></span>
                  <input class="form-control" type="text" name="tmplahir" id="tmplahir" placeholder="" value="" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGAL LAHIR</span></span>
                  <input class="form-control" type="text" name="tgllahir" id="tgllahir" class="tanggal" placeholder="" value="" width="15" maxlength="10" required />
               </div>
             </div>
             <span class='text-danger'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">AGAMA</span></span>
                  <select class="form-control" name="fid_agama" id="fid_agama" required >
                    <option value='' selected>-- Pilih Agama --</option>
                    <?php
                    $agama = $this->mnonpns->agama()->result_array();
                    foreach($agama as $ag)
                    {
                        echo "<option value='".$ag['id_agama']."'>".$ag['nama_agama']."</option>";
                    }
                    ?>
                  </select>
               </div>
             </div>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">ALAMAT DOMISILI</span></span>
                  <input class="form-control" type="text" name="alamat" id="alamat" placeholder="" value="" width="50" maxlength="200" required />
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">NO. AKTA LAHIR</span></span>
                  <input class="form-control" type="text" name="aktalahir" id="aktalahir" class="tanggal" placeholder="" value="" width="30" maxlength="30" required />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                 <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS ANAK</span></span>
                 <select class="form-control" name="status" id="status" required >
                    <option value='KANDUNG' selected>KANDUNG</option>
                    <option value='TIRI'>TIRI</option>
                    <option value='ANGKAT'>ANGKAT</option>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">PEKERJAAN</span></span>
                  <select class="form-control" name="pekerjaan" id="pekerjaan" style="font-size: 12px;" required >
                    <option value='PELAJAR' selected>PELAJAR</option>
                    <option value='BEKERJA'>BEKERJA</option>
                    <option value='LAIN-LAIN'>LAIN-LAIN</option>
                  </select>
                </div>
             </div>
             <div class='col-md-4' align="left">
                <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 12px;"><span class="text text-danger">STATUS NIKAH</span></span>
                  <select class="form-control" name="statuskawin" id="statuskawin" required >
		    <option value='BELUM MENIKAH' selected>BELUM MENIKAH</option>
                    <option value='MENIKAH'>MENIKAH</option>
                    <option value='JANDA/DUDA'>JANDA / DUDA</option>
                  </select>
                </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">STATUS HIDUP</span></span>
                  <select class="form-control" name="statushidup" id="statushidup" required >
                    <option value='YA' selected>YA</option>
                    <option value='TIDAK'>TIDAK</option>
                  </select>
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-danger">TANGGUNGAN</span></span>
                  <select class="form-control" name="tanggungan" id="tanggungan" required >
                    <option value='YA' selected>YA</option>
                    <option value='TIDAK'>TIDAK</option>
                  </select>
               </div>
             </div>
          </div>
          <div class='row'>
             <div class='col-md-6' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">NO. AKTA MENINGGAL</span></span>
                  <input class="form-control" type="text" name="aktameninggal" id="aktameninggal" class="tanggal" placeholder="" value="" width="40" maxlength="50" />
               </div>
             </div>
             <div class='col-md-4' align="left">
               <div class="form-group input-group">
                  <span class="input-group-addon" style="font-size: 11px;"><span class="text text-success">TGL. MENINGGAL</span></span>
                  <input class="form-control" type="text" name="tglmeninggal" id="tglmeninggal"  class="tanggal" placeholder="" value="" width="15" maxlength="10" />
               </div>
             </div>
             <span class='text-success'>FORMAT :<br/>tanggal-bulan-tahun</span>
          </div>
      </div> <!-- End Modal Body -->
      <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-outline">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbspSIMPAN
          </button>

          <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbspBATAL
          </button>
      </div> <!-- end footer -->
     </form>
    </div> <!-- End Modal Content -->
  </div>
</div>
<!-- End Modal Tambah Anak -->
