<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-qrcode"></i>&nbsp; QR Code Generator</h5>
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
						$this->bootgrid->setTable("qr_generator");
						$this->bootgrid->setTitle("QR CODE GENERATOR");
						$this->bootgrid->sortBy("qr_generator.id");
						$this->bootgrid->sortType("DESC");

						$columns = array();
						$columns[] = array(
							"id" => "autonumeric",
							"field" => "autonumeric",
							"name" => "No",
							"type" => "autonumeric",
							"width" => "25px",
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "url",
							"field" => "url",
							"name" => "URL",
						);
						$columns[] = array(
							"id" => "dibuat_oleh",
							"field" => "dibuat_oleh",
							"name" => "Dibuat Oleh",
							"format" => "nama_admin"
						);
						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "dibuat_tgl",
							"name" => "Tanggal",
							"format" => "date",
							"date" => array(
								"format" => "d M Y H:i a"
							)
						);

						$columns[] = array(
							"id" => "preview",
							"field" => "id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Lihat QR Code"></i>',
								"class" => "view-dokumen"
							),
							"modal" => array(
								"view" => "backend/tool/modal_view_qr"
							)
						);

						$columns[] = array(
							"id" => "download",
							"field" => "drive_file_id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fas fa-download mr-0" title="Download QR Code"></i>',
								"class" => "download-dokumen"
							),
							"link" => array(
								"url" => base_url("/admin/tool/download_qr/{{id}}")
							)
						);

						$addButton = array(
							"text" => "<i class='fas fa-plus mr-0'></i>",
							"modal" => array(
								"view" => "backend/tool/modal_qr_generator",
								"data" => array(
									"table" => "qr_generator"
								)
							)
						);
						$this->bootgrid->setAddButton($addButton);

						$this->bootgrid->setColumns($columns);

						$deleteButton = array(
							"text" => '<i class="fas fa-trash-alt mr-0" title="Hapus Dokumen"></i>'
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
