<style type="text/css">
	.rpd td { vertical-align:top; font-size:12px; font-family: 'tahoma'; }
	.rpd .center { text-align:center; }
	.rpd .font16 { font-size:15px; }
	.rpd .bold { font-weight:bold; }
	.rpd .bordered { border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; }
	.rpd .bordered td { border-right:1px solid #000; padding:2px 6px;}
	.rpd .middle { vertical-align:middle; }
	.rpd .font4 { font-size:4px;}
	.rpd .kuitansi { border:2px solid #000; font-size:14px; padding:3px 20px; font-weight:bold; }
	.rpd .justify {text-align:justify; }
	.rpd .font8 { font-size:8px; }
	.rpd .font7 { font-size:7px; }
	.rpd .font6 { font-size:6px; }
	.rpd .text-right { text-align:right; display:block; }
	.rpd .bb { border-bottom:2px solid #000; }
	.rpd .bt { border-top:2px solid #000; }
	.rpd .bt-normal { border-top:1px solid #000; }
</style>
<table class="rpd" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td align="right" style="font-size:7px;"><?php print $item["no_urut"]; ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:15px;margin-left:-10px;margin-right:-10px;">
				<tbody>
					<tr>
						<td width="100%"><img src="<?php print base_url("/assets/images/kemendikdasmen-bgtk_bali.png"); ?>" /></td>
					</tr>
				</tbody>
			</table>

			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="53%">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
						<td width="47%">
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="32%">No. Bukti</td>
									<td style="font-size:11px;">: <?php print $this->utility->penomoran($item["id"])."/KW/PD/".$satker["kode_satker"]."/".date("Y", strtotime($item["tgl_selesai_tugas"])); ?></td>
								</tr>
								<tr>
									<td>Tahun Anggaran</td>
									<td style="font-size:11px;">: 2022</td>
								</tr>
								<tr>
									<td>MAK/Kode</td>
									<td style="font-size:11px;">: <?php print $item["dipa_kegiatan"].".".$item["dipa_kro"].".".$item["dipa_ro"].".".$item["dipa_komponen"].".".$item["dipa_sub_komponen"].".".$item["dipa_akun_transport"]."/".$item["dipa_program"]; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<table style="margin-bottom:6px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td class="kuitansi">KUITANSI</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="border-bottom:2px solid #000; margin-bottom:2px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td width="22%">SUDAH DITERIMA DARI</td>
						<td width="1%">:</td>
						<td width="76%" colspan="2">Kuasa Pengguna Anggaran <?php print $satker["upt"]; ?></td>
					</tr>
					<tr>
						<td>JUMLAH UANG</td>
						<td>:</td>
						<td colspan="2" class="bold">
							<?php
								$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
								$total = $item["pesawat_berangkat"] + $item["pesawat_pulang"] + $item["taksi_berangkat"] + $item["taksi_pulang"] + $item["transport"] + $item["transport_lainnya"] + ($item["uang_harian"]*$lamaTugas) + ($item["penginapan"] * ($lamaTugas-1));
								print $this->utility->format_money($total);
							?>
						</td>
					</tr>
					<tr>
						<td>UNTUK PEMBAYARAN</td>
						<td>:</td>
						<td colspan="2" class="justify"><?php print $item["deskripsi_kuitansi"]; ?>. SPD Terlampir</td>
					</tr>
					<tr>
						<td class="font4">&nbsp;</td>
						<td class="font4">&nbsp;</td>
						<td class="font4">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lunas dibayar, <?php print $this->utility->formatDateIndo($item["tgl_kuitansi"]); ?></td>
						<td><?php print $item["kab_kuitansi"]; ?>, <?php print $this->utility->formatDateIndo($item["tgl_kuitansi"]); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Bendahara Pengeluaran,</td>
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
						<td width="35%"><?php print $item["nama_bp"]; ?></td>
						<td><?php print $item["nama"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>NIP <?php print $item["nip_bp"]; ?></td>
						<td><?php if(!empty($item["nip"])) { print "NIP ".$item["nip"]; } ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:0px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td class="font7 justify">Peraturan Menteri Republik Indonesia Nomor 60/PMK.02/2021 tentang Standar Biaya Masukan Tahun Anggaran 2022, Peraturan Kementerian Keuangan Nomor 113/PMK.05/2012 tentang Perjalanan Dinas Dalam Negeri Bagi Pejabat Negara, Pegawai Negeri dan Pegawai Tidak Tetap, Surat Edaran Dirjen Pelayanan Kesehatan Nomor HK.02.02/1/3065/2021 tentang Batasan Tarif Tertinggi Pemeriksaan Rapid Tes Antigen-SWAB.</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" style="margin-bottom:6px;" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td class="font16 center bold">RINCIAN BIAYA PERJALANAN DINAS</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:4px;">
				<tbody>
					<tr>
						<td width="24%">Lampiran SPD Nomor</td>
						<td>: <?php print $item["no_spd"]; ?></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td>: <?php print $this->utility->formatDateIndo($item["tgl_surat"]); ?></td>
					</tr>
				</tbody>
			</table>
			
			<table width="100%" class="bordered" style="margin-bottom:6px;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="5%" class="bold bb">No</td>
						<td class="bold center bb">Perincian Biaya</td>
						<td class="bold bb center">Jumlah</td>
						<td class="bold bb center">Keterangan</td>
					</tr>
					
					<?php
						$i = 0;
						if (!empty($item["pesawat_berangkat"])) {
							$i++;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td>
									<div>Tiket Pesawat (PP):</div>
									<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $item["kab_asal"]; ?> - <?php print $item["kab_tujuan"]; ?></div>
									<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $item["kab_tujuan"]; ?> - <?php print $item["kab_asal"]; ?></div>
								</td>
								<td align="right">
									<div>&nbsp;</div>
									<div class="text-right"><?php print $this->utility->format_money($item["pesawat_berangkat"]); ?></div>
									<div class="text-right"><?php print $this->utility->format_money($item["pesawat_pulang"]); ?></div>
								</td>
								<td>
									<div>&nbsp;</div>
									<div>&nbsp;</div>
								</td>
							</tr>
					<?php
						}
					?>
					
					<?php
						if (!empty($item["taksi_berangkat"])) {
							$i++;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td>
									<div>Taksi <?php print $item["provinsi_asal"]; ?></div>
									<div>Taksi <?php print $item["provinsi_tujuan"]; ?></div>
								</td>
								<td align="right">
									<div class="text-right"><?php print $this->utility->format_money($item["taksi_berangkat"]); ?></div>
									<div class="text-right"><?php print $this->utility->format_money($item["taksi_pulang"]); ?></div>
								</td>
								<td>
									<div>&nbsp;</div>
									<div>&nbsp;</div>
								</td>
							</tr>
					<?php
						}
					?>
					
					<?php
						if (!empty($item["transport"])) {
							$i++;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td>
									<div>Transport:</div>
									<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transport Lokal (PP) <?php print $item["kab_asal"]; ?> - <?php print $item["kab_tujuan"]; ?></div>
								</td>
								<td align="right">
									<div>&nbsp;</div>
									<div class="text-right"><?php print $this->utility->format_money($item["transport"]); ?></div>
								</td>
								<td>
									<div>&nbsp;</div>
									<div><?php print $item["keterangan_transport"]; ?></div>
								</td>
							</tr>
					<?php
						}
					?>

					<?php
						if (!empty($item["uang_harian"])) {
							$i++;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td>Uang Harian (<?php print $lamaTugas; ?> hari x <?php print $this->utility->format_money($item["uang_harian"]); ?>)</td>
								<td align="right"><?php print $this->utility->format_money(($item["uang_harian"]*$lamaTugas)); ?></td>
								<td><?php print $item["keterangan_uang_harian"]; ?></td>
							</tr>
					<?php
						}
					?>
					
					<?php
						if (!empty($item["penginapan"])) {
							$i++;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td>Penginapan (<?php print $lamaTugas - 1; ?> kali x <?php print $this->utility->format_money($item["penginapan"]); ?>)</td>
								<td align="right"><?php print $this->utility->format_money(($item["penginapan"] * ($lamaTugas - 1))); ?></td>
								<td><?php print $item["keterangan_penginapan"]; ?></td>
							</tr>
					<?php
						}
					?>

					<?php
						if (!empty($item["transport_lainnya"])) {
							$i++;
					?>
							<tr>
								<td class="center"><?php print $i; ?></td>
								<td>
									<div>Transport Lainnya:</div>
								</td>
								<td align="right">
									<div class="text-right"><?php print $this->utility->format_money($item["transport_lainnya"]); ?></div>
								</td>
								<td>
									<div><?php print $item["keterangan_transport_lainnya"]; ?></div>
								</td>
							</tr>
					<?php
						}
					?>
					<tr>
						<td class="bold bt" colspan="2">Jumlah</td>
						<td class="bold bt" align="right"><?php print $this->utility->format_money($total); ?></td>
						<td class="bt">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4" class="bt-normal">Terbilang : <em><?php print $this->utility->terbilang($total); ?></em></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" class="bb" style="margin-bottom: 4px;">
				<tbody>
					<tr>
						<td width="6%">&nbsp;</td>
						<td width="54%">&nbsp;</td>
						<td width="40%"><?php print $item["kab_kuitansi"]; ?>, <?php print $this->utility->formatDateIndo($item["tgl_kuitansi"]); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Telah dibayarkan sejumlah :</td>
						<td>Telah menerima jumlah uang sebesar :</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="bold"><?php print $this->utility->format_money($total); ?></td>
						<td class="bold"><?php print $this->utility->format_money($total); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Bendahara Pengeluaran,</td>
						<td>Yang menerima,</td>
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
						<td><?php print $item["nama_bp"]; ?></td>
						<td><?php print $item["nama"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>NIP <?php print $item["nip_bp"]; ?></td>
						<td><?php if(!empty($item["nip"])) { print "NIP ".$item["nip"]; } ?></td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="1" cellspacing="0" style="margin-bottom: 6px;">
				<tbody>
					<tr>
						<td class="center bold">PERHITUNGAN SPD RAMPUNG</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="1" cellspacing="0">
				<tbody>
					<tr>
						<td width="50%">
							<table cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="50%">Ditetapkan sejumlah</td>
									<td width="2%">:</td>
									<td width="46%" align="right"><?php print $this->utility->format_money($total); ?></td>
									<td width="2%">&nbsp;</td>
								</tr>
								<tr>
									<td>Yang telah dibayar semula</td>
									<td>:</td>
									<td align="right"><?php print $this->utility->format_money($total); ?></td>
									<td>_</td>
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
						<td width="50%">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="71.2%">&nbsp;</td>
						<td width="28.8%">Mengetahui/Menyetujui :</td>
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
						<td><?php print $item["nama_ppk"]; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>NIP <?php print $item["nip_ppk"]; ?></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>