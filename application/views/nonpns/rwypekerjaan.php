<script type="text/javascript">
function showtambahrwypkj(nik) {
  $.ajax({
    type: "POST",
    url: "<?php echo site_url('nonpns/showtambahrwypkj'); ?>",
    data: "nik="+nik,
    success: function(data) {
      $("#rwypkj").html(data);
    },
    error:function (XMLHttpRequest) {
      alert(XMLHttpRequest.responseText);
    }
    })
  };

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

// Showunker untuk menampilkan unit kerja pada textbox sehingga bisa diedit manual
  function showunker(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataunker";
    url=url+"?idunker="+str1;      
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedUnker;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedUnker(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampilunker").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampilunker").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 

</script>

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
  <div class="panel panel-default" style="width: 85%;">
    <div class="panel-body">
      <table class='table table-condensed'>
        <tr> 
          <td align='right'>
            <?php
              if (($this->session->userdata('nonpns_priv') == "Y") OR ($this->session->userdata('level') != "TAMU")) { 
                echo "<form method='POST' name='tambahpkj'>";
              ?>               
                  <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>' />        
                  <button type='button' class='btn btn-info btn-sm' onClick='showtambahrwypkj(tambahpkj.nik.value)'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>&nbspTambah Riwayat Pekerjaan
                  </button>
              <?php
                 echo "</form>";
              }
            ?>            
          </td>
          <td align='right' width='50'>
            <?php
              echo "<form method='POST' action='../nonpns/nonpnsdetail'>";          
              echo "<input type='hidden' name='nik' id='nik' maxlength='18' value='$nik'>";
            ?>
                <button type="submit" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
            <?php
              echo "</form>";          
            ?>
          </td>            
        </tr>
      </table> 

      <div id='rwypkj'></div>
    
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-education" aria-hidden="true"></span>
        <?php
          echo '<b>RIWAYAT PEKERJAAN</b><br />';
          echo $this->mnonpns->getnama($nik);
          echo " ::: NIK. ".$nik
        ?>
        </div>
        <table class="table table-condensed">
          <tr>
            <td align='center'>
                <table class='table table-hover table-condensed'>
                  <tr class='info'>
                    <th width='20'><center>#</center></th>
                    <th width='100'><center>Jenis Non PNS</center></th>                    
                    <th width='300'><center>Unit Kerja<br /><u>Jabatan</u></center></th>
                    <th align='10'><center>Gaji<br /><u>Sumber Gaji</u></center></th>                    
                    <th align='100'><center>TMT</center></th>
                    <th width='300'><center>Surat Keputusan</center></th>
                    <th colspan='2'><center>Aksi</center></th>
                  </tr>
                  <?php
                    $no=1;
                    foreach($rwypdk as $v):                    
                  ?>
                  <tr>
                    <td align='center'><?php echo $no;?></td>                    
                    <td align='center'><?php echo $this->mnonpns->getjnsnonpns($v['fid_jenis_nonpns']); ?></td>
                    <td align='left'><?php echo $v['nama_unit_kerja'].'<br/><u>'.$this->mnonpns->getjabatan($v['fid_jabnonpns']).'</u>'; ?></td>
                    <td align='center'><?php echo 'Rp. '.indorupiah($v['gaji']).'<br/><u>'.$this->mnonpns->getsumbergaji($v['fid_sumbergaji']).'</u>'; ?></td>                    
                    <td width='100' align='center'><?php echo tgl_indo($v['tmt_awal']).'<br/>s/d<br/>'.tgl_indo($v['tmt_akhir']); ?></td>
                    <td align='left'><?php echo $v['pejabat_sk'].'<br/>'.$v['no_sk'].'<br/>'.tgl_indo($v['tgl_sk']); ?></td>

                    <td align='center' align='50'>
                      <?php
                      //echo "<form method='POST' action='../nonpns/editrwypkj'>";
                      echo "<form method='POST' name='editpkj' action='../nonpns/editrwypkj'>";
                      echo "<input type='hidden' name='nik' id='nik' value='$nik'>";
                      echo "<input type='hidden' name='tmt_awal' id='tmt_awal' value='$v[tmt_awal]'>";
                      ?>
                      <button type="submit" class="btn btn-success btn-xs">
                      <span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span><br/>&nbspEdit&nbsp
                      </button>
                      <?php
                        echo "</form>";
                      ?>
                    </td>
                    <td align='center' align='50'>
                      <?php
                      echo "<form method='POST' action='../nonpns/hapusrwypkj'>";          
                      echo "<input type='hidden' name='nik' id='nik' value='$nik'>";
                      echo "<input type='hidden' name='tmt_awal' id='tmt_awal' value='$v[tmt_awal]'>";
                      ?>
                      <button type="submit" class="btn btn-warning btn-xs ">
                      <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span><br/>Hapus
                      </button>
                      <?php
                        echo "</form>";
                      ?>
                    </td>
                  </tr>
                  <?php
                    $no++;
                    endforeach;
                  ?>
                </table>
            </td>
          </tr>
        </table>        
      </div>
    </div>
  </div>  
</center>