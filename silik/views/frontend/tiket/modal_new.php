<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Tiket Baru</h5>
		</div>
		<form action="<?php print base_url('/tiket/saveNew/'); ?>" method="post" class="form-submit" autocomplete="false">
			<div class="modal-body">
				<div class="form-group">
					<label>Judul</label>
					<input type="text" name="judul" required class="form-control new-tiket-judul" value="" />
				</div>
				<div class="form-group">
					<label>Deskripsi</label>
					<textarea name="deskripsi" required class="form-control new-tiket-des" rows="10"></textarea>
				</div>
				<div class="form-group">
					<a href="javascript:;" class="toggle-new-tiket-file"><i class="fas fa-paperclip"></i> Attach File</a>
					<div class="new-tiket-file" style="display: none;">
						<div class="dropzone dropzone-new-tiket"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	Tiket.dropzoneNewTiket();
	$('.toggle-new-tiket-file').click(function () {
		$('.new-tiket-file').slideToggle('fast');
	});
</script>