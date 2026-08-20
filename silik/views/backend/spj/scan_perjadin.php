<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-barcode"></i> Terima Laporan Perjadin</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->
	<style type="text/css">
		.bootgrid-table td.select-cell, .bootgrid-table th.select-cell {
			width: 38px;
		}
		.table-condensed>tbody>tr>td {
			overflow: visible;
			white-space: normal;
		}
		select.select-mak {
			padding: 7px 4px;
		}
		.input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
			margin-left: -1px;
			border-top-left-radius: 0;
			border-bottom-left-radius: 0;
			padding: 9px 20px 9px;
		}
		.scan-barcode-body .card:nth-child(2) {
			box-shadow: 0 1px 1px 0 rgba(69, 90, 100, 0.08);
		}
		.scan-barcode-body .card:nth-child(2) .card-header,
		.scan-barcode-body .card:nth-child(2) .card-body .bootgrid-header
		{
			display: none;
		}
		.scan-barcode-body .card:nth-child(2) .card-body {
			padding-top: 15px;
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12 scan-barcode-body">
					<div class="card" style="margin-bottom: 0;">
						<div class="card-header">
							<h5 class="bootgrid-title">TERIMA LAPORAN PERJADIN</h5>
						</div>
						<div class="card-body" style="padding-bottom: 0;">
							<div class="row">
								<div class="col-md-6">
									<form action="" class="scan-barcode-form" autocomplete="off">
										<div class="input-group mb-3">
											<input type="text" name="" id="barcode-reader" class="form-control" placeholder="Nomor Laporan" />
											<button type="submit" class="btn btn-info">CARI</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<?php
						$conditions = array(
							array(
								"field" => "DATE(spj_item.terima_laporan_tgl)",
								"operator" => "=",
								"value" => date("Y-m-d")
							)
						);


						$this->bootgrid->setTable("spj_item", $conditions);
						$this->bootgrid->setTableJoin("penugasan_item");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("penugasan_item.id = spj_item.penugasan_item_id");
						$this->bootgrid->sortBy("terima_laporan_tgl");
						$this->bootgrid->sortType("ASC");

						$columns = array();
						$columns[] = array(
							"id" => "autonumeric",
							"field" => "autonumeric",
							"name" => "No",
							"type" => "autonumeric",
							"width" => "25px",
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "id",
							"field" => "spj_item.id",
							"name" => "ID",
							"type" => "numeric",
							"width" => "25px",
							"identifier" => "true",
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "nama",
							"field" => "spj_item.nama",
							"name" => "Nama"
						);
					
						$columns[] = array(
							"id" => "kab_tujuan",
							"field" => "penugasan_item.kab_tujuan",
							"name" => "Tujuan"
						);
						
						$columns[] = array(
							"id" => "tempat_tujuan",
							"field" => "penugasan_item.tempat_tujuan",
							"name" => "Tempat"
						);
					
						$columns[] = array(
							"id" => "date_range_tgs",
							"field" => "penugasan_item.tgl_mulai_tugas",
							"name" => "Tgl Tugas",
							"format" => "date_range",
							"date_range" => array(
								"start" => "penugasan_item.tgl_mulai_tugas",
								"end" => "penugasan_item.tgl_selesai_tugas"
							)
						);
					
						$columns[] = array(
							"id" => "preview",
							"field" => "id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat'
							),
							"modal" => array(
								"view" => "backend/user/modal_lihat_penugasan"
							)
						);
					
						$columns[] = array(
							"id" => "check_laporan_oleh",
							"field" => "spj_item.check_laporan_oleh",
							"name" => "Diterima",
							"format" => "nama_admin"
						);

						$this->bootgrid->setColumns($columns);

						$this->bootgrid->setRowCount('-1');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="<?php print base_url('assets/js/spj_keuangan.js?v='.rand()); ?>"></script>
