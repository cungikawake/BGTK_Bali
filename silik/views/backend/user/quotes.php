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
						<h5 class="m-b-20"><i class="fas fa-user-check"></i> User Profil</h5>
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
				<?php $this->load->view("backend/user/user_menu"); ?>
				<div class="col-lg-8">
					<?php
							$conditions = array(
								array(
									"field" => "dibuat_oleh",
									"operator" => "=",
									"value" => $_SESSION["user"]["id"]
								)
							);
					
							$this->bootgrid->setTable("kutipan", $conditions);
							$this->bootgrid->setTitle('<i class="fas fa-quote-right m-r-10"></i><span class="p-l-5">Kutipan</span>');

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
								"id" => "kutipan",
								"field" => "kutipan",
								"name" => "Kutipan",
								"width" => "80%"
							);
					
							$columns[] = array(
								"id" => "oleh",
								"field" => "oleh",
								"name" => "Oleh"
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
							

							$this->bootgrid->setColumns($columns);

							$addButton = array(
								"text" => "Tambah",
								"modal" => array(
									"view" => "backend/user/modal_quote"
								)
							);
							$this->bootgrid->setAddButton($addButton);
					
							$editButton = array(
								"text" => '<i class="fas fa-pencil-alt mr-0" title="Ubah Kutipan"></i>',
								"modal" => array(
									"view" => "backend/user/modal_quote"
								)
							);
							$this->bootgrid->setEditButton($editButton);

							$deleteButton = array(
								"text" => '<i class="fas fa-trash-alt mr-0" title="Hapus Kutipan"></i>'
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