<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sertifikat_model extends CI_Model{
	
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() {
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function getById ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("sertifikat");
		$this->new_db->where("id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}

	public function getByIdAndYear ($id, $year) {
		$out = array();
		
		// Make new connection to db transaction
		$db_tahun = $this->group_prefix . $year; 
		$this->db_trans = $this->load->database($db_tahun, true);

		$this->db_trans->select("*");
		$this->db_trans->from("sertifikat");
		$this->db_trans->where("id", $id);
		
		$query = $this->db_trans->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function save ($data, $id = 0) {
		if (empty($id)) {
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
            $data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			$this->new_db->insert('sertifikat', $data);
			$id = $this->new_db->insert_id();
		}
		else {
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			$this->new_db->where('id', $id);
			$this->new_db->update('sertifikat', $data);
		}
		
		return $id;
	}

	public function add_page ($data, $id = 0) {
		
		$data['diubah_oleh'] = $_SESSION["user"]["id"];
		$data['diubah_tgl'] = date("Y-m-d H:i:s");
		
		$this->new_db->where('id', $id);
		$this->new_db->update('sertifikat', $data);
		
		return $id;
	}
	
	public function getTypeHead ($term) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("sertifikat");
		$this->new_db->like('nama', $term);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
}