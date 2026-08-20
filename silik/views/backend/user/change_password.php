<?php
	$this->load->view("backend/includes/header");
	$user = $_SESSION["user"];
?>
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
							<h5><i class="feather icon-shield wid-20"></i><span class="p-l-5">Ganti Password</span></h5>
						</div>
					 	<div class="card-body">
							<form action="/admin/user/save_password" method="post" class="form-submit">
								<input type="hidden" name="id" class="form-control" value="<?php print isset($user["id"]) ? $user["id"] : ""; ?>" />
								
								<div class="form-group">
									<label>Password Baru</label>
									<input type="password" name="password" required class="form-control" />
								</div>
								<div class="form-group">
									<label>Konfirmasi Password Baru</label>
									<input type="password" name="confirm_password" required class="form-control" />
								</div>
								<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
							</form>
						</div>
					</div>
				</div>

			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>