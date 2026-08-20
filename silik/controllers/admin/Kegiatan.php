<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {
	
	function __construct() {
		parent::__construct(); 
		
		$this->load->model("kegiatan_model");
		$this->load->model("kegiatan_options_model");
		$this->load->model("biodata_model");
		$this->load->model("dakung_model");
		$this->load->model("pengaturan_model");
		$this->load->model("user_model");
		$this->load->model("komponen_kegiatan_model");
	}
	
	public function index() {
		$this->auth->login();
		$this->load->view('/backend/kegiatan/lists');
	}
	
	public function save () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan kegiatan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			if (isset($data["tgl_mulai_kegiatan"]) && !empty($data["tgl_mulai_kegiatan"])) {
				$data["tgl_mulai_kegiatan"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_mulai_kegiatan"])));
			}
			
			if (isset($data["tgl_selesai_kegiatan"]) && !empty($data["tgl_selesai_kegiatan"])) {
				$data["tgl_selesai_kegiatan"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"), $data["tgl_selesai_kegiatan"])));
			}
			
			if (isset($data["detail_tgl_kegiatan"]) && !empty($data["detail_tgl_kegiatan"])) {
				
				$tglDetail = array();
				
				foreach ($data["detail_tgl_kegiatan"] as $detailTglKegiatan) {
					$tglDetail[] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"), $detailTglKegiatan)));
				}
				
				sort($tglDetail);
				
				$data["detail_tgl_kegiatan"] = json_encode($tglDetail);
				
				$lastDate = count($tglDetail);
				
				$data["tgl_mulai_kegiatan"] = $tglDetail[0];
				$data["tgl_selesai_kegiatan"] = $tglDetail[$lastDate-1];
			}
			else {
				$data["detail_tgl_kegiatan"] = "";
			}
			
			if (isset($data["komponen"]) && !empty($data["komponen"])) {
				$data["komponen"] = json_encode($data["komponen"]);
			} 

			$id = $this->kegiatan_model->save($data, $id); 

			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan kegiatan. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function duplikat () {
		$this->auth->login();
		
		ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menduplikat kegiatan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$kegiatan = $this->kegiatan_model->getKegiatanById($id);
			
			if (!empty($kegiatan)) {
				$data = $kegiatan;
				$data["nama"] = "COPY - ".$data["nama"];
				
				// UNSET
				unset($data["id"]);
				unset($data["kode"]);

				unset($data["no_urut_terakhir"]);
				unset($data["spj_kegiatan"]);
				unset($data["daftar_hadir"]);
				
				unset($data["dibuat_tgl"]);
				unset($data["diubah_tgl"]);
				unset($data["dibuat_oleh"]);
				unset($data["diubah_oleh"]);
				
				if (isset($data["komponen"]) && !empty($data["komponen"])) {
					$data["komponen"] = json_encode($data["komponen"]);
				}
				
				if (isset($data["kategori"]) && !empty($data["kategori"])) {
					$data["kategori"] = json_encode($data["kategori"]);
				}
				
				$baru = $this->kegiatan_model->save($data);

				if (empty($baru)) {
					$out["error"] = true;
					$out["msg"] = "Gagal menduplikat kegiatan. Silahkan coba lagi!";
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function save_more_opt () {
		$this->auth->login();
				
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan pengaturan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			if (!empty($id)) {
				$kegiatan = $this->kegiatan_model->getKegiatanById($id);
				$kegiatanOpts = $this->kegiatan_options_model->get($id, $data["komponen"]);

				$ops = array();

				if (!empty($kegiatanOpts)) {
					foreach ($kegiatanOpts as $doo) {
						$ops[$doo["key"]] = $doo["id"];
					}
				}

				if (isset($data["option"]) && !empty($data["option"])) {
					foreach ($data["option"] as $key => $val) {
						$opsId = 0;

						if (isset($ops[$key])) {
							$opsId = $ops[$key];
						}

						// SAVE JSON KATEGORI
						if ($key == "kategori" && !empty($val)) {
							$val = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $val);
							$val = json_encode($val);
						}

						$foo = array();
						$foo["kegiatan_id"] = $kegiatan["id"];
						$foo["code_komponen"] = $data["komponen"];
						$foo["key"] = $key;
						$foo["value"] = $val;

						$this->kegiatan_options_model->save($foo, $opsId);
					}
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function checkRegistered () {
		$out = array();
		
		if (isset($_POST["kegiatan"]) && !empty($_POST["kegiatan"])) {
			$unsur = $_POST["unsur"];

			$this->load->model("master_komponen_kegiatan_model");
			$komponen = $this->master_komponen_kegiatan_model->get_record_by_code($unsur);

			if (!empty($komponen)) {
				$out = $this->komponen_kegiatan_model->getDetailByNik($komponen->table_name, $_POST["kegiatan"], $_POST["nik"]);
			}
		}
		
		print json_encode($out);
	}
	
	public function save_item () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan item!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST["kegiatan_id"]) && !empty($_POST["kegiatan_id"])) {
			
			if ($_POST["kab_unit_kerja"] == "Lainnya") {
				$_POST["kab_unit_kerja"] = $_POST["kab_unit_kerja_lainnya"];
			}
			
			unset($_POST["kab_unit_kerja_lainnya"]);
			
			$data = $_POST;
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			
			$unsur = "";
			
			if (isset($data["unsur"])) {
				$unsur = $data["unsur"];
				unset($data["unsur"]);
			}
			
			
			if (isset($data["tgl_lahir"]) && !empty($data["tgl_lahir"])) {
				$data["tgl_lahir"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_lahir"])));
			}
			
			$tabel = $data['table_komponen'];
			$code_komponen = $data['code_komponen'];
			unset($data['table_komponen']);
			unset($data['code_komponen']);

			$success = $this->komponen_kegiatan_model->save($tabel, $code_komponen, $data, $id);
			
			// Update data Biodata
			$this->biodata_model->updateByNIK($data);
			
			if (!$success) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan panitia!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function item ($id, $komponen = "peserta") {
		$this->auth->login();
		
		$kegiatan = $this->kegiatan_model->getKegiatanById($id);
		
		if (!empty($kegiatan) && $komponen == "peserta") {
			// Get First Aktif Komponen
			if (isset($kegiatan["komponen"]) && !empty($kegiatan["komponen"])) {
				$komponenAktif = "";
				
				foreach ($kegiatan["komponen"] as $kom => $komAktif) {
					if ($komAktif == "1") {
						$komponenAktif = $kom;
						break;
					}
				}
				
				if ($komponenAktif != "peserta") {
					redirect(base_url("/admin/item/".$id."/".$komponenAktif));
				}
			}
		}

		$kegiatanOptions = $this->kegiatan_options_model->get($id, $komponen);
		$options = array();

		if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
			foreach ($kegiatanOptions as $ops) {
				$options[$ops["key"]] = $ops["value"];
			}
		}

		
		$data = array();
		$data["kegiatan"] = $kegiatan;
		$data["kegiatan_options"] = $options;
		$data["aktif_komponen"] = $komponen;

		$this->load->model("master_komponen_kegiatan_model");
		$data["komponen"] = $this->master_komponen_kegiatan_model->get_record_by_code($komponen);
		$data["opsi_komponen"] = $this->master_komponen_kegiatan_model->get_all_records();
		 
		$data["biodata_kasubag"] = array();   
		$kasubbag = $this->pengaturan_model->getPengaturanBySistem('kasubbag');
		if (!empty($kasubbag)) {
			$biodataId = $kasubbag["value"];

			$data["biodata_kasubag"] = $this->biodata_model->getBiodataById($biodataId);
		}
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$this->load->view('backend/kegiatan/item', $data);
	}
	
	public function data_dukung ($id) {
		$this->auth->login();
		$this->load->model("master_komponen_kegiatan_model");
		
		$kegiatan = $this->kegiatan_model->getKegiatanById($id);
		
		$data = array();
		$data["kegiatan"] = $kegiatan;
		$data["opsi_komponen"] = $this->master_komponen_kegiatan_model->get_all_records();
		
		$this->load->view('backend/kegiatan/data_dukung', $data);
	}
	
	public function formUploadDakung () {
		$this->auth->login();
		
		$data = array();
		$data["kegiatan_id"] = $_POST["kegiatan_id"];
		
		$this->load->view('backend/kegiatan/modal_dakung', $data);
	}
	
	public function uploadDakung () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_FILES) && !empty($_FILES)) {
			$file = $_FILES['file'];
			$kegiatanId = $_POST["kegiatan_id"];
			$nama = $_POST["nama"];
			$jenis = $_POST["jenis"];
			
			$kegiatan = $this->kegiatan_model->getKegiatanById($kegiatanId);
			
			$allowed = array('pdf', 'doc', 'docx');
			$filename = $file['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			$allowedSize = 5242880; // 5 Mb
						
			if (!empty($kegiatan)) {
				// Check File Type
				if (in_array($ext, $allowed)) {
					if ($file["size"] <= $allowedSize) {
						$user = $this->user_model->getUserById($_SESSION["user"]["id"]);
						
						// Upload File
						$dir = APPPATH . "../assets/data_dukung";
						is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

						$dir = APPPATH . "../assets/data_dukung/".$_SESSION["tahun_anggaran"];
						is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
			
						$targetPath = $dir."/".$kegiatan["kode"];
						
						is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
						
						$filename = $file['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);

						$namaFile = str_replace(' ', '_', $nama);
						$namaFile = preg_replace('/[^A-Za-z0-9\-]/', '_', $namaFile);

						$targetFile =  $namaFile."_".rand().".".$ext;

						$tempFile = $file["tmp_name"];
						
						if (move_uploaded_file($tempFile, $targetPath. "/" .$targetFile)) {
							// save file db
							$data = array();
							$data["kegiatan_id"] = $kegiatanId;
							$data["nama"] = $nama;
							$data["nama_file"] = $targetFile;
							$data["size"] = $file["size"];
							$data["type"] = $ext;
							$data["jenis"] = $jenis;
							
							$out["id"] = $this->dakung_model->save($data);
						}
						else {
							$out["error"] = true;
							$out["msg"] = "Gagal mengunggah file";
						}
					}
					else {
						$out["error"] = true;
						$out["msg"] = "Maksimal ukuran file adalah 5 Mb";
					}
				}
				else {
					$out["error"] = true;
					$out["msg"] = "Tipe file tidak diizinkan";
				}
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Kegiatan Tidak Ditemukan";
			}
		}
		
		print json_encode($out);
	}
	
	public function dakungList () {
		$this->auth->login();
		
		$data = array();
		$data["list"] = array();
		
		if (isset($_POST["kegiatanId"]) && !empty($_POST["kegiatanId"])) {
			$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($_POST["kegiatanId"]);
			$data["list"] = $this->dakung_model->getByKegiatanId($_POST["kegiatanId"]);
		}
		
		print $this->load->view('backend/kegiatan/data_dukung_list', $data, true);
	}
	
	public function deleteDakung () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$file = $this->dakung_model->getById($_POST["id"]);
			$kegiatan = $this->kegiatan_model->getKegiatanById($file["kegiatan_id"]);
			
			$delFile = APPPATH . "../assets/data_dukung/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/".$file["nama_file"];

			if (file_exists($delFile)) {
				unlink($delFile);
			}
			
			$this->dakung_model->delete($file["id"]);
			$out["error"] = false;
			$out["kegiatan"] = $kegiatan["id"];
		}
		
		print json_encode($out);
	}
	
	public function generateBitly () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST["kegiatanId"]) && !empty($_POST["kegiatanId"])) {
			$kegiatanId = $_POST["kegiatanId"];
			$customLink = $_POST["customLink"];
			$komponen = $_POST["type"];

			$kegiatanOptions = $this->kegiatan_options_model->get($kegiatanId, $komponen);
			$optionId = 0;
			$option = array();

			if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
				foreach ($kegiatanOptions as $ops) {
					if ($ops["key"] == "link") {
						$option = $ops["value"];
						$optionId = $ops["id"];
					}
				}
			}
			
			if (!empty($option)) {
				if (empty($option["custom_bitlinks"])) {
					
					$bitly = $this->bitly->customLink($option["id"], $customLink);
					
					if (isset($bitly["id"])) {
						// Save Here
						$data = array();
						$data["kegiatan_id"] = $kegiatanId;
						$data["code_komponen"] = $komponen;
						$data["key"] = "link";
						$data["value"] = json_encode($bitly);
						$this->kegiatan_options_model->save($data, $optionId);
						
						$out = $bitly;
						$out["error"] = false;
					}
					else {
						$out = $bitly;
						$out["error"] = true;
					}
				}
				else {
					
					if ($option["custom_bitlinks"] != "bit.ly/".$customLink) {
						// UPDATE (CREATE) NEW LINK
						$longUrl = base_url("kegiatan/registrasi_".$komponen."/".$kegiatanId);
				
						$bitly = $this->bitly->shorten($longUrl);

						if (isset($bitly["id"])) {
							// Save Here
							$data = array();
							$data["kegiatan_id"] = $kegiatanId;
							$data["code_komponen"] = $komponen;
							$data["key"] = "link";
							$data["value"] = json_encode($bitly);
							$this->kegiatan_options_model->save($data, $optionId);


							$bitly = $this->bitly->customLink($bitly["id"], $customLink);

							if (isset($bitly["id"])) {
								// Save Here
								$data = array();
								$data["kegiatan_id"] = $kegiatanId;
								$data["code_komponen"] = $komponen;
								$data["key"] = "link";
								$data["value"] = json_encode($bitly);
								$this->kegiatan_options_model->save($data, $optionId);

								$out = $bitly;
								$out["error"] = false;
								$out["range"] = "custom link edit";
							}
							else {
								$out = $bitly;
								$out["error"] = true;
								$out["range"] = "bitly link edit";
							}
						}
						else {
							$out = $bitly;
							$out["error"] = true;
							$out["range"] = "gagal bitly link edit";
						}
					}
					else {
						$out = $option;
						$out["error"] = false;
						$out["range"] = "custom bitly link edit sama";
					}
				}
			}
			else {
				$longUrl = base_url("kegiatan/registrasi_".$komponen."/".$kegiatanId);
				
				$bitly = $this->bitly->shorten($longUrl);
				
				if (isset($bitly["id"])) {
					// Save Here
					$data = array();
					$data["kegiatan_id"] = $kegiatanId;
					$data["code_komponen"] = $komponen;
					$data["key"] = "link";
					$data["value"] = json_encode($bitly);
					$optionId = $this->kegiatan_options_model->save($data);
					
					$bitly = $this->bitly->customLink($bitly["id"], $customLink);
					
					if (isset($bitly["id"])) {
						// Save Here
						$data = array();
						$data["kegiatan_id"] = $kegiatanId;
						$data["code_komponen"] = $komponen;
						$data["key"] = "link";
						$data["value"] = json_encode($bitly);
						$optionId = $this->kegiatan_options_model->save($data, $optionId);
						
						$out = $bitly;
						$out["error"] = false;
					}
					else {
					    // Can't make custom link, Remove Data
						$data = array();
						$data["kegiatan_id"] = $kegiatanId;
						$data["code_komponen"] = $komponen;
						$data["key"] = "link";
						$data["value"] = "";
						$optionId = $this->kegiatan_options_model->save($data, $optionId);
						
						$out = $bitly;
						$out["error"] = true;
					}
				}
				else {
					$out = $bitly;
					$out["error"] = true;
				}
			}
		}
		
		print json_encode($out);
		exit();
	}

	public function generateBitlyDaftarHadir () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST["kegiatanId"]) && !empty($_POST["kegiatanId"])) {
			$kegiatanId = $_POST["kegiatanId"];
			$customLink = $_POST["customLink"];
			$komponen = $_POST["komponen"];
			$tanggal = $_POST["tanggal"];

			$kegiatanOptions = $this->kegiatan_options_model->get($kegiatanId, $komponen);
			$optionId = 0;
			$option = array();

			if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
				foreach ($kegiatanOptions as $ops) {
					if ($ops["key"] == "daftar_hadir") {
						$option = $ops["value"];
						$optionId = $ops["id"];
					}
				}
			}
			
			if (isset($option[$tanggal]["link"]) && !empty($option[$tanggal]["link"])) {

				if (empty($option[$tanggal]["link"]["custom_bitlinks"])) {
					
					$bitly = $this->bitly->customLink($option[$tanggal]["link"]["id"], $customLink);
					
					if (isset($bitly["id"])) {
						$option[$tanggal]["link"] = $bitly;

						// Save Here
						$data = array();
						$data["kegiatan_id"] = $kegiatanId;
						$data["code_komponen"] = $komponen;
						$data["key"] = "daftar_hadir";
						$data["value"] = json_encode($option);
						$this->kegiatan_options_model->save($data, $optionId);
						
						$out = $bitly;
						$out["error"] = false;
					}
					else {
						$out = $bitly;
						$out["error"] = true;
					}
				}
				else {
					
					if ($option[$tanggal]["link"]["custom_bitlinks"] != "bit.ly/".$customLink) {
						// UPDATE (CREATE) NEW LINK
						$longUrl = base_url("daftar_hadir_".$komponen."/".$kegiatanId."/".$tanggal);
				
						$bitly = $this->bitly->shorten($longUrl);

						if (isset($bitly["id"])) {
							$option[$tanggal]["link"] = $bitly;

							// Save Here
							$data = array();
							$data["kegiatan_id"] = $kegiatanId;
							$data["code_komponen"] = $komponen;
							$data["key"] = "daftar_hadir";
							$data["value"] = json_encode($option);
							$this->kegiatan_options_model->save($data, $optionId);


							$bitly = $this->bitly->customLink($bitly["id"], $customLink);

							if (isset($bitly["id"])) {
								$option[$tanggal]["link"] = $bitly;

								// Save Here
								$data = array();
								$data["kegiatan_id"] = $kegiatanId;
								$data["code_komponen"] = $komponen;
								$data["key"] = "daftar_hadir";
								$data["value"] = json_encode($option);
								$this->kegiatan_options_model->save($data, $optionId);

								$out = $bitly;
								$out["error"] = false;
								$out["range"] = "custom link edit";
							}
							else {
								$out = $bitly;
								$out["error"] = true;
								$out["range"] = "bitly link edit";
							}
						}
						else {
							$out = $bitly;
							$out["error"] = true;
							$out["range"] = "gagal bitly link edit";
						}
					}
					else {
						$out = $option;
						$out["error"] = false;
						$out["range"] = "custom bitly link edit sama";
					}
				}
			}
			else {
				$longUrl = base_url("daftar_hadir_".$komponen."/".$kegiatanId."/".$tanggal);
				
				$bitly = $this->bitly->shorten($longUrl);
				
				if (isset($bitly["id"])) {
					$option[$tanggal]["link"] = $bitly;

					// Save Here
					$data = array();
					$data["kegiatan_id"] = $kegiatanId;
					$data["code_komponen"] = $komponen;
					$data["key"] = "daftar_hadir";
					$data["value"] = json_encode($option);
					$optionId = $this->kegiatan_options_model->save($data);
					
					$bitly = $this->bitly->customLink($bitly["id"], $customLink);
					
					if (isset($bitly["id"])) {
						$option[$tanggal]["link"] = $bitly;

						// Save Here
						$data = array();
						$data["kegiatan_id"] = $kegiatanId;
						$data["code_komponen"] = $komponen;
						$data["key"] = "daftar_hadir";
						$data["value"] = json_encode($option);
						$optionId = $this->kegiatan_options_model->save($data, $optionId);
						
						$out = $bitly;
						$out["error"] = false;
					}
					else {
						$option[$tanggal]["link"] = "";

					    // Can't make custom link, Remove Data
						$data = array();
						$data["kegiatan_id"] = $kegiatanId;
						$data["code_komponen"] = $komponen;
						$data["key"] = "daftar_hadir";
						$data["value"] = json_encode($option);
						$optionId = $this->kegiatan_options_model->save($data, $optionId);
						
						$out = $bitly;
						$out["error"] = true;
					}
				}
				else {
					$out = $bitly;
					$out["error"] = true;
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function switchRegistration () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST["kegiatanId"]) && !empty($_POST["kegiatanId"])) {
			$kegiatanId = $_POST["kegiatanId"];
			$switch = $_POST["switch"];
			$komponen = $_POST["type"];

			$kegiatanOptions = $this->kegiatan_options_model->get($kegiatanId, $komponen);
			$optionId = 0;

			if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
				foreach ($kegiatanOptions as $ops) {
					if ($ops["key"] == "link_on") {
						$optionId = $ops["id"];
					}
				}
			}

			$foo = array();
			$foo["kegiatan_id"] = $kegiatanId;
			$foo["code_komponen"] = $komponen;
			$foo["key"] = "link_on";
			$foo["value"] = $switch;

			$this->kegiatan_options_model->save($foo, $optionId);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
		exit();
	}

	public function switchDaftarHadir () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST["kegiatanId"]) && !empty($_POST["kegiatanId"])) {
			$kegiatanId = $_POST["kegiatanId"];
			$komponen = $_POST["komponen"];
			$tanggal = $_POST["tanggal"];
			$switch = $_POST["switch"];

			$kegiatanOptions = $this->kegiatan_options_model->get($kegiatanId, $komponen);
			$optionId = 0;
			$optionValue = array();

			if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
				foreach ($kegiatanOptions as $ops) {
					if ($ops["key"] == "daftar_hadir") {
						$optionId = $ops["id"];
						$optionValue = $ops["value"];
					}
				}
			}

			if (!isset($optionValue[$tanggal])) {
				$optionValue[$tanggal] = array();
			}

			$optionValue[$tanggal]["link_on"] = $switch;  

			$foo = array();
			$foo["kegiatan_id"] = $kegiatanId;
			$foo["code_komponen"] = $komponen;
			$foo["key"] = "daftar_hadir";
			$foo["value"] = json_encode($optionValue);

			$this->kegiatan_options_model->save($foo, $optionId);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
		exit();
	}
	
	public function download_biodata2 ($kegiatanId, $code_komponen, $page = 0) {
		$this->auth->login();

		$data = array();
		$data["type"] = $code_komponen;
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);

		$kegiatanOpts = $this->kegiatan_options_model->get($kegiatanId, $code_komponen);

		$data["options"] = array();

		if (!empty($kegiatanOpts)) {
			foreach ($kegiatanOpts as $doo) {
				$data["options"][$doo["key"]] = $doo["value"];
			}
		}

		$biodatas = $this->komponen_kegiatan_model->getItemByKegiatanId($code_komponen, $kegiatanId);
		
		$perPage = 100;
		
		if (!empty($biodatas)) {
			if (empty($page)) {
				print json_encode(array("page" => ceil(count($biodatas)/$perPage)));
			}
			else {
				$html = '';
				$lastKey = $page * $perPage;
				$startKey = $lastKey - $perPage;
				
				foreach (range($startKey, ($lastKey - 1)) as $key) {
					if (isset($biodatas[$key]) && !empty($biodatas[$key])) {
						$data["biodata"] = $biodatas[$key];
						
						if (!empty($html)) {
							$html .= "<pagebreak />";
						}
						
						$html .= $this->load->view('template/biodata', $data, true);
					}
				}
				
				$this->mpdf->create($html,"biodata_".$code_komponen."_".$data["kegiatan"]["kode"]);
			}
		}
		else {
			print "Tidak Ada Data";
		}
	}
	
	public function download_single_biodata ($code_komponen, $id) {
		
		$data = array();
		$data["type"] = $code_komponen;
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}

		$biodata = $this->komponen_kegiatan_model->getItemById($code_komponen, $id);
		
		if (!empty($biodata)) {
			$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($biodata["kegiatan_id"]);

			$data["options"] = array();

			if (!empty($data["kegiatan"])) {
				$kegiatan_options = $this->kegiatan_options_model->get($data["kegiatan"]["id"], $code_komponen);

				if (!empty($kegiatan_options)) {
					foreach ($kegiatan_options as $op) {
						$data["options"][$op["key"]] = $op["value"];
					}
				}

			}
		}
		
		$html = '<h3 style="text-align:center;">Tidak ada Data</h3>';
		$namaFile = "tidak ada data";
		
		if (!empty($biodata)) {
			$data["biodata"] = $biodata;
			
			$html = $this->load->view('template/biodata', $data, true);
			
			$namaFile = "biodata_".$code_komponen."_".$data["biodata"]["nama"];
		}
		
		$this->mpdf->create($html,$namaFile,false);
	}

	public function download_daftar_hadir ($kegiatanId, $type) {
		//ini_set('display_errors', '1');
		//ini_set('display_startup_errors', '1');
		//error_reporting(E_ALL);
		$this->auth->login();
		
		$data = array();
		$data["type"] = $type;
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);

		$data["kegiatan_options"] = $this->kegiatan_options_model->get($kegiatanId, $type);

		$data["biodata"] = $this->komponen_kegiatan_model->getItemByKegiatanId($type, $kegiatanId);

		$html = $this->load->view('template/daftar_hadir', $data, true);

		/*$setName = "download_daftar_hadir_".$type."_".$data["kegiatan"]["kode"];

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
		$mpdf->shrink_tables_to_fit = 1;

		$html = $this->load->view('template/daftar_hadir', $data, true);

		$html = "TEST";

		//$mpdf->WriteHTML($html);
		//$mpdf->Output($setName.'.pdf', 'F');*/


	    $this->mpdf->createLandscape($html, "daftar_hadir_".$type."_".$data["kegiatan"]["kode"]);
	}
	
	public function download_daftar_hadir2 ($kegiatanId, $type) {
		$this->auth->login();
		
		$data = array();
		$data["type"] = $type;
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);

		$data["kegiatan_options"] = $this->kegiatan_options_model->get($kegiatanId, $type);

		$biodatas = $this->komponen_kegiatan_model->getItemByKegiatanId($type, $kegiatanId);

		$setName = "download_daftar_hadir_".$type."_".$data["kegiatan"]["kode"];

		$row = 100;

		if (!empty($biodatas)) {
			
			if (count($biodatas) <= $row) {
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
				$mpdf->shrink_tables_to_fit = 1;

				$html = $this->load->view('template/daftar_hadir', $data, true);

				$mpdf->WriteHTML($html);
				$mpdf->Output($setName.'.pdf', 'D');
			}
			else {
				$iterasi = ceil(count($biodatas)/$row);
				$files = array();
				$no = 1;

				foreach (range(1, $iterasi) as $i) {
					if ($i == 1) {
						$data["biodata"] = array();

						foreach ($biodatas as $i_b => $biodata) {
							if ($i_b == $row) {
								break;
							}

							$biodata["no"] = $no;

							$data["biodata"][] = $biodata;
							$no++;
						}

						$html = $this->load->view('template/daftar_hadir_head', $data, true);
						
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
						$mpdf->shrink_tables_to_fit = 1;

						$mpdf->WriteHTML($html);

						// Save File
						$dir = APPPATH . "../assets/temp_pdf";
						is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

						$mpdf->Output($dir."/".$setName.'_'.$i.'.pdf', 'F');
					}
					else if ($i == $iterasi) {
						$data["biodata"] = array();
						$start = ($row * $iterasi) - $row;
						$end = $row * $iterasi;

						foreach ($biodatas as $i_b => $biodata) {
							if ($i_b == $end) {
								break;
							}

							if ($i_b >= $start) {
								$biodata["no"] = $no;

								$data["biodata"][] = $biodata;
								$no++;
							}
						}

						$html = $this->load->view('template/daftar_hadir_footer', $data, true);

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
						$mpdf->shrink_tables_to_fit = 1;

						$mpdf->WriteHTML($html);

						// Save File
						$dir = APPPATH . "../assets/temp_pdf";
						is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

						$mpdf->Output($dir."/".$setName.'_'.$i.'.pdf', 'F');
					}
					else {
						$data["biodata"] = array();
						$start = ($row * $i) - $row;
						$end = $row * $i;

						foreach ($biodatas as $i_b => $biodata) {
							if ($i_b == $end) {
								break;
							}

							if ($i_b >= $start) {
								$biodata["no"] = $no;

								$data["biodata"][] = $biodata;
								$no++;
							}
						}

						$html = $this->load->view('template/daftar_hadir_body', $data, true);

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
						$mpdf->shrink_tables_to_fit = 1;
						
						$mpdf->WriteHTML($html);

						// Save File
						$dir = APPPATH . "../assets/temp_pdf";
						is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

						$mpdf->Output($dir."/".$setName.'_'.$i.'.pdf', 'F');
					}
				}

				
			}

		}
		else {
			$html = '<h3 style="text-align:center;">Tidak ada Data</h3>';

			$mpdf->WriteHTML($html);
			$mpdf->Output($setName.'.pdf', 'D');
		}
		
		
		
		

	    //$this->mpdf->createLandscape($html, "daftar_hadir_".$type."_".$data["kegiatan"]["kode"]);
	}
	
	public function export_excel ($kegiatanId, $type) {
		$this->auth->login();
		
		$data = array();
		$data["type"] = $type;
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);
		$data["biodata"] = $this->komponen_kegiatan_model->getItemByKegiatanId($type, $kegiatanId);
		
		if (!empty($data["biodata"])) {
			$keyData = array(
				"kode" => "Kode",
				"ktp" => "NIK",
				"nama" => "Nama",
				"tempat_lahir" => "Tempat Lahir",
				"tgl_lahir" => "Tanggal Lahir",
				"jenis_kelamin" => "Jenis Kelamin",
				"alamat_tinggal" => "Alamat Rumah",
				"telp" => "Telp/Hp",
				"email" => "Email",
				"nip" => "NIP",
				"ptkp" => "Status PTKP",
				"pangkat" => "Pangkat",
				"golongan" => "Golongan",
				"jabatan" => "Jabatan",
				"unit_kerja" => "Unit Kerja",
				"alamat_unit_kerja" => "Alamat Unit Kerja",
				"kab_unit_kerja" => "Kab/Kota Unit Kerja",
				"telp_unit_kerja" => "Telp Unti Kerja",
				"kategori" => "Kategori",
				"no_rekening" => "No Rekening",
				"nama_pemilik_rekening" => "Nama Pemilik Rekening",
				"nama_bank" => "Nama Bank",
				"valid_rekening" => "Valid Rekening",
				"konfirmasi_paket" => "Menerima Biaya Paket Data",
				"tanda_tangan" => "Tanda Tangan"
			);
			
			$exportData = array();
			
			$exp = array();
			$exp[] = "No";
			
			foreach ($keyData as $export) {
				$exp[] = $export;
			}
			
			$exportData[] = $exp;
			
			
			
			$i = 1;
			foreach ($data["biodata"] as $bios) {
				$exp = array();
				$exp[] = $i;
				
				foreach ($keyData as $dooKey => $doo) {
					foreach ($bios as $bioKey => $bio) {
						if ($bioKey == $dooKey) {
							$exp[] = $bio;
						}
					}
				}
				
				$exportData[] = $exp;
				$i++;
			}
		}
		else {
			$exportData = array(array("Data not found"));
		}

		$this->excel->create($exportData, "export_".$type."_".$data["kegiatan"]["kode"]);
	}
	
	function sertificate_typehead () {
		$out = array();
		
		if (isset($_GET["q"])) {
			$term = $_GET["q"];
			
			$this->load->model("sertifikat_model");
		
			$sertificates = $this->sertifikat_model->getTypeHead($term);
			
			$out["total_count"] = count($sertificates);
			$out["items"] = $sertificates;
		}
		
		print json_encode($out);
		exit();
	}
	
	function report () {
		$this->auth->login();
		
		$html = '<div class="alert alert-danger"><p>Gagal Memuat Laporan! (under maintenance)</p></div>';
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$id = $_POST["id"];
			$unsur = $_POST["unsur"];
			
			$data = array();
			$data["unsur"] = $unsur;
			$data["report_kab"] = array();
			
			$items = $this->komponen_kegiatan_model->getItemByKegiatanId($unsur, $id, true);
			
			$unsurSatuan = $this->config->item("unsur_satuan");
			
			$reportKab = array();
			$reportWaktuDaftar = array();
			$reportUnsur = array();
			
			if (!empty($items)) {
				foreach ($items as $item) {
					if (!isset($reportKab[$item["kab_unit_kerja"]])) {
						$reportKab[$item["kab_unit_kerja"]] = 0;
					}
					
					$tglDaftar = date("Y-m-d", strtotime($item["dibuat_tgl"]));
					
					if (!isset($reportWaktuDaftar[$tglDaftar])) {
						$reportWaktuDaftar[$tglDaftar] = 0;
					}
					
					$break = 0;
					
					foreach ($unsurSatuan as $keyUs => $paramUss) {
						
						foreach ($paramUss as $paramUs) {
							
							$regex = strtolower(substr($item["unit_kerja"], 0, strlen($paramUs)));
							
							if ($regex === $paramUs) {
								if (!isset($reportUnsur[$keyUs])) {
									$reportUnsur[$keyUs] = 0;
								}
								
								$reportUnsur[$keyUs] += 1;
								$break = 1;
								break;
							}
						}
						
						if ($break) {
							break;
						}
					}
					
					if (!$break) {
						if (!isset($reportUnsur[$item["unit_kerja"]])) {
							$reportUnsur[$item["unit_kerja"]] = 0;
						}
						
						$reportUnsur[$item["unit_kerja"]] += 1;
					}
					
					$reportKab[$item["kab_unit_kerja"]] += 1;
					$reportWaktuDaftar[$tglDaftar] += 1;
				}
			}
			
			// SORTING
			if (!empty($reportWaktuDaftar)) {
				ksort($reportWaktuDaftar);
			}
			
			if (!empty($reportUnsur)) {
				$sortReportUnsur = array();
				
				foreach ($unsurSatuan as $keyUs => $paramUss) {
					if (isset($reportUnsur[$keyUs])) {
						$sortReportUnsur[$keyUs] = $reportUnsur[$keyUs];
						unset($reportUnsur[$keyUs]);
					}
				}
				
				if (!empty($reportUnsur)) {
					foreach ($reportUnsur as $key => $foo) {
						$sortReportUnsur[$key] = $foo;
					}
				}
				
				$reportUnsur = $sortReportUnsur;
			}
			
			$data["report_kab"] = $reportKab;
			$data["report_waktu"] = $reportWaktuDaftar;
			$data["report_unsur"] = $reportUnsur;
			
			$html = $this->load->view('backend/kegiatan/report_pendaftaran', $data, true);
		}
		
		print $html;
		exit();
	}

	function tugas_panitia () {
		$this->auth->login();

		$data = array();

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$data["id"] = $_POST["id"];
			$data["table_id"] = $_POST["table_id"];
			$data["panitia"] = $this->komponen_kegiatan_model->getItemByKegiatanId("panitia", $_POST["id"]);
		}

		$html = $this->load->view('backend/kegiatan/modal_tugas_panitia', $data, true);

		print $html;
		exit();
	}

	function save_tugas_panitia () {
		$this->auth->login();

		$out = array();
		$out["error"] = 0;
		$out["msg"] = "Tugas Panitia berhasil Disimpan";
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$kegiatan = $this->kegiatan_model->getKegiatanById($_POST["id"]);

			if (!empty($kegiatan)) {
				$this->load->model("arsip_model");

				$arsip = $this->arsip_model->getByKegiatanId($kegiatan["id"]);
				$execute = true;

				if (!empty($arsip) && $arsip["status"] != "Baru" ) {
					$execute = false;
				}

				if ($execute) {
					
					$panitia = $this->komponen_kegiatan_model->getItemByKegiatanId("panitia", $_POST["id"]);

					if (!empty($panitia)) {
						foreach ($panitia as $pan) {
							$data = array();
							$data["tugas_panitia"] = "";
							$data["jabatan_panitia"] = "anggota";
							$data["kegiatan_id"] = $_POST["id"];

							$this->komponen_kegiatan_model->save("kegiatan_panitia","panitia", $data, $pan["id"]);
						}
					}

					foreach ($this->config->item("tugas_panitia") as $tg => $ts) {
						if ($tg == "penanggungjawab" || $tg == "ketua") {
							$data = array();
							$data["jabatan_panitia"] = $tg;
							$data["kegiatan_id"] = $_POST["id"];
							$this->komponen_kegiatan_model->save("kegiatan_panitia","panitia", $data, $_POST[$tg]);
						}

						if ($tg != "penanggungjawab" && $tg != "ketua") {
							$data = array();
							$data["tugas_panitia"] = $tg;
							$data["kegiatan_id"] = $_POST["id"];
							$this->komponen_kegiatan_model->save("kegiatan_panitia","panitia", $data, $_POST[$tg]);
						}
					}
					
					// BUAT ARSIP LAPORAN
					$pembuatLaporan = $this->komponen_kegiatan_model->getItemById("panitia", $_POST[$tg]);

					if (!empty($pembuatLaporan)) {
						$nik = $pembuatLaporan["ktp"];

						$this->load->model("biodata_model");
						$pembuatLaporan = $this->biodata_model->getBiodataByNik($nik);

						if (!empty($pembuatLaporan)) {
							$userLaporan = $this->user_model->getUserBySyncBiodata($pembuatLaporan["id"]);
							$data = array();
							$data["nama"] = "Laporan Kegiatan ".$kegiatan["nama"];
							$data["program"] = $kegiatan["program"];
							$data["jenis_berkas"] = "Laporan Kegiatan";
							$data["kegiatan_id"] = $kegiatan["id"];
							$data["akses"] = "Biasa";
							$data['dibuat_oleh'] = $userLaporan["id"];
							$data['diubah_oleh'] = $userLaporan["id"];

							$arsipId = 0;
							if (isset($arsip["id"]) && !empty($arsip["id"])) {
								$arsipId = $arsip["id"];
							}
							$this->arsip_model->save_arsip($data, $arsipId);
						}
						else {
							$out["error"] = 1;
							$out["msg"] = "Pembuat laporan tidak ditemukan";
							$out["close_modal"] = false;
							$out["reload_table"] = false;
						}
					}
					else {
						$out["error"] = 1;
						$out["msg"] = "Pembuat laporan tidak ditemukan";
						$out["close_modal"] = false;
						$out["reload_table"] = false;
					}
				}
				else {
					$out["error"] = 1;
					$out["msg"] = "Arsip laporan sudah terbentuk";
					$out["close_modal"] = false;
					$out["reload_table"] = false;
				}
			}
			
		}

		print json_encode($out);
		exit();
	}

	function rekap_daftar_hadir_peserta () {
		$this->auth->login();

		$data = array();

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$data["id"] = $_POST["id"];
			$data["table_id"] = $_POST["table_id"];
			$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($_POST["id"]);
			$data["peserta"] = $this->komponen_kegiatan_model->getItemByKegiatanId("peserta", $_POST["id"]);
		}

		$html = $this->load->view('backend/kegiatan/modal_rekap_daftar_hadir_peserta', $data, true);

		print $html;
		exit();
	}

	function save_rekap_daftar_hadir_peserta () {
		$this->auth->login();

		$out = array();
		$out["error"] = 0;
		$out["msg"] = "Rekap Daftar Hadir Berhasil Disimpan";
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			
		}

		print json_encode($out);
		exit();
	}

	function option_daftar_hadir_peserta () {
		$this->auth->login();

		$data = array();

		if (isset($_POST["kegiatan_id"]) && !empty($_POST["kegiatan_id"])) {
			$data["kegiatan_id"] = $_POST["kegiatan_id"];
			$data["tipe"] = $_POST["tipe"];
			$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["kegiatan_id"]);
			$data["peserta"] = $this->komponen_kegiatan_model->getItemByKegiatanId($data["tipe"], $data["kegiatan_id"]);
		}

		$html = $this->load->view('backend/kegiatan/modal_option_daftar_hadir_peserta', $data, true);

		print $html;
		exit();
	}

	public function download_option_daftar_hadir ($kegiatanId, $type, $tanggal) {
		
		$this->auth->login();
		
		$data = array();
		$data["type"] = $type;
		
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($kegiatanId);

		$data["kegiatan_options"] = $this->kegiatan_options_model->get($kegiatanId, $type);

		$data["biodata"] = $this->komponen_kegiatan_model->getItemByKegiatanId($type, $kegiatanId);

		$data["tanggal"] = $tanggal;

		$html = $this->load->view('template/option_daftar_hadir', $data, true);

	    $this->mpdf->createLandscape($html, "daftar_hadir_".$type."_".$data["kegiatan"]["kode"]);
	}
}
