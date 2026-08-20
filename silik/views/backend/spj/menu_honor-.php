<div id="keg-more-opt-<?php print $unsur; ?>" class="collapse">
	<input type="hidden" class="unsur-spj" value="<?php print $unsur; ?>" />
	<div class="keg-opt-form">
		<form class="form-spj-option" method="post">
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="javascript:;" aria-controls="dasar-pembayaran">Dasar Pembayaran</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-spby">SPBy</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-spj">Kuitansi</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-transport">Transport</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-uang-harian">Uang Harian</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-honor">Honor</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="javascript:;" aria-controls="rincian-spm">SPM</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tab-content">
				<div class="tab-pane active show" id="dasar-pembayaran">
					<div class="row">
						<div class="col-md-5">
							<label>Detail Anggaran</label>
							<hr />

							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Program</label>
										<input type="text" name="dipa_program" placeholder="<?php print $placeHolder["dipa_program"]; ?>" class="form-control" value="<?php print (isset($options["dipa_program"])) ? $options["dipa_program"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Kegiatan</label>
										<input type="text" name="dipa_kegiatan" placeholder="<?php print $placeHolder["dipa_kegiatan"]; ?>" class="form-control" value="<?php print (isset($options["dipa_kegiatan"])) ? $options["dipa_kegiatan"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>KRO</label>
										<input type="text" name="dipa_kro" placeholder="<?php print $placeHolder["dipa_kro"]; ?>" class="form-control" value="<?php print (isset($options["dipa_kro"])) ? $options["dipa_kro"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>RO</label>
										<input type="text" name="dipa_ro" placeholder="<?php print $placeHolder["dipa_ro"]; ?>" class="form-control" value="<?php print (isset($options["dipa_ro"])) ? $options["dipa_ro"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Komponen</label>
										<input type="text" name="dipa_komponen" placeholder="<?php print $placeHolder["dipa_komponen"]; ?>" class="form-control" value="<?php print (isset($options["dipa_komponen"])) ? $options["dipa_komponen"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Sub Kom.</label>
										<input type="text" name="dipa_sub_komponen" placeholder="<?php print $placeHolder["dipa_sub_komponen"]; ?>" class="form-control" value="<?php print (isset($options["dipa_sub_komponen"])) ? $options["dipa_sub_komponen"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Akun Trans.</label>
										<input type="text" name="dipa_akun_transport" placeholder="<?php print $placeHolder["dipa_akun_transport"]; ?>" class="form-control" value="<?php print (isset($options["dipa_akun_transport"])) ? $options["dipa_akun_transport"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label>Akun Honor</label>
										<input type="text" name="dipa_akun_honor" placeholder="<?php print $placeHolder["dipa_akun_honor"]; ?>" class="form-control" value="<?php print (isset($options["dipa_akun_honor"])) ? $options["dipa_akun_honor"] : ""; ?>" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1">
							&nbsp;
						</div>
						<div class="col-md-5">
							<label>Detail Surat (SK, Surat Tugas atau Undangan)</label>
							<hr />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Nomor Surat</label>
										<input type="text" name="nomor_surat" class="form-control" value="<?php print (isset($options["nomor_surat"])) ? $options["nomor_surat"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Tanggal Surat</label>
										<input type="text" name="tgl_surat" class="form-control datepicker" value="<?php print (isset($options["tgl_surat"])) ? $options["tgl_surat"] : ""; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="rincian-spj">
					<div class="row">
						<div class="col-md-5">
							<label>Kuitansi Transport</label>
							<hr />
							<div class="form-group form-group-sm">
								<label>Deskripsi</label>
								<textarea class="form-control" placeholder="<?php print $placeHolder["deskripsi_transport"]; ?>" rows="5" name="deskripsi_kuitansi" ><?php print (isset($options["deskripsi_kuitansi"])) ? $options["deskripsi_kuitansi"] : ""; ?></textarea>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Kab/Kota</label>
										<select name="kab_kuitansi" class="form-control select2">
											<?php
												$kab_spj = isset($options["kab_kuitansi"]) && !empty($options["kab_kuitansi"]) ? $options["kab_kuitansi"] : $kegiatan["kab_tempat_kegiatan"];

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
										<?php
											$tgl_kuitansi = isset($options["tgl_kuitansi"]) && !empty($options["tgl_kuitansi"]) ? $options["tgl_kuitansi"] : date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
										?>
										<input type="text" name="tgl_kuitansi" required class="form-control datepicker" value="<?php print $tgl_kuitansi; ?>" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<label>Kuitansi Honor</label>
							<hr />
							<div class="form-group form-group-sm">
								<label>Deskripsi</label>
								<textarea class="form-control" placeholder="<?php print $placeHolder["deskripsi_honor"]; ?>" rows="5" name="deskripsi_honor" ><?php print (isset($options["deskripsi_honor"])) ? $options["deskripsi_honor"] : ""; ?></textarea>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Kab/Kota</label>
										<select name="kab_honor" class="form-control select2">
											<?php
												$kab_spj = isset($options["kab_honor"]) && !empty($options["kab_honor"]) ? $options["kab_honor"] : $kegiatan["kab_tempat_kegiatan"];

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
										<?php
											$tgl_honor = isset($options["tgl_honor"]) && !empty($options["tgl_honor"]) ? $options["tgl_honor"] : date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
										?>
										<input type="text" name="tgl_honor" required class="form-control datepicker" value="<?php print $tgl_honor; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="rincian-transport">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5">
									<label>Transport</label>
									<hr />
									<div class="row">
									<?php
										$areas = $this->config->item("transport_area");

										foreach ($areas as $area) {
											if ($area == "Lainnya") {
												continue;
											}

											$area_name = "transport_".strtolower($area);
									?>
											<div class="col-md-4">
												<div class="form-group form-group-sm">
													<label><?php print $area; ?></label>
													<input type="text" name="<?php print $area_name; ?>" class="form-control autoNumeric" value="<?php print (isset($options[$area_name])) ? $options[$area_name] : ""; ?>" />
												</div>
											</div>
									<?php
										}
									?>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group form-group-sm">
												<label>Keterangan Transport</label>
												<textarea class="form-control" rows="4" name="keterangan_transport" ><?php print (isset($options["keterangan_transport"])) ? $options["keterangan_transport"] : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									&nbsp;
								</div>
								<div class="col-md-5">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group form-group-sm">
												<label>Transport Lainnya</label>
												<input type="text" name="transport_lainnya" class="form-control autoNumeric" value="<?php print (isset($options["transport_lainnya"])) ? $options["transport_lainnya"] : ""; ?>" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group form-group-sm">
												<label>Keterangan Transport Lainnya</label>
												<textarea class="form-control" rows="4" name="keterangan_transport_lainnya"><?php print (isset($options["keterangan_transport_lainnya"])) ? $options["keterangan_transport_lainnya"] : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="rincian-uang-harian">
					<div class="row">
						<div class="col-md-5">

							<div class="row">
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label>Uang Harian</label>
										<input type="text" name="uang_harian" class="form-control autoNumeric" value="<?php print (isset($options["uang_harian"])) ? $options["uang_harian"] : ""; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Keterangan Uang Harian</label>
										<textarea class="form-control" rows="4" name="keterangan_uang_harian" ><?php print (isset($options["keterangan_uang_harian"])) ? $options["keterangan_uang_harian"] : ""; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="rincian-honor">
					<div class="row">
						<div class="col-md-5">

							<div class="row">
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label>Honor/Vol</label>
										<input type="text" name="honor" class="form-control autoNumeric" value="<?php print (isset($options["honor"])) ? $options["honor"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group form-group-sm">
										<label>Vol</label>
										<input type="text" name="vol_honor" class="form-control" value="<?php print (isset($options["vol_honor"])) ? $options["vol_honor"] : "1"; ?>" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label>Satuan</label>
										<input type="text" name="satuan_honor" class="form-control" value="<?php print (isset($options["satuan_honor"])) ? $options["satuan_honor"] : "jam"; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Keterangan Honor</label>
										<textarea class="form-control" rows="4" name="keterangan_honor" ><?php print (isset($options["keterangan_honor"])) ? $options["keterangan_honor"] : ""; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="rincian-spby">
					<div class="row">
						<div class="col-md-5">
							<label>SPBy Transport</label>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Penerima</label>
										<select id="select_spby" data-unsur="narasumber" class="form-control" name="penerima_spby" data-selected="<?php print (isset($options["penerima_spby"])) ? $options["penerima_spby"] : "0"; ?>"></select>
									</div>
									<div class="form-group form-group-sm">
										<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
											<input type="hidden" name="penerima_spby_dkk" value="0" />

											<?php
												$penerima_spby_dkk_selected = "";
												if (isset($options["penerima_spby_dkk"]) && $options["penerima_spby_dkk"] == "1") {
													$penerima_spby_dkk_selected = 'checked="checked"';
												}
											?>

											<input type="checkbox" name="penerima_spby_dkk" id="checkbox-penerima_spby_dkk" <?php print $penerima_spby_dkk_selected; ?> value="1" />
											<label for="checkbox-penerima_spby_dkk" class="cr">&nbsp;&nbsp;&nbsp; Penerima dkk?</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Deskripsi</label>
										<textarea class="form-control" placeholder="<?php print $placeHolder["deskripsi_transport"]; ?>" rows="5" name="deskripsi_spby" ><?php print (isset($options["deskripsi_spby"])) ? $options["deskripsi_spby"] : ""; ?></textarea>
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
													$bukti_pembelian_spby = isset($options["bukti_pembelian_spby"]) && !empty($options["bukti_pembelian_spby"]) ? $options["bukti_pembelian_spby"] : "Kuitansi";
												?>
												<input type="text" name="bukti_pembelian_spby" class="form-control" value="<?php print $bukti_pembelian_spby; ?>" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Nota/Bukti Penerimaan</label>
												<?php
													$bukti_penerimaan_spby = isset($options["bukti_penerimaan_spby"]) && !empty($options["bukti_penerimaan_spby"]) ? $options["bukti_penerimaan_spby"] : "Daftar Pengeluaran Riil";
												?>
												<input type="text" name="bukti_penerimaan_spby" class="form-control" value="<?php print $bukti_penerimaan_spby; ?>" />
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
												<select name="kab_spby" class="form-control select2">
													<?php
														$kab_spj = isset($options["kab_spby"]) && !empty($options["kab_spby"]) ? $options["kab_spby"] : $kegiatan["kab_tempat_kegiatan"];

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
												<?php
													$tgl_spby = isset($options["tgl_spby"]) && !empty($options["tgl_spby"]) ? $options["tgl_spby"] : date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
												?>
												<input type="text" name="tgl_spby" required class="form-control datepicker" value="<?php print $tgl_spby; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1">&nbsp;</div>
						<div class="col-md-5">
							<label>SPBy Honor</label>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Penerima</label>
										<select id="select_spby_honor" data-unsur="narasumber" class="form-control" name="penerima_spby_honor" data-selected="<?php print (isset($options["penerima_spby_honor"])) ? $options["penerima_spby_honor"] : "0"; ?>"></select>
									</div>
									<div class="form-group form-group-sm">
										<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
											<input type="hidden" name="penerima_spby_honor_dkk" value="0" />

											<?php
												$penerima_spby_honor_dkk_selected = "";
												if (isset($options["penerima_spby_honor_dkk"]) && $options["penerima_spby_honor_dkk"] == "1") {
													$penerima_spby_honor_dkk_selected = 'checked="checked"';
												}
											?>

											<input type="checkbox" name="penerima_spby_honor_dkk" id="checkbox-penerima_spby_honor_dkk" <?php print $penerima_spby_honor_dkk_selected; ?> value="1" />
											<label for="checkbox-penerima_spby_honor_dkk" class="cr">&nbsp;&nbsp;&nbsp; Penerima dkk?</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label>Deskripsi</label>
										<textarea class="form-control" placeholder="<?php print $placeHolder["deskripsi_honor"]; ?>" rows="5" name="deskripsi_spby_honor" ><?php print (isset($options["deskripsi_spby_honor"])) ? $options["deskripsi_spby_honor"] : ""; ?></textarea>
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
													$bukti_pembelian_spby_honor = isset($options["bukti_pembelian_spby_honor"]) && !empty($options["bukti_pembelian_spby_honor"]) ? $options["bukti_pembelian_spby_honor"] : "Kuitansi";
												?>
												<input type="text" name="bukti_pembelian_spby_honor" class="form-control" value="<?php print $bukti_pembelian_spby_honor; ?>" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-sm">
												<label>Nota/Bukti Penerimaan</label>
												<?php
													$bukti_penerimaan_spby_honor = isset($options["bukti_penerimaan_spby_honor"]) && !empty($options["bukti_penerimaan_spby_honor"]) ? $options["bukti_penerimaan_spby_honor"] : "Daftar Pengeluaran Riil";
												?>
												<input type="text" name="bukti_penerimaan_spby_honor" class="form-control" value="<?php print $bukti_penerimaan_spby_honor; ?>" />
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
												<select name="kab_spby_honor" class="form-control select2">
													<?php
														$kab_spby_honor = isset($options["kab_spby_honor"]) && !empty($options["kab_spby_honor"]) ? $options["kab_spby_honor"] : $kegiatan["kab_tempat_kegiatan"];

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
												<?php
													$tgl_spby_honor = isset($options["tgl_spby_honor"]) && !empty($options["tgl_spby_honor"]) ? $options["tgl_spby_honor"] : date("d/m/Y", strtotime($kegiatan["tgl_selesai_kegiatan"]));
												?>
												<input type="text" name="tgl_spby_honor" required class="form-control datepicker" value="<?php print $tgl_spby_honor; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="rincian-spm">
					<div class="row">
						<div class="col-md-5">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Nomor SPM</label>
										<input type="text" name="nomor_spm" placeholder="<?php print $placeHolder["nomor_spm"]; ?>" class="form-control" value="<?php print (isset($options["nomor_spm"])) ? $options["nomor_spm"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Tanggal SPM</label>
										<input type="text" name="tgl_spm" placeholder="<?php print $placeHolder["tgl_spm"]; ?>" class="form-control datepicker" value="<?php print (isset($options["tgl_spm"])) ? $options["tgl_spm"] : ""; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Pagu Transport</label>
										<input type="text" name="pagu_transport" class="form-control autoNumeric" value="<?php print (isset($options["pagu_transport"])) ? $options["pagu_transport"] : ""; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Pagu Uang Harian</label>
										<input type="text" name="pagu_uang_harian" class="form-control autoNumeric" value="<?php print (isset($options["pagu_uang_harian"])) ? $options["pagu_uang_harian"] : ""; ?>" />
									</div>
								</div>
							</div>
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label>Pagu Honor</label>
										<input type="text" name="pagu_honor" class="form-control autoNumeric" value="<?php print (isset($options["pagu_honor"])) ? $options["pagu_honor"] : ""; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-md-12">
					<button type="submit" class="btn btn-danger">Terapkan</button>
				</div>
			</div>
		</form>
	</div>
</div>