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

  //validasi textbox khusus angka dan tanda strip (-)
  function validAngkaStrip(a)
  {
    if(!/^[0-9.-]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/detailpengantar'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-warning btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' name='formtambahusul' action='../kgb/editusul_aksi'>
      <input type='hidden' name='nip' id='nip' value='<?php echo $nip; ?>'>
      <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $idpengantar; ?>'>

      <div class="panel panel-success">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>EDIT USUL KGB</b>
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
                  <td align='right' width='120'><b>Tgl. Pengantar</b> :</td>
                  <td><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='6'>
                    <center><img src='../photo/<?php echo $v['nip'];?>.jpg' width='90' height='120' alt='$nip.jpg'>
                    <br /><br />
                    <button type='submit' class='btn btn-info btn-sm'>
                      <span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbspSimpan
                    </button>
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
                      if ($v[fid_golru_lama] == $gl[id_golru]) {
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
                    <input type='text' size='30' name='nosk' value='<?php echo $v['sk_lama_no']; ?>' /><br />
                    <small id="noskHelpInline" class="text-muted">
                      Tanggal SK :
                    </small>
                    <input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tglsk' class='tanggal' value='<?php echo tgl_sql($v['sk_lama_tgl']); ?>' />
                    <small id="tglskHelpInline" class="text-muted">
                      Hari-Bulan-Tahun (HH-BB-TTTT).
                    </small>
                    <br />
                    <small id="pejabatskHelpInline" class="text-muted">
                      Pejabat SK&nbsp&nbsp:
                    </small>
                    <input type='text' size='80' maxlength='100' name='pjbpengantar' value='<?php echo $v['sk_lama_pejabat']; ?>'/>
                  </td>                  
                </tr>
                <tr>                
                <td align='center' colspan='3'><u><b>Diusulkan oleh</b></u></td>
                <td align='center'><u><b>Status Usulan</b></u></td>
                </tr>
                <tr>              
                  <td colspan='3' align='center'><?php echo $this->mpegawai->getnama($v['user_usul']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_usul']); ?></td>    
                  <td align='center'><?php echo $this->mkgb->getstatuskgb($v['fid_status']); ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      <?php
        endforeach;
      ?>  
      </div>      
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