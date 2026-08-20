<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("pengaturan_model");
		$this->load->model("biodata_model");
		
		$pegawai = $this->biodata_model->getBiodataByPegawaiBalai();
		
		$data = array();
		$data["pegawai"] = $pegawai;

		$this->load->vars($data);
	}
	
	public function satker() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "satker";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}
	
	public function mak() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "mak";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}
	
	public function pejabat() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "pejabat";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}
	
	public function api() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "api";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}
	
	public function smtp() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "smtp";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}

	public function arsip() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "arsip";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}

	public function absensi() {
		$this->auth->login();
		
		$data = array();
		$data["section"] = "absensi";
		$data["form"] = $this->pengaturan_model->getPengaturanBySection($data["section"]);
		
		$this->load->view('backend/pengaturan/pengaturan', $data);
	}
	
	public function save () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan data!";
		$out["reload"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			
			foreach ($data[$data["section"]] as $sistem => $val) {
				$this->pengaturan_model->save($val, $data["section"], $sistem);
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	
	public function edit () {
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
			
			if (!empty($biodatas)) {
				foreach ($biodatas as $biodata) {
					$out = $biodata;
				}
			}
		}
		
		print json_encode($biodatas);
	}
}
