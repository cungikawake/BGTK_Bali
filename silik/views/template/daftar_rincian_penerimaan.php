<style type="text/css">
	.drp td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.drp .center { text-align:center; }
	.drp .font16 { font-size:16px; }
	.drp .bold { font-weight:bold; }
	.drp.bordered { border-left:1px solid #000; border-top:1px solid #000; }
	.drp.bordered td { border-right:1px solid #000; border-bottom:1px solid #000; padding:6px 6px;}
	.drp .middle { vertical-align:middle; }
	.drp .bottom { vertical-align:bottom; }
	.drp .font4 { font-size:4px;}
	.drp .kuitansi { border:2px solid #000; font-size:16px; padding:4px 20px; font-weight:bold; }
	.drp .justify {text-align:justify; }
	.drp .font8 { font-size:8px; }
	.drp .font7 { font-size:7px; }
	.drp .font6 { font-size:6px; }
	.drp .text-right { text-align:right; display:block; }
	.drp .bb { border-bottom:2px solid #000; }
	.drp .bt { border-top:2px solid #000; }
	.drp .bt-normal { border-top:1px solid #000; }
	.drp .paddingTB td {padding: 2px 0; }
	.drp .middle { vertical-align: middle; }
	.drp .paadingTB2 {padding-top: 4px; padding-bottom: 4px; line-height: 24px; }
	.drp .nowrap {white-space: nowrap; }
</style>

<table width="100%" class="drp" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td width="18%">&nbsp;</td>
			<td>
				<table width="100%" style="margin-left:-10px;margin-right:-10px;">
					<tbody>
						<tr>
							<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
						</tr>
					</tbody>
				</table>
			</td>
			<td width="18%">&nbsp;</td>
		</tr>
	</tbody>
</table>

<?php
	$showTiket = false;
	$showTaksi = false;
	$showTransportLokal = false;
	$showTransLainnya = false;
	$showUangHarian = false;
	$showPenginapan = false;

	if (!empty($items)) {
		foreach ($items as $item) {
			if (!empty($item["pesawat_berangkat"]) || !empty($item["pesawat_pulang"])) {
				$showTiket = true;
			}

			if (!empty($item["taksi_berangkat"]) || !empty($item["taksi_pulang"])) {
				$showTaksi = true;
			}

			if (!empty($item["transport"])) {
				$showTransportLokal = true;
			}

			if (!empty($item["transport_lainnya"])) {
				$showTransLainnya = true;
			}

			$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);

			if (!empty($item["uang_harian"]) && $lamaTugas > 0) {
				$showUangHarian = true;
			}

			$lamaNginap = $lamaTugas - 1;

			if (!empty($item["penginapan"]) && $lamaNginap > 0) {
				$showPenginapan = true;
			}
		}
	}

	$noWidth = "4%";
	$namaWidth = "16%";
	$jabatanWidth = "14%";
	$kabWidth = "7%";
	$hariWidth = "4%";
	$tglWidth = "7%";

	if (!$showTiket && !$showTaksi && !$showPenginapan) {
		$noWidth = "4%";
		$namaWidth = "20%";
		$jabatanWidth = "15%";
		$kabWidth = "8%";
		$hariWidth = "4%";
		$tglWidth = "10%";
	}

	if (!$showTiket && !$showTaksi && !$showTransLainnya && !$showPenginapan) {
		$noWidth = "4%";
		$namaWidth = "22%";
		$jabatanWidth = "18%";
		$kabWidth = "11%";
		$hariWidth = "4%";
		$tglWidth = "12%";
	}

	if (!$showTiket && !$showTaksi && !$showTransLainnya && !$showUangHarian && !$showPenginapan) {
		$noWidth = "4%";
		$namaWidth = "22%";
		$jabatanWidth = "20%";
		$kabWidth = "11%";
		$hariWidth = "4%";
		$tglWidth = "12%";
	}
?>

<table class="drp" width="100%" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td class="font16 bold center" colspan="3">
				DAFTAR RINCIAN PENERIMAAN TRANSPORT 
				<?php
					if ($showUangHarian) {
						print " & UANG HARIAN ";
					}
				?>
				<?php print strtoupper(str_replace(array("_","praktek"),array(" ","praktik"),$spj["komponen"])); ?></td>
		</tr>
		<tr>
			<td width="8%">&nbsp;</td>
			<td class="font16 bold center">Kegiatan <?php print $spj["nama"]; ?></td>
			<td width="8%">&nbsp;</td>
		</tr>
	</tbody>
</table>

<table class="drp bordered" cellpadding="0" cellspacing="0" width="100%" style="page-break-inside: always; margin-bottom: 5px;">
	<thead>
		<tr>
			<td class="center middle bold" width="<?php print $noWidth; ?>">No</td>
			<td class="center middle bold" width="<?php print $namaWidth; ?>">Nama / NIP</td>
			<td class="center middle bold" width="<?php print $jabatanWidth; ?>">Jabatan/Unit Kerja</td>
			<td class="center middle bold" width="<?php print $kabWidth; ?>">Kab/Kota Asal - Tujuan</td>
			<td class="center middle bold" width="<?php print $hariWidth; ?>">Hari</td>
			<td class="center middle bold" width="<?php print $tglWidth; ?>">Tanggl Kegiatan</td>
			
			<?php if ($showTiket) { ?>
				<td class="center middle nowrap bold">Tiket Pesawat <br />PP (Rp.)</td>
			<?php } ?>
			
			<?php if ($showTaksi) { ?>
				<td class="center middle nowrap bold">Taksi PP <br />(Rp.)</td>
			<?php } ?>
			
			<?php if ($showTransportLokal) { ?>
				<td class="center middle nowrap bold">Transport <br />Lokal PP (Rp.)</td>
			<?php } ?>
			
			<?php if ($showTransLainnya) { ?>
				<td class="center middle nowrap bold">Transport <br />Lainnya (Rp.)</td>
			<?php } ?>
			
			<?php if ($showUangHarian) { ?>
				<td class="center middle nowrap bold">Uang Harian <br />(Rp.)</td>
			<?php } ?>

			<?php if ($showPenginapan) { ?>
				<td class="center middle nowrap bold">Penginapan <br />(Rp.)</td>
			<?php } ?>

			<td class="center middle nowrap bold">Jumlah Diterima <br />(Rp.)</td>
		</tr>
	</thead>
	<tbody>
	<?php		
		$jumlahTiket = 0;
		$jumlahTaksi = 0;
		$jumlahTrans = 0;
		$jumlahUH = 0;
		$jumlahTransLainnya = 0;
		$jumlahPenginapan = 0;
		$jumlahDiterima = 0;
		
		if (!empty($items)) {
			$i = 1;
			
			foreach ($items as $item) {
				$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
				$tglTugas = $this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
				
				// Hack Tugas yg dirinci
				if (!empty($item["tgl_tugas"])) {
					$lamaTugas = count($item["tgl_tugas"]);
					
					$item["transport"] = $lamaTugas * $item["transport"];
					
					$tglTugas = "";
					
					foreach ($item["tgl_tugas"] as $tglT) {
						if (!empty($tglTugas)) {
							$tglTugas .= ", ";
						}
						
						$tglTugas .= $this->utility->formatShortDateIndo($tglT["tgl_tugas"]);
					}
				}
				
				$tiket = $item["pesawat_berangkat"] + $item["pesawat_pulang"];
				$taksi = $item["taksi_berangkat"] + $item["taksi_pulang"];
				
				$uangHarian = ($item["uang_harian"]*$lamaTugas);
				$penginapan = ($item["penginapan"]*($lamaTugas-1));
				
				$diterima = $item["transport"] + $uangHarian + $item["transport_lainnya"] + $penginapan + $tiket + $taksi;
				
				$jumlahTiket += $tiket;
				$jumlahTaksi += $taksi;
				$jumlahTrans += $item["transport"];
				$jumlahUH += $uangHarian;
				$jumlahTransLainnya += $item["transport_lainnya"];
				$jumlahPenginapan += $penginapan;
				$jumlahDiterima += $diterima;
	?>
				<tr>
					<td class="middle center"><?php print $i; ?></td>
					<td class="middle"><?php print $item["nama"]; ?><br />NIP <?php print (!empty($item["nip"])) ? $item["nip"] : "-"; ?></td>
					<td class="middle"><?php print $item["jabatan"]." ".$item["unit_kerja"]; ?></td>
					<td class="middle center"><?php print $item["kab_asal"]; ?> - <?php print $item["kab_tujuan"]; ?></td>
					<td class="middle center"><?php print $lamaTugas; ?></td>
					<td class="middle center"><?php print $tglTugas; ?></td>
					
					<?php if ($showTiket) { ?>
						<td class="middle text-right"><?php print $this->utility->format_number($tiket); ?></td>
					<?php } ?>

					<?php if ($showTaksi) { ?>
						<td class="middle text-right"><?php print $this->utility->format_number($taksi); ?></td>
					<?php } ?>

					<?php if ($showTransportLokal) { ?>
						<td class="middle text-right"><?php print $this->utility->format_number($item["transport"]); ?></td>
					<?php } ?>

					<?php if ($showTransLainnya) { ?>
						<td class="middle text-right"><?php print $this->utility->format_number($item["transport_lainnya"]); ?></td>
					<?php } ?>

					<?php if ($showUangHarian) { ?>
						<td class="middle text-right"><?php print $this->utility->format_number($uangHarian); ?></td>
					<?php } ?>
					
					<?php if ($showPenginapan) { ?>
						<td class="middle text-right"><?php print $this->utility->format_number($penginapan); ?></td>
					<?php } ?>
					
					<td class="middle text-right"><?php print $this->utility->format_number($diterima); ?></td>
				</tr>
	<?php
				$i++;
			}
		}
	?>
		
		<tr>
			<td class="middle center bold paadingTB2" colspan="6">JUMLAH</td>
			
			<?php if ($showTiket) { ?>
				<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahTiket); ?></td>
			<?php } ?>

			<?php if ($showTaksi) { ?>
				<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahTaksi); ?></td>
			<?php } ?>

			<?php if ($showTransportLokal) { ?>
				<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahTrans); ?></td>
			<?php } ?>

			<?php if ($showTransLainnya) { ?>
				<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahTransLainnya); ?></td>
			<?php } ?>

			<?php if ($showUangHarian) { ?>
				<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahUH); ?></td>
			<?php } ?>

			<?php if ($showPenginapan) { ?>
				<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahPenginapan); ?></td>
			<?php } ?>

			<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_number($jumlahDiterima); ?></td>
		</tr>
	</tbody>
</table>
<table cellpadding="0" cellspacing="0" width="100%" class="drp" style="page-break-inside: avoid;">
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="33%" style="padding-top: 20px;">Mengetahui,</td>
		<td>&nbsp;</td>
		<td width="28%" style="padding-top: 20px;"><?php print $kab_spby; ?>, <?php print $this->utility->formatDateIndo($tgl_spby); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Pejabat Pembuat Komitmen</td>
		<td>&nbsp;</td>
		<td>Bendahara Pengeluaran</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<div style="font-weight: bold;"><?php print $nama_ppk; ?></div>
			NIP <?php print $nip_ppk; ?>
		</td>
		<td>&nbsp;</td>
		<td>
			<div style="font-weight: bold;"><?php print $nama_bp; ?></div>
			NIP <?php print $nip_bp; ?>
		</td>
	</tr>
</table>