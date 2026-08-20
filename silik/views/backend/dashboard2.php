<?php $this->load->view("backend/includes/header"); ?>   
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-home"></i> Ringkasan Eksekutif Pelatihan</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style type="text/css">
		.card-block i.feather {
			background-color: #EEF5FD;
			padding: 8px 10px;
			color: #2C70D5;
			border-radius: 5px;
		}
		.tab-pane.show {
			opacity: 1;
		}
		.card-header .nav-pills .nav-item .nav-link {
			padding:5px;
			font-size:13px;
		}
		.highcharts-credits {
			display:none;
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">			
			<div class="row">
				<div class="col-md-3">
					<div class="card user-card">
						<div class="card-block">
							<h5 class="mb-4"><i class="feather icon-layers"></i>&nbsp; Jumlah Pelatihan</h5>
							<h3 class="mb-4"><?php print $this->utility->format_number($kegiatan); ?></h3>
							<span class="text-muted">Pelatihan tahun ini</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card user-card">
						<div class="card-block">
							<h5 class="mb-4"><i class="feather icon-users"></i>&nbsp; Jumlah Peserta</h5>
							<h3 class="mb-4"><?php print $this->utility->format_number($biodata); ?></h3>
							<span class="text-muted">Peserta pelatihan tahun ini</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card user-card">
						<div class="card-block">
							<h5 class="mb-4"><i class="feather icon-watch"></i> Kehadiran</h5>
							<h3 class="mb-4"><?php print $this->utility->format_number($kegiatan); ?></h3>
							<span class="text-muted">Persentase kehadiran peserta</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card user-card">
						<div class="card-block">
							<h5 class="mb-4"><i class="feather icon-trending-up"></i>&nbsp; Tingkat Kepuasan</h5>
							<h3 class="mb-4"><?php print $this->utility->format_number($biodata); ?></h3>
							<span class="text-muted">Tingkat kepuasan peserta</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="card user-card perPelatihan">
						<div class="card-header">
							<ul class="nav nav-pills">
								<li class="nav-item"><a class="nav-link active" href="javascript:;" id="perBulan-tab">Per Bulan</a></li>
								<li class="nav-item"><a class="nav-link" href="javascript:;" id="perTW-tab" tabindex="-1">Per Triwulan</a></li>
								<li class="nav-item"><a class="nav-link" href="javascript:;" id="perSM-tab" tabindex="-1">Per Semester</a></li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-pane fade hide show" id="perBulan">
								<div class="card-block">
									<?php
										$colChart = array();
										$colChart["title"] = "Jumlah Pelatihan Per Bulan";
										$colChart["categories"] = array();
										$colChart["data"] = array();

										$colChartData = array();

										if (isset($pelatihan_graph["month"]) && !empty($pelatihan_graph["month"])) {
											foreach ($pelatihan_graph["month"] as $doo => $foo) {
												$colChart["categories"][] = $doo;
												$colChartData[] = $foo;
											}
										}

										$colChart["data"][] = array(
											"nama" => "Pelatihan",
											"value" => $colChartData
										);

										print $this->chart->column("jumlah_pelatihan", $colChart, "100%", "300px");
									?>
								</div>
							</div>
							<div class="tab-pane fade hide" id="perTW">
								<div class="card-block">
									<?php
										$colChart = array();
										$colChart["title"] = "Jumlah Pelatihan Per Triwulan";
										$colChart["categories"] = array();
										$colChart["data"] = array();

										$colChartData = array();

										if (isset($pelatihan_graph["triwulan"]) && !empty($pelatihan_graph["triwulan"])) {
											foreach ($pelatihan_graph["triwulan"] as $doo => $foo) {
												$colChart["categories"][] = $doo;
												$colChartData[] = $foo;
											}
										}

										$colChart["data"][] = array(
											"nama" => "Pelatihan",
											"value" => $colChartData
										);

										print $this->chart->column("jumlah_pelatihan_tw", $colChart, "100%", "300px");
									?>
								</div>
							</div>
							<div class="tab-pane fade hide" id="perSM">
								<div class="card-block">
									<?php
										$colChart = array();
										$colChart["title"] = "Jumlah Pelatihan Per Semester";
										$colChart["categories"] = array();
										$colChart["data"] = array();

										$colChartData = array();

										if (isset($pelatihan_graph["semester"]) && !empty($pelatihan_graph["semester"])) {
											foreach ($pelatihan_graph["semester"] as $doo => $foo) {
												$colChart["categories"][] = $doo;
												$colChartData[] = $foo;
											}
										}

										$colChart["data"][] = array(
											"nama" => "Pelatihan",
											"value" => $colChartData
										);

										print $this->chart->column("jumlah_pelatihan_q", $colChart, "100%", "300px");
									?>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="card user-card">
						<div class="card-block" style="margin-left:-15px;margin-right:-15px;">
							<?php
								$colChart = array();
								$colChart["title"] = "Tingkat Kehadiran Peserta";
								$colChart["categories"] = array();
								$colChart["data"] = array();

								$colChart["data"][] = array(
									"nama" => "Hadir",
									"value" => 99
								);

								$colChart["data"][] = array(
									"nama" => "Tidak Hadir",
									"value" => 1
								);

								print $this->chart->pie("kehadiran_pelatiahn", $colChart, "100%", "100%");
							?>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="card user-card">
						<div class="card-block" style="margin-left:-15px;margin-right:-15px;">
							<?php
								$colChart = array();
								$colChart["title"] = "Tingkat Kepuasan Peserta";
								$colChart["categories"] = array();
								$colChart["data"] = array();

								$colChart["data"][] = array(
									"nama" => "Sangat Puas",
									"value" => 60
								);

								$colChart["data"][] = array(
									"nama" => "Puas",
									"value" => 20
								);

								$colChart["data"][] = array(
									"nama" => "Cukup",
									"value" => 10
								);

								$colChart["data"][] = array(
									"nama" => "Kurang",
									"value" => 5
								);

								$colChart["data"][] = array(
									"nama" => "Tidak Puas",
									"value" => 5
								);

								print $this->chart->pie("kepuasan_pelatiahn", $colChart, "100%", "100%");
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.perPelatihan .nav-link').click(function () {
			var id = $(this).attr("id").replace("-tab","");
			
			$('.perPelatihan .nav-link').removeClass("active");
			$(this).addClass("active");

			$('.perPelatihan .tab-pane').removeClass("show");
			$('.perPelatihan .tab-pane#'+id).addClass("show");
		});
	});
</script>
