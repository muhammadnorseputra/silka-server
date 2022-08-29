	
<!-- JS file -->
<script src="<?= base_url('assets/autocomplete/jquery.easy-autocomplete.min.js') ?>"></script>

<!-- CSS file -->
<link rel="stylesheet" href="<?= base_url('assets/autocomplete/easy-autocomplete.css') ?>">


<script type="text/javascript">
  function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
      {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
      }
    if (window.ActiveXObject)
      { 
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }
  
  
  function showData(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="show_refjabfubkn";
    url=url+"?nmjab="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilkan").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilkan").innerHTML= "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
  

</script>

<!-- Default panel contents -->
  <center>
    <div class="panel panel-info" style="padding:3px;overflow:auto;width:98%;height:620px;">
      <div class='panel-heading' align='left'><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
        <b>DATA REFERENSI JFU BKN</b>
      </div>
	
  <?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?> alert-info" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>
  
  <center>
    <form method='POST' name='formrefjfu' style='margin-top: 30px;'>
	<div class="row" style="padding:3px;width:70%;height:auto;">
		<div class="col-md-2 text-center"></div>
		<div class="col-md-7 text-center">
			<input class='form-control' placeholder='Ketik Nama Jabatan Fungsional Umum' type='text' name='nmjab' id='nmjab' maxlength='50'>
		</div>
		<div class="col-md-2 text-left">
			<button type="button" class="btn btn-info" onClick="showData(formrefjfu.nmjab.value)">
            		<span class="fa fa-search" aria-hidden="true"></span> Cari Jabatan
          </button>
		</div>
	</div>
      </form>

  <!-- untuk ajax -->
  
  </center>
  <div id='tampilkan'></div>
  </div>
</center>

<script>
var options = {
	url: "<?= base_url('home/show_autocomplete/jabatan') ?>",
	getValue: "nama",
	listLocation: "items",
	ajaxSettings: {
	    dataType: "json",
	    method: "POST",
	    data: {
	      dataType: "json"
	    }
	  },
	list: {
		maxNumberOfElements: 999999,
		match: {
			enabled: true
		},
		showAnimation: {
			type: "fade", //normal|slide|fade
			time: 400,
			callback: function() {}
		},

		hideAnimation: {
			type: "fade", //normal|slide|fade
			time: 200,
			callback: function() {}
		}
	},
	preparePostData: function(data) {
	    data.q = $("#nmjab").val();
	    return data;
	  },
	requestDelay: 300
};

$("#nmjab").easyAutocomplete(options);
</script>
