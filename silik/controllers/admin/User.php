<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	protected $captcha_config = array(
		'img_path'      => APPPATH . "../assets/images/captcha/",
		'img_url'       => "/assets/images/captcha/",
		'font_path'     => APPPATH . "../assets/images/captcha/cambria.ttf",
		'img_width'     => '120',
		'img_height'    => 39,
		'expiration'    => 7200,
		'word_length'   => 4,
		'font_size'     => 20,
		'img_id'        => 'captcha-img',
		'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',
		'expiration' => 7200,
	
		// White background and border, black text and red grid
		'colors' => array(
				'background' => array(255, 255, 255),
				'border' => array(255, 255, 255),
				'text' => array(0, 0, 0),
				'grid' => array(4, 169, 245)
		)
	);

	protected $test = array("test");

	function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->auth->login();
		$this->load->view('backend/user/lists');
	}
	
	public function keep_auth () {
		if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
			$session = $_SESSION["user"];
			$_SESSION["user"] = $session;
		}

		if (isset($_SESSION["biodata"]) && !empty($_SESSION["biodata"])) {
			$session = $_SESSION["biodata"];
			$_SESSION["biodata"] = $session;
		}

		if (isset($_SESSION["tahun_anggaran"]) && !empty($_SESSION["tahun_anggaran"])) {
			$session = $_SESSION["tahun_anggaran"];
			$_SESSION["tahun_anggaran"] = $session;
		}
	}
	
	public function keep_menu () {
		if (isset($_SESSION["menu"]) && !empty($_SESSION["menu"])) {
			$session = $_SESSION["menu"];
			$_SESSION["menu"] = $session;
		}
	}
	
	public function set_menu () {
		if (isset($_POST["menu"]) && !empty($_POST["menu"])) {
			if ($_POST["menu"] == "true") {
				$_SESSION["menu"] = true;
			}
			else {
				$_SESSION["menu"] = false;
			}
		}
	}
	
	public function login () {
		$this->load->helper('captcha');
		
		if (isset($_POST) && !empty($_POST)) {
			$username = $_POST["username"];
			$password = $_POST["password"];
			$captcha = $_POST["captcha"];
			$tahunAnggaran = $_POST["tahun_anggaran"];

			$contain_sess_captcha = $this->session->userdata('valuecaptchaCode');
			
			$out = array("error" => false);
			
			if (empty($username) && empty($password)) {
				$out["error"] = true;
				$out["msg"] = "Username dan Password tidak boleh kosong";
			}
			else if (empty($username)) {
				$out["error"] = true;
				$out["msg"] = "Username tidak boleh kosong";
			}
			else if (empty($password)) {
				$out["error"] = true;
				$out["msg"] = "Password tidak boleh kosong";
			}
			else if ($captcha != $contain_sess_captcha) {
				$out["error"] = true;
				$out["msg"] = "Kode Captcha Tidak Sesuai";
			}
			
			if ($out["error"]) {
				print json_encode($out);
				exit();
			}
			else {
				$user = $this->user_model->login($username, $password);
				
				if (!empty($user)) {
					$access = (array) json_decode($user["akses"]);
					$aksesVal = array();

					if (!empty($access)) {
						foreach ($access as $accessKey => $accessItems) {
							$aksesVal[$accessKey] = array();

							foreach ($accessItems as $key => $item) {
								$aksesVal[$accessKey][$key] = $item;
							}
						}
					}
					
					$user["akses"] = $aksesVal;
					$_SESSION["user"] = $user;
					
					$this->load->model("biodata_model");
					$biodata = $this->biodata_model->getBiodataById($user["sync_biodata"]);
					$_SESSION["biodata"] = $biodata;
					
					$_SESSION["tahun_anggaran"] = $tahunAnggaran;

					$_SESSION["token"] = rand();

					$this->session->unset_userdata('valuecaptchaCode');

					// Remember Me
					if (isset($_POST['remember'])) {
						$token = bin2hex(random_bytes(32));
						$expires = (new DateTime('last day of december'))->setTime(23, 59, 59)->format('Y-m-d H:i:s');

						// Simpan token ke database
						$rememberData = array();
						$rememberData["token"] = $token;
						$rememberData["token_expire"] = $expires;

						$this->user_model->save($rememberData, $user["id"]);

						// Simpan cookie
						setcookie(
							'remember_token',
							$token,
							strtotime($expires),
							'/',
							'',
							false,
							true
						);
					}

					if (isset($_SESSION["login_redirect"]) && !empty($_SESSION["login_redirect"])) {
						$redirect = base_url($_SESSION["login_redirect"]);
						unset($_SESSION['login_redirect']);
					}
					else {
						$redirect = base_url('/admin/');
					}
					
					$out["error"] = false;
					$out["redirect"] = $redirect;
					print json_encode($out);
					exit();
				}
				else {
					$out["error"] = true;
					$out["msg"] = "Username atau Password tidak sesuai";
					
					print json_encode($out);
					exit();
				}
			}
			
		}
		else {
			is_dir($this->captcha_config["img_path"]) || @mkdir($this->captcha_config["img_path"]) || die("Can't Create folder");

			$captcha = create_captcha($this->captcha_config);
			$this->session->unset_userdata('valuecaptchaCode');
			$this->session->set_userdata('valuecaptchaCode', $captcha['word']);

			$data = array();
			$data['captchaImg'] = $captcha['image'];

			$this->load->view('backend/user/login', $data);
		}
		
	}

	public function refresh_captcha () {
		$this->load->helper('captcha');
		$out = array();
		$out["error"] = false;

		$captcha = create_captcha($this->captcha_config);
		$this->session->unset_userdata('valuecaptchaCode');
		$this->session->set_userdata('valuecaptchaCode', $captcha['word']);

		$out["captcha"] = $captcha["image"];

		print json_encode($out);
		exit();
	}
	
	public function save () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan user!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			$process = true;
			
			if (isset($data["username"])) {
				$user = $this->user_model->getUserByUsername($data["username"]);
				
				if (!empty($user)) {
					$process = false;
					$out["error"] = true;
					$out["msg"] = "Username tidak tersedia!";
				}
			}
			
			if ($process) {
		
				$id = (isset($data["id"]) ? $data["id"] : "");

				unset($data["id"]);
				
				if (isset($data["akses"])) {
					$data["akses"] = json_encode($data["akses"]);
				}

				$id = $this->user_model->save($data, $id);

				if (empty($id)) {
					$out["error"] = true;
					$out["msg"] = "Gagal menyimpan user. Silahkan coba lagi!";
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	
	public function edit () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan user!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			ini_set('display_errors', '1');
			ini_set('display_startup_errors', '1');
			error_reporting(E_ALL);
			
			$data = $_POST;
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			if (isset($data["akses"])) {
				$data["akses"] = json_encode($data["akses"]);
			}

			$id = $this->user_model->save($data, $id);

			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan user. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function reset_password () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil mereset password!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			$process = true;
			
			if ($data["password"] != $data["confirm_password"]) {
				$process = false;
				$out["error"] = true;
				$out["msg"] = "Password dan Konfirmasi Password tidak sama!";
			}
			
			if ($process) {
				$this->user_model->savePassword($data["password"], $data["id"]);
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function logout () {
		session_destroy();
		
		redirect(base_url("/admin/login"));
	}
	
	function sync_biodata () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyinkrokan biodata!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$data = array();
			$data["sync_biodata"] = $_POST["sync_biodata"];
			
			$id = $this->user_model->save($data, $id);

			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan user. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}

	function change_photo_profile () {
		$this->auth->login();
		$this->load->view('backend/user/modal_change_photo_profile');
	}

	public function upload_photo_profile () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_FILES) && !empty($_FILES)) {
			$file = $_FILES['file'];
			
			$allowed = array('jpg', 'jpeg', 'png');
			$filename = $file['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			$allowedSize = 3145728; // 5 Mb
			
			// Check File Type
			if (in_array($ext, $allowed)) {
				if ($file["size"] <= $allowedSize) {

					$tempFile = $file["tmp_name"];

					// Handle File To Upload
					$targetPath = APPPATH . "../assets/user_profile";
					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
					chmod($targetPath, 0755);
					
					$targetFile =  "photo_".$_SESSION["user"]["id"].".".$ext;
					move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);

					// Handle File Upload
					$image = new Imagick($targetPath. "/" .$targetFile);

					$flattened = new Imagick();
					$flattened->newImage($image->getImageWidth(), $image->getImageHeight(), new ImagickPixel("white"));

					$flattened->compositeImage($image, imagick::COMPOSITE_OVER, 0, 0);

					$flattened->setImageFormat("jpg");
					$flattened->writeImage($targetPath. "/" ."photo_".$_SESSION["user"]["id"].".jpg");

					$image->clear();
					$image->destroy();
					$flattened->clear();
					$flattened->destroy();

					if (file_exists($targetPath. "/" ."photo_".$_SESSION["user"]["id"].".png")) {
						unlink($targetPath. "/" ."photo_".$_SESSION["user"]["id"].".png");
					}

					if (file_exists($targetPath. "/" ."photo_".$_SESSION["user"]["id"].".jpeg")) {
						unlink($targetPath. "/" ."photo_".$_SESSION["user"]["id"].".jpeg");
					}
				}
				else {
					$out["error"] = true;
					$out["msg"] = "Maksimal ukuran file adalah 3Mb";
				}
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Tipe file tidak diizinkan";
			}
		}
		
		print json_encode($out);
	}

	function crop_photo_profile () {
		$this->auth->login();
		$this->load->view('backend/user/modal_crop_photo_profile');
	}

	function cropped_photo_profile () {
		$folderPath = APPPATH . "../assets/user_profile";
		$image_parts = explode(";base64,", $_POST['image']);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		$filename = "profile_".$_SESSION["user"]["id"].".png";
		$file = $folderPath . "/" .$filename;

		file_put_contents($file, $image_base64);

		// Handle File to resize
		$imagick = new Imagick($file);
		$imagick->resizeImage(0, 150, Imagick::FILTER_CATROM, 1);
		$imagick->writeImage($file);

		$response = array(
			'status' => true,
			'msg' => 'Image uploaded on server successfully!',
			'file' => $file,
			'path' => base_url("assets/user_profile/".$filename)."?v=".rand()
		);

		print json_encode($response);
	}
	
	function sync_drive () {
		$this->auth->login();
		
		$this->load->view('backend/user/sync_drive');
	}
	
	function oAuthUrl () {
		$this->auth->login();
		$data = array();
		$data["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data["url"] = $this->google->authUrl();
			$data["error"] = false;
		}
		
		print json_encode($data);
		exit();
	}
	
	public function oAuth2 () {
		if (isset($_GET["code"]) && $this->google->isAuthenticated($_GET["code"])) {
			$token = $this->google->getAccessToken();
			$this->google->setAccessToken($token);
			$googleUser = $this->google->getUserDetail();
			
			$user = $_SESSION["user"];
			
			$this->google->saveTokenFile($user["id"], json_encode($token));
			
			$rootDriveId = $this->google->createDriveFolder("SILIK BALI");
			
			$data = array();
			$data["sync_drive"] = $googleUser['email'];
			$data["drive_folder_id"] = $rootDriveId;
			
			$id = $this->user_model->save($data, $user["id"]);
			$_SESSION["user"]["sync_drive"] = $googleUser['email'];
			
			redirect(base_url("/admin/user/sync_drive"));
		}
	}
	
	public function profile () {
		$this->auth->login();
		$this->load->view('backend/user/profile');
	}
	
	public function bank () {
		$this->auth->login();
		$this->load->view('backend/user/bank');
	}
	
	public function change_password () {
		$this->auth->login();
		$this->load->view('backend/user/change_password');
	}
	
	public function documents () {
		$this->auth->login();
		$this->load->view('backend/user/documents');
	}
	
	public function uploadDocument () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_FILES) && !empty($_FILES)) {
			$file = $_FILES['file'];
			$nama = $_POST["nama"];
			
			$allowed = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');
			$filename = $file['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			$allowedSize = 3145728; // 5 Mb
			
			// Check File Type
			if (in_array($ext, $allowed)) {
				if ($file["size"] <= $allowedSize) {
					$user = $this->user_model->getUserById($_SESSION["user"]["id"]);
					
					
					$tempFile = $file["tmp_name"];          

					$targetPath = $dir = APPPATH . "../assets/user_dokumen/".$_SESSION["user"]["id"];

					is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
					
					$targetFile = str_replace(' ', '-', $filename);
					$targetFile = str_replace($ext, '', $targetFile);
					$targetFile = preg_replace('/[^A-Za-z0-9\-]/', '', $targetFile);
					$targetFile = strtolower($targetFile);
					
					$targetFile =  $targetFile."_".$_SESSION["user"]["username"].".".$ext;

					if (move_uploaded_file($tempFile,$targetPath. "/" .$targetFile)) {
						// save file db
						$data = array();
						$data["user_id"] = $user["id"];
						$data["nama"] = $nama;
						$data["filename"] = $targetFile;
						$data["size"] = $file["size"];
						$data["type"] = $ext;

						$out["id"] = $this->user_model->saveDocument($data);
					}
					else {
						$out["error"] = true;
						$out["msg"] = "Gagal mengunggah file";
					}
				}
				else {
					$out["error"] = true;
					$out["msg"] = "Maksimal ukuran file adalah 3Mb";
				}
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Tipe file tidak diizinkan";
			}
		}
		
		print json_encode($out);
	}
	
	public function download_dokumen ($id = 0) {
		$this->auth->login();
		
		if (!empty($id)) {
			$dok = $this->user_model->getDocumentById($id);
			
			$filePath = APPPATH . "../assets/user_dokumen/".$dok["user_id"]."/".$dok["filename"];
			
			if(file_exists($filePath)) {
				$fileName = basename($filePath);
				$fileSize = filesize($filePath);

				// Output headers.
				header("Cache-Control: private");
				header("Content-Type: application/stream");
				header("Content-Length: ".$fileSize);
				header("Content-Disposition: attachment; filename=".$fileName);

				// Output file.
				readfile ($filePath);                   
				exit();
			}
			else {
				die('The provided file path is not valid.');
			}
		}
	}
	
	public function save_password () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil mengganti password!";
		
		if (isset($_POST) && !empty($_POST)) {
			if (isset($_POST) && !empty($_POST)) {
				$data = $_POST;
				$process = true;

				if ($data["password"] != $data["confirm_password"]) {
					$process = false;
					$out["error"] = true;
					$out["msg"] = "Password dan Konfirmasi Password tidak sama!";
				}

				if ($process) {
					$this->user_model->savePassword($data["password"], $data["id"]);
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function quotes () {
		$this->auth->login();
		$this->load->view('backend/user/quotes');
	}
	
	public function saveQuote () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan kutipan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			if (isset($_POST) && !empty($_POST)) {
				$data = $_POST;
				$this->user_model->saveQuote($data);
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function penugasan () {
		$this->auth->login();
		$this->load->view('backend/user/penugasan');
	}
	
	public function saveLaporanPerjadin () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan laporan.";
		$out["close_modal"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$submitType = $_POST["submit_btn"];
			
			$data = array();
			$data["laporan_tugas"] = $_POST["laporan_tugas"];
			$data["laporan_hasil"] = $_POST["laporan_hasil"];
			$data["laporan_ttd"] = "";
			$data["spd_jabatan"] = $_POST["spd_jabatan"];
			$data["spd_satker"] = $_POST["spd_satker"];
			$data["spd_nama"] = $_POST["spd_nama"];
			$data["spd_nip"] = $_POST["spd_nip"];
			$data["status"] = '1';
			
			
			if ($submitType == "validasi") {
				$out["msg"] = "Berhasil mengirim laporan untuk validasi.";
				$data["status"] = '2';
			}
			
			if ($submitType == "preview") {
				$out["close_modal"] = false;
			}
			
			if (isset($_FILES) && !empty($_FILES)) {
				
				$allowed = array('jpg', 'jpeg', 'png');
				$allowedSize = 2097152; // 2 Mb
				
				if (isset($_FILES['laporan_foto']) && !empty($_FILES['laporan_foto'])) {
				
					$fotos = $_FILES['laporan_foto'];

					if (!empty($fotos) && isset($fotos["name"]) && !empty($fotos["name"])) {
						foreach ($fotos["name"] as $fotoKey => $foto) {
							if (isset($fotos['name'][$fotoKey])) {
								$filename = $fotos['name'][$fotoKey];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);

								// Check File Type
								if (in_array($ext, $allowed)) {
									if ($fotos["size"][$fotoKey] <= $allowedSize) {

										// Handle File To Upload 
										$tempFile = $fotos["tmp_name"][$fotoKey];

										$targetPath = APPPATH . "../assets/laporan_perjadin";
										is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
										chmod($targetPath, 0755);

										$targetPath = $targetPath."/".$_SESSION["tahun_anggaran"];
										is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
										chmod($targetPath, 0755);

										$targetPath = $targetPath."/".$id;
										is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
										chmod($targetPath, 0755);
										
										$targetFile =  "foto_".($fotoKey + 1).".".$ext;
										move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);

										// Handle File to resize
										$imagick = new Imagick($targetPath. "/" .$targetFile);
										$imagick->resizeImage(0, 400, Imagick::FILTER_CATROM, 1);
										$imagick->writeImage($targetPath. "/" .$targetFile);

										$data["laporan_foto"][] = $targetFile;
									}
									else {
										$out["error"] = true;
										$out["msg"] = "Maksimal ukuran foto adalah 2Mb";
									}
								}
								else {
									$out["error"] = true;
									$out["msg"] = "Tipe file foto tidak diizinkan. Silahkan mengupload file jpg, jpeg atau png.";
								}
							}
						}
					}
				}
				
				
				if (isset($_FILES['stamp']) && !empty($_FILES['stamp'])) {
					$stamp = $_FILES['stamp'];
					$filename = $stamp['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					// Check File Type
					if (in_array($ext, $allowed)) {
						if ($stamp["size"] <= $allowedSize) {

							// Handle Upload File
							$tempFile = $stamp["tmp_name"];

							$targetPath = APPPATH . "../assets/laporan_perjadin";
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetPath = $targetPath."/".$_SESSION["tahun_anggaran"];
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetPath = $targetPath."/".$id;
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetFile =  "stamp.".$ext;
							move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);
							
							// Handle Transparant and Crop Stamp
							$imagick = new Imagick($targetPath. "/" .$targetFile);
							$imagick->floodFillPaintImage("rgb(255, 0, 255)", 5000, "rgb(255,255,255)", 0 , 0, false);
							$imagick->transparentPaintImage("rgb(255,0,255)", 0, 5, false);
							$imagick->setImageFormat('png');
							$imagick->trimImage(20000);
							$imagick->resizeImage(0, 300, Imagick::FILTER_CATROM, 1);
							$imagick->writeImage($targetPath. "/stamp.png");
							
							if ($ext != "png") {
								if (file_exists($targetPath. "/" .$targetFile)) {
									unlink($targetPath. "/" .$targetFile);
								}
							}

							// Handle data to save database
							$data["spd_cap"] = "stamp.png";
						}
						else {
							$out["error"] = true;
							$out["msg"] = "Maksimal ukuran Stempel adalah 2Mb";
						}
					}
					else {
						$out["error"] = true;
						$out["msg"] = "Tipe file Stempel tidak diizinkan. Silahkan mengupload file bertipe .png";
					}
				}
				
				if (isset($_FILES['bukti_pengeluaran']) && !empty($_FILES['bukti_pengeluaran'])) {
					$buktiPengeluaran = $_FILES['bukti_pengeluaran'];
					$filename = $buktiPengeluaran['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					$allowed = array('pdf');
					$allowedSize = 5242880; // 5 Mb

					// Check File Type
					if (in_array($ext, $allowed)) {
						if ($buktiPengeluaran["size"] <= $allowedSize) {

							// Handle Upload File
							$tempFile = $buktiPengeluaran["tmp_name"];

							$targetPath = APPPATH . "../assets/laporan_perjadin";
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetPath = $targetPath."/".$_SESSION["tahun_anggaran"];
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetPath = $targetPath."/".$id;
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetFile =  "bukti_pengeluaran.".$ext;
							move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);
						}
						else {
							$out["error"] = true;
							$out["msg"] = "Maksimal ukuran Bukti Pengeluaran adalah 1Mb";
						}
					}
					else {
						$out["error"] = true;
						$out["msg"] = "Tipe file Bukti Pengeluaran tidak diizinkan. Silahkan mengupload file bertipe .pdf";
					}
				}
			}
			
			// Convert to json before save
			if (isset($data["laporan_foto"]) && !empty($data["laporan_foto"])) {
				$data["laporan_foto"] = json_encode($data["laporan_foto"]);
			}
			
			$tglBuatLaporan = date("Y-m-d H:i:s");
			
			$data["dibuat_tgl"] = $this->getLastDateWorkDay($tglBuatLaporan);
			$data["diubah_tgl"] = $this->getLastDateWorkDay($tglBuatLaporan);
			
			$this->load->model('penugasan_model');
			$out["id"] = $this->penugasan_model->saveItem($data, $id);
			
			
			if ($data["status"] == "2") {
				// Notif Telegram
				$users = $this->user_model->getUser();
				
				if (!empty($users)) {
					foreach ($users as $user) {
						if (isset($user["akses"]["keuangan"]["apr_perjadin"]) && $user["akses"]["keuangan"]["apr_perjadin"] == "1") {
							
							$this->load->model("penugasan_model");
							$this->load->library("telegram");
							
							$approvalPenugasan = $this->penugasan_model->getItemByStatus($data["status"]);
							
							$chatID = $user["telegram_chat_id"];
							
							$msg = "Hi.. <b>".$user["nama"]."</b>, \n";
							$msg .= "Ada ".count($approvalPenugasan)." laporan perjalanan dinas yang perlu disetujui. Silahkan <a href='".base_url("/admin/spj/approve_perjadin/")."'>klik disini</a> untuk melihat laporan. \n";
							$msg .= "Terimakasih.";
							
							if (!empty($chatID)) {
								$this->telegram->sendChat($chatID, $msg);	
							}
						}
					}
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function preview_laporan_perjadin ($id = '0') {
		$data = array();
		$html = "Laporan tidak ditemukan";
		
		if (!empty($id)) {
			// GET DATA SATKER
			$this->load->model("pengaturan_model");
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");

			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$data["satker"][$foo["sistem"]] = $foo["value"];
				}
			}
			
			// PEJABAT PPK
			$data["ppk"] = $this->getPejabat("ppk");
			$data["kasubbag"] = $this->getPejabat("kasubbag");
			$data["kepala"] = $this->getPejabat("kepala");
			
			// GET DATA ITEM
			$this->load->model("penugasan_model");
			$data["item"] = $this->penugasan_model->getItemById($id);
			
			if (!empty($data["item"]) && !empty($data["item"]["penugasan_id"])) {
				$data["penugasan"] = $this->penugasan_model->getById($data["item"]["penugasan_id"]);
				
				// SET PENANGGUNGJAWAB
				if (isset($data["kasubbag"]["ktp"]) && $data["kasubbag"]["ktp"] == $data["item"]["ktp"]) {
					$data["pj"] = $data["kepala"];
				}
				else if (isset($data["kepala"]["ktp"]) && $data["kepala"]["ktp"] == $data["item"]["ktp"]) {
					$data["pj"] = $data["kepala"];
				}
				else {
					$data["pj"] = $data["kasubbag"];
				}
				
				
				// DEFINE DATA ITEM
				$data["item"]["no_spd"] = "0000/SPD.00/000000/0000";
				$data["item"]["dipa_mak"] = "000.00.XX / 0000.XXX.000.000.XX.000000";
				
				$data["spj_item"]["no_spd"] = $data["item"]["no_spd"];
				
				$perjadin = array();
				//$perjadin["surat_tugas"] = APPPATH . "../assets/surat_tugas/penugasan/".$data["penugasan"]["surat"];
				
				$perjadin["spd_depan"] = $this->load->view('template/sppd_depan_penugasan', $data, true);
				$perjadin["spd_belakang"] = $this->load->view('template/sppd_belakang_penugasan', $data, true);
				
				$buktiPengeluaran = APPPATH . "../assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$id."/bukti_pengeluaran.pdf";
				
				if (file_exists($buktiPengeluaran)) {
					$perjadin["bukti_pengeluaran"] = $buktiPengeluaran;
				}
				
				$perjadin["laporan"] = $this->load->view('template/laporan_perjadin', $data, true);
				$this->mpdf->createLaporanPerjadin($perjadin,"laporan_perjadin".$id, false);
			}
			else {
				print "ERROR PAGE LAPORAN";
			}
		}
		else {
			print "ERROR PAGE LAPORAN";
		}
	}
	
	public function laporan_perjadin ($id = '0') {
		$data = array();
		$html = "Laporan tidak ditemukan";
		
		if (!empty($id)) {
			// GET DATA SATKER
			$this->load->model("pengaturan_model");
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");

			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$data["satker"][$foo["sistem"]] = $foo["value"];
				}
			}
			
			// GET DATA ITEM
			$this->load->model("penugasan_model");
			$data["item"] = $this->penugasan_model->getItemById($id);
			
			$this->load->model("spj_model");
			$data["spj_item"] = $this->spj_model->getItemById($data["item"]["spj_item_id"]);
			
			
			// PEJABAT PPK
			$data["ppk"] = array("nama" => "", "nip" => "");
			
			// PEJABAT PJ
			$data["pj"] = array("nama" => "", "nip" => "", "jabatan" => "");
			
			if (!empty($data["spj_item"])) {
				// PEJABAT PPK
				$data["ppk"] = array("nama" => $data["spj_item"]["nama_ppk"], "nip" => $data["spj_item"]["nip_ppk"]);
				
				// PEJABAT PJ
				$data["pj"] = array("nama" => $data["spj_item"]["nama_pj"], "nip" => $data["spj_item"]["nip_pj"], "jabatan" => $data["spj_item"]["jabatan_pj"]);
				
				// Hack Kepala
				$data["kepala"] = $this->getPejabat("kepala");
				
				if (isset($data["kepala"]["ktp"]) && $data["kepala"]["ktp"] == $data["spj_item"]["ktp"]) {
					$data["pj"] = $data["kepala"];
				}
			}
			
			
			if (!empty($data["item"]) && !empty($data["item"]["penugasan_id"])) {
				// QR CODE
				$this->load->library('qr_code');
				$this->load->model("validasi_ttd_model");
				
				$data["penugasan"] = $this->penugasan_model->getById($data["item"]["penugasan_id"]);
				
				if (!empty($data["item"]["dipa_balai"])) {
					// DEFINE DATA ITEM
					if (date("Y", strtotime($data["spj_item"]["dibuat_tgl"])) == "2022") {
						$data["item"]["no_spd"] = $this->utility->penomoran($data["spj_item"]["id"])."/SPD/".$data["satker"]["kode_satker"]."/".date("Y", strtotime($data["spj_item"]["dibuat_tgl"]));
					}
					else {
						$data["item"]["no_spd"] = $this->utility->penomoran($data["spj_item"]["no_urut"])."/SPD.".$data["spj_item"]["spj_id"]."/".$data["satker"]["kode_satker"]."/".date("Y", strtotime($data["spj_item"]["dibuat_tgl"]));
					}
					
					
					$data["spj_item"]["no_spd"] = $data["item"]["no_spd"];
					

					$data["item"]["dipa_mak"] = $data["spj_item"]["dipa_program"]." / ".$data["spj_item"]["dipa_kegiatan"].".".$data["spj_item"]["dipa_kro"].".".$data["spj_item"]["dipa_ro"].".".$data["spj_item"]["dipa_komponen"].".".$data["spj_item"]["dipa_sub_komponen"].".".$data["spj_item"]["dipa_akun_transport"];



					$data["validasi"]["spd_depan"] = "";
					$data["validasi"]["spd_belakang_berangkat"] = "";
					$data["validasi"]["spd_belakang_pulang"] = "";
					$data["validasi"]["spd_belakang_ppk"] = "";
				
				
					$validasi = $this->validasi_ttd_model->get("Surat Perjalanan Dinas", $data["item"]["id"]);

					if (!empty($validasi)) {
						foreach ($validasi as $val) {
							$url = base_url("/validasi/ttd/".$val["kode"]);
							$data["validasi"][$val["posisi_ttd"]] = $this->qr_code->create(100, $url);
						}
					}
				}
				
				// Perjadin
				$data["validasi"]["perjadin"] = "";
				$validasi = $this->validasi_ttd_model->get("Laporan Perjalanan Dinas", $data["item"]["id"]);
				
				if (!empty($validasi)) {
					foreach ($validasi as $val) {
						$url = base_url("/validasi/ttd/".$val["kode"]);
						$data["validasi"][$val["posisi_ttd"]] = $this->qr_code->create(100, $url);
					}
				}
				
				// Hack Barcode SPD Depan
				if (isset($data["validasi"]["spd_depan"])) {
					$data["validasi"]["spd_depan"] = $this->qr_code->create(100, strtoupper(md5($data["satker"]["kode_satker"])).".".$data["spj_item"]["id"]);
				}
				
				// BUILD PDF
				$perjadin = array();
				//$perjadin["surat_tugas"] = APPPATH . "../assets/surat_tugas/penugasan/".$data["penugasan"]["surat"];
				
				if (!empty($data["item"]["dipa_balai"])) {
					
					if (!$data["penugasan"]["penugasan_internal"]) {
						$perjadin["susunan_pertanggungjawaban"] = $this->load->view('template/susunan_pertanggungjawaban_perjadin', $data, true);
					}
					
					$perjadin["spd_depan"] = $this->load->view('template/sppd_depan_penugasan', $data, true);
					
					if (!$data["penugasan"]["penugasan_internal"]) {
						$perjadin["spd_belakang"] = $this->load->view('template/sppd_belakang_penugasan', $data, true);
					}
					
					$perjadin["rincian_biaya_perjadin"] = $this->load->view('template/rincian_perjadin', $data, true);
					
					if ($data["spj_item"]["dpr_taksi_berangkat"] > 0 || $data["spj_item"]["dpr_taksi_pulang"] > 0 || $data["spj_item"]["dpr_transport"] > 0 || $data["spj_item"]["dpr_transport_lainnya"] > 0 || $data["spj_item"]["dpr_penginapan"] > 0) {
						$perjadin["daftar_pengeluaran_riil"] = $this->load->view('template/daftar_pengeluaran_riil', $data, true);
					}
					
					$buktiPengeluaran = APPPATH . "../assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$id."/bukti_pengeluaran.pdf";
				
					if (file_exists($buktiPengeluaran)) {
						$perjadin["bukti_pengeluaran"] = $buktiPengeluaran;
					}
					
					if ($data["item"]["provinsi_asal"] != $data["item"]["provinsi_tujuan"]) {
					    $perjadin["surat_pernyataan"] = $this->load->view('template/surat_pernyataan_perjadin', $data, true);
					}
					else {
						if (file_exists($buktiPengeluaran)) {
							$perjadin["surat_pernyataan"] = $this->load->view('template/surat_pernyataan_perjadin_lokal', $data, true);
						}
					}
				}
				
				if (!$data["penugasan"]["penugasan_internal"]) {
					$perjadin["laporan"] = $this->load->view('template/laporan_perjadin', $data, true);
				}
				
				$this->mpdf->createLaporanPerjadin($perjadin,"laporan_perjadin".$id, false);
			}
			else {
				print "ERROR PAGE LAPORAN";
			}
		}
		else {
			print "ERROR PAGE LAPORAN";
		}
	}
	
	private function getPejabat ($jabatan) {
		$out = array();
		$out["nip"] = "";
		$out["nama"] = "";
		
		$this->load->model("pengaturan_model");
		$this->load->model("biodata_model");

		$pejabat = $this->pengaturan_model->getPengaturanBySistem($jabatan);

		if (!empty($pejabat)) {
			$biodataId = $pejabat["value"];

			$out = $this->biodata_model->getBiodataById($biodataId);
		}
		
		return $out;
	}
	
	public function saveApprovePerjadin () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyetujui laporan.";
		$out["close_modal"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$this->load->model('penugasan_model');
			$this->load->model('biodata_model');
			$this->load->model("pengaturan_model");
			$this->load->library('telegram');
			
			$data = array();
			
			$id = $_POST["id"];
			
			if (isset($_POST["status"])) {
				$data["status"] = $_POST["status"];
			}
			
			if (isset($_POST["dipa_balai"])) {
				$data["dipa_balai"] = $_POST["dipa_balai"];
			}
			
			// TOLAK PERJADIN
			if (isset($_POST["status"]) && $_POST["status"] == "4") {
				if (isset($_POST["keterangan"])) {
					$data["keterangan_ditolak"] = $_POST["keterangan"];
				}
				
				$data["ditolak_tgl"] = date("Y-m-d H:i:s");
				$data["ditolak_oleh"] = $_SESSION["user"]["id"];
				
				$out["msg"] = "Berhasil menolak laporan.";
			}
			
			// APPROVE PERJADIN
			if (isset($_POST["status"]) && $_POST["status"] == "3") {
				$data["disetujui_tgl"] = date("Y-m-d H:i:s");
				$data["disetujui_oleh"] = $_SESSION["user"]["id"];
			}
			
			$out["id"] = $this->penugasan_model->saveItem($data, $id);
			
			$item = $this->penugasan_model->getItemById($id);
			$biodataPetugas = $this->biodata_model->getBiodataByNik($item["ktp"]);
			$userPetugas = $this->user_model->getUserBySyncBiodata($biodataPetugas["id"]);
			$penugasan = $this->penugasan_model->getById($item["penugasan_id"]);
			
			// MAKE SPJ DATA
			if (isset($_POST["status"]) && $_POST["status"] == "3") {
				
				$this->load->model("validasi_ttd_model");
				
				// GET DATA SATKER
				$getSatker = $this->pengaturan_model->getPengaturanBySection("satker");
				$satker = array("kode_surat" => "", "kode_satker" => "");
				
				if (!empty($getSatker)) {
					foreach ($getSatker as $foo) {
						$satker[$foo["sistem"]] = $foo["value"];
					}
				}
				
				// PEJABAT
				$ppk = $this->getPejabat("ppk");
				$bp = $this->getPejabat("bp");
				$kasubbag = $this->getPejabat("kasubbag");
				$kepala = $this->getPejabat("kepala");
				$pj = array("nama" => "", "nip" => "");
				
				
				if (isset($_POST["dipa_balai"]) && !empty($_POST["dipa_balai"])) {
					// SAVE SPJ
					$this->load->model("spj_model");
					
					if (isset($penugasan["kegiatan_id"]) && !empty($penugasan["kegiatan_id"])) {
						$spj = $this->spj_model->getByKegiatanIdKomponen($penugasan["kegiatan_id"], $penugasan["tipe"]);
					}
					else {
						$spj = $this->spj_model->getByPenugasanIdKegiatanId($penugasan["id"], $penugasan["kegiatan_id"]);
					}

					$dataSpj = array();
					$dataSpj["penugasan_id"] = $penugasan["id"];

					$spjId = $this->spj_model->save($dataSpj, $spj["id"]);
					
					
					// GET ALL SPJ ITEMS
					$spjItems = $this->spj_model->getItemBySpjId($spj["id"]);
					
					// GET SPJ ITEM IF EXIST
					$spjItem = $this->spj_model->getItemByPenugasanItemId($item["id"]);
					
					if (!isset($spjItem["id"])) {
						$spjItem["id"] = 0;
					}
					
					
					// SAVE SPJ ITEM
					$dataSpjItem = array();
					
					if (empty($spjItem["id"])) {
						$dataSpjItem["no_urut"] = count($spjItems) + 1;	
					}
					else {
						$dataSpjItem["no_urut"] = $spjItem["no_urut"];	
					}
					
					$dataSpjItem["spj_id"] = $spjId;
					$dataSpjItem["penugasan_item_id"] = $id;
					
					if (isset($spj["dipa"]["program"])) {
						$dataSpjItem["dipa_program"] = $spj["dipa"]["program"];
						$dataSpjItem["dipa_kegiatan"] = $spj["dipa"]["kegiatan"];
						$dataSpjItem["dipa_kro"] = $spj["dipa"]["kro"];
						$dataSpjItem["dipa_ro"] = $spj["dipa"]["ro"];
						$dataSpjItem["dipa_komponen"] = $spj["dipa"]["komponen"];
						$dataSpjItem["dipa_sub_komponen"] = $spj["dipa"]["sub_komponen"];
												
						$dataSpjItem["dipa_akun_transport"] = $spj["dipa"]["akun_transport"];
						//$dataSpjItem["dipa_akun_honor"] = $spj["dipa"]["akun_honor"];
					}
					
					if (isset($spj["based"]["nomor_surat"])) {
						$dataSpjItem["nomor_surat"] = "Surat Tugas";
						$dataSpjItem["nomor_surat"] = $spj["based"]["nomor_surat"];
					}

					if (isset($spj["based"]["tgl_surat"])) {
						$dataSpjItem["tgl_surat"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $spj["based"]["tgl_surat"])));
					}
					
					$dataSpjItem["ktp"] = $item["ktp"];
					$dataSpjItem["nama"] = $item["nama"];
					$dataSpjItem["telp"] = $item["telp"];
					$dataSpjItem["nip"] = $item["nip"];
					$dataSpjItem["pangkat"] = $item["pangkat"];
					$dataSpjItem["golongan"] = $item["golongan"];
					$dataSpjItem["jabatan"] = $item["jabatan"];
					$dataSpjItem["npwp"] = $item["npwp"];
					$dataSpjItem["unit_kerja"] = $item["unit_kerja"];
					$dataSpjItem["pegawai_balai"] = $item["pegawai_balai"];
					$dataSpjItem["nama_bank"] = $item["nama_bank"];
					$dataSpjItem["no_rekening"] = $item["no_rekening"];
					$dataSpjItem["nama_pemilik_rekening"] = $item["nama_pemilik_rekening"];
					$dataSpjItem["provinsi_asal"] = $item["provinsi_asal"];
					$dataSpjItem["provinsi_tujuan"] = $item["provinsi_tujuan"];
					$dataSpjItem["kab_asal"] = $item["kab_asal"];
					$dataSpjItem["kab_tujuan"] = $item["kab_tujuan"];
					$dataSpjItem["tgl_mulai_tugas"] = $item["tgl_mulai_tugas"];
					$dataSpjItem["tgl_selesai_tugas"] = $item["tgl_selesai_tugas"];
					
					if (isset($kasubbag["ktp"]) && ($kasubbag["ktp"] == $item["ktp"] || $kepala["ktp"] == $item["ktp"])) {
						$dataSpjItem["nama_pj"] = $kepala["nama"];
						$dataSpjItem["nip_pj"] = $kepala["nip"];
						$dataSpjItem["jabatan_pj"] = $kepala["jabatan"];
						$pj["nama"] = $kepala["nama"];
						$pj["nip"] = $kepala["nip"];
					}
					else {
						$dataSpjItem["nama_pj"] = $kasubbag["nama"];
						$dataSpjItem["nip_pj"] = $kasubbag["nip"];
						$dataSpjItem["jabatan_pj"] = $kasubbag["jabatan"];
						$pj["nama"] = $kasubbag["nama"];
						$pj["nip"] = $kasubbag["nip"];
					}
					
					$dataSpjItem["nama_ppk"] = $ppk["nama"];
					$dataSpjItem["nip_ppk"] = $ppk["nip"];
					$dataSpjItem["nama_bp"] = $bp["nama"];
					$dataSpjItem["nip_bp"] = $bp["nip"];
					
					// HACK Kab SPJ dan Tgl SPJ
					$dataSpjItem["kab_kuitansi"] = $_ENV["DEFAULT_KABUPATEN"];

					if (isset($_POST["tgl_kuitansi"])) {
						$dataSpjItem["tgl_kuitansi"] = date("Y-m-d", strtotime(str_replace(array("/"),array("-"), $_POST["tgl_kuitansi"])));
					}
					else {
						$dataSpjItem["tgl_kuitansi"] = date('Y-m-d', strtotime("next thursday"));
					}
					
					// HACK Tanggal Kuitansi
					$dataSpjItem["tgl_kuitansi"] = $this->getLastDateWorkDay($dataSpjItem["tgl_kuitansi"]);	
					
					// HACK Tanggal Kuitansi
					if ($dataSpj["penugasan_id"] == "176") {
						$dataSpjItem["tgl_kuitansi"] = date('Y-m-d', "2025-12-24");
					}
					
					// NOMINAL PEMBAYARAN
					if (isset($_POST["pesawat_berangkat"])) {
						$dataSpjItem["pesawat_berangkat"] = $_POST["pesawat_berangkat"];
					}
					if (isset($_POST["pesawat_pulang"])) {
						$dataSpjItem["pesawat_pulang"] = $_POST["pesawat_pulang"];
					}
					
					if (isset($_POST["taksi_berangkat"])) {
						$dataSpjItem["taksi_berangkat"] = $_POST["taksi_berangkat"];
					}
					if (isset($_POST["dpr_taksi_berangkat"])) {
						$dataSpjItem["dpr_taksi_berangkat"] = $_POST["dpr_taksi_berangkat"];
					}
					
					if (isset($_POST["taksi_pulang"])) {
						$dataSpjItem["taksi_pulang"] = $_POST["taksi_pulang"];
					}
					if (isset($_POST["dpr_taksi_pulang"])) {
						$dataSpjItem["dpr_taksi_pulang"] = $_POST["dpr_taksi_pulang"];
					}
					
					
					if (isset($_POST["transport"])) {
						$dataSpjItem["transport"] = $_POST["transport"];
					}
					
					if (isset($_POST["dpr_transport"])) {
						$dataSpjItem["dpr_transport"] = $_POST["dpr_transport"];
					}
					
					if (isset($_POST["keterangan_transport"])) {
						$dataSpjItem["keterangan_transport"] = $_POST["keterangan_transport"];
					}
					
					if (isset($_POST["transport_lainnya"])) {
						$dataSpjItem["transport_lainnya"] = $_POST["transport_lainnya"];
					}
					
					if (isset($_POST["dpr_transport_lainnya"])) {
						$dataSpjItem["dpr_transport_lainnya"] = $_POST["dpr_transport_lainnya"];
					}
					
					if (isset($_POST["keterangan_transport_lainnya"])) {
						$dataSpjItem["keterangan_transport_lainnya"] = $_POST["keterangan_transport_lainnya"];
					}
					
					if (isset($_POST["uang_harian"])) {
						$dataSpjItem["uang_harian"] = $_POST["uang_harian"];
					}
					
					if (isset($_POST["penginapan"])) {
						$dataSpjItem["penginapan"] = $_POST["penginapan"];
					}
					
					if (isset($_POST["dpr_penginapan"])) {
						$dataSpjItem["dpr_penginapan"] = $_POST["dpr_penginapan"];
					}
					
					if (isset($_POST["keterangan_penginapan"])) {
						$dataSpjItem["keterangan_penginapan"] = $_POST["keterangan_penginapan"];
					}
					

					$spjItemId = $this->spj_model->saveItem($dataSpjItem, $spjItem["id"]);
					
					
					
					// UPDATE PENUGASAN ITEM
					$dataPenugasanItem = array();
					$dataPenugasanItem["spj_item_id"] = $spjItemId;
					$this->penugasan_model->saveItem($dataPenugasanItem, $id);					
					
					// BUAT VALIDASI TTD
					// SPD Depan
					$data = array();
					$data["id_berkas"] = $item["id"];
					$data["jenis_berkas"] = "Surat Perjalanan Dinas";
					$data["posisi_ttd"] = "spd_depan";

					$detail = array();
					$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
					$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
					$detail["Keterangan_Tugas"] = $penugasan["nama"];
					
					$detail["Nomor_SPD"] = $this->utility->penomoran($dataSpjItem["no_urut"])."/SPD.".$dataSpjItem["spj_id"]."/".$satker["kode_satker"]."/".date("Y");
					$detail["Tgl_SPD"] = $penugasan["tgl_surat"];					
					
					$detail["Disetujui_oleh_PPK"] = $ppk["nama"];
					$detail["Disetujui_Tgl"] = $penugasan["tgl_surat"];

					$data["detail"] = json_encode($detail);
					$this->validasi_ttd_model->save($data);


					// SPD Belakang Berangkat
					$data = array();
					$data["id_berkas"] = $item["id"];
					$data["jenis_berkas"] = "Surat Perjalanan Dinas";
					$data["posisi_ttd"] = "spd_belakang_berangkat";

					$detail = array();
					$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
					$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
					$detail["Keterangan_Tugas"] = $penugasan["nama"];
					$detail["Nomor_SPD"] = $this->utility->penomoran($dataSpjItem["no_urut"])."/SPD.".$dataSpjItem["spj_id"]."/".$satker["kode_satker"]."/".date("Y");
					$detail["Tgl_SPD"] = $penugasan["tgl_surat"];
					$detail["Disetujui_oleh_Penanggungjawab_Perjalanan_Dinas"] = $ppk["nama"];
					$detail["Disetujui_Tgl"] = $item["tgl_mulai_tugas"];

					$data["detail"] = json_encode($detail);
					$this->validasi_ttd_model->save($data);


					// SPD Belakang Pulang
					$data = array();
					$data["id_berkas"] = $item["id"];
					$data["jenis_berkas"] = "Surat Perjalanan Dinas";
					$data["posisi_ttd"] = "spd_belakang_pulang";

					$detail = array();
					$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
					$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
					$detail["Keterangan_Tugas"] = $penugasan["nama"];
					$detail["Nomor_SPD"] = $this->utility->penomoran($dataSpjItem["no_urut"])."/SPD.".$dataSpjItem["spj_id"]."/".$satker["kode_satker"]."/".date("Y");
					$detail["Tgl_SPD"] = $penugasan["tgl_surat"];
					$detail["Disetujui_oleh_Penanggungjawab_Perjalanan_Dinas"] = $ppk["nama"];
					$detail["Disetujui_Tgl"] = $item["tgl_selesai_tugas"];

					$data["detail"] = json_encode($detail);
					$this->validasi_ttd_model->save($data);


					// SPD Belakang Approve
					$data = array();
					$data["id_berkas"] = $item["id"];
					$data["jenis_berkas"] = "Surat Perjalanan Dinas";
					$data["posisi_ttd"] = "spd_belakang_ppk";

					$detail = array();
					$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
					$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
					$detail["Keterangan_Tugas"] = $penugasan["nama"];
					$detail["Nomor_SPD"] = $this->utility->penomoran($dataSpjItem["no_urut"])."/SPD.".$dataSpjItem["spj_id"]."/".$satker["kode_satker"]."/".date("Y");
					$detail["Tgl_SPD"] = $penugasan["tgl_surat"];
					$detail["Disetujui_oleh_PPK"] = $ppk["nama"];
					$detail["Disetujui_Tgl"] = date("Y-m-d");

					$data["detail"] = json_encode($detail);
					$this->validasi_ttd_model->save($data);
					
					// Laporan Perjalanan Dinas
					$data = array();
					$data["id_berkas"] = $item["id"];
					$data["jenis_berkas"] = "Laporan Perjalanan Dinas";
					$data["posisi_ttd"] = "perjadin";

					$detail = array();
					$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
					$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
					$detail["Keterangan_Tugas"] = $penugasan["nama"];
					$detail["Nomor_SPD"] = $this->utility->penomoran($dataSpjItem["no_urut"])."/SPD.".$dataSpjItem["spj_id"]."/".$satker["kode_satker"]."/".date("Y");
					$detail["Tgl_SPD"] = $penugasan["tgl_surat"];
					$detail["Disetujui_oleh_Pegawai"] = $item["nama"];
					$detail["Disetujui_Tgl"] = date("Y-m-d", strtotime($item["diubah_tgl"]));

					$data["detail"] = json_encode($detail);
					$this->validasi_ttd_model->save($data);
				}
				else {
					// Set Penugasan Item Terbayarakan
					$data = array();
					$data["status"] = 6;
					$this->penugasan_model->saveItem($data, $id);
					
					// Laporan Perjalanan Dinas
					$data = array();
					$data["id_berkas"] = $item["id"];
					$data["jenis_berkas"] = "Laporan Perjalanan Dinas";
					$data["posisi_ttd"] = "perjadin";

					$detail = array();
					$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
					$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
					$detail["Keterangan_Tugas"] = $penugasan["nama"];
					$detail["Nomor_SPD"] = "-";
					$detail["Tgl_SPD"] = "";
					$detail["Disetujui_oleh_Pegawai"] = $item["nama"];
					$detail["Disetujui_Tgl"] = date("Y-m-d", strtotime($item["diubah_tgl"]));

					$data["detail"] = json_encode($detail);
					$this->validasi_ttd_model->save($data);
				}
				
				
				// NOTIF PETUGAS LAPORAN DISETUJUI
				if (isset($userPetugas["telegram_chat_id"]) && !empty($userPetugas["telegram_chat_id"])) {
					$chatID = $userPetugas["telegram_chat_id"];
					
					$msg = "Hi.. <b>".$userPetugas["nama"]."</b>, \n";
					
					$msg .= "Horee.. Laporan perjalanan dinas kamu untuk tugas ".$penugasan["nama"]." (".$item["kab_tujuan"].", ".$item["provinsi_tujuan"].") pada tgl ".$this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"])." telah disetujui oleh tim validator.\n";
					
					if (isset($_POST["dipa_balai"]) && !empty($_POST["dipa_balai"])) {
						$msg .= "Silahkan print <a href='".base_url("/admin/user/laporan_perjadin/".$item["id"])."'>laporan ini</a>, kemudian Tandatangani dan setorkan ke bagian keuangan ya! \nTerimakasih.";
					}
					else {
						$msg .= "Terimakasih.";
					}

					$this->telegram->sendChat($chatID, $msg);
				}
				
				// UPDATE STATUS PENUGASAN
				$penugasanItemAlls = $this->penugasan_model->getItemsByPenugasanId($penugasan["id"]);
				$laporanApproved = 1;

				if (!empty($penugasanItemAlls)) {
					foreach ($penugasanItemAlls as $boo) {
						if ($boo["status"] == "0" || $boo["status"] == "1" || $boo["status"] == "2" || $boo["status"] == "4") {
							$laporanApproved = 0;
						}
					}
				}

				if ($laporanApproved) {
					$data = array();
					
					if (isset($_POST["dipa_balai"]) && !empty($_POST["dipa_balai"])) {
						$data["status"] = 4;
					}
					else {
						$data["status"] = 5;
					}

					$this->penugasan_model->save($data, $penugasan["id"]);
				}
			}
			
			// NOTIF TELEGRAM TOLAK PERJADIN
			if (isset($_POST["status"]) && $_POST["status"] == "4") {
				$chatID = $userPetugas["telegram_chat_id"];

				if (!empty($chatID)) {
					$msg = "Hi.. <b>".$userPetugas["nama"]."</b>, \n";

					$msg .= "Opss.. Laporan perjalanan dinas kamu untuk tugas ".$penugasan["nama"]." (".$item["kab_tujuan"].", ".$item["provinsi_tujuan"].") pada tgl ".$this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"])." ditolak oleh tim validator.\n";
					
					$msg .= "Silahkan <a href='".base_url("/admin/user/penugasan/")."'>lihat disini</a>, klik icon \xF0\x9F\x93\x9B yang berwarna merah pada status penugasan tersebut untuk melihat alasan penolakan. \nTerimakasih.";
					
					$this->telegram->sendChat($chatID, $msg);
				}
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function getJsonItemPenugasan () {
		$out = array();
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$this->load->model('penugasan_model');
			$out = $this->penugasan_model->getItemById($id);
		}
		
		print json_encode($out);
	}
	
	protected function getLastDateWorkDay ($date) {
		$currentYear = $_SESSION["tahun_anggaran"];
		$givenYear = date("Y", strtotime($date));
		
		$hari = $date;
		
		if ($currentYear != $givenYear) {
			$lastDate = "31-12-".$currentYear;
			$hari = date('Y-m-d', strtotime($lastDate));
			$lastWorkingDayThisYear = date('N', strtotime($lastDate));
			
			if ($lastWorkingDayThisYear >= 6) {
				$lastDate = "30-12-".$currentYear;
				$hari = date('Y-m-d', strtotime($lastDate));
				$lastWorkingDayThisYear = date('N', strtotime($lastDate));

				if ($lastWorkingDayThisYear >= 6) {
					$lastDate = "29-12-".$currentYear;
					$hari = date('Y-m-d', strtotime($lastDate));
					$lastWorkingDayThisYear = date('N', strtotime($lastDate));

					if ($lastWorkingDayThisYear >= 6) {
						$lastDate = "28-12-".$currentYear;
						$hari = date('Y-m-d', strtotime($lastDate));
						$lastWorkingDayThisYear = date('N', strtotime($lastDate));
					}
				}
			}
		}
		
		return $hari;
	}

	public function modal_urutkan_pegawai () {
		$this->load->model("biodata_model");

		$data = array();
		$data["users"] = $this->user_model->getUser();

		$biodatas = $this->biodata_model->getBiodataByPegawaiBalai();

		if (!empty($data["users"])) {
			foreach ($data["users"] as $key => $user) {
				if (isset($biodatas[$user["sync_biodata"]])) {
					$data["users"][$key]["nama_lengkap"] = $biodatas[$user["sync_biodata"]]["nama"];
				}
			}
		}

		print $this->load->view('backend/user/modal_urutkan_pegawai', $data, true);
	}

	public function update_urutan_pegawai () {
		$out = array("error" => false);
		
		if (isset($_POST) && !empty($_POST)) {
			$urutan = $_POST["urutan"];
			
			if (!empty($urutan)) {
				foreach ($urutan as $urut) {
					$data = array();
					$data["no_urut"] = $urut["no_urut"];

					$this->user_model->save($data, $urut["user_id"]);
				}
			}
		}
		
		print json_encode($out);
	}
	
	
	
	public function convert_img () {
		$this->load->view('backend/user/convert_img');
	}
	
	public function test_tele () {
		$apiToken = "5535506323:AAF8_DnZhEEon9vxvqhl3AtZvR2SN-NJQC0";
		$data = [
		  'chat_id' => '1675513458',
		  'text' => 'Hello from PHP'
		];
		$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" .
									 http_build_query($data) );
	}
	
	public function test_google_calender () {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		// 1 = senin
		// 7 = minggu
		$hari = date('d-m-Y', strtotime("next thursday", strtotime("28-12-2023")));
		
		// check date in this last year
		$hari = $this->getLastDateWorkDay($hari);
		
		print "<pre>";
		print_r($hari);
		print "</pre>";
		
		
		print "<br />";
		print "<pre>";
		print_r(date('N', strtotime("16-01-2023")));
		print "</pre>";
		print "<pre>";
		print_r(date('N', strtotime("17-01-2023")));
		print "</pre>";
		print "<pre>";
		print_r(date('N', strtotime("18-01-2023")));
		print "</pre>";
		print "<pre>";
		print_r(date('N', strtotime("19-01-2023")));
		print "</pre>";
		print "<pre>";
		print_r(date('N', strtotime("20-01-2023")));
		print "</pre>";
		print "<pre>";
		print_r(date('N', strtotime("21-01-2023")));
		print "</pre>";
		print "<pre>";
		print_r(date('N', strtotime("22-01-2023")));
		print "</pre>";
	}
}
