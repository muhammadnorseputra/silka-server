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
  
  
  function showHitungUlang(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="hitungulang";
    url=url+"?nip="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("hitungulang").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("hitungulang").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 

</script>

<style>
.nilai {
  font-size: 120%;
  background-color: khaki;
  color: black;
}
</style>

<!-- Default panel contents -->
<center>
  <div class="panel panel-default" style="width:99%;height:640px;border:0px solid white">
    <div class="panel-body">

      <div class="panel panel-success"   style="padding:3px;overflow:auto;width:90%;height:610px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
          <b>INDEKS PROFESIONALITAS ASN</b>
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

	<small>
	<table class='table table-condensed table-hover' style="width:90%;height:auto;">
        	<tr class='warning'>
                  <th width='20'><center>Tahun</center></th>
		  <th width='20'><center>Kelompok - Jenis Jabatan</center></th>
                  <th width='400'><center><u>Jabatan</u><br />Unit Kerja</center></th>
                  <th width='100'><center><u>KUALIFIKASI</u><br/>25%</center></th>
                  <th width='230'><center><u>KOMPETENSI</u><br/>40%</center></th>
		  <th width='170'><center><u>KINERJA</u></br>30%</center></th>
		  <th width='130'><center><u>DISIPLIN</u></br>5%</center></th>
                  <th width='150'><center>NILAI PIP</center></th>
		  <th width='120'><center>Diukur pada</center></th>
                </tr>
	<?php
        foreach($rwy as $r) :
	?>
		<tr>
                  <td align='center'><?php echo "<span class='badge nilai'>".$r['tahun']."</span>";?></td>
		  <td align='center'><?php echo $r['jns_jabatan'];?></td>
                  <td><?php echo '<u>'.$r['jabatan'].'</u><br />'.$r['unit_kerja']; ?></td>
                  <td><?php echo $r['tingkat_pendidikan']."<br/>Skor : <span class='badge nilai'>".$r['skor_kualifikasi']."</span>"; ?></td>
                  <td><?php echo "Diklat PIM : ".$r['diklat_pim']."<br/>Diklat Fungsional : ".$r['diklat_fung']."<br/>Diklat Teknis : ".$r['diklat_teknis'].
			"<br/>Seminar/Workshop/dll : ".$r['seminar']."<br/>Skor :  <span class='badge nilai'>".$r['skor_kompetensi']."</span>"; ?></td>
		  <td><?php echo "Nilai Kinerja : ".round($r['nilai_kinerja'],2)."<br/>Skor : <span class='badge nilai'>".$r['skor_kinerja']."</span>"; ?></td>
                  <td><?php echo $r['riwayat_disiplin']."<br/>Skor :  <span class='badge nilai'>".$r['skor_disiplin']."</span>"; ?></td>
		  <td><?php echo "<h4 class='text text-primary'>".$r['nilai_pip']."</h4>Kategori : <b>".$r['kategori_pip']."</b>"; ?></td>
                  <td><?php echo "<u>".tglwaktu_indo($r['created_at'])."</u>"; ?></td>
		</tr>

	<?php
       endforeach;
       echo "</table>
	     </small>";

       $thnini = date("Y");
       $pipa = $this->mpip->detailpip($nip, $thnini)->result_array();
       $jmlpipa = $this->mpip->getjmlpip($nip, $thnini);
          
       if ($jmlpipa == 1) {
         foreach($pipa as $v):
       ?>

        <table class="table" style="width:50%;">        
          <tr>
            <td align='center'>
              <ul class="list-group" style="width:100%; text-align: left;">
                <li class="list-group-item list-group-item-default" style="font-size: 150%; background-color: khaki;"><center>
                <h4>Indeks Profesionalitas Tahun <?php echo $v['tahun']?></h4></center>
                </li>
                <li class="list-group-item">KUALIFIKASI (Bobot 25%)<br/>
                  <span class="badge nilai"><?php echo $v['skor_kualifikasi']; ?></span>
                  <?php echo "Pendidikan Terakhir : <b>".$v['tingkat_pendidikan']."</b>"; ?>
                </li>
                <li class="list-group-item">KOMPETENSI (Bobot 40%)<br/>
                  <?php 
                  echo "- Diklat Kepemimpinan : <b>".$v['diklat_pim']."</b>";
                  echo "<br/>- Diklat Fungsional : <b>".$v['diklat_fung']."</b>";
                  echo "<br/>- Diklat Teknis 20 JP : <b>".$v['diklat_teknis']."</b>";
                  echo "<br/>- Seminar/Workshop/Sejenisnya : <b>".$v['seminar']."</b>";
                  ?>
                  <span class="badge nilai"><?php echo $v['skor_kompetensi']; ?></span>
                </li>
                <li class="list-group-item">KINERJA (Bobot 30%)<br/>
                  <?php echo "Nilai Prestasi Kerja Tahun Lalu : <b>".$v['nilai_kinerja']."</b>"; ?>
                  <span class="badge nilai"><?php echo $v['skor_kinerja']; ?></span>
                </li>
                <li class="list-group-item">DISIPLIN (Bobot 5%)<br/>
                  <?php echo "Riwayat Penjatuhan Hukuman Disiplin 5 (lima) tahun terakhir : <b>".$v['riwayat_disiplin']."</b>"; ?>
                  <span class="badge nilai"><?php echo $v['skor_disiplin']; ?></span>
                </li>           
                <li class="list-group-item" style="background-color: silver;">
                  <b>NILAI INDEKS PROFESIONALITAS</b><br/>
                  <?php echo "Tingkat Profesionalitas : ".$v['kategori_pip']."</b>"; ?>
                  <span class="badge nilai"><?php echo $v['nilai_pip']; ?></span>
                </li>    
              </ul>
            </td>
          </tr>
        </table>

        <?php
        endforeach;
      } else {
        echo "<h4 style='color: red;'>PENGUKURAN INDEKS PROFESIONALITAS TAHUN INI BELUM DILAKUKAN</h4>";
        }
        ?>          

        <div id='hitungulang'>          
          <form method="POST" name="formhitungulang">
            <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
            <button type="button" class="btn btn-danger btn-lg" onClick="showHitungUlang(formhitungulang.nip.value)">
              <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Lakukan Pengukuran Ulang IPASN 2021 !!!
            </button>
          </form>
        </div> <!-- end div hitungulang-->

      </div>
    </div>
  </div>
</center>
