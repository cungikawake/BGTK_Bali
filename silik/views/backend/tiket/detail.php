<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-10"><i class="feather icon-message-circle"></i> Hai BGP</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
<style>
	.h-list-body .chat-messages .chat-menu-content > div .chat-cont {
		background: #1dc4e9;
	}
	.table-chat-file>tbody>tr>td {
		background: none;
	}
	.chat-menu-content a {
		color: #fff;
	}
</style>
	<!-- [ breadcrumb ] end -->
	<?php $this->load->view("backend/tiket/menu"); ?>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card msg-card">
						<div class="card-body msg-block">
							<div class="row" style="margin-left: -25px; margin-right: -25px;">
								<div class="col-lg-3 col-md-12" style="padding-left: 25px; padding-right: 25px;">
									<div class="message-mobile">
										<div class="taskboard-right-progress">
											<div class="h-list-body">
												<div class="msg-user-list">
													<div class="main-friend-list">
														<div class="media userlist-box " data-id="1" data-status="online" data-username="Josephin Doe">
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
															
															<a class="media-left" href="#!"><img class="media-object img-radius" src="<?php print $avatar; ?>" />
															</a>
															<div class="media-body">
															<h6 class="chat-header"><?php print $guest["nama"]; ?></h6>
															</div>
														</div>
														<div class="guest-detail">
															<div class="guest-detail-list">
																<div class="guest-detail-label">Unit Kerja</div>
																<div class="guest-detail-value"><?php print $guest["unit_kerja"]; ?></div>
															</div>
															<div class="guest-detail-list">
																<div class="guest-detail-label">Telepon</div>
																<div class="guest-detail-value"><?php print $guest["telepon"]; ?></div>
															</div>
															<div class="guest-detail-list">
																<div class="guest-detail-label">Email</div>
																<div class="guest-detail-value"><?php print $guest["email"]; ?></div>
															</div>
															<div class="guest-detail-list">
																<div class="guest-detail-label">ID Tiket</div>
																<div class="guest-detail-value"><?php print $tiket["no"]; ?></div>
															</div>
															<div class="guest-detail-list">
																<div class="guest-detail-label">Judul Tiket</div>
																<div class="guest-detail-value"><?php print $tiket["judul"]; ?></div>
															</div>
														</div>
														<div class="guest-action-btn">
															<div class="guest-detail-label">Tiket Status</div>
															<div>
																<?php
																	$disable = "";
																	
																	if ($tiket["status"] == "2") {
																		$disable = 'disabled="disabled"';
																	}
																?>
																<select class="form-control ticket-status-change" <?php print $disable; ?> tiket-id="<?php print $tiket["id"]; ?>">
																	<?php
																		$selectedProses = "";
																		$selectedSelesai = "";
																	
																		if ($tiket["status"] == "1") {
																			$selectedProses = 'selected="selected"';
																		}
																		else if ($tiket["status"] == "2") {
																			$selectedSelesai = 'selected="selected"';
																		}
																		else {
																		print '<option value="0" selected="selected">Baru</option>';
																		}
																	?>
																	<option value="1" <?php print $selectedProses; ?>>Proses</option>
																	<option value="2" <?php print $selectedSelesai; ?>>Selesai</option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-9 col-md-12" style="padding-left: 25px; padding-right: 25px;">
									<div class="ch-block">
										<div class="h-list-body">
											<div class="msg-user-chat">
												<input type="hidden" name="tiket_id" value="<?php print $tiket["id"]; ?>" />
												<div class="main-friend-chat">
													
												</div>
											</div>
										</div>
										
										<?php
											if ($tiket["status"] != "2") {
										?>
											<hr>
											<div class="msg-form">
												<div class="mb-3">
													<textarea class="form-control msg-send-chat" placeholder="Text . . ." rows="2"></textarea>
												</div>
												<div class="mb-3 tiket-upload" style="display: none;">
													<div id="dropzone-tiket" class="dropzone">
														<div class="dz-message needsclick">    
														Drop files here or click to upload.
													  	</div>
													</div>
												</div>
												<div class="mb-0">
													<button class="btn btn-info btn-submit-tiket" type="button"><i class="fas fa-paper-plane"></i> Kirim</button> <a href="javascript:;" class="show-tiket-upload"><i class="fas fa-paperclip"></i> Attach file</a>
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
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
