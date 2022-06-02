<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<center>
<!--<a class="media" href="assets/ManualCuti.pdf"></a>-->
<a class='media' href=<?php echo base_url()."assets/Manual-Cuti.pdf"; ?>></a>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    <script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.media').media({width: 900});
            });
        </script>

<!--
  <form class="navbar-form navbar-center" role="search" method="POST" action="../pegawai/tampilnipnama">
    <div class="form-group">    	
      <input type="text" name="data" id="data" class="form-control" placeholder="Ketik NIP atau Nama" size='25' maxlength='25'>
      <button type="submit" class="btn btn-success">
        <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Cari Pegawai</button>
    </div>
  </form>  
 -->
</center>
