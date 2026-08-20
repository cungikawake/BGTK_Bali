<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("pengaturan_model");
		$this->load->model("guest_model");
	}
	
	public function index() {
		$this->auth->guest();
		
		$data = array();
		$data["guest"] = $this->session->userdata('guest');

		$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
		if (!empty($pengaturan)) {
			foreach ($pengaturan as $foo) {
				$data["satker"][$foo["sistem"]] = $foo["value"];
			}
		}
		
		$this->load->view('/frontend/user/overview', $data);
	}
	
	public function daftar () {
		if (isset($_POST) && !empty($_POST["email"])) {
			$guest = $this->guest_model->getByEmail($_POST["email"]);
			
			if (!empty($guest)) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Email yang anda gunakan sudah terdaftar</div>');
				
				foreach ($_POST as $key => $val) {
					$this->session->set_flashdata($key, $val);
				}
				
				redirect(base_url("user/daftar"));
			}
			else {
				$id = $this->guest_model->register($_POST);
				$guest = $this->guest_model->getById($id);
				
				$nama = strip_tags($guest['nama']);
				$email = strip_tags($guest['email']);
				$subject = "Aktivasi Akun - ".$this->config->item("site_name");
				$link = base_url("user/aktivasi/".$guest["aktivasi"]);
				
				$data = array();
				$data["date"] = date("l, d F Y");
				$data["nama"] = $nama;
				$data["link"] = $link;
				
				$message = $this->load->view('/template/aktivasi_akun', $data, true);
				
				$this->load->model("pengaturan_model");
				$lookup = $this->pengaturan_model->getPengaturanBySection("smtp");
				
				$smtp = array();
				
				if (!empty($lookup)) {
					foreach ($lookup as $foo) {
						$smtp[$foo["sistem"]] = $foo["value"];
					}
				}
				
				$config = array();
				$config['protocol'] = 'mail';
				$config['smtp_host'] = $smtp["smtp_host"];
				$config['smtp_port'] = $smtp["smtp_port"];
				$config['smtp_timeout'] = '7';
				$config['smtp_user'] = $smtp["smtp_user"];
				$config['smtp_pass'] = $smtp["smtp_password"];
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$config['newline'] = "\r\n";
				
				$this->email->initialize($config);
				$this->email->set_newline("\r\n");
				$this->email->from($smtp["smtp_user"], $this->config->item('site_name'));
				$this->email->reply_to($smtp["smtp_user"], $this->config->item('site_name'));
				$this->email->to($email);
				
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->set_alt_message($message);
				
				$send = $this->email->send();
				
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Pendaftaran Berhasil. Silahkan periksa email anda untuk mengaktifkan akun.</div>');
				$this->session->set_flashdata('show_form', false);
				redirect(base_url("user/daftar"));
			}
		}
		else {
			$this->load->view('/frontend/user/daftar');
		}
	}
	
	public function detail () {
		$this->auth->guest();
		
		$guest = $this->session->userdata('guest');
		
		if (isset($_POST) && !empty($_POST["nama"])) {
			$this->guest_model->save($_POST, $guest["id"]);
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Berhasil menyimpan profil</div>');
			
			$guest = $this->guest_model->getById($guest["id"]);
			
			$this->session->set_userdata("guest", $guest);
			
			redirect(base_url("user/detail"));
		}
		else {
			$data = array();
			$data["guest"] = $guest;

			$this->load->view('/frontend/user/detail', $data);
		}
	}
	
	public function reset_password () {
		if (isset($_POST) && !empty($_POST["email"])) {
			$guest = $this->guest_model->getByEmail($_POST["email"]);
			
			if (!empty($guest)) {
				// generate unique code
				$data = array();
				$data["reset_password"] = md5("reset-".date("d-m-y H:i:s").rand());
				$this->guest_model->save($data, $guest["id"]);
				
				$nama = strip_tags($guest['nama']);
				$email = strip_tags($guest['email']);
				$subject = "Reset Password - ".$this->config->item("site_name");
				$link = base_url("user/ubah_password/".$data["reset_password"]);
				
				$data = array();
				$data["date"] = date("l, d F Y");
				$data["nama"] = $nama;
				$data["link"] = $link;
				
				$message = $this->load->view('/template/reset_password', $data, true);
				
				$this->load->model("pengaturan_model");
				$lookup = $this->pengaturan_model->getPengaturanBySection("smtp");
				
				$smtp = array();
				
				if (!empty($lookup)) {
					foreach ($lookup as $foo) {
						$smtp[$foo["sistem"]] = $foo["value"];
					}
				}
				
				$config = array();
				$config['protocol'] = 'mail';
				$config['smtp_host'] = $smtp["smtp_host"];
				$config['smtp_port'] = $smtp["smtp_port"];
				$config['smtp_timeout'] = '7';
				$config['smtp_user'] = $smtp["smtp_user"];
				$config['smtp_pass'] = $smtp["smtp_password"];
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$config['newline'] = "\r\n";
				
				$this->email->initialize($config);
				$this->email->set_newline("\r\n");
				$this->email->from($smtp["smtp_user"], $this->config->item('site_name'));
				$this->email->reply_to($smtp["smtp_user"], $this->config->item('site_name'));
				$this->email->to($email);
				
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->set_alt_message($message);
				
				$send = $this->email->send();
				
				$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Link untuk mereset password telah terkirim ke email <strong>'.$_POST["email"].'</strong>, silahkan klik link tersebut untuk mereset password.</div>');
				redirect("user/reset_password");
			}
			else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Email anda tidak terdaftar</div>');
				redirect("user/reset_password");
			}
		}
		else {
			$this->load->view('/frontend/user/reset_password');	
		}
	}
	
	public function ubah_password ($kunci = null) {
		
		if (isset($_POST) && !empty($_POST["reset_password"])) {
			$guest = $this->guest_model->getByResetCode($_POST["reset_password"]);
			
			if (!empty($guest)) {
				$pass = $_POST["password"];
				$repass = $_POST["new_password"];
				
				if ($pass != $repass) {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger">Password Baru dan Ulangi Password harus sama</div>');
					redirect("user/ubah_password/".$_POST["reset_password"]);
				}
				else {
					$this->guest_model->savePassword($pass, $guest["id"]);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Sukses! Berhasil mengubah password. Silahkan masuk dengan password baru.</div>');
					redirect("user/login/");
				}
			}
			else {
				redirect("user/login");
			}
		}
		else {
			if (!empty($kunci)) {
				$guest = $this->guest_model->getByResetCode($kunci);

				if (!empty($guest)) {
					$data = array();
					$data["reset_password"] = $kunci;

					$this->load->view('/frontend/user/ubah_password', $data);
				}
				else {
					redirect("user/login");
				}
			}
		}
	}
	
	public function aktivasi ($kunci = null) {
		if (!empty($kunci)) {
			$guest = $this->guest_model->getByActivation($kunci);
			
			if (!empty($guest)) {
				$data = array();
				$data["aktivasi"] = "";

				$this->guest_model->save($data, $guest["id"]);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">Sukses! Berhasil mengaktifkan akun. Silahkan masuk dengan akun anda.</div>');
				redirect("user/login/");
			}
		}
	}
	
	public function login() {
	    
		$guest = $this->session->userdata('guest');
		
		if (empty($guest)) {
			$data = array();
			
			if (isset($_POST) && !empty($_POST)) {
				$data["email"] = $_POST["email"];
				$data["password"] = $_POST["password"];
				
				$error = false;
				
				$checkEmail = $this->guest_model->getByEmail($data["email"]);
				
				if (empty($checkEmail)) {
					$error = true;
					$this->session->set_flashdata('msg', '<div class="alert alert-danger">Email tidak terdaftar</div>');
				}
				
				if (!$error) {
					$guest = $this->guest_model->login($data["email"], $data["password"]);
					
					if (!empty($guest)) {
						if (!empty($guest["aktivasi"])) {
							$this->session->set_flashdata('msg', '<div class="alert alert-danger">Akun anda belum diaktifkan. Silahkan aktifkan akun melalui link yang telah dikirim ke email anda.</div>');
							redirect("user/login");
						}
						else {
							$this->session->set_userdata("guest", $guest);
							redirect("user/");	
						}
					}
					else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger">Password yang anda masukan salah</div>');
						redirect("user/login");
					}
				}
			}
			
			//$data["facebookLoginUrl"] = $this->facebook->loginUrl();
			$data["googleLoginUrl"] = $this->google->authUrl();
			
			$this->load->view('/frontend/user/login', $data);
		}
		else {
			redirect(base_url("user/"));
		}
	}
	
	public function keep_auth () {
		if (isset($_POST)) {
			$guest = $this->session->userdata('guest');
			
			$guest = $this->guest_model->getById($guest["id"]);
			
			$this->session->set_userdata("guest", $guest);
		}
	}
	
	public function keep_menu () {
		if (isset($_POST)) {
			$guest = $this->session->userdata('guest_menu');
			$this->session->set_userdata("guest_menu", $guest);
		}
	}
	
	public function set_menu () {
		if (isset($_POST)) {
			$this->session->set_userdata("guest_menu", $_POST["show"]);
		}
	}
	
	public function logout () {
		if (isset($_SESSION["guest"])) {
			unset($_SESSION["guest"]);
		}
		
		redirect(base_url("/"));
	}
	
	public function oAuth2 () {
		
		$user = $this->session->userdata('guest');
		
		if (empty($user)) {
			if (isset($_GET["code"]) && $this->google->isAuthenticated($_GET["code"])) {
				$token = $this->google->getAccessToken();
				$accessToken = $this->google->setAccessToken($token);
				$this->google->setClient();

				$googleUser = $this->google->getUserDetail();

				// Prepare Data
				$user = array();
				$user['oauth_provider'] = 'google';
				$user['oauth_uid'] = $googleUser['sub'];
				$user['nama'] = $googleUser['name'];
				$user['email'] = $googleUser['email'];
				$user['jenis_kelamin'] = isset($googleUser['gender']) ? $googleUser['gender'] : "";
				$user['avatar'] = $googleUser['picture']."?sz=210";

				$getUser = $this->guest_model->getByGoogleId($user['oauth_uid']);

				if (empty($getUser)) {
					$id = $this->guest_model->save($user);
				}
				else {
					$id = $this->guest_model->save($user, $getUser["id"]);
				}
				
				$user = $this->guest_model->getById($id);
				$this->session->set_userdata("guest", $user);
				
				redirect("/user/");		
			}
			else {
				redirect("/user/login/");
			}
		}
		else {
			redirect("/user/");
		}
	}
}
