<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Pembayaran Suka Duka</h5>
		</div>
		<form action="<?php print base_url('admin/user/save/'); ?>" method="post" class="form-submit" autocomplete="false">
			<div class="modal-body">
				<div class="form-group">
					<label>Username</label>
					<input type="text" name="username" required class="form-control" value="" />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" required class="form-control" value="" />
				</div>
				<hr />
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" required class="form-control" value="" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
		
		<?php
			print "<pre>";
print_r($pembayaran_item);
print "</pre>";
		?>
	</div>
</div>