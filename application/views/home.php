<html lang="en">
	<head>
		<meta charset="utf-8">

		<title><?php echo $title ?></title>
 		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />		

		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>" />

		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
		<style>
			.text-center {
			    text-align: center!important;
			}

	      html, body {
	        height: 100%;
	        /*
	        background-image: url(../assets/bg06.gif);
	        background-repeat: repeat;
	        */

	        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
		    font-size: 16px;
		    font-weight: 400;
		    line-height: 1.5;
		    color: #212529;
		    margin: 0;
	      }

	      .form-signin {
			    width: 50%;
			    height: 100%;
			    max-width: 100%;			    
			    padding: 150px 200px 200px 200px;
			    margin: 0 auto;
			    float: right;
			}

			.kiri {
				float: left;
				width: 50%;
			    height: 100%;
			    padding: 180 20 20 50;
			    
			    /*background-color: #5bc0de; /* info */ 
			    /*background-color: #f0ad4e; /* warning */
			    /*background-color: #d9534f; /* danger */	
			    /*background-color: #5cb85c; /* success */

				background-image: url(../assets/bg06.gif);
	
			}

			.kiri a {
				color: #33b367;
			}

			.kiri p {
				color: #5cb85c;
				/*color: #DC143C;*/
			}

			.kiri i {
				margin-right: 20px;
			}

			.kanan {
				font-size: 14px;
				text-align: right;
			}
			.kanan img {
				width: 280px;
				height: 90px;
			}
			.dropdown-submenu {
			  position: relative; 
			}
			
			/* apabila rotasi layar potrat */
			@media only screen and (max-width: 600px) {
				body {
				height: auto;
				//background-image: url(../assets/bg06.gif);
				}
				.form-signin {
				    width: auto;
			    	float: none;
			    	padding: 15px;
			    	margin-top: 15%;
			    	height: auto;
				  }
				input[type="text"] {
					margin-bottom: 10px;
				} 
				img {
					border-radius:20px;
					max-width: 100%;
					width:auto;
				}
			}
			
			/* apabila rotasi layar landscape */
			@media only screen and (min-width: 600px) and (max-width: 720px) {
				.form-signin {
				    width: auto;
			    	float: none;
			    	padding: 160px;
				  }
			}
			
      	</style>

		<link rel="stylesheet" href="<?php echo base_url('assets/css/floating-labels.css'); ?>" />	
	</head>
	<!--<body class='text-center'>-->
	<body>
	<!--
	<div class="panel panel-info" style="width: 100%; height: 100%">
		<div class="panel-body">
	-->
		
		<div class="row" style="margin:0%;">			
				<div class="kiri hidden-xs hidden-sm">
					<div style="display:flex; flex-direction: column; align-items:start; justify-content:center; gap: 30px;">
						<p style="display: inline-flex; justify-content:center; align-items:start; flex-direction: column;">
							<i class='fa fa-3x fa-home'></i> <span>BKPSDM Kabupaten Balangan</span>
						</p>
						<p style="display: inline-flex; justify-content:center; align-items:start; flex-direction: column;">
							<i class='fa fa-3x fa-map-marker'></i> 
							<span>Jln. A. Yani Km 4,5 No. 1 Kel. Batu piring Kec. Paringin Selatan Kab. Balangan</span>
						</p>
						<p style="display: inline-flex; justify-content:center; align-items:start; flex-direction: column;">
							<i class='fa fa-3x fa-phone'></i> 
							<span>0526-2028060 (Telp / Fax)</span>
						</p>
						<p style="display: inline-flex; justify-content:center; align-items:start; flex-direction: column;">
							<i class='fa fa-3x fa-internet-explorer'></i>
							<a href="//www.bkpsdm.balangankab.go.id" target="_blank"> www.bkpsdm.balangankab.go.id</a>
						</p>
					</div>
				</div>			

				<div class="kanan">
				<form class="form-signin" action="<?php echo base_url('login/masuk');?>" method="post" autocomplete="off">
					<?php
						echo "<center>";
						echo "<img class='mb-4' src=".base_url()."assets/silka3.png>";
						echo "</center><br />";
					?>
					<?php
							if ($this->session->flashdata('pesan') <> ''){
							?>
								<div class="alert alert-dismissible alert-danger" role="alert" align="center">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-exclamation-circle"></i></span></button>
								<?php echo $this->session->flashdata('pesan');?>
								</div>
								<?php
							}
					?>
					<div class="form-label-group">
			      <input type="text" id="username" name="username" class="form-control-custom" placeholder="Username" autocomplete="off" required="" autofocus="" >
			      <label for="username">Username</label>
			      </div>
			      <div class="form-label-group">
			      <input type="password" id="password" name="password" class="form-control-custom" placeholder="Password" autocomplete="off" required="" >
			      <label for="password">Password</label>
			      <button type="button" id="showps" style="position: absolute; top:13; right: 15px;" tabindex="-1">show</button>
			      </div>
			      
			      <div>
						 <label for="intbknya" style="text-align:left;selection:none; cursor: pointer;display:flex; align-content:center; align-items:start; justify-content:start;user-select: none;-webkit-user-select:none; -moz-user-select: none; -ms-user-select: none">
   					 <input type="checkbox" id="intbknya" name="intbkn" value="YA" style="margin-right:15px;margin-left:4px; transform: scale(1.4)"/>
						 	Centang untuk aktifkan Fitur Integrasi BKN
							<!--<span class="fa fa-hand-o-right fa-2x" aria-hidden="true"></span>-->
							
						 </label>
    			   </div>
    			   <hr>
			      <div class='mb-3'>
			      <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"><i class='fa fa-sign-in'></i> Sign in</button>
			      </div>		      	

			      <!--
			      <p><code>Jika anda bukan User terdaftar,</code><a href="<?php echo base_url('login/logintamu') ?>">Klik Disini</a> untuk login sebagai tamu.</p>
			      <br/>	
			  	  -->
			      <p class="text-center text-muted" style="margin-top:8%;">BKPSDM Kab. Balangan © 2017</p>
			      	
			    </form>
			    </div>

			    <svg  style="position:absolute; bottom:0;right:0; z-index:-1;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
  <path fill="#efefef" fill-opacity="1" d="M0,64L60,80C120,96,240,128,360,117.3C480,107,600,53,720,69.3C840,85,960,171,1080,176C1200,181,1320,107,1380,69.3L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
</svg>
		</div>
	<script>
		
		var button_ps = document.getElementById("showps");
		function showhidepass() {
		var input_ps = document.getElementById("password");
			if(input_ps.type == "password") {
				input_ps.type = "text";
				this.innerHTML = "hide";
			} else {
				input_ps.type = "password";
				this.innerHTML = "show";
			}
		}
		button_ps.addEventListener("click", showhidepass);
	</script>
		
		<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 	
		<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script> 
	</body>
</html>
