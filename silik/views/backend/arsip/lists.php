<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-folder"></i> Arsip</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<?php
						$conditions = array(
							array(
								"field" => "status",
								"operator" => "=",
								"value" => "Divalidasi Arsiparis"
							),
							" OR ",
							array(
								"field" => "status",
								"operator" => "=",
								"value" => "Ditolak Arsiparis"
							),
							" OR ",
							array(
								"field" => "status",
								"operator" => "=",
								"value" => "Diarsipkan"
							)
							,
							" OR ",
							array(
								"field" => "status",
								"operator" => "=",
								"value" => "Dipinjam"
							)
						);

						$this->bootgrid->setTable("arsip", $conditions);
						$this->bootgrid->setTitle("ARSIP");
						$this->bootgrid->sortBy("tgl_laporan_diterima_arsip");
						$this->bootgrid->sortType("DESC");

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
							"id" => "kode",
							"field" => "kode",
							"name" => "Kode"
						);
						
						$columns[] = array(
							"id" => "jenis_berkas",
							"field" => "jenis_berkas",
							"name" => "Jenis Berkas",
							"class" => "wraptext",
							"format" => "jenis_arsip",
							"width" => "220px",
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama",
							"class" => "wraptext",
							"width" => "780px"
						);

						$columns[] = array(
							"id" => "no_kabinet",
							"field" => "no_kabinet",
							"name" => "Kabinet",
							"width" => "100px"
						);

						$columns[] = array(
							"id" => "no_laci",
							"field" => "no_laci",
							"name" => "Laci",
							"width" => "100px"
						);

						$columns[] = array(
							"id" => "no_folder",
							"field" => "no_folder",
							"name" => "Folder",
							"width" => "100px"
						);

						$columns[] = array(
							"id" => "status",
							"field" => "status",
							"name" => "Status",
							"width" => "100px",
							"format" => "status_arsip"
						);

						$columns[] = array(
							"id" => "diubah_tgl",
							"field" => "diubah_tgl",
							"name" => "Diubah Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d M Y"
							),
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "keterangan",
							"field" => "keterangan",
							"name" => "Keterangan",
							"width" => "200px",
							"visible" => "false"
						);

						$this->bootgrid->setColumns($columns);

						$addButton = array(
							"text" => "<i class='fas fa-plus mr-0'></i>",
							"modal" => array(
								"view" => "backend/arsip/modal_add_arsip"
							)
						);
						$this->bootgrid->setAddButton($addButton);	
					
						$editButton = array(
							"text" => '<i class="fas fa-edit mr-0"></i>',
							"modal" => array(
								"view" => "backend/arsip/modal_kearsipan"
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
