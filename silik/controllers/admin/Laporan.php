<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	
	function __construct() {
		parent::__construct();		
		$this->load->model("biodata_model");
		$this->load->model("laporan_model");
	}
	
	public function index () {
		$this->auth->login();
		
		redirect(base_url("/admin/laporan/penugasan"));
	}
	
	public function penugasan () {
		
		$this->load->view('backend/laporan/penugasan_list',$data);
	}

	public function data_penugasan () {
		$data = array();
		$data["current"] = $_POST["current"];
		$data["rowCount"] = $_POST["rowCount"];
		$data["search"] = $_POST["searchPhrase"];
		$data["rows"] = array();
		$data["total"] = 0;

		if (isset($_POST["current"]) && !empty($_POST["current"])) {
			$pegawai = $this->biodata_model->getBiodataByPegawaiBalai(1);

			$lookupKtp = array();

			if (!empty($pegawai)) {
				$dataPegawai = array();

				foreach ($pegawai as $peg) {
					$lookupKtp[] = $peg["ktp"];
					$dataPegawai[$peg["ktp"]] = $peg;
				}

				$penugasan = $this->laporan_model->getLaporanPenugasan($lookupKtp, $data["search"]);

				$i = 1;

				foreach ($penugasan as $ktp => $tugas) {
					$row = $tugas;
					$row["nama"] = $dataPegawai[$ktp]["nama"];
					$row["id"] = $i;

					$data["rows"][] = $row;
					$i++;
				}

				$data["total"] = count($data["rows"]);
			}
		}

		print json_encode($data);
	}

	public function export_penugasan () {
		$data = array();
		$exportData = array(array("Data not found"));

		$pegawai = $this->biodata_model->getBiodataByPegawaiBalai(1);

		$lookupKtp = array();

		if (!empty($pegawai)) {
			$dataPegawai = array();

			foreach ($pegawai as $peg) {
				$lookupKtp[] = $peg["ktp"];
				$dataPegawai[$peg["ktp"]] = $peg;
			}

			$penugasan = $this->laporan_model->getLaporanPenugasan($lookupKtp, $data["search"]);

			$i = 1;

			foreach ($penugasan as $ktp => $tugas) {
				$row = $tugas;
				$row["nama"] = $dataPegawai[$ktp]["nama"];
				$row["id"] = $i;

				$data[] = $row;
				$i++;
			}

			if (!empty($data)) {
				$keyData = array(
					"nama" => "Nama",
					"total_tugas" => "Total Tugas (Kali)",
					"total_hari" => "Total Hari",
					"total_tiket_berangkat" => "Total Tiket Berangkat",
					"total_tiket_pulang" => "Total Tiket Pulang",
					"total_tiket" => "Total Tiket",
					"total_taksi_berangkat" => "Total Taksi Berangkat",
					"total_taksi_pulang" => "Total Taksi Pulang",
					"total_taksi" => "Total Taksi",
					"total_transport" => "Total Transport",
					"total_transport_lainnya" => "Total Transport Lainnya",
					"total_uang_harian" => "Total Uang Harian",
					"total_uang_penginapan" => "Total Penginapan",
					"total_pembayaran" => "Total Pembayaran"
				);
				
				$exportData = array();
				
				$exp = array();
				$exp[] = "No";
				
				foreach ($keyData as $export) {
					$exp[] = $export;
				}
				
				$exportData[] = $exp;
				
				
				
				$i = 1;
				foreach ($data as $bios) {
					$exp = array();
					$exp[] = $i;
					
					foreach ($keyData as $dooKey => $doo) {
						foreach ($bios as $bioKey => $bio) {
							if ($bioKey == $dooKey) {
								$exp[] = $bio;
							}
						}
					}
					
					$exportData[] = $exp;
					$i++;
				}
			}
		}

		$this->excel->create($exportData, "Export_laporan_penugasan");
	}

	public function kegiatan () {
		$data = array();
				
		$this->load->view('backend/laporan/kegiatan_list',$data);
	}

	public function update_status_laporan ($id = null, $status = null) {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Gagal Menerima Laporan!";

		if (isset($_POST["kegiatan_id"]) && !empty($_POST["kegiatan_id"]) && isset($_POST["status"]) && !empty($_POST["status"])) {
			$id = $_POST["kegiatan_id"];
			$status = $_POST["status"];

			$this->laporan_model->updateStatusLaporanKegiatan($id, $status);

			$out = array();
			$out["error"] = false;
			$out["msg"] = "Berhasil Menerima Laporan!";
		}

		print json_encode($out);
	}
}
