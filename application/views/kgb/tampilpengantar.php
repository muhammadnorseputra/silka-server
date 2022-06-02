<!-- Default panel contents -->
  <center>
    <div class="panel panel-default" style="width: 99%; background-color:Beige;">
      <div class="panel-body">
        <?php
        if ($this->session->flashdata('pesan') <> ''){
          ?>
          <div class="alert alert-dismissible alert-info">
            <?php echo $this->session->flashdata('pesan');?>
          </div>
          <?php
        }
        ?>

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

        <!-- start panel -->
        <div class="panel panel-success">
          <div class="panel-heading" align="left">
            <b>PENGANTAR USUL KENAIKAN GAJI BERKALA</b><br/>
            <?php echo "Jumlah : ", $this->mkgb->getjmlpengantarskpd(), " Pengantar"; ?>      
          </div>
          <table class='table table-condensed'>
            <tr>
              <?php
              // cek privilegde user session -- usulkgb_priv
              if ($this->session->userdata('usulkgb_priv') == "Y") { 
              ?>
              <td align='right'>
                <form method="POST" action="../kgb/tambahpengantar">
                  <button type="submit" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Buat Pengantar
                  </button>
                </form>
              </td>
              <?php
              }
              ?>
              <td align='right' width='50'>
                <form method="POST" action="../home">
                  <button type="submit" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                  </button>
                </form>
              </td>
            </tr>
          </table> 
        </div>
        <!-- end panel -->

      <!-- untuk scrollbar -->
      <div style="padding:0px;overflow:auto;width:100%;height:350px;border:1px solid PaleGreen">
        <table class="table table-condensed table-hover"  style="background-color: white;">
          <tr class='success'>
            <td align='center'><b>No.</b></td>
            <td align='center' width='200'><b>No. Pengantar<br/>Tgl. Pengantar</b></td>
            <td align='center' width='450'><b>Unit Kerja</b></td>
            <td align='center' width='100'><b>Jumlah Usul</b></td>
            <td align='center' width='200'><b>Created</b></td>
            <td align='center' width='60'><b><b>Status</b></td>
            <td align='center' colspan='3'><b>Aksi</b></td>
          </tr>      

          <?php
            $no = 1;
            foreach($kgb as $v):          
          ?>   
          <tr>   
            <td align='center'><?php echo $no.'.'; ?></td>
            <td><?php echo $v['no_pengantar'].'<br/>'.tgl_indo($v['tgl_pengantar']); ?></td>
            <td><?php echo $this->munker->getnamaunker($v['fid_unit_kerja']); ?></td>
            <td align='center'><?php echo $this->mkgb->getjmldetailpengantar($v['id_pengantar']); ?></td>
            
            <td><?php echo tglwaktu_indo($v['created_at']); ?></td>
            <td align='center'>
            <?php
            $status = $this->mkgb->getstatuspengantar($v['fid_status']);
            if ($status == 'SKPD') {          
              echo "<h5><span class='label label-default'>Inbox SKPD</span></h5>";
            } else if ($status == 'CETAK') {
              echo "<h5><span class='label label-warning'>Cetak</span></h5>";
            }
            ?>
            </td>
            <td align='center'>
              <?php
              echo "<form method='POST' action='../kgb/detailpengantar'>";          
              echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
              ?>
              <button type="submit" class="btn btn-success btn-xs ">
              <span class="glyphicon glyphicon-tag" aria-hidden="true"></span><br />Lihat Usul
              </button>
              <?php
                echo "</form>";
              ?>
            </td>
            <td align='right'>
              <?php          
                if (($this->mkgb->getjmldetailpengantar($v['id_pengantar']) == 0) AND (($this->mkgb->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'SKPD'))) {
                  echo "<form method='POST' action='../kgb/editpengantar' target=''>";          
                  echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
                  echo "<input type='hidden' name='tgl_pengantar' id='tgl_pengantar' value='$v[tgl_pengantar]'>";
                  ?>
                  <button type="submit" class="btn btn-warning btn-xs">
                  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></span><br/>&nbsp&nbspEdit&nbsp&nbsp
                  </button>
                  <?php
                    echo "</form>";
                  ?>
                <?php
                } else {
                  echo "<button class='btn btn-warning btn-xs disabled'>";
                  echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span><br/>&nbsp&nbspEdit&nbsp&nbsp";
                  echo "</button>";
                }
                ?>
            </td>
            <td align='right'>
              <?php          
                if (($this->mkgb->getjmldetailpengantar($v['id_pengantar']) != 0) AND (($this->mkgb->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'SKPD') OR ($this->mkgb->getstatuspengantar_byidpengantar($v['id_pengantar']) == 'CETAK'))) {
                  echo "<form method='POST' action='../kgb/cetakpengantar' target='_blank'>";          
                  echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$v[id_pengantar]'>";
                  echo "<input type='hidden' name='tgl_pengantar' id='tgl_pengantar' value='$v[tgl_pengantar]'>";
                  echo "<input type='hidden' name='id_unker' id='id_unker' value='$v[fid_unit_kerja]'>";
                  ?>
                  <button type="submit" class="btn btn-primary btn-xs">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />Cetak Pengantar
                  </button>
                  <?php
                    echo "</form>";
                  ?>
                <?php
                } else {
                  echo "<button class='btn btn-primary btn-xs disabled'>";
                  echo "<span class='glyphicon glyphicon-print' aria-hidden='true'></span><br />Cetak Pengantar";
                  echo "</button>";
                }
                ?>
            </td>        
          </tr>
          <?php
            $no++;
            endforeach;
          ?>
        </table>
      </div>
    </div>
  </div>
</center>