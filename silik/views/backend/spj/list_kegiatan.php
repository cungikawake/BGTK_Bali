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
	<style type="text/css">
		.bootgrid-table td.select-cell, .bootgrid-table th.select-cell {
			width: 38px;
		}
		.table-condensed>tbody>tr>td {
			overflow: visible;
			white-space: normal;
		}
		select.select-mak {
			padding: 7px 4px;
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h5 class="bootgrid-title">SPJ KEGIATAN</h5>
						</div>
						<div class="card-body">
							<table id="grid-data-kegiatan" class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th data-column-id="id" data-identifier="true" data-visible="false">ID</th>
										<th data-column-id="kegiatan_id" data-visible="false">Kegiatan ID</th>
										<th data-column-id="autonumeric" data-width="50px" data-sortable="false">No</th>
										<th data-column-id="nama">Nama Kegiatan</th>
										<th data-column-id="tgl_kegiatan">Tgl Kegiatan</th>
										<th data-column-id="tanggal" data-width="130px" data-sortable="false">Tgl Dibuat</th>
										<th data-column-id="paid" data-width="70px" data-sortable="false">Paid</th>
										<th data-column-id="dibuat_oleh" data-width="130px" data-visible="false" data-sortable="false">Dibuat Oleh</th>
										<th data-column-id="act_btn" data-width="90px">&nbsp;</th>
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
<script src="<?php print base_url('assets/js/spj_keuangan.js?v='.rand()); ?>"></script>
