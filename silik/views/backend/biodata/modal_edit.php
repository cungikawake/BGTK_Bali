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
							<label>NPWP</label>
							<input type="text" name="npwp" <?php print $disable; ?> class="form-control" value="<?php print isset($npwp) ? $npwp : ""; ?>" />
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
									<div class="custom-control custom-checkbox">
										<input type="hidden" name="pegawai_balai" value="0" />
										<input type="checkbox" <?php print $disable; ?> class="custom-control-input" id="pegawai_balai" name="pegawai_balai" value="1" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "checked='checked'" : ""; ?> />
										<label class="custom-control-label" for="pegawai_balai">Pegawai Balai</label>
									</div>
								</div>
								<div class="form-group">
									<label>Unit Kerja/Sekolah</label>
									<input type="text" name="unit_kerja" <?php print $disable; ?> class="form-control" value="<?php print isset($unit_kerja) ? $unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
								</div>
								<div class="form-group">
									<label>Telp Unit Kerja/Sekolah</label>
									<input type="text" name="telp_unit_kerja" <?php print $disable; ?> class="form-control" value="<?php print isset($telp_unit_kerja) ? $telp_unit_kerja : ""; ?>" <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?> />
								</div>

								<div class="row">
							  		<div class="col-md-6">
										<div class="form-group">
											<label>Provinsi Unit Kerja/Sekolah</label>
											<select name="provinsi_unit_kerja" <?php print $disable; ?> class="form-control select2" required <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?>>
												<option value="">&nbsp;</option>
												<?php
													if (!isset($provinsi_unit_kerja) || empty($provinsi_unit_kerja)) {
														$provinsi_unit_kerja = $_ENV['DEFAULT_PROVINSI'];
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
											<select name="kab_unit_kerja" <?php print $disable; ?> class="form-control select2" required <?php print isset($pegawai_balai) && $pegawai_balai == "1" ? "readonly='readonly'" : ""; ?>>
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
							<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="hidden" name="valid_rekening" value="0" />
										<input type="checkbox" <?php print $disable; ?> class="custom-control-input" id="valid_rekening" name="valid_rekening" value="1" <?php print isset($valid_rekening) && $valid_rekening == "1" ? "checked='checked'" : ""; ?> />
										<label class="custom-control-label" for="valid_rekening">Valid Rekening</label>
									</div>
								</div>
						  </div>
						</div>
				  	</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>
<script>
	$('[name="golongan"]').change(function () {
		var pangkat = $(this).find(":selected").data('pangkat');
		$('[name="pangkat"]').val(pangkat);
	});
	
	$('#pegawai_balai').change(function () {
		if ($(this).is(':checked')) {
			$('[name="unit_kerja"]').val("<?php print $satker["upt"]; ?>").attr("readonly","readonly");
			$('[name="telp_unit_kerja"]').val("<?php print $satker["telepon"]; ?>").attr("readonly","readonly");
			$('[name="alamat_unit_kerja"]').val("<?php print $satker["alamat"]; ?>").attr("readonly","readonly");
			$('[name="provinsi_unit_kerja"]').val("<?php print $_ENV['DEFAULT_PROVINSI']; ?>").trigger('change');
			$('[name="kab_unit_kerja"]').val("<?php print $_ENV['DEFAULT_KABUPATEN']; ?>").trigger('change');
		}
		else {
			$('[name="unit_kerja"]').val("").removeAttr("readonly");
			$('[name="telp_unit_kerja"]').val("").removeAttr("readonly");
			$('[name="alamat_unit_kerja"]').val("").removeAttr("readonly");
			$('[name="provinsi_unit_kerja"]').val("<?php print $_ENV['DEFAULT_PROVINSI']; ?>").trigger('change');
			$('[name="kab_unit_kerja"]').val("<?php print $_ENV['DEFAULT_KABUPATEN']; ?>").trigger('change');
		}
	});
	
	// Provinsi
	$('[name="provinsi_unit_kerja"]').on("change", function(e) { 
			var provinsi = $(this).val();
			var kabupaten = Biodata.kabupatenProvinsi(provinsi);
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
	
	
	var Biodata = {};
	
	Biodata.stopLoader = function () {
		$(".loader").remove();
	}
	
	Biodata.startLoader = function () {
		Biodata.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">LOADING DATA...</div></div></div>');
	}
	
	Biodata.saveLoader = function () {
		Biodata.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">SAVING DATA...</div></div></div>');
	}
	
	Biodata.kabupaten = function () {
		var kab = [];
		
		<?php
			foreach ($this->config->item("transport_area") as $areaId => $areaName) {
				if ($areaId != "Lainnya") {
					print "kab.push('".$areaId."');";
				}
			}
		?>
		
		return kab;
	}

	Biodata.kabupatenProvinsi = function (provinsi) {
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
	
	Biodata.findByNIK = function (nik) {
		
		Biodata.startLoader();
		
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
					$('[name="kab_unit_kerja"]').prop('disabled', false).val('').trigger('change');
					$('[name="alamat_unit_kerja"]').removeAttr("disabled").val('');
					$('#pegawai_balai').removeAttr("disabled").prop('checked', false);
					
					$('.kab_unit_kerja_lainnya').addClass("hidden");
					$('[name="kab_unit_kerja_lainnya"]').removeAttr("disabled").val('');

					$('[name="nama_bank"]').prop('disabled', false).val('').trigger('change');
					$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val('');
					$('[name="no_rekening"]').removeAttr("disabled").val('');
					
					$('.notif-nik').html("Biodata tidak ditemukan, silahkan mengisi form untuk menambah data baru.").removeClass("alert-success").addClass("alert-danger").show();
				}
				else {
					$('[name="id"]').val(obj.id);
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
					$('#pegawai_balai').removeAttr("disabled");
					$('[name="kab_unit_kerja"]').prop('disabled', false).val(obj.kab_unit_kerja).trigger('change');
					$('[name="alamat_unit_kerja"]').removeAttr("disabled").val(obj.alamat_unit_kerja);
					
					var kabupaten = Biodata.kabupaten();
				
					if(typeof obj.kab_unit_kerja === "undefined" || obj.kab_unit_kerja == "" || $.inArray(obj.kab_unit_kerja, kabupaten) !== -1) {
						$('.kab_unit_kerja_lainnya').addClass("hidden");
						$('[name="kab_unit_kerja_lainnya"]').removeAttr("disabled").val("");
					}
					else {
						$('[name="kab_unit_kerja"]').val("Lainnya").trigger("change");
						$('.kab_unit_kerja_lainnya').removeClass("hidden");
						$('[name="kab_unit_kerja_lainnya"]').removeAttr("disabled").val(obj.kab_unit_kerja);
					}
					
					if (obj.pegawai_balai) {
						$('#pegawai_balai').prop('checked', true);
					}
					else {
						$('#pegawai_balai').prop('checked', false);
					}

					$('[name="nama_bank"]').prop('disabled', false).val(obj.nama_bank).trigger('change');
					$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val(obj.nama_pemilik_rekening);
					$('[name="no_rekening"]').removeAttr("disabled").val(obj.no_rekening);
					
					$('.notif-nik').html("Biodata telah ditemukan, silahkan mengisi form untuk mengubah data.").removeClass("alert-danger").addClass("alert-success").show();
				}
				
				Biodata.stopLoader();
			}
		});
	}
	
	$('[name="ktp"]').on('keyup', function() {
		var jmlh_char = this.value.length;
		var nik = $(this).val();
		
		if (jmlh_char == 16) { // KTP
			Biodata.findByNIK(nik);
		}
	});
</script>