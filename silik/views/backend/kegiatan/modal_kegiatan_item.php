<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title"><?php print strtoupper($unsur); ?></h5>
		</div>
		
		<?php
			$disable = 'disabled="disabled"';
		
			if (isset($id) && !empty($id)) {
				$disable = '';
			}
		?>
		
		<form action="/admin/kegiatan/save_item" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="table_komponen" class="form-control" value="<?php print $table; ?>" />
			<input type="hidden" name="code_komponen" class="form-control" value="<?php print $code_komponen; ?>" />
			<input type="hidden" name="unsur" class="form-control" value="<?php print $unsur; ?>" />
			<input type="hidden" name="kegiatan_id" class="form-control" value="<?php print isset($parentId) ? $parentId : ""; ?>" />
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>NIK</label>
					<input type="text" name="ktp" class="form-control" value="<?php print isset($ktp) ? $ktp : ""; ?>" style="background-color:#FDE9F1;" />
					<div class="notif-nik alert" style="margin-top: 10px; padding:5px 10px; display: none;"></div>
				</div>
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" name="nama" required <?php print $disable; ?> class="form-control" value="<?php print isset($nama) ? $nama : ""; ?>" />
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>NIP</label>
							<input type="text" name="nip" <?php print $disable; ?> class="form-control" value="<?php print isset($nip) ? $nip : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Jabatan</label>
							<input type="text" name="jabatan" <?php print $disable; ?> class="form-control" value="<?php print isset($jabatan) ? $jabatan : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Golongan</label>
							<select name="golongan" <?php print $disable; ?> class="form-control select2">
								<option value=""></option>
								
								<?php
									$options = $this->config->item("golongan_pangkat");
									$valSelected = isset($golongan) ? $golongan : "";
								
									foreach ($options as $gol => $pang) {
										$selected = '';
										
										if ($valSelected == $gol) {
											$selected = 'selected="selected"';
										}
										
										print '<option value="'.$gol.'" data-pangkat="'.$pang.'" '.$selected.'>'.$gol.'</option>';
									}
								?>
							</select>
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
							<input type="text" name="tempat_lahir" <?php print $disable; ?> required class="form-control" value="<?php print isset($tempat_lahir) ? $tempat_lahir : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Tgl Lahir</label>
							<input type="text" name="tgl_lahir" <?php print $disable; ?> required class="form-control datepicker" value="<?php print isset($tgl_lahir) ? date("d/m/Y", strtotime($tgl_lahir)) : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Jenis Kelamin</label>
							<select name="jenis_kelamin" <?php print $disable; ?> class="form-control select2">
								<option value=""></option>
								
								<?php
									$options = array("Laki-laki"=>"Laki-laki", "Perempuan" => "Perempuan");
									$valSelected = isset($jenis_kelamin) ? $jenis_kelamin : "";
								
									foreach ($options as $jk => $jkVal) {
										$selected = '';
										
										if ($valSelected == $jk) {
											$selected = 'selected="selected"';
										}
										
										print '<option value="'.$jk.'" '.$selected.'>'.$jk.'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-md-6">
							<label>Status PTKP</label>
							<select name="ptkp" <?php print $disable; ?> class="form-control select2">
								<option value=""></option>
								
								<?php
									$options = $this->config->item("status_ptkp");
									$valSelected = isset($ptkp) ? $ptkp : "";
								
									foreach ($options as $gol => $pang) {
										$selected = '';
										
										if ($valSelected == $gol) {
											$selected = 'selected="selected"';
										}
										
										print '<option value="'.$gol.'" '.$selected.'>'.$pang.'</option>';
									}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Telp/Hp</label>
							<input type="text" name="telp" <?php print $disable; ?> required class="form-control" value="<?php print isset($telp) ? $telp : ""; ?>" />
						</div>
						<div class="col-md-6">
							<label>Email</label>
							<input type="text" name="email" <?php print $disable; ?> class="form-control" value="<?php print isset($email) ? $email : ""; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Alamat Rumah</label>
					<textarea name="alamat_tinggal" <?php print $disable; ?> class="form-control"><?php print isset($alamat_tinggal) ? $alamat_tinggal : ""; ?></textarea>
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
									<input type="text" name="unit_kerja" <?php print $disable; ?> class="form-control" value="<?php print isset($unit_kerja) ? $unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
								</div>
								<div class="row">
							  		<div class="col-md-6">
										<div class="form-group">
											<label>Nomor Pokok Sekolah Nasional</label>
											<input type="text" name="npsn" <?php print $disable; ?> class="form-control" value="<?php print isset($npsn) ? $npsn : ""; ?>" />
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Telp Unit Kerja/Sekolah</label>
											<input type="text" name="telp_unit_kerja" <?php print $disable; ?> class="form-control" value="<?php print isset($telp_unit_kerja) ? $telp_unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
										</div>
									</div>
								</div>
								
							  	<div class="row">
							  		<div class="col-md-6">
										<div class="form-group">
											<label>Provinsi Unit Kerja/Sekolah</label>
											<select name="provinsi_unit_kerja" <?php print $disable; ?> class="form-control select2" required>
												<option value="">&nbsp;</option>
												<?php
													if (in_array($kab_unit_kerja, array("Badung","Bangli", "Buleleng", "Gianyar", "Tabanan", "Karangasem", "Klungkung", "Jembrana","Denpasar"))) {
														$provinsi_unit_kerja = "Bali";
													}
												
													foreach ($this->config->item("provinsi") as $provinsi => $kabs) {
														$selected = "";

														if (isset($provinsi_unit_kerja) && $provinsi == $provinsi_unit_kerja) {
															$selected = 'selected="selected"';
														}

														print '<option value="'.$provinsi.'" '.$selected.'>'.$provinsi.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Kab/Kota Unit Kerja/Sekolah</label>
											<select name="kab_unit_kerja" <?php print $disable; ?> class="form-control select2" required>
												<option value="">&nbsp;</option>
												<?php
													foreach ($this->config->item("provinsi") as $provinsi => $kabs) {

														if (isset($provinsi_unit_kerja) && $provinsi == $provinsi_unit_kerja) {
															
															foreach ($kabs as $kab) {
																$selected = "";
																
																if (isset($kab_unit_kerja) && $kab == $kab_unit_kerja) {
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
									<label>Alamat Unit Kerja/Sekolah</label>
									<textarea name="alamat_unit_kerja" <?php print $disable; ?> class="form-control" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?>><?php print isset($alamat_unit_kerja) ? $alamat_unit_kerja : ""; ?></textarea>
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
								<select name="nama_bank" <?php print $disable; ?> class="form-control select2">
									<option value="">&nbsp;</option>
									<?php
										foreach ($this->config->item("bank") as $bankOpsi) {
											$selected = "";

											if (isset($nama_bank) && $bankOpsi == $nama_bank) {
												$selected = 'selected="selected"';
											}

											print '<option value="'.$bankOpsi.'" '.$selected.'>'.$bankOpsi.'</option>';
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label>Nama Pemilik Rekening</label>
								<input type="text" <?php print $disable; ?> name="nama_pemilik_rekening" class="form-control" value="<?php print isset($nama_pemilik_rekening) ? $nama_pemilik_rekening : ""; ?>" />
							</div>
							<div class="form-group">
								<label>Nomor Rekening</label>
								<input type="text" <?php print $disable; ?> name="no_rekening" class="form-control" value="<?php print isset($no_rekening) ? $no_rekening : ""; ?>" />
							</div>
						  </div>
						</div>
				  	</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php if(isset($_POST["parentId"])) { ?>
					<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<?php } ?>
				
				<?php if(isset($_POST["parentId"])) { ?>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<?php } else { ?>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<?php } ?>
			</div>
		</form>
	</div>
</div>
<script>
		
	var Unsur = {};
	
	Unsur.stopLoader = function () {
		$(".loader").remove();
	}
	
	Unsur.startLoader = function () {
		Unsur.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">LOADING DATA...</div></div></div>');
	}
	
	Unsur.saveLoader = function () {
		Unsur.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">SAVING DATA...</div></div></div>');
	}
	
	Unsur.checkRegistered = function (keg, unsur, nik) {
		Unsur.startLoader();
		
		$('.notif-nik').html("");
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/checkRegistered",
			data: {
				version: Math.random(),
				nik: nik,
				kegiatan: keg,
				unsur: unsur
			},
			dataType: 'json',
			success: function(obj){
				
				if (typeof obj && obj.length === 0) {
					// Unsur Belum Terdaftar
					$('.notif-nik').append('<div style="font-weight:bold;"><?php print ucfirst($unsur); ?> belum terdaftar</div>');
					
					$('[name="id"]').removeAttr("disabled").val('');
					
					Unsur.findByNIK(nik);
				}
				else {
					// Unsur Sudah Terdaftar
					$('.notif-nik').append('<div><?php print ucfirst($unsur); ?> sudah terdaftar, silahkan periksa kembali dan simpan</div>').removeClass("alert-danger").addClass("alert-success").show();
					
					$('[name="id"]').removeAttr("disabled").val(obj.id);
					$('[name="nama"]').removeAttr("disabled").val(obj.nama);

					$('[name="golongan"]').prop('disabled', false).val(obj.golongan).trigger('change');

					$('[name="pangkat"]').removeAttr("disabled").val(obj.pangkat);
					$('[name="tempat_lahir"]').removeAttr("disabled").val(obj.tempat_lahir);
					$('[name="tgl_lahir"]').removeAttr("disabled").datepicker('update', new Date(obj.tgl_lahir));
					$('[name="telp"]').removeAttr("disabled").val(obj.telp);
					$('[name="jenis_kelamin"]').prop('disabled', false).val(obj.jenis_kelamin).trigger('change');
					$('[name="npwp"]').removeAttr("disabled").val(obj.npwp);
					$('[name="email"]').removeAttr("disabled").val(obj.email);
					$('[name="alamat_tinggal"]').removeAttr("disabled").val(obj.alamat_tinggal);
					$('[name="unit_kerja"]').removeAttr("disabled").val(obj.unit_kerja);
					$('[name="nip"]').removeAttr("disabled").val(obj.nip);
					$('[name="jabatan"]').removeAttr("disabled").val(obj.jabatan);
					$('[name="telp_unit_kerja"]').removeAttr("disabled").val(obj.telp_unit_kerja);
					$('[name="npsn"]').removeAttr("disabled").val(obj.npsn);
					$('[name="alamat_unit_kerja"]').removeAttr("disabled").val(obj.alamat_unit_kerja);
					
					$('[name="provinsi_unit_kerja"]').prop('disabled', false).val(obj.provinsi_unit_kerja).trigger('change');
					
					$('[name="kab_unit_kerja"]').prop('disabled', false).val(obj.kab_unit_kerja).trigger('change');
					
					$('[name="nama_bank"]').prop('disabled', false).val(obj.nama_bank).trigger('change');
					$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val(obj.nama_pemilik_rekening);
					$('[name="no_rekening"]').removeAttr("disabled").val(obj.no_rekening);
				}
				
				Unsur.stopLoader();
			}
		});
	}
	
	Unsur.provinsi = function () {
		var provinsi = [];
		
		<?php
			foreach ($this->config->item("provinsi") as $provinsi => $kabupaten) {
				print "provinsi.push('".$provinsi."');";
			}
		?>
		
		return provinsi;
	}
	
	Unsur.kabupatenProvinsi = function (provinsi) {
		var items = [];
		provinsi = typeof provinsi !== 'undefined' ? provinsi : "Bali";
		var kabupaten = [];
		
		<?php
			foreach ($this->config->item("provinsi") as $provinsi => $kabupaten) {
				print "var item = [];";
				
				foreach ($kabupaten as $foo) {
					print "item.push('".$foo."');";
				}
				
				print "items.push({'".$provinsi."':item});";
			}
		?>
		
		if (items.length > 0) {
			$.each(items, function (i, provs) {
				$.each(provs, function (prov, kabs) {
					if (prov == provinsi) {
						kabupaten = kabs;
					}
				});
			});	
		}
		
		return kabupaten;
	}
	
	Unsur.findByNIK = function (nik) {
		
		$.ajax({
			type: "POST",
			url: "/admin/biodata/getDetailByNik",
			data: {
				version: Math.random(),
				nik: nik
			},
			dataType: 'json',
			success: function(obj){
				
				if (typeof obj && obj.length === 0) {
					$('[name="nama"]').removeAttr("disabled").val('');

					$('[name="golongan"]').prop('disabled', false).val('').trigger('change');

					$('[name="pangkat"]').removeAttr("disabled").val('');
					$('[name="tempat_lahir"]').removeAttr("disabled").val('');
					$('[name="tgl_lahir"]').removeAttr("disabled").val('');
					$('[name="telp"]').removeAttr("disabled").val('');
					$('[name="jenis_kelamin"]').prop('disabled', false).val('').trigger('change');
					$('[name="npwp"]').removeAttr("disabled").val('');
					$('[name="email"]').removeAttr("disabled").val('');
					$('[name="alamat_tinggal"]').removeAttr("disabled").val('');
					$('[name="unit_kerja"]').removeAttr("disabled").val('');
					$('[name="nip"]').removeAttr("disabled").val('');
					$('[name="jabatan"]').removeAttr("disabled").val('');
					$('[name="telp_unit_kerja"]').removeAttr("disabled").val('');
					$('[name="provinsi_unit_kerja"]').prop('disabled', false).val('').trigger('change');
					$('[name="kab_unit_kerja"]').prop('disabled', false).val('').trigger('change');
					$('[name="alamat_unit_kerja"]').removeAttr("disabled").val('');
					$('[name="npsn"]').removeAttr("disabled").val('');
					
					$('[name="nama_bank"]').prop('disabled', false).val('').trigger('change');
					$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val('');
					$('[name="no_rekening"]').removeAttr("disabled").val('');
					
					$('.notif-nik').append("<div>Biodata tidak ditemukan, silahkan mengisi form kemudian klik simpan.</div>").removeClass("alert-success").addClass("alert-danger").show();
				}
				else {
					$('[name="nama"]').removeAttr("disabled").val(obj.nama);
					$('[name="golongan"]').prop('disabled', false).val(obj.golongan).trigger('change');
					$('[name="pangkat"]').removeAttr("disabled").val(obj.pangkat);
					$('[name="tempat_lahir"]').removeAttr("disabled").val(obj.tempat_lahir);
					$('[name="tgl_lahir"]').removeAttr("disabled").datepicker('update', new Date(obj.tgl_lahir));
					$('[name="telp"]').removeAttr("disabled").val(obj.telp);
					$('[name="jenis_kelamin"]').prop('disabled', false).val(obj.jenis_kelamin).trigger('change');
					$('[name="npwp"]').removeAttr("disabled").val(obj.npwp);
					$('[name="email"]').removeAttr("disabled").val(obj.email);
					$('[name="alamat_tinggal"]').removeAttr("disabled").val(obj.alamat_tinggal);
					$('[name="unit_kerja"]').removeAttr("disabled").val(obj.unit_kerja);
					$('[name="nip"]').removeAttr("disabled").val(obj.nip);
					$('[name="jabatan"]').removeAttr("disabled").val(obj.jabatan);
					$('[name="telp_unit_kerja"]').removeAttr("disabled").val(obj.telp_unit_kerja);
					$('[name="alamat_unit_kerja"]').removeAttr("disabled").val(obj.alamat_unit_kerja);
					$('[name="npsn"]').removeAttr("disabled").val(obj.npsn);
					
					if (obj.kab_unit_kerja == "Badung" || obj.kab_unit_kerja == "Bangli" || obj.kab_unit_kerja == "Buleleng" || obj.kab_unit_kerja == "Gianyar" || obj.kab_unit_kerja == "Jembrana" || obj.kab_unit_kerja == "Karangasem" || obj.kab_unit_kerja == "Klungkung" || obj.kab_unit_kerja == "Tabanan" || obj.kab_unit_kerja == "Denpasar" || obj.kab_unit_kerja == "" || typeof obj.kab_unit_kerja === "undefined") {
						obj.provinsi_unit_kerja = "Bali";	
					}
					$('[name="provinsi_unit_kerja"]').prop("disabled",false).val(obj.provinsi_unit_kerja).trigger("change");
					
					$('[name="kab_unit_kerja"]').prop("disabled",false).val(obj.kab_unit_kerja).trigger("change");

					
					$('[name="nama_bank"]').prop('disabled', false).val(obj.nama_bank).trigger('change');
					$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val(obj.nama_pemilik_rekening);
					$('[name="no_rekening"]').removeAttr("disabled").val(obj.no_rekening);
					
					$('.notif-nik').append("<div>Biodata telah ditemukan, silahkan periksa kembali dan simpan.</div>").removeClass("alert-danger").addClass("alert-success").show();
				}
				
				Unsur.stopLoader();
			}
		});
	}
	
	
	
	Unsur.init = function () {
		$('[name="ktp"]').on('keyup', function(e) {
			if (e.keyCode == 17) {
				return false;
			}

			var jmlh_char = this.value.length;
			var nik = $(this).val();
			var unsur = $('[name="unsur"]').val();
			var keg = $('[name="kegiatan_id"]').val();

			if (jmlh_char == 16) { // KTP
				Unsur.checkRegistered(keg, unsur, nik);
			}
		});
		
		$('[name="golongan"]').change(function () {
			var pangkat = $(this).find(":selected").data('pangkat');
			$('[name="pangkat"]').val(pangkat);
		});

		// Provinsi
		$('[name="provinsi_unit_kerja"]').on("change", function(e) { 
			var provinsi = $(this).val();
			var kabupaten = Unsur.kabupatenProvinsi(provinsi);
			var data = [];
			data.push({id:0,text:''});

			$('[name="kab_unit_kerja"]').empty().trigger("change");

			if (kabupaten.length > 0) {
				var data = [];
				data.push({id:'',text:''});

				$.each(kabupaten, function (i, kab) {
					data.push({id:kab,text:kab});
				});
			}
			$('[name="kab_unit_kerja"]').select2({data:data});

		});
	}
	
	$(document).ready(function () {
		Unsur.init();
	});
</script>