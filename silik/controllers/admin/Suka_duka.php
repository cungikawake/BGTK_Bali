<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suka_duka extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("suka_duka_model");
	}
	
	public function index () {
		$this->auth->login();
		
		$data = array();
		$this->load->view('backend/suka_duka/list',$data);
	}
	
	public function pembayaran () {
		$this->auth->login();
		
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		if (isset($_POST["year"]) && isset($_POST["month"]) && !empty($_POST["year"]) && !empty($_POST["month"])) {
			$data = array();
			$data["pembayaran"] = array();
			$data["pembayaran_item"] = array();
			
			$year = $_POST["year"];
			$month = $_POST["month"];

			$data["pembayaran_item"] = $this->suka_duka_model->getPembayaranItem($_SESSION["user"]["id"], $year, $month);

			$this->load->view('backend/suka_duka/modal_pembayaran',$data);
		}
	}
}
