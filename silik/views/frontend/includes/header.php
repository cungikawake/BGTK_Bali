<!DOCTYPE html>
<html lang="id">

<head>
    <title><?php print $this->config->item("site_name")." - ".$this->config->item("site_description"); ?></title>
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
    <meta name="description" content="<?php print $this->config->item("site_name")." - ".$this->config->item("site_description"); ?>" />
    <meta name="author" content=<?php echo $_ENV['INSTANSI_NAME'] ?>/>
    <meta name="robots" content="noindex">
	
	
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
	
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/fonts/feather/css/feather.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/jquery-scrollbar/css/jquery.scrollbar.min.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/fonts/datta/datta-icon.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/select2/select2.css'); ?>">
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/datepicker/css/bootstrap-datepicker.min.css'); ?>">
	<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php print base_url('assets/css/style.css?v=3'); ?>">
	
	<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
	
    <?php $this->load->view("frontend/includes/menu"); ?>

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
            <a href="<?php print base_url("/"); ?>" class="b-brand">
                   <div class="b-bg">
                       <img src="<?php print base_url("/assets/images/logo-kemdikbud-icon.png"); ?>" />
                   </div>
                   <span class="b-title"><?php print $this->config->item("site_name"); ?></span>
               </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="javascript:">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"></a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon feather icon-settings"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="<?php print base_url('assets/images/user/avatar-1.jpg'); ?>" class="img-radius" alt="User-Profile-Image">
                                <span><?php print $_SESSION["guest"]["nama"]; ?></span>
                                <a href="<?php print base_url('/user/logout'); ?>" class="dud-logout" title="Logout">
                                    <i class="feather icon-log-out"></i>
                                </a>
                            </div>
                            <!--<ul class="pro-body">
                                <li><a href="javascript:" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
                                <li><a href="javascript:" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                                <li><a href="message.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
                                <li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
                            </ul>-->
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">