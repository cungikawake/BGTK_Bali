<style type="text/css">
	@media (min-width: 768px) {
		#modal-scan-barcode .modal-dialog {
			width: 900px;
		}
	}
	#terima-scan-laporan:focus {
		border: 1px solid #000;
	}
</style>
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Laporan Perjalanan Dinas</h5>
		</div>
		
		<?php
			if (isset($penugasan_item)) {
				if ($penugasan_item["status"] == "3") {
		?>
					<div class="modal-body">
						<div class="form-group">
							<label>Nama Petugas</label>
							<p>
								<?php print $penugasan_item["nama"]; ?>
							</p>
						</div>
						<hr class="mb-4 mt-4" />
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
									<p><a href="<?php print base_url("/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$penugasan["surat"]); ?>" target="_blank"><i class="fas fa-file-pdf" style="color: #994442;"></i> <?php print $penugasan["surat"]; ?></a></p>
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
									<p><?php print $this->utility->formatDateIndo($penugasan_item["tgl_mulai_tugas"]); ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tgl Selesai Tugas</label>
									<p><?php print $this->utility->formatDateIndo($penugasan_item["tgl_selesai_tugas"]); ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Lama Tugas</label>
									<p><?php print $this->utility->lama_tugas($penugasan_item["tgl_mulai_tugas"], $penugasan_item["tgl_selesai_tugas"]); ?> hari</p>
								</div>
							</div>
						</div>
						<hr class="mb-4 mt-4" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Tempat Tujuan</label>
									<p><?php print $penugasan_item["tempat_tujuan"]." (".$penugasan_item["provinsi_tujuan"].", ".$penugasan_item["kab_tujuan"].")"; ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-spj-item-id="<?php print $spj_item["id"]; ?>" id="terima-scan-laporan">Terima Laporan</button>
						<button type="button" class="btn btn-secondary btn-close-terima-perjadin" data-dismiss="modal">Tutup</button>
					</div>
		<?php
				}
				else if ($penugasan_item["status"] == "5") {
		?>
					<div class="modal-body">
						<div class="alert alert-success">
							<b>Laporan Perjalanan Dinas Sudah Diterima dan Menunggu Pembayaran</b>
						</div>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary btn-close-terima-perjadin" data-dismiss="modal">Tutup</button>
					</div>
		<?php
				}
				else if ($penugasan_item["status"] == "6") {
		?>
					<div class="modal-body">
						<div class="alert alert-success">
							<b>Laporan Perjalanan Dinas Sudah Terbayarkan.</b>
						</div>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary btn-close-terima-perjadin" data-dismiss="modal">Tutup</button>
					</div>
		<?php
				}
				else {
		?>
					<div class="modal-body">
						<div class="alert alert-danger">
							<b>Laporan Perjalanan Dinas Belum Disetujui.</b>
						</div>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary btn-close-terima-perjadin" data-dismiss="modal">Tutup</button>
					</div>
		<?php
				}
			}
			else {
		?>
				<div class="modal-body">
					<div class="alert alert-danger">
						<b>Laporan Perjalanan Dinas Tidak Ditemukan atau Kesalahan Input Barcode. <br/>Silahkan Scan Ulang Barcode Laporan.</b>
					</div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-close-terima-perjadin" data-dismiss="modal">Tutup</button>
				</div>
		<?php
			}
		?>
	</div>
</div>