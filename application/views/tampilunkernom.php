<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<center>
<form class="navbar-form navbar-center" role="search" method="POST" action="../pegawai/nomperunker">
  <div class="form-group">
    <div id="unker">  
      <select name="id_unker" id="id_unker">
      <?php
          echo "<option>- Pilih Unit Kerja -</option>";
          foreach($unker as $uk)
          {
              echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
          }
      ?>
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-info btn-sm">
  <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Tampil Nominatif</button>
</form> 
