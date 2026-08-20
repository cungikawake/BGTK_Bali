<style>
	.biodata td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.biodata .dataField { width: 190px; padding-left: 16px; }
	.biodata .nomorRegistrasi { padding-left: 16px; }
	.biodata .wrapNomorRegistrasi { padding: 12px; border: 1px dotted #000; }
	
	<?php
		$showBankAkun = false;
		$showConfirmPaket = false;
		$showTtd = false;

		if (isset($options["form_show_bank"])) {
			$showBankAkun = $options["form_show_bank"];
		}

		if (isset($options["form_show_confirm_paket"])) {
			$showConfirmPaket = $options["form_show_confirm_paket"];
		}

		if (isset($options["form_ttd"])) {
			$showTtd = $options["form_ttd"];
		}
		
		if ($showBankAkun && $showConfirmPaket) {
			$dottedSpace = 'font-size: 5px;';
			$ttdSpace = 'font-size: 15px;';
			print '.biodata .dataFieldSpace {font-size: 3px;}; ';
		}
		else if ($showBankAkun && !$showConfirmPaket) {
			$dottedSpace = 'font-size: 10px;';
			print '.biodata .dataFieldSpace {font-size: 7px;}; ';
			$ttdSpace = 'font-size: 27px;';
		}
		else if (!$showBankAkun && $showConfirmPaket) {
			$dottedSpace = 'font-size: 14px;';
			print '.biodata .dataFieldSpace {font-size: 12px;}; ';
			$ttdSpace = 'font-size: 30px;';
		}
		else {
			$dottedSpace = 'font-size: 16px;';
			print '.biodata .dataFieldSpace {font-size: 16px;}; ';
			$ttdSpace = 'font-size: 40px;';
		}
	
		$typeTitle = $type;
	
		if ($type == "pengajar_praktek") {
			$typeTitle = "pengajar praktik";
		}
	
		$noUrut = $item["no_urut"];
	
		if (!empty($biodata["kode"])) {
			$nomorUrut = explode("-", $biodata["kode"]);
			
			if (!empty($nomorUrut)) {
				$nomorUrut = $nomorUrut[0];
				$noUrut = (int) $nomorUrut;	
			}
		}
	?>
</style>

<table class="biodata" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?php if (!empty($noUrut)) { ?>
				<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td align="right" style="font-size:7px;"><?php print $noUrut; ?></td>
						</tr>
					</tbody>
				</table>
			<?php } ?>

				<table width="100%" style="margin-bottom:15px;">
					<tbody>
						<tr>
							<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
						</tr>
					</tbody>
				</table>

				<table width="100%" style="font-family: 'timesnewromanxx';text-align: center;">
					<tbody>
						<tr>
							<td>
								<div style="font-size: 11px;">&nbsp;</div>
								<div style="font-size: 16px; font-weight: bold;">BIODATA <?php print strtoupper(str_replace("_"," ",$typeTitle)); ?></div>
								<div style="font-size: 6px;">&nbsp;</div>
							</td>	
						</tr>
					</tbody>
				</table>

				<table width="100%" style="font-family: 'timesnewromanxx'; font-size: 16px;">
					<tbody>
						<tr>
							<td style="width: 100px; font-weight: bold;">Kegiatan</td>
							<td style="width: 3px;">:</td>
							<td><?php print $kegiatan["nama"]; ?></td>
						</tr>
						<tr>
							<td style="font-weight: bold;">Hari, Tanggal</td>
							<td>:</td>
							<td><?php print $this->utility->formatRangeDay($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?>, <?php print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></td>
						</tr>

						<?php
							if ($kegiatan["tipe_kegiatan"] == "Daring") {
						?>
							<tr>
								<td style="font-weight: bold;">Zoom Id</td>
								<td>:</td>
								<td><?php print $kegiatan["zoom_id_kegiatan"]; ?></td>
							</tr>
						<?php
							}
							else {
								$distrik = "Kab. ";
								if ($kegiatan["kab_tempat_kegiatan"] == "Denpasar") {
									$distrik = "Kota ";
								}
						?>
							<tr>
								<td style="font-weight: bold;">Tempat</td>
								<td>:</td>
								<td><?php print $kegiatan["tempat_kegiatan"]." (".$distrik.$kegiatan["kab_tempat_kegiatan"].")"; ?><?php // print $biodata["kab_unit_kerja"]; ?></td>
							</tr>
						<?php
							}
						?>

					</tbody>
				</table>

				<table width="100%" style="font-family: 'timesnewromanxx';">
					<tbody>
						<tr>
							<td style="<?php print $dottedSpace; ?> border-bottom: 1px solid #000;">&nbsp;</td>
						</tr>
						<tr>
							<td style="<?php print $dottedSpace; ?>">&nbsp;</td>
						</tr>
					</tbody>
				</table>

				<table width="100%" style="font-family: 'timesnewromanxx'; font-size: 16px; vertical-align: top;">
					<tbody>
						<tr>
							<td colspan="3" style="font-weight: bold;">I. DATA DIRI</td>
						</tr>
						<tr>
							<td class="dataField">Nama</td>
							<td width="15">:</td>
							<td><?php print $biodata["nama"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">NIP</td>
							<td>:</td>
							<td><?php print $biodata["nip"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Jabatan</td>
							<td>:</td>
							<td><?php print $biodata["jabatan"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Pangkat, Golongan</td>
							<td>:</td>
							<td>
								<?php
									if (empty($biodata["pangkat"])) {
										print "-";
									}
									else {
										print $biodata["pangkat"]; ?>, <?php print $biodata["golongan"];
									}
								?>
							</td>
						</tr>
						<tr>
							<td class="dataField">Jenis Kelamin</td>
							<td>:</td>
							<td><?php print $biodata["jenis_kelamin"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Tempat, Tgl Lahir</td>
							<td>:</td>
							<td><?php print $biodata["tempat_lahir"]; ?>, <?php print $this->utility->formatDateIndo($biodata["tgl_lahir"]); ?></td>
						</tr>
						<tr>
							<td class="dataField">Status PTKP</td>
							<td>:</td>
							<td>
								<?php
									$ptkp = $this->config->item("status_ptkp");

									if (!empty($biodata["ptkp"])) {
										print $biodata["ptkp"]." - ".$ptkp[$biodata["ptkp"]];
									}
								?>
							</td>
						</tr>
						<tr>
							<td class="dataField">Telepon/HP</td>
							<td>:</td>
							<td><?php print $biodata["telp"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Email</td>
							<td>:</td>
							<td><?php print $biodata["email"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Alamat Rumah</td>
							<td>:</td>
							<td><?php print $biodata["alamat_tinggal"]; ?></td>
						</tr>


						<tr>
							<td colspan="3" class="dataFieldSpace">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" style="font-weight: bold;">II. UNIT KERJA</td>
						</tr>
						<tr>
							<td class="dataField">Nama Unit Kerja</td>
							<td>:</td>
							<td><?php print $biodata["unit_kerja"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Telp. Unit Kerja</td>
							<td>:</td>
							<td><?php print $biodata["telp_unit_kerja"]; ?></td>
						</tr>
						<tr>
							<td class="dataField">Alamat Unit Kerja</td>
							<td>:</td>
							<td><?php print $biodata["alamat_unit_kerja"]; ?> (<?php print $biodata["kab_unit_kerja"]; ?>)</td>
						</tr>

						<?php
							if ($showBankAkun) {
						?>
								<tr>
									<td colspan="3" class="dataFieldSpace">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3" style="font-weight: bold;">III. AKUN BANK</td>
								</tr>
								<tr>
									<td class="dataField">No Rekening</td>
									<td>:</td>
									<td><?php print $biodata["no_rekening"]; ?></td>
								</tr>
								<tr>
									<td class="dataField">Nama Pemilik Rekening</td>
									<td>:</td>
									<td><?php print $biodata["nama_pemilik_rekening"]; ?></td>
								</tr>
								<tr>
									<td class="dataField">Nama Bank</td>
									<td>:</td>
									<td><?php print $biodata["nama_bank"]; ?></td>
								</tr>
						<?php
							}
						?>


						<?php
							/*if ($showConfirmPaket) {
								if ($biodata["konfirmasi_paket"]) {
						?>
								<tr>
									<td colspan="3" class="dataFieldSpace">&nbsp;</td>
								</tr>
								<tr>
									<td class="dataField" colspan="3">Saya menyatakan bahwa benar, saya <strong>belum</strong> menerima biaya paket data atau biaya komunikasi dari pemerintah pada bulan ini.</td>
								</tr>
						<?php
								}
								else {
						?>
								<tr>
									<td colspan="3" class="dataFieldSpace">&nbsp;</td>
								</tr>
								<tr>
									<td class="dataField" colspan="3">Saya menyatakan bahwa benar, saya <strong>sudah</strong> menerima biaya paket data atau biaya komunikasi dari pemerintah pada bulan ini.</td>
								</tr>
						<?php
								}

							}*/
						?>
					</tbody>
				</table>

				<table width="100%" style="font-family: 'timesnewromanxx'; font-size: 16px; vertical-align: top;">
					<tbody>
						<tr>
							<td colspan="2" style="<?php print $ttdSpace; ?>">&nbsp;</td>
						</tr>
						<tr>
							<td class="nomorRegistrasi">
								<table style="border: dotted 1px #ccc; text-align: center; color: #ccc;">
									<tbody>
										<tr>
											<td style="padding: 20px 25px 0; font-size: 14px;">Nomor Registrasi:</td>
										</tr>
										<tr>
											<td style="padding: 0 25px 20px; font-size: 20px; font-weight: bold;"><?php print $biodata["kode"]; ?></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td>
								<?php
									$kota = $_ENV["DEFAULT_KABUPATEN"];
									if (!empty($kegiatan["kab_tempat_kegiatan"])) {
										$kota = $kegiatan["kab_tempat_kegiatan"];
									}
								?>
								<?php print $kota; ?>, <?php print $this->utility->formatDateIndo($kegiatan["tgl_mulai_kegiatan"]); ?><br />

								<?php
									$ttd = "assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/ttd-".$biodata["kode"].".png";
									$ttd2 = "assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/ttd-".$biodata["ktp"].".png";

									if (file_exists(APPPATH."../".$ttd) && $showTtd) {
								?>
									<img src="<?php print base_url($ttd); ?>" height="70px" />
								<?php
									}
									else if (file_exists(APPPATH."../".$ttd2) && $showTtd) {
								?>
									<img src="<?php print base_url($ttd2); ?>" height="70px" />
								<?php
									}
								?>
							</td>
						</tr>
						<tr>
							<td style="width: 55%;">&nbsp;</td>
							<td><?php print $biodata["nama"]; ?></td>
						</tr>
						<?php
							if (!empty(trim($biodata["nip"])) || $biodata["nip"] != '') {
						?>
								<tr>
									<td>&nbsp;</td>
									<td>NIP <?php print $biodata["nip"]; ?></td>
								</tr>
						<?php
							}
						?>

					</tbody>
				</table>
		</td>
	</tr>
</table>