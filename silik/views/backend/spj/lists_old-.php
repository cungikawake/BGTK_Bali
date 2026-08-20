<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-donate"></i> SPJ Kegiatan</h5>
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
						$this->bootgrid->setTable("spj_kegiatan");
						$this->bootgrid->setTableJoin("kegiatan");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("spj_kegiatan.kegiatan_id = kegiatan.id");
					
						$this->bootgrid->setTitle("SPJ KEGIATAN");

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "spj_kegiatan.id",
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
							"id" => "nama_kegiatan",
							"field" => "kegiatan.nama",
							"name" => "Nama Kegiatan",
							"format" => "textLink",
							"textLink" => array(
								"url" => "/admin/spj/peserta/{{spj_kegiatan__id}}"
							)
						);
						
					
						$columns[] = array(
							"id" => "status",
							"field" => "spj_kegiatan.status",
							"name" => "Status",
							"format" => "spj_label"
						);
					
						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "spj_kegiatan.dibuat_tgl",
							"name" => "Dibuat Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);
					
						$columns[] = array(
							"id" => "diubah_tgl",
							"field" => "spj_kegiatan.diubah_tgl",
							"name" => "Diubah Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);
					
						
						if ($this->utility->hasUserAccess("spj_kegiatan","add")) {
							$addButton = array(
								"text" => "Tambah",
								"modal" => array(
									"view" => "backend/spj/modal_edit_spj_kegiatan"
								)
							);
							$this->bootgrid->setAddButton($addButton);	
						}
						
						if ($this->utility->hasUserAccess("spj_kegiatan","edit")) {
							$editButton = array(
								"text" => "Edit",
								"modal" => array(
									"view" => "modal_edit_spj_kegiatan"
								)
							);
							$this->bootgrid->setEditButton($editButton);
						}
					
						if ($this->utility->hasUserAccess("spj_kegiatan","delete")) {
							$deleteButton = array(
								"text" => "Delete"
							);
							$this->bootgrid->setDeleteButton($deleteButton);
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
