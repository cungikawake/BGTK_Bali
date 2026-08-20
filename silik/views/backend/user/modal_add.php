<style>
	.user-access {
		border: 1px solid #ddd;
		margin-bottom: 5px;
		border-radius: 4px;
	}
	.user-access-trigger a {
		padding: 7px 10px;
		display: block;
	}
	.user-access-trigger a:focus {
		text-decoration: none;
	}
	.user-access .checkbox {
		margin: 0;
		padding: 0;
	}
	.user-access-form {
    	border-top: 1px solid #ddd;
	}
	.user-access-form .row {
		padding: 15px 15px 10px;
	}
	.user-access-form .form-group {
		margin-bottom: 5px;
	}
</style>
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Tambah Admin</h5>
		</div>
		<form action="<?php print base_url('admin/user/save/'); ?>" method="post" class="form-submit" autocomplete="false">
			<div class="modal-body">
				<div class="form-group">
					<label>Username</label>
					<input type="text" name="username" required class="form-control" value="" />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" required class="form-control" value="" />
				</div>
				<hr />
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" required class="form-control" value="" />
				</div>
				<hr />
				
				<div class="form-group">
					<label>User Akses</label>
					<div id="accordion-user">
					<?php
						$access = $this->config->item("user_akses");

						if (!empty($access)) {
							foreach ($access as $aksesSection => $aksesItems) {
								$aksesSectionId = str_replace(array(" "), array("-"), $aksesSection);
								$aksesSectionName = ucwords(str_replace(array("_"),array(" "),$aksesSection));
								$splitItem = ceil(count($aksesItems)/2);

								if ($aksesSectionName == "Spj") {
									$aksesSectionName = "SPJ Penugasan";
								}

								if ($aksesSectionName == "Data Dukung Kegiatan") {
									$aksesSectionName = "Kegiatan Data Dukung";
								}
					?>
								<div class="user-access">
									<div class="user-access-trigger">
										<a href="javascript:;" data-toggle="collapse" data-target="#collapseSatker-<?php print $aksesSectionId; ?>" aria-expanded="true" aria-controls="collapseSatker-<?php print $aksesSectionId; ?>">
											<?php print $aksesSectionName; ?>
										</a>
									</div>
									<div id="collapseSatker-<?php print $aksesSectionId; ?>" class="user-access-form collapse" aria-labelledby="headSatker1" data-parent="#accordion-user">
										<div class="row">
											<div class="col-md-6">
												<?php
													if (!empty($aksesItems)) {
														$i = 1;
														
														foreach ($aksesItems as $aksesItemKey => $aksesItem) {
															$aksesItemId = $aksesSectionId.str_replace(array(" "), array("-"), $aksesItemKey);
															
															$checked = "";
															
															if ($aksesItem["value"]) {
																$checked = 'checked="checked"';
															}
												?>
															<div class="form-group">
																<div class="checkbox checkbox-info d-inline">
																	<input type="hidden" name="akses[<?php print $aksesSection; ?>][<?php print $aksesItemKey; ?>]" value="0" />
																	<input type="checkbox" name="akses[<?php print $aksesSection; ?>][<?php print $aksesItemKey; ?>]" id="checkbox-<?php print $aksesItemId; ?>" value="1" <?php print $checked; ?> />
																	<label for="checkbox-<?php print $aksesItemId; ?>" class="cr"><?php print $aksesItem["name"]; ?></label>
																</div>
															</div>
												<?php
															if ($i == $splitItem) {
																print '</div><div class="col-md-6">';
															}
															
															$i++;
														}
													}
												?>
											</div>
										</div>
									</div>
								</div>
					<?php
							}

						}
					?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>