<center>
<form class="navbar-form navbar-center" role="search" method="POST" action="../sotk/cetak"  target='_blank'>
  <div class="form-group">
    <div id="unker">  
      <select name="id_unker" id="id_unker">
      <?php
          echo "<option>- Pilih Unit Kerja -</option>";
          foreach($pilihunker as $uk)
          {
              echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
          }
      ?>
      </select>
    </div>
  </div>
  <?php
  if ($this->session->userdata('cetak_sotk_priv') == "Y") { 
    echo "<button type='submit' class='btn btn-info btn-sm'>";
    echo "<span class='glyphicon glyphicon-print' aria-hidden='false'></span> Cetak SOTK</button>";
  } else {
    echo "<button type='' class='btn btn-danger btn-sm' disabled>";
    echo "<span class='glyphicon glyphicon-print' aria-hidden='false'></span> Cetak SOTK</button>";
  }
  ?>
</form> 
