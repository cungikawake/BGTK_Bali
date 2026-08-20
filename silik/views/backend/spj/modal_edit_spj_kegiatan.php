<div class="modal fade" id="add-spj-modal" role="dialog" aria-hidden="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Buat SPJ Kegiatan</h5>
			</div>
			<form method="post" class="form-spj">
				<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>">
				<div class="modal-body">
					<div class="opt-kegiatan">
						<div class="form-group">
							<label>Pilih Kegiatan</label>
							<select class="form-control select2-kegiatan" name="kegiatan_id" data-selected-kegiatan="<?php print isset($kegiatan_id) ? $kegiatan_id : ""; ?>"></select>
						</div>
					</div>
					<div class="form-group">
						<label>Nama SPJ Keuangan</label>
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