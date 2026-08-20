<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bootgrids extends CI_Controller {
	var $pegawaiBalai = array();
	var $admin = array();
	var $grid_db = '';
	
	function __construct() {
		parent::__construct();
		
		$this->load->model("biodata_model");
		$this->load->model("user_model");
		$this->getPegawaiBalai();
		$this->getAdmin();
	}
	
	protected function getPegawaiBalai () {
		$this->pegawaiBalai = $this->biodata_model->getBiodataByPegawaiBalai();
	}
	
	protected function getAdmin () {
		$this->admin = $this->user_model->getUser();
	}
	
	protected function format ($table, $res, $column) {
		
		if (strpos($column->field, ".") !== false) {
			$field = str_replace(".", "__", $column->field);
		}
		else {
			$field = $table."__".$column->field;
		}
		
		$value = $res[$field];
		$valueOri = $res[$field];
		
		// Cut Long Title
		if (isset($column->field) && ($column->field == "nama" || $column->field == "kutipan" || $column->field == "kegiatan.nama" || $column->field == "penugasan.nama" || $column->field == "judul")) {
			$length = strlen($value);
			
			if ($length >= 65) {
				//$value = '<i style="font-style:normal;" title="'.$value.'">'.substr($value, 0, 65)."...".'</i>';
			}
		}
		
		if (isset($column->format) && $column->format == "numeric") {
			$value = (int) $value; 
		}
		else if (isset($column->format) && $column->format == "feedback") {
			$text = "Tamu";
			$class = "label text-white theme-bg f-12";
			
			if (empty($value)) {
				$text = "Admin";
				$class = "label text-white label-secondary f-12";
			}
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "tiket_status") {
			$text = "Baru";
			$class = "label text-white theme-bg f-12";
			
			if ($value == "1") {
				$text = "Proses";
				$class = "label text-white theme-bg f-12";
			}
			else if ($value == "2") {
				$text = "Selesai";
				$class = "label text-white label-secondary f-12";
			}
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "tiket_feedback") {
			$text = "Ditanggapi";
			$class = "label text-white theme-bg f-12";
			
			if ($value == "1") {
				$text = "Menunggu";
				$class = "label theme-bg2 f-12 text-white";
			}
			else if ($value == "2") {
				$text = "Selesai";
				$class = "label text-white label-secondary f-12";
			}
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "spj_label") {
			
			if ($value == "baru") {
				$class = "label theme-bg2 f-12 text-white";
			}
			else if ($value = "proses") {
				$class = "label text-white theme-bg f-12";
			}
			else {
				$class = "label text-white label-secondary f-12";
			}
			
			
			$text = ucfirst($value);
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "rating") {
			$star = "";
			
			foreach (range(1,5) as $i) {
				if ($i <= $value) {
					$star .= '<i class="fas fa-star colored"></i>';
				}
				else {
					$star .= '<i class="fas fa-star darked"></i>';
				}
			}
			
			$value = $star;
		}
		else if (isset($column->format) && $column->format == "penugasan_status") {
			$operator = '<span class="icon-grey material-icons">&#xf108;</span>';
			$draft = '<span class="icon-green material-icons" title="Draft">&#xe873;</span>';
			$verif = '<span class="icon-grey material-icons" title="Belum Validasi">&#xf014;</span>';
			$verifWaiting = '<span class="icon-yellow material-icons" title="Proses Validasi">&#xf014;</span>';
			$verifDiscard = '<a href="javascript:;" onclick="Kepegawaian.showAlasanTolak(\''.$res['penugasan__id'].'\');"><span class="icon-red material-icons" title="Penugasan Ditolak">&#xf012;</span></a>';
			$verifApproved = '<span class="icon-green material-icons" title="Penugasan Disetujui">&#xe8e8;</span>';
			$petugas = '<span class="icon-grey material-icons" title="Belum Disposisi Petugas">&#xe851;</span>';
			$petugasBatal = '<span class="icon-red material-icons" title="Disposisi Petugas Dibatalkan">&#xe851;</span>';
			$petugasWaiting = '<span class="icon-yellow material-icons" title="Disposisi Petugas">&#xe851;</span>';
			$petugasAccept = '<span class="icon-green material-icons" title="Dilaporkan Petugas">&#xe851;</span>';
			$pembayaran = '<span class="icon-grey material-icons" title="Belum dibayarkan">&#xe263;</span>';
			$pembayaranDone = '<span class="icon-green material-icons" title="Telah dibayarkan">&#xe263;</span>';
			
			if ($value == "0") {
				$status = $draft;
				$status .= $operator;
				$status .= $verif;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "1") {
				$status = $draft;
				$status .= $operator;
				$status .= $verifWaiting;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "2") {
				$status = $draft;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasWaiting;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "3") {
				$status = $draft;
				$status .= $operator;
				$status .= $verifDiscard;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "4") {
				$status = $draft;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasAccept;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "5") {
				$status = $draft;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasAccept;
				$status .= $operator;
				$status .= $pembayaranDone;
			}
			else if ($value == "6") {
				$status = $draft;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasBatal;
				$status .= $operator;
				$status .= $pembayaran;
			}
			
			$value = $status;
		}
		else if (isset($column->format) && $column->format == "penugasan_item_status") {
			$operator = '<span class="icon-grey material-icons">&#xf108;</span>';
			$petugas = '<span class="icon-green material-icons" title="Penugasan Diterima">&#xe851;</span>';
			$petugasBatal = '<span class="icon-red material-icons" title="Penugasan Dibatalkan">&#xe851;</span>';
			$draft = '<span class="icon-grey material-icons" title="Laporan Belum Dibuat">&#xe873;</span>';
			$draftWaiting = '<span class="icon-yellow material-icons" title="Laporan Telah Dibuat">&#xe873;</span>';
			$draftDone = '<span class="icon-green material-icons" title="Laporan Telah Diajukan">&#xe873;</span>';
			$verif = '<span class="icon-grey material-icons" title="Belum Validasi Laporan">&#xf014;</span>';
			$verifWaiting = '<span class="icon-yellow material-icons" title="Proses Validasi Laporan">&#xf014;</span>';
			$verifDiscard = '<a href="javascript:;" onclick="User.showAlasanTolak(\''.$res['penugasan_item__id'].'\');"><span class="icon-red material-icons" title="Laporan Ditolak">&#xf012;</span></a>';
			$verifApproved = '<span class="icon-green material-icons" title="Laporan Disetujui">&#xe8e8;</span>';
			
			$pembayaran = '<span class="icon-grey material-icons" title="Belum dibayarkan">&#xe263;</span>';
			$pembayaranHold = '<span class="icon-red material-icons" title="Setorkan laporan ke keuangan">&#xe263;</span>';
			$pembayaranWaiting = '<span class="icon-yellow material-icons" title="Menunggu dibayarkan">&#xe263;</span>';
			$pembayaranDone = '<span class="icon-green material-icons" title="Telah dibayarkan">&#xe263;</span>';
			
			//if($_SERVER["REMOTE_ADDR"]=='180.249.186.103'){
				if (!empty($res["spj_item_id"])) {
					$this->load->model("spj_model");
					$spjItem = $this->spj_model->getItemById($res["spj_item_id"]);
					
					if (!empty($spjItem) && $spjItem["paid"] == "1") {
						$pembayaran = $pembayaranDone;
						$pembayaranWaiting = $pembayaranDone;
					}
				}
			//}
			
			if ($value == "0") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draft;
				$status .= $operator;
				$status .= $verif;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "1") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draftWaiting;
				$status .= $operator;
				$status .= $verif;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "2") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draftDone;
				$status .= $operator;
				$status .= $verifWaiting;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "3") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draftDone;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $pembayaranHold;
			}
			else if ($value == "4") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draftDone;
				$status .= $operator;
				$status .= $verifDiscard;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "5") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draftDone;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $pembayaranWaiting;
			}
			else if ($value == "6") {
				$status = $petugas;
				$status .= $operator;
				$status .= $draftDone;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $pembayaranDone;
			}
			else if ($value == "7") {
				$status = $petugasBatal;
				$status .= $operator;
				$status .= $draft;
				$status .= $operator;
				$status .= $verif;
				$status .= $operator;
				$status .= $pembayaran;
			}
			
			$value = $status;
		}
		elseif (isset($column->format) && $column->format == "button") {
			$text = "Button";
			$class = "btn btn-info btn-sm";
			$attr = 'data-'.$column->field.'="'.$value.'" data-table="'.$table.'"';
			
			if (isset($column->button) && isset($column->button->text)) {
				$text = $column->button->text;
			}
			
			if (isset($column->button) && isset($column->button->class)) {
				$class = $class." ".$column->button->class;
			}

			if (isset($column->button) && isset($column->button->title)) {
				$attr = $attr.' title="'.$column->button->title.'"';
			}
			
			if (isset($column->modal)) {
				$class = $class." row-event-click";
				$attr = $attr.' data-action="modal" data-modal-view="'.$column->modal->view.'"';
			}
			
			else if (isset($column->link)) {
				
				$class = $class." row-event-click";
				
				if (isset($column->link->url)) {
					$url = $column->link->url;
					
					if (isset($res) && !empty($res)) {
						foreach ($res as $resKey => $resVal) {
							$url = str_replace("{{".$resKey."}}",$resVal, $url);
						}
					}
					
					if (strpos($url, "http") === 0) {
						$url = $url;
					}
					else {
						$url = base_url($url);
					}
					
					$attr = $attr.' data-action="link" data-href="'.$url.'"';
				}
				
				if (isset($column->link->target)) {
					$target = $column->link->target;					
					$attr = $attr.' data-target="'.$target.'"';
				}
				
			}
			
			else if (isset($column->onclick)) {
				$attr = $attr.' onclick="'.$column->onclick.'"';
			}
			
			$showHide = true;
			
			if (isset($column->conditions) && !empty($column->conditions)) {
				$logic = "";
				foreach ($column->conditions as $con) {

					if (isset($con->field)) {
						$conField = str_replace(".","__",$con->field);

						if (isset($res[$conField])) {
							$logic .= $res[$conField].$con->operator.$con->value;
						}

					}
					else {
						$logic .= $con->operator;
					}
				}
				

				eval("\$showHide=$logic;");
			}
			
			if ($showHide) {
				$value = "<a href='javascript:;' class='".$class."' ".$attr.">".$text."</a>";
			}
			else {
				$value = '';
			}
		}
		elseif (isset($column->format) && $column->format == "surat_tugas") {
			$val = "";
			$class = "btn btn-info btn-sm row-event-click";
			$attr = 'data-'.$column->field.'="'.$value.'" data-table="'.$table.'" data-target="_blank"';
			
			
			if (isset($res) && !empty($res)) {
				foreach ($res as $resKey => $resVal) {
					if ($resKey == "surat_tugas" && $resVal != "") {
						$val = $resVal;
						$attr = $attr.' data-action="link" data-href="'.base_url($column->link->url.$resVal).'"';
					}
				}
			}
			
			if (!empty($val)) {
				$value = "<a href='javascript:;' class='".$class."' ".$attr."><i class='fas fa-book'></i> Surat Tugas</a>";
			}
		}
		elseif (isset($column->format) && $column->format == "buku_tabungan") {
			$bukuTabungan = base_url("/assets/buku_tabungan/tabungan_".$value.".jpg");
			$bukuPath = APPPATH . "../assets/buku_tabungan/tabungan_".$value.".jpg";
			
			if (file_exists($bukuPath)) {
				$value = "<a class='btn btn-info' href='".$bukuTabungan."?v=".rand()."' target='_blank'><i class='fas fa-book'></i> Lihat</a>";
			}
			else {
				$value = "";
			}
		}
		elseif (isset($column->format) && $column->format == "valid_rekening") {
			if ($value == "1") {
				$value = '<i class="icon-green fas fa-check-circle" style="font-size:20px; padding-right:15px;" title="Rekening Valid"></i>';
			}
			else {
				$value = '<i class="icon-red fas fa-exclamation-circle" style="font-size:20px; padding-right:15px;" title="Rekening Belum Valid"></i>';
			}
		}
		elseif (isset($column->format) && $column->format == "bukti_pengeluaran") {
			$bukuTabungan = base_url("/assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$value."/bukti_pengeluaran.pdf?v=".rand());
			$bukuPath = APPPATH . "../assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$value."/bukti_pengeluaran.pdf";
			
			if (file_exists($bukuPath)) {
				$value = "<a class='btn btn-info' href='".$bukuTabungan."' target='_blank'><i class='fas fa-book'></i> Bukti</a>";
			}
			else {
				$value = "";
			}
		}
		else if (isset($column->format) && $column->format == "date") {
			if (isset($column->date) && isset($column->date->format)) {
				$value = date($column->date->format, strtotime($value));
			}
		}
		else if (isset($column->format) && $column->format == "text_persen") {
			$value = $value."%";
		}
		else if (isset($column->format) && $column->format == "text_capitalize") {
			$value = ucfirst($value);
		}
		else if (isset($column->format) && $column->format == "NamaPegawaiBalai") {
			if (isset($this->pegawaiBalai) && !empty($this->pegawaiBalai)) {
				foreach ($this->pegawaiBalai as $pegawaiBalai) {
					if ($value == $pegawaiBalai["id"]) {
						$value = $pegawaiBalai["nama"];
					}
				}
			}
		}
		else if (isset($column->format) && $column->format == "nama_admin") {
			if (isset($this->admin) && !empty($this->admin)) {
				foreach ($this->admin as $admin) {
					if ($value == $admin["id"]) {
						$value = $admin["nama"];
					}
				}
			}
		}
		else if (isset($column->format) && $column->format == "formula_money" && isset($column->formula)) {
			$formula = $column->formula;
			
			foreach ($res as $key => $val) {
				$formula = str_replace(array("{{".$key."}}"),array($val),$formula);
			}
			
			if (stripos($formula, "/0") !== false) {
				$formula = str_replace(array("/0"),array("/1"),$formula);
			}
			
			eval( '$value = (' . $formula. ');' );
			
			$value = "Rp. ".number_format($value,0,",",".");
		}
		else if (isset($column->format) && $column->format == "formula_pct" && isset($column->formula)) {
			$formula = $column->formula;
			
			foreach ($res as $key => $val) {
				$formula = str_replace(array("{{".$key."}}"),array($val),$formula);
			}
			
			if (stripos($formula, "/0") !== false) {
				$formula = str_replace(array("/0"),array("/1"),$formula);
			}
			
			eval( '$value = (' . $formula. ');' );
			
			$value = round($value,2)."%";
		}
		else if (isset($column->format) && $column->format == "money") {
			$value = "Rp. ".number_format($value,0,",",".");
		}
		else if (isset($column->format) && $column->format == "day_date") {
			$value = $this->utility->formatDayDate($value);
		}
		else if (isset($column->format) && $column->format == "vol_honor") {
			$value = $value." ".$res[$table."__satuan_honor"];
		}
		else if (isset($column->format) && $column->format == "rkakl_detail_name") {
			$volumeText = $res["volume_1"]." ".$res["volume_satuan_1"];
			
			if (isset($res["volume_2"]) && !empty($res["volume_2"])) {
				$volumeText .= " x ".$res["volume_2"]." ".$res["volume_satuan_2"];
			}
			
			if (isset($res["volume_3"]) && !empty($res["volume_3"])) {
				$volumeText .= " x ".$res["volume_3"]." ".$res["volume_satuan_3"];
			}
			
			if (isset($res["volume_4"]) && !empty($res["volume_4"])) {
				$volumeText .= " x ".$res["volume_4"]." ".$res["volume_satuan_4"];
			}
			
			$value = $value." <br /><span class='rkakl_detail_name'>[".$volumeText."]</span>";
		}
		else if (isset($column->format) && $column->format == "rkakl_volume") {
			$volumeText = $res["volume_1"];
			
			if (isset($res["volume_2"]) && !empty($res["volume_2"])) {
				$volumeText = $volumeText*$res["volume_2"];
			}
			
			
			if (isset($res["volume_3"]) && !empty($res["volume_3"])) {
				$volumeText = $volumeText*$res["volume_3"];
			}
			
			if (isset($res["volume_4"]) && !empty($res["volume_4"])) {
				$volumeText = $volumeText*$res["volume_4"];
			}
			
			$value = $volumeText.",00";
		}
		else if (isset($column->format) && $column->format == "textLink") {
			$attr = "";
			$class = "row-event-click";
				
			if (isset($column->textLink->url)) {
				$url = $column->textLink->url;

				if (isset($res) && !empty($res)) {
					foreach ($res as $resKey => $resVal) {
						$url = str_replace("{{".$resKey."}}",$resVal, $url);
					}
				}

				//$attr .= 'data-action="link" data-href="'.base_url($url).'"';
				//$attr .= 'data-action="link"';
			}
			
			$value = "<a href='".base_url($url)."' title='".$valueOri."' class='".$class."' ".$attr.">".$value."</a>";
		}
		else if (isset($column->format) && $column->format == "namaPaketAkunTextLink") {
			$attr = "";
			$class = "row-event-click";
				
			if (isset($column->textLink->url)) {
				$url = $column->textLink->url;

				if (isset($res) && !empty($res)) {
					foreach ($res as $resKey => $resVal) {
						$url = str_replace("{{".$resKey."}}",$resVal, $url);
					}
				}

				$attr .= 'data-action="link" data-href="'.base_url($url).'"';
			}
			
			$paketAkun = $this->config->item("paket_akun");
			$namaAkun = $paketAkun[$value]["nama"];
			
			$value = "<a href='javascript:;' class='".$class."' ".$attr.">".$namaAkun."</a>";
		}
		else if (isset($column->format) && $column->format == "label_aktive_inactive") {
			if ($value == "1") {
				$value = '<label class="label bg-c-blue text-white f-12">Aktif</label>';
			}
			else {
				$value = '<label class="label bg-c-red text-white f-12">Tidak Aktif</label>';
			}
		}
		else if (isset($column->format) && $column->format == "komponen_sub_komponen_kode") {
			
			$this->load->model("rkakl_model");
			$subKomponenId = $value;
			
			$subKomponen = $this->rkakl_model->getSubKomponenById($subKomponenId);
			
			if (!empty($subKomponen)) {
				$kode = $subKomponen["kode"];
				$komponen = $this->rkakl_model->getKomponenById($subKomponen["rkakl_komponen_id"]);

				if (!empty($komponen)) {
					$kode = $komponen["kode"].".".$subKomponen["kode"];
					$output = $this->rkakl_model->getOutputById($komponen["rkakl_output_id"]);
					
					if (!empty($output)) {
						$kode = '<a href="'.base_url('rkakl/akun/'.$subKomponen["id"].'/').'" target="_blank">'.$output["kode"].".".$komponen["kode"].".".$subKomponen["kode"].'</a>';
					}
					
				}
				
				$value = $kode;
			}
			
		}
		else if (isset($column->format) && $column->format == "rkakl_sub_komponen_anggaran") {
			
			$this->load->model("rkakl_model");
			$subKomponenId = $value;
			
			$subKomponen = $this->rkakl_model->getSubKomponenById($subKomponenId);
			
			if (!empty($subKomponen)) {
				$value = "Rp. ".number_format($subKomponen["anggaran"],0,",",".");;
			}
			
		}
		else if (isset($column->format) && $column->format == "rkakl_sub_komponen_realisasi") {
			
			$this->load->model("rkakl_model");
			$subKomponenId = $value;
			
			$subKomponen = $this->rkakl_model->getSubKomponenById($subKomponenId);
			
			if (!empty($subKomponen)) {
				$value = "Rp. ".number_format($subKomponen["realisasi"],0,",",".");;
			}
			
		}
		else if (isset($column->format) && $column->format == "transport_area") {
			
			foreach ($this->config->item('transport_area') as $areaId => $areaName) {
				if ($value == $areaId) {
					$value = $areaName;
				}
			}
		}
		else if (isset($column->format) && $column->format == "perjadin_nominatif_honor") {
			$volumeSatuan = $res["volume_satuan_honor"];
			$satuan = $this->config->item("rkakl_volume_satuan");
			$value = "Rp. ".number_format($value,0,",",".")." / 1 ".$volumeSatuan;
		}
		else if (isset($column->format) && $column->format == "volume_honor") {
			$volumeSatuan = $res["volume_satuan_honor"];
			$satuan = $this->config->item("rkakl_volume_satuan");
			$value = $value.' '.$volumeSatuan;
		}
		else if (isset($column->format) && $column->format == "perjadin_tujuan_jaldis") {
			$berangkatDari = $res["tujuan_dari_jaldis"];
			$tujuanKe = $res["tujuan_ke_jaldis"];
			$value = $berangkatDari.' - '.$tujuanKe;
		}
		else if (isset($column->format) && $column->format == "volume_jaldis") {
			$volumeSatuan = $res["volume_satuan_jaldis"];
			$value = $value.' '.$volumeSatuan;
		}
		else if (isset($column->format) && $column->format == "sync_biodata") {
			if ($res["sync_biodata"]) {
				$this->load->model("biodata_model");
				
				$biodata = $this->biodata_model->getBiodataById($res["sync_biodata"]);
				
				$value = $biodata["nama"];
			}
			else {
				$value = '<a href="javascript:;" class="btn btn-danger btn-sm row-event-click btn-sync-biodata" data-id="'.$res["id"].'" data-table="user" data-action="modal" data-modal-view="backend/user/modal_sync_biodata"><i class="fas fa-sync-alt"></i> Sinkronkan Biodata</a>';
			}
		}
		else if (isset($column->format) && $column->format == "checklist") {
			$class = $column->class;
			
			$checked = "";
			
			if ($value == "1") {
				$checked = 'checked="checked"';
			}
			
			if (isset($res["paid"]) && $res["paid"] == "1") {
				//$checked .= " disabled";
			}
			
			$value = '<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;"><input type="checkbox" data-table="'.$table.'" id="checklist-'.$column->field.'-'.$res["id"].'" value="1" class="'.$class.'" data-id="'.$res["id"].'" '.$checked.'><label for="checklist-'.$column->field.'-'.$res["id"].'" class="cr"></label></div>';
		}
		else if (isset($column->format) && $column->format == "checklist_laporan") {
			$class = $column->class;
			
			$checked = "";
			
			if ($value == "1") {
				$checked = 'checked="checked" disabled';
			}
			
			$value = '<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;"><input type="checkbox" data-table="'.$table.'" id="checklist-'.$column->field.'-'.$res["id"].'" value="1" class="'.$class.'" data-id="'.$res["id"].'" '.$checked.'><label for="checklist-'.$column->field.'-'.$res["id"].'" class="cr"></label></div>';
		}
		else if (isset($column->format) && $column->format == "lock") {
			if (!property_exists($column, 'class')) {
				$column->class = "";
			}
			
			if (!property_exists($column, 'onclick')) {
				$column->onclick = "javascript:;";
			}
			
			$class = $column->class;
			$onclick = $column->onclick;
			
			$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:16px; color:#999;" class="'.$class.'" data-id="'.$res["id"].'" value="1" title="Lock"><i class="fas fa-unlock-alt"></i></a>';
			
			if ($value == "1") {
				$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:16px; color:#f44236;" class="'.$class.'" data-id="'.$res["id"].'" value="0" title="Unlock"><i class="fas fa-lock"></i></a>';
			}
			
			$value = $icon;
		}
		else if (isset($column->format) && $column->format == "print") {
			if (!property_exists($column, 'class')) {
				$column->class = "";
			}
			
			if (!property_exists($column, 'onclick')) {
				$column->onclick = "javascript:;";
			}
			
			$class = $column->class;
			$onclick = $column->onclick;
					
			if (isset($res) && !empty($res)) {
				foreach ($res as $resKey => $resVal) {
					$onclick = str_replace("{{".$resKey."}}",$resVal, $onclick);
				}
			}
			
			
			$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:18px; color:#999;" class="'.$class.'" data-id="'.$res["id"].'" value="1" title="Print"><i class="fas fa-print"></i></a>';
			
			if ($value == "1") {
				$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:18px; color:#f44236;" class="'.$class.'" data-id="'.$res["id"].'" value="1" title="Sudah diprint"><i class="fas fa-print"></i></a>';
			}
			
			$value = $icon;
		}
		else if (isset($column->format) && $column->format == "mcm") {
			if (!property_exists($column, 'class')) {
				$column->class = "";
			}
			
			if (!property_exists($column, 'onclick')) {
				$column->onclick = "javascript:;";
			}
			
			$class = $column->class;
			$onclick = $column->onclick;
			
			$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:20px; color:#999;" class="'.$class.'" data-id="'.$res["id"].'" value="1" title="Download MCM Transfer"><i class="fas fa-file-excel"></i></a>';
			
			$value = $icon;
		}
		else if (isset($column->format) && $column->format == "paidSpjItem") {
			if (!property_exists($column, 'class')) {
				$column->class = "";
			}
			
			if (!property_exists($column, 'onclick')) {
				$column->onclick = "javascript:;";
			}
			
			$class = $column->class;
			$onclick = $column->onclick;
			
			$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:16px; color:#999; padding:0 7px; cursor:text;" class="'.$class.'" data-id="'.$res["id"].'" data-nama="'.$res["nama"].'" value="1" title="Pay"><span class="material-icons" title="Belum dibayarkan" style="cursor:text;">&#xe263;</span></a>';
			
			if ($value == "1") {
				$icon = '<a href="javascript:;" data-table="'.$table.'" style="font-size:16px; color:#2ebf55; padding:0 7px; cursor:text;" class="'.$class.'" data-id="'.$res["id"].'" data-nama="'.$res["nama"].'" value="1" title="Paid"><span class="material-icons" title="Telah Dibayarkan" style="cursor:text;">&#xe263;</span></a>';
			}
			
			$value = $icon;
		}
		else if (isset($column->format) && $column->format == "paidSpby") {
			if (!property_exists($column, 'class')) {
				$column->class = "";
			}
			
			if (!property_exists($column, 'onclick')) {
				$column->onclick = "javascript:;";
			}
			
			$class = $column->class;
			$onclick = $column->onclick;
			
			$dataNama = "";
			if (isset($res["nama"])) {
				$dataNama = 'data-nama="'.$res["nama"].'"';
			}

			$icon = '<a href="javascript:;" data-table="'.$table.'" onClick="'.$onclick.'" style="font-size:16px; color:#999; padding:0 7px; cursor:text;" class="'.$class.'" data-id="'.$res["id"].'" '.$dataNama.' value="1" title="Pay"><span class="material-icons" title="Belum dibayarkan" style="margin-top:4px;">&#xe263;</span></a>';
			
			if ($value == "1") {
				$icon = '<a href="javascript:;" data-table="'.$table.'" style="font-size:16px; color:#2ebf55; padding:0 7px; cursor:text;" class="'.$class.'" data-id="'.$res["id"].'" '.$dataNama.' value="1" title="Paid"><span class="material-icons" title="Telah Dibayarkan" style="margin-top:4px;">&#xe263;</span></a>';
			}
			
			$value = $icon;
		}
		else if (isset($column->format) && $column->format == "date_range" && isset($column->date_range) && !empty($column->date_range)) {
			$date_start = $res[str_replace(".", "__", $column->date_range->start)];
			$date_end = $res[str_replace(".", "__", $column->date_range->end)];
			
			$value = $this->utility->formatRangeDate($date_start, $date_end);
		}
		else if (isset($column->format) && $column->format == "day_counter" && isset($column->day_counter) && !empty($column->day_counter)) {
			$date_start = $res[str_replace(".", "__", $column->day_counter->start)];
			$date_end = $res[str_replace(".", "__", $column->day_counter->end)];
			
			$value = $this->utility->lama_tugas($date_start, $date_end)." hari";
		}
		else if (isset($column->format) && $column->format == "nomor_urut") {
			$nomorUrut = explode("-", $value);
			
			if (!empty($nomorUrut)) {
				$nomorUrut = $nomorUrut[0];
				$value = (int) $nomorUrut;	
			}
		}
		else if (isset($column->format) && $column->format == "lama_tugas") {
			
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$tgl_tugas = json_decode($res["tgl_tugas"], true);
				$hari = count($tgl_tugas);
				$value = $hari." hari";
			}
			else {
				$startDate = $res["tgl_mulai_tugas"];
				$endDate = $res["tgl_selesai_tugas"];
			
				$value = $this->utility->lama_tugas($startDate, $endDate)." hari";
			}
		}
		else if (isset($column->format) && $column->format == "jumlah_perjalanan") {
			
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$tgl_tugas = json_decode($res["tgl_tugas"], true);
				$perjalanan = count($tgl_tugas);
				$value = $perjalanan." kali";
			}
			else {
				$value = "1 kali";
			}
		}
		else if (isset($column->format) && $column->format == "lama_nginap") {
			
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$value = 0;
			}
			else {
				$startDate = $res["tgl_mulai_tugas"];
				$endDate = $res["tgl_selesai_tugas"];

				$value = ($this->utility->lama_tugas($startDate, $endDate) - 1);
			}
			
			if ($value > 0) {
				$value .= " malam";
			}
			else {
				$value = "-";
			}
		}
		else if (isset($column->format) && $column->format == "jumlah_uang_harian") {
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$tgl_tugas = json_decode($res["tgl_tugas"], true);
				$lama_tugas = count($tgl_tugas);
			}
			else {
				$startDate = $res["tgl_mulai_tugas"];
				$endDate = $res["tgl_selesai_tugas"];
				$lama_tugas = $this->utility->lama_tugas($startDate, $endDate);
			}
			
			$value = $res["uang_harian"]*$lama_tugas;
			$value = "Rp. ".number_format($value,0,",",".");
		}
		else if (isset($column->format) && $column->format == "jumlah_transport") {
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$tgl_tugas = json_decode($res["tgl_tugas"], true);
				$perjalanan = count($tgl_tugas);
			}
			else {
				$startDate = $res["tgl_mulai_tugas"];
				$endDate = $res["tgl_selesai_tugas"];
				$perjalanan = 1;
			}
			
			$value = $res["transport"]*$perjalanan;
			$value = "Rp. ".number_format($value,0,",",".");
		}
		else if (isset($column->format) && $column->format == "jumlah_penginapan") {
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$lama_nginap = 0;
			}
			else {
				$startDate = $res["tgl_mulai_tugas"];
				$endDate = $res["tgl_selesai_tugas"];

				$lama_nginap = $this->utility->lama_tugas($startDate, $endDate) - 1;
			}
			
			$value = $res["penginapan"]*$lama_nginap;
			$value = "Rp. ".number_format($value,0,",",".");
		}
		else if (isset($column->format) && $column->format == "jumlah_honor") {
			$value = $res["honor"]*$res["vol_honor"];
			$value = "Rp. ".number_format($value,0,",",".");
		}
		else if (isset($column->format) && $column->format == "jumlah_diterima") {
			
			if (isset($res["tgl_tugas"]) && !empty($res["tgl_tugas"])) {
				$tgl_tugas = json_decode($res["tgl_tugas"], true);
				$perjalanan = count($tgl_tugas);
				$lama_tugas = count($tgl_tugas);
				$lama_nginap = 0;
			}
			else {
				$startDate = $res["tgl_mulai_tugas"];
				$endDate = $res["tgl_selesai_tugas"];
				
				$perjalanan = 1;
				$lama_tugas = $this->utility->lama_tugas($startDate, $endDate);
				$lama_nginap = $this->utility->lama_tugas($startDate, $endDate) - 1;
			}
			
			
			$total = 0;
			
			$total += $res["pesawat_berangkat"];
			$total += $res["pesawat_pulang"];
			$total += $res["taksi_berangkat"];
			$total += $res["taksi_pulang"];
			$total += $res["transport"] * $perjalanan;
			$total += $res["transport_lainnya"];
			$total += $res["uang_harian"] * $lama_tugas;
			$total += $res["penginapan"] * $lama_nginap;
			$total += ($res["honor"] * $res["vol_honor"]) - (($res["honor"] * $res["vol_honor"])*($res["pajak"]/100));
			
			$value = "Rp. ".number_format($total,0,",",".");
		}
		else if (isset($column->format) && $column->format == "buat_perjadin_btn") {
			
			if ($res["penugasan_item__status"] == "0" || $res["penugasan_item__status"] == "1" || $res["penugasan_item__status"] == "4") {
				$value = '<a href="javascript:;" class="btn btn-sm btn-info row-event-click" data-penugasan_item.id="'.$value.'" data-table="penugasan_item" data-action="modal" data-modal-view="backend/user/modal_laporan_penugasan"><i class="fas fa-edit"></i>Buat</a>';
			}
			else {
				$value = '<a href="javascript:;" class="btn btn-sm btn-secondary" style="pointer-events: none;opacity: 0.6;"><i class="fas fa-edit"></i>Buat</a>';
			}
			
		}
		else if (isset($column->format) && $column->format == "download_perjadin_btn") {
			
			if ($res["penugasan_item__status"] == "1" || $res["penugasan_item__status"] == "2" || $res["penugasan_item__status"] == "4") {
				$value = '<a href="'.base_url("/admin/user/preview_laporan_perjadin/".$value).'" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>Preview</a>';
			}
			else if ($res["penugasan_item__status"] == "3" || $res["penugasan_item__status"] == "5" || $res["penugasan_item__status"] == "6") {
				$value = '<a href="'.base_url("/admin/user/laporan_perjadin/".$value).'" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-cloud-download-alt"></i>Download</a>';
			}
			else {
				$value = '<a href="javascript:;" class="btn btn-secondary btn-sm" style="pointer-events: none;opacity: 0.6;"><i class="fas fa-eye"></i>Preview</a>';
			}
			
		}
		elseif (isset($column->format) && $column->format == "tgl_kuitansi") {
		    if ($value == "1970-01-01") {
		        $value = "-";
		    }
		    else {
		        $value = $this->utility->formatShortDateIndo($value);
		    }
		}
		elseif (isset($column->format) && $column->format == "checklistHadir") {
			$daftarHadir = json_decode($value, true);

			$searchDate = str_replace("daftar_hadir_","", $column->id);
			
			if (isset($daftarHadir[$searchDate]) && $daftarHadir[$searchDate] == 1) {
				$value = '<i class="fas fa-check-square icon-green" style="font-size:20px; margin-right:16px;" title="Hadir"></i>';
			}
			else {
				$value = '<i class="fas fa-check-square icon-grey" style="font-size:20px; margin-right:16px;" title="Tidak Hadir"></i>';
			}
		}
		elseif (isset($column->format) && $column->format == "status_active") {
			if($value == 1){
				$value = '<label class="badge btn-success">Aktif</label>';
			}else{
				$value = '<label class="badge btn-danger">Tidak Aktif</label>';
			}
		}
		elseif (isset($column->format) && $column->format == "jenis_arsip") {
			$value = "[".$res["arsip__program"]."] ".$res["arsip__jenis_berkas"];
		}
		elseif (isset($column->format) && $column->format == "laporan_kegiatan") {
			
			if (isset($res["tugas_panitia"]) && $res["tugas_panitia"] == "laporan_kegiatan") {
				$value = '<i class="fas fa-check-square icon-green" style="font-size:20px; margin-right:16px;" title="Pembuat Laporan Kegiatan"></i>';
			}
			else {
				$value = '<i class="fas fa-check-square icon-grey" style="font-size:20px; margin-right:16px;"></i>';
			}
		}
		else if (isset($column->format) && $column->format == "status_arsip") {

			if ($value == "Divalidasi Arsiparis") {
				$value = '<span class="label label-yellow f-12 text-white">Divalidasi</span>';
			}
			else if ($value == "Diarsipkan") {
				$value = '<span class="label label-green f-12 text-white">'.$value.'</span>';
			}
			else if ($value == "Ditolak Arsiparis") {
				$value = '<span class="label label-red f-12 text-white">Ditolak</span>';
			}
			else {
				$value = '<span class="label label-primary f-12 text-white">'.$value.'</span>';
			}

		}
		else if (isset($column->format) && $column->format == "label_arsip") {

			$operator = '<span class="icon-grey material-icons">&#xf108;</span>';
			$draft = '<span class="icon-yellow material-icons" title="Draft">&#xe85d;</span>';
			$created = '<span class="icon-green material-icons" title="Draft telah dibuat">&#xe85d;</span>';
			$verif = '<span class="icon-grey material-icons" title="Belum Validasi SPI">&#xe85f;</span>';
			$verifWaiting = '<span class="icon-yellow material-icons" title="Proses Validasi SPI">&#xe85f;</span>';
			$verifDiscard = '<a href="javascript:;" onclick="Arsip.showAlasanTolakSpi(\''.$res['arsip__id'].'\');"><span class="icon-red material-icons" title="Laporan ditolak SPI">&#xe85f;</span></a>';
			$verifApproved = '<span class="icon-green material-icons" title="Disetujui SPI">&#xe862;</span>';
			$petugas = '<span class="icon-grey material-icons" title="Belum Tandatangan Kepala">&#xe85e;</span>';
			$petugasBatal = '<span class="icon-red material-icons" onclick="Arsip.showAlasanTolakKepala(\''.$res['arsip__id'].'\');" title="Ditolak Tandatangan Kepala">&#xe85e;</span>';
			$petugasWaiting = '<span class="icon-yellow material-icons" title="Menunggu Tandatangan Kepala">&#xe85e;</span>';
			$petugasAccept = '<span class="icon-green material-icons" title="Ditandatangani Kepala">&#xe85e;</span>';

			$petugasArsip = '<span class="icon-grey material-icons" title="Belum Divalidasi Petugas Arsip">&#xe85e;</span>';
			$petugasArsipBatal = '<span class="icon-red material-icons" onclick="Arsip.showAlasanTolakArsip(\''.$res['arsip__id'].'\');" title="Ditolak Petugas Arsip">&#xe85e;</span>';
			$petugasArsipWaiting = '<span class="icon-yellow material-icons" title="Validasi Petugas Arsip">&#xe85e;</span>';
			$petugasArsipAccept = '<span class="icon-green material-icons" title="Disetujui Petugas Arsip">&#xe85e;</span>';

			$draftArchive = '<span class="icon-yellow material-icons" title="Draft Arsip">&#xe85d;</span>';
			$createdArchive = '<span class="icon-green material-icons" title="Arsip telah dibuat">&#xe85d;</span>';

			$archive = '<span class="icon-grey material-icons" title="Belum diarsipkan">&#xe861;</span>';
			$archiveDone = '<span class="icon-green material-icons" title="Telah diarsipkan">&#xe861;</span>';
			$archiveTaken = '<span class="icon-blue material-icons" title="Arsip dipinjam">&#xe861;</span>';
			$archiveWait = '<span class="icon-yellow material-icons" title="Arsip divalidasi">&#xe861;</span>';
			$archiveDiscard = '<span class="icon-red material-icons" title="Arsip dipinjam">&#xe861;</span>';
			$pack = '<span class="icon-grey material-icons" title="Belum Jilid">&#xe558;</span>';
			$packStart = '<span class="icon-yellow material-icons" title="Proses Jilid">&#xe558;</span>';
			$packDone = '<span class="icon-green material-icons" title="Sudah Jilid">&#xe558;</span>';
			
			if ($res["arsip__jenis_berkas"] == "Laporan Kegiatan" || $res["arsip__jenis_berkas"] == "Laporan Keuangan dan BMN") {
				if ($value == "Baru") { // Laporan Draft
					$status = $draft;
					$status .= $operator;
					$status .= $verif;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Divalidasi SPI") { // Laporan Periksa SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifWaiting;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Disetujui SPI") { // Laporan Disetujui SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Ditolak SPI") { // Laporan Ditolak SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifDiscard;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Divalidasi Kepala") { // Laporan Diterima Kepala
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasWaiting;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Disetujui Kepala") { // Laporan Dittd Kepala
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Ditolak Kepala") { // Laporan Ditolak Kepala
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasBatal;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Proses Jilid") { // Laporan Proses Jilid
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packStart;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Selesai Jilid") { // Laporan Selesai Jilid
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Divalidasi Arsiparis") { // Laporan Divalidasi
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveWait;
				}
				else if ($value == "Diarsipkan") { // Laporan Diarsipkan
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveDone;
				}
				else if ($value == "Dipinjam") { // Laporan Dipinjam
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveDiscard;
				}
			}
			else if ($res["arsip__jenis_berkas"] == "Pengadaan Barang dan Jasa") {
				if ($value == "Baru") { // Laporan Draft
					$status = $draft;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Proses Jilid") { // Laporan Proses Jilid
					$status = $created;
					$status .= $operator;
					$status .= $packStart;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Selesai Jilid") { // Laporan Selesai Jilid
					$status = $created;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Divalidasi Arsiparis") { // Laporan Divalidasi
					$status = $created;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveWait;
				}
				else if ($value == "Diarsipkan") { // Laporan Diarsipkan
					$status = $created;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveDone;
				}
				else if ($value == "Dipinjam") { // Laporan Dipinjam
					$status = $created;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveDiscard;
				}
			}
			else {

				$verif = '<span class="icon-grey material-icons" title="Belum Validasi Arsiparis">&#xe85f;</span>';
				$verifWaiting = '<span class="icon-yellow material-icons" title="Proses Validasi Arsiparis">&#xe85f;</span>';
				$verifDiscard = '<a href="javascript:;" onclick="Arsip.showAlasanTolakArsiparis(\''.$res['arsip__id'].'\');"><span class="icon-red material-icons" title="Ditolak Arsiparis">&#xe85f;</span></a>';
				$verifApproved = '<span class="icon-green material-icons" title="Disetujui Arsiparis">&#xe862;</span>';

				if ($value == "Baru") { // Laporan Draft
					$status = $draft;
					$status .= $operator;
					$status .= $verif;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Divalidasi Arsiparis") { // Laporan Periksa SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifWaiting;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Ditolak Arsiparis") { // Laporan Ditolak SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifDiscard;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Diarsipkan") { // Laporan Diarsipkan
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $archiveDone;
				}
				else if ($value == "Dipinjam") { // Laporan Dipinjam
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $archiveDiscard;
				}
			}
			
			if (!empty($res["kegiatan_id"])) {
				/*$value = $res["kegiatan__progress_laporan"];

				if ($value == "0") { // Laporan Draft
					$status = $draft;
					$status .= $operator;
					$status .= $verif;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "1") { // Laporan Periksa SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifWaiting;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "2") { // Laporan Disetujui SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "3") { // Laporan Ditolak SPI
					$status = $created;
					$status .= $operator;
					$status .= $verifDiscard;
					$status .= $operator;
					$status .= $petugas;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "4") { // Laporan Diterima Kepala
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasWaiting;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "5") { // Laporan Dittd Kepala
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "6") { // Laporan Ditolak Kepala
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasBatal;
					$status .= $operator;
					$status .= $pack;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "7") { // Laporan Proses Jilid
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packStart;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "8") { // Laporan Selesai Jilid
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "9") { // Laporan Divalidasi
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveWait;
				}
				else if ($value == "10") { // Laporan Diarsipkan
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveDone;
				}
				else if ($value == "11") { // Laporan Dipinjam
					$status = $created;
					$status .= $operator;
					$status .= $verifApproved;
					$status .= $operator;
					$status .= $petugasAccept;
					$status .= $operator;
					$status .= $packDone;
					$status .= $operator;
					$status .= $archiveDiscard;
				}*/
			}
			else {

				/*if ($value == "Baru") {
					$status = $draftArchive;
					$status .= $operator;
					$status .= $petugasArsip;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Divalidasi") {
					$status = $createdArchive;
					$status .= $operator;
					$status .= $petugasArsipWaiting;
					$status .= $operator;
					$status .= $archive;
				}
				else if ($value == "Diarsipkan") {
					$status = $createdArchive;
					$status .= $operator;
					$status .= $petugasArsipAccept;
					$status .= $operator;
					$status .= $archiveDone;
				}
				else if ($value == "Dipinjam") {
					$status = $createdArchive;
					$status .= $operator;
					$status .= $petugasArsipAccept;
					$status .= $operator;
					$status .= $archiveDiscard;
				}
				else if ($value == "Ditolak") {
					$status = $createdArchive;
					$status .= $operator;
					$status .= $petugasArsipBatal;
					$status .= $operator;
					$status .= $archive;
				}*/

				
			}
			
			$value = $status;
		}
		else if (isset($column->format) && $column->format == "label_laporan_spi") {

			if ($res["arsip__status"] == "Divalidasi SPI") {
				$value = "Divalidasi SPI";
				$class = "label label-yellow f-12 text-white";
			}
			else if ($res["arsip__status"] == "Ditolak SPI") {
				$value = "Ditolak SPI";
				$class = "label label-red f-12 text-white";
			}
			else if ($res["arsip__status"] != "Baru") {
				$value = "Disetujui SPI";
				$class = "label label-green f-12 text-white";
			}
			
			$text = ucfirst($value);
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "label_laporan_kepala") {

			if ($res["arsip__status"] == "Divalidasi Kepala") {
				$value = "Divalidasi Kepala";
				$class = "label label-yellow f-12 text-white";
			}
			else if ($res["arsip__status"] == "Ditolak Kepala") {
				$value = "Ditolak Kepala";
				$class = "label label-red f-12 text-white";
			}
			else {
				$value = "Disetujui Kepala";
				$class = "label label-green f-12 text-white";
			}
			
			$text = ucfirst($value);
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "date_laporan_spi") {

			if ($res["arsip__status"] == "Divalidasi SPI") {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_diterima_spi"]);
			}
			else if ($res["arsip__status"] == "Ditolak SPI") {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_ditolak_spi"]);
			}
			else if ($res["arsip__status"] != "Baru") {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_disetujui_spi"]);
			}

		}
		else if (isset($column->format) && $column->format == "label_laporan_jilid") {

			if ($res["arsip__status"] == "Proses Jilid") {
				$value = "Proses Jilid";
				$class = "label label-yellow f-12 text-white";
			}
			else {
				$value = "Selesai Jilid";
				$class = "label label-green f-12 text-white";
			}
			
			$text = ucfirst($value);
			
			$value = "<span class='".$class."'>".$text."</span>";
		}
		else if (isset($column->format) && $column->format == "petugas_laporan_spi") {

			if ($res["arsip__status"] == "Divalidasi SPI") {
				$value = $res["arsip__petugas_laporan_diterima_spi"];
			}
			else if ($res["arsip__status"] == "Ditolak SPI") {
				$value = $res["arsip__petugas_laporan_ditolak_spi"];
			}
			else if ($res["arsip__status"] != "Baru") {
				$value = $res["arsip__petugas_laporan_disetujui_spi"];
			}

			if (isset($this->admin) && !empty($this->admin)) {
				foreach ($this->admin as $admin) {
					if ($value == $admin["id"]) {
						$value = $admin["nama"];
					}
				}
			}

		}
		else if (isset($column->format) && $column->format == "date_laporan_kepala") {

			if ($res["arsip__status"] == "Divalidasi Kepala") {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_diterima_kepala"]);
			}
			else if ($res["arsip__status"] == "Ditolak Kepala") {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_ditolak_kepala"]);
			}
			else {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_disetujui_kepala"]);
			}

		}
		else if (isset($column->format) && $column->format == "petugas_laporan_kepala") {

			if ($res["arsip__status"] == "Divalidasi Kepala") {
				$value = $res["arsip__petugas_laporan_diterima_kepala"];
			}
			else if ($res["arsip__status"] == "Ditolak Kepala") {
				$value = $res["arsip__petugas_laporan_ditolak_kepala"];
			}
			else {
				$value = $res["arsip__petugas_laporan_disetujui_kepala"];
			}

			if (isset($this->admin) && !empty($this->admin)) {
				foreach ($this->admin as $admin) {
					if ($value == $admin["id"]) {
						$value = $admin["nama"];
					}
				}
			}

		}
		else if (isset($column->format) && $column->format == "date_laporan_jilid") {

			if ($res["arsip__status"] == "Proses Jilid") {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_diterima_jilid"]);
			}
			else {
				$value = $this->utility->formatDatetimeIndo($res["arsip__tgl_laporan_selesai_jilid"]);
			}

		}
		else if (isset($column->format) && $column->format == "petugas_laporan_jilid") {
			
			if ($res["arsip__status"] == "Proses Jilid") {
				$value = $res["arsip__petugas_laporan_diterima_jilid"];
			}
			else {
				$value = $res["arsip__petugas_laporan_selesai_jilid"];
			}

			if (isset($this->admin) && !empty($this->admin)) {
				foreach ($this->admin as $admin) {
					if ($value == $admin["id"]) {
						$value = $admin["nama"];
					}
				}
			}

		}
		else if (isset($column->format) && $column->format == "laporan_kegiatan_status") {
			$operator = '<span class="icon-grey material-icons">&#xf108;</span>';
			$draft = '<span class="icon-yellow material-icons" title="Draft Laporan">&#xe85d;</span>';
			$created = '<span class="icon-green material-icons" title="Laporan telah dibuat">&#xe85d;</span>';
			$verif = '<span class="icon-grey material-icons" title="Belum Validasi SPI">&#xe85f;</span>';
			$verifWaiting = '<span class="icon-yellow material-icons" title="Proses Validasi SPI">&#xe85f;</span>';
			$verifDiscard = '<a href="javascript:;" onclick="Kepegawaian.showAlasanTolak(\''.$res['penugasan__id'].'\');"><span class="icon-red material-icons" title="Laporan ditolak SPI">&#xe85f;</span></a>';
			$verifApproved = '<span class="icon-green material-icons" title="Disetujui SPI">&#xe862;</span>';
			$petugas = '<span class="icon-grey material-icons" title="Belum Tandatangan Kepala">&#xe85e;</span>';
			$petugasBatal = '<span class="icon-red material-icons" title="Ditolak Tandatangan Kepala">&#xe85e;</span>';
			$petugasWaiting = '<span class="icon-yellow material-icons" title="Menunggu Tandatangan Kepala">&#xe85e;</span>';
			$petugasAccept = '<span class="icon-green material-icons" title="Ditandatangani Kepala">&#xe85e;</span>';
			$pembayaran = '<span class="icon-grey material-icons" title="Belum diarsipkan">&#xe861;</span>';
			$pembayaranDone = '<span class="icon-green material-icons" title="Telah diarsipkan">&#xe861;</span>';
			$pack = '<span class="icon-grey material-icons" title="Belum Jilid">&#xe558;</span>';
			$packStart = '<span class="icon-yellow material-icons" title="Proses Jilid">&#xe558;</span>';
			$packDone = '<span class="icon-green material-icons" title="Sudah Jilid">&#xe558;</span>';
			
			if ($value == "0") { // Laporan Draft
				$status = $draft;
				$status .= $operator;
				$status .= $verif;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "1") { // Laporan Periksa SPI
				$status = $created;
				$status .= $operator;
				$status .= $verifWaiting;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "2") { // Laporan Disetujui SPI
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "3") { // Laporan Ditolak SPI
				$status = $created;
				$status .= $operator;
				$status .= $verifDiscard;
				$status .= $operator;
				$status .= $petugas;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "4") { // Laporan Diterima Kepala
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasWaiting;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "5") { // Laporan Dittd Kepala
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasAccept;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "6") { // Laporan Ditolak Kepala
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasBatal;
				$status .= $operator;
				$status .= $pack;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "7") { // Laporan Proses Jilid
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasAccept;
				$status .= $operator;
				$status .= $packStart;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "8") { // Laporan Selesai Jilid
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasAccept;
				$status .= $operator;
				$status .= $packDone;
				$status .= $operator;
				$status .= $pembayaran;
			}
			else if ($value == "9") { // Laporan Diarsipkan
				$status = $created;
				$status .= $operator;
				$status .= $verifApproved;
				$status .= $operator;
				$status .= $petugasAccept;
				$status .= $operator;
				$status .= $packDone;
				$status .= $operator;
				$status .= $pembayaranDone;
			}
			
			$value = $status;
		}
		else if (isset($column->format) && $column->format == "laporan_kegiatan_spi") {
			if ($value == "0" || $value == "3") {
				$value = "<a href='javascript:;' class='btn btn-sm btn-secondary' data-kegiatan-id='".$res["kegiatan__id"]."' data-kegiatan-name='".$res["kegiatan__nama"]."' onClick='MonitoringLaporanKegiatan.TerimaLaporanSPI(this);'>Terima Laporan</a>";
			}
			else if ($value == "1") {
				$value = "<a href='javascript:;' class='btn setuju-laporan-spi btn-sm btn-info' data-kegiatan-id='".$res["kegiatan__id"]."' data-kegiatan-name='".$res["kegiatan__nama"]."' onClick='MonitoringLaporanKegiatan.SetujuLaporanSPI(this);'>Setuju Laporan</a>";
			}
			else {
				$value = "";
			}
		}
		else if (isset($column->format) && $column->format == "laporan_kegiatan_kepala") {
			if ($value == "2" || $value == "6") {
				$value = "<a href='javascript:;' class='btn btn-sm btn-secondary' data-kegiatan-id='".$res["kegiatan__id"]."' data-kegiatan-name='".$res["kegiatan__nama"]."' onClick='MonitoringLaporanKegiatan.TerimaLaporanKepala(this);'>Terima Laporan</a>";
			}
			else if ($value == "4") {
				$value = "<a href='javascript:;' class='btn setuju-laporan-spi btn-sm btn-info' data-kegiatan-id='".$res["kegiatan__id"]."' data-kegiatan-name='".$res["kegiatan__nama"]."' onClick='MonitoringLaporanKegiatan.SetujuLaporanKepala(this);'>Setuju Laporan</a>";
			}
			else {
				$value = "";
			}
		}
		else if (isset($column->format) && $column->format == "laporan_kegiatan_jilid") {
			if ($value == "5") {
				$value = "<a href='javascript:;' class='btn btn-sm btn-secondary' data-kegiatan-id='".$res["kegiatan__id"]."' data-kegiatan-name='".$res["kegiatan__nama"]."' onClick='MonitoringLaporanKegiatan.TerimaJilid(this);'>Terima Jilid</a>";
			}
			else if ($value == "7") {
				$value = "<a href='javascript:;' class='btn btn-sm btn-info' data-kegiatan-id='".$res["kegiatan__id"]."' data-kegiatan-name='".$res["kegiatan__nama"]."' onClick='MonitoringLaporanKegiatan.SelesaiJilid(this);'>Selesai Jilid</a>";
			}
			else {
				$value = "";
			}
		}
		else if (isset($column->format) && $column->format == "guest_name") {
			$this->load->model("guest_model");
			$guest = $this->guest_model->getById($value);
			$value = $guest["nama"];
		}
		else if (isset($column->format) && $column->format == "guest_unit_kerja") {
			$this->load->model("guest_model");
			$guest = $this->guest_model->getById($value);
			$value = $guest["unit_kerja"];
		}
		else if (isset($column->format) && $column->format == "status_laporan_wi") {
			$draftWaiting = '<span class="label label-secondary" title="Laporan Telah Dibuat">Draft</span>';
			$verifWaiting = '<span class="label label-warning" title="Proses Validasi Laporan">Validasi</span>';
			$verifDiscard = '<a href="javascript:;" onclick="User.showAlasanTolak(\''.$res['penugasan_item__id'].'\');"><span class="label label-danger" title="Laporan Ditolak">Ditolak</span></a>';
			$verifApproved = '<span class="label label-success" title="Laporan Disetujui">Disetujui</span>';

			if ($value == "0") {
				$value = $draftWaiting;
			}
			else if ($value == "1") {
				$value = $verifWaiting;
			}
			else if ($value == "2") {
				$value = $verifApproved;
			}
			else if ($value == "3") {
				$value = $verifDiscard;
			}
		}
		else if (isset($column->format) && $column->format == "judul_wi") {
			$configWi = $this->config->item("tipe_kegiatan_wi");

			$value = $res["judul"]."<br />";

			$value .= "<span style='font-size:11px; font-weight:bold;'>".$configWi[$res["tipe_kegiatan"]]."<span>";

			if (!empty($res["kab_tempat_kegiatan"])) {
				$value .= "&nbsp; - &nbsp;<span style='font-size:11px; font-weight:bold;'>".$res["tempat_kegiatan"]." (".$res["kab_tempat_kegiatan"].")<span>";
			}
			
		}
		else if (isset($column->format) && $column->format == "laporan_wi") {
			if (!empty($res["dokumen_link"])) {
				$value = '<a href="'.$res["dokumen_link"].'" class="btn btn-sm btn-primary" target="_blank">Download</a>';
			}
		}		
		
		return $value;
	}
	
	public function data() {
		//ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);
		
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body);
		
		if (!empty($data)) {			
			$table = $data->table;
			$columns = $data->columns;
			$current = $data->current;
			$rowCount = $data->rowCount;
			$search = $data->search;
			$sortBy = isset($data->sortBy) ? $data->sortBy : $table.".id";
			$sortDirection = isset($data->sortDirection) ? $data->sortDirection : "ASC";
			$tableJoin = isset($data->tableJoin) ? $data->tableJoin : "";
			$tableJoinType = isset($data->tableJoinType) ? $data->tableJoinType : "";
			$tableJoinCondition = isset($data->tableJoinCondition) ? $data->tableJoinCondition : array();
			$conditions = isset($data->conditions) ? (array) $data->conditions : array();
			$editBtn = isset($data->editBtn) ? $data->editBtn : array();
			$deleteBtn = isset($data->deleteBtn) ? $data->deleteBtn : array();
			$filterYearCreatedDate = isset($data->filterYearCreatedDate) ? $data->filterYearCreatedDate : "";
			$filterKabKota = isset($data->filterKabKota) ? $data->filterKabKota : "";
			$filterKabKotaTujuan = isset($data->filterKabKotaTujuan) ? $data->filterKabKotaTujuan : "";
			$filterBulan = isset($data->filterBulan) ? $data->filterBulan : "";
			$filterKelas = isset($data->filterKelas) ? $data->filterKelas : "";
			
			$where = "";
		
			if (!empty($conditions)) {
				foreach ($conditions as $keyBoo => $boo) {
					
					if (!isset($boo->field)) {
						$where .= $boo;
					}
					else {
						if (isset($conditions[$keyBoo-1]->field) && !empty($where)) {
							$where .= " AND ";
						}

						$where .= $boo->field." ".$boo->operator." '".$boo->value."'";
					}
				}
			}
			
			if (!empty($filterYearCreatedDate)) {
				if (!empty($where)) {
					$where .= " AND ";
				}
				
				$where .= "YEAR(dibuat_tgl) = '".$filterYearCreatedDate."'";
			}
			
			if (!empty($filterKabKota) && $filterKabKota == "Lainnya") {
				
				$configAreas = $this->config->item("transport_area");
				
				foreach ($configAreas as $configArea) {
					if (!empty($where)) {
						$where .= " AND ";
					}
					
					if ($table == "spj_item") {
						$where .= "kab_asal != '".$configArea."'";
					}
					else {
						$where .= "kab_unit_kerja != '".$configArea."'";
					}
				}
			}
			else if (!empty($filterKabKota) && $filterKabKota != "Semua Kabupaten") {
				
				if (!empty($where)) {
					$where .= " AND ";
				}
				
				if ($table == "spj_item") {
					$where .= "kab_asal = '".$filterKabKota."'";
				}
				else {
					$where .= "kab_unit_kerja = '".$filterKabKota."'";
				}
			}

			if (!empty($filterKabKotaTujuan) && $filterKabKotaTujuan == "Lainnya") {
				
				$configAreas = $this->config->item("transport_area");
				
				foreach ($configAreas as $configArea) {
					if (!empty($where)) {
						$where .= " AND ";
					}
					
					if ($table == "spj_item") {
						$where .= "kab_tujuan != '".$configArea."'";
					}
					else {
						$where .= "kab_unit_kerja != '".$configArea."'";
					}
				}
			}
			else if (!empty($filterKabKotaTujuan) && $filterKabKotaTujuan != "Semua Kabupaten") {
				
				if (!empty($where)) {
					$where .= " AND ";
				}
				
				if ($table == "spj_item") {
					$where .= "kab_tujuan = '".$filterKabKotaTujuan."'";
				}
				else {
					$where .= "kab_unit_kerja = '".$filterKabKotaTujuan."'";
				}
			}

			if (!empty($filterKelas) && $filterKelas != "Semua Kelas") {
				if (!empty($where)) {
					$where .= " AND ";
				}
				
				if ($table == "spj_item") {
					$where .= "kategori = '".$filterKelas."'";
				}
				else {
					$where .= "kategori = '".$filterKelas."'";
				}
			}

			if (!empty($filterBulan)) {
				if (!empty($where)) {
					$where .= " AND ";
				}
				
				if ($table == "widyaiswara") {
					$where .= "MONTH(tgl_selesai_kegiatan) = '".$filterBulan."'";
				}
				else {
					$where .= "MONTH(tgl_selesai_kegiatan) = '".$filterBulan."'";
				}
			}
			
			// SEARCH

			if (is_array($columns) && !empty($search)) {
				if (!empty($where)) {
					$where .= " AND ";
				}
				
				$where .= " ( ";
					$x = 0;
					foreach ($columns as $key => $column) {
						if ( $column->id == 'autonumeric' ) { continue; }
						
						if (!empty($x)) {
							$where .= " OR ";
						}

						$where .= $column->field." LIKE '%".$search."%'";
						$x++;
					}
				$where .= " ) ";
			}
			
			
			// TOTAL
			$config_tb = $this->config->item('db_master_table');
			if(!in_array($table, $config_tb)){
				$tahun_anggaran = (isset($_SESSION['tahun_anggaran']))? $_SESSION['tahun_anggaran'] : date('Y');
				$db_tahun = 'transaction_' . $tahun_anggaran; 
				$this->grid_db = $this->load->database($db_tahun, true);
				$this->grid_db->from($table);
			}else{
				$this->grid_db = $this->db;
				$this->grid_db->from($table);
			}
			
		
			if (!empty($tableJoin) && !empty($tableJoinCondition)) {
				if (!empty($tableJoinType)) {
					$this->grid_db->join($tableJoin, $tableJoinCondition, $tableJoinType);
				}
				else {
					$this->grid_db->join($tableJoin, $tableJoinCondition);
				}

				$tableFields = $this->grid_db->list_fields($table);
				$tableJoinFields = $this->grid_db->list_fields($tableJoin);

				$select = array();

				if (!empty($tableFields)) {
					foreach ($tableFields as $tableField) {
						$select[] = $table.'.'.$tableField.' AS '.$table.'__'.$tableField;
					}
				}

				if (!empty($tableJoinFields)) {
					foreach ($tableJoinFields as $tableJoinField) {
						$select[] = $tableJoin.'.'.$tableJoinField.' AS '.$tableJoin.'__'.$tableJoinField;
					}
				}

				if (!empty($select)) {
					$this->grid_db->select(implode(", ", $select));
				}
				else {
					$this->grid_db->select('*');
				}
			}
			else {

				$tableFields = $this->grid_db->list_fields($table);
				$select = array();

				if (!empty($tableFields)) {
					foreach ($tableFields as $tableField) {
						$select[] = $table.'.'.$tableField.' AS '.$table.'__'.$tableField;
					}
				}

				if (!empty($select)) {
					$this->grid_db->select(implode(", ", $select));
				}
				else {
					$this->grid_db->select('*');
				}
			}

			if (!empty($where)) {
				$this->grid_db->where($where);
			}

			$total = $this->grid_db->count_all_results();

			$this->grid_db->reset_query();

			$records = array();
			$records["rows"] = array();

			$this->grid_db->select('*');
			$this->grid_db->from($table);

			if (!empty($tableJoin) && !empty($tableJoinCondition)) {
				if (!empty($tableJoinType)) {
					$this->grid_db->join($tableJoin, $tableJoinCondition, $tableJoinType);
				}
				else {
					$this->grid_db->join($tableJoin, $tableJoinCondition);
				}

				$tableFields = $this->grid_db->list_fields($table);
				$tableJoinFields = $this->grid_db->list_fields($tableJoin);

				$select = array();

				if (!empty($tableFields)) {
					foreach ($tableFields as $tableField) {
						$select[] = $table.'.'.$tableField.' AS '.$table.'__'.$tableField;
					}
				}

				if (!empty($tableJoinFields)) {
					foreach ($tableJoinFields as $tableJoinField) {
						$select[] = $tableJoin.'.'.$tableJoinField.' AS '.$tableJoin.'__'.$tableJoinField;
					}
				}

				if (!empty($select)) {
					$this->grid_db->select(implode(", ", $select));
				}
				else {
					$this->grid_db->select('*');
				}
			}
			else {

				$tableFields = $this->grid_db->list_fields($table);
				$select = array();

				if (!empty($tableFields)) {
					foreach ($tableFields as $tableField) {
						$select[] = $table.'.'.$tableField.' AS '.$table.'__'.$tableField;
					}
				}

				if (!empty($select)) {
					$this->grid_db->select(implode(", ", $select));
				}
				else {
					$this->grid_db->select('*');
				}
			}


			if (!empty($where)) {
				$this->grid_db->where($where);
			}

			$this->grid_db->order_by($sortBy, $sortDirection);
			
			if ($rowCount > 0) {
				$this->grid_db->limit($rowCount, (($rowCount*$current)-$rowCount));
			}
			
			$result = $this->grid_db->get();


			if($result->num_rows() > 0) {
				
				$i = $current;
				
				if ($rowCount > 0) {
					$i = ($current*$rowCount) - $rowCount + 1;
				}

				foreach ($result->result_array() as $res) {
					$rows = array();

					if (!empty($columns)) {
						$data = array();
						$data["id"] = $res["id"];
						
						foreach ($columns as $column) {
							if ($column->id == "autonumeric") {
								$value = '<div class="autoNumber">'.$i.'</div>';
							}
							else {
								$value = $this->format($table, $res, $column);
							}
							
							$data[$column->id] = $value;
						}
						
						$rows[] = $data;
					}
					

					if (!empty($editBtn) || !empty($deleteBtn)) {
						$btn = "";
						$showEditBtn = 1;
						$showDeleteBtn = 1;
						
						if (isset($editBtn->conditions) && !empty($editBtn->conditions)) {
							$editCondsString = "";
							$editBtnConds = $editBtn->conditions;

							foreach ($editBtnConds as $conI => $con) {
								$con = (array) $con;

								if (count($con) == 1) {
									$editCondsString .= " ".$con["operator"]." ";
								}
								else {
									if ($conI > 0 && $conI%2 == 1) {
										$editCondsString .= " AND ";
									}

									// HACK ARSIP
									if ($con["field"] == "kegiatan__progress_laporan" && empty($res[$con["field"]])) {
										$res[$con["field"]] = 0;
									}

									$editCondsString .= $res[$con["field"]]." ".$con["operator"]." ".$con["value"];
								}
							}
							

							if (eval("return ".$editCondsString.";")) {
								$showEditBtn = 1;
							}
							else {
								$showEditBtn = 0;
							}
						}

						if (isset($deleteBtn->conditions) && !empty($deleteBtn->conditions)) {
							$deteleCondsString = "";
							$deleteBtnConds = $deleteBtn->conditions;

							foreach ($deleteBtnConds as $conI => $con) {
								$con = (array) $con;

								if (count($con) == 1) {
									$deteleCondsString .= " ".$con["operator"]." ";
								}
								else {
									if ($conI > 0 && $conI%2 == 1) {
										$deteleCondsString .= " AND ";
									}

									$deteleCondsString .= "'".$res[$con["field"]]."' ".$con["operator"]." '".$con["value"]."'";
								}
							}
							

							if (eval("return ".$deteleCondsString.";")) {
								$showDeleteBtn = 1;
							}
							else {
								$showDeleteBtn = 0;
							}
						}
						
						
						if (!empty($editBtn) && !empty($res) && $showEditBtn) {
							
							$editBtnAttr = "";
							
							if (isset($editBtn->modal) && !empty($editBtn->modal)) {
								foreach ($editBtn->modal as $modalKey => $modalValue) {
									if (!empty ($editBtnAttr)) {
										$editBtnAttr .= " ";
									}
									
									$editBtnAttr .= 'data-modal-'.$modalKey.'="'.$modalValue.'"';
								}
							}
							
							if (isset($editBtn->parent) && !empty($editBtn->parent)) {
								$editBtnAttr .= ' data-parent="'.$editBtn->parent.'"';
							}
							
							if (isset($editBtn->href) && !empty($editBtn->href)) {
								
								foreach ($res as $k => $v) {
									$editBtn->href = str_replace("{{".$k."}}",$v,$editBtn->href);
								}
								
								$editBtnAttr .= ' data-href-="'.$editBtn->href.'"';
							}
							
							$btn .= '<a class="btn btn-sm btn-secondary row-event-click" title="Ubah" data-id="'.$res[$table."__id"].'" data-table="'.$table.'" data-action="edit-row" '.$editBtnAttr.'>'.$editBtn->text.'</a>';
						}
						else {
							$btn .= '<a class="btn btn-sm btn-secondary disabled" title="Tidak dapat diubah"><i class="fas fa-edit mr-0"></i></a>';
						}

						if (!empty($deleteBtn) && !empty($res) && $showDeleteBtn) {
							$btn .= ' <a class="btn btn-sm btn-danger row-event-click" title="Hapus" data-id="'.$res[$table."__id"].'" data-table="'.$table.'" data-action="delete-row">'.$deleteBtn->text.'</a>';
						}
						else {
							$btn .= ' <a class="btn btn-sm btn-danger disabled" title="Tidak dapt dihapus"><i class="fas fa-trash-alt mr-0"></i></a>';
						}

						$data["edit-delete-action"] = $btn;
					}
					else {
						$btn = "";
						$btn .= '<a class="btn btn-sm btn-secondary disabled" title="Tidak dapat diubah"><i class="fas fa-edit mr-0"></i></a>';
						$btn .= ' <a class="btn btn-sm btn-danger disabled" title="Tidak dapt dihapus"><i class="fas fa-trash-alt mr-0"></i></a>';
						$data["edit-delete-action"] = $btn;
					}
					
					$records["rows"][] = $data;
					$i++;
				}
			}
			
			$records["current"] = $current;
			$records["rowCount"] = $rowCount;
			$records["total"] = $total;
			
			print json_encode($records);
			exit();
		}
	}
	
	public function loadModalForm () {
		if (isset($_POST) && !empty($_POST)) {
			$data = array();
			$view = $_POST["view"];
			
			if (isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["table"]) && !empty($_POST["table"])) {
				
				
				$config_tb = $this->config->item('db_master_table');
				if(!in_array($_POST["table"], $config_tb)){
					$db_tahun = 'transaction_' . $_SESSION['tahun_anggaran']; 
					$newDb = $this->load->database($db_tahun, true);

					$newDb->select('*');
					$newDb->from($_POST["table"]);
					$newDb->where('id', $_POST["id"]);

					$result = $newDb->get();
				} else {
					$this->db->select('*');
					$this->db->from($_POST["table"]);
					$this->db->where('id', $_POST["id"]);

					$result = $this->db->get();
				}

				if($result->num_rows() > 0) {
					foreach ($result->result_array() as $res) {
						$data = $res;
					}
				}
			}
			
			if (isset($_POST['parentId']) && !empty($_POST['parentId'])) {
				$data["parentId"] = $_POST['parentId'];
				
				if ($view == "modal_perjadin_nominatif_detail_edit") {
					$nominatifId = $_POST['parentId'];
					
					$this->load->model("perjadin_model");
					$this->load->model("rkakl_model");
					
					$data["perjadinNominatif"] = $this->perjadin_model->getPerjadinNominatifById($nominatifId);
					
					if (!empty($data["perjadinNominatif"])) {
						$data["akun"] = $this->rkakl_model->getAkunById($data["perjadinNominatif"]["rkakl_akun_id"]);
						
						if (!empty($data["akun"])) {
							$data["detail"] = $this->rkakl_model->getAllDetailByAkunId($data["akun"]["id"]);
						}
					}
					
				}
			}
			
			if ($view == "backend/biodata/modal_edit" || $view == "backend/kegiatan/modal_kegiatan_peserta" || $view == "backend/kegiatan/modal_kegiatan_panitia" || $view == "backend/kegiatan/modal_kegiatan_narasumber") {
				$this->load->model("pengaturan_model");
				
				$satkers = $this->pengaturan_model->getPengaturanBySection("satker");
				$dataSatker = array();
				
				if (!empty($satkers)) {
					foreach ($satkers as $satker) {
						$dataSatker[$satker["sistem"]] = $satker["value"];
					}
					
					$data["satker"] = $dataSatker;
				}
			}

			if ($view == "backend/arsip/modal_kearsipan" || $view == "backend/arsip/modal_arsip" || $view == "backend/spi/modal_arsip_spi" || $view == "backend/spi/modal_arsip_kepala" || $view == "backend/arsip/modal_arsip_jilid") {
				$this->load->model("pengaturan_model");
				
				$arsips = $this->pengaturan_model->getPengaturanBySection("arsip");
				$kearispan = array();
				
				if (!empty($arsips)) {
					foreach ($arsips as $arsip) {
						$kearispan[$arsip["sistem"]] = $arsip["value"];
					}
					
					$data["pengaturan"] = $kearispan;
				}

				$this->load->model("biodata_model");
				
				$data["pegawai"] = $this->biodata_model->getBiodataByPegawaiBalai();
				$data["pencipta"] = $this->user_model->getUserById($data["dibuat_oleh"]); 
			}

			if ($view == "backend/widyaiswara/modal_approve_laporan") {
				$this->load->model("biodata_model");

				$user = $this->user_model->getUserById($data["user_id"]);

				
				$data["widyaiswara"] = $this->biodata_model->getBiodataById($user["sync_biodata"]);
			}
			 
			if ($view == "backend/kegiatan/modal_kegiatan_edit") {
				if (isset($data["detail_tgl_kegiatan"]) && !empty($data["detail_tgl_kegiatan"])) {
					$data["detail_tgl_kegiatan"] = json_decode($data["detail_tgl_kegiatan"], true);
				}

				$this->load->model("pengaturan_model");
				
				$arsips = $this->pengaturan_model->getPengaturanBySection("arsip");
				$kearispan = array();
				
				if (!empty($arsips)) {
					foreach ($arsips as $arsip) {
						$kearispan[$arsip["sistem"]] = $arsip["value"];
					}
					
					$data["pengaturan"] = $kearispan;
				}

				$this->load->model("master_komponen_kegiatan_model");
				$data["opsi_komponen"] = $this->master_komponen_kegiatan_model->get_all_records();

				if (!isset($data["buat_laporan"])) {
					$data["buat_laporan"] = 1;
				} 
			}

			if ($view == "backend/kegiatan/modal_view_dokumen") {
				
				if (isset($data["kegiatan_id"]) && !empty($data["kegiatan_id"])) {
					$this->load->model("kegiatan_model");
					$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["kegiatan_id"]);
				}
				 
			}
			
			if ($view == "backend/user/modal_sync_biodata") {
				$this->load->model("biodata_model");
				
				$biodatas = $this->biodata_model->getBiodataByPegawaiBalai();
				
				if (!empty($biodatas)) {
					foreach ($biodatas as $biodata) {
						$data["biodata"][] = $biodata;
					}
				}
			}
			
			if ($view == "backend/spj/modal_edit_spj_kegiatan") {
				$this->load->model("kegiatan_model");
				
				$data["kegiatan"] = $this->kegiatan_model->getKegiatanBySpjKegiatanId("0");
			}
			
			if ($view == "backend/spj/modal_import") {
				if (isset($_POST) && !empty($_POST)) {
					foreach ($_POST as $key => $foo) {
						if ($key == "view" || $key == "version") {
							continue;
						}
						
						$data[$key] = $foo;
					}
					
					if (isset($data["kegiatan_id"]) && !empty($data["kegiatan_id"])) {
						$this->load->model("kegiatan_model");
						$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["kegiatan_id"]);
					}
					else {
						$this->load->model("penugasan_model");
						$data["penugasan"] = $this->penugasan_model->getById($data["penugasan_id"]);
					}
				}
			}
			
			if ($view == "backend/spj/modal_import") {
				if (isset($_POST) && !empty($_POST)) {
					foreach ($_POST as $key => $foo) {
						if ($key == "view" || $key == "version") {
							continue;
						}
						
						$data[$key] = $foo;
					}
				}
			}
			
			if ($view == "backend/kepegawaian/modal_edit_penugasan" || $view == "backend/kepegawaian/modal_preview_penugasan") {
				$this->load->model("biodata_model");
				
				$data["pegawai"] = $this->biodata_model->getBiodataByPegawaiBalai();
			}
			
			if ($view == "backend/kegiatan/modal_kegiatan_item") {
				$this->load->model("pengaturan_model");
				
				$satkers = $this->pengaturan_model->getPengaturanBySection("satker");
				$dataSatker = array();
				
				if (!empty($satkers)) {
					foreach ($satkers as $satker) {
						$dataSatker[$satker["sistem"]] = $satker["value"];
					}
					
					$data["satker"] = $dataSatker;
				}
				
				if (isset($_POST["table"]) && !empty($_POST["table"])) {
					$this->load->model("master_komponen_kegiatan_model");
					$komponen = $this->master_komponen_kegiatan_model->get_record_by_table($_POST["table"]);
					
					if (!empty($komponen)) {
						$data["table"] = $komponen->table_name;
						$data["code_komponen"] = $komponen->code;
						$data["unsur"] = $komponen->code;
					}
				}
			}
			
			if ($view == "backend/spj/modal_edit_item") {
				$table = $_POST["table"];
				$this->load->model("spj_model");
				
				$data["spj"] = $this->spj_model->getById($data["spj_id"]);
				
				if (!empty($data["spj"]) && isset($data["spj"]["kegiatan_id"]) && !empty($data["spj"]["kegiatan_id"])) {
					$this->load->model("kegiatan_model");
					$data["kegiatan"] = $this->kegiatan_model->getKegiatanById($data["spj"]["kegiatan_id"]);
				}
				
				if (isset($data["tgl_tugas"]) && !empty($data["tgl_tugas"])) {
					$data["tgl_tugas"] = json_decode($data["tgl_tugas"], true);
				}
			}
			
			if ($view == "backend/spj/modal_daftar_hadir") {
				$this->load->model("spj_model");
				
				if (empty($data) && isset($_POST["spj_id"])) {
					$data["spj_id"] = $_POST["spj_id"];
				}
				
				$data["spj"] = $this->spj_model->getById($data["spj_id"]);
			}
			
			if ($view == "backend/user/modal_lihat_penugasan") {
				$this->load->model("penugasan_model");
				$data["penugasanItem"] = $this->penugasan_model->getItemById($data["penugasan_item_id"]);
				$data["penugasan"] = $this->penugasan_model->getById($data["penugasanItem"]["penugasan_id"]);
			}

			if ($view == "backend/user/modal_laporan_penugasan") {
				$this->load->model("penugasan_model");
				$data["penugasan"] = $this->penugasan_model->getById($data["penugasan_id"]);
			}
			
			if ($view == "backend/kepegawaian/modal_ganti_petugas") {
				$this->load->model("biodata_model");
				$data["petugas"] = $this->biodata_model->getBiodataByPegawaiBalai();
			}
			
			if ($view == "backend/spj/modal_edit_status") {
				$this->load->model("penugasan_model");
				$data["penugasanItem"] = $this->penugasan_model->getItemById($data["penugasan_item_id"]);
			}
			
			if ($view == "backend/spj/modal_approve_perjadin") {
				$this->load->model("penugasan_model");
				$this->load->model("spj_model");
				
				$data["penugasan"] = $this->penugasan_model->getById($data["penugasan_id"]);
				$komponen = $data["penugasan"]["tipe"];
				
				if ($komponen == "monev") {
					$komponen = "petugas";
				}
				
				$data["spj"] = $this->spj_model->getByPenugasanIdKegiatanIdKomponen($data["penugasan"]["id"], $data["penugasan"]["kegiatan_id"], $komponen);
				
				$data["spj_item"] = array();
					
				if (isset($data["spj"]["id"]) && !empty($data["spj"]["id"])) {
					$data["spj_item"] = $this->spj_model->getItemBySpjId($data["spj"]["id"]);
				}
			}
			
			if ($view == "backend/spj/modal_spby") {
				if (isset($_POST["spj_id"])) {
					$spjId = $_POST["spj_id"];
				}
				else {
					$spjId = $data["spj_id"];
				}
				
				$this->load->model("spj_model");
				
				$data["spj"] = $this->spj_model->getById($spjId);

				$data["spby_penerima"] = array();
					
				if (isset($data["spj"]["id"]) && !empty($data["spj"]["id"])) {
					$spjItems = $this->spj_model->getItemBySpjId($data["spj"]["id"]);

					if (!empty($spjItems)) {
						foreach ($spjItems as $spjItem) {
							if (!isset($data["spby_penerima"][$spjItem["ktp"]])) {
								$data["spby_penerima"][$spjItem["ktp"]] = array();
							}

							$data["spby_penerima"][$spjItem["ktp"]]["id"] = $spjItem["id"];
							$data["spby_penerima"][$spjItem["ktp"]]["nip"] = $spjItem["nip"];
							$data["spby_penerima"][$spjItem["ktp"]]["nama"] = $spjItem["nama"];
						}
					}
				}
			}

			if ($view == "backend/tool/modal_view_qr") {
				$this->load->model("tool_model");
				$qr = $this->tool_model->getQRById($_POST["id"]);

				$data["qr_code"] = array();

				if (!empty($qr)) {
					$this->load->library('qr_code');
					$data["qr_code"] = $qr;
					$data["qr_code"]["image"] = $this->qr_code->create(500, $qr["url"]);
				}
			}
  
			
			$this->load->view($view,$data);
		}
	}

	protected function deleteItem ($table, $id) {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Berhasil menghapus";
		
		$remove = 1;
		
		if (!empty($table) && !empty($id)) {
			
			if ($table == "kegiatan") {
				$this->load->model("kegiatan_model");

				$kegiatan = $this->kegiatan_model->getKegiatanById($id);

				if (isset($kegiatan["komponen"]) && !empty($kegiatan["komponen"])) {
					$komponen = array();

					foreach ($kegiatan["komponen"] as $kom => $komOn) {
						if ($komOn) {
							$komponen[] = $kom;
						}
					}

					if (!empty($komponen)) {
						$this->load->model("komponen_kegiatan_model");

						foreach ($komponen as $kom) {
							$items = $this->komponen_kegiatan_model->getItemByKegiatanId($kom, $id);
						
							foreach ($items as $item) {
								$this->komponen_kegiatan_model->delete($kom, $item["id"]);
								
								$this->utility->deleteTtd($kegiatan["kode"], $item["ktp"]);
								$this->utility->deleteSurTug($kegiatan["kode"], $item["surat_tugas"]);
							}
						}
					}
				}
								
				/*if (!empty($dakungs)) {
					foreach ($dakungs as $dakung) {
						$this->dakung_model->delete($dakung["id"]);
						
						$this->google->deleteDriveFile($dakung["drive_file_id"]);
					}
				}*/
			}

			// Hanlde Delete Kegiatan Komponen Item
			if (substr($table, 0, strlen("kegiatan_")) === "kegiatan_") {
				$this->load->model("master_komponen_kegiatan_model");
				$this->load->model("komponen_kegiatan_model");

				$komponen = $this->master_komponen_kegiatan_model->get_record_by_table($table);
				
				if (!empty($komponen)) {
					$item = $this->komponen_kegiatan_model->getItemById($komponen->code, $id);
					
					if (isset($item["kegiatan_id"])) {
						$this->load->model("kegiatan_model");
						$kegiatan = $this->kegiatan_model->getKegiatanById($item["kegiatan_id"]);
						
						$this->utility->deleteTtd($kegiatan["kode"], $item["kode"]);
						$this->utility->deleteSurTug($kegiatan["kode"], $item["surat_tugas"]);
					}
				}
			}
			
			if ($table == "user_document") {
				$this->load->model("user_model");
				
				$document = $this->user_model->getDocumentById($id);
				
				if (!empty($document)) {
					$dir = APPPATH . "../assets/user_dokumen/".$document["user_id"];
					$file = $dir."/".$document["filename"];
					
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}

			if ($table == "widyaiswara") {
				$this->load->helper('file');
				$file = APPPATH . "../assets/laporan_wi/".$_SESSION['tahun_anggaran']."/".$id."/";

				delete_files($file, TRUE);
					
				@rmdir($file);
			}

			if ($table == "sertifikat") {				
				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$id.".jpeg";
					
				if (file_exists($file)) {
					unlink($file);
				}

				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$id.".jpg";
				
				if (file_exists($file)) {
					unlink($file);
				}

				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$id."-next.jpeg";
				
				if (file_exists($file)) {
					unlink($file);
				}

				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$id."-next.jpg";
				
				if (file_exists($file)) {
					unlink($file);
				}
			}
			
			if ($table == "penugasan") {
				$this->utility->deleteSurTug('penugasan', 'ST_Penugasan_'.$id.'.pdf');
			}
			
			if ($table == "spj_item") {
				$this->load->model("spj_model");
				
				$spjItem = $this->spj_model->getItemById($id);
				
				$remove = 1;
				
				if (isset($spjItem["kunci"]) && $spjItem["kunci"] == "1") {
					$remove = 0;	
				}
				
				if (isset($spjItem["paid"]) && $spjItem["paid"] == "1") {
					$remove = 0;	
				}
			}
			
			if ($table == "spby") {
				$this->load->model("spby_model");
				
				$spby = $this->spby_model->getById($id);
				
				$remove = 0;
				
				if (isset($spby["nominal"]) && empty($spby["nominal"])) {
					$remove = 1;	
				}
			}
			
			if ($remove) {
				
				$config_tb = $this->config->item('db_master_table');
				
				if (!in_array($table, $config_tb)) {
					$db_tahun = 'transaction_' . $_SESSION['tahun_anggaran']; 
					$transaction_db = $this->load->database($db_tahun, true);

					$transaction_db->where('id', $id);
					$transaction_db->delete($table);
					$transaction_db->reset_query();
				}
				else {
					$this->db->where('id', $id);
					$this->db->delete($table);
					$this->db->reset_query();
				}

				$out["error"] = false;
				
				if (substr($table, 0, strlen("kegiatan_")) === "kegiatan_") {
					$this->load->model("master_komponen_kegiatan_model");
					$this->load->model("komponen_kegiatan_model");
	
					$komponen = $this->master_komponen_kegiatan_model->get_record_by_table($table);
					
					if (!empty($komponen) && isset($item["kegiatan_id"])) {
						$this->komponen_kegiatan_model->refreshNoUrut($komponen->code, $item["kegiatan_id"]);
					}
				}
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Gagal menghapus item";
			}
		}
		
		return $out;
	}

	public function delete_multi_row () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Gagal menghapus data";

		$table = $_POST["table"];
		
		if (isset($_POST["all_rows"]) && $_POST["all_rows"] == "true") {

			if (isset($_POST["parent"]) && !empty($_POST["parent"]) && isset($_POST["parent_field"]) && !empty($_POST["parent_field"])) {
				$parentId = $_POST["parent"];
				$parentField = $_POST["parent_field"];
				$deselectedRows = array();

				if (isset($_POST["deselected_rows"]) && !empty($_POST["deselected_rows"])) {
					foreach ($_POST["deselected_rows"] as $deselected) {
						$deselectedRows[] = $deselected;
					}
				}

				$config_tb = $this->config->item('db_master_table');

				if (!in_array($table, $config_tb)) {
					$db_tahun = 'transaction_' . $_SESSION['tahun_anggaran']; 
					$transaction_db = $this->load->database($db_tahun, true);

					$transaction_db->select('id');
					$transaction_db->from($table);

					$transaction_db->where($parentField, $parentId);

					if (!empty($deselectedRows)) {
						$transaction_db->where_not_in('id', $deselectedRows);
					}

					$data = $transaction_db->get();
		
					if($data->num_rows() > 0) {
						foreach ($data->result_array() as $key => $foo) {
							$out = $this->deleteItem($table, $foo["id"]);
						}
					}
					
					$transaction_db->reset_query();
				}
				else {

					$this->db->select('id');
					$this->db->from($table);

					$this->db->where($parentField, $parentId);

					if (!empty($deselectedRows)) {
						$this->db->where_not_in('id', $deselectedRows);
					}

					$data = $this->db->get();
		
					if($data->num_rows() > 0) {
						foreach ($data->result_array() as $key => $foo) {
							$out = $this->deleteItem($table, $foo["id"]);
						}
					}
					
					$this->db->reset_query();
				}
			}
			
		}
		else if (isset($_POST["selected_rows"]) && !empty($_POST["selected_rows"])) {
			$selectedRows = $_POST["selected_rows"];

			foreach ($selectedRows as $selectedItem) {
				$out = $this->deleteItem($table, $selectedItem);
			}	
		}

		print json_encode($out);
		exit();
	}
	
	public function deleteRow () {
		$out = array();
		$out["error"] = true;
		$out["msg"] = "Berhasil menghapus";
		
		$remove = 1;
		
		if (isset($_POST) && !empty($_POST["id"]) && !empty($_POST["table"])) {
			
			if ($_POST["table"] == "kegiatan") {
				$this->load->model("kegiatan_model");

				$kegiatan = $this->kegiatan_model->getKegiatanById($_POST["id"]);

				if (isset($kegiatan["komponen"]) && !empty($kegiatan["komponen"])) {
					$komponen = array();

					foreach ($kegiatan["komponen"] as $kom => $komOn) {
						if ($komOn) {
							$komponen[] = $kom;
						}
					}

					if (!empty($komponen)) {
						$this->load->model("komponen_kegiatan_model");

						foreach ($komponen as $kom) {
							$items = $this->komponen_kegiatan_model->getItemByKegiatanId($kom, $_POST["id"]);
						
							foreach ($items as $item) {
								$this->komponen_kegiatan_model->delete($kom, $item["id"]);
								
								$this->utility->deleteTtd($kegiatan["kode"], $item["ktp"]);
								$this->utility->deleteSurTug($kegiatan["kode"], $item["surat_tugas"]);
							}
						}
					}
				}
								
				/*if (!empty($dakungs)) {
					foreach ($dakungs as $dakung) {
						$this->dakung_model->delete($dakung["id"]);
						
						$this->google->deleteDriveFile($dakung["drive_file_id"]);
					}
				}*/
			}

			// Hanlde Delete Kegiatan Komponen Item
			if (substr($_POST["table"], 0, strlen("kegiatan_")) === "kegiatan_") {
				$this->load->model("master_komponen_kegiatan_model");
				$this->load->model("komponen_kegiatan_model");

				$komponen = $this->master_komponen_kegiatan_model->get_record_by_table($_POST["table"]);
				
				if (!empty($komponen)) {
					$item = $this->komponen_kegiatan_model->getItemById($komponen->code, $_POST["id"]);
					
					if (isset($item["kegiatan_id"])) {
						$this->load->model("kegiatan_model");
						$kegiatan = $this->kegiatan_model->getKegiatanById($item["kegiatan_id"]);
						
						$this->utility->deleteTtd($kegiatan["kode"], $item["kode"]);
						$this->utility->deleteSurTug($kegiatan["kode"], $item["surat_tugas"]);
					}
				}
			}
			
			if ($_POST["table"] == "user_document") {
				$this->load->model("user_model");
				
				$document = $this->user_model->getDocumentById($_POST["id"]);
				
				if (!empty($document)) {
					$dir = APPPATH . "../assets/user_dokumen/".$document["user_id"];
					$file = $dir."/".$document["filename"];
					
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}

			if ($_POST["table"] == "widyaiswara") {
				$this->load->helper('file');
				$file = APPPATH . "../assets/laporan_wi/".$_SESSION['tahun_anggaran']."/".$_POST["id"]."/";

				delete_files($file, TRUE);
					
				@rmdir($file);
			}

			if ($_POST["table"] == "sertifikat") {				
				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$_POST["id"].".jpeg";
					
				if (file_exists($file)) {
					unlink($file);
				}

				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$_POST["id"].".jpg";
				
				if (file_exists($file)) {
					unlink($file);
				}

				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$_POST["id"]."-next.jpeg";
				
				if (file_exists($file)) {
					unlink($file);
				}

				$file = APPPATH . "../assets/images/sertifikat/".$_SESSION['tahun_anggaran']."/".$_POST["id"]."-next.jpg";
				
				if (file_exists($file)) {
					unlink($file);
				}
			}
			
			if ($_POST["table"] == "penugasan") {
				$this->utility->deleteSurTug('penugasan', 'ST_Penugasan_'.$_POST["id"].'.pdf');
			}
			
			if ($_POST["table"] == "spj_item") {
				$this->load->model("spj_model");
				
				$spjItem = $this->spj_model->getItemById($_POST["id"]);
				
				$remove = 1;
				
				if (isset($spjItem["kunci"]) && $spjItem["kunci"] == "1") {
					$remove = 0;	
				}
				
				if (isset($spjItem["paid"]) && $spjItem["paid"] == "1") {
					$remove = 0;	
				}
			}
			
			if ($_POST["table"] == "spby") {
				$this->load->model("spby_model");
				
				$spby = $this->spby_model->getById($_POST["id"]);
				
				$remove = 0;
				
				if (isset($spby["nominal"]) && empty($spby["nominal"])) {
					$remove = 1;	
				}
			}
			
			if ($remove) {
				
				$config_tb = $this->config->item('db_master_table');
				
				if (!in_array($_POST["table"], $config_tb)) {
					$db_tahun = 'transaction_' . $_SESSION['tahun_anggaran']; 
					$transaction_db = $this->load->database($db_tahun, true);

					$transaction_db->where('id', $_POST["id"]);
					$transaction_db->delete($_POST["table"]);
					$transaction_db->reset_query();
				}
				else {
					$this->db->where('id', $_POST["id"]);
					$this->db->delete($_POST["table"]);
					$this->db->reset_query();
				}

				$out["error"] = false;
				
				if (substr($_POST["table"], 0, strlen("kegiatan_")) === "kegiatan_") {
					$this->load->model("master_komponen_kegiatan_model");
					$this->load->model("komponen_kegiatan_model");
	
					$komponen = $this->master_komponen_kegiatan_model->get_record_by_table($_POST["table"]);
					
					if (!empty($komponen) && isset($item["kegiatan_id"])) {
						$this->komponen_kegiatan_model->refreshNoUrut($komponen->code, $item["kegiatan_id"]);
					}
				}
			}
			else {
				$out["error"] = true;
				$out["msg"] = "Gagal menghapus item";
			}
		}
		
		print json_encode($out);
		exit();
	}
}
