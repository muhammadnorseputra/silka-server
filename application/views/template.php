<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SILKa Online</title>

    <link rel="icon" href="<?php echo base_url('assets/favicon32.png'); ?>" type="image/png" />	
	
    <!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo base_url('assets/dark-mode/dark-mode.css') ?>">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />    
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker.css'); ?>" rel="stylesheet"/>
    

	<!-- ANALITIC -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-230315730-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'UA-230315730-2');
	</script>


    <!-- for dashboard using SB Admin 2 -->
      <!-- Custom CSS -->
      <link href="<?php echo base_url('assets/css/sb-admin-2.css'); ?>" rel="stylesheet">

      <!-- MetisMenu CSS -->
      <link href="<?php echo base_url('assets/css/metisMenu.min.css'); ?>" rel="stylesheet">

      <!-- Custom Fonts -->
      <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

      <!-- Custom Theme JavaScript -->
      <script type="text/javascript" src="<?php echo base_url('assets/js/sb-admin.js'); ?>"></script>


      <link href="<?php echo base_url('assets/css/highcharts-gridlight.css'); ?>" rel="stylesheet" type="text/css">

      <!-- akhir dashboard -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      html, body {
        height: 100%;
        font-size:12px;
      }
      select{
        padding:5px;
        border:1px solid #666666;
        -moz-border-radius: 5px; 
        -webkit-border-radius: 5px;9
        z-index: 9999 ;
      }

      footer {
      color: #666;
      background: #222;
      padding: 10px 20px 1px 20px;
      border-top: 2px solid #000;
      margin-top: 5%;
      width: 100%;
	position: absolute;
	bottom: 0;
	left: 0;
	z-index: -1;
      }

      footer a {
      color: #999;
      }

      footer a:hover {
      color: #efefef;
      }

      .wrapper {
      min-height: 100%;
      height: auto !important;
      height: 100%;
      margin: 0 auto -50px;
      }
      .push {
      height: 63px;
      }
      /* not required for sticky footer; just pushes hero down a bit */
      .wrapper > .container {
      padding-top: 60px;
      }
    </style>

      <link href="<?php echo base_url('assets/css/proper.css'); ?>" rel="stylesheet">
      
  </head>
  <body>
    <!-- High chart -->
      <script type="text/javascript" src="<?php echo base_url('assets/js/highcharts.js'); ?>"></script>
      <script type="text/javascript" src="<?php echo base_url('assets/js/exporting.js'); ?>"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/popover.js') ?>"></script>    
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>

    <?php $this->load->view('nav'); ?>
    <div class="container-fluid" id="content-data">
    <?php $this->load->view($content); ?>        
    </div>        
    <?php 
	//$this->load->view('footer');
    ?>    
  </body>
</html>
