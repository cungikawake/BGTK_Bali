<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->model("pengaturan_model");
	}
	
	public function index() {
		$this->sertifikat();
	}
	
	public function sertifikat ($year = null, $kode = null, $html = null) {
		$data = array();
		
		if (!empty($year) && !empty($kode)) {
			$this->load->model("sertifikat_model");
			$this->load->model("kegiatan_model");
			$this->load->model("komponen_kegiatan_model");
			$this->load->model("kegiatan_options_model");
			$this->load->model("master_komponen_kegiatan_model");
			
			// Find Short Code
			$shortCodes = explode("-", $kode);

			if (!empty($shortCodes) && isset($shortCodes["1"])) {
				$shortCode = $shortCodes["1"];
				$komponen = $this->master_komponen_kegiatan_model->get_record_by_short_code($shortCode);

				if(empty($komponen)){
					return redirect('404_override');
				}

				$data = array();

				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$data["satker"][$foo["sistem"]] = $foo["value"];
					}
				}

				$data["person"] = $this->komponen_kegiatan_model->getItemByKodeAndYear($komponen->code, $kode, $year);

				if (!empty($data["person"])) {
					$kegiatanId = $data["person"]["kegiatan_id"];
					
					$data["kegiatan"] = $this->kegiatan_model->getKegiatanByIdAndYear($kegiatanId, $year);

					// Generate QR Code
					$this->load->library('qr_code');
					$urlSertifikat = base_url("/download/sertifikat/".$year."/".$kode);
					$data["qr_code"] = $this->qr_code->create(400, $urlSertifikat);
					
					// HACK Sertifikat Nomor to Slash
					$countHype = substr_count ($kode, '-');
	
					if ($countHype == 2) {
						$kodeItem = explode("-", $data["person"]["kode"]);
	
						$kodeBaru = $kodeItem[0]."/".$kodeItem[2].".".$kodeItem[1];
						$data["person"]["kode"] = $kodeBaru;
					}
					
					if (!empty($data["kegiatan"])) {
						$templateId = $this->kegiatan_options_model->getSertifikatIdByKegiatanKomponenYear($data["kegiatan"]["id"], $komponen->code, $year);
						
						if ($templateId) {
							$data["sertifikat"] = $this->sertifikat_model->getByIdAndYear($templateId, $year);
							$data["year"] = $year;

							$html = $this->load->view('template/sertifikat', $data, true);

							if(!empty($data["sertifikat"]['gambar_2'])){
								$html2 = $this->load->view('template/sertifikat_page_2', $data, true);
								$this->mpdf->createSertifikat_v2($html,$html2, "sertifikat", false);
							}else{
								$this->mpdf->createSertifikat($html, "sertifikat", false);
								//print $html;
								//exit();
							}
								 
						}
					}
				}else{
					$this->load->view('/frontend/sertifikat/download', $data);	
				}

			}else{
				$this->load->view('/frontend/sertifikat/download', $data);	
			}
		}
		else {
			$this->load->view('/frontend/sertifikat/download', $data);	
		}
	}
	
	public function table_sertifikat () {
		$html = "<div class='alert alert-danger' style='text-align:center;'>Anda belum memiliki sertifikat</div>";

		if (isset($_POST["nik"]) & !empty($_POST["nik"]) && isset($_POST["captchaToken"]) & !empty($_POST["captchaToken"])) {
			
			$token = $_POST['captchaToken'];
			$action = $_POST['captchaAction'];

			// call curl to POST request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => "6LfSQ7MqAAAAAFMlRmECdicvPVqmAQXff6JJqF2O", 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);

			// verify the response
			if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
				$this->load->model("kegiatan_model");
				$this->load->model("komponen_kegiatan_model");
				$this->load->model("kegiatan_options_model");
				$this->load->model("master_komponen_kegiatan_model");
				
				$data = array();
				$lookupIdKegiatan = array();
				$lookupIdKegiatanKomponen = array();
				$lookupMasterKomponen = array();

				$masterKomponen = $this->master_komponen_kegiatan_model->get_all_records();

				if (!empty($masterKomponen)) {
					foreach ($masterKomponen as $kom) {
						$lookupMasterKomponen[$kom->code] = array();
						$lookupMasterKomponen[$kom->code]["id"] = $kom->id;
						$lookupMasterKomponen[$kom->code]["name"] = $kom->name;
					}
				}

				$item = $this->komponen_kegiatan_model->getItemByNikAndYear($_POST["nik"], $_POST["year"]);

				if (!empty($item)) {
					foreach ($item as $komponen => $foo) {
						foreach ($foo as $boo) {
							if (isset($boo["kegiatan_id"]) && !empty($boo["kegiatan_id"]) && isset($komponen) && !empty($komponen) && isset($_POST["year"]) && !empty($_POST["year"])) {
								$kegiatanOptions = $this->kegiatan_options_model->getByKegiatanKomponenAndYear($boo["kegiatan_id"], $komponen, $_POST["year"]);

								if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
									foreach ($kegiatanOptions as $ops) {
										$boo[$ops["key"]] = $ops["value"];
									}
								}

								$boo["jabatan_kegiatan"] = $lookupMasterKomponen[$komponen]["name"];

								$data["sertifikats"][] = $boo;
								$lookupIdKegiatan[] = $boo["kegiatan_id"];
							}
						}
					}
				}
				

				if (!empty($data)) {
					$lookupIdKegiatan = array_unique($lookupIdKegiatan);
					$data["kegiatan"] = $this->kegiatan_model->getKegiatanByIdsAndYear($lookupIdKegiatan, $_POST["year"]);


					$html = $this->load->view('/frontend/sertifikat/table_download', $data, true);
				}
			}
			else {
				$html = "<div class='alert alert-warning' style='text-align:center;'>Protect by reCAPTCHA ~ Contact Developer</div>";
			}
		}
		
		print $html;
	}
	
	public function sppd ($code_komponen, $kegiatanId = "", $download = null) {
		$this->load->model("kegiatan_model");
		$this->load->model("kegiatan_options_model");
		
		$data = array();
		$data["kegiatan_id"] = $kegiatanId;
		$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);

		// Pejabat Lokasi
		$data["lokasi"] = array(
			"unit_kerja" => "", 
			"nama" => "", 
			"nip" => "", 
			"jabatan" => ""
		);

		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}

		$kegiatanOptions = $this->kegiatan_options_model->get($kegiatanId, $code_komponen);

		if (!empty($kegiatanOptions)) {
			foreach ($kegiatanOptions as $kegiatanOption) {
				if ($kegiatanOption["key"] == "spd_satker") {
					$data["lokasi"]["unit_kerja"] = $kegiatanOption["value"];
				}

				if ($kegiatanOption["key"] == "spd_jabatan") {
					$data["lokasi"]["jabatan"] = $kegiatanOption["value"];
				}

				if ($kegiatanOption["key"] == "spd_nip") {
					$data["lokasi"]["nip"] = $kegiatanOption["value"];
				}

				if ($kegiatanOption["key"] == "spd_nama") {
					$data["lokasi"]["nama"] = $kegiatanOption["value"];
				}
			}
		}

		if ($download == "execute") {
			if (empty($kegiatanId)) {
				$this->load->view('frontend/errors/logo');
			}
			else {

				if (empty($data["kegiatan"])) {
					$this->load->view('frontend/errors/logo');
				}
				else {
					if (empty($data["kegiatan"]["kab_tempat_kegiatan"])) {
						$data["kegiatan"]["kab_tempat_kegiatan"] = "Denpasar";
					}
					
					$dataPeserta = array();
					$dataPeserta["kab"] = "";
					$dataPeserta["nama"] = "";
					$dataPeserta["unit_kerja"] = "";
					$dataPeserta["jabatan"] = "";
					$dataPeserta["nip"] = "";
					
					if (isset($_GET["unit_kerja"]) && !empty($_GET["unit_kerja"])) {
						$dataPeserta["unit_kerja"] = $_GET["unit_kerja"];
					}
					
					if (isset($_GET["kab_unit_kerja"]) && !empty($_GET["kab_unit_kerja"])) {
						$dataPeserta["kab"] = $_GET["kab_unit_kerja"];
					}
					
					if (isset($_GET["nama"]) && !empty($_GET["nama"])) {
						$dataPeserta["nama"] = $_GET["nama"];
					}
					
					if (isset($_GET["jabatan"]) && !empty($_GET["jabatan"])) {
						$dataPeserta["jabatan"] = $_GET["jabatan"];
					}
					
					if (isset($_GET["nip"]) && !empty($_GET["nip"])) {
						$dataPeserta["nip"] = $_GET["nip"];
					}
					


					$data["pejabat_peserta"] = $dataPeserta;
					$data["ppk"] = array("nama" => "", "nip" => "");

					$this->load->model("pengaturan_model");
					$this->load->model("biodata_model");
					
					$ppk = $this->pengaturan_model->getPengaturanBySistem("ppk");
					
					if (!empty($ppk)) {
						$biodataId = $ppk["value"];
						
						$data["ppk"] = $this->biodata_model->getBiodataById($biodataId);
					}

					$html = $this->load->view('template/sppd_peserta', $data, true);

					$this->mpdf->createSPPD($html, "sppd", false);
				}
			}
		}
		else {
			$this->load->view('/frontend/sppd/download', $data);
		}
	}
	
	public function tembak_sppd_peserta ($kegiatanId = "", $download = null) {
		$data = array();
		$data["kegiatan_id"] = $kegiatanId;

		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		if ($download == "execute") {
			if (empty($kegiatanId)) {
				$this->load->view('frontend/errors/logo');
			}
			else {
				$this->load->model("kegiatan_model");
				$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);

				if (empty($data["kegiatan"])) {
					$this->load->view('frontend/errors/logo');
				}
				else {
					if (empty($data["kegiatan"]["kab_tempat_kegiatan"])) {
						$data["kegiatan"]["kab_tempat_kegiatan"] = $_ENV["DEFAULT_KABUPATEN"];
					}
					
					$dataPeserta = array();
					$dataPeserta["kab"] = "";
					$dataPeserta["id"] = "";
					$dataPeserta["nama"] = "";
					$dataPeserta["unit_kerja"] = "";
					$dataPeserta["jabatan"] = "";
					$dataPeserta["nip"] = "";
					
					$this->load->model("pengaturan_model");
					$this->load->model("biodata_model");
					
					if (isset($_GET["pejabat"]) && !empty($_GET["pejabat"])) {
						$biodataId = $_GET["pejabat"];
						$pejabat = $this->biodata_model->getBiodataById($biodataId);
						
						if (!empty($pejabat)) {
							$dataPeserta["id"] = $pejabat["id"];
							$dataPeserta["nama"] = $pejabat["nama"];
							$dataPeserta["unit_kerja"] = $pejabat["unit_kerja"];
							$dataPeserta["jabatan"] = $pejabat["jabatan"];
							$dataPeserta["nip"] = $pejabat["nip"];
						}
					}
					
					$data["pejabat_peserta"] = $dataPeserta;
					$data["ppk"] = array("nama" => "", "nip" => "");
					
					$ppk = $this->pengaturan_model->getPengaturanBySistem("ppk");
					
					if (!empty($ppk)) {
						$biodataId = $ppk["value"];
						
						$data["ppk"] = $this->biodata_model->getBiodataById($biodataId);
					}
					
					$html = $this->load->view('template/tembak_sppd_peserta', $data, true);

					$this->mpdf->createSPPD($html, "sppd", false);
				}
			}
		}
		else {
			
			$this->load->model("pengaturan_model");
			$this->load->model("biodata_model");
			
			$kepala = $this->pengaturan_model->getPengaturanBySistem("kepala");

			if (!empty($kepala)) {
				$biodataId = $kepala["value"];

				$data["pejabat"][] = $this->biodata_model->getBiodataById($biodataId);
			}
			
			$kasubbag = $this->pengaturan_model->getPengaturanBySistem("kasubbag");

			if (!empty($kasubbag)) {
				$biodataId = $kasubbag["value"];

				$data["pejabat"][] = $this->biodata_model->getBiodataById($biodataId);
			}
			
			$ppk = $this->pengaturan_model->getPengaturanBySistem("ppk");

			if (!empty($ppk)) {
				$biodataId = $ppk["value"];

				$data["pejabat"][] = $this->biodata_model->getBiodataById($biodataId);
			}
			
			$this->load->view('/frontend/sppd/tembak', $data);
		}
	}
}