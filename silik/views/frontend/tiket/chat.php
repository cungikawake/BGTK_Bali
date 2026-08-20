<div class="media chat-messages">
	<div class="media-body chat-menu-reply">
	<div class="chat-limit">
		<div class="chat-cont"><?php print nl2br($tiket["deskripsi"]); ?></div>
		
		<?php if (!empty($tiket["drive_file"])) { ?>
			<div class="chat-cont">
				<table class="table table-chat-file">
					<tbody>
						<?php
							foreach ($tiket["drive_file"] as $tiketFile) {
								$nama = strtolower($tiketFile["nama"]);
								$size = $this->utility->formatSizeUnits($tiketFile["size"]);
								$type = $tiketFile["type"];
								$driveFileId = $tiketFile["drive_file"];

								$icon = "fa-file-pdf";

								if ($type == "doc" || $type == "docx") {
									$icon = "fa-file-word";
								}
								else if ($type == "jpg" || $type == "jpeg" || $type == "png") {
									$icon = "fa-file-image";
								}
						?>
								<tr>
									<td width="30px">
										<i class="chat-file-icon fas <?php print $icon; ?>"></i>
									</td>
									<td>
										<h6 class="m-0"><a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><?php print $nama; ?></a></h6>
										<div class="chat-file-attr">
											<div class="chat-file-size"><?php print $size; ?></div>
										</div>
									</td>
								</tr>
						<?php
							}						
						?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
	<p class="chat-time"><?php print $this->utility->formatDatetimeIndo($tiket["dibuat_tgl"]); ?></p>
	</div>
</div>

<?php
	if (isset($tiket_chat) && !empty($tiket_chat)) {
		foreach ($tiket_chat as $dates) {
			foreach ($dates as $userId => $users) {
				
				
				if (empty($userId)) {
?>
					<div class="media chat-messages">
						<div class="media-body chat-menu-reply">
						<div class="chat-limit">
							<?php
								foreach ($users as $chat) {					   
									if (!empty($chat["deskripsi"])) {
							?>
									<div class="chat-cont"><?php print nl2br($chat["deskripsi"]); ?></div>
							<?php 
									} 
									
									if (!empty($chat["drive_file"])) {
							?>
										<div class="chat-cont">
											<table class="table table-chat-file">
												<tbody>
													<?php
														foreach ($chat["drive_file"] as $chatFile) {
															$nama = strtolower($chatFile["nama"]);
															$size = $this->utility->formatSizeUnits($chatFile["size"]);
															$type = $chatFile["type"];
															$driveFileId = $chatFile["drive_file"];

															$icon = "fa-file-pdf";

															if ($type == "doc" || $type == "docx") {
																$icon = "fa-file-word";
															}
															else if ($type == "jpg" || $type == "jpeg" || $type == "png") {
																$icon = "fa-file-image";
															}
													?>
															<tr>
																<td width="30px">
																	<a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><i class="chat-file-icon fas <?php print $icon; ?>"></i></a>
																</td>
																<td>
																	<h6 class="m-0"><a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><?php print $nama; ?></a></h6>
																	<div class="chat-file-attr">
																		<div class="chat-file-size"><a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><?php print $size; ?></a></div>
																	</div>
																</td>
															</tr>
													<?php
														}						
													?>
												</tbody>
											</table>
										</div>
							<?php 
									}
								}
							?>
						</div>
						<p class="chat-time"><?php print $this->utility->formatDatetimeIndo($chat["dibuat_tgl"]); ?></p>
						</div>
					</div>
<?php
					}
					else {
?>
					<div class="media chat-messages">
						<a class="media-left photo-table" href="#!"><img class="media-object img-radius img-radius m-t-5" src="<?php print base_url("/assets/images/user/avatar-female.png"); ?>" style="border:1px solid #1dc4e9;" /></a>
						<div class="media-body chat-menu-content">
						<div class="chat-limit">
							<?php
								foreach ($users as $chat) {					   
									if (!empty($chat["deskripsi"])) {
							?>
									<div class="chat-cont"><?php print nl2br($chat["deskripsi"]); ?></div>
							<?php 
									} 
									
									if (!empty($chat["drive_file"])) {
							?>
										<div class="chat-cont">
											<table class="table table-chat-file">
												<tbody>
													<?php
														foreach ($chat["drive_file"] as $chatFile) {
															$nama = strtolower($chatFile["nama"]);
															$size = $this->utility->formatSizeUnits($chatFile["size"]);
															$type = $chatFile["type"];
															$driveFileId = $chatFile["drive_file"];

															$icon = "fa-file-pdf";

															if ($type == "doc" || $type == "docx") {
																$icon = "fa-file-word";
															}
															else if ($type == "jpg" || $type == "jpeg" || $type == "png") {
																$icon = "fa-file-image";
															}
													?>
															<tr>
																<td width="30px">
																	<a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><i class="chat-file-icon fas <?php print $icon; ?>"></i></a>
																</td>
																<td>
																	<h6 class="m-0"><a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><?php print $nama; ?></a></h6>
																	<div class="chat-file-attr">
																		<div class="chat-file-size"><a href="https://drive.google.com/open?id=<?php print $driveFileId; ?>" target="_blank" class="" title="<?php print $nama; ?>"><?php print $size; ?></a></div>
																	</div>
																</td>
															</tr>
													<?php
														}						
													?>
												</tbody>
											</table>
										</div>
							<?php 
									}
								}
							?>
						</div>
						<p class="chat-time"><?php print $this->utility->formatDatetimeIndo($chat["dibuat_tgl"]); ?></p>
						</div>
					</div>
<?php	
				}
				
			}
		}
	}

?>