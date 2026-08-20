<div class="modal fade" id="modal-dakung" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="" class="form-dakung" enctype="multipart/form-data">
			<input type="hidden" name="kegiatan_id" value="<?php print $kegiatan_id; ?>" class="form-control" />
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Upload Data Dukung</h5>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label>Nama File</label>
						<input type="text" name="nama" class="form-control" />
					</div>
					<div class="form-group">
						<label>Jenis File</label>
						<select name="jenis" class="select2 form-control">
							<?php
								$jenis = array("Surat Keputusan", "Surat Tugas", "Surat Undangan", "Panduan", "Kerangka Acuan Kerja (KAK)", "Laporan Kegiatan", "Lainnya");

								foreach ($jenis	as $op) {
									print '<option value="'.$op.'">'.$op.'</option>';
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>File</label>
						<input type="file" name="file" class="form-control" accept="application/pdf,.doc,.docx" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info btn-submit-dakung">Upload</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</form>
	</div>
</div>