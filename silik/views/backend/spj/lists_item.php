<?php $this->load->view("backend/includes/header"); ?>
	<style type="text/css">
		.checkbox input[type=checkbox] + .cr:before {
			margin-right: 0;
		}
		.row-event-click.btn > i {
			margin-right: 0;
		}
		.wrap-table-bootgrid table tr th:last-child,
		.wrap-table-bootgrid table tr td:last-child {
			width: 90px !important;
		}
		.form-group-sm select.form-control.select-mak {
			padding: 5px 4px;
			line-height: 20px;
			height: 20px;
		}
		.mcm-remark, .mcm-remark:hover, .mcm-remark:active {
			padding: 0 !important;
			font-size: 19px !important;
			background:none !important;
			border: none !important;
			color: #999 !important;
		}
		.p-r-40 {
			padding-right: 40px;
		}
		
		@media (min-width: 768px) {
			.modal-dialog.modal-spby {
				width: 900px;
			}
		}
		
		.spby-items {
			height: 250px;
			overflow-y: auto;
			border: 1px solid #ccc;
		}
		.table-spby-items {
			margin-bottom: 0;
		}
		
		.table-spby-items > thead {
			border-top: 1px solid #ccc;
		}
		
		.table-spby-items > tfoot {
			border-bottom: 1px solid #ccc;
		}
		.border-spj-left {
			border-left: 1px solid #ccc;
			padding-left: 12px !important;
		}
		.border-spj-right {
			border-right: 1px solid #ccc;
			padding-right: 12px !important;
		}
	</style>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<?php if (!empty($spj["kegiatan_id"])) { ?>
							<h5>SPJ Kegiatan - <?php print $spj["nama"]; ?></h5>
							<p class="m-b-0">Tanggal Kegiatan: <?php print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></p>
							
							<?php if ($kegiatan["tipe_kegiatan"] == "Daring") { ?>
								<p class="m-b-20">Tempat: <?php print $kegiatan["zoom_id_kegiatan"]; ?></p>
							<?php } else { ?>
								<p class="m-b-20">Tempat: <?php print $kegiatan["tempat_kegiatan"]." (".$kegiatan["kab_tempat_kegiatan"].")"; ?></p>
							<?php } ?>
							
						<?php } else { ?>
							<h5>SPJ Penugasan - <?php print $spj["nama"]; ?></h5>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<?php $this->load->view("backend/spj/menu"); ?>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<div class="spj-items">
					<?php
						$showTiket = true;
						$showPulsa = false;
						$showTransport = true;
						$showHonor = false;
						$showPenginapan = true;
						$showUangHarian = true;
						$showCheckLaporan = true;
						$showCheckListST = true;
						$showCheckListSPD = true;
						$showTglKuitansi = true;
						$showPaid = true;

						/*if (isset($penugasan) && !empty($penugasan) && isset($penugasan["petugas"]) && !empty($penugasan["petugas"])) {

							foreach ($penugasan["petugas"] as $petugasDetail) {
								if ($petugasDetail["provinsi_tujuan"] != $_ENV['DEFAULT_PROVINSI']) {
									$showTiket = true;
									$showTransport = false;
									$showHonor = false;
								}
							}
							
							$showCheckListST = false;
							$showCheckListSPD = false;
							$showCheckLaporan = true;
							$showTglKuitansi = true;
							$showPaid = true;
						}

						if (isset($spj["komponen"]) && ($spj["komponen"] == "peserta" || $spj["komponen"] == "petugas")) {
							$showHonor = false;
						}
						
						if (isset($spj["komponen"]) && ($spj["komponen"] == "petugas" || $spj["komponen"] == "narasumber")) {
							$showPenginapan = true;
						}
						
						if (isset($kegiatan["tipe_kegiatan"]) && $kegiatan["tipe_kegiatan"] == "Daring") {
							$showTiket = false;
							$showTransport = false;
							$showPenginapan = false;
							$showUangHarian = false;
							$showPulsa = true;
						}
						
						if (isset($spj_item) && !empty($spj_item)) {
							foreach ($spj_item as $boo) {
								if ($boo["provinsi_asal"] != $boo["provinsi_tujuan"]) {
									$showTiket = true;
									$showTransport = false;
								}
							}
						}*/
						
						$kab_asal = "kab_asal";
						$kab_tujuan = "kab_tujuan";
						
						if ($showTiket) {
							//$kab_asal = "provinsi_asal";
							//$kab_tujuan = "provinsi_tujuan";
						}
						
						
						
						// Table Builder
						$conditions = array(
							array(
								"field" => "spj_id",
								"operator" => "=",
								"value" => $spj["id"]
							)
						);
						
						
						$this->bootgrid->setTable("spj_item", $conditions);
						$this->bootgrid->sortBy("no_urut");
						$this->bootgrid->sortType("ASC");
						
						/*$cardLink = array();
						$cardLink[] = array(
							"target" => "/admin/spj/export_mcm/".$spj["id"],
							"icon" => "fas fa-file-excel",
							"text" => "Export MCM Excel"
						);

						$this->bootgrid->setCardLink($cardLink);*/
						
						if ($showHonor && $showPulsa) {
							$this->bootgrid->setTitle("PULSA / PAKET DATA & HONOR ".strtoupper(str_replace("_"," ",$spj["komponen"])));
						}
						else if ($showPulsa) {
							$this->bootgrid->setTitle("PULSA / PAKET DATA ".strtoupper(str_replace("_"," ",$spj["komponen"])));
						}
						else if ($showHonor) {
							$this->bootgrid->setTitle("TRANSPORT & HONOR ".strtoupper(str_replace("_"," ",$spj["komponen"])));
						}
						else {
							$this->bootgrid->setTitle("TRANSPORT ".strtoupper(str_replace("_"," ",$spj["komponen"])));
						}

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "id",
							"name" => "ID",
							"type" => "numeric",
							"width" => "25px",
							"identifier" => "true",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "penugasan_item_id",
							"field" => "penugasan_item_id",
							"name" => "Penugasan Item Id",
							"type" => "numeric",
							"width" => "25px",
							"identifier" => "true",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "autonumeric",
							"field" => "autonumeric",
							"name" => "No",
							"type" => "autonumeric",
							"width" => "25px",
							"visible" => "true"
						);
					
						$columns[] = array(
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama ".ucfirst(str_replace("_"," ",$spj["komponen"]))
						);
						
						$columns[] = array(
							"id" => "kab_asal",
							"field" => $kab_asal,
							"name" => "Asal",
							"class" => "border-spj-left",
							"visible" => $showTransport || $showTiket ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "kab_tujuan",
							"field" => $kab_tujuan,
							"name" => "Tujuan",
							"visible" => $showTransport || $showTiket ? 'true' : 'false'
						);

						if (isset($kegiatan_options["kategori"]) && !empty($kegiatan_options["kategori"])) {
							$columns[] = array(
								"id" => "kategori",
								"field" => "kategori",
								"name" => "Kelas",
								"class" => "border-spj-left",
							);
						}
						
						
						/*$columns[] = array(
							"id" => "telp",
							"field" => "telp",
							"name" => "No Hp",
							"class" => "border-spj-left",
							"visible" => $showPulsa ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "pulsa",
							"field" => "pulsa",
							"name" => "Pulsa",
							"format" => "money",
							"visible" => $showPulsa ? 'true' : 'false'
						);*/
						
						$columns[] = array(
							"id" => "pesawat_berangkat",
							"field" => "pesawat_berangkat",
							"name" => "Tiket Berangkat",
							"format" => "money",
							"class" => "border-spj-left",
							"visible" => $showTiket ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "pesawat_pulang",
							"field" => "pesawat_pulang",
							"name" => "Tiket Pulang",
							"format" => "money",
							"visible" => $showTiket ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "total_pesawat",
							"field" => "pesawat_pulang",
							"name" => "Total Tiket",
							"format" => "formula_money",
							"formula" => "{{pesawat_berangkat}}+{{pesawat_pulang}}",
							"visible" => $showTiket ? 'true' : 'false'
						);
						
						
						$columns[] = array(
							"id" => "taksi_berangkat",
							"field" => "taksi_berangkat",
							"name" => "Taksi Asal",
							"format" => "money",
							"class" => "border-spj-left",
							"visible" => $showTiket ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "taksi_pulang",
							"field" => "taksi_pulang",
							"name" => "Taksi Tujuan",
							"format" => "money",
							"visible" => $showTiket ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "total_taksi",
							"field" => "taksi_berangkat",
							"name" => "Total Taksi",
							"format" => "formula_money",
							"formula" => "{{taksi_berangkat}}+{{taksi_pulang}}",
							"visible" => $showTiket ? 'true' : 'false'
						);
						
						
						$columns[] = array(
							"id" => "transport",
							"field" => "transport",
							"name" => "Transport PP",
							"class" => "border-spj-left",
							"format" => "money",
							"visible" => $showTransport ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "perjalanan",
							"field" => "tgl_selesai_tugas",
							"name" => "Perjalanan",
							"format" => "jumlah_perjalanan",
							"visible" => $showTransport ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "jumlah_transport",
							"field" => "tgl_selesai_tugas",
							"name" => "Jumlah Transport",
							"format" => "jumlah_transport",
							"visible" => $showTransport ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "transport_lainnya",
							"field" => "transport_lainnya",
							"name" => "Trans. Lainnya",
							"class" => "border-spj-left",
							"format" => "money",
							"visible" => $showTransport ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "uang_harian",
							"field" => "uang_harian",
							"name" => "U. Harian / Hari",
							"class" => "border-spj-left",
							"format" => "money",
							"visible" => $showUangHarian ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "lama_tugas",
							"field" => "tgl_selesai_tugas",
							"name" => "Lama Tugas",
							"format" => "lama_tugas",
							"visible" => $showUangHarian ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "jumlah_uang_harian",
							"field" => "uang_harian",
							"name" => "Jumlah UH",
							"format" => "jumlah_uang_harian",
							"visible" => $showUangHarian ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "penginapan",
							"field" => "penginapan",
							"name" => "Hotel / Mlm",
							"format" => "money",
							"class" => "border-spj-left",
							"visible" => $showPenginapan ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "lama_nginap",
							"field" => "penginapan",
							"name" => "Lama Nginap",
							"format" => "lama_nginap",
							"visible" => $showPenginapan ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "jumlah_penginapan",
							"field" => "penginapan",
							"name" => "Jumlah Hotel",
							"format" => "jumlah_penginapan",
							"visible" => $showPenginapan ? 'true' : 'false'
						);
						
						/*$columns[] = array(
							"id" => "honor",
							"field" => "honor",
							"name" => "Honor / Vol",
							"format" => "money",
							"class" => "border-spj-left",
							"visible" => $showHonor ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "vol_honor",
							"field" => "vol_honor",
							"name" => "Vol",
							"format" => "vol_honor",
							"visible" => $showHonor ? 'true' : 'false'
						);
						$columns[] = array(
							"id" => "jumlah_honor",
							"field" => "honor",
							"name" => "Honor Bruto",
							"format" => "jumlah_honor",
							"visible" => $showHonor ? 'true' : 'false'
						);
						
						$columns[] = array(
							"id" => "pajak",
							"field" => "pajak",
							"name" => "Pajak",
							"formula" => "{{pajak}}",
							"format" => "formula_pct",
							"visible" => $showHonor ? 'true' : 'false'
						);
						
						$columns[] = array(
							"id" => "pajak_money",
							"field" => "pajak",
							"name" => "Pajak",
							"format" => "formula_money",
							"formula" => "(({{honor}}*{{vol_honor}})*{{pajak}}/100)",
							"visible" => $showHonor ? 'true' : 'false'
						);
						
						$columns[] = array(
							"id" => "honor_neto",
							"field" => "honor",
							"name" => "Honor Neto",
							"format" => "formula_money",
							"formula" => "({{honor}}*{{vol_honor}})-(({{honor}}*{{vol_honor}})*{{pajak}}/100)",
							"visible" => $showHonor ? 'true' : 'false'
						);*/
						
						$columns[] = array(
							"id" => "jumlah_diterima",
							"field" => "transport",
							"name" => "Jumlah Diterima",
							"format" => "jumlah_diterima",
							"class" => "border-spj-left"
						);
						
						
						/*$columns[] = array(
							"id" => "check_st",
							"field" => "check_st",
							"name" => "ST",
							"format" => "checklist",
							"class" => "updateST",
							"width" => "20px",
							"visible" => $showCheckListST || $showCheckListST ? 'true' : 'false'
						);
						
						$columns[] = array(
							"id" => "check_spd",
							"field" => "check_spd",
							"name" => "SPD",
							"format" => "checklist",
							"class" => "updateSPD",
							"width" => "20px",
							"visible" => $showCheckListSPD || $showCheckListSPD ? 'true' : 'false'
						);*/
						
						if (empty($spj["kegiatan_id"])) {
							$columns[] = array(
								"id" => "check_laporan",
								"field" => "check_laporan",
								"name" => "Terima Laporan",
								"format" => "checklist_laporan",
								"class" => "updateLP",
								"width" => "20px",
								"visible" => $showCheckLaporan || $showCheckLaporan ? 'true' : 'false'
							);

							$columns[] = array(
								"id" => "tgl_kuitansi",
								"field" => "tgl_kuitansi",
								"name" => "Tgl Pembayaran",
								"format" => "tgl_kuitansi",
								"visible" => $showTglKuitansi || $showTglKuitansi ? 'true' : 'false'
							);
						}
						
						$columns[] = array(
							"id" => "kunci",
							"field" => "kunci",
							"name" => "Lock",
							"format" => "lock",
							"class" => "lock",
							"onclick" => "Spj_Keuangan.updateLock(this);",
							"width" => "50px"
						);
						
						if (!empty($spj["kegiatan_id"])) {
							$columns[] = array(
								"id" => "print",
								"field" => "print",
								"name" => "Print",
								"format" => "print",
								"class" => "print",
								"onclick" => "window.open('/admin/spj/print_selected_item/{{id}}','_blank')",
								"width" => "50px",
								"visible" => 'false'
							);
						}
						
						$columns[] = array(
							"id" => "paid",
							"field" => "paid",
							"name" => "Paid",
							"format" => "paidSpjItem",
							"class" => "paid",
							"width" => "40px",
							"visible" => $showPaid || $showPaid ? 'true' : 'false'
						);
						
						if (empty($spj["kegiatan_id"])) {
							$columns[] = array(
								"id" => "ubah_status",
								"field" => "id",
								"name" => "Status",
								"format" => "button",
								"button" => array(
									"class" => "",
									"text" => "Status"
								),
								"modal" => array(
									"view" => "backend/spj/modal_edit_status"
								),
								"visible" => 'false'
							);

							$columns[] = array(
								"id" => "laporan",
								"field" => "penugasan_item_id",
								"name" => "Laporan",
								"format" => "button",
								"button" => array(
									"class" => "",
									"text" => "Laporan"
								),
								"link" => array(
									"url" => "/admin/user/laporan_perjadin/{{penugasan_item_id}}",
									"target" => "_blank"
								),
								"visible" => 'true'
							);
							
							$columns[] = array(
								"id" => "bukti",
								"field" => "penugasan_item_id",
								"name" => "Bukti",
								"format" => "bukti_pengeluaran",
								"visible" => 'true'
							);
						}
						
						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "dibuat_tgl",
							"name" => "Dibuat Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);
					
						$columns[] = array(
							"id" => "diubah_tgl",
							"field" => "diubah_tgl",
							"name" => "Diubah Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);
						
						
						$addButton = array(
							"text" => "Import",
							"modal" => array(
								"view" => "backend/spj/modal_import",
								"data" => array(
									"komponen" => $spj["komponen"],
									"spj_id" => $spj["id"],
									"kegiatan_id" => $spj["kegiatan_id"],
									"penugasan_id" => $spj["penugasan_id"]
								)
							)
						);
						$this->bootgrid->setAddButton($addButton);
						
						
						$lockButton = array(
							"spj" => $spj["id"],
							"lock" => $spj["kunci"]
						);
						$this->bootgrid->setLockButton($lockButton);
						
						
						if (!empty($spj["kegiatan_id"])) {
							$toolbarButton = array(
								"class" => "print_rincian_perjalanan_dinas",
								"title" => "Print Rincian Perjalanan Dinas",
								"icon" => "fas fa-print"
							);

							$this->bootgrid->setToolbarButton($toolbarButton);
							
							$toolbarButton = array(
								"class" => "print_amplop",
								"title" => "Print Amplop",
								"icon" => "fas fa-envelope"
							);

							$this->bootgrid->setToolbarButton($toolbarButton);
						}
						
						if (!empty($spj["kegiatan_id"])) {
							$this->bootgrid->setCustomFilter("kabupaten_kota");
						}
						else {
							$this->bootgrid->setCustomFilter("kabupaten_kota_tujuan");
						}

						if (isset($kegiatan_options["kategori"]) && !empty($kegiatan_options["kategori"])) {
							$this->bootgrid->setCustomFilter("kelas", $kegiatan_options["kategori"]);
						}
						
						$editButton = array(
							"text" => "<i class='fas fa-edit'></i>",
							"modal" => array(
								"view" => "backend/spj/modal_edit_item"
							)
						);
						$this->bootgrid->setEditButton($editButton);

						$deleteButton = array(
							"text" => "<i class='fas fa-trash-alt'></i>"
						);
						$this->bootgrid->setDeleteButton($deleteButton);

						$this->bootgrid->setColumns($columns);

						$this->bootgrid->setRowCount('10');

						print $this->bootgrid->render();
					?>
					</div>
					
					<div class="spby-list">
						<?php
							// Table Builder						
							$conditions = array(
								array(
									"field" => "spj_id",
									"operator" => "=",
									"value" => $spj["id"]
								)
							);

							$this->bootgrid->setTable("spby", $conditions);
							$this->bootgrid->sortBy("dibuat_tgl");
							$this->bootgrid->sortType("ASC");
						
							$this->bootgrid->setTitle("SURAT PERINTAH BAYAR");
							
							$columns = array();
							$columns[] = array(
								"id" => "id",
								"field" => "id",
								"name" => "ID",
								"type" => "numeric",
								"width" => "25px",
								"identifier" => "true",
								"visible" => "false"
							);
							$columns[] = array(
								"id" => "autonumeric",
								"field" => "autonumeric",
								"name" => "No",
								"type" => "autonumeric",
								"width" => "25px",
								"visible" => "true"
							);
							$columns[] = array(
								"id" => "penerima",
								"field" => "penerima",
								"name" => "Penerima",
								"visible" => "true"
							);
							$columns[] = array(
								"id" => "deskripsi",
								"field" => "deskripsi",
								"name" => "Deskripsi",
								"visible" => "true",
								"class" => "wraptext"
							);
							$columns[] = array(
								"id" => "dipa_akun",
								"field" => "dipa_akun",
								"name" => "Akun",
								"visible" => "true"
							);
							$columns[] = array(
								"id" => "nominal",
								"field" => "nominal",
								"name" => "Jumlah",
								"format" => "money",
								"visible" => "true"
							);
						
							$columns[] = array(
								"id" => "pajak",
								"field" => "pajak",
								"name" => "Pajak",
								"format" => "money",
								"visible" => "true"
							);
						
							$columns[] = array(
								"id" => "transfer",
								"field" => "transfer",
								"name" => "Transfer",
								"format" => "money",
								"visible" => "true"
							);
						
							
							if (!empty($spj["kegiatan_id"])) {
								$printSPDPaketMeeting = 1;
							}
							else {
								$printSPDPaketMeeting = 0;
							}
						
							$columns[] = array(
								"id" => "print_item",
								"field" => "id",
								"name" => "",
								"format" => "print",
								"class" => "print text-center",
								"onclick" => "Spj_Keuangan.printSPBy(this,".$printSPDPaketMeeting.");",
								"width" => "40px"
							);
							
							if ($this->utility->hasUserAccess("spj","pembayaran")) { 
								/*$columns[] = array(
									"id" => "export_mcm",
									"field" => "id",
									"name" => "",
									"format" => "mcm",
									"class" => "text-center",
									"onclick" => "Spj_Keuangan.exportMCM(this);",
									"width" => "40px"
								);*/
								
								$columns[] = array(
									"id" => "export_mcm",
									"field" => "id",
									"name" => "",
									"format" => "button",
									"class" => "text-center",
									"button" => array(
										"text" => "<i class='fas fa-file-excel'></i>",
										"class" => "mcm-remark"
									),
									"modal" => array(
										"view" => "backend/spj/modal_mcm_remark"
									)
								);

								$columns[] = array(
									"id" => "paid",
									"field" => "paid",
									"name" => "",
									"format" => "paidSpby",
									"class" => "paid",
									"onclick" => "Spj_Keuangan.paySPBy(this);",
									"width" => "32px"
								);
							}
							else {
								$columns[] = array(
									"id" => "paid",
									"field" => "paid",
									"name" => "",
									"format" => "paidSpby",
									"class" => "paid",
									"width" => "32px"
								);
							}
							
							$columns[] = array(
								"id" => "dibuat_tgl",
								"field" => "dibuat_tgl",
								"name" => "Dibuat Tgl",
								"format" => "date",
								"date" => array(
									"format" => "d/m/Y H:i a"
								),
								"visible" => "false"
							);
							$columns[] = array(
								"id" => "diubah_tgl",
								"field" => "diubah_tgl",
								"name" => "Diubah Tgl",
								"format" => "date",
								"date" => array(
									"format" => "d/m/Y H:i a"
								),
								"visible" => "false"
							);
						
							$addButton = array(
								"text" => "Tambah",
								"modal" => array(
									"view" => "backend/spj/modal_spby",
									"data" => array(
										"spj_id" => $spj["id"]
									)
								)
							);
							$this->bootgrid->setAddButton($addButton);
						
							$editButton = array(
								"text" => "<i class='fas fa-edit'></i>",
								"modal" => array(
									"view" => "backend/spj/modal_spby"
								)
							);
							$this->bootgrid->setEditButton($editButton);

							$deleteButton = array(
								"text" => "<i class='fas fa-trash-alt'></i>"
							);
							$this->bootgrid->setDeleteButton($deleteButton);
						
							$this->bootgrid->setColumns($columns);

							$this->bootgrid->setRowCount('10');

							print $this->bootgrid->render();
						?>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="<?php print base_url('assets/js/spj_keuangan.js?v='.rand()); ?>"></script>
