<style type="text/css">
	.perjadin td, .perjadin td p { vertical-align:top; font-size:12px; font-family: 'tahoma'; line-height: normal;}
	.perjadin .center { text-align:center; }
	.perjadin .right { text-align: right; }
	.perjadin .justify { text-align: justify; }
	.perjadin .bold { font-weight: bold; font-size:12px; }
	.perjadin .mb-10 { margin-bottom: 10px;}
	.perjadin .mb-15 { margin-bottom: 15px;}
	.perjadin .mb-20 { margin-bottom: 20px;}
	.perjadin .paragraph { white-space: pre-line; word-wrap: break-word; }
	.perjadin .hasil-laporan { margin-bottom: 15px; }
	.perjadin ul, .perjadin ol {margin-bottom: 15px; margin-left: 20px; }
	.perjadin ul li, .perjadin ol li, .perjadin p { font-size:12px; font-family: 'tahoma'; text-align: justify; }
	.perjadin.preview {
		background: url('<?php print base_url('assets/images/red-preview.jpg'); ?>');
	}
</style>
<?php
	$preview = "preview";
	if (isset($spj_item)) {
		$preview = "";
	}
?>
<div class="perjadin <?php print $preview; ?>">
	<table width="100%" style="margin-bottom:15px;margin-left:-10px;margin-right:-10px;">
		<tbody>
			<tr>
				<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="perjadin-content mb-15">
		<tbody>
			<tr>
				<td width="12%">Perihal <br/>Lampiran</td>
				<td>: &nbsp;&nbsp;&nbsp;Perjalanan Dinas <br/>
					: &nbsp;&nbsp;&nbsp;-
				</td>
				<td class="right"><?php print $this->utility->formatDateIndo($item["diubah_tgl"]); ?> &nbsp;&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="perjadin-content mb-15">
		<tbody>
			<tr>
				<td class="bold">Yth. Kepala <?php print ucfirst($satker["upt"]); ?> <br />di - <?php print $_ENV["DEFAULT_KABUPATEN"]; ?></td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="perjadin-content mb-15">
		<tbody>
			<tr>
				<td class="paragraph justify">Berdasarkan surat tugas dari Kepala <?php print ucfirst($satker["upt"]); ?> nomor: <?php print $penugasan["nomor_surat"]; ?> tanggal <?php print $this->utility->formatDateIndo($penugasan["tgl_surat"]); ?>, maka bersama ini kami sampaikan laporan hasil perjalanan dinas sebagai berikut.</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="perjadin-content mb-20">
		<tbody>
			<tr>
				<td width="6%">&nbsp;</td>
				<td width="30%">Tanggal berangkat</td>
				<td width="2%">:</td>
				<td><?php print $this->utility->formatDateIndo($item["tgl_mulai_tugas"]); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Tanggal tiba</td>
				<td>:</td>
				<td><?php print $this->utility->formatDateIndo($item["tgl_selesai_tugas"]); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Lama perjalanan dinas</td>
				<td>:</td>
				<td><?php print $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]); ?> hari</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Transportasi yang digunakan</td>
				<td>:</td>
				<td><?php print ($item["provinsi_tujuan"] == $_ENV['DEFAULT_PROVINSI']) ? "Angkutan darat" : "Angkutan darat & udara" ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Tempat tujuan</td>
				<td>:</td>
				<td><?php print $item["tempat_tujuan"]. " (".$item["kab_tujuan"].", ".$item["provinsi_tujuan"].")"; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Tujuan perjalanan</td>
				<td>:</td>
				<td><?php print $penugasan["nama"]; ?></td>
			</tr>
		</tbody>
	</table>
	
	<p class="bold">Pelaksanaan Kegiatan</p>
	<?php print $item["laporan_tugas"]; ?>
	
	<p class="bold">Hasil Kegiatan</p>
	<?php print $item["laporan_hasil"]; ?>
	
	<table width="100%" class="perjadin-content" style="margin-top: 40px;">
		<tbody>
			<tr>
				<td width="55%">&nbsp;</td>
				<td>Yang melaksanakan tugas,</td>
			</tr>
			<tr>
				<td rowspan="3">
					<?php
						if (isset($validasi)) {
							print '<img class="qr-code" src="'.$validasi["perjadin"].'" />';
						}
						else {
							print '&nbsp;';
						}
					?>
				</td>
				<td height="80px">
					<?php
						if (isset($spj_item)) {
							print '&nbsp;';
						}
						else {
							//print '<img src="'.$item["laporan_ttd"].'" height="80px" />';
							print '&nbsp;';
						}
					?>
				</td>
			</tr>
			<tr>
				<td><?php print $item["nama"]; ?></td>
			</tr>
			<?php
				if (!empty($item["nip"]) && $item["nip"] != "-" && $item["nip"] != "0") {
			?>
				<tr>
					<td>NIP <?php print $item["nip"]; ?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	<pagebreak>
	
	<p class="bold center mb-10">DOKUMENTASI</p>
	<p class="bold center"><?php print $penugasan["nama"]; ?><br /><?php print $item["tempat_tujuan"]. " (".$item["kab_tujuan"].", ".$item["provinsi_tujuan"].")"; ?><br /><?php print $this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]) ?></p>
		
	<div class="foto center mb-20"><img src="<?php print base_url("/assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$item["id"]."/".$item["laporan_foto"][0]."?v=".rand()); ?>" style="max-height: 350px;" /></div>
	<div class="foto center"><img src="<?php print base_url("/assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$item["id"]."/".$item["laporan_foto"][1]."?v=".rand()); ?>" style="max-height: 350px;" /></div>
</div>