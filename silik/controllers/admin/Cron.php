<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

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
		exit();
	}

	public function deface_hack () {

		$path = "/vendor/onix.php";
		$filename = APPPATH . ".." . $path;

		if (file_exists($filename)) {
			unlink($filename);
		}

		$file404 = "/404.php";
		$filename404 = APPPATH . ".." . $file404;

		if (file_exists($filename404)) {
			unlink($filename404);

			$indexfile = APPPATH . "../assets/index.php";

			if (file_exists($indexfile)) {
				rename($indexfile, APPPATH . "../index.php");
			}
		}

		$fileMAU = "/mau.txt";
		$filenameMAU = APPPATH . ".." . $fileMAU;

		if (file_exists($filenameMAU)) {
			unlink($filenameMAU);
		}
	}
}
