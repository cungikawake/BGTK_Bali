<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("sertifikat_model");
	}
	
	public function index() {
		$this->auth->login();
		$this->load->view('backend/sertifikat/lists');
	}
	
	public function edit ($id) {
		$this->auth->login();
		$data = array();
		$data["sertifikat"] = $this->sertifikat_model->getById($id);
		
		$this->load->view('backend/sertifikat/design', $data);
	}
	
	public function save_koordinat () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			unset($_POST["id"]);
			
			$data = array();
			$data["koordinat"] = json_encode($_POST);

			$id = $this->sertifikat_model->save($data, $id);
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function json_detail () {
		$out = array();
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];

			$sertifikat = $this->sertifikat_model->getById($id);
			$out = $sertifikat;
		}
		
		print json_encode($out);
	}
	
	public function add () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_FILES) && !empty($_FILES)) {
			$file = $_FILES['file'];
			$nama = $_POST["nama"];
			
			$allowed = array('jpg', 'jpeg');
			$filename = $file['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			$allowedSize = 5242880; // 5 Mb
			
			if (in_array($ext, $allowed)) {
				if ($file["size"] <= $allowedSize) {
					
					$data = array();
					$data["nama"] = $nama;
					
					$id = $this->sertifikat_model->save($data);
					
					$targetName = $id.".".$ext;
					$tempFile = $file['tmp_name'];
					
					$dir = APPPATH . "../assets/images"; // Full Path

					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
					
					$targetPath = $dir."/sertifikat/";

					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

					$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');

					$targetPath = $targetPath."/".$tahun_anggaran."/";

					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

					$targetFile = $targetPath. $targetName;

					if (move_uploaded_file($tempFile, $targetFile)) {
						$out["error"] = false;
						$out["id"] = $id;
						
						$data = array();
						$data["gambar"] = $targetName;

						$id = $this->sertifikat_model->save($data, $id);
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
		
		print json_encode($out);
	}
	
		
	public function test_qr () {
		// Generate QR Code
		$kode = "NO-0123";
		$this->load->library('qr_code');
		$urlSertifikat = base_url();
		$qr_code = $this->qr_code->create(400, $urlSertifikat);
		
		print '<img src="'.$qr_code.'" />';
	}

	public function add_next_page () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_FILES) && !empty($_FILES)) {
			$file = $_FILES['file']; 
			$old_id = $_POST['old_id'];
			$allowed = array('jpg', 'jpeg');
			$filename = $old_id.'-next-'.$file['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			$allowedSize = 5242880; // 5 Mb
			 
			if (in_array($ext, $allowed)) {
				if ($file["size"] <= $allowedSize) {
					
					$data = array();
					$data["gambar_2"] = $filename;
					
					$id = $this->sertifikat_model->add_page($data, $old_id);
					
					$targetName = $id."-next.".$ext;
					$tempFile = $file['tmp_name'];
					
					$dir = APPPATH . "../assets/images"; // Full Path

					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
					
					$targetPath = $dir."/sertifikat/";

					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

					$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');

					$targetPath = $targetPath."/".$tahun_anggaran."/";

					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

					$targetFile = $targetPath. $targetName;

					if (move_uploaded_file($tempFile, $targetFile)) {
						$out["error"] = false;
						$out["id"] = $id;
						
						$data = array();
						$data["gambar_2"] = $targetName;

						$id = $this->sertifikat_model->save($data, $id);
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
		
		print json_encode($out);
	}
}
