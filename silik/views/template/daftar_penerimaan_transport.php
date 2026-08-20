<style type="text/css">
	.penerimaan td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.penerimaan .center { text-align:center; }
	.penerimaan .middle { vertical-align:middle; }
	.penerimaan .font14 { font-size:14px; }
	.penerimaan .font16 { font-size:16px; }
	.penerimaan .bold { font-weight:bold; }
	.penerimaan .bordered { border-top:1px solid #000; border-left:1px solid #000; }
	.penerimaan .bordered td { border-bottom:1px solid #000; border-right:1px solid #000; padding:4px 6px;}
	.penerimaan .middle { vertical-align:middle; }
	.penerimaan .font4 { font-size:4px;}
	.penerimaan .justify { text-align:justify; }
	.penerimaan .right { text-align:right; }
	.penerimaan .bordered td.bb {border-bottom: 2px solid #000;}
	.penerimaan .bt {border-top: 1px solid #000;}
	.table-penerimaan {border-left: 1px solid #000; border-bottom: 1px solid #000;}
	.table-penerimaan td {border-top: 1px solid #000; border-right: 1px solid #000; font-size: 10px;}
</style>
<table width="100%" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
		</tr>
	</tbody>
</table>

<table width="100%" class="penerimaan" style="margin-bottom:15px;">
	<tr>
		<td class="center font14 bold">DAFTAR PENERIMAAN TRANSPORT & UANG HARIAN <?php print strtoupper($unsur); ?></td>
	</tr>
	<tr>
		<td class="center font14 bold">TAHUN 2022</td>
	</tr>
</table>

<table width="100%" class="penerimaan" style="margin-bottom:15px;">
	<tr>
		<td style="width: 100px;">Kegiatan</td>
		<td>: <?php print $kegiatan["nama"]; ?></td>
	</tr>
	<tr>
		<td>Hari, Tanggal</td>
		<td>: <?php print $this->utility->formatRangeDay($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?>, <?php print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></td>
	</tr>

	<?php
		if ($kegiatan["tipe_kegiatan"] == "Daring") {
	?>
		<tr>
			<td>Zoom Id</td>
			<td>: <?php print $kegiatan["zoom_id_kegiatan"]; ?></td>
		</tr>
	<?php
		}
		else {
	?>
		<tr>
			<td>Tempat</td>
			<td>: <?php print $kegiatan["tempat_kegiatan"]; ?></td>
		</tr>
	<?php
		}
	?>
</table>

<table width="100%" cellpadding="4" cellspacing="0" class="penerimaan table-penerimaan" style="margin-bottom:15px;">
	<tr>
		<td class="center middle bold">No</td>
		<td class="center middle bold">Nama/NIP</td>
		<td class="center middle bold">Jabatan/Unit Kerja</td>
		<td class="center middle bold">Kab/Kota</td>
		<td class="center middle bold">Hari</td>
		<td width="10%" class="center middle bold">Transport Lokal (Rp.)</td>
		<td width="10%" class="center middle bold">Uang Harian (Rp.)</td>
		<td width="10%" class="center middle bold">Transport Lainnya (Rp.)</td>
		<td width="10%" class="center middle bold">Jumlah Diterima (Rp.)</td>
	</tr>
	<?php
		if (!empty($items)) {
			$i = 1;
			$transport = 0;
			$uangHarian = 0;
			$transportLain = 0;
			$jumlahTotal = 0;
			
			foreach ($items as $item) {
				$lama = $this->utility->lama_tugas($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]);
				
				$jumlah = $item["transport"] + ($item["uang_harian"] * $lama) + $item["transport_lainnya"];
				
				$transport += $item["transport"];
				$uangHarian += ($item["uang_harian"] * $lama);
				$transportLain += $item["transport_lainnya"];
				$jumlahTotal += $jumlah;
	?>
				<tr>
					<td class="center"><?php print $i; ?></td>
					<td><?php print $item["nama"]; ?><br /><?php if (!empty($item["nip"])) { print "NIP ".$item["nip"]; } else { print "&nbsp;"; } ?></td>
					<td><?php print $item["jabatan"]." ".$item["unit_kerja"]; ?></td>
					<td><?php print $item["transport_asal"]; ?></td>
					<td class="center"><?php print $lama; ?></td>
					<td class="right"><?php print $this->utility->format_number($item["transport"]); ?></td>
					<td class="right"><?php print $this->utility->format_number($item["uang_harian"]); ?></td>
					<td class="right"><?php print $this->utility->format_number($item["transport_lainnya"]); ?></td>
					<td class="right"><?php print $this->utility->format_number($jumlah); ?></td>
				</tr>
	<?php
				$i++;
			}
		}
	?>
	<tr>
		<td class="center middle bold">&nbsp;</td>
		<td class="center middle bold" colspan="2">JUMLAH</td>
		<td class="center middle bold">&nbsp;</td>
		<td class="center middle bold">&nbsp;</td>
		<td width="10%" class="right bold"><?php print $this->utility->format_number($transport); ?></td>
		<td width="10%" class="right bold"><?php print $this->utility->format_number($uangHarian); ?></td>
		<td width="10%" class="right bold"><?php print $this->utility->format_number($transportLain); ?></td>
		<td width="10%" class="right bold"><?php print $this->utility->format_number($jumlahTotal); ?></td>
	</tr>
</table>