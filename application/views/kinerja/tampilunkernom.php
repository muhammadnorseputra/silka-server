<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<center>
<?php
echo "TAMBAH USUL TPP BULAN ".bulan($bulan)." TAHUN ".$tahun;
?>
<form class="navbar-form navbar-center" role="search" method="POST" action="../kinerja/nomperunker">
  <div class="form-group">
    <div id="unker">  
      <input type='hidden' name='tahun' id='tahun' maxlength='18' value='<?php echo $tahun; ?>'>
      <input type='hidden' name='bulan' id='bulan' maxlength='18' value='<?php echo $bulan; ?>'>
            
      <select name="id_unker" id="id_unker" required>
      <?php
          echo "<option value='0'>- Pilih Unit Kerja -</option>";
          foreach($unker as $uk)
          {
            $telahusul = $this->mkinerja->unkertelahusul($uk['id_unit_kerja'], $tahun, $bulan);
            if ($telahusul == false) {
              echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
            }
          }
      ?>
      </select>
    </div>
  </div>

  <button type="submit" class="btn btn-sm">
  <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Unduh Data Kinerja</button>
</form> 
