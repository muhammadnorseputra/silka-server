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
          <form method="POST" action="../takah/cetaknomperunker" target='_blank'>                
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
        <form method="POST" action="../takah/tampilunkernomtakah">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 

  <div class="panel panel-info">  
  <div class="panel-heading" align="left"><b>NOMINATIF DOKUMEN ELEKTRONIK ::: <?php echo $nmunker ?></b><br />
  <?php echo "Jumlah ASN : ".$jmlpeg ?>
  </div>
  <div style="padding:3px;overflow:auto;width:99%;height:450px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='success'>
        <td align='center'><b>No</b></td>
        <td align='center'><b>NIP<br/>Nama</b></td>
        <td align='center'><b>CPNS/PNS</b></td>
        <td align='center'><b>Jabatan<br/>Terakhir</b></td>
        <td align='center'><b>Pangkat<br/>Terakhir</b></td>
        <td align='center'><b>Ijazah<br/>Terakhir</b></td>
        <td align='center'><b>SKP<br/>Terakhir</b></td>
        <td align='center'><b>KGB<br/>Terakhir</b></td>
        <td align='center'><b>KTP</b></td>
        <td align='center'><b>NPWP</b></td>
        <td align='center'><b>Karis/Karsu</b></td>
        <td align='center'><b>Karpeg</b></td>
        <td align='center'><b>Taspen</b></td>
        <td align='center'><b>Buku Nikah</b></td>
        <td align='center'><b>Akta<br/>Kelahiran</b></td>
      </tr>

      <?php
        $no = 1;
        foreach($peg as $v):
      ?>

      <tr>
        <td align='center'><?php echo $no; ?></td>
        <td><?php echo $v['nip']."<br/>".namagelar($v['gelar_depan'],$v['nama'],$v['gelar_belakang']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafilecp($v['nip']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafilejab($v['nip']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafilekp($v['nip']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafileijazah($v['nip']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafileskp($v['nip']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafilekgb($v['nip']); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '1'); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '2'); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '3'); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '4'); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '5'); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '6'); ?></td>
        <td align='center'><?php echo $this->mtakah->cek_adafiletakah($v['nip'], '7'); ?></td>
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
