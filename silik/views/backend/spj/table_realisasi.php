<ul class="nav nav-tabs" role="tablist">
	<?php if ($pagu_transport > 0) { ?>
	<li class="nav-item">
		<a class="nav-link first-tab" href="#realisasi-total" aria-controls="realisasi-total">Total</a>
	</li>
	<?php } ?>
	<?php if ($pagu_transport > 0) { ?>
	<li class="nav-item">
		<a class="nav-link" href="#realisasi-kab" aria-controls="realisasi-kab">Transport Kabupaten/Kota</a>
	</li>
	<?php } ?>
	<?php if ($pagu_honor > 0) { ?>
		<li class="nav-item">
			<a class="nav-link" href="#realisasi-honor" aria-controls="realisasi-honor">Honor</a>
		</li>
	<?php } ?>
</ul>
<div class="tab-content">
	<?php if ($pagu_transport > 0) { ?>
	<div class="tab-pane" id="realisasi-total">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<?php
							$colChart = array();
							$colChart["title"] = "";
							$colChart["categories"] = array("Transport", "Uang Harian");
							$colChart["data"] = array();
							$colChart["data"][] = array(
								"nama" => "Sisa",
								"value" => array($sisa_transport, $sisa_uang_harian)
							);
							$colChart["data"][] = array(
								"nama" => "Realisasi",
								"value" => array($realisasi_transport, $realisasi_uang_harian)
							);

							print $this->chart->columnDouble("column_peserta_total", $colChart, "100%", "250px");
						?>
					</div>
					<div class="col-md-6">
						<?php 
							$pieChart = array();
							$pieChart["title"] = "";
							$pieChart["data"] = array();
							$pieChart["data"][] = array(
								"nama" => "Sisa",
								"value" => $total_sisa
							);
							$pieChart["data"][] = array(
								"nama" => "Realisasi",
								"value" => $total_realisasi
							);

							print $this->chart->pie("pie_peserta_total", $pieChart, "100%", "250px");
						?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<table class="table table-condensed table-hover table-striped">
					<thead>
						<tr>
							<th></th>
							<th class="text-right">Pagu</th>
							<th class="text-right">Realisasi</th>
							<th class="text-right">Sisa</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="font-weight: bold;">Tiket</td>
							<td class="text-right"><?php print $this->utility->format_money($pagu_tiket); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($realisasi_tiket); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($sisa_tiket); ?></td>
						</tr>
						
						<tr>
							<td style="font-weight: bold;">Taksi</td>
							<td class="text-right"><?php print $this->utility->format_money($pagu_taksi); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($realisasi_taksi); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($sisa_taksi); ?></td>
						</tr>
						
						<tr>
							<td style="font-weight: bold;">Transport</td>
							<td class="text-right"><?php print $this->utility->format_money($pagu_transport); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($realisasi_transport); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($sisa_transport); ?></td>
						</tr>
						
						<tr>
							<td style="font-weight: bold;">Uang Harian</td>
							<td class="text-right"><?php print $this->utility->format_money($pagu_uang_harian); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($realisasi_uang_harian); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($sisa_uang_harian); ?></td>
						</tr>
						<tr>
							<td style="font-weight: bold;">Penginapan</td>
							<td class="text-right"><?php print $this->utility->format_money($pagu_penginapan); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($realisasi_penginapan); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($sisa_penginapan); ?></td>
						</tr>
						<tr>
							<td style="font-weight: bold;">Honor</td>
							<td class="text-right"><?php print $this->utility->format_money($pagu_honor); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($realisasi_honor); ?></td>
							<td class="text-right"><?php print $this->utility->format_money($sisa_honor); ?></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th style="font-weight: bold;">Total</th>
							<th class="text-right"><?php print $this->utility->format_money($total_pagu); ?></th>
							<th class="text-right"><?php print $this->utility->format_money($total_realisasi); ?></th>
							<th class="text-right"><?php print $this->utility->format_money($total_sisa); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if ($pagu_transport > 0) { ?>
	<div class="tab-pane" id="realisasi-kab">
		<div class="row">
			<div class="col-md-6">
				<?php
					$colChart = array();
					$colChart["title"] = "-";
					$colChart["categories"] = array();
					$colChart["data"] = array();

					$colChartTransport = array();
					$colChartUangHarian = array();

					if (isset($kab) && !empty($kab)) {
						foreach ($kab as $key => $res) {
							$colChart["categories"][] = $key;
							$colChartTransport[] = $res["transport"];
							$colChartUangHarian[] = $res["uang_harian"];
						}
					}

					$colChart["data"][] = array(
						"nama" => "Transport",
						"value" => $colChartTransport
					);
					$colChart["data"][] = array(
						"nama" => "Uang Harian",
						"value" => $colChartUangHarian
					);

					print $this->chart->column("column_peserta", $colChart, "100%", "100%");
				?>
			</div>
			<div class="col-md-6">
				<h5>Transport</h5>
				<table class="table table-condensed table-hover table-striped mb-5">
					<thead>
						<tr>
							<th>Kab/Kota</th>
							<th class="text-right">Orang</th>
							<th class="text-right">Transport</th>
							<th class="text-right">Uang Harian</th>
							<th class="text-right">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$totalPax = 0;
							$totalTransport = 0;
							$totalUH = 0;

							if (isset($kab) && !empty($kab)) {
								foreach ($kab as $key => $res) {
									$totalPax += $res["pax"];
									$totalTransport += $res["transport"];
									$totalUH += $res["uang_harian"];
						?>
									<tr>
										<td style="font-weight: bold;"><?php print $key; ?></td>
										<td class="text-right"><?php print $this->utility->format_number($res["pax"]); ?></td>
										<td class="text-right"><?php print $this->utility->format_money($res["transport"]); ?></td>
										<td class="text-right"><?php print $this->utility->format_money($res["uang_harian"]); ?></td>
										<td class="text-right"><?php print $this->utility->format_money($res["transport"] + $res["uang_harian"]); ?></td>
									</tr>
						<?php
								}
							}
						?>

					</tbody>
					<tfoot>
						<tr>
							<th>&nbsp;</th>
							<th class="text-right"><?php print $this->utility->format_number($totalPax); ?></th>
							<th class="text-right"><?php print $this->utility->format_money($totalTransport); ?></th>
							<th class="text-right"><?php print $this->utility->format_money($totalUH); ?></th>
							<th class="text-right"><?php print $this->utility->format_money($totalTransport + $totalUH); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if ($pagu_honor > 0) { ?>
	
		<div class="tab-pane" id="realisasi-honor">
			<div class="row">
				<div class="col-md-6">
					<?php 
						$pieChart = array();
						$pieChart["title"] = "";
						$pieChart["data"] = array();
						$pieChart["data"][] = array(
							"nama" => "Sisa",
							"value" => $sisa_honor
						);
						$pieChart["data"][] = array(
							"nama" => "Realisasi",
							"value" => $realisasi_honor
						);

						print $this->chart->pie("pie_honor", $pieChart, "100%", "250px");
					?>
				</div>
				<div class="col-md-6">
					<h5>Honor</h5>
					<table class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th></th>
								<th class="text-right">Honor</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="font-weight: bold;">Pagu</td>
								<td class="text-right"><?php print $this->utility->format_money($pagu_honor); ?></td>
							</tr>
							<tr>
								<td style="font-weight: bold;">Realisasi</td>
								<td class="text-right"><?php print $this->utility->format_money($realisasi_honor); ?></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th style="font-weight: bold;">Sisa</th>
								<th class="text-right"><?php print $this->utility->format_money($sisa_honor); ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
