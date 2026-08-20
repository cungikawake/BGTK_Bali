<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Biodata_model extends CI_Model{
	
    function __construct() {
		
    }
	
	public function countBiodata () {
		$count = $this->db->count_all('biodata');
		
		return $count;
	}
	
	public function getBiodataById ($id) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("biodata");
		$this->db->where("id", $id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getBiodataByNik ($nik) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("biodata");
		$this->db->where("ktp", $nik);
		
		$query = $this->db->get();
		
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
			
			if (isset($_SESSION["user"]["id"])) {
				$data['dibuat_oleh'] = $_SESSION["user"]["id"];
				$data['diubah_oleh'] = $_SESSION["user"]["id"];	
			}
			
			$this->db->insert("biodata", $data);
			$id = $this->db->insert_id();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			if (isset($_SESSION["user"]["id"])) {
				$data['diubah_oleh'] = $_SESSION["user"]["id"];	
			}
			
			$this->db->where("id", $id);
			$this->db->update("biodata", $data);
		}
		
		return $id;
	}
	
	public function updateByNIK ($data) {
		
		
		if (!empty($data["ktp"])){
			$biodata = $this->getBiodataByNik($data["ktp"]);
			
			if (empty($biodata)) {
				unset($data["id"]);
				unset($data["kegiatan_id"]);
				
				$data['dibuat_tgl']  = date("Y-m-d H:i:s");
				$data['diubah_tgl'] = date("Y-m-d H:i:s");
				
				if (isset($_SESSION["user"]["id"])) {
					$data['dibuat_oleh'] = $_SESSION["user"]["id"];
					$data['diubah_oleh'] = $_SESSION["user"]["id"];	
				}

				$this->db->insert("biodata", $data);
				$this->db->insert_id();
			}
			else {
				unset($data["id"]);
				unset($data["kegiatan_id"]);

				$data['diubah_tgl'] = date("Y-m-d H:i:s");
				
				if (isset($_SESSION["user"]["id"])) {
					$data['diubah_oleh'] = $_SESSION["user"]["id"];	
				}

				$this->db->where("ktp", $data["ktp"]);
				$this->db->update("biodata", $data);
			}
		}
		
		return $data;
	}
	
	public function updateDataBank ($data) {
		$data['diubah_tgl'] = date("Y-m-d H:i:s");
				
		if (isset($_SESSION["user"]["id"])) {
			$data['diubah_oleh'] = $_SESSION["user"]["id"];	
		}

		$data["valid_rekening"] = 1;

		$this->db->like('nama_bank', $data["nama_bank"]);
		$this->db->where("no_rekening", $data["no_rekening"]);

		if (isset($data["nama_bank"])) {
			unset($data["nama_bank"]);
		}

		$this->db->update("biodata", $data);
		
		return $this->db->affected_rows();
	}
	
	public function getBiodataByPegawaiBalai ($status = 1) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("biodata");
		$this->db->where("pegawai_balai", $status);
		//$this->db->where("ktp !=", "0000000000000001");
		$this->db->order_by('nama', 'ASC');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[$row["id"]] = $row;
			}
		}
		
		return $out;
	}
	
	
	public function searchBiodataByName ($term) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("biodata");
		$this->db->like('nama', $term, 'both');
		$this->db->order_by('nama', 'ASC');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getBirthday () {
	
		$out = array();
		
		$this->db->select("*");
		$this->db->from("biodata");
		$this->db->where("pegawai_balai", 1);
		$this->db->where("DAY(tgl_lahir)", date("d"));
		$this->db->where("MONTH(tgl_lahir)", date("m"));
		$this->db->order_by('nama', 'ASC');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
}