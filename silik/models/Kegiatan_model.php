<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kegiatan_model extends CI_Model{

	protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
    }

	public function get_all() {
        return $this->new_db->get('kegiatan')->result();
    }
	
	public function countKegiatan () {
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');

		$this->new_db->where("YEAR(tgl_selesai_kegiatan)", $tahun_anggaran);
		$this->new_db->from('kegiatan');
		
		$count = $this->new_db->count_all_results();
		 
		return $count;
	}
	
	public function getKegiatanById ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan");
		$this->new_db->where("id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		if (isset($out["link_peserta"]) && !empty($out["link_peserta"])) {
			$out["link_peserta"] = (array) json_decode($out["link_peserta"]);
		}
		
		if (isset($out["link_narasumber"]) && !empty($out["link_narasumber"])) {
			$out["link_narasumber"] = (array) json_decode($out["link_narasumber"]);
		}
		
		if (isset($out["link_panitia"]) && !empty($out["link_panitia"])) {
			$out["link_panitia"] = (array) json_decode($out["link_panitia"]);
		}
		
		if (isset($out["link_moderator"]) && !empty($out["link_moderator"])) {
			$out["link_moderator"] = (array) json_decode($out["link_moderator"]);
		}
		
		if (isset($out["link_pp"]) && !empty($out["link_pp"])) {
			$out["link_pp"] = (array) json_decode($out["link_pp"]);
		}
		
		if (isset($out["link_fasil"]) && !empty($out["link_fasil"])) {
			$out["link_fasil"] = (array) json_decode($out["link_fasil"]);
		}
		
		if (isset($out["link_instruktur"]) && !empty($out["link_instruktur"])) {
			$out["link_instruktur"] = (array) json_decode($out["link_instruktur"]);
		}
		
		if (isset($out["link_pengawas"]) && !empty($out["link_pengawas"])) {
			$out["link_pengawas"] = (array) json_decode($out["link_pengawas"]);
		}
		
		if (isset($out["link_kepala_sekolah"]) && !empty($out["link_kepala_sekolah"])) {
			$out["link_kepala_sekolah"] = (array) json_decode($out["link_kepala_sekolah"]);
		}
		
		if (isset($out["detail_tgl_kegiatan"]) && !empty($out["detail_tgl_kegiatan"])) {
			$out["detail_tgl_kegiatan"] = (array) json_decode($out["detail_tgl_kegiatan"]);
		}
		
		if (isset($out["komponen"]) && !empty($out["komponen"])) {
			$out["komponen"] = (array) json_decode($out["komponen"]);
		}
		
		if (isset($out["kategori"]) && !empty($out["kategori"])) {
			$out["kategori"] = (array) json_decode($out["kategori"]);
		}
		
		return $out;
	}

	public function getKegiatanByIdAndYear ($id, $year) {
		$out = array();

		// Make new connection to db transaction
		$db_tahun = $this->group_prefix . $year; 
		$this->db_trans = $this->load->database($db_tahun, true);
		
		$this->db_trans->select("*");
		$this->db_trans->from("kegiatan");
		$this->db_trans->where("id", $id);
		
		$query = $this->db_trans->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		$this->db_trans->reset_query();
		
		if (isset($out["link_peserta"]) && !empty($out["link_peserta"])) {
			$out["link_peserta"] = (array) json_decode($out["link_peserta"]);
		}
		
		if (isset($out["link_narasumber"]) && !empty($out["link_narasumber"])) {
			$out["link_narasumber"] = (array) json_decode($out["link_narasumber"]);
		}
		
		if (isset($out["link_panitia"]) && !empty($out["link_panitia"])) {
			$out["link_panitia"] = (array) json_decode($out["link_panitia"]);
		}
		
		if (isset($out["link_moderator"]) && !empty($out["link_moderator"])) {
			$out["link_moderator"] = (array) json_decode($out["link_moderator"]);
		}
		
		if (isset($out["link_pp"]) && !empty($out["link_pp"])) {
			$out["link_pp"] = (array) json_decode($out["link_pp"]);
		}
		
		if (isset($out["link_fasil"]) && !empty($out["link_fasil"])) {
			$out["link_fasil"] = (array) json_decode($out["link_fasil"]);
		}
		
		if (isset($out["link_instruktur"]) && !empty($out["link_instruktur"])) {
			$out["link_instruktur"] = (array) json_decode($out["link_instruktur"]);
		}
		
		if (isset($out["link_pengawas"]) && !empty($out["link_pengawas"])) {
			$out["link_pengawas"] = (array) json_decode($out["link_pengawas"]);
		}
		
		if (isset($out["link_kepala_sekolah"]) && !empty($out["link_kepala_sekolah"])) {
			$out["link_kepala_sekolah"] = (array) json_decode($out["link_kepala_sekolah"]);
		}
		
		if (isset($out["detail_tgl_kegiatan"]) && !empty($out["detail_tgl_kegiatan"])) {
			$out["detail_tgl_kegiatan"] = (array) json_decode($out["detail_tgl_kegiatan"]);
		}
		
		if (isset($out["komponen"]) && !empty($out["komponen"])) {
			$out["komponen"] = (array) json_decode($out["komponen"]);
		}
		
		if (isset($out["kategori"]) && !empty($out["kategori"])) {
			$out["kategori"] = (array) json_decode($out["kategori"]);
		}
		
		return $out;
	}
	
	public function getKegiatanByIds ($ids) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan");
		$this->new_db->where_in("id", $ids);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[$row["id"]] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getKegiatanByIdsAndYear ($ids, $year) {
		$out = array();

		// Make new connection to db transaction
		$db_tahun = $this->group_prefix . $year; 
		$this->db_trans = $this->load->database($db_tahun, true);
		
		$this->db_trans->select("*");
		$this->db_trans->from("kegiatan");
		$this->db_trans->where_in("id", $ids);
		
		$query = $this->db_trans->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[$row["id"]] = $row;
			}
		}
		
		$this->db_trans->reset_query();
		
		return $out;
	}
	
	public function getKegiatanBySpjKegiatanId ($id = "0") {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan");
		$this->new_db->where("spj_kegiatan", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[$row["id"]] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function save ($data, $id = 0) {
		if (empty($id)) {
			$data['kode'] = $this->utility->kode_kegiatan();
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
            $data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->insert("kegiatan", $data);
			$id = $this->new_db->insert_id();
			
			$this->new_db->reset_query();
			
			$kode = array();
			$kode['kode'] = $data['kode'].$id;
			
			$this->new_db->where("id", $id);
			$this->new_db->update("kegiatan", $kode);
			$this->new_db->reset_query();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			if (isset($_SESSION["user"]["id"])) {
				$data['diubah_oleh'] = $_SESSION["user"]["id"];	
			}
			
			$this->new_db->where("id", $id);
			$this->new_db->update("kegiatan", $data);
			$this->new_db->reset_query();
		}
		
		return $id;
	}
	
	
	public function searchKegiatanByName ($term) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan");
		$this->new_db->like('nama', $term, 'both');
		$this->new_db->order_by('nama', 'ASC');
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function turnOffForm () {
		$out = array();
		
		$date = new DateTime("now");
		$CURDATE = $date->format('Y-m-d');
		
		$dataForm = array(
			"link_peserta_on",
			"link_panitia_on",
			"link_moderator_on",
			"link_pp_on",
			"link_fasil_on",
			"link_instruktur_on",
			"link_pengawas_on",
			"link_kepala_sekolah_on"
		);
		
		$where = "DATE(tgl_selesai_kegiatan) < '".$CURDATE."' AND (";
		
		$formOn = "";
		
		foreach ($dataForm as $fm) {
			if (!empty($formOn)) {
				$formOn .= " OR ";
			}
			
			$formOn .= $fm."=1";
		}
		
		$where .= $formOn.")";
		
		$this->new_db->select("*");
		$this->new_db->from("kegiatan");
		$this->new_db->where($where);
		$this->new_db->order_by('id', 'ASC');
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getLaporanKegiatanSatatus ($id) {
		$out = array();
		
		$this->new_db->select("progress_laporan");
		$this->new_db->from("kegiatan");
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

	public function saveLaporanKegiatanStatus ($data, $id = 0) {
		if (!empty($id)) {
			$this->new_db->where("id", $id);
			$this->new_db->update("kegiatan", $data);
			$this->new_db->reset_query();
		}
		
		return $id;
	}
}