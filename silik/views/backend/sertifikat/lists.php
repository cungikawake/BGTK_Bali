<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-feather"></i> Template Sertifikat</h5>
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
						$this->bootgrid->setTable("sertifikat");
						$this->bootgrid->setTitle("TEMPLATE SERTIFIKAT");
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
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama"
						);
						$columns[] = array(
							"id" => "koordinat",
							"field" => "koordinat",
							"name" => "Koordinat",
							"visible" => "false"
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
					
						$columns[] = array(
							"id" => "design",
							"field" => "sertifikat.id",
							"name" => "Aksi",
							"format" => "button",
							"button" => array(
								"text" => "<i class='fas fa-image'></i>Design"
							),
							"link" => array(
								"url" => "/admin/sertifikat/edit/{{sertifikat__id}}"
							)
						);

						$this->bootgrid->setColumns($columns);
					
						$addButton = array(
							"text" => "Tambah",
							"modal" => array(
								"view" => "backend/sertifikat/modal_tambah"
							)
						);
						$this->bootgrid->setAddButton($addButton);
					
						$deleteButton = array(
							"text" => "Delete"
						);
						$this->bootgrid->setDeleteButton($deleteButton);
					
						$this->bootgrid->setRowCount('15');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
