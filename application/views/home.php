<html lang="en">
	<head>
		<meta charset="utf-8">

		<title><?php echo $title ?></title>
 		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />		

		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>" />		
		<script async src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 	
		<script async src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script> 

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
				color: #fff;
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
				background-image: url(../assets/bg06.gif);
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
					box-shadow: 0 0 1em #333;
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

			.checkbox .cr {
  				position: relative;
  				display: inline-block;
  				border: 1px solid #a9a9a9;
  				border-radius: .25em;
  				width: 1.3em;
  				height: 1.3em;
  				float: left;
  				margin-right: .5em;
			}

			.checkbox .cr .cr-icon {
  				position: absolute;
  				font-size: .8em;
  				line-height: 0;
  				top: 50%;
  				left: 15%;
			}

			.checkbox label input[type="checkbox"] {
  				display: none;
			}

			.checkbox label input[type="checkbox"]+.cr>.cr-icon {
  				opacity: 0;
			}

			.checkbox label input[type="checkbox"]:checked+.cr>.cr-icon {
  				opacity: 1;
			}

			.checkbox label input[type="checkbox"]:disabled+.cr {
  				opacity: .5;
			}

      	</style>
      	<meta name="google-site-verification" content="685uuxqu76JDgkvpNNj0Ojz9AhpNUylPgXLLt7vbgdI" />
      <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-YT6E3S1R0N"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		
		  gtag('config', 'G-YT6E3S1R0N');
		</script>
	</head>
	<!--<body class='text-center'>-->
	<body>
	<!--
	<div class="panel panel-info" style="width: 100%; height: 100%">
		<div class="panel-body">
	-->
		
		<div class="row" style="margin:0%;">			
				<div class="kiri hidden-xs hidden-sm">
					<p class="mt-5 mb-3 text-muted"><i class='fa fa-3x fa-home'></i> BKPSDM Kabupaten Balangan</p>
					<p class="mt-5 mb-3 text-muted"><i class='fa fa-3x fa-map-marker'></i> Jln. A. Yani Km 4,5 No. 1 Kel. Batu piring Kec. Paringin Selatan Kab. Balangan</p>
					<p class="mt-5 mb-3 text-muted"><i class='fa fa-3x fa-phone'></i> 0526-2028060 (Telp / Fax)</p>
					<p class="mt-5 mb-3"><i class='fa fa-3x fa-internet-explorer'></i><a href="http://www.bkppd-balangankab.info" target="_blank"> www.bkppd-balangankab.info</a></p>
				</div>			

				<div class="kanan">
				<form class="form-signin" action="<?php echo base_url('login/masuk');?>" method="post">
					<?php
						echo "<center>";
						echo "<img class='mb-4' src=".base_url()."assets/silka3.png>";
						echo "</center><br />";
					?>
			      <!--<label for="username" class="sr-only">Username</label>-->
			      <input type="text" id="username" name="username" class="form-control" placeholder="Username" required="" autofocus="" >
			      <!--<label for="password" class="sr-only">Password</label>-->
			      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="" >
			      <div class="input-group checkbox mb-3">
				<span class="input-group-addon">
				 <h6 align='right'>
					Centang untuk aktifkan Fitur Integrasi BKN
					<span class="fa fa-hand-o-right fa-2x" aria-hidden="true"></span>
				 </h6>
				</span>
				<span class="input-group-addon">
					<div class="checkbox">
  						<label>
   						<input type="checkbox" name="intbkn" value="YA" />
   						<span class="cr" style="font-size: 18px;"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
						</label>
					</div>
                                </span>
    			      </div>
			      <div class='checkbox mb-3'>
			      <button class="btn btn-lg btn-danger btn-block" type="submit"><i class='fa fa-sign-in'></i> Sign in</button>
			      </div>		      	

			      <!--
			      <p><code>Jika anda bukan User terdaftar,</code><a href="<?php echo base_url('login/logintamu') ?>">Klik Disini</a> untuk login sebagai tamu.</p>
			      <br/>	
			  	  -->
			      <p class="mt-5 mb-3 text-muted">BKPSDM Kab. Balangan © 2017</p>
			      	<?php
							if ($this->session->flashdata('pesan') <> ''){
							?>
								<div class="alert alert-dismissible alert-danger" align="center">
								<?php echo $this->session->flashdata('pesan');?>
								</div>
								<?php
							}
					?>
			    </form>
			    </div>
			    
		</div>
				
	</body>
</HTML>
