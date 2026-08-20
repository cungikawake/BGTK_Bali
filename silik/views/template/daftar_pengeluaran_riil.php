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
	.dpr .noborderright {border-right: none;}
</style>
<table class="dpr" width="100%" cellpadding="0" cellspacing="0">
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
			
			<table width="100%" style="margin-bottom:15px;">
				<tr>
					<td class="center font16 bold underline">DAFTAR PENGELUARAN RIIL</td>
				</tr>
			</table>

			<table width="100%" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3">Yang bertanda tangan dibawah ini :</td>
				</tr>
				<tr>
					<td width="12%" style="padding-left:28px;padding-top:5px;">Nama</td>
					<td width="3%">:</td>
					<td style="padding-top:5px;"><?php print $spj_item["nama"]; ?></td>
				</tr>
				<tr>
					<td style="padding-left:28px;">NIP</td>
					<td width="3%">:</td>
					<td><?php if (!empty($spj_item["nip"])) { print $spj_item["nip"]; } ?></td>
				</tr>
				<tr>
					<td style="padding-left:28px;">Jabatan</td>
					<td width="3%">:</td>
					<td><?php print $spj_item["jabatan"]; ?> <?php print $spj_item["unit_kerja"]; ?></td>
				</tr>
			</table>

			<table width="100%" style="margin-bottom:15px;" cellpadding="0" cellspacing="0">
				<tr>
					<td class="justify">Berdasarkan Surat Perjalanan Dinas (SPD) Nomor: <?php print $spj_item["no_spd"]; ?> tanggal <?php print $this->utility->formatDateIndo($spj_item["tgl_surat"]); ?>, dengan ini kami menyatakan dengan sesungguhnya bahwa: </td>
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
									<td class="center bold bb" colspan="2" width="70%">Uraian</td>
									<td class="center bold bb">Jumlah</td>
								</tr>
								<tr class="noborbot">
									<td style="font-size: 2px;">&nbsp;</td>
									<td style="font-size: 2px;" colspan="2">&nbsp;</td>
									<td style="font-size: 2px;">&nbsp;</td>
								</tr>
								<?php
									$i = 0;
									$total = 0;
								?>
								
								<?php
									if ((!empty($spj_item["taksi_berangkat"]) && $spj_item["dpr_taksi_berangkat"]) || (!empty($spj_item["taksi_pulang"]) && $spj_item["dpr_taksi_pulang"])) {
										$i++;
										
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td class="noborderright">
												<?php
													if (!empty($spj_item["taksi_berangkat"]) && $spj_item["dpr_taksi_berangkat"]) {
														print "<div>Taksi</div>";
														$total += $spj_item["taksi_berangkat"];
													}
										
													if (!empty($spj_item["taksi_pulang"]) && $spj_item["dpr_taksi_pulang"]) {
														print "<div>Taksi</div>";
														$total += $spj_item["taksi_pulang"];
													}
												?>
											</td>
											<td>
												<?php
													if (!empty($spj_item["taksi_berangkat"]) && $spj_item["dpr_taksi_berangkat"]) {
														print "<div>".$spj_item["provinsi_asal"]."</div>";
													}
										
													if (!empty($spj_item["taksi_pulang"]) && $spj_item["dpr_taksi_pulang"]) {
														print "<div>".$spj_item["provinsi_tujuan"]."</div>";
													}
												?>
											</td>
											<td class="right">
												<?php
													if (!empty($spj_item["taksi_berangkat"]) && $spj_item["dpr_taksi_berangkat"]) {
														print "<div>".$this->utility->format_money($spj_item["taksi_berangkat"])."</div>";
													}
										
													if (!empty($spj_item["taksi_pulang"]) && $spj_item["dpr_taksi_pulang"]) {
														print "<div>".$this->utility->format_money($spj_item["taksi_pulang"])."</div>";
													}
												?>
											</td>
										</tr>
								<?php
									}
								?>
								
								<?php
									if (!empty($spj_item["transport"]) && $spj_item["dpr_transport"]) {
										$i++;
										
										$lamaTugas = 1;
										
										if (!empty($spj_item["tgl_tugas"])) {
											$lamaTugas = count($spj_item["tgl_tugas"]);
											$total += ($spj_item["transport"]*$lamaTugas);
										}
										else {
											$total += $spj_item["transport"];
										}
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td class="noborderright">Transport Lokal</td>
											<td>
												<div><?php print $spj_item["kab_asal"]; ?> - <?php print $spj_item["kab_tujuan"]; ?> (PP)</div>
												
												<?php
													if (!empty($spj_item["tgl_tugas"])) {
												?>
													<div><?php print $this->utility->format_money($spj_item["transport"])."&nbsp;&nbsp;x&nbsp;&nbsp;".$lamaTugas." kali"; ?></div>
												<?php
													}
												?>
											</td>
											<td class="right">
												<?php
													if (!empty($spj_item["tgl_tugas"])) {
														print $this->utility->format_money($spj_item["transport"]*$lamaTugas);
													}
													else {
														print $this->utility->format_money($spj_item["transport"]);
													}
												?>
											</td>
										</tr>
								<?php
									}
								?>
								
								<?php
									if (!empty($spj_item["transport_lainnya"]) && $spj_item["dpr_transport_lainnya"]) {
										$i++;
										$total += $spj_item["transport_lainnya"];
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td class="noborderright">Transport Lainnya </td>
											<td><?php print $spj_item["keterangan_transport_lainnya"]; ?></td>
											<td class="right"><?php print $this->utility->format_money($spj_item["transport_lainnya"]); ?></td>
										</tr>
								<?php
									}
								?>
								
								<?php
									$lamaNginap = $this->utility->lama_tugas($spj_item["tgl_mulai_tugas"], $spj_item["tgl_selesai_tugas"]) - 1;
								
									if (!empty($spj_item["penginapan"]) && $spj_item["dpr_penginapan"] && !empty($lamaNginap)) {
										$i++;
										$total += $spj_item["penginapan"];
								?>
										<tr class="noborbot">
											<td class="center"><?php print $i; ?></td>
											<td class="noborderright">Penginapan </td>
											<td><?php print $spj_item["keterangan_penginapan"]; ?></td>
											<td class="right"><?php print $this->utility->format_money(($spj_item["penginapan"] * $lamaNginap)); ?></td>
										</tr>
								<?php
									}
								?>
								<tr class="noborbot">
									<td style="font-size: 3px;">&nbsp;</td>
									<td style="font-size: 3px;" colspan="2">&nbsp;</td>
									<td style="font-size: 3px;">&nbsp;</td>
								</tr>
								<tr>
									<td class="center bt">&nbsp;</td>
									<td class="bold center bt" colspan="2">Jumlah</td>
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
					<td width="55%">Mengetahui/Menyutujui :</td>
					<td width="39%"><?php print $spj_item["kab_kuitansi"]; ?>, <?php print $this->utility->formatDateIndo($spj_item["tgl_kuitansi"]); ?></td>
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
					<td>
						<div style="font-weight: bold;"><?php print $spj_item["nama_ppk"]; ?></div>
						NIP <?php print $spj_item["nip_ppk"]; ?>
					</td>
					<td>
						<div style="font-weight: bold;"><?php print $spj_item["nama"]; ?></div>
						<?php if(!empty($spj_item["nip"]) && $spj_item["nip"] != "-" && $spj_item["nip"] != "0") { print "NIP ".$spj_item["nip"]; } ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>