<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Sinkronkan Admin Dengan Biodata</h5>
		</div>
		<form action="/admin/user/sync_biodata" method="post" class="form-submit" autocomplete="false">
			<input type="hidden" name="id" required class="form-control" value="<?php print $id; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>Biodata</label>
					<select id="select-biodata-sync" class="form-control select2" name="sync_biodata">
						<?php
							if (isset($biodata) && !empty($biodata)) {
								foreach ($biodata as $bio) {
									print '<option value="'.$bio["id"].'">'.$bio["nama"].'</option>';
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>