<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Approve Laporan Widyaiswara</h5>
		</div>
		
		<form action="<?php print base_url("/admin/widyaiswara/approve_laporan"); ?>" method="post" class="form-submit">
			<input type="hidden" value="<?php print $id; ?>" name="id" />
			<input type="hidden" name="status" value="3" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Rincian</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Nama Petugas</label>
									<p><?php print $widyaiswara["nama"]; ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Golongan, Pangkat</label>
									<p><?php print $widyaiswara["golongan"].", ".$widyaiswara["pangkat"]; ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Jabatan</label>
									<p><?php print $widyaiswara["jabatan"]; ?></p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0" />
						<div class="form-group">
							<label>Keterangan Fasilitasi</label>
							<p>
								<?php
									if (!empty($judul)) {
										print "".ucfirst($judul)." ";
									}
								?>
								<?php print $penugasan["nama"]; ?>
							</p>
						</div>
						<hr class="mb-3 mt-0" />
						
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Tgl Mulai Tugas</label>
									<p><?php print $this->utility->formatDateIndo($tgl_mulai_kegiatan); ?></p>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Tgl Selesai Tugas</label>
									<p><?php print $this->utility->formatDateIndo($tgl_selesai_kegiatan); ?></p>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Lama Tugas</label>
									<p><?php print $this->utility->lama_tugas($tgl_mulai_kegiatan, $tgl_selesai_kegiatan); ?> hari</p>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Jumlah JP</label>
									<p><?php print $jam_pelajaran; ?> Jp</p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-0" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-0">
									<label>Tempat</label>
									<p class="mb-0"><?php print $tempat_kegiatan." (".$kab_tempat_kegiatan.")"; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="card">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Laporan Fasilitasi</h5>
					</div>
					<div class="card-body">
						<div class="form-group mb-0">
							<div class="iframe-laporan">
								<?php

									$buktiPath = "assets/laporan_wi/".$_SESSION["tahun_anggaran"]."/".$id."/bukti_dokumen.pdf";
								
									if (file_exists(APPPATH . "../".$buktiPath)) {
								?>
										<iframe src="<?php print base_url($buktiPath); ?>?v=<?php print rand(); ?>"></iframe>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary mb-0 approve-laporan">Setuju</button>
				<button type="button" class="btn btn-danger tolak-laporan" data-id="<?php print $id; ?>">Tolak</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>