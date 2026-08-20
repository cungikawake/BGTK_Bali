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
			<h5 class="modal-title">Edit Detail Penugasan</h5>
		</div>
		<form action="/admin/kepegawaian/ubahDetailPenugasan" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				<?php
					$provinsis = $this->config->item('provinsi');
					$kabupatens = $this->config->item('transport_area');
				?>
				
				<div class="penugasan-main mb-0">
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Tgl Mulai Tugas</label>
								<input type="text" class="form-control tgl-mulai-tugas datepicker" name="tgl_mulai_tugas" value="<?php print date("d/m/Y", strtotime($tgl_mulai_tugas)); ?>" />
							</div>
							<div class="col-md-6">
								<label>Tgl Selesai Tugas</label>
								<input type="text" class="form-control tgl-selesai-tugas datepicker" name="tgl_selesai_tugas" value="<?php print date("d/m/Y", strtotime($tgl_selesai_tugas)); ?>" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Provinsi Asal</label>

								<select class="form-control provinsi-asal select2" name="provinsi_asal" required>
									<?php
										foreach ($provinsis as $provinsi => $provinsiKabupatens) {
											$selected = "";

											if (isset($provinsi_asal) && $provinsi_asal == $provinsi) {
												$selected = 'selected="selected"';
											}

											print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label>Kab/Kota Asal</label>
								<select class="form-control kab-asal select2" name="kab_asal" required>
									<?php
										foreach ($provinsis as $provinsi => $provinsiKabupatens) {
											if (isset($provinsi_asal) && $provinsi_asal == $provinsi) {

												foreach ($provinsiKabupatens as $kabupaten) {
													$selected = "";

													if (isset($kab_asal) && $kab_asal == $kabupaten) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$kabupaten.'" '.$selected.'>'.$kabupaten.'</option>';
												}

											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Provinsi Tujuan</label>

								<select class="form-control provinsi-tujuan select2" name="provinsi_tujuan" required>
									<?php
										foreach ($provinsis as $provinsi => $provinsiKabupatens) {
											$selected = "";

											if (isset($provinsi_tujuan) && $provinsi_tujuan == $provinsi) {
												$selected = 'selected="selected"';
											}

											print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label>Kab/Kota Tujuan</label>
								<select class="form-control kab-tujuan select2" name="kab_tujuan" required>
									<?php
										foreach ($provinsis as $provinsi => $provinsiKabupatens) {
											if (isset($provinsi_tujuan) && $provinsi_tujuan == $provinsi) {

												foreach ($provinsiKabupatens as $kabupaten) {
													$selected = "";

													if (isset($kab_tujuan) && $kab_tujuan == $kabupaten) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$kabupaten.'" '.$selected.'>'.$kabupaten.'</option>';
												}

											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>Tempat Tujuan</label>
								<textarea rows="2" required class="form-control tempat-tujuan" name="tempat_tujuan" placeholder="SMPN 1 Kupang"><?php print $tempat_tujuan; ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info" style="margin-bottom: 0;">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>