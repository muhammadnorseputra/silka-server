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
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspKembali&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formtambahusulcuti' action='../cuti/tambahusulcutitunda_aksi'>
      <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $idpengantar; ?>'>

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>DETAIL USUL CUTI TUNDA</b>
        </div>
        <?php
          foreach($cuti as $v):
        ?>

        <table class="table">
          <tr>
            <td align='center'>              
             
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='130'><b>No. Pengantar :</b></td>
                  <td width='300'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='110'><b>Tgl. Pengantar :</b></td>
                  <td><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='6' width='150'><center><img  class='img-thumbnail' src='../photo/<?php echo $v['nip'];?>.jpg' width='90' height='120' alt='$nip.jpg'></td>
                </tr>
                <tr>
                  <td align='right'><b>NIP :</b></td>
                  <td colspan='3'><?php echo $v['nip']; ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Nama : </b></td>
                  <td align='left' colspan='3'><?php echo $this->mpegawai->getnama($v['nip']); ?></td>
                </tr>                
                <?php 
                    if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
                    }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
                    }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
                    }
                ?>
                <tr>
                <td align='right'><b>Jabatan :</b></td>
                <td colspan='3'><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br /><u>', $v['nama_unit_kerja'],'</u>'; ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Tahun :</b></td>
                  <td><?php echo $v['tahun']; ?></td>
                  <td colspan='2' align='left'><b>Keputusan Pejabat Yang Berwenang</b></td>
                  
                </tr>
                <tr>
                  <td align='right'><b>Jumlah Hari :</b></td>
                  <td colspan='1'><?php echo $v['jml_hari']; ?></td>                  
                  <td colspan='2' rowspan='2'><?php echo $v['keputusan_pej']; ?></td>
                </tr>
                
              </table>
            </td>
          </tr>
        </table>
        <?php
        endforeach;
        ?>
      </div>
       <!-- Tombol submit ada pada file cuti.php function getdatacuti() dengan metode ajax -->
       <!-- 
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
        -->        
      </form>
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
