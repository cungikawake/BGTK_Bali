<style type="text/css">
	.rpd td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.rpd .center { text-align:center; }
	.rpd .font16 { font-size:16px; }
	.rpd .bold { font-weight:bold; }
	.rpd .bordered { border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; }
	.rpd .bordered td { border-right:1px solid #000; padding:2px 6px;}
	.rpd .middle { vertical-align:middle; }
	.rpd .font4 { font-size:4px;}
	.rpd .kuitansi { border:2px solid #000; font-size:16px; padding:4px 20px; font-weight:bold; }
	.rpd .justify {text-align:justify; }
	.rpd .font8 { font-size:8px; }
	.rpd .font7 { font-size:7px; }
	.rpd .font6 { font-size:6px; }
	.rpd .text-right { text-align:right; display:block; }
	.rpd .bb { border-bottom:2px solid #000; }
	.rpd .bt { border-top:2px solid #000; }
	.rpd .bt-normal { border-top:1px solid #000; }
	.rpd .paddingTB td {padding: 2px 0; }
</style>
<table class="rpd" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:7px;"><?php if (isset($item)) { print $item["no_urut"]; } ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:15px;">
				<tbody>
					<tr>
						<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
					</tr>
				</tbody>
			</table>

			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px;">
				<tbody>
					<tr>
						<td width="57%">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
						<td width="43%">
							<table width="100%" class="paddingTB" cellpadding="0" cellspacing="0">
								<tr>
									<td width="37%">No. Bukti</td>
									<td>: <?php //print $this->utility->penomoran($item["id"])."/KW/PD/".$satker["kode_satker"]."/".date("Y", strtotime($item["tgl_selesai_tugas"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/KW/<?php print $satker["kode_satker"]; ?>/<?php print date("Y", strtotime($spby["tgl_spby"])); ?></td>
								</tr>
								<tr>
									<td>Tahun Anggaran</td>
									<td>: <?php print date("Y", strtotime($spby["tgl_spby"])); ?></td>
								</tr>
								<tr>
									<td>MAK</td>
									<td>: <?php print $spby["dipa_kegiatan"].".".$spby["dipa_kro"].".".$spby["dipa_ro"].".".$spby["dipa_komponen"].".".$spby["dipa_sub_komponen"].".".$spby["dipa_akun"]; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<table style="margin-bottom:25px;" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td class="center font16 bold"><span style="border-bottom: 2px solid #000;">KUITANSI / BUKTI PEMBAYARAN</span></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" class="paddingTB" style="margin-bottom: 25px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td width="22%">KEPADA</td>
						<td width="1%">:</td>
						<td width="76%" colspan="2"><?php print $spby["penerima"]; ?></td>
					</tr>
					<tr>
						<td width="22%">SUDAH DITERIMA DARI</td>
						<td width="1%">:</td>
						<td width="76%" colspan="2">Kuasa Pengguna Anggaran/Pejabat Pembuat Komitmen <?php print $satker["upt"]; ?></td>
					</tr>
					<tr>
						<td>JUMLAH UANG</td>
						<td>:</td>
						<td colspan="2" class="bold"><?php print $this->utility->format_money($spby["nominal"]); ?></td>
					</tr>
					<tr>
						<td>TERBILANG</td>
						<td>:</td>
						<td colspan="2"><?php print $this->utility->terbilang($spby["nominal"]); ?></td>
					</tr>
					<tr>
						<td>UNTUK PEMBAYARAN</td>
						<td>:</td>
						<td colspan="2" class="justify"><?php print $spby["deskripsi"]; ?>, Daftar Rincian Penerimaan Terlampir</td>
					</tr>
			</table>
			<table width="100%" style="margin-bottom:20px;" cellpadding="1" cellspacing="0">
					<tr>
						<td>Lunas dibayar, <?php print $this->utility->formatDateIndo($spby["tgl_spby"]); ?></td>
						<td width="20%">&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php print $spby["kab_spby"] ?>, <?php print $this->utility->formatDateIndo($spby["tgl_spby"]); ?></td>
					</tr>
					<tr>
						<td>Bendahara Pengeluaran,</td>
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
						<td class="bold"><?php print $spby["nama_bp"]; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="bold"><?php print $spby["penerima"]; ?></td>
					</tr>
					<tr>
						<td>NIP <?php print $spby["nip_bp"]; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>
							<?php
								if ($spby["nip_penerima"] != "" && $spby["nip_penerima"] != "0" && $spby["nip_penerima"] != "-") {
									print "NIP ".$spby["nip_penerima"];
								}
							?>
						</td>
					</tr>
				</tbody>
			</table>
	
			<table width="100%" cellpadding="1" cellspacing="0" style="border-top:2px solid #000; margin-bottom:20px;">
				<tbody>
					<tr>
						<td class="center font4">&nbsp;</td>
					</tr>
				</tbody>
			</table>
	
			<table width="100%" cellpadding="1" cellspacing="0" style="margin-bottom: 20px;">
				<tbody>
					<tr>
						<td class="center bold">PERHITUNGAN SPD RAMPUNG</td>
					</tr>
				</tbody>
			</table>
	
			<table width="100%" cellpadding="1" cellspacing="0" style="margin-bottom: 35px; ">
				<tbody>
					<tr>
						<td width="20%">&nbsp;</td>
						<td width="60%">
							<table width="100%" cellpadding="0" cellspacing="0" class="paddingTB">
								<tbody>
									<tr>
										<td width="40%">Ditetapkan sejumlah</td>
										<td width="5%">:</td>
										<td width="40%" align="right"><?php print $this->utility->format_money($spby["nominal"]); ?></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>Yang telah dibayar semula</td>
										<td>:</td>
										<td align="right"><?php print $this->utility->format_money($spby["nominal"]); ?></td>
										<td>&nbsp;&nbsp;_</td>
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
						<td width="20%">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="71.5%">&nbsp;</td>
						<td width="28.5%">Mengetahui/Menyetujui :</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>a.n Kuasa Pengguna Anggaran</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Pejabat Pembuat Komitmen</td>
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
						<td class="bold"><?php print $spby["nama_ppk"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>NIP <?php print $spby["nip_ppk"]; ?></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>