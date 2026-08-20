<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-donate"></i> SPJ Penugasan</h5>
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
							<h5 class="bootgrid-title">SPJ PENUGASAN</h5>
						</div>
						<div class="card-body">
							<table id="grid-data" class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th data-column-id="id" data-identifier="true" data-visible="false">ID</th>
										<th data-column-id="penugasan_id" data-visible="false">Penugasan ID</th>
										<th data-column-id="autonumeric" data-width="50px" data-sortable="false">No</th>
										<th data-column-id="tipe_spj" data-width="90px" data-visible="false">Tipe</th>
										<th data-column-id="nama">Nama</th>
										<!--<th data-column-id="petugas" data-width="80px">Petugas</th>-->
										<th data-column-id="belum_bayar" data-width="80px">Belum</th>
										<th data-column-id="siap_bayar" data-width="80px">Siap</th>
										<th data-column-id="dibayarkan" data-width="80px">Dibayar</th>
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
