<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_pelatihan_model extends CI_Model {
    
	protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$db_tahun = $this->group_prefix . $_SESSION['tahun_anggaran']; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }

	public function countPelatihan () {
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');

		$this->new_db->select(array("id","kode","tgl_selesai_kegiatan"));
		$this->new_db->where("nama_pelatihan !=","");
		$this->new_db->group_by("nama_pelatihan");
		$this->new_db->from('kegiatan');
		
		$count = $this->new_db->count_all_results();
		 
		return $count;
	}

	public function countPelatihanGraph () {
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');

		$this->new_db->select(array("COUNT(id) AS jumlah_kegiatan","MONTH(tgl_selesai_kegiatan) AS bulan_pelatihan"));
		$this->new_db->where("nama_pelatihan !=","");
		$this->new_db->group_by(array("nama_pelatihan", "MONTH(tgl_selesai_kegiatan)"));
		$this->new_db->from('kegiatan');
		
		$query = $this->new_db->get();

		$foo = array();

		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (isset($foo[$row["bulan_pelatihan"]])) {
					$foo[$row["bulan_pelatihan"]] += 1;
				}
				else {
					$foo[$row["bulan_pelatihan"]] = 1;
				}
			}
		}

		$months = array(
			1 => "Jan",
			2 => "Feb",
			3 => "Mar",
			4 => "Apr",
			5 => "Mei",
			6 => "Jun",
			7 => "Jul",
			8 => "Agu",
			9 => "Sep",
			10 => "Okt",
			11 => "Nov",
			12 => "Des"
		);

		$pelatihan = array();
		$pelatihan["month"] = array();
		$pelatihan["triwulan"] = array();
		$pelatihan["semester"] = array();

		foreach ($months as $monthKey => $monthVal) {
			$val = 0;

			if (isset($foo[$monthKey])) {
				$val = $foo[$monthKey];
			}

			$pelatihan["month"][$monthVal] = $val;
		}


		$pelatihan["triwulan"]["TW I"] = 0;
		$pelatihan["triwulan"]["TW II"] = 0;
		$pelatihan["triwulan"]["TW III"] = 0;
		$pelatihan["triwulan"]["TW IV"] = 0;

		foreach ($months as $monthKey => $monthVal) {
			$val = 0;

			if (isset($foo[$monthKey])) {
				$val = $foo[$monthKey];
			}

			if ($monthKey == 1 || $monthKey == 2 || $monthKey == 3) {
				$pelatihan["triwulan"]["TW I"] += $val;
			}

			if ($monthKey == 4 || $monthKey == 5 || $monthKey == 6) {
				$pelatihan["triwulan"]["TW II"] += $val;
			}

			if ($monthKey == 7 || $monthKey == 8 || $monthKey == 9) {
				$pelatihan["triwulan"]["TW III"] += $val;
			}

			if ($monthKey == 10 || $monthKey == 11 || $monthKey == 12) {
				$pelatihan["triwulan"]["TW IV"] += $val;
			}
		}



		$pelatihan["semester"]["Semester I"] = 0;
		$pelatihan["semester"]["Semester II"] = 0;

		foreach ($months as $monthKey => $monthVal) {
			$val = 0;

			if (isset($foo[$monthKey])) {
				$val = $foo[$monthKey];
			}

			if ($monthKey == 1 || $monthKey == 2 || $monthKey == 3 || $monthKey == 4 || $monthKey == 5 || $monthKey == 6) {
				$pelatihan["semester"]["Semester I"] += $val;
			}

			if ($monthKey == 7 || $monthKey == 8 || $monthKey == 9 || $monthKey == 10 || $monthKey == 11 || $monthKey == 12) {
				$pelatihan["semester"]["Semester II"] += $val;
			}
		}
		 
		return $pelatihan;
	}

	public function countPesertaPelatihan () {
		$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');

		$this->new_db->select('id');
		$this->new_db->where("nama_pelatihan !=","");
		$this->new_db->from('kegiatan');
		
		$query = $this->new_db->get();

		$kegiatanIds = array();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$kegiatanIds[] = $row["id"];
			}
		}

		$this->new_db->reset_query();

		$this->new_db->select('id');
		$this->new_db->where_in('kegiatan_id', $kegiatanIds);
		$this->new_db->from('kegiatan_peserta');
		
		$count = $this->new_db->count_all_results();

		return $count;
	}
}
?>