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
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../cuti/detailproses'>";          
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
        <b>PROSES USUL CUTI TUNDA</b>
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
                    <center><img class='img-thumbnail' src='../photo/<?php echo $v['nip'];?>.jpg' width='120' height='160' alt='$nip.jpg'>

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
                  <!--<td colspan='3' align='center'><b>Entri Usul : </b><?php //echo $v['tgl_usul'].' | '.$this->mlogin->getnamauser($v['user_usul']); ?></td>
                  <td colspan='4' align='center'><b>Kirim Usul : </b><?php //echo $v['tgl_kirim_usul']; ?></td>-->
                </tr>
                <?php
                $status = $this->mcuti->getstatuscuti($v['fid_status']);
                if (($status == 'BTL') OR ($status == 'TMS')) {
                ?>
                <tr class='danger'>
                  <td align='right'><b>Status : </b></td>
                  <td colspan='6'><?php echo '<b>'.$status.'</b><br/>'.$v['alasan']; ?></td>
                </tr>
                <tr class='danger'>
                  <td align='right'><b>Diproses oleh : </b></td>
                  <td colspan='6'><?php echo $this->mlogin->getnamauser($v['user_proses']).' pada '.$v['tgl_proses']; ?></td>
                </tr>
                <?php
                } else if (($status == 'SETUJU') OR ($status == 'CETAKSK')){
                ?>
                <tr class='success'>
                  <td align='right'><b>Status : </b></td>
                  <td colspan='6'><?php echo '<b>'.$status.'</b><br/>No. SK : '.$v['no_sk'].' -- Tgl. SK : '.tgl_indo($v['tgl_sk']).' -- Pejabat SK : '.$v['pejabat_sk'] ; ?></td>
                </tr>
                <tr class='success'>
                  <td align='right'><b>Diproses oleh : </b></td>
                  <td colspan='6'><?php echo $this->mlogin->getnamauser($v['user_proses']).' pada '.$v['tgl_proses']; ?></td>
                </tr>
                <?php  
                }
                ?>
              </table>

            <?php
            if ($this->mcuti->getstatuscuti($v['fid_status']) == 'INBOXBKPPD') {
            ?>
              <table class="table table-condensed"'>
                <tr class='danger'>
                  <td colspan='7' align='center'><b>APPROVAL</b></td>
                </tr>
                <tr class='danger'>
                  <td align='right' rowspan='3' width='300'>
                  </td>                  
                  <td align='right' rowspan='3'>
                    <form method='POST' action='../cuti/prosesusultms_tunda'>
                    <textarea id="alasantms" name="alasantms" rows="3" cols="35" required></textarea>
                  </td>                  
                  <td align='left' rowspan='3'>
                  <?php
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-danger btn-xs'>";
                    echo "<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span><br />T M S<br/>(Selesai)";
                    echo "</button>";
                    echo "</form>";
                  ?>
                  </td>
                  <td align='right'>No. SK</td> 
                  <td align='left'>
                    <form method='POST' action='../cuti/prosesusulsetuju_tunda'>
                    <input type='text' name='no_sk' id='no_sk' size='23' required></td> 
                  <td align='center' rowspan='2'>
                  <?php
                    echo "<input type='hidden' name='nip' id='nip' value='$v[nip]'>";
                    echo "<input type='hidden' name='fid_pengantar' id='fid_pengantar' value='$v[fid_pengantar]'>";
                    echo "<button type='submit' class='btn btn-success btn-xs'>";
                    echo "<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span><br />Setuju<br/>(Cetak SK)";
                    echo "</button>";
                  ?>
                  </td>
                </tr>
                <tr class='danger'>
                  <td align='right'>Tgl. SK</td> 
                  <td align='left'><input type='text' name='tgl_sk' id='tgl_sk' class="tanggal" size='12' value='<?php echo date('d-m-Y'); ?>' required></td> 
                </tr>
                <tr class='danger'>
                  <td align='right'>Pejabat SK</td> 
                  <td colspan='2' align='left'><input type='text' name='pejabat_sk' id='pejabat_sk' value='KEPALA BADAN KEPEGAWAIAN, PENDIDIKAN DAN PELATIHAN DAERAH' size='35' required></td> 
                  </form>
                </tr>
              </table>
            <?php
            }
            ?>

            </td>            
          </tr>
        </table>
      <?php
        endforeach;
      ?>  
      </div>      
      <?php
        if (($status == 'SETUJU') OR ($status == 'CETAKSK')) {
          echo "<form method='POST' action='../cuti/cetaksk_tunda' target='_blank'>";          
          echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[fid_pengantar]'>";
          echo "<input type='hidden' name='nip' id='nip' size='18' value='$v[nip]'>";
          echo "<input type='hidden' name='tahun' id='tahun' size='5' value='$v[tahun]'>";
      ?>
          <p align="right">
            <button type="submit" class="btn btn-primary btn-sm">&nbsp
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbspCetak SK&nbsp&nbsp&nbsp
            </button>
          </p>
      <?php
        echo "</form>";
        }
      ?>
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