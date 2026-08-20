<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">ARSIP [<?php print isset($kode) ? $kode : ""; ?>]</h5>
		</div>

		<style type="text/css">
			.valid-check {
				zoom: 1.4;
			}
		</style>

		<?php
			$disabled = 'disabled="disabled"';
			$readonly = '';

			if (isset($jenis_berkas) && $jenis_berkas == "Laporan Kegiatan" && !empty($kegiatan_id)) {
				$readonly = 'readonly';

				if ($status == "Baru") {
					$disabled = '';
				}
			}
			
			if (empty($status) || $status == "Baru" || $status == "Ditolak Arsiparis" || $status == "Ditolak SPI" || $status == "Ditolak Kepala") {
				$disabled = '';
			}
		?>
		
		<form action="/admin/arsip/save_arsip" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control arsip-id" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card mb-0">
					<div class="card-header"><h5>Rincian Arsip</h5></div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Nama</label><input <?php print $disabled." ".$readonly; ?> type="text" name="nama" class="form-control" required value="<?php print isset($nama) ? $nama : ""; ?>" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label>Program</label>
									<select <?php print $disabled." ".$readonly; ?> name="program" class="form-control select2" required="required">
										<option value=""></option>

										<?php
											$programs = explode("\n", $pengaturan["program"]);
											
											if (!empty($programs)) {
												foreach ($programs as $pro) {
													$foo = explode("|", $pro);
													
													if ($foo[0] == $_SESSION["tahun_anggaran"]) {
														$selected = '';

														if ($foo[1] == $program) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$foo[1].'" '.$selected.'>['.$foo[1].'] '.$foo[2].'</option>';
													}
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Jenis Berkas</label>
									<select <?php print $disabled." ".$readonly; ?> name="jenis_berkas" class="form-control jenis_berkas select2" required="required">
										<option value=""></option>
										<?php
											$berkas = explode("\n", $pengaturan["jenis_berkas"]);
											
											if (!empty($berkas)) {
												foreach ($berkas as $kas) {
													$kas = trim($kas);
													$selected = '';

													if ($kas == $jenis_berkas) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$kas.'" '.$selected.'>'.$kas.'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Keamanan dan Akses</label>
									<select <?php print $disabled." ".$readonly; ?> name="akses" class="form-control select2" required="required">
									<?php
										if (!isset($akses) && $akses == "") {
											$akses = "Biasa";
										}

										$akseses = explode("\n", $pengaturan["akses"]);
										
										if (!empty($akseses)) {
											foreach ($akseses as $keyAk => $ak) {
												$ak = trim($ak);
												$selected = '';

												if (trim($ak) == trim($akses)) {
													$selected = 'selected="selected"';
												}

												print '<option value="'.$ak.'" '.$selected.'>'.$ak.'</option>';
											}
										}
									?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<table class="table table-condensed table-striped mb-0 table-uraian-arsip">
										<thead>
											<tr>
												<th width="4%">No</th>
												<th width="35%">Item</th>
												<th width="16%">Tanggal</th>
												<th width="15%">Perkembangan</th>
												<th width="20%">Jumlah</th>

												<?php
													if (isset($status) && $status != "Baru") {
												?>
													<th width="6%"></th>
												<?php
													}
												?>

												<th width="10%">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$itemArsip = array();

												$itemDefault["item"] = "";
												$itemDefault["tgl"] = "";
												$itemDefault["perkembangan"] = "Asli";
												$itemDefault["jumlah"] = "";
												$itemDefault["satuan"] = "Berkas";

												$itemArsip[] = $itemDefault;

												if (isset($uraian) && !empty($uraian)) {
													$itemArsip = json_decode($uraian, true);
												}

												if (!empty($itemArsip)) {
													foreach ($itemArsip as $keyItem => $item) {
											?>
													<tr>
														<td class="no-item"><?php print $keyItem+1; ?></td>
														<td>
															<select <?php print $disabled; ?> name="item[]" class="select-item form-control select2">
																<option value=""></option>
																<?php
																	$arsipItems = explode("\n", $pengaturan["item"]);
												
																	if (!empty($arsipItems)) {
																		foreach ($arsipItems as $keyItem => $valItem) {
																			$valItem = trim($valItem);
																			$selected = "";
																			
																			if ($item["item"] == $valItem) {
																				$selected = 'selected="selected"';
																			}
																			
																			print '<option value="'.$valItem.'" '.$selected.'>'.$valItem.'</option>';
																		}
																	}
																?>
															</select>
														</td>
														<td>
															<input <?php print $disabled; ?> type="text" class="form-control datepicker form-item" name="tgl[]" value="<?php print isset($item["tgl"]) ? $item["tgl"] : ""; ?>" />
														</td>
														<td>
															<?php
																$perkembanganOptions = explode("\n", $pengaturan["perkembangan"]);
															?>
															<select <?php print $disabled; ?> name="perkembangan[]" class="select-perkembangan form-control">
																<?php
																	if (!empty($perkembanganOptions)) {
																		foreach ($perkembanganOptions as $keyItem => $valItem) {
																			$valItem = trim($valItem);
																			$selected = "";
																			
																			if ($item["perkembangan"] == $valItem) {
																				$selected = 'selected="selected"';
																			}
																			
																			print '<option value="'.$valItem.'" '.$selected.'>'.$valItem.'</option>';
																		}
																	}
																?>
															</select>
														</td>
														<td>
															<?php
																$berkasOptions = array("Berkas", "Lembar", "Set");
															?>
															<div class="input-group">
															<input <?php print $disabled; ?> type="text" name="jumlah[]" class="form-control form-item form-berkas" value="<?php print isset($item["jumlah"]) ? $item["jumlah"] : ""; ?>" />
															<select <?php print $disabled; ?> class="form-control form-item select-berkas" name="satuan[]">
																<?php
																	if (!empty($berkasOptions)) {
																		foreach ($berkasOptions as $keyItem => $valItem) {	
																			$selected = "";
																			
																			if ($item["satuan"] == $valItem) {
																				$selected = 'selected="selected"';
																			}
																			
																			print '<option value="'.$valItem.'" '.$selected.'>'.$valItem.'</option>';
																		}
																	}
																?>
															</select>
															</div>
														</td>

														<?php
															if (isset($status) && $status != "Baru") {
														?>
														<td class="text-center" style="font-size:18px;">
															<?php
																if (isset($item["valid"]) && $item["valid"] == "1") {
																	print '<a href="javascript:;" class="icon-green" title="Item Valid"><i class="fa fa-check-circle" aria-hidden="true"></i></a>';
																}
																else {
																	print '<a href="javascript:;" class="icon-red" title="Item Tidak Valid"><i class="fa fa-times-circle" aria-hidden="true"></i></a>';
																}

																print '<input '.$disabled.' type="hidden" name="valid[]" value="'.$item["valid"].'" />';
															?>
														</td>
														<?php
															}
														?>

														<td>
															<?php
																$duplicateClass = "duplicate-arsip-item";
																$deleteClass = "delete-arsip-item";

																if ($status == "Diarsipkan") {
																	$duplicateClass = "";
																	$deleteClass = "";
																}
															?>
															<a <?php print $disabled; ?> href="javascript:;" class="btn btn-info <?php print $duplicateClass; ?>" title="Duplikasi"><i class="fas fa-copy"></i></a>&nbsp;
															<a <?php print $disabled; ?> href="javascript:;" class="btn btn-danger <?php print $deleteClass; ?>" title="Hapus"><i class="fas fa-trash-alt"></i></a>
														</td>
													</tr>
											<?php
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<hr class="mb-2" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Keterangan Arsip</label>
									<textarea <?php print $disabled; ?> name="keterangan" class="form-control" rows="5"><?php print isset($keterangan) ? $keterangan : ""; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
					if ($status != "Baru" && !empty($id)) {
				?>
						<div class="card mt-4 mb-0">
							<div class="card-header"><h5>Status Arsip</h5></div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Status</label>
											<div>
												<input type="text" disabled="disabled" class="form-control status-arsip" value="<?php print $status; ?>" />

												<?php
													if ($status == 'Ditolak Arsiparis' || $status == 'Ditolak SPI') {
														print '<input type="hidden" name="status" value="Baru" />';
													}
													else if ($status == 'Ditolak Kepala') {
														print '<input type="hidden" name="status" value="Disetujui SPI" />';
													}
												?>
											</div>
										</div>
									</div>
									<div class="col-md-3 kontrol-peminjam">
										<div class="form-group">
											<label>Nama Peminjam</label>
											<div>
												<?php
													$namaPeminjam = "";

													if (isset($pegawai) && !empty($pegawai)) {
														foreach ($pegawai as $peg) {
															if (isset($dipinjam_oleh) && $dipinjam_oleh == $peg["id"]) {
																$namaPeminjam = $peg["nama"];
																break;
															}
														}
													}
												?>
												<input type="text" disabled="disabled" class="form-control" value="<?php print $namaPeminjam; ?>" />
											</div>
										</div>
									</div>
									<div class="col-md-9 row-simpan-arsip">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label>Nomor Kabinet</label>
													<input type="text" disabled="disabled" class="form-control" value="<?php print isset($no_kabinet) ? $no_kabinet : ""; ?>" />
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Nomor Laci</label>
													<input type="text" disabled="disabled" class="form-control" value="<?php print isset($no_laci) ? $no_laci : ""; ?>" />
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Nomor Folder</label>
													<input type="text" disabled="disabled" class="form-control" value="<?php print isset($no_folder) ? $no_folder : ""; ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row row-tolak-arsiparis">
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan Arsiparis</label>
											<div>
												<textarea class="form-control" disabled="disabled" rows="5"><?php print isset($keterangan_arsip) ? $keterangan_arsip : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>

								<div class="row row-tolak-spi">
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan SPI</label>
											<div>
												<textarea class="form-control" disabled="disabled" rows="5"><?php print isset($keterangan_spi) ? $keterangan_spi : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>

								<div class="row row-tolak-kepala">
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan Kepala</label>
											<div>
												<textarea class="form-control" disabled="disabled" rows="5"><?php print isset($keterangan_kepala) ? $keterangan_kepala : ""; ?></textarea>
											</div>
										</div>
									</div>
								</div>
									
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<a href="javascript:;" class="sejarah-arsip">&raquo; Lihat Sejarah Arsip</a>
										</div>
									</div>
									<div class="col-md-12 load-sejarah-arsip"></div>
								</div>
							</div>
						</div>
				<?php
					}
				?>
			</div>
			<div class="modal-footer">
				<?php
					if (empty($disabled)) {
				?>
						<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<?php
					}
				?>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<style type="text/css">
	@media (min-width: 768px) {
		.modal-dialog {
			width: 960px;
		}
	}
	.table-uraian-arsip input,
	.table-uraian-arsip select {
		min-height:36px;
	}
	.table-uraian-arsip > tbody > tr > td .btn {
		font-size: 14px;
   		line-height: 24px;
	}
	.table-uraian-arsip > tbody > tr > td .btn > i {
		margin-right:0;
	}
</style>
<script>
	$(document).ready(function () {
		function checkStatusArsip () {
			var statusArsip = $('.status-arsip').val();

			if (statusArsip == "Dipinjam") {
				$('.kontrol-peminjam').show();
				$('.row-simpan-arsip').hide();
				$('[name="no_kabinet"]').val('').removeAttr('required');
				$('[name="no_laci"]').val('').removeAttr('required');
				$('[name="no_folder"]').val('').removeAttr('required');
				$('.row-tolak-arsiparis').hide();
				$('.row-tolak-spi').hide();
				$('.row-tolak-kepala').hide();
			}
			else if (statusArsip == "Ditolak Arsiparis") {
				$('.kontrol-peminjam').hide();
				$('.dipinjam_oleh').val('');
				$('.row-simpan-arsip').hide();
				$('[name="no_kabinet"]').val('').removeAttr('required');
				$('[name="no_laci"]').val('').removeAttr('required');
				$('[name="no_folder"]').val('').removeAttr('required');
				$('.row-tolak-arsiparis').show();
				$('.row-tolak-spi').hide();
				$('.row-tolak-kepala').hide();
			}
			else if (statusArsip == "Ditolak SPI") {
				$('.kontrol-peminjam').hide();
				$('.dipinjam_oleh').val('');
				$('.row-simpan-arsip').hide();
				$('[name="no_kabinet"]').val('').removeAttr('required');
				$('[name="no_laci"]').val('').removeAttr('required');
				$('[name="no_folder"]').val('').removeAttr('required');
				$('.row-tolak-arsiparis').hide();
				$('.row-tolak-spi').show();
				$('.row-tolak-kepala').hide();
			}
			else if (statusArsip == "Ditolak Kepala") {
				$('.kontrol-peminjam').hide();
				$('.dipinjam_oleh').val('');
				$('.row-simpan-arsip').hide();
				$('[name="no_kabinet"]').val('').removeAttr('required');
				$('[name="no_laci"]').val('').removeAttr('required');
				$('[name="no_folder"]').val('').removeAttr('required');
				$('.row-tolak-arsiparis').hide();
				$('.row-tolak-spi').hide();
				$('.row-tolak-kepala').show();
			}
			else {
				$('.kontrol-peminjam').hide();
				$('.dipinjam_oleh').val('');
				$('.row-simpan-arsip').show();
				$('[name="no_kabinet"]').attr('required','required');
				$('[name="no_laci"]').attr('required','required');
				$('[name="no_folder"]').attr('required','required');
				$('.row-tolak-arsiparis').hide();
				$('.row-tolak-spi').hide();
				$('.row-tolak-kepala').hide();
			}
		}

		$('.status-arsip').change(function () {
			checkStatusArsip();
		});
		

		checkStatusArsip();

		$('.sejarah-arsip').click(function () {
			Loader.start();

			var arsipId = $('.arsip-id').val();

			$.ajax({
				type: "POST",
				url: "/admin/arsip/load_sejarah_arsip",
				data: {
					id: arsipId,
					version: Math.random()				
				},
				dataType: 'html',
				success: function(html){
					$('.load-sejarah-arsip').html(html);

					Loader.stop();
				}
			});
		});
	});
</script>