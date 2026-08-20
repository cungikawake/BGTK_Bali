<?php $this->load->view("frontend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-user"></i> Profil</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<?php
				if($this->session->flashdata('msg')){
					print $this->session->flashdata('msg');
				}
			?>
			<div class="row">
				<div class="col-md-3">	
					<div class="card">
						<div class="card-body" style="text-align: center;">
							<div class="form-group">
								<?php
									if (empty($guest["avatar"])) {
										$avatar = base_url("/assets/images/user/avatar-2.jpg");

										if ($guest["jenis_kelamin"] == "Perempuan") {
											$avatar = base_url("/assets/images/user/avatar-5.jpg");
										}
									}
									else {
										$avatar =$guest["avatar"]; 
									}
								?>
								<img src="<?php print $avatar; ?>" />
							</div>
							<div class="form-group">
								<label><?php print $guest["nama"]; ?></label>
								<p><?php print $guest["email"]; ?></p>
							</div>
							<div class="form-group">
								<label>Telepon/HP:</label><p><?php print $guest["telepon"]; ?></p>
							</div>
							<div class="form-group">
								<label>Unit Kerja: </label><p><?php print $guest["unit_kerja"]; ?></p>
							</div>
							<div class="form-group">
								<label>Alamat Unit Kerja: </label><p><?php print $guest["alamat"]; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">	
					<div class="card">
						<div class="card-body">
							<form action="/user/detail" method="post" autocomplete="off">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Email</label>
											<input type="text" class="form-control" value="<?php print $guest["email"]; ?>" readonly />
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Nama</label>
											<input type="text" name="nama" required class="form-control" value="<?php print $guest["nama"]; ?>" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Jenis Kelamin</label>
											<select class="form-control" name="jenis_kelamin" required>
												<?php
													$selL = "";
													$selP = "";
													
													if ($guest["jenis_kelamin"] == "Laki-laki") {
														$selL = 'selected="selected"';
													}
												
													if ($guest["jenis_kelamin"] == "Perempuan") {
														$selP = 'selected="selected"';
													}
												?>
												<option value="Laki-laki" <?php print $selL; ?>>Laki-laki</option>
												<option value="Perempuan" <?php print $selP; ?>>Perempuan</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Telepon/HP</label>
											<input type="text" name="telepon" required class="form-control" value="<?php print $guest["telepon"]; ?>" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Unit Kerja</label>
											<textarea name="unit_kerja" required class="form-control"><?php print $guest["unit_kerja"]; ?></textarea>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Alamat Unit Kerja</label>
											<textarea name="alamat" required class="form-control"><?php print $guest["alamat"]; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" class="btn btn-info">Simpan</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("frontend/includes/footer"); ?>
