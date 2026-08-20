<style type="text/css">
	.amplop-css td { vertical-align:top; font-size:12px; font-family: 'tahoma'; line-height: normal; }
	.amplop-css .center { text-align:center; }
	.amplop-css .font16 { font-size:15px; }
	.amplop-css .bold { font-weight:bold; }
	.amplop-css .underline { text-decoration: underline; }
	.amplop-css .bordered { border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; }
	.amplop-css .bordered td { border-right:1px solid #000; padding:2px 6px;}
	.amplop-css .middle { vertical-align:middle; }
	.amplop-css .font4 { font-size:4px;}
	.amplop-css .kuitansi { border:2px solid #000; font-size:14px; padding:3px 20px; font-weight:bold; }
	.amplop-css .justify {text-align:justify; }
	.amplop-css .font8 { font-size:8px; }
	.amplop-css .font7 { font-size:7px; }
	.amplop-css .font6 { font-size:6px; }
	.amplop-css .text-right { text-align:right; display:block; }
	.amplop-css .bb { border-bottom:2px solid #000; }
	.amplop-css .bt { border-top:2px solid #000; }
	.amplop-css .bt-normal { border-top:1px solid #000; }
	.amplop-css .nobr {border-right: none; }
</style>

<?php
	if (!empty($spj_item["tgl_tugas"])) {
		$lamaTugas = count($spj_item["tgl_tugas"]);
	}
	else {
		$lamaTugas = $this->utility->lama_tugas($spj_item["tgl_mulai_tugas"], $spj_item["tgl_selesai_tugas"]);
	}
?>

<table class="amplop-css" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="3%" class="font16 bold"><?php print $spj_item["no_urut"]."."; ?></td>
					<td class="font16 bold"><?php print $spj_item["nama"]; ?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><?php print $spj["nama"]; ?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
			<table width="80%" class="bordered" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="5%" class="bold bb">No</td>
						<td class="bold center bb" colspan="2">Perincian Biaya</td>
						<td class="bold bb center">Jumlah</td>
					</tr>
					<tr>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;" class="nobr">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
					</tr>
					
					<?php
						$i = 0;
						$total = 0;	
					
						if (!empty($spj_item["pesawat_berangkat"]) || !empty($spj_item["pesawat_pulang"])) {
							$i++;
							
							$total += $spj_item["pesawat_berangkat"] + $spj_item["pesawat_pulang"];
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td class="nobr">
									<div>Tiket Pesawat (PP):</div>
								</td>
								<td>
									<?php if (!empty($spj_item["pesawat_berangkat"])) { ?>
									<div><?php print $spj_item["provinsi_asal"]; ?> - <?php print $spj_item["provinsi_tujuan"]; ?></div>
									<?php } ?>
									<?php if (!empty($spj_item["pesawat_pulang"])) { ?>
									<div><?php print $spj_item["provinsi_tujuan"]; ?> - <?php print $spj_item["provinsi_asal"]; ?></div>
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
							</tr>
					<?php
						}
					?>
					
					<tr>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;" class="nobr">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
						<td style="font-size: 4px;">&nbsp;</td>
					</tr>
					<tr>
						<td class="bold bt" colspan="3">Jumlah</td>
						<td class="bold bt" align="right"><?php print $this->utility->format_money($total); ?></td>
					</tr>
					<tr>
						<td colspan="4" class="bt-normal">Terbilang : <em><?php print $this->utility->terbilang($total); ?></em></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>