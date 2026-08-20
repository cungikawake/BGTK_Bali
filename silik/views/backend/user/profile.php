<?php
	$this->load->view("backend/includes/header");
	$biodata = $_SESSION["biodata"];
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
							<h5><i class="feather icon-user wid-20"></i><span class="p-l-5">Biodata</span></h5>
						</div>
					 	<div class="card-body">
							<form action="/admin/biodata/save" method="post" class="form-submit">
								<input type="hidden" name="id" class="form-control" value="<?php print isset($biodata["id"]) ? $biodata["id"] : ""; ?>" />
								
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input type="text" name="nama" required class="form-control" value="<?php print isset($biodata["nama"]) ? $biodata["nama"] : ""; ?>" />
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>NIP</label>
											<input type="text" name="nip" class="form-control" value="<?php print isset($biodata["nip"]) ? $biodata["nip"] : ""; ?>" />
										</div>
										<div class="col-md-6">
											<label>Jabatan</label>
											<input type="text" name="jabatan" class="form-control" value="<?php print isset($biodata["jabatan"]) ? $biodata["jabatan"] : ""; ?>" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Golongan</label>
											<select name="golongan" class="form-control select2">
												<option value=""></option>

												<?php
													$options = $this->config->item("golongan_pangkat");
													$valSelected = isset($biodata["golongan"]) ? $biodata["golongan"] : "";

													foreach ($options as $gol => $pang) {
														$selected = '';

														if ($valSelected == $gol) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$gol.'" data-pangkat="'.$pang.'" '.$selected.'>'.$gol.'</option>';
													}
												?>
											</select>
										</div>
										<div class="col-md-6">
											<label>Pangkat</label>
											<input type="text" name="pangkat" class="form-control" readonly value="<?php print isset($biodata["pangkat"]) ? $biodata["pangkat"] : ""; ?>" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Tempat Lahir</label>
											<input type="text" name="tempat_lahir" required class="form-control" value="<?php print isset($biodata["tempat_lahir"]) ? $biodata["tempat_lahir"] : ""; ?>" />
										</div>
										<div class="col-md-6">
											<label>Tgl Lahir</label>
											<input type="text" name="tgl_lahir" required class="form-control datepicker" value="<?php print isset($biodata["tgl_lahir"]) ? date("d/m/Y", strtotime($biodata["tgl_lahir"])) : ""; ?>" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Jenis Kelamin</label>
											<select name="jenis_kelamin" class="form-control select2">
												<option value=""></option>

												<?php
													$options = array("Laki-laki"=>"Laki-laki", "Perempuan" => "Perempuan");
													$valSelected = isset($biodata["jenis_kelamin"]) ? $biodata["jenis_kelamin"] : "";

													foreach ($options as $jk => $jkVal) {
														$selected = '';

														if ($valSelected == $jk) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$jk.'" '.$selected.'>'.$jk.'</option>';
													}
												?>
											</select>
										</div>
										<div class="col-md-6">
											<label>NPWP</label>
											<input type="text" name="npwp" class="form-control" value="<?php print isset($biodata["npwp"]) ? $biodata["npwp"] : ""; ?>" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Telp/Hp</label>
											<input type="text" name="telp" required class="form-control" value="<?php print isset($biodata["telp"]) ? $biodata["telp"] : ""; ?>" />
										</div>
										<div class="col-md-6">
											<label>Email</label>
											<input type="text" name="email" class="form-control" value="<?php print isset($biodata["email"]) ? $biodata["email"] : ""; ?>" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Alamat Rumah</label>
									<textarea name="alamat_tinggal" class="form-control"><?php print isset($biodata["alamat_tinggal"]) ? $biodata["alamat_tinggal"] : ""; ?></textarea>
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
<script src="<?php print base_url('assets/plugins/cropper/cropper.js'); ?>"></script>
<script src="<?php print base_url('assets/js/user.js?v='.rand()); ?>"></script>