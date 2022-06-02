<script type="text/javascript">
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
  
  
  function showData(str1, str2, str3, str4)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilpnsusul";
    url=url+"?nip="+str1;
    url=url+"&uk="+str2;
    url=url+"&thn="+str3;
    url=url+"&bln="+str4;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampil").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampil").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }

  function showKalkulasi(str1, str2, str3, str4, str5, str6)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="tampilkalkulasi";
    url=url+"?nip="+str1;
    url=url+"&thn="+str2;
    url=url+"&bln="+str3;
    url=url+"&kls="+str4;
    url=url+"&kin="+str5;
    url=url+"&abs="+str6;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedKalkulasi;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedKalkulasi(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("kalkulasi").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("kalkulasi").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
</script>

<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:640px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-success"   style="padding:3px;overflow:auto;width:70%;height:610px;">
    <div class='panel-heading' align='left'>
      <b>EDIT USUL TPP PERIODE <?php echo strtoupper(bulan($bln))." ".$thn; ?></b><br/>
      <?php
        $nmunker = $this->munker->getnamaunker($idunker);
        echo $nmunker;
      ?>
    </div>
  
    <table class='table table-condensed'>
      <tr>      
        <td align='right' width='50'>
          <form method='POST' action='../kinerja/detail_pengantar'>   
              <input type='hidden' name='fid_unker' id='fid_unker' value='<?php echo $idunker; ?>'>
              <input type='hidden' name='thn' id='thn' value='<?php echo $thn; ?>'>
              <input type='hidden' name='bln' id='bln' value='<?php echo $bln; ?>'>         
              <button type='submit' class='btn btn-success btn-sm'>
                <span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>Kembali
              </button>
            </form>
        </td>
      </tr>
    </table> 

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
    <?php
      $nama = $this->mpegawai->getnama($nip);      
      $lokasifile = './photo/';
      $filename = "$nip.jpg";
      if (file_exists ($lokasifile.$filename)) {
        $photo = "../photo/$nip.jpg";
      } else {
        $photo = "../photo/nophoto.jpg";
      }
      
      $jnsjab = $this->mkinerja->get_jnsjab($nip);
        if ($jnsjab == "STRUKTURAL") {
          $ideselon = $this->mpegawai->getfideselon($nip);
          $namaeselon = $this->mpegawai->getnamaeselon($ideselon);
          if (($namaeselon == 'IV/A') OR ($namaeselon == 'IV/B')) {
            $id_jabstruk = $this->mkinerja->getfidjabstruk($nip);
            $cektidakadajfu = $this->mkinerja->cektidakadajfu($id_jabstruk);
            
            $cekkaskpd = $this->mkinerja->cek_kaskpd_eselon4($id_jabstruk);
              $ceksubkeukec = $this->mkinerja->ceksubkeukec_adabendahara($id_jabstruk);
              // cek apakah kasubbag perencanaan dan keuangan pada kecamatan, dan ada jfu bendaharanya
              if ($ceksubkeukec == true) {
                $kelasjab = 9;
              } else if ($cekkaskpd == true) {
                $kelasjab = 9;
              } else if (($cektidakadajfu == true) OR ($cektidakadajfu == 'nocategory')) { // tidak ada JFU
                $kelasjab = 8;    
              } else {
                $kelasjab = 9;
              }
          } else {
            $kelasjab = $this->mkinerja->get_kelasjabstruk($nip);
          }
        } else if ($jnsjab == "FUNGSIONAL UMUM") {
          $kelasjab = $this->mkinerja->get_kelasjabfu($nip);
        } else if ($jnsjab == "FUNGSIONAL TERTENTU") {
          $kelasjab = $this->mkinerja->get_kelasjabft($nip);
        }
     
      echo "<div align='center'>";
      echo '<table class="table table-condensed" style="width: 70%;">';
      echo "<tr class='info'>
            <td rowspan='3' align='center' width='80'>
              <img src='$photo' width='90' height='120' class='img-thumbnail'>
            </td>
            <td>$nama</td></tr>
            <tr class='info'>          
              <td>";
      echo $this->mpegawai->namajabnip($nip);
      echo " <b>(Kelas ".$kelasjab.")</b>";
      echo "</td>
            <tr class='info'>
            <td>";
      echo $nmunker;
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</div>";
      
      
      ?>
      <form method="POST" name="formkal" action="../kinerja/editusulpns_aksi">
      <table style="width: 70%;">
      <tr>        
      <td>
        <?php
        foreach($usul_tpp as $v):

        $cekplt = $this->mkinerja->cek_sdgplt($nip, $bln, $thn);
        $cekcutisakit = $this->mkinerja->cek_sdgcutisakit($nip, $bln, $thn);
        $cekcutibesar = $this->mkinerja->cek_sdgcutibesar($nip, $bln, $thn);

        // Ini ngurus PLT
        // PLT. hanya diperbolehkan jika ybs dalam keadaan tidak sedang cuti sakit atau cuti besar
        if (($cekplt == true) AND ($cekcutisakit == false) AND ($cekcutibesar == false)) {
          $plt = "YA";
          $jabplt = $this->mkinerja->get_jabplt($nip);
          $unkerplt = $this->mkinerja->get_unkerplt($nip);
          $kelasjabplt = $this->mkinerja->get_kelasjabplt($nip);
          //$hargajab = $this->mkinerja->get_hargajabplt($nip); 
          echo "<td align='right'><b>Jabatan PLT :</b></td>";
          echo "<td colspan='3'>".$jabplt."<br/>".$unkerplt."<b>(Kelas Jab : ".$kelasjabplt.")</b></td>";
        } else {
          $plt = "TIDAK";
          $jabplt = "-";
          $unkerplt = "-";
          $kelasjabplt = 0;
        }
        ?>
          
          <input type='hidden' name='nip' id='nip' value='<?php echo $nip; ?>' required />
          <input type='hidden' name='thn' id='thn' value='<?php echo $thn; ?>' required />
          <input type='hidden' name='bln' id='bln' value='<?php echo $bln; ?>' required />
          <input type='hidden' name='idunker' id='idunker' value='<?php echo $idunker; ?>' required />          
          <input type='hidden' name='kelasjabatan' id='kelasjabatan' value='<?php echo $kelasjab; ?>' required />
           

          <div class='panel panel-default'>
            <div class='panel-heading'>
              <div class='row'>
                <div class='col-md-6' align='center'> 
                <?php        

                // get nilai_skp dari tabel kinerja_bulanan
                $nilaiskp = $this->mkinerja->get_realisasikinerja($nip, $thn, $bln);
                ?>  
                  <b>Nilai Kinerja Bulanan :</b>
                    <input type="text" name="kin" id="kin" size="3" maxlength="5" value=<?php echo number_format($v['nilai_kinerja'],2); ?> required /> 
                  <?php
                $nilai_absensi = $this->mkinerja->get_realisasiabsensi($nip, $thn, $bln);
                ?>
                </div>
                <div class='col-md-6'>
                  <b>Nilai Absensi Bulanan :</b>
                  <input type="text" name="absen" id="absen" size=3 maxlength="5" value=<?php echo number_format($v['nilai_absensi'],2); ?> required />
                </div>
              </div>
            </div>
          </div>
          <?php        
                        
            $idgolru = $this->mhukdis->getidgolruterakhir($nip);
            $golru = $this->mpegawai->getnamagolru($idgolru);
            echo "<input type='hidden' name='idgolru' id='idgolru' value='".$idgolru."' required />";
            echo "<input type='hidden' name='golru' id='golru' value='".$golru."' required />";

            echo "<div class='col-md-6'>";
            echo "<div class='panel panel-info'>";
              echo "<div class='panel-heading'>";
                echo "<div class='text-primary' align='center'><b>PERHITUNGAN TPP BASIC</b></div>";
                echo "<div align='left'><small>TPP Basic</small>
                    <span class='pull-right text-muted'>
                      <div class='text-primary'>
                        Rp. ".number_format($v['tpp_basic'],0,",",".")."
                      </div>
                    </span>
                    </div>";


              $statcpns = $this->mpegawai->getstatpeg($nip);
              $cpns = "TIDAK";

              if ($statcpns == "CPNS") {
                $cpns = "YA";
                echo "<div class='text-danger' align='left'><span class='label label-warning'>CPNS (80 %)</span></div>";
              }

              if ($cekcutisakit == true) {  
                echo "<div class='text-danger' align='left'><span class='label label-warning'>CUTI SAKIT (40 %)</span></div>";
              }

              if ($cekcutibesar == true) {   
                echo "<div class='text-danger' align='left'><span class='label label-warning'>CUTI BESAR (40 %)</span></div>";
              }
              echo "<br/><div align='left'><small>TPP KINERJA</small><span class='pull-right text-muted'><div class='text-primary'>Rp. <input type='text' name='tppkin' id='tppkin' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['tpp_kinerja']." required /></b></div><span></div>";

              echo "<br/><div align='left'><small>TPP ABSENSI</small><span class='pull-right text-muted'><div class='text-primary'>Rp. <input type='text' name='tppabs' id='tppabs' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['tpp_absensi']." required /></b></div><span></div>";
              
              echo "<br/><div align='left'><small>TPP GROSS</small><span class='pull-right text-muted'><div class='text-primary'>Rp. <input type='text' name='jmltpp' id='jmltpp' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_kotor']." required /></b></div><span></div>";
             
            echo "</div>"; // tutup heading panel
            echo "</div>"; // tutup panel
            echo "</div>"; // tutup column kiri

            echo "<div class='col-md-6'>";
              echo "<div class='panel panel-warning'>";
              echo "<div class='panel-heading'>";
              echo "<div class='text-danger' align='center'><b>INDIKATOR TAMBAHAN</b></div>";  
              
              echo "<div align='left'><small>Sekretaris Daerah</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahsekda' id='tambahsekda' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_sekda']." required /></div><span></div>";
              echo "<br/><div align='left'><small>Tanpa JFU</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahtanpajfu' id='tambahtanpajfu' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_tanpajfu']." required /></b></div><span></div>";
              echo "<br/><div align='left'><small>Bendahara</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahbendahara' id='tambahbendahara' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_bendahara']." required /></b></div><span></div>";
              echo "<br/><div align='left'><small>Pokja UPPBJ</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahpokja' id='tambahpokja' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_pokja']." required /></b></div><span></div>";
              echo "<br/><div align='left'><small>Dokter</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahdokter' id='tambahdokter' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_dokter']." required /></b></div><span></div>";
              echo "<br/><div align='left'><small>Radiografer</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahradiografer' id='tambahradiografer' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_radiografer']." required /></b></div><span></div>";
              echo "<br/><div align='left'><small>Jabatan Kelas 1 dan 3</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahkelas1dan3' id='tambahkelas1dan3' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_kelas1dan3']." required /></div><span></div>";      
              echo "<br/><div align='left'><small>Terpencil</small><span class='pull-right text-muted'><div class='text-danger'>Rp. <input type='text' name='tambahterpencil' id='tambahterpencil' onkeyup='validAngka(this)' size='8' maxlength='8' value=".$v['jml_tpp_terpencil']." required /></div><span></div>";
              
            echo "</div>"; // tutup heading panel
            echo "</div>"; // tutup panel
            echo "<div align='center'><button type='submit' class='btn btn-warning btn-sm'>";
            echo "<span class='glyphicon glyphicon-save' aria-hidden='true'></span> SIMPAN";
            echo "</button></div>";

            echo "</div>"; // tutup panel
            echo "</div>"; // tutup column kanan
          endforeach;
          ?>
        </td>
      </tr>
      </table>
      </form> 
  </div>
</div>
</div>
</center>
