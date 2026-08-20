<?php $this->load->view("backend/includes/header"); ?>
	<style type="text/css">
		.checkbox input[type=checkbox] + .cr:before {
			margin-right: 0;
		}
		.row-event-click.btn > i {
			margin-right: 0;
		}
	</style>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5>SPJ Kegiatan <?php print $kegiatan["tipe_kegiatan"]; ?> - <?php print $kegiatan["nama"]; ?></h5>
						<p class="m-b-0">Tanggal Kegiatan: <?php print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]); ?></p>
						<p class="m-b-20">Tempat: <?php print $kegiatan["tempat_kegiatan"]." (".$kegiatan["kab_tempat_kegiatan"].")"; ?></p>
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
					<div class="spj-<?php print $unsur; ?>">
					<?php
						$conditions = array(
							array(
								"field" => "spj_id",
								"operator" => "=",
								"value" => $spj["id"]
							)
						);
						
						$this->bootgrid->setTable("spj_kegiatan_".$unsur, $conditions);
						$this->bootgrid->sortBy("no_urut");
						$this->bootgrid->sortType("ASC");
						$this->bootgrid->setTitle("TRANSPORT & HONOR");

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
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama ".ucfirst($unsur)
						);
						$columns[] = array(
							"id" => "golongan",
							"field" => "golongan",
							"name" => "Gol"
						);
						$columns[] = array(
							"id" => "transport_asal",
							"field" => "transport_asal",
							"name" => "Asal"
						);
						$columns[] = array(
							"id" => "transport_tujuan",
							"field" => "transport_tujuan",
							"name" => "Tujuan"
						);
						$columns[] = array(
							"id" => "transport",
							"field" => "transport",
							"name" => "Transport",
							"format" => "money"
						);
						$columns[] = array(
							"id" => "uang_harian",
							"field" => "uang_harian",
							"name" => "Uang Harian",
							"format" => "money"
						);
						
						$columns[] = array(
							"id" => "honor",
							"field" => "honor",
							"name" => "Honor/Vol",
							"format" => "money"
						);
						
						$columns[] = array(
							"id" => "jam_honor",
							"field" => "jam_honor",
							"name" => "Vol",
							"format" => "volumen_honor"
						);
						
						$columns[] = array(
							"id" => "pajak",
							"field" => "pajak",
							"name" => "Pajak",
							"format" => "text_persen"
						);
						
						$columns[] = array(
							"id" => "surat_tugas",
							"field" => "surat_tugas",
							"name" => "ST",
							"format" => "checklist",
							"class" => "updateST",
							"width" => "20px"
						);
						
						$columns[] = array(
							"id" => "spd",
							"field" => "spd",
							"name" => "SPD",
							"format" => "checklist",
							"class" => "updateSPD",
							"width" => "20px"
						);
						
						$columns[] = array(
							"id" => "kunci",
							"field" => "kunci",
							"name" => "",
							"format" => "lock",
							"class" => "lock",
							"onclick" => "SPJ.updateLock(this);",
							"width" => "40px"
						);
						
						$columns[] = array(
							"id" => "print_".$unsur,
							"field" => "print",
							"name" => "",
							"format" => "print",
							"class" => "print",
							"onclick" => "SPJ.printDok(this);",
							"width" => "40px"
						);
					
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
									"unsur" => $unsur
								)
							)
						);
						$this->bootgrid->setAddButton($addButton);
						
						$printBtn = array(
							"class" => "printSelected",
							"title" => "Print SPJ",
							"icon" => "fas fa-print mr-0"
						);
						$this->bootgrid->setToolbarButton($printBtn);
						
						$printBtn = array(
							"class" => "printSpby",
							"title" => "Print SPBy",
							"icon" => "fas fa-file-alt mr-0"
						);
						$this->bootgrid->setToolbarButton($printBtn);
						
						$lockButton = array(
							"unsur" => $unsur,
							"spj" => $spj["id"],
							"lock" => $spj["lock_".$unsur]
						);
						$this->bootgrid->setLockButton($lockButton);
					
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

						$this->bootgrid->setRowCount('15');

						print $this->bootgrid->render();
					?>
					</div>
					
					<div class="spj-realisasi">
						<div class="card">
							<div class="card-header">
								<h5 class="bootgrid-title">REALISASI</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div id="table-realisasi">
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="<?php print base_url('assets/js/spj.js?v='.rand()); ?>"></script>
