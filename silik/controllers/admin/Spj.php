<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spj extends CI_Controller {
	
	function __construct() {
	    
		parent::__construct();
		$this->load->model("spby_model");
		$this->load->model("spj_model");
		
		// Decide to remove
		$this->load->model("kegiatan_model");
		$this->load->model("penugasan_model");
		$this->load->model("user_model");
	}
	
	public function approve_perjadin ($status = '2') {
		$this->auth->login();
		
		$data["status"] = $status;
		
		$this->load->view('backend/spj/lists_approve_perjadin', $data);
	}
	
	public function index() {
		$this->auth->login();
		$this->load->view('backend/spj/lists');
	}
	
	public function kegiatan() {
		$this->auth->login();
		$this->load->view('backend/spj/list_kegiatan');
	}
	
	public function json_list () {
		$this->auth->login();
		
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body, true);
		
		$out = array();
		
		$lists = $this->spj_model->getGroupByPenugasan($data["current"], $data["rowCount"], $data["search"], $data["sort"]);
		$countAll = $this->spj_model->countGroupByPenugasan($data["current"], 0, $data["search"], $data["sort"]);
		
		if (!empty($lists)) {
			$filterKegiatan = array();
			$lookupKegiatan = array();
			
			foreach ($lists as $list) {
				if (!empty($list["kegiatan_id"])) {
					if (!isset($lookupKegiatan[$list["kegiatan_id"]])) {
						$filterKegiatan[] = $list;
						$lookupKegiatan[$list["kegiatan_id"]] = 1;
					}
				}
				else {
					$filterKegiatan[] = $list;
				}
			}
			
			$lists = $filterKegiatan;
		}
		
		$out["current"] = $data["current"];
		$out["rowCount"] = $data["rowCount"];
		$out["total"] = $countAll;
		$out["rows"] = $lists;
		
		
		if (!empty($lists)) {
			
			$laporan = array();
			foreach ($lists as $list) {
				$penugasanItems = $this->penugasan_model->getItemsByPenugasanId($list["penugasan_id"]);
				
				$laporan[$list["penugasan_id"]]["belum_bayar"] = 0;
				$laporan[$list["penugasan_id"]]["siap_bayar"] = 0;
				
				if (!empty($penugasanItems)) {
					foreach ($penugasanItems as $penugasanItem) {
						if ($penugasanItem["status"] <= 4) {
							$laporan[$list["penugasan_id"]]["belum_bayar"] = $laporan[$list["penugasan_id"]]["belum_bayar"] +1;
						}
						else if ($penugasanItem["status"] == 5) {
							$laporan[$list["penugasan_id"]]["siap_bayar"] = $laporan[$list["penugasan_id"]]["siap_bayar"] +1;
						}
					}
				}
			}	
			
			$rows = array();
			$i = ($data["rowCount"] * $data["current"]) - $data["rowCount"] + 1;
			
			foreach ($lists as $list) {
				$list["autonumeric"] = $i;
				
				// Nama SPJ
				if (isset($list["nama"])) {
					$length = strlen($list["nama"]);
			
					if ($length >= 50) {
						//$nama = substr($list["nama"], 0, 50)."...";
					}
					else {
						//$nama = $list["nama"];
					}
					
					$nama = $list["nama"];
					
					$list["nama"] = '<a href="'.base_url('/admin/spj/detail/'.$list["id"]).'" title="'.$list["nama"].'">'.$nama.'</a>';
				}
				
				$list["penugasan_id"] = $list["penugasan_id"];
				$list["petugas"] = $list["item_total"];
				
				
				if ($laporan[$list["penugasan_id"]]["belum_bayar"] == $list["item_total"]) {
					$colorBelum = "bg-c-red";
				}
				else if ($laporan[$list["penugasan_id"]]["belum_bayar"] < $list["item_total"] && $laporan[$list["penugasan_id"]]["belum_bayar"] != 0) {
					$colorBelum = "bg-c-yellow";
				}
				else {
					$colorBelum = "bg-c-grey";
				}
				
				$list["belum_bayar"] = '<label class="label '.$colorBelum.' text-white f-14">'.$laporan[$list["penugasan_id"]]["belum_bayar"].'</label>';
				
				
				
				if ($laporan[$list["penugasan_id"]]["siap_bayar"] > 0) {
					$colorSiapBayar = "bg-c-red";
				}
				else {
					$colorSiapBayar = "bg-c-grey";
				}
				
				$list["siap_bayar"] = '<label class="label '.$colorSiapBayar.' text-white f-14">'.$laporan[$list["penugasan_id"]]["siap_bayar"].'</label>';
				
				
				if ($list["item_dibayar"] == $list["item_total"]) {
					$colorDibayar = "bg-c-green";
				}
				else if ($list["item_dibayar"] > 0) {
					$colorDibayar = "bg-c-yellow";
				}
				else {
					$colorDibayar = "bg-c-grey";
				}
				
				$list["dibayarkan"] = '<label class="label '.$colorDibayar.' text-white f-14">'.$list["item_dibayar"].'</label>';
				
				// Tipe SPJ
				$list["tipe_spj"] = "Monev";
				
				if (!empty($list["kegiatan_id"])) {
					$list["tipe_spj"] = "Kegiatan";
				}
				
				$list["act_btn"] = '<a class="btn btn-sm btn-secondary" onclick="Spj_Keuangan.editBtn(this);" data-id="'.$list["id"].'" title="Edit"><i class="fas fa-edit" style="margin:0;"></i></a> <a class="btn btn-sm btn-danger" onclick="Spj_Keuangan.deleteBtn(this);" data-id="'.$list["id"].'" title="Delete"><i class="fas fa-trash-alt" style="margin:0;"></i></a>';
				
				$rows[] = $list;
				$i++;
			}
			
			$out["rows"] = $rows;
		}
		
		print json_encode($out);
	}
	
	public function json_list_kegiatan () {
		$this->auth->login();
		
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body, true);
		$users = $this->user_model->getUser();
		
		
		if ($_SESSION["user"]["id"] == "1") {
			$dibuat_oleh = 0;
		}
		else {
			$dibuat_oleh = $_SESSION["user"]["id"];
		}
		
		$lists = $this->spj_model->getGroupByKegiatan($data["current"], $data["rowCount"], $data["search"], $data["sort"], $dibuat_oleh);
		$countAll = $this->spj_model->countGroupByKegiatan($data["current"], 0, $data["search"], $data["sort"], $dibuat_oleh);
		
		if (!empty($lists)) {
			$filterKegiatan = array();
			$lookupKegiatan = array();
			
			foreach ($lists as $list) {
				if (!empty($list["kegiatan_id"])) {
					if (!isset($lookupKegiatan[$list["kegiatan_id"]])) {
						$filterKegiatan[] = $list;
						$lookupKegiatan[$list["kegiatan_id"]] = 1;
					}
				}
				else {
					$filterKegiatan[] = $list;
				}
			}
			
			$lists = $filterKegiatan;
		}

		$kegiatans = array();

		if (!empty($lookupKegiatan)) {
			$this->load->model("kegiatan_model");
			$kegiatanIds = array_keys($lookupKegiatan);
			$kegiatans = $this->kegiatan_model->getKegiatanByIds($data["kegiatan_id"]);
		}
		
		$out = array();
		$out["current"] = $data["current"];
		$out["rowCount"] = $data["rowCount"];
		$out["total"] = $countAll;
		$out["rows"] = $lists;
		
		
		if (!empty($lists)) {
			
			$rows = array();
			$i = ($data["rowCount"] * $data["current"]) - $data["rowCount"] + 1;
			
			foreach ($lists as $list) {
				$list["autonumeric"] = $i;
				
				// Nama SPJ
				if (isset($list["nama"])) {					
					$nama = $list["nama"];
					
					$list["nama"] = '<a href="'.base_url('/admin/spj/detail/'.$list["id"]).'" title="'.$list["nama"].'">'.$nama.'</a>';
				}

				$list["tgl_kegiatan"] = "-";

				if (isset($kegiatans[$list["kegiatan_id"]])) {
					$list["tgl_kegiatan"] = $this->utility->formatRangeDate($kegiatans[$list["kegiatan_id"]]["tgl_mulai_kegiatan"], $kegiatans[$list["kegiatan_id"]]["tgl_selesai_kegiatan"]);
				}
				
				$list["kegiatan_id"] = $list["kegiatan_id"];
				
				$list["tanggal"] = date("d M Y", strtotime($list["dibuat_tgl"]));
				
				
				if (!empty($list["item_total"]) && $list["item_dibayar"] == $list["item_total"]) {
					$colorDibayar = "icon-green";
				}
				else if ($list["item_dibayar"] > 0) {
					$colorDibayar = "icon-yellow";
				}
				else {
					$colorDibayar = "icon-grey";
				}
				
				$list["paid"] = '<span class="'.$colorDibayar.' material-icons" title="Telah dibayarkan">&#xe263;</span>';
				
				$list["dibuat_oleh"] = $users[$list["dibuat_oleh"]]["nama"];
				
				$list["act_btn"] = '<a class="btn btn-sm btn-secondary" onclick="Spj_Keuangan.editBtn(this);" data-id="'.$list["id"].'" title="Edit"><i class="fas fa-edit" style="margin:0;"></i></a> <a class="btn btn-sm btn-danger" onclick="Spj_Keuangan.deleteBtn(this);" data-id="'.$list["id"].'" title="Delete"><i class="fas fa-trash-alt" style="margin:0;"></i></a>';
				
				$rows[] = $list;
				$i++;
			}
			
			$out["rows"] = $rows;
		}
		
		print json_encode($out);
	}
	
	public function modal_edit_spj () {
		$this->auth->login();
		
		$data = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$data = $this->spj_model->getById($_POST["id"]);
		}
		
		$data["penugasan_options"] = $this->spj_model->searchPossiblePenugasan();
		
		$html = $this->load->view('backend/spj/modal_edit_spj', $data, true);
		
		print $html;
	}

	public function modal_edit_spj_kegiatan () {
		$this->auth->login();
		
		$data = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$data = $this->spj_model->getById($_POST["id"]);
		}
		
		$data["penugasan_options"] = $this->spj_model->searchPossiblePenugasan();
		
		$html = $this->load->view('backend/spj/modal_edit_spj_kegiatan', $data, true);
		
		print $html;
	}
	
	
	public function kegiatan_typehead () {
		$this->auth->login();
		$out = array();
		
		if (isset($_REQUEST["q"]) && !empty($_REQUEST["q"])) {
			$kegiatan = $this->spj_model->searchPossibleKegiatan($_REQUEST["q"]);
			
			$out["total_count"] = count($kegiatan);
			$out["items"] = $kegiatan;
		}
		
		print json_encode($out);
	}
	
	public function penugasan_typehead () {
		$this->auth->login();
		$out = array();
		
		if (isset($_REQUEST["q"]) && !empty($_REQUEST["q"])) {
			$penugasan = $this->spj_model->searchPossiblePenugasan($_REQUEST["q"]);
			
			$out["total_count"] = count($penugasan);
			$out["items"] = $penugasan;
		}
		
		print json_encode($out);
	}
	
	public function  save_spj () {
		$this->auth->login();
		$out = array();
		$out["error"] = false;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			unset($_POST["id"]);
			
			$data = $_POST;
			
			if (empty($id)) {
				if (isset($data["kegiatan_id"]) && !empty($data["kegiatan_id"])) {
					// Get SPJ With Kegiatan Id
					$komponenSPJ = array();
					$spj = $this->spj_model->getByKegiatanId($data["kegiatan_id"]);
					
					if (!empty($spj)) {
						foreach ($spj as $boo) {
							$komponenSPJ[$boo["komponen"]] = $boo["id"];
						}
					}
					
					// Sync with Penugasan If Exist
					$komponenPenugasanId = array();
					$this->load->model("penugasan_model");
					$penugasan = $this->penugasan_model->getByKegiatanId($data["kegiatan_id"]);
					
					if (!empty($penugasan)) {
						foreach ($penugasan as $boo) {
							$komponenPenugasanId[$boo["tipe"]] = $boo["id"];
						}
					}
					
					$this->load->model("kegiatan_model");
					$kegiatan = $this->kegiatan_model->getKegiatanById($data["kegiatan_id"]);
					
					if (isset($kegiatan["komponen"]) && !empty($kegiatan["komponen"])) {
						$dataSave = $data;
						
						foreach ($kegiatan["komponen"] as $komponen => $komponenActive) {
							if ($komponenActive) {
								$dataSave["penugasan_id"] = 0;
								$dataSave["komponen"] = $komponen;
							
								if (isset($komponenPenugasanId[$komponen])) {
									$dataSave["penugasan_id"] = $komponenPenugasanId[$komponen];
								}

								if (isset($komponenSPJ[$komponen]) && !empty($komponenSPJ[$komponen])) {
									$id = $this->spj_model->save($dataSave, $komponenSPJ[$komponen]);
								}
								else {
									$id = $this->spj_model->save($dataSave);
								}
							}
						}
					}
				}
				else {
					$this->load->model("penugasan_model");
					$spj = $this->spj_model->getByPenugasanId($data["penugasan_id"]);
					$penugasan = $this->penugasan_model->getById($data["penugasan_id"]);
					$penugasanItems = $this->penugasan_model->getItemsByPenugasanId($data["penugasan_id"]);
					
					$dataSave = $data;
					$dataSave["komponen"] = "petugas";
					$dataSave["item_total"] = count($penugasanItems);
					
					if (isset($spj["id"]) && !empty($spj["id"])) {
						$id = $this->spj_model->save($dataSave, $spj["id"]);
					}
					else {
						$based = array();
						$based["nomor_surat"] = $penugasan["nomor_surat"];
						$based["tgl_surat"] = date("d/m/Y", strtotime($penugasan["tgl_surat"]));
						
						$dataSave["based"] = json_encode($based);
						
						$id = $this->spj_model->save($dataSave);
					}
				}
			}
			else {
				// Update Nama SPJ
				$spj = $this->spj_model->getById($id);
				
				if (!empty($spj["kegiatan_id"])) {
					// Update All Kegiatan
					$spjs = $this->spj_model->getByKegiatanId($spj["kegiatan_id"]);
					
					if (!empty($spjs)) {
						foreach ($spjs as $spj) {
							$id = $this->spj_model->save($data, $spj["id"]);
						}
					}
				}
				else {
					$id = $this->spj_model->save($data, $spj["id"]);
				}
			}
		}
		
		print json_encode($out);
	}
	
	public function json_kegiatan () {
		$this->auth->login();
		$out = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$this->load->model("kegiatan_model");
			$out = $this->kegiatan_model->getKegiatanById($_POST["id"]);
		}
		
		print json_encode($out);
	}
	
	public function json_penugasan () {
		$this->auth->login();
		$out = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$this->load->model("penugasan_model");
			$out = $this->penugasan_model->getById($_POST["id"]);
		}
		
		print json_encode($out);
	}
	
	public function delete_spj() {
		$this->auth->login();
		$out = array();
		
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$spj = $this->spj_model->getById($_POST["id"]);
			
			if (!empty($spj)) {
				if (!empty($spj["kegiatan_id"])) {
					$spjs = $this->spj_model->getByKegiatanId($spj["kegiatan_id"]);
					
					if (!empty($spjs)) {
						foreach ($spjs as $spj) {
							$out = $this->spj_model->delete($spj["id"]);
							$out = $this->spj_model->deleteItemBySpjId($spj["id"]);
						}
					}
				}
				else {
					$out = $this->spj_model->delete($spj["id"]);
					$out = $this->spj_model->deleteItemBySpjId($spj["id"]);
				}
			}
		}
		
		print json_encode($out);
	}
	
	public function detail ($id) {
		$this->auth->login();
		
		$data = array();
		$data['spj'] = $this->spj_model->getById($id);
		$data['komponen'] = array($data['spj']);
		
		$data["mak"] = array();
		$this->load->model("pengaturan_model");
		$maks = $this->pengaturan_model->getPengaturanBySection("mak");

		if (!empty($maks)) {
			foreach ($maks as $mak) {
				$data["mak"][$mak["sistem"]] = array_filter(array_map('trim',explode("\n", $mak["value"])));
			}
		}
		
		
		if (!empty($data['spj']["kegiatan_id"])) {
			$this->load->model("kegiatan_model");
			
			$data['kegiatan'] = $this->kegiatan_model->getKegiatanById($data['spj']["kegiatan_id"]);
			$data["komponen"] = $this->spj_model->getByKegiatanId($data['spj']["kegiatan_id"]);
			$data["spj_item"] = $this->spj_model->getItemBySpjId($data['spj']["id"]);

			$this->load->model("kegiatan_options_model");
			$kegiatanOptions = $this->kegiatan_options_model->get($data['spj']["kegiatan_id"], $data["komponen"]->code);
			$options = array();

			if (isset($kegiatanOptions) && !empty($kegiatanOptions)) {
				foreach ($kegiatanOptions as $ops) {
					$options[$ops["key"]] = $ops["value"];
				}
			}

			$data["kegiatan_options"] = $options;
			
			$this->load->view('backend/spj/lists_item', $data);
		}
		else {
			$this->load->model("penugasan_model");
			
			$data["penugasan"] = $this->penugasan_model->getById($data['spj']["penugasan_id"]);
			
			$this->load->view('backend/spj/lists_item', $data);
		}
	}
	
	public function save_spj_based () {
		$this->auth->login();
		$out = array();
		$out["error"] = false;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$dipa = array();
			$based = array();
			$data = array();
			
			// Substitute New Dipa & Based Setting
			$spj = $this->spj_model->getById($id);
			
			// DIPA
			$data["dipa"] = array();
			
			if (isset($spj["dipa"]) && !empty($spj["dipa"])) {
				$data["dipa"] = $spj["dipa"];
			}
			
			if (isset($_POST["dipa"]) && !empty($_POST["dipa"])) {
				$dipa = $_POST["dipa"];
					
				foreach ($_POST["dipa"] as $dipa_name => $dipa_value) {
					$data["dipa"][$dipa_name] = $dipa_value;
				}
			}
			
			$data["dipa"] = json_encode($data["dipa"]);
			
			// BASED
			$data["based"] = array();
			
			if (isset($spj["based"]) && !empty($spj["based"])) {
				$data["based"] = $spj["based"];
			}
			
			if (isset($_POST["based"]) && !empty($_POST["based"])) {
				$based = $_POST["based"];
					
				foreach ($_POST["based"] as $based_name => $based_value) {
					$data["based"][$based_name] = $based_value;
				}
			}
			
			$data["based"] = json_encode($data["based"]);
			
			
			$id = $this->spj_model->save($data, $id);
			
			$spj = $this->spj_model->getById($id);
			
			// Update SPJ Items
			$items = $this->spj_model->getItemBySpjId($id);
			
			if (!empty($items)) {
				foreach ($items as $item) {
					
					// Escape paid item
					if ($item["paid"]) {
						//continue;
					}
					
					// Escape lock item
					if ($item["kunci"]) {
						continue;
					}
					
					$data = array();
					if (isset($dipa["program"])) {
						$data["dipa_program"] = $dipa["program"];
						$data["dipa_kegiatan"] = $dipa["kegiatan"];
						$data["dipa_kro"] = $dipa["kro"];
						$data["dipa_ro"] = $dipa["ro"];
						$data["dipa_komponen"] = $dipa["komponen"];
						$data["dipa_sub_komponen"] = $dipa["sub_komponen"];
						$data["dipa_akun_transport"] = $dipa["akun_transport"];
						$data["dipa_akun_honor"] = $dipa["akun_honor"];
					}
					
					if (isset($based["jenis_surat"])) {
						$data["jenis_surat"] = $based["jenis_surat"];
					}
					
					if (isset($based["nomor_surat"])) {
						$data["nomor_surat"] = $based["nomor_surat"];
					}

					if (isset($based["tgl_surat"])) {
						$data["tgl_surat"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $based["tgl_surat"])));
					}
					
					// Kuitansi Transport
					/*if (isset($based["deskripsi_kuitansi"])) {
						$data["deskripsi_kuitansi"] = $based["deskripsi_kuitansi"];
						$data["kab_kuitansi"] = $based["kab_kuitansi"];
					}
					*/
					if (isset($based["kab_kuitansi"])) {
						$data["kab_kuitansi"] = $based["kab_kuitansi"];
						
						$data["kab_honor"] = $data["kab_kuitansi"];
					}
					
					if (isset($based["tgl_kuitansi"])) {
						$data["tgl_kuitansi"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $based["tgl_kuitansi"])));
						
						$data["tgl_honor"] = $data["tgl_kuitansi"];
					}
				
					//HACK KUITANSI
					if (isset($based["deskripsi_spby"])) {
						$data["deskripsi_kuitansi"] = $based["deskripsi_spby"];
						$data["kab_kuitansi"] = $based["kab_spby"];
					}
					if (isset($based["tgl_spby"])) {
						$data["tgl_kuitansi"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $based["tgl_spby"])));
					}
					
					// Kuitansi Honor
					if (isset($based["deskripsi_honor"])) {
						$data["deskripsi_honor"] = $based["deskripsi_honor"];
						$data["kab_honor"] = $based["kab_honor"];
					}
					if (isset($based["tgl_honor"])) {
						$data["tgl_honor"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $based["tgl_honor"])));
					}
					
					// Tiket & Taksi
					if (isset($based["tiket_berangkat"])) {
						$data["pesawat_berangkat"] = $based["tiket_berangkat"];
					}
					
					if (isset($based["tiket_pulang"])) {
						$data["pesawat_pulang"] = $based["tiket_pulang"];
					}
					
					if (isset($based["taksi_berangkat"])) {
						$data["taksi_berangkat"] = $based["taksi_berangkat"];
					}
					
					if (isset($based["taksi_pulang"])) {
						$data["taksi_pulang"] = $based["taksi_pulang"];
					}
					
					if (isset($based["dpr_taksi_berangkat"])) {
						$data["dpr_taksi_berangkat"] = $based["dpr_taksi_berangkat"];
					}
					
					if (isset($based["dpr_taksi_pulang"])) {
						$data["dpr_taksi_pulang"] = $based["dpr_taksi_pulang"];
					}
					
					// Transport
					if (!empty($spj["kegiatan_id"])) {
						$transportTarget = $item["kab_asal"];
					}
					else {
						$transportTarget = $item["kab_tujuan"];
					}
					
					if (isset($based["transport_".strtolower($transportTarget)])) {
						$data["transport"] = $based["transport_".strtolower($transportTarget)];
						$data["dpr_transport"] = $based["dpr_transport"];
						$data["keterangan_transport"] = $based["keterangan_transport"];
						
						$data["transport_lainnya"] = $based["transport_lainnya"];
						$data["dpr_transport_lainnya"] = $based["dpr_transport_lainnya"];
						$data["keterangan_transport_lainnya"] = $based["keterangan_transport_lainnya"];
					}
					
					// Uang Harian
					if (isset($based["uang_harian"])) {
						$data["uang_harian"] = $based["uang_harian"];
						$data["keterangan_uang_harian"] = $based["keterangan_uang_harian"];
					}
					
					// Penginapan
					if (isset($based["penginapan"])) {
						$data["penginapan"] = $based["penginapan"];
						$data["dpr_penginapan"] = $based["dpr_penginapan"];
						$data["keterangan_penginapan"] = $based["keterangan_penginapan"];
					}
					
					// Pulsa
					if (isset($based["pulsa"])) {
						$data["pulsa"] = $based["pulsa"];
						$data["keterangan_pulsa"] = $based["keterangan_pulsa"];
					}
					
					// Honor
					if (isset($based["honor"])) {
						$data["honor"] = $based["honor"];
						$data["vol_honor"] = $based["vol_honor"];
						$data["satuan_honor"] = $based["satuan_honor"];
						$data["keterangan_honor"] = $based["keterangan_honor"];
					}
					
					$this->spj_model->saveItem($data, $item["id"]);
				}
			}
		}
		
		print json_encode($out);
	}
	
	private function getPejabat ($jabatan) {
		$out = array();
		$out["nip"] = "";
		$out["nama"] = "";
		
		$this->load->model("pengaturan_model");
		$this->load->model("biodata_model");

		$pejabat = $this->pengaturan_model->getPengaturanBySistem($jabatan);

		if (!empty($pejabat)) {
			$biodataId = $pejabat["value"];

			$out = $this->biodata_model->getBiodataById($biodataId);
		}
		
		return $out;
	}
	
	public function import_spj_item () {
		//ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil melakukan import data";
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$urutan = $_POST["urutan"];
			
			// Get SPJ
			$spj = $this->spj_model->getById($id);
			
			if (!empty($spj)) {
				$penugasanId = $spj["penugasan_id"];
				$kegiatanId = $spj["kegiatan_id"];
				$komponen = $spj["komponen"];
				
				if (!empty($kegiatanId)) {
					// Import Dari Kegiatan
					
					// Data Yang Sudah Ada
					$spjKTP = array();
					$spjItems = $this->spj_model->getItemBySpjId($id);
					
					if (!empty($spjItems)) {
						foreach ($spjItems as $spjItem) {
							$spjKTP[$spjItem["ktp"]] = $spjItem;
						}
					}
					
					// Get Kegiatan
					$kegiatan = $this->kegiatan_model->getKegiatanById($kegiatanId);
					

					$this->load->model("komponen_kegiatan_model");
					
					$items = $this->komponen_kegiatan_model->getItemByKegiatanId($komponen, $kegiatanId, $urutan);

					if (!empty($items)) {
						
						// Pejabat
						$ppk = $this->getPejabat("ppk");
						$bp = $this->getPejabat("bp");
						$kepala = $this->getPejabat("kepala");
						$kasubbag = $this->getPejabat("kasubbag");
						
						// Pegawai Balai
						$allPegawaiBalai = array();
						$biodataPegawai = $this->biodata_model->getBiodataByPegawaiBalai();
						
						if (!empty($biodataPegawai)) {
							foreach ($biodataPegawai as $bio) {
								$allPegawaiBalai[$bio["ktp"]] = $bio;
							}
						}
						
						
						// BUILD DATA TO SAVE
						$noUrut = 1;
						
						foreach ($items as $item) {
							$spjItemId = 0;
							$spjItemPaid = 0;
							$pegawaiBalai = 0;
							$provinsiAsal = $_ENV['DEFAULT_PROVINSI'];
							$provinsiTujuan = $_ENV['DEFAULT_PROVINSI'];
							$nip = trim($item["nip"]);
							
							if (isset($spjKTP[$item["ktp"]])) {
								// Update Data
								$spjItemId = $spjKTP[$item["ktp"]]["id"];
								$spjItemPaid = $spjKTP[$item["ktp"]]["paid"];
								
								unset($spjKTP[$item["ktp"]]);
							}
							
							if (isset($allPegawaiBalai[$item["ktp"]])) {
								$pegawaiBalai = 1;
							}
							
							if (isset($item["provinsi_unit_kerja"]) && !empty($item["provinsi_unit_kerja"])) {
								$provinsiAsal = $item["provinsi_unit_kerja"];
							}
							
							if (isset($kegiatan["provinsi_tempat_kegiatan"]) && !empty($kegiatan["provinsi_tempat_kegiatan"])) {
								$provinsiTujuan = $kegiatan["provinsi_tempat_kegiatan"];
							}
							
							if ($nip == "-" || $nip == "0" || $nip == "o" || $nip == "O") {
								$nip = "";
							}
							
							
							// Prepare Data
							$data = array();
							$data["spj_id"] = $spj["id"];
							$data["no_urut"] = $noUrut;
							
							if (isset($spj["dipa"]["program"])) {
								$data["dipa_program"] = $spj["dipa"]["program"];
								$data["dipa_kegiatan"] = $spj["dipa"]["kegiatan"];
								$data["dipa_kro"] = $spj["dipa"]["kro"];
								$data["dipa_ro"] = $spj["dipa"]["ro"];
								$data["dipa_komponen"] = $spj["dipa"]["komponen"];
								$data["dipa_sub_komponen"] = $spj["dipa"]["sub_komponen"];
								$data["dipa_akun_transport"] = $spj["dipa"]["akun_transport"];

								if (!isset($spj["dipa"]["akun_honor"])) {
									$spj["dipa"]["akun_honor"] = "0";
								}

								$data["dipa_akun_honor"] = $spj["dipa"]["akun_honor"];
							}
							
							if (isset($spj["based"]["nomor_surat"])) {
								$data["nomor_surat"] = $spj["based"]["nomor_surat"];
							}
							
							if (isset($spj["based"]["jenis_surat"])) {
								$data["jenis_surat"] = $spj["based"]["jenis_surat"];
							}
							
							if (isset($spj["based"]["tgl_surat"])) {
								$data["tgl_surat"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $spj["based"]["tgl_surat"])));
							}
							
							$data["ktp"] = $item["ktp"];
							$data["nama"] = $item["nama"];
							$data["telp"] = $item["telp"];
							$data["nip"] = $nip;
							$data["pangkat"] = $item["pangkat"];
							$data["golongan"] = $item["golongan"];
							$data["jabatan"] = $item["jabatan"];
							$data["npwp"] = $item["npwp"];
							$data["email"] = $item["email"];
							$data["unit_kerja"] = $item["unit_kerja"];
							$data["pegawai_balai"] = $pegawaiBalai;
							$data["pajak"] = $this->utility->persentasePajak($item["npwp"], $item["golongan"]);
							
							$data["nama_bank"] = $item["nama_bank"];
							$data["no_rekening"] = $item["no_rekening"];
							$data["nama_pemilik_rekening"] = $item["nama_pemilik_rekening"];
							
							$data["kategori"] = $item["kategori"];
							
							$data["provinsi_asal"] = $provinsiAsal;
							$data["provinsi_tujuan"] = $provinsiTujuan;
							$data["kab_asal"] = $item["kab_unit_kerja"];
							$data["kab_tujuan"] = $kegiatan["kab_tempat_kegiatan"];
							$data["tgl_mulai_tugas"] = $kegiatan["tgl_mulai_kegiatan"];
							$data["tgl_selesai_tugas"] = $kegiatan["tgl_selesai_kegiatan"];
							
							if (isset($kasubbag["ktp"]) && $kasubbag["ktp"] == $item["ktp"]) {
								$data["nama_pj"] = $kepala["nama"];
								$data["nip_pj"] = $kepala["nip"];
								$data["jabatan_pj"] = $kepala["jabatan"];
							}
							else if (isset($kepala["ktp"]) && $kepala["ktp"] == $item["ktp"]) {
								$data["nama_pj"] = $kepala["nama"];
								$data["nip_pj"] = $kepala["nip"];
								$data["jabatan_pj"] = $kepala["jabatan"];
							}
							else {
								$data["nama_pj"] = $kasubbag["nama"];
								$data["nip_pj"] = $kasubbag["nip"];
								$data["jabatan_pj"] = $kasubbag["jabatan"];
							}
							
							$data["nama_ppk"] = $ppk["nama"];
							$data["nip_ppk"] = $ppk["nip"];
							$data["nama_bp"] = $bp["nama"];
							$data["nip_bp"] = $bp["nip"];
							
							//if (!$pegawaiBalai) {
								$data["check_laporan"] = 1;
								$data["check_laporan_oleh"] = $_SESSION["user"]["id"];
							
								if (isset($spj["based"]["kab_kuitansi"]) && !empty($spj["based"]["kab_kuitansi"])) {
									$data["kab_kuitansi"] = $spj["based"]["kab_kuitansi"];
								}
								else {
									$data["kab_kuitansi"] = $kegiatan["kab_tempat_kegiatan"];
								}
							
								if (isset($spj["based"]["tgl_kuitansi"]) && !empty($spj["based"]["tgl_kuitansi"])) {
									$data["tgl_kuitansi"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $spj["based"]["tgl_kuitansi"])));
									
								}
								else {
									$data["tgl_kuitansi"] = $kegiatan["tgl_selesai_kegiatan"];
								}
								
							//}
							
							if (!empty($spjItemId)) {
								unset($data["tgl_mulai_tugas"]);
								unset($data["tgl_selesai_tugas"]);
							}
							
							if (!$spjItemPaid) {
								$spjItemId = $this->spj_model->saveItem($data, $spjItemId);
							}
							
							$noUrut++;
						}
						
						// Remove Data Yang Tidak Ditemukan Pada Saat Import Baru
						if (!empty($spjKTP)) {
							foreach ($spjKTP as $spjItem) {
								$this->spj_model->deleteItem($spjItem["id"]);
							}
						}
						
						// Re-order No Urut
						$spjItems = $this->spj_model->getItemBySpjId($spj["id"], "no_urut");
						
						if (!empty($spjItems)) {
							$noUrut = 1;
							
							foreach ($spjItems as $spjItem) {
								$data = array();
								$data["no_urut"] = $noUrut;
								
								$this->spj_model->saveItem($data, $spjItem["id"]);
								$noUrut++;
							}
						}
						
						// Update Total Item On SPJ
						$data = array();
						$data["item_total"] = count($items);
						$this->spj_model->save($data, $spj["id"]);
					}
					else {
						$out["msg"] = "Tidak ada data yang diimport.";
					}
				}
				else {
					// Import Dari Penugasan
					$this->load->model("penugasan_model");
					$this->load->model("validasi_ttd_model");
					$this->load->model("pengaturan_model");
				
					// GET DATA SATKER
					$getSatker = $this->pengaturan_model->getPengaturanBySection("satker");
					$satker = array("kode_surat" => "", "kode_satker" => "");

					if (!empty($getSatker)) {
						foreach ($getSatker as $foo) {
							$satker[$foo["sistem"]] = $foo["value"];
						}
					}
					
					// Data Yang Sudah Ada
					$spjPenugasan = array();
					$spjItems = $this->spj_model->getItemBySpjId($id);
					
					if (!empty($spjItems)) {
						foreach ($spjItems as $spjItem) {
							$spjPenugasan[$spjItem["penugasan_item_id"]] = $spjItem;
						}
					}
					
					// Get Penugasan
					$penugasan = $this->penugasan_model->getById($penugasanId);
					
					// Get Items Penugasan
					$items = $this->penugasan_model->getItemsByPenugasanId($penugasanId);
					
					if (!empty($items)) {
						// Pejabat
						$ppk = $this->getPejabat("ppk");
						$bp = $this->getPejabat("bp");
						$kepala = $this->getPejabat("kepala");
						$kasubbag = $this->getPejabat("kasubbag");

						// Pegawai Balai
						$allPegawaiBalai = array();
						$biodataPegawai = $this->biodata_model->getBiodataByPegawaiBalai();

						if (!empty($biodataPegawai)) {
							foreach ($biodataPegawai as $bio) {
								$allPegawaiBalai[$bio["ktp"]] = $bio;
							}
						}

						// BUILD DATA TO SAVE
						$noUrut = 1;
						$item_total = 0;

						foreach ($items as $item) {
							
							// status 7 "dibatalkan"
							
							if ($item["status"] < "7") {						
								$spjItemId = 0;
								$spjItemPaid = 0;
								$pegawaiBalai = 0;
								$nip = trim($item["nip"]);

								if (isset($spjPenugasan[$item["id"]])) {
									// Update Data
									$spjItemId = $spjPenugasan[$item["id"]]["id"];
									$spjItemPaid = $spjPenugasan[$item["id"]]["paid"];
									
									unset($spjPenugasan[$item["id"]]);
								}

								if (isset($allPegawaiBalai[$item["ktp"]])) {
									$pegawaiBalai = 1;
								}

								if ($nip == "-" || $nip == "0" || $nip == "o" || $nip == "O") {
									$nip = "";
								}


								// Prepare Data
								$data = array();
								$data["spj_id"] = $spj["id"];
								$data["penugasan_item_id"] = $item["id"];
								$data["no_urut"] = $noUrut;

								if (isset($spj["dipa"]["program"])) {
									$data["dipa_program"] = $spj["dipa"]["program"];
									$data["dipa_kegiatan"] = $spj["dipa"]["kegiatan"];
									$data["dipa_kro"] = $spj["dipa"]["kro"];
									$data["dipa_ro"] = $spj["dipa"]["ro"];
									$data["dipa_komponen"] = $spj["dipa"]["komponen"];
									$data["dipa_sub_komponen"] = $spj["dipa"]["sub_komponen"];
									
									// HACK AKUN TRANSPORT
									// HACK TRANSPORT DALAM KOTA
									$akunTransport = $spj["dipa"]["akun_transport"];
																		
									$data["dipa_akun_transport"] = $akunTransport;
									//$data["dipa_akun_honor"] = $spj["dipa"]["akun_honor"];
								}

								if (isset($spj["based"]["nomor_surat"])) {
									$data["nomor_surat"] = $spj["based"]["nomor_surat"];
								}

								if (isset($spj["based"]["tgl_surat"])) {
									$data["tgl_surat"] = date("Y-m-d", strtotime(str_replace(array("/"), array("-"), $spj["based"]["tgl_surat"])));
								}

								$data["ktp"] = $item["ktp"];
								$data["nama"] = $item["nama"];
								$data["telp"] = $item["telp"];
								$data["nip"] = $nip;
								$data["pangkat"] = $item["pangkat"];
								$data["golongan"] = $item["golongan"];
								$data["jabatan"] = $item["jabatan"];
								$data["npwp"] = $item["npwp"];
								$data["unit_kerja"] = $item["unit_kerja"];
								$data["pegawai_balai"] = $pegawaiBalai;

								$data["nama_bank"] = $item["nama_bank"];
								$data["no_rekening"] = $item["no_rekening"];
								$data["nama_pemilik_rekening"] = $item["nama_pemilik_rekening"];

								$data["provinsi_asal"] = $item["provinsi_asal"];
								$data["provinsi_tujuan"] = $item["provinsi_tujuan"];
								$data["kab_asal"] = $item["kab_asal"];
								$data["kab_tujuan"] = $item["kab_tujuan"];
								$data["tgl_mulai_tugas"] = $item["tgl_mulai_tugas"];
								$data["tgl_selesai_tugas"] = $item["tgl_selesai_tugas"];
								
								if (isset($kasubbag["ktp"]) && $kasubbag["ktp"] == $item["ktp"]) {
									$data["nama_pj"] = $kepala["nama"];
									$data["nip_pj"] = $kepala["nip"];
									$data["jabatan_pj"] = $kepala["jabatan"];
								}
								else if (isset($kepala["ktp"]) && $kepala["ktp"] == $item["ktp"]) {
									$data["nama_pj"] = $kepala["nama"];
									$data["nip_pj"] = $kepala["nip"];
									$data["jabatan_pj"] = $kepala["jabatan"];
								}
								else {
									$data["nama_pj"] = $kasubbag["nama"];
									$data["nip_pj"] = $kasubbag["nip"];
									$data["jabatan_pj"] = $kasubbag["jabatan"];
								}
								
								$data["nama_ppk"] = $ppk["nama"];
								$data["nip_ppk"] = $ppk["nip"];
								$data["nama_bp"] = $bp["nama"];
								$data["nip_bp"] = $bp["nip"];
								
								if (!$spjItemPaid) {
									
									if ($penugasan["penugasan_internal"]) {
										$data["tgl_kuitansi"] = date("Y-m-d");
										$data["kab_kuitansi"] = $_ENV["DEFAULT_KABUPATEN"];
									}
									
									$spjItemId = $this->spj_model->saveItem($data, $spjItemId);
									
									// Update Penugasan Item "spj_item_id" dengan "spj_item_id" baru
									$penugasanItemData = array();
									$penugasanItemData["spj_item_id"] = $spjItemId;

									$this->penugasan_model->saveItem($penugasanItemData, $item["id"]);
									
									if ($penugasan["penugasan_internal"]) {
										$spdDepan = $this->validasi_ttd_model->get("Surat Perjalanan Dinas", $item["id"], "spd_depan");
										$idSpd = 0;
										
										if (!empty($spdDepan)) {
											$idSpd = $spdDepan[0]["id"];
										}
										
										// SPD Depan
										$spd = array();
										$spd["id_berkas"] = $item["id"];
										$spd["jenis_berkas"] = "Surat Perjalanan Dinas";
										$spd["posisi_ttd"] = "spd_depan";

										$detail = array();
										$detail["Nomor_Surat_Tugas"] = $penugasan["nomor_surat"];
										$detail["Tgl_Surat_Tugas"] = $penugasan["tgl_surat"];
										$detail["Keterangan_Tugas"] = $penugasan["nama"];

										$detail["Nomor_SPD"] = $this->utility->penomoran($data["no_urut"])."/SPD.".$data["spj_id"]."/".$satker["kode_satker"]."/".date("Y");
										$detail["Tgl_SPD"] = $penugasan["tgl_surat"];					

										$detail["Disetujui_oleh_PPK"] = $ppk["nama"];
										$detail["Disetujui_Tgl"] = $penugasan["tgl_surat"];

										$spd["detail"] = json_encode($detail);
										$this->validasi_ttd_model->save($spd, $idSpd);
									}
								}
								
								$noUrut++;
								$item_total++;
							}
						}

						// Remove Data Yang Tidak Ditemukan Pada Saat Import Baru
						if (!empty($spjPenugasan)) {
							foreach ($spjPenugasan as $spjItem) {
								$this->spj_model->deleteItem($spjItem["id"]);
							}
						}
						
						// Re-order No Urut
						$spjItems = $this->spj_model->getItemBySpjId($spj["id"]);
						
						if (!empty($spjItems)) {
							$noUrut = 1;
							
							foreach ($spjItems as $spjItem) {
								$data = array();
								$data["no_urut"] = $noUrut;
								
								$this->spj_model->saveItem($data, $spjItem["id"]);
								$noUrut++;
							}
						}

						// Update Total Item On SPJ
						$data = array();
						$data["item_total"] = $item_total;
						$this->spj_model->save($data, $spj["id"]);
					}
					else {
						$out["msg"] = "Tidak ada data yang diimport.";
					}
				}
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Gagal melakukan import data. SPJ tidak ditemukan";
			}
		}
		
		print json_encode($out);
	}
	
	
	public function updateST () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$data = array();
			$data["check_st"] = $_POST["surat_tugas"];
			$data["check_st_oleh"] = $_SESSION["user"]["id"];
			
			$this->spj_model->saveItem($data, $id);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function updateSPD () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$data = array();
			$data["check_spd"] = $_POST["spd"];
			$data["check_spd_oleh"] = $_SESSION["user"]["id"];
			
			$this->spj_model->saveItem($data, $id);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function updateLP () {
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menerima laporan perjalanan dinas";
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$item = $this->spj_model->getItemById($id);
			$spj = $this->spj_model->getById($item["spj_id"]);
			
			$out["item"] = $item;
			
			if (isset($item["penugasan_item_id"]) && !empty($item["penugasan_item_id"])) {
				$this->load->model("penugasan_model");
				$penugasaItem = $this->penugasan_model->getItemById($item["penugasan_item_id"]);
				
				if ($penugasaItem["status"] == "3" || $penugasaItem["status"] == "5" || $penugasaItem["status"] == "6") {
					$data = array();
					$data["check_laporan"] = $_POST["laporan"];
					$data["terima_laporan_tgl"] = date("Y-m-d H:i:s");
					$data["check_laporan_oleh"] = $_SESSION["user"]["id"];
					$this->spj_model->saveItem($data, $id);

					$data2 = array();

					if (isset($item["paid"]) && $item["paid"] != "1") {
						$data2["status"] = "5";
					}

					$this->penugasan_model->saveItem($data2, $penugasaItem["id"]);

					if (isset($item["paid"]) && $item["paid"] != "1") {

						$this->load->library("telegram");
						$this->load->model("biodata_model");
						$this->load->model("user_model");

						$penugasan = $this->penugasan_model->getById($penugasaItem["penugasan_id"]);
						$biodataPetugas = $this->biodata_model->getBiodataByNik($penugasaItem["ktp"]);
						$userPetugas = $this->user_model->getUserBySyncBiodata($biodataPetugas["id"]);

						if (isset($userPetugas["telegram_chat_id"]) && !empty($userPetugas["telegram_chat_id"])) {

							$chatID = $userPetugas["telegram_chat_id"];

							$msg = "Hi.. <b>".$userPetugas["nama"]."</b>, \n";

							$msg .= "Laporan perjalanan dinas kamu dengan tugas <b>".$penugasan["nama"]."</b> telah diterima oleh tim keuangan. Terimakasih sudah mengumpulkan laporan tepat waktu dan transaksi pembayaran akan segera diproses.";
							$this->telegram->sendChat($chatID, $msg);
						}
					}

					$out["error"] = false;
					$out["msg"] = "Berhasil menerima laporan perjalanan dinas";
				}
				else {
					$out["error"] = true;
					$out["msg"] = "Laporan belum tervalidasi";
					$out["penugasan_item"] = $penugasaItem;
				}
			}
		}
		
		print json_encode($out);
	}
	
	public function paySPBy () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$spbyId = $_POST["id"];
			
			// SPBy
			$spby = $this->spby_model->getById($spbyId);
			
			if (!empty($spby)) {
				
				// Update paid SPBy
				$data = array();
				$data["paid"] = 1;

				$this->spby_model->save($data, $spbyId);

				// SPJ Item
				$items = $this->spj_model->getItemBySpbyId($spbyId);

				// Update Paid Spj Item
				if (!empty($items)) {
					foreach ($items as $item) {
						$data = array();
						$data["paid"] = 1;

						$this->spj_model->saveItem($data, $item["id"]);
					}
				}


				// Update paid counter SPJ
				$paid = $this->spj_model->getItemBySpjIdPaid($spby["spj_id"]);

				$data = array();
				$data["item_dibayar"] = count($paid);
				$this->spj_model->save($data, $spby["spj_id"]);
				
				
				$this->load->model("penugasan_model");
				$this->load->library("telegram");
				$this->load->model("biodata_model");
				$this->load->model("user_model");
				
				$biodataPetugas = $this->biodata_model->getBiodataByPegawaiBalai();
				$userPetugas = $this->user_model->getUser();
				
				if (!empty($items)) {
					foreach ($items as $item) {
						// Penugasan Item
						$penugasanItem = $this->penugasan_model->getItemById($item["penugasan_item_id"]);

						if (!empty($penugasanItem)) {

							if ($penugasanItem["status"] == "5") {
								$data = array();
								$data["status"] = 6;

								$this->penugasan_model->saveItem($data, $penugasanItem["id"]);
							}

							$penugasan = $this->penugasan_model->getById($penugasanItem["penugasan_id"]);
							
							$usersChatId = array();

							if (!empty($userPetugas)) {
								foreach ($userPetugas as $boo) {
									$usersChatId[$boo["sync_biodata"]] = array(
										"chat_id" => $boo["telegram_chat_id"],
										"nama" => $boo["nama"],
									);
								}
							}

							if (!empty($biodataPetugas)) {
								foreach ($biodataPetugas as $bio) {
									if ($bio["ktp"] == $penugasanItem["ktp"]) {
										if (isset($usersChatId[$bio["id"]]["chat_id"]) && !empty($usersChatId[$bio["id"]]["chat_id"])) {

											$chatID = $usersChatId[$bio["id"]]["chat_id"];

											$msg = "Hi.. <b>".$usersChatId[$bio["id"]]["nama"]."</b>, \n";

											$msg .= "Horee.. Laporan perjalanan dinas kamu dengan tugas <b>".$penugasan["nama"]."</b> telah dibayarkan oleh tim keuangan. Terimakasih atas kerjasamanya.";
											$this->telegram->sendChat($chatID, $msg);
										}
									}
								}
							}

						}
					}
				}
				
				
				// Update Status Penugasan
				$spj = $this->spj_model->getById($spby["spj_id"]);

				if (!empty($spj)) {
					if ($spj["penugasan_id"] > 0 && $spj["item_total"] > 0 && $spj["item_total"] == $spj["item_dibayar"]) {
						$data = array();
						$data["status"] = "5"; // dibayarkan

						$penugasanId = $this->penugasan_model->save($data, $spj["penugasan_id"]);
					}
				}

				$out["error"] = false;
			}
		}
		
		print json_encode($out);
	}
	
	public function executeStatusPenugasanManual () {
		$this->load->model("penugasan_model");
		$spjs = $this->spj_model->getAll();
		
		foreach ($spjs as $spj) {
			if (!empty($spj)) {
				if ($spj["penugasan_id"] > 0 && $spj["item_total"] > 0 && $spj["item_total"] == $spj["item_dibayar"]) {
					$data = array();
					$data["status"] = "5"; // dibayarkan
					
					$penugasanId = $this->penugasan_model->save($data, $spj["penugasan_id"]);
				}
			}
		}
	}
	
	public function updatePaidSelected () { // PAID SPBY
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$this->load->model("penugasan_model");
			
			$ids = $_POST["ids"];
			
			foreach ($ids as $id) {
				$data = array();
				$data["paid"] = 1;

				$this->spj_model->saveItem($data, $id);
				
				// Penugasan Item
				$penugasanItem = $this->penugasan_model->getItemBySpjItemId($id);

				if (!empty($penugasanItem)) {
					$data = array();
					$data["status"] = 6;

					$this->penugasan_model->saveItem($data, $penugasanItem["id"]);
				}
			}
			
			$item = $this->spj_model->getItemById($id);
			
			$paid = $this->spj_model->getItemBySpjIdPaid($item["spj_id"]);
			
			$data = array();
			$data["item_dibayar"] = count($paid);
			$this->spj_model->save($data, $item["spj_id"]);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function typehead ($spjId) {
		$out = array();
		
		if (!empty($spjId) && isset($_GET["q"])) {
			$term = $_GET["q"];
			
			$items = $this->spj_model->getItemsBySpjIdTerm($spjId, $term);
			
			$out["total_count"] = count($items);
			$out["items"] = $items;
		}
		
		print json_encode($out);
		exit();
	}
	
	public function selected_spby () {
		$out = array();
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$item = $this->spj_model->getItemById($id);
			
			$out[] = $item;
		}
		
		print json_encode($out);
		exit();
	}
	
	public function save_manual_item () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan SPJ Item!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			
			if (isset($data["tgl_kuitansi"]) && !empty($data["tgl_kuitansi"])) {
				$data["tgl_kuitansi"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_kuitansi"])));
			}
			
			if (isset($data["tgl_honor"]) && !empty($data["tgl_honor"])) {
				$data["tgl_honor"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_honor"])));
			}
			
			if (isset($data["tgl_mulai_tugas"]) && !empty($data["tgl_mulai_tugas"])) {
				$data["tgl_mulai_tugas"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_mulai_tugas"])));
			}
			
			if (isset($data["tgl_selesai_tugas"]) && !empty($data["tgl_selesai_tugas"])) {
				$data["tgl_selesai_tugas"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_selesai_tugas"])));
			}
			
			if (isset($data["tgl_surat"]) && !empty($data["tgl_surat"])) {
				$data["tgl_surat"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_surat"])));
			}
			
			if (isset($data["tgl_tugas"]) && !empty($data["tgl_tugas"])) {
				$tglTugas = array();
				
				foreach ($data["tgl_tugas"] as $fooKey => $foo) {
					$boo = array();
					$boo["tgl_tugas"] = date("Y-m-d", strtotime(str_replace(array("/"),array("-"), $foo)));
					
					if (isset($data["tempat_tugas"][$fooKey])) {
						$boo["tempat_tugas"] = $data["tempat_tugas"][$fooKey];
					}
					else {
						$boo["tempat_tugas"] = "";
					}
					
					
					$tglTugas[] = $boo;
				}
				
				$data["tgl_tugas"] = json_encode($tglTugas);
			}
			else {
				$data["tgl_tugas"] = "";
			}
			
			if (isset($data["tempat_tugas"])) {
				unset($data["tempat_tugas"]);
			}
			
			$id = $this->spj_model->saveItem($data, $id);
			
			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan item. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function print_item () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			
			$data = array();
			$data["print"] = "1";
			
			$this->spj_model->saveItem($data, $id);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	private function data_spj ($id) {
		$this->auth->login();
		
		// DEFINE VARIABLE GLOBAL
		$data = array();

		$item = $this->spj_model->getItemById($id);

		if (!empty($item)) {
			// GET DATA SPJ
			$spj = $this->spj_model->getById($item["spj_id"]);

			if (!empty($spj)) {
				$data["spj"] = $spj;


				// GET DATA SATKER
				$this->load->model("pengaturan_model");
				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");

				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$data["satker"][$foo["sistem"]] = $foo["value"];
					}
				}

				// GET DATA KEGIATAN
				$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);

				// Define Data
				$item["no_spd"] = $this->utility->penomoran($item["id"])."/SPD/".$data["satker"]["kode_satker"]."/".date("Y", strtotime($item["dibuat_tgl"]));

				$item["dipa_mak"] = $item["dipa_program"]." / ".$item["dipa_kegiatan"].".".$item["dipa_kro"].".".$item["dipa_ro"].".".$item["dipa_komponen"].".".$item["dipa_sub_komponen"].".".$item["dipa_akun_transport"];

				$data["item"] = $item;

				if (!empty($data["kegiatan"])) {

					if ($spj["komponen"] == "peserta") {
						$data["biodata"] = $this->peserta_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "moderator") {
						$data["biodata"] = $this->moderator_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "narasumber") {
						$data["biodata"] = $this->narasumber_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "panitia") {
						$data["biodata"] = $this->panitia_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "fasilitator") {
						$data["biodata"] = $this->fasilitator_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "instruktur") {
						$data["biodata"] = $this->instruktur_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "pengajar_praktek") {
						$data["biodata"] = $this->pengajar_praktek_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "pengawas") {
						$data["biodata"] = $this->pengawas_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}
					else if ($spj["komponen"] == "kepala_sekolah") {
						$data["biodata"] = $this->kepala_sekolah_model->getByKegiatanIdNik($data["kegiatan"]["id"], $item["ktp"]);
					}

					$data["type"] = $spj["komponen"];	
				}
			}
		}
		
		return $data;
	}
	
	public function updatePrintSelected () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$ids = $_POST["ids"];
			
			if (!empty($ids)) {
				foreach ($ids as $id) {
					$data = array();
					$data["print"] = "1";
					$this->spj_model->saveItem($data, $id);

					$out["error"] = false;
				}
			}
			
		}
		
		print json_encode($out);
	}
	
	public function print_spby ($spbyId = 0) {
		$this->auth->login();
		
		if (!empty($spbyId)) {
			$spby = $this->spby_model->getById($spbyId);
			
			if (!empty($spby)) {
				
				// GET DATA SATKER
				$this->load->model("pengaturan_model");
				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
				$satker = array();
				
				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$satker[$foo["sistem"]] = $foo["value"];
					}
				}
				
				// SPBY & Kuitansi
				$data = array();
				$data["satker"] = $satker;
				$data["spby"] = $spby;
				
				if (isset($spby["penerima_dkk"]) && $spby["penerima_dkk"] == "1") {
					$data["spby"]["penerima"] .= ", dkk";
				}
				
				$html = array();
				$html["spby"] = $this->load->view('template/spby', $data, true);
				
				if ($spby["dipa_akun"] != "522151" && $spby["dipa_akun"] != "521213" && $spby["dipa_akun"] != "521115") {
					$html["spby"] .= $this->load->view('template/kuitansi', $data, true);
				}
				
				// Daftar Penerimaan
				$data = $spby;
				$data["tipe"] = "transport";
				$data["spj"] = $this->spj_model->getById($spby["spj_id"]);
				$data["satker"] = $satker;
				
				if ($spby["dipa_akun"] == "522151" || $spby["dipa_akun"] == "521213" || $spby["dipa_akun"] == "521115") {
					$data["items"] = $this->spj_model->getItemBySpbyIdHonor($spby["id"]);
				}
				else {
					$data["items"] = $this->spj_model->getItemBySpbyId($spby["id"]);
				}
				
				if ($spby["dipa_akun"] == "522151" || $spby["dipa_akun"] == "521213" || $spby["dipa_akun"] == "521115") {
					$html["daftar_penerimaan"] = $this->load->view('template/daftar_rincian_penerimaan_honor', $data, true);
				}
				else {
					$html["daftar_penerimaan"] = $this->load->view('template/daftar_rincian_penerimaan', $data, true);
				}
				
				
				$this->mpdf->createSpj($html,"spby", false);
			}
			else {
				$this->load->view('frontend/errors/logo');
			}
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
	public function print_daftar_hadir ($daftarHadirId = 0) {
		$this->auth->login();
		
		if (!empty($daftarHadirId)) {
		    
		    // GET DAFTAR HADIR
		    $this->load->model("daftar_hadir_model");
			$daftarHadir = $this->daftar_hadir_model->getById($daftarHadirId);
			
			//print '<pre>'; print_r($daftarHadir); print '</pre>'; exit();
			
			if (!empty($daftarHadir)) {
			    
			    $data = array();
			    
			    $data["daftar_hadir"] = $daftarHadir;
			    
			    // GET KETUA
			    $this->load->model("biodata_model");
			    $data["ketua"] = $this->biodata_model->getBiodataById($daftarHadir["ketua_panitia"]);
			    
				// GET DATA SATKER
				$this->load->model("pengaturan_model");
				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
				$satker = array();
				
				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$satker[$foo["sistem"]] = $foo["value"];
					}
				}
				
				$data["satker"] = $satker;
				
				// GET ITEM
				$data["items"] = $this->spj_model->getItemByDaftarHadirId($daftarHadirId);
				
				// GET SPJ
				$data["spj"] = $this->spj_model->getById($daftarHadir["spj_id"]);
				
				if (!empty($data["spj"])) {
				    $data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["spj"]["kegiatan_id"]);
				    
				    $html["daftar_hadir"] = $this->load->view('template/daftar_hadir_paket_meeting', $data, true);
				    
				    $html["daftar_penerimaan_atk"] = $this->load->view('template/daftar_penerimaan_atk_meeting', $data, true);
				    
    				$this->mpdf->createSpjAdd($html,"daftar_hadir", false);
				}
				else {
    				$this->load->view('frontend/errors/logo');
    			}
			}
			else {
				$this->load->view('frontend/errors/logo');
			}
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
	/*public function print_daftar_penerimaan ($spbyId = 0) {
		$this->auth->login();
		
		if (!empty($spbyId)) {
			$spby = $this->spby_model->getById($spbyId);
			
			if (!empty($spby)) {
				
				// SPBY Transport
				$data = $spby;
				$data["tipe"] = "transport";
				$data["spj"] = $this->spj_model->getById($spby["spj_id"]);
				
				if ($spby["dipa_akun"] == "522151" || $spby["dipa_akun"] == "521213" || $spby["dipa_akun"] == "521115") {
					$data["items"] = $this->spj_model->getItemBySpbyIdHonor($spby["id"]);
				}
				else {
					$data["items"] = $this->spj_model->getItemBySpbyId($spby["id"]);
				}
				
				// GET DATA SATKER
				$this->load->model("pengaturan_model");
				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
				$satker = array();
				
				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$satker[$foo["sistem"]] = $foo["value"];
					}
				}
				
				$data["satker"] = $satker;
				
				if ($spby["dipa_akun"] == "522151" || $spby["dipa_akun"] == "521213" || $spby["dipa_akun"] == "521115") {
					$html = $this->load->view('template/daftar_rincian_penerimaan_honor', $data, true);
				}
				else {
					$html = $this->load->view('template/daftar_rincian_penerimaan', $data, true);
				}
				
				
				$this->mpdf->createLandscape($html,"daftar_rincian_penerimaan", false);
			}
			else {
				$this->load->view('frontend/errors/logo');
			}
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}*/
	
	public function loadTableRealisasi () {
		$html = "";
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["spj_id"];
			
			$data = array();
			$data["kab"] = array();
			$data["pagu_tiket"] = 0;
			$data["pagu_taksi"] = 0;
			$data["pagu_transport"] = 0;
			$data["pagu_uang_harian"] = 0;
			$data["pagu_penginapan"] = 0;
			$data["pagu_honor"] = 0;
			$data["realisasi_tiket"] = 0;
			$data["realisasi_taksi"] = 0;
			$data["realisasi_transport"] = 0;
			$data["realisasi_uang_harian"] = 0;
			$data["realisasi_penginapan"] = 0;
			$data["realisasi_honor"] = 0;
			$data["sisa_tiket"] = 0;
			$data["sisa_taksi"] = 0;
			$data["sisa_transport"] = 0;
			$data["sisa_uang_harian"] = 0;
			$data["sisa_penginapan"] = 0;
			$data["sisa_honor"] = 0;
			$data["total_pagu"] = 0;
			$data["total_realisasi"] = 0;
			$data["total_sisa"] = 0;
			
			$spj = $this->spj_model->getById($id);
			
			if (!empty($spj)) {
				$based = $spj["based"];
				
				$paguTiket = (isset($based["pagu_tiket"]) && !empty($based["pagu_tiket"])) ? $based["pagu_tiket"] : 0;
				$paguTaksi = (isset($based["pagu_taksi"]) && !empty($based["pagu_taksi"])) ? $based["pagu_taksi"] : 0;
				$paguTransport = (isset($based["pagu_transport"]) && !empty($based["pagu_transport"])) ? $based["pagu_transport"] : 0;
				$paguUH = (isset($based["pagu_uang_harian"]) && !empty($based["pagu_uang_harian"])) ? $based["pagu_uang_harian"] : 0;
				$paguPenginapan = (isset($based["pagu_penginapan"]) && !empty($based["pagu_penginapan"])) ? $based["pagu_penginapan"] : 0;
				$paguHonor = (isset($based["pagu_honor"]) && !empty($based["pagu_honor"])) ? $based["pagu_honor"] : 0;
				$totalPagu = $paguTiket + $paguTaksi + $paguTransport + $paguUH + $paguPenginapan + $paguHonor;
				
				$data["pagu_tiket"] = $paguTiket;
				$data["pagu_taksi"] = $paguTaksi;
				$data["pagu_transport"] = $paguTransport;
				$data["pagu_uang_harian"] = $paguUH;
				$data["pagu_penginapan"] = $paguPenginapan;
				$data["pagu_honor"] = $paguHonor;
				$data["total_pagu"] = $totalPagu;
				$data["dummy"] = 0;
				
				$items = $this->spj_model->getItemBySpjId($id);
				
				
				if (!empty($items)) {
					foreach ($items as $item) {
						if (!isset($data["kab"][$item["kab_asal"]]["transport"])) {
							$data["kab"][$item["kab_asal"]]["pax"] = 0;
							$data["kab"][$item["kab_asal"]]["tiket"] = 0;
							$data["kab"][$item["kab_asal"]]["taksi"] = 0;
							$data["kab"][$item["kab_asal"]]["transport"] = 0;
							$data["kab"][$item["kab_asal"]]["uang_harian"] = 0;
							$data["kab"][$item["kab_asal"]]["penginapan"] = 0;
						}
						
						$data["kab"][$item["kab_asal"]]["pax"] += 1;
						$data["kab"][$item["kab_asal"]]["tiket"] += $item["pesawat_berangkat"] + $item["pesawat_pulang"];
						$data["kab"][$item["kab_asal"]]["taksi"] += $item["taksi_berangkat"] + $item["taksi_pulang"];
						$data["kab"][$item["kab_asal"]]["transport"] += $item["transport"];
						$data["kab"][$item["kab_asal"]]["transport"] += $item["transport_lainnya"];
						$data["kab"][$item["kab_asal"]]["uang_harian"] += $item["uang_harian"];
						$data["kab"][$item["kab_asal"]]["penginapan"] += $item["penginapan"];
						
						if (empty($item["transport_lainnya"])) {
							$item["transport_lainnya"] = 0;
						}
						
						$data["realisasi_tiket"] = $data["realisasi_tiket"] + $item["pesawat_berangkat"] + $item["pesawat_pulang"];
						$data["realisasi_taksi"] = $data["realisasi_taksi"] + $item["taksi_berangkat"] + $item["taksi_pulang"];
						
						$data["realisasi_transport"] = $data["realisasi_transport"] + $item["transport"];
						$data["realisasi_transport"] = $data["realisasi_transport"] + $item["transport_lainnya"];
						
						$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
						
						$data["realisasi_uang_harian"] = $data["realisasi_uang_harian"] + ($item["uang_harian"]*$lamaTugas);
						$data["realisasi_penginapan"] = $data["realisasi_penginapan"] + $item["penginapan"];
						
						if (isset($item["honor"]) && isset($item["vol_honor"])) {
							$data["realisasi_honor"] = $data["realisasi_honor"] + ($item["honor"] * $item["vol_honor"]);
						}
					}
				}
				
				$data["sisa_tiket"] = $data["pagu_tiket"] - $data["realisasi_tiket"];
				$data["sisa_taksi"] = $data["pagu_taksi"] - $data["realisasi_taksi"];
				
				$data["sisa_transport"] = $data["pagu_transport"] - $data["realisasi_transport"];
				$data["sisa_uang_harian"] = $data["pagu_uang_harian"] - $data["realisasi_uang_harian"];
				$data["sisa_penginapan"] = $data["pagu_penginapan"] - $data["realisasi_penginapan"];
				$data["sisa_honor"] = $data["pagu_honor"] - $data["realisasi_honor"];
				
				
				$data["total_realisasi"] = $data["realisasi_tiket"] + $data["realisasi_taksi"] + $data["realisasi_transport"] + $data["realisasi_uang_harian"] + $data["realisasi_penginapan"] + $data["realisasi_honor"];
				
				$data["total_sisa"] = $data["sisa_tiket"] + $data["sisa_taksi"] + $data["sisa_transport"] + $data["sisa_uang_harian"] + $data["sisa_penginapan"] + $data["sisa_honor"];
				
				$html = $this->load->view('backend/spj/table_realisasi', $data, true);
			}
		}
		
		print $html;
	}
	
	
	public function export_mcm ($spjId) {
		$this->auth->login();
		
		$spj = $this->spj_model->getById($spjId);
		$items = $this->spj_model->getItemBySpjId($spjId);
		
		if (!empty($items)) {
			
			$total = 0;
			$itemTotal = array();
			
			foreach ($items as $item) {
				$itemSubTotal = 0;
					
				$itemSubTotal += $item["pesawat_berangkat"];
				$itemSubTotal += $item["pesawat_pulang"];
				$itemSubTotal += $item["taksi_berangkat"];
				$itemSubTotal += $item["taksi_pulang"];
				$itemSubTotal += $item["transport"];
				$itemSubTotal += $item["transport_lainnya"];
				
				if (!empty($item["uang_harian"])) {
					$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
					$itemSubTotal += ($item["uang_harian"]*$lamaTugas);
				}
				
				if (!empty($item["penginapan"])) {
					$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
					$itemSubTotal += ($item["penginapan"]*($lamaTugas - 1));
				}
				
				if (!empty($item["honor"])) {
					$totalHonor = $item["honor"] * $item["vol_honor"];
					$pajak = $totalHonor * $item["pajak"] / 100;
					$honor = $totalHonor - $pajak;
					
					$itemSubTotal += $honor;
				}
				
				$itemTotal[$item["id"]] = $itemSubTotal;
				$total += $itemSubTotal;
			}
			
			$keyData = array(
				"no_rekening" => "P",
				"nama_pemilik_rekening" => date("Ymd"),
				"kosong_1" => "8100126933581000",
				"kosong_2" => count($items),
				"kosong_3" => $total
			);
			
			$exportData = array();
			
			$exp = array();
			
			foreach ($keyData as $export) {
				$exp[] = $export;
			}
			
			foreach (range(1,39) as $kosong) {
				$exp[] = "";
			}
			
			$exportData[] = $exp;
			
			
			foreach ($items as $item) {
				$exp = array();
				
				foreach ($keyData as $dooKey => $doo) {
					$kosong = true;
					
					foreach ($item as $itemKey => $itemVal) {
						if ($itemKey == $dooKey) {
							$exp[] = $itemVal;
							$kosong = false;
						}
					}
					
					if ($kosong) {
						$exp[] = "";
					}
				}
				
				foreach (range(1,39) as $range) {
					if ($range == 1) {
						$exp[] = "IDR";
					}
					else if ($range == 2) {
						$exp[] = $itemTotal[$item["id"]];
					}
					else if ($range == 3) {
						$exp[] = ucfirst($spj["komponen"])." ".$spj["nama"];
					}
					else if ($range == 5) {
						if ($item["nama_bank"] == "Bank Mandiri") {
							$exp[] = "IBU";
						}
						else {
							$exp[] = "LBU";
						}
					}
					else if ($range == 6) {
						if ($item["nama_bank"] == "Bank Mandiri") {
							$exp[] = "";
						}
						else if ($item["nama_bank"] == "Bank BPD Bali") {
							$exp[] = "1290013";
						}
						else if ($item["nama_bank"] == "Bank BCA") {
							$exp[] = "0140397";
						}
						else if ($item["nama_bank"] == "Bank BNI") {
							$exp[] = "0090010";
						}
						else if ($item["nama_bank"] == "Bank BRI") {
							$exp[] = "0020307";
						}
						else if ($item["nama_bank"] == "Bank Danamon") {
							$exp[] = "0110042";
						}
					}
					else if ($range == 7) {
						if ($item["nama_bank"] == "Bank Mandiri") {
							$exp[] = "Mandiri";
						}
						else if ($item["nama_bank"] == "Bank BPD Bali") {
							$exp[] = "BPD Bali";
						}
						else if ($item["nama_bank"] == "Bank BCA") {
							$exp[] = "BCA";
						}
						else if ($item["nama_bank"] == "Bank BNI") {
							$exp[] = "BNI";
						}
						else if ($item["nama_bank"] == "Bank BRI") {
							$exp[] = "BRI";
						}
						else if ($item["nama_bank"] == "Bank Danamon") {
							$exp[] = "Danamon";
						}
					}
					else if ($range == 12) {
						if (!empty($item["email"])) {
							$exp[] = "Y";
						}
						else {
							$exp[] = "N";
						}
					}
					else if ($range == 13) {
						if (!empty($item["email"])) {
							$exp[] = $item["email"];
						}
						else {
							$exp[] = "";
						}
					}
					else if ($range == 17) {
						if ($item["nama_bank"] != "Bank Mandiri") {
							$exp[] = "Y";
						}
						else 
						{
							$exp[] = "";
						}
					}
					else if ($range == 34) {
						$exp[] = "BEN";
					}
					else if ($range == 35) {
						$exp[] = "1";
					}
					else if ($range == 36) {
						$exp[] = "E";
					}
					else if ($range == 39) {
						$exp[] = "'";
					}
					else {
						$exp[] = "";
					}
				}
				
				$exportData[] = $exp;
				
			}
		}
		else {
			$exportData = array(array("Data not found"));
		}
		
		$this->excel->create($exportData, "export_MCM_".$spjId."_".$spj["komponen"]);
	}
	
	public function export_mcm_spby ($spbyId, $typeFile = "excel") {
		$this->auth->login();
		
		$spby = $this->spby_model->getById($spbyId);
		
		if (!empty($spby)) {
			$remark = $spby["remark"];
			$spj = $this->spj_model->getById($spby["spj_id"]);
			$items = $this->spj_model->getItemBySpbyId($spbyId);

			if (!empty($items)) {

				$total = 0;
				$itemTotal = array();

				foreach ($items as $item) {
					$itemSubTotal = 0;

					$itemSubTotal += $item["pesawat_berangkat"];
					$itemSubTotal += $item["pesawat_pulang"];
					$itemSubTotal += $item["taksi_berangkat"];
					$itemSubTotal += $item["taksi_pulang"];
					$itemSubTotal += $item["transport_lainnya"];
					
					if (!empty($item["tgl_tugas"])) {
						$lamaTugas = count($item["tgl_tugas"]);
						$itemSubTotal += ($item["transport"]*$lamaTugas);
						
						if (!empty($item["uang_harian"])) {
							$itemSubTotal += ($item["uang_harian"]*$lamaTugas);
						}
						
						if (!empty($item["penginapan"])) {
							$itemSubTotal += ($item["penginapan"]*($lamaTugas - 1));
						}
					}
					else {
						$itemSubTotal += $item["transport"];

						if (!empty($item["uang_harian"])) {
							$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
							$itemSubTotal += ($item["uang_harian"]*$lamaTugas);
						}

						if (!empty($item["penginapan"])) {
							$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
							$itemSubTotal += ($item["penginapan"]*($lamaTugas - 1));
						}
					}

					if (!empty($item["honor"])) {
						$totalHonor = $item["honor"] * $item["vol_honor"];
						$pajak = $totalHonor * $item["pajak"] / 100;
						$honor = $totalHonor - $pajak;

						$itemSubTotal += $honor;
					}

					$itemTotal[$item["id"]] = $itemSubTotal;
					$total += $itemSubTotal;
				}

				$keyData = array(
					"no_rekening" => "P",
					"nama_pemilik_rekening" => date("Ymd"),
					"kosong_1" => "8100126933581000",
					"kosong_2" => count($items),
					"kosong_3" => $total
				);

				$exportData = array();

				$exp = array();

				foreach ($keyData as $export) {
					$exp[] = $export;
				}

				foreach (range(1,39) as $kosong) {
					$exp[] = "";
				}

				$exportData[] = $exp;


				foreach ($items as $item) {
					$exp = array();

					foreach ($keyData as $dooKey => $doo) {
						$kosong = true;

						foreach ($item as $itemKey => $itemVal) {
							if ($itemKey == $dooKey) {
								$exp[] = $itemVal;
								$kosong = false;
							}
						}

						if ($kosong) {
							$exp[] = "";
						}
					}

					foreach (range(1,39) as $range) {
						if ($range == 1) {
							$exp[] = "IDR";
						}
						else if ($range == 2) {
							$exp[] = $itemTotal[$item["id"]];
						}
						else if ($range == 3) {
							$exp[] = $remark;
						}
						else if ($range == 5) {
							if ($item["nama_bank"] == "Bank Mandiri") {
								$exp[] = "IBU";
							}
							else {
								$exp[] = "LBU";
							}
						}
						else if ($range == 6) {
							$kodeBank = $this->config->item('kode_bank');
							
							if (isset($kodeBank[$item["nama_bank"]]["kode"])) {
								$exp[] = $kodeBank[$item["nama_bank"]]["kode"];
							}
							else {
								$exp[] = "ERROR!";
							}
						}
						else if ($range == 7) {
							$kodeBank = $this->config->item('kode_bank');
							
							if (isset($kodeBank[$item["nama_bank"]]["alias"])) {
								$exp[] = $kodeBank[$item["nama_bank"]]["alias"];
							}
							else {
								$exp[] = "ERROR!";
							}
						}
						else if ($range == 12) {
							if (!empty($item["email"])) {
								//$exp[] = "Y";
								$exp[] = "N";
							}
							else {
								$exp[] = "N";
							}
						}
						else if ($range == 13) {
							if (!empty($item["email"])) {
								//$exp[] = $item["email"];
								$exp[] = "";
							}
							else {
								$exp[] = "";
							}
						}
						else if ($range == 17) {
							if ($item["nama_bank"] != "Bank Mandiri") {
								$exp[] = "Y";
							}
							else 
							{
								$exp[] = "";
							}
						}
						else if ($range == 34) {
							$exp[] = "BEN";
						}
						else if ($range == 35) {
							$exp[] = "1";
						}
						else if ($range == 36) {
							$exp[] = "E";
						}
						else if ($range == 39) {
							$exp[] = "'";
						}
						else {
							$exp[] = "";
						}
					}

					$exportData[] = $exp;

				}
			}
			else {
				$exportData = array(array("Data not found"));
			}
		}
		else {
			$exportData = array(array("Data not found"));
		}
		
		if ($typeFile == "csv") {
			$this->excel->csv($exportData, $spby["nama_file"]);
		}
		else {
			$this->excel->create($exportData, $spby["nama_file"]);
		}
	}
	
	public function generate_penerimaan_honor ($spjId = "") {
		$data = array();
		$spj = $this->spj_model->getById($spjId);

		if (!empty($spj)) {
				
			// Kegiatan
			$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);		
			
			// Prepare to Generate SPBY
			$html = "";
			
			// GET DATA SATKER
			$this->load->model("pengaturan_model");
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");

			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$data["satker"][$foo["sistem"]] = $foo["value"];
				}
			}

			// GET DATA PEGAWAI BALAI
			$this->load->model("biodata_model");
			$pegawais = $this->biodata_model->getBiodataByPegawaiBalai();

			$pegawai = array();
			if (!empty($pegawais)) {
				foreach ($pegawais as $peg) {
					$pegawai[$peg["id"]] = $peg;
				}
			}
			
			// PEJABAT
			$bp = array();
			$pejabatBP = $this->pengaturan_model->getPengaturanBySistem("bp");

			if (!empty($pejabatBP)) {
				$biodataId = $pejabatBP["value"];

				$bp = $this->biodata_model->getBiodataById($biodataId);
			}
			
			
			// SPBY Transport
			$items = $this->spj_model->getItemBySpjId($spjId);
			
			
			// Prepare Data
			$data["items"] = $items;
			$data["bp"] = $bp;
			
			//$this->load->view('template/daftar_penerimaan_honor', $data);
			$html = $this->load->view('template/daftar_penerimaan_honor', $data, true);
			
			$this->mpdf->createSpj($html,"Daftar Penerimaan Transport", false);
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
	public function save_status_penugasan () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Berhasil menyimpan Status Penugasan!";
		$out["close_modal"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$this->load->model("penugasan_model");
			
			$spjItemId = $_POST["id"];
			$statusPenugasanItem = $_POST["status_penugasan_item"];
			
			$spjItem = $this->spj_model->getItemById($spjItemId);
			
			if (!empty($spjItem)) {
				$data = array();
				$data["status"] = $statusPenugasanItem;

				$this->penugasan_model->saveItem($data, $spjItem["penugasan_item_id"]);
			}
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function updateLock () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$table = $_POST["table"];
			
			$data = array();
			$data["kunci"] = $_POST["value"];
			
			$this->spj_model->saveItem($data, $id);
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function list_spby_item () {
		
		if (isset($_POST["spby_id"])) {
			$data = array();
			$data["spj_id"] = $_POST["spj_id"];
			$data["spby_id"] = $_POST["spby_id"];
			$data["akun"] = $_POST["akun"];
			
			$data["spby"] = array();
			$data["spby"]["paid"] = 0;
			
			$spby = $this->spby_model->getById($data["spby_id"]);
			
			if (!empty($spby)) {
				$data["spby"] = $spby;
			}
			
			if ($data["spby"]["paid"]) {
				if ($data["akun"] == "522151" || $data["akun"] == "521213" || $data["akun"] == "521115") {
					$data["items"] = $this->spj_model->getPaidSpbyHonorItemsBySpjIdAndSpbyId($_POST["spj_id"], $_POST["spby_id"]);
				}
				else {
					$data["items"] = $this->spj_model->getPaidSpbyItemsBySpjIdAndSpbyId($_POST["spj_id"], $_POST["spby_id"]);
				}
			}
			else {
				if ($data["akun"] == "522151" || $data["akun"] == "521213" || $data["akun"] == "521115") {
					$data["items"] = $this->spj_model->getPossibleSpbyHonorItemsBySpjIdAndSpbyId($_POST["spj_id"], $_POST["spby_id"], $_POST["tgl_spby"]);
				}
				else {
					$data["items"] = $this->spj_model->getPossibleSpbyItemsBySpjIdAndSpbyId($_POST["spj_id"], $_POST["spby_id"], $_POST["tgl_spby"]);	
				}
			}
			
			$html = $this->load->view('backend/spj/list_spby_item', $data, true);
			
			print $html;
		}
		else {
			print "Error! SPBy Not Found.";
		}
	}
	
	public function save_spby () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan SPBy!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST["spj_id"]) && !empty($_POST["spj_id"])) {
			$spbyId = $_POST["spby_id"];
			$spbyItems = $_POST["spby_item"];
			
			unset($_POST["spby_id"]);
			unset($_POST["spby_item"]);
			
			$data = $_POST;
			
			if (isset($data["tgl_spby"]) && !empty($data["tgl_spby"])) {
				$data["tgl_spby"] = date("Y-m-d", strtotime(str_replace(array("/"),array("-"),$data["tgl_spby"])));
			}
			else {
				$data["tgl_spby"] = date("Y-m-d");
			}
			
			// PPK dan BP
			$ppk = array("id" => 0, "nama" => "", "nip" => "");
			$bp = array("id" => 0, "nama" => "", "nip" => "");

			$this->load->model("pengaturan_model");
			$this->load->model("biodata_model");

			$pejabatPPK = $this->pengaturan_model->getPengaturanBySistem("ppk");

			if (!empty($pejabatPPK)) {
				$biodataId = $pejabatPPK["value"];

				$ppk = $this->biodata_model->getBiodataById($biodataId);
			}

			$pejabatBP = $this->pengaturan_model->getPengaturanBySistem("bp");

			if (!empty($pejabatBP)) {
				$biodataId = $pejabatBP["value"];

				$bp = $this->biodata_model->getBiodataById($biodataId);
			}
			
			$data["nama_ppk"] = $ppk["nama"];
			$data["nip_ppk"] = $ppk["nip"];
			$data["nama_bp"] = $bp["nama"];
			$data["nip_bp"] = $bp["nip"];
			
			$id = $this->spby_model->save($data, $spbyId);
			
			
			// Update Items
			
			if ($data["dipa_akun"] == "522151" || $data["dipa_akun"] == "521213" || $data["dipa_akun"] == "521115") {
				$typeSpby = "spby_id_honor";
			}
			else {
				$typeSpby = "spby_id";
			}
			
			if (!empty($spbyItems)) {
				foreach ($spbyItems as $spjItemId => $joinSpby) {
					$data = array();
					$data[$typeSpby] = 0;
					
					if ($joinSpby > 0) {
						$data[$typeSpby] = $id;
					}

					$this->spj_model->saveItem($data, $spjItemId);
				}
			}
		}
		
		print json_encode($out);
	}
	
	
	public function print_selected_item ($ids) {
		
		if (!empty($ids)) {
			$ids = explode("_",$ids);		
			$items = $this->spj_model->getItemsByIds($ids);
			
			if (!empty($items)) {
				// GET DATA SATKER
				$this->load->model("pengaturan_model");
				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
				$satker = array();
				
				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$satker[$foo["sistem"]] = $foo["value"];
					}
				}
				
				$pdf = "";
				$spj = $this->spj_model->getById($items[0]["spj_id"]);
				
				foreach ($items as $item) {
					$data = array();
					$data["satker"] = $satker;
					$data["spj"] = $spj;
					$data["spj_item"] = $item;
					$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["spj"]["kegiatan_id"]);
					
					$data["spj_item"]["no_spd"] = $this->utility->penomoran(1)."/SPD.".$data["spj_item"]["spj_id"]."/".$data["satker"]["kode_satker"]."/".date("Y", strtotime($data["spj_item"]["dibuat_tgl"]));
					
					if ($item["dipa_akun_transport"] == "524111" || $item["dipa_akun_transport"] == "533111" || $item["dipa_akun_transport"] == "524113") {
						
						$data["spj_item"]["no_spd"] = $this->utility->penomoran($data["spj_item"]["no_urut"])."/SPD.".$data["spj_item"]["spj_id"]."/".$data["satker"]["kode_satker"]."/".date("Y", strtotime($data["spj_item"]["dibuat_tgl"]));
						
						if (!empty($item["tgl_tugas"])) {
							$dum_i = 1;
							
							foreach ($item["tgl_tugas"] as $boo) {
								$dum = $data;
								$dum["spj_item"]["tgl_mulai_tugas"] = $boo['tgl_tugas'];
								$dum["spj_item"]["tgl_selesai_tugas"] = $boo['tgl_tugas'];
								$dum["spj_item"]["no_kode"] = $dum_i;
								$dum["spj_item"]["tempat_tugas"] = $boo['tempat_tugas'];
								
								$pdf .= $this->load->view('template/sppd_depan', $dum, true);
								
								$dum_i++;
							}
						}
						else {
							$pdf .= $this->load->view('template/sppd_depan', $data, true);
						}
					}
					
					if ((isset($item["transport"]) && !empty($item["transport"])) || (isset($item["uang_harian"]) && !empty($item["uang_harian"])) || (isset($item["penginapan"]) && !empty($item["penginapan"])) || (isset($item["taksi_berangkat"]) && !empty($item["taksi_berangkat"]))) {
						
						$pdf .= $this->load->view('template/rincian_perjadin', $data, true);
						
						if ($item["dpr_taksi_berangkat"] > 0 || $item["dpr_taksi_pulang"] > 0 || $item["dpr_transport"] > 0 || $item["dpr_transport_lainnya"] > 0 || $item["dpr_penginapan"] > 0) {
							$pdf .= $this->load->view('template/daftar_pengeluaran_riil', $data, true);
						}
						
						if ($item["provinsi_asal"] != $item["provinsi_tujuan"]) {
						    
						    $data["item"] = $item;
						    
						    $pdf .= $this->load->view('template/surat_pernyataan_perjadin', $data, true);
						}
						else {
							if (($item["transport"] > 0 && $item["dpr_transport"] == 0) || ($item["transport_lainnya"] > 0 && $item["dpr_transport_lainnya"] == 0) || ($item["penginapan"] > 0 && $item["dpr_penginapan"] == 0)) {
							
								$data["item"] = $item;
						    
						    	$pdf .= $this->load->view('template/surat_pernyataan_perjadin_lokal', $data, true);
							}
						}
					}
					
					
					if (isset($item["honor"]) && !empty($item["honor"]) && !empty($item["dipa_akun_honor"])) {
						$pdf .= $this->load->view('template/kuitansi_honor', $data, true);
					}
				}
				
				
				$this->mpdf->createSPJItem($pdf,"Rincian Perjalanan Dinas", false);
			}
		}
		else {
			exit();
		}
	}
	
	public function updateLockAll () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Ulangi lagi, terjadi kesalahan";
		
		if (isset($_POST) && !empty($_POST)) {
			$spj_id = $_POST["spj_id"];
			$value = $_POST["value"];
			
			$data = array();
			$data["kunci"] = $value;
			
			$this->spj_model->updateItemBySpjId($data, $spj_id);
			
			$data = array();
			$data["kunci"] = $value;
			
			$this->spj_model->save($data, $spj_id);
			
			$out["error"] = false;
			$out["msg"] = "Berhasil lock semua record";
		}
		
		print json_encode($out);
	}
	
	public function spd_paket_meeting ($spbyId = 0) {
		
		if (!empty($spbyId)) {
			$spby = $this->spby_model->getById($spbyId);
			
			if (!empty($spby)) {
				
				// SPBY Transport
				$data = $spby;
				$data["tipe"] = "transport";
				$data["spj"] = $this->spj_model->getById($spby["spj_id"]);
				$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["spj"]["kegiatan_id"]);
				
				if ($spby["dipa_akun"] == "522151" || $spby["dipa_akun"] == "521213" || $spby["dipa_akun"] == "521115") {
					$data["items"] = $this->spj_model->getItemBySpbyIdHonor($spby["id"]);
				}
				else {
					$data["items"] = $this->spj_model->getItemBySpbyId($spby["id"]);
				}
				
				$item = array();
				$item["no_urut"] = "";
				
				if (!empty($data["items"])) {
					$item = $data["items"][0];
				}
				
				if (!empty($item["nama_ppk"])) {
					$data["pejabat"]["ppk"] = array(
						"nip" => $item["nip_ppk"],
						"nama" => $item["nama_ppk"]
					);
				}

				if (!empty($item["nama_bp"])) {
					$data["pejabat"]["bp"] = array(
						"nip" => $item["nip_bp"],
						"nama" => $item["nama_bp"]
					);
				}
				
				$data["spj_item"] = $item;
				
				
				// GET DATA SATKER
				$this->load->model("pengaturan_model");
				$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
				$satker = array();
				
				if (!empty($pengaturan)) {
					foreach ($pengaturan as $foo) {
						$satker[$foo["sistem"]] = $foo["value"];
					}
				}
				
				$data["satker"] = $satker;
				
				
				// SPD
				$data["spj_item"]["no_spd"] = $this->utility->penomoran(1)."/SPD.".$data["spj_item"]["spj_id"]."/".$data["satker"]["kode_satker"]."/".date("Y", strtotime($data["spj_item"]["dibuat_tgl"]));
				
				$html = array();
		
				$html["spd_depan"] = $this->load->view('template/sppd_depan_paket_meeting', $data, true);
				$html["spd_belakang"] = $this->load->view('template/sppd_belakang_paket_meeting', $data, true);

				$this->mpdf->createSPDPaketMeeting($html,"daftar_rincian_penerimaan", false);
			}
			else {
				$this->load->view('frontend/errors/logo');
			}
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
	public function save_mcm_transfer () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Ulangi lagi, terjadi kesalahan";
		
		if (isset($_POST) && !empty($_POST)) {
			$spbyId = $_POST["id"];
			
			$data = array();
			$data["nama_file"] = $_POST["nama_file"];
			$data["remark"] = $_POST["remark"];
			
			$spbyId = $this->spby_model->save($data, $spbyId);
			
			$out["error"] = false;
			$out["spby_id"] = $spbyId;
			$out["msg"] = "Berhasil mendownload MCM Transfer File";
			$out["download"] = $_POST["download"];
		}
		
		print json_encode($out);
	}
	
	public function print_kelengkapan_spby () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Ulangi lagi, terjadi kesalahan";
		
		if (isset($_POST) && !empty($_POST)) {
			$out = array();
			$out["sppd"] = 0;
			$out["daftar_hadir"] = 0;
			
			$spbyId = $_POST["id"];
			$spby = $this->spby_model->getById($spbyId);
			
			if ($spby["dipa_akun"] == "524119") {
				$out["sppd"] = 1;
				//$out["daftar_hadir"] = 1;
			}
		}
		
		print json_encode($out);
	}
	
	public function print_amplop ($ids) {
		$this->auth->login();
		
		if (!empty($ids)) {
			$ids = explode("_",$ids);		
			$items = $this->spj_model->getItemsByIds($ids);
			
			if (!empty($items)) {
				// GET DATA SATKER
				
				$pdf = "";
				$spj = $this->spj_model->getById($items[0]["spj_id"]);
				
				foreach ($items as $item) {
					$data = array();
					$data["spj"] = $spj;
					$data["spj_item"] = $item;
					
					if ((isset($item["pesawat_berangkat"]) && !empty($item["pesawat_berangkat"])) || (isset($item["pesawat_pulang"]) && !empty($item["pesawat_pulang"])) || (isset($item["transport"]) && !empty($item["transport"])) || (isset($item["uang_harian"]) && !empty($item["uang_harian"])) || (isset($item["penginapan"]) && !empty($item["penginapan"])) || (isset($item["taksi_berangkat"]) && !empty($item["taksi_berangkat"]))) {
						if (!empty($pdf)) {
							$pdf .= "<pagebreak/>";
						}
						
						$pdf .= $this->load->view('template/amplop_penerima', $data, true);
					}
				}
				
				$this->mpdf->createAmplop($pdf,"Amplop");
			}
		}
		else {
			exit();
		}
	}
	
	
	public function getItemDaftarHadir () {
		$this->auth->login();
		
		if (isset($_POST["spj_id"])) {
			$data = array();
			$data["id"] = $_POST["id"];
			$data["items"] = $this->spj_model->getItemDaftarKegiatan($_POST["spj_id"], $_POST["id"]);
			
			$html = $this->load->view('backend/spj/table_item_daftar_kehadiran', $data, true);
			
			print $html;
		}
		else {
			print "Item tidak tersedia.";
		}
	}
	
	public function save_daftar_hadir () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = true;
		$out["id"] = 0;
		
		if (isset($_POST["spj_id"])) {
			
			$id = $this->spj_model->saveDaftarHadir($_POST, $_POST["id"]);
			
			$out["id"] = $id;
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	public function print_daftar_hadir_atk ($id = false) {
		$this->auth->login();
		
		
	}
	
	public function scan_perjadin () {
		$this->auth->login();
		
		$data = array();
		
		$this->load->view('backend/spj/scan_perjadin', $data);
	}
	
	public function loadSpjItemBarcode () {
		$this->auth->login();
		
		if (isset($_POST) && !empty($_POST)) {
			// GET DATA SATKER
			$this->load->model("pengaturan_model");
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");
			
			$data = array();
			
			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$data["satker"][$foo["sistem"]] = $foo["value"];
				}
			}
			
			$spjItemId = str_replace(strtoupper(md5($data["satker"]["kode_satker"])).".","",$_POST["spj_item_id"]);
			$spjItemId = str_replace(md5($data["satker"]["kode_satker"]).".","",$spjItemId);
			
			$data["spj_item"] = $this->spj_model->getItemById($spjItemId);
			
			if (!empty($data["spj_item"])) {
				$data["penugasan_item"] = $this->penugasan_model->getItemById($data["spj_item"]["penugasan_item_id"]);
				
				if (!empty($data["penugasan_item"])) {
					$data["penugasan"] = $this->penugasan_model->getById($data["penugasan_item"]["penugasan_id"]);
				}
			}
			
			print $this->load->view('backend/user/modal_scan_barcode', $data, true);
		}
		else {
			
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function save () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan SPJ Kegiatan!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			
			if (isset($data["id"]) && empty($data["id"])) {
				$data["status"] = "baru";
			}
			
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);

			$id = $this->spj_model->save($data, $id);
			
			$kegiatanId = $data["kegiatan_id"];
				
			// Reset Data To Save Kegiatan
			$data = array();
			$data["spj_kegiatan"] = $id;

			$this->kegiatan_model->save($data, $kegiatanId);
			
			
			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan SPJ kegiatan. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	
	protected function decodeBased ($based) {
		$out = array();
		
		if (!empty($based)) {
			$options = json_decode($based, true);

			foreach ($options as $opt) {
				$out[$opt["name"]] = $opt["value"];
			}
		}
		
		return $out;
	}
	
	
	protected function detailSpj ($unsur = "peserta", $spjId = "") {
		if (!empty($spjId)) {
			
			$spj = $this->spj_model->getById($spjId);
			
			if (!empty($spj)) {
				$kegiatan = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);
				
				$based = $this->decodeBased($spj["based_".$unsur]);
				
				$data = array();
				$data["spj"] = $spj;
				$data["options"] = $based;
				$data["kegiatan"] = $kegiatan;
				$data["unsur"] = $unsur;
				
				$placeHolder = array();
				$placeHolder["dipa_program"] = "023.16.DI";
				$placeHolder["dipa_kegiatan"] = "6397";
				$placeHolder["dipa_kro"] = "QDB";
				$placeHolder["dipa_ro"] = "850";
				$placeHolder["dipa_komponen"] = "063";
				$placeHolder["dipa_sub_komponen"] = "CA";
				$placeHolder["dipa_akun_transport"] = "524111";
				$placeHolder["dipa_akun_honor"] = "522151";
				$placeHolder["nomor_spm"] = "00001A";
				$placeHolder["tgl_spm"] = "01/01/2022";
				$placeHolder["deskripsi_transport"] = "Belanja perjalanan dinas paket meeting luar kota (transport & uang harian ".$unsur."), kegiatan ... tgl ... di ...";
				$placeHolder["deskripsi_honor"] = "Belanja jasa profesi (honorarium ".$unsur."), kegiatan ... tgl ... di ...";
				
				$data["placeHolder"] = $placeHolder;
				
				if ($unsur == "peserta") {
					$this->load->view('backend/spj/lists_peserta', $data);
				}
				else {
					$this->load->view('backend/spj/lists_transport_honor', $data);
				}
			}
			else {
				redirect(base_url("/admin/spj/"));
			}
		}
		else {
			redirect(base_url("/admin/spj/"));
		}
	}
	
	
	public function peserta ($id_spj = "") {
		$this->auth->login();
		
		$this->detailSpj("peserta", $id_spj);
	}
	
	public function narasumber ($id_spj = "") {
		$this->auth->login();
		
		$this->detailSpj("narasumber", $id_spj);
	}
	
	public function panitia ($id_spj = "") {
		$this->auth->login();
		
		$this->detailSpj("panitia", $id_spj);
	}
	
	public function fasilitator ($id_spj = "") {
		$this->auth->login();
		
		$this->detailSpj("fasilitator", $id_spj);
	}
	
	public function instruktur ($id_spj = "") {
		$this->auth->login();
		
		$this->detailSpj("instruktur", $id_spj);
	}
	
	public function pengajar_praktek ($id_spj = "") {
		$this->auth->login();
		
		$this->detailSpj("pengajar_praktek", $id_spj);
	}
	
	
	
	public function saveOption () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Ulangi lagi, terjadi kesalahan";
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["spj_id"];
			$unsur = $_POST["unsur"];
			
			$data = array();
			$data["based_".$unsur] = json_encode($_POST["based"]);
			
			$this->spj_model->save($data, $id);
			
			
			$spj = $this->spj_model->getById($id);
			
			if (!empty($spj)) {
				$kegiatan = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);
				
				$based = $this->decodeBased($spj["based_".$unsur]);
				
				if ($unsur == "narasumber") {
					$items = $this->spj_narasumber_model->getBySpjId($id);
				}
				else if ($unsur == "panitia") {
					$items = $this->spj_panitia_model->getBySpjId($id);
				}
				else if ($unsur == "peserta") {
					$items = $this->spj_peserta_model->getBySpjId($id);
				}
				else if ($unsur == "fasilitator") {
					$items = $this->spj_fasilitator_model->getBySpjId($id);
				}
				else if ($unsur == "instruktur") {
					$items = $this->spj_instruktur_model->getBySpjId($id);
				}
				else if ($unsur == "pengajar_praktek") {
					$items = $this->spj_pengajar_praktek_model->getBySpjId($id);
				}
				
			
				if (!empty($items)) {
					foreach ($items as $item) {
						
						if ($item["kunci"] == "1") {
							continue;
						}
						
						$transport = 0;
						
						if (!empty($based)) {
							foreach ($based as $optKey => $optVal) {
								$itemArea = "transport_".strtolower($item["transport_asal"]);
								
								if ($optKey == $itemArea) {
									$transport = $optVal;
								}
							}
						}
						
						$tgl_surat = (isset($based["tgl_surat"]) ? date("Y-m-d", strtotime(str_replace("/","-",$based["tgl_surat"]))) : "");
												
						$tgl_kuitansi = (isset($based["tgl_kuitansi"]) ? date("Y-m-d", strtotime(str_replace("/","-",$based["tgl_kuitansi"]))) : "");
						
						$data = array();
						
						$data["dipa_program"] = (isset($based["dipa_program"]) ? $based["dipa_program"] : "");
						$data["dipa_kegiatan"] = (isset($based["dipa_kegiatan"]) ? $based["dipa_kegiatan"] : "");
						$data["dipa_kro"] = (isset($based["dipa_kro"]) ? $based["dipa_kro"] : "");
						$data["dipa_ro"] = (isset($based["dipa_ro"]) ? $based["dipa_ro"] : "");
						$data["dipa_komponen"] = (isset($based["dipa_komponen"]) ? $based["dipa_komponen"] : "");
						$data["dipa_sub_komponen"] = (isset($based["dipa_sub_komponen"]) ? $based["dipa_sub_komponen"] : "");
						$data["dipa_akun_transport"] = (isset($based["dipa_akun_transport"]) ? $based["dipa_akun_transport"] : "");
						$data["nomor_surat"] = (isset($based["nomor_surat"]) ? $based["nomor_surat"] : "");
						$data["tgl_surat"] = $tgl_surat;
						
						$data["deskripsi_kuitansi"] = (isset($based["deskripsi_kuitansi"]) ? $based["deskripsi_kuitansi"] : "");
						$data["kab_kuitansi"] = (isset($based["kab_kuitansi"]) ? $based["kab_kuitansi"] : "");
						$data["tgl_kuitansi"] = $tgl_kuitansi;
						
						
						if ($unsur != "peserta") {
							$tgl_honor = (isset($based["tgl_honor"]) ? date("Y-m-d", strtotime(str_replace("/","-",$based["tgl_honor"]))) : "");

							$pajakGolongan = $this->config->item("golongan_pajak");

							$pajak = 0;
							if (isset($pajakGolongan[$item["golongan"]])) {
								$pajak = $pajakGolongan[$item["golongan"]];
							}

							if ((!empty($item["npwp"]) && $item["npwp"] != "-") && empty($item["golongan"]))  {
								$pajak = $pajakGolongan["-"];
							}

							$data["honor"] = (isset($based["honor"]) ? $based["honor"] : "0");
							$data["pajak"] = $pajak;
							$data["jam_honor"] = (isset($based["vol_honor"]) ? $based["vol_honor"] : "1");
							$data["satuan_honor"] = (isset($based["satuan_honor"]) ? $based["satuan_honor"] : "jam");
							$data["keterangan_honor"] = (isset($based["keterangan_honor"]) ? $based["keterangan_honor"] : "");
							$data["deskripsi_honor"] = (isset($based["deskripsi_honor"]) ? $based["deskripsi_honor"] : "");
							$data["kab_honor"] = (isset($based["kab_honor"]) ? $based["kab_honor"] : "");
							$data["tgl_honor"] = $tgl_honor;
						}
						
						
						$data["transport"] = $transport;
						$data["keterangan_transport"] = (isset($based["keterangan_transport"]) ? $based["keterangan_transport"] : "");
						$data["transport_lainnya"] = (isset($based["transport_lainnya"]) ? $based["transport_lainnya"] : 0);
						$data["keterangan_transport_lainnya"] = (isset($based["keterangan_transport_lainnya"]) ? $based["keterangan_transport_lainnya"] : "");
						
						$data["uang_harian"] = (isset($based["uang_harian"]) ? $based["uang_harian"] : 0);
						$data["keterangan_uang_harian"] = (isset($based["keterangan_uang_harian"]) ? $based["keterangan_uang_harian"] : "");
						
						
						if ($unsur == "narasumber") {
							$this->spj_narasumber_model->save($data, $item["id"]);
						}
						else if ($unsur == "panitia") {
							$this->spj_panitia_model->save($data, $item["id"]);
						}
						else if ($unsur == "peserta") {
							$this->spj_peserta_model->save($data, $item["id"]);
						}
						else if ($unsur == "fasilitator") {
							$this->spj_fasilitator_model->save($data, $item["id"]);
						}
						else if ($unsur == "instruktur") {
							$this->spj_instruktur_model->save($data, $item["id"]);
						}
						else if ($unsur == "pengajar_praktek") {
							$this->spj_pengajar_praktek_model->save($data, $item["id"]);
						}
					}
				}
			}
			
			$out["error"] = false;
			$out["msg"] = "Berhasil menerapkan opsi";
		}
		
		print json_encode($out);
	}
	
	public function importData () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Ulangi lagi, terjadi kesalahan";
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["spj_id"];
			$unsur = $_POST["unsur"];
			
			$spj = $this->spj_model->getById($id);
			
			if (!empty($spj)) {
				$kegiatan = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);
				
				$based = $this->decodeBased($spj["based_".$unsur]);
				
				// Items Kegiatan
				if ($unsur == "narasumber") {
					$items = $this->narasumber_model->getNarasumberKegiatan($kegiatan["id"], true);
				}
				else if ($unsur == "panitia") {
					$items = $this->panitia_model->getPanitiaKegiatan($kegiatan["id"], true);
				}
				else if ($unsur == "peserta") {
					$items = $this->peserta_model->getPesertaKegiatan($kegiatan["id"], true);
				}
				else if ($unsur == "fasilitator") {
					$items = $this->fasilitator_model->getByKegiatan($kegiatan["id"], true);
				}
				else if ($unsur == "instruktur") {
					$items = $this->instruktur_model->getByKegiatan($kegiatan["id"], true);
				}
				else if ($unsur == "pengajar_praktek") {
					$items = $this->pengajar_praktek_model->getByKegiatan($kegiatan["id"], true);
				}
				
				
				// PPK dan BP
				$ppk = array("id" => 0);
				$bp = array("id" => 0);
				
				$this->load->model("pengaturan_model");
				$this->load->model("biodata_model");

				$pejabatPPK = $this->pengaturan_model->getPengaturanBySistem("ppk");

				if (!empty($pejabatPPK)) {
					$biodataId = $pejabatPPK["value"];

					$ppk = $this->biodata_model->getBiodataById($biodataId);
				}
				
				$pejabatBP = $this->pengaturan_model->getPengaturanBySistem("bp");

				if (!empty($pejabatBP)) {
					$biodataId = $pejabatBP["value"];

					$bp = $this->biodata_model->getBiodataById($biodataId);
				}
				
				
				
				// Delete Item Tidak Di Lock
				if ($unsur == "narasumber") {
					$this->spj_narasumber_model->deleteBySpjId($spj["id"], "0");
				}
				else if ($unsur == "panitia") {
					$this->spj_panitia_model->deleteBySpjId($spj["id"], "0");
				}
				else if ($unsur == "peserta") {
					$this->spj_peserta_model->deleteBySpjId($spj["id"], "0");
				}
				else if ($unsur == "fasilitator") {
					$this->spj_fasilitator_model->deleteBySpjId($spj["id"], "0");
				}
				else if ($unsur == "instruktur") {
					$this->spj_instruktur_model->deleteBySpjId($spj["id"], "0");
				}
				else if ($unsur == "pengajar_praktek") {
					$this->spj_pengajar_praktek_model->deleteBySpjId($spj["id"], "0");
				}
				
				
				// Items Kegiatan
				if ($unsur == "narasumber") {
					$imported = $this->spj_narasumber_model->getBySpjId($spj["id"]);
				}
				else if ($unsur == "panitia") {
					$imported = $this->spj_panitia_model->getBySpjId($spj["id"]);
				}
				else if ($unsur == "peserta") {
					$imported = $this->spj_peserta_model->getBySpjId($spj["id"]);
				}
				else if ($unsur == "fasilitator") {
					$imported = $this->spj_fasilitator_model->getBySpjId($spj["id"]);
				}
				else if ($unsur == "instruktur") {
					$imported = $this->spj_instruktur_model->getBySpjId($spj["id"]);
				}
				else if ($unsur == "pengajar_praktek") {
					$imported = $this->spj_pengajar_praktek_model->getBySpjId($spj["id"]);
				}
				
				
				$importedItem = array();
				
				if (!empty($imported)) {
				    foreach ($imported as $im) {
				        $importedItem[$im[$unsur."_id"]] = $im;
				    }    
				}
				
				
				if (!empty($items)) {
					$no_urut = 1;
					
					foreach ($items as $item) {
						
						// Formating Data
						if ($item["nip"] == "-" || $item["nip"] == "0") {
							$item["nip"] = "";
						}
						
						if (($item["pangkat"] == "-" || empty($item["pangkat"])) && ($item["golongan"] == "-" || empty($item["golongan"]))) {
							$item["pangkat"] = "-";
							$item["golongan"] = "";
						}
						
						$transport = 0;
						
						if (!empty($based)) {
							foreach ($based as $optKey => $optVal) {
								$itemArea = "transport_".strtolower($item["kab_unit_kerja"]);
								
								if ($optKey == $itemArea) {
									$transport = $optVal;
								}
							}
						}
						
						$tgl_surat = (isset($based["tgl_surat"]) ? date("Y-m-d", strtotime(str_replace("/","-",$based["tgl_surat"]))) : "");
						
						$tgl_kuitansi = (isset($based["tgl_kuitansi"]) ? date("Y-m-d", strtotime(str_replace("/","-",$based["tgl_kuitansi"]))) : "");
						
						
						
						// Prepare Data To Save
						$data = array();
						$data["no_urut"] = $no_urut;
						
						if (isset($importedItem[$item["id"]])) {
							// Update No Urut Lock Item
						    $itemId = $importedItem[$item["id"]]["id"];
							
							if ($unsur == "narasumber") {
								$this->spj_narasumber_model->save($data, $itemId);
							}
							else if ($unsur == "panitia") {
								$this->spj_panitia_model->save($data, $itemId);
							}
							else if ($unsur == "peserta") {
								$this->spj_peserta_model->save($data, $itemId);
							}
							else if ($unsur == "fasilitator") {
								$this->spj_fasilitator_model->save($data, $itemId);
							}
							else if ($unsur == "instruktur") {
								$this->spj_instruktur_model->save($data, $itemId);
							}
							else if ($unsur == "pengajar_praktek") {
								$this->spj_pengajar_praktek_model->save($data, $itemId);
							}
						}
						else {
							// Insert New Peserta
							$data["spj_id"] = $id;
						    $data[$unsur."_id"] = $item["id"];
							
    						$data["dipa_program"] = (isset($based["dipa_program"]) ? $based["dipa_program"] : "");
							$data["dipa_kegiatan"] = (isset($based["dipa_kegiatan"]) ? $based["dipa_kegiatan"] : "");
							$data["dipa_kro"] = (isset($based["dipa_kro"]) ? $based["dipa_kro"] : "");
							$data["dipa_ro"] = (isset($based["dipa_ro"]) ? $based["dipa_ro"] : "");
							$data["dipa_komponen"] = (isset($based["dipa_komponen"]) ? $based["dipa_komponen"] : "");
							$data["dipa_sub_komponen"] = (isset($based["dipa_sub_komponen"]) ? $based["dipa_sub_komponen"] : "");
    						$data["dipa_akun_transport"] = (isset($based["dipa_akun_transport"]) ? $based["dipa_akun_transport"] : "");
							$data["dipa_akun_honor"] = (isset($based["dipa_akun_honor"]) ? $based["dipa_akun_honor"] : "");
    						$data["nomor_surat"] = (isset($based["nomor_surat"]) ? $based["nomor_surat"] : "");
    						$data["tgl_surat"] = $tgl_surat;
							
							$data["deskripsi_kuitansi"] = (isset($based["deskripsi_kuitansi"]) ? $based["deskripsi_kuitansi"] : "");
    						$data["kab_kuitansi"] = (isset($based["kab_kuitansi"]) ? $based["kab_kuitansi"] : "");
    						$data["tgl_kuitansi"] = $tgl_kuitansi;
							
							
							if ($unsur != "peserta") {
								$tgl_honor = (isset($based["tgl_honor"]) ? date("Y-m-d", strtotime(str_replace("/","-",$based["tgl_honor"]))) : "");
								
								$pajakGolongan = $this->config->item("golongan_pajak");
								
								$pajak = 0;
								if (isset($pajakGolongan[$item["golongan"]])) {
									$pajak = $pajakGolongan[$item["golongan"]];
								}
								
								if ((!empty($item["npwp"]) && $item["npwp"] != "-") && empty($item["golongan"]))  {
									$pajak = $pajakGolongan["-"];
								}
								
								$data["honor"] = (isset($based["honor"]) ? $based["honor"] : "0");
								$data["pajak"] = $pajak;
								$data["jam_honor"] = (isset($based["vol_honor"]) ? $based["vol_honor"] : "1");
								$data["satuan_honor"] = (isset($based["satuan_honor"]) ? $based["satuan_honor"] : "jam");
								$data["deskripsi_honor"] = (isset($based["deskripsi_honor"]) ? $based["deskripsi_honor"] : "");
								$data["kab_honor"] = (isset($based["kab_honor"]) ? $based["kab_honor"] : "");
								$data["tgl_honor"] = $tgl_honor;
							}
							
							$data["ktp"] = $item["ktp"];
    						$data["nama"] = $item["nama"];
    						$data["nip"] = $item["nip"];
    						$data["pangkat"] = $item["pangkat"];
							$data["golongan"] = $item["golongan"];
							$data["jabatan"] = $item["jabatan"];
							$data["npwp"] = $item["npwp"];
    						$data["unit_kerja"] = $item["unit_kerja"];
    						$data["nama_bank"] = $item["nama_bank"];
    						$data["no_rekening"] = $item["no_rekening"];
    						$data["nama_pemilik_rekening"] = $item["nama_pemilik_rekening"];
							
    						$data["transport_asal"] = $item["kab_unit_kerja"];
    						$data["transport_tujuan"] = $kegiatan["kab_tempat_kegiatan"];
    						$data["transport"] = $transport;
							$data["keterangan_transport"] = (isset($based["keterangan_transport"]) ? $based["keterangan_transport"] : "");
    						$data["transport_lainnya"] = (isset($based["transport_lainnya"]) ? $based["transport_lainnya"] : "0");
    						$data["keterangan_transport_lainnya"] = (isset($based["keterangan_transport_lainnya"]) ? $based["keterangan_transport_lainnya"] : "");
							
    						$data["uang_harian"] = (isset($based["uang_harian"]) ? $based["uang_harian"] : 0);
    						$data["keterangan_uang_harian"] = (isset($based["keterangan_uang_harian"]) ? $based["keterangan_uang_harian"] : "");
    						
							
    						$data["ppk"] = $ppk["id"];
    						$data["bp"] = $bp["id"];
							
							
							if ($unsur == "narasumber") {
								$this->spj_narasumber_model->save($data);
							}
							else if ($unsur == "panitia") {
								$this->spj_panitia_model->save($data);
							}
							else if ($unsur == "peserta") {
								$this->spj_peserta_model->save($data);
							}
							else if ($unsur == "fasilitator") {
								$this->spj_fasilitator_model->save($data);
							}
							else if ($unsur == "instruktur") {
								$this->spj_instruktur_model->save($data);
							}
							else if ($unsur == "pengajar_praktek") {
								$this->spj_pengajar_praktek_model->save($data);
							}
						}
						
						$no_urut++;
					}
				}
				
				
			}
			
			$out["error"] = false;
			$out["msg"] = "Berhasil mengimport item kegiatan";
		}
		
		print json_encode($out);
	}
	
	
	
	public function updatePrint () {
		$out = array();
		$out["error"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST["id"];
			$table = $_POST["table"];
			
			$data = array();
			$data["print"] = $_POST["value"];
			
			if ($table == "spj_kegiatan_peserta") {
				$this->spj_peserta_model->save($data, $id);
			}
			else if ($table == "spj_kegiatan_narasumber") {
				$this->spj_narasumber_model->save($data, $id);
			}
			else if ($table == "spj_kegiatan_panitia") {
				$this->spj_panitia_model->save($data, $id);
			}
			else if ($table == "spj_kegiatan_fasilitator") {
				$this->spj_fasilitator_model->save($data, $id);
			}
			else if ($table == "spj_kegiatan_instruktur") {
				$this->spj_instruktur_model->save($data, $id);
			}
			else if ($table == "spj_kegiatan_pengajar_praktek") {
				$this->spj_pengajar_praktek_model->save($data, $id);
			}
			
			$out["error"] = false;
		}
		
		print json_encode($out);
	}
	
	
	
	
	
	public function save_manual_peserta () {
		$this->auth->login();
		
		$out = array();
		$out["error"] = false;
		$out["msg"] = "Berhasil menyimpan SPJ Peserta!";
		$out["close_modal"] = true;
		$out["reload_table"] = true;
		
		if (isset($_POST) && !empty($_POST)) {
			$data = $_POST;
			
			$id = (isset($data["id"]) ? $data["id"] : "");

			unset($data["id"]);
			
			if (isset($data["tgl_kuitansi"]) && !empty($data["tgl_kuitansi"])) {
				$data["tgl_kuitansi"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$data["tgl_kuitansi"])));
			}
			
			$id = $this->spj_peserta_model->save($data, $id);
			
			if (empty($id)) {
				$out["error"] = true;
				$out["msg"] = "Gagal menyimpan SPJ Peserta. Silahkan coba lagi!";
			}
		}
		
		print json_encode($out);
		exit();
	}
	
	public function generate ($unsur = "", $id = "") {
		$this->auth->login();
		
		if (empty($unsur) || empty($id)) {
			$this->load->view('frontend/errors/logo');
		}
		else {
			
			// DEFINE VARIABLE GLOBAL
			$data = array();
			$html = "";
			
			// GET DATA ITEM
			if ($unsur == "narasumber") {
				$item = $this->spj_narasumber_model->getById($id);
				$item["kode_unsur"] = "NS";
			}
			else if ($unsur == "panitia") {
				$item = $this->spj_panitia_model->getById($id);
				$item["kode_unsur"] = "PN";
			}
			else if ($unsur == "peserta") {
				$item = $this->spj_peserta_model->getById($id);
				$item["kode_unsur"] = "PS";
			}
			else if ($unsur == "fasilitator") {
				$item = $this->spj_fasilitator_model->getById($id);
				$item["kode_unsur"] = "FS";
			}
			else if ($unsur == "instruktur") {
				$item = $this->spj_instruktur_model->getById($id);
				$item["kode_unsur"] = "IN";
			}
			else if ($unsur == "pengajar_praktek") {
				$item = $this->spj_pengajar_praktek_model->getById($id);
				$item["kode_unsur"] = "PP";
			}
			
			
			
			if (!empty($item)) {
				// GET DATA SPJ
				$spj = $this->spj_model->getById($item["spj_id"]);

				if (!empty($spj)) {
					
					$spj["based_peserta"] = $this->decodeBased($spj["based_peserta"]);
					$spj["based_narasumber"] = $this->decodeBased($spj["based_narasumber"]);
					$spj["based_panitia"] = $this->decodeBased($spj["based_panitia"]);
					$spj["based_fasilitator"] = $this->decodeBased($spj["based_fasilitator"]);
					$spj["based_instruktur"] = $this->decodeBased($spj["based_instruktur"]);
					$spj["based_pengajar_praktek"] = $this->decodeBased($spj["based_pengajar_praktek"]);
					
					$data["spj"] = $spj;


					// GET DATA SATKER
					$this->load->model("pengaturan_model");
					$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");

					if (!empty($pengaturan)) {
						foreach ($pengaturan as $foo) {
							$data["satker"][$foo["sistem"]] = $foo["value"];
						}
					}


					// GET DATA PEGAWAI BALAI
					$this->load->model("biodata_model");
					$pegawais = $this->biodata_model->getBiodataByPegawaiBalai();

					$pegawai = array();
					if (!empty($pegawais)) {
						foreach ($pegawais as $peg) {
							$pegawai[$peg["id"]] = $peg;
						}
					}

					$data["pejabat"]["ppk"] = array(
						"nip" => "",
						"nama" => ""
					);

					$data["pejabat"]["bp"] = array(
						"nip" => "",
						"nama" => ""
					);


					// GET DATA KEGIATAN
					$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);

					
					// DEFINE VALUE
					if (empty($item["transport"])) {
						$item["transport"] = 0;
					}

					if (empty($item["uang_harian"])) {
						$item["uang_harian"] = 0;
					}

					if (empty($item["transport_lainnya"])) {
						$item["transport_lainnya"] = 0;
					}
					
					if (isset($item["honor"]) && empty($item["honor"])) {
						$item["honor"] = 0;
					}


					$data["item"] = $item;

					if (!empty($item["ppk"]) && isset($pegawai[$item["ppk"]])) {
						$data["pejabat"]["ppk"] = array(
							"nip" => $pegawai[$item["ppk"]]["nip"],
							"nama" => $pegawai[$item["ppk"]]["nama"]
						);
					}

					if (!empty($item["bp"]) && isset($pegawai[$item["bp"]])) {
						$data["pejabat"]["bp"] = array(
							"nip" => $pegawai[$item["bp"]]["nip"],
							"nama" => $pegawai[$item["bp"]]["nama"]
						);
					}
					
					
					// GET BIODATA PESERTA
					if ($unsur == "narasumber") {
						$biodata = $this->narasumber_model->getNarasumberById($item["narasumber_id"]);
					}
					else if ($unsur == "panitia") {
						$biodata = $this->panitia_model->getPanitiaById($item["panitia_id"]);
					}
					else if ($unsur == "peserta") {
						$biodata = $this->peserta_model->getPesertaById($item["peserta_id"]);
					}
					else if ($unsur == "fasilitator") {
						$biodata = $this->fasilitator_model->getById($item["fasilitator_id"]);
					}
					else if ($unsur == "instruktur") {
						$biodata = $this->instruktur_model->getById($item["instruktur_id"]);
					}
					else if ($unsur == "pengajar_praktek") {
						$biodata = $this->pengajar_praktek_model->getById($item["pengajar_praktek_id"]);
					}
					
					$data["biodata"] = $biodata;
					$data["type"] = ucfirst($unsur);
					
					
					$html .= $this->load->view('template/sppd_depan', $data, true);
					$html .= "<pagebreak />";
					$html .= $this->load->view('template/rincian_perjadin', $data, true);
					$html .= "<pagebreak />";
					$html .= $this->load->view('template/daftar_pengeluaran_riil', $data, true);
					
					$printKuitansiHonor = 1;
					
					if ($unsur == "peserta") {
						$printKuitansiHonor = 0;
					}
					
					if ($data["item"]["honor"] == "0") {
						$printKuitansiHonor = 0;
					}
					
					if ($printKuitansiHonor) {
						$html .= "<pagebreak />";
						$html .= $this->load->view('template/kuitansi_honor', $data, true);
					}
					
					$html .= "<pagebreak />";
					$html .= $this->load->view('template/biodata', $data, true);
					
					
					
					$this->mpdf->createSPJ($html,"spj_".$unsur."_".$item["id"], false);
				}
				else {
					$this->load->view('frontend/errors/logo');
				}
			}
			else {
				$this->load->view('frontend/errors/logo');
			}
		}
	}
	
	
	
	
	
	public function printSpby () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Ulangi lagi, terjadi kesalahan";
		
		if (isset($_POST) && !empty($_POST)) {
			$spjId = $_POST["spjId"];
			$table = $_POST["table"];
			
			$spj = $this->spj_model->getById($spjId);

			if (!empty($spj)) {
				
				$spj["based_peserta"] = $this->decodeBased($spj["based_peserta"]);
				$spj["based_narasumber"] = $this->decodeBased($spj["based_narasumber"]);
				$spj["based_panitia"] = $this->decodeBased($spj["based_panitia"]);
				$spj["based_fasilitator"] = $this->decodeBased($spj["based_fasilitator"]);
				$spj["based_instruktur"] = $this->decodeBased($spj["based_instruktur"]);
				$spj["based_pengajar_praktek"] = $this->decodeBased($spj["based_pengajar_praktek"]);

				$data["spj"] = $spj;
				
				if ($table == "spj_kegiatan_peserta") {
					$based = $spj["based_peserta"];
				}
				else if ($table == "spj_kegiatan_narasumber") {
					$based = $spj["based_narasumber"];
				}
				else if ($table == "spj_kegiatan_panitia") {
					$based = $spj["based_panitia"];
				}
				else if ($table == "spj_kegiatan_fasilitator") {
					$based = $spj["based_fasilitator"];
				}
				else if ($table == "spj_kegiatan_instruktur") {
					$based = $spj["based_instruktur"];
				}
				else if ($table == "spj_kegiatan_pengajar_praktek") {
					$based = $spj["based_pengajar_praktek"];
				}
				
				
				if (!empty($based)) {
					$spby = $this->spby_model->getSpbyKegiatanBySpjId($table, $spj["id"], $based["dipa_akun_transport"]);
					
					$spbyId = 0;

					if (!empty($spby)) {
						$spbyId = $spby["id"];
					}
					
					// SPBY Transport
					$data = array();
					$data[$table] = $spj["id"];
					$data["dipa_program"] = $based["dipa_program"];
					$data["dipa_kegiatan"] = $based["dipa_kegiatan"];
					$data["dipa_kro"] = $based["dipa_kro"];
					$data["dipa_ro"] = $based["dipa_ro"];
					$data["dipa_komponen"] = $based["dipa_komponen"];
					$data["dipa_sub_komponen"] = $based["dipa_sub_komponen"];
					$data["dipa_akun"] = $based["dipa_akun_transport"];
					$data["deskripsi"] = $based["deskripsi_spby"];
					$data["bukti_pembelian"] = $based["bukti_pembelian_spby"];
					$data["bukti_penerimaan"] = $based["bukti_penerimaan_spby"];
					$data["kab_spby"] = $based["kab_spby"];
					$data["tgl_spby"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$based["tgl_spby"])));
					$data["nominal"] = 0;

					// GET BY SPJ
					if ($table == "spj_kegiatan_peserta") {
						$items = $this->spj_peserta_model->getBySpjId($spj["id"]);
					}
					else if ($table == "spj_kegiatan_narasumber") {
						$items = $this->spj_narasumber_model->getBySpjId($spj["id"]);
					}
					else if ($table == "spj_kegiatan_panitia") {
						$items = $this->spj_panitia_model->getBySpjId($spj["id"]);
					}
					else if ($table == "spj_kegiatan_fasilitator") {
						$items = $this->spj_fasilitator_model->getBySpjId($spj["id"]);
					}
					else if ($table == "spj_kegiatan_instruktur") {
						$items = $this->spj_instruktur_model->getBySpjId($spj["id"]);
					}
					else if ($table == "spj_kegiatan_pengajar_praktek") {
						$items = $this->spj_pengajar_praktek_model->getBySpjId($spj["id"]);
					}


					if (!empty($items)) {
						foreach ($items as $item) {
							if ($item["id"] == $based["penerima_spby"]) {
								$data["penerima"] = $item["nama"];
								$data["nip_penerima"] = $item["nip"];

								if ($based["penerima_spby_dkk"] == "1") {
									$data["penerima"] .= ", dkk.";
								}
							}

							$data["nominal"] += $item["transport"] + $item["transport_lainnya"] + $item["uang_harian"];
						}
					}


					if (empty($spbyId)) {
						$this->load->model("pengaturan_model");
						$ppk = $this->pengaturan_model->getPengaturanBySistem("ppk");
						$bp = $this->pengaturan_model->getPengaturanBySistem("bp");

						$data["ppk"] = $ppk["value"];
						$data["bp"] = $bp["value"];
					}

					$spbyId = $this->spby_model->save($data, $spbyId);
					
					
					// SPBY Honor
					if ($table != "spj_kegiatan_peserta") {
						
						$spby = $this->spby_model->getSpbyKegiatanBySpjId($table, $spj["id"], $based["dipa_akun_honor"]);
					
						$spbyId = 0;

						if (!empty($spby)) {
							$spbyId = $spby["id"];
						}
						
						$data = array();
						$data[$table] = $spj["id"];
						$data["dipa_program"] = $based["dipa_program"];
						$data["dipa_kegiatan"] = $based["dipa_kegiatan"];
						$data["dipa_kro"] = $based["dipa_kro"];
						$data["dipa_ro"] = $based["dipa_ro"];
						$data["dipa_komponen"] = $based["dipa_komponen"];
						$data["dipa_sub_komponen"] = $based["dipa_sub_komponen"];
						$data["dipa_akun"] = $based["dipa_akun_honor"];
						$data["deskripsi"] = $based["deskripsi_spby_honor"];
						$data["bukti_pembelian"] = $based["bukti_pembelian_spby_honor"];
						$data["bukti_penerimaan"] = $based["bukti_penerimaan_spby_honor"];
						$data["kab_spby"] = $based["kab_spby_honor"];
						$data["tgl_spby"] = date("Y-m-d",strtotime(str_replace(array("/"),array("-"),$based["tgl_spby_honor"])));
						$data["nominal"] = 0;


						if (!empty($items)) {
							foreach ($items as $item) {
								if ($item["id"] == $based["penerima_spby_honor"]) {
									$data["penerima"] = $item["nama"];
									$data["nip_penerima"] = $item["nip"];

									if ($based["penerima_spby_honor_dkk"] == "1") {
										$data["penerima"] .= ", dkk.";
									}
								}

								$data["nominal"] += ($item["honor"] * $item["jam_honor"]);
							}
						}


						if (empty($spbyId)) {
							$this->load->model("pengaturan_model");
							$ppk = $this->pengaturan_model->getPengaturanBySistem("ppk");
							$bp = $this->pengaturan_model->getPengaturanBySistem("bp");

							$data["ppk"] = $ppk["value"];
							$data["bp"] = $bp["value"];
						}

						$spbyId = $this->spby_model->save($data, $spbyId);
					}

					if (!empty($spbyId)) {
						$out["error"] = false;
						$out["msg"] = "Berhasil print spby peserta";
					}
				}
				else {
					$out["msg"] = "Mohon mengisi rincian SPBy terlebih dulu";
				}
			}
		}
		
		print json_encode($out);
	}
	
	
	
	
	public function generateDaftarPenerimaan ($type = "peserta", $spjId = "") {
		$data = array();
		$spj = $this->spj_model->getById($spjId);
		
		$spj["based_peserta"] = $this->decodeBased($spj["based_peserta"]);
		$spj["based_narasumber"] = $this->decodeBased($spj["based_narasumber"]);
		$spj["based_panitia"] = $this->decodeBased($spj["based_panitia"]);
		$spj["based_fasilitator"] = $this->decodeBased($spj["based_fasilitator"]);
		$spj["based_instruktur"] = $this->decodeBased($spj["based_instruktur"]);
		$spj["based_pengajar_praktek"] = $this->decodeBased($spj["based_pengajar_praktek"]);

		if (!empty($spj)) {
			
			$data["unsur"] = $type;
				
			// Kegiatan
			$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($spj["kegiatan_id"]);
			
			
			// Parse Data
			$table = "spj_kegiatan_peserta";
			$based = $spj["based_peserta"];
			
			if ($type == "narasumber") {
				$table = "spj_kegiatan_narasumber";
				$based = $spj["based_narasumber"];
			}
			else if ($type == "fasilitator") {
				$table = "spj_kegiatan_fasilitator";
				$based = $spj["based_fasilitator"];
			}
			else if ($type == "instruktur") {
				$table = "spj_kegiatan_instruktur";
				$based = $spj["based_instruktur"];
			}
			else if ($type == "pengajar_praktek") {
				$table = "spj_kegiatan_pengajar_praktek";
				$based = $spj["based_pengajar_praktek"];
			}
			else if ($type == "panitia") {
				$table = "spj_kegiatan_panitia";
				$based = $spj["based_panitia"];
			}
			
			
			// Prepare to Generate SPBY
			$html = "";
			
			// GET DATA SATKER
			$this->load->model("pengaturan_model");
			$pengaturan = $this->pengaturan_model->getPengaturanBySection("satker");

			if (!empty($pengaturan)) {
				foreach ($pengaturan as $foo) {
					$data["satker"][$foo["sistem"]] = $foo["value"];
				}
			}

			// GET DATA PEGAWAI BALAI
			$this->load->model("biodata_model");
			$pegawais = $this->biodata_model->getBiodataByPegawaiBalai();

			$pegawai = array();
			if (!empty($pegawais)) {
				foreach ($pegawais as $peg) {
					$pegawai[$peg["id"]] = $peg;
				}
			}
			
			// PEJABAT
			$bp = array();
			$pejabatBP = $this->pengaturan_model->getPengaturanBySistem("bp");

			if (!empty($pejabatBP)) {
				$biodataId = $pejabatBP["value"];

				$bp = $this->biodata_model->getBiodataById($biodataId);
			}
			
			
			// SPBY Transport
			if ($table == "spj_kegiatan_peserta") {
				$items = $this->spj_peserta_model->getBySpjId($spj["id"]);
			}
			else if ($table == "spj_kegiatan_narasumber") {
				$items = $this->spj_narasumber_model->getBySpjId($spj["id"]);
			}
			else if ($table == "spj_kegiatan_panitia") {
				$items = $this->spj_panitia_model->getBySpjId($spj["id"]);
			}
			else if ($table == "spj_kegiatan_fasilitator") {
				$items = $this->spj_fasilitator_model->getBySpjId($spj["id"]);
			}
			else if ($table == "spj_kegiatan_instruktur") {
				$items = $this->spj_instruktur_model->getBySpjId($spj["id"]);
			}
			else if ($table == "spj_kegiatan_pengajar_praktek") {
				$items = $this->spj_pengajar_praktek_model->getBySpjId($spj["id"]);
			}
			
			
			// Prepare Data
			$data["items"] = $items;
			$data["bp"] = $bp;
			
			$html = $this->load->view('template/daftar_penerimaan_transport', $data, true);
			
			$this->mpdf->createSpj($html,"Daftar Penerimaan Transport", false);
			
			/*$data["spby"] = $this->spby_model->getSpbyKegiatanBySpjId($table, $spj["id"], $based["dipa_akun_transport"]);
			
			if (!empty($data["spby"])) {
				$data["pejabat"] = array();

				$data["pejabat"]["ppk"] = array(
					"nip" => $pegawai[$data["spby"]["ppk"]]["nip"],
					"nama" => $pegawai[$data["spby"]["ppk"]]["nama"]
				);

				$data["pejabat"]["bp"] = array(
					"nip" => $pegawai[$data["spby"]["bp"]]["nip"],
					"nama" => $pegawai[$data["spby"]["bp"]]["nama"]
				);
				
				$html = $this->load->view('template/spby', $data, true);
			}
			
			// SPBY Honor
			if ($table != "spj_kegiatan_peserta") {
				$data["spby"] = $this->spby_model->getSpbyKegiatanBySpjId($table, $spj["id"], $based["dipa_akun_honor"]);

				if (!empty($data["spby"])) {
					$data["pejabat"] = array();

					$data["pejabat"]["ppk"] = array(
						"nip" => $pegawai[$data["spby"]["ppk"]]["nip"],
						"nama" => $pegawai[$data["spby"]["ppk"]]["nama"]
					);

					$data["pejabat"]["bp"] = array(
						"nip" => $pegawai[$data["spby"]["bp"]]["nip"],
						"nama" => $pegawai[$data["spby"]["bp"]]["nama"]
					);
					
					if (!empty($html)) {
						$html .= "<pagebreak />";
					}
					
					$html .= $this->load->view('template/spby', $data, true);
				}
			}*/
			
			
			//$this->mpdf->createSpj($html,"spby", false);
		}
		else {
			$this->load->view('frontend/errors/logo');
		}
	}
	
}
