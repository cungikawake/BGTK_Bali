<?php
	$this->load->view("backend/includes/header");
	$user = $_SESSION["user"];
?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-file-text"></i> Dokumen Saya</h5>
						<div class="alert alert-info">
							<p>Silahkan menyimpan dokumen - dokumen yang bersifat privasi disini seperti SK PNS, SK Jabatan, Sertifikat, dll. User lain tidak bisa mengakses dokumen anda.</p>
						</div>
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
								"field" => "user_id",
								"operator" => "=",
								"value" => $_SESSION["user"]["id"]
							)
						);

						$this->bootgrid->setTable("user_document", $conditions);
						$this->bootgrid->setTitle('<i class="feather icon-file-text wid-20"></i><span class="p-l-5">Dokumen Saya</span>');

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
							"name" => "Nama Dokumen",
							"width" => "40%"
						);
						$columns[] = array(
							"id" => "filename",
							"field" => "filename",
							"name" => "File",
							"width" => "40%"
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
							"id" => "preview",
							"field" => "id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Lihat Dokumen"></i>',
								"class" => "view-dokumen"
							),
							"modal" => array(
								"view" => "backend/user/modal_view_dokumen"
							)
						);

						$columns[] = array(
							"id" => "download",
							"field" => "drive_file_id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fas fa-download mr-0" title="Download Dokumen"></i>',
								"class" => "download-dokumen"
							),
							"link" => array(
								"url" => base_url("/admin/user/download_dokumen/{{id}}")
							)
						);

						$this->bootgrid->setColumns($columns);

						$addButton = array(
							"text" => "<i class='fas fa-plus mr-0'></i>",
							"modal" => array(
								"view" => "backend/user/modal_dokumen"
							)
						);
						$this->bootgrid->setAddButton($addButton);


						$deleteButton = array(
							"text" => '<i class="fas fa-trash-alt mr-0" title="Hapus Dokumen"></i>'
						);
						$this->bootgrid->setDeleteButton($deleteButton);

						$this->bootgrid->setRowCount('10');

						print $this->bootgrid->render();
					?>
				</div>

			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>