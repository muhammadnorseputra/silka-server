<!-- Default panel contents -->
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-info">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
  <center>
  <div class="panel panel-default"  style="width: 99%;">
  <div class="panel-body">
  
  <table class='table table-condensed'>
    <tr>
      <?php
      // cek privilegde user session -- usulcuti_priv
      if (($this->session->userdata('level') == "ADMIN") || ($this->session->userdata('level') == "USER")) { 
      ?>
      <td align='right'>
        <form method="POST" action="../akunpns/tambahakun">
          <button type="submit" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Tambah Akun
          </button>
        </form>
      </td>
      <?php
      }
      ?>
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 
  
  <div class="panel panel-danger">  
  <div class="panel-heading" align="left">
  <b>Manajemen Akun PNS</b><br />
  <?php 
  $total = $this->makunpns->gettotalakun();
  $jmlaktif = $this->makunpns->getjmlakunaktif();
  $jmlnonaktif = $this->makunpns->getjmlakunnonaktif();
  echo "Jumlah Akun : ", $total, " PNS (", $jmlaktif, " Akun Aktif, ",$jmlnonaktif, " Akun Non Aktif)"; 
  ?>
  </div>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:420px;border:1px solid white" >
  
  <form class="form-inline" action="<?= base_url('akunpns/listakun') ?>" method="get">
	  <div class="form-group">
	    <label for="nipnama">Masukan NIP/Nama :</label>
	    <input type="text" class="form-control" id="nipnama" name="nipnama">
	  </div>
	  <button type="submit" class="btn btn-default">Cari</button>
	</form>
	<br>
  <table class="table table-condensed table-hover">
  		<thead>
      <tr class='danger'>
        <td align='center' width='30'>No.</td>
        <td align='center' width='200' colspan='2'>Nama<br/>NIP</td>
        <td align='center'>Jabatan<br/>Unit Kerja</td>
        <td align='center'>Status<br/>Dibuat tgl</td>
        <td align='center' colspan='3'>Aksi</td>
      </tr>
      </thead>
      <tbody>
      <?php
        $no = 1;
        if(!empty($user)):
        foreach($user as $v):    
            
      ?>

      <?php 
          if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
          }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
          }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
          }
      ?>
      
      <tr>    
        <td align='center'><?php echo $no; ?></td>
        <td><?php
          $lokasifile = './photo/';
          $filename = $v['nip'].".jpg";

          if (file_exists ($lokasifile.$filename)) {
            $photo = "../photo/".$v['nip'].".jpg";
          } else {
            $photo = "../photo/nophoto.jpg";
          }

          echo "<center><img src='$photo' width='30' height='40'></center>";
          ?>
          <td>
            <?php
            echo $this->mpegawai->getnama($v['nip']).'<br/>NIP. '.$v['nip'];
            ?>
          </td>

        <td><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab).'<br /><u>'.$this->munker->getnamaunker($v['fid_unit_kerja']).'</u>'; ?></td>
        
        <td align='center'>
            <?php
            if ($v['status'] == 'AKTIF') {
              echo "<span class='label label-info'>".$v['status']."</span>";
            } else {
              echo "<span class='label label-default'>".$v['status']."</span>";
            }
	    ?>
	    <br/>
	    <?php echo tglwaktu_indo($v['created_at']); ?>	
            
        </td>
        <td align='center' width='20'>
          <?php          
              $status = $this->makunpns->getstatusakun($v['nip']);
              if ($status == 'AKTIF') {
                echo "<form method='POST' action='../akunpns/nonaktifkanakun'>";          
                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";              
                ?>
                <button type="submit" class="btn btn-default btn-xs">
                Non Aktifkan<br /><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                </button>
                <?php
              } else {
                echo "<form method='POST' action='../akunpns/aktifkanakun'>";          
                echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";              
                ?>
                <button type="submit" class="btn btn-info btn-xs">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><br />&nbsp&nbsp&nbsp&nbspAktifkan&nbsp&nbsp&nbsp&nbsp
                </button>
                <?php
              }
              ?>
              </form>
        </td>
        <td  align='center' width='20'>
          <?php
              echo "<form method='POST' action='../akunpns/resetpassword'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              ?>
              <button type="submit" class="btn btn-warning btn-xs">Reset<br />Password
              </button>
              </form>
        </td>        
        <td  align='center' width='20'>
          <?php
              echo "<form method='POST' action='../akunpns/hapusakun_aksi'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              ?>
              <button type="submit" class="btn btn-danger btn-xs">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br />Hapus
              </button>
              </form>
        </td>
      </tr>
      <?php
        $no++;
        endforeach;
        else:
        echo "<td  align='center' colspan='6'>Data tidak ditemukan, silahkan cari terlebih dahulu.</td>";
        endif;
      ?>
      
      </tbody>
      
  </table>
</div>
</div>
</div>
</div>
</center>
