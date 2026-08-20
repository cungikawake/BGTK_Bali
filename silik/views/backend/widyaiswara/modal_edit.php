<?php
	$this->load->model("biodata_model");
	$pegawaiBalai = $this->biodata_model->getBiodataByPegawaiBalai();
?>
<style type="text/css">
	.detail-tgl-kegiatan, .add-detail-tgl-kegiatan {
		display: inline-block;
		margin: 5px 0 0;
	}
	.form-detail-tgl-kegiatan + .form-detail-tgl-kegiatan {
		margin-top: 10px;
	}
	.input-group>:not(:first-child) {
		margin-left: -1px;
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
	}
	.input-group.form-detail-tgl-kegiatan .input-group-text {
		padding: 0;
		display: block;
	}
	.input-group.form-detail-tgl-kegiatan .del-detail-tgl-kegiatan {
		display: block;
		padding: 9px 15px;
	}
	.input-group.form-detail-tgl-kegiatan .del-detail-tgl-kegiatan i {
		font-size: 16px;
	}
</style>
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">KEGIATAN</h5>
		</div>
		<form class="submit-laporan-wi" method="post" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="id" required class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>Nama Kegiatan</label>
					<input type="text" name="judul" placeholder="Pelatihan Pembelajaran Mendalam bagi Guru" required class="form-control" value="<?php print isset($judul) ? htmlspecialchars($judul) : ""; ?>" />
				</div>

				<div class="form-group">
					<label>Tipe Kegiatan</label>
					<select class="form-control select2" name="tipe_kegiatan">
						<?php 
							$configWi = $this->config->item("tipe_kegiatan_wi");

							foreach ($configWi as $tipeKey => $tipeValue) {
								$selected = "";

								if (isset($tipe_kegiatan) && $tipe_kegiatan == "$tipeKey") {
									$selected = 'selected="selected"';
								}

								print '<option value="'.$tipeKey.'" '.$selected.'>'.$tipeValue.'</option>';
							}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Tgl Mulai Kegiatan</label>
							<input type="text" name="tgl_mulai_kegiatan" required class="form-control datepicker" value="<?php print isset($tgl_mulai_kegiatan) ? date("d/m/Y", strtotime($tgl_mulai_kegiatan)) : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Tgl Selesai Kegiatan</label>
							<input type="text" name="tgl_selesai_kegiatan" required class="form-control datepicker" value="<?php print isset($tgl_selesai_kegiatan) ? date("d/m/Y", strtotime($tgl_selesai_kegiatan)) : ""; ?>" />
						</div>
					</div>
				</div>

				<?php
					$showLokasiKegiatan = "show";
					if (isset($tipe_kegiatan) && $tipe_kegiatan == "konversi") {
						$showLokasiKegiatan = "hide";
					}
				?>

				<div class="form-group form-lokasi-kegiatan <?php print $showLokasiKegiatan; ?>">
					<div class="row">
						<div class="col-md-6">
							<label>Tempat</label>
							<input type="text" name="tempat_kegiatan" placeholder="SD Negeri 3 Buleleng" class="form-control" value="<?php print isset($tempat_kegiatan) ? $tempat_kegiatan : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Kab/Kota</label>
							<select name="kab_tempat_kegiatan"  class="form-control select2">
								<option value="">&nbsp;</option>
								<?php
									foreach ($this->config->item("provinsi") as $provinsi => $kabs) {

										if ($provinsi == "Bali") {
											
											foreach ($kabs as $kab) {
												$selected = "";
												
												if (isset($kab_tempat_kegiatan) && $kab == $kab_tempat_kegiatan) {
													$selected = 'selected="selected"';
												}
												
												print '<option value="'.$kab.'" '.$selected.'>'.$kab.'</option>';
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
							<label>Jumlah JP</label>
							<input type="text" name="jam_pelajaran" required class="form-control" value="<?php print isset($jam_pelajaran) ? $jam_pelajaran : ""; ?>" />
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Dokumen Bukti (Google Drive File Link)</label>
					<textarea name="dokumen_link" class="form-control" rows="5"><?php print isset($dokumen_link) ? $dokumen_link : ""; ?></textarea>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info" value="simpan" name="submit_btn">Simpan</button>
				<button type="submit" class="btn btn-danger" value="validasi" name="submit_btn">Kirim Validasi</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('select[name="tipe_kegiatan"]').change(function () {
			var tipeKegiatan = $(this).val();

			if (tipeKegiatan == "konversi") {
				$('.form-lokasi-kegiatan').removeClass("show").addClass("hide");
			}
			else {
				$('.form-lokasi-kegiatan').removeClass("hide").addClass("show");
			}
		});
	});
</script>