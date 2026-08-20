<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spj_model extends CI_Model{
	
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$db_tahun = $this->group_prefix . $_SESSION['tahun_anggaran']; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function getAll () {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getById ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		$this->new_db->where("id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByPenugasanId ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		$this->new_db->where("penugasan_id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByKegiatanId ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		$this->new_db->where("kegiatan_id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getByPenugasanIdKegiatanId ($penugasanId, $kegiatanId) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		$this->new_db->where("penugasan_id", $penugasanId);
		$this->new_db->where("kegiatan_id", $kegiatanId);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByKegiatanIdKomponen ($kegiatanId, $komponen) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		$this->new_db->where("kegiatan_id", $kegiatanId);
		$this->new_db->where("komponen", $komponen);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByPenugasanIdKegiatanIdKomponen ($penugasanId, $kegiatanId, $komponen) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		$this->new_db->where("penugasan_id", $penugasanId);
		$this->new_db->where("kegiatan_id", $kegiatanId);
		$this->new_db->where("komponen", $komponen);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				if (isset($row["based"]) && !empty($row["based"])) {
					$row["based"] = json_decode($row["based"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemById ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemsByIds ($ids) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where_in('id', $ids);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemBySpjId ($id, $orderBy = false) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spj_id", $id);

		if ($orderBy) {
			$this->new_db->order_by($orderBy, 'ASC');
		}
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemBySpjIdAndSpbyId ($spjId, $spbyId) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spj_id", $spjId);
		$this->new_db->where("spby_id", $spbyId);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemByDaftarHadirId ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("daftar_hadir", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getPossibleSpbyItemsBySpjIdAndSpbyId ($spjId, $spbyId, $tglSpby) {
		
		$tglSpby = str_replace(array("/"), array("-"), $tglSpby);
		$tglSpby = date("Y-m-d", strtotime($tglSpby));
		
		$out = array();
		
		/*$this->new_db->select("spj_item.*");
		$this->new_db->from("spj_item");
		$this->new_db->join('penugasan_item', 'penugasan_item.spj_item_id = spj_item.id', 'left');
		
		$where = "spj_item.spj_id='".$spjId."' AND (spj_item.spby_id='".$spbyId."' OR spj_item.spby_id='0') AND penugasan_item.status = '5' AND spj_item.tgl_kuitansi <= '".$tglSpby."'";
		$this->new_db->where($where);*/
		
		
		$this->new_db->select("spj_item.*");
		$this->new_db->from("spj_item");
		
		$where = "spj_item.spj_id='".$spjId."' AND (spj_item.spby_id='".$spbyId."' OR spj_item.spby_id='0') AND spj_item.check_laporan = '1' AND spj_item.tgl_kuitansi <= '".$tglSpby."'";
		$this->new_db->where($where);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getPossibleSpbyHonorItemsBySpjIdAndSpbyId ($spjId, $spbyId, $tglSpby) {
		
		$tglSpby = str_replace(array("/"), array("-"), $tglSpby);
		$tglSpby = date("Y-m-d", strtotime($tglSpby));
		
		$out = array();
		
		/*$this->new_db->select("spj_item.*");
		$this->new_db->from("spj_item");
		$this->new_db->join('penugasan_item', 'penugasan_item.spj_item_id = spj_item.id', 'left');
		
		$where = "spj_item.spj_id='".$spjId."' AND (spj_item.spby_id='".$spbyId."' OR spj_item.spby_id='0') AND penugasan_item.status = '5' AND spj_item.tgl_kuitansi <= '".$tglSpby."'";
		$this->new_db->where($where);*/
		
		
		$this->new_db->select("spj_item.*");
		$this->new_db->from("spj_item");
		
		$where = "spj_item.spj_id='".$spjId."' AND (spj_item.spby_id_honor='".$spbyId."' OR spj_item.spby_id_honor='0') AND spj_item.check_laporan = '1' AND spj_item.tgl_kuitansi <= '".$tglSpby."'";
		$this->new_db->where($where);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getPaidSpbyItemsBySpjIdAndSpbyId ($spjId, $spbyId) {
		$out = array();
		
		$this->new_db->select("spj_item.*");
		$this->new_db->from("spj_item");
		
		//$this->new_db->join('penugasan_item', 'penugasan_item.spj_item_id = spj_item.id', 'left');
		//$where = "spj_item.spj_id='".$spjId."' AND spj_item.spby_id='".$spbyId."' AND penugasan_item.status = '6'";
		
		$where = "spj_item.spj_id='".$spjId."' AND spj_item.spby_id='".$spbyId."' AND spj_item.paid = '1'";
		$this->new_db->where($where);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getPaidSpbyHonorItemsBySpjIdAndSpbyId ($spjId, $spbyId) {
		$out = array();
		
		$this->new_db->select("spj_item.*");
		$this->new_db->from("spj_item");
		
		//$this->new_db->join('penugasan_item', 'penugasan_item.spj_item_id = spj_item.id', 'left');
		//$where = "spj_item.spj_id='".$spjId."' AND spj_item.spby_id='".$spbyId."' AND penugasan_item.status = '6'";
		
		$where = "spj_item.spj_id='".$spjId."' AND spj_item.spby_id_honor='".$spbyId."' AND spj_item.paid_honor = '1'";
		$this->new_db->where($where);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemsBySpjIdTerm ($id, $term) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spj_id", $id);
		$this->new_db->like('nama', $term);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemBySpbyId ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spby_id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemBySpbyIdHonor ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spby_id_honor", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemByPenugasanItemId ($id) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("penugasan_item_id", $id);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemBySpjIdKtp ($id, $ktp) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spj_id", $id);
		$this->new_db->where("ktp", $ktp);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getItemBySpjIdPaid ($spjId, $paid = 1) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where("spj_id", $spjId);
		$this->new_db->where("paid", $paid);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (!empty($row["tgl_tugas"])) {
					$row["tgl_tugas"] = json_decode($row["tgl_tugas"], true);
				}
				
				$out[] = $row;
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
			
			$this->new_db->insert("spj", $data);
			$id = $this->new_db->insert_id();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->where("id", $id);
			$this->new_db->update("spj", $data);
		}
		
		return $id;
	}
	
	public function saveItem ($data, $id = 0) {
		if (empty($id)) {
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
            $data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['dibuat_oleh'] = $_SESSION["user"]["id"];
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			if (isset($data["spj_id"]) && !empty($data["spj_id"])) {
				$this->new_db->insert("spj_item", $data);
				$id = $this->new_db->insert_id();	
			}
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			$data['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->where("id", $id);
			$this->new_db->update("spj_item", $data);
		}
		
		return $id;
	}
	
	public function updateItemBySpjId ($data, $spj_id) {
		$data['diubah_tgl'] = date("Y-m-d H:i:s");
		$data['diubah_oleh'] = $_SESSION["user"]["id"];

		$this->new_db->where("spj_id", $spj_id);
		$this->new_db->update("spj_item", $data);
	}
	
	public function getGroupByPenugasanAndKegiatan ($current, $rowCount, $search, $sort) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		if ($rowCount) {
			$this->new_db->limit($rowCount, (($current * $rowCount) - $rowCount));	
		}
		
		if (!empty($search)) {
			$this->new_db->like('nama', $search);
		}
		
		$this->new_db->group_by(array("penugasan_id", "kegiatan_id"));
		$this->new_db->order_by('dibuat_tgl', 'DESC');
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function countGroupByPenugasanAndKegiatan ($current, $rowCount, $search, $sort) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		if ($rowCount) {
			$this->new_db->limit($rowCount, (($current * $rowCount) - $rowCount));	
		}
		
		if (!empty($search)) {
			$this->new_db->like('nama', $search);
		}
		
		$this->new_db->group_by(array("penugasan_id", "kegiatan_id"));
		$this->new_db->order_by('dibuat_tgl', 'DESC');
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		
		$query = $this->new_db->get();
		
		return $query->num_rows();
	}
	
	public function getGroupByPenugasan ($current, $rowCount, $search, $sort) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		if ($rowCount) {
			$this->new_db->limit($rowCount, (($current * $rowCount) - $rowCount));	
		}
		
		if (!empty($search)) {
			$this->new_db->like('nama', $search);
		}
		
		$this->new_db->group_by(array("penugasan_id"));
		$this->new_db->order_by('dibuat_tgl', 'DESC');
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		$this->new_db->where('kegiatan_id','0');
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function countGroupByPenugasan ($current, $rowCount, $search, $sort) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		if ($rowCount) {
			$this->new_db->limit($rowCount, (($current * $rowCount) - $rowCount));	
		}
		
		if (!empty($search)) {
			$this->new_db->like('nama', $search);
		}
		
		$this->new_db->group_by(array("penugasan_id"));
		$this->new_db->order_by('dibuat_tgl', 'DESC');
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		$this->new_db->where('kegiatan_id','0');
		
		$query = $this->new_db->get();
		
		return $query->num_rows();
	}
	
	public function getGroupByKegiatan ($current, $rowCount, $search, $sort, $dibuat_oleh = 0) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		if ($rowCount) {
			$this->new_db->limit($rowCount, (($current * $rowCount) - $rowCount));	
		}
		
		if (!empty($search)) {
			$this->new_db->like('nama', $search);
		}
		
		$this->new_db->group_by(array("kegiatan_id"));
		$this->new_db->order_by('dibuat_tgl', 'DESC');
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		$this->new_db->where('penugasan_id','0');
		
		if (!empty($dibuat_oleh)) {
			$this->new_db->where('dibuat_oleh',$dibuat_oleh);
		}
		
		$query = $this->new_db->get();
		
		$this->new_db->reset_query();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				
				if (isset($row["dipa"]) && !empty($row["dipa"])) {
					$row["dipa"] = json_decode($row["dipa"], true);
				}
				
				
				$this->new_db->select("*");
				$this->new_db->from("spj");
				$this->new_db->where('kegiatan_id',$row["kegiatan_id"]);
				
				$querySPJ = $this->new_db->get();
				
				if($querySPJ->num_rows() > 0) {
					$komponen = array();
					$countItem = array();
					
					$countItem["item_total"] = 0;
					$countItem["item_dibayar"] = 0;
					
					foreach ($querySPJ->result_array() as $rowSPJ) {
						$item = array();
						$item["item_total"] = $rowSPJ["item_total"];
						$item["item_dibayar"] = $rowSPJ["item_dibayar"];
						
						$countItem["item_total"] += $item["item_total"];
						$countItem["item_dibayar"] += $item["item_dibayar"];
						
						$komponen[$rowSPJ["komponen"]] = $item;
					}
					
					$row["komponen"] = $komponen;
					$row["item_total"] = $countItem["item_total"];
					$row["item_dibayar"] = $countItem["item_dibayar"];
				}
				
				$out[] = $row;
			}
		}
		
		return $out;
	}
	
	public function countGroupByKegiatan ($current, $rowCount, $search, $sort, $dibuat_oleh = 0) {
		$out = array();
		
		$this->new_db->select("*");
		$this->new_db->from("spj");
		
		if ($rowCount) {
			$this->new_db->limit($rowCount, (($current * $rowCount) - $rowCount));	
		}
		
		if (!empty($search)) {
			$this->new_db->like('nama', $search);
		}
		
		$this->new_db->group_by(array("kegiatan_id"));
		$this->new_db->order_by('dibuat_tgl', 'DESC');
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		$this->new_db->where('penugasan_id','0');
		
		if (!empty($dibuat_oleh)) {
			$this->new_db->where('dibuat_oleh',$dibuat_oleh);
		}
		
		$query = $this->new_db->get();
		
		return $query->num_rows();
	}
	
	public function searchPossibleKegiatan ($term) {
		$out = array();
		$ids = array();
		
		// GET ALL REGISTERED KEGIATAN
		$this->new_db->select("id, penugasan_id, kegiatan_id");
		$this->new_db->from("spj");
		$this->new_db->group_by(array("kegiatan_id"));
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$ids[] = $row["kegiatan_id"];
			}
		}
		
		$this->new_db->reset_query();
		
		
		// GET NAMA KEGIATAN
		$this->new_db->select("*");
		$this->new_db->from("kegiatan");
		$this->new_db->like('nama', $term, 'both');
		$this->new_db->order_by('nama', 'ASC');
		$this->new_db->where('YEAR(tgl_selesai_kegiatan)', $_SESSION["tahun_anggaran"]);
		
		if (!empty($ids)) {
			$this->new_db->where_not_in('id', $ids);
		}
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function searchPossiblePenugasan ($term = "") {
		$out = array();
		$ids = array();
		
		// GET ALL REGISTERED KEGIATAN
		$this->new_db->select("id, penugasan_id, kegiatan_id");
		$this->new_db->from("spj");
		$this->new_db->group_by(array("penugasan_id"));
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$ids[] = $row["penugasan_id"];
			}
		}
		
		$this->new_db->reset_query();
		
		
		// GET NAMA KEGIATAN
		$this->new_db->select("*");
		$this->new_db->from("penugasan");
		
		if (!empty($term)) {
			$this->new_db->like('nama', $term, 'both');
		}
		
		$this->new_db->order_by('nama', 'ASC');
		
		if (!empty($ids)) {
			$this->new_db->where_not_in('id', $ids);
		}
		
		$this->new_db->where('YEAR(dibuat_tgl)', $_SESSION["tahun_anggaran"]);
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function delete ($id) {
		$out = array();
		$out["error"] = true;
		
		if (!empty($id)) {
			$this->new_db->where('id', $id);
			$this->new_db->delete('spj');
			$out["error"] = false;
		}
		
		return $out;
	}
	
	public function deleteItem ($id) {
		$out = array();
		$out["error"] = true;
		
		if (!empty($id)) {
			$this->new_db->where('id', $id);
			$this->new_db->delete('spj_item');
			$out["error"] = false;
		}
		
		return $out;
	}
	
	public function deleteItemBySpjId ($id) {
		$out = array();
		$out["error"] = true;
		
		if (!empty($id)) {
			$this->new_db->where('spj_id', $id);
			$this->new_db->delete('spj_item');
			$out["error"] = false;
		}
		
		return $out;
	}
	
	public function getItemDaftarKegiatan ($spjId, $spjDaftarHadirId = 0) {
		// GET NAMA KEGIATAN
		$this->new_db->select("*");
		$this->new_db->from("spj_item");
		$this->new_db->where('spj_id = "'.$spjId.'" AND (daftar_hadir = "'.$spjDaftarHadirId.'" OR daftar_hadir = "0")');
		
		$this->new_db->order_by('kategori', 'ASC');
		
		$query = $this->new_db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out[] = $row;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}
	
	public function saveDaftarHadir ($data, $id = false) {
		$items = array();
		
		if (isset($data["df_item"]) && !empty($data["df_item"])) {
			foreach ($data["df_item"] as $boo) {
				if (!empty($boo)) {
					$items[] = $boo;
				}
			}
		}
		
		if (empty($id)) {
			$foo = array();
			$foo["spj_id"] = $data["spj_id"];
			$foo["nama_daftar_hadir"] = $data["nama_daftar_hadir"];
			$foo["nama_penerimaan_atk"] = $data["nama_penerimaan_atk"];
			$foo["jumlah"] = count($items);
			$foo["ketua_panitia"] = $data["ketua_panitia"];
			$foo["spasi_daftar_hadir"] = $data["spasi_daftar_hadir"];
			$foo["spasi_penerimaan_atk"] = $data["spasi_penerimaan_atk"];
			
			$foo['dibuat_tgl']  = date("Y-m-d H:i:s");
            $foo['diubah_tgl'] = date("Y-m-d H:i:s");
			$foo['dibuat_oleh'] = $_SESSION["user"]["id"];
			$foo['diubah_oleh'] = $_SESSION["user"]["id"];
			
			if (isset($foo["spj_id"]) && !empty($foo["spj_id"])) {
				$this->new_db->insert("spj_daftar_hadir", $foo);
				$id = $this->new_db->insert_id();
			}
		}
		else {
			$foo = array();
			$foo["spj_id"] = $data["spj_id"];
			$foo["nama_daftar_hadir"] = $data["nama_daftar_hadir"];
			$foo["nama_penerimaan_atk"] = $data["nama_penerimaan_atk"];
			$foo["jumlah"] = count($items);
			$foo["ketua_panitia"] = $data["ketua_panitia"];
			$foo["spasi_daftar_hadir"] = $data["spasi_daftar_hadir"];
			$foo["spasi_penerimaan_atk"] = $data["spasi_penerimaan_atk"];
			
			$foo['diubah_tgl'] = date("Y-m-d H:i:s");
			$foo['diubah_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->where("id", $id);
			$this->new_db->update("spj_daftar_hadir", $foo);
		}
		
		if (!empty($id) && !empty($items)) {
			foreach ($items as $item) {
				$foo = array();
				$foo["daftar_hadir"] = $id;
				
				$this->saveItem($foo, $item);
			}
		}
		
		return $id;
	}
}