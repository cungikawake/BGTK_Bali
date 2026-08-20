<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-id-card"></i> Penugasan</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->
	<style type="text/css">
		@media (min-width: 768px) {
			.table-penugasan_item .modal-dialog {
				width: 900px;
			}
		}
		.tox-tinymce {
			border: 1px solid #ccc;
		}
		.file-foto {
			border: 1px solid #c9edf9;
			margin-bottom: 10px;
			border-radius: 4px;
			background: #d9edf7;
		}
		.file-foto a {
			padding: 8px 10px;
			display: block;
		}
		.file-foto a i {
			font-size: 18px;
		}
		.signature-pad {
			width: 100%;
			height: 230px;
		}
		.signature-pad canvas {
			border: 1px solid #ccc;
			display: block;
		}
		.signature-pad--actions {
			text-align: right;
			margin-top: 5px;
		}
	</style>
	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12 list-penugasan">										
					<?php
						$conditions = array(
							array(
								"field" => "penugasan_item.ktp",
								"operator" => "=",
								"value" => $_SESSION["biodata"]["ktp"]
							),
							array(
								"field" => "YEAR(penugasan_item.tgl_selesai_tugas)",
								"operator" => "=",
								"value" => $_SESSION["tahun_anggaran"]
							)
						);
					
						$this->bootgrid->setTable("penugasan_item", $conditions);
						$this->bootgrid->setTableJoin("penugasan");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("penugasan_item.penugasan_id = penugasan.id");
						$this->bootgrid->sortBy("penugasan_item.id");
						$this->bootgrid->sortType("DESC");
					
						$this->bootgrid->setTitle("PENUGASAN");

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "penugasan_item.id",
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
							"field" => "penugasan.nama",
							"name" => "Penugasan",
							"format" => "text",
							"class" => "wraptext"
						);
					
						$columns[] = array(
							"id" => "kab_tujuan",
							"field" => "penugasan_item.kab_tujuan",
							"name" => "Tujuan",
							"width" => "120px"
						);
						
						$columns[] = array(
							"id" => "tempat_tujuan",
							"field" => "penugasan_item.tempat_tujuan",
							"name" => "Tempat",
							"width" => "150px",
							"class" => "wraptext"
						);
					
						$columns[] = array(
							"id" => "date_range_tgs",
							"field" => "penugasan_item.tgl_mulai_tugas",
							"name" => "Tgl Tugas",
							"format" => "date_range",
							"date_range" => array(
								"start" => "penugasan_item.tgl_mulai_tugas",
								"end" => "penugasan_item.tgl_selesai_tugas"
							),
							"class" => "wraptext",
							"width" => "120px",
						);
					
						$columns[] = array(
							"id" => "preview",
							"field" => "penugasan_item.id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat'
							),
							"modal" => array(
								"view" => "backend/user/modal_lihat_penugasan"
							),
							"visible" => "false"
						);
					
						$columns[] = array(
							"id" => "status",
							"field" => "penugasan_item.status",
							"name" => "Status",
							"format" => "penugasan_item_status"
						);
					
						$columns[] = array(
							"id" => "buat_laporan_perjadin",
							"field" => "penugasan_item.id",
							"name" => "Laporan",
							"format" => "buat_perjadin_btn"
						);
						
						$columns[] = array(
							"id" => "bukti",
							"field" => "penugasan_item.id",
							"name" => "Bukti",
							"format" => "bukti_pengeluaran",
							"visible" => 'true'
						);
					
						$columns[] = array(
							"id" => "download_laporan_perjadin",
							"field" => "penugasan_item.id",
							"name" => "SPJ",
							"format" => "download_perjadin_btn"
						);
					
						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "penugasan_item.dibuat_tgl",
							"name" => "Dibuat Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);
					
						$columns[] = array(
							"id" => "diubah_tgl",
							"field" => "penugasan_item.diubah_tgl",
							"name" => "Diubah Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);

						$this->bootgrid->setColumns($columns);

						$this->bootgrid->setRowCount('15');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="<?php print base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/signaturePad/signature-pad.js'); ?>"></script>
