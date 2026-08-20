<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">SPJ Peserta</h5>
		</div>
		
        <form action="/admin/spj/save_manual_peserta" method="post" class="form-submit" autocomplete="off">
        	<input name="id" type="hidden" value="<?php print $id; ?>" />
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="<?php print $nama; ?>" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Transport Asal</label>
                            <input type="text" class="form-control" value="<?php print $transport_asal; ?>" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Transport Tujuan</label>
                            <input type="text" class="form-control" value="<?php print $transport_tujuan; ?>" readonly />
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="javascript:;" aria-controls="modal-edit-kuitansi">Kuitansi</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="javascript:;" aria-controls="modal-edit-transport">Transport</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="javascript:;" aria-controls="modal-edit-uang-harian">Uang Harian</a>
							</li>
						</ul>
						
						<div class="tab-content">
							<div class="tab-pane active show" id="modal-edit-kuitansi">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Deskripsi Kuitansi Transport</label>
											<textarea class="form-control" name="deskripsi_kuitansi" rows="4"><?php print $deskripsi_kuitansi; ?></textarea>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Kab/Kota Kuitansi</label>
											<select class="form-control select2" name="kab_kuitansi">
												<?php
													$areas = $this->config->item("transport_area");

													if (!empty($areas)) {
														foreach ($areas as $area) {
															$selected = "";
															if ($area == $kab_kuitansi) {
																$selected = 'selected="selected"';
															}
												?>
														<option value="<?php print $area; ?>" <?php print $selected; ?>><?php print $area; ?></option>
												<?php
														}									
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Tgl Kuitansi</label>
											<input type="text" class="form-control datepicker" name="tgl_kuitansi" value="<?php print date("d/m/Y", strtotime($tgl_kuitansi)); ?>" />
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="modal-edit-transport">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Transport</label>
											<input type="text" class="form-control autoNumeric" name="transport" value="<?php print $transport; ?>" />
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan Transport</label>
											<textarea class="form-control" name="keterangan_transport" rows="2"><?php print $keterangan_transport; ?></textarea>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Transport Lainnya</label>
											<input type="text" class="form-control autoNumeric" name="transport_lainnya" value="<?php print $transport_lainnya; ?>" />
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan Transport Lainnya</label>
											<textarea class="form-control" name="keterangan_transport_lainnya" rows="2"><?php print $keterangan_transport_lainnya; ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="modal-edit-uang-harian">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Uang Harian</label>
											<input type="text" class="form-control autoNumeric" name="uang_harian" value="<?php print $uang_harian; ?>" />
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Keterangan Uang Harian</label>
											<textarea class="form-control" name="keterangan_uang_harian" rows="2"><?php print $keterangan_uang_harian; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
		</form>
    </div>
</div>
<script type="text/javascript">
	$('.accor-btn').click(function () {
		var accorItem = $(this).closest('.accor-item');
		var accor = $(this).closest('.accor');
		
		accor.find('.accor-content').slideUp();
		
		
		if (accorItem.find('.accor-content').css('display') == "block") {
			accorItem.find('.accor-content').slideUp();
		}
		else {
			accorItem.find('.accor-content').slideDown();
		}
	});
</script>