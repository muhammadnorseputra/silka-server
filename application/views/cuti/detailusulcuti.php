<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../cuti/detailpengantar'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbsp&nbspKembali&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>DETAIL USUL CUTI</b>
        </div>
        <?php
          foreach($cuti as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>              
             
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='120'><b>No. Pengantar</b> :</td>
                  <td width='300'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='120'><b>Tgl. Pengantar</b> :</td>
                  <td><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='6'>
                    <center><img class='img-thumbnail' src='../photo/<?php echo $v['nip'];?>.jpg' width='135' height='180' alt='$nip.jpg'>
                  </td>
                </tr>
                <tr>
                  <td align='right'><b>NIP</b> :</td>
                  <td><?php echo $v['nip']; ?></td>
                  <td align='right'><b>Nama</b> :</td>
                  <td><?php echo $this->mpegawai->getnama($v['nip']); ?></td>
                </tr>
                <?php 
                    if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
                    }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
                    }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
                    }
                ?>
                <tr>
                  <td align='right'><b>Jabatan</b> :</td>
                  <td colspan='3'><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br /><u>', $v['nama_unit_kerja'],'</u>'; ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Jenis Cuti</b> :</td>
                  <td><?php echo $v['nama_jenis_cuti']; ?></td>
                  <?php
                  $jnscuti = $this->mcuti->getnamajeniscuti($v['fid_jns_cuti']);
                  if ($jnscuti == 'CUTI SAKIT') {			
                    echo "<td align='center' colspan='2'><b>Ket</b> Penyakit : ".$v['ket_jns_cuti']."</td>";  
                  } if ($jnscuti == 'CUTI BERSALIN') {			
                    echo "<td align='center' colspan='2'><b>Ket</b> kelahiran Anak Ke-".$v['ket_jns_cuti']."</td>";  
                  } if ($jnscuti == 'CUTI BESAR') {			
                    echo "<td align='center' colspan='2'><b>Ket</b> Telah Bekerja Selama : ".$v['ket_jns_cuti']." Tahun</td>";  
                  } else {
                    echo "<td colspan='2'></td>";
                  }
                  ?>                  
                </tr>                
                <tr>
                  <td align='right'><b>Tahun</b> :</td>
                  <td>
                  <?php 
                    echo $v['thn_cuti']. "&nbsp&nbsp&nbsp&nbsp&nbspJumlah : ". $v['jml']." ".$v['satuan_jml']; 

                    if (($jnscuti == 'CUTI TAHUNAN') AND ($v['tambah_hari_tunda'] != 0)) {
                      $jmltotal = $v['jml'] + $v['tambah_hari_tunda'];
                      echo " + ".$v['tambah_hari_tunda']." HARI (cuti tunda)";  
                    }
                  ?>
                  </td>
                  <td align='right'><b>Tanggal Cuti</b> :</td>
                  <td colspan='1'><?php echo tgl_indo($v['tgl_mulai']).' s/d '.tgl_indo($v['tgl_selesai']); ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Alamat</b> :</td>
                  <td colspan='3'><?php echo $v['alamat']; ?></td>                  
                </tr>
                <tr>
                <td align='center' colspan='2'><u><b>Catatan Pejabat Kepegawaian</b></u></td>
                <td align='center' colspan='2'><u><b>Catatan / Pertimbangan Atasan Langsung</b></u></td>
                <td align='center' colspan='2'><u><b>Keputusan Pejabat Yang Berwenang</b></u></td>
                </tr>
                <tr>                  
                  <td colspan='2' align='center'><?php echo $v['catatan_pej_kepeg']; ?></td>
                  <td colspan='2' align='center'><?php echo $v['catatan_atasan']; ?></td>
                  <td colspan='2' align='center'><?php echo $v['keputusan_pej']; ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      <?php
        endforeach;
      ?>  
      </div>      
    </div> <!-- end class="panel-body" -->    
  </div>  
</center>
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-danger">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
