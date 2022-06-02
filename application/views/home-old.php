<HTML lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>" />		

		<link rel="icon" href="<?php echo base_url('assets/favicon32.png'); ?>" type="image/png" />		

		<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
		
		<style>
	      html, body {
	        height: 99%;
	        font-size:12px;
	        background-image: url(../assets/bg06.gif);
	        background-repeat: repeat;
	      }
      	</style>
	</head>
	<body>
	<!--
	<div class="panel panel-info" style="width: 100%; height: 96%">
		<div class="panel-body">
	-->
				<form action="<?php echo base_url('login/masuk');?>" method="post">
					<div class="col-md-3 col-md-offset-4" style="margin-top:12%;margin-left:38%">
						<div class="panel panel-default">
							<div class="panel_body" style="margin-left:5%; margin-right:5%">
							<!--	<div align='center'>
									<img src=../assets/harijadi14.jpg width='150' height='150'>
									<br /><br />
									<span style="color: #FF0033">
									<b>PRE LAUNCHING (TRIAL MODE)</b><br />
									</span>
									<span style="color: #3300FF">
									In sya Allah, akan aktif setiap hari kerja<br />jam 08:00 sampai 16:00 WITA.
									</span>
								</div>
							-->
								<div class="row form_group">
								<h3 align='center'>
								<?php 
									//echo $judul;
							      	//echo "<img src=".base_url()."assets/logo.jpg width='40' height='50'>&nbsp";
							      	echo "<img src=".base_url()."assets/silka3copy.png width='165' height='55'>";
							    ?>        
								</h3>
								</div>
								<div class="row form_group">
									<label class="col-md-4" for="username" style="margin-top:2%" align='right'>Username</label>
									<div class="col-md-8">
										<input type="text" name="username" class="form-control input-sm" id="username" maxlength="18" required>
									</div>	
								</div>

								<div class="row form_group" style="margin-top:2%">
									<label class="col-md-4" for="password" style="margin-top:2%" align='right'>Password</label>
									<div class="col-md-8">
										<input type="password" name="password" class="form-control input-sm" id="password" maxlength="18" required>
									</div>	
								</div>

								<div class="row form_group" style="margin-top:2%;margin-bottom:5%">
									<center>
									<div class="col-md-12" align='right'>
										<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp&nbspLogin</button>
									</div>
									</center>
								</div>
								<div align='right'>
									<i><a href="<?php echo base_url('login/logintamu') ?>">Login sebagai tamu</a></i>
								</div>

								<div align='center' style="margin-top:5%;margin-bottom:2%;margin-right:1%">
										<i>BKPPD Kab. Balangan &copy All rights reserved</i>
								</div>
							</div>
						</div>
						<?php
							if ($this->session->flashdata('pesan') <> ''){
							?>
								<div class="alert alert-dismissible alert-warning">
								<?php echo $this->session->flashdata('pesan');?>
								</div>
								<?php
							}
						?>
					</div>
				</form>
			<!--
			</div>
		</div>
		-->
	</body>
</HTML>
