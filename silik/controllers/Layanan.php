<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Layanan extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view('frontend/buku_tamu/buku_tamu');
	}
	
	public function buku_tamu () {
		$this->load->view('frontend/buku_tamu/buku_tamu');
	}
	
	public function ult () {
		if (isset($_POST) && !empty($_POST)) {
			print "<pre>";
				print_r($_POST);
			print "</pre>";
		}
		else {
			$this->load->view('frontend/buku_tamu/layanan_ult');
		}
	}
}