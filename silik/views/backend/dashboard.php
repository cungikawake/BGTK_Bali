<?php $this->load->view("backend/includes/header"); ?>   
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-home"></i> Dashboard</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->
	<style type="text/css">
		.f-16 { font-size: 16px; }
		.text-black-50 {
			--bs-text-opacity: 1;
			color: rgba(0,0,0,.5)!important;
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">
					<h6 class="mt-0 mb-4" style="font-size: 17px;">Selamat Datang, <b><?php print $_SESSION["user"]["nama"]; ?></b></h6>
				</div>
				<!--<div class="col-md-12">
					<div class="alert alert-info">
						<p>WARNING</p>
					</div>
				</div>-->				
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="card user-card">
						<div class="card-block">
							<h5 class="mb-4"><i class="feather icon-layers"></i> Kegiatan</h5>
							<h3 class="mb-4"><?php print $this->utility->format_number($kegiatan); ?></h3>
							<span class="text-muted">Jumlah kegiatan tahun ini</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card user-card">
						<div class="card-block">
							<h5 class="mb-4"><i class="feather icon-users"></i> Biodata</h5>
							<h3 class="mb-4"><?php print $this->utility->format_number($biodata); ?></h3>
							<span class="text-muted">Jumlah biodata terhimpun</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card bg-c-blue bitcoin-wallet" style="min-height: 162px;">
						<div class="card-block">
							<h5 class="text-white mb-2"><?php print $kutipan["kutipan"]; ?></h5>
							<span class="text-white d-block text-italic">~ <?php print $kutipan["oleh"]; ?></span>
							<i class="fas fa-quote-right f-70 text-white"></i>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
		
		<div class="row">
			<?php
				if (!empty($birthday)) {
			?>
				<div class="col-md-4">
					<div class="card bitcoin-wallet">
						<div class="card-block">
							<div class="align-items-center justify-content-center">
								<div class="col">
									<h5 class="mb-4">Happy Birthday </h5>
								</div>
							</div>
							<?php
								foreach ($birthday as $pegawai) {
									$yearBirth = date("Y", strtotime($pegawai["tgl_lahir"]));
									$ulathKe = date("Y") - $yearBirth;
							?>
									<h6 class="mt-3 mb-0" style="font-size: 15px;"><?php print $pegawai["nama"]; ?></h6>
									<span class="badge theme-bg text-white"><?php print $ulathKe; ?> Tahun</span>
							<?php
								}
							?>

							<h6 class="text-muted mt-4 mb-0">Semoga panjang umur dan sehat selalu.</h6>
							<i class="fas fa-birthday-cake text-c-purple f-80"></i>
						</div>
					</div>
				</div>
			<?php
				}	
			?>
			<!--
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h5><i class="feather icon-award"></i> HAI BGP Ranking</h5>
					</div>
					<div class="card-block">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Pegawai</th>
										<th>Jumlah Tiket</th>
										<th>Ratings</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if (isset($hai_ranking) && !empty($hai_ranking)) {
											$i = 1;
											foreach ($hai_ranking as $rank) {
									?>
											<tr>
												<td><?php print $i; ?></td>
												<td><?php print $rank["nama"]; ?></td>
												<td><?php print $rank["total_respon"]; ?></td>
												<td>
													<?php
														$star = round($rank["total_rating"] / $rank["total_respon"]);
												
														foreach (range(1,5) as $s) {
															if ($s <= $star) {
																print '<i class="fa fa-star f-16 text-c-yellow"></i>';
															}
															else {
																print '<i class="fa fa-star f-16 text-black-50"></i>';
															}
														}
													?>
												</td>
											</tr>
									<?php
												$i++;
											}
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			-->
			
			<div class="col-md-8">
				<div class="card">
					<img src="<?php print base_url("/assets/images/slide_dashboard/bmn.jpg?v=3"); ?>" width="100%" alt="Slide BMN" Title="Jagalah Barang Milik Negara Seperti Barang Milik Sendiri" />
				</div>
			</div>
			
			<?php
				if (empty($birthday)) {
			?>
					<div class="col-md-4">
						<div class="card">
							<img src="<?php print base_url("/assets/images/slide_dashboard/bebas_korupsi.jpg"); ?>" width="100%" alt="Slide Bebas Korupsi" Title="Tolak Gratifikasi & Lingkungan Bebas Korupsi" />
						</div>
					</div>
			<?php
				}
			?>
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
