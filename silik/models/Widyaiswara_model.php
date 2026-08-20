<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widyaiswara_model extends CI_Model {
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    public function __construct() {
        $tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
    }

	public function getById($id) {
		$out = array("id" => 0);
		
		$where = array();
		$where["id"] = $id;
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('widyaiswara');
		$this->new_db->order_by('id', 'desc');
		$this->new_db->limit(1);
		
		$absen = $this->new_db->get();
		
		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function save ($data, $id = 0) {

		if (empty($id)) {
			
			if (!isset($data['dibuat_tgl'])) {
				$data['dibuat_tgl'] = date("Y-m-d H:i:s");
			}
			
			$data['user_id'] = $_SESSION["user"]["id"];
			
			$this->new_db->insert("widyaiswara", $data);
			$id = $this->new_db->insert_id();
			
			$this->new_db->reset_query();
		}
		else {			
			$this->new_db->where("id", $id);
			$this->new_db->update("widyaiswara", $data);
			$this->new_db->reset_query();
		}
		
		return $id;
	}

	public function getByBulan ($bulan, $status = null) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("widyaiswara");
		$this->new_db->where("MONTH(tgl_selesai_kegiatan)", $bulan);
		$this->new_db->order_by('tgl_selesai_kegiatan', 'ASC');

		if (!empty($status)) {
			$this->new_db->where("status", $status);
		}
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
}
?>