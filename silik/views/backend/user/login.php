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
		.refresh-captcha {
			padding: 9px 7px 10px;
			background: #ccc;
			display: inline-block;
			margin-left: -3px;
		}
	</style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
				<form action="" class="form-submit">
					<div class="card-body text-center">
						<div class="mb-4">
							<i class="feather icon-unlock auth-icon"></i>
						</div>
						<h3 class="mb-4">Login</h3> 
						<div class="form-group mb-3">
							<input type="text" class="form-control" name="username" placeholder="Username" required>
						</div>
						<div class="form-group mb-4">
							<input type="password" class="form-control" name="password" placeholder="Password" required>
						</div>
						<div class="form-group mb-4">
							<select class="form-control" name="tahun_anggaran">
								<?php
									$currentYear = date("Y");
									foreach ($this->config->item("tahun_anggaran") as $tahun) {
										$selected = "";
										
										if ($tahun == $currentYear) {
											$selected = 'selected="selected"';
										}
										
										print '<option value="'.$tahun.'" '.$selected.'>'.$tahun.'</option>';
									}
								?>
							</select>
						</div>
						<!--<div class="form-group text-left">
							<div class="checkbox checkbox-fill d-inline">
								<input type="checkbox" name="remember" id="checkbox-fill-a1" value="1" />
								<label for="checkbox-fill-a1" class="cr"> Ingat saya diperangkat ini</label>
							</div>
						</div>-->
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6" style="padding-right:0;"><?php print $captchaImg; ?> <a href="javascript:;" class="refresh-captcha" title="Refresh Kode Captcha"><i class="fas fa-sync-alt"></i></a></div>
								<div class="col-xs-6"><input type="text" class="form-control" name="captcha" placeholder="Kode Captcha" required></div>
							</div>
						</div>

						<!--<div class="form-group text-left">
							<div class="checkbox checkbox-fill d-inline">
								<input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
								<label for="checkbox-fill-a1" class="cr"> Save Details</label>
							</div>
						</div>-->
						<button class="btn btn-primary shadow-2 mb-4">Login</button>
						<!--<p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html">Reset</a></p>
						<p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html">Signup</a></p>-->
					</div>
				</form>
            </div>
        </div>
    </div>

    <!-- Required Js -->
<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php print base_url('assets/js/script.js?v='.rand()); ?>"></script>
</body>
</html>
