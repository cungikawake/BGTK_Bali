<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	require APPPATH .'third_party/Qr/vendor/autoload.php';

	use Endroid\QrCode\Builder\Builder;
	use Endroid\QrCode\Color\Color;
	use Endroid\QrCode\Encoding\Encoding;
	use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
	use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
	use Endroid\QrCode\Label\Font\NotoSans;
	use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
	use Endroid\QrCode\Writer\PngWriter;

	class Qr_code {
		protected $CI;
		
		public function __construct() {
			$this->CI =& get_instance();
		}
		
		public function create ($size = 300, $data, $label = "") {
			
			if ($size <= 100) {
				$logo = 'qr-logo-kemdikbud-20.png';
			}
			else if ($size < 150) {
				$logo = 'qr-logo-kemdikbud-40.png';
			}
			else if ($size < 220) {
				$logo = 'qr-logo-kemdikbud-50.png';
			}
			else if ($size < 300) {
				$logo = 'qr-logo-kemdikbud-60.png';
			}
			else if ($size < 400) {
				$logo = 'qr-logo-kemdikbud-90.png';
			}
			else {
				$logo = 'qr-logo-kemdikbud-140.png';
			}
			
			$result = Builder::create()
			->writer(new PngWriter())
			->writerOptions([])
			->data($data)
			->encoding(new Encoding('UTF-8'))
			->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
			->size($size)
			->margin(0)
			->roundBlockSizeMode(new RoundBlockSizeModeMargin())
			->foregroundColor(new Color(23, 23, 23));
			
			$result = $result->logoPath(APPPATH.'../assets/images/'.$logo);
			
			$result = $result->labelText($label)
			->labelFont(new NotoSans(0))
			->labelAlignment(new LabelAlignmentCenter())
			->build();
			
			$dataUri = $result->getDataUri();
			
			return $dataUri;
		}
	}
?>