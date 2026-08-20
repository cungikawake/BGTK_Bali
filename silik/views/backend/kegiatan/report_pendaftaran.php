<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link first-tab" href="#report-kab" aria-controls="report-kab">Kabupaten/Kota</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#report-unsur" aria-controls="report-unsur">Unsur</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#report-waktu" aria-controls="report-waktu">Waktu Daftar</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane" id="report-kab">
		<div class="row">
			<div class="col-md-7">
				<?php
					$colChart = array();
					$colChart["title"] = "-";
					$colChart["categories"] = array();
					$colChart["data"] = array();

					$colChartData = array();

					if (isset($report_kab) && !empty($report_kab)) {
						foreach ($report_kab as $kab => $foo) {
							$colChart["categories"][] = ucwords( strtolower($kab) );
							$colChartData[] = $foo;
						}
					}

					$colChart["data"][] = array(
						"nama" => $unsur,
						"value" => $colChartData
					);

					print $this->chart->column("report_kab", $colChart, "100%", "100%");
				?>
			</div>
			<div class="col-md-5">
				<h5><?php print ucfirst($unsur); ?> Per Kabupaten/Kota</h5>
				<div class="wrap-table-bootgrid">
					<table class="table table-condensed table-hover table-striped mb-5">
						<thead>
							<tr>
								<th>No</th>
								<th class="text-left">Kabupaten/Kota</th>
								<th class="text-right">Jumlah <?php print ucfirst($unsur); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$total_kab = 0;
								if (!empty($report_kab)) {
									$no = 1;
									foreach ($report_kab as $kab => $foo) {
										$total_kab += $foo;
							?>
										<tr>
											<td><?php print $no; ?></td>
											<td class="text-left"><?php print ucwords( strtolower($kab) ); ?></td>
											<td class="text-right"><?php print $this->utility->format_number($foo); ?></td>
										</tr>
							<?php
										$no++;
									}
								}
								else {
							?>
								<tr>
									<td colspan="3">Data tidak ditemukan</td>
								</tr>
							<?php
								}
							?>

						</tbody>
						<?php
							if (!empty($total_kab)) {
						?>
							<tfoot>
								<tr>
									<th colspan="2" class="text-left">TOTAL</th>
									<th class="text-right"><?php print $this->utility->format_number($total_kab); ?></th>
								</tr>
							</tfoot>
						<?php
							}
						?>

					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="report-unsur">
		<div class="row">
			<div class="col-md-7">
				<?php
					$colChart = array();
					$colChart["title"] = "-";
					$colChart["categories"] = array();
					$colChart["data"] = array();

					$colChartData = array();

					if (isset($report_unsur) && !empty($report_unsur)) {
						foreach ($report_unsur as $doo => $foo) {
							$colChart["categories"][] = $doo;
							$colChartData[] = $foo;
						}
					}

					$colChart["data"][] = array(
						"nama" => $unsur,
						"value" => $colChartData
					);

					print $this->chart->column("report_unsur", $colChart, "100%", "100%");
				?>
			</div>
			<div class="col-md-5">
				<h5><?php print ucfirst($unsur); ?> Per Unsur Satuan</h5>
				<div class="wrap-table-bootgrid">
					<table class="table table-condensed table-hover table-striped mb-5">
						<thead>
							<tr>
								<th>No</th>
								<th class="text-left">Unsur</th>
								<th class="text-right">Jumlah <?php print ucfirst($unsur); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$total_unsur = 0;
								if (!empty($report_unsur)) {
									$no = 1;
									foreach ($report_unsur as $unsurSat => $foo) {
										$total_unsur += $foo;
							?>
										<tr>
											<td><?php print $no; ?></td>
											<td class="text-left"><?php print $unsurSat; ?></td>
											<td class="text-right"><?php print $this->utility->format_number($foo); ?></td>
										</tr>
							<?php
										$no++;
									}
								}
								else {
							?>
								<tr>
									<td colspan="3">Data tidak ditemukan</td>
								</tr>
							<?php
								}
							?>

						</tbody>
						<?php
							if (!empty($total_unsur)) {
						?>
							<tfoot>
								<tr>
									<th colspan="2" class="text-left">TOTAL</th>
									<th class="text-right"><?php print $this->utility->format_number($total_unsur); ?></th>
								</tr>
							</tfoot>
						<?php
							}
						?>

					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="report-waktu">
		<div class="row">
			<div class="col-md-7">
				<?php
					$colChart = array();
					$colChart["title"] = "-";
					$colChart["title_y"] = "Jumlah Peserta";
					$colChart["data"] = array();
					$chartData = array();
				
					if (!empty($report_waktu)) {
						foreach ($report_waktu as $waktu => $foo) {
							$chartStats = array($this->utility->formatShortDayMonth($waktu), $foo);
							$chartData[] = $chartStats;
						}
					}

					$colChart["data"][] = array(
						"name" => ucfirst($unsur),
						"data" => $chartData
					);

					print $this->chart->lineDate("report_waktu_chart", $colChart, "100%", "100%");
				?>
			</div>
			<div class="col-md-5">
				<h5><?php print ucfirst($unsur); ?> Per Waktu Daftar</h5>
				<div class="wrap-table-bootgrid">
					<table class="table table-condensed table-hover table-striped mb-5">
						<thead>
							<tr>
								<th>No</th>
								<th class="text-left">Waktu Daftar</th>
								<th class="text-right">Jumlah <?php print ucfirst($unsur); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$total_waktu = 0;
								if (!empty($report_waktu)) {
									$no = 1;
									foreach ($report_waktu as $waktu => $foo) {
										$total_waktu += $foo;
							?>
										<tr>
											<td><?php print $no; ?></td>
											<td class="text-left"><?php print $this->utility->formatDateIndo($waktu); ?></td>
											<td class="text-right"><?php print $this->utility->format_number($foo); ?></td>
										</tr>
							<?php
										$no++;
									}
								}
								else {
							?>
								<tr>
									<td colspan="3">Data tidak ditemukan</td>
								</tr>
							<?php
								}
							?>

						</tbody>
						<?php
							if (!empty($total_waktu)) {
						?>
							<tfoot>
								<tr>
									<th colspan="2" class="text-left">TOTAL</th>
									<th class="text-right"><?php print $this->utility->format_number($total_waktu); ?></th>
								</tr>
							</tfoot>
						<?php
							}
						?>

					</table>
				</div>
			</div>
		</div>
	</div>
</div>
