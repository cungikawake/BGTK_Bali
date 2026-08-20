<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-pocket"></i> Approval Penugasan</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<ul class="nav nav-pills mb-4">
		<li class="nav-item">
			<a class="nav-link <?php print ($status == '1') ? 'active' : ''; ?>" href="<?php print base_url("admin/kepegawaian/approve_penugasan/"); ?>">Menunggu</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php print ($status == '2') ? 'active' : ''; ?>" href="<?php print base_url("admin/kepegawaian/approve_penugasan/2"); ?>">Disetujui</a>
		</li>
	</ul>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<?php
						$conditions = array(
							array(
								"field" => "penugasan.status",
								"operator" => "=",
								"value" => $status
							)
						);
					
						if ($status == '2') {
							$conditions = array();
							
							$conditions[] = " ( ";
							$conditions[] = array(
								"field" => "penugasan.status",
								"operator" => "=",
								"value" => '2'
							);
							$conditions[] = " OR ";
							$conditions[] = array(
								"field" => "penugasan.status",
								"operator" => "=",
								"value" => '4'
							);
							$conditions[] = " OR ";
							$conditions[] = array(
								"field" => "penugasan.status",
								"operator" => "=",
								"value" => '5'
							);
							$conditions[] = " OR ";
							$conditions[] = array(
								"field" => "penugasan.status",
								"operator" => "=",
								"value" => '6'
							);
							$conditions[] = " ) ";
						}
					
						$conditions[] = " AND ";
						$conditions[] = array(
							"field" => "YEAR(penugasan.dibuat_tgl)",
							"operator" => "=",
							"value" => $_SESSION["tahun_anggaran"]
						);
						

						$this->bootgrid->setTable("penugasan", $conditions);
						$this->bootgrid->setTableJoin("kegiatan");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("penugasan.kegiatan_id = kegiatan.id");
						$this->bootgrid->sortBy("penugasan.dibuat_tgl");
						$this->bootgrid->sortType("DESC");
					
						if ($status == '1') {
							$this->bootgrid->setTitle("MENUNGGU PERSETUJUAN");
						}
						else if ($status == '2') {
							$this->bootgrid->setTitle("TELAH DISETUJUI");
						}

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "penugasan.id",
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
							"field" => "penugasan.nama",
							"name" => "Nama Penugasan",
							"format" => "textLink",
							"textLink" => array(
								"url" => "/admin/kepegawaian/approval_penugasan/{{penugasan__id}}/"
							),
							"class" => "wraptext"
						);

						$columns[] = array(
							"id" => "status",
							"field" => "penugasan.status",
							"name" => "",
							"format" => "penugasan_status"
						);

						$columns[] = array(
							"id" => "preview",
							"field" => "penugasan.id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat',
								"class" => "preview-penugasan-kegiatan"
							),
							"link" => array(
								"url" => "/admin/kepegawaian/approval_penugasan/{{penugasan__id}}/"
							)
						);

						$columns[] = array(
							"id" => "dibuat_tgl",
							"field" => "penugasan.dibuat_tgl",
							"name" => "Dibuat Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "diubah_tgl",
							"field" => "penugasan.diubah_tgl",
							"name" => "Diubah Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d/m/Y H:i a"
							),
							"visible" => "false"
						);

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
<script src="<?php print base_url('assets/js/kepegawaian.js?v='.rand()); ?>"></script>
