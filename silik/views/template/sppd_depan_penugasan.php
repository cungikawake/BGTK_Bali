<style type="text/css">
	.sppd-depan td { vertical-align:top; font-size:12px; font-family: 'tahoma'; line-height: normal;}
	.sppd-depan .center { text-align:center; }
	.sppd-depan .font16 { font-size:16px; }
	.sppd-depan .bold { font-weight:bold; }
	.sppd-depan .bordered { border-top:1px solid #000; border-left:1px solid #000; }
	.sppd-depan .bordered td { border-bottom:1px solid #000; border-right:1px solid #000; padding:4px 6px;}
	.sppd-depan .middle { vertical-align:middle; }
	.sppd-depan .font4 { font-size:4px;}
	.sppd-depan.preview {
		background: url('<?php print base_url('assets/images/red-preview.jpg'); ?>');
	}
</style>
<?php
	$preview = "preview";
	if (isset($spj_item)) {
		$preview = "";
	}
?>
<table class="sppd-depan <?php print $preview; ?>" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:7px;"><?php print isset($spj_item["no_urut"]) ? $spj_item["no_urut"] : ""; ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:15px;margin-left:-10px;margin-right:-10px;">
				<tbody>
					<tr>
						<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
					</tr>
				</tbody>
			</table>

			<table width="100%" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="62%">
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td>Kementerian Negara / Lembaga</td>
								</tr>
								<tr>
									<td>Pendidikan Dasar Dan Menengah</td>
								</tr>
							</table>
						</td>
						<td width="38%">
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="26%">Lembar Ke</td>
									<td>: 1</td>
								</tr>
								<tr>
									<td width="26%">Kode No.</td>
									<td>:</td>
								</tr>
								<tr>
									<td width="26%">Nomor</td>
									<td>: <?php print $item["no_spd"]; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>

			<table width="100%" style="margin-bottom:10px;">
				<tr>
					<td class="center font16 bold">SURAT PERJALANAN DINAS (SPD)</td>
				</tr>
			</table>

			<table width="100%" class="bordered" cellpadding="0" cellspacing="0">
				<tr>
					<td class="center middle" width="5%">1</td>
					<td class="middle" width="42%">Pejabat Pembuat Komitmen / NIP</td>
					<td>
						<div><?php print $ppk["nama"]; ?></div>
						<div>NIP <?php print $ppk["nip"]; ?></div>
					</td>
				</tr>
				<tr>
					<td class="center middle">2</td>
					<td class="middle">Nama / NIP Pegawai yang diberi perintah</td>
					<td>
						<div><?php print $item["nama"]; ?></div>
						<div>
							<?php
								if (!empty($item["nip"]) && $item["nip"] != "-") {
									print "NIP ".$item["nip"];
								}
								else {
									print "-";
								}
							?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="center">3</td>
					<td class="middle">
						<div>a. Pangkat dan golongan</div>
						<div>b. Jabatan / Instansi</div>
						<div>c. Tingkat biaya perjalanan dinas</div>
					</td>
					<td>
						<div>a. <?php print $item["pangkat"]; ?><?php if (!empty($item["golongan"])) { print ", ".$item["golongan"];} ?></div>
						<div>b. <?php print $item["jabatan"]." ".$item["unit_kerja"] ?></div>
						<div>c. C</div>
					</td>
				</tr>
				<tr>
					<td class="center">4</td>
					<td>Maksud perjalanan dinas</td>
					<td style="word-wrap:break-word;"><?php print $penugasan["nama"]." sesuai Surat Tugas No. ".$penugasan["nomor_surat"]." tgl ".$this->utility->formatDateIndo($penugasan["tgl_surat"]); ?></td>
				</tr>
				<tr>
					<td class="center middle">5</td>
					<td class="middle">Alat angkut yang dipergunakan</td>
					<td>
						<?php 
							if ($item["provinsi_tujuan"] == $_ENV['DEFAULT_PROVINSI']) {
								$transDarat = $this->config->item('transport_darat');
								$transLaut = $this->config->item('transport_laut');

								$trans = "Darat";

								$lewatLaut = 0;

								if (!empty($transLaut)) {
									foreach ($transLaut as $laut) {
										if ($item["kab_tujuan"] == $laut) {
											$lewatLaut = 1;
										}
									}
								}

								if ($lewatLaut) {
									$trans = "Darat & laut";
								}
								else {
									$lewatDarat = 0;

									if (!empty($transDarat)) {
										foreach ($transDarat as $darat) {
											if ($item["kab_tujuan"] == $darat) {
												$lewatDarat = 1;
											}
										}
									}

									if (!$lewatDarat) {
										$trans = "Darat & udara";
									}
								}

								print $trans;
							}
							else {
								print "Darat & udara";
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="center">6</td>
					<td class="middle">
						<div>a. Tempat berangkat</div>
						<div>b. Tempat tujuan</div>
					</td>
					<td>
						<div>a. <?php print $item["kab_asal"]; ?></div>
						<div>b. <?php print $item["kab_tujuan"]; ?></div>
					</td>
				</tr>
				<tr>
					<td class="center">7</td>
					<td class="middle">
						<div>a. Lamanya perjalanan dinas</div>
						<div>b. Tanggal berangkat</div>
						<div>c. Tanggal harus kembali/ tiba di tempat baru *)</div>
					</td>
					<?php
						$diff = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
					?>
					<td>
						<div>a. <?php print $diff; ?> hari</div>
						<div>b. <?php print $this->utility->formatDateIndo($item["tgl_mulai_tugas"]); ?></div>
						<div>c. <?php print $this->utility->formatDateIndo($item["tgl_selesai_tugas"]); ?></div>
					</td>
				</tr>
				<tr>
					<td class="center">8</td>
					<td class="middle">
						<div>Pengikut: &nbsp;&nbsp;&nbsp; Nama</div>
						<div>1. </div>
						<div>2. </div>
						<div>3. </div>
					</td>
					<td style="padding:0;">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td>Tanggal lahir</td>
								<td style="border-right:none;">Keterangan</td>
							</tr>
							<tr>
								<td style="border-bottom:none;">
									<div>&nbsp;</div>
									<div>&nbsp;</div>
									<div>&nbsp;</div>
								</td>
								<td style="border-right:none; border-bottom:none;">
									<div>&nbsp;</div>
									<div>&nbsp;</div>
									<div>&nbsp;</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="center">9</td>
					<td class="middle">
						<div>Pembebanan anggaran</div>
						<div>a. Instansi</div>
						<div>b. Mata anggaran</div>
					</td>
					<td>
						<div>&nbsp;</div>
						<div>a. <?php print $_ENV['INSTANSI_DIPA_NAME']; ?></div>
						<div>b. <?php print $item["dipa_mak"]; ?></div>
					</td>
				</tr>
				<tr>
					<td class="center">10</td>
					<td class="middle">Keterangan lain-lain</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:4px;">
				<tr>
					<td class="center middle" width="5%">&nbsp;</td>
					<td class="middle" width="40%">*) coret yang tidak perlu</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<table width="100%" cellpadding="1" cellspacing="0" style="margin-top:10px;">
				<tr>
					<td width="71%">&nbsp;</td>
					<td>Dikeluarkan di : <?php print $_ENV['DEFAULT_KABUPATEN']; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tanggal : <?php print $this->utility->formatDateIndo($penugasan["tgl_surat"]); ?></td>
				</tr>
				<tr>
					<td rowspan="7">
						<?php
							if (isset($validasi)) {
								print '<img class="qr-code" src="'.$validasi["spd_depan"].'" />';
							}
							else {
								print '&nbsp;';
							}
						?>
					</td>
					<td>Pejabat Pembuat Komitmen</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td class="bold"><?php print $ppk["nama"]; ?></td>
				</tr>
				<tr>
					<td>NIP <?php print $ppk["nip"]; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>