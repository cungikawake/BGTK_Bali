<style type="text/css">
	td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.center { text-align:center; }
	.font18 { font-size:18px; }
	.font16 { font-size:16px; }
	.font13 { font-size:13px; }
	.bold { font-weight:bold; }
	.bordered { border-top:1px solid #000; border-left:1px solid #000; }
	.bordered td { border-bottom:1px solid #000; border-right:1px solid #000; padding:4px 6px;}
	.middle { vertical-align:middle; }
	.font4 { font-size:4px;}
	.justify { text-align:justify; }
	.right { text-align:right; }
	.bt {border-top: 1px solid #000;}
	.main-spby tr td { padding-bottom: 7px; }
</style>
<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
	<tr>
		<td width="90%;" height="1060px" style="padding-top: 15px;">
			<table width="100%" style="margin-bottom:15px;">
				<tbody>
					<tr>
						<td width="2%">&nbsp;</td>
						<td width="96%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
						<td width="2%">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="4%">&nbsp;</td>
					<td width="92%">
						<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
							<tr>
								<td class="center font16 bold"><span style="border-bottom: 2px solid #000;">SURAT PERINTAH BAYAR</span></td>
							</tr>
							<tr>
								<td class="center" style="padding-top: 6px;">Tanggal : <?php print $this->utility->formatDateIndo($spby["tgl_spby"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php /*print $this->utility->penomoran($spby["id"]);*/ ?>/PB/<?php print $satker["kode_satker"]; ?>/<?php print date("Y", strtotime($spby["tgl_spby"])); ?></td>
							</tr>
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" style="border-top: 3px double #000; margin-bottom:15px;">
							<tr>
								<td style="padding-top: 20px;">Saya yang bertanda tangan di bawah ini selaku Kuasa Pengguna Anggaran / Pejabat Pembuat Komitmen memerintahkan Bendahara Pengeluaran agar melakukan pembayaran sejumlah:</td>
							</tr>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
							<tr>
								<td width="30%" class="justify bold font13">
									<span style="border-bottom: 1px dotted #000;"><?php print $this->utility->format_money($spby["nominal"]); ?></span>
								</td>
								<td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							</tr>
						</table>
						<table width="100%" cellpadding="15px" cellspacing="0" style="margin-bottom:15px; border: 1px solid #000; border-bottom: 3px double #000;">
							<tr>
								<td class="center bold" style="font-style: italic;font-size: 13px;">
									~~~~ <?php print $this->utility->terbilang($spby["nominal"]); ?> ~~~~
								</td>
							</tr>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0" class="main-spby" style="margin-bottom:25px;">
							<tr>
								<td width="29%">Kepada</td>
								<td width="1%">:</td>
								<td width="71%" class="bold"><span style="border-bottom: 1px dotted #000;"><?php print $spby["penerima"]; ?></span></td>
							</tr>
							<tr>
								<td>Untuk pembayaran</td>
								<td>:</td>
								<td><?php print $spby["deskripsi"]; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Atas dasar:</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>1. Kuitansi/bukti pembelian</td>
								<td>:</td>
								<td><div style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/KW/<?php print $satker["kode_satker"]; ?>/<?php print date("Y", strtotime($spby["tgl_spby"])); ?></div></td>
							</tr>
							<tr>
								<td>2. Nota/bukti penerimaan </td>
								<td>:</td>
								<td><span style="border-bottom: 1px dotted #000;"><?php //print $spby["bukti_penerimaan"]; ?></span></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;barang/jasa (bukti lainnya)</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Dibebankan pada:</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Kegiatan, Output, MAK</td>
								<td>:</td>
								<td><div style="border-bottom: 1px dotted #000;"><?php print $spby["dipa_kegiatan"].".".$spby["dipa_kro"].".".$spby["dipa_ro"].".".$spby["dipa_komponen"].".".$spby["dipa_sub_komponen"].".".$spby["dipa_akun"]; ?></div></td>
							</tr>
							<tr>
								<td>Kode </td>
								<td>:</td>
								<td><span style="border-bottom: 1px dotted #000;"><?php print $spby["dipa_program"]; ?></span></td>
							</tr>
						</table>

						<table cellpadding="0" cellspacing="0" width="100%" style="border-top: 3px double #000;">
							<tr>
								<td width="33%" style="padding-top: 20px;">Setuju/lunas dibayar,</td>
								<td width="38%" style="padding-top: 20px;">Diterima,</td>
								<td width="28%" style="padding-top: 20px;"><?php print $spby["kab_spby"] ?>, <?php print $this->utility->formatDateIndo($spby["tgl_spby"]); ?></td>
							</tr>
							<tr>
								<td>tanggal: <?php print $this->utility->formatDateIndo($spby["tgl_spby"]); ?></td>
								<td>tanggal: <?php print $this->utility->formatDateIndo($spby["tgl_spby"]); ?></td>
								<td>a.n. Kuasa Pengguna Anggaran</td>
							</tr>
							<tr>
								<td>Bendahara Pengeluaran</td>
								<td>Penerima Uang/Uang Muka Kerja</td>
								<td>Pejabat Pembuat Komitmen</td>
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
								<td>
									<span class="bold"><?php print $spby["nama_bp"]; ?></span><br />
									NIP <?php print $spby["nip_bp"]; ?>
								</td>
								<td>
									<span class="bold"><?php print $spby["penerima"]; ?></span><br />
									<?php
										if ($spby["nip_penerima"] != "" && $spby["nip_penerima"] != "0" && $spby["nip_penerima"] != "-") {
											print "NIP ".$spby["nip_penerima"];
										}
									?>
								</td>
								<td>
									<span class="bold"><?php print $spby["nama_ppk"]; ?></span><br />
									NIP <?php print $spby["nip_ppk"]; ?>
								</td>
							</tr>
						</table>
					</td>
					<td width="3%">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>