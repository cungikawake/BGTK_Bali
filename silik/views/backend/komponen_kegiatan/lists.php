<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-layers"></i> Komponen Kegiatan</h5>
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
						 
						$this->bootgrid->setTable("master_komponen_kegiatan");
						$this->bootgrid->setTitle("KOMPONEN KEGIATAN");
						$this->bootgrid->sortBy("order");
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
							"id" => "name",
							"field" => "name",
							"name" => "Nama",
							"visible" => "true"
						);
						 
						$columns[] = array(
							"id" => "code",
							"field" => "code",
							"name" => "Kode", 
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "short_code",
							"field" => "short_code",
							"name" => "Short Kode", 
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "table_name",
							"field" => "table_name",
							"name" => "Tabel", 
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "status",
							"field" => "status",
							"name" => "Status", 
							"visible" => "true",
							"format" => "status_active", 
						);

						$columns[] = array(
							"id" => "order",
							"field" => "order",
							"name" => "Prioritas", 
							"visible" => "true", 
						);
						  

						$this->bootgrid->setColumns($columns); 
					
						if ($this->utility->hasUserAccess("komponen_kegiatan","add")) {
							$addButton = array(
								"text" => "Tambah",
								"modal" => array(
									"view" => "backend/komponen_kegiatan/modal_edit"
								)
							);
							$this->bootgrid->setAddButton($addButton);
						}
					
						if ($this->utility->hasUserAccess("komponen_kegiatan","edit")) {
							$editButton = array(
								"text" => "Edit",
								"modal" => array(
									"view" => "backend/komponen_kegiatan/modal_edit"
								)
							);
							$this->bootgrid->setEditButton($editButton);
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
