<?php $this->load->view("backend/includes/header"); ?>
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
					<div class="card">
						<div class="card-header">
							<h5><i class="fab fa-google-drive wid-20"></i><span class="p-l-5">Sync Google Drive</span></h5>
						</div>
					 	<div class="card-body">
							<?php
								if (isset($_SESSION["user"]["sync_drive"]) && !empty($_SESSION["user"]["sync_drive"])) {
							?>
									<div class="alert alert-success mb-0" role="alert">
										<h5 class="alert-heading"><i class="feather icon-check-circle me-2"></i>
									Terhubung Google Drive</h5>
										<p class="mb-2">Akun anda sudah terhubung ke Google Drive. <br /><a href="javascript:;" style="font-weight: bold;" class="text-success"><?php print $_SESSION["user"]["sync_drive"]; ?></a></p>
										
										<a class="btn btn-sm btn-info generate-oAuth-link">Reconnect Google Drive</a>
									</div>
							<?php
								}
								else {
							?>
									<div class="alert alert-danger mb-0" role="alert">
										<h5 class="alert-heading"><i class="feather icon-alert-octagon me-2"></i>
									Hubungkan Google Drive</h5>
										<p class="mb-2">Gunakan akun belajar.id supaya kapasitas drive unlimited.</p>
										<a class="btn btn-sm btn-info generate-oAuth-link">Generate Request Link</a>
									</div>
									
							<?php
								}
							?>
						</div>
					</div>
				</div>

			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$('.generate-oAuth-link').click(function () {
			$.ajax({
				type: "POST",
				url: "/admin/user/oAuthUrl/",
				data: {
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					if (!obj.error) {
						$('.generate-oAuth-link').replaceWith('<a class="btn btn-sm btn-success" href="'+obj.url+'">Start Sync Goolge Drive</a>');
					}
					else {
						alert("Something goes wrong!! call Bayu");
					}
				}
			});	
		});
	});
</script>