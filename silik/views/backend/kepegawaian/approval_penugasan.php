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
	<input type="hidden" class="penugasan-id" value="<?php print $penugasan["id"]; ?>" />
	<!-- [ breadcrumb ] end -->
	<style type="text/css">
		.bootgrid-header {
			margin: 0;
		}
		.table-condensed>tbody>tr>td {
			padding: 8px 5px;
		}
		#grid-rincian-petugas {
			border-bottom: 2px solid #ddd;
		}
		.bootgrid-table td {
			text-overflow: unset;
		}
		.approve-penugasan, .discard-penugasan {
			margin-bottom: 0;
		}
		.btn-surtug {
			margin: 0;
			float: right;
		}
		td p {
			word-wrap: break-word;
    		white-space: normal;
		}
	</style>

	<ul class="nav nav-pills mb-4">
		<li class="nav-item">
			<a class="nav-link <?php print ($penugasan["status"] == '1') ? 'active' : ''; ?>" href="<?php print base_url("admin/kepegawaian/approve_penugasan/"); ?>">Menunggu</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php print ($penugasan["status"] == '2' || $penugasan["status"] == '4' || $penugasan["status"] == '5' || $penugasan["status"] == '6') ? 'active' : ''; ?>" href="<?php print base_url("admin/kepegawaian/approve_penugasan/2"); ?>">Disetujui</a>
		</li>
	</ul>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<div class="card" style="margin-bottom: 20px;">
						<div class="card-header">
							<h5 class="m-b-20"><?php print $penugasan["nama"]; ?></h5>
						</div>
					</div>
					<div class="card" style="margin-bottom: 20px;">
						<div class="card-header">
							<h5 class="bootgrid-title">Rincian Petugas</h5>
							<a href="<?php print base_url("/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$penugasan["surat"]); ?>" class="btn btn-info btn-sm btn-surtug" target="_blank"><i class="fas fa-file-pdf"></i> Surat Tugas</a>
						</div>
						<div class="card-body">
							<div class="wrap-table-bootgrid">
								<table id="grid-rincian-petugas" class="table table-condensed table-hover table-striped">
									<thead>
										<tr>
											<th width="3%">No</th>
											<th width="25%">Nama Petugas</th>
											<th width="12%">Kab/Kota Asal</th>
											<th width="13%">Kab/Kota Tujuan</th>
											<th width="25%">Tempat Tujuan</th>
											<th width="7%">Lama Tugas</th>
											<th width="15%">Tanggal Tugas</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (isset($petugas) && !empty($petugas)) {
												foreach ($petugas as $pet) {
													if (!isset($pet["id"])) {
														$pet["id"] = "";
													}
										?>
													<tr>
														<td><?php print $pet["no"]; ?></td>
														<td><?php print $pet["nama"]; ?></td>
														<td><?php print $pet["kab_asal"]; ?></td>
														<td><?php print $pet["kab_tujuan"]; ?></td>
														<td><?php print $pet["tempat_tujuan"]; ?></td>
														<td><?php print $pet["lama_tugas"]; ?></td>
														<td><?php print $pet["tgl_tugas"]; ?></td>
														
														<?php
															if ($penugasan["status"] == "2" || $penugasan["status"] == "6") {
																
																print "<td>";
																print '<a href="javascript:;" class="btn btn-sm btn-secondary ubah-penugasan" data-id="'.$pet["id"].'">Edit</a> ';
																
																if ($pet["status"] <= "2") {
																	print '<a href="javascript:;" class="btn btn-sm btn-info ganti-penugasan" data-id="'.$pet["id"].'">Ganti Petugas</a> 
																		<a href="javascript:;" class="btn btn-sm btn-danger batal-penugasan" data-id="'.$pet["id"].'" data-nama="'.$pet["nama"].'">Batal</a>
																	';
																}
																else if ($pet["status"] == "3") {
																	print "Laporan Disetujui";
																}
																else if ($pet["status"] == "4") {
																	print "Laporan Ditolak";
																}
																else if ($pet["status"] == "5") {
																	print "Proses Pembayaran";
																}
																else if ($pet["status"] == "6") {
																	print "Telah Dibayarkan";
																}
																else if ($pet["status"] == "7") {
																	print "Tugas Dibatalkan";
																}
																else {
																	print "Belum Buat Laporan";
																}
																
																print "</td>";
															}
														?>
													</tr>
										<?php
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<?php
						if ($penugasan["status"] == "1") {
					?>
							<div class="card">
								<div class="card-body btn-approval">
									<button class="btn btn-info approve-penugasan">Setuju</button>
									<button class="btn btn-danger discard-penugasan">Tolak</button>
								</div>
							</div>
					<?php
						}
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
	
<?php $this->load->view("backend/includes/footer"); ?>
<script src="<?php print base_url('assets/js/kepegawaian.js?v='.rand()); ?>"></script>
