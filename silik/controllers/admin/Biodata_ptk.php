<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biodata_ptk extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("biodata_ptk_model");
	}
	
	public function index() {
		$this->auth->login();
		
		$this->load->view('backend/biodata_ptk/lists');
	}
	
	public function save () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan biodata!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			if (isset($_POST["kab_unit_kerja"]) && $_POST["kab_unit_kerja"] == "Lainnya") {
				$_POST["kab_unit_kerja"] = $_POST["kab_unit_kerja_lainnya"];
			}
			unset($_POST["kab_unit_kerja_lainnya"]);
			
			$data = $_POST;
			
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			if (isset($data["tgl_lahir"]) && !empty($data["tgl_lahir"])) {
				$data["tgl_lahir"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_lahir"])));
			}

			$id = $this->biodata_model->save($data, $id);
			
			if (isset($_SESSION["biodata"]["id"]) && $_SESSION["biodata"]["id"] == $id) {
				$biodata = $this->biodata_model->getBiodataById($id);
				$_SESSION["biodata"] = $biodata;
			}

			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan biodata. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	
	public function edit () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan biodata!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			if (isset($data["tgl_lahir"]) && !empty($data["tgl_lahir"])) {
				$data["tgl_lahir"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_lahir"])));
			}

			$id = $this->biodata_model->save($data, $id);

			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan biodata. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function search() {
		$out = array();
		$out["results"] = array();
		
		if (isset($_POST["term"]) && !empty($_POST["term"])) {
			$biodatas = $this->biodata_model->searchBiodataByName($_POST["term"]["term"]);
			
			if (!empty($biodatas)) {
				foreach ($biodatas as $biodata) {
					$out["results"][] = array(
						"id" => $biodata["id"],
						"text" => $biodata["nama"],
					);
				}
			}
		}
		
		print json_encode($out);
	}
	
	public function getDetailById () {
		$out = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$biodatas = $this->biodata_model->getBiodataById($_POST["id"]);
			
			if (!empty($biodatas)) {
				foreach ($biodatas as $biodata) {
					$out = $biodata;
				}
			}
		}
		
		print json_encode($biodatas);
	}
	
	public function getDetailByNik () {
		$out = array();
		
		if (isset($_POST["nik"]) && !empty($_POST["nik"])) {
			$biodatas = $this->biodata_model->getBiodataByNik($_POST["nik"]);
			
			if (isset($biodatas["no_rekening"])) {
			    $biodatas["no_rekening"] = str_replace(array(" ","-","."), array("","",""), $biodatas["no_rekening"]);
				    
		        $biodatas["no_rekening"] = trim($biodatas["no_rekening"]);
			}
			
		    
		    $biodatas["punya_buku_tabungan"] = 0;
		    
		    if (isset($biodatas["ktp"])) {
		        $filename = APPPATH . "../assets/buku_tabungan/tabungan_".$biodatas["ktp"].".jpg";

                if (file_exists($filename)) {
                    $biodatas["punya_buku_tabungan"] = 1;
                }
		    }
			
		}
		
		print json_encode($biodatas);
	}
	
	public function import_data_bank () {
		$this->auth->login();
		
		$data = array();
		print $this->load->view('backend/biodata/modal_import_data_bank', $data, true);
	}
	
	public function execute_import_data_bank () {
		$this->auth->login();
		
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

		if (isset($_FILES["csv_data_bank"]) && $_FILES["csv_data_bank"]["size"] > 0 && in_array($_FILES['csv_data_bank']['type'], $csvMimes)) {
			
			$handle = fopen($_FILES['csv_data_bank']['tmp_name'], "r");
			$headers = fgetcsv($handle, 1000, ";");
			
			if (count($headers) == 3 || count($headers) == 4) {
				$i = 1;

				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
					$foo = array();
					$foo["no_rekening"] = $data[0];
					$foo["nama_pemilik_rekening"] = $data[1];
					$foo["nama_bank"] = $data[2];
					
					$execute = $this->biodata_model->updateDataBank($foo);
					
					$out["result"][] = array(
						"no" => $i,
						"no_rekening" => $data[0],
						"nama_pemilik_rekening" => $data[1],
						"nama_bank" => $data[2],
						"result" => $execute
					);

					$i++;
				}
				
				$out["error"] = false;
				$out["msg"] = "Import Data Bank Berhasil";
			}
			
			fclose($handle);
		}
		
		print json_encode($out);		
	}
}
