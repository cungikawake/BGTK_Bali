<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tool extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index () {
		redirect(base_url('/admin/tool/qr_generator'));
	}

	public function qr_generator () {
		$this->auth->login();

		$data = array();
		$this->load->view('backend/tool/qr_generator',$data);
	}

	public function save_qr () {
		$this->auth->login();

		if (isset($_POST) && !empty($_POST)) {
			$out = array();
			$out["error"] = false;
			$out["msg"] = "";
			$out["close_modal"] = true;
			$out["reload_table"] = true;
			
			$this->load->model("tool_model");

			$data = array();
			$data["url"] = $_POST["url"];
			
			$this->tool_model->saveQR($data);

			print json_encode($out);
		}
		else {
			$this->load->view('backend/user/login');
		}
	}

	public function download_qr ($id = 0) {
		$this->auth->login();
		
		if (!empty($id)) {
			$this->load->model("tool_model");
			$qr = $this->tool_model->getQRById($id);

			if (!empty($qr)) {
				$this->load->library('qr_code');
				$image = $this->qr_code->create(500, $qr["url"]);

				$resultimg = str_replace("data:image/png;base64,","",$image);
				header('Content-Disposition: attachment;filename="qr_code.png"');
				header('Content-Type: image/png');
				echo base64_decode($resultimg);                
				exit();
			}
			else {
				die('The provided file path is not valid.');
			}
		}
		else {
			die('The provided file path is not valid.');
		}
	}

	public function kontrak_pm () {
		$this->auth->login();
		$this->load->view('backend/tool/kontrak_pm');
	}

	public function download_kontrak_pm ($id = null) {
		$this->auth->login();
		$this->load->library('word');

		if (!empty($id)) {
			$this->load->model("tool_model");

			$kontrak = $this->tool_model->getKontrak($id);

			$data = array(
				"npsn"	=> $kontrak["npsn"],
				"sekolah" => $kontrak["nama_sekolah"],
				"nomor_bgtk" => $kontrak["nomor_bgtk"],
				"nomor_sekolah" => "",
				"tgl_perjanjian" => $kontrak["tgl_kks"],
				"nama_kepala_sekolah" => "",
				"jabatan_kepala_sekolah" => "",
				"alamat_sekolah" => "",
				"nip_kepala_sekolah" => "",
				"tlp_sekolah" => "",
				"email_sekolah" => "",
				"jumlah_guru" => $kontrak["jumlah_guru"],
				"jumlah_ks" => $kontrak["jumlah_ks"],
				"jenis_dana" => "",
				"kabupaten" => "Denpasar",
				"biaya_pnbp_guru" => $kontrak["biaya_pnbp_guru"],
				"biaya_pnbp_ks" => $kontrak["biaya_pnbp_ks"],
				"biaya_non_pnbp_guru" => $kontrak["biaya_non_pnbp_guru"],
				"biaya_non_pnbp_ks" => $kontrak["biaya_non_pnbp_ks"],
				"nomor_rekening" => $kontrak["nomor_rekening"],
				"nama_rekening" => $kontrak["nama_rekening"]
			);

			$this->word->save($data);

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.$kontrak["npsn"].'_'.$kontrak["nama_sekolah"].'.docx"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize(APPPATH."../assets/kontrak_pm/".$data["npsn"]."_".$data["sekolah"].".docx"));
			ob_clean();
			flush();
			readfile(APPPATH."../assets/kontrak_pm/".$data["npsn"]."_".$data["sekolah"].".docx");
		}
	}

	public function import_data_kontrak_pm () {
		$data = array();
		print $this->load->view('backend/tool/modal_import_data_kontrak_pm', $data, true);
	}

	public function execute_import_data_kontrak_pm () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "File atau format CSV Tidak Valid";
		$out["result"] = array();
		
		$csvMimes = array(
			'text/csv',
			'text/plain',
			'application/csv',
			'text/comma-separated-values',
			'application/excel',
			'application/vnd.ms-excel',
			'application/vnd.msexcel',
			'text/anytext',
			'application/octet-stream',
			'application/txt',
		);

		if (isset($_FILES["csv_data_kontrak_pm"]) && $_FILES["csv_data_kontrak_pm"]["size"] > 0 && in_array($_FILES['csv_data_kontrak_pm']['type'], $csvMimes)) {
			$this->load->model("tool_model");

			$handle = fopen($_FILES['csv_data_kontrak_pm']['tmp_name'], "r");
			$headers = fgetcsv($handle, 1000, ";");

			if (count($headers) == 14) {
				$i = 1;

				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
					if (empty($data[1])) {
						continue;
					}

					$foo = array();
					$foo["npsn"] = $data[1];
					$foo["nama_sekolah"] = $data[2];
					$foo["kab_unit_kerja"] = $data[3];
					$foo["nomor_bgtk"] = $data[4];
					$foo["tgl_kks"] = $data[5];
					$foo["jumlah_ks"] = $data[6];
					$foo["jumlah_guru"] = $data[7];
					$foo["biaya_pnbp_ks"] = $data[8];
					$foo["biaya_pnbp_guru"] = $data[10];
					$foo["biaya_non_pnbp_ks"] = $data[9];
					$foo["biaya_non_pnbp_guru"] = $data[11];
					$foo["nomor_rekening"] = $data[12];
					$foo["nama_rekening"] = $data[13];
					
					$execute = $this->tool_model->importDataKontrakPM($foo);
					
					$out["result"][] = array(
						"no" => $i,
						"npsn" => $foo["npsn"],
						"nama_sekolah" =>$foo["nama_sekolah"],
						"kabupaten" => $foo["kab_unit_kerja"],
						"result" => $execute
					);

					$i++;
				}
				
				$out["error"] = false;
				$out["msg"] = "Import Data KKS Berhasil";
			}
			
			fclose($handle);
		}
		
		print json_encode($out);		
	}
}
