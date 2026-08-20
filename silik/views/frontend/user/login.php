<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php print $this->config->item("site_name")." - ".$this->config->item("site_description"); ?></title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?php print $this->config->item("site_name")." - ".$this->config->item("site_description"); ?>" />
    <meta name="author" content="<?php echo $_ENV['INSTANSI_NAME'] ?>"/>

   	<?php //Favicon icon ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php print base_url('assets/images/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php print base_url('assets/images/favicon-16x16.png'); ?>">
	<?php // Google Font ?>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i&display=swap" rel="stylesheet">
    <?php // fontawesome icon ?>
    <link rel="stylesheet" href="<?php print base_url('assets/fonts/fontawesome/css/fontawesome-all.min.css'); ?>">
    <?php // animation css ?>
    <link rel="stylesheet" href="<?php print base_url('assets/plugins/animation/css/animate.min.css'); ?>">
	<?php // bootstrap css ?>
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
	<?php // bootgrid table css ?>
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/bootgrid/jquery.bootgrid.min.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/fonts/feather/css/feather.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/jquery-scrollbar/css/jquery.scrollbar.min.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/fonts/datta/datta-icon.css'); ?>">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php print base_url('assets/css/style.css'); ?>">
	
	<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>
	
	<style type="text/css">
		.bg-white {
			background-color: #fff!important;
		}
		.align-items-center {
			-ms-flex-align: center!important;
			align-items: center!important;
		}
		.align-items-stretch {
			-ms-flex-align: stretch!important;
			align-items: stretch!important;
		}
		.justify-content-center {
			-ms-flex-pack: center!important;
			justify-content: center!important;
		}
		.text-white {
			color: #fff;
		}
		.btn-primary {
			width: 100%;
    		border: 4px;
		}
		.or-container {
			text-align: center;
			margin: 0;
			margin-bottom: 15px;
			margin-top: -10px;
			clear: both;
			color: #6a737c;
			font-variant: small-caps;
		}
		.or-container .or-hr {
			margin-bottom: 0;
			position: relative;
			top: 13px;
			height: 0;
			border: 0;
			border-top: 1px solid #dadada;
		}
		.or-container #or {
			display: inline-block;
			position: relative;
			padding: 0 10px;
			background-color: #FFF;
		}
		.btn-fb, .btn-fb:hover {
			background: #4267B2;
			border-color: #4267B2;
			vertical-align: middle;
			padding: 0;
			margin-bottom: 10px;
			color: #fff !important;
			font-weight: 400 !important;
		}
		
		.btn-fb span {
			line-height: 35px;
			vertical-align: middle;
			display: inline-block;
		}
		
		.btn-fb i {
			font-size: 16px;
			line-height: 34px;
			vertical-align: middle;
		}
		
		.btn-google, .btn-google:hover {
			background: #fff;
			border: 1px solid #d6d9dc;
			color: #535a60 !important;
			vertical-align: middle;
			padding: 0;
			font-weight: 400 !important;
		}
		
		.btn-google svg {
			font-size: 20px;
			line-height: 34px;
			vertical-align: middle;
			margin-right: 3px;
		}
		.btn-google span {
			line-height: 35px;
			vertical-align: middle;
			display: inline-block;
		}
		.auth-wrapper .auth-icon:before {
			background: #04a9f5;
			background-clip: text;
			-webkit-background-clip: text;
		}
		
		@media (max-width: 767px) {
			.aut-bg-img { display: none !important; }
		}
		@media (min-width: 1200px) {
			.aut-bg-img { height: 100% !important; }
		}
	</style>

</head>

<body>
    <div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch">
		<div class="row align-items-center w-100 align-items-stretch bg-white">
			<div class="d-none d-lg-flex col-lg-8 aut-bg-img align-items-center d-flex justify-content-center">
				<div class="col-md-8">
					<h1 class="text-white mb-5">Masuk ke <?php print $this->config->item("site_name"); ?></h1>
					<p class="text-white"><?php print $this->config->item("site_description"); ?></p>
				</div>
			</div>
			<div class="col-lg-4 align-items-stret h-100 align-items-center d-flex justify-content-center">
				<div class=" auth-content text-center">
					<div class="mb-4">
					<i class="feather icon-unlock auth-icon"></i>
					</div>
					<h3 class="mb-4">Sign In</h3>
					<?php
						if($this->session->flashdata('msg')){
							print $this->session->flashdata('msg');
						}
					?>
					<form action="<?php print base_url("user/login"); ?>" method="post">
						<div class="input-group mb-3">
							<input type="email" class="form-control" name="email" placeholder="Email">
						</div>
						<div class="input-group mb-4">
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>
						<button class="btn btn-primary mb-4" w-100>Masuk</button>
					</form>
					
					<div class="or-container">
						<hr class="or-hr">
						<div id="or">atau</div>
					</div>


					<div class="form-group">
						<a class="btn btn-primary btn-google" href="<?php print $googleLoginUrl; ?>">
							<svg aria-hidden="true" class="svg-icon native iconGoogle" width="18" height="18" viewBox="0 0 18 18"><g><path d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 0 0 2.38-5.88c0-.57-.05-.66-.15-1.18z" fill="#4285F4"></path><path d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2a4.8 4.8 0 0 1-7.18-2.54H1.83v2.07A8 8 0 0 0 8.98 17z" fill="#34A853"></path><path d="M4.5 10.52a4.8 4.8 0 0 1 0-3.04V5.41H1.83a8 8 0 0 0 0 7.18l2.67-2.07z" fill="#FBBC05"></path><path d="M8.98 4.18c1.17 0 2.23.4 3.06 1.2l2.3-2.3A8 8 0 0 0 1.83 5.4L4.5 7.49a4.77 4.77 0 0 1 4.48-3.3z" fill="#EA4335"></path></g></svg> <span>Masuk dengan Google</span></a>
					</div>
					
					<p class="mb-2 text-muted">Lupa password? <a href="<?php print base_url("/user/reset_password"); ?>">Reset</a></p>
					<p class="mb-0 text-muted">Belum mempunyai akun? <a href="<?php print base_url("/user/daftar"); ?>">Daftar</a></p>
				</div>
			</div>
		</div>
	</div>


    <!-- Required Js -->
<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php print base_url('assets/js/guest.js'); ?>"></script>
</body>
</html>
