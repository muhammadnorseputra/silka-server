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

  
  function showKetCuti(idjnscuti) {
  $.ajax({
    type: "POST",
    url: "<?php echo site_url('cuti/showketcuti'); ?>",
    data: "idjnscuti="+idjnscuti,
    success: function(data) {
      $("#KetCuti").html(data);
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
  
</script>

<center>   
  <div class="panel panel-danger" style="width: 80%; background-color:Beige;">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../cuti/admin_tampilupdateusul'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$fid_pengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formeditusulcuti' action='../cuti/admin_updateusul_aksi'>
      <input type='hidden' name='fid_pengantar' id='fid_pengantar' value='<?php echo $fid_pengantar; ?>'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <b>EDIT USUL CUTI</b>
        </div>
        <?php
          foreach($cuti as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>                           
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='110'>No. Pengantar :</td>
                  <td width='300'><input type="text" size='30' name="nopengantar" value="<?php echo $nopengantar; ?>" disabled/></td>
                  <td align='right' width='110'>Tgl. Pengantar :</td>
                  <td><input type="text" name="tglpengantar" class="tanggal" value="<?php echo tgl_indo($tglpengantar); ?>" disabled /></td>
                  <td rowspan='5'><div id='nama'>
                  <?php
                    echo "<center><img class='img-thumbnail' src='../photo/$v[nip].jpg' width='100' height='125' alt='$v[nip].jpg'>";
                  ?>
                  </div></td>
                </tr>
                <tr>
                  <td align='right'>NIP :</td>
                  <td><input type="text" name="nip" id="nip" size='20' value="<?php echo $v['nip']; ?>" required disabled /></td>                  
                  <td align='right'>Nama :</td>
                  <td><input type="text" name="nama" size='35' value="<?php echo $nama; ?>" disabled/></td>
                </tr>                
                <tr>
                  <td align='right'>Jenis Cuti :</td>
                  <td>
                    <select name="id_jnscuti" id="id_jnscuti" onChange="showKetCuti(this.value)" required />
                      <?php
                      foreach($jnscuti as $jc)
                      {
                        if ($v['fid_jns_cuti']==$jc['id_jenis_cuti']) {
                          echo "<option value='".$jc['id_jenis_cuti']."' selected>".$jc['nama_jenis_cuti']."</option>";
                        } else {
                          echo "<option value='".$jc['id_jenis_cuti']."'>".$jc['nama_jenis_cuti']."</option>";
                        }
                        
                      }
                      ?>
                    </select>
                  </td>
                  <td align='left' colspan='2'><div id='KetCuti'></div></td>
                </tr>                
                <tr>
                  <td align='right'>Tahun :</td>
                  <td>
                    <input type="text" name="tahun" size='8' maxlength='4' value="<?php echo $v['thn_cuti']; ?>" required/>
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspJumlah Hari : 
                    <input type="text" name="jmlhari" size='8' maxlength='2' value="<?php echo $v['jml']; ?>" required/>                            
                  </td>
                  <td align='right'>Tanggal Cuti :</td>
                  <td colspan='1'>
                    <input type="text" name="tglmulai" size='12' class="tanggal" value="<?php echo tgl_sql($v['tgl_mulai']); ?>" required /> s/d <input type="text" name="tglselesai" size='12' class="tanggal" value="<?php echo tgl_sql($v['tgl_selesai']); ?>" required />
                  </td>
                </tr>
                <tr>
                  <td align='right'>Alamat :</td>
                  <td colspan='3'>
                    <input type="text" name="alamat" size='100' maxlength='200' value="<?php echo $v['alamat']; ?>" required/>
                  </td>                  
                </tr>
                <tr>
                <td align='center' colspan='2'>Catatan Pejabat Kepegawaian</td>
                <td align='center' colspan='2'>Catatan / Pertimbangan Atasan Langsung</td>
                <td align='left' colspan='2'>Keputusan Pejabat Yang Berwenang</td>
                </tr>
                <tr>
                  <td colspan='2' align='right'>
                    <textarea id="catatan_pej_kepeg" name="catatan_pej_kepeg" rows="3" cols="43" required><?php echo $v['catatan_pej_kepeg']; ?></textarea>
                  </td>
                  <td colspan='2' align='center'>
                    <textarea id="catatan_atasan" name="catatan_atasan" rows="3" cols="43"><?php echo $v['catatan_atasan']; ?></textarea>
                  </td>
                  <td colspan='2' align='left'>
                    <textarea id="keputusan_pej" name="keputusan_pej" rows="3" cols="43"><?php echo $v['keputusan_pej']; ?></textarea>
                  </td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Status Usulan :</td>
                  <td colspan='4'>
                    <select name="id_statusul" id="id_statusul" required />
                      <?php
                      foreach($statuscuti as $sc)
                      {
                        if ($v['fid_status']==$sc['id_statuscuti']) {
                          echo "<option value='".$sc['id_statuscuti']."' selected>".$sc['nama_statuscuti']."</option>";
                        } else {
                          echo "<option value='".$sc['id_statuscuti']."'>".$sc['nama_statuscuti']."</option>";
                        }
                        
                      }
                      ?>    
                  </td>
                </tr>
              </table>   
            </td>
          </tr>
        </table>
        <?php
        endforeach;
        ?>
        </div>
        <p align="right">          
          <button type='submit' class='btn btn-success btn-sm'>
          <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
          </button>
        </p>        
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-danger">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
