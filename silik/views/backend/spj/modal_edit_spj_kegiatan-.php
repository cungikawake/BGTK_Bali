<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">SPJ Kegiatan</h5>
		</div>
		<form action="/admin/spj/save" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>Nama Kegiatan</label>
					<select class="form-control select2 pilih-kegiatan" name="kegiatan_id" required>
						<option value="">&nbsp;</option>
						<?php
							if (isset($kegiatan) && !empty($kegiatan)) {
								foreach ($kegiatan as $keg) {
									print '<option data-tipe="'.$keg["tipe_kegiatan"].'" data-mulai="'.$keg["tgl_mulai_kegiatan"].'" data-selesai="'.$keg["tgl_selesai_kegiatan"].'" data-tempat="'.$keg["tempat_kegiatan"].'" data-kab="'.$keg["kab_tempat_kegiatan"].'" data-zoom="'.$keg["zoom_id_kegiatan"].'" data-kode="'.$keg["zoom_code_kegiatan"].'" value="'.$keg["id"].'">'.$keg["nama"].'</option>';
								}
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Tipe Kegiatan</label>
					<input type="text" disabled class="form-control tipe-kegiatan" value="" />
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Tgl Mulai Kegiatan</label>
							<input type="text" disabled class="form-control tgl-mulai-kegiatan" value="" />
						</div>
						<div class="col-md-6">
							<label>Tgl Selesai Kegiatan</label>
							<input type="text" disabled class="form-control tgl-selesai-kegiatan" value="" />
						</div>
					</div>
				</div>
				
				<?php
					$daringForm = "";
					$luringForm = "";
				
					if(isset($tipe_kegiatan) && $tipe_kegiatan == "Luring") {
						$daringForm = "display:none;";
					}
					else {
						$luringForm = "display:none;";
					}
				?>
				
				<div class="form-group luring-form" style="<?php print $luringForm; ?>">
					<label>Tempat</label>
					<input type="text" disabled class="form-control tempat-kegiatan" value="" />
				</div>
				<div class="form-group luring-form" style="<?php print $luringForm; ?>">
					<label>Tempat (Kabupaten)</label>
					<input type="text" disabled class="form-control kab-kegiatan" value="" />
				</div>
				<div class="form-group daring-form" style="<?php print $daringForm; ?>">
					<div class="row">
						<div class="col-md-6">
							<label>Zoom ID</label>
							<input type="text" disabled class="form-control zoom-kegiatan" value="" />
						</div>
						<div class="col-md-6">
							<label>Zoom Passcode</label>
							<input type="text" disabled class="form-control zoom-kode-kegiatan" value="" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Buat SPJ Kegiatan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('.pilih-kegiatan').change(function () {
			var selected = $(".pilih-kegiatan").select2().find(":selected");
			var tipe = selected.data("tipe");
			var tgl_mulai = selected.data("mulai");
			var tgl_selesai = selected.data("selesai");
			var tempat = selected.data("tempat");
			var kab = selected.data("kab");
			var zoom = selected.data("zoom");
			var kode = selected.data("kode");
			
			$('.daring-form').hide();
			$('.luring-form').hide();

			if (tipe == "Daring") {
				$('.daring-form').show();
			}
			else {
				$('.luring-form').show();
			}
			
			$('.tipe-kegiatan').val(tipe);
			$('.tgl-mulai-kegiatan').val(tgl_mulai);
			$('.tgl-selesai-kegiatan').val(tgl_selesai);
			$('.tempat-kegiatan').val(tempat);
			$('.kab-kegiatan').val(kab);
			$('.zoom-kegiatan').val(zoom);
			$('.zoom-kode-kegiatan').val(kode);
		});
	});
</script>