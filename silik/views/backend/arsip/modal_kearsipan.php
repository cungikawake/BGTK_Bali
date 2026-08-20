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
		
		<form action="/admin/arsip/save_kearsipan" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control arsip-id" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card">
					<div class="card-header"><h5>Rincian Arsip</h5></div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Nama</label>
									<p><input type="text" class="form-control" disabled="disabled" value="<?php print isset($nama) ? $nama : ""; ?>" /></p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0">
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label>Program</label>
									<p>
										<?php
											$programs = explode("\n", $pengaturan["program"]);
											$programArsip = array();

											if (!empty($programs)) {
												foreach ($programs as $pro) {
													$foo = explode("|", $pro);
													
													if ($foo[0] == $_SESSION["tahun_anggaran"]) {
														$selected = '';

														if ($foo[1] == $program) {
															$programArsip[$foo[1]] = $foo[2]; 
														}
													}
												}
											}
										?>
										<input type="text" class="form-control" disabled="disabled" value="<?php print isset($programArsip[$program]) ? "[".$program."] - ".$programArsip[$program] : ""; ?>" />
									</p>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Jenis Berkas</label>
									<p><input type="text" class="form-control" disabled="disabled" value="<?php print isset($jenis_berkas) ? $jenis_berkas : ""; ?>" /></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Pencipta</label>
									<p>
										<input type="text" class="form-control" disabled="disabled" value="<?php print $pegawai[$pencipta["sync_biodata"]]["nama"]; ?>" />
									</p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0">

						<?php
							$itemArsip = array();

							if (isset($uraian) && !empty($uraian)) {
								$itemArsip = json_decode($uraian, true);
							}
						?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Uraian</label>
									<table class="table table-condensed table-hover table-striped mb-0">
										<thead>
											<tr>
												<th>No</th>
												<th>Item</th>
												<th>Tanggal</th>
												<th>Perkembangan</th>
												<th>Jumlah</th>
												<th>Valid</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if (!empty($itemArsip)) {
													foreach ($itemArsip as $itemNo => $item) {
											?>
														<tr>
															<td><?php print $itemNo + 1; ?></td>
															<td><?php print $item["item"]; ?></td>
															<td><?php print $item["tgl"]; ?></td>
															<td><?php print $item["perkembangan"]; ?></td>
															<td><?php print $item["jumlah"]." ".$item["satuan"]; ?></td>
															<td>
																<input type="hidden" name="uraian[<?php print $itemNo; ?>][item]" value="<?php print $item["item"]; ?>" />
																<input type="hidden" name="uraian[<?php print $itemNo; ?>][tgl]" value="<?php print $item["tgl"]; ?>" />
																<input type="hidden" name="uraian[<?php print $itemNo; ?>][perkembangan]" value="<?php print $item["perkembangan"]; ?>" />
																<input type="hidden" name="uraian[<?php print $itemNo; ?>][jumlah]" value="<?php print $item["jumlah"]; ?>" />
																<input type="hidden" name="uraian[<?php print $itemNo; ?>][satuan]" value="<?php print $item["satuan"]; ?>" />
																<input type="hidden" name="uraian[<?php print $itemNo; ?>][valid]" value="0" />

																<?php
																	$disabled = "";
																	$checked = "";
																	
																	if (isset($item["valid"]) && $item["valid"] == "1") {
																		$checked = 'checked="checked"';
																	}

																	if (isset($jenis_berkas) && ($jenis_berkas == "Laporan Kegiatan" || $jenis_berkas == "Laporan Keuangan dan BMN")) {
																		$disabled = 'onclick="return false"';
																	}

																	if (isset($jenis_berkas) && $jenis_berkas == "Pengadaan Barang dan Jasa") {
																		$checked = 'checked="checked"';
																		$disabled = 'onclick="return false"';
																	}
																?>

																<input type="checkbox" name="uraian[<?php print $itemNo; ?>][valid]" value="1" <?php print $checked; ?> <?php print $disabled; ?> class="valid-check" />
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
						<hr class="mb-3 mt-0">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Keterangan</label>
									<p><textarea disabled="disabled" class="form-control" rows="5"><?php print isset($keterangan) ? $keterangan : ""; ?></textarea></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-0">
					<div class="card-header"><h5>Petugas Arsip</h5></div>
					<div class="card-body">
					<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<?php
										if ($status == "Divalidasi Arsiparis" && ($jenis_berkas == "Laporan Kegiatan" || $jenis_berkas == "Laporan Keuangan dan BMN" || $jenis_berkas == "Pengadaan Barang dan Jasa")) {
											$statusOptions = array("Divalidasi Arsiparis","Diarsipkan");
										}
										else if ($status == "Divalidasi Arsiparis") {
											$statusOptions = array("Divalidasi Arsiparis","Diarsipkan", "Ditolak Arsiparis");
										}
										else if ($status == "Diarsipkan") {
											$statusOptions = array("Diarsipkan", "Dipinjam");
										}
										else if ($status == "Ditolak Arsiparis") {
											$statusOptions = array("Diarsipkan", "Ditolak Arsiparis");
										}
										else if ($status == "Dipinjam") {
											$statusOptions = array("Dipinjam", "Diarsipkan");
										}
									?>
									<label>Status</label>
									<select name="status" class="select2 status-arsip">
										<?php
											foreach ($statusOptions as $op) {
												$selected = '';

												if (isset($status) && $status == $op) {
													$selected = 'selected="selected"';
												}

												print '<option value="'.$op.'" '.$selected.'>'.$op.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4 kontrol-peminjam">
								<div class="form-group">
									<label>Nama Peminjam</label>
									<select name="dipinjam_oleh" class="select2 dipinjam_oleh">
										<?php
											if (isset($pegawai) && !empty($pegawai)) {
												print '<option value="">  </option>';

												foreach ($pegawai as $peg) {
													$selected = '';

													if (isset($dipinjam_oleh) && $dipinjam_oleh == $peg["id"]) {
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

						<div class="row row-simpan-arsip">
							<div class="col-md-4">
								<div class="form-group">
									<label>Nomor Kabinet</label>
									<input type="text" name="no_kabinet" class="form-control" required value="<?php print isset($no_kabinet) ? $no_kabinet : ""; ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Nomor Laci</label>
									<input type="text" name="no_laci" class="form-control" required value="<?php print isset($no_laci) ? $no_laci : ""; ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Nomor Folder</label>
									<input type="text" name="no_folder" class="form-control" required value="<?php print isset($no_folder) ? $no_folder : ""; ?>" />
								</div>
							</div>
						</div>

						<div class="row row-tolak-arsip">
							<div class="col-md-12">
								<div class="form-group">
									<label>Keterangan</label>
									<textarea class="form-control" name="keterangan_arsip" rows="5"><?php print isset($keterangan_arsip) ? $keterangan_arsip : ""; ?></textarea>
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
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
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
</style>

<script>
	$(document).ready(function () {
		function showHideFormControl (statusArsip) {
			if (statusArsip == "Dipinjam") {
				$('.kontrol-peminjam').show();
				$('.row-simpan-arsip').hide();
				$('.row-tolak-arsip').hide();
				
				$('[name="no_kabinet"]').removeAttr('required');
				$('[name="no_laci"]').removeAttr('required');
				$('[name="no_folder"]').removeAttr('required');
				$('[name="keterangan_tolak"]').removeAttr('required');
			}
			else if (statusArsip == "Divalidasi Arsiparis") {
				$('.kontrol-peminjam').hide();
				$('.row-simpan-arsip').hide();
				$('.row-tolak-arsip').hide();

				$('[name="no_kabinet"]').removeAttr('required');
				$('[name="no_laci"]').removeAttr('required');
				$('[name="no_folder"]').removeAttr('required');
				$('[name="keterangan_tolak"]').removeAttr('required');
			}
			else if (statusArsip == "Ditolak Arsiparis") {
				$('.kontrol-peminjam').hide();
				$('.row-simpan-arsip').hide();
				$('.row-tolak-arsip').show();
				
				$('[name="no_kabinet"]').removeAttr('required');
				$('[name="no_laci"]').removeAttr('required');
				$('[name="no_folder"]').removeAttr('required');
			}
			else {
				$('.kontrol-peminjam').hide();
				$('.row-simpan-arsip').show();
				$('.row-tolak-arsip').hide();

				$('[name="no_kabinet"]').attr('required','required');
				$('[name="no_laci"]').attr('required','required');
				$('[name="no_folder"]').attr('required','required');
			}
		}
		$('.status-arsip').change(function () {
			var statusArsip = $(this).val();
			showHideFormControl(statusArsip);
		});

		var statusArsip = $('.status-arsip').val();

		showHideFormControl(statusArsip);

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