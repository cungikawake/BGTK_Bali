<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kegiatan_options_model extends CI_Model{
	
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function get ($kegiatanId, $komponen = 0, $key = 0) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan_options");
		$this->new_db->where("kegiatan_id", $kegiatanId);

		if (!empty($komponen)) {
			$this->new_db->where("code_komponen", $komponen);
		}

		if (!empty($key)) {
			$this->new_db->where("key", $key);
		}
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {

				// Parse Json to Array
				if ($row["key"] == "link") {
					$row["value"] = json_decode($row["value"], true);
				}

				if ($row["key"] == "kategori") {
					$row["value"] = json_decode($row["value"], true);
				}

				if ($row["key"] == "daftar_hadir") {
					$row["value"] = json_decode($row["value"], true);
				}

				$out[$row["id"]] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getSertifikatIdByKegiatanKomponenYear ($kegiatanId, $komponen, $year) {
		$out = 0;

		// Make new connection to db transaction
		$db_tahun = $this->group_prefix . $year; 
		$this->db_trans = $this->load->database($db_tahun, true);
		
		$this->db_trans->select("*");
		$this->db_trans->from("kegiatan_options");
		$this->db_trans->where("kegiatan_id", $kegiatanId);
		
		$this->db_trans->where("code_komponen", $komponen);
		$this->db_trans->where("key", "sertificate");
		
		$query = $this->db_trans->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row["value"];
			}
		}
		
		$this->db_trans->reset_query();
		
		return $out;
	}

	

	public function getByKegiatanKomponenAndYear ($kegiatanId, $komponen, $year) {
		$out = array();

		// Make new connection to db transaction
		$db_tahun = $this->group_prefix . $year; 

		$this->db_trans = $this->load->database($db_tahun, true);
		
		$this->db_trans->select("*");
		$this->db_trans->from("kegiatan_options");
		$this->db_trans->where("kegiatan_id", $kegiatanId);
		$this->db_trans->where("code_komponen", $komponen);
		
		$query = $this->db_trans->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {

				// Parse Json to Array
				if ($row["key"] == "link") {
					$row["value"] = json_decode($row["value"], true);
				}

				if ($row["key"] == "kategori") {
					$row["value"] = json_decode($row["value"], true);
				}

				if ($row["key"] == "daftar_hadir") {
					$row["value"] = json_decode($row["value"], true);
				}

				$out[$row["id"]] = $row;
			}
		}
		
		$this->db_trans->reset_query();
		
		return $out;
	}
	
	public function save ($data, $id = 0) {

		if (empty($id)) {
			$this->new_db->insert("kegiatan_options", $data);
			$id = $this->new_db->insert_id();
			$this->new_db->reset_query();
		}
		else {			
			$this->new_db->where("id", $id);
			$this->new_db->update("kegiatan_options", $data);
			$this->new_db->reset_query();
		}
		
		return $id;
	}
	
	public function delete ($id) {
		
		$this->new_db->where('id', $id);
		$this->new_db->delete("kegiatan_options");
		$this->new_db->reset_query();
	}
}