<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Import <?php print ucfirst(str_replace("_"," ",$komponen)); ?></h5>
		</div>
		
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger mb-0" role="alert">
						<h5 class="alert-heading"><i class="feather icon-alert-octagon me-2"></i> Perhatian</h5>
						
						<?php
							if (isset($kegiatan_id) && !empty($kegiatan_id)) {
						?>
							<p class="mb-2">Proses import akan mengambil data <b><?php print str_replace("_"," ",$komponen); ?></b> dari kegiatan <b>"<?php print $kegiatan["nama"]; ?>"</b>.</p>
						<?php
							} else {
						?>
							<p class="mb-2">Proses import akan mengambil data <b><?php print str_replace("_"," ",$komponen); ?></b> dari penugasan <b>"<?php print $penugasan["nama"]; ?>"</b>.</p>
						<?php
							}
						?>
					</div>

					<?php
						if (isset($kegiatan_id) && !empty($kegiatan_id)) {
					?>
						<div class="form-group" style="margin-top:10px;">
							<label>Urutkan Data Berdasarkan:</label>
							<select name="order" class="form-control select2">
								<option value="pendaftaran">Waktu Pendaftaran</option>
								<option value="kabupaten">Kabupaten</option>
								<option value="kategori">Kategori</option>
							</select>
						</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-import-data-spj" data-spj="<?php print $spj_id; ?>">Lanjutkan</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		</div>
	</div>
</div>