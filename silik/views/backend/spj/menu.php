<ul class="nav nav-pills nav-pills-perjadin">
	<?php
		if (!empty($komponen)) {
			foreach ($komponen as $kom) {
				if (isset($kegiatan["tipe_kegiatan"]) && $kegiatan["tipe_kegiatan"] == "Daring" && $kom["komponen"] == "panitia") {
					continue;
				}
	?>
			<li class="nav-item">
				<a class="nav-link <?php if ($kom["id"] == $spj["id"]) { print "active"; } ?>" href="<?php print base_url("admin/spj/detail/".$kom["id"]."/"); ?>"><?php print ucwords(str_replace("_"," ", $kom["komponen"])); ?></a>
			</li>
	<?php
			}
		}
	?>
	<li class="nav-more-opt"><a data-toggle="collapse" href="#spj-id-<?php print $spj["id"]; ?>" role="button" aria-expanded="true" aria-controls="spj-id-<?php print $spj["id"]; ?>"><i class="fas fa-angle-down"></i></a></li>
</ul>

<?php
	$showTiket = true;
	$showTransport = true;
	$showHonor = true;
	$showPulsa = false;
	$showUangHarian = true;
	$showLainnya = false;

	/*$transportDarat = $this->config->item("transport_darat");
	$transportLaut = $this->config->item("transport_laut");

	print "<pre>";
	print_r($transportDarat);
	print "</pre>";*/

	if (isset($penugasan) && !empty($penugasan) && isset($penugasan["petugas"]) && !empty($penugasan["petugas"])) {
		foreach ($penugasan["petugas"] as $petugasDetail) {
			if ($petugasDetail["provinsi_asal"] != $_ENV['DEFAULT_PROVINSI'] || $petugasDetail["provinsi_tujuan"] != $_ENV['DEFAULT_PROVINSI']) {
				$showTiket = true;
				$showTransport = false;
				$showHonor = false;
			}
		}
	}
	
	if (isset($spj["komponen"]) && ($spj["komponen"] == "peserta" || $spj["komponen"] == "petugas")) {
		$showHonor = false;
	}
	
	if (!empty($spj["kegiatan_id"])) {
		$showTiket = true;
		$showLainnya = true;
	}

	if (isset($kegiatan["tipe_kegiatan"]) && $kegiatan["tipe_kegiatan"] == "Daring") {
		$showTiket = false;
		$showTransport = false;
		$showUangHarian = false;
		$showPulsa = true;
	}
?>

<div id="spj-id-<?php print $spj["id"]; ?>" class="collapse">
	<div class="keg-opt-form">
		<form class="form-spj-option" method="post">
			<input type="hidden" class="spj_id" name="id" value="<?php print $spj["id"]; ?>" />
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="javascript:;" aria-controls="dasar-pembayaran">Dasar Pembayaran</a>
						</li>
						
						<?php if ($showTiket || $showHonor) { ?>
								<li class="nav-item">
									<a class="nav-link" href="javascript:;" aria-controls="rincian-tiket">Tiket & Taksi</a>
								</li>
						<?php } ?>
						
						<?php if ($showTransport) { ?>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-transport">Transport</a>
						</li>
						<?php } ?>
						
						<?php if ($showPulsa) { ?>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-pulsa">Pulsa / Paket Data</a>
						</li>
						<?php } ?>
						
						<?php if ($showUangHarian) { ?>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-uang-harian">Uang Harian & Penginapan</a>
						</li>
						<?php } ?>
						
						<?php if ($showHonor) { ?>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-honor">Honor</a>
						</li>
						<?php } ?>
						
						<?php if ($showLainnya) { ?>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-spj">Lainnya</a>
						</li>
						<?php } ?>
						
						<?php /*
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-spby">SPBy</a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-spm">SPM</a>
						</li>
						*/ ?>
					</ul>
				</div>
			</div>
			<div class="tab-content">
				<div class="tab-pane active show" id="dasar-pembayaran">
					<div class="row">
						<div class="col-md-7">
							<label>Dipa Anggaran</label>
							<hr />

							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Program</label>
										<select name="dipa[program]" class="select-mak form-control select2 required" data-name="Dipa Program">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["program"]) && !empty($mak["program"])) {
													foreach ($mak["program"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["program"]) && $spj["dipa"]["program"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Kegiatan</label>
										<select name="dipa[kegiatan]" class="select-mak select2 form-control required" data-name="Dipa Kegiatan">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["kegiatan"]) && !empty($mak["kegiatan"])) {
													foreach ($mak["kegiatan"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["kegiatan"]) && $spj["dipa"]["kegiatan"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>KRO</label>
										<select name="dipa[kro]" class="select-mak select2 form-control required" data-name="Dipa KRO">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["kro"]) && !empty($mak["ro"])) {
													foreach ($mak["kro"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["kro"]) && $spj["dipa"]["kro"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>RO</label>
										<select name="dipa[ro]" class="select-mak select2 form-control required" data-name="Dipa RO">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["ro"]) && !empty($mak["ro"])) {
													foreach ($mak["ro"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["ro"]) && $spj["dipa"]["ro"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Komponen</label>
										<select name="dipa[komponen]" class="select-mak select2 form-control required" data-name="Dipa Komponen">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["komponen"]) && !empty($mak["komponen"])) {
													foreach ($mak["komponen"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["komponen"]) && $spj["dipa"]["komponen"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Sub Kom.</label>
										<select name="dipa[sub_komponen]" class="select-mak select2 form-control required" data-name="Dipa Sub Komponen">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["sub_komponen"]) && !empty($mak["sub_komponen"])) {
													foreach ($mak["sub_komponen"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["sub_komponen"]) && $spj["dipa"]["sub_komponen"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Akun Trans.</label>
										<select name="dipa[akun_transport]" class="select-mak select2 form-control" data-name="Dipa Akun Transport">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["akun"]) && !empty($mak["akun"])) {
													foreach ($mak["akun"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["akun_transport"]) && $spj["dipa"]["akun_transport"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Akun Honor</label>
										<select name="dipa[akun_honor]" class="select-mak select2 form-control" data-name="Dipa Akun Honor">
											<option value="">&nbsp;</option>
											<?php
												if (isset($mak["akun"]) && !empty($mak["akun"])) {
													foreach ($mak["akun"] as $boo) {
														$selected = "";
														
														if (isset($spj["dipa"]["akun_honor"]) && $spj["dipa"]["akun_honor"] == $boo) {
															$selected = 'selected="selected"';
														}
														
														print '<option value="'.$boo.'" '.$selected.'>'.$boo.'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1">
							&nbsp;
						</div>
						<div class="col-md-4">
							<label style="display: block;">
								Dasar Surat
								
								<?php
									if (isset($penugasan) && !empty($penugasan)) {
										
										$filename = APPPATH . "../assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$penugasan["surat"];
										$filepath = "/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$penugasan["surat"];

										if (file_exists($filename)) {
											print '<a href="'.base_url($filepath).'" target="_blank" style="float: right;">Lihat</a>';
										}
									}
								?>
							</label>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Jenis Surat</label>
										<select class="form-control select2" name="based[jenis_surat]">
											<?php
												$jenisSurats = array("Surat Tugas", "Surat Undangan", "Surat Keputusan");
											
												foreach ($jenisSurats as $jenisSurat) {
													$selected = "";
													
													if (isset($spj["based"]["jenis_surat"]) && !empty($spj["based"]["jenis_surat"]) && $spj["based"]["jenis_surat"] == $jenisSurat) {
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
								<div class="col-md-7">
									<div class="form-group form-group-sm">
										<label>Nomor Surat</label>
										<input type="text" name="based[nomor_surat]" class="form-control" value="<?php print (isset($spj["based"]["nomor_surat"])) ? $spj["based"]["nomor_surat"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label>Tanggal Surat</label>
										<input type="text" name="based[tgl_surat]" class="form-control datepicker" value="<?php print (isset($spj["based"]["tgl_surat"])) ? $spj["based"]["tgl_surat"] : ""; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<?php if ($showLainnya) { ?>
				<div class="tab-pane" id="rincian-spj">
					<div class="row">
						<div class="col-md-5">
							<label>Pembayaran</label>
							<hr />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Lokasi Kab/Kota</label>
										<select name="based[kab_kuitansi]" disabled class="form-control select2">
											<?php
												$kab_spj = isset($spj["based"]["kab_kuitansi"]) && !empty($spj["based"]["kab_kuitansi"]) ? $spj["based"]["kab_kuitansi"] : $kegiatan["kab_tempat_kegiatan"];

												$areas = $this->config->item("transport_area");

												foreach ($areas as $area) {
													$selected = "";

													if ($area == $kab_spj) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<?php
											$tglSelesaiKeg = date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
										
											$tgl_spj = isset($spj["based"]["tgl_kuitansi"]) && !empty($spj["based"]["tgl_kuitansi"]) ? $spj["based"]["tgl_kuitansi"] : $tglSelesaiKeg;
										?>
										<label>Tanggal</label>
										<input type="text" disabled name="based[tgl_kuitansi]" class="form-control datepicker" value="<?php print (isset($tgl_spj)) ? $tgl_spj : ""; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php if ($showTiket || $showHonor) { ?>
					<div class="tab-pane" id="rincian-tiket">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-group-sm">
													<label>Tiket Pesawat Berangkat</label>
													<input disabled type="text" name="based[tiket_berangkat]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["tiket_berangkat"])) ? $spj["based"]["tiket_berangkat"] : ""; ?>" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-sm">
													<label>Tiket Pesawat Pulang</label>
													<input disabled type="text" name="based[tiket_pulang]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["tiket_pulang"])) ? $spj["based"]["tiket_pulang"] : ""; ?>" />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-group-sm">
													<label>Taksi Berangkat</label>
													<input disabled type="text" name="based[taksi_berangkat]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["taksi_berangkat"])) ? $spj["based"]["taksi_berangkat"] : ""; ?>" />
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group form-group-sm">
													<label>&nbsp;</label>
													<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
														<input disabled type="hidden" name="based[dpr_taksi_berangkat]" value="0" />

														<?php
															$dpr_taksi_berangkat_selected = "";
															if (isset($spj["based"]["dpr_taksi_berangkat"]) && $spj["based"]["dpr_taksi_berangkat"] == "1") {
																$dpr_taksi_berangkat_selected = 'checked="checked"';
															}
														?>

														<input disabled type="checkbox" name="based[dpr_taksi_berangkat]" id="checkbox-dpr_taksi_berangkat" <?php print $dpr_taksi_berangkat_selected; ?> value="1" />
														<label for="checkbox-dpr_taksi_berangkat" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-group-sm">
													<label>Taksi Pulang</label>
													<input disabled type="text" name="based[taksi_pulang]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["taksi_pulang"])) ? $spj["based"]["taksi_pulang"] : ""; ?>" />
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group form-group-sm">
													<label>&nbsp;</label>
													<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
														<input disabled type="hidden" name="based[dpr_taksi_pulang]" value="0" />

														<?php
															$dpr_taksi_pulang_selected = "";
															if (isset($spj["based"]["dpr_taksi_pulang"]) && $spj["based"]["dpr_taksi_pulang"] == "1") {
																$dpr_taksi_pulang_selected = 'checked="checked"';
															}
														?>

														<input disabled type="checkbox" name="based[dpr_taksi_pulang]" id="checkbox-dpr_taksi_pulang" <?php print $dpr_taksi_pulang_selected; ?> value="1" />
														<label for="checkbox-dpr_taksi_pulang" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				
				<?php if ($showTransport) { ?>
				<div class="tab-pane" id="rincian-transport">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-7">
									<div class="row">
										<?php
											$areas = array();
											foreach ($this->config->item("transport_darat") as $area) {
												$areas[$area] = $area;
											}

											foreach ($this->config->item("transport_laut") as $area) {
												$areas[$area] = $area;
											}

											foreach ($areas as $area) {
												$area_name = "transport_".strtolower(str_replace(array(" "),array("_"),$area));
										?>
												<div class="col-md-4">
													<div class="form-group form-group-sm">
														<label><?php print $area; ?></label>
														<input disabled type="text" name="based[<?php print $area_name; ?>]" class="form-control autoNumeric" value="<?php print (isset($spj["based"][$area_name])) ? $spj["based"][$area_name] : ""; ?>" />
													</div>
												</div>
										<?php
											}
										?>
									</div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group form-group-sm">
												<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
													<input disabled type="hidden" name="based[dpr_transport]" value="0" />

													<?php
														$dpr_transport_selected = "";
														if (isset($spj["based"]["dpr_transport"]) && $spj["based"]["dpr_transport"] == "1") {
															$dpr_transport_selected = 'checked="checked"';
														}
													?>

													<input disabled type="checkbox" name="based[dpr_transport]" id="checkbox-dpr_transport" <?php print $dpr_transport_selected; ?> value="1" />
													<label for="checkbox-dpr_transport" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group form-group-sm">
												<label>Keterangan Transport</label>
												<textarea disabled class="form-control" rows="3" name="based[keterangan_transport]" ><?php print (isset($spj["based"]["keterangan_transport"])) ? $spj["based"]["keterangan_transport"] : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									&nbsp;
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-9">
											<div class="form-group form-group-sm">
												<label>Transport Lainnya</label>
												<input disabled type="text" name="based[transport_lainnya]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["transport_lainnya"])) ? $spj["based"]["transport_lainnya"] : ""; ?>" />
											</div>
										</div>
										<div class="col-md-9">
											<div class="form-group form-group-sm">
												<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
													<input disabled type="hidden" name="based[dpr_transport_lainnya]" value="0" />

													<?php
														$dpr_transport_lainnya_selected = "";
														if (isset($spj["based"]["dpr_transport_lainnya"]) && $spj["based"]["dpr_transport_lainnya"] == "1") {
															$dpr_transport_lainnya_selected = 'checked="checked"';
														}
													?>

													<input disabled type="checkbox" name="based[dpr_transport_lainnya]" id="checkbox-dpr_transport_lainnya" <?php print $dpr_transport_lainnya_selected; ?> value="1" />
													<label for="checkbox-dpr_transport_lainnya" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group form-group-sm">
												<label>Keterangan Transport Lainnya</label>
												<textarea disabled class="form-control" rows="3" name="based[keterangan_transport_lainnya]"><?php print (isset($spj["based"]["keterangan_transport_lainnya"])) ? $spj["based"]["keterangan_transport_lainnya"] : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php if ($showUangHarian) { ?>
				<div class="tab-pane" id="rincian-uang-harian">
					<div class="row">
						<div class="col-md-5">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Uang Harian / Hari</label>
										<input disabled type="text" name="based[uang_harian]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["uang_harian"])) ? $spj["based"]["uang_harian"] : ""; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Keterangan Uang Harian</label>
										<textarea disabled class="form-control" rows="3" name="based[keterangan_uang_harian]" ><?php print (isset($spj["based"]["keterangan_uang_harian"])) ? $spj["based"]["keterangan_uang_harian"] : ""; ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1">&nbsp;</div>
						<div class="col-md-5">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Penginapan / Mlm</label>
										<input disabled type="text" name="based[penginapan]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["penginapan"])) ? $spj["based"]["penginapan"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label>&nbsp;</label>
										<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
											<input disabled type="hidden" name="based[dpr_penginapan]" value="0" />

											<?php
												$dpr_penginapan_selected = "";
												if (isset($spj["based"]["dpr_penginapan"]) && $spj["based"]["dpr_penginapan"] == "1") {
													$dpr_penginapan_selected = 'checked="checked"';
												}
											?>

											<input disabled type="checkbox" name="based[dpr_penginapan]" id="checkbox-dpr_penginapan" <?php print $dpr_penginapan_selected; ?> value="1" />
											<label for="checkbox-dpr_penginapan" class="cr">&nbsp;&nbsp;&nbsp; Masuk DPR?</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Keterangan Penginapan</label>
										<textarea disabled class="form-control" rows="3" name="based[keterangan_penginapan]" ><?php print (isset($spj["based"]["keterangan_penginapan"])) ? $spj["based"]["keterangan_penginapan"] : ""; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php if ($showPulsa) { ?>
				<div class="tab-pane" id="rincian-pulsa">
					<div class="row">
						<div class="col-md-5">

							<div class="row">
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label>Pulsa / Paket Data</label>
										<input disabled type="text" name="based[pulsa]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pulsa"])) ? $spj["based"]["pulsa"] : ""; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Keterangan Pulsa / Paket Data</label>
										<textarea disabled class="form-control" rows="3" name="based[keterangan_pulsa]" ><?php print (isset($spj["based"]["keterangan_pulsa"])) ? $spj["based"]["keterangan_pulsa"] : ""; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php if ($showHonor) { ?>
				<div class="tab-pane" id="rincian-honor">
					<div class="row">
						<div class="col-md-5">

							<div class="row">
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label>Honor/Vol</label>
										<input disabled type="text" name="based[honor]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["honor"])) ? $spj["based"]["honor"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group form-group-sm">
										<label>Vol</label>
										<input disabled type="text" name="based[vol_honor]" class="form-control" value="<?php print (isset($spj["based"]["vol_honor"])) ? $spj["based"]["vol_honor"] : "1"; ?>" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label>Satuan</label>
										<input disabled type="text" name="based[satuan_honor]" class="form-control" value="<?php print (isset($spj["based"]["satuan_honor"])) ? $spj["based"]["satuan_honor"] : "jam"; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Uraian Honor</label>
										<textarea disabled class="form-control" rows="3" name="based[keterangan_honor]" placeholder="Belanja Jasa Profesi (Honor Narasumber)..."><?php print (isset($spj["based"]["keterangan_honor"])) ? $spj["based"]["keterangan_honor"] : ""; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php /* ?>
				<div class="tab-pane" id="rincian-spby">
					<div class="row">
						<div class="col-md-5">
							<label>SPBy Transport</label>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Penerima</label>
										<select id="select_spby" class="form-control" name="based[penerima_spby_transport]" data-selected="<?php print (isset($spj["based"]["penerima_spby_transport"])) ? $spj["based"]["penerima_spby_transport"] : "0"; ?>"></select>
										
										<input type="hidden" class="nama-penerima-spby" name="based[nama_penerima_spby_transport]" value="<?php print (isset($spj["based"]["nama_penerima_spby_transport"])) ? $spj["based"]["nama_penerima_spby_transport"] : ""; ?>" />
										
										<input type="hidden" class="nip-penerima-spby" name="based[nip_penerima_spby_transport]" value="<?php print (isset($spj["based"]["nip_penerima_spby_transport"])) ? $spj["based"]["nip_penerima_spby_transport"] : ""; ?>" />
									</div>
									<div class="form-group form-group-sm">
										<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
											<input type="hidden" name="based[penerima_spby_dkk]" value="0" />

											<?php
												$penerima_spby_dkk_selected = "";
												if (isset($spj["based"]["penerima_spby_dkk"]) && $spj["based"]["penerima_spby_dkk"] == "1") {
													$penerima_spby_dkk_selected = 'checked="checked"';
												}
											?>

											<input type="checkbox" name="based[penerima_spby_dkk]" id="checkbox-penerima_spby_dkk" <?php print $penerima_spby_dkk_selected; ?> value="1" />
											<label for="checkbox-penerima_spby_dkk" class="cr">&nbsp;&nbsp;&nbsp; Penerima dkk?</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Deskripsi</label>
										<textarea class="form-control" rows="5" name="based[deskripsi_spby]" ><?php print (isset($spj["based"]["deskripsi_spby"])) ? $spj["based"]["deskripsi_spby"] : ""; ?></textarea>
									</div>
								</div>
							</div>
							
							
							<div class="row hidden">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Kuitansi/Bukti Pembelian</label>
												<?php
													$bukti_pembelian_spby = isset($spj["based"]["bukti_pembelian_spby"]) && !empty($spj["based"]["bukti_pembelian_spby"]) ? $spj["based"]["bukti_pembelian_spby"] : "Kuitansi";
												?>
												<input type="text" name="based[bukti_pembelian_spby]" class="form-control" value="<?php print $bukti_pembelian_spby; ?>" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Nota/Bukti Penerimaan</label>
												<?php
													$bukti_penerimaan_spby = isset($spj["based"]["bukti_penerimaan_spby"]) && !empty($spj["based"]["bukti_penerimaan_spby"]) ? $spj["based"]["bukti_penerimaan_spby"] : "Daftar Pengeluaran Riil";
												?>
												<input type="text" name="based[bukti_penerimaan_spby]" class="form-control" value="<?php print $bukti_penerimaan_spby; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Kab/Kota</label>
												<select name="based[kab_spby]" class="form-control select2">
													<?php
														$kab_spj = isset($spj["based"]["kab_spby"]) && !empty($spj["based"]["kab_spby"]) ? $spj["based"]["kab_spby"] : $kegiatan["kab_tempat_kegiatan"];

														$areas = $this->config->item("transport_area");

														foreach ($areas as $area) {
															$selected = "";

															if ($area == $kab_spj) {
																$selected = 'selected="selected"';
															}

															print '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Tanggal</label>
												<input type="text" name="based[tgl_spby]" class="form-control datepicker" value="<?php print (isset($spj["based"]["tgl_spby"])) ? $spj["based"]["tgl_spby"] : ""; ?>" autocomplete="off" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1">&nbsp;</div>
						
						<?php if ($showHonor) { ?>
							<div class="col-md-5">
							<label>SPBy Honor</label>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Penerima</label>
										<select id="select_spby_honor" data-unsur="narasumber" class="form-control" name="based[penerima_spby_honor]" data-selected="<?php print (isset($spj["based"]["penerima_spby_honor"])) ? $spj["based"]["penerima_spby_honor"] : "0"; ?>"></select>
										
										<input type="hidden" class="nama-penerima-spby" name="based[nama_penerima_spby_honor]" value="<?php print (isset($spj["based"]["nama_penerima_spby_honor"])) ? $spj["based"]["nama_penerima_spby_honor"] : ""; ?>" />
										
										<input type="hidden" class="nip-penerima-spby" name="based[nip_penerima_spby_honor]" value="<?php print (isset($spj["based"]["nip_penerima_spby_honor"])) ? $spj["based"]["nip_penerima_spby_honor"] : ""; ?>" />
									</div>
									<div class="form-group form-group-sm">
										<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
											<input type="hidden" name="based[penerima_spby_honor_dkk]" value="0" />

											<?php
												$penerima_spby_honor_dkk_selected = "";
												if (isset($spj["based"]["penerima_spby_honor_dkk"]) && $spj["based"]["penerima_spby_honor_dkk"] == "1") {
													$penerima_spby_honor_dkk_selected = 'checked="checked"';
												}
											?>

											<input type="checkbox" name="based[penerima_spby_honor_dkk]" id="checkbox-penerima_spby_honor_dkk" <?php print $penerima_spby_honor_dkk_selected; ?> value="1" />
											<label for="checkbox-penerima_spby_honor_dkk" class="cr">&nbsp;&nbsp;&nbsp; Penerima dkk?</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Deskripsi</label>
										<textarea class="form-control" rows="5" name="based[deskripsi_spby_honor]" ><?php print (isset($spj["based"]["deskripsi_spby_honor"])) ? $spj["based"]["deskripsi_spby_honor"] : ""; ?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Kuitansi/Bukti Pembelian</label>
												<?php
													$bukti_pembelian_spby_honor = isset($spj["based"]["bukti_pembelian_spby_honor"]) && !empty($spj["based"]["bukti_pembelian_spby_honor"]) ? $spj["based"]["bukti_pembelian_spby_honor"] : "Kuitansi";
												?>
												<input type="text" name="based[bukti_pembelian_spby_honor]" class="form-control" value="<?php print $bukti_pembelian_spby_honor; ?>" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Nota/Bukti Penerimaan</label>
												<?php
													$bukti_penerimaan_spby_honor = isset($spj["based"]["bukti_penerimaan_spby_honor"]) && !empty($spj["based"]["bukti_penerimaan_spby_honor"]) ? $spj["based"]["bukti_penerimaan_spby_honor"] : "Daftar Pengeluaran Riil";
												?>
												<input type="text" name="based[bukti_penerimaan_spby_honor]" class="form-control" value="<?php print $bukti_penerimaan_spby_honor; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Kab/Kota</label>
												<select name="based[kab_spby_honor]" class="form-control select2">
													<?php
														$kab_spby_honor = isset($spj["based"]["kab_spby_honor"]) && !empty($spj["based"]["kab_spby_honor"]) ? $spj["based"]["kab_spby_honor"] : $kegiatan["kab_tempat_kegiatan"];

														$areas = $this->config->item("transport_area");

														foreach ($areas as $area) {
															$selected = "";

															if ($area == $kab_spj) {
																$selected = 'selected="selected"';
															}

															print '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Tanggal</label>
												<input type="text" name="based[tgl_spby_honor]" class="form-control datepicker" value="<?php print (isset($spj["based"]["tgl_spby_honor"])) ? $spj["based"]["tgl_spby_honor"] : ""; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php */ ?>
				
				<div class="tab-pane" id="rincian-spm">
					<div class="row">
						<div class="col-md-5">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Nomor SPM</label>
										<input disabled type="text" name="based[nomor_spm]" class="form-control" value="<?php print (isset($spj["based"]["nomor_spm"])) ? $spj["based"]["nomor_spm"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Tanggal SPM</label>
										<input disabled type="text" name="based[tgl_spm]" class="form-control datepicker" value="<?php print (isset($spj["based"]["tgl_spm"])) ? $spj["based"]["tgl_spm"] : ""; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10">
							<div class="row">
								<?php if ($showTiket) { ?>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Pagu Tiket</label>
										<input disabled type="text" name="based[pagu_tiket]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pagu_tiket"])) ? $spj["based"]["pagu_tiket"] : ""; ?>" />
									</div>
								</div>
								<?php } ?>
								
								<?php if ($showTiket) { ?>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Pagu Taksi</label>
										<input disabled type="text" name="based[pagu_taksi]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pagu_taksi"])) ? $spj["based"]["pagu_taksi"] : ""; ?>" />
									</div>
								</div>
								<?php } ?>
								
								<?php if ($showTransport) { ?>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Pagu Transport</label>
										<input disabled type="text" name="based[pagu_transport]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pagu_transport"])) ? $spj["based"]["pagu_transport"] : ""; ?>" />
									</div>
								</div>
								<?php } ?>
								
								<?php if ($showUangHarian) { ?>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Pagu Uang Harian</label>
										<input disabled type="text" name="based[pagu_uang_harian]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pagu_uang_harian"])) ? $spj["based"]["pagu_uang_harian"] : ""; ?>" />
									</div>
								</div>
								<?php } ?>
								
								<?php if ($showUangHarian) { ?>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Pagu Penginapan</label>
										<input disabled type="text" name="based[pagu_penginapan]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pagu_penginapan"])) ? $spj["based"]["pagu_penginapan"] : ""; ?>" />
									</div>
								</div>
								<?php } ?>
								
								<?php if ($showHonor) { ?>
									<div class="col-md-3">
										<div class="form-group form-group-sm">
											<label>Pagu Honor</label>
											<input disabled type="text" name="based[pagu_honor]" class="form-control autoNumeric" value="<?php print (isset($spj["based"]["pagu_honor"])) ? $spj["based"]["pagu_honor"] : ""; ?>" />
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-md-12">
					<button type="submit" disabled class="btn btn-danger">Terapkan</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div style="display: block;height: 15px;">&nbsp;</div>