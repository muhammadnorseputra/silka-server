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
  <div class="panel panel-default" style="width: 80%; background-color:Beige;">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/admin_tampilupdateusul'>";          
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

      <form method='POST' name='formeditusulcuti' action='../kgb/admin_updateusul_aksi'>
      <input type='hidden' name='fid_pengantar' id='fid_pengantar' value='<?php echo $fid_pengantar; ?>'>
      <input type='hidden' name='nip' id='nip' maxlength='18' value='<?php echo $nip; ?>'>
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <b>UPDATE USUL KGB</b>
        </div>
        <?php
          foreach($kgb as $v):
        ?>
       <table class="table">
          <tr>
            <td align='center'>
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='120'><b>No. Pengantar</b> :</td>
                  <td width='300'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='150'><b>Tgl. Pengantar</b> :</td>
                  <td><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='9'>
                    <center>
                      <?php                        
                         $lokasifile = './photo/';
                          $filename = "$nip.jpg";
                          if (file_exists ($lokasifile.$filename)) {
                            $photo = "../photo/$nip.jpg";
                          } else {
                            $photo = "../photo/nophoto.jpg";
                          }
                        echo "<center><img class='img-thumbnail' src='$photo' width='100' height='125' alt='$photo'>";
                      ?>
                    </center>
                  </td>
                </tr>
                <tr>
                  <td align='right'><b>NIP</b> :</td>
                  <td><?php echo $v['nip']; ?></td>
                  <td align='right'><b>Nama</b> :</td>
                  <td><?php echo $this->mpegawai->getnama($v['nip']); ?></td>
                </tr>
                <?php 
                    if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
                    }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
                    }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
                    }
                ?>
                <tr>
                  <td align='right'><b>Jabatan</b> :</td>
                  <td colspan='3'><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br /><u>', $v['nama_unit_kerja'],'</u>'; ?></td>
                </tr>
                <tr class='info'>
                  <td align='right'><b>Gapok Lama</b> :</td>
                  <td>
                    Rp. <input type='text' size='10' maxlength='7' name='gapoklama' onkeyup='validAngka(this)' value='<?php echo $v['gapok_lama']; ?>' />
                    <small id="noskHelpInline" class="text-muted">
                      ditulis tanpa titik
                    </small>
                  </td>
                  <td align='right'><b>TMT</b> :</td>
                  <td>
                    <input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tmtgajilama' class='tanggal' value='<?php echo tgl_sql($v['tmt_gaji_lama']); ?>' />
                    <small id="passwordHelpInline" class="text-muted">
                      Hari-Bulan-Tahun (HH-BB-TTTT).
                    </small>
                  </td>
                </tr>                
                <tr class='info'>
                  <td align='right'><b>Masa Kerja</b> :</td>
                  <td>
                  <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkthnlama' value='<?php echo $v['mk_thn_lama']; ?>' /> Tahun
                  <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkblnlama' value='<?php echo $v['mk_bln_lama']; ?>' /> Bulan</td>
                  <td align='right'><b>Dalam Golru</b> :</td>
                  <td>
                    <?php //echo $this->mpegawai->getnamapangkat($v['fid_golru_lama']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_lama']).')'; ?>
                    <?php
                    $golru = $this->mpegawai->golru()->result_array();
                    echo "<select name='fid_golru_lama' id='fid_golru_lama'>";  
                    foreach($golru as $gl)
                    {
                      if ($v['fid_golru_lama'] == $gl['id_golru']) {
                        echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                      } else {
                        echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                      }
                    }
                    ?>
                  </td>
                </tr>
                <tr class='info'>
                  <td align='right'><b>Berdasarkan<br/>SK Nomor</b> :</td>
                  <td colspan='3'>
                    <small id="noskHelpInline" class="text-muted">
                      Nomor SK&nbsp&nbsp&nbsp:
                    </small>
                    <input type='text' size='30' name='nosklama' value='<?php echo $v['sk_lama_no']; ?>' /><br />
                    <small id="noskHelpInline" class="text-muted">
                      Tanggal SK :
                    </small>
                    <input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tglsklama' class='tanggal' value='<?php echo tgl_sql($v['sk_lama_tgl']); ?>' />
                    <small id="tglskHelpInline" class="text-muted">
                      Hari-Bulan-Tahun (HH-BB-TTTT).
                    </small>
                    <br />
                    <small id="pejabatskHelpInline" class="text-muted">
                      Pejabat SK&nbsp&nbsp:
                    </small>
                    <input type='text' size='80' maxlength='100' name='pjblama' value='<?php echo $v['sk_lama_pejabat']; ?>'/>
                  </td>                  
                </tr>


                <!-- Start : Data Gaji Baru -->
                <tr class='success'>
                  <td align='right'><b>Gapok Baru</b> :</td>
                  <td>
                    Rp. <input type='text' size='10' maxlength='7' name='gapokbaru' onkeyup='validAngka(this)' value='<?php echo $v['gapok_baru']; ?>' />
                    <small id="noskHelpInline" class="text-muted">
                      ditulis tanpa titik
                    </small>
                  </td>
                  <td align='right'><b>TMT Gaji Baru</b> :</td>
                  <td>
		    <?php
                      if (($v['tmt_gaji_baru'] == null) || ($v['tmt_gaji_baru'] == '')) { 
			$tmtgajibaru = '';
		      } else {
		        $tmtgajibaru = tgl_sql($v['tmt_gaji_baru']);
		      }
                    ?>

                    <input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tmtgajibaru' class='tanggal' value='<?php echo $tmtgajibaru; ?>' />
                    <small id="passwordHelpInline" class="text-muted">
                      Hari-Bulan-Tahun (HH-BB-TTTT).
                    </small>
                  </td>
                </tr>                
                <tr class='success'>
                  <td align='right'><b>MK Baru</b> :</td>
                  <td>
                  <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkthnbaru' value='<?php echo $v['mk_thn_baru']; ?>' /> Tahun
                  <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='mkblnbaru' value='<?php echo $v['mk_bln_baru']; ?>' /> Bulan</td>
                  <td align='right'><b>TMT Gaji Berikutnya</b> :</td>
                  <td>
		     <?php
                      if (($v['tmt_gaji_berikutnya'] == null) || ($v['tmt_gaji_berikutnya'] == '')) {
                        $tmtgajiberikutnya = '';
                      } else {
                        $tmtgajiberikutnya = tgl_sql($v['tmt_gaji_baru']);
                      }
                    ?>
                    <input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tmtberikutnya' class='tanggal' value='<?php echo $tmtgajiberikutnya; ?>' />
                    <small id="passwordHelpInline" class="text-muted">
                      Hari-Bulan-Tahun (HH-BB-TTTT).
                    </small>
                  </td>                  
                </tr>
                <tr class='success'>
                  <td align='right'><b>Golru Baru</b> :</td>
                  <td colspan='3'>
                    <?php //echo $this->mpegawai->getnamapangkat($v['fid_golru_lama']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_lama']).')'; ?>
                    <?php
                    $golru = $this->mpegawai->golru()->result_array();
                    echo "<select name='fid_golru_baru' id='fid_golru_baru'>";  
                    foreach($golru as $gl)
                    {
                      if ($v['fid_golru_lama'] == $gl['id_golru']) {
                        echo "<option value='".$gl['id_golru']."' selected>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                      } else {
                        echo "<option value='".$gl['id_golru']."'>".$gl['nama_golru'].' - '.$gl['nama_pangkat']."</option>";
                      }
                    }
                    ?>
                  </td>
                </tr>
                <!-- Start : Data Gaji Lama -->

                <tr>                
                  <td align='center' colspan='2'><u><b>Diusulkan oleh</b></u></td>
                  <td align='left' colspan='4'>
                      <?php echo $this->mpegawai->getnama($v['user_usul']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_usul']); ?>
                  </td>    
                </tr>
                <tr class='danger'>
                  <td align='right'>Status Usulan :</td>
                  <td colspan='4'>
                    <select name="id_statusul" id="id_statusul" required>
                      <?php
                      foreach($statuskgb as $sc)
                      {
                        if ($v['fid_status']==$sc['id_statuskgb']) {
                          echo "<option value='".$sc['id_statuskgb']."' selected>".$sc['nama_statuskgb']."</option>";
                        } else {
                          echo "<option value='".$sc['id_statuskgb']."'>".$sc['nama_statuskgb']."</option>";
                        }
                        
                      }
                      ?>
                    </select>    
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
