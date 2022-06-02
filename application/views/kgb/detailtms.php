<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../kgb/tampilinbox'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-warning btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>
      <div class="panel panel-success">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>DETAIL STATUS KGB</b>
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
                  <td width='250'><?php echo $v['no_pengantar']; ?></td>
                  <td align='right' width='120'><b>Tgl. Pengantar</b> :</td>
                  <td  colspan='2'><?php echo tgl_indo($v['tgl_pengantar']); ?></td>
                  <td rowspan='8' colspan='2'>
                    <center><img src='../photo/<?php echo $v['nip'];?>.jpg' width='120' height='160' alt='$nip.jpg'><center>
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
                  <td align='right'><b>Gapok Lama</b> :</td>
                  <td colspan='3'><?php echo 'Rp. '.indorupiah($v['gapok_lama']).',-'; ?></td>
                </tr>                
                <tr>
                  <td align='right'><b>Masa Kerja</b> :</td>
                  <td>
                    <?php echo $v['mk_thn_lama'].' Tahun, '.$v['mk_bln_lama'].' Bulan'; ?>                    
                    <input type="hidden" size="3" name="mkthn" id="mkthn" value="<?php echo $v['mk_thn_lama']; ?>" />
                    <input type="hidden" size="3" name="mkbln" id="mkbln" value="<?php echo $v['mk_bln_lama']; ?>" />
                  </td>
                  <td align='right' rowspan='2'><b>Berdasarkan<br/>Surat Keputusan</b> :</td>                  
                  <td rowspan='2'><?php echo $v['sk_lama_pejabat'].'<br/>Nomor : '.$v['sk_lama_no'].'<br/>Tanggal : '.tgl_indo($v['sk_lama_tgl']); ?></td>
                </tr>
                
                <tr>
                  <td align='right'><b>TMT</b> :</td>
                  <td>
                    <?php echo tgl_indo($v['tmt_gaji_lama']); ?>
                    <input type="hidden" size='10' name="tmt" value="<?php echo $v['tmt_gaji_lama']; ?>" />
                  </td>         
                </tr>
                <tr>
                  <td align='right'><b>Dalam Golru</b> :</td>
                  <td colspan='3'>
                    <?php echo $this->mpegawai->getnamapangkat($v['fid_golru_lama']).' ('.$this->mpegawai->getnamagolru($v['fid_golru_lama']).')';?>
                    <input type="hidden" size='3' name="fidgolru" value="<?php echo $v['fid_golru_lama']; ?>" />
                  </td>      
                </tr>
                <tr><td></td></tr>   
                <tr class='info'>
                  <td align='right'><b>Diusulkan oleh </b></td>
                  <td colspan='6' align='left'><?php echo $this->mpegawai->getnama($v['user_usul']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_usul']).'<b> diterima tim teknis BKPPD pada tanggal </b>'.tglwaktu_indo($v['tgl_kirim_usul']); ?></td>
                </tr>
                <tr><td></td></tr>
                <?php
                $status = $this->mkgb->getstatuskgb($v['fid_status']);
                if (($status == 'BTL') OR ($status == 'TMS')) {
                ?>                
                <tr class='danger'>
                  <td align='right'><b>Diproses oleh </b></td>
                  <td colspan='6'><?php echo $this->mpegawai->getnama($v['user_proses']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_proses']); ?></td>
                </tr>
                <tr class='danger'>
                  <td align='right'><b>Status : </b></td>
                  <td colspan='6'><?php echo '<b>'.$status.'</b><br/>'.$v['alasan']; ?></td>
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
                  <td colspan='6'><?php echo $this->mpegawai->getnama($v['user_proses']).' <b>pada tanggal</b> '.tglwaktu_indo($v['tgl_proses']); ?></td>
                </tr>
                <?php
                }
                ?>
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