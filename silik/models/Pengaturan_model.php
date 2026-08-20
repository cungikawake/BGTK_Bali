<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengaturan_model extends CI_Model{
	
    function __construct() {
		
    }
	
	public function getPengaturanBySection ($section) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("pengaturan");
		$this->db->where("section", $section);
		$this->db->order_by("pos", "ASC");
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[$row["id"]] = $row;
			}
		}
		
		return $out;
	}
	
	public function getPengaturanBySistem ($sistem) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("pengaturan");
		$this->db->where("sistem", $sistem);
		$this->db->order_by("pos", "ASC");
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function save ($value, $section, $sistem) {
		$data = array();
		$data["value"] = $value;
		
		$this->db->where("section", $section);
		$this->db->where("sistem", $sistem);
		$this->db->update("pengaturan", $data);
		
		return $value;
	}
}