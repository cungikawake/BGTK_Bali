<style type="text/css">
	.kui-honor td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.kui-honor .center { text-align:center; }
	.kui-honor .font16 { font-size:16px; }
	.kui-honor .bold { font-weight:bold; }
	.kui-honor .bordered { border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; }
	.kui-honor .bordered td { border-right:1px solid #000; padding:2px 6px;}
	.kui-honor .middle { vertical-align:middle; }
	.kui-honor .font4 { font-size:4px;}
	.kui-honor .kuitansi { border:2px solid #000; font-size:16px; padding:4px 20px; font-weight:bold; }
	.kui-honor .justify {text-align:justify; }
	.kui-honor .text-center {text-align:center; }
	.kui-honor .font8 { font-size:8px; }
	.kui-honor .font7 { font-size:7px; }
	.kui-honor .font6 { font-size:6px; }
	.kui-honor .text-right { text-align:right; display:block; }
	.kui-honor .bb { border-bottom:2px solid #000; }
	.kui-honor .bt { border-top:2px solid #000; }
	.kui-honor .bt-normal { border-top:1px solid #000; }
	.kui-honor .paddingTB td {padding: 3px 0; }
</style>

<?php
	$honorBruto = $spj_item["honor"]*$spj_item["vol_honor"];
	$honorNetto = ($honorBruto)-($honorBruto*$spj_item["pajak"]/100);
?>

<table class="kui-honor" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:7px;"><?php print $spj_item["no_urut"]; ?></td>
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
									<td>: <?php //print $this->utility->penomoran($item["id"])."/KW/PD/".$satker["kode_satker"]."/".date("Y", strtotime($item["tgl_selesai_tugas"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/KW/<?php print $satker["kode_satker"]; ?>/<?php print date("Y", strtotime($spj_item["dibuat_tgl"])); ?></td>
								</tr>
								<tr>
									<td>Tahun Anggaran</td>
									<td>: <?php print date("Y", strtotime($spj_item["dibuat_tgl"])); ?></td>
								</tr>
								<tr>
									<td>MAK</td>
									<td>: <?php print $spj_item["dipa_kegiatan"].".".$spj_item["dipa_kro"].".".$spj_item["dipa_ro"].".".$spj_item["dipa_komponen"].".".$spj_item["dipa_sub_komponen"].".".$spj_item["dipa_akun_honor"]; ?></td>
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
			<table width="100%" class="paddingTB" style="margin-bottom: 5px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td width="22%">KEPADA</td>
						<td width="1%">:</td>
						<td width="76%" colspan="2"><?php print $spj_item["nama"]; ?></td>
					</tr>
					<tr>
						<td width="22%">SUDAH DITERIMA DARI</td>
						<td width="1%">:</td>
						<td width="76%" colspan="2">Kuasa Pengguna Anggaran/Pejabat Pembuat Komitmen <?php print $satker["upt"]; ?></td>
					</tr>
					<tr>
						<td>JUMLAH UANG</td>
						<td>:</td>
						<td colspan="2" class="bold"><?php print $this->utility->format_money($honorBruto); ?></td>
					</tr>
					<tr>
						<td>TERBILANG</td>
						<td>:</td>
						<td colspan="2"><?php print $this->utility->terbilang($honorBruto); ?></td>
					</tr>
					<tr>
						<td>UNTUK PEMBAYARAN</td>
						<td>:</td>
						<td colspan="2"><?php print $spj_item["keterangan_honor"]; ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" class="paddingTB" style="margin-bottom: 35px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td width="22%">&nbsp;</td>
						<td width="1%">&nbsp;</td>
						<td colspan="6">dengan perincian sbb:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php print $this->utility->format_money($spj_item["honor"]); ?></td>
						<td width="6%" class="text-center">x</td>
						<td><?php print $spj_item["vol_honor"]." ".$spj_item["satuan_honor"]; ?></td>
						<td width="4%" class="text-center">=</td>
						<td class="text-right"><?php print $this->utility->format_money($honorBruto); ?></td>
						<td width="20%">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php print $this->utility->format_money($honorBruto); ?></td>
						<td class="text-center">x</td>
						<td><?php print $spj_item["pajak"]; ?>% (PPh 21)</td>
						<td class="text-center">=</td>
						<td class="text-right" style="border-bottom: 1px solid #000;"><?php print $this->utility->format_money($honorBruto*($spj_item["pajak"]/100)); ?></td>
						<td>&nbsp;_</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="3" class="bold text-right">Jumlah diterima</td>
						<td>&nbsp;</td>
						<td class="text-right bold"><?php print $this->utility->format_money($honorNetto); ?></td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>
					
			<table width="100%" style="margin-bottom:20px;" cellpadding="1" cellspacing="0">
					<tr>
						<td width="62%">&nbsp;</td>
						<td><?php print $spj_item["kab_kuitansi"]; ?>, <?php print $this->utility->formatDateIndo($spj_item["tgl_kuitansi"]); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Yang menerima,</td>
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
						<td class="bold"><?php print $spj_item["nama"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<?php
								if ($spj_item["nip"] != "" && $spj_item["nip"] != "0" && $spj_item["nip"] != "-") {
									print "NIP ".$spj_item["nip"];
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
	
			<table width="100%" style="margin-bottom:20px;" cellpadding="1" cellspacing="0">
					<tr>
						<td>Setuju dibayar,</td>
						<td width="13%">&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lunas dibayar, <?php print $this->utility->formatDateIndo($spj_item["tgl_kuitansi"]); ?></td>
					</tr>
					<tr>
						<td>A.n Kuasa Pengguna Anggaran</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Bendahara Pengeluaran,</td>
					</tr>
					<tr>
						<td>Pejabat Pembuat Komitmen,</td>
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
						<td class="bold"><?php print $spj_item["nama_ppk"]; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="bold"><?php print $spj_item["nama_bp"]; ?></td>
					</tr>
					<tr>
						<td>NIP <?php print $spj_item["nip_ppk"]; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>NIP <?php print $spj_item["nip_bp"]; ?></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>