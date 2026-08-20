<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spi extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		/*$data = array();
		$data["new_tiket"] = $this->tiket_model->getNew();
		$data["proses_tiket"] = $this->tiket_model->getByUserId($user["id"],"1","1");

		$this->load->vars($data);*/
		$this->load->model("arsip_model");
	}
	
	public function index () {
		$this->auth->login();
		
		redirect(base_url("/admin/spi/laporan_kegiatan"));
	}
	
	public function laporan_kegiatan () {
		$this->auth->login();
		$data = array();
		
		$this->load->view('backend/spi/laporan_kegiatan', $data);
	}

	public function loadDataArsip () {
		$this->auth->login();

		$data = array();
		$data["arsip"] = array();
		$data["kegiatan"] = array();
		$data["pembuat_laporan"] = array();
		
		if (isset($_POST["kode"]) && !empty($_POST["kode"])) {
			$arsip = $this->arsip_model->getByKode($_POST["kode"]);

			$data["arsip"] = $arsip;

			if (isset($arsip["kegiatan_id"]) && !empty($arsip["kegiatan_id"])) {
				$this->load->model("kegiatan_model");

				$kegiatan = $this->kegiatan_model->getKegiatanById($arsip["kegiatan_id"]);

				$kegiatan["tgl_mulai_kegiatan"] = date("d/m/Y", strtotime($kegiatan["tgl_mulai_kegiatan"]));
				$kegiatan["tgl_selesai_kegiatan"] = date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));

				$data["kegiatan"] = $kegiatan;
			}

			if (isset($arsip["dibuat_oleh"]) && !empty($arsip["dibuat_oleh"])) {
				$this->load->model("user_model");

				$pembuat = $this->user_model->getUserById($arsip["dibuat_oleh"]);

				$data["pembuat_laporan"] = $pembuat;
			}
			
		}

		print json_encode($data);
		exit();
	}

	public function load_data_arsip () {
		$this->auth->login();

		$data = array();
		$data["arsip"] = array();
		$data["kegiatan"] = array();
		$data["pembuat_laporan"] = array();
		
		if (isset($_POST["kode"]) && !empty($_POST["kode"])) {
			$this->load->model("arsip_model");
			$arsip = $this->arsip_model->getByKode($_POST["kode"]);

			$data["arsip"] = $arsip;
			$data["kegiatan"] = array();
			$data["pembuat_laporan"] = array();
			$data["petugas_terima_spi"] = array();
			$data["petugas_setuju_spi"] = array();
			$data["petugas_terima_kepala"] = array();
			$data["petugas_setuju_kepala"] = array();

			if (isset($arsip["kegiatan_id"]) && !empty($arsip["kegiatan_id"])) {
				$this->load->model("kegiatan_model");

				$kegiatan = $this->kegiatan_model->getKegiatanById($arsip["kegiatan_id"]);

				$kegiatan["tgl_mulai_kegiatan"] = date("d/m/Y", strtotime($kegiatan["tgl_mulai_kegiatan"]));
				$kegiatan["tgl_selesai_kegiatan"] = date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));

				$data["kegiatan"] = $kegiatan;
			}

			if (isset($arsip["dibuat_oleh"]) && !empty($arsip["dibuat_oleh"])) {
				$this->load->model("user_model");

				$pembuat = $this->user_model->getUserById($arsip["dibuat_oleh"]);

				$data["pembuat_laporan"] = $pembuat;
			}

			if (isset($arsip["petugas_laporan_diterima_spi"]) && !empty($arsip["petugas_laporan_diterima_spi"])) {
				$this->load->model("user_model");

				$petugas_terima_spi = $this->user_model->getUserById($arsip["petugas_laporan_diterima_spi"]);

				$data["petugas_terima_spi"] = $petugas_terima_spi;
			}

			if (isset($arsip["petugas_laporan_disetujui_spi"]) && !empty($arsip["petugas_laporan_disetujui_spi"])) {
				$this->load->model("user_model");

				$petugas_setuju_spi = $this->user_model->getUserById($arsip["petugas_laporan_disetujui_spi"]);

				$data["petugas_setuju_spi"] = $petugas_setuju_spi;
			}

			if (isset($arsip["petugas_laporan_diterima_kepala"]) && !empty($arsip["petugas_laporan_diterima_kepala"])) {
				$this->load->model("user_model");

				$petugas_terima_kepala = $this->user_model->getUserById($arsip["petugas_laporan_diterima_kepala"]);

				$data["petugas_terima_kepala"] = $petugas_terima_kepala;
			}

			if (isset($arsip["petugas_laporan_disetujui_kepala"]) && !empty($arsip["petugas_laporan_disetujui_kepala"])) {
				$this->load->model("user_model");

				$petugas_setuju_kepala = $this->user_model->getUserById($arsip["petugas_laporan_disetujui_kepala"]);

				$data["petugas_setuju_kepala"] = $petugas_setuju_kepala;
			}

			if (isset($arsip["petugas_laporan_diterima_jilid"]) && !empty($arsip["petugas_laporan_diterima_jilid"])) {
				$this->load->model("user_model");

				$petugas_terima_jilid = $this->user_model->getUserById($arsip["petugas_laporan_diterima_jilid"]);

				$data["petugas_terima_jilid"] = $petugas_terima_jilid;
			}

			if (isset($arsip["petugas_laporan_selesai_jilid"]) && !empty($arsip["petugas_laporan_selesai_jilid"])) {
				$this->load->model("user_model");

				$petugas_selesai_jilid = $this->user_model->getUserById($arsip["petugas_laporan_selesai_jilid"]);

				$data["petugas_selesai_jilid"] = $petugas_selesai_jilid;
			}
			
		}

		print json_encode($data);
		exit();
	}

	public function terima_laporan_kegiatan () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan kegiatan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$kegiatanId = $_POST["id"];
			$this->arsip_model->updateStatusLaporan("1", $kegiatanId);
		}

		if (isset($_POST["kode"]) && !empty($_POST["kode"])) {
			$kode = $_POST["kode"];
			$this->arsip_model->updateTerimaArsipLaporan($kode);
		}

		print json_encode($out);
		exit();
	}

	public function save_arsip () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$approval = $_POST["approval"];
			$keterangan_spi = $_POST["keterangan_spi"];

			$uraian = $_POST["uraian"];

			$this->load->model("arsip_model");
			$this->load->model("kegiatan_model");

			$arsip = $this->arsip_model->getById($id);

			if (!empty($arsip)) {
				$data = array();
				$dataKegiatan = array();

				$uraianArsip = json_decode($arsip["uraian"], true);

				if (!empty($uraianArsip)) {
					foreach ($uraianArsip as $k => $val) {
						$data["uraian"][$k] = $val;
						$data["uraian"][$k]["valid"] = $uraian[$k]["valid"];
					}

					$data["uraian"] = json_encode($data["uraian"]);
				}

				if ($approval == "setuju") {
					$data["tgl_laporan_disetujui_spi"] = date("Y-m-d H:i:s");
					$data["petugas_laporan_disetujui_spi"] = $_SESSION["user"]["id"];
					$data['status'] = "Disetujui SPI";

					$dataKegiatan["progress_laporan"] = 2;

					$out["msg"] = "Berhasil menyetujui laporan!";
				}
				else if ($approval == "tolak") {
					$data["tgl_laporan_ditolak_spi"] = date("Y-m-d H:i:s");
					$data["petugas_laporan_ditolak_spi"] = $_SESSION["user"]["id"];
					$data['status'] = "Ditolak SPI";

					$dataKegiatan["progress_laporan"] = 3;

					$out["msg"] = "Berhasil menolak laporan!";
				}

				$data["keterangan_spi"] = $keterangan_spi;

				$this->arsip_model->save_arsip($data, $id);

				if (!empty($arsip["kegiatan_id"])) {
					$this->kegiatan_model->saveLaporanKegiatanStatus($dataKegiatan, $arsip["kegiatan_id"]);
				}
			}
		}

		print json_encode($out);
		exit();
	}


	public function kepala_laporan_kegiatan () {
		$this->auth->login();
		$data = array();
		
		$this->load->view('backend/spi/kepala_laporan_kegiatan', $data);
	}

	public function terima_laporan_kegiatan_kepala () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan kegiatan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$kegiatanId = $_POST["id"];
			$this->arsip_model->updateStatusLaporan("4", $kegiatanId);
		}

		if (isset($_POST["kode"]) && !empty($_POST["kode"])) {
			$kode = $_POST["kode"];
			$this->arsip_model->updateTerimaArsipLaporanKepala($kode);
		}

		print json_encode($out);
		exit();
	}

	public function save_arsip_kepala () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$approval = $_POST["approval"];
			$keterangan_kepala = $_POST["keterangan_kepala"];

			$this->load->model("arsip_model");
			$this->load->model("kegiatan_model");

			$arsip = $this->arsip_model->getById($id);

			if (!empty($arsip)) {
				$data = array();
				$dataKegiatan = array();

				if ($approval == "setuju") {
					$data["tgl_laporan_disetujui_kepala"] = date("Y-m-d H:i:s");
					$data["petugas_laporan_disetujui_kepala"] = $_SESSION["user"]["id"];
					$data["status"] = "Disetujui Kepala";

					$dataKegiatan["progress_laporan"] = 5;

					$out["msg"] = "Berhasil menyetujui laporan!";
				}
				else if ($approval == "tolak") {
					$data["tgl_laporan_ditolak_kepala"] = date("Y-m-d H:i:s");
					$data["petugas_laporan_ditolak_kepala"] = $_SESSION["user"]["id"];
					$data["status"] = "Ditolak Kepala";

					$dataKegiatan["progress_laporan"] = 6;

					$out["msg"] = "Berhasil menolak laporan!";
				}

				$data["keterangan_kepala"] = $keterangan_kepala;

				$this->arsip_model->save_arsip($data, $id);

				if (!empty($arsip["kegiatan_id"])) {
					$this->kegiatan_model->saveLaporanKegiatanStatus($dataKegiatan, $arsip["kegiatan_id"]);
				}
			}
		}

		print json_encode($out);
		exit();
	}

}
