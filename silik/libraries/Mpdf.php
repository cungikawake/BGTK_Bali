<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	require APPPATH .'third_party/Mpdf/vendor/autoload.php';
	
	class Mpdf {
		var $CI;
		var $sertifikatFonts;
		
		public function __construct () {
			$this->CI =& get_instance();
     		$this->sertifikatFonts = $this->CI->config->item('sertifikat_fonts');
		}
		
		public function create ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 15,
				'margin_right' => 15,
				'margin_top' => 10,
				'margin_bottom' => 10,
				'margin_header' => 10,
				'margin_footer' => 10
			]);
			
			$mpdf->WriteHTML($html);
			
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output('MyPDF.pdf', 'I');
			}
		}
		
		public function createSPJItem ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 26,
				'margin_right' => 8,
				'margin_top' => 7,
				'margin_bottom' => 7,
				'margin_header' => 10,
				'margin_footer' => 10
			]);
			
			$mpdf->WriteHTML($html);
			
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output($setName.'.pdf', 'I');
			}
		}
		
		
		public function createSPJ ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 26,
				'margin_right' => 8,
				'margin_top' => 7,
				'margin_bottom' => 7,
				'margin_header' => 10,
				'margin_footer' => 10
			]);
			
			//$mpdf->SetDisplayMode('fullpage','two');
			
			$mpdf->WriteHTML($html["spby"]);
			
			
			$mpdf->setHeader();	// Clear headers before adding page
			$mpdf->AddPage('L','','','','',8,8,18,10,18,10);

			$mpdf->WriteHTML($html["daftar_penerimaan"]);
			
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output($setName.'.pdf', 'I');
			}
		}
		
		public function createSpjAdd ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 18,
				'margin_right' => 8,
				'margin_top' => 7,
				'margin_bottom' => 7,
				'margin_header' => 10,
				'margin_footer' => 10
			]);
			
			$mpdf->shrink_tables_to_fit = 1;
			
			if (isset($html["daftar_hadir"])) {
			    $mpdf->WriteHTML($html["daftar_hadir"]);
			}
			
			if (isset($html["daftar_penerimaan_atk"])) {
			    $mpdf->WriteHTML('<pagebreak />');
			    $mpdf->WriteHTML($html["daftar_penerimaan_atk"]);
			}
			
			$setName = "download_";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output($setName.'.pdf', 'I');
			}
		}
		
		public function createSPBy ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 4,
				'margin_right' => 4,
				'margin_top' => 4,
				'margin_bottom' => 4,
				'margin_header' => 4,
				'margin_footer' => 4,
			]);
			
			$mpdf->WriteHTML($html);
			
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output($setName.'.pdf', 'I');
			}
		}
		
		public function createLandscape ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4-L',
				'orientation' => 'L',
				'margin_left' => 9,
				'margin_right' => 9,
				'margin_top' => 11,
				'margin_bottom' => 10,
				'margin_header' => 11,
				'margin_footer' => 10
			]);

			$mpdf->curlAllowUnsafeSslRequests = true;
			
			//$mpdf->keep_table_proportions = true;
			$mpdf->shrink_tables_to_fit = 1;
			
			$mpdf->WriteHTML($html);
			
			$setName = "download_";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output($setName.'.pdf', 'I');
			}
		}
		
		public function createSPDPaketMeeting ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 26,
				'margin_right' => 10,
				'margin_top' => 10,
				'margin_bottom' => 15,
				'margin_header' => 10,
				'margin_footer' => 10
			]);

			$mpdf->SetDisplayMode('fullpage','two');

			$mpdf->mirrorMargins = 1;
			
			$mpdf->WriteHTML($html["spd_depan"]);


			$mpdf->setHeader();	// Clear headers before adding page
			$mpdf->AddPage('L','','','','',6,6,18,10,18,10);

			$mpdf->WriteHTML($html["spd_belakang"]);

			$mpdf->Output('mpdf.pdf', 'I');
		}
		
		public function createSertifikat ($html, $name = false, $download = true) {
			// Add these headers before generating PDF
			header('X-Frame-Options: SAMEORIGIN');
			header('X-Content-Type-Options: nosniff');
			header('Referrer-Policy: strict-origin-when-cross-origin');

			$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];

			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];
			
			$sertificateFonts = array();
			
			if (!empty($this->sertifikatFonts)) {
				foreach ($this->sertifikatFonts as $font => $fontFile) {
					if ($fontFile[0]) {
						$sertificateFonts[$font] = array(
							"R" => $fontFile[1]
						);
					}
				}
			}
			
			
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4-L',
				'orientation' => 'L',
				'margin_left' => 0,
				'margin_right' => 0,
				'margin_top' => 0,
				'margin_bottom' => 0,
				'margin_header' => 0,
				'margin_footer' => 0,
				'dpi' => 300,
				'img_dpi' => 300,
				'fontDir' => array_merge($fontDirs, [APPPATH."../assets/fonts/sertifikat/"]),
				'fontdata' => $fontData + $sertificateFonts
			]);
			
			$mpdf->WriteHTML($html);
			
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output('sertifikat.pdf', 'I');
			}
		}

		//for generate 2 page
		public function createSertifikat_v2 ($html, $html2, $name = false, $download = true) {
			header('X-Frame-Options: SAMEORIGIN');
			header('X-Content-Type-Options: nosniff');
			header('Referrer-Policy: strict-origin-when-cross-origin');
			
			$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];

			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];
			
			$sertificateFonts = array();
			
			if (!empty($this->sertifikatFonts)) {
				foreach ($this->sertifikatFonts as $font => $fontFile) {
					if ($fontFile[0]) {
						$sertificateFonts[$font] = array(
							"R" => $fontFile[1]
						);
					}
				}
			}
			
			
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4-L',
				'orientation' => 'L',
				'margin_left' => 0,
				'margin_right' => 0,
				'margin_top' => 0,
				'margin_bottom' => 0,
				'margin_header' => 0,
				'margin_footer' => 0,
				'dpi' => 300,
				'img_dpi' => 300,
				'fontDir' => array_merge($fontDirs, [APPPATH."../assets/fonts/sertifikat/"]),
				'fontdata' => $fontData + $sertificateFonts
			]);
			
			$mpdf->WriteHTML($html);

			$mpdf->AddPage();

			$mpdf->WriteHTML($html2);
			
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output('sertifikat.pdf', 'I');
			}
		}
		
		public function createSertifikat2 ($data, $name = false, $download = true) {
			
			$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];

			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];
			
			$sertificateFonts = array();
			
			if (!empty($this->sertifikatFonts)) {
				foreach ($this->sertifikatFonts as $font => $fontFile) {
					if ($fontFile[0]) {
						$sertificateFonts[$font] = array(
							"R" => $fontFile[1]
						);
					}
				}
			}
			
			
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4-L',
				'orientation' => 'L',
				'margin_left' => 0,
				'margin_right' => 0,
				'margin_top' => 0,
				'margin_bottom' => 0,
				'margin_header' => 0,
				'margin_footer' => 0,
				'dpi' => 300,
				'img_dpi' => 300,
				'fontDir' => array_merge($fontDirs, [APPPATH."../assets/fonts/sertifikat/"]),
				'fontdata' => $fontData + $sertificateFonts
			]);
			
			$html = '<body style="background-image: url(\''.$data["image_path"].'\'); background-image-resize:6"></body>';
			
			$mpdf->WriteHTML($html);
			
			// Define Scale
			$sizeRiil = 3508;
			$sizeSkala = 700;
			$sizeRiilY = 2480;
			$sizeSkalaY = 495;
			
			$fontSkala = ($sizeRiil/$sizeSkala);
			$skala = ($sizeRiil/$sizeSkala)*0.084;
			$skalaY = ($sizeRiilY/$sizeSkalaY)*0.08;
			$skalaW = ($sizeRiil/$sizeSkala)*0.0847;
			$skalaFont = 1.20;
			
			// Nomor Sertifikat
			$nomor_x = ($data["nomor_x"] * $skala);
			$nomor_y = ($data["nomor_y"] * $skalaY);
			$nomor_w = $data["nomor_w"] * $skalaW;
			$nomor_size = $data["nomor_size"] * $skalaFont;
			$nomor_align = $data["nomor_align"];
			$nomor = $data["nomor"];
			
			if ($nomor_align == "center") {
				$nomor_align = "C";
			}
			else if ($nomor_align == "right") {
				$nomor_align = "R";
			}
			else {
				$nomor_align = "L";
			}
			
			$mpdf->SetFillColor(229,229,229);
			$mpdf->SetFont($data["nomor_font"],'',$nomor_size);
			$mpdf->SetXY($nomor_x, ($nomor_size*$skalaY/2) + $nomor_y);
			$mpdf->WriteCell($nomor_w,0,$nomor,0,0,$nomor_align,1);
			
			
			// Nama Sertifikat
			$nama_x = ($data["nama_x"] * $skala);
			$nama_y = ($data["nama_y"] * $skalaY);
			$nama_w = $data["nama_w"] * $skalaW;
			$nama_size = $data["nama_size"] * $skalaFont;
			$nama_align = $data["nama_align"];
			
			if ($nama_align == "center") {
				$nama_align = "C";
			}
			else if ($nama_align == "right") {
				$nama_align = "R";
			}
			else {
				$nama_align = "L";
			}
			
			$mpdf->SetFillColor(229,229,229);
			$mpdf->SetFont($data["nama_font"],'',$nama_size);
			$mpdf->SetXY($nama_x, $nama_y);
			$mpdf->WriteCell($nama_w,$data["nama_size"],$data["nama"],0,0,$nama_align,0);
			
			
			// QR Kode
			$qr_code_x = ($data["qr_code_x"] * $skala);
			$qr_code_y = ($data["qr_code_y"] * $skala);
			$mpdf->Image($data["qr_code"], $qr_code_x+19, $qr_code_y+14, (59*$skala), (61*$skala));
			
			
			// Generate
			$setName = "download_sipandu";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output('sertifikat.pdf', 'I');
			}
		}
		
		public function createSPPD ($html, $name = false, $download = true) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 26,
				'margin_right' => 8,
				'margin_top' => 10,
				'margin_bottom' => 10,
				'margin_header' => 10,
				'margin_footer' => 10
			]);
			
			$mpdf->WriteHTML($html);
			
			$setName = "sppd";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output('SPPD.pdf', 'I');
			}
		}
		
		public function createLaporanPerjadin ($perjadin, $name = false, $download = true) {
			
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'A4',
				'margin_left' => 26,
				'margin_right' => 10,
				'margin_top' => 10,
				'margin_bottom' => 15,
				'margin_header' => 10,
				'margin_footer' => 10
			]);
			
			$mpdf->setFooter('{PAGENO}');
			
			if (isset($perjadin["susunan_pertanggungjawaban"])) {
				$mpdf->WriteHTML($perjadin["susunan_pertanggungjawaban"]);
			}
			
			if (isset($perjadin["spd_depan"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
				}
				
				$mpdf->WriteHTML($perjadin["spd_depan"]);
			}
			
			if (isset($perjadin["spd_belakang"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak />');
				}
				
				$mpdf->WriteHTML($perjadin["spd_belakang"]);
			}
			
			if (isset($perjadin["rincian_biaya_perjadin"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
				}
				
				$mpdf->WriteHTML($perjadin["rincian_biaya_perjadin"]);
			}
			
			if (isset($perjadin["daftar_pengeluaran_riil"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak/>');
				}
				
				$mpdf->WriteHTML($perjadin["daftar_pengeluaran_riil"]);
			}
			
			/*if (isset($perjadin["bukti_pengeluaran"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
				}
				
				$pagecount = $mpdf->SetSourceFile($perjadin["bukti_pengeluaran"]);
				for ($i=1; $i<=$pagecount; $i++) {
					$import_page = $mpdf->ImportPage($i);
					$mpdf->UseTemplate($import_page);

					if ($pagecount != $i) {
						$mpdf->AddPage();
					}
				}
			}*/
			
			if (isset($perjadin["surat_pernyataan"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak/>');
				}
				
				$mpdf->WriteHTML($perjadin["surat_pernyataan"]);
			}
			
			if (isset($perjadin["surat_tugas"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak />');
				}
				
				
				$pagecount = $mpdf->SetSourceFile($perjadin["surat_tugas"]);
				for ($i=1; $i<=$pagecount; $i++) {
					$import_page = $mpdf->ImportPage($i);
					$mpdf->UseTemplate($import_page);

					if ($pagecount != $i) {
						$mpdf->AddPage();
					}
				}
			}
			
			if (isset($perjadin["laporan"])) {
				$pageNumber = count($mpdf->pages);
				
				if ($pageNumber > 0) {
					$mpdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
				}
				
				$mpdf->WriteHTML($perjadin["laporan"]);
			}
			
			$setName = "laporan_perjadin";
			
			if ($name) {
				$setName = $name;
			}
			
			if ($download) {
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$mpdf->Output($setName.'.pdf', 'I');
			}
		}
		
		public function createAmplop ($html, $setName = "Amplop") {
			$mpdf = new \Mpdf\Mpdf(['format' => [110, 232], 'orientation' => 'L', 'margin_header' => 9, 'margin_footer' => 11, "margin_left"=> 30, "margin_right"=> 20]);
			$mpdf->SetHTMLFooter('<table cellpadding="0" cellspacing="0"><tr><td><img src="'.base_url("assets/images/kemdikdasmen-bgtkbali.jpg").'" width="200px" style="margin-right:7px;" /></td><td style="font-size:12px;color:#666; border-left:1px solid #666">&nbsp;&nbsp;&nbsp;&nbsp;<i>"Satya, Widya, Wibawa"</i></td></tr></table>');
			$mpdf->WriteHTML($html);
			$mpdf->Output($setName.'.pdf', 'I');
		}
	}