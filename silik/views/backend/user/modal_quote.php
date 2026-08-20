<?php
	if (!isset($id)) { $id = ""; }
	if (!isset($kutipan)) { $kutipan = ""; }
	if (!isset($oleh)) { $oleh = ""; }
?>

<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Kutipan</h5>
		</div>
		<form action="/admin/user/saveQuote" method="post" class="form-submit" autocomplete="false">
			<input type="hidden" name="id" required class="form-control" value="<?php print $id; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>Kutipan</label>
					<textarea class="form-control" required name="kutipan" rows="4"><?php print $kutipan; ?></textarea>
				</div>
				<div class="form-group">
					<label>Oleh</label>
					<input type="text" name="oleh" required class="form-control" value="<?php print $oleh; ?>" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>