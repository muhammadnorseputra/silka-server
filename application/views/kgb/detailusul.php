<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/detailpengantar'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-warning btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspKembali&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>
      <div class="panel panel-success">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>DETAIL USUL KGB</b>
        </div>
        <?php
          foreach($kgb as $v):
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
                  <td rowspan='8'>
                    <center><img class='img-thumbnail' src='../photo/<?php echo $v['nip'];?>.jpg' width='100' height='125' alt='$nip.jpg'>
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
                <tr class='info'>
                  <td align='right'><b>Gapok Lama</b> :</td>
                  <td><?php echo 'Rp. '.indorupiah($v['gapok_lama']).',-'; ?></td>
                  <td align='right'><b>TMT</b> :</td>
                  <td><?php echo tgl_indo($v['tmt_gaji_lama']); ?></td>
                </tr>                
                <tr class='info'>
                  <td align='right'><b>Masa Kerja</b> :</td>
                  <td><?php echo $v['mk_thn_lama'].' Tahun, '.$v['mk_bln_lama'].' Bulan'; ?></td>
                  <td align='right'><b>Dalam Golru</b> :</td>
                  <td><?php echo $this->mpegawai->getnamapangkat($v['fid_golru_lama']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_lama']).')';?></td>
                </tr>
                <tr class='info'>
                  <td align='right'><b>Berdasarkan<br/>SK Nomor</b> :</td>
                  <td colspan='3'><?php echo $v['sk_lama_pejabat'].'<br/>'.$v['sk_lama_no'].'<br/>'.tgl_indo($v['sk_lama_tgl']); ?></td>                  
                </tr>
                <tr>                
                <td align='center' colspan='3'><u><b>Diusulkan oleh</b></u></td>
                <td align='center'><u><b>Status Usulan</b></u></td>
                </tr>
                <tr>              
                  <td colspan='3' align='center'><?php echo $this->mpegawai->getnama($v['user_usul']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_usul']); ?></td>    
                  <td align='center'><?php echo $this->mkgb->getstatuskgb($v['fid_status']); ?></td>
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