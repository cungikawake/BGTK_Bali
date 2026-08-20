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
    <meta name="description" content="<?php echo $_ENV['APP_NAME']." - ".$_ENV['APP_DETAIL']; ?>" />
    <meta name="author" content="<?php echo $_ENV['INSTANSI_NAME']; ?>"/>
	
	<?php //Favicon icon ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php print base_url('assets/images/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php print base_url('assets/images/favicon-16x16.png'); ?>">
	<?php // Google Font ?>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

	
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
    <link rel="stylesheet" href="<?php print base_url('assets/plugins/cropper/cropper.css'); ?>">
	<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php print base_url('assets/css/style.css?v='.rand()); ?>">
	
	<script src="<?php print base_url('assets/js/vendor-all.min.js'); ?>"></script>

	<style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #status {
            padding: 10px;
            text-align: center;
            font-weight: bold;
			position: relative;
			z-index: 2;
        }

		#tombol {
            padding: 15px 0;
            text-align: center;
            font-weight: bold;
			position: absolute;
			bottom:0;
			z-index: 2;
			width:92%;
			background: #fff;
			webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    		box-shadow: 0 1px 20px 0 #888;
			left: 50%;
    		transform: translate(-50%, -25%);
			border-radius:10px;
			font-size:14px;
        }

        .valid {
            background: #4caf50;
            color: white;
        }

        .invalid {
            background: #f44336;
            color: white;
        }

        #map {
            height: 80vh;
            width: 100%;
			margin-top:-160px;
        }

		#date-wrapper {
			font-size:16px;
		}

		#clock-wrapper {
			margin-top:5px;
			margin-bottom:10px;
		}
    </style>
</head>
<body>

	<div id="status">Mendeteksi lokasi...</div>
	<div id="map"></div>
	<div id="tombol">
		<div id="date-wrapper">
			<?php
				$date = date("Y-m-d");
				$dayInfo = $this->utility->formatDayDate($date);
				$dateIndo = $this->utility->formatDateIndo2($date);

				print $dayInfo;
			?>
		</div>
		<h3 id="clock-wrapper">00:00:00</h3>
		<input type="hidden" id="absen_latitude" value="" />
		<input type="hidden" id="absen_longitude" value="" />
		<input type="hidden" id="absen_time" value="" />
		
		<?php
			$jam = strtotime(date("H:i:s"));
			$waktuMasuk = strtotime($apel_mulai["value"]);
			$waktuSelesai = strtotime($apel_selesai["value"]);

			$type = "Apel";

			if (date('l') === 'Friday') {
				$type = "Senam";
			}

			if ($jam >= $waktuMasuk) {
				
				if ($jam > $waktuSelesai) {
		?>
					<a href="javascript:;" class="btn btn-terlambat btn-danger hidden" disabled="disabled">TERLAMBAT <?php print strtoupper($type); ?></a>
		<?php
				}
				else {
		?>
					<a href="javascript:;" class="btn btn-checkin btn-info hidden" disabled="disabled">CHECK-IN <?php print strtoupper($type); ?></a>
		<?php
				}
		?>
				<a href="javascript:;" class="btn btn-tidak-hadir btn-danger hidden" disabled="disabled">TIDAK HADIR <?php print strtoupper($type); ?></a>
		<?php
			}
		?>
	</div>

	<script>

		function getDeviceHeight() {
			return document.documentElement.clientHeight;
		}

		function showClock () {
			setInterval(function() {
				var date = new Date();
				var har = date.getHours();
				var min = date.getMinutes();
				var sec = date.getSeconds();
				
				if (har < 10) {
					har = "0" + date.getHours();
				}

				if (min < 10) {
					min = "0" + date.getMinutes();
				}

				if (sec < 10) {
					sec = "0" + date.getSeconds();
				}

				$('#clock-wrapper').html(
					har + ":" + min + ":" + sec
				);

				$('#absen_time').val(har + ":" + min + ":" + sec);
			}, 500);
		}

		window.addEventListener("load", () => {
			const height = getDeviceHeight();
			$("#map").css("height",height+100);

			showClock();
		});

		$(document).ready(function () {
			$('.btn-checkin').click(function () {
				var disabled = $(this).attr('disabled');

				if (typeof disabled !== 'undefined' && disabled !== false) {
					return; // stop jika masih disabled
				}

				Swal.fire({
					text: 'Apakah anda yakin untuk Check-In <?php print $type; ?>?',
					title: 'Check-In <?php print $type; ?>',
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Simpan',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						var get_lat = $("#absen_latitude").val();
						var get_lan = $("#absen_longitude").val();
						var get_time = $("#absen_time").val();

						Loader.start();

						$.ajax({
							type: "POST",
							url: "/admin/absensi/absen_apel",
							data: {
								latitude: get_lat,
								longitude: get_lan,
								time: get_time,
								tidak_hadir: 0,
								keterangan: "",
								version: Math.random()				
							},
							dataType: 'json',
							success: function(obj){
								Loader.stop();

								Swal.fire({
									icon: 'success',
									title: 'Sukses',
									text: "Berhasil merekam Check-In <?php print $type; ?>",
								showConfirmButton: true,
								}).then(function() {
									location.reload();
								});
							}
						});
					}
				});
			});
		});


		/* ===============================
		KONFIGURASI KANTOR
		================================ */
		const OFFICE_LOCATION = {
			lat: <?php print $latitude["value"] ?>,   // LAT KANTOR
			lng: <?php print $longitude["value"] ?>   // LNG KANTOR
		};

		const RADIUS = 32; // meter

		let map;

		/* ===============================
		INIT SETELAH MAPS SIAP
		================================ */
		function onMapsLoaded() {
			if (!navigator.geolocation) {
				alert("Browser tidak mendukung geolocation");
				return;
			}

			navigator.geolocation.getCurrentPosition(
				handleLocation,
				() => alert("Gagal mendapatkan lokasi"),
				{ enableHighAccuracy: true }
			);
		}

		/* ===============================
		PROSES LOKASI USER
		================================ */
		function handleLocation(position) {
			const userLocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};

			const distance = calculateDistance(
				userLocation.lat,
				userLocation.lng,
				OFFICE_LOCATION.lat,
				OFFICE_LOCATION.lng
			);

			map = new google.maps.Map(document.getElementById("map"), {
				center: OFFICE_LOCATION,
				zoom: 19.3,
				mapId: "42762d763df06bc039ae5620",
				mapTypeControl: false,
				fullscreenControl: false,
				streetViewControl: false
			});

			// Marker Kantor (Advanced Marker)
			/*new google.maps.marker.AdvancedMarkerElement({
				map,
				position: OFFICE_LOCATION,
				title: "Lokasi Kantor"
			});*/

			// Marker Pegawai (Advanced Marker)
			new google.maps.marker.AdvancedMarkerElement({
				map,
				position: userLocation,
				title: "Lokasi Anda"
			});

			$('#absen_latitude').val(userLocation.lat);
			$('#absen_longitude').val(userLocation.lng);

			// Radius Kantor
			new google.maps.Circle({
				map,
				center: OFFICE_LOCATION,
				radius: RADIUS,
				strokeColor: "#2196f3",
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: "#2196f3",
				fillOpacity: 0.2
			});

			// Status Absensi
			const status = document.getElementById("status");

			if (distance <= RADIUS) {
				status.className = "valid";
				status.innerHTML = `Anda berada dalam area absensi<br>Jarak: ${distance.toFixed(2)} meter`;
				
				$("#tombol .btn-checkin").removeClass('hidden').removeAttr("disabled");
				$("#tombol .btn-terlambat").removeClass('hidden').removeAttr("disabled");
				$("#tombol .btn-tidak-hadir").addClass('hidden').attr("disabled","disabled");
			} else {
				status.className = "invalid";
				status.innerHTML = `Anda di luar area absensi<br>Jarak: ${distance.toFixed(2)} meter`;

				$("#tombol .btn-checkin").addClass('hidden').attr("disabled","disabled");
				$("#tombol .btn-terlambat").addClass('hidden').attr("disabled","disabled");
				$("#tombol .btn-tidak-hadir").removeClass('hidden').removeAttr("disabled");
			}
		}

		/* ===============================
		HITUNG JARAK (HAVERSINE)
		================================ */
		function calculateDistance(lat1, lon1, lat2, lon2) {
			const R = 6371000;
			const dLat = deg2rad(lat2 - lat1);
			const dLon = deg2rad(lon2 - lon1);

			const a =
				Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos(deg2rad(lat1)) *
				Math.cos(deg2rad(lat2)) *
				Math.sin(dLon / 2) *
				Math.sin(dLon / 2);

			const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			return R * c;
		}

		function deg2rad(deg) {
			return deg * (Math.PI / 180);
		}

		$('.btn-tidak-hadir').click(function () {
			var modalTolak = '<div id="keterangan-absen" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Keterangan Tidak Hadir</h5></div><form action="/admin/absensi/absen_apel" class="form-submit"><div class="modal-body"><textarea class="form-control" name="keterangan" rows="8" id="keterangan-tidak-hadir" required></textarea></div><div class="modal-footer"><button type="button" class="btn btn-simpan-keterangan-tidak-hadir btn-primary mb-0">Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></form></div></div></div>';
		
			$('html').append(modalTolak);

			$('#keterangan-absen').modal({backdrop: 'static', keyboard: false});
			$('#keterangan-absen').modal('show');
		});

		$('.btn-terlambat').click(function () {
			var modalTolak = '<div id="keterangan-absen" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Keterangan Terlambat</h5></div><form action="/admin/absensi/absen_apel" class="form-submit"><div class="modal-body"><textarea class="form-control" name="keterangan" rows="8" id="keterangan-terlambat" required></textarea></div><div class="modal-footer"><button type="button" class="btn btn-simpan-keterangan-terlambat btn-primary mb-0">Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></form></div></div></div>';
		
			$('html').append(modalTolak);

			$('#keterangan-absen').modal({backdrop: 'static', keyboard: false});
			$('#keterangan-absen').modal('show');
		});

		$(document).ready(function () {
			$(document).on("click", ".btn-simpan-keterangan-terlambat", function () {
				var get_lat = $("#absen_latitude").val();
				var get_lan = $("#absen_longitude").val();
				var get_time = $("#absen_time").val();
				var get_keterangan = $("#keterangan-terlambat").val();

				if (get_keterangan != "") {
					Loader.start();

					$.ajax({
						type: "POST",
						url: "/admin/absensi/absen_apel",
						data: {
							latitude: get_lat,
							longitude: get_lan,
							time: get_time,
							tidak_hadir: 0,
							keterangan: get_keterangan,
							version: Math.random()				
						},
						dataType: 'json',
						success: function(obj){
							Loader.stop();

							Swal.fire({
								icon: 'success',
								title: 'Sukses',
								text: "Berhasil merekam Terlambat <?php print $type; ?>",
							showConfirmButton: true,
							}).then(function() {
								$('#keterangan-absen').modal('hide');
								location.reload();
							});
						}
					});
				}
				else {
					$("#keterangan-tidak-hadir").focus();
				}
			});

			$(document).on("click", ".btn-simpan-keterangan-tidak-hadir", function () {
				var get_lat = $("#absen_latitude").val();
				var get_lan = $("#absen_longitude").val();
				var get_time = $("#absen_time").val();
				var get_keterangan = $("#keterangan-tidak-hadir").val();

				if (get_keterangan != "") {
					Loader.start();

					$.ajax({
						type: "POST",
						url: "/admin/absensi/absen_apel",
						data: {
							latitude: get_lat,
							longitude: get_lan,
							time: get_time,
							tidak_hadir: 1,
							keterangan: get_keterangan,
							version: Math.random()				
						},
						dataType: 'json',
						success: function(obj){
							Loader.stop();

							Swal.fire({
								icon: 'success',
								title: 'Sukses',
								text: "Berhasil merekam Tidak Hadir <?php print $type; ?>",
							showConfirmButton: true,
							}).then(function() {
								$('#keterangan-absen').modal('hide');
								location.reload();
							});
						}
					});
				}
				else {
					$("#keterangan-tidak-hadir").focus();
				}
			});
		});
	</script>

	<!-- GOOGLE MAPS API (VERSI TERBARU) -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPNbmhM4wqwKZL_7Kr7-MLq-o_gvLq7ik&libraries=marker&callback=onMapsLoaded&loading=async" async defer></script>

	<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/js/pcoded.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/bootgrid/jquery.bootgrid.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/autoNumeric/autoNumeric.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/select2/select2.js'); ?>"></script>
	<script src="<?php print base_url('assets/plugins/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
	<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
	<script src="<?php print base_url('assets/js/table.js?v='.rand()); ?>"></script>
	<script src="<?php print base_url('assets/js/script.js?v='.rand()); ?>"></script>
	<script src="<?php print base_url('assets/js/biodata.js?v='.rand()); ?>"></script>
</body>
</html>
