<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{
	protected $salt;
	protected $table;
	protected $primary;
	
    function __construct() {
        $this->table = 'user';
        $this->primary = 'id';
		$this->salt = "BayuPrawiraSikedu2020";
    }
	
	public function getUser () {
		$out = array();
		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("status", "1");
		$this->db->order_by('no_urut', 'ASC');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (isset($row["akses"]) && !empty($row["akses"])) {
					$row["akses"] = json_decode($row["akses"], true);
				}
				else {
					$row["akses"] = array();
				}
				
				if (isset($row["notif"]) && !empty($row["notif"])) {
					$row["notif"] = json_decode($row["notif"], true);
				}
				else {
					$row["notif"] = array();
				}
				
				$out[$row["id"]] = $row;
			}
		}
		
		return $out;
	}
	
	public function getUserById ($id) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($this->primary, $id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		if (isset($out["notif"]) && !empty($out["notif"])) {
			$out["notif"] = json_decode($out["notif"], true);
		}
		else {
			$out["notif"] = array();
		}
		
		return $out;
	}
	
	public function getUserByUsername ($username) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("username", $username);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["notif"]) && !empty($row["notif"])) {
					$row["notif"] = json_decode($row["notif"], true);
				}
				else {
					$row["notif"] = array();
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getUserBySyncBiodata ($syncBiodata) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("sync_biodata", $syncBiodata);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["notif"]) && !empty($row["notif"])) {
					$row["notif"] = json_decode($row["notif"], true);
				}
				else {
					$row["notif"] = array();
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getUserByTelegramChatId ($chatId) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("telegram_chat_id", $chatId);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["notif"]) && !empty($row["notif"])) {
					$row["notif"] = json_decode($row["notif"], true);
				}
				else {
					$row["notif"] = array();
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function login ($username, $password) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("username", $username);
		$this->db->where("password", md5($this->salt.$password));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["notif"]) && !empty($row["notif"])) {
					$row["notif"] = json_decode($row["notif"], true);
				}
				else {
					$row["notif"] = array();
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function save ($data, $id = 0) {
		if (empty($id)) {
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
            $data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			if (isset($data["password"]) && !empty($data["password"])) {
				$data["password"] = md5($this->salt.$data["password"]);
			}
			
			$this->db->insert($this->table, $data);
			$id = $this->db->insert_id();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			if (isset($_SESSION["user"]["id"])) {
				$data['diubah_oleh'] = $_SESSION["user"]["id"];
			}
			
			if (isset($data["password"]) && !empty($data["password"])) {
				$data["password"] = md5($this->salt.$data["password"]);
			}
			
			$this->db->where($this->primary, $id);
			$this->db->update($this->table, $data);
		}
		
		return $id;
	}
	
	public function savePassword ($password, $id) {
		$data = array();
		$data['diubah_tgl'] = date("Y-m-d H:i:s");
		$data["password"] = md5($this->salt.$password);

		$this->db->where($this->primary, $id);
		$this->db->update($this->table, $data);
		
		return true;
	}
	
	public function saveDocument ($data) {
		$data['dibuat_tgl'] = date("Y-m-d H:i:s");
		
		$this->db->insert("user_document", $data);
		$id = $this->db->insert_id();
		
		return $id;
	}
	
	public function getDocumentById ($id) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from('user_document');
		$this->db->where('id', $id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function saveQuote ($data) {
		$data['dibuat_tgl'] = date("Y-m-d H:i:s");
		$data['diubah_tgl'] = date("Y-m-d H:i:s");
		
		if (isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])) {
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
		}
		
		if (isset($data["id"]) && !empty($data["id"])) {
			$id = $data['id'];
			
			unset($data['id']);
			
			$this->db->where('id', $id);
			$this->db->update("kutipan", $data);
		}
		else {
			$this->db->insert("kutipan", $data);
			$id = $this->db->insert_id();
		}
		
		return $id;
	}
	
	public function addNotif ($sync_biodata, $key) {
		$user = $this->getUserBySyncBiodata($sync_biodata);
		
		if (!empty($user["notif"]) && isset($user["notif"][$key])) {
			$user["notif"][$key]["count"] += 1;
		}
		else {
			$user["notif"][$key]["count"] = 1;
		}
		
		$user["notif"][$key]["read"] = 0;
		$user["notif"][$key]["open"] = 0;
		
		$data = array();
		$data["notif"] = json_encode($user["notif"]);
		
		$this->db->where("sync_biodata", $sync_biodata);
		$this->db->update($this->table, $data);
		
		if ($user["id"] == $_SESSION["user"]["id"]) {
			$_SESSION["user"]["notif"] = $user["notif"];
		}
	}
	
	public function deleteNotif ($sync_biodata, $key) {
		$user = $this->getUserBySyncBiodata($sync_biodata);
		
		if (!empty($user["notif"]) && isset($user["notif"][$key]) && isset($user["notif"][$key]["count"]) && !empty($user["notif"][$key]["count"])) {
			$user["notif"][$key]["count"] -= 1;
		}
		else {
			$user["notif"][$key]["count"] = 0;
		}
		
		$user["notif"][$key]["read"] = 0;
		$user["notif"][$key]["open"] = 0;
		
		$data = array();
		$data["notif"] = json_encode($user["notif"]);
		
		$this->db->where("sync_biodata", $sync_biodata);
		$this->db->update($this->table, $data);
		
		if ($user["id"] == $_SESSION["user"]["id"]) {
			$_SESSION["user"]["notif"] = $user["notif"];
		}
	}
}