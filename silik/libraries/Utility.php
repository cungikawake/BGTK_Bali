<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Utility {
		protected $CI;
		
		public function __construct() {
			$this->CI =& get_instance();
		}
		
		public function penomoran ($val) {
			if ($val < 10) {
				$val = "0000".$val;
			}
			else if ($val < 100) {
				$val = "000".$val;
			}
			else if ($val < 1000) {
				$val = "00".$val;
			}
			else if ($val < 10000) {
				$val = "0".$val;
			}
			
			return $val;
		}
		
		public function lama_tugas ($start, $end) {
			$datediff = strtotime($end) - strtotime($start);

			$diff = round($datediff / (60 * 60 * 24)) + 1;
		
			return $diff;
		}
		
		public function format_number ($value, $dec = 0) {
			$value = number_format($value,$dec,",",".");
			return $value;
		}
		
		public function format_money ($value) {
			$value = "Rp. ".number_format($value,0,",",".");
			return $value;
		}
		
		public function kode_kegiatan () {
			$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$base = strlen($charset);
			$result = '';

			$now = explode(' ', microtime())[1];
			while ($now >= $base){
			    $now = (int) $now;
				$i = $now % $base;
				$result = $charset[$i] . $result;
				$now /= $base;
			}
			return substr($result, -2);
		}
		
		public function kode_registrasi ($sub = -3) {
			$charset = "029501842710582934710967201769356678734345567545546423190887857r6345455671890123457745678901231234567890123456789012345676789090123456789012345678";
			$base = strlen($charset);
			$result = '';

			$now = explode(' ', microtime())[1];
			while ($now >= $base){
				$i = $now % $base;
				$result = $charset[$i] . $result;
				$now /= $base;
			}
			return substr($result, $sub);
		}
		
		public function formatSizeUnits($bytes) {
			if ($bytes >= 1073741824) {
				$bytes = number_format($bytes / 1073741824, 2) . ' Gb';
			}
			elseif ($bytes >= 1048576) {
				$bytes = number_format($bytes / 1048576, 2) . ' Mb';
			}
			elseif ($bytes >= 1024) {
				$bytes = number_format($bytes / 1024, 2) . ' Kb';
			}
			elseif ($bytes > 1) {
				$bytes = $bytes . ' bytes';
			}
			elseif ($bytes == 1) {
				$bytes = $bytes . ' byte';
			}
			else {
				$bytes = '0 bytes';
			}

			return $bytes;
		}
		
		public function formatShortDayMonth ($date) {
			$bulan = array (
				1 => 'Jan',
				2 => 'Feb',
				3 => 'Mar',
				4 => 'Apr',
				5 => 'Mei',
				6 => 'Jun',
				7 => 'Jul',
				8 => 'Agu',
				9 => 'Sep',
				10 => 'Okt',
				11 => 'Nov',
				12 => 'Des'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))];
			
			return $out;
		}
		
		public function formatShortDateIndo ($date) {
			$bulan = array (
				1 => 'Jan',
				2 => 'Feb',
				3 => 'Mar',
				4 => 'Apr',
				5 => 'Mei',
				6 => 'Jun',
				7 => 'Jul',
				8 => 'Agu',
				9 => 'Sep',
				10 => 'Okt',
				11 => 'Nov',
				12 => 'Des'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))].date(" Y", strtotime($date));
			
			return $out;
		}
		
		public function formatDateIndo ($date) {
			$bulan = array (
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))].date(" Y", strtotime($date));
			
			return $out;
		}
		
		public function namaBulan ($number) {
			$bulan = array (
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			
			$out = $bulan[$number];
			
			return $out;
		}
		
		public function formatDateIndo2 ($date) {
			$bulan = array (
				1 => 'Jan',
				2 => 'Feb',
				3 => 'Mar',
				4 => 'Apr',
				5 => 'Mei',
				6 => 'Jun',
				7 => 'Jul',
				8 => 'Agu',
				9 => 'Sep',
				10 => 'Okt',
				11 => 'Nov',
				12 => 'Des'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))].date(" Y", strtotime($date));
			
			return $out;
		}
		
		public function formatDatetimeIndo ($date) {
			$bulan = array (
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))].date(" Y,", strtotime($date)).date(" H:i a", strtotime($date));
			
			return $out;
		}
		
		public function formatDateMonthIndo ($date) {
			$bulan = array (
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))];
			
			return $out;
		}
		
		public function formatDateShortMonthIndo ($date) {
			$bulan = array (
				1 => 'Jan',
				2 => 'Feb',
				3 => 'Mar',
				4 => 'Apr',
				5 => 'Mei',
				6 => 'Jun',
				7 => 'Jul',
				8 => 'Agu',
				9 => 'Sep',
				10 => 'Okt',
				11 => 'Nov',
				12 => 'Des'
			);
			
			$out = date("d ", strtotime($date)).$bulan[date("n", strtotime($date))];
			
			return $out;
		}
		
		public function formatRangeDate ($dateStart, $dateEnd) {
			$date = '';
			
			if (empty($dateEnd) || $dateEnd == "0000-00-00" || $dateEnd == $dateStart) {
				$date = $this->formatDateIndo2($dateStart);
			}
			else {

				$sameMonth = false;
				$sameYear = false;

				if (date("F Y", strtotime($dateStart)) == date("F Y", strtotime($dateEnd))) {
					$sameMonth = true;
				}
				else if (date("Y", strtotime($dateStart)) == date("Y", strtotime($dateEnd))) {
					$sameYear = true;
				}

				if ($sameMonth) {
					$date = date("d", strtotime($dateStart));
					$date .= " s.d ";
					$date .= $this->formatDateIndo2($dateEnd);
				}
				else if ($sameYear) {
					$date = $this->formatDateShortMonthIndo($dateStart);
					$date .= " s.d ";
					$date .= $this->formatDateIndo2($dateEnd);
				}
				else {
					$date = $this->formatDateIndo2($dateStart);
					$date .= " s.d ";
					$date .= $this->formatDateIndo2($dateEnd);
				}
			}
			
			return $date;
		}
		
		public function formatRangeDate2 ($dateStart, $dateEnd) {
			$date = '';
			
			if (empty($dateEnd) || $dateEnd == "0000-00-00" || $dateEnd == $dateStart) {
				$date = $this->formatDateIndo($dateStart);
			}
			else {

				$sameMonth = false;
				$sameYear = false;

				if (date("F Y", strtotime($dateStart)) == date("F Y", strtotime($dateEnd))) {
					$sameMonth = true;
				}
				else if (date("Y", strtotime($dateStart)) == date("Y", strtotime($dateEnd))) {
					$sameYear = true;
				}

				if ($sameMonth) {
					$date = date("d", strtotime($dateStart));
					$date .= " s.d ";
					$date .= $this->formatDateIndo($dateEnd);
				}
				else if ($sameYear) {
					$date = $this->formatDateMonthIndo($dateStart);
					$date .= " s.d ";
					$date .= $this->formatDateIndo($dateEnd);
				}
				else {
					$date = $this->formatDateIndo($dateStart);
					$date .= " s.d ";
					$date .= $this->formatDateIndo($dateEnd);
				}
			}
			
			return $date;
		}
		
		public function formatDetailDate ($date) {
			$text = "";
			
			if (!empty($date)) {
				$groupMonth = array();
				
				foreach ($date as $dt) {
					$dtKey = date("m", strtotime($dt));
					
					if (!isset($groupMonth[$dtKey])) {
						$groupMonth[$dtKey] = array();
					}
					
					$groupMonth[$dtKey][] = $dt;
				}
				
				$groupMonth = array_values($groupMonth);
				$countGroupMont = count($groupMonth);
				
				if ($countGroupMont > 1) {
					foreach ($groupMonth as $groupDateKey => $groupDate) {
						if (!empty($groupDate)) {
							$countGroupDate = count($groupDate);
							
							foreach ($groupDate as $dtKey => $dt) {
								if ($dtKey == ($countGroupDate-1) && $groupDateKey == ($countGroupMont-1)) {
									$text .= " dan ";
									$text .= $this->formatDateShortMonthIndo($dt);
									$text .= date(" Y", strtotime($dt));
								}
								else {
									if (!empty($text)) {
										$text .= ", ";
									}
									
									$text .= $this->formatDateShortMonthIndo($dt);
								}
							}
						}
					}
				}
				else {
					foreach ($groupMonth as $groupDate) {
						if (!empty($groupDate)) {
							$countGroupDate = count($groupDate);
							
							foreach ($groupDate as $dtKey => $dt) {
								if ($dtKey == ($countGroupDate-1)) {
									$text .= " dan ";
									$text .= $this->formatDateShortMonthIndo($dt);
									$text .= date(" Y", strtotime($dt));
								}
								else {
									if (!empty($text)) {
										$text .= ", ";
									}
									
									$text .= date("d", strtotime($dt));
								}
							}
						}
					}
				}
			}
			
			return $text;
		}
		
		public function formatDay ($tgl) {
			$date = '';
			
			$day = array(
				1 => "Senin",
				2 => "Selasa",
				3 => "Rabu",
				4 => "Kamis",
				5 => "Jumat",
				6 => "Sabtu",
				7 => "Minggu",
			);
			
			$date = $day[date("N", strtotime($tgl))];
			
			
			return $date;
		}

		public function formatDayDate ($tgl) {
			$date = '';
			
			$day = array(
				1 => "Senin",
				2 => "Selasa",
				3 => "Rabu",
				4 => "Kamis",
				5 => "Jumat",
				6 => "Sabtu",
				7 => "Minggu",
			);
			
			$date = $day[date("N", strtotime($tgl))].", ".$this->formatShortDateIndo($tgl);
			
			
			return $date;
		}
		
		public function formatRangeDay ($dateStart, $dateEnd) {
			$date = '';
			
			$day = array(
				1 => "Senin",
				2 => "Selasa",
				3 => "Rabu",
				4 => "Kamis",
				5 => "Jumat",
				6 => "Sabtu",
				7 => "Minggu",
			);
			
			if (empty($dateEnd) || $dateEnd == "0000-00-00" || $dateEnd == $dateStart) {
				$date = $day[date("N", strtotime($dateStart))];
			}
			else {
				$date = $day[date("N", strtotime($dateStart))];
				$date .= " s.d ";
				$date .= $day[date("N", strtotime($dateEnd))];
			}
			
			return $date;
		}
		
		public function resize_image($file, $w, $h=false, $crop=false) {
			list($width, $height) = getimagesize($file);
			$r = $width / $height;
			if ($crop) {
				if ($width > $height) {
					$width = ceil($width-($width*abs($r-$w/$h)));
				} else {
					$height = ceil($height-($height*abs($r-$w/$h)));
				}
				$newwidth = $w;
				$newheight = $h;
			} else {
				if ($h) {
					if ($w/$h > $r) {
						$newwidth = $h*$r;
						$newheight = $h;
					} else {
						$newheight = $w/$r;
						$newwidth = $w;
					}
				}
				else {
					$newheight = $w/$r;
					$newwidth = $w;
				}
			}
			
			$newwidth = (int) $newwidth;
			$newheight = (int) $newheight;
			
			$src = imagecreatefrompng($file);
			$dst = imagecreatetruecolor($newwidth, $newheight);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			return $dst;
		}
		
		function hasUserAccess ($section, $item) {
			if (isset($_SESSION["user"]["akses"][$section][$item]) && $_SESSION["user"]["akses"][$section][$item]) {
				return true;	
			}
			else {
				return false;
			}
		}
		
		function deleteTtd ($kegiatan, $target) {
			$dir = APPPATH . "../assets/ttd/".$_SESSION["tahun_anggaran"]."/".$kegiatan; // Full Path
			
			if (!empty($target)) {
				$file = $dir."/ttd-".$target.".png"; // Full Path
				
				if (file_exists($file)) {
					unlink($file);
				}
			}

			if ($files = glob($dir . "/*")) {
				
			} else {
				if( is_dir($dir) ) rmdir( $dir );
			}
		}
		
		function deleteSurTug ($kegiatan, $target) {
			$dir = APPPATH . "../assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/".$kegiatan;
			
			if (!empty($target)) {
				$file = $dir."/".$target; // Full Path

				if (file_exists($file)) {
					unlink($file);
				}
			}
			
			if ($files = glob($dir . "/*")) {
				
			} else {
				if( is_dir($dir) ) rmdir( $dir );
			}
		}
		
		function getHAINumber ($id) {
			$no = "HAI-";
			
			if ($id < 10) {
				$no .= "0000".$id;
			}
			else if ($id < 100) {
				$no .= "000".$id;
			}
			else if ($id < 1000) {
				$no .= "00".$id;
			}
			else if ($id < 10000) {
				$no .= "0".$id;
			}
			else {
				$no .= $id;
			}
			
			return $no;
		}
		
		function penyebut($nilai) {
			$nilai = abs($nilai);
			$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
			$temp = "";
			if ($nilai < 12) {
				$temp = " ". $huruf[$nilai];
			} else if ($nilai <20) {
				$temp = $this->penyebut($nilai - 10). " belas";
			} else if ($nilai < 100) {
				$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
			} else if ($nilai < 200) {
				$temp = " seratus" . $this->penyebut($nilai - 100);
			} else if ($nilai < 1000) {
				$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
			} else if ($nilai < 2000) {
				$temp = " seribu" . $this->penyebut($nilai - 1000);
			} else if ($nilai < 1000000) {
				$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
			} else if ($nilai < 1000000000) {
				$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
			} else if ($nilai < 1000000000000) {
				$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
			} else if ($nilai < 1000000000000000) {
				$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
			}     
			return $temp;
		}
	 
		function terbilang($nilai) {
			if($nilai<0) {
				$hasil = "minus ". trim($this->penyebut($nilai));
			} else {
				$hasil = trim($this->penyebut($nilai));
			}     		
			return ucwords($hasil." rupiah");
		}

		function angka_huruf($nilai) {
			if($nilai<0) {
				$hasil = "minus ". trim($this->penyebut($nilai));
			} else {
				$hasil = trim($this->penyebut($nilai));
			}     		
			return ucwords($hasil);
		}
		
		function persentasePajak ($npwp, $golongan) {
			$out = 0;
			
			if (!empty($golongan) && $golongan != "-") {
				if (strpos($golongan, "IV") !== false) {
					$out = 15;
				}
				else if (strpos($golongan, "III/") !== false) {
					$out = 5;
				}
			}
			else {
				if (!empty($npwp)) {
					$out = 5;
				}
				else {
					$out = 6;
				}
			}
			
			return $out;
		}

		function generateSlug($str) { 
			$str = strtolower($str); 
			$str = str_replace(' ', '_', $str); 
			$str = preg_replace('/[^a-z0-9_]/', '', $str); 
	
			return $str;
		}

		function getUserPhoto ($id = false) {
			if (!$id) {
				$user = $_SESSION["user"];
				$biodata = $_SESSION["biodata"];
				$id = $user["id"];
			}
			else {
				$this->CI->load->model("user_model");
				$this->CI->load->model("biodata_model");

				$user = $this->CI->user_model->getUserById($id);

				if (!empty($user)) {
					$id = $user["id"];
					$biodataId = $user["sync_biodata"];
					$biodata = $this->CI->biodata_model->getBiodataById($biodataId);
				}
				else {
					$id = 0;
					$biodata = array();
				}
			}
			
			$photoPath = "assets/user_profile/profile_".$id.".png";
						
			if (file_exists(APPPATH."../".$photoPath)) {
				$photo = base_url($photoPath);
			}
			elseif ($biodata["jenis_kelamin"] == "Laki-laki"){
				$photo = base_url("assets/images/user/avatar-2.jpg");
			}
			else {
				$photo = base_url("assets/images/user/avatar-1.jpg");
			}

			if (isset($_SESSION["token"])) {
				$photo = $photo."?v=".$_SESSION["token"];
			}

			return $photo;
		}
	}
?>