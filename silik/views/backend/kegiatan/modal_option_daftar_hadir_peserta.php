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
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<form action="/admin/kegiatan/download_option_daftar_hadir" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="kegiatan_id" required class="form-control" value="<?php print $kegiatan["id"]; ?>" />
			<input type="hidden" name="tipe" required class="form-control" value="<?php print $tipe; ?>" />

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Download Daftar Hadir <?php print ucfirst($tipe); ?></h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<h4><?php print $kegiatan["nama"]; ?></h4>
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

						if (isset($kegiatan["detail_tgl_kegiatan"]) && !empty($kegiatan["detail_tgl_kegiatan"])) {
							$date_sign = $kegiatan["detail_tgl_kegiatan"];
						}
					?>

					<table style="border-bottom:1px solid #aaa;" id="table-rekap-daftar-hadir-peserta" class="table table-condensed table-hover table-striped">
						<tbody style="border-top:none;">
							<tr>
								<td class="dh-date">
									<div class="checkbox checkbox-primary" style="padding: 0; margin: 0;">
										<input type="checkbox" class="check-all-df" id="checkbox-all-dh" value="1" />
										<label for="checkbox-all-dh" class="cr">&nbsp;</label>
									</div>
								</td>
								<td>
									<label for="checkbox-all-dh" class="cr">Semua</label>
								</td>
							</tr>

							<?php
								if (!empty($date_sign)) {
									foreach ($date_sign as $df) {
							?>
									<tr>
										<td class="dh-date">
											<div class="checkbox checkbox-primary" style="padding: 0; margin: 0;">
												<input type="checkbox" name="" class="check-daftar-hadir" id="checkbox-<?php print $df; ?>" value="<?php print $df; ?>" />
												<label for="checkbox-<?php print $df; ?>" class="cr">&nbsp;</label>
											</div>
										</td>
										<td>
											<label for="checkbox-<?php print $df; ?>" class="cr"><?php print $this->utility->formatDateIndo2($df); ?></label>
										</td>
									</tr>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary download-option-daftar-hadir-execute" data-kegiatan="<?php print $kegiatan["id"]; ?>" data-tipe="<?php print $tipe; ?>">Download</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('.check-all-df').change(function () {
		if ($(this).is(':checked')) {
			$('input[type="checkbox"].check-daftar-hadir').prop('checked', true);
		}
		else {
			$('input[type="checkbox"].check-daftar-hadir').prop('checked', false);
		}
	});
</script>