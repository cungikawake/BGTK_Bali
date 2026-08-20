<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-clock"></i> Absensi Pegawai</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<div class="card">
						<div class="card-header">
							<h5 class="bootgrid-title">ABSENSI PEGAWAI</h5>
						</div>
						<div class="card-body">
							<div class="row absen-info">
								<div class="col-xs-12">
									<div class="text-center t-bold" style="margin-bottom:7px;">
									<?php
										$date = date("Y-m-d");
										$dayInfo = $this->utility->formatDayDate($date);
										$dateIndo = $this->utility->formatDateIndo2($date);

										print $dayInfo;
									?>
										<h3 id="clock-wrapper" style="margin-top:5px;"></h3>
									</div>
								</div>
								<div class="col-xs-12">
									<input type="hidden" id="absen_latitude" value="" />
									<input type="hidden" id="absen_longitude" value="" />
									<input type="hidden" id="absen_time" value="" />
									<div class="text-center" style="margin-bottom:20px;">
										<?php
											$showAbsenMasuk = true;
											$showAbsenKeluar = true;

											if (isset($absen["absen_masuk"]) && !empty($absen["absen_masuk"])) {
												$showAbsenMasuk = false;
											}

											// Jam 12 Siang
											$siang = date("H");
											
											if ($siang >= "12") {
												$showAbsenMasuk = false;
											}

											if ($showAbsenMasuk) {
												$showAbsenKeluar = false;
											}

											if ($showAbsenMasuk) {
										?>
												<a href="javascript:;" class="btn btn-success absen-masuk">ABSEN MASUK</a>
										<?php
											}

											if ($showAbsenKeluar) {
										?>
												<a href="javascript:;" class="btn btn-danger absen-keluar">ABSEN KELUAR</a>
										<?php
											}
										?>
									</div>
								</div>
								<hr />
								<div class="col-xs-6">
									<div class="absen-info-in alert alert-success text-center">
										<div class="t-bold">MASUK</div>
										<div>
											<?php
												if (isset($absen["absen_masuk"]) && !empty($absen["absen_masuk"])) {
													print $absen["absen_masuk"];
												}
												else {
													print "00:00:00";
												}
											?>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="absen-info-out alert alert-danger text-center">
										<div class="t-bold">KELUAR</div>
										<div>
											<?php
												if (isset($absen["absen_keluar"]) && !empty($absen["absen_keluar"])) {
													print $absen["absen_keluar"];
												}
												else {
													print "00:00:00";
												}
											?>
										</div>
									</div>
								</div>
								
							</div>

							<div id="map"></div>
							<div id="result"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>

	<style type="text/css">
		#map {
			height:500px;
		}

		@media only screen and (max-width: 935px) {
			.page-header {
				display: none;
			}
			.card .card-body {
				padding:15px;
			}
			#map {
				height:300px;
			}
		}
		.card {
			position: relative;
		}
	</style>

<?php $this->load->view("backend/includes/footer"); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYz0goVzOIYYESY9cG_PlCKW68AnSQAJ0&libraries=marker&v=weekly"></script>
<script type="text/javascript">
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

	function findMe () {
		var masterLat = "<?php print $latitude["value"]; ?>";
		var masterLng = "<?php print $longitude["value"]; ?>";

		if ("geolocation" in navigator){ //check geolocation available 
			// try to get user current location using getCurrentPosition() method
			navigator.geolocation.getCurrentPosition(function(position){ 
				$("#result").html("Found your location (Lat : "+position.coords.latitude+", Lang :"+ position.coords.longitude + ")") ;
				masterLat = position.coords.latitude;
				masterLng = position.coords.longitude;
				initMap(masterLat, masterLng);
			},
			function (err) {
				console.warn(`ERROR(${err.code}): ${err.message}`);
			},
			{ enableHighAccuracy: true, timeout: 5000, maximumAge: 0}
		);
		}
		else {
			alert("Browser doesn't support geolocation!");
		}
	}

	async function initMap(masterLat, masterLng) {
		// Set Input
		$('#absen_latitude').val(masterLat);
		$('#absen_longitude').val(masterLng);

		// Request needed libraries.
		const { Map } = await google.maps.importLibrary("maps");
		const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
			"marker",
		);
		const { Place } = await google.maps.importLibrary("places");
		const map = new Map(document.getElementById("map"), {
			center: { lat: masterLat, lng: masterLng },
			zoom: 10,
			mapId: "4504f8b37365c3d0",
		});

		var me = {};
		me.position = { lat: masterLat, lng: masterLng },
		me.image = "https://bgpbali.id/assets/images/map-marker.png?v=44321";
		me.name = "Posisi saya saat ini";

		var beachFlagImg = document.createElement("img");

		beachFlagImg.src = me.image;
		beachFlagImg.style.width = "30px";

		var beachFlagMarkerView = new AdvancedMarkerElement({
			map,
			position: me.position,
			content: beachFlagImg,
			title: me.name,
		});

		
		// LOAD POSISI USER LAIN

		var userPositions = [];

		<?php
			if (isset($pegawai) && !empty($pegawai)) {
				foreach ($pegawai as $map) {
		?>
					var user = {};
					user.position = { lat: <?php print $map["latitude"]; ?>, lng: <?php print $map["longitude"]; ?> },
					user.image = "<?php print base_url("/assets/user_profile/profile_".$map["user_id"].".png?v=".rand()); ?>";
					user.name = "<?php print $map["nama"]; ?>";

					userPositions.push(user);
		<?php
				}
			}
		?>

		$.each(userPositions, function(i, val) {
			// [START maps_advanced_markers_graphics_png]
			// A marker with a with a URL pointing to a PNG.
			var beachFlagImg = document.createElement("img");

			beachFlagImg.src = val.image;
			beachFlagImg.style.width = "40px";
			beachFlagImg.style.border = "4px solid #FFFFFF";
			beachFlagImg.style.borderRadius = "50%";

			var beachFlagMarkerView = new AdvancedMarkerElement({
				map,
				position: val.position,
				content: beachFlagImg,
				title: val.name,
			});
			// [END maps_advanced_markers_graphics_png]
		});
	}

	findMe();
	showClock();

	$(document).ready(function() {
		$('.absen-masuk').click(function () {
			Swal.fire({
				text: 'Apakah anda yakin untuk absen masuk?',
				title: 'Absen Masuk',
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
						url: "/admin/absensi/absen_masuk",
						data: {
							latitude: get_lat,
							longitude: get_lan,
							time: get_time,
							version: Math.random()				
						},
						dataType: 'json',
						success: function(obj){
							Loader.stop();

							Swal.fire({
								icon: 'success',
								title: 'Sukses...',
								text: "Berhasil merekam absen masuk",
							showConfirmButton: true,
							}).then(function() {
								location.reload();
							});
						}
					});
				}
			});
		});

		$('.absen-keluar').click(function () {
			var modalTolak = '<div id="keterangan-absen" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Laporan Log Hari Ini</h5></div><form action="/admin/absensi/absen_keluar" class="form-submit"><div class="modal-body"><textarea class="form-control" name="log_harian" rows="8" id="log-absen" required></textarea></div><div class="modal-footer"><button type="submit" class="btn btn-primary mb-0">Simpan</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></form></div></div></div>';
		
			$('html').append(modalTolak);

			$('#keterangan-absen').modal({backdrop: 'static', keyboard: false});
			$('#keterangan-absen').modal('show');
		});
	});
</script>
