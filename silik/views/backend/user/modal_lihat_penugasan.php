<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Rincian Penugasan</h5>
		</div>
		
		<div class="modal-body">
			<div class="form-group">
				<label>Keterangan Tugas</label>
				<p>
					<?php
						if (!empty($penugasan["kegiatan_id"])) {
							print "".ucfirst($penugasan["tipe"])." ";
						}
					?>
					<?php print $penugasan["nama"]; ?>
				</p>
			</div>
			<hr class="mb-4 mt-4" />
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Surat Tugas</label>
						<p><a href="<?php print base_url("/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$penugasan["surat"].'?v='.rand()); ?>" target="_blank"><i class="fas fa-file-pdf" style="color: #994442;"></i> <?php print $penugasan["surat"]; ?></a></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Nomor Surat Tugas</label>
						<p><?php print $penugasan["nomor_surat"]; ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Tgl Surat Tugas</label>
						<p><?php print $this->utility->formatDateIndo($penugasan["tgl_surat"]); ?></p>
					</div>
				</div>
			</div>
			<hr class="mb-4 mt-4" />
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Tgl Mulai Tugas</label>
						<p><?php print $this->utility->formatDateIndo($tgl_mulai_tugas); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Tgl Selesai Tugas</label>
						<p><?php print $this->utility->formatDateIndo($tgl_selesai_tugas); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Lama Tugas</label>
						<p><?php print $this->utility->lama_tugas($tgl_mulai_tugas, $tgl_selesai_tugas); ?> hari</p>
					</div>
				</div>
			</div>
			<hr class="mb-4 mt-4" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Tempat Tujuan</label>
						<p><?php print $penugasanItem["tempat_tujuan"]." (".$provinsi_tujuan.", ".$kab_tujuan.")"; ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		</div>
	</div>
</div>