<style type="text/css">
	.khr td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.khr .center { text-align:center; }
	.khr .font16 { font-size:15px; }
	.khr .bold { font-weight:bold; }
	.khr .bordered { border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; }
	.khr .bordered td { border-right:1px solid #000; padding:4px 6px;}
	.khr .middle { vertical-align:middle; }
	.khr .font4 { font-size:4px;}
	.khr .kuitansi { border:2px solid #000; font-size:14px; padding:3px 20px; font-weight:bold; }
	.khr .justify {text-align:justify; }
	.khr .font8 { font-size:8px; }
	.khr .font7 { font-size:7px; }
	.khr .font6 { font-size:6px; }
	.khr .text-right { text-align:right; }
	.khr .bb { border-bottom:2px solid #000; }
	.khr .bt { border-top:2px solid #000; }
	.khr .bt-normal { border-top:1px solid #000; }
	.khr .kw-detail td.space { font-size: 6px; }
	.khr .kw-detail td.space2 { font-size: 2px; }
</style>
<table class="khr" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:7px;"><?php print $item["no_urut"]; ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="border-bottom: 3px solid #000; margin-bottom:6px;">
				<tbody>
					<tr>
						<td width="22%" style="text-align: center; vertical-align: middle; font-family: 'timesnewromanxx';">
							<img style="width:120px;" src="<?php print base_url("/assets/images/logo-kemdikbud-black.png"); ?>" />
						</td>
						<td width="78%" style="text-align: center; font-family: 'timesnewromanxx'; padding-bottom: 3px;">
							<div style="font-size: 20px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</div>
							<div style="font-size: 20px;">RISET DAN TEKNOLOGI</div>
							<div style="font-size: 18px; font-weight: bold;"><?php print strtoupper($satker["upt"]); ?></div>
							<div style="font-size: 14px;"><?php print $satker["alamat"]; ?></div>
							<div style="font-size: 14px;">Telp. <?php print $satker["telepon"]; ?>, Laman: <?php print $satker["website"]; ?></div>
							<div style="font-size: 14px;">Pos-el. <?php print $satker["email"]; ?></div>
						</td>
					</tr>
				</tbody>
			</table>

			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
				<tbody>
					<tr>
						<td width="52%">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
						<td width="48%">
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="32%">No. Bukti</td>
									<td style="font-size:11px;">: <?php print $this->utility->penomoran($item["id"])."/KW/HR/".$satker["kode_satker"]."/".date("Y", strtotime($kegiatan["tgl_selesai_kegiatan"])); ?></td>
								</tr>
								<tr>
									<td>Tahun Anggaran</td>
									<td style="font-size:11px;">: 2022</td>
								</tr>
								<tr>
									<td>MAK/Kode</td>
									<td style="font-size:11px;">: <?php print $item["dipa_kegiatan"].".".$item["dipa_kro"].".".$item["dipa_ro"].".".$item["dipa_komponen"].".".$item["dipa_sub_komponen"].".".$item["dipa_akun_honor"]."/".$item["dipa_program"]; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="text-align: center;">
							<table cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td class="kuitansi">KUITANSI</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="kw-detail" width="100%" style="border-bottom:2px solid #000; margin-bottom:2px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="22%">SUDAH DITERIMA DARI</td>
						<td width="1%">:</td>
						<td width="76%" colspan="2">Kuasa Pengguna Anggaran <?php echo $satker["upt"]; ?></td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
					</tr>
					<tr>
						<td>JUMLAH UANG</td>
						<td>:</td>
						<td colspan="2" class="bold">
							<?php
								$lamaNgajar = $item["vol_honor"];
								$total = $item["honor"] * $lamaNgajar;
								print $this->utility->format_money($total);
							?>
						</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
					</tr>
					<tr>
						<td>TERBILANG</td>
						<td>:</td>
						<td colspan="2"><em><?php print $this->utility->terbilang($total); ?></em></td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td>UNTUK PEMBAYARAN</td>
						<td>:</td>
						<td colspan="2" class="justify"><?php print $item["deskripsi_honor"]; ?></td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="2" class="justify">
							<?php
								$nilaiPajak = ($item["pajak"]/100) * $total;
							?>
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td colspan="9">dengan perincian sbb:</td>
								</tr>
								<tr>
									<td colspan="9" class="space">&nbsp;</td>
								</tr>
								<tr>
									<td><?php print $this->utility->format_money($item["honor"]); ?></td>
									<td>x</td>
									<td><?php print $item["vol_honor"]; ?> <?php print $item["satuan_honor"]; ?></td>
									<td><?php if (strtolower($item["satuan_honor"]) != "keg") { print "x"; } ?></td>
									<td><?php if (strtolower($item["satuan_honor"]) != "keg") { print "1 keg"; } ?></td>
									<td class="text-right">=&nbsp;&nbsp;</td>
									<td class="text-right"><?php print $this->utility->format_money($total); ?></td>
									<td></td>
									<td width="15%">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="9" class="space2">&nbsp;</td>
								</tr>
								<tr>
									<td>PPh pasal 21 &nbsp;&nbsp;(<?php print $item["pajak"]; ?>%)</td>
									<td>x</td>
									<td colspan="3"><?php print $this->utility->format_money($total); ?></td>
									<td class="text-right">=&nbsp;&nbsp;</td>
									<td class="text-right"><?php print $this->utility->format_money($nilaiPajak); ?></td>
									<td>&nbsp;_</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="9" class="space2">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="6" class="space2">&nbsp;</td>
									<td class="space2 bt-normal">&nbsp;</td>
									<td class="space2"></td>
									<td class="space2">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="6" class="text-right">Jumlah diterima&nbsp;&nbsp;</td>
									<td class="text-right"><?php print $this->utility->format_money(($total - $nilaiPajak)); ?></td>
									<td></td>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td class="space">&nbsp;</td>
						<td class="space">&nbsp;</td>
						<td colspan="2" class="space">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php print $item["kab_honor"]; ?>, <?php print $this->utility->formatDateIndo($item["tgl_honor"]); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Yang menerima,</td>
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
						<td>&nbsp;</td>
						<td width="35%">&nbsp;</td>
						<td><?php print $item["nama"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php if(!empty($item["nip"])) { print "NIP ".$item["nip"]; } ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
			
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 4px;">
				<tbody>
					<tr>
						<td width="6%">&nbsp;</td>
						<td width="58.7%">&nbsp;</td>
						<td width="35.3%">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Mengetahui/Menyetujui :</td>
						<td>Lunas dibayar tgl <?php print $this->utility->formatDateIndo($item["tgl_honor"]); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Pejabat Pembuat Komitmen,</td>
						<td>Bendahara Pengeluaran,</td>
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
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><?php print $item["nama_ppk"]; ?></td>
						<td><?php print $item["nama_bp"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>NIP <?php print $item["nip_ppk"]; ?></td>
						<td>NIP <?php print $item["nip_bp"]; ?></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>