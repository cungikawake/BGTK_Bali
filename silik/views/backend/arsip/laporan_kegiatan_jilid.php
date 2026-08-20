<?php
$this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fa fa-archive"></i> Jilid Laporan Kegiatan</h5>
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
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<?php
						$conditions = array(
							"( ",
								array(
									"field" => "arsip.jenis_berkas",
									"operator" => "=",
									"value" => "Laporan Keuangan dan BMN"
								),
								" OR ",
								array(
									"field" => "arsip.jenis_berkas",
									"operator" => "=",
									"value" => "Laporan Kegiatan"
								),
								" OR ",
								array(
									"field" => "arsip.jenis_berkas",
									"operator" => "=",
									"value" => "Pengadaan Barang dan Jasa"
								),
							" ) AND (",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Baru"
								),
								" AND ",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Divalidasi SPI"
								),
								" AND ",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Ditolak SPI"
								),
								" AND ",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Disetujui SPI"
								),
								" AND ",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Divalidasi Kepala"
								),
								" AND ",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Ditolak Kepala"
								),
								" AND ",
								array(
									"field" => "arsip.status",
									"operator" => "!=",
									"value" => "Disetujui Kepala"
								),
							")"
						);

						$this->bootgrid->setTable("arsip", $conditions);
						$this->bootgrid->setTitle("JILID LAPORAN");
						//$this->bootgrid->setTableJoin("kegiatan");
						//$this->bootgrid->setTableJoinType("INNER JOIN");
						//$this->bootgrid->setTableJoinCondition("arsip.kegiatan_id = kegiatan.id");
						$this->bootgrid->sortBy("arsip.tgl_laporan_diterima_jilid");
						$this->bootgrid->sortType("DESC");

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "arsip.id",
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
							"id" => "kode",
							"field" => "arsip.kode",
							"name" => "Kode"
						);
						
						$columns[] = array(
							"id" => "jenis_berkas",
							"field" => "arsip.jenis_berkas",
							"name" => "Jenis Berkas",
							"format" => "jenis_arsip",
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "nama",
							"field" => "arsip.nama",
							"name" => "Nama Laporan",
							"class" => "wraptext"
						);

						$columns[] = array(
							"id" => "pembuat_laporan",
							"field" => "arsip.dibuat_oleh",
							"name" => "Pembuat Laporan",
							"format" => "nama_admin"
						);

						$columns[] = array(
							"id" => "status",
							"field" => "arsip.status",
							"name" => "Status",
							"format" => "label_laporan_jilid"
						);

						$columns[] = array(
							"id" => "tgl_status",
							"field" => "tgl_laporan_diterima_jilid",
							"name" => "Tgl Status",
							"format" => "date_laporan_jilid"
						);

						$columns[] = array(
							"id" => "petugas_spi",
							"field" => "petugas_laporan_diterima_jilid",
							"name" => "Petugas Jilid",
							"format" => "petugas_laporan_jilid"
						);

						$this->bootgrid->setColumns($columns);
						
						$addButton = array(
							"text" => "<i class='fas fa-plus mr-0'></i>",
							"modal" => array(
								"view" => "backend/arsip/modal_laporan_kegiatan_jilid"
							)
						);
						$this->bootgrid->setAddButton($addButton);	
					
				
						$editButton = array(
							"text" => '<i class="fas fa-edit mr-0"></i>',
							"modal" => array(
								"view" => "backend/arsip/modal_arsip_jilid"
							)
						);

						$this->bootgrid->setEditButton($editButton);
					
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
