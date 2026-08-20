<style type="text/css">
	.rpd td { vertical-align:top; font-size:12px; font-family: 'tahoma'; line-height: normal; }
	.rpd .center { text-align:center; }
	.rpd .font16 { font-size:15px; }
	.rpd .bold { font-weight:bold; }
	.rpd .underline { text-decoration: underline; }
	.rpd .bordered { border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; }
	.rpd .bordered td { border-right:1px solid #000; padding:3px 6px;}
	.rpd .middle { vertical-align:middle; }
	.rpd .font4 { font-size:4px;}
	.rpd .kuitansi { border:2px solid #000; font-size:14px; padding:3px 20px; font-weight:bold; }
	.rpd .justify {text-align:justify; }
	.rpd .font8 { font-size:8px; }
	.rpd .font7 { font-size:7px; }
	.rpd .font6 { font-size:6px; }
	.rpd .text-right { text-align:right; display:block; }
	.rpd .bb { border-bottom:2px solid #000; }
	.rpd .bt { border-top:2px solid #000; }
	.rpd .bt-normal { border-top:1px solid #000; }
	.rpd .nobr {border-right: none; }
</style>

<?php
	if (!empty($spj_item["tgl_tugas"])) {
		$lamaTugas = count($spj_item["tgl_tugas"]);
	}
	else {
		$lamaTugas = $this->utility->lama_tugas($spj_item["tgl_mulai_tugas"], $spj_item["tgl_selesai_tugas"]);
	}
?>

<table class="rpd" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:9px;"><?php print $spj_item["no_urut"]; ?></td>
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

			<table width="100%" style="margin-bottom:15px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td class="font16 center bold underline">RINCIAN BIAYA PERJALANAN DINAS</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
				<tbody>
					<tr>
						<td width="24%">Lampiran SPD Nomor</td>
						<td>: <?php print $spj_item["no_spd"]; ?></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td>: <?php print $this->utility->formatDateIndo($spj_item["tgl_surat"]); ?></td>
					</tr>
				</tbody>
			</table>
			
			<table width="100%" class="bordered" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="5%" class="bold bb">No</td>
						<td class="bold center bb" colspan="2">Perincian Biaya</td>
						<td class="bold bb center">Jumlah</td>
						<td width="22%" class="bold bb center">Keterangan</td>
					</tr>
					<tr>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;" class="nobr">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
					</tr>
					
					<?php
						$i = 0;
						$total = 0;	
					
						if (!empty($spj_item["pesawat_berangkat"]) || !empty($spj_item["pesawat_pulang"])) {
							$i++;
							
							$total += $spj_item["pesawat_berangkat"] + $spj_item["pesawat_pulang"];

							$provAsal = $spj_item["provinsi_asal"];
							$provTujuan = $spj_item["provinsi_tujuan"];

							if ($spj_item["provinsi_asal"] == $spj_item["provinsi_tujuan"]) {
								$provAsal = $spj_item["kab_asal"];
								$provTujuan = $spj_item["kab_tujuan"];
							}
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td class="nobr">
									<div>Tiket Pesawat (PP):</div>
								</td>
								<td>
									<?php if (!empty($spj_item["pesawat_berangkat"])) { ?>
									<div><?php print $provAsal; ?> - <?php print $provTujuan; ?></div>
									<?php } ?>
									<?php if (!empty($spj_item["pesawat_pulang"])) { ?>
									<div><?php print $provTujuan; ?> - <?php print $provAsal; ?></div>
									<?php } ?>
								</td>
								<td align="right">
									<?php if (!empty($spj_item["pesawat_berangkat"])) { ?>
									<div class="text-right"><?php print $this->utility->format_money($spj_item["pesawat_berangkat"]); ?></div>
									<?php } ?>
									<?php if (!empty($spj_item["pesawat_pulang"])) { ?>
									<div class="text-right"><?php print $this->utility->format_money($spj_item["pesawat_pulang"]); ?></div>
									<?php } ?>
								</td>
								<td>
									<?php if (!empty($spj_item["pesawat_berangkat"])) { ?>
									<div>&nbsp;</div>
									<?php } ?>
									<?php if (!empty($spj_item["pesawat_pulang"])) { ?>
									<div>&nbsp;</div>
									<?php } ?>
								</td>
							</tr>
					<?php
						}
					?>
					
					<?php
						if (!empty($spj_item["taksi_berangkat"]) || !empty($spj_item["taksi_pulang"])) {
							$i++;
							
							$total += $spj_item["taksi_berangkat"] + $spj_item["taksi_pulang"];
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td colspan="2">
									<?php if (!empty($spj_item["taksi_berangkat"])) { ?>
									<div>Taksi <?php print $spj_item["provinsi_asal"]; ?></div>
									<?php } ?>
									<?php if (!empty($spj_item["taksi_pulang"])) { ?>
									<div>Taksi <?php print $spj_item["provinsi_tujuan"]; ?></div>
									<?php } ?>
								</td>
								<td align="right">
									<?php if (!empty($spj_item["taksi_berangkat"])) { ?>
									<div class="text-right"><?php print $this->utility->format_money($spj_item["taksi_berangkat"]); ?></div>
									<?php } ?>
									<?php if (!empty($spj_item["taksi_pulang"])) { ?>
									<div class="text-right"><?php print $this->utility->format_money($spj_item["taksi_pulang"]); ?></div>
									<?php } ?>
								</td>
								<td>
									<?php if (!empty($spj_item["taksi_berangkat"])) { ?>
									<div>&nbsp;</div>
									<?php } ?>
									<?php if (!empty($spj_item["taksi_pulang"])) { ?>
									<div>&nbsp;</div>
									<?php } ?>
								</td>
							</tr>
					<?php
						}
					?>
					
					<?php
						
						if (!empty($spj_item["transport"]) || !empty($spj_item["transport_lainnya"])) {
							$i++;
							
							if (!empty($spj_item["tgl_tugas"])) {
								$total += $spj_item["transport"] * $lamaTugas;
							}
							else {
								$total += $spj_item["transport"];
							}
							
							$total += $spj_item["transport_lainnya"];
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td class="nobr">
									<div>Transport:</div>
									<?php if (!empty($spj_item["transport"])) { ?>
										<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transport Lokal (PP)</div>
									<?php } ?>
									
									<?php if (!empty($spj_item["tgl_tugas"])) { ?>
										<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
									<?php } ?>
									
									<?php if (!empty($spj_item["transport_lainnya"])) { ?>
										<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transport Lainnya</div>
									<?php } ?>
								</td>
								<td>
									<div>&nbsp;&nbsp;</div>
									<?php if (!empty($spj_item["transport"])) { ?>
										<div><?php print $spj_item["kab_asal"]; ?> - <?php print $spj_item["kab_tujuan"]; ?></div>
									<?php } ?>
									
									<?php if (!empty($spj_item["tgl_tugas"])) { ?>
										<?php print $this->utility->format_money($spj_item["transport"]); ?> &nbsp;x&nbsp; <?php print $lamaTugas; ?> Kali
									<?php } ?>
									
									<?php if (!empty($spj_item["transport_lainnya"])) { ?>
										<div>&nbsp;</div>
									<?php } ?>
								</td>
								<td align="right">
									<div>&nbsp;</div>
									<?php if (empty($spj_item["tgl_tugas"]) && !empty($spj_item["transport"])) { ?>
										<div class="text-right"><?php print $this->utility->format_money($spj_item["transport"]); ?></div>
									<?php } ?>
									
									<?php if (!empty($spj_item["tgl_tugas"])) { ?>
										<?php "<div>".print $this->utility->format_money($spj_item["transport"] * $lamaTugas)."</div><div>&nbsp;</div>"; ?>
									<?php } ?>
									
									<?php if (!empty($spj_item["transport_lainnya"])) { ?>
										<div class="text-right"><?php print $this->utility->format_money($spj_item["transport_lainnya"]); ?></div>
									<?php } ?>
								</td>
								<td>
									<div>&nbsp;</div>
									<?php if (!empty($spj_item["transport"])) { ?>
										<div><?php if (empty($spj_item["tgl_tugas"]) && !empty($spj_item["keterangan_transport"])) { print $spj_item["keterangan_transport"];} ?></div>
									<?php } ?>
									
									<?php if (!empty($spj_item["transport"]) && !empty($spj_item["tgl_tugas"])) { ?>
										<div><?php if (!empty($spj_item["keterangan_transport"])) { print $spj_item["keterangan_transport"];} else { print "&nbsp;"; } ?></div>
										<div>&nbsp;</div>
									<?php } ?>
									
									<?php if (!empty($spj_item["transport_lainnya"])) { ?>
										<div><?php if (!empty($spj_item["keterangan_transport_lainnya"])) { print $spj_item["keterangan_transport_lainnya"];} else { print "&nbsp;"; } ?></div>
									<?php } ?>
								</td>
							</tr>
					<?php
						}
					?>

					<?php
						if (!empty($spj_item["uang_harian"])) {
							$i++;
							
							$total += $spj_item["uang_harian"]*$lamaTugas;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td class="nobr">Uang Harian</td>
								<td><?php print $this->utility->format_money($spj_item["uang_harian"]); ?> &nbsp;x&nbsp; <?php print $lamaTugas; ?> Hari</td>
								<td align="right"><?php print $this->utility->format_money(($spj_item["uang_harian"]*$lamaTugas)); ?></td>
								<td><?php print $spj_item["keterangan_uang_harian"]; ?></td>
							</tr>
					<?php
						}
					?>
					
					<?php
						$lamaNginap = $this->utility->lama_tugas($spj_item["tgl_mulai_tugas"], $spj_item["tgl_selesai_tugas"]) - 1;
					
						if (!empty($spj_item["penginapan"]) && !empty($lamaNginap)) {
							$i++;
							
							$total += $spj_item["penginapan"] * $lamaNginap;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td class="nobr">Penginapan</td>
								<td><?php print $this->utility->format_money($spj_item["penginapan"]); ?> &nbsp;x&nbsp; <?php print $lamaTugas - 1; ?> Malam</td>
								<td align="right"><?php print $this->utility->format_money(($spj_item["penginapan"] * $lamaNginap)); ?></td>
								<td><?php print $spj_item["keterangan_penginapan"]; ?></td>
							</tr>
					<?php
						}
					?>
					
					<tr>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;" class="nobr">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
					</tr>
					<tr>
						<td class="bold bt" colspan="3">Jumlah</td>
						<td class="bold bt" align="right"><?php print $this->utility->format_money($total); ?></td>
						<td class="bt">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5" class="bt-normal">Terbilang : <em><?php print $this->utility->terbilang($total); ?></em></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" class="bb" style="padding-bottom:15px; margin-bottom: 15px;">
				<tbody>
					<tr>
						<td width="6%">&nbsp;</td>
						<td width="54%">&nbsp;</td>
						<td width="40%"><?php print $spj_item["kab_kuitansi"]; ?>, <?php print $this->utility->formatDateIndo($spj_item["tgl_kuitansi"]); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Dibayarkan sejumlah</td>
						<td>Telah menerima jumlah uang sebesar</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><?php print $this->utility->format_money($total); ?></td>
						<td><?php print $this->utility->format_money($total); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Bendahara Pengeluaran,</td>
						<td>Yang menerima,</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<div style="font-weight: bold"><?php print $spj_item["nama_bp"]; ?></div>
							NIP <?php print $spj_item["nip_bp"]; ?>
						</td>
						<td>
							<div style="font-weight: bold"><?php print $spj_item["nama"]; ?></div>
							<?php if(!empty($spj_item["nip"]) && $spj_item["nip"] != "-" && $spj_item["nip"] != "0") { print "NIP ".$spj_item["nip"]; } ?>
						</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="1" cellspacing="0" style="margin-bottom: 15px;">
				<tbody>
					<tr>
						<td class="center bold">PERHITUNGAN SPD RAMPUNG</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="1" cellspacing="0" style="margin-bottom: 35px;">
				<tbody>
					<tr>
						<td width="27%">&nbsp;</td>
						<td width="46%">
							<table cellpadding="0" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td width="50%">Ditetapkan sejumlah</td>
									<td width="4%">:</td>
									<td width="42%" align="right"><?php print $this->utility->format_money($total); ?></td>
									<td width="4%">&nbsp;</td>
								</tr>
								<tr>
									<td>Yang telah dibayar semula</td>
									<td>:</td>
									<td align="right"><?php print $this->utility->format_money($total); ?></td>
									<td>&nbsp;_</td>
								</tr>
								<tr>
									<td>Sisa kurang/lebih</td>
									<td>:</td>
									<td align="right" class="bt-normal">Rp. 0</td>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
						<td width="27%">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="69.6%">&nbsp;</td>
						<td width="30.4%">Mengetahui/Menyetujui</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>a.n Kuasa Pengguna Anggaran</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Pejabat Pembuat Komitmen,</td>
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
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="bold"><?php print $spj_item["nama_ppk"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>NIP <?php print $spj_item["nip_ppk"]; ?></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>