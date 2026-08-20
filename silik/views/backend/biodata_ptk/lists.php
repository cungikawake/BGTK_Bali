<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-users"></i> Master Biodata</h5>
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
						$this->bootgrid->setTable("biodata_ptk");
						$this->bootgrid->setTitle("MASTER BIODATA PTK");
						$this->bootgrid->sortBy("dibuat_tgl");
						$this->bootgrid->sortType("ASC");

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
							"id" => "nik",
							"field" => "nik",
							"name" => "NIK"
						);
						
						$columns[] = array(
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama"
						);

						$columns[] = array(
							"id" => "nip",
							"field" => "nip",
							"name" => "NIP"
						);

						$columns[] = array(
							"id" => "jeniskelamin",
							"field" => "jeniskelamin",
							"name" => "Jenis Kelamin"
						);

						$columns[] = array(
							"id" => "tgllahir",
							"field" => "tgllahir",
							"name" => "Tgl Lahir"
						);

						$columns[] = array(
							"id" => "nuptk",
							"field" => "nuptk",
							"name" => "NUPTK"
						);

						$columns[] = array(
							"id" => "jenis_ptk",
							"field" => "jenis_ptk",
							"name" => "Jenis PTK"
						);

						$columns[] = array(
							"id" => "nama_satuan",
							"field" => "nama_satuan",
							"name" => "Nama Satuan"
						);

						$columns[] = array(
							"id" => "npsn",
							"field" => "npsn",
							"name" => "NPSN"
						);

						$columns[] = array(
							"id" => "jenjang",
							"field" => "jenjang",
							"name" => "Jenjang"
						);

						$columns[] = array(
							"id" => "kabkota",
							"field" => "kabkota",
							"name" => "Kab / Kota"
						);

						$columns[] = array(
							"id" => "status_sekolah",
							"field" => "status_sekolah",
							"name" => "Status Sekolah"
						);
						

						$this->bootgrid->setColumns($columns);
					
						//$this->bootgrid->setCustomFilter("kabupaten_kota");
					
						if ($this->utility->hasUserAccess("biodata","add")) {
							$addButton = array(
								"text" => "<i class='fas fa-plus mr-0'></i>",
								"modal" => array(
									"view" => "backend/biodata/modal_edit"
								)
							);
							$this->bootgrid->setAddButton($addButton);
						}
					
						if ($this->utility->hasUserAccess("biodata","edit")) {
							$editButton = array(
								"text" => '<i class="fas fa-edit mr-0"></i>',
								"modal" => array(
									"view" => "backend/biodata/modal_edit"
								)
							);
							$this->bootgrid->setEditButton($editButton);
						}
					
						if ($this->utility->hasUserAccess("biodata","delete")) {
							$deleteButton = array(
								"text" => '<i class="fas fa-trash-alt mr-0"></i>',
							);
							$this->bootgrid->setDeleteButton($deleteButton);
						}
						
						if ($this->utility->hasUserAccess("biodata","import_data_bank")) {
							$toolbarButton = array(
								"class" => "biodata_import_data_bank",
								"title" => "Import Data Bank",
								"icon" => "fas fa-cloud-upload-alt"
							);

							$this->bootgrid->setToolbarButton($toolbarButton);
						}
					
						$this->bootgrid->setRowCount('15');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
