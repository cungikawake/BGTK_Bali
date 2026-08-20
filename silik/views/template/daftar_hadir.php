<style>
	.table-daftar-hadir tr th {
		border-bottom: 1px solid #333;
		border-left: 1px solid #333;
		padding-left: 5px;
		background-color:#CBCBCB;
	}
	.table-daftar-hadir tr td {
		border-bottom: 1px solid #333;
		border-left: 1px solid #333;
		padding-left: 5px;
		padding-top:10px;
		padding-bottom:10px;
	}
	.table-daftar-hadir tr .last-col {
		border-right: 1px solid #333;
	}
	.table-daftar-hadir {
		border-top: 1px solid #333;
	}
	.table-daftar-hadir tr td.center {
		text-align: center;
	}
</style>

<?php
	$showTtd = false;

	if (isset($kegiatan_options) && !empty($kegiatan_options)) {
		foreach ($kegiatan_options as $opt) {
			if ($opt["key"] == "form_ttd") {
				$showTtd = $opt["value"];
				break;
			}
		}
	}

	if ($kegiatan["tipe_kegiatan"] == "Daring") {
		$showTtd = true;
	}

	$typeTitle = $type;
?>
<table width="100%" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td width="100%" style="text-align: center;"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" width="68%" /></td>
		</tr>
	</tbody>
</table>

<table width="100%" style="font-family: 'timesnewromanxx';text-align: center;">
	<tbody>
		<tr>
			<td>
				<div style="font-size: 11px;">&nbsp;</div>
				<div style="font-size: 18px; font-weight: bold;">DAFTAR HADIR <?php print strtoupper(str_replace("_"," ",$type)); ?></div>
				<div style="font-size: 6px;">&nbsp;</div>
			</td>	
		</tr>
	</tbody>
</table>

<table width="100%" style="font-family: 'timesnewromanxx'; font-size: 16px; margin-bottom: 10px;vertical-align:top;" cellpadding="0">
	<tbody>
		<tr>
			<td style="width: 110px;">Kegiatan</td>
			<td style="width: 12px;">:</td>
			<td><?php print $kegiatan["nama"]; ?></td>
		</tr>
		<tr>
			<td>Hari, Tanggal</td>
			<td>:</td>
			<td><?php print $this->utility->formatRangeDay($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?>, <?php print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></td>
		</tr>
		
		<?php
			if ($kegiatan["tipe_kegiatan"] == "Daring") {
		?>
			<tr>
				<td>Meeting Id</td>
				<td>:</td>
				<td><?php print $kegiatan["zoom_id_kegiatan"]; ?></td>
			</tr>
		<?php
			}
			else {
		?>
			<tr>
				<td>Tempat</td>
				<td>:</td>
				<td><?php print $kegiatan["tempat_kegiatan"]." (".$kegiatan["kab_tempat_kegiatan"].")"; ?></td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<table width="100%" style="font-family: 'timesnewromanxx'; page-break-inside: always; margin-bottom: 14px;" class="table-daftar-hadir" cellpadding="8px" cellspacing="0">
	<thead>
		<?php
			if ($kegiatan["tgl_mulai_kegiatan"] == $kegiatan["tgl_selesai_kegiatan"]) {
		?>
				<tr>
					<th class="center middle bold" width="5%">No</th>
					<th class="center middle bold" width="25%">Nama / NIP</th>
					<th class="center middle bold" width="15%">Pangkat / Gol</th>
					<th class="center middle bold" width="20%">Jabatan / Unit Kerja</th>
					<th class="center middle bold" width="15%">Asal <br/>Kab / Kota</th>
					<th class="center middle bold last-col" width="20%">Tanda Tangan</th>
				</tr>
		<?php
			}
			else {
				
				$start_date = new DateTime($kegiatan["tgl_mulai_kegiatan"]);
				$end_date = new DateTime($kegiatan["tgl_selesai_kegiatan"]);
				$end_date->setTime(0,0,1);

				// Step 2: Defining the Date Interval
				$interval = new DateInterval('P1D');

				// Step 3: Creating the Date Range
				$date_range = new DatePeriod($start_date, $interval, $end_date);
				
				$date_sign = array();
				foreach($date_range as $date) {
					$dateFormated = $date->format('Y-m-d');
					$date_sign[] = $dateFormated;
				}

				if (!empty($kegiatan["detail_tgl_kegiatan"])) {
					$date_sign = $kegiatan["detail_tgl_kegiatan"];
				}
		?>
				<tr>
					<th class="center middle bold" rowspan="2" width="4%">No</th>
					<th class="center middle bold" rowspan="2" width="15%">Nama / NIP</th>
					<th class="center middle bold" rowspan="2" width="7%">Pangkat / Gol</th>
					<th class="center middle bold" rowspan="2" width="7%">Jabatan / Unit Kerja</th>
					<th class="center middle bold" rowspan="2" width="7%">Asal <br/>Kab / Kota</th>
					<th class="center middle bold last-col" colspan="<?php print count($date_sign); ?>">Tanda Tangan</th>
				</tr>
				<tr>
					<?php
						$i = 1;
						$countDay = count($date_sign);
						foreach ($date_sign as $date) {
							$class = "";

							if ($i == $countDay) {
								$class = "last-col";
							}
					?>
							<th class="center middle bold <?php print $class; ?>" style="white-space: nowrap;" width="10%"><?php print $this->utility->formatShortDateIndo($date); ?></th>
					<?php
							$i++;
						}
					?>
				</tr>
		<?php
			}
		?>
	</thead>
	<tbody>
		<?php
			$x = 1;
			foreach ($biodata as $bio) {
		?>
				<tr>
					<td align="center"><?php print $x; ?></td>
					<td>
						<div style="padding-left: 3px;"><?php print $bio["nama"]; ?></div>
						<?php
							if (!empty($bio["nip"]) && $bio["nip"] != "-") {
						?>
							<div style="padding-left: 3px;">NIP <?php print $bio["nip"]; ?></div>
						<?php
							} else {
						?>
							<div style="padding-left: 3px;">&nbsp;</div>
						<?php
							}
						?>
					</td>
					
					<?php
						$pangGol = $bio["pangkat"].", ".$bio["golongan"];

						if (empty($bio["pangkat"])) {
							$pangGol = "-";
						}
					?>
					<td align="center"><?php print $pangGol; ?></td>
					
					
					<td><?php print $bio["jabatan"]." ".$bio["unit_kerja"]; ?></td>
					<td><?php print $bio["kab_unit_kerja"]; ?></td>
					
					<?php
						if ($kegiatan["tgl_mulai_kegiatan"] == $kegiatan["tgl_selesai_kegiatan"]) {
					?>
						<td class="last-col" style="text-align: center; font-size: 30px; width: 150px;">
							<?php
								$dateChange = "2023-03-01";
								$dateKegitan = $kegiatan["tgl_mulai_kegiatan"];

								if (strtotime($dateKegitan) >= strtotime($dateChange)) {
									$ttd = "assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/ttd-".$bio["ktp"].".png";
								}
								else {
									$ttd = "assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/ttd-".$bio["kode"].".png";
								}

								if (!file_exists(APPPATH."../".$ttd)) {
									$ttd = "assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/ttd-".$bio["kode"].".png";
								}

								if ($showTtd) {
									if (file_exists(APPPATH."../".$ttd)) {
							?>
									<img src="<?php print base_url($ttd); ?>" height="30px" />
							<?php
									}
									else {
							?>
									<img src="<?php print $bio["tanda_tangan"]; ?>" height="30px" />
							<?php
									}
								}
							?>
						</td>
					<?php
						}
						else {
							$i = 1;
							$countDay = count($date_sign);
							foreach ($date_sign as $date) {
								$class = "";
								
								if ($i == $countDay) {
									$class = "last-col";
								}
					?>
								<td class="center middle <?php print $class; ?>" style="white-space: nowrap;" width="10%">
									<?php
										$dateChange = "2023-03-01";
										$dateKegitan = $kegiatan["tgl_mulai_kegiatan"];
										$ttd = "empty.png";

										if ($kegiatan["tipe_kegiatan"] == "Luring") {
											if (strtotime($dateKegitan) >= strtotime($dateChange)) {
												//$ttd = "assets/ttd/".$kegiatan["kode"]."/ttd-".$bio["ktp"].".png";
											}
											else {
												//$ttd = "assets/ttd/".$kegiatan["kode"]."/ttd-".$bio["kode"].".png";
											}
										}
										else {
											// Kegiatan Daring
											if (!empty($bio["daftar_hadir"])) {
												$isiDaftarHadir = json_decode($bio["daftar_hadir"], true);

												if (isset($isiDaftarHadir[$date]) && $isiDaftarHadir[$date] == 1) {
													$tglDaftarHadirPath = date("d_m_Y", strtotime($date));
													$ttd = "assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/".$tglDaftarHadirPath."/ttd-".$bio["ktp"].".png";
												}
											}
										}

										if ($showTtd) {
											if (file_exists(APPPATH."../".$ttd)) {
									?>
											<img src="<?php print base_url($ttd); ?>" height="40px" />
									<?php
											}
										}
									?>
								</td>
					<?php
								$i++;
							}
						}
					?>
				</tr>
		<?php
				$x++;
			}
		?>
	</tbody>
</table>
<table width="100%" style="font-family: 'timesnewromanxx'; font-size: 16px; vertical-align: top; page-break-inside: avoid;">
	<tbody>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php if (empty($kegiatan["kab_tempat_kegiatan"]) || $kegiatan["tipe_kegiatan"] == "Daring") {$tempat = $_ENV["DEFAULT_KABUPATEN"]; } else { $tempat = $kegiatan["kab_tempat_kegiatan"]; } print $tempat; ?>, <?php print $this->utility->formatDateIndo($kegiatan["tgl_selesai_kegiatan"]); ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 70%;">&nbsp;</td>
			<td>........................................</td>
		</tr>
	</tbody>
</table>