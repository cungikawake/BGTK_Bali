<style type="text/css">
	.modal-body {
		background: #f1f1f1;
	}
	#dropzone-surat-tugas {
		min-height: 100px;
	}
	#dropzone-surat-tugas.dropzone .dz-message {
		margin: 30px 0;
	}
	.surat-tugas-penugasan {
		margin-top: 5px;
		padding: 5px 0;
	}
	.surat-tugas-penugasan i {
		font-size: 18px;
		color: #994442;
	}
	.penugasan-main, .penugasan-st {
		border: 1px solid #ccc;
		padding: 15px;
		margin-bottom: 15px;
		box-shadow: #ccc 0px 1px 5px;
		background: #fff;
	}
	.penugasan-kegiatan, .penugasan-monev-sec, .penugasan-undangan-sec {
		border: 1px solid #ccc;
		padding: 15px;
		box-shadow: #ccc 0px 1px 5px;
		background: #fff;
	}
	.penugasan-monev-sec + .penugasan-monev-sec,
	.penugasan-undangan-sec + .penugasan-undangan-sec{
		margin-top: 15px;
	}
	.penugasan-monev-head:after,
	.penugasan-undangan-head:after{
		display: block;
		content: '';
		clear: both;
	}
	.remove-monev-sec,
	.remove-undangan-sec{
		float: right;
		font-size: 18px;
		padding: 0px 5px 1px;
		margin: 0;
		line-height: 1;
	}
	.add-group-undangan, .add-group-monev {
		padding: 3px 12px;
	}
</style>

<?php
	$kabupatens = $this->config->item('transport_area');
	$provinsis = $this->config->item('provinsi');

	if (!isset($tipe)) {
		$tipe = 'monev';
	}
?>

<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Penugasan</h5>
		</div>
		<form action="/admin/kepegawaian/save_penugasan_kegiatan" method="post" class="form-penugasan" autocomplete="off">
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				
				<div class="penugasan-st">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Nomor Surat Tugas</label>
								<input type="text" name="nomor_surat" disabled class="form-control" value="<?php print isset($nomor_surat) ? $nomor_surat : ""; ?>" />
							</div>
							<div class="col-md-6">
								<?php
									$tglShow = "";
									if (isset($tgl_surat) && !empty($tgl_surat)) {
										$tglShow = date("d/m/Y", strtotime($tgl_surat));
									}
								?>
								<label>Tgl Surat Tugas</label>
								<input type="text" name="tgl_surat" disabled class="form-control datepicker" value="<?php print $tglShow; ?>" />
							</div>
						</div>
					</div>
					<div class="form-group mb-0">
						<div class="row">
							<div class="col-md-12">
								<label>Surat Tugas (.pdf - max 5 Mb)</label>
								<?php
									if (isset($surat) && !empty($surat)) {
								?>
										<div class="surat-tugas-penugasan">
											<div style="font-size: 14px;"><i class="fas fa-file-pdf"></i> <a href="<?php print base_url("/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$surat."?v=".rand()); ?>" target="_blank"><?php print $surat; ?> </a></div>
										</div>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="penugasan-main">
					<div class="form-group">
						<?php
							$tipePenugasan = array(
								"monev" => "Monev / Pendampingan / Undangan Luar",
								"peserta" => "Peserta Kegiatan Balai",
								"panitia" => "Panitia Kegiatan Balai",
								"narasumber" => "Narasumber Kegiatan Balai",
							);
						?>
						<label>Tipe Tugas</label>
						<select class="form-control select2" name="tipe" disabled>
							<?php
								foreach ($tipePenugasan as $keyJab => $valJab) {
									$selected = '';
									if (isset($tipe) && $keyJab == $tipe) {
										$selected = 'selected="selected"';
									}

									print '<option value="'.$keyJab.'" '.$selected.'>'.$valJab.'</option>';
								}
							?>
						</select>
					</div>
					
					<?php 
						if ($this->utility->hasUserAccess("kepegawaian","penugasan_dalam_kota")) {
					?>
							<div class="form-group">
								<label>Tugas Internal</label>
								<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
									<input type="hidden" name="penugasan_internal" value="0" disabled />

									<?php
										$penugasan_internal_selected = "";
										if (isset($penugasan_internal) && $penugasan_internal == "1") {
											$penugasan_internal_selected = 'checked="checked"';
										}
									?>

									<input type="checkbox" name="penugasan_internal" id="checkbox-penugasan_internal" <?php print $penugasan_internal_selected; ?> value="1" disabled />
									<label for="checkbox-penugasan_internal" class="cr">Ya, Penugasan Internal</label>
								</div>
							</div>
					<?php
						}
					?>
					
					<?php
						$showPenugasanKeg = '';
						$disablePenugasanKeg = 'disabled="disabled"';
						$showKeteranganTugas = 'display:none;';

						if (isset($tipe) && $tipe == "monev") {
							$showPenugasanKeg = 'display:none;';
							$disablePenugasanKeg = 'disabled="disabled"';
							$showKeteranganTugas = '';
						}
					?>

					<div class="penugasan-kegiatan-pilih" style="<?php print $showPenugasanKeg; ?>">
						<div class="form-group">
							<label>Pilih Kegiatan</label>
							<select class="form-control" <?php print $disablePenugasanKeg; ?> id="select-kegiatan" name="kegiatan_id" disabled data-selected="<?php print isset($kegiatan_id) ? $kegiatan_id : "0"; ?>">
							</select>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Tgl Mulai Kegiatan</label>
									<input type="text" disabled class="form-control tgl-mulai-kegiatan" value="" />
								</div>
								<div class="col-md-6">
									<label>Tgl Selesai Kegiatan</label>
									<input type="text" disabled class="form-control tgl-selesai-kegiatan" value="" />
								</div>
							</div>
						</div>
					</div>
					
					<div class="keterangan-monev" style="<?php print $showKeteranganTugas; ?>">
						<div class="form-group mb-0">
							<div class="row">
								<div class="col-md-12">
									<label>Keterangan Tugas</label>
									<textarea name="nama" class="form-control" rows="2" disabled placeholder="Rapat Koordinasi Program..."><?php print isset($nama) ? $nama : ""; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
					
				
				<?php
					$showPenugasanKeg = '';
					$disablePenugasanKeg = 'disabled="disabled"';
					
					if (isset($tipe) && $tipe == "monev") {
						$showPenugasanKeg = 'display:none;';
						$disablePenugasanKeg = 'disabled="disabled"';
					}
				?>
				
				<div class="penugasan-kegiatan" style="<?php print $showPenugasanKeg; ?>">
					<div class="form-group mb-0">
						<div class="row">
							<div class="col-md-12">
								<label>Petugas</label>
								<select name="petugas[]" <?php print $disablePenugasanKeg; ?> class="form-control select2 petugas-kegiatan" value="" multiple>
									<?php
										if (isset($pegawai) && !empty($pegawai)) {
											$selectedPetugas = array();

											if (isset($petugas) && !empty($petugas)) {
												$detailPetugas = json_decode($petugas, true);
												$selectedPetugas = $detailPetugas[0]["petugas"];
											}

											foreach ($pegawai as $peg) {
												$selected = "";

												if (in_array($peg["id"], $selectedPetugas)) {
													$selected = 'selected="selected"';
												}

												print '<option value="'.$peg["id"].'" '.$selected.'>'.$peg["nama"].'</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				
				
				<?php
					$showPenugasanMonev = '';
					$disablePenugasanMonev = 'disabled="disabled"';
					
					if (isset($tipe) && $tipe != "monev") {
						$showPenugasanMonev = 'display:none;';
						$disablePenugasanMonev = 'disabled="disabled"';
					}
				?>
				
				<div class="penugasan-monev" style="<?php print $showPenugasanMonev; ?>">
					<div class="monev-section">
						
						<?php
							$monevGroups = array();
						
							$monevGroup1 = array();
							$monevGroup1["tgl_mulai_tugas"] = "";
							$monevGroup1["tgl_selesai_tugas"] = "";
							$monevGroup1["provinsi_asal"] = $_ENV['DEFAULT_PROVINSI'];
							$monevGroup1["provinsi_tujuan"] = $_ENV['DEFAULT_PROVINSI'];
							$monevGroup1["kab_asal"] = $_ENV['DEFAULT_KABUPATEN'];
							$monevGroup1["kab_tujuan"] = $_ENV['DEFAULT_KABUPATEN'];
							$monevGroup1["tempat_tujuan"] = "";
							$monevGroup1["petugas"] = array();
						
							if (isset($petugas) && !empty($petugas)) {
								$monevGroups = json_decode($petugas, true);
								
								if (isset($monevGroups[0]) && !empty($monevGroups[0])) {
									$monevGroup1 = $monevGroups[0];
								}
							}
						?>
						
						<div class="penugasan-monev-sec">
							<div class="form-group mb-0"><label>GROUP 1</label></div>
							<hr class="mt-0 mb-3" />
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Tgl Mulai Tugas</label>
										<input type="text" <?php print $disablePenugasanMonev; ?> disabled class="form-control tgl-mulai-tugas datepicker" value="<?php print $monevGroup1["tgl_mulai_tugas"]; ?>" />
									</div>
									<div class="col-md-6">
										<label>Tgl Selesai Tugas</label>
										<input type="text" <?php print $disablePenugasanMonev; ?> disabled class="form-control tgl-selesai-tugas datepicker" value="<?php print $monevGroup1["tgl_selesai_tugas"]; ?>" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Provinsi Asal</label>

										<select class="form-control provinsi-asal select2" <?php print $disablePenugasanMonev; ?> disabled>
											<?php
												foreach ($provinsis as $provinsi => $provinsiKabupatens) {
													$selected = "";
													
													if (isset($monevGroup1["provinsi_asal"]) && $monevGroup1["provinsi_asal"] == $provinsi) {
														$selected = 'selected="selected"';
													}
													
													print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
												}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label>Kab/Kota Asal</label>
										<select class="form-control kab-asal select2" <?php print $disablePenugasanMonev; ?> disabled>
											<?php
												foreach ($provinsis as $provinsi => $provinsiKabupatens) {
													if (isset($monevGroup1["provinsi_asal"]) && $monevGroup1["provinsi_asal"] == $provinsi) {
														
														foreach ($provinsiKabupatens as $kabupaten) {
															$selected = "";

															if (isset($monevGroup1["kab_asal"]) && $monevGroup1["kab_asal"] == $kabupaten) {
																$selected = 'selected="selected"';
															}

															print '<option value="'.$kabupaten.'" '.$selected.'>'.$kabupaten.'</option>';
														}
														
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Provinsi Tujuan</label>

										<select class="form-control provinsi-tujuan select2" <?php print $disablePenugasanMonev; ?> disabled>
											<?php
												foreach ($provinsis as $provinsi => $provinsiKabupatens) {
													$selected = "";
													
													if (isset($monevGroup1["provinsi_tujuan"]) && $monevGroup1["provinsi_tujuan"] == $provinsi) {
														$selected = 'selected="selected"';
													}
													
													print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
												}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label>Kab/Kota Tujuan</label>
										<select class="form-control kab-tujuan select2" <?php print $disablePenugasanMonev; ?> disabled>
											<?php
												foreach ($provinsis as $provinsi => $provinsiKabupatens) {
													if (isset($monevGroup1["provinsi_tujuan"]) && $monevGroup1["provinsi_tujuan"] == $provinsi) {
														
														foreach ($provinsiKabupatens as $kabupaten) {
															$selected = "";

															if (isset($monevGroup1["kab_tujuan"]) && $monevGroup1["kab_tujuan"] == $kabupaten) {
																$selected = 'selected="selected"';
															}

															print '<option value="'.$kabupaten.'" '.$selected.'>'.$kabupaten.'</option>';
														}
														
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Tempat Tujuan</label>
										<textarea rows="2" disabled <?php print $disablePenugasanMonev; ?> class="form-control tempat-tujuan" placeholder="SMPN 1 Kupang"><?php print $monevGroup1["tempat_tujuan"]; ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Petugas</label>
										<select <?php print $disablePenugasanMonev; ?> class="form-control select2 petugas-monev" disabled value="" multiple>
											<?php
												if (isset($pegawai) && !empty($pegawai)) {
													$selectedPetugas = array();

													if (isset($monevGroup1["petugas"]) && !empty($monevGroup1["petugas"])) {
														$selectedPetugas = $monevGroup1["petugas"];
													}

													foreach ($pegawai as $peg) {
														$selected = "";

														if (in_array($peg["id"], $selectedPetugas)) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$peg["id"].'" '.$selected.'>'.$peg["nama"].'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<?php
							if (!empty($monevGroups) && count($monevGroups) > 1) {
								foreach ($monevGroups as $monevGroupKey => $monevGroup) {
									if (empty($monevGroupKey)) {
										continue;
									}
									
									$monevGroupNo = $monevGroupKey + 1;
						?>
									<div class="penugasan-monev-sec">
										<div class="form-group penugasan-monev-head mb-0"><label>GROUP <span class="penugasan-monev-group-no"><?php print $monevGroupNo; ?></span></label><button type="button" class="btn btn-danger remove-monev-sec" title="Hapus Group">×</button></div>
										<hr class="mt-0 mb-3" />
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Tgl Mulai Tugas</label>
													<input type="text" <?php print $disablePenugasanMonev; ?> disabled class="form-control tgl-mulai-tugas datepicker" value="<?php print $monevGroup["tgl_mulai_tugas"]; ?>" />
												</div>
												<div class="col-md-6">
													<label>Tgl Selesai Tugas</label>
													<input type="text" <?php print $disablePenugasanMonev; ?> disabled class="form-control tgl-selesai-tugas datepicker" value="<?php print $monevGroup["tgl_selesai_tugas"]; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Provinsi Asal</label>

													<select class="form-control provinsi-asal select2" <?php print $disablePenugasanMonev; ?> disabled>
														<?php
															foreach ($provinsis as $provinsi => $provinsiKabupatens) {
																$selected = "";

																if (isset($monevGroup["provinsi_asal"]) && $monevGroup["provinsi_asal"] == $provinsi) {
																	$selected = 'selected="selected"';
																}

																print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
															}
														?>
													</select>
												</div>
												<div class="col-md-6">
													<label>Kab/Kota Asal</label>
													<select class="form-control kab-asal select2" <?php print $disablePenugasanMonev; ?> disabled>
														<?php
															foreach ($provinsis as $provinsi => $provinsiKabupatens) {
																if (isset($monevGroup["provinsi_asal"]) && $monevGroup["provinsi_asal"] == $provinsi) {

																	foreach ($provinsiKabupatens as $kabupaten) {
																		$selected = "";

																		if (isset($monevGroup["kab_asal"]) && $monevGroup["kab_asal"] == $kabupaten) {
																			$selected = 'selected="selected"';
																		}

																		print '<option value="'.$kabupaten.'" '.$selected.'>'.$kabupaten.'</option>';
																	}

																}
															}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Provinsi Tujuan</label>

													<select class="form-control provinsi-tujuan select2" <?php print $disablePenugasanMonev; ?> disabled>
														<?php
															foreach ($provinsis as $provinsi => $provinsiKabupatens) {
																$selected = "";

																if (isset($monevGroup["provinsi_tujuan"]) && $monevGroup["provinsi_tujuan"] == $provinsi) {
																	$selected = 'selected="selected"';
																}

																print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
															}
														?>
													</select>
												</div>
												<div class="col-md-6">
													<label>Kab/Kota Tujuan</label>
													<select class="form-control kab-tujuan select2" <?php print $disablePenugasanMonev; ?> disabled>
														<?php
															foreach ($provinsis as $provinsi => $provinsiKabupatens) {
																if (isset($monevGroup["provinsi_tujuan"]) && $monevGroup["provinsi_tujuan"] == $provinsi) {

																	foreach ($provinsiKabupatens as $kabupaten) {
																		$selected = "";

																		if (isset($monevGroup["kab_tujuan"]) && $monevGroup["kab_tujuan"] == $kabupaten) {
																			$selected = 'selected="selected"';
																		}

																		print '<option value="'.$kabupaten.'" '.$selected.'>'.$kabupaten.'</option>';
																	}

																}
															}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label>Tempat Tujuan</label>
													<textarea rows="2" disabled <?php print $disablePenugasanMonev; ?> class="form-control tempat-tujuan" placeholder="SMPN 1 Kupang"><?php print $monevGroup["tempat_tujuan"]; ?></textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label>Petugas</label>
													<select disabled <?php print $disablePenugasanMonev; ?> class="form-control select2 petugas-monev" value="" multiple>
														<?php
															if (isset($pegawai) && !empty($pegawai)) {
																$selectedPetugas = array();
																
																if (isset($monevGroup["petugas"]) && !empty($monevGroup["petugas"])) {
																	$selectedPetugas = $monevGroup["petugas"];
																}

																foreach ($pegawai as $peg) {
																	$selected = "";
																	
																	if (in_array($peg["id"], $selectedPetugas)) {
																		$selected = 'selected="selected"';
																	}
																	
																	print '<option value="'.$peg["id"].'" '.$selected.'>'.$peg["nama"].'</option>';
																}
															}
														?>
													</select>
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
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var provinsis = [];
		
		<?php
			foreach ($provinsis as $provinsi => $provinsiKabupatens) {
				print 'var provinsi = {};';
				
				
				print 'var kabupaten = [];';
				
				foreach ($provinsiKabupatens as $kabupaten) {
					print 'kabupaten.push("'.$kabupaten.'");';
				}
				
				print 'provinsi["'.$provinsi.'"] = kabupaten;';
				
				print 'provinsis.push(provinsi);';
			}
		?>
		
		Kepegawaian.provinsi = provinsis;
		Kepegawaian.modalInit();
	});
</script>