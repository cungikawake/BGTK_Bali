<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title" style="text-align: center;">Mengubah status tiket menjadi "Selesai"?</h5>
		</div>
		<div class="modal-body" style="text-align: center;">
			<div class="form-group">
				Tiket dengan status "Selesai" tidak akan bisa ditindaklanjuti kembali.
			</div>
			<div class="form-group" id="rating">
				<label for="rating">Mohon memberikan penilaian terhadapt layanan kami</label>
			</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" name="tiket_id" value="<?php print $tiket_id; ?>" />
			<input type="hidden" name="rating" value="" />
			<button type="button" class="btn btn-info btn-modal-save-rating">Lanjutkan</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		</div>
	</div>
</div>