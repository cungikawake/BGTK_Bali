<style type="text/css">
	.dpr td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.dpr .center { text-align:center; }
	.dpr .font10 { font-size:10px; }
	.dpr .font16 { font-size:16px; }
	.dpr .bold { font-weight:bold; }
	.dpr .bordered { border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; }
	.dpr .bordered td { border-bottom:none; border-right:1px solid #000; padding:4px 6px;}
	.dpr .middle { vertical-align:middle; }
	.dpr .font4 { font-size:4px;}
	.dpr .justify { text-align:justify; }
	.dpr .right { text-align:right; }
	.dpr .bordered td.bb {border-bottom: 2px solid #000;}
	.dpr .bt {border-top: 1px solid #000;}
	.dpr .underline { text-decoration: underline; }
</style>
<table class="dpr" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:7px;"><?php print $item["no_urut"]; ?></td>
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
			
			<table width="100%" style="margin-bottom:15px;">
				<tr>
					<td class="center font16 bold underline">DAFTAR PENGELUARAN RIIL</td>
				</tr>
			</table>

			<table width="100%" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">Yang bertanda tangan dibawah ini :</td>
				</tr>
				<tr>
					<td width="12%" style="padding-left:28px;padding-top:5px;">Nama</td>
					<td style="padding-top:5px;">: <?php print $item["nama"]; ?></td>
				</tr>
				<tr>
					<td style="padding-left:28px;">NIP</td>
					<td>: <?php if (!empty($item["nip"])) { print $item["nip"]; } ?></td>
				</tr>
				<tr>
					<td style="padding-left:28px;">Jabatan</td>
					<td>: <?php print $item["jabatan"]; ?> <?php print $item["unit_kerja"]; ?></td>
				</tr>
			</table>

			<table width="100%" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tr>
					<td class="justify">Berdasarkan Surat Perjalanan Dinas (SPD) Nomor: <?php print $item["no_spd"]; ?> tanggal <?php print $this->utility->formatDateIndo($item["tgl_surat"]); ?>, dengan ini kami menyatakan dengan sesungguhnya bahwa: </td>
				</tr>
			</table>

			<table width="100%" style="margin-bottom:40px;" cellpadding="0" cellspacing="0">
				<tr>
					<td width="4%">1. </td>
					<td class="justify">Biaya transport pegawai dan/atau biaya penginapan di bawah ini yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi :</td>
				</tr>
				<tr>
					<td width="4%">&nbsp;</td>
					<td>
						<table width="100%" class="bordered" cellpadding="0" cellspacing="0" style="margin-top:10px; margin-bottom:10px;">
							<tbody>
								<tr>
									<td class="center bold bb" width="5%">No</td>
									<td class="center bold bb" width="70%">Uraian</td>
									<td class="center bold bb">Jumlah</td>
								</tr>
								<tr class="noborbot">
									<td style="font-size: 2px;">&nbsp;</td>
									<td style="font-size: 2px;">&nbsp;</td>
									<td style="font-size: 2px;">&nbsp;</td>
								</tr>
								<?php
									$i = 0;
									$total = 0;
								?>
								
								<?php
									if (!empty($item["taksi_berangkat"])) {
										$i++;
										$total += $item["taksi_berangkat"];
										$total += $item["taksi_pulang"];
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td>
												<div>Taksi <?php print $item["provinsi_asal"]; ?></div>
												<div>Taksi <?php print $item["provinsi_tujuan"]; ?></div>
											</td>
											<td class="right">
												<div><?php print $this->utility->format_money($item["taksi_berangkat"]); ?>
												</div>
												<div><?php print $this->utility->format_money($item["taksi_pulang"]); ?>
												</div>
											</td>
										</tr>
								<?php
									}
								?>
								
								<?php
									if (!empty($item["transport"])) {
										$i++;
										$total += $item["transport"];
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td>Transport Lokal &nbsp;&nbsp;&nbsp;<?php print $item["kab_asal"]; ?> - <?php print $item["kab_tujuan"]; ?> (PP)</td>
											<td class="right"><?php print $this->utility->format_money($item["transport"]); ?></td>
										</tr>
								<?php
									}
								?>
								<?php
									if (!empty($item["transport_lainnya"])) {
										$i++;
										$total += $item["transport_lainnya"];
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td>Transport Lainnya (<?php print $item["keterangan_transport_lainnya"]; ?>)</td>
											<td class="right"><?php print $this->utility->format_money($item["transport_lainnya"]); ?></td>
										</tr>
								<?php
									}
								?>
								<tr class="noborbot">
									<td style="font-size: 3px;">&nbsp;</td>
									<td style="font-size: 3px;">&nbsp;</td>
									<td style="font-size: 3px;">&nbsp;</td>
								</tr>
								<tr>
									<td class="center bt">&nbsp;</td>
									<td class="bold center bt">Jumlah</td>
									<td class="bold right bt"><?php print $this->utility->format_money($total); ?></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>2. </td>
					<td class="justify">Jumlah uang tersebut pada angka 1 diatas benar-benar dikeluarkan untuk pelaksanaan perjalanan dinas dimaksud dan apabila dikemudian hari terdapat kelebihan atas pembayaran, kami bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara.</td>
				</tr>
			</table>

			<table width="100%" cellpadding="1" cellspacing="0" style="margin-top:10px;">
				<tr>
					<td width="4%">&nbsp;</td>
					<td width="64%">Mengetahui/Menyutujui :</td>
					<td width="32%"><?php print $item["kab_kuitansi"]; ?>, <?php print $this->utility->formatDateIndo($item["tgl_kuitansi"]); ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>a.n Kuasa Pengguna Anggaran<br/>Pejabat Pembuat Komitmen</td>
					<td>Pelaksana SPD,</td>
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
					<td class="bold"><?php print $item["nama_ppk"]; ?></td>
					<td class="bold"><?php print $item["nama"]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>NIP <?php print $item["nip_ppk"]; ?></td>
					<td><?php if(!empty($item["nip"])) { print "NIP ".$item["nip"]; } ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>