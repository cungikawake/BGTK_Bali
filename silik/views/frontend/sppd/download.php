<!DOCTYPE html>
<html lang="id">
	<head>
		<title>Download SPPD Kegiatan <?php print $satker["upt"]; ?></title>
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
		<meta name="description" content="Download SPPD Kegiatan <?php print $satker["upt"]; ?>" />
		<meta name="author" content="BGP Provinsi Bali"/>

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
		<link rel="stylesheet" href="<?php print base_url('assets/plugins/signaturePad/signature-pad.css'); ?>">
		<!-- vendor css -->
		<link rel="stylesheet" href="<?php print base_url('assets/css/style.css?v=2'); ?>">

		<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>
		
		<style type="text/css">
			.wrap-header {
				position: relative;
				background: #fff;
				box-shadow: 0 2px 3px rgb(0 0 0 / 5%);
				border-bottom: 1px solid #eee;
				text-align: center;
			}
			
			.wrap-title {
				display: inline-block;
				text-align: left;
				padding: 17px 0 12px;
			}
			.wrap-title .logo,
			.wrap-title .title {
				float: left;
			}
			.wrap-title .title .bgp {
				padding: 0px 0px 0 15px;
				font-size: 24px;
				font-weight: 700;
				margin-top: -4px;
			}
			.wrap-title .title .lokal {
				padding: 0px 0px 0 15px;
				font-size: 15px;
				font-style: italic;
			}
			.wrap-title:after {
				display: block;
				content: '';
				clear: both;
			}
			body {
				background: #f5f9fb;
			}
			.main-download {
				margin: 30px 0 0 0;
				background: #fff;
				border: 1px solid #eee;
				padding: 30px 15px;
			}
			.main-title {
				font-size: 20px;
				text-align: center;
				font-weight: bold;
				position: relative;
				margin-bottom: 15px;
			}
			.main-title:after {
				content: "";
				display: inline-block;
				height: 3px;
				background: #3ebfea;
				position: absolute;
				bottom: -5px;
				width: 90px;
				left: calc(50% - 45px);
			}
			.form-download {
				text-align: center;
			}
			
			.form-download input.form-control {
				text-align: center;
			}
			
			.table-result {
				margin-top: 30px;
			}
			
			.second-title {
				text-align: center;
				margin-bottom: 30px;
				font-weight: bold;
				font-size: 16px;
			}
			
			@media (min-width: 1200px) {
				.container {
					width: 1128px;
				}
			}
		</style>
	</head>

	<body>
		<!-- [ Pre-loader ] start -->
		<div class="loader-bg">
			<div class="loader-track">
				<div class="loader-fill"></div>
			</div>
		</div>
		<!-- [ Pre-loader ] End -->
		
		<div class="wrap-header">
			<div class="wrap-title">
				<div class="logo"><img src="<?php print base_url("/assets/images/logo-kemdikbud-50.jpg"); ?>" /></div>
				<div class="title">
					<div class="bgp"><?php echo $_ENV['INSTANSI_DIPA_NAME']; ?></div>
					<div class="lokal"><?php echo $_ENV['INSTANSI_SLOGAN']; ?></div>
				</div>
			</div>
		</div>
		<div class="wrap-main">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="main-download">
							<div class="main-title">Download SPPD</div>
							<div class="second-title">
								<?php
									if (isset($kegiatan["nama"]) && !empty($kegiatan["nama"])) {
										print "Kegiatan ".$kegiatan["nama"];
									}
								?>
							</div>
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<form class="form-certificate" action="<?php print base_url("/download/sppd_peserta/".$kegiatan_id."/execute/"); ?>" method="get">
										<div class="form-group form-download">
											<label>Nama Pejabat Penandatangan SPPD</label>
											<input type="text" name="nama" class="form-control" required />
										</div>
										<div class="form-group form-download">
											<label>NIP Pejabat Penandatangan SPPD</label>
											<input type="text" name="nip" class="form-control" required />
										</div>
										<div class="form-group form-download">
											<label>Jabatan Pejabat Penandatangan SPPD</label>
											<input type="text" name="jabatan" class="form-control text-left" placeholder="Contoh: Kepala Dinas" required />
										</div>
										<div class="form-group form-download">
											<label>Nama Unit Kerja Pejabat Penandatangan SPPD</label>
											<input type="text" name="unit_kerja" placeholder="Contoh: Disdikpora <?php print $_ENV["DEFAULT_KABUPATEN"]; ?>" class="form-control" required />
										</div>
										<div class="form-group form-download">
											<label>Kab/Kota Unit Kerja Pejabat Penandatangan SPPD</label>
											<select name="kab_unit_kerja" class="form-control select2" required>
												<option value="">&nbsp;</option>
												<?php
													foreach ($this->config->item("transport_area") as $areaId => $areaName) {
														print '<option value="'.$areaId.'">'.$areaName.'</option>';
													}
												?>
											</select>
										</div>
										
										<div class="alert alert-info" style="padding: 7px 15px; text-align: center;">Mohon di print dengan kertas A4</div>
										
										<div class="form-group form-download">
											<button type="submit" class="btn btn-info get-certifcate">Download SPPD</button>
										</div>
									</form>
								</div>
							</div>
							
							<div class="table-download-sertifikat">
							
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	
	<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/js/pcoded.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/bootgrid/jquery.bootgrid.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/select2/select2.js'); ?>"></script>
	<script src="<?php print base_url('assets/js/script.js'); ?>"></script>
	
	<script type="text/javascript">
		
	</script>
</html>