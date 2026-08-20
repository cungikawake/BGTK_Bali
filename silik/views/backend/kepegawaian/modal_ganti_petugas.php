<style type="text/css">
	.modal-body {
		background: #f1f1f1;
	}
	.penugasan-main, .penugasan-st {
		border: 1px solid #ccc;
		padding: 15px;
		margin-bottom: 15px;
		box-shadow: #ccc 0px 1px 5px;
		background: #fff;
	}
</style>
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Ganti Penugasan</h5>
		</div>
		<form action="/admin/kepegawaian/ganti_petugas" method="post" class="form-ganti-petugas" autocomplete="off">
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				
				<div class="penugasan-st">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Nomor Surat Tugas</label>
								<input type="text" name="nomor_surat" required class="form-control" value="<?php print isset($nomor_surat) ? $nomor_surat : ""; ?>" />
							</div>
							<div class="col-md-6">
								<?php
									$tglShow = "";
									if (isset($tgl_surat) && !empty($tgl_surat)) {
										$tglShow = date("d/m/Y", strtotime($tgl_surat));
									}
								?>
								<label>Tgl Surat Tugas</label>
								<input type="text" name="tgl_surat" required class="form-control datepicker" value="<?php print $tglShow; ?>" />
							</div>
						</div>
					</div>
					<div class="form-group mb-0">
						<div class="row">
							<div class="col-md-12">
								<label>Upload Surat Tugas (.pdf - max 5 Mb)</label>
								<input type="file" accept="application/pdf" required name="surat_tugas" class="form-control surat-tugas-baru" />
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="penugasan-main">
					<div class="form-group">
						<label>Petugas Lama</label>
						<input type="text" class="form-control nama-petugas-lama" value="<?php print $nama; ?>" disabled />
					</div>
					<div class="form-group">
						<label>Petugas Pengganti</label>
						<select name="biodata_id" class="form-control nama-petugas-baru select2">
							<?php
								if (isset($petugas) && !empty($petugas)) {
									foreach ($petugas as $pet) {
										print '<option value="'.$pet["id"].'">'.$pet["nama"].'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit-penugasan" style="margin-bottom: 0;">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>