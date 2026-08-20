<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Auth {
		protected $CI;
		
		public function __construct() {
			$this->CI =& get_instance();
		}
		
		public function login ($param = null) {
			if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {

				if (!empty($param)) {
					$_SESSION["login_redirect"] = $param;
				}

				redirect(base_url('/admin/login/'));
				exit();
			}
		}
		
		/*public function guest () {
			redirect(base_url('/admin/login/'));

			// if (!isset($_SESSION["guest"]) || empty($_SESSION["guest"])) {
			// 	redirect(base_url('/user/login/'));
			// }
		}*/

		public function guest () {
			if (!isset($_SESSION["guest"]) || empty($_SESSION["guest"])) {
				redirect(base_url('/user/login/'));
			}
		}
	}
?>