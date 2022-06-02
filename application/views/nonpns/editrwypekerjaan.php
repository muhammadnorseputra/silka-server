    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.js"></script>

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
    </script>

  <center> 
    
    <div class="panel panel-info" style="width: 70%; background-color:Beige;">
      <div class='panel-body'>
      <form method='POST' action='../nonpns/rwypekerjaan'>
        <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>'>
        <p align='right'>
          <button type='submit' class='btn btn-warning btn-sm'>&nbsp
          <span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      </form>

      

      <form method='POST' action='../nonpns/editrwypkj_aksi'>
      <input type='hidden' name='nik' id='nik' maxlength='18' value='<?php echo $nik; ?>'>
      <input type='hidden' name='tmt_awal' id='tmt_awal' maxlength='20' value='<?php echo $tmt_awal; ?>'><br/>

      <div class='panel panel-info'>
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
          <b>EDIT RIWAYAT PEKERJAAN</b>
        </div>

        <?php        
            foreach($editrwypkj as $v):
        ?>

      <table class="table table-condensed table-hover">        
        <tr>
        <td width='160' align='right' class='info'><b>Nama</b></td>
          <td><?php echo $this->mnonpns->getnama($nik); ?></td>
          <td>NIK : <?php echo $nik;?></td>
        </tr>
        <tr>
          <td align='right' width='150' class='info'><b>Jenis Non PNS</b></td>
          <td colspan='3'>
            <select name="fid_jenis" id="fid_jenis" required>
              <?php
                //echo "<option value='-'>-- Pilih Jenis --</option>";                
              if ($v['fid_jenis_nonpns']=='') {
                echo "<option value='-'>-- Pilih Jenis --</option>";
              }
                
              foreach($jnsnonpns as $jn)
              {
                if ($v['fid_jenis_nonpns']==$jn['id_jenis_nonpns']) {
                  echo "<option value='".$jn['id_jenis_nonpns']."' selected>".$jn['nama_jenis_nonpns']."</option>";
                } else {
                  echo "<option value='".$jn['id_jenis_nonpns']."'>".$jn['nama_jenis_nonpns']."</option>";
                }              
                  //echo "<option value='".$u['id_jenis_nonpns']."'>".$u['nama_jenis_nonpns']."</option>";
              }
              ?>
            </select>                          
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Tugas Pekerjaan</b></td>
          <td colspan='3'>
            <select name="fid_jabatan" id="fid_jabatan" onChange="showKetJab(this.value)" required>
              <?php
              if ($v['fid_jabnonpns']=='') {
                echo "<option value='-'>-- Pilih Tugas Pekerjaan --</option>";
              }
              foreach($jab as $j)
              {                 
                if ($v['fid_jabnonpns']==$j['id_jabnonpns']) {
                  echo "<option value='".$j['id_jabnonpns']."' selected>".$j['nama_jabnonpns']."</option>";
                } else {
                  echo "<option value='".$j['id_jabnonpns']."'>".$j['nama_jabnonpns']."</option>";
                }
              }
              echo "<option value='".$idjab."'>".$nmjab."</option>";
              ?>
            </select>              
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Unit Kerja</b></td>
          <td colspan='3'>
            <input type="text" name="nama_unker" size='70' maxlength='100' value='<?php echo $v['nama_unit_kerja']; ?>' required />
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Sumber Gaji</b></td>
          <td>
            <select name="fid_sumbergaji" id="fid_sumbergaji" required >
              <?php
              if ($v['fid_sumbergaji']=='') {
                echo "<option value='-'>-- Pilih Sumber Gaji --</option>";
              }
              foreach($gaji as $g)
              { 
                if ($v['fid_sumbergaji']==$g['id_sumbergaji']) {
                  echo "<option value='".$g['id_sumbergaji']."' selected>".$g['nama_sumbergaji']."</option>";
                } else {
                  echo "<option value='".$g['id_sumbergaji']."'>".$g['nama_sumbergaji']."</option>";
                }

              }
              ?>
            </select>
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
          <td align='right' bgcolor='#D9EDF7'><b>Gaji</b></td>
          <td><input type="text" name="gaji" size='12' maxlength='8' onkeyup='validAngka(this)' value='<?php echo $v['gaji']; ?>'/>
            <small class="text-muted">Hanya angka, tanpa Rp. dan tanpa titik</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Tgl Mulai Bekerja :</b></td>
          <td><input type="text" name="tmtawal" class="tanggal" size='15' maxlength='10' value='<?php echo tgl_sql($v['tmt_awal']); ?>' />              
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
          <td align='right' bgcolor='#D9EDF7'><b>Sampai Tanggal :</b></td>
          <td><input type="text" name="tmtakhir" class="tanggal" size='15' maxlength='10' value='<?php echo tgl_sql($v['tmt_akhir']); ?>' />              
            <small class="text-muted">** WAJIB DIISI</small>
          </td>
        </tr>
        <tr>
          <td align='right' bgcolor='#D9EDF7'><b>Surat Keputusan :</b></td>
          <td colspan='4'>
            <table class="table">
              <tr>
                <td width='100' align='right'>No. SK</td>
                <td>
                  <input type="text" name="no_sk" size='40' maxlength='50' value='<?php echo $v['no_sk']; ?>' required />
                </td>
                <td width='80' align='right'>Tgl. SK</td>
                <td>
                  <input type="text" class='tanggal' name="tgl_sk" size='12' maxlength='10' value='<?php echo tgl_sql($v['tgl_sk']); ?>' required />
                </td>
              </tr>
              <tr>
                <td width='100' align='right'>Pejabat yang memutuskan</td>
                <td colspan='3'>
                  <input type="text" name="pejabat_sk" size='70' maxlength='50' value='<?php echo $v['pejabat_sk']; ?>' required /><br />
                  <small class="text-muted">Diisi dengan nama jabatan, bukan nama orang yang menduduki jabatan.</small>
                </td>
              </tr>              
            </table>
          </td>
        </tr>
        <tr>
          <td colspan='5'>
            <p align="right">
              <button type="submit" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
              </button>
            </p>
          </td>
        </tr>
      </table>
      <?php
        endforeach;
      ?>
    </div>
  </form>
</div>
</div>
</center>