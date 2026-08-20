<style type="text/css">
	.penugasan-panitia div.row > div {
		border-bottom: 1px solid #ddd;
		display:flex;
		align-items:center;
		min-height: 49px;
		padding-top: 4px;
		padding-bottom: 4px;
	}
</style>

<div class="modal fade" id="modal-show-rekap-daftar-hadir-peserta" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<form action="/admin/kegiatan/save_rekap_daftar_hadir_peserta" method="post" class="form-submit" autocomplete="off" data-table-id="<?php print isset($table_id) ? $table_id : ""; ?>">
			<input type="hidden" name="id" required class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Rekap Daftar Hadir Peserta</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="search form-group">
								<div class="input-group">
									<span class="icon glyphicon input-group-addon glyphicon-search" style="padding: 12px 25px 0px 15px; margin-top: -1px; margin-bottom: 1px;"></span><input type="text" id="searchInput" class="search-field form-control" placeholder="Search">
								</div>
							</div>
						</div>
					</div>

					<style type="text/css">
						#table-rekap-daftar-hadir-peserta tbody {
							display:block;
							height:364px;
							overflow:auto;
						}
						#table-rekap-daftar-hadir-peserta thead, #table-rekap-daftar-hadir-peserta tbody tr {
							display:table;
							width:100%;
							table-layout:fixed;
						}
						#table-rekap-daftar-hadir-peserta thead {
							width: calc( 100% - 1em )
						}
						#table-rekap-daftar-hadir-peserta table {
							width:100%;
						}
						#table-rekap-daftar-hadir-peserta .dh-no {
							width:35px;
						}
						#table-rekap-daftar-hadir-peserta .dh-date {
							width:115px;
						}
					</style>

					<?php
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
					?>

					<table style="border-bottom:1px solid #aaa;" id="table-rekap-daftar-hadir-peserta" class="table table-condensed table-hover table-striped">
						<thead style="border-top:1px solid #aaa;border-bottom:none;">
							<tr>
								<th class="dh-no">No</th>
								<th>Nama</th>

								<?php
									if (!empty($date_sign)) {
										foreach ($date_sign as $df) {
								?>
										<th class="dh-date"><?php print $this->utility->formatDateIndo2($df); ?></th>
								<?php
										}
									}
								?>
							</tr>
						</thead>
						<tbody style="border-top:none;">
							<tr>
								<td class="dh-no"></td>
								<td></td>
								<?php
									if (!empty($date_sign)) {
										foreach ($date_sign as $df) {
								?>
										<td class="dh-date">
											<div class="checkbox checkbox-primary" style="padding: 0; margin: 0;">
												<input type="checkbox" class="check-all-df" id="checkbox-<?php print $df; ?>" data-date="<?php print $df; ?>" value="1" />
												<label for="checkbox-<?php print $df; ?>" class="cr">Semua</label>
											</div>
										</td>
								<?php
										}
									}
								?>
							</tr>

							<?php
								if (isset($peserta) && !empty($peserta)) {
									$noPs = 1;

									foreach ($peserta as $ps) {
							?>
										<tr>
											<td class="dh-no"><?php print $noPs; ?></td>
											<td><?php print $ps["nama"]; ?></td>
											<?php
												if (!empty($date_sign)) {
													foreach ($date_sign as $df) {
											?>
														<td class="dh-date">
															<div class="checkbox checkbox-primary" style="padding: 0; margin: 0;">
																<input type="checkbox" name="daftar_hadir[<?php print $ps["id"]; ?>][<?php print $df; ?>]" class="check-daftar-hadir" data-daftar-hadir="<?php print $df; ?>" id="checkbox-<?php print $ps["id"]; ?>-<?php print $df; ?>" value="1" />
																<label for="checkbox-<?php print $ps["id"]; ?>-<?php print $df; ?>" class="cr">&nbsp;</label>
															</div>
														</td>
											<?php
													}
												}
											?>
										</tr>
							<?php
										$noPs++;
									}
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$("#searchInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#table-rekap-daftar-hadir-peserta tbody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$('.check-all-df').change(function () {
		var tgl = $(this).attr('data-date');

		if ($(this).is(':checked')) {
			$('input[type="checkbox"][data-daftar-hadir="'+tgl+'"]').prop('checked', true);
		}
		else {
			$('input[type="checkbox"][data-daftar-hadir="'+tgl+'"]').prop('checked', false);
		}
	});

	$('.check-daftar-hadir').change(function () {
		var tgl = $(this).attr('data-daftar-hadir');

		if (!$(this).is(':checked')) {
			$('input[type="checkbox"][id="checkbox-'+tgl+'"]').prop('checked', false);
		}
	});
</script>