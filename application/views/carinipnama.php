<center style="margin-top:30px;">
  <form class="navbar-form navbar-center" role="search" method="POST" action="../pegawai/tampilnipnama">
    <div class="form-group" style="display: flex; align-items: center; justify-content:center">    	
      <input autofocus style="border:2px solid #ccc; border-right:0px; border-radius:0px; outline: none;font-size: 1.3em;height: 50px!important;" type="text" name="data" id="data" class="form-control" placeholder="Ketik NIP atau Nama" size='60' maxlength='18'>
      <button type="submit" class="btn btn-primary" style="height: 50px!important; border-radius:0px;">
        <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Cari Pegawai</button>
    </div>
  </form>  
</center>

<!-- JS file -->
<script src="<?= base_url('assets/autocomplete/jquery.easy-autocomplete.min.js') ?>"></script>

<!-- CSS file -->
<link rel="stylesheet" href="<?= base_url('assets/autocomplete/easy-autocomplete.css') ?>">
<script>
var options = {
	url: "<?= base_url('pegawai/show_autocomplete') ?>",
	getValue: function(element) {
		return `${element.nama}`;
	},
	listLocation: "items",
	ajaxSettings: {
	    dataType: "json",
	    method: "POST",
	    data: {
	      dataType: "json"
	    }
	  },
	template: {
        type: "custom",
        method: function(value, item) {
			return `
			<div style="display: flex; justify-content:start;">
				<div>
					<img src="http://silka.balangankab.go.id/photo/${item.nip}.jpg" style="border-radius: 8px;" width="30"/>
				</div>
				<div style="margin-left: 10px;">
					<span style="color:#888; font-size: 10px; text-overflow: ellipsis;">${item.nama_unit_kerja}</span><br>${value} ${item.gelar_belakang} / ${item.nip}
				</div>
			</div>
			`;
		}
    },
	list: {
		maxNumberOfElements: 999999,
		match: {
			enabled: true
		},
		showAnimation: {
			type: "normal", //normal|slide|fade
			time: 200,
			callback: function() {}
		},

		hideAnimation: {
			type: "fade", //normal|slide|fade
			time: 200,
			callback: function() {}
		},
		onChooseEvent: function() {
			var itemData = $("#data").getSelectedItemData();
			var value = `${itemData.nip}`;

			$("#data").val(value).trigger("change");
		}
	},
	preparePostData: function(data) {
	    data.q = $("#data").val();
	    return data;
	  },
	requestDelay: 300
};

$("#data").easyAutocomplete(options);
</script>


