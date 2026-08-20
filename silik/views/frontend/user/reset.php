<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIPANDU - Sistem Informasi Pelayanan Terpadu</title>
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
    <meta name="description" content="Datta Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

   <?php //Favicon icon ?>
    <link rel="icon" href="<?php print base_url('assets/images/favicon.ico'); ?>" type="image/x-icon">
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
		.auth-wrapper .auth-icon:before { background: #04a9f5; background-clip: text; -webkit-background-clip: text; }
		.theme-bg { background: #04a9f5; display: flex; }
		.img-fluid { max-width: 100%; height: auto; }
		.row.no-gutters {display: flex; flex-wrap: wrap; }
		.align-items-center { -ms-flex-align: center!important; align-items: center!important; }
		.custom-select, .form-control {background: none; }
		
		@media (max-width: 767px) {
			.d-none { display: none !important; }
			.row.no-gutters { display: block; flex-wrap: wrap; }
		}
	</style>
</head>

<body>
<div class="auth-wrapper">
	<div class="auth-content subscribe">
		<div class="card">
			<div class="row no-gutters">
				<div class="col-md-4 col-lg-6 d-none d-md-flex d-lg-flex theme-bg align-items-center justify-content-center">
				<img src="<?php print base_url("/assets/images/lock.png"); ?>" class="img-fluid" />
				</div>
				<div class="col-md-8 col-lg-6">
					<div class="card-body text-center">
						<div class="row justify-content-center">
							<div class="col-sm-11">
								<div class="mb-4">
								<i class="feather icon-mail auth-icon"></i>
								</div>
								<h3 class="mb-4">Reset Password</h3>
								<?php
									if($this->session->flashdata('msg')){
										print $this->session->flashdata('msg');
									}
								?>
								<form action="/user/reset_password" method="post" autocomplete="off">
									<div class="input-group mb-3">
									<input type="email" name="email" class="form-control" placeholder="Email" required />
									</div>
									<button class="btn btn-primary mb-4" type="submit">Reset Password</button>
								</form>
								
								<p class="mb-0 text-muted">Sudah memiliki akun? <a href="<?php print base_url("user/login"); ?>">Masuk</a></p>
								<p class="mb-0 text-muted">Belum memiliki akun? <a href="<?php print base_url("user/daftar"); ?>">Daftar</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Required Js -->
<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php print base_url('assets/js/guest.js'); ?>"></script>
</body>
</html>