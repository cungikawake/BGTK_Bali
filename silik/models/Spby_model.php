<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spby_model extends CI_Model{
	
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$db_tahun = $this->group_prefix . $_SESSION['tahun_anggaran']; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function getAll () {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spby");
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[$row["id"]] = $row;
			}
		}
		
		return $out;
	}
	
	public function getById ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spby");
		$this->new_db->where("id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByTipeSpjId ($tipe = "transport", $spjId) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spby");
		$this->new_db->where("spj_id", $spjId);
		$this->new_db->where("tipe", $tipe);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getSpbyKegiatanBySpjId ($spj = "spj_kegiatan_peserta", $spjId, $akun) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spby");
		$this->new_db->where($spj, $spjId);
		$this->new_db->where("dipa_akun", $akun);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
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
			
			$this->new_db->insert("spby", $data);
			$id = $this->new_db->insert_id();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->where("id", $id);
			$this->new_db->update("spby", $data);
		}
		
		return $id;
	}
}