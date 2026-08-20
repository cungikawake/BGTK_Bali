<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Widyaiswara extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->model('widyaiswara_model');
	}
	
	public function index () {
		$this->auth->login();
	}

	public function list () {
		$this->auth->login();
		
		$data = array();
		$daya["error"] = false;

		$this->load->view('backend/widyaiswara/lists',$data);
	}

	public function save () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan laporan.";
		$out["close_modal"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];

			// HITUNG AKUMULASI JP
			/*$bulan = date("m",strtotime(str_replace(array("/"),array("-"), $_POST["tgl_selesai_kegiatan"])));
			$laporans = $this->widyaiswara_model->getByBulan($bulan);

			$totalJamPelajaranSebelum = 0;

			if (!empty($laporans)) {
				foreach ($laporans as $laporan) {
					$totalJamPelajaranSebelum += $laporan["jam_pelajaran"];
				}
			}

			if (!empty($id)) {

				$totalJamPelajaranSebelum = 0;

				foreach ($laporans as $laporan) {
					if ($laporan["id"] == $id) {
						break;
					}

					$totalJamPelajaranSebelum += $laporan["jam_pelajaran"];
				}
			}

			// KELEBIHAN JAM MENGAJAR
			$kelebihanJamPelajaran = 0;
			$totalJamPelajaranSekarang = $_POST["jam_pelajaran"] + $totalJamPelajaranSebelum;

			if ($totalJamPelajaranSekarang >= 32) {
				if ($totalJamPelajaranSebelum <= 32) {
					$kelebihanJamPelajaran = $totalJamPelajaranSekarang - 32;
				}
				else {
					$kelebihanJamPelajaran = $_POST["jam_pelajaran"];
				}
			}*/

			$submitType = $_POST["submit_btn"];
			
			$data = array();
			$data["judul"] = $_POST["judul"];
			$data["tgl_mulai_kegiatan"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$_POST["tgl_mulai_kegiatan"])));
			$data["tgl_selesai_kegiatan"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$_POST["tgl_selesai_kegiatan"])));
			$data["tempat_kegiatan"] = $_POST["tempat_kegiatan"];
			$data["kab_tempat_kegiatan"] = $_POST["kab_tempat_kegiatan"];
			$data["jam_pelajaran"] = $_POST["jam_pelajaran"];
			$data["total_jam_pelajaran"] = "0";
			$data["kelebihan_jam_pelajaran"] = "0";
			$data["dokumen_link"] = $_POST["dokumen_link"];
			$data["status"] = '0';
			
			if ($submitType == "validasi") {
				$out["msg"] = "Berhasil mengirim laporan untuk validasi.";
				$data["status"] = '1';
			}
			
			$id = $this->widyaiswara_model->save($data, $id);
			
			/*if (isset($_FILES) && !empty($_FILES)) {
				
				if (isset($_FILES['bukti_dokumen']) && !empty($_FILES['bukti_dokumen'])) {
					$buktiDokumen = $_FILES['bukti_dokumen'];
					$filename = $buktiDokumen['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					$allowed = array('pdf');
					$allowedSize = 5242880; // 5 Mb

					// Check File Type
					if (in_array($ext, $allowed)) {
						if ($buktiDokumen["size"] <= $allowedSize) {

							// Handle Upload File
							$tempFile = $buktiDokumen["tmp_name"];

							$targetPath = APPPATH . "../assets/laporan_wi";
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetPath = $targetPath."/".$_SESSION["tahun_anggaran"];
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetPath = $targetPath."/".$id;
							is_dir($targetPath) || @mkdir($targetPath) || die("Can't Create folder");
							chmod($targetPath, 0755);

							$targetFile =  "bukti_dokumen.".$ext;
							move_uploaded_file($tempFile,$targetPath. "/" .$targetFile);
						}
						else {
							$out["error"] = true;
							$out["msg"] = "Maksimal ukuran Bukti Dokumen adalah 5Mb";
						}
					}
					else {
						$out["error"] = true;
						$out["msg"] = "Tipe file Bukti Dokumen tidak diizinkan. Silahkan mengupload file bertipe .pdf";
					}
				}
			}*/
			
			if ($data["status"] == "2") {
				// Notif Telegram
				$users = $this->user_model->getUser();
				
				if (!empty($users)) {
					$this->load->library("telegram");

					foreach ($users as $user) {
						if (isset($user["akses"]["keuangan"]["apr_perjadin"]) && $user["akses"]["keuangan"]["apr_perjadin"] == "1") {
							$chatID = $user["telegram_chat_id"];
							
							$msg = "Hi.. <b>".$user["nama"]."</b>, \n";
							$msg .= "Ada laporan widyaiswara yang perlu disetujui.";
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

	public function approve_laporan () {
		$this->auth->login();

		$data = array();
		$daya["error"] = false;

		$this->load->view('backend/widyaiswara/lists_approve',$data);
	}

	public function approve () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyetujui laporan.";
		$out["close_modal"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];

			// HITUNG AKUMULASI JP
			$bulan = date("m",strtotime(str_replace(array("/"),array("-"), $_POST["tgl_selesai_kegiatan"])));
			$laporans = $this->widyaiswara_model->getByBulan($bulan, 1);

			$totalJamPelajaranSebelum = 0;

			if (!empty($laporans)) {
				foreach ($laporans as $laporan) {
					$totalJamPelajaranSebelum += $laporan["jam_pelajaran"];
				}
			}

			// KELEBIHAN JAM MENGAJAR
			$kelebihanJamPelajaran = 0;
			$totalJamPelajaranSekarang = $_POST["jam_pelajaran"] + $totalJamPelajaranSebelum;

			if ($totalJamPelajaranSekarang >= 32) {
				if ($totalJamPelajaranSebelum <= 32) {
					$kelebihanJamPelajaran = $totalJamPelajaranSekarang - 32;
				}
				else {
					$kelebihanJamPelajaran = $_POST["jam_pelajaran"];
				}
			}
			
			$data = array();
			$data["total_jam_pelajaran"] = $totalJamPelajaranSekarang;
			$data["kelebihan_jam_pelajaran"] = $kelebihanJamPelajaran;
			$data["status"] = '3';

			$submitType = $_POST["submit_btn"];
			
			if ($submitType == "tolak") {
				$out["msg"] = "Berhasil menolak laporan.";
				$data["total_jam_pelajaran"] = "0";
				$data["kelebihan_jam_pelajaran"] = "0";
				$data["status"] = '2';
			}
			
			$id = $this->widyaiswara_model->save($data, $id);
		}
		
		print json_encode($out);
		exit();
	}
}
