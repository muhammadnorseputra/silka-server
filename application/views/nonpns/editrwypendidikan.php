<!-- untuk inputan hanya angka dengan javascript -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
      $(document).ready(function () {
        $('.tanggal').datepicker({
          format: "dd-mm-yyyy",
          todayHighlight: true,
          clearBtn: true,
          autoclose:true
        });
      });

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

  function showJurPen(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showjurpenrwy";
    url=url+"?idtp="+str1;   
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedJurpen;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedJurpen(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampiljurpen").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampiljurpen").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Loading...</center>";
    }
  }   

</script>

<center>  

  <div class='panel panel-default' style="width: 70%; background-color:Beige;">
    <div class='panel-body'>
      <form method='POST' action='../nonpns/rwypendidikan'>
        <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>'>
        <p align='right'>
          <button type='submit' class='btn btn-warning btn-sm'>&nbsp
          <span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      </form>


      <form method='POST' action='../nonpns/editrwypdk_aksi'>
      <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>'>
      <input type='hidden' name='fid_tingkat_lama' id='fid_tingkat_lama' maxlength='20' value='<?php echo $fid_tingkat; ?>'><br/>

        <div class='panel panel-success'>
          <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
          <b>EDIT RIWAYAT PENDIDIKAN</b>
          </div>

          <?php
          foreach($detailrwypdk as $v):
          ?>

          <table class='table'>
            <tr>
              <td align='center'>
                <table class="table table-condensed table-hover">
                  <tr>
                    <td width='160' align='right'>Nama :</td>
                    <td><?php echo $this->mnonpns->getnama($nik); ?></td>
                    <td>NIK : <?php echo $nik;?></td>
                  </tr>
                  <tr>
                    <td align='right'>Tingkat Pendidikan :</td>
                    <td width='150'>
                      <select name="fid_tingpen" id="fid_tingpen" onChange="showJurPen(this.value)" required>
                      <?php
                      foreach($tingpen as $tp)
                      {              
                        if ($v['fid_tingkat']==$tp['id_tingkat_pendidikan']) {
                          echo "<option value='".$tp['id_tingkat_pendidikan']."' selected>".$tp['nama_tingkat_pendidikan']."</option>";
                        } else {
                          echo "<option value='".$tp['id_tingkat_pendidikan']."'>".$tp['nama_tingkat_pendidikan']."</option>";
                        } 
                      }
                      ?>
                      </select>
                    </td>
                    <td>
                      <div id='tampiljurpen'>
                        <select name='fid_jurpen' id='fid_jurpen' required>
                          <?php
                          $jurpen = $this->mnonpns->jurpen($v['fid_tingkat'])->result_array();
                          foreach($jurpen as $jp) {              
                            if ($v['fid_jurusan']==$jp['id_jurusan_pendidikan']) {
                              echo "<option value='".$jp['id_jurusan_pendidikan']."' selected>".$jp['nama_jurusan_pendidikan']."</option>";
                            } else {
                              echo "<option value='".$jp['id_jurusan_pendidikan']."'>".$jp['nama_jurusan_pendidikan']."</option>";
                            } 
                            //echo "<option value='".$jp['id_jurusan_pendidikan']."'>".$jp['nama_jurusan_pendidikan']."</option>";
                          }
                          ?>
                          </select>
                          Gelar Akademik : <input type='text' name='gelar' size='6' maxlength='10' value='<?php echo $v['gelar']; ?>' />
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td align='right'>Tahun Lulus :</td>
                    <td colspan='2'><input type="text" name="tahunlulus" size="6" onkeyup="validAngka(this)" maxlength="4" value='<?php echo $v['thn_lulus']; ?>' required /></td>
                  </tr>
                  <tr>
                    <td align='right'>Nama Sekolah :</td>
                    <td colspan='2'><input type="text" name="namasekolah" size='50' maxlength='100' value='<?php echo $v['nama_sekolah']; ?>' required /></td>
                  </tr>
                  <tr>
                    <td align='right'>Nama Pimpinan Sekolah :</td>
                    <td colspan='2'><input type="text" name="namakepsek" size='40' maxlength='50' value='<?php echo $v['nama_kepsek']; ?>' /></td>
                  </tr>
                  <tr>
                    <td align='right'>No. Ijazah :</td>
                    <td colspan='2'><input type="text" name="noijazah" size='30' maxlength='50' value='<?php echo $v['no_sttb']; ?>' /></td>
                  </tr>                  
                  <tr>
                    <td align='right'>Tanggal Ijazah :</td>
                    <td colspan='2'><input type="text" name="tglijazah" class="tanggal" size='12' maxlength='10' value='<?php echo tgl_sql($v['tgl_sttb']); ?>' required /></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <?php
          endforeach;
          ?>

        </div>     
        <p align='right'>
          <button type="submit" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>

<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class='alert alert-dismissible alert-danger'>
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>