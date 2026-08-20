<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">BIODATA</h5>
		</div>
		
		<?php
			$disable = 'disabled="disabled"';
		
			if (isset($id) && !empty($id)) {
				$disable = '';
			}
		?>
		
		<form action="/admin/biodata/save" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>NIK</label>
					<input type="text" name="ktp" readonly class="form-control" value="<?php print isset($ktp) ? $ktp : ""; ?>" style="background-color:#FDE9F1;" />
					<div class="notif-nik alert" style="margin-top: 10px; padding:5px 10px; display: none;"></div>
				</div>
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" name="nama" readonly required <?php print $disable; ?> class="form-control" value="<?php print isset($nama) ? $nama : ""; ?>" />
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>NIP</label>
							<input type="text" name="nip" readonly <?php print $disable; ?> class="form-control" value="<?php print isset($nip) ? $nip : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Jabatan</label>
							<input type="text" name="jabatan" readonly <?php print $disable; ?> class="form-control" value="<?php print isset($jabatan) ? $jabatan : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Golongan</label>
							<input type="text" name="golongan" class="form-control" readonly value="<?php print isset($golongan) ? $golongan : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Pangkat</label>
							<input type="text" name="pangkat" class="form-control" readonly value="<?php print isset($pangkat) ? $pangkat : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Tempat Lahir</label>
							<input type="text" name="tempat_lahir" readonly required class="form-control" value="<?php print isset($tempat_lahir) ? $tempat_lahir : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Tgl Lahir</label>
							<input type="text" name="tgl_lahir" readonly required class="form-control datepicker" value="<?php print isset($tgl_lahir) ? date("d/m/Y", strtotime($tgl_lahir)) : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Jenis Kelamin</label>
							<input type="text" name="jenis_kelamin" readonly required class="form-control" value="<?php print isset($jenis_kelamin) ? $jenis_kelamin : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>NPWP</label>
							<input type="text" name="npwp" readonly class="form-control" value="<?php print isset($npwp) ? $npwp : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Telp/Hp</label>
							<input type="text" name="telp" readonly required class="form-control" value="<?php print isset($telp) ? $telp : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Email</label>
							<input type="text" name="email" readonly class="form-control" value="<?php print isset($email) ? $email : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Alamat Rumah</label>
					<textarea name="alamat_tinggal" readonly class="form-control"><?php print isset($alamat_tinggal) ? $alamat_tinggal : ""; ?></textarea>
				</div>
				<hr />
				
				
				<div id="accordion2">
					<div class="card" style="margin-bottom: 10px;">
						<div class="btn btn-info" id="headSatker1" style="padding:15px 20px; margin:0; text-align: left;">
							<a href="javascript:;" data-toggle="collapse" data-target="#collapseSatker1" aria-expanded="true" aria-controls="collapseSatker1" style="color:#fff; text-decoration: none;">
							  	<strong style="font-weight: 700;">Unit Kerja</strong>
							</a>
						</div>

						<div id="collapseSatker1" class="collapse in" aria-labelledby="headSatker1" data-parent="#accordion2">
						  <div class="card-body" style="padding: 20px 25px 10px;">
								<div class="form-group">
									<label>Unit Kerja/Sekolah</label>
									<input type="text" name="unit_kerja" readonly class="form-control" value="<?php print isset($unit_kerja) ? $unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
								</div>
								<div class="form-group">
									<label>Telp Unit Kerja/Sekolah</label>
									<input type="text" name="telp_unit_kerja" readonly class="form-control" value="<?php print isset($telp_unit_kerja) ? $telp_unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
								</div>
							  	<div class="form-group">
									<label>Kabupaten/Kota Unit Kerja/Sekolah</label>
									<input type="text" name="kab_unit_kerja" readonly class="form-control" value="<?php print isset($kab_unit_kerja) ? $kab_unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
								</div>
								<div class="row">
							  		<div class="col-md-6">
										<div class="form-group">
											<label>Provinsi Unit Kerja/Sekolah</label>
											<input type="text" name="provinsi_unit_kerja" readonly class="form-control" value="<?php print isset($provinsi_unit_kerja) ? $provinsi_unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Kab/Kota Unit Kerja/Sekolah</label>
											<input type="text" name="kab_unit_kerja" readonly class="form-control" value="<?php print isset($kab_unit_kerja) ? $kab_unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
										</div>
									</div>
							  	</div>
								<div class="form-group">
									<label>Alamat Unit Kerja/Sekolah</label>
									<textarea name="alamat_unit_kerja" readonly class="form-control" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?>><?php print isset($alamat_unit_kerja) ? $alamat_unit_kerja : ""; ?></textarea>
								</div>
						  </div>
						</div>
				  	</div>
					
				<hr />
				<div id="accordion">
					<div class="card" style="margin-bottom: 10px;">
						<div class="btn btn-secondary" id="headingOne" style="padding:15px 20px; margin:0; text-align: left;">
							<a href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#fff; text-decoration: none;">
								<strong style="font-weight: 700;">Akun Bank</strong>
							</a>
						</div>

						<div id="collapseOne" class="collapse in" aria-labelledby="headingOne" data-parent="#accordion">
						  <div class="card-body" style="padding: 20px 25px 10px;">
							<div class="form-group">
								<label>Nama Bank</label>
								<input type="text" readonly name="nama_bank" class="form-control" value="<?php print isset($nama_bank) ? $nama_bank : ""; ?>" />
							</div>
							<div class="form-group">
								<label>Nama Pemilik Rekening</label>
								<input type="text" readonly name="nama_pemilik_rekening" class="form-control" value="<?php print isset($nama_pemilik_rekening) ? $nama_pemilik_rekening : ""; ?>" />
							</div>
							<div class="form-group">
								<label>Nomor Rekening</label>
								<input type="text" readonly name="no_rekening" class="form-control" value="<?php print isset($no_rekening) ? $no_rekening : ""; ?>" />
							</div>
						  </div>
						</div>
				  	</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</form>
	</div>
</div>