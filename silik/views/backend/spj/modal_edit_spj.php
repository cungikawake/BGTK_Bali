<div class="modal fade" id="add-spj-modal" role="dialog" aria-hidden="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Buat SPJ Penugasan</h5>
			</div>
			<form method="post" class="form-spj">
				<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>">
				<div class="modal-body">
					<div class="opt-monev">
						<div class="form-group">
							<label>Pilih Penugasan</label>
							<select class="form-control select2-penugasan" name="penugasan_id" data-selected-penugasan="<?php print isset($penugasan_id) ? $penugasan_id : ""; ?>">
								<option>&nbsp;</option>
								<?php
									if (isset($penugasan_options) && !empty($penugasan_options)) {
										foreach ($penugasan_options as $opt) {
											print '<option value="'.$opt["id"].'">'.$opt["nama"].'</option>';
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Nama SPJ Penugasan</label>
						<textarea class="form-control" rows="2" name="nama"><?php print isset($nama) ? $nama : ""; ?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info btn-submit-spj mb-0">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>