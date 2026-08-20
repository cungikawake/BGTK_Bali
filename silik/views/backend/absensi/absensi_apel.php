<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-clock"></i> Absensi Apel & Senam</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style type="text/css">
		.flex-shrink-0 {
			flex-shrink: 0 !important;
		}
		.avatar {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 4px;
			font-size: 18px;
			font-weight: 600;
			width: 48px;
			height: 48px;
		}
		.flex-grow-1 {
			flex-grow: 1 !important;
		}
		.bg-light-success {
			background: rgb(232.4, 252.8, 247.7);
			color: #1de9b6;
		}
		.bg-light-primary {
			background: rgb(229.9, 246.4, 254);
			color: #04a9f5;
		}
		.bg-light-warning {
			background: rgb(253.9, 248.9, 233.8);
			color: #f4c22b;
		}
		.bg-light-danger {
			background: rgb(253.9, 236.1, 234.9);
			color: #f44236;
		}
		.pct-apel {
			padding-top:2px;
			font-weight: bold;
		}
		.card .card-header.card-header-success h5:after {
			background-color: #1de9b6;
		}
		.card .card-header.card-header-warning h5:after {
			background-color: #f4c22b;
		}
		.card .card-header.card-header-danger h5:after {
			background-color: #f44236;
		}
		.table-apel {
			max-height: 325px;
			min-height: 325px;
			-webkit-overflow-scrolling: touch;
		}
		.table-rekap-apel {
			max-height: 430px;
			min-height: 430px;
			-webkit-overflow-scrolling: touch;
		}
		.text-success {
			color: #2ebf55;
		}
		.text-warning {
			color: #f4c22b;
		}
		.text-danger {
			color: #f44236;
		}
		.rounded-circle {
			border-radius: 50%;
		}
		.no-absen {
			padding-left: 15px !important;
		}
		.wrap-text {
			overflow-wrap: break-word; /* standar */
  			word-wrap: break-word;     /* legacy */
			text-wrap: auto;
			white-space: normal !important;
		}
		.pct-absensi {
			float:right;
			font-size:12px;
			font-weight: bold;
			padding-top:1px;
		}
		.border-left {
			border-left: 1px solid #ccc;
		}
		.table-rekap-apel>.table>thead>tr>th {
			vertical-align: middle;
		}

		@media screen and (max-width: 767px) {
			.table-responsive {
				overflow-y: auto;
			}
			.table-apel {
				min-height: 0;
			}
			.table-rekap-apel {
				min-height: 0;
			}
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-lg-2 col-md-2">
					<div class="card-selector mb-5">
						<?php
							$senin = date('d/m/Y', strtotime('monday this week'));
							$jumat = date('d/m/Y', strtotime('friday this week'));

							$today = strtotime(date("d-m-Y"));
							$seninCom = strtotime('monday this week');
							$jumatCom = strtotime('friday this week');

							$tgl = "Senin, ".$senin;

							if ($today >= $jumatCom) {
								$tgl = "Jumat, ".$jumat;
							}
						?>
						<input type="text" class="form-control" id="tgl-apel" value="<?php print $tgl; ?>" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-2 alert-user"></div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="card">
					<div class="card-body">
						<div class="d-flex align-items-center">
						<div class="flex-shrink-0">
							<div class="avatar bg-light-primary">
							<i class="feather icon-users f-24"></i>
							</div>
						</div>
						<div class="flex-grow-1 ml-3">
							<p class="mb-1">Jumlah Pegawai</p>
							<div class="d-flex align-items-center justify-content-between">
							<h4 class="mb-0 mt-1 jumlah-pegawai">0</h4>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6">
					<div class="card">
					<div class="card-body">
						<div class="d-flex align-items-center">
						<div class="flex-shrink-0">
							<div class="avatar bg-light-success" style="color:#2ebf55;">
							<i class="feather icon-check-square f-24"></i>
							</div>
						</div>
						<div class="flex-grow-1 ml-3">
							<p class="mb-1">Hadir <span class="type-absen"></span> Tepat Waktu</p>
							<div class="d-flex align-items-center justify-content-between">
							<h4 class="mb-0 mt-1 tepat-waktu">0</h4>
							<span class="text-success pct-apel pct-tepat-waktu">0</span>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6">
					<div class="card">
					<div class="card-body">
						<div class="d-flex align-items-center">
						<div class="flex-shrink-0">
							<div class="avatar bg-light-warning">
							<i class="feather icon-minus-square f-24"></i>
							</div>
						</div>
						<div class="flex-grow-1 ml-3">
							<p class="mb-1">Hadir <span class="type-absen"></span> Terlambat</p>
							<div class="d-flex align-items-center justify-content-between">
							<h4 class="mb-0 mt-1 terlambat">0</h4>
							<span class="text-success pct-apel pct-terlambat">0</span>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6">
					<div class="card">
					<div class="card-body">
						<div class="d-flex align-items-center">
						<div class="flex-shrink-0">
							<div class="avatar bg-light-danger">
							<i class="feather icon-x-square f-24"></i>
							</div>
						</div>
						<div class="flex-grow-1 ml-3">
							<p class="mb-1">Tidak Hadir <span class="type-absen"></span></p>
							<div class="d-flex align-items-center justify-content-between">
							<h4 class="mb-0 mt-1 tidak-hadir">0</h4>
							<span class="text-success pct-apel pct-tidak-hadir">0</span>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>
			</div>

		
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="card Recent-Users table-card">
						<div class="card-header card-header-success">
							<h5>Hadir <span class="type-absen"></span> Tepat Waktu</h5>
						</div>
						<div class="card-body px-0 pb-3 pt-0">
							<div class="table-responsive table-apel">
							<table class="table table-hover mb-0">
								<tbody id="list_tepat_waktu">
									<tr><td>Tidak ada data</td></tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6">
					<div class="card Recent-Users table-card">
						<div class="card-header card-header-warning">
							<h5>Hadir <span class="type-absen"></span> Terlambat</h5>
						</div>
						<div class="card-body px-0 pb-3 pt-0">
							<div class="table-responsive table-apel">
							<table class="table table-hover mb-0">
								<tbody id="list_terlambat">
									<tr><td>Tidak ada data</td></tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6">
					<div class="card Recent-Users table-card">
						<div class="card-header card-header-danger">
							<h5>Tidak Hadir <span class="type-absen"></span></h5>
						</div>
						<div class="card-body px-0 pb-3 pt-0">
							<div class="table-responsive table-apel">
							<table class="table table-hover mb-0">
								<tbody id="list_tidak_hadir">
									<tr><td>Tidak ada data</td></tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>


			
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h5>Rekaptulasi Absensi Apel & Senam</h5>
						</div>
						<div class="card-body">
							<div class="table-responsive table-rekap-apel">
								<table class="table table-hover table-striped">
									<thead>
										<tr>
											<th width="3%" rowspan="2">No</th>
											<th width="20%" rowspan="2">Nama</th>
											<th class="border-left text-center" colspan="5">APEL</th>
											<th class="border-left text-center" colspan="5">SENAM</th>
										</tr>
										<tr>
											<th class="border-left" width="6%">Total Apel</th>
											<th class="border-left" width="7%">Ikut Apel</th>
											<th class="border-left" width="7%">Tepat Waktu</th>
											<th class="border-left" width="7%">Terlambat</th>
											<th class="border-left" width="7%">Tidak Hadir</th>

											<th class="border-left" width="6%">Total Senam</th>
											<th class="border-left" width="7%">Ikut Senam</th>
											<th class="border-left" width="7%">Tepat Waktu</th>
											<th class="border-left" width="7%">Terlambat</th>
											<th class="border-left" width="7%">Tidak Hadir</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (isset($users) && !empty($users)) {
												$i = 1;

												foreach ($users as $user) {
											?>
													<tr>
														<td><?php print $i; ?></td>
														<td class="wrap-text"><?php print $user["nama_lengkap"]; ?></td>
														
														<td class="border-left"><?php print $user["total_apel"]; ?> kali</td>
														<td class="border-left"><?php print $user["ikut_apel"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_ikut_apel"]; ?>%)</span></td>
														<td class="border-left"><?php print $user["tepat_waktu"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_tepat_waktu"]; ?>%)</span></td>
														<td class="border-left"><?php print $user["terlambat"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_terlambat"]; ?>%)</span></td>
														<td class="border-left"><?php print $user["tidak_hadir"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_tidak_hadir"]; ?>%)</span></td>

														<td class="border-left"><?php print $user["total_senam"]; ?> kali</td>
														<td class="border-left"><?php print $user["ikut_senam"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_ikut_senam"]; ?>%)</span></td>
														<td class="border-left"><?php print $user["tepat_waktu_senam"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_tepat_waktu_senam"]; ?>%)</span></td>
														<td class="border-left"><?php print $user["terlambat_senam"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_terlambat_senam"]; ?>%)</span></td>
														<td class="border-left"><?php print $user["tidak_hadir_senam"]; ?> kali &nbsp;<span class="pct-absensi">(<?php print $user["pct_tidak_hadir_senam"]; ?>%)</span></td>
													</tr>
											<?php
													$i++;
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="card">
						<div class="card-header">
							<h5>Statistik Absensi Apel</h5>
						</div>
						<div class="card-body">
							<?php
								$colChart = array();
								$colChart["title"] = "Statistik Absensi Apel";

								//print $this->chart->stackedPct("statistik_apel", $colChart, "100%", "100%");
							?>
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
	$.fn.datepicker.dates['en'] = {
		days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
		daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
		daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
		months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		today: "Today",
		clear: "Clear",
		format: "mm/dd/yyyy",
		titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
		weekStart: 0
	};

	$(document).ready(function() {

		function loadDataApel () {
			Loader.start();
			var tgl_apel = $("#tgl-apel").val();

			$.ajax({
				type: "POST",
				url: "/admin/absensi/data_apel",
				data: {
					"tgl_apel" : tgl_apel
				},
				dataType: 'json',
				success: function(obj){
					
					if (obj.error) {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: "Terjadi Kesalahan, Gagal memuat data Apel"
						});
					}
					else {
						$(".jumlah-pegawai").html(obj.jumlah_pegawai);
						
						$(".tepat-waktu").html(obj.tepat_waktu);
						$(".terlambat").html(obj.terlambat);
						$(".tidak-hadir").html(obj.tidak_hadir);

						$(".pct-tepat-waktu").html(obj.pct_tepat_waktu);
						$(".pct-terlambat").html(obj.pct_terlambat);
						$(".pct-tidak-hadir").html(obj.pct_tidak_hadir);

						$("#list_tepat_waktu").html(obj.list_tepat_waktu);
						$("#list_terlambat").html(obj.list_terlambat);
						$("#list_tidak_hadir").html(obj.list_tidak_hadir);

						$('.alert-user').html(obj.user_alert);
						$('.type-absen').html(obj.type);
					}

					Loader.stop();
				}
			});
		}

		$("#tgl-apel").datepicker({
			autoclose: true,
			format: 'DD, dd/mm/yyyy',
			startDate: "01/01/<?php print $_SESSION["tahun_anggaran"]; ?>",
			beforeShowDay:
				function(dt)
				{
				return dt.getDay() == 1 || dt.getDay() == 5;
			}
		});
		
		$("#tgl-apel").change(function () {
			loadDataApel();
		});

		$(document).on("click", ".keterangan-terlambat", function () {
			var id = $(this).attr("data-id");
			var keterangan = $(".keterangan-apel-"+id).html();
			var modalTolak = '<div id="keterangan-absen" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Keterangan Terlambat</h5></div><div class="modal-body"><p>'+keterangan+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
		
			$('html').append(modalTolak);

			$('#keterangan-absen').modal({backdrop: 'static', keyboard: false});
			$('#keterangan-absen').modal('show');
		});

		$(document).on("click", ".keterangan-tidak-hadir", function () {
			var id = $(this).attr("data-id");
			var keterangan = $(".keterangan-apel-"+id).html();
			var modalTolak = '<div id="keterangan-absen" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Keterangan Tidak Hadir</h5></div><div class="modal-body"><p>'+keterangan+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
		
			$('html').append(modalTolak);

			$('#keterangan-absen').modal({backdrop: 'static', keyboard: false});
			$('#keterangan-absen').modal('show');
		});

		// First Load
		loadDataApel();
	});
</script>
