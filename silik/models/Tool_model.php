<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tool_model extends CI_Model {
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    public function __construct() {
        $tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
    }
	
	public function saveQR ($data) {
		$user = $this->session->userdata('user');

		$data["dibuat_oleh"] = $user["id"];
		$data["dibuat_tgl"] = date("Y-m-d H:i:s");
			
		$this->new_db->insert('qr_generator', $data);
		$out = $this->new_db->insert_id();
		$this->new_db->reset_query();
		
		return $out;
	}


	public function getQRById ($id) {
		$out = array();
		
		$where = array();
		$where["id"] = $id;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('qr_generator');		
		$this->new_db->order_by('dibuat_tgl', 'asc');
		
		$qr = $this->new_db->get();
		
		if($qr->num_rows() > 0) {
			foreach ($qr->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getKontrak ($id) {
		$out = array();
		
		$where = array();
		$where["id"] = $id;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('kontrak_pm');
		
		$qr = $this->new_db->get();
		
		if($qr->num_rows() > 0) {
			foreach ($qr->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function importDataKontrakPM ($data) {
		$kontrak = array();

		$this->new_db->select("*");
		$this->new_db->from("kontrak_pm");
		$this->new_db->where("npsn", $data["npsn"]);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$kontrak = $row;
			}
		}

		if (empty($kontrak)) {			
			$this->new_db->insert("kontrak_pm", $data);
			$id = $this->new_db->insert_id();
		}
		else {
			$id = $kontrak["id"];
			$this->new_db->where("id", $id);
			$this->new_db->update("kontrak_pm", $data);
		}
		
		return $id;
	}
}
?>