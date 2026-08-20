<?php
	$showTiket = false;
	$showTransport = true;
	$showHonor = true;
	$showPulsa = false;
	$showUangHarian = true;
	$showLainnya = true;
	$disabled = "";

	if (isset($provinsi_asal) && isset($provinsi_tujuan) && $provinsi_asal != $provinsi_tujuan) {
		$showTiket = true;
		//$showTransport = false;
		$showHonor = false;
	}
	
	if (isset($spj["komponen"]) && ($spj["komponen"] == "peserta" || $spj["komponen"] == "petugas")) {
		$showHonor = false;
	}

	if (isset($kegiatan["tipe_kegiatan"]) && $kegiatan["tipe_kegiatan"] == "Daring") {
		$showTiket = false;
		$showTransport = false;
		$showUangHarian = false;
		$showPulsa = true;
	}

	$lock = false;

	if ((isset($paid) && $paid == "1") || isset($kunci) && $kunci == "1") {
		$disabled = 'disabled="disabled"';
		$lock = true;
	}
?>

<style type="text/css">
	.input-group .form-control:last-child {
		margin-left: -1px;
	}
	.input-group-text:last-child {
		margin-left: -1px;
		padding: 0;
	}
	.form-rincian-tgl .input-group .input-group-text i {
		font-size: 14px;
	}
	.remove-rinci-tgl-tugas {
		padding: 8px 15px;
	}
</style>
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">SPJ <?php print $spj["komponen"]; ?></h5>
		</div>
		
        <form action="/admin/spj/save_manual_item" method="post" class="form-submit">
        	<input name="id" type="hidden" value="<?php print $id; ?>" />
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="<?php print $nama; ?>" readonly />
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label>Gol</label>
                            <input type="text" class="form-control" value="<?php print $golongan; ?>" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NPWP</label>
                            <input type="text" class="form-control" value="<?php print $npwp; ?>" readonly />
                        </div>
                    </div>
					
					
					<?php if ($showTransport || $showTiket) { ?>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transport Asal</label>
								<input type="text" class="form-control" value="<?php print $kab_asal; ?>" readonly />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Transport Tujuan</label>
								<input type="text" class="form-control" value="<?php print $kab_tujuan; ?>" readonly />
							</div>
						</div>
                    <?php } ?>
					
					<?php
						$hideDefaultTglTugas = "";
						$btnTextTglTugas = "Rinci tanggal tugas";
						
						if (isset($tgl_tugas) && !empty($tgl_tugas)) {
							$hideDefaultTglTugas = 'style="display: none;"';
							$btnTextTglTugas = "Tambah tanggal tugas";
						}
					?>
					
					<div class="default-tgl-tgs" <?php print $hideDefaultTglTugas; ?>>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tanggal Mulai Tugas</label>
								<input type="text" name="tgl_mulai_tugas" class="form-control datepicker" <?php print $disabled; ?> value="<?php print date("d/m/Y", strtotime($tgl_mulai_tugas)); ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tanggal Selesai Tugas</label>
								<input type="text" name="tgl_selesai_tugas" <?php print $disabled; ?> class="form-control datepicker" value="<?php print date("d/m/Y", strtotime($tgl_selesai_tugas)); ?>" />
							</div>
						</div>
					</div>
					
					<div id="rinci-tgl-tgs">
						<?php
							if (isset($tgl_tugas) && !empty($tgl_tugas)) {
								print '<div class="col-md-12 label-rincian-tgl-tgs"><label>Rincian Tanggal Tugas</label></div>';
								
								$booNo = 1;
								foreach ($tgl_tugas as $boo) {
						?>
									<div class="col-md-12 form-rincian-tgl">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-text no-rincian-tgl"><?php print $booNo; ?></span>
														<input type="text" class="form-control datepicker" name="tgl_tugas[]" required autocomplete="off" value="<?php print date("d/m/Y", strtotime($boo["tgl_tugas"])); ?>" <?php print $disabled; ?> />
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="input-group">
														<input type="text" class="form-control" name="tempat_tugas[]" required autocomplete="off" placeholder="SMKN 1 Tabanan" value="<?php print $boo["tempat_tugas"] ?>" <?php print $disabled; ?> />
														
														<?php if (!$lock) { ?>
														<span class="input-group-text">
															<a href="javascript:;" class="remove-rinci-tgl-tugas" title="Hapus"><i class="fas fa-trash-alt"></i></a>
														</span>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
						<?php
									$booNo++;
								}
							}
						?>
					</div>
					
					<?php if (!$lock) { ?>
						<div class="col-md-12">
							<a href="javascript:;" class="btn-rinci-tgl-tgs"><?php print $btnTextTglTugas; ?></a>
						</div>
					<?php } ?>
					
					<div class="col-md-12">&nbsp;</div>
					
                    <div class="col-md-12">
						<ul class="nav nav-tabs" role="tablist">
							<?php
							$activeTabItem = true;
							/*
							<li class="nav-item">
								<a class="nav-link active" href="javascript:;" aria-controls="modal-edit-kuitansi">Kuitansi</a>
							</li>
							*/ ?>
							<li class="nav-item">
								<a class="nav-link active" href="javascript:;" aria-controls="modal-edit-dasar">Dasar Pembayaran</a>
							</li>
							
							<?php
								if ($showPulsa) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "active";
										$activeTabItem = true;
									}
							?>
									<li class="nav-item">
										<a class="nav-link <?php print $activeTabClass; ?>" href="javascript:;" aria-controls="modal-edit-pulsa">Pulsa / Paket Data</a>
									</li>
							<?php
								}
							?>
							
							<?php
								if ($showTiket) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "active";
										$activeTabItem = true;
									}
							?>
									<li class="nav-item">
										<a class="nav-link <?php print $activeTabClass; ?>" href="javascript:;" aria-controls="modal-edit-tiket">Tiket & Taksi</a>
									</li>
							<?php
								}
							?>
							
							<?php
								if ($showTransport) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "active";
										$activeTabItem = true;
									}
							?>
									<li class="nav-item">
										<a class="nav-link <?php print $activeTabClass; ?>" href="javascript:;" aria-controls="modal-edit-transport">Transport</a>
									</li>
							<?php
								}
							?>
							
							<?php
								if ($showUangHarian) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "active";
										$activeTabItem = true;
									}
							?>
									<li class="nav-item">
										<a class="nav-link <?php print $activeTabClass; ?>" href="javascript:;" aria-controls="modal-edit-uang-harian">UH & Penginapan</a>
									</li>
							<?php
								}
							?>
							
							<?php
								if ($showHonor) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "active";
										$activeTabItem = true;
									}
							?>
									<li class="nav-item">
										<a class="nav-link <?php print $activeTabClass; ?>" href="javascript:;" aria-controls="modal-edit-honor">Honor</a>
									</li>
							<?php
								}
							?>
							
							<?php
								if ($showLainnya) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "active";
										$activeTabItem = true;
									}
							?>
									<li class="nav-item">
										<a class="nav-link <?php print $activeTabClass; ?>" href="javascript:;" aria-controls="modal-edit-lainnya">Lainnya</a>
									</li>
							<?php
								}
							?>
						</ul>
						
						<div class="tab-content">
							
							<?php
							$activeTabItem = true;
							
							/*
							<div class="tab-pane active show" id="modal-edit-kuitansi">
								
								<?php if ($showTransport || $showTiket) { ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Deskripsi Kuitansi Transport</label>
												<textarea class="form-control" name="deskripsi_kuitansi" rows="4" <?php print $disabled; ?>><?php print $deskripsi_kuitansi; ?></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Kab/Kota Kuitansi</label>
												<select class="form-control select2" <?php print $disabled; ?> name="kab_kuitansi">
													<?php
														$areas = $this->config->item("transport_area");

														if (!empty($areas)) {
															foreach ($areas as $area) {
																$selected = "";
																if ($area == $kab_kuitansi) {
																	$selected = 'selected="selected"';
																}
													?>
															<option value="<?php print $area; ?>" <?php print $selected; ?>><?php print $area; ?></option>
													<?php
															}									
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Tgl Kuitansi</label>
												<input type="text" <?php print $disabled; ?> class="form-control datepicker" name="tgl_kuitansi" value="<?php print date("d/m/Y", strtotime($tgl_kuitansi)); ?>" />
											</div>
										</div>
									</div>
								<?php } ?>
								
								<?php if ($showTransport && $showHonor) { ?>
									<hr class="mt-3 mb-4" />
								<?php } ?>
								
								<?php if ($showHonor) { ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Deskripsi Kuitansi Honor</label>
												<textarea class="form-control" <?php print $disabled; ?> name="deskripsi_honor" rows="4"><?php print $deskripsi_honor; ?></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Kab/Kota Kuitansi</label>
												<select class="form-control select2" <?php print $disabled; ?> name="kab_honor">
													<?php
														$areas = $this->config->item("transport_area");

														if (!empty($areas)) {
															foreach ($areas as $area) {
																$selected = "";
																if ($area == $kab_honor) {
																	$selected = 'selected="selected"';
																}
													?>
															<option value="<?php print $area; ?>" <?php print $selected; ?>><?php print $area; ?></option>
													<?php
															}									
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Tgl Kuitansi</label>
												<input type="text" <?php print $disabled; ?> class="form-control datepicker" name="tgl_honor" value="<?php print date("d/m/Y", strtotime($tgl_honor)); ?>" />
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
							*/ ?>
							
							<?php
								if ($showTiket) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "show active";
										$activeTabItem = true;
									}
							?>
									<div class="tab-pane <?php print $activeTabClass; ?>" id="modal-edit-tiket">
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-10">
														<div class="form-group form-group-sm">
															<label>Tiket Pesawat Berangkat</label>
															<input type="text" <?php print $disabled; ?> name="pesawat_berangkat" class="form-control autoNumeric" value="<?php print $pesawat_berangkat; ?>">
														</div>
														<div class="form-group form-group-sm">
															<label>Tiket Pesawat Pulang</label>
															<input type="text" <?php print $disabled; ?> name="pesawat_pulang" class="form-control autoNumeric" value="<?php print $pesawat_pulang; ?>">
														</div>
													</div>
												</div>
												
												<hr class="mt-3 mb-4" />
												
												<div class="row">
													<div class="col-md-7">
														<div class="form-group">
															<label>Transport Lainnya</label>
															<input type="text" <?php print $disabled; ?> class="form-control autoNumeric" name="transport_lainnya" value="<?php print $transport_lainnya; ?>" />
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group form-group-sm">
															<label>&nbsp;</label>
															<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																<input type="hidden" <?php print $disabled; ?> name="dpr_transport_lainnya" value="0" />

																<?php
																	$dpr_transport_lainnya_selected = "";
																	if (isset($dpr_transport_lainnya) && $dpr_transport_lainnya == "1") {
																		$dpr_transport_lainnya_selected = 'checked="checked"';
																	}
																?>

																<input type="checkbox" <?php print $disabled; ?> name="dpr_transport_lainnya" id="checkbox-item-dpr_transport_lainnya" <?php print $dpr_transport_lainnya_selected; ?> value="1" />
																<label for="checkbox-item-dpr_transport_lainnya" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
															</div>
														</div>
													</div>
													<div class="col-md-10">
														<div class="form-group">
															<label>Keterangan Transport Lainnya</label>
															<textarea class="form-control" <?php print $disabled; ?> name="keterangan_transport_lainnya" rows="2"><?php print $keterangan_transport_lainnya; ?></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-7">
														<div class="form-group form-group-sm">
															<label>Taksi Asal (PP)</label>
															<input type="text" <?php print $disabled; ?> name="taksi_berangkat" class="form-control autoNumeric" value="<?php print $taksi_berangkat; ?>">
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group form-group-sm">
															<label>&nbsp;</label>
															<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																<input type="hidden" <?php print $disabled; ?> name="dpr_taksi_berangkat" value="0" />

																<?php
																	$dpr_taksi_berangkat_selected = "";
																	if (isset($dpr_taksi_berangkat) && $dpr_taksi_berangkat == "1") {
																		$dpr_taksi_berangkat_selected = 'checked="checked"';
																	}
																?>

																<input type="checkbox" <?php print $disabled; ?> name="dpr_taksi_berangkat" id="checkbox-item-dpr_taksi_berangkat" <?php print $dpr_taksi_berangkat_selected; ?> value="1" />
																<label for="checkbox-item-dpr_taksi_berangkat" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-7">
														<div class="form-group form-group-sm">
															<label>Taksi Tujuan (PP)</label>
															<input type="text" <?php print $disabled; ?> name="taksi_pulang" class="form-control autoNumeric" value="<?php print $taksi_pulang; ?>">
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group form-group-sm">
															<label>&nbsp;</label>
															<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																<input type="hidden" <?php print $disabled; ?> name="dpr_taksi_pulang" value="0" />

																<?php
																	$dpr_taksi_pulang_selected = "";
																	if (isset($dpr_taksi_pulang) && $dpr_taksi_pulang == "1") {
																		$dpr_taksi_pulang_selected = 'checked="checked"';
																	}
																?>

																<input type="checkbox" <?php print $disabled; ?> name="dpr_taksi_pulang" id="checkbox-item-dpr_taksi_pulang" <?php print $dpr_taksi_pulang_selected; ?> value="1" />
																<label for="checkbox-item-dpr_taksi_pulang" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>										
									</div>
							<?php
								}
							?>
							
							<?php
								if ($showTransport) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "show active";
										$activeTabItem = true;
									}
							?>
									<div class="tab-pane <?php print $activeTabClass; ?>" id="modal-edit-transport">
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-7">
														<div class="form-group">
															<label>Transport PP</label>
															<input type="text" <?php print $disabled; ?> class="form-control autoNumeric" name="transport" value="<?php print $transport; ?>" />
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group form-group-sm">
															<label>&nbsp;</label>
															<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																<input type="hidden" <?php print $disabled; ?> name="dpr_transport" value="0" />

																<?php
																	$dpr_transport_selected = "";
																	if (isset($dpr_transport) && $dpr_transport == "1") {
																		$dpr_transport_selected = 'checked="checked"';
																	}
																?>

																<input type="checkbox" <?php print $disabled; ?> name="dpr_transport" id="checkbox-item-dpr_transport" <?php print $dpr_transport_selected; ?> value="1" />
																<label for="checkbox-item-dpr_transport" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label>Keterangan Transport</label>
															<textarea <?php print $disabled; ?> class="form-control" name="keterangan_transport" rows="2"><?php print $keterangan_transport; ?></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-7">
														<div class="form-group">
															<label>Transport Lainnya</label>
															<input type="text" <?php print $disabled; ?> class="form-control autoNumeric" name="transport_lainnya" value="<?php print $transport_lainnya; ?>" />
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group form-group-sm">
															<label>&nbsp;</label>
															<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																<input type="hidden" <?php print $disabled; ?> name="dpr_transport_lainnya" value="0" />

																<?php
																	$dpr_transport_lainnya_selected = "";
																	if (isset($dpr_transport_lainnya) && $dpr_transport_lainnya == "1") {
																		$dpr_transport_lainnya_selected = 'checked="checked"';
																	}
																?>

																<input type="checkbox" <?php print $disabled; ?> name="dpr_transport_lainnya" id="checkbox-item-dpr_transport_lainnya" <?php print $dpr_transport_lainnya_selected; ?> value="1" />
																<label for="checkbox-item-dpr_transport_lainnya" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label>Keterangan Transport Lainnya</label>
															<textarea <?php print $disabled; ?> class="form-control" name="keterangan_transport_lainnya" rows="2"><?php print $keterangan_transport_lainnya; ?></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							?>
							
							<?php
								if ($showUangHarian) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "show active";
										$activeTabItem = true;
									}
							?>
								<div class="tab-pane <?php print $activeTabClass; ?>" id="modal-edit-uang-harian">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-7">
													<div class="form-group">
														<label>Uang Harian / Hari</label>
														<input type="text" <?php print $disabled; ?> class="form-control autoNumeric" name="uang_harian" value="<?php print $uang_harian; ?>" />
													</div>
												</div>
												<div class="col-md-10">
													<div class="form-group">
														<label>Keterangan Uang Harian</label>
														<textarea <?php print $disabled; ?> class="form-control" name="keterangan_uang_harian" rows="2"><?php print $keterangan_uang_harian; ?></textarea>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-7">
													<div class="form-group">
														<label>Penginapan / Malam</label>
														<input type="text" <?php print $disabled; ?> class="form-control autoNumeric" name="penginapan" value="<?php print $penginapan; ?>" />
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group form-group-sm">
														<label>&nbsp;</label>
														<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
															<input type="hidden" <?php print $disabled; ?> name="dpr_penginapan" value="0" />

															<?php
																$dpr_penginapan_selected = "";
																if (isset($dpr_penginapan) && $dpr_penginapan == "1") {
																	$dpr_penginapan_selected = 'checked="checked"';
																}
															?>

															<input type="checkbox" <?php print $disabled; ?> name="dpr_penginapan" id="checkbox-item-dpr_penginapan" <?php print $dpr_penginapan_selected; ?> value="1" />
															<label for="checkbox-item-dpr_penginapan" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
														</div>
													</div>
												</div>
												<div class="col-md-10">
													<div class="form-group">
														<label>Keterangan Penginapan</label>
														<textarea <?php print $disabled; ?> class="form-control" name="keterangan_penginapan" rows="2"><?php print $keterangan_penginapan; ?></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
								}
							?>
							
							<?php
								if ($showPulsa) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "show active";
										$activeTabItem = true;
									}
							?>
									<div class="tab-pane <?php print $activeTabClass; ?>" id="modal-edit-pulsa">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Pulsa / Paket Data</label>
													<input type="text" <?php print $disabled; ?> class="form-control autoNumeric" name="pulsa" value="<?php print $pulsa; ?>" />
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Keterangan Pulsa / Paket Data</label>
													<textarea <?php print $disabled; ?> class="form-control" name="keterangan_pulsa" rows="2"><?php print $keterangan_pulsa; ?></textarea>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							?>
							
							<?php
								if ($showHonor) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "show active";
										$activeTabItem = true;
									}
							?>
									<div class="tab-pane <?php print $activeTabClass; ?>" id="modal-edit-honor">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group form-group-sm">
													<label>Honor / Vol</label>
													<input type="text" <?php print $disabled; ?> name="honor" class="form-control autoNumeric" value="<?php print $honor; ?>" />
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group form-group-sm">
													<label>Vol</label>
													<input type="text" <?php print $disabled; ?> name="vol_honor" class="form-control" value="<?php print $vol_honor; ?>" />
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group form-group-sm">
													<label>Satuan</label>
													<input type="text" <?php print $disabled; ?> name="satuan_honor" class="form-control" value="<?php print $satuan_honor; ?>" />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group form-group-sm">
													<label>Keterangan Honor</label>
													<textarea class="form-control" <?php print $disabled; ?> rows="4" name="keterangan_honor"><?php print $keterangan_honor; ?></textarea>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group form-group-sm">
													<label>Pajak</label>
													<div class="input-group">
														<input type="text" <?php print $disabled; ?> class="form-control" value="<?php print $pajak; ?>" name="pajak" >
														<div class="input-group-append">
															<span class="input-group-text" style="padding: 0 15px;">%</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							?>
							
							<div class="tab-pane show active" id="modal-edit-dasar">
								<div class="row">
									<div class="col-md-5">
										<div class="form-group form-group-sm">
											<label>Jenis Surat</label>
											<select <?php print $disabled; ?> class="form-control select2" name="jenis_surat">
												<?php
													$jenisSurats = array("Surat Tugas", "Surat Undangan", "Surat Keputusan");

													foreach ($jenisSurats as $jenisSurat) {
														$selected = "";

														if (isset($jenis_surat) && !empty($jenis_surat) && $jenis_surat == $jenisSurat) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$jenisSurat.'" '.$selected.'>'.$jenisSurat.'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group form-group-sm">
											<label>Nomor Surat</label>
											<input type="text" name="nomor_surat" <?php print $disabled; ?> class="form-control" value="<?php print (isset($nomor_surat)) ? $nomor_surat: ""; ?>" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group form-group-sm">
											<label>Tanggal Surat</label>
											<input type="text" name="tgl_surat" <?php print $disabled; ?> class="form-control datepicker" value="<?php print (isset($tgl_surat)) ? date("d/m/Y",strtotime($tgl_surat)) : ""; ?>" />
										</div>
									</div>
								</div>
							</div>
							
							
							<?php
								if ($showLainnya) {
									$activeTabClass = "";
									
									if (!$activeTabItem) {
										$activeTabClass = "show active";
										$activeTabItem = true;
									}
							?>
									<div class="tab-pane <?php print $activeTabClass; ?>" id="modal-edit-lainnya">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label>Lokasi Pembayaran</label>
													<select <?php print $disabled; ?> name="kab_kuitansi" class="form-control select2">
														<option value="">&nbsp;</option>
														<?php
															$kab_spj = isset($kab_kuitansi) && !empty($kab_kuitansi) ? $kab_kuitansi : $_ENV["DEFAULT_KABUPATEN"];
															$provinsi = $_ENV["DEFAULT_PROVINSI"];
															$areas = $this->config->item("provinsi");

															if ( isset($areas[$provinsi]) && !empty($areas[$provinsi]) ) {
																foreach ($areas[$provinsi] as $area) {
																	$selected = "";

																	if ($area == $kab_spj) {
																		$selected = 'selected="selected"';
																	}

																	print '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
																}
															}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<?php
														$tgl_spj = isset($tgl_kuitansi) && !empty($tgl_kuitansi) ? $tgl_kuitansi : date("Y-m-d");
													?>
													<label>Tanggal Pemabayaran</label>
													<input type="text" <?php print $disabled; ?> name="tgl_kuitansi" class="form-control datepicker" value="<?php print (isset($tgl_spj)) ? date("d/m/Y", strtotime($tgl_spj)) : ""; ?>" />
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							?>
							
						</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
				<?php
					if ((isset($paid) && $paid == "0") && isset($kunci) && $kunci == "0") {
				?>
					<button type="submit" class="btn btn-info">Simpan</button>
				<?php
					}
				?>
                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
		</form>
    </div>
</div>
<div id="form-rinci-tgl-tgs" style="display: none;">
	<div class="col-md-12 form-rincian-tgl">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-text no-rincian-tgl">1</span>
						<input type="text" class="form-control datepicker" name="tgl_tugas[]" required autocomplete="off" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" name="tempat_tugas[]" required autocomplete="off" placeholder="SMKN 1 Tabanan" />
						<span class="input-group-text">
							<a href="javascript:;" class="remove-rinci-tgl-tugas" title="Hapus"><i class="fas fa-trash-alt"></i></a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<script type="text/javascript">
	$('.accor-btn').click(function () {
		var accorItem = $(this).closest('.accor-item');
		var accor = $(this).closest('.accor');
		
		accor.find('.accor-content').slideUp();
		
		
		if (accorItem.find('.accor-content').css('display') == "block") {
			accorItem.find('.accor-content').slideUp();
		}
		else {
			accorItem.find('.accor-content').slideDown();
		}
	});
</script>