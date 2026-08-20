<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-layers"></i> Kegiatan</h5>
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
						$this->bootgrid->setTable("kegiatan");
						$this->bootgrid->setTitle("KEGIATAN");
					
						$this->bootgrid->sortBy("tgl_mulai_kegiatan");
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
							"id" => "kode",
							"field" => "kode",
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
							"field" => "program",
							"name" => "Program",
							"visible" => "true"
						);
					
						$linkKeg = "/admin/item/{{id}}/peserta";
					
						if (!empty($linkKeg)) {
							$columns[] = array(
								"id" => "nama",
								"field" => "nama",
								"name" => "Nama",
								"format" => "textLink",
								"textLink" => array(
									"url" => $linkKeg
								),
								"class" => "wraptext"
							);
						}
						else {
							$columns[] = array(
								"id" => "nama",
								"field" => "nama",
								"name" => "Nama",
								"class" => "wraptext"
							);
						}

						if ($this->utility->hasUserAccess("kegiatan","pelatihan")) {
							$columns[] = array(
								"id" => "jenis_pelatihan",
								"field" => "jenis_pelatihan",
								"name" => "Pelatihan",
								"visible" => "true"
							);
						}
						
						$columns[] = array(
							"id" => "tipe_kegiatan",
							"field" => "tipe_kegiatan",
							"name" => "Tipe",
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "tgl_mulai_kegiatan",
							"field" => "tgl_mulai_kegiatan",
							"name" => "Tgl Mulai",
							"format" => "day_date",
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "tgl_selesai_kegiatan",
							"field" => "tgl_selesai_kegiatan",
							"name" => "Tgl Selesai",
							"format" => "day_date",
							"visible" => "true"
						);
					
						if ($this->utility->hasUserAccess("kegiatan","duplikat")) {
							$columns[] = array(
								"id" => "duplikat",
								"field" => "id",
								"name" => "",
								"format" => "button",
								"button" => array(
									"text" => "<i class='fas fa-copy mr-0'></i>",
									"class" => "duplikat-kegiatan",
									"title" => "Duplikat"
								),
								"onclick" => "Kegiatan.duplikat(this);",
							);
						}
					
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
							"id" => "dibuat_oleh",
							"field" => "dibuat_oleh",
							"name" => "Dibuat Oleh",
							"format" => "nama_admin",
							"visible" => "false"
						);
					
						$columns[] = array(
							"id" => "diubah_oleh",
							"field" => "diubah_oleh",
							"name" => "Diubah Oleh",
							"format" => "nama_admin",
							"visible" => "false"
						);

						$this->bootgrid->setColumns($columns);
					
						if ($this->utility->hasUserAccess("kegiatan","add")) {
							$addButton = array(
								"text" => "Tambah",
								"modal" => array(
									"view" => "backend/kegiatan/modal_kegiatan_edit"
								)
							); 
							$this->bootgrid->setAddButton($addButton);
						}
						
						if ($this->utility->hasUserAccess("kegiatan","edit")) {
							$editButton = array(
								"text" => '<i class="fas fa-edit mr-0"></i>',
								"modal" => array(
									"view" => "backend/kegiatan/modal_kegiatan_edit"
								)
							);
							$this->bootgrid->setEditButton($editButton);
						}
					
						if ($this->utility->hasUserAccess("kegiatan","delete")) {
							$deleteButton = array(
								"text" => '<i class="fas fa-trash-alt mr-0"></i>'
							);
							$this->bootgrid->setDeleteButton($deleteButton);
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
