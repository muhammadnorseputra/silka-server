<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/typeahead/jquery.typeahead.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/typeahead/jquery.typeahead.min.css') ?>">
<center>
<div class="container">
	<div class="row">
		<div class="col-md-5 col-md-offset-3">
			<form class="form-horizontal" id="caripegawai"  method="POST" action="<?= base_url('pensiun/tampilnipnama') ?>">
			    <div class="typeahead__container form-group">
			            	<label for="js-nipnama">Cari Pegawai</label>
			        <div class="typeahead__field">
			        
			            <div class="typeahead__query">
			                <input class="js-nipnama" id="js-nipnama" name="filter" placeholder="Ketik NIP atau Nama" autocomplete="off">
			            </div>
			            <div class="typeahead__button">
			                <button type="submit">
			                    <i class="typeahead__search-icon"></i> Cari
			                </button>
			            </div>
			        </div>
			    </div>
			</form>
		</div>
	</div>
</div>

</center>
<style>
.typeahead__container {
 font-size: 1.7rem;
}
#caripegawai .typeahead__list {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>
<script>
$(document).ready(function() {


$.typeahead({
    input: '.js-nipnama',
    minLength: 1,
    order: "asc",
    maxItem: false,
    cache: true,
    offset: false,
    hint: true,
    searchOnFocus: true,
    backdrop: {
        "background-color": "#999"
    },
    source: {
        pegawai: {
            ajax: {
                type: "POST",
                url: "<?php echo base_url('pensiun/filternipnama') ?>",
				dataType: "json",
				data: {
		 			filter: $('input.js-nipnama').val(),
				}
            }
        }
    }
});
});
</script>
