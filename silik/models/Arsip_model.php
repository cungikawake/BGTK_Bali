<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Arsip_model extends CI_Model {

	protected $group_prefix = 'transaction_';
	protected $new_db = '';

    public function __construct() {
        $tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
    }
	
	public function getStatus($arsipId) {
		$out = array();
		
		$where = array();
		$where["arsip_id"] = $arsipId;
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('arsip_status');
		$this->new_db->order_by('id', 'desc');
		$this->new_db->limit(1);
		
		$arsip = $this->new_db->get();
		
		if($arsip->num_rows() > 0) {
			foreach ($arsip->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getSejarahByArsipId($id) {
		$out = array();
		
		$where = array();
		$where["arsip_id"] = $id;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('arsip_status');		
		$this->new_db->order_by('id', 'asc');
		
		$arsip = $this->new_db->get();
		
		if($arsip->num_rows() > 0) {
			foreach ($arsip->result_array() as $key => $foo) {
				$out[] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function getById($id) {
		$out = array();
		
		$where = array();
		$where["id"] = $id;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('arsip');		
		$this->new_db->order_by('id', 'asc');
		
		$arsip = $this->new_db->get();
		
		if($arsip->num_rows() > 0) {
			foreach ($arsip->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getByKode($kode) {
		$out = array();
		
		$where = array();
		$where["kode"] = $kode;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('arsip');		
		$this->new_db->order_by('id', 'asc');
		
		$arsip = $this->new_db->get();
		
		if($arsip->num_rows() > 0) {
			foreach ($arsip->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function getByKegiatanId($kegiatan_id) {
		$out = array();
		
		$where = array();
		$where["kegiatan_id"] = $kegiatan_id;
		
		if (!empty($where)) {
			$this->new_db->where($where);
		}
		
		$this->new_db->select('*');
		$this->new_db->from('arsip');		
		$this->new_db->order_by('id', 'asc');
		
		$arsip = $this->new_db->get();
		
		if($arsip->num_rows() > 0) {
			foreach ($arsip->result_array() as $key => $foo) {
				$out = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function save_status ($data) {
		$data['dibuat_tgl']  = date("Y-m-d H:i:s");

		if (!isset($data['dibuat_oleh'])) {
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
		}
		
		$this->new_db->insert("arsip_status", $data);
		$id = $this->new_db->insert_id();
		
		$this->new_db->reset_query();


		$update = array();

		if (isset($data['no_kabinet'])) {
			$update['no_kabinet'] = $data['no_kabinet'];
		}

		if (isset($data['no_laci'])) {
			$update['no_laci'] = $data['no_laci'];
		}

		if (isset($data['no_folder'])) {
			$update['no_folder'] = $data['no_folder'];
		}

		if (isset($data['status'])) {
			$update['status'] = $data['status'];
		}

		if (isset($data['dipinjam_oleh'])) {
			$update['dipinjam_oleh'] = $data['dipinjam_oleh'];
		}
		
		$update['diubah_tgl']  = date("Y-m-d H:i:s");
		$update['diubah_oleh'] = $data['dibuat_oleh'];
		
		$this->new_db->where("id", $data["arsip_id"]);
		$this->new_db->update("arsip", $update);
		$this->new_db->reset_query();
		
		return $id;
	}

	public function save_arsip ($data, $id = 0) {

		if (empty($id)) {
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
			$data['diubah_tgl']  = date("Y-m-d H:i:s");
			$data['status'] = "Baru";

			if (!isset($data['dibuat_oleh'])) {
				$data['dibuat_oleh'] = $_SESSION["user"]["id"];
			}

			if (!isset($data['diubah_oleh'])) {
				$data['diubah_oleh'] = $_SESSION["user"]["id"];
			}

			$this->new_db->insert("arsip", $data);
			$id = $this->new_db->insert_id();

			$this->new_db->reset_query();

			// Update Kode Arsip
			$update = array();
			$update["kode"] = $data["program"]."-".$this->utility->penomoran($id);

			$this->new_db->where("id", $id);
			$this->new_db->update("arsip", $update);

			$this->new_db->reset_query();

			// Create Status Arsip
			$dataStatus = array();
			$dataStatus['arsip_id'] = $id;
			$dataStatus['no_kabinet'] = "";
			$dataStatus['no_laci'] = "";
			$dataStatus['no_folder'] = "";
			$dataStatus['status'] = "Baru";
			$dataStatus['dipinjam_oleh'] = "";
			$dataStatus['dibuat_oleh'] = $data['dibuat_oleh'];
			$dataStatus['dibuat_tgl'] = $data['dibuat_tgl'];

			$this->save_status($dataStatus);

		}
		else {
			$data['diubah_tgl']  = date("Y-m-d H:i:s");
			$data['diubah_oleh'] = $_SESSION["user"]["id"];

			$this->new_db->where("id", $id);
			$this->new_db->update("arsip", $data);
		}

		
		
		return $id;
	}

	public function updateStatusLaporan ($status = 0, $id = 0) {

		if (!empty($id)) {
			$data = array();
			$data['progress_laporan'] = $status;
			
			$this->new_db->where("id", $id);
			$this->new_db->update("kegiatan", $data);
			$this->new_db->reset_query();
		}
		
		return $id;
	}

	public function updateTerimaArsipLaporan ($kode) {

		if (!empty($kode)) {
			$data = array();
			$data['tgl_laporan_diterima_spi'] = date("Y-m-d H:i:s");
			$data['petugas_laporan_diterima_spi'] = $_SESSION["user"]["id"];
			$data['status'] = "Divalidasi SPI";
			
			$this->new_db->where("kode", $kode);
			$this->new_db->update("arsip", $data);
			$this->new_db->reset_query();
		}
		
		return $kode;
	}

	public function updateTerimaArsipLaporanKepala ($kode) {

		if (!empty($kode)) {
			$data = array();
			$data['tgl_laporan_diterima_kepala'] = date("Y-m-d H:i:s");
			$data['petugas_laporan_diterima_kepala'] = $_SESSION["user"]["id"];
			$data['status'] = "Divalidasi Kepala";
			
			$this->new_db->where("kode", $kode);
			$this->new_db->update("arsip", $data);
			$this->new_db->reset_query();
		}
		
		return $kode;
	}

	public function updateTerimaArsipLaporanJilid ($kode) {

		if (!empty($kode)) {
			$data = array();
			$data['tgl_laporan_diterima_jilid'] = date("Y-m-d H:i:s");
			$data['petugas_laporan_diterima_jilid'] = $_SESSION["user"]["id"];
			$data['status'] = "Proses Jilid";
			
			$this->new_db->where("kode", $kode);
			$this->new_db->update("arsip", $data);
			$this->new_db->reset_query();
		}
		
		return $kode;
	}
	
}
?>