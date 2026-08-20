<?php
	/* SKALA 
	 * riil width 3508
	 * riil height 2480
	 * peta width 700
	 * peta height 495
	 * skala 5.01142857
	*/
	
	$fonts = $this->config->item("sertifikat_fonts");

	$koordinat = json_decode($sertifikat["koordinat"], true);
	
	$sizeRiil = 3508;
	$sizeSkala = 698;
	$skala = $sizeRiil/$sizeSkala;
?>
<style type="text/css">
	<?php
		foreach ($fonts as $font => $fontFile) {
			if ($fontFile[0]) {
	?>
				@font-face {
					font-family: "<?php print $font; ?>";
					src: url("<?php print base_url("/assets/fonts/sertifikat/".$fontFile[1]); ?>");
				}

	<?php
			}
		}
	?>
	.cover {
		height: 100%;
		background: url('<?php print base_url("assets/images/sertifikat/".$sertifikat["gambar"]); ?>');
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		position: relative;
	}
	.no {
		position: absolute;
		padding: 20px;
		display: inline-block;
		color: rgba(0,0,0,0.5);
		float: left;
	}
	
	.nomor-registrasi {
		display: inline-block;
		position: absolute;
		margin-left: <?php print $koordinat["nomor_registrasi_x"]*$skala; ?>px;
		font-family: '<?php print $koordinat["nomor_registrasi_font"]; ?>';
		font-size: <?php print $koordinat["nomor_registrasi_size"]*$skala; ?>px;
		width: <?php print $koordinat["nomor_registrasi_w"]*$skala; ?>px;
		text-align: <?php print $koordinat["nomor_registrasi_align"]; ?>;;
		margin-top:<?php print ($koordinat["nomor_registrasi_y"]*$skala) - 100; ?>px;
	}
	.nama-peserta {
		display: inline-block;
		position: absolute;
		margin-top: <?php print ($koordinat["nama_peserta_y"]*$skala)-($koordinat["nomor_registrasi_y"]*$skala)-($koordinat["nomor_registrasi_size"]*$skala)-30; ?>px;
		margin-left: <?php print $koordinat["nama_peserta_x"]*$skala; ?>px;
		font-family: '<?php print $koordinat["nama_peserta_font"]; ?>';
		font-size: <?php print $koordinat["nama_peserta_size"]*$skala; ?>px;
		width: <?php print $koordinat["nama_peserta_w"]*$skala; ?>px;
		text-align: <?php print $koordinat["nama_peserta_align"]; ?>;
	}
	
	<?php
		$sizeNomorPeserta = $koordinat["nomor_registrasi_size"]*$skala;
		$topNomorPeserta = $koordinat["nomor_registrasi_y"]*$skala;
		$sizeNamaPeserta = $koordinat["nama_peserta_size"]*$skala;
		$topNamaPeserta = $koordinat["nama_peserta_y"]*$skala;
	
		$top0 = ($koordinat["qr_code_y"]*$skala) - $sizeNamaPeserta - $topNamaPeserta - $sizeNomorPeserta - $topNomorPeserta + 835;
	?>
	
	.qr-code {
		position: absolute;
		margin-left: <?php print $koordinat["qr_code_x"]*$skala; ?>px;
		margin-top:<?php print $top0; ?>px;
	}
</style>
<div class="cover">
	<div class="no">&nbsp;&nbsp;&nbsp;</div>
	<div class="nomor-registrasi"><?php print $person["kode"]; ?>/B7.14/Cert/2022</div>
	<div class="nama-peserta" style="font-family: '<?php print $koordinat["nama_peserta_font"]; ?>';"><?php print $person["nama"]; ?></div>
	<?php
		if (isset($_GET["test"]) && $_GET["test"] == "1") {
	?>
		<img class="qr-code" src="<?php print $qr_code; ?>" />
	<?php
		}
	?>
</div>
