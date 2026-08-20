<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-portrait"></i> Penugasan</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<style type="text/css">
		@media (min-width: 768px) {
			.modal-dialog {
				width: 800px;
			}
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<?php
						$conditions = array(
							array(
								"field" => "YEAR(dibuat_tgl)",
								"operator" => "=",
								"value" => $_SESSION["tahun_anggaran"]
							)
						);
					
						$this->bootgrid->setTable("penugasan", $conditions);
						$this->bootgrid->sortBy("dibuat_tgl");
						$this->bootgrid->sortType("DESC");
					
						$this->bootgrid->setTitle("PENUGASAN");

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
							"id" => "nama_penugasan",
							"field" => "nama",
							"name" => "Nama Penugasan",
							"format" => "text",
							"class" => "wraptext"
						);
					
						$columns[] = array(
							"id" => "status",
							"field" => "status",
							"name" => "",
							"format" => "penugasan_status"
						);
					
						$columns[] = array(
							"id" => "preview",
							"field" => "id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat',
								"class" => "preview-penugasan-kegiatan"
							),
							"modal" => array(
								"view" => "backend/kepegawaian/modal_preview_penugasan"
							)
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
							"text" => "Tambah",
							"modal" => array(
								"view" => "backend/kepegawaian/modal_edit_penugasan"
							)
						);
						$this->bootgrid->setAddButton($addButton);
					
						$editButton = array(
							"text" => "Edit",
							"modal" => array(
								"view" => "backend/kepegawaian/modal_edit_penugasan"
							),
							"conditions" => array(
								array(
									"field" => "status",
									"operator" => "==",
									"value" => 0
								),
								array(
									"operator" => " OR ",
								),
								array(
									"field" => "status",
									"operator" => "==",
									"value" => 3
								)
							)
						);
						$this->bootgrid->setEditButton($editButton);
					
						$deleteButton = array(
							"text" => "Delete",
							"conditions" => array(
								array(
									"field" => "status",
									"operator" => "==",
									"value" => 0
								),
								array(
									"operator" => "OR"
								),
								array(
									"field" => "status",
									"operator" => "==",
									"value" => 3
								)
							)
						);
						$this->bootgrid->setDeleteButton($deleteButton);

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
<script src="<?php print base_url('assets/js/kepegawaian.js?v='.rand()); ?>"></script>
