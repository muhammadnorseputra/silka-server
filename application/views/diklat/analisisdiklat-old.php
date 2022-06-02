<div class="container">
  <div class="row">
    <div class="col-md-4  bg-primary" style="padding: 10px;">
    <b>Pilih Unit Kerja: </b><select name="unker" id="unker" style="display:none;"></select>
  </div>
  <div class="col-md-2  bg-primary" style="padding: 10px;">
    <span><b>Jenis Jabatan: </b> <select id="jenis_jabatan" disabled> </select></span>
  </div>
  <div class="col-md-3  bg-primary" style="padding: 10px;">
  <b>Jabatan:</b> <select class="form-control" style="width:100%;" id="pilih_jabatan" disabled></select>
</div>
<div class="col-md-3 bg-info" style="padding: 7px;">
  <b class="text-danger" style="position: relative; bottom: 3px;">Cari by</b>
  <!-- <button class="btn btn-danger btn-sm pull-right" id="carinippns" onclick="get_analisa()" style="position: relative; bottom: 3px;"> <i class="glyphicon glyphicon-search"></i></button> -->
  
  <span  style="position: relative; bottom: 3px;"><b>IDENTITAS: </b></span>  <input type="text" onkeyup="get_analisa()" class="form-control" name="nipcari" max="18" min="0" id="nipcari" placeholder="Masukan NIP / NAMA" style="position: relative; bottom: 0px;">
  <!--  <span id="nama_unker" style="display:none;"></span> -->
</div>




<div class="clearfix"></div>
<hr>
<div class="clearfix"></div>
<center><span id="loader"></span></center>
<div class="row" id="list-pegawai"></div>

</div>
</div>
<div class="modal fade detail-peg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" keyboar="false">
<div class="modal-dialog modal-lg" style="width:90%;" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Informasi Kediklatan</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-5">
        <div class="text-success"><b><i class="glyphicon glyphicon-user"></i> Profil Singkat Pegawai</b></div>
        <div id="peg_load_here">
          <center><span id="loader2"></span></center>
        </div>
        <div><?php
          // khusus untuk level admin
          if ($this->session->userdata('nama') == "salasiah") {
          ?>
          <!-- Nav tabs -->
<!--           <ul class="nav nav-tabs nav-inverse" role="tablist">
            <li role="presentation" class="active"><a href="#note" aria-controls="note" role="tab" data-toggle="tab">POST IT!</a></li>
          </ul> -->
          <!-- Tab panes -->
          
<!--           <div class="tab-content ">
            <br>
            <div role="tabpanel" class="tab-pane fade in active" id="note">
              <div class="alert alert-sm alert-warning" role="alert"> Berikan Catatan Sesuai Keperluan... <button class="btn btn-xs btn-warning" data-toggle="collapse" data-target="#catatan" aria-expanded="false" aria-controls="catatan">Pesan!!!</button></div>
              
              <div class="collapse" id="catatan">
                <form action="#">
                  <textarea name="catatan" class="form-control" cols="100%" rows="3" placeholder="PESAN ANDA DISINI..."></textarea>
                </form>
              </div>
            </div>
          </div> -->
          <?php } ?>
        </div>
      </div>
      <div class="col-md-7">
        
        <div class="panel panel-success" style="border-bottom: 3px solid #333;">
          <div class="panel-heading"><span class="text-default"><i class="glyphicon glyphicon-list-alt"></i><b> Riwayat Diklat</b></span> <br> <small class="text-muted">::: Data diambil dari tabel riwayat diklat</small></div>
          <div class="panel-body">
            <div>
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#struktural" aria-controls="struktural" role="tab" data-toggle="tab">STRUKTURAL</a></li>
                <li role="presentation"><a href="#fu" aria-controls="fu" role="tab" data-toggle="tab"> TEKNIS FUNGSIONAL</a></li><!--
                <li role="presentation"><a href="#tk" aria-controls="tk" role="tab" data-toggle="tab">TEKNIS</a></li> -->
                <li role="presentation" class="pull-right"><a href="#ok" aria-controls="ok" role="tab" data-toggle="tab"><b class="text-success"><span class="text-danger"><i class="glyphicon glyphicon-check"></i></span> REKOMENDASI</b></a></li>
                <li role="presentation" class="pull-right"><a href="#usul" aria-controls="usul" role="tab" data-toggle="tab"><b class="text-warning"><span class="text-danger"><i class="glyphicon glyphicon-plus"></i></span> USUL</b></a></li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="struktural">
                  <div id="riwayat_diklat_struktural"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="fu"  style="height: auto; max-height: 350px; overflow-y: scroll; overflow-x: hidden;">
                  <div id="riwayat_diklat_fungsional"></div>
                  <div class="clearfix"></div>
                  <div id="riwayat_diklat_teknis"></div>
                </div><!--
                <div role="tabpanel" class="tab-pane fade" id="tk">
                  
                </div>  -->
                <div role="tabpanel" class="tab-pane fade" id="ok">
                  <div id="rekomendasi_diklat_analisa"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="usul">
                  <p><img src="<?php echo base_url('assets/diklat/coming-soon-090616.jpg') ?>" style="position:relative; left:30%;" width="200"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Tab panes -->

        <div class="panel panel-default" style="border-bottom: 3px solid #333;">
          <div class="panel-heading"><span class="text-default"><i class="glyphicon glyphicon-lg glyphicon-book"></i><b> Rekomendasi Diklat</b></span> <br> <small class="text-muted">::: Data diambil dari Persyaratan Diklat</small></div>
          <div class="panel-body" id="rekomendasi_diklat" style="height: auto; max-height: 350px; overflow-y: scroll; overflow-x: hidden;"></div>
          <center><span id="loader3"></span></center>
        </div>
        
      </div>
    </div>
  </div>
<!--   <div class="modal-footer">
    <b class="text-muted pull-left">  *) Apabila ada ketidak sesuaian data, segera laporan kepada pihak terkait! <br> **) Sebelum data di <u class="text-danger">REKAM</u>, Pastikan Data Sudah Benar! </b>
    
    <div class="btn-group" role="group">
      <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> REKAM ANALISA</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CLOSE</button>
    </div>
  </div> -->
</div>
</div>
</div>
<?php $this->load->view($analisis_diklat) ?>
