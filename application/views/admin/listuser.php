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
      if ($this->session->userdata('level') == "ADMIN") { 
      ?>
      <td align='right'>
        <form method="POST" action="../admin/tambahuser">
          <button type="submit" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Tambah User
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
  <b>User Management</b><br />
  <?php echo "Jumlah Data : ", $this->madmin->getjmluser(), " User"; ?>
  </div>
  </div>
  <!-- untuk scrollbar -->
  <div style="padding:3px;overflow:auto;width:99%;height:320px;border:1px solid white" >
  <table class="table table-condensed table-hover">
      <tr class='danger'>
        <td align='center' rowspan='2' width='30'>No.</td>
        <td align='center' width='450' rowspan='2'>NIP | Nama<br />Jabatan<br />Unit Kerja</td>
        <td align='center' width='80' rowspan='2' colspan='2'>Username<br/>Level<br/>Last Login</td>
        <td align='center' colspan='16'>Priviledge</td>
        <td align='center' rowspan='2' colspan='3'>Aksi</td>
      </tr>
      <tr class='danger'>
        <td align='center' width='30'>Prof</td>
        <td align='center' width='30'>Edit Prof</td>
        <td align='center' width='30'>C-Prof</td>
        <td align='center' width='20'>Nom</td>
        <td align='center' width='40'>C-No</td>
        <td align='center' width='20'>Stat</td>
        <td align='center' width='30'>C-Stat</td>
        <td align='center' width='20'>Sotk</td>
        <td align='center' width='30'>C-Sotk</td>
        <td align='center' width='20'>Usul Cuti</td>
        <td align='center' width='20'>Proses Cuti</td>
	<td align='center' width='20'>Usul KGB</td>
        <td align='center' width='20'>Proses KGB</td>
	<td align='center' width='20'>Non PNS</td>
        <td align='center' width='20'>Akun PNS</td>
	<td align='center' width='20'>TPP</td>
      </tr>

      <?php
        $no = 1;
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
        <td><?php echo $v['nip'].' | '.$this->mpegawai->getnama($v['nip']).'<br />'.$this->mpegawai->namajab($v['fid_jnsjab'],$idjab).'<br /><u>'.$this->munker->getnamaunker($v['fid_unit_kerja']).'</u>'; ?></td>
        <td>
        <?php 
        $lokasifile = './photo/';
        $filename = $v['nip'].".jpg";

        if (file_exists ($lokasifile.$filename)) {
          $photo = "../photo/".$v['nip'].".jpg";
        } else {
          $photo = "../photo/nophoto.jpg";
        }
        echo "<center><img src='$photo' width='45' height='60'></center>";
        ?>          
        </td>
        <td><?php echo $v['username'].'<br />'.$v['level'].'<br />'.$v['last_login']; ?></td>
        <td align='center'><?php echo $v['profil'] ?></td>
        <td align='center'><?php echo $v['edit_profil'] ?></td>
        <td align='center'><?php echo $v['cetak_profil'] ?></td>
        <td align='center'><?php echo $v['nominatif'] ?></td>
        <td align='center'><?php echo $v['cetak_nominatif'] ?></td>
        <td align='center'><?php echo $v['statistik'] ?></td>
        <td align='center'><?php echo $v['cetak_statistik'] ?></td>
        <td align='center'><?php echo $v['sotk'] ?></td>
        <td align='center'><?php echo $v['cetak_sotk'] ?></td>
        <td align='center'><?php echo $v['usulcuti'] ?></td>
        <td align='center'><?php echo $v['prosescuti'] ?></td>
	<td align='center'><?php echo $v['usulkgb'] ?></td>
        <td align='center'><?php echo $v['proseskgb'] ?></td>
	<td align='center'><?php echo $v['nonpns'] ?></td>
        <td align='center'><?php echo $v['akunpns'] ?></td>
        <td align='center'><?php echo $v['tpp'] ?></td>
	<td align='center' width='20'>
          <?php          
              echo "<form method='POST' action='../admin/edituser'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              echo "<input type='hidden' name='username' id='username' value='$v[username]'>";
              echo "<input type='hidden' name='level' id='level' value='$v[level]'>";
              ?>
              <button type="submit" class="btn btn-primary btn-xs">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span><br />&nbspEdit&nbsp
              </button>
              </form>
        </td>
        <td  align='center' width='20'>
          <?php
              echo "<form method='POST' action='../admin/resetpassword'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              echo "<input type='hidden' name='username' id='username' value='$v[username]'>";
              echo "<input type='hidden' name='level' id='level' value='$v[level]'>";
              ?>
              <button type="submit" class="btn btn-danger btn-xs">Reset<br />Password
              </button>
              </form>
        </td>        
        <td  align='center' width='20'>
          <?php
              echo "<form method='POST' action='../admin/hapususer_aksi'>";          
              echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
              echo "<input type='hidden' name='nama' id='nama' value='$v[username]'>";
              echo "<input type='hidden' name='level' id='level' value='$v[level]'>";
              ?>
              <button type="submit" class="btn btn-warning btn-xs">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span><br />Hapus
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
</div>
</div>
</div>
</center>
