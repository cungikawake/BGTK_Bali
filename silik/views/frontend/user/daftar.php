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
		<div class="auth-content">
			<div class="auth-bg">
				<span class="r"></span>
				<span class="r s"></span>
				<span class="r s"></span>
				<span class="r"></span>
			</div>
			<div class="card">
				<div class="card-body text-center">
					<h5 class="mb-4">Daftar Akun</h5>
					<?php
						if($this->session->flashdata('msg')){
							print $this->session->flashdata('msg');
						}
						
						$nama = "";
						$jk = "Laki-laki";
						$telepon = "";
						$unit_kerja = "";
						$alamat = "";
						$email = "";
					
						if($this->session->flashdata('nama')){
							$nama = $this->session->flashdata('nama');
							$jk = $this->session->flashdata('jenis_kelamin');
							$telepon = $this->session->flashdata('telepon');
							$unit_kerja = $this->session->flashdata('unit_kerja');
							$alamat = $this->session->flashdata('alamat');
							$email = $this->session->flashdata('email');
						}
					?>
					<form action="/user/daftar" method="post" autocomplete="off">
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php print $nama; ?>" required />
						</div>
						<div class="input-group mb-3">
							<select class="form-control" name="jenis_kelamin" required>
								<?php
									$selL = "";
									$selP = "";

									if ($jk == "Laki-laki") {
										$selL = 'selected="selected"';
									}

									if ($jk == "Perempuan") {
										$selP = 'selected="selected"';
									}
								?>
								<option value="Laki-laki" <?php print $selL; ?>>Laki-laki</option>
								<option value="Perempuan" <?php print $selP; ?>>Perempuan</option>
							</select>
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="telepon" value="<?php print $telepon; ?>" placeholder="Telepon/HP" required />
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="unit_kerja" value="<?php print $unit_kerja; ?>" placeholder="Unit Kerja" required />
						</div>
						<div class="input-group mb-3">
							<textarea class="form-control" name="alamat" placeholder="Alamat Unit Kerja" required><?php print $alamat; ?></textarea>
						</div>
						<br />
						<div class="input-group mb-3">
							<input type="email" class="form-control" name="email" placeholder="Email" value="<?php print $email; ?>" required />
						</div>
						<div class="input-group mb-3">
							<input type="password" class="form-control" name="password" placeholder="Password" required />
						</div>
						<button class="btn btn-primary mb-4" type="submit">Daftar</button>
					</form>
					<p class="mb-0 text-muted">Sudah memiliki akun? <a href="<?php print base_url("user/login"); ?>">Masuk</a></p>
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