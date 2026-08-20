<!DOCTYPE html>
<html lang="id">

<head>
    <title>Buku Tamu</title>
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
    <meta name="description" content="Buku Tamu" />
    <meta name="author" content="BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?>"/>
	
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
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/signaturePad/signature-pad.css'); ?>">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php print base_url('assets/css/style.css?v=2'); ?>">
	
	<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>
    
    <style type="text/css">
		.container {
			max-width: 800px;
			margin-top: 20px;
		}
		.card {
			margin: 10px 0 30px 0;
			background: #fff;
			border: 1px solid #eee;
			padding: 20px;
		}
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
		.main-title {
			font-size: 20px;
			text-align: center;
			font-weight: bold;
			position: relative;
			margin-bottom: 30px;
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
		
		.d-inline {
			display: inline!important;
		}
		
		.star-req {
			color: #D80407;
    		font-size: 18px;
		}
		
		.btn {
			margin-bottom: 0px;
		}
		
		.col-md-12 > .card {
			border-radius: 14px;
			overflow: hidden;
		}
		
		
		.modal-footer {
			margin-top: 15px;
			border-top: none;
		}
		.form-rows .row {
			padding-bottom:6px;
		}
		.form-rows .row .col-md-5,
		.form-rows .row .col-md-7 {
			line-height:32px;	
		}
		.judul {
			padding:2px 0 2px 0;
			font-size:40px;
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font-weight:bold;
			margin-bottom:35px;
			color: #3ebfea;
		}
		.btn-kirim {
			padding-right:40px;
			padding-left:40px;
			font-size:18px;
		}
		body {
			background: url("/assets/images/registrasi-peserta-bg.jpg");
			background-size: contain;
		}
		.wrap-form {
			padding:0 15px;
		}
		label {
			font-size:14px;	
		}
		.card .card-block, .card .card-body {
			padding: 5px;
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
				<div class="bgp">BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?></div>
				<div class="lokal">Saguyub Nangun Janakerthih</div>
			</div>
		</div>
	</div>
	
	<form action="">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-block" style="text-align: center; ">
                    	<div class="main-title">Buku Tamu BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?></div>
                  	</div>	
           			<div class="wrap-form">
                    	<div class="row">
                    		<div class="col-md-2">&nbsp;</div>
                        	<div class="col-md-8 form-rows">
								<div class="form-group">
									<label>Nama Lengkap <span class="star-req">*</span></label>
									<input type="text" name="nama" required class="form-control" value="" />
								</div>
								
								<div class="form-group">
									<label style="display: block; margin-bottom: 7px;">Jenis Kelamin <span class="star-req">*</span></label>

									<div class="form-group d-inline">
										<div class="radio radio-primary d-inline">
											<input type="radio" name="radio-p-fill-5" id="kelamin-laki" checked="checked">
											<label for="kelamin-laki" class="cr">Laki - laki &nbsp;&nbsp;&nbsp;</label>
										</div>
										<div class="radio radio-primary d-inline">
											<input type="radio" name="radio-p-fill-5" id="kelamin-perempuan">
											<label for="kelamin-perempuan" class="cr">Perempuan</label>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label>No. HP <span class="star-req">*</span></label>
									<input type="text" name="no_hp" required class="form-control" value="" />
								</div>
								
                    			<div class="form-group">
									<label>Asal Instansi/Sekolah <span class="star-req">*</span></label>
									<input type="text" name="asal_instansi" required class="form-control" value="" />
								</div>
                    			
                                <div class="form-group">
									<label>Tujuan <span class="star-req">*</span></label>
									<textarea name="tujuan_bertamu" required rows="4" class="form-control"></textarea>
								</div>
								<div class="form-group">
									<label>Kritik/Saran</label>
									<textarea name="saran" required rows="4" class="form-control"></textarea>
								</div>
                            </div>
                            <div class="col-md-2">&nbsp;</div>
                        </div>
                    </div>
                        
           			<div class="modal-footer" style="text-align: center;">
						<button type="submit" class="btn btn-info">KIRIM</button>
            		</div>
				</div>
			</div>
		</div>
	</div>
	</form>


<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php print base_url('assets/js/pcoded.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/bootgrid/jquery.bootgrid.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/autoNumeric/autoNumeric.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/select2/select2.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script src="<?php print base_url('assets/plugins/signaturePad/signature-pad.js'); ?>"></script>
<script src="<?php print base_url('assets/js/script.js'); ?>"></script>
<script type="text/javascript">
	var Biodata = {};
	var Dropzone = function() {};
	
	Biodata.siganturePad = function() {};
	
	Biodata.setDropzone = function () {
		if ($('#dropzone-surat-tugas').length) {
			var form = $('.form-submit-registrasi');
			
			$("#dropzone-surat-tugas").dropzone({ 
				url: "/kegiatan/registrasi_save/?v"+Math.random(),
				paramName: "surat_tugas", // The name that will be used to transfer the file
				maxFilesize: 5, // MB
				autoProcessQueue: false,
				acceptedFiles: '.jpg,.jpeg,.pdf,.png',
				addRemoveLinks: true,
				parallelUploads: 10,
				uploadMultiple: false,
				maxFiles: 1,
				init: function() {
					Dropzone = this;

					Dropzone.on('sending', function(file, xhr, formData){
						var formFields = form.serializeArray();
						
						$.each(formFields, function(index, field) {
							formData.append(field.name, field.value);
						});
					});

					Dropzone.on("success", function(file, xhr) {
						Dropzone.removeFile(file);
						Biodata.stopLoader();
						
						var res = JSON.parse(xhr);
						$('.card').html(res.html);
					});
				},
			});
		}
	}
	
	Biodata.init = function () {
		// Golongan Dan Pangkat
		$('[name="golongan"]').change(function () {
			var pangkat = $(this).find(":selected").data('pangkat');
			$('[name="pangkat"]').val(pangkat);
		});
		
		// Menghitung NIK
		$('[name="nik"]').on('keyup', function(e) {
			var jmlh_char = this.value.length;
			var nik = $(this).val();
			
			$('.hitung-digit').text(jmlh_char);
			
			if (e.keyCode != 17) {
				if (jmlh_char == 16) { // KTP
					Biodata.findByNIK(nik);
				}
			}
		});
		
		// Menangkap NIK Jika Copy Paste
		$('[name="nik"]').on('paste', function (e) {
			if (e.originalEvent.clipboardData) {
				var text = e.originalEvent.clipboardData.getData("text/plain");
				$('[name="nik"]').val(text).keyup();
			}
		});
		
		
		// Kabupaten Lainnya
		$('[name="kab_unit_kerja"]').on("change", function(e) { 
			var kab = $(this).val();
			
			if (kab == "Lainnya") {
				$('.kab_unit_kerja_lainnya').removeClass("hidden");
				$('[name="kab_unit_kerja_lainnya"]').attr("required", "required");
			}
			else {
				$('.kab_unit_kerja_lainnya').addClass("hidden");
				$('[name="kab_unit_kerja_lainnya"]').removeAttr("required");
			}
		});
		
		
		// Set Dropzone
		Biodata.setDropzone();
		
		
		// Submit Form
		$(document).on("submit","form.form-submit-registrasi",function (e) {
			e.preventDefault();
			
			// Validasi
			var jabatan = $('[name="jabatan"]').val();

			if (jabatan.length <= 3) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Jabatan</strong> dengan benar',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="jabatan"]').offset().top-200
					}, 500, function(){$('[name="jabatan"]').focus();});
				});

				return false;
			}

			var alamatRumah = $('[name="alamat_tinggal"]').val()

			if (alamatRumah.length <= 20) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Alamat Rumah</strong> lebih lengkap',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="alamat_tinggal"]').offset().top-200
					}, 500, function(){$('[name="alamat_tinggal"]').focus();});
				});

				return false;
			}

			var alamatKantor = $('[name="alamat_unit_kerja"]').val()

			if (alamatKantor.length <= 20) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Alamat Unit Kerja/Sekolah</strong> lebih lengkap',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="alamat_unit_kerja"]').offset().top-200
					}, 500, function(){$('[name="alamat_unit_kerja"]').focus();});
				});

				return false;
			}
			
			//
			if ($('#dropzone-surat-tugas').length && $('#dropzone-surat-tugas').hasClass("required")) {
				if (Dropzone.getQueuedFiles().length <= 0) {
					Swal.fire(
						'Perhatian!',
						'Mohon mengupload <strong>Surat Tugas</strong>',
						'warning'
					).then((result) => {
						$('html, body').animate({
							scrollTop: $('#dropzone-surat-tugas').offset().top-200
						}, 500, function(){$('#dropzone-surat-tugas').focus();});
					});

					return false;
				}
			}
			
			// handle ttd
			if ($('#signature-pad').length) {
				var sign = Biodata.siganturePad.toDataURL();
				
				if (sign == "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAArAAAADVCAYAAACv4sN2AAAAAXNSR0IArs4c6QAAC+dJREFUeF7t1kENAAAMArHh3/R0XNIpIB0Pdo4AAQIECBAgQIBASGChrKISIECAAAECBAgQOANWCQgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASeI92ANYVskDgAAAAAElFTkSuQmCC") {
					Swal.fire(
						'Perhatian!',
						'Mohon mengisi <strong>Tanda Tangan</strong> dengan benar',
						'warning'
					).then((result) => {
						$('html, body').animate({
							scrollTop: $('#signature-pad').offset().top-200
						}, 500, function(){$('#signature-pad').focus();});
					});

					return false;	
				}
			}
			
			
			
			Biodata.stopLoader();
			Biodata.saveLoader();
			
			// handle ttd
			if ($('#signature-pad').length) {
				Biodata.siganturePad.removeBlanks();
				$('.signature-data').val(Biodata.siganturePad.toDataURL());
			}
			
			var dropzoneHandle = false;
			
			if ($('#dropzone-surat-tugas').length) {
				if (Dropzone.getQueuedFiles().length > 0) {
					dropzoneHandle = true;
				}
			}
			
			if (dropzoneHandle) {
				Dropzone.processQueue();	
			}
			else {
				var url = window.location.href;
				var action = $(this).attr('action');
				var data = $(this).serialize();
				var form = $(this);

				if (typeof action === typeof undefined && action === false) {
					action = url;
				}

				$.ajax({
					type: "POST",
					url: action,
					data: data,
					dataType: 'json',
					success: function(obj){
						Biodata.stopLoader();

						if (obj.error) {
							Swal.fire(
								'Gagal!',
								obj.msg,
								'error'
							);
						}
						else {
							$('.card').html(obj.html);
						}
					}
				});
			}
		});
		
		//$(document).on('click','.btn-modal-form-submit', function (e) {
			//Biodata.setButtonSubmit();
			//Biodata.submitWithoutFile();
			//$('form.form-submit-registrasi').submit();
		//});
		
		/*$(document).on("submit","form.form-submit-registrasi",function (e) {
			e.preventDefault();
			
			Biodata.submitValidation();
			
			Biodata.stopLoader();
			Biodata.saveLoader();
			
			// handle ttd
			if ($('#signature-pad').length) {
				Biodata.siganturePad.removeBlanks();
				$('.signature-data').val(Biodata.siganturePad.toDataURL());
			}

			var url = window.location.href;
			var action = $(this).attr('action');
			var data = $(this).serialize();
			var form = $(this);
			//var data = new FormData(this);

			if (typeof action === typeof undefined && action === false) {
				action = url;
			}

			$.ajax({
				type: "POST",
				url: action,
				data: data,
				dataType: 'json',
				success: function(obj){
					Biodata.stopLoader();
					
					if (obj.error) {
						Swal.fire(
							'Gagal!',
							obj.msg,
							'error'
						);
					}
					else {
						$('.card').html(obj.html);
					}
				}
			});
		});*/
		
		
		if ($('#signature-pad').length) {
			var wrapper = document.getElementById("signature-pad");
			var clearButton = wrapper.querySelector("[data-action=clear]");
			var canvas = wrapper.querySelector("canvas");
			
			Biodata.siganturePad = new SignaturePad(canvas, {
			  penColor: "rgb(2, 2, 2)"
			});
			
			Biodata.siganturePad.off();
			
			function resizeCanvas() {
			  var ratio =  Math.max(window.devicePixelRatio || 1, 1);

			  // This part causes the canvas to be cleared
			  canvas.width = canvas.offsetWidth * ratio;
			  canvas.height = canvas.offsetHeight * ratio;
			  canvas.getContext("2d").scale(ratio, ratio);
			  Biodata.siganturePad.clear();
			}
			
			window.onresize = resizeCanvas;
			resizeCanvas();
			
			clearButton.addEventListener("click", function (event) {
				Biodata.siganturePad.clear();
			});
		}
	}
	
	Biodata.stopLoader = function () {
		$(".loader").remove();
	}
	
	Biodata.startLoader = function () {
		Biodata.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">LOADING DATA...</div></div></div>');
	}
	
	Biodata.saveLoader = function () {
		Biodata.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">SAVING DATA...</div></div></div>');
	}
	
	Biodata.kabupaten = function () {
		var kab = [];
		
		<?php
			foreach ($this->config->item("transport_area") as $areaId => $areaName) {
				if ($areaId != "Lainnya") {
					print "kab.push('".$areaId."');";
				}
			}
		?>
		
		return kab;
	}
	
	Biodata.findByNIK = function (nik) {
		
		Biodata.startLoader();
		
		$.ajax({
			type: "POST",
			url: "/admin/biodata/getDetailByNik",
			data: {
				version: Math.random(),
				nik: nik
			},
			dataType: 'json',
			success: function(obj){
				$('[name="nama"]').removeAttr("disabled").val(obj.nama);
				
				$('[name="golongan"]').prop("disabled",false).val(obj.golongan).trigger("change");
				
				$('[name="pangkat"]').removeAttr("disabled").val(obj.pangkat);
				$('[name="tempat_lahir"]').removeAttr("disabled").val(obj.tempat_lahir);
				$('[name="tgl_lahir"]').removeAttr("disabled").datepicker('update', new Date(obj.tgl_lahir));
				$('[name="telp"]').removeAttr("disabled").val(obj.telp);
				$('[name="jenis_kelamin"]').prop("disabled",false).val(obj.jenis_kelamin).trigger("change");
				$('[name="npwp"]').removeAttr("disabled").val(obj.npwp);
				$('[name="email"]').removeAttr("disabled").val(obj.email);
				$('[name="alamat_tinggal"]').removeAttr("disabled").val(obj.alamat_tinggal);
				$('[name="unit_kerja"]').removeAttr("disabled").val(obj.unit_kerja);
				$('[name="nip"]').removeAttr("disabled").val(obj.nip);
				$('[name="jabatan"]').removeAttr("disabled").val(obj.jabatan);
				$('[name="telp_unit_kerja"]').removeAttr("disabled").val(obj.telp_unit_kerja);
				$('[name="kab_unit_kerja"]').prop("disabled",false).val(obj.kab_unit_kerja).trigger("change");
				$('[name="alamat_unit_kerja"]').removeAttr("disabled").val(obj.alamat_unit_kerja);
				
				var kabupaten = Biodata.kabupaten();
				
				if(typeof obj.kab_unit_kerja === "undefined" || obj.kab_unit_kerja == "" || $.inArray(obj.kab_unit_kerja, kabupaten) !== -1) {
					$('.kab_unit_kerja_lainnya').addClass("hidden");
					$('[name="kab_unit_kerja_lainnya"]').removeAttr("disabled").val("");
				}
				else {
					$('[name="kab_unit_kerja"]').val("Lainnya").trigger("change");
					$('.kab_unit_kerja_lainnya').removeClass("hidden");
					$('[name="kab_unit_kerja_lainnya"]').removeAttr("disabled").val(obj.kab_unit_kerja);
				}
				
				$('[name="nama_bank"]').prop("disabled",false).val(obj.nama_bank).trigger("change");
				$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val(obj.nama_pemilik_rekening);
				$('[name="no_rekening"]').removeAttr("disabled").val(obj.no_rekening);
				$('[name="konfirmasi_paket"]').prop("disabled", false);
				
				$('[name="surat_tugas"]').removeAttr("disabled");
				
				if ($('#signature-pad').length) {
					Biodata.siganturePad.on();	
				}
				
				$('.btn-modal-form-submit').removeAttr("disabled");
				
				Biodata.stopLoader();
			}
		});
	}
	
	$(document).ready(function () {
		Biodata.init();
	});
</script>
</body>
</html>