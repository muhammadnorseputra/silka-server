<div class="row">
   <div class="col-lg-2 col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-group fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
				$jmlpns =  $this->mgraph->jmlpns();
				$jmlpppk =  $this->mgraph->jmlpppk();
			
                        	echo $jmlpns+$jmlpppk;
                        ?>                        	
                        </div>
                        <div>Jumlah ASN</div>
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left">PNS + CPNS + PPPK</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user-md fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                                echo $this->mgraph->jmlpns();
                        ?>
                        </div>
                        <div>Jumlah PNS + CPNS</div>
                    </div>
                </div>
            </div>
            <a href="">
                <div class="panel-footer">
                    <span class="pull-left">termasuk CPNS - 
		    <?php
                                echo $this->mgraph->jmlcpns();
                    ?>
		    </span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-2 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user  fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                            echo $this->mgraph->jmlpppk();
                        ?>
                        </div>
                        <div>Jumlah PPPK Aktif</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('nonpns/statistik') ?>">
                <div class="panel-footer">
                    <span class="pull-left">seluruh kategori</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-wheelchair fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	$tgl = getdate();
				$thn = $tgl["year"];

                        	//$thn = 2022;
				//$thn = date('Y');
                        	//echo $this->mgraph->jmlpensiun('2017');
				echo $this->mgraph->jmlpensiun($thn);
                        ?>	
                        </div>
                        <div>Pensiunan Tahun Ini</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('pensiun/statistik') ?>">
                <div class="panel-footer">
                    <span class="pull-left">yang sudah mencapai TMT</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-briefcase fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	//$thn = '2021';
				$thn = date('Y');
                        	echo $this->mgraph->jmlusulkgb($thn);
                        ?>	
                        </div>
                        <div>Usul KGB Tahun ini</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('kgb/statistika') ?>">
                <div class="panel-footer">
                    <span class="pull-left">yang telah disetujui</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-check-square-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	$thn = date('Y');
                        	echo $this->mgraph->jmlusulcutisetuju($thn);
                        ?>
                        </div>
                        <div>Usul Cuti Tahun Ini</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('cuti/statistika') ?>">
                <div class="panel-footer">
                    <span class="pull-left">yang telah disetujui</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
	
    <!--
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-ticket fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                        	//$thn = date('Y');
                        	echo $this->mgraph->jmlusulcutitundasetuju('2021');
                        ?>
                        </div>
                        <div>Cuti Tunda Tahun Ini</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">yang telah disetujui</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    -->    
</div>
<!-- /.row -->

<div class="row">
<?php
	$this->load->view("dashboard-pns.php");
?>
</row> <!-- End Row -->


<div class="row">
  <div class="col-lg-12 col-md-12">	
    <ul class="nav nav-pills nav-justified">
        <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
        <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
        <!--<li><a href='#asn' data-toggle='tab'>ASN</a></li> -->
        <!--<li class='active'><a href='#pns' data-toggle='tab'>PNS</a></li>-->
        <!--<li><a href='#pppk' data-toggle='tab'>PPPK</a></li>-->
    </ul>

    <div class="tab-content">
	<div class="tab-pane" id="pppk">
        <br />
	      <div id='statpppk'></div>	
	      <?php
		//$this->load->view("dashboard-pppk.php");
	      ?>
        </div>

	<div class="tab-pane fade in active" id="pns">
        <br />
	      <div id='statpns'></div>	
	      <?php
		//$this->load->view("dashboard-pns.php");
              ?>
        </div>

    </div>
  </div> <!-- End Kolom -->
</row> <!-- End Row -->
