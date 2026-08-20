<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Buat Laporan Perjalanan Dinas</h5>
		</div>
		
		<form class="submit-laporan" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php print $id; ?>" />
			
			<div class="modal-body" style="background: #f4f7fa;">

				<div class="card" style="margin-bottom: 15px;">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Rincian Tugas</h5>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label>Keterangan Tugas</label>
							<p><?php print $penugasan["nama"]; ?></p>
						</div>
						<hr class="mb-3 mt-3" />
						<div class="row">
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Surat Tugas</label>
									<p class="mb-0"><a href="<?php print base_url("/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/penugasan/".$surat_tugas."?v=".rand()); ?>" target="_blank"><i class="fas fa-file-pdf" style="color: #994442;"></i> <?php print $surat_tugas; ?></a></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Nomor Surat Tugas</label>
									<p class="mb-0"><?php print $penugasan["nomor_surat"]; ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Tgl Surat Tugas</label>
									<p class="mb-0"><?php print $this->utility->formatDateIndo($penugasan["tgl_surat"]); ?></p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-3" />
						<div class="row">
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Tgl Mulai Tugas</label>
									<p class="mb-0"><?php print $this->utility->formatDateIndo($tgl_mulai_tugas); ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Tgl Selesai Tugas</label>
									<p class="mb-0"><?php print $this->utility->formatDateIndo($tgl_selesai_tugas); ?></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Lama Tugas</label>
									<p class="mb-0"><?php print $this->utility->lama_tugas($tgl_mulai_tugas, $tgl_selesai_tugas); ?> hari</p>
								</div>
							</div>
						</div>
						<hr class="mb-3 mt-3" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-0">
									<label>Tempat Tujuan</label>
									<p class="mb-0"><?php print $tempat_tujuan." (".$provinsi_tujuan.", ".$kab_tujuan.")"; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card" style="margin-bottom: 15px;">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>SPD (Surat Perjalanan Dinas)</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Jabatan Penandatangan SPD</label>
									<input type="text" name="spd_jabatan" placeholder="Kepala Sekolah" class="form-control" value="<?php print $spd_jabatan; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Instansi Penandatangan SPD</label>
									<input type="text" name="spd_satker" placeholder="SDN 2 Abang" class="form-control" value="<?php print $spd_satker; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Pejabat Penandatangan SPD</label>
									<input type="text" name="spd_nama" placeholder="I Wayan Murti, S.Pd" class="form-control" value="<?php print $spd_nama; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>NIP Pejabat Penandatangan SPD</label>
									<input type="text" name="spd_nip" placeholder="197412031991021005" class="form-control" value="<?php print $spd_nip; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-0">
									<label>Tanda Tangan dan Stempel <span style="font-weight: 400; font-size:12px;">(Hapus bg <a href="https://remove.bg" target="_blank">https://remove.bg</a>)</span></label>
									<?php
										$required = 'required';
										if (isset($spd_cap) && !empty($spd_cap)) {
											$required = '';
											print '<div class="file-foto"><a href="'.base_url('/assets/laporan_perjadin/'.$_SESSION["tahun_anggaran"]."/".$id.'/'.$spd_cap."?v=".rand()).'" target="_blank"><i class="fas fa-image"></i> '.ucfirst($spd_cap).'</a></div>';
										}
									?>
									<input type="file" name="stamp" class="form-control stamp-satker" accept="image/png" name="foto[]" />
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="card" style="margin-bottom: 15px;">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Laporan Perjalanan Dinas</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Pelaksanaan Kegiatan</label>
									<textarea class="laporan-perjadin" name="laporan_tugas"><?php print $laporan_tugas; ?></textarea>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Hasil Kegiatan</label>
									<textarea class="laporan-perjadin" name="laporan_hasil"><?php print $laporan_hasil; ?></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label>Dokumentasi Tugas (jpg, jpeg, png) Max 2Mb - 2 Foto</label>
							</div>
							<?php
								if (isset($laporan_foto) && !empty($laporan_foto)) {
									$laporan_foto = json_decode($laporan_foto, true);
								}
							?>
							<div class="col-md-6">
								<div class="form-group mb-0">
									<?php
										$required = 'required';
										if (isset($laporan_foto[0]) && !empty($laporan_foto[0])) {
											$required = '';
											print '<div class="file-foto"><a href="'.base_url('/assets/laporan_perjadin/'.$_SESSION["tahun_anggaran"]."/".$id.'/'.$laporan_foto[0]."?v=".rand()).'" target="_blank"><i class="fas fa-image"></i> '.ucfirst($laporan_foto[0]).'</a></div>';
										}
									?>
									<input type="file" class="form-control foto-lap-1" <?php print $required; ?> accept="image/jpeg" name="foto[0]" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-0">
									<?php
										$required = 'required';
										if (isset($laporan_foto[1]) && !empty($laporan_foto[1])) {
											$required = '';
											print '<div class="file-foto"><a href="'.base_url('/assets/laporan_perjadin/'.$_SESSION["tahun_anggaran"]."/".$id.'/'.$laporan_foto[1]."?v=".rand()).'" target="_blank"><i class="fas fa-image"></i> '.ucfirst($laporan_foto[1]).'</a></div>';
										}
									?>
									<input type="file" class="form-control foto-lap-2" <?php print $required; ?> accept="image/jpeg" name="foto[1]" />
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="card" style="margin-bottom: 0;">
					<div class="card-header" style="padding: 10px 25px;">
						<h5>Bukti Pengeluaran</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<label>Tiket Pesawat, Taksi, Bill Hotel, Tiket Boat dll (pdf) - Max 5 Mb</label>
							</div>
							<div class="col-md-6">
								<?php
									$buktiPath = APPPATH . "../assets/laporan_perjadin/".$_SESSION["tahun_anggaran"]."/".$id."/bukti_pengeluaran.pdf";
						
									if (file_exists($buktiPath)) {
										print '<div class="file-foto"><a href="'.base_url('/assets/laporan_perjadin/'.$_SESSION["tahun_anggaran"]."/".$id.'/bukti_pengeluaran.pdf?v='.rand()).'" target="_blank"><i class="far fa-file-pdf"></i> Bukti_pengeluaran.pdf</a></div>';
									}
								?>
								
								<div class="form-group mb-0">
									<input type="file" class="form-control bukti-pengeluaran" accept="application/pdf" name="bukti_pengeluaran" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="submit_btn" value="" />
				<?php if ($status <= 1 || $status == 4) { ?>
					<button type="submit" class="btn btn-submit btn-info mb-0" data-submit="simpan">Simpan</button>
				<?php } ?>
				
				<?php if ($status <= 1 || $status == 4) { ?>
				<button type="submit" class="btn btn-submit btn-danger mb-0" data-submit="validasi">Kirim Validasi</button>
				<?php } ?>
				
				<button type="button" class="btn btn-secondary mb-0 mr-0" data-dismiss="modal">Batal</button>			
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		tinymce.init({
			selector: 'textarea.laporan-perjadin',
			height: 350,
			plugins: [
				'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
				'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'wordcount', 'paste'
			],
			menubar:false,
			statusbar: false,
			toolbar: 'undo redo | ' +
				'bold italic | alignleft aligncenter ' +
				'alignright alignjustify | bullist numlist outdent indent',
			content_style: 'body { background:#f0f0f0; font-family:Helvetica,Arial,sans-serif; font-size:16px }',
			paste_as_text: true
		});
	});
</script>