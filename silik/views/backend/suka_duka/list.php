<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fas fa-hand-holding-heart"></i> Suka Duka</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<style type="text/css">
		.sukadukaMonth {
			cursor: pointer;
		}
	</style>

	<?php $selectedYear = date("Y"); ?>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<div class="card">
						<div class="card-header"><h5 class="bootgrid-title">SUKA DUKA</h5></div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<div class="row">
										<label class="col-md-4 col-form-label" style="padding-top: 6px;">Tahun: </label>
										<div class="col-md-7">
											<select class="select2">
												<?php
													$yearNext = date("Y") + 1;
													foreach (range(2022,$yearNext) as $yr) {
														$selected = '';
														
														if ($selectedYear == $yr) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							
							<hr style="margin: 15px 0;" />
							
							<div class="row">
								<?php
									foreach (range(1,12) as $month) {
								?>
								<div class="col-md-3">
									<div class="card theme-grey ticket-customer">
										<div class="card-block sukadukaMonth" data-year="<?php print $selectedYear; ?>" data-month="<?php print $month; ?>">
											<div class="align-items-center justify-content-center">
												<div class="col-auto">
													<h3 class="text-white mb-0 f-w-300"><?php print $this->utility->namaBulan($month); ?></h3>
												</div>
											</div>
											<h5 class="text-white f-w-300 mt-4">Belum Bayar</h5>
											<i class="fas fa-dollar-sign text-white f-70"></i>
										</div>
									</div>
								</div>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<script src="<?php print base_url('assets/js/suka_duka.js'); ?>"></script>
<?php $this->load->view("backend/includes/footer"); ?>
