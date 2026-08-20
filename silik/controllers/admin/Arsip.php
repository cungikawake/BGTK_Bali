<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("arsip_model");
	}
	
	public function index () {
		$this->auth->login();
		
		redirect(base_url("/admin/arsip/me"));
	}

	public function me () {
		$this->auth->login();

		$data = array();
		
		$this->load->view('backend/arsip/me',$data);
	}
	
	public function list () {
		$this->auth->login();
		
		$data = array();
		
		$this->load->view('backend/arsip/lists',$data);
	}

	public function save_kearsipan () {

		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan arsip";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$no_kabinet = $_POST["no_kabinet"];
			$no_laci = $_POST["no_laci"];
			$no_folder = $_POST["no_folder"];
			$status = $_POST["status"];
			$dipinjam_oleh = $_POST["dipinjam_oleh"];
			$keterangan_arsip = $_POST["keterangan_arsip"];

			if ($status == "Dipinjam") {
				$no_kabinet = "";
				$no_laci = "";
				$no_folder = "";
				$keterangan_arsip = "";
			}

			if ($status == "Diarsipkan") {
				$dipinjam_oleh = "";
				$keterangan_arsip = "";
			}

			if ($status == "Ditolak") {
				$dipinjam_oleh = "";
				$no_kabinet = "";
				$no_laci = "";
				$no_folder = "";
			}

			$arsip = $this->arsip_model->getById($id);

			$data = array();
			$data["arsip_id"] = $id;
			$data["no_kabinet"] = $no_kabinet;
			$data["no_laci"] = $no_laci;
			$data["no_folder"] = $no_folder;
			$data["status"] = $status; 
			$data["dipinjam_oleh"] = $dipinjam_oleh;
			
			$this->arsip_model->save_status($data);

			if (isset($_POST["uraian"]) && !empty($_POST["uraian"])) {
				$data = array();
				$data["uraian"] = json_encode($_POST["uraian"]);
				$data["keterangan_arsip"] = $keterangan_arsip;

				$this->arsip_model->save_arsip($data, $id);

				if ($status == "Diarsipkan" && isset($arsip["kegiatan_id"]) && !empty($arsip["kegiatan_id"])) {
					$this->arsip_model->updateStatusLaporan("10", $arsip["kegiatan_id"]);
				}
				else if ($status == "Divalidasi" && isset($arsip["kegiatan_id"]) && !empty($arsip["kegiatan_id"])) {
					$this->arsip_model->updateStatusLaporan("9", $arsip["kegiatan_id"]);
				}
				else if ($status == "Dipinjam" && isset($arsip["kegiatan_id"]) && !empty($arsip["kegiatan_id"])) {
					$this->arsip_model->updateStatusLaporan("11", $arsip["kegiatan_id"]);
				}
			}			
		}

		print json_encode($out);
		exit();
	}

	public function save_arsip () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan arsip";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$nama = $_POST["nama"];
			$program = $_POST["program"];
			$jenis_berkas = $_POST["jenis_berkas"];
			$akses = $_POST["akses"];
			$keterangan = $_POST["keterangan"];

			$uraian = array();

			$item_nama = $_POST["item"];
			$item_tgl = $_POST["tgl"];
			$item_perkembangan = $_POST["perkembangan"];
			$item_jumlah = $_POST["jumlah"];
			$item_satuan = $_POST["satuan"];

			if (!empty($item_nama)) {
				foreach ($item_nama as $i => $itemNama) {
					$item = array();

					$item["item"] = $itemNama;
					$item["tgl"] = $item_tgl[$i];
					$item["perkembangan"] = $item_perkembangan[$i];
					$item["jumlah"] = $item_jumlah[$i];
					$item["satuan"] = $item_satuan[$i];

					if (isset($_POST["valid"]) && !empty($_POST["valid"])) {
						$item["valid"] = $_POST["valid"][$i];
					}
					else {
						$item["valid"] = "0";
					}

					$uraian[] = $item;
				}
			}

			$data = array();
			$data["nama"] = $nama;
			$data["program"] = $program;
			$data["jenis_berkas"] = $jenis_berkas;
			$data["akses"] = $akses;

			$data["keterangan"] = $keterangan;
			$data["uraian"] = json_encode($uraian);

			if (isset($_POST["status"]) && !empty($_POST["status"])) {
				$data["status"] = $_POST["status"];
			}

			$this->arsip_model->save_arsip($data, $id);
		}

		print json_encode($out);
		exit();
	}

	public function load_sejarah_arsip () {
		$data = array();

		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];

			$users = $this->user_model->getUser();

			$this->load->model("biodata_model");
			$pegawai = $this->biodata_model->getBiodataByPegawaiBalai();

			$sejarah = $this->arsip_model->getSejarahByArsipId($id);
			
			if (isset($sejarah) && !empty($sejarah)) {
				foreach ($sejarah as $se => $so) {
					$dibuatNama = $pegawai[$users[$so["dibuat_oleh"]]["sync_biodata"]]["nama"];

					if (!empty($so["dipinjam_oleh"])) {
						$dipinjamNama = $pegawai[$so["dipinjam_oleh"]]["nama"];
					}
					else {
						$dipinjamNama = "-";
					}

					$sejarah[$se]["dibuat_nama"] = $dibuatNama;
					$sejarah[$se]["dipinjam_nama"] = $dipinjamNama;
				}
			}

			$data["sejarah"] = $sejarah;
		}

		print $this->load->view('backend/arsip/table_sejarah',$data, true);
	}

	public function jilid () {
		$this->auth->login();
		
		$data = array();
		
		$this->load->view('backend/arsip/laporan_kegiatan_jilid',$data);
	}

	public function terima_laporan_kegiatan_jilid () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil terima laporan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$this->load->model("arsip_model");

			$kegiatanId = $_POST["id"];
			$this->arsip_model->updateStatusLaporan("7", $kegiatanId);
		}

		if (isset($_POST["kode"]) && !empty($_POST["kode"])) {
			$this->load->model("arsip_model");

			$kode = $_POST["kode"];
			$this->arsip_model->updateTerimaArsipLaporanJilid($kode);
		}

		print json_encode($out);
		exit();
	}

	public function save_arsip_jilid () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$approval = $_POST["approval"];

			$this->load->model("arsip_model");
			$this->load->model("kegiatan_model");

			$arsip = $this->arsip_model->getById($id);

			if (!empty($arsip)) {
				$data = array();
				$dataKegiatan = array();

				if ($approval == "selesai") {
					$data["tgl_laporan_selesai_jilid"] = date("Y-m-d H:i:s");
					$data["petugas_laporan_selesai_jilid"] = $_SESSION["user"]["id"];
					$data["status"] = "Selesai Jilid";

					$dataKegiatan["progress_laporan"] = 8;

					$out["msg"] = "Berhasil selesai jilid laporan!";
				}

				$this->arsip_model->save_arsip($data, $id);

				if (!empty($arsip["kegiatan_id"])) {
					$this->kegiatan_model->saveLaporanKegiatanStatus($dataKegiatan, $arsip["kegiatan_id"]);
				}
			}
		}

		print json_encode($out);
		exit();
	}

	public function load_data_arsip () {
		$this->auth->login();

		$data = array();
		$data["arsip"] = array();
		
		if (isset($_POST["kode"]) && !empty($_POST["kode"])) {
			$this->load->model("arsip_model");
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

				$data["pembuat_arsip"] = $pembuat;
			}
		}

		print json_encode($data);
		exit();
	}

	public function tambah_arsip () {
		$this->auth->login();

		$out = array();
		$out["error"] = false;
		$out["close_modal"] = true;
		$out["reload_table"] = true;

		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$data = array();
			$data["arsip_id"] = $id;
			$data["status"] = "Divalidasi Arsiparis";
			
			$this->arsip_model->save_status($data);


			$data = array();
			$data["tgl_laporan_diterima_arsip"] = date("Y-m-d H:i:s");

			$this->arsip_model->save_arsip($data, $id);
		}

		print json_encode($out);
		exit();
	}

	public function label ($id = false) {
		$data = array();
		$arsip = $this->arsip_model->getById($id);

		if (!empty($arsip)) {

			// GET DATA SATKER
			$this->load->model("pengaturan_model");
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
			$satker = array();
			
			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$satker[$foo["sistem"]] = $foo["value"];
				}
			}

			// GET DATA PEGAWAI BALAI
			$this->load->model("user_model");
			$user = $this->user_model->getUserById($arsip["dibuat_oleh"]);
			$this->load->model("biodata_model");
			$pencipta = $this->biodata_model->getBiodataById($user["sync_biodata"]);

			// QR CODE
			$kode = $arsip["kode"]."/".$satker["kode_satker"]."/".$_SESSION["tahun_anggaran"];
			$this->load->library('qr_code');
			$qr_code = $this->qr_code->create(400, base_url("/admin/arsip/informasi_arsip/".str_replace("/", "_", $kode)));
			
			$data["kode_arsip"] = $kode;
			$data["satker"] = $satker;
			$data["arsip"] = $arsip;
			$data["user"] = $user;
			$data["pencipta"] = $pencipta;
			$data["qr_code"] = $qr_code;

			$html = $this->load->view('template/label_arsip',$data, true);

			$this->mpdf->create($html,"label_arsip",false);
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}

	public function getJsonArsip () {
		$this->auth->login();
		
		$out = array();
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$out = $this->arsip_model->getById($id);
		}
		
		print json_encode($out);
	}
}
