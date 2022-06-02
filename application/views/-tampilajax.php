<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<center>
  <div id="unker">  
      Pilih Unit Kerja : 
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

  <div id="pegawai">     
  </div>   
  </center>

<script type="text/javascript"> 
        $("#id_unker").change(function(){
                var id_unker = {id_unker:$("#id_unker").val()};
                   $.ajax({
               type: "POST",
               url : "<?php echo base_url(); ?>home/pegperunker",
               data: id_unker,
               success: function(msg){
               $('#pegawai').html(msg);
               }
            });
              });
</script>