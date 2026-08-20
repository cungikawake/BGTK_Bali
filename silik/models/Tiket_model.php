<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tiket_model extends CI_Model {
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    public function __construct() {
        $tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
    }
	
	public function getNew() {
		$out = array();
		
		$where = array();
		$where["status"] = "0";
		$where["user_id"] = "0";
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('tiket');
		$this->new_db->order_by('dibuat_tgl', 'asc');
		
		$tiket = $this->new_db->get();
		
		if($tiket->num_rows() > 0) {
			
			foreach ($tiket->result_array() as $key => $foo) {
				$foo["drive_file"] = json_decode($foo["drive_file"], true);
				$out[$key] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getByUserId($userId, $status = "0", $feedback = null) {
		$out = array();
		
		$where = array();
		$where["user_id"] = $userId;
		$where["status"] = $status;
		
		if ($feedback !== null) {
			$where["feedback"] = $feedback;
		}
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('tiket');
		$this->new_db->order_by('dibuat_tgl', 'asc');
		
		$tiket = $this->new_db->get();
		
		if($tiket->num_rows() > 0) {
			foreach ($tiket->result_array() as $key => $foo) {
				$foo["drive_file"] = json_decode($foo["drive_file"], true);
				$out[] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getById($id) {
		$out = array();
		
		$where = array();
		$where["id"] = $id;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('tiket');		
		$this->new_db->order_by('dibuat_tgl', 'asc');
		
		$tiket = $this->new_db->get();
		
		if($tiket->num_rows() > 0) {
			foreach ($tiket->result_array() as $key => $foo) {
				$foo["drive_file"] = json_decode($foo["drive_file"], true);
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getByGuestFeedback($guestId,$feedback) {
		$out = array();
		
		$where = array();
		$where["guest_id"] = $guestId;
		$where["feedback"] = $feedback;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('tiket');		
		$this->new_db->order_by('dibuat_tgl', 'asc');
		
		$tiket = $this->new_db->get();
		
		if($tiket->num_rows() > 0) {
			foreach ($tiket->result_array() as $key => $foo) {
				$foo["drive_file"] = json_decode($foo["drive_file"], true);
				$out[] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getChat($id) {
		$out = array();
		
		$where = array();
		$where["tiket_id"] = $id;
		
		$this->new_db->select('*');
		$this->new_db->from('tiket_chat');
		$this->new_db->where($where);
		$this->new_db->order_by('id', 'asc');
		
		$tiket = $this->new_db->get();
		
		if($tiket->num_rows() > 0) {
			foreach ($tiket->result_array() as $key => $foo) {
				$foo["drive_file"] = json_decode($foo["drive_file"], true);
				$out[] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function update ($data, $id) {
		$this->new_db->where("id", $id);
		$this->new_db->update("tiket", $data);
		$this->new_db->reset_query();
		
		return $id;
	}
	
	public function updateChat ($data, $id) {
		$this->new_db->where("id", $id);
		$this->new_db->update("tiket_chat", $data);
		$this->new_db->reset_query();
		
		return $id;
	}
	
	public function saveNewChat ($judul, $deskripsi) {
		$guest = $this->session->userdata('guest');
		$dibuat_tgl = date("Y-m-d H:i:s");
		
		$data = array();
		$data["judul"] = $judul;
		$data["guest_id"] = $guest["id"];
		$data["status"] = 0;
		$data["deskripsi"] = $deskripsi;
		$data["dibuat_tgl"] = $dibuat_tgl;
		$data["feedback"] = "1";
		$data["feedback_tgl"] = $dibuat_tgl;
			
		$this->new_db->insert('tiket', $data);
		$id = $this->new_db->insert_id();
		$this->new_db->reset_query();
		
		$data = array();
		$data["no"] = $this->utility->getHAINumber($id);
		
		$this->new_db->where('id', $id);
		$this->new_db->update('tiket', $data);
		$this->new_db->reset_query();
		
		return $id;
	}
	
	public function saveChat ($parentId, $msg) {
		$guest = $this->session->userdata('guest');
		$dibuat_tgl = date("Y-m-d H:i:s");
		
		$data = array();
		$data["tiket_id"] = $parentId;
		$data["guest_id"] = $guest["id"];
		$data["deskripsi"] = $msg;
		$data["dibuat_tgl"] = $dibuat_tgl;
			
		$this->new_db->insert('tiket_chat', $data);
		$id = $this->new_db->insert_id();
		$this->new_db->reset_query();
		
		$data = array();
		$data["feedback"] = "1";
		$data["feedback_tgl"] = $dibuat_tgl;
		
		$this->new_db->where('id', $parentId);
		$this->new_db->update('tiket', $data);
		$this->new_db->reset_query();
		
		return $id;
	}
	
	public function saveChatAdmin ($parentId, $msg) {
		$user = $this->session->userdata('user');

		$data = array();
		$data["tiket_id"] = $parentId;
		$data["user_id"] = $user["id"];
		$data["deskripsi"] = $msg;
		$data["dibuat_tgl"] = date("Y-m-d H:i:s");
			
		$this->new_db->insert('tiket_chat', $data);
		$out = $this->new_db->insert_id();
		$this->new_db->reset_query();
		
		$data = array();
		$data["user_id"] = $user["id"];
		$data["status"] = "1";
		$data["feedback"] = "0";
		$data["feedback_tgl"] = date("Y-m-d H:i:s");
		
		$this->new_db->where('id', $parentId);
		$this->new_db->update('tiket', $data);
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getHaRanking () {
		$out = array();
		
		$this->db->select('tiket.user_id, user.nama, COUNT(tiket.user_id) as total_respon, SUM(tiket.rating) as total_rating');
		$this->db->join('user','user.id=tiket.user_id','left'); 
		$this->db->group_by('user_id'); 
		$this->db->order_by('total_respon', 'desc'); 
		$tiket = $this->db->get('tiket',5);
		
		if($tiket->num_rows() > 0) {
			foreach ($tiket->result_array() as $key => $foo) {
				$out[] = $foo;
			}
		}
		
		$this->db->reset_query();
		
		return $out;
	}
}
?>