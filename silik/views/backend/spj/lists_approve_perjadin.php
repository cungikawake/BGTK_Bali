<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-pocket"></i> Approval Laporan Perjadin</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<ul class="nav nav-pills mb-4">
		<li class="nav-item">
			<a class="nav-link <?php print ($status == '2') ? 'active' : ''; ?>" href="<?php print base_url("admin/spj/approve_perjadin/"); ?>">Menunggu</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php print ($status == '3') ? 'active' : ''; ?>" href="<?php print base_url("admin/spj/approve_perjadin/3"); ?>">Disetujui</a>
		</li>
	</ul>

	<style type="text/css">
		@media (min-width: 768px) {
			.table-penugasan_item .modal-dialog {
				width: 900px;
			}
		}
		.iframe-laporan iframe {
			width: 100%;
			border: 1px solid #ccc;
			min-height: 400px;
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
								"field" => "penugasan_item.status",
								"operator" => "=",
								"value" => $status
							)
						);
					
						$this->bootgrid->setTable("penugasan_item", $conditions);
						$this->bootgrid->setTableJoin("penugasan");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("penugasan_item.penugasan_id = penugasan.id");
						$this->bootgrid->sortBy("penugasan_item.dibuat_tgl");
						$this->bootgrid->sortType("DESC");
					
						if ($status == '2') {
							$this->bootgrid->setTitle("MENUNGGU PERSETUJUAN");
						}
						else if ($status == '3') {
							$this->bootgrid->setTitle("TELAH DISETUJUI");
						}

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
							"id" => "nama_pegawai",
							"field" => "penugasan_item.nama",
							"name" => "Nama",
							"format" => "text"
						);
					
						$columns[] = array(
							"id" => "kab_tujuan",
							"field" => "penugasan_item.kab_tujuan",
							"name" => "Tujuan"
						);
					
						$columns[] = array(
							"id" => "tgl_mulai_tugas",
							"field" => "penugasan_item.tgl_mulai_tugas",
							"name" => "Tgl Tugas",
							"format" => "date_range",
							"date_range" => array(
								"start" => "penugasan_item.tgl_mulai_tugas",
								"end" => "penugasan_item.tgl_selesai_tugas"
							)
						);
					
						$columns[] = array(
							"id" => "lama_tugas",
							"field" => "penugasan_item.tgl_mulai_tugas",
							"name" => "Lama Tugas",
							"format" => "day_counter",
							"day_counter" => array(
								"start" => "penugasan_item.tgl_mulai_tugas",
								"end" => "penugasan_item.tgl_selesai_tugas"
							)
						);
					
						$columns[] = array(
							"id" => "status",
							"field" => "penugasan_item.status",
							"name" => "Status",
							"format" => "penugasan_item_status"
						);
						
						$columns[] = array(
							"id" => "preview",
							"field" => "penugasan_item.id",
							"name" => "Laporan",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat'
							),
							"modal" => array(
								"view" => "backend/spj/modal_approve_perjadin"
							)
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
<script src="<?php print base_url('assets/js/spj_keuangan.js?v='.rand()); ?>"></script>
