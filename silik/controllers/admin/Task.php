<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		/*$data = array();
		$data["new_tiket"] = $this->tiket_model->getNew();
		$data["proses_tiket"] = $this->tiket_model->getByUserId($user["id"],"1","1");

		$this->load->vars($data);*/
	}
	
	public function index () {
		$this->auth->login();
		
		redirect(base_url("/admin/task/list"));
	}
	
	public function list () {
		$data = array();
		
		$this->load->view('backend/task/detail',$data);
	}

	public function change_priority () {
		$data = array("error" => false);

		print json_encode($data);
	}

	public function change_status () {
		$data = array("error" => false);
		print json_encode($data);
	}
}
