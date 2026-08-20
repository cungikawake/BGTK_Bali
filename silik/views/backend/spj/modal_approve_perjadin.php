<style type="text/css">
	.checkbox input[type=checkbox] + .cr:before {
		margin-right: 0;
	}
	.input-group .input-group-text {
		padding-left: 10px;
		padding-right: 10px;
		background: #f4f7fa;
		border-left: none;
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
	}
	.text-dpr {
		float: right;
		font-size: 11px;
		text-align: center;
		display: inline-block;
		margin-right: 7px;
	}
	label {
		display: block;
	}
	.icon-keterangan {
		display: inline-block;
		margin-top: 5px;
	}
</style>
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Approve Laporan Perjadin</h5>
		</div>
		
		<form action="" method="post" class="form-approve-perjadin">
			<input type="hidden" value="<?php print $id; ?>" name="id" />
			<input type="hidden" name="status" value="3" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Rincian Tugas</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Nama Petugas</label>
									<p><?php print $nama; ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Golongan, Pangkat</label>
									<p><?php print $golongan.", ".$pangkat; ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Jabatan</label>
									<p><?php print $jabatan; ?></p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0" />
						<div class="form-group">
							<label>Keterangan Tugas</label>
							<p>
								<?php
									if (!empty($penugasan["kegiatan_id"])) {
										print "".ucfirst($penugasan["tipe"])." ";
									}
								?>
								<?php print $penugasan["nama"]; ?>
							</p>
						</div>
						<hr class="mb-3 mt-0" />
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Surat Tugas</label>
									<p><a href="<?php print base_url("/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$surat_tugas); ?>" target="_blank"><i class="fas fa-file-pdf" style="color: #994442;"></i> <?php print $surat_tugas; ?></a></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Nomor Surat Tugas</label>
									<p><?php print $penugasan["nomor_surat"]; ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tgl Surat Tugas</label>
									<p><?php print $this->utility->formatDateIndo($penugasan["tgl_surat"]); ?></p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0" />
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Tgl Mulai Tugas</label>
									<p><?php print $this->utility->formatDateIndo($tgl_mulai_tugas); ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tgl Selesai Tugas</label>
									<p><?php print $this->utility->formatDateIndo($tgl_selesai_tugas); ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Lama Tugas</label>
									<p><?php print $this->utility->lama_tugas($tgl_mulai_tugas, $tgl_selesai_tugas); ?> hari</p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-0">
									<label>Tempat Tujuan</label>
									<p class="mb-0"><?php print $tempat_tujuan." (".$provinsi_tujuan.", ".$kab_tujuan.")"; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="card">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Laporan Perjalanan Dinas</h5>
					</div>
					<div class="card-body">
						<div class="form-group mb-0">
							<div class="iframe-laporan">
								<?php
									$laporanLink = "/admin/user/preview_laporan_perjadin/".$id;
									
									if ($status >= "3" && $status <= "6") {
										$laporanLink = "/admin/user/laporan_perjadin/".$id;
									}
								?>
								<iframe src="<?php print base_url($laporanLink); ?>?v=<?php print rand(); ?>"></iframe>
							</div>
						</div>
					</div>
				</div>
				
				<?php
					$buktiPath = APPPATH . "../assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$id."/bukti_pengeluaran.pdf";
				
					if (file_exists($buktiPath)) {
				?>
						<div class="card">
							<div class="card-header" style="padding: 10px 25px;">
								<h5>Bukti Pengeluaran</h5>
							</div>
							<div class="card-body">
								<div class="form-group mb-0">
									<div class="iframe-laporan">
										<?php
											$buktiPengeluaran = "/assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$id."/bukti_pengeluaran.pdf";
										?>
										<iframe src="<?php print base_url($buktiPengeluaran); ?>?v=<?php print rand(); ?>"></iframe>
									</div>
								</div>
							</div>
						</div>
				<?php
					}
				?>

				<div class="card mb-0">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Pertanggungjawaban</h5>
					</div>
					<div class="card-body">
					    <input type="hidden" name="dipa_balai" value="1" />
						<!--<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Sumber Dana</label>
									
									<?php
										$disbaleDipa = "";
										$selectedDipa1 = "";
										$selectedDipa2 = "";
									
										if ($status >= "3" && $status <= "6") {
											$disbaleDipa = 'disabled="disabled"';
											
											if (isset($dipa_balai) && $dipa_balai) {
												$selectedDipa1 = 'selected="selected"';
												$selectedDipa2 = "";
											}
											else {
												$selectedDipa1 = '';
												$selectedDipa2 = 'selected="selected"';
											}
										}
									?>
									
									<select name="dipa_balai" class="form-control select2 approve-dipa" <?php print $disbaleDipa; ?></selec>>
										<option value="1" <?php print $selectedDipa1; ?>>Dipa Balai</option>
										<option value="0" <?php print $selectedDipa2; ?>>Dipa Penyelenggara</option>
									</select>
								</div>
							</div>
						</div>-->
						
						<div class="use-dipa-balai">
							<?php
								$nominal = 0;
								$spjItem = array();

								if (!empty($spj_item)) {
									foreach ($spj_item as $item) {
										if ($item["penugasan_item_id"] == $id) {
											$nominal += $item["pesawat_berangkat"];
											$nominal += $item["pesawat_pulang"];
											$nominal += $item["taksi_berangkat"];
											$nominal += $item["taksi_pulang"];
											$nominal += $item["transport"];
											$nominal += $item["transport_lainnya"];
											$nominal += $item["uang_harian"];
											$nominal += $item["penginapan"];
											$nominal += $item["honor"];
											$spjItem = $item;
										}
									}
								}
							
								$disableSubmit = true;
							
								if (isset($spj["dipa"]["program"]) && !empty($spj["dipa"]["program"])) {
							?>
									<div class="form-group">
										<label>Nama SPJ Keuangan</label>
										<p><?php print $spj["nama"]; ?></p>
										<input type="hidden" class="possible-use-dipa-balai" value="1" />
									</div>
									<div class="form-group">
										<label>Mata Anggaran Kegiatan (MAK)</label>
										<p><?php print $spj["dipa"]["program"]." . ".$spj["dipa"]["kegiatan"].".".$spj["dipa"]["kro"].".".$spj["dipa"]["ro"].".".$spj["dipa"]["komponen"]." . ".$spj["dipa"]["sub_komponen"]." . ".$spj["dipa"]["akun_transport"]; ?></p>
									</div>
							
									<?php
										// SEMENTARA
										$transport = 0;
										$transportLainnya = 0;
										$uangHarian = 0;
										$diterima = 0;
										
									
										if (!empty($spjItem)) {
											$lamaTugas = $this->utility->lama_tugas($spjItem["tgl_mulai_tugas"], $spjItem["tgl_selesai_tugas"]);
											$transport = $spjItem["transport"];
											$transportLainnya = $spjItem["transport_lainnya"];
											$uangHarian = $spjItem["uang_harian"]*$lamaTugas;
											$diterima = $transport + $transportLainnya + $uangHarian;
											
										}
									?>
							
								<?php
									//if (isset($spjItem["provinsi_asal"]) && isset($spjItem["provinsi_tujuan"]) && $spjItem["provinsi_asal"] == $spjItem["provinsi_tujuan"]) {
										
										$disableSubmit = false;
										
										$showTiket = false;
										$showTransport = true;
										$showUangHarian = true;

										if (isset($spjItem["provinsi_asal"]) && isset($spjItem["provinsi_tujuan"]) && $spjItem["provinsi_asal"] != $spjItem["provinsi_tujuan"]) {
											$showTiket = true;
											$showTransport = false;
										}
										
										// RIncian Biaya
										$lamaTugas = 0;
										$tiketBerangkat = 0;
										$tiketPulang = 0;
										$taksiAsal = 0;
										$taksiTujuan = 0;
										$transport = 0;
										$transportLainnya = 0;
										$uangHarian = 0;
										$totalUangHarian = 0;
										$penginapan = 0;
										$totalPenginapan = 0;
										$diterima = 0;
										$keteranganTransport = "";
										$keteranganTransLainnya = "";
										$keteranganPenginapan = "";
										$dprTransport = 0;
										$dprTransLainnya = 0;
										$dprPenginapan = 0;
									
										if (!empty($spjItem)) {
											$lamaTugas = $this->utility->lama_tugas($spjItem["tgl_mulai_tugas"], $spjItem["tgl_selesai_tugas"]);
											
											$tiketBerangkat = $spjItem["pesawat_berangkat"];
											$tiketPulang = $spjItem["pesawat_pulang"];
											$taksiAsal = $spjItem["taksi_berangkat"];
											$taksiTujuan = $spjItem["taksi_pulang"];
											$transport = $spjItem["transport"];
											$transportLainnya = $spjItem["transport_lainnya"];
											$uangHarian = $spjItem["uang_harian"];
											$totalUangHarian = $spjItem["uang_harian"]*$lamaTugas;
											$penginapan = $spjItem["penginapan"];
											$totalPenginapan = $spjItem["penginapan"]*($lamaTugas-1);
											$diterima = $transport + $transportLainnya + $totalUangHarian + $totalPenginapan;
											
											$keteranganTransport = $spjItem["keterangan_transport"];
											$keteranganTransLainnya = $spjItem["keterangan_transport_lainnya"];
											$keteranganPenginapan = $spjItem["keterangan_penginapan"];
											
											$dprTaksiAsal = $spjItem["dpr_taksi_berangkat"];
											$dprTaksiPulang = $spjItem["dpr_taksi_pulang"];
											$dprTransport = $spjItem["dpr_transport"];
											$dprTransLainnya = $spjItem["dpr_transport_lainnya"];
											$dprPenginapan = $spjItem["dpr_penginapan"];
										}
									?>
										<div class="row">
											<div class="col-md-12">
												<label>Rincian Biaya Perjalanan Dinas</label>
											</div>

											<?php
												$provinsiAsal = $spjItem["provinsi_asal"];
												$provinsiTujuan = $spjItem["provinsi_tujuan"];

												if ($spjItem["provinsi_asal"] == $spjItem["provinsi_tujuan"]) {
													$provinsiAsal = $spjItem["kab_asal"];
													$provinsiTujuan = $spjItem["kab_tujuan"];
												}
											?>
											
											<div class="col-md-9">
												<div style="overflow: auto;">
													<table class="table table-condensed table-hover table-striped" style="border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd;">
														<tbody>
															<tr>
																<th>No</th>
																<th>Nama Komponen</th>
																<th>Detail</th>
																<th>Nominal</th>
															</tr>
															<tr class="row-cal row-tiket-berangkat">
																<td class="row-cal-no" align="center">1</td>
																<td>Tiket Berangkat</td>
																<td><?php print $provinsiAsal; ?> - <?php print $provinsiTujuan; ?></td>
																<td><span class="apr-total-tiket-berangkat"><?php print $this->utility->format_money($tiketBerangkat); ?></span></td>
															</tr>
															<tr class="row-cal row-tiket-pulang">
																<td class="row-cal-no" align="center">2</td>
																<td>Tiket Pulang</td>
																<td><?php print $provinsiTujuan; ?> - <?php print $provinsiAsal; ?></td>
																<td><span class="apr-total-tiket-pulang"><?php print $this->utility->format_money($tiketPulang); ?></span></td>
															</tr>
															<tr class="row-cal row-taksi-asal">
																<td class="row-cal-no" align="center">3</td>
																<td>Taksi Asal</td>
																<td><?php print $provinsiAsal; ?></td>
																<td><span class="apr-total-taksi-asal"><?php print $this->utility->format_money($taksiAsal); ?></span></td>
															</tr>
															<tr class="row-cal row-taksi-tujuan">
																<td class="row-cal-no" align="center">4</td>
																<td>Taksi Tujuan</td>
																<td><?php print $provinsiTujuan; ?></td>
																<td><span class="apr-total-taksi-tujuan"><?php print $this->utility->format_money($taksiTujuan); ?></span></td>
															</tr>
															<tr class="row-cal row-transport">
																<td class="row-cal-no" align="center">5</td>
																<td>Transport PP</td>
																<td><?php print $spjItem["kab_asal"]; ?> - <?php print $spjItem["kab_tujuan"]; ?></td>
																<td><span class="apr-total-transport"><?php print $this->utility->format_money($transport); ?></span></td>
															</tr>
															<tr class="row-cal row-transport-lainnya">
																<td class="row-cal-no" align="center">6</td>
																<td>Transport Lainnya</td>
																<td class="apr-keterangan-transport-lainnya"><?php print $keteranganTransLainnya; ?></td>
																<td><span class="apr-total-transport-lainnya"><?php print $this->utility->format_money($transportLainnya); ?></span></td>
															</tr>
															<tr class="row-cal row-total-uang-harian">
																<td class="row-cal-no" align="center">7</td>
																<td>Uang Harian</td>
																<td><span class="apr-uang-harian"><?php print $this->utility->format_money($uangHarian); ?></span> x <?php print $lamaTugas; ?> hari</td>
																<td><span class="apr-total-uang-harian"><?php print $this->utility->format_money($totalUangHarian); ?></span></td>
															</tr>
															<tr class="row-cal row-total-penginapan">
																<td class="row-cal-no" align="center">8</td>
																<td>Penginapan</td>
																<td><span class="apr-penginapan"><?php print $this->utility->format_money($penginapan); ?></span> x <?php print $lamaTugas - 1; ?> mlm</td>
																<td><span class="apr-total-penginapan"><?php print $this->utility->format_money($totalPenginapan); ?></span></td>
															</tr>
															<tr>
																<th>&nbsp;</th>
																<th>Jumlah Diterima</th>
																<th>&nbsp;</th>
																<th><span class="apr-total-diterima"><?php print $this->utility->format_money($diterima); ?></span></th>
															</tr>
														</tbody>
													</table>
												</div>
											</div>	
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Tiket Berangkat</label>
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-pesawat-berangkat" name="pesawat_berangkat" value="<?php print $tiketBerangkat; ?>" />
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Tiket Pulang</label>
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-pesawat-pulang" name="pesawat_pulang" value="<?php print $tiketPulang; ?>" />
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<label>Taksi Asal <span class="text-dpr">DPR?</span></label>
														<div class="input-group">
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-taksi-asal" name="taksi_berangkat" value="<?php print $taksiAsal; ?>" />
															
															<div class="input-group-text">
																<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																	<input type="hidden" name="dpr_taksi_berangkat" value="0" />

																	<input type="checkbox" name="dpr_taksi_berangkat" id="checkbox-item-dpr_taksi_berangkat" value="1" <?php if ($dprTaksiAsal == 1) { print 'checked="checked"'; } ?> />
																	<label for="checkbox-item-dpr_taksi_berangkat" class="cr"></label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<label>Taksi Tujuan <span class="text-dpr">DPR?</span></label>
														<div class="input-group">
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-taksi_pulang" name="taksi_pulang" value="<?php print $taksiTujuan; ?>" />
															
															<div class="input-group-text">
																<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																	<input type="hidden" name="dpr_taksi_pulang" value="0" />

																	<input type="checkbox" name="dpr_taksi_pulang" id="checkbox-item-dpr_taksi_pulang" value="1" <?php if ($dprTaksiPulang == 1) { print 'checked="checked"'; } ?> />
																	<label for="checkbox-item-dpr_taksi_pulang" title="Masuk DPR?" class="cr"></label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<label>Transport PP <span class="text-dpr">DPR?</span></label>
														<div class="input-group">
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-transport" name="transport" value="<?php print $transport; ?>" />
															
															<div class="input-group-text">
																<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																	<input type="hidden" name="dpr_transport" value="0" />

																	<input type="checkbox" name="dpr_transport" id="checkbox-item-dpr_transport" value="1" <?php if ($dprTransport == 1) { print 'checked="checked"'; } ?> />
																	<label for="checkbox-item-dpr_transport" class="cr"></label>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group form-group-sm">
															<a href="javascript:;" title="Keterangan Transport" class="show-ket-trans icon-keterangan"><i class="fas fa-align-left" style="color: #3f4d67;"></i> </a>
														</div>
													</div>
												</div>
												
												<?php
													$displayKetTrans = "display:none;";
										
													if (!empty($keteranganTransport)) {
														$displayKetTrans = "display:block;";
													}
												?>
												
												<div class="row row-keterangan-trans" style="<?php print $displayKetTrans; ?>">
													<div class="col-md-12">
														<div class="form-group">
															<label>Keterangan Transport</label>
															<textarea class="form-control" name="keterangan_transport" rows="2"><?php print $keteranganTransport; ?></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<label>Transport Lainnya <span class="text-dpr">DPR?</span></label>
														<div class="input-group">
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-transport-lainnya" name="transport_lainnya" value="<?php print $transportLainnya; ?>" />
															
															<div class="input-group-text">
																<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																	<input type="hidden" name="dpr_transport_lainnya" value="0" />

																	<input type="checkbox" name="dpr_transport_lainnya" id="checkbox-item-dpr_transport_lainnya" value="1" <?php if ($dprTransLainnya == 1) { print 'checked="checked"'; } ?> />
																	<label for="checkbox-item-dpr_transport_lainnya" class="cr"></label>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group form-group-sm">
															<a href="javascript:;" title="Keterangan Trans. Lainnya" class="show-ket-trans-lainnya icon-keterangan"><i class="fas fa-align-left" style="color: #3f4d67;"></i> </a>
														</div>
													</div>
												</div>
												
												<?php
													$displayKetTransLainnya = "display:none;";
										
													if (!empty($keteranganTransLainnya)) {
														$displayKetTransLainnya = "display:block;";
													}
												?>
												
												<div class="row row-keterangan-trans-lainnya" style="<?php print $displayKetTransLainnya; ?>">
													<div class="col-md-12">
														<div class="form-group">
															<label>Keterangan Trans. Lainnya</label>
															<textarea class="form-control keterangan_trans_lainnya" name="keterangan_transport_lainnya" rows="2"><?php print $keteranganTransLainnya; ?></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Uang Harian / Hari</label>
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-uang-harian" name="uang_harian" value="<?php print $uangHarian; ?>" />
															<input type="hidden" class="cal-apr-lama-tugas" value="<?php print $lamaTugas; ?>" />
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<label>Penginapan / Mlm <span class="text-dpr">DPR?</span></label>
														<div class="input-group">
															<input type="text" class="form-control autoNumeric cal-apr-perjadin cal-apr-penginapan" name="penginapan" value="<?php print $penginapan; ?>" />
															
															<div class="input-group-text">
																<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
																	<input type="hidden" name="dpr_penginapan" value="0" />

																	<input type="checkbox" name="dpr_penginapan" id="checkbox-item-dpr_penginapan" value="1" <?php if ($dprPenginapan == 1) { print 'checked="checked"'; } ?> />
																	<label for="checkbox-item-dpr_penginapan" class="cr"></label>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group form-group-sm">
															<a href="javascript:;" class="show-ket-penginapan icon-keterangan" title="Keterangan Penginapan"><i class="fas fa-align-left" style="color: #3f4d67;"></i> </a>
														</div>
													</div>
												</div>
												
												<?php
													$displayKetPenginapan = "display:none;";
										
													if (!empty($keteranganPenginapan)) {
														$displayKetPenginapan = "display:block;";
													}
												?>
												
												<div class="row row-keterangan-penginapan" style="<?php print $displayKetPenginapan; ?>">
													<div class="col-md-12">
														<div class="form-group">
															<label>Keterangan Penginapan</label>
															<textarea class="form-control" name="keterangan_penginapan" rows="2"><?php print $keteranganPenginapan; ?></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
														<?php 
															$tgl_kuitansi = date('d/m/Y', strtotime("next thursday"));
														?>
														<label>Tanggal Pembayaran</label>
														<input type="text" name="tgl_kuitansi" class="form-control datepicker" value="<?php print $tgl_kuitansi; ?>" />
														</div>
													</div>
												</div>
											</div>
										</div>
							<?php
									/*}
									else if (isset($spjItem["provinsi_asal"]) && isset($spjItem["provinsi_tujuan"]) && $spjItem["provinsi_asal"] != $spjItem["provinsi_tujuan"] && $nominal > 0) {
									    $disableSubmit = false; 
									}
									else {
							?>
										<div class="alert alert-danger">
											<p>Tim keuangan belum membuatkan SPJ Keuangan untuk penugasan ini. Apabila penugasan ini akan dibayarkan dengan <b>Dipa Balai</b>, mohon intruksikan tim keuangan untuk membuat SPJ Keuangan terlebih dulu supaya Mata Anggaran Kegiatan (MAK) untuk penugasan ini ditetapkan.</p>
										</div>
										<input type="hidden" class="possible-use-dipa-balai" value="0" />
							<?php
									}*/
							?>		
									
							<?php		
								}
								else {
							?>
									<div class="alert alert-danger">
										<p>Tim keuangan belum membuatkan SPJ Keuangan untuk penugasan ini. Apabila penugasan ini akan dibayarkan dengan <b>Dipa Balai</b>, mohon intruksikan tim keuangan untuk membuat SPJ Keuangan terlebih dulu supaya Mata Anggaran Kegiatan (MAK) untuk penugasan ini ditetapkan.</p>
									</div>
									<input type="hidden" class="possible-use-dipa-balai" value="0" />
							<?php
								}
							?>
						</div>
						
						<div class="use-dipa-penyelenggara" style="display: none;">
							<div class="alert alert-info">
								<p>Apabila penugasan ini akan dibayarkan dengan <b>Dipa Penyelenggara</b>, maka tim keuangan tidak perlu membuat SPJ Keuangan untuk penugasan ini.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php
					if ($status <= "2") {
				?>
				<button type="submit" class="btn btn-primary mb-0 approve-perjadin" <?php print $disableSubmit ? "disabled":""; ?>>Setuju</button>
				<button type="button" class="btn btn-danger tolak-perjadin" data-id="<?php print $id; ?>">Tolak</button>
				<?php
					}
				?>
				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('.cal-apr-pesawat-berangkat').trigger("change");
	});
</script>