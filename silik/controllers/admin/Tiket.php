<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends CI_Controller {
	
	function __construct() {
		parent::__construct();		
		$this->load->model("tiket_model");
		$this->load->model("guest_model");
		
		$user = $_SESSION["user"];
		
		$data = array();
		$data["new_tiket"] = $this->tiket_model->getNew();
		$data["proses_tiket"] = $this->tiket_model->getByUserId($user["id"],"1","1");

		$this->load->vars($data);
	}
	
	public function index () {
		$this->auth->login();
		
		redirect(base_url("/admin/tiket/lists/baru"));
	}
	
	private function lists_baru () {
		$data = array();
		
		$this->load->view('backend/tiket/list_baru',$data);
	}
	
	private function lists_proses () {
		
		$data = array();
		$this->load->view('backend/tiket/list_proses',$data);
	}
	
	private function lists_selesai () {
		
		$data = array();
		$this->load->view('backend/tiket/list_selesai',$data);
	}
	
	public function lists ($status) {
		//$this->auth->login();
		
		if ($status == "baru") {
			$this->lists_baru();
		}
		else if ($status == "proses") {
			$this->lists_proses();
		}
		else if ($status == "selesai") {
			$this->lists_selesai();
		}
	}
	
	public function detail ($id) {
		$this->auth->login();
		
		$data = array();
		$data["tiket"] = $this->tiket_model->getById($id);
		$data["guest"] = $this->guest_model->getById($data["tiket"]["guest_id"]);
		
		$this->load->view('backend/tiket/detail',$data);
	}
	
	public function chat () {
		$this->auth->login();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$id = $_POST["id"];
			
			$data = array();
			$data["tiket"] = $this->tiket_model->getById($id);
			$data["tiket_chat"] = $this->tiket_model->getChat($id);
			$data["guest"] = $this->guest_model->getById($data["tiket"]["guest_id"]);
			
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

			$this->load->view('backend/tiket/chat',$data);	
		}
	}
	
	public function saveChatAdmin () {
		$out = array();
		
		if (isset($_POST["tiket_id"])) {
			$this->auth->login();
			
			// get feedback status before update
			$ticketBeforeUpdate = $this->tiket_model->getById($_POST["tiket_id"]);
			
			$parentId = $_POST["tiket_id"];
			$msg = $_POST["msg"];
			
			$id = $this->tiket_model->saveChatAdmin($parentId, $msg);
			
			// Update Notifikasi Guest
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
				
				
				// Send Email If status menunggu (no multiple email)
				if (isset($ticketBeforeUpdate["feedback"]) && $ticketBeforeUpdate["feedback"] == "1") {
					$nama = strip_tags($guest['nama']);
					$email = strip_tags($guest['email']);
					$subject = "Tiket No. ".$ticket["no"]." Telah Ditanggapi - ".$this->config->item("site_name");
					$link = base_url("/tiket/detail/".$ticket["id"]);

					$data = array();
					$data["date"] = date("l, d F Y");
					$data["nama"] = $nama;
					$data["link"] = $link;
					$data["tiket_no"] = $ticket["no"];

					$message = $this->load->view('/template/tiket_respon', $data, true);

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
				}
			}
			
			
			$out["error"] = false;
			
			if (isset($_FILES) && !empty($_FILES)) {
				$parent = $this->tiket_model->getById($parentId);

				if (!empty($parent)) {
					// Make Sure Root Folder
					$rootDriveId = $this->google->createDriveFolder("SIPANDU - TIKET");
					
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
	
	
	public function ubah_status () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST["tiketId"]) && !empty($_POST["tiketId"])) {
			$data = array();
			$data["status"] = $_POST["status"];
			
			if ($data["status"] == "2") {
				$data["feedback"] = 2;
			}
			
			$this->tiket_model->update($data, $_POST["tiketId"]);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	
	/*public function list_ajax() {
		$user = $this->auth();
		
		$search = $_GET["search"]["value"];
		$tickets = $this->ticket_model->getByUserId($user["id"], false, false, $search);
		
		$data = array();
		$data["recordsTotal"] = count($tickets);
		$data["recordsFiltered"] = count($tickets);
		$data["data"] = array();
		
		$limit = $_GET["length"];
		$limitStart = $_GET["start"];
		$tickets = $this->ticket_model->getByUserId($user["id"], $limitStart, $limit, $search);
		
		if (!empty($tickets)) {
			$i = $limitStart + 1;
			foreach ($tickets as $ticket) {
				$lookup = array();
				$lookup["number"] = $i;
				$lookup["title"] = '<a href="'.base_url("ticket/overview/".$ticket["id"]."/").'" style="font-weight:400;">'.$ticket["title"].'</a>';
				
				if (empty($ticket["status"])) {
					$status = '<a href="javascript:;" title="Menunggu Balasan Admin" style="font-size:18px;"><i class="far fa-check-circle"></i></a>&nbsp;&nbsp;<span style="font-size:13px;">Menunggu Balasan</span>';
				}
				else {
					$status = '<a href="javascript:;" title="Sudah Dibalas Admin" style="font-size:18px; color:green;"><i class="fas fa-check-circle"></i></a>&nbsp;&nbsp;<span style="font-size:13px;">Sudah Dibalas</span>';
				}
				
				$lookup["status"] = $status;
				$lookup["created_date"] = '<span style="font-size:13px;">'.date("d M Y H:i a", strtotime($ticket["created_date"])).'</span>';
				$lookup["action"] = '<a class="btn btn-primary btn-sm" href="'.base_url("ticket/overview/".$ticket["id"]."/").'">Lihat</a>';
				
				$data["data"][] = $lookup;
				
				$i++;
			}
		}
		
		print json_encode($data);
	}
	
	public function overview ($ticketId) {
		$user = $this->auth();
		
		$ticket = $this->ticket_model->getById($user["id"], $ticketId);
		
		if (empty($ticket)) {
			redirect("/ticket/");
		}
		else {
			$data["ticket"] = $ticket;
			
        	$this->load->template("ticket/overview",$data);
		}
	}
	
	public function load_chat () {
		$user = $this->auth();
		$ticketId = $_POST["ticket_id"];
		
		$out = array();
		
		$ticket = $this->ticket_model->getById($user["id"], $ticketId);
		
		if (!empty($ticket)) {
			$out["tickets"][] = $ticket;
			
			$tickets = $this->ticket_model->getByParentId($ticketId);
			
			if (!empty($tickets)) {
				foreach ($tickets as $ticket) {
					$out["tickets"][] = $ticket;
				}
			}
			
        	$this->load->template("ticket/chat",$out);
		}
	}
	
	public function submit_chat () {
		if (isset($_POST["ticket_id"])) {
			$user = $this->auth();
			$ticketId = $_POST["ticket_id"];
			$chat = $_POST["chat"];
			
			$ticket = $this->ticket_model->save($ticketId, $chat);
			
			$out = array();
			$out["ticket_id"] = $ticket;
			
			print json_encode($out);
		}
	}*/
}
