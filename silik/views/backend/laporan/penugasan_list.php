<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-map"></i> Monitoring Penugasan</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->
	<style type="text/css">
		.bootgrid-table th>.column-header-anchor>.text {
			margin:0;
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<div class="card" style="margin-bottom: 20px;">
						<div class="card-header">
							<h5 class="bootgrid-title">Monitoring Penugasan</h5>
							<div class="card-header-right">
								<div class="btn-group card-option">
									<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="feather icon-more-horizontal"></i>
									</button>
									<ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">
										<li class="dropdown-item"><a href="/admin/laporan/export_penugasan" class="link-card "><i class="fas fa-file-excel"></i> Export Excel</a></li></ul>
								</div>
							</div>
						</div>
						<div class="card-body">
							<table id="grid-penugasan-list" class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th data-column-id="id" data-width="50px" data-type="numeric">No</th>
										<th data-column-id="nama" data-width="280px" data-css-class="wraptext">Nama Petugas</th>
										<th data-column-id="total_tugas" data-type="tugas" data-width="80px" data-header-css-class="text-right" data-css-class="text-right">Tugas</th>
										<th data-column-id="total_hari" data-type="tugas_hari" data-width="80px" data-header-css-class="text-right" data-css-class="text-right">Hari</th>
										<th data-column-id="total_tiket_berangkat" data-visible="false" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Tiket Berangkat</th>
										<th data-column-id="total_tiket_pulang" data-visible="false" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Tiket Pulang</th>
										<th data-column-id="total_tiket" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Total Tiket</th>
										<th data-column-id="total_taksi_berangkat" data-visible="false" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Taksi Berangkat</th>
										<th data-column-id="total_taksi_pulang" data-visible="false" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Taksi Pulang</th>
										<th data-column-id="total_taksi" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Total Taksi</th>
										<th data-column-id="total_uang_penginapan" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Total Penginapan</th>
										<th data-column-id="total_transport" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Total Transport</th>
										<th data-column-id="total_transport_lainnya" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Total Trans. Lainnya</th>
										<th data-column-id="total_uang_harian" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Total Uang Harian</th>
										<th data-column-id="total_pembayaran" data-type="currency" data-header-css-class="text-right" data-css-class="text-right">Jumlah Total</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="<?php print base_url('assets/js/laporan.js?v='.rand()); ?>"></script>
