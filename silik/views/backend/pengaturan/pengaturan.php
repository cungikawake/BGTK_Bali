<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-settings"></i> Pengaturan <?php print ucfirst($section); ?></h5>
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
				<div class="col-md-12">										
					<div class="card">
						<div class="card-header">
							<h5>Pengaturan <?php print ucfirst($section); ?></h5>
						</div>
						<div class="card-body">
							<?php
								$col1 = ceil(count($form)/2);
								$col2 = count($form)
							?>
							
							<div class="row">
								<form class="form-submit" action="<?php print base_url("/admin/pengaturan/save"); ?>">
									<input type="hidden" name="section" value="<?php print $section; ?>" />
									<div class="col-md-6">
										<?php
											$counting = 1;
										
											foreach ($form as $key => $field) {
												
												if ($counting <= $col1){
													print '<div class="form-group">';
														print '<label for="filed--'.$field["sistem"].'">'.$field["name"].'</label>';
													
														
														if ($field["type"] == "text") {
															print '<input type="text" class="form-control" id="filed--'.$field["sistem"].'" name="'.$field["section"].'['.$field["sistem"].']" value="'.$field["value"].'" />';
														}
														else if ($field["type"] == "textarea") {
															print '<textarea class="form-control" id="filed--'.$field["sistem"].'" name="'.$field["section"].'['.$field["sistem"].']">'.$field["value"].'</textarea>';
														}
														else if ($field["type"] == "pegawai") {
															print '<select class="form-control select2" id="filed--'.$field["sistem"].'" name="'.$field["section"].'['.$field["sistem"].']">';
																print '<option value="">&nbsp;</option>';
															
																if (!empty($pegawai)) {
																	foreach ($pegawai as $peg) {
																		$selected = '';
																		
																		if ($field["value"] == $peg["id"]) {
																			$selected = 'selected="selected"';
																		}
																		
																		print '<option value="'.$peg["id"].'" '.$selected.'>'.$peg["nama"].'</option>';
																	}
																}
															
															print '</select>';
														}
														
													print '</div>';
													
													unset($form[$key]);
												}
												else {
													break;
												}
												
												$counting++;
											}
										?>
									</div>
									<div class="col-md-6">
										<?php
											foreach ($form as $field) {
												
												print '<div class="form-group">';
													print '<label for="filed--'.$field["sistem"].'">'.$field["name"].'</label>';

													if ($field["type"] == "text") {
														print '<input type="text" class="form-control" id="filed--'.$field["sistem"].'" name="'.$field["section"].'['.$field["sistem"].']" value="'.$field["value"].'" />';
													}
													else if ($field["type"] == "textarea") {
														print '<textarea class="form-control" id="filed--'.$field["sistem"].'" name="'.$field["section"].'['.$field["sistem"].']">'.$field["value"].'</textarea>';
													}
													else if ($field["type"] == "pegawai") {
														print '<select class="form-control select2" id="filed--'.$field["sistem"].'" name="'.$field["section"].'['.$field["sistem"].']">';
															print '<option value="">&nbsp;</option>';

															if (!empty($pegawai)) {
																foreach ($pegawai as $peg) {
																	$selected = '';

																	if ($field["value"] == $peg["id"]) {
																		$selected = 'selected="selected"';
																	}

																	print '<option value="'.$peg["id"].'" '.$selected.'>'.$peg["nama"].'</option>';
																}
															}

														print '</select>';
													}

												print '</div>';
											}
										?>
									</div>
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</form>
							</div>
						</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
