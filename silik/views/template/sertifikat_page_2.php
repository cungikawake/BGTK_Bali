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
	$sizeSkala = 700;
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
		background: url('<?php print base_url("assets/images/sertifikat/".$year."/".$sertifikat["gambar_2"]); ?>');
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		position: relative;
	}
 
	.qr-code {
		display: inline-block;
		margin-left: <?php print $koordinat["qr_code_x"]*$skala; ?>px;
		margin-top:<?php print $koordinat["qr_code_y"]*$skala; ?>px;
	}
	
	<?php
		$nomorTop = ($koordinat["nomor_registrasi_y"]*$skala) - ($koordinat["qr_code_y"]*$skala) - 415;
		$pesertaTop = ($koordinat["nama_peserta_y"]*$skala) - $nomorTop - ($koordinat["nomor_registrasi_size"]*$skala) - ($koordinat["qr_code_y"]*$skala) - 442;
	?>
	
	.nomor-registrasi {
		display: inline-block;
		position: absolute;
		margin-left: <?php print $koordinat["nomor_registrasi_x"]*$skala; ?>px;
		font-family: '<?php print $koordinat["nomor_registrasi_font"]; ?>';
		font-size: <?php print $koordinat["nomor_registrasi_size"]*$skala; ?>px;
		width: <?php print $koordinat["nomor_registrasi_w"]*$skala; ?>px;
		text-align: <?php print $koordinat["nomor_registrasi_align"]; ?>;;
		margin-top: <?php print $nomorTop; ?>px;
		line-height: normal;
	}
	.nama-peserta {
		display: inline-block;
		position: absolute;
		margin-top: <?php print $pesertaTop; ?>px;
		margin-left: <?php print $koordinat["nama_peserta_x"]*$skala; ?>px;
		font-family: '<?php print $koordinat["nama_peserta_font"]; ?>';
		font-size: <?php print ($koordinat["nama_peserta_size"]*$skala); ?>px;
		width: <?php print $koordinat["nama_peserta_w"]*$skala; ?>px;
		text-align: <?php print $koordinat["nama_peserta_align"]; ?>;
		line-height: normal;
	}
	
	
</style>
<div class="cover">
	<img class="qr-code" src="<?php print $qr_code; ?>" width="400" height="410" />
</div>
 