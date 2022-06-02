<script type="text/javascript">
  //validasi textbox khusus angka
  function validAngka(a)
  {
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }

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
    var url="tampiltabelharjab";
    url=url+"?id="+str1;
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
      document.getElementById("tampilkan").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
  
  function showDetail(id) {
   var modal = $("#ModalJST");
   modal.modal('show');
   $.getJSON('<?= base_url('harjab/detailharjab/') ?>', {id: id}, function(result){
   	modal.find('[name="id_jabatan"]').val(id);
   	modal.find('.id_namajabatan').html(result[0].nama_jabatan);
   	modal.find('[name="kelasjabatan"]').val(result[0].kelas);
   	modal.find('[name="hargajabatan"]').val(result[0].harga);
   	
   });
  }
  
  function showDetailJFU(id) {
   var modal = $("#ModalJFU");
   modal.modal('show');
   $.getJSON('<?= base_url('harjab/detailharjab_jfu/') ?>', {id: id}, function(result){
   	modal.find('[name="id_jabfu"]').val(id);
   	modal.find('.id_namajabatan').html(result[0].nama_jabfu);
   	modal.find('[name="kelasjabatan"]').val(result[0].kelas);
   	modal.find('[name="hargajabatan"]').val(result[0].harga);
   	
   });
  }
</script>

<!-- Default panel contents -->
  <div class="container">
  <div class="panel panel-default" style="width:100%;height:80%;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-info" style="padding:3px;overflow:auto;width:100%;height:100%;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>CEK KELAS DAN HARGA JABATAN</b>
        </div>
  
  <table class='table table-condensed'>
    <tr>                  
      <td align='right' width='30'>
        <form method="POST" action="../kinerja/cariusul">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 
	
  
  <center>
    <form method='POST' name='formupdatestatus'>    
      <table>      
      <tr>        
        <td>
          <select name="thn" id="thn" required onChange="showData(this.value)" />
          <?php
          echo "<option value='0'>- Pilih Unitkerja -</option>";
          foreach($unker as $u)
          {
            echo "<option value='".$u['id_unit_kerja']."'>".$u['nama_unit_kerja']."</option>";
          }
          ?>
          </select>    
        </td>
      </tr>
      </table>
      </form>
      

<hr>
  <!-- untuk ajax -->
  

  </center>
  <?php if($this->session->flashdata('message') <> ''): ?>
	  <div class="alert alert-info" role="alert">
	  	<?php echo $this->session->flashdata('message'); ?>
	  </div>
	<?php endif; ?>
  <div id='tampilkan'></div>
  </div>
</div>
</div>

</div>
