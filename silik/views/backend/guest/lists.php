<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-user"></i> Master User</h5>
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
						$this->bootgrid->setTable("guest");
						$this->bootgrid->setTitle("MASTER USER");

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
							"id" => "unit_kerja",
							"field" => "unit_kerja",
							"name" => "Unit Kerja"
						);
					
						$columns[] = array(
							"id" => "email",
							"field" => "email",
							"name" => "Email"
						);
					
						$columns[] = array(
							"id" => "telepon",
							"field" => "telepon",
							"name" => "Telepon"
						);
					
						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "dibuat_tgl",
							"name" => "Dibuat Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "true"
						);

						$this->bootgrid->setColumns($columns);

						$this->bootgrid->setRowCount('-1');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
