<style type="text/css">
	.spd-paket-meeting td {
		vertical-align:top; font-size:12px; font-family: 'tahoma'; line-height: normal;
	}
	.spd-paket-meeting td.bold {
		font-weight: bold;
	}
	.spd-paket-meeting td.uppercase {
		text-transform: uppercase;
	}
	.spd-paket-meeting.bordered {
		border-top:1px solid #000;
		border-left: 1px solid #000;
	}
	.spd-paket-meeting.bordered td {
		border-right: 1px solid #000;
		border-bottom: 1px solid #000;
		font-size:11px;
	}
	.spd-paket-meeting.bordered thead td {
		vertical-align:middle;
		font-weight: bold;
		text-align: center;
	}
	.spd-paket-meeting .center {
		text-align: center;
	}
	.spd-paket-meeting tbody td {
		vertical-align: middle;
	}
</style>

<table class="spd-paket-meeting" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="bold">Lampiran SPD</td>
	</tr>
	<tr>
		<td class="bold">Nomor <?php print $spj_item["no_spd"]; ?>, tanggal <?php print $this->utility->formatDateIndo($spj_item["tgl_surat"]); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="uppercase">Kegiatan <?php print $spj["nama"]; ?></td>
	</tr>
	<tr>
		<td class="uppercase">TANGGAL  <?php print $this->utility->formatRangeDate2($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></td>
	</tr>
	<tr>
		<td class="uppercase">
			BERTEMPAT DI <?php print $kegiatan["tempat_kegiatan"]; ?> 
			<?php
				print $kegiatan["kab_tempat_kegiatan"];
			?>
		</td>
	</tr>
	<tr>
		<td class="uppercase">SATUAN KERJA <?php print strtoupper($satker["upt"]); ?></td>
	</tr>
	<tr>
		<td class="uppercase">KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<table class="spd-paket-meeting bordered" cellpadding="2" cellspacing="0" width="100%">
	<thead>
		<tr>
			<td rowspan="2" width="2.5%">No</td>
			<td rowspan="2">Nama Pelaksana SPD/NIP</td>
			<td rowspan="2" width="13%">Jabatan/ Unit Kerja</td>
			<td rowspan="2" width="7.6%">Tempat Kedudukan Asal</td>
			<td rowspan="2" width="5%">Tingkat Biaya Perjalanan Dinas</td>
			<td rowspan="2" width="6.2%">Alat Angkutan yang digunakan</td>
			<td colspan="2">
				<?php
					if (isset($items[0]["jenis_surat"])) {
						print $items[0]["jenis_surat"];
					}
					else {
						print "Surat Tugas";
					}
				?>
			</td>
			<td colspan="2">Tanggal</td>
			<td rowspan="2" width="5.4%">Lamanya Perjalanan Dinas</td>
			<td rowspan="2" width="5.4%">Keterangan</td>
		</tr>
		<tr>
			<td width="9%">Nomor</td>
			<td width="8.8%">Tanggal</td>
			<td width="8.8%">Keberangkatan Dari Tempat Kedudukan Asal</td>
			<td width="8.8%">Tiba Kembali Kedudukan Asal</td>
		</tr>
	</thead>
	<tbody>
		<?php
			if (isset($items) && !empty($items)) {
				$x = 1;
				
				foreach ($items as $item) {
		?>
					<tr>
						<td class="center"><?php print $x; ?></td>
						<td>
							<?php print $item["nama"]; ?>
							<?php
								if (!empty($item["nip"]) && $item["nip"] != "-") {
									print "<br />";
									print "NIP ".$item["nip"];
								}
							?>
						</td>
						<td><?php print $item["jabatan"]." ".$item["unit_kerja"]; ?></td>
						<td align="center"><?php print $item["kab_asal"]; ?></td>
						<td class="center">C</td>
						<td align="center">Angkutan <?php if ($item["provinsi_tujuan"] == $_ENV['DEFAULT_PROVINSI']) { print "Darat"; } else {print "Darat & Udara"; } ?></td>
						<td align="center"><?php print $item["nomor_surat"]; ?></td>
						<td align="center"><?php print $this->utility->formatDateIndo($item["tgl_surat"]); ?></td>
						<td align="center"><?php print $this->utility->formatDateIndo($item["tgl_mulai_tugas"]); ?></td>
						<td align="center"><?php print $this->utility->formatDateIndo($item["tgl_selesai_tugas"]); ?></td>
						<td class="center"><?php print $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]); ?> hari</td>
						<td>&nbsp;</td>
					</tr>
		<?php
					$x++;
				}
			}
		?>
	</tbody>
</table>
<br />
<br />
<table cellpadding="0" cellspacing="0" class="spd-paket-meeting" style="page-break-inside: avoid;">
	<tr>
		<td width="80%">&nbsp;</td>
		<td><?php print $_ENV["DEFAULT_KABUPATEN"]; ?>, <?php print $this->utility->formatDateIndo($spj_item["tgl_surat"]); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Pejabat Pembuat Komitmen</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php print $satker["upt"]; ?></td>
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
		<td class="bold"><?php print $item["nama_ppk"]; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>NIP <?php print $item["nip_ppk"]; ?></td>
	</tr>
</table>