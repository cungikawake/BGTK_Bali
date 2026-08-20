<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-book"></i> Monitoring Laporan Kegiatan</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<?php
						$conditions = array(
							array(
								"field" => "kegiatan.buat_laporan",
								"operator" => "=",
								"value" => "1"
							)
						);
						$this->bootgrid->setTable("kegiatan", $conditions);
						$this->bootgrid->setTitle("MONITORING LAPORAN KEGIATAN");
						$this->bootgrid->setTableJoin("arsip");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("kegiatan.id = arsip.kegiatan_id");
					
						$this->bootgrid->sortBy("kegiatan.tgl_mulai_kegiatan");
						$this->bootgrid->sortType("DESC");

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "kegiatan.id",
							"name" => "ID",
							"type" => "numeric",
							"width" => "25px",
							"identifier" => "true",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "kode",
							"field" => "kegiatan.kode",
							"name" => "Kode",
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
							"id" => "program",
							"field" => "kegiatan.program",
							"name" => "Program",
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "nama",
							"field" => "kegiatan.nama",
							"name" => "Nama",
							"class" => "wraptext",
							"width" => "700px"
						);
						
						$columns[] = array(
							"id" => "tipe_kegiatan",
							"field" => "kegiatan.tipe_kegiatan",
							"name" => "Tipe",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "tgl_mulai_kegiatan",
							"field" => "kegiatan.tgl_mulai_kegiatan",
							"name" => "Tgl Kegiatan",
							"format" => "date_range",
							"date_range" => array(
								"start" => "kegiatan.tgl_mulai_kegiatan",
								"end" => "kegiatan.tgl_selesai_kegiatan"
							),
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "progress_laporan",
							"field" => "kegiatan.progress_laporan",
							"name" => "Progress Laporan",
							"format" => "laporan_kegiatan_status",
							"visible" => "true"
						);
						
						$columns[] = array(
							"id" => "pembuat_laporan",
							"field" => "arsip.dibuat_oleh",
							"name" => "Pembuat Laporan",
							"format" => "nama_admin",
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "arsip_kode",
							"field" => "arsip.kode",
							"name" => "Kode Arsip",
							"visible" => "true"
						);

						if ($this->utility->hasUserAccess("laporan","laporan_kegiatan_spi")) {
							$columns[] = array(
								"id" => "petugas_spi",
								"field" => "kegiatan.progress_laporan",
								"name" => "Petugas SPI",
								"format" => "laporan_kegiatan_spi",
								"visible" => "true"
							);
						}

						if ($this->utility->hasUserAccess("laporan","laporan_kegiatan_kepala")) {
							$columns[] = array(
								"id" => "laporan_kepala",
								"field" => "kegiatan.progress_laporan",
								"name" => "Kepala Balai",
								"format" => "laporan_kegiatan_kepala",
								"visible" => "true"
							);
						}

						if ($this->utility->hasUserAccess("laporan","laporan_kegiatan_jilid")) {
							$columns[] = array(
								"id" => "petugas_jilid",
								"field" => "kegiatan.progress_laporan",
								"name" => "Petugas Jilid",
								"format" => "laporan_kegiatan_jilid",
								"visible" => "true"
							);
						}
						

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
<script src="<?php print base_url('assets/js/monitoring_laporan_kegiatan.js?v='.rand()); ?>"></script>
