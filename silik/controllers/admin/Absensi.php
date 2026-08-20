<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("absensi_model");
	}
	
	public function index () {
		$this->auth->login();
		
		$data = array();
		$data["absen"] = $this->absensi_model->getUserByIdDate($_SESSION["user"]["id"], date("Y-m-d"));

		$this->load->model("pengaturan_model");
		$data["latitude"] = $this->pengaturan_model->getPengaturanBySistem('latitude');
		$data["longitude"] = $this->pengaturan_model->getPengaturanBySistem('longitude');

		$data["pegawai"] = $this->absensi_model->getUsersByDate(date("Y-m-d"));

		$this->load->view('backend/absensi/absensi',$data);
	}

	public function apel () {
		$this->auth->login("/admin/absensi/apel");

		$data = array();
		$data["absen"] = $this->absensi_model->getUserApelByIdDate($_SESSION["user"]["id"], date("Y-m-d"));

		if ((date('l') === 'Monday' || date('l') === 'Friday') && empty($data["absen"])) {
			// Absen Screen Senin & Jumat
			$this->load->model("pengaturan_model");
			$data["latitude"] = $this->pengaturan_model->getPengaturanBySistem('latitude');
			$data["longitude"] = $this->pengaturan_model->getPengaturanBySistem('longitude');
			$data["apel_mulai"] = $this->pengaturan_model->getPengaturanBySistem('apel_mulai');
			$data["apel_selesai"] = $this->pengaturan_model->getPengaturanBySistem('apel_selesai');

			$this->load->view('backend/absensi/absensi_apel2',$data);
		}
		else {
			// Laporan Absensi
			$totalApel = $this->absensi_model->countAllApel();
			$ikutApel = $this->absensi_model->countIkutApel();
			$apelTepatWaktu = $this->absensi_model->countApelTepatWaktu();
			$apelTerlambat = $this->absensi_model->countApelTerlambat();

			$totalSenam = $this->absensi_model->countAllSenam();
			$ikutSenam = $this->absensi_model->countIkutSenam();
			$senamTepatWaktu = $this->absensi_model->countSenamTepatWaktu();
			$senamTerlambat = $this->absensi_model->countSenamTerlambat();

			$data = array();
			$data["users"] = $this->user_model->getUser();

			$this->load->model("biodata_model");
			$biodatas = $this->biodata_model->getBiodataByPegawaiBalai();

			if (!empty($data["users"])) {
				foreach ($data["users"] as $key => $user) {
					if (isset($biodatas[$user["sync_biodata"]])) {
						$data["users"][$key]["nama_lengkap"] = $biodatas[$user["sync_biodata"]]["nama"];
						
						$data["users"][$key]["total_apel"] = $totalApel;
						$data["users"][$key]["ikut_apel"] = 0;
						$data["users"][$key]["pct_ikut_apel"] = 0;
						$data["users"][$key]["tepat_waktu"] = 0;
						$data["users"][$key]["pct_tepat_waktu"] = 0;
						$data["users"][$key]["terlambat"] = 0;
						$data["users"][$key]["pct_terlambat"] = 0;
						$data["users"][$key]["tidak_hadir"] = $totalApel;
						$data["users"][$key]["pct_tidak_hadir"] = round($totalApel/$totalApel*100, 0);

						if (isset($ikutApel[$key])) {
							$data["users"][$key]["ikut_apel"] = $ikutApel[$key]["ikut_apel"];
							$data["users"][$key]["pct_ikut_apel"] = round($ikutApel[$key]["ikut_apel"]/$totalApel*100, 0);

							$data["users"][$key]["tidak_hadir"] = $totalApel - $ikutApel[$key]["ikut_apel"];
							$data["users"][$key]["pct_tidak_hadir"] = round($data["users"][$key]["tidak_hadir"]/$totalApel*100, 0);
						}

						if (isset($apelTepatWaktu[$key])) {
							$data["users"][$key]["tepat_waktu"] = $apelTepatWaktu[$key]["apel_tepat_waktu"];
							$data["users"][$key]["pct_tepat_waktu"] = round($apelTepatWaktu[$key]["apel_tepat_waktu"]/$data["users"][$key]["ikut_apel"]*100, 0);
						}

						if (isset($apelTerlambat[$key])) {
							$data["users"][$key]["terlambat"] = $apelTerlambat[$key]["apel_terlambat"];
							$data["users"][$key]["pct_terlambat"] = round($apelTerlambat[$key]["apel_terlambat"]/$data["users"][$key]["ikut_apel"]*100, 0);
						}
						
						
						$data["users"][$key]["total_senam"] = $totalSenam;
						$data["users"][$key]["ikut_senam"] = 0;
						$data["users"][$key]["pct_ikut_senam"] = 0;
						$data["users"][$key]["tepat_waktu_senam"] = 0;
						$data["users"][$key]["pct_tepat_waktu_senam"] = 0;
						$data["users"][$key]["terlambat_senam"] = 0;
						$data["users"][$key]["pct_terlambat_senam"] = 0;
						$data["users"][$key]["tidak_hadir_senam"] = $totalSenam;
						$data["users"][$key]["pct_tidak_hadir_senam"] = 100;

						if ($totalSenam > 0) {
							$data["users"][$key]["pct_tidak_hadir_senam"] = round($totalSenam/$totalSenam*100, 0);
						}

						
						if (isset($ikutSenam[$key])) {
							$data["users"][$key]["ikut_senam"] = $ikutSenam[$key]["ikut_senam"];
							$data["users"][$key]["pct_ikut_senam"] = round($ikutSenam[$key]["ikut_senam"]/$totalSenam*100, 0);

							$data["users"][$key]["tidak_hadir_senam"] = $totalSenam - $ikutSenam[$key]["ikut_senam"];
							$data["users"][$key]["pct_tidak_hadir_senam"] = round($data["users"][$key]["tidak_hadir"]/$totalSenam*100, 0);
						}

						if (isset($senamTepatWaktu[$key])) {
							$data["users"][$key]["tepat_waktu_senam"] = $senamTepatWaktu[$key]["senam_tepat_waktu"];
							$data["users"][$key]["pct_tepat_waktu_senam"] = round($senamTepatWaktu[$key]["senam_tepat_waktu"]/$data["users"][$key]["ikut_senam"]*100, 0);
						}

						if (isset($senamTerlambat[$key])) {
							$data["users"][$key]["terlambat_senam"] = $senamTerlambat[$key]["senam_terlambat"];
							$data["users"][$key]["pct_terlambat_senam"] = round($senamTerlambat[$key]["senam_terlambat"]/$data["users"][$key]["ikut_senam"]*100, 0);
						}

					}
				}

				$ikutApel = array_column($data["users"], 'ikut_apel');
				$tepatWaktu = array_column($data["users"], 'tepat_waktu');
				$noUrut = array_column($data["users"], 'no_urut');

				array_multisort(
					$ikutApel, SORT_DESC,
					$tepatWaktu, SORT_DESC,
					$noUrut, SORT_ASC,
					$data["users"]
				);
			}

			$this->load->view('backend/absensi/absensi_apel',$data);
		}
	}

	public function absen_apel () {
		$this->auth->login("/admin/absensi/apel/");
		
		$out = array();
		$out["error"] = false;

		if (isset($_POST) && !empty($_POST)) {
			$this->load->model("pengaturan_model");

			$waktuMasuk = $this->pengaturan_model->getPengaturanBySistem('apel_selesai');
			$absen = $this->absensi_model->getUserApelByIdDate($_SESSION["user"]["id"], date("Y-m-d"));
			
			$id = 0;

			if (isset($absen["id"]) && !empty($absen["id"])) {
				$id = $absen["id"];
			}

			$data = array();
			$data["user_id"] = $_SESSION["user"]["id"];
			$data["latitude"] = $_POST["latitude"];
			$data["longitude"] = $_POST["longitude"];
			$data["waktu"] = $waktuMasuk["value"];
			$data["absen"] = $_POST["time"];
			$data["keterangan"] = $_POST["keterangan"];
			$data["tidak_hadir"] = $_POST["tidak_hadir"];

			$data["tipe"] = "apel";

			if (date('l') === 'Friday') {
				$data["tipe"] = "senam";
			}

			$id = $this->absensi_model->saveAbsenApel($data, $id);
		}

		print json_encode($out);
	}

	public function data_apel () {
		$this->auth->login();

		$data = array();
		$data["error"] = false;

		$this->load->model("biodata_model");
		$this->load->model("user_model");

		$pegawais = $this->biodata_model->getBiodataByPegawaiBalai();
		$users = $this->user_model->getUser();

		$pegawaiBalai = array();

		if (!empty($users)) {
			foreach ($users as $user) {
				if (isset($pegawais[$user["sync_biodata"]])) {
					$pegawaiBalai[$user["id"]] = $pegawais[$user["sync_biodata"]];
					$pegawaiBalai[$user["id"]]["user_id"] = $user["id"];
				}
			}
		}

		// Tanggal Apel
		$tglApel = str_replace("Senin, ", "", $_POST["tgl_apel"]);
		$tglApel = str_replace("Jumat, ", "", $tglApel);
		$tglApel = str_replace(array("/"), array("-"), $tglApel);
		$tglApel = date("Y-m-d", strtotime($tglApel));

		$tepatWaktu = $this->absensi_model->apelTepatWaktu($tglApel);
		$terlambat = $this->absensi_model->apelTerlambat($tglApel);
		$tidak_hadir_tercatat = $this->absensi_model->apelTidakHadir($tglApel);
		$tidak_hadir = count($pegawaiBalai) - count($tepatWaktu) - count($terlambat);

		if (date('l', strtotime($tglApel)) === 'Monday') {
			$data["tipe"] = "Apel";
		}

		if (date('l', strtotime($tglApel)) === 'Friday') {
			$data["tipe"] = "Senam";
		}

		$data["jumlah_pegawai"] = count($pegawaiBalai);
		
		$data["tepat_waktu"] = count($tepatWaktu);
		$data["terlambat"] = count($terlambat);
		$data["tidak_hadir"] = $tidak_hadir;

		$data["pct_tepat_waktu"] = round($data["tepat_waktu"] / $data["jumlah_pegawai"] * 100, 2)."%";
		$data["pct_terlambat"] = round($data["terlambat"] / $data["jumlah_pegawai"] * 100, 2)."%";
		$data["pct_tidak_hadir"] = round($data["tidak_hadir"] / $data["jumlah_pegawai"] * 100, 2)."%";

		$tidakHadir = $pegawaiBalai;

		if (!empty($tidakHadir)) {
			foreach ($tidakHadir as $peg) {
				if (isset($tepatWaktu[$peg["user_id"]])) {
					$tepatWaktu[$peg["user_id"]]["nama"] = $peg["nama"];
					$tepatWaktu[$peg["user_id"]]["nip"] = $peg["nip"];
					$tepatWaktu[$peg["user_id"]]["jenis_kelamin"] = $peg["jenis_kelamin"];

					unset($tidakHadir[$peg["user_id"]]);
				}

				if (isset($terlambat[$peg["user_id"]])) {
					$terlambat[$peg["user_id"]]["nama"] = $peg["nama"];
					$terlambat[$peg["user_id"]]["nip"] = $peg["nip"];
					$terlambat[$peg["user_id"]]["jenis_kelamin"] = $peg["jenis_kelamin"];

					unset($tidakHadir[$peg["user_id"]]);
				}
			}
		}

		$currentUser = $_SESSION["user"]["id"];

		$data["list_tepat_waktu"] = "";
		$data["list_terlambat"] = "";
		$data["list_tidak_hadir"] = "";
		$data["user_alert"] = "";

		if (isset($tepatWaktu) && !empty($tepatWaktu)) {
			$i = 1;
			foreach ($tepatWaktu as $apel) {
				$apel["no"] = $i;
				$data["list_tepat_waktu"] .= $this->load->view('backend/absensi/absensi_apel_list_tepat_waktu', $apel, true);
				
				if ($apel["user_id"] == $currentUser) {
					$data["user_alert"] = '<div class="alert alert-success mb-5 t-bold">Terima Kasih Sudah Datang Tepat Waktu.</div>';
				}

				$i++;
			}
		}
		else {
			$data["list_tepat_waktu"] = "<tr><td style='padding:8px 20px;'>Tidak ada data</td></tr>";
		}

		if (isset($terlambat) && !empty($terlambat)) {
			$i = 1;
			foreach ($terlambat as $apel) {
				$apel["no"] = $i;
				$data["list_terlambat"] .= $this->load->view('backend/absensi/absensi_apel_list_terlambat', $apel, true);

				if ($apel["user_id"] == $currentUser) {
					$data["user_alert"] = '<div class="alert alert-warning mb-5 t-bold">Opps.. Hari Ini Anda Terlambat! Minggu Depan Harus Datang Lebih Awal.</div>';
				}

				$i++;
			}
		}
		else {
			$data["list_terlambat"] = "<tr><td style='padding:8px 20px;'>Tidak ada data</td></tr>";
		}

		if (isset($tidakHadir) && !empty($tidakHadir)) {
			$i = 1;
			foreach ($tidakHadir as $apel) {
				if (isset($tidak_hadir_tercatat[$apel["user_id"]])) {
					$apel["keterangan"] = $tidak_hadir_tercatat[$apel["user_id"]]["keterangan"];
				}
				else {
					$apel["keterangan"] = "";
				}

				$apel["no"] = $i;
				$data["list_tidak_hadir"] .= $this->load->view('backend/absensi/absensi_apel_list_tidak_hadir', $apel, true);

				$i++;
			}
		}
		else {
			$data["list_tidak_hadir"] = "<tr><td style='padding:8px 20px;'>Tidak ada data</td></tr>";
		}

		print json_encode($data);
	}

	public function absen_masuk () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;

		if (isset($_POST) && !empty($_POST)) {
			$this->load->model("pengaturan_model");

			$waktuMasuk = $this->pengaturan_model->getPengaturanBySistem('waktu_masuk');
			$absen = $this->absensi_model->getByUserDate($_SESSION["user"]["id"], date("Y-m-d"));
			
			$data = array();
			$data["id"] = $absen["id"];
			$data["user_id"] = $_SESSION["user"]["id"];
			$data["latitude"] = $_POST["latitude"];
			$data["longitude"] = $_POST["longitude"];
			$data["waktu_masuk"] = $waktuMasuk["value"];
			$data["absen_masuk"] = $_POST["time"];

			$id = $this->absensi_model->absen_masuk($data);
		}

		print json_encode($out);
	}

	public function absen_keluar () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil merekam absen keluar";
		$out["close_modal"] = true;
		$out["reload"] = true;

		if (isset($_POST) && !empty($_POST)) {
			$this->load->model("pengaturan_model");

			$waktuKeluar = $this->pengaturan_model->getPengaturanBySistem('waktu_keluar');
			$absen = $this->absensi_model->getByUserDate($_SESSION["user"]["id"], date("Y-m-d"));
			
			$data = array();
			$data["id"] = $absen["id"];
			$data["user_id"] = $_SESSION["user"]["id"];
			$data["waktu_keluar"] = $waktuKeluar["value"];
			$data["keterangan"] = $_POST["log_harian"];

			$id = $this->absensi_model->absen_keluar($data);
		}

		print json_encode($out);
	}

	/*public function me () {
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

			$data = array();
			$data["arsip_id"] = $id;
			$data["no_kabinet"] = $no_kabinet;
			$data["no_laci"] = $no_laci;
			$data["no_folder"] = $no_folder;
			$data["status"] = $status; 
			$data["dipinjam_oleh"] = $dipinjam_oleh;

			$this->arsip_model->save_status($data);
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

			$jenis_belanja = "";
			$nomor_spm = "";
			$nomor_drpp = "";
			$jumlah_bantek = "";

			if ($jenis_berkas == "Keuangan") {
				$jenis_belanja = $_POST["jenis_belanja"];
				$nomor_spm = $_POST["nomor_spm"];
				$nomor_drpp = $_POST["nomor_drpp"];
				$jumlah_bantek = $_POST["jumlah_bantek"];
			}

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

					$uraian[] = $item;
				}
			}

			$data = array();
			$data["nama"] = $nama;
			$data["program"] = $program;
			$data["jenis_berkas"] = $jenis_berkas;
			$data["akses"] = $akses;

			$data["jenis_belanja"] = $jenis_belanja;
			$data["nomor_spm"] = $nomor_spm;
			$data["nomor_drpp"] = $nomor_drpp;
			$data["jumlah_bantek"] = $jumlah_bantek;

			$data["keterangan"] = $keterangan;
			$data["uraian"] = json_encode($uraian);

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
	}*/
}
