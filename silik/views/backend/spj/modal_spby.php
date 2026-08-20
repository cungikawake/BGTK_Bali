<?php
	$disable = "";

	if (!isset($paid)) {
		$paid = 0;
	}

	if ($paid) {
		$disable = 'disabled="disabled"';
	}

	if (!isset($id)) {
		$id = 0;
	}

	if (!isset($nominal)) {
		$nominal = 0;
	}

	if (!isset($pajak)) {
		$pajak = 0;
	}

	if (!isset($transfer)) {
		$transfer = 0;
	}

	if (!isset($spj_id)) {
		$spj_id = 0;
	}

	if (!isset($spj_item_id)) {
		$spj_item_id = 0;
	}
	
	if (isset($spj["dipa"]) && empty($spj["dipa"])) {
?>
        <div class="modal-dialog modal-spby modal-dialog-centered" role="document">
        	<div class="modal-content">
        		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        				<span aria-hidden="true">&times;</span>
        			</button>
        			<h5 class="modal-title">Surat Perintah Bayar</h5>
        		</div>
        		<div class="modal-body">
				    <div class="row">
					    <div class="col-md-12">
					        <div class="alert alert-danger">Mata Anggaran Kegiatan belum didetailkan.</div>
					    </div>
					</div>
			    </div>
        	</div>
        </div>
<?php
        exit();
	}
?>

<div class="modal-dialog modal-spby modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Surat Perintah Bayar</h5>
		</div>
		<form action="/admin/spj/save_spby" method="post" class="form-submit">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" class="spby_id" <?php print $disable; ?> name="spby_id" value="<?php print $id; ?>" />
						<input type="hidden" name="spj_id" <?php print $disable; ?> value="<?php print $spj["id"]; ?>" />
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-sm">
									<label>Penerima</label>
									<select id="select_spby" class="select2 form-control" name="spj_item_id" data-selected="<?php print (isset($spj_item_id)) ? $spj_item_id : "0"; ?>" <?php print $disable; ?>>
										<option value="0"> </option>
										<?php
											if (isset($spby_penerima) && !empty($spby_penerima) ) {
												foreach ($spby_penerima as $pen) {
													$selected = "";

													if ($pen["id"] == $spj_item_id) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$pen["id"].'" data-nip="'.$pen["nip"].'" data-nama="'.$pen["nama"].'" '.$selected.'>'.$pen["nama"].'</option>';
												}
											}
										?>
									</select>

									<input type="hidden" class="nama-penerima-spby" name="penerima" <?php print $disable; ?> value="<?php print (isset($penerima)) ? $penerima : ""; ?>" />

									<input type="hidden" class="nip-penerima-spby" name="nip_penerima" <?php print $disable; ?> value="<?php print (isset($nip_penerima)) ? $nip_penerima : ""; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-sm">
									<label>&nbsp;&nbsp;</label>
									<div class="checkbox checkbox-primary d-inline" style="padding: 0; margin: 0;">
										<input type="hidden" name="penerima_dkk" <?php print $disable; ?> value="0" />

										<?php
											$penerima_dkk_selected = "";
											if (isset($penerima_dkk) && $penerima_dkk == "1") {
												$penerima_dkk_selected = 'checked="checked"';
											}
										?>

										<input type="checkbox" name="penerima_dkk" id="checkbox-penerima_spby_dkk" <?php print $penerima_dkk_selected; ?> value="1" <?php print $disable; ?> />
										<label for="checkbox-penerima_spby_dkk" class="cr">&nbsp;&nbsp;&nbsp; Penerima dkk?</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group form-group-sm">
							<label>Uraian</label>
							<textarea class="form-control" rows="5" name="deskripsi" <?php print $disable; ?>><?php print (isset($deskripsi)) ? $deskripsi : ""; ?></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-sm">
									<label>Kab/Kota</label>
									<?php
										if (!isset($kab_spby) || empty($kab_spby)) {
											$kab_spby = $_ENV["DEFAULT_KABUPATEN"];
										}
									?>
									<select name="kab_spby" class="form-control select2" <?php print $disable; ?>>
										<?php
											$provinsi = $_ENV["DEFAULT_PROVINSI"];
											$areas = $this->config->item("provinsi");

											if ( isset($areas[$provinsi]) && !empty($areas[$provinsi]) ) {
												foreach ($areas[$provinsi] as $area) {
													$selected = "";

													if ($area == $kab_spby) {
														$selected = 'selected="selected"';
													}

													print '<option value="'.$area.'" '.$selected.'>'.$area.'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-sm">
									<label>Tanggal</label>
									<?php
										if (!isset($tgl_spby) || empty($tgl_spby)) {
											$tgl_spby = date("d-m-Y");
										}

										$tgl_spby = date("d/m/Y", strtotime($tgl_spby));
									?>
									<input type="text" name="tgl_spby" class="tgl-spby form-control datepicker" value="<?php print $tgl_spby; ?>" autocomplete="off" <?php print $disable; ?> />
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-7">
										<div class="form-group form-group-sm">
											<label>Kegiatan.Output</label>
											<?php
												$dipaProgram = $spj["dipa"]["program"];
												$dipaKegiatan = $spj["dipa"]["kegiatan"];
												$dipaKro = $spj["dipa"]["kro"];
												$dipaRo = $spj["dipa"]["ro"];
												$dipaKomponen = $spj["dipa"]["komponen"];
												$dipaSubKomponen = $spj["dipa"]["sub_komponen"];
											
												if (isset($dipa_program) && !empty($dipa_program)) {
													$dipaProgram = $dipa_program;
													$dipaKegiatan = $dipa_kegiatan;
													$dipaKro = $dipa_kro;
													$dipaRo = $dipa_ro;
													$dipaKomponen = $dipa_komponen;
													$dipaSubKomponen = $dipa_sub_komponen;
												}
											
												$kegiatanOutput = $dipaKegiatan.".".$dipaKro.".".$dipaRo.".".$dipaKomponen.".".$dipaSubKomponen;
											?>
											
											<input type="text" class="form-control kegiatan-output-spby" value="<?php print $kegiatanOutput; ?>" readonly />
											
											<input type="hidden" name="dipa_program" value="<?php print $dipaProgram; ?>" />
											<input type="hidden" name="dipa_kegiatan" value="<?php print $dipaKegiatan; ?>" />
											<input type="hidden" name="dipa_kro" value="<?php print $dipaKro; ?>" />
											<input type="hidden" name="dipa_ro" value="<?php print $dipaRo; ?>" />
											<input type="hidden" name="dipa_komponen" value="<?php print $dipaKomponen; ?>" />
											<input type="hidden" name="dipa_sub_komponen" value="<?php print $dipaSubKomponen; ?>" />
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group form-group-sm">
											<?php
												$akuns = array(
													$spj["dipa"]["akun_transport"] => $spj["dipa"]["akun_transport"],
													$spj["dipa"]["akun_honor"] => $spj["dipa"]["akun_honor"]
												);
											?>
											<label>Akun</label>
											<select class="select2 form-control spby_akun" name="dipa_akun" <?php print $disable; ?>>
												<?php
													foreach ($akuns as $ak) {
														$selected = '';
														
														if ($dipa_akun == $ak) {
															$selected = 'selected="selected"';
														}
														
														if (empty($ak)) {
															continue;
														}
												?>
													<option value="<?php print $ak; ?>" <?php print $selected; ?></optio><?php print $ak; ?></option>
												<?php
													}
												?>
												
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-group-sm">
											<label>Jumlah Bruto</label>
											<input type="text" class="form-control autoNumeric jumlah-spby" name="nominal" value="<?php print $nominal; ?>" required readonly />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-group-sm">
											<label>Jumlah Pajak</label>
											<input type="text" class="form-control autoNumeric jumlah-pajak" name="pajak" value="<?php print $pajak; ?>" required readonly />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-group-sm">
											<label>Jumlah Netto</label>
											<input type="text" class="form-control autoNumeric jumlah-transfer" name="transfer" value="<?php print $transfer; ?>" required readonly />
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="spby-items">

						</div>
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<?php
					if (!$paid) {
				?>
						<button type="submit" class="btn btn-info mb-0" data-spj="<?php print $spj_id; ?>">Simpan</button>
				<?php
					}
				?>
				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function () {
		
		function getItemSpbyByRequest () {
			var akun = $('.spby_akun').val();
			var spjId = $('.spj_id').val();
			var spbyId = $('.spby_id').val();
			var tglSpby = $('.tgl-spby').val();
			
			Spj_Keuangan.getItemSPBy(spjId, spbyId, akun, tglSpby);
		}
		
		/*if ($('#select_spby').length) {
			var spjId = $('.spj_id').val();
			var element = $('#select_spby');

			var optionUrl = "/admin/spj/typehead/"+spjId+"/";
			var selectedUrl = "/admin/spj/selected_spby/";

			Spj_Keuangan.getPenerimaSPBy(element, optionUrl, selectedUrl);
		}*/

		$('#select_spby').on("change", function(e) {
			var penerima = $(this).find(":selected").data("nama");
			var nipPenerima = $(this).find(":selected").data("nip");

			$(".nama-penerima-spby").val(penerima);
			$(".nip-penerima-spby").val(nipPenerima);
		});
		
		if ($('.spby_id').length) {
			getItemSpbyByRequest();
		}
		
		$(document).on("change", '.tgl-spby', function () {
			getItemSpbyByRequest();
		});
	});
</script>