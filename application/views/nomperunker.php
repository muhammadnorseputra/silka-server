<!-- Default panel contents -->
<?php
if ($nmunker == '')
{     
?>
    <center>
    <div class="panel panel-default" style="width: 50%">
        <div class="panel-body">
           <div class="alert alert-danger alert-dismissible" role="alert">              
              <b>Kesalahan...</b><br />Silahkan pilih unit kerja terlebih dahulu
            </div>  
          <button type="button" class="btn btn-success btn-sm" onclick="history.back(-1)">
          <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Kembali</button>
        </div>
        </div>
    </center>
  <?php
}else
{
?>
  <center>
  <div class="panel panel-default"  style="width: 99%">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <?php
      //cek priviledge session user -- cetak_nominatif_priv
      if ($this->session->userdata('cetak_nominatif_priv') == "Y") { 
      ?>
        <td align='right'>
          <form method="POST" action="../pegawai/cetaknomperunker" target='_blank'>                
            <input type='hidden' name='id' id='id' maxlength='18' value='<?php echo $idunker; ?>'>
            <button type="submit" class="btn btn-success btn-sm">
              <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Nominatif
            </button>
          </form>
        </td>
      <?php
      }
      ?>
      <td align='right' width='50'>
        <form method="POST" action="../pegawai/tampilunkernom">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 

  <div class="panel panel-info">  
  <div class="panel-heading" align="left"><b>NOMINATIF ASN ::: <?php echo $nmunker ?></b><br />
  <?php echo "Jumlah ASN : ".$jmlpeg ?>
  </div>
  <div style="padding:3px;overflow:auto;width:99%;height:450px;border:1px solid white" >
  <table class="table table-bordered table-hover">
      <tr class='success'>
        <td align='center'><b>No</b></td>
        <td align='center' width='120'><b>NIP</b></td>
        <td align='center'><b>Nama</b></td>
        <td align='center' width='20'><b>Jns Kel</b></td>
        <td align='center' width='150'><b>Golongan Ruang</b></td>
        <td align='center'><b>Jabatan</b></td>
        <td align='center'><b>Maker</b></td>
        <td align='center' width='100'><b>Latihan Jabatan</b></td>
        <td align='center'><b>Pendidikan</b></td>
        <td align='center'><b>Tempat/Tanggal Lahir</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($peg as $v):
      ?>

      <tr>
        <td align='center'><?php echo $no; ?></td>
        <td><?php echo $v['nip']; ?></td>
        <td><?php echo namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></td>
        <td align='center'><?php echo $v['jenis_kelamin'];?></td>
        <td align='center'>
          <?php echo $this->mpegawai->getnamapangkat($v['fid_golru_skr']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_skr']).')<br />TMT : ',tgl_indo($v['tmt_golru_skr']); ?>
        </td>
        <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }
        ?>
        <td><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab).'<br />TMT : '.tgl_indo($v['tmt_jabatan']); ?></td>
        <td align='center'><?php echo hitungmkcpns($v['nip']); ?></td>
        <td><?php echo $this->mpegawai->getdssingkat($v['nip']); ?></td>
        <td><?php echo $this->mpegawai->getpendidikansingkat($v['nip']); ?></td>
        <td><?php echo $v['tmp_lahir'],' / ',tgl_indo($v['tgl_lahir']); ?></td>
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>
</div>
</div>
</div>
</div>
</center>
<?php
}
?>
