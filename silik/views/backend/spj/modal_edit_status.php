<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Ubah Status Penugasan</h5>
		</div>
		
        <form action="/admin/spj/save_status_penugasan" method="post" class="form-submit">
        	<input name="id" type="hidden" value="<?php print $id; ?>" />
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Status</label>
							<?php
								$status = array(
									"0" => "Belum Buat Laporan",
									"1" => "Draft Laporan",
									"2" => "Proses Persetujuan Laporan",
									"3" => "Laporan Disetujui & Segera Kumpul Laporan",
									"4" => "Laporan Ditolak",
									"5" => "Laporan Dikumpul & Menunggu Pembayaran",
									"6" => "Telah Dibayarkan"
								);
							?>
							
							<select class="select2 form-control" name="status_penugasan_item">
								<?php
									foreach ($status as $stl => $st) {
										$selected = "";
										
										if ($penugasanItem["status"] == $stl) {
											$selected = 'selected="selected"';
										}
										
										print '<option value="'.$stl.'" '.$selected.'>'.$stl.'. '.$st.'</option>';
									}
								?>
							</select>
                            
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