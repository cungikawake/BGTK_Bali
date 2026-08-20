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
			<td>
				<table width="100%">
					<tbody>
						<tr>
							<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<table class="drp" width="100%" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td class="font16 bold center" colspan="3"><?php print nl2br($daftar_hadir["nama_penerimaan_atk"]); ?></td>
		</tr>
	</tbody>
</table>

<table class="drp" width="100%" style="margin-bottom:15px;">
	<tbody>
		<tr>
			<td width="18%"><strong>Nama Kegiatan</strong></td>
			<td width="1%">:</td>
			<td><?php print $spj["nama"]; ?></td>
		</tr>
		<tr>
			<td><strong>Tanggal</strong></td>
			<td>:</td>
			<td><?php print $this->utility->formatRangeDate2($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></td>
		</tr>
		<tr>
			<td><strong>Tempat</strong></td>
			<td>:</td>
			<td><?php print $kegiatan["tempat_kegiatan"]." (".$kegiatan["kab_tempat_kegiatan"].")"; ?></td>
		</tr>
	</tbody>
</table>

<table class="drp bordered" cellpadding="0" cellspacing="0" width="100%" style="page-break-inside: always; margin-bottom: 5px;">
	<thead>
		<tr>
			<td class="center middle bold" width="6%">No</td>
			<td class="center middle bold" width="31%">Nama / NIP</td>
			<td class="center middle bold" width="32%">Jabatan/Unit Kerja</td>
			<td class="center middle bold" width="15%">Kab/Kota</td>
			<td class="center middle bold" width="16%">Tanda Tangan</td>
		</tr>
	</thead>
	<tbody>
	<?php
	    $lineHeight = 0;
	    
	    if (!empty($daftar_hadir["spasi_penerimaan_atk"])) {
	        $lineHeight = $daftar_hadir["spasi_penerimaan_atk"];
	    }
	    
		if (!empty($items)) {
			$i = 1;
			
			foreach ($items as $item) {
	?>
				<tr>
					<td class="middle center" style="height: <?php print $lineHeight; ?>px;"><?php print $i; ?></td>
					<td class="middle"><?php print $item["nama"]; ?><br />NIP <?php print (!empty($item["nip"])) ? $item["nip"] : "-"; ?></td>
					<td class="middle"><?php print $item["jabatan"]." ".$item["unit_kerja"]; ?></td>
					<td class="middle center"><?php print $item["kab_asal"]; ?></td>
					<td>&nbsp;</td>
				</tr>
	<?php
				$i++;
			}
		}
	?>
	</tbody>
</table>
<table cellpadding="0" cellspacing="0" width="100%" class="drp" style="page-break-inside: avoid;">
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
		<td width="10%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="35%"><?php print $kegiatan["kab_tempat_kegiatan"]; ?>, <?php print $this->utility->formatDateIndo($kegiatan["tgl_selesai_kegiatan"]); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Ketua Panitia</td>
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
		<td><?php print $ketua["nama"]; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		    <?php
		        if ($ketua["nip"] != "" && $ketua["nip"] != "-") {
		            print "NIP ".$ketua["nip"];
		        }
		    ?>
		</td>
	</tr>
</table>