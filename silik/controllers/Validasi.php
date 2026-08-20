<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("validasi_ttd_model");
		$this->load->model("pengaturan_model");
	}
	
	function ttd ($kode = "") {
		if (!empty($kode)) {
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
		
			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$data["satker"][$foo["sistem"]] = $foo["value"];
				}
			}

			$ttd = $this->validasi_ttd_model->getByKode($kode);
			
			if (!empty($ttd)) {
				$this->load->view('frontend/validasi/ttd', $ttd);
			}
			else {
				$this->load->view('frontend/errors/ttd');
			}
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
}