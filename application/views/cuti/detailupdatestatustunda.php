<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../cuti/updatestatus'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
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
      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>UPDATE STATUS CUTI TUNDA</b>
        </div>
        <?php
          foreach($cuti as $v):
        ?>
        <table class="table">
          <tr>
            <td align='center'>                           
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='120'><b>No. Pengantar</b> :</td>
                  <td width='300'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='120'><b>Tgl. Pengantar</b> :</td>
                  <td  colspan='2'><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='5' colspan='2'>
                    <center><img src='../photo/<?php echo $v['nip'];?>.jpg' width='120' height='160' alt='$nip.jpg'>

                  </td>
                </tr>
                <tr>
                  <td align='right'><b>NIP</b> :</td>
                  <td><?php echo $v['nip']; ?></td>
                  <td align='right'><b>Nama</b> :</td>
                  <td colspan='2'><?php echo $this->mpegawai->getnama($v['nip']); ?></td>
                </tr>
                <?php 
                    if ($v['fid_jnsjab'] == 1) { $idjab = $v['fid_jabatan'];
                    }else if ($v['fid_jnsjab'] == 2) { $idjab = $v['fid_jabfu'];
                    }else if ($v['fid_jnsjab'] == 3) { $idjab = $v['fid_jabft'];
                    }
                ?>
                <tr>
                  <td align='right'><b>Jabatan</b> :</td>
                  <td colspan='4'><?php echo $this->mpegawai->namajab($v['fid_jnsjab'],$idjab), '<br /><u>', $v['nama_unit_kerja'],'</u>'; ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Tahun</b> :</td>
                  <td colspan='3'><?php echo $v['tahun']; ?></td>
                </tr>
                <tr>
                  <td align='right'><b>Jumlah</b> :</td>
                  <td colspan='4'><?php echo $v['jml_hari'].' hari';?></td>                  
                </tr>
                <tr class='info'>
                  <td colspan='3' align='center'><b>Entri Usul : </b><?php echo $v['tgl_usul'].' | '.$this->mlogin->getnamauser($v['user_usul']); ?></td>
                  <td colspan='4' align='center'><b>Kirim Usul : </b><?php echo $v['tgl_kirim_usul']; ?></td>
                </tr>
                <?php
                  $status = $this->mcuti->getstatuscuti($v['fid_status']);                
                ?>
                <tr class='danger'>
                  <td align='right'><b>Status saat ini : </b></td>
                  <td><?php echo '<b>'.$status.'</b><br/>'.$v['alasan']; ?></td>
                  <td align='right'><b>Update ke : </b></td>
                  <td colspan='3'>
                    <form method='POST' action='../cuti/updatestatustunda_aksi'>
                    <input type='hidden' name='id_statuslama' id='id_statuslama' value='<?php echo $v['fid_status']; ?>'>
                    <select name="id_statusbaru" id="id_statusbaru" required />
                        <?php
                        foreach($statuscuti as $jc)
                        {
                          if ($jc['id_statuscuti'] == $v['fid_status']) {
                            echo "<option value='".$jc['id_statuscuti']."' selected>".$jc['nama_statuscuti']."</option>";  
                          } else if ($jc['id_statuscuti'] == '5') {
                            echo "";
                          }else {
                            echo "<option value='".$jc['id_statuscuti']."'>".$jc['nama_statuscuti']."</option>";  
                          }
                          
                        }
                        ?>
                    </select>&nbsp
                    <?php
                      echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                      echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                      echo "<button type='submit' class='btn btn-danger btn-sm'>";
                      echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Proses";
                      echo "</button>";
                      echo "</form>";
                    ?>
                  </td>
                </tr>
                <tr class='danger'>
                  <td align='right'><b>Diproses oleh : </b></td>
                  <td colspan='6'><?php echo $this->mlogin->getnamauser($v['user_proses']).' pada '.$v['tgl_proses']; ?></td>
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