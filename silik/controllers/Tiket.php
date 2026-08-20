<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->model("tiket_model");
	}
	
	public function index() {
		$this->auth->guest();
		
		$data = array();
		$data["guest"] = $this->session->userdata('guest');
		
		$this->load->view('/frontend/tiket/lists', $data);
	}
	
	public function saveNew () {
		$out = array();
		
		if (isset($_POST["judul"])) {
			$this->auth->guest();
			
			$judul = $_POST["judul"];
			$deskripsi = $_POST["deskripsi"];
			
			$id = $this->tiket_model->saveNewChat($judul, $deskripsi);
			
			$out["error"] = false;
			
			if (isset($_FILES) && !empty($_FILES)) {
				$tiket = $this->tiket_model->getById($id);
				
				// Make Sure Root Folder
				$mainDriveId = $this->google->createDriveFolder("SILIK BALI");
				$rootDriveId = $this->google->createDriveFolder("Tiket", $mainDriveId);
				$folderDriveId = $this->google->createDriveFolder($tiket["no"], $rootDriveId);

				$data = array();
				$data["drive_folder"] = $folderDriveId;
				$this->tiket_model->update($data, $id);
				
				$files = array();
				$allowed = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');
				$allowedSize = 5242880; // 5 Mb

				$driveFiles = array();

				foreach ($_FILES['file']["name"] as $key => $filename) {
					$files[$key]["name"] = $filename;
					$files[$key]["type"] = $_FILES['file']["type"][$key];
					$files[$key]["tmp_name"] = $_FILES['file']["tmp_name"][$key];
					$files[$key]["error"] = $_FILES['file']["error"][$key];
					$files[$key]["size"] = $_FILES['file']["size"][$key];
				}

				foreach ($files as $key => $file) {

					$filename = $file['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					// Check File Type
					if (in_array($ext, $allowed)) {
						if ($file["size"] <= $allowedSize) {
							$fileDriveId = $this->google->createDriveFile($file, $folderDriveId);

							if ($fileDriveId) {
								$driveFiles[$key]["drive_file"] = $fileDriveId;
								$driveFiles[$key]["nama"] = $filename;
								$driveFiles[$key]["size"] = $file["size"];
								$driveFiles[$key]["type"] = $ext;
							}
						}
						else {
							$out["error"] = false;
							$out["msg"] = "File Size Terlalu Besar";
						}
					}
					else {
						$out["error"] = false;
						$out["msg"] = "Tipe File Tidak Diizinkan";
					}
				}

				$data = array();
				$data["drive_file"] = json_encode($driveFiles);
				$this->tiket_model->update($data, $id);
			}
			
			// NOTIF TELEGRAM
			/*$this->load->model('user_model');
			$this->load->library("telegram");
			
			$users = $this->user_model->getUser();
			
			if (!empty($users)) {
				foreach ($users as $user) {
					if (isset($user["akses"]["hai_bgp"]["list"]) && $user["akses"]["hai_bgp"]["list"] == "1") {
							
							$tiket = $this->tiket_model->getById($id);
						
							$chatID = $user["telegram_chat_id"];
							
							$msg = "Hi.. <b>".$user["nama"]."</b>, \n";
							$msg .= "Ada tiket baru di HAI BGP, ID tiket ".$tiket["no"]." dengan judul <b>".$tiket["judul"]."</b>. Mohon bantu memberikan tanggapan <a href='".base_url("/admin/tiket/lists/baru")."'>disini</a>. \n";
							$msg .= "Terimakasih.";
							
							if (!empty($chatID)) {
								$this->telegram->sendChat($chatID, $msg);	
							}
						}
				}
			}*/
			
			print json_encode($out);
		}
	}
	
	public function detail ($id = false) {
		$this->auth->guest();
		
		if ($id) {
			$data = array();
			$data["tiket"] = $this->tiket_model->getById($id);
			$data["guest"] = $this->session->userdata('guest');
			
			$this->load->view('/frontend/tiket/detail', $data);
		}
		else {
			redirect(base_url("/tiket/"));
		}
	}
	
	public function chat () {
		$this->auth->guest();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$id = $_POST["id"];
			
			$data = array();
			$data["tiket"] = $this->tiket_model->getById($id);
			$data["tiket_chat"] = $this->tiket_model->getChat($id);
			$data["guest"] = $this->session->userdata('guest');
			
			if (!empty($data["tiket_chat"])) {
				$lookup = array();
				
				foreach ($data["tiket_chat"] as $chat) {
					$lookupKey = date("Y-m-d H:i", strtotime($chat["dibuat_tgl"]));
					
					if (!isset($lookup[$lookupKey])) {
						$lookup[$lookupKey] = array();
					}
					
					if (!isset($lookup[$lookupKey][$chat["user_id"]])) {
						$lookup[$lookupKey][$chat["user_id"]] = array();
					}
					
					$lookup[$lookupKey][$chat["user_id"]][] = $chat;
				}
				
				$data["tiket_chat"] = $lookup;
			}

			$this->load->view('frontend/tiket/chat',$data);	
		}
	}
	
	public function saveChat () {
		$out = array();
		
		if (isset($_POST["tiket_id"])) {
			$this->auth->guest();
			
			$parentId = $_POST["tiket_id"];
			$msg = $_POST["msg"];
			
			$id = $this->tiket_model->saveChat($parentId, $msg);
			
			// Update Notifikasi
			$ticket = $this->tiket_model->getById($_POST["tiket_id"]);
			
			if (!empty($ticket)) {
				$this->load->model("guest_model");
				$guestId = $ticket["guest_id"];
				
				$guest = $this->guest_model->getById($guestId);
				$guestTiket = $this->tiket_model->getByGuestFeedback($guestId, "0");
				
				$guest["notif"]["hai"] = count($guestTiket);
				
				$data = array();
				$data["notif"] = json_encode($guest["notif"]);
				
				$this->guest_model->save($data, $guestId);
			}
			
			$out["error"] = false;
			
			if (isset($_FILES) && !empty($_FILES)) {
				$parent = $this->tiket_model->getById($parentId);

				if (!empty($parent)) {
					// Make Sure Root Folder
					$mainDriveId = $this->google->createDriveFolder("SILIK BALI");
					$rootDriveId = $this->google->createDriveFolder("Tiket", $mainDriveId);
					
					// Drive Folder
					$folderDriveId = $parent["drive_folder"];

					if (empty($folderDriveId)) {
						// Create Drive Folder
						$folderDriveId = $this->google->createDriveFolder($parent["no"], $rootDriveId);

						$data = array();
						$data["drive_folder"] = $folderDriveId;
						$this->tiket_model->update($data, $parentId);
					}
					
					
					$files = array();
					$allowed = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');
					$allowedSize = 5242880; // 5 Mb
					
					$driveFiles = array();
					
					foreach ($_FILES['file']["name"] as $key => $filename) {
						$files[$key]["name"] = $filename;
						$files[$key]["type"] = $_FILES['file']["type"][$key];
						$files[$key]["tmp_name"] = $_FILES['file']["tmp_name"][$key];
						$files[$key]["error"] = $_FILES['file']["error"][$key];
						$files[$key]["size"] = $_FILES['file']["size"][$key];
					}
					
					foreach ($files as $key => $file) {
						
						$filename = $file['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						
						// Check File Type
						if (in_array($ext, $allowed)) {
							if ($file["size"] <= $allowedSize) {
								$fileDriveId = $this->google->createDriveFile($file, $folderDriveId);

								if ($fileDriveId) {
									$driveFiles[$key]["drive_file"] = $fileDriveId;
									$driveFiles[$key]["nama"] = $filename;
									$driveFiles[$key]["size"] = $file["size"];
									$driveFiles[$key]["type"] = $ext;
								}
							}
							else {
								$out["error"] = false;
								$out["msg"] = "File Size Terlalu Besar";
							}
						}
						else {
							$out["error"] = false;
							$out["msg"] = "Tipe File Tidak Diizinkan";
						}
					}
					
					$data = array();
					$data["drive_file"] = json_encode($driveFiles);
					$this->tiket_model->updateChat($data, $id);
				}
				else {
					$out["error"] = true;
					$out["msg"] = "Tiket Tidak Ditemukan";
				}
			}
			
			print json_encode($out);
		}
	}
	
	public function rating_modal (){
		$this->auth->guest();
		$data = array();
		$data["tiket_id"] = $_POST["tiket_id"];
		$this->load->view('frontend/tiket/modal_rating',$data);
	}
	
	public function save_rating (){
		$this->auth->guest();
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST)) {
			$tiket_id = $_POST["tiket_id"];
			
			$data = array();
			$data["rating"] = $_POST["rating"];
			$data["status"] = "2"; // Selesai
			$data["feedback"] = "2"; // Selesai
			$this->tiket_model->update($data, $tiket_id);
			$out["error"] = false;
			
			// Update Notifikasi
			$ticket = $this->tiket_model->getById($_POST["tiket_id"]);
			
			if (!empty($ticket)) {
				$this->load->model("guest_model");
				$guestId = $ticket["guest_id"];
				
				$guest = $this->guest_model->getById($guestId);
				$guestTiket = $this->tiket_model->getByGuestFeedback($guestId, "0");
				
				$guest["notif"]["hai"] = count($guestTiket);
				
				$data = array();
				$data["notif"] = json_encode($guest["notif"]);
				
				$this->guest_model->save($data, $guestId);
			}
		}
		
		print json_encode($out);
	}
	
}