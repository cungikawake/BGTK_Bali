<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absensi_model extends CI_Model {

	protected $group_prefix = 'transaction_';
	protected $new_db = '';

    public function __construct() {
        $tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
		$db_tahun = $this->group_prefix . $tahun_anggaran; 
		$this->new_db = $this->load->database($db_tahun, true);
    }
	
	public function getUserByIdDate($userId, $date) {
		$out = array("id" => 0);
		
		$where = array();
		$where["user_id"] = $userId;
		$where["tanggal"] = $date;
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('absensi');
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

	public function getUserApelByIdDate($userId, $date) {
		$out = array();
		
		$where = array();
		$where["user_id"] = $userId;
		$where["tanggal"] = $date;
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('absensi_apel');
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

	public function saveAbsenApel ($data, $id = null) {
		$update = array();
		$update["user_id"] = $data["user_id"];
		$update["latitude"] = $data["latitude"];
		$update["longitude"] = $data["longitude"];
		$update["tanggal"] = date("Y-m-d");
		$update["waktu"] = $data["waktu"];
		$update["absen"] = $data["absen"];
		$update["tipe"] = $data["tipe"];
		$update["keterangan"] = $data["keterangan"];

		$waktuMasuk = strtotime($update["tanggal"]." ".$update["waktu"]);
		$absenMasuk = strtotime($update["tanggal"]." ".$update["absen"]);

		if ($absenMasuk > $waktuMasuk) {
			$terlambat = $absenMasuk - $waktuMasuk;

			$jam   = floor($terlambat / (60 * 60));
			$menit = floor( ($terlambat - ( $jam * (60 * 60) )) / 60);
			$detik = $terlambat % 60;

			if ($jam < 10) {
				$jam = "0".$jam;
			}

			if ($menit < 10) {
				$menit = "0".$menit;
			}

			if ($detik < 10) {
				$detik = "0".$detik;
			}

			$update["terlambat"] = $jam.":".$menit.":".$detik;
		}
		else {
			$update["terlambat"] = "00:00:00";
		}

		if ($data["tidak_hadir"]) {
			$update["terlambat"] = "00:00:00";
			$update["absen"] = "00:00:00";
		}

		if (isset($id) && !empty($id)) {
			$this->new_db->where("id", $id);
			$this->new_db->update("absensi_apel", $update);
		}
		else {
			$update["dibuat_tgl"] = date("Y-m-d H:i:s");
			$this->new_db->insert("absensi_apel", $update);
			$id = $this->new_db->insert_id();
		}

		$this->new_db->reset_query();
		
		return $id;
	}

	public function apelTepatWaktu($tglApel) {
		$out = array();
		
		$where = array();
		$where["tanggal"] = $tglApel;
		$where["absen !="] = "00:00:00";
		$where["terlambat"] = "00:00:00";
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('absensi_apel');
		$this->new_db->order_by('id', 'asc');
		
		$absen = $this->new_db->get();
		
		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function apelTerlambat($tglApel) {
		$out = array();
		
		$where = array();
		$where["tanggal"] = $tglApel;
		$where["absen !="] = "00:00:00";
		$where["terlambat !="] = "00:00:00";
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('absensi_apel');
		$this->new_db->order_by('id', 'asc');
		
		$absen = $this->new_db->get();
		
		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function apelTidakHadir($tglApel) {
		$out = array();
		
		$where = array();
		$where["tanggal"] = $tglApel;
		$where["absen"] = "00:00:00";
		$where["terlambat"] = "00:00:00";
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('absensi_apel');
		$this->new_db->order_by('id', 'asc');
		
		$absen = $this->new_db->get();
		
		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function countAllApel () {
		$this->new_db->select('tanggal');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('DATE(tanggal)');

		$where = array();
		$where["tipe"] = "apel";
		$this->new_db->where($where);

		$absen = $this->new_db->get();

		return $absen->num_rows();
	}

	public function countIkutApel () {
		$out = array();

		$this->new_db->select('absensi_apel.user_id, COUNT(absensi_apel.id) AS ikut_apel');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('user_id');

		$where = array();
		$where["tipe"] = "apel";
		$this->new_db->where($where);

		$absen = $this->new_db->get();

		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();

		return $out;
	}

	public function countApelTepatWaktu () {
		$out = array();

		$where = array();
		$where["absen !="] = "00:00:00";
		$where["terlambat"] = "00:00:00";
		$where["tipe"] = "apel";
		
		$this->new_db->where($where);

		$this->new_db->select('absensi_apel.user_id, COUNT(absensi_apel.id) AS apel_tepat_waktu');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('user_id');

		$absen = $this->new_db->get();

		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();

		return $out;
	}

	public function countApelTerlambat () {
		$out = array();

		$where = array();
		$where["absen !="] = "00:00:00";
		$where["terlambat !="] = "00:00:00";
		$where["tipe"] = "apel";
		
		$this->new_db->where($where);

		$this->new_db->select('absensi_apel.user_id, COUNT(absensi_apel.id) AS apel_terlambat');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('user_id');

		$absen = $this->new_db->get();

		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();

		return $out;
	}



	public function countAllSenam () {
		$this->new_db->select('tanggal');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('DATE(tanggal)');

		$where = array();
		$where["tipe"] = "senam";
		$this->new_db->where($where);

		$absen = $this->new_db->get();

		return $absen->num_rows();
	}

	public function countIkutSenam () {
		$out = array();

		$this->new_db->select('absensi_apel.user_id, COUNT(absensi_apel.id) AS ikut_senam');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('user_id');

		$where = array();
		$where["tipe"] = "senam";
		$this->new_db->where($where);

		$absen = $this->new_db->get();

		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();

		return $out;
	}

	public function countSenamTepatWaktu () {
		$out = array();

		$where = array();
		$where["absen !="] = "00:00:00";
		$where["terlambat"] = "00:00:00";
		$where["tipe"] = "senam";
		
		$this->new_db->where($where);

		$this->new_db->select('absensi_apel.user_id, COUNT(absensi_apel.id) AS senam_tepat_waktu');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('user_id');

		$absen = $this->new_db->get();

		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();

		return $out;
	}

	public function countSenamTerlambat () {
		$out = array();

		$where = array();
		$where["absen !="] = "00:00:00";
		$where["terlambat !="] = "00:00:00";
		$where["tipe"] = "senam";
		
		$this->new_db->where($where);

		$this->new_db->select('absensi_apel.user_id, COUNT(absensi_apel.id) AS senam_terlambat');
		$this->new_db->from('absensi_apel');
		$this->new_db->group_by('user_id');

		$absen = $this->new_db->get();

		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
			}
		}
		
		$this->new_db->reset_query();

		return $out;
	}


	public function getUsersByDate ($date) {
		$out = array();
		
		$where = array();
		$where["tanggal"] = $date;
		
		$this->new_db->where($where);
		
		$this->new_db->select('*');
		$this->new_db->from('absensi');
		$this->new_db->order_by('id', 'asc');
		
		$absen = $this->new_db->get();
		$lookupUserId = array();
		
		if($absen->num_rows() > 0) {
			foreach ($absen->result_array() as $key => $foo) {
				$out[$foo["user_id"]] = $foo;
				$lookupUserId[] = $foo["user_id"];
			}
		}
		
		$this->new_db->reset_query();

		if (!empty($lookupUserId)) {
			$this->db->where_in("id", $lookupUserId);
			$this->db->select('*');
			$this->db->from('user');
			$this->db->order_by('id', 'asc');

			$pegawai = $this->db->get();

			if($pegawai->num_rows() > 0) {
				foreach ($pegawai->result_array() as $key => $foo) {
					$out[$foo["id"]]["nama"] = $foo["nama"];
				}
			}
		}
		
		return $out;
	}

	public function absen_masuk ($data) {
		$update = array();
		$update["user_id"] = $data["user_id"];
		$update["latitude"] = $data["latitude"];
		$update["longitude"] = $data["longitude"];
		$update["tanggal"] = date("Y-m-d");
		$update["waktu_masuk"] = $data["waktu_masuk"];
		$update["absen_masuk"] = $data["absen_masuk"];

		$waktuMasuk = strtotime($update["tanggal"]." ".$update["waktu_masuk"]);
		$absenMasuk = strtotime($update["tanggal"]." ".$update["absen_masuk"]);

		if ($absenMasuk > $waktuMasuk) {
			$terlambat = $absenMasuk - $waktuMasuk;

			$jam   = floor($terlambat / (60 * 60));
			$menit = floor( ($terlambat - ( $jam * (60 * 60) )) / 60);
			$detik = $terlambat % 60;

			if ($jam < 10) {
				$jam = "0".$jam;
			}

			if ($menit < 10) {
				$menit = "0".$menit;
			}

			if ($detik < 10) {
				$detik = "0".$detik;
			}

			$update["terlambat"] = $jam.":".$menit.":".$detik;
		}
		else {
			$update["terlambat"] = "00:00:00";
		}

		if (isset($data["id"]) && !empty($data["id"])) {
			$id = $data["id"];

			$this->new_db->where("id", $id);
			$this->new_db->update("absensi", $update);
		}
		else {
			$this->new_db->insert("absensi", $update);
			$id = $this->new_db->insert_id();
		}

		$this->new_db->reset_query();
		
		return $id;
	}

	public function absen_keluar ($data) {
		$update = array();
		$update["user_id"] = $data["user_id"];
		$update["tanggal"] = date("Y-m-d");
		$update["waktu_keluar"] = $data["waktu_keluar"];
		$update["absen_keluar"] = date("H:i:s");
		$update["keterangan"] = $data["keterangan"];

		$waktuKeluar = strtotime($update["tanggal"]." ".$update["waktu_keluar"]);
		$absenKeluar = strtotime($update["tanggal"]." ".$update["absen_keluar"]);

		if ($absenKeluar < $waktuKeluar) {
			$pulangCepat = $waktuKeluar - $absenKeluar;

			$jam   = floor($pulangCepat / (60 * 60));
			$menit = floor( ($pulangCepat - ( $jam * (60 * 60) )) / 60);
			$detik = $pulangCepat % 60;

			if ($jam < 10) {
				$jam = "0".$jam;
			}

			if ($menit < 10) {
				$menit = "0".$menit;
			}

			if ($detik < 10) {
				$detik = "0".$detik;
			}

			$update["pulang_cepat"] = $jam.":".$menit.":".$detik;
		}
		else {
			$update["pulang_cepat"] = "00:00:00";
		}

		if (isset($data["id"]) && !empty($data["id"])) {
			$id = $data["id"];

			$this->new_db->where("id", $id);
			$this->new_db->update("absensi", $update);
		}
		else {
			$this->new_db->insert("absensi", $update);
			$id = $this->new_db->insert_id();
		}

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

			$update = array();
			$update["kode"] = $data["program"]."-".$this->utility->penomoran($id);

			$this->new_db->where("id", $id);
			$this->new_db->update("arsip", $update);

			$this->new_db->reset_query();

			$status = array();
			$status["arsip_id"] = $id;
			$status['status'] = "Baru";
			$status['dibuat_tgl']  = date("Y-m-d H:i:s");
			$status['dibuat_oleh'] = $_SESSION["user"]["id"];
			
			$this->new_db->insert("arsip_status", $status);
			$id = $this->new_db->insert_id();
			
			$this->new_db->reset_query();
		}
		else {
			$data['diubah_tgl']  = date("Y-m-d H:i:s");
			$data['diubah_oleh'] = $_SESSION["user"]["id"];

			$this->new_db->where("id", $id);
			$this->new_db->update("arsip", $data);
		}

		
		
		return $id;
	}
}
?>