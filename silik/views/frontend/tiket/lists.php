<?php $this->load->view("frontend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-message-circle"></i> Hai BGTK</h5>
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
								"field" => "guest_id",
								"operator" => "=",
								"value" => $guest["id"]
							)
						);
					
						$this->bootgrid->setTable("tiket", $conditions);
						$this->bootgrid->setTitle("TIKET");
					
						$this->bootgrid->sortBy("feedback_tgl");
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
							"id" => "no",
							"field" => "no",
							"name" => "Tiket ID"
						);
						$columns[] = array(
							"id" => "judul",
							"field" => "judul",
							"name" => "Judul"
						);
					
						$columns[] = array(
							"id" => "feedback",
							"field" => "feedback",
							"name" => "Status",
							"format" => "tiket_feedback"
						);
					
						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "tiket.dibuat_tgl",
							"name" => "Dibuat Tanggal",
							"format" => "date",
							"date" => array(
								"format" => "d M Y H:i a"
							),
							"visible" => "false"
						);
					
						$columns[] = array(
							"id" => "feedback_tgl",
							"field" => "tiket.feedback_tgl",
							"name" => "Feedback Tanggal",
							"format" => "date",
							"date" => array(
								"format" => "d M Y H:i a"
							)
						);
					
						$columns[] = array(
							"id" => "tanggapi",
							"field" => "tiket.id",
							"name" => "Aksi",
							"format" => "button",
							"button" => array(
								"text" => "<i class='fas fa-comments'></i>Tanggapi"
							),
							"link" => array(
								"url" => "/tiket/detail/{{tiket__id}}"
							)
						);

						$this->bootgrid->setColumns($columns);
					
						$addButton = array(
							"text" => "Buat Tiket Baru",
							"modal" => array(
								"view" => "frontend/tiket/modal_new"
							)
						);
						$this->bootgrid->setAddButton($addButton);

						$this->bootgrid->setRowCount('-1');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("frontend/includes/footer"); ?>
