<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("kegiatan_model"); 
		$this->load->model("biodata_model");
		$this->load->model("dakung_model");
		$this->load->model("pengaturan_model");
		$this->load->model("master_komponen_kegiatan_model");
		$this->load->model("komponen_kegiatan_model");
		$this->load->model("kegiatan_options_model");
	}
	
	public function index() {
		$this->load->view('frontend/errors/logo');
	}
	
	protected function registrasi_form ($komponen, $kegiatanId) {
		$data = array(); 
		$data["komponen"] = $this->master_komponen_kegiatan_model->get_record_by_code($komponen);
		$data["type"] = $data["komponen"]->name;
		$data["title"] = "Pendaftaran Kegiatan";
		
		// Lookup Satker Header
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		// Lookup Kegiatan
		$kegiatan = $this->kegiatan_model->getKegiatanById($kegiatanId);
		
		if (!empty($kegiatan)) {
			$data["kegiatan"] = $kegiatan;
			$data["title"] .= " ".$kegiatan["nama"];
			 
			$data["kegiatan_options"] = $this->kegiatan_options_model->get($kegiatan['id'], $data["komponen"]->code);

			$this->load->view('frontend/kegiatan/kegiatan_registrasi2', $data);
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
	public function registrasi ($komponen, $kegiatanId) {
		$this->registrasi_form($komponen, $kegiatanId);
	}
	
	public function registrasi_save2 () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Gagal melakukan pendaftaran!";
		
		if (isset($_POST) && !empty($_POST)) {
			$kegiatanId = $_POST["kegiatan_id"];
			
			$code_komponen = $_POST['komponen'];
			unset($_POST["komponen"]);

			$ktp = $_POST["nik"];
			unset($_POST["nik"]);
			
			if ($_POST["kab_unit_kerja"] == "Lainnya") {
				$_POST["kab_unit_kerja"] = $_POST["kab_unit_kerja_lainnya"];
			}
			unset($_POST["kab_unit_kerja_lainnya"]);

			if (isset($_POST["buku_tabungan"])) {
				unset($_POST["buku_tabungan"]);
			}
			
			$id = 0;
			$data = $_POST;
			$data["ktp"] = $ktp;
			
			// Tgl lahir format
			if (isset($data["tgl_lahir"]) && !empty($data["tgl_lahir"])) {
				$data["tgl_lahir"] = date("Y-m-d", strtotime(str_replace(array("/"),array("-"),$data["tgl_lahir"])));
			}
			
			$kegiatan = $this->kegiatan_model->getKegiatanById($kegiatanId);
			$komponen = $this->master_komponen_kegiatan_model->get_record_by_code($code_komponen);
			
			if (!empty($komponen)) {
				// Cek Jika Sudah Pernah Registrasi
				$user = $this->komponen_kegiatan_model->getDetailByNik($komponen->table_name, $kegiatanId, $data["ktp"]);
				
				// Jika Sudah Registrasi, Set ID ke Registrasi Sebelumnya
				if (!empty($user)) {
					$id = $user["id"];
				}

				$id = $this->komponen_kegiatan_model->save($komponen->table_name, $komponen->code, $data, $id);
				
				$registered = $this->komponen_kegiatan_model->getDetailByNik($komponen->table_name, $kegiatanId, $data["ktp"]);

				$tahunKegiatan = date("Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
				
				// handle surat tugas
				if (isset($_FILES['surat_tugas']) && !empty($_FILES['surat_tugas'])) {
					$files = array();
					$allowed = array('pdf', 'jpg', 'jpeg', 'png');
					$allowedSize = 3145728; // 3 Mb
					
					$tempFile = $_FILES['surat_tugas']["tmp_name"];
					
					$dir = APPPATH . "../assets/surat_tugas";
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$dir = APPPATH . "../assets/surat_tugas/".$tahunKegiatan;
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
		
					$targetPath = $dir."/".$kegiatan["kode"];
					
					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
					
					$filename = $_FILES['surat_tugas']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					$targetFile =  "Surat_Tugas_".$registered["kode"].".".$ext;

					move_uploaded_file($tempFile, $targetPath. "/" .$targetFile);
					
					$data["surat_tugas"] = $targetFile;
					
					$id = $this->komponen_kegiatan_model->save($komponen->table_name, $komponen->code, $data, $id);
				}

				// handle buku tabungan
				if (isset($_FILES['buku_tabungan']) && !empty($_FILES['buku_tabungan'])) {
					$files = array();
					$allowed = array('pdf', 'jpg', 'jpeg', 'png');
					$allowedSize = 3145728; // 3 Mb
					
					$tempFile = $_FILES['buku_tabungan']["tmp_name"];
		
					$targetPath = APPPATH . "../assets/buku_tabungan";
					
					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
					
					$filename = $_FILES['buku_tabungan']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					$targetFile =  "tabungan_".$ktp.".".$ext;

					move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);
					
					if ($ext == "jpeg" || $ext == "jpg" || $ext == "png") {
						
						if ($ext == "jpeg" || $ext == "jpg") {
							$imageTmp = imagecreatefromjpeg($targetPath. "/" .$targetFile);
						}
						else if ($ext == "png") {
							$imageTmp = imagecreatefrompng($targetPath. "/" .$targetFile);
						}
						
						imagejpeg($imageTmp, $targetPath. "/" ."tabungan_".$ktp.".jpg", 25);
						imagedestroy($imageTmp);
						
						if ($ext != "jpg") {
							unlink($targetPath. "/" .$targetFile);
						}
					}
					
					if (file_exists($targetPath. "/" ."tabungan_".$ktp.".jpg")) {
						$im = new imagick($targetPath. "/" ."tabungan_".$ktp.".jpg");
						$im->setImageCompression(true);
						$im->setCompression(Imagick::COMPRESSION_JPEG);
						$im->setCompressionQuality(25); 
						$im->setImageFormat("jpg");
						$im->stripImage();

						$im->writeImage($targetPath. "/" ."tabungan_".$ktp.".jpg"); 
						$im->clear(); 
						$im->destroy();
					}
				}

				// handle ttd
				if (isset($data["tanda_tangan"]) && !empty($data["tanda_tangan"])) {
					$data_uri = $data["tanda_tangan"];
					$encoded_image = explode(",", $data_uri)[1];
					$decoded_image = base64_decode($encoded_image);
					
					$dir = APPPATH . "../assets/ttd";
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$dir = $dir."/".$tahunKegiatan; // Full Path
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$dir = $dir."/".$kegiatan["kode"]; // Full Path
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$name = 'ttd-'.$ktp.'.png';
					
					file_put_contents($dir."/".$name, $decoded_image);
					
					$this->utility->resize_image($dir."/".$name, 200);
				}

				// Update data Biodata
				if (isset($data["konfirmasi_paket"])) {
					unset($data["konfirmasi_paket"]);
				}
				
				if (isset($data["tanda_tangan"])) {
					unset($data["tanda_tangan"]);
				}
				
				if (isset($data["surat_tugas"])) {
					unset($data["surat_tugas"]);
				}
				
				if (isset($data["kategori"])) {
					unset($data["kategori"]);
				}
				
				$this->biodata_model->updateByNIK($data);


				// Prepare For Preview
				$out["error"] = false;
				$out["msg"] = "Berhasil melakukan pendaftaran!";
				$data["kegiatan"] = $kegiatan;
				
				$data["item"] = $registered;
				$data["komponen"] = $komponen;

				// Kegiatan Options
				$kegiatan_options = $this->kegiatan_options_model->get($kegiatan["id"], $komponen->code);

				$data["wa_grup"] = "";
				$data["tele_grup"] = "";

				if (!empty($kegiatan_options)) {
					foreach ($kegiatan_options as $opts) {
						if ($opts["key"] == "wa_grup") {
							$data["wa_grup"] = $opts["value"];
						}

						if ($opts["key"] == "tele_grup") {
							$data["tele_grup"] = $opts["value"];
						}
					}
				}

				$out["html"] = $this->load->view('frontend/kegiatan/kegiatan_registrasi_berhasil', $data, true);
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Gagal melakukan pendaftaran!";
				$data["kegiatan"] = $kegiatan;
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function form_daftar_hadir ($type = "peserta", $idKegiatan, $tglKegiatan) {
		$data = array();
		$data["type"] = $type;
		$data["tgl_daftar_hadir"] = date("Y-m-d", $tglKegiatan);
		$data["title"] = "Daftar Hadir";
		
		// Lookup Satker Header
		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		// Lookup Kegiatan
		$kegiatan = $this->kegiatan_model->getKegiatanById($idKegiatan);
		
		if (!empty($kegiatan)) {
			$data["title"] .= " Kegiatan ".$kegiatan["nama"];
			$data["kegiatan"] = $kegiatan;
			$data["link_on"] = 0;

			// Lookup Link On/Off
			$kegiatanOptions = $this->kegiatan_options_model->get($idKegiatan, $type);

			if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
				foreach ($kegiatanOptions as $ops) {
					if ($ops["key"] == "daftar_hadir" && isset($ops["value"][$tglKegiatan]["link_on"])) {
						$data["link_on"] = $ops["value"][$tglKegiatan]["link_on"];
					}
				}
			}

			// Lookup Komponen
			$this->load->model("master_komponen_kegiatan_model");
			$data["komponen"] = $this->master_komponen_kegiatan_model->get_record_by_code($type);

            $this->load->view('frontend/kegiatan/daftar_hadir', $data);
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
	public function daftar_hadir ($komponen, $idKegiatan, $tglKegiatan) {
		$this->form_daftar_hadir($komponen, $idKegiatan, $tglKegiatan);
	}
	
	public function getItemKegiatan () {
		$data = array();
		
		if (isset($_POST) && !empty($_POST)) {
			$nik = $_POST["nik"];
			$kegiatan = $_POST["kegiatan"];
			$type = $_POST["type"];
			
			$biodata = $this->komponen_kegiatan_model->getItemByNik($type, $kegiatan, $nik);
			
			if (!empty($biodata)) {
				$data["biodata"] = $biodata;
			}
		}
		
		print json_encode($data);
	}
	
	public function daftar_hadir_save () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Daftar hadir berhasil disimpan";
		
		if (isset($_POST) && !empty($_POST)) {
			
			$kegiatanId = $_POST["kegiatan_id"];
			
			$kegiatan = $this->kegiatan_model->getKegiatanById($kegiatanId);
			
			if (!empty($kegiatan)) {
				$data = $_POST;
				$type = $_POST["type"];

				$registered = $this->komponen_kegiatan_model->getItemByNik($type, $kegiatanId, $data["nik"]);

				$tahunKegiatan = date("Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
				
				if (!empty($registered)) {
					$id = $registered["id"];
					$kehadiran = date("Y-m-d", strtotime($data["tgl_daftar_hadir"]));
					
					$update = array();
					
					$update["daftar_hadir"] = array();
					$update["daftar_hadir"][$kehadiran] = 1;

					if (isset($registered["daftar_hadir"]) && !empty($registered["daftar_hadir"])) {
						$update["daftar_hadir"] = json_decode($registered["daftar_hadir"], true);
						$update["daftar_hadir"][$kehadiran] = 1;
					}
					
					$update["daftar_hadir"] = json_encode($update["daftar_hadir"]);
					
					$komponen = $this->master_komponen_kegiatan_model->get_record_by_code($type);

					$id = $this->komponen_kegiatan_model->save($komponen->table_name, $type, $update, $id);
				}
				
				// TTD HANDLE
				if (isset($data["tanda_tangan"]) && !empty($data["tanda_tangan"])) {
					$data_uri = $data["tanda_tangan"];
					$encoded_image = explode(",", $data_uri)[1];
					$decoded_image = base64_decode($encoded_image);

					$dir = APPPATH . "../assets/ttd/".$tahunKegiatan; // Full Path
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$dir = $dir."/".$kegiatan["kode"]; // Full Path
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
					
					$dir .= "/".date("d_m_Y", strtotime($data["tgl_daftar_hadir"]));
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
					
					$name = 'ttd-'.$data["nik"].'.png';

					file_put_contents($dir."/".$name, $decoded_image);

					$this->utility->resize_image($dir."/".$name, 200);
				}

				$data["kegiatan"] = $kegiatan;
				
				$out["html"] = $this->load->view('frontend/kegiatan/kegiatan_daftar_hadir_berhasil', $data, true);
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Anda Belum Terdaftar";
			}
		}
		else {
			$out["error"] = true;
			$out["msg"] = "Anda Belum Terdaftar";
		}
		
		print json_encode($out);
	}
}
