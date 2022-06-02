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
    var url="carivalusul";
    url=url+"?thn="+str1;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("ditemukan").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("ditemukan").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
</script>

<!-- Default panel contents -->
  <center>
  <div class="panel panel-default" style="width:99%;height:640px;border:0px solid white">
  <div class="panel-body">

  <div class="panel panel-info"   style="padding:3px;overflow:auto;width:90%;height:610px;">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>VALIDASI USUL HUKUMAN DISIPLIN</b>
        </div>
  
  <table class='table table-condensed'>
    <tr>      
      <td align='right' width='50'>
        <form method="POST" action="../home">
          <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </form>
      </td>
    </tr>
  </table> 

  <?php
  if ($pesan != '') {
    ?>
    <div class="<?php echo $jnspesan; ?>" alert-info role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php
      echo $pesan;
      ?>          
    </div> 
    <?php
  }
  ?>
  
  <center>
    <form method='POST' name='formvalusul'>    
      <table>      
      <tr>        
        <td><b>Pilih Tahun TMT Hukuman Disiplin</b>&nbsp</td>
        <td>
          <select name="thntmt" id="thntmt" required onChange="showData(this.value)" >
            <option value='0'>-- Tahun TMT --</option>
            <?php
            $thntmt = $this->mhukdis->gettahuntmt()->result_array();
            foreach($thntmt as $tt)
            {
              echo "<option value='".$tt['tahun']."'>".$tt['tahun']."</option>";
            }
            ?>
          </select>
        </td>
      </tr>
      </table>
      </form>
      
  <!-- untuk ajax -->
  
  </center>
  <div id='ditemukan'></div>
  </div>
</div>
</div>
</center>
