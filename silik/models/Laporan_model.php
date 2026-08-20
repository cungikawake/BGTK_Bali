<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_model extends CI_Model{
	
    protected $group_prefix = 'transaction_';
	protected $new_db = '';

    function __construct() { 
		$db_tahun = $this->group_prefix . $_SESSION['tahun_anggaran']; 
		$this->new_db = $this->load->database($db_tahun, true);
		 
    }
	
	public function getLaporanPenugasan ($ktps, $search = null) {
		$out = array();

		$select = array(
			"ktp",
			"nama",
			"tgl_mulai_tugas",
			"tgl_selesai_tugas",
			"pesawat_berangkat",
			"pesawat_pulang",
			"taksi_berangkat",
			"taksi_pulang",
			"transport",
			"transport_lainnya",
			"uang_harian",
			"penginapan",
		);
		
		$this->new_db->select($select);
		$this->new_db->from("spj_item");
		$this->new_db->where_in("ktp",$ktps);
		$this->new_db->where('paid', "1");

		$fieldSearch = array(
			"nama"
		);

		if (!empty($search)) {
			foreach ($fieldSearch as $kel => $sel) {
				if ($kel) {
					$this->new_db->or_like($sel, $search);
				}
				else {
					$this->new_db->like($sel, $search);
				}
			}
		}

		$query = $this->new_db->get();

		//print $this->new_db->last_query();
		
		if($query->num_rows() > 0) {
			$lookup = array();

			foreach ($query->result_array() as $row) {
				if (!isset($lookup[$row["ktp"]])) {
					$lookup[$row["ktp"]] = array();
				}

				$row["lama_tugas"] = $this->utility->lama_tugas($row["tgl_mulai_tugas"], $row["tgl_selesai_tugas"]);

				$row["lama_menginap"] = 0;
				if ($row["lama_tugas"] > 1) {
					$row["lama_menginap"] = $row["lama_tugas"] - 1;
				}

				$lookup[$row["ktp"]][] = $row; 
			}

			if (!empty($lookup)) {
				foreach ($lookup as $ktp => $loop) {
					if (!empty($loop)) {
						foreach ($loop as $lp) {
							if (!isset($out[$ktp])) {
								$out[$ktp] = array();
								$out[$ktp]["ktp"] = $ktp;
								$out[$ktp]["total_tiket_berangkat"] = 0;
								$out[$ktp]["total_tiket_pulang"] = 0;
								$out[$ktp]["total_taksi_berangkat"] = 0;
								$out[$ktp]["total_taksi_pulang"] = 0;
								$out[$ktp]["total_transport"] = 0;
								$out[$ktp]["total_transport_lainnya"] = 0;
								$out[$ktp]["total_uang_harian"] = 0;
								$out[$ktp]["total_uang_penginapan"] = 0;
								$out[$ktp]["total_tugas"] = count($lookup[$ktp]);
								$out[$ktp]["total_hari"] = 0;
								$out[$ktp]["total_tiket"] = 0;
								$out[$ktp]["total_taksi"] = 0;
								$out[$ktp]["total_pembayaran"] = 0;
							}

							$out[$ktp]["total_tiket_berangkat"] = $out[$ktp]["total_tiket_berangkat"] + $lp["pesawat_berangkat"];
							$out[$ktp]["total_tiket_pulang"] = $out[$ktp]["total_tiket_pulang"] + $lp["pesawat_pulang"];
							$out[$ktp]["total_taksi_berangkat"] = $out[$ktp]["total_taksi_berangkat"] + $lp["taksi_berangkat"];
							$out[$ktp]["total_taksi_pulang"] = $out[$ktp]["total_taksi_pulang"] + $lp["taksi_pulang"];
							$out[$ktp]["total_transport"] = $out[$ktp]["total_transport"] + $lp["transport"];
							$out[$ktp]["total_transport_lainnya"] = $out[$ktp]["total_transport_lainnya"] + $lp["transport_lainnya"];
							$out[$ktp]["total_uang_harian"] = $out[$ktp]["total_uang_harian"] + ($lp["uang_harian"]*$lp["lama_tugas"]);
							$out[$ktp]["total_hari"] = $out[$ktp]["total_hari"]  + $lp["lama_tugas"];

							$total_menginap = 0;

							if ($lp["lama_menginap"] > 0) {
								$total_menginap = $lp["penginapan"] * $lp["lama_menginap"];
							}

							$out[$ktp]["total_uang_penginapan"] = $out[$ktp]["total_uang_penginapan"] + $total_menginap;
						}
					}
				}

				if (!empty($out)) {
					foreach ($out as $ktp => $total) {
						$out[$ktp]["total_tiket"] = $total["total_tiket_berangkat"] + $total["total_tiket_pulang"];
						$out[$ktp]["total_taksi"] = $total["total_taksi_berangkat"] + $total["total_taksi_pulang"];
						$out[$ktp]["total_pembayaran"] = $total["total_tiket_berangkat"] + $total["total_tiket_pulang"] + $total["total_taksi_berangkat"] + $total["total_taksi_pulang"] + $total["total_transport"] + $total["total_transport_lainnya"] + $total["total_uang_penginapan"] + $total["total_uang_harian"];
					}
				}

				// SORT DATA
				usort($out, function($a, $b) {
					return $b['total_pembayaran'] <=> $a['total_pembayaran'];
				});

				if (!empty($out)) {
					$lookup = array();

					foreach ($out as $doit) {
						$lookup[$doit["ktp"]] = $doit;
					}

					$out = $lookup;
				}
			}
		}
		
		$this->new_db->reset_query();
		
		return $out;
	}

	public function updateStatusLaporanKegiatan ($kegiatanId, $status) {
		$out = array();
		$out["error"] = false;
		 
		$update = array();
		$update['progress_laporan'] = $status;
		$update['diubah_tgl']  = date("Y-m-d H:i:s");
		$update['diubah_oleh'] = $_SESSION["user"]["id"];
		
		$this->new_db->where("id", $kegiatanId);
		$this->new_db->update("kegiatan", $update);
		$this->new_db->reset_query();

		return $out;
	}
}