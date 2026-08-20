<style type="text/css">
	.spd-belakang table { width: 100%; font-size: 12px; }
	.spd-belakang table.bordered  { border-left: 1px solid #000; border-bottom: 1px solid #000; width: 100%; }
	.spd-belakang table td { font-family:"tahoma" }
	.spd-belakang table td { border-right: 1px solid #000; border-top: 1px solid #000; font-family:"tahoma" }
	.spd-belakang .no-border {border: none; padding: 1px 0; }
	<?php
		if (isset($spj_item["id"])) {
	?>
	.spd-belakang .ttd {padding: 5px 0; text-align: center; color: #ccc; }
	<?php
		}
		else {
	?>
	.spd-belakang .ttd {padding: 45px 0; text-align: center; color: #ccc; }
	<?php
		}
	?>
	
	.spd-belakang .ttd-lokasi {padding: 45px 0; text-align: center; color: #ccc; }
	
	<?php
		if (isset($spj_item["id"])) {
	?>
		.spd-belakang .ttd2 {padding: 25px 0; text-align: center; color: #ccc; }
	<?php
		}
		else {
	?>
		.spd-belakang .ttd2 {padding: 30px 0; text-align: center; color: #ccc; }
	<?php
		}
	?>
	
	.spd-belakang .p7 {padding: 7px 12px; vertical-align: top;}
	.spd-belakang .step {width: 25px; vertical-align: top; }
	.spd-belakang .label {width: 110px; }
	.spd-belakang .pt-7 { padding-top: 7px; }
	.spd-belakang .right { text-align: right; }
	.spd-belakang .stamp-spd {
		background: url('<?php print base_url('assets/laporan_perjadin/'.$_SESSION["tahun_anggaran"]."/".$item["id"].'/stamp.png?v='.rand()); ?>');
		background-image-resize: 3;
		background-repeat: no-repeat;
		background-position: left;
	}
	.spd-belakang.preview {
		background: url('<?php print base_url('assets/images/red-preview.jpg'); ?>');
	}
</style>
<?php
	$preview = "preview";
	if (isset($spj_item)) {
		$preview = "";
	}
?>
<div class="spd-belakang <?php print $preview; ?>">
	<table cellpadding="0" cellspacing="0" class="bordered">
		<tr>
			<td width="50%" class="p7">&nbsp;</td>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">I.</td>
						<td class="no-border label">Berangkat dari</td>
						<td class="no-border" colspan="2">: &nbsp;<?php print $item["kab_asal"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Ke</td>
						<td class="no-border" colspan="2">: &nbsp;<?php print $item["kab_tujuan"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Pada tanggal</td>
						<td class="no-border" colspan="2">: &nbsp;<?php print $this->utility->formatDateIndo($item["tgl_mulai_tugas"]); ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border pt-7" colspan="3">Pejabat Pembuat Komitmen</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3"><?php print $_ENV["INSTANSI_DIPA_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border ttd" colspan="2">
							<?php
								if (isset($validasi)) {
									if (file_exists(APPPATH . '../assets/ttd/pejabat/'.$ppk["nip"].'.png')) {
										print '<img class="ttd-pj" src="'.base_url('/assets/ttd/pejabat/'.$ppk["nip"].'.png').'" style="height:96px;" />';
									}
								}
								else {
									print '&nbsp;';
								}
							?>
						</td>
						<td class="no-border right">
							<?php
								if (isset($validasi)) {
									print '<img class="qr-code" src="'.$validasi["spd_belakang_berangkat"].'" />';
								}
								else {
									print '&nbsp;';
								}
							?>
						</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3"><?php print $ppk["nama"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3">NIP <?php print $ppk["nip"]; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">II.</td>
						<td class="no-border label">Tiba di</td>
						<td class="no-border">:&nbsp; <?php print $item["kab_tujuan"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Pada tanggal</td>
						<td class="no-border">:&nbsp; <?php print $this->utility->formatDateIndo($item["tgl_mulai_tugas"]); ?></td>
					</tr>
					
					<tr>
						<td class="no-border" colspan="3">
							<table cellpadding="0" cellspacing="0" width="100%" class="stamp-spd">
								<tr>
									<td class="no-border" width="9%">&nbsp;</td>
									<td class="no-border">&nbsp;</td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border"><?php print $item["spd_jabatan"]; ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border"><?php print $item["spd_satker"]; ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border ttd-lokasi"></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border"><?php print $item["spd_nama"]; ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border"><?php print ($item["spd_nip"] !="" && $item["spd_nip"] != "0" && $item["spd_nip"] != "-") ? "NIP ".$item["spd_nip"] : ""; ?></td>
								</tr>
							</table> 
						</td>
					</tr>
				</table>
			</td>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">&nbsp;</td>
						<td class="no-border label">Berangkat dari</td>
						<td class="no-border">:&nbsp; <?php print $item["kab_tujuan"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Ke</td>
						<td class="no-border">:&nbsp; <?php print $item["kab_asal"]; ?></td>
					</tr>
					<tr>
						<td class="no-border" colspan="3">
							<table cellpadding="0" cellspacing="0" width="100%" class="stamp-spd">
								<tr>
									<td class="no-border" width="8%">&nbsp;</td>
									<td class="no-border" colspan="2" width="37%">Pada tanggal</td>
									<td class="no-border">:&nbsp; <?php print $this->utility->formatDateIndo($item["tgl_selesai_tugas"]); ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border" colspan="3" style="padding-top:4px;"><?php print $item["spd_jabatan"]; ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border" colspan="3"><?php print $item["spd_satker"]; ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border ttd-lokasi" colspan="3"></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border" colspan="3"><?php print $item["spd_nama"]; ?></td>
								</tr>
								<tr>
									<td class="no-border">&nbsp;</td>
									<td class="no-border" colspan="3"><?php print ($item["spd_nip"] !="" && $item["spd_nip"] != "0" && $item["spd_nip"] != "-") ? "NIP ".$item["spd_nip"] : ""; ?></td>
								</tr>
							</table> 
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">III.</td>
						<td class="no-border label">Tiba di</td>
						<td class="no-border">:</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Pada tanggal</td>
						<td class="no-border">:</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">&nbsp;</td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">&nbsp;</td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border ttd2">&nbsp;</td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="2">&nbsp;</td>
					</tr>
				</table>
			</td>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">&nbsp;</td>
						<td class="no-border label">Berangkat dari</td>
						<td class="no-border">:</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Ke</td>
						<td class="no-border">:</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Pada tanggal</td>
						<td class="no-border">:</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">&nbsp;</td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border ttd2">&nbsp;</td>
						<td class="no-border"></td>
					</tr>
					
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="2">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">IV.</td>
						<td class="no-border label">Tiba di</td>
						<td class="no-border" colspan="2">:&nbsp; <?php print $item["kab_asal"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">Pada tanggal</td>
						<td class="no-border" colspan="2">:&nbsp; <?php print $this->utility->formatDateIndo($item["tgl_selesai_tugas"]); ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">&nbsp;</td>
						<td class="no-border"></td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border">&nbsp;</td>
						<td class="no-border"></td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3">Pejabat Pembuat Komitmen</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3"><?php print $_ENV["INSTANSI_DIPA_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border ttd" colspan="2">
							<?php
								if (isset($validasi)) {
									if (file_exists(APPPATH . '../assets/ttd/pejabat/'.$ppk["nip"].'.png')) {
										print '<img class="ttd-pj" src="'.base_url('/assets/ttd/pejabat/'.$ppk["nip"].'.png').'" style="height:96px;" />';
									}
								}
								else {
									print '&nbsp;';
								}
							?>
						</td>
						<td class="no-border right">
							<?php
								if (isset($validasi)) {
									print '<img class="qr-code" src="'.$validasi["spd_belakang_pulang"].'" />';
								}
								else {
									print '&nbsp;';
								}
							?>
						</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3"><?php print $ppk["nama"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3">NIP <?php print $ppk["nip"]; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" class="p7">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step">&nbsp;</td>
						<td class="no-border label" colspan="3">Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3" style="padding-top: 10px;">Pejabat Pembuat Komitmen</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="3"><?php print $_ENV["INSTANSI_DIPA_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border ttd" colspan="2">
							<?php
								if (isset($validasi)) {
									if (file_exists(APPPATH . '../assets/ttd/pejabat/'.$ppk["nip"].'.png')) {
										print '<img class="ttd-pj" src="'.base_url('/assets/ttd/pejabat/'.$ppk["nip"].'.png').'" style="height:96px;" />';
									}
								}
								else {
									print '&nbsp;';
								}
							?>
						</td>
						<td class="no-border right">
							<?php
								if (isset($validasi)) {
									print '<img class="qr-code" src="'.$validasi["spd_belakang_ppk"].'" />';
								}
								else {
									print '&nbsp;';
								}
							?>
						</td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border"><?php print $ppk["nama"]; ?></td>
					</tr>
					<tr>
						<td class="no-border"></td>
						<td class="no-border" colspan="2">NIP <?php print $ppk["nip"]; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="p7" colspan="2">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step" style="font-size: 11px;">V.</td>
						<td class="no-border label" style="font-size: 11px;">Catatan Lain-lain &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="p7" colspan="2">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="no-border step" style="font-size: 11px;">VI.</td>
						<td class="no-border label" style="font-size: 11px;">PERHATIAN:<br />
	PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>