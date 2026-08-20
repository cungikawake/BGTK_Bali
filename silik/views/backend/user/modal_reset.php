<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Reset Password</h5>
		</div>
		<form action="/admin/user/reset_password" method="post" class="form-submit" autocomplete="false">
			<input type="hidden" name="id" required class="form-control" value="<?php print $id; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" required class="form-control" value="" />
				</div>
				<div class="form-group">
					<label>Konfirmasi Password</label>
					<input type="password" name="confirm_password" required class="form-control" value="" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>