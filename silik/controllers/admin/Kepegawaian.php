<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepegawaian extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("kegiatan_model");
		$this->load->model("penugasan_model");
		$this->load->model("biodata_model");
		$this->load->library("telegram");
	}
	
	public function index () {
		$this->auth->login();
	}
	
	public function penugasan () {
		$this->auth->login();
		
		$data = array();
		
		$this->load->view('backend/kepegawaian/penugasan',$data);
	}
	
	public function search_kegiatan () {
		$this->auth->login();
		
		$data = array();
		
		if (isset($_GET["q"]) && !empty($_GET["q"])) {
			$kegiatans = $this->kegiatan_model->searchKegiatanByName($_GET["q"]);
			
			$data["total_count"] = count($kegiatans);
			$data["items"] = $kegiatans;
		}
		
		print json_encode($data);
	}
	
	public function savePenugasan () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan penugasan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			$id = $data["id"];
			
			unset($data["id"]);
			
			
			// Prepare Data To Save
			if (isset($data["status"]) && $data["status"] == "1") {
				$data["tgl_usulan"] = date("Y-m-d H:i:s");
			}
			
			if (isset($data["tgl_surat"]) && !empty($data["tgl_surat"])) {
				$data["tgl_surat"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_surat"])));
			}
			
			if (isset($_POST["tipe"]) && $_POST["tipe"] == "monev") {
				$data["petugas"] = json_encode($_POST["petugas"]);
			}
			else {
				$this->load->model("kegiatan_model");
				$kegiatan = $this->kegiatan_model->getKegiatanById($_POST["kegiatan_id"]);
				
				$petugas = array();
				$petugas["tgl_mulai_tugas"] = date("d/m/Y", strtotime($kegiatan["tgl_mulai_kegiatan"]));
				$petugas["tgl_selesai_tugas"] = date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
				$petugas["provinsi_asal"] = $_ENV['DEFAULT_PROVINSI'];
				$petugas["provinsi_tujuan"] = $_ENV['DEFAULT_PROVINSI'];
				$petugas["kab_asal"] = $_ENV['DEFAULT_KABUPATEN'];
				$petugas["kab_tujuan"] = $kegiatan["kab_tempat_kegiatan"];
				$petugas["tempat_tujuan"] = $kegiatan["tempat_kegiatan"];
				$petugas["petugas"] = $_POST["petugas"];
				
				$data["petugas"] = json_encode(array($petugas));
			}
			
			
			$id = $this->penugasan_model->save($data, $id);
			
			
			// Hadle File
			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan penugasan. Silahkan coba lagi!";
			}
			else {
				if (isset($_FILES) && !empty($_FILES)) {
					$files = array();
					$allowed = array('pdf');
					$allowedSize = 5242880; // 5 Mb
					
					$tempFile = $_FILES['file']["tmp_name"];          

					$dir = APPPATH . "../assets/surat_tugas";
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$dir = $dir."/".$_SESSION["tahun_anggaran"];
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$dir = $dir."/penugasan";
					is_dir($dir) || @mkdir($dir) || die("Can't Create folder");

					$filename = $_FILES['file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					$targetFile =  "ST_Penugasan_".$id.".".$ext;

					move_uploaded_file($tempFile,$dir. "/" .$targetFile);
					
					$data = array();
					$data["surat"] = $targetFile;
					
					$id = $this->penugasan_model->save($data, $id);
				}
			}
			
			// Handle Notif Approval
			if (isset($data["status"]) && $data["status"] == "1") {
				
				/*$this->load->model("user_model");
				$users = $this->user_model->getUser();
				
				if (!empty($users)) {
					foreach ($users as $user) {
						if (isset($user["akses"]["kepegawaian"]["apr_penugasan"]) && $user["akses"]["kepegawaian"]["apr_penugasan"] == "1") {
							
							$approvalPenugasan = $this->penugasan_model->getByStatus($data["status"]);
							
							$chatID = $user["telegram_chat_id"];
							
							$msg = "Hi.. <b>".$user["nama"]."</b>, \n";
							$msg .= "Ada ".count($approvalPenugasan)." penugasan yang perlu disetujui. Silahkan <a href='".base_url("/admin/kepegawaian/approve_penugasan/")."'>klik disini</a> untuk melihat penugasan. \n";
							$msg .= "Terimakasih.";
							
							if (!empty($chatID)) {
								$this->telegram->sendChat($chatID, $msg);	
							}
						}
					}
				}*/
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function json_penugasan_kegiatan () {
		$this->auth->login();
		
		$data = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$data = $this->kegiatan_model->getKegiatanById($_POST["id"]);
		}
		
		print json_encode($data);
	}
	
	public function approve_penugasan ($status = '1') {
		$this->auth->login();
		
		$data = array();
		$data["status"] = $status;
		
		$this->load->view('backend/kepegawaian/approve_penugasan',$data);
	}
	
	public function approval_penugasan ($id) {
		$this->auth->login();
		
		$data = array();
		$pegawai = $this->biodata_model->getBiodataByPegawaiBalai();
		$penugasan = $this->penugasan_model->getById($id);
		
		if (!empty($penugasan)) {
			$data["penugasan"] = $penugasan;
			$detailPetugas = $penugasan["petugas"];
			
			if ($penugasan["status"] >= "2") {
				$penugasanItems = $this->penugasan_model->getItemsByPenugasanId($penugasan["id"]);
				
				if (!empty($penugasanItems)) {
					$i = 1;
					foreach ($penugasanItems as $item) {
						$item["no"] = $i;
						$item["lama_tugas"] = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"])." hari";
						$item["tgl_tugas"] = $this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
						
						$data["petugas"][] = $item;
							
						$i++;
					}
				}
			}
			else {
				if (!empty($detailPetugas)) {
					$i = 1;

					foreach ($detailPetugas as $foo) {

						if (isset($foo["tgl_mulai_tugas"])) {
							$foo["tgl_mulai_tugas"] = str_replace(array("/"),array("-"), $foo["tgl_mulai_tugas"]);
						}

						if (isset($foo["tgl_selesai_tugas"])) {
							$foo["tgl_selesai_tugas"] = str_replace(array("/"),array("-"), $foo["tgl_selesai_tugas"]);
						}


						if (!empty($foo["petugas"])) {
														
							foreach ($foo["petugas"] as $boo) {
								$petugas = array();
								$petugas["no"] = $i;
								$petugas["nama"] = $pegawai[$boo]["nama"];
								$petugas["kab_asal"] = $foo["kab_asal"];
								$petugas["kab_tujuan"] = $foo["kab_tujuan"];
								$petugas["tempat_tujuan"] = $foo["tempat_tujuan"];
								$petugas["lama_tugas"] = $this->utility->lama_tugas($foo["tgl_mulai_tugas"], $foo["tgl_selesai_tugas"])." hari";
								$petugas["tgl_tugas"] = $this->utility->formatRangeDate($foo["tgl_mulai_tugas"], $foo["tgl_selesai_tugas"]);
								$petugas["status"] = "0";
								
								if (isset($boo["status"])) {
									$petugas["status"] = $boo["status"];
								}

								$data["petugas"][] = $petugas;

								$i++;
							}
						}

					}
				}
			}
			
			$this->load->view('backend/kepegawaian/approval_penugasan',$data);
		}
		else {
			redirect(base_url("admin/kepegawaian/approve_penugasan/"));	
		}
	}
	
	public function saveApprovePenugasan () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$data = array();
			$data["status"] = $_POST["status"];
			
			if ($data["status"] == "2") {
				$data["tgl_diterima"] = date("Y-m-d H:i:s");
				
				$out["msg"] = "Berhasil menyetujui usulan penugasan";
			}
			
			if ($data["status"] == "3") {
				$data["tgl_ditolak"] = date("Y-m-d H:i:s");
				$data["keterangan"] = $_POST["keterangan"];
				
				$out["msg"] = "Berhasil menolak usulan penugasan";
			}
			
			$id = $this->penugasan_model->save($data, $id);
			
			// HANDLE NOTIF
			$this->load->model("user_model");
				
			$users = $this->user_model->getUser();

			if (!empty($users)) {				
				// Add Notif Penugasan
				/*if ($data["status"] == "3") {
					$penugasan = $this->penugasan_model->getById($id);
					
					foreach ($users as $user) {
						if (isset($user["akses"]["kepegawaian"]["penugasan"]) && $user["akses"]["kepegawaian"]["penugasan"] == "1") {
							
							$chatID = $user["telegram_chat_id"];
							
							$msg = "Hi.. <b>".$user["nama"]."</b>, \n";
							$msg .= "Pengajuan penugasan ".$penugasan["nama"]." telah ditolak oleh tim validator. Silahkan <a href='".base_url("/admin/kepegawaian/penugasan/")."'>klik disini</a> untuk melihat penugasan dan mohon segera ditindaklanjuti.\n";
							$msg .= "Terimakasih.";
							
							if (!empty($chatID)) {
								$this->telegram->sendChat($chatID, $msg);	
							}
						}
					}
				}*/
			}
			
			// APPROVE - CREATE ITEMS
			if ($data["status"] == "2") {
				$this->load->model("user_model");
				
				$penugasan = $this->penugasan_model->getById($id);
				
				$item = array();
				$item["penugasan_id"] = $id;
				$item["surat_tugas"] = "ST_Penugasan_".$id.".pdf";
					
				if (!empty($penugasan["petugas"])) {
					foreach ($penugasan["petugas"] as $detailPetugas) {
						$item["tgl_mulai_tugas"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $detailPetugas["tgl_mulai_tugas"])));

						$item["tgl_selesai_tugas"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $detailPetugas["tgl_selesai_tugas"])));

						if (!isset($detailPetugas["provinsi_asal"])) {
							$item["provinsi_asal"] = $_ENV['DEFAULT_PROVINSI'];
						}
						else {
							$item["provinsi_asal"] = $detailPetugas["provinsi_asal"];
						}

						if (!isset($detailPetugas["provinsi_tujuan"])) {
							$item["provinsi_tujuan"] = $_ENV['DEFAULT_PROVINSI'];
						}
						else {
							$item["provinsi_tujuan"] = $detailPetugas["provinsi_tujuan"];
						}

						$item["kab_asal"] = $detailPetugas["kab_asal"];
						$item["kab_tujuan"] = $detailPetugas["kab_tujuan"];
						$item["tempat_tujuan"] = $detailPetugas["tempat_tujuan"];
						
						if ($penugasan["penugasan_internal"]) {
							$item["status"] = "5";
							$item["dipa_balai"] = "1";
						}

						if (!empty($detailPetugas["petugas"])) {
							foreach ($detailPetugas["petugas"] as $petugas) {
								$biodataPetugas = $this->biodata_model->getBiodataById($petugas);
								$userPetugas = $this->user_model->getUserBySyncBiodata($biodataPetugas["id"]);

								// Unset Unesesary Data
								unset($biodataPetugas["id"]);
								unset($biodataPetugas["npsn"]);
								unset($biodataPetugas["unsur"]);
								unset($biodataPetugas["valid_rekening"]);
								unset($biodataPetugas["dibuat_tgl"]);
								unset($biodataPetugas["diubah_tgl"]);
								unset($biodataPetugas["dibuat_oleh"]);
								unset($biodataPetugas["diubah_oleh"]);
								unset($biodataPetugas["ptkp"]);

								if (empty($biodataPetugas["provinsi_unit_kerja"])) {
									$biodataPetugas["provinsi_unit_kerja"] = $_ENV['DEFAULT_PROVINSI'];
								}

								foreach ($biodataPetugas as $keyBio => $valBio) {
									$item[$keyBio] = $valBio;
								}

								$this->penugasan_model->saveItem($item);

								/*if (isset($userPetugas["telegram_chat_id"]) && !empty($userPetugas["telegram_chat_id"])) {
									
									$chatID = $userPetugas["telegram_chat_id"];
									
									$msg = "Hi.. <b>".$userPetugas["nama"]."</b>, \n";

									$msg .= "Ada tugas baru untuk kamu yaitu ".$penugasan["nama"]." (".$item["kab_tujuan"].", ".$item["provinsi_tujuan"].") pada tgl ".$this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]).".\n";
									
									$msg .= "Untuk selengkapnya <a href='".base_url("/admin/user/penugasan/")."'>klik disini</a> ya! \n";
									$msg .= "Terimakasih.";
									
									$this->telegram->sendChat($chatID, $msg);
								}*/
							}
						}
					}
				}
				
				/*foreach ($users as $user) {
					if (isset($user["akses"]["kepegawaian"]["penugasan"]) && $user["akses"]["kepegawaian"]["penugasan"] == "1") {

						$chatID = $user["telegram_chat_id"];

						$msg = "Hi.. <b>".$user["nama"]."</b>, \n";
						$msg .= "Pengajuan penugasan ".$penugasan["nama"]." telah disetujui oleh tim validator.\n";
						$msg .= "Terimakasih.";

						if (!empty($chatID)) {
							$this->telegram->sendChat($chatID, $msg);	
						}
					}
				}*/
			}
		}
		else {
			$out["error"] = true;
			$out["msg"] = "Gagal approval usulan penugasan";
		}
		
		print json_encode($out);
	}
	
	public function batalPenugasan ($id = "") {
		$this->auth->login();
		
		$out = array();
		
		if ( (isset($_POST) && !empty($_POST)) || (isset($id) || !empty($id)) ) {
			
			if (isset($_POST) && !empty($_POST)) {
				$id = $_POST["id"];
			}			
			
			$data = array();
			$data["status"] = "7";
			
			$out = $this->penugasan_model->saveItem($data, $id);
			
			$item = $this->penugasan_model->getItemById($id);
			
			if (!empty($item)) {
				$this->load->model("user_model");
				$this->load->model("biodata_model");
				
				$penugasanItems = $this->penugasan_model->getItemsByPenugasanId($item["penugasan_id"]);
				
				$batalSemuaPenugasan = 1;
				
				if (!empty($penugasanItems)) {
					foreach ($penugasanItems as $penugasanItem) {
						if ($penugasanItem["status"] < "7") {
							$batalSemuaPenugasan = 0;
						}
					}
				}
				
				if ($batalSemuaPenugasan) {
					$data = array();
					$data["status"] = "6";
					
					$this->penugasan_model->save($data, $item["penugasan_id"]);
				}
				
				$penugasan = $this->penugasan_model->getById($item["penugasan_id"]);
				$biodata = $this->biodata_model->getBiodataByNik($item["ktp"]);
				
				if (!empty($biodata)) {
					$user = $this->user_model->getUserBySyncBiodata($biodata["id"]);
					
					if (isset($user["telegram_chat_id"]) && !empty($user["telegram_chat_id"])) {
						$chatID = $user["telegram_chat_id"];
									
						$msg = "Hi.. <b>".$user["nama"]."</b>, \n";

						$msg .= "Opps.. Tugas kamu terkait ".$penugasan["nama"]." (".$item["kab_tujuan"].", ".$item["provinsi_tujuan"].") pada tgl ".$this->utility->formatRangeDate($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"])." telah dibatalkan.\n";
						$msg .= "Terimakasih.";

						$this->telegram->sendChat($chatID, $msg);
					}
				}
			}
		}
		
		if (isset($_POST) && !empty($_POST)) {
			print json_encode($out);
		}
	}
	
	public function gantiPenugasan () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$nomorSuratTugas = $_POST["nomor_surat"];
			$tglSuratTugas = date("Y-m-d", strtotime(str_replace(array("/"),array("-"),$_POST["tgl_surat"])));
			$bioadataIdBaru = $_POST["biodata_id"];
			
			$item = $this->penugasan_model->getItemById($id);
			
			if (!empty($item)) {
				
				if (isset($_FILES["surat_tugas"]) && !empty($_FILES["surat_tugas"])) {
				
					$allowed = array('pdf');
					$allowedSize = 5242880; // 5 Mb

					$suratTugas = $_FILES['surat_tugas'];
					$filename = $suratTugas['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					// Check File Type
					if (in_array($ext, $allowed)) {
						if ($suratTugas["size"] <= $allowedSize) {

							// Handle Upload File
							$tempFile = $suratTugas["tmp_name"];

							$targetPath = APPPATH . "../assets/surat_tugas";
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

							$targetPath = $targetPath."/".$_SESSION["tahun_anggaran"];
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

							$targetPath = $targetPath."/penugasan";
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");

							$targetFile =  "ST_Penugasan_".$item["penugasan_id"].".".$ext;
							move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);
						}
						else {
							$out["error"] = true;
							$out["msg"] = "Maksimal ukuran cap adalah 5 Mb";
						}
					}
					else {
						$out["error"] = true;
						$out["msg"] = "Tipe file cap tidak diizinkan. Silahkan mengupload file pdf.";
					}
				}
				
				
				if (!$out["error"]) {
				
					$data = array();
					$data["nomor_surat"] = $nomorSuratTugas;
					$data["tgl_surat"] = $tglSuratTugas;

					$this->penugasan_model->save($data, $item["penugasan_id"]);


					$this->load->model("biodata_model");
					$this->load->model("user_model");

					$petugasBaru = $this->biodata_model->getBiodataById($bioadataIdBaru);

					if (!empty($petugasBaru)) {
						$penugasan = $this->penugasan_model->getById($item["penugasan_id"]);
						$user = $this->user_model->getUserBySyncBiodata($petugasBaru["id"]);

						unset($petugasBaru["id"]);
						unset($petugasBaru["dibuat_tgl"]);
						unset($petugasBaru["diubah_tgl"]);
						unset($petugasBaru["diubah_oleh"]);
						
						$tglMulaiTugas = $item["tgl_mulai_tugas"];
						$tglSelesaiTugas = $item["tgl_selesai_tugas"];
						$tempatTujuan = $item["tempat_tujuan"];
						
						$out["penugasan_item"] = $item;

						$petugasBaru["penugasan_id"] = $item["penugasan_id"];
						$petugasBaru["surat_tugas"] = $item["surat_tugas"];
						$petugasBaru["tgl_mulai_tugas"] = $tglMulaiTugas;
						$petugasBaru["tgl_selesai_tugas"] = $tglSelesaiTugas;
						$petugasBaru["provinsi_asal"] = $item["provinsi_asal"];
						$petugasBaru["provinsi_tujuan"] = $item["provinsi_tujuan"];
						$petugasBaru["kab_asal"] = $item["kab_asal"];
						$petugasBaru["kab_tujuan"] = $item["kab_tujuan"];
						$petugasBaru["tempat_tujuan"] = $tempatTujuan;
						$petugasBaru["status"] = "0";

						$this->penugasan_model->saveItem($petugasBaru);


						if (isset($user["telegram_chat_id"]) && !empty($user["telegram_chat_id"])) {
							$chatID = $user["telegram_chat_id"];

							$msg = "Hi.. <b>".$user["nama"]."</b>, \n";

							$msg .= "Ada tugas baru untuk kamu yaitu ".$penugasan["nama"]." (".$petugasBaru["kab_tujuan"].", ".$petugasBaru["provinsi_tujuan"].") pada tgl ".$this->utility->formatRangeDate($petugasBaru["tgl_mulai_tugas"], $petugasBaru["tgl_selesai_tugas"]).".\n";

							$msg .= "Untuk selengkapnya <a href='".base_url("/admin/user/penugasan/")."'>klik disini</a> ya! \n";
							$msg .= "Terimakasih.";

							$this->telegram->sendChat($chatID, $msg);
						}
					}

					$this->batalPenugasan($item["id"]);
				}
			}
		}
	}
	
	public function ubahDetailPenugasan () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan penugasan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$id = $_POST["id"];
			$tglMulaiTugas = date("Y-m-d", strtotime(str_replace(array("/"),array("-"),$_POST["tgl_mulai_tugas"])));
			$tglSelesaiTugas = date("Y-m-d", strtotime(str_replace(array("/"),array("-"),$_POST["tgl_selesai_tugas"])));
			$provAsal = $_POST["provinsi_asal"];
			$kabAsal = $_POST["kab_asal"];
			$provTujuan = $_POST["provinsi_tujuan"];
			$kabTujuan = $_POST["kab_tujuan"];
			$tempat = $_POST["tempat_tujuan"];
			
			$data = array();
			$data["tgl_mulai_tugas"] = $tglMulaiTugas;
			$data["tgl_selesai_tugas"] = $tglSelesaiTugas;
			$data["provinsi_asal"] = $provAsal;
			$data["kab_asal"] = $kabAsal;
			$data["provinsi_tujuan"] = $provTujuan;
			$data["kab_tujuan"] = $kabTujuan;
			$data["tempat_tujuan"] = $tempat;
			
			$penugasanItemId = $this->penugasan_model->saveItem($data, $id);
			
			$this->load->model("spj_model");
			$spjItem = $this->spj_model->getItemByPenugasanItemId($penugasanItemId);
			
			if (!empty($spjItem)) {
				$data = array();
				$data["tgl_mulai_tugas"] = $tglMulaiTugas;
				$data["tgl_selesai_tugas"] = $tglSelesaiTugas;
				$data["provinsi_asal"] = $provAsal;
				$data["kab_asal"] = $kabAsal;
				$data["provinsi_tujuan"] = $provTujuan;
				$data["kab_tujuan"] = $kabTujuan;
				
				$this->spj_model->saveItem($data, $spjItem["id"]);
			}
		}
		
		print json_encode($out);
	}
	
	public function getJsonPenugasan () {
		$this->auth->login();
		
		$out = array();
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$out = $this->penugasan_model->getById($id);
		}
		
		print json_encode($out);
	}
}
