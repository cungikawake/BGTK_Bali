<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dakung_model extends CI_Model{
	
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function getByKegiatanId ($kegiatanId) {
		$out = array();
		$user = array();
		
		$this->db->select("*");
		$this->db->from("user");
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$user[$row["id"]] = $row["username"];
			}
		}
		
		$this->db->reset_query();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan_data_dukung");
		$this->new_db->where("kegiatan_id", $kegiatanId);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["user"] = $user[$row["dibuat_oleh"]];
				$out[] = $row;
			}
		}
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getById ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan_data_dukung");
		$this->new_db->where("id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function save ($data, $id = 0) {

		if (empty($id)) {
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
            $data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->insert("kegiatan_data_dukung", $data);
			$id = $this->new_db->insert_id();
			$this->new_db->reset_query();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->where("id", $id);
			$this->new_db->update("kegiatan_data_dukung", $data);
			$this->new_db->reset_query();
		}
		
		return $id;
	}
	
	public function delete ($id) {
		$this->new_db->where('id', $id);
		$this->new_db->delete('kegiatan_data_dukung');
		$this->new_db->reset_query();
		
		return true;
	}
}