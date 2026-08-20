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
						<td align="right" style="font-size:7px;"><?php print $spj_item["no_urut"]; ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:15px;">
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
									<td>Pendidikan Dasar dan Menengah</td>
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
									<td>: <?php if (isset($spj_item["no_kode"]) && !empty($spj_item["no_kode"])) { print $spj_item["no_kode"]; } ?></td>
								</tr>
								<tr>
									<td width="26%">Nomor</td>
									<td>: <?php print $spj_item["no_spd"]; ?></td>
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
						<div><?php print $spj_item["nama_ppk"]; ?></div>
						<div>NIP <?php print $spj_item["nip_ppk"]; ?></div>
					</td>
				</tr>
				<tr>
					<td class="center middle">2</td>
					<td class="middle">Nama / NIP Pegawai yang diberi perintah</td>
					<td>
						<div><?php print $spj_item["nama"]; ?></div>
						<div>
							<?php
								if (!empty($spj_item["nip"]) && $spj_item["nip"] != "-") {
									print "NIP ".$spj_item["nip"];
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
						<div>a. <?php print $spj_item["pangkat"]; ?><?php if (!empty($spj_item["golongan"])) { print ", ".$spj_item["golongan"];} ?></div>
						<div>b. <?php print $spj_item["jabatan"]." ".$spj_item["unit_kerja"]; ?></div>
						<div>c. C</div>
					</td>
				</tr>
				<?php
					$tempatTugas = "";
					
					if(isset($spj_item["tempat_tugas"]) && !empty($spj_item["tempat_tugas"])){
						$tempatTugas = " di ".$spj_item["tempat_tugas"];
					}
				?>
				<tr>
					<td class="center">4</td>
					<td>Maksud perjalanan dinas</td>
					<td style="word-wrap:break-word;">Kegiatan <?php print $spj["nama"].$tempatTugas." sesuai ".$spj_item["jenis_surat"]." No. ".$spj_item["nomor_surat"]." tgl ".$this->utility->formatDateIndo($spj_item["tgl_surat"]); ?></td>
				</tr>
				<tr>
					<td class="center middle">5</td>
					<td class="middle">Alat angkut yang dipergunakan</td>
					<td><?php if ($spj_item["provinsi_asal"] != $spj_item["provinsi_tujuan"]) { print "Darat & Udara"; } else { print "Darat"; } ?></td>
				</tr>
				<tr>
					<td class="center">6</td>
					<td class="middle">
						<div>a. Tempat berangkat</div>
						<div>b. Tempat tujuan</div>
					</td>
					<td>
						<?php if ($spj_item["provinsi_asal"] != $spj_item["provinsi_tujuan"]) { ?>
							<div>a. <?php print $spj_item["provinsi_asal"]; ?><?php print " ( ".$spj_item["kab_asal"]." )"; ?></div>
							<div>b. <?php print $spj_item["provinsi_tujuan"]; ?><?php print " ( ".$spj_item["kab_tujuan"]." )"; ?></div>
						<?php } else { ?>
							<div>a. <?php print $spj_item["kab_asal"]; ?></div>
							<div>b. <?php print $spj_item["kab_tujuan"]; ?></div>
						<?php } ?>
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
						$diff = $this->utility->lama_tugas($spj_item["tgl_mulai_tugas"], $spj_item["tgl_selesai_tugas"]);
					?>
					<td>
						<div>a. <?php print $diff; ?> hari</div>
						<div>b. <?php print $this->utility->formatDateIndo($spj_item["tgl_mulai_tugas"]); ?></div>
						<div>c. <?php print $this->utility->formatDateIndo($spj_item["tgl_selesai_tugas"]); ?></div>
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
						<div>a. <?php print $satker["upt"]; ?></div>
						<div>b. <?php print $spj_item["dipa_program"]." / ".$spj_item["dipa_kegiatan"].".".$spj_item["dipa_kro"].".".$spj_item["dipa_ro"].".".$spj_item["dipa_komponen"].".".$spj_item["dipa_sub_komponen"].".".$spj_item["dipa_akun_transport"]; ?></div>
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
					<td>Dikeluarkan di : <?php print $_ENV["DEFAULT_KABUPATEN"]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tanggal : <?php print $this->utility->formatDateIndo($spj_item["tgl_surat"]); ?></td>
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
					<td class="bold"><?php print $spj_item["nama_ppk"]; ?></td>
				</tr>
				<tr>
					<td>NIP <?php print $spj_item["nip_ppk"]; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>