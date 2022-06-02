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
  <div class="panel panel-info" style="width: 80%">
    <div class="panel-body">
      <form method='POST' action='../hukdis/tampilusulhukdis'>          
      <p align="right">
        <button type="submit" class="btn btn-info btn-sm">
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
        </button>
      </p>
      </form>

      <form method='POST' name='formtambahusul' action='../hukdis/editusul_aksi'>
      <?php
          echo "<input type='hidden' name='nip' id='nip' value='$nip'>";
          echo "<input type='hidden' name='tmt_lama' id='tmt_lama' value='$tmt'>";
          echo "<input type='hidden' name='jnshd_lama' id='jnshd_lama' value='$jnshd'>";
      ?>
      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
          <?php
          echo '<b>DETAIL HUKUMAN DISIPLIN</b><br />';
          ?>
        </div>
        <?php
        foreach($edithd as $v):              
        ?>
        <table class="table">
          <tr>
            <td align='center'>
              <table class='table table-condensed'>
                <tr class='info'>
                  <td align='center' width='15%'><b>IDENTITAS PNS<br/>Pada saat dijatuhi<br/>Hukuman Disiplin</b></td>
                  <td>
                  <table class='table table-condensed'>
                  <tr>
                    <td readonly width="15%">NIP</td>
                    <td readonly width="1%">:</td>
                    <td><?php echo $v['nip'];?></td>
                  </tr>
                  <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td><?php echo $this->mpegawai->getnama($v['nip']),'</b>' ?></td>
                  </tr>
                  <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php echo $v['jabatan']."<br/>TMT Jabatan : ".tgl_indo($v['tmt_jabatan']); ?></td>
                  </tr>
                  <tr>
                    <td>Pangkat (Golru)</td>
                    <td>:</td>
                    <td><?php echo $this->mpegawai->getnamapangkat($v['fid_golru'])." (".$this->mpegawai->getnamagolru($v['fid_golru']).")<br/>TMT Pangkat (Golru) : ".tgl_indo($v['tmt_golru']); ?></td>
                  </tr>
                  <tr>
                    <td>Gaji</td>
                    <td>:</td>
                    <td><?php echo "Rp. ".indorupiah($v['gaji'])."<br/>TMT Gaji : ".tgl_indo($v['tmt_golru']); ?></td>
                  </tr>
                  </table>
                  </td>
                  <td colspan='2' align='center' width='30%'>
                  <?php
                    $lokasifile = './photo/';
                    $filename = "$v[nip].jpg";
                    if (file_exists ($lokasifile.$filename)) {
                      $photo = "../photo/$v[nip].jpg";
                    } else {
                      $photo = "../photo/nophoto.jpg";
                    }
                  ?>
                  <img src='<?php echo $photo; ?>' width='120' height='160' alt='<?php echo $v['nip']; ?>.jpg' class="img-thumbnail">
                  </td>
                </tr>
                <tr class='warning'>
                  <td align='center' rowspan="4"><b>DETAIL<br/>Hukuman Disiplin</b></td>
                  <td colspan='2' >
                    <table class='table table-condesed'>
                    <tr>
                      <td readonly width="18%">Jenis Hukuman</td>
                      <td readonly width="1%">:</td>
                      <td>
                      <?php
                      $jnshukdis = $this->mhukdis->jnshukdis()->result_array();
                      echo "<select name='fid_jnshd' id='fid_jnshd' required>";  
                      foreach($jnshukdis as $jh)
                      {
                        if ($v['fid_jenis_hukdis'] == $jh['id_jenis_hukdis']) {
                          echo "<option value='".$jh['id_jenis_hukdis']."' selected>".$jh['tingkat'].' - '.$jh['nama_jenis_hukdis']."</option>";
                        } else {
                          echo "<option value='".$jh['id_jenis_hukdis']."'>".$jh['tingkat'].' - '.$jh['nama_jenis_hukdis']."</option>";
                        }
                      }
                      ?>
                    </tr>
                    <tr>
                      <?php
                      // Kasus ketidakhadiran khusus untuk Teguran Lisan
                      if ($v['fid_jenis_hukdis'] == '01') {
                      ?>
                        <td>Kasus Ketidakhadiran</td>
                        <td>:</td>
                        <td colspan='3'>
                        <select name="tdkhadir" id="tdkhadir" required >
                          <?php
                          if ($v['ketidakhadiran'] == 'YA') {
                            echo "<option value='YA' selected>YA</option>";
                            echo "<option value='TIDAK'>TIDAK</option>";
                          } else if ($v['ketidakhadiran'] == 'TIDAK') {
                            echo "<option value='YA'>YA</option>";
                            echo "<option value='TIDAK' selected>TIDAK</option>";
                          } else {
                            echo "<option value='YA' selected>-- Kasus Ketidakhadiran --</option>";
                            echo "<option value='YA'>YA</option>";
                            echo "<option value='TIDAK'>TIDAK</option>";
                          } 
                          ?>
                        </select>
                        <small>Pilih YA, jika kasus yang dilaporkan berkaitan dengan KETIDAKHADIRAN</small>
                        </td>
                      <?php
                      }
                      ?>
                    </tr>
                    <tr class='success'>
                      <td>Panggilan I</td>
                      <td>:</td>
                      <td colspan='3'>
                        <table class="table table-condensed">
                        <tr>
                          <td align='right' width='20%'>No. Surat :</td>
                          <td colspan='3'><input type="text" name="nopanggil1" value="<?php echo $v['pemanggilan1_nosurat']; ?>" size='40' maxlength='50' required />
                        <tr></td>
                        </tr>        
                          <td align='right'>Tgl. Surat :</td>
                          <td colspan='3'><input type="text" name="tglpanggil1" class="tanggal" value="<?php echo tgl_sql($v['pemanggilan1_tglsurat']); ?>" size='15' maxlength='10' required />
                            <small>dd-mm-yyyy</small>
                          </td>
                        </tr>
                        <tr>
                          <td align='right'>Tgl. Pemeriksaan I :</td>
                          <td colspan='3'><input type="text" name="tglperiksa1" class="tanggal" value="<?php echo tgl_sql($v['pemeriksaan1_tgl']); ?>" size='15' maxlength='10' required />
                            <small>dd-mm-yyyy</small>
                          </td>
                        </tr>
                        </table>
                      </td>
                    </tr>
		    <?php
                      if ($v['pemanggilan2_tglsurat'] != null) {
                    ?>

                    <!-- Panggilan ke II tidak required -->
                    <tr class='success'>
                      <td>Panggilan II</td>
                      <td>:</td>
                      <td colspan='3'>
			<table class="table table-condensed">
                        <tr>
                          <td align='right' width='20%'>No. Surat :</td>
                          <td colspan='3'><input type="text" name="nopanggil2" value="<?php echo $v['pemanggilan2_nosurat']; ?>" size='40' maxlength='50' /></td>
                        </tr>        
                        <tr>
                          <td align='right'>Tgl. Surat :</td>
			  <td colspan='3'><input type="text" name="tglpanggil2" class="tanggal" value="<?php echo tgl_sql($v['pemanggilan2_tglsurat']); ?>" size='15' maxlength='10' />
                            <small>dd-mm-yyyy</small>
                          </td>
			</tr>
                        <tr>
                          <td align='right'>Tgl. Pemeriksaan II :</td>
                          <td colspan='3'><input type="text" name="tglperiksa2" class="tanggal" value="<?php echo tgl_sql($v['pemeriksaan2_tgl']); ?>" size='15' maxlength='10' />
                            <small>dd-mm-yyyy</small>
                          </td>
                        </tr>
                        </table>
                      	</td>
                    </tr>
		    <?php
                    }
                    ?>
                    <tr>
                      <td>Peraturan yang dilanggar</td>
                      <td>:</td>
                      <td>
                      <?php
                      $peruu = $this->mhukdis->peruu()->result_array();
                      echo "<select name='fid_peruu' id='fid_peruu' required>";  
                      foreach($peruu as $pu)
                      {
                        if ($v['fid_peruu'] == $pu['id_peruu_hukdis']) {
                          echo "<option value='".$pu['id_peruu_hukdis']."' selected>".$pu['nama_peruu_hukdis']."</option>";
                        } else {
                          echo "<option value='".$pu['id_peruu_hukdis']."'>".$pu['nama_peruu_hukdis']."</option>";
                        }
                      }
                      ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Masa Hukuman</td>
                      <td>:</td>
                      <td>
                      <?php echo "Terhitung mulai. "; ?>
                          <input type='text' size='12' maxlength='10' name='tmtmulai' class='tanggal' value='<?php echo tgl_sql($v['tmt_hukuman']); ?>' required />
                      <?php
                        if ($v['akhir_hukuman'] != null) {
                          echo "Sampai dengan. ";
                      ?>    
                          <input type='text' size='12' maxlength='10' name='tmtakhir' class='tanggal' value='<?php echo tgl_sql($v['akhir_hukuman']); ?>' />
                      <?php
                        }
                      ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Lama Hukuman</td>
                      <td>:</td>
                      <td>
                        <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='lamathn' value='<?php echo $v['lama_thn']; ?>' /> Tahun
                        <input type='text' size='2' maxlength='2' onkeyup='validAngka(this)' name='lamabln' value='<?php echo $v['lama_bln']; ?>' /> Bulan
                      </td>
                    </tr>
                    <tr>
                      <td>Deskripsi Kasus</td>
                      <td>:</td>
                      <td>
                        <textarea class="form-control rounded-0" name="deskripsi" maxlength="140" id="deskripsi" rows="2" required><?php echo $v['deskripsi']; ?>
                        </textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>Surat Keputusan</td>
                      <td>:</td>
                      <td>
                      <table class='table table-condensed'>
                        <tr>                          
                          <td readonly width="18%">Pejabat Berwenang</td>
                          <td readonly width="1%">:</td>
                          <td>
                          <select name="nip_pejabat" id="nip_pejabat" required >
                          <?php
                            $atasan = $this->mhukdis->getatasan()->result_array();
                            foreach($atasan as $at)
                            {
                              if ($at['nip'] == $v['nippejabat_sk']) {
                                echo "<option value='".$at['nip']."' selected>".$at['gelar_depan']." ".$at['nama']." ".$at['gelar_belakang']." - NIP. ".$at['nip']."</option>";
                              } else {
                                echo "<option value='".$at['nip']."'>".$at['gelar_depan']." ".$at['nama']." ".$at['gelar_belakang']." - NIP. ".$at['nip']."</option>";
                              }
                            }
                          ?>
                          </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Nomor</td>
                          <td>:</td>
                          <td><input type='text' size='30' name='nosk' value='<?php echo $v['no_sk']; ?>' /></td>
                        </tr>
                        <tr>
                          <td>Tanggal</td>
                          <td>:</td>
                          <td><input type='text' size='12' maxlength='10' onkeyup='validAngkaStrip(this)' name='tglsk' class='tanggal' value='<?php echo tgl_sql($v['tgl_sk']); ?>' /></td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                    </table>
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
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
      </p>
        </form
        >        
      </div>
    </div>
  </center>

