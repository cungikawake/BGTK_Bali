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
							<h5><i class="fas fa-wallet wid-20"></i><span class="p-l-5">Rekening</span></h5>
						</div>
					 	<div class="card-body">
							<form action="/admin/biodata/save" method="post" class="form-submit">
								<input type="hidden" name="id" class="form-control" value="<?php print isset($biodata["id"]) ? $biodata["id"] : ""; ?>" />
								
								<div class="form-group">
									<label>Nama Bank</label>
									<select name="nama_bank" required class="form-control select2">
										<option value="">&nbsp;</option>
										<?php
											foreach ($this->config->item("bank") as $bankOpsi) {
												$selected = "";

												if (isset($biodata["nama_bank"]) && $bankOpsi == $biodata["nama_bank"]) {
													$selected = 'selected="selected"';
												}

												print '<option value="'.$bankOpsi.'" '.$selected.'>'.$bankOpsi.'</option>';
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Nama Pemilik Rekening</label>
									<input type="text" name="nama_pemilik_rekening" required class="form-control" value="<?php print isset($biodata["nama_pemilik_rekening"]) ? $biodata["nama_pemilik_rekening"] : ""; ?>" />
								</div>
								<div class="form-group">
									<label>Nomor Rekening</label>
									<input type="text" name="no_rekening" required class="form-control" value="<?php print isset($biodata["no_rekening"]) ? $biodata["no_rekening"] : ""; ?>" />
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