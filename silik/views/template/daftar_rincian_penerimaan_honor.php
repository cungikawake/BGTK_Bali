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
</style>

<table width="100%" class="drp" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td width="18%">&nbsp;</td>
			<td>
				<table width="100%">
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

<table class="drp" width="100%" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td class="font16 bold center" colspan="3">DAFTAR RINCIAN PENERIMAAN HONOR <?php print strtoupper(str_replace(array("_","praktek"),array(" ","praktik"),$spj["komponen"])); ?></td>
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
			<td class="center middle bold">No</td>
			<td class="center middle bold" width="23%">Nama / NIP</td>
			<td class="center middle bold" width="3.5%">Gol</td>
			<td class="center middle bold" width="18%">Jabatan / Unit Kerja</td>
			<td class="center middle bold" width="11%">Honor (Rp.)</td>
			<td class="center middle bold" width="4.5%">Vol</td>
			<td class="center middle bold">Jumlah Honor (Rp.)</td>
			<td class="center middle bold" width="11%">Pajak (Rp.)</td>
			<td class="center middle bold">Jumlah Diterima (Rp.)</td>
		</tr>
	</thead>
	<tbody>
	<?php		
		$jumlahHonor = 0;
		$jumlahPajak = 0;
		$jumlahDiterima = 0;
		
		if (!empty($items)) {
			$i = 1;
			
			foreach ($items as $item) {
				$honorer = $item["honor"] * $item["vol_honor"];
				$pajak = $honorer * $item["pajak"] / 100;
				$diterima = $honorer - $pajak;
				
				$jumlahHonor += $honorer;
				$jumlahPajak += $pajak;
				$jumlahDiterima += $diterima;
	?>
				<tr>
					<td class="middle"><?php print $i; ?></td>
					<td class="middle"><?php print $item["nama"]; ?><br />NIP <?php print (!empty($item["nip"])) ? $item["nip"] : "-"; ?></td>
					<td class="middle"><?php print $item["golongan"]; ?></td>
					<td class="middle"><?php print $item["jabatan"]." ".$item["unit_kerja"]; ?></td>
					<td class="middle text-right"><?php print $this->utility->format_money($item["honor"]); ?></td>
					<td class="middle text-right"><?php print $item["vol_honor"]." ".$item["satuan_honor"]; ?></td>
					<td class="middle text-right"><?php print $this->utility->format_money($honorer); ?></td>
					<td class="middle text-right"><?php print $this->utility->format_money($pajak); ?></td>
					<td class="middle text-right"><?php print $this->utility->format_money($diterima); ?></td>
				</tr>
	<?php
				$i++;
			}
		}
	?>
		
		<tr>
			<td class="middle center bold paadingTB2" colspan="4">JUMLAH</td>
			<td class="middle text-right bold paadingTB2" style="white-space: nowrap;">&nbsp;</td>
			<td class="middle text-right bold paadingTB2" style="white-space: nowrap;">&nbsp;</td>
			<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_money($jumlahHonor); ?></td>
			<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_money($jumlahPajak); ?></td>
			<td class="middle text-right bold paadingTB2" style="white-space: nowrap;"><?php print $this->utility->format_money($jumlahDiterima); ?></td>
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