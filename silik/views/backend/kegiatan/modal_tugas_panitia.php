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

<div class="modal fade" id="modal-atur-tugas-panitia" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="/admin/kegiatan/save_tugas_panitia" method="post" class="form-submit" autocomplete="off" data-table-id="<?php print isset($table_id) ? $table_id : ""; ?>">
			<input type="hidden" name="id" required class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Tugas Panitia</h5>
				</div>
				<div class="modal-body">
					<div class="penugasan-panitia">
						<div class="row">
							<div class="col-md-1 t-bold">No</div>
							<div class="col-md-4 t-bold">Tugas</div>
							<div class="col-md-7 t-bold">Petugas</div>
						</div>

						<?php
							$i = 1;

							foreach ($this->config->item("tugas_panitia") as $tg => $ts) {
						?>
								<div class="row">
									<div class="col-md-1"><?php print $i; ?></div>
									<div class="col-md-4"><?php print $ts; ?></div>
									<div class="col-md-7">
										<select class="form-control select-tugas-panitia select2" name="<?php print $tg; ?>" required>
											<?php
												print '<option value="">&nbsp;&nbsp;</option>';

												if (isset($panitia) && !empty($panitia)) {
													foreach ($panitia as $pan) {
														$selected = "";

														if (($tg == "penanggungjawab" && $pan["jabatan_panitia"] == "penanggungjawab") || ($tg == "ketua" && $pan["jabatan_panitia"] == "ketua")) {
															$selected = 'selected="selected"';
														}
														else if ($pan["tugas_panitia"] == $tg) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$pan["id"].'" '.$selected.'>'.$pan["nama"].'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
						<?php
								$i++;
							}
						?>
					</div>
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
	$(document).on("change",".select-tugas-panitia",function (e) {
		var penanggungjawab = $('.select-tugas-panitia[name="penanggungjawab"]').val();
		var ketua = $('.select-tugas-panitia[name="ketua"]').val();

		if (penanggungjawab != "" && ketua != "" && penanggungjawab == ketua) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: "Penanggungjawab dan Ketua tidak boleh sama"
			});

			$(this).val("").trigger('change');
		}
	});
</script>