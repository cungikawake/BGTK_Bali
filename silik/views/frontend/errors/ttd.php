<!DOCTYPE html>
<html lang="id">
	<head>
		<title>BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?></title>
		<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 11]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		<!-- Meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="description" content="BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?>" />
		<meta name="author" content="BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?>"/>

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

		<link rel="stylesheet" href="<?php print base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" href="<?php print base_url('assets/fonts/feather/css/feather.css'); ?>">
		<link rel="stylesheet" href="<?php print base_url('assets/plugins/jquery-scrollbar/css/jquery.scrollbar.min.css'); ?>">
		<link rel="stylesheet" href="<?php print base_url('assets/fonts/datta/datta-icon.css'); ?>">
		<link rel="stylesheet" href="<?php print base_url('assets/plugins/select2/select2.css'); ?>">
		<link rel="stylesheet" href="<?php print base_url('assets/plugins/datepicker/css/bootstrap-datepicker.min.css'); ?>">
		<link rel="stylesheet" href="<?php print base_url('assets/plugins/signaturePad/signature-pad.css'); ?>">
		<!-- vendor css -->
		<link rel="stylesheet" href="<?php print base_url('assets/css/style.css?v=2'); ?>">

		<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>
		
		<style type="text/css">
			html, body {
				width: 100%;
				height: 100%;
				background: #fff;
			}
			.wrap-logo {
				width: 100%;
				height: 100%;
				position: relative;
			}
			.logo {
				display: inline-block;
				position: absolute;
				top: 50%;
				left: 50%;
				/* bring your own prefixes */
				transform: translate(-50%, -60%);
				text-align: center;
			}
			.logo-text {
				font-size: 28px;
				font-weight: bold;
				white-space: nowrap;
			}
			.logo-moto {
				font-size: 18px;
				font-style: italic;
				white-space: nowrap;
			}
		</style>
	</head>

	<body>
		<div class="wrap-logo">
			<div class="logo">
				<img src="<?php print base_url("/assets/images/logo-kemdikbud.jpg"); ?>" width="120px" /><br >
				<div class="logo-text">BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?></div>
				<div class="logo-moto">Saguyub Nangun Janakerthih</div>
				<h4 class="alert alert-danger">Tanda Tangan Tidak Ditemukan</h4>
			</div>
		</div>
	</body>
	
	<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/js/pcoded.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/bootgrid/jquery.bootgrid.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/js/script.js'); ?>"></script>
</html>