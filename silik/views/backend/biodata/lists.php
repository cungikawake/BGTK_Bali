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
						$this->bootgrid->setTable("biodata");
						$this->bootgrid->setTitle("MASTER BIODATA");
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
							"id" => "ktp",
							"field" => "ktp",
							"name" => "ID KTP"
						);
						$columns[] = array(
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama"
						);
						$columns[] = array(
							"id" => "tempat_tgl_lahir",
							"field" => "tgl_lahir",
							"name" => "Tempat/Tgl Lahir",
							"format" => "tempat_tgl_lahir",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "alamat_tinggal",
							"field" => "alamat_tinggal",
							"name" => "Alamat",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "telp",
							"field" => "telp",
							"name" => "Telp",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "nip",
							"field" => "nip",
							"name" => "NIP",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "pangkat_golongan",
							"field" => "golongan",
							"name" => "Pangkat/Golongan",
							"format" => "pangkat_golongan",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "jabatan",
							"field" => "jabatan",
							"name" => "Jabatan",
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "unit_kerja",
							"field" => "unit_kerja",
							"name" => "Unit Kerja"
						);
						$columns[] = array(
							"id" => "kab_unit_kerja",
							"field" => "kab_unit_kerja",
							"name" => "Kab/Kota"
						);
						$columns[] = array(
							"id" => "alamat_unit_kerja",
							"field" => "alamat_unit_kerja",
							"name" => "Alamat Unit Kerja",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "telp_unit_kerja",
							"field" => "telp_unit_kerja",
							"name" => "Telp Unit Kerja",
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "npwp",
							"field" => "npwp",
							"name" => "NPWP",
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "email",
							"field" => "email",
							"name" => "Email",
							"visible" => "false"
						);
						
						$columns[] = array(
							"id" => "buku_tabungan",
							"field" => "ktp",
							"name" => "Buku Tabungan",
							"visible" => "true",
							"format" => "buku_tabungan"
						);

						$columns[] = array(
							"id" => "valid_rekening",
							"field" => "valid_rekening",
							"name" => "Valid Rek",
							"visible" => "true",
							"format" => "valid_rekening",
							"align" => "center"
						);
					
						$columns[] = array(
							"id" => "preview",
							"field" => "id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i>'
							),
							"modal" => array(
								"view" => "backend/biodata/modal_lihat"
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

						$this->bootgrid->setColumns($columns);
					
						$this->bootgrid->setCustomFilter("kabupaten_kota");
					
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
