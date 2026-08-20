<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validasi_ttd_model extends CI_Model {
    
	protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$db_tahun = $this->group_prefix . $_SESSION['tahun_anggaran']; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function get($jenisBerkas, $IdBerkas, $posisiTtd = "") {
		$out = array();
		
		$where = array();
		$where["jenis_berkas"] = $jenisBerkas;
		$where["id_berkas"] = $IdBerkas;
		
		if (!empty($posisiTtd)) {
			$where["posisi_ttd"] = $posisiTtd;
		}
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('validasi_ttd');
		
		$valids = $this->new_db->get();
		
		if($valids->num_rows() > 0) {
			foreach ($valids->result_array() as $key => $foo) {
				$foo["detail"] = json_decode($foo["detail"], true);
				$out[] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getByKode($kode) {
		$out = array();
		
		$where = array();
		$where["kode"] = $kode;
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('validasi_ttd');
		
		$valids = $this->new_db->get();
		
		if($valids->num_rows() > 0) {
			foreach ($valids->result_array() as $key => $foo) {
				$foo["detail"] = json_decode($foo["detail"], true);
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function save ($data, $id = 0) {
		if (empty($id)) {
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
			
			$this->new_db->insert("validasi_ttd", $data);
			$id = $this->new_db->insert_id();
			
			$data = array();
			$data["kode"] = md5($id."BayuPrawira");
			
			$this->new_db->where("id", $id);
			$this->new_db->update("validasi_ttd", $data);
		}
		else {
			$this->new_db->where("id", $id);
			$this->new_db->update("validasi_ttd", $data);
		}
		
		return $id;
	}
}
?>