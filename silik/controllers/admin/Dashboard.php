<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->auth->login();
		
		$this->load->model("kegiatan_model"); 
		$this->load->model("biodata_model");
		$this->load->model("kutipan_model");
		$this->load->model("tiket_model");
		
		$data = array();
		$data["kegiatan"] = $this->kegiatan_model->countKegiatan();
		
		$data["biodata"] = $this->biodata_model->countBiodata();
		$data["kutipan"] = $this->kutipan_model->getRandom();
		$data["hai_ranking"] = array();//$this->tiket_model->getHaRanking();
		$data["birthday"] = $this->biodata_model->getBirthday();
		
		$this->load->view('backend/dashboard', $data);
	}

	public function dashboard_pelatihan() {
		$this->auth->login();
		$this->load->model("dashboard_pelatihan_model");

		$data = array();

		$data["kegiatan"] = $this->dashboard_pelatihan_model->countPelatihan();
		
		$data["pelatihan_graph"] = $this->dashboard_pelatihan_model->countPelatihanGraph();

		$data["biodata"] = $this->dashboard_pelatihan_model->countPesertaPelatihan();

		$this->load->view('backend/dashboard2', $data);
	}
}
