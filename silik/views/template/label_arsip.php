<html>
<head>
	<title>Label Arsip</title>
</head>	
<body style="background:url('/assets/images/arsip-background-v2.png') no-repeat center center cover;padding:0;margin:0;">
	
	<style type="text/css">
		td { 
			vertical-align:top; 
			font-size:16px; 
			font-family: 'tahoma'; 
		}
		.label-kode-arsip { 
			border: 1px solid #0154b3;
			background-color: #0154b3;
			padding: 5px;
			color: #fff;
			font-size: 20px;
			font-weight: bold;
		}
		.kode-arsip {
			border:2px solid #0052b0;
			font-size: 30px; 
			font-weight: bold;
			padding: 20px;
		}
		.detail-arsip {
			border-top: 1px solid #0154b3;
			border-left: 1px solid #0154b3;
			border-right: 1px solid #0154b3;
		}
		.detail-arsip td {
			padding: 10px 12px;
			border-bottom: 1px solid #0154b3;
		}
		.petunjuk-title {
			color: #012c5f;
			font-weight: bold;
			margin-bottom: 10px;
		}
		.petunjukli {
			line-height: 1.5;
			margin-bottom: 10px;
			font-size: 14px;
		}
	</style>

	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td style="padding-left: 50px;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="center" style="padding-top: 70px;font-size: 34px; font-weight: bold; color:#012c5f;">ARSIP FISIK</td>
					</tr>
					<tr>
						<td align="center" style="padding-top: 10px;font-size: 24px; font-weight: bold; color:#012c5f;">
							Balai Guru Dan Tenaga Kependidikan<br />Provinsi Bali
						</td>
					</tr>
					<tr>
						<td align="center" style="padding-top: 50px;">
							<table cellpadding="0" cellspacing="0" width="30%">
								<tr>
									<td align="center" class="label-kode-arsip">
										Kode Arsip
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" class="kode-arsip">
							<?php print $kode_arsip; ?>
						</td>
					</tr>
				</table>
				<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 50px; margin-bottom: 50px;">
					<tr>
						<td align="center">
							<table cellpadding="0" cellspacing="0" width="36%">
								<tr>
									<td align="center" class="label-kode-arsip">
										Rincian Arsip
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="detail-arsip" width="100%">
							<table cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td width="29%">Nama Arsip</td>
									<td width="5%">:</td>
									<td><?php print $arsip["nama"]; ?></td>
								</tr>
								<tr>
									<td>Jenis Arsip</td>
									<td>:</td>
									<td><?php print $arsip["jenis_berkas"]; ?></td>
								</tr>
								<tr>
									<td>Keamanan dan Akses</td>
									<td>:</td>
									<td><?php print $arsip["akses"]; ?></td>
								</tr>
								<tr>
									<td>Pencipta Arsip</td>
									<td>:</td>
									<td><?php print $pencipta["nama"]; ?></td>
								</tr>
								<tr>
									<td>Tahun Arsip</td>
									<td>:</td>
									<td><?php print date("Y", strtotime($arsip["dibuat_tgl"])); ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="130px" align="center" style="font-size:12px;">
							<img src="<?php print $qr_code; ?>" width="120" height="120" />
						</td>
						<td style="padding-left:25px;font-size:14px;line-height:1.5;">
							<div class="petunjuk-title">Petunjuk Penggunaan</div>
							<ul class="petunjuk">
								<li class="petunjukli">&nbsp;Tempel label pada bagian akhir laporan <br />&nbsp;&nbsp;&nbsp;&nbsp;atau bagian depan bantek</li>
								<li class="petunjukli">&nbsp;Gunakan kode arsip untuk pencarian cepat</li>
								<li class="petunjukli">&nbsp;Pindai QR Code untuk informasi arsip </li>
							</ul>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
