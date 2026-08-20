<?php $url_1 = $this->uri->segment(2); ?>
<?php $url_2 = $this->uri->segment(4); ?>
<ul class="nav nav-pills nav-pills-perjadin nav-pills-keg" style="padding:15px 15px 5px;">
	<?php
		$showMoreOpt = false;
		$opt = "keg-more-opt-peserta";

		if (!empty($opsi_komponen)) {
			foreach ($opsi_komponen as $kom) {
				if (isset($kegiatan["komponen"][$kom->code]) && $kegiatan["komponen"][$kom->code] == "1") {
			?>
				<li class="nav-item">
					<a class="nav-link <?php if ($url_2 == $kom->code) { print "active"; } ?>" href="<?php print base_url("admin/item/".$kegiatan["id"]."/".$kom->code."/"); ?>"><?php print $kom->name; ?></a>
				</li>
			<?php
				}

				if ($url_2 == $kom->code) {
					$showMoreOpt = true;
					$opt = "keg-more-opt-".$kom->code;
				}
			}
		}
	?>

	<?php if ($this->utility->hasUserAccess("data_dukung_kegiatan","list")) { ?>
	<li class="nav-item">
		<a class="nav-link <?php if ($url_1 == "data_dukung") { print "active"; } ?>" href="<?php print base_url("admin/data_dukung/".$kegiatan["id"]."/"); ?>">Data Dukung</a>
	</li>
	<?php } ?>
	
	<?php if ($showMoreOpt) { ?>
		<li class="nav-more-opt"><a data-toggle="collapse" href="#<?php print $opt; ?>" role="button" aria-expanded="true" aria-controls="<?php print $opt; ?>"><i class="fas fa-angle-down"></i></a></li>
	<?php } ?>
</ul>
<style type="text/css">
	.btn-edit-spd-link { padding: 6px 10px; margin: 0 0 4px; }
	.btn-edit-spd-link i { margin: 0; }
	.input-edit-spd-link { width: 85%; padding: 7px 12px; display: inline-block; cursor: pointer; }
	.d-inline { display: inline-block; }
	.form-link-dh { padding: 6px; height: 30px; min-height: 30px }
	.switch-dh { margin-left: 10px; }
	.btn-edit-dh-bitly { padding: 2px 0 0; background:none;}
	.form-control.form-link-dh { border: 1px solid #c2defd; background-color: #ddecfd; cursor: pointer; font-size:13px; color:#222; }
	.link-off .form-link-dh { border: 1px solid #EFEFEF; background: #EFEFEF; color: #888; cursor: default;}
	.btn.btn-edit-dh-bitly { font-size:16px; }
	.btn.btn-edit-dh-bitly[disabled] { opacity:0.4; }
</style>

<div class="keg-more-opt">
	<?php
		if (!empty($opsi_komponen)) {
			foreach ($opsi_komponen as $kom) {
				if ($url_2 == $kom->code) {
				?>
					<div id="keg-more-opt-<?php print $kom->code; ?>" class="collapse">
						<div class="keg-opt-form">
							<form action="/admin/kegiatan/save_more_opt" method="post" class="form-submit" autocomplete="off">
								<input type="hidden" name="id" value="<?php print $kegiatan["id"]; ?>" />
								<input type="hidden" name="komponen" value="<?php print $kom->code; ?>" />
								<input type="hidden" name="base_url" value="<?php print base_url(); ?>" />
								<input type="hidden" name="option[form_show_bank]" value="0" />
								<input type="hidden" name="option[form_show_confirm_paket]" value="0" />
								<input type="hidden" name="option[form_ttd]" value="0" />
								<input type="hidden" name="option[form_upload_surtug]" value="0" />
								<input type="hidden" name="option[form_wajib_surtug]" value="0" />
								<input type="hidden" name="option[npsn]" value="0" />
								<?php
									$bank = '';
									$paket = '';
									$ttd = '';
									$upSurtug = '';
									$surtug = '';
									$npsn = '';

									if (isset($kegiatan_options["form_show_bank"]) && $kegiatan_options["form_show_bank"] == 1) {
										$bank = 'checked="checked"';
									}

									if (isset($kegiatan_options["form_show_confirm_paket"]) && $kegiatan_options["form_show_confirm_paket"] == 1) {
										$paket = 'checked="checked"';
									}
									
									if (isset($kegiatan_options["form_ttd"]) && $kegiatan_options["form_ttd"] == 1) {
										$ttd = 'checked="checked"';
									}
									
									if (isset($kegiatan_options["form_upload_surtug"]) && $kegiatan_options["form_upload_surtug"] == 1) {
										$upSurtug = 'checked="checked"';
									}
									
									if (isset($kegiatan_options["form_wajib_surtug"]) && $kegiatan_options["form_wajib_surtug"] == 1) {
										$surtug = 'checked="checked"';
									}

									if (isset($kegiatan_options["npsn"]) && $kegiatan_options["npsn"] == 1) {
										$npsn = 'checked="checked"';
									}
								?>
								<div class="row">
									
									<div class="col-md-12">
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item active">
												<a class="nav-link" href="#form-<?php print $kom->code;?>" data-toggle="tab">Form Pendaftaran</a>
											</li>
											
											<?php
												if ($kegiatan["tipe_kegiatan"] == "Daring") {
											?>
													<li class="nav-item">
														<a class="nav-link" href="#dh-<?php print $kom->code;?>" data-toggle="tab">Daftar Hadir</a>
													</li>
											<?php
												}
												else {
											?>
													<li class="nav-item">
														<a class="nav-link" href="#spd-<?php print $kom->code;?>" data-toggle="tab">Surat Perjalanan Dinas</a>
													</li>
											<?php
												}
											?>
											<li class="nav-item">
												<a class="nav-link" href="#sertifikat-<?php print $kom->code;?>" data-toggle="tab">Sertifikat</a>
											</li>
										</ul>
									</div>
									
									<div class="col-md-12">
										<div class="tab-content">
											<div class="tab-pane active" id="form-<?php print $kom->code;?>">
												<div class="row">
													<div class="col-md-6">
														<label>Form Pendaftaran <?php print $kom->name;?></label>
														<div class="form-group">
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 5px 0 0;">
																<input type="checkbox" name="option[form_show_bank]" id="checkbox-p-1" <?php print $bank; ?> value="1" />
																<label for="checkbox-p-1" class="cr">Tampilkan Form Akun Bank</label>
															</div>
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 5px 0 0;">
																<input type="checkbox" name="option[form_show_confirm_paket]" id="checkbox-p-2" <?php print $paket; ?> value="1" />
																<label for="checkbox-p-2" class="cr">Tampilkan Form Konfirmasi <strong>"Berkomitmen Hadir"</strong> </label>
															</div>
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 5px 0 0;">
																<input type="checkbox" name="option[form_ttd]" id="checkbox-p-x1" <?php print $ttd; ?> value="1" />
																<label for="checkbox-p-x1" class="cr">Tampilkan Form Tanda Tangan</label>
															</div>
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 5px 0 0;">
																<input type="checkbox" name="option[npsn]" id="checkbox-p-npsp" <?php print $npsn; ?> value="1" />
																<label for="checkbox-p-npsp" class="cr">Tampilkan Form Nomor Pokok Sekolah Nasional (NPSN)</label>
															</div>
														</div>
														<div class="form-group">
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 5px 0 0;">
																<input type="checkbox" name="option[form_upload_surtug]" id="checkbox-st-1" <?php print $upSurtug; ?> value="1" />
																<label for="checkbox-st-1" class="cr">Tampilkan Form Upload Surat Tugas</label>
															</div>
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 5px 0 0;">
																<input type="checkbox" name="option[form_wajib_surtug]" id="checkbox-st-2" <?php print $surtug; ?> value="1" />
																<label for="checkbox-st-2" class="cr">Peserta Wajib Upload Surat Tugas</label>
															</div>
														</div>
														<label>Kategori</label>
														<div class="form-group">
															<?php
																$pengkelasan = "";
																if (isset($kegiatan_options["kategori"]) && !empty($kegiatan_options["kategori"])) {
																	$pengkelasan = $kegiatan_options["kategori"];
																}
															?>
															<textarea class="form-control" rows="4" name="option[kategori]"><?php print $pengkelasan; ?></textarea>
															<small>Kosongkan jika tidak ada pengkelasan; Enter untuk tiap nama kelas.</small>
														</div>
														
													</div>
													<div class="col-md-5">
														<label>Link WA Grup <?php print $kom->name;?></label>
														<div class="form-group">
															<div class="input-group input-group-sm">
																<div class="input-group-prepend">
																	<span class="input-group-text" id="inputGroup-sizing-sm" style="background-color: #25d366; color: #fff;"><i class="fab fa-whatsapp"></i></span>
																</div>
																<?php
																	$waGrup = "";
																	if (isset($kegiatan_options["wa_grup"]) && !empty($kegiatan_options["wa_grup"])) {
																		$waGrup = $kegiatan_options["wa_grup"];
																	}
																?>
																<input type="text" class="form-control" name="option[wa_grup]" value="<?php print $waGrup; ?>" />
															</div>
														</div>

														<label>Link Telegram Grup <?php print $kom->name;?></label>
														<div class="form-group">
															<div class="input-group input-group-sm">
																<div class="input-group-prepend">
																	<span class="input-group-text" id="inputGroup-sizing-sm" style="background-color: #0088cc; color: #fff;"><i class="fab fa-telegram-plane"></i></span>
																</div>
																<?php
																	$teleGrup = "";
																	if (isset($kegiatan_options["tele_grup"]) && !empty($kegiatan_options["tele_grup"])) {
																		$teleGrup = $kegiatan_options["tele_grup"];
																	}
																?>
																<input type="text" class="form-control" name="option[tele_grup]" value="<?php print $teleGrup; ?>" />
															</div>
															<small>Link akan ditampilkan setelah pendaftaran berhasil</small>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="dh-<?php print $kom->code;?>">
												<div class="row">
													<div class="col-md-4">
														<?php
															if ($kegiatan["tipe_kegiatan"] == "Daring") {
																$start_date = new DateTime($kegiatan["tgl_mulai_kegiatan"]);
																$end_date = new DateTime($kegiatan["tgl_selesai_kegiatan"]);
																$end_date->setTime(0,0,1);

																// Step 2: Defining the Date Interval
																$interval = new DateInterval('P1D');

																// Step 3: Creating the Date Range
																$date_range = new DatePeriod($start_date, $interval, $end_date);
																
																$date_sign = array();
																foreach($date_range as $date) {
																	$dateFormated = $date->format('Y-m-d');
																	$date_sign[] = $dateFormated;
																}

																if (!empty($kegiatan["detail_tgl_kegiatan"])) {
																	$date_sign = $kegiatan["detail_tgl_kegiatan"];
																}

																foreach ($date_sign as $tglDetail) {
																	$strDate = strtotime($tglDetail);
																	$checked = "";
																	$readOnly = "link-off";
																	$disabled = "disabled";
																	$linkDaftarHadir = base_url("daftar_hadir_".$kom->code."/".$kegiatan["id"]."/".$strDate);

																	if (isset($kegiatan_options["daftar_hadir"][$strDate]["link_on"]) && !empty($kegiatan_options["daftar_hadir"][$strDate]["link_on"])) {
																		$checked = 'checked="checked"';
																		$readOnly = "";
																		$disabled = "";
																	}
																	
																	if (isset($kegiatan_options["daftar_hadir"][$strDate]["link"]["custom_bitlinks"]) && !empty($kegiatan_options["daftar_hadir"][$strDate]["link"]["custom_bitlinks"])) {
																		$linkDaftarHadir = $kegiatan_options["daftar_hadir"][$strDate]["link"]["custom_bitlinks"];
																	}
																?>
																		<div class="form-group form-group-switch group-switch-<?php print $strDate; ?> <?php print $readOnly; ?>">
																			<label class="label-daftar-hadir">Daftar Hadir (<?php print $this->utility->formatShortDateIndo($tglDetail); ?>)</label>
																			<div class="switch switch-dh d-inline">
																				<input type="checkbox" <?php print $checked; ?> class="bitly-dh" data-kegiatan="<?php print $kegiatan["id"]; ?>" data-type="<?php print $komponen->code; ?>" data-date="<?php print $strDate; ?>" name="bitly_daftar_hadir[<?php print date("d-m-Y", $strDate); ?>]" id="switchDH-<?php print $strDate; ?>" value="1" />
																				<label for="switchDH-<?php print $strDate; ?>" class="cr" style="top:10px;" title="Aktifkan Registrasi"></label>
																			</div>

																			<div class="row">
																				<div class="col-md-10">
																				<input type="text" class="form-control form-link-dh form-link-dh-<?php print $strDate; ?>" readonly value="<?php print $linkDaftarHadir; ?>" />
																				</div>
																				<div class="col-md-2 pl-0">
																					<button class="btn btn-edit-dh-bitly" <?php print $disabled; ?> type="button" data-tanggal="<?php print $strDate; ?>" title="Edit Bitly Link"><i class="fas fa-edit"></i></button>
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
											<div class="tab-pane" id="spd-<?php print $kom->code;?>">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label>Nama Pejabat Tujuan Perjalanan Dinas</label>
															<?php
																$spdNama = "";
																if (isset($kegiatan_options["spd_nama"]) && !empty($kegiatan_options["spd_nama"])) {
																	$spdNama = $kegiatan_options["spd_nama"];
																}
															?>
															<input type="text" class="form-control" name="option[spd_nama]" value="<?php print $spdNama; ?>" />
														</div>
														<div class="form-group">
															<label>NIP Pejabat Tujuan Perjalanan Dinas</label>
															<?php
																$spdNip = "";
																if (isset($kegiatan_options["spd_nip"]) && !empty($kegiatan_options["spd_nip"])) {
																	$spdNip = $kegiatan_options["spd_nip"];
																}
															?>
															<input type="text" class="form-control" name="option[spd_nip]" value="<?php print $spdNip; ?>" />
														</div>
														<div class="form-group">
															<label>Jabatan Pejabat Tujuan Perjalanan Dinas</label>
															<?php
																$spdJabatan = "";
																if (isset($kegiatan_options["spd_jabatan"]) && !empty($kegiatan_options["spd_jabatan"])) {
																	$spdJabatan = $kegiatan_options["spd_jabatan"];
																}
															?>
															<input type="text" class="form-control" name="option[spd_jabatan]" value="<?php print $spdJabatan; ?>" />
														</div>
														<div class="form-group">
															<label>Nama Unit Kerja Pejabat Tujuan Perjalanan Dinas</label>
															<?php
																$spdSatker = "";
																if (isset($kegiatan_options["spd_satker"]) && !empty($kegiatan_options["spd_satker"])) {
																	$spdSatker = $kegiatan_options["spd_satker"];
																}
															?>
															<input type="text" class="form-control" name="option[spd_satker]" value="<?php print $spdSatker; ?>" />
														</div>
													</div>
													<div class="col-md-6">
														<label>Link SPD</label>
														<div class="form-group">
															<?php
																$spdLink = base_url("/download/sppd_".$kom->code."/".$kegiatan["id"]);
															?>
															<input type="text" class="form-control input-edit-spd-link" value="<?php print $spdLink; ?>" readonly /> <!--<button type="button" class="btn btn-info btn-edit-spd-link" title="Edit SPD Link"><i class="fas fa-edit"></i></button>--><br />
															<small>Link untuk download SPD apabila peserta perlu membawa SPD</small>
														</div>
														
														<div class="alert alert-info">
															<div><label>Informasi Data Kasubbag Umum <br /><?php echo $satker["upt"]; ?></label></div>
															<div class="form-group mb-1">
																<div><?php print $biodata_kasubag['nama']; ?></div>
															</div>
															<div class="form-group">
																<div>NIP <?php print $biodata_kasubag['nip']; ?></div>
															</div>
															<div class="form-group mb-1">
																<div>Kasubbag Umum</div>
															</div>
															<div class="form-group mb-0">
																<div><?php echo $satker["upt"]; ?></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="sertifikat-<?php print $kom->code;?>">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group" style="width: 70%;">
															<label>Template Sertifikat Peserta</label>
															<?php
																$sertifikat = "0";
																if (isset($kegiatan_options["sertificate"]) && !empty($kegiatan_options["sertificate"])) {
																	$sertifikat = $kegiatan_options["sertificate"];
																}
															?>
															<select id="select-serticate" class="form-control" name="option[sertificate]" data-selected-sertificate="<?php print $sertifikat; ?>"></select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6" style="margin-top: 15px;">
										<button type="submit" class="btn btn-info">Simpan</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				<?php
				}
			}
		}
	?>
</div>
<style type="text/css">
	.nav-pills-keg .nav-item {margin-bottom: 10px;}
</style>
<div style="display: block;height: 15px;">&nbsp;</div>