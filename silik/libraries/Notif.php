<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Notif {
		protected $CI;
		protected $new_db;
		public function __construct() {
			$this->CI =& get_instance();
			
			$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
			$group_prefix = 'transaction_'.$tahun_anggaran;
			$this->new_db = $this->CI->load->database($group_prefix, true);
		}
		
		public function getNotifHAI () {
			// NEW TIKET
			$this->new_db->select("*");
			$this->new_db->from("tiket");
			$this->new_db->where("user_id", "0");
			$this->new_db->where("status", "0");
			$this->new_db->where("feedback", "1");

			$query = $this->new_db->get();
			
			$count = $query->num_rows();
			
			$this->new_db->reset_query();
			
			// PROSES TIKET
			if (isset($_SESSION["user"])) {
				$this->new_db->select("*");
				$this->new_db->from("tiket");
				$this->new_db->where("user_id", $_SESSION["user"]["id"]);
				$this->new_db->where("status", "1");
				$this->new_db->where("feedback", "1");

				$query = $this->new_db->get();
				
				$count = $count + $query->num_rows();
			}
			

			return $count;
		}
		
		public function getNotifPenugasan () {
			$this->new_db->select("*");
			$this->new_db->from("penugasan_item");
			$where = "ktp='".$_SESSION["biodata"]["ktp"]."' AND (status = '0' OR status = '1' OR status = '3' OR status = '4')";
			
			$this->new_db->where($where);

			$query = $this->new_db->get();
			
			$count = $query->num_rows();
			
			$this->new_db->reset_query();
			
			return $count;
		}

		public function getNotifArsip () {
			$this->new_db->select("*");
			$this->new_db->from("arsip");
			$where = "dibuat_oleh='".$_SESSION["user"]["id"]."' AND (status = 'Baru' OR status = 'Ditolak SPI' OR status = 'Ditolak Kepala' OR status = 'Ditolak Arsiparis' OR status = 'Dipinjam')";
			
			$this->new_db->where($where);

			$query = $this->new_db->get();
			
			$count = $query->num_rows();
			
			$this->new_db->reset_query();
			
			return $count;
		}
		
		public function getNotifAprPenugasan () {
			if (isset($_SESSION["user"]["akses"]["kepegawaian"]["apr_penugasan"]) && $_SESSION["user"]["akses"]["kepegawaian"]["apr_penugasan"] == "1") {
				$this->new_db->select("*");
				$this->new_db->from("penugasan");
				$this->new_db->where("status", "1");

				$query = $this->new_db->get();

				$count = $query->num_rows();
				$this->new_db->reset_query();
			}
			else {
				$count = "";
			}
			
			return $count;
		}
		
		public function getNotifKepegawaianPenugasan () {
			if (isset($_SESSION["user"]["akses"]["kepegawaian"]["penugasan"]) && $_SESSION["user"]["akses"]["kepegawaian"]["penugasan"] == "1") {
				$this->new_db->select("*");
				$this->new_db->from("penugasan");
				$this->new_db->where("status", "3");

				$query = $this->new_db->get();

				$count = $query->num_rows();
				$this->new_db->reset_query();
			}
			else {
				$count = "";
			}
			
			return $count;
		}
		
		public function getNotifAprPerjadin () {
			if (isset($_SESSION["user"]["akses"]["keuangan"]["apr_perjadin"]) && $_SESSION["user"]["akses"]["keuangan"]["apr_perjadin"] == "1") {
				$this->new_db->select("*");
				$this->new_db->from("penugasan_item");
				$this->new_db->where("status", "2");

				$query = $this->new_db->get();

				$count = $query->num_rows();
				$this->new_db->reset_query();
			}
			else {
				$count = "";
			}
			
			return $count;
		}

		public function getNotifAprWidyaiswara () {
			if (isset($_SESSION["user"]["akses"]["widyaiswara"]["apr_widyaiswara"]) && $_SESSION["user"]["akses"]["widyaiswara"]["apr_widyaiswara"] == "1") {
				$this->new_db->select("*");
				$this->new_db->from("widyaiswara");
				$this->new_db->where("status", "1");

				$query = $this->new_db->get();

				$count = $query->num_rows();
				$this->new_db->reset_query();
			}
			else {
				$count = "";
			}
			
			return $count;
		}
	}
?>