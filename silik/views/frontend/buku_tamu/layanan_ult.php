<!DOCTYPE html>
<html lang="id">

<head>
    <title>Pendaftaran Kegiatan</title>
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
    <meta name="description" content="Form Registrasi Kegiatan BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?>" />
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
	<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/signaturePad/signature-pad.css'); ?>">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php print base_url('assets/css/style.css?v=2'); ?>">
	
	<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>
    
    <style type="text/css">
		.card {
			margin: 10px 0 30px 0;
			background: #fff;
			border: 1px solid #eee;
		}
		.wrap-title .logo, .wrap-title .title {
			float: left;
		}
		.wrap-title:after {
			display: block;
			content: '';
			clear: both;
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
		.wrap-title .title .bgp {
			padding: 0px 0px 0 20px;
			font-size: 35px;
			font-weight: 700;
			margin-top: -4px;
		}
		.wrap-title .title .lokal {
			padding: 0px 0px 0 20px;
			font-size: 15px;
			font-style: italic;
			text-align:center;
			margin-top:-5px;
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
		.judul1 {
			font-size:30px;
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font-weight:bold;
			color: #0e5e99;
		}
		.judul2 {
			font-size:15px;
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font-weight:bold;
			color: #0e5e99;
			margin-bottom:20px;
		}
		.btn-kirim {
			padding-right:40px;
			padding-left:40px;
			font-size:18px;
		}
		body {
			background: #0e5e99;
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
		.nilai {
			text-align: center;
			margin-top: 25px;
			margin-bottom: 30px;
			font-size:30px;
			font-weight:bold;
		}
		.emoticon {
			text-align:center;
			font-size:80px;	
		}
		.emot {
			display:inline-block;	
		}
		
		.emot a {
			filter:grayscale(1);	
		}
		.emot a:focus {
			outline:none;
			text-decoration:none;
		}
		.emot a:hover, .emot a.selected {
			filter:none;	
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
			<div class="logo"><img src="https://bgpbali.id/assets/images/logo-kemdikbud-50.jpg"></div>
			<div class="title">
                <div class="bgp">BGP Provinsi <?php echo $_ENV['DEFAULT_PROVINSI']; ?></div>
                <div class="lokal">Saguyub Nangun Janakerthih</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-block" style="text-align: center; ">
                    	<div class="row header"></div>
                        <div class="col-md-12">
                            <div class="judul1">KEPUASAN LAYANAN</div>
                            <div class="judul2"> UNIT LAYANAN TERPADU (ULT)</div>
                        </div>
  					</div>
                    <form action="" method="post">
                    <div class="wrap-form">
                        <div class="row">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-6 form-rows">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>NAMA LENGKAP <span class="star-req">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="nama" required class="form-control" value="" />
                                    </div>
      							</div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>PROFESI / JABATAN <span class="star-req">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="profesi_jabatan" required class="form-control" value="" />
                                    </div>
                                </div>
                    			<div class="row">
                                    <div class="col-md-5">
                                        <label>ASAL INSTANSI <span class="star-req">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="asal_instansi" required class="form-control" value="" />
                                    </div>
                                </div>
                   				<div class="row">
                                    <div class="col-md-5">
                                        <label>NO. HP <span class="star-req">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="no_hp" required class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>JENIS KELAMIN <span class="star-req">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                    	<input type="radio" name="jenis_kelamin" value="Laki - Laki" checked /> Laki-Laki
                                      	<input type="radio" name="jenis_kelamin" value="Perempuan" /> Perempuan
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>PERIHAL <span class="star-req">*</span></label>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea name="perihal" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">&nbsp;</div>
                        </div>
                    </div>
                    <div class="wrap-emoticon">
                        <div class="col-md-12">
                            <div class="nilai">PENILAIAN KEPUASAN LAYANAN KAMI :</div> 
                        </div>
                        <div class="emoticon"> 
                            <div class="col-md-12" >
                                <div class="emot emot_sangatsenang"><a data-nilai="5" href="javascript:;">&#128525 </a></div>
                                <div class="emot emot_senang"><a data-nilai="4" href="javascript:;">&#128522 </a></div>
                                <div class="emot emot_cukup"><a data-nilai="3" href="javascript:;">&#128528 </a></div>
                                <div class="emot emot_kurang"><a data-nilai="2" href="javascript:;">&#128577 </a></div>
                                <div class="emot emot_sangatkurang"><a data-nilai="1" href="javascript:;">&#128545 </a></div>
                            </div>
                        </div>
                    </div>     
                    <div class="modal-footer" style="text-align: center;">
                        <input type="hidden" class="nilai-emot" name="nilai" value="0" />
                        <button type="submit" class="btn btn-info btn-modal-form-submit btn-kirim">SIMPAN</button>
                        <button type="submit" class="btn btn-info btn-modal-form-submit btn-kirim">BATAL</button>
                    </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>


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
	var ULT = {};
	
	ULT.init = function () {
		$('.emot a').click(function () {
			var nilai = $(this).attr("data-nilai");
			$('.emot a').removeClass('selected');
			$(this).addClass('selected');
			
			$('.nilai-emot').val(nilai);
		});
	}
	
	$(document).ready(function () {
		ULT.init();
	});
</script>
</body>
</html>