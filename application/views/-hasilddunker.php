<!-- Default panel contents -->
  <div class="panel-heading">Tampil Pegawai</div>

  <!-- Table -->
  <table class="table table-bordered">
      <tr>
        <td>No</td>
        <td>NIP</td>
        <td>Nama</td>
        <td>Alamat</td>
        <td>Aksi</td>
      </tr>
      <?php
        $no = 1;
        foreach($data as $v):
      ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $v['nip']; ?></td>
        <td><?php echo $v['nama']; ?></td>
        <td><?php echo $v['tmp_lahir'].' / ',$v['tgl_lahir']; ?></td>
        <td>Detail | Edit</td>
      </tr>
      <?php
        $no++;
        endforeach;
      ?>
  </table>