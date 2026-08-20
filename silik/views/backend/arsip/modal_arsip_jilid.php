<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">LAPORAN KEGIATAN [<?php print isset($kode) ? $kode : ""; ?>]</h5>
		</div>

		<style type="text/css">
			.valid-check {
				zoom: 1.4;
			}
		</style>

		<?php
			$disabled = '';
			$readonly = '';

			if (isset($jenis_berkas) && ($jenis_berkas == "Laporan Kegiatan" || $jenis_berkas == "Laporan Keuangan dan BMN" || $jenis_berkas == "Pengadaan Barang dan Jasa")) {
				$disabled = '';
				$readonly = 'readonly';
			}
			
			if ($status == "Diarsipkan") {
				$disabled = 'disabled="disabled"';
			}
		?>
		
		<form action="/admin/arsip/save_arsip_jilid" method="post" class="form-submit-spi" autocomplete="off">
			<input type="hidden" name="id" class="form-control arsip-id" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card mb-0">
					<div class="card-header"><h5>Rincian Laporan</h5></div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Nama Kegiatan</label><input <?php print $disabled." ".$readonly; ?> type="text" name="nama" class="form-control" required value="<?php print isset($nama) ? $nama : ""; ?>" />
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
						
						<?php
							$rowKeuanganStyle = 'style="display:none;"';
							$rowRequired = '';
							
							if ($jenis_berkas == "Keuangan") {
								$rowKeuanganStyle = '';
								$rowRequired = 'required="required"';
							}
						?>
						<hr class="mb-2 row-keuangan" <?php print $rowKeuanganStyle; ?> />

						<div class="row row-keuangan" <?php print $rowKeuanganStyle; ?>>
							<div class="col-md-3">
								<div class="form-group">
									<label>Jenis Belanja</label>
									<select <?php print $disabled; ?> name="jenis_belanja" class="form-control select2" <?php print $rowRequired; ?>>
										<option value=""></option>

										<?php
											$jenis_belanja_ops = array(
												"GUP" => "[GUP] Ganti Uang Persediaan",
												"TUP" => "[TUP] Tambahan Uang Persediaan",
												"LS" => "[LS] Langsung",
											);
											
											if (!empty($jenis_belanja_ops)) {
												foreach ($jenis_belanja_ops as $op => $vl) {
													$selected = '';

													if ($op == $jenis_belanja) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$op.'" '.$selected.'>'.$vl.'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Nomor SPM</label>
									<input <?php print $disabled; ?> class="form-control" name="nomor_spm" value="<?php print isset($nomor_spm) ? $nomor_spm : ""; ?>" <?php print $rowRequired; ?> style="min-height:36px;" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Nomor DRPP</label>
									<input <?php print $disabled; ?> class="form-control" name="nomor_drpp" value="<?php print isset($nomor_drpp) ? $nomor_drpp : ""; ?>" <?php print $rowRequired; ?> style="min-height:36px;" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Jumlah Bantek</label>
									<select <?php print $disabled; ?> name="jumlah_bantek" class="form-control select2" <?php print $rowRequired; ?>>
									<?php
										if (!isset($jumlah_bantek) && $jumlah_bantek == "") {
											$jumlah_bantek = "1";
										}
										
										foreach (range(1,10) as $fuu) {
											$selected = '';

											if ($fuu == $jumlah_bantek) {
												$selected = 'selected="selected"';
											}

											print '<option value="'.$fuu.'" '.$selected.'>'.$fuu.'</option>';
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
															<select <?php print $disabled." ".$readonly; ?> name="item[]" class="select-item form-control select2">
																<option value=""></option>
																<?php
																	$arsipItems = explode("\n", $pengaturan["item"]);
												
																	if (!empty($arsipItems)) {
																		foreach ($arsipItems as $key => $valItem) {
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
															<input <?php print $disabled." ".$readonly; ?> type="text" class="form-control datepicker form-item" name="tgl[]" value="<?php print isset($item["tgl"]) ? $item["tgl"] : ""; ?>" />
														</td>
														<td>
															<?php
																$perkembanganOptions = explode("\n", $pengaturan["perkembangan"]);
															?>
															<select <?php print $disabled." ".$readonly; ?> name="perkembangan[]" class="select-perkembangan form-control">
																<?php
																	if (!empty($perkembanganOptions)) {
																		foreach ($perkembanganOptions as $key => $valItem) {
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
															<input <?php print $disabled." ".$readonly; ?> type="text" name="jumlah[]" class="form-control form-item form-berkas" value="<?php print isset($item["jumlah"]) ? $item["jumlah"] : ""; ?>" />
															<select <?php print $disabled." ".$readonly; ?> class="form-control form-item select-berkas" name="satuan[]">
																<?php
																	if (!empty($berkasOptions)) {
																		foreach ($berkasOptions as $key => $valItem) {	
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
									<label>Keterangan</label>
									<textarea <?php print $disabled." ".$readonly; ?> name="keterangan" class="form-control" rows="5"><?php print isset($keterangan) ? $keterangan : ""; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php
					if (empty($disabled)) {
				?>
						<button type="submit" class="btn btn-info btn-modal-form-submit" name="approval" value="selesai">Selesai Jilid</button>
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
			width: 880px;
		}
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
		$('.status-arsip').change(function () {
			var statusArsip = $(this).val();

			if (statusArsip == "Dipinjam") {
				$('.kontrol-peminjam').show();
				$('.row-simpan-arsip').hide();
				$('[name="no_kabinet"]').val('').removeAttr('required');
				$('[name="no_laci"]').val('').removeAttr('required');
				$('[name="no_folder"]').val('').removeAttr('required');
			}
			else {
				$('.kontrol-peminjam').hide();
				$('.dipinjam_oleh').val('');
				$('.row-simpan-arsip').show();
				$('[name="no_kabinet"]').attr('required','required');
				$('[name="no_laci"]').attr('required','required');
				$('[name="no_folder"]').attr('required','required');
			}
		});

		$('.jenis_berkas').change(function () {
			var jenisBerkas = $(this).val();

			if (jenisBerkas == "Keuangan") {
				$('.row-keuangan').show();
				$('[name="jenis_belanja"]').attr('required','required');
				$('[name="nomor_spm"]').attr('required','required');
				$('[name="nomor_drpp"]').attr('required','required');
				$('[name="jumlah_bantek"]').attr('required','required');
			}
			else {
				$('.row-keuangan').hide();
				$('[name="jenis_belanja"]').removeAttr('required');
				$('[name="nomor_spm"]').removeAttr('required');
				$('[name="nomor_drpp"]').removeAttr('required');
				$('[name="jumlah_bantek"]').removeAttr('required');
			}
		});

		var statusArsip = $('.status-arsip').val();

		if (statusArsip == "Dipinjam") {
			$('.kontrol-peminjam').show();
			$('.row-simpan-arsip').hide();
			$('[name="no_kabinet"]').val('').removeAttr('required');
			$('[name="no_laci"]').val('').removeAttr('required');
			$('[name="no_folder"]').val('').removeAttr('required');
		}
		else {
			$('.kontrol-peminjam').hide();
			$('.dipinjam_oleh').val('');
			$('.row-simpan-arsip').show();
			$('[name="no_kabinet"]').attr('required','required');
			$('[name="no_laci"]').attr('required','required');
			$('[name="no_folder"]').attr('required','required');
		}

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

		$(document).on("submit","form.form-submit-spi",function (e) {
			e.preventDefault();
			
			var url = window.location.href;
			var action = $(this).attr('action');
			var data = $(this).serialize();
			var form = $(this);

			if (typeof action === typeof undefined && action === false) {
				action = url;
			}

			var approval = "";

			// Check if an active element exists and is a submit button
			if (document.activeElement && (document.activeElement.type === 'submit' || document.activeElement.type === 'button')) {
				data += '&' + encodeURI(document.activeElement.getAttribute('name')) + '=' + encodeURI(document.activeElement.getAttribute('value'));

				approval = document.activeElement.getAttribute('value');
			}

			var ext_submit = 1;

			if (approval == "tolak") {
				if($('[name="keterangan_kepala"]').val() == "") {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: "Mohon memberikan keterangan penolakan"
					});

					ext_submit = 0;
				}
			}
			
			if (ext_submit) {
				Loader.start();
				
				$.ajax({
					type: "POST",
					url: action,
					data: data,
					dataType: 'json',
					success: function(obj){
						Loader.stop();
						
						if (obj.error) {
							
							if(typeof(obj.redirect) != "undefined" && obj.redirect !== null) {
								window.location.href = obj.redirect;
							}
							else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: obj.msg
								});
							}
						}
						else {
							if(typeof(obj.redirect) != "undefined" && obj.redirect !== null) {
								window.location.href = obj.redirect;
							}
							else if (typeof(obj.reload) != "undefined" && (obj.reload !== null || obj.reload !== false)) {
								
								Swal.fire({
								icon: 'success',
									title: 'Sukses...',
								text: obj.msg,
								showConfirmButton: true,
								}).then(function() {
									location.reload();
								});
								
							}
							else {
								if (obj.close_modal) {
									form.closest('.modal').modal('hide');
								}
								
								if (obj.reload_table) {
									var tableId = form.attr('data-table-id');
									Table.refreshTable(tableId);
								}
									
								Swal.fire({
									icon: 'success',
									title: 'Sukses...',
									text: obj.msg,
									showConfirmButton: true,
								});
							}
						}
					}
				});
			}
		});
	});
	
</script>